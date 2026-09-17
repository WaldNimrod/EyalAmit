# WS-3B — DONE: submenu state + Hebrew form reporting errors in English

Builder: team_10 (this line) · Date: 2026-09-18
Mandate: WS-3B (P1) — task 1: two submenu toggles never report state; task 2: Contact Form 7
validates in English inside a Hebrew form. Report per
`_COMMUNICATION/team_10/A11Y-FIX-2026-09-18/00-BRIEF-SHARED-FIX.md`.

Per the shared brief: I am BUILDING these fixes, not verifying them. Everything below is my own
measurement to convince myself each fix is real before handing it off — the PASS call belongs to
a different line (Iron Rule #1). I did not mark either task PASS anywhere in this document.

## 0. Scope actually touched

- `site/wp-content/themes/ea-eyalamit/assets/js/ea-chapters.js` — task 1 (only file changed for it).
- `site/wp-content/mu-plugins/ea-w2-15-cf7-contact-form-once.php` — task 2 (only file changed for it).
- New: `scripts/qa/ws-3b-nav-dd-aria-proof.cjs` — verification harness (not shipped to the site;
  same category as the existing `ws-2-1-focus-contrast-proof.cjs`).
- `assets/js/ea-hero.js` — read, not edited (see A.2 — its dropdown block was the reference
  implementation, but is bound to a dead selector and was not reusable verbatim; nothing in it
  needed changing for this mandate).
- No CSS file touched. **No `section-nav.php` change is being requested** — explained in A.2; the
  fix is fully achievable from `ea-chapters.js` against the existing static markup.
- Not committed, not deployed, `style.css` Version untouched.

This worktree is shared with other concurrently-running lines (per the brief). I saw uncommitted
local edits to `chapters.css`, `chapters-render.php`, `books-v2.css`, and two `*-defaults.php`
files appear mid-session, and `git log` gained several unrelated commits (image alt-text, gallery
dedup, heading structure) while I worked — none of it touches navigation or the contact form.
Where I cite `chapters.css` line numbers below, they are **against git HEAD**
(`13633bb3f777510d022a2c6794a9d262bd30ee15` at time of writing), because another line's
uncommitted, in-progress edit near the top of that file (an 11-line contrast-token comment) shifts
every line number below it in the live working tree. I verified my cited HEAD line numbers still
match content 1:1 (`git show HEAD:...` re-checked against my original reads) before using them.

---

# PART A — Task 1: submenu `aria-expanded` state

## A.0 Which nav is live (proved before editing)

Fetched the staging home page fresh for this task (`http://eyalamit-co-il-2026.s887.upress.link/`,
HTTP 200, 83823 bytes — not the 150-byte truncation trap):

- `id="nav"` × 1, `class="nav__dd"` × 5, `class="nav__burger"` × 1 — all present in the delivered
  HTML. This matches `section-nav.php` exactly: 3 `<a class="nav__dd">` (`:32,52,63`) + 2
  `<button class="nav__dd">` (`:42,73`) = 5.
- `ea-topnav__dropdown-toggle` (the selector the dead reference implementation binds) — **0**
  matches in the delivered HTML.
- One nuance worth stating precisely: `assets/js/ea-hero.js` **is** enqueued on this page
  (`<script id="ea-wave2-hero-js" src=".../ea-hero.js?ver=1.5.38">`, confirmed in the live
  `<script>` tags) — it is not dead in the sense of never running. Its dropdown block
  (`ea-hero.js:47-75`) does run on every load, but
  `document.querySelectorAll('.ea-topnav__dropdown-toggle')` returns an empty NodeList on this
  page (0 matches, confirmed above), so the block's `if (toggles.length)` guard short-circuits and
  it produces zero live effect. "Dead" here means dead-in-effect, not dead-in-execution — worth
  being exact about since the brief's own framing ("wired to the wrong selector") is about effect,
  and I do not want to overclaim what I measured.

Confirms the brief: Chapters (`#nav` / `.nav__dd` / `section-nav.php`) is what ships to visitors;
the Wave2 dropdown-toggle code runs but touches nothing live. All edits below target the live
(Chapters) system only.

## A.1 Root cause

`template-parts/chapters/section-nav.php:42` and `:73` — both
`<button class="nav__dd" type="button" aria-haspopup="true" aria-expanded="false">` — start at
`aria-expanded="false"` and nothing in the theme's JS ever changed it (measured by team_100: 0
occurrences of `nav__dd` in any theme JS file before this change; I re-confirmed this with my own
`grep -rn "nav__dd" --include="*.js" .` before writing anything — 0 matches, same result).

