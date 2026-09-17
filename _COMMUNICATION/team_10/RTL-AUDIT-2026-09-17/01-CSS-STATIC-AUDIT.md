# RTL/BiDi CSS Static Audit — ea-eyalamit theme

**Date:** 2026-09-17
**Scope:** All 20 CSS files under `site/wp-content/themes/ea-eyalamit/` (19 in `assets/css/` + `style.css`)
**Type:** Read-only static audit. No code was modified.
**Trigger:** Two live RTL bugs found tonight by the client-facing owner during an actual client meeting — mirrored/backwards testimonial-carousel nav arrows, and a decorative border rendering on the visual-left instead of the reading-start (right) side (a plain `border-left` in this theme's own CSS, compounded by an inherited `border-left` from GeneratePress's default blockquote styling). Both are already fixed in `chapters.css` using logical properties. This audit looks for the same class of issue elsewhere before it surfaces live again.

## 1. Standard checked against

**Governing standard:** `_aos/lean-kit/modules/standards-conventions/rtl-bidi/RTL_BIDI_STANDARD_v1.0.0.md` (AOS Module 11 — RTL & Bidirectional UI Standard, v1.0.0, status ACTIVE, authority Team 100).

Core CSS rule (Section 2.1): every property in the physical→logical mapping table **MUST** use the logical form in new code; physical form = FAIL in code review. Physical properties are permitted only as **documented exceptions** for things with no logical equivalent (transforms, gradients, box-shadow direction, pseudo-element decorations) — and even those exceptions are supposed to carry a `[dir="rtl"]` override wherever the physical value would otherwise visually flip incorrectly (Section 2.3).

### Pre-commit checklist (Section 8.1, quoted verbatim)

> Each item is a YES/NO gate. **All must be YES before merge.**
>
> **HTML:**
> - [ ] `<html>` has `lang` attribute set to correct BCP 47 tag (e.g., `he`, `he-IL`)
> - [ ] `<html>` has `dir="rtl"` for RTL pages
> - [ ] All user-input fields that may contain unknown-direction text have `dir="auto"`
> - [ ] All unknown-direction inline content is wrapped in `<bdi>` or `dir="auto"` span
> - [ ] Known-LTR islands (ticker symbols, URLs, code, product codes) have explicit `dir="ltr"`
> - [ ] Price/currency tokens are wrapped in `dir="ltr"` span
> - [ ] Shekel sign (₪) appears BEFORE digits in HTML source
>
> **CSS:**
> - [ ] No `margin-left` or `margin-right` in new component CSS (use `margin-inline-*`)
> - [ ] No `padding-left` or `padding-right` in new component CSS (use `padding-inline-*`)
> - [ ] No `left:` or `right:` for positioned elements (use `inset-inline-*`)
> - [ ] No `text-align: left` or `text-align: right` (use `text-align: start`/`end`)
> - [ ] No `border-left` or `border-right` for semantic UI borders (use `border-inline-*`)
> - [ ] Physical properties used only for intentionally physical geometry (charts, canvas, pixel-anchored assets) — each instance has a comment justifying the exception
> - [ ] `[dir="rtl"]` overrides only for transforms, gradients, pseudo-elements, box-shadow direction
>
> **JavaScript:**
> - [ ] Direction read via `document.dir` (not `document.documentElement.dir`)
> - [ ] No hardcoded `'left'`/`'right'` strings in positioning logic — use logical or conditional
> - [ ] Dynamic content injection wraps unknown-direction text in `dir="auto"` or `<bdi>`
> - [ ] MUI projects: theme `direction: 'rtl'` AND stylis-plugin-rtl installed and configured
> - [ ] Portal components independently apply direction (not relying on ancestor inheritance)
> - [ ] Date/price/number formatting uses `Intl` API with `he-IL` locale
>
> **Bootstrap 5 RTL:**
> - [ ] `bootstrap.rtl.min.css` loaded (not `bootstrap.min.css`) for RTL pages
> - [ ] Custom RTL CSS loads AFTER Bootstrap RTL CSS
> - [ ] Breadcrumb, toast, input-group, progress bar reviewed manually (Bootstrap RTL experimental gaps)
>
> **Icons:**
> - [ ] Directional SVG icons (arrows, chevrons, send) have `[dir="rtl"] { transform: scaleX(-1) }`
> - [ ] Media control icons (play, pause) and universal icons (checkmark, close) have NO mirroring override

(Bootstrap items are not applicable — this theme does not use Bootstrap.)

### A note on how "live" was determined

This theme runs **two parallel systems** (per prior audit memory): an older **Wave2** block system (`template-parts/blocks/*`, `inc/wave2-*.php`) and the current **Chapters** system (`template-parts/chapters/*`, `inc/chapters/*`), which is enabled by default (`ea_chapters_enabled()` in `inc/chapters/chapters-render.php:91` defaults to `true`) and is confirmed active in production — tonight's bugs were both in Chapters markup (`chapters.css`'s `.tmq`/`.tmq__q`/`.testi-mq__btn` classes). Rather than only grep-matching class names (which can miss *enqueue*-level dead code, or wrongly clear *selector*-level dead code), this audit traced the actual `wp_enqueue_style()` call graph in `functions.php` and `inc/**/*.php` for all 20 files, then cross-checked selectors against `template-parts/`, `inc/`, and `page-templates/`. This surfaced three distinct dead/live states, all reported below:

