# Client Hub — נספח פרויקט Eyal Amit 2026

מסמך זה משלים את [`CLIENT_HUB_STANDARD_v1.md`](CLIENT_HUB_STANDARD_v1.md) **בלבד** לפרויקט `EyalAmit.co.il-2026`. אין לערוך את גוף הנוהל הנעול.

## מבנה מאגר

- **שורש Hub:** `hub/` (לא תחת `docs/project/eyal-client-hub/`).
- **נתונים:** `hub/data/` — `decisions.json`, `tasks.json`, `roadmap.json`, `updates.json`, `deliverables.json` (הרחבה F-14), **`eyal-pending.json`** (אופציונלי): רשימת «מה חסר» עם בעלים (`nimrod` | `eyal` | `dev`) ו־`hubAction` — נטען בבנייה לכרטיס **מסלול לאייל** ולטבלה ב־**`tasks.html`** (בכניסה רק תמונת מצב כללית + הפניה). קשר למסמך המפתח של אייל (`eyal_amit_dev_brief_GEO_AEO_SEO.md`) ולדלטה מול SSOT תחת `_communication/team_100/`.
- **SSOT:** `hub/ssot/` — `manifest.json`, `responses/`.
- **פלט בנייה:** `hub/dist/` (לא ב-Git).

## מזהי החלטות — מיגרציה מ־`questions.json`

- לפני v1.1 השתמשו במזהים `Q-EYAL-*`.
- מ־v1.1 ואילך **`D-EYAL-*`** (למשל `Q-EYAL-HOME-01` → `D-EYAL-HOME-01`).
- **ייצואי ingest ישנים** ב־`hub/ssot/responses/` שמפנים ל־`Q-*` אינם נספרים אוטומטית כטעונים ב־UI החדש; לשימור ארכיון בלבד. ייצוא חדש חייב להשתמש במזהי `D-*` מתוך `decisions.json`.

## `pending.html` (תאימות לאחור)

- בבנייה נוצר `pending.html` עם **הפניה** ל־`tasks.html` (meta refresh) כדי לא לשבור קישורים ישנים.

## דליברבלס ומוקאפים (F-14)

- `deliverables.json` — רשימת קישורים לקבצים תחת `files/` כאשר מופעלת בנייה עם mirror.
- **מוקאפים:** מועתקים מ־`docs/project/eyal-ceo-submissions-and-responses/to-eyal/_shared-assets` ל־`dist/mockups/` (כמו בבנייה הקודמת).

## ארגומנטי בנייה

- `--mirror-docs` — מעתיק מסמכים מ־`to-eyal` / `from-eyal` (docx, txt, pdf) ל־`dist/files/`.
- `--mirror-docx` — **alias** ל־`--mirror-docs` (תאימות לסקריפטים ומסמכים קודמים).

## דפים נוספים (עץ · קליטת תוכן)

- **`site-tree.html`** — עץ IA מ־`hub/data/site-tree.json`: הערות כלליות ולפי צומת, קישורי legacy/מוקאפים, טבלת legacy לא ממופה, ייצוא **`eyal-site-tree-feedback`**.
- **`content-intake.html`** — בחירת עמוד, שדות דינמיים מ־`page-templates.json`, בלוק Drive (שם קובץ/קישור), ייצוא **`eyal-page-content-intake`**.
- **מוקאפי תבניות:** `dist/mockups/page-types/` (מועתקים מ־`hub/src/mockups/page-types/` בבנייה).

## ייצוא משוב

- `exportType` להחלטות: **`eyal-feedback`** (`tasks.html`) — קליטה: `ingest_eyal_feedback_json.py`, שדה **`respondent`** חובה.
- `exportType` לעץ: **`eyal-site-tree-feedback`** — JSON ידני לצוות / `from-eyal` / (אופציונלי) `hub/ssot/responses/` אחרי סקירה; אין סקריפט קליטה אוטומטי חובה בשלב זה.
- `exportType` לקליטת תוכן לעמוד: **`eyal-page-content-intake`** — אותו נוהל העברה כמו לעיל.
- `defaultRespondent` ב־UI: **Eyal Amit**

## צפייה ציבורית

- ה-Hub מיועד ל**צפייה ללא Basic Auth** (לפי מנדט v1.1). אין להמליץ על סיסמה לתיקיית ה-Hub לצורך צפייה בלבד; אבטחה ברמת שרת אחרת — בלי לחסום את מטרת השקיפות.

