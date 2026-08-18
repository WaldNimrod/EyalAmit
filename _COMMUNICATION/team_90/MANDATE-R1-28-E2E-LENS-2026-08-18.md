# MANDATE — team_90 · Composer · R1-28 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/snoring-sleep-apnea/` (אין `?compare=eyal`).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-28-E2E-2026-08-18.md`

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/snoring-sleep-apnea/`

מקור בייטים: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/נחירות ודום נשימה/snoring-sleep-apnea-didgeridoo-CHECKED.md`
אין `סקירה נחירות`. לא לאמת מול `from-eyal/`.

### א1. מידע (CONFIRMED/FAIL + ציטוט מ-`<main>`)

1. H1 מכיל `נחירות ודום נשימה בשינה`. אין H2 `מה יש בעמוד הזה`. אין שורת «להשלמה לפני פרסום».
2. סיפור יוני **קיים**. באנר/כרטיס ממתין למכבי.jpg וליוני.jpg **קיימים** (SNR-01/02/03 — לא FAIL).
3. CTA `רוצה לדבר איתי` → `/contact/`. אין H2 כפול על אותו CTA.
4. SECTION 18 לא ציבורי.
5. WP-EI-03 לא נפתח — לא ממציאים jpg. SNR-01–04 ממתינים — לא FAIL.

### א2. ממשקים

6. אפס כרטיס/סקשן ריק ב-`<main>` (כרטיסי המתנה SNR-01/02 מותרים — הם לא ריקים).
7. `qa_probe` דסקטופ:
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /snoring-sleep-apnea/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

### א3. קישורים — HEAD/GET עם `-sk -o /dev/null -w '%{http_code} %{url_effective}'`

PASS רק אם 200 או 301 לאותו אתר (לא 404, לא 000).

פנימיים בגוף (`<main>`): `/contact/` · `/eyal-amit/`.
תפריט ראשי (דגימה): `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` — 200 או 301.

חיצוניים: `https://www.bmj.com/content/332/7536/266` · `https://www.maccabi4u.co.il/healthguide/medicalconditions/obstructivesleepapneaosa/` — 200/301/302 = PASS. חסימת CDN/WAF = הערה לא חוסמת אם ה-URL תואם למסמך.

---

## עדשה ב׳ — חומר אייל + אקסל + הנגשה §3ג

קבצים:
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/EA-CONTENT-TRACKER.xlsx`
- ו/או `_COMMUNICATION/team_100/S006/tracker/latest.csv` + `latest-items.csv`
- טאב `עמוד · דיג׳רידו, נחירות ודום נש` / `r1-28-items.json`
- אמנה: `_COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md` §2, §3א, §3ג

אל תשנה את האקסל. **SSoT סטטוס סעיף = xlsx / latest-items.csv** (לא JSON ישן).

### ב1. גיליון ראשי (סבב-1-ליבה · R1-28)

8. שורה R1-28 קיימת, נתיב `/snoring-sleep-apnea/`.
9. `סטטוס מכונה` = `הוגש לבדיקה`.
10. `ממתין ל` = `אייל` (SNR-01–04). אם `team_100` — FAIL.
11. סוכן לא כתב בעמודות אנוש (`סטטוס אישור`, `הערות נימרוד`, `הערות אייל`, `תאריך אישור`).

### ב2. טאב העמוד — הנגשה לאייל

רק SNR-01…SNR-04 אמורים להיות `ממתין לאייל`. SNR-05 = `בוצע` / `ברור`.

12. SNR-01…04: עמודת `מה נדרש ממך` משפט אנושי אחד, בלי PHP/git. `_picks` קיימות. URL חי בעמודת קישור.
13. אין שאלות לנימרוד פתוחות על העמוד.
14. סעיפים ממתינים של עמודים אחרים לא דורסו.
15. אין קובץ `to-eyal` חדש ל-R1-28. ההגשה היא סטייג'ינג + שורת אקסל.

### ב3. נעילת סיווג

16. SNR-01…04 = `לא ברור`. SNR-05 = `ברור` ובוצע. אם ברור סומן כממתין לאייל — FAIL.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה.
טבלה קצרה: מספר בדיקה · CONFIRMED/FAIL · ציטוט (HTTP code / תא אקסל / קטע HTML).
ריק = FAIL.
