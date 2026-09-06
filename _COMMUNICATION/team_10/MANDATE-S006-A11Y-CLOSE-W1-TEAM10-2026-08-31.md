# מנדט · A11Y-CLOSE W1 (רוחבי) · צוות 10 · 2026-08-31

**מוציא:** צוות 100 · **מבצע:** צוות 10 · **מאמת:** צוות 90/50 במנוע אחר  
**שורש:** `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-a11y-close` · ענף `feat/s006-a11y-close`  
**חוק:** [PLAN-S006-A11Y-CLOSE-PACK-2026-08-31.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026-a11y-close/_COMMUNICATION/team_100/S006/PLAN-S006-A11Y-CLOSE-PACK-2026-08-31.md)

## אסור

- שכתוב `accessibility-defaults.php` / privacy / terms / הסרת WP-EI-05
- Enable Accessibility · תוסף נגישות שני · overlay
- החלפת CF7 ב-Fluent/Gravity
- שכתוב פסקאות בעמודי סבב 1
- כתיבה מחוץ לשורש העץ הזה

## חובה

1. דילוג **אחד** לכל תבנית, `href="#main"`, `<main id="main" tabindex="-1">`. EN: «Skip to content». CSS 1.5.17 כבר בענף (`transition:none` בפוקוס).
2. להעביר מ-checkout המלוכלך של `main` רק קבצי A11Y-NOW PHP שכבר חיים בסטייג'ינג ולא ב-git (tpl-chapters `id="main"`, header `#main`, wave2 skip EN) — לא את 387 הנתיבים.
3. טופס `/contact/`: CF7 נשאר; להסתיר טופס native כש-CF7 מודפס; label/aria לשדות CF7.
4. פוטר: `h4` → `p.foot__col-title`; CSS `.foot h4, .foot__col-title` אותם כללים.
5. `:focus-visible` ל-`.foot a` / `.tlink` / כפתורים ב-chapters.
6. ניגודיות `.foot__disc` ≥ 4.5:1 (טוקן אחד).
7. באמפ Version ב-`style.css` ל-**1.5.18** אחרי W1.
8. FTP `python3 scripts/ftp_deploy_site_wp_content.py` ואז ניקוי מטמון uPress אם אפשר.

## DoD

דילוג אחד נראה ב-Tab, מגיע ל-`#main`; טופס אחד עם תוויות ב-`/contact/`; H1 של 23 עמודי R1 לא השתנה מול baseline.
