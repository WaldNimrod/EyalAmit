# MANDATE — team_90 · Composer · R1-13 `/bags/` content contract

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ בלבד. מובייל מחוץ להיקף.
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/bags/
TLS פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL. `-fast` אסור.

## ארבעת סעיפי החוזה

1. התאמת מקור — כל מחרוזת חדשה במקור המצוטט. אחרת FAIL.
2. האנק לא ממופה — שינוי קוד שאינו ממופה למטה → FAIL.
3. Provenance — מחרוזת בלי הערת מקור → FAIL.
4. פלט ריק = FAIL.

**מקור:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/תיקים לדיג_רידו/bags for didg.md`
אין סקירה. md = רצוי.

## סעיפים ממופים (theme diff)

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/bags-defaults.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (דילוג ACF ל-`bags`)

מורשה גם: `repair-defaults.php` · `didgeridoos-defaults.php` · `stands-storage-defaults.php` · `stand-floor-defaults.php`.
אסור: `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `shop-defaults.php` · `tpl-chapters-page.php`.

## מה לבדוק ב-HTML החי (`<main>`)

1. H1 = `תיקים לדיג'רידו` בלי `<em>`. אין תג-פרק. אין «מחיר לפי התאמה». אין `mrng.to` / product-cta.
2. CTA `לתיאום והתאמה של תיק לדיג'רידו` → `/contact/`.
3. בדיוק 7 `<details class="ea-faq-item">` ב-`.ea-faq-list` ב-`<main>` (faq-inline), סדר המסמך. קישור שיעורים קנוני `/lessons/` (לא נתיב אחר).
4. Bleed (BAG-05) **עשוי להישאר** — ממתינים לאייל; לא FAIL אם קיים. אין גלריית pending ריקה.
5. אין תמונות חדשות שהומצאו (BAG-03/04 ממתינים — לא FAIL אם אין מדיה).

`qa_probe` דסקטופ בנוסף. שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-13-BAGS-2026-08-18.md`
