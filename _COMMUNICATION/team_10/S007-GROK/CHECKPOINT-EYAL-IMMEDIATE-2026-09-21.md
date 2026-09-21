# צ'קפוינט — חבילת מיידי מאייל · 2026-09-21

**סטטוס:** GATE OPEN. ATTACK נחת 2026-09-21. בסיס GET+CDP נכתב.

בסיס GET: [`tmp/qa/eyal-immediate-baseline/get-baseline.json`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/eyal-immediate-baseline/get-baseline.json)  
בסיס CDP: [`tmp/qa/eyal-immediate-baseline/cdp-baseline.json`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/eyal-immediate-baseline/cdp-baseline.json)

לפני המימוש (נמדד): `/` Lorem+pending; `/didgeridoos/` 200; `/thank-you/` 200 placeholder; משפטי pending; P016/P045 עדיין 200; `/books/kushi-blantis/` 200; תמה 1.5.99.

## נקודת שחזור

| שדה | ערך |
|-----|------|
| HEAD | `20361b1d6b1de5f2423dc575b81cdf7d1f4ccb60` |
| הודעה | `docs: Wave B tint as-made commit hash` |
| תמה חיה | **1.5.99** ב־[`style.css`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/style.css) |
| סטייג'ינג | http://eyalamit-co-il-2026.s887.upress.link (HTTP; TLS לא תקין בכוונה) |
| איחוד אייל | [`WORKING-UNION-FROM-C.json`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/WORKING-UNION-FROM-C.json) sha12 `469b376e6ee9` |
| גלריה | [`GALLERY.html`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/content-gaps-2026-09-21/GALLERY.html) |

**Rollback:** `git revert` לחתימה הזו + FTP של תמה 1.5.99. בלי `git add -A`. בלי `local/`. בלי `_aos/`.

## חרגה — תפריט

לא לגעת ב־`inc/ea-canonical-nav.php`, `inc/ea-nav-drawer.php`, `template-parts/chapters/section-nav.php`, `template-parts/blocks/block-topnav.php`, `assets/js/ea-canonical-nav-gp-dropdown.js`. T1/T2/T3/E2/E7/A5-תפריט מחוץ למנדט.

## בסיס CDP

תיקייה: `tmp/qa/eyal-immediate-baseline/` (לא Git).

**לא לצלם כל עוד ביקורת העומק רצה.** אחרי נחיתת ATTACK, לפני הקוד הראשון: CDP 390 ו־1440 + GET בלי follow + `style.css?ver=` על:

- `/`
- `/didgeridoos/`
- `/thank-you/`
- `/faq/`
- `/learning/therapist-training/`
- `/accessibility/`
- `/privacy/`
- `/terms/`
- `/method/`
- `/blog/`
- `/סיפורים-מהנייר-עם-אייל-עמית/` (P016)
- `/41-הטור-של-אייל-עמית-חארטה-בארטה/` (P045)
- `/מורה-לדיגרידו-מודה-למוריו-תלמידיו-ומט/` (P002)
- `/נשים-מנגנות-בדיגרידו-אישה-מנגנת-בדיג/` (P008)
- `/34-הטור-של-אייל-עמית-הלב/` (P048)
- `/books/kushi-blantis/`

רגרסיית תפריט: לספור 10 כפתורי L1 בדסקטופ (בלי בית/לוגו) — חייב להישאר 10 אחרי המימוש.

## טבלת קבלה מול אייל (רק מיידי)

PASS רק אם תואם `choice`/`note` ב־C, לא «נראה בסדר».

| id | בחירת אייל | הצלחה | URL |
|----|------------|--------|-----|
| A4 | להשתמש ואשלח נוסח | שתי השורות «תודה שפנית אליי» / «הפרטים התקבלו…». טופס מפנה לכאן. לא בתפריט. | `/thank-you/` |
| B1 | אשלח קישור | iframe `youtube.com/embed/wDQoJauqsRM`. אין lorem / «ממתין לאישור» בפרק 03. | `/` |
| C2 | מאשר כמו שהוא | אין שינוי נוסח. | `/learning/therapist-training/` |
| D1 | להסיר את הסקשן | אין קרוסלת המלצות ואין CTA «לכל העדויות» ב־`/didgeridoos/`. | `/didgeridoos/` |
| D2 | להשאיר 15 | 15 המלצות בדף הבית. אין פעולה. | `/` |
| D3 | אשלח כתובת | FAQ «הכשרת מטפלים» → `/learning/therapist-training/` (יחסי, לא דומיין סטייג'ינג). לא `/cbDidg-therapy-training`. | `/faq/` |
| F3 | אסתמה | אין `אסטמה` בברירות תמה חיות. לא נוגעים בציטוטי לקוחות / asthma. | `/` `/method/` |
| L1 | אושר | אין `pending-note` / «ממתין לאישור» בנגישות. | `/accessibility/` |
| L2 | אושר ולהשאיר מדידה | אין באנר טיוטה. CMP + GA4 נשארים. | `/privacy/` |
| L3 | אושר | אין באנר טיוטה. | `/terms/` |
| P016 | מחיקה (הערה) | GET בלי follow = 301 אל `/blog/` (או 410). לא 200 תוכן. | slug למעלה |
| P045 | תסיר את הפוסט | כנ״ל | slug למעלה |
| P002 | יש הערה | הירו מהמקור + hrefs לאתר החדש. מדיה מהמקור בלבד. | slug למעלה |
| P006 | יש הערה | הירו מהמקור + hrefs. | `/ריברסינג-נשימה-מעגלית-דיגרידו/` (ומה שנשאר ב־JSON) |
| P008 | יש הערה | הירו + תמונות נשים מהמקור + נקודות בודדות הוסרו. לא מחיקת פוסט. | slug למעלה |
| P048 | יש הערה | הירו + קישור ל־`/books/kushi-blantis/`. אם 404 — `/books/` + חריג במנדט. לא slug עברי. | slug למעלה |

## קבצים מותרים אחרי פתיחת השער (צוות 10)

- `site/wp-content/themes/ea-eyalamit/style.css` (bump אחרי קריאה, 1.5.99 → הבא)
- `template-parts/chapters/section-home-03-video.php`
- `inc/chapters/defaults/home-defaults.php`
- `inc/chapters/defaults/didgeridoos-defaults.php`
- `inc/chapters/defaults/method-defaults.php`
- `inc/chapters/defaults/accessibility-defaults.php`
- `inc/chapters/defaults/privacy-defaults.php`
- `inc/chapters/defaults/terms-defaults.php`
- `inc/wave2-stage-b.php` (רק שורת אסטמה אם חיה)
- `inc/data/ea-faq-seed.json`
- mu-plugin once חדש לדחיפת FAQ `general-12` (דפוס Wave B)
- מיפוי `/thank-you/` לתבנית פרקים פשוטה + ברירות (אין היום ב־`chapters-routing`)
- תוכן WP: שני פוסטים + ארבעה חריגי בלוג + 301; הפניית טופס לתודה

**אסור:** `--fs-*`, תפריט קנוני, `/en/` נוסח, באנר הטיוטה של EN, גלריות, באצ׳ 54+48 הירו, מחיקת `/services/`, 301 `/about/`.

## מנועים

- בונה: צוות 10 Composer, אחרי ATTACK + צילומי בסיס.
- מאמת: הסשן הזה (לא הבונה). ארטיפקט: `EYAL-IMMEDIATE-VERIFY-2026-09-21.md`.
