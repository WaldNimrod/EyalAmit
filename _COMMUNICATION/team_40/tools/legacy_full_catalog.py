#!/usr/bin/env python3
"""
קטלוג מלא: סריקת uploads בלגסי, סינון נגזרות WP, אינדקס טכני, CLIP, ציון רלוונטיות,
העתקה ל-team_40 עם שמות EA-*, catalog.json, catalog.all.json, gallery.html (נוצר בסקריפט נפרד או בסוף).
"""
from __future__ import annotations

import argparse
import hashlib
import importlib.util
import json
import os
import re
import sys
from datetime import datetime, timezone
from pathlib import Path
from typing import Any

# --- טעינת מודול CLIP קיים ---
HERE = Path(__file__).resolve().parent
TEAM40 = HERE.parent
SEM_PATH = TEAM40 / "legacy-media-index-50-2026-04-11" / "semantic_enrich_clip.py"

_spec = importlib.util.spec_from_file_location("semantic_enrich_clip", SEM_PATH)
if _spec is None or _spec.loader is None:
    raise RuntimeError(f"Cannot load {SEM_PATH}")
_sem = importlib.util.module_from_spec(_spec)
_spec.loader.exec_module(_sem)
LABEL_DEFS = _sem.LABEL_DEFS
load_clip = _sem.load_clip
encode_labels = _sem.encode_labels
build_semantic_entry = _sem.build_semantic_entry

from site_tree_tags import (
    SiteTreeContext,
    default_site_tree_path,
    render_gallery_html,
    tags_for_entry,
)

from PIL import Image, ExifTags
import imagehash
import numpy as np

IMAGE_EXT = {".jpg", ".jpeg", ".png", ".gif", ".webp"}
# נגזרות WordPress בגודל ביניים
WP_THUMB_RE = re.compile(r"-\d+x\d+\.(jpe?g|png|gif|webp)$", re.IGNORECASE)

# אינדקסים ב-LABEL_DEFS לפרומפטים "נמוכי עדיפות" לתוכן ציבורי
def _negative_indices() -> set[int]:
    neg: set[int] = set()
    for i, (prompt, _, _) in enumerate(LABEL_DEFS):
        pl = prompt.lower()
        if "screenshot" in pl or "document or printed" in pl:
            neg.add(i)
    return neg


NEGATIVE_INDICES = _negative_indices()


def is_wp_intermediate(name: str) -> bool:
    return bool(WP_THUMB_RE.search(name))


def walk_original_images(root: Path, min_bytes: int) -> list[Path]:
    out: list[Path] = []
    for dirpath, _, files in os.walk(root):
        for f in files:
            suf = Path(f).suffix.lower()
            if suf not in IMAGE_EXT:
                continue
            if is_wp_intermediate(f):
                continue
            fp = Path(dirpath) / f
            try:
                if fp.stat().st_size >= min_bytes:
                    out.append(fp)
            except OSError:
                pass
    return sorted(out)


def rel_from_legacy(path: Path, legacy_root: Path) -> str:
    return path.relative_to(legacy_root).as_posix()


def technical_one(path: Path) -> dict[str, Any]:
    data = path.read_bytes()
    sha = hashlib.sha256(data).hexdigest()
    entry_id = sha[:16]
    out: dict[str, Any] = {
        "entry_id": entry_id,
        "sha256": sha,
        "bytes": len(data),
    }
    try:
        im = Image.open(path)
        im.load()
        w, h = im.size
        fmt = im.format or ""
        ph = str(imagehash.phash(im))
        exif_d: dict[str, str] = {}
        try:
            ex = im.getexif()
            if ex:
                for k, v in ex.items():
                    tag = ExifTags.TAGS.get(k, str(k))
                    if tag in ("DateTime", "DateTimeOriginal") and "datetime" not in exif_d:
                        exif_d["datetime"] = str(v)[:32]
                    if tag == "Make":
                        exif_d["camera_make"] = str(v).strip()
                    if tag == "Model":
                        exif_d["camera_model"] = str(v).strip()
        except Exception:
            pass
        if exif_d.get("camera_make") or exif_d.get("camera_model"):
            exif_d["camera"] = (
                exif_d.get("camera_make", "") + " " + exif_d.get("camera_model", "")
            ).strip()
        out.update(
            {
                "width": w,
                "height": h,
                "aspect_ratio": round(w / h, 4) if h else None,
                "format": fmt,
                "phash": ph,
                "exif": exif_d,
                "decode": "ok",
            }
        )
    except Exception as e:
        out.update(
            {
                "width": 0,
                "height": 0,
                "decode": f"error: {e}",
            }
        )
    return out


