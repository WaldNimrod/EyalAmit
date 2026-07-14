---
id: VERDICT-WP-CANON-L-GATE_BUILD-T1-T5-2026-07-14
from_team: team_90
to_team: team_110
cc: team_00, team_100
date: 2026-07-14
type: cross-engine-validation-verdict
wp: WP-CANON-TEMPLATE-UNIFICATION
gate: L-GATE_BUILD (partial — T1, T2, T3, T3b, T5)
mandate: _COMMUNICATION/team_90/MANDATE-TEAM90-L-GATE_BUILD-WP-CANON-TEMPLATE-UNIFICATION-2026-07-14.md
spec: _COMMUNICATION/team_100/WP-CANON-TEMPLATE-UNIFICATION-LOD400-2026-07-14.md
commit_under_review: 5b09255
staging_base: http://eyalamit-co-il-2026.s887.upress.link
builder_engine: cursor-grok-4.5
validator_engine: composer-2.5
overall: PASS_WITH_FINDINGS
method: independent code grep/read + curl HTTP matrix + qa_probe.mjs (CDP, 16 probes)
---

# VERDICT — team_90 · L-GATE_BUILD (T1–T5) · WP-CANON-TEMPLATE-UNIFICATION

**Overall verdict: `PASS_WITH_FINDINGS`**

T1 (Mokesh), T2 (FAQ), T3 (product-cta), T3b (books), and T5 (shop/qr) are **implemented and live on staging** per LOD400. No blockers. Two **minor** doc/orphan-template findings do not block gate progression for this slice.

Iron Rule #1 satisfied: builder `cursor-grok-4.5` (team_110) ≠ validator `composer-2.5` (team_90). All claims below re-verified independently; builder QA artifact not trusted without reproduction.

---

## Task summary

| Task | Verdict | Staging smoke |
|------|---------|---------------|
| T1 Mokesh media + schema | **PASS** | `/eyal-amit/mokesh-dahiman/` HTTP 200 |
| T2 FAQ many-to-many | **PASS** | `/faq/` 490 items; `/treatment/` 45 items |
| T3 product-cta + commerce re-home | **PASS** | `/didgeridoos/` CTA markers present |
| T3b book dual CTAs + schema fields | **PASS** | `/books/vekatavta/` HTTP 200 |
| T5 shop + qr routes + QR matrix | **PASS** | `/shop/`, `/qr/`, `/qr/qr1..qr48/` 48/48 HTTP 200 |

**Independent qa_probe.mjs:** 16/16 PASS (mobile + desktop on `/shop/`, `/qr/`, `/qr/qr2/`, `/eyal-amit/mokesh-dahiman/`, `/didgeridoos/`, `/faq/`, `/treatment/`, `/books/vekatavta/`). Timestamp `2026-07-14T02:34:28.375Z`.

---

## Findings table

| ID | Task | Severity | Finding | Evidence |
|----|------|----------|-----------|----------|
| F90-B01 | T1 | — | **PASS** — Mokesh files exist; route map binds `mokesh-dahiman` → `tpl-chapters-mokesh`; live page renders `mokesh-hero`, `chapters.css`, `ea-mokesh.js`. | `site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/mokesh-hero.php`; `site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-render.php:51`; HTTP 200 + DOM markers on staging |
| F90-B02 | T1 | — | **PASS** — Person + VideoObject gated to mokesh slug only; VideoObject is trailer documentary (`about` → Person `@id`), not muted-hero decoration; no `hero` in VideoObject id/name/description. | `site/wp-content/mu-plugins/ea-w2-seo-schema.php:188-231`; live JSON-LD parse: `has_hero_in_id_or_name: False` |
| F90-B03 | T2 | — | **PASS** — `ea_faq_cat` taxonomy + `ea_faq_query_items()` registered; legacy `faq.php` part deleted; defaults use `faqblock`; seed path exists (`ea-faq-seed.json`, `ea-faq-seed-once.php`, `class-ea-faq-migrate-command.php`). | `site/wp-content/themes/ea-eyalamit/functions.php:326,446`; `template-parts/chapters/parts/faqblock.php`; git: `faq.php` absent under `site/` |
| F90-B04 | T2 | — | **PASS** — Live FAQ corpus non-empty after seed. | `/faq/` → 490× `ea-faq-item`; `/treatment/` → 45× `ea-faq-item`; both show `ea-faq-list` |
| F90-B05 | T3 | — | **PASS** — `product-cta.php` exists; five product defaults reference `product-cta` part; `wave2-w2-05.php` deleted; commerce accessors live in `chapters-commerce.php` (required from `functions.php:790`). | `inc/chapters/defaults/{bags,didgeridoos,repair,stand-floor,stands-storage}-defaults.php`; glob: 0× `wave2-w2-05.php`; staging `/didgeridoos/` → `data-ea-product-cta`, `ea-product-price` |
| F90-B06 | T3b | — | **PASS** — Book defaults carry top-level `price`, `buy_print_url`, `buy_ebook_url`, `genre`, `meta_year`, `meta_pages`; `phero`/`cta` sections include `cta_slug` + dual CTA (`cta2_label`/`cta2_url`); C-5 PENDING comments preserved on tsva. | `vekatavta-defaults.php:17-22,33,120-121`; `tsva-bekahol-defaults.php:18-28,38-44,151-161`; `phero.php:25`, `cta.php:23-27`; staging `/books/vekatavta/` HTTP 200 + `data-ea-book-purchase` |
| F90-B07 | T5 | — | **PASS** — `shop` + `qr` in `ea_chapters_route_map()`; `ea_chapters_pattern_routes()` maps `qr` parent → `tpl-chapters-qr`; QR child matrix 48/48 HTTP 200; Chapters chrome on hub pages. | `chapters-render.php:45-47,68-71`; `page-templates/tpl-chapters-qr.php`; curl loop qr1..qr48 → 48/48 OK; `/shop/`, `/qr/` → `chapters.css`, `ea-chapters` |
| F90-B08 | T5 | — | **PASS** — QR seed mu-plugin untouched in commit `5b09255` (only `ea-faq-seed-once.php`, `ea-w2-seo-schema.php`, `ea-w209-legacy-301-redirects.php` changed under `mu-plugins/`). | `git show 5b09255 --stat -- site/wp-content/mu-plugins/` |
| F90-M01 | T3 | minor | `product-cta.php` file header still cites deleted `inc/wave2-w2-05.php` line numbers and `ea_w2_05_assets()` — runtime is correct via `chapters-commerce.php`; comments are stale. | `template-parts/chapters/parts/product-cta.php:6-17` |
| F90-M02 | — | minor | Orphan `page-templates/tpl-books.php` still calls deleted `ea_w2_05_render_books_archive()`; `/books/` correctly routes via Chapters `muzza` type (not this template). Low risk unless an editor re-assigns the legacy template in wp-admin. | `page-templates/tpl-books.php:31-32`; staging `/books/` renders `chapters-main` + muzza content HTTP 200 |

