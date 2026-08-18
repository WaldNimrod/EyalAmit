# MANDATE — team_90 · Composer · R1-21 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/eyal-amit/` (אין `?compare=eyal` — שתי גרסאות באותו עמוד).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-21-E2E-2026-08-18.md`

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/`

מקורות בייטים:
- גרסה א׳: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/אודות - אייל עמית/אודות - אייל עמית.md`
- גרסה ב׳: `…/אייל_עמית_אודות_חדש_מלא_לאתר (נשמר אוטומטית).docx`

אין `סקירה אודות`. לא לאמת מול `from-eyal/`.

### א1. מידע

1. תווית `גרסה א׳ — המסמך` לפני `גרסה ב׳ — הצעת SEO` ב-`<main>`.
2. H1 גרסה א׳ = `אייל עמית` בלי `<em>`.
3. גרסה א׳ כוללת: גבעתיים · שריפה בגיל 12 · 2003 · שבעת המורים (מוקש, יורם סיון, תמיר אלוני, טל מידן, אלה טולנאי, לילה וניגם חפר, שיר סופר).
4. גרסה ב׳ כוללת: משאפים · עוזר נגר. אין בלוק Schema/FAQPage / כותרת «למה מנועי חיפוש ומנועי AI» ב-`<main>`.
5. אין `href` עם `/muzeh` ב-`<main>`. יש `/books/` ו-`/eyal-amit/mokesh-dahiman/`. ויקיפדיה כטקסט בלי href מומצא.
6. אין ציר זמן עם שנת 2000. ABT-02 תמונות קיימות — לא FAIL.

### א2. ממשקים

7. אפס כרטיס/סקשן ריק ב-`<main>`.
8. `qa_probe` דסקטופ:
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /eyal-amit/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

### א3. קישורים ב-`<main>`

200 או 301: `/books/` · `/eyal-amit/mokesh-dahiman/` · `/shop/` · `/learning/` · `/treatment/` · `/contact/` · `/method/` (אם מופיעים כ-href).
תפריט ראשי (דגימה): `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` — 200 או 301.

---

## עדשה ב׳ — אקסל

SSoT = xlsx / `latest-items.csv`. אל תשנה את האקסל.

9. R1-21 קיימת, נתיב `/eyal-amit/`. `סטטוס מכונה` = `הוגש לבדיקה`. `ממתין ל` = `אייל` (ABT-08/02/05). אם `team_100` — FAIL.
10. סוכן לא כתב בעמודות אנוש.
11. רק ABT-02, ABT-05, ABT-08 = `ממתין לאייל`. ABT-01/03/04/06/09 = `בוצע`. ABT-07 = `הוקפא` (לא ממתין לאייל).
12. ABT-08/02/05: `מה נדרש ממך` אנושי, `_picks`, URL חי. אין שאלות לנימרוד פתוחות. סעיפי עמודים אחרים לא דורסו. אין `to-eyal` חדש.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה. טבלה קצרה. ריק = FAIL.
