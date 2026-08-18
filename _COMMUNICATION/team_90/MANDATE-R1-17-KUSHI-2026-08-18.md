# MANDATE — team_90 · Composer · R1-17 `/books/kushi-blantis/` content contract

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ בלבד. מובייל מחוץ להיקף.
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/
TLS פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL. `-fast` אסור.

## ארבעת סעיפי החוזה

1. התאמת מקור — כל מחרוזת חדשה במקור המצוטט. אחרת FAIL.
2. האנק לא ממופה — שינוי קוד שאינו ממופה למטה → FAIL.
3. Provenance — מחרוזת בלי הערת מקור → FAIL.
4. פלט ריק = FAIL.

**מקור:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/כושי בלאנטיס/kushi_full.md`
אין סקירה. md = רצוי. מחקר: `_COMMUNICATION/team_100/S006/RESEARCH-R1-17-KUSHI-2026-08-18.md`

## סעיפים ממופים

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/kushi-blantis-defaults.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (דילוג ACF)

מורשה גם אחי גל 3: `tsva-bekahol-defaults.php` · `vekatavta-defaults.php` · `faq-defaults.php` · `snoring-sleep-apnea-defaults.php` · `inc/data/ea-faq-seed.json` · `mu-plugins/ea-s006-faq-merge-once.php` · `scripts/ftp_deploy_site_wp_content.py`
אסור: `muzza-defaults.php` · `videoblk.php` · `block-faq-list.php` · `tpl-chapters-page.php`

## מה לבדוק ב-HTML החי (`<main>`)

1. H1 = `כושי בלאנטיס` בלי `<em>`. אין תג `הספר`. אין 69 ₪. אין `mrng.to`.
2. קישור מנדלי `https://www.mendele.co.il/product/kushibelantis/` מופיע. מודפס = «קישור יתווסף בהמשך» (אין URL מודפס מומצא).
3. בדיוק 6 `<details class="ea-faq-item">` ב-faq-inline, סדר המסמך.
4. אין `.reveals` עם תשע תמונות chapters. אין `temp_note` / חשבונית ירוקה.
5. KSH-01–05 מדיה/אודות ממתינים לאייל — לא FAIL אם אין גלריה/עיתונות חדשה.

`qa_probe` דסקטופ בנוסף. שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-17-KUSHI-2026-08-18.md`
