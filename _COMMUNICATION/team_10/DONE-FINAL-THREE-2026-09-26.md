# DONE — footer terms link, paragraph-only CTA clearance, topnav diagnosis

Date: 2026-09-26. Theme **1.5.136 → 1.5.137**. Commit `46d43d88e6e6` on `main`, deployed, not pushed. Deploy log line: `2026-09-26T18:43:16+03:00 · 46d43d88e6e6 · main · theme 1.5.137 · 725 files` in [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/DEPLOY-LOG.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S006/DEPLOY-LOG.md).

`style.css` Version was **1.5.136** before the bump. Live `chapters.css?ver=1.5.136` on the before pass, `1.5.137` on the after pass and on all 136 sitemap URLs.

Staging base: http://eyalamit-co-il-2026.s887.upress.link (plain HTTP). Viewport for every gap: **1440×900**. Gap = `logo.left − ink.right`, where ink is the right edge of `.cta-band__h` and/or `.cta-band__p` after the band was scrolled into view and the reveal class `.r.in` was on. Cookie dialog `#ea-cookie-notice` was closed so the page was not inert. Two animation frames after settle. A leftover `translateY` under 0.06px remained on some bands while opacity was already above 0.99; that shift is vertical only and does not move `left`/`right`.

Locked files, sha256 unchanged before and after:

- `ea-tokens.css` `0c4f825befdd09e744d2a8c541f31cb009e7e095e8bf2d78413653fb6ed150b4`
- `S007-TYPOGRAPHY-CANON.md` `259cf4e0b197aaa8faa10721d0f389758c77b3a8dd6ca21ae5d69677b116952d`

No new token. No component `font-size`. The old footer menu function stays unhooked.

Next measure: Team 90.

## Task 1 — `/terms/` in the legal strip

The strip is the one `<p class="ea-ftr__base">` inside `ea_render_unified_footer()` in [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/ea-canonical-nav.php). The existing two anchors were left in place. The third uses the drawer label **תקנון** from [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/ea-nav-drawer.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/ea-nav-drawer.php) line 217. The page H1 «תקנון ותנאי שימוש» was not used.

Live legal strip, identical on **136/136** sitemap URLs (redirects not followed):

| href | label |
|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/accessibility/ | הצהרת נגישות |
| http://eyalamit-co-il-2026.s887.upress.link/privacy/ | מדיניות פרטיות |
| http://eyalamit-co-il-2026.s887.upress.link/terms/ | תקנון |

http://eyalamit-co-il-2026.s887.upress.link/terms/ returned **200** on the first attempt, redirects not followed.

### Legal documents found

| Document | Where | Linked from the footer strip |
|---|---|---|
| הצהרת נגישות | published page http://eyalamit-co-il-2026.s887.upress.link/accessibility/ | yes |
| מדיניות פרטיות | published page http://eyalamit-co-il-2026.s887.upress.link/privacy/ | yes |
| תקנון | published page http://eyalamit-co-il-2026.s887.upress.link/terms/ | yes, as of 1.5.137 |
| Medical disclaimer | inline `<p class="ea-ftr__disc">`, no page of its own | no link; the paragraph contains no `<a>` |

No fourth legal page. Census:

- Yoast `page-sitemap.xml` (83) + `post-sitemap.xml` (53) = **136** unique locs. The only locs whose paths are privacy, accessibility, or terms are those three.
- REST `wp/v2/pages` reports **101** published pages. Title/slug scan for terms, privacy, accessibility, legal, cookie, disclaimer, policy, תקנון, נגישות, פרטיות, עוגיות, ויתור, הסתייגות, תנאי matched only those three, plus the false hit `tools-and-accessories` (the substring «access»). That page is the tools hub, not a policy.
- Theme route map in `ea_chapters_route_map()` registers legal slugs `privacy`, `accessibility`, `terms` only.
- Site-tree seeder `ea_m2_st_ensure_page` creates the same three legal slugs and no other policy slug.
- The cookie dialog links to `/privacy/` and is not a page.
- `template-parts/blocks/block-disclaimer.php` has no caller.

