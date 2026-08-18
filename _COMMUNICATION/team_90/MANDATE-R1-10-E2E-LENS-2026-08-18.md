# MANDATE — team_90 · Composer · R1-10 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/shop/` (אין `?compare=eyal`).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-10-E2E-2026-08-18.md`

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/shop/`

מקור בייטים: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/כלים למכירה/buy didgeridoo.md`
אין `סקירה חנות`. לא לאמת מול `docs/project/eyal-ceo-submissions-and-responses/from-eyal/`.

### א1. מידע (CONFIRMED/FAIL + ציטוט מ-`<main>`)

1. H1 = `כלי דיג'רידו למכירה - כלים בעבודת יד` בלי `<em>`. אין תג «חנות». אין גריד `bookcard`. אין «מחיר לפי התאמה». אין כרטיס סטנד רצפתי.
2. ארבעה כפתורי CTA ל-`/contact/` ככתבם במסמך (תיאום והתאמה / הגעה והתנסות / בדיקת זמינות / הגעה ובחירת כלי).
3. בדיוק 5 `<details class="ea-faq-item">` בתוך `.ea-faq-list` ב-`<main>` (faq-inline).
4. שלושה ממליצים + Facebook href: שירי אלקבץ · רותי שליט · אלון גרזון רז. URLs: `1E7ndvYyrp` · `19m2waNvQe` · `1Cky28MdtH`.
5. SHP-01/02 תמונות ממתינות לאייל — אין רכיב מדיה חדש שהומצא. לא FAIL אם אין תמונות הירו/אביזרים.

### א2. ממשקים

6. אפס כרטיס/סקשן ריק ב-`<main>`.
7. `qa_probe` דסקטופ:
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /shop/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

### א3. קישורים — HEAD/GET עם `-sk -o /dev/null -w '%{http_code} %{url_effective}'`

PASS רק אם 200 או 301 לאותו אתר (לא 404, לא 000).

פנימיים בגוף (`<main>`):
- `/contact/`
- `/treatment/`
- `/method/`
- `/lessons/`
- `/sound-healing/`
- `/repair/`
- `/instruments` — **301 מותר** (יעד חי `/tools-and-accessories/instruments/`). 404 = FAIL. אל תדרשו שה-href יהיה `/bags/`.

3 קישורי פייסבוק SECTION 09 — HEAD; 200/301/302 = PASS. 404 = FAIL. חסימת Facebook (403/login) = הערה לא חוסמת אם ה-URL תואם למסמך.

תפריט ראשי (דגימה): `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` — 200 או 301.

`tel:+972524822842` ו-`wa.me/972524822842` — קיימים ב-HTML (footer). לא חובה לפתוח WhatsApp.

---

## עדשה ב׳ — חומר אייל + אקסל + הנגשה §3ג

קבצים:
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx`
- ו/או `_COMMUNICATION/team_100/S006/tracker/latest.csv` + `latest-items.csv`
- טאב `עמוד · עמוד קטלוג ראשי` / `r1-10-items.json`
- אמנה: `_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md` §2, §3א, §3ג

אל תשנה את האקסל. **SSoT סטטוס סעיף = xlsx / latest-items.csv** (לא JSON ישן).

### ב1. גיליון ראשי (סבב-1-ליבה · R1-10)

8. שורה R1-10 קיימת, נתיב `/shop/`.
9. `סטטוס מכונה` = `הוגש לבדיקה`.
10. `ממתין ל` = `אייל` (בגלל SHP-01/SHP-02). אם `team_100` — FAIL.
11. סוכן לא כתב בעמודות אנוש (`סטטוס אישור`, `הערות נימרוד`, `הערות אייל`, `תאריך אישור`).

### ב2. טאב העמוד — הנגשה לאייל

רק SHP-01, SHP-02 אמורים להיות `ממתין לאייל`. SHP-03…SHP-05 = `בוצע` / `ברור`.

12. SHP-01 ו-SHP-02: עמודת `מה נדרש ממך` משפט אנושי אחד, בלי PHP/git. `_picks` קיימות. URL חי בעמודת קישור.
13. אין שאלות לנימרוד פתוחות על העמוד.
14. סעיפים ממתינים של עמודים אחרים (BK-04/05/06, ABT-02/05/08, MK-02…07, H-01 וכו') לא דורסו.
15. אין קובץ `to-eyal` חדש ל-R1-10. ההגשה היא סטייג'ינג + שורת אקסל.

### ב3. נעילת סיווג

16. SHP-01/02 = `לא ברור`. SHP-03…05 = `ברור` ובוצעו. אם ברור סומן כממתין לאייל — FAIL.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה.
טבלה קצרה: מספר בדיקה · CONFIRMED/FAIL · ציטוט (HTTP code / תא אקסל / קטע HTML).
ריק = FAIL.
