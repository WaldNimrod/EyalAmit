# M2 G2 — דוח QA חוזר לצוות 50

**תאריך ביצוע:** 2026-04-02  
**שעת ביצוע:** 17:28 IDT  
**מבקר/ת:** Codex (בשם צוות 50)  
**סטטוס מסכם:** **FAIL**

**נבדק מול מסמכי התיקון:**  
[`M2-IMPLEMENTATION-SUMMARY-2026-04-01.md`](../team_10/M2-IMPLEMENTATION-SUMMARY-2026-04-01.md)  
[`M2-G2-STAGING-P0-DONE-2026-04-04.md`](../team_10/M2-G2-STAGING-P0-DONE-2026-04-04.md)  
[`site/README.md`](../../site/README.md)  
[`../team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md`](../team_100/M2-QA50-RETEST-MANDATE-INFRA-G2-2026-04-06.md)

**הערת תיארוך:** מסמכי צוות 10 מתוארכים ל־2026-04-04, אך הריטסט של צוות 50 בוצע בפועל על סביבת הסטייג'ינג הזמינה ב־2026-04-02.

## סיכום

סבב התיקון הנוסף סגר חלק נוסף מהחסמים שדווחו בדוח [`M2-G2-QA-REPORT-TEAM50-2026-04-02.md`](./M2-G2-QA-REPORT-TEAM50-2026-04-02.md):

- עמודי המעטפת קיימים ב־REST הציבורי ובנתיבי האתר.
- `/en/` קיים ומחזיר `ea-lang-en`.
- תפריט M2 קיים בפלט הציבורי.
- `therapist-training` מחזיר ב־REST הציבורי `yoast_head_json.robots.index = noindex`.
- כותרות `/` כוללות כעת `expires: Wed, 11 Jan 1984 05:00:00 GMT` ו־`cache-control: no-cache, must-revalidate, max-age=0, no-store, private`.
- `Q3` התשתיתי נסגר בדוח התשתית המקביל.

עם זאת, שני כשלים מהותיים עדיין פתוחים ולכן G2 לא יכול לקבל `PASS`:

1. **דף `contact` לא מרנדר טופס Fluent**, אלא מציג את ה־shortcode כטקסט גולמי: `[fluentform id="1"]`.  
2. **דף הבית ב־`/` עדיין מוגש למבקר רגיל כפלט מטמון stale** עם `Sample Page` ו־`Hello world!`, בעוד עם cache-bust (`/?cb=20260402-qa`) מתקבל עמוד `בית` (`page-id-16`). מבחינת QA ציבורי זו עדיין תקלה חיה עד purge/ייצוב בצד uPress.

## קדם־תנאים (Go / No-Go)

| ID | תנאי | סטטוס | ראיה |
|----|------|--------|------|
| G1 | סביבת סטייג'ינג זמינה | ☑ | `curl -k -sI /` החזיר `HTTP/2 200`. |
| G2 | GeneratePress + child `EA Eyal Amit` פעילים | ☑ | פלט הציבורי כולל `wp-child-theme-ea-eyalamit` וטעינת `ea-eyalamit/style.css`. |
| G3 | `ea-staging-noindex.php` משפיע בסטייג'ינג | ☑ | `x-robots-tag: noindex, nofollow` בכותרות + meta robots ב־HTML. |
| G4 | מעטפת עמודים + קריאה הושלמו | ✗ | עמודי המעטפת קיימים, אבל `GET /` ללא query עדיין מחזיר blog index ישן עם `Hello world!`; `GET /?cb=20260402-qa` מחזיר את עמוד `בית` (`page-id-16`). |
| G5 | Yoast + Fluent + SMTP | ✗ | Yoast אומת; Fluent לא מרונדר ב־`/contact/`; SMTP לא ניתן לאימות בלי טופס עובד. |

## מטריצת בדיקות

