#!/usr/bin/env python3
"""Package the media gallery for delivery to Eyal.

Creates _COMMUNICATION/team_110/build/gallery-eyal/ with:
  gallery.html     — open in any browser, no server needed
  images/          — 582 DOK-WEB images (full + _sm thumbs)
  video_thumbs/    — 1,454 video frame JPGs (CLIP-tagged)
  legacy/          — 315 EA legacy archive images
  site/            — 48 current website images
  videos/          — 1,459 web-compressed MP4s (h264/720p, from DOK-WEB/videos)
  data/            — JSON indexes + AI-readable text reports

Run: python3 _COMMUNICATION/team_110/package-gallery.py
"""
import csv, json, os, shutil, subprocess, sys
from datetime import date

PROJ   = "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026"
DOK    = f"{PROJ}/docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/DOK-WEB"
PKG    = f"{PROJ}/_COMMUNICATION/team_110/build/gallery-eyal"
TODAY  = date.today().isoformat()

# Source data files
SRC_DATA = {
    "image-clip-tags.json":   f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/image-clip-tags.json",
    "video-clip-tags.json":   f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/video-clip-tags.json",
    "video-enrichment.json":  f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/video-enrichment.json",
    "person-tags.json":       f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/person-tags.json",
    "slot-candidates.json":   f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/slot-candidates.json",
    "catalog-images.json":    f"{PROJ}/_COMMUNICATION/team_110/build/catalogs/ea-dok-web/catalog-images.json",
    "catalog-videos.json":    f"{PROJ}/_COMMUNICATION/team_110/build/catalogs/ea-dok-web/catalog-videos.json",
}

LEGACY_SRC  = f"{PROJ}/_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/media"
LEGACY_CAT  = f"{PROJ}/_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/catalog.json"
THEME_SRC   = f"{PROJ}/site/wp-content/themes/ea-eyalamit/assets/images"
IMG_CSV     = f"{DOK}/_INDEX_IMAGES.csv"
VID_CSV     = f"{DOK}/_INDEX_VIDEOS.csv"


def fmt_dur(sec):
    if not sec:
        return '—'
    s = int(float(sec))
    return f"{s//60}:{s%60:02d}"


def copy_dir_progress(src, dst, label):
    os.makedirs(dst, exist_ok=True)
    files = [f for f in os.listdir(src)
             if os.path.isfile(os.path.join(src, f)) and not f.startswith('.')]
    print(f"  Copying {len(files)} files → {label}/")
    for i, fn in enumerate(files, 1):
        shutil.copy2(os.path.join(src, fn), os.path.join(dst, fn))
        if i % 200 == 0:
            print(f"    {i}/{len(files)}…")
    print(f"    done ({len(files)} files)")
    return len(files)


# ── 1. Create directory structure ─────────────────────────────────────────────

def setup_dirs():
    for d in ['images', 'video_thumbs', 'legacy', 'site', 'videos', 'data']:
        os.makedirs(f"{PKG}/{d}", exist_ok=True)
    print(f"Package root: {PKG}")


# ── 2. Copy media files ───────────────────────────────────────────────────────

def copy_dok_images():
    """Copy all DOK-WEB image files (full + _sm thumbs) from DOK root."""
    dst = f"{PKG}/images"
    files = [f for f in os.listdir(DOK)
             if f.lower().endswith(('.jpg','.jpeg','.png')) and not f.startswith('.')]
    print(f"  Copying {len(files)} DOK-WEB image files → images/")
    for i, fn in enumerate(files, 1):
        shutil.copy2(f"{DOK}/{fn}", f"{dst}/{fn}")
        if i % 200 == 0:
            print(f"    {i}/{len(files)}…")
    print(f"    done ({len(files)} files)")
    return len(files)


def copy_video_thumbs():
    src = f"{DOK}/video_thumbs"
    if os.path.isdir(src):
        return copy_dir_progress(src, f"{PKG}/video_thumbs", "video_thumbs")
    print("  video_thumbs not found, skipping")
    return 0


def copy_legacy():
    return copy_dir_progress(LEGACY_SRC, f"{PKG}/legacy", "legacy")


