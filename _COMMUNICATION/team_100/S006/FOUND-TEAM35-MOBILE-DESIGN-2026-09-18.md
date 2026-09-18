
> ⚠ **HISTORICAL — not the current state.** Typography and CSS sizing are governed by
> `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`, locked at theme 1.5.56. Numbers in
> this file were true when it was written. **Do not act on a font-size figure from here**
> without checking the canon first — §7 there lists the specific figures that are dead.
> Kept because the measurements and the method are still useful; the conclusions are not.
# The mobile design already exists, was built, and is stranded

team_100, 2026-09-18. Found on team_00's recollection that «צוות 35» had produced design work.
He was right, and what is there is bigger than sketches.

## What exists

`_COMMUNICATION/team_35/` — 83 files, 25 HTML mockups, 18 images, 37 documents, dated
2026-05-31 and 2026-06-03. Seven desktop clusters (WP-W2-10 A–G), a Track-2 desktop
elevation, and a dedicated **mobile** handoff.

`handoff-WP-W2-10-MOBILE/` contains, in its own words, a **high-fidelity** package:
`README-MOBILE.md`, `NAV-DRAWER-SPEC.md` (open/close, accordion, focus trap, Escape, scrim,
RTL and LTR), `BREAKPOINT-NOTES.md` (per-component behaviour at 1023 / 767 / 639),
`DELTA-AND-FIXES.md`, eleven mobile mockups, and three implementation stylesheets.

It states that the open mobile questions — three-column comparison, shop columns,
testimonials, timeline — were **decided**, not left open. And it names the review blocker it
was built to close: «התפריט הראשי לא אחיד בכל התבניות».

## What happened to it

It was implemented, as `assets/ea-mobile-nav.css`, `assets/ea-mobile-nav.js` and
`assets/ea-mobile-variants.css` — the exact filenames the handoff specifies.

Then the Chapters template system replaced the navigation, and that work was orphaned.

**Measured on the live mobile home page (390px), 2026-09-18:**

    stylesheets loaded : ea-mobile-nav.css, ea-mobile-variants.css
    scripts loaded     : ea-mobile-nav.js

    .ea-topnav         0 elements
    .ea-mnav-drawer    0
    .ea-mnav-link      0
    .ea-mnav-burger    0
    .ea-cfoot          0
    .ea-shop-grid      0
    .ea-book-card      0

Every visitor downloads the mobile design layer on every page. It applies to nothing.

This is the same body of dead code three independent audits reached separately — the RTL
audit, the accessibility structure line and the interactive line — each noting that the
better-written implementation sits on the dead side. The interactive line specifically
praised this drawer's real focus trap, Escape handling and focus restore, and recorded that
it is unreachable on any live page. **It is unreachable because it belongs to a superseded
system, not because it was written badly.**

## Why this changes the responsive task

We are not starting from nothing, and we are not starting from sketches. There is a
signed-off mobile design with per-component decisions already made, and a working
implementation of its navigation sitting one wiring change away from the live system.

The mapping work should therefore begin by comparing **what is live** against **what was
designed and approved**, and reporting the delta. That is a far more useful report than an
inventory of things that look slightly off, and it is likely to answer several of the
questions the mapping would otherwise have to raise.

## And a finding that changes the typography question

The design's own stylesheets use ad-hoc sizes: `.62`, `.66`, `.68`, `.7`, `.74`, `.76`,
`.78`, `.8`, `.82`, `.86`, `.92rem`. So the six near-identical small sizes in our theme are
**not our drift — they are inherited**. The design was never built on a type scale either.

Consequence: introducing a scale is not cleanup. It is a **new design decision**, and the
right place to take it is back to the design source rather than to settle it in a stylesheet.
That is precisely the conversation team_00 proposed having with a mockup in hand.

## Immediate, unrelated win available

Three stylesheets and one script are fetched by every visitor on every page and match zero
elements. Removing them from the enqueue is a pure performance gain with no visual risk —
but it must be folded into the standing dead-code decision from the RTL audit, not taken
unilaterally, because these files are also the reference implementation we may want back.
