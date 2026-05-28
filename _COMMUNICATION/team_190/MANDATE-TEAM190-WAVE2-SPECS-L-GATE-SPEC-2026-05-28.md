---
id: MANDATE-TEAM190-WAVE2-SPECS-L-GATE-SPEC-2026-05-28
from_team: team_100 (Chief System Architect)
to_team: team_190 (Final Validator — constitutional, IR#5)
gate: L-GATE_SPEC (spec validation, pre-build)
scope: [WP-W2-03, WP-W2-04, WP-W2-05, WP-W2-07, WP-W2-08, WP-W2-09]
date: 2026-05-28
status: ISSUED — BLOCKING the Wave2 orchestration handoff
---

# L-GATE_SPEC Validation Mandate — Wave2 LOD400 specs (W2-03..W2-09)

**Per team_00 directive (2026-05-28):** the LOD400 specs team_100 authored MUST pass team_190 validation + corrections BEFORE any build is dispatched and BEFORE the team_100 orchestration handoff goes live. This mandate gates `_COMMUNICATION/team_100/HANDOFF_SELF_100_WP-W2-03_2026-05-28_v1.md`.

## §0 — Engine constraint (IR#1)
team_190 MUST run on **native Codex / OpenAI / GPT-5** (≠ claude author of these specs). Confirm engine in line 1.

## §1 — Specs to validate (author: team_100, claude)
| WP | Spec path |
|----|-----------|
| WP-W2-03 (Books) | `_aos/work_packages/S002/WP-W2-03/LOD400_spec.md` |
| WP-W2-04 (Sound/Lessons) | `_aos/work_packages/S002/WP-W2-04/LOD400_spec.md` |
| WP-W2-05 (Shop) | `_aos/work_packages/S002/WP-W2-05/LOD400_spec.md` |
| WP-W2-07 (Press/Moksha/QR/Testimonials) | `_aos/work_packages/S002/WP-W2-07/LOD400_spec.md` |
| WP-W2-08 (EN landing) | `_aos/work_packages/S002/WP-W2-08/LOD400_spec.md` |
| WP-W2-09 (Cutover prep) | `_aos/work_packages/S002/WP-W2-09/LOD400_spec.md` |

(Out of scope: WP-W2-02 spec — already validated in its L-GATE_VALIDATE R2 PASS. WP-W2-06 spec — validates within W2-06's own L-GATE_VALIDATE after re-QA.)

## §2 — Validation criteria (LOD400 precision gate)
For each spec, assess:
1. **LOD400 precision** — sufficient for a fresh agent/junior dev to implement WITHOUT gaps, guesses, or assumptions (per_page templates, block contracts, ACs, content-source paths all present and resolvable).
2. **Content-source resolution** — every referenced 25.5.26 `.md` path exists and matches the page.
3. **Cross-cutting correctness** — routing pattern (template_include @100 + `ea_wave2_shell`), D-14 reuse, IR#1 chain, branch isolation, dependency declarations are correct and consistent with the W2-02 precedent.
4. **AC measurability** — ≥3 measurable ACs per WP; ACs map to the deliverables.
5. **Scope/dependency integrity** — IN/OUT scope clean; depends_on correct (all depend on W2-02 COMPLETE except W2-09 on all).

## §3 — Deliverable
Per-spec verdict (PASS / PASS_WITH_FINDINGS / BLOCKED) + specific correction items, written to `_COMMUNICATION/team_190/VERDICT-WAVE2-SPECS-L-GATE-SPEC-2026-05-28.md`.
- team_100 applies corrections, re-submits any BLOCKED specs.
- **Only when all 6 specs reach PASS (or PASS_WITH_FINDINGS, no blocking gaps)** does team_100 activate the orchestration handoff and dispatch WP-W2-03.

*team_100 — 2026-05-28*
