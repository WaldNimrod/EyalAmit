---
id: MANDATE-TEAM10-W2-05-SHOP-2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_10 (Builder)
wp: WP-W2-05 — Shop (5 product pages + /shop catalog)
date: 2026-05-29
status: READY TO DISPATCH (awaiting team_00 go)
spec_ref: _aos/work_packages/S002/WP-W2-05/LOD400_spec.md
depends_on: WP-W2-02 (COMPLETE), WP-W2-04 (COMPLETE — mirror its pattern)
branch: feature/w2-05-shop
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-05
---

# Dispatch Mandate — WP-W2-05 (Shop)

## 1. Scope
Build **6 pages** in the `ea-eyalamit` theme:
- 5 product/service pages on a NEW `tpl-shop-item.php`:
  `/didgeridoos`, `/bags`, `/stands-storage`, `/stand-floor`, `/repair`
- 1 unified catalog `/shop` on a NEW `tpl-shop-archive.php` (5 product cards, responsive grid).

Content transcribed **1:1** from the 25.5.26 sources (AC-05 rule — normalize clear/obvious
typos, preserve Eyal's voice & deliberate slang; flag genuine ambiguities in the completion
report, do NOT guess):
| Page | Source `.md` |
|------|------|
| /didgeridoos | `docs/.../תוכן לאתר 25.5.26/כלים למכירה/buy didgeridoo.md` |
| /bags | `.../תיקים לדיג'רידו/bags for didg.md` |
| /stands-storage | `.../סטנדים לדיג'רידו לאחסון/stend for hanging.md` |
| /stand-floor | `.../סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md` |
| /repair | `.../תיקון כלי דיג'רידו/build didg.md` |

## 2. Mirror W2-04 EXACTLY (this is a replication task — do NOT invent a new architecture)
Reference implementation (read fully before building):
- `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-04.php` (router)
- `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-04-content.php` (content provider)
- `site/wp-content/themes/ea-eyalamit/page-templates/tpl-service.php` (thin shell)
- `site/wp-content/themes/ea-eyalamit/assets/css/w2-04-service.css`
- `site/wp-content/themes/ea-eyalamit/assets/js/ea-ab-testing.js`

### Files to CREATE
1. **`inc/wave2-w2-05.php`** — copy `wave2-w2-04.php`. Slug→template map:
   `didgeridoos|bags|stands-storage|stand-floor|repair => tpl-shop-item`, `shop => tpl-shop-archive`.
   Keep: `template_include` pri 100 (`locate_template`), `template_redirect` → `set_query_var('ea_wave2_shell', true)`,
   `body_class` pri 102 → `ea-wave2-shell` + `ea-shop-<slug>`, `generate_sidebar_layout` → `no-sidebar`,
   `generate_show_title` → false, `wp_enqueue_scripts` pri 28 (enqueue `w2-05-shop.css` + reuse `ea-ab-testing` JS).
   `require_once __DIR__ . '/wave2-w2-05-content.php';`. Version from `wp_get_theme()->get('Version')`.
2. **`inc/wave2-w2-05-content.php`** — copy `wave2-w2-04-content.php`. `the_content` filter pri 9
   (guards `is_main_query() && in_the_loop()`), per-slug dispatch. Add block renderers for the
   **10-block shop contract** (see §3). Include the `/shop` archive branch (renders the catalog grid).
3. **`page-templates/tpl-shop-item.php`** — thin shell (copy `tpl-service.php`):
   `get_header()` → topnav block → `<main class="ea-wave2-shop-item">` loop `the_content()` →
   footer-social block → `get_footer()`.
4. **`page-templates/tpl-shop-archive.php`** — thin shell for `/shop` (`<main class="ea-wave2-shop-archive">`),
   same structure; the catalog grid HTML is injected by the content provider.
