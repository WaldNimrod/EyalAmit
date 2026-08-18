VERDICT: PASS

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-R1-16-BOOKS-2026-08-18.md`
**מאמת:** `composer-2.5` (team_90) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/books/ · דסקטופ · `curl -sk` (55739 bytes, HTTP 200)

---

**חוזה (קוד + מקור)**

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff --name-only` בערכת הנושא: `muzza-defaults.php` + `chapters-render.php` (+ `about-defaults.php` / `shop-defaults.php` / `mokesh-defaults.php` — גל מקביל, מותר במנדט). **לא** נגעו: `template-books-hub.php` · `videoblk.php` · `block-faq-list.php` · ילדי ספרים (`kushi-blantis` / `tsva-bekahol` / `vekatavta` defaults) |
| Provenance | **CONFIRMED** | `grep` ב-`muzza-defaults.php`: כל 10 הסעיפים עם `/* S006 · מקור: content 13.8.26/מוזה הוצאה לאור - ספרים/MUZZA.md · SECTION … */`; BK-01/02/03 מתועדים; BK-04/05/06 מדיה — as-is (Eyal) |
| התאמת מקור | **CONFIRMED** | גופי תוכן, בלארבים, 150/~~207~~, שלושת ניסוחי CTA כרטיס, ו-`https://mrng.to/MTUiO3vkIg` תואמים `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/מוזה הוצאה לאור - ספרים/MUZZA.md` |
| ACF skip `muzza` | **CONFIRMED** | `chapters-render.php`: `'muzza'` (עם `shop` / `about` / `mokesh`) נוסף ל-`in_array(...)` ב-`phero overlay` + `page_sections` — מותר במנדט («דילוג ACF ל-`muzza`») |

**HTML חי — `<main>` בלבד** (`curl -sk`)

| # | בדיקה (מנדט) | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 `מוזה הוצאה לאור`; H2 רק מ-`### כותרת` | **CONFIRMED** | `<h1 class="phero__h">מוזה הוצאה לאור</h1>`; H2×3: «למה את הספרים של מוזה תמצאו כאן» · «חבילת 3 הספרים של אייל עמית» · «שלושה ספרים, שלושה עולמות». אין `<h2>הספרים של מוזה</h2>` · אין `<h2>סגירת עמוד</h2>` |
| 2 | CTA כרטיסים ככתבו; אין meta «2001 · מסעות» | **CONFIRMED** | `bookcard__cta`: «לעמוד הספר צבע בכחול וזרוק לים» · «לעמוד הספר כושי בלאנטיס» · «לעמוד הספר וכתבת». `grep` meta `2001 · מסעות` / `bookcard__meta` — 0 |
| 3 | כפתור אחד `לרכישת חבילת 3 הספרים` → Morning | **CONFIRMED** | `grep -c 'לרכישת חבילת 3 הספרים'` = 1; `href="https://mrng.to/MTUiO3vkIg"` ×1. אין `pending-note` · אין «ממתין לאישור» / «ממתין לקישור» |
| 4 | מדיה BK-04/05/06 | **N/A (לא FAIL)** | הירו + עטיפות קיימים; תמונת באנדל לא רונדרת — ממתין לאייל, מפורש במנדט |

**קישורים נוספים (מחוץ לסעיף 3, לא FAIL):** עוגן פנימי מ-SECTION 03 `href="#books-bundle">לרכישת חבילת הספרים` — במקור; נפרד מכפתור הרכישה החיצוני. נתיבי כרטיס: `/books/tsva-bekahol/` · `/books/kushi-blantis/` · `/books/vekatavta/`.

**`qa_probe` דסקטופ** (`qa_probe.mjs`, ללא `-fast`)

```json
{ "verdict": "PASS", "failures": 0, "results": [
  { "viewport": "desktop", "page": "_books_", "overflow": false, "forbiddenFound": [], "pass": true }
]}
```

נתיב: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/r1-16-books/qa_probe_result.json`

**הערות מחוץ לחוזה (לא FAIL):** `chapters-render.php` עודכן גם ל-`shop`/`about`/`mokesh` (גל מקביל). שינויי `_COMMUNICATION`/tracker — מחוץ להיקף PHP. TLS סטייג'ינג — צפוי.