def copy_site():
    EXCLUDE = {'ea-logo.jpg','ea-logo-mark.png','ea-arcs.png','ea-logo.jpeg'}
    EXCL_STEMS = {'logo','arcs','logo-mark','palette','icon'}
    dst = f"{PKG}/site"
    os.makedirs(dst, exist_ok=True)
    total = 0
    for root, _, files in os.walk(THEME_SRC):
        sub = os.path.relpath(root, THEME_SRC)
        for fn in files:
            if not fn.lower().endswith(('.jpg','.jpeg','.png')):
                continue
            if fn in EXCLUDE:
                continue
            stem = fn.rsplit('.',1)[0].lower()
            if any(x in stem for x in EXCL_STEMS):
                continue
            dst_fn = fn if sub == '.' else f"{sub.replace(os.sep,'_')}_{fn}"
            shutil.copy2(os.path.join(root, fn), f"{dst}/{dst_fn}")
            total += 1
    print(f"  Copied {total} site images → site/")
    return total


def copy_videos():
    """Copy the web-compressed MP4s (DOK-WEB/videos — already h264/720p per _INDEX_VIDEOS.csv)."""
    src = f"{DOK}/videos"
    if os.path.isdir(src):
        return copy_dir_progress(src, f"{PKG}/videos", "videos")
    print("  videos/ not found, skipping")
    return 0


# ── 3. Copy JSON data files ───────────────────────────────────────────────────

def copy_json_data():
    for name, src in SRC_DATA.items():
        if os.path.exists(src):
            shutil.copy2(src, f"{PKG}/data/{name}")
            size_kb = os.path.getsize(src) // 1024
            print(f"  data/{name}  ({size_kb} KB)")
        else:
            print(f"  MISSING: {src}")


# ── 4. Generate AI-readable text reports ─────────────────────────────────────

def load_json(path):
    if os.path.exists(path):
        with open(path, encoding='utf-8') as f:
            return json.load(f)
    return {}


def generate_images_report():
    clip_tags   = load_json(f"{PKG}/data/image-clip-tags.json")
    person_tags = load_json(f"{PKG}/data/person-tags.json")
    slots       = load_json(f"{PKG}/data/slot-candidates.json")

    # Load CSV metadata
    img_rows = {}
    with open(IMG_CSV, newline='', encoding='utf-8-sig') as f:
        for row in csv.DictReader(f):
            stem = row['source_name'].rsplit('.',1)[0]
            img_rows[f"DOK-{stem}"] = row

    lines = [
        f"# גלריית מדיה — אייל עמית | אינדקס תמונות מועשר",
        f"# נוצר: {TODAY}",
        f"# {len(img_rows)} תמונות DOK-WEB | תגיות CLIP: {len(clip_tags)} | אנשים ממויינים: {len(person_tags)}",
        "",
    ]

    for img_id, row in img_rows.items():
        stem = img_id[4:]
        tags = clip_tags.get(img_id, [])
        persons = person_tags.get(img_id, [])
        w = row.get('orig_width','')
        h = row.get('orig_height','')
        res = f"{w}×{h}" if w and h else '—'
        mp = row.get('megapixels','') or '—'
        cam = row.get('camera','') or '—'
        dt  = (row.get('date_taken','') or '')[:10].replace(':','-')
        gps_s = ''
        try:
            lat = float(row.get('gps_lat') or 0)
            lon = float(row.get('gps_lon') or 0)
            if 29 < lat < 34 and 34 < lon < 36:
                gps_s = ' | ישראל'
        except Exception:
            pass
        slot_pages = [f"{s['page']}/{s['role'] or s.get('section','')}"
                      for s in (slots.get(img_id) or [])]

        lines.append(img_id)
        lines.append(f"  קובץ: {stem}.jpg | thumb: {stem}_sm.jpg")
        lines.append(f"  תאריך: {dt or '—'} | מצלמה: {cam}{gps_s}")
        lines.append(f"  רזולוציה: {res} ({mp}MP)")
        if slot_pages:
            lines.append(f"  מיקומים בבוחר: {' · '.join(slot_pages)}")
        if persons:
            lines.append(f"  אנשים: {' · '.join(persons)}")
        if tags:
            lines.append(f"  תגיות CLIP: {' · '.join(tags)}")
        lines.append("")

    out = f"{PKG}/data/INDEX_IMAGES_ENRICHED.txt"
    with open(out, 'w', encoding='utf-8') as f:
        f.write('\n'.join(lines))
    print(f"  INDEX_IMAGES_ENRICHED.txt  ({len(lines)} שורות, {len(img_rows)} תמונות)")


