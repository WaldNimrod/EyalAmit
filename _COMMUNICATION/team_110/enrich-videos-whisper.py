#!/usr/bin/env python3
"""Transcribe DOK-WEB videos with Whisper and extract tags.

Output: hub/dist/files/team40/video-enrichment.json
  { "VID-BQSS0835": {"text": "...", "tags": [...], "lang": "he"}, ... }

Run: python3 _COMMUNICATION/team_110/enrich-videos-whisper.py
"""
import csv, json, os, re, subprocess, tempfile
from concurrent.futures import ThreadPoolExecutor, as_completed

# ── Config ────────────────────────────────────────────────────────────────────
PROJ       = "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026"
DOK        = f"{PROJ}/docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/DOK-WEB"
VID_DIR    = f"{DOK}/videos"
VID_CSV    = f"{DOK}/_INDEX_VIDEOS.csv"
OUT_JSON   = f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/video-enrichment.json"
MODEL_SIZE = "small"   # small = good Hebrew accuracy, CPU is faster than MPS for short clips
WORKERS    = 4         # CPU inference; 4 parallel processes
MAX_SEC    = 90        # cap audio sent to Whisper per video
LOGPROB_THRESH  = -1.0   # below = likely hallucination → discard
NO_SPEECH_THRESH = 0.5   # above = no real speech → discard

# Hebrew stopwords to skip when building tag list
HE_STOP = {
    'את','של','על','אל','אם','לא','כי','יש','זה','הוא','היא','הם','הן','אני','אנחנו',
    'אתה','את','אתם','הם','אנו','כך','גם','רק','עוד','כבר','מה','מי','איך','למה',
    'כן','לו','לה','לי','לנו','לכם','לכן','שם','כאן','כל','כן','פה','שם','אחד','שני',
    'ה','ו','ל','מ','ב','כ','ש','כש','אחרי','לפני','בין','עם','אבל','אלא','כאשר',
    'הזה','הזאת','האלה','הוא','היא','הם','הן','הטיפול','שיש','ואז','בזה','מזה','אותו',
    'אותה','אותם','אלו','אלה','עכשיו','היום','הדבר','הדברים','בו','בה','בהם',
    'שאנחנו','שאני','שיש','שזה','שהוא','שהיא','שהם',
}

# Domain boosted terms — if found, definitely a tag
DOMAIN_BOOST = {
    'נשימה','דיגרידו','נגינה','קערות','מדיטציה','טיפול','סאונד','סאונדהילינג','שיטה',
    'גוף','נפש','רוח','אנרגיה','ריפוי','מוזיקה','צליל','הרמוניה','תודעה','רגיעה',
    'ספר','הרצאה','הדרכה','מוקש','אייל','ג\'ונגל','ויבס',
}


# Domain keyword patterns (Hebrew + common variants)
DOMAIN_KEYWORDS = [
    ('נשימה',        'נשימה'),
    ("דיג'רידו",     'דיגרידו'),
    ('דיגרידו',      'דיגרידו'),
    ('סאונד',        'סאונדהילינג'),
    ('קערות',        'קערות שירה'),
    ('מדיטציה',      'מדיטציה'),
    ('ריפוי',        'ריפוי'),
    ('טיפול',        'טיפול'),
    ('גוף',          'גוף'),
    ('נפש',          'נפש'),
    ('נגינה',        'נגינה'),
    ('נכירה',        'נכירות'),
    ('נחירה',        'נחירות'),
    ('נחירות',       'נחירות'),
    ('כאב',          'כאב'),
    ('חרדה',         'חרדה'),
    ('שינה',         'שינה'),
    ('ילדים',        'ילדים'),
    ('ספר',          'ספרים'),
    ('הרצאה',        'הרצאה'),
    ('הדרכה',        'הדרכה'),
    ('מוסיקה',       'מוסיקה'),
    ('מוזיקה',       'מוסיקה'),
    ('תדרים',        'תדרים'),
    ('רטטים',        'רטטים'),
    ('צלילים',       'סאונדהילינג'),
    ('אנרגיה',       'אנרגיה'),
    ('רוחניות',      'רוחניות'),
    ('שלווה',        'שלווה'),
    ('רגיעה',        'רגיעה'),
    ('מוקש',         'מוקש'),
]

