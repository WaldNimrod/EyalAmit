---
title: אינדקס מדיה לגסי — סבב 50 קבצים
from: team_40
date: 2026-04-11
---

# אינדקס JSON — 50 קבצי מדיה

## מה נכלל

| רכיב | תיאור |
|------|--------|
| `mirror/` | עותק של 50 קבצים מ־`eyalamit.co.il-legacy/wp-content/uploads/` (מבנה תיקיות זהה) |
| `index.json` | גרסה 2 — מטא-דאטה מבוססת פיקסלים בלבד |
| `index.v3.json` | **מומלץ** — כולל **`semantic_content`** (CLIP zero-shot: נושאים בעברית + `site_hooks`) |
| `build_index.py` | סקריפט לשחזור / הרצה מחדש (אותו seed = אותה דגימה) |
| `semantic_enrich_clip.py` | הוספת שכבת תוכן ויזואלי (CLIP) — יוצר `index.v3.json` |
| `SEMANTIC-LAYER.md` | תיאור שכבות ניתוח (פיקסלים → CLIP → VLM אופציונלי) |
| `requirements-semantic.txt` | torch + open_clip (התקנה חד-פעמית) |
| `query_index.py` | חיפוש טקסטואלי מהיר בשורת פקודה |

## סיווג רשומות

- **`scan_primary` (25):** נבחרו אקראית מתוך כל ה־uploads (≥20KB), אחרי החרגת 10 קבצי ה־POC הקודם, עם **העדפה** לנתיבים **ללא** מילות מפתח תוכן (מוזה/ספרים/מותג) בשם הקובץ — מתאים לדרישת «לא בממשק הציבורי / לא במיפוי אצלנו». כל תיאור הסוכן מבוסס **ניתוח פיקסלים בלבד**.
- **`content_context` (25):** הועדפו קבצים עם רמזים בשם הנתיב (regex תוכן), והשלמה אקראית. כאן מותרת הערה שמזכירה את שם הקובץ.

## מבנה `agent` ברשומה

- `tags` — תגיות באנגלית (ערכי סיווג לסינון).
- `tag_groups_he` — אותן קבוצות עם מפתחות בעברית (כיוון, בהירות, צבע דומיננטי, וכו׳).
- `notes_he` — משפט הסבר בעברית.
- `notes_source` — תמיד `pixel_statistics_v1` (סטטיסטיקות PIL/NumPy, ללא מודל שפה חיצוני).

## חיפוש

### נושאים / התאמה לעמוד (גרסה 3)

ב־`index.v3.json` לכל רשומה יש `semantic_content.top_labels` (פרומפט אנגלי + ציון), `topics_he_union`, `site_hooks_union` (למשל `site:muzeh`, `site:didgeridoo` ב־`search.keywords`).

```bash
# דוגמה: jq — כל התמונות עם הוק «ספרים»
jq '.entries[] | select(.semantic_content.topics_he_union[]? == "ספרים") | .legacy_relative' index.v3.json
```

### סקריפט מקומי

```bash
cd _communication/team_40/legacy-media-index-50-2026-04-11
python3 query_index.py landscape
python3 query_index.py ספרים
python3 query_index.py site:muzeh
```

### jq (אם מותקן)

כל הרשומות עם `source_class` מסוים:

```bash
jq '.entries[] | select(.agent.source_class=="scan_primary") | .legacy_relative' index.json
```

### אינדקס מובנה

בתוך `index.json`:

- `meta.search.keyword_index` — מיפוי מילת מפתח → רשימת `entry_id`.
- לכל רשומה: `search.keywords`, `search.facet_snapshot`, ו־`search_blob` לחיפוש substring.

## הרצה מחדש

```bash
python3 build_index.py \
  --legacy "/path/to/eyalamit.co.il-legacy/wp-content/uploads" \
  --mirror "./mirror" \
  --out-json "./index.json" \
  --copy --seed 42

pip install -r requirements-semantic.txt
python3 semantic_enrich_clip.py --index index.json --mirror mirror --out index.v3.json
```

## הרחבה עתידית

להחליף את שכבת `pixel_statistics_v1` ב־**VLM מקומי** (Ollama) או **CLIP** — לשמור אותו שדה `notes_source` כדי לדעת מאיפה הגיע התיאור.
