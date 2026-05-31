---
id: MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v1.0.0
title: team_190 Constitutional Validation Mandate — Stage B Implementation
status: ARMED — awaiting team_50 L-GATE_BUILD PASS verdict trigger
date: 2026-05-27
from_team: team_100 (architect)
to_team: team_190 (Senior Constitutional Validator)
target_wp: WP-W2-01-STAGE-B-IMPL
gate: L-GATE_VALIDATE (final, constitutional, immutable)
constitutional_authority: Iron Rule #5 — "Final validation owned by team_190 (constitutional, cross-engine, immutable)"
trigger_condition: "team_50 L-GATE_BUILD verdict PASS or PASS_WITH_FINDINGS committed at _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md"
parent_in_process_preverdict: ../team_100/PREVERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md
parent_mandate_team50: ../team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.1.0.md
parent_remediation: ../team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md
builder_engine: cursor-composer (team_10)
team_50_engine: (set by team_50 verdict §1 — NOT cursor-*, NOT claude-*)
validator_engine_required: "Codex / OpenAI / GPT (team_190 native engine per governance). MUST NOT be cursor-* (builder). SHOULD NOT match the team_50 engine for cross-engine diversity, but governance permits it if team_190's native engine is Codex and team_50 chose Gemini."
info_barrier: "Per team_190 governance — review the IMPLEMENTATION independently. Do NOT use team_50's findings as your premise. team_50's PASS flag is the trigger; their reasoning is informational only."
profile: L0
---

# team_190 Constitutional Validation Mandate — Stage B Implementation

## 0. Context

WP-W2-01-STAGE-B-IMPL has cleared L-GATE_BUILD via cross-engine team_50 QA (Round 2, post-remediation). This mandate authorizes the **final constitutional L-GATE_VALIDATE** gate per Iron Rule #5.

**This is the absolute final gate before Stage B is considered closed.** A BLOCKED verdict here stops all downstream Wave2 work (W2-02 content, W2-06 blog migration).

## 1. Validation Scope

team_190 independently re-validates whether the delivered Stage B implementation is:
- **Correct** — produces the behavior specified in D-14 LOD400 v1.1 and the team_10 mandate.
- **Complete** — all 12 blocks, 13 templates, all 14 VCs satisfied, no scope gaps.
- **Governance-sound** — Iron Rules respected (cross-engine build/QA chain, repo-internal spec_ref paths, lean-kit physical snapshots, write-isolation, identity headers on artifacts, `validate_aos.sh` 0 FAIL).

### In Scope (must verify independently)

1. **Code surface — `site/wp-content/themes/ea-eyalamit/`**:
   - 12 block partials at `template-parts/blocks/block-*.php` — each block well-formed, escapes output, no obvious XSS/injection vectors.
   - 13 page templates at `page-templates/tpl-*.php` — each has `Template Name:`, declares no forbidden globals.
   - Theme enqueue logic in `functions.php` + `inc/wave2-stage-b.php` — versioned URLs, dependency order correct.
   - A/B testing script at `assets/js/ea-ab-testing.js` — uses canonical contract `eyal_cta_variant` ∈ {form_only, dual, wa_only} (the Round-1 drift fix in commit fb8da63 must be present).
   - Analytics config at `inc/analytics-config.json` — structure valid; placeholder values OK pending Eyal Phase 2 gates.
2. **Live page — `/wave2-test/` at uPress staging** (HTTP entry; or HTTPS with `--ignore-certificate-errors`):
   - Renders 12 blocks; computed RTL; ea-tokens/animations/atoms CSS load HTTP 200.
   - axe-core wcag2aa: independently re-run; 0 critical, 0 serious required.
   - Lighthouse mobile: independently re-run on HTTPS+cert-bypass; perf ≥85, a11y ≥95 required (see §3 for TLS environment caveat).
3. **AOS governance compliance**:
   - `validate_aos.sh .` → 0 FAIL.
   - WP entry in `_aos/roadmap.yaml` has correct `gate_history` chain including Round-1 FAIL + Round-2 PASS entries.
   - All artifacts under `_COMMUNICATION/*/` use canonical filename conventions; no spec_ref pointing outside repo.
   - Iron Rule #1 chain: builder=cursor-composer, team_50 validator engine ≠ cursor AND ≠ claude (verify §1 of team_50 verdict).
