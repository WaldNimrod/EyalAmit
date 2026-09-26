# DONE — B7 second navigation — 2026-09-26

Builder report. Team 90 re-measures. Not pushed.

Staging: `http://eyalamit-co-il-2026.s887.upress.link` (plain HTTP). Theme **1.5.133**. Commit `17b52fa`. Deploy log line: `2026-09-26T02:53:43+03:00 · 17b52fa01a98 · main · theme 1.5.133 · 725 files` in [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/DEPLOY-LOG.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/DEPLOY-LOG.md).

`http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/style.css` returns **200** and its header line is `Version: 1.5.133`. The `<link>` query on rendered pages is `ver=1790380405` (file mtime). Before this deploy it was `ver=1790377919`.

Chrome: `/Users/nimrod/.cache/puppeteer/chrome-headless-shell/mac_arm-149.0.7827.22/chrome-headless-shell`, found with the same `find … chrome-headless-shell | sort -V | tail -1` logic as [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs). That file was not modified. Cookie dialog `#ea-cookie-notice` was dismissed with `[data-ea-cookie-choice="reject"]` before each box read. `cookieOpen` was false on every read.

Sitemap population, redirects not followed: `post-sitemap.xml` 53 + `page-sitemap.xml` 83 = **136** unique URLs. Concurrency capped at 3.

## Root cause

Exactly two live pages are not Chapters documents. The other 134 carry body class `ea-chapters` and are self-contained templates that never call `get_header()`, so GeneratePress never builds a navigation.

| URL | Body class evidence | What actually renders the document |
|---|---|---|
| `http://eyalamit-co-il-2026.s887.upress.link/press/` | no `ea-chapters`; has `ea-press`, `ea-editorial-press`, `ea-wave2-shell`, `ea-nd-orphan`, `ea-open-round-chrome`, `nav-float-right`, `page-template-default` | `ea_w2_07_template_include()` forces [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-content.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-content.php), which calls `get_header()` |
| `http://eyalamit-co-il-2026.s887.upress.link/historical-articles/` | no `ea-chapters`; no `ea-wave2-shell`; has `page-template-default`, `ea-nd-orphan`, `ea-open-round-chrome`, `nav-float-right`, `right-sidebar` | Not in `ea_chapters_route_map()`. Falls through to GeneratePress `page.php`, which calls `get_header()` |

Child [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/header.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/header.php) loads the parent header when it is readable. Parent is GeneratePress **3.6.1** (on the server, not in this repo). Body class `nav-float-right` selects `generate_add_navigation_float_right()` on `generate_after_header_content` (priority 5), which calls `generate_navigation_position()`. That function prints both navigation elements:

1. `<nav class="main-navigation mobile-menu-control-wrapper" id="mobile-menu-control-wrapper">` via `generate_do_header_mobile_menu_toggle` on `generate_before_navigation`
2. `<nav class="main-navigation nav-align-right sub-menu-left" id="site-navigation">`

That is the measured **3** marker hits: `id="site-navigation"` × 1 and a `class` attribute containing the token `main-navigation` × 2.

`ea_open_round_inject_chapters_nav()` on `wp_body_open` also prints the canonical `<nav id="nav">` on both pages, because both slugs are in `ea_open_round_chrome_slugs()`. The GeneratePress pair sat inside `.site-header`, which `body.ea-open-round-chrome .site-header{display:none !important}` removes from layout. On `/press/` the selector `body.ea-nd-orphan.ea-wave2-shell` **matches** (`revealRuleMatches: true`). Its rule ` .site-header{display:block}` does not win: computed `display` of `.site-header` was `none`. Computed `display` of `#site-navigation` was `block`, box **0×0**, because the ancestor was `display:none`. On `/historical-articles/` that reveal selector does **not** match (`ea-wave2-shell` is absent).

## Fix

On `wp` (priority 20), for `is_page( array( 'press', 'historical-articles' ) )` only, `remove_action` the five GeneratePress navigation constructors at the priorities the parent registers them:

- `generate_after_header_content` / `generate_add_navigation_float_right` / 5 — the one this site's `nav-float-right` setting actually runs
- `generate_after_header` / `generate_add_navigation_after_header` / 5
- `generate_before_header` / `generate_add_navigation_before_header` / 5
- `generate_before_right_sidebar_content` / `generate_add_navigation_before_right_sidebar` / 5
- `generate_before_left_sidebar_content` / `generate_add_navigation_before_left_sidebar` / 5

Those `remove_action` calls are the parent theme's own extension point (its comments on `generate_add_navigation_*` say the hooks are split so a child can unhook them). The `.site-header` shell is still emitted and still `display:none`. The navigation markup is not. No `display:none` rule was added.

Files: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/ea-open-round.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/ea-open-round.php) and the `Version:` line in [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/style.css](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/style.css) (`1.5.132` → `1.5.133`). `chapters.css`, `home-front.css`, and `template-parts/chapters/` were not edited.

## Acceptance

Fetches do not follow redirects. Marker counts are attribute matches (`id="site-navigation"`, `class="… main-navigation …"`), not CSS source text. Every one of the 136 stylesheet responses contains the strings `main-navigation` and `site-navigation` inside GeneratePress inline CSS; those are not elements.

