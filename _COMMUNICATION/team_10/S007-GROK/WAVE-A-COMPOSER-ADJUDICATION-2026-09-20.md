# גל א — אישורר / הפרכה לדוח Composer · 2026-09-20

**תוקף:** [Composer](bcc2d043-50ca-45b8-860b-d3aa2074643d)  
**מאמת:** קו הבנייה (מנוע אחר) · CDP נפרד 39 דגימות + ציד overflow  
**דוח התוקף:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-A-COMPOSER-ATTACK-2026-09-20.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/WAVE-A-COMPOSER-ATTACK-2026-09-20.md)

חוזה גל א על משפחת Chapters **עומד**. אין P0. אין לפתוח גל ב בגלל זה.

---

## שלושת ה-MISS של Composer

| id | Composer אמר | הכרעה | חומרה אחרי אימות |
|---|---|---|---|
| **WAF-01** `/shop/` «תיקון וחידוש כלים» בגוף | P1, סעיף 15 | **מאושר כעובדה, מופרך כהפרת חוזה 15.** סעיף 15 היה L2 בניווט בלבד — שם התווית החדשה חיה. בכרטיס/lede של החנות נשאר הנוסח הישן (`shop-defaults.php`). | P2 תוכן אח, לא nav |
| **WAF-02** overflow אופקי 610px ב־390 על `.phero--media` | P2 similar | **מאושר, ועם שורש.** לא מגירה. `.phero--media{overflow:visible}` (תיקון סעיף 16) משחרר את `.phero .arcs` (`left:-220px; width:620px`) → `scrollWidth` 610. בית/`/repair/` בלי phero-media נשארים 390. אפשר לגלול הצידה במובייל. | P2 רגרסיה מגל א · תיקון קטן: `overflow-x: clip` על ההירו |
| **WAF-03** `/en/` 3× `wa.me` | P2 similar | **מאושר כעובדה, מופרך כהפרת סעיף 10.** סעיף 10 היה רק `/contact/` — שם 1× וואטסאפ, בלי צף. באנגלית: שני CTA + צף. | P2 אח · לא גל א |

---

## חשוד של Composer

| id | Composer | הכרעה |
|---|---|---|
| **WAF-S01** מחזור עוגיות לא הושלם אצלם | חשוד | **מופרך כפער.** מאמת: אחרי «הבנתי» `open:false`, `localStorage=1`, טעינה חוזרת לא פותחת, `gtag` נשאר function. |
| **WAF-S02** קרוסלת עדויות בבית | רעש | **מאושר כרעש.** `scrollWidth` של המסילה ארוך בכוונה; qa_probe בבית 390 = 390/390. |

Pass שלהם על סעיפים 1, 6, 10, 15-nav, 16-overlap, 7-presence, הסתרת וורדמרק ב־1440 — **מאושרים**.

---

## מה Composer פספס (המאמת מצא)

| id | עמוד | רזולוציה | מה |
|---|---|---|---|
| **WAF-V01** | `/about/` `/press/` | 390 ו־1440 | אין `.nav__wm`. תבנית GP/`tpl-content`, לא Chapters. המגירה כן נושאת «המרכז לטיפול בדיג׳רידו». הקנוני `/eyal-amit/` תקין. |
| **WAF-V02** | אותם עמודים | פוטר Wave2 חי | «כלים ואביזרים» → `/tools-and-accessories` (301 ל־`/shop/`). ספרים = «מוזה הוצאה לאור» לא «ספרים – מוזה הוצאה לאור». גל א נגע רק ב־`section-footer.php`. |

---

## מה כן / מה לא עכשיו

- **לא חוסם את אישור גל א** על העמודים שתוקנו.
- **כן שווה תיקון קטן אם נימרוד רוצה עכשיו:** WAF-02 (`overflow-x: clip` על `.phero--media`, בלי לגעת בריווח האנכי של סעיף 16).
- WAF-01 / WAF-03 / WAF-V01 / WAF-V02 — תור נפרד (תוכן חנות, EN, משפחת GP), לא גל א.
