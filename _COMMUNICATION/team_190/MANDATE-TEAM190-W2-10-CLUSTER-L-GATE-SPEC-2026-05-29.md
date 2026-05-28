---
id: MANDATE-TEAM190-W2-10-CLUSTER-L-GATE-SPEC-2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_190 (Final Validator — constitutional, IR#5)
gate: L-GATE_SPEC (spec validation)
scope: [WP-W2-10, WP-W2-10-A, WP-W2-10-B, WP-W2-10-C, WP-W2-10-D, WP-W2-10-E, WP-W2-10-F, WP-W2-10-G]
milestone: S003 (UI Precision)
date: 2026-05-29
status: ISSUED
---

# L-GATE_SPEC Validation Mandate — UI-Precision cluster (WP-W2-10 + A–G)

Completes the goal "every W2 package spec-validated." The S002 content WPs (W2-02..09) are spec-validated/closed; this validates the S003 UI-Precision cluster, newly elevated from LOD200 to LOD400 LOD400 specs by team_100.

## §0 — Engine constraint (IR#1)
team_190 MUST run on **native Codex / OpenAI / GPT-5** (≠ claude author). Confirm engine in line 1. Prove tree: `git log --oneline -1` should be the current HEAD.

## §1 — Specs to validate (author: team_100)
| WP | Spec |
|----|------|
| WP-W2-10 (umbrella) | `_aos/work_packages/S003/WP-W2-10/LOD400_spec.md` |
| WP-W2-10-A (Service) | `_aos/work_packages/S003/WP-W2-10-A/LOD400_spec.md` |
| WP-W2-10-B (Editorial) | `_aos/work_packages/S003/WP-W2-10-B/LOD400_spec.md` |
| WP-W2-10-C (Conversion) | `_aos/work_packages/S003/WP-W2-10-C/LOD400_spec.md` |
| WP-W2-10-D (Blog) | `_aos/work_packages/S003/WP-W2-10-D/LOD400_spec.md` |
| WP-W2-10-E (Commerce) | `_aos/work_packages/S003/WP-W2-10-E/LOD400_spec.md` |
| WP-W2-10-F (EN) | `_aos/work_packages/S003/WP-W2-10-F/LOD400_spec.md` |
| WP-W2-10-G (Hero video) | `_aos/work_packages/S003/WP-W2-10-G/LOD400_spec.md` |

Process SSoT (context): `_COMMUNICATION/team_100/UI-PRECISION-WORK-PACKAGES-LOD200-2026-05-28.md` + `UI-PRECISION-PHASE-PLAN-2026-05-28.md`.

## §2 — Validation criteria (LOD400 precision gate)
Per spec: (1) implementability — routes, template state, 5-stage flow with owners, composition/slot contract, measurable ACs (incl. Lighthouse ≥85/a11y100 triple-run + axe 0 critical/serious) all present; (2) dependency integrity — content-WP dependencies + team_35 activation rule correct; (3) cross-engine chain (team_35/team_10 builder ≠ team_50 ≠ team_190); (4) composition-only scope (no new atoms / no D-14 drift); (5) asset-gating declared where applicable (E commerce assets, G hero video, C CF7 form_id).

## §3 — Deliverable
Per-spec verdict (PASS / PASS_WITH_FINDINGS / BLOCKED) + corrections → `_COMMUNICATION/team_190/VERDICT-W2-10-CLUSTER-L-GATE-SPEC-2026-05-29.md`. team_100 applies corrections + re-submits any BLOCKED. On all-PASS, ALL W2 packages (S002 + S003) are spec-validated.

*team_100 — 2026-05-29*
