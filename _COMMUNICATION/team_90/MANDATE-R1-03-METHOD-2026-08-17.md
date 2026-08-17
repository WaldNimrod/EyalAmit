# MANDATE — team_90 · Composer · R1-03 `/method/` content contract

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 (הסשן הזה) · Iron Rule #1.
**היקף:** דסקטופ בלבד. מובייל = מחוץ להיקף.
**עמוד:** `http://eyalamit-co-il-2026.s887.upress.link/method/`
אין `?compare=eyal` בעמוד הזה.

TLS פג בכוונה — `curl -sk` מותר כאן בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL. `-fast` אסור.

## ארבעת סעיפי החוזה (חובה)

1. **התאמת מקור** — כל מחרוזת תוכן חדשה חייבת להימצא במקור המצוטט. אחרת FAIL.
2. **האנק לא ממופה** — שינוי קוד שאינו ממופה לסעיף למטה → FAIL.
3. **Provenance** — מחרוזת שהשתנתה בלי הערת מקור בקוד → FAIL.
4. **פלט ריק = FAIL.**

**מקור הבייטים (SSOT, team_00 17.8.26):**
`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/השיטה/method.md`

אין קובץ `סקירה השיטה`. הכלל «אין הערה = מאושר» אינו חל. ה-md הוא הרצוי. הערות למתכנת = בלוקי DEV NOTES בתוך אותו md.

אל תאשרו מול `docs/project/eyal-ceo-submissions-and-responses/from-eyal/` (גיבוי בלבד).

## סעיפים ממופים (רק אלה מותרים ב-diff של ערכת הנושא)

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/method-defaults.php`
- `site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-method.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (דילוג ACF ל-`method`, C-11 — אותו ערוץ כתיבה כמו C-10 ב-`/treatment/`)

`git diff --name-only HEAD` בתוך ערכת הנושא חייב להיות תת-קבוצה של הרשימה הזו.
קבצי טרקר / `_COMMUNICATION` / `scripts/tracker_schema.py` / `tmp/` אינם FAIL.

**אסור לגעת:** `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · defaults של עמוד אחר.

## מה לבדוק ב-HTML החי (דסקטופ, `<main>` בלבד)

1. כותרת הירו `שיטת cbDIDG של אייל עמית` + CTA `לתיאום שיחת היכרות` → `/contact/`.
2. אין `circular-breathing` ב-`<main>`. אין קופסת `.ea-pending-approval` ב-`<main>` (JSON-LD ב-`<head>` עלול להכיל את המחלקה מבנק CPT — זה לא FAIL).
3. אין `<section class="bleed">`.
4. אין כרטיסי `.rcard` ב«למי השיטה מתאימה». הטקסט כולל «ולמי שמחפש תהליך אישי עמוק, ולא פתרון קסם מהיר.»
5. מופיע «סטודיו נשימה מעגלית» בסקשן אודות.
6. קישור `לימוד והכשרה` מצביע ל-`/learning/` (לא `/lessons/`).
7. אקורדיון נראה: בדיוק 7 `<details>` ב-`<main>` (שאלות SECTION 11). אל תספרו JSON-LD / `ea-faq-item` ב-schema. אין שאלות CPT נוספות באקורדיון הנראה.
8. שמונה שמות ממליצים ייחודיים, לכל אחד `href` ל-Facebook מ-SECTION 12. קרין: `18Ks7D2HQD`.
9. קישור `לעוד המלצות ועדויות` מצביע ל-`/media` (כפי שבמסמך — לא להמציא `/testimonials/`).
10. CTA סיום SECTION 14 → `/contact/`.

תמונות הירו/ספליט: נשארו קיימות; MTH-01 ממתין לאייל — **לא FAIL**.

## מלכודות מדידה

- הקרוסלה עשויה לשכפל כרטיסים ב-DOM — סופרים שמות/`href` ייחודיים.
- `-k` רק מול הסטייג'ינג.
- אל תבדקו מובייל.
- `qa_probe` דסקטופ בנוסף, אינו תחליף לחוזה.

## פלט חובה

שורה ראשונה בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`
אחר כך רשימת בדיקות קצרה עם CONFIRMED/FAIL + ציטוט ראיה.
ריק = FAIL.