Their sibling `<ul class="nav__sub">` is revealed **purely by CSS**, not by anything keyed off
`aria-expanded`:

- Desktop (`chapters.css:522`, HEAD): `.nav__l>li:hover .nav__sub,.nav__l>li:focus-within
  .nav__sub{opacity:1;visibility:visible;transform:none}` — hover or focus-within on the `<li>`
  reveals it. `chapters.css:527`: `@media(max-width:1180px){.nav__l{display:none}}` — this is the
  desktop/mobile boundary the rest of the fix keys off.
- Mobile (`chapters.css:671` `@media(max-width:1180px)` block): `chapters.css:684`
  `.nav__sub{position:static;opacity:1;visibility:inherit;...}` — every submenu is inline and
  **permanently expanded together** inside the open drawer, not gated by hover/focus on the
  individual item. `chapters.css:691-692` deliberately **defeats** the desktop hover/focus-within
  rule at this width (`.nav:not([data-menu="1"]) .nav__l>li:hover .nav__sub, ...:focus-within
  .nav__sub{visibility:inherit}`) — this is the fix that closed the 18-leaked-links defect in
  commit `57883f8` this morning; I read it as a hard constraint, not something to route around.
- Confirmed via `grep -n "aria-expanded" chapters.css` → **0 matches**. Nothing in the live CSS
  reads this attribute at all, unlike the dead system (`ea-atoms.css:298`:
  `.ea-topnav__dropdown-toggle[aria-expanded="true"] + .ea-topnav__submenu{...}` — visibility
  literally keyed off the attribute there).

One correction to the brief's own count: it describes ".nav__dd is also used on **four** `<a>`
elements (`:32, :52, :63`)" — that parenthetical lists three line numbers, and `grep -n
'class="nav__dd"' section-nav.php` finds exactly **three** `<a class="nav__dd">` (`:32,52,63`,
plus the two `<button>` at `:42,73` = 5 total occurrences of the class). I could not find a fourth
anywhere in the theme (`grep -rn "nav__dd"` across all `.php`/`.js`/`.css` — only these five plus
the CSS rules). Flagging the discrepancy rather than silently matching "four" to what I actually
found.

## A.2 Fix chosen, and why not a verbatim port of `ea-hero.js:51-64`

The brief points at `ea-hero.js:47-75` as "the correct implementation," and it is well-built —
click toggle, close-others, Escape, outside-click — but that logic exists because *on the dead
side*, `aria-expanded` **is** the visibility driver (the CSS rule quoted above,
`ea-atoms.css:298`). Porting it verbatim to the live nav would set the attribute correctly while
changing nothing on screen (`chapters.css` has zero `[aria-expanded]` selectors), and — worse — it
would fight the live CSS: a click-driven "closed" state would leave `aria-expanded="false"` while
the mouse is still hovering and CSS is still showing the panel, which is a **new** lie, not a fix.
So I read the live CSS as the contract and wrote JS that mirrors exactly the conditions that
already drive it, rather than reusing the dead nav's state-owning model:

- **Desktop (`ea-chapters.js:41-127`, guarded so it no-ops below 1180px):** for each `.nav__dd`
  button, `mouseenter`/`mouseleave`/`focusin`/`focusout` on its parent `<li>` re-read
  `li.matches(':hover') || li.matches(':focus-within')` live and write that straight to
  `aria-expanded`. Since these are the *same* native events the CSS pseudo-classes are defined by,
  the attribute cannot drift from what is drawn — it is reading the same ground truth the renderer
  reads, not a parallel model of it. `chapters.css` already requires `:focus-within` support for
  its own core nav to work at all (`:522,543,544,691-692`), so relying on `Element.matches`
  against it adds no new browser-support burden.
- **Mobile (≤1180px):** since the CSS makes every submenu expand **together** with the drawer
  (§A.1), per-item hover/focus tracking would be answering the wrong question. Instead
  `syncDrawerExpanded()` (`ea-chapters.js:93-98`) sets all `.nav__dd` buttons' `aria-expanded` to
  match `nav.getAttribute('data-menu') === '1'`, called from the exact two places `data-menu`
  changes: inside `closeMenu()` (`:148`, covers Escape + link-tap + re-click-to-close, since all
  three already call `closeMenu()`) and the burger's own open branch (`:156`). A
  `matchMedia('(max-width: 1180px)')` change listener (`:113-123`) re-settles every button if the
  viewport crosses the breakpoint mid-session (resize, orientation change, or a test harness
  calling `setViewport` without a reload).
- **Deliberately not done, with reasons (per the brief's "decide deliberately... justify either
  way"):**
  - **The three `<a class="nav__dd">` anchors get no `aria-haspopup`/`aria-expanded`.** They are
    primary navigation links — activating them navigates, it does not toggle anything — and the
    measured defect is specifically the two buttons' hardcoded state. Their submenus remain fully
    reachable and announced as an ordinary list either way; nothing WCAG requires is missing for a
    link whose only action is navigation. Adding dynamic ARIA state to markup outside my ownership,
    for elements the mandate does not cite, risked the verifier contract's "unmapped hunk" clause
    for no cited benefit.
  - **No click/Escape/outside-click handling added for the two buttons.** This dropdown closes
    itself the instant hover/focus leaves (that is what `:hover`/`:focus-within` mean) — there is
    no "stuck open" state for Escape to solve here, unlike the dead nav's click-toggle model, which
    needed one because its open state persisted independent of focus/hover. Adding one would be new
    interaction surface on a live nav, not required by SC 4.1.2, and explicitly the kind of
    unrequested change the brief warns against.
  - **No `aria-controls` added.** Nice-to-have per APG, not required for Name/Role/Value, and
    would need an `id` added to each `.nav__sub` in `section-nav.php` (outside my ownership) purely
    for a relationship nicety unrelated to the cited defect. Noted here as a possible future
    follow-up, not requested as a change.

## A.3 Changes made (file:line, current file state)

**`assets/js/ea-chapters.js:41-127`** — new block, inserted before the existing "mobile hamburger"
block so `syncDrawerExpanded` is defined before it is referenced:
- `:80` `ddToggles` — all `.nav__dd[aria-haspopup="true"]` under `#nav` (the 2 buttons only, by
  construction of the selector — the 3 anchors have no `aria-haspopup` so they are excluded).