def generate_videos_report():
    clip_tags  = load_json(f"{PKG}/data/video-clip-tags.json")
    vid_enrich = load_json(f"{PKG}/data/video-enrichment.json")

    vid_rows = {}
    with open(VID_CSV, newline='', encoding='utf-8-sig') as f:
        for row in csv.DictReader(f):
            stem = row['source_name'].rsplit('.',1)[0]
            vid_rows[f"VID-{stem}"] = row

    n_tx = sum(1 for v in vid_enrich.values() if v.get('text'))
    n_clip = len(clip_tags)

    lines = [
        f"# גלריית מדיה — אייל עמית | אינדקס סרטונים מועשר",
        f"# נוצר: {TODAY}",
        f"# {len(vid_rows)} סרטונים | תגיות CLIP: {n_clip} | תמלולי Whisper: {n_tx}",
        "",
    ]

    for vid_id, row in vid_rows.items():
        stem = vid_id[4:]
        ct_tags = clip_tags.get(vid_id, [])
        enrich  = vid_enrich.get(vid_id, {})
        w_tags  = enrich.get('tags', [])
        text    = enrich.get('text', '').strip()
        dur     = fmt_dur(row.get('duration_sec'))
        res     = row.get('orig_res','') or '—'
        dt      = (row.get('creation_time','') or '')[:10]
        all_tags = list(dict.fromkeys(ct_tags + w_tags))

        lines.append(vid_id)
        lines.append(f"  קובץ: {row.get('output_name',stem+'.mp4')} | אורך: {dur} | רזולוציה: {res}")
        lines.append(f"  תאריך: {dt or '—'}")
        if all_tags:
            lines.append(f"  תגיות: {' · '.join(all_tags)}")
        if text:
            snip = text[:100] + ('…' if len(text) > 100 else '')
            lines.append(f"  תמליל: {snip}")
        lines.append("")

    out = f"{PKG}/data/INDEX_VIDEOS_ENRICHED.txt"
    with open(out, 'w', encoding='utf-8') as f:
        f.write('\n'.join(lines))
    print(f"  INDEX_VIDEOS_ENRICHED.txt  ({len(vid_rows)} סרטונים)")


def generate_transcripts_report():
    vid_enrich = load_json(f"{PKG}/data/video-enrichment.json")
    vid_rows   = {}
    with open(VID_CSV, newline='', encoding='utf-8-sig') as f:
        for row in csv.DictReader(f):
            stem = row['source_name'].rsplit('.',1)[0]
            vid_rows[f"VID-{stem}"] = row

    entries = [(vid_id, e) for vid_id, e in vid_enrich.items()
               if e.get('text') and not e.get('silent')]
    entries.sort(key=lambda x: x[0])

    lines = [
        f"# תמלילי סרטונים — Whisper",
        f"# נוצר: {TODAY}",
        f"# {len(entries)} סרטונים עם דיבור",
        "",
    ]
    for vid_id, e in entries:
        row  = vid_rows.get(vid_id, {})
        dur  = fmt_dur(row.get('duration_sec'))
        dt   = (row.get('creation_time','') or '')[:10]
        tags = e.get('tags', [])
        text = e.get('text', '').strip()
        lines.append(f"=== {vid_id} | {dur} | {dt} ===")
        if tags:
            lines.append(f"[תגיות: {', '.join(tags)}]")
        lines.append(text)
        lines.append("")

    out = f"{PKG}/data/TRANSCRIPTS.txt"
    with open(out, 'w', encoding='utf-8') as f:
        f.write('\n'.join(lines))
    print(f"  TRANSCRIPTS.txt  ({len(entries)} תמלילים)")


def generate_persons_report():
    person_tags = load_json(f"{PKG}/data/person-tags.json")
    clip_tags   = load_json(f"{PKG}/data/image-clip-tags.json")

    from collections import defaultdict
    by_person = defaultdict(list)
    for img_id, persons in person_tags.items():
        for p in persons:
            tags = clip_tags.get(img_id, [])
            by_person[p].append((img_id, tags))

    lines = [
        f"# תמונות לפי אנשים",
        f"# נוצר: {TODAY}",
        f"# {len(person_tags)} תמונות ממויינות",
        "",
    ]
    for person, imgs in sorted(by_person.items()):
        lines.append(f"## {person}  ({len(imgs)} תמונות)")
        for img_id, tags in sorted(imgs):
            tag_s = ', '.join(tags) if tags else '—'
            lines.append(f"  {img_id}  |  {tag_s}")
        lines.append("")

    out = f"{PKG}/data/PERSONS.txt"
    with open(out, 'w', encoding='utf-8') as f:
        f.write('\n'.join(lines))
    print(f"  PERSONS.txt  ({len(person_tags)} תמונות)")


