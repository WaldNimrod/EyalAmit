# LOD400 — Eyal Client Hub V2 (ממשק לקוח סטטי)

**מזהה:** EYAL-HUB-V2-LOD400  
**תאריך:** 2026-04-15  
**גרסת אפיון:** **1.1** — תהליך קצה־לקצה (§13), דיוק AC מול ממצאי L-GATE_SPEC F-01–F-06 ([`L-GATE_SPEC_result.md`](../team_190/EYAL-HUB-V2/L-GATE_SPEC_result.md)).  
**מחייב ל:** צוות 10 (יישום), צוות 50 (QA), צוות 90 (ולידציה פוסט־פיתוח); צוות 190 (L-GATE_SPEC — הושלם).  
**מקור ארגוני:** [`docs/CLIENT_HUB_STANDARD_v1.md`](../../docs/CLIENT_HUB_STANDARD_v1.md) + [`docs/CLIENT_HUB_APPENDIX_EYAL.md`](../../docs/CLIENT_HUB_APPENDIX_EYAL.md)  
**מיקום מימוש:** `hub/`, `scripts/build_eyal_client_hub.py`, סקריפטי פריסה ואוטומציה כמפורט להלן.  
**פרומטי אקטיבציה (כל הצוותים — Cursor / OpenAI):** [`EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md`](./EYAL-HUB-V2-ACTIVATION-PROMPTS-ALL-TEAMS-2026-04-15.md)

---

## 0. גבולות קנוניים (חובה)

### 0.1 שלוש שכבות

| שכבה | תפקיד | קוראים |
|------|--------|--------|
| **קאנון פרויקט + מאגר (AOS)** | `docs/PROJECT-ENTRY.md`, `docs/sop/SSOT.md`, `docs/project/ROADMAP-2026.md`, מנדטים תחת `_COMMUNICATION/` (שם התיקייה במאגר זה); אופציונלית מקורות מובְנים תחת `_aos/` **רק אם ממופים במפורט בקובץ מיפוי** (`hub/canon-map.example.yaml` או יורש) | סקריפטים בפיתוח / מפתח — **לא דפדפן** |
| **`hub/data/*.json`** | נתונים לבנייה, ב-Git | עורך ו/או סקריפט סנכרון |
| **`hub/dist/`** | HTML/CSS/JS סטטי | לקוח בשרת ציבורי |

### 0.2 תוכן גלוי ללקוח

- כל טקסט גלוי ב-UI — **בשפת פרויקט Eyal Amit** (אתר, שלב, מסמכים, פגישות).
- **אסור** להציג מונחי AOS פנימיים, נתיבי `_aos/`, שמות שערי lean-kit, או מזהי WP פנימיים כטקסט גלוי (מותר הערות HTML מוסתרות/מטא טכני שלא נראה למשתמש קצה).

### 0.3 מדיניות QR

- **לא** כשורת דשבורד ולא כתוכן ראשי; לכל היותר קישור נקודתי אחד אם נדרש — לא ברירת מחדל ב-V2.

---

## 1. מטרות ולא-מטרות

**מטרות**

- דשבורד בית: מצב/שער נוכחי, סטטיסטיקה תמציתית, קישורים פעילים, עץ אתר עם סטטוס פיתוח ורמת חומר.
- קליטה מסודרת: החלטות (`decisions.json`) + **סקשן שאלות** נפרד עם ייצוא JSON ייעודי.
- זרימת Drive: הוראות ברורות + שדות לזיהוי קובץ בדרייב; קליטה תפעולית ל־`from-eyal/`.
- יומן: roadmap למעלה, לוג עדכונים למטה — בתוך אקורדיונים.
- פגישה: `meeting-brief.json` + ייצוא סנאפשוט (JSON/טקסט) בסוף פגישה.
- מבנה **אקורדיון אחיד** לכל הסקשנים בכל דף Hub.
- רמזור **טיוטה / סופי / מוחלף** לדליברבלס במסמכים.
- אוטומציית פיתוח: ולידציית JSON, בדיקת קישורים מקומית, מיפוי קאנון→Hub (אופציונלי), נקודת כניסה אחת לריצה — ראו §7.

