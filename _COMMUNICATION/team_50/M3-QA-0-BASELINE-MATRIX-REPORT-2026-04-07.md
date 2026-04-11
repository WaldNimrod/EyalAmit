# M3 — דוח QA-0: מטריצת בסיס מול `site-tree.json`

**סטטוס:** `FINAL`  
**תוצאה:** `PASS WITH NOTES`  
**תאריך דוח:** 2026-04-07  
**מבצע:** צוות **50** (QA)  
**מנדט:** [`M3-QA-0-BASELINE-MATRIX-MANDATE-TEAM50-2026-04-07.md`](./M3-QA-0-BASELINE-MATRIX-MANDATE-TEAM50-2026-04-07.md)  
**מטריצה נבדקת:** [`../team_10/M3-PAGE-FILL-MATRIX-2026-04-07.md`](../team_10/M3-PAGE-FILL-MATRIX-2026-04-07.md) (v1)  
**עץ נעול:** [`../../hub/data/site-tree.json`](../../hub/data/site-tree.json)  
**סטייג’ינג:** `https://eyalamit-co-il-2026.s887.upress.link` (REST `wp/v2/pages`, TLS לפי [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md) §6 — `curl -k`)

---

## סיכום מנהלים

מטריצת M3-M0 מכסה את כל 35 צמתי העץ; כל `pageId` במטריצה קיים ב־`site-tree.json`; שדות סטטוס WP ותוכן מלאים בכל שורה שאינה `N/A` לפי ההגדרה במנדט. דגימת חמישה עמודים «חי» מול סטייג’ינג: קיים עמוד/נתיב תקף (כולל מעקב אחרי 301 ל־canonical); לא נצפה 404 «שקט» בדגימה.

**הערות (לא שער עצירה ל־QA-0):** במטריצה כבר מתועדות כפילויות שורות ב־REST ל־`lectures`, `sound-healing`, `workshops` — נשאר תחת **צוות 10** / כיוון **צוות 100** ב־M3-M2.

---

## טבלת תוצאות (חובה)

| ID בדיקה | תוצאה | הערה | בעלים (10/100) |
|----------|--------|------|----------------|
| Q0-1 | **PASS** | 35 צמתים ב־`site-tree.json`; 35 שורות במטריצה (כמתועד בנספח המטריצה). | — |
| Q0-2 | **PASS** | `diff` ממוין בין רשימת `nodes[].id` לבין עמודת `pageId` במטריצה — זהות מלאה (אין מזהה יתום / חסר). | — |
| Q0-3 | **PASS** | 4 שורות עם **N/A** ב־WP (וגם בתוכן): `st-blog-post`, `st-extra-pages`, `st-gallery-cms`, `st-404`. שורה `st-html-sitemap`: **אין** / **PLACEHOLDER** — מלא ומתועד. כל שאר השורות: **חי** + עמודת תוכן לא ריקה. | — |
| Q0-4 | **PASS** | דגימה (5× «חי»): `st-home` → `/home/` (301 ל־`/`), `st-svc-treatment` → `treatment`, `st-contact` → `contact`, `st-book-tsva` → `tsva-bechol-ve-zorek-layam` (301 ל־`/muzeh/tsva-bechol-ve-zorek-layam/`), `st-legal-access` → `accessibility`. אימות REST: כל ה־slugs הופיעו ברשימת `wp/v2/pages` (סה״כ 45 עמודים בתשובה). סטייה מהעץ (`muzeh/...` מול slug ילד ב־WP) **מתועדת במטריצה** ל־`st-book-tsva`. | 10 / 100 לפי צורך יישור slug |
| Q0-5 | **PASS** | אחרי `-L`: כל חמשת הנתיבים הסתיימו ב־**HTTP 200**; לא זוהה דף חי עם 404 קשיח בדגימה. | — |

---

## ראיות טכניות (תמצית)

- ספירת צמתים: `jq '.nodes | length' hub/data/site-tree.json` → **35**.
- REST: `curl -sS -k 'https://eyalamit-co-il-2026.s887.upress.link/wp-json/wp/v2/pages?per_page=100'` → **45** רשומות; slugs הדגימה נכללו ברשימה.
- HTTP (עם מעקב הפניות): `/home/`, `/treatment/`, `/contact/`, `/tsva-bechol-ve-zorek-layam/`, `/accessibility/` — סטטוסים סופיים **200** (לאחר 301 ל־`/` ול־`/muzeh/tsva-bechol-ve-zorek-layam/` בהתאמה).

---

## המלצת המשך (לפי מנדט)

**PASS / PASS WITH NOTES** → מעבר ל־**M3-M2** לפי [`../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md`](../team_100/M3-EXECUTION-PLAN-AND-MANDATES-TEAM100-2026-04-07.md); צוות **100** יפרסם מנדט QA-1 וקישור ביומן האורקסטרציה.

---

**צוות 50** — סגירת שער M3 QA-0