The disclaimer paragraph is non-empty on all 136 pages and contains no anchor. It was not edited.

## Task 2 — paragraph with no heading clears the logo

The 1.5.136 rule required both `.cta-band__h` and `.cta-band__p`. A second rule now matches `.cta-band__txt:has(.cta-band__p):not(:has(.cta-band__h))` with the same `padding-inline-start` calc. The heading-and-paragraph rule, and the `body.page-id-73` reset that zeroes it, were not edited.

Before is live 1.5.136. After is live 1.5.137.

### The two that overlapped

| URL | Before gap | After gap | Before padding | After padding |
|---|---|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/ | **−240** | **+24** | 0px | 264px |
| http://eyalamit-co-il-2026.s887.upress.link/lessons/ | **−240** | **+24** | 0px | 264px |

Both bands have a paragraph and no heading (home 129 characters, lessons 65).

### Three already-correct bands, unchanged

| URL | Before gap | After gap | Padding both times |
|---|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/method/ | **+24** | **+24** | 264px |
| http://eyalamit-co-il-2026.s887.upress.link/repair/ | **+24** | **+24** | 264px |
| http://eyalamit-co-il-2026.s887.upress.link/learning/ | **+24** | **+24** | 264px |

### Button-only bands, boxes unchanged

No heading, no paragraph, padding 0px before and after, gap not applicable (no ink).

| URL | Before button box | After button box |
|---|---|---|
| http://eyalamit-co-il-2026.s887.upress.link/bags/ | left 160, right 436.6, width 276.6, height 55.7 | same |
| http://eyalamit-co-il-2026.s887.upress.link/stands-storage/ | left 160, right 324.4, width 164.4, height 55.7 | same |
| http://eyalamit-co-il-2026.s887.upress.link/stand-floor/ | left 160, right 305.7, width 145.7, height 55.7 | same |

Also unchanged, measured so the new selector can be seen not to apply:

- http://eyalamit-co-il-2026.s887.upress.link/testimonials/ has both a heading and a paragraph. The page-73 reset still wins: gap **−240**, padding **0px**, before and after.
- Title-only band 2 on http://eyalamit-co-il-2026.s887.upress.link/books/kushi-blantis/ and on http://eyalamit-co-il-2026.s887.upress.link/books/tsva-bekahol/ : gap **−240**, padding **0px** after the deploy. The button-only bands on those pages stayed padding 0.

## Task 3 — why `<header data-block="topnav">` never paints

Nothing in this task was edited. `block-topnav.php`, `tpl-qr.php`, `tpl-blog-single.php`, `wave2-stage-b.php`, and `chapters-routing.php` are absent from commit `46d43d8`.

The block file does run when it is included. On a live request it is not included. A later `template_include` filter returns a different file, and WordPress includes that file. `body_class` / `is_page_template()` still report the assigned post meta `_wp_page_template`, which is why a QR page’s body contains `page-template-tpl-qr` while `tpl-qr.php` is not the file that ran.

### QR

`ea_w2_07_template_include` (priority 100) swaps only `/press/`. It leaves a QR child on `tpl-qr.php`. `ea_chapters_template_include` (priority 103) then matches parent slug `qr` in `ea_chapters_pattern_routes()` and returns `page-templates/tpl-chapters-qr.php`. That template prints `section-nav.php` (`aria-label="תפריט ראשי"`, from `ea_canonical_nav_items()`). It does not call `get_template_part( 'template-parts/blocks/block', 'topnav' )`. The block’s own label is `ניווט ראשי`.

Live http://eyalamit-co-il-2026.s887.upress.link/qr/qr1/ HTTP 200, measured on 1.5.136 before any edit:

