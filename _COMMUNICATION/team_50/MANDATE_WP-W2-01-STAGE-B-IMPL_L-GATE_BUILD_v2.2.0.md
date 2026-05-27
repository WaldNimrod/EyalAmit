---
id: MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.2.0
title: team_50 QA Mandate v2.2.0 — Round 3 post-contrast-fix
status: ACTIVE — ready for dispatch by nimrod (external engine — Codex/GPT-5 OR Gemini)
supersedes: ./MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.1.0.md
date: 2026-05-27
from_team: team_100 (architect)
to_team: team_50 (external engine — NOT cursor-*, NOT claude-*)
target_wp: WP-W2-01-STAGE-B-IMPL
gate: L-GATE_BUILD
round: 3 (post-contrast-fix)
parent_round_2_verdict_fail: ./VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md
parent_round_2_notice: ./NOTICE_TO_TEAM_00_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2_2026-05-27.md
in_process_preverdict_r2: ../team_100/PREVERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_2026-05-27.md
contrast_fix_commit: c8d7b35
contrast_fix_evidence: ../team_100/evidence/axe-r3-contrast-fix-2026-05-27.md
builder_engine: cursor-composer (team_10 — original) + claude-sonnet-4-6 (team_100 — R3 CSS patch)
validator_engine_required: "NOT cursor-* AND NOT claude-* (per Iron Rule #1 + nimrod directive). Acceptable: Codex (any), Gemini Code Assist, GPT-5 web."
profile: L0
target_url_canonical: https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
target_url_note: TLS cert expired (M7 deferred). Use --ignore-certificate-errors for Chrome tools.
---

# team_50 QA Mandate v2.2.0 — Round 3 (post-contrast-fix)

## 0. Context

Round 2 (commit 56a159f) returned **FAIL** with one BLOCKER:
- **VC-6:** color-contrast on `.ea-sound-toggle__label` measured **3.73:1** (WCAG 2 AA requires 4.5:1 for normal text). Surfaced via Puppeteer-injected axe — the `@axe-core/cli` command in the original mandate landed on `chrome-error://chromewebdata/` due to the expired-TLS redirect and missed it. Your discovery method (Puppeteer + cert-bypass) was correct and the actionable finding of Round 2. **This is the most valuable single finding of the entire QA chain so far.** Thank you.

Round 3 fix (commit c8d7b35, in-process verified by team_100):
- `.ea-sound-toggle` `color: rgba(255,255,255,0.7)` → `rgba(255,255,255,0.92)` (target ≥4.5:1 against topnav `rgba(46,43,40,0.72)`)
- `.ea-sound-toggle` `border: rgba(255,255,255,0.25)` → `rgba(255,255,255,0.45)` (visual hierarchy consistency with brighter text)
- `style.css` Version: 1.3.6 → 1.3.7 (cache-bust the enqueued CSS — `$ver` is read from `wp_get_theme()->get('Version')`)

Deploy: 2-file delta via FTPS to uPress staging; CSS confirmed live via curl.

In-process re-verification (Puppeteer-injected axe, same method as your R2 finding): **0 serious / 0 critical**. `.ea-sound-toggle` absent from any violation. Evidence: `_COMMUNICATION/team_100/evidence/axe-r3-contrast-fix-2026-05-27.{md,json}`.

## 1. Cross-Engine Constraint (unchanged)

- Builder engines so far: cursor-composer (original implementation) + claude-sonnet-4-6 (R3 CSS patch).
- YOUR engine MUST BE: NOT cursor-* AND NOT claude-*. Acceptable: Codex (CLI or Cursor-with-GPT5/o1), Gemini, GPT-5 web. Same engine as your R2 run is preferred (continuity of perspective).

## 2. VC Re-Run List

**Critical re-run (the bug you found):**
- **VC-6** — Puppeteer-injected axe on https://eyalamit-co-il-2026.s887.upress.link/wave2-test/ with `--ignore-certificate-errors`. Required: 0 critical AND 0 serious. Specifically confirm `.ea-sound-toggle` / `.ea-sound-toggle__label` no longer appears in any contrast violation.

**Carry-forward from R2 (you already passed these — confirm no regression):**
- VC-1 (CSS enqueue), VC-2 (12 blocks), VC-3 (12 partials), VC-4 (13 templates), VC-5 (RTL), VC-7 (Lighthouse HTTPS+cert-bypass perf ≥85 + a11y ≥95 — you measured perf 87 / a11y 100 in R2), VC-8 (reduced-motion fallback), VC-9 (visual RTL screenshots), VC-10 (A/B distribution — you measured 6/6 valid in R2), VC-11 (footer 3 links), VC-12 (WhatsApp), VC-13 (books-wave1.css absent), VC-14 (validate_aos 0 FAIL).

