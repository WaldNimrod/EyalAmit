# MANDATE — team_90 · Composer · S006 WAIT-WAVE W3 · בסיס דסקטופ + תיקונים מותרים

**מאמת:** `composer-2.5` · **בנאי:** Cursor Grok 4.6 · Iron Rule #1.
דסקטופ. פלט ריק = FAIL. `-fast` אסור. **אל תשנה קבצים** מלבד קובץ הפסק שלך.

שורה ראשונה: `VERDICT: PASS` או `VERDICT: FAIL`

כתוב אל: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-S006-WAIT-WAVE-W3-2026-08-18.md`

בסיס: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/wait-wave-opt-baseline/`
רישום דחייה: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/OPT-R3-REGISTER.md`

קבצים **מותרים** לתיקון בגל (רק אם ממצא חי בהם): `home-front.css`, `testimonials-carousel.css`, `books-v2.css`, `faq-toc.css`, `w2-05-shop.css`, `w2-14e-catalog.css`, ו-JS ייעודי (`ea-testimonials.js`, `ea-mokesh.js`, `ea-faq-toc.js`, `books-reveal.js`). אסור: `chapters.css`, `ea-tokens.css`, `ea-atoms.css`, `ea-mobile-*.css`, nav/footer, `*-defaults.php`.

## חוזה

1. **`git diff` ריק** על `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/` — אפס שינוי טקסט עמוד.

2. **qa_probe דסקטופ 21/21** — קראו `qa_probe_result.json`: `total=21`, `failures=0`, `overflow=false` לכל שורה. אם צריך שחזור: `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` עם `tmp/qa/cdp/wait-wave-opt-baseline/config.json` (desktop 1440×900 בלבד). אל תריצו מובייל.

3. **מפת ממצא→קובץ.** כל ממצא בבסיס (overflow / קונסולה / netfail / hex) ממופה או לתיקון בקובץ ייעודי **או** לשורה ב-OPT-R3. הבנאי טוען: 0 תיקוני CSS/JS כי אין פגם פונקציונלי בקובץ מותר. אשרו או הפילו:
   - `console-harvest.json`: 0 `consoleErrors` ב-21 עמודים.
   - `netfail-urls.json`: הביטול המשותף הוא GA `g/collect`; עודפי מוקש הם YouTube-nocookie — לא קובץ ייעודי.
   - hex בקבצים ייעודיים בלי overflow/console = OPT-R3-03, לא חובת תיקון בגל.

4. **Lighthouse דסקטופ** קיים כארטיפקט תחת `lighthouse/` (מדגם ≥3 עמודים). ציוני סטייג'ינג (noindex/SEO נמוך, בלי CDN) **אינם FAIL**.

5. **אין כרום משותף ב-diff של הגל.** `git diff -- site/wp-content/themes/ea-eyalamit/assets/css/chapters.css site/wp-content/themes/ea-eyalamit/assets/css/ea-mobile-nav.css site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css` ריק.

## אסור לפסול בגלל

- C-07/C-08, FAQ 404, Lorem H-06, H1 `<em>`.
- מובייל לא נמדד (OPT-R3-05).
- ציוני SEO בסטייג'ינג.

## פלט

טבלה: בדיקה · סיווג · תוצאה · ראיה (`file://` או פלט git/qa_probe).
אל תתקנו CSS.
