# XVAL — mobile baseline at phone width (2026-09-19)

Independent verifier on a different engine from the builders. **Nothing was changed.** This is a measured baseline before the mobile phase, not a sign-off.

**Site:** http://eyalamit-co-il-2026.s887.upress.link  
**Theme:** `ea-tokens.css?ver=1.5.66` at start **and** at end (1.5.67 did not go live during this run).  
**Primary viewport:** 390×844, `deviceScaleFactor=3`, touch on, `pointer: coarse` asserted via `matchMedia` (`true`). Also 360×800 and 768×1024 for overflow. Desktop 1440×900 only where a C2 comparison required it.  
**Engine:** real Chrome (Puppeteer) + real `keyboard.press('Tab'|'Enter'|'Escape')`. Viewport asserted before every judgement. Each page asserted loaded (HTTP 200, 8k–HTML, known element).  
**Raw JSON:** [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/result.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/result.json) · [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/nav-followup.json](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/nav-followup.json) · shots in [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/)

Pages covered: `/` `/contact/` `/faq/` `/shop/` `/treatment/` `/about/` `/press/` `/en/` `/snoring-sleep-apnea/` `/2228-2/` (blog post) `/services/` `/thank-you/` `/courses-soon/`.

---

## M1 — horizontal overflow

Document metric at 390 / 360 / 768: **`scrollWidth === innerWidth` (0 px) on every page.** That number is not a pass.

**Trap (hidden overflow):** `/en/` only. `html` and `body` both compute `overflow-x: hidden`. Widest child is `SPAN.arcs` at **620 px** in a 390 px viewport. The page cannot scroll sideways because it was told not to. 1 element reported outside the viewport box.

**Trap (0 px metric, real boxes outside the viewport):** every chapters page. An ancestor clips; the document does not grow.

| Page | 390 `sw/iw` | trap `html/body overflow-x` | widest box | box width | elements with rect outside viewport |
|---|---|---|---|---|---|
| `/` | 390/390 | visible/visible | `DIV.testi-mq__track` | 2786.4 | 232 |
| `/contact/` | 390/390 | visible/visible | `SPAN.arcs` | 620 | 70 |
| `/faq/` | 390/390 | visible/visible | `UL.ea-faq-toc__list` | 2139.8 | 98 |
| `/shop/` | 390/390 | visible/visible | `SPAN.arcs` | 620 | 69 |
| `/treatment/` | 390/390 | visible/visible | `DIV.testi-mq__track` | 2438.7 | 207 |
| `/about/` | 390/390 | visible/visible | `#page` | 390 | 100 |
| `/press/` | 390/390 | visible/visible | `SPAN.ea-breath-divider__line` | 404.7 | 101 |
| `/en/` | 390/390 | **hidden/hidden** | `SPAN.arcs` | 620 | 1 |
| `/snoring-sleep-apnea/` | 390/390 | visible/visible | `SPAN.arcs` | 620 | 72 |
| `/2228-2/` | 390/390 | visible/visible | `SPAN.arcs` | 620 | 69 |
| `/services/` `/thank-you/` `/courses-soon/` | 390/390 | visible/visible | GP `#masthead` | 390 | **0** |

Same pattern at 360 and 768 (home track grows to 4386 px at 768; FAQ chip list stays 2139.8). Parent-theme pages are the only ones whose *boxes* stay inside the viewport.

The 2786 px testimonials track and the 2139 px FAQ chip row are the two that matter: the first is a horizontal marquee (contained, not a user scrollbar); the second is a focusable chip row that hangs off the left in RTL (see M4b).

---

## M2 — type scale at phone width

**Confirmed live:** none of the twelve `--fs-*` tokens are re-declared in a media query, and they compute to the **same pixel size at 390 and at 1440**. Root is 16 px at both. `--fs-h1` is **44.2 px** at both.

| token | 390 px | 1440 px | Δ |
|---|---|---|---|
| `--fs-h1` | 44.2 (`2.7625rem`) | 44.2 | 0 |
| `--fs-display` | 34 | 34 | 0 |
| `--fs-h2` | 24.65 | 24.65 | 0 |
| `--fs-h4` | 21.25 | 21.25 | 0 |
| `--fs-lead` | 19.55 | 19.55 | 0 |
| `--fs-h3` | 18.7 | 18.7 | 0 |
| `--fs-nav` | 18.36 | 18.36 | 0 |
| `--fs-body` | 17 | 17 | 0 |
| `--fs-sm` | 15.3 | 15.3 | 0 |
| `--fs-xs` | 13.6 | 13.6 | 0 |
| `--fs-2xs` | 12.24 | 12.24 | 0 |
| `--fs-3xs` | 11.05 | 11.05 | 0 |

