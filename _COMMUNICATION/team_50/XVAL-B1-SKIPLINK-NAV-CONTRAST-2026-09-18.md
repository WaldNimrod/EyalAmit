Independent live check of `/` only. Nothing was changed. I did not run an accessibility scanner.

Site: [http://eyalamit-co-il-2026.s887.upress.link/](http://eyalamit-co-il-2026.s887.upress.link/)  
Viewport asserted **1440×900** (non-zero) before any ratio. Rendered DOM **78,210** bytes, title `בית - eyal amit`, `.ea-skiplink` + `.hero` + `#main` present (HTTP 200). Staging TLS ignored by design.

Method (all of this is measured unless marked otherwise): Chrome via puppeteer-core; real `Tab` / `Enter` / `Space`; **800 ms settle** after every key; **no** `element.focus()` on targets; **no** CSS injection. Foreground = `getComputedStyle.color` after settle. Background = **painted-pixel sample** of the on-screen clip (Python/PIL median of inset pixels, not an ancestor `backgroundColor` walk). Raw JSON: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/b1-xval.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/b1-xval.json).

At load: `scrollY=0`, `nav[data-s]="0"`. The header sits on a **gradient over a photograph**. Walking ancestors from `.nav__b` / `.nav__en` hits `BODY` `rgb(255,255,250)` after skipping that gradient — I did not use that colour.

---

## 1. Skip link — `a.ea-skiplink` (`href="#main"`, text `דלג לתוכן`)

Live class is `.ea-skiplink`. `.ea-skip-link` is **absent** from the delivered HTML.

| State | Ratio | FG | BG | How BG | Threshold | Selector |
|---|---:|---|---|---|---:|---|
| Unfocused | **5.67:1** | `rgb(255,255,255)` | `rgb(164,78,43)` | **Computed own** `background-color` (opaque). Element is `position:absolute; top:-40px`; clip is **off-viewport**, so pixels were **not** sampled. | **4.5:1** (14.4px / weight 300, not large text) | `a.ea-skiplink` |
| Focused (real Tab) | **5.67:1** | `rgb(255,255,255)` | `rgb(164,78,43)` | **Painted pixels** of the on-screen clip. Inset samples were flat `rgb(164,78,43)` (stdev 0). Own computed bg matches. | **4.5:1** | `a.ea-skiplink:focus` |

Unfocused skip is not visible on the page (confirmed in [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/shots-b1-xval/home-top-unfocused.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/shots-b1-xval/home-top-unfocused.png)). Focused skip is white on terracotta with a Chrome blue ring ([file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/shots-b1-xval/home-top-skip-focused.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/a11y-verify-independent/shots-b1-xval/home-top-skip-focused.png)).

Text colour did **not** collapse to `--contrast` (`#2e2b28` / `rgb(46,43,40)`). That collapse would be **2.48:1** on this fill (calculated from those two measured colours). It is not what the live page does today.

Focus indicator (computed `outline: auto 1px rgb(0,95,204)`): **1.06:1** against the painted terracotta fill. Threshold for a UI focus indicator is **3:1**. Outer adjacent colour is the hero photograph → **INDETERMINATE** if you insist on sampling the photo. The 1.06 figure is calculated from measured outline-color vs measured fill, not a ring-pixel sample.

---

## 2. First Tab, and what Enter / Space actually do

**Measured.** Fresh load, focus on `BODY`, one real `Tab`: focus moved off `BODY` onto `a.ea-skiplink`. It is the first tab stop.

**Enter** while the skip link is focused (measured, then re-measured on a second load):

- `location.hash` becomes `#main`
- `document.activeElement` becomes `main#main.chapters-main` (`tabindex="-1"`)
- `scrollY` stays **0**
- `#main`’s `getBoundingClientRect().top` is already **0** at load (the landmark starts at the hero, under the fixed nav)
- Nav is **outside** `#main` (skip → `nav#nav` → `main#main` in source order)

So focus **does** move into the main landmark. The viewport **does not scroll**, because that landmark is already at y=0.

Next real `Tab` after that Enter (measured): focus goes to `a.btn.btn--terra` “לתיאום שיחת היכרות” inside `#main`, **not** back into `.nav`. Keyboard skip of the nav works; visual scroll does not happen.

**Space** while the skip link is focused (measured, separate load):

- Hash stays empty
- Focus **stays** on `a.ea-skiplink`
- `scrollY` becomes **860** (page scrolled; skip is `position:fixed` so it remains on screen)
- Space did **not** activate the link

---

## 3. Language toggle — `a.nav__en`

| State | Ratio | FG | BG | How BG | Threshold | Selector |
|---|---:|---|---|---|---:|---|
| Unfocused | **13.10:1** | `rgba(255,255,255,0.85)` | painted `rgb(24,23,20)` | Painted-pixel inset median of the control clip at `scrollY=0` / `data-s=0`. Own bg is transparent; first opaque computed ancestor is BODY ivory **behind a gradient** — not used. | **4.5:1** (11.52px / 300) | `a.nav__en` |
| Focused (Tab stop 32) | **17.38:1** | `rgb(255,255,255)` | painted `rgb(30,26,12)` | Same painted-pixel method, after 800 ms. Colour stayed white, not `#2e2b28`. | **4.5:1** | `a.nav__en` |

