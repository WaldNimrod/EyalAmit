# MANDATE — team_90 · Composer · R1-11 `/repair/` content contract

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ בלבד. מובייל מחוץ להיקף.
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/repair/
TLS פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL. `-fast` אסור.

## ארבעת סעיפי החוזה

1. התאמת מקור — כל מחרוזת חדשה במקור המצוטט. אחרת FAIL.
2. האנק לא ממופה — שינוי קוד שאינו ממופה למטה → FAIL.
3. Provenance — מחרוזת בלי הערת מקור → FAIL.
4. פלט ריק = FAIL.

**מקור:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/תיקון כלי דיג_רידו/build didg.md`
אין סקירה. md = רצוי.

## סעיפים ממופים (theme diff)

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/repair-defaults.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (דילוג ACF ל-`repair` יחד עם ילדי הגל)

`git diff --name-only HEAD` בערכת הנושא חייב להיות תת-קבוצה של הרשימה הזו **פלוס** defaults של עמודי הגל האחרים.

מורשה גם: `didgeridoos-defaults.php` · `bags-defaults.php` · `stands-storage-defaults.php` · `stand-floor-defaults.php` (אחים בגל, לא FAIL).
אסור: `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `shop-defaults.php` · `tpl-chapters-page.php`.

## מה לבדוק ב-HTML החי (`<main>`)

1. H1 = `תיקון וחידוש דיג'רידו` בלי `<em>`. אין תג-פרק. אין פסקת «מהנדס אלקטרוניקה». אין «מחיר לפי התאמה». אין `mrng.to`. אין גלריית «ממתין לאישור».
2. CTA `לתיאום בדיקה לכלי` → `/contact/` מופיע אחרי הסקשנים ככתוב במסמך.
3. בדיוק 6 `<details class="ea-faq-item">` ב-`.ea-faq-list` ב-`<main>` (faq-inline), סדר המסמך: זמן → האם כל כלי → צליל → מחיר → הצעת מחיר → שדרוג.
4. קישור `[כלים ואביזרים לדיג'רידו](/tools-and-accessories)` קיים ככתבו (לא הומר ל-`/shop/`).
5. אין בלוק המלצות (REP-02 ממתינים לאייל). אין תמונת הירו חדשה (REP-01 ממתינים — לא FAIL אם אין מדיה).

`qa_probe` דסקטופ בנוסף. שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-11-REPAIR-2026-08-18.md`
