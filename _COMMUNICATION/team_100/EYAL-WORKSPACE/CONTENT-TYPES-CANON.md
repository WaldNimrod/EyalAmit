# Content-types canon — definitions file (for sessions)

**Date: 2026-09-26. True for theme version 1.5.138.** The call-to-action rebuild has landed;
nothing is in flight. Re-verify this file's geometry claims if the theme version changes.

**Paired document:** [ea-content-types.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/EYAL-WORKSPACE/ea-content-types.html)
— the artifact for Nimrod and Eyal, published live at the hub. **Pairing rule: these two
documents are edited together. Changing one without the other is a defect,** the same way a
token change without its canon entry is a defect in this project. The artifact carries the
picture and the plain-language definition; this file carries the renderer, the CSS, the exact
classes, the exact inputs, the variants and the exceptions — everything a session needs to
render a type correctly without opening the theme.

**Source:** derived from [TYPE-MAP-2026-09-26.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/AUDIT-2026-09-26/TYPE-MAP-2026-09-26.md),
per [MANDATE-TYPE-CANON-PAIR-2026-09-26.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/AUDIT-2026-09-26/MANDATE-TYPE-CANON-PAIR-2026-09-26.md).
This is a derivation, not a second research pass. **"Not measured" is a legal value here too** —
where the map could not measure something, this file says so instead of guessing.

## What required opening the theme beyond the map

The map already carried inputs for every type from each renderer's own `$args`/field handling —
this file did not re-derive those. Two things sent this pass back into the code and into two
other approved artifacts:

1. **Exact field names for eight home-page sections** the map described in prose ("fields for
   chap, title, background image, three step rows…"). Read directly: `section-hero.php` (home
   video hero), `section-07-how-to-start.php` (start), `section-01-about.php` (about/collage),
   `section-04-studio.php` (studio), `section-02-for-whom.php` (whom), `section-06-compare.php`
   (compare). Each entry below now names the literal ACF/Chapters field key (`hero_video`,
   `about_img1_alt`, `cmp_a_cta`, etc.), not a paraphrase.
2. **The two blog types**, added to this canon after team_00 ruled the blog is not typeless.
   Their inputs come from three files the map does not cover, because they document a decision,
   not a live render: [`PHASE-2-BLOG-QR-AFTER-SKETCH.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/PHASE-2-BLOG-QR-AFTER-SKETCH.md),
   [`POST-TEMPLATE-SETTINGS.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/POST-TEMPLATE-SETTINGS.md)
   (the approved schema, §7), and the dummy content file
   [`DUMMY-WEEK-OF-BREATH.json`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/post-template/DUMMY-WEEK-OF-BREATH.json).
   Both sketches (`SKETCH-NEW-POST-DUMMY.html`, `SKETCH-BLOG-QR.html`) were read for the same
   reason. Type 37 below is documented from these, not from a live page — none exists yet.

Nothing else in this file required a new render or a new measurement. Everything else is the
map's own finding, restated in the pair's format.

## What survives from the map, unedited

36 row types have a renderer and at least one live page; 28 are uniform, 8 are not; 19 part
files and 6 modifiers are orphans; two populations (52 blog posts, 48 printed-code pages) sit
outside the row system for their body content. **This file adds a 37th type** (the approved,
unbuilt blog "new post" template) and resolves the blog population into two named types per
team_00's ruling below. The printed-code population is unchanged: still no row-type inside it.

---

## Index

