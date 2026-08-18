VERDICT: PASS

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-R1-10-SHOP-2026-08-18.md`  
**מאמת:** team_90 · composer-2.5 · **בנאי:** Cursor Grok 4.6 · Iron Rule #1  
**חי:** http://eyalamit-co-il-2026.s887.upress.link/shop/ · HTTP **200** (`curl -sk`, 61113 bytes, 2026-08-18)  
**מקור SSOT:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/כלים למכירה/buy didgeridoo.md`  
**ראיות:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/r1-10-shop/`

---

## חוזה (קוד + מקור)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא: `shop-defaults.php` · `chapters-render.php` · `about-defaults.php` · `mokesh-defaults.php` · `muzza-defaults.php` — כולם מותר במנדט (גל מקביל + shop). **לא** נגעו: `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `didgeridoos-defaults.php` · `tpl-chapters-page.php` |
| Provenance | **CONFIRMED** | 53 הערות `/* S006 · מקור: content 13.8.26/כלים למכירה/buy didgeridoo.md · SECTION … */` ב-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/shop-defaults.php`; 0 מחרוזות תוכן בלי מקור בשדות `title`/`sub`/`body`/`q`/`a`/`cta_*` |
| התאמת מקור | **CONFIRMED** | 10 כותרות סעיפים · 5 שאלות FAQ · 4 CTA כפתורים · 3 ממליצים + 3 Facebook href — תואמים `buy didgeridoo.md`; אין שאריות קטלוג (`bookcard` · `כל המוצרים` · `מחיר לפי התאמה`) ב-PHP |
| ACF skip `shop` | **CONFIRMED** | `'shop'` (עם `muzza` / `about` / `mokesh`) ב-`in_array(...)` ב-`ea_chapters_phero_overlay()` + `ea_chapters_page_sections()` — `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` |

---

## HTML חי — `<main>` בלבד (`curl -sk`)

| # | בדיקה (מנדט) | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 = `כלי דיג'רידו למכירה - כלים בעבודת יד` בלי `<em>`; אין «חנות»; אין `bookcard`; אין «מחיר לפי התאמה»; אין כרטיס סטנד רצפתי | **CONFIRMED** | H1×1: `כלי דיג'רידו למכירה - כלים בעבודת יד` (אין `<em>`). `חנות` · `bookcard` · `מחיר לפי התאמה` · `סטנד רצפתי` — **לא** ב-`<main>` |
| 2 | ארבעה CTA ל-`/contact/` ככתבם במסמך | **CONFIRMED** | 4 כפתורי `btn` ב-`<main>`: «לתיאום והתאמה אישית» · «לתיאום הגעה והתנסות בכלים» · «לבדיקת זמינות והתאמה» · «לתיאום הגעה ובחירת כלי» — כולם `href="/contact"`. (קישורי «עמוד יצירת קשר» בפרוזה/FAQ — במקור, לא CTA כפתור) |
| 3 | בדיוק 5 `<details class="ea-faq-item">` ב-`.ea-faq-list` (faq-inline) | **CONFIRMED** | `.ea-faq-list` ×1 ב-`<main>`; `ea-faq-item` ×5 בתוך הרשימה |
| 4 | שלושה ממליצים + Facebook href מ-SECTION 09 | **CONFIRMED** | שירי אלקבץ · רותי שליט · אלון גרזון רז; `facebook.com/share/p/1E7ndvYyrp` · `facebook.com/share/p/19m2waNvQe` · `facebook.com/share/v/1Cky28MdtH` |
| 5 | תמונות הירו/סדנה (SHP-01/02) | **N/A (לא FAIL)** | ממתין לאייל — מפורש במנדט |

---

## `qa_probe` דסקטופ (ללא `-fast`)

```json
{ "verdict": "PASS", "failures": 0, "results": [
  { "viewport": "desktop", "page": "shop", "overflow": false,
    "forbiddenFound": [], "pass": true }
]}
```

`absent`: `חנות` · `bookcard` · `מחיר לפי התאמה` (סעיפי מנדט ל-`<main>`).  
נתיב: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/r1-10-shop/qa_probe_result.json`

---

## הערות מחוץ לחוזה (לא FAIL)

- **`סטנד רצפתי לנגינה`** ב-`section-nav` / topnav (מחוץ ל-`<main>`) — לא כרטיס מוצר; לא בסעיף 1 המנדט.
- `<title>` «עמוד קטלוג ראשי» — מטא WP ישנה; לא בסעיף HTML המנדט.
- שינויי `about-defaults.php` / `muzza-defaults.php` / `mokesh-defaults.php` — גל מקביל (מותר).
- GO-BUILD R1-10 אמר «לא לגעת ב chapters-render»; המנדט team_90 מפורשות מאשר `chapters-render.php` לדילוג ACF — המנדט המאמת הוא סמכות.

---

## סיכום

חוזה R1-10 `/shop/` (מקור Drive · provenance · diff ממופה · ACF skip · HTML `<main>` · qa_probe דסקטופ) — **עומד**.
