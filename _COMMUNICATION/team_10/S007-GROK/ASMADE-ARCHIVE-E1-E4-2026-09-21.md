# As-made — ארכיון E1/E4 (תוכן שנמצא באתר ישן)

**תאריך:** 2026-09-21  
**צוות:** 10 (יישום)  
**סטייג'ינג:** http://eyalamit-co-il-2026.s887.upress.link  
**גרסת תמה:** `1.5.104` (`site/wp-content/themes/ea-eyalamit/style.css`)

## מה בוצע

- טעינת `w2-07-show-archive.json` + הזרקת תוכן ל־`/historical-articles/` דרך `the_content` (תבנית ברירת מחדל; H1 «כתבות היסטוריות» נשאר).
- `/press/`: שלוש שורות חדשות ב־`w2-07-press.json` (כבר במאגר) + קידומת `home_url()` ל־URL שמתחיל ב־`/`; אחרי בלוק FB «ממליצים» — אקורדיון «המלצות על המופע» מתוך ארכיון המופע.
- רינדור אטומים קיימים בלבד: `.ea-content-section`, `.ea-press`, `.ea-book-gallery`, `.ea-testimonial-acc`.
- CSS: `w2-07-heritage.css` + `ea-blog.css` + `ea-atoms` (דרך `ea_w2_07_ensure_wave2_atoms`) על `/historical-articles/`.

## קבצים שנגעו

| קובץ |
|------|
| `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-07.php` |
| `site/wp-content/themes/ea-eyalamit/assets/css/w2-07-heritage.css` |
| `site/wp-content/themes/ea-eyalamit/style.css` (Version → 1.5.104) |

**נתונים/תמונות (כבר במאגר לפני הסשן — לא נערכו כאן):**

- `site/wp-content/themes/ea-eyalamit/inc/data/w2-07-show-archive.json`
- `site/wp-content/themes/ea-eyalamit/inc/data/w2-07-press.json`
- `site/wp-content/themes/ea-eyalamit/assets/images/archive/*.jpg`

## FTP

```text
Done: FTP deploy site/wp-content (child theme + mu-plugins).
```

פקודה: `python3 scripts/ftp_deploy_site_wp_content.py --allow-dirty "S007 phase1 archive E1/E4 found content into existing templates; tree already dirty from 1.5.103"`

## אימות GET (ללא follow, UA דפדפן)

| בדיקה | תוצאה |
|--------|--------|
| `/press/` HTTP | 200 |
| שלוש כותרות (גבעתיים / רואי פרסול / מרקוביץ) | נמצאו ב-HTML |
| «המלצות על המופע» + «אברהם טל» | נמצאו |
| `/historical-articles/` HTTP | 200 |
| «מופע הסיפורים של אייל עמית» + `assets/images/archive/GIVATAIM.jpg` | נמצאו |
| `/shows-heritage/` HTTP | 200 (ללא תוכן ארכיון חדש) |
| דף בית — href ל־`/shows-heritage/` `/press/` `/historical-articles/` | 0 |
| `w2-07-heritage.css?ver=` | 1.5.104 |

## מה לא בוצע (לפי מנדט)

- **L1 / `inc/ea-canonical-nav.php`** — לא נגע.
- **301 / redirects** — לא נוספו.
- **`/shows-heritage/`** — לא מולא.
- **A3** — גלריית במה / פוסטרים / קטלוג JPG מאייל — hold.
- **תגובות FB אנונימיות** — לא הודבקו.
- **Hub rebuild**, **תבניות בלוג/QR**, **`_aos/`**, **`local/`**.

## מקור מפקד

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ARCHIVE-CENSUS-E1-E4-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/ARCHIVE-CENSUS-E1-E4-2026-09-21.md)
