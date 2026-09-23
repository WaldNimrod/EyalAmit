---
id: S007_ALIGN_CANON_AUDIT_2026-09-21
schema_version: aos_v1_team_messaging
type: AUDIT (team_100)
status: CDP live numbers — independent gpt-5.2 remeasure in parallel
date: 2026-09-21
viewport_primary: 1440×900
viewport_secondary: 390×844
staging: http://eyalamit-co-il-2026.s887.upress.link
raw: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/align-audit/raw.json
extra: file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/align-audit/extra.json
canon_page: /snoring-sleep-apnea/
---

# Align-canon audit — דום נשימה מול דפי דוגמה

מדידה חיה ב-CDP (chrome-headless-shell, UA דפדפן). curl לא נחשב ליישור.  
מנוע נפרד רץ במקביל: [gpt-5.2](f314cb25-ea19-4109-a0a7-302024a3fa02).

## 0. קאנון — מה שנמדד על `/snoring-sleep-apnea/` ב-1440

| פרמטר | חי | מקור CSS |
|---|---|---|
| `main` | 1440, max-width none (פס מלא) | `.chapters-main` |
| `.wrap` | **1200px**, `padding-inline: 48px`, x=120 | `chapters.css` :88 |
| תוכן פנימי ב-wrap | 1104px, מתחיל ב-x=168 | 1200−96 |
| `.intro-body` | **775.3px** (`max-width: 775.276px` = **82ch**), x=332.4 | :540 |
| H2 `.h2` על ה-wrap | **1104px**, `text-align: start`, x=168 | כותרת רחבה מהגוף |
| הסטת כותרת (RTL: הפרש קצה ימין H2 מול גוף) | **164.4px** | זו «ההסטה» |
| `.sec` padding | **88px** / 88px (`--sec` ceiling) | :48, :199 |
| שורת split | H2 וגוף **516px** באותו x — בלי הסטת 82ch | אטום שני, חוקי |
| CTA `.cta-band__in` | 1120px | :438 |
| H1 `.phero__h` | 786.6px = 32ch, start (ב-RTL יושב על הקצה הימני של ה-1104) | :397 |
| מובייל 390 | wrap=390, pad 48, H2=גוף=**294px**, offset **0**, pad `--sec` **40px** | 82ch לא נכנס |

פער אוויר סביב גוף 82ch בתוך wrap: (1104−775.3)/2 = **164.35px** לכל צד — זהה להסטת הכותרת.

## 1. משפחות מבנה (18 URL שנמדדו)

| משפחה | n | מה זה | דפים |
|---|---|---|---|
| **F-CHAP-82CH** | 8 | wrap 1200 + גוף 82ch ממורכז + H2 1104 start + sec 88 | `/snoring-sleep-apnea/` `/treatment/` `/method/` `/lessons/` `/eyal-amit/` `/about/` `/learning/` `/en/` |
| **F-HOME-HERO** | 1 | שורות F-CHAP-82CH, אבל הירו קולנועי ממורכז (לא phero 32ch start) | `/` |
| **F-CHAP-SPECIAL** | 4 | כרום Chapters, בלי עמודת 82ch (טופס / FAQ 820 / חנות / ארכיון בלוג) | `/contact/` `/faq/` `/shop/` `/blog/` |
| **F-QR-CHAP** | 1 | wrap 1200 + intro-body 82ch, בלי H2 בשורה הראשונה | `/qr/qr1/` |
| **F-BLOG-SINGLE** | 1 | `main` כלובי **960px** + גוף **66ch / 624px** | `/2228-2/` |
| **F-PRESS-W2** | 1 | `ea-wave2-editorial`, בלי `.wrap`, H1 596, סקשנים 1440 | `/press/` |
| **F-GP-NARROW** | 1 | `site-main` **820px**, בלי phero Chapters | `/historical-articles/` |

8/18 = **44%** במשפחת הקאנון המלאה.  
12/18 משתמשים בכרום Chapters (`chapters-main`).  
3/18 מחוץ ל-Chapters לגמרי או בכלוב זר (בלוג-יחיד, עיתונות, היסטורי-GP).

## 2. טבלת 1440 — מול הקאנון

Match = wrap 1200 ±1 **ו** גוף קריאה ≈775 ±4 **ו** H2 1104 עם offset ≈164 **על לפחות שורת prose אחת**.  
Split-half אינו חריגה — הוא אטום שני באותו עמוד קאנון.

