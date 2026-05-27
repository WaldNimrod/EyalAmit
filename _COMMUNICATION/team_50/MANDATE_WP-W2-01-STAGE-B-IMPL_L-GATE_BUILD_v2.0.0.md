---
id: MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0
title: team_50 QA Mandate v2.0.0 — Stage B Impl Round 2 cross-engine final
status: ACTIVE — awaiting dispatch by nimrod to external engine (Codex/GPT-5 OR Gemini)
date: 2026-05-27
from_team: team_100 (architect)
to_team: team_50 (external engine, NOT cursor, NOT claude)
target_wp: WP-W2-01-STAGE-B-IMPL
gate: L-GATE_BUILD
round: 2
phase: 1 (re-run, post-remediation R1-R4)
parent_mandate_v1: ./MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
parent_verdict_r1_fail: ./VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
remediation_plan: ../team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md
in_process_preverdict: ../team_100/PREVERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md
builder_engine: cursor-composer (team_10)
validator_engine_required: "NOT cursor-* AND NOT claude-* — must be truly third engine. Acceptable: Codex / GPT-5 (Cursor agent mode) / Gemini Code Assist / Codex CLI"
profile: L0
implementation_commit: e165218
remediation_commits:
  - 0f71779 (team_99 deploy + smoke page)
  - fb8da63 (A/B drift fix)
target_url: http://eyalamit-co-il-2026.s887.upress.link/wave2-test/
url_note: HTTP only — TLS deferred to M7 (uPress wildcard limitation); TLS is MAJOR finding from Round 1 carried forward, NOT a blocker.
---

# team_50 QA Mandate v2.0.0 — Stage B Impl Round 2 Cross-Engine Final

## 0. Context

Round 1 (cursor validator) returned FAIL — see verdict v1.0.0. Root causes: deploy gap + cross-engine violation + A/B contract drift. Remediation R1–R4 complete (deploy + smoke page + A/B fix + TLS deferred). team_100 ran in-process pre-verdict (Sonnet+Haiku sub-agents) at `../team_100/PREVERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md` — advisory PASS_WITH_FINDINGS (12/14 PASS, 1 FAIL MAJOR on Lighthouse perf, 1 SKIP needing headed browser).

This mandate authorizes a constitutional cross-engine R5 verdict.

## 1. Cross-Engine Constraint (Iron Rule #1)

