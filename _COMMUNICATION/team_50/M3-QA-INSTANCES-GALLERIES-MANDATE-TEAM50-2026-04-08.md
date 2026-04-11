# M3 — שער QA-2: אינסטנסים, גלריות והמלצות (צוות **50**)

**תאריך:** 2026-04-08  
**מוציא:** צוות **100** (אורקסטרציה)  
**אל:** צוות **50** (QA)  
**תלות:** השלמת **M3-M3** לפי [`../team_10/M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md`](../team_10/M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md) + **QA-1 סגור** — [`M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md`](./M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md)

**תנאי שער לפני דוח FINAL המאשר מעבר ל־M3-M4:** **Q1-6** (כפילויות REST / יישור slug מתועד ב־QA-1) — **סגור** בידי **10**/**100** או **waiver** מתועד ב־[`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) (יומן / סעיף ייעודי). צוות **50** יציין בדוח אם התנאי התקיים.

**קליטת מוכנות (כאשר יפורסם):** `M3-QA-2-READINESS-REQUEST-TEAM10-*.md` תחת `team_10/`.

---

## מטרה

לאמת מול **סטייג’ינג** ש**אינסטנסי** FAQ, גלריות והמלצות/מדיה **מאוכלסים**, **מקושרים** לעמודי השער והקטלוגים, ועומדים בסקופ הגלריות ובתקרת משקל תמונה — בהתאם לעץ, למטריצה ולדוח המלאי.

---

## סביבה

| # | נושא | מקור |
|---|------|------|
| A1 | סטייג’ינג | [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) |
| A2 | TLS סטייג’ינג | [`STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md) |
| A3 | עץ נעול | `hub/data/site-tree.json` |
| A4 | מטריצת מילוי | [`../team_10/M3-PAGE-FILL-MATRIX-2026-04-07.md`](../team_10/M3-PAGE-FILL-MATRIX-2026-04-07.md) |
| A5 | מלאי גלריות | [`GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md`](../../docs/project/team-100-preplanning/GALLERY-INVENTORY-REPORT-DRAFT-2026-03-31.md) |
| A6 | סקופ גלריות | [`GALLERY-DECISION-SCOPE-v1.2.md`](../../docs/project/team-100-preplanning/GALLERY-DECISION-SCOPE-v1.2.md) |

---

## בדיקות חובה

| ID | בדיקה | ציפייה |
|----|--------|--------|
| Q2-1 | FAQ | עמוד שער/קטלוג FAQ (`st-faq`) — אינסטנסים מוצגים או `PLACEHOLDER` מתועד במטריצה; אין רשימה ריקה בלי נימוק |
| Q2-2 | גלריות — כיסוי | עמוד קטלוג גלריות (`st-galleries-catalog`) — ישות לכל פריט נדרש במלאי או סטטוס **DEFERRED** מתועד |
| Q2-3 | גלריות — תמונות | דגימה: מניין תמונות **למחיצה** מול **תקרת 150KB** (לפחות **3** גלריות או כל המאוכלסות אם פחות) |
| Q2-4 | המלצות / מדיה | עמוד `st-media` — קטלוג או רשימה תואמת מודל; כפילויות (למשל `testimonials-media`) **מתועדות כטופלות או פתוחות עם בעלים** |
| Q2-5 | שיבוץ בעמודים | דגימה: לפחות **3** עמודים שאמורים להציג אינסטנסים — הקישור/הטמעה עובדים; אין 404 «שקט» |
| Q2-6 | alt בסיסי | דגימה מגלריה/מדיה: יש **alt** או תיעוד פער כממצא עם בעלים |
| Q2-7 | RTL | דגימה בדפי שער האינסטנסים — כיוון עברי סביר; אין שבירות קשות |

---

## פלט חובה

קובץ דוח תחת `_communication/team_50/`:

**שם מומלץ:** `M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-YYYY-MM-DD.md`

**כותרות חובה בדוח:**

- `**סטטוס:**` אחד מ: **`FINAL`**
- `**תוצאה:**` אחד מ: **`PASS`** · **`PASS WITH NOTES`** · **`FAIL`**
- טבלה: **ID בדיקה | תוצאה | הערה | בעלים (10/100)**
- שורה מפורשת: **Q1-6 / waiver** — **התקיים** / **לא התקיים** (אם לא — **FAIL** או **PASS WITH NOTES** לפי נוהל **100**)

---

## אחרי שער

| תוצאה | פעולה |
|--------|--------|
| **PASS** / **PASS WITH NOTES** | מעבר ל־**M3-M4** (ליטוש ויזואלי מבני) לפי [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) — צוות **100** יעדכן יומן; ריצת **50** כהערת משנה לוויזואל לפי התוכנית |
| **FAIL** | תיקון ב־10 — ריטסט QA-2 |

---

## ביצוע וסגירה (2026-04-07)

**דוח FINAL:** [`M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](./M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) · **`PASS WITH NOTES`** — **Q1-6 / waiver: לא התקיים**; **אישור מעבר ל־M3-M4: לא מאושר עדיין** (מפורש בדוח).

**הגשה חוזרת צוות 10 (תיעוד תיקונים):** [`../team_10/M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md`](../team_10/M3-QA-2-READINESS-RESUBMISSION-TEAM10-2026-04-08.md)

**אימות תיעוד חוזר (ללא curl / ריטסט פונקציונלי):** [`M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md`](./M3-QA-2-DOC-SYNC-RETEST-TEAM50-2026-04-07.md) — **`FINAL`** · **`PASS`** — **אין** שינוי בפסק הדין הפונקציונלי של דוח QA-2 לעיל.

**ריטסט פונקציונלי (2026-04-08):** [`M3-QA-INSTANCES-GALLERIES-REPORT-RETEST-TEAM50-2026-04-08.md`](./M3-QA-INSTANCES-GALLERIES-REPORT-RETEST-TEAM50-2026-04-08.md) — **`FINAL`** · **`PASS WITH NOTES`** — **Q1-6** טכני **PASS** (REST באורך 1 + `publish` + הורה; **301** מ־`/lectures/`, `/workshops/`); **Q2-2** **PASS**; **Q2-3** **PASS WITH NOTES** (שתי גלריות בלבד; דגימת 150KB לשתיהן לפי מנדט «כל המאוכלסות אם פחות מ־3»); **Q2-4…Q2-6** **PASS**; שורת שער — waiver **פורסם**; **אישור GO מלא M3-M4 מטעם 50** — **לא**; לפי בקשת [`../team_10/M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md`](../team_10/M3-QA-2-READINESS-REQUEST-TEAM10-2026-04-08.md).

**דוח השלמה לצוות 100:** [`../team_10/M3-M3-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-08.md`](../team_10/M3-M3-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-08.md)

---

**צוות 100** — אורקסטרציה M3