| עמוד | משפחה | wrap | קריאה px | H2 px | offset | sec pad | match | חריגה מדויקת |
|---|---|---|---|---|---|---|---|---|
| `/snoring-sleep-apnea/` | F-CHAP-82CH | 1200 | 775.3 | 1104 | 164.4 | 88 | **כן** | בסיס. גם split 516 ו-CTA 1120 |
| `/treatment/` | F-CHAP-82CH | 1200 | 775.3 | 1104 | 164.4 | 88 | **כן** | שורת lead 60ch = **567.3** |
| `/method/` | F-CHAP-82CH | 1200 | 775.3 | 1104 | 164.4 | 88 | **כן** | שורת split 516 ראשונה במדגם |
| `/lessons/` | F-CHAP-82CH | 1200 | 775.3 | 1104 | 164.4 | 88 | **כן** | שורה 760px (לא 82ch) |
| `/eyal-amit/` `/about/` | F-CHAP-82CH | 1200 | 775.3 | 1104 | 164.4 | 88 | **כן** | |
| `/learning/` | F-CHAP-82CH | 1200 | 775.3 | 1104 | 164.4 | 88 | **כן** | photo-slot מלא-wrap |
| `/en/` | F-CHAP-82CH | 1200 | 775.3 | 1104 | 164.4 | 88 | **כן** | `text-align:left` במקום `start` — אותה גאומטריה LTR |
| `/` | F-HOME-HERO | 1200 | 775.3 | 1104 | 164.4 | 88 | שורות כן | **H1 ממורכז**, `max none`, x=361.8 w=716.5. pheroIn 796.5 לא 1200 |
| `/qr/qr1/` | F-QR-CHAP | 1200 | 775.3 | — | — | 88 | גוף כן | אין H2 בשורה הראשונה |
| `/contact/` | F-CHAP-SPECIAL | 1200 | — | יש | — | 88 | chrome | אין `.intro-body` |
| `/faq/` | F-CHAP-SPECIAL | **820** ברשימה | — | יש | — | — | **לא** | `.ea-faq-list` max **820px**; `wrapN=0` |
| `/shop/` | F-CHAP-SPECIAL | 1200 | — | יש | — | — | chrome | קטלוג, לא עמודת קריאה |
| `/blog/` | F-CHAP-SPECIAL | 1136 בתוך main 1200 | — | יש | — | 88 | **חלקי** | `main` max **1200px** — כובל את ה-phero |
| `/2228-2/` | F-BLOG-SINGLE | 896 בתוך main **960** | **624** (66ch) | 800 related | — | 88 | **לא** | ראו §4 |
| `/press/` | F-PRESS-W2 | אין wrap | — | — | — | — | **לא** | H1 596; סקשן 1440; CSS 65ch editorial |
| `/historical-articles/` | F-GP-NARROW | אין | — | — | — | — | **לא** | `main.site-main` **820px** |

## 3. סטטיסטיקת שורות (12 הסקשנים הראשונים לכל דף, דסקטופ, 15 דפים ב-raw)

n שורות במדגם = 103.

| סוג שורה | n | % | הערה |
|---|---|---|---|
| `prose-82ch-offset` (H2 1104 + גוף 775 + offset 164) | 49 | 47.6 | הקאנון |
| `h2-no-read` (כותרת בלי עמודת intro-body) | 22 | 21.4 | כרטיסים, FAQ, חנות, עיתונות |
| `other` (TOC / photo-slot / לא זוהה) | 13 | 12.6 | |
| `split-half` 516/516 | 6 | 5.8 | אטום חוקי מדום נשימה |
| `prose-82ch-no-h2` | 5 | 4.9 | משפט lead ממורכז |
| `cta-band` | 4 | 3.9 | |
| `prose-narrow-760` | 2 | 1.9 | חריגת מידה בתוך Chapters |
| lead **60ch / 567.3** | 2 | 1.9 | `.center .lead { max-width: 60ch }` |

על דפי F-CHAP-82CH, הקאנון 82ch+offset הוא הרוב. השורות שאינן 82ch הן split / CTA / 60ch lead / רשתות — לא באג מדידה.

## 4. חמש החריגות הכי חמורות (דיוק ממשק)

1. **פוסט בלוג יחיד** `/2228-2/`  
   `main.ea-wave2-blog-single` = **960px** (`--ea-prose-width`) + `padding 32px`.  
   `.ea-post-content` = **66ch / 624px**.  
   הירו עצמו כלוא ב-960 (לא פס 1440). H1 x=333 במקום 485.  
   מול קאנון: גוף **−151px**, מעטפת **−240px**, בלי הסטת H2 164.  
   זה המבנה שהסקיצה הקודמת חיקתה (כרטיס ~920).

2. **`/historical-articles/`** — `site-main` **820px**, בלי `.wrap` / `.phero`. משפחת GeneratePress. תוכן הארכיון הוזרק לתוך תבנית שלא שייכת לקאנון.

3. **`/press/`** — `ea-wave2-editorial`. אין `.wrap`. H1 596. ב-CSS נשאר `.ea-section-intro__body { max-width: 65ch }`.

4. **הירו הבית** — H1 ממורכז, `pheroIn` 796.5, לא 1200/32ch start. השורות מתחתיו כן קאנון. שני הירו באתר.

