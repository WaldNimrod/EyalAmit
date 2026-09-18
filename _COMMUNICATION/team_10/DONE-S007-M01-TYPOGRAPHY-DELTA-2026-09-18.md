---
id: DONE_S007_M01_TYPOGRAPHY_DELTA_2026-09-18_v1.0.0
schema_version: aos_v1_team_messaging
type: DONE (team_10 → team_100)
from: team_10
to: team_100
cc: [team_00]
date: 2026-09-18
law: TASK-S007-RESPONSIVE-MOBILE-2026-09-18.md
mandate: MANDATE-S007-M01-TYPOGRAPHY-DELTA-2026-09-18.md
disposition: MAPPED AND REPORTED. Typography only. No corrective change made under this mandate.
---

# S007 M-01 · Typography delta — approved design vs. live site

Scope held to typography only, per team_00's same-day narrowing quoted in the mandate.
No file under `site/` was changed. No fix was made — fixes wait for the accessibility
milestone to close, per the mandate.

## Executive summary

1. **The menu-vs-body relationship is not a mockup/live disagreement — both sides already
   agree, and team_00 is asking to change what they agree on.** Nav top-level link measures
   **12.48px** in the mockup and **12.8px** live (Δ0.32px, both weight 300) — a match, not a
   drift. There is nothing to "fix toward the design" here; the design and the site both
   render the same small number. His two directions (menu bigger, body smaller) are a request
   for a new decision, which is exactly what Part 3 below proposes concretely.
2. **Two systemic, page-spanning deltas dwarf everything else: section headings and hero
   titles render bigger AND heavier than the design, on every page that has them.** Section
   heading is design **2rem/weight 200** everywhere; live is `clamp(1.8rem,3.1vw,2.6rem)`
   **/weight 600** everywhere (`chapters.css:73`) — at 1440px that is 32px→41.6px (+30%) and a
   jump from extra-light to semibold. Hero title is design **weight 100** (ultra-thin) on 8 of
   10 mockups; live is **weight 500** on both `.hero__h` (`chapters.css:148`) and `.phero__h`
   (`chapters.css:303`) — a difference in visual character at least as large as the size delta.
3. **One card role is a real outlier: book-card titles render 63% larger than designed**, flat
   across all three viewports (not a responsive-formula artifact) — `.bookcard__t`
   (`chapters.css:883`, 1.5rem/24px) vs. the mockup's `.ea-book-card__title` (0.92rem/14.72px,
   `Commerce - Books Archive (elevated).html:84`).
4. **Neither side has a type scale — confirmed — but two prior, orphaned attempts already
   exist in this codebase**, unknown to the mandate's own baseline: (a) an 8-token
   `--ea-size-*` scale in `style.css:104-112`, wired to 14 rules, all scoped under
   `body.ea-home-dashboard` — verified **absent from the live home page HTML** (0 matches),
   i.e. dead Wave2 code, not something a visitor ever sees; (b) a 5-token `--ea-type-*` scale
   inside the EN-Landing mockup's own `<style>` block (`EN - Landing (elevated).html:27-32`).
   Part 3 treats both as evidence, not as the answer — see below.
5. **One correction to the mandate's own given baseline, verified because it was cheap:**
   `style.css` *does* contain `font-size:var(...)` declarations (9 distinct custom
   properties, 14 use-sites) — the mandate's baseline ("not one `font-size:var(...)` anywhere
   in the theme") is accurate for `chapters.css` but not for `style.css`. Doesn't change the
   diagnosis (that code is dead — see #4) but the claim as stated was too broad.
6. **Tonight's own contact-page redesign (committed earlier this session, before this
   mandate existed) already matches the design's typography almost exactly** for the two
   roles it touched — see the ALREADY-CLOSED list. It's the one place on the site where
   design and live agree on both size and weight for a heading and a body role, and it
   happened by coincidence, not because anyone was targeting the mockup.

## Methodology

