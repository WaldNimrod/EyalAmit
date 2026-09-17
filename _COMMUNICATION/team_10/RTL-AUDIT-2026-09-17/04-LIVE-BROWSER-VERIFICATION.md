# RTL Audit — Facet 4: Live Browser Verification

**Author:** team_10 (direct investigation, not a sub-agent)
**Method:** empirical only — live computed styles, DOM probes, and cross-page (RTL vs LTR) comparison on the staging site (`eyalamit-co-il-2026.s887.upress.link`), not static code reading. This facet exists specifically to catch the class of bug static analysis structurally cannot see: cases where the *authored* CSS looks compliant (e.g. already uses a logical property) but the *rendered* result is still wrong because of an interaction with something else (an inherited parent-theme rule, a companion animation, a sibling property).
**Scope sampled:** primary nav (desktop + mobile), header icons, hero section, FAQ accordion, CTA buttons, contact form, home vs `/en/` cross-check. This is a representative sample, not exhaustive — see recommendations for what should be swept next.

---

## Finding 1 (CONFIRMED BUG) — hero "scroll down" hint points sideways, not down

**File:** `site/wp-content/themes/ea-eyalamit/assets/css/chapters.css`, lines 94–97.

```
.hero__cues{position:absolute;z-index:3;bottom:26px;left:0;right:0;display:flex;justify-content:center;gap:60px}
.hero__cues span{width:11px;height:11px;border-inline-end:1.5px solid rgba(255,255,255,.6);border-bottom:1.5px solid rgba(255,255,255,.6);transform:rotate(45deg);animation:bob 2.4s var(--e) infinite}
@keyframes bob{0%,100%{transform:rotate(45deg) translate(0,0)}50%{transform:rotate(45deg) translate(-3px,3px)}}
```

**What it is:** two small `aria-hidden` decorative chevrons at the bottom of every full-height hero section (visible on the home page hero, mobile and desktop), meant to hint "scroll down" with a gentle bounce.

**The bug:** the chevron shape is built from `border-bottom` + `border-inline-end`, rotated 45°. `border-inline-end` resolves to `border-right` in LTR and `border-left` in RTL — that part is correctly logical. But the classic "two borders + `rotate(45deg)`" technique only produces a **downward**-pointing corner when the second border is physically on the **right**. Pair the same `rotate(45deg)` with a border on the **left** instead (exactly what happens on this RTL site) and the corner points **left**, not down.

I proved this two ways, not just by reasoning about it:
1. **Geometry:** the bottom-right vertex sits at 45° below horizontal; rotating +45° (clockwise) brings it to 90° = straight down. The bottom-left vertex sits at 135°; rotating the *same* +45° brings it to 180° = straight left. Confirmed via `getComputedStyle` that `border-inline-end` resolves to `border-left` on this page (`direction: rtl`).
2. **Visual reproduction:** I built an isolated probe on the live page with the exact same CSS (`border-inline-end` + `border-bottom` + `rotate(45deg) scale(10)`) and screenshotted it — the rendered shape is unambiguously a sideways "‹", not a "⌄". (Screenshot taken during this session; not attached to this file, but reproducible by anyone by pasting the probe CSS into devtools on any page of this site.)

The companion animation makes it worse, not better: `translate(-3px,3px)` (bounce down-and-left) was tuned to look like "nudging further in the direction it points" for a *down*-pointing chevron. On the actual RTL-rendered *left*-pointing chevron, the bounce now reads as unrelated diagonal motion instead of "nudging toward its own tip."

