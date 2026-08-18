RECOMMEND: ASK_NIMROD · ברור 1 · לא-ברור נימרוד 1 · לא-ברור אייל 1

# RESEARCH — R1-25 `/faq/` · פאזה א׳ בלבד · 2026-08-18

**צוות:** 100 (S006 page researcher) · **לא בנאי · לא מאמת**
**סקואופ נעול:** `סקואופ אושר: R1-17, R1-18, R1-19, R1-25, R1-28 בלבד` + הקפאת `R1-07, R1-08, R1-09, R1-27`
**עמוד:** R1-25 `/faq/` בלבד · http://eyalamit-co-il-2026.s887.upress.link/faq/
**דין:** אמנה §2 «אין סקירה» · §3א נעילת סיווג · §3ג · מנדט `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/MANDATE-R1-25-FAQ-BUILD-2026-08-18.md`
**פאזה ב׳:** לא. אין `GO BUILD R1-25`. אפס עריכות PHP / xlsx / git / FTP / CPT / `inc/data/*.json`.

סעיפי טרקר: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/r1-25-items.json` · קידומת `FAQ-`.

**CPT מול md: לא תואם.** אקורדיון חי = 108 פריטי `ea_faq` (≈ `ea-faq-seed.json`). md = 52 שאלות. 15 התאמות Q+A מנורמלות; 30 אותה שאלה עם תשובה שונה; 7 שאלות md חסרות בחי; 64 שאלות חיות שאינן במסמך. בגלל הפער — `RECOMMEND` כולל `ASK_NIMROD` גם אם Hero/Intro ברורים.

---

## 1. חומר

SSOT (ה-md הוא הרצוי; אין קובץ סקירה → «אין הערה = מאושר» **אינו חל**):

`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/דף FAQ/FAQ FINAL.md`

| בדיקה | תוצאה |
|---|---|
| תיקיית `דף FAQ/` | **כן** — קובץ יחיד `FAQ FINAL.md` (22 854 בתים, SECTION 01–10) |
| `סקירה FAQ` ליד הסנכרון | **אין.** קובץ סקירה יחיד בחבילה: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/סקירה דף הבית.xlsx` |
| מדיה בתיקייה (jpg/png/mp4/שם קובץ) | **אין** |
| `from-eyal/` | **לא נפתח** (אמנה §2 / מנדט) |

ערוץ כתיבה חוקי (פאזה ב׳ בלבד, Hero+Intro בלבד): `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/faq-defaults.php`

**מלכודת CPT:** האקורדיון נמשך מ-`ea_faq` דרך `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-faq-list.php` (`faqblock` ב-defaults, בלי ארגומנט קטגוריה = כל הקורפוס). **אסור** לגעת ב-`block-faq-list.php` וב-`inc/data/*.json`. אין `faq-inline` במנדט לעמוד הזה. אל תבנו CPT.

---

## 2. חי מול md

**HTTP:** `curl -sk` → **200** · canonical `/faq/` · כותרת מסמך «שאלות נפוצות (FAQ) - eyal amit». TLS סטייג'ינג פג בכוונה. `X-Robots-Tag` / robots: `noindex, nofollow`. עימוד דסקטופ לא אומת ב-CDP — הרישום מה-HTML.

### Hero + Intro (ערוץ `faq-defaults.php`)

סדר המסמך: **01 הירו → 02 בלוק קישורים → 03–10 אקורדיון.** SECTION 01–02 הם היחידים שמותר להדביק ב-defaults אחרי GO.

