# Canon map — what it is, how it is used, how it is built

**Date: 2026-09-27. True for theme version 1.5.150.** Owner: team_10 (canon stage A, working
directly with team_00). Validation: team_90 (`90- הכנה לעלייה לאוויר אייל עמית` [418028]).
Current state and decisions: [CANON-STAGE-A-STATE.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/CANON-STAGE-A-STATE.md).

## What it is

[ea-canon-map.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/canon-map/ea-canon-map.html)
is the **one central document of canon stage A** (team_00, 2026-09-27): every content type
on the site, in logical order, grouped, each with its identifier, its properties, and a
full-size example.

It serves two kinds of user, and that is why the canon is dual:

| User | Works with | Uses the map for |
|---|---|---|
| Nimrod, Eyal | their eyes | approving and refining each type visually, from a sketch |
| Sessions and agents (stage-B reset lanes, all future work) | text | the ID, fields and source of every type; the rules in the text canon |

Team_00's process ruling: **work starts from a visual sketch, not from editing the site.**
Deriving definitions and text from an approved visual is the builders' job and goes
through validation.

## Structure

- **Header** — capture date, theme version, and the three reading rules (copied verbatim /
  dummy / video placeholder).
- **Tab bar** — one tab per group; it stays pinned while scrolling and is the navigation
  between groups. Nine groups: פתיחות · קריאה · תמונה וטקסט · רשתות וכרטיסים · קולות ·
  שאלות ומבנה · מדיה · פעולה · מעטפות.
- **One row per type.** Collapsed: ID · name (+ a flag such as «ייחודי לעמוד אחד») ·
  one-line description · number of pages using it · live thumbnail.
- **Click a row** → full description and note; then, side by side, **properties** — nine
  fixed labels in a fixed order for every type (מבנה · גובה · רוחב · יישור · רקע · מדיה ·
  כפתור · בטלפון · גרסאות) — and **fields**, a table of field · type · code name, with the
  type from a closed list (טקסט קצר · טקסט ארוך (עם עיצוב) · תמונה · טקסט חלופי · קישור ·
  כן/לא · בחירה מרשימה · מספר · רשימת פריטים · סרטון); then **every page on the site that
  uses the type**; then every example at full size, variants labelled.

### Identifiers

`T-01` … `T-37`, the canon's own numbering — the same numbers as
`CONTENT-TYPES-CANON.md` and the old artifact. **An ID is permanent.** A type that is
split gets a new ID; a retired ID is never reused. **Retired: `T-03`** — merged into `T-02`
on 2026-09-27 (one video-hero template; 36 types remain). The ID is the "type A" of the request
format team_00 defined for Eyal's maintenance environment: «שורה מטיפוס A עם תוכן B בעמוד C
במיקום X».

### Three kinds of example, each visibly marked

| Kind | Marking | Rule |
|---|---|---|
| Live copy | none | Structure **and content** copied verbatim from one of the pages that use the type. Every page in the row's uses list is a **feasibility proof**. |
| Dummy | dashed amber frame + «תוכן דמה — לא מופיע באתר» | Only for a type with no live instance. Generic, obviously fake text built from the real parts. The row says «כרגע לא בשימוש באתר» instead of a proof link, and carries a proposal for where to implement it. |
| Proposal | solid green frame + «הצעה לאישור — עדיין לא באתר» | A change awaiting team_00's approval, styled **in the map only**. Nothing on the site changes until stage B. |

**Videos:** every video in the map is one fixed placeholder (film icon, YouTube mark, site
atmosphere background) — team_00's ruling. Map only; the pages keep their real videos.

## Rules

1. **Content law.** Live copies are verbatim — never trimmed inside a sentence, adapted or
   "improved". A long body may be cut *between* blocks, with a visible cut line. Dummy text
   never reaches a real page.
2. **The map never changes the site.** Proposals are map-scoped CSS. Site changes happen in
   stage B, from the approved canon.
3. **One host line.** The staging host appears exactly once, in `<base href>`. Every
   stylesheet and image is relative to it. At the domain cutover that line is the whole
   change. (Consequence: in-page `#links` would resolve to the host — so the tabs are
   buttons driven by script, not links.)
4. **Stamp everything.** Capture date and theme version on the page and in every row. Never
   capture a URL with a query string (the staging typography tuner overrides the locked
   tokens via `?ty=`).
5. **Every type needs a feasibility proof** — at least one element on a public page
   implementing it exactly. None → dummy + «כרגע לא בשימוש» + a proposal.
