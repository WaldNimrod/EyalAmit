# M3 — בקשת **QA-0** (מוכנות מטריצת בסיס) — מצוות **10** לצוות **50**

**תאריך:** 2026-04-07  
**מוציא:** צוות **10**  
**אל:** צוות **50** (QA)  
**מנדט ביצוע קנוני ל־50:** [`../team_50/M3-QA-0-BASELINE-MATRIX-MANDATE-TEAM50-2026-04-07.md`](../team_50/M3-QA-0-BASELINE-MATRIX-MANDATE-TEAM50-2026-04-07.md)

---

## הצהרת השלמה

**מטריצת מילוי עמודים גרסה v1 הושלמה** ומאושרת להעברה לשער QA-0:

- [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md) (כולל נספח ספירת כיסוי)

**סביבת אימות לדגימה (סטייג'ינג):** `http://eyalamit-co-il-2026.s887.upress.link` · מדיניות TLS: [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md) · runbook: [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)

---

## בדיקת עצמית צוות 10 (לפני מסירה)

| מזהה | תיאור | תוצאה | הערה קצרה |
|------|--------|--------|-----------|
| **Q0-1** | כיסוי מטריצה ↔ `site-tree.json` | **PASS** | 35 צמתים, 35 שורות; סקריפט אימות מקומי + נספח במטריצה |
| **Q0-2** | עקביות `pageId` | **PASS** | כל המזהים קיימים ב־[`hub/data/site-tree.json`](../../hub/data/site-tree.json) |
| **Q0-3** | שדות מלאים (שורות שאינן `N/A` בסטטוס WP) | **PASS** | סטטוס WP + סטטוס תוכן מלאים; 4 שורות `N/A` + 1 שורה `אין` מתועדות |
| **Q0-4** | הצעת דגימה ל־5 צמתים | **מוכן** | ראו טבלה למטה — צוות 50 יבחר/יאמת לפי המנדט |
| **Q0-5** | אין 404 שקט בדגימה | **PASS** | `curl -L` ל־5 הנתיבים — כולם מסתיימים ב־HTTP 200 |

### דגימת 5 צמתים ל־Q0-4 (סומנו «חי» במטריצה)

| pageId | slug (סטייג'ינג) | URL לבדיקה |
|--------|-------------------|------------|
| `st-home` | `home` | `http://eyalamit-co-il-2026.s887.upress.link/home/` → מפנה ל־`/` (200) |
| `st-contact` | `contact` | `http://eyalamit-co-il-2026.s887.upress.link/contact/` |
| `st-method` | `method` | `http://eyalamit-co-il-2026.s887.upress.link/method/` |
| `st-faq` | `faq` | `http://eyalamit-co-il-2026.s887.upress.link/faq/` |
| `st-blog` | `blog` | `http://eyalamit-co-il-2026.s887.upress.link/blog/` |

---

## פלט מצוות 50 (התקבל)

דוח **`FINAL`** פורסם תחת `_communication/team_50/`:

- [`../team_50/M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md`](../team_50/M3-QA-0-BASELINE-MATRIX-REPORT-2026-04-07.md) — **`PASS WITH NOTES`** · Q0-1–Q0-5 **PASS**; הערות — כפילויות REST ויישור slug (במטריצה; בעלות 10/100 ל־M3-M2).
- [`../team_50/M3-QA-0-DOC-SYNC-RETEST-TEAM50-2026-04-07.md`](../team_50/M3-QA-0-DOC-SYNC-RETEST-TEAM50-2026-04-07.md) — בדיקה חוזרת **תיעוד בלבד** (אימות קישורים מול עדכון 100) — **PASS**; ללא curl/REST חוזר לסטייג’ינג.

---

## עדכון לצוות 100

אורקסטרציה: שורות **חבילה 1** ו־**QA-0** עודכנו ב־[`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md) — M3-M0 **סגור** ב־10; **QA-0 סגור** ב־50 (**`PASS WITH NOTES`**). לפי מנדט: צוות **100** רשאי להמשיך ל־**M3-M2** ולפרסם מנדט **QA-1**.

---

*בקשת QA-0 — צוות 10 (סגורה לאחר דוח FINAL).*
