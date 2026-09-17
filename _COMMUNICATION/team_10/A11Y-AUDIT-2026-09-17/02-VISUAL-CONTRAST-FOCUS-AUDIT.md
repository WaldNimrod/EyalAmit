# A11Y-VISUAL — Colour, Contrast, Focus Visibility, Text Sizing & Reflow

Mandate: team_10 audit line, A11Y-VISUAL prefix. Standard: **IS 5568 level AA = WCAG 2.0 level AA**
(binding). Any 2.1/2.2-only criterion cited below is explicitly labelled "beyond the binding
standard — recommendation only." This is **not legal advice**.

Auditor engine: Claude (Sonnet). Date: 2026-09-17. Staging measured:
`http://eyalamit-co-il-2026.s887.upress.link` (TLS invalid by design on staging — not a defect).
Production `https://www.eyalamit.co.il/` was **not** audited except for one accidental redirect
noted explicitly in §4 and discarded.

---

## 1. Scope and what was actually run

**Static analysis** (primary tool, per method notes) — full read of every file in
`site/wp-content/themes/ea-eyalamit/assets/css/` (14 files, 9,704 lines) plus `style.css`
(451 lines) and `functions.php`'s inline `<style>` generators. Cross-referenced two JS files
(`assets/js/ea-testi-mq.js`, and the reduced-motion contract in `ea-animations.css`) where the
CSS alone could not explain an observed class toggle — flagged inline where I stepped outside
the nominal CSS-only scope.

**Contrast maths** — a Python script implementing the WCAG relative-luminance/contrast formula
exactly (sRGB → linear → luminance; `(L1+0.05)/(L2+0.05)`), with alpha-compositing for every
`rgba()` color against its real declared backdrop. Script + full pair list:
`/private/tmp/claude-501/-Users-nimrod-Documents-AOS-V5-EyalAmit-co-il-2026/5ae45105-ea60-41c0-a0a1-15918f2e481d/scratchpad/contrast.py`
and `pairs.py` (not part of the product repo; scratch only). **Every ratio below is this
script's output**, not an eyeball estimate.

**Live verification** — Chrome via the Browser pane, against staging only, viewport confirmed
non-zero (1024×768) before trusting any measurement (per the brief's known-trap list). Pages
visited and their live `body` class (to settle "which template system is actually live" —
this codebase runs several parallel systems and file presence alone does not prove liveness):

| URL | body class (key parts) | confirms |
|---|---|---|
| `/` | `page-template-tpl-home ... ea-wave2-shell ea-m4-polish ea-chapters` | homepage is Chapters-rendered, **not** `ea-home-dashboard` |
| `/treatment/`, `/method/` | `...ea-chapters` / `page-template-tpl-service ...ea-chapters` | both Chapters-rendered |
| `/accessibility/`, `/privacy/` | `page-template-default page ...ea-chapters` | plain WP pages, Chapters CSS still loaded |
| `/faq/` | `page-template-tpl-faq ...ea-chapters` | |
| `/en/` | `...ea-lang-en ltr ea-m4-polish ea-en-landing ea-chapters`, `html lang="en" dir="ltr"` | |
| `/books/`, `/blog/` | `...ea-chapters` / `...ea-blog-archive-view` | |

Techniques used live: `document.body.className`; `getComputedStyle()` on real elements;
enumerating `document.styleSheets` / `CSSRule` to see **which rule actually wins the cascade**
(not just which rules exist in the repo); real keyboard `Tab` key-presses via the OS-level
`computer` tool (not `element.focus()` — see the false-positive I caught myself making in §4);
`element.matches(':focus-visible')` to confirm the browser actually granted focus-visible
before trusting a computed style.

---

## 2. Findings

Severity scale: **CRITICAL** (breaks a core AT/keyboard path, sitewide or on the primary
statement) · **HIGH** · **MEDIUM** · **LOW**. "Live-confirmed" = measured in a real browser on
staging; "static" = measured from the CSS text; "inferred" = a reasoned risk I could not
render-test within this session.

### A11Y-VISUAL-01 — CRITICAL — Skip-to-content link loses required contrast the instant it becomes visible

- **WCAG 2.0 SC 1.4.3 Contrast (Minimum), Level AA.**
- **Measured, live.** The site's real skip link is `.ea-skiplink`
  (`assets/css/ea-atoms.css:74-85`): `background: var(--ea-terracotta); color: #fff;` — by
  itself **5.67:1**, a clean PASS. But `.ea-skiplink:focus, .ea-skiplink:focus-visible`
  (`ea-atoms.css:88-95`) only sets `position/top/right/z-index/transition` — it never
  re-asserts `color`. Meanwhile GeneratePress (the parent theme) emits its own **dynamic,
  inline** stylesheet (`<style id="generate-style-inline-css">`, generated at runtime by the
  parent theme's PHP — not a file in this repo, confirmed by reading
  `document.styleSheets` live) containing:
  ```
  a { color: var(--accent); }
  a:hover, a:focus, a:active { color: var(--contrast); }
  ```
  `a:focus` has specificity **(0,1,1)**; `.ea-skiplink` has specificity **(0,1,0)**. (0,1,1)
  beats (0,1,0), so GeneratePress's rule wins the instant the link is focused — regardless of
  source order, because it is strictly more specific. `--contrast` resolves to `#2E2B28` via
  the child theme's own override (`functions.php:146-164`, specifically
  `functions.php:158: '--contrast:var(--eyal-ink);'` — a real fix for a *different* bug,
  "prevent leakage of GP's default `--accent:#1e73be`", per its own Hebrew doc-comment; it did
  not anticipate this side effect).
  Reproduced twice, live, on `/accessibility/`: a **real keyboard `Tab` keypress** (not
  `element.focus()` — see §4 for why that distinction mattered) landed on the skip link with
  `document.activeElement` confirmed and `el.matches(':focus-visible') === true`, then
  `getComputedStyle` read `color: rgb(46, 43, 40)` (`#2E2B28`) against
  `background: rgb(164, 78, 43)` (`#A44E2B`).
  **Computed: 2.48:1** — needs 4.5:1 (normal text, 14.4px/400). **FAILS**, and badly — a
  keyboard or screen-reader user who presses Tab on page load, the very first and most
  important accessibility affordance on the site renders at roughly half the required contrast.