4. **Cross-cutting checks**:
   - `books-wave1.css` absent from repo and staging.
   - No dangling references to removed files in remaining code.
   - Hebrew content displays correctly (UTF-8 encoding, no mojibake) at the staging URL.

### Out of Scope

- Phase 2 verifications gated on Eyal's 3 human inputs (SMTP / GA4 / Clarity) — these are explicitly carried forward to a separate Phase 2 QA cycle.
- TLS renewal — MAJOR carry-forward to M7 cutover; verify its disposition is documented, do NOT block on it.
- W2-02 / W2-06 content (separate WPs, not yet started).
- Aesthetic/design judgment — Eyal/Team 00's domain.

## 2. Constitutional Independence (mandatory)

Per team_190 Iron Rules:

- **Adversarial stance:** Assume the implementation is broken until proven otherwise.
- **Independence:** Do NOT read team_50's findings before forming your own. Their PASS flag is the trigger; their reasoning is informational only. Re-derive verdicts from primary evidence (the code, the staging page, the validate_aos output).
- **Binary verdict:** L-GATE_VALIDATE returns PASS / FAIL / BLOCKED only — no PASS_WITH_FINDINGS at this gate (per governance "Binary verdict only at final gates").
- **One-shot pattern:** If your verdict is BLOCKED or FAIL, re-routing for a second team_190 run is PROHIBITED without explicit team_00 authorization. Choose carefully.

## 3. TLS Environment Caveat — Pre-Approved

The uPress staging TLS cert is expired. This was diagnosed by team_50 Round-1, dispositioned MAJOR-deferred-to-M7 by team_100 (uPress wildcard plan limitation). It is NOT a Stage-B code defect.

**For Lighthouse runs:**
- Use `--chrome-flags="--ignore-certificate-errors --allow-running-insecure-content"` against the **HTTPS** URL. This bypasses the HTTP→HTTPS(cert-fail)→HTTP redirect chain that masks the true page perf.
- If you measure perf <85 on HTTP entry, document it as evidence supporting the TLS finding (not as a fresh Stage-B failure).
- Pass criterion: perf ≥85 AND a11y ≥95 under the HTTPS+cert-bypass methodology.

## 4. Required Deliverables

### Deliverable 1 — VERDICT v1.0.0
File: `_COMMUNICATION/team_190/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v1.0.0.md`

**Mandatory structure (governance-locked):**

```
# §0 VERDICT BOX (must appear FIRST in chat and at the top of the file)

| Field | Value |
|-------|-------|
| WP | WP-W2-01-STAGE-B-IMPL |
| Gate | L-GATE_VALIDATE |
| Round | 1 (one-shot) |
| Verdict | PASS / FAIL / BLOCKED |
| One-line next step | … |

# §1 Validator engine declaration
- Engine: <name>
- Hostname: <hostname>
- Cross-engine attestation: builder=cursor-composer ≠ this engine; team_50 engine ≠ this engine (if applicable).

# §2 Constitutional checks (table) — at minimum:
- C-1 Code surface: 12 blocks + 13 templates + enqueue + A/B + analytics config
- C-2 Live page: blocks render, RTL, CSS enqueue, footer, WhatsApp
- C-3 axe wcag2aa fresh run: 0 critical, 0 serious
- C-4 Lighthouse mobile HTTPS+bypass: perf ≥85, a11y ≥95
- C-5 validate_aos.sh: 0 FAIL
- C-6 Roadmap gate_history correctness
- C-7 Cross-engine chain integrity (Iron Rule #1)
- C-8 Artifact + filename canon compliance

# §3 Independent findings (do NOT reference team_50's findings as premise)

# §4 Evidence (fresh artifacts produced this run; paths under _COMMUNICATION/team_190/evidence/)

# §5 Verdict rationale (one paragraph)
```

### Deliverable 2 — Git commit
Per team_190 governance: `validate(WP-W2-01-STAGE-B-IMPL/L-GATE_VALIDATE): {VERDICT} — Team 190`. Push.

## 5. Authority Boundaries

