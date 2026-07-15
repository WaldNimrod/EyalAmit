---
id: MANDATE-TEAM110-WP-CANON-CSS-ENQUEUE-FIX-2026-07-14
from_team: team_100
to_team: team_110
cc: team_00, team_90, team_50
date: 2026-07-14
type: scoped-fix-mandate
wp: WP-CANON-TEMPLATE-UNIFICATION
gate: post-VALIDATE hygiene — production-readiness blocker
builder_engine_required: cursor-grok-4.5
prior_completion: _COMMUNICATION/team_110/COMPLETION_REPORT_WP-CANON-TEMPLATE-UNIFICATION_v1.0.0.md
diagnosis_ref: _COMMUNICATION/team_100/HANDOFF_SELF_100_WP-CANON-TEMPLATE-UNIFICATION_2026-07-14_v1.md
priority: HIGH — blocks legitimate production go/no-go
---

# MANDATE — team_110 · WP-CANON CSS enqueue fix (scoped)

## Context

team_110's COMPLETION_REPORT claimed LOD500 / staging GO. Independent team_100 re-check confirmed T1–T6 (except this gap), QR permanence, and C-5 PENDING are solid. **One live blocker remains:** when T6 deleted `inc/wave2-w2-05.php`, the enqueue of `assets/css/w2-05-shop.css` was not re-homed. Only PHP accessors moved to `inc/chapters/chapters-commerce.php`.

**Live on staging today:** all 5 product pages have correct DOM (`ea-product-price`, `ea-cta-ab`, `ea-cta-pill--whatsapp`) but **no** `w2-05-shop.css` in `<link>` — unstyled price + broken CTA layout / WhatsApp button color. DOM-presence QA cannot catch this.

This is **not** a new ADR045 full-execution handoff. One well-diagnosed fix + two awareness items.

## Required (blocking)

1. In [`site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-commerce.php`](../../site/wp-content/themes/ea-eyalamit/inc/chapters/chapters-commerce.php), add a `wp_enqueue_scripts` handler (mirror `ea_chapters_book_purchase_assets`) that enqueues `w2-05-shop.css` **only** when:

   `is_page( array( 'didgeridoos', 'bags', 'stands-storage', 'stand-floor', 'repair' ) )`

   Suggested handle: `ea-w2-05-shop`. Path: `get_stylesheet_directory_uri() . '/assets/css/w2-05-shop.css'`. Version: theme version.

2. Do **not** migrate rules into `chapters.css` in this pass (LOD400 kept `w2-05-shop.css` as the rule source).

3. FTP deploy to staging (`eyalamit-staging-ftp` / project deploy scripts).

4. Prove with curl that `w2-05-shop.css` appears in `<link rel="stylesheet">` on all 5 product URLs under `https://eyalamit-co-il-2026.s887.upress.link/`.

5. Builder engine: **cursor-grok-4.5** (team_00 split). Do not self-sign VALIDATE.

## Awareness (non-blocking — do not silently resolve)

1. **Book galleries:** all three books use `assets/images/kushi-04-sinai.jpg` with caption «רגעים מהדרך». LOD400 declined this file pending Eyal. **Flag to Eyal/team_00** — do not swap images without content sign-off.

2. **COMPLETION_REPORT reconciliation:** working-tree Hebrew rewrite vs committed English at `7767df7`. Produce **one** authoritative `_COMMUNICATION/team_110/COMPLETION_REPORT_WP-CANON-TEMPLATE-UNIFICATION_v1.0.0.md` that:
   - keeps the `7767df7` evidence-artifact table;
   - updates T7 to DONE citing PASS recheck + team_50 E2E PASS artifacts;
   - removes the stale residual «team_90 must return L-GATE_BUILD on a non-Composer engine»;
   - states that production readiness is gated on **this CSS fix + team_90 delta validate** (not claimed ready until those land).

## Exit / handback

File a short fix-complete note to `_COMMUNICATION/team_110/` (e.g. `FIX-COMPLETE-WP-CANON-CSS-ENQUEUE-2026-07-14.md`) with: commit SHA (if committed), FTP done, curl evidence snippet for all 5 URLs, and the two awareness items acknowledged.

team_100 will then dispatch a **focused** team_90 delta validation (CSS loaded + computed styles + V-01/V-06 only) — not a full re-VALIDATE.