1. **Live** — enqueued on a route with real content, selectors match a template that route renders.
2. **Orphaned (file-level dead)** — no `wp_enqueue_style()` call exists anywhere in the theme; the browser never loads the file at all, regardless of markup. (`services.css`, `w2-04-service.css`, `w2-10-service.css`, `w2-14e-catalog.css`.)
3. **Loaded-but-selector-dead** — the file *is* enqueued (via a shared "Wave2 shell" mechanism that still fires on every Chapters view — see `inc/wave2-stage-b.php` + `inc/chapters/chapters-routing.php`'s `ea_wave2_shell` flag), but its selectors only match markup in the old `template-parts/blocks/*` system, which Chapters routing no longer renders on any live route. (`testimonials-carousel.css`, `ea-mobile-nav.css`, `ea-mobile-variants.css`.)

---

## 2. Findings per file

Ordered so real violations on confirmed-live code come first.

### 2.1 `assets/css/chapters.css` — LIVE (the single-source Chapters design system; enqueued by `inc/chapters/chapters-enqueue.php` on every Chapters view, including the front page and the `/en` English page)

This is the highest-priority file: it is the one live stylesheet loaded on essentially every real page, Hebrew and English alike.

**Already fixed tonight — do not re-flag, cited here only for confirmation:**

| Line | Selector | Code | Note |
|---|---|---|---|
| 747 | `.tmq__q` | `border-left:0;border-inline-start:5px solid rgba(0,0,0,.05)` | Exactly the incident's border bug. `border-left:0` deliberately zeros out GeneratePress's inherited physical blockquote border; `border-inline-start` supplies the real one. Comment at lines 741–746 documents this per the standard. **Correct, no action.** |
| 695–707 | `.testi-mq__viewport`, `.testi-mq__track`, `.testi-mq__btn` | `direction:ltr` | Fixes the mirrored-arrow bug: Unicode `‹›` glyphs were rendering mirrored inside an RTL run. Documented at lines 697–702, dated 2026-09-16 (tonight). **Correct, no action.** |
| 757 | `.tmq__n` | `text-align:end` | Already logical. |
| 759–764 | `.tmq__nl` | `display:inline-flex; gap:4px` (no directional margin) | Comment explicitly cites the standard's guidance to prefer flex/gap over directional margins for icon spacing. **Good example, no action.** |

**NEW — real violation, highest priority (live, interactive, not decorative):**

| Line(s) | Selector | Property/value | Verdict |
|---|---|---|---|
| 611–616 | `.nav__l` (mobile hamburger drawer, `@media(max-width:1180px)`) | `transform:translateX(100%)` (closed state), `.nav[data-menu="1"] .nav__l{transform:none}` (open state) | **Real violation.** This is the live, site-wide mobile-nav slide-in panel — not a decoration. The standard's own worked example for this exact scenario (Section 5.4, "Modals and Drawers") prescribes `inset-inline-end:0` + `transform:translateX(100%)` as the default with a `[dir="rtl"]{transform:translateX(-100%)}` override. `.nav__l` here uses a symmetric `inset:72px 0 0 0` (full viewport width) instead of edge-anchoring, and there is **no `[dir]` override anywhere in this file** (confirmed: zero `[dir=` selectors in `chapters.css`). Today's visible risk is contained only because the panel is full-viewport-width, so "off past the right edge" looks the same regardless of direction — but this deviates from the documented MUST-pattern, and a working reference implementation for the *exact same component type* already exists in this codebase (see `ea-mobile-nav.css` §2.9 below). **Fix:** port the `--ea-mnav-tx` custom-property pattern, or add `[dir="ltr"] .nav__l{transform:translateX(-100%)}` alongside an `inset-inline` anchor. |

**NEW — real violations, medium priority (asymmetric UI positioning, not decorative):**

| Line(s) | Selector | Property/value | Verdict / fix |
|---|---|---|---|
| 634–636 | `.ea-skip-link`, `.ea-skip-link:focus`, `.ea-skiplink:focus` (note: two different class spellings — `.ea-skip-link` and `.ea-skiplink` — likely refactor debris, see Patterns §3) | `right:-9999px` / `right:12px;left:auto` / `top:12px;right:12px;left:auto` | Real violation. A skip-to-content link should reveal at the reading-start corner (`inset-inline-start`), not a hardcoded `right`. This is global chrome, so it also affects the confirmed-live `/en` (LTR) page. **Fix:** `inset-inline-start: -9999px` → `inset-inline-start: 12px` on focus. |
| 475, 477 | `.nav__sub` (dropdown submenu), `.nav__sub::before` (its pointer triangle) | `right:0` / `right:24px` (mixed in the same rule as a correct `border-inline-start`!) | Real violation — dropdown menus are exactly the component class Section 5.6 calls out. **Fix:** `inset-inline-end:0` / `inset-inline-end:24px`. |
| 125–126 | `.tl__n::before` (timeline node dot), `.tl__n:not(:last-child)::after` (connector, content `"←"`) | `right:0` / `left:14px` | Real violation — a timeline reads start-to-end; the node marker and connector should anchor logically. Bonus: the `←` glyph itself is a hardcoded-direction character (Section 5.5 territory), out of this audit's literal property scope but worth a follow-up. **Fix:** `inset-inline-start:0` / `inset-inline-start:14px`. |
| 205 | `.st3::after` (step counter badge) | `right:20px` | Real violation. **Fix:** `inset-inline-end:20px`. |
| 388 | `.videoblk__cap` (video caption/credit) | `right:22px;bottom:18px` | Real violation. **Fix:** `inset-inline-end:22px`. |
| 459 | `.cta-band__logo--side` | `left:auto;right:-40px` | Real violation. **Fix:** `inset-inline-start:auto;inset-inline-end:-40px`. |
| 494 | `.rcard__hint` (card hint badge) | `left:18px` | Real violation. **Fix:** `inset-inline-start:18px`. |
| 503–504, 512, 514 | `.flow-steps2__line`, `.fstep__dot` (+ 2 responsive overrides) | `right:54px`/`right:34px`; `right:-66px`/`right:-44px` | Real violation, internally consistent at least. **Fix:** `inset-inline-end` throughout. |
| 562 | `.nav__dd[aria-current="page"]::after` | `left:16px` | Real violation (overrides a symmetric parent rule asymmetrically). **Fix:** `inset-inline-start:16px`. |
| 678 | `.ea-chapters .ea-whatsapp-float` | `right:auto;left:22px` | Deliberate design override (WhatsApp float pinned opposite the site default specifically on Chapters pages) — real violation per the letter of the standard, but clearly intentional. **Fix:** express via logical properties and add the one-line comment the checklist requires ("why this side, regardless of language") rather than leaving it silently physical. |

**Text-align — real violations (12 code instances; 2 more grep hits at lines 727/754 are comments, not code, and are excluded):**

| Line(s) | Selector | Value | Note |
|---|---|---|---|
| 27 | `body` (bare, global) | `direction:rtl;text-align:right` | **Highest-impact instance in the file.** This is an unscoped `body` selector, so it applies to *every* page this stylesheet loads on — including the confirmed-live `/en` English page (`ea_chapters_is_view()` returns true for the `en` route per `chapters-render.php:65`, so `chapters.css` loads there too). See Patterns §3 and Recommendations §4 for the full mechanism. **Fix:** drop the hardcoded pair entirely and let `dir="rtl"` on `<html>` (already correctly set per-template) do the job; if a body-level statement is wanted for clarity, use `text-align:start`. |
| 219, 232 | `.foot__brand` | `text-align:left` (desktop) → `text-align:right` (mobile, `@media(max-width:760px)`) | Real violation, and internally inconsistent even on its own terms (flips by viewport width, not by content/direction logic) — likely a layout artifact rather than a deliberate bidi decision. **Fix:** clarify the actual design intent, then express with `text-align:start`/`end` or `text-align:match-parent`. |
| 351 | `.dd__sum-main` | `text-align:right` | Real violation. **Fix:** `text-align:end`. |
| 527 | `.mag-spread` | `text-align:right` | Real violation. **Fix:** `text-align:end`. |
| 544, 547, 548 | `.cta-band--row`, `.cta-band--row .cta-band__h`, `.cta-band--row .cta-band__p` | `text-align:right` (×3) | Real violation, repeated 3× in one component. **Fix:** `text-align:end`. |
| 716 | `.tmq` | `direction:rtl;text-align:right` | Real violation (the testimonial card container itself — separate from the already-fixed `.tmq__q`/`.tmq__n` children). **Fix:** `text-align:end`; the explicit `direction:rtl` forces RTL even inside an LTR page, which is the same systemic pattern as line 27. |
| 773 | `.testi-grid` | `direction:rtl;text-align:right` | Same pattern as `.tmq`. |
| 781 | `.bookcards` | `text-align:right` | Real violation. |
| 818 | `.gfig__cap` (gallery caption over a gradient) | `text-align:right` | Real violation. |

**Reviewed, low risk (symmetric — listed for completeness, not worth individual fix tickets):** lines 67, 75, 94, 267, 309, 320, 357, 358, 385, 458, 561, 940 all pair `left:0`/`right:0` (full-bleed stretch) or `left:50%`+`transform:translateX/translate(-50%,…)` (centering). Direction-agnostic by construction; logical equivalents (`inset-inline:0`, or leave centering transforms as-is) would be cleaner but there is no visual bug.

**Reviewed, borderline — undocumented decorative background motifs (candidate legitimate exceptions per checklist item "physical properties used only for intentionally physical geometry... each instance has a comment"):** lines 154 (`.studio__t .arcs`), 213 (`.foot .arcs`), 244 (`.phero .arcs`), 364 (`.bleed__breath`), 551/556 (`.cta-rings`), 591 (`.btile--txt::after`) — all single-sided `left`/`right` offsets positioning decorative background artwork (arcs/rings/logo watermark motifs), not text or interactive controls. These plausibly qualify as the standard's "intentionally physical geometry" exception, **but none carries the required justifying comment.** Verdict: exception, missing its documentation — add a one-line comment per instance, or convert to `inset-inline-*` (visually identical for LTR since the motifs aren't mirrored intentionally either way, so logical would only cost a naming change, not a behavior change).

