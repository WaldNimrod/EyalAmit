#!/usr/bin/env python3
"""
בונה אינדקס JSON למדיה מלגסי: העתקה (אופציונלי), חישובי פיקסלים, תגיות מובנות.
אין תלות ב-Ollama — כל תיאורי הסוכן ל-scan_primary מבוססי סטטיסטיקה על התמונה.
"""
from __future__ import annotations

import argparse
import hashlib
import json
import os
import random
import re
from collections import Counter
from datetime import datetime, timezone
from pathlib import Path
from typing import Any

from PIL import Image, ImageFilter, ImageStat, ExifTags
import imagehash
import numpy as np

IMAGE_EXT = {".jpg", ".jpeg", ".png", ".gif", ".webp"}

# קבצי ה-POC הקודם (לא לכלול ב"לא בממשק" אם רוצים הפרדה נקייה)
DEFAULT_EXCLUDE = {
    "2017/06/כושי-בלאנטיס1.jpg",
    "2016/12/כושי-בלאנטיס1.jpg",
    "2016/12/איל-מישה-איטליה-כושי-בלאנטיס-3.jpg",
    "2010/12/Screen20Shot202013-03-1220at208.png",
    "2016/12/סיני-יוני-09-151.jpg",
    "2016/12/עטיפה-1.jpg",
    "2017/06/רותם-כהן-צבע-בכחול-וזרוק-לים-הודו-2.jpg",
    "2017/06/מוזה-הוצאה-לאור-איטליה-1.jpg",
    "2017/06/אייל-עמית-וכתבת.jpg",
    "2017/06/צבע-בכחול-וזרוק-לים-קאסול-2.jpg",
}

CONTENT_HINT_RE = re.compile(
    r"(מוזה|כושי|צבע|בכחול|וכתבת|דיגרידו|עמית|הרצא|סדנא|טיפול|אייל)",
    re.I,
)


def rel_posix(p: Path, root: Path) -> str:
    return p.relative_to(root).as_posix()


def walk_images(root: Path, min_bytes: int) -> list[Path]:
    out: list[Path] = []
    for dirpath, _, files in os.walk(root):
        for f in files:
            suf = Path(f).suffix.lower()
            if suf not in IMAGE_EXT:
                continue
            fp = Path(dirpath) / f
            try:
                if fp.stat().st_size >= min_bytes:
                    out.append(fp)
            except OSError:
                pass
    return out


def rgb_to_hsv_np(rgb: np.ndarray) -> tuple[float, float, float]:
    """rgb 0-1, returns h 0-360 s,v 0-1"""
    r, g, b = rgb
    mx = max(r, g, b)
    mn = min(r, g, b)
    d = mx - mn
    if d < 1e-6:
        h = 0.0
    elif mx == r:
        h = (60 * ((g - b) / d) + 360) % 360
    elif mx == g:
        h = (60 * ((b - r) / d) + 120) % 360
    else:
        h = (60 * ((r - g) / d) + 240) % 360
    s = 0 if mx == 0 else d / mx
    v = mx
    return h, s, v