5. **`assets/css/w2-05-shop.css`** — copy `w2-04-service.css` patterns; add product blocks (price,
   purchase CTA, gallery) + responsive **catalog grid: 4-up desktop / 2-up mobile**, each card linked.
   **D-14 tokens ONLY** (`--ea-*`, incl. `--ea-on-dark` in `assets/css/ea-tokens.css`). **NO raw hex.**

### Files to MODIFY (surgical — never `git add -A`; IR#1)
6. **`functions.php`** — add `require_once get_stylesheet_directory() . '/inc/wave2-w2-05.php';`
   (mirror the W2-04 `require_once`, ~line 787).
7. **`template-parts/blocks/block-faq-list.php`** — FAQ category mapping (see §4).
8. **`assets/js/ea-ab-testing.js`** — add a product-CTA handler (see §5). Reuse canonical
   `eyal_cta_variant` key. NO new A/B key.
9. **`style.css`** — bump theme `Version: 1.4.3` → **`1.4.4`**.
10. **`hub/data/site-tree.json`** — under `st-didg-gear-hub` (slug `tools-and-accessories`):
    repoint existing `st-svc-repair` `templateId` `tpl-service` → `tpl-shop-item`; add nodes for
    `didgeridoos`, `bags`, `stands-storage`, `stand-floor`, and `/shop` (`tpl-shop-archive`).
    (Do NOT touch `hub/dist/data/site-tree.json` — generated.)

## 3. Block contract (10 per product page — adapt W2-04 block types)
`hero · what-it-is(prose) · features/how-it-works(prose|steps) · who-it's-for(prose) ·
faq(view-only filtered) · testimonials(placeholder accordion — same as W2-04, grey images, W2-07 carry-forward) ·
**price** · **purchase/contact CTA (matrix §5)** · gallery · closing`.
- **price** block (NEW): render `get_post_meta( get_the_ID(), 'ea_product_price', true )`; if empty →
  literal `מחיר לפי התאמה`. **No hardcoded price values in templates.** Eyal enters via WP admin (C3).
- **gallery** block (NEW): placeholder gallery markup (grey tiles) — real images Eyal/W2-07-era; non-blocking.
- **closing** block: short closing prose + optional secondary link (mirror W2-04 CTA/closing prose).
- Source `.md` files use `### DEV NOTES` + `### התוכן` per SECTION — transcribe the התוכן, honor DEV NOTES
  (e.g., "single H1", "do not look like an e-commerce store", keep lines short).

## 4. FAQ (view-only, category-filtered) — DECISION (deterministic)
The shared `$faq_data` in `block-faq-list.php` currently has NO product categories
(only: treatment, lessons, sound-healing, method, general). Per product page, apply this rule:
- **If the product's source `.md` contains an FAQ/שאלות section** → add a new category key to
  `$faq_categories` (e.g. `didgeridoos`, `bags`, `stands-storage`, `stand-floor`, `repair`) and append
  its Q/A entries (transcribed 1:1) to `$faq_data`; the product page's faq block filters to that key.
- **Else (no product FAQ in source)** → set the faq block `category => 'general'` so the view-only
  block still renders relevant content and AC-02 (full block contract) holds.
Reuse the existing `ea_faq_only_category` arg + view-only branch — do NOT duplicate the dataset, do
NOT add chips/JS. Pass category via `get_template_part(..., array('ea_faq_only_category' => ...))`.

## 5. Purchase/contact CTA matrix (B02) + GA4 — deterministic per product
Per product, resolve in order:
1. **GI URL present** → button `href="<gi-url>" target="_blank" rel="noopener"`; `cta_type=green_invoice`.
2. **No GI URL** (current state for ALL 5 — Eyal-pending) → `href="/contact?subject=product-<slug>"`
   **same tab**; `cta_type=contact`. **Never `#`.**