- **User impact:** a sighted keyboard user tabbing in sees a dim, hard-to-read pill where the
  design intended a crisp white-on-terracotta one. This is not a corner case — it is the
  literal first Tab stop on every page.

### A11Y-VISUAL-02 — CRITICAL — The same mechanism makes the main-nav "EN" toggle (and structurally similar links) nearly invisible on keyboard focus, sitewide

- **WCAG 2.0 SC 1.4.3, Level AA.**
- **Measured, live**, same root cause as -01. `.nav__en` (`assets/css/chapters.css:102`):
  `color: rgba(255,255,255,.85)` — a bare single-class selector, specificity (0,1,0), with
  only an `:hover` companion (`chapters.css:103: .nav__en:hover{border-color:#fff;color:#fff}`
  — hover-only, does not match plain keyboard `:focus`). On the homepage, I focused the element
  immediately before it in tab order via script, then sent **one real keyboard `Tab`**
  (confirmed `document.activeElement.className === 'nav__en'` and
  `matches(':focus-visible') === true`), and read `getComputedStyle(el).color = rgb(46, 43, 40)`
  — the same GeneratePress override, same reason: (0,1,1) beats (0,1,0).
  The "EN" pill sits on the main nav's dark backdrop (`.nav` gradient, top stop
  `rgba(14,9,5,.82)` at rest per `chapters.css:690`, or `rgba(20,14,9,.95)` once scrolled per
  `chapters.css:90`). Computing ink `#2E2B28` against that backdrop across every bound I can
  construct (bright photo behind it, black behind it, scrolled-solid state, or the flat
  `--dark` token `#0E0905`) gives **1.16–1.41:1** in every case — for comparison, the *worst*
  the design ever risks elsewhere in this audit is around 2:1. This is close to true invisibility.
- **Why this one link and not others nearby:** I checked `.nav__l a` (`chapters.css:95`,
  main menu links) and `.nav__dd` (`chapters.css:492`, dropdown toggles) the same way — both
  are, by luck rather than design, *also* matched by the descendant selector `.nav__l a`
  (specificity (0,1,1), tying GeneratePress's rule and winning because the child theme's
  stylesheet loads later in the `<head>`). Live-confirmed on the homepage: a real-Tab-focused
  `.nav__dd` kept its intended `rgba(255,255,255,.82)`. `.nav__en` has no such protecting
  ancestor selector — it is a standalone pill, styled only by its own single class — so it
  falls through. The exact, mechanically checkable rule for "is this `<a>` at risk": *its
  colour is declared on a bare single class (specificity exactly 0,1,0), and neither that
  class's own `:hover`/`:focus`/`:active` variant nor any wrapping descendant selector
  re-asserts a colour at specificity (0,1,1) or higher.* I did not have budget to run this
  check against every `<a>`-targeting colour rule in the 9,704-line stylesheet set by hand;
  I recommend team_100 script exactly this check (§5) rather than trust a second manual pass.
  One further instance I *did* check and can report as low-impact: `.tlink`
  (`chapters.css:484`, an inline content link, "cbDIDG" on `/treatment/`) has the same
  structural gap, but because it sits on the light `--ivory` background, the same override
  (ink `#2E2B28` on `#FFFFFA`) is still high-contrast (≈13:1) — a colour inconsistency, not a
  contrast failure. Severity is entirely a function of *what backdrop* the affected link sits on.
- **User impact:** any keyboard-only or switch-access visitor tabbing through the header on
  *every single page* loses legibility of the language toggle at the exact moment they've
  reached it. This is a sitewide, every-page defect, not confined to one template.

### A11Y-VISUAL-03 — HIGH — `--eyal-muted` is referenced but never defined; every use silently renders the exact colour the design system says it replaced for failing AA

- **WCAG 2.0 SC 1.4.3, Level AA. Static, cross-checked by exhaustive grep (measured on source).**
- `assets/css/ea-tokens.css:24`: `--ea-muted: #6F635A; /* Visible muted text. Updated
  2026-05-27 from #A8A19B for AA contrast. */` — i.e. `#A8A19B` is a known-bad colour the team
  already fixed once.
- `assets/css/books-v2.css` uses a **different, unrelated** variable, `--eyal-muted`, four
  times: `books-v2.css:462`, `:839`, `:875-879`, `:883-889` — always as
  `var( --eyal-muted, #a8a19b )`. I grepped the entire repository (`*.css`, `*.php`) for a
  definition of `--eyal-muted` and found **none** — only `--eyal-sand/-terracotta/-earth/
  -olive/-ink/-chocolate/-brick/-accent-rgb` are ever defined (`functions.php:146-161`).
  Because the custom property is undefined, every one of these four `var()` calls resolves to
  its literal fallback, `#a8a19b` — **the exact value ea-tokens.css's own comment says was
  replaced for AA contrast.** This is not a stylistic near-miss; it is the old, already-
  rejected colour, reintroduced through an unrelated variable name that nobody defined.
