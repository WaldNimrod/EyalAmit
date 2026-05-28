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
| Floor stand | `/stand-floor` | `tpl-shop-item.php` | `סטנד רצפתי.../stend for playing.md` |
| Repair | `/repair` | `tpl-shop-item.php` | `תיקון כלי דיג'רידו/build didg.md` |
| Catalog | `/shop` | `tpl-shop-archive.php` | unified — 5 product cards |

## Block contract (each product page, 10 blocks)
hero · what-it-is · how-it-works/features · who-it's-for · FAQ (filtered) · testimonials (placeholder until W2-07) · **price** · **purchase/contact CTA (Green Invoice / form per A/B)** · gallery · closing.

## Cross-cutting (reuse W2-02 infra)
`tpl-shop-item.php` + `tpl-shop-archive.php` (both in `ea_wave2_is_active_view` list). Route via slug; set `ea_wave2_shell`. **Prices entered by Eyal via WP admin (C3)** — show "מחיר לפי התאמה" until entered (non-blocking). No WooCommerce/cart. Update `site-tree.json` (+6 nodes).

## Acceptance Criteria
- AC-01: 6 URLs → 200.
- AC-02: each product page renders full block contract.
- AC-03: price shown on catalog card + product page (or "מחיר לפי התאמה" fallback).
- AC-04: purchase button → Green Invoice / form (per A/B variant), GA4-tracked.
- AC-05: `/shop` responsive grid (4-up desktop, 2-up mobile); each card links to its product.
- AC-06: `validate_aos.sh` 0 FAIL.

## Out of scope
WooCommerce / local cart; products not in 25.5.26.

## Gate sequence
L-GATE_ELIGIBILITY → L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190).