- `:81-83` `narrowMQ` — `matchMedia('(max-width: 1180px)')`, with a feature-detected no-op fallback
  if `matchMedia` is unavailable (matching the existing `reduce` guard style at `:25`).
- `:85-89` `syncDesktopOne(toggle)` — the live hover/focus-within read described in A.2.
- `:93-98` `syncDrawerExpanded()` — the mobile drawer-driven sync described in A.2.
- `:100-126` wiring: per-button hover/focus listeners (`:101-111`), the breakpoint-change handler
  (`:113-123`), and an initial settle call if the page loads already narrow (`:125`).

**`assets/js/ea-chapters.js:129-166`** (existing "mobile hamburger" block, two one-line additions):
- `:148` — `syncDrawerExpanded();` added at the end of `closeMenu()` (`:133-149`), right after the
  pre-existing `burger.focus()` (`:144`, from this morning's WS-2.2 fix). Fires on every path that
  already calls `closeMenu()`: re-clicking the burger while open (`:150-152`, the
  `if (open) { closeMenu(); return; }` branch), a real link tap (`:158-161`), and Escape
  (`:162-164`).
- `:156` — `syncDrawerExpanded();` added at the end of the burger's own open branch (`:150-157`,
  the `data-menu`/`aria-expanded`/`nav-locked` lines at `:153-155`).

No other files touched for task 1. `git diff --stat` for this file: 93 insertions, 0 deletions.

## A.4 Verification method

Staging serves the **old** `ea-chapters.js` — this edit is local, not deployed. To measure it
without deploying, `scripts/qa/ws-3b-nav-dd-aria-proof.cjs` drives real Chrome
(`puppeteer-core`, launched the same way as `ws-2-1-focus-contrast-proof.cjs`:
`executablePath` = local Google Chrome.app, `--ignore-certificate-errors` for the by-design-invalid
staging cert) against the **live** staging page, with `page.setRequestInterception(true)`
substituting only the exact `assets/js/ea-chapters.js` request with this repo's edited local file
(confirmed: `interceptHits: 2`, one per page load). I chose response-substitution over
`page.addScriptTag` deliberately — the latter would run a **second** copy of the IIFE alongside the
live one and double every listener, which is not what a real deploy would do.

