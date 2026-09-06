# מנדט · נגישות עכשיו (דסקטופ) · צוות 10 · 2026-08-26

**מוציא:** צוות 100 · **מבצע:** צוות **10** בלבד · **מאמת אחרי תיקון:** צוות 50 (לא אותו מנוע)  
**חוק:** [PLAN-S006-A11Y-DEPTH-NOW-AND-R3-2026-08-26.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/PLAN-S006-A11Y-DEPTH-NOW-AND-R3-2026-08-26.md)  
**GO:** team_00 ביקש טיפול עומק עכשיו. זה **לא** חתימת AA. זה תיקון פגמים שבורים בדסקטופ.

## אסור

- FTP בלי אישור נימרוד אחרי שהקוד במאגר.
- שכתוב `accessibility-defaults.php` / הדבקת הצהרה / הסרת באנר WP-EI-05.
- Enable Accessibility · תוסף נגישות שני · רכיב נגישות מאפס.
- שינוי תפריט/פוטר/צבעי מותג «לייפות».
- נגיעה ב־defaults של 23 עמודי סבב 1 מעבר ל־`alt` על תמונות קיימות.

## חובה — ארבעה תיקונים

### A11Y-NOW-01 · דילוג שבור

בסטייג'ינג חי: `<a class="ea-skiplink" href="#main">דלג לתוכן</a>` אבל בעמודי chapters **אין** `id="main"` — יש `id="chapters-main"`.

**DoD:** קישור דילוג **אחד** (או שניהם) מגיע ל־`<main>` האמיתי בכל תבנית: chapters, blog, EN, QR. בדיקת Tab בדף הבית: Enter על הדילוג מעביר פוקוס לתוכן, לא לראש התפריט.

מקורות: `inc/wave2-stage-b.php` (`href="#main"`) · תבניות `id="chapters-main"` · `header.php` `#ea-main` (מעטפת בלי GeneratePress).

המלצת 100: יעד קנוני אחד — או `id="main"` על כל `<main>` + CSS שמכיר גם `chapters-main`, או skiplink שבורר לפי התבנית. לא להשאיר `#main` מת על chapters.

### A11Y-NOW-02 · שפת הדילוג ב־EN

`/en/` מגיש דילוג בעברית מדילוג הגל + Skip to content מהתבנית. ליישר: בעמוד `lang=en` כל דילוג באנגלית.

### A11Y-NOW-03 · alt ריק על תמונות תוכן בדף הבית

שבע תמונות עם `alt=""` שהן תוכן (לא קישוט), בין היתר: `breath-practice.jpg`, `didgs-window.jpg`, `eyal-bright.jpg`, `eyal-window.jpg`, `eyal-close.jpg`, `studio-interior.jpg`.

**DoD:** alt בעברית קצר שמתאר את התמונה. דקורטיבי אמיתי נשאר `alt=""`. בלי המצאת סיפור.

### A11Y-NOW-04 · הגדרת WP Accessibility

Settings → WP Accessibility: יעד skip = המזהה החי של `<main>` אחרי 01. צילום מסך בהגדרות בדוח. לא להפעיל שכבת UI שמשנה DOM מעבר לדילוג+פוקוס.

## אימות אחרי ביצוע

- `curl`/דפדפן: בדף הבית `href` של `.ea-skiplink` מצביע למזהה שקיים ב־HTML.
- צוות 50: Tab+Enter לדילוג בבית + צור קשר. לא חתימת AA.

## דוח סיום

`_COMMUNICATION/team_10/DONE-S006-A11Y-NOW-TEAM10-2026-08-26.md` — רשימת קבצים, לפני/אחרי למזהה הדילוג, רשימת alt שנוספו.
