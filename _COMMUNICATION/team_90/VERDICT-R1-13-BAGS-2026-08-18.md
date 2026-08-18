VERDICT: PASS

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-R1-13-BAGS-2026-08-18.md`  
**מאמת:** team_90 · composer-2.5 (Lens A) · **בנאי:** Cursor Grok 4.6 · Iron Rule #1  
**חי:** http://eyalamit-co-il-2026.s887.upress.link/bags/ · HTTP **200** (`curl -sk`, 55471 bytes, 2026-08-18)  
**מקור SSOT:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/תיקים לדיג_רידו/bags for didg.md`  
**ראיות:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/cdp/r1-13-bags/`

---

## חוזה (קוד + מקור)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא: `bags-defaults.php` · `chapters-render.php` · `repair-defaults.php` · `didgeridoos-defaults.php` · `stands-storage-defaults.php` · `stand-floor-defaults.php` — כולם מותר במנדט (גל wave2 + bags). **לא** נגעו: `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `shop-defaults.php` · `tpl-chapters-page.php` |
| Provenance | **CONFIRMED** | 47 הערות `/* S006 · מקור: content 13.8.26/תיקים לדיג_רידו/bags for didg.md · SECTION … */` ב-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/bags-defaults.php`; כל שדות `title`/`sub`/`body`/`q`/`a`/`cta_*` מהמקור מסומנים. bleed BAG-05 — `/* BAG-05 KEEP */` (מותר; לא מחרוזת חדשה מהמקור) |
| התאמת מקור | **CONFIRMED** | 10 סעיפי תוכן · 7 שאלות FAQ · 2 CTA כפתורים — תואמים `bags for didg.md` (סדר מסמך); קישור שיעורים ב-PHP/HTML: `/lessons/` (קנוני, לא `/didgeridoо-lessons` מהערת DEV במקור) |
| ACF skip `bags` | **CONFIRMED** | `'bags'` (עם wave2 tools) ב-`in_array(...)` ב-`ea_chapters_phero_overlay()` + `ea_chapters_page_sections()` — `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` |

---

## HTML חי — `<main>` בלבד (`curl -sk`)

| # | בדיקה (מנדט) | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 = `תיקים לדיג'רידו` בלי `<em>`; אין תג-פרק; אין «מחיר לפי התאמה»; אין `mrng.to` / `product-cta` | **CONFIRMED** | H1×1: `תיקים לדיג'רידו` (אין `<em>`). `chap` · `מחיר לפי התאמה` · `mrng.to` · `product-cta` — **לא** ב-`<main>` |
| 2 | CTA `לתיאום והתאמה של תיק לדיג'רידו` → `/contact/` | **CONFIRMED** | 2 כפתורי `btn` ב-`<main>` (phero + cta-band): טקסט תואם; `href="/contact"` ×4 (כולל קישורי FAQ) |
| 3 | בדיוק 7 `<details class="ea-faq-item">` ב-`.ea-faq-list` (faq-inline), סדר המסמך; `/lessons/` קנוני | **CONFIRMED** | `.ea-faq-list` ×1; `ea-faq-item` ×7; סדר: כל תיק→מגן→הזמנה→בתחילת הדרך→אחסון→כבס→מחיר. `href="/lessons/"` ×1 ב-FAQ (לא `/didgeridoо-lessons`) |
| 4 | Bleed BAG-05 | **N/A (לא FAIL)** | `class="bleed"` קיים — ממתין לאייל; מפורש במנדט |
| 5 | אין גלריית pending ריקה; תמונות BAG-03/04 | **CONFIRMED / N/A** | אין `pending` גלריה ב-`<main>`; אין מדיה חדשה שהומצאה — לא FAIL |

---

## `qa_probe` דסקטופ (ללא `-fast`)

```json
{ "verdict": "PASS", "failures": 0, "ts": "2026-08-18T00:45:37.303Z",
  "results": [
    { "viewport": "desktop", "page": "_bags_", "overflow": false,
      "forbiddenFound": [], "pass": true, "scrollWidth": 1440, "clientWidth": 1440 }
  ]}
```

פקודה: `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /bags/`

---

## הערות מחוץ לחוזה (לא FAIL)

- Yoast JSON-LD (מחוץ ל-`<main>`) עדיין מציין `/didgeridoо-lessons/` — לא בסעיף HTML המנדט; HTML ב-`<main>` משתמש ב-`/lessons/`.
- שינויי `repair-defaults.php` / `didgeridoos-defaults.php` / `stands-storage-defaults.php` / `stand-floor-defaults.php` — גל wave2 מקביל (מותר).
- `git diff` כולל tracker CSV — לא קוד תמה; לא unmapped theme.

---

## סיכום

חוזה R1-13 `/bags/` (מקור Drive · provenance · diff ממופה · ACF skip · HTML `<main>` · qa_probe דסקטופ) — **עומד**.