- **Tooling built for this mandate** (all under `tmp/qa/s007-typography/`, gitignored, no
  `site/` file touched): `measure_typography.mjs`, a zero-dependency CDP probe sibling to
  `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` — same chrome-headless-shell
  discovery, extended to read computed `font-size`/`font-weight`/`line-height` for a named
  list of {role, selector} pairs per page, and to measure **characters-per-line** by counting
  visual line-boxes via `Range.getClientRects()` (grouped by matching `top`) rather than
  estimating from average character width — this counts how the browser actually wrapped the
  real text, in either script. Works identically against `file://` mockup HTML and `https://`
  staging. Screenshots are clipped to a role's element bounding box (`Page.captureScreenshot`
  with `clip`), never full-page — the mandate's own 20,000px-tall trap.
- **Values are RENDERED**, read via `getComputedStyle` in a real headless-Chrome layout pass,
  not parsed from source `rem`/`clamp()` strings — per the mandate's explicit instruction,
  since the two differ by root size and viewport.
- **Cross-engine dispatch used** (`scripts/run_cross_engine_validator.sh`, default model
  `cursor-grok-4.6-high` per team_00's cost order, both read-only extraction tasks, no edits):
  one pass mapped every text role's selector + declared values across the 10 mobile mockups'
  own embedded `<style>` blocks (`tmp/qa/s007-typography/mockup-crosswalk-result.md`); a second
  mapped the same roles across the live theme's CSS (`tmp/qa/s007-typography/live-crosswalk-result.md`).
  Both are cited throughout by their own file:line citations. I spot-verified both against the
  live DOM myself and **caught one real error in the live-side dispatch**: it reported the
  contact-page form fields as `.ea-contact-form__*` (a real rule in `ea-atoms.css:1315-1325`,
  but for the *dead hand-rolled fallback form* in `contact.php`, not what renders). The live
  form is Contact Form 7's own markup (`.wpcf7-form-control.wpcf7-text` etc., confirmed via
  `curl` against the live page and re-measured directly — see the ALREADY-CLOSED list). This is
  exactly why the mandate wants a second engine and not a single trusted pass: the dispatch's
  static-code read was reasonable and well-cited, and still wrong about what a visitor gets,
  because a page can enqueue CSS for markup it no longer renders.
- **Page set:** all 10 mobile mockups (`_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/mockups/`,
  the 11th file, `Mobile UI.html`, is a phone-frame preview harness, not a page, and was
  excluded) against their live counterparts, **at 390 / 768 / 1440px** — 60 measurement passes,
  0 failures. Plus the two desktop-only clusters with no mobile mockup — **C** (`/contact/`,
  `/faq/`) and **D** (`/blog/` archive + one live post) — **at 1440px only**, 8 more passes.
  **Scoping decision, disclosed rather than silent:** clusters A/B/E/F's *desktop* mockup
  files (`WP-W2-10-{A,B,E,F}/elevation/mockup/*.html`) were not separately re-measured, because
  they cover the same pages already captured via the mobile-mockup set at 1440px; comparing
  the two mockup exports against each other was out of scope for the time available and would
  answer a design-consistency question, not a design-vs-live one.
- **Live page slugs used** (verified by fetching each, not assumed): home `/`; method
  `/method/`; treatment `/treatment/`; about `/eyal-amit/`; mokesh
  `/eyal-amit/mokesh-dahiman/`; books archive `/books/`; book detail
  `/books/tsva-bekahol/`; media `/testimonials/` (redirects from `/media/`); galleries
  `/galleries/`; EN `/en/`; contact `/contact/`; faq `/faq/`; blog archive `/blog/`; blog
  single, one live post fetched from the archive's own links.
- **Total raw font-size declarations counted directly** (comments stripped, rule blocks
  parsed, not a substring grep): **382** across every `assets/css/*.css` + `style.css`; **223**
  restricted to the three files Chapters pages actually enqueue (`chapters.css` 109,
  `ea-atoms.css` 93, `style.css` 21). The mandate's own baseline said 263 (242 + 21). I'm
  reporting my own count rather than correcting toward that number, per this project's
  standing measurement discipline — the gap is most likely counting method (rule-block parse
  vs. raw substring count handles multi-selector rules and `!important` duplicates
  differently), not a disagreement about which files matter.

