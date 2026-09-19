---
id: MANDATE_S007_M08_INVISIBLE_BUT_FOCUSABLE_2026-09-19
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00, team_50]
date: 2026-09-19
evidence: _COMMUNICATION/team_50/XVAL-MOBILE-BASELINE-2026-09-19.md, _COMMUNICATION/team_50/XVAL-A11Y-TABWALK-2026-09-19.md
theme_at_dispatch: 1.5.71
status: DISPATCHED
---

# M-08 · Three controls a keyboard can reach and an eye cannot find

**team_00 approved this batch on 2026-09-19.** All three are the same defect class, all three
are measured, none needs a design decision. This is accessibility, not styling.

**The principle, and it has now bitten this site four times:** `visibility:hidden` and
`display:none` remove an element from the tab order. `opacity:0` and `transform:translateX()`
do not. A control hidden by paint alone is still reachable, and a keyboard user lands on
something that is not on screen.

## The three

**1. The closed Wave2 drawer on `/about/` and `/press/`.**
Closed `ea-mnav` computes `display:flex; visibility:visible; opacity:1;
transform:translateX(-335px)` — no `inert`, no `aria-hidden`. Measured: **22 of 28 stops on
`/about/` and 10 of 16 on `/press/`** are inside the closed drawer, first one at **x=−96**.
The Chapters burger already does this correctly (0 of 22 reachable when closed, via
`visibility:hidden`) — copy that, do not invent a second mechanism.

**2. The same drawer's background is not inert when it is open.**
`main.click()` reached the page behind it, and there is no scroll lock. The Chapters drawer
sets `nav-locked`; the native `<dialog>` route (`showModal()`) gives inertness, Escape and
focus return for free. Pick one and say which.

**3. Five FAQ topic chips take focus off-screen.**
`.ea-faq-toc__link` at `left` = −69, −32.7, −26.6, −60.9, −64.7 in a 390px viewport; the chip
row itself is a 2139px horizontal RTL scroller. The fix is that focusing a chip scrolls it
into its own row, not that the row stops scrolling.

## What NOT to do

Do not put `visibility:hidden` on an element that carries a control's **accessible name**. On
2026-09-19 the TOC rail's labels were left at `opacity:0` deliberately for exactly this
reason: they are the links' names, and hiding them would leave eleven links nameless. Hide the
**container**, or remove it from the tab order — never the name.

## Verification, and it must be a real tab walk

Real key events, not an `element.focus()` loop — a simulated focus loop has given wrong
answers on this project. For each page: every stop's rectangle, computed `visibility`,
`opacity`, and whether it is inside the viewport after the browser's own focus scroll.
`/about/` and `/press/` at 390 and at 1440; `/faq/` at 390. Report the stop counts before and
after.

## Limits

No `git add -A`. Do not touch `_aos/`. Bump `style.css` `Version:`. The deploy script ships
the working tree and refuses a dirty `site/`. Report to team_100 (`eyalamit-co-il-2026-76`).
Validation is team_50's, on a different engine.
