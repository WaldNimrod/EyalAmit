# VERIFY-EYEBROW-2026-09-26 — Independent second-opinion measurement

**Scope:** `.chap` eyebrow label (white, ~11px, weight 500 → threshold 4.5:1) inside the hero
(`header.phero`) across the whole live published population of theme **1.5.141**.
**Method:** independent second measurement, built from scratch, from the live site, without
reading the builder's report. Real rendered browser (chrome-headless-shell), painted pixels,
not CSS lookups.

## VERDICT

**No — not every measured instance clears 4.5:1.** Of 222 (page × viewport) measurements across
111 pages that render the `.chap` eyebrow, **220 pass and 2 fail**, both **mobile-only (390px)**,
both on the same **desktop-passes / mobile-fails** pattern: a long chapter title that wraps the
eyebrow pill to two lines at 390px width, landing part of the pill over a brighter region of that
post's photo. All 111 pages pass at 1440px.

**Failing pages (mobile, 390px):**

| Page | Worst ratio | Threshold | Ground |
|---|---|---|---|
| `/עכשיו-מופע-הסיפורים-של-אייל-עמית-תופע/` | **3.77** | 4.5 | photo, 2-line eyebrow pill |
| `/שני-תאריכים-קרובים-למופע-הסיפורים-של-א/` | **4.11** | 4.5 | photo, 2-line eyebrow pill |

Two further pages in the same family pass but narrowly (5.08, 5.43) — see "Systemic pattern"
below. Every other page in the 111-page population, at both viewports, clears 4.5:1 comfortably
(median ratio across all 222 measurements: **12.1:1**).

## Theme version confirmed

`?ver=1.5.141` on every enqueued stylesheet, on every page fetched, including all contested pages.
No stale-cache mixed-version pages found.

## Population enumeration (not a sample — a census of the .chap-bearing pages)

Enumerated via `wp-json/wp/v2/pages` + `/posts`, `per_page=100&status=publish`, paged to
exhaustion, ≤3 concurrent requests, retry-on-502:

- **153** published objects (101 pages + 52 posts)
- **136** resolve to HTTP 200 at their own `link`
- **17** redirect (3xx)

This matches Team 90's stated population exactly (153 / 136 / 17).

Of the 136 live pages, **133** render a `header.phero` hero at all; **22** of those 133 have a
hero with no `.chap` eyebrow span (e.g. `/eyal-amit/`, `/books/`, `/shop/`, `/thank-you/`,
`/method/`, `/faq/`, `/treatment/`, `/lessons/`, `/lectures/`, `/workshops/`, `/galleries/`,
`/testimonials/`, and 10 more — spot-checked several, confirmed genuine: these hero pages simply
carry no chapter label, not a scraping miss). **That leaves 111 pages that actually paint the
`.chap` element** — 60 with a photo hero (`phero--media`, dark pill backing), 51 with a flat
gradient hero (no pill).

**This is 2 fewer than Team 90's stated 113/136.** I could not reproduce 113 from the live site;
111 is what actually renders the element today. Worth reconciling, but it does not change the
verdict — I measured all 111.

**`/press/` does not use this component at all.** It runs the *editorial* template family
(`.ea-edhero` / `.ea-edhero__kicker`, body class `ea-nd-orphan ea-press ea-editorial…`), not the
`chapters`/`phero`/`.chap` family — consistent with the known Wave2/Chapters dual-template split
in this repo's project memory. I measured its kicker anyway for due diligence (see below); it is
a different component, different CSS, different weight (300, not 500), and is out of scope for
"the `.chap` eyebrow."

## Method — every rule from the brief, and why

- **Real rendered browser:** chrome-headless-shell at the pinned cache path, driven via
  puppeteer-core (already vendored under `scripts/qa/node_modules`, not installed by me), reusing
  the Chrome-discovery logic style of `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs`
  (read only, not modified). 3 concurrent pages, retry on 502 (none encountered in this run).
- **Settle:** `networkidle2` nav wait, `document.fonts.ready`, two nested `requestAnimationFrame`s,
  cookie dialog dismissed (`dialog#ea-cookie-notice.close()` + remove, clear `[inert]`), then a
  second settle pass.
