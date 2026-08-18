# MANDATE — team_90 · Composer · R1-14 `/stands-storage/` content contract

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ בלבד. מובייל מחוץ להיקף.
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/stands-storage/
TLS פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL. `-fast` אסור.

## ארבעת סעיפי החוזה

1. התאמת מקור — כל מחרוזת חדשה במקור המצוטט. אחרת FAIL.
2. האנק לא ממופה — שינוי קוד שאינו ממופה למטה → FAIL.
3. Provenance — מחרוזת בלי הערת מקור → FAIL.
4. פלט ריק = FAIL.

**מקור:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/סטנדים לדיג_רידו לאחסון/stend for hanging.md`
אין סקירה. md = רצוי. **לא** לערבב עם `stend for playing.md` / `/stand-floor/`.

## סעיפים ממופים (theme diff)

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/stands-storage-defaults.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (דילוג ACF ל-`stands-storage`)

מורשה גם: `repair-defaults.php` · `didgeridoos-defaults.php` · `bags-defaults.php` · `stand-floor-defaults.php`.
אסור: `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `shop-defaults.php` · `tpl-chapters-page.php`.

## מה לבדוק ב-HTML החי (`<main>`)

1. H1 = `סטנדים לאחסון דיג'רידו` בלי `<em>`. תת `לתלייה או בעמידה` (או בגוף ההירו). אין «מחיר לפי התאמה». אין `mrng.to`. אין bleed + ייחוס «אייל עמית». אין גלריית pending. אין `.reveals`.
2. CTA `לתיאום והזמנה` → `/contact/`.
3. בדיוק 5 `<details class="ea-faq-item">` ב-`.ea-faq-list` ב-`<main>` (faq-inline), סדר המסמך: התאמה → תלייה/עמידה → שמירה על הכלי → התאמה אישית → הצעת מחיר.
4. שני סוגי אחסון מופיעים: תלייה על הקיר + עמידה על הרצפה (אחסון, לא נגינה).
5. אין תמונות חדשות (STN-01/02 ממתינים — לא FAIL אם אין מדיה).

`qa_probe` דסקטופ בנוסף. שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-14-STANDS-STORAGE-2026-08-18.md`