- **Builder:** cursor-composer (team_10).
- **Round-1 validator:** cursor-composer (VIOLATION — same engine as builder; that's why Round 1 was rejected).
- **Round-2 in-process pre-verdict:** claude-sonnet-4-6 + claude-haiku-4-5 (team_100 architect orchestration — advisory only, NOT a substitute for cross-engine verdict).
- **Round-2 final validator MUST be:**
  - NOT cursor (any variant) — builder engine
  - NOT claude (any variant: opus/sonnet/haiku) — already used for in-process pre-verdict; nimrod directive 2026-05-27 requires *truly third* engine for the final canonical verdict.
  - **Acceptable:** Codex (CLI or Cursor agent mode with GPT-5/o1), Gemini Code Assist, GPT via web with repo access, or any other engine not in the above two families.

If the only available engine is in the forbidden families, the validator MUST stop and report to team_00.

## 2. VC Re-Run List (14 VCs)

The external validator runs all 14 VCs fresh, then compares against the in-process pre-verdict. **Discrepancies are the most valuable finding** — they expose engine-specific bias.

### Carry-forward repo-side VCs (4) — confirm no regression only

| VC | Check | Expected |
|----|-------|----------|
| VC-3 | `ls site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-*.php \| wc -l` | 12 |
| VC-4 | `grep -l "Template Name:" site/wp-content/themes/ea-eyalamit/page-templates/tpl-*.php \| wc -l` | ≥12 (currently 13) |
| VC-13 | `find site/wp-content/themes/ea-eyalamit -name "books-wave1.css"` | empty |
| VC-14 | `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` | 0 FAIL |

### Live-page VCs (10) — fresh execution required

| VC | Check | Pass criterion |
|----|-------|----------------|
| VC-1 | `<link>` tags for ea-tokens, ea-animations, ea-atoms CSS on /wave2-test/ | All 3 present, HTTP 200 |
| VC-2 | 12 blocks rendered on /wave2-test/ | 12 distinct `data-block` markers in HTML |
| VC-5 | RTL declaration | `<html dir="rtl" lang="he-IL">` or equivalent |
| **VC-6** | axe-core wcag2aa scan | 0 critical AND 0 serious violations |
| **VC-7** | Lighthouse mobile | performance ≥85 AND accessibility ≥95 |
| VC-8 | `@media (prefers-reduced-motion: reduce)` in ea-animations.css | Block present in CSS source |
| **VC-9** | Visual RTL — headed browser inspection | Blocks lay out correctly RTL; text alignment, mirror behavior OK |
| **VC-10** | A/B variant assignment in browser | Load 3+ incognito sessions; `sessionStorage.eyal_cta_variant` ∈ {form_only, dual, wa_only}; distribution roughly uniform across multiple visits |
| VC-11 | Footer 3 social links with `target="_blank" rel="noopener noreferrer"` | All 3 confirmed |
| VC-12 | WhatsApp `wa.me/972524822842` link | Confirmed in HTML |

**Critical VCs for external R5 (bolded above):**
- **VC-6, VC-7** — independent tool runs (the in-process Lighthouse measured 81 perf; if the external engine also lands < 85, MAJOR finding stands and team_100 opens a perf tuning WP).
- **VC-9** — first time visual RTL is checked (in-process couldn't; needs headed browser).
- **VC-10** — first time live A/B distribution is checked (in-process verified code only).

## 3. Findings Disposition Rules

Same as Round 1 (mandate v1.0.0 §2):

| Rating | Treatment |
|--------|-----------|
| **BLOCKER** | Stops L-GATE_BUILD PASS. Returns to team_10. |
| **MAJOR** | Documented; team_100 decides advance vs hold. |
| **MINOR** | Documented; non-blocking. |

**Pre-verdict guidance (advisory, do not bind external R5):**
- F-R2-01 (Lighthouse perf 81) → team_100 inclination is MAJOR-not-BLOCKER. External R5 may concur or escalate based on independent re-run.

## 4. Required Deliverables

### Deliverable 1 — VERDICT v2.0.0
File: `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md`

Structure (mandatory):
- §0 verdict box: PASS / PASS_WITH_FINDINGS / FAIL
- §1 hostname + **validator_engine declaration** (MUST state engine name; MUST NOT be cursor-* or claude-*)
- §2 VC table — all 14 VCs (4 carry-forward + 10 fresh)
- §3 Findings (BLOCKER / MAJOR / MINOR) — compare against in-process pre-verdict F-R2-01, F-R2-02, F-R2-03; confirm, retract, or escalate each
- §4 validate_aos.sh result
- §5 evidence files — at minimum:
  - axe JSON (fresh run)
  - Lighthouse HTML + JSON (fresh run)
  - Headed browser screenshots: /wave2-test/ RTL desktop + mobile
  - sessionStorage inspection notes for A/B (VC-10)
- §6 Phase 2 trigger statement (still pending Eyal 3 human gates — non-blocking)
- §7 Cross-engine compliance attestation

### Deliverable 2 — Git commit
Commit message: `qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): {VERDICT} v2 — Team 50 cross-engine`

## 5. Trigger Conditions (verify before starting QA)

1. `curl -I http://eyalamit-co-il-2026.s887.upress.link/wave2-test/` → 200 ✓ (verified 2026-05-27 by team_100)
2. `curl -I http://eyalamit-co-il-2026.s887.upress.link/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css` → 200 ✓
3. git: working tree clean, on main, no pending team_10 patches
4. `validate_aos.sh` → 0 FAIL

All four ✓ as of mandate authoring.

## 6. Authority + Scope Boundaries

- The external session writes to `_COMMUNICATION/team_50/` only (verdict + evidence subfolder).
- The external session does NOT edit `_aos/roadmap.yaml` — gate advance is team_100's act.
- The external session does NOT spawn other agents — single-session QA execution.
- On verdict commit, push and notify team_00. team_100 will reactivate.

## 7. Activation Prompt — copy this verbatim into the external engine session

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_50 only — WP-W2-01-STAGE-B-IMPL R5 Cross-Engine Final QA

Identity: team_50 (QA & Functional Acceptance)
🚨 Engine constraint: NOT cursor-*, NOT claude-*. Must declare engine in §1 of verdict.

Mandate (FIRST READ):
  /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md

Supporting context (read in order):
  1. team_100 in-process pre-verdict:
     _COMMUNICATION/team_100/PREVERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md
  2. Round-1 mandate (VC definitions):
     _COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
  3. Round-1 FAIL verdict (what was broken):
     _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
  4. Remediation plan (R1-R4 already complete):
     _COMMUNICATION/team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md

Working dir: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
Target URL (HTTP — TLS deferred): http://eyalamit-co-il-2026.s887.upress.link/wave2-test/

Task:
  1. Run all 14 VCs from mandate v2.0.0 §2.
  2. Fresh axe-core scan: `npx @axe-core/cli http://eyalamit-co-il-2026.s887.upress.link/wave2-test/ --tags wcag2aa --save _COMMUNICATION/team_50/evidence/axe-r2.json --exit`
  3. Fresh Lighthouse mobile run: `npx lighthouse http://eyalamit-co-il-2026.s887.upress.link/wave2-test/ --form-factor=mobile --only-categories=performance,accessibility --output=json --output=html --output-path=_COMMUNICATION/team_50/evidence/lighthouse-r2 --chrome-flags="--headless=new --no-sandbox" --quiet`
  4. Headed browser inspection (VC-9 + VC-10) — open /wave2-test/ in browser, screenshot RTL layout (desktop + mobile widths), open DevTools and read `sessionStorage.eyal_cta_variant`. Repeat in 3 incognito windows to sample A/B distribution.
  5. Compare results against team_100 pre-verdict. Either:
     - Concur with each finding → cite pre-verdict and confirm.
     - Disagree → document the discrepancy as the most valuable evidence.

Output: _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md
Structure per mandate v2.0.0 §4.

After verdict commit (one commit, message: "qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): {VERDICT} v2 — Team 50 cross-engine") + push, notify team_00.
```

## 8. Version

| Date | Action |
|------|--------|
| 2026-05-27 | Mandate v2.0.0 authored by team_100 after in-process Sonnet+Haiku pre-verdict (12/14 PASS, 1 FAIL MAJOR perf, 1 SKIP visual RTL). External engine dispatch pending nimrod. |
