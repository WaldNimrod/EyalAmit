RECOMMEND: BUILD · ברור 3 · לא-ברור נימרוד 0 · לא-ברור אייל 2

# RESEARCH — R1-15 `/stand-floor/` · פאזה א׳ בלבד · 2026-08-18

**צוות:** 100 (S006 page researcher) · **לא בנאי · לא מאמת**
**סקואופ נעול:** `סקואופ אושר: R1-11, R1-12, R1-13, R1-14, R1-15 בלבד`
**עמוד:** R1-15 `/stand-floor/` בלבד · http://eyalamit-co-il-2026.s887.upress.link/stand-floor/
**דין:** אמנה §2 «אין סקירה» · §3א נעילת סיווג · §3ג · מנדט `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/MANDATE-R1-15-STAND-FLOOR-BUILD-2026-08-18.md`
**פאזה ב׳:** לא. אין `GO BUILD R1-15`. אפס עריכות PHP / xlsx / git / FTP / אחים.
**טרקר סעיפים:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/tracker/r1-15-items.json` · קידומת `FLR-`.

---

## 1. חומר

SSOT (ה-md הוא הרצוי; אין קובץ סקירה → «אין הערה = מאושר» **אינו חל**):

`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md`

| בדיקה | תוצאה |
|---|---|
| תיקיית `סטנד רצפתי לנגינה בישיבה נמוכה/` | **כן** — קובץ יחיד `stend for playing.md` (11 686 בתים, 10 סקשנים, 266 שורות) |
| `סקירה סטנד רצפתי` / כל «סקירה …» לעמוד | **אין.** |
| מדיה בתיקייה (jpg/png/mp4/שם קובץ) | **אין** |
| `from-eyal/` | **לא נפתח** (אמנה §2) |
| אח R1-14 | `stend for hanging.md` — מסמך אחר, **מחוץ לסקואופ** |
| כרטיס חנות R1-10 | הוסר ב-SHP-03 — **לא** מקור בייטים לעמוד הזה |

ערוץ כתיבה (פאזה ב׳ בלבד): `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/stand-floor-defaults.php`

שורת הטרקר הראשית: `WP-EI-01, WP-EI-02 (ON_HOLD)` — **נדחים** למחזור הזה. לא נפתחים.

---

## 2. חי מול md

**HTTP:** `curl -sk` → **200** · canonical `/stand-floor/` · `X-Robots-Tag: noindex, nofollow` (סטייג'ינג). TLS פג בכוונה.

**ערוץ החי:** `stand-floor-defaults.php`. גופי 02 / 04 / 05 / 06 / 07 **כן** במסמך. הכרום סביבם **לא**.

| בלוק חי (דסקטופ) | ב-defaults | במסמך |
|---|---|---|
| תג `סטנד רצפתי לדיג'רידו` | `phero.chap` | **אין** |
| H1 עם `<em>נמוכה</em>` | `phero.title` | H1 שורה 13 **בלי** em |
| תת = פסקת הפתיחה | `phero.sub` | שורה 15 (פסקה 1 מתוך 4) |
| מדיה `eyal-playing.jpg` בהירו + ב-split 02 | `phero.media` + `split.image` | DEV NOTES שורות 4, 37, 259–260 — **בלי קובץ** |
| CTA הירו `[ליצירת קשר](/contact/)` | `phero.cta_*` | שורה 22 — כן |
| H2 כפול «פתיחה» + אותו H1 שוב + 4 פסקאות | `sections[0]` prose | SECTION 01 הוא ההירו, לא סקשן שני |
| split «הבעיה» + אותה תמונה | `sections[1]` | כותרת+גוף 02 כן; תמונה בלי קובץ |
| 4 צעדים עם H3 שהומצאו + כפילות פרוזה («זה הכל.») | `steps` + prose | SECTION 03 הוא פרוזה, בלי כותרות-צעד |
| רשימות 04 / 05 / 07 | prose | **כן**, מילה-במילה |
| קישור `[טיפול בדיג'רידו](/didgeridoo-treatment/)` | SECTION 06 | שורה 166. חי: 301 → `/services/didgeridoo-treatment-breath/` → 301 → `/treatment/` (**200**) |
| `faqblock cats:stand-floor` — 4 שאלות, **סדר הפוך** | `faqblock` | SECTION 08 שורות 211–221, סדר המסמך |
| H2 `תמונות המוצר` + 2 כרטיסי pending | `gallery` pending | SECTION 10 = הערות למתכנת, **לא מוצג למשתמש**. גלריה «לא חובה» |
| H2 SECTION 09 + גוף מחובר לפסקה אחת | `product-cta` | שורות 238–245 — שתי פסקאות + כפתור מגע |
| `מחיר לפי התאמה` + `לרכישה מאובטחת` → `https://mrng.to/MTUiO3vkIg` (קישור חבילת הספרים) + «קישור רכישה זמני» | `gi_temp` + `chapters-commerce.php` | **אין** מחיר, **אין** רכישה, **אין** Morning |

**קישורי המסמך:** `/contact/` → **200**. `/didgeridoo-treatment/` → שרשרת 301 ל-`/treatment/` (**200**). DEV NOTES ב-04 («אפשר לשקול בהמשך» `/lessons`) **אינם** בייטים — לא מוסיפים.

