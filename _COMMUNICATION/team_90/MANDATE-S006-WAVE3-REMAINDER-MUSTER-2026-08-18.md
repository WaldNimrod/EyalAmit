# MANDATE — team_90 · Composer · S006 wave 3 remainder muster

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. גל 3 remainder בלבד: R1-17 / R1-18 / R1-19 / R1-25 / R1-28. הקפאות R1-07/08/09/27 מחוץ להיקף (אין PHP).
TLS פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL. `-fast` אסור.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-WAVE3-REMAINDER-MUSTER-2026-08-18.md`

בסיס: `http://eyalamit-co-il-2026.s887.upress.link`

אל תשנה קבצים מלבד פסק הדין. מובייל מחוץ להיקף. סעיפי אייל פתוחים אינם FAIL של המפקד.

## בדיקות

1. שלושת ה-href מכרטיסי הספרים בהורה `/books/` מחזירים 200 (או 301 לאותו נתיב קנוני):
   `/books/kushi-blantis/` · `/books/tsva-bekahol/` · `/books/vekatavta/`
2. `/faq/` ו-`/snoring-sleep-apnea/` מחזירים 200.
3. האב `/books/` מחזיר 200. **לא נפתח מחדש** — H1 עדיין `מוזה הוצאה לאור` בלי em. אל תדרשו שינוי ב-`muzza-defaults.php`.
4. H1 של החמישה מול המקור:
   - `/books/kushi-blantis/` → `כושי בלאנטיס`
   - `/books/tsva-bekahol/` → `צבע בכחול וזרוק לים`
   - `/books/vekatavta/` → `וכתבת`
   - `/faq/` → `שאלות נפוצות`
   - `/snoring-sleep-apnea/` → מכיל `נחירות ודום נשימה בשינה`
5. `qa_probe` דסקטופ על חמשת נתיבי ההדבקה יחד:
   `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /books/kushi-blantis/,/books/tsva-bekahol/,/books/vekatavta/,/faq/,/snoring-sleep-apnea/`
   PASS רק אם לכל נתיב desktop `overflow: false` ו-`forbiddenFound: []`.
6. דגימת `#nav` רמה ראשונה — רגרסיית 404 בלבד, לא סעיפי אייל. דגימה: `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` `/treatment/` `/faq/` `/snoring-sleep-apnea/`. `/learning/` נשאר `#` בלי ילדי הכשרות/הרצאות/סדנאות חדשים (הקפאה). R1-29 `/learning/courses/` מחוץ לסקואופ — אל תדרשו 200.