- Computed (against the two backgrounds these rules actually sit on,
  `books-v2.css:376` `#faf8f5` and `:399/:853` `#f3eee8`):
  - `.ea-section-label` (9.3px/200) on `#faf8f5`: **2.41:1**. FAILS (need 4.5).
  - `.ea-book-gallery-placeholder__label` (9.3px/200) on `#f3eee8`: **2.21:1**. FAILS.
  - `.ea-book-gallery-placeholder__text` (11.5px/300) on `#f3eee8`: **2.21:1**. FAILS.
  - `.ea-book-gallery-placeholder__note` (9.9px/200, **plus an additional `opacity:.7`
    stacked on top**, `books-v2.css:888`) on `#f3eee8`: **1.70:1**. FAILS badly.
  - For reference, had the intended `--ea-muted` (#6F635A) actually been wired up: 5.49:1, a
    clean pass. The fix is one variable name, not a colour decision.
- **Liveness:** `books-v2.css` is enqueued sitewide (`functions.php:695-699`, unconditional).
  I could **not** confirm these four specific selectors render on a live page within budget —
  `/books/` (the hub) does not use them (it renders `.bookcard`/`.bookcards` from
  `chapters.css` instead — see -13 below on the dual-template problem), and the one book
  **detail** page I tried, `/books/tsva-bekahol/`, redirected to the **old production domain**
  mid-navigation (caught and discarded — see §4). I did not find a safe staging book-detail URL
  in the remaining budget. Reported here as a real, computed defect in live-enqueued CSS whose
  exact on-page presence is unconfirmed — see the COULD NOT MEASURE list.

### A11Y-VISUAL-04 — HIGH — chapters.css's own `--muted` token fails AA against both of its standard backgrounds, including a disclaimer

- **WCAG 2.0 SC 1.4.3, Level AA. Static (source), chapters.css confirmed live sitewide.**
- `chapters.css:16`: `--muted:#8C775F;` — a **third**, separate "muted text" colour (see -13),
  used as `color:var(--muted)` in exactly four places (`chapters.css:286` `.cap` — image
  captions, `:306` `.feat__meta`, `:319` `.post__meta`, `:464` `.disc__t` — a disclaimer
  paragraph inside `.disc{background:var(--ivory-2)}`, `chapters.css:463`).
  - `#8C775F` on `--ivory` `#FFFFFA` (`.cap`, `.feat__meta`, `.post__meta`; 11.8–13.6px/400):
    **4.26:1**. FAILS 4.5:1.
  - `#8C775F` on `--ivory-2` `#EFEAE1` (`.disc__t`, 13.1px/400): **3.56:1**. FAILS more badly —
    this is the disclaimer case, exactly what the brief flagged as a priority.
- **Liveness:** `chapters.css` is the live, sitewide stylesheet (confirmed via body-class on
  every page visited). I could not find `.cap`/`.disc`/`.post__meta` rendered on any of the ten
  pages I sampled (`/`, `/treatment/`, `/method/`, `/accessibility/`, `/faq/`, `/books/`, `/en/`,
  `/contact/`, `/snoring-sleep-apnea/`, `/blog/`) — meaning the underlying stylesheet is
  unambiguously loaded everywhere, but I cannot prove any content editor has placed one of
  these four specific components on the required page set. Given `.post__meta`-style
  "date/author on a card" and `.disc`-style "disclaimer strip" are exactly the kind of
  component that gets reused on pages outside my sample (individual blog posts, other
  treatment sub-pages I did not enumerate), I report this as a real, live-CSS defect with
  page-level presence unconfirmed, not as dead code (contrast with -14 below, which *is* dead).

### A11Y-VISUAL-05 — LOW-MEDIUM — Footer brand tagline marginally fails 4.5:1 (a live, exact near-miss, not a rounding artefact)

- **WCAG 2.0 SC 1.4.3, Level AA. Measured, live.**
- `.foot__brand p` (`chapters.css:242`): `color:rgba(255,255,255,.45)` on `.foot`'s
  `background:var(--dark)` = `#0E0905` (`chapters.css:233`). Live `getComputedStyle` on
  `/accessibility/` confirmed `color: rgba(255, 255, 255, 0.45)`, `font-size: 13.12px` exactly.
  Full-precision computation: **4.4960:1** (rounds to 4.50, but is genuinely, if narrowly,
  under 4.5). **FAILS** by less than 1%.
- Contrast with a sibling that got fixed: `.foot__base` originally shipped at
  `rgba(255,255,255,.4)` (`chapters.css:250`, computed **3.77:1**, a clear fail) and was
  explicitly bumped to `rgba(255,255,255,.62)` later in the same file
  (`chapters.css:683: /* footer copyright: lift opacity so it clears AA on the near-black
  footer */`, computed **7.74:1** — live-confirmed too). `.foot__brand p` sits right next to
  that fixed line and was not caught by the same pass.
- **User impact:** low-vision users reading the footer's "about the studio" tagline get text
  that is very close to, but not quite at, the legal minimum — worth folding into the same fix
  that already touched `.foot__base`.

### A11Y-VISUAL-06 — MEDIUM — `.btile--clay` gradient tile text fails at one full, exactly-computable end of its own gradient

- **WCAG 2.0 SC 1.4.3, Level AA. Static — and unlike the photograph cases below, fully
  resolvable from CSS, because a linear-gradient's stop colours are exact, not photographic.**
- `.btile--clay{background:linear-gradient(155deg,#B5663D,#9A4F2B)}` (`chapters.css:613`).
  - `.btile__t{color:#fff}` (`chapters.css:594`, 17.6px/400 — not large text, needs 4.5):
    on stop 1 `#B5663D`: **4.26:1** FAILS. On stop 2 `#9A4F2B`: **5.95:1** PASSES. Roughly the
    lighter half of every such tile fails.
  - `.btile__tag{color:#F0DCC8}` (`chapters.css:614`, 9px/500): on stop 1: **3.20:1** FAILS.
    On stop 2: **4.47:1** — also FAILS (by a hair; needs 4.5, this is 9px so it does not
    qualify as "large text" despite weight 500).
- I could not find `.btile` rendered on any of the ten sampled pages — flagged as static-only
  in the COULD NOT MEASURE list, but the CSS-level defect is certain (no photograph uncertainty
  involved here, unlike -12).

### A11Y-VISUAL-07 — MEDIUM — Mobile drawer secondary link text fails contrast

- **WCAG 2.0 SC 1.4.3, Level AA. Static — component confirmed to exist and load ≤1023px;
  not screenshotted live at that width in this session.**
- `.ea-mnav-link__ext` (`assets/css/ea-mobile-nav.css:167`): `color:rgba(255,255,255,.45)`,
  0.7rem, on the drawer's `--ea-ink` (`#2E2B28`) surface (`ea-mobile-nav.css:107`). Computed:
  **4.11:1**. FAILS 4.5:1. This is the small "external link" style label next to menu items in
  the mobile navigation drawer — directly relevant since mobile is explicitly in scope this round.

### A11Y-VISUAL-08 — MEDIUM — `.bookcard`'s focus indicator depends entirely on an undeclared browser default, on an element that also clips its own overflow

- **WCAG 2.0 SC 2.4.7 Focus Visible, Level AA. Measured, live, on `/books/` (confirmed 3 real
  `a.bookcard` elements rendered).**
- `.bookcard` (`chapters.css:805-806`) is a real `<a>` wrapping an entire book card
  (confirmed via `template-parts/chapters/parts/bookcard.php:47`), and sets `overflow:hidden`
  on **itself**. Its only `:focus-visible` rule (`chapters.css:808`) changes `transform` and
  `box-shadow` — it never declares an `outline`. I exhaustively grepped every `outline:` and
  `outline-color:` declaration in the theme (30+ hits) and `.bookcard` is not among them —
  every other interactive atom in the system (`.btn`, `.foot a`, `.tlink`, `.rcard[tabindex]`,
  nav links, form fields, the FAQ TOC, the footer social icons — over 30 selectors) gets an
  explicit `outline: 2px solid var(--terra/-lt/-dk/…)`. `.bookcard` alone does not.
  Live test: I focused the element immediately before the first bookcard, sent one real
  keyboard `Tab`, confirmed `matches(':focus-visible') === true`, and read the computed
  outline: `outline-style: auto` (i.e. the bare **browser default**, not a design-system
  colour), `outline-width: 1px` (half the width used everywhere else), `outline-color:
  rgb(229, 151, 0)` (not a brand colour — the browser's own heuristic pick),
  `outline-offset: 1px`. A screenshot at that state did show a thin ring around the card, so
  on the Chromium engine I tested this is **not currently invisible** — but it is the one
  place in the whole system where visibility is an accident of the browser's own default
  rather than an asserted, tested design decision, on an element whose own `overflow:hidden`
  is exactly the condition known (Chromium/WebKit) to clip self-drawn outlines in other
  configurations.
- **User impact:** low today on the tested engine; fragile — a different browser default,
  a future CSS change, or a different browser engine's outline-clip behaviour could silently
  remove the only focus indicator on a component people use to browse and buy books, with
  nothing in the codebase asserting it should look any particular way.

### A11Y-VISUAL-09 — LOW-MEDIUM (inferred) — `.rcard`'s *explicit* outline may still be clipped by its own `overflow:hidden`

- **WCAG 2.0 SC 2.4.7, Level AA. Inferred from a well-documented browser behaviour; could not
  render-test — no live page in my sample rendered `.rcard`/`.reveals` (see §4).**
- `.rcard` (`chapters.css:508`) sets `overflow:hidden` on itself, and
  `.rcard[tabindex]:focus{outline:2px solid var(--terra-lt);outline-offset:3px}`
  (`chapters.css:520`) draws its outline **3px outside** the border box via a positive
  `outline-offset` — on the same element that clips its own overflow. This exact
  combination (outline + positive offset + `overflow:hidden` on the same box) is
  documented Chromium/Firefox behaviour that clips the outline to the element's own box.
  Contrast this with `.ea-qr-facade:focus-visible{outline:3px solid var(--ea-focus,#fff);
  outline-offset:-3px}` (`chapters.css:977-979`) — a **negative** offset, deliberately drawn
  *inside* the box, which sidesteps this exact problem. The `.rcard` rule predates or simply
  didn't apply the same fix. I flag this as inferred, not measured, and recommend team_50 (or
  whichever line reaches a page using "reveals" — ACF-mapped to `tpl-chapters-method.php`,
  which none of the ten pages I sampled resolved to) confirm it visually before it's treated
  as fact.

### A11Y-VISUAL-10 — LOW-MEDIUM (inferred) — Fixed-pixel "read more" reveal panels risk clipping text under font-size-only enlargement

- **WCAG 2.0 SC 1.4.4 Resize Text, Level AA. Static; component not found live in my sample.**
- `.sc__more`/`.rcard__more` (`chapters.css:359`, `:513`; expanded state `:361`, `:518`):
  `max-height:0;overflow:hidden` at rest, expanding to a **fixed** `max-height:160px` /
  `170px` on hover/focus-within, `overflow:hidden` still in force. The text inside is
  free-form, editor-entered ACF content (`inc/chapters/chapters-render.php:430`, field type
  `ta` = textarea, no length limit) via `template-parts/chapters/parts/reveals.php:31`. Full
  page-zoom (the standard 1.4.4 test) scales the px ceiling along with everything else and is
  fine; the risk is specifically a user who enlarges *text only* (a browser "minimum font
  size" setting, or an OS text-size accessibility feature that doesn't rescale layout) against
  editor-entered copy that already runs close to the ceiling — there is no safety margin and
  no `overflow-y:auto` fallback if it's exceeded.

### A11Y-VISUAL-11 — LOW, conditional — a second, separate auto-scrolling testimonial marquee has no touch-equivalent pause

- **WCAG 2.0 SC 2.2.2 Pause, Stop, Hide, Level A (included in AA). Static; live presence on
  the required page set NOT confirmed (checked `/`, `/en/` — absent from both).**
- This is a **different** component from -correct item below. `.ea-testi-carousel__track`
  (`assets/css/testimonials-carousel.css:20-45`, block `template-parts/blocks/
  block-testimonials-carousel.php`) is a pure-CSS `animation: ea-testi-scroll ... infinite`
  marquee. It correctly disables itself under `prefers-reduced-motion` (`testimonials-
  carousel.css:61-64`) and pauses on `:hover`/`:focus-within` (`:30-33`) — but because it is
  pure CSS with no JS event wiring, there is no `pointerdown`/touch-tap equivalent, so a
  touch-only visitor who neither hovers nor focuses a child link has no way to pause it once
  it starts (and per SC 2.2.2 it must run under five seconds without one; a `60s`-default
  loop plainly doesn't). Its enqueue (`inc/wave2-stage-b.php:106`) is unconditional, but I did
  not find the component rendered on the homepage or `/en/`, the two pages most likely to
  carry a testimonial section — see §4. If it is not placed on any live page, this finding is
  moot; if it is, the gap is real. Compare with A11Y-VISUAL item below (checked/correct) —
  the *other*, confirmed-live testimonial carousel gets this right.

### A11Y-VISUAL-12 — informational, "cannot be resolved from CSS alone" per the brief's own instruction — text over photographs/scrims has no guaranteed contrast floor at the lightest stop

- **WCAG 2.0 SC 1.4.3. Explicitly NOT a pass/fail — reported as the brief instructs, with the
  CSS-computable bound as evidence for *why* a rendered check matters, not as the answer.**
- Several components lay text over a photograph/video with a translucent gradient scrim, and
  the scrim alone does not guarantee AA at every stop. Worked example: `.hero__h{color:#fff}`
  (`chapters.css:112`) over `.hero__scrim` (`chapters.css:109`), whose lightest declared stop
  is `rgba(18,12,8,.25)` at 35%. Compositing that stop over a *hypothetically bright* backdrop
  (white, the worst case the CSS itself cannot rule out) gives **1.77:1**; over the scrim's
  darkest stop (`rgba(18,12,8,.9)`) the same white text gets **15.27:1**. The true number is
  whatever the actual hero photo/video currently in use produces at the exact point the text
  sits — which is editorial content, not fixed in CSS, and can change with any future asset
  swap. The same pattern repeats for `.hero__trust` (kicker text, `chapters.css:111`), `.cmpc__t`/
  `.cmpc__p` (`chapters.css:199-202`), `.btile__t`/`.btile__tag` over `.btile__ov`
  (`chapters.css:591-594`), and the at-rest (unscrolled) main nav text over its own
  fade-to-transparent gradient (`chapters.css:690`, top stop `rgba(14,9,5,.82)` down to fully
  transparent — computed range **2.00–8.72:1** depending purely on where in that gradient the
  text sits and what's behind it). I am not asserting these fail; I am asserting the CSS
  provides no floor, and a rendered sample against the actual current photography is needed
  to know. Recommend a team_50/team_100 pass with real screenshots of each hero/section in
  current use.

### A11Y-VISUAL-13 — MEDIUM, systemic root cause — three unrelated "muted text" colours and two unrelated "ink" values across duplicate design-token systems

- Not a WCAG SC itself — the architectural cause tying -03 and -04 together, worth fixing once
  rather than patch-by-patch. This codebase carries **two parallel, independently-maintained
  colour-token systems** for what is presented to Eyal as one brand:
  1. `ea-tokens.css:8-27` + `functions.php:146-161` (`--ea-*` / `--eyal-*`): `--ea-ink:#2E2B28`,
     `--ea-muted:#6F635A` (deliberately fixed from `#A8A19B` for AA, per its own comment).
  2. `chapters.css:12-24` (`:root{--ivory/--dark/--terra/--ink/--muted/...}`, no `ea-`/`eyal-`
     prefix at all): `--ink:#2f2013` (close to but **not** the same hex as system 1's ink),
     `--muted:#8C775F` (a **third**, unrelated value, and — per -04 — one that fails AA against
     both of its own backgrounds, unlike system 1's carefully-fixed one).
  Plus the dangling `--eyal-muted` (undefined, -03) makes a *fourth* nominal "muted" reference
  that resolves to `#A8A19B` — the value system 1 explicitly rejected. Three hex values, one
  concept, one of the three demonstrably chosen *without* the AA pass system 1's own history
  shows the team knows how to do. I'd fix -03 and -04 by pointing everything at the one value
  that already passed a real audit (`--ea-muted:#6F635A`), not by tuning three colours separately.

### A11Y-VISUAL-14 — informational / hygiene, not a live defect — two whole stylesheets are orphaned dead code

- `services.css` (`.ea-treatment-page`/`.ea-method-page`, including the `#666` disclaimer
  originally flagged while reading it): **zero** references to `services.css` anywhere in any
  `.php` file in the theme (exhaustive grep), and its target templates `tpl-treatment.php`/
  `tpl-method.php` **do not exist** as files. It cannot render on any current page.
- `home-front.css` + `style.css:84-241`'s `--ea-home-*` tokens (`.ea-home-text:#818181` on
  white = 3.90:1, would fail; `--ea-home-accent:#1ABC9C` on white = 2.41:1, would fail):
  gated behind `body.ea-home-dashboard`, which the `body_class` filter (`functions.php:190-
  201`) never emits, and its enqueue is conditional on `is_page_template('page-templates/
  tpl-home.php')` (`inc/wave2-stage-b.php:141`) — a template documented in its own file header
  as a "FROZEN EMERGENCY ROLLBACK ... for tpl-home.php when Chapters is off"
  (`inc/wave2-stage-b.php:4-8`). Live-measured: the homepage's real body class carries
  `ea-chapters`, not `ea-home-dashboard`. Both files' contrast numbers are real but currently
  unreachable by any visitor. Listed so team_100 doesn't spend fix effort here, and flagged
  as a separate cleanup recommendation (removal), not an A11Y-VISUAL fix.

---

## 3. Checked and found correct (with evidence — equally important)

- **The skip link itself (mechanism, not colour) is correct and live**, resolving the brief's
  "verify, don't assume" on A11Y-NOW-01/02: exactly **one** skip link exists per page; on
  Hebrew pages it reads "דלג לתוכן" targeting `#main`, and `#main` genuinely exists in the DOM
  (`document.getElementById('main')` confirmed true, live, on `/accessibility/`); on `/en/` it
  correctly reads "Skip to content" in English (`lang="en"`), also targeting a real `#main`.
  Only its *colour on focus* is broken (A11Y-VISUAL-01).
- **A real, documented AA fix history exists and works.** `.btn--terra`'s filled button
  originally used `--terra` (`#B5663D`, white text = 4.26:1, a fail) and was overridden later
  in the same file by `--terra-btn:#B05F38` (`chapters.css:677-680`, comment: "axe serious → 0
  ... white text ≥4.5:1"), computed **4.63:1** — a genuine, working fix, live-confirmed by
  cascade order. Margin is thin (about 3% of headroom); I'd widen it slightly rather than
  touch it again reactively. Likewise `.foot__base`'s copyright line
  (`chapters.css:250→683`, `rgba(.4)`→`rgba(.62)`, **3.77:1 → 7.74:1**, live-confirmed) —
  see A11Y-VISUAL-05 for the sibling rule that was missed in the same pass.
- **The contact form's focus pattern is a correct, deliberate implementation**, not a bug:
  `.ea-contact-form--cf7 .wpcf7-form-control...:focus{outline:none; border-color:...}`
  followed immediately by the same selector's `:focus-visible{outline:2px solid
  var(--ea-terracotta); outline-offset:2px}` (`ea-atoms.css:1428-1439`). Because both rules
  share identical specificity and the `:focus-visible` block is later in source order, a
  keyboard-focused field gets the full outline back; a mouse-click focus gets the quieter
  border-colour change only. Live-confirmed on `/contact/`: programmatic focus showed the
  quiet state (`outline-style:none`, border-colour changed) exactly as designed for that case.
- **Hidden-content technique is correct in two different, deliberate ways.** `.ea-sr-only`
  (`ea-atoms.css:1650-1660`) uses the complete, standard visually-hidden clip pattern.
  Separately, the CF7 contact form's field labels use `font-size:0` rather than
  `display:none` specifically so the accessible name survives for assistive tech
  (`ea-atoms.css:1372-1385`, with an explicit comment explaining exactly this reasoning) —
  live-confirmed on `/contact/`: the label element for "שם מלא" (full name) exists in the DOM
  with `font-size: 0px`, i.e. present for AT, invisible to sighted users, which is the correct
  direction for this failure mode (the harmful direction — visible to sight but missing from
  the tree — was not found). `[hidden]{display:none!important}` (`chapters.css:31`) carries a
  documented, self-aware justification (a real prior bug, the duplicate WhatsApp CTA, already
  fixed per git history) rather than being a defensive-programming smell.
- **`prefers-reduced-motion` is honoured comprehensively, not piecemeal.**
  `ea-animations.css:90-99` sets a universal `*, *::before, *::after {
  animation-duration:0.01ms!important; animation-iteration-count:1!important;
  transition-duration:0.01ms!important }` under the media query — this alone neutralises
  every `animation:`/`transition:` in the codebase (breathe-*, the hero chevron bob, the
  testimonial idle-move glide, the pending-approval pulse, all of it) regardless of which
  specific class a future component uses, on top of several components' own explicit,
  redundant guards. This is a robust, forward-compatible implementation.
- **The homepage's manual testimonial carousel (`.testi-mq` + `ea-testi-mq.js`, confirmed live
  — 15 `.tmq` cards on `/`) is a genuinely well-built implementation of the "idle animation"
  the brief asked me to look at specifically.** Reading `ea-testi-mq.js:127-220`: the
  automatic "idle ping-pong" step (`chapters.css:731-736`, every 2.6s) is gated by
  `var motionOK = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;` **before**
  the timer is ever started (`ea-testi-mq.js:158-163`) — reduced motion fully disables the
  auto-advance mechanism itself, not just its CSS transition. It pauses (not merely on hover)
  on `mouseenter`, `focusin`, **and** `pointerdown` (`ea-testi-mq.js:196-200`) — covering
  mouse, keyboard, and touch alike, which is the one thing the *other*, CSS-only carousel
  (A11Y-VISUAL-11) is missing. Any manual button click stops it permanently
  (`stopIdleForGood()`). This satisfies SC 2.2.2 about as well as an implicit (hover/focus/
  touch-triggered, not a dedicated visible button) mechanism can. Soft recommendation only:
  consider an explicitly visible, independently-discoverable pause affordance for maximum
  robustness — not required given the multi-modal coverage already present.
- **The one genuine same-sentence inline content link I found in running prose does not rely
  on colour alone.** `.tlink` (`chapters.css:484`, e.g. "cbDIDG" inside a sentence on
  `/treatment/`) sets `text-decoration:none` but has a real `border-bottom:1px solid
  rgba(154,79,43,.4)` acting as a underline substitute — live-confirmed
  (`getComputedStyle`: `borderBottomWidth:"1px"`, `borderBottomStyle:"solid"`). Everything
  else I found with `text-decoration-line:none` inside a `<p>`/`<li>` on the pages I sampled
  turned out, on inspection, to be either a whole-block link (the entire paragraph/list item
  *is* the link — a much weaker 1.4.1 case) or a navigation-style link, not a same-sentence
  colour-only link.
- **The `body.ea-m4-polish .entry-content a` prose-link styling is sound, given what
  GeneratePress itself does.** `style.css:370-377` sets colour, weight, and underline
  *thickness/offset* but never `text-decoration-line` itself — I initially flagged this as
  unresolvable statically, but reading GeneratePress's own dynamic stylesheet live
  (`generate-style-inline-css`) shows the parent theme's base rule is `a { text-decoration:
  underline; }` sitewide. The child theme's rule refines an underline that's genuinely there
  by default; it does not (as I first suspected) rely on colour and weight alone.
- **`-webkit-line-clamp:3`** (`ea-blog.css:120`, live-confirmed on `/blog/`, 12 cards): truncates
  by line count, so it scales consistently with text size at any zoom level and is not a 1.4.4
  concern — `scrollHeight === clientHeight` (124px each) confirmed at 100%, i.e. not currently
  clipping anything beyond its designed 3-line preview.

---

## 4. COULD NOT MEASURE

1. **The true, rendered contrast of every text-over-photograph/video component**
   (A11Y-VISUAL-12's list) against the *actual* current image/video content on each page.
   Reason: this depends on photograph pixel values, which are editorial content, not fixed in
   CSS, and change with any asset swap. I computed the CSS-only bound (best/worst case) as
   supporting evidence; a rendered screenshot check against the live imagery is needed for a
   real number.
2. **Live presence of `.rcard`/`.reveals`/`.sc__more`/`.disc`/`.disc__t`/`.cap`/`.feat__meta`/
   `.btile`/`.ea-testi-carousel__track` on the required page set.** Reason: checked ten live
   URLs (`/`, `/treatment/`, `/method/`, `/accessibility/`, `/faq/`, `/books/`, `/en/`,
   `/contact/`, `/snoring-sleep-apnea/`, `/blog/`) and found none of them; the underlying
   stylesheets are confirmed loaded sitewide, but which ACF-driven components a content editor
   has actually placed on any *other* page (there are dozens more — `/lessons/`,
   `/sound-healing/`, `/repair/`, `/didgeridoos/`, individual blog posts, etc.) was outside
   this session's budget to fully crawl.
3. **`.ea-book-gallery-placeholder__*` / `.ea-section-label` live rendering on a real book
   detail page.** Reason: I attempted `/books/tsva-bekahol/` and it **redirected mid-navigation
   to the old production domain** (`https://eyalamit.co.il/...`, confirmed by
   `location.origin` and a body class full of the *old* theme's markers —
   `qode-theme-bridge`, `wpb-js-composer`). Per the brief's explicit instruction ("Audit
   staging. Do not audit production"), I discarded that entire page load and did not use any
   value from it. I did not find a second staging book-detail URL that stayed on staging
   within remaining budget (`/books/kushi-blantis/`, `/books/vekatavta/` were not re-tried
   after this).
4. **Whether `.rcard`'s outline is visually clipped by its own `overflow:hidden`
   (A11Y-VISUAL-09).** Reason: no live page in my sample rendered the component (see #2); the
   finding is reasoned from documented browser behaviour, not rendered.
5. **Any assistive-technology behaviour** (VoiceOver/NVDA announcement of the CF7 `font-size:0`
   label, of `.ea-sr-only` content, of ARIA states). Reason: no screen reader is available in
   this tool environment; this is explicitly team_50's remit per the plan doc.
6. **An exhaustive sweep of every `<a>`-targeting single-class colour rule in the codebase for
   the GeneratePress-override vulnerability (A11Y-VISUAL-02).** Reason: I confirmed the exact
   mechanical rule for which rules are at risk and verified two concrete instances live
   (one severe, `.nav__en`; one cosmetic-only, `.tlink`), and checked several more by
   reasoning through specificity (`.nav__l a`, `.nav__dd`, `.foot__base a` — all safe), but did
   not script a full pass across the ~150+ colour-on-`<a>` declarations in the theme within
   this session. See the recommended check in §5.
7. **Whether `body.ea-home-dashboard`/`services.css` are reachable through *any* path** (e.g.
   an admin toggle re-enabling the "Chapters off" rollback, or a page I didn't enumerate still
   assigned `tpl-treatment.php`/`tpl-method.php` — though those two files were confirmed absent
   from the filesystem, so that specific path is closed). I'm confident in "not reachable
   today" based on the evidence in -14, short of "provably unreachable under all future admin
   configuration," which isn't a meaningful bar for a snapshot audit.

---

## 5. Recommended fixes, ordered by user impact

1. **Fix the GeneratePress `a:focus`/`:hover`/`:active` colour collision (-01, -02).** Two
   options, in order of my preference: (a) give every affected single-class link rule its own
   `:focus`/`:hover`/`:active` colour re-assertion at the *same* class (cheapest, but you have
   to find them all — see the grep method below), or (b) add one small, deliberate, high-
   specificity rule scoped to the theme's own root wrapper (e.g.
   `body.ea-chapters a:hover, body.ea-chapters a:focus, body.ea-chapters a:active { color:
   inherit; }` or similar, specificity (0,2,1), which beats GP's (0,1,1) everywhere at once)
   that neutralises GP's override sitewide and lets each component's own rules decide colour
   again. Confirm with the exact live-CSSOM technique used in this audit
   (`document.styleSheets` + `el.matches(rule.selectorText)`), not a static read — that's what
   caught this. File to start with: `assets/css/ea-atoms.css` (`.ea-skiplink`, lines 74-95)
   and `assets/css/chapters.css` (`.nav__en`, lines 102-103). To find the rest: grep every
   `color:` declaration whose selector is a single bare class applied to an `<a>`, then check
   whether that same class has its own `:hover`/`:focus`/`:active` colour rule — if not, it's
   at risk wherever it sits on a dark/saturated background.
2. **Fix `--eyal-muted` (-03):** either define it (`--eyal-muted: var(--ea-muted);` alongside
   the other `--eyal-*` overrides in `functions.php:146-161`) or change the four consumers in
   `books-v2.css` to use `--ea-muted`/`--eyal-*` directly. One-line-equivalent fix, four fail
   sites resolved.
3. **Fix chapters.css's `--muted` (-04):** point `chapters.css:16`'s `--muted` at the same
   value `--ea-muted` already uses (`#6F635A`), or redefine it to a colour that independently
   clears 4.5:1 against both `#FFFFFA` and `#EFEAE1`. This also resolves the disclaimer case
   (`.disc__t`) directly.
4. **`.foot__brand p` (-05):** bump `rgba(255,255,255,.45)` to something in the `.foot__base`-
   fix neighbourhood (`.62` clears both with margin) — `chapters.css:242`.
5. **`.btile--clay` (-06):** darken `.btile__t`'s implicit reliance on `#fff`-on-stop-1, or
   choose the tile's gradient stops so neither end drops below 4.5:1/3.20:1 minimums; adjust
   `.btile__tag`'s `#F0DCC8` similarly — `chapters.css:613-614`.
6. **`.ea-mnav-link__ext` (-07):** raise `rgba(255,255,255,.45)` — `ea-mobile-nav.css:167`.
7. **Give `.bookcard` its own explicit `outline` on `:focus-visible`, matching the rest of the
   system** (e.g. the same `outline:2px solid var(--terra-lt); outline-offset:3px` used by
   sibling components), rather than relying on the browser default — `chapters.css:805-808`.
8. **Change `.rcard`'s outline to a negative offset** (as `.ea-qr-facade` already does), so it
   can never be clipped by the element's own `overflow:hidden` regardless of browser —
   `chapters.css:520` (pattern already proven correct at `chapters.css:977-979`).
9. **Give `.sc__more`/`.rcard__more` more headroom**: either drop the fixed `max-height` in
   favour of a generous `ch`/`em`-based ceiling that scales with font size, or add
   `overflow-y:auto` as a safety net so an over-long editor entry scrolls instead of clipping —
   `chapters.css:359-361`, `:513-518`.
10. **If `.ea-testi-carousel__track` is actually placed on any live page, add a `pointerdown`/
    touch pause** alongside its existing `:hover`/`:focus-within`, mirroring what
    `ea-testi-mq.js` already does correctly for the other carousel — `testimonials-carousel.css`
    + its block PHP would need a small JS companion, or a visible pause button.
11. **Housekeeping (not urgent, not user-facing today):** delete `services.css` and consider
    removing `home-front.css` + the `--ea-home-*` block in `style.css` once team_100 confirms
    the "Chapters off" rollback path is permanently retired — reduces the surface every future
    audit has to re-discover is dead.

---

## 6. What I believe the other lines will get wrong

- **Anyone testing focus/contrast by reading the CSS source and eyeballing the declared
  colours will miss A11Y-VISUAL-01 and -02 completely.** The source values for
  `.ea-skiplink`/`.nav__en` are correct-looking (white on terracotta, light-on-dark) — the
  defect only exists in the *runtime cascade*, against a stylesheet (GeneratePress's dynamic
  customizer CSS) that isn't a file in this repository at all. A grep-only or static-only pass
  — including, initially, my own first pass — will report these as PASS. The only way to catch
  it is to read `document.styleSheets`/`getComputedStyle` on a real, keyboard-Tab-focused
  element, on staging, and notice the number doesn't match the source.
- **Anyone testing focus with `element.focus()` in a script instead of a real keyboard
  keypress will get inconsistent, sometimes-wrong results and may not even notice.** I did
  this myself mid-audit: calling `.focus()` programmatically on `.bookcard` and `.ea-skiplink`
  produced `document.activeElement` correctly but **did not** reliably trigger
  `:focus-visible`-gated styles (in one case the position/colour changes simply never
  applied, even though the element held real focus) — Chromium's focus-visible heuristic
  treats script-triggered focus differently from keyboard-triggered focus, and not always in
  the direction you'd expect. Always confirm `el.matches(':focus-visible')` and prefer a real
  OS-level key-press before trusting any focus-state measurement.
- **Whoever checks `--eyal-muted`/`--eyal-*` tokens by reading `functions.php` alone may not
  notice `--eyal-muted` specifically is missing**, because it sits in the middle of seven
  *other* `--eyal-*` variables that all *are* defined right next to it — the absence is easy
  to miss unless you specifically grep for the definition, not just the usage.
- **A crawl limited to the brief's named page set (`/`, `/contact/`, `/treatment/`,
  `/accessibility/`, `/faq/`, `/shop/`, `/blog/`+post, `/en/`, `/qr/`+child, one book/product
  page) will likely reach the same "component not found" dead ends I did** for
  `.rcard`/`.disc`/`.btile`/the CSS-only testimonial marquee/the `--eyal-muted` consumers —
  and should resist the temptation to mark those CSS defects "not applicable" on that basis
  alone. The stylesheets are confirmed live; only the specific page placement is unconfirmed.
  I'd treat "not found on the named page set" as **inconclusive**, not as a clean bill of
  health, and recommend whoever has more crawl budget check the fuller sitemap
  (`/lessons/`, `/sound-healing/`, `/repair/`, `/didgeridoos/`, individual posts under
  `/blog/`, `/learning/*`) before closing any of A11Y-VISUAL-03/04/06/11 as moot.
- **Anyone who tries the same book-detail URL I did (`/books/tsva-bekahol/`) without checking
  `location.origin` afterward will silently audit the wrong site.** It redirects staging →
  production mid-session with no visible error. Worth a heads-up to every line touching the
  books/shop area.
- **Do not assume `body.ea-home-dashboard`/`services.css` numbers are "the site's real
  disclaimer contrast" or "the site's real home page contrast."** Both are confirmed dead code
  today (§2, -14) despite containing real, computable, real-looking failures. If another line
  reports these as live findings without checking liveness the way I did (body-class +
  enqueue-condition + template-file-existence, all three), the round's findings list will
  overstate what's actually broken for a real visitor.
