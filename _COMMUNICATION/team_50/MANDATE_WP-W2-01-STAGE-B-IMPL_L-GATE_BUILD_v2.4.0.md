---
id: MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.4.0
title: team_50 QA Mandate v2.4.0 — Round 5 (clean re-dispatch, Cursor authorized)
status: ACTIVE — ready for dispatch
supersedes: ./MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.3.0.md
date: 2026-05-27
from_team: team_100 (architect)
to_team: team_50 (QA — Cursor composer authorized by team_00 disposition)
target_wp: WP-W2-01-STAGE-B-IMPL
gate: L-GATE_BUILD
round: 5 (clean re-dispatch — focus is code correctness)
team_00_authority: ../team_00/DISPOSITION_IR1_WAIVER_WP-W2-01-STAGE-B-IMPL_2026-05-27.md
engine_authorized: "Either (a) cursor-composer (Cursor IDE) OR (b) claude-sonnet-4-6 (sub-agent under team_100 orchestration) — per team_00 disposition. The constitutional cross-engine layer is preserved at L-GATE_VALIDATE (team_190 Codex/OpenAI native, fully separate from both)."
profile: L0
target_url: https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
target_url_note: TLS cert expired (M7 deferred). Use --ignore-certificate-errors for Chrome tools.
---

# team_50 QA Mandate v2.4.0 — Round 5

## 0. The question this round answers

**Is the code correct?** That is the only question. Engine choice is settled by team_00 disposition; the constitutional cross-engine check happens at team_190 (Codex), not here.

## 1. Engine

Either `cursor-composer` (external Cursor session) OR `claude-sonnet-4-6` (sub-agent under team_100 orchestration) is authorized for this round by team_00 disposition `../team_00/DISPOSITION_IR1_WAIVER_WP-W2-01-STAGE-B-IMPL_2026-05-27.md`. Declare the chosen engine honestly in §1 of the verdict. Constitutional cross-engine integrity is enforced at team_190 (Codex/OpenAI), not here.

## 2. VCs (14 total)

Run all 14 fresh. R3 evidence stands as comparison reference only — confirm or dispute with your own measurements.

| VC | Method | Pass criterion |
|----|--------|----------------|
| VC-1 | curl + HTML inspect | 3 `<link>` to ea-tokens / ea-animations / ea-atoms CSS |
| VC-2 | DOM scan | 12 `data-block` markers in `/wave2-test/` |
| VC-3 | `ls site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-*.php \| wc -l` | 12 |
| VC-4 | `grep -l "Template Name:" site/wp-content/themes/ea-eyalamit/page-templates/tpl-*.php \| wc -l` | ≥12 |
| VC-5 | grep `<html dir="rtl"` | present |
| **VC-6** | **Puppeteer-injected axe** (NOT @axe-core/cli — CLI broken under TLS-redirect per your R2 finding) | 0 critical AND 0 serious. `.ea-sound-toggle` absent from any violation. |
| **VC-7** | **Lighthouse mobile HTTPS+cert-bypass — 3 runs minimum** | avg ≥85 AND each run ≥80 AND a11y always 100 |
| VC-8 | curl ea-animations.css + grep `prefers-reduced-motion` | block present |
| VC-9 | Headed browser screenshots (desktop 1440×900 + mobile 390×844) | RTL layout valid both viewports |
| VC-10 | Puppeteer + sessionStorage read, 6+ incognito trials | All valid variants, ≥2 distinct |
| VC-11 | curl + grep | 3 social links FB/IG/YT with `target="_blank" rel="noopener noreferrer"` |
| VC-12 | curl + grep | `wa.me/972524822842` |
| VC-13 | curl on books-wave1.css | HTTP 404 (asset absent) |
| VC-14 | `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` | 0 FAIL |

**Two new VCs added after team_190 R2 findings (R4 fixes verified):**
- **VC-A1 (audio 404 closure)** — `curl /wave2-test/ \| grep -c "didgeridoo"` → 0.
- **VC-A2 (wp-block-library dequeue)** — `curl /wave2-test/ \| grep -c "wp-block-library-inline-css"` → 0.

## 3. Method (locked)

- **axe**: Puppeteer-injected, NOT CLI.
- **Lighthouse**: ≥3 runs with cache-bust query (`?cb=$(date +%s%N)`); avg + each-min.
- **TLS**: `--ignore-certificate-errors --allow-running-insecure-content` against the HTTPS URL.

## 4. Deliverables

### Deliverable 1 — VERDICT v4.0.0
File: `_COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v4.0.0.md`