Always fire GA4 **`product_cta_click`** with params `{ product_slug, cta_type }` (distinct from W2-04's
`cta_click`). The A/B variant (canonical `eyal_cta_variant`: form_only/dual/wa_only) selects form vs
WhatsApp for the **contact** path; WhatsApp → `https://wa.me/972524822842`. Extend `ea-ab-testing.js`
with a `[data-ea-product-cta]` handler (mirror the existing `[data-ea-ab]` block) firing `product_cta_click`.
Store GI URLs in a single per-slug map in `wave2-w2-05-content.php` (all empty now → contact fallback);
wiring real URLs later = one-line-per-product map edit.

## 6. Build → deploy → verify (in the worktree)
- Build in `/Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-05` (branch `feature/w2-05-shop`).
- Deploy: `python3 scripts/ftp_deploy_site_wp_content.py` with cache-bust `?cb=$(date +%s)$RANDOM`.
- Verify all **6 URLs → 200** (cache-busted), 10 blocks per product page, price/fallback on card+page,
  CTA hrefs correct + GA4 wired, `/shop` grid 4-up/2-up with every card linked.
- Run `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` → **0 FAIL**.
- Commit **surgically by file** (never `git add -A`).
- Completion report → `_COMMUNICATION/team_100/` (files changed, AC evidence, ambiguities flagged,
  FAQ §4 decision per product, GI-pending note).

## 7. Cross-engine chain (IR#1 — immutable)
- Builder: team_10 (Claude). L-GATE_BUILD QA: team_50 — **MUST be non-Claude**.
  L-GATE_VALIDATE: team_190 — native Codex/GPT-5.

## 8. Acceptance criteria (gate against — LOD400 AC-01..06)
AC-01 6 URLs 200 · AC-02 full 10-block contract each product page · AC-03 price on card+page (or
fallback) · AC-04 CTA matrix + GA4 `product_cta_click` · AC-05 `/shop` responsive grid, cards linked ·
AC-06 validate_aos.sh 0 FAIL.

## 9. Out of scope
WooCommerce/cart; products not in 25.5.26; wiring real Green Invoice URLs (Eyal-pending → contact fallback).

## 10. Activation prompt (paste into a builder session on team_00 go)
```
You are team_10 (builder) for the AOS eyalamit spoke. Build WP-W2-05 (Shop).
Worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-05 (branch feature/w2-05-shop).
Read this mandate (_COMMUNICATION/team_10/MANDATE-TEAM10-W2-05-SHOP-2026-05-29.md) and the
LOD400 spec (_aos/work_packages/S002/WP-W2-05/LOD400_spec.md) in full FIRST.
This is a 1:1 MIRROR of WP-W2-04: read inc/wave2-w2-04.php, inc/wave2-w2-04-content.php,
page-templates/tpl-service.php, assets/css/w2-04-service.css, assets/js/ea-ab-testing.js and
replicate the pattern. Create tpl-shop-item.php + tpl-shop-archive.php (new), inc/wave2-w2-05.php +
inc/wave2-w2-05-content.php, assets/css/w2-05-shop.css; modify functions.php, block-faq-list.php,
ea-ab-testing.js, style.css (1.4.4), hub/data/site-tree.json. 5 product pages + /shop catalog.
10-block contract; price via ea_product_price post meta (fallback "מחיר לפי התאמה", no hardcoded
prices); CTA matrix B02 (no GI URL yet → /contact?subject=product-<slug>, cta_type=contact) firing
GA4 product_cta_click {product_slug, cta_type}; FAQ view-only per §4 rule. Content 1:1 from the 5
25.5.26 sources (AC-05: normalize clear typos, preserve voice; flag ambiguities). D-14 tokens only,
no raw hex. Deploy via scripts/ftp_deploy_site_wp_content.py (cache-bust ?cb=$(date +%s)$RANDOM).
Verify 6 URLs 200 + blocks + grid. validate_aos.sh 0 FAIL. Commit surgically (NO git add -A).
Report to _COMMUNICATION/team_100/.
```

*team_100 — 2026-05-29 — READY TO DISPATCH on team_00 go.*
