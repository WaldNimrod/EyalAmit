---
id: DECISION-F-W2-04-FAQ-PREGNANCY-LINK-2026-05-29
schema_version: aos_v1_team_messaging
from_team: team_00 (Principal)
to_team: team_100 (Chief System Architect)
type: decision
subject: "AOS_decide F-W2-04-FAQ-PREGNANCY-LINK — RECORDED"
date: 2026-05-29
related_wp: WP-W2-04
status: RECORDED
---

# Decision Recorded — F-W2-04-FAQ-PREGNANCY-LINK

**Decision:** A — add `/blog/pregnancy-didgeridoo` "קראו עוד" link to the canonical FAQ dataset
(`block-faq-list.php`) for the lessons entry "האם אפשר בזמן הריון?".

**Q1 (W2-06 import?):** כן — פוסט קיים (W2-06 scope).
**Q2 (מי מממש?):** team_100 — implement immediately as targeted post-closure fix on main.

**Note:** `/blog/pregnancy-didgeridoo` is currently HTTP 404 on staging — post needs to be
published. Link wired in advance (same pattern as GI URLs in W2-05). Once Eyal/team publishes
the post, the link goes live automatically.

**Implementation:** edit `block-faq-list.php` lessons pregnancy entry → add link → redeploy → commit.

*team_00 — 2026-05-29*
