# LOD400 Spec — WP-W2-10-E
# UI-Precision — Commerce cluster (HIGH, asset-gated)

**WP ID:** WP-W2-10-E | **Milestone:** S003 | **Parent:** WP-W2-10 | **Priority:** HIGH | **Profile:** L0
**Executors:** team_35 + team_10 + team_80 | **QA:** team_50 (non-Claude) → **Validate:** team_190 (Codex)
**Authored:** 2026-05-29 (team_100) | **lod_status:** LOD400 | **Process SSoT:** UI-PRECISION-WORK-PACKAGES-LOD200 §WP-W2-10-E

## Objective
Product/book card + detail archetypes with an Eyal-approved composition, across the commerce routes, with a verified placeholder→real-asset swap path.

## Routes & templates
`/books` + 3 book details (`tpl-books.php`, `tpl-book-detail.php`, content W2-03) · `/shop` + 5 product items (`tpl-shop-archive.php`, `tpl-shop-item.php`, content W2-05).

## Composition contract
Card archetype = cover/image + title + price + Green Invoice CTA. Detail archetype = gallery + description + buy CTA + related. **Asset-gated:** real cover/product images + Green Invoice links pending Eyal → mock with placeholders, swap on delivery.

## 5-stage flow
S1 mockup (card + detail archetypes, placeholders) → S2 Eyal sign-off → S3 team_10 refine across books+shop routes → S4 team_80 tokens → S5 team_50 QA → team_190 validate. Asset-swap = follow-up when Eyal delivers.

## Acceptance Criteria
- AC-E1: mockups approved by Eyal.
- AC-E2: catalogue (`/books`, `/shop`) + detail routes render the archetypes.
- AC-E3: placeholder→real-asset swap path verified (documented + tested with a sample).
- AC-E4: Green Invoice CTA wired per the W2-03/W2-05 CTA matrix (when links arrive; fallback `/contact?subject=...` until then).
- AC-E5: team_50 QA + team_190 L-GATE_VALIDATE PASS — Lighthouse mobile perf ≥ 85 / a11y 100 (triple-run median); axe 0 critical / 0 serious.

## Dependencies
**W2-03 (books) + W2-05 (shop)** content-complete; Eyal media + Green Invoice links for final assets. team_35 activated by team_00.

## Gate sequence
L-GATE_SPEC → S1–S5 → L-GATE_BUILD → L-GATE_VALIDATE → close. Est: mockup 2.5d + refine 2d + QA 1d (+ asset-swap follow-up).
