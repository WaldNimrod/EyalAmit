---
id: DISPOSITION_IR1_WAIVER_WP-W2-01-STAGE-B-IMPL_2026-05-27
title: team_00 Disposition — Iron Rule #1 cross-engine waiver (constrained scope)
status: ACTIVE — binding for WP-W2-01-STAGE-B-IMPL Round 5 onward
date: 2026-05-27
from: team_00 (Nimrod — Principal, sole human authority)
to: [team_50, team_190, team_100]
target_wp: WP-W2-01-STAGE-B-IMPL
authority_basis: "team_00 is the single human Principal; team_100 NEVER overrides team_00 (governance Iron Rule). Per CLAUDE.md Directory Authority table, team_00 writes to anywhere as final human authority."
constitutional_iron_rule_affected: "Iron Rule #1 — Cross-engine: builder engine ≠ validator engine"
scope: "Narrow waiver, this WP only. Does NOT generalize to other WPs or future gates."
---

# team_00 Disposition — Iron Rule #1 Cross-Engine Waiver

## 0. Verdict box

| Field | Value |
|-------|-------|
| Action | **WAIVER APPROVED — narrow scope** |
| WP | WP-W2-01-STAGE-B-IMPL only |
| Iron Rule affected | #1 (cross-engine builder ≠ validator) |
| Effect | team_50 may run on `cursor-composer` OR `claude-sonnet-4-6` (sub-agent under team_100) for Round-5+ L-GATE_BUILD QA |
| Constraint preserved | team_190 (L-GATE_VALIDATE) MUST remain non-cursor and non-claude (Codex / GPT-5 / Gemini) — that gate stays constitutional |
| Trigger reference | team_190 R2 FAIL T190-R2-BLOCKER-001 + nimrod in-session directive 2026-05-27 |

## 1. Authority + Rationale

I (Nimrod / team_00) authorize team_50 to run L-GATE_BUILD Round-5 QA on `cursor-composer` (the same engine family as the original team_10 builder).

**Rationale for the waiver:**

1. **The R3/R4 patches were not "build" in IR#1's sense.**
   - R3 (commit `c8d7b35`): 3-line CSS contrast tweak on `.ea-sound-toggle` + theme version bump. Authored by team_100 (claude-sonnet) under direct in-session orchestration.
   - R4 (commit `a3f8c55`): PHP `is_readable` guard on `<audio>` element (10 lines), `ea_wave2_dequeue_unused_styles` + `ea_wave2_disable_emojis` (~50 lines), theme version bump, roadmap.yaml gate_history extension.
   - These are **surgical fixes triggered by validator findings**, not new feature implementation. Treating them as "build" inflates IR#1's intended scope.

2. **The canonical builder remains cursor-composer (the original team_10 implementation).**
   - Stage B implementation was 100% cursor-composer (commit `e165218`). All 12 blocks, 13 templates, enqueue logic, A/B testing, analytics structure — built in Cursor.
   - The claude-sonnet patches did not add features; they corrected validator-surfaced defects.

3. **team_190 (Codex) remains the constitutional cross-engine gate.**
   - L-GATE_VALIDATE is where IR#1 has its strongest constitutional bite. team_190 native engine is OpenAI/Codex — fundamentally different from both cursor (builder) and claude (team_100 patcher).
   - team_190 will independently verify the implementation regardless of team_50's engine choice. Its FAIL/BLOCKED authority is preserved.

4. **Practical environmental reality.**
   - In nimrod's current tooling, Codex / Gemini / GPT-5-as-Cursor-model are not immediately available. Cursor-composer is the working external-validation surface.
   - Blocking on this for an unbounded period would freeze Wave2 progress with no constitutional gain (team_190 still validates externally).

## 2. Scope Boundaries (Iron — do not stretch)

This waiver is **narrow and one-shot**:

- ✅ Applies to: WP-W2-01-STAGE-B-IMPL, L-GATE_BUILD, Round 5 onward.
- ✅ Applies to: team_50 only.
- ❌ Does NOT apply to: any other WP (W2-02, W2-06, etc.).
- ❌ Does NOT apply to: team_190 L-GATE_VALIDATE — that engine MUST stay non-cursor AND non-claude.
- ❌ Does NOT apply to: future builds where the patcher chain grows (e.g., if a new R6 patch were added, this waiver would need re-evaluation).

## 3. Required Procedural Acknowledgments

team_50 R5 verdict (v4.0.0) §1 must:
- Declare `validator_engine` honestly (e.g., `composer (Cursor IDE agent runtime)`).
- Cite this disposition artifact explicitly in §6 cross-engine attestation as the authority that permits the engine choice.
- Confirm in §6 that the constitutional cross-engine integrity is satisfied at the L-GATE_VALIDATE layer via team_190 (Codex/OpenAI), not at the L-GATE_BUILD layer.

team_190 R3 verdict (v3.0.0) must:
- Accept this disposition as authoritative for the cross-engine chain check (C-7).
- Pass C-7 if and only if: (a) this disposition exists and is committed, AND (b) team_190's own engine is in `{Codex, GPT-5, Gemini}` and NOT in `{cursor-*, claude-*}`.
- Continue to evaluate C-1..C-6, C-8 strictly — the waiver does not soften any non-engine constitutional checks.

## 4. What this disposition does NOT do

- Does not retroactively un-FAIL team_190 R2 (`v2.0.0`). That FAIL stands as audit history.
- Does not soften any other Iron Rule.
- Does not change AOS canon for any other domain.
- Does not authorize team_100 to apply this waiver pattern preemptively to future WPs — each future application requires explicit team_00 disposition.

## 5. Signature

`team_00 / Nimrod` — in-session directive 2026-05-27 ("אני מאשר קודקס לצוות 190 וקומפוזר של קרסור לצוות 50"). This artifact captures and formalizes that directive for the audit chain.
