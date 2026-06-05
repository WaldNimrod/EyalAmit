---
gate: CR-FINAL_FULL_E2E
wp: WP-W2-15-CR-FINAL
to: team_50
from: team_100
engine_builder: claude-code
engine_validator: cursor (IR#1)
date: 2026-06-05
priority: HIGH
status: OPEN
depends_on: CR-FINAL team_90 leg PASS (2026-06-05)
branch: main @ 9c48714
---

# MANDATE — team_50 CR-FINAL full E2E (leg 3 of 3)

## Context
CR1–CR4 on `origin/main` @ `9c48714`; CR-FINAL team_90 leg PASS, team_190 full-site in parallel.
This is the **end-to-end user-journey** leg — the third and final CR-FINAL gate before content can
reach "ready". Live staging `http://eyalamit-co-il-2026.s887.upress.link`.

## E2E scope — exercise real journeys, not just the gate
1. **Navigation:** every top-nav item resolves (incl. "מוזה הוצאה לאור" → `/books`); `/muzza` 301→
   `/books`; breadcrumb/back-links work; mobile drawer (WP-W2-14) intact.
2. **Content journeys:** home → service (treatment/sound-healing/lessons/method) → FAQ → contact;
   books hub `/books` → each book detail `/books/{vekatavta,kushi-blantis,tsva-bekahol}`; shop
   `/didgeridoos,/bags,/stands-storage,/stand-floor,/repair`. Verbatim copy renders, CTAs link
   correctly, no console errors, no broken images.
3. **Forms/CTAs:** contact CTAs reach `/contact`; external purchase links open correctly.
4. **Responsive + a11y sanity** across 360/390/414/768/desktop on the journeys above.
5. **Spot verbatim** ≥3 pages vs `25.5.26/` source (confirm hikikomori = היקיקומורי, etc.).

## Out of scope
CR5 (`/mokesh`, `/galleries`, `/media`) — BLOCKED on Eyal.

## Deliverable
`VERDICT_WP-W2-15-CR-FINAL_E2E_v1.md` in `_COMMUNICATION/team_50/` — PASS / PASS_WITH_FINDINGS /
BLOCK + evidence. Route to team_100. On **triple-PASS (team_90 ✓ + team_190 ✓ + team_50 ✓)** →
team_100 may inform team_00/Eyal that content is "ready". (Hub API unreachable — file-based, ADR043 §4.)
