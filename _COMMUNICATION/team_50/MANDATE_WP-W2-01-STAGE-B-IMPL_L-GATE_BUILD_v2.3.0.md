---
id: MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.3.0
title: team_50 QA Mandate v2.3.0 — Round 5 (post-team_190-FAIL remediation)
status: ACTIVE — ready for dispatch by nimrod
supersedes: ./MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.2.0.md
date: 2026-05-27
from_team: team_100 (architect)
to_team: team_50 (external engine — STRICTLY NOT cursor-*, NOT claude-*)
target_wp: WP-W2-01-STAGE-B-IMPL
gate: L-GATE_BUILD
round: 5 (after team_190 v2 FAIL on cross-engine chain + perf + 404 + roadmap)
parent_round_3_pass: ./VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v3.0.0.md
parent_team_190_fail: ../team_190/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v2.0.0.md
parent_team_190_notice: ../team_190/NOTICE_TO_TEAM_00_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_FAIL_2026-05-27.md
in_process_r4_evidence: ../team_100/evidence/lighthouse-r4-triplerun-summary.md
builder_chain: cursor-composer (original) + claude-sonnet-4-6 (R3+R4 patches)
validator_engine_required_strict: "MUST be in {Codex CLI, Codex via Cursor agent (GPT-5/o1 model), Gemini Code Assist, GPT-5 web with repo access}. MUST NOT be cursor-composer (any model). MUST NOT be claude-* (opus/sonnet/haiku). Refusal-to-execute mandated if disallowed engine — see §1."
profile: L0
target_url: https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
target_url_note: TLS cert expired (M7 deferred). Use --ignore-certificate-errors for Chrome.
---

# team_50 QA Mandate v2.3.0 — Round 5

## 0. Context

team_190 L-GATE_VALIDATE Round 2 returned **FAIL** with the binding finding **T190-R2-BLOCKER-001**: team_50 v3.0.0 declared `validator_engine` = `composer (Cursor IDE agent runtime)` — same family as builder cursor-composer, violating Iron Rule #1 cross-engine integrity. team_190 stopped on that violation even though all measurements were correct.

The technical content of team_50 R3 (your Puppeteer axe finding + your VC-1..14 PASS) **remains canonical evidence** and is incorporated into the R4 remediation. The R5 dispatch exists to satisfy the cross-engine chain requirement that team_190 enforced.

team_100 has additionally fixed 3 of the 4 team_190 findings in commits since R3:
- T190-R2-MAJOR-002 (audio 404) → block-topnav.php PHP-guards `<audio>` element; live 404 eliminated.
- T190-R2-BLOCKER-002 (Lighthouse perf 83) → `ea_wave2_dequeue_unused_styles` + emoji disable; triple-run Lighthouse landed 87/87/87 — variance collapsed from 7 points to 0; stable above ≥85.
- T190-R2-MAJOR-001 (roadmap drift) → `_aos/roadmap.yaml` `gate_history` now records R2, R3, L-GATE_VALIDATE R1+R2, and this R4 remediation block.

Your R5 job: independently re-validate. Concur or dispute.

## 1. ENGINE CONSTRAINT — HARD STOP

This is enforced as a refusal precondition (not a soft preference):

```
allowed_engines = {Codex_CLI, Codex_via_Cursor_agent_with_GPT5_or_o1,
                   Gemini_Code_Assist, GPT5_web_with_repo}
forbidden_engines = {cursor_composer_with_ANY_model,
                     claude_opus_ANY, claude_sonnet_ANY, claude_haiku_ANY}
```

**If your engine is in `forbidden_engines`:**
1. STOP. Do NOT measure anything. Do NOT touch any file.
2. Open `_COMMUNICATION/team_50/REFUSAL_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_R5_<engine>_2026-05-27.md` and write:
   - `verdict: REFUSED — engine not in allowed set`
   - your engine name + model
   - the line in this mandate you matched against
3. Commit "qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): REFUSED — Team 50 R5 — disallowed engine". Push.
4. Notify team_00. EXIT.

Rationale: team_190 R2 BLOCKER-001 made the cost of running with the wrong engine higher than the cost of stopping. A refusal artifact is the constitutionally clean output; a forbidden-engine verdict is not.

## 2. VC Re-Run List (after refusal check)

