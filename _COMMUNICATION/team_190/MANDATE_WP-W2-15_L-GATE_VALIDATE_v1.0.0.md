---
gate: L-GATE_VALIDATE
wp: WP-W2-15
to: team_190
from: team_100
engine_builder: claude-code
engine_validator: team_190 (cross-engine, constitutional — IR#5)
date: 2026-06-05
priority: HIGH
status: OPEN
depends_on: team_50 VERDICT PASS_WITH_FINDINGS (2026-06-05) + team_100 findings resolution
---

# MANDATE — team_190 L-GATE_VALIDATE (WP-W2-15 CR1–CR4)

## Context
CR1–CR4 content reconciliation is built, deployed to staging, self-measured by team_100,
and **independently QA-passed by team_50** (PASS_WITH_FINDINGS, 16/16 in-scope). team_100 has
resolved the actionable findings (see `_COMMUNICATION/team_100/FINDINGS-RESOLUTION_WP-W2-15_team50_2026-06-05.md`).
This mandate is the **constitutional cross-engine validation** (Iron Rule #5) before batch close.

Branch `wp-w2-15-cr1` · staging http://eyalamit-co-il-2026.s887.upress.link

## Validate
1. **Content-accuracy** — re-run `node scripts/qa/content-diff.mjs`; confirm 16/16 in-scope pages
   gatePass (section ≥95 · sentence ≥90 · 0 invented). Current live: 96.51% simple / 98.21% weighted.
2. **Gate-tool ratification (constitutional):** `scripts/qa/content-diff.mjs` was modified by the
   builder (team_100). Independently review every change (entity decode · section calibration ·
   sentence-fusion/paragraph fallback · bold-DEV-NOTES + dev/QA/placeholder section exclusion ·
   `> DEV NOTE` skip · FAQ-Category/`(חלק N)` title strip · dash/ellipsis/maqaf/space-before-punct
   unification) and rule whether each is a legitimate WP-display-transform normalization (vs.
   bar-lowering). Co-sign with **team_90** (gate owner). RATIFY / RATIFY-WITH-FINDINGS / REJECT.
3. **No-regression:** 0 horizontal overflow @360/390/414/768, axe 0 critical/0 serious, HTTP 200,
   single H1, RTL, `ea-tokens.css` unchanged — across all 17 CR routes incl. `/muzza/` (301→/books).
4. **Verbatim integrity:** spot-check ≥3 pages against `25.5.26/` source.

## Out of scope / carried
- CR5 (`/mokesh`, `/galleries`, `/media`) — BLOCKED on Eyal.
- Eyal/source items: hikikomori spelling, `/contact`-in-prose slug, `/muzza` vs `/books` canonical
  preference (interim decision = /books).

## Deliverable
`VERDICT_WP-W2-15_L-GATE_VALIDATE_v{N}.md` in `_COMMUNICATION/team_190/` — verdict + gate-tool
ratification opinion (co-signed team_90). On dual-PASS (team_50 ✓ + team_190) → team_100 merges
CR1–CR4 to main + locks roadmap. (Hub API unreachable this session — deliver file-based, ADR043 §4.)