**לא במסגרת V2 (P1 / עתיד)**

- טעינת קבצי קאנון מהדפדפן.
- שרת צד־קוחץ שמושך מגוגל דרייב אוטומטית.
- החלפת מסמכי docx/PDF פורמליים כמקור החלטה חתומה — ה-Hub משלים ומקשר בלבד.

---

## 2. IA — רשימת דפים

| דף קובץ | תיאור |
|---------|--------|
| `index.html` | דשבורד בית (שער, סטטיסטיקה, דליברבלס עם רמזור, קישורים, מוקאפים, עץ אתר מקוצר או הפניה) |
| `tasks.html` | משימות + החלטות + **שאלות** (אקורדיונים נפרדים) |
| `roadmap.html` | יומן: roadmap + updates (אקורדיון) |
| `site-tree.html` | עץ IA (קיים — לעטוף/ליישר לאקורדיון לפי §4) |
| `content-intake.html` | קליטת תוכן לעמוד (קיים) |
| `meeting.html` | **חדש** — תדריך פגישה + סנאפשוט |
| `pending.html` | הפניה ל־`tasks.html` (תאימות לאחור) |

ניווט גלובלי: קישורים עקביים בכל הדפים לכל הדפים לעיל, **כולל** `meeting.html` לאחר שנוסף לבילד.

**הערה:** `content-intake.html` ו־`site-tree.html` — לעטוף את אזורי התוכן העיקריים באקורדיון לפי §3 (אפשר יותר מסקשן אחד לדף); לשמור על ייצואי JSON ופונקציונליות קיימים.

---

## 3. דפוס אקורדיון (גלובלי)

**חובה:** כל תוכן עמוד (מלבד כותרת עליונה, ניווט ופוטר סטנדרטי) מחולק ל**סקשנים** באמצעות אותו דפוס ויזואלי:

- מומלץ: `<details class="hub-acc">` + `<summary class="hub-acc__summary">` עם כותרת סקשן בעברית.
- מחלקת CSS משותפת ב־`hub/src/assets/hub.css` (למשל `.hub-acc`, `.hub-acc__summary:focus-visible`).
- אופציונלי (אם ב-AC): שמירת מצב פתוח/סגור ב־`sessionStorage` עם מפתח לפי `pageId` + `sectionId`.

**טבלת סקשנים** — לממש לפי עמוד (Team 10 ממלא עמודות "מקור נתונים"):

| דף | סקשן (סדר) | מקור נתונים |
|----|-------------|-------------|
| index | דשבורד מצב/שער | `roadmap.json` (+ שדות חדשים §5.2) |
| index | סטטיסטיקה / KPI תמציתי | חישוב מ־`tasks.json` / `roadmap.json` כפי שמוגדר ב-AC יישום |
| index | דליברבלס + רמזור | `deliverables.json` |
| index | קישורים מהירים | `links.json` (חדש) |
| index | מוקאפים | קיים (`MOCKUP_INDEX_SECTIONS` / נתונים) |
| index | עץ אתר | `site-tree.json` או תת־עץ |
| tasks | משימות | `tasks.json`, `eyal-pending.json` |
| tasks | החלטות | `decisions.json` |
| tasks | שאלות | `questions-prompts.json` + טופס ייצוא |
| tasks | העלאת קבצים (Drive) | טקסט סטטי + שדות טופס ייצוא `eyal-drive-intake` |
| roadmap | מפת דרכים | `roadmap.json` |
| roadmap | לוג עדכונים | `updates.json` |
| meeting | תדריך פגישה | `meeting-brief.json` |
| meeting | ייצוא סנאפשוט | JS — ללא שרת |

---

## 4. מפרט דף בית (`index.html`)

### 4.1 שער ושלב נוכחי

