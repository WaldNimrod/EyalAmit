#!/usr/bin/env python3
"""Generate 160×160 JPEG thumbnails for all DOK-WEB videos using ffmpeg.

Outputs: DOK-WEB/video_thumbs/{stem}.jpg  (skip if already exists)
Run: python3 _COMMUNICATION/team_110/gen-video-thumbs.py
"""
import csv, os, subprocess, sys
from concurrent.futures import ThreadPoolExecutor, as_completed

PROJ    = "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026"
DOK     = f"{PROJ}/docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/DOK-WEB"
VID_DIR = f"{DOK}/videos"
VID_CSV = f"{DOK}/_INDEX_VIDEOS.csv"
OUT_DIR = f"{DOK}/video_thumbs"
WORKERS = 6


def make_thumb(row):
    stem     = row['source_name'].rsplit('.', 1)[0]
    fn       = row['output_name']
    dur_str  = row.get('duration_sec', '0')
    dur      = float(dur_str) if dur_str else 0.0
    src      = os.path.join(VID_DIR, fn)
    out      = os.path.join(OUT_DIR, stem + '.jpg')

    if not os.path.exists(src):
        return (stem, 'missing')
    if os.path.exists(out):
        return (stem, 'skip')

    # seek to 5% of duration, min 1s, max 4s
    t = max(1.0, min(4.0, dur * 0.05))

    cmd = [
        'ffmpeg', '-y', '-loglevel', 'error',
        '-ss', str(t),
        '-i', src,
        '-vframes', '1',
        '-vf', 'scale=160:160:force_original_aspect_ratio=increase,crop=160:160',
        '-q:v', '4',
        out,
    ]
    try:
        subprocess.run(cmd, check=True, capture_output=True, timeout=30)
        return (stem, 'ok')
    except Exception as e:
        return (stem, f'err:{e}')


def main():
    os.makedirs(OUT_DIR, exist_ok=True)

    with open(VID_CSV, newline='', encoding='utf-8-sig') as f:
        rows = list(csv.DictReader(f))

    total = len(rows)
    print(f"Processing {total} videos with {WORKERS} workers…")

    done = skip = err = 0
    with ThreadPoolExecutor(max_workers=WORKERS) as pool:
        futs = {pool.submit(make_thumb, r): r for r in rows}
        for i, fut in enumerate(as_completed(futs), 1):
            stem, status = fut.result()
            if status == 'ok':    done += 1
            elif status == 'skip': skip += 1
            else:                 err  += 1; print(f"  ✗ {stem}: {status}")
            if i % 100 == 0:
                print(f"  {i}/{total}  done={done} skip={skip} err={err}")

    print(f"\nDone. done={done}  skip={skip}  err={err}")
    print(f"Thumbnails: {OUT_DIR}")


if __name__ == '__main__':
    main()