- **Glyph rects, not the block box:** `Range.getClientRects()` over the `.chap` text node(s) —
  1 rect on 220/222 measurements, 2 rects (line-wrap) on the 4 flagged pages.
- **Painted-pixel background recovery:** screenshot → PIL decode → sample. For each glyph rect, a
  ring is built (padded by the text-shadow's own reach: `0 1px 3px rgba(0,0,0,.85)` → 4px), then
  **clipped to the element's own painted box** (`chap.getBoundingClientRect()`), never past it.
- **Ink-vs-background separation:** pixels within the tight glyph rect close to the element's
  declared solid color (`rgb(255,255,255)`, opacity 1) are the "ink core" → median gives the
  as-painted foreground. Ring pixels far from that ink color are background candidates; the
  computed white (as painted, e.g. `rgb(244,244,244)` — never pure 255 at 11px) is composited with
  its declared alpha (here always 1, so no-op) over every background sample, and WCAG contrast is
  computed per sample. **Worst (lowest) ratio across all samples is the page's number.**
- **`elementFromPoint` topmost check** at every glyph-rect center on all 222 measurements: 100%
  confirmed `.chap` (or a descendant) is the topmost painted element — no cookie-dialog or other
  occlusion anywhere.
- **Gentle:** 3 concurrent max, no 502s encountered, so no retries were needed in practice.

### A correction I had to make on myself, mid-run — and why it matters for the disagreement question

My first pass clipped the background ring to the element's raw bounding box on all sides. On
`/sound-healing/` this produced **4.17 (desktop) / 4.46 (mobile)** — both apparent failures. Before
trusting that, I cropped and visually inspected the sampled pixels: the "worst" pixel in both cases
sat in the **rounded end of the pill** (`border-radius:100px` on a ~23px-tall box renders as a full
stadium — the left/right ends are semicircular, radius = height/2). A rectangular bounding-box clip
samples pixels in that curved zone that are **not actually inside the visible pill** — they're the
anti-aliased blend between the pill's curved edge and the raw photo behind it, several pixels away
from any glyph. That is not what a reader sees behind the text; it's an artifact of clipping a
curved shape with a rectangle.

I fixed this by insetting the clip box by the pill's own corner radius (`height/2 + 1px`) on the
left/right, and by 1.5px on the flat top/bottom edges (to shave the same anti-aliasing on those
sides). Re-run: `/sound-healing/` → **9.00 (desktop) / 8.37 (mobile)**, both comfortably passing.
I verified this wasn't over-correction by checking the genuine failures below still reproduce with
the same corrected method — they do, with the brightest background pixel landing squarely inside
the pill body (confirmed by crop), not at an edge.

## Systemic pattern behind the 2 failures

Both failing pages — and 2 more that pass narrowly — belong to the same family: long
"מופע הסיפורים" (storytelling show) blog-post chapter titles. On mobile (390px) the eyebrow pill
text wraps to **2 lines** (`sample_count` jumps to ~3400 vs. ~250–1300 for single-line pills). The
4 pages with this 2-line-wrap signature are the **4 lowest ratios in the entire 222-measurement
set**:

| Page (mobile) | Worst ratio |
|---|---|
| `עכשיו-מופע-הסיפורים-של-אייל-עמית-תופע` | 3.77 (FAIL) |
| `שני-תאריכים-קרובים-למופע-הסיפורים-של-א` | 4.11 (FAIL) |
| `אייל-עמית-תופעת-יחיד-מופע-סיפורים-spoken-stories-15` | 5.08 (pass, narrow) |
| `סרטים-מהחיים-מופע-הסיפורים-של-אייל-עמי` | 5.43 (pass, narrow) |

Visually confirmed both failures: one has a bright warm skin-tone close-up photo behind the second
line of the pill; the other has a **bright yellow event-poster graphic** bleeding through the
semi-transparent pill on the right side, exactly where the second line sits. This is the same
failure mode the brief flagged for `/press/` ("a photograph reportedly contains a near-white
graphic") — except it's real here, on these two posts, not on `/press/` (which uses a different,
solid dark panel background, not a photo, behind its kicker). **All 4 pass at 1440px** — the
eyebrow stays on one line at that width, over a different (safer) part of each photo's responsive
crop.

## Contested pages — final numbers

| Page | 1440px | 390px | Sample n (1440/390) | Ground |
|---|---|---|---|---|
| `/sound-healing/` | 9.00 | 8.37 | 712 / 712 | photo |
| `/learning/therapist-training/` | 9.99 | 9.10 | 376 / 376 | photo |
| `/contact/` | 9.47 | 6.80 | 456 / 513 | photo |
| `/learning/` | 12.92 | 10.34 | 768 / 768 | photo |
| `/qr/qr1/` | 15.56 | 12.09 | 246 / 246 | flat |
| `/qr/qr24/` | 15.56 | 12.66 | 246 / 246 | flat |
| `/press/` (`.ea-edhero__kicker`, **not** `.chap`) | 7.52 | 7.52 | 421 / 540 | photo, solid dark panel — no near-white graphic found at the kicker's own location |

Font: `11.05px` / weight `500` on every `.chap` instance (matches `--fs-3xs` = 0.690625rem ×
17px body anchor). Threshold applied: 4.5:1 throughout (small text, weight 500 is not "bold" for
the WCAG large-text exception).

## The question behind the question: why has `/sound-healing/` produced four different numbers before mine?

**My number: 9.00:1 at 1440px, 8.37:1 at 390px**, from 712 painted-pixel background samples per
viewport (method above), both comfortably passing.

Given what I found *on myself* mid-session (see correction above — my own first pass on this exact
page gave 4.17–4.46, a number that sits right where the historical "3.80" and "4.96" readings
cluster), I believe the most likely explanation for the four disagreeing numbers (1.38, 4.52, 3.80,
4.96) is a combination of:

1. **Pipeline timing relative to the fix.** The commit history on this repo shows the pill backing
   landed in stages: white-text unification, then a shadow-alpha strengthening (0.70→0.85), then
   the dark pill backing added last, specifically because "one page's baked-in near-white panel
   outran what a shadow alone could do." A reading of **1.38** is very plausibly from *before* any
   of that shipped — raw white text straight on a bright photo, shadow only or not even that.
   **3.80–4.52** plausibly land in the shadow-only-no-pill window, or on a CSS-declared-color
   lookup that can't see a photo background at all and falls back to a flat token.
2. **Box-edge vs. shape-aware sampling — the one I caught myself doing.** A pill drawn with
   `border-radius:100px` is a stadium, not a rectangle. Any measurement that samples "the
   background near the text" using the element's rectangular bounding box (CSS `getBoundingClientRect`
   is a rectangle even though the paint isn't) will pull in anti-aliased curved-edge pixels that
   blend fill with raw photo — consistently pulling the ratio down toward ~4–5, which is exactly
   where three of the four historical numbers (3.80, 4.52, 4.96) sit. This is not a hypothesis I'm
   guessing at — I reproduced it on this exact page in this exact session before correcting it.
3. **Viewport / responsive-image crop.** The photo behind the eyebrow is not identically cropped
   at every width (confirmed elsewhere in this run: the 2-line-wrap failures pass at 1440px and
   fail at 390px purely because a different, brighter region of the same photo ends up behind the
   text at the narrower width). A measurement taken at an unstated or inconsistent viewport would
   land on a different patch of the same photo and get a different number for reasons that have
   nothing to do with the CSS.

I don't think this page can be fully reconciled to a single number without knowing exactly which
method and viewport produced each of the four prior readings — but "rectangular clip vs. the
pill's actual stadium shape" is, on the evidence I collected today, a real and sufficient source of
a >4-point swing on this exact page, and should be the first thing checked in any future
re-measurement before assuming the CSS regressed.

## Sanity checks passed

- 100% `elementFromPoint` topmost-match across all 222 `.chap` measurements — no occlusion.
- Only 1 of 222 records needed the ink-detection threshold relaxed (20→35); every other record's
  "ink core" was found on the first, strictest pass.
- No 502s encountered; no retries needed.
