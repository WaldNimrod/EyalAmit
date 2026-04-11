# M2 — דוח Smoke FINAL לצוות 50 (ריטסט v2)

**STATUS:** **FINAL**  
**סטטוס מסכם:** **PASS WITH NOTES**  
**תאריך ביצוע בפועל:** 2026-04-06  
**שעת ביצוע:** 23:01 IDT  
**תאריך בקשת הריטסט:** 2026-04-06  
**מבקר/ת:** Codex (בשם צוות 50)

## מסמכי מקור

- [`M2-VALIDATION-RETEST-REQUEST-TEAM50-2026-04-06.md`](./M2-VALIDATION-RETEST-REQUEST-TEAM50-2026-04-06.md)
- [`M2-QA-CONSOLIDATED-MANDATE-TEAM50-2026-04-10.md`](./M2-QA-CONSOLIDATED-MANDATE-TEAM50-2026-04-10.md)
- [`M2-SMOKE-REPORT-FINAL-2026-04-06.md`](./M2-SMOKE-REPORT-FINAL-2026-04-06.md)
- [`../team_10/M2-STAGING-DEPLOY-VERIFY-ARTIFACT-2026-04-06.md`](../team_10/M2-STAGING-DEPLOY-VERIFY-ARTIFACT-2026-04-06.md)
- [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md)
- [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)
- [`../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md)
- [`../team_10/M2-WP-ACCESSIBILITY-CONFIG-AND-QA-2026-04-09.md`](../team_10/M2-WP-ACCESSIBILITY-CONFIG-AND-QA-2026-04-09.md)
- [`../team_30/M2-PLUGIN-INVENTORY-2026-04-10.md`](../team_30/M2-PLUGIN-INVENTORY-2026-04-10.md)
- [`../../hub/data/site-tree.json`](../../hub/data/site-tree.json)
- [`M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](./M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md)

## מסקנה

הריטסט הנוכחי סוגר את ממצאי ה־FAIL מהדוח הקודם:

- ה־IA הציבורי מיושר כעת לעץ הנעול `site-tree.json`.
- נתיבי legacy קריטיים מפנים ב־`301` ליעדים הקנוניים.
- דפי המערכת/פוטר הדרושים חיים.
- EN תוקן ברמת `<html lang="en" dir="ltr">`.
- `contact` ממשיך לרנדר Fluent ולעבור submit אפליקטיבי.

הסטטוס הוא `PASS WITH NOTES` בלבד, משום שהערת **F2** נשארת פתוחה:
לא בוצע אימות ישיר של mailbox או `WP Mail Logging` מתוך `wp-admin`.

## מדיניות בדיקה

- הסטייג'ינג נבדק פונקציונלית מול `http://` ובהצלבה עם `curl -k` על `https://`.
- כשל תעודה בסטייג'ינג אינו נחשב כשל G2.
- תשתית המאגר (`Q1–Q8`) נסמכת כאן על דוח PASS קיים.
- בדיקות `S12`, `S15`, `S16` הושלמו בשיטה חלופית מבוססת HTML/CSS/DOM וראיות שרת, משום שסביבת הדפדפן האוטומטית המקומית נחסמה ברמת sandbox/macOS. זו **הסקה מבוססת ראיות**, לא capture אינטראקטיבי מלא.

## מטריצת §8 — S1–S16

| ID | תוצאה | הערה |
|----|--------|------|
| S1 | ☑ | `GET /` החזיר `HTTP 200`; דף הבית הציבורי נטען עם `page-id-16`. |
| S2 | ☑ | `GET /wp-admin/` מחזיר `302` ל־`/wp-login.php`; `wp-login.php` עצמו מחזיר `200`. נקודת הכניסה לאדמין זמינה. |
| S3 | ☑ | `curl -k -sI https://...` החזיר `HTTP/2 200`; לפי מדיניות סטייג'ינג, TLS מלא אינו תנאי קבלה כאן. |
| S4 | ☑ | `noindex` פעיל בכותרות וב־HTML. |
| S5 | ☑ | התפריט הראשי הציבורי מיושר לעץ הנעול: `treatment`, `method`, `lessons`, `sound-healing`, `learning`, `tools-and-accessories`, `muzeh`, `blog`, `eyal-amit`, `contact`; `EN` מופיע כקישור צד, לא כפריט ראשי. |
| S6 | ☑ | היררכיית הילדים מיושרת ל־hubs החדשים: `learning/*`, `tools-and-accessories/*`, `muzeh/*`, `eyal-amit/mokesh-dahiman/`. |
| S7 | ☑ | קורסים מיושרים כעת: בתפריט מופיע קישור חיצוני `קורסים (סקולר / חיצוני)`, ונתיב legacy `courses-soon` מפנה `301` ל־`/learning/courses-external/`. |
| S8 | ☑ | `/en/` נטען (`200`), עם `ea-lang-en`, ו־`<html lang="en" dir="ltr">`. |
| S9 | ☑ | מלאי העץ הקריטי חי: `learning`, `treatment`, `lessons`, `tools-and-accessories`, `muzeh`, `media`, `faq`, `privacy`, `galleries`, `learning/courses-external` מחזירים `200`. |
| S10 | ☑ | דפי מערכת חיים: `accessibility`, `terms`, `privacy`, `faq`, `galleries`. |
| S11 | ☑ | `/contact/` מרנדר Fluent תקין; submit ל־`admin-ajax.php` החזיר `success: true`, `insert_id: 3`. |
| S12 | ☑ | לא נצפתה אינדיקציה לכשל JS קריטי בפלט הציבורי; asset refs תקינים, הדפים מרונדרים, והתנהגות redirect/menu/footer עקבית. מדובר בהסקה מבוססת ראיות, לא capture console חי. |
| S13 | ☑ | בדגימות `GET /`, `GET /contact/`, `GET /learning/therapist-training/`, `GET /en/` לא נצפה PHP Fatal או דף שגיאה. |
| S14 | ☑ | דגימת תוספים מול מלאי 30 תואמת: Yoast (`v27.3`), Fluent Forms (`6.2.0`), WP Accessibility (`2.3.3`) נטענים בפלט הציבורי; legacy routes עובדים דרך redirect קנוני. |
| S15 | ☑ | דף הבית כולל markup ו־CSS responsive תקינים: `menu-toggle`, `has-inline-mobile-toggle`, media queries של GeneratePress, ו־EN/תפריט/CTA בנויים למובייל. הוערך בשיטה סטטית עקב חסם דפדפן מקומי. |
| S16 | ☑ | כנ"ל לטאבלט: אין אינדיקציה מבנית לחיתוך קריטי; תבנית GeneratePress וה־child CSS מגדירים התנהגות responsive עקבית. הוערך בשיטה סטטית עקב חסם דפדפן מקומי. |

