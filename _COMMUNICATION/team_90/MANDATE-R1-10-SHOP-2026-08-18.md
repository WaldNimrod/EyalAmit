# MANDATE — team_90 · Composer · R1-10 `/shop/` content contract

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ בלבד. מובייל מחוץ להיקף.
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/shop/
TLS פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL. `-fast` אסור.

## ארבעת סעיפי החוזה

1. התאמת מקור — כל מחרוזת חדשה במקור המצוטט. אחרת FAIL.
2. האנק לא ממופה — שינוי קוד שאינו ממופה למטה → FAIL.
3. Provenance — מחרוזת בלי הערת מקור → FAIL.
4. פלט ריק = FAIL.

**מקור:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/כלים למכירה/buy didgeridoo.md`
אין סקירה. md = רצוי.

## סעיפים ממופים (theme diff)

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/shop-defaults.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (דילוג ACF ל-`shop` בגל אחד עם muzza/about/mokesh)

`git diff --name-only HEAD` בערכת הנושא חייב להיות תת-קבוצה של הרשימה הזו **פלוס** defaults של עמודי הגל האחרים (muzza/about/mokesh) — אלה גל מקביל, לא FAIL אם הם בשמות המורשים למטה.

מורשה גם: `muzza-defaults.php` · `about-defaults.php` · `mokesh-defaults.php` (עמודי גל אחרים).
אסור: `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `didgeridoos-defaults.php` וילדי מוצר · `tpl-chapters-page.php`.

## מה לבדוק ב-HTML החי (`<main>`)

1. H1 = `כלי דיג'רידו למכירה - כלים בעבודת יד` בלי `<em>`. אין תג «חנות». אין גריד `bookcard`. אין «מחיר לפי התאמה». אין כרטיס סטנד רצפתי.
2. ארבעה CTA ל-`/contact/` ככתבם במסמך.
3. בדיוק 5 `<details class="ea-faq-item">` ב-`.ea-faq-list` ב-`<main>` (faq-inline).
4. שלושה ממליצים + Facebook href מ-SECTION 09: שירי אלקבץ · רותי שליט · אלון גרזון רז.
5. אין תמונות הירו/סדנה (SHP-01/02 ממתינים לאייל — לא FAIL).

`qa_probe` דסקטופ בנוסף. שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`.