**מחוץ לסקואופ:** `stands-storage-defaults.php` · `shop-defaults.php` · `didgeridoos-defaults.php` · `bags-defaults.php` · `repair-defaults.php` · `product-cta.php` · `chapters-commerce.php` · `chapters-render.php` · `block-faq-list.php` · תפריט/פוטר · meta/SEO (S007).

**מלכודת לבנאי:** לא להעתיק מ-`stands-storage-defaults.php` ולא מכרטיס שהוסר ב-`/shop/`. לא לגעת ב-`product-cta.php` — חלק משותף שמזריק GI/מחיר כשיש URL לסלאג.

---

## 3. סיווג (שער 2) — אמנה §3א

`ברור` רק אם (א) מקור מצוטט **ו** (ב) בייטים מילה-במילה **ו** (ג) פעולה אחת. אין סקירה → כל פער מול החי **בהיקף**. תוספת צוות שאינה במסמך יורדת עם ההדבקה. מדיה בלי קובץ = `לא ברור` לאייל.

| # | הסעיף | (א) | (ב) | (ג) | סיווג | סטטוס |
|---|---|---|---|---|---|---|
| FLR-01 | תמונות הירו + סקשן 02 | SECTION 01 שורה 4 · SECTION 02 שורה 37 · SECTION 10 שורות 259–260 | אין קובץ/קישור | בחירה | לא ברור | ממתין לאייל |
| FLR-02 | תמונות 03 / 04 / 06 + גלריה אופציונלית | SECTION 03 שורה 63 · SECTION 10 שורות 261–264 | אין קובץ | בחירה | לא ברור | ממתין לאייל |
| FLR-03 | סדר 01–07 + הירו בלי em + הסרת כרום שהומצא | SECTION 01–07 שורות 13–194 | כן, המסמך ככתבו | הדבקה אחת; תג/פתיחה/צעדים/גלריה pending יורדים | **ברור** | פתוח |
| FLR-04 | FAQ — 4 מהמסמך, `faq-inline` | SECTION 08 שורות 211–221 | 4 שאלות+תשובות ככתבן | החלפה, בלי `block-faq-list.php` | **ברור** | פתוח |
| FLR-05 | CTA מגע מ-SECTION 09, בלי רכישה/מחיר | SECTION 09 שורות 238–245 | H2 + שתי פסקאות + `[ליצירת קשר](/contact)` | `cta` (לא `product-cta`) | **ברור** | פתוח |

אין סעיפים לנימרוד. WP-EI-01/02 לא נפתחים — כרום ה-GI יורד כי אינו במסמך (תקדים BK-03).

קישור 06: טקסט `טיפול בדיג'רידו` ככתבו; href קנוני `/treatment/` (שרשרת 301 חיה, תקדים LSN-07). לא `/services/didgeridoo-treatment-breath/`.

---

## 4. פעולות הדבקה `ברור` (לשער 4, רק אחרי `GO BUILD R1-15`)

רק `stand-floor-defaults.php` (+ חלק חדש ייעודי לעמוד אם חייבים). Provenance על כל מחרוזת. אין תוכן = אין רכיב.

1. **FLR-03** — למחוק תג-פרק שהומצא, `<em>` ב-H1, סקשן «פתיחה» הכפול, בלוק `steps` עם H3 שהומצאו, וגלריית pending. להדביק SECTION 01–07 ככתבם, בסדר המסמך. H1 = `סטנד רצפתי לדיג'רידו לנגינה בישיבה נמוכה`. SECTION 03 פרוזה כולל «זה הכל.» — בלי כותרות-צעד. רשימות 04/05/07 ככתבן. `[טיפול בדיג'רידו](/treatment/)`. CTA הירו `[ליצירת קשר](/contact)`. SECTION 10 לא רונדר כסקשן משתמש.
2. **FLR-04** — ארבע השאלות בסדר המסמך כ-`faq-inline`. לא `faqblock` / CPT / `block-faq-list.php`.
3. **FLR-05** — בלוק `cta`: כותרת `רוצה לבדוק אם זה מתאים לך?` + שתי הפסקאות + `ליצירת קשר` → `/contact`. בלי מחיר, בלי `לרכישה מאובטחת`, בלי `mrng.to`, בלי WhatsApp, בלי pending GI. לא לגעת ב-`product-cta.php`.

מדיה (FLR-01/02) **לא** בבנייה עד בחירת אייל. לא ממציאים תמונת סטנד. לא ממציאים קישור רכישה.

---

## 5. מה לא נגענו בו

- PHP חי · xlsx · git · FTP · `tracker_page_tab.py`
- `stands-storage-defaults.php` `shop-defaults.php` `didgeridoos-defaults.php` `bags-defaults.php` `repair-defaults.php`
- `chapters-render.php` `tpl-chapters-page.php` `videoblk.php` `block-faq-list.php` `product-cta.php` `chapters-commerce.php` `inc/data/*.json`
- תפריט עליון / פוטר (קבצים משותפים) · מובייל (סבב 3) · meta/SEO (S007)
- סעיפי אייל ממתינים בעמודים אחרים