Real interaction only: `page.hover()` (native `mouseenter`/`mouseleave`, not a synthetic dispatch)
and `page.keyboard.press('Tab')` in a loop reading `document.activeElement` (not
`element.focus()`). First Tab moving focus off `BODY` is asserted explicitly before any
focus-based result is trusted (`sawOffBody`/`offBody` in the report — both runs: `true`).
Viewport non-zero asserted at both 1440×900 and 390×844. Page-load success asserted via HTTP status
+ byte count before reading anything (both passes: HTTP 200, ~84.9KB, not the 150-byte trap).

Full raw output: `scripts/qa/reports/ws-3b-nav-dd-aria-proof.json` (written fresh on the last run).

## A.5 Before / after measurement

**Before (unmodified live script, static markup only):** both buttons ship
`aria-expanded="false"` and nothing changes it — this is the cited defect, and I did not
re-measure the "before" separately since it is definitionally the static HTML team_100 already
measured.

**After (local fix, live-injected, two full runs):**

| Check | Run 1 | Run 2 |
|---|---|---|
| Desktop hover, button 0 ("לימוד והכשרה"): false → true → false | pass | pass |
| Desktop hover, button 1 ("אייל עמית"): false → true → false | pass | pass |
| Real-Tab focus onto button 1 sets `aria-expanded="true"` | pass | pass |
| Still `"true"` while Tab has moved to a link inside its own submenu | **flaked, see below** | pass |
| Reverts to `"false"` once Tab moves past the `<li>` entirely | pass | pass |
| 3 `<a class="nav__dd">` anchors: no `aria-expanded`, no `aria-haspopup` | pass | pass |
| 390px, drawer closed: 0 focusable elements inside `.nav__l` | pass | pass |
| 390px, real click opens drawer: both buttons flip to `"true"` together | pass | pass |
| 390px, open: 28 focusable elements inside `.nav__l` | pass (28) | pass (28) |
| Escape closes drawer; both buttons revert to `"false"` | pass | pass |
| 390px, re-closed after Escape: 0 focusable elements inside `.nav__l` | **anomalous: 2** | pass (0) |

(Every row is traceable to the raw JSON at `scripts/qa/reports/ws-3b-nav-dd-aria-proof.json`.)

Two things I want to be exact about rather than smooth over:

1. **Run 1's "still true inside the submenu link" read came back false.** I did not accept that
   as a real bug without checking: my first version of the test harness's `tabWalk()` helper read
   `document.activeElement` immediately after `page.keyboard.press('Tab')` with **no settle delay**
   — unlike the hover test (which had one) and unlike `ws-2-1-focus-contrast-proof.cjs`'s own
   pattern (`SETTLE_MS`, with a comment explaining exactly this class of race). I added a matching
   delay, re-ran, and it passed — and passed again on the full Run 2. I'm reporting the flaked
   first reading rather than deleting it, but I believe it was my harness racing ahead of the
   browser's own focus-event dispatch, not the fix.
2. **Run 1's re-closed-after-Escape count came back 2 (expected 0).** This one I could not fully
   close the loop on. I wrote a smaller, isolated diagnostic reproducing just the
   open→Escape→re-measure sequence (`page.click('.nav__burger')` → 45 tabs → `Escape` → 450ms
   settle → blur → 20-tab count), and it read **0/20** cleanly, with `.nav__l`'s computed
   `visibility` confirmed `"hidden"` at every step and focus confirmed correctly restored to
   `BUTTON.nav__burger` after Escape. Run 2 of the full script also read 0. So: 1 anomalous reading
   out of 3 independent measurements of the same assertion, not reproducible in isolation. I am
   reporting it rather than hiding it, but I do not have a diagnosed cause for that single reading,
   and I am not confident enough to call it either "real" or "definitely noise" — flagging as
   **could not fully explain**, not asserting a pass on the strength of 2-out-of-3.

## A.6 What I could not measure / where I believe this could still be wrong

