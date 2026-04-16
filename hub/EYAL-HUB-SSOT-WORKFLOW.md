# נוהל — ממשק לאייל (view) ↔ SSOT (JSON)

**תאריך עדכון:** 2026-04-03 (Hub Standard v1.1 — מקור יחיד `hub/`)  
**נוהל ארגוני קנוני:** [`docs/CLIENT_HUB_STANDARD_v1.md`](../docs/CLIENT_HUB_STANDARD_v1.md) · **נספח Eyal:** [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../docs/CLIENT_HUB_APPENDIX_EYAL.md)

**פלייבוק עדכון קצר (חסכון בטוקנים):** [`hub/HUB-CANONICAL-UPDATE-PLAYBOOK.md`](HUB-CANONICAL-UPDATE-PLAYBOOK.md) — רצעדים קבועים לפני כל פריסה.

**מיקום ממשק (מקור בנייה):** **`hub/`** בשורש המאגר — `hub/data/`, `hub/src/`, פלט `hub/dist/`.  
**SSOT:** **`hub/ssot/`** — `manifest.json`, `responses/*.json`.

---

## 1. הגדרות

| מונח | משמעות |
|------|--------|
| **View** | קבצי HTML/CSS/JS ב־`hub/dist/` לאחר `build_eyal_client_hub.py` ופריסת FTP. |
| **SSOT** | JSON תחת `hub/ssot/responses/` לאחר **קליטה** (`ingest_eyal_feedback_json.py`). |
| **מזהה החלטה** | מזהה יציב `D-EYAL-*` ב־`hub/data/decisions.json`, בייצוא JSON, וב־SSOT. (מזהי `Q-*` היסטוריים — ראו נספח Eyal.) |

**סתירה:** אם יש פער בין view ל־SSOT — **SSOT גובר**; להריץ בנייה מחדש אחרי קליטה.

---

## 2. מתי מעדכנים את הממשק (פריסה)

- שינוי ב־`hub/data/*.json` (החלטות, משימות, רודמאפ, עדכונים, דליברבלס).
- אחרי קליטת ייצוא JSON ל־`hub/ssot/responses/`.
- שינוי ב־`hub/src/assets/` (CSS/JS).

**חובה — סוכני AI / אוטומציה:** אחרי שינוי רלוונטי ב־Hub, **הסוכן מריץ בעצמו** בנייה + פריסת FTP (לא להפנות את נימרוד להריץ), ומדווח חזרה עם **אישור פריסה** ו־**`generatedAt`** מפלט הבנייה או מ־`hub/dist/metadata.json`. ראו גם [`AGENTS.md`](../AGENTS.md) §Client Hub.

```bash
cd EyalAmit.co.il-2026
python3 scripts/build_eyal_client_hub.py
python3 scripts/ftp_publish_eyal_client_hub.py --dry-run
python3 scripts/ftp_publish_eyal_client_hub.py
```

**Prune (ברירת מחדל):** `ftp_publish_eyal_client_hub.py` **מוחק בשרת** קבצים תחת נתיב ה־Hub שאינם קיימים ב־`hub/dist/` — כדי שלא יישארו עמודים/נכסים מגרסה ישנה מול הלקוח. לביטול: `--no-prune`.

**מראה קבצי Word ב־hub:** `python3 scripts/build_eyal_client_hub.py --mirror-docs` (או `--mirror-docx`) מעתיק `.docx` / `.txt` / `.pdf` מ־`to-eyal/` ו־`from-eyal/` ל־`dist/files/…`.

---

## 3. איך מושכים עדכונים מהממשק ל־SSOT

1. אייל פותח **`tasks.html`** בפריסה, פותח כל החלטה, ממלא ולוחץ **ייצוא תשובות** (קובץ JSON אחד).
2. הצוות מקבל את הקובץ (מייל / Drive / `incoming/` אם הופעל).
3. קליטה:

```bash
python3 scripts/ingest_eyal_feedback_json.py path/to/export.json --by "שם מקלט"
```

4. הסקריפט בודק `schemaVersion`, `exportType` (`eyal-feedback`), **`respondent` לא ריק**, ושכל `answers[].id` קיים ב־`hub/data/decisions.json`; כותב ל־`hub/ssot/responses/` ומעדכן `manifest.json`.
5. **Commit** למאגר.

**חובה לפני ייצוא:** כל מזהה החלטה חדש (`D-EYAL-*`) חייב להופיע ב־`hub/data/decisions.json` לפני שאייל מייצא — אחרת קליטת JSON תיכשל.

---

## 3.1 ייצואי JSON נוספים (עץ אתר · קליטת תוכן)

מעבר ל־`eyal-feedback` מ־`tasks.html`:

| עמוד | `exportType` | אחסון מומלץ אחרי סקירה |
|------|----------------|-------------------------|
| `site-tree.html` | `eyal-site-tree-feedback` | `docs/project/eyal-ceo-submissions-and-responses/from-eyal/` עם שם מתאריך + נושא, ו/או `hub/ssot/responses/` אם סוכם למזג לתהליך SSOT |
| `content-intake.html` | `eyal-page-content-intake` | כנ״ל — קובץ לכל עמוד או אצווה לפי מה שנוח לצוות |

**אין העלאת קבצים כבדים בדפדפן** — תוכן מלא ב־Drive; בטופס רק שם קובץ או קישור.

שלב אופציונלי עתידי: סקריפט ingest שממזג `eyal-site-tree-feedback` לעדכון `hub/data/site-tree.json` — רק אחרי סקירת צוות 100.

---

## 4. ולידציה

- ייצוא: `schemaVersion`, `exportType`, `exportTimestamp`, `respondent`, `answers[]` עם `id` ולפחות `choice` או `notes`.
- קליטה נכשלת אם מזהה החלטה לא מוכר, חסר משיב, או תשובה ריקה.

---

## 5. פריסה ואבטחה

- נתיב: **`UPRESS_EYAL_HUB_PATH`** ב־`local/.env.upress` — [`UPRESS_WORDPRESS_STANDARD_v2.md`](../docs/project/UPRESS_WORDPRESS_STANDARD_v2.md).
- **מטמון uPress אחרי FTP:** **EzCache** — `POST …/ezcache/v1/cache` עם purge (REST + Application Password); **Varnish** — החרגת קידומת נתיב ה־Hub בפאנל לפי מאמרי התמיכה. פירוט מלא וקישורים: [`CLIENT_HUB_APPENDIX_EYAL.md`](../docs/CLIENT_HUB_APPENDIX_EYAL.md) §«פריסת Hub, EzCache ו־Varnish».
- **סטייג'ינג:** תעודת SSL ציבורית תקינה **לא** מותקנת כמו בפרודקשן — לבדיקת Hub בדפדפן או ב־MCP השתמשו ב־**`http://<host>/<UPRESS_EYAL_HUB_PATH>/…`**. בפרודקשן — רק **HTTPS** תקין. פירוט: [`CLIENT_HUB_APPENDIX_EYAL.md`](../docs/CLIENT_HUB_APPENDIX_EYAL.md).
- **אין** להפעיל Basic Auth על צפיית ה־Hub כדרישה לשקיפות מול הלקוח (מנדט v1.1).
- `<meta name="robots" content="noindex, nofollow">`; `robots.txt` ב־`dist/`.

---

## 6. מסמכי Word פורמליים

ה־Hub **אינו** מחליף docx/PDF. קישורים: [`EYAL-CORRESPONDENCE-CANON.md`](../docs/project/eyal-ceo-submissions-and-responses/EYAL-CORRESPONDENCE-CANON.md).
