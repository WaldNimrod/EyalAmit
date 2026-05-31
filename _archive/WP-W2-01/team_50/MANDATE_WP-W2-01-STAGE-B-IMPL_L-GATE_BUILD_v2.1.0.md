---
id: MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.1.0
title: team_50 QA Mandate v2.1.0 — Stage B Impl Round 2 cross-engine final
status: ACTIVE — ready for dispatch by nimrod (external engine: Codex/GPT-5 OR Gemini)
supersedes: ./MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md
date: 2026-05-27
from_team: team_100 (architect)
to_team: team_50 (external engine — NOT cursor-*, NOT claude-*)
target_wp: WP-W2-01-STAGE-B-IMPL
gate: L-GATE_BUILD
round: 2 (post-remediation, post-in-process-PASS)
parent_mandate_v1: ./MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
parent_verdict_r1_fail: ./VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
remediation_plan: ../team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md
in_process_preverdict: ../team_100/PREVERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md
builder_engine: cursor-composer (team_10)
validator_engine_required: "NOT cursor-* AND NOT claude-*. Acceptable: Codex (CLI or Cursor agent w/ GPT-5/o1), Gemini Code Assist, GPT-5 web with repo access."
profile: L0
implementation_commit: e165218
remediation_commits:
  - 0f71779 (team_99 deploy + smoke page)
  - fb8da63 (A/B drift fix)
  - c6b3161 (team_100 in-process pre-verdict + evidence)
target_url_canonical: https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
target_url_note: TLS cert expired (uPress wildcard deferred to M7 — MAJOR carry-forward). Use --ignore-certificate-errors for Chrome-based tools, OR test HTTP entry and document the redirect-chain perf penalty as known finding.
in_process_result: 14/14 PASS with environment caveat on VC-7 (TLS-redirect cost on HTTP entry)
---

# team_50 QA Mandate v2.1.0 — Stage B Impl Round 2 Cross-Engine

> **Note:** Supersedes v2.0.0. The change between v2.0.0 → v2.1.0 is the addition of the in-process remediation cycle that resolved VC-7 (HTTPS-direct workaround for TLS) and VC-9 (Puppeteer visual QA) before external dispatch. The expected result is now PASS, not PASS_WITH_FINDINGS.

## 0. Context

After Round-1 cursor-validator FAIL + remediation R1–R4 (deploy, smoke page, A/B drift fix, TLS deferral), team_100 ran in-process Sonnet+Haiku sub-agent orchestration → **14/14 PASS** with one environment caveat (see PREVERDICT §3 F-R2-01). This mandate authorizes the constitutional cross-engine L-GATE_BUILD verdict.

## 1. Cross-Engine Constraint (Iron Rule #1)

