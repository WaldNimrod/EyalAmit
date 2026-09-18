---
id: MANDATE_S007_M01_TYPOGRAPHY_DELTA_2026-09-18_v1.0.0
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00]
date: 2026-09-18
law: TASK-S007-RESPONSIVE-MOBILE-2026-09-18.md
disposition: MAP AND REPORT. Typography only. No corrective change under this mandate.
---

# S007 M-01 · Typography — the approved design versus the live site

## ⚠ Scope, narrowed by team_00 on 2026-09-18

> «אנחנו מטפלים כרגע רק בנושא טיפוגרפיה — לא בתבניות של אלמנטים. זה יבוצע בנפרד.»

**Typography only.** Type size, weight, line-height, letter-spacing, line length, and the
relationships between them.

**Out of scope, deliberately, and to be a separate mandate:** section structure and order,
component layout, spacing and padding except where it is line-height, imagery and crops,
grid and column decisions, the nav drawer's behaviour. If you notice one, note it in a
single "seen in passing" list at the end — one line each, no screenshots, no analysis —
and move on. Do not let it pull the mandate.

**You manage this.** Dispatch **short, cheap Composer lines — one specific task each**.
**Engine cost order (team_00):** Grok first · `composer-2.5` for black work · GPT only for
a genuine extra edge. `scripts/run_cross_engine_validator.sh` defaults to Grok, 900s.

**Fix nothing.** Fixes wait for the accessibility milestone to close.

## Read first

- `_COMMUNICATION/team_100/S006/TASK-S007-RESPONSIVE-MOBILE-2026-09-18.md`
- `_COMMUNICATION/team_100/S006/FOUND-TEAM35-MOBILE-DESIGN-2026-09-18.md`
- `_COMMUNICATION/team_100/S006/RESEARCH-S007-RESPONSIVE-MOBILE-2026-09-18.md`
- `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/` and the desktop clusters in
  `_COMMUNICATION/team_35/WP-W2-10-*/`

## What team_100 has already measured — take as given, verify if cheap

**Neither side has a type scale.** `ea-tokens.css` declares **zero** font sizes, and there
is not one `font-size:var(...)` anywhere in the theme. Live CSS carries **242** hardcoded
`font-size` declarations plus 21 in `style.css`. Only 11 use `clamp()`.

The design's own stylesheets do the same: `.62 .66 .68 .7 .74 .76 .78 .8 .82 .86 .92rem`.
**So the scattered sizes are inherited, not our drift.**

Live nav, measured 2026-09-18: top-level link **12.8px** weight 300 against body text
**18.88px** — the menu is 68% of body size. EN toggle **11.52px**, the smallest text on the
site, and it is a control. In the mobile drawer the top-level items rise to 16px but
submenu links stay at **12.8px**.

team_00's two stated directions: **the main menu is too small**, and **body text should be
smaller**.

## The work

### Part 1 — the delta

For each of the 11 mobile mockups and their live counterparts, plus the desktop clusters
where a desktop counterpart exists, compare **type only**. For every distinct text role —
page title, section heading, sub-heading, body, lead paragraph, caption, card title, card
blurb, meta, label, form input, form label, button, nav item, submenu item, footer text,
legal text — report:

    role · mockup px / weight / line-height · live px / weight / line-height · delta

Measure the **rendered** values in a browser, not the declared rem in the file: the two
differ because of the root size, and the root size is part of what is under discussion.

Viewports: **390px** primary, **768px**, and one desktop width.

### Part 2 — the line-length question

For the prose-heavy pages, report measured **characters per line** at each viewport, in the
mockup and live. This is the single strongest lever on reading comfort and nobody has
measured it here. Hebrew counts differently from Latin — say which you counted.

### Part 3 — propose the scale

Neither side has one. Propose a type scale: a small set of steps, each with a name, a value,
and the roles that map to it. Show which of the ~263 live declarations collapse into which
step, and name every declaration that does **not** fit and why. Six near-identical small
sizes almost certainly become two or three; say which and what is lost.

State plainly where the scale would change the current appearance and by how much. team_00
wants the menu larger and the body smaller: show what that looks like as scale values, not
as a sentence.

## Classify every gap

One classification each, one line of reason:

- **FIX-NOW** — the design already decided it, the site does not do it, no judgement needed.
- **SHOW-FIRST** — needs team_00's eye. Any change to body or heading size is this by
  default: he asked to be shown.
- **BACK-TO-35** — the design has no answer, or its answer no longer fits the content.
- **ALREADY-CLOSED** — resolved by the accessibility work. Name which. Do not re-report.
- **SUPERSEDED** — live is genuinely better than the design. A legitimate answer.

## Screenshots

`tmp/qa/s007-typography/<page-slug>/` — `mockup-390.png`, `live-390.png`, plus a detail crop
per finding. **Full-page mobile captures come out 20,000px tall and are unreviewable** —
slice by section and name each slice for what it shows. Every finding links its image by
relative path.

Where a size difference is small, a side-by-side crop of the same text at the same zoom is
worth more than any number. Produce those for the roles team_00 will decide on.

## Report

`_COMMUNICATION/team_10/DONE-S007-M01-TYPOGRAPHY-DELTA-2026-09-18.md`

Must support a real discussion and a measurable plan: the full delta table; the scale
proposal; three consolidated lists (FIX-NOW, SHOW-FIRST, BACK-TO-35); what you could not
measure; and the short "seen in passing" list of non-typography observations.

## Constraints

- Content law: if text does not fit, that is a finding or a question for Eyal, never an edit.
- RTL site. Read `_COMMUNICATION/team_10/RTL-AUDIT-2026-09-17/` first.
- Staging returns short incomplete responses under repeated probing — assert each page
  loaded, probe serially. A 0x0 viewport returns real-looking wrong numbers — assert non-zero.
- Every claim about code cites `file:line`. Never `git add -A`.
