# MANDATE — team_90 · Composer · R1-03 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/method/` (אין `?compare=eyal`).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/method/`

מקור בייטים: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/השיטה/method.md`
אין `סקירה השיטה`. לא לאמת מול `docs/project/eyal-ceo-submissions-and-responses/from-eyal/`.

### א1. מידע (CONFIRMED/FAIL + ציטוט מ-`<main>`)

1. H1 = `שיטת cbDIDG של אייל עמית`. כפתור הירו `לתיאום שיחת היכרות` → `/contact/`.
2. אין `circular-breathing`. אין `.ea-pending-approval` ב-`<main>` (JSON-LD ב-`<head>` מותר).
3. אין `<section class="bleed">`. אין `.rcard`. יש «ולמי שמחפש תהליך אישי עמוק, ולא פתרון קסם מהיר.»
4. «סטודיו נשימה מעגלית» בסקשן אודות.
5. `לימוד והכשרה` → `/learning/` (לא `/lessons/`).
6. בדיוק 7 `<details>` ב-`<main>` (SECTION 11). אל תספרו JSON-LD.
7. 8 שמות ממליצים ייחודיים + 8 `href` Facebook מ-SECTION 12. קרין: `18Ks7D2HQD`.
8. `לעוד המלצות ועדויות` → `/media` (כפי שבמסמך).
9. CTA סיום SECTION 14 → `/contact/`.

### א2. ממשקים

10. אפס כרטיס/סקשן ריק ב-`<main>`. תמונות הירו שכבר היו באתר נשארו — MTH-01 ממתין לאייל, לא רכיב ריק ולא FAIL.
11. `qa_probe` דסקטופ: הריצו מחדש
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /method/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף (אם רץ — התעלמו).

### א3. קישורים — HEAD/GET עם `-sk -o /dev/null -w '%{http_code} %{url_effective}'`

PASS רק אם 200 או 301 לאותו אתר (לא 404, לא 000).

פנימיים בגוף (`<main>`, לא תפריט גלובלי):
- `/contact/` (הירו + CTA + SECTION 13)
- `/treatment/`
- `/lessons/`
- `/sound-healing/`
- `/eyal-amit/`
- `/eyal-amit/mokesh-dahiman/`
- `/learning/`
- `/faq/`
- `/media/` (או 301 ל-`/testimonials/` — מותר, זה הקנון החי)

8 קישורי פייסבוק SECTION 12 — HEAD; 200/301/302 = PASS. 404 = FAIL. חסימת Facebook (403/login) = הערה לא חוסמת אם ה-URL תואם למסמך.

תפריט ראשי (דגימה): `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` — 200 או 301.

`tel:+972524822842` ו-`wa.me/972524822842` — קיימים ב-HTML (footer). לא חובה לפתוח WhatsApp.

קישור BMJ — HEAD; 200/301/302 = PASS. 403 חיצוני = הערה לא חוסמת.

קישור הריברסינג ב-SECTION 11: היעד החי הוא `/ריברסינג-נשימה-מעגלית-דיגרידו/` (R2-058, 200 בסטייג'ינג). ה-URL ב-md (`/Blog/…-ודיג'רידו/`) הוא slug ישן ש-404. אל תדרשו את ה-404.

---

## עדשה ב׳ — חומר אייל + אקסל + הנגשה §3ג

קבצים:
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx`
- ו/או `_COMMUNICATION/team_100/S006/tracker/latest.csv` + `latest-items.csv`
- טאב `עמוד · השיטה` / `r1-03-items.json`
- אמנה: `_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md` §2, §3א, §3ג

אל תשנה את האקסל.

### ב1. גיליון ראשי (סבב-1-ליבה · R1-03)

12. שורה R1-03 קיימת, נתיב `/method/`.
13. `סטטוס מכונה` = `הוגש לבדיקה`.
14. `ממתין ל` = `אייל` (בגלל MTH-01). אם `team_100` — FAIL.
15. סוכן לא כתב בעמודות אנוש (`סטטוס אישור`, `הערות נימרוד`, `הערות אייל`, `תאריך אישור`).

### ב2. טאב העמוד — הנגשה לאייל

רק MTH-01 אמור להיות `ממתין לאייל`. MTH-02…MTH-08 = `בוצע` / `ברור`.

16. MTH-01: עמודת `מה נדרש ממך` משפט אנושי אחד, בלי PHP/git. `_picks` / אפשרויות = להשאיר / להחליף / בלי תמונה. URL חי בעמודת קישור.
17. אין שאלות לנימרוד פתוחות על העמוד.
18. סעיפים ממתינים של עמודים אחרים (H-01/H-06/H-07, T-01/T-02, M-01a/M-03/M-04/M-05) לא דורסו.
19. אין קובץ `to-eyal` חדש ל-R1-03. ההגשה היא סטייג'ינג + שורת אקסל.

### ב3. נעילת סיווג

20. MTH-01 = `לא ברור` (מדיה בלי קובץ מאייל). MTH-02…08 = `ברור` ובוצעו. אם ברור סומן כממתין לאייל — FAIL.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה.
טבלה קצרה: מספר בדיקה · CONFIRMED/FAIL · ציטוט (HTTP code / תא אקסל / קטע HTML).
ריק = FAIL.