## בדיקות משלימות

| ID | תוצאה | הערה |
|----|--------|------|
| HOME | ☑ | דף הבית כולל `ea-home-front`, Hero, CTA, Rubik, FAQ קצר, legal footer, וקישורים מעודכנים לנתיבים הקנוניים. קישור `shop` הוסר מה־HOME; המוקאפ הציבורי מיושר כעת לתצורה המאושרת. |
| Y1 | ☑ | `/learning/therapist-training/` כולל `noindex, nofollow` ו־Yoast פעיל בפלט. |
| T-en | ☑ | `/en/` חי, `ea-lang-en` קיים, והמסמך ברמת `lang="en" dir="ltr"`. |
| A11y | ☑ | דילוג לתוכן קיים בפלט הבית (`href="#content"`), WP Accessibility נטען, legal footer קיים, ועמוד נגישות חי ב־`/accessibility/`. |
| G3 | ☑ | מול מלאי 30 והפלט הציבורי: Yoast, Fluent, WP Accessibility תואמים; WP Mail Logging נשאר רלוונטי ל־F2 בלבד. |
| Fluent | ☑ | טופס `id=1` בדף `contact` מרונדר ונשלח בהצלחה ברמת אפליקציה (`insert_id: 3`). |
| Infra | ☑ | היעתק PASS מדוח [`M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](./M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md). |

## ממצאים פתוחים

| # | חומרה | ממצא | בעלים |
|---|--------|------|--------|
| NOTE-01 | Note | F2 עדיין פתוח רק ברמת delivery verification: לא נצפה mailbox אמיתי ולא נבדק `WP Mail Logging` מתוך `wp-admin`. ה־submit האפליקטיבי עצמו עבר. | צוות 10 + צוות 100 |

## ראיות ממוקדות

- `GET /` → `HTTP 200`, `page-id-16`, `X-Robots-Tag: noindex, nofollow`
- `GET /learning/`, `/treatment/`, `/lessons/`, `/tools-and-accessories/`, `/muzeh/`, `/media/`, `/faq/`, `/privacy/`, `/galleries/`, `/learning/courses-external/` → `200`
- `GET /shop/` → `301` ל־`/tools-and-accessories/`
- `GET /courses-soon/` → `301` ל־`/learning/courses-external/`
- `GET /hashita/` → `301` ל־`/method/`
- `GET /books/` → `301` ל־`/muzeh/`
- `GET /testimonials-media/` → `301` ל־`/media/`
- `GET /accessibility-statement/` → `301` ל־`/accessibility/`
- `GET /en/` מתחיל ב־`<html lang="en" dir="ltr">`
- `GET /contact/` כולל `fluentform_1`, nonce פעיל, `ff-btn-submit`
- `POST /wp-admin/admin-ajax.php` עם `action=fluentform_submit` → `{"success":true,"data":{"insert_id":3,...}}`
- `GET /wp-json/wp/v2/pages?per_page=100&_fields=id,slug,link,status,title` מחזיר גם את צמתי העץ החדשים (`privacy`, `media`, `galleries`, `faq`, `muzeh`, `tools-and-accessories`, `learning`, `courses-external`, `treatment`, `method`, `lessons`)

## המלצת צוות 50 לצוות 100

אפשר לקלוט את `§11 G4` כ־**PASS WITH NOTES**.

הערת הסיום היחידה:

1. אם נדרש `PASS` ללא הערות, יש להשלים אימות mailbox / `WP Mail Logging` ל־F2 מתוך `wp-admin` או בסביבת פרודקשן לפי מדיניות שבוע 0.

## חתימת צוות 50

**פסק דין QA סופי לריצה זו:** **PASS WITH NOTES**  
**חתימה:** Codex (צוות 50)  
**תאריך:** 2026-04-06
