# M3 — דוח QA-1: עמודים, תוכן בסיסי, ניווט ו־RTL (סטייג’ינג)

**סטטוס:** `FINAL`  
**תוצאה:** `PASS WITH NOTES`  
**תאריך דוח:** 2026-04-07  
**מבצע:** צוות **50** (QA)  
**בקשת מוכנות:** [`../team_10/M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md`](../team_10/M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md)  
**מנדט ביצוע:** [`M3-QA-PAGES-CONTENT-MANDATE-TEAM50-2026-03-29.md`](./M3-QA-PAGES-CONTENT-MANDATE-TEAM50-2026-03-29.md)  
**עץ נעול:** [`../../hub/data/site-tree.json`](../../hub/data/site-tree.json)  
**מטריצה:** [`../team_10/M3-PAGE-FILL-MATRIX-2026-04-07.md`](../team_10/M3-PAGE-FILL-MATRIX-2026-04-07.md) (v2)  
**סטייג’ינג:** `https://eyalamit-co-il-2026.s887.upress.link` · TLS: [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md) — בדיקות: `curl -kL`

---

## סיכום מנהלים

- **30** צמתי «חי» (החרגות כמפורט במוכנות 10: ללא `st-blog-post`, `st-extra-pages`, `st-gallery-cms`, `st-404`, `st-html-sitemap`) — כולם **HTTP 200** אחרי מעקב הפניות, עם ניסיון גיבוי ל־slug אחרון לילדים תחת `muzeh/` כשהנתיב המלא לא נדרש.
- דגימת **≥5** תבניות (`tpl-home`, `tpl-service`, `tpl-method`, `tpl-nav-hub`, `tpl-lecture-product`) — רינדור תקין בנתיבים: `/` (בית), `/treatment/`, `/method/`, `/learning/`, `/learning/lectures/`.
- תוכן בסיסי: דגימת גודל HTML וטקסט גולמי (אחרי הסרת script/style) על **שישה** עמודים חיים — אין גוף «ריק»; עמודים עם **PLACEHOLDER** במטריצה נשארים בטווח גודל דומה לשאר (לא בוצעה השוואה מילולית מלאה מול R#).
- ניווט: **26** קישורי תפריט (מחלקות `menu-item` + `<nav>` בדף הבית) — כולם **200**.
- RTL: דף הבית `<html dir="rtl" lang="he-IL">`; `/en/` — `<html lang="en" dir="ltr">`.
- **הערה (Q1-6):** ב־REST עדיין **כפילויות slug** ל־`lectures`, `sound-healing`, `workshops` (שתי רשומות לכל אחד) — תואם מעקב QA-0; **פתוח** מול [`../team_10/M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md`](../team_10/M3-M2-GOVERNANCE-BACKLOG-TEAM10-TO-TEAM100-2026-04-01.md) / החלטות **100**.

---

## טבלת תוצאות (חובה)

| ID בדיקה | תוצאה | הערה | בעלים (10/100) |
|----------|--------|------|----------------|
| Q1-1 | **PASS** | 30/30 נתיבים — `curl -kL` → **200** סופי (חרגו 5 צמתים כבקשת 10). | — |
| Q1-2 | **PASS** | 5 תבניות שונות ברינדור: בית, שירות, שיטה, hub לימודים, הרצאות (נתיבי דגימה לעיל). | — |
| Q1-3 | **PASS WITH NOTES** | שישה עמודים נדגמו (~45–54KB HTML, אורך טקסט גולמי ~500–680 תווים) — אין גוף ריק. אימות מלא מול כל שורת PLACEHOLDER/R# במטריצה — מחוץ להיקף smoke זה; מומלץ לסגור במסירה ל־QA-2. | 10 |
| Q1-4 | **PASS** | 26 קישורי תפריט מדף הבית — **200**; לא זוהו יעדי תפריט שבורים בדגימה. | — |
| Q1-5 | **PASS** | RTL בסיסי לעברית; EN עם LTR — כמטריצה. | — |
| Q1-6 | **PASS WITH NOTES** | כפילויות REST ל־3 slugs עדיין קיימות; נדרשת החלטת **100** (מיזוג/301/השבתה) לפני סגירה טכנית מלאה. | **100** (יישום 10 אחרי החלטה) |

---

## ראיות טכניות (תמצית)

- סקריפט Python: לולאה על `site-tree.json` (בלי 5 מזהים), בניית נתיב `/{slug}/` וגיבוי `/{segmentאחרון}/` לילדים; `subprocess` + `/usr/bin/curl -kL` — כל התוצאות `200`.
- `wp/v2/pages?per_page=100`: `duplicate slugs: [('lectures', 2), ('sound-healing', 2), ('workshops', 2)]`.
- דגימת תוכן: `/treatment/`, `/faq/`, `/en/`, `/privacy/`, `/muzeh/`, `/contact/` — גדלי גוף לעיל.

---

## המלצת המשך

**PASS WITH NOTES** → מעבר אפשרי ל־**M3-M3** / **QA-2** לפי [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md), בכפוף לסגירת נושא **Q1-6** בתיק **100** או קבלת waiver מתועד.

**קישור חוזר:** בקשת המוכנות מ־10 עודכנה בסעיף «פלט מצוות 50 (התקבל)» — [`../team_10/M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md`](../team_10/M3-QA-1-READINESS-REQUEST-TEAM10-2026-04-01.md).

---

**צוות 50** — סגירת שער M3 QA-1 (ביצוע)