## סטייג'ינג מול פרודקשן — HTTPS ותעודות

**כלל פרויקט (uPress sandbox):** בסטייג'ינג **אין** תעודת SSL ציבורית תקינה כמו באתר החי. **`https://`** על hostname הסטייג'ינג עלול להיכשל ב־curl (`certificate problem` / `expired`) או להציג אזהרה בדפדפן.

- **בדיקות Hub / אתר בסטייג'ינג:** השתמשו ב־**`http://`** — לדוגמה  
  `http://<staging-host>/<UPRESS_EYAL_HUB_PATH>/index.html`  
  (ברירת מחדל לנתיב Hub: `ea-eyal-hub`).
- **פרודקשן:** רק **`https://`** עם תעודה מותקנת ותקינה על הדומיין הסופי — **מעבר מלא ל‑SSL** על כל ענפי הפרויקט (אתר, Hub, REST, תיעוד); ראו [`ROADMAP-2026.md`](project/ROADMAP-2026.md) ו־[`LAUNCH-CHECKLIST-2026.md`](project/LAUNCH-CHECKLIST-2026.md).
- **FTP:** מדיניות TLS — ראו [`UPRESS_WORDPRESS_STANDARD_v2.md`](project/UPRESS_WORDPRESS_STANDARD_v2.md) §2.1; `UPRESS_FTP_USE_TLS` ב־`local/.env.upress`.
- **תיעוד ארגוני נוסף:** [`_communication/team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../_communication/team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md), [`STAGING-CHANNEL-STATUS-2026-03-31.md`](../_communication/team_20/STAGING-CHANNEL-STATUS-2026-03-31.md).

### פריסת Hub, EzCache ו־Varnish (מטמון uPress)

בפרויקט Eyal **מטמון הדפים** מנוהל לפי תיעוד uPress והארגון: **Varnish** (שכבת מטמון בפאנל) ו־**EzCache** — תוסף WordPress **רשמי** לפי הספק לניקוי מטמון ולניהול Varnish (לא תוסף קאש דפים צד־ג׳ נפרד). מקור מחייב לפרשנות: [`M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md`](../_communication/team_100/M2-UPRESS-BUNDLED-PLUGINS-ARCHITECTURE-2026-04-02.md) §0–§1; מפת REST: [`UPRESS_WORDPRESS_STANDARD_v2.md`](project/UPRESS_WORDPRESS_STANDARD_v2.md) §7.5–§14 (`ezcache/v1`).

1. **פריסת קבצים:** `python3 scripts/build_eyal_client_hub.py` ואז `python3 scripts/ftp_publish_eyal_client_hub.py` (ברירת מחדל **prune**). בלי FTP מעודכן + prune, עלולים להישאר קבצי HTML ישנים על הדיסק בנתיב ה־Hub.
2. **ניקוי מטמון אחרי פריסה (EzCache — REST):**  
   `POST {UPRESS_WP_REST_BASE}/ezcache/v1/cache` עם גוף `{"action":"purge"}` ואימות Application Password — כמוגדר ב־[`UPRESS_WORDPRESS_STANDARD_v2.md`](project/UPRESS_WORDPRESS_STANDARD_v2.md) §«Cache Invalidation After Changes» ו־§14 (Post-Deploy Checklist). זהו ערוץ ה־**purge** המתועד לאוטומציה מול התוסף.
3. **ניקוי מטמון (פאנל uPress):** לפי [מאמר התמיכה](https://support.upress.co.il/dev/how-to-clear-cache/) — **אתר → פיתוח → ניהול כלי אחסון → בצע ניקוי מטמון** (מוסיף על או במקום קריאת REST, לפי מה שמופעל בחשבון).
4. **החרגת נתיב ה־Hub מ־Varnish (מומלץ לקביעות):** לפי [מאמר Varnish של uPress](https://support.upress.co.il/performance/%d7%94%d7%a4%d7%a2%d7%9c%d7%aa-%d7%95%d7%94%d7%92%d7%93%d7%a8%d7%aa-%d7%9e%d7%98%d7%9e%d7%95%d7%9f-varnish-cache/) ניתן להגדיר **החרגות URL**; יש להחריג את קידומת נתיב ה־Hub בפועל (`/<UPRESS_EYAL_HUB_PATH>/`, למשל `/ea-eyal-hub/`) כדי שלא יישמר עותק סטטי של דפי ה־Hub אחרי כל עדכון FTP. לאחר שינוי הגדרות Varnish — לבצע ניקוי מטמון כמופיע באותו מאמר וב־EzCache.
5. **אימות:** `curl -I` על קובץ Hub או גלישה עם `?nocache=$(date +%s)` — לעקוף מטמון דפדפן/פרוקסי בעת בדיקה.
6. **סימניה לאייל:** **`index.html`** או **`tasks.html`** — ב־v1.1 **`pending.html`** הוא רק הפניה ל־`tasks.html`.

---

## Hub V2 — אפיון LOD400 ונתונים (2026-04-15)

מקור מחייב לביצוע UI/בילד: [`EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md`](../_communication/team_100/EYAL-CLIENT-HUB-V2-LOD400-2026-04-15.md) (**גרסה 1.1** — תהליך קצה־לקצה §13, AC-01…AC-15). מנדטים: [`MANDATE-TEAM190-…`](../_communication/team_100/MANDATE-TEAM190-EYAL-HUB-V2-L-GATE-SPEC-2026-04-15.md) · [`MANDATE-TEAM10-…`](../_communication/team_100/MANDATE-TEAM10-EYAL-HUB-V2-IMPLEMENTATION-2026-04-15.md) · [`MANDATE-TEAM50-…`](../_communication/team_100/MANDATE-TEAM50-EYAL-HUB-V2-QA-2026-04-15.md) (**QA מקיף ומלא**) · [`MANDATE-TEAM90-…`](../_communication/team_100/MANDATE-TEAM90-EYAL-HUB-V2-POST-DEV-VALIDATION-2026-04-15.md).

**תוצאת L-GATE_SPEC (צוות 190):** [`L-GATE_SPEC_result.md`](../_communication/team_190/EYAL-HUB-V2/L-GATE_SPEC_result.md) — PASS WITH FINDINGS (2026-04-15).

**פרומטי אקטיבציה (זהות + קונטקסט) לכל הצוותים:** [`EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md`](../_communication/team_100/EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md) — צוותים 100 / 190 / 10 / 50 / 90.

### קבצי נתונים נוספים (אחרי מימוש צוות 10)

| קובץ | תיאור |
|------|--------|
| `hub/data/links.json` | קישורים מהירים לפי קטגוריות (מסמכים, מוקאפים, סטייג'ינג, כלים) |
| `hub/data/questions-prompts.json` | מטא־טופס + שדות לסקשן «שאלות» ב־`tasks.html` |
| `hub/data/meeting-brief.json` | תדריך פגישה ל־`meeting.html` |

### שדה `documentStatus` ב־`deliverables.json`

- ערכים מותרים: `draft` | `final` | `superseded` (אופציונלי; ברירת מחדל במימוש: `final` אם חסר).
- רמזור ויזואלי בדף בית — ראו LOD400 §4.2.

### הרחבות `roadmap.json` (אופציונליות)

- `currentGateLabelHe` — תווית שלב/שער לדשבורד.
- `milestoneProgress` — אובייקט עם מספרים לכרטיסי סטטיסטיקה.

### ייצואי JSON נוספים

| `exportType` | עמוד | הערה |
|--------------|------|------|
| `eyal-questions` | `tasks.html` (סקשן שאלות) | קליטה ידנית / ingest עתידי |
| `eyal-drive-intake` | `tasks.html` או קליטה | שם קובץ בדרייב + הקשר |
| `eyal-meeting-snapshot` | `meeting.html` | סנאפשוט סוף פגישה |

ייצואי קיימים (`eyal-feedback`, `eyal-site-tree-feedback`, `eyal-page-content-intake`) — נשמרים; אין לשבור.

### אוטומציה מקומית

- `scripts/hub_validate_hub_data.py` — ולידציית מבנה ל־`hub/data`.
- `scripts/hub_check_dist_links.py` — אחרי `build`; לקישורי `files/` יש להריץ בנייה עם `--mirror-docs` כדי שקבצי `dist/files/` יתאימו ל־`href`.
- `hub/canon-map.example.yaml` — דוגמה למיפוי קאנון→Hub (dev-time בלבד).
- פלייבוק עדכון: [`hub/HUB-CANONICAL-UPDATE-PLAYBOOK.md`](../hub/HUB-CANONICAL-UPDATE-PLAYBOOK.md).
