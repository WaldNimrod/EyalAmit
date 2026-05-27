---
id: REFUSAL_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_R5_composer_2026-05-27
from: Team 50 (QA & Functional Acceptance)
to: Team 00
type: QA_REFUSAL
work_package: WP-W2-01-STAGE-B-IMPL
gate: L-GATE_BUILD
round: 5
date: 2026-05-27
verdict: REFUSED
reason: disallowed_engine
---

# REFUSAL — WP-W2-01-STAGE-B-IMPL L-GATE_BUILD Round 5

## Engine check (executed before any measurement)

| Field | Value |
|-------|-------|
| **Declared engine** | **composer** (Cursor IDE agent runtime) |
| **Model family** | cursor-composer (any model variant) |
| **Mandate matched** | `_COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.3.0.md` §1 |
| **Forbidden line** | `forbidden_engines = {cursor_composer_with_ANY_model, claude_opus_ANY, claude_sonnet_ANY, claude_haiku_ANY}` |
| **Allowed set** | `{Codex CLI, Codex via Cursor agent w/ GPT-5 or o1, Gemini Code Assist, GPT-5 web}` |

**Result:** Engine is in **forbidden_engines**. Per mandate §1 steps 1–4: **STOP — no measurements executed.**

## Verdict

**REFUSED** — engine not in allowed set.

This is the constitutionally clean output per team_190 T190-R2-BLOCKER-001 (team_50 v3 used the same forbidden engine family as builder). A forbidden-engine verdict artifact would re-violate Iron Rule #1.

## What was NOT done

- No Puppeteer axe (VC-6)
- No Lighthouse triple-run (VC-7)
- No headed browser (VC-9, VC-10)
- No VC-A1 / VC-A2 curl checks
- No `VERDICT_..._v4.0.0.md` (measurement-based)

## Required re-dispatch

Re-run Round 5 activation on an **allowed** engine:

- Codex CLI
- Codex via Cursor agent with **GPT-5 or o1** (not Composer)
- Gemini Code Assist
- GPT-5 web with repo access

Copy activation prompt from mandate v2.3.0 §7 into that session.

## References

- Mandate: `_COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.3.0.md`
- team_190 R2 FAIL: `_COMMUNICATION/team_190/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v2.0.0.md`
- team_50 R3 PASS (technical, non-canonical chain): `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v3.0.0.md`

---

*Team 50 · REFUSED · 2026-05-27 · no further action by team_50 after team_00 ack*