| ID | בדיקה | תוצאה | הערות / ראיה |
|----|--------|--------|----------------|
| T1 | Child פעיל | ☑ | `body` ב־`/` ובדפי מעטפת כולל `wp-child-theme-ea-eyalamit`. |
| T2 | `style.css` של child נטען | ☑ | הפלט הציבורי כולל `/wp-content/themes/ea-eyalamit/style.css?ver=1.0.1`. |
| T3 | EN LTR (`/en/`) | ☑ | `/en/` מחזיר `200`; `body` כולל `ea-lang-en`. |
| S1 | `noindex` בסטייג'ינג | ☑ | כותרת `x-robots-tag: noindex, nofollow` ו־meta robots ב־HTML. |
| P-set | עמודי הבסיס וה־slugs הנדרשים | ☑ | `REST /wp-json/wp/v2/pages?per_page=100` מציג את מעטפת העמודים; בדיקת נתיבים החזירה `200` עבור `/blog/`, `/services/`, `/services/didgeridoo-lessons/`, `/services/lectures/`, `/books/`, `/courses-soon/`, `/therapist-training/`, `/shop/`, `/accessibility-statement/`, `/shows-heritage/`. `/home/` מחזיר `301` ל־`/`, כמצופה כאשר עמוד בית מוגדר. |
| Y1 | `therapist-training` מוגדר `noindex` ב־Yoast | ☑ | `REST /wp-json/wp/v2/pages/21` מחזיר `yoast_head_json.robots.index = noindex` ו־`follow = follow`. |
| F1 | טופס בדף `/contact/` | ✗ | `/contact/` קיים, אבל בדף מופיע `<p>[fluentform id=1]</p>` במקום טופס מרונדר. |
| F2 | שליחת טופס / SMTP | ✗ | חסום תפקודית כל עוד F1 נכשל; לא ניתן לבדוק שליחה או לוג מייל. |
| M1 | תפריט ראשי עברית | ☑ | ב־`/contact/` ו־`/en/` נראה תפריט עם פריטי M2, כולל שירותים, בלוג, ספרים, צור קשר, קורסים, הכשרות, הופעות ו־English. |
| M2 | `courses-soon` מקושר מתפריט | ☑ | קישור `קורסים` מופיע בתפריט ו־`/courses-soon/` מחזיר `200`. |
| M3 | פריט English מוביל ל־`/en/` | ☑ | פריט `English` מופיע בתפריט ו־`/en/` מחזיר `200`. |
| X1 | Elementor אינו פעיל | ☑ | אין אינדיקציה ציבורית ל־`elementor` בפלט שנבדק; אימות מוגבל לפלט ציבורי, לא ל־wp-admin. |
| X2 | WooCommerce אינו פעיל | ☑ | אין אינדיקציה ציבורית ל־`woocommerce` בפלט שנבדק; אימות מוגבל לפלט ציבורי, לא ל־wp-admin. |
| R1 | דף הבית הציבורי משרת את `בית` בלי cache-bust | ✗ | `GET /` עדיין מחזיר `body class="... home blog ..."` עם `Sample Page` ו־`Hello world!`; `GET /?cb=20260402-qa` מחזיר `page-id-16` וכותרת `בית`. כותרות `/` כבר כוללות `cache-control: no-cache, must-revalidate, max-age=0, no-store, private`, ולכן נדרש כנראה purge בקצה. |

## ממצאים

| # | חומרה | ממצא | שחזור קצר |
|---|--------|------|------------|
| BUG-06 | קריטי | Fluent shortcode לא מרונדר בדף `contact` | `curl -k -s /contact/` מחזיר `<p>[fluentform id=1]</p>`. |
| BUG-07 | גבוהה | דף הבית הציבורי עדיין stale בלי purge | `curl -k -s /` מחזיר `Sample Page` + `Hello world!`; `curl -k -s '/?cb=20260402-qa'` מחזיר עמוד `בית`. |
| BUG-08 | נסגר | Q3 WP-CLI מקומי עבר בריטסט | `bash scripts/verify_local_wp_cli.sh` עבר; `docker compose exec wordpress /usr/bin/wp --path=/var/www/html --allow-root cli info` עבר ביציאה `0`. |

## המלצת צוות 50 ל־100

לא לסגור את **M2 / G2** בשלב זה.

נדרשים שני תיקונים לפני `PASS`:

1. לגרום ל־Fluent Forms להיטען בפועל בדף `contact` ולבצע אחר כך בדיקת שליחה.  
2. לבצע purge/ניקוי מטמון uPress כך ש־`/` הרגיל ישרת את עמוד `בית` גם בלי query cache-bust.

אחרי שני התיקונים האלה, אפשר לבקש ריטסט קצר ממוקד של צוות 50 במקום מחזור QA מלא.

**חתימת צוות 50:** Codex (צוות 50) + 2026-04-02
