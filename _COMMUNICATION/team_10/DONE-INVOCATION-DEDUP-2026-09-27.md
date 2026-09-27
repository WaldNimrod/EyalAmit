# DONE — invocation dedup (nav, chapters footer prelude, footer-social) — 2026-09-27

Mandate: `_COMMUNICATION/team_90/AUDIT-2026-09-27/MANDATE-INVOCATION-DEDUP-2026-09-27.md`  
Worked example: `_COMMUNICATION/team_10/DONE-FOOTER-ONE-PATH-2026-09-27.md`  
Staging: `http://eyalamit-co-il-2026.s887.upress.link`  
Theme: **1.5.145** (live `style.css` `Version:` after deploy)  
Commits: **`c1c7f70`** (1.5.144 dedup) · **`6380a19`** (1.5.145 — QR `section-footer` hook coverage)  
Deploy: `python3 scripts/ftp_deploy_site_wp_content.py` — **clean `site/`**, no `--allow-dirty`

## Precondition (verified before edit)

| Check | Measurement |
|---|---|
| `site/` git status | clean |
| `style.css` Version (repo) | **1.5.143** |
| Live staging `style.css` Version | **1.5.143** |
| `assets/css/ea-tokens.css` in commit | **0 bytes diff** |

## Invocation paths

### Primary nav (`nav#nav`)

#### Before (9 paths + `ea_chapters_nav_mark_once()`)

| Location | Mechanism |
|---|---|
| `page-templates/tpl-chapters-home.php` | `get_template_part( … section', 'nav' )` |
| `page-templates/tpl-chapters-page.php` | same |
| `page-templates/tpl-chapters-qr.php` | same |
| `page-templates/tpl-chapters-blog-single.php` | same |
| `page-templates/tpl-chapters-blog-archive.php` | same |
| `page-templates/tpl-chapters-mokesh.php` | same |
| `page-templates/tpl-chapters-method.php` | same |
| `inc/ea-open-round.php:89` | `add_action( 'wp_body_open', … inject section-nav )` |
| `template-parts/chapters/section-nav.php` | `ea_chapters_nav_mark_once()` guard |

#### After (1 path, no guard)

```text
$ rg "get_template_part\(\s*'template-parts/chapters/section',\s*'nav'" site/wp-content/themes/ea-eyalamit
inc/ea-canonical-nav.php:658:		get_template_part( 'template-parts/chapters/section', 'nav' );

$ rg "add_action\(\s*'wp_body_open',\s*'ea_render_primary_nav" site/wp-content/themes/ea-eyalamit
inc/ea-canonical-nav.php:661:add_action( 'wp_body_open', 'ea_render_primary_nav_wp_hook', 20 );

$ rg "ea_chapters_nav_mark_once" site/wp-content/themes/ea-eyalamit
(0 matches)
```

### Chapters footer prelude (`section-footer.php` — contact gap + `$GLOBALS['ea_unified_footer_reveal']`)

#### Before (7 explicit `get_template_part( … section', 'footer' )`)

Same seven chapter templates as nav (home, page, qr, blog-single, blog-archive, mokesh, method).

#### After (1 path)

```text
$ rg "get_template_part\(\s*'template-parts/chapters/section',\s*'footer'" site/wp-content/themes/ea-eyalamit
inc/ea-canonical-nav.php:709:		get_template_part( 'template-parts/chapters/section', 'footer' );

$ rg "add_action\(\s*'wp_footer',\s*'ea_chapters_section_footer" site/wp-content/themes/ea-eyalamit
inc/ea-canonical-nav.php:712:add_action( 'wp_footer', 'ea_chapters_section_footer_wp_hook', 5 );
```

`ea_chapters_uses_section_footer_partial()` mirrors the old call sites: `ea_chapters_is_view()` minus `/en/`, `/press/`, `/historical-articles/`, plus chapters blog post templates. **1.5.144** used template-slug only and dropped sticky-reveal on `/qr/qr1/`; **1.5.145** fixed that (see byte proof).

Unified `<footer>` markup remains solely on `add_action( 'wp_footer', 'ea_render_unified_footer_wp_hook' )` (unchanged from footer mandate).

### Social block (`block-footer-social.php`)

#### Before (5 call sites, empty partial after footer-one-path)

| Location |
|---|
| `page-templates/tpl-content.php` |
| `page-templates/tpl-blog-archive.php` |
| `page-templates/tpl-blog-single.php` |
| `page-templates/tpl-qr.php` |
| `inc/wave2-stage-b.php` (`ea_wave2_render_home_blocks`) |

#### After (0 call sites; partial retained)