- הצגת **טקסט קצר** מ־`roadmap.json` — סדר עדיפות: (א) אם קיים `currentGateLabelHe` — הצגתו ככותרת מצב; (ב) אחרת — **שורה ראשונה** מ־`summaryHe` (עד ל-`\n` הראשון, או עד 160 תווים אם אין מעבר שורה); (ג) אחרת — `summaryHe` במלואו (עם קיצור ויזואלי ב-CSS אם ארוך).
- **סטטיסטיקה:** לפחות שני כרטיסים/מספרים, חישוב **דטרמיניסטי** מ־JSON:
  - **משימות:** לספור כל אובייקט במערך `tasks.json` → `sections[]` → `tasks[]` (מבנה נוכחי במאגר: רמה אחת; אם בעתיד יתווספו רמות — לעדכן סעיף זה ב-LOD400). `openCount` = משימות עם `status` ≠ `completed`. `doneCount` = משימות עם `status` = `completed`. הצגה: לפחות שני מספרים או יחס (למשל «פתוחות: X · סגורות: Y»).
  - **עדכונים:** `updatesRecentCount` = מספר פריטים ב־`updates.json` → `items` עם `date` בשלושים הימים האחרונים (לפי לוח שנה), או לחלופין הצגת מזהה `currentFocusId` מה-roadmap — לפחות **אחד** משני אלה בכרטיס שני.

### 4.2 דליברבלס — רמזור

כל פריט ב־`deliverables.json` → `items[]` תומך בשדה אופציונלי:

- `documentStatus`: אחד מ־`draft` | `final` | `superseded` (ברירת מחדל אם חסר: `final` לפריטים ישנים).
- רינדור: תג ויזואלי (למשל `span.deliverable-status--draft`) + תווית עברית: «טיוטה» / «סופי» / «הוחלף».

### 4.3 `links.json` (קובץ חדש)

```json
{
  "schemaVersion": 1,
  "categories": [
    {
      "id": "docs",
      "titleHe": "מסמכים",
      "items": [
        {
          "labelHe": "…",
          "href": "files/… או URL מלא",
          "openInNewTab": false,
          "noteHe": "אופציונלי"
        }
      ]
    }
  ]
}
```

- `href` יחסי — יחסית לשורש Hub ב־`dist/`; חיצוני — `http://` לסטייג'ינג או `https://` לפרודקשן לפי נוהל הנספח.

### 4.4 עץ אתר

- שימור התנהגות קיימת; אם הדף ארוך — עטיפה באקורדיון לפי צמתים או קיבוץ היררכי — לפי שיקול Team 10 ובהתאם ל-AC נגישות.

---

## 5. מודל נתונים — סכימות

### 5.1 `roadmap.json` (הרחבה)

שדות נוספים (אופציונליים אם חסרים — ברירות מוגדרות בבילד):

- `currentGateLabelHe` (string)
- `milestoneProgress` (object): לפחות `completedCount`, `totalCount` או `percent` — מספרים שלמים.

### 5.2 `questions-prompts.json` (חדש)

```json
{
  "schemaVersion": 1,
  "introHe": "טקסט הקדמה קצר",
  "formFields": [
    { "id": "topic", "labelHe": "נושא", "type": "text", "required": true },
    { "id": "urgency", "labelHe": "דחיפות", "type": "select", "optionsHe": ["נמוכה", "בינונית", "גבוהה"] },
    { "id": "relatedPageId", "labelHe": "עמוד/צומת (אופציונלי)", "type": "text" },
    { "id": "body", "labelHe": "תיאור השאלה", "type": "textarea", "required": true },
    { "id": "driveFileName", "labelHe": "שם קובץ בדרייב (לזיהוי)", "type": "text" },
    { "id": "attachmentDeclared", "labelHe": "צורף קובץ בדרייב", "type": "checkbox" }
  ],
  "exportType": "eyal-questions"
}
```

