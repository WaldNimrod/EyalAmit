---
id: MANDATE_S007_M03_TYPE_INVENTORY_2026-09-18
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10 (session eyalamit-co-il-2026-e4)
cc: [team_00]
date: 2026-09-18
law: _COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md
state: _COMMUNICATION/team_100/S006/HANDOFF-CURRENT-S006.md
status: DISPATCHED
---

# M-03 · Typography inventory — measurement only, zero edits

## Why this exists

team_00's closing instruction for this phase was to wire the whole site cleanly and
precisely to the same CSS definitions. That is impossible to do safely by eye: the
live-loaded stylesheets carry **261 `font-size` declarations** (I briefed 263 — see
the correction below) and `chapters.css` alone spends 53 distinct values on its 114. Before a scale can be
applied, every declaration has to be located, resolved to a real pixel number, and
clustered — so that locking the scale becomes a mechanical mapping instead of 261
individual judgement calls.

This mandate produces that inventory. **It produces no fix.**

## Hard scope limits

- **No CSS edits. No PHP edits. No deploy. No commit to any theme file.** The only
  file you create is the report named below.
- Do **not** propose a scale, and do **not** decide which declarations are "wrong".
  team_00 has not locked the scale yet; a recommendation now would prejudge his call.
- Do not touch `_aos/`. Do not run `git add -A` or `git add .` (charter §5.4).

## The nine files that are actually live

> Corrected 2026-09-18 after team_10 caught it: this heading said "eight" over a list of
> nine. `home-front.css` is also home-page-conditional (enqueued from `inc/wave2-stage-b.php`),
> not sitewide — it is absent from `/treatment/`. And the 263 figure below is wrong: the real
> count is **261**. My 262 included one `font-size` inside a comment at `ea-atoms.css:1379`,
> and the 263 predated my own removal of `.nav__b b`.

Confirmed 2026-09-18 from the rendered home page at theme version 1.5.40. Only these
load on a page; everything else in `assets/css/` is either conditional or dead.

```
assets/css/chapters.css
assets/css/ea-atoms.css
assets/css/ea-tokens.css
assets/css/ea-animations.css
assets/css/ea-mobile-nav.css
assets/css/ea-mobile-variants.css
assets/css/home-front.css
assets/css/testimonials-carousel.css
style.css
```

⚠ `ea-mobile-nav.css` and `ea-mobile-variants.css` load on every page and match
**zero elements** — they are the orphaned team_35 mobile design. Count their
declarations, but mark every row from them `ORPHAN` so nobody later "fixes" a rule
that no element can reach. Verify the zero-match claim yourself rather than taking
it from this mandate; that is the point of positive assertion.

## What to produce

One artifact:

```
_COMMUNICATION/team_10/S007-M03/TYPE-INVENTORY-2026-09-18.md
```

Plus one machine-readable companion beside it:

```
_COMMUNICATION/team_10/S007-M03/type-inventory.csv
```

### CSV columns — one row per `font-size` declaration

```
file,line,selector,raw_value,computed_px_1440,computed_px_390,font_weight,font_family_token,role_guess,status
```

- `computed_px_1440` / `computed_px_390` — resolve `rem` against the real root size
  (measure it; do not assume 16), and resolve every `clamp()` at that viewport width
  by hand. A `clamp(1.8rem,3.1vw,2.6rem)` is **not** one number; it is a different
  number at each width, and that is exactly what makes these declarations invisible
  to a text search for a size.
- `font_weight` — the weight in the same rule block, or `inherit` when absent.
- `font_family_token` — which of the six token names the rule resolves to, or the
  literal family when hardcoded.
- `role_guess` — a short label such as `section-title`, `card-title`, `body`, `meta`,
  `nav`, `tag`, `caption`, `button`. This is a description of where it is used, not a
  recommendation about what it should become.
- `status` — `LIVE` or `ORPHAN`.

### Report sections

1. **Counts** — declarations per file, distinct values per file, total.
2. **Clusters** — group every LIVE row by `computed_px_1440` rounded to the nearest
   whole pixel, largest first. For each cluster list its members. This is the section
   that makes the wiring mechanical: a cluster is a candidate rung.
3. **The `clamp()` set** — every fluid declaration, with both endpoint values and the
   viewport at which it stops growing. These are the ones that will fight a fixed
   scale, so they need to be visible as a set.
4. **Font families** — resolve all six token names to their real family lists, say
   which token each live rule uses, and list every rule that hardcodes a family
   instead of using a token.
5. **What you could not resolve** — any declaration whose computed value depends on a
   cascade you could not determine statically. Name it; do not guess it.

## Traps this project has already fallen into

Each of these produced a confident wrong answer here before. They are not
hypothetical.

- **Spacing-sensitive grep lies.** `font-size:var(` returned zero where
  `font-size: var(` had fourteen. Match on a pattern that tolerates whitespace, and
  state the pattern you used in the report.
- **A plugin's version is not the theme's version.** Match on path, never on a
  version number alone.
- **Dead code reads exactly like live code.** A selector existing in a stylesheet
  proves nothing about whether any element carries that class. Where a rule looks
  significant, check the rendered DOM before recording it as live.
- **A clean automated result is not evidence** (charter §8א clause 5). If a tool
  reports "no issues", that is a fact about the tool.

## Positive assertion

Every number in the report carries `file:line` or the URL and selector it was
measured from. "No `font-size` in this file" is only acceptable when you state the
command that produced the zero. A count you did not personally produce does not go
in the report — including the counts written above in this mandate.

## Reporting

When done, message team_100 (session `eyalamit-co-il-2026-76`) with the artifact path
and the three headline counts. If something in this mandate turns out to be wrong —
including the file list or the 263 figure — say so plainly; correcting the mandate is
worth more than matching it.
