---
id: RESEARCH_S007_RESPONSIVE_MOBILE_2026-09-18_v1.0.0
type: RESEARCH (team_100 research line → team_100 / team_10)
recorded_by: team_100 (research line)
date: 2026-09-18
status: RESEARCH COMPLETE — mapping (team_10) can start from this
source_task: `_COMMUNICATION/team_100/S006/TASK-S007-RESPONSIVE-MOBILE-2026-09-18.md`
---

> ⚠ **HISTORICAL — not the current state.** Typography and CSS sizing are governed by
> `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`, locked at theme 1.5.56. Numbers in
> this file were true when it was written. **Do not act on a font-size figure from here**
> without checking the canon first — §7 there lists the specific figures that are dead.
> Kept because the measurements and the method are still useful; the conclusions are not.

# Research — responsiveness and mobile design accuracy (S007)

## 0. What this document is and is not

This is research, not an audit. **No file under `site/` was changed to produce it.** Its job is
to make the next line's full mapping sharp instead of vague: what is already known (so it is
not rediscovered), what "good on a phone" actually breaks down into as measurable checks, what
tooling exists and what its blind spots are, which pages actually need visiting and why, which
traps have already produced false answers on this project, and what shape the final report
needs so team_00 can discuss it and approve a correction plan.

To ground this research I did three small things beyond reading: (1) re-verified every
`file:line` citation carried forward from the RTL/accessibility audits against the **current**
working tree, because line numbers shifted under tonight's accessibility fixes (see §1.4) —
several citations below differ from the source reports for exactly this reason; (2) ran the
repo's own `qa_probe.mjs` against 5 representative pages at 2 viewports, live, to confirm the
tool chain works end-to-end today and to get one real data point (§3.1); (3) opened two of the
resulting screenshots to check they were actually usable evidence, which surfaced a new trap
(§5). I did **not** audit the other ~85 pages, measure any of §2's dimensions systematically, or
take the screenshot set the mapping needs — that is explicitly the next line's job
(`TASK-S007-RESPONSIVE-MOBILE-2026-09-18.md:47-49`), and duplicating it here wastes the budget
the owner asked to protect.

The owner's own words, restated because they are the bar everything below has to serve:
**not** "the code is valid," but whether the site "looks right, reads well, and is genuinely
pleasant on a phone — including where things must be made smaller and where spacing must
change" (`TASK-S007-RESPONSIVE-MOBILE-2026-09-18.md:28-32`).

---

## 1. What we already know

### 1.1 Why mobile is a separate round at all

`S006-MILESTONE-CHARTER.md:453-459`, quoted in full because it is the legal basis for
everything else in this section:

> **8ב. היקף מסך — סבבים 1 ו-2 הם דסקטופ בלבד**
> **החלטת team_00, 17.8.26, לייעול.** כל נושא **מובייל ורספונסיב** של האתר כולו עובר ל**סבב 3**.
> - סבבים 1–2: אימות ואישור **בדסקטופ בלבד**. `qa_probe --viewports desktop`.
> - ממצא מובייל שעולה תוך כדי — **נרשם לסבב 3 ולא מטופל**, אלא אם הוא שובר גם את הדסקטופ.
> - אישור אייל בסבבים 1–2 הוא אישור דסקטופ. מובייל ייבדק כיחידה אחת בסבב 3.

Concretely: every content approval Eyal has given so far (R1, R2 — the two `VERIFY-R2-*.md`
sequences, ~130 items) is a **desktop-only** approval. Nothing about his sign-off implies the
same page is acceptable on a phone. And any mobile issue anyone noticed in passing during R1/R2
was deliberately **not** fixed and was logged instead — which is exactly what §1.2 catalogues.

### 1.2 Findings already on file, logged and waiting — do not rediscover these

`_COMMUNICATION/team_100/S006/OPT-R3-REGISTER.md:1-37` is the register of what the WAIT-WAVE
optimization pass (18.8.26) measured and deliberately left for round 3. Its own conclusion
(line 7): *"אפס תיקוני CSS/JS ייעודיים. overflow 21/21 נקי. `console.error` 0/21. כל מה למטה =
סבב 3"* — i.e. a clean `qa_probe`-style desktop sweep, with everything mobile-shaped punted
here by name:

| ID | Finding | Why deferred | Relevance to S007 |
|---|---|---|---|
| OPT-R3-04 | Shared chrome (`chapters.css`, nav, footer, `ea-mobile-*`) was locked out of the WAIT-WAVE edit scope entirely | "נעול מחוץ לגל. רוב 21 העמודים רצים עליו" | **This is the file set S007 is now explicitly allowed to open.** Confirms `chapters.css`/nav/footer/`ea-mobile-*` were never touched for mobile reasons before today. |
| OPT-R3-05 | Mobile viewport, generally | "אמנה: סבב 1–2 דסקטופ בלבד" | Direct restatement of §1.1; also names `qa_probe` מובייל + `ea-mobile-*` fixes as the round-3 target — i.e. this task. |
| A11Y-R3-01 | Contrast / tokens / shared chrome / mobile, from an accessibility angle | "סבבים 1–2 דסקטופ; נגישות מבנית = A11Y-NOW" | Partially closed since — see §1.4. |
| A11Y-R3-05 | Full keyboard + screen reader + `qa_probe` מובייל | "לא חתימת AA בסבב 2" | Keyboard part closed tonight for the nav specifically (§1.4); screen-reader and the mobile `qa_probe` pass are still open and belong to team_50's separate AA sign-off track, not S007. |
| OPT-R3-01/02 | GA `fetch` abort under headless Chrome; YouTube telemetry blocks on the Mokesh embed | Analytics/embed policy, not a page defect | Not S007's — these are network-level artifacts of headless testing, not layout. Mention only so nobody re-flags them as new. |
| OPT-R3-03 | Hardcoded hex colours in `home-front.css` / `books-v2.css` / `faq-toc.css` | No functional defect, deferred to avoid a visual diff while Eyal was reviewing | Token hygiene, not responsive behaviour — out of scope for this task unless the mapping happens to touch the same selectors for a real mobile reason. |
| OPT-R3-06 | Lighthouse scores measured on staging | "noindex + בלי CDN. ארטיפקט, לא כשל" | Applies equally to any mobile Lighthouse run the mapping does — re-measure on production before treating a score as a finding (see §3.3). |

### 1.3 The RTL audit (2026-09-17) — what's mobile-relevant, re-verified against today's line numbers

