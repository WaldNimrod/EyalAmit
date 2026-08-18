# MANDATE — team_90 · Composer · S006 wave 2 tools muster

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. גל 2 בלבד: R1-11…R1-15 + הורה `/shop/` (לא נפתח מחדש).
TLS פג בכוונה — `curl -sk` מותר כאן בלבד. פלט ריק = FAIL. `-fast` אסור.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-WAVE2-TOOLS-MUSTER-2026-08-18.md`

בסיס: `http://eyalamit-co-il-2026.s887.upress.link`

## בדיקות

1. חמשת ה-href בדרופדאון «כלים ואביזרים» מ-`section-nav.php` מחזירים 200 (או 301 לאותו נתיב קנוני):
   `/repair/` · `/didgeridoos/` · `/bags/` · `/stands-storage/` · `/stand-floor/`
2. האב `/shop/` מחזיר 200. **לא נפתח מחדש** — H1 עדיין `כלי דיג'רידו למכירה - כלים בעבודת יד` בלי em, בלי גריד מחירים. אל תדרשו שינוי ב-`shop-defaults.php`.
3. H1 של החמישה מול המקור:
   - `/repair/` → `תיקון וחידוש דיג'רידו`
   - `/didgeridoos/` → `כלי דיג'רידו למכירה - כלים בעבודת יד`
   - `/bags/` → `תיקים לדיג'רידו`
   - `/stands-storage/` → `סטנדים לאחסון דיג'רידו`
   - `/stand-floor/` → `סטנד רצפתי לדיג'רידו לנגינה בישיבה נמוכה`
4. `qa_probe` דסקטופ על חמשת הנתיבים יחד:
   `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /repair/,/didgeridoos/,/bags/,/stands-storage/,/stand-floor/`
   PASS רק אם לכל נתיב desktop `overflow: false` ו-`forbiddenFound: []`.
5. דגימת `#nav` רמה ראשונה — רגרסיית 404 בלבד, לא סעיפי אייל. דגימה: `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` `/treatment/` `/muzza/` `/mokesh/`.

מובייל מחוץ להיקף. סעיפי אייל פתוחים (כולל SHP-01/02, BAG-03/04/05, REP-01/02, DG-02/03, STN-01/02, FLR-01/02) אינם FAIL של המפקד.
