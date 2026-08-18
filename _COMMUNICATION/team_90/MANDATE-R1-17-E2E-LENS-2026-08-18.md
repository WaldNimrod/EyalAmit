# MANDATE — team_90 · Composer · R1-17 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/books/kushi-blantis/` (אין `?compare=eyal`).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-17-E2E-2026-08-18.md`

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/`

מקור בייטים: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/כושי בלאנטיס/kushi_full.md`
אין `סקירה כושי`. לא לאמת מול `from-eyal/`.

### א1. מידע (CONFIRMED/FAIL + ציטוט מ-`<main>`)

1. H1 = `כושי בלאנטיס` בלי `<em>`. אין תג `הספר`. אין `69` ₪. אין `mrng.to`.
2. קישור מנדלי `https://www.mendele.co.il/product/kushibelantis/` מופיע. מודפס = «קישור יתווסף בהמשך» (אין URL מודפס מומצא).
3. בדיוק 6 `<details class="ea-faq-item">` ב-faq-inline ב-`<main>`.
4. אין `.reveals` עם תשע תמונות chapters. אין `temp_note` / חשבונית ירוקה.
5. KSH-01–05 מדיה/אודות ממתינים לאייל — אין רכיב מדיה חדש שהומצא. לא FAIL אם אין גלריה/עיתונות חדשה. אין href חי ל-`https://www.eyalamit.co.il/about/` (KSH-05).

### א2. ממשקים

6. אפס כרטיס/סקשן ריק ב-`<main>`.
7. `qa_probe` דסקטופ:
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /books/kushi-blantis/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

### א3. קישורים — HEAD/GET עם `-sk -o /dev/null -w '%{http_code} %{url_effective}'`

PASS רק אם 200 או 301 לאותו אתר (לא 404, לא 000).

פנימיים בגוף (`<main>`): דגימת תפריט ראשי `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` — 200 או 301.

חיצוני: `https://www.mendele.co.il/product/kushibelantis/` — 200/301/302 = PASS.

`tel:+972524822842` ו-`wa.me/972524822842` — קיימים ב-HTML (footer). לא חובה לפתוח WhatsApp.

---

## עדשה ב׳ — חומר אייל + אקסל + הנגשה §3ג

קבצים:
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx`
- ו/או `_COMMUNICATION/team_100/S006/tracker/latest.csv` + `latest-items.csv`
- טאב `עמוד · כושי בלאנטיס` / `r1-17-items.json`
- אמנה: `_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md` §2, §3א, §3ג

אל תשנה את האקסל. **SSoT סטטוס סעיף = xlsx / latest-items.csv** (לא JSON ישן).

### ב1. גיליון ראשי (סבב-1-ליבה · R1-17)

8. שורה R1-17 קיימת, נתיב `/books/kushi-blantis/`.
9. `סטטוס מכונה` = `הוגש לבדיקה`.
10. `ממתין ל` = `אייל` (KSH-01–05). אם `team_100` — FAIL.
11. סוכן לא כתב בעמודות אנוש (`סטטוס אישור`, `הערות נימרוד`, `הערות אייל`, `תאריך אישור`).

### ב2. טאב העמוד — הנגשה לאייל

רק KSH-01…KSH-05 אמורים להיות `ממתין לאייל`. KSH-06…KSH-08 = `בוצע` / `ברור`.

12. KSH-01…05: עמודת `מה נדרש ממך` משפט אנושי אחד, בלי PHP/git. `_picks` קיימות. URL חי בעמודת קישור.
13. אין שאלות לנימרוד פתוחות על העמוד.
14. סעיפים ממתינים של עמודים אחרים לא דורסו.
15. אין קובץ `to-eyal` חדש ל-R1-17. ההגשה היא סטייג'ינג + שורת אקסל.

### ב3. נעילת סיווג

16. KSH-01…05 = `לא ברור`. KSH-06…08 = `ברור` ובוצעו. אם ברור סומן כממתין לאייל — FAIL.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה.
טבלה קצרה: מספר בדיקה · CONFIRMED/FAIL · ציטוט (HTTP code / תא אקסל / קטע HTML).
ריק = FAIL.
