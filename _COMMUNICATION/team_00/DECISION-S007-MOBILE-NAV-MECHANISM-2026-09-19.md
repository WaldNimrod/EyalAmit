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

---

# team_00's rulings on the drawer, 2026-09-19 — and what they cost, measured

## The rulings

**«מגירה מאושר - יש לנו המון עמודים - חובה לוודא שנכנס במסך או לצמצם רווחים»**
**«הכול כולל הכול בלי שום עמוד חריג.»**
**«כשהמגירה נפתחת - כפתור וואטסאפ או מאחור או מוסתר»**

So: the drawer is approved; **every page gets it, with no exception** — the six pages still on
the bare parent theme included; it **must fit the screen or the spacing comes down**; and the
WhatsApp float must go **behind or away** while it is open.

## What "fit the screen" actually costs — measured, not estimated

Live on `/about/` at **390×844**, the existing designed drawer opened with a real click:

- **11 top-level items, 25 rows in total.** Three sub-lists, and they are **open by default** —
  there is no collapsing today, which is why the list is as long as it is.
- The list box is **597px** tall and already carries `overflow-y:auto`, so it **does** scroll
  inside itself rather than spilling off the screen.
- Content measures **660px**. **63px sit below the fold**, and **18 of the 25 rows are fully
  visible without any scrolling.**

**So it fits today, and the gap is 63px.** Spread over 25 rows that is **under 3px of vertical
padding per row** — which is the cheapest possible version of his "reduce spacing", and it
makes the entire menu reachable on an iPhone 14 with no scrolling at all.

**Internal scrolling still has to stay.** At 375×667 the viewport is 177px shorter and no
amount of reasonable trimming closes that. The rule is therefore: **trim so it fits on a
844-tall phone, keep `overflow-y:auto` so a 667-tall phone degrades to a scroll instead of a
clipped menu.** Never `overflow:hidden` on that list.

**And the row height is not a free variable.** Rows are 59px today, which is above the 44px
touch-target floor with room to spare; trimming 3px keeps it there. Do not trim below 44px of
hit area to win space — that trades one accessibility problem for another.

## The WhatsApp float

Today it renders **on top of** the open drawer — visible in the comparison screenshots. It
sits at `z-index:60`. **A native `<dialog>` opened with `showModal()` solves this by
construction**: the dialog is in the browser's top layer, which is above every z-index on the
page, so the float ends up behind it without a single line of z-index arithmetic. That is a
second, independent reason the mechanism decided above is the right one.

If the float must be **hidden** rather than merely behind — his wording allows either — hide it
with `visibility:hidden`, never `opacity:0`, or it stays in the tab order behind a modal.

## No exceptions means the six orphan pages too

`/services/`, `/shows-heritage/`, `/historical-articles/`, `/thank-you/`, `/courses-soon/`,
`/learning/courses-external/` currently serve GeneratePress's own toggle — a white panel with
the brand in lowercase Latin. **They get the same drawer as everything else.** That is the
single clearest instruction in this whole record, and the one a future session is most likely
to quietly drop, because those six pages have been missed by every sweep on this milestone.

---

## The last open question, closed — 2026-09-19

**team_00: «והמגירה שנועלת את העמוד מאחוריה לגמרי - מקובל»**

The all-or-nothing cost stated above is **accepted**. `showModal()` stands: no partial drawer,
no peeking edge, and the page does not scroll while the drawer is open.

**Every question on the mobile navigation is now answered.** The look is the June package's
drawer; the mechanism is the browser's own modal; every page gets it with no exception; the
WhatsApp float goes behind or away; the row spacing comes down by roughly 3px so the menu fits
a 844-tall phone without scrolling, while `overflow-y:auto` stays as the floor for shorter
phones; and the background locking completely is approved rather than tolerated.

**Nothing on this element is waiting on team_00 any more.** What remains is building it, and
that is blocked only by the mobile phase itself starting.

