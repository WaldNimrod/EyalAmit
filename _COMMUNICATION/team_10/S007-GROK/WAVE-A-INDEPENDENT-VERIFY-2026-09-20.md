# גל א — מדידה עצמאית (מאמת, לא Composer)

**תאריך:** 2026-09-20  
**סטייג'ינג:** http://eyalamit-co-il-2026.s887.upress.link  
**תמה חיה:** 1.5.96  
**מנוע:** chrome-headless CDP · GET בלי follow-redirect  
**גלם:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-independent/result.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/wave-a-independent/result.json)

זה דוח המאמת. דוח התקיפה של Composer מאוחד בהמשך.

---

## חוזה גל א — PASS על משפחת Chapters

| סעיף | איפה | רזולוציה | תוצאה |
|---|---|---|---|
| 1 וורדמרק | `/` `.nav__wm` | 390, 768, 1920 | נראה. טקסט «המרכז לטיפול בדיג׳רידו» |
| 1 וורדמרק | `/` | 1280, 1440 | `display:none` — **מכוון** (1081–1499) |
| 6 פוטר | `/` `/contact/` `/shop/` `/privacy/` `/repair/` `/lessons/` | 390+1440 | בלוג דיג׳רידו, ספרים – מוזה הוצאה לאור, כלים `/shop/`, לימוד `/learning/` |
| 10 וואטסאפ | `/contact/` | 390+1440 | 1× `wa.me` נראה. float לא קיים |
| 15 תיקון L2 | כל עמודי Chapters שנבדקו | — | «תיקון וחידוש כלי דיג׳רידו» ב־DOM (ניווט) |
| 16 הירו | `/lessons/` | 390 | overlap **false**, gap **+16**, h1Top 88, navBottom 72 |
| 16 אחים | 19 עמודי `.phero--media` ב־390 | 390 | **אפס overlap**. כולל treatment, sound-healing, method, workshops, faq, privacy, terms, contact, about-canonical `/eyal-amit/`, mokesh |
| 7 עוגיות | `/` | 390 | דיאלוג נפתח, `gtag=function`, אחרי «הבנתי» `open:false` + localStorage=1 ולא חוזר |
| 7 פרטיות | `/privacy/` HTML | — | אין «אין באנר הסכמה נפרד» |

GET בלי follow: כל יעדי גל א = 200. `/tools-and-accessories/repair/` → 301 `/repair/`. `/about/moksha/` → 301 `/eyal-amit/mokesh-dahiman/`. `/workshops/` → 301 `/learning/workshops/`.

---

## אחים / פספוסים מחוץ ל־Chapters (לא שוברים את חוזה הגל על העמודים שתוקנו)

### P2 · וורדמרק חסר בדסקטופ במשפחת GP

- **עמודים:** `/about/` `/press/` (שניהם HTTP 200, תבנית `tpl-content` / GeneratePress). `/en/` (נחיתה אנגלית, בלי `.nav__wm`).
- **רזולוציה:** 390 ו־1440 — אין `.nav__wm` בכלל.
- **מה מפיל:** הוורדמרק הוזרק רק ל־`section-nav.php` (Chapters). GP header לא מקבל אותו. המגירה כן: `.ea-nd__brand` = «המרכז לטיפול בדיג׳רידו» (קיים, מוסתר עד פתיחה).
- **קנוני מקביל שעובד:** `/eyal-amit/` (Chapters) — וורדמרק חי.

### P2 · פוטר Wave2 על `/about/` `/press/`

- תווית הכלים עדיין מצביעה ל־`/tools-and-accessories` (301 ל־`/shop/`).
- ספרים בפוטר Wave2: «מוזה הוצאה לאור» — לא «ספרים – מוזה הוצאה לאור».
- תוכנית גל א נגעה במפורש ב־`section-footer.php` בלבד, עם סייג: Wave2 רק אם מדידה מראה שהוא חי. הוא חי כאן.

### P2 · `/en/` — שלושה `wa.me` נראים

- שני כפתורי «Talk on WhatsApp» + הצף. סעיף 10 היה רק `/contact/`. זה אח, לא הפרת החוזה.

### P3 · `/shop/` גוף העמוד

- כרטיס/lede עדיין «תיקון וחידוש כלים». הניווט L2 כבר «כלי דיג׳רידו». לא סעיף 15.

### P2 · overflow אופקי אחרי תיקון סעיף 16 (WAF-02, מאושר)

ב־390, כל `.phero--media`: `scrollWidth` 610 מול `clientWidth` 390. בית ו־`/repair/` (בלי הירו מדיה) נשארים 390.  
שורש: `.phero--media{overflow:visible}` + `.phero .arcs{left:-220px;width:620px}`.

### לא ממצא

- וורדמרק מוסתר ב־1440: מכוון, לא באג.
- L1 «ספרים» בסרגל: לא חלק מגל א (רק פוטר).
- באנר WP-EI-05 בעמודי המשפט: מחוץ להיקף.
