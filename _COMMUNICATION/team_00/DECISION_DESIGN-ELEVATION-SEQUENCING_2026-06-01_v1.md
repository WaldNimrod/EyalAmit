---
id: DECISION_DESIGN-ELEVATION-SEQUENCING_2026-06-01_v1
title: Design-elevation vs implementation sequencing (S003 UI-Precision)
type: aos_decide — DECISION RECORDED
date: 2026-06-01
from_team: team_00 (Principal)
decided_by: team_00
brief_ref: (aos_decide brief, this session)
status: DECIDED
decision: Option C — Hybrid, cluster-tiered
milestone: S003
---

# DECISION — Option C (Hybrid, cluster-tiered)

## Context
The D-14 design system + S1 team_35 mockups are **composition-on-real-content** ("looks like a website,
but far from the final visual design we'll need"). Decision: where the high-fidelity design happens and
in what order relative to implementation. Five options were briefed (A implement→elevate→reimplement;
B elevate→implement once; C hybrid; D system D-14→D-15 first; E parallel).

## Ruling (team_00, 2026-06-01)
**Option C — Hybrid, cluster-tiered.** Two tracks:

### Track-1 — BASE (implement now, low-visual-risk / settled)
Implement the settled clusters now for a working spine — **no team_35 elevation needed**:
- **Home** (`tpl-home`) — POC-reviewed composition (the one reviewed comp); refine + interim hero placeholder.
- **Conversion** (`tpl-contact`, `tpl-faq`) — templates already REAL.
- **Blog** (`tpl-blog-archive`, `tpl-blog-single`) — built in W2-06; implement the D composition.

→ Canonical WP: **WP-W2-11 (S003 Base Implementation)**, LOD400. Executed by the next session
(S3 team_10 → S4 team_80 → S5 team_50/190), orchestrated via the aos_handoff full 100.

### Track-2 — ELEVATION (high-visual; design lift FIRST, then implement)
The stub/high-visual clusters go through real design elevation before implementation:
- **A Service**, **B Editorial**, **E Commerce**, **F EN** → **team_35 (claude-design)** improvement + precision
  (with team_00/nimrod) → **Eyal approval** → implement the final template.
- **G Hero video** — remains BLOCKED on Eyal's video asset.

→ Stays under **WP-W2-10** (umbrella + A/B/E/F children), team_35 elevation path.

## Flow (team_00-stated)
1. Implement the **base** (WP-W2-11) — next session orchestrates.
2. Hand the high-visual clusters to **team_35** for improvement/precision (with nimrod).
3. **Eyal approval** of the elevated designs.
4. Implement the **final** templates.

## Rationale
Best momentum-vs-quality balance: ship the settled spine fast (real value + a live base), concentrate
design-elevation effort where perception is driven (flagship pages), and honor the phase-plan §6 rule
(front-load sign-off before refining the high-visual pages) — avoiding a rework cascade where it matters.

## Open parameters (from the brief)
- gap-type: treated as **compositional** (layouts), not systemic — so D-14 stays; no D-15 system rebuild.
- time-pressure: base ships now (Track-1); elevation runs in parallel/after (Track-2).

## Next actions
- ✅ WP-W2-11 LOD400 authored + registered (this session).
- ✅ Merge + push (preliminary to handoff).
- ✅ aos_handoff full 100 → next session orchestrates WP-W2-11 base implementation.
- ⏭ team_35 elevation (Track-2) initiated after / alongside, with Eyal sign-off gate.

*team_00 | Option C (hybrid) DECIDED 2026-06-01.*
