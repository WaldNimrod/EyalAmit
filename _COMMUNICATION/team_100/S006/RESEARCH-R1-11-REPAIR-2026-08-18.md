RECOMMEND: BUILD · ברור 2 · לא-ברור נימרוד 0 · לא-ברור אייל 2

# RESEARCH — R1-11 `/repair/` · פאזה א׳ בלבד · 2026-08-18

**צוות:** 100 (S006 page researcher) · **לא בנאי · לא מאמת**
**סקואופ נעול:** `סקואופ אושר: R1-11, R1-12, R1-13, R1-14, R1-15 בלבד`
**עמוד:** R1-11 `/repair/` בלבד · http://eyalamit-co-il-2026.s887.upress.link/repair/
**דין:** אמנה §2 «אין סקירה» · §3א נעילת סיווג · §3ג · מנדט `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/MANDATE-R1-11-REPAIR-BUILD-2026-08-18.md`
**פאזה ב׳:** לא. אין `GO BUILD R1-11`. אפס עריכות PHP / xlsx / git / FTP / אחים.

סעיפי טרקר: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/r1-11-items.json` · קידומת `REP-`.

---

## 1. חומר

SSOT (ה-md הוא הרצוי; אין קובץ סקירה → «אין הערה = מאושר» **אינו חל**):

`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/תיקון כלי דיג_רידו/build didg.md`

| בדיקה | תוצאה |
|---|---|
| תיקיית `תיקון כלי דיג_רידו/` | **כן** — קובץ יחיד `build didg.md` (15 016 בתים, 10 סקשנים) |
| `סקירה תיקון` ליד הסנכרון | **אין.** קובץ סקירה יחיד בחבילה: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/סקירה דף הבית.xlsx` |
| מדיה בתיקייה (jpg/png/mp4/קישור קובץ) | **אין** |
| DEV NOTES | בתוך אותו md (לא קובץ נפרד) |
| `from-eyal/` | **לא נפתח** (אמנה §2) |
| `WP-EI-01` / `WP-EI-02` | ON_HOLD — **נדחים** למחזור הזה (מנדט) |

ערוץ כתיבה (פאזה ב׳ בלבד): `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/repair-defaults.php`

**אחים בגל (לא לגעת):** `didgeridoos-defaults.php` · `bags-defaults.php` · `stands-storage-defaults.php` · `stand-floor-defaults.php` · `shop-defaults.php`.

---

## 2. חי מול md

**HTTP:** `curl -sk` → **200** · canonical `/repair/` · כותרת מסמך «תיקון וחידוש דיג'רידו». TLS סטייג'ינג פג בכוונה. `X-Robots-Tag: noindex, nofollow`.

**ערוץ החי = defaults.** רוב גופי 01–04 / 08 קיימים, עם כרום צוות, סדר שגוי, ותוספות שאינן במסמך.

סדר המסמך (רצוי): **01 הירו → 02 מתי → 03 תהליך → 04 למה כאן → 05 FAQ → 06 המלצות (ריק) → 07 CTA → 08 סוגי תיקונים.** SECTION 09 = DEV NOTES לעמוד (לא תוכן אתר). SECTION 10 = QA checklist למתכנת (לא תוכן אתר).

סדר החי: 01 → 02 → 03 → 04 → **08 לפני 05** → 07 → גלריה ממתינה → product-cta.

