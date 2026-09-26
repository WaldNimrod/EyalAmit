# DONE — content-type canon pair — 2026-09-26

**Mandate:** [`MANDATE-TYPE-CANON-PAIR-2026-09-26.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/AUDIT-2026-09-26/MANDATE-TYPE-CANON-PAIR-2026-09-26.md)
**Source:** [`TYPE-MAP-2026-09-26.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/AUDIT-2026-09-26/TYPE-MAP-2026-09-26.md)
**Theme version:** 1.5.138, stable, nothing in flight.

## Delivered

- [`CONTENT-TYPES-CANON.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/EYAL-WORKSPACE/CONTENT-TYPES-CANON.md) — the definitions file, for sessions. 37 content-row types (the map's 36 plus the approved-but-unbuilt blog "new post" template), 9 tier-2 elements, orphans, a stage-A review list, and the record of where the 2026-09-23 canon is superseded.
- [`ea-content-types.html`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/EYAL-WORKSPACE/ea-content-types.html) — the artifact, for Nimrod and Eyal. Same 37 types, each with a live-rendered example (through the theme's own stylesheets, loaded from staging) and a plain-language definition, plus the same stage-A review list in his language.

Both state the date, the theme version, and the pairing rule, and each references the other.

## Two mid-task additions, both folded in

1. **team_00's stage-A/B/C ruling** (canon feeds a reset round; deviations and no-type areas must be marked for his visual review, not fixed or recommended by this pair). Added as a third section in both documents: **significant deviations** (8 entries, one per non-uniform type from the map, each with a live URL and what a viewer would notice) and **no-type areas** (QR body content, plus three approved-but-unbuilt gaps: the logo-hero rule for blog/QR, and the new-post template itself). No entry recommends a fix; each is tagged with what's needed from him (a look, a decision, or a ruling).
2. **The blog is not typeless.** Per team_00's ruling, resolved into two named types: #34 (the existing archive post — loose by design, historic images never replaced) and #37 (the approved, sketch-based, block-driven new-post template — **zero live instances**, documented from `POST-TEMPLATE-SETTINGS.md` §7, `DUMMY-WEEK-OF-BREATH.json`, and the two approved sketches, not from a live render). The 48 printed-code (QR) pages keep their existing shell type (#33) but stay on the no-type list for their body content, since the sketch only adds a hero-variant rule, not a row system.

## Verification

- **Both documents exist, link to each other, state the pairing rule, date and version.** Confirmed.
- **Every type in the map appears in both, compared in both directions.** Confirmed programmatically: the artifact's 37 type entries are exactly `1..37` with no gaps or duplicates, matching the definitions file's 37 headings exactly by number.
- **The artifact contains zero class names, file paths, or status codes.** Grepped the artifact's visible prose (all static HTML text plus every `name`/`def`/`note`/`flag`/review-item field in the script — excluding the iframe markup itself, which necessarily carries the theme's real classes in order to render through the live stylesheets, per the mandate's own instruction to do that rather than reimplement the CSS): 0 occurrences of `.php`, `template-parts`, any `.css` filename, any dot-class selector, and 0 standalone HTTP status codes (200/301/302/404/410/500/502/503).
- **Sufficiency test — CTA band (#8), picked because it's the type Nimrod defined precisely himself.** From the definitions-file entry alone, to render "a CTA band, sand, with title T, body B, button label L to URL U": `<section class="cta-band cta-band--row cta-band--sand"><div class="cta-band__in"><span class="cta-band__logo cta-band__logo--side" aria-hidden="true"></span><div class="cta-band__txt"><h2 class="cta-band__h">T</h2><p class="cta-band__p">B</p></div><div class="cta-band__act"><a class="btn btn--terra" href="U">L</a></div></div></section>` — no other CSS needed beyond `chapters.css` lines 845–898 and 1539–1555, already cited in the entry. Verified live in the browser: the rendered band matches the map's measured geometry exactly (right third logo, middle third right-aligned text, left third centered button).
- **Every orphan and exception from the map appears in the definitions file.** Carried forward under Orphans and inside each type's own Exceptions point; nothing dropped.
- **Live artifact returns 200 and is byte-identical to the tracked source.** Verified after publish and after a targeted single-file re-upload (needed because the first full publish pass had already uploaded the file before a late fix to the cross-document link — corrected and re-verified).

## What required opening the theme beyond the map (and could not be presented honestly without it)

- Exact field names for eight home-page sections the map described only in prose (`section-hero.php`, `section-07-how-to-start.php`, `section-01-about.php`, `section-04-studio.php`, `section-02-for-whom.php`, `section-06-compare.php`) — read directly rather than paraphrased again.
- The full markup of about a dozen renderers (`phero.php`, `cta.php`, `split.php`, `prose.php`, `gallery.php`, `bleed.php`, `point-cards.php`, `photo-band.php`, `videoblk.php` + its placeholder, `testimonials.php`, `testi-cards.php`, `block-faq-list.php`, `faq-inline.php`, `dd.php`, `toc.php`, `bookcard.php`, `photo-slot.php`) — needed to build faithful live-CSS examples for the artifact, since the map documented inputs and measurements but not the exact DOM nesting.
- Three files outside the map entirely for the two blog types: `PHASE-2-BLOG-QR-AFTER-SKETCH.md`, `POST-TEMPLATE-SETTINGS.md`, `DUMMY-WEEK-OF-BREATH.json`, plus both approved sketches.

## What could not be presented honestly

- **Tier-2 elements 18–20 (testimonial marquee/grid/cards) and a few one-page bespoke types** (fbgrid, timeline, contact, press) have class names in the definitions file that are *reasonable reconstructions* from the map's own class-fragment mentions and the one file I did read in full (`testimonials.php`, `testi-cards.php`) rather than a full read of every neighboring file — the map itself flagged several of their measurements as "not measured," and I did not close that gap with a new measurement pass, per the mandate's instruction not to guess to make the document look finished. Flagged as such in the definitions file, not smoothed over.
- The "13 fields" phrase team_00 used for the new-post type does not correspond to any literal numbered list in the approved settings file. I stated in the definitions file exactly how I read it (hero + the 11 approved dummy rows + the media pool = 13) rather than presenting an invented canonical list as his own words.

## Live artifact

http://eyalamit-co-il-2026.s887.upress.link/ea-eyal-hub/ea-content-types.html