Structure:
- §0 verdict box: PASS / PASS_WITH_FINDINGS / FAIL
- §1 hostname + `validator_engine: composer (Cursor IDE agent runtime)` + cite team_00 disposition
- §2 VC table — 14 + VC-A1 + VC-A2 = 16 rows
- §3 Findings (BLOCKER / MAJOR / MINOR)
- §4 validate_aos.sh result
- §5 evidence files
- §6 Acknowledgment: cite team_00 disposition; note that constitutional cross-engine is enforced at team_190 (Codex), not here.

### Deliverable 2 — Git commit
`qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): {VERDICT} v4 — Team 50`. Push.

## 5. Trigger Conditions (verified by team_100)

| Condition | Status |
|-----------|--------|
| team_00 disposition committed | ✓ pending this commit |
| All R4 fixes live on staging | ✓ |
| Triple-run Lighthouse stable ≥85 in-process | ✓ (87/87/87) |
| `<audio>` absent from live HTML | ✓ |
| wp-block-library inline absent from live HTML | ✓ |
| `validate_aos.sh` 0 FAIL | ✓ |
| Roadmap gate_history reflects R2/R3/L-GATE_VALIDATE R1/R2 + R4 | ✓ |

## 6. Boundaries

- Writes only to `_COMMUNICATION/team_50/`.
- Do not edit `_aos/roadmap.yaml`.
- Single-session; no sub-agent spawning.

## 7. Activation Prompt — copy verbatim into the Cursor session

```
HANDOFF_DEPTH: lean
ACTIVATION_SCOPE: team_50 only — WP-W2-01-STAGE-B-IMPL L-GATE_BUILD R5 (clean re-dispatch)

Identity: team_50 (QA & Functional Acceptance)
Engine: cursor-composer (authorized by team_00 disposition — see mandate §1).
The question is whether the code is correct. Engine choice is settled.

Mandate (FIRST READ):
  /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026/_COMMUNICATION/team_50/MANDATE_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.4.0.md

team_00 disposition (cite in §1 + §6 of verdict):
  _COMMUNICATION/team_00/DISPOSITION_IR1_WAIVER_WP-W2-01-STAGE-B-IMPL_2026-05-27.md

Supporting context:
  - Your R2 finding (contrast bug — closed in R3):
    _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v2.0.0.md
  - R4 fix evidence (perf 87/87/87 triple-run, audio guard, dequeue):
    _COMMUNICATION/team_100/evidence/lighthouse-r4-triplerun-summary.md
    git show a3f8c55

Working dir: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026
Target URL: https://eyalamit-co-il-2026.s887.upress.link/wave2-test/
TLS: cert expired → use --ignore-certificate-errors.

Task (per mandate v2.4.0 §2 + §3):
  1. Puppeteer-injected axe → _COMMUNICATION/team_50/evidence/axe-r5-puppeteer.json
     (pass: 0 critical AND 0 serious)
  2. Lighthouse triple-run mobile HTTPS+bypass:
     for N in 1 2 3; do
       npx lighthouse https://eyalamit-co-il-2026.s887.upress.link/wave2-test/?cb=$(date +%s%N) \
         --form-factor=mobile --only-categories=performance,accessibility \
         --output=json \
         --output-path=_COMMUNICATION/team_50/evidence/lighthouse-r5-run-${N}.json \
         --chrome-flags="--headless=new --no-sandbox --ignore-certificate-errors --allow-running-insecure-content" \
         --quiet
     done
     (pass: avg ≥85 AND each ≥80 AND a11y=100)
  3. Headed browser VC-9 (screenshots desktop+mobile) + VC-10 (sessionStorage A/B over 6 incognito sessions)
  4. VC-A1: curl /wave2-test/ → grep "didgeridoo" must be 0
  5. VC-A2: curl /wave2-test/ → grep "wp-block-library-inline-css" must be 0
  6. VC-1..5, 8, 11..14 light re-touch

Output: _COMMUNICATION/team_50/VERDICT_WP-W2-01-STAGE-B-IMPL_L-GATE_BUILD_v4.0.0.md
- §1 declare engine "composer (Cursor IDE)" + cite team_00 disposition
- §6 attestation: constitutional cross-engine is at team_190 (Codex), not here

Commit "qa(WP-W2-01-STAGE-B-IMPL/L-GATE_BUILD): {VERDICT} v4 — Team 50". Push. Notify team_00.
```

## 8. Version

| Date | Version | Action |
|------|---------|--------|
| 2026-05-27 | 2.0.0 → 2.3.0 | Iterations with progressively tighter engine constraints (over-engineered) |
| 2026-05-27 | 2.4.0 | Clean re-dispatch under team_00 IR#1 waiver. Focus: code correctness, not engine theater. |
