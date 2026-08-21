# MANDATE — team_90 · Composer · זנבות ליבה 19.8 · חוזה תוכן

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.  
**סקואופ:** `סקואופ אושר: זנבות ליבה — מחיקת ציר זמן בבית, הורדת compare בטיפול, קישור הריון בשיעורים בלבד`  
דסקטופ. `curl -sk` לסטייג'ינג בלבד. פלט ריק = FAIL. `-fast` אסור. **אל תשנה קבצים** מלבד קובץ הפסק.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`  
כתוב אל: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-TAILS-CORE-CONTRACT-A-2026-08-21.md`

## ארבעת סעיפי החוזה

1. **התאמת מקור** — כל מחרוזת חדשה חייבת להימצא במקור המצוטט של הסעיף. אחרת FAIL.  
2. **האנק לא ממופה** — שינוי קוד בערכת הנושא שאינו בשלושת הסעיפים → FAIL.  
3. **Provenance** — מחרוזת שהשתנתה בלי הערת מקור → FAIL.  
4. **פלט ריק = FAIL.**

אסור לתת למאמת מחרוזת שהבנאי כתב ולבקש אישוש. תנו את **המקור** ובקשו התאמה.

## מקורות (רק אלה)

- H-01: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/הערות%20של%20אייל%20לאחר%20סבב%20שלב%201%20-%2019.8.26/דף%20הבית.xlsx` · D5 = `למחוק מהדף`
- T-01: אותו תיק · `טיפול בדיג_רידו.xlsx` · D5 = `לך על הגרסה המוצעת`
- LSN-09: אותו תיק · `שיעורי דיג_רידו.xlsx` · D6 =  
  `https://www.eyalamit.co.il/Blog/%d7%a0%d7%a9%d7%99%d7%9d-%d7%9e%d7%a0%d7%92%d7%a0%d7%95%d7%aa-%d7%91%d7%93%d7%99%d7%92%d7%a8%d7%99%d7%93%d7%95-%d7%90%d7%99%d7%a9%d7%94-%d7%9e%d7%a0%d7%92%d7%a0%d7%aa-%d7%91%d7%93%d7%99%d7%92/`

## קבצים מותרים ב-diff ערכת הנושא

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/home-defaults.php`
- `site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-01-about.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/lessons-defaults.php`

`git diff --name-only HEAD --` **ארבעת הקבצים למעלה בלבד**.  
`inc/seo-head-fallbacks.php` וכל קובץ ערכה אחר שהיה מלוכלך **לפני** גל הזנבות (WAIT-WAVE / SEO 18.8) **אינו** האנק של הגל הזה — לא FAIL ולא revert.

**אסור:** `treatment-defaults.php` · מחיקת `treatment-eyal-defaults.php` · `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · FAQ · CSS גלובלי.

## בדיקות חיות

1. **בית** `http://eyalamit-co-il-2026.s887.upress.link/` `#about`  
   אין `.tl` / `.tl__y` / הטקסטים `2004` ו-`2017` כתחנות ציר.  
   `about_body` עדיין קיים (לא נמחק פרק 11). פלייסהולדר פרק 3 נשאר.

2. **טיפול** `http://eyalamit-co-il-2026.s887.upress.link/treatment/`  
   העמוד החי נשאר (H1 טיפול קיים).  
   `http://eyalamit-co-il-2026.s887.upress.link/treatment/?compare=eyal` **זהה בתוכן** לנתיב בלי הפרמטר (אין טווין מסמך).  
   אל תדרשו שינוי בגוף הטיפול מעבר לזה.

3. **שיעורים** `http://eyalamit-co-il-2026.s887.upress.link/lessons/`  
   בשאלת «האם אפשר בזמן הריון?» מופיע «לא מומלץ» **וגם** `קראו עוד` עם href **בייט-בבייט** ל-URL ב-D6.  
   אין href ל-`/blog/pregnancy-didgeridoo`.  
   אל תבדקו FAQ האתר (`/faq/`).

## מלכודות

- קרוסלה מדפיסה כרטיסים פעמיים — לא רלוונטי לגל הזה.  
- TLS סטייג'ינג פג בכוונה (`-k`).  
- מובייל מחוץ להיקף.  
- `qa_probe` דסקטופ בנוסף, אינו תחליף.

## פלט

טבלה: בדיקה · סיווג · תוצאה · ראיה (`file://` או פלט curl/CDP קצר).
