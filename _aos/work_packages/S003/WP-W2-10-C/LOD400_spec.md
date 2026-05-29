# LOD400 Spec — WP-W2-10-C
# UI-Precision — Conversion cluster (MED)

**WP ID:** WP-W2-10-C | **Milestone:** S003 | **Parent:** WP-W2-10 | **Priority:** MED | **Profile:** L0
**Executors:** team_35 + team_10 + team_80 | **QA:** team_50 (non-Claude) → **Validate:** team_190 (Codex)
**Authored:** 2026-05-29 (team_100) | **lod_status:** LOD400 | **Process SSoT:** UI-PRECISION-WORK-PACKAGES-LOD200 §WP-W2-10-C

## Objective
Polish the conversion routes (templates already REAL — fast win) and resolve the CF7 `form_id=0` wiring as part of refinement.

## Routes & template
`/contact` (`tpl-contact.php` — REAL but CF7 `form_id=0`) · `/faq` (`tpl-faq.php` — REAL, filter UI). Content from W2-02.

## Composition contract
Contact composition = form + WhatsApp A/B variants (per WP-W2-01 ea-ab-testing) + trust signals. FAQ composition = category/tag filter polish. Wire the real CF7 form id via `add_filter('ea_wave2_cf7_form_id', fn()=><ID>)` once Eyal creates the form.

## 5-stage flow
S1 mockup (contact + faq) → S2 Eyal sign-off → S3 team_10 refine + CF7 wiring → S4 team_80 tokens → S5 team_50 QA → team_190 validate.

## Acceptance Criteria
- AC-C1: mockups approved by Eyal.
- AC-C2: CF7 form renders (form_id ≠ 0) on `/contact` (depends on Eyal creating the form — Phase-2-adjacent; if not yet created, AC-C2 carries forward with documented dependency).
- AC-C3: FAQ filter UX validated (category select filters; URL state).
- AC-C4: team_50 QA + team_190 L-GATE_VALIDATE PASS — Lighthouse mobile perf ≥ 85 / a11y 100 (triple-run median); axe 0 critical / 0 serious.

## Dependencies
W2-02 content-complete (✓) + CF7 form configured by Eyal (for AC-C2). team_35 activated by team_00.

## Gate sequence
L-GATE_SPEC → S1–S5 → L-GATE_BUILD → L-GATE_VALIDATE → close. Est: mockup 1.5d + refine 1d + QA 0.5d.
