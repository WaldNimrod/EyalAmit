#!/usr/bin/env python3
"""
שכבת תוכן ויזואלי: OpenCLIP zero-shot על רשימת פרומפטים (אנגלית) + מיפוי לנושאים בעברית והצעות התאמה לפרקים באתר.

קלט: index.json (גרסה 2) + תיקיית mirror/
פלט: index.v3.json (מוסיף לכל רשומה semantic_content + מרחיב search)
"""
from __future__ import annotations

import argparse
import json
import sys
from datetime import datetime, timezone
from pathlib import Path

HERE = Path(__file__).resolve().parent

# --- פרומפטים לאתר אייל עמית (אנגלית — כך CLIP עובד הכי טוב) ---
# כל פריט: (prompt_en, topics_he[], site_hints[])
# site_hints: מזהים לוגיים לצוות (לא URL מלא) — לסינון ולשילוב בעמודים
LABEL_DEFS: list[tuple[str, list[str], list[str]]] = [
    ("a photo of a book or novel cover", ["ספרים", "כריכה"], ["muzeh", "books"]),
    ("a person reading a book", ["ספרים", "קריאה"], ["muzeh", "books"]),
    ("a musical performance on a stage", ["הופעה", "במה"], ["lectures", "events"]),
    ("a concert or live music event", ["מוזיקה", "הופעה"], ["events", "music"]),
    ("a didgeridoo or long wooden wind instrument", ["דיג'רידו", "כלי נשיפה"], ["didgeridoo", "services"]),
    ("a person playing a wind instrument", ["נגינה", "כלי נגינה"], ["music", "services"]),
    ("a music studio or recording room", ["סטודיו", "הקלטה"], ["studio", "services"]),
    ("a workshop or classroom teaching", ["סדנה", "לימוד"], ["workshops", "courses"]),
    ("a therapy or healing session", ["טיפול", "ריפוי"], ["therapy", "services"]),
    ("a portrait photo of a person", ["פורטרט", "אנשים"], ["about", "bio"]),
    ("a group of people smiling", ["אנשים", "קהילה"], ["about", "testimonials"]),
    ("a landscape with mountains or hills", ["טבע", "הרים"], ["travel", "atmosphere"]),
    ("a beach sea or ocean view", ["ים", "חוף"], ["travel", "atmosphere"]),
    ("a city street or urban scene", ["עיר", "רחוב"], ["travel", "atmosphere"]),
    ("a forest jungle or trees", ["יער", "טבע"], ["travel", "atmosphere"]),
    ("a desert or arid landscape", ["מדבר", "נוף"], ["travel", "atmosphere"]),
    ("a temple or spiritual place", ["רוחני", "מקדש"], ["travel", "atmosphere"]),
    ("a family or children", ["משפחה", "ילדים"], ["about", "personal"]),
    ("a wedding or celebration", ["חגיגה", "אירוע"], ["events"]),
    ("food or a restaurant meal", ["אוכל"], ["atmosphere"]),
    ("a screenshot of a computer or phone screen", ["מסך", "צילום מסך"], ["legacy", "ui"]),
    ("a document or printed text close-up", ["מסמך", "טקסט"], ["books", "legal"]),
    ("a close-up of hands crafting or working", ["ידיים", "מלאכה"], ["workshops", "craft"]),
    ("a yoga or meditation pose", ["יוגה", "מדיטציה"], ["therapy", "wellness"]),
    ("a crowd or audience from behind", ["קהל", "אירוע"], ["events", "lectures"]),
    ("a night scene with artificial lighting", ["לילה", "תאורה"], ["atmosphere"]),
    ("a macro or extreme close-up of an object", ["מקרו", "פרט"], ["product", "detail"]),
    ("a sports or outdoor activity", ["ספורט", "פעילות"], ["atmosphere"]),
    ("a vehicle car bus or train travel", ["נסיעה", "תחבורה"], ["travel"]),
    ("an animal in nature", ["חיה", "טבע"], ["travel", "atmosphere"]),
    ("a professional headshot neutral background", ["ראש", "תדמית"], ["about", "press"]),
    ("waterfall or river in nature", ["מים", "נחל"], ["travel", "atmosphere"]),
    ("a museum or gallery interior", ["מוזיאון", "תערוכה"], ["culture"]),
    ("a painting drawing or visual art", ["אמנות", "ציור"], ["culture"]),
]


def pick_device():
    try:
        import torch

        if torch.backends.mps.is_available():
            return "mps"
        if torch.cuda.is_available():
            return "cuda"
        return "cpu"
    except ImportError:
        print("Install: pip install -r requirements-semantic.txt", file=sys.stderr)
        sys.exit(1)


def load_clip(device: str):
    import open_clip
    import torch

    model_name = "ViT-B-32"
    pretrained = "laion2b_s34b_b79k"
    model, _, preprocess = open_clip.create_model_and_transforms(model_name, pretrained=pretrained)
    model = model.to(device).eval()
    tokenizer = open_clip.get_tokenizer(model_name)
    return model, preprocess, tokenizer, model_name, pretrained


def encode_labels(tokenizer, device, model, prompts: list[str]):
    import torch

    text = tokenizer(prompts).to(device)
    with torch.no_grad():
        tf = model.encode_text(text)
        tf = tf / tf.norm(dim=-1, keepdim=True)
    return tf


