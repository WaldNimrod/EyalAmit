# WS-2.1 — DONE: skip link + nav language-toggle focus contrast

Builder: team_10 (this line) · Date: 2026-09-18
Mandate: WS-2.1 — the skip link and the nav language toggle lose required contrast at the
exact moment a keyboard user focuses them. SC 1.4.3 / SC 2.4.7. P0.
Report per `_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/00-BRIEF-SHARED-FIX.md`.

Per the shared brief: I am BUILDING this fix, not verifying it. Everything below is my own
measurement to convince myself the fix is real before handing it off — the PASS call belongs
to a different line (Iron Rule #1).

## 0. Which side is live (verified before editing)

Fetched the staging home page (`http://eyalamit-co-il-2026.s887.upress.link/`, HTTP 200,
83824 bytes) and located selectors directly in the delivered HTML:

- `<a class="ea-skiplink" href="#main">דלג לתוכן</a>` — matches
  `site/wp-content/themes/ea-eyalamit/inc/wave2-stage-b.php:422`, exactly as the brief says.
- `<a class="nav__en" href=".../en/" hreflang="en" lang="en">EN</a>` — matches
  `template-parts/chapters/section-nav.php:77`.
- `class="ea-skip-link"` (header.php's variant) — **zero** matches in the live HTML. Confirmed
  dead, per the brief; no edit was made there.
- Body classes on the live page include both `ea-wave2-shell` and `ea-chapters` — the two
  systems are literally co-present as CSS module names, but the actual header/nav DOM (`.nav`,
  `.nav__l`, `.nav__en`, `.nav__dd`, `.nav__b`) is 100% Chapters markup. All edits below target
  Chapters-system selectors in `assets/css/chapters.css` and the shared atom in
  `assets/css/ea-atoms.css` (which IS enqueued live — `ea-wave2-atoms-css`, confirmed by its
  `<link>` tag in the delivered `<head>` — "Wave2 is dead" refers to dead *markup/JS*, not to
  this one still-loaded stylesheet).

## 1. Root cause, confirmed by two independent methods

Extracted the live `<style id="generate-style-inline-css">` block verbatim. It contains, as one
unconditional, unscoped, non-`@media` rule:

```
a:hover, a:focus, a:active{color:var(--contrast);}
```

`--contrast` resolves (confirmed via `getComputedStyle(el).getPropertyValue('--contrast')`
inside both `.ea-skiplink` and `.nav__en`) to `#2e2b28` everywhere on the page — there is no
per-section override of the token itself.

**Specificity, confirmed two ways — real Chrome cascade resolution (CDP
`CSS.getMatchedStylesForNode`, cross-checked against real keyboard-Tab computed style) and by
hand:**

| Selector | Specificity | Source |
|---|---|---|
| `a:hover, a:focus, a:active` | **0,1,1** | `generate-style-inline-css` (GeneratePress, dynamic) |
| `.ea-skiplink` | 0,1,0 | `ea-atoms.css:74` |
| `.nav__b`, `.nav__en`, `.btn--terra`, `.btn--gw` | 0,1,0 | `chapters.css` (each, own line) |
| `.nav__l a`, `.nav__dd` (as descendant), `.nav__sub a`, `.foot a` | **0,1,1** (tied) | `chapters.css` |

0,1,0 selectors lose to 0,1,1 unconditionally, regardless of stylesheet order — that's the
skip link and the EN toggle. The 0,1,1-tied selectors are a genuine tie, broken by cascade
order: `chapters.css`'s `<link>` is the **last** stylesheet in the delivered `<head>` (confirmed
by byte offset: `ea-chapters-css` at 29351, vs. `generate-style-inline-css` at 18982; no
stylesheet or `<style>` block re-declares `a:focus` after it), so `.nav__l a` and its siblings
win their tie honestly and were **already fine** before I touched anything — see §6.

## 2. Fix chosen — honest specificity raise, no `!important`

For each broken component, added `color` to (or created) its own `:focus,:focus-visible` rule.
A selector with the class plus a pseudo-class is **0,2,0** — that beats the colliding rule's
0,1,1 outright, so `!important` is never needed and none was used anywhere in this change.
Where a component already had an established "highlighted" treatment (e.g. `.nav__en:hover`'s
`border-color:#fff;color:#fff`), I re-used that exact value for `:focus`/`:focus-visible` rather
than inventing a new colour — same discipline as the existing `.foot a:focus-visible` and
`.tlink:focus-visible` rules already in the file (see §6), which this fix now matches instead
of being the odd one out.

## 3. Changes made (file:line)

**`site/wp-content/themes/ea-eyalamit/assets/css/ea-atoms.css:88-101`** — `.ea-skiplink:focus,
.ea-skiplink:focus-visible` gained one declaration, `color: #fff;` (matches the base rule's own
`color:#fff` at line 79). Nothing else in that rule (the `position:fixed` repositioning) was
touched.

**`site/wp-content/themes/ea-eyalamit/assets/css/chapters.css:708`** — the duplicate
`.ea-skiplink:focus,.ea-skiplink:focus-visible{...}` rule (repositioning only, no colour) gained
the same `color:#fff`, for consistency with the ea-atoms.css copy above (both rules already
existed as intentional duplicates before this change; leaving one fixed and one not would be a
worse state than either fixing both or neither). Comment at this line explicitly notes this is
**not** the dead `.ea-skip-link` (hyphenated) rule immediately above it at `chapters.css:706-707`
— that one belongs to `header.php`'s markup, confirmed dead in §0, and was left untouched.

**`site/wp-content/themes/ea-eyalamit/assets/css/chapters.css:109`** (new rule, after
`.nav__b` at :103) — `.nav__b:focus,.nav__b:focus-visible{color:#fff}`. `.nav__b` is the header
logo/brand link; it had no `:focus` rule of any kind before this change.

**`site/wp-content/themes/ea-eyalamit/assets/css/chapters.css:128`** (new rule, after
`.nav__en:hover` at :121) — `.nav__en:focus,.nav__en:focus-visible{border-color:#fff;color:#fff}`
— the exact mandate target.

**`site/wp-content/themes/ea-eyalamit/assets/css/chapters.css:90`** (new rule, after
`.btn:focus-visible` at :78) — `.btn--terra:focus-visible,.btn--gw:focus-visible{color:#fff}`.
Not named in the original mandate; found during the §6 sweep, same failure class, same file —
see §6 for why these two (and not `.btn--gd`) needed it.

No other files touched. `style.css` Version left at 1.5.37 (not bumped — team_100 bumps once
for the wave, per the shared brief). Never used `git add -A`/`git add .`; nothing committed.
Diff: 2 files, **33 insertions(+), 1 deletion(-)** (`git diff --stat`).

## 4. Verification method — and two harness bugs I caught in my own tooling first

Staging serves the **old** files — this edit is local. Wrote
`scripts/qa/ws-2-1-focus-contrast-proof.cjs` (real Chrome via vendored `puppeteer-core`,
launched the same way `scripts/qa/wp-w2-12-rev2-computed-proof.cjs` does), which: navigates to
the live staging page; asserts the viewport is non-zero (1440×900, confirmed via
`window.innerWidth/innerHeight`); asserts the first real `Tab` press moves focus off `BODY`
(confirmed — lands on the skip link) before trusting anything further; walks up to 160 real
`Tab` presses (`page.keyboard.press('Tab')`, real CDP input, never `.focus()` or `.click()`)
recording computed colour + effective background for every stop; and, for the "fixed" run,
injects the proposed CSS into the live DOM via `page.addStyleTag` and repeats the same walk —
so every "after" number below was produced by live-injecting the change into the loaded staging
page, not by editing staging itself.

**Two measurement traps surfaced while building this, both caught and corrected before trusting
any number:**

1. **Effective-background walker started one node too high.** My first version walked from
   `el.parentElement`, skipping the focused element's *own* background. For anything that sets
   its own solid background (the skip link's terracotta, the CTA buttons' fill), this silently
   substituted a distant ancestor's colour instead — one early run reported `.btn--terra` on
   `rgb(0,0,0)` (a coincidental ancestor, giving a fake 21:1) and several nav links on
   `rgb(255,255,250)` (the page's own ivory background, several DOM levels up). Fixed by
   checking the element itself first (`scripts/qa/ws-2-1-focus-contrast-proof.cjs`, `eaFindBg`).
2. **Colour read mid-transition.** GeneratePress's `main.min.css` puts
   `transition:color .1s ease-in-out` on every `<a>` (chapters.css adds its own `.2s` on some
   nav items). Reading `getComputedStyle` immediately after the Tab keypress that moves focus
   catches the colour mid-animation. Caught this concretely: one early read of `.nav__en` on
   real focus returned `rgba(89,86,84,.965)` — not a real third colour, but the exact algebraic
   midpoint (~79% progress) between its resting `rgba(255,255,255,.85)` and the collapsed
   `rgb(46,43,40)`. A `getMatchedStylesForNode` cross-check (CDP, `.forcePseudoState`) on the
   *skip link* correctly showed the collapse (validating that tool), but the *same* tool on
   `.nav__en` kept showing the resting colour even after the wait was added elsewhere — i.e.
   `forcePseudoState`'s effect does not reliably reach `getComputedStyle` for a transitioning
   property, so I stopped trusting it for anything but a first hint and rely only on real
   Tab + an explicit 450ms settle wait (`SETTLE_MS` in the script) for every number reported
   below. Re-verified after the fix: real Tab + wait, both scrolled and unscrolled nav states,
   gives the same stable `rgb(46,43,40)` for `.nav__en` pre-fix — a real collapse, not a
   transition artifact.

Also: the header nav's dark tint is scroll-dependent — `ea-chapters.js:17` sets
`nav[data-s]="1"` only once `window.scrollY > 40`; below that it's a CSS gradient
(`chapters.css:100-101`) over whatever sits behind it, which isn't a flat colour and can't be
walked reliably. I deliberately scroll past 40px and assert `data-s="1"` before measuring any
nav-hosted component, so the background read is the well-defined flat `rgba(20,14,9,.95)` — the
same "dark nav" team_100's own report describes. This does not affect *whether* the bug exists
(the colliding rule sets `color` unconditionally, independent of scroll position) — confirmed by
re-running the skip-link/`.nav__en` check at `scrollY=0` too: same collapse, same final colour,
only the background (and therefore the exact ratio) differs. Numbers below are all in the
scrolled state unless noted.

## 5. Before / after measurement (two decimals, real Tab, 450ms settle)

| Component | Unfocused (ratio) | **Baseline** focused (ratio) | **Fixed** focused (ratio) |
|---|---|---|---|
| `.ea-skiplink` | `rgb(255,255,255)` on `rgb(164,78,43)` = **5.67** | `rgb(46,43,40)` = **2.48** (FAIL) | `rgb(255,255,255)` = **5.67** (PASS, = unfocused) |
| `.nav__en` | `rgba(255,255,255,.85)` on dark nav = **13.83** | `rgb(46,43,40)` = **1.36** (FAIL) | `rgb(255,255,255)` = **19.15** (PASS) |
| `.nav__b` (logo) | white on dark nav = **19.15** | `rgb(46,43,40)` = **1.36** (FAIL) | white = **19.15** (PASS, = unfocused) |
| `.btn--terra` (Contact CTA) | white on `rgb(176,95,56)` = **4.63** | `rgb(46,43,40)` = **3.04** (FAIL) | white = **4.63** (PASS, = unfocused) |
| `.btn--gw` (ghost CTA) | white, bg not reliably walkable (§6/§7) | `rgb(46,43,40)` — same collapse confirmed | white restored (colour confirmed; ratio still not walkable) |

My own skip-link numbers reproduce team_100's exactly (5.67 / 2.48). My `.nav__en` number
(1.36) falls inside team_100's own reported range (1.1–1.4). Both fixed columns are ≥4.5:1
(skip link and logo link exactly reproduce their own unfocused ratio, which is the correct
outcome — §3 says do not change the unfocused appearance, and this confirms focus now matches
it). `.btn--terra`'s restored 4.63 is the same margin its unfocused state already carries
(barely above 4.5) — a pre-existing characteristic of that button's own colour choice, not
something this mandate asks me to change, so I left it as-is.

**Regression check (unfocused, untouched by this fix) — baseline vs. fixed run, identical page,
before vs. after CSS injection:** all five components' *unfocused* colour/ratio are byte-for-byte
identical between the two runs (see raw JSON, §below). The 5.67 / 19.15 / 19.15 / 4.63 unfocused
numbers above did not move.

Raw data: `scripts/qa/reports/ws-2-1-focus-contrast-baseline.json` and `...-fixed.json` (full
160-stop Tab logs included, for the record).

## 6. The "structurally similar links" sweep — what else I checked, what I fixed, what I left alone

Per the brief's §4, checked every other anchor-colour rule in both `chapters.css` and
`ea-atoms.css` that is live in the delivered HTML (cross-referenced against real classes present
in the fetched page, not just grep). Two new same-failure-class bugs, one already-safe cluster
explained by the tie-and-order mechanism in §1, one collapse that turned out invisible, and one
partial finding on `.tlink`:

**Fixed (same failure class — single-class 0,1,0 colour rule, no existing `:focus` colour
reassertion, non-white background):**
- `.nav__b` (header logo/brand link) — §5.
- `.btn--terra` and `.btn--gw` (CTA buttons using `chapters.css:72-75`) — §5. `.btn--gd` was
  checked too and is **not** included: its focused colour also goes to `rgb(46,43,40)`, but
  against its own light background that *increases* contrast (measured 3.55:1 → 11.74:1) — the
  opposite of a failure, so no change made there.

**Already safe — confirmed by measurement, not assumed:**
- `.nav__dd` (as a link, e.g. the "Treatment" nav item) and plain `.nav__l` items are all *also*
  matched by the broader descendant rule `.nav__l a` (`chapters.css:113`) at the **same** 0,1,1
  specificity as the colliding GeneratePress rule — and being later in the cascade (§1), they win
  the tie honestly. Measured unfocused==focused (**12.89 / 12.89**) for both, confirmed unchanged
  by injecting the fix (§5 table's regression check extends to these too — see the raw JSON).
  This is *why* the mandate named only two components: everything else sharing this exact
  descendant-selector shape was never broken.
- `.nav__sub` dropdown submenu items are protected the same way, via `.nav__sub a`
  (`chapters.css:524`, same 0,1,1-tied-and-later mechanism). Measured focused **12.29** (high,
  passing) — could not capture its unfocused baseline directly since it requires the parent
  dropdown to be open first (§7).
- `.foot a` / `.foot__base a` already carry their own `.foot a:focus-visible{color:#fff;
  outline:...}` (`chapters.css:264`) — 0,2,1, unconditionally higher than the collision.
  Measured **7.30→19.81** and **6.26→19.81** — focus makes these *more* readable, not less. No
  change needed or made.
- `.tlink` (the `.sec--dark .tlink` variant, 0,2,0) measured unfocused==focused (**2.80**),
  confirmed safe. **Partial finding, not fixed:** other live `.tlink` instances outside a dark
  section (e.g. the "לתיאום שיחת היכרות" / "לקריאה נוספת אודות אייל עמית" links, found while
  walking the tab log, not through my primary component list) show focused colour
  `rgb(46,43,40)`, which — *if* that is a collapse from the base rule's `var(--terra-dk)` — would
  be the same mechanism. I did not capture their unfocused baseline directly, so I cannot state
  a before/after ratio for them specifically. What I can state: their measured background is
  `rgb(255,255,250)` (light), and **both** `var(--terra-dk)` and `rgb(46,43,40)` against that
  background compute well above 4.5:1 (≈5.9:1 and ≈15.8:1 respectively) — so even in the worst
  case this specific pair is not an SC 1.4.3 failure, just a colour change I'm not fully certain
  is intentional. Left alone: no confirmed failure, and "fix only what is in the same failure
  class" — a passing, unconfirmed maybe is not that.

**Collapse confirmed real but not visible — deliberately not fixed:**
- `.ea-whatsapp-float`. Its *own* background is opaque (`.ea-chapters .ea-whatsapp-float{
  background:rgba(14,9,5,.82)}`, `chapters.css:750` — this is the live Chapters restyle; the
  `#0F7A3F` green pill in `ea-atoms.css` is the dead Wave2 version, confirmed by the same
  body-class check as §0), so this reading is not a walker artifact. Measured **19.81 → 1.41**:
  a real collapse of the anchor's `color` property. But
  `.ea-chapters .ea-whatsapp-float__label{display:none}` (`chapters.css:753`) removes the only
  text node, and `.ea-whatsapp-float__icon{color:#25D366}` (`chapters.css:754`) sets the visible
  SVG icon's colour directly,
  independent of the anchor's own `color` — so the collapsing property has no visible glyph
  reading it. The button's focus indicator is unaffected either way
  (`.ea-whatsapp-float:focus-visible{outline:2px solid #fff}`, `ea-atoms.css:1199`, confirmed
  still rendering, `outlineStyle:"solid"` in both runs). Not included in the fix: adding `color`
  here would be an unmapped hunk against a property nothing displays.

## 7. What I could not measure / where I believe this is incomplete

- **`.btn--gw`'s exact ratio.** It sits inside a `.cmpc` comparison card whose dark appearance
  comes from `.cmpc__sc{position:absolute;inset:0;background:rgba(18,12,8,.6)}` — an
  **absolutely-positioned sibling**, not an ancestor background. My walker (and the brief's own
  prescribed method, "walk ancestors") cannot see a sibling's background by design, so I can
  confirm the colour collapses (white → `rgb(46,43,40)`) and is restored by the fix, but not the
  precise before/after ratio. Given `.cmpc{color:#fff}` (the card's own established text colour)
  and `.btn--gw{color:#fff}` agree, white is clearly the intended colour here, so the fix
  (restoring it) is correct regardless of the exact number.
- **The `.tlink` partial finding above** — flagged, not resolved either way.
- **Real assistive-technology behaviour** (VoiceOver/NVDA/JAWS) was not tested — only Chrome
  keyboard-event + computed-style measurement, per the tooling available to this line. Nothing
  about semantics (roles/attributes) changed, only `color`/`border-color` values, so I have no
  reason to expect AT-specific discrepancy, but I did not verify it directly.
- Two harness bugs in my own script were caught and fixed before they could produce a false
  result (§4) — flagging that they existed at all, per this report's own instructions, rather
  than presenting only the corrected numbers as if they were the first ones I got.
- Everything else in §5/§6 was measured directly and positively, not inferred.

## 8. Deploy status

Not deployed. This edit exists only in the local working tree at
`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026`; staging continues to serve the old
`chapters.css` / `ea-atoms.css` until team_100 deploys (FTP is IP-allowlisted regardless — not
something this line can or should do). Every "Fixed" number in §5/§6 was produced by
live-injecting the same CSS into the loaded staging page in a real browser
(`page.addStyleTag`), not by editing staging itself. The live site is **not** fixed yet.

`style.css` Version: left at **1.5.37**, not bumped (team_100's call, per the shared brief).
