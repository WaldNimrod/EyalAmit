# M2 G2 — דוח QA חוזר לצוות 50

**תאריך ביצוע בפועל:** 2026-04-02  
**שעת ביצוע:** 18:17 IDT  
**תאריך מסמך הבקשה:** 2026-04-07  
**מבקר/ת:** Codex (בשם צוות 50)  
**סטטוס מסכם:** **PASS WITH NOTES**

**נבדק מול מסמכי הבקשה והקשר:**  
[`M2-QA-RETEST-REQUEST-TEAM50-2026-04-07.md`](./M2-QA-RETEST-REQUEST-TEAM50-2026-04-07.md)  
[`../team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md`](../team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md)  
[`M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](./M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md)  
[`M2-G2-QA-RETEST-TEAM50-2026-04-02.md`](./M2-G2-QA-RETEST-TEAM50-2026-04-02.md)

## סיכום

הריטסט הרשמי מאשר שהחסמים המרכזיים של G2 שדווחו קודם נסגרו:

- `/` מחזיר עמוד בית סטטי תקין עם `page-id-16`, ללא `home blog`, `Sample Page`, או `Hello world!`.
- `/contact/` מרנדר בפועל את Fluent Forms, כולל `fluentform_1`, `fluent_form_1`, `ff-el-form-control`, שדות קלט וכפתור שליחה.
- כותרות `/` כוללות `cache-control: no-cache, must-revalidate, max-age=0, no-store, private` ו־`x-robots-tag: noindex, nofollow`.
- בדיקת שליחה ל־Fluent דרך `admin-ajax.php` החזירה הצלחה אפליקטיבית: `{"success":true,"data":{"insert_id":1,"result":{"message":"Thank you for your message. We will get in touch with you shortly","action":"hide_form"}}}`.

לכן BUG-06 ו־BUG-07 נסגרו.  
הסטטוס הכולל הוא `PASS WITH NOTES` ולא `PASS` מלא, משום שלא בוצע אימות ישיר של תיבת דוא"ל או `WP Mail Logging` מתוך `wp-admin`; מה שאומת הוא הצלחת submit ברמת האפליקציה/Fluent.

## קדם־תנאים (Go / No-Go)

| ID | תנאי | סטטוס | ראיה |
|----|------|--------|------|
| G1 | סביבת סטייג'ינג זמינה | ☑ | `curl -k -sI /` החזיר `HTTP/2 200`. |
| G2 | GeneratePress + child `EA Eyal Amit` פעילים | ☑ | `GET /` כולל `wp-child-theme-ea-eyalamit` ו־`page-id-16`. |
| G3 | `ea-staging-noindex.php` משפיע בסטייג'ינג | ☑ | `x-robots-tag: noindex, nofollow` בכותרות + meta robots ב־HTML. |
| G4 | מעטפת עמודים + קריאה הושלמו | ☑ | `GET /` מחזיר עמוד `בית` (`page-id-16`) בלי צורך ב־query cache-bust. |
| G5 | Yoast + Fluent + SMTP | ◐ | Yoast אומת, Fluent מרונדר, ו־submit החזיר success אפליקטיבי; לא נצפתה ישירות קבלה בדוא"ל או רשומת `WP Mail Logging`. |

## מטריצת בדיקות

| ID | בדיקה | תוצאה | הערות / ראיה |
|----|--------|--------|----------------|
| T1 | Child פעיל | ☑ | `body` ב־`/` כולל `wp-child-theme-ea-eyalamit`. |
| T2 | `style.css` של child נטען | ☑ | הפלט הציבורי כולל `/wp-content/themes/ea-eyalamit/style.css?ver=1.0.1`. |
| T3 | EN LTR (`/en/`) | ☑ | `/en/` מחזיר `200`; `body` כולל `ea-lang-en`. |
| S1 | `noindex` בסטייג'ינג | ☑ | כותרת `x-robots-tag: noindex, nofollow` ו־meta robots ב־HTML. |
| P-set | עמודי הבסיס וה־slugs הנדרשים | ☑ | מעטפת G2 קיימת ונגישה; דף הבית הציבורי כבר אינו stale. |
| Y1 | `therapist-training` מוגדר `noindex` ב־Yoast | ☑ | אומת קודם ב־REST הציבורי; לא נסתר בריטסט הנוכחי. |
| F1 | טופס בדף `/contact/` | ☑ | `/contact/` כולל מרקאפ Fluent פעיל: `fluentform_1`, `fluent_form_1`, `ff-el-form-control`, שדות `email`, `message`, וכפתור `Submit Form`. |
| F2 | שליחת טופס / SMTP | ◐ | POST מסומן ל־`/wp-admin/admin-ajax.php` עם `action=fluentform_submit` החזיר `success: true`, `insert_id: 1`, והודעת תודה. לא בוצע אימות ישיר של mailbox או `WP Mail Logging`. |
| M1 | תפריט ראשי עברית | ☑ | חזית G2 תקינה; דפי הליבה נגישים, כולל `צור קשר`, `קורסים`, `הכשרות למטפלים`, `English`. |
| M2 | `courses-soon` מקושר מתפריט | ☑ | הנתיב חי ונגיש. |
| M3 | פריט English מוביל ל־`/en/` | ☑ | `English` מוביל לעמוד קיים (`200`). |
| X1 | Elementor אינו פעיל | ☑ | אין אינדיקציה ציבורית ל־`elementor` בפלט שנבדק. |
| X2 | WooCommerce אינו פעיל | ☑ | אין אינדיקציה ציבורית ל־`woocommerce` בפלט שנבדק. |
| R1 | דף הבית הציבורי משרת את `בית` בלי cache-bust | ☑ | `GET /` מחזיר `page-id-16` וכותרת `בית`. |

## ממצאים

| # | סטטוס | ממצא | ראיה |
|---|--------|------|------|
| BUG-06 | נסגר | Fluent כבר מרונדר בדף `contact` | מרקאפ `ff-el-form`, `fluentform_1`, `ff-el-form-control` בפלט `/contact/`. |
| BUG-07 | נסגר | דף הבית הציבורי כבר אינו stale בלי query | `GET /` מחזיר `page-id-16` ולא `home blog` / `Hello world!`. |
| BUG-08 | נסגר | Q3 WP-CLI מקומי עבר | ראה דוח התשתית המקביל: [`M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md`](./M2-INFRA-QA-REPORT-TEAM50-2026-04-03.md). |
| NOTE-01 | פתוח כהערת QA | אימות delivery ישיר של SMTP לא בוצע ב־mailbox או `WP Mail Logging` | submit אפליקטיבי הצליח, אך אין גישת `wp-admin` לצוות 50 בריטסט זה. |

## המלצת צוות 50 ל־100

אפשר להתקדם לסגירת G2 ברמת QA כ־`PASS WITH NOTES`.

אם צוות 100 דורש `PASS` ללא הערות, נדרש צעד אחרון אחד:

1. לפתוח `wp-admin` או `WP Mail Logging` ולאשר שההגשה המסומנת אכן נרשמה/נשלחה.

בהיעדר גישת אדמין, אין כרגע blocker פונקציונלי פתוח ב־חזית הציבורית.

**חתימת צוות 50:** Codex (צוות 50) + 2026-04-02
