# LOD400 Spec — WP-W2-10-F
# UI-Precision — EN landing (HIGH, direction-flip risk)

**WP ID:** WP-W2-10-F | **Milestone:** S003 | **Parent:** WP-W2-10 | **Priority:** HIGH | **Profile:** L0
**Executors:** team_35 + team_10 + team_80 | **QA:** team_50 (non-Claude) → **Validate:** team_190 (Codex)
**Authored:** 2026-05-29 (team_100) | **lod_status:** LOD400 | **Process SSoT:** UI-PRECISION-WORK-PACKAGES-LOD200 §WP-W2-10-F

## Objective
LTR composition for `/en` (`tpl-en-landing.php`, STUB) — an LTR mirror of the RTL system — with validated logical-property mirroring and EN typography.

## Route & template
`/en` on `tpl-en-landing.php`. Content from W2-08.

## Composition contract
LTR composition of the 6 EN sections (per W2-08 spec). Validate logical properties (`margin-inline`, `padding-inline`, `start/end`) flip correctly RTL→LTR; EN typography (latin font stack, line-length). Isolate direction-flip risk.

## 5-stage flow
S1 mockup (LTR `/en` on real W2-08 EN content) → S2 Eyal sign-off → S3 team_10 refine → S4 team_80 tokens → S5 team_50 QA (incl. RTL/LTR mirror) → team_190 validate.

## Acceptance Criteria
- AC-F1: mockup approved by Eyal.
- AC-F2: LTR layout correct — no RTL bleed (logical-property mirroring verified).
- AC-F3: a11y + RTL/LTR mirror QA PASS.
- AC-F4: team_50 QA + team_190 L-GATE_VALIDATE PASS — Lighthouse mobile perf ≥ 85 / a11y 100 (triple-run median); axe 0 critical / 0 serious.

## Dependencies
**W2-08 (EN landing)** content-complete (itself gated on team_30 EN content). team_35 activated by team_00.

## Gate sequence
L-GATE_SPEC → S1–S5 → L-GATE_BUILD → L-GATE_VALIDATE → close. Est: mockup 2d + refine 1.5d + QA 1d.
