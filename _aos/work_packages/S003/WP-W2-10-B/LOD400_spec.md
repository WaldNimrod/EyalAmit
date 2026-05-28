# LOD400 Spec — WP-W2-10-B
# UI-Precision — Editorial cluster (HIGH)

**WP ID:** WP-W2-10-B | **Milestone:** S003 | **Parent:** WP-W2-10 | **Priority:** HIGH | **Profile:** L0
**Executors:** team_35 + team_10 + team_80 | **QA:** team_50 (non-Claude) → **Validate:** team_190 (Codex)
**Authored:** 2026-05-29 (team_100) | **lod_status:** LOD400 | **Process SSoT:** UI-PRECISION-WORK-PACKAGES-LOD200 §WP-W2-10-B

## Objective
Long-form editorial archetype (`tpl-content.php`, currently STUB) with an Eyal-approved composition, instantiated on the editorial routes, with a real bio/portrait block (not placeholder avatar).

## Routes & template
`/about` (content W2-02) · `/press` (וכתבת, W2-07) · `/about/moksha` (Moksh, W2-07) — all on `tpl-content.php`.

## Composition contract
Editorial archetype = portrait/bio block + rich body + pullquotes + media gallery + related. 3 route instantiations. Composition-only; D-14 atoms/tokens unchanged.

## 5-stage flow
S1 team_35 mockup (editorial archetype on real about content) → S2 Eyal sign-off → S3 team_10 refine 3 routes → S4 team_80 tokens → S5 team_50 QA → team_190 validate.

## Acceptance Criteria
- AC-B1: mockup approved by Eyal.
- AC-B2: bio/portrait block is REAL (Eyal portrait, not placeholder avatar).
- AC-B3: team_80 token-compliance PASS.
- AC-B4: QA + validate PASS — Lighthouse ≥85/a11y100; axe 0 critical/serious on all 3 routes.

## Dependencies
W2-02 (about) + **W2-07 (press, moksha)** content-complete. team_35 activated by team_00. (Note: `/about/moksha` page exists from W2-02 as ID 181; W2-07 fills final content.)

## Gate sequence
L-GATE_SPEC → S1–S5 → L-GATE_BUILD → L-GATE_VALIDATE → close. Est: mockup 2d + refine 1.5d + QA 1d.
