#!/usr/bin/env python3
"""
DOK Image Processor — web-ready, two tagged sizes per image + rich index
-----------------------------------------------------------------------
For EVERY source image, produces TWO variants:
  • LARGE  (2560px long edge)  -> hero / full-screen / gallery
  • SMALL  (1280px long edge)  -> thumbnails / mobile / previews

Routing by type:
  HEIC      -> JPG  (q85, EXIF preserved)
  JPG       -> JPG  (q85, re-optimized)
  PNG/photo -> JPG  (no transparency = photo saved as PNG -> big savings)
  PNG/alpha -> PNG  (has transparency = graphic/logo -> kept lossless)
  AAE       -> skipped (Apple Photos sidecar)

Naming (the tag): large keeps the clean name, small gets a `_sm` suffix.
  IMG_0801.jpg       (large)
  IMG_0801_sm.jpg    (small)

Folder structure preserved under DOK-WEB/. Index: _INDEX_IMAGES.csv
(one row per source, both variants + full attributes).

Single-threaded — no hangs.

Usage:
  python3 process_images.py            # all images
  python3 process_images.py --test 15  # first 15 into DOK-WEB/_TEST
"""

import os, sys, csv, json, subprocess
from pathlib import Path

SOURCE = (
    Path.home() / "Documents" / "Eyal Amit" / "EyalAmit.co.il-2026"
    / "docs" / "project" / "eyal-ceo-submissions-and-responses"
    / "from-eyal" / "תוכן לאתר 25.5.26" / "תמונות וסרטונים DOK אביב"
)

# ---- tunables ----
MAX_DIM_LARGE = 2560   # hero / full view
MAX_DIM_SMALL = 1280   # thumbnail / mobile
JPEG_QUALITY  = 85
# ------------------

IMAGE_EXTS = {".heic", ".jpg", ".jpeg", ".png"}


def run(cmd, timeout=120):
    return subprocess.run(cmd, capture_output=True, text=True, timeout=timeout)


def human(n):
    n = float(n)
    for unit in ("B", "KB", "MB", "GB"):
        if n < 1024:
            return f"{n:.1f}{unit}"
        n /= 1024
    return f"{n:.1f}TB"


def to_jpg(src: Path, dst: Path, max_dim: int) -> int:
    """HEIC/JPG/photo-PNG -> JPG at max_dim. Returns output size or 0."""
    dst.parent.mkdir(parents=True, exist_ok=True)
    r = run(["sips", "-s", "format", "jpeg",
             "-s", "formatOptions", str(JPEG_QUALITY),
             "-Z", str(max_dim), str(src), "--out", str(dst)])
    return dst.stat().st_size if (r.returncode == 0 and dst.exists()) else 0


def to_png(src: Path, dst: Path, max_dim: int) -> int:
    """alpha-PNG -> PNG at max_dim (keeps transparency). Returns output size or 0."""
    dst.parent.mkdir(parents=True, exist_ok=True)
    r = run(["sips", "-s", "format", "png",
             "-Z", str(max_dim), str(src), "--out", str(dst)])
    return dst.stat().st_size if (r.returncode == 0 and dst.exists()) else 0


def get_metadata_bulk(files) -> dict:
    if not files:
        return {}
    cmd = ["exiftool", "-json", "-n",
           "-DateTimeOriginal", "-CreateDate",
           "-Make", "-Model", "-LensModel",
           "-ImageWidth", "-ImageHeight", "-Megapixels",
           "-Orientation#", "-GPSLatitude", "-GPSLongitude",
           "-FNumber", "-ExposureTime", "-ISO", "-FocalLength",
           "-ColorSpace", "-ColorType"] + [str(f) for f in files]
    r = run(cmd, timeout=300)
    out = {}
    try:
        for entry in json.loads(r.stdout):
            out[str(Path(entry.get("SourceFile", "")).resolve())] = entry
    except Exception:
        pass
    return out


