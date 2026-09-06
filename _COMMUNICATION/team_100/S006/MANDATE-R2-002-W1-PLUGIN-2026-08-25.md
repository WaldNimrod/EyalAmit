# MANDATE — team_100 subagent · R2-002 `/about/moksha/` · W1 plugin (full 5-entry map)

**מנהל:** team_100 · **בנאי:** Cursor Grok · **לא מאמת. לא E2E. לא FTP.**
**חוק:** אמנה §3א · GO רציף · [MAP-S006-R2-W1-301-2026-08-25.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/MAP-S006-R2-W1-301-2026-08-25.md)
**תבנית:** [AGENT-TEMPLATE-S006-R2-PAGE.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/AGENT-TEMPLATE-S006-R2-PAGE.md)

שורה ראשונה בדוח: `RECOMMEND: BUILD_DONE|ASK_NIMROD`

## זהות

```
שורה: R2-002
עמוד: מוקש דהימן — על השם
נתיב: /about/moksha/
גל: W1
סוג: 301-חדש (קובץ אחד לכל חמש השורות החדשות)
מקור הבייטים: INTAKE-NIMROD-R2-MAP-2026-08-24.md · בחירה «301 אל מוקש לזכרו»
מחוץ לסקואופ: 23 עמודי סבב 1 · טופס סבב 1 · videoblk.php · block-faq-list.php · wp-admin · מובייל
```

## מה לבנות

קובץ **חדש בלבד:** `site/wp-content/mu-plugins/ea-s006-r2-w1-legacy-301.php`

דפוס 301: מחצית ה-redirect ב-`site/wp-content/mu-plugins/ea-s006-testimonials-slug-once.php` (`template_redirect` עדיפות 0, `wp_safe_redirect` 301).

המפה — **חמש** השורות, לא רק מוקש:

| מקור | יעד |
|---|---|
| `/about/moksha/` | `/eyal-amit/mokesh-dahiman/` |
| `/tools-and-accessories/` | `/shop/` |
| `/tools-and-accessories/instruments/` | `/didgeridoos/` |
| `/tools-and-accessories/repair/` | `/repair/` |
| `/services/handmade-instruments/` | `/didgeridoos/` |

הערת מקור על המערך: `/* S006 · מקור: INTAKE-NIMROD-R2-MAP-2026-08-24.md · נימרוד 24.8.2026 */`  
כותרת תגובה: `X-EA-Redirect: s006-r2-w1`

אל תפנו אם היעד אינו עמוד `publish` (אותו משמרת כמו testimonials — עדיף מקור 200 מאשר 301 ל-404).

## אסור

- `ea-w209-legacy-301-redirects.php` (GENERATED)
- `ea-m2-site-tree-lock-sync-once.php` (once + טבלה קיימת — דורסים handmade בעדיפות 0, לא בעריכת ה-once)
- כל `inc/chapters/defaults/*-defaults.php` של סבב 1 (במיוחד `mokesh-defaults.php` · `shop` · `didgeridoos` · `repair`)
- `block-topnav.php` · `functions.php` · `videoblk.php` · `block-faq-list.php`
- FTP · git add/commit/push · wp-admin · טופס `s006-review.html`

## דיווח ל-100

- הנתיב שנוצר
- חמש השורות במערך
- מה לא נגע
- שורה ראשונה `RECOMMEND: BUILD_DONE` או `ASK_NIMROD` אם יעד 301 היה דורס גוף סבב 1
