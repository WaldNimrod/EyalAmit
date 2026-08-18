# MANDATE — team_90 · Composer · R1-16 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/books/` (אין `?compare=eyal`).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-16-E2E-2026-08-18.md`

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/books/`

מקור בייטים: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/מוזה הוצאה לאור - ספרים/MUZZA.md`
אין `סקירה מוזה`. לא לאמת מול `from-eyal/`.

### א1. מידע (CONFIRMED/FAIL + ציטוט מ-`<main>`)

1. H1 = `מוזה הוצאה לאור` בלי `<em>`. H2 רק מ-`### כותרת`: «למה את הספרים של מוזה תמצאו כאן» · «חבילת 3 הספרים של אייל עמית» · «שלושה ספרים, שלושה עולמות». אין H2 «הספרים של מוזה» / «סגירת עמוד» / «על אייל עמית».
2. שלושה CTA כרטיס ככתבם: «לעמוד הספר צבע בכחול וזרוק לים» · «לעמוד הספר כושי בלאנטיס» · «לעמוד הספר וכתבת». אין `bookcard__meta` / «2001 · מסעות».
3. כפתור אחד `לרכישת חבילת 3 הספרים` → `https://mrng.to/MTUiO3vkIg`. אין `pending-note` / «ממתין לאישור».
4. BK-04/05/06 מדיה ממתינים לאייל — תמונות קיימות / באנדל בלי תמונה = לא FAIL.

### א2. ממשקים

5. אפס כרטיס/סקשן ריק ב-`<main>`.
6. `qa_probe` דסקטופ:
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /books/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

### א3. קישורים

פנימיים בגוף (`<main>`): `/books/tsva-bekahol/` · `/books/kushi-blantis/` · `/books/vekatavta/` — 200 או 301.
חיצוני: `https://mrng.to/MTUiO3vkIg` — 200/301/302 = PASS. חסימת CDN/קצר = הערה לא חוסמת אם ה-URL תואם למסמך.

תפריט ראשי (דגימה): `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` — 200 או 301.

---

## עדשה ב׳ — אקסל

SSoT = xlsx / `latest-items.csv`. אל תשנה את האקסל.

7. R1-16 קיימת, נתיב `/books/`. `סטטוס מכונה` = `הוגש לבדיקה`. `ממתין ל` = `אייל` (BK-04/05/06). אם `team_100` — FAIL.
8. סוכן לא כתב בעמודות אנוש.
9. רק BK-04, BK-05, BK-06 = `ממתין לאייל`. BK-01…03 = `בוצע` / `ברור`. `מה נדרש ממך` אנושי, `_picks`, URL חי.
10. אין שאלות לנימרוד פתוחות. סעיפי עמודים אחרים לא דורסו. אין `to-eyal` חדש.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה. טבלה קצרה. ריק = FAIL.
