# M3-M4 — מנדט: ליטוש ויזואלי מבני (צוות **10**)

**תאריך:** 2026-04-08  
**מוציא:** צוות **100** (אורקסטרציה)  
**אל:** צוות **10** (+ תיאום **נימרוד** / עיצוב לפי הצורך)  
**תוכנית מסגרת:** [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md)  
**תלות:** **QA-2** דוח **FINAL** פורסם — [`../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-INSTANCES-GALLERIES-REPORT-TEAM50-2026-04-07.md) · **waiver שער Q1-6** לצורך פתיחת M4 במקביל — [`../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md`](../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md)  
**שער הבא:** [`../team_50/M3-QA-M4-VISUAL-NOTE-MANDATE-TEAM50-2026-04-08.md`](../team_50/M3-QA-M4-VISUAL-NOTE-MANDATE-TEAM50-2026-04-08.md) (**QA-M4** — הערת ויזואל)

## רצף ארגוני (חבילה 4)

**שלב 1** בשרשרת הארגונית: צוות **10** משלים מנדט זה (קוד, פריסה) ומפרסם **`M3-QA-M4-READINESS-REQUEST-TEAM10-YYYY-MM-DD.md`**. צוות **50** לא פותח **QA-M4** לפני פרסום קובץ זה. **G5–G7** רצים **במקביל** לפי waiver — ראו [`../team_100/M3-PACKAGE4-TEAM100-DIRECT-IMPLEMENTATION-AND-SEQUENCE-2026-03-29.md`](../team_100/M3-PACKAGE4-TEAM100-DIRECT-IMPLEMENTATION-AND-SEQUENCE-2026-03-29.md) §3.

---

## מטרה

**אחידות מבנית־ויזואלית** ב־GeneratePress + child: כותרות, רשתות, כרטיסים, ריווחים, קומפוננטים חוזרים; צבעים מ־[`EYAL-SITE-COLOR-PALETTE.md`](../../docs/project/EYAL-SITE-COLOR-PALETTE.md) (או פלטה מאושרת אחרת ביומן **100**).

**לא בתוך M3-M4** (נדרש waiver **100**): מנוע גלריה כבד; שינוי תבנית נעולה בעץ; שינוי slug/הורה.

---

## קלטים חובה

| # | מקור |
|---|------|
| 1 | [`hub/data/site-tree.json`](../../hub/data/site-tree.json) · [`hub/data/page-templates.json`](../../hub/data/page-templates.json) |
| 2 | [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) |
| 3 | דף בית / מוקאף מאושר — ראו תוכנית M3 §0.1 |
| 4 | סטייג’ינג — [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) |

---

## פלט חובה

1. **קוד** — `site/wp-content/themes/ea-eyalamit/` (CSS/תבניות) כנדרש; שינויים **ממוקדים** (ללא ריפקטור כללי).  
2. **פריסה** לסטייג’ינג לפי נוהל הקיים.  
3. **בקשת מוכנות ל־QA-M4** — מסמך `team_10/` (שם מוצע: `M3-QA-M4-READINESS-REQUEST-TEAM10-YYYY-MM-DD.md`) עם דגימות URL (בית, שירות, קטלוג, עמוד משפטי) ורשימת שינויים.

**במקביל (חובת 10):** התקדמות ב־**G5–G7** / **Q1-6** לפי [`../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md`](../team_100/M3-Q1-6-WAIVER-PARALLEL-M4-GATE-TEAM100-2026-04-08.md) — **אין** דחייה עד אחרי M4.

---

## סיום

כשהמסירה מוכנה — עדכנו **100** ו**50** לפי מנדט **QA-M4**.

**סטטוס מנדט M3-M4:** **QA-M4 סגור** — **`PASS`** (ריטסט קנוני) — [`../team_50/M3-QA-M4-VISUAL-NOTE-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-M4-VISUAL-NOTE-RETEST-TEAM50-2026-04-07.md); דוח ראשון: [`M3-QA-M4-VISUAL-NOTE-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-M4-VISUAL-NOTE-REPORT-TEAM50-2026-04-07.md) (**PASS WITH NOTES**). **תיקוני הערות + הגשה חוזרת** — תמה **1.3.1** · [`M3-QA-M4-READINESS-RESUBMISSION-TEAM10-2026-04-07.md`](./M3-QA-M4-READINESS-RESUBMISSION-TEAM10-2026-04-07.md) · [`M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-07.md`](./M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-07.md). **מסירה ל־100:** [`M3-M4-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-07.md`](./M3-M4-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-07.md). **שלב הבא (אורקסטרציה):** [`../team_100/M3-QA-M4-RETEST-ACCEPTANCE-AND-NEXT-PHASE-TEAM100-2026-04-07.md`](../team_100/M3-QA-M4-RETEST-ACCEPTANCE-AND-NEXT-PHASE-TEAM100-2026-04-07.md).

---

## ביצוע (צוות 10) — תמצית

| # | פריט | הוכחה |
|---|------|--------|
| 1 | Child `ea-eyalamit` — גרסת תמה **1.3.1**; `ea-m4-polish`; Rubik; פלטה + דריסת משתני GP ב־inline; תיקון `body` ב־`/en/` (ללא `rtl`) | `functions.php`, `style.css` |
| 2 | פריסת FTP לסטייג’ינג (מחזורי) | [`M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md`](./M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-01.md) · [`M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-07.md`](./M3-M4-STAGING-DEPLOY-VERIFY-TEAM10-2026-04-07.md) |
| 3 | בקשת מוכנות **QA-M4** | [`M3-QA-M4-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-M4-READINESS-REQUEST-TEAM10-2026-04-01.md) |
| 4 | מסירת שלב 1 ל־**100** | [`M3-M4-STAGE1-HANDOFF-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M4-STAGE1-HANDOFF-TEAM10-TO-TEAM100-2026-04-01.md) |
| 5 | הגשה חוזרת אחרי דוח QA-M4 | [`M3-QA-M4-READINESS-RESUBMISSION-TEAM10-2026-04-07.md`](./M3-QA-M4-READINESS-RESUBMISSION-TEAM10-2026-04-07.md) |
| 6 | דוח השלמה ל־**100** (אחרי QA-M4) | [`M3-M4-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-07.md`](./M3-M4-COMPLETION-HANDOFF-TEAM10-TO-TEAM100-2026-04-07.md) |

---

**צוות 100** — אורקסטרציה M3