If the engine check passes, run all 14 VCs fresh. R3 evidence stands as carry-forward only if your engine confirms.

| VC | Method | Pass criterion | Source for in-process expectation |
|----|--------|----------------|-----------------------------------|
| VC-1 | curl + HTML inspect | 3 `<link>` to ea-tokens/animations/atoms.css | live: confirmed |
| VC-2 | DOM scan for `data-block` | 12 distinct values | live: confirmed |
| VC-3..4 | repo `ls`/`grep` | 12 blocks, 13 templates | confirmed (carry-forward) |
| VC-5 | curl + grep `<html dir="rtl"` | present | confirmed |
| **VC-6** | **Puppeteer-injected axe** (NOT @axe-core/cli — known broken under TLS-redirect) | 0 critical AND 0 serious; `.ea-sound-toggle` absent | in-process R4: 0/0 |
| **VC-7** | **Lighthouse mobile HTTPS+cert-bypass — 3 runs minimum, take average** | avg ≥85 AND each run ≥80 AND a11y always 100 | in-process R4 triple-run: 87/87/87 (stable) |
| VC-8 | curl ea-animations.css + grep `prefers-reduced-motion` | block present | confirmed |
| VC-9 | Puppeteer headed-mode screenshot (desktop 1440×900 + mobile 390×844) | RTL layout valid both viewports | confirmed via R3 evidence |
| VC-10 | Puppeteer + sessionStorage read | 6+ trials, all valid variants, ≥2 distinct | confirmed via R3 evidence |
| VC-11 | curl + grep social links | 3 links FB/IG/YT with `target="_blank" rel="noopener noreferrer"` | confirmed |
| VC-12 | curl + grep WhatsApp | `wa.me/972524822842` present | confirmed |
| VC-13 | curl on books-wave1.css | HTTP 404 | confirmed |
| VC-14 | bash `validate_aos.sh .` | 0 FAIL | confirmed: 30/18/0 |

**Additional R5-specific checks (from team_190 findings):**
- VC-A1 (new) — `/assets/audio/didgeridoo-ambient.mp3` is NOT referenced in live HTML. Method: `curl /wave2-test/ | grep -c "didgeridoo"` → 0.
- VC-A2 (new) — wp-block-library inline-css is NOT in live HTML on /wave2-test/. Method: `curl | grep -c "wp-block-library-inline-css"` → 0.

## 3. Methodology (locked by team_190 R2 + R4 evidence)

- **Axe:** Puppeteer-injected, NEVER `@axe-core/cli`.
- **Lighthouse:** minimum 3 runs with cache-bust query (`?cb=<timestamp>`); report avg + spread; PASS criterion uses avg ≥85 AND each-run ≥80.
- **TLS:** `--ignore-certificate-errors --allow-running-insecure-content`; HTTPS URL direct.

## 4. Required Deliverables

### Deliverable 1 — VERDICT v4.0.0
File: `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v4.0.0.md`

Structure:
- §0 verdict box: PASS / PASS_WITH_FINDINGS / FAIL / **REFUSED**
- §1 hostname + **validator_engine declaration** with the EXACT model name (e.g. "Codex CLI o1-2024-11-20" or "Gemini Code Assist gemini-2.0-pro"); MUST satisfy §1 allowed set.
- §2 VC table — VC-1..14 + VC-A1 + VC-A2 (16 rows total).
- §3 Findings — concur/dispute against team_190 R2 findings + team_100 R4 fixes.
- §4 validate_aos.sh result.
- §5 evidence files (Puppeteer axe JSON, Lighthouse triple-run JSONs, screenshots).
- §6 Cross-engine compliance attestation: state explicitly "engine ∉ {cursor-*, claude-*}" and quote the verdict §1 declaration.

### Deliverable 2 — Git commit
`qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): {VERDICT} v4 — Team 50 cross-engine`. Push.

## 5. Trigger Conditions (verified by team_100 2026-05-27)

| Condition | Status |
|-----------|--------|
| All R4 fixes committed + pushed | ✓ (commit ahead of HEAD) |
| `<audio>` element gone from live HTML | ✓ (verified by curl, count=0) |
| wp-block-library inline-css gone from live HTML | ✓ (verified by curl) |
| Triple-run Lighthouse stable ≥85 in-process | ✓ (87/87/87) |
| `_aos/roadmap.yaml` reflects R2/R3/L-GATE_VALIDATE history | ✓ |
| `validate_aos.sh` 0 FAIL | ✓ |
| team_190 R2 FAIL artifacts present (for your concur/dispute reference) | ✓ |

