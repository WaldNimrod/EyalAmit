# M2 — צ׳ק־ליסט שער פנימי (סטייג’ינג) — אחרי פריסת חבילת עץ נעול

**תאריך:** 2026-03-29  
**בסיס URL (runbook):** `https://eyalamit-co-il-2026.s887.upress.link`  
**מטרה:** לאשר ש־MU + child מהמאגר רצו לפני בקשת ריטסט לצוות 50.

---

## א. ראיה מרוכזת אחרי פריסה

לאחר `python3 scripts/ftp_deploy_site_wp_content.py` + `GET /` — ראו  
[`M2-STAGING-DEPLOY-VERIFY-ARTIFACT-2026-04-06.md`](./M2-STAGING-DEPLOY-VERIFY-ARTIFACT-2026-04-06.md).  
**אחרי צוות 50:** דוח FINAL — [`../team_50/M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md`](../team_50/M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md) (**PASS WITH NOTES**, F2).

**לפני פריסה (היסטורי):** צמתי העץ החזירו 404; legacy כמו `/shop/` היה 200 — תואם דוח 50 הישן.

---

## ב. אחרי פריסה + טעינת דף אחת

| # | בדיקה | צפוי |
|---|--------|------|
| 1 | `GET /learning/` | 200 |
| 2 | `GET /treatment/` | 200 |
| 3 | `GET /lessons/` | 200 |
| 4 | `GET /tools-and-accessories/` | 200 |
| 5 | `GET /muzeh/` | 200 |
| 6 | `GET /media/` | 200 |
| 7 | `GET /faq/` | 200 |
| 8 | `GET /privacy/` | 200 |
| 9 | `GET /galleries/` | 200 |
| 10 | `GET /learning/courses-external/` | 200 |
| 11 | `GET /shop/` | 301 → `/tools-and-accessories/` |
| 12 | `GET /courses-soon/` | 301 → `/learning/courses-external/` |
| 13 | `GET /accessibility-statement/` | 301 → `/accessibility/` |
| 14 | `GET /en/` — `view-source` | `<html lang="en" dir="ltr">` (או שקול) |
| 15 | דף הבית — HTML | קישור טיפול ל־`/treatment/`; אין `/shop/` או `courses-soon` בתבנית |
| 16 | הדר | קישור **EN** נראה; **אין** פריט English בתפריט ה-primary |
| 17 | פוטר | ניווט `ea-footer-legal-nav` עם FAQ, גלריות, מדיה, פרטיות, נגישות, תקנון |
| 18 | תפריט primary | ללא «בית» כטקסט; קורסים כקישור חיצוני (custom) |

---

## ג. אופציה בסיס נתונים

אם הסנכרון לא רץ: לוודא שקובץ ה־MU עלה ושאין שגיאת PHP בלוג; ניתן לאלץ מחדש עם `delete_option('ea_m2_site_tree_lock_sync_v2')` ואז לרענן.
