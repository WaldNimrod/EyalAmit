---
gate: CR-FINAL_FULL-SITE-CONTENT-ACCURACY
wp: WP-W2-15-CR-FINAL
to: team_90
from: team_100
engine_builder: claude-code
date: 2026-06-05
priority: HIGH
status: OPEN
depends_on: CR1-4 merged to main (dual-PASS team_50 + team_190)
---

# MANDATE — team_90 CR-FINAL full-site content-accuracy re-audit + gate ratification

## Why
CR1–CR4 are built, dual-PASSed (team_50 QA + team_190 L-GATE_VALIDATE), and **merged to main**
(`origin/main` @ `2c202fa`). Per the WP-W2-15 program §3C, **CR-FINAL** requires a FULL-SITE
re-audit by team_90 (gate owner) before content can reach "ready". This is the first of the three
CR-FINAL legs (team_90 + team_190 full-site + team_50 E2E).

> HARD RULE: no "ready"/sign-off to team_00/Eyal until this CR-FINAL **triple-PASS** is complete.

## Scope
ALL sourced pages, live staging `http://eyalamit-co-il-2026.s887.upress.link`, branch `main`.

## Tasks
1. **Full re-audit** — run `node scripts/qa/content-diff.mjs` over the whole PAGE_MAP. Confirm
   **every CR1–CR4 sourced page ≥ gate** (section ≥95 · sentence ≥90 · 0 invented) and report the
   site rollup. Current team_100 live baseline: **16/16 in-scope PASS · 96.51% simple / 98.21%
   weighted** (up from the 33.64% / 0-of-17 baseline you established 2026-06-04).
2. **Gate-tool ratification (you OWN content-diff.mjs)** — team_190 already returned
   RATIFY-WITH-FINDINGS on the 7 change groups. As gate owner, **co-sign or dissent**: entity decode ·
   section-coverage calibration (Principal-approved) · sentence-fusion/paragraph fallback ·
   bold-DEV-NOTES + dev/QA/"(להשלמה)" section exclusion · `> DEV NOTE` skip · FAQ-Category/`(חלק N)`
   title strip · dash/ellipsis/maqaf/space-before-punctuation unification. Confirm none lower the
   content bar (they normalize WP display transforms / exclude authoring scaffolding).
3. **Confirm the post-QA fixes landed:** `/sound-healing` & `/faq` now 100% sentence; `/muzza` 301→
   `/books` (canonical); muzza book links → `/books/<slug>`; `hikikomori` unified to **היקיקומורי**
   in render + source.

## Out of scope
- **CR5** (`/mokesh-dahiman`, `/galleries`, `/media`) — BLOCKED on Eyal; expected FAIL/NA. Do not
  count against the CR1–4 rollup.

## Deliverable
`CONTENT-ACCURACY-REPORT-CR-FINAL-2026-06-05.md` + refreshed evidence in
`_COMMUNICATION/team_90/evidence/`. State per-page %, overall %, gate-ratification verdict, and a
clear **CR-FINAL team_90 leg: PASS / FINDINGS** line. Route to team_100. On team_90 ✓ + team_190
full-site ✓ + team_50 E2E ✓ → triple-PASS → team_100 may inform team_00/Eyal "ready".
(Hub API unreachable this session — deliver file-based per ADR043 §4.)