| בלוק חי | ב-defaults | במסמך |
|---|---|---|
| תג `שאלות נפוצות` | `phero.chap` | אין תג-פרק ב-«התוכן» |
| H1 `שאלות <em>נפוצות</em>` | `phero.title` | אין H1 נפרד. שורה 18 מתחילה «שאלות נפוצות על…». `<em>` **אינו** במסמך |
| תת: שלושת משפטי 01 בשורה אחת | `phero.sub` | שורות 18–20 ככתבן (שני בלוקים; החי איחד) |
| CTA «שיחת היכרות» → `/contact/` | `phero.cta_*` | שורה 22 `[שיחת היכרות](/contact)` — תואם |
| הירו `studio-mosaic.jpg` · alt «הסטודיו בפרדס חנה — שאלות נפוצות» | `phero.media` | DEV NOTES שורות 14–15: overlay על תמונה, **בלי שם קובץ** |
| תג `לפני שמתחילים` + H2 `לא כל עבודה עם דיג׳רידו היא אותו דבר` | `sections[0]` prose chap/title | אין chap. שורות 43–44 הן גוף («👉 לפני שממשיכים…» + המשפט), לא H2 נפרד |
| גוף 02 + ארבעה `tlink` ל-`/treatment/` `/sound-healing/` `/lessons/` `/method/` | `sections[0]` body | שורות 43–51. קישורים כרשימה. href המסמך: `/didgeridoo-treatment` (לא `/treatment/`) + אותם שלושה |
| אקורדיון `faqblock` | `sections[1]` חלק `faqblock` args ריקים | SECTION 03–10 — 52 שאלות ב-7 קטגוריות md |

`curl -skI` ל-`/didgeridoo-treatment/` → **301** אל `/services/didgeridoo-treatment-breath/` (לא אל `/treatment/`). `/treatment/` עצמו **200**. הדבקת Intro = בייטי המסמך (`/didgeridoo-treatment`), לא המרה ל-`/treatment/` (המרה = בחירה, לא §3א). ממצא 301 ללייגסי — לידיעה, לא תוקן, לא נרשם ב-CODE-BLOCKED בפאזה א׳.

### אקורדיון CPT (חי) מול md מול seed (קריאה בלבד)

חי (HTML `.ea-faq-item__question`): **108** פריטים ב-13 נושאי TOC.

md SECTION 03–10: **52** שאלות ב-7 קטגוריות.

`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/data/ea-faq-seed.json`: **108** פריטים. אותם מפתחות-שאלה כמו בחי. 105 Q+A מנורמלים זהים; 3 התנגשויות מפתח/סחיפה (ראו למטה). **ה-seed אינו מקור בייטים לעמוד** — md הוא הרצוי.

| קטגוריה md (רצוי) | מס׳ | קטגוריה חיה (TOC) | מס׳ |
|---|---|---|---|
| טיפול בדיג'רידו (03) | 15 | treatment | 20 |
| שיעורי נגינה (04) | 8 | lessons | 8 |
| סאונד הילינג (05) | 8 | sound-healing | 8 |
| השיטה - cbDIDG (06) | 6 | method | 9 |
| שאלות כלליות (07+08) | 10 | general | 18 |
| ידע ורקע מקצועי (09) | 2 | *(נבלע ב-general / method)* | — |
| תוכן נוסף וספרים (10) | 3 | vekatavta 7 · kushi-blantis 6 · tsva-bekahol 5 | 18 |
| **אין במסמך** | 0 | didgeridoos 5 · bags 7 · stands-storage 5 · stand-floor 4 · repair 6 | 27 |

**ספירת התאמה (מפתח-שאלה מנורמל, תשובה בלי תגיות; URL הוסרו לצורך השוואת פרוזה):**

- Q+A מלא: **15** (6 שיעורים · 6 סאונד · «כמה זמן נמשך התהליך?» · «האם צריך לתרגל גם בין המפגשים?» · «איפה מתקיימים המפגשים?» — החי בלי «עמל 8 ב׳», כמו המסמך)
- אותה שאלה, תשובה שונה: **30** (ניסוח, משפטים עודפים, `ea-pending-approval`, או href)
- שאלות md שאין בחי (מפתח שונה): **7**
- שאלות חיות שאין במסמך: **64** (כולל מוצרים, שלושת הספרים, WP-S4-07 נחירות/CPAP/GEO, כפילויות ניסוח)

