---
id: MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v1.2.0
title: team_190 Constitutional Validation Mandate v1.2.0 — Round 3 (post-R4 remediation)
status: ARMED — awaiting team_50 v4.0.0 PASS verdict trigger
supersedes: ./MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v1.1.0.md
date: 2026-05-27
from_team: team_100 (architect)
to_team: team_190 (Senior Constitutional Validator)
re_routing_authorization: "team_00 (nimrod) — implicit via in-session 2026-05-27 directive following R4 fix delivery. Your R1 BLOCKED + R2 FAIL stand as canonical audit trail; R3 is a fresh one-shot under v1.2.0."
target_wp: WP-W2-01-STAGE-B-IMPL
gate: L-GATE_VALIDATE
trigger_condition: "_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v4.0.0.md exists with verdict PASS or PASS_WITH_FINDINGS AND §1 declares engine ∉ {cursor-*, claude-*}"
parent_verdict_v1_blocked: ./VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v1.0.0.md
parent_verdict_v2_fail: ./VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v2.0.0.md
parent_mandate_team50_r5: ../team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.3.0.md
r4_fix_evidence:
  - audio_404: ../team_100/PREVERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md
  - perf_triple_run: ../team_100/evidence/lighthouse-r4-triplerun-summary.md
  - roadmap_history: _aos/roadmap.yaml gate_history for WP-W2-01-STAGE-B-IMPL
constitutional_authority: Iron Rule #5
validator_engine_required: "Codex / OpenAI / GPT (team_190 native). MUST NOT be cursor-* (builder family). Continuity with your prior runs preferred."
info_barrier: "Per team_190 governance — independent review. team_50 PASS flag is trigger only."
profile: L0
---

# team_190 Constitutional Validation Mandate v1.2.0 — Round 3

## 0. Re-routing Authorization

Your R2 FAIL (`VERDICT_..._v2.0.0.md`) correctly identified 2 BLOCKER + 2 MAJOR findings. The cross-engine BLOCKER (T190-R2-BLOCKER-001) is fundamentally addressed via the **hardened R5 team_50 mandate** (v2.3.0) with refusal-to-execute on disallowed engine — see §1. The remaining 3 findings have code/data fixes:

| Finding | Fix | Evidence |
|---------|-----|----------|
| T190-R2-MAJOR-002 audio 404 | block-topnav.php now PHP-guards `<audio>` (is_readable + theme-relative URI); live HTML grep for "didgeridoo" returns 0 | (your re-verify) curl `/wave2-test/` |
| T190-R2-BLOCKER-002 perf 83 | `ea_wave2_dequeue_unused_styles` + `ea_wave2_disable_emojis` on Wave2 templates; theme v1.3.9 cache-bust; triple-run Lighthouse 87/87/87 (variance from 7 points to 0) | `_COMMUNICATION/team_100/evidence/lighthouse-r4-triplerun-summary.md` (your re-verify via fresh triple-run) |
| T190-R2-MAJOR-001 roadmap drift | `_aos/roadmap.yaml` `gate_history` now records Rounds 2-3 build + L-GATE_VALIDATE R1-R2 + R4 remediation block; WP `status: IN_VALIDATION`, `current_lean_gate: L-GATE_VALIDATE-REMEDIATION` | (your re-verify) `_aos/roadmap.yaml` itself |

Re-routing authorized by team_00 in-session 2026-05-27 with the directive "fix and re-test, only then present prompts." This is a fresh one-shot under v1.2.0; your prior verdicts are preserved.

## 1. Validation Scope

Same 8 constitutional checks as v1.0.0 §1 + v1.1.0 §1. Round-3 focus on the 3 specific R4 fixes plus full chain re-verification.

### Specific R3 verifications (in addition to v1.0.0 scope)

1. **Cross-engine chain integrity (C-7):** team_50 v4.0.0 §1 MUST declare engine ∈ {Codex, GPT-5, Gemini} AND §6 MUST contain explicit attestation. If §1 violates, return **FAIL** on this check (do not invent a workaround). Your R2 BLOCKER-001 set the binding precedent.
2. **Perf threshold (C-4):** run your OWN Lighthouse triple-run (do not rely on team_100 or team_50 numbers). Pass: avg ≥85 AND each ≥80 AND a11y always 100.
3. **Audio 404 elimination (C-2 component):** curl /wave2-test/ → grep `didgeridoo` returns 0. Also verify no `<audio class="ea-sound-toggle__audio">` element in HTML.
4. **Roadmap correctness (C-6):** `_aos/roadmap.yaml` WP-W2-01-STAGE-B-IMPL must show R2/R3 build entries + L-GATE_VALIDATE R1 BLOCKED + R2 FAIL + R4 remediation block. `status: IN_VALIDATION`.

