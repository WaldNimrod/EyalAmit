#!/usr/bin/env python3
"""Build DOK-WEB catalogs + comprehensive media gallery HTML.

Outputs:
  _COMMUNICATION/team_110/build/catalogs/ea-dok-web/catalog-images.json
  _COMMUNICATION/team_110/build/catalogs/ea-dok-web/catalog-videos.json
  _COMMUNICATION/team_110/build/media-gallery.html
"""
import csv, json, os, sys
from PIL import Image
import numpy as np

PROJ            = "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026"
SLOTS_JSON      = f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/slot-candidates.json"
PERSONS_JSON    = f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/person-tags.json"
CLIP_TAGS_JSON     = f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/image-clip-tags.json"
VID_CLIP_TAGS_JSON = f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/video-clip-tags.json"
VID_ENRICH_JSON    = f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/video-enrichment.json"
DOK  = f"{PROJ}/docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/DOK-WEB"
IMG_CSV  = f"{DOK}/_INDEX_IMAGES.csv"
VID_CSV  = f"{DOK}/_INDEX_VIDEOS.csv"
LEGACY   = f"{PROJ}/_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/catalog.json"
THEME    = f"{PROJ}/site/wp-content/themes/ea-eyalamit/assets/images"
OUT_DIR  = f"{PROJ}/_COMMUNICATION/team_110/build/catalogs/ea-dok-web"
GALLERY  = f"{PROJ}/_COMMUNICATION/team_110/build/media-gallery.html"


# ── Quality + metadata helpers ──────────────────────────────────────────────

def analyze_quality(img_path):
    """Return 0–1 visual quality score from a thumbnail (PIL)."""
    try:
        img = Image.open(img_path).convert('L')
        arr = np.array(img, dtype=float)
        if arr.size == 0:
            return 0.5
        h = arr[:-2, :] - 2 * arr[1:-1, :] + arr[2:, :]
        v = arr[:, :-2] - 2 * arr[:, 1:-1] + arr[:, 2:]
        sharpness = min(1.0, (np.var(h) + np.var(v)) * 0.5 / 250.0)
        mean_b = float(np.mean(arr)) / 255.0
        if mean_b < 0.1 or mean_b > 0.97:   exposure = 0.2
        elif mean_b < 0.25 or mean_b > 0.85: exposure = 0.65
        else:                                 exposure = 1.0
        return round(0.65 * sharpness + 0.35 * exposure, 3)
    except Exception:
        return 0.5


def metadata_tags(row):
    """Derive basic tags from CSV metadata (no AI required)."""
    tags = []
    w = int(row.get('orig_width') or 0)
    h = int(row.get('orig_height') or 0)
    if h > 0:
        ar = w / h
        if ar < 0.85:   tags.append('פורטרט')
        elif ar > 1.15: tags.append('לנדסקייפ')
        else:           tags.append('ריבוע')
    cam = row.get('camera', '').lower()
    if 'iphone' in cam:  tags.append('iPhone')
    elif cam:            tags.append(cam.split()[0])
    dt = (row.get('date_taken') or '')
    if len(dt) >= 7:
        try:
            m = int(dt[5:7])
            seasons = {3:'אביב',4:'אביב',5:'אביב',6:'קיץ',7:'קיץ',8:'קיץ',
                       9:'סתיו',10:'סתיו',11:'סתיו',12:'חורף',1:'חורף',2:'חורף'}
            if m in seasons: tags.append(seasons[m])
        except Exception:
            pass
    try:
        lat = float(row.get('gps_lat') or 0)
        lon = float(row.get('gps_lon') or 0)
        if 31 < lat < 34 and 34 < lon < 36:
            tags.append('ישראל')
    except Exception:
        pass
    mp = float(row.get('megapixels') or 0)
    if mp > 15: tags.append('רזולוציה גבוהה')
    return tags


# ── A. Parse DOK-WEB images ─────────────────────────────────────────────────

def parse_images():
    entries = []
    with open(IMG_CSV, newline='', encoding='utf-8-sig') as f:
        rows = list(csv.DictReader(f))
    total = len(rows)
    for i, row in enumerate(rows):
        stem = row['source_name'].rsplit('.', 1)[0]
        w = int(row['orig_width'])  if row['orig_width']  else 0
        h = int(row['orig_height']) if row['orig_height'] else 0
        ar = round(w / h, 3) if h > 0 else 1.0
        dt_raw = row.get('date_taken', '').strip()
        dt = dt_raw[:10].replace(':', '-') if dt_raw else ''
        mp = float(row['megapixels']) if row['megapixels'] else 0.0
        sm_path = os.path.join(DOK, row['small_file'])
        q = analyze_quality(sm_path)
        t = metadata_tags(row)
        if (i + 1) % 100 == 0:
            print(f"  analyzed {i+1}/{total}...")
        entries.append({
            'id': f'DOK-{stem}',
            'lg': row['large_file'],
            'sm': row['small_file'],
            'ar': ar,
            'dt': dt,
            'mp': round(mp, 2),
            'q':  q,
            't':  t,
        })
    return entries


# ── B. Parse DOK-WEB videos ─────────────────────────────────────────────────

SEASONS = {3:'אביב',4:'אביב',5:'אביב',6:'קיץ',7:'קיץ',8:'קיץ',
           9:'סתיו',10:'סתיו',11:'סתיו',12:'חורף',1:'חורף',2:'חורף'}

def video_tags(row):
    tags = []
    dur = float(row['duration_sec']) if row.get('duration_sec') else 0.0
    if dur > 0:
        if dur < 30:   tags.append('קצר')
        elif dur < 180: tags.append('בינוני')
        else:          tags.append('ארוך')
    res = row.get('orig_res', '')
    if res and 'x' in res:
        try:
            w, h = map(int, res.lower().split('x'))
            if h > w: tags.append('פורטרט')
            else:     tags.append('לנדסקייפ')
        except Exception:
            pass
    loc = row.get('location', '').strip()
    if loc:
        # ISO 6709: +30.93+035.07+335/
        import re
        m = re.match(r'([+-]\d+\.?\d*)([+-]\d+\.?\d*)', loc)
        if m:
            try:
                lat, lon = float(m.group(1)), float(m.group(2))
                if 29 < lat < 34 and 34 < lon < 36:
                    tags.append('ישראל')
            except Exception:
                pass
    ct = row.get('creation_time', '').strip()
    if len(ct) >= 7:
        try:
            month = int(ct[5:7])
            if month in SEASONS: tags.append(SEASONS[month])
        except Exception:
            pass
    return tags

