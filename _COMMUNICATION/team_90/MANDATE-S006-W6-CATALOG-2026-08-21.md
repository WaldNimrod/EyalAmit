# MANDATE — team_90 · Composer · גל 6 · קטלוג וכלים

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6. פלט ריק = FAIL. אל תשנה קבצים מלבד הפסק.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`  
כתוב אל: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-W6-CATALOG-2026-08-21.md`

חי (כולם `http://` דסקטופ, בלי `https://`):

- `http://eyalamit-co-il-2026.s887.upress.link/shop/`
- `http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/`
- `http://eyalamit-co-il-2026.s887.upress.link/repair/`
- `http://eyalamit-co-il-2026.s887.upress.link/bags/`
- `http://eyalamit-co-il-2026.s887.upress.link/stands-storage/`
- `http://eyalamit-co-il-2026.s887.upress.link/stand-floor/`

מקורות: תיקיית  
`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/הערות של אייל לאחר סבב שלב 1 - 19.8.26/`  
קבצים: `עמוד קטלוג ראשי.xlsx` · `תיקון וחידוש דיג_רידו.xlsx` · `תיקים לדיג_רידו.xlsx` · `סטנדים לאחסון דיג_רידו.xlsx` · `סטנד רצפתי לנגינה בישיבה נמוכה.xlsx`

## בדיקות

1. `/shop/` הוא שער, לא שכפול של `/didgeridoos/`. יש H2/כותרת `כל מה שצריך לדיג׳רידו, במקום אחד` וחמש קוביות עם קישורים ל-`/didgeridoos/` · `/repair/` · `/bags/` · `/stands-storage/` · `/stand-floor/`.
2. בסרגל הראשי, «כלים ואביזרים» הוא קישור ל-`/shop/` (לא כפתור בלי href).
3. `/didgeridoos/` H2 `מי בונה את הכלים ולמה זה חשוב`. מופיע `מאז 1999`. מופיע קישור `לקריאה נוספת אודות אייל עמית` אל `/eyal-amit/`. «תיקים לדיג'רידו» → `/bags/` ו«סטנדים לאחסון» → `/stands-storage/` (לא `/instruments`).
4. ב-`/didgeridoos/` בלוק `מה אומרים אנשים שעובדים עם הכלי` הוא קרוסלת `testi-mq` עם שני כפתורי חץ. כפתור לכל העדויות → `/testimonials/` (לא `/media/`). אין תמונות פרופיל מומצאות (`via.placeholder` / `ui-avatars`).
5. `/repair/`: הפסקה מתחת להירו מתחילה ב-`תהליך תיקון כלי דיג'רידו מבוסס`. קישור `מוקש דהימן` → `/eyal-amit/mokesh-dahiman/`. אין בלוק המלצות/קרוסלה בעמוד התיקון.
6. `/bags/`: אחרי «תמונות מהשטח» יש גלריה עם 6 תמונות. רצועת bleed נשארת.
7. `/stands-storage/`: H1 מכיל `סטנדים לאחסון דיג'רידו לתלייה או בעמידה`. בגוף «מה זה» אין מקף ארוך (`–`) בין «מסודרת» ל«בלי». יש גלריה עם לפחות 5 תמונות. השורה האחרונה של «למי זה מתאים» מכילה `כלי שימושי ואסטטי`.
8. `/stand-floor/`: 200 ולא ריק. **לא** נדרש שינוי בגל זה (אקסל ריק = אין הערות). שינוי עותק/גלריה שם = FAIL.

אסור: `videoblk.php` · `block-faq-list.php`. קבצים dirty מלפני הגל אינם FAIL.