A 44.2 px H1 at 390 does **not** clip and does **not** push `scrollWidth` wide. It wraps. Line count below is `box.height / (44.2 × 1.12)` — `getClientRects()` on a block H1 returns one box, so that API is not a line count.

**Worst three at 390 (by H1 box height, all `font-size: 44.2`, no clip ancestor):**

1. **`/2228-2/`** — `H1.phero__h` box **230 × 346.5** at `l=80` (column is only 230 px). ≈ **7 lines**. The title *is* the first screen; the date sits under it; body text starts immediately. Shot: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/blogpost_390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/blogpost_390.png)
2. **`/`** — `H1.hero__h` box **310 × 247.5**. ≈ **5 lines**. Fills the hero; CTA still on the first screen at `y=673`. Shot: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/home_390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/home_390.png)
3. **`/snoring-sleep-apnea/`** — `H1.phero__h` box **294 × 247.5**. ≈ **5 lines**. Lead is then covered by the WhatsApp float. Shot: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/snoring_390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/snoring_390.png)

Short titles (`צור קשר`, `שאלות נפוצות`, `Eyal Amit`, `אודות אייל עמית`) stay one line at 44.2 and are fine. `/press/` is the exception that already leaves the scale: `H1.ea-edhero__title` computes **24.65 px** (`--fs-h2`) via `ea-blog.css`. Parent-theme titles (`/services/` `/thank-you/` `/courses-soon/`) are 44.2 on `h1.entry-title` and wrap 1–2 lines in a 330 px column.

---

## M3 — touch targets at 390

Interactive set = `a[href], button, input, select, textarea, summary, [role=button|link], [tabindex]:not(-1)`, excluding `display:none` / `visibility:hidden` / 0×0.

**Under 24×24 (WCAG 2.2 AA floor) — site-wide classes:**

| What | Size | Pages |
|---|---|---|
| Footer column links (`טיפול בדיג׳רידו` …) | **125 × 21.1** | every chapters page |
| Testimonial name links `A.tmq__nl` | **~80–110 × 19** | `/`, `/treatment/` |
| Press testimonial names | **53.3 × 18.3** | `/press/` |
| Parent-theme WhatsApp float | **105.6 × 19** | `/services/` `/thank-you/` `/courses-soon/` |
| `A.ea-topnav__brand` | **58.3 × 20.4** | `/about/` `/press/` |
| `/en/` language pill | **50.5 × 21.1** | `/en/` |
| GP leftover skip `A.screen-reader-text.skip-link` | **1 × 1** | `/about/` `/press/` + parent-theme pages |
| Courses purchase button | **161.2 × 20** | `/courses-soon/` |

**Under 44×44 but ≥24 (not AA-min, fails the 44 CSS-px mobile target):**

- Chapters burger `.nav__burger` **42 × 42** on `/` `/contact/` `/faq/` `/shop/` `/treatment/` `/snoring-sleep-apnea/` `/2228-2/`
- Brand mark `.nav__b` **40 × 40**
- EN `.nav__en` **45.7 × 35**
- Sound `#soundtg` **74.6 × 34.3**
- Skip `.ea-skiplink` **84.2 × 37.1**
- FAQ chips `.ea-faq-toc__link` **~110–147 × 30.9**
- `ea-mnav-*` taps on `/about/` `/press/` **are 44 × 44** (the one header that already meets 44)

Adjacent gaps: footer column links sit **11 px** apart vertically (21.1-tall targets + 11 px < 24). FAQ chips sit in a single row with **0 px** horizontal gap between neighbours that share the row.

`ea-mnav` drawer links (when that drawer exists) are 50 px tall — they pass size and fail reachability while closed (M6).

---

## M4 — the three 2026-09-18 defects

Real Tab. First Tab always left `BODY`. 390×844 asserted.

### 4a. Header Tab order vs visual RTL — **STILL THERE**