## 6. Authority Boundaries

- Writes only to `_COMMUNICATION/team_50/` (verdict + evidence subfolder + optional REFUSAL artifact).
- DO NOT edit `_aos/roadmap.yaml`.
- DO NOT spawn other agents.

## 7. Activation Prompt — copy verbatim into the external engine session

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_50 only — WP-W2-01-STAGE-B-IMPL L-GATE_BUILD R5 cross-engine

Identity: team_50 (QA & Functional Acceptance)

🚨 HARD ENGINE CHECK — RUN FIRST, before reading anything else:

   Your engine MUST be in {Codex CLI, Codex via Cursor agent w/ GPT-5 or o1,
                           Gemini Code Assist, GPT-5 web}.
   Your engine MUST NOT be {cursor-composer ANY model, claude-* ANY model}.

   If your engine is forbidden:
     1. Write _COMMUNICATION/team_50/REFUSAL_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_R5_<engine>_2026-05-27.md
        (verdict: REFUSED, your engine name, line matched).
     2. Commit "qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): REFUSED — Team 50 R5 — disallowed engine"
     3. Push. Notify team_00. EXIT.
   Refusal is the constitutionally clean output. Do NOT proceed to measurement.

If engine check passes, continue:

Mandate (FIRST READ):
  /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.3.0.md

Supporting context (read in order):
  1. team_190 R2 FAIL verdict (why this round exists):
     _COMMUNICATION/team_190/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v2.0.0.md
  2. Your R3 PASS (technical work — incorporated as carry-forward):
     _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v3.0.0.md
  3. team_100 R4 fix evidence (perf triple-run; 87/87/87):
     _COMMUNICATION/team_100/evidence/lighthouse-r4-triplerun-summary.md
  4. R4 commit (audio guard + dequeue + roadmap):
     git show HEAD  (the latest commit before this dispatch)

Working dir: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
Target URL: https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
TLS: cert expired → use --ignore-certificate-errors.

Task (per mandate v2.3.0 §2 + §3):
  1. Puppeteer-injected axe (NOT CLI):
     Output: _COMMUNICATION/team_50/evidence/axe-r5-puppeteer.json
     Pass: 0 critical AND 0 serious.
  2. Lighthouse triple-run mobile HTTPS+bypass:
     for N in 1 2 3; do
       npx lighthouse https://eyalamit-co-il-2026.s887.upress.link/wave2-test/?cb=$(date +%s%N) \
         --form-factor=mobile --only-categories=performance,accessibility \
         --output=json \
         --output-path=_COMMUNICATION/team_50/evidence/lighthouse-r5-run-${N}.json \
         --chrome-flags="--headless=new --no-sandbox --ignore-certificate-errors --allow-running-insecure-content" \
         --quiet
     done
     Compute avg + each-run-min. Pass: avg ≥85 AND each-run ≥80 AND a11y always 100.
  3. Headed browser for VC-9 (screenshots) + VC-10 (sessionStorage A/B across 6 incognito sessions).
  4. VC-A1: curl /wave2-test/ → grep -c "didgeridoo" must be 0.
  5. VC-A2: curl /wave2-test/ → grep -c "wp-block-library-inline-css" must be 0.

Output: _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v4.0.0.md
Structure per mandate v2.3.0 §4. §6 cross-engine attestation MANDATORY.

Commit "qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): {VERDICT} v4 — Team 50 cross-engine". Push.
Notify team_00.
```

## 8. Version

| Date | Version | Action |
|------|---------|--------|
| 2026-05-27 | 2.0.0 | Initial external mandate |
| 2026-05-27 | 2.1.0 | Post-in-process-PASS dispatch (FAILed on VC-6 contrast — team_50 found bug; great catch) |
| 2026-05-27 | 2.2.0 | Post-contrast-fix dispatch (PASSed but team_50 ran on Cursor — IR#1 violation surfaced by team_190 R2) |
| 2026-05-27 | 2.3.0 | Post-team_190-R2-FAIL dispatch with HARD engine refusal precondition + triple-run Lighthouse methodology + 2 new VCs (VC-A1 audio, VC-A2 block-library) |