Full reports: `_COMMUNICATION/team_10/RTL-AUDIT-2026-09-17/`. Four independent facets (CSS
static, PHP templates, JS interactive, live browser) plus a cross-cutting map. I re-checked
every citation below against the working tree **today**; several have shifted from the audit's
own numbers because tonight's accessibility fixes touched the same file (see §1.4) — I flag
each place that happened.

**a. Mobile nav drawer's slide animation is not `[dir]`-aware — still true, now at different
lines.** `site/wp-content/themes/ea-eyalamit/assets/css/chapters.css:688-693` (closed state:
`transform:translateX(100%)`; open state at `:692-693`, inside the `@media(max-width:1180px)`
block starting `:674`). The RTL audit cited lines 611-616 for this same rule on 2026-09-17; it
moved because tonight's WS-2.2 accessibility fix (commit `57883f8`) added `visibility` toggling
to the same block (comment block directly above `:688` explains why). The underlying RTL gap
the audit found — no `[dir="ltr"]` override, so the drawer always slides from the same physical
side regardless of language — is unchanged. Low visible risk today because the panel is
full-viewport-width (open/closed states look identical either direction), and a working
reference implementation already exists, unused, at `assets/css/ea-mobile-nav.css:30-31,111,122`
(the `--ea-mnav-tx` custom-property pattern) — port it rather than inventing a new fix.

