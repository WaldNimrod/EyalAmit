# M3 — שער QA-1: עמודים, תוכן בסיסי וניווט מול העץ (צוות **50**)

**תאריך:** 2026-03-29  
**מוציא:** צוות **100** (אורקסטרציה)  
**אל:** צוות **50** (QA)  
**תלות:** השלמת **M3-M2** לפי [`../team_10/M3-M2-PAGES-CONTENT-MANDATE-TEAM10-2026-03-29.md`](../team_10/M3-M2-PAGES-CONTENT-MANDATE-TEAM10-2026-03-29.md) + **QA-0 סגור** — [`M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md`](./M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md)

**קליטת מוכנות מצוות 10:** [`../team_10/M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md`](../team_10/M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md) — עודכן עם **פלט 50** (2026-04-07). טיוטת עצמי **Q1-4**/**Q1-6** אומתה ב־50: ניווט **PASS**; **Q1-6** — **PASS WITH NOTES** (כפילויות REST פתוחות מול **100**).

---

## מטרה

לאמת מול **סטייג’ינג** שעמודי האתר, **תוכן בסיסי**, **ניווט** ו־**RTL** תואמים את [`hub/data/site-tree.json`](../../hub/data/site-tree.json) ואת [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](../team_10/M3-PAGE-FILL-MATRIX-2026-04-07.md) — ברמת איכות **לפני** אינסטנסים מלאים (FAQ / גלריות / המלצות) שייבדקו ב־**QA-2**.

---

## סביבה

| # | נושא | מקור |
|---|------|------|
| A1 | סטייג’ינג | [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) |
| A2 | TLS סטייג’ינג | [`STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md) |
| A3 | עץ נעול | `hub/data/site-tree.json` |
| A4 | מטריצת מילוי | [`../team_10/M3-PAGE-FILL-MATRIX-2026-04-07.md`](../team_10/M3-PAGE-FILL-MATRIX-2026-04-07.md) |

---

## בדיקות חובה

| ID | בדיקה | ציפייה |
|----|--------|--------|
| Q1-1 | עמודים מול עץ | לכל צומת שסומן **חי** (או טיוטה שבהיקף הבדיקה): קיים מסלול בחזית; אין 404 «שקט» בלי תיעוד במטריצה |
| Q1-2 | תבניות | דגימה של **לפחות 5** עמודים מתבניות **שונות** (`tpl-*` מ־`page-templates.json`) — רינדור תקין, אין תבנית שגויה ברורה |
| Q1-3 | תוכן בסיסי | עמודים «חיים»: אין גוף ריק; **PLACEHOLDER** / חסר — רק אם מתועד במטריצה או ב־Hub לפי נוהל |
| Q1-4 | ניווט | תפריטים ראשיים/משניים — קישורים שבורים או יעדים שגויים מתועדים כממצא |
| Q1-5 | RTL | כיוון עברי בסיסי בדפים שנבדקו; אין שבירות קשות (טקסט LTR בלבד היכן שלא מתאים) |
| Q1-6 | מעקב הערות QA-0 | כפילויות REST / יישור slug שצוינו בדוח QA-0 — **סטטוס** (טופל / פתוח עם בעלים 10/100) |

---

## פלט חובה

קובץ דוח תחת `_communication/team_50/`:

**שם מומלץ:** `M3-QA-PAGES-CONTENT-REPORT-TEAM50-YYYY-MM-DD.md` · **בפועל (2026-04-07):** [`M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md`](./M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md)

**כותרות חובה בדוח:**

- `**סטטוס:**` אחד מ: **`FINAL`**
- `**תוצאה:**` אחד מ: **`PASS`** · **`PASS WITH NOTES`** · **`FAIL`**
- טבלה: **ID בדיקה | תוצאה | הערה | בעלים (10/100)**

---

## אחרי שער

| תוצאה | פעולה |
|--------|--------|
| **PASS** / **PASS WITH NOTES** | מעבר ל־**M3-M3** + **QA-2** לפי [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) — מנדט **M3-M3:** [`../team_10/M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md`](../team_10/M3-M3-INSTANCES-MANDATE-TEAM10-2026-04-08.md) · מנדט **QA-2:** [`M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md`](./M3-QA-INSTANCES-GALLERIES-MANDATE-TEAM50-2026-04-08.md) · דוח **QA-2 FINAL** — **בכפוף** לסגירת **Q1-6** או **waiver** מתועד |
| **FAIL** | תיקון ב־10 — ריטסט QA-1 |

---

## ביצוע וסגירה (2026-04-07)

**דוח FINAL:** [`M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md`](./M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md) · **`PASS WITH NOTES`** — Q1-1, Q1-2, Q1-4, Q1-5 **PASS**; Q1-3, Q1-6 **PASS WITH NOTES** (מעקב **100** על כפילויות REST).

**אימות תיעוד חוזר (ללא curl):** [`M3-QA-1-DOC-SYNC-RETEST-TEAM50-2026-04-07.md`](./M3-QA-1-DOC-SYNC-RETEST-TEAM50-2026-04-07.md) — **`PASS WITH NOTES`** (תיקון קישור §4 ביומן 100).

---

**צוות 100** — אורקסטרציה M3