def parse_videos():
    entries = []
    with open(VID_CSV, newline='', encoding='utf-8-sig') as f:
        for row in csv.DictReader(f):
            stem = row['source_name'].rsplit('.', 1)[0]
            ct   = row.get('creation_time', '').strip()
            dt   = ct[:10] if len(ct) >= 10 else ''
            dur  = float(row['duration_sec']) if row['duration_sec'] else 0.0
            entries.append({
                'id':  f'VID-{stem}',
                'fn':  row['output_name'],
                'dur': round(dur, 1),
                'res': row.get('orig_res', ''),
                'dt':  dt,
                't':   video_tags(row),
            })
    return entries


# ── C. Slim legacy catalog ───────────────────────────────────────────────────

NODE_PAGE = {
    'st-home': 'home', 'st-eyal-hub': 'about', 'st-svc-treatment': 'treatment',
    'st-svc-sound': 'sound-healing', 'st-svc-lessons': 'lessons',
    'st-blog': 'blog', 'st-books': 'books', 'st-books-muzeh': 'books',
    'st-method': 'method', 'st-mokesh': 'mokesh',
}

def slim_legacy():
    with open(LEGACY) as f:
        raw = json.load(f)
    entries = raw.get('entries', raw) if isinstance(raw, dict) else raw
    result = []
    for e in entries:
        if not e.get('public_id'):
            continue
        tc   = e.get('semantic_content', {})
        tech = e.get('technical', {})
        tags = e.get('site_tree_tags', [])
        pages = list(dict.fromkeys(
            NODE_PAGE[t['node_id']] for t in tags
            if t.get('node_id') and t['node_id'] in NODE_PAGE
        ))
        result.append({
            'id': e['public_id'],
            'fn': e.get('media_filename', e['public_id'] + '.jpg'),
            'ar': round(tech.get('aspect_ratio', 1.0), 3),
            't':  tc.get('topics_he_union', [])[:5],
            'h':  tc.get('site_hooks_union', [])[:5],
            'pg': pages[0] if pages else 'general',
            's':  round(e.get('relevance_score', 0.5), 3),
        })
    return result


# ── D. Scan theme images ─────────────────────────────────────────────────────

EXCLUDE_THM = {'ea-logo.jpg','ea-logo-mark.png','ea-arcs.png','ea-logo.jpeg'}
EXCLUDE_STEMS = {'logo','arcs','logo-mark','palette','icon'}

def scan_theme():
    result = []
    for root, _, files in os.walk(THEME):
        sub = os.path.relpath(root, THEME)
        if sub == '.': sub = ''
        for fn in sorted(files):
            if not fn.lower().endswith(('.jpg','.jpeg','.png')):
                continue
            if fn in EXCLUDE_THM:
                continue
            stem = fn.rsplit('.',1)[0].lower()
            if any(x in stem for x in EXCLUDE_STEMS):
                continue
            result.append({
                'id':  f'THM-{fn.rsplit(".",1)[0]}',
                'fn':  fn,
                'sub': sub,
            })
    return result


# ── E. Load picker slot-candidates index ────────────────────────────────────

def load_slot_candidates():
    if not os.path.exists(SLOTS_JSON):
        return {}
    with open(SLOTS_JSON, encoding='utf-8') as f:
        return json.load(f)


def load_person_tags():
    if not os.path.exists(PERSONS_JSON):
        return {}
    with open(PERSONS_JSON, encoding='utf-8') as f:
        return json.load(f)


def load_clip_tags():
    if not os.path.exists(CLIP_TAGS_JSON):
        return {}
    with open(CLIP_TAGS_JSON, encoding='utf-8') as f:
        return json.load(f)


def load_video_clip_tags():
    if not os.path.exists(VID_CLIP_TAGS_JSON):
        return {}
    with open(VID_CLIP_TAGS_JSON, encoding='utf-8') as f:
        return json.load(f)


def load_video_enrichment():
    if not os.path.exists(VID_ENRICH_JSON):
        return {}
    with open(VID_ENRICH_JSON, encoding='utf-8') as f:
        return json.load(f)


# ── F. Generate gallery HTML ─────────────────────────────────────────────────

PAGE_LABELS = {
    'general': 'כללי', 'home': 'דף הבית', 'about': 'אודות',
    'method': 'השיטה', 'treatment': 'טיפול', 'sound-healing': 'סאונדהילינג',
    'lessons': 'שיעורים', 'blog': 'בלוג', 'books': 'ספרים', 'mokesh': 'מוקש',
}

