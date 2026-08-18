VERDICT: PASS

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-R1-11-REPAIR-2026-08-18.md`
**מאמת:** `composer-2.5` (team_90) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1
**עמוד:** http://eyalamit-co-il-2026.s887.upress.link/repair/ · דסקטופ · `curl -sk` (63229 bytes, HTTP 200)

---

**חוזה (קוד + מקור)**

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא: `repair-defaults.php` + `chapters-render.php` + אחי גל (`didgeridoos-defaults.php` · `bags-defaults.php` · `stands-storage-defaults.php` · `stand-floor-defaults.php` — מותר). **לא** נגעו: `shop-defaults.php` · `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `tpl-chapters-page.php` |
| Provenance | **CONFIRMED** | `grep` ב-`repair-defaults.php`: 54 הערות `/* S006 · מקור: content 13.8.26/תיקון כלי דיג_רידו/build didg.md · SECTION … */` על כל שדות תוכן |
| התאמת מקור | **CONFIRMED** | גוף, כותרות, FAQ (6), קישור `[כלים ואביזרים לדיג'רידו](/tools-and-accessories)`, CTA `לתיאום בדיקה לכלי` → `/contact` תואמים `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/תיקון כלי דיג_רידו/build didg.md`. הוסר פסקת «מהנדס אלקטרוניקה» שלא במקור |
| ACF skip `repair` | **CONFIRMED** | `chapters-render.php`: `'repair'` (עם ילדי גל 2) נוסף ל-`in_array(...)` ב-`phero overlay` + `page_sections` |

**HTML חי — `<main id="chapters-main">`**

| # | בדיקה (מנדט) | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 `תיקון וחידוש דיג'רידו` בלי `<em>`; בלי תג-פרק; בלי «מהנדס אלקטרוניקה»; בלי «מחיר לפי התאמה»; בלי `mrng.to`; בלי גלריית «ממתין לאישור» | **CONFIRMED** | `<h1 class="phero__h">תיקון וחידוש דיג'רידו</h1>`; `grep` על HTML מלא — 0 התאמות אסורות; אין `gallery` / `pending` / `product-cta` ב-main |
| 2 | CTA `לתיאום בדיקה לכלי` → `/contact` | **CONFIRMED** | `grep -c 'לתיאום בדיקה לכלי'` = 7 (הירו + 6 `cta-band` אחרי סקשנים); כל `href="/contact"` |
| 3 | בדיוק 6 `<details class="ea-faq-item">` בסדר המסמך | **CONFIRMED** | `grep -c '<details class="ea-faq-item'` = 6; סדר: זמן → כל כלי → צליל → מחיר → הצעת מחיר → שדרוג |
| 4 | קישור `כלים ואביזרים לדיג'רידו` → `/tools-and-accessories` (לא `/shop/`) | **CONFIRMED** | `<a class="tlink" href="/tools-and-accessories">כלים ואביזרים לדיג'רידו</a>` ב-FAQ «האם כל דיג'רידו» |
| 5 | אין בלוק המלצות (REP-02) | **CONFIRMED** | אין `מה אומרים` / carousel המלצות ב-main; SECTION 06 לא רונדר (כמצופה) |
| 6 | תמונת הירו חדשה (REP-01) | **N/A (לא FAIL)** | אין מדיה הירו חדשה — ממתין לאייל, מפורש במנדט |

**`qa_probe` דסקטופ** (`qa_probe.mjs`, ללא `-fast`)

```json
{ "verdict": "PASS", "failures": 0, "ts": "2026-08-18T00:45:36.983Z",
  "results": [
    { "viewport": "desktop", "page": "_repair_", "overflow": false, "forbiddenFound": [], "pass": true }
]}
```

**הערות מחוץ לחוזה (לא FAIL):** `chapters-render.php` עודכן גם ל-ילדי גל 2 (מותר). שינויי `_COMMUNICATION`/tracker — מחוץ להיקף PHP. `ea-testimonials-carousel-css` נטען גלובלית מהתמה — לא בלוק תוכן ב-main. TLS סטייג'ינג — צפוי.