- Writes ONLY to `_COMMUNICATION/team_190/` (verdict + `evidence/` subfolder).
- **NEVER** writes to `_aos/` — roadmap mutation belongs to team_100 (ADR034 R9 for L2 spoke).
- DO NOT spawn other agents — single-session validation.
- On verdict commit + push, the verdict is delivered. team_100 next session handles gate advance + Stage-B closure + Wave2 launch.

## 6. Trigger Verification

Before starting validation, confirm trigger is met:
- `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md` exists with verdict PASS or PASS_WITH_FINDINGS.
- That verdict has been committed (`git log --oneline | grep "qa(WP-W2-01-STAGE-B-IMPL"` shows team_50's commit).
- `git status` clean on `main`.

If any condition is false, STOP and notify team_00.

## 7. Activation Prompt — copy verbatim into the external engine session

```
HANDOFF_DEPTH: full
ACTIVATION_SCOPE: team_190 only — WP-W2-01-STAGE-B-IMPL L-GATE_VALIDATE constitutional

Identity: team_190 (Senior Constitutional Validator)
Engine constraint: NOT cursor-* (builder). Use your native Codex/OpenAI engine. Declare in §1.

⚠️ INFO BARRIER: Do NOT read team_50's reasoning/findings before forming your own assessment.
Their PASS flag is your trigger; their detailed conclusions are informational only.
Re-derive verdicts from primary evidence (the code, the staging page, validate_aos output).

Mandate (FIRST READ):
  /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_COMMUNICATION/team_190/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v1.0.0.md

Supporting context (read after own assessment):
  1. team_50 L-GATE_BUILD verdict (TRIGGER ONLY — read §0 box, not findings):
     _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md
  2. team_100 in-process pre-verdict (architectural assessment, not constitutional):
     _COMMUNICATION/team_100/PREVERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md
  3. Round-1 → Round-2 remediation plan:
     _COMMUNICATION/team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md
  4. D-14 LOD400 design spec (governance basis):
     _COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md (or current version)

Working dir: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
Target URL: https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
TLS note: cert expired (deferred to M7). Use --ignore-certificate-errors for Chrome tools.

Tasks:
  1. Independent constitutional review — 8 checks per mandate §4 §2.
  2. Fresh axe-core + Lighthouse runs (HTTPS+cert-bypass):
       npx @axe-core/cli https://eyalamit-co-il-2026.s887.upress.link/wave2-test/ \
         --tags wcag2aa --save _COMMUNICATION/team_190/evidence/axe-validate.json --exit
       npx lighthouse https://eyalamit-co-il-2026.s887.upress.link/wave2-test/ \
         --form-factor=mobile --only-categories=performance,accessibility \
         --output=json --output=html \
         --output-path=_COMMUNICATION/team_190/evidence/lighthouse-validate \
         --chrome-flags="--headless=new --no-sandbox --ignore-certificate-errors --allow-running-insecure-content" \
         --quiet
  3. validate_aos.sh: bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .
  4. Code surface review — read 12 blocks + 13 templates + functions.php + ea-ab-testing.js + analytics-config.json.
  5. Cross-engine chain verification — confirm team_50 verdict §1 declares engine ≠ cursor AND ≠ claude.

Output: _COMMUNICATION/team_190/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_VALIDATE_v1.0.0.md
Structure: mandate §4 — §0 verdict box MANDATORY first, then §1 engine, §2 8 checks, §3 findings, §4 evidence, §5 rationale.

Commit one verdict commit + push. Message:
  "validate(WP-W2-01-STAGE-B-IMPL/L-GATE_VALIDATE): {VERDICT} — Team 190"

Verdict is binary: PASS / FAIL / BLOCKED. No PASS_WITH_FINDINGS at this gate.

One-shot rule: re-routing prohibited without team_00 authorization. Choose carefully.

After push, notify team_00. (team_100 next session handles gate advance + WP closure protocol.)
```

## 8. Version

| Date | Action |
|------|--------|
| 2026-05-27 | Mandate authored by team_100 after in-process pre-verdict 14/14 PASS + ahead of team_50 L-GATE_BUILD dispatch. Status ARMED until team_50 PASS arrives. |