On `/` `/contact/` `/faq/` `/shop/` at 390, visual RTL of the bar is **brand (right, x≈306) → שמע (x≈188) → EN (x≈130) → burger (far left, x=44)**.

Measured Tab:

| stop | `/` | x |
|---|---|---|
| 1 | skip `.ea-skiplink` | 293.8 |
| 2 | brand `.nav__b` | 306 |
| 3 | **burger `.nav__burger`** | **44** |
| 4 | sound `#soundtg` | 187.5 |
| 5 | EN `.nav__en` | 129.9 |

After the brand, Tab jumps to the left edge, then back right. Same burger-breaks-the-sequence on `/contact/` `/faq/` `/shop/` (those three have no sound control; Tab 3 = burger, Tab 4 = EN).

At **1440×900** the burger is not in the sequence. Tab is skip → brand → first desktop dropdown (`טיפול בדיג׳רידו` at x=1137). Viewport-specific. Unchanged from C2.

`/about/` `/press/` use the other header. Visual RTL is brand (x=308) → EN (x=148) → שמע (x=76) → burger (x=24). Tab is skip → GP leftover skip → brand → **burger → שמע → EN**. Same class of contradiction; then Tab continues into the closed off-canvas drawer (M6).

### 4b. Focus while off-screen — **STILL THERE** (FAQ chips). Peek CTA still focuses below the fold.

**FAQ chips, `/faq/` @390.** Real Tab stops 6–21 are `.ea-faq-toc__link`. Five of them take focus with `left < 0`:

| stop | text | `left` | px outside (left) |
|---|---|---|---|
| 8 | סאונד הילינג בדיג'רידו | −69.0 | **69.0** |
| 12 | סטנדים לאחסון דיג'רידו | −32.7 | 32.7 |
| 14 | תיקון וחידוש דיג'רידו | −26.6 | 26.6 |
| 17 | כושי בלאנטיס | −60.9 | 60.9 |
| 20 | סדנאות דיג'רידו | −64.7 | 64.7 |

C2 had six chips, max 87.5 px. I measured **five**, max **69.0 px**. Same defect, slightly different inventory. The row itself is 2139.8 px wide (M1). Shot of the first-screen chips hanging off the left: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/faq_390.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/faq_390.png)

**Home `#peek`.** Stop 12 `A.btn.btn--terra` “לתיאום שיחת היכרות”, `inPeek=true`, `top=15882.4` in an 844-tall viewport, `onScreen=false`. C2’s `y=2252` is gone as a number (the page is much taller now); a peek CTA still receives focus while fully below the fold. I could not prove headless Chrome’s scroll-into-view matches iPhone Safari — treat the **horizontal** FAQ chips as the unambiguous half of this finding. Below-fold focus without scroll was also true of contact form fields and shop cards in the same harness.

`/contact/` `/shop/`: no horizontally off-screen focused control. Same as C2.

### 4c. 200% text, burger/EN 100+ px outside, overflow still 0 — **split**

Specified method (M5): **double the root font size**, not page zoom.

| condition | root | `scrollWidth` | burger `left` | EN `left` | overflow-x |
|---|---|---|---|---|---|
| 100% text | 16 | 390 (0) | 44 | 129.9 | visible |
| **root 200%** | **32** | **390 (0)** | **44 (in)** | **109.8 (in)** | visible |
| CSS `zoom:2` (C2’s actual 100+ px method) | 16 | 390 (0) | **−86.5 (86.5 outside)** | **−42.5 (42.5 outside)** | visible |

Under **text-only resize, the burger and EN do not leave the viewport.** The 100+ px claim does **not** reproduce that way. Under **CSS `zoom:2`** they still leave, overflow still reads 0, but the distances are **86.5 / 42.5**, not C2’s 151.6 / 107.6. Same defect class, smaller number, and it is zoom, not text resize.

What *does* break at root 200% is M5.

---

## M5 — text-only resize 200% at 390

Root 16 → 32 on every page. `--fs-h1` becomes **88.4 px**. Document overflow stays **0 px** everywhere, including `/en/` (still `hidden/hidden`).

What breaks:

