# MANDATE — team_90 · Composer · R1-04 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/lessons/` (אין `?compare=eyal`).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/lessons/`

מקור בייטים: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/שיעורי נגינה/lesons.md`
שם הקובץ `lesons.md`. אין `סקירה שיעורי נגינה`. לא לאמת מול `docs/project/eyal-ceo-submissions-and-responses/from-eyal/`.

### א1. מידע (CONFIRMED/FAIL + ציטוט מ-`<main>`)

1. H1 = `שיעורי נגינה בדיג'רידו לפי שיטת cbDIDG של אייל עמית` בלי `<em>`. כפתור הירו `לתיאום שיעור ראשון` → `/contact/`.
2. אין פסקת «אצל אייל עמית הלימוד פרטני» ב-`<main>`.
3. «איך נראים השיעורים בפועל» לפני «מה לומדים בפועל». אין `.rcard` / `.reveals`.
4. אין `href` ל-`/eyal-amit/mokesh-dahiman/` ב-`<main>`. «מוקש» כטקסט. אין `/didgeridoo-treatment` ב-`<main>`. «טיפול בדיג'רידו» → `/treatment/`.
5. בדיוק 8 `<details class="ea-faq-item">` בתוך `.ea-faq-list` ב-`<main>` (SECTION 09). אל תספרו `.dd__item` ואל תספרו JSON-LD.
6. 9 שמות ממליצים ייחודיים + 9 `href` Facebook מ-SECTION 08. רותי: `1E63Lr7iyJ`. אלכס פסטרנק: `1PDkhtFZ4t`.
7. אין h2 `בואו לנסות`. CTA סיום → `/contact/`.
8. אין `href` ל-`/blog/pregnancy-didgeridoo`. «לא מומלץ» כן מופיע (LSN-09 — לא FAIL).

### א2. ממשקים

9. אפס כרטיס/סקשן ריק ב-`<main>`. תמונות הירו שכבר היו באתר נשארו — LSN-01 ממתין לאייל, לא רכיב ריק ולא FAIL. אין רכיב וידאו ל-SECTION 04 (LSN-02, אין תוכן = אין רכיב) — לא FAIL.
10. `qa_probe` דסקטופ: הריצו מחדש
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /lessons/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף (אם רץ — התעלמו).

### א3. קישורים — HEAD/GET עם `-sk -o /dev/null -w '%{http_code} %{url_effective}'`

PASS רק אם 200 או 301 לאותו אתר (לא 404, לא 000).

פנימיים בגוף (`<main>`, לא תפריט גלובלי):
- `/contact/`
- `/method/`
- `/sound-healing/`
- `/treatment/`

9 קישורי פייסבוק SECTION 08 — HEAD; 200/301/302 = PASS. 404 = FAIL. חסימת Facebook (403/login) = הערה לא חוסמת אם ה-URL תואם למסמך.

תפריט ראשי (דגימה): `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` — 200 או 301.

`tel:+972524822842` ו-`wa.me/972524822842` — קיימים ב-HTML (footer). לא חובה לפתוח WhatsApp.

אין לדרוש 200 על `/blog/pregnancy-didgeridoo` (404 ידוע, LSN-09).

---

## עדשה ב׳ — חומר אייל + אקסל + הנגשה §3ג

קבצים:
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx`
- ו/או `_COMMUNICATION/team_100/S006/tracker/latest.csv` + `latest-items.csv`
- טאב `עמוד · שיעורי דיג'רידו` / `r1-04-items.json`
- אמנה: `_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md` §2, §3א, §3ג

אל תשנה את האקסל.

### ב1. גיליון ראשי (סבב-1-ליבה · R1-04)

11. שורה R1-04 קיימת, נתיב `/lessons/`.
12. `סטטוס מכונה` = `הוגש לבדיקה`.
13. `ממתין ל` = `אייל` (בגלל LSN-01/LSN-02/LSN-09). אם `team_100` — FAIL.
14. סוכן לא כתב בעמודות אנוש (`סטטוס אישור`, `הערות נימרוד`, `הערות אייל`, `תאריך אישור`).

### ב2. טאב העמוד — הנגשה לאייל

רק LSN-01, LSN-02, LSN-09 אמורים להיות `ממתין לאייל`. LSN-03…LSN-08 = `בוצע` / `ברור`.

15. כל אחד מ-LSN-01/02/09: עמודת `מה נדרש ממך` משפט אנושי אחד, בלי PHP/git. `_picks` / אפשרויות קיימות. URL חי בעמודת קישור.
16. אין שאלות לנימרוד פתוחות על העמוד.
17. סעיפים ממתינים של עמודים אחרים (H-01/H-06/H-07, T-01/T-02, MTH-01, M-01a/M-03/M-04/M-05) לא דורסו.
18. אין קובץ `to-eyal` חדש ל-R1-04. ההגשה היא סטייג'ינג + שורת אקסל.

### ב3. נעילת סיווג

19. LSN-01/02/09 = `לא ברור`. LSN-03…08 = `ברור` ובוצעו. אם ברור סומן כממתין לאייל — FAIL.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה.
טבלה קצרה: מספר בדיקה · CONFIRMED/FAIL · ציטוט (HTTP code / תא אקסל / קטע HTML).
ריק = FAIL.