def score_image_batch(preprocess, model, device, text_features, paths: list[Path]):
    """Returns list of list of (label_idx, prob) top-8 per image."""
    import torch
    from PIL import Image

    batch_tensors = []
    valid_idx = []
    for i, p in enumerate(paths):
        try:
            im = Image.open(p).convert("RGB")
            batch_tensors.append(preprocess(im))
            valid_idx.append(i)
        except Exception:
            batch_tensors.append(None)

    out_probs: list[list[tuple[int, float]]] = [[] for _ in paths]
    if not any(t is not None for t in batch_tensors):
        return out_probs

    stacked = []
    map_back = []
    for i, t in enumerate(batch_tensors):
        if t is None:
            continue
        stacked.append(t)
        map_back.append(i)
    if not stacked:
        return out_probs

    images = torch.stack(stacked).to(device)
    with torch.no_grad():
        imf = model.encode_image(images)
        imf = imf / imf.norm(dim=-1, keepdim=True)
        logits = 100.0 * imf @ text_features.T
        probs = logits.softmax(dim=-1)

    for row, orig_i in enumerate(map_back):
        p = probs[row].tolist()
        ranked = sorted(enumerate(p), key=lambda x: -x[1])[:10]
        out_probs[orig_i] = [(int(j), float(s)) for j, s in ranked]
    return out_probs


def build_semantic_entry(
    top: list[tuple[int, float]],
    defs: list[tuple[str, list[str], list[str]]],
    threshold: float = 0.02,
) -> dict:
    topics: set[str] = set()
    sites: set[str] = set()
    top_k = []
    for idx, score in top[:8]:
        if score < threshold:
            continue
        prompt_en, the, sh = defs[idx]
        topics.update(the)
        sites.update(sh)
        top_k.append(
            {
                "prompt_en": prompt_en,
                "score": round(score, 5),
                "topics_he": list(the),
                "site_hooks": list(sh),
            }
        )
    return {
        "engine": "open_clip_zero_shot",
        "label_set": "eyalamit-topics-v1",
        "top_labels": top_k,
        "topics_he_union": sorted(topics),
        "site_hooks_union": sorted(sites),
    }


def merge_search(entry: dict, semantic: dict) -> None:
    kw = entry.setdefault("search", {}).setdefault("keywords", [])
    for t in semantic.get("topics_he_union", []):
        if t not in kw:
            kw.append(t)
    for s in semantic.get("site_hooks_union", []):
        x = f"site:{s}"
        if x not in kw:
            kw.append(x)
    for lab in semantic.get("top_labels", [])[:5]:
        kw.append(lab["prompt_en"][:80])
    entry["search_blob"] = (
        entry.get("search_blob", "")
        + "\n"
        + json.dumps(semantic, ensure_ascii=False)
    ).lower()


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--index", type=Path, default=HERE / "index.json")
    ap.add_argument("--mirror", type=Path, default=HERE / "mirror")
    ap.add_argument("--out", type=Path, default=HERE / "index.v3.json")
    ap.add_argument("--batch", type=int, default=8)
    ap.add_argument("--threshold", type=float, default=0.015)
    args = ap.parse_args()

    doc = json.loads(args.index.read_text(encoding="utf-8"))
    device = pick_device()
    model, preprocess, tokenizer, mn, pt = load_clip(device)
    prompts = [d[0] for d in LABEL_DEFS]
    text_f = encode_labels(tokenizer, device, model, prompts)

    entries = doc["entries"]
    paths = [args.mirror / e["mirror_relative"] for e in entries]

    all_ranked: list[list[tuple[int, float]]] = []
    for i in range(0, len(paths), args.batch):
        batch_paths = paths[i : i + args.batch]
        ranked_batch = score_image_batch(preprocess, model, device, text_f, batch_paths)
        # score_image_batch returns per-path list aligned to batch_paths length
        all_ranked.extend(ranked_batch)

    meta = doc.setdefault("meta", {})
    meta["version"] = 3
    meta["semantic_layer"] = {
        "added_utc": datetime.now(timezone.utc).isoformat(),
        "torch_device": device,
        "clip_model": mn,
        "clip_pretrained": pt,
        "prompt_count": len(prompts),
        "description_he": "ניתוח תוכן ויזואלי (CLIP zero-shot) — לא מחליף מודל שפה לתיאור חופשי בעברית; משלים פיקסלים.",
    }

    for e, ranked in zip(entries, all_ranked):
        sem = build_semantic_entry(ranked, LABEL_DEFS, threshold=args.threshold)
        e["semantic_content"] = sem
        merge_search(e, sem)

    # אינדקס מילות מפתח מחודש (כולל נושאים בעברית ו-site:)
    keyword_index: dict[str, list[str]] = {}
    for e in entries:
        eid = e["entry_id"]
        for kw in e.get("search", {}).get("keywords", []):
            ks = str(kw)
            if len(ks) < 2 or len(ks) > 120:
                continue
            keyword_index.setdefault(ks, []).append(eid)
    meta.setdefault("search", {})["keyword_index"] = keyword_index
    meta["search"]["hint_he"] = (
        meta["search"].get("hint_he", "")
        + " | סנן לפי topics_he_union או site:muzeh ב-search.keywords."
    )

    args.out.write_text(json.dumps(doc, ensure_ascii=False, indent=2), encoding="utf-8")
    print(f"Wrote {args.out} with semantic_content on {len(entries)} entries (device={device})")


if __name__ == "__main__":
    main()
