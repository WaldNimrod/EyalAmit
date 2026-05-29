# LOD400 Spec — WP-W2-10-D
# UI-Precision — Blog cluster (MED)

**WP ID:** WP-W2-10-D | **Milestone:** S003 | **Parent:** WP-W2-10 | **Priority:** MED | **Profile:** L0
**Executors:** team_35 + team_10 + team_80 | **QA:** team_50 (non-Claude) → **Validate:** team_190 (Codex)
**Authored:** 2026-05-29 (team_100) | **lod_status:** LOD400 | **Process SSoT:** UI-PRECISION-WORK-PACKAGES-LOD200 §WP-W2-10-D

## Objective
Refine the blog archive + single composition on top of W2-06's first build (already L-GATE_VALIDATE PASS), with validated reading typography for long Hebrew posts.

## Routes & templates
`/blog` archive (`tpl-blog-archive.php`) + `/blog/<slug>` single (`tpl-blog-single.php`). Content from W2-06 (COMPLETE).

## Composition contract
Archive = card grid + category filter + pagination. Single = article typography + author/date + related posts + share. Refine on top of the W2-06 build (composition-only). Opportunity: clear the W2-06 P3 (IDEA-006 [vc_row] in archive excerpts) via excerpt shortcode-strip.

## 5-stage flow
S1 mockup (archive + single on real posts) → S2 Eyal sign-off → S3 team_10 refine → S4 team_80 tokens → S5 team_50 QA → team_190 validate.

## Acceptance Criteria
- AC-D1: mockups approved by Eyal.
- AC-D2: archive + single match approved composition.
- AC-D3: reading typography validated for long Hebrew posts (line-length, leading, RTL).
- AC-D4: team_50 QA + team_190 L-GATE_VALIDATE PASS — Lighthouse mobile perf ≥ 85 / a11y 100 (triple-run median); axe 0 critical / 0 serious. (Bonus: IDEA-006 excerpt [vc_row] cleared.)

## Dependencies
W2-06 COMPLETE (✓). team_35 activated by team_00.

## Gate sequence
L-GATE_SPEC → S1–S5 → L-GATE_BUILD → L-GATE_VALIDATE → close. Est: mockup 1.5d + refine 1.5d + QA 1d.
