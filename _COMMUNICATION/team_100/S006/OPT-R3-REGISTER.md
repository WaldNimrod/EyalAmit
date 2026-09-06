# OPT-R3 REGISTER — S006 WAIT-WAVE

רישום ממצאי אופטימיזציה שנמדדו בגל WAIT-WAVE (18.8.26) **ולא תוקנו**, כי הם דורשים כרום משותף, מובייל, או שינוי ויזואלי בלי פגם פונקציונלי ממופה.

**נעילת הגל:** מדידה דסקטופ + תיקון רק בקבצי CSS/JS ייעודיים לעמוד, ורק אם הממצא חי בהם. אפס נגיעה ב-`chapters.css` / `ea-tokens.css` / `ea-atoms.css` / `style.css` (מעבר ל-`Version` אחרי פריסת נכס) / `ea-mobile-*.css` / תפריט / פוטר.

**מסקנת WAIT-WAVE W3:** אפס תיקוני CSS/JS ייעודיים. overflow 21/21 נקי. `console.error` 0/21. כל מה למטה = סבב 3.

בסיס: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/wait-wave-opt-baseline/`

| # | ממצא | למה לא עכשיו | יעד סבב 3 |
|---|---|---|---|
| OPT-R3-01 | `net::ERR_ABORTED` Fetch ב-21/21 עמודים | Headless Chrome מבטל `google-analytics.com/g/collect` (G-MRXESK7QJF). לא `console.error`. לא קובץ ייעודי. | מדיניות אנליטיקס בסטייג'ינג / חסימת headless — לא תיקון עמוד |
| OPT-R3-02 | 4–5 ביטולי רשת נוספים ב-`/eyal-amit/mokesh-dahiman/` | YouTube-nocookie (`timedtext` / `qoe` / `ptracking` / `playback`) על הטמעת `kf4NKSdYi9E`. MK-03/05 ממתינים לאייל. | מובייל + מדיניות הטמעות אחרי תשובת אייל |
| OPT-R3-03 | צבעים מקודדים קשיח ב-`home-front.css` / `books-v2.css` / `faq-toc.css` | אין overflow ואין שגיאת קונסולה ממופה. החלפת hex→token תשנה מראה בזמן שאייל סוקר. | יישור ל-`ea-tokens.css` בסבב 3 |
| OPT-R3-04 | כרום משותף (`chapters.css`, nav, footer, `ea-mobile-*`) | נעול מחוץ לגל. רוב 21 העמודים רצים עליו. | סבב 3 = מובייל + קבצים משותפים |
| OPT-R3-05 | viewport מובייל | אמנה: סבב 1–2 דסקטופ בלבד. | qa_probe מובייל + תיקוני `ea-mobile-*` |
| OPT-R3-06 | ציוני Lighthouse בסטייג'ינג | noindex + בלי CDN. ארטיפקט, לא כשל. | מדידה מחדש על דומיין הייצור |
| A11Y-R3-01 | ניגודיות / טוקנים / כרום משותף / מובייל | סבבים 1–2 דסקטופ; נגישות מבנית = A11Y-NOW | ביקורת ת״י 5568 AA — [PLAN-S006-A11Y-DEPTH-NOW-AND-R3-2026-08-26.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/PLAN-S006-A11Y-DEPTH-NOW-AND-R3-2026-08-26.md) |
| A11Y-R3-02 | מדיניות כתוביות / הטמעות YouTube | 35ד לא חל אוטומטית; MK ממתינים לאייל | סבב 3 + נוסח בהצהרה |
| A11Y-R3-03 | הצהרה סופית + ייצור 404 | HOLD הדבקה W4 | אחרי GO נימרוד + אישור אייל |
| A11Y-R3-05 | מקלדת מלאה + קורא מסך + qa_probe מובייל | לא חתימת AA בסבב 2 | צוות 50 — BRIEF-S006-A11Y-R3-AUDIT |

## מפת ממצא → קובץ (W3)

| ממצא בבסיס | קובץ מותר לתיקון בגל? | פעולה |
|---|---|---|
| overflow false × 21 | — | אין תיקון |
| `console.error` 0 × 21 | — | אין תיקון |
| GA collect aborted × 21 | לא (אנליטיקס משותף) | OPT-R3-01 |
| YouTube telemetry × mokesh | לא (הטמעה ממתינה לאייל) | OPT-R3-02 |
| hex ב-`home-front.css` / `books-v2.css` / `faq-toc.css` | מותר טכנית, אין פגם פונקציונלי | OPT-R3-03 |
| mask `#000` ב-`testimonials-carousel.css` | מותר טכנית; mask לא token | OPT-R3-03 (ליווי) |
| `w2-05-shop.css` / `w2-14e-catalog.css` | אין hex פגם | אין תיקון |
| JS ייעודי (`ea-testimonials.js`, `ea-mokesh.js`, `ea-faq-toc.js`, `books-reveal.js`) | 0 שגיאות ששוחזרו | אין תיקון |

`git diff` על `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/` — ריק בגל הזה.
