# LOD400 Spec — WP-W2-10 (umbrella)
# UI-Precision — per-cluster hi-fi composition for every non-home route

**WP ID:** WP-W2-10 | **Milestone:** S003 | **Track:** CONTENT (team_35 mockups) + A (team_10 refine) | **Profile:** L0
**Owner:** team_100 (orchestration) | **Executors:** team_35 (mockups) + team_10 (refine) + team_80 (tokens) | **QA:** team_50 → **Validate:** team_190 (Codex)
**Authored:** 2026-05-29 (team_100) | **lod_status:** LOD400 | **status:** PLANNED (team_35 on-demand by team_00 only)
**Process SSoT:** `_COMMUNICATION/team_100/UI-PRECISION-WORK-PACKAGES-LOD200-2026-05-28.md` + `UI-PRECISION-PHASE-PLAN-2026-05-28.md`

## Objective
Every non-home route gets an Eyal-approved visual composition, implemented on the deployed D-14 templates and validated — closing the gap where only the homepage has a reviewed composition. Composition-only: atoms/tokens remain D-14 (team_80 owns the system).

## Children (process in sequence per LOD200 §5)
WP-W2-10-A (Service) → -B (Editorial) → -C (Conversion) → -D (Blog) → -E (Commerce) → -F (EN) → -G (Hero video).

## Canonical 5-stage flow (every child)
| Stage | Owner | Output |
|-------|-------|--------|
| S1 Mockup | team_35 (claude-design sandbox; HANDOFF_PACKAGE → `_COMMUNICATION/team_35/<WP>/`) | hi-fi HTML mockup(s) on REAL migrated content |
| S2 Sign-off | team_00 + Eyal | APPROVE / REVISE (the missing visual gate) |
| S3 Refine | team_10 | apply composition deltas to deployed templates (composition-only; D-14 atoms/tokens unchanged) |
| S4 Token-compliance | team_80 | verify zero ad-hoc drift from D-14 |
| S5 QA→Validate | team_50 (L-GATE_BUILD) → team_190 (L-GATE_VALIDATE) | Puppeteer axe + Lighthouse triple-run + visual screenshots |

## Cross-engine (IR#1)
Builder (team_10/team_35) ≠ team_50 validator; team_190 = native Codex/non-claude. Per team_00 strict disposition 2026-05-28.

## Acceptance Criteria (umbrella)
- AC-U0: all 7 clusters signed off by Eyal + L-GATE_VALIDATE PASS.
- AC-U1: zero D-14 token drift across all refined templates (team_80 verified).
- AC-U2: every route Lighthouse mobile perf ≥ 85 + a11y = 100 (triple-run median).
- AC-U3: every route axe-core 0 critical / 0 serious.
- AC-U4: all children COMPLETE/LOD500_LOCKED → umbrella closes.

## Dependencies / activation
- Content migration content-complete on staging (W2-02 ✓, W2-06 ✓; per-cluster content WPs W2-03/04/05/07/08 for their clusters).
- **Activation:** team_35 invoked ONLY by explicit team_00 instruction (governance team_35 §invocation), AFTER the cluster's content dependency is content-complete.

## Gate sequence (umbrella)
L-GATE_SPEC (this doc + children) → children execute → umbrella CLOSE when all children LOD500_LOCKED → feeds W2-09 cutover-readiness.