def main():
    test_limit = 0
    dest_name = "DOK-WEB"
    if "--test" in sys.argv:
        i = sys.argv.index("--test")
        test_limit = int(sys.argv[i + 1]) if i + 1 < len(sys.argv) else 15
        dest_name = "DOK-WEB/_TEST"

    dest_root = SOURCE.parent / dest_name
    dest_root.mkdir(parents=True, exist_ok=True)
    index_csv = dest_root / "_INDEX_IMAGES.csv"

    images = sorted(f for f in SOURCE.rglob("*")
                    if f.is_file() and f.suffix.lower() in IMAGE_EXTS)
    if test_limit:
        images = images[:test_limit]

    print(f"מקור:  {SOURCE}")
    print(f"יעד:   {dest_root}")
    print(f"תמונות: {len(images)}" + (f"  (בדיקה: {test_limit})" if test_limit else ""))
    print(f"גרסאות: LARGE {MAX_DIM_LARGE}px + SMALL {MAX_DIM_SMALL}px · JPEG q{JPEG_QUALITY}\n")

    meta = get_metadata_bulk(images)

    rows = []
    tot_in = tot_large = tot_small = 0
    ok = err = 0

    for n, src in enumerate(images, 1):
        ext = src.suffix.lower()
        rel = src.relative_to(SOURCE)
        size_in = src.stat().st_size
        tot_in += size_in
        m = meta.get(str(src.resolve()), {})

        is_alpha_png = (ext == ".png"
                        and "alpha" in str(m.get("ColorType", "")).lower())

        if is_alpha_png:
            out_ext, conv, action = ".png", to_png, "png-keep"
        elif ext == ".png":
            out_ext, conv, action = ".jpg", to_jpg, "png→jpg"
        else:
            out_ext, conv, action = ".jpg", to_jpg, "converted"

        large = dest_root / rel.with_suffix(out_ext)
        small = dest_root / rel.with_name(rel.stem + "_sm" + out_ext)

        size_large = conv(src, large, MAX_DIM_LARGE)
        size_small = conv(src, small, MAX_DIM_SMALL)
        success = size_large > 0 and size_small > 0

        tot_large += size_large
        tot_small += size_small
        ok += success
        err += (not success)

        rows.append({
            "n": n,
            "source_name":    src.name,
            "rel_folder":     str(rel.parent),
            "orig_format":    ext.lstrip("."),
            "action":         action if success else "ERROR",
            "large_file":     large.name,
            "large_size":     size_large,
            "small_file":     small.name,
            "small_size":     size_small,
            "orig_size":      size_in,
            "saved_pct":      round((1 - (size_large + size_small) / size_in) * 100, 1) if size_in else "",
            "date_taken":     m.get("DateTimeOriginal") or m.get("CreateDate", ""),
            "camera":         " ".join(x for x in (m.get("Make"), m.get("Model")) if x),
            "lens":           m.get("LensModel", ""),
            "orig_width":     m.get("ImageWidth", ""),
            "orig_height":    m.get("ImageHeight", ""),
            "megapixels":     m.get("Megapixels", ""),
            "gps_lat":        m.get("GPSLatitude", ""),
            "gps_lon":        m.get("GPSLongitude", ""),
            "f_number":       m.get("FNumber", ""),
            "exposure":       m.get("ExposureTime", ""),
            "iso":            m.get("ISO", ""),
            "focal_length":   m.get("FocalLength", ""),
        })

        flag = "✓" if success else "✗"
        print(f"[{n}/{len(images)}] {flag} {action:10s} "
              f"L:{human(size_large):>8s}  S:{human(size_small):>8s}  {src.name}")

    if rows:
        with open(index_csv, "w", newline="", encoding="utf-8-sig") as f:
            w = csv.DictWriter(f, fieldnames=list(rows[0].keys()))
            w.writeheader()
            w.writerows(rows)

    tot_out = tot_large + tot_small
    print("\n" + "=" * 52)
    print(f"עובדו {ok} | שגיאות {err}  (×2 גרסאות = {ok*2} קבצים)")
    print(f"נפח מקור:      {human(tot_in)}")
    print(f"גרסה גדולה:    {human(tot_large)}")
    print(f"גרסה קטנה:     {human(tot_small)}")
    print(f"סה\"כ פלט:      {human(tot_out)}")
    if tot_in:
        print(f"חיסכון מול מקור: {human(tot_in - tot_out)}  ({round((1-tot_out/tot_in)*100,1)}%)")
    print(f"אינדקס:        {index_csv}")


if __name__ == "__main__":
    main()