## Part 1 — the delta, by page

Full per-page, per-viewport table (60 mobile-mockup passes across 10 roles-rich pages,
role-by-role, all three viewports): **[`full-delta-table.md`](tmp/qa/s007-typography/full-delta-table.md)**
(466 rows — kept as a separate file rather than inlined, so this report stays readable).
Desktop-only clusters (contact/faq/blog, 1440px): see the tables under **Desktop-only
clusters** further down.

### The two systemic deltas (present on every page that has the role)

**Section heading** — design is flat `2rem`/weight `200` on every mockup but one (Media/
Galleries use a smaller page-head variant, 1.6rem). Live is one rule,
`.h2{font-size:clamp(1.8rem,3.1vw,2.6rem);font-weight:600}` (`chapters.css:73`), used
site-wide. Measured at 1440px:

| Page | Mockup | Live | Δ |
|---|---|---|---|
| Home | 32px/200 | 41.6px/600 | +9.6px, +weight |
| Method | 32px/200 | 41.6px/600 | +9.6px, +weight |
| Treatment | 32px/200 | 41.6px/600 | +9.6px, +weight |
| About | 32px/200 | 41.6px/600 | +9.6px, +weight |
| Mokesh | 32px/200 | 41.6px/600 | +9.6px, +weight |
| Books archive | 32px/200 | 41.6px/600 | +9.6px, +weight |
| Book detail | 32px/200 | 41.6px/600 | +9.6px, +weight |
| EN | 32px/200 (token) | 41.6px/600 | +9.6px, +weight |
| Media | 25.6px/200 | 41.6px/600 | +16.0px, +weight |

At 390px the gap narrows (24px vs 28.8px, +4.8px) because live's `clamp()` compresses at
mobile widths and the mockups don't scale down at all for this role — but the weight gap
(200 vs 600) is constant at every width, because weight isn't part of live's `clamp()`.

