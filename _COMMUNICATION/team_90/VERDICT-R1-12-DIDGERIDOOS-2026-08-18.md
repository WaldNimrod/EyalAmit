VERDICT: PASS

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-R1-12-DIDGERIDOOS-2026-08-18.md`  
**מאמת:** team_90 · composer-2.5 · **בנאי:** Cursor Grok 4.6 · Iron Rule #1  
**חי:** http://eyalamit-co-il-2026.s887.upress.link/didgeridoos/ · HTTP **200** (`curl -sk`, ~49 KB, 2026-08-18)  
**מקור SSOT:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/כלים למכירה/buy didgeridoo.md`  
**ראיות:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/r1-12-didgeridoos/`

---

## חוזה (קוד + מקור)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא: `didgeridoos-defaults.php` · `chapters-render.php` · `bags-defaults.php` · `repair-defaults.php` · `stands-storage-defaults.php` · `stand-floor-defaults.php` — כולם מותר במנדט (גל wave2 + didgeridoos). **לא** נגעו: `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `shop-defaults.php` · `tpl-chapters-page.php` |
| `shop-defaults.php` ללא שינוי | **CONFIRMED** | `git diff HEAD -- shop-defaults.php` → 0 שורות |
| Provenance | **CONFIRMED** | 52 הערות `/* S006 · מקור: content 13.8.26/כלים למכירה/buy didgeridoo.md · SECTION … */` ב-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/didgeridoos-defaults.php` |
| התאמת מקור | **CONFIRMED** | כותרות סעיפים · 5 שאלות FAQ · 4 CTA כפתורים · 3 ממליצים + Facebook href — תואמים `buy didgeridoo.md`; אין שאריות קטלוג (`מחיר לפי התאמה` · `mrng.to` · `pending`) ב-PHP או ב-`<main>` |
| ACF skip `didgeridoos` | **CONFIRMED** | `'didgeridoos'` (עם wave2 tools) ב-`in_array(...)` ב-`ea_chapters_phero_overlay()` + `ea_chapters_page_sections()` — `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` |

---

## HTML חי — `<main>` בלבד (`curl -sk`)

| # | בדיקה (מנדט) | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 = `כלי דיג'רידו למכירה - כלים בעבודת יד` בלי `<em>`; אין תג «כלים למכירה»; אין bleed; אין «מחיר לפי התאמה»; אין `mrng.to`; אין גלריית pending | **CONFIRMED** | H1×1: `כלי דיג'רידו למכירה - כלים בעבודת יד` (אין `<em>`). תג «כלים למכירה» · `מחיר לפי התאמה` · `mrng.to` · `pending` — **לא** ב-`<main>` |
| 2 | ארבעה CTA ל-`/contact/` ככתבם במסמך | **CONFIRMED** | 4 כפתורי `btn` ב-`<main>`: «לתיאום והתאמה אישית» · «לתיאום הגעה והתנסות בכלים» · «לבדיקת זמינות והתאמה» · «לתיאום הגעה ובחירת כלי» — כולם `href="/contact"` |
| 3 | בדיוק 5 `<details class="ea-faq-item">` ב-`.ea-faq-list` (faq-inline), סדר המסמך | **CONFIRMED** | `.ea-faq-list` ×1 ב-`<main>`; `ea-faq-item` ×5; סדר: ניסיון קודם → איזה כלי → מתחילים/מתקדמים → עבודה נשימתית → איך קונים |
| 4 | קישור `/instruments` ככתבו (301 מותר) | **CONFIRMED** | 2× `href="/instruments"` ב-«מוצרים משלימים»; `curl -skI /instruments` → **301** → `http://eyalamit-co-il-2026.s887.upress.link/tools-and-accessories/instruments/` |
| 5 | תמונות הירו/סדנה (DG-02/03) | **N/A (לא FAIL)** | ממתין לאייל — מפורש במנדט |

---

## `qa_probe` דסקטופ (ללא `-fast`)

```json
{ "verdict": "PASS", "failures": 0, "ts": "2026-08-18T00:45:36.850Z", "results": [
  { "viewport": "desktop", "page": "_didgeridoos_", "url": "/didgeridoos/",
    "scrollWidth": 1440, "clientWidth": 1440, "overflow": false,
    "forbiddenFound": [], "pass": true }
]}
```

נתיב: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/r1-12-didgeridoos/qa_probe_result.json`

---

## הערות מחוץ לחוזה (לא FAIL)

- שינויי `bags-defaults.php` / `repair-defaults.php` / `stands-storage-defaults.php` / `stand-floor-defaults.php` — גל wave2 מקביל (מותר במנדט).
- קישורי «עמוד יצירת קשר» בפרוזה/FAQ — במקור, לא CTA כפתור.
- `<title>` Yoast «כלי דיג'רידו למכירה - eyal amit» — מטא; לא בסעיף HTML המנדט.

---

## סיכום

חוזה R1-12 `/didgeridoos/` (מקור Drive · provenance · diff ממופה · ACF skip · HTML `<main>` · qa_probe דסקטופ) — **עומד**.
