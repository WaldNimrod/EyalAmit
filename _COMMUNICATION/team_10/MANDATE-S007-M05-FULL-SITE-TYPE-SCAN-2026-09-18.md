---
id: MANDATE_S007_M05_FULL_SITE_TYPE_SCAN_2026-09-18
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00, team_50]
date: 2026-09-18
theme_under_test: 1.5.60
canon: _COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md
status: DISPATCHED
---

# M-05 · Every page, every deviation — size, weight AND family

## Why, in team_00's words

«נשימה היא הבסיס להכל - חורג מהטיפוגרפיה - חובה לסרוק את כל העמודים לאיתור חריגות נוספות.»

He opened the home page and found one himself. That element is `.bleed__q`, and it is not a
size problem at all — it renders in **Frank Ruhl Libre** while the other 33 text selectors on
that page render in **Heebo**. Every scan run on this milestone so far has checked **size**,
and two of them also **weight**. **None checked family.** That is the hole.

**Sampling is also finished as a method here.** Three separate passes sampled representative
pages and each missed something the next one found: two live stylesheets, six pages with no
tokens at all, an 8.568px caret, a post with a skipped heading level. **Scan all 157 URLs.**

## The URL list

`_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv` — 103 pages, 54 posts.
Use it as the raw URL list. Do **not** trust its grouping, and do not reduce to
representatives: team_00 asked for every page and the sampling record above is why.

## What counts as a deviation

For every rendered text element on every URL, at 1440×900:

1. **Size** — computed `font-size` not within ±0.6px of one of the twelve rungs (canon §1).
2. **Weight** — computed `font-weight` not one of 100/200/300/400/500/600/700/800.
3. **Family** — computed `font-family` whose first entry is not `Heebo`.

Report every one with page URL, selector, the computed value, and the nearest rung/family.

**Known and already catalogued — report them, but separately from anything new:**

- `--serif` (Frank Ruhl Libre) on 6 chapters.css rules: `.tl__y`, `.bleed__q`, `.st3::after`,
  `.shstep__dot span`, `.bookcard__cover .ph`, `.bookcard__t`.
- `--display` (Suez One) on 6: `.fstep__num`, `.fstep__t`, `.mag-spread__fig figcaption b`,
  `.mag-list__n`, `.mag-list__t`, `.btile__t`.
- `--ea-font-sans` (Rubik) on 6 style.css rules, plus a literal Rubik in
  `theme-shell-fallback.css`.
- The three documented size exemptions and the two unproven ones (canon §6).

**What I want from you is what is NOT on that list.** Which pages actually render each of
those, and what else exists that nobody has named.

## Traps — every one of these already produced a wrong answer on this site

1. **A sweep that filters for text longer than one character is blind to every glyph.** That
   is how an 8.568px caret survived nine sweeps. Use `length > 0` plus a
   `getBoundingClientRect()` zero-size guard.
2. **A sweep only reports selectors that appear on the pages you loaded.** It is not an audit
   of the stylesheet. That is why this mandate is all 157 and not a sample.
3. **Searching the wrong property returns a clean zero.** `ea-tokens.css` holds nine
   composite tokens inside the `font:` shorthand and reports zero `font-size` declarations.
4. **A declaration being present proves nothing** — check computed values. A base floor
   shipped at `0,0,1` here was completely inert behind GeneratePress at the same specificity.
5. **Third-party CSS is live too** (GeneratePress, wpa-style, Fluent Forms, CF7). If a
   deviation traces to one of those, say so — that changes who fixes it.

## Hard limits

**Measure and report. Change nothing.** No CSS, no PHP, no deploy, no theme commit. If the
theme version moves while you run, say so rather than implying a stable target — it has
happened in every batch on this milestone so far.

Degrade gracefully: if 157 URLs runs long, report partial coverage with the exact list of
what was and was not reached. **Do not raise a timeout to make a long run fit — split it.**

## Output

```
_COMMUNICATION/team_10/S007-M05/FULL-SITE-TYPE-SCAN-2026-09-18.md
_COMMUNICATION/team_10/S007-M05/deviations.csv
```

CSV: `page,selector,axis,computed,expected_nearest,source_sheet,status`
where `axis` is size|weight|family and `status` is `catalogued` or `NEW`.

## Reporting

Message team_100 (`eyalamit-co-il-2026-76`) with: URLs actually scanned out of 157, total
deviations, how many are NEW, and the single worst one. If the answer is that the site is
clean apart from the catalogued list, say that plainly — but only after 157, not after 16.
