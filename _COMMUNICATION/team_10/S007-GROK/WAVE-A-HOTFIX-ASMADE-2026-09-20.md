# Wave A hotfix — as-made · 2026-09-20

**מנדט:** [MANDATE-WAVE-A-HOTFIX-2026-09-20.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/MANDATE-WAVE-A-HOTFIX-2026-09-20.md)  
**מבצע:** צוות 10  
**סטייג'ינג:** http://eyalamit-co-il-2026.s887.upress.link  
**גרסת תמה:** 1.5.97  
**קומיטים:** `4270b68` (חבילה עיקרית) · `c91a048` (תיקון הוק וורדמרק GP)  
**FTP:** `Done: FTP deploy site/wp-content (child theme + mu-plugins).` (הרצה שנייה אחרי `c91a048`)

## שינויים

| id | קובץ | מה |
|---|---|---|
| WAF-02 | `assets/css/chapters.css` | `.phero--media` — `overflow-x: clip; overflow-y: visible` (ריווח אנכי סעיף 16 נשמר) |
| WAF-01 | `inc/chapters/defaults/shop-defaults.php` | `תיקון וחידוש כלים` → `תיקון וחידוש כלי דיג׳רידו` בכותרת כרטיס וב־`<strong>` ב־lede |
| WAF-03 | `page-templates/tpl-chapters-en.php` | הוסר כפתור in-page כפול «Talk on WhatsApp» (~שורה 150); CTA בהירו נשאר; צף אתר נשאר |
| WAF-V02 | `template-parts/blocks/block-footer-social.php` | כלים → `/shop/`; ספרים → `ספרים – מוזה הוצאה לאור` → `/books/` |
| WAF-V01 | `inc/ea-nav-drawer.php` + `assets/css/ea-atoms.css` | וורדמרק «המרכז לטיפול בדיג׳רידו» ליד כותרת GP ב־`/about/` `/press/` (`generate_site_title_output`; מוסתר 1081–1499 כמו Chapters) |
| bump | `style.css` | Version 1.5.96 → 1.5.97 |

## אימות מהיר (HTTP, אחרי FTP)

- `/shop/` — 0 מופעי «תיקון וחידוש כלים» בגוף; תווית כרטיס/lede מעודכנת.
- `/en/` — 2× `wa.me` (הירו + צף).
- `/about/` `/press/` — פוטר Wave2: אין `/tools-and-accessories`; תווית ספרים מעודכנת; `.nav__wm` ב־header.
- `style.css?ver=1.5.97` על סטייג'ינג.

## BLOCKER

אין.
