# MANDATE — team_90 · Composer · R1-19 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/books/vekatavta/` (אין `?compare=eyal`).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-19-E2E-2026-08-18.md`

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/books/vekatavta/`

מקור בייטים: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/וכתבת/vekatavta.md`
אין `סקירה וכתבת`. לא לאמת מול `from-eyal/`.

### א1. מידע (CONFIRMED/FAIL + ציטוט מ-`<main>`)

1. H1 = `וכתבת` בלי `<em>`. אין `79` ₪. אין `mrng.to`.
2. `https://www.mendele.co.il/product/vekatavta/` מופיע. כתיב `היקוקומורי`/`היקוקמורי` ככתבו (לא «היקיקומורי»).
3. בדיוק 7 `<details class="ea-faq-item">` ב-faq-inline ב-`<main>`.
4. אין `temp_note` / חשבונית ירוקה.
5. VKT-01/02 מדיה ממתינים — אין רכיב מדיה חדש שהומצא. לא FAIL.

### א2. ממשקים

6. אפס כרטיס/סקשן ריק ב-`<main>`.
7. `qa_probe` דסקטופ:
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /books/vekatavta/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

### א3. קישורים — HEAD/GET עם `-sk -o /dev/null -w '%{http_code} %{url_effective}'`

PASS רק אם 200 או 301 לאותו אתר (לא 404, לא 000).

פנימיים: תפריט ראשי (דגימה) `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` — 200 או 301.
חיצוני: `https://www.mendele.co.il/product/vekatavta/` — 200/301/302 = PASS.

---

## עדשה ב׳ — חומר אייל + אקסל + הנגשה §3ג

קבצים:
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx`
- ו/או `_COMMUNICATION/team_100/S006/tracker/latest.csv` + `latest-items.csv`
- טאב `עמוד · וכתבת` / `r1-19-items.json`
- אמנה: `_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md` §2, §3א, §3ג

אל תשנה את האקסל. **SSoT סטטוס סעיף = xlsx / latest-items.csv** (לא JSON ישן).

### ב1. גיליון ראשי (סבב-1-ליבה · R1-19)

8. שורה R1-19 קיימת, נתיב `/books/vekatavta/`.
9. `סטטוס מכונה` = `הוגש לבדיקה`.
10. `ממתין ל` = `אייל` (VKT-01/02). אם `team_100` — FAIL.
11. סוכן לא כתב בעמודות אנוש (`סטטוס אישור`, `הערות נימרוד`, `הערות אייל`, `תאריך אישור`).

### ב2. טאב העמוד — הנגשה לאייל

רק VKT-01, VKT-02 אמורים להיות `ממתין לאייל`. VKT-03…VKT-05 = `בוצע` / `ברור`.

12. VKT-01/02: עמודת `מה נדרש ממך` משפט אנושי אחד, בלי PHP/git. `_picks` קיימות. URL חי בעמודת קישור.
13. אין שאלות לנימרוד פתוחות על העמוד.
14. סעיפים ממתינים של עמודים אחרים לא דורסו.
15. אין קובץ `to-eyal` חדש ל-R1-19. ההגשה היא סטייג'ינג + שורת אקסל.

### ב3. נעילת סיווג

16. VKT-01/02 = `לא ברור`. VKT-03…05 = `ברור` ובוצעו. אם ברור סומן כממתין לאייל — FAIL.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה.
טבלה קצרה: מספר בדיקה · CONFIRMED/FAIL · ציטוט (HTTP code / תא אקסל / קטע HTML).
ריק = FAIL.
