---
id: MANDATE-TEAM191-WP-W2-14-A-ARCHIVE-2026-06-04
from_team: team_100 (Chief System Architect)
to_team: team_191 (Git/Files Custodian)
wp: WP-W2-14-A — Mobile Chrome Foundation (canonical nav + footer + drawer)
date: 2026-06-04
gate: POST-CLOSURE ARCHIVE
status: ISSUED (execute AFTER merge to main on team_00 go)
branch: wp-w2-14-a-mobile-chrome
---

# Archive Mandate — WP-W2-14-A

WP-W2-14-A is **CLOSED** (DONE / LOD500_LOCKED; team_50 L-GATE_BUILD **PASS** + team_190
L-GATE_VALIDATE **PASS** round-1, 0 P0/P1). Closure on branch `wp-w2-14-a-mobile-chrome`.
Roadmap already set to DONE/LOD500_LOCKED by team_100 (single-writer) on the branch.
**This is the Phase-1 pattern-setter; on close, Phase 2 (14-B/C/D/E) unblocks.**

## Pre-archive: confirm the branch carries all gate artifacts
The S5/validate artifacts were authored in Cursor (team_50 / team_190). Before archiving,
confirm they are committed onto `wp-w2-14-a-mobile-chrome` (cherry-pick / merge if they
landed on another ref). The branch must contain the build + all 3 gate verdicts + evidence.

## Archive actions (execute AFTER merge to main on team_00 go)
1. Archive these gate/build artifacts → `_archive/WP-W2-14-A/` (surgical `git mv`):
   - `_COMMUNICATION/team_100/PREFLIGHT-WP-W2-14-A-2026-06-04.md`
   - `_COMMUNICATION/team_100/evidence/wp-w2-14-a/` (qa_probe + screenshots)
   - `_COMMUNICATION/team_50/QA-VERDICT-WP-W2-14-A-L-GATE-BUILD-2026-06-04.md`
   - `_COMMUNICATION/team_50/evidence/wp-w2-14-a/` (if present)
   - `_COMMUNICATION/team_190/VERDICT-WP-W2-14-A-L-GATE-VALIDATE-2026-06-04.md`
   - `_COMMUNICATION/team_190/evidence/wp-w2-14-a/` (if tracked; .png are gitignored — keep local)
   - this mandate (after completion)
2. **KEEP LIVE (do NOT archive — needed for Phase 2 / 14-B–E):**
   - `_COMMUNICATION/team_100/WP-W2-14-MOBILE-PROGRAM-PLAN-2026-06-03.md` (drives B/C/D/E)
   - `_aos/work_packages/S003/WP-W2-14-{A..E}/LOD400_spec.md` (A closed; B–E pending)
   - `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/` (source package — B/C/D/E inherit it)
   - `_COMMUNICATION/team_190/VERDICT-WP-W2-14-SPEC-VALIDATION-*.md` (umbrella spec-gate — archive at WP-W2-14 final close, not now)
   - `_COMMUNICATION/team_100/HANDOFF-…WP-W2-14-…ORCHESTRATION-2026-06-03.md` (umbrella orchestration)
3. Surgical `git mv` by explicit path — never `git add -A` (IR#1).
4. `validate_aos.sh` 0 FAIL post-archive (Check 32 — `_aos/` committed; no drift).
5. Report completion to `_COMMUNICATION/team_100/`.

## Carry-forward (do NOT lose — not archive items)
- **team_80 S4 ratification:** the `.ea-breath-divider{overflow:hidden}` edit in `ea-atoms.css`
  (pre-existing scaleX overflow fix, approved by team_190) must be ratified by team_80 at S4.
- **WP-W2-14-B owns:** `/en` full chrome wiring (`tpl-en-landing.php` server-rendered
  controls/drawer/.ea-cfoot) and the non-blocking F-03 recommendation (`inert` on the closed
  drawer). Both flagged in the 14-A pre-flight + team_190 verdict.

*team_100 — 2026-06-04 — execute after team_00 go + merge to main.*
