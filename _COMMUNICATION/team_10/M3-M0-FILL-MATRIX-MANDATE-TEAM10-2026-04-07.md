# M3-M0 — מנדט: מטריצת מילוי עמודים (צוות **10**)

**תאריך:** 2026-04-07  
**מוציא:** צוות **100** (אורקסטרציה)  
**אל:** צוות **10**  
**תוכנית מסגרת:** [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md)  
**שער QA-0 (הושלם 2026-04-07):** מנדט [`../team_50/M3-QA-0-BASELINE-MATRIX-MANDATE-TEAM50-2026-04-07.md`](../team_50/M3-QA-0-BASELINE-MATRIX-MANDATE-TEAM50-2026-04-07.md) · דוח **FINAL** [`../team_50/M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md`](../team_50/M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md) · **`PASS WITH NOTES`**

---

## מטרה

להשלים **מפת מילוי אחת** לכל צומת בעץ הנעול: סטטוס עמוד ב־WP, מקור legacy לתוכן, סטטוס תוכן — כדי לאפשר אורקסטרציה של M3 ושער **QA-0**.

---

## קלטים חובה

| # | מקור |
|---|------|
| 1 | [`hub/data/site-tree.json`](../../hub/data/site-tree.json) |
| 2 | [`hub/data/page-templates.json`](../../hub/data/page-templates.json) |
| 3 | אתר **legacy** + SSOT / [`CONTENT-SSOT-INVENTORY.csv`](../../docs/project/team-100-preplanning/CONTENT-SSOT-INVENTORY.csv) לפי צורך |
| 4 | סטייג’ינג — מצב עמודים קיים (ראו [`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](./M2-IMPLEMENTATION-SUMMARY-2026-04-01.md)) |

---

## פלט חובה (נתיב קנוני)

**קובץ עבודה:** [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md)

- השלד (35 שורות מ־`site-tree`) כבר נוצר — **יש למלא** את העמודות הריקות.  
- לכל שורה: **סטטוס WP** (טיוטה / חי / אין / `N/A`), **סטטוס תוכן** (legacy / חלקי / `PLACEHOLDER` + מזהה R# ממסמך המחקר אם רלוונטי), **הערות** (כולל `DEFERRED` + בעלים אם צריך אישור 100).

---

## כללים

- **אין** צומת «חי» בעץ בלי שורה במטריצה (או החלטת `N/A` מתועדת).  
- שינוי **slug / הורה** — רק באישור **צוות 100** (QR / P22).  
- **טקסטים זמניים מהמחקר** — צפויים בקרוב; אין לחסום את מילוי המטריצה — סמנו `PLACEHOLDER` והפניה ל־[`M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md`](../team_100/M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md).

---

## סיום

כשהמטריצה **מלאה לגרסה v1**, עדכנו את **צוות 100** + פתחו בקשה ל־**QA-0** לפי מנדט צוות 50 לעיל.

## ביצוע וסגירה (2026-04-07)

| # | נושא | קישור / פלט |
|---|------|-------------|
| 1 | מטריצה v1 מלאה (35↔35, N/A×4, אין×1, נספח ספירה) | [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) |
| 2 | בדיקת עצמית Q0-1–Q0-5 (סקריפט מקומי + `curl -L` סטייג’ינג) | מתועדת בבקשת המוכנות |
| 3 | בקשת QA-0 ל־50 | [`M3-QA-0-READINESS-REQUEST-TEAM10-2026-04-07.md`](./M3-QA-0-READINESS-REQUEST-TEAM10-2026-04-07.md) |
| 4 | מנדט QA-0 — הועבר לביצוע צוות **50** | [`../team_50/M3-QA-0-BASELINE-MATRIX-MANDATE-TEAM50-2026-04-07.md`](../team_50/M3-QA-0-BASELINE-MATRIX-MANDATE-TEAM50-2026-04-07.md) |
| 5 | דוח QA-0 **FINAL** — **`PASS WITH NOTES`** | [`../team_50/M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md`](../team_50/M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md) |
| 6 | יומן אורקסטרציה צוות 100 | [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) |

**סטטוס מנדט M3-M0:** **CLOSED** (צוות 10) — שער **QA-0** נסגר ב־50 (**`PASS WITH NOTES`**).

**צוות 100** — אורקסטרציה M3