**7 שאלות md חסרות כמפתח בחי:**

1. איך נראה מפגש טיפולי? (שורה 83)
2. האם צריך ניסיון קודם בנגינה? (95) — החי: «האם צריך לדעת לנגן כדי להתחיל?»
3. למי טיפול בדיג'רידו יכול להתאים? (105)
4. מה ההבדל בין טיפול בדיג'רידו לסאונד הילינג? (117) — החי: «איך זה שונה מסאונד הילינג?»
5. מה הקשר בין הנגינה לנשימה היומיומית? (147) — החי: «מה הקשר בין דיג׳רידו לנשימה היומיומית?»
6. האם זה מתאים גם למי שלא "מחובר לעולם הזה"? (181) — החי בלי «האם»
7. האם השיטה יכולה לעזור לנחירות או דום נשימה? (418) — החי מוסיף «בשינה»

**דוגמאות תשובה-שונה (לא ממצה):** «מה זה בעצם טיפול בדיג'רידו?» — המסמך «תהליך אישי… נגינה…» + קישור בלוג ייצור; החי «נשימה יומיומית… תרגול…» בלי הקישור. «האם זה טיפול רפואי?» — המסמך מוסיף משפט סטרס; החי קיצור צוות. Method «כמה זמן לוקח לראות שינוי?» — המסמך משפט אחד; החי פסקאות ארוכות (גם כפילות עם טיפול). Rebirthing: החי עם `ea-pending-approval` + קישור `/blog/` במקום URL הבלוג במסמך. הכשרת מטפלים: במסמך `[קורס…](/cbDidg-therapy-training)`; החי טקסט בלי href.

**href במסמך מול חי (CPT בלבד — לא ערוץ defaults):**