**Hero/page title** — design is weight `100` on Home/Method/Treatment/Mokesh/Books/EN,
weight `200` on Book-Detail/Media/Galleries (the mockups disagree with each other on
weight — see mockup-crosswalk's own "inconsistencies" section). Live is weight `500` on
every page, no exception (`.hero__h` and `.phero__h`, both `chapters.css`). Size delta
direction flips by viewport because live uses `clamp()` and most individual mockup files do
not redeclare hero size at every breakpoint:

| Page | 390px Δ | 768px Δ | 1440px Δ |
|---|---|---|---|
| Home | +6.4px | −1.5px | +8.0px |
| Method | +8.0px | ~0px | +9.6px |
| Treatment | +6.4px | n/m | +9.6px |
| About | +8.0px | n/m | +9.6px |
| Mokesh | +4.8px | **−12.7px** | +9.6px |
| Books archive | n/m | **−12.7px** | +9.6px |
| Media/Galleries | n/m | −9.5px | +12.8px |

The −12.7px cells are the clearest illustration of why the mandate insisted on rendered
values: Mokesh's and Books-Archive's mockup files declare a flat `3rem` hero title with no
`768px`-range breakpoint override, while live's `clamp(2.2rem,4.6vw,3.6rem)` genuinely
shrinks below that flat value in the 640–1024px band before growing past it again at desktop.
Reading the source `rem` alone would have shown "48px vs. some smaller clamp value" as a
constant relationship; it is not constant — it crosses over twice.

### The one flat, non-responsive outlier

**Card title, Books Archive** — `.bookcard__t` (`chapters.css:883`, static `1.5rem`, weight
`300`) measures **24px** at all three viewports. The mockup's `.ea-book-card__title`
(`Commerce - Books Archive (elevated).html:84`, static `.92rem`, weight `400`) measures
**14.72px** at all three viewports. Both sides are non-responsive here, so this is a flat
+9.28px / +63% gap with no viewport story — the largest proportional delta measured in this
report for any role that exists on both sides.

### A reversed case (live smaller, not bigger)

**Testimonial quote, Home** — design `.ea-tcarousel__q` is `1.3rem`/weight `200` (20.8px);
live `.tmq__q` (`chapters.css:836`) is `1rem`/weight `400` (16px) — live is **smaller and
heavier** here, the opposite of the hero/heading pattern. Treat the exact characters-per-line
number for this role with caution — see Could Not Measure.

### Desktop-only clusters (C: contact/faq, D: blog — 1440px)

| Page | Role | Mockup | Live | Note |
|---|---|---|---|---|
| Contact | Page/hero title | 44.8px/200 | 57.6px/500 | same pattern as hero title elsewhere |
| Contact | Section heading | 32px/200 | **32px/200** | `.ea-contact-section__heading` — see ALREADY-CLOSED |
| Contact | Body | 16.8px/300 | **16.8px/300** | `.ea-contact-section__body` — see ALREADY-CLOSED |
| Contact | Form label | 12.48px/300 | **0px** | intentional — see SUPERSEDED |
| Contact | Form input | 14.4px/300 | 14.4px/300 | match |
| FAQ | Page/hero title | 44.8px/200 | 57.6px/500 | same pattern |
| FAQ | FAQ question | 16px/400 | 17.28px/500 | small delta, weight up one step |
| FAQ | FAQ answer | n/a (mockup FAQ page has no visible answer text measured — accordion closed by default) | 16px/300 | see Could Not Measure |
| Blog archive | Card title | 14.72px/400 | NOT FOUND | see Could Not Measure |
| Blog single | Section heading | 32px/200 | 41.6px/600 | same systemic pattern |

## Part 2 — characters per line

Measured by counting actual rendered line-boxes (`Range.getClientRects()`, grouped by `top`)
for the real page/post text, not estimated from average glyph width — this counts Unicode
characters (`String.length`); all sampled copy is Hebrew or English with no combining marks
or surrogate pairs, so this is a like-for-like character count in both languages, not a
grapheme or word count. 168 clean readings across the 10 mobile-mockup pages; **9 readings
were excluded as unreliable** (see Could Not Measure — testimonial carousel and one short
UI-label paragraph, both measurement-selector artifacts, not real findings).

Representative body-role readings at 390px (primary viewport):

| Page | Role | Mockup cpl | Live cpl |
|---|---|---|---|
| Home | Hero sub | 36 | 33 |
| Home | Body paragraph | n/a (role not present on this mockup) | 27 |
| Method | Body paragraph | 28 | 29 |
| Treatment | Body paragraph | 38 | 25 |
| About | Body paragraph | 34 | 31 |
| Mokesh | Body paragraph | 39 | 32 |
| Books archive | Body paragraph | n/a (see excluded) | 32 |
| Book detail | Body paragraph | 33 | 29 |
| EN | Body paragraph | 32 | 32 |

Live body text at 390px sits mostly in the **25–33 characters-per-line** band; the mockup's
own body copy (where measurable) sits in a similar **28–39** band — these are close, not a
wide gap, for Hebrew body prose specifically. The widest single Hebrew CPL gap measured is
**Treatment at 390px: mockup 38 vs. live 25** (live wraps noticeably tighter, consistent with
that page's own +5.12px body-size delta reported in Part 1 — a bigger font in the same
column width means fewer characters fit per line, which is the mechanical link between "body
too big" and "lines feel short/choppy" that team_00 is likely reacting to, more than an
absolute-size complaint on its own).

No English prose block of comparable length existed on any live page measured (the EN
landing page's own body-paragraph role reads Hebrew-adjacent test copy at 32/32 — matched —
but true English running text was not found on a page in this set; flagged under Could Not
Measure rather than assumed comparable to Hebrew CPL norms).

## Part 3 — a proposed type scale

Neither side has one — confirmed. But this project already tried twice and both attempts
were orphaned before anyone connected them to the live Chapters templates:

- `style.css:104-112` defines 8 tokens (`--ea-size-xs` 0.8rem through `--ea-size-hero-h1`
  `clamp(1.2rem,3.6vw,1.75rem)`) and 14 rules use them (`style.css:147` onward) — every one of
  those 14 rules is scoped under `body.ea-home-dashboard`, which **does not appear anywhere in
  the live home page's rendered HTML** (checked directly: 0 matches). Dead Wave2 code, not a
  live design decision.
- The EN-Landing mockup's own `<style>` block defines 5 tokens
  (`EN - Landing (elevated).html:27-32`: `--ea-type-body-sm` 0.78rem through `--ea-type-h1-hero`
  `3.4rem`) and is the *only one of the 10 mockup files* to use variables instead of repeating
  literals — none of the other 9 mockups reference these tokens, so even the design side never
  standardized on this attempt.

Neither prior attempt is proposed here as the answer — both predate this mandate's own
measurements and neither accounts for team_00's two stated directions. What follows is a new
proposal, grounded in what actually got measured.

### The proposed steps

7 static steps (assuming the common 16px root this project already uses) plus one guidance for
hero titles, which should keep the fluid `clamp()` mechanism already in use rather than move
to a flat step — hero is a display role, not a paragraph role, and `clamp()` is already the
right tool for it.

| Step | Value | Renders at | Roles mapped to it | Direction vs. today |
|---|---|---|---|---|
| `2xs` | 0.7rem | 11.2px | legal/copyright text, meta labels, captions | ~unchanged |
| `xs` | 0.75rem | 12px | footer text, CTA pill, EN toggle | ~unchanged |
| `sm` | 0.9rem | 14.4px | **nav top-level link** (up from 12.8px), form input/select, card blurb | **nav: bigger** ✅ |
| `base` | 1rem | 16px | **body paragraph** (down from 17.28–19.52px live today), FAQ question | **body: smaller** ✅ |
| `md` | 1.15rem | 18.4px | card title, section lead / intro paragraph | mixed: bigger for the undersized card-title outlier from Part 1, smaller for the currently-1.5rem book-card title |
| `lg` | 1.5rem | 24px | sub-heading (h3-tier: `.shstep__t`, `.rcard__t`, `.dd__t`, `.post__t` — 4 near-identical values today) | mild increase, consolidates 4→1 |
| `xl` | `clamp(1.6rem, 2.4vw, 2rem)` | 25.6–32px | section heading | **smaller than live's current 41.6px ceiling**, matches the mockup's own flat 2rem ceiling exactly |
| hero (fluid, unchanged mechanism) | keep per-role `clamp()`, e.g. `clamp(2.2rem,4.6vw,3.6rem)` | 35–58px | hero/page title | mechanism is already correct; **weight is the open question**, not size — see SHOW-FIRST |

### What collapses into what (core 223 declarations)

The proposal above absorbs the dominant clusters directly:

- **`0.78rem`/`0.8rem`/`0.82rem`/`0.85rem`** (nav, footer, CTA, filter — 4 near-identical
  values, ~35 occurrences combined) → split across `xs` (footer/CTA, unchanged) and `sm`
  (nav, deliberately raised)
- **`0.72rem`/`0.74rem`/`0.76rem`/`0.62rem`/`0.64rem`/`0.66rem`** (six near-identical small
  sizes, the mandate's own headline observation, ~25 occurrences) → **collapse to `2xs`**
  alone. This is the six-into-two-or-three the mandate anticipated; the measured data
  supports collapsing to *one* rather than two or three, since none of the six differ by
  more than 1.4px and no role among them (meta, caption, legal, section-label) needs visual
  separation from another in this group.
- **`0.9rem`/`0.92rem`/`0.95rem`/`0.98rem`** (form input, some card blurbs/titles, ~44
  occurrences) → **collapse to `sm`** for control-like text (inputs), **`md`** for
  reading-like text (card titles, blurbs) — these should NOT all collapse to one value, since
  a form control and a card headline are different roles wearing the same coincidental size
  today.
- **`1rem`/`1.05rem`/`1.06rem`/`1.08rem`/`1.15rem`** (body, lead, FAQ answer, testimonial —
  ~40 occurrences) → **collapse to `base`** (body/FAQ) or **`md`** (lead paragraphs, which
  are deliberately a step above body in most editorial systems and already read slightly
  larger in the mockups)
- **`1.16rem`/`1.14rem`/`1.2rem`** (`.shstep__t`, `.rcard__t`, `.dd__t`, `.post__t` — four
  near-identical h3-tier headings, ~9 occurrences) → **collapse to `lg`**
- **`2rem`** (13 occurrences, mostly section headings already at the design's intended value)
  → **becomes the ceiling of `xl`**, replacing live's `clamp(1.8rem,3.1vw,2.6rem)` ceiling of
  2.6rem/41.6px

### What does not fit — name these, don't force them

- **Hero titles and page-heads** — keep `clamp()`, per-role, not a flat step (already argued
  above).
- **`.ea-book-detail h1` (`ea-atoms.css`, `2.8rem`)** — a one-off large display heading for a
  single commerce template; forcing it into `xl` would shrink it by 12.5% for no stated
  reason. Flag as bespoke, revisit only if Eyal asks for consistency here specifically.
- **Decorative/iconographic sizing** — `.ea-faq-item summary::after` and similar
  pseudo-element glyphs sized via `font-size` are icons, not text roles; excluded from the
  scale entirely, same treatment the mandate gives to logos/icons in the parallel duplicate-
  image mandate.
- **`var(--ea-size-*)` (style.css, dead Wave2 code)** — not migrated into the new scale; the
  code itself is a separate, non-typography cleanup candidate (see Seen In Passing).

### Team_00's two directions as concrete numbers

- **"Menu too small"**: 12.8px → **14.4px** (`sm`), a +12.5% increase. This does not chase the
  mockup (which agrees with today's 12.8px) — it is a new answer to a question neither side
  had previously decided.
- **"Body too big"**: live ranges 17.28–19.52px across the measured pages/viewports (Part 1)
  → **16px** (`base`), a 7–18% reduction depending on which page's current value is the
  reference point. This lands close to — not identical to — the mockup's own body values
  (14.4–18.4px, itself inconsistent page-to-page per the mockup-crosswalk's "inconsistencies"
  section), which is why this is proposed as a new scale value grounded in the measurement,
  not as "match the design," since the design never had one settled number either.

## Classification

### FIX-NOW
*(design already decided it, cleanly, live doesn't do it, no judgement needed)*

- None found. Every delta with a clean single "correct" design answer either turned out to
  be something both sides already agree on (nav — see summary #1) or turned out to require a
  judgement call about weight/scale that the mandate itself default-classifies as SHOW-FIRST.
  This absence is itself worth reporting plainly rather than manufacturing a FIX-NOW item to
  fill the category.

### SHOW-FIRST
*(needs team_00's eye — any body/heading size change defaults here)*

1. **Section heading: size (32px→41.6px) and weight (200→600) site-wide.** The single
   biggest-reach typography delta measured (every content page). `chapters.css:73`.
2. **Hero/page title: weight (100/200 design → 500 live) site-wide**, independent of the size
   question, which the `clamp()` mechanism already handles reasonably. `chapters.css:148,303`.
3. **Body paragraph size — the concrete "make body smaller" decision.** Proposed landing
   value 16px (`base`), see Part 3. Needs Eyal/team_00's eye per the mandate's own default
   rule, even though the direction is already decided in principle.
4. **Nav top-level link size — the concrete "make menu bigger" decision.** Proposed landing
   value 14.4px (`sm`). Same default-SHOW-FIRST rule; also worth showing alongside the body
   change since the two move toward each other and the *relative* hierarchy (menu vs. body)
   is what will actually read as "fixed" or "not fixed" to a visitor.
5. **Book-card title (63% oversized, flat, `chapters.css:883`).** Large enough, and localized
   enough (one card component, reused on the books archive and possibly elsewhere), that it
   should be shown before touching, per the same-default rule, even though the direction
   (make smaller, toward `md`) is not really in dispute.
6. **EN toggle at 11.52px (`.nav__en`, `chapters.css:131`) — smallest text on the site and it
   is a control**, not decoration. Not previously flagged by the accessibility work (that work
   closed contrast/keyboard/`aria-expanded`/heading-structure, not control text size). Worth a
   look alongside the scale rollout since it would land in `2xs` today (unchanged) unless
   team_00 wants controls specifically excluded from the smallest step.

### BACK-TO-35
*(design has no answer, or its answer no longer fits)*

1. **Hero title weight disagrees mockup-to-mockup** (100 on 8 files, 200 on Book-Detail and
   Media/Galleries) — the design itself never settled this, so there is nothing for live to
   "match" until team_35's side has one answer. See mockup-crosswalk's own inconsistencies
   section for the full breakdown by file.
2. **Mobile-breakpoint coverage for hero title is inconsistent across the 10 mockup files** —
   Home has explicit `@media` overrides at both 1023px and 639px; Mokesh and Books-Archive
   have none, which is why their measured delta crosses sign between 768px and 1440px (Part
   1). Not a live-implementation bug — the design simply never specified a mobile hero size
   for those two templates.
3. **Card body-text sizing has three different values across three mockup files with no
   apparent rule for which gets which** (`.ea-service-tile__desc` 0.9rem, `.ea-book-card__teaser`
   0.78rem, `.ea-gal__d` 0.82rem — mockup-crosswalk's inconsistencies section). A scale
   collapses these into one value (`sm`), but which specific value is "correct" per-component
   is a design call, not a measurement.

### ALREADY-CLOSED
*(resolved already — name which, don't re-report)*

1. **Contact page section heading and body text already match the design almost exactly**
   (32px/200 and 16.8px/300 respectively, both sides) — resolved by tonight's own earlier,
   unrelated contact-page redesign (committed before this mandate existed), not by any
   accessibility work. Named here so it is not mistaken for a gap in the Part 1 table.
2. **200%-zoom nav clipping and text-over-image contrast** — the S007 research doc
   (`_COMMUNICATION/team_100/S006/RESEARCH-S007-RESPONSIVE-MOBILE-2026-09-18.md`, §1.4) already
   tracks these as open accessibility items (A11Y-LIVE-03, A11Y-LIVE-06), not typography;
   named here only to confirm this report did not duplicate them.

### SUPERSEDED
*(live is genuinely better than the design — a legitimate answer)*

1. **Contact form labels: mockup shows visible 12.48px labels; live renders them at
   `font-size:0`, intentionally.** This is not a gap — it is tonight's own earlier, explicit
   product decision ("לא צריך לכל שדה כותרת" — the field's placeholder already carries the
   label), implemented as `.ea-contact-form--cf7 .ea-cf7-row > label{font-size:0;line-height:0}`
   (`ea-atoms.css:1388-1391`), verified still screen-reader-visible via the label text
   remaining in the DOM ("שם מלא" etc.). The mockup was built before that decision existed.

## Could not measure

- **Testimonial-quote characters-per-line, home/method/treatment.** The matched `.tmq__q` /
  mockup-equivalent element measured 67–112px wide in the DOM at capture time (vs. an
  expected several-hundred-px card width) on both the live carousel and, unexpectedly, the
  static mockup — almost certainly a non-active carousel slide or a collapsed/transformed
  instance caught by `querySelector`'s first-match behavior, the same class of animation-state
  trap this project's own earlier carousel work this session already documented. Font-size
  and weight for this role are still trustworthy (those don't depend on element width); the
  characters-per-line figure for these three specific readings is not, and was excluded
  rather than reported as if measured. Re-measuring correctly would need the same
  "dispatch a real `mouseenter`, wait for the settle animation" approach used earlier this
  session for the home-page carousel, applied to each of the three pages — a small, specific,
  cheap follow-up task if this role's CPL matters for a decision.
- **One short mockup paragraph** (`Commerce - Books Archive (elevated).html`,
  `.ea-section--prose .ea-section__inner>p`, text "רכישה ישירה" / "Direct purchase") is a
  UI label, not flowing prose — excluded from the characters-per-line dataset for the same
  reason (11 characters is not a representative line).
- **English running prose, characters-per-line.** No live page in this set carries a real
  English paragraph of comparable length to the Hebrew body copy measured; the EN landing
  page's own "body" role text is short/parallel test copy. Cannot report an English CPL
  norm from this page set — would need a genuinely long-form English page, if one exists,
  to do this properly.
- **FAQ answer text on the FAQ mockup (`conversion-faq.html`).** The accordion pattern means
  answer text is not visible/measurable until expanded; this measurement pass did not
  interact with the accordion (an interaction task, not a static-read one). Font-size/weight
  for the *question* role was measured cleanly; the *answer* role was not attempted for this
  file specifically (it was measured successfully elsewhere, e.g. the live FAQ page, where
  at least one item defaults open).
- **Blog-archive card title, live.** `.ea-blog-card__title` was NOT FOUND against the live
  `/blog/` page with my configured selector list; the live crosswalk dispatch did not cover
  blog-specific classes (out of its original brief, which focused on the 10 mobile-mockup
  role set). This is a real gap in this report's own coverage, not a claim that the role
  doesn't exist live — the blog archive plainly renders card titles. Flagging as
  COULD NOT MEASURE rather than omitting it silently.
- **Full reconciliation of the 382-vs-263 total font-size-declaration count** — see
  Methodology. Reported both counts with method; did not chase an exact match.

## Seen in passing — not typography, not chased

- Three CSS files (`ea-mobile-nav.css`, `ea-mobile-variants.css`, plus the `.ea-mnav-*` /
  `.ea-topnav__lang` rules in `ea-atoms.css`) are dead Wave2 navigation code, independently
  reconfirmed during this mandate (their selectors match 0 live elements) — already known
  from the RTL audit and the S007 research doc; not re-litigated here, only reconfirmed in
  passing while building the live role crosswalk.
- The `style.css` `--ea-size-*` token block (Part 3) is dead code specifically because it is
  scoped to `.ea-home-dashboard`, a class absent from live markup — a pure-removal candidate
  once someone owns the standing Wave2 dead-code decision (per the RTL audit's own
  recommendation not to remove such code unilaterally).
- `books-v2.css`, `services.css`, `w2-05-shop.css`, `w2-14e-catalog.css`, `home-front.css`,
  `ea-blog.css`, and several smaller `w2-*.css` files (159 of the 382 total font-size
  declarations, none in the 223-core count) were not checked for live/dead status under this
  mandate — typography-scale work should probably wait for that determination, since a scale
  proposal has no reason to account for rules nobody's browser ever loads.
- Blog-single mockup's post-meta/tags/share-row typography (`.ea-post-meta`, `.ea-post-tags`,
  `.ea-post-share`) was not measured — outside the mandate's named 17 roles, and blog is a
  low-traffic template relative to the other 9 pages measured in full.

## Screenshots

All under `tmp/qa/s007-typography/`, sliced by section, never full-page:

- `results-mobile/screenshots/` — 72 files, one hero (+ cards/nav where applicable) crop per
  page × source × viewport, named `<page>__<mockup|live>__<viewport>__<section>.png`.
- `results-desktop/screenshots/` — 12 files, same convention, for contact/faq/blog.
- `compare/` — three purpose-built side-by-side crops for the roles team_00 will actually
  decide on, matched to real element width at native (2×) pixel resolution rather than a
  resized full-page shot:
  - [`home-hero-390-mockup-vs-live.png`](tmp/qa/s007-typography/compare/home-hero-390-mockup-vs-live.png) — hero title/weight, mobile
  - [`nav-links-1440-mockup-vs-live.png`](tmp/qa/s007-typography/compare/nav-links-1440-mockup-vs-live.png) — the "menu too small" question, desktop
  - [`body-text-1440-treatment-mockup-vs-live.png`](tmp/qa/s007-typography/compare/body-text-1440-treatment-mockup-vs-live.png) — the "body too big" question, largest measured delta (Treatment page)

Raw measurement data (all 68 targets, every role, every viewport, machine-readable):
`results-mobile/results.json`, `results-desktop/results.json`. Full per-page delta table:
`full-delta-table.md`.
