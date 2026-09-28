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

## Structure (since 2026-09-27, after the merge — D49)

- **Header** — what the map is, the reading rules, and the site-wide rules in one line each.
- **Tab bar** — pinned. Eight groups of the **current** types: פתיחות · טקסט · תמונה וטקסט · כרטיסים · מדיה ·
  פעולה · תבניות עמוד · משותף; on the left, the pages: המפה · הצעות פתוחות · חלוקות · מה אושר — רשת · בדיקת גוונים.
- **One row per current type** (18: 14 types, 2 page templates P-1/P-2, 2 shared rows S-1 «ממתין לתוכן» and S-2 buttons). Collapsed: ID ·
  name + status (מאושר / מאושר בחלקו / פתוח) · definition · pages using it · live thumbnail.
- **Click a row** → definition, which old types it merged, **variants** with their values, **rules**, **fields**,
  every page that uses it; then the examples: every **approved** one (blue), then **today's site** for each old
  type it absorbed, labelled with the variant it becomes (the feasibility proof).
- **No proposals and no grid lines in the map.** Proposals live in `open.html` (numbered O-n) until ruled on;
  grid lines live in the proof pages.
- In every example the section backgrounds are normalised to the nearest canonical tone and placeholders use the
  one «waiting for content» look — in the map only, never the site (A-1, A-5).

### Identifiers

`T-01` … `T-37`, the canon's own numbering — the same numbers as
`CONTENT-TYPES-CANON.md` and the old artifact. **An ID is permanent.** A type that is
split gets a new ID; a retired ID is never reused. **Retired: `T-03`** — merged into `T-02`
on 2026-09-27 (one video-hero template; 35 old IDs remain — merged into 18 current rows since D49). The ID is the "type A" of the request
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

Nothing is hand-edited in the HTML. From the repo root:

```bash
python3 _COMMUNICATION/team_10/canon-map/tools/census.py
python3 _COMMUNICATION/team_10/canon-map/tools/fetch.py
python3 _COMMUNICATION/team_10/canon-map/tools/build.py _COMMUNICATION/team_10/canon-map/map-source.html
sh _COMMUNICATION/team_10/canon-map/tools/rebuild_views.sh
```

- `census.py` enumerates every published page and post from the REST API, fetches each once **without
  following redirects**, and writes `tools/uses.json` (pages per old type ID).
- `fetch.py` saves the source pages into the working directory (run it and `build.py` from a scratch directory).
- `build.py` captures every example of every **old** type ID (T-01…T-37) — today's site, approved and proposed —
  into `map-source.html`, the internal source every page reads. Its spec is one `t(...)` line per old type, the
  appended `GRID_PROPOSALS`, and the CSS of every approved and proposed treatment.
- `rebuild_views.sh` writes the pages from `map-source.html`:
  - `canon_view.py` → `ea-canon-map.html`, the map. **Its types live in `tools/canon_types.py`** — name, which old
    types it merges, status, definition, variants, fields, rules. Change a current type there.
  - `open_view.py` → `open.html`, every open proposal (O-n) plus the decisions that have no picture.
  - `grids_view.py` → `grids.html`, the locked grid compositions K-n.m.
  - `grid_proof.py` → `grid-proof.html`, the approved types with the six-column ruler (T-xx.n) and rules R-n.
  - `palette_check.py` → `palette-check.html`, contrast of every tone.
- **Approve a proposal** → in `build.py` change its `__PROPOSAL__` to `__APPROVED__` and its label to «מאושר — …»,
  update the status/rules in `canon_types.py`, rebuild: it leaves `open.html` and shows blue in the map.
- **Add a proposal** → an example with `("__PROPOSAL__", "<class>")` in `build.py`, CSS scoped to the class.

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

1440 and 375 wide: 35 old type IDs (18 current rows), every example non-empty, no page-level horizontal scroll at
375. Elements that extend past the edge by design and are clipped (`.arcs`, the testimonial
track, the memorial video layer, the contact band's logo watermark) are not defects —
**a defect is only what moves `document.scrollWidth`.**
