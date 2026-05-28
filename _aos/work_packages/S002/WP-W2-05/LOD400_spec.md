# LOD400 Spec — WP-W2-05
# Shop — 4 Products + Repair + Unified /shop Catalog

**WP ID:** WP-W2-05 | **Track:** A | **Milestone:** S002 | **Profile:** L0
**Owner/Builder:** team_10 | **L-GATE_BUILD:** team_50 (non-Claude) | **L-GATE_VALIDATE:** team_190 (Codex)
**Depends on:** WP-W2-02 (COMPLETE — template + tokens) | **Authored:** 2026-05-28 (team_100) | **lod_status:** LOD400

## Objective
5 product/service pages + a unified `/shop` catalog live on staging, with prices and Green Invoice purchase/contact CTA. Measurable: 6 URLs 200, each product page renders the full block contract, price shown on card + page.

## Pages & sources (25.5.26 — `כלים למכירה/` etc.)
| Page | URL | Template | Source (.md) |
|------|-----|----------|--------------|
| Didgeridoos | `/didgeridoos` | `tpl-shop-item.php` | `כלים למכירה/buy didgeridoo.md` |
| Bags | `/bags` | `tpl-shop-item.php` | `תיקים לדיג'רידו/bags for didg.md` |
| Stands (storage) | `/stands-storage` | `tpl-shop-item.php` | `סטנדים לדיג'רידו לאחסון/stend for hanging.md` |
| Floor stand | `/stand-floor` | `tpl-shop-item.php` | `סטנד רצפתי לנגינה בישיבה נמוכה/stend for playing.md` |
| Repair | `/repair` | `tpl-shop-item.php` | `תיקון כלי דיג'רידו/build didg.md` |
| Catalog | `/shop` | `tpl-shop-archive.php` | unified — 5 product cards |

## Block contract (each product page, 10 blocks)
hero · what-it-is · how-it-works/features · who-it's-for · FAQ (filtered) · testimonials (placeholder until W2-07) · **price** · **purchase/contact CTA (Green Invoice / form per A/B)** · gallery · closing.

## Cross-cutting (reuse W2-02 infra)
`tpl-shop-item.php` + `tpl-shop-archive.php` (both in `ea_wave2_is_active_view` list). Route via slug; set `ea_wave2_shell`. No WooCommerce/cart. Update `site-tree.json` (+6 nodes).

## Purchase/contact CTA matrix (B02 — deterministic per product)
Each product page CTA resolves in this order: (1) if a Green Invoice URL exists for the product → button opens it in a **new tab** (`target="_blank" rel="noopener"`); (2) if no GI URL → button routes to `/contact?subject=product-<slug>` (**same tab**). In BOTH cases fire GA4 event `product_cta_click` with params `product_slug` + `cta_type` (`green_invoice`|`contact`). A/B variant (per WP-W2-01 ea-ab-testing) selects form vs WhatsApp for the contact path: WhatsApp → `https://wa.me/972524822842`. Green Invoice URLs are Eyal-provided (per-product); absence is the fallback above, never `#`.

## Prices (F03)
Price source = post meta key **`ea_product_price`** on each product page (Eyal enters via WP admin, C3). Render on catalog card + product page. If `ea_product_price` empty → display literal fallback "מחיר לפי התאמה" (non-blocking). No hardcoded price values in templates.

## Acceptance Criteria
- AC-01: 6 URLs → 200.
- AC-02: each product page renders full block contract.
- AC-03: price shown on catalog card + product page (or "מחיר לפי התאמה" fallback).
- AC-04: purchase button behaves per the **Purchase/contact CTA matrix** above (GI new-tab if URL present, else `/contact?subject=product-<slug>`; never `#`); fires GA4 `product_cta_click` with `product_slug`+`cta_type`.
- AC-05: `/shop` responsive grid (4-up desktop, 2-up mobile); each card links to its product.
- AC-06: `validate_aos.sh` 0 FAIL.

## Out of scope
WooCommerce / local cart; products not in 25.5.26.

## Gate sequence
L-GATE_ELIGIBILITY → L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190).
