---
id: DECISION_S007_MOBILE_NAV_MECHANISM_2026-09-19
schema_version: aos_v1_team_messaging
type: DECISION RECORD
from: team_100 (under team_00 delegation)
date: 2026-09-19
decisions: [D-26, D-29, D-30]
theme_at_decision: 1.5.71
status: BINDING for the mobile phase
---

# One mobile drawer, on the browser's own modal

## The delegation, in team_00's words

**2026-09-19: «לא מבין את ההתנגשות בנושא התפריט. אם יש שאלה בין שני עיצובים שונים או ממשקים
שונים - צריך סקיצת השוואה. אם זה שאלה טכנית - אתם בוחרים את ההיתנהגות המיטבית ומה שיהיה יציב
ומדוייק יותר לאתר שלנו ולסגנון שלו.»**

And, on the June package: **«עברתי על הסקיצה היא בסיס טוב - כמובן צריכה התאמה לתוכן ולעיצובים
הנוספים שנכנסו במהלך הדרך.»**

## There was no design conflict to sketch

The site currently serves **three different mobile menus**, and which one a visitor sees
depends only on which page they opened. None of the three was ever chosen:

- **Chapters `.nav__burger`** — most of the site. Behaviourally correct today: 0 of 22 items
  reachable when closed (`visibility:hidden`), `nav-locked` set on open.
- **Wave2 `ea-mnav`** — `/about/` and `/press/` only. The **designed** one, from the June
  package, whose own spec covers focus trap, Escape, scrim and both writing directions. The
  spec is sound; the implementation is not — closed it is `transform:translateX(-335px)` with
  `visibility:visible`, leaving **22 of 28 stops on `/about/` and 10 of 16 on `/press/`**
  reachable by keyboard, first one at x=−96, and the background is not inert when open.
- **GeneratePress `.menu-toggle`** — the bare parent theme, showing through on the pages that
  fall outside both systems.

They exist because the Chapters template system replaced the navigation **after** the June
design had been implemented, and that work was orphaned. That is a leftover, not a
disagreement. **So this is a technical question, and D-30 applies.**

## The decision

**One drawer for the whole site. The June package's design. Built on a native `<dialog>`
opened with `showModal()`.**

Rationale, and none of it is speculative — all four were measured end to end on this site on
2026-09-19, on the lightbox at `/snoring-sleep-apnea/`:

1. **Focus trap, Escape-to-close, background inertness and focus-return to the opener are the
   browser's job** and cost no code. A hand-rolled drawer has to implement four things
   correctly; this site has already shipped the wrong version of two of them.
2. **The pattern is already live here** — both the lightbox and the new TOC mobile sheet use
   it, and both were independently verified. Choosing it is choosing something that works
   here, not something expected to.
3. **Top-layer rendering removes the z-index fight** with the WhatsApp float at `z-index:60`,
   which has cost this project time before.

## The cost, stated rather than discovered later

`showModal()` is all-or-nothing. **No partially-open drawer, no peeking edge, and the page
cannot be scrolled behind it while it is open.** If a partial drawer is ever wanted, that is a
different decision and this record is where it gets revisited.

## What "adaptation" of the June package actually means

Not cosmetic. Before any of it is built:

- **Every font size in those mockups is dead.** They predate the locked scale by three months.
  Canon §7 lists the dead figures. Re-type onto the twelve rungs; never copy a number across.
- **Four elements postdate the package entirely** and do not appear in it: the TOC element in
  its three states, the image lightbox, the FAQ accordion, and the testimonial cards now being
  built under M-09.
- **The section rhythm changed** after team_00 asked for less air: `--sec` is
  `clamp(62px,6.2vw,88px)`, and at phone width it floors at 62px — which the mobile baseline
  measured as more air than content on the snoring page's first band.

## Sequencing note

M-08 repairs the Wave2 drawer's closed-state focusability **now**, knowing this decision will
replace it. That is deliberate: it is a live accessibility defect on two published pages. The
mandate tells team_10 to match the Chapters behaviour minimally and not to invest in it.
