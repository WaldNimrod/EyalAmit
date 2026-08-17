# MANDATE — team_90 · Composer · R1-05 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/sound-healing/` (אין `?compare=eyal`).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/sound-healing/`

מקור בייטים: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/סאונדהילינג/sound_healing_final.md`
אין `סקירה סאונד הילינג`. לא לאמת מול `docs/project/eyal-ceo-submissions-and-responses/from-eyal/`.

### א1. מידע (CONFIRMED/FAIL + ציטוט מ-`<main>`)

1. H1 = `סאונד הילינג פרטי בדיג'רידו - מסע אישי בצליל ותדר ליחידים ולזוגות` בלי `<em>`. כפתור הירו `לתיאום שיחת היכרות` → `/contact/`.
2. אין «המפגשים מתקיימים בסטודיו של אייל עמית בפרדס חנה». אין `.bleed` / `.steps` / `מבנה המפגש`.
3. אין `.rcard` / `.reveals` / `ועוד למי זה מתאים`. «איך זה עובד?» כולל «אוהל הטיפי» ו«כשעתיים».
4. אין `href` ל-`/eyal-amit/mokesh-dahiman/` ב-`<main>`. «מוקש דהימן» כטקסט. אין `/method-cbdidg`. `שיטת cbDIDG` → `/method/`.
5. בדיוק 8 `<details class="ea-faq-item">` בתוך `.ea-faq-list`. קישור FAQ המלא → `/faq/`.
6. 8 שמות ממליצים ייחודיים + 8 `href` Facebook. קרין: `1TNJeTs7Mo`. `לכל ההמלצות על אייל עמית` → `/testimonials/`.
7. h2 `רוצים להגיע למפגש?` + כפתור `יצירת קשר` → `/contact/`. אין WhatsApp ב-`<main>`.

### א2. ממשקים

8. אפס כרטיס/סקשן ריק ב-`<main>`. תמונות הירו שכבר היו באתר נשארו — SH-01 ממתין לאייל, לא FAIL. אין רכיב וידאו ל-SECTION 05 (SH-02) — לא FAIL.
9. `qa_probe` דסקטופ:
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /sound-healing/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

### א3. קישורים — HEAD/GET עם `-sk -o /dev/null -w '%{http_code} %{url_effective}'`

PASS רק אם 200 או 301 לאותו אתר (לא 404, לא 000).

פנימיים בגוף (`<main>`):
- `/contact/`
- `/method/`
- `/treatment/`
- `/lessons/`
- `/faq/`
- `/testimonials/`

8 קישורי פייסבוק SECTION 09 — HEAD; 200/301/302 = PASS. 404 = FAIL. חסימת Facebook (403/login) = הערה לא חוסמת אם ה-URL תואם למסמך.

תפריט ראשי (דגימה): `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` — 200 או 301.

`tel:+972524822842` ו-`wa.me/972524822842` — קיימים ב-HTML (footer). לא חובה לפתוח WhatsApp.

אין לדרוש 200 על `/method-cbdidg` (404 ידוע, הוחלף ב-`/method/`).

---

## עדשה ב׳ — חומר אייל + אקסל + הנגשה §3ג

קבצים:
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx`
- ו/או `_COMMUNICATION/team_100/S006/tracker/latest.csv` + `latest-items.csv`
- טאב `עמוד · סאונד הילינג` / `r1-05-items.json`
- אמנה: `_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md` §2, §3א, §3ג

אל תשנה את האקסל.

### ב1. גיליון ראשי (סבב-1-ליבה · R1-05)

10. שורה R1-05 קיימת, נתיב `/sound-healing/`.
11. `סטטוס מכונה` = `הוגש לבדיקה`.
12. `ממתין ל` = `אייל` (בגלל SH-01/SH-02). אם `team_100` — FAIL.
13. סוכן לא כתב בעמודות אנוש (`סטטוס אישור`, `הערות נימרוד`, `הערות אייל`, `תאריך אישור`).

### ב2. טאב העמוד — הנגשה לאייל

רק SH-01, SH-02 אמורים להיות `ממתין לאייל`. SH-03…SH-08 = `בוצע` / `ברור`.

14. SH-01 ו-SH-02: עמודת `מה נדרש ממך` משפט אנושי אחד, בלי PHP/git. `_picks` קיימות. URL חי בעמודת קישור.
15. אין שאלות לנימרוד פתוחות על העמוד.
16. סעיפים ממתינים של עמודים אחרים (H-01/H-06/H-07, T-01/T-02, MTH-01, LSN-01/LSN-02/LSN-09, M-01a/M-03/M-04/M-05) לא דורסו.
17. אין קובץ `to-eyal` חדש ל-R1-05. ההגשה היא סטייג'ינג + שורת אקסל.

### ב3. נעילת סיווג

18. SH-01/02 = `לא ברור`. SH-03…08 = `ברור` ובוצעו. אם ברור סומן כממתין לאייל — FAIL.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה.
טבלה קצרה: מספר בדיקה · CONFIRMED/FAIL · ציטוט (HTTP code / תא אקסל / קטע HTML).
ריק = FAIL.
