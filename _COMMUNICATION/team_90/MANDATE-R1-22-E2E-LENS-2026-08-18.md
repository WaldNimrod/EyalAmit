# MANDATE — team_90 · Composer · R1-22 E2E + עדשת אקסל

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
**היקף:** דסקטופ. העמוד שלנו = `/eyal-amit/mokesh-dahiman/`.
**TLS:** `curl -sk` מותר מול הסטייג'ינג בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL.

שורה ראשונה חייבת להיות בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`

שתי עדשות. FAIL באחת = FAIL כללי. אל תשנה קבצים.
כתוב ל-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-R1-22-E2E-2026-08-18.md`

---

## עדשה א׳ — דיוק מידע, ממשקים, קישורים

URL: `http://eyalamit-co-il-2026.s887.upress.link/eyal-amit/mokesh-dahiman/`

מקור: `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/מוקש - דף הנחצחה לזרכו ופועלו/מוקש - דף הנצחה לזיכרו ופועלו.docx`
אין `סקירה מוקש`. לא לאמת מול `from-eyal/`.

### א1. מידע

1. H1 = `מי היה מוקש דהימן?` בלי `<em>`. אין תג `1950–2020` / `לזכרו · 1950` ב-`<main>`.
2. כותרות המסמך בסדר (לפחות): היכרותו הראשונה · בית המלאכה ברישיקש · Dream Time · קוטלי · הגשמת החלום · תפנית חדה · פרידה · ומה היום · דברי הספד. אין H2 ממציא: צינור האום, שפת הלב, תם עידן.
3. `(jungle vibes)` ו-`jungel vibes` ככתבם — לא `Jungle Vibes` כמותג מתוקן ב-`<main>`.
4. `href` Gofundme `https://www.gofundme.com/f/Roof-For-Mukesh` ו-Facebook `https://www.facebook.com/mukesh.the.art.of.shanti.living.the.movie`.
5. **לא FAIL:** timeline, bleed, gallery 19, fbembeds, תמונות קיימות, `yt_id` — נימרוד השאיר; ממתינים לאייל (MK-02…07).

### א2. ממשקים

6. אפס כרטיס/סקשן ריק ב-`<main>`.
7. `qa_probe` דסקטופ:
    `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /eyal-amit/mokesh-dahiman/`
    PASS רק אם desktop `overflow: false` ו-`forbiddenFound: []`. מובייל מחוץ להיקף.

### א3. קישורים

Gofundme + Facebook סרט — HEAD; 200/301/302 = PASS. 404 = FAIL. חסימת Facebook (403/login) = הערה לא חוסמת אם ה-URL תואם.
תפריט ראשי (דגימה): `/` `/method/` `/lessons/` `/sound-healing/` `/shop/` `/contact/` `/eyal-amit/` `/books/` — 200 או 301.
קישור מוקש בתפריט (dropdown) ל-`/eyal-amit/mokesh-dahiman/` — 200.

---

## עדשה ב׳ — אקסל

SSoT = xlsx / `latest-items.csv`. אל תשנה את האקסל.

8. R1-22 קיימת, נתיב `/eyal-amit/mokesh-dahiman/`. `סטטוס מכונה` = `הוגש לבדיקה`. `ממתין ל` = `אייל` (MK-02…07). אם `team_100` — FAIL.
9. סוכן לא כתב בעמודות אנוש.
10. רק MK-02…07 = `ממתין לאייל`. MK-01 = `בוצע` / `ברור`. `מה נדרש ממך` אנושי, `_picks`, URL חי.
11. אין שאלות לנימרוד פתוחות (MK-06/07 הועברו לאייל לפי נימרוד). סעיפי עמודים אחרים לא דורסו. אין `to-eyal` חדש.

---

## פלט

`VERDICT: PASS` או `VERDICT: FAIL` בשורה הראשונה. טבלה קצרה. ריק = FAIL.