---

### 2.2 `assets/css/ea-atoms.css` — LIVE (loaded on every "Wave2 shell" view — which, via `ea_wave2_shell`, includes every live Chapters view too, so this also reaches `/en`)

**Real violations — text-align (12 instances, identical pattern each time: a hardcoded `text-align:right` on a component that has no direction-conditional logic at all):**

| Line(s) | Selector |
|---|---|
| 59 | `body` (bare, global — same systemic pattern as `chapters.css:27`, see Patterns §3) |
| 478 | `.ea-hero__title` |
| 489 | `.ea-hero__subtitle` |
| 500 | `.ea-hero__trust` |
| 506 | `.ea-hero__cta-wrap` |
| 731 | `.ea-faq-item__answer` region (contextual; see line 727 comment "kept literal = original physical value" — i.e., already known and deliberately left, not accidental) |
| 1098 | `.ea-faq-item__question` |
| 1122 | `.ea-faq-mini-section__footer` |
| 1207 | `.ea-contact-form__label` |
| 1222 | `.ea-contact-form__input, __select, __textarea` (also sets `direction:rtl` on the same rule — a form input, see Recommendations) |
| 1279 | `.ea-contact-form--cf7 .ea-cf7-row > label` |
| 1298 | `.ea-contact-form--cf7 .wpcf7-form-control.wpcf7-text/.wpcf7-textarea` (also `direction:rtl`) |

