# MANDATE — team_90 · Composer · R1-04 `/lessons/` content contract

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 (הסשן הזה) · Iron Rule #1.
**היקף:** דסקטופ בלבד. מובייל = מחוץ להיקף.
**עמוד:** `http://eyalamit-co-il-2026.s887.upress.link/lessons/`
אין `?compare=eyal` בעמוד הזה.

TLS פג בכוונה — `curl -sk` מותר כאן בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL. `-fast` אסור.

## ארבעת סעיפי החוזה (חובה)

1. **התאמת מקור** — כל מחרוזת תוכן חדשה חייבת להימצא במקור המצוטט. אחרת FAIL.
2. **האנק לא ממופה** — שינוי קוד שאינו ממופה לסעיף למטה → FAIL.
3. **Provenance** — מחרוזת שהשתנתה בלי הערת מקור בקוד → FAIL.
4. **פלט ריק = FAIL.**

**מקור הבייטים (SSOT, team_00 17.8.26):**
`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/שיעורי נגינה/lesons.md`

שם הקובץ הוא `lesons.md` (חסר o). אין קובץ `סקירה שיעורי נגינה`. הכלל «אין הערה = מאושר» אינו חל. ה-md הוא הרצוי. הערות למתכנת = בלוקי DEV NOTES בתוך אותו md.

אל תאשרו מול `docs/project/eyal-ceo-submissions-and-responses/from-eyal/` (גיבוי בלבד).

## סעיפים ממופים (רק אלה מותרים ב-diff של ערכת הנושא)

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/lessons-defaults.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (דילוג ACF ל-`lessons`, C-12 — אותו ערוץ כתיבה כמו C-10/C-11)

`git diff --name-only HEAD` בתוך ערכת הנושא חייב להיות תת-קבוצה של הרשימה הזו.
קבצי טרקר / `_COMMUNICATION` / `scripts/` / `tmp/` אינם FAIL.

**אסור לגעת:** `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · defaults של עמוד אחר · `tpl-chapters-page.php`.

## מה לבדוק ב-HTML החי (דסקטופ, `<main>` בלבד)

1. H1 = `שיעורי נגינה בדיג'רידו לפי שיטת cbDIDG של אייל עמית` בלי `<em>`. CTA הירו `לתיאום שיעור ראשון` → `/contact/`.
2. אין פסקת פתיחה שהומצאה ב-SECTION 02 (הפסקה שמתחילה «אצל אייל עמית הלימוד פרטני» אינה במסמך — אם היא ב-`<main>` זה FAIL).
3. סדר כותרות: «איך נראים השיעורים בפועל» **לפני** «מה לומדים בפועל».
4. אין כרטיסי `.rcard` / `.reveals` ב«למי זה מתאים». שש הפסקאות מ-SECTION 06 כתובות.
5. אין `href` ל-`/eyal-amit/mokesh-dahiman/`. המילה «מוקש» מופיעה כטקסט. `[cbDIDG](/method)` ב-SECTION 01 ו-`שיטת [שיטת cbDIDG](/method)` ב-SECTION 07 ככתבם.
6. אין `href` ל-`/didgeridoo-treatment` ב-`<main>`. קישור «טיפול בדיג'רידו» → `/treatment/` (ניתוב קנוני כמו ריברסינג ב-R1-03).
7. אקורדיון FAQ נראה: בדיוק 8 `<details class="ea-faq-item">` בתוך `.ea-faq-list` ב-`<main>` (שאלות SECTION 09). אל תספרו `.dd__item` (SECTION 05) ואל תספרו JSON-LD. אין שאלות CPT נוספות באקורדיון ה-FAQ.
8. תשעה שמות ממליצים ייחודיים, לכל אחד `href` ל-Facebook מ-SECTION 08. רותי: `1E63Lr7iyJ`. אלכס פסטרנק: `1PDkhtFZ4t`.
9. אין h2 `בואו לנסות`. CTA סיום = פסקה + כפתור `לתיאום שיעור ראשון` → `/contact/`.
10. אין `href` ל-`/blog/pregnancy-didgeridoo` (404). הטקסט «לא מומלץ» כן מופיע. LSN-09 ממתין לאייל — **לא FAIL**.

תמונות הירו/ספליט: נשארו קיימות; LSN-01 ממתין לאייל — **לא FAIL**.
וידאו SECTION 04: לא רונדר רכיב וידאו (אין קובץ); LSN-02 ממתין לאייל — **לא FAIL**.

## מלכודות מדידה

- הקרוסלה עשויה לשכפל כרטיסים ב-DOM — סופרים שמות/`href` ייחודיים.
- `-k` רק מול הסטייג'ינג.
- אל תבדקו מובייל.
- `qa_probe` דסקטופ בנוסף, אינו תחליף לחוזה.
- סך `<details>` ב-`<main>` גדול מ-8 בגלל אקורדיון `.dd` של SECTION 05 — זה לא FAIL. סופרים רק `.ea-faq-item`.

## פלט חובה

שורה ראשונה בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`
אחר כך רשימת בדיקות קצרה עם CONFIRMED/FAIL + ציטוט ראיה.
ריק = FAIL.