def build_gallery(leg, dok_imgs, dok_vids, thm, slot_cands, person_tags, vid_enrich, pkg_mode=False):
    # Base paths — different for server mode vs portable package mode
    DOK_SRC = "docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/DOK-WEB/"
    if pkg_mode:
        b_js_block = (
            "const B = {\n"
            "  leg: './legacy/',\n"
            "  dok: './images/',\n"
            "  vid: './videos/',\n"
            "  thm: './site/',\n"
            "  vt:  './video_thumbs/',\n"
            "};\n"
            "const ABS = B;"   # absPath() fallback — Finder button not shown in pkg
        )
        finder_btn = ''
    else:
        proj_path = '/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026'
        b_js_block = (
            "const B = {\n"
            "  leg: 'files/team40/ea-legacy-curated/media/',\n"
            f"  dok: '../../{DOK_SRC}',\n"
            f"  vid: '../../{DOK_SRC}videos/',\n"
            "  thm: '../../site/wp-content/themes/ea-eyalamit/assets/images/',\n"
            f"  vt:  '../../{DOK_SRC}video_thumbs/',\n"
            "};\n"
            f"const PROJ = '{proj_path}';\n"
            "const ABS = {\n"
            f"  leg: PROJ + '/_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/media/',\n"
            f"  dok: PROJ + '/{DOK_SRC}',\n"
            f"  vid: PROJ + '/{DOK_SRC}videos/',\n"
            f"  thm: PROJ + '/site/wp-content/themes/ea-eyalamit/assets/images/',\n"
            "};"
        )
        finder_btn = '<button class="btn-finder" onclick="revealInFinder()">📂 פתח ב-Finder</button>'

    leg_j      = json.dumps(leg,          ensure_ascii=False, separators=(',',':'))
    dok_j      = json.dumps(dok_imgs,     ensure_ascii=False, separators=(',',':'))
    vid_j      = json.dumps(dok_vids,     ensure_ascii=False, separators=(',',':'))
    thm_j      = json.dumps(thm,          ensure_ascii=False, separators=(',',':'))
    slots_j    = json.dumps(slot_cands,   ensure_ascii=False, separators=(',',':'))
    persons_j  = json.dumps(person_tags,  ensure_ascii=False, separators=(',',':'))
    venrich_j  = json.dumps(vid_enrich,   ensure_ascii=False, separators=(',',':'))
    n_transcribed = sum(1 for v in vid_enrich.values() if v.get('text'))

    page_opts = ''.join(
        f'<option value="{k}">{v}</option>'
        for k,v in PAGE_LABELS.items()
    )

    html = f"""<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>גלריית מדיה — אייל עמית 2026</title>
<link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;700&display=swap" rel="stylesheet">
<style>
:root{{--terra:#a44e2b;--sand:#d8c7b5;--ink:#2e2b28;--cream:#f5f0ea;--muted:#8a7e74;--bg:#faf7f3}}
*{{box-sizing:border-box;margin:0;padding:0}}
body{{font-family:Heebo,sans-serif;background:var(--bg);color:var(--ink);min-height:100vh}}
header{{background:var(--ink);color:#fff;padding:20px 24px 16px;display:flex;align-items:baseline;gap:16px;flex-wrap:wrap}}
header h1{{font-size:1.5rem;font-weight:700}}
header .sub{{color:var(--sand);font-size:.85rem}}
header .stats{{margin-right:auto;font-size:.8rem;color:var(--sand)}}
.toolbar{{background:#fff;border-bottom:1px solid var(--sand);padding:10px 20px;display:flex;gap:8px;align-items:center;flex-wrap:wrap;position:sticky;top:0;z-index:10}}
.toolbar input{{flex:1;min-width:180px;max-width:300px;padding:7px 12px;border:1px solid var(--sand);border-radius:6px;font-family:inherit;font-size:.9rem;background:var(--cream)}}
.toolbar select{{padding:7px 10px;border:1px solid var(--sand);border-radius:6px;font-family:inherit;font-size:.85rem;background:var(--cream);cursor:pointer;max-width:160px}}
.toolbar select:disabled{{opacity:.4;cursor:default}}
.btn-tags{{padding:6px 12px;border:1px solid var(--sand);border-radius:6px;font-family:inherit;font-size:.82rem;background:var(--cream);cursor:pointer;white-space:nowrap;transition:.15s}}
.btn-tags.on{{background:var(--terra);color:#fff;border-color:var(--terra)}}
.tabs{{display:flex;gap:0;border-bottom:2px solid var(--sand);background:#fff;padding:0 20px}}
.tab{{padding:10px 18px;border:none;background:none;font-family:inherit;font-size:.9rem;cursor:pointer;color:var(--muted);border-bottom:3px solid transparent;margin-bottom:-2px;transition:.15s}}
.tab.active{{color:var(--terra);border-bottom-color:var(--terra);font-weight:500}}
.tab b{{font-size:.78rem;background:var(--sand);color:var(--ink);border-radius:10px;padding:1px 7px;margin-right:5px}}
.grid{{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:10px;padding:16px 20px}}
.card{{background:#fff;border-radius:8px;overflow:hidden;cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,.08);transition:.15s;position:relative}}
.card:hover{{box-shadow:0 3px 12px rgba(0,0,0,.15);transform:translateY(-2px)}}
.card img{{width:100%;aspect-ratio:1;object-fit:cover;display:block;background:var(--sand)}}
.card .vid-thumb{{width:100%;aspect-ratio:1;background:var(--ink);display:flex;flex-direction:column;align-items:center;justify-content:center;color:#fff;gap:6px;position:relative;overflow:hidden}}
.card .vid-thumb img{{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}}
.vplay{{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:36px;height:36px;border-radius:50%;background:rgba(0,0,0,.55);display:flex;align-items:center;justify-content:center;font-size:14px;pointer-events:none}}
.vdur-o{{position:absolute;bottom:5px;left:5px;background:rgba(0,0,0,.62);color:#fff;font-size:.65rem;padding:1px 5px;border-radius:3px;font-family:monospace;direction:ltr;pointer-events:none}}
.card .vicon{{font-size:2rem}}
.card .vdur{{font-size:.75rem;color:var(--sand)}}
.card .info{{padding:7px 8px 8px}}
.card .cid{{font-size:.68rem;font-family:monospace;color:var(--terra);font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;direction:ltr;text-align:left}}
.card .ctitle{{font-size:.75rem;color:var(--ink);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:500}}
.card .cmeta{{font-size:.67rem;color:var(--muted);margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}}
.card .ctags{{display:none;flex-wrap:wrap;gap:3px;margin-top:5px}}
.card .ctag{{background:var(--cream);border:1px solid var(--sand);border-radius:3px;padding:1px 5px;font-size:.62rem;color:var(--ink);cursor:pointer}}
.card .ctag:hover{{background:var(--sand)}}
body.tags-on .card .ctags{{display:flex}}
.empty{{text-align:center;padding:60px 20px;color:var(--muted);font-size:1rem}}
/* Modal */
.modal{{display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:100;align-items:center;justify-content:center}}
.modal.open{{display:flex}}
.mi{{background:#fff;border-radius:12px;max-width:860px;width:calc(100% - 32px);max-height:90vh;overflow:auto;display:flex;flex-direction:column}}
.mi-img{{flex:0 0 auto;max-height:55vh;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#111;border-radius:12px 12px 0 0}}
.mi-img img{{max-height:55vh;max-width:100%;object-fit:contain}}
.mi-img video{{max-height:55vh;max-width:100%;background:#000;display:block}}
.mi-body{{padding:18px 20px 20px;display:flex;gap:12px;flex-direction:column}}
.mi-id{{font-family:monospace;font-size:1rem;color:var(--terra);font-weight:700;direction:ltr;text-align:left}}
.mi-title{{font-size:.95rem;color:var(--ink);font-weight:600}}
.mi-meta{{font-size:.85rem;color:var(--muted);line-height:1.7}}
.mi-tags{{display:flex;flex-wrap:wrap;gap:6px;margin-top:4px}}
.mi-tag{{background:var(--cream);border:1px solid var(--sand);border-radius:4px;padding:2px 8px;font-size:.75rem;color:var(--ink);cursor:pointer}}
.mi-tag:hover{{background:var(--sand)}}
.mi-actions{{display:flex;gap:10px;align-items:center;flex-wrap:wrap}}
.btn-copy{{background:var(--terra);color:#fff;border:none;border-radius:6px;padding:8px 16px;font-family:inherit;font-size:.85rem;cursor:pointer;font-weight:500}}
.btn-copy:hover{{opacity:.9}}
.btn-close{{background:none;border:1px solid var(--sand);border-radius:6px;padding:8px 14px;font-family:inherit;font-size:.85rem;cursor:pointer;color:var(--muted)}}
.copy-ok{{color:green;font-size:.8rem;display:none}}
.btn-finder{{background:none;border:1px solid var(--sand);border-radius:6px;padding:8px 14px;font-family:inherit;font-size:.85rem;cursor:pointer;color:var(--ink)}}
.btn-finder:hover{{background:var(--sand)}}
.pcount{{position:absolute;top:5px;left:5px;background:var(--terra);color:#fff;font-size:.58rem;padding:1px 5px;border-radius:8px;font-weight:600;z-index:2;direction:ltr}}
.mi-quality{{display:flex;align-items:center;gap:8px;font-size:.82rem;color:var(--muted)}}
.mi-qbar{{flex:1;height:5px;background:var(--sand);border-radius:3px;overflow:hidden;max-width:140px}}
.mi-qfill{{height:100%;border-radius:3px}}
.mi-qnum{{font-family:monospace;font-size:.78rem;min-width:34px}}
.mi-slabel{{font-size:.75rem;color:var(--muted)}}
.mi-slots{{display:flex;flex-wrap:wrap;gap:6px;margin-top:4px}}
.mi-slot{{background:var(--cream);border:1px solid var(--sand);border-radius:4px;padding:3px 9px;font-size:.74rem;text-decoration:none;color:var(--ink);cursor:pointer;transition:.12s}}
.mi-slot:hover{{background:var(--terra);color:#fff;border-color:var(--terra)}}
.mi-img img{{cursor:zoom-in}}
.mi-img img:-webkit-full-screen{{object-fit:contain;background:#000;max-height:100vh;max-width:100vw;cursor:zoom-out}}
.mi-img img:fullscreen{{object-fit:contain;background:#000;max-height:100vh;max-width:100vw;cursor:zoom-out}}
.fhint{{font-size:.7rem;color:var(--muted);text-align:center;padding:3px 0 0}}
#toast{{display:none;position:fixed;bottom:28px;left:50%;transform:translateX(-50%);background:rgba(46,43,40,.92);color:#fff;padding:9px 22px;border-radius:8px;z-index:200;font-size:.82rem;pointer-events:none;white-space:nowrap}}
/* Modal nav */
.mi-nav{{display:flex;align-items:center;justify-content:space-between;padding:8px 12px 0;gap:8px}}
.btn-nav{{background:none;border:1px solid var(--sand);border-radius:6px;padding:6px 14px;font-family:inherit;font-size:.85rem;cursor:pointer;color:var(--muted);transition:.12s}}
.btn-nav:hover:not(:disabled){{background:var(--terra);color:#fff;border-color:var(--terra)}}
.btn-nav:disabled{{opacity:.28;cursor:default}}
.mi-counter{{font-size:.75rem;color:var(--muted);white-space:nowrap;direction:ltr}}
/* Person badge */
.person-badge{{display:inline-block;background:#4a6fa5;color:#fff;border-radius:4px;padding:1px 7px;font-size:.68rem;font-weight:600;margin-left:3px}}
.mi-person{{display:flex;flex-wrap:wrap;gap:5px;align-items:center}}
.mi-person-badge{{background:#4a6fa5;color:#fff;border-radius:5px;padding:3px 10px;font-size:.78rem;font-weight:600}}
/* Transcript */
.card .csnip{{font-size:.65rem;color:var(--muted);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-style:italic}}
.mi-transcript{{background:var(--cream);border-radius:6px;padding:10px 14px;font-size:.82rem;line-height:1.7;color:var(--ink);max-height:120px;overflow-y:auto;margin-top:4px;direction:rtl}}
</style>
</head>
<body>
<header>
  <h1>גלריית מדיה</h1>
  <span class="sub">אייל עמית · 2026</span>
  <span class="stats">315 ארכיון · 582 תמונות חדשות · {len(dok_vids):,} סרטונים ({n_transcribed} תומללו) · {len(thm)} אתר נוכחי</span>
</header>

<div class="toolbar">
  <input type="search" id="srch" placeholder="חיפוש לפי מזהה, שם קובץ, תאריך, תגית, שם..." oninput="doFilter()">
  <select id="pg" onchange="doFilter()">
    <option value="">כל הדפים</option>
    {page_opts}
  </select>
  <select id="tagFilter" onchange="doFilter()" style="display:none">
    <option value="">כל התגיות</option>
  </select>
  <select id="personFilter" onchange="doFilter()" style="display:none">
    <option value="">כל האנשים</option>
  </select>
  <button class="btn-tags" id="btnTags" onclick="toggleTags()" style="display:none">תגיות</button>
</div>

<div class="tabs">
  <button class="tab active" onclick="setTab('leg')">ארכיון ישן <b>{len(leg)}</b></button>
  <button class="tab" onclick="setTab('dok')">תמונות חדשות <b>{len(dok_imgs)}</b></button>
  <button class="tab" onclick="setTab('vid')">סרטונים <b>{len(dok_vids):,}</b></button>
  <button class="tab" onclick="setTab('thm')">אתר נוכחי <b>{len(thm)}</b></button>
</div>

<div id="grid" class="grid"></div>
<div id="empty" class="empty" style="display:none">אין תוצאות</div>
<div id="toast"></div>

<div id="modal" class="modal" onclick="if(event.target===this)closeModal()">
  <div class="mi">
    <div class="mi-nav">
      <button class="btn-nav" id="m-prev" onclick="navModal(-1)">→ הקודם</button>
      <span class="mi-counter" id="m-counter"></span>
      <button class="btn-nav" id="m-next" onclick="navModal(1)">הבא ←</button>
      <button class="btn-close" onclick="closeModal()" style="margin-right:auto">✕</button>
    </div>
    <div class="mi-img">
      <img id="m-img" src="" alt="" onerror="this.style.display='none'" onclick="toggleFullscreen(this)">
      <video id="m-vid" controls preload="none" style="display:none"></video>
    </div>
    <p class="fhint" id="m-fhint">לחץ על התמונה למסך מלא</p>
    <div class="mi-body">
      <div class="mi-id" id="m-id"></div>
      <div class="mi-title" id="m-title"></div>
      <div class="mi-person" id="m-person" style="display:none"></div>
      <div class="mi-meta" id="m-meta"></div>
      <div class="mi-quality" id="m-quality" style="display:none">
        <span>איכות:</span>
        <div class="mi-qbar"><div class="mi-qfill" id="m-qfill"></div></div>
        <span class="mi-qnum" id="m-qnum"></span>
      </div>
      <div class="mi-tags" id="m-tags"></div>
      <div id="m-transcript-wrap" style="display:none">
        <div class="mi-slabel">תמליל:</div>
        <div class="mi-transcript" id="m-transcript"></div>
      </div>
      <div id="m-slots-wrap" style="display:none">
        <div class="mi-slabel" id="m-slabel"></div>
        <div class="mi-slots" id="m-slots"></div>
      </div>
      <div class="mi-actions">
        <button class="btn-copy" onclick="copyId()">העתק מזהה</button>
        {finder_btn}
        <span class="copy-ok" id="copy-ok">✓ הועתק</span>
      </div>
    </div>
  </div>
</div>

<script>
// ── DATA ──────────────────────────────────────────────────────────────────────
const DATA = {{
  leg: {leg_j},
  dok: {dok_j},
  vid: {vid_j},
  thm: {thm_j},
}};
// image-id → [{{slotId, page, section, role}}]
const PICKER = {slots_j};
// image-id → ["אייל","מוקש",...]
const PERSONS = {persons_j};
// video-id → {{text, tags, lang, silent}}
const VENRICH = {venrich_j};

// ── BASE PATHS ────────────────────────────────────────────────────────────────
{b_js_block}

const PAGE_HE = {{
  general:'כללי', home:'דף הבית', about:'אודות',
  method:'השיטה', treatment:'טיפול', 'sound-healing':'סאונדהילינג',
  lessons:'שיעורים', blog:'בלוג', books:'ספרים', mokesh:'מוקש',
}};
const HE_MO = ['','ינו׳','פבר׳','מרץ','אפר׳','מאי','יוני','יולי','אוג׳','ספט׳','אוק׳','נוב׳','דצמ׳'];

// ── STATE ─────────────────────────────────────────────────────────────────────
let curTab = 'leg';
let curFiltered = [];
let modalIdx = -1;
let modalId = null;
let modalAbsPath = null;
let tagsOn = false;

// ── HELPERS ───────────────────────────────────────────────────────────────────
function fmtDate(dt) {{
  if (!dt) return '';
  const p = dt.split('-');
  if (p.length < 2) return dt;
  return (HE_MO[parseInt(p[1])]||'') + ' ' + p[0];
}}
function fmtDur(sec) {{
  const m = Math.floor(sec/60);
  const s = String(Math.floor(sec%60)).padStart(2,'0');
  return m + ':' + s;
}}
function qualityOf(tab, item) {{
  if (tab === 'leg') return item.s || null;
  if (tab === 'dok') return item.q || null;
  return null;
}}
function qColor(q) {{
  if (q >= 0.70) return '#4caf50';
  if (q >= 0.45) return '#ff9800';
  return '#e53935';
}}

function titleFor(tab, item) {{
  if (tab === 'leg') return (item.t && item.t.length) ? item.t[0] : (PAGE_HE[item.pg]||item.pg);
  if (tab === 'dok') return fmtDate(item.dt) || item.id.replace('DOK-','');
  if (tab === 'vid') return fmtDur(item.dur);
  if (tab === 'thm') return item.fn.replace(/\.[^.]+$/,'').replace(/[-_]/g,' ');
  return '';
}}
function imgSrc(tab, item) {{
  if (tab === 'leg') return B.leg + item.fn;
  if (tab === 'dok') return B.dok + item.sm;
  if (tab === 'thm') return B.thm + (item.sub ? item.sub + '/' : '') + item.fn;
  return '';
}}
function fullSrc(tab, item) {{
  if (tab === 'leg') return B.leg + item.fn;
  if (tab === 'dok') return B.dok + item.lg;
  if (tab === 'thm') return B.thm + (item.sub ? item.sub + '/' : '') + item.fn;
  return '';
}}

// ── CARD ──────────────────────────────────────────────────────────────────────
function cardHTML(tab, item) {{
  const id    = item.id;
  const title = titleFor(tab, item);
  const persons = PERSONS[id] || [];
  const venr = VENRICH[id] || null;
  const tags = [...(item.t||[])];

  let thumb;
  if (tab === 'vid') {{
    const dur = fmtDur(item.dur);
    const stem = id.replace('VID-','');
    const tSrc = B.vt + stem + '.jpg';
    thumb = `<div class="vid-thumb"><img src="${{tSrc}}" alt="" onerror="this.style.display='none'"><div class="vplay">▶</div><div class="vdur-o">${{dur}}</div></div>`;
  }} else {{
    thumb = `<img src="${{imgSrc(tab,item)}}" alt="${{id}}" loading="lazy">`;
  }}
  let meta = '';
  if (tab === 'leg') meta = (PAGE_HE[item.pg]||item.pg) + ' · ' + item.ar;
  else if (tab === 'dok') meta = (item.dt||'—') + ' · ' + item.ar;
  else if (tab === 'vid') meta = (item.dt||'—') + ' · ' + (item.res||'—');
  else if (tab === 'thm') meta = item.sub || 'root';

  const snipHtml = (tab === 'vid' && venr && venr.text)
    ? `<div class="csnip">${{venr.text.slice(0,60)}}…</div>`
    : '';

  const q = qualityOf(tab, item);
  const qdot = q !== null ? `<span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:${{qColor(q)}};margin-right:3px;vertical-align:middle"></span>` : '';
  const slots = PICKER[id] || [];
  const pcountHtml = slots.length ? `<div class="pcount">${{slots.length}}</div>` : '';
  const personHtml = persons.map(p=>`<span class="person-badge">${{p}}</span>`).join('');

  const tagsHtml = tags.length
    ? `<div class="ctags">${{tags.map(t=>`<span class="ctag" onclick="filterByTag(event,'${{t}}')">${{t}}</span>`).join('')}}</div>`
    : '';
  return `<div class="card" onclick="openModal('${{tab}}','${{id}}')">${{pcountHtml}}${{thumb}}<div class="info"><div class="cid">${{qdot}}${{id}}</div><div class="ctitle">${{title}}${{personHtml}}</div><div class="cmeta">${{meta}}</div>${{snipHtml}}${{tagsHtml}}</div></div>`;
}}

// ── RENDER ────────────────────────────────────────────────────────────────────
function render(items) {{
  curFiltered = items;
  const grid  = document.getElementById('grid');
  const empty = document.getElementById('empty');
  if (!items.length) {{ grid.innerHTML = ''; empty.style.display = ''; return; }}
  empty.style.display = 'none';
  grid.innerHTML = items.map(it => cardHTML(curTab, it)).join('');
}}

// ── FILTER ────────────────────────────────────────────────────────────────────
function doFilter() {{
  const q      = document.getElementById('srch').value.trim().toLowerCase();
  const pg     = document.getElementById('pg').value;
  const tag    = document.getElementById('tagFilter').value;
  const person = document.getElementById('personFilter').value;
  let items = DATA[curTab];

  if (q) {{
    items = items.filter(it => {{
      const persons = PERSONS[it.id] || [];
      const venr = VENRICH[it.id];
      const tx = venr ? (venr.text || '') : '';
      const s = [it.id, it.fn||it.lg||'', it.dt||'',
                 ...(it.t||[]), ...(it.h||[]), ...persons, tx].join(' ').toLowerCase();
      return s.includes(q);
    }});
  }}
  if (pg  && curTab === 'leg') items = items.filter(it => it.pg === pg);
  if (tag) items = items.filter(it => (it.t||[]).includes(tag) || (it.h||[]).includes(tag));
  if (person) items = items.filter(it => (PERSONS[it.id]||[]).includes(person));
  render(items);
}}

function filterByTag(e, tag) {{
  e.stopPropagation();
  document.getElementById('tagFilter').value = tag;
  doFilter();
}}

// ── TABS ──────────────────────────────────────────────────────────────────────
function setTab(t) {{
  curTab = t;
  document.querySelectorAll('.tab').forEach((el,i) => {{
    el.classList.toggle('active', ['leg','dok','vid','thm'][i] === t);
  }});
  const isLeg = (t === 'leg');
  const hasTags = (t === 'leg' || t === 'dok' || t === 'vid');
  document.getElementById('pg').disabled = !isLeg;
  document.getElementById('tagFilter').style.display = hasTags ? '' : 'none';
  document.getElementById('btnTags').style.display   = hasTags ? '' : 'none';
  document.getElementById('personFilter').style.display = (t !== 'thm') ? '' : 'none';
  if (!isLeg) {{ document.getElementById('pg').value = ''; }}
  // rebuild tag dropdown for current tab
  rebuildTagDropdown(t);
  doFilter();
}}

// ── TAGS TOGGLE ───────────────────────────────────────────────────────────────
function toggleTags() {{
  tagsOn = !tagsOn;
  document.body.classList.toggle('tags-on', tagsOn);
  const btn = document.getElementById('btnTags');
  btn.textContent = tagsOn ? 'הסתר תגיות' : 'תגיות';
  btn.classList.toggle('on', tagsOn);
}}

// ── TAG DROPDOWN ─────────────────────────────────────────────────────────────
const _tagCache = {{}};
function rebuildTagDropdown(tab) {{
  const sel = document.getElementById('tagFilter');
  const prev = sel.value;
  if (_tagCache[tab]) {{
    sel.innerHTML = _tagCache[tab];
    sel.value = prev;
    return;
  }}
  const freq = {{}};
  (DATA[tab]||[]).forEach(it => {{
    [...(it.t||[]), ...(it.h||[])].forEach(tag => {{ freq[tag] = (freq[tag]||0) + 1; }});
  }});
  const sorted = Object.entries(freq).sort((a,b) => b[1]-a[1]);
  let html = '<option value="">כל התגיות</option>';
  sorted.forEach(([tag, count]) => {{
    html += `<option value="${{tag}}">${{tag}} (${{count}})</option>`;
  }});
  _tagCache[tab] = html;
  sel.innerHTML = html;
  sel.value = prev;
}}

function initPersonDropdown() {{
  const all = new Set();
  Object.values(PERSONS).forEach(arr => arr.forEach(p => all.add(p)));
  const sel = document.getElementById('personFilter');
  all.forEach(p => {{
    const opt = document.createElement('option');
    opt.value = p; opt.textContent = p;
    sel.appendChild(opt);
  }});
}}


// ── FULLSCREEN + FINDER ───────────────────────────────────────────────────────
function absPath(tab, item) {{
  if (tab === 'leg') return ABS.leg + item.fn;
  if (tab === 'dok') return ABS.dok + item.lg;
  if (tab === 'vid') return ABS.vid + item.fn;
  if (tab === 'thm') return ABS.thm + (item.sub ? item.sub + '/' : '') + item.fn;
  return '';
}}

function showToast(msg, ms) {{
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.style.display = 'block';
  clearTimeout(t._tid);
  t._tid = setTimeout(() => {{ t.style.display = 'none'; }}, ms||2800);
}}

function toggleFullscreen(el) {{
  const isFs = document.fullscreenElement || document.webkitFullscreenElement;
  if (isFs) {{
    (document.exitFullscreen || document.webkitExitFullscreen).call(document);
  }} else {{
    const fn = el.requestFullscreen || el.webkitRequestFullscreen;
    if (fn) fn.call(el);
  }}
}}

async function revealInFinder() {{
  if (!modalAbsPath) return;
  try {{
    const ctrl = new AbortController();
    setTimeout(() => ctrl.abort(), 1500);
    const r = await fetch('http://127.0.0.1:7772/?path=' + encodeURIComponent(modalAbsPath), {{signal: ctrl.signal}});
    if (r.ok) {{ showToast('✓ נפתח ב-Finder'); return; }}
  }} catch(e) {{}}
  // Fallback: copy path
  try {{
    await navigator.clipboard.writeText(modalAbsPath);
    showToast('הנתיב הועתק — ב-Finder: ⌘⇧G להדבקה');
  }} catch(e) {{
    showToast(modalAbsPath, 6000);
  }}
}}

// ── MODAL ─────────────────────────────────────────────────────────────────────
function navModal(dir) {{
  const newIdx = modalIdx + dir;
  if (newIdx < 0 || newIdx >= curFiltered.length) return;
  const it = curFiltered[newIdx];
  openModalAt(curTab, it.id, newIdx);
}}

function openModal(tab, id) {{
  const idx = curFiltered.findIndex(x => x.id === id);
  openModalAt(tab, id, idx);
}}

function openModalAt(tab, id, idx) {{
  const item = DATA[tab].find(x => x.id === id);
  if (!item) return;
  modalId = id;
  modalIdx = idx;
  modalAbsPath = absPath(tab, item);

  const imgEl = document.getElementById('m-img');
  const vidEl = document.getElementById('m-vid');
  if (tab === 'vid') {{
    imgEl.style.display = 'none';
    vidEl.style.display = 'block';
    vidEl.src = B.vid + item.fn;
    document.getElementById('m-fhint').style.display = 'none';
  }} else {{
    vidEl.style.display = 'none';
    imgEl.style.display = '';
    imgEl.src = fullSrc(tab, item);
    document.getElementById('m-fhint').style.display = '';
  }}

  document.getElementById('m-id').textContent = id;
  document.getElementById('m-title').textContent = titleFor(tab, item);

  let meta = '';
  if (tab === 'leg') {{
    meta = `עמוד: ${{PAGE_HE[item.pg]||item.pg}} · יחס: ${{item.ar}}`;
  }} else if (tab === 'dok') {{
    meta = `תאריך: ${{item.dt||'—'}} · יחס: ${{item.ar}} · ${{item.mp}}MP`;
  }} else if (tab === 'vid') {{
    meta = `תאריך: ${{item.dt||'—'}} · אורך: ${{fmtDur(item.dur)}} · רזולוציה: ${{item.res||'—'}}`;
  }} else if (tab === 'thm') {{
    meta = `קובץ: ${{item.fn}} · תיקייה: ${{item.sub||'root'}}`;
  }}
  document.getElementById('m-meta').textContent = meta;

  // quality bar
  const q = qualityOf(tab, item);
  const qWrap = document.getElementById('m-quality');
  if (q !== null) {{
    document.getElementById('m-qfill').style.cssText = `width:${{Math.round(q*100)}}%;background:${{qColor(q)}}`;
    document.getElementById('m-qnum').textContent = q.toFixed(2);
    qWrap.style.display = '';
  }} else {{
    qWrap.style.display = 'none';
  }}

  // tags
  const tagsEl = document.getElementById('m-tags');
  tagsEl.innerHTML = '';
  const allTags = [...(item.t||[]), ...(item.h||[])];
  allTags.forEach(tag => {{
    const span = document.createElement('span');
    span.className = 'mi-tag';
    span.textContent = tag;
    span.onclick = () => {{ closeModal(); filterByTag({{stopPropagation:()=>{{}}}}, tag); }};
    tagsEl.appendChild(span);
  }});

  // transcript
  const txWrap = document.getElementById('m-transcript-wrap');
  const txEl   = document.getElementById('m-transcript');
  const venr = VENRICH[id];
  if (venr && venr.text) {{
    txEl.textContent = venr.text;
    txWrap.style.display = '';
  }} else {{
    txWrap.style.display = 'none';
  }}

  // picker slots
  const slots = PICKER[id] || [];
  const sWrap  = document.getElementById('m-slots-wrap');
  const sEl    = document.getElementById('m-slots');
  const sLabel = document.getElementById('m-slabel');
  sEl.innerHTML = '';
  if (slots.length) {{
    sLabel.textContent = `מיקומים בבוחר (${{slots.length}}):`;
    slots.forEach(s => {{
      const a = document.createElement('a');
      a.className = 'mi-slot';
      a.href = `image-picker.html#sc-${{s.slotId}}`;
      a.target = '_blank';
      a.textContent = `${{s.page}} — ${{s.role||s.section}}`;
      sEl.appendChild(a);
    }});
    sWrap.style.display = '';
  }} else {{
    sWrap.style.display = 'none';
  }}

  // person badges
  const personEl = document.getElementById('m-person');
  const persons = PERSONS[id] || [];
  if (persons.length) {{
    personEl.innerHTML = persons.map(p => `<span class="mi-person-badge">${{p}}</span>`).join('');
    personEl.style.display = '';
  }} else {{
    personEl.style.display = 'none';
  }}

  // nav counter
  const total = curFiltered.length;
  document.getElementById('m-counter').textContent = total > 0 ? `${{idx+1}} / ${{total}}` : '';
  document.getElementById('m-prev').disabled = (idx <= 0);
  document.getElementById('m-next').disabled = (idx < 0 || idx >= total - 1);

  document.getElementById('copy-ok').style.display = 'none';
  document.getElementById('modal').classList.add('open');
}}

function closeModal() {{
  if (document.fullscreenElement || document.webkitFullscreenElement) {{
    (document.exitFullscreen || document.webkitExitFullscreen).call(document);
  }}
  const vidEl = document.getElementById('m-vid');
  vidEl.pause(); vidEl.src = ''; vidEl.style.display = 'none';
  document.getElementById('m-img').src = ''; document.getElementById('m-img').style.display = '';
  document.getElementById('modal').classList.remove('open');
  modalId = null; modalAbsPath = null;
}}

function copyId() {{
  if (!modalId) return;
  navigator.clipboard.writeText(modalId).then(() => {{
    const ok = document.getElementById('copy-ok');
    ok.style.display = 'inline';
    setTimeout(() => {{ ok.style.display = 'none'; }}, 2000);
  }}).catch(() => {{
    const ta = document.createElement('textarea');
    ta.value = modalId;
    document.body.appendChild(ta); ta.select(); document.execCommand('copy'); document.body.removeChild(ta);
    document.getElementById('copy-ok').style.display = 'inline';
    setTimeout(() => {{ document.getElementById('copy-ok').style.display = 'none'; }}, 2000);
  }});
}}

document.addEventListener('keydown', e => {{
  if (e.key === 'Escape') closeModal();
  if (!document.getElementById('modal').classList.contains('open')) return;
  if (e.key === 'ArrowLeft')  navModal(1);
  if (e.key === 'ArrowRight') navModal(-1);
}});

// ── INIT ──────────────────────────────────────────────────────────────────────
rebuildTagDropdown('leg');
initPersonDropdown();
setTab('leg');
</script>
</body>
</html>"""
    return html


