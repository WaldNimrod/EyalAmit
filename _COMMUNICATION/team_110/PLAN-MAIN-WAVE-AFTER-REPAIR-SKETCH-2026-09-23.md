---
id: PLAN-MAIN-WAVE-AFTER-REPAIR-SKETCH-2026-09-23
from: team_110
to: team_00
date: 2026-09-23
status: VALIDATED-AWAITING-SKETCH
validator: gpt-5.6-sol-medium
validator_id: 00f279bb-7e3a-48e1-896e-88773667e14d
findings_open: 0
---

# תוכנית מיין — מה שלא ממתין לאייל

אין קוד ואין FTP מהסשן הזה עד שני שערים: התוכנית הזו מאושרת, וסקיצת `/repair/` חזרה מאושרת מצוות 10.  
המנדט של 10: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/TO-TEAM10-GO-REPAIR-SKETCH-2026-09-23.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/TO-TEAM10-GO-REPAIR-SKETCH-2026-09-23.md)

מקורות:

- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--design-notes/2026-09-23--design-notes--from-eyal.docx](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--design-notes/2026-09-23--design-notes--from-eyal.docx)
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--whatsapp-after-1158/eyal-s006-excel-answers-2026-09-21T11-06-38Z.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--whatsapp-after-1158/eyal-s006-excel-answers-2026-09-21T11-06-38Z.json)
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--whatsapp-after-1158/ea-media-filter-2026-09-21T13-51-27-450Z.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-09-23--whatsapp-after-1158/ea-media-filter-2026-09-21T13-51-27-450Z.json)

תמה חיה עכשיו: 1.5.111. צור קשר כבר עלה. לא פותחים אותו מחדש.

## מחוץ לגל

תפריט (M1, `T-NAV-HOLD`), מוקש (M5), סטנדים כשיחה (M6), הסטת 82ch (M3), כותרות cbDIDG (M7), קרוסלה בלי קבצים (M8), מוזיקת רקע בלי קובץ (M9), 179 בלי `assignedPage`, A3, A5, C1, תמונה ייחודית לכל QR (`Q-HERO-ASK`).

## גל א — לא תלוי בסקיצה

מתחיל רק אחרי אישור התוכנית הזו **וגם** אחרי שהסקיצה חזרה, כדי שלא יידרסו קבצים ב-FTP. התוכן של הגל לא מחכה לצבע.

### T-COOKIE-COPY

ציטוט, מסמך 23.9:

> שימוש בעוגיות  
> כדי לשפר את חוויית הגלישה, לתפעל את האתר ולנתח את השימוש בו, אנו משתמשים בקובצי Cookies ובטכנולוגיות דומות. מידע נוסף על השימוש במידע מופיע במדיניות הפרטיות.  
> [אישור] [דחייה]  
> את הלחצן של "אישור" צריך להדגיש יותר כמובן. שזו תהיה ברירת המחדל.

קוד היום: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/ea-cookie-notice.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/ea-cookie-notice.php) שורות 52–57. כותרת «שימוש בעוגיות ובמדידה». גוף על GA4. כפתורים «אישור מדידה» ו«המשך בלי מדידה».  
הדגשה כבר חלקית ב-[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-cookie-notice.css](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-cookie-notice.css): `.ea-cookie__ack` מלא, `.ea-cookie__reject` מתאר.

מימוש: להחליף את שלושת המחרוזות. הקישור למדיניות הפרטיות נשאר. `data-ea-cookie-choice` נשאר `accept` / `reject`. לא מיל נוסף.

דפדפן: ביקור ראשון בלי העוגייה `ea_cookie_cmp`. הכותרת והפסקה זהות לציטוט. «אישור» מלא ו«דחייה» מתאר. לחיצה על כל אחד סוגרת את הדיאלוג ולא פותחת אותו שוב בריענון. 390 ו-1440, בלי גלילה אופקית.

### T-QR-SWAP

ציטוט, אותו מסמך. permalink לא זז.

| עמוד | מה משתנה |
|---|---|
| `/qr/qr6/` | הווידאו החסר מוחלף ב-https://www.youtube.com/watch?v=Lak0__1Hqwc |
| `/qr/qr8/` | כל התוכן מוחלף בפסקה «כאן 11 \| בראבא, לסלאו, קטורזה, רשף, גורי, פוליאקוב, גיתית, ליטל, פרידמן, דב ותום - על כורסה אחת. וכולם משתפים את החוויות והסיפורים הכי אישיים, מוזרים ומצחיקים ממלחמת המפרץ:» וב-https://www.youtube.com/watch?v=RH7Zv8Iqw4s |
| `/qr/qr18/` | «13 הצעות נישואין שקצת התפקששו» https://www.youtube.com/watch?v=ZrRFtY9z3wY ו«ואיך אפשר בלי סרטון של הצעות נישואין מרגשות עד דמעות:» https://www.youtube.com/watch?v=GYQxjlUO15U |
| `/qr/qr23/` | כל התוכן מוחלף: «אודי כגן – הלך לי השזלונג» https://www.youtube.com/watch?v=zoKn9_3xUIc ו«תום יער ספיישל הריון ולידה» https://www.youtube.com/watch?v=gdavWTyCcy4 |
| `/qr/qr27/` | רק וידאו לואיס סי קיי מוחלף ב-https://www.youtube.com/watch?v=sIA_-7lBmGY |
| `/qr/qr28/` | היפרלינק https://www.npr.org/2005/11/09/5005952/hungry-planet-what-the-world-eats ווידאו נשיונל ג׳אוגרפיק מוחלף ב-https://www.youtube.com/watch?v=Ht1Ub6Xl93g&list=PLDB837E03BF7E16FF |
| `/qr/qr31/` | הווידאו השבור מוחלף ב-https://www.youtube.com/watch?v=-Jcqxr9Djjc והתמונה החסרה יורדת מ-https://www.eyalamit.co.il/wp-content/uploads/2016/12/CR-7.jpg |