6. **Mobile is part of every check.** Nothing is approved on desktop alone.

## The working loop, per type or per cross-cutting pattern

1. Show the current state in the map (live copy), and if a change is wanted, the change as
   a **proposal** next to it.
2. Team_00 approves or refines **by eye**, desktop and phone.
3. Record the decision — his words — in `CANON-STAGE-A-STATE.md`, and update the type's
   row (description, fields, note) in the map.
4. Update the type's entry in `CONTENT-TYPES-CANON.md` in the same commit (pairing rule).
5. Team_90 re-measures. A builder's report is a claim.
6. The approved canon goes to stage B, which resets the site to it.

## How it is built

Nothing is hand-edited in the HTML. Three scripts in `tools/` regenerate it from the live site:

```bash
python3 _COMMUNICATION/team_10/canon-map/tools/census.py
python3 _COMMUNICATION/team_10/canon-map/tools/fetch.py
python3 _COMMUNICATION/team_10/canon-map/tools/build.py _COMMUNICATION/team_10/canon-map/ea-canon-map.html
```

`census.py` enumerates every published page and post from the REST API, fetches each once
**without following redirects** (a redirect shell is not a use — following it counts the
target twice), and writes `tools/uses.json`: the pages using each type. Its detectors are
explicit per type; a YouTube video pasted into a blog post's text is post content, not T-36.

`fetch.py` saves the source pages into the working directory (run both from a scratch
directory; sequential, gentle on staging). `build.py` holds the spec — one line per type:
ID, name, type in code, fields, and the examples (source page + selector, and whether it
is a live copy, a dummy or a proposal). Per type, `tools/type-defs.json` holds the
plain-language description (moved from the retired `ea-content-types.html`, deleted 2026-09-27), the nine properties, the
typed fields and the technical keys an editor never sets.

- **Change a type's text, properties or fields** → `tools/type-defs.json`.
- **Change an example or add a variant** → its line in `build.py`.
- **Show a proposal** → add an example with `("__PROPOSAL__", "<class>")` and scope its CSS
  to that class in `build.py`.
- **After a theme change** → re-run all three; the stamps update themselves.
- **Palette check** → `python3 tools/palette_check.py ea-canon-map.html palette-check.html`. Temporary; the approved text paragraph on every tone of both palettes with WCAG ratios per role and a verdict. Its tone list and text sets are at the top of the script.
- **Approved view** («מה אושר», team_00: every sketch shows the six-column grid; everything approved laid out by type / variant / field / rule, every example numbered T-xx.n) → `python3 tools/grid_proof.py ea-canon-map.html grid-proof.html`. Add a type to `TYPES` when it is approved; site-wide rules are `RULES`. The overlay spans the element's own grid, so a design that is off-grid shows immediately. The map and its sketch pages share one top bar (`tools/proofnav.py`).
- **Merge proposal** («איחוד», D40) → `python3 tools/merge_view.py ea-canon-map.html merge.html`. Temporary; which old types become variants of which type, and the cross-type findings A-n. Its spec is `MERGE`, `TEMPLATES` and `FINDINGS` at the top of the script.

## The grid (team_00's rulings, 2026-09-27)

Six equal columns over the component's **content width** (not the screen), numbered from the
right: column 1 is the rightmost. Gutter **10px**, one variable (`--cm-gap`). It is a ruler that
divides the space, not a set of content cards — the grid proof draws only column edges. Every
sketch from now on is shown with it (`grid-proof.html`). Approved placements so far: hero —
text 1–4, button 5–6 (bottom or top); CTA band — text 1–4, button 5–6; text paragraph —
heading 1–6, text 2–5. A button always fills its columns on one line; on a phone it goes under
the text, on the left.

## Map pitfall, found and fixed once

A selector like `main > section.sec` picks the first matching section, which on some pages is a
different type (a split, an accordion). T-04 captured the wrong type twice. **After changing any
capture, audit every example against its type's signature** (the check lives in the stage-A
state file's history; 65 of 65 clean at the last run).

## Verified at capture (team_10's claim; team_90 re-measures)

1440 and 375 wide: 36 types, every example non-empty, no page-level horizontal scroll at
375. Elements that extend past the edge by design and are clipped (`.arcs`, the testimonial
track, the memorial video layer, the contact band's logo watermark) are not defects —
**a defect is only what moves `document.scrollWidth`.**
