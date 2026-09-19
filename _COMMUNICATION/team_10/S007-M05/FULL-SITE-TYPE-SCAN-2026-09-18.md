---
id: DONE_S007_M05_FULL_SITE_TYPE_SCAN_2026-09-18_v1.0.0
schema_version: aos_v1_team_messaging
type: DONE (team_10 → team_100)
from: team_10 (session eyalamit-co-il-2026-e4)
to: team_100 (session eyalamit-co-il-2026-76)
cc: [team_00, team_50]
date: 2026-09-18
mandate: MANDATE-S007-M05-FULL-SITE-TYPE-SCAN-2026-09-18.md
canon: _COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md
disposition: MEASURE AND REPORT. All 157 URLs, not a sample. No CSS/PHP/deploy.
---

# S007 M-05 · Every page, every deviation — size, weight and family

## Headline

**157 of 157 URLs reached — full coverage, zero failures, no split needed.** 13,412 text
elements scanned (`length > 0` + a zero-size `getBoundingClientRect()` guard, per the
mandate's own trap #1 — no glyph-length filtering anywhere in this scan).

- **Total deviations: 114** (112 family, 2 size, **0 weight** — the weight-scale lock from
  1.5.60 held across the entire site, not just the pages checked when it closed).
- **NEW (not on the canon's catalogued list): 92.** Catalogued: 22.
- **The worst one, by far: six published, publicly reachable pages render almost their
  entire chrome outside the theme's type system altogether**, not just missing a scale
  token — see below. This is the finding the mandate asked for: "what else exists that
  nobody has named."

## The worst finding: six pages render through bare GeneratePress, not Heebo

`/services/`, `/shows-heritage/`, `/historical-articles/`, `/thank-you/`, `/courses-soon/`,
`/learning/courses-external/` — the same six pages canon §3 already named as rendering
"outside every Wave2 template whitelist" (and which needed `ea-tokens.css`'s enqueue made
unconditional at 1.5.55 just to get *size* tokens at all). **What canon §3 didn't say, and
this scan found empirically: on all six, the skip-link, the header/nav wrapper, every
top-level menu item, the footer's `site-info` block, and the WhatsApp float button all
compute `font-family: -apple-system`** — meaning literally no CSS sets a font there at all;
the browser's own OS default is showing through. The main article content and the
footer-legal nav on the same six pages compute **Rubik**, not `-apple-system` — traced to
`style.css`'s `body.ea-m4-polish h1.entry-title` / `.page-content` / `.ea-footer-legal-menu`
rules (the ones canon §10 calls "Rubik — six style.css rules... earlier reports called it
fetched and unused. It is used" — **this scan is the live proof of exactly where**: these
six pages specifically, confirmed by the matching page list).

The class names on these six pages' own markup make the cause visible without needing to
read PHP: `header.site-header`, `nav.main-navigation`, `ul.menu.sf-menu`, `main.site-main`,
`article...div.inside-article`, `div.site-footer>footer.site-info` — every one of those is
GeneratePress's own **parent-theme** class, not a Chapters or Wave2 class. These six pages
are not "missing a token." They are rendering through the bare parent theme, essentially
unstyled by this child theme's typography system at the structural level, while every other
page on the site goes through Chapters or Wave2 and gets Heebo throughout. A visitor landing
on any of these six sees a different site.

**Two more pages carry a narrower version of the same mechanism**: `/about/` and `/press/`
otherwise render correctly (Chapters/Wave2, Heebo throughout) but their footer's legal-nav
specifically (`.ea-footer-legal-nav`) still resolves to the same `style.css` Rubik rule —
a much smaller footprint (one row each) but the identical root cause.

**Full per-page detail for all eight pages is in the CSV.** 92 of this scan's 114 total
deviations sit inside these two findings (the six fully-orphaned pages plus the two
footer-legal-nav cases) — everything else on the site is a handful of small, separate items,
below.

## Coverage and methodology

- URL list: `_COMMUNICATION/team_100/S006/S007-SITEMAP-157-URLS-2026-09-18.tsv` (103 pages,
  54 posts), used as the raw list per the mandate — no grouping trusted, no reduction to
  representatives.
- Run split into 4 parallel batches of ~39 URLs each (per the mandate's "split rather than
  raise a timeout" instruction) — not because any batch was close to a limit, but because a
  157-URL single run risked one. All 4 finished cleanly; 157/157 pages returned `ok`, 0
  errors, 0 short/empty responses.
- Viewport: 1440×900, one pass per page (this mandate is about which font renders, not about
  responsive behavior, so a single desktop viewport is the right scope — unlike the M-01
  size/weight work, which needed 390/768/1440).
- Every page was scrolled through in ~700px steps before AND during enumeration, not just
  once at the end — see the methodology note below for why the "during" part turned out to
  matter.
- Deviation math: computed `font-size` compared to all twelve canon rungs, nearest kept,
  flagged if the gap exceeds the mandate's ±0.6px tolerance; computed `font-weight` flagged
  if not one of the eight canon weights; computed `font-family`'s first entry flagged if not
  exactly `Heebo`.
- Selectors known and intentionally off-scale (canon §6: `.nav__caret`, `.testi-mq__btn`,
  the CF7 label's `font-size:0`) are excluded from being counted as fresh deviations and
  never appear as `NEW` in the CSV, but nothing was excluded from being *scanned* — the
  em-glyph and CF7-label cases still show up in the raw data, just pre-classified.

### A methodology bug caught before the real run, worth naming

The first attempt at this scan enumerated the DOM once, after returning to scroll position 0
at the end of a scroll-through — the same pattern that worked correctly for the M-04
contrast work. It returned **zero** deviations on the home page, which was itself the tell:
`.bleed__q` — the exact element team_00 found himself, and the reason this mandate exists —
was silently absent. Direct comparison showed the element renders correctly (Frank Ruhl
Libre, confirmed via a standalone check) but disappears from a scroll-linked reveal section
once scrolled back away from it — a *different* lazy-content behavior than the "hasn't
loaded yet" trap M-04 already solved by scrolling down once. The fix here: enumerate at
**every** scroll checkpoint during the pass, not only at the end, and merge findings by
(selector, axis). Re-verified against the known `.bleed__q` deviation before trusting the
tool on the other 156 pages — it now catches it every time.

## Catalogued deviations — where they actually render (not just "exist in source")

The mandate's own ask: not the list itself, but which pages render each entry.

| Family | Selector | Pages it actually rendered on in this scan |
|---|---|---|
| Frank Ruhl Libre (`--serif`) | `.bleed__q` | 6 pages (pull-quote section reused site-wide, not home-only) |
| Frank Ruhl Libre (`--serif`) | `.bookcard__t` | 6 pages (every book-card instance) |
| Frank Ruhl Libre (`--serif`) | `.tl__y` (`li.tl__n>span.tl__y`) | 2 pages: `/about/moksha/`, `/eyal-amit/mokesh-dahiman/` |
| Frank Ruhl Libre / Suez One | `.st3::after`, `.shstep__dot span`, `.bookcard__cover .ph`, `.fstep__num`, `.fstep__t`, `.mag-spread__fig figcaption b`, `.mag-list__n`, `.mag-list__t`, `.btile__t` | **0 pages in this scan matched any of these 9.** Not contradicting the canon (these are real declarations — not re-verified as dead here, just not encountered as *rendered, visible* elements with direct text across these specific 157 URLs at 1440px in this pass). Flagged under Could Not Confirm below rather than silently dropped. |
| Rubik (`--ea-font-sans`, `style.css`) | `.page-content`, `h1.entry-title`, `.page-content h2/h3`, `.ea-instance-catalog__title`, `.ea-footer-legal-menu` | The 6 orphaned pages above, plus `/about/` and `/press/` for the footer-legal-nav rule specifically — see "worst finding" |
| Rubik (literal, `theme-shell-fallback.css`) | `body.ea-m4-polish` (and siblings) | **0 pages matched the literal rule as the DIRECT source in this scan** — every Rubik hit traced to the `style.css` `--ea-font-sans` rules instead, which happen to produce the same rendered value. Not evidence the literal rule is dead (both are plausible sources of the identical string; distinguishing them needs a source-level check, not a rendered-value one) — flagged below. |

## New, non-catalogued deviations, everything outside the "worst finding" above

- **`/en/`** — `header.ea-en-head__b` (the EN page's own logo/brand link, text "Eyal Amit")
  renders in **Frank Ruhl Libre**. Single page, single element, low reach — but genuinely new
  and not on any prior list.
- **Old blog-post content, 5 posts** — inline `Arial`/`arial` spans inside pasted-from-Word
  content (`.MsoNormal`, nested `span>span>span` chains, one Facebook-paste utility-class
  block). This is **content embedded in the database**, not a template or CSS issue —
  categorically different from everything above, and not something a CSS/token fix touches.
  Posts affected: "(27) הטור של אייל עמית: חכמת הפרצוף", "(40) הטור... פרסומת אחת וחזרנו",
  "(41) הטור... חארטה בארטה", "(29) הטור... רייב שבוע הספר", and the "נשימה מעגלית — סטודיו
  דיג'רידו..." 2012 post. Exact selectors and text in the CSV.
- **Two size deviations, both also inside old post content, both minor**: a `<strong>` at
  16px (nearest rung `--fs-sm` 15.3px, 0.7px over the ±0.6 tolerance — right at the edge) in
  Facebook-paste content on the "תלמידים ומטופלים ממליצים" post; and the Contact page's CF7
  row label at `font-size:0` — this one is the **canon's own documented, intentional**
  exemption (hidden-but-accessible label, per §6), correctly excluded from `NEW` in the CSV
  but listed here for completeness since it is technically a size-axis reading.
- **Zero weight deviations, anywhere, across all 157 pages.** The 1.5.60 weight-scale lock
  holds site-wide, not just on the pages sampled when it closed.

## Could not confirm / measure

- **9 of the 19 catalogued family rules (the `--serif`/`--display` set beyond `.bleed__q`,
  `.bookcard__t`, `.tl__y`) were not encountered as rendered elements with direct text on
  any of the 157 URLs at 1440px in this pass.** They are real CSS declarations (not
  re-disputed here) — this scan simply didn't hit a live instance of each one. Possible
  reasons, not distinguished from each other here: the component only appears on a state
  this scan doesn't trigger (e.g. inside an unopened `<details>`, matching the same class of
  gap M-04 already flagged for accordion content), or the component's content is currently
  empty/placeholder on every page that has the slot. Named rather than silently omitted, per
  the project's own "COULD NOT MEASURE, never a pass by absence" standard.
- **Whether the literal Rubik rule in `theme-shell-fallback.css` ever fires versus the
  `style.css` rule producing an identical rendered value** — a rendered-value scan cannot
  distinguish two rules that resolve to the same string; would need a source-order/specificity
  check, not a live-DOM one.
- **Any page state reachable only via interaction** (an opened accordion, a hover state, a
  focus state, a carousel's non-first slide) is out of this scan's reach by construction — it
  reads the DOM as it settles after scroll, not after user interaction. Consistent with every
  earlier mandate's own disclosed limits on this exact point.

## Files

```
_COMMUNICATION/team_10/S007-M05/FULL-SITE-TYPE-SCAN-2026-09-18.md   (this file)
_COMMUNICATION/team_10/S007-M05/deviations.csv                       (114 rows)
```

Raw per-page data (gitignored): `tmp/qa/s007-typography/m05-batch-{0,1,2,3}.jsonl` — one
JSON object per URL, every field the CSV was built from plus the raw scanned-element count
per page for anyone who wants to re-verify coverage independently.

No file under `site/` was edited. Nothing was committed or deployed. **The theme version did
move during this run, same as every other mandate on this milestone** — 1.5.60/1.5.61 when
the mandate and canon were read, **1.5.64 now**. Checked the three intervening commits
(`3f82f0b` "Snoring page restructured, and less air site-wide", `e7d2656` a `--sec`
spacing-variable fix caught by the deploy guard, `ee3ac3d` a lightbox/image-placement
change): none touch font-family, font-weight, or a size rung — all three are spacing/layout
or an unrelated feature. I don't believe this changes any finding above, but I'm stating the
drift plainly rather than the alternative (this report first claimed the version had held
stable, which was checked after writing and found false — corrected here before sending,
not after).
