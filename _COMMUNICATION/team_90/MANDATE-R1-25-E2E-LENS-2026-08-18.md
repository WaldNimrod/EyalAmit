# MANDATE — team_90 · Composer · R1-25 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/faq/` (אין `?compare=eyal`).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-25-E2E-2026-08-18.md`

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/faq/`

מקור Hero/Intro + תשובות שמוזגו: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/דף FAQ/FAQ FINAL.md`
טבלת מיזוג: `_COMMUNICATION/team_100/S006/RESEARCH-R1-25-FAQ-MERGE-TABLE-2026-08-18.md`
אין `סקירה FAQ`. לא לאמת מול `from-eyal/`.

חריג team_00 18.8.26: ערוץ CPT/JSON נפתח למיזוג. לא לגעת ב-`block-faq-list.php`.

### א1. מידע (CONFIRMED/FAIL + ציטוט מ-`<main>`)

1. H1 = `שאלות נפוצות` בלי `<em>`. אין תג-פרק «שאלות נפוצות» מעל H1. CTA «שיחת היכרות» → `/contact/`.
2. Intro כולל href `/didgeridoo-treatment` ככתבו במסמך (לא הומר ל-`/treatment/`).
3. אקורדיון: אין כרטיס PLACEHOLDER / «שאלת דוגמה». ספירת `<details class="ea-faq-item">` ≥ 108 (צפוי ~110).
4. שאלות מוצרים/ספרים שעדיין ב-TOC נשארות — לא FAIL.
5. FAQ-01 מדיה ממתינה — אין רכיב מדיה חדש שהומצא. לא FAIL.

### א2. ממשקים

6. אפס כרטיס/סקשן ריק ב-`<main>`.
7. `qa_probe` דסקטופ:
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /faq/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

### א3. קישורים — HEAD/GET עם `-sk -o /dev/null -w '%{http_code} %{url_effective}'`

PASS רק אם 200 או 301 לאותו אתר (לא 404, לא 000).

פנימיים בגוף (`<main>`): `/contact/` · `/didgeridoo-treatment` (**301 מותר** ליעד חי) · `/sound-healing/` · `/lessons/` · `/method/`.
תפריט ראשי (דגימה): `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` — 200 או 301.

---

## עדשה ב׳ — חומר אייל + אקסל + הנגשה §3ג

קבצים:
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx`
- ו/או `_COMMUNICATION/team_100/S006/tracker/latest.csv` + `latest-items.csv`
- טאב `עמוד · שאלות נפוצות (FAQ)` / `r1-25-items.json`
- אמנה: `_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md` §2, §3א, §3ג
- טבלת מיזוג: `_COMMUNICATION/team_100/S006/RESEARCH-R1-25-FAQ-MERGE-TABLE-2026-08-18.md`

אל תשנה את האקסל. **SSoT סטטוס סעיף = xlsx / latest-items.csv** (לא JSON ישן).

### ב1. גיליון ראשי (סבב-1-ליבה · R1-25)

8. שורה R1-25 קיימת, נתיב `/faq/`.
9. `סטטוס מכונה` = `הוגש לבדיקה`.
10. `ממתין ל` = `אייל` (FAQ-01/FAQ-04). אם `team_100` — FAIL.
11. סוכן לא כתב בעמודות אנוש (`סטטוס אישור`, `הערות נימרוד`, `הערות אייל`, `תאריך אישור`).

### ב2. טאב העמוד — הנגשה לאייל

רק FAQ-01, FAQ-04 אמורים להיות `ממתין לאייל`. FAQ-02, FAQ-03 = `בוצע` / `ברור`.

12. FAQ-01/FAQ-04: עמודת `מה נדרש ממך` משפט אנושי אחד, בלי PHP/git. `_picks` קיימות. URL חי בעמודת קישור.
13. אין שאלות לנימרוד פתוחות על העמוד (הכרעת CPT כבר כתובה).
14. סעיפים ממתינים של עמודים אחרים לא דורסו.
15. אין קובץ `to-eyal` חדש ל-R1-25. ההגשה היא סטייג'ינג + שורת אקסל + טבלת המיזוג ב-_COMMUNICATION.

### ב3. נעילת סיווג

16. FAQ-01/FAQ-04 = `לא ברור`. FAQ-02/FAQ-03 = `ברור` ובוצעו. אם ברור סומן כממתין לאייל — FAIL.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה.
טבלה קצרה: מספר בדיקה · CONFIRMED/FAIL · ציטוט (HTTP code / תא אקסל / קטע HTML).
ריק = FAIL.