| במסמך | `curl -skI` 2026-08-18 | חי ב-CPT |
|---|---|---|
| `/didgeridoo-treatment` | 301 → `/services/didgeridoo-treatment-breath/` | `/treatment/` |
| `/mokesh` | 301 → `/eyal-amit/mokesh-dahiman/` | `/eyal-amit/mokesh-dahiman/` |
| `/muse` | **404** | `/books/` |
| `/cbDidg-therapy-training` | **404** | אין href |
| `/blog/pregnancy-didgeridoo` | **404** | `/blog/` («קראו עוד») |
| ייצור `eyalamit.co.il/...` (כלים/תיקים/סטנדים/תיקון + שני פוסטי Blog) | לא נבדק כקנון סטייג'ינג | קנוני סטייג'ינג (`/didgeridoos/` `/bags/` וכו') |

**Seed מול חי (קריאה בלבד):** הקורפוס זהה במפתחות. סחיפה אחת ברורה ב-`general-01`: ה-seed עדיין «(עמל 8 ב')»; החי וה-md **בלי** הכתובת — CPT חי נערך אחרי ה-seed. שני מפתחות כפולים (`האם הסטנד מתאים לכל סוגי הדיג'רידו?` · `כמה זמן לוקח לקרוא את הספר?`) יוצרים התנגשות השוואה, לא בהכרח סחיפת תוכן.

**JSON-LD (Yoast):** 110 שאלות = 108 האקורדיון + 2 `PLACEHOLDER` («שאלת דוגמה (M3) — PLACEHOLDER R1/R2») שלא ב-HTML הנראה. שאריות CPT. לא נבנו ולא נמחקו.

**ממתיני-אישור חיים בגוף CPT:** CPAP (treatment) · בידול ריברסינג (method) · «כמה עולה טיפול / שיעור?» (general-18). אין במסמך FAQ FINAL. חלק מהפער, לא סעיף אייל נפרד כאן (אין ערוץ כתיבה).

**אין faq-inline במנדט.** תיקון הקורפוס ≠ Hero. אל תבנו CPT. אל תחליפו `faqblock` ב-inline בלי הכרעת נימרוד.

---

## 3. סיווג (שער 2) — אמנה §3א

`ברור` רק אם (א) מקור מצוטט **ו** (ב) בייטים מילה-במילה **ו** (ג) פעולה אחת. אין סקירה → כל פער מול החי **בהיקף**. מדיה בלי קובץ = `לא ברור` לאייל. פער Q&A ב-CPT = `לא ברור` לנימרוד (אין ערוץ כתיבה חוקי).

| # | הסעיף | (א) | (ב) | (ג) | סיווג | סטטוס |
|---|---|---|---|---|---|---|
| FAQ-01 | תמונת הירו | SECTION 01 DEV NOTES שורות 14–15 | אין קובץ/קישור | בחירה | לא ברור | ממתין לאייל |
| FAQ-02 | הירו + Intro — בלי em, בלי תג שהומצא, בייטי 01–02 | SECTION 01–02 שורות 18–22 · 43–51 | כן, המסמך ככתבו | הדבקה אחת ב-`faq-defaults.php` | **ברור** | פתוח |
| FAQ-03 | קורפוס האקורדיון 03–10 | SECTION 03–10 שורות 73–629 | 52≠108; רוב הנוסחים שונים | אין פעולה חוקית ב-defaults | לא ברור | ממתין להכרעת נימרוד |

אין סעיפי BUILD ל-CPT. Hero/Intro כן ניתנים להדבקה אחרי `GO BUILD R1-25` — **רק** FAQ-02, ורק אם נימרוד לא הקפיא את העמוד כולו ב-FAQ-03.

---

## 4. פעולות הדבקה `ברור` (לשער 4, רק אחרי `GO BUILD R1-25`)

1. **FAQ-02** — ב-`faq-defaults.php` בלבד: להוריד `<em>` מ-H1; להוריד תג-פרק הירו ותג «לפני שמתחילים». להדביק SECTION 01 שורות 18–20 כפרוזת ההירו + `[שיחת היכרות](/contact)`. להדביק SECTION 02 שורות 43–51 ככתבן (כולל 👉 אם בשורת המסמך; ארבעת הקישורים עם `/didgeridoo-treatment` ככתבו, לא המרה ל-`/treatment/`). לא לגעת ב-`faqblock`. Provenance על כל מחרוזת. **לא** לרוץ אם FAQ-03 ננעל כהקפאת עמוד.

מדיה (FAQ-01) ואקורדיון (FAQ-03) **לא** בבנייה עד הכרעה. לא ממציאים תמונה. לא כותבים seed JSON. לא WP-CLI migrate.

---

## 5. שאלות

**לאייל (אחת):** FAQ-01 — תמונת ההירו בלי קובץ במסמך. להשאיר / להחליף / בלי תמונה.

**לנימרוד (אחת, חוסמת את הקורפוס):** FAQ-03 — 108 בחי מול 52 במסמך. אין ערוץ כתיבה חוקי. לבחור: להשאיר אקורדיון ולהדביק רק הירו+פתיח · לפתוח ערוץ CPT בכתב · אחר.

---

## 6. מה לא נגענו בו

- PHP / FTP / git / xlsx / `tracker_page_tab.py` / `tracker_update.py`
- `block-faq-list.php` · `inc/data/ea-faq-seed.json` · כל `inc/data/*.json`
- `chapters-render.php` · `tpl-chapters-page.php` · `videoblk.php` · defaults של אחים
- wp-admin · ACF · WP-CLI migrate · יצירת `faq-inline` בעמוד `/faq/`
- R1-07/08/09 (הוקפאו) · LSN-09 (404 הריון ב-R1-04) · תפריט/פוטר · מובייל · meta/SEO (S007)
- `docs/project/eyal-ceo-submissions-and-responses/from-eyal/` (לא נפתח)