**מטען ייצוא (`eyal-questions`)** — חובה להתאים לדפוס Client Hub Standard (F-06): שורש עם `schemaVersion`, `exportType` = `eyal-questions`, `exportTimestamp` (ISO-8601 UTC), `respondent` (מחרוזת לא ריקה), ומערך `answers`: כל פריט לפחות `fieldId` (תואם `formFields[].id`) ו־`value` (מחרוזת או בוליאני לפי סוג השדה). אופציונלי: `notesHe` ברמת השורש להערות חופשיות. **הבהרה:** ב־Standard המילולי מופיע גם `{ id, choice, notes }` לטופסי החלטות — ייצוא `eyal-questions` הוא **הרחבת טופס שאלות**; אינו מחליף את צורת `eyal-feedback` להחלטות. קליטה עתידית — לשמור תאימות עם `ingest` כמו `eyal-feedback` רק אחרי הרחבת סקריפט (מחוץ ל-P0 אם לא נדרש).

### 5.3 `meeting-brief.json` (חדש)

```json
{
  "schemaVersion": 1,
  "meetingDate": "2026-04-20",
  "titleHe": "כותרת קצרה",
  "goalsHe": ["…"],
  "agendaHe": ["…"],
  "openDecisionsRefs": ["D-EYAL-…"],
  "prepHe": "מה להכין",
  "quickLinks": [{ "labelHe": "…", "href": "tasks.html" }]
}
```

### 5.4 ייצוא סנאפשוט פגישה

- `exportType` מוצע: `eyal-meeting-snapshot`
- שדות: `exportTimestamp`, `respondent`, `meetingDate`, `snapshotBodyHe` (טקסט מסכם), `sourceFields` (העתק שדות מ־`meeting-brief.json`).

### 5.5 ייצוא Drive intake

- `exportType`: `eyal-drive-intake`
- שורש ייצוא: `schemaVersion`, `exportType`, `exportTimestamp`, `respondent`, ושדות מטען: `driveFileName`, `contextHe` (עמוד/חבילה), `dateOptional` (מחרוזת ISO או ריק).

---

## 6. נגישות (מינימום)

- מקלדת: `<summary>` ניתן לפוקוס; אין מלכודת מיקוד.
- תוויות מקושרות לשדות טפסים.
- `lang="he"` וכיוון RTL כבר קיימים — לשמור.

---

## 7. אוטומציה (סביבת פיתוח בלבד)

### 7.1 קבצים

- `hub/canon-map.example.yaml` — דוגמה למיפוי `canonPath` → `hubDataPath` (לא חובה להריץ ב-POC).
- `scripts/hub_validate_hub_data.py` — ולידציית מבנה בסיסית ל־`hub/data/*.json`.
- `scripts/hub_check_dist_links.py` — אחרי `build`, בודק שקישורים יחסיים ב־HTML מצביעים לקבצים קיימים.

### 7.2 נקודת כניסה (מומלץ)

- Makefile target או `scripts/hub_publish_local.sh`: `validate` → `build` → `hub_check_dist_links.py` (פריסה FTP ידנית או `--dry-run` לפי נוהל).

---

## 8. בנייה ופריסה

- `python3 scripts/build_eyal_client_hub.py` (עם `--mirror-docs` כשמוסיפים קבצים ל־`files/`).
- `python3 scripts/ftp_publish_eyal_client_hub.py` — ראו [`hub/EYAL-HUB-SSOT-WORKFLOW.md`](../../hub/EYAL-HUB-SSOT-WORKFLOW.md) ו־[`hub/HUB-CANONICAL-UPDATE-PLAYBOOK.md`](../../hub/HUB-CANONICAL-UPDATE-PLAYBOOK.md).
- ניקוי מטמון EzCache/Varnish לפי נספח Eyal.

---

## 9. קריטריוני קבלה (AC)

