# קטלוג מדיה מלגסי — מדריך לאיגנטים

נוצר אוטומטית (קטלוג ראשוני): `2026-04-11T01:26:49.966955+00:00`  
עדכון תגיות עץ: ראה `meta.site_tree_enriched_utc` ב־`catalog.json`.

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
| `site_tree_tags` | מערך: שיוך היוריסטי לצמתי עץ (`node_id`, `title_he`, `slug`, `path_he`, `source`) |
| `technical` | sha256, phash, מימדים |

## תגיות עץ (`site_tree_tags`)

- נגזרות מ־**CLIP** (`site_hooks`) + מיפוי קבוע בקוד (`_communication/team_40/tools/site_tree_tags.py`) + רמזים בעברית/בנתיב לגסי (ספרים ספציפיים וכו').
- **אינן אמת מילולית** — רק נקודת פתיחה לשיוך תוכן ולסינון בגלריה.

## גלריה והעתקה ללוח

ב־`gallery.html`, לחיצה על כרטיס תמונה מעתיקה טקסט בפורמט:

```
EA-000042 | EA-000042.jpg
legacy: 2016/11/ASAF.jpg
```

ניתן להדביק כך לאיגנט או למסמך עבודה לזיהוי חד-משמעי של הקובץ.

## סינון

- נגזרות WordPress (`*-300x200.jpg` וכו') **לא נכללו** בסריקה.
- סף רלוונטיות בשימוש: **0.065** (ראה `meta.thresholds` ב-JSON).

## Hub (ממשק עבודה)

אחרי `python3 scripts/build_eyal_client_hub.py` מהשורש של מאגר `EyalAmit.co.il-2026`, הקטלוג מועתק ל־`hub/dist/files/team40/ea-legacy-curated/` ומקושר מכניסת Hub (`index.html`) ומרשימת החומרים (`deliverables.json`).  
לפיתוח מהיר בלי העתקת המדיה: `--skip-team40-legacy-media`.

## פריסה לשרת (FTP / rsync)

1. בנה Hub מקומית (ללא דילוג על המדיה אם רוצים חבילה מלאה).
2. סנכרן את תוכן `hub/dist/` לתיקיית ה-Hub בשרת (לפי `EYAL-HUB-SSOT-WORKFLOW.md` ונתיב הפריסה שלכם), כך ש־`files/team40/ea-legacy-curated/gallery.html` יישב תחת אותו בסיס URL כמו `index.html`.

דוגמה (התאימו משתמש, מארח ונתיב יעד):

```bash
rsync -av --delete ./hub/dist/files/team40/ea-legacy-curated/ \
  USER@HOST:path/to/ea-eyal-hub/files/team40/ea-legacy-curated/
```

## עדכון תגיות בלי CLIP

```bash
cd _communication/team_40/tools
python3 enrich_catalog_site_tree.py --catalog-dir ../ea-legacy-curated-2026-04-11
```

## המשך

שכבת VLM לתיאור בעברית: ראה `../legacy-media-index-50-2026-04-11/SEMANTIC-LAYER.md`.
