---
id: MANDATE_S007_M01_DESIGN_DELTA_2026-09-18_v1.0.0
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00]
date: 2026-09-18
law: TASK-S007-RESPONSIVE-MOBILE-2026-09-18.md
disposition: MAP AND REPORT. No corrective change to the site under this mandate.
---

# S007 M-01 · The approved design versus the live site

**You manage this.** Dispatch **short, cheap Composer lines — one specific task each**:
open a page, capture it, bring evidence back. Do not run one long line over everything.

**Engine cost order (team_00, 2026-09-18):** Grok first · `composer-2.5` for black work ·
GPT only when an extra edge is genuinely needed. `scripts/run_cross_engine_validator.sh`
now defaults to Grok and its per-attempt timeout is 900s.

**Fix nothing.** Fixes wait for the accessibility milestone to close. A mandate that maps
and a mandate that repairs are different mandates, and mixing them loses the map.

## Read first

- `_COMMUNICATION/team_100/S006/TASK-S007-RESPONSIVE-MOBILE-2026-09-18.md` — the task in
  team_00's own words. The bar is not "valid code", it is that the site looks right, reads
  well, and is pleasant on a phone.
- `_COMMUNICATION/team_100/S006/FOUND-TEAM35-MOBILE-DESIGN-2026-09-18.md` — why this
  mandate exists at all.
- `_COMMUNICATION/team_100/S006/RESEARCH-S007-RESPONSIVE-MOBILE-2026-09-18.md` — the
  measurable dimensions, the tooling, the traps, and which mobile items the accessibility
  work already closed. **Do not re-open those.**
- `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/` — `README-MOBILE.md`,
  `NAV-DRAWER-SPEC.md`, `BREAKPOINT-NOTES.md`, `DELTA-AND-FIXES.md`, and the 11 mockups.

## The core fact this mandate turns on

The mobile design was approved, implemented as `ea-mobile-nav.css` / `ea-mobile-nav.js` /
`ea-mobile-variants.css`, and then orphaned when the Chapters system replaced the
navigation. All three still load on every page. team_100 measured on the live mobile home
page: `.ea-topnav`, `.ea-mnav-drawer`, `.ea-mnav-link`, `.ea-mnav-burger`, `.ea-cfoot`,
`.ea-shop-grid`, `.ea-book-card` — **zero elements each**.

So this is not "audit the site". It is: **what was approved, what shipped, and where do
they differ.**

## The pairs to compare

Eleven mobile mockups in `handoff-WP-W2-10-MOBILE/mockups/`. Establish the live counterpart
for each and state how you determined it. Expected pairing, to verify not assume:
Home-Dashboard → `/` · Service-Treatment → `/treatment/` · Method → `/method/` ·
Editorial-About → the about/Eyal page · Memorial-Mokesh → the Mukesh page ·
Commerce-Books-Archive → the books or shop hub · Commerce-Book-Detail → one book page ·
Galleries-Catalog → `/galleries/` · Media-Catalog → the media/testimonials page ·
EN-Landing → `/en/` · Mobile UI → the nav and footer chrome, which is cross-cutting.

**If a mockup has no live counterpart, that is a finding, not a blocker.** Say so.

## For each pair

Open the mockup and the live page side by side at the same viewport. Capture both.
Report the differences that a person would notice, in this order of interest:

1. **Structure** — sections present in one and not the other; order changed.
2. **Typography** — size, weight, line height, line length. The design's own stylesheets
   use ad-hoc sizes and so does the theme; where they differ, give both numbers.
3. **Spacing and rhythm** — does it breathe where the design breathes.
4. **Component behaviour** — the per-component decisions the handoff says were *decided*:
   three-column comparison, shop columns, testimonials, timeline. Did the live site
   implement the decision, a different one, or none.
5. **Imagery** — crop, aspect, position.
6. **The chrome** — navigation and footer, against `NAV-DRAWER-SPEC.md`.

Viewports: **390px** primary; also **768px** and one desktop width where the design has a
desktop counterpart. `BREAKPOINT-NOTES.md` names 1023 / 767 / 639 — check the live site
actually breaks there.

## Classify every gap — this is what the owner will decide from

Each finding carries exactly one classification, with a one-line reason:

- **FIX-NOW** — unambiguous, no design judgement needed, low risk. The design already
  decided it and the live site simply does not do it.
- **SHOW-FIRST** — needs team_00's eye before we build. A visual or proportional choice
  where reasonable people differ, or where the design and the current site are both
  defensible.
- **BACK-TO-35** — the design does not answer it, or answers it for a page/state that no
  longer exists, or the content has changed enough that the design no longer fits.
- **ALREADY-CLOSED** — the accessibility work or a later change already resolved it. Name
  which. Do not re-report these as open.
- **SUPERSEDED** — the design is genuinely out of date and the live behaviour is better.
  Say why; this is a legitimate answer and team_00 would rather hear it than have us build
  backwards.

## Screenshots

`tmp/qa/s007-design-delta/<page-slug>/` — `mockup-390.png`, `live-390.png`, and any
detail crop as `detail-<what>.png`. **Full-page mobile captures come out 20,000px tall and
are unreviewable** — slice by section and name each slice for what it shows. Every finding
in the report links to its image by relative path.

## Report

`_COMMUNICATION/team_10/DONE-S007-M01-DESIGN-DELTA-2026-09-18.md`

It must let team_00 hold a discussion, make decisions, and build a **measurable** plan. So:
a summary table of every finding with its classification; the findings grouped by page;
for each, what the design says, what the site does, the image links, and a size estimate;
then three consolidated lists — everything FIX-NOW, everything SHOW-FIRST, everything
BACK-TO-35 — because those are the three conversations he will actually have.

Also report, plainly: what you could not compare and why, and anything where the mockup
itself is ambiguous.

## Constraints

- Content law: if text does not fit, that is a layout finding or a question for Eyal, never
  a silent edit.
- Right-to-left site. The RTL audit at `_COMMUNICATION/team_10/RTL-AUDIT-2026-09-17/` found
  several mobile-relevant issues — read it rather than rediscovering them.
- Staging returns short incomplete responses under repeated probing. Assert each page
  loaded before judging it. Probe serially.
- A 0x0 viewport returns real-looking wrong numbers. Assert it is non-zero.
- Every claim about code cites `file:line`. Never `git add -A`.
