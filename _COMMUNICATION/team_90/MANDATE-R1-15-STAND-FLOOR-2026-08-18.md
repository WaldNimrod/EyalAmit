# MANDATE — team_90 · Composer · R1-15 `/stand-floor/` content contract

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ בלבד. מובייל מחוץ להיקף.
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/stand-floor/
TLS פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL. `-fast` אסור.

## ארבעת סעיפי החוזה

1. התאמת מקור — כל מחרוזת חדשה במקור המצוטט. אחרת FAIL.
2. האנק לא ממופה — שינוי קוד שאינו ממופה למטה → FAIL.
3. Provenance — מחרוזת בלי הערת מקור → FAIL.
4. פלט ריק = FAIL.

**מקור:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md`
אין סקירה. md = רצוי. **לא** לערבב עם סטנדי אחסון / `shop-defaults.php`.

## סעיפים ממופים (theme diff)

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/stand-floor-defaults.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (דילוג ACF ל-`stand-floor`)

מורשה גם: `repair-defaults.php` · `didgeridoos-defaults.php` · `bags-defaults.php` · `stands-storage-defaults.php`.
אסור: `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `shop-defaults.php` · `tpl-chapters-page.php` · `product-cta.php`.

## מה לבדוק ב-HTML החי (`<main>`)

1. H1 = `סטנד רצפתי לדיג'רידו לנגינה בישיבה נמוכה` בלי `<em>`. אין תג-פרק. אין «מחיר לפי התאמה». אין `mrng.to`. אין גלריית pending. אין H3-צעדים שהומצאו. SECTION 03 כולל «זה הכל.».
2. CTA הירו `ליצירת קשר` → `/contact/`. CTA תחתון כותרת `רוצה לבדוק אם זה מתאים לך?`.
3. בדיוק 4 `<details class="ea-faq-item">` ב-`.ea-faq-list` ב-`<main>` (faq-inline), סדר המסמך.
4. קישור `טיפול בדיג'רידו` → `/treatment/` (קנוני; לא `/services/didgeridoo-treatment-breath/`).
5. אין תמונות חדשות (FLR-01/02 ממתינים — לא FAIL אם אין מדיה). SECTION 10 (הערות מתכנת) לא מוצג למשתמש.

`qa_probe` דסקטופ בנוסף. שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-15-STAND-FLOOR-2026-08-18.md`