- I could not measure any of this against the **actually deployed** site — see A.7.
- I did not test with a real screen reader (VoiceOver/NVDA). Everything above is DOM-state
  (`aria-expanded` value) and real key/mouse events, not an assistive-technology transcript.
- Touch-specific interaction (a real touchscreen tap, as opposed to Puppeteer's mouse click) was
  not separately tested at 390px — the drawer open/close itself is unchanged by this fix (I only
  added a same-tick `aria-expanded` sync after the pre-existing state change), so I have no reason
  to expect a difference, but I have not driven a real touch event to confirm it.
- The single unreproduced "2" reading in A.5 — see above; not confidently explained.
- A screen-reader user who hovers with a mouse *while also* having left-over keyboard focus deep in
  a previously-opened different submenu was not specifically tried (an unusual combination); the
  logic is symmetric per-button so I expect it to hold, but I did not construct that exact scenario.

## A.7 Deploy status

Not deployed. This edit exists only in the local working tree; staging continues to serve the old
`ea-chapters.js` until team_100 deploys. Every "after" result in A.5 was produced by
request-intercepting the live staging page in a real browser and substituting only this one local
file, not by editing staging itself.

---

# PART B — Task 2: Contact Form 7 validates in English inside a Hebrew form

## B.1 Investigation — what's actually happening (done live, before choosing a fix)

Submitted the real staging form twice, safely (validation blocks send both times — no message was
sent, per the brief's constraint):

**Trigger 1 — all required fields empty.** Read the rendered DOM directly (not a visual read):

```
responseOutput.text = "קיימת שגיאה בשדה אחד או יותר. נא לבדוק ולנסות שוב."   (Hebrew)
tips (.wpcf7-not-valid-tip, one per empty required field):
  your-name    -> "Please fill out this field."   (English)
  your-email   -> "Please fill out this field."   (English)
  your-subject -> "Please fill out this field."   (English)
htmlLang = "he-IL", htmlDir = "rtl"; none of the tip spans carry a lang attribute at all.
```

**Trigger 2 — name/subject valid, phone and email deliberately malformed** (`your-phone` =
"abc-not-a-phone", `your-email` = "not-an-email"; still blocked client/server-side before send):

```
responseOutput.text = "קיימת שגיאה בשדה אחד או יותר. נא לבדוק ולנסות שוב."   (Hebrew, same string)
tips:
  your-phone -> "Please enter a telephone number."   (English)
  your-email -> "Please enter an email address."     (English)
```

This directly confirms the brief's own citation (SC 3.1.2 + SC 3.3.1) and rules out one of the
three candidates the brief listed: **it is not simply "the site locale is English."** If the whole
site/plugin stack resolved to English, the `validation_error` banner would be English too — it is
not, on two independent triggers. Something is translating *some* CF7 message keys to Hebrew but
not others.

I checked this against Contact Form 7's own source
(`github.com/rocklobster-in/contact-form-7`, `master`) rather than trust memory for something a
fix's correctness depends on:
- `includes/contact-form-template.php` registers `validation_error` (default: "One or more fields
  have an error. Please check and try again.") among the long-standing generic message keys.
- `modules/text.php` separately registers the newer, per-field-type keys used here:
  `invalid_email` ("Please enter an email address."), `invalid_tel` ("Please enter a telephone
  number."). `modules/select.php` confirms a required `select*` field (the subject dropdown) uses
  the same generic `invalid_required` key as text fields — no separate select-specific key exists.
- **Every one of these keys goes through the identical `__( $string, 'contact-form-7' )` call**,
  each looked up independently by key at render time (`includes/contact-form.php`, `message()`
  method: `$messages = $this->prop('messages'); return $messages[$status];`).

Given that, the coherent explanation — matching the brief's own "a missing translation" candidate
— is that whatever Hebrew translation coverage exists for the `contact-form-7` textdomain on this
server's plugin-language install covers the older `validation_error` key but has no entry for the
newer per-field-type keys (`invalid_required`, `invalid_email`, `invalid_tel`), so gettext falls
back to the untranslated English source string for those three specifically. I cannot inspect the
server's installed `.mo` file directly (no WP-CLI on staging, no filesystem access to
`wp-content/languages/` from this repo — confirmed empty/absent locally, CF7 itself is not
vendored in this repo either, only on the live server). I also cannot fully rule out an
alternative explanation — that `validation_error` was individually hand-edited to Hebrew at some
earlier point via the CF7 admin "Messages" tab while the others were never touched — the two
explanations are indistinguishable from outside wp-admin/DB access. **Either way, the correct fix
is the same**: stop depending on whatever the server's translation state happens to be, and set
these specific keys explicitly.

One more static clue, consistent with (not proof of) the above: `functions.php:210-223`
(`ea_eyalamit_hebrew_language_attributes`) rewrites `language_attributes()` output from
`lang="en-US"` to `lang="he-IL"` and adds `dir="rtl"` when missing — a **cosmetic** patch (its own
Hebrew comment: "ברירת מחדל: עברית RTL (כשאין תבנית GP מלאה, לעיתים נשאר en-US)" — "sometimes
en-US remains" without it). This shows the *page-attribute* layer needed a manual patch at some
point; it does not by itself prove anything about the *plugin-translation* layer CF7 depends on,
which is a separate WordPress subsystem (`get_locale()` / `load_plugin_textdomain`) — I'm not
citing it as the cause, only as consistent background.

## B.2 Fix chosen

CF7's own per-form `messages` property (confirmed above: a flat `key => plain string` array,
read directly by `message()`) is exactly the brief's second candidate — "CF7's own message
strings stored per-form." Setting the three broken keys there is deterministic and independent of
whatever the server's plugin-translation catalog does or does not contain, now or after any future
plugin/language update. I left `validation_error` untouched (it is already correct) rather than
overwrite it with my own re-typed copy of a string that already works.

**Scope boundary I drew, and why:** the audit/mandate citation is specifically about *validation*
messages. I translated exactly the keys this form's actual fields can trigger:
`invalid_required` (shared by the required `text*`/`email*`/`select*` fields), `invalid_email`,
`invalid_tel`. I deliberately did **not** touch `mail_sent_ok`, `mail_sent_ng`, `spam`, or
`accept_terms` — none are cited by the audit, this form has no acceptance field, and — critically —
the brief's own safe-test constraint ("do not send a real message") means I have no way to trigger
or verify `mail_sent_ok`/`mail_sent_ng` live at all. Shipping a translation I cannot verify, for a
string nobody measured as broken, felt like exactly the "unmapped hunk" the verifier contract warns
against. Also untouched: `invalid_url`, `invalid_too_long`, `invalid_too_short` — this form has no
`[url]` field and no `minlength`/`maxlength` constraints on any field, so those keys can never be
triggered by this form; translating them would be unverifiable and out of scope. If team_100 or the
owner wants the success/failure banners translated too, that reads to me like a natural, small,
separate REV 5 — flagging it here rather than folding it in unasked.

## B.3 Changes made (file:line, current file state)

**`site/wp-content/mu-plugins/ea-w2-15-cf7-contact-form-once.php:15-20`** — bumped
`EA_W2_15_CF7_REV` from `3` to `4`, with a one-line comment continuing the existing per-REV log.
This is load-bearing, not cosmetic: the function returns early at `:54-56` whenever
`$rev_seen >= EA_W2_15_CF7_REV`, so without the bump this change would never reach the
already-seeded live form (per the brief: "A REV bump is the only way an edit reaches the live
form").

**`:103-147`** — inside `ea_w2_15_cf7_ensure_form()`, after `$props['mail'] = $mail;` and before
`$form->set_properties( $props );`:
- `:142-144` — defensive `is_array` guard around `$props['messages']` (belt-and-suspenders; CF7's
  own `upgrade()` path already guarantees this key exists and is populated, confirmed against
  source, but the guard costs nothing).
- `:145-147` — three flat string assignments:
  - `$props['messages']['invalid_required'] = 'נא למלא שדה זה.';`
  - `$props['messages']['invalid_email'] = 'נא להזין כתובת אימייל.';`
  - `$props['messages']['invalid_tel'] = 'נא להזין מספר טלפון.';`
  Wording matches the vocabulary this exact form's own field labels already use ("אימייל",
  "טלפון" — `:69-70`) rather than inventing new terms; kept to one plain short sentence each, no
  added phrasing, per the brief's "no invented brand voice."
- `:106-141` — a source comment documenting the investigation above, so a future reader (or a
  verifier) does not have to re-derive the cause.

No other property changed — form markup, mail template, field set, and the D-8/REV-3 subject
dropdown are all byte-identical to before.

`php -l` (PHP 8, Homebrew): **no syntax errors detected.**

## B.4 Verification — before confirmed live; after cannot be, without a deploy

**Before:** confirmed live, twice, independently (B.1) — this is a real, currently-live defect, not
a stale report.

**After: I could not measure this live**, and want to be explicit about why rather than imply
otherwise. Unlike task 1 (a JS file the browser fetches, which I can intercept and substitute
against the live page without deploying), this fix is server-side PHP that only takes effect by
actually running on `wp_loaded` and rewriting the form's stored `_messages` post-meta in the
database. There is no client-side injection technique that proves this the way
`page.setRequestInterception` does for a static asset — proving it live requires the file to
actually execute on the server, i.e., a deploy, which is out of scope for this line ("Do not
deploy... team_100 deploys").

What I did instead, to have real confidence rather than "should work":
- `php -l` — clean.
- Traced CF7's actual `message()`/`upgrade()` implementation (B.1) to confirm the exact shape
  (`array( 'key' => 'plain string' )`) my code writes matches exactly what CF7 reads — not the
  nested `description`/`default` shape used only in the admin-UI *registration* functions, which
  would have been a silent, hard-to-spot bug if I'd guessed wrong.
- Confirmed the three key names (`invalid_required`, `invalid_email`, `invalid_tel`) against CF7
  source rather than against memory, and confirmed they match the exact English strings I measured
  live in B.1 verbatim ("Please fill out this field." / "Please enter an email address." /
  "Please enter a telephone number.") — so I know these are the right keys, not adjacent ones that
  would leave the real bug untouched.
- Re-read the diff once more end-to-end (B.3) to confirm nothing else in `$props` changed.

## B.5 What I could not measure / where I believe this is incomplete

- **The live "after" state — cannot be measured by this line at all**, by design of the
  deploy/verify split. Whoever verifies this after deploy should repeat exactly B.1's two triggers
  and confirm the three tips now read the Hebrew strings in B.3, with `validation_error` unchanged
  from what B.1 already showed.
- `mail_sent_ok` / `mail_sent_ng` / `spam` / `accept_terms` remain whatever the server's
  translation state currently produces for them — not touched, not verified, see B.2 for why.
- I have not confirmed what happens on an actual **successful** send (forbidden to test per the
  brief) — if `mail_sent_ok` also turns out to be untranslated live, that's the natural REV 5
  mentioned in B.2, not something folded into this change.
- I relied on a third-party GitHub mirror of Contact Form 7's source
  (`rocklobster-in/contact-form-7`, the plugin author's own repo) rather than the exact `.php`
  running on this server, since CF7 is not vendored in this git repository and I have no server
  filesystem access. I'm confident in the `messages` property shape (it's core, stable CF7
  architecture, unchanged across many major versions) but flagging the source as external rather
  than implying I read the exact bytes running on eyalamit's server.

## B.6 Deploy status

Not deployed. `EA_W2_15_CF7_REV` will apply automatically on the next `wp_loaded` request after
deploy — no manual re-seed step needed, by design of the existing REV mechanism. FTP is
IP-allowlisted regardless, so this line could not deploy even if it were in scope.

---

## Summary for team_100

- Task 1: `ea-chapters.js` only, additive (93 insertions / 0 deletions), no CSS touched, no
  `section-nav.php` change needed or requested. Verified live-injected against staging, 2 full
  runs of 11 assertions each: Run 1 was 9/11 clean (2 flagged — one traced to my own harness
  missing a settle delay, fixed and confirmed; one unreproduced anomaly, see A.5); Run 2 was
  11/11 clean. Neither run is being reported as a PASS — that call belongs to another line.
- Task 2: `ea-w2-15-cf7-contact-form-once.php` only (REV 3 → 4 + 3 message-key overrides). Root
  cause investigated and narrowed past "site locale" to a specific, per-key translation gap;
  fix does not depend on diagnosing that gap further since it overrides the keys directly. "Before"
  confirmed live twice; "after" is structurally verified (source-shape-correct, lint-clean) but
  **not** live-measurable without a deploy this line is not permitted to perform.
- Nothing here requires a `style.css` Version bump beyond what team_100 already plans for the wave.
- No governance-layer (`_aos/`) files touched.