Focus ring: computed `outline auto 1px rgb(0,95,204)`. Against the focused painted clip median `rgb(30,26,12)` that is **2.90:1** (calculated; 3:1 threshold for a focus indicator). Against the unfocused clip median it is exactly **3.00:1**.

**Disagreement with** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/01-DONE-FOCUS-CONTRAST.md](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/01-DONE-FOCUS-CONTRAST.md): they report unfocused **13.83** and focused **19.15** on a scrolled `data-s="1"` solid nav (`rgba(20,14,9,.95)`). Those are not the rest-state home numbers. Mine are painted pixels at `scrollY=0`.

---

## 4. Brand / logo — `a.nav__b` (visible text in `a.nav__b b`)

Unfocused **INDETERMINATE**. Own background is transparent. Effective background is the nav gradient over the hero photograph. Painted clip of `a.nav__b` (includes the logo mark): inset luminance spread too high for one ratio (stdev 0.0406, spread 0.136). Diagnostic only, **not** a declared ratio: inset samples of white vs that clip ranged **5.44–18.54:1** (median 11.49:1 on `rgb(53,60,39)`). Threshold that would apply to the 18px / 300 text is **4.5:1**. Selector: `a.nav__b`.

A walker that took BODY `rgb(255,255,250)` would print a fake near-1:1 or a fake 21:1 depending on compositing. That walk is wrong here.

Focused (Tab stop 2): **15.19:1**, FG `rgb(255,255,255)`, painted BG `rgb(48,35,28)`, painted-pixel inset median, still at `scrollY=0`. Colour stayed white. Threshold **4.5:1**. Selector `a.nav__b`. Inset range on that focused clip 8.20–17.91:1; sampler called it flat enough (stdev 0.025).

Focus ring vs painted focused fill `rgb(48,35,28)`: **2.54:1** (calculated; 3:1 threshold). Outer adjacent is still photograph → INDETERMINATE.

**Disagreement:** team_10’s 19.15/19.15 assumes the scrolled solid nav. I will not adopt that number for the live home rest state.

---

## 5. Primary CTAs in the first two visual blocks

What I treated as the first two blocks, from geometry at `scrollY=0`:

1. `header.hero` — 100vh (0–900)
2. `section#what` — 900–1761.83

`section#video` starts at 1761.83; that is the third block.

**Only one** `a.btn` intersects that region: the hero button.

| Control | Unfocused | Focused (real Tab stop 33) |
|---|---|---|
| `a.btn.btn--terra` href `/contact/` “לתיאום שיחת היכרות” | **4.63:1** `rgb(255,255,255)` on painted **and** computed `rgb(176,95,56)` (opaque self fill; pixels matched) | **4.63:1** same pair. Colour stayed white. |

Font 13.12px / 500 → threshold **4.5:1**. Margin above the threshold is **0.13**. Selector: `a.btn.btn--terra`.

Focus indicator: computed `outline: 2px solid rgb(208,138,94)` / offset 3px. Against the button fill that is **1.65:1** (calculated; 3:1 threshold). The offset puts part of the ring on the photograph → that side is **INDETERMINATE**.

There is **no** `.btn--gw` (or any other `.btn`) in hero + `#what`. The first ghost button in the DOM is in `#compare` (top 3563, below `#video`). Tab stop 34 did land on that out-of-scope ghost after the browser scrolled to `scrollY=3110`; I am **not** counting it as an in-scope CTA. Its focused screenshot also threw `Cannot take screenshot with 0 height` despite a 58px clip — **COULD NOT MEASURE** that out-of-scope control.

---

## What I could not measure, and why

- **Skip unfocused, painted:** off-viewport (`top: -40px`). Computed-only 5.67:1.
- **Brand unfocused, single ratio:** photograph + gradient. INDETERMINATE.
- **Any nav/brand/lang ratio that needs a flat computed ancestor at `scrollY=0`:** the first opaque computed colour is BODY ivory behind a gradient. I refused that walk.
- **Focus-indicator contrast against the photograph:** INDETERMINATE (not a flat colour).
- **`.btn--gw` in-scope:** does not exist in the first two blocks.
- **Simulated `:focus` without Tab:** not attempted; first Tab did leave `BODY`, so the keyboard path is real.

---

## Claims I could falsify vs claims I could not

Live CSS `?ver=1.5.39` already contains `color:#fff` on `.ea-skiplink:focus`, `.nav__en:focus`, `.nav__b:focus`, `.btn--terra:focus-visible`. GeneratePress’s `a:focus{color:var(--contrast)}` is still in the inline block; `--contrast` computes to `#2e2b28` on this page. **On today’s live home page the text-colour collapse is not happening** on the skip link, EN control, brand link, or in-scope terra CTA. A claim that those four still go to 2.48 / ~1.36 on focus is **false on this host, this date, this page**.

A claim that EN/brand focused contrast is **19.15:1** on the unscrolled home header is **false** as a rest-state painted measurement (I get 17.38 and 15.19). Their 19.15 is a different background condition (scrolled solid nav, computed fill).

Skip text 5.67/5.67 and terra 4.63/4.63 **match** team_10’s “fixed” column. I am not treating that match as a pass of their process — it is just the same two numbers from a different engine on the now-deployed CSS.

I did not reconcilе toward the repo. Where a walker, a scrolled nav, or a CSS comment disagrees with a painted rest-state reading, the painted rest-state reading is the one above.
