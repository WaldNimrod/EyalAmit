# גל א — הערות אייל · מדידה אחרי מימוש · לאישור נימרוד

**תאריך:** 2026-09-20  
**סטייג'ינג:** http://eyalamit-co-il-2026.s887.upress.link (HTTP; TLS לא תקין בכוונה)  
**תמה חיה:** 1.5.96  
**קומיטים:** `8f5c9c6` (גל א) · `756347c` (תיקון מרוץ פופ העוגיות)  
**FTP:** `_COMMUNICATION/team_100/S006/DEPLOY-LOG.md` שורות 1.5.95 ו־1.5.96  

לא נפתח גל ב. לא נוספו פריטי L1 לתפריט. FAQ ועדויות נשארו במגירה.

צילומים מקומיים (לא ב-Git, לפי כלל המדיה ב־`_COMMUNICATION/`): [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/)

---

## טבלת סעיפים

| # | נדרש | בוצע | לפני | אחרי | איך נבדק | סיכון |
|---|---|---|---|---|---|---|
| 1 | כפילות «אייל עמית» ליד הלוגו | וורדמרק **המרכז לטיפול בדיג׳רידו** ליד הסימן; `aria-label` זהה; מגירה זהה. התפריט נשאר «אייל עמית» → אודות+מוקש | סימן בלבד; aria «אייל עמית — דף הבית». הוורדמרק הורד ב־18.9 | וורדמרק חי בדסקטופ רחב (≥1500px) ובמובייל. בין 1081–1499 מוסתר כדי לא לדחוק את שורת L1 | GET + צילום בית | מחרוזת ארוכה; ברוחב ביניים נשאר סימן בלבד |
| 6 | תוויות פוטר | Chapters: «בלוג דיג׳רידו», «ספרים – מוזה הוצאה לאור»; ב«מה מציעים»: «כלים ואביזרים» → `/shop/`, «לימוד והכשרה» → `/learning/` (חי, HTTP 200) | «בלוג», «ספרים · מוזה»; בלי כלים/לימוד בפוטר | כל ארבע התוויות חיות ב־`/` | snapshot בית | עמודת «מה מציעים» ארוכה יותר |
| 10 | שני וואטסאפ בצור קשר | וריאנט B הוסר מה־DOM. הצף כבר מדוכא ב־`is_page('contact')` | 2× `wa.me` ב־HTML (A + B `hidden`) | 1× `wa.me` נראה: «דברו איתי בוואטסאפ». אין `.ea-whatsapp-float` בדף | CDP `a[href*="wa.me"]` = 1 | NAP «טלפון / וואטסאפ» הוא `tel:` — נשאר |
| 15 | תיקון בסרגל | L2 ב־`ea-canonical-nav.php`: **תיקון וחידוש כלי דיג׳רידו** | «תיקון וחידוש כלים» | התווית החדשה במגירה ובדסקטופ | snapshot בית | תווית ארוכה בתפריט המשנה |
| 16 | הירו שיעורים מאחורי הסרגל | `.phero--media .phero__in` padding-block-start `calc(72px + 16px)`; overflow visible | מובייל 390: `h1Top=0`, `navBottom=72`, **overlap true**, gap −72 | אחרי: `h1Top=88`, gap +16, **overlap false**. `/treatment/` gap +626, overlap false | CDP לפני/אחרי + צילום | הירו מדיה גבוה יותר כשהליד ארוך |
| 7 | פופ יידוע עוגיות (גל א) | `<dialog>` ראשון, GA4 בשמו, קישור לפרטיות, «הבנתי». לא חוסם GA4, בלי קטגוריות. 1.5.95 רץ לפני ה־markup — תוקן ב־1.5.96 | אין באנר; מדיניות: «אין באנר הסכמה נפרד» | דיאלוג נפתח בכניסה ראשונה; `gtag` נשאר function; אחרי «הבנתי» לא חוזר (`localStorage ea_cookie_notice_ack`) | צילום דיאלוג פתוח + סגירה + טעינה חוזרת | זה יידוע, לא CMP. גל ב — יישום מלא |

---

## סקיצות ויזואליות

### לוגו + וורדמרק (דסקטופ)

לפני — סימן בלבד, התפריט כולל «אייל עמית»:

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-before-home-nav-desktop.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-before-home-nav-desktop.png)

אחרי — «המרכז לטיפול בדיג׳רידו» ליד הסימן (ימין ב־RTL); «אייל עמית» נשאר פריט תפריט:

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-after-cookie-home.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-after-cookie-home.png)

ב־1081–1499px הוורדמרק מוסתר בכוונה (הסרגל כבר מלא). במובייל (`<1081`) הוא מופיע ליד הסימן כי פריטי L1 מוסתרים.

### פופ עוגיות

מצב ראשון (דיאלוג פתוח, `gtag` חי):

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-after-cookie-dialog.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-after-cookie-dialog.png)

אחרי «הבנתי» — הדיאלוג יורד, האתר כרגיל (אותו צילום בית למעלה).

### הירו `/lessons/` מול הסרגל

לפני, דסקטופ — לא חופף (הבאג היה במובייל):

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-before-lessons-hero-desktop.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-before-lessons-hero-desktop.png)

לפני, מובייל — H1 ב־y=0 מאחורי הסרגל:

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-before-lessons-hero-mobile.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-before-lessons-hero-mobile.png)

אחרי, מובייל — H1 מתחת לסרגל, gap 16px:

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-after-lessons-hero-mobile.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-after-lessons-hero-mobile.png)

בקרת רגרסיה `/treatment/` — הירו בתחתית הצילום, לא מאחורי הסרגל:

[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-after-treatment-hero.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-a-shots/wave-a-after-treatment-hero.png)

---

## מה לא נכנס (גל ב / אחר כך)

- פירורי לחם, בלוקים שחורים, שבירת כותרות, קישורים ישנים, הגדלת הסרגל בגלילה
- יישום עוגיות מלא (קטגוריות / דחייה / CMP)
- FAQ ועדויות בסרגל — בלי L1 חדשים; נימרוד מול אייל על צמצום