**b. Mobile submenu links clip instead of wrapping — a genuine, already-diagnosed mobile
layout bug, not an RTL one.** `chapters.css:541`: `.nav__sub a{...white-space:nowrap...}`
inside a drawer item that can be as narrow as ~95px for long Hebrew labels (e.g. "נחירות ודום
נשימה בשינה"). The RTL audit's live-browser facet found the overflow is **clipped, not
scrolling**, because the parent `.nav__l` sets `overflow-y:auto` (`chapters.css:688`), which per
the CSS spec forces the paired `overflow-x` to compute to `auto` as well — confirmed live via
`getComputedStyle`. This reproduces identically regardless of `dir`; it is a "box too narrow
for `nowrap` text" bug. Likely fix named by the audit: drop `white-space:nowrap` on
`.nav__sub a` so long labels wrap. This is squarely S007's to pick up.

**c. Footer brand alignment flips by *viewport width*, not by direction logic — an open
design question, not a settled bug.** Desktop: `chapters.css:276`
(`.foot__brand{text-align:left}`). Mobile: `chapters.css:289`
(`@media(max-width:760px){...text-align:right...}`). The RTL audit itself couldn't tell whether
this is deliberate ("likely a layout artifact rather than a deliberate bidi decision"). Good
candidate for the mapping to screenshot both states and put to the owner as a question, not
silently "fix."

**d. Hero scroll-down chevron points sideways, not down.** `chapters.css:151-152`
(`.hero__cues`/`.hero__cues span`). Decorative (`aria-hidden`), low severity, but it is the
first thing on every full hero — home included — so it belongs in a mobile-hero screenshot
regardless of its RTL origin. Not itself a responsive bug; flagging only because it will be in
frame for the hero screenshots §2 and §4 ask for anyway.

**e. Not S007's — the `←` bidi-mirrored CTA arrow live on `/books/`, `/shop/`, `/qr/`.**
Tracked as an RTL fix, not a responsive one. Mention only so the mapping doesn't duplicate it.

**f. Confirmed correct already — don't re-test.** At 320px width, the nav correctly collapses
to a hamburger and the desktop bar does not paint over the layout
(`_COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/04-LIVE-BROWSER-VERIFICATION.md:106`, discussed
further in §1.4). The RTL audit's live facet also separately re-opened the drawer at t=0/100ms/
500ms and found it settles to full-viewport-width edge-to-edge with no clipping at rest
(`_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/02-DONE-MOBILE-NAV-KEYBOARD.md:199-213` — this is
the same "menu doesn't cover the viewport" claim, independently re-checked tonight and found
not reproducible, a timing artifact of reading the DOM before the CSS transition settles).

**g. What the RTL audit itself never looked at, live, at any width.** Its own scope note
(`04-LIVE-BROWSER-VERIFICATION.md`, closing section): blog archive/single, shop/product pages,
the books pages, and the mokesh/tsva-bekahol/vekatavta one-off pages were sampled only via
static code reading, never opened in a live browser. These are genuinely first looks for S007,
not re-checks.

**h. Dead code — do not spend mobile budget here.** Confirmed independently by three RTL-audit
facets and by `MEMORY.md`: the theme runs two parallel systems, and `.ea-topnav*`,
`.ea-mnav-*`/`ea-mobile-nav.{css,js}`, `ea-mobile-variants.css`, and every `template-parts/
blocks/*.php` file are enqueued on every page via the shared `ea_wave2_shell` mechanism but
match zero markup any live route renders (`_COMMUNICATION/team_10/RTL-AUDIT-2026-09-17/
01-CSS-STATIC-AUDIT.md:206-223`). Irony worth repeating: the single best `[dir]`-aware mobile
drawer implementation in the whole codebase (`ea-mobile-nav.css`'s `--ea-mnav-tx` pattern) is
in this dead set. See §4.1 for the equivalent finding among the *page templates*.

### 1.4 The accessibility work — what it already closed for mobile, what it left open, and one timing caveat

Source: `_COMMUNICATION/team_100/S006/A11Y-CONSOLIDATED-REGISTER-2026-09-17.md` (the audit, 62
findings) and `_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/` (tonight's 5 fixes). The task brief
is explicit that this report should say which mobile items accessibility already closed so the
mapping doesn't reopen them — here is that list, plus the reverse: what's still open and lands
squarely inside S007 anyway.

**Closed — do not re-flag:**
- **P0-3, the mobile menu's keyboard trap.** Fixed: `_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/
  02-DONE-MOBILE-NAV-KEYBOARD.md` + `05-DONE-ARIA-AND-FORM-LANG.md` task 1 (commits `57883f8`,
  `c48d4f3`). One explicitly-accepted residual gap, not silently dropped: the closed drawer's 28
  links are still in the Tab order — just relocated to *after* the burger instead of before it
  — because the drawer is hidden via `transform`, never `display:none`/`inert`
  (`02-DONE-MOBILE-NAV-KEYBOARD.md:220-234`). The fix's author flagged this as a possible
  follow-up (`inert` toggling), not requested by the mandate. Not S007's to fix unless the owner
  wants it.
- **P0-1/P0-2, skip-link and nav-language-toggle focus contrast.** Fixed sitewide, including
  mobile (same CSS): `01-DONE-FOCUS-CONTRAST.md`.
- **P1-3/P1-4, muted-text contrast tokens.** Fixed: `03-DONE-CONTRAST-TOKENS.md`;
  `chapters.css:18` (`--ink`) and the `--muted` token discussed there is now `#786651`.
- **P1-2, submenu `aria-expanded` state; P1-5, English validation-error strings inside a
  Hebrew form.** Fixed: `05-DONE-ARIA-AND-FORM-LANG.md` (commit `c48d4f3`).
- **P1-7/P1-8, heading structure.** Fixed: `04-DONE-HEADING-STRUCTURE.md`.
- **"Menu doesn't cover the full viewport" and "320px nav collapse looks broken."** Both
  investigated and found **not actual defects** (§1.3f) — confirmed-correct, not merely
  unaddressed.

**Still open, and this is the important part — these overlap S007's own mandate, not just
accessibility's:**
- **A11Y-LIVE-03 (WCAG 1.4.4 Resize Text, binding AA).** At 200% zoom, real navigation content
  is clipped off the page's **left** edge (RTL — overflow spills left, not right) and becomes
  permanently unreachable, not just harder to read: `nav#nav > div.nav__r` (165px past the
  edge), the EN language link, and `button#soundtg` all measured clipped on the home page;
  separately, the testimonials-carousel's own clipping viewport overflows left by 756px on home
  and `/treatment/`. Evidence: `tmp/qa/a11y-2026-09-17/out/zoom-reflow/home.json`, screenshot
  `tmp/qa/a11y-2026-09-17/out/screenshots/home_zoom200.png`
  (`_COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/04-LIVE-BROWSER-VERIFICATION.md:105`). None of
  tonight's five fixes touched zoom/reflow — this is **still open** and already fully diagnosed
  down to the pixel and the selector. High-value first stop for the mapping.
- **A11Y-LIVE-06.** Text sitting over a photographic hero/nav background is **unverifiable**
  by both axe-core and DOM-based contrast scanning on essentially every page sampled (21/21,
  32/32 nodes `backgroundIndeterminate:true`) — not a pass, not a fail, a tool blind spot
  (`04-LIVE-BROWSER-VERIFICATION.md:108`). Directly relevant to §2.10 below: the mobile crop of
  the same hero photo is a *different* patch of image behind the *same* white text, so a
  desktop-only look here proves nothing about mobile.
- **Register §7, "Round-3 Definition of Done."** Explicitly lists **mobile contrast evidence**
  as confirmed absent from the repo, even after tonight's fixes
  (`A11Y-CONSOLIDATED-REGISTER-2026-09-17.md:233-239`). This document's mapping is not asked to
  close that gate, but its screenshots and measurements are exactly the raw material that would.

**A timing caveat worth carrying forward explicitly.** `02-DONE-MOBILE-NAV-KEYBOARD.md:238-241`
states, truthfully at the time it was written, that the fix was "not deployed... staging
continues to serve the old... until team_100 deploys." I checked whether that is still true.
The four tonight's-fix commits (`57883f8`, `511681a`, `399aa5f`, `c48d4f3`) all landed between
2026-09-18 00:50 and 02:01 (`git log --format="%ai %h %s"`). `DEPLOY-LOG.md`'s three most recent
entries are 2026-09-18 12:09, 12:13 and 12:15 — all *after* those commits — and the deploy
script "uploads the working tree, not a git ref" (`DEPLOY-LOG.md:1-4`). That strongly suggests,
but does not from repo evidence alone *prove*, that the noon deploys carried tonight's fixes to
staging. **Do not assume either way** — a DONE report's "not deployed" line can be true when
written and stale an hour later. Before screenshotting staging for any item this section calls
"closed," the mapping should do one quick live check (e.g. confirm the mobile menu's tab order
on the live site) rather than trust either source blindly.

### 1.5 Stale prior mobile artifacts — do not reuse these as ground truth

- `scripts/qa/reports/mobile-audit/*.png` (`about-mob.png`, `treatment-mob.png`, `books-mob.png`,
  `shop-mob.png`, `en-mob.png`, `bookdetail-mob.png`, `nav-open-mob.png`) — committed 2026-06-03
  in commit `415aa04` ("brief(wp-w2-10): full mobile-UI spec request to team_35 + mobile-audit
  screenshots"), work package WP-W2-10, an S003-era milestone confirmed by
  `_archive/WP-W2-10-A/team_100/ASSET-PACKAGE-CONFIRM-WP-W2-10-TRACK2-2026-06-02.md:1-9` ("S1
  hi-fi mockups"). This is **eleven weeks before S006 R1 even started** (2026-08-17) — the
  entire Chapters system, all of Eyal's real content, and every RTL/a11y fix since then
  postdate these images. Do not treat them as current.
- `scripts/qa/reports/lh-mobile-*.json` (~80 files, `ls -la` mtimes 2026-06-02) — same vintage,
  same caveat. Also **gitignored** (`scripts/qa/.gitignore:3`, `reports/`), so these are
  someone's local run, not shared team state, and the committed script
  (`scripts/qa/http-qa-lighthouse.sh`) writes `lh_<route>.json`, not `lh-mobile-*` — a different
  naming pattern, meaning the mobile runs were an undocumented ad hoc invocation, not the
  script actually in the repo today.
- `scripts/qa/reports/visual-audit/*` — also 2026-06-03, and a different exercise entirely
  (live-vs-design-mock comparison, not a "good on a phone" judgment). Don't reuse for this task.

---

## 2. The measurable dimensions of "good on a phone"

For each dimension: what "good" means, the concrete measurement, what the screenshot needs to
show, and — because conflating these is exactly how this kind of audit goes soft — which half a
tool can actually do and which half needs a human eye.

**1. Text size and line length.** *Good:* body copy readable without pinch-zoom; a comfortable
measure per line (the classic ~45–75 Latin-character rule needs Hebrew-specific recalibration —
flag as a judgment call, not a number to assert). *Measurement:* computed `font-size`/
`line-height` on real body-text nodes at each target viewport, plus rendered line length in px.
Note the trap: `ea-tokens.css:31-40` defines an authored type scale (`--ea-type-body: 300
0.9rem/1.85 var(--ea-font)`, etc.) but `chapters.css` — the one live, single-source stylesheet
for the whole site — references `var(--ea-type-` **zero times** (confirmed by grep); it declares
its own font sizes ad hoc per selector. Measure what's actually rendered, don't assume the
token scale governs it. *Screenshot:* an unscaled, full-width crop of 2–3 real paragraphs at
each viewport — the owner needs to read actual Hebrew at 100% to judge comfort, not a
downscaled thumbnail. *Tool vs. eye:* px values are tool-measurable; "comfortable to read" is
not — never let the first stand in for the second.

**2. Vertical rhythm — do sections breathe or crowd.** *Good:* consistent, intentional spacing
between sections. *Measurement:* since `chapters.css` doesn't consume the `--ea-space-0..24`
scale either (same single-reference finding as above — `ea-tokens.css:43-55` defines it,
`chapters.css` doesn't use it), there is no authored ground truth to check rendered spacing
against. Measure actual gaps (`getBoundingClientRect()` deltas between consecutive `<section>`/
major-block boundaries) at each viewport and look for outliers and cross-page inconsistency,
rather than checking against a scale that isn't in force. *Screenshot:* full-page, but see §5 —
a raw full-page mobile capture is not, by itself, something a human can review.

**3. Tap targets and spacing between them.** *Good:* comfortably sized and spaced controls — no
single-tap-that-hits-the-neighbor moments. IS 5568/WCAG 2.0 AA (the binding standard for this
project, per the a11y audits) has no target-size criterion of its own; WCAG 2.5.5 (AAA, 44×44px)
and 2.5.8 (2.2 AA, 24×24px) are useful references but must be labelled "beyond the binding
standard — recommendation only," the same convention the a11y audits used, for consistency.
*Measurement:* computed height/width via `getBoundingClientRect()` on every `<a>`/`<button>`/
form control at mobile width, plus gap to the nearest sibling target. One concrete starting
point already identified: `.btn{padding:15px 36px;...}` (`chapters.css:81`) — height not yet
computed, worth being first measured rather than assumed compliant. *Screenshot:* a zoomed crop
around a representative cluster — e.g. the mobile submenu rows at `chapters.css:541`, which are
also already flagged as visually clipping (§1.3b), so one screenshot serves two findings.
*Tool vs. eye:* size and spacing are tool-measurable in px; whether it *feels* right to a real
thumb is not — and emulated clicks are mouse events, not touch (§3.4).

**4. Horizontal overflow and content clipping.** The one dimension with an existing automated
check: `qa_probe.mjs`'s `scrollWidth` vs `clientWidth` comparison
(`_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs:112-123`). My own grounding
run today (§3.1) came back clean, 0/10, across 5 pages × 2 viewports. **What this check does
not catch, proven against this exact codebase:** overflow that is *clipped* rather than
scrollable. A11Y-LIVE-03 (§1.4) found real content pushed off-screen with
`scrollWidth === clientWidth` throughout — "this would not surface in a bare
`scrollWidth>clientWidth` check either" (`04-LIVE-BROWSER-VERIFICATION.md:105`). Run `qa_probe`
for the cheap sitewide first pass, but do not conclude "no overflow bugs" from a clean run
alone. *Screenshot:* full-page plus a tight crop on any specific clipped element.

**5. Image aspect and cropping on narrow screens.** No responsive-image mechanism exists
anywhere in the theme: zero hits for `srcset` or `wp_get_attachment_image()` across
`template-parts/` and `inc/`. Every image ships one fixed resolution to every device; the only
mobile adaptation available is CSS. Concretely, hero images are a plain
`<img class="phero__media" src="..." alt="...">`
(`template-parts/chapters/parts/phero.php:25`) with no `srcset`/`sizes`. *Measurement:* for each
hero/gallery/figure image, read the CSS box (`object-fit`, `aspect-ratio`, fixed height) at
mobile width and compare against the source image's native aspect ratio to quantify how much is
cropped. *Screenshot is mandatory here, not optional* — the math tells you how much is cut, only
a human eye tells you *what* (a face vs. empty sky). This is impossible to judge from CSS alone.

**6. Multi-column collapse and whether the resulting reading order still makes sense.** The
theme already collapses grids at named breakpoints — cataloguing a sample: `.about` → 1
column ≤900px (`chapters.css:171`), `.whom`/`.sess` → 1 column ≤520px via a two-step breakpoint
(`:189-190,198-199`), `.bookcards`/`.testi-grid`/`.gallery` → 1 column at 560/560/520px
(`:871-872,863-864,898-899`). The measurable question is not *whether* it collapses (it
demonstrably does) but (a) whether DOM source order still reads correctly once it's one visual
column — a 2-D grid can use `order`/`grid-template-areas` in ways that are fine in 2-D and wrong
top-to-bottom in 1-D — and (b) whether the breakpoints agree with each other across files; they
don't (see §5's breakpoint-vocabulary trap). *Screenshot:* just above and just below the
collapse breakpoint, side by side.

**7. Sticky/fixed elements eating the viewport.** The fixed header claims a 72px band at the
top of every page (`inset:72px 0 0 0` on the mobile drawer, `chapters.css:688`, implies a 72px
header) — on a ~667–844px phone viewport that's 8–11% of vertical space gone before any content,
and real mobile browsers' own address-bar/toolbar chrome (which **collapses dynamically on
scroll**, something no desktop-browser emulation reproduces — see §3.4) eats more on top of
that. *Measurement:* at load and mid-scroll, what percentage of viewport height is claimed by
anything `position:fixed`/`sticky` (header, `#ea-scroll-progress`, any sticky CTA).
*Screenshot:* a viewport-height (not full-page) capture at load — that's the frame the fixed-
chrome tax actually applies to.

**8. Forms on a phone keyboard.** The one real form on the site (`/contact/`) already gets
input *types* right: `[tel your-phone ...]` / `[email* your-email ...]`
(`site/wp-content/mu-plugins/ea-w2-15-cf7-contact-form-once.php:70-71`) render as
`type="tel"`/`type="email"`, correctly summoning the right mobile keyboard layout — confirmed
correct, don't re-test. What is **not** yet right:
`.wpcf7-form-control.wpcf7-text/.wpcf7-select/.wpcf7-textarea{font-size:0.9rem;...}`
(`assets/css/ea-atoms.css:1394-1407`) computes to **~14.4px** at the default 16px root (no root
override found anywhere in the theme) — below the ~16px floor real iOS Safari uses to decide
whether to auto-zoom the page when a field receives focus. Flagging this as the sharpest
available illustration of the emulation-vs-real-device gap the task brief asked me to address
(full discussion in §3.4): every tool this project owns runs on Chromium, which has no such
zoom-on-focus behavior at all, emulated or not — **this class of bug is invisible to every
measurement this project has ever run.** *Measurement:* computed `font-size` on every visible
form control at mobile width; flag anything under 16px. *Screenshot:* before/after tapping the
field on a real iPhone or the iOS Simulator — Chrome DevTools literally cannot produce this
screenshot regardless of viewport setting.

**9. RTL-specific mobile issues.** Covered in §1.3; the two live items needing mapping
specifically at mobile widths (not yet done) are the `.nav__sub` clipped labels (`chapters.css:
541`) and the still-open 200%-zoom clipping (A11Y-LIVE-03, §1.4) — the a11y audit's 320px pass
covered only the collapsed-nav-at-rest case, not general reflow at narrow real widths sitewide.

**10. Hero/text-over-image legibility (not in the brief's list verbatim, but follows directly
from §1.4's A11Y-LIVE-06 and belongs here).** Nav/hero text over photographic backgrounds is
unverifiable by axe-core or DOM contrast scanning on essentially every page. On mobile the same
hero photo is **cropped differently** (§2.5), so the patch of image sitting behind the text is
not the desktop patch — a desktop-only contrast look gives zero guarantee for mobile.
*Measurement:* either real pixel-sampling under the text box at each breakpoint, or — more
practically for this task's timeline — a human eye on the actual per-viewport screenshot.
Explicitly tool-blind; don't let an automated pass stand in for it.

---

## 3. Tooling this repo already has

### 3.1 `qa_probe.mjs` — the canonical, zero-dependency runner

`_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` (143 lines), documented in
`_aos/lean-kit/modules/validation-quality/docs/BROWSER_QA_HARNESS_CANON_v1.0.0.md`. Talks to a
cached `chrome-headless-shell` over raw CDP via Node's built-in WebSocket — no npm/pip
dependency, Node 18+ only (this machine: v24.7.0, and three `chrome-headless-shell` builds are
already cached under `~/.cache/puppeteer`). Per (page, viewport) it checks: horizontal overflow
(`scrollWidth` vs `clientWidth`, `qa_probe.mjs:112-123`), a caller-supplied forbidden-substring
scan, non-empty `<title>`, and an optional full-page screenshot. Default viewports are
`{mobile: 375×812, desktop: 1440×900}` (`:80`), fully overridable via config; it sets CDP
`Emulation.setDeviceMetricsOverride{..., mobile: vp.w < 768}` — a UA/viewport-level "mobile"
flag only, not real touch or gesture emulation.

**What it does not check:** of §2's ten dimensions, this script covers exactly one directly
(overflow, #4) and contributes screenshots toward a few others; text size, vertical rhythm, tap
targets, image cropping, sticky-chrome viewport share, and anything needing a value judgment are
all untouched by it today. New per-dimension probes will need writing — see §3.2 for the
established idiom to write them in.

**Grounding run (today, live against current staging):** I ran it against home, `/treatment/`,
`/qr/`, `/contact/`, `/en/` at both default viewports
(`node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --config <cfg>`,
config and output under this session's scratchpad, not the project's `tmp/qa/` — this was a
tooling check, not mapping evidence). Result: **0/10 failures, verdict PASS** — every page is
overflow-clean at 375px and 1440px right now. This is itself a useful, concrete data point for
the owner's framing: overflow-clean is necessary and already achieved, and says nothing at all
about whether any of §2's other nine dimensions are good.

**A new trap I found opening the resulting screenshots myself:** full-page captures
(`captureBeyondViewport:true`, `qa_probe.mjs:117`) at mobile width come out extremely tall —
20,067px and 26,449px tall in my two samples, at 375px width. These are technically correct
captures that are **not humanly reviewable as single images** — nobody can judge "does this
breathe or crowd" from a 26,000px-tall PNG without slicing it first. Any new probe built for §2
should capture per-section crops (bounded by each `<section>`'s own `getBoundingClientRect()`)
in addition to, or instead of, one full-page shot.

### 3.2 The established puppeteer-core + axe-core idiom

`scripts/qa/package.json:6-9` declares `puppeteer-core ^23.0.0` (installed: 23.11.1) and
`axe-core ^4.10.0`; both are present under `scripts/qa/node_modules/`. **Trap:** this directory
is gitignored (`scripts/qa/.gitignore:1-3` — `node_modules/`, `package-lock.json`, `reports/`),
so it is not committed — a fresh worktree needs `npm install` inside `scripts/qa/` before any of
these scripts run, consistent with `MEMORY.md`'s existing "worktrees silently lack the
gitignored deps" note, now confirmed specifically for this directory too.

The established pattern (worked example: `scripts/qa/team190-postdeploy-design-eyeball.cjs:
22-28`): launch full Chrome via
`puppeteer.launch({executablePath: CHROME, headless:'new', args:['--no-sandbox',
'--ignore-certificate-errors']})`, `page.setViewport(...)`,
`page.goto(url + '?nc=' + cachebuster, {waitUntil:'networkidle2', timeout:90000})`, then
`page.evaluate()` to pull real computed values out of the live DOM. This is a good skeleton for
any new §2 probe (a tap-target sizer, a spacing sampler, the form font-size checker §2.8 calls
for). Note that same script's `brokenImages` check (`:36`,
`img.naturalWidth === 0 && img.src`) is written in a way that would misreport a not-yet-loaded
lazy image as broken — a live illustration of the lazy-image trap in §5, not a bug to copy.
Also note **team_190 no longer exists in the live team registry** (`MEMORY.md`) — treat this
code as reusable prior art, not as an active owner to coordinate with.

### 3.3 Lighthouse (mobile)

Full Chrome is required, not `chrome-headless-shell`
(`BROWSER_QA_HARNESS_CANON_v1.0.0.md:48-57`). The one committed runner,
`scripts/qa/http-qa-lighthouse.sh:18`, hardcodes `--preset=desktop` — there is no committed
script for a *mobile* Lighthouse pass on the current site; the only `lh-mobile-*.json` files
present are the stale June artifacts (§1.5). A new invocation with `--preset=mobile` (or no
preset — Lighthouse's own default is mobile) would need writing. Dev/staging Performance and
SEO scores are artifacts of `noindex` + no CDN + `?nc=` cache-busting, not findings
(`BROWSER_QA_HARNESS_CANON_v1.0.0.md:72-75`) — this applies to a mobile run exactly as it does
to the desktop one OPT-R3-06 already flagged.

### 3.4 Real device vs. emulation — where it actually matters here

CDP/DevTools viewport emulation gives you viewport size, device-pixel-ratio, and a coarse
"mobile" UA/touch-point flag. It does **not** give you, each tied to a concrete finding above:

- iOS Safari's zoom-on-focus for sub-16px inputs (§2.8) — Chromium has no such behavior,
  emulated or not.
- The dynamic address-bar/toolbar chrome that changes the *effective* viewport height as a real
  user scrolls (§2.7) — CDP's device-metrics override is a fixed number, never live.
- Real touch gestures vs. simulated pointer/mouse events — explicitly flagged as untested by
  tonight's own accessibility fix: *"Touch-specific interaction (a real touchscreen tap, as
  opposed to Puppeteer's mouse click) was not verified... I have not driven a real touch event
  to confirm it"* (`_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/05-DONE-ARIA-AND-FORM-LANG.md:
  243-246`).
- Real font hinting/rendering, real network conditions, real momentum/rubber-band scrolling.

This environment also exposes an **iOS Simulator control tool**
(`mcp__Claude_Code_iOS_Simulator__control`) capable of driving real Mobile Safari in a simulated
iOS runtime — much closer than any Chromium tool to the zoom-on-focus/dynamic-viewport class of
bug, though still a simulator, not physical hardware, and I have not verified a simulator is
actually installed/bootable on this machine — that check is the next line's first step if it
wants to use it.

**Recommendation:** use `qa_probe.mjs`/Chrome-based tooling for the cheap, sitewide,
tool-measurable dimensions (#3, #4, #6, #9 structurally); reserve the iOS Simulator (or a real
phone) specifically for #7 and #8, and as a spot-check multiplier anywhere a Chrome-only
measurement comes back borderline.

### 3.5 A canonical viewport set (reconciling what prior art already used, inconsistently)

| Viewport | Where it's already used |
|---|---|
| 375×812 | `qa_probe.mjs` default (`:80`); A11Y-AUDIT interactive facet (`03-INTERACTIVE-FORMS-MEDIA-AUDIT.md:21`) |
| 390×844 | Tonight's WS-2.2 mobile-nav-keyboard fix baseline (`02-DONE-MOBILE-NAV-KEYBOARD.md:125`) |
| 320px width only | A11Y-LIVE-04's reflow floor (`04-LIVE-BROWSER-VERIFICATION.md:106`) |
| 1440×900 | Universal desktop baseline across every script and audit in this repo |
| 768×1024 (tablet) | Not used anywhere in this project yet |

**Recommendation:** adopt **375×812** as the primary mobile baseline (maximizes comparability
with both the tool default and the existing a11y evidence), add **320px width** as a stress-test
floor specifically for dimensions #4/#9, and treat **390×844** as a secondary confirmation width
given tonight's fix was verified there. Tablet (768×1024) is explicitly outside this task's
stated scope ("genuinely pleasant to use on a **phone**") — but several of the theme's own
breakpoints (880px, 900px, 980px) sit inside tablet territory and nobody has looked there in any
round; worth one line to the owner rather than silently deciding either way.

---

## 4. The page set

### 4.1 How pages actually route to templates — the mechanism, not a guess

This is read directly off the live routing filter, not inferred from URL shape.
`ea_chapters_template_include()` (`site/wp-content/themes/ea-eyalamit/inc/chapters/
chapters-routing.php:17-49`, filter priority 103) maps a page's slug through
`ea_chapters_route_map()` (`inc/chapters/chapters-render.php:32-71`) to a template file, with a
separate parent-slug pattern route for QR children (`ea_chapters_pattern_routes()`,
`chapters-render.php:79-83`, e.g. `/qr/qr1/`). Blog archive/single route separately at priority
105 (`chapters-routing.php:76-97`).

Eight live template files, all confirmed present on disk
(`find site/wp-content/themes/ea-eyalamit/page-templates -iname "tpl-chapters-*.php"`):
`tpl-chapters-home.php` (front page only), `tpl-chapters-method.php` (`/method/` only),
`tpl-chapters-mokesh.php` (`/eyal-amit/mokesh-dahiman/` only), `tpl-chapters-en.php` (`/en/`
only), `tpl-chapters-qr.php` (QR children, pattern-routed, real `post_content` — not
sections-array driven), `tpl-chapters-blog-archive.php`, `tpl-chapters-blog-single.php`, and
**`tpl-chapters-page.php`**, one file shared by 27 different `type` values: `treatment`,
`snoring-sleep-apnea`, `sound-healing`, `lessons`, `about`, `faq`, `didgeridoos`, `bags`,
`stands-storage`, `stand-floor`, `repair`, `shop`, `muzza` (books hub), `qr-hub`, `vekatavta`,
`kushi-blantis`, `tsva-bekahol`, `contact`, `galleries`, `media` (slug now `testimonials`),
`privacy`, `accessibility`, `terms`, `learning`, `therapist-training`, `lectures`, `workshops`
(`chapters-render.php:34-69`).

**Likely-dead templates — flag, don't map.** `page-templates/` also holds
`template-book-detail.php`, `template-books-hub.php`, `template-galleries-catalog.php`, and (more
broadly, newly catalogued here) nine legacy non-`tpl-chapters-*` files —
`tpl-blog-archive.php`, `tpl-blog-single.php`, `tpl-books.php`, `tpl-catalog-14e.php`,
`tpl-content.php`, `tpl-en-landing.php`, `tpl-home.php`, `tpl-qr.php`,
`tpl-stage-b-test.php`. Every slug that could plausibly use the classic WP "Template Name"
files (`books`, `vekatavta`, `kushi-blantis`, `tsva-bekahol`, `galleries`) is explicitly present
in `ea_chapters_route_map()`, applied at `template_include` priority 103 — which **wins
regardless of what Template Name is assigned in wp-admin**. These files are therefore very
likely unreachable by any live visitor, the same class of finding as the RTL audit's Wave2
dead-code map (§1.3h), just not previously listed there. `template-media-catalog.php`'s fate
genuinely can't be settled from code alone (depends on whether a page with slug `media` still
exists in the DB) — flag it exactly the way the RTL audit flagged `tpl-content.php`
(`00-MAPPING.md:76-80`): a 30-second wp-admin check closes it; don't spend mapping budget
guessing. Treat any `page-templates/*.php` file without a `tpl-chapters-` prefix (or the four
catalog/media names) as presumptively shadowed the same way.

### 4.2 Below the template: the real unit of reuse is the "part"

`tpl-chapters-page.php` pages are not 27 different layouts — they're compositions of ~19–25
shared components. Each page's `defaults/<type>-defaults.php` file returns an array with a
`'phero'` (hero) key present on nearly every inner page, plus a `'sections'` array whose entries
each carry a `'part'` key (`chapters-render.php:404-441` is the field-map SSOT); each part is
rendered by exactly one file under `template-parts/chapters/parts/*.php`, styled by shared
selectors in `chapters.css`. **A mobile bug in one part is the same bug everywhere that part is
placed** — this is the actual unit mobile QA should work in, not "page."

Matrix built by grepping every `defaults/*.php` file for `'part' => 'X'`:

| Page type | Parts used |
|---|---|
| about | gallery, prose, split |
| accessibility / privacy / terms | pending-note, prose |
| bags | bleed, cta, faq-inline, gallery, prose |
| contact | contact |
| didgeridoos | cta, faq-inline, prose, testimonials |
| faq | faqblock |
| galleries | cta, gallery, pending-note |
| kushi-blantis / tsva-bekahol / vekatavta | cta, faq-inline, gallery, prose |
| learning / therapist-training | cta, prose |
| lectures / workshops | cta, faq-inline, prose |
| lessons | cta, dd, faq-inline, prose, split, testimonials, videoblk-placeholder |
| media (testimonials) | cta, gallery, pending-note, testimonials |
| method | cta, faq-inline, prose, split, testimonials |
| mokesh | bleed, fbembeds, gallery, mokesh-portrait, mokesh-video, prose, split, timeline |
| muzza (books hub) / shop / qr-hub | bookcard (+ cta, prose for muzza) |
| repair / stand-floor | cta, faq-inline, prose |
| snoring-sleep-apnea | cta, dd, gallery, prose |
| sound-healing | cta, faq-inline, prose, split, testimonials, videoblk-placeholder |
| stands-storage | cta, faq-inline, gallery, prose |
| treatment | bleed, dd, faqblock, prose, split, testimonials, videoblk-placeholder |
| home, en, qr (children) | bespoke — see below, not sections-array driven |

Two findings from building this matrix worth acting on directly:

- **Six registered parts have zero live placements anywhere:** `steps`, `reveals`, `mag`,
  `lead`, `product-cta`, `videoblk` (non-placeholder). Confirmed by grepping every
  `defaults/*.php` and `tpl-chapters-home.php`'s own hardcoded `get_template_part()` calls
  (`page-templates/tpl-chapters-home.php:30-82` — home calls named `section-*.php` files and two
  generic parts, `prose` and `cta`, never these six). Don't spend mapping time hunting for a
  page that exercises them — there isn't one today.
- **Home and `/en/` are entirely bespoke**, not sections-array driven. Home alone composes 11+
  unique `section-*.php` files (`section-hero`, `section-home-03-video`, `section-06-compare`,
  `section-02-for-whom`, `section-07-how-to-start`, `section-03-session`, `section-photo-band`,
  `section-04-studio`, `section-home-09-peek`, `section-05-testimonials`, `section-01-about`)
  found nowhere else on the site — it cannot be represented by any other page and needs its own
  full pass regardless of "template coverage."

### 4.3 Proposed representative set

~16–17 URLs instead of the ~90-page full inventory, chosen to hit every live template file and
effectively every live part at least once — the concrete "group by template" the task asked for,
shown rather than asserted:

| Page | Template | Why it's in the set |
|---|---|---|
| `/` | `tpl-chapters-home.php` | Bespoke, 11+ unique sections, mandatory on its own merits |
| `/en/` | `tpl-chapters-en.php` | Bespoke LTR; architectural RTL risk already flagged (§1.3) |
| `/method/` | `tpl-chapters-method.php` | The only page on this template |
| `/treatment/` | `tpl-chapters-page.php` (treatment) | Richest single instance: 7 parts (bleed, dd, faqblock, prose, split, testimonials, videoblk-placeholder) |
| `/faq/` | `tpl-chapters-page.php` (faq) | The *other* `faqblock` branch — A11Y-STRUCT-03 already proved these two diverge structurally (150 headings vs. 12) |
| `/contact/` | `tpl-chapters-page.php` (contact) | The one real form on the site — dimension #8 |
| `/eyal-amit/` | `tpl-chapters-page.php` (about) | Owner-named "Eyal's page"; covers gallery + split, not covered elsewhere |
| `/eyal-amit/mokesh-dahiman/` | `tpl-chapters-mokesh.php` | Owner-named "Mukesh's page"; bespoke, timeline + fbembeds + mokesh-only parts |
| `/testimonials/` | `tpl-chapters-page.php` (media) | Grid mode — RTL audit already flagged this as structurally distinct from the carousel used everywhere else |
| `/books/` | `tpl-chapters-page.php` (muzza) | Owner-named "books hub" |
| `/books/vekatavta/` | `tpl-chapters-page.php` (vekatavta) | Represents all 3 "book galleries" — kushi-blantis and tsva-bekahol share an identical part composition per the matrix |
| `/shop/` | `tpl-chapters-page.php` (shop) | Owner-named "shop"; catalog/hub view (bookcard) |
| `/didgeridoos/` | `tpl-chapters-page.php` (didgeridoos) | Richest of the product-page family (bags, stands-storage, stand-floor, repair share `chapters-commerce.php`'s purchase-link map and an identical or subset part composition) |
| `/qr/` + one child, e.g. `/qr/qr1/` | `tpl-chapters-page.php` (qr-hub) + `tpl-chapters-qr.php` | The hub (bookcard) and one child (freeform `post_content`, structurally distinct from every other row). **Flag explicitly: every visitor to a QR child page arrived by scanning it with a phone camera — this is the one page category on the entire site where 100% of real traffic is mobile, unlike every other row here.** |
| Blog archive + one post | `tpl-chapters-blog-archive.php` / `tpl-chapters-blog-single.php` | Both bespoke, own stylesheet (`ea-blog.css`) with its own breakpoint set (560/639/767/900/1023px) |
| One of `/privacy/`, `/terms/`, `/accessibility/` | `tpl-chapters-page.php` | Identical `pending-note`+`prose` composition across all three per the matrix — pick one, spot-check the other two match |

**One acknowledged gap in this proposal:** `/galleries/` (type `galleries`: cta, gallery,
pending-note) isn't individually covered by anything else in the set above — add it as an 18th
row if budget allows; flagging rather than silently omitting.

**Owner-named categories not individually listed, and why that's not a gap:** sound-healing,
snoring, lessons — same `cta`/`faq-inline`/`prose`(+`dd`/`split`/`testimonials`) family as
treatment/method, already structurally covered. The four types the owner didn't name
(`learning`, `therapist-training`, `lectures`, `workshops`) are the simplest family on the site
(`cta`+`prose` or `cta`+`faq-inline`+`prose`) and fully subsumed by the `/didgeridoos/` row.

---

## 5. Known traps

**Carried forward, all already burned this project once:**
- `curl` sees HTML only, never the rendered box model — never judge layout from it.
- A `0×0` viewport returns real-looking, wrong numbers — assert non-zero before trusting any
  measurement.
- Lazy-loaded images report `naturalWidth = 0`; arithmetic on them yields `NaN`, and
  `Math.abs(NaN) > threshold` is `false` — the comparison silently *passes*.
  `scripts/qa/team190-postdeploy-design-eyeball.cjs:36` is written exactly this way and would
  misreport a not-yet-loaded image as broken — a live example of the trap sitting in this
  repo's own prior art, not a hypothetical.
- Single-line `grep` misses attributes on multi-line tags.
- Batch browser calls can 503 mid-run and return partial results that look complete.
- Staging returns short/incomplete responses under repeated probing (this task's own ground
  rules; `MEMORY.md`'s "QA harnesses that fail open" entry has the fuller catalogue).
- An overflow check based on `scrollWidth > clientWidth` misses *clipped* (non-scrolling)
  overflow — proven concretely against this codebase by A11Y-LIVE-03 (§1.4), and it is exactly
  `qa_probe.mjs`'s own check (§3.1) — a clean `qa_probe` run is not proof of no clipping.
- Dead Wave2 code (`.ea-topnav*`, `.ea-mnav-*`, `ea-mobile-nav.{css,js}`,
  `template-parts/blocks/*.php`) is enqueued on every page but reaches zero live visitors —
  confirmed independently by three RTL-audit facets, `MEMORY.md`, and tonight's a11y brief.
  Don't spend mobile budget there.

**New, surfaced by this research:**
- **Stale prior art reads as ready-made evidence but isn't.** The June 2026 mobile screenshots
  and Lighthouse runs (§1.5) predate the entire S006 content rebuild by eleven weeks — dated and
  sourced here explicitly so this isn't rediscovered the hard way.
- **Full-page mobile-width screenshots are too tall to review.** `captureBeyondViewport:true` at
  375px produced 20,000+px-tall PNGs in my own grounding run (§3.1) — technically correct,
  practically unreviewable without slicing by section.
- **`scripts/qa/node_modules/` is gitignored, not committed.** Any fresh worktree needs
  `npm install` in `scripts/qa/` before the puppeteer-core/axe-core scripts run — confirms
  `MEMORY.md`'s general worktree-deps warning for this specific directory.
- **A DONE report's "not deployed" can go stale within the hour.** Worked example in §1.4:
  cross-check `DEPLOY-LOG.md`'s latest timestamp against the commit(s) in question — don't trust
  either source alone, and don't assume "closed in the working tree" means "visible on staging
  right now" without checking.
- **No responsive images anywhere** (`srcset`/`sizes` = zero hits). Distinct from "does it crop
  badly" (§2.5) even though both stem from the same missing mechanism — this one is a
  performance fact (every device downloads the same source resolution) worth keeping separate.
- **At least five incompatible breakpoint vocabularies coexist**: `chapters.css`'s own ad hoc
  set (520/560/640/760/820/880/900/980/1080/1180px) vs. `ea-atoms.css`'s 639/767/1023px vs.
  `books-v2.css`'s 400/540/799/800px vs. `ea-blog.css`'s 560/639/767/900/1023px. A device near
  any of these boundaries can be treated differently by different stylesheets on the same
  rendered page — worth checking explicitly at ~640px, ~767px and ~880px, where the vocabularies
  disagree most.
- **The contact form's font-size-under-16px risk (§2.8) is invisible to every Chromium-based
  tool this project owns.** Don't let a clean Lighthouse/axe/`qa_probe` run stand in for a
  real-device (or Simulator) check on this specific class of bug.

---

## 6. Proposed shape for the mapping's report

Adapted from the `A11Y-CONSOLIDATED-REGISTER-2026-09-17.md` format — which the owner has
already seen and worked from successfully — with two additions this task specifically asked
for that the accessibility format didn't need: a **reach** column (how many live pages/URLs
share the affected component, a direct product of §4.2's matrix) and an **effort estimate**.

1. **Header/scope block.** What ran, when, against which exact commit and `DEPLOY-LOG.md`
   timestamp (per §1.4's caveat, record this every time, not just once, so a later reader knows
   precisely what they're looking at).
2. **Findings table**, columns: `ID` · `severity` (P0/P1/P2, reusing the a11y register's own
   bands — blocks a core mobile path / real-but-narrower / correct-but-low-impact — for
   consistency across the owner's two concurrent workstreams) · `dimension` (from §2's ten) ·
   `template/part affected` + `file:line` · `reach` (e.g. "faq-inline: 13 page types," straight
   from §4.2's matrix) · `measured` / `inferred` · `evidence` (`file:line` and/or a screenshot
   link — never one without the other) · `what a phone user actually experiences` · `effort`
   (S/M/L, sized by **how many files change**, not how many pages are affected — §4.2 means most
   real fixes are one file touching many pages) · `owner decision needed: y/n`.
3. **Defects vs. open questions, kept apart** — mirroring how the a11y register separated
   "confirmed defects" from "decisions that belong to team_00." An item like `.foot__brand`'s
   viewport-based flip (§1.3c) or the hamburger-corner placement the RTL audit already raised is
   a *question*, not a bug with an obvious fix; mixing the two into one list is how a report
   stops supporting a real decision.
4. **"Verified correct, don't re-spend attention here"** — mirroring the a11y register's §4.
   Seed it with what's already confirmed fine for mobile: 320px nav collapse at rest, the "menu
   doesn't cover the viewport" non-reproduction, the contact form's semantic input types (§1.3f,
   §1.4, §2.8).
5. **"COULD NOT MEASURE," explicit and separate from PASS** — per the a11y brief's own rule:
   never report a pass because something was absent, silent, or errored.
6. **Screenshots**: one directory per mapping run, `tmp/qa/mobile-<date>/screenshots/`, named
   `<page>_<viewport>_<what>.png`, matching the existing `tmp/qa/a11y-2026-09-17/out/screenshots/`
   convention rather than the gitignored `scripts/qa/reports/` location prior mobile work used
   (§1.5) — this run's evidence should be findable later, not silently local-only. Every finding
   row links its screenshot(s) directly; per the owner's own rule, "a finding without an image
   he can look at is not a finding he can decide on."
7. **Close with a punch-list ordered by reach × severity, not by page or by file.** Since §4.2
   established that most live components are shared across many pages, the highest-leverage
   fixes are almost never "fix page X" but "fix component Y" — the report should make that
   arithmetic visible rather than leaving the owner to reconstruct it himself.
