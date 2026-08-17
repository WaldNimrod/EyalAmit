# MANDATE — team_90 · Composer · R1-05 `/sound-healing/` content contract

**מאמת:** `composer-2.5` (Cursor) · **בנאי:** Cursor Grok 4.6 (הסשן הזה) · Iron Rule #1.
**היקף:** דסקטופ בלבד. מובייל = מחוץ להיקף.
**עמוד:** `http://eyalamit-co-il-2026.s887.upress.link/sound-healing/`
אין `?compare=eyal` בעמוד הזה.

TLS פג בכוונה — `curl -sk` מותר כאן בלבד. אסוף ראיות בעצמך. פלט ריק = FAIL. `-fast` אסור.

## ארבעת סעיפי החוזה (חובה)

1. **התאמת מקור** — כל מחרוזת תוכן חדשה חייבת להימצא במקור המצוטט. אחרת FAIL.
2. **האנק לא ממופה** — שינוי קוד שאינו ממופה לסעיף למטה → FAIL.
3. **Provenance** — מחרוזת שהשתנתה בלי הערת מקור בקוד → FAIL.
4. **פלט ריק = FAIL.**

**מקור הבייטים (SSOT, team_00 17.8.26):**
`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/סאונדהילינג/sound_healing_final.md`

אין קובץ `סקירה סאונד הילינג`. הכלל «אין הערה = מאושר» אינו חל. ה-md הוא הרצוי. הערות למתכנת = בלוקי DEV NOTES בתוך אותו md.

אל תאשרו מול `docs/project/eyal-ceo-submissions-and-responses/from-eyal/` (גיבוי בלבד).

## סעיפים ממופים (רק אלה מותרים ב-diff של ערכת הנושא)

- `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/sound-healing-defaults.php`
- `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` (דילוג ACF ל-`sound-healing`, C-13 — אותו ערוץ כתיבה כמו C-10…C-12)

`git diff --name-only HEAD` בתוך ערכת הנושא חייב להיות תת-קבוצה של הרשימה הזו.
קבצי טרקר / `_COMMUNICATION` / `scripts/` / `tmp/` אינם FAIL.

**אסור לגעת:** `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · defaults של עמוד אחר · `tpl-chapters-page.php`.

## מה לבדוק ב-HTML החי (דסקטופ, `<main>` בלבד)

1. H1 = `סאונד הילינג פרטי בדיג'רידו - מסע אישי בצליל ותדר ליחידים ולזוגות` בלי `<em>`. CTA הירו `לתיאום שיחת היכרות` → `/contact/`.
2. אין פסקת «המפגשים מתקיימים בסטודיו של אייל עמית בפרדס חנה» (הומצאה ב-SECTION 03).
3. אין `.bleed` · אין `.steps` · אין כותרת `מבנה המפגש`. «איך זה עובד?» הוא פרוזה, כולל «אוהל הטיפי» ו«כשעתיים».
4. אין `.rcard` / `.reveals`. אין כותרת `ועוד למי זה מתאים`. שמונה פסקאות SECTION 07 כולל קישור `/lessons/`.
5. אין `href` ל-`/eyal-amit/mokesh-dahiman/` ב-`<main>`. «מוקש דהימן» כטקסט. אין `/method-cbdidg`. `שיטת cbDIDG` → `/method/`.
6. אקורדיון FAQ: בדיוק 8 `<details class="ea-faq-item">` בתוך `.ea-faq-list` ב-`<main>` (SECTION 08). אל תספרו JSON-LD. אחריו קישור `דף השאלות הנפוצות המלא` → `/faq/`.
7. שמונה שמות ממליצים ייחודיים + 8 `href` Facebook מ-SECTION 09. קרין בעמוד הזה: `1TNJeTs7Mo`. קישור `לכל ההמלצות על אייל עמית` → `/testimonials/`.
8. CTA סיום: h2 `רוצים להגיע למפגש?` + כפתור `יצירת קשר` → `/contact/`. אין כפתור WhatsApp ב-`<main>`.

תמונות הירו/ספליט: נשארו קיימות; SH-01 ממתין לאייל — **לא FAIL**.
וידאו SECTION 05: לא רונדר; SH-02 ממתין לאייל — **לא FAIL**.

## מלכודות מדידה

- הקרוסלה עשויה לשכפל כרטיסים ב-DOM — סופרים שמות/`href` ייחודיים.
- `-k` רק מול הסטייג'ינג.
- אל תבדקו מובייל.
- `qa_probe` דסקטופ בנוסף, אינו תחליף לחוזה.

## פלט חובה

שורה ראשונה בדיוק אחת מ: `VERDICT: PASS` או `VERDICT: FAIL`
אחר כך רשימת בדיקות קצרה עם CONFIRMED/FAIL + ציטוט ראיה.
ריק = FAIL.