5. **`/faq/`** — רשימה `max-width: 820px`. אותו מספר כמו GP 820 — **מידה שלישית** לצד 1200 ו-82ch.  
   תוספת: **60ch lead** (567px) ו-**760px** ב-`/treatment/` `/lessons/` — מידות רביעית וחמישית בתוך Chapters.

## 5. מובייל 390

כל דפי F-CHAP-82CH זהים: inner **294px**, offset **0**, `--sec` **40px**, בלי overflow.  
הקאנון הדסקטופי (הסטת 164) **לא קיים במובייל** — אין מקום. זה אחיד, לא דריפט בין עמודים.  
`padding-inline: 48px` על 390 משאיר 294 לקריאה — נתון, לא הוכרע כאן.

דפי F-PRESS / F-GP / בלוג-ארכיון: בלי intro-body במדגם הראשון.

## 6. שאריות CSS (סטטי, לא חי)

| מידה | קבצים |
|---|---|
| `--ea-prose-width: 960px` | `ea-tokens.css` + `ea-blog.css` (7) + `ea-atoms.css` (17) + `w2-04/05/07/08/10/14e` |
| `65ch` | `ea-atoms.css` (3) `ea-blog.css` editorial `w2-14e` |
| `66ch` | `.ea-post-content` חי בפוסט |
| `82ch` | **רק** `chapters.css` `.prose` + `.intro-body` |
| `820px` | FAQ + gallery--doc + breakpoint bio |

שתי מערכות רוחב חיות במקביל: **Chapters 1200/82ch** ו-**Wave2 960/65–66ch**.

## 7. מה אחיד / מה לא — בלי המלצת מימוש

**אחיד היום** על עמודי הליבה של Chapters (טיפול, שיטה, שיעורים, אודות, לימוד, דום נשימה, EN):  
מעטפת 1200, גוף 82ch ממורכז, H2 על ה-wrap עם הסטה 164px, `--sec` 88/40, הירו פנימי 32ch start.

**לא אחיד, וזה מה שיש ליישר אם רוצים מערכת אחת:**

| נושא | מצב |
|---|---|
| פוסט בלוג | כלוב 960 + 66ch. שובר את הקאנון יותר מכל דף אחר במדגם |
| הירו בית מול הירו פנימי | ממורכז מול start-32ch |
| FAQ / מסמך-גלריה | 820 |
| עיתונות + כתבות היסטוריות | Wave2 / GP, לא Chapters |
| Lead ממורכז | 60ch ליד 82ch |
| Split | 516 — אטום שני, צריך להישאר מפורש ולא «חריגה» |

קובץ הגדרות לתבנית פוסט (טיוטה, ממתין לאישור אחרי הדיון הזה):  
[file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/POST-TEMPLATE-SETTINGS.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/POST-TEMPLATE-SETTINGS.md)

## 8. הכרעה מול מדידה עצמאית ([gpt-5.2](f314cb25-ea19-4109-a0a7-302024a3fa02))

דוח המאמת: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/ALIGN-CANON-AUDIT-2026-09-21.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/ALIGN-CANON-AUDIT-2026-09-21.md)

**מספרי הבסיס זהים בשני המנועים:** wrap 1200 / 82ch=775.3 / H2 1104 / הסטה 164.4 / `--sec` 88@1440 ו-40@390 / מובייל inner 294.

| טענת המאמת | הכרעה |
|---|---|
| `/method/` `/lessons/` = DEVIATE כי שורה 1 היא split 516 | **נדחה כסיווג עמוד.** אותה שורה קיימת גם בקאנון (דום נשימה שורה 3). שורות 2+ שם הן 82ch+164. עמוד קאנון עם אטום split, לא משפחה אחרת. |
| 5 החריגות הגרועות = contact/faq/shop/press/qr «ROWS MISSING» | **נדחה כחומרה.** זה פספוס סלקטור (אין זוג H2+`.intro-body`), לא הפער הוויזואלי הגדול. QR כן מציג intro-body 775.3 בלי H2. |
| פוסט בודד קריאה 380px | **חלקי.** 380 הוא כרטיס ב«פוסטים נוספים». גוף הפוסט עצמו: **624px / 66ch** בתוך `main` 960 (`/2228-2/`). |
| בית = MATCH | **שורות כן, הירו לא.** H1 ממורכז 716.5 מול phero 32ch start. |
| EN offset −164.4 | **לא חריגה.** LTR; הערך המוחלט 164.4. |
| ארכיון בלוג קריאה 320 | **לא עמודת קריאה.** זו כרטיסיה. החריגה האמיתית: `main` כלוא ב-1200, הירו 1136. |

שורד לשני המנועים בלי ויכוח: פוסט בלוג 960; היסטורי GP 820; עיתונות בלי wrap; FAQ/חנות/קשר בלי עמודת 82ch; שני הירו באתר.
