# MANDATE — team_90 · Composer · R1-23 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/contact/`. **אין שינוי PHP** — הוגש כקיים.
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-23-E2E-2026-08-18.md`

נימרוד 18.8.26: «זה פשוט הפרטים המדויקים. אין מה לשנות.» אל תדרשו הסרת `<em>` או שינוי NAP. אל תדרשו מקור md מאייל.

---

## עדשה א׳ — שלמות העמוד החי

URL: `http://eyalamit-co-il-2026.s887.upress.link/contact/`

אין חבילת `content 13.8.26` לעמוד. לא לאמת מול `from-eyal/`.

### א1. מידע (CONFIRMED/FAIL + ציטוט מ-`<main>`)

1. H1 מכיל `צור` ו-`קשר` (מותר `<em>` — זה המצב שהוגש). HTTP 200.
2. NAP ב-`<main>`: `עמל 8 ב'` (או `רח' עמל 8 ב'`) + `פרדס חנה`. טלפון תצוגה `052-4822842`. `tel:+972524822842`.
3. טופס פנייה קיים (CF7 או גיבוי) עם שדות שם/טלפון/הודעה — לא לבדוק שליחה חיה.
4. קישור WhatsApp `wa.me/972524822842` קיים בעמוד או בפוטר.

### א2. ממשקים

5. אפס כרטיס/סקשן ריק ב-`<main>`.
6. `qa_probe` דסקטופ:
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /contact/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

### א3. קישורים

תפריט ראשי (דגימה): `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` — 200 או 301.
`tel:+972524822842` קיים ב-HTML.

---

## עדשה ב׳ — אקסל

SSoT = xlsx / `latest-items.csv`. אל תשנה את האקסל.

7. R1-23 קיימת, נתיב `/contact/`. `סטטוס מכונה` = `הוגש לבדיקה`.
8. `ממתין ל` = `נימרוד` **הוא PASS** (אין סעיפי מדיה לאייל; CNT-01 בוצע). אם `אייל` בלי סעיף ממתין — הערה, לא FAIL. אם `team_100` — FAIL.
9. CNT-01 = `בוצע` / `ברור`. אין סעיפים `ממתין לאייל` על העמוד.
10. סוכן לא כתב בעמודות אנוש. אין `to-eyal` חדש. סעיפי עמודים אחרים לא דורסו.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה. טבלה קצרה. ריק = FAIL.
