VERDICT: PASS

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-R1-15-STAND-FLOOR-2026-08-18.md`  
**מאמת:** team_90 · composer-2.5 (Composer lens A) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1  
**חי:** http://eyalamit-co-il-2026.s887.upress.link/stand-floor/ · HTTP **200** (`curl -sk`, 57353 bytes, 2026-08-18)  
**מקור SSOT:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md`  
**ראיות:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/r1-15-stand-floor/`

---

## חוזה (קוד + מקור)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא: `stand-floor-defaults.php` · `chapters-render.php` · `repair-defaults.php` · `didgeridoos-defaults.php` · `bags-defaults.php` · `stands-storage-defaults.php` — כולם מותר במנדט. **לא** נגעו: `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `shop-defaults.php` · `tpl-chapters-page.php` · `product-cta.php` |
| Provenance | **CONFIRMED** | 39 הערות `/* S006 · מקור: content 13.8.26/סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md · SECTION … */` ב-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/stand-floor-defaults.php` |
| התאמת מקור | **CONFIRMED** | כותרות SECTION 01–09 · ארבעת FAQ · CTA · גוף פרוזה — תואמים `stend for playing.md`. קישור SECTION 06: מימוש קנוני `/treatment/` (מנדט), לא `/didgeridoo-treatment` מה-md |
| ACF skip `stand-floor` | **CONFIRMED** | `'stand-floor'` ב-`in_array(...)` ב-`ea_chapters_phero_overlay()` + `ea_chapters_page_sections()` — `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` שורות 603 · 645 |

---

## HTML חי — `<main>` בלבד (`curl -sk`)

| # | בדיקה (מנדט) | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 = `סטנד רצפתי לדיג'רידו לנגינה בישיבה נמוכה` בלי `<em>`; אין תג-פרק; אין «מחיר לפי התאמה»; אין `mrng.to`; אין גלריית pending; אין H3-צעדים שהומצאו; SECTION 03 כולל «זה הכל.» | **CONFIRMED** | H1×1 ללא `<em>`. `מחיר לפי התאמה` · `mrng.to` · `pending` · `gallery` · `<h3` — **לא** ב-`<main>`. פסקה «זה הכל.» בSECTION 03 |
| 2 | CTA הירו `ליצירת קשר` → `/contact/`; כותרת תחתונה `רוצה לבדוק אם זה מתאים לך?` | **CONFIRMED** | `phero__cta` → `href="/contact"` · `ליצירת קשר`. H2 `רוצה לבדוק אם זה מתאים לך?` לפני `cta-band` |
| 3 | בדיוק 4 `<details class="ea-faq-item">` ב-`.ea-faq-list` (faq-inline), סדר המסמך | **CONFIRMED** | `.ea-faq-list` ×1 ב-`<main>`; `ea-faq-item` ×4. סדר: מתאים לכל סוגי → הרכיב/כוון → תחזוקה → עיצוב אישי |
| 4 | קישור `טיפול בדיג'רידו` → `/treatment/` (קנוני) | **CONFIRMED** | `<a class="tlink" href="/treatment/">טיפול בדיג'רידו</a>` בSECTION 06 |
| 5 | אין GI; SECTION 10 לא מוצג; מדיה FLR-01/02 | **CONFIRMED** | אין `product-cta` · אין `gi_temp` · אין `mrng.to`. אין תמונות/גלריה ב-`<main>`. SECTION 10 (הערות מתכנת) לא בחי — **N/A (לא FAIL)** |

---

## `qa_probe` דסקטופ (ללא `-fast`)

```json
{ "verdict": "PASS", "failures": 0, "results": [
  { "viewport": "desktop", "page": "_stand_floor_", "url": "/stand-floor/",
    "overflow": false, "forbiddenFound": [], "pass": true }
]}
```

נתיב: `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/r1-15-stand-floor/qa_probe_result.json` · ts `2026-08-18T00:45:54.378Z`

---

## קישורים קנוניים

| URL | סטטוס |
|-----|--------|
| `/contact/` | **200** |
| `/treatment/` | **200** |

---

## סיכום

חוזה R1-15 `/stand-floor/` (מקור Drive · provenance · diff ממופה · ACF skip · HTML `<main>` · qa_probe דסקטופ · בלי GI) — **עומד**.