## 2. Method (locked)

- Puppeteer-injected axe (NOT CLI).
- Lighthouse triple-run minimum, average score, each-run-min check.
- `--ignore-certificate-errors` for Chrome tooling.
- Independent measurements — do NOT use team_50 R5 evidence as your primary source.

## 3. Required Deliverables

### Deliverable 1 — VERDICT v3.0.0
File: `_COMMUNICATION/team_190/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v3.0.0.md`

Same §0..§5 structure as v1.0.0/v2.0.0 deliverables. §0 box first, in chat and in file.

Verdict is **binary**: PASS / FAIL / BLOCKED. No PASS_WITH_FINDINGS.

### Deliverable 2 — Git commit
`validate(WP-W2-01-STAGE-B-IMPL/L-GATE_VALIDATE): {VERDICT} — Team 190`. Push.

## 4. Trigger Verification

Before starting, confirm ALL:
- `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v4.0.0.md` exists.
- That verdict §0 box shows PASS or PASS_WITH_FINDINGS.
- That verdict §1 declares engine ∈ {Codex, GPT-5, Gemini}. **If §1 engine is cursor-* or claude-*, return BLOCKED again** — same procedural posture as your R1.
- git status clean on main.
- `validate_aos.sh` → 0 FAIL.

If any condition fails → return **BLOCKED**. The one-shot rule for v1.2.0 applies (next re-routing requires team_00 auth again).

## 5. Authority Boundaries (unchanged)

- Write only to `_COMMUNICATION/team_190/` (verdict + evidence).
- NEVER write to `_aos/`.

## 6. Activation Prompt — copy verbatim into the external engine session

```
HANDOFF_DEPTH: full
ACTIVATION_SCOPE: team_190 only — WP-W2-01-STAGE-B-IMPL L-GATE_VALIDATE round 3 (re-routed)

Identity: team_190 (Senior Constitutional Validator)
Engine: NOT cursor-*. Use your native Codex/OpenAI engine. Declare in §1.

⚠️ INFO BARRIER: Independent review. team_50 R5 PASS flag triggers you; their reasoning is informational.

Mandate (FIRST READ):
  /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_COMMUNICATION/team_190/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v1.2.0.md

Trigger artifact (read §0 BOX ONLY):
  _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v4.0.0.md
  → §0 verdict must be PASS or PASS_WITH_FINDINGS
  → §1 engine must be ∈ {Codex, GPT-5, Gemini} (NOT cursor-* AND NOT claude-*)
  → If §1 fails this check, return BLOCKED. Do not proceed.

Your prior verdicts (preserved as audit history — do not re-open):
  _COMMUNICATION/team_190/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v1.0.0.md (R1 BLOCKED)
  _COMMUNICATION/team_190/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v2.0.0.md (R2 FAIL)

R4 fix context (informational):
  _COMMUNICATION/team_100/evidence/lighthouse-r4-triplerun-summary.md
  _aos/roadmap.yaml (WP-W2-01-STAGE-B-IMPL gate_history extended)
  git show <latest R4 commit>

Working dir: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
Target URL: https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
TLS: cert expired → use --ignore-certificate-errors.

Tasks (per mandate v1.2.0 §1):
  1. Independent 8-check constitutional review.
  2. Puppeteer-injected axe → _COMMUNICATION/team_190/evidence/axe-validate-r3.json
  3. Lighthouse triple-run HTTPS+cert-bypass → _COMMUNICATION/team_190/evidence/lighthouse-validate-r3-run-N.json
     (avg ≥85 AND each-run ≥80 AND a11y=100 required)
  4. validate_aos.sh → 0 FAIL.
  5. Re-derive: audio 404 eliminated (grep "didgeridoo" = 0), wp-block-library inline absent.
  6. Roadmap.yaml gate_history records R2/R3/L-GATE_VALIDATE R1/R2/R4 chain; status = IN_VALIDATION.

Output: _COMMUNICATION/team_190/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v3.0.0.md
Structure: mandate §3. §0 verdict box FIRST.

Binary verdict: PASS / FAIL / BLOCKED. One-shot.

Commit "validate(WP-W2-01-STAGE-B-IMPL/L-GATE_VALIDATE): {VERDICT} — Team 190". Push. Notify team_00.
```

## 7. Version

| Date | Version | Action |
|------|---------|--------|
| 2026-05-27 | 1.0.0 | First mandate — BLOCKED on procedural |
| 2026-05-27 | 1.1.0 | Re-routed after R3 fix; FAILed on cross-engine + perf + 404 + roadmap |
| 2026-05-27 | 1.2.0 | Re-routed after R4 fixes (audio guard + dequeue + roadmap + hardened R5 mandate). ARMED until team_50 v4.0.0 PASS arrives. |