| מזהה | קריטריון | ראיה |
|------|-----------|------|
| AC-01 | כל דפי ה-Hub הנדרשים ב§2 נבנים ל־`dist/` | רשימת קבצים בבילד |
| AC-02 | כל עמוד ב§2 (כולל `content-intake.html`, `site-tree.html`) משתמש באקורדיון ל**כל הסקשנים לפי טבלת §3** (לא רק «עיקריים»); ניווט גלובלי כולל `meeting.html` כשהדף קיים | בדיקה ויזואלית / DOM |
| AC-03 | אין מונחי AOS גלויים בטקסט UI | סריקת טקסט |
| AC-04 | דף בית: שער/מיקוד + סטטיסטיקה + דליברבלס עם רמזור; **וגם** סקשני קישורים מהירים (`links.json`), מוקאפים ועץ אתר **כשקיימים בנתונים** — לפי שורות ה־index בטבלת §3, עם אקורדיון | צילום מסך / DOM |
| AC-05 | `links.json` נטען ומוצג בקבוצות | DOM |
| AC-06 | `tasks.html`: **ארבעה** סקשנים מובחנים באקורדיון — משימות; החלטות; שאלות; **קליטת Drive** (§3). אם Drive מוטמע בתוך סקשן אחר — לתעד במסירת צוות 10 איזה סקשן | DOM + מסירה |
| AC-07 | ייצוא `eyal-questions` יורד כ-JSON תקין | הורדה |
| AC-08 | ייצוא `eyal-drive-intake` תקין | הורדה |
| AC-09 | `meeting.html` + ייצוא סנאפשוט | הורדה |
| AC-10 | ייצואי קיימים לא נשברים: `eyal-feedback`, `eyal-site-tree-feedback`, `eyal-page-content-intake` | בדיקה ידנית |
| AC-11 | סנכרון `hub/data` עם קאנון: טבלת דלתא במסירה מפרטת לפחות **תאריך/שלב** מול `PROJECT-ENTRY` ו/או `roadmap.json` (`currentGateLabelHe`, `summaryHe`, מקטע מקביל) וכל שינוי בקבצי SSOT רלוונטיים | טבלת דלתא במסירה |
| AC-12 | לאחר פריסה FTP — כל דפי Hub וכל `href` פנימי וקבצים תחת `dist/files`, `dist/mockups` — HTTP 200 בכתובת ציבורית | דוח צוות 50 |
| AC-13 | `hub_validate_hub_data.py` ו־`hub_check_dist_links.py` עוברים לפני פריסה | לוג טרמינל |
| AC-14 | נגישות מינימום §6 | בדיקת מקלדת |
| AC-15 | אין רגרסיה ב־**F-08 / F-09 / F-10** ([`CLIENT_HUB_STANDARD_v1.md`](../../docs/CLIENT_HUB_STANDARD_v1.md)) בהתאם לסביבה + [`CLIENT_HUB_APPENDIX_EYAL.md`](../../docs/CLIENT_HUB_APPENDIX_EYAL.md): חסימת אינדקס, פוטר מותג, קיום `metadata.json` ב־`dist/` אם קיים במאגר לפני V2 | בדיקה במסירה / השוואת baseline |

---

## 10. MVP מול P1 (עומס)

**P0 (חובה):** אקורדיון, דשבורד מצב, רמזור דליברבלס, `links.json`, שאלות + Drive intake exports, `meeting.html` + snapshot, ולידציה + לינק־צ'ק, פריסה + QA שרת.

**P1:** סנכרון אוטומטי מלא מ־`canon-map.yaml`, שמירת מצב אקורדיון ב־`sessionStorage`, ingest אוטומטי ל-`eyal-questions`.

---

## 11. מסירה לצוותים

- **צוות 190:** L-GATE_SPEC על מסמך זה (לפני או במקביל למימוש) — תוצאה: [`../team_190/EYAL-HUB-V2/L-GATE_SPEC_result.md`](../team_190/EYAL-HUB-V2/L-GATE_SPEC_result.md).
- **צוות 10:** מימוש בילד + נכסים + JSON לדוגמה ממולאים.
- **צוות 50:** מטריצת QA מול טבלת §9 בשרת.
- **צוות 90:** בקרה מול מסמך זה + דוח 50.

---

## 12. ביקורת צוות 100 — מוכנות לולידציה (2026-04-15)

