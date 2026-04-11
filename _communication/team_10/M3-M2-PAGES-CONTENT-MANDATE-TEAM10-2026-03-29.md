# M3-M2 — מנדט: שלד עמודים + מיגרציית תוכן מ־legacy (צוות **10**)

**תאריך:** 2026-03-29  
**מוציא:** צוות **100** (אורקסטרציה)  
**אל:** צוות **10**  
**תוכנית מסגרת:** [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md)  
**תלות:** **QA-0 סגור** — דוח **FINAL** [`../team_50/M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md`](../team_50/M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md) · **`PASS WITH NOTES`** (הערות המשך — כפילויות REST, יישור slug — **באחריות 10/100** במסגרת מנדט זה).  
**שער הבא:** [`../team_50/M3-QA-PAGES-CONTENT-MANDATE-TEAM50-2026-03-29.md`](../team_50/M3-QA-PAGES-CONTENT-MANDATE-TEAM50-2026-03-29.md) (**QA-1**)

---

## מטרה

לבנות **כל** העמודים הנדרשים לפי [`hub/data/site-tree.json`](../../hub/data/site-tree.json) והתבניות ב־[`hub/data/page-templates.json`](../../hub/data/page-templates.json); למלא **תוכן בסיסי** מ־**legacy** (העתקה, חיתוך, התאמת כותרות/פסקאות) כפי שממופה ב־[`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md); להשאיר רק מה שמסומן **PLACEHOLDER** / חסר — עם הפניה ל־[`M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md`](../team_100/M3-TEXT-PLACEHOLDER-REQUIREMENTS-FOR-RESEARCH-2026-04-07.md) ולמסירות מחקר.

---

## קלטים חובה

| # | מקור |
|---|------|
| 1 | [`hub/data/site-tree.json`](../../hub/data/site-tree.json) |
| 2 | [`hub/data/page-templates.json`](../../hub/data/page-templates.json) |
| 3 | [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) — מקור עבודה למצב עמוד ותוכן |
| 4 | אתר **legacy** + SSOT / [`CONTENT-SSOT-INVENTORY.csv`](../../docs/project/team-100-preplanning/CONTENT-SSOT-INVENTORY.csv) |
| 5 | [`M2-CONTENT-INTAKE-FROM-EYAL-2026-04-03.md`](./M2-CONTENT-INTAKE-FROM-EYAL-2026-04-03.md) §3 · כלי ייבוא / `scripts/m2_emit_pages_wxr.py` לפי הצורך |
| 6 | סטייג’ינג — [`M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) |

---

## כללים

- שינוי **slug / הורה** — רק באישור **צוות 100** (QR / P22).  
- **תמונות** — לפי נוהל Drive ותקרת 150KB למחיצה (כמתואר בתוכנית M3).  
- **מקביל:** **M3-M1** (טקסטים למחקר) — אין לחסום מיגרציה; סמנו `PLACEHOLDER_COPY` במטריצה/Hub לפי נוהל.

---

## פלט חובה

1. **ב־WordPress (סטייג’ינג):** עמודים עם התבנית הנכונה, תוכן בסיסי נטען או `PLACEHOLDER` מתועד.  
2. **מטריצה:** עדכון [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) (או נספח/גרסה חדשה לפי נוהל 100) — סטטוס WP / תוכן משקפים מצב אחרי **M3-M2**.  
3. **בקשת מוכנות ל־QA-1** (מסמך תחת `team_10/` או עדכון למנדט 50 — לפי הנוהל שיפורסם עם תחילת הביצוע): טבלת עצמי מול בדיקות **Q1-*** במנדט QA-1, דגימות, בסיס URL סטייג’ינג.

---

## סיום

כשהמסירה **מוכנה לבדיקת QA-1**, עדכנו **צוות 100** ופתחו קו מול **צוות 50** לפי [`../team_50/M3-QA-PAGES-CONTENT-MANDATE-TEAM50-2026-03-29.md`](../team_50/M3-QA-PAGES-CONTENT-MANDATE-TEAM50-2026-03-29.md).

**סטטוס מנדט M3-M2:** **CLOSED לשער QA-1** (צוות 10) — מסירה ל־50; **QA-1** סגור (**`PASS WITH NOTES`**, 2026-04-07). **המשך:** יישום החלטות **100** על **Q1-6** (כפילויות REST) לפני **QA-2**.

---

## ביצוע ומסירה (מאגר — 2026-04-01)

| # | נושא | קישור |
|---|------|--------|
| 1 | תיק החלטות **100** (slug, כפילויות REST, איחודים) | [`M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md) |
| 2 | רשימת ביצוע סטייג’ינג (שלד · תוכן · ניווט) | [`M3-M2-STAGING-EXECUTION-CHECKLIST-TEAM10-2026-04-01.md`](./M3-M2-STAGING-EXECUTION-CHECKLIST-TEAM10-2026-04-01.md) |
| 3 | מטריצה v2 + נספחי מעקב (B–D) | [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) |
| 4 | בקשת מוכנות **QA-1** (+ פלט מצוות 50) | [`M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md) |
| 5 | יומן אורקסטרציה צוות 100 | [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) |
| 6 | דוח **QA-1 FINAL** — **`PASS WITH NOTES`** | [`../team_50/M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md) |

**דוח בפועל ל־50 (תאריך ביצוע בקובץ):** `M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md` — ראו [`M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md`](./M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md)

---

**צוות 100** — אורקסטרציה M3
