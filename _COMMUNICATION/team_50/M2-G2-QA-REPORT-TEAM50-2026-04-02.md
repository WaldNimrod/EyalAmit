# M2 G2 — דוח QA לצוות 50

**תאריך ביצוע:** 2026-04-02  
**שעת ביצוע:** 15:35 IDT  
**מבקר/ת:** Codex (בשם צוות 50)  
**סטטוס מסכם:** **BLOCKED**

**מקור דרישות:** [`M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md`](./M2-G2-QA-BRIEF-FOR-TEAM50-2026-03-29.md)

**סיכום:** סביבת הסטייג'ינג עצמה נגישה, `noindex` פעיל, ו־child theme נטען בפועל. עם זאת, קדם־התנאי **G4** אינו מתקיים: ייבוא `m2-pages-seed.wxr`, הגדרת עמוד בית/בלוג, והקמת תפריטים לא הושלמו על הסטייג'ינג. לכן אין בסיס לאישור "G2 הושלם", והבדיקה נסגרת כ־`BLOCKED` עם ממצאי כשל מהותיים.

## קדם־תנאים (Go / No-Go)

| ID | תנאי | סטטוס | ראיה |
|----|------|--------|------|
| G1 | סביבת סטייג'ינג זמינה | ☑ | `curl -k -sI` החזיר `HTTP/2 200` ל־`/`. |
| G2 | GeneratePress + child `EA Eyal Amit` פעילים | ☑ | source של `/` כולל `generate-style-css`, `generate-child-css`, ו־`body` עם `wp-child-theme-ea-eyalamit`. |
| G3 | `ea-staging-noindex.php` משפיע בסטייג'ינג | ☑ | `x-robots-tag: noindex, nofollow` בכותרות וגם `<meta name='robots' content='noindex, nofollow' />` ב־HTML. |
| G4 | ייבוא WXR + בית סטטי/בלוג | ✗ | `/home/`, `/blog/`, `/services/`, `/books/`, `/shop/` מחזירים `404`; דף הבית מציג `Hello world!` ותפריט `Sample Page`. |
| G5 | Yoast + Fluent + SMTP | ◐ | Yoast פעיל בפלט הציבורי; Fluent/SMTP לא ניתנים לאימות כי `/contact/` מחזיר `404` ואין טופס זמין. |

## מטריצת בדיקות

| ID | בדיקה | תוצאה | הערות / ראיה |
|----|--------|--------|----------------|
| T1 | Child פעיל | ☑ | `body class="... wp-theme-generatepress wp-child-theme-ea-eyalamit ..."` בדף הבית. |
| T2 | `style.css` של child נטען | ☑ | source כולל `/wp-content/themes/ea-eyalamit/style.css?ver=1.0.1`; שליפת הקובץ אישרה `Template: generatepress`. |
| T3 | EN LTR (`/en/`) | ✗ | `/en/` מחזיר דף `Page not found`; אין `ea-lang-en` כי העמוד עצמו חסר. |
| S1 | `noindex` בסטייג'ינג | ☑ | `x-robots-tag: noindex, nofollow` + meta robots ב־HTML של `/`. |
| P-set | עמודי הבסיס וה־slugs הנדרשים | ✗ | `404` עבור `/contact/`, `/home/`, `/blog/`, `/services/`, `/didgeridoo-lessons/`, `/lectures/`, `/books/`, `/courses-soon/`, `/therapist-training/`, `/accessibility-statement/`, `/shop/`. |
| Y1 | `therapist-training` מוגדר `noindex` ב־Yoast | ✗ | לא ניתן לאמת כי `/therapist-training/` מחזיר `404`. |
| F1 | טופס בדף `/contact/` | ✗ | `/contact/` מחזיר `404`; אין טופס זמין. |
| F2 | שליחת טופס / SMTP | ✗ | חסום תפקודית עקב היעדר `/contact/`; לא ניתן לבדוק שליחה או לוג מייל. |
| M1 | תפריט ראשי עברית | ✗ | בדף הבית מופיע `Sample Page` בלבד בתפריט הראשי; תפריטי M2 לא הוקמו. |
| M2 | `courses-soon` מקושר מתפריט | ✗ | `/courses-soon/` מחזיר `404`; אין פריט תפריט תואם. |
| M3 | פריט English מוביל ל־`/en/` | ✗ | `/en/` מחזיר `404`; לא נצפה קישור English תקין. |
| X1 | Elementor אינו פעיל | ☑ | בדיקת source ציבורי של `/` לא הראתה `elementor`; סטטוס זה מבוסס על תצפית ציבורית בלבד, לא על רשימת תוספים ב־wp-admin. |
| X2 | WooCommerce אינו פעיל | ☑ | בדיקת source ציבורי של `/` לא הראתה `woocommerce`; גם כאן מדובר בתצפית ציבורית בלבד. |

## באגים / ממצאים

| # | חומרה | ממצא | שחזור קצר |
|---|--------|------|------------|
| BUG-01 | קריטי | ייבוא עמודי M2 לא בוצע בסטייג'ינג | גלישה ל־`/contact/`, `/home/`, `/blog/`, `/services/`, `/books/`, `/shop/` מחזירה `404`. |
| BUG-02 | גבוהה | תפריט ראשי לא עודכן למבנה M2 | דף הבית מציג `Sample Page` בלבד בתפריט הראשי. |
| BUG-03 | גבוהה | דף הבית אינו מוגדר לפי G2 אלא כבלוג ברירת מחדל | `/` מציג את `Hello world!` ולא עמוד בית סטטי. |
| BUG-04 | גבוהה | EN page חסר ולכן בדיקת LTR נכשלת | `/en/` מחזיר `404` ודף שגיאה. |
| BUG-05 | גבוהה | טופס צור קשר לא זמין לבדיקה | `/contact/` מחזיר `404`, לכן אין אפשרות לאמת Fluent או SMTP. |

## המלצת צוות 50 ל־100

לא לסגור את **M2 / G2** בשלב זה. להחזיר לצוות 10 להשלמת שלבי הסטייג'ינג המתועדים בסיכום היישום:

1. ייבוא `m2-pages-seed.wxr`.
2. הגדרת `בית` ו־`בלוג` תחת הגדרות קריאה.
3. הקמת תפריטים T1–T6.
4. יצירת/חיבור טופס Fluent בדף `contact`.
5. העלאת עמוד `en` ובדיקת `ea-lang-en`.
6. אימות חוזר של `therapist-training` עם `noindex` ברמת העמוד.

**חתימת צוות 50:** Codex (צוות 50) + 2026-04-02