| בלוק חי (דסקטופ) | ב-defaults | במסמך |
|---|---|---|
| תג `תיקון כלי דיג'רידו` | `phero.chap` | כותרת-סקשן בלבד, לא ב-«התוכן» |
| H1 `תיקון וחידוש <em>דיג'רידו</em>` | `phero.title` | H1 בלי em: `תיקון וחידוש דיג'רידו` (שורה 24) |
| תת מקוצר (בלי «המשפיעות על הצליל…») | `phero.sub` | פסקת הפתיחה המלאה שורות 26–27 |
| הירו `eyal-workshop.jpg` | `phero.media` | DEV NOTES שורות 12–19 מבקשים צילום כלי/תהליך/בית מלאכה **בלי קובץ** |
| H2 כפול «תיקון וחידוש דיג'רידו» + chap «פתיחה» | `sections[0]` | H1 פעם אחת. אין chap |
| פסקת «הרקע שלו כמהנדס אלקטרוניקה…» | `sections[0]` body | **אין** במסמך — תוספת צוות |
| רשימת 02 (9 פריטים) | `sections[1]` | תואם שורות 67–75. חסר CTA שורה 80 |
| שלבי 03 (1–5) | `steps` | תואם. חסר «כך נראה התהליך:» (שורה 104) ו-CTA |
| `.reveals` + 5 תמונות אתר | `reveals` | רשימה כתובה שורות 156–169. אייקונים אופציונליים בלי קובץ. **אין** תמונות |
| 08 כ-`mag` + כיתוב «עבודת תיקון.» + `didg-spiral-detail.jpg` | `mag` | רשימה שורות 327–362. הכיתוב הומצא. הסדר החי: 08 לפני FAQ |
| FAQ CPT `faqblock cats:repair` (סדר אחר) | `faqblock` | 6 שאלות SECTION 05 שורות 205–240, בסדר המסמך, + CTA |
| 07 כותרת+גוף בלי כפתור | prose | + `[לתיאום בדיקה לכלי](/contact)` שורה 302 |
| `גלריית מוצר` / «ממתין לאישור» ×2 | `gallery` pending | **אין** במסמך |
| `product-cta`: «מחיר לפי התאמה» · «לרכישה מאובטחת» → `https://mrng.to/MTUiO3vkIg` (חבילת ספרים) · קופסת GI | `product-cta` + `chapters-commerce.php` | **אין.** CTA היחיד במסמך: `/contact` |
| SECTION 06 המלצות | **אין** (נכון: בלוק ריק) | כותרת שורה 264 + TODO בלי ציטוטים. DEV NOTES: לא פעיל עד המלצות אמיתיות |

**קישורי המסמך שנבדקו חי:** `/contact/` `/method/` `/tools-and-accessories/` — כולם **200**. הבייטים הם `/tools-and-accessories` — הדבקה מילה-במילה, בלי המרה ל-`/shop/` (המרה = המצאה).

**מחוץ לסקואופ:** defaults של אחים · `chapters-render.php` / `videoblk.php` / `block-faq-list.php` / `inc/data/*.json` · `/tools-and-accessories/repair/` (R2-026) · תפריט משותף · meta/SEO (S007) · `WP-EI-01/02`.

**מלכודת לבנאי:** לא לגעת ב-`ea-faq-seed.json` ולא ב-`block-faq-list.php`. לא להעתיק `product-cta` מ-`didgeridoos-defaults.php`. לא לרנדר SECTION 09–10 (DEV NOTES / QA).

---

## 3. סיווג (שער 2) — אמנה §3א

`ברור` רק אם (א) מקור מצוטט **ו** (ב) בייטים מילה-במילה **ו** (ג) פעולה אחת. אין סקירה → כל פער מול החי **בהיקף**. תוספת צוות שאינה במסמך יורדת עם ההדבקה (כמו גריד `bookcard` ב-R1-10). מדיה בלי קובץ = `לא ברור` לאייל. «מעל שני עשורים» / «מוקש דהימן» — **במסמך** (SECTION 01 שורות 32–33) → מותר להדביק.

| # | הסעיף | (א) | (ב) | (ג) | סיווג | סטטוס |
|---|---|---|---|---|---|---|
| REP-01 | תמונת הירו (+ צילומי בית מלאכה ש-DEV NOTES מבקשים בלי קובץ) | SECTION 01 שורות 12–19 · SECTION 07 שורה 288 · SECTION 09 שורות 373–377 | אין קובץ/קישור | בחירה | לא ברור | ממתין לאייל |
| REP-02 | המלצות תיקון | SECTION 06 שורות 248–276 | אין ציטוטים — רק TODO | בחירה/מילוי | לא ברור | ממתין לאייל |
| REP-03 | סדר 01–04+07–08 + הירו בלי em + הסרת כרום צוות | SECTION 01–04 · 07–08 (שורות 24–177, 294–364) | כן, המסמך ככתבו | הדבקה אחת במקום הכרום | **ברור** | פתוח |
| REP-04 | FAQ — 6 מהמסמך, `faq-inline`, סדר המסמך | SECTION 05 שורות 205–244 | 6 שאלות ככתבן | החלפה, בלי `block-faq-list.php` | **ברור** | פתוח |

