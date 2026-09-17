# Standards Compliance Scorecard

Scored against `_aos/lean-kit/modules/standards-conventions/rtl-bidi/RTL_BIDI_STANDARD_v1.0.0.md` (AOS Module 11), Section 8.1's pre-commit checklist — the standard's own definition of "done." Each row's evidence points into the four facet reports (`01`–`04`) rather than repeating their detail here.

Legend: **PASS** (no violation found) · **FAIL** (confirmed violation exists) · **PARTIAL** (mixed — some correct instances, some not) · **N/A** (the situation this rule guards against doesn't currently exist on this site) · **N/T** (not tested this round)

## HTML

| Checklist item | Verdict | Evidence |
|---|---|---|
| `<html>` has correct `lang` (BCP 47) | PARTIAL | Confirmed `lang="he-IL"` on the home page (Facet 4, live check). Not re-checked on `/en/` or every other route — spot-checked, not exhaustive. |
| `<html>` has `dir="rtl"` for RTL pages | PASS | Confirmed live on home page; `/en/` correctly reports `dir="ltr"` (Facet 4). |
| User-input fields with unknown-direction text have `dir="auto"` | **FAIL** | Contact form's name/phone/email/subject/message fields carry no `dir="auto"` — they only inherit `dir="rtl"` from the page (Facet 4, live DOM check). Low severity: a Hebrew visitor typing an English name would still see it typed correctly left-to-right within the field either way in every modern browser; `dir="auto"` is the belt-and-suspenders form the standard asks for, not a currently-visible defect. |
| Unknown-direction inline content wrapped in `<bdi>`/`dir="auto"` | N/T | No dynamic user-generated content (e.g. a "Welcome back, {name}" string) was found in the audited scope to test this against. |
| Known-LTR islands (`tel:`, code, product codes) get explicit `dir="ltr"` | PASS | Every phone-number link in scope correctly wrapped, consistently (Facet 2). |
| Price/currency tokens wrapped in `dir="ltr"`, ₪ before digits | N/A | No live price display exists anywhere checked (`/shop/`, `/books/` listings) — this site runs a lead-generation model, not visible pricing (Facet 4). Must be re-verified the day a price is ever added. |

## CSS

| Checklist item | Verdict | Evidence |
|---|---|---|
| No `margin-left`/`margin-right` | PASS | Zero hits across all 20 CSS files (Facet 1). |
| No `padding-left`/`padding-right` | PASS | Zero hits across all 20 CSS files (Facet 1). |
| No `left:`/`right:` for positioned elements | **FAIL** | ~25 genuinely asymmetric hits across `chapters.css`/`ea-atoms.css` (Facet 1); the mobile nav drawer is the one live *interactive* instance, the rest are dropdowns, badges, captions, skip-links. |
| No `text-align:left`/`right` | **FAIL** | 28 code instances across 6 files (Facet 1), plus the contact-form fields (Facet 4) and an inconsistent `.foot__brand` rule that flips by viewport width rather than logic (Facet 1). Highest-count, cheapest-to-fix category in the whole audit. |
| No `border-left`/`border-right` for semantic borders | PASS (as of tonight) | Exactly one hit in the entire theme, and it's tonight's already-fixed testimonial border (Facet 1). |
| Physical properties used only for justified exceptions, each with a comment | **FAIL** | 7 decorative background motifs use unexplained physical offsets (Facet 1); the hero scroll-hint chevron is the sharpest example of this rule's purpose — an exception-worthy decorative element that was handled *inconsistently* (one logical property, one hardcoded companion value) rather than either fully physical-and-commented or fully direction-aware (Facet 4). |
| `[dir="rtl"]` overrides used for the no-logical-equivalent cases (transforms, gradients, box-shadow, pseudo-elements) | **Architecturally not applicable in the form the standard assumes** | The standard's worked examples (§2.3, §6.1) assume a single codebase serving both directions via `[dir]` switching. This theme instead hardcodes RTL as the default everywhere and fights `/en/` with inline per-element patches (see `00-MAPPING.md` §2) — zero `[dir="rtl"]` selectors exist in `chapters.css` at all (Facet 1). Where a `[dir]`-based override *does* exist (`ea-atoms.css`'s `.ea-topnav__submenu`, `ea-mobile-nav.css`'s drawer), it's correctly built as the standard prescribes — the pattern isn't unknown to whoever wrote those, it's just not applied consistently sitewide. |

## JavaScript

| Checklist item | Verdict | Evidence |
|---|---|---|
| Direction read via `document.dir`, not `documentElement.dir` | PARTIAL | Only one file reads direction at runtime at all (`ea-mobile-nav.js`, currently dead code) and it uses the non-canonical form — cosmetic, zero behavioral difference (Facet 3). |
| No hardcoded `'left'`/`'right'` strings in positioning logic | PARTIAL | 3 instances found, all symmetric/benign in their current use (Facet 3) — none is a live bug, but none should be copied from either. |
| Dynamic content injection wraps unknown-direction text | N/T | No dynamic HTML-injection call sites matching this pattern were found in the audited JS. |
| Portal components independently apply direction | N/A | This theme has no portal-style components (modals rendered to `document.body` outside their DOM parent) — not a React/MUI codebase; the standard's own portal guidance targets that stack specifically. |
| Date/price/number formatting uses `Intl` with `he-IL` | N/T | No date/number-formatting JS was encountered in the audited scope. |

## Icons (Standard §5.5 — mirror direction-of-movement only)

| Checklist item | Verdict | Evidence |
|---|---|---|
| Directional SVG icons get `[dir="rtl"]{transform:scaleX(-1)}` | N/A | This theme has zero SVG icons that would need this — every arrow-like affordance in the theme is either a literal Unicode character (a *different* bug class, see below) or a fixed non-directional path (link-out icon, social logos). No SVG anywhere is transform-mirrored, correctly, because none needs to be (Facet 2). |
| Universal icons (checkmark, play, close) carry no mirroring override | PASS | Confirmed — zero blanket-mirroring rules exist anywhere in the theme's CSS or PHP (Facet 2, exhaustive supplementary grep). |

## Bidi text handling (Standard §4 — related but distinct from the icon-mirroring rule above)

This is the codebase's actual weak spot, and it's worth scoring separately from the SVG-icon checklist above because it's a different mechanism (a literal Unicode character bidi-mirroring inside a text run, not a deliberately-applied CSS transform on an icon):

| Location | Verdict |
|---|---|
| Testimonial carousel `›`/`‹` buttons | **PASS — fixed tonight**, `direction:ltr` correctly stops the mirroring (Facet 2, re-verified against live CSS). |
| `bookcard.php`'s `←` CTA hint (`/books/`, `/shop/`, `/qr/`) | **FAIL — live, unmitigated** (Facet 2, Finding 2.1). |
| Hero `.hero__cues` scroll hint | **FAIL — live, unmitigated**, though this is a shape/rotation bug rather than a bidi-mirroring bug specifically (Facet 4) — related family, different mechanism. |
| `block-topnav.php`'s `↗`, `block-contact-cta.php`'s `↙` | **Indeterminate** — pending the one open reachability question in `00-MAPPING.md` §4. |
| `block-testimonials-carousel.php`/`-row.php`'s `↗` | FAIL on paper, but on confirmed-dead code — moot. |

**Pattern:** every one of these is the identical root mechanism (Facet 2's Pattern #2): a literal directional Unicode character typed into a Hebrew string with no bidi isolation. The one place in the codebase that renders the same *concept* (an external-link/CTA hint) via an actual SVG path instead of a Unicode glyph has zero exposure to this bug class by construction. This is the single most actionable, cheapest structural recommendation in the whole audit: prefer a small inline SVG over a typed arrow character for any future hint/CTA, and treat "no bare directional Unicode in a Hebrew-adjacent string" as a lint-able rule (mirroring the standard's own §8.2 suggestion, extended from CSS properties to text glyphs).

---

## One-paragraph read

The codebase is **not undisciplined** — the places that got explicit attention (phone numbers, the testimonials carousel after tonight's fix, the SVG icon set, the one existing `[dir]`-based dropdown override, `ea-mobile-nav.js`'s dormant drawer math) are done correctly and in some cases better than the standard's own worked examples. The gaps cluster in two shapes: (1) a large but mechanical backlog of `text-align`/`left`/`right` physical properties that were never wrong-looking *because the site has effectively one direction in practice*, and (2) a handful of literal Unicode arrow characters dropped into Hebrew strings with no bidi isolation — the exact bug class that caused tonight's original incident, now found live in three more places (`/books/`, `/shop/`, `/qr/`) and once more in a rotation/shape form (the hero hint). Neither gap is a sign the team doesn't know the rules; both are the predictable result of building against one direction for a long time with no `/en/`-scale pressure-testing yet.
