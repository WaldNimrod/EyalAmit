# DONE — footer one invocation path — 2026-09-27

Mandate: `_COMMUNICATION/team_90/AUDIT-2026-09-26/MANDATE-FOOTER-ONE-PATH-2026-09-27.md`  
Staging: `http://eyalamit-co-il-2026.s887.upress.link`  
Theme: **1.5.143** (live `?ver=1.5.143` after deploy)  
Commit: **`e456b1f`** (6 files under `site/wp-content/themes/ea-eyalamit/` only)  
Deploy: `python3 scripts/ftp_deploy_site_wp_content.py` — **clean `site/`**, no `--allow-dirty`

## Precondition (verified before edit)

| Check | Measurement |
|---|---|
| `site/` git status | clean |
| `style.css` Version | **1.5.142** |
| cbDIDG lane | committed on `main` (working tree clean at start) |

## Invocation paths

### Before (5 render paths + guard)

| Location | Mechanism |
|---|---|
| `inc/ea-canonical-nav.php` | `add_action( 'wp_footer', 'ea_render_unified_footer' )` |
| `footer.php:63` | explicit `ea_render_unified_footer()` |
| `template-parts/blocks/block-footer-social.php:18` | explicit call |
| `page-templates/tpl-chapters-en.php:120` | explicit call |
| `template-parts/chapters/section-footer.php:24` | explicit call with `array( 'reveal' => true )` |
| `ea_render_unified_footer()` | `static $ea_rendered` render-once guard |

### After (1 path, no guard)

```text
$ rg "ea_render_unified_footer\(" site/wp-content/themes/ea-eyalamit --glob '*.php'
# → function definition + column helper + hook callback body only (no template calls)

$ rg "add_action\(\s*'wp_footer'.*unified" site/wp-content/themes/ea-eyalamit
inc/ea-canonical-nav.php:670:add_action( 'wp_footer', 'ea_render_unified_footer_wp_hook' );
```

Chapters sticky-reveal: `section-footer.php` sets `$GLOBALS['ea_unified_footer_reveal'] = true` before `wp_footer()`; `ea_render_unified_footer_wp_hook()` passes `'reveal' => true` into `ea_render_unified_footer()`. No other `$GLOBALS` / helpers added.

## Rendered footer — byte proof (before change, then after deploy)

Captured `outerHTML` of all `<footer>` nodes (CDP, cookie choice pre-set, 1440×900) into  
`tmp/footer-one-path/before/` and `tmp/footer-one-path/after/`. **`diff -q` identical on all five.**

| Path | SHA-256 of concatenated footer outerHTML | Before footer count | After footer count |
|---|---|---:|---:|
| `/` | `537170d8bdb36bf5c7c44b5bc69775fa604c1c8ff797531921bb29c87a86e512` | 1 | 1 |
| `/press/` | `1950c98f32e29fa728748ba87a51924f13da381ff515a6334fb7d96ee8ef5b46` | 1 | 1 |
| `/historical-articles/` | `1950c98f32e29fa728748ba87a51924f13da381ff515a6334fb7d96ee8ef5b46` | 1 | 1 |
| `/en/` | `1950c98f32e29fa728748ba87a51924f13da381ff515a6334fb7d96ee8ef5b46` | 1 | 1 |
| `/qr/qr1/` | `537170d8bdb36bf5c7c44b5bc69775fa604c1c8ff797531921bb29c87a86e512` | 1 | 1 |

`assets/css/ea-tokens.css`: **0 bytes diff** in commit.

## Reveal argument (Chapters)

**What it did:** `'reveal' => true` adds classes `foot uncover` on `<footer>`, inserts `<span class="arcs">`, and enables `ea-chapters.js` sticky footer sizing (`footer.foot.uncover` → `is-uncover` + `#main` margin-bottom when footer height ≤ 85% viewport).

**How preserved:** flag in `section-footer.php` → hook callback (above). `/en/` never used reveal (explicit call had no args); still `classes: ea-ftr` only.

**Browser measurement on `/` (before and after, identical JSON):**

```json
{"classes":"ea-ftr foot uncover","isUncover":false,"mainMb":"","hasArcs":true}
```

After scroll-to-bottom CDP probe: same on **1.5.142** baseline and **1.5.143** deploy. `is-uncover` false on home because footer height exceeds 85% viewport (`ea-chapters.js` `tooTall` branch) — unchanged behaviour. QR sample `/qr/qr1/` after deploy: same classes + `hasArcs: true`.

## Full population regression

REST: `/wp-json/wp/v2/pages` (paginated) + `/wp-json/wp/v2/posts` → **153** published objects.  
HEAD without redirect follow (502 retried): **136× HTTP 200**, **17× HTTP 301**.

| Check | Result |
|---|---|
| `<footer` count per 200 URL | **136/136 exactly 1** |
| `nav#nav` count | **136/136 exactly 1** |
| `id="site-navigation"` | **0** on all 136 |
| `data-block="topnav"` | **0** on all 136 |
| PHP error strings (`Fatal`, `Parse`, `Warning:.*on line`, `Notice:.*on line`) | **0** on 136 |

Concurrency **3**; 502 retried before counting as failure.

## Horizontal overflow @ 390px (CDP)

| Path | scrollWidth | clientWidth | overflow |
|---|---:|---:|---|
| `/` | 390 | 390 | false |
| `/press/` | 390 | 390 | false |
| `/historical-articles/` | 390 | 390 | false |
| `/en/` | 390 | 390 | false |

Before and after: identical table.

## Non-rendering templates (unchanged, reported only)

| Template | Behaviour |
|---|---|
| `page-templates/tpl-books.php` | 301 to `/books/`, `exit` — no HTML, no footer |
| `page-templates/tpl-catalog-14e.php` | 301 to `/`, `exit` — no published page uses it |

## Scope discipline

- No `--allow-dirty` deploy.
- No edits outside the six committed theme paths; no `ea-tokens.css`, no hub, no `_aos/`, no `local/`.
