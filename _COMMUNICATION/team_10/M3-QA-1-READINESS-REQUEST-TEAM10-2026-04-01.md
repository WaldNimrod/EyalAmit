# M3 — בקשת **QA-1** (מוכנות עמודים + תוכן בסיסי) — מצוות **10** לצוות **50**

**תאריך:** 2026-04-01  
**מוציא:** צוות **10**  
**אל:** צוות **50** (QA)  
**מנדט ביצוע קנוני ל־50:** [`../team_50/M3-QA-PAGES-CONTENT-MANDATE-TEAM50-2026-03-29.md`](../team_50/M3-QA-PAGES-CONTENT-MANDATE-TEAM50-2026-03-29.md)

---

## הקשר מנדט M3-M2

- מנדט ביצוע: [`M3-M2-PAGES-CONTENT-MANDATE-TEAM10-2026-03-29.md`](./M3-M2-PAGES-CONTENT-MANDATE-TEAM10-2026-03-29.md)  
- רשימת ביצוע סטייג’ינג: [`M3-M2-STAGING-EXECUTION-CHECKLIST-TEAM10-2026-04-01.md`](./M3-M2-STAGING-EXECUTION-CHECKLIST-TEAM10-2026-04-01.md)  
- תיק החלטות **100:** [`M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md)  
- מטריצה (v2): [`M3-PAGE-FILL-MATRIX-2026-04-07.md`](./M3-PAGE-FILL-MATRIX-2026-04-07.md)

**סביבת אימות:** `https://eyalamit-co-il-2026.s887.upress.link` · מדיניות TLS: [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md) · runbook: [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) — לבדיקות HTTP מומלץ `curl -kL`.

---

## בדיקת עצמית צוות 10 (מול QA-1)

| מזהה | תיאור | תוצאה | הערה |
|------|--------|--------|------|
| **Q1-1** | עמודים מול עץ (צמתים «חי», ללא 5 החרגות N/A/אין) | **PASS** | סריקה אוטומטית 2026-04-01: **30** נתיבים מ־[`hub/data/site-tree.json`](../../hub/data/site-tree.json) (לא כולל `st-blog-post`, `st-extra-pages`, `st-gallery-cms`, `st-404`, `st-html-sitemap`) — כולם **HTTP 200** סופי עם `curl -kL`. ראו נספח D במטריצה. |
| **Q1-2** | דגימת **≥5** תבניות שונות (`tpl-*`) | **PASS** | דגימה: `tpl-home` → `/home/` · `tpl-service` → `/treatment/` · `tpl-method` → `/method/` · `tpl-nav-hub` → `/learning/` · `tpl-lecture-product` → `/lectures/` |
| **Q1-3** | תוכן בסיסי — אין גוף ריק ב«חיים» | **PASS WITH NOTES** (דוח 50) | דוח **FINAL** 2026-04-07: דגימה על **6** עמודים — גודל HTML וטקסט גולמי תקפים; אימות מלא מול כל PLACEHOLDER/R# במטריצה — **מחוץ** ל־smoke (מומלץ לסגור במסירה ל־**QA-2**). |
| **Q1-4** | ניווט (תפריטים) | **PASS** (דוח 50) | **26** קישורי `menu-item` / `<nav>` מדף הבית — כולם **200** (`curl -kL`); תיקון לעומת **PENDING** בטיוטת 10. |
| **Q1-5** | RTL | **PASS** (דוח 50) | דף הבית: `dir="rtl"` · `lang="he-IL"`; `/en/`: `lang="en"` · `dir="ltr"`. |
| **Q1-6** | מעקב הערות QA-0 (כפילויות REST / יישור slug) | **PASS WITH NOTES** (דוח 50) | ב־REST עדיין כפילויות ל־`lectures`, `sound-healing`, `workshops` — **פתוח מול צוות 100** (ראו דוח + תיק governance). |

---

## פלט מצוות 50 (התקבל)

דוח **`FINAL`** (תאריך ביצוע בפועל בקובץ — **2026-04-07**, לא התאריך 2026-04-01 שהוצע בטקסט המקורי של בקשה זו):

- [`../team_50/M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md`](../team_50/M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md) — **`PASS WITH NOTES`** · טבלת תוצאות מלאה לפי **Q1-1–Q1-6** בגוף הדוח.

### מה נבדק בפועל (סטייג’ינג, `curl -kL`)

| בדיקה | ממצא |
|--------|------|
| **Q1-1** | **30** נתיבי «חי» (אותן **5** החרגות כבבקשת 10) — כולם **HTTP 200** סופי. |
| **Q1-2** | **5** תבניות: בית, טיפול, שיטה, לימודים, הרצאות (הרצאות תחת `/learning/lectures/`). |
| **Q1-3** | דגימה על **6** עמודים — גודל HTML וטקסט גולמי תקפים; אימות מלא מול כל PLACEHOLDER/R# — **מחוץ** ל־smoke. |
| **Q1-4** | **26** קישורי תפריט מדף הבית — כולם **200**. |
| **Q1-5** | `dir="rtl"` · `lang="he-IL"` בבית; `lang="en"` · `dir="ltr"` ב־`/en/`. |
| **Q1-6** | ב־REST עדיין כפילויות: `lectures`, `sound-healing`, `workshops` — **פתוח** מול **צוות 100**. |

### הנחיה לצוות **100** (אורקסטרציה)

לפני פרסום **חבילה 3** / מסירה רשמית ל־**QA-2**: לסגור את נושא **Q1-6** — החלטה על עמוד קנוני / 301 / השבתת כפיל (או **waiver** מתועד) — ראו [`M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](./M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md) ודוח **QA-1** לעיל. עד אז, **PASS WITH NOTES** של QA-1 נשאר עם בעלים **100** לכפילויות REST האמורות.

---

## פלט צפוי (לתיעוד — הושלם)

לפי מנדט QA-1 — דוח **`FINAL`** תחת `_communication/team_50/`:

**שם בפועל:** `M3-QA-PAGES-CONTENT-REPORT-TEAM50-2026-04-07.md`

חובה בדוח: `**סטטוס:** FINAL` · `**תוצאה:**` אחת מ־PASS / PASS WITH NOTES / FAIL · טבלת ממצאים לפי מזהי בדיקה.

---

## עדכון לצוות 100

אורקסטרציה: **QA-1 סגור** ב־50 (**`PASS WITH NOTES`**) — יומן ב־[`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md). **חבילה 2** (מבחינת שער QA-1) הושלמה; המשך: סגירת **Q1-6** לפני **QA-2** (כניסוח לעיל).

---

*בקשת QA-1 — צוות 10 (מסירה ל־50 הושלמה; דוח FINAL התקבל 2026-04-07).*