| Marker | Count | Which file owns it |
|---|---|---|
| `page-template-tpl-qr` in the body class | present | post meta, not the included file |
| `chapters-main` | 1 | `tpl-chapters-qr.php` |
| `כל דפי ה-QR` (ASCII hyphen) | 1 | `tpl-chapters-qr.php` line 50 |
| `כל דפי ה־QR` (Hebrew maqaf) | 0 | `tpl-qr.php` line 31 only |
| `ea-wave2-qr` | 0 | `tpl-qr.php` only |
| `data-block="topnav"` | 0 | `block-topnav.php` |
| `ניווט ראשי` | 0 | the block’s `<nav>` |
| `id="nav"` with `תפריט ראשי` | 1 | `section-nav.php` |

The deployed QR response matches the repo’s Chapters template, not a different copy of `tpl-qr.php`. This is not a deployment mismatch.

After 1.5.137, `data-block="topnav"` is **0** on all 136 sitemap URLs, including every `/qr/qrN/`.

### Blog single

`ea_chapters_blog_template_include` (priority 105) returns `tpl-chapters-blog-single.php` for every `is_singular('post')`. A live post (first non-`/blog/` loc in `post-sitemap.xml`) returned HTTP 200 with body classes `post-template-default single` plus `ea-chapters` plus `ea-blog-single-view`, `chapters-main` 1, `ea-wave2-blog-single` 0, `data-block="topnav"` 0. Posts do not carry a page-template body class. `tpl-blog-single.php` is not the included file.

### Home chrome call

`ea_wave2_render_home_blocks()` is called from `tpl-home.php` and `tpl-stage-b-test.php` only. The front page is routed at priority 103 to `tpl-chapters-home.php`. `tpl-home.php` says it is the rollback kept for `EA_CHAPTERS_FRONT=false`. That constant is not defined anywhere under `site/`, so `ea_chapters_enabled()` stays at its default `true`. Home HTML has `data-block="topnav"` 0 and one `nav#nav` labelled `תפריט ראשי`.

`/en/` is the same kind of override: `ea_w2_08_template_include` at priority 101 would include `tpl-en-landing.php` (that file contains its own `<header data-block="topnav">`), and the route map sends slug `en` to `tpl-chapters-en.php` at priority 103. Live `/en/` is `page-template-default`, has `chapters-main`, and has `data-block="topnav"` 0. The class `ea-en-landing` is added by a body-class filter on the slug, the same way the QR body class names a file that did not run.

### Stable or fragile

Stable while Chapters stays on. That is the default, and it is what the live pages are doing.

Fragile only on the documented rollback: define `EA_CHAPTERS_FRONT` false, or filter `ea_chapters_front_enabled` to false. The assigned templates would then be the files that run, and the three call sites would emit the block. No code was changed to reach this conclusion.

## Regression

`page-sitemap.xml` 83 + `post-sitemap.xml` 53 = **136** unique URLs. Concurrency 3. Redirects not followed. No 502 was returned.

| Check | Result |
|---|---|
| HTTP 200 | **136 / 136** |
| `chapters.css?ver=` | **1.5.137** on 136 / 136 |
| `<p class="ea-ftr__base">` links | the three rows in the table above, on 136 / 136 |
| `nav#nav` | **1** on 136 / 136, `aria-label` `תפריט ראשי` |
| `id="site-navigation"` | **0** on 136 / 136 |
| `data-block="topnav"` | **0** on 136 / 136 |
| `<footer` | **1** on 136 / 136 |
| `ea-ftr__disc` non-empty and with no `<a>` | **136 / 136** |
| `Fatal error`, `Parse error`, `Uncaught `, `Warning: `, `Notice: `, `Deprecated: `, `There has been a critical error` | **0** |

Spot check of opening `<nav>` tags: home has `nav#nav` plus `ea-ftr__nav`. `/press/` adds `nav.ea-crumb` (breadcrumbs). Neither is a second primary nav. `/press/` and `/historical-articles/` have `main-navigation` class count **0**.