| Check | Before | After |
|---|---|---|
| `id="site-navigation"` on `/press/` and `/historical-articles/` | 1 each | **0** each |
| `class` token `main-navigation` on those two | 2 each | **0** each |
| Either marker on the other 134 | 0 | **0** |
| `<nav id="nav">` blocks | 1 on all 136 | **1 on all 136** |
| `<footer` | 1 on all 136 | **1 on all 136** |
| HTTP status, redirects not followed | 136 × 200 | **136 × 200** |
| PHP strings `Fatal error`, `Parse error`, `Warning:`, `Notice:`, `Deprecated:`, `There has been a critical error` | 0 | **0** |

Rendered DOM on the two pages plus `/method/` (control), after dismissing the cookie dialog:

| Page | Viewport | `#site-navigation` | `.main-navigation` | `#nav` | `footer` | primary (`#nav` or `#site-navigation`) |
|---|---|---|---|---|---|---|
| `/press/` | 1280×800 and 390×844 | 0 | 0 | 1 | 1 | 1 |
| `/historical-articles/` | both | 0 | 0 | 1 | 1 | 1 |
| `/method/` | both | 0 | 0 | 1 | 1 | 1 |

Before, the two target pages were primary **2** (`#nav` and `#site-navigation`). `/method/` was already 1.

### Canonical item set, both directions

The set is the 31 visible `(path, label)` pairs `ea_canonical_nav_items()` produces and `section-nav.php` prints. `courses-external` (`קורסים דיגיטליים` → `/learning/courses-external/`) is `hidden` and is not in the set. There is no `home` key in the array.

From the single `<nav id="nav">` on each URL: `html.unescape` on href and label, tags stripped, dropdown caret `▾` stripped, whitespace collapsed. Renderer chrome (`nav__b`, `nav__home`, `nav__en`) was separated from tree items before the comparison.

- Tree items missing from the page: **empty on 136/136**
- Tree items on the page that are not in the set: **empty on 136/136**
- Tree item count inside `#nav`: **31** on `/press/`, `/historical-articles/`, and `/method/` (and on every other URL; the mismatch list was empty)
- Chrome links, identical on 136/136: `/` + `המרכז לטיפול בדיג׳רידו` (`nav__b`); `/` + empty text (`nav__home`); `/en/` + `EN` (`nav__en`)

`/en/` also has a pre-existing `<nav class="ea-en-nav" aria-label="Main">` (1 page). It is not a GeneratePress marker. Its Hebrew `nav#nav` still matched the 31-item set in both directions. This change did not add or remove `ea-en-nav`. Other extra `<nav>` elements are breadcrumbs (`ea-crumb`), the footer (`ea-ftr__nav`), and on some URLs a FAQ toc or blog filter/pagination. `/press/` after the fix has exactly three `<nav>` elements: `תפריט ראשי`, `פירורי לחם`, `ניווט בפוטר`.

### Rendered boxes

`getBoundingClientRect` after load, cookie dismissed. `display` is computed.

**`nav#nav` (the real navigation)** — unchanged on all six reads:

| Page | 1280×800 | 390×844 |
|---|---|---|
| `/press/` | 1280×88 at (0, 0), `display:flex` | 390×88 at (0, 0), `display:flex` |
| `/historical-articles/` | 1280×88 at (0, 0), `display:flex` | 390×88 at (0, 0), `display:flex` |
| `/method/` | 1280×88 at (0, 0), `display:flex` | 390×88 at (0, 0), `display:flex` |

**`#main`:**

| Page | Viewport | Before | After |
|---|---|---|---|
| `/press/` | 1280×800 | 1280×7720.7 at (0, 88) | 1280×7720.7 at (0, 88) |
| `/press/` | 390×844 | 390×8998.91 at (0, 88) | 390×8998.91 at (0, 88) |
| `/historical-articles/` | 1280×800 | 820×33173.17 at (40, 108) | 820×33173.17 at (40, 108) |
| `/historical-articles/` | 390×844 | 390×20980.55 at (0, 108) | 390×24199.05 at (0, 108) |
| `/method/` | 1280×800 | 1280×7694.23 at (0, 0) | 1280×7694.23 at (0, 0) |
| `/method/` | 390×844 | 390×10001.05 at (0, 0) | 390×10001.05 at (0, 0) |

The one number that moved is `/historical-articles/` mobile `#main` height (20980.55 → 24199.05). x, y, and width stayed 0, 108, 390. A repeat on the deployed page, 390×844, scrolled to the bottom: **18/18** images in `#main` complete, height **24199.046875** at both an 800 ms settle and a 4000 ms settle. Desktop height on that same page stayed 33173.17 to the hundredth, and `/press/` and `/method/` matched to the hundredth at both viewports. The nav box did not move.

**GeneratePress nav box:**

| | Before `#site-navigation` | After |
|---|---|---|
| `/press/` both viewports | 0×0 at (0, 0), own `display:block`, ancestor `.site-header` `display:none` 0×0 | element absent |
| `/historical-articles/` both viewports | same 0×0 / `display:block` | element absent |
| `/method/` | absent | absent |

`.site-header#masthead` is still in the DOM on the two pages, still 0×0, still `display:none`. On `/press/` `body.ea-nd-orphan.ea-wave2-shell` still matches. There is no `#site-navigation` inside it for that rule to reveal.

## Next

Team 90 re-measures. This session did not push.
