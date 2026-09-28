# Canon map validation — lane 1: the map against the rulings

Validator: a different engine than the builder (builder = Claude, team_10). Read-only: **do not edit, create or
delete any file except your report**, do not run git commands that change state, do not touch the network.

## Inputs (repo-relative)

1. `_COMMUNICATION/team_10/CANON-STAGE-A-STATE.md` — §3 "Decisions": every ruling D1…D62, each with team_00's own
   words (Hebrew, in «») and what was done. **The Hebrew quote is the authority**; the English column is the
   builder's account of it and may be wrong.
2. `_COMMUNICATION/team_100/EYAL-WORKSPACE/CONTENT-TYPES-CANON.md` — the written canon ("Canon terms and site-wide
   rules", "Grid rules", per-type APPROVED blocks, the audit table).
3. `_COMMUNICATION/team_10/canon-map/tools/canon_types.py` — the map's current types: status (מאושר / מאושר בחלקו /
   פתוח), definition, variants, fields, rules.
4. `_COMMUNICATION/team_10/canon-map/ea-canon-map.html` — the published map (examples labelled «מאושר — …»).
5. `_COMMUNICATION/team_10/canon-map/grids.html` — the locked grid compositions K-n.m.

You do not need to know how the map is built.

## What to check

- **A. Every ruling is in the map and the canon.** For each D-row whose Hebrew quote approves or rules something,
  find where it lands in (2), (3) and (4). Missing, weakened, or contradicted = finding.
- **B. Nothing unapproved.** Every example labelled «מאושר» in (4), every rule in (3) and every APPROVED statement in
  (2) must trace back to a ruling. Anything that does not = finding.
- **C. Superseded rulings.** Later rulings override earlier ones (e.g. D29→D32 text columns, the K-4.2 redefinition in
  D50, the button contrast correction in D54). The map and canon must follow the latest. Stale = finding.
- **D. The three documents agree.** Any contradiction between (2), (3) and (4) — a status, a column range, a
  variant list, a colour, a number = finding.
- **E. Statuses are honest.** A type marked מאושר must have no open item in its rules; a type marked מאושר בחלקו must
  name what is missing.

## Report

Write exactly one file: `_COMMUNICATION/team_10/canon-validation/VERDICT-LANE-1.md`. For each finding:
an ID `L1-n`, the check letter (A–E), the exact location(s) (file + line or the map row ID), the ruling it concerns
(D-number and the Hebrew quote), what is wrong, and severity (blocker / fix / note). End with a verdict line:
`VERDICT: PASS` (zero blocker and fix findings) or `VERDICT: FINDINGS (n)`. Do not soften: a finding you are unsure
of is still a finding, marked «uncertain».