def score_image_batch_probs(preprocess, model, device, text_features, paths: list[Path]):
    """מחזיר לכל תמונה: רשימת הסתברויות מלאה (או None) + top ranked."""
    import torch
    from PIL import Image as PILImage

    batch_tensors: list[Any] = []
    for p in paths:
        try:
            im = PILImage.open(p).convert("RGB")
            batch_tensors.append(preprocess(im))
        except Exception:
            batch_tensors.append(None)

    n_labels = text_features.shape[0]
    results: list[dict[str, Any]] = []
    stacked = []
    map_back: list[int] = []
    for i, t in enumerate(batch_tensors):
        if t is None:
            results.append({"probs": None, "ranked": []})
        else:
            stacked.append(t)
            map_back.append(i)
            results.append({})  # placeholder

    if not stacked:
        return [{"probs": None, "ranked": []} for _ in paths]

    images = torch.stack(stacked).to(device)
    with torch.no_grad():
        imf = model.encode_image(images)
        imf = imf / imf.norm(dim=-1, keepdim=True)
        logits = 100.0 * imf @ text_features.T
        probs = logits.softmax(dim=-1)

    for row, orig_i in enumerate(map_back):
        pvec = probs[row].tolist()
        ranked = sorted(enumerate(pvec), key=lambda x: -x[1])[:12]
        results[orig_i] = {
            "probs": pvec,
            "ranked": [(int(j), float(s)) for j, s in ranked],
        }
    return results


def relevance_from_probs(
    probs: list[float] | None,
    width: int,
    height: int,
    file_bytes: int,
    min_edge: int,
    min_bytes_soft: int,
) -> float:
    if not probs or width <= 0:
        return 0.0
    pos_max = max((probs[i] for i in range(len(probs)) if i not in NEGATIVE_INDICES), default=0.0)
    neg_mass = sum(probs[i] for i in NEGATIVE_INDICES if i < len(probs))
    # קנס אם "מסך/מסמך" דומיננטיים
    r = pos_max * (1.0 - 0.65 * min(1.0, neg_mass / 0.45))
    mi = min(width, height)
    if mi < min_edge:
        r *= 0.35 + 0.65 * (mi / max(min_edge, 1))
    if file_bytes < min_bytes_soft:
        r *= 0.85
    return max(0.0, min(1.0, r))


