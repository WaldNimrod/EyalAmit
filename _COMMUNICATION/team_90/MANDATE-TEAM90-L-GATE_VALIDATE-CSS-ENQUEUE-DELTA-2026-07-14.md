---
id: MANDATE-TEAM90-L-GATE_VALIDATE-CSS-ENQUEUE-DELTA-2026-07-14
from_team: team_100
to_team: team_90
cc: team_00, team_110, team_50
date: 2026-07-14
type: validate-delta-mandate
wp: WP-CANON-TEMPLATE-UNIFICATION
gate: L-GATE_VALIDATE (focused delta — CSS enqueue hygiene)
builder_engine: cursor-grok-4.5 (team_110)
validator_engine_required: composer-2.5
prior_verdict: _COMMUNICATION/team_90/VERDICT-WP-CANON-L-GATE_VALIDATE-RECHECK-PASS-LOOP-2026-07-14.md
fix_complete: _COMMUNICATION/team_110/FIX-COMPLETE-WP-CANON-CSS-ENQUEUE-2026-07-14.md
mandate_fix: _COMMUNICATION/team_110/MANDATE-TEAM110-WP-CANON-CSS-ENQUEUE-FIX-2026-07-14.md
staging_base: https://eyalamit-co-il-2026.s887.upress.link
---

# MANDATE — team_90 · L-GATE_VALIDATE delta (CSS enqueue)

## Purpose

Focused recheck after team_110 re-homed `w2-05-shop.css` enqueue into `chapters-commerce.php`. Prior VALIDATE recheck was PASS, but independent team_100 review found a live CSS regression that DOM-presence checks missed. **Do not** re-run full V-02…V-07 / LOD400 audit.

Iron Rule #1: validator engine = **composer-2.5** ≠ builder **cursor-grok-4.5**.

## In scope only

| ID | Check | Pass criteria |
|----|-------|----------------|
| D-CSS-01 | Stylesheet loaded | `w2-05-shop.css` present in `<link rel="stylesheet">` on all 5: `/didgeridoos/`, `/bags/`, `/stands-storage/`, `/stand-floor/`, `/repair/` |
| D-CSS-02 | Computed styles | **Not DOM-only.** Via CDP / `getComputedStyle` (or `qa_probe.mjs` / browser tooling): `.ea-product-price` has non-default styled font-size/weight; `.ea-cta-pill--whatsapp` has non-transparent / non-initial background (green/olive fill from CSS). Sample at least `/didgeridoos/` desktop; note mobile if easy. |
| V-01 | QR permanence | `/qr/qr1/` … `/qr/qr48/` all HTTP 200 (48/48) |
| V-06 | Commerce DOM | On a product page: `data-ea-product-cta` (or equivalent product-cta marker), `ea-product-price`, `wa.me` still present |

## Out of scope

Full V-02…V-07 re-audit, LOD400 reopen, `/press` migration, C-5, book gallery image content, Hub.

## Staging notes

- Base: `https://eyalamit-co-il-2026.s887.upress.link` (TLS invalid by design — cert errors are not defects).
- Fix file: `inc/chapters/chapters-commerce.php` → `ea_chapters_w2_05_shop_assets`.

## Output

Write: `_COMMUNICATION/team_90/VERDICT-WP-CANON-L-GATE_VALIDATE-CSS-ENQUEUE-DELTA-2026-07-14.md`

Frontmatter must include: `overall: PASS|FAIL`, `builder_engine`, `validator_engine`, Iron Rule #1 attestation, evidence for each of D-CSS-01, D-CSS-02, V-01, V-06.

`overall: PASS` only if all four in-scope checks pass.
