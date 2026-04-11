# M2 — דוח Smoke FINAL לצוות 50

> **נספח audit:** פסק הדין המעודכן אחרי ריטסט — [`M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md`](./M2-SMOKE-REPORT-FINAL-2026-04-06-v2.md) (**PASS WITH NOTES**, F2).

**STATUS:** **FINAL**  
**סטטוס מסכם:** **FAIL**  
**תאריך ביצוע בפועל:** 2026-04-06  
**שעת ביצוע:** 22:10 IDT  
**תאריך המנדט/בקשה בהקשר:** 2026-04-10  
**מבקר/ת:** Codex (בשם צוות 50)

## מסמכי מקור

- [`../team_100/M2-WORKPLAN-AND-MANDATES-2026-03-30.md`](../team_100/M2-WORKPLAN-AND-MANDATES-2026-03-30.md)
- [`../team_100/M2-FULL-CLOSEOUT-PLAN-2026-04-10.md`](../team_100/M2-FULL-CLOSEOUT-PLAN-2026-04-10.md)
- [`../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md)
- [`../team_20/M2-RUNBOOK-ENV-2026-03-31.md`](../team_20/M2-RUNBOOK-ENV-2026-03-31.md)
- [`../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md)
- [`../team_10/M2-G2-STAGING-P0-DONE-2026-04-04.md`](../team_10/M2-G2-STAGING-P0-DONE-2026-04-04.md)
- [`../team_10/M2-WP-ACCESSIBILITY-CONFIG-AND-QA-2026-04-09.md`](../team_10/M2-WP-ACCESSIBILITY-CONFIG-AND-QA-2026-04-09.md)
- [`../team_30/M2-PLUGIN-INVENTORY-2026-04-10.md`](../team_30/M2-PLUGIN-INVENTORY-2026-04-10.md)
- [`../../hub/data/site-tree.json`](../../hub/data/site-tree.json)
- [`M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](./M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md)

## מסקנה קנונית

הבדיקה הסופית **נכשלת** לא בגלל TLS של הסטייג'ינג, אלא בגלל פער מהותי מול **העץ הנעול** `site-tree.json`:

- התפריט הציבורי וה־slugs בפועל עדיין מיושרים ברובם למבנה legacy / §7 הישן.
- צמתי IA נעולים וחיוניים לעץ הסופי חסרים או לא מיושמים בנתיבים המאושרים.
- מערכת העמודים/פוטר עדיין אינה תואמת לעץ הנעול.

בהתאם ל־§8.6, זהו **FAIL** בגלל **S9** (מלאי מול מקור אמת נעול), ובפועל גם **S5–S7** ו־**S10** נכשלים.

## מדיניות סביבה לביצוע הבדיקה

- הסטייג'ינג נבדק פונקציונלית מול `http://` ובהצלבה עם `curl -k` על `https://`, בהתאם ל־[`STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md`](../team_20/STAGING-TLS-VS-PRODUCTION-WORKFLOW-2026-04-02.md).
- כשל תעודה ב־`https://` על `*.upress.link` **לא** נספר כאן ככשל G2.
- תשתית המאגר (**Q1–Q8**) מסומנת כאן כהיעתק PASS מדוח קודם, בלי ריצה מלאה מחדש.

## מטריצת §8 — S1–S16

| ID | תוצאה | הערה |
|----|--------|------|
| S1 | ☑ | `GET /` החזיר `HTTP 200`; דף הבית הציבורי נטען עם `page-id-16`. |
| S2 | ◐ | `GET /wp-admin/` מחזיר `302` ל־`/wp-login.php`; `wp-login.php` עצמו מחזיר `200`. לא בוצעה התחברות אדמין בפועל בריצה זו כי לא סופקו אישורי גישה לצוות 50. |
| S3 | ☑ | `curl -k -sI https://...` החזיר `HTTP/2 200`. לפי מדיניות סטייג'ינג, אזהרת אמון/כשל תעודה אינם חוסמים. |
| S4 | ☑ | `noindex` פעיל: `X-Robots-Tag: noindex, nofollow` בכותרות ו־`<meta name='robots' content='noindex, nofollow' />` בפלט. |
| S5 | ✗ | התפריט הראשי אינו תואם לעץ הנעול: בפועל מופיעים `בית`, `שירותים`, `ספרים`, `קורסים` (`/courses-soon/`) ועוד; בעץ הנעול נדרשים צמתים כמו `treatment`, `learning`, `tools-and-accessories`, `muzeh`, ו־`English` כאיקון צד. |
| S6 | ✗ | היררכיית הילדים בפועל נשענת על `/services/...` legacy; בעץ הנעול חלק מהעמודים אמורים להיות top-level או תחת hubs אחרים. |
| S7 | ✗ | צומת הקורסים המאושר הוא `courses-external` חיצוני; בפועל `GET /courses-external/` מחזיר `404`, והתפריט/דף הבית מפנים ל־`/courses-soon/` פנימי. |
| S8 | ☑ | `/en/` נטען (`200`) וכולל מחלקת גוף `ea-lang-en`. הערת QA: מסמך ה־HTML עצמו עדיין `lang="he-IL"` ו־`dir="rtl"`. |
| S9 | ✗ | **Fatal.** מלאי הסטייג'ינג אינו תואם לעץ הנעול: `learning`, `treatment`, `lessons`, `tools-and-accessories`, `muzeh`, `media`, `faq`, `privacy`, `galleries`, `courses-external` חסרים או בנתיבים אחרים. |
| S10 | ✗ | דפי מערכת חלקיים בלבד: `terms` קיים, `accessibility` מפנה ל־`/accessibility-statement/`, אך `privacy`, `faq`, `galleries` חסרים (`404`). |
| S11 | ☑ | `/contact/` מרנדר Fluent תקין; submit ל־`admin-ajax.php` החזיר `success: true`, `insert_id: 2`. הערת F2: לא אומת mailbox / `WP Mail Logging`. |
| S12 | ◐ | לא בוצע capture ישיר של console browser בגלל כשל סביבתי בכלי Playwright (`/.playwright-mcp` read-only). בדגימת HTML/asset refs לא נצפתה אינדיקציה ל־Fatal front-end, אך זו אינה ראיית קונסול מלאה. |
| S13 | ☑ | בדגימות `GET /`, `GET /contact/`, `GET /therapist-training/`, `GET /en/` לא נצפה PHP Fatal או דף שגיאה; כל הנתיבים שנדגמו החזירו HTML תקין או `404` רגיל. |
| S14 | ◐ | דגימת תוספים ציבורית תואמת חלקית למלאי 30: זוהו Yoast (`v27.3`), Fluent Forms (`6.2.0`), WP Accessibility (`2.3.3`). לא בוצעה דגימת wp-admin ישירה למלאי המלא. |
| S15 | ◐ | יש אינדיקציה ב־GeneratePress ל־mobile toggle ו־CSS רספונסיבי ב־`max-width:768px`, אך לא בוצעה הרצת viewport חיה בגלל חסם כלי הדפדפן. |
| S16 | ◐ | כנ"ל לטאבלט: קיימת תמיכה CSS/תבנית, אך לא בוצעה ולידציית viewport חיה. |

## בדיקות משלימות

| ID | תוצאה | הערה |
|----|--------|------|
| HOME | ◐ | דף הבית כולל מאפייני מוקאף/תבנית מאושרים: `Rubik`, `ea-home-front`, Hero, CTA, בלוקים שיווקיים. עם זאת, הוא עדיין כולל CTA ל־`/shop/` וקישור `קורסים` ל־`/courses-soon/`, בניגוד לעץ הנעול ולמדיניות «אין חנות». |
| Y1 | ☑ | `/therapist-training/` כולל `noindex, nofollow` ו־Yoast פעיל בפלט. |
| T-en | ☑ | `/en/` חי וכולל `ea-lang-en`. הערת איכות: `html lang="he-IL"` ו־`dir="rtl"` נשארו ברמת המסמך. |
| A11y | ◐ | דילוג לתוכן קיים בפלט הבית (`<a class="screen-reader-text skip-link" href="#content">`), WP Accessibility נטען, ועמוד הצהרת נגישות קיים דרך `accessibility-statement`. מנגד, `privacy`/`faq`/`galleries` חסרים, ו־EN אינו מסומן כשפה/כיוון ברמת `<html>`. לא בוצעו keyboard/screen reader/Lighthouse חיים בגלל חסם כלי הדפדפן. |
| G3 | ◐ | מול מלאי 30: שלושת תוספי הליבה שזוהו ציבורית תואמים. דגימת "מול פאנל" למלאי 30 המלא לא בוצעה ללא גישת אדמין. |
| Fluent | ☑ | טופס `id=1` בדף `contact` מרונדר ונשלח בהצלחה ברמת אפליקציה. F2 נשאר הערת פרודקשן/אדמין בלבד. |
| Infra | ☑ | היעתק PASS מדוח [`M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](./M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md); לא בוצע ריצת Q1–Q8 מלאה מחדש. |

## ממצאים ובעלים

| # | חומרה | ממצא | בעלים |
|---|--------|------|--------|
| F-01 | Fatal | הסטייג'ינג אינו מיושר לעץ הנעול `site-tree.json`. בפועל מיושם מבנה legacy: `hashita`, `services/...`, `books`, `testimonials-media`, `courses-soon`, `shop`. | צוות 10 |
| F-02 | Fatal | צמתי IA נעולים חסרים או לא חיים בנתיבים המאושרים: `/learning/`, `/treatment/`, `/lessons/`, `/tools-and-accessories/`, `/muzeh/`, `/media/`, `/faq/`, `/privacy/`, `/galleries/`, `/courses-external/` מחזירים `404` או לא קיימים בפועל. | צוות 10 |
| F-03 | High | HOME והתפריט עדיין מפנים ל־`/shop/` ול־`/courses-soon/`, למרות החלטת 100 שאין חנות ושהקורסים הם צומת חיצוני `courses-external`. | צוות 10 + צוות 100 |
| F-04 | Medium | עמוד EN אמנם חי וכולל `ea-lang-en`, אבל המסמך עצמו נשאר `lang="he-IL"` ו־`dir="rtl"`. | צוות 10 |
| F-05 | Medium | דפי מערכת/פוטר לא שלמים מול העץ: `privacy`, `faq`, `galleries` חסרים; `accessibility` חי רק דרך redirect ל־`accessibility-statement`; בדגימת HTML הבית לא נמצאו קישורי footer/Legal תואמים לעץ הנעול. | צוות 10 |

## ראיות ממוקדות

- `GET /` → `HTTP 200`, `page-id-16`, `X-Robots-Tag: noindex, nofollow`
- `GET /wp-admin/` → `302` ל־`/wp-login.php?...`
- `GET /wp-login.php` → `200`
- `GET /courses-external/` → `404`
- `GET /courses-soon/` → `200`
- `GET /shop/` → `200`
- `GET /learning/`, `/treatment/`, `/lessons/`, `/tools-and-accessories/`, `/muzeh/`, `/media/`, `/faq/`, `/privacy/`, `/galleries/` → `404`
- `GET /accessibility/` → `301` ל־`/accessibility-statement/`
- `GET /wp-json/wp/v2/pages?per_page=100&_fields=id,slug,link,status,title` מחזיר בין היתר `courses-soon`, `shop`, `accessibility-statement`, `books`, `testimonials-media`, אך לא את רוב צומתי העץ הנעול
- `POST /wp-admin/admin-ajax.php` עם `action=fluentform_submit` → `{"success":true,"data":{"insert_id":2,...}}`

## המלצת צוות 50 לצוות 100

לא לקלוט את §11 G4 כנסגר.

סדר התיקון המומלץ:

1. ליישר את ה־IA, ה־slugs והתפריט הציבורי ל־[`../../hub/data/site-tree.json`](../../hub/data/site-tree.json) כמקור אמת יחיד.
2. להסיר תלות חזיתית ב־`/shop/` וב־`/courses-soon/`, או להוציא waiver מפורש מ־100 אם זו הסטייה המכוונת.
3. להשלים את דפי המערכת/פוטר החסרים לפי העץ הנעול.
4. לתקן EN ברמת `lang`/`dir` למסמך.
5. אחרי תיקונים: לבקש ריטסט FINAL קצר לצוות 50.

## חתימת צוות 50

**פסק דין QA סופי לריצה זו:** **FAIL**  
**חתימה:** Codex (צוות 50)  
**תאריך:** 2026-04-06