- **Home hero is consumed.** H1 box 329 × **990**. CTA and lead leave the first screen. Trust line sits under the header. Shot: [file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/home_390_text200.png](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/tmp/qa/mobile-baseline/screenshots/home_390_text200.png)
- **`/2228-2/` H1 becomes 230 × 1485.** One title, more than a viewport and a half.
- **`/snoring-sleep-apnea/` H1 becomes 294 × 792.**
- **`/faq/` `/treatment/` H1 at `top=0`, height 198** — the page title sits in the nav’s box. `/contact/` H1 at `top=46.2`.
- Skip link at `top=−40` (already true unfocused at 100%; at 200% it is 136×58).
- Brand mark stays 40×40 (image, does not follow the root). Burger stays 42×42 (px-sized). EN grows to 61×54 and stays on-screen.
- No unexpected document scrollbar. The missing control is **vertical**: the primary CTA is no longer on the first screen, and several page titles collide with the fixed header.

The published “text can be doubled” claim is true for the tokens (they scale ×2.000) and false for the **layout around those tokens** at phone width.

---

## M6 — mobile navigation

**Two live systems. Both stylesheets are enqueued on almost every child-theme page (`ea-mobile-nav.css?ver=1.5.66` and `ea-mobile-variants.css?ver=1.5.66`). Only one of them drives a given page.** Parent-theme pages enqueue neither.

### System A — chapters `.nav__burger` (most of the site)

Present and visible on `/` `/contact/` `/faq/` `/shop/` `/treatment/` `/snoring-sleep-apnea/` `/2228-2/`. **No `#ea-mnav-drawer` in the DOM.** The enqueued `ea-mobile-nav.css` is dead weight here.

| check | result |
|---|---|
| Tab reaches burger | yes, stop 3 |
| Enter opens | yes, `data-menu=1`, `aria-expanded=true`, `body.nav-locked` |
| Tab after open enters `.nav__l` | yes, first 12 stops are drawer links |
| Escape closes | yes |
| Focus returns to burger | yes |
| Closed items in Tab order | **0 of 22** (`.nav__l` is `visibility: hidden` while closed) |
| Background inert while open | not re-probed by click on this system; `body.nav-locked` is set |

### System B — `ea-mnav` drawer (`/about/` `/press/`)

Drawer present. Closed state at 390:

- `display: flex`, `visibility: visible`, `opacity: 1`
- `transform: matrix(1,0,0,1,-335.391,0)` (parked 335 px off the left)
- **`inert` absent, `aria-hidden` null**
- 35 links/buttons, all `visibility: visible`

This is the site’s old drawer bug in a new stylesheet: **off-canvas via transform only**.

| check | `/about/` | `/press/` |
|---|---|---|
| Closed Tab hits inside `#ea-mnav-drawer` | **22 of 28** (stops 7–28) | **10 of 16** |
| First closed-drawer focus | brand at `x=−95.8`, close at `x=−311.4` | same pattern |
| Tab to burger | stop 4 | (same chrome) |
| Enter opens | yes, `ea-mnav-open`, focus moves to `.ea-mnav-close` | — |
| Tab while open stays in drawer | yes, 14/14, no `main` hit | — |
| Escape + restore | yes, back to `.ea-mnav-burger` | — |
| Background inert | **no** — `main.click()` fired while open; drawer stayed open; `body overflow` stayed `visible` (no scroll lock) | — |

### System C — parent theme (`/services/` `/thank-you/` `/courses-soon/`)

GeneratePress `.menu-toggle` **55 × 60**, visible. No `ea-mobile-nav` / `ea-mobile-variants` in the head. Tokens + GP + child `style.css` only. A third chrome.

### `/en/`

LTR landing. No burger of either kind. Header is brand + `עברית →` (21.1 px tall). Both mobile CSS files are in the head and unused.

`/snoring-sleep-apnea/` showed a TOC node (`.ea-toc` / sheet). Noted; not measured. Out of scope.

---

## M7 — vertical rhythm (`--sec`)

Live token: `clamp(62px, 6.2vw, 88px)`. At 390, `6.2vw = 24.18`, so the clamp **floors at 62 px**. Measured `padding-top` of `.sec` = **62 px** on every chapters page that has `.sec`.

