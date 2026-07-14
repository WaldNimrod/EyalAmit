---
id: MANDATE-TEAM90-L-GATE_VALIDATE-WP-CANON-TEMPLATE-UNIFICATION-2026-07-14
from_team: team_110
to_team: team_90
cc: team_00, team_100
date: 2026-07-14
type: mandate
wp: WP-CANON-TEMPLATE-UNIFICATION
gate: L-GATE_VALIDATE
depends_on: L-GATE_BUILD verdict for same WP
builder_engine: cursor-composer (team_110)
---

# MANDATE — team_90 · L-GATE_VALIDATE · WP-CANON-TEMPLATE-UNIFICATION

Run **after** L-GATE_BUILD PASS / PASS_WITH_FINDINGS.

Constitutional / cross-engine validate of the shipped Wave2→Chapters unification against LOD400 acceptance criteria (§5–§7), with emphasis on:

- QR URL preservation (100% of `/qr/qrN/`)
- No undefined commerce functions after Wave2 deletes
- FAQ many-to-many fidelity vs visible accordion
- Mokesh VideoObject vs hero-prohibition lint
- Residual Wave2 scope honesty (w2-07 /press, frozen stage-b)

Artifact: `_COMMUNICATION/team_90/VERDICT-WP-CANON-L-GATE_VALIDATE-2026-07-14.md`

Iron Rule #1: builder engine ≠ validator engine.
