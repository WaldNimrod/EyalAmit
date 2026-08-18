VERDICT: PASS

**מנדט:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/MANDATE-R1-14-STANDS-STORAGE-2026-08-18.md`  
**מאמת:** team_90 · composer-2.5 · **בנאי:** Cursor Grok 4.6 · Iron Rule #1  
**חי:** http://eyalamit-co-il-2026.s887.upress.link/stands-storage/ · HTTP **200** (`curl -sk`, ~60 KB, 2026-08-18)  
**מקור SSOT:** `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/EyalAmit_Site_GoogleDrive_Sync/content 13.8.26/סטנדים לדיג_רידו לאחסון/stend for hanging.md`  
**לא מעורב:** `/stand-floor/` · `stend for playing.md`

---

## חוזה (קוד + מקור)

| בדיקה | תוצאה | ראיה |
|--------|--------|------|
| Diff ממופה בלבד | **CONFIRMED** | `git diff --name-only HEAD` בערכת הנושא: `stands-storage-defaults.php` · `chapters-render.php` · `repair-defaults.php` · `didgeridoos-defaults.php` · `bags-defaults.php` · `stand-floor-defaults.php` — כולם מותר במנדט (R1-14 + גל מקביל). **לא** נגעו: `videoblk.php` · `block-faq-list.php` · `inc/data/*.json` · `shop-defaults.php` · `tpl-chapters-page.php` |
| Provenance | **CONFIRMED** | 44 הערות `/* S006 · מקור: content 13.8.26/סטנדים לדיג_רידו לאחסון/stend for hanging.md · SECTION … */` ב-`file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/stands-storage-defaults.php`; כל שדות `title`/`sub`/`body`/`q`/`a`/`cta_*` מסומנים |
| התאמת מקור | **CONFIRMED** | 10 סעיפי תוכן (01–10) + 5 שאלות FAQ + 2 CTA — תואמים `stend for hanging.md`; אין תוכן מ-`stend for playing.md` |
| ACF skip `stands-storage` | **CONFIRMED** | `'stands-storage'` (עם `stand-floor` / `bags` / `repair` וכו') ב-`in_array(...)` ב-`ea_chapters_phero_overlay()` + `ea_chapters_page_sections()` — `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php` |

---

## HTML חי — `<main>` בלבד (`curl -sk`)

| # | בדיקה (מנדט) | תוצאה | ראיה |
|---|--------|--------|------|
| 1 | H1 = `סטנדים לאחסון דיג'רידו` בלי `<em>`; תת `לתלייה או בעמידה`; אין «מחיר לפי התאמה»; אין `mrng.to`; אין bleed+ייחוס; אין גלריית pending; אין `.reveals` | **CONFIRMED** | H1×1: `סטנדים לאחסון דיג'רידו` (אין `<em>`). `phero__s` מתחיל ב-`לתלייה או בעמידה`. אסורים — **לא** ב-`<main>` |
| 2 | CTA `לתיאום והזמנה` → `/contact/` | **CONFIRMED** | 2 כפתורים ב-`<main>`: `phero__cta` + `cta-band` — שניהם `לתיאום והזמנה` · `href="/contact"` |
| 3 | בדיוק 5 `<details class="ea-faq-item">` ב-`.ea-faq-list` (faq-inline), סדר המסמך | **CONFIRMED** | `.ea-faq-list` ×1; `ea-faq-item` ×5. סדר: התאמה לכל סוגים → תלייה/עמידה → שמירה על הכלי → התאמה אישית → הצעת מחיר |
| 4 | שני סוגי אחסון: תלייה על הקיר + עמידה על הרצפה (אחסון, לא נגינה) | **CONFIRMED** | סעיף «סוגי סטנדים»: `סטנד לתלייה על הקיר` · `סטנד לעמידה על הרצפה`; אין תוכן נגינה ב-`<main>` |
| 5 | תמונות STN-01/02 | **N/A (לא FAIL)** | אין מדיה חדשה ב-`<main>` — ממתין לאייל, מפורש במנדט |

---

## `qa_probe` דסקטופ (ללא `-fast`)

```bash
node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs \
  --base http://eyalamit-co-il-2026.s887.upress.link --paths /stands-storage/
```

```json
{ "verdict": "PASS", "failures": 0, "results": [
  { "viewport": "desktop", "page": "_stands_storage_", "url": "/stands-storage/",
    "overflow": false, "forbiddenFound": [], "pass": true }
]}
```

`ts`: 2026-08-18T00:45:45.466Z

---

## הערות מחוץ לחוזה (לא FAIL)

- **`סטנד רצפתי לנגינה`** ב-topnav (מחוץ ל-`<main>`) — קישור ניווט לעמוד אח; לא ערבוב תוכן `stend for playing.md`.
- `<meta name="description">` / Yoast — טקסט ישן («בין נגינה לנגינה»); לא בסעיף HTML המנדט (`<main>`).
- שינויי `repair-defaults.php` / `bags-defaults.php` / `didgeridoos-defaults.php` / `stand-floor-defaults.php` — גל מקביל S006 (מותר).
- שינויי tracker CSV תחת `_COMMUNICATION/team_100/S006/tracker/` — מחוץ להיקף חוזה קוד.

---

## סיכום

חוזה R1-14 `/stands-storage/` (מקור Drive · provenance · diff ממופה · ACF skip · HTML `<main>` · qa_probe דסקטופ) — **עומד**.