**Blog note, read this first:** the 52 published posts are **not** typeless. Team_00 ruled there
are two blog types: [#34 — Archive post](#34-blog--archive-post-existing-ea-post-content) (what
is live today, deliberately loose) and [#37 — New post](#37-blog--new-post-block-template-approved-not-built)
(approved, block-based, **not yet built — zero live instances**). The 48 printed-code (`/qr/qrN/`)
pages keep their own shell type ([#33](#33-qr-article-shell)); their body content still has no
row-type, and they stay on the [stage-A review list](#stage-a-review-list) as a no-type area.

### Tier 1 — content rows (37)

1. [Page hero — `phero`](#1-page-hero--phero)
2. [Home video hero — `hero`](#2-home-video-hero--hero)
3. [Mokesh video hero — `mokesh-hero`](#3-mokesh-video-hero--mokesh-hero)
4. [Prose row — `sec` + `intro-body`](#4-prose-row--sec--intro-body)
5. [Prose fold — `prose-fold`](#5-prose-fold--prose-fold)
6. [Split — `split2`](#6-split--split2)
7. [Floated figure — `pfloat`](#7-floated-figure--pfloat)
8. [CTA band — `cta-band`](#8-cta-band--cta-band)
9. [Point cards — `point-cards`](#9-point-cards--point-cards)
10. [Photo band — `photo-band`](#10-photo-band--photo-band)
11. [Gallery — `gallery`](#11-gallery--gallery)
12. [Bleed quote — `bleed`](#12-bleed-quote--bleed)
13. [Whom cards — `whom`](#13-whom-cards--whom)
14. [Compare pair — `cmp`](#14-compare-pair--cmp)
15. [How to start — `start`](#15-how-to-start--start)
16. [Portrait collage — `collage` inside `about`](#16-portrait-collage--collage-inside-about)
17. [Studio split — `studio`](#17-studio-split--studio)
18. [Testimonial marquee — `testi-mq`](#18-testimonial-marquee--testi-mq)
19. [Testimonial grid — `testi-grid`](#19-testimonial-grid--testi-grid)
20. [Testimonial cards — `ea-testi-cards`](#20-testimonial-cards--ea-testi-cards)
21. [FAQ (three renderers, one family)](#21-faq)
22. [Definition accordion — `dd`](#22-definition-accordion--dd)
23. [Table of contents — `ea-toc`](#23-table-of-contents--ea-toc)
24. [Book / product cards — `bookcards`](#24-book--product-cards--bookcards)
25. [Spotlight row — `ea-now`](#25-spotlight-row--ea-now)
26. [Video block — `videoblk`](#26-video-block--videoblk)
27. [Video placeholder — `videoblk` + pending box](#27-video-placeholder--videoblk--pending-box)
28. [Facebook embeds — `fbgrid`](#28-facebook-embeds--fbgrid)
29. [Timeline — `tl`](#29-timeline--tl)
30. [Photo slot — `ea-photo-slot`](#30-photo-slot--ea-photo-slot)
31. [Contact rows](#31-contact-rows)
32. [Press list — `ea-press`](#32-press-list--ea-press)
33. [QR article shell](#33-qr-article-shell)
34. [Blog — Archive post (existing, `ea-post-content`)](#34-blog--archive-post-existing-ea-post-content)
35. [Blog card — `ea-blog-card`](#35-blog-card--ea-blog-card)
36. [Mokesh video embed — plain iframe](#36-mokesh-video-embed--plain-iframe)
37. [Blog — New post (block template, approved, not built)](#37-blog--new-post-block-template-approved-not-built)

### Tier 2 — elements inside the rows (9)

[Eyebrow](#eyebrow--chap) · [Heading](#heading) · [Sub / lede](#sub--lede) · [Body prose](#body-prose)
· [Buttons](#buttons) · [Logo watermark](#logo-watermark) · [Scrim](#scrim)
· [Pending-approval badge](#pending-approval-badge) · [Image and caption](#image-and-caption)

### Other sections

[Orphans](#orphans) · [Stage-A review list](#stage-a-review-list) · [Where this supersedes the 2026-09-23 canon](#where-this-supersedes-the-2026-09-23-canon)

---

## Tier 1 — content rows

<a id="1-page-hero--phero"></a>
### 1. Page hero — `phero`

- **Renderer:** [`template-parts/chapters/parts/phero.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/phero.php) lines 18–56.
  **CSS:** [`assets/css/chapters.css`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/chapters.css) lines 416–460 (base), 526–545 (`--media`), 528–529 (`--half`), 1524–1529 (`--compact`).
- **Classes:** `.phero` (base, text hero), `.phero--media` (photo hero, added when `media` is non-empty), `.phero--compact` (78vh, via `mod`), `.phero--half` (44vh, via `mod`), `.phero__in`, `.phero__h`, `.phero__s`, `.phero__lede`, `.phero__cta`, `.phero__sc` (scrim), `.phero__media-cue`, `.arcs` (ring motif).
- **Inputs (exact, from the renderer's `$args`):** `chap` (eyebrow string), `title` (H1, limited HTML via `ea_chapters_kses_e`), `sub` (subhead, limited HTML), `lede` (optional multi-paragraph HTML body under the sub, via `wp_kses_post` — **not** the same escaping as `sub`, so it is the only field here that keeps `<p>` breaks), `media` (image URL — empty means text hero, non-empty adds `phero--media`), `media_alt`, `literal_alt` (bool — keep an empty alt empty instead of auto-filling it), `cta_label`, `cta_url`, `cta_slug` (optional — marks the button as an external, GA4-tracked purchase link: `target=_blank rel=noopener` + `data-ea-book-purchase` + `data-ea-book-slug` + an "(opens in a new tab)" aria-label suffix; do not pass for internal links), `dark` (bool), `mod` (free class string, sanitized per token — this is how `phero--compact` and `phero--half` are actually applied).
- **Layout rules, measured.** Photo hero: flex, content bottom-anchored, `min-height: 88vh` (measured 792px at a 900px-tall viewport). Full viewport width. Title `text-align: start` (physical right in RTL), title box ~787px wide. Scrim (`.phero__sc`) is the same bottom-weighted gradient family as the home hero. Compact (`--compact` + `--media`): 702px = 78vh; arc motif and bottom cue are `display:none`. Half (`--half` + `--media`): 396px = 44vh. Text hero (no `media`): does not use a viewport fraction at all — `min-height: 0`, `display: block`; measured 363px on `/qr/qr1/`. Button, when present, is always `btn btn--gw` (outline), never the filled terracotta.
- **Pages:** 133 of 136. Absent on `/` (video hero instead), `/press/`, `/historical-articles/`. `phero--media` (88vh): 74 pages. `phero--compact`: `/repair/` only. `phero--half`: `/contact/` only. Text hero (no photo): `/bags/`, `/didgeridoos/`, `/galleries/`, `/learning/courses-external/`, `/shop/`, `/snoring-sleep-apnea/`, `/stand-floor/`, `/stands-storage/`, `/thank-you/`, all 48 `/qr/qrN/` pages, and one blog post with no featured image (see the archive blog type).
- **Variants:** `--media` vs. text hero is structural (same file, driven by whether `media` is set), not a silent override. `--compact` and `--half` are declared `mod` values. `/en/` is LTR: same hero, `dir="ltr"` and inline `direction:ltr;text-align:left` set on `<main>` by `tpl-chapters-en.php`, so title/eyebrow measure `text-align: left`.
- **Exceptions:** No `page-id-` CSS rule anywhere. `/learning/courses-external/` renders a hero with title «קורסים» and sub «יעלה בקרוב» and an empty `sections` array — a deliberate parking page, not a broken hero. **This type is not uniform** (flagged in the [stage-A review list](#stage-a-review-list) — the compact and half variants read very differently on screen from the standard photo hero).
- **Orphan?** No. The unrelated Wave 2 file `block-hero.php` is a true orphan (see [Orphans](#orphans)).

<a id="2-home-video-hero--hero"></a>
### 2. Home video hero — `hero`

- **Renderer:** [`template-parts/chapters/section-hero.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-hero.php), whole file (48 lines). **CSS:** `chapters.css` lines 173–195. Not an `$args` part — reads Chapters fields directly.
- **Classes:** `.hero`, `.hero__media` (video or poster `<img>`), `.hero__sound` (mute/unmute toggle, only rendered when a real `<video>` exists), `.hero__scrim`, `.hero__c`, `.hero__trust`, `.hero__h`, `.hero__s`, `.hero__cues`. The map's name `hero--video` is not a live class — the class is plain `hero`.
- **Inputs (exact field keys, read from the renderer):** `hero_video` (resolved via `ea_chapters_asset_url`), `hero_poster` (via `ea_chapters_img`), `hero_trust` (the trust line, allows `<br>`), `hero_cta_label`, `hero_cta_url`, `hero_title` (the page's single H1), `hero_subtitle`. No video source falls back to the poster `<img>`.
- **Layout rules, measured.** 1440×900: fills viewport, `min-height: max(620px, 100vh)`, flex, centered, `text-align: center`. H1 box 716×99, centered. At 390×844: fills viewport, H1 box 310×145. Scrim `.hero__scrim` matches `.phero__sc`'s gradient family. Video `object-fit: cover`.
- **Pages:** `/` only.
- **Variants:** None — one page.
- **Exceptions:** None beyond being home-only. Not `phero--compact`, not `phero--media` — a separate file and class family.
- **Orphan?** No.

<a id="3-mokesh-video-hero--mokesh-hero"></a>
### 3. Mokesh video hero — `mokesh-hero`

- **Renderer:** [`template-parts/chapters/parts/mokesh-hero.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/mokesh-hero.php) (the file's own docblock says it is page-specific, not reusable). Emits `phero phero--media mokesh-hero`. **CSS:** inherits `.phero.phero--media` from `chapters.css`; no separate rule block of its own found.
- **Classes:** `.phero.phero--media.mokesh-hero`, plus `.mokesh-hero__yt` for the YouTube background layer.
- **Inputs:** `chap`, `title`, `sub`, `media` (poster / no-JS fallback image), `media_alt`, `yt_id`.
- **Layout rules, measured.** On `/eyal-amit/mokesh-dahiman/`: 1440×792 (the ordinary 88vh media hero box), scrim present, title `text-align: start`. The YouTube layer sits on top as extra markup; its own play/pause geometry was not measured separately.
- **Pages:** `/eyal-amit/mokesh-dahiman/` only.
- **Variants:** None — one page, by design (a declared bespoke, not a silent override of `phero.php`).
- **Exceptions:** None beyond the above.
- **Orphan?** No.

<a id="4-prose-row--sec--intro-body"></a>
### 4. Prose row — `sec` + `intro-body`

- **Renderer:** [`template-parts/chapters/parts/prose.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/prose.php) lines 14–76. **CSS:** `.intro-body` at `chapters.css` line 603.
- **Classes:** `.sec` (base), `.sec--alt` (adds `alt`), `.sec--dark` (adds `dark`; `dark` wins over `alt` if both are passed), `.intro-body`, `.center` (on `.wrap`, when `center` is true), `.chap`/`.chap--c`, `.h2`, `.pfloat`/`.pfloat--s`/`.pfloat--e` (see the float type), `.prose-fold`, `.prose-acc`/`.prose-acc--fold` (see the fold type).
- **Inputs (exact):** `chap`, `title`, `body` (HTML via `wp_kses_post`), `center` (bool), `alt` (bool), `dark` (bool — takes priority over `alt`), `id`, `float_image`, `float_alt`, `float_zoom` (bool — wraps the float in a zoom button), `float_side` (`s` inline-start default, or `e` inline-end — **`e` has zero live uses**), `float_mod` (free class; the only live value is `pfloat--standing`), `literal_alt`, `collapsible` (bool), `toggle_label` (default «לחצו לקריאה», or «להמשך קריאה» when paired with `preview_lines`), `preview_lines` (int — see the fold type).
- **Layout rules, measured.** Reading column `max-width: 82ch`, `margin-inline: auto`. Measured 775–776px at 1440 when not inside a split. `text-align: start` (physical right), not centered as a block. Heading is `.h2` with an inline `margin-bottom: 18px` from the PHP itself (present on every use, not a per-page override). `center` adds `margin-inline: auto` on the column. `dark`/`alt` are background modifiers on the `<section>` only — they do not change the column shape.
- **Pages:** the column itself (`.intro-body`) also appears inside split, point-cards and the QR shell, so a raw class count over-reports this part specifically. Confirmed renders of this exact part: home (3 columns) and 24 designed inner pages — `/accessibility/`, `/bags/`, `/books/`, `/books/kushi-blantis/`, `/books/tsva-bekahol/`, `/books/vekatavta/`, `/didgeridoos/`, `/en/`, `/eyal-amit/`, `/eyal-amit/mokesh-dahiman/`, `/learning/`, `/learning/lectures/`, `/learning/therapist-training/`, `/learning/workshops/`, `/lessons/`, `/method/`, `/privacy/`, `/repair/`, `/snoring-sleep-apnea/`, `/sound-healing/`, `/stand-floor/`, `/stands-storage/`, `/terms/`, `/treatment/`. No prose column at all: `/blog/`, `/contact/`, `/faq/`, `/galleries/`, `/historical-articles/`, `/learning/courses-external/`, `/press/`, `/shop/`, `/testimonials/`.
- **Variants:** `sec--alt`, `sec--dark` (live on `/` and `/lessons/` — `/contact/`'s dark band is the separate contact part, not this one), `center`, the fold (type 5), the float (type 7). `/en/` measures `text-align: left` (whole page is LTR).
- **Exceptions:** No `page-id-` rule. The inline `margin-bottom: 18px` on the H2, and `margin-inline: auto` when centered, are in the part's own PHP, so they apply on every use, not per page. **This type is on the [stage-A review list](#stage-a-review-list)** — the map counts it as not uniform because of the background/fold variance below.
- **Orphan?** No. `parts/lead.php` (a separate, unused, centered statement type) is an orphan (see [Orphans](#orphans)).

<a id="5-prose-fold--prose-fold"></a>
### 5. Prose fold — `prose-fold`

- **Renderer:** same `prose.php`, lines 38–44, active when `collapsible` and `preview_lines` are both set. **CSS:** `chapters.css` lines 705–706.
- **Classes:** `.prose-fold` (peek wrapper, `--fold-lines` custom property), `.prose-fold__peek.intro-body`, `.prose-acc.prose-acc--fold` (a `<details>`), `.prose-acc__t` (the `<summary>`).
- **Inputs:** `collapsible` (bool), `preview_lines` (int — sets `--fold-lines`, default clamp is 4 lines in CSS if unset elsewhere), `toggle_label` (default «להמשך קריאה» in this branch).
- **Layout rules.** The peek is a CSS line-clamp to `--fold-lines` lines. Opening the `<details>` hides the peek via `:has(.prose-acc[open])`. Viewport line-count itself was not measured.
- **Pages:** the three book pages only — `/books/kushi-blantis/`, `/books/tsva-bekahol/`, `/books/vekatavta/`.
- **Variants:** none beyond `preview_lines`.
- **Exceptions:** none.
- **Orphan?** No.

<a id="6-split--split2"></a>
### 6. Split — `split2`

- **Renderer:** [`template-parts/chapters/parts/split.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/split.php) lines 16–21 and full file. **CSS:** `chapters.css` lines 482–487. The Mokesh portrait reuses this grid via `mokesh-portrait.php`, which adds a figcaption the generic part cannot.
- **Classes:** `.split2`, `.split2--rev` (reversed order), `.split2--cover` (image fills the column, no crop, no `figr` class at all), `.figr` + `.figr--l` (5/4, default) / `.figr--p` (4/5, portrait) / `.figr--w` (16/10 — **zero live uses**), `.intro-body`, `.zoom`/`.zoom__hint` (opens the image full-size; only rendered when `zoom` is true).
- **Inputs (exact):** `chap`, `title`, `body` (HTML), `image`, `alt`, `literal_alt`, `figr` (`l`|`p`|`w`, default `l` — ignored when `cover` is true), `reversed` (bool), `soft` (bool — adds `sec--alt` to the section; unrelated to the image's own `alt`), `cover` (bool), `zoom` (bool), `id`. Note: the historic `pairs_with_cards` flag was removed 2026-09-20 (team_00 rejected it on screenshots) — do not reintroduce it.
- **Layout rules, measured.** Two equal columns at 1440: `/method/` 516px + 516px; `/repair/` 524px + 524px (cover). `object-fit: cover` on the image. At 390, `/repair/` collapsed to one 294px column. `reversed` changes order only. `cover` drops the aspect-ratio crop entirely. `zoom` is live only on `/snoring-sleep-apnea/` (2 controls) — the map's name `split--doc` is this `zoom` flag, not a separate class.
- **Pages:** 8 — `/eyal-amit/` (2, one reversed), `/eyal-amit/mokesh-dahiman/` (6, two reversed — via the portrait part), `/lessons/` (1), `/method/` (1), `/repair/` (2, both `--cover`, one reversed), `/snoring-sleep-apnea/` (1, with zoom), `/sound-healing/` (1), `/treatment/` (1). `--cover`: `/repair/` only. `figr--p`: `/eyal-amit/` and Mokesh. `figr--l`: the other seven. `figr--w`: zero.
- **Variants:** cover, reversed, `figr` crop, and zoom are all declared inputs, not silent overrides. Mokesh's figcaption is bespoke to that one page.
- **Exceptions:** The H2 carries the same inline `margin-bottom: 18px` as prose. **This type is on the [stage-A review list](#stage-a-review-list)** — crop shape and zoom availability vary visibly by page.
- **Orphan?** `figr--w` is an unused input value; the part itself is live.

<a id="7-floated-figure--pfloat"></a>
### 7. Floated figure — `pfloat`

- **Renderer:** inside `prose.php` (the `float_*` inputs) — not its own file. **CSS:** `chapters.css` lines 1508–1514 and 1531–1532 (`--standing`).
- **Classes:** `.pfloat`, `.pfloat--s` (inline-start, i.e. floats to the physical right in RTL — the live default), `.pfloat--e` (inline-end — **zero live uses**), `.pfloat--standing` (larger size, via `float_mod`).
- **Inputs:** `float_image`, `float_alt`, `float_zoom` (bool), `float_side` (`s` default, `e` unused), `float_mod` (free class — only live value is `pfloat--standing`).
- **Layout rules, measured.** Default float: `max-width: clamp(180px, 30%, 260px)`, `float: inline-start`. On `/snoring-sleep-apnea/`: measured 146×26 — a small image, not a portrait. Standing (`/repair/`): 295px at 1440 (CSS cap `min(320px, 38%)`), 12px image radius; at 390 it becomes 294px, `float: none` (the CSS drops the float under the mobile breakpoint entirely).
- **Pages:** `pfloat` (either size): `/repair/` and `/snoring-sleep-apnea/` only. `pfloat--standing`: `/repair/` only.
- **Variants:** the two live sizes (default cap vs. standing) are declared, not silent — `/repair/` uses standing on purpose, `/snoring-sleep-apnea/` keeps the older small float on purpose (matches the 2026-09-23 canon's own instruction on this one point).
- **Exceptions:** none beyond the modifier itself. **This type is on the [stage-A review list](#stage-a-review-list)** — the two floats read as different sizes of prominence.
- **Orphan?** the `e` side is an unused input value.

<a id="8-cta-band--cta-band"></a>
### 8. CTA band — `cta-band`

- **Renderer:** [`template-parts/chapters/parts/cta.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/cta.php), full file (48 lines). **CSS:** `chapters.css` lines 845–898 (the three-column rule), 1539–1555 (`--sand`, and the unused `--stack`).
- **Classes:** `.cta-band`, `.cta-band--row` (the only live layout — every band is this), `.cta-band--stack` (declared, **zero live uses**), `.cta-band--choc` (declared, **zero live uses, marked retired in the CSS comment at line 1541**), `.cta-band--sand`, `.cta-band__in`, `.cta-band__logo.cta-band__logo--side` (see the logo element), `.cta-band__txt`, `.cta-band__h`, `.cta-band__p`, `.cta-band__act`, `.cta-band__act-group` (added when a second button is present), `.ea-pending-inline` (the `temp_note` line).
- **Inputs (exact):** `title`, `body`, `cta_label`, `cta_url`, `cta2_label`, `cta2_url` (a second button, always rendered with class `btn--gw` — **zero live uses**), `cta_slug` (external purchase link, same convention as `phero.php`), `id`, `stack` (bool — column layout, drops the logo — **zero live uses**), `choc` (bool — **zero live uses, retired**), `sand` (bool — sand-fill, ink text), `btn` (button class override, default `btn--terra`), `temp_note` (a pending-approval line under the band, live only on `/books/`).
- **Layout rules, measured (1.5.138, current/stable).** Three equal thirds. Grid is `direction: ltr` so track 1 is the physical left, track 2 the middle, track 3 the physical right; the text itself inside track 2 is `direction: rtl; text-align: right`. Right third: logo mark only (`aria-hidden`, decorative). Middle third: text. Left third: button, `justify-content: center`. At 1440, every measured band (home, `/method/`, `/testimonials/`, `/bags/`, `/repair/`, `/learning/`, `/books/`, `/books/kushi-blantis/`, all three on `/snoring-sleep-apnea/`) used identical tracks: 357px + 357px + 357px inside a 1120px row. Logo at x≈923, text at x≈541, button at x≈160. At 390 the same bands collapse to one column: logo 140px centered, then text full-width, then the centered button. That collapse is the stylesheet's own rule below 880px, not a per-page override. `--sand` replaces the dark wash with the sand ground and ink text; it does not touch the grid.
- **Pages:** 29 bands on 19 pages, every one `cta-band--row`. Content shape (data, not CSS): 8 bands have heading+body+button; 2 are body-only (home, `/lessons/`); 2 are heading-only (one each on the Kushi and Tsva book pages); the remaining 17 are button-only with an empty middle third. 13 pages add `--sand`. `/books/` uses `btn--gw` (outline) instead of the terracotta default. `cta2_label` (second button): zero pages. `temp_note`: `/books/` only.
- **Variants:** the grid is uniform across every band, including `/testimonials/` (page id 73), which used to be carved out (see Exceptions). Sand vs. dark and terra vs. `btn--gw` are declared inputs. A button-only band is still this type, not a degraded one.
- **Exceptions:** at the start of the map's read, `chapters.css` still had `body.page-id-73 .cta-band--row … { padding-inline-start: 0 }`. **That rule is absent from deployed 1.5.138.** Measured, `/testimonials/` now uses the same 357px tracks as every other page — do not carry the page-73 exception forward from an older document. No other `page-id-` rule exists anywhere in the theme CSS for this type. The home band's `sand` flag is hardcoded in `tpl-chapters-home.php` (home's CTA is not called through the general defaults path). `btn--sand` is not a CTA button at all — it belongs to the photo-band type and is hardcoded there. **This type is on the [stage-A review list](#stage-a-review-list)** — the content-shape variance (empty middle third vs. full heading+body) is visible.
- **Orphan?** The part itself is live. `--stack` and `--choc` are orphan modifiers (see [Orphans](#orphans)).

<a id="9-point-cards--point-cards"></a>
### 9. Point cards — `point-cards`

- **Renderer:** [`template-parts/chapters/parts/point-cards.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/point-cards.php), full file. **CSS:** `chapters.css` lines 1555–1560.
- **Classes:** `.point-cards`, `.point-cards__lead` (`.intro-body` also applied), `.point-cards__grid`, `.point-cards__card`, `.point-cards__after` (`.intro-body` also applied). Section is always `.sec.sec--alt`.
- **Inputs (exact):** `chap`, `title`, `id`, `lead` (HTML, optional intro above the grid), `after` (HTML, optional closing note below the grid), `items[{title, text}]` (a card with both empty is skipped entirely, not rendered blank).
- **Layout rules, measured.** White cards, two columns, always — even at 390. `/repair/` at 1440: 544px + 544px. At 390: still two columns, 139px + 139px (matches the two grids seen on that page).
- **Pages:** `/repair/` only (two separate grids on that one page).
- **Variants:** none — one page.
- **Exceptions:** the H2 has the same inline `margin-bottom: 18px` convention. No `page-id-` rule.
- **Orphan?** No. Not the same thing as the home "whom" cards (type 13).

<a id="10-photo-band--photo-band"></a>
### 10. Photo band — `photo-band`

- **Renderer:** [`template-parts/chapters/parts/photo-band.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/photo-band.php), full file. **CSS:** `chapters.css` lines 1569–1586.
- **Classes:** `.photo-band`, `.photo-band__media`, `.photo-band__sc` (scrim), `.photo-band__in`, `.h2` for the title, `.btn.btn--sand` (the button — hardcoded class, not an input).
- **Inputs (exact):** `title`, `body` (HTML), `image`, `alt`, `literal_alt`, `cta_label`, `cta_url`, `id`. The button's class is **not** exposed as an input — the PHP always writes `btn btn--sand`.
- **Layout rules, measured.** Full-bleed photo, scrim, text block. At 1440: `.photo-band__in` measured 640×384, `text-align: start`, positioned with `margin-inline-end: 8vw` and `width: min(640px, 100%)` (the 8vw offset itself was not re-measured as an x-coordinate). At 390: text block 390×408, scrim switches to a top-to-bottom gradient.
- **Pages:** `/repair/` only.
- **Variants:** none — one page.
- **Exceptions:** the sand button is hardcoded, so this row cannot take a different button color. Home's "how to start" band (type 15) is a visually similar but structurally different type — do not conflate them.
- **Orphan?** No.

<a id="11-gallery--gallery"></a>
### 11. Gallery — `gallery`

- **Renderer:** [`template-parts/chapters/parts/gallery.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/gallery.php), full file. **CSS:** `chapters.css` lines 1177–1194 (base), 1186–1189 (`--doc`), 1575–1590 (`--portraits`). Home's peek section ([`section-home-09-peek.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-home-09-peek.php)) emits the same `.gallery`/`.gfig` classes without going through this file — it is the same type, not a second one.
- **Classes:** `.gallery`, `.gallery--doc` (**zero live uses**), `.gallery--portraits`, `.gfig`, `.gfig--pending` (empty pending slot), `.gfig--pending-img` (pending badge over an existing image), `.gfig__cap`, `.ea-pending-approval`/`.ea-pending-approval__badge`/`__title`/`__note` (see the pending-badge element).
- **Inputs (exact):** `chap`, `title`, `lead`, `alt` (bool, section background — default **true**), `id`, `doc` (bool — **zero live uses**), `portraits` (bool), `items[{image, alt, cap, pending, pending_label}]`, `literal_alt`. An item with `pending: true` and no image renders the glowing "ממתין לאישור" slot instead of being skipped.
- **Layout rules, measured.** Default: three columns, image `aspect-ratio: 4/3`, `object-fit: cover`. Home, Mokesh, and the Kushi book at 1440: 357px × 3. `--portraits` (`/repair/`): four columns of 267px at 1440, aspect `3/4`; at 390, two columns of 141px. Caption (`.gfig__cap`) overlays the bottom of the figure.
- **Pages:** 11 — `/` (via the peek section, same classes), `/bags/`, `/books/kushi-blantis/`, `/books/tsva-bekahol/`, `/books/vekatavta/`, `/eyal-amit/`, `/eyal-amit/mokesh-dahiman/`, `/galleries/` (149 figures), `/repair/` (`--portraits`), `/stands-storage/`, `/testimonials/`. `--doc`: zero pages. `--portraits`: `/repair/` only.
- **Variants:** the 4:3 three-column grid is the default everywhere except the one declared `--portraits` page. `--doc` is an unused input.
- **Exceptions:** none per page. Pending slots are an item-level flag, not a page-level one. **This type is on the [stage-A review list](#stage-a-review-list)** — the portrait grid on `/repair/` looks visibly different (narrower, taller, four not three).
- **Orphan?** `--doc` is an unused modifier; the part itself is live.

<a id="12-bleed-quote--bleed"></a>
### 12. Bleed quote — `bleed`

- **Renderer:** [`template-parts/chapters/parts/bleed.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/bleed.php), full file. Home's version is a separate file, [`section-photo-band.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-photo-band.php), which emits the identical `.bleed` markup and is the same type, not a second one (its filename is misleading — it is not the `photo-band` type). **CSS:** `chapters.css` lines 291–306.
- **Classes:** `.bleed`, `.bleed__sc`, `.bleed__c`, `.bleed__in`, `.bleed__q`, `.bleed__a`.
- **Inputs (part):** `image`, `alt`, `quote`, `attrib`. Home's own section instead reads Chapters fields `band_image`, `band_alt`, `band_quote`, `band_attrib` directly (no `$args`).
- **Layout rules, measured.** Full-bleed photo, `height: clamp(340px, 46vw, 560px)`, `object-fit: cover`, scrim (same gradient family as the heroes). Quote `.bleed__q`: display size, white, `max-width: 20ch`, `text-align: start`. On `/`: 340×48. On Mokesh (longer quote, same rule): 383×95. Attribution is a small uppercase line beneath.
- **Pages:** 4 — `/`, `/bags/`, `/eyal-amit/mokesh-dahiman/`, `/treatment/`.
- **Variants:** none beyond quote length changing box height, which is the rule doing its job, not an override.
- **Exceptions:** none.
- **Orphan?** No.

<a id="13-whom-cards--whom"></a>
### 13. Whom cards — `whom`

- **Renderer:** [`template-parts/chapters/section-02-for-whom.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-02-for-whom.php), full file. **CSS:** `chapters.css` line 237. The map's name `whom-cards` is not the live class — it is `.whom`.
- **Classes:** `.sec.sec--alt`, `.whom`, `.whom__i` (item), `.whom__m` (media slot), `.ph` (placeholder text when an item has no image), `.whom__p` (caption line).
- **Inputs (exact field keys):** `whom_chap`, `whom_title`, `whom_lead`, and repeater `whom_items[{image, alt, text}]`.
- **Layout rules, measured.** Four equal columns at 1440: 258px × 4, centered section heading. At 390: one column, 294px. Each item: a photo over a short line.
- **Pages:** `/` only.
- **Variants:** none — one page. Not `point-cards` (type 9) and not `reveals.php` (an orphan, see [Orphans](#orphans)).
- **Exceptions:** none.
- **Orphan?** No.

<a id="14-compare-pair--cmp"></a>
### 14. Compare pair — `cmp`

- **Renderer:** [`template-parts/chapters/section-06-compare.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-06-compare.php), full file. **CSS:** `chapters.css` line 279. The map's name `cmp-pair` is not the live class — it is `.cmp`.
- **Classes:** `.cmp`, `.cmpc` (card), `.cmpc__m` (media), `.cmpc__sc` (scrim), `.cmpc__b` (body), `.cmpc__t` (title).
- **Inputs (exact field keys):** `cmp_chap`, `cmp_title`, `cmp_lead`, and two fixed cards — `cmp_a_image`, `cmp_a_alt`, `cmp_a_title`, `cmp_a_text`, `cmp_a_cta`, `cmp_a_url`; the same six keys again prefixed `cmp_b_`. Not a repeater — exactly two cards, hardcoded in the renderer.
- **Layout rules, measured.** Two equal columns at 1440: 540px + 540px. At 390: one column. Centered heading.
- **Pages:** `/` only.
- **Variants:** none — one page.
- **Exceptions:** none. The unrelated Wave 2 `block-service-comparison.php` is a separate, unused file (see [Orphans](#orphans)).
- **Orphan?** No.

<a id="15-how-to-start--start"></a>
### 15. How to start — `start`

- **Renderer:** [`template-parts/chapters/section-07-how-to-start.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-07-how-to-start.php), full file. **CSS:** `chapters.css` lines 309–315 (band), 316 (`.steps3`).
- **Classes:** `.start`, `.start__bg`, `.start__sc`, `.start__in`, `.start__h`, `.steps3`, `.st3`/`.st3__ic`/`.st3__t`/`.st3__p`.
- **Inputs (exact field keys):** `start_bg` (background image), `start_steps` (repeater rows, `{title, text}` each — icon is chosen by index from three fixed SVGs baked into the template, not an input), `start_chap`, `start_title`, `start_cta_label`, `start_cta_url`.
- **Layout rules, measured.** Dark image band, centered text (`.start__in`, 1100px wide at 1440). Three step columns at 1440: 302px × 3. At 390: one column. Button is hardcoded `btn btn--terra`, centered, with an inline `margin-top: 48px` wrapper — not `photo-band`'s sand button.
- **Pages:** `/` only.
- **Variants:** none — one page.
- **Exceptions:** the inline margin on the button wrapper, in the template on every use (only home, so moot in practice).
- **Orphan?** No. `parts/steps.php` (class `show`/`shstep`) is a separate, unused file (see [Orphans](#orphans)).

<a id="16-portrait-collage--collage-inside-about"></a>
### 16. Portrait collage — `collage` inside `about`

- **Renderer:** [`template-parts/chapters/section-01-about.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-01-about.php), full file. **CSS:** `chapters.css` lines 219–223 (`.about`) plus the adjacent `.collage` rule. Map's name `portrait-trio`. A timeline used to live here and is explicitly not rendered (the file's own comment says so).
- **Classes:** `.about`, `.about__col`, `.about__body`, `.collage`, `.collage__big`, `.collage__sm`.
- **Inputs (exact field keys):** `about_chap`, `about_title`, `about_body` (HTML, passed through `ea_replace_retired_brand`), `about_img1`/`about_img1_alt`, `about_img2`/`about_img2_alt`, `about_img3`/`about_img3_alt`. Not a generic `$args` part — three fixed image slots, not a repeater.
- **Layout rules.** Stylesheet: text column + collage in `grid-template-columns: 1fr 1.05fr`, one column under 900px. Collage itself: `1.5fr 1fr`, two rows (one large image, two small). Measured at 1440: collage box 535×391, tracks 312px + 208px. Bio text alignment was not isolated from the neighboring prose column on the same page.
- **Pages:** `/` only.
- **Variants:** none — one page.
- **Exceptions:** the H2 has inline `margin-bottom: 22px` (not the usual 18px — a genuine off-scale annotation, not a defect, since it is declared in the part itself). Not the same thing as `gallery--portraits`.
- **Orphan?** No.

<a id="17-studio-split--studio"></a>
### 17. Studio split — `studio`

- **Renderer:** [`template-parts/chapters/section-04-studio.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-04-studio.php), full file. **CSS:** `chapters.css` lines 257–265.
- **Classes:** `.sec` (with inline `style="padding:0"`), `.studio`, `.studio__t`, `.arcs`, `.chap`, `.studio__h`, `.studio__p`, `.btn.btn--gw` (hardcoded), `.studio__m`.
- **Inputs (exact field keys):** `studio_image`, `studio_alt`, `studio_chap`, `studio_title`, `studio_body` (HTML, allows `<br>` via `ea_chapters_kses_e`), `studio_cta_label`, `studio_cta_url`. The button class (`btn--gw`) and its `align-self:flex-start` are hardcoded, not inputs.
- **Layout rules.** Stylesheet only (not measured in this pass): grid `.9fr 1.1fr`, `min-height: 460px`, dark text column, image `object-fit: cover` on the other side, text `max-width: 42ch`. Collapse breakpoint not measured.
- **Pages:** `/` only.
- **Variants:** none — one page.
- **Exceptions:** the two inline styles (section padding, button alignment) live in the template, so they apply wherever this file is used — only home today.
- **Orphan?** No. Not the same as `split2`.

<a id="18-testimonial-marquee--testi-mq"></a>
### 18. Testimonial marquee — `testi-mq`

- **Renderer:** [`template-parts/chapters/parts/testimonials.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/testimonials.php) and the home wrapper [`section-05-testimonials.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-05-testimonials.php). **CSS:** `chapters.css` lines 1055–1077.
- **Classes:** `.testi-mq`, `.testi-mq__btn`, `.testi-mq__btn--left` (`order: 3`, so "next" lands on the correct physical side under RTL scroll math).
- **Inputs (exact):** `chap`, `title`, `lead` (HTML), `cat`, `items[{text, name, href}]`, `layout` (chooses marquee vs. grid, type 19), `archive`. Home's wrapper reads `testi_items` first (its 15 approved rows), falling back to the Facebook corpus (`ea-testimonials-fb.json`, via `ea_fb_testimonials_all()`) only when `testi_items` is empty; also `testi_cta_label`/`testi_cta_url` for the link to `/testimonials/`.
- **Layout rules.** A row of cards, previous/next buttons, no auto-scroll. Track is `direction: ltr` on purpose (keeps the scroll math from fighting RTL). Card width and gap were not measured.
- **Pages:** 5 — `/`, `/lessons/`, `/method/`, `/sound-healing/`, `/treatment/`.
- **Variants:** same markup on all five; whether a page's quotes are the shared 48-item corpus or its own `items` list is a content difference, not a layout one.
- **Exceptions:** none in CSS. The map's name `ea-testi-cards` for the home testimonials is a misattribution — home is this marquee, not type 20.
- **Orphan?** The Wave 2 carousel/row blocks are unused (see [Orphans](#orphans)); this marquee is the live implementation.

<a id="19-testimonial-grid--testi-grid"></a>
### 19. Testimonial grid — `testi-grid`

- **Renderer:** same `testimonials.php`, the grid branch, selected by the `layout` input. **CSS:** `chapters.css` line 1142.
- **Classes:** `.testi-grid` (or equivalent grid class emitted by the same file's grid branch).
- **Inputs:** same as the marquee; `/testimonials/` uses three separate `testimonials` part calls with the grid layout, rather than one call with three groups.
- **Layout rules.** Stylesheet: three columns, `direction: rtl`, `text-align: right`, 24px gap. Column widths not measured in the viewport.
- **Pages:** `/testimonials/` only (three grids on that one page).
- **Variants:** one page, three repeats of the same grid.
- **Exceptions:** none. The removed page-73 CTA exception (type 8) did not target this grid.
- **Orphan?** No.

<a id="20-testimonial-cards--ea-testi-cards"></a>
### 20. Testimonial cards — `ea-testi-cards`

- **Renderer:** [`template-parts/chapters/parts/testi-cards.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/testi-cards.php), full file. **CSS:** `chapters.css` lines 1593–1600.
- **Classes:** `.ea-testi-cards` (or the container class from this file), card items with an ivory ground and a terracotta inline-start border.
- **Inputs (exact):** `quotes` (array of HTML strings — the part adds no heading, name, or label of its own), `id`, `alt`.
- **Layout rules, measured.** Two columns at 1440. `/snoring-sleep-apnea/`: 542px + 542px. Breakpoint to one column under 880px was not measured.
- **Pages:** `/snoring-sleep-apnea/` only.
- **Variants:** none — one page.
- **Exceptions:** none.
- **Orphan?** No.

<a id="21-faq"></a>
### 21. FAQ

Three renderers, one visual family — document all three together, they share CSS.

- **Full bank.** Renderer [`template-parts/blocks/block-faq-list.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-faq-list.php). Inputs via `$args`: `ea_faq_only_category`, `ea_faq_only_categories`, `ea_faq_view_chap`, `ea_faq_view_title`, `ea_faq_view_id`. With no filter, renders the whole `ea_faq` CPT with a category table-of-contents (`.ea-faq-toc`) and one group per category. **Pages:** `/faq/` only.
- **View-only.** Renderers [`template-parts/chapters/parts/faq-inline.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/faq-inline.php) and [`faqblock.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/faqblock.php) (which delegates into the block). Inline's inputs: `chap`, `title`, `id`, `items[{q, a}]`, `cards` (bool, adds `--cards`), `open_first` (bool). `faqblock`'s inputs: `cat`/`cats`, `chap`, `title`, `id` — items come from the CPT, not from `items`. **Pages:** 14 — `/bags/`, `/books/kushi-blantis/`, `/books/tsva-bekahol/`, `/books/vekatavta/`, `/didgeridoos/`, `/learning/lectures/`, `/learning/workshops/`, `/lessons/`, `/method/`, `/repair/`, `/sound-healing/`, `/stand-floor/`, `/stands-storage/`, `/treatment/`.
- **Mini.** Renderer [`template-parts/blocks/block-faq-mini.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-faq-mini.php), class `.ea-faq-mini-section`. Context `ea_faq_mini_ctx`: `heading`, `aria_label`, `items[{q, a}]`, `footer{label, href}`. Home passes six corpus questions plus a link to `/faq/`. **Pages:** `/` only. It contains an inner `.ea-faq-list`, so a naive class search double-counts home.
- **Classes (shared family):** `.ea-faq-toc`, the question-row flex line (question + toggle icon), `.ea-faq-list--cards` (max-width 760px, white rounded cards, borders removed).
- **Layout rules, measured.** The question row is a max-width 820px list. `/faq/` and `/method/` had no item pre-opened. `/repair/`'s cards variant had the first item open — this is the `open_first`/`active`-style behavior of that one page, not a global rule; the 2026-09-23 canon's "first question open" claim is true only of the cards variant on `/repair/`.
- **Variants:** plain view-only is uniform; cards and mini are declared variants; open-by-default is an input, not the default state.
- **Exceptions:** none per page id. **This type is on the [stage-A review list](#stage-a-review-list)** — the cards look visibly different from the plain list.
- **Orphan?** No.

<a id="22-definition-accordion--dd"></a>
### 22. Definition accordion — `dd`

- **Renderer:** [`template-parts/chapters/parts/dd.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/dd.php), full file. Map's name on the snoring page: `deflist`.
- **Classes:** `.dd` (or equivalent container from this file), rendered as a stack of `<details>`.
- **Inputs (exact):** `chap`, `title`, `lead` (HTML), `dark` (bool), `id`, `items[{tag, title, body, active}]` — `active` opens that one row by default.
- **Layout rules.** Centered heading. Viewport column widths: not measured.
- **Pages:** 3 — `/lessons/`, `/snoring-sleep-apnea/`, `/treatment/`.
- **Variants:** same markup on all three; which row opens is the per-item `active` flag.
- **Exceptions:** none found.
- **Orphan?** No.

<a id="23-table-of-contents--ea-toc"></a>
### 23. Table of contents — `ea-toc`

- **Renderer:** [`template-parts/chapters/parts/toc.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/toc.php), full file. **CSS:** `chapters.css` lines 1363–1372, plus the `:has(> .phero + .ea-toc)` block at ~1433–1479, which restyles the toc for a dark hero context.
- **Classes:** `.ea-toc`, structural classes for the inline list / rail / mobile-sheet presentations of the same list.
- **Inputs:** `items[{id, label}]` (empty → renders nothing), `heading`.
- **Layout rules, measured.** On `/snoring-sleep-apnea/`, the inline list: 1066×321, `text-align: start`. The `:has()` rule fires only when this part is the element immediately after `.phero` — a structural condition, not a page id, and it will fire on any future page with that exact order. Rail and sheet geometry: not measured.
- **Pages:** `/snoring-sleep-apnea/` only.
- **Variants:** none — one page.
- **Exceptions:** the `:has()` pairing above.
- **Orphan?** No.

<a id="24-book--product-cards--bookcards"></a>
### 24. Book / product cards — `bookcards`

- **Renderer:** [`template-parts/chapters/parts/bookcard.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/bookcard.php), full file. **CSS:** `chapters.css` lines 1148–1168.
- **Classes:** `.bookcards` (or equivalent grid class), whole card is one `<a>`.
- **Inputs (exact):** `chap`, `title`, `lead`, `alt`, `id`, `cta_label` (default «לעמוד הספר ←»), `card_heading_level`, `items[{cover, title, blurb, url, meta, cta}]`.
- **Layout rules, measured.** `/books/` at 1440: three columns, ~349px, `text-align: right`, cover ratio 3/4. Breakpoints (two columns under 880px, one under 560px) not measured.
- **Pages:** 3 — `/books/` (the books), `/shop/` (5 cards), `/qr/` (the QR hub page — not the individual `/qr/qrN/` articles).
- **Variants:** same grid; `cta_label` changes with context (books vs. shop vs. QR hub).
- **Exceptions:** none.
- **Orphan?** No. `parts/product-cta.php` (price + purchase buttons) is a separate, unused file (see [Orphans](#orphans)).

<a id="25-spotlight-row--ea-now"></a>
### 25. Spotlight row — `ea-now`

- **Renderer:** [`template-parts/chapters/section-home-spotlight.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-home-spotlight.php), full file. **CSS:** [`assets/css/ea-open-round.css`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-open-round.css) lines 6–36.
- **Classes:** `.ea-now` (section id is always the literal string `ea-now`, on every page that uses this partial — safe because it never renders twice per document).
- **Inputs (exact):** optional `$args['cards']`, each `{image, title, line1, line2, url}`. With no `$args`, reads Chapters field `now_cards`. `/books/` explicitly overrides with `ea_muzza_spotlight_cards()` (books + the bundle) rather than forking the file.
- **Layout rules, measured.** Four columns at 1440 (283px × 4) on both `/` and `/books/`. At 390 on home: two columns of 178px. Image ratio 3/2, `object-fit: cover`. Title plus up to two lines.
- **Pages:** `/` and `/books/`.
- **Variants:** same grid on both; the cards differ because the input differs, not the layout.
- **Exceptions:** none.
- **Orphan?** No.

<a id="26-video-block--videoblk"></a>
### 26. Video block — `videoblk`

- **Renderer:** [`template-parts/chapters/parts/videoblk.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/videoblk.php) and home's [`section-home-03-video.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-home-03-video.php).
- **Classes:** `.videoblk`.
- **Inputs (part):** `chap`, `title`, `body` (HTML), `poster`, `video`, `cap`, `alt`. Home's own section reads its fields directly and embeds a YouTube iframe.
- **Layout rules.** A 16/9 frame, `max-width: 760px` on the title column, inline `margin-top: 48px` on the frame from the PHP. Player chrome not measured.
- **Pages:** the class is on 4 — `/` (a real, playing YouTube embed), `/lessons/`, `/sound-healing/`, `/treatment/`. The last three currently carry `ea-pending-approval` and render the placeholder variant (type 27) because their defaults have no `video` URL yet — treat `/` as this type and the other three as the placeholder.
- **Variants:** the frame class is shared; a playing embed and a pending box are two content states inside the same shell, not two shells.
- **Exceptions:** home's iframe has inline `position:absolute;inset:0;…`. The blog JSON mapper (type 37) can also inject a YouTube iframe with inline styles into a body; no published post does this yet. **This type is on the [stage-A review list](#stage-a-review-list)** — a real, playable video on one page vs. an empty pending box on three others is visible.
- **Orphan?** No.

<a id="27-video-placeholder--videoblk--pending-box"></a>
### 27. Video placeholder — `videoblk` + pending box

- **Renderer:** [`template-parts/chapters/parts/videoblk-placeholder.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/videoblk-placeholder.php), full file.
- **Classes:** `.videoblk` (same shell as type 26), `.ea-pending-approval` (absolutely positioned inside it).
- **Inputs:** `chap`, `title`, `body`, `box` (the accessible name of the empty frame), `id`. No video URL — that is the point of this variant.
- **Layout rules.** Same 16/9 frame as the video block; not separately measured beyond the class co-occurrence.
- **Pages:** `/lessons/`, `/sound-healing/`, `/treatment/`.
- **Variants:** same pattern on all three.
- **Exceptions:** inline positioning on the pending box, in the part, applying to every use.
- **Orphan?** No.

<a id="28-facebook-embeds--fbgrid"></a>
### 28. Facebook embeds — `fbgrid`

- **Renderer:** [`template-parts/chapters/parts/fbembeds.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/fbembeds.php), full file.
- **Classes:** `.fbgrid` (or equivalent container).
- **Inputs:** `chap`, `title`, `lead`, `alt`, `id`, `items[{href, title}]`.
- **Layout rules.** A grid of Facebook post iframes; column count not measured.
- **Pages:** `/eyal-amit/mokesh-dahiman/` only.
- **Variants:** none — one page.
- **Exceptions:** iframe `style="border:none;overflow:hidden"`, inline in the part.
- **Orphan?** No.

<a id="29-timeline--tl"></a>
### 29. Timeline — `tl`

- **Renderer:** [`template-parts/chapters/parts/timeline.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/timeline.php), full file. **CSS:** `chapters.css` line 228.
- **Classes:** `.tl` (or equivalent container).
- **Inputs:** `chap`, `title`, `lead`, `dark`, `alt`, `center`, `id`, `items[{year, text}]`.
- **Layout rules, measured.** On the Mokesh page at 1440: four columns of 276px, top border, years as markers. Mobile collapse not measured.
- **Pages:** `/eyal-amit/mokesh-dahiman/` only. Home's about section explicitly does **not** render a timeline (its own code comment says so).
- **Variants:** none — one page.
- **Exceptions:** none found.
- **Orphan?** No.

<a id="30-photo-slot--ea-photo-slot"></a>
### 30. Photo slot — `ea-photo-slot`

- **Renderer:** [`template-parts/chapters/parts/photo-slot.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/photo-slot.php), full file. **CSS:** `chapters.css` lines 130–131.
- **Classes:** `.ea-photo-slot`, `.ph` (the empty box carrying the label).
- **Inputs:** `label` (visible text and the aria name; default "Photo — to be chosen"), `id`.
- **Layout rules, measured.** A 16/9 reservation. On `/learning/` and `/en/`: 1104×621 at 1440 (exactly 16/9). Label text sits inside `.ph`. On `/en/` it follows the LTR page (`text-align: left`).
- **Pages:** `/learning/` (3 slots) and `/en/` (5 slots) — 8 slots total, two pages.
- **Variants:** same frame; the label string is the input. These are standing reservations, not missing images inside a gallery.
- **Exceptions:** none beyond page direction on `/en/`.
- **Orphan?** No.

<a id="31-contact-rows"></a>
### 31. Contact rows

- **Renderer:** [`template-parts/chapters/parts/contact.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/contact.php), full file — three sections in one file.
- **Classes:** `.ea-wave2-contact` (the form, beside a small photo), `.ea-wave2-contact__cta` (dark WhatsApp band, `data-block="contact-cta"`), `.ea-wave2-contact__nap` (name/address/phone line).
- **Inputs:** none. The part takes no `title`/`body` — it reads NAP helper functions and a hardcoded CF7 shortcode directly.
- **Layout rules.** Per the file's own comment: three stacked rows — form beside a photo, dark WhatsApp band, then the NAP line. The half-height page hero above these three rows is the page hero (type 1, `--half`), not part of this type. Form column widths not measured.
- **Pages:** `/contact/` only.
- **Variants:** none — one page.
- **Exceptions:** `ea_wave2_render_whatsapp_float()` returns immediately when `is_page('contact')` — the floating WhatsApp button every other page gets is absent here (a PHP page check, not a CSS `page-id` rule). The phone link has inline `white-space: nowrap`.
- **Orphan?** No. `block-contact-cta.php` is a separate, unused Wave 2 file (see [Orphans](#orphans)).

<a id="32-press-list--ea-press"></a>
### 32. Press list — `ea-press`

- **Renderer:** rendered by [`inc/wave2-w2-07.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/wave2-w2-07.php) around line 225, on the plain content template (not a Chapters part). **CSS:** [`assets/css/w2-07-heritage.css`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/w2-07-heritage.css) lines 64–88.
- **Classes:** `.ea-press`, `.ea-editorial`, `.ea-editorial-press` (body classes); `/historical-articles/` additionally uses `.ea-historical-archive` and four `.ea-content-section` blocks.
- **Inputs:** not an `$args` part — a fixed list of mentions (year, source, link, title). Links open in a new tab.
- **Layout rules, measured.** Each row a flex line, baseline-aligned, date then link. `/press/` at 1440: one item 960×94, `text-align: start`. This page has no `phero` and no Chapters hero at all.
- **Pages:** `/press/` (the list) and `/historical-articles/` (a press-quote block reusing `.ea-press`, plus the archive sections — a different page shape overall, not the press index).
- **Variants:** the row markup matches on both; the surrounding page differs.
- **Exceptions:** both pages sit outside the Chapters router on purpose (`/press/` is forced to `tpl-content.php`). No `page-id-` CSS.
- **Orphan?** No.

<a id="33-qr-article-shell"></a>
### 33. QR article shell

- **Renderer:** [`page-templates/tpl-chapters-qr.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-qr.php) lines 27–51. Not a chapter part. The hub page `/qr/` is a normal Chapters page using `bookcards` (type 24), not this shell.
- **Classes:** `.phero` (text hero, no photo — see the pending change below), `.intro-body` (one column), body class `.ea-qr`. A hardcoded back link «כל דפי ה-QR».
- **Inputs:** from the post itself — title (the H1), featured image if present (**none of the 48 currently have one**), and `the_content()` dropped whole into one `.intro-body`. Eyebrow is the literal string `QR`.
- **Layout rules, measured.** `/qr/qr1/` at 1440: text hero 363px tall (no photo, no 88vh), one reading column 776px wide, `text-align: start`. Inside `the_content`, the HTML is migrated as-is and was not decomposed into row types — a heading inside it is not a prose-part heading.
- **Pages:** `/qr/qr1/` through `/qr/qr48/` (48 pages). All 48: `phero` + exactly one `.intro-body` + `.ea-qr`.
- **Variants:** the shell is uniform across all 48; the migrated body inside it is free content, not a type — **this is the reason the printed-code population stays on the [stage-A review list](#stage-a-review-list)** as a no-type area even though the shell itself is documented here.
- **Exceptions:** the back link has inline `margin-top: var(--ea-space-8, 32px)` in the template, on every QR child. **Pending change, approved not built:** [`SKETCH-BLOG-QR.html`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/S007-GROK/wave-b-sketches/SKETCH-BLOG-QR.html) (approved) specifies that a QR page with a unique photo gets a photo hero, and one with none gets a **logo hero**, not the current plain text hero — the same rule as the blog's archive/new-post types below. Zero of the 48 pages implement this today; all 48 currently render the plain text hero. This is recorded on the [stage-A review list](#stage-a-review-list), not treated as already true.
- **Orphan?** The legacy `tpl-qr.php` (which called the orphaned `block-topnav.php`) is not what these live URLs render.

<a id="34-blog--archive-post-existing-ea-post-content"></a>
### 34. Blog — Archive post (existing, `ea-post-content`)

**This is what every one of the 52 published posts renders today.** Team_00 named this the
"Archive" type: deliberately loose, so the old posts need minimum work to be acceptable — do
not tighten it into the New Post schema (type 37).

- **Renderer:** [`page-templates/tpl-chapters-blog-single.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-chapters-blog-single.php) lines 90–107, the branch that runs when no JSON row document exists for the post (every post today — see type 37). **CSS:** [`assets/css/ea-blog.css`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/assets/css/ea-blog.css) lines 207–217.
- **Classes:** `.phero.phero--media` (or plain `.phero`, see below) for the hero, `.ea-post-content` for the body.
- **Inputs:** the post object itself — title, categories (hero eyebrow), author, date, featured image, `the_content` (free HTML), tags, a copy-link share control. No row-type argument of any kind.
- **Layout rules, measured.** One sampled post (`/100-100-100-תודה/`) at 1440: media hero 792px (88vh), then `.ea-post-content` 776×2371, `text-align: start`. Images inside it are `max-width: 100%`.
- **Pages:** all 52 published posts. 51 have `phero--media`. **The historic-as-is rule (policy, locked):** the hero image carried over from the old site is never replaced, even where it is dated or low-quality.
- **Variants:** the shell is uniform; the body is free HTML, exactly like the QR body (type 33) — this is why "a row of type A inside a blog post" has no row-slot mechanism to point at for these 52 posts, even though the shell itself is this named type.
- **Exceptions/known gap — approved, not built:** the locked policy (`PHASE-2-BLOG-QR-AFTER-SKETCH.md`, §2/§4) says **a post with no featured image gets a logo hero, not a portrait hero and not the generic text hero.** Measured today: the one post without a featured image (the 2012 Pardes Hanna studio post) renders the ordinary text hero from `phero.php` — no logo mark, because that hero variant does not exist yet anywhere in the renderer. This is recorded on the [stage-A review list](#stage-a-review-list) as an implementation gap, not presented as already true.
- **Orphan?** No. `tpl-blog-single.php` (the pre-Chapters legacy template, topnav + contact-cta) is not what these 52 URLs render (see [Orphans](#orphans)).

<a id="35-blog-card--ea-blog-card"></a>
### 35. Blog card — `ea-blog-card`

- **Renderer:** [`template-parts/blocks/block-blog-card.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-blog-card.php), full file. Called from the Chapters blog single (related posts) and the Chapters archive.
- **Classes:** `.ea-blog-card`.
- **Inputs:** the current post in the loop — title, link, thumbnail, date. No `$args`.
- **Layout rules.** A card in the archive grid / the related-posts row; box model not measured.
- **Pages:** 53 — all 52 posts (as related cards) plus `/blog/` (the archive grid).
- **Variants:** same partial everywhere; not measured for layout drift.
- **Exceptions:** none found.
- **Orphan?** No. The pre-Chapters legacy archive template that also calls this file is not the live template — the Chapters archive is.

<a id="36-mokesh-video-embed--plain-iframe"></a>
### 36. Mokesh video embed — plain iframe

- **Renderer:** [`template-parts/chapters/parts/mokesh-video.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/mokesh-video.php), full file (its own comment says it is not reusable). Emits a `.figr` with a plain inline 16/9 iframe — no unique class.
- **Classes:** `.figr` (reused from the split type).
- **Inputs:** `yt_id`, `title` (the iframe's accessible name).
- **Layout rules.** A plain iframe, not a second YouTube API player (the hero already uses the API). Frame size not measured as its own node.
- **Pages:** wired only from `mokesh-defaults.php`, on `/eyal-amit/mokesh-dahiman/`.
- **Variants:** none — one page, by design.
- **Exceptions:** inline `max-width:760px; aspect-ratio:16/9` on the wrapper, in the part.
- **Orphan?** No. Bespoke.

<a id="37-blog--new-post-block-template-approved-not-built"></a>
### 37. Blog — New post (block template, approved, not built)

**Zero live instances. No dummy or demo post exists on the site.** This entry documents an
**approved decision, not a render** — team_00 approved the sketch on 2026-09-22, and this is
what a session must build toward, not what exists today. Do not present this as live anywhere
in the artifact without this qualifier attached.

- **Renderer:** not yet written. Planned per [`POST-TEMPLATE-SETTINGS.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007/POST-TEMPLATE-SETTINGS.md) §6: a JSON content file at `site/wp-content/themes/ea-eyalamit/inc/data/blog/{slug}.json`, read by a PHP renderer (also not yet written) that maps each row's `part` value to the **existing** files in `template-parts/chapters/parts/` — this type is a composite of already-documented types, not a new visual component, and the settings file is explicit that no new CSS class or `chapters.css` edit is permitted for a single post.
- **Classes:** none of its own. Reuses `.phero`/`.phero--media`, `.sec`/`.sec--alt`/`.sec--dark`, `.intro-body`, `.split2`/`.figr`, `.gallery`/`.gfig`, `.pfloat`, `.videoblk`, `.cta-band--row`, `.btn` — i.e., types 1, 4, 6, 7, 8, 11, 26 above, in whatever order the JSON's `rows[]` array specifies.
- **Inputs — the approved schema (`ea-post-v1`, from §7 of the settings file, verbatim):**
  - Post-level: `slug`, `title`, `category`, `date`, `author`.
  - `hero { chap, image, imageAlt }` — **empty `image` is the trigger for a logo hero, not a portrait** (same rule as the archive gap above, and the QR gap in type 33 — none of the three is built yet).
  - `media[]` — up to 8 items, `{ id, file, alt, cap, pending }`, `id` matching `^img-0[1-8]$`.
  - `video { youtube?, file?, poster?, cap? }` — at least one source.
  - `rows[]`, in display order — each `{ id, part, bg, title?, body?, center?, images?, float?, zoom?, cta_label?, cta_url? }`.
    - `part` ∈ `prose | split | gallery | photo-slot | cta | quote | video` — mapping to `parts/prose.php`, `parts/split.php`, `parts/gallery.php`, `parts/photo-slot.php`, `parts/cta.php`, `parts/testi-cards.php` (or a `<blockquote>` inside prose), `parts/videoblk.php` respectively.
    - `bg` ∈ `ivory | ivory-2 | dark | cta` — mapping to `.sec`, `.sec.sec--alt`, `.sec.sec--dark`, `.cta-band.cta-band--row` respectively. No fifth background without a new SSOT decision.
  - **team_00's own count, "fields 1–13," maps onto this schema as: the hero (1) + the eleven ordered rows `r01`–`r11` in the approved dummy (2–12) + the shared media pool (13).** This canon states that reading explicitly rather than inventing a different 13-item list — the settings file itself does not number fields 1–13 anywhere.
- **Layout rules — the locked alignment canon (§1 of the settings file, measured live on `/snoring-sleep-apnea/`, 2026-09-20):** `.wrap` is `max-width:1200px; padding-inline:48px` (not a narrow centered card, ~920px, as an earlier sketch draft tried); the H2 sits on the full `.wrap` width, `text-align:start`, wider than the body column beneath it (that offset is intentional, not a bug to fix); the reading column is 82ch centered inside the wrap (~212px each side at 1200px), never 65ch flush to an edge; a split row uses the two columns across the full wrap width, never a narrowed one-third text column; a small in-text image uses `float_image` so text wraps it, never a column that steals width for the whole story height; gallery and CTA rows run the full wrap width; the hero's `.phero__in` is 1200px, H1 up to 32ch, sub up to 54ch, `text-align:start` — never a centered card.
- **Pages:** zero. The dummy JSON (`DUMMY-WEEK-OF-BREATH.json`) and its matching sketch exist only as approved references, not as a published or even draft post.
- **Variants:** the `part` and `bg` vocabularies above are the only declared variants; nothing else is approved.
- **Exceptions:** none yet — there is nothing live to except. **Recorded on the [stage-A review list](#stage-a-review-list)** as the central "approved but not built" gap.
- **Orphan?** No — the opposite of an orphan: a decision with no renderer yet, rather than a renderer with no use.

---

## Tier 2 — elements inside the rows

<a id="eyebrow--chap"></a>
### Eyebrow — `chap`

- **Defined:** `chapters.css` lines 92–93. Emitted by almost every part when `chap` (or the matching field) is non-empty.
- **Inputs:** the string; `center`/a centered section adds `chap--c`.
- **Rules, measured:** small, medium weight, uppercase, letter-spacing 3px, terracotta. Default `text-align: start`. `chap--c` is centered (measured on the testimonials gallery and Mokesh headings). `/en/`: `text-align: left`.
- **Pages:** 113 have at least one `.chap` (includes the 48 QR children, whose literal eyebrow is `QR`). `/press/` and `/historical-articles/` use a different heading class entirely.
- **Variants:** the `--c` modifier and the LTR page.
- **Exceptions:** on a media hero, the eyebrow switches to the on-dark color token (line 460) — hero context, not a page-level override.
- **Orphan?** No.

<a id="heading"></a>
### Heading

- **Defined:** page hero H1 = `.phero__h` (line 421); home video hero H1 = `.hero__h` (line 187); section headings = `.h2`, usually with inline `margin-bottom: 18px` written by the part; CTA heading = `.cta-band__h`.
- **Inputs:** `title` on the part, or the post/page title for heroes reading the post.
- **Rules, measured:** hero H1 `text-align: start`, ~787px wide, on the dark scrim. Home H1 centered. Section H2 inherits start. CTA H2 is `text-align: right` inside the middle third.
- **Pages:** every one of the 136 has exactly one H1. CTA H2: on the 8 full bands plus the 2 heading-only book bands (10 total).
- **Variants:** uniform within each host row.
- **Exceptions:** the repeated inline `margin-bottom: 18px` lives in the parts, not per page.
- **Orphan?** No.

<a id="sub--lede"></a>
### Sub / lede

- **Defined:** hero sub `.phero__s` (line 432); hero lede `.phero__lede` (line 437, HTML, multi-paragraph — live on `/shop/`); section lede: class `.lead`; CTA body `.cta-band__p`.
- **Inputs:** `sub`, `lede`, or the part's `lead`/`body`.
- **Rules:** hero sub is lead-size, `max-width: 54ch`, on-dark color. `.lead` is usually centered on `chap--c` pages. The class `.lead` was directly token-confirmed on only 3 pages (`/historical-articles/`, `/lessons/`, `/treatment/`) — treat that as a floor, not proof other leads are absent (the census under-counts leads whose exact token wasn't stored). CTA body is right-aligned in the middle third, only present when `body` is non-empty.
- **Pages:** hero sub on every media hero that passes `sub` (all posts, via author/date). CTA body on the 10 bands whose `.cta-band__p` token was non-zero.
- **Variants:** uniform within the hero; the section lede is not one single measured rule across pages.
- **Exceptions:** none per page id.
- **Orphan?** `parts/lead.php` (a whole centered section) is an orphan; the `.lead` class itself is not.

<a id="body-prose"></a>
### Body prose

- **Defined:** `.intro-body` (line 603) inside a prose row, a split, a point-card lead, the QR shell, or `.ea-post-content` for posts.
- **Inputs:** `body` HTML for parts; `the_content` for QR/posts.
- **Rules, measured:** the Chapters column is 82ch, start-aligned, ~776px at 1440. Post body: same 776px, start-aligned, line-height 1.9 (`ea-blog.css`). Links stay terracotta.
- **Pages:** see the prose row, QR shell, and archive blog types.
- **Variants:** the Chapters column is uniform; post/QR bodies are uniform as containers, free as content.
- **Exceptions:** `/en/` is left-aligned (LTR page).
- **Orphan?** No.

<a id="buttons"></a>
### Buttons

- **Defined:** `.btn` at line 102. `--terra` (line 104, filled), `--gw` (line 106, outline light-on-dark), `--gd` (line 108, outline terracotta-on-ivory), `--sand` (line 1530, sand fill, chocolate text, pill radius).
- **Inputs:** whichever class the caller passes. CTA defaults to `--terra`, second button (unused) is always `--gw`. Hero CTA is always `--gw`. Photo-band is always `--sand`. Studio and the books bundle pass `--gw`.
- **Rules, measured:** a CTA button ~56px tall, centered in the left third. Sample widths: 152px («ליצירת קשר») to 225px (the books bundle). Padding `15px 36px`, `inline-flex`.
- **Pages:** `--terra`: 19 pages. `--gw`: 21 pages. `--gd`: 5 — `/`, `/eyal-amit/`, `/learning/`, `/learning/workshops/`, `/method/`. `--sand`: `/repair/` only (on the photo-band, not a CTA).
- **Variants:** each variant is uniform; which one a row uses is an input, except where a part hardcodes it (photo-band, hero, studio, start).
- **Exceptions:** the hardcoding above. `--sand` is live, but not inside a chocolate CTA as the 2026-09-23 canon claimed — that CTA variant does not exist on the site.
- **Orphan?** No.

<a id="logo-watermark"></a>
### Logo watermark

- **Defined:** `.cta-band__logo--side` in `cta.php`, painted with `ea-logo-mark.png`. CSS lines 863–871 (plus the absolute placement at line 727, overridden by the row rule). A separate `.arcs` motif is the unrelated ring watermark on heroes/studio/the magazine part.
- **Inputs:** none — present whenever the band is not `stack`, and `stack` is unused, so every live band has it.
- **Rules, measured:** in the right third, stretched to the track (~357×96 for a short text column, taller when text wraps — 231px tall on `/method/`). Opacity .26. At 390: a 140px box, centered, its own row. Decorative (`aria-hidden`).
- **Pages:** every CTA band (29 bands, 19 pages).
- **Variants:** uniform at 1.5.138.
- **Exceptions:** the removed page-73 padding rule (type 8) existed to keep this mark off the text; the three-column grid now does that job instead.
- **Orphan?** the old absolute `.cta-band__logo` rule (centered, 64% wide, line 726) is superseded by the `--side` override on every live band — nothing emits the logo without `--side` today.

<a id="scrim"></a>
### Scrim

- **Defined:** `.phero__sc` (416), `.hero__scrim` (179), `.bleed__sc` (297), `.photo-band__sc` (1571), `.start__sc` (312). One gradient family: darker toward the bottom.
- **Inputs:** none — present whenever the host row has a photo; absent on a text hero.
- **Rules, measured:** on a media hero and the home video hero, the scrim covers the whole hero box (1440×792 and 1440×900); does not change text alignment. Photo-band's desktop scrim is horizontal (heavier inline-start), vertical under the mobile breakpoint — that switch was not re-measured as a color, only as a stylesheet rule.
- **Pages:** `phero__sc` on the 74 media heroes; `hero__scrim` on `/`; `bleed__sc` on the 4 bleed pages; `photo-band__sc` on `/repair/`; `start__sc` on `/`.
- **Variants:** the heroes and bleed share one gradient; photo-band and start declare their own.
- **Exceptions:** none per page.
- **Orphan?** No.

<a id="pending-approval-badge"></a>
### Pending-approval badge

- **Defined:** CSS lines 1197–1233. Two hosts: a gallery item (`.gfig--pending`, corner badge) and [`pending-note.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/parts/pending-note.php) (a whole section — badge + required title + note). The video placeholder (type 27) and the CTA `temp_note` share the same visual family (`.ea-pending-approval`, `.ea-pending-inline`).
- **Inputs:** gallery item: `pending`, `pending_label`. Note part: `chap`, `title` (required — the part returns nothing without it), `note`, `id`, `alt`. CTA: `temp_note`. Placeholder: the `box` string.
- **Rules, measured:** on `/testimonials/`, the corner badge is 105×27, centered text. The section-level note was not isolated as its own box.
- **Pages:** `.ea-pending-approval` on 5 — `/learning/therapist-training/`, `/lessons/`, `/sound-healing/`, `/testimonials/`, `/treatment/` (the last three via the video placeholder; `/testimonials/` can be either the corner badge or the section note). `.ea-pending-inline`: `/books/` only (the CTA temp note).
- **Variants:** the badge's label string is fixed («ממתין לאישור»); the host (corner / section / under-CTA) is the variant.
- **Exceptions:** CTA's temp note has inline `margin-top:10px`; the gallery badge position is inline in `gallery.php`.
- **Orphan?** the part is wired from `media-defaults.php` (`/testimonials/`) — not an orphan, but easy to confuse with the gallery badge since they share a class.

<a id="image-and-caption"></a>
### Image and caption

- **Defined:** gallery: `<img>` + optional `.gfig__cap` overlay. Split/Mokesh portrait: `.figr` image, figcaption only on the Mokesh part. Bleed/heroes: the image is the background; the "caption" is a quote or title, not a figcaption. Book card: cover is the top of the whole link, no separate caption. Photo slot: no image at all, a label.
- **Inputs:** `image`/`media`/`cover`/`float_image`, plus `alt` or `cap`. `literal_alt` keeps an empty alt empty; otherwise `ea_chapters_content_img_alt` may replace it.
- **Rules, measured:** gallery image 4/3 cover; portrait gallery 3/4; split `figr--l` 5/4 cover (516×413 on `/method/`); `figr--p` 4/5; book cover 3/4; spotlight image 3/2. Caption overlay sits at the bottom of `.gfig`. Mokesh figcaption is left-aligned/LTR/small via an inline style local to `mokesh-portrait.php` only.
- **Pages:** wherever the host row is used (gallery 11, split 8, book cards 3, heroes 74 with a photo).
- **Variants:** uniform within each host; there is no single "image with caption" type across hosts.
- **Exceptions:** the Mokesh caption style; pending gallery items omit the image.
- **Orphan?** No.

---

<a id="orphans"></a>
## Orphans

Defined in the theme, present on **zero** of the 136 live pages (confirmed by class search on
the fetched HTML, not by filename — these load via `get_template_part`, which splits the name).

### `block-topnav.php`

[`template-parts/blocks/block-topnav.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-topnav.php) is called from [`inc/wave2-stage-b.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/wave2-stage-b.php), [`tpl-blog-archive.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-blog-archive.php), [`tpl-blog-single.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-blog-single.php), and [`tpl-qr.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/page-templates/tpl-qr.php). Chapters routing (`template_include`, priority 103/105) serves `tpl-chapters-*` instead. Live nav is [`section-nav.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-nav.php). `.ea-topnav` and `data-block="topnav"`: zero pages.

### Chapter parts with no live page

| File | Would have emitted | Why unused |
|---|---|---|
| `parts/mag.php` | `mag-spread` | Not referenced from any defaults part. |
| `parts/steps.php` | `show`/`shstep` | Not referenced. Home uses `.steps3` instead. `.flow-steps2` (CSS) is also unused. |
| `parts/lead.php` | a centered `chap`+H2+`lead` | Not referenced. |
| `parts/reveals.php` | `reveals`/`rcard` | Not referenced. Home uses `.whom`. `rcard` appears 36× inside one legacy post body — that is old content text, not this file. |
| `parts/product-cta.php` | `ea-product-price` | Not referenced. Shop and books use `bookcard`. |

**Unused modifiers on live parts:** `cta-band--stack`, `cta-band--choc`, `gallery--doc`, `pfloat--e`, `figr--w`, and the CTA second button (`cta-band__act-group`).

### Wave 2 blocks with no live page

`block-bio.php`, `block-books-row.php`, `block-breath-divider-1.php`, `block-contact-cta.php`,
`block-disclaimer.php`, `block-hero.php`, `block-intro.php`, `block-method-pillars.php`,
`block-service-comparison.php`, `block-services-row.php`, `block-testimonials-carousel.php`,
`block-testimonials-row.php`, `block-treatment-overview.php`.

`block-content-section.php` is **not** in this list — it is live on `/historical-articles/`
(four sections). `block-footer-social.php` is a thin call into the unified footer (the Chapters
footer, [`section-footer.php`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-footer.php), is on every Chapters page); not counted as a content row.
`block-faq-list.php`, `block-faq-mini.php`, and `block-blog-card.php` are live and documented above (types 21, 35).

### Rendered, but not a row-type

- **48 printed-code (`/qr/qrN/`) pages:** shell is type 33; the body inside it is free migrated HTML with no row-type. **Stays on the [stage-A review list](#stage-a-review-list).**
- **The blog's 52 posts are no longer in this section** — team_00 ruled they carry two named types (34, 37). See [where the map's original framing changed](#where-this-supersedes-the-2026-09-23-canon).
- **17 redirects** render nothing (they 301 before any template runs):

| From | To |
|---|---|
| `/about/moksha/` | `/eyal-amit/mokesh-dahiman/` |
| `/courses-soon/` | `/learning/courses-external/` |
| `/hashita/` | `/method/` |
| `/muzeh/` | `/books/` |
| `/muzeh/kushi-blantis/` | `/books/kushi-blantis/` |
| `/muzeh/tsva-bechol-ve-zorek-layam/` | `/books/tsva-bekahol/` |
| `/muzeh/vekatavt/` | `/books/vekatavta/` |
| `/muzza/` | `/books/` |
| `/muzza/tsva-bechol-ve-zorek-layam/` | `/books/tsva-bekahol/` |
| `/muzza/vekatavt/` | `/books/vekatavta/` |
| `/services/didgeridoo-lessons/` | `/lessons/` |
| `/services/didgeridoo-treatment-breath/` | `/treatment/` |
| `/services/handmade-instruments/` | `/didgeridoos/` |
| `/shows-heritage/` | `/` |
| `/tools-and-accessories/` | `/shop/` |
| `/tools-and-accessories/instruments/` | `/didgeridoos/` |
| `/tools-and-accessories/repair/` | `/repair/` |

---

<a id="stage-a-review-list"></a>
## Stage-A review list

**team_00's ruling (2026-09-26): this canon is the input to a reset round, not only a
description of what exists.** Stage A is him reviewing the canon and adding precisions; stage B
is a reset round bringing the site into line with the corrected canon; stage C is this list.
**No entry below recommends a fix or names a "correct" option — that is his decision in stage A,
not this canon's.** Each entry states what a viewer would see, gives a live URL, and names what
is needed from him: **a look**, **a decision**, or **a ruling on whether something becomes a
type of its own.**

### A. Significant deviations — a type exists, but pages depart from it visibly

The map found 8 of the 36 original row types are not uniform. All eight, with the technical
detail a stage-B session needs to act once he has ruled:

| Type | Pages that deviate | What a viewer would notice | File / selector | Measurement | Needs |
|---|---|---|---|---|---|
| Page hero (#1, `phero`) | `/repair/` (compact), `/contact/` (half), `/en/` (mirrored) vs. every other inner page with a photo | The opening photo band is visibly shorter on two pages than everywhere else, and the English page's hero text sits on the opposite side | `chapters.css` lines 526–545, 1524–1529; `phero--compact`/`phero--half` | 88vh (792px) standard vs. 78vh (702px) compact vs. 44vh (396px) half, all at 1440×900 | Decision: rule which heights are intentional variants and which (if any) should be unified |
| CTA band (#8, `cta-band`) | 17 of 29 bands are button-only (empty middle third); `/books/` uses an outline button instead of the filled default | The same banner sometimes shows a heading and a line of text beside the button, and sometimes shows only the button with empty space beside it; one page's button is hollow instead of solid | `parts/cta.php`; `chapters.css` lines 845–898 | 8 heading+body+button, 2 body-only, 2 heading-only, 17 button-only, out of 29 bands on 19 pages | Decision: rule which content shapes are acceptable going forward |
| Prose row (#4, `sec`+`intro-body`) | `/` and `/lessons/` (dark background); `/books/kushi-blantis/`, `/tsva-bekahol/`, `/vekatavta/` (collapsed with a "continue reading" toggle); `/en/` (mirrored) | The same block of running text sits on a plain cream background on most pages, on a dark band on two, and is cut short with a toggle on the three book pages | `parts/prose.php`; `chapters.css` line 603, 705–706 (fold) | dark/alt are declared `sec--dark`/`sec--alt`; fold uses `--fold-lines` | Decision: rule whether the fold and the dark background are content decisions per page or should follow a rule |
| Split (#6, `split2`) | `/repair/` (cover crop, no crop at all); `/eyal-amit/` and Mokesh (portrait crop); `/snoring-sleep-apnea/` (click-to-zoom) | The paired photo is sometimes a wide rectangle, sometimes a tall portrait, and sometimes fills the whole column edge-to-edge with no crop; on one page clicking it opens a larger version, which does not happen anywhere else | `parts/split.php`; `chapters.css` lines 482–487 | `figr--l` (5/4) vs. `figr--p` (4/5) vs. `split2--cover` (no crop); `zoom` live only on 1 page | Decision: rule which crop is default and whether zoom should exist elsewhere |
| Floated figure (#7, `pfloat`) | `/snoring-sleep-apnea/` (small, 146×26) vs. `/repair/` (standing, 295px) | A photo floating beside the reading text is small on one page and noticeably larger and more prominent on another | `parts/prose.php` (float_* args); `chapters.css` lines 1508–1514, 1531–1532 | 260px cap (default) vs. `min(320px,38%)` (standing) | Decision: rule whether both sizes should keep existing, or one should replace the other |
| FAQ (#21) | `/repair/` uses the cards look with the first question open; every other page with an FAQ list uses the plain bordered list | The same questions-and-answers block looks like a bordered list on most pages, but on one page looks like separate white cards with the first answer already showing | `block-faq-list.php`, `faq-inline.php`; `chapters.css` lines 669–680, 1563–1567 | `.ea-faq-list--cards`, max-width 760px vs. 820px list | Decision: rule whether the cards look should spread or stay unique to `/repair/` |
| Gallery (#11, `gallery`) | `/repair/` (four-column portrait grid) vs. every other gallery (three-column 4:3 grid) | The picture grid is the usual three wide photos on most pages, but four narrower tall portraits on one page | `parts/gallery.php`; `chapters.css` lines 1177–1194, 1575–1590 | 4:3 three-up (357px) vs. `--portraits` four-up (267px) | Decision: rule whether the portrait layout is a one-off or a real second option |
| Video block (#26, `videoblk`) | `/` (a real, playing video) vs. `/lessons/`, `/sound-healing/`, `/treatment/` (empty box, "pending approval" badge) | The video-shaped box actually plays a video on the homepage, but on three other pages it is an empty box with a waiting badge instead | `parts/videoblk.php` vs. `videoblk-placeholder.php` | 3 of 4 instances are the placeholder | Look: confirm whether real video content is still expected for these three, or the slots should be removed |

### B. Areas that fall under no type

| Area | What a viewer would notice | File / selector | Measurement | Live URL(s) | Needs |
|---|---|---|---|---|---|
| Printed-code (`/qr/qrN/`) page bodies — 48 pages | The shell (photo/logo band + one reading column) is consistent, but the text inside it is a straight migration from the old site with no internal structure — "a row of type A on this page" has nothing to attach to inside the body | `tpl-chapters-qr.php` lines 27–51; body is raw `the_content()` inside `.intro-body` | All 48 confirmed: `phero` + exactly one `.intro-body` + `.ea-qr` | http://eyalamit-co-il-2026.s887.upress.link/qr/qr1/ (representative; all 48 follow `/qr/qr1/` through `/qr/qr48/`) — hub: http://eyalamit-co-il-2026.s887.upress.link/qr/ | Ruling: whether the QR body should ever get a row-type of its own, or stay free content by design |
| Printed-code hero rule — approved, not built | The sketch calls for a unique photo when the page has one, and a logo mark when it does not; today every QR page shows the same plain generic opening regardless | `SKETCH-BLOG-QR.html` §3; current renderer has no logo-hero branch | 0 of 48 implement the approved rule today | http://eyalamit-co-il-2026.s887.upress.link/qr/qr1/ | Look: confirm the approved sketch is still what he wants before it is built |
| Blog "no featured image" hero — approved, not built | The locked policy calls for a logo mark when a post has no photo; today that one post shows the same plain text opening as any short page, with no logo | `phero.php` (no logo-mark branch exists); policy in `PHASE-2-BLOG-QR-AFTER-SKETCH.md` §2/§4 | 1 of 52 posts affected today | http://eyalamit-co-il-2026.s887.upress.link/[the 2012 Pardes Hanna studio post] (see `/blog/` for the current link) | Look: confirm the approved rule before it is built |
| Blog — New post type (#37) — approved, not built at all | Nothing to see yet: no dummy or demo post has ever been published | `POST-TEMPLATE-SETTINGS.md`; `DUMMY-WEEK-OF-BREATH.json`; `SKETCH-NEW-POST-DUMMY.html` | 0 live or draft instances | http://eyalamit-co-il-2026.s887.upress.link/blog/ (the archive — none of these posts use the new schema yet) | Look: confirm the approved sketch, dummy content and field schema are still current before Team 10 builds the renderer |

---

<a id="where-this-supersedes-the-2026-09-23-canon"></a>
## Where this supersedes the 2026-09-23 canon

Per the map, and confirmed here: where the earlier
[`S007-PATTERN-CANON-2026-09-23.md`](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/S007-PATTERN-CANON-2026-09-23.md)
disagrees with the measured map, **the map wins, and this file carries that resolution forward**
so nobody reconciles the two documents later by guessing:

- **Naming:** `whom-cards` → live class is `.whom` (type 13). `cmp-pair` → live class is `.cmp`
  (type 14). `portrait-trio` → this is the `.collage` inside `.about` (type 16), no such name
  exists in CSS. `deflist` → live class family is `.dd` (type 22). `split--doc` → this is the
  `zoom` boolean input on `split.php`, not a separate class (type 6). `ea-testi-cards` for the
  home testimonials → home renders the marquee (type 18); `ea-testi-cards` is the
  `/snoring-sleep-apnea/`-only type (20).
- **The compact hero was never the internal default.** Every other inner page with a photograph
  uses the 88vh media hero; `phero--compact` (78vh) is live on `/repair/` only.
- **`cta-band--choc` and `cta-band--stack` render nowhere.** The chocolate CTA the 2026-09-23
  canon described does not exist on the live site; `--choc` is marked retired in the CSS comment
  itself.
- **The `/testimonials/` (page id 73) CTA exception is gone.** The `body.page-id-73` padding
  override was present at the start of the map's read and is absent from the deployed 1.5.138
  stylesheet. `/testimonials/` now uses the same three-column grid as every other CTA band. Do
  not carry the old exception forward.
- **The blog was framed as "no type" going into this canon; it is not, as of team_00's ruling
  2026-09-26.** Two types exist: [#34 Archive](#34-blog--archive-post-existing-ea-post-content)
  (today's live shape) and [#37 New post](#37-blog--new-post-block-template-approved-not-built)
  (approved, unbuilt). The printed-code population (type 33's body content) remains untyped and
  is carried on the [stage-A review list](#stage-a-review-list).

**Date and version, restated: 2026-09-26, theme 1.5.138. Pairing rule, restated: this file and**
**[ea-content-types.html](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/EYAL-WORKSPACE/ea-content-types.html)**
**are edited together. A change to one without the other is a defect.**