# ── MAIN ─────────────────────────────────────────────────────────────────────

def main():
    print("Parsing DOK-WEB images CSV...")
    dok_imgs = parse_images()
    print(f"  {len(dok_imgs)} images")

    print("Parsing DOK-WEB videos CSV...")
    dok_vids = parse_videos()
    print(f"  {len(dok_vids)} videos")

    print("Slimming legacy catalog...")
    leg = slim_legacy()
    print(f"  {len(leg)} legacy entries with public_id")

    print("Scanning theme images...")
    thm = scan_theme()
    print(f"  {len(thm)} theme images")

    os.makedirs(OUT_DIR, exist_ok=True)

    img_out = f"{OUT_DIR}/catalog-images.json"
    with open(img_out, 'w', encoding='utf-8') as f:
        json.dump(dok_imgs, f, ensure_ascii=False, indent=2)
    print(f"Wrote {img_out}")

    vid_out = f"{OUT_DIR}/catalog-videos.json"
    with open(vid_out, 'w', encoding='utf-8') as f:
        json.dump(dok_vids, f, ensure_ascii=False, indent=2)
    print(f"Wrote {vid_out}")

    print("Loading slot-candidates index...")
    slot_cands = load_slot_candidates()
    print(f"  {len(slot_cands)} images with picker slots")

    print("Loading person tags...")
    person_tags = load_person_tags()
    print(f"  {len(person_tags)} tagged images")

    print("Loading CLIP image tags...")
    clip_tags = load_clip_tags()
    print(f"  {len(clip_tags)} CLIP-tagged images")
    # Merge CLIP tags into DOK images (append, no duplicates)
    for img in dok_imgs:
        ct = clip_tags.get(img['id'], [])
        if ct:
            existing_t = set(img['t'])
            img['t'] = img['t'] + [t for t in ct if t not in existing_t]

    print("Loading video CLIP tags...")
    vid_clip = load_video_clip_tags()
    print(f"  {len(vid_clip)} CLIP-tagged videos")
    # Merge CLIP visual tags into video entries
    for vid in dok_vids:
        vc = vid_clip.get(vid['id'], [])
        if vc:
            existing_t = set(vid.get('t', []))
            vid['t'] = vid.get('t', []) + [t for t in vc if t not in existing_t]

    print("Loading video enrichment (Whisper)...")
    vid_enrich = load_video_enrichment()
    n_tx = sum(1 for v in vid_enrich.values() if v.get('text'))
    print(f"  {len(vid_enrich)} processed, {n_tx} with transcript")
    # Merge Whisper tags into video entries (appended after CLIP tags)
    for vid in dok_vids:
        ve = vid_enrich.get(vid['id'])
        if ve and ve.get('tags'):
            existing_t = set(vid.get('t', []))
            vid['t'] = vid.get('t', []) + [t for t in ve['tags'] if t not in existing_t]

    pkg_mode = '--package' in sys.argv
    out_path = GALLERY
    if pkg_mode:
        pkg_dir = f"{PROJ}/_COMMUNICATION/team_110/build/gallery-eyal"
        os.makedirs(pkg_dir, exist_ok=True)
        out_path = f"{pkg_dir}/gallery.html"

    print(f"Generating gallery HTML {'(package mode)' if pkg_mode else ''}...")
    html = build_gallery(leg, dok_imgs, dok_vids, thm, slot_cands, person_tags, vid_enrich,
                         pkg_mode=pkg_mode)
    with open(out_path, 'w', encoding='utf-8') as f:
        f.write(html)
    size_kb = os.path.getsize(out_path) // 1024
    print(f"Wrote {out_path} ({size_kb} KB)")

    print("\nDone.")


if __name__ == '__main__':
    main()