def write_readme():
    readme = f"""# גלריית מדיה — אייל עמית 2026
# נוצר: {TODAY}

## פתיחה
פתח את gallery.html בדפדפן (Chrome / Safari / Firefox).
אין צורך בשרת — הגלריה עובדת ישירות מהקובץ.

## תכולת החבילה
  gallery.html        — ממשק הגלריה
  images/             — 582 תמונות DOK-WEB (full + thumbs)
  video_thumbs/       — 1,454 פריימים מהסרטונים (CLIP-tagged)
  legacy/             — 315 תמונות ארכיון ישן (EA-XXXXXX)
  site/               — 48 תמונות אתר נוכחי
  videos/             — 1,459 סרטונים (דחוסים לאינטרנט — h264/720p)
  data/               — אינדקסים ותגיות (JSON + טקסט)

## קבצי data/ — לעבודה עם AI
  INDEX_IMAGES_ENRICHED.txt  — 582 תמונות עם כל התגיות
  INDEX_VIDEOS_ENRICHED.txt  — 1,459 סרטונים עם תגיות CLIP + תמלילים
  TRANSCRIPTS.txt            — תמלילי דיבור מלאים (Whisper)
  PERSONS.txt                — תמונות לפי אנשים (אייל, מוקש)
  image-clip-tags.json       — תגיות CLIP לכל תמונה
  video-clip-tags.json       — תגיות CLIP לכל סרטון
  video-enrichment.json      — תמלילי Whisper + תגיות

---
Team 110 · EyalAmit.co.il-2026
"""
    with open(f"{PKG}/README.txt", 'w', encoding='utf-8') as f:
        f.write(readme)
    print("  README.txt")


# ── 5. Build gallery HTML (package mode) ─────────────────────────────────────

def build_html():
    script = f"{PROJ}/_COMMUNICATION/team_110/build-media-suite.py"
    print("\nBuilding gallery.html (package mode)…")
    result = subprocess.run(
        [sys.executable, script, '--package'],
        cwd=PROJ, capture_output=True, text=True
    )
    for line in result.stdout.strip().split('\n'):
        print(f"  {line}")
    if result.returncode != 0:
        print("ERROR:", result.stderr[-500:])
        sys.exit(1)


# ── 6. Size report ────────────────────────────────────────────────────────────

def size_report():
    total = 0
    counts = {}
    for d in ['images', 'video_thumbs', 'legacy', 'site', 'videos', 'data']:
        dpath = f"{PKG}/{d}"
        if not os.path.isdir(dpath):
            continue
        n = 0
        sz = 0
        for fn in os.listdir(dpath):
            fp = f"{dpath}/{fn}"
            if os.path.isfile(fp):
                sz += os.path.getsize(fp)
                n += 1
        counts[d] = (n, sz)
        total += sz

    html_sz = os.path.getsize(f"{PKG}/gallery.html") if os.path.exists(f"{PKG}/gallery.html") else 0
    total += html_sz

    print(f"\n{'='*50}")
    print(f"  גלריה מוכנה: {PKG}")
    print(f"{'='*50}")
    print(f"  gallery.html     {html_sz//1024:>6} KB")
    for d, (n, sz) in counts.items():
        print(f"  {d+'/':15s}  {n:>5} קבצים  {sz//1024//1024:>4} MB")
    print(f"  {'TOTAL':15s}  {total//1024//1024:>5} MB")
    print(f"\n  לזיפ: zip -r gallery-eyal.zip gallery-eyal/")


# ── MAIN ──────────────────────────────────────────────────────────────────────

def main():
    print(f"\n=== package-gallery.py → {PKG} ===\n")

    print("1. Setting up directories…")
    setup_dirs()

    print("\n2. Copying media files…")
    copy_dok_images()
    copy_video_thumbs()
    copy_legacy()
    copy_site()
    copy_videos()

    print("\n3. Copying JSON data files…")
    copy_json_data()

    print("\n4. Generating text reports…")
    generate_images_report()
    generate_videos_report()
    generate_transcripts_report()
    generate_persons_report()
    write_readme()

    build_html()

    size_report()


if __name__ == '__main__':
    main()