| page / block | pad T+B | inner content ≈ | air / content |
|---|---|---|---|
| `/` `#video` `.sec` | 62+62 | 375.5 | **0.33** (62 px each side on a 376 px block — the tightest chapters case) |
| `/` `#session` | 62+62 | 362 | 0.34 |
| `/contact/` NAP band | 62+62 | 209 | **0.59** |
| `/en/` short `.sec` | 62+62 | 277 | 0.45 |
| `/` `#what` | 62+62 | 1025 | 0.12 |
| `/snoring-sleep-apnea/` first `.sec` | 62+62 | 114 | **1.09** (62+62 on a 114 px band) |
| `/about/` `.ea-content-section` | **80+80** (not `--sec`) | 48–401 | up to **3.3** on the shortest block |
| `/press/` `.ea-section` | **120+120** (not `--sec`) | 162–3105 | 1.48 on the CTA band |

`--sec` at 62 px is large next to a short band (snoring’s 114 px block, contact NAP 209 px) and unremarkable next to a 1000 px section. `/about/` and `/press/` ignore `--sec` and use 80/120 — more air than the chapters token, on pages that already run the other nav.

---

## Prioritised list for the mobile phase (worst first)

1. **Two (plus a third) mobile navs are live.** Chapters pages run `.nav__burger`. `/about/` `/press/` run `ea-mnav`. Parent-theme pages run GeneratePress. Both child stylesheets are enqueued almost everywhere; only one drives. A mobile pass that edits one file will miss most URLs. Evidence: drawer `present:false` on 10 of 13 pages; `present:true` only on `/about/` `/press/`; `/services/` has GP `.menu-toggle` and neither sheet.

2. **Closed `ea-mnav` drawer is in the Tab order.** Transform-only hide, `visibility:visible`, `opacity:1`, no `inert`, no `aria-hidden`. 22 closed-drawer hits on `/about/`, 10 on `/press/`, first hit at `x=−96`. The chapters drawer does this correctly (`visibility:hidden`, 0 hits). Same bug this theme already shipped once.

3. **200% text-only resize at 390 destroys the first screen.** Tokens scale ×2 as promised; the hero does not. Home H1 990 px tall; blog title 1485 px; FAQ/treatment titles at `y=0` under the nav. Published statement vs this layout.

4. **Desktop type scale at phone width.** `--fs-h1` is 44.2 at 390, confirmed. Long titles wrap 5–7 lines and *are* the first viewport (`/2228-2/`, `/`, `/snoring-sleep-apnea/`). Nothing clips, nothing goes wide. The mobile phase has to decide whether that wrap is the product.

5. **FAQ topic chips are a 2139 px RTL row.** Five chips take keyboard focus while hanging 27–69 px off the left. Document overflow still 0. C2 finding, still there.

6. **Header Tab order contradicts visual RTL** on every chapters page at 390 (burger at x=44 is stop 3, after the brand at x=306). Desktop 1440 is clean. C2 finding, still there. `/about/` `/press/` have the same contradiction plus the closed-drawer leak.

7. **Touch targets under 24 px tall** are a footer-and-chrome problem, not a one-page problem: footer links 21.1, testimonial names 19, parent WhatsApp 19, about brand 20.4, EN-landing lang 21.1. Chapters burger is 42×42 (under 44). `ea-mnav` taps already meet 44.

8. **`/en/` hides overflow instead of proving there is none.** `html,body{overflow-x:hidden}`; `SPAN.arcs` is 620 px in a 390 px view.

9. **Background of the open `ea-mnav` is not inert.** `main.click()` reached the page; no body scroll lock. Focus trap works; pointer/click does not.

10. **`--sec` floors at 62 px at 390.** Fine on long sections; 62+62 on a 114 px snoring band is more air than content. `/about/` `/press/` use 80/120 and are a different rhythm.

---

## Could not measure

- OS/browser text-only zoom as a user setting (Firefox/Safari “Text only”). Used the specified method: JS double of the computed root `font-size`, reflow, re-read.
- Whether headless Chrome’s refusal to scroll a focused below-fold control matches iPhone Safari. Horizontal off-screen (FAQ chips, closed drawer) does not depend on that.
- End of `/faq/` Tab order past the summaries (walk wrapped at stop 65 inside the list).
- Full Tab / nav / 200% matrix at 360 and at 768 (overflow + type + headings only).
- Open-menu background inertness on the chapters burger (only `ea-mnav` was click-probed).
- Contrast, focus-ring visibility, or any scanner result (none used).
- The TOC sheet on `/snoring-sleep-apnea/` (seen, skipped).

No page was “passed” by a scanner. No code was changed.

**Theme at start: 1.5.66. Theme at end: 1.5.66.**