**User-visible effect:** on every page with this hero pattern (confirmed on the home page; likely wherever the same hero markup/section is reused — check reachability the same way Facet 2 checked template reachability), Hebrew visitors see a sideways-flicking mark at the bottom of the hero instead of a "scroll down" cue. Low severity (decorative, `aria-hidden`, doesn't block anything) but visibly broken once you know to look, and exactly the kind of small polish detail a client notices.

**Why a plain grep wouldn't have caught this:** `border-inline-end` *is* the standard-compliant, logical property — a naive "flag any border-left/border-right" sweep would call this file clean. The bug isn't the property choice, it's that the *shape*, which was arguably a bad candidate for a logical property in the first place, and the *rotation/translate values* it's paired with weren't updated to match.

**Recommended fix — and the more important, general lesson:** a "scroll down" affordance has no reading-direction semantics at all; it should look identical in Hebrew and English. That makes it a case for the standard's own *documented exception* category (decorative, direction-agnostic shapes), not for logical properties. Simplest correct fix: revert to a fixed physical pairing that always points down regardless of `dir` —
```
.hero__cues span{border-right:1.5px solid rgba(255,255,255,.6);border-bottom:1.5px solid rgba(255,255,255,.6);transform:rotate(45deg);...}
```
(no `[dir]` override needed, because the intent is direction-invariant). The alternative — keep `border-inline-end` and add a `[dir="rtl"]` override that flips both the static rotation and the keyframe's translate sign — works too but is more code for a purely decorative element with no actual direction meaning.

**Pattern worth generalizing:** anywhere a border-trick shape or CSS transform encodes a *fixed* visual meaning that has nothing to do with text flow (scroll-down hints, loading spinners, decorative corner marks), using a logical property is not automatically "more correct" — it can introduce a bug where none existed. Logical properties belong on things that should track reading direction (accents next to text, icon spacing, alignment); direction-invariant decoration should stay physical and constant.

---

## Finding 2 (low-priority, latent — not currently live) — form fields hardcode `text-align:right` in a shared stylesheet

**File:** `site/wp-content/themes/ea-eyalamit/assets/css/ea-atoms.css` — `text-align: right` appears roughly a dozen times (lines checked include 59, 478, 489, 500, 506, 731, 1098, 1122, 1207, 1222, 1279, 1298), including the Contact Form 7 field rules (`.ea-contact-form--cf7 .wpcf7-form-control...`, around line 1279–1298).

**Why it's not an active bug today:** I checked whether anything on the site's one LTR page (`/en/`) actually reuses these shared "atom" classes. It doesn't — `/en/` is a minimal 6-link landing page with no `<form>` at all (confirmed via live DOM query), so nothing currently renders this CSS in an LTR context. Right now, `text-align:right` and the logically-correct `text-align:end` produce the exact same visual result on every page that actually uses this stylesheet, because every one of those pages is RTL.

**Why it's still worth fixing now rather than later:** `ea-atoms.css` is a shared, sitewide base stylesheet (its own name says "atoms" — base components), not a Hebrew-only file. If an English contact form, or any other LTR page, is ever built reusing `.wpcf7-form-control` or the other atom classes this touches, every one of these rules would silently right-align LTR text the day that page ships — a "worked in every test because no one tested the language it breaks" bug. Converting these dozen instances to `text-align:end` (or `:start`, per case) costs nothing today (identical rendering) and removes a foot-gun for whoever builds the next English page.

**Recommendation:** low priority relative to Finding 1, but cheap — worth batching into whatever CSS cleanup pass addresses Facet 1's findings, specifically flagged as "safe to convert with zero visual risk" since it's provably not live on any LTR page today.

---

## Confirmed-safe patterns (no action needed — kept here so the CSS/JS audits don't re-flag them as false positives, and as reference examples of "done right")

- **Primary nav dropdown toggles** (`▾`, U+25BE, a down-pointing triangle) — not a Bidi_Mirrored character (only left/right-implying glyphs like ‹ › ← → mirror; a vertical triangle has no horizontal mirror counterpart), so it renders identically in RTL and LTR. No `direction:ltr` wrapper needed, and none is present — correct.
- **Header volume/"שמע" icon** — a universal speaker-icon convention. Checked its computed `transform`: `none`. Correctly *not* mirrored, per the standard's own rule that only direction-of-movement icons should flip.
- **FAQ accordion expand/collapse icon** (`.dd__ic`, in the `<details>/<summary>` pattern used across FAQ sections) — state change is driven by a 135° *rotation* (a "+" rotating to look like "×"), not a left/right mirror or position swap. Rotation-based state icons are direction-agnostic by construction; this is a correct, reusable pattern worth pointing to as a model for any other expand/collapse UI in the theme.
- **CTA buttons** (e.g. "לתיאום שיחת היכרות") — plain text, no directional icon, nothing to mis-mirror.

## Design observation (owner decision, not a code defect)

- The mobile hamburger menu icon sits at the **top-left** corner of the header, opposite the top-right logo/brand mark. Some RTL sites deliberately mirror this (hamburger at top-right, matching the logo's corner), others keep it in the universally-expected top-left corner regardless of language (arguably why it's colloquially always drawn as 3 left-aligned bars). Both are legitimate, common choices — flagging only so this is a conscious decision rather than an unnoticed default. No fix suggested; needs an owner call, not a code change.

## Checked, not applicable — currency/shekel bidi handling (standard §4.3)

The standard specifically calls out shekel-sign placement as a common RTL bug (₪ is a Unicode-neutral character that can attach to the wrong side of a number without an explicit `dir="ltr"` wrapper). I checked `/shop/` and `/books/` (the two listing pages most likely to show prices) for any `₪` character in the rendered text — found none on either page. This site appears to run on a lead-generation model (every product/service page ends in a "coordinate a call" CTA, not a price + add-to-cart), so this rule is currently **not applicable** rather than passing or failing. Flagging so it isn't silently skipped: if a price ever gets added anywhere (a shop checkout, a course fee), it MUST follow §4.3 (₪ before the digits in source, whole token wrapped in `dir="ltr"`) from the start — I did not check individual product detail pages beyond the two listing pages, so this should be re-verified if/when checkout functionality is added.

## Cross-check against the CSS static audit's mobile-drawer finding

The parallel CSS static audit (see `01-CSS-STATIC-AUDIT.md`) flagged `chapters.css`'s mobile nav drawer (`.nav__l` inside the `@media(max-width:1180px)` block, line ~613) for using `transform:translateX(100%)` with no `[dir]`-aware override. I opened the live mobile menu to check what this actually looks like in practice.

**What I found on verification:** the drawer's resting positions (open and closed) are NOT visibly broken — `inset:72px 0 0 0` pins it to the full viewport width symmetrically in both states (confirmed: `left:0, right:375` at a 375px viewport, matching the viewport exactly), so there is no content-clipping or wrong-side consequence at rest. The real effect of the missing `[dir]` handling is narrower than "broken": it's that the **slide-in animation direction** doesn't get the RTL-appropriate treatment the standard's §5.4 calls for (drawers should visually open from the reading-end side) — a real but purely cosmetic/motion-consistency gap, not a functional defect. Downgrading this specific finding's user-visible severity from what a static read alone would suggest, while confirming the underlying code observation is accurate.

**A separate, likely non-RTL bug found while I was in there:** several mobile submenu items (`.nav__sub a`, e.g. "נחירות ודום נשימה בשינה" under "טיפול בדיג'רידו", "כלים בעבודת יד ואביזרים" under "כלים ואביזרים") render with visibly clipped text at the left edge of the screen. Root cause, confirmed via computed styles: these links have `white-space:nowrap` inside a box too narrow for their actual text (e.g. a 95px-wide box for text that needs much more), and the overflow — which paints leftward from the RTL-anchored right edge — gets clipped because the parent `.nav__l` sets `overflow-y:auto`, which per the CSS spec forces the paired `overflow-x` to compute to `auto` as well (confirmed: `overflow-x: auto` even though only `overflow-y` was authored), clipping anything that overflows past the container's edge instead of letting it wrap. This reproduces the same way regardless of `dir` — it's a "box too narrow for nowrap text" layout bug, not a mirroring/logical-property issue, so I'm flagging it here for visibility rather than folding it into the RTL findings above. Recommend a separate follow-up ticket (likely fix: drop `white-space:nowrap` on `.nav__sub a` so long labels wrap instead of overflowing).

## What this facet did not cover (recommended next sweep)

Given time, I sampled the highest-traffic surfaces (home hero, nav, FAQ, one contact form) rather than every page. Not yet checked live in-browser: the blog listing/single post templates, the shop/product pages, the books pages, and the mokesh/tsva-bekahol/vekatavta one-off landing pages — these are architecturally distinct enough (different template families per the Wave2/Chapters split) that they're worth their own pass rather than assuming this sample generalizes.