| בדיקה | תוצאה |
|--------|--------|
| עקביות פנימית (סעיפים, טבלאות AC, הפניות §) | **עבר** — תוקן אזכור אוטומציה §7; נוספו כללי תצוגת שער/סטטיסטיקה; נוספה הנחיה לניווט ול־content-intake/site-tree. |
| התאמה ל-Standard + נספח Eyal | **עבר** — ייצוא `eyal-questions` מקושר ל-F-06; מקורות ארגוניים בכותרת. |
| פערים LOD400 (מה מותר לממשן לנחש) | **מצומצם** — חישוב משימות/עדכונים מוגדר מפורשות; מטען JSON לשאלות מוגדר. נותר שיקול ויזואלי מינורי (CSS קיצור טקסט). |
| מסלול ולידציה (90) | **מוכן** — טבלת §9 מספקת AC-by-AC; מומלץ לצוות 90 לצרף צילומי מסך אם דוח 50 לא מפורט. |
| **L-GATE_SPEC (צוות 190)** | **הושלם 2026-04-15** — **PASS WITH FINDINGS**; ראו [`L-GATE_SPEC_result.md`](../team_190/EYAL-HUB-V2/L-GATE_SPEC_result.md) (F-01–F-06 — הבהרות AC אופציונליות, לא חוסמות). |

**מסקנה:** המסמך **מלא ומוכן למימוש צוות 10** (גרסה 1.1 כוללת תהליך קצה־לקצה §13); ולידציה חוקתית לפי SPEC הוזנה. **ולידציה פוסט־מימוש (צוות 90)** — לאחר סיום מימוש צוות 10 ודוח צוות 50. אם במימוש יתגלה סתירה בין מבנה `tasks.json` האמיתי לבין ספירת §4.1 — יש לעדכן את סעיף הספירה או את הבילד ולתעד בשורה ב-LOD400 (גרסה משנית).

---

## 13. תהליך קצה־לקצה (מסגרת)

| שלב | בעל תפקיד | קלט עיקרי | פלט / ארטיפקט | הערה |
|-----|-----------|-----------|----------------|------|
| אפיון | צוות 100 | SSOT, דרישות מוצר | LOD400 זה | מקור מחייב למימוש |
| L-GATE_SPEC | צוות 190 | LOD400 | [`L-GATE_SPEC_result.md`](../team_190/EYAL-HUB-V2/L-GATE_SPEC_result.md) | הושלם (PASS WITH FINDINGS) |
| יישום + בנייה מקומית | צוות 10 | LOD400 §1–§9 | `hub/dist/`, לוגים ירוקים §7 | לפני FTP |
| פריסה | צוות 10 | `hub/dist/` | FTP לנתיב Hub ([`EYAL-HUB-SSOT-WORKFLOW.md`](../../hub/EYAL-HUB-SSOT-WORKFLOW.md)); ניקוי מטמון ([נספח Eyal](../../docs/CLIENT_HUB_APPENDIX_EYAL.md)) | כתובת ציבורית לבדיקה |
| **הגשה ל־QA** | צוות 10 → 50 | מסירה + URLs | דוח צוות 50 מול §9 | **מוכן ל־QA** כשסעיף Done במנדט צוות 10 התמלא ויש URL פעיל |
| QA שרת | צוות 50 | מסירת 10, LOD400 §9 | `EYAL-HUB-V2-QA-REPORT-TEAM50-*.md` | לא מתקן קוד |
| ולידציה מסמכית | צוות 90 | דוח 50 + מסירת 10 + LOD400 | `VALIDATION-EYAL-HUB-V2-TEAM90-*.md` | פוסט־דוח QA |

**קריטריון «מוכן להגשה ל־QA» (צוות 10):** (א) כל סעיפי ה־Done במנדט [`MANDATE-TEAM10-…`](./MANDATE-TEAM10-EYAL-HUB-V2-IMPLEMENTATION-2026-04-15.md); (ב) AC-01 עד AC-15 עברו בדיקה עצמית או סומנו פערים מוסכמים עם צוות 100; (ג) פריסה לכתובת ציבורית + **purge** מטמון אם נדרש; (ד) מסירה כוללת **שורש URL מלא** (סטייג'ינג/פרודקשן לפי נוהל) ונתיב יחסי Hub.

---

**סיום אפיון LOD400**
