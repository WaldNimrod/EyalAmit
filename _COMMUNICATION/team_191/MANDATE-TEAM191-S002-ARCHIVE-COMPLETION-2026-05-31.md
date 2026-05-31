---
id: MANDATE-TEAM191-S002-ARCHIVE-COMPLETION-2026-05-31
from_team: team_100 (Chief System Architect)
to_team: team_191 (Git, Archive & File Governance)
date: 2026-05-31
authority: ADR042 §step-1 + POST_GATE_ARCHIVE_PROCEDURE v1.1.0 (Iron Rule #15)
trigger: S002 milestone closeout — 4 WPs reached COMPLETE/LOD500_LOCKED but were never archived
status: ACTIVE
---

# Mandate — Complete the S002 Wave2 archival gap

## Context
S002 (Wave2) is being formally closed out. Audit found **4 of 9 WPs un-archived** despite
COMPLETE/LOD500_LOCKED status and (for 3 of them) a previously-issued team_191 archive mandate
that was never executed:

- **WP-W2-01** (Infrastructure / D-14 + parent of STAGE-A, STAGE-B-PREP, STAGE-B-IMPL)
- **WP-W2-02** (Core Content) — prior mandate `MANDATE-TEAM191-W2-02-ARCHIVE-2026-05-28.md`
- **WP-W2-03** (Books) — prior mandate `MANDATE-TEAM191-W2-03-ARCHIVE-2026-05-29.md`
- **WP-W2-06** (Blog) — prior mandate `MANDATE-TEAM191-W2-06-ARCHIVE-2026-05-28.md`

(WP-W2-04/05/07/08/09 are already archived.)

## Scope of work
For each of the 4 WPs, execute `POST_GATE_ARCHIVE_PROCEDURE.md` (Steps 5–7) canonically:

1. `mkdir -p _archive/<WP-ID>/<team_name>/` mirroring source team dirs.
2. **Move** (never delete) every WP-scoped artifact whose filename name-matches the WP (verdicts,
   QA-verdicts, MANDATE-TEAM50/190/191, NOTICE, REFUSAL, DISPOSITION, ACK, PREVERDICT, EVIDENCE,
   REQA/GO-SIGNAL, HANDOFF_SELF_*, completion/import-prep/build reports). The prior
   `MANDATE-TEAM191-*-ARCHIVE-*` files themselves move into their WP archive. All W2-01 STAGE-*
   artifacts consolidate under `_archive/WP-W2-01/`.
3. Create `_archive/<WP-ID>/ARCHIVE_MANIFEST.md` per the procedure template, including the
   **mandatory Path redirects table** (former `_COMMUNICATION/...` → `_archive/<WP-ID>/...`) and a
   **Misplaced Artifacts** note (Iron Rule #12 — these artifacts sat at team root, not in a WP subdir).

## HARD CONSTRAINTS (reference integrity — binding)
- **DO NOT MOVE these files** (they are `spec_ref` targets validated by validate_aos.sh Check 4, or
  shared multi-WP docs). Leave in place; list them in the manifest under "Referenced / retained":
  1. `_COMMUNICATION/team_100/WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md` (spec_ref of WP-W2-01)
  2. `_COMMUNICATION/team_100/MANDATE-TEAM100-STAGE-A-ATOMS-FIRST-2026-05-26.md` (spec_ref of STAGE-A)
  3. `_COMMUNICATION/team_10/MANDATE-TEAM10-STAGE-B-PREP-PARALLEL-2026-05-26.md` (spec_ref of STAGE-B-PREP)
  4. `_COMMUNICATION/team_10/MANDATE-TEAM10-STAGE-B-IMPLEMENTATION-2026-05-27.md` (spec_ref of STAGE-B-IMPL)
  5. `_COMMUNICATION/team_100/HANDOFF_SELF_100_W2-03-04-05_ORCHESTRATION_2026-05-29_v1.md` (multi-WP)
- **DO NOT edit `_aos/roadmap.yaml`.** team_100 owns all SSoT mutations (M.1 handled separately).
  The manifest Path-redirects table + procedure M.4 cover the free-text `gate_history` note paths.
- **DO NOT delete anything.** Move only.
- Surgical per-file `git` staging only — never `git add -A`. **Do not commit; do not push.** Leave the
  working tree staged-ready for team_100 review.

## Source file inventory (team_100 pre-scan — authoritative)
The 4 WPs' WP-scoped artifacts (move all EXCEPT the 5 do-not-move files above):
- WP-W2-01: team_00/{ACK,DISPOSITION×3}, team_10/HANDOFF_SELF_10_*STAGE-B-PREP*, team_100/{GATE-ADVANCE-REQUEST,HANDOFF_SELF_100_*STAGE-A/B-IMPL*,MANDATE-TEAM191-*STAGE-B-IMPL*,PREVERDICT_*}, team_190/{MANDATE_*v1.0-1.3, NOTICE_*×4, VERDICT_*STAGE-B-IMPL_VALIDATE_v1-4, VERDICT_*STAGE_A_SPEC_v1-2}, team_50/{HANDOFF_SELF_50_*, MANDATE_*BUILD_v*, NOTICE_*×3, REFUSAL_*, VERDICT_*BUILD_v1-4, VERDICT_*STAGE-B-PREP_BUILD}
- WP-W2-02: team_10/{W2-02-COMPLETION-REPORT, W2-02-HANDOFF-TO-TEAM100} (NOT the CORE-CONTENT mandate — that is team_10 build mandate, movable), team_190/{MANDATE-TEAM190-*, VERDICT-WP-W2-02-*}, team_191/MANDATE-TEAM191-W2-02-ARCHIVE, team_50/{EVIDENCE-*, QA-VERDICT-*, REQA-SIGNAL-*}. The `MANDATE-TEAM10-W2-02-CORE-CONTENT` is movable (spec_ref is the LOD400_spec, not this mandate).
- WP-W2-03: team_10/MANDATE-TEAM10-W2-03-BOOKS, team_100/{HANDOFF_SELF_100_WP-W2-03_*, INFO-HANDOFF-TO-W2-03-SESSION, W2-03-COMPLETION-REPORT}, team_190/{MANDATE-TEAM190-*, VERDICT-WP-W2-03-*}, team_191/MANDATE-TEAM191-W2-03-ARCHIVE, team_50/{MANDATE-TEAM50-*, QA-VERDICT-*}. (NOT the W2-03-04-05 orchestration handoff.)
- WP-W2-06: team_10/{MANDATE-TEAM10-W2-06-*, W2-06-COMPLETION-REPORT, W2-06-IMPORT-PREP}, team_100/W2-06-COMPLETION-REPORT-TO-TEAM100, team_190/{HANDOFF_SELF_190_*, MANDATE-TEAM190-*, VERDICT-WP-W2-06-*}, team_191/MANDATE-TEAM191-W2-06-ARCHIVE, team_50/{GO-SIGNAL-*, HANDOFF_SELF_50_*, MANDATE-TEAM50-*, QA-VERDICT-*, REQA-SIGNAL-*}

## Acceptance
- 4 new `_archive/WP-W2-0N/` dirs, each with `ARCHIVE_MANIFEST.md` (with Path-redirects table).
- The 5 do-not-move files remain at their original paths.
- `_COMMUNICATION` no longer holds the moved WP-scoped artifacts.
- Report back: per-WP moved-file count, manifest path, and confirmation the constraints held.

*team_100 → team_191 | 2026-05-31*