**Verdict for all 12:** real violations. None has a documented reason to stay physical (line 731's comment explicitly flags it as a known, *deliberate* physical value rather than an oversight, which is at least honest, but the standard doesn't carve out an exception for "we know and left it anyway" — it should still be logical). **Fix (same for all):** `text-align:right` → `text-align:end`; the two `direction:rtl` instances on form controls should be dropped in favor of inheriting from `<html dir>`, or gated so they don't apply on `/en`.

**Real violation, correctly mitigated — worth noting as a *good* partial example:**

| Line(s) | Selector | Code |
|---|---|---|
| 266, 279–281 | `.ea-topnav__submenu` | Base rule: `right:0`. Override: `nav[dir="ltr"] .ea-topnav__submenu{right:auto;left:0;}` |

**Verdict:** Real violation per the letter of the standard (a positioned element MUST use `inset-inline-*`, which has no browser-support caveat, so there's no legitimate exception here) — **but** it is the one place in the whole codebase outside `ea-mobile-nav.css` that actually ships a working `[dir]`-based override, so it is **not visually broken today in either direction.** Medium priority: replace the two-rule pair with one `inset-inline-end:0` declaration (cleaner, and removes the drift risk of the two rules ever getting out of sync).

**Real violation — a second, parallel skip-link implementation:**

| Line(s) | Selector | Code |
|---|---|---|
| 70–92 | `.ea-skiplink`, `.ea-skiplink:focus` | `right:0` / `right:12px;left:auto` |

Same issue as `chapters.css`'s `.ea-skip-link`/`.ea-skiplink` (§2.1) — this file has **yet another, independent** skip-link rule set. See Patterns §3 for the count across the codebase (three separate implementations, two different class-name spellings, inconsistent sides).

**Reviewed, low risk (symmetric, decorative underline-reveal / full-bleed patterns — same shape as the equivalent `chapters.css` cases):** lines 24–25, 98–99, 121–122, 130–131, 140–141, 190–191, 202–203, 209–210 (8 pairs, 16 line-instances) — all `left:0;right:0` or `left:50%;right:50%` symmetric pairs on `.ea-link::after`, `#ea-scroll-progress`, `.ea-topnav`, `.ea-topnav__link::after`. No visual RTL/LTR difference possible; logical `inset-inline` would be cleaner but this is cosmetic-only cleanup, not a bug fix.

---

### 2.3 `style.css` — LIVE (always loaded; WordPress requires the child theme's own stylesheet)

| Line | Selector | Property/value | Verdict |
|---|---|---|---|
| 19–23 | `body.ea-lang-en, body.ea-lang-en.ltr` | `direction:ltr;text-align:left;unicode-bidi:isolate` | Real violation per the letter of the checklist, but **functionally inert as a bug** since it only ever fires inside a rule that already forces `direction:ltr` (where `left` and logical `start` always coincide). Confirmed **live and load-bearing**: `functions.php:190-196` adds body class `ea-lang-en` via a slug check (`is_page('en')`) that fires regardless of which template renders the page, so this rule is exactly what keeps the `/en` page's *body-level* direction correct against the global `body{direction:rtl}` rules in `chapters.css`/`ea-atoms.css` (see Recommendations §4 for why the page *also* needed inline-style patches on top of this). **Fix:** `text-align:left` → `text-align:start` for consistency/lint-cleanliness; no visible change expected. |

No other hits in this file (checked: no `margin-left/right`, `padding-left/right`, `border-left/right`, `float`, or bare `left:`/`right:` positioning).

---

### 2.4 `assets/css/books-v2.css` — LIVE (enqueued unconditionally in `functions.php:697-702` — "replaces books-wave1.css" — for the books hub/detail views)

| Line | Selector | Property/value | Verdict |
|---|---|---|---|
| 1045 | `.ea-books-hub-hero` | `background-position: 60% center;` — comment: *"B&W portrait: face on left, push slightly right for RTL balance"* | **Documented exception, but missing the formal `[dir]` pairing the standard asks for.** This compensates for a specific photograph's fixed composition (the subject's face sits toward the left third of the actual JPEG) rather than for text flow, so a mirrored `[dir="ltr"]` value may not even be desirable — flipping it wouldn't "fix" anything, it would just re-crop a portrait that isn't mirrored. Verdict: exception, correctly has an explanatory comment (satisfies checklist item "each instance has a comment justifying the exception"), but doesn't have the `[dir="rtl"]` companion rule the standard's letter technically calls for. Recommend: either add an explicit `[dir="ltr"]` value confirming "intentionally unchanged" (so a future reader doesn't assume it was missed), or leave as-is and note the rationale in this audit (done). |
| 1127 | `.ea-book-detail-hero__blur` | `background-position: center 20%;` | **Not a violation.** No `left`/`right` keyword — pure vertical offset. Included here only because it matched the broad `background-position:` grep; no action needed. |
| 1359 | `.ea-books-hub-card__cta a:hover::before` | `transform:translateX(3px)` on a `content:'→'` arrow, comment *"RTL: → points toward text (right side)"* | Minor. Self-consistent today (books pages are Hebrew-only, confirmed no English book routes), but the nudge direction and the arrow glyph itself are hardcoded for RTL with no `[dir="ltr"]` counterpart. Low priority unless book pages ever gain an English variant. |

---

### 2.5 `assets/css/ea-animations.css` — LIVE (loaded on every Wave2-shell / Chapters view alongside `ea-atoms.css`)

| Line(s) | Selector | Property/value | Verdict |
|---|---|---|---|
| 27–29 | `@keyframes breathe-drift` | `translateX(0)`/`translateX(8px)`/`translateX(-6px)` | **Not a real violation.** Small ambient jitter for decorative background circles — symmetric wobble, not a directional slide, conveys no reading-direction meaning. Legitimate exception, no `[dir]` override needed. |
| 45–48 | `@keyframes ea-slideIn-rtl` | `translateX(32px) → 0` | Minor / self-documenting. The keyframe is explicitly named `-rtl`, signaling the author knew this is direction-specific; there is no sibling `-ltr` keyframe in this file. Fine as long as it is only ever applied inside RTL-scoped markup — flag as needing a one-line comment confirming that scoping, per the checklist's "each instance has a comment justifying the exception." |
| 135–136 | `.ea-link::after` (inside `@media(prefers-reduced-motion:reduce)`) | `left:0;right:0` | Symmetric, same as the base rule in `ea-atoms.css`. No issue. |

---

### 2.6–2.9 Clean live files (scanned, zero hits in every requested pattern)

| File | Live status | Result |
|---|---|---|
| `assets/css/w2-05-shop.css` | **LIVE** — enqueued by `inc/chapters/chapters-commerce.php:ea_chapters_w2_05_shop_assets()`, specifically on the 5 real product pages (`didgeridoos`, `bags`, `stands-storage`, `stand-floor`, `repair`). Despite the legacy `w2-` filename, this was explicitly "re-homed" (its own comment) into the Chapters system during the T6 migration. | No physical-direction hits at all (only `translateY`, not direction-relevant). Clean. |
| `assets/css/w2-08-en-landing.css` | **LIVE** — enqueued by `inc/wave2-w2-08.php:ea_w2_08_assets()`, gated on `is_page('en')` (slug-based, so it fires regardless of which template renders — confirmed still active even though the *template* is now `tpl-chapters-en.php`, not the old `tpl-en-landing.php`). | Zero hits — appropriately, since this file is written for an LTR page and correctly never declares a hardcoded RTL-style physical value. Clean. |
| `assets/css/ea-blog.css` | **LIVE** — enqueued twice (redundantly): `inc/wave2-w2-07.php:501` and `inc/chapters/chapters-enqueue.php:134` (`ea_chapters_blog_assets`, on the real blog archive/single views). | Zero hits. Clean. |
| `assets/css/ea-tokens.css` | **LIVE** — enqueued by `inc/wave2-stage-b.php:101`, which fires on every Chapters view via the `ea_wave2_shell` flag (functions.php comment: "still required by Chapters shell"). | Zero hits. Clean. |
| `assets/css/faq-toc.css` | **LIVE** — enqueued by `inc/chapters/chapters-enqueue.php:107-114`, on `is_page('faq')`. | Zero hits. Clean. |

---

### 2.10 `assets/css/ea-mobile-nav.css` — LIVE-LOADED but LIKELY SELECTOR-DEAD on every real page

**Enqueue status:** loaded via `inc/wave2-stage-b.php:115` on every Wave2-shell view — which, via the `ea_wave2_shell` query var set by `inc/chapters/chapters-routing.php`, fires on every live Chapters page too.

**Selector reachability:** its classes (`.ea-mnav-burger`, `.ea-mnav-drawer`, `.ea-cfoot__*`, `.ea-footer__*`, etc.) were grepped against every file in `template-parts/`. The only match is `template-parts/blocks/block-topnav.php` (the old Wave2 block system). **Zero matches in `template-parts/chapters/`.** Chapters renders its own, completely separate nav via `template-parts/chapters/section-nav.php` (classes `.nav`, `.nav__burger`, `.nav__l`, styled entirely by `chapters.css` — see §2.1). `block-topnav.php` itself is only invoked by `ea_wave2_render_home_blocks()`, which the code's own comment says is a rollback path "for tpl-home.php when Chapters is off" — and Chapters defaults to on. **Verdict: LIKELY DEAD — verify reachability before prioritizing**, per the audit brief's instruction for this exact situation (enqueued, but its markup is not rendered by any route Chapters currently serves).

**Findings inside it, listed as instructed despite the likely-dead status:**

| Line | Code | Verdict |
|---|---|---|
| 30–31 | `html[dir="rtl"]{--ea-mnav-tx:-100%} html[dir="ltr"]{--ea-mnav-tx:100%}`, consumed at line 111 as `transform:translateX(var(--ea-mnav-tx,100%))` | **This is the single best-executed example of the standard's own recommended pattern (Section 6.2, "Custom Properties Pattern") anywhere in the codebase.** Legitimate exception, correctly handled. Worth pointing to as the reference implementation when fixing `chapters.css`'s equivalent, currently-live drawer (§2.1). |
| 111, 122 | `.ea-mnav-drawer{transform:translateX(var(--ea-mnav-tx,100%))}` / open state `transform:translateX(0)` | Correctly handled (depends on the dir-aware custom property above). |

No other physical-direction hits in this file.

---

### 2.11 `assets/css/ea-mobile-variants.css` — LIVE-LOADED but LIKELY SELECTOR-DEAD (same reasoning as §2.10; it only extends `ea-mobile-nav`'s classes, which are enqueued as its dependency and share the same dead-on-Chapters status)

Zero physical-direction hits — the file is exclusively responsive breakpoint variants. Nothing to flag either way.

---

### 2.12 `assets/css/testimonials-carousel.css` — LIVE-LOADED but LIKELY SELECTOR-DEAD

**Enqueue status:** loaded via `inc/wave2-stage-b.php:106` on every Wave2-shell view (same `ea_wave2_shell` mechanism as above).

**Selector reachability:** its four classes (`.ea-testi-carousel__viewport/__track/__item`, `.ea-testimonial-card`) are defined and consumed by `template-parts/blocks/block-testimonials-carousel.php` and `block-testimonials-row.php` — both in the old Wave2 block system. **Zero matches in `template-parts/chapters/`.** The live, client-facing testimonial carousel that was actually fixed tonight is a *different, parallel* implementation: `chapters.css`'s `.tmq`/`.testi-mq__*` classes, rendered by `template-parts/chapters/parts/testimonials.php`. `block-testimonials-carousel.php`'s own header comment even documents that it falls back to `ea_w2_07_fb_testimonials()` (the old Facebook-testimonials renderer) — another old-system-only code path. **Verdict: LIKELY DEAD — verify reachability before prioritizing.**

**Findings inside it:**

| Line(s) | Code | Verdict |
|---|---|---|
| 50–51 | `@keyframes` marquee: `from{transform:translateX(0)} to{transform:translateX(-50%)}` | Hardcoded-sign `translateX`, no `[dir]` variant. If this file is ever revived, an RTL auto-scrolling marquee conventionally needs the mirror-image sign so the motion still reads as "forward." Moot while dead; flagged for completeness per the audit brief. |

---

### 2.13 `assets/css/theme-shell-fallback.css` — CONFIRMED NON-PRODUCTION (not simply "likely dead" — traced to a concrete, always-false-in-production condition)

**Enqueue status:** `functions.php:39-50` — `ea_eyalamit_enqueue_theme_shell_fallback()` enqueues this file **only when** `ea_eyalamit_generatepress_parent_style_readable()` returns false, i.e., only when the GeneratePress **parent theme's `style.css` is not present on disk.** In production, GeneratePress is installed, so this is always false there. This file (and its accompanying `.ea-shell-*` markup in `header.php`) exists purely as a stopgap for a repository checkout/worktree that lacks the (gitignored) parent theme — matching this project's own known issue that worktrees silently lack GeneratePress. **A real site visitor never loads this CSS.**

**Findings, listed per the audit brief despite non-production status:**

| Line | Selector | Property/value | Verdict |
|---|---|---|---|
| 14–17 | `body.rtl` | `direction:rtl;text-align:right` | Would be a real violation if live; moot given confirmed non-production status. |
| 221 | `.screen-reader-text.ea-skip-link:focus` | `left:0.5rem;top:0.5rem` | A **third**, independently-coded skip-link implementation (see Patterns §3) — and this one pins to the physical **left**, the opposite side from the other two (`chapters.css` and `ea-atoms.css` both pin theirs to `right`). Moot given non-production status, but the inconsistency itself is worth noting. |
| 53, 269 | `.` (border-radius shorthand, bonus finding) | `border-radius: 0 0 4px 4px;` / `12px 12px 0 0` | Top/bottom-only asymmetry (not left/right), so not an RTL concern — noted only because it surfaced in the border-radius grep pass. No action needed. |

---

### 2.14 `assets/css/services.css` — CONFIRMED ORPHANED (dead file — no enqueue path exists anywhere in the theme)

**Evidence:** exhaustive search of every `.php` file in the theme for `assets/css` string references, plus a loose search for `services.css`/`'services'` in any form, turns up **zero** `wp_enqueue_style()` (or any other loading mechanism — no `@import`, no direct `<link>`) referencing this file. Independent corroboration: the file's own header comment claims it targets `tpl-treatment` and `tpl-method` page templates — **neither file exists** in `page-templates/` today (only Chapters equivalents `tpl-chapters-page.php` do, and the route map sends `/treatment/` and `/method/` there instead). A classname spot-check (`.ea-method-block`, `.ea-method-block__h2`, etc.) against `template-parts/` and `inc/` also came back empty. **Verdict: confirmed dead, not merely "likely."**

**Findings, listed per the audit brief:**

| Line | Selector | Property/value | Verdict |
|---|---|---|---|
| 11–24 | `.ea-treatment-page, .ea-method-page` | `direction:rtl;text-align:right` | Would be a real (global-scope) violation if live. Moot. |
| 184 | `.ea-treatment-who-list li::before` (a `✦` bullet decoration) | `right:0` | Would be a real violation (directional list-marker positioning) if live. |
| 319 | `.ea-treatment-faq-q::after` (a `+` expand icon) | `left:0` | Would be a real violation if live. |
| 157 | `.ea-treatment-divider, .ea-method-divider` | `background:linear-gradient(to left, transparent, var(--svc-sand), transparent)` | Not actually a directional issue even if live — a symmetric transparent→color→transparent gradient renders identically regardless of the angle's sign. No fix needed even hypothetically. |

---

### 2.15 `assets/css/w2-10-service.css` — CONFIRMED ORPHANED + selectors only match dead old-system markup

**Evidence:** no `wp_enqueue_style()` call anywhere (the file's own header comment says it was "loaded only on the 4 service routes" as of 2026-06-03, but the enqueue file that would have done that no longer exists). Its classes (`.ea-hero__kicker`, `.ea-disclaimer`, `.ea-bio-block__portrait`, etc.) were found only in `template-parts/blocks/*` (old system), never in `template-parts/chapters/`. **Verdict: confirmed dead at the enqueue layer, and selector-dead too.**

| Line | Selector | Property/value | Verdict |
|---|---|---|---|
| 24 | `.ea-hero__kicker` | `text-align:right` | Would be a real violation if live. Moot. |

---

### 2.16 `assets/css/home-front.css` — LIKELY DEAD

**Evidence:** enqueued by `inc/wave2-stage-b.php:141`, but gated specifically on `is_page_template('page-templates/tpl-home.php')`. `tpl-home.php` still exists on disk, but the Chapters router (`inc/chapters/chapters-routing.php:ea_chapters_template_include`, priority 103) unconditionally serves `tpl-chapters-home.php` for the front page whenever Chapters is enabled (default: yes) — the code's own comment on the wave2 render function calls it a "rollback... for tpl-home.php when Chapters is off." A classname spot-check (`.ea-home-mediarow`, `.ea-bio-block__portrait`, etc.) against `template-parts/chapters/` came back empty. **Verdict: LIKELY DEAD — verify reachability before prioritizing** (it would only matter if Chapters were ever disabled, or if `tpl-home.php` is manually re-assigned to a page).

| Line | Selector | Property/value | Verdict |
|---|---|---|---|
| 425 | (bonus finding, not in the literal grep list) `border-radius: 0 4px 4px 0` | 4-value shorthand, left/right corners asymmetric | Same bug class as the requested 4-corner longhands (`border-top-left-radius` etc. — zero literal longhand hits were found anywhere in the codebase, but this shorthand achieves the identical physical-corner effect). Would need a `[dir]`-aware swap if ever revived. Moot given dead status. |

No other hits (no text-align, margin, padding, float, or left/right positioning matches in this file at all).

---

### 2.17 `assets/css/w2-07-heritage.css` — LIKELY DEAD

**Evidence:** enqueued by `inc/wave2-w2-07.php:ea_w2_07_assets()`, gated on old-system page/QR detection functions (`ea_w2_07_is_press`, `ea_w2_07_is_qr` checking `is_page_template('page-templates/tpl-qr.php')`) that target templates superseded by the Chapters route map (`'qr' => tpl-chapters-page`, plus a `tpl-chapters-qr.php` pattern-route for QR children). Classnames (`.ea-press__*`, `.ea-qr-article*`) came back empty against `template-parts/chapters/`. **Verdict: LIKELY DEAD — verify reachability before prioritizing.**

Zero physical-direction hits in this file regardless — clean even if revived.

---

### 2.18 `assets/css/w2-04-service.css` — CONFIRMED ORPHANED at the enqueue layer

**Evidence:** no `wp_enqueue_style()` anywhere. The historical loader, `inc/wave2-w2-04.php`, no longer exists in `inc/` — it is only mentioned in comments elsewhere (`inc/ea-testimonials-fb.php:11`, `inc/wave2-w2-07.php:332`) as a thing that used to exist. Nuance worth flagging: unlike the other orphaned files, this one's class names (`.ea-cta-pill`, `.ea-faq-item`, `.ea-cta-ab`, etc.) **are** still used by live Chapters partials (`template-parts/chapters/parts/product-cta.php`, `contact.php`, `faq-inline.php`) — but those elements are evidently styled by other, currently-loaded sheets (`ea-atoms.css`/`chapters.css` define the same "atom" class names independently). This specific file's rules never reach the browser either way. **Verdict: confirmed dead at the file level; the components it targets are alive but styled elsewhere.**

Zero physical-direction hits in this file — clean even hypothetically.

---

### 2.19 `assets/css/w2-14e-catalog.css` — CONFIRMED ORPHANED

**Evidence:** no `wp_enqueue_style()` anywhere. Its historical loader, `inc/wave2-w2-14e.php`, no longer exists — `inc/chapters/chapters-enqueue.php:77` documents that only that file's *script* enqueue (a Mokesh trailer video) was ported into the Chapters system; the CSS enqueue was not carried over. Classnames (`.ea-14e-heading`, `.ea-14e-pagehead`, etc.) came back empty against every template directory. **Verdict: confirmed dead.**

Only non-directional hit: line 420, `transform:translate(-50%,-50%)`, a standard centering trick paired with `top:50%;left:50%` — not a real RTL concern even hypothetically.

---

## 3. Patterns — the recurring mistakes, by count

1. **Global, unscoped `body { direction:rtl; text-align:right }`, repeated in 2 of the most-loaded live files** (`chapters.css:27`, `ea-atoms.css:59`) — plus 2 more component-level repeats of the identical pair (`chapters.css:716` `.tmq`, `chapters.css:773` `.testi-grid`). This is the single most consequential pattern in the whole audit: because it is unscoped, it applies to the confirmed-live `/en` English page too, and is why that page's own template (`page-templates/tpl-chapters-en.php`) had to be patched with repeated inline `style="direction:ltr;text-align:left"` on `<main>` and on every one of its 4 `<section>` elements rather than simply inheriting from `<html lang="en" dir="ltr">` as the standard's Section 1.1 intends. **4 instances, 2 files, defended against with inline-style patches rather than fixed at the source.**

2. **Hardcoded `text-align: right` (or `:left`) instead of `text-align: start`/`end`** — 28 real code instances (2 additional grep hits are comments, not code) across 6 files: `chapters.css` (12), `ea-atoms.css` (12), `services.css` (1, dead), `w2-10-service.css` (1, dead), `theme-shell-fallback.css` (1, non-production), `style.css` (1). This is the single largest raw count and the cheapest category to fix — a mechanical find/replace, since `start`/`end` are supported with zero browser caveats per the standard's own Section 2.4.

3. **Hardcoded `left:`/`right:` for absolutely/fixed-positioned elements instead of `inset-inline-start/end`** — 63 raw hits across 5 files (`chapters.css` 36, `ea-atoms.css` 22, `services.css` 2, `ea-animations.css` 2, `theme-shell-fallback.css` 1). Of these, roughly 28 are symmetric pairs (`left:0;right:0` full-bleed stretches, or `left:50%`+`translate(-50%,…)` centering) that carry **no actual visual risk** either direction; the remainder (~25) are genuinely asymmetric, directionally-meaningful UI positioning (dropdown menus, skip links, step/timeline markers, card badges, captions) that would visibly land on the wrong side if the same component were ever rendered in an LTR context.

4. **Three independent, mutually-inconsistent skip-link implementations** — `chapters.css` (`.ea-skip-link`/`.ea-skiplink`, pinned `right`), `ea-atoms.css` (`.ea-skiplink`, pinned `right`), `theme-shell-fallback.css` (`.ea-skip-link`, pinned `left`). Beyond the RTL question, the class-name spelling itself is inconsistent (`skip-link` vs `skiplink`) — signals unconsolidated refactor debris across what should be one shared accessibility primitive.

5. **Decorative background motifs (`.arcs`, `.cta-rings`, logo watermarks) positioned with a single hardcoded `left`/`right` offset and no justifying comment** — 7 instances in `chapters.css` (lines 154, 213, 244, 364, 551, 556, 591). These plausibly qualify as the standard's own "intentionally physical geometry" exception category, but none carries the comment the checklist explicitly requires for that exception to count as compliant.

**Not found anywhere in the codebase (0 hits, 20/20 files clean):** `margin-left`/`margin-right`, `padding-left`/`padding-right`, `float:left`/`float:right`, and the four `border-*-radius` longhands. `border-left`/`border-right` had exactly **one** hit in the entire theme, and it is the already-fixed testimonial border from tonight's incident.

---

## 4. Prioritized recommendations

**P0 — fix now, live and functional (not cosmetic):**
1. `chapters.css` `.nav__l` mobile drawer (§2.1, lines 611-616): add a `[dir]`-aware transform, ideally by porting the `--ea-mnav-tx` custom-property pattern that already exists, unused, in `ea-mobile-nav.css`. This is the live, site-wide hamburger menu — the only interactive (not decorative) component flagged in this audit that both (a) is confirmed live and (b) currently has zero directional handling.
2. The global unscoped `body{direction:rtl;text-align:right}` in `chapters.css:27` and `ea-atoms.css:59` (Patterns §1): remove it and let `<html dir>` do its job per Section 1.1 of the standard, rather than relying on `/en`-only class overrides plus inline-style patches scattered through `tpl-chapters-en.php`. This is the architectural root cause behind the most convoluted part of the whole audit and the most likely source of the *next* client-visible bug, since every new Chapters section built without remembering to add its own inline `direction:ltr;text-align:left` patch will silently inherit RTL/right on the English page.

**P1 — fix soon, real violations on live, shared chrome:**
3. Consolidate the three skip-link implementations (Patterns §4) into one, using `inset-inline-start`.
4. Fix the ~25 genuinely asymmetric `left:`/`right:` positioning hits and the 28 `text-align:right/left` instances in `chapters.css` and `ea-atoms.css` (§2.1, §2.2) — mechanical, low-risk find/replace to logical equivalents (`inset-inline-*`, `text-align:start/end`). Do the nav dropdown (`.nav__sub`) first since Section 5.6 of the standard calls out dropdowns specifically and it is the most likely to actually get used on `/en` next.
5. Add the missing justifying comments to the 7 decorative-motif exceptions (Patterns §5), or convert them to logical properties (behaviorally identical, and then no comment is even needed).

**P2 — cleanup, no live risk today:**
6. Decide whether to delete or resurrect the 6 confirmed-orphaned/likely-dead files (`services.css`, `w2-04-service.css`, `w2-10-service.css`, `w2-14e-catalog.css`, `home-front.css`, `w2-07-heritage.css`) and the 3 loaded-but-selector-dead files (`testimonials-carousel.css`, `ea-mobile-nav.css`, `ea-mobile-variants.css`). None of this is urgent for RTL correctness since none of it currently reaches a real visitor either at the network level (4 files) or the rendered-DOM level (3 files) — but it is dead weight a future developer could easily mistake for live code (as this audit itself had to spend significant effort ruling out), and 3 of the "loaded" ones cost every real page an unnecessary CSS download.
7. `theme-shell-fallback.css` is fine to leave as-is (it never reaches production), but if it is ever cleaned up, fix its `body.rtl` and skip-link hits too so a future non-parent-theme dev/CI run doesn't present a different (and inconsistent) RTL posture than production.
8. `books-v2.css`'s `background-position` exception (§2.4, line 1045) already has a comment; consider adding an explicit `[dir="ltr"]` confirming "intentionally not mirrored" so a future auditor doesn't have to re-derive that reasoning.

**Process recommendation:** the automated CI grep check in the standard's own Section 8.2 (`grep -rn --include="*.css" -E "(margin-left|margin-right|padding-left|padding-right|border-left:|border-right:)..."`) would not have caught most of what's flagged here, since it doesn't cover `text-align`, bare `left:`/`right:` positioning, or `background-position` — the three categories that actually produced real findings in this codebase. Consider extending that CI pattern to match the fuller list this audit used.