def short_title(basename: str, public_id: str) -> str:
    stem = Path(basename).stem
    # אנגלית/מספרים בלבד לתצוגה קצרה
    safe = re.sub(r"[^a-zA-Z0-9._-]+", "-", stem)[:40].strip("-")
    if len(safe) < 3:
        return f"img-{public_id}"
    return safe


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument(
        "--legacy",
        type=Path,
        default=Path("/Users/nimrod/Documents/Eyal Amit/eyalamit.co.il-legacy/wp-content/uploads"),
    )
    ap.add_argument(
        "--out-dir",
        type=Path,
        default=None,
        help="תיקיית פלט; ברירת מחדל team_40/ea-legacy-curated-YYYY-MM-DD",
    )
    ap.add_argument("--min-bytes", type=int, default=2048)
    ap.add_argument("--min-edge", type=int, default=200, help="מינימום צלע קצרה לפיקסלים")
    ap.add_argument("--min-bytes-soft", type=int, default=8000)
    ap.add_argument("--threshold", type=float, default=0.065, help="relevance_score מינימלי לכלול באתר")
    ap.add_argument("--batch", type=int, default=12)
    ap.add_argument("--dry-run", action="store_true", help="לא מעתיק קבצים ל-media/")
    ap.add_argument("--max-files", type=int, default=0, help="0 = ללא הגבלה (לבדיקות)")
    ap.add_argument(
        "--site-tree",
        type=Path,
        default=None,
        help="נתיב ל־site-tree.json (ברירת מחדל: hub/data/site-tree.json במאגר)",
    )
    args = ap.parse_args()

    out_dir = args.out_dir
    if out_dir is None:
        out_dir = TEAM40 / f"ea-legacy-curated-{datetime.now().strftime('%Y-%m-%d')}"

    legacy_root = args.legacy.resolve()
    if not legacy_root.is_dir():
        print(f"Missing legacy uploads: {legacy_root}", file=sys.stderr)
        sys.exit(1)

    print("Walking originals (no WP WxH thumbs)...", flush=True)
    all_paths = walk_original_images(legacy_root, args.min_bytes)
    if args.max_files > 0:
        all_paths = all_paths[: args.max_files]
    print(f"Found {len(all_paths)} candidate files", flush=True)

    # טכני
    tech_rows: list[dict[str, Any]] = []
    for p in all_paths:
        rel = rel_from_legacy(p, legacy_root)
        t = technical_one(p)
        tech_rows.append({"legacy_relative": rel, "legacy_path": str(p), "technical": t})

    device = _sem.pick_device()
    model, preprocess, tokenizer, mn, pt = load_clip(device)
    prompts = [d[0] for d in LABEL_DEFS]
    text_f = encode_labels(tokenizer, device, model, prompts)

    print(f"CLIP on {device} ({mn})...", flush=True)
    all_clip: list[dict[str, Any]] = []
    for i in range(0, len(all_paths), args.batch):
        batch = all_paths[i : i + args.batch]
        part = score_image_batch_probs(preprocess, model, device, text_f, batch)
        all_clip.extend(part)

    entries_all: list[dict[str, Any]] = []
    for row, clip in zip(tech_rows, all_clip):
        tech = row["technical"]
        probs = clip.get("probs")
        ranked = clip.get("ranked") or []
        w, h = tech.get("width", 0), tech.get("height", 0)
        rel = row["legacy_relative"]
        sem = build_semantic_entry(ranked, LABEL_DEFS, threshold=0.012)
        rel_score = relevance_from_probs(
            probs,
            w,
            h,
            tech.get("bytes", 0),
            args.min_edge,
            args.min_bytes_soft,
        )
        include = rel_score >= args.threshold and tech.get("decode") == "ok"
        ent = {
            "entry_id": tech["entry_id"],
            "legacy_relative": rel,
            "filename": Path(rel).name,
            "technical": dict(tech),
            "semantic_content": sem,
            "relevance_score": round(rel_score, 5),
            "include_in_site": include,
        }
        entries_all.append(ent)

    st_path = (args.site_tree or default_site_tree_path()).resolve()
    if not st_path.is_file():
        print(
            f"WARN: site-tree.json not found at {st_path} — site_tree_tags empty",
            flush=True,
        )
        st_ctx: SiteTreeContext | None = None
    else:
        st_ctx = SiteTreeContext.load(st_path)
    for e in entries_all:
        e["site_tree_tags"] = tags_for_entry(e, st_ctx) if st_ctx else []

    included = [e for e in entries_all if e["include_in_site"]]
    # מזהים ציבוריים רציפים + שמות קבצים ייחודיים
    media_dir = out_dir / "media"
    catalog_entries: list[dict[str, Any]] = []
    for idx, e in enumerate(included, start=1):
        public_id = f"EA-{idx:06d}"
        src = legacy_root / e["legacy_relative"]
        ext = src.suffix.lower()
        if ext not in IMAGE_EXT:
            ext = ".jpg"
        dest_name = f"{public_id}{ext}"
        e_out = dict(e)
        e_out["public_id"] = public_id
        e_out["media_filename"] = dest_name
        e_out["short_title"] = short_title(e["filename"], public_id)
        catalog_entries.append(e_out)

    meta = {
        "version": 5,
        "generated_utc": datetime.now(timezone.utc).isoformat(),
        "legacy_root": str(legacy_root),
        "output_dir": str(out_dir.resolve()),
        "clip_model": mn,
        "clip_pretrained": pt,
        "torch_device": device,
        "counts": {
            "candidates": len(all_paths),
            "included": len(included),
            "excluded": len(entries_all) - len(included),
        },
        "thresholds": {
            "relevance_min": args.threshold,
            "min_bytes_scan": args.min_bytes,
            "min_edge_px": args.min_edge,
            "min_bytes_soft_penalty": args.min_bytes_soft,
            "wp_thumb_regex": WP_THUMB_RE.pattern,
        },
        "label_set": "eyalamit-topics-v1",
        "site_tree_json": str(st_path),
    }

    out_dir.mkdir(parents=True, exist_ok=True)
    (out_dir / "catalog.all.json").write_text(
        json.dumps({"meta": meta, "entries": entries_all}, ensure_ascii=False, indent=2),
        encoding="utf-8",
    )
    meta_cat = dict(meta)
    meta_cat["catalog_file"] = "catalog.json"
    (out_dir / "catalog.json").write_text(
        json.dumps({"meta": meta_cat, "entries": catalog_entries}, ensure_ascii=False, indent=2),
        encoding="utf-8",
    )

    if not args.dry_run:
        media_dir.mkdir(parents=True, exist_ok=True)
        for e in catalog_entries:
            src = legacy_root / e["legacy_relative"]
            dest = media_dir / e["media_filename"]
            dest.write_bytes(src.read_bytes())
        print(f"Copied {len(catalog_entries)} files to {media_dir}", flush=True)
    else:
        print("Dry-run: no files copied", flush=True)

    # HTML גלריה (סינון + העתקה ללוח)
    html_path = out_dir / "gallery.html"
    html = render_gallery_html(
        catalog_entries,
        relevance_threshold=args.threshold,
        included_count=meta["counts"]["included"],
    )
    html_path.write_text(html, encoding="utf-8")
    print(f"Wrote {html_path}", flush=True)

    agents = out_dir / "AGENTS.md"
    agents.write_text(
        f"""# קטלוג מדיה מלגסי — מדריך לאיגנטים

נוצר אוטומטית: `{meta["generated_utc"]}` · מקור עץ: `{st_path}`

## מיקום

- **אינדקס מלא (כולל נפסלים):** `catalog.all.json`
- **אינדקס לשילוב באתר:** `catalog.json` — רק `include_in_site` אחרי סף `relevance_score`
- **קבצים:** תיקיית `media/` — שמות שטוחים `EA-000001.jpg` וכו'
- **גלריה סטטית:** `gallery.html` — סינון לפי צמתי עץ, לחיצה על כרטיס מעתיקה מזהה ללוח

## שדות עיקריים ב-`catalog.json`

| שדה | משמעות |
|-----|--------|
| `public_id` | מזהה יציב לתצוגה (`EA-000001`) |
| `media_filename` | שם הקובץ תחת `media/` |
| `short_title` | כותרת קצרה לגלריה |
| `legacy_relative` | נתיב יחסי בלגסי מתוך `wp-content/uploads/` |
| `relevance_score` | 0–1 — ציון שילוב CLIP + מימדים |
| `semantic_content` | תגיות נושא בעברית, `site_hooks_union` |
| `site_tree_tags` | שיוך היוריסטי לצמתי עץ (`node_id`, `title_he`, `slug`, `path_he`, `source`) |
| `technical` | sha256, phash, מימדים |

## תגיות עץ

נגזרות מ־CLIP + מיפוי ב־`tools/site_tree_tags.py` — **לא אמת מילולית**.

## גלריה — העתקה ללוח

```
EA-000042 | EA-000042.jpg
legacy: …/שם-קובץ-מקור
```

## סינון

- נגזרות WordPress (`*-300x200.jpg` וכו') **לא נכללו** בסריקה.
- סף רלוונטיות בשימוש: **{args.threshold}** (ראה `meta.thresholds` ב-JSON).

## Hub

לאחר `python3 scripts/build_eyal_client_hub.py` מהמאגר: `hub/dist/files/team40/ea-legacy-curated/`. דגל `--skip-team40-legacy-media` מדלג על העתקת המדיה.

## עדכון תגיות בלי CLIP

`python3 tools/enrich_catalog_site_tree.py --catalog-dir <תיקיית_קטלוג>`

## המשך

שכבת VLM לתיאור בעברית: ראה `../legacy-media-index-50-2026-04-11/SEMANTIC-LAYER.md`.
""",
        encoding="utf-8",
    )
    print(f"Wrote {agents}", flush=True)
    print(f"Done. Output: {out_dir}", flush=True)


if __name__ == "__main__":
    main()