- **Builder engine:** cursor-composer (team_10).
- **Round-1 validator (rejected):** cursor-composer (same engine — IR#1 violation).
- **In-process pre-verdict engines (advisory only, NOT cross-engine):** claude-sonnet-4-6 + claude-haiku-4-5.
- **YOUR engine MUST BE:** NOT cursor-* AND NOT claude-*. Per nimrod directive 2026-05-27, the canonical verdict requires a truly third engine. Acceptable: Codex (any), Gemini, GPT-5 web. If only forbidden engines are available, STOP and report to team_00.

## 2. VC Re-Run List (14 VCs — confirm in-process PASS)

Run each VC fresh. For each, you may **concur** (cite the in-process evidence and confirm with your own measurement) or **dispute** (your measurement differs — that's the most valuable possible finding).

### Repo-side VCs (4) — carry-forward confirmation

| VC | Check | Expected |
|----|-------|----------|
| VC-3 | `ls site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-*.php \| wc -l` | 12 |
| VC-4 | `grep -l "Template Name:" site/wp-content/themes/ea-eyalamit/page-templates/tpl-*.php \| wc -l` | ≥12 (currently 13) |
| VC-13 | `find site/wp-content/themes/ea-eyalamit -name "books-wave1.css"` | empty |
| VC-14 | `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` | 0 FAIL (currently 30 PASS / 18 SKIP / 0 FAIL) |

### Live-page VCs (10) — fresh execution

| VC | Check | In-process result (informational) |
|----|-------|-----------------------------------|
| VC-1 | 3 CSS `<link>` tags (ea-tokens/animations/atoms) on /wave2-test/ | PASS |
| VC-2 | 12 blocks rendered (`data-block` markers) | PASS |
| VC-5 | `<html dir="rtl" lang="he-IL">` + computed direction | PASS |
| VC-6 | axe-core wcag2aa: 0 critical AND 0 serious | PASS (0 violations) |
| VC-7 | Lighthouse mobile: perf ≥85 AND a11y ≥95 | **PASS on HTTPS** (perf 90, a11y 100). **FAIL on HTTP** (perf 81 — TLS redirect penalty). See §3. |
| VC-8 | `@media (prefers-reduced-motion: reduce)` in ea-animations.css | PASS |
| VC-9 | Visual RTL layout (headed browser, desktop + mobile) | PASS (screenshots in `_COMMUNICATION/team_100/evidence/screenshot-*-rtl.png`) |
| VC-10 | `sessionStorage.eyal_cta_variant` ∈ {form_only, dual, wa_only}, distribution ≥2 distinct across ≥6 trials | PASS (4× form_only, 2× dual in 6 trials) |
| VC-11 | Footer 3 social links FB+IG+YT with `target="_blank" rel="noopener noreferrer"` | PASS |
| VC-12 | WhatsApp `wa.me/972524822842` | PASS |

## 3. VC-7 — Special Handling

The TLS cert is expired (R4 of Round-1 remediation, deferred to M7 — MAJOR carry-forward). This creates an HTTP→HTTPS(cert-fail)→HTTP redirect chain that costs ~1100ms in `redirects` audit, dropping Lighthouse perf from ~90 to ~81 on HTTP entry.

**Required methodology for VC-7:**
- Use Chrome with `--ignore-certificate-errors --allow-running-insecure-content` and hit `https://eyalamit-co-il-2026.s887.upress.link/wave2-test/` directly. This eliminates the redirect chain and measures actual page perf.
- Pass criterion: perf ≥85 AND a11y ≥95 under this methodology.
- Document the HTTP-entry result separately as evidence supporting the TLS finding (already MAJOR-deferred).

In-process measurement: perf **90/100**, a11y **100/100** under HTTPS+cert-bypass. Expect comparable.

## 4. Required Deliverables

### Deliverable 1 — VERDICT v2.0.0
File: `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md`

Structure:
- §0 verdict box: PASS / PASS_WITH_FINDINGS / FAIL
- §1 hostname + **validator_engine declaration** (MUST state engine name; MUST NOT be cursor-* or claude-*)
- §2 VC table — all 14 VCs (4 carry-forward confirm + 10 fresh)
- §3 Findings (BLOCKER / MAJOR / MINOR) — confirm or dispute F-R2-01 (TLS env) and F-R2-02 (mobile `<p>` text-align override)
- §4 validate_aos.sh result
- §5 evidence files (fresh axe JSON, fresh Lighthouse HTML+JSON, headed-browser screenshots if applicable, sessionStorage notes)
- §6 Cross-engine compliance attestation

### Deliverable 2 — Git commit
Commit message: `qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): {VERDICT} v2 — Team 50 cross-engine`. Push.

## 5. Trigger Conditions (verified by team_100 2026-05-27)

| Condition | Status |
|-----------|--------|
| `curl -I http://…/wave2-test/` → 200 | ✓ |
| `curl -I http://…/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css` → 200 | ✓ |
| git: working tree clean on main | ✓ |
| `validate_aos.sh` → 0 FAIL | ✓ (30/18/0) |
| In-process pre-verdict committed | ✓ (commit c6b3161) |

## 6. Authority Boundaries

- Writes to `_COMMUNICATION/team_50/` only (verdict + evidence subfolder).
- DO NOT edit `_aos/roadmap.yaml` — that's team_100's act on PASS.
- DO NOT spawn other agents — single-session QA.
- On verdict commit + push, notify team_00. team_100 next session handles gate advance.

## 7. Activation Prompt — copy verbatim into the external engine session

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_50 only — WP-W2-01-STAGE-B-IMPL L-GATE_BUILD R2 cross-engine final

Identity: team_50 (QA & Functional Acceptance)
🚨 Engine: NOT cursor-*, NOT claude-*. State engine name in §1 of verdict.

Mandate (FIRST READ):
  /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.1.0.md

Supporting context (read in order):
  1. team_100 in-process pre-verdict (14/14 PASS advisory):
     _COMMUNICATION/team_100/PREVERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md
  2. Round-1 original mandate (VC definitions):
     _COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
  3. Round-1 FAIL verdict (what was broken):
     _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v1.0.0.md
  4. Remediation plan (R1-R4 complete, R5 = this dispatch):
     _COMMUNICATION/team_100/REMEDIATION-PLAN-STAGE-B-IMPL-FAIL-2026-05-27.md
  5. Evidence dir for in-process measurements:
     _COMMUNICATION/team_100/evidence/

Working dir: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
Target URL: https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
Note: TLS cert expired (deferred to M7). Use --ignore-certificate-errors for Chrome.

Task:
  1. Run 14 VCs per mandate v2.1.0 §2.
  2. Fresh axe scan:
       npx @axe-core/cli https://eyalamit-co-il-2026.s887.upress.link/wave2-test/ \
         --tags wcag2aa --save _COMMUNICATION/team_50/evidence/axe-r2.json --exit
  3. Fresh Lighthouse mobile (HTTPS + cert-bypass) per mandate v2.1.0 §3:
       npx lighthouse https://eyalamit-co-il-2026.s887.upress.link/wave2-test/ \
         --form-factor=mobile --only-categories=performance,accessibility \
         --output=json --output=html \
         --output-path=_COMMUNICATION/team_50/evidence/lighthouse-r2 \
         --chrome-flags="--headless=new --no-sandbox --ignore-certificate-errors --allow-running-insecure-content" \
         --quiet
  4. Headed browser (VC-9 + VC-10): screenshot desktop + mobile widths of /wave2-test/; read sessionStorage.eyal_cta_variant across 6+ incognito sessions.
  5. Concur or dispute each in-process result. Disputes are the most valuable evidence.

Output: _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md
Structure: mandate v2.1.0 §4.

Commit one verdict commit + push. Message: "qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): {VERDICT} v2 — Team 50 cross-engine"

After push, notify team_00 (no further action by team_50).
```

## 8. Version

| Date | Version | Action |
|------|---------|--------|
| 2026-05-27 | 2.0.0 | First external mandate drafted (in-process result was PASS_WITH_FINDINGS — VC-7 perf 81 / VC-9 SKIP) |
| 2026-05-27 | 2.1.0 | After remediation cycle (HTTPS+cert-bypass for VC-7 → perf 90; Puppeteer for VC-9 → PASS; VC-10 distribution sampled). In-process now 14/14 PASS. External validator expected to confirm. |