def analyze_pixels(im: Image.Image) -> dict[str, Any]:
    im = im.convert("RGB")
    w, h = im.size
    # downsample for stats
    max_side = 320
    if max(w, h) > max_side:
        r = max_side / max(w, h)
        im_small = im.resize((max(1, int(w * r)), max(1, int(h * r))), Image.Resampling.LANCZOS)
    else:
        im_small = im
    arr = np.asarray(im_small).astype(np.float64) / 255.0
    flat = arr.reshape(-1, 3)
    mean_rgb = flat.mean(axis=0)
    std_rgb = flat.std(axis=0)
    hsv = np.array([rgb_to_hsv_np(flat[i]) for i in range(0, len(flat), max(1, len(flat) // 5000))])
    mean_h, mean_s, mean_v = hsv.mean(axis=0)

    # dominant colors (quantize to 8 bins per channel)
    q = (arr * 7).astype(np.uint8)
    packed = (q[:, :, 0].astype(np.uint32) << 16) | (q[:, :, 1].astype(np.uint32) << 8) | q[
        :, :, 2
    ].astype(np.uint32)
    counts = Counter(packed.flatten().tolist()).most_common(5)
    palette = []
    for val, _cnt in counts[:5]:
        rq = (val >> 16) & 0xFF
        gq = (val >> 8) & 0xFF
        bq = val & 0xFF
        rr = int((rq / 7.0) * 255)
        gg = int((gq / 7.0) * 255)
        bb = int((bq / 7.0) * 255)
        palette.append("#{:02x}{:02x}{:02x}".format(rr, gg, bb))

    gray = im_small.convert("L")
    stat = ImageStat.Stat(gray)
    brightness = stat.mean[0] / 255.0
    contrast = stat.stddev[0] / 255.0

    edges = gray.filter(ImageFilter.FIND_EDGES)
    edge_arr = np.asarray(edges).astype(np.float64)
    edge_energy = float(edge_arr.mean() / 255.0)
    lap = np.var(edge_arr)

    # classify
    ow, oh = im.size
    if ow > oh * 1.15:
        orientation = "landscape"
    elif oh > ow * 1.15:
        orientation = "portrait"
    else:
        orientation = "square"

    if brightness < 0.35:
        brightness_band = "dark"
    elif brightness > 0.65:
        brightness_band = "bright"
    else:
        brightness_band = "mid"

    if mean_h < 60 or mean_h > 300:
        temp = "warm"
    elif 180 < mean_h < 260:
        temp = "cool"
    else:
        temp = "neutral"

    if mean_s < 0.15:
        sat = "low"
    elif mean_s < 0.4:
        sat = "moderate"
    else:
        sat = "high"

    if edge_energy < 0.08 and contrast < 0.12:
        complexity = "low"
    elif edge_energy > 0.18 or contrast > 0.22:
        complexity = "high"
    else:
        complexity = "medium"

    if lap < 300:
        sharp = "soft"
    elif lap < 1200:
        sharp = "medium"
    else:
        sharp = "sharp"

    return {
        "width": w,
        "height": h,
        "mean_rgb": [round(float(x), 4) for x in mean_rgb],
        "std_rgb": [round(float(x), 4) for x in std_rgb],
        "mean_hsv_deg": [round(float(mean_h), 2), round(float(mean_s), 4), round(float(mean_v), 4)],
        "brightness_0_1": round(brightness, 4),
        "contrast_0_1": round(contrast, 4),
        "edge_energy_0_1": round(edge_energy, 4),
        "laplacian_variance": round(float(lap), 2),
        "dominant_hex": palette[:5],
        "orientation": orientation,
        "brightness_band": brightness_band,
        "color_temperature": temp,
        "saturation_band": sat,
        "complexity": complexity,
        "sharpness": sharp,
    }


def he_notes_from_stats(
    st: dict[str, Any], source_class: str, filename: str
) -> tuple[dict[str, list[str]], str]:
    tags: dict[str, list[str]] = {
        "orientation": [st["orientation"]],
        "brightness": [st["brightness_band"]],
        "color_temperature": [st["color_temperature"]],
        "saturation": [st["saturation_band"]],
        "complexity": [st["complexity"]],
        "sharpness": [st["sharpness"]],
        "dominant_colors": st["dominant_hex"][:5],
    }
    oh = {"landscape": "רוחבי", "portrait": "אנכי", "square": "מרובע"}[st["orientation"]]
    br = {"dark": "כהה", "mid": "בינונית", "bright": "בהירה"}[st["brightness_band"]]
    temp = {"warm": "חמים", "cool": "קרירים", "neutral": "ניטרליים"}[st["color_temperature"]]
    comp = {"low": "נמוכה", "medium": "בינונית", "high": "גבוהה"}[st["complexity"]]
    shp = {"soft": "רכה", "medium": "בינונית", "sharp": "גבוהה"}[st["sharpness"]]

    if source_class == "scan_primary":
        notes = (
            f"ניתוח פיקסלים בלבד (ללא שם קובץ): תמונה {oh}, בהירות כללית {br}, "
            f"מגוון צבעים {temp}, מורכבות מבנית {comp}, חדות משוערת {shp}. "
            f"צבעים דומיננטיים: {', '.join(st['dominant_hex'][:3])}."
        )
    else:
        notes = (
            f"ניתוח פיקסלים + הקשר שם קובץ. ויזואלית: {oh}, בהירות {br}, גוון {temp}, "
            f"מורכבות {comp}, חדות {shp}. קובץ: {filename}."
        )
        tags["filename_context"] = ["books_or_brand_adjacent"]

    return tags, notes


def exif_basic(im: Image.Image) -> dict[str, str]:
    out: dict[str, str] = {}
    try:
        ex = im.getexif()
        if not ex:
            return out
        for k, v in ex.items():
            tag = ExifTags.TAGS.get(k, str(k))
            if tag in ("DateTime", "DateTimeOriginal", "DateTimeDigitized") and not out.get(
                "datetime"
            ):
                out["datetime"] = str(v)[:32]
            if tag == "Make" and "camera" not in out:
                out["camera_make"] = str(v).strip()
            if tag == "Model":
                out["camera_model"] = str(v).strip()
    except Exception:
        pass
    if out.get("camera_make") or out.get("camera_model"):
        out["camera"] = (out.get("camera_make", "") + " " + out.get("camera_model", "")).strip()
    return out


def build_search_blob(entry: dict[str, Any]) -> str:
    ag = entry.get("agent", {})
    parts = [
        entry.get("legacy_relative", ""),
        entry.get("entry_id", ""),
        json.dumps(ag.get("tags", {}), ensure_ascii=False),
        json.dumps(ag.get("tag_groups_he", {}), ensure_ascii=False),
        ag.get("notes_he", ""),
        str(entry.get("technical", {})),
    ]
    return "\n".join(parts).lower()


def build_search_keywords(entry: dict[str, Any]) -> dict[str, Any]:
    """מפתחות לחיפוש טקסטואלי / סינון (מחרוזות קטנות באנגלית + עברית מהערות)."""
    ag = entry.get("agent", {})
    tags = ag.get("tags", {})
    kw: list[str] = []
    for _cat, vals in tags.items():
        if isinstance(vals, list):
            kw.extend(str(v).lower() for v in vals)
        else:
            kw.append(str(vals).lower())
    for _cat, vals in ag.get("tag_groups_he", {}).items():
        if isinstance(vals, list):
            kw.extend(str(v) for v in vals)
        else:
            kw.append(str(vals))
    # path tokens (year, ext)
    rel = entry.get("legacy_relative", "")
    parts = rel.replace("\\", "/").split("/")
    for p in parts:
        if p:
            kw.append(p.lower())
    notes = entry.get("agent", {}).get("notes_he", "")
    for w in re.findall(r"[\u0590-\u05FF]{2,}", notes):
        kw.append(w)
    tech = entry.get("technical", {})
    for key in ("format", "phash"):
        v = tech.get(key)
        if v:
            kw.append(str(v).lower())
    # dedupe preserve order
    seen = set()
    out: list[str] = []
    for x in kw:
        if x not in seen:
            seen.add(x)
            out.append(x)
    return {"keywords": out, "facet_snapshot": tags}


def process_one(
    src: Path,
    legacy_root: Path,
    source_class: str,
) -> dict[str, Any]:
    rel = rel_posix(src, legacy_root)
    data = open(src, "rb").read()
    sha = hashlib.sha256(data).hexdigest()
    entry_id = sha[:16]
    im = Image.open(src)
    im.load()
    fmt = im.format or ""
    exif = exif_basic(im)
    try:
        ph = str(imagehash.phash(im))
    except Exception:
        ph = ""
    st = analyze_pixels(im)
    tags, notes_he = he_notes_from_stats(st, source_class, src.name)
    aspect = round(st["width"] / st["height"], 4) if st["height"] else None

    technical = {
        "bytes": len(data),
        "width": st["width"],
        "height": st["height"],
        "aspect_ratio": aspect,
        "format": fmt,
        "sha256": sha,
        "phash": ph,
        "exif": exif,
        "pixel_stats": {k: v for k, v in st.items() if k not in ("width", "height")},
    }

    tag_groups_he = {
        "כיוון_ומסג": tags.get("orientation", []),
        "בהירות_כללית": tags.get("brightness", []),
        "טמפרטורת_צבע_מוערכת": tags.get("color_temperature", []),
        "רווי_צבע": tags.get("saturation", []),
        "מורכבות_מבנית": tags.get("complexity", []),
        "חדות_משוערת": tags.get("sharpness", []),
        "צבעים_דומיננטיים_hex": tags.get("dominant_colors", []),
    }
    if "filename_context" in tags:
        tag_groups_he["הקשר_קובץ"] = tags["filename_context"]

    agent = {
        "tags": tags,
        "tag_groups_he": tag_groups_he,
        "notes_he": notes_he,
        "notes_source": "pixel_statistics_v1",
        "source_class": source_class,
    }

    entry = {
        "entry_id": entry_id,
        "legacy_relative": rel,
        "filename": src.name,
        "technical": technical,
        "agent": agent,
    }
    entry["search_blob"] = build_search_blob(entry)
    entry["search"] = build_search_keywords(entry)
    return entry


def select_files(
    legacy_root: Path,
    exclude: set[str],
    seed: int,
    n_scan: int,
    n_ctx: int,
) -> tuple[list[tuple[Path, str]], list[tuple[Path, str]]]:
    random.seed(seed)
    all_im = walk_images(legacy_root, min_bytes=20_000)
    rel_map = {rel_posix(p, legacy_root): p for p in all_im}
    pool = [p for p in all_im if rel_posix(p, legacy_root) not in exclude]
    if len(pool) < n_scan:
        raise SystemExit(f"need {n_scan} random files, only {len(pool)} after exclude")

    scan_pool = [p for p in pool if not CONTENT_HINT_RE.search(rel_posix(p, legacy_root))]
    if len(scan_pool) < n_scan:
        scan_pool = list(pool)

    scan_pick = random.sample(scan_pool, n_scan)

    ctx_candidates = [
        p
        for p in pool
        if p not in scan_pick and CONTENT_HINT_RE.search(rel_posix(p, legacy_root))
    ]
    random.shuffle(ctx_candidates)
    ctx_pick: list[Path] = []
    for p in ctx_candidates:
        if len(ctx_pick) >= n_ctx:
            break
        ctx_pick.append(p)
    # fill if not enough keyword files
    rest = [p for p in pool if p not in scan_pick and p not in ctx_pick]
    random.shuffle(rest)
    for p in rest:
        if len(ctx_pick) >= n_ctx:
            break
        ctx_pick.append(p)

    if len(ctx_pick) < n_ctx:
        raise SystemExit(f"could only pick {len(ctx_pick)} context files")

    out_scan = [(p, "scan_primary") for p in scan_pick]
    out_ctx = [(p, "content_context") for p in ctx_pick[:n_ctx]]
    return out_scan, out_ctx


def main() -> None:
    ap = argparse.ArgumentParser()
    ap.add_argument("--legacy", type=Path, required=True)
    ap.add_argument("--mirror", type=Path, required=True)
    ap.add_argument("--out-json", type=Path, required=True)
    ap.add_argument("--scan", type=int, default=25)
    ap.add_argument("--context", type=int, default=25)
    ap.add_argument("--seed", type=int, default=42)
    ap.add_argument("--copy", action="store_true")
    args = ap.parse_args()

    exclude = set(DEFAULT_EXCLUDE)
    scan_sel, ctx_sel = select_files(args.legacy, exclude, args.seed, args.scan, args.context)
    combined = scan_sel + ctx_sel

    args.mirror.mkdir(parents=True, exist_ok=True)

    entries: list[dict[str, Any]] = []
    for src, cls in combined:
        rel = rel_posix(src, args.legacy)
        if args.copy:
            dest = args.mirror / rel
            dest.parent.mkdir(parents=True, exist_ok=True)
            if not dest.exists():
                dest.write_bytes(src.read_bytes())
        # process from source (original) for stats
        entry = process_one(src, args.legacy, cls)
        entry["mirror_relative"] = rel
        entries.append(entry)

    meta = {
        "version": 2,
        "generated_utc": datetime.now(timezone.utc).isoformat(),
        "legacy_root": str(args.legacy),
        "mirror_root": str(args.mirror),
        "total": len(entries),
        "counts": {
            "scan_primary": sum(1 for e in entries if e["agent"]["source_class"] == "scan_primary"),
            "content_context": sum(
                1 for e in entries if e["agent"]["source_class"] == "content_context"
            ),
        },
        "selection": {
            "exclude_poc_paths": sorted(exclude),
            "random_seed": args.seed,
            "scan_primary_rule": "random among uploads >=20KB, excluding POC list; prefer paths without content keywords for 'not in curated mapping'",
            "content_context_rule": "prefer paths matching books/brand heuristics; fill remainder random",
        },
    }

    # Facets for structured search
    by_year: dict[str, list[str]] = {}
    for e in entries:
        y = e["legacy_relative"].split("/")[0] if "/" in e["legacy_relative"] else "unknown"
        by_year.setdefault(y, []).append(e["entry_id"])
    meta["facets"] = {
        "by_year": {k: len(v) for k, v in sorted(by_year.items())},
        "by_source_class": meta["counts"],
    }

    # אינדקס הפוך לפי מילות מפתח אנגליות/מזהים קצרים (לא כל עברית — חוסך נפח)
    keyword_index: dict[str, list[str]] = {}
    for e in entries:
        eid = e["entry_id"]
        for kw in e["search"]["keywords"]:
            if len(kw) < 2:
                continue
            if len(kw) > 80:
                continue
            keyword_index.setdefault(kw, []).append(eid)
    meta["search"] = {
        "keyword_index": keyword_index,
        "hint_he": "סנן entries שבהם query מופיע ב-search_blob או ב-search.keywords; השתמש ב-meta.facets ו-source_class.",
    }

    doc = {"meta": meta, "entries": entries}
    args.out_json.parent.mkdir(parents=True, exist_ok=True)
    args.out_json.write_text(json.dumps(doc, ensure_ascii=False, indent=2), encoding="utf-8")
    print(f"Wrote {len(entries)} entries to {args.out_json}")


if __name__ == "__main__":
    main()
