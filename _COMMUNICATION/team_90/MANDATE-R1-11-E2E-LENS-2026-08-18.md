# MANDATE — team_90 · Composer · R1-11 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/repair/` (אין `?compare=eyal`).
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-11-E2E-2026-08-18.md`

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/repair/`

מקור בייטים: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/תיקון כלי דיג_רידו/build didg.md`

### א1. מידע

1. H1 = `תיקון וחידוש דיג'רידו` בלי `<em>`. אין תג-פרק. אין פסקת מהנדס. אין «מחיר לפי התאמה». אין `mrng.to`. אין גלריית pending.
2. CTA `לתיאום בדיקה לכלי` → `/contact/`.
3. בדיוק 6 `<details class="ea-faq-item">` ב-`.ea-faq-list` ב-`<main>`.
4. קישור `/tools-and-accessories` ככתבו (לא `/shop/`).
5. REP-01/02 מדיה+המלצות ממתינים — לא FAIL אם חסרים.

### א2. ממשקים

6. אפס כרטיס ריק ב-`<main>`.
7. `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /repair/` — desktop `overflow: false`, `forbiddenFound: []`.

### א3. קישורים

פנימיים: `/contact/` `/method/` `/tools-and-accessories` — 200 או 301 לאותו אתר.
תפריט ראשי דגימה: `/` `/shop/` `/repair/` `/didgeridoos/` `/bags/` `/stands-storage/` `/stand-floor/` `/contact/` — 200 או 301.

---

## עדשה ב׳ — אקסל

- `_COMMUNICATION/team_100/S006/tracker/latest.csv` + `latest-items.csv`
- טאב `עמוד · תיקון וחידוש דיג'רידו` / `r1-11-items.json`

8. R1-11 קיימת, נתיב `/repair/`. `סטטוס מכונה` = `הוגש לבדיקה`. `ממתין ל` = `אייל` (REP-01/02).
9. REP-03/04 = `בוצע` / `ברור`. REP-01/02 = `ממתין לאייל` + משפט אנושי ב-`מה נדרש ממך`.
10. אין שאלות נימרוד פתוחות. עמודות אנוש לא נגע. סעיפי אייל של עמודים אחרים לא דורסו.