DEV NOTE שורה 254–258 («בלוק לא פעיל עד הוספת המלצות אמיתיות») + TODO שורות 267–276 אינם בייטים חלופיים. לא ממציאים המלצות. לא משאילים מטיפול/שיעורים/סאונד. אין תוכן = אין רכיב.

אייקונים אופציונליים ב-02/04/08 בלי קובץ — לא נוספים (אין תוכן = אין רכיב). לא נפתח סעיף.

אין סעיפים לנימרוד. הסרת `.reveals` / `mag` / גלריה ממתינה / `product-cta` (מחיר + קישור Morning לספרים + GI) היא חלק מ-REP-03: תוספת צוות שאינה במסמך, לא בלוק מאושר של אייל.

---

## 4. פעולות הדבקה `ברור` (לשער 4, רק אחרי `GO BUILD R1-11`)

1. **REP-03** — למחוק כרום שהומצא: `<em>` ב-H1 · תג-פרק · H2 כפול «פתיחה» · פסקת המהנדס · `.reveals` + חמש תמונות האתר · `mag` + כיתוב «עבודת תיקון.» · גלריית «תמונות המוצר» הממתינה · `product-cta` (מחיר לפי התאמה / לרכישה מאובטחת / `mrng.to` / GI). להדביק SECTION 01–04 ו-07–08 ככתבם, **בסדר המסמך** (08 אחרי 07, לא לפני FAQ). H1 = `תיקון וחידוש דיג'רידו` **בלי** `<em>`. רשימות 02 ו-04 כרשימה כתובה (לא `.reveals`). שלבי 03 כולל «כך נראה התהליך:». סוגי 08 כרשימה (לא `mag`). CTA `[לתיאום בדיקה לכלי](/contact)` אחרי 01, 02, 03, 04, 07, 08 ככתבם. קישורי גוף: `/contact` `/method` ככתבם. Provenance על כל מחרוזת.
2. **REP-04** — שש שאלות SECTION 05 כ-`faq-inline` **בסדר המסמך** (זמן → האם כל כלי → צליל → מחיר → הצעת מחיר → שדרוג). קישור `[כלים ואביזרים לדיג'רידו](/tools-and-accessories)` ככתבו. CTA ל-`/contact`. לא `faqblock` / CPT / `block-faq-list.php` / `inc/data/*.json`.

מדיה (REP-01) והמלצות (REP-02) **לא** בבנייה עד בחירת אייל. לא ממציאים מחיר/כפתור רכישה. לא פותחים `WP-EI-01/02`.

בנייה: רק `repair-defaults.php` (+ חלק חדש ייעודי לעמוד אם חייבים). לא לגעת באחים.

---

## 5. שאלות לנימרוד

**אין.**

---

## 6. מה לא נגענו בו

- PHP / FTP / git / xlsx / `tracker_page_tab.py` / `tracker_update.py`
- `didgeridoos-defaults.php` `bags-defaults.php` `stands-storage-defaults.php` `stand-floor-defaults.php` `shop-defaults.php`
- `chapters-render.php` `tpl-chapters-page.php` `videoblk.php` `block-faq-list.php` `product-cta.php` `chapters-commerce.php` `inc/data/*.json`
- R2-026 `/tools-and-accessories/repair/` · תפריט/פוטר משותפים · מובייל (סבב 3) · meta/SEO (S007)
- סעיפי אייל ממתינים בעמודים אחרים (כולל SHP-01/02)