```text
$ rg "get_template_part\(\s*'template-parts/blocks/block',\s*'footer-social'" site/wp-content/themes/ea-eyalamit
(0 matches)
```

Footer content path: `ea_render_unified_footer_wp_hook` on `wp_footer` only.

## Rendered markup — byte proof (before baseline 1.5.143, after deploy 1.5.145)

CDP capture: `tmp/invocation-dedup/capture.mjs` → `before/` vs `after2/`.  
Cookie dialog dismissed before read; 1440×900.

| Path | SHA-256 `nav#nav` outerHTML | SHA-256 all `<footer>` outerHTML | `diff -q` nav | `diff -q` footer |
|---|---|---|---|---|
| `/` | `10629a677d3814e7ae3cc7ab520ed4cd7e10c9e6291644bf70655b92537f514e` | `537170d8bdb36bf5c7c44b5bc69775fa604c1c8ff797531921bb29c87a86e512` | identical | identical |
| `/press/` | `e10ceb84086b320d9f62ad4d96fc247704dfbd13fb26d913a223f616b2125774` | `1950c98f32e29fa728748ba87a51924f13da381ff515a6334fb7d96ee8ef5b46` | identical | identical |
| `/historical-articles/` | `e10ceb84086b320d9f62ad4d96fc247704dfbd13fb26d913a223f616b2125774` | `1950c98f32e29fa728748ba87a51924f13da381ff515a6334fb7d96ee8ef5b46` | identical | identical |
| `/en/` | `d956f1baa88e83a6f58592bd73122a5843c792d8b3767fb3c9621275544bd0ec` | `1950c98f32e29fa728748ba87a51924f13da381ff515a6334fb7d96ee8ef5b46` | identical | identical |
| `/qr/qr1/` | `10629a677d3814e7ae3cc7ab520ed4cd7e10c9e6291644bf70655b92537f514e` | `537170d8bdb36bf5c7c44b5bc69775fa604c1c8ff797531921bb29c87a86e512` | identical | identical |

Per-page counts before and after: **nav#nav = 1**, **`<footer>` = 1** on all five.

## Full population regression

REST: `/wp-json/wp/v2/pages` + `/wp-json/wp/v2/posts` → **153** objects.  
HEAD/HTML scan without redirect follow (502 retried, concurrency **3**):

| Phase | 200 | 301 | nav≠1 on 200 | footer≠1 on 200 | PHP error strings |
|---|---:|---:|---:|---:|---:|
| Before (1.5.143) | 136 | 17 | 0 | 0 | 0 |
| After (1.5.145) | 136 | 17 | 0 | 0 | 0 |

## Horizontal overflow @ 390px (CDP, after deploy)

| Path | scrollWidth | clientWidth | overflow |
|---|---:|---:|---|
| `/` | 390 | 390 | false |
| `/press/` | 390 | 390 | false |
| `/historical-articles/` | 390 | 390 | false |
| `/en/` | 390 | 390 | false |

## Four dead items (reported only — not deleted)

| Item | Measurement (staging, 136×200 population unless noted) |
|---|---|
| **`header.php` child early-return** | `ea-shell-nav` substring: **0/136** pages (sample `/`, `/press/`, `/en/`, `/contact/` also **0**) |
| **`block-topnav.php` call sites** | `ea-topnav` / `data-block="topnav"`: **0/136** pages. **4** `get_template_part( … block', 'topnav' )` remain in repo (`tpl-blog-*`, `tpl-qr.php`, `wave2-stage-b.php`) — dead on live HTML |
| **`tpl-catalog-14e.php`** | REST published pages with template `page-templates/tpl-catalog-14e.php`: **0** |
| **`tpl-chapters-en.php` inline `ea_canonical_nav_items()` loop** | `/en/` still uses `.ea-en-nav` flat links (not `nav#nav` markup). **Propose (not implemented):** extract a shared `ea_render_en_landing_nav()` in `inc/ea-canonical-nav.php` that emits the existing flat anchor loop verbatim, call it from `tpl-chapters-en.php` only; Hebrew `section-nav.php` stays on `wp_body_open`. Risk: any accidental reuse of the Hebrew desktop renderer would change `/en/` pixels — gate with a dedicated function name + mandate, not `get_template_part( section-nav )`. |

## Scope discipline

- No `--allow-dirty` deploy.
- No `git add -A`; 18 theme paths in `c1c7f70` + 2 in `6380a19`.
- No edits to `ea-tokens.css`, `hub/`, `_aos/`, `local/`, `_COMMUNICATION/team_100/S007/`.
- **Not pushed** to `origin`.