קוד: התוכן הוא `post_content` של העמוד הקיים. התבנית [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-qr.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-qr.php) קוראת `the_content()` ולא מחזיקה את גוף ה-QR. אין קובץ PHP חדש לכל QR. אין slug חדש.

מימוש: עדכון העמוד הקיים בסטייג'ינג. ב-QR6, QR27, QR28, QR31 מחליפים רק את היעד שצוין. ב-QR8 וב-QR23 מחליפים את כל הגוף. התמונה של QR31 עולה לספריית המדיה ומקושרת מתוך אותו עמוד.

דפדפן: כל אחת משבע הכתובות 200, אותו path. ה-iframe או הקישור החדש נוכחים. ב-QR27 שאר העמוד נשאר. ב-QR28 קישור NPR נפתח. ב-QR31 התמונה נטענת (לא 404). 390 בלי גלילה אופקית.

### T-BLOG-HERO-OLD

ציטוט: «בלוג, האם אפשר לבקש מקלוד להעתיק את כל תמונות הנושא מהאתר המקורי? כרגע מופיעות רק תמונות בודדות בבלוג.»

קוד: כרטיס הבלוג משתמש בתמונה הראשית של הפוסט. הארכיון [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-blog-archive.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-blog-archive.php) לא מחזיק רשימת תמונות.

מימוש: לכל פוסט מפורסם בלי תמונה ראשית, לחפש את אותו פוסט ב-`https://www.eyalamit.co.il/` לפי slug ואז לפי כותרת, ולהעתיק את תמונת הנושא. אין התאמה — שורה בדוח, בלי תמונה מומצאת ובלי תמונה של פוסט אחר.

דפדפן: `/blog/` מראה תמונה על כל כרטיס שיש לו מקור. כרטיס בלי מקור נשאר בלי תמונה ומתועד.

### T-BLOG-CHIPS

ציטוט: «מופיעים בכותרת מילות מפתח לחיפוש אבל הן כולן נוגעות לכתיבה ולמופע סיפורים. צריך להוסיף לחצנים נוספים: דיג'רידו, נשימה. צריך לבקש מקלוד שיעבור על התכנים בבלוג ויחשוב אם צריך להוסיף קטגוריות נוספות.»

קוד: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-blog-archive.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-blog-archive.php) שורות 62–68. `get_categories( array( 'hide_empty' => true ) )`. לחצן ריק לא יופיע.

מימוש: ליצור את הקטגוריות «דיג׳רידו» ו«נשימה» אם חסרות, ולשייך פוסטים קיימים שהכותרת או הקטגוריה הישנה שלהם עוסקת בזה. לא לפתוח קטגוריה שלישית בגל. אם הסריקה מוצאת מועמד, הוא נרשם לפגישה.

דפדפן: ב-`/blog/` מופיעים «דיג׳רידו» ו«נשימה». לחיצה על כל אחד מסננת (`?cat=`) ומחזירה לפחות פוסט אחד. «הכל» מחזיר את הרשימה המלאה.

### T-FOOTER-MOTION

ציטוט: «בפוטר אשמח אם הוא יכנס בצורה יותר מונפשת כמו באתר הישן.»

קוד: `.foot` ב-[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/chapters.css](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/chapters.css) שורה 312. `background:var(--dark)` ו-`--dark:#0E0905`. אין אנימציית כניסה.

מימוש: לבדוק את כניסת הפוטר ב-`https://www.eyalamit.co.il/` ולשחזר את התנועה על `.foot`. צבע הפוטר לא משתנה. `prefers-reduced-motion: reduce` מכבה את התנועה.

דפדפן: גלילה אל הפוטר ב-`/contact/` וב-`/repair/`. הפוטר נכנס בתנועה. הרקע נשאר `#0E0905`. ב-390 אין גלילה אופקית.

### T-BOOK-FOLD

ציטוט, אקסל 21.9, על שלושת הספרים:

