# MANDATE — team_90 · Composer · R1-12 `/didgeridoos/` content contract

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ בלבד. מובייל מחוץ להיקף.
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/
TLS פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL. `-fast` אסור.

## ארבעת סעיפי החוזה

1. התאמת מקור — כל מחרוזת חדשה במקור המצוטט. אחרת FAIL.
2. האנק לא ממופה — שינוי קוד שאינו ממופה למטה → FAIL.
3. Provenance — מחרוזת בלי הערת מקור → FAIL.
4. פלט ריק = FAIL.

**מקור:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/כלים למכירה/buy didgeridoo.md`
אין סקירה. md = רצוי. **לא** לאמת מול `shop-defaults.php` כמקור בייטים (אותו md, ערוץ אחר). DG-01 ננעל: להדביק גם כאן.

## סעיפים ממופים (theme diff)

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/didgeridoos-defaults.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (דילוג ACF ל-`didgeridoos`)

מורשה גם: `repair-defaults.php` · `bags-defaults.php` · `stands-storage-defaults.php` · `stand-floor-defaults.php`.
אסור: `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `shop-defaults.php` · `tpl-chapters-page.php`.

## מה לבדוק ב-HTML החי (`<main>`)

1. H1 = `כלי דיג'רידו למכירה - כלים בעבודת יד` בלי `<em>`. אין תג «כלים למכירה». אין bleed. אין «מחיר לפי התאמה». אין `mrng.to`. אין גלריית pending.
2. ארבעה CTA ל-`/contact/` ככתבם במסמך.
3. בדיוק 5 `<details class="ea-faq-item">` ב-`.ea-faq-list` ב-`<main>` (faq-inline), סדר המסמך.
4. קישור `/instruments` קיים ככתבו (301 ל-`/tools-and-accessories/instruments/` מותר). אל תדרשו המרה ל-`/bags/`.
5. אין תמונות הירו/סדנה חדשות (DG-02/03 ממתינים לאייל — לא FAIL).

`qa_probe` דסקטופ בנוסף. שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-12-DIDGERIDOOS-2026-08-18.md`
