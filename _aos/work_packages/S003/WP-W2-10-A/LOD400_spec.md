# LOD400 Spec — WP-W2-10-A
# UI-Precision — Service cluster (HIGH)

**WP ID:** WP-W2-10-A | **Milestone:** S003 | **Parent:** WP-W2-10 | **Priority:** HIGH | **Profile:** L0
**Executors:** team_35 (mockup) + team_10 (refine) + team_80 (tokens) | **QA:** team_50 (non-Claude) → **Validate:** team_190 (Codex)
**Authored:** 2026-05-29 (team_100) | **lod_status:** LOD400 | **Process SSoT:** UI-PRECISION-WORK-PACKAGES-LOD200 §WP-W2-10-A + PHASE-PLAN

## Objective
Give the service-page archetype (`tpl-service.php`, currently a STUB with 7 unwired D-14 slots) an Eyal-approved hi-fi composition, instantiated on all 4 service routes, with the slots wired by team_10.

## Routes & template
`/treatment`, `/method` (content from W2-02) · `/sound-healing`, `/lessons` (content from W2-04) — all on `tpl-service.php`.

## Composition / slot contract
Archetype = hero + intro + pillars/steps + testimonials + CTA + related. team_10 wires the **7 D-14 slots** so no route falls back to bare `the_content()`. Composition-only; no new atoms; no content rewrite.

## 5-stage flow
S1 team_35 mockup (service archetype on real treatment/method content) → S2 Eyal sign-off → S3 team_10 wire 7 slots across 4 routes → S4 team_80 token-compliance → S5 team_50 QA → team_190 validate.

## Acceptance Criteria
- AC-A1: mockup approved by Eyal (S2 gate recorded).
- AC-A2: all 4 routes render the full slot set (no bare `the_content()`).
- AC-A3: team_80 token-compliance PASS (zero D-14 drift).
- AC-A4: team_50 QA + team_190 validate PASS — Lighthouse mobile perf ≥85 / a11y 100 (triple-run); axe 0 critical/serious on all 4 routes.

## Dependencies
W2-02 (treatment, method) + **W2-04 (sound-healing, lessons)** content-complete on staging. team_35 activated by team_00.

## Gate sequence
L-GATE_SPEC (this doc) → S1–S5 → L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190) → close. Est: mockup 2d + refine 2d + QA 1d.