def extract_tags(text: str, lang: str, max_tags: int = 8) -> list:
    if not text:
        return []
    seen = {}
    tl = text.lower()
    for pattern, label in DOMAIN_KEYWORDS:
        if pattern in tl or pattern in text:
            seen[label] = seen.get(label, 0) + 1
    return list(seen.keys())[:max_tags]


def transcribe_video(row: dict, model) -> tuple:
    stem = row['source_name'].rsplit('.', 1)[0]
    vid_id = f"VID-{stem}"
    fn = row['output_name']
    dur = float(row['duration_sec']) if row.get('duration_sec') else 0.0
    src = os.path.join(VID_DIR, fn)

    if not os.path.exists(src):
        return (vid_id, None)

    with tempfile.NamedTemporaryFile(suffix='.mp3', delete=False) as tmp:
        tmp_path = tmp.name

    try:
        # Extract audio (cap at MAX_SEC seconds)
        t_end = min(dur, MAX_SEC) if dur > 0 else MAX_SEC
        cmd = [
            'ffmpeg', '-y', '-loglevel', 'error',
            '-i', src, '-t', str(t_end),
            '-ar', '16000', '-ac', '1', '-q:a', '0',
            tmp_path
        ]
        subprocess.run(cmd, check=True, capture_output=True, timeout=60)

        # Transcribe
        result = model.transcribe(
            tmp_path,
            language='he',
            task='transcribe',
            fp16=False,
            verbose=False,
            no_speech_threshold=0.6,
            logprob_threshold=-1.0,
        )
        text = result.get('text', '').strip()
        lang = result.get('language', 'he')
        segs = result.get('segments', [])
        if segs:
            avg_lp = sum(s.get('avg_logprob', -99) for s in segs) / len(segs)
            avg_ns = sum(s.get('no_speech_prob', 1.0) for s in segs) / len(segs)
        else:
            avg_lp, avg_ns = -99.0, 1.0

        # Discard hallucinations
        if avg_lp < LOGPROB_THRESH or avg_ns > NO_SPEECH_THRESH or not text:
            return (vid_id, {'text': '', 'tags': [], 'lang': lang, 'silent': True})

        tags = extract_tags(text, lang)
        return (vid_id, {'text': text, 'tags': tags, 'lang': lang})
    except Exception as e:
        return (vid_id, {'text': '', 'tags': [], 'lang': 'he', 'err': str(e)[:80]})
    finally:
        try:
            os.unlink(tmp_path)
        except Exception:
            pass


def main():
    import whisper, torch

    print(f"Loading Whisper '{MODEL_SIZE}' model…")
    device = 'cpu'   # CPU is 3x faster than MPS for short clips (tested)
    print(f"Device: {device}")
    model = whisper.load_model(MODEL_SIZE, device=device)

    # Load existing results to skip already-done
    existing = {}
    if os.path.exists(OUT_JSON):
        with open(OUT_JSON, encoding='utf-8') as f:
            existing = json.load(f)
        print(f"Resuming — {len(existing)} already done")

    with open(VID_CSV, newline='', encoding='utf-8-sig') as f:
        rows = list(csv.DictReader(f))

    todo = [r for r in rows if f"VID-{r['source_name'].rsplit('.',1)[0]}" not in existing]
    print(f"To process: {len(todo)} / {len(rows)}")

    done = skip = err = 0
    for i, row in enumerate(todo, 1):
        vid_id, data = transcribe_video(row, model)
        if data is None:
            skip += 1
        elif data.get('err'):
            err += 1
        else:
            done += 1
        if data is not None:
            existing[vid_id] = data

        if i % 50 == 0 or i == len(todo):
            # Save progress
            with open(OUT_JSON, 'w', encoding='utf-8') as f:
                json.dump(existing, f, ensure_ascii=False, indent=2)
            print(f"  {i}/{len(todo)}  done={done} skip={skip} err={err}  saved")

    with open(OUT_JSON, 'w', encoding='utf-8') as f:
        json.dump(existing, f, ensure_ascii=False, separators=(',', ':'))
    print(f"\nDone. {len(existing)} videos transcribed → {OUT_JSON}")


if __name__ == '__main__':
    main()