For carry-forward, light re-touch is sufficient — you do NOT need to re-screenshot or re-run Lighthouse unless you suspect regression. Cite your R2 evidence and confirm.

## 3. Methodology Update (locked from your R2 finding)

**Axe execution method (required):** Puppeteer with axe-core injection — NOT `@axe-core/cli`. The CLI's URL navigation breaks under the TLS-redirect chain even with `--ignore-certificate-errors`. Use the same Node script approach you authored in R2 (or the team_100 R3 script at `/tmp/team100-axe-r3.js` for reference). Save fresh evidence to `_COMMUNICATION/team_50/evidence/axe-r3-puppeteer.json`.

## 4. Required Deliverables

### Deliverable 1 — VERDICT v3.0.0
File: `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v3.0.0.md`

Structure:
- §0 verdict box: PASS / PASS_WITH_FINDINGS / FAIL
- §1 hostname + **validator_engine declaration** (state engine; MUST NOT be cursor-* or claude-*)
- §2 VC table — VC-6 fresh; VC-1..5, 7..14 carry-forward from R2 evidence with one-line confirmation each
- §3 Findings — confirm VC-6 fix landed; any new findings
- §4 validate_aos.sh result
- §5 evidence files (fresh axe-r3-puppeteer.json minimum; other artifacts may be cited from R2)
- §6 Cross-engine compliance attestation

### Deliverable 2 — Git commit
`qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): {VERDICT} v3 — Team 50 cross-engine`. Push.

## 5. Trigger Conditions (verified by team_100 2026-05-27)

| Condition | Status |
|-----------|--------|
| Contrast fix commit pushed | ✓ c8d7b35 |
| CSS live on staging (curl confirms 0.92 alpha + Version 1.3.7) | ✓ |
| In-process Puppeteer axe re-verification | ✓ 0 serious / 0 critical |
| git working tree clean on main | ✓ |
| `validate_aos.sh` 0 FAIL | ✓ |

## 6. Authority Boundaries (unchanged)

- Write only to `_COMMUNICATION/team_50/` (verdict + evidence subfolder).
- DO NOT edit `_aos/roadmap.yaml`.
- DO NOT spawn other agents.
- On verdict commit + push, notify team_00.

## 7. Activation Prompt — copy verbatim into the external engine session

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_50 only — WP-W2-01-STAGE-B-IMPL L-GATE_BUILD R3 cross-engine

Identity: team_50 (QA & Functional Acceptance)
🚨 Engine: NOT cursor-*, NOT claude-*. State engine in §1 of verdict.

Mandate (FIRST READ):
  /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.2.0.md

Supporting context (read in order):
  1. Your R2 FAIL verdict (the bug you found):
     _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md
  2. team_100 R3 contrast-fix evidence:
     _COMMUNICATION/team_100/evidence/axe-r3-contrast-fix-2026-05-27.md
  3. R3 fix commit (CSS patch + theme v1.3.7):
     git show c8d7b35

Working dir: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
Target URL: https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
TLS: cert expired (M7 deferred) → use --ignore-certificate-errors for Chrome.

Task:
  1. Critical re-run: fresh Puppeteer-injected axe (NOT @axe-core/cli — see mandate §3 for why).
     Output: _COMMUNICATION/team_50/evidence/axe-r3-puppeteer.json
     Pass criterion: 0 serious AND 0 critical. .ea-sound-toggle must NOT appear in any violation.
  2. Confirm no regression on VC-1..5, 7..14 (your R2 evidence stands — light re-touch only).
  3. Issue VERDICT_..._v3.0.0.md (mandate §4). Commit "qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): {VERDICT} v3 — Team 50 cross-engine". Push.

After push, notify team_00. (team_190 will be re-routed by nimrod after your PASS.)
```

## 8. Version

| Date | Version | Action |
|------|---------|--------|
| 2026-05-27 | 2.0.0 | Initial external mandate after in-process FAIL (VC-7 perf) |
| 2026-05-27 | 2.1.0 | Post-remediation 14/14 PASS in-process → dispatched |
| 2026-05-27 | 2.2.0 | After Round-2 verdict FAIL on VC-6 contrast → team_100 fix verified in-process → re-dispatch for R3 cross-engine confirmation |
