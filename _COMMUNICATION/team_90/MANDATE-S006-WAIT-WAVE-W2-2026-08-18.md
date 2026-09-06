# MANDATE — team_90 · Composer · S006 WAIT-WAVE W2 · מפת קליטה 129

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
`curl -sk` / `curl -skI` לסטייג'ינג בלבד. פלט ריק = FAIL. `-fast` אסור. **אל תשנה קבצים** מלבד קובץ הפסק שלך. **אסור PHP** ו-129 קבצי RESEARCH.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`

כתוב אל: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-WAIT-WAVE-W2-2026-08-18.md`

מפה: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/R2-INTAKE-MAP-2026-08-18.csv`

בסיס: `http://eyalamit-co-il-2026.s887.upress.link`

## חוזה

1. **129/129 שורות.** אין תא ריק ב-`HTTP_ראשון`, `HTTP_סופי`, `חבילה_דרייב`. ספרו בעצמכם (לא להעתיק את סיכום הבנאי).

2. **מדגם HEAD עצמאי ≥12 שורות**, לפחות 3 מכל סוג. חובה לכלול בדיוק את אלה (אפשר להוסיף):

| סוג | מזהים | נתיבים |
|---|---|---|
| עמוד | R2-003 · R2-006 · R2-007 | `/accessibility/` · `/historical-articles/` · `/learning/courses-external/` |
| QR | R2-081 · R2-082 · R2-083 | `/qr/` · `/qr/qr1/` · `/qr/qr10/` |
| פוסט | R2-027 · R2-028 · R2-029 | שלושת הפוסטים הראשונים במפה |
| legacy/301 | R2-004 · R2-005 · R2-008 | `/courses-soon/` · `/hashita/` · `/muzeh/` |

לכל שורת מדגם: HEAD ראשון (`curl -skI -o /dev/null -w '%{http_code}'`) ואז GET עם עד 2 קפיצות (`curl -sk -L --max-redirs 2 -o /dev/null -w '%{http_code} %{url_effective}'`). תוצאה זהה למפה ±תעבורה (301 מול 200 בקפיצה ראשונה = FAIL רק אם המפה טוענת 200 והחי 301, או להפך). יעד 301 חייב להיות 200 או 301→200. 404 ביעד = ממצא בטבלה, לא תיקון.

3. **0 שינוי תחת** `site/wp-content/themes/` בגל W2 — `git diff -- site/wp-content/themes/` ריק ביחס ל-HEAD **או** הסבירו שכל diff קיים אינו מ-W2 (W1 glob / Hub / W3 מדידה ב-`tmp/`). אסור `defaults.php` חדש.

4. חבילת דרייב: התאמה שמרנית מול `content 13.8.26` (תיקייה↔נתיב). פוסט/QR/301 = `אין` זה צפוי. R2-001/002 עם חבילת אודות/מוקש + `לא-ברור` זה צפוי (אותה חבילה כבר בסבב 1).

מרווח בין בקשות ≥0.3s (uPress מגביל).

## פלט

טבלה: מזהה · סוג · HTTP מפה · HTTP מאמת · חבילה · תוצאה · ראיה.
אל תבנו עמודי סבב 2.
