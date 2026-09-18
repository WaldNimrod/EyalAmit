
> ⚠ **HISTORICAL — not the current state.** Typography and CSS sizing are governed by
> `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`, locked at theme 1.5.56. Numbers in
> this file were true when it was written. **Do not act on a font-size figure from here**
> without checking the canon first — §7 there lists the specific figures that are dead.
> Kept because the measurements and the method are still useful; the conclusions are not.
# The row rhythm: why the home page is beautiful and the others are flat

team_100, 2026-09-18. This is Phase 4's deliverable — **a definition and a reference map,
no corrective work.** It exists to test one claim by team_00:

> «דף הבית יפה מאוד, רוב העמודים האחרים דורשים עבודה ונגיעות עיצוב כי הן בפועל ברובם לא
> עומדים בתבניות ולא כוללים שורות עם סגנונות מתחלפים כמו בתבניות.»

**Measured, and true — more sharply than stated.**

## The numbers

Of the 29 pages that run through the shared rendering mechanism:

- **11 pages (38%) have zero alternating rows anywhere in the body.**
- **21 pages (72%) have at most one.**
- Only three reach as many as three.

The home page carries **five** alternating or dark rows within nine to twelve sections,
plus a full-bleed image band, plus a dark component, plus a dark closing band.

## Why — and it is structural, not carelessness

**The home page is built from eleven bespoke template files used by nothing else.**
`section-hero`, `section-01-about` … `section-07-how-to-start`, `section-photo-band`,
`section-home-03-video`, `section-home-09-peek` — each is referenced by exactly one
template, `tpl-chapters-home.php`. They are **architecturally incapable of being reused**
on another page. Its rhythm was composed by hand, section by section, and it does not even
alternate regularly — two cream rows sit back to back, two dark ones do too. It reads as
composition, not formula.

**Every other page runs one generic loop** over a shared library of parts, and that loop
contains **no alternation logic at all.** team_100 verified directly: there is no modulo, no
section index, no odd/even, nothing. The only index arithmetic in the file concerns ACF slot
merging.

**So every row defaults to plain, and a variant is an explicit per-section request.**
And across **33 defaults files, only four carry even one such request** — `mokesh`,
`lessons`, `muzza`, `snoring-sleep-apnea`, one flag each. Verified by team_100.

Every other non-plain row anywhere on the site is a side effect of a part's own hardcoded
default — `gallery`, `bookcard`, `testimonials`, `videoblk-placeholder` and `fbembeds` are
cream whether or not anyone decided they should be.

## The link team_00 drew between rows and media is also correct

**The flattest pages are the ones with no photographs at all.**

- `/repair/` — 13 sections, **zero images**, six plain prose rows and the same dark CTA
  repeated six times. Not one row ever changes colour.
- `/didgeridoos/` — 15 sections, **zero images**, one alternating row.
- `/eyal-amit/` — 15 sections, 6 images, **one** alternating row.

And the visually rich pages get their richness from **one large gallery block bolted on**,
not from photographs distributed through the rhythm. The home page spreads 39 images across
thirteen varied sections; `/books/vekatavta/` puts 95 into a single gallery.

## The finding that should decide how the next milestone is scoped

**Six of the twenty-four body parts are dead code** — fully written, styled, documented, and
called from nowhere: `videoblk` (the real video block, as opposed to its placeholder),
`reveals`, `steps`, `lead`, `mag` (a dark magazine spread, with a complete CSS block), and
`product-cta` (which even carries its own alt-support docblock).

**Several of them are precisely the vocabulary the flat pages lack.** The infrastructure for
the fix largely exists. It is simply not connected.

## And the part that should be uncomfortable

`/contact/` is **the only page in the codebase** that has a genuinely hand-built alternating
sequence. Its own docblock records team_00 asking for exactly this, dated 2026-09-17:
*the page needs to be built from visually separated parts, rows, like the home page — each
row with a touch of design that separates it.*

He asked yesterday. It was applied to one page. It was not carried to any other.

## What this defines for the next milestone — definition only

1. **The vocabulary exists and is documented above.** Three section variants, plus the bleed
   band, the CTA band, and the hero. Nothing new needs inventing.
2. **The decision is per page, per section** — there is no automatic mechanism to switch on,
   and introducing one would be a design decision, not a fix.
3. **Rows and media are one problem.** A page with no photographs cannot be rescued by
   alternating background colours alone; the flat pages need both.
4. **Start by connecting what already exists.** Six built parts are unused, and at least
   three of them address exactly the gap.
5. **`/contact/` is the worked reference** for what team_00 means, and the home page is the
   quality bar.

**No corrective work was done and none should be until the typography and accessibility
phases close.** Doing it earlier means composing rows against type that is about to change.