**Blockers: 0 · Major: 0 · Minor: 2**

---

## Evidence detail (by task)

### T1 — Mokesh

- Files: `mokesh-hero.php`, `fbembeds.php` (used in `mokesh-defaults.php:287`), `tpl-chapters-mokesh.php`.
- Route: `ea_chapters_route_map()['mokesh-dahiman']` → `template: tpl-chapters-mokesh`, `type: mokesh` (`chapters-render.php:51`).
- Staging: HTTP 200; DOM contains `mokesh-hero`, `chapters.css`, `ea-mokesh`.
- Schema: Yoast graph includes `Person` (`#/schema/person/mokesh-dahiman`) and `VideoObject` (`#/schema/video/mukesh-trailer`) with `about` pointing to Person; name is official trailer title, not hero-loop framing.

### T2 — FAQ

- API: `ea_faq_query_items()` at `functions.php:446`; taxonomy `ea_faq_cat` at `functions.php:326`.
- Passthrough: `faqblock.php` → `block-faq-list.php` (uses `ea_faq_query_items`).
- Seed: `site/wp-content/mu-plugins/ea-faq-seed-once.php`, `inc/data/ea-faq-seed.json`, `inc/cli/class-ea-faq-migrate-command.php`.
- Staging corpus populated (490 global FAQ rows on `/faq/`).

### T3 — product-cta

- Part renders Wave2-compatible DOM (`data-ea-product-cta`, `data-product-slug`, `ea-product-price`).
- `wave2-w2-05.php` absent; surviving Wave2 inc files: `wave2-w2-07.php`, `wave2-w2-08.php` only.
- `chapters-commerce.php` provides `ea_w2_05_price()`, `ea_w2_05_gi_url()`, `ea_wave2_wa_url()`.

### T3b — books

- All three book defaults (`vekatavta`, `kushi-blantis`, `tsva-bekahol`) carry top-level commerce/schema fields and dual-CTA sections.
- C-5 PENDING annotations on tsva Mendele URLs per spec (`tsva-bekahol-defaults.php:18-22` et al.) — expected, not a defect.
- Book purchase GA4 script enqueued via `ea_chapters_book_purchase_assets()` in `chapters-commerce.php:67-82`.

### T5 — shop / qr

- Hub routes: `shop` → `type: shop`, `qr` → `type: qr-hub`.
- Child pattern: parent slug `qr` → `tpl-chapters-qr` (`chapters-render.php:70`).
- Full QR HTTP matrix (team_90 independent): **48/48 × HTTP 200** (`/qr/qr1/` … `/qr/qr48/`).
- QR content SSOT `ea-w2-07-qr-content-data.php` not modified in reviewed commit.

---

## Gate recommendation

| Gate slice | Recommendation |
|------------|----------------|
| L-GATE_BUILD T1–T5 | **PROCEED** — implementation matches LOD400 for in-scope tasks |
| Follow-up (non-blocking) | team_110: refresh `product-cta.php` header comments (F90-M01); consider retiring or rewiring `tpl-books.php` (F90-M02) in a later hygiene pass |

T4, T6, T7 were **out of scope** for this partial verdict per mandate; not validated here.

---

## Validator attestation

- **Engine:** composer-2.5 (team_90)
- **Builder under review:** cursor-grok-4.5 (team_110), commit `5b09255`
- **Staging:** `http://eyalamit-co-il-2026.s887.upress.link`
- **Reproduction commands used:** curl smoke + QR matrix; `node …/qa_probe.mjs --base … --paths '/shop/,/qr/,…'`
- **Date:** 2026-07-14
