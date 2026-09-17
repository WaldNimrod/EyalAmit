# WS-2.2 — DONE: mobile nav keyboard trap (Chapters `#nav`)

Builder: team_10 (this line) · Date: 2026-09-18
Mandate: WS-2.2 — after a keyboard user opens the mobile menu, they cannot reach it.
Report per `_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/00-BRIEF-SHARED-FIX.md`.

Per the shared brief: I am BUILDING this fix, not verifying it. Everything below is my own
measurement to convince myself the fix is real before handing it off — the PASS call belongs
to a different line (Iron Rule #1).

## 0. Which nav system is live (proved before editing)

Fetched the staging home page (`http://eyalamit-co-il-2026.s887.upress.link/`, HTTP 200,
76674 bytes) and located selectors in the delivered HTML directly, not by reading source:

- `id="nav"` at byte offset 30785, `<ul class="nav__l"` at 30999, `<div class="nav__r"` at
  34347, `class="nav__burger"` at 34725 — all present. Gap from the `<ul>` to the burger:
  34725 − 30999 = 3726 bytes ≈ 3.7KB, matching the brief's figure.
- Wave2/dead-system selectors (`ea-topnav`, `ea-mnav-drawer`) — zero matches in the same HTML.

Confirms the brief: Chapters (`#nav` / `.nav__burger` / `section-nav.php`) is what ships;
Wave2 (`ea-mobile-nav.js` / `.ea-topnav`) is not rendered on this page. All edits below target
the live (Chapters) system only.

## 1. Root cause

`template-parts/chapters/section-nav.php` (before edit): `<ul class="nav__l">` (menu) opened
at old line 21, `<button class="nav__burger">` (open/close trigger) at old line 78, nested
inside `<div class="nav__r">`. The menu is ~3.7KB earlier in source than the burger, with
nothing between them that would reorder tab stops (no `tabindex`, and CSS `order` — confirmed
absent from every `.nav`/`.nav__b`/`.nav__l`/`.nav__r` rule in `assets/css/chapters.css` prior
to this change — does not affect tab order regardless).

Consequence, confirmed live (§5 below, real keyboard events, unpatched staging):
- From page load, 33 real `Tab` presses are needed to reach the burger; 28 of those 33 land
  inside the (closed, off-screen) `.nav__l` menu, because `.nav__l` is hidden at mobile width
  only via `transform:translateX(100%)` (`assets/css/chapters.css:641`, current numbering —
  this rule itself is unchanged by this fix, only shifted down by the comment added at :633-637),
  never `display:none`/`hidden`/`inert` — so it stays fully tabbable while visually off-canvas.
- After reaching the burger and opening it with a real `Enter` keypress (`aria-expanded` and
  `data-menu` both flip correctly — `ea-chapters.js:58-64` already did this right, per the
  brief), the next `Tab` moves forward in DOM order **past** `.nav__r` and out of `<nav>`
  entirely, landing on `A.btn.btn--terra "לתיאום שיחת היכרות"` — a call-to-action button in
  page content behind the nav. The menu the user just opened is never reached. This is the
  mandate defect, reproduced live as a third independent measurement line (two audits +
  team_100's DOM check, per the brief, now +1).

## 2. Fix chosen: (a) DOM order, burger extracted alone — with reasoning

Chose option (a) (DOM order) over (b) (JS focus trap), per the brief's own framing: it is the
more honest fix, needs no new interaction logic, and — critically — checking the CSS first
(as the brief required before assuming free reordering) showed a way to do it with **zero**
visual or focus-order impact at desktop, which a naive reorder would not have had. Reasoning:

- `.nav` is `display:flex` (`chapters.css:88`) with children `.nav__b`, `.nav__l`, `.nav__r` in
  that order, no `order` set on any of them (verified: `grep -n "order:" chapters.css` matches
  only `.split2--rev` and `.testi-mq__btn*`, never a `.nav*` selector) — so at desktop, visual
  order = DOM order.
- `.nav__burger` is `display:none` at desktop (`chapters.css:627`, unchanged by this fix) and
  only `display:flex` under `@media(max-width:1180px)` (was line 633 before this edit, now
  `:638`, quoted in full in §3). A `display:none` element is
  excluded from flex layout AND from the desktop tab sequence entirely (not just invisible —
  unfocusable). So **wherever the burger sits in the DOM, desktop rendering and desktop tab
  order are unaffected**, as long as nothing else moves.
- Swapping the *whole* `.nav__r` (sound toggle + EN link + burger) before `.nav__l` — the
  literal reading of "move the burger before the menu list" — would have dragged the visible
  sound/EN controls along with it, changing **desktop** tab order (sound/EN before the menu,
  where visually they still render after it) even though desktop rendering itself would stay
  pixel-identical via `order`. That is a new SC 2.4.3 mismatch I chose not to introduce.
- So the smallest-blast-radius version: extract **only** the `<button class="nav__burger">`
  from inside `.nav__r`, and place it alone as a direct child of `<nav>`, immediately before
  `.nav__l`. Confirmed no CSS selector anywhere scopes `.nav__burger` through a `.nav__r`
  ancestor (`grep -n "nav__r.*burger"` → no matches), and `ea-chapters.js:43` finds it via
  `nav.querySelector('.nav__burger')`, which does not care about nesting depth — so nothing
  else in the codebase depends on the burger's old position inside `.nav__r`.

Also read the dead `assets/js/ea-mobile-nav.js` before writing anything, per the brief's
instruction to reuse rather than reinvent. Its `closeDrawer()` (lines 61-68) always restores
focus to whatever triggered the open (`lastFocus.focus()`), on every close path — Escape,
close-button, scrim-tap, or link-tap alike, not just Escape. I mirrored that single-path
contract in `ea-chapters.js` (§below) rather than special-casing Escape.

## 3. Changes made (file:line)

**`site/wp-content/themes/ea-eyalamit/template-parts/chapters/section-nav.php:21-28`** — new
`<button class="nav__burger">` block (attributes unchanged: `aria-label`, `aria-expanded`,
`aria-controls` all identical to before) inserted as a direct child of `<nav>`, immediately
after the brand link (`:17-19`) and immediately before `<ul class="nav__l">` (now `:30`). The
original burger markup removed from inside `<div class="nav__r">` (was old `:78-80`; `.nav__r`
now contains only the sound-toggle button and the EN link, `:82-87`). A source comment at
`:21-25` documents why, citing this mandate.

**`site/wp-content/themes/ea-eyalamit/assets/css/chapters.css:638`** — inside the existing
`@media(max-width:1180px)` block: `.nav__burger{display:flex}` → `.nav__burger{display:flex;
order:1}`. Purpose: restore the burger's visual position at the end of the mobile header
cluster (after sound/EN), since it is now DOM-first but must still *render* last, and CSS
`order` changes paint position without touching tab order. No-op above 1180px (burger is
`display:none` there, so not a flex participant regardless of `order`) and no-op for `.nav__l`
placement (it is `position:fixed` at this breakpoint — `chapters.css:639` — so it is not a
flex participant either, and never was affected by sibling order).

**`site/wp-content/themes/ea-eyalamit/assets/js/ea-chapters.js:45-57`** — `closeMenu()` gained
one line, `burger.focus();`, at the end (`:56`), after the existing `nav.removeAttribute`,
`aria-expanded` and `nav-locked` lines. Fires on every existing close path unchanged: Escape
(`:69-71` guarded, only when `data-menu==='1'`), a real link tap (`:65-68`), and re-clicking the
burger while open (`:58-64`, specifically the `if (open) {closeMenu(); return;}` branch at
`:60`). A no-op when the burger already has focus, and a no-op at desktop
width where the burger is `display:none` and therefore cannot receive focus.

No other files touched. `style.css` Version left at 1.5.37 (not bumped, per the shared brief —
team_100 bumps once for the wave). Total diff: 3 files, 23 insertions, 4 deletions
(`git diff --stat`).

## 4. Verification method (and why it's trustworthy)

Staging serves the **old** files — this edit is local. To measure the fix I drove real Chrome
(`puppeteer-core` 23.11.1, vendored at `scripts/qa/node_modules/`, launched exactly as
`scripts/qa/http-qa-axe.cjs` does: `executablePath` = local Google Chrome.app,
`--ignore-certificate-errors` for the by-design-invalid staging cert) against the live staging
page, then **injected the same three changes onto the live DOM** (moved the real burger node,
added the same `order:1` rule via an injected `<style>`, re-bound `closeMenu`/open logic with
the `burger.focus()` line included) and re-measured with the same real-keyboard harness. Every
key press below is `page.keyboard.press(...)` — real CDP input dispatch — never
`element.focus()` or `.click()`. Viewport asserted non-zero before every measurement
(mobile: 390×844; desktop: 1440×900) — both confirmed via `window.innerWidth/innerHeight`
before proceeding, per the brief's `0x0` trap warning. First `Tab` press on a fresh page load
was confirmed to move focus off `BODY` (landed on the skip-link) before trusting any further
result, per the brief's other explicit trap warning — real key events confirmed working, not a
COULD-NOT-MEASURE case.

Two problems surfaced *in the test harness itself* during this work, both caught and corrected
before trusting any number — noted here in full because catching them is exactly the discipline
the brief asks for, and because it explains why some intermediate numbers below were discarded
rather than reported:

1. **Transition-timing trap (my own).** An early check of the "does the open panel cover the
   viewport" claim (see §6) read `.nav__l`'s bounding rect with zero delay after the `Enter`
   keypress and got a false-looking "still off-screen" result. `.nav__l` animates via
   `transition:transform .35s` (`chapters.css:641`); reading geometry before a CSS transition
   settles samples mid-flight, not the resting state. Re-measured at t=0/100ms/500ms — see §6.
2. **Duplicate-listener race (an artifact of live-injecting onto a page that already ran the
   *old* script).** Because only the burger *node* was moved/replaced, staging's original,
   unpatched `ea-chapters.js` was still attached to `window`'s `keydown` for Escape, racing my
   injected listener on the same shared `nav[data-menu]` flag — the stale original fired first
   (bubble order = attachment order), cleared the flag, and my listener then saw "already
   closed" and skipped. This cannot happen in the real deploy (one script, one listener, no
   race) — it is purely a limitation of testing-by-injection. Fixed for the test only by
   registering the injected Escape listener with `capture:true` and calling
   `stopPropagation()`, so it runs and wins before the stale bubble-phase original ever fires.
   The *actual* file at `ea-chapters.js:56` has no such trick and needs none — there is only
   one listener in the real deploy. Re-ran the Escape check after this correction; see §5.

## 5. Before / after measurement

**Baseline, unpatched staging, mobile viewport (390×844):**

- Full closed-state tab walk from page load, real `Tab` × 33 to reach the burger:
  skip-link → brand → then 28 consecutive stops inside `.nav__l` (every top-level link/button
  and every submenu link, e.g. `טיפול בדיג׳רידו`, `נחירות ודום נשימה בשינה`, … through
  `צור קשר`) → sound-toggle button → EN link → burger (33rd stop). **28 of 33 confirmed
  geometrically inside `.nav__l`** — matches the brief's cited 32-before/28-off-screen exactly.
- Real `Enter` on the burger: `nav[data-menu]` → `"1"`, `.nav__burger[aria-expanded]` →
  `"true"` — the existing toggle logic is correct, confirmed live (matches the brief).
- One more real `Tab`: focus lands on `A.btn.btn--terra "לתיאום שיחת היכרות"` — **outside**
  `.nav__l`, outside `<nav>` entirely. **Bug reproduced, live, with real key events.**

**After injecting the fix, same page, same viewport:**

- Tab walk from page load to burger: skip-link → brand → burger. **3 stops (was 33).**
- Real `Enter` on burger → `data-menu="1"`, `aria-expanded="true"`; focus stays on the burger
  (correct — activating a button doesn't relocate focus).
- Real `Tab` → focus lands on `A.nav__dd "טיפול בדיג׳רידו▾"`, confirmed
  `.closest('.nav__l')` truthy. **Tab from the burger enters the menu — PASS.**
- Real `Shift+Tab` from there → focus lands back on `BUTTON.nav__burger`. **Shift+Tab returns
  to the burger — PASS.**
- Re-opened, real `Tab` into the menu, then real `Escape` (measured after correcting the
  duplicate-listener race per §4.2, with explicit state checks at every step, not assumed):
  `data-menu` → `null`, `aria-expanded` → `"false"`, focus → `BUTTON.nav__burger`. **Escape
  closes and returns focus to the burger — PASS.** A second `Escape` immediately after (menu
  already closed) changed nothing — guard condition holds, no double-fire.
- `aria-expanded` observed correct at every state transition above (false → true on open,
  true → false on close). **PASS.**
- Full post-fix open-menu tab sequence recorded for the record (burger → 28 menu stops →
  sound-toggle → EN link → first page-content button) — same 28 menu items as before, now
  positioned after the burger instead of before it; see §7 for what this means.

**Desktop, before vs. after (1440×900), 15-stop walk from page load:**

- Before: skip-link, brand, `טיפול בדיג׳רידו▾`, `השיטה`, `שיעורי דיג׳רידו`, `סאונד הילינג`,
  `לימוד והכשרה▾`, `כלים ואביזרים▾`, `ספרים▾`, `בלוג דיג׳רידו`, `אייל עמית▾`, `צור קשר`,
  sound-toggle, EN link, first page-content button.
- After (same fix injected): byte-for-byte identical sequence, same 15 elements in the same
  order.
- **Desktop tab sequence unchanged — PASS**, and separately confirmed
  `getComputedStyle('.nav__burger').display === 'none'`,
  `getComputedStyle('.nav__l').display === 'flex'` (i.e. the normal horizontal menu, not the
  mobile drawer) at this width post-fix — nothing about desktop rendering changed either.

## 6. Independently verified: "menu doesn't cover the viewport" claim — not reproducible

The brief asked me to check this independently and fix it only if it's part of the same
defect. My first read (zero-delay, see §4.1) suggested `.nav__l` stayed off-screen after
opening. Re-measured its `getBoundingClientRect()` and computed `transform` at t=0 (right after
the `Enter` keypress), t=100ms, and t=500ms, on the **unpatched** page (this claim has nothing
to do with the burger's DOM position, so the baseline script is the right one to check it on):

- t=0: `transform: matrix(1,0,0,1,390,0)` (i.e. `translateX(100%)` of its own 390px width),
  rect `left:390, right:780` — off-screen, matches the audited claim.
- t=100ms: `translateX(72px)` — mid-animation.
- t=500ms (transition duration is 350ms, `chapters.css:641`): `transform: none`, rect
  `left:0, right:390` — **full viewport width, edge-to-edge**, top at 72px (below the fixed
  header), matching `inset:72px 0 0 0`.

**Conclusion: does not reproduce once the transition settles.** The claim was very likely
measured with the same zero-delay pattern I initially fell into myself — a timing artifact, not
a real defect. Not part of the WS-2.2 defect (which is about DOM/tab order, not this geometry),
and per the brief's own instruction ("fix it only if it is part of the same defect"), and since
it isn't even reproducible, **no change made for this claim.**

## 7. What I could not measure / where I believe this is incomplete

- **Closed-menu tab stops did not disappear — they moved.** A keyboard user who tabs past the
  burger *without* pressing Enter still passes through all 28 menu links (now off-screen and
  closed, exactly as before) before reaching the sound-toggle and EN link — because, as
  established in §1, `.nav__l` is hidden only via `transform`, never `display:none`/`hidden`/
  `inert`, so closed-state focusability is unconditional on `data-menu` and unrelated to where
  the burger sits in the DOM. This is the *same* underlying trait the brief measured as "28
  off-screen stops," just relocated to after the burger instead of before it. I deliberately
  did not add `inert`/`tabindex` toggling to remove this, for two reasons: (a) the mandate's
  explicit acceptance list (Tab-enters-menu / Shift+Tab-returns / Escape-restores /
  aria-expanded-correct / desktop-unchanged) does not ask for it, and the dead
  `ea-mobile-nav.js` reference — which the brief told me to model the fix on — doesn't do it
  either (its closed drawer is also only `transform`-hidden, `assets/css/ea-mobile-nav.css`,
  not display/inert-gated); (b) the verifier contract penalizes unmapped hunks, and this is a
  distinct, pre-existing characteristic rather than the specific defect I was asked to fix. I'm
  flagging it here rather than silently leaving it, per this report's own instructions — a
  follow-up (`inert` on `.nav__l` toggled alongside `data-menu`) would close it cleanly if
  team_100 wants it as its own item.
- **Real assistive-technology (VoiceOver/NVDA/JAWS) behavior was not tested** — only Chrome
  keyboard-event/DOM measurement, per the tooling actually available to this line. I have no
  reason to expect a discrepancy (nothing about AT-specific semantics changed — same elements,
  same attributes, same roles, only DOM position and one added `order` and one added
  `.focus()`), but I did not verify it directly and am not claiming I did.
- Everything else in the acceptance list (§5) was measured directly and positively, not inferred.

## 8. Deploy status

Not deployed. This edit exists only in the local working tree at
`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026`; staging continues to serve the old
`section-nav.php` / `chapters.css` / `ea-chapters.js` until team_100 deploys (FTP is
IP-allowlisted regardless — not something this line can or should do). Every "after" result
above was produced by live-injecting the same change into the loaded staging page in a real
browser, not by editing staging itself — called out explicitly per the brief's instruction not
to imply the live site is already fixed.
