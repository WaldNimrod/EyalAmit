---
gate: CR-FINAL_FULL-SITE_L-GATE_VALIDATE
wp: WP-W2-15-CR-FINAL
to: team_190
from: team_100
engine_builder: claude-code
engine_validator: team_190 (constitutional, cross-engine — IR#5)
date: 2026-06-05
priority: HIGH
status: OPEN
depends_on: CR-FINAL team_90 leg PASS (2026-06-05)
branch: main @ 9c48714
---

# MANDATE — team_190 CR-FINAL FULL-SITE L-GATE_VALIDATE (leg 2 of 3)

## Context
CR1–CR4 merged to `origin/main` @ `9c48714`. **CR-FINAL team_90 leg = PASS** (full re-audit 16/16,
96.51%/98.21%; gate RATIFY-WITH-FINDINGS). This is the **constitutional full-site validation** —
the second CR-FINAL leg. Live staging `http://eyalamit-co-il-2026.s887.upress.link`.

## Validate (FULL SITE — not just the CR pages)
1. **Content-accuracy holds site-wide** — re-run `content-diff.mjs`; confirm 16/16 sourced CR1–4
   pages still gatePass on `main`.
2. **No-regression across the WHOLE site** (all live routes, incl. elevated chrome/nav/footer,
   blog, contact): 0 horizontal overflow @360/390/414/768, axe 0 critical/0 serious, HTTP 200,
   single H1, RTL, `ea-tokens.css` unchanged vs the WP-W2-14 locked baseline.
3. **Cross-link / redirect integrity:** `/muzza`+`/muzeh` 301→`/books`; nav "מוזה הוצאה לאור"→`/books`;
   book cards → `/books/<slug>` resolve 200; no `/muzeh` or other dead internal links on live.
4. **Constitutional gate ownership (IR#5):** final cross-engine stamp on the calibrated
   `content-diff.mjs` (already RATIFY-WITH-FINDINGS by team_90 + team_190 build-leg) — confirm it
   stands as the canonical CONTENT-ACCURACY gate.

## Out of scope
CR5 (`/mokesh`, `/galleries`, `/media`) — BLOCKED on Eyal.

## Deliverable
`VERDICT_WP-W2-15-CR-FINAL_FULL-SITE-VALIDATE_v1.md` in `_COMMUNICATION/team_190/` — PASS /
PASS_WITH_FINDINGS / BLOCK + evidence. Route to team_100. (Hub API unreachable — file-based, ADR043 §4.)
