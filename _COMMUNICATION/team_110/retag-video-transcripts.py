#!/usr/bin/env python3
"""Re-extract tags from already-saved Whisper transcripts (no re-transcription).
Run after improving extract_tags in enrich-videos-whisper.py.
"""
import json, sys, os

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

PROJ     = "/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026"
OUT_JSON = f"{PROJ}/_COMMUNICATION/team_110/build/enrichment/video-enrichment.json"

if not os.path.exists(OUT_JSON):
    print("No enrichment file yet.")
    sys.exit(0)

with open(OUT_JSON, encoding='utf-8') as f:
    data = json.load(f)

updated = 0
for vid_id, entry in data.items():
    if entry.get('text') and not entry.get('silent'):
        new_tags = extract_tags(entry['text'], entry.get('lang', 'he'))
        if new_tags != entry.get('tags'):
            entry['tags'] = new_tags
            updated += 1

with open(OUT_JSON, 'w', encoding='utf-8') as f:
    json.dump(data, f, ensure_ascii=False, indent=2)

with_text = sum(1 for v in data.values() if v.get('text'))
print(f"Re-tagged {updated} entries. Total done: {len(data)}, with speech: {with_text}")
