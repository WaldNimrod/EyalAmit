# M2 — בקשת **ולידציה חוזרת** (צוות **50**)

**סטטוס בקשה:** **הושלמה** — דוח תוצאה: [`M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md`](./M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md) (**PASS WITH NOTES**, NOTE **F2** בלבד).

**תאריך בקשה:** 2026-04-06  
**מוציא:** צוות **10** (יישום + פריסה סטייג’ינג) · תיאום **100**  
**אל:** צוות **50** (QA / בקרה)  
**סוג:** ריצת **FINAL** מלאה לפי מנדט מרוכז — לא דגימה חלקית.

---

## מטרה

לאמת מחדש את **M2 G4 / §11** מול **הסטייג’ינג החי** לאחר סגירת הפערים מדוח  
[`M2-SMOKE-REPORT-FINAL-2026-04-06.md`](./M2-SMOKE-REPORT-FINAL-2026-04-06.md) (**FAIL** — S5–S10, F-01–F-05).

---

## מנדט (מקור אחיד)

[`M2-QA-CONSOLIDATED-MANDATE-TEAM50-2026-04-10.md`](./M2-QA-CONSOLIDATED-MANDATE-TEAM50-2026-04-10.md) — כולל §8 (**S1–S16**), בדיקות משלימות (**HOME**, **Y1**, **T-en**, **A11y**, **G3**, **Fluent**), ומדיניות סטייג’ינג/TLS.

**מקור אמת IA:** [`hub/data/site-tree.json`](../../hub/data/site-tree.json) (נעול 2026-04-06).

---

## סביבת בדיקה

| פריט | ערך |
|------|-----|
| בסיס סטייג’ינג | `https://eyalamit-co-il-2026.s887.upress.link` (או `http://` לפי מדיניות TLS בסטייג’ינג — ראו [`STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md)) |
| Runbook | [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) |

---

## ראיות פריסה ואימות טכני מקדים (צוות 10)

פריסת FTP מהמאגר בוצעה; סנכרון עץ נעול רץ על הסטייג’ינג. פירוט ודגימות `curl`/HTML:

- [`../team_10/M2-STAGING-DEPLOY-VERIFY-ARTIFACT-2026-04-06.md`](../team_10/M2-STAGING-DEPLOY-VERIFY-ARTIFACT-2026-04-06.md)

בריף טכני מורחב (שינויי קוד):  
[`M2-QA-RETEST-REQUEST-TEAM50-2026-03-29.md`](./M2-QA-RETEST-REQUEST-TEAM50-2026-03-29.md).

---

## תוצר חובה מצוות 50

קובץ דוח יחיד עם כותרת מפורשת:

- `**STATUS:** **FINAL**`
- `**PASS**` | `**PASS WITH NOTES**` | `**FAIL**`

**שם קובץ מומלץ:** `_communication/team_50/M2-SMOKE-REPORT-FINAL-2026-04-06.md`  
(או תאריך ביצוע בפועל; אם קיים כבר דוח מאותו תאריך — גרסה עם סיומת `-v2` או תאריך חדש, ללא דריסה לא מכוונת.)

לאחר **PASS** / **PASS WITH NOTES** (רק F2) — העברה ל־**100** לקליטת §11 G4 לפי [`M2-FINAL-QA-REQUEST-M2-CLOSEOUT-TEAM50-2026-04-10.md`](./M2-FINAL-QA-REQUEST-M2-CLOSEOUT-TEAM50-2026-04-10.md).

---

## חתימת מוציא הבקשה

**צוות 10** — בקשת ולידציה חוזרת פעילה נכון ל־**2026-04-06**.
