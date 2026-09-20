# מנדט צוות 10 — חבילת תיקוני WAF אחרי גל א · 2026-09-20

**מזמין:** מנהל מבצע (אורקסטרציה) מול נימרוד.  
**מבצע:** צוות 10 (יישום) — סובאגנט Composer.  
**מאמת:** המנוע הזה, אחרי FTP, לא הבונה.  
**אישור נימרוד:** לממש את כל התיקונים שהוצגו בהכרעה, כולל בדיקה חוזרת.

סטייג'ינג: http://eyalamit-co-il-2026.s887.upress.link (HTTP). תמה חיה עכשיו **1.5.96**. אחרי השינוי: bump ב־`site/wp-content/themes/ea-eyalamit/style.css` ל־**1.5.97**, commit רק קבצי התמה+המנדט, FTP `python3 scripts/ftp_deploy_site_wp_content.py` (מסרב ל־`site/` מלוכלך). בלי `git add -A`, בלי `local/`, בלי `_aos/`. טוקני טיפוגרפיה לא נוגעים. אין פריטי L1 חדשים. אין נוסח מומצא.

מקור הכרעה: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-A-COMPOSER-ADJUDICATION-2026-09-20.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-A-COMPOSER-ADJUDICATION-2026-09-20.md)

---

## חובה לבצע

### WAF-02 · overflow אופקי ב־390 על `.phero--media`

- קובץ: `site/wp-content/themes/ea-eyalamit/assets/css/chapters.css`
- היום: `.phero--media{… overflow:visible}` (תיקון סעיף 16) משחרר `.phero .arcs` (`left:-220px; width:620px`) → `scrollWidth` 610.
- תיקון: לשמור את `padding-block-start` האנכי (סעיף 16 נשאר). לחתוך אופקית בלי להסתיר את ה־H1: למשל `overflow-x: clip;` (או `hidden` אם clip לא מספיק) + `overflow-y: visible`.
- הצלחה: `/lessons/` `/contact/` `/treatment/` ב־390: `documentElement.scrollWidth <= clientWidth + 1`, overlap H1/nav עדיין false, gap ≥ 16 ב־`/lessons/`.

### WAF-01 · `/shop/` תווית ישנה בגוף

- קובץ: `inc/chapters/defaults/shop-defaults.php`
- להחליף מחרוזת מדויקת `תיקון וחידוש כלים` → `תיקון וחידוש כלי דיג׳רידו` בכותרת הכרטיס וב־`<strong>` ב־lede בלבד. לא לנסח מחדש פסקאות.
- הצלחה: 0 מופעי «תיקון וחידוש כלים» ב־HTML של `/shop/`; הניווט L2 נשאר «כלי דיג׳רידו».

### WAF-03 · `/en/` שלושה `wa.me`

- קובץ: `page-templates/tpl-chapters-en.php` (CTA בהירו + כפתור שני ~שורה 150).
- להשאיר **לחצן in-page אחד** («Talk on WhatsApp»). למחוק את הכפיל. הצף האתר נשאר (כמו `/shop/`, לא כמו `/contact/`).
- הצלחה: in-page `wa.me` נראה = 1; float קיים; סה״כ נראים = 2 (לא 3).

### WAF-V02 · פוטר Wave2 חי ב־`/about/` `/press/`

- קובץ: `template-parts/blocks/block-footer-social.php`
- `כלים ואביזרים` → `home_url( '/shop/' )` (לא `/tools-and-accessories`).
- תווית ספרים: **ספרים – מוזה הוצאה לאור** (נוסח אייל) → `/books/`.
- הצלחה: ב־HTML של `/about/` ו־`/press/` אין href ל־`/tools-and-accessories`; התווית החדשה של הספרים קיימת.

### WAF-V01 · וורדמרק ב־GP `/about/` `/press/`

- היום אין `.nav__wm` (תבנית `tpl-content` / GP). המגירה כן נושאת «המרכז לטיפול בדיג׳רידו».
- להוסיף את **אותה מחרוזת** ליד הסימן ב־header של GP, בלי פריט L1 חדש ובלי לגעת ב־`--fs-nav`. אם אין חריץ לוגו — לכתוב BLOCKER במסירה, לא להמציא סרגל שני.
- הצלחה אם בוצע: המחרוזת נראית ב־390 (או במגירה לפחות, שכבר קיימת) ובדסקטופ רחב; ב־1081–1499 מותר להסתיר כמו Chapters.

---

## אסור

- לא קבוצה ב (פירורים, בלוקים שחורים, שבירת כותרות, מפקד קישורים ישנים, גובה סרגל).
- לא CMP / דחיית עוגיות / חסימת GA4.
- לא FAQ/עדויות ב־L1.
- לא באנר WP-EI-05.

## מסירה

קובץ `_COMMUNICATION/team_10/S007-GROK/WAVE-A-HOTFIX-ASMADE-2026-09-20.md`: מה שונה, גרסת תמה, קומיט, שורת FTP. בלי סודות.