> אולי כדאי לתת את ארבעת השורות הראשונות ואז להוסיף בסוף להמשך קריאה>> (לחיצה על זה תפתח את יתר הטקסט באקורדיון. את ההערה הזו צריך להחיל גם על שני הספרים האחרים.

המילה במקור היא «שורות», לא «משפטים».

קוד היום: שלושת הקבצים עם `collapsible => true` ותווית «קטע מתוך הספר – לקריאה». הגוף כולו סגור עד לחיצה.

- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/kushi-blantis-defaults.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/kushi-blantis-defaults.php)
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/tsva-bekahol-defaults.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/tsva-bekahol-defaults.php)
- [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/vekatavta-defaults.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/vekatavta-defaults.php)
- הרנדר: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/prose.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/prose.php) שורות 34–36, `<details>` סגור.

מימוש: ארבע שורות ויזואליות גלויות (`line-clamp: 4` על מידת השורה החיה), ואז פקד שהטקסט שלו «להמשך קריאה». לחיצה פותחת את יתר הקטע. לא משכתבים את גוף הקטע. גלריית הספרים לא זזה בגל הזה.

דפדפן: `/books/kushi-blantis/`, `/books/tsva-bekahol/`, `/books/vekatavta/`. לפני לחיצה נראות ארבע שורות והפקד. אחרי לחיצה נראה המשך הקטע. 390 ו-1440.

## גל ב — רק אחרי סקיצת התיקון המאושרת

ה-HEX והיחס תמונה-גדולה מול גלריה-בתחתית נלקחים מהדוח `TO-TEAM110-DONE-REPAIR-SKETCH-2026-09-23.md` אחרי אישור נימרוד. בלי המספרים האלה הגל לא מתחיל.

### T-COLOR / M4

ציטוט, מסמך 23.9: «יש באתר בלוקים בצבע שחור שנראים כמו פוטר. … צריך לשנות את הצבע של הבלוקים הבעייתיים ולהחליף אותם בחום כלשהו מהפלטה שהגשנו.»

ציטוט קודם, אקסל, על בלוק «לרכישת ספר»: אותו בלבול, על כל דף עם הבלוק הזה.

קוד: `.cta-band`, `.sec--dark`, `.start` ב-`chapters.css` משתמשים ב-`--dark-grad` (מ-`#0B0703` אל `#2A1A0C`) ועליו `--ea-dark-warm-wash`. הפוטר `.foot` הוא `--dark:#0E0905` ונשאר.

מימוש: ה-HEX שאושר על `/repair/` עולה לשלושת הסלקטורים האלה בכל האתר. המועמדים מהפלטה שננעלה הם רק `#5C3A2E`, `#8A5A44`, `#A44E2B`, `#AB3A2B`. `#9A4F2B` הוא `--terra-dk` החי, לא צבע בפלטה, ולא מועמד. `:root` של שאר הגוונים (הכפתור החי מול טרקוטה בפלטה, דיו, גוף) משתנה רק אם דוח הסקיצה סגר גם אותם. הפוטר לא נצבע מחדש.

דפדפן: `/repair/`, `/books/kushi-blantis/`, `/method/`. הבלוק האמצעי בצבע שאושר. הפוטר עדיין `#0E0905`. טקסט לבן על הבלוק לפחות 4.5:1. 390 ו-1440.

### T-GALLERY-ASSIGNED

האקסל על הספרים, סעיף 3: «את הבלוק של "גלריה" צריך להעביר ממש לסוף הדף» — גם בשני הספרים האחרים. זה חלק מהגל, לא מגל א.

שאר העמודים: רק פריטים עם `status=need` ו-`assignedPage` לא ריק בייצוא 13:51Z. הערה «גלריה כללית בתחתית העמוד» הולכת לתחתית. בלי ההערה — לאורך העמוד, באותו יחס שהסקיצה קבעה בתיקון. 179 בלי עמוד לא נכנסים. `status=no` לא נכנס, גם אם יש הערה.

דפדפן: לכל עמוד שקיבל תמונות, התמונות שסומנו לתחתית אחרי אחרון בלוקי התוכן, והשאר למעלה. ספירה זהה לייצוא. אין תמונה מעמוד אחר.

## סדר ביצוע אחד, אחרי שני השערים

תמה אחת, FTP אחד, ואז דפדפן 390/1440 במנוע שאינו הבונה על: עוגיות, שבעת ה-QR, `/blog/`, פוטר, שלושת הספרים, `/repair/`, ועמוד אחד נוסף עם הבלוק הכהה. הלוח והטופס נגזרים מ-`scripts/s007_render_work_ssot.py` רק אחרי שהקוד חי. צוות 10 לא ממזג ולא כותב ל-SSOT.

## אימות

מנוע שאינו הכותב, 23.9: [אימות התוכנית](00f279bb-7e3a-48e1-896e-88773667e14d). שלושה פערים תוקנו (מילת «כמובן» בעוגיות, «ואיך» ונקודתיים ב-QR18, `#9A4F2B` יצא מרשימת המועמדים). בדיקה חוזרת: `FINDINGS_OPEN: 0`.

שער: אין קוד עד אישור נימרוד על התוכנית הזו, ואין FTP של הגל עד שסקיצת תיקון הכלים חזרה מאושרת.
