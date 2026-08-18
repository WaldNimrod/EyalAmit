# MANDATE — team_90 · Composer · R1-18 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/books/tsva-bekahol/` (אין `?compare=eyal`).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-18-E2E-2026-08-18.md`

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/`

מקור בייטים: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/צבע בכחול וזרוק לים/eyal_tsva_FINAL.md`
אין `סקירה צבע`. לא לאמת מול `from-eyal/`.

### א1. מידע (CONFIRMED/FAIL + ציטוט מ-`<main>`)

1. H1 = `צבע בכחול וזרוק לים` בלי `<em>`. אין `59` ₪. אין `mrng.to`.
2. רכישה מודפסת → `/contact/`. אין כפתור מנדלי (TSV-07 404 ממתין לאייל — לא FAIL אם חסר).
3. בדיוק 5 `<details class="ea-faq-item">` ב-faq-inline ב-`<main>`. לשמור «להינות» / «ימכר» ככתבם.
4. אין `temp_note` / חשבונית ירוקה / `garden.jpg` כספליט.
5. TSV-01/02/03 מדיה ממתינים — אין רכיב מדיה חדש שהומצא. לא FAIL.

### א2. ממשקים

6. אפס כרטיס/סקשן ריק ב-`<main>`.
7. `qa_probe` דסקטופ:
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /books/tsva-bekahol/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

### א3. קישורים — HEAD/GET עם `-sk -o /dev/null -w '%{http_code} %{url_effective}'`

PASS רק אם 200 או 301 לאותו אתר (לא 404, לא 000).

פנימיים בגוף (`<main>`): `/contact/` · `/about/` (קישור 08 ככתבו בסטייג'ינג — 200/301 בסטייג'ינג = PASS).
תפריט ראשי (דגימה): `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` — 200 או 301.

אין href חי ל-`mendele.co.il/product/tsvabacholvezorekleyam` (TSV-07).

---

## עדשה ב׳ — חומר אייל + אקסל + הנגשה §3ג

קבצים:
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx`
- ו/או `_COMMUNICATION/team_100/S006/tracker/latest.csv` + `latest-items.csv`
- טאב `עמוד · צבע בכחול וזרוק לים` / `r1-18-items.json`
- אמנה: `_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md` §2, §3א, §3ג

אל תשנה את האקסל. **SSoT סטטוס סעיף = xlsx / latest-items.csv** (לא JSON ישן).

### ב1. גיליון ראשי (סבב-1-ליבה · R1-18)

8. שורה R1-18 קיימת, נתיב `/books/tsva-bekahol/`.
9. `סטטוס מכונה` = `הוגש לבדיקה`.
10. `ממתין ל` = `אייל` (TSV-01/02/03/07). אם `team_100` — FAIL.
11. סוכן לא כתב בעמודות אנוש (`סטטוס אישור`, `הערות נימרוד`, `הערות אייל`, `תאריך אישור`).

### ב2. טאב העמוד — הנגשה לאייל

רק TSV-01, TSV-02, TSV-03, TSV-07 אמורים להיות `ממתין לאייל`. TSV-04…TSV-06 = `בוצע` / `ברור`.

12. TSV-01/02/03/07: עמודת `מה נדרש ממך` משפט אנושי אחד, בלי PHP/git. `_picks` קיימות. URL חי בעמודת קישור.
13. אין שאלות לנימרוד פתוחות על העמוד.
14. סעיפים ממתינים של עמודים אחרים לא דורסו.
15. אין קובץ `to-eyal` חדש ל-R1-18. ההגשה היא סטייג'ינג + שורת אקסל.

### ב3. נעילת סיווג

16. TSV-01/02/03/07 = `לא ברור`. TSV-04…06 = `ברור` ובוצעו. אם ברור סומן כממתין לאייל — FAIL.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה.
טבלה קצרה: מספר בדיקה · CONFIRMED/FAIL · ציטוט (HTTP code / תא אקסל / קטע HTML).
ריק = FAIL.
