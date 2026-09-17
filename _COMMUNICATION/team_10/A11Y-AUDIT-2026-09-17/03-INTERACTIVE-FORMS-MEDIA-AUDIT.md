# A11Y-INTERACT — Keyboard Operability, Interactive Components, Forms and Media

Mandate: team_10 audit line, A11Y-AUDIT-2026-09-17. Standard: IS 5568 level AA = WCAG 2.0
level AA (binding). WCAG 2.1/2.2 criteria cited below are labelled explicitly as
"beyond the binding standard" wherever used. **This is not legal advice.**

Auditor note on regulation 35ד/35ו: turnover/classification-based exemptions are not
known to this line. No exemption is assumed anywhere below.

---

## 1. Scope and what I actually ran

- Read `_COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/00-BRIEF-SHARED.md` in full before
  starting (mandatory per brief).
- Static code review: every file under
  `site/wp-content/themes/ea-eyalamit/assets/js/` (14 files, all enqueued — see §2),
  their enqueue sites in `inc/`, and every template-part rendering an interactive
  component (nav, drawer, dropdown, accordion, carousel, lightbox, video/audio, forms).
- Live verification: Chrome (via CDP) against staging `http://eyalamit-co-il-2026.s887.upress.link`,
  2026-09-17, desktop (1024×768) and mobile (375×812) viewports — both confirmed
  non‑zero before trusting any measurement (`window.innerWidth/innerHeight` read back
  after every `resize_window` call).
- **Sanity check for the documented Tab-simulation trap**: before trusting any Tab-key
  result, I clicked into the page and pressed Tab once, then read
  `document.activeElement` — focus moved off `<body>` onto a real link
  (`A.btn.btn--gw`) on the first press. Real key delivery confirmed; every keyboard
  result below is a genuine measurement, not the August false-pass pattern.
- I did **not** submit the contact form with valid data (would send a real email to
  the site's `admin_email`, i.e. Eyal's live inbox — out of scope for a read-only
  audit). I **did** submit it empty once — CF7 blocks that before any mail is sent, so
  it is safe, and it is exactly how I obtained the live error-state DOM in §5.
- Pages touched: `/`, `/contact/`, `/faq/`, `/accessibility/`, `/books/`,
  `/books/vekatavta/`, `/books/kushi-blantis/`, `/books/tsva-bekahol/`, `/qr/`,
  `/qr/qr1/` … `/qr/qr16/`, `/blog/`, `/shop/`, `/en/`, `/eyal-amit/mokesh-dahiman/`.

### Methodology hazard I hit that is not yet in the brief's trap list

**The Browser pane is a shared resource across concurrent sessions.** Mid-audit, tool
responses started telling me a *different* Claude session had set the viewport, and
navigations I did not issue landed the tab on `/accessibility/` and on `/` while I was
mid-check on `/contact/`. `tabs_context` confirmed three open tabs (`seed`, `tab-1`,
`tab-2`) — almost certainly the other team_10 lines running this same audit round in
parallel against the same staging site. Any of us reading `document.title` /
`window.location` right before trusting a DOM snapshot would have caught this; not
checking it silently mixes two pages' state into one measurement and produces a
confident wrong answer, the same failure class as the documented traps. **Mitigation
used from that point on:** I opened my own dedicated tab (`tabs_create` → `tab-3`) and
pinned every subsequent call to it with an explicit `tabId`, re-verifying
`document.title` at the start of every batch. See §6 — I recommend every line doing
live browser work do the same.

---

## 2. Inventory — every enqueued script and the component it drives

All 14 JS files under `assets/js/` are enqueued somewhere; none are orphaned at the
enqueue level (though several are orphaned at the *usage* level — see the critical
scoping note in §3).

| # | File | Enqueued at | Condition | Component |
|---|------|-------------|-----------|------------|
| 1 | `ea-entrance.js` | `inc/wave2-stage-b.php:119` | every Wave2 page | scroll-reveal (decorative) |
| 2 | `ea-scroll.js` | `inc/wave2-stage-b.php:120` | every Wave2 page | scroll-progress bar (decorative) |
| 3 | `ea-ab-testing.js` | `inc/wave2-stage-b.php:121` | every Wave2 page | WhatsApp/form A/B CTA tracking |
| 4 | `ea-hero.js` | `inc/wave2-stage-b.php:122` | every Wave2 page | **`.ea-topnav` burger/dropdown + sound toggle (Wave2 system)** |
| 5 | `ea-mobile-nav.js` | `inc/wave2-stage-b.php:123` | every Wave2 page | **`.ea-mnav-drawer` mobile drawer (Wave2 system)** |
| 6 | `ea-testimonials.js` | `inc/wave2-stage-b.php:142` | `is_page_template('tpl-home.php')` only | dots-rotator testimonials (Wave2 system) |
| 7 | `ea-chapters.js` | `inc/chapters/chapters-enqueue.php:43-49` | every Chapters view | **`#nav`/`.nav__burger` mobile menu + video sound-toggles (live system)** |
| 8 | `ea-testi-mq.js` | `inc/chapters/chapters-enqueue.php:51-57` | every Chapters view | manual testimonial strip (live) |
| 9 | `ea-mokesh.js` | `inc/chapters/chapters-enqueue.php:86-92` | slug `mokesh-dahiman` only | YouTube IFrame API hero trailer |
| 10 | `ea-faq-toc.js` | `inc/chapters/chapters-enqueue.php:112-118` | `is_page('faq')` only | FAQ topic TOC (scroll-spy + smooth scroll) |
| 11 | `ea-blog-share.js` | `inc/chapters/chapters-enqueue.php:140-146` | singular `post` only | copy-link share button |
| 12 | `ea-book-purchase.js` | `inc/chapters/chapters-commerce.php:75-81` | 3 book pages | GA4 click tracker (no UI behaviour) |
| 13 | `ea-qr-facade.js` | `inc/chapters/chapters-qr-facade.php:98-104` | QR views only | YouTube facade (click-to-embed) |
| 14 | `books-reveal.js` | `functions.php:705-711` | books-v2 assets | scroll-reveal (decorative) |

Components with behaviour, inventoried from templates (file:line in each section below):
mobile navigation (two parallel implementations — see §3), desktop dropdown submenus
(two parallel implementations), FAQ accordion (native `<details>`) + its TOC, a
pure-CSS book-cover lightbox, a YouTube click-to-embed facade, three parallel
testimonial-carousel implementations, a hero/dedicated self-hosted video with
click-to-play, a YouTube IFrame-API autoplay hero (Mokesh), the CF7 contact form, the
WhatsApp float button, and the wp-accessibility plugin's assets. No tabs (`role="tab"`)
widget, no true modal dialog other than the lightbox, and no cookie-consent
banner/modal exist anywhere in the theme (grepped `consent|cookie` — the only hits are
code comments explaining that `youtube-nocookie.com` is used specifically *to avoid*
needing one).

---

## 3. Critical scoping finding — two parallel nav systems; only one is live

This governs how every other finding below should be read, so it comes first.

The theme ships **two independent, fully-built primary-navigation systems**:

- **Wave2** (`.ea-topnav`, `.ea-mnav-drawer`, `template-parts/blocks/block-topnav.php`,
  driven by `ea-mobile-nav.js` + `ea-hero.js`) — a careful, WCAG-conscious
  implementation: real focus trap, Escape-to-close, focus restored to the trigger on
  close, `aria-modal="true"` drawer, dir-aware slide, desktop dropdowns wired via
  `:hover`, `:focus-within`, **and** `[aria-expanded="true"] + submenu` all at once
  (`assets/css/ea-atoms.css:288-291`).
- **Chapters** (`#nav`/`.nav__*`, `template-parts/chapters/section-nav.php`, driven by
  `ea-chapters.js`) — a simpler implementation with no focus trap, no focus
  restoration, and (as measured below) a live focus-order defect.

**Measured live:** every content page I loaded — `/`, `/contact/`, `/faq/`,
`/accessibility/`, all 3 book pages, `/qr/qr1/`, `/blog/`, `/shop/` — rendered the
**Chapters** nav (`#nav` present, `.ea-topnav` absent, `.ea-mnav-drawer` absent). I could
not find `.ea-topnav` on a single live page in the page set, despite
`get_template_part( 'template-parts/blocks/block', 'topnav' )` still being called from
`page-templates/tpl-content.php:22`, `tpl-blog-single.php:16`, `tpl-qr.php:15`, and
`tpl-blog-archive.php:36`. Either those four template files are not the ones actually
assigned to any current page (most likely, matching the same "orphaned template"
pattern documented for the book lightbox in §5.2), or some other gate suppresses the
block; I have no wp-admin/WP-CLI access to check page-template assignments directly
(read-only mandate, and staging has no WP-CLI — matches the team's prior findings on
this project). `/en/` is a separate static landing page with **no** `<nav>` and **zero**
`<button>` elements at all — nothing in this mandate's scope applies there.

**Practical effect:** the well-built drawer (`ea-mobile-nav.js`) and the well-built
desktop dropdown (`ea-hero.js` + `ea-atoms.css`) are, as far as I can measure, not what
any real visitor to this staging site currently gets. What real visitors get is the
Chapters nav, which has the defects in §4. Likewise, `ea-testimonials.js` (dots
rotator) and `block-testimonials-carousel.php` (auto-scroll marquee) are absent from
the live home page (`document.querySelectorAll('[data-testi-rotator]')` and
`.ea-testi-carousel` both return zero matches there); the component actually live on
the home page is `ea-testi-mq.js` (§7).

I flag this as **measured, not inferred** (empirical `querySelector` checks against
the live DOM across the full page set), but I cannot rule out a page outside my set
using the Wave2 system — I did not crawl every URL on the site.

---

## 4. Findings — mobile navigation (live: Chapters `#nav`)

### A11Y-INTERACT-01 — Opening the mobile menu, then pressing Tab, skips the menu entirely
**Severity: High · SC 2.4.3 Focus Order (Level A) · Measured (live)**

`template-parts/chapters/section-nav.php:16-82` renders, in DOM order: brand link →
`<ul class="nav__l">` (the **entire** menu incl. all submenus, lines 21-71) →
`<div class="nav__r">` (sound toggle, EN link, then the burger, lines 73-81). The
burger is therefore the **last** focusable element inside `<nav>`.

Live measurement on `/` (mobile viewport, 375×812): clicked the burger
(`aria-label="תפריט"`) → `aria-expanded` correctly flips to `"true"` and
`#nav[data-menu="1"]` is set. Pressed Tab once: focus landed on
`<a class="btn btn--terra" href="/contact/">לתיאום שיחת היכרות</a>` — a **hero CTA
button**, not a menu link. `document.getElementById('nav').children` confirms the DOM
order above (`["A.nav__b","UL.nav__l","DIV.nav__r"]`).

A keyboard user who opens the menu and does what every UI convention trains them to do
— press Tab to move into the thing that just appeared — is dropped straight into the
page body instead. The only way to actually reach the open menu's links is Shift+Tab
(backwards) from the burger, which is not discoverable. `ea-chapters.js:41-65` has no
`focus()` call and no Tab-key handling at all, so nothing corrects this.

**What a user experiences:** a screen-reader or keyboard-only user opens "תפריט", hears
nothing change (no focus move, no announcement), and the very next Tab press appears to
have "closed" the menu because they are back in body content — the menu is, in
practice, unusable by keyboard.

### A11Y-INTERACT-02 — Open mobile menu does not visually contain the page underneath it
**Severity: High (supports -01) · Measured (live, screenshot)**

Same interaction as above, before pressing Tab: screenshot at 375×812 shows the opened
`.nav__l` panel occupying only roughly the right ~55% of the viewport width, with the
home hero's photo and Hebrew headline still fully visible and text-overlapping on the
left portion — not dimmed, not covered, not behind a scrim. `getComputedStyle` on
`.nav__l` reports `display:flex; visibility:visible; opacity:1; position:fixed`,
occupying the full `{x:0,y:72,width:375,height:740}` rect, and
`document.elementFromPoint()` inside that rect correctly hit-tests to the menu's own
`<li>` — so the menu genuinely is the topmost, interactive layer there; the defect is
that content behind/around it keeps rendering and is not visually suppressed the way a
site-wide "open overlay" pattern requires.

I am not tying this to its own WCAG 2.0 number — it is not a clean fit for any single
2.0 AA success criterion, it reads more as a layout/CSS defect than a pure
accessibility one — but I am reporting it because it is direct, reproducible evidence
for the "does background content stay reachable/visible behind an open overlay"
question this mandate asks, and it is the visual half of the same root cause as
-01 (no script manages the open state as an actual overlay). A sighted keyboard user
tabbing through the intermixed text in -01 would see focus rings appear on backdrop
content they cannot cleanly read against the menu text — worth fixing together with -01.

### A11Y-INTERACT-03 — Submenu toggle buttons never update their own `aria-expanded`
**Severity: Medium · SC 4.1.2 Name, Role, Value (Level A) · Measured (live + code)**

`template-parts/chapters/section-nav.php:33` and `:64`:
```
<button class="nav__dd" type="button" aria-haspopup="true" aria-expanded="false">לימוד והכשרה...
<button class="nav__dd" type="button" aria-haspopup="true" aria-expanded="false">אייל עמית...
```
Grepped every enqueued JS file for `nav__dd` — zero matches. Nothing in the theme ever
writes to this attribute. The submenu (`.nav__sub`) is revealed purely by CSS:
`.nav__l>li:hover .nav__sub,.nav__l>li:focus-within .nav__sub{opacity:1;visibility:visible;transform:none}`
(`assets/css/chapters.css:497`). Because `:focus-within` fires the instant the button
receives focus, Tab-only users *do* reach the submenu's links (no keyboard trap here —
this is a state-reporting defect, not an operability one), but `aria-expanded` sits at
`"false"` forever regardless of the true, visible state. A screen-reader user is told
"collapsed" every single time, including while the submenu is open in front of them.
Pressing Enter/Space on the button itself does nothing (no click handler) — the reveal
already happened on focus, so the button's implied "activate to expand" affordance is
inert.

**What a user experiences:** VoiceOver/NVDA announces "לימוד והכשרה, button, collapsed"
and never updates that, even once the four submenu links are audibly the very next
stops in the reading order.

### Found correct: Escape-to-close and the desktop dropdown reveal mechanism
- Escape closes the Chapters mobile menu correctly: measured live, `data-menu`
  attribute is removed, `aria-expanded` returns to `"false"`, `body.nav-locked` is
  removed (`ea-chapters.js:61-63`). Focus is **not** returned to the burger on close (no
  restore-focus logic exists) — a real but secondary gap given -01 already leaves focus
  outside the menu regardless.
- The Wave2 desktop dropdown pattern (`ea-atoms.css:288-293`, `ea-hero.js:47-75`,
  `block-topnav.php:209-216`) is a genuinely well-built disclosure widget — real
  `<button aria-haspopup aria-expanded>`, Escape closes globally, outside-click closes,
  and crucially the CSS wires `:hover`, `:focus-within`, **and** the JS-driven
  `[aria-expanded="true"]` together so it cannot get out of sync the way -03 does. I
  could not confirm this is reachable on any live page (§3) but it is worth pointing
  future work at as the reference pattern to copy into the Chapters nav.
- No `aria-*` attribute pointing at a non-existent id was found in any nav variant
  (`aria-controls="nav"` → `#nav` exists; `aria-controls="ea-mnav-drawer"` →
  `#ea-mnav-drawer` exists even though dead; CF7's `aria-describedby` targets all
  resolve — see §5).

---

## 5. Findings — the `/contact/` form (Contact Form 7, live)

Verified against the **live rendered DOM** at `/contact/`, not just source, including
one safe empty-submission. CF7 version confirmed live: `6.1.7` (hidden field
`_wpcf7_version`). The seeder is `site/wp-content/mu-plugins/ea-w2-15-cf7-contact-form-once.php`;
its `$form_markup` (lines 56-64) matches the live DOM exactly.

**Labelling (1.3.1 / 4.1.2) — correct.** Every field uses the wrapping-`<label>`
pattern (`<label>שם מלא<br>[text* your-name …]</label>`,
`ea-w2-15-cf7-contact-form-once.php:58-62`), which is a valid implicit
label-to-control association needing no `for`/`id` pair — confirmed in the live markup.

**Required marking (3.3.2 / 4.1.2) — correct and matches D-8's intent.** Live DOM:
`your-name` and `your-email` inputs and the `your-subject` select all carry
`aria-required="true"`; `your-phone` and `your-message` correctly carry neither. This
is exposed programmatically (not just visually), satisfying the SC even though CF7
does not additionally emit the native `required` attribute (the form uses
`novalidate` and does its own AJAX-driven validation — `aria-required` alone is
sufficient here).

### A11Y-INTERACT-04 — CF7's own validation strings are unlocalized English inside a Hebrew form
**Severity: Medium · SC 3.1.2 Language of Parts (Level AA) · Measured (live)**

Live test: submitted the form empty (safe — CF7 blocks mail on invalid input, no email
was sent to Eyal). Resulting DOM, inside `<div class="wpcf7" lang="he-IL" dir="rtl">`:
```
<div class="screen-reader-response"><p role="status" aria-live="polite" aria-atomic="true">
  קיימת שגיאה בשדה אחד או יותר. נא לבדוק ולנסות שוב.</p>
  <ul><li id="wpcf7-f392-o1-ve-your-name">Please fill out this field.</li>
      <li id="wpcf7-f392-o1-ve-your-email">Please fill out this field.</li></ul>
</div>
```
The summary sentence is correctly Hebrew. The **per-field** messages
("Please fill out this field.") are English, with no `lang="en"` on the `<li>` or on
the matching visible tip (`<span class="wpcf7-not-valid-tip">`). The `your-name` input's
`aria-describedby="wpcf7-f392-o1-ve-your-name"` points straight at that English string,
so a Hebrew screen-reader voice will attempt to pronounce it phonetically as Hebrew.
Root cause is almost certainly a missing/incomplete Hebrew translation for
Contact Form 7 itself on this install (`_wpcf7_locale` is correctly `he_IL`, but the
plugin's own `he_IL.mo` does not appear to be supplying these particular strings).

**What a user experiences:** a Hebrew screen-reader user who leaves a required field
empty hears a correct Hebrew summary, then a garbled, mispronounced English sentence
naming which field is wrong.

### Found correct: the live-region architecture around it
This part of CF7 6.x's accessibility design is implemented correctly and is worth
recording as a **pass**, not just absence-of-error:
- `.screen-reader-response`'s `<p role="status" aria-live="polite" aria-atomic="true">`
  is visually hidden with the standard clip technique
  (`position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(1px,1px,1px,1px)`
  — read back via `getComputedStyle`), **not** `display:none`, so it stays in the
  accessibility tree while being invisible on screen. Confirmed live.
- The visible `.wpcf7-response-output` banner is deliberately `aria-hidden="true"` even
  while showing the same message text on screen — this is not a bug, it is CF7
  avoiding a double-announcement, because the identical text is already exposed via
  the live region above. I want to flag this explicitly because a less careful reading
  of the DOM (seeing `aria-hidden="true"` on a visibly-red, on-screen error box) looks
  like a defect and is not one here.
- The invalid field gets `aria-invalid="true"` and its own
  `wpcf7-not-valid-tip` is correctly `aria-hidden="true"` for the same
  no-double-announcement reason, with the real description delegated to
  `aria-describedby`.

**Could not measure:** the *success*-path announcement (what happens to
`.wpcf7-response-output`/`aria-hidden` and the live region on a valid submission) —
deliberately not tested, since triggering it means sending a real lead email to
Eyal's live `admin_email`. Recommend team_50 or team_100 test this once, off staging's
real inbox is acceptable to touch, or by temporarily pointing `recipient` at a
throwaway address.

### A11Y-INTERACT-05 — Subject dropdown (D-8) has no neutral default — recommendation, not a 2.0 AA failure
**Severity: not a WCAG 2.0 AA failure — recommendation · Measured (live)**

`ea-w2-15-cf7-contact-form-once.php:61`:
```
[select* your-subject "טיפול בדיג'רידו" "שיעורי נגינה" "סאונד הילינג" "רכישת כלי" "רכישת ספר" "תיקון כלי" "אחר"]
```
No blank/prompt option. Live: the `<select>` visibly shows "טיפול בדיג'רידו" (its first
option) pre-selected on load — I confirmed this both in the live DOM and visually in a
screenshot. Because a value is always present, the `aria-required="true"` validation
never has anything to catch: a visitor asking about "רכישת ספר" who does not notice the
dropdown will silently submit "טיפול בדיג'רידו" as their subject. This is a UX/data-
quality defect the brief specifically asked me to check, not a WCAG criterion (there is
no 2.0 SC requiring a "sane default"), so it is a recommendation: add a disabled,
non-selected placeholder option (e.g. `"— בחרו נושא —"`) as the visible first option.

### A11Y-INTERACT-10 — Honeypot / fallback-form note
**Severity: informational · Inferred (code) — fallback path not currently live**

No custom honeypot field exists in the seeded CF7 form at all — nothing to check
against "hidden from sight and from AT" for this form specifically. CF7's own
framework hidden fields (`_wpcf7`, `_wpcf7_version`, the nonce, etc.) use native
`type="hidden"`, which is correctly removed from both focus and the accessibility tree
— confirmed in the live DOM dump above, not a concern.

Separately, `template-parts/chapters/parts/contact.php:35-64` renders a **second**,
plain HTML fallback contact form, used only if `ea_wave2_render_contact_form()`
(`inc/wave2-stage-b.php:367-377`) returns `false` — i.e. only if CF7 is ever
unavailable or its form gets un-wired. Since the CF7 form is live right now, this path
is currently dormant (I did not find a way to force it without breaking the live form,
so this is inferred from code, not measured). It is worth recording because it is
inconsistent with the live form and would be a real regression if it ever activated:
its required set is different (name, phone, message required; email optional — CF7's
live set is name, email, subject required; phone, message optional), it carries
`novalidate` with **no accompanying JS validation anywhere in the 14 enqueued
scripts**, its `<form action="#" method="post">` goes nowhere, and its pre-built
`.ea-contact-form__error` spans (lines 41, 47, 53, 59, each correctly wired via
`aria-describedby` and `hidden`) can never actually be revealed because nothing ever
un-hides them. If CF7 ever fails to wire, visitors get a form that looks real,
validates nothing, and submits nowhere.

---

## 6. Findings — media

### A11Y-INTERACT-08 — Mokesh trailer: no caption control reachable at all
**Severity: exposure (see framing below) · SC 1.2.2 Captions (Prerecorded) (Level A) ·
Measured (code) + partially observed live**

`assets/js/ea-mokesh.js:73-87`, live on `/eyal-amit/mokesh-dahiman/` (mount point and
custom unmute button both confirmed present in the live DOM): the YouTube IFrame API
player is created with `controls: 0` (hides **all** of YouTube's own chrome, including
whatever CC button it would otherwise offer), `disablekb: 1` (disables the player's own
keyboard shortcuts), and `cc_load_policy: 0`. The **only** exposed control anywhere on
the page is the custom `[data-ea-mokesh-unmute]` mute/unmute button
(confirmed live: `<button class="mokesh-hero__unmute" aria-pressed="false">`). This is a
real documentary trailer with narration (per the file's own doc-comment) — once
unmuted, a user gets audio with **no** way to turn captions on, because there is no UI
control for it anywhere and no transcript on the page. I could not inspect the actual
YouTube player's internal DOM (cross-origin iframe, not introspectable from the parent
page), so the `controls:0`/`disablekb:1`/`cc_load_policy:0` request is a code-level
measurement, corroborated live by the total absence of any caption-related control on
the surrounding page.

**Framing per the brief:** this is a technical-conformance gap against 1.2.2 under the
binding standard as such — separate and prior to any question of regulation 35ד's
captioning duty, which turns on the business's turnover/classification that this audit
does not have. I am not asserting 35ד applies or is violated; I am asserting the WCAG
2.0 AA criterion has no content-based captioning path available to a user right now,
and flagging the legal question as the owner's to resolve with real figures.

Found correct in the same file: the **plain** `<iframe>` embed of the same film used
elsewhere on the page (`template-parts/chapters/parts/mokesh-video.php:36-43`) has a
real, descriptive `title` — confirmed live: `title="MUKESH - The Art of Shanti Living |
Official Trailer"` and a second instance titled `"MUKESH: The Art of Shanti Living"`.
The file's own doc-comment explicitly cites WCAG 4.1.2 as the reason for the "נגן
וידאו:" action-prefix pattern used elsewhere (see the QR facade below) — this is a
codebase that is clearly aware of the requirement in some places and not others.

### A11Y-INTERACT-07 — `videoblk.php`'s self-hosted video has no caption track (latent — could not confirm live-populated)
**Severity: latent · SC 1.2.2 Captions (Prerecorded) (Level A) · Measured (code); live
population not found in the page set**

`template-parts/chapters/parts/videoblk.php:24`:
```
<video class="videoblk__v" muted loop playsinline preload="none" ...><source src="..." type="video/mp4"></video>
```
No `<track kind="captions">` child at all. The click-to-play handler
(`assets/js/ea-chapters.js:100-115`) explicitly unmutes on activation
(`vid.muted = false;`), so if this ever plays a video with meaningful narration, there
is no caption path. This block is registered in the generic Chapters renderer's schema
(`inc/chapters/chapters-render.php:427`) but I could not find a single live page in my
page set with a populated `.videoblk__v` — every instance I found
(`section-home-03-video.php`, `videoblk-placeholder.php`) was the "ממתין לאישור"
(pending-approval) placeholder box, which carries no video at all. I am reporting this
as a **latent** code defect, not a live failure — if/when Eyal supplies a real video for
this block, it will ship with no caption path unless fixed first.

### Found correct: the home hero video and the QR facade
- The home page's hero video is genuinely decorative and carries no audio at all —
  confirmed by fetching the live page source: `<video class="hero__media" muted loop
  playsinline preload="none" poster="…">` with `<source src="…/ea-home-hero-720-muted.mp4">`
  — the file is even *named* "muted" at the asset level. 1.2.1/1.2.2 do not apply to a
  silent decorative loop; not a finding.
- The QR video facade (`inc/chapters/chapters-qr-facade.php:43-88`,
  `assets/js/ea-qr-facade.js`) is a genuinely well-built pattern and deserves credit:
  the trigger button's `aria-label` is built dynamically per post as
  `"נגן וידאו: <post title>"` (line 66-73), with an explicit code comment citing WCAG
  2.4.6/4.1.2 for *why* the action-naming prefix is deliberate; the poster `<img>` is
  correctly `alt=""` (decorative, the button already has the name); the decorative
  play-icon span is `aria-hidden="true"`; on activation the injected `<iframe>` gets
  `tabindex="-1"` before insertion (needed for `.focus()` to reliably land, per the
  code comment) and focus is explicitly moved into it for keyboard users
  (`ea-qr-facade.js:27-33`). **Could not measure live**: none of `/qr/qr1/` through
  `/qr/qr16/` currently contain a YouTube embed in their post content (checked via raw
  HTML fetch for the `/embed/` substring across all 16 — zero matches), so the facade
  mechanism has nothing to activate on right now. Code-level assessment stands as
  correct; live behaviour unconfirmed for lack of content.

### A11Y-INTERACT-09 — Four Facebook embeds share one generic, indistinguishable title
**Severity: low — not a clean 2.0 AA fit, recommendation · Measured (live)**

On `/eyal-amit/mokesh-dahiman/`, 4 separate `<iframe>` Facebook-post embeds all carry
the identical `title="פוסט פייסבוק"` ("Facebook post"). A screen-reader user tabbing
through the page hears the same name four times with no way to tell them apart before
entering one. This is most likely inherent to Facebook's own oEmbed/plugin markup
rather than anything the theme controls directly — I did not find theme code
generating this attribute — so I am not asserting the theme can fix it outright, only
recording it as observed.

### Timing/interruptions (2.2.1 / 2.2.2)
No countdown, session timeout, or auto-redirecting content exists anywhere in the 14
enqueued scripts. The only auto-moving content found **live** is `ea-testi-mq.js`'s
idle ping-pong animation (see §7) — handled correctly. `ea-testimonials.js`'s 5-second
auto-advance rotator and the CSS auto-scroll marquee both have correct pause/reduced-
motion handling in code but are not currently live (§3), so I am not scoring them as
either pass or fail here.

---

## 7. Findings — carousels, accordion, lightbox, third-party widgets

### Found correct: FAQ accordion + TOC (live, `/faq/`)
`template-parts/blocks/block-faq-list.php:96-107` uses native `<details>`/`<summary>`
for all 133 live FAQ items (counted on `/faq/`) — keyboard operability (Tab to
`<summary>`, Enter/Space to toggle) and correct `aria-expanded` exposure are guaranteed
by the browser's native semantics, not custom script, so there is nothing here to
break. The topic TOC (`block-faq-list.php:70-79`, 16 live chip links confirmed) is a
plain `<a href="#faq-topic-slug">` per chip — real, natively keyboard-operable anchors,
enhanced progressively by `ea-faq-toc.js` (smooth scroll respecting
`prefers-reduced-motion`, scroll-spy via `IntersectionObserver`, legacy `?topic=`
deep-link support) — the enhancement degrades cleanly to plain anchor-jump if JS fails.
Category sections with no items get the native `hidden` attribute
(`block-faq-list.php:90`), correctly removed from both sight and the accessibility
tree.

### A11Y-INTERACT-11 — Home mini-FAQ variant hardcodes a stale `aria-expanded` (latent — not found live)
**Severity: latent · SC 4.1.2 (Level A) · Measured (code); not found rendered anywhere
in the page set**

`template-parts/blocks/block-faq-mini.php:58`:
```
<summary class="ea-faq-item__summary" aria-expanded="false">
```
This is the *same* native `<details>` pattern as the FAQ archive, except here someone
added a manual `aria-expanded="false"` that nothing ever updates (no JS targets
`.ea-faq-item__summary`) — once a visitor opens it, the exposed state is permanently
wrong, same class of bug as A11Y-INTERACT-03. Live check: `/` currently renders **zero**
`<details>` elements at all (`document.querySelectorAll('details').length === 0`), so
this specific block is not placed on the home page right now. It remains registered in
the Wave2 block catalog (`inc/wave2-stage-b.php:51`) and could be activated on any page
through site-tree configuration I do not have visibility into. Fix is trivial (delete
the attribute — native `<details>` already exposes the state correctly, as
`block-faq-list.php`'s identical markup without it proves) and cheap enough to do
regardless of current placement.

### A11Y-INTERACT-06 — Book-cover lightbox is 100% keyboard-inoperable (latent — confirmed NOT reachable on any live book page)
**Severity: would be Critical if live · SC 2.1.1 Keyboard (Level A) · Measured (code);
measured live as unreachable**

`page-templates/template-book-detail.php:62-97`:
```php
<input type="checkbox" id="ea-cover-lightbox" class="ea-cover-lightbox-toggle" aria-hidden="true">
<figure class="ea-book-cover">
  <label for="ea-cover-lightbox" class="ea-cover-lightbox-trigger" aria-label="הגדל כריכה">…</label>
  …
</figure>
<div class="ea-cover-lightbox-overlay" role="dialog" aria-modal="true" aria-label="כריכת הספר מוגדלת">
  <label for="ea-cover-lightbox" class="ea-cover-lightbox-close" aria-label="סגור">✕</label>
  …
</div>
```
`assets/css/books-v2.css:1261-1263`: `.ea-cover-lightbox-toggle { display: none; }`.
Pure-CSS "checkbox hack," no JS anywhere touches `#ea-cover-lightbox` (grepped every
enqueued JS file — zero matches).

The checkbox is `display:none` — natively removed from the Tab order entirely, on top
of already being `aria-hidden`. Both the open trigger and the close control are plain
`<label>` elements, which are **not** in the default Tab order (only form controls are).
Net result: **no element involved in this feature is keyboard-focusable at all.** A
keyboard-only user cannot open the lightbox; if a mouse/touch user opens it, a keyboard
user cannot close it either — Escape does nothing (pure CSS, no listener), and Tab does
nothing (nothing to land on). Nor does focus ever move into the
`role="dialog" aria-modal="true"` overlay on open (no JS = no `.focus()` call), so even
a screen-reader user who opens it by mouse gets no announcement that a dialog appeared.

**Confirmed NOT reachable live, checked all three real book pages:**
`/books/vekatavta/`, `/books/kushi-blantis/`, `/books/tsva-bekahol/` all render with
body class `page-template-default` (WordPress's own marker for "no custom template
assigned" — contrast with `/contact/`'s
`page-template page-template-page-templates page-template-tpl-contact …`), **not** the
`tpl-book-detail` classes this template would produce, and `.ea-book-cover-wrap` is
absent from all three live pages. They render a plain `<img class="phero__media">`
hero cover instead, via the Chapters system, with no zoom/lightbox feature at all
currently. Per the brief's positive-assertion rule I am **not** calling this a live
failure — I am reporting it as a real, severe, ready-to-ship defect sitting in a
template file that remains selectable in wp-admin (I could not verify page-template
assignment directly — no wp-admin/WP-CLI access — but the body-class evidence above is
conclusive for these three URLs specifically). Recommend either fixing it (real
`<button>`s, JS-driven, focus-managed) or deleting the dead template so it cannot be
one accidental wp-admin dropdown selection away from shipping with zero keyboard access.

### Found correct: the three live testimonial-carousel patterns
Per §3, only `ea-testi-mq.js` is confirmed live (home page). Verified live:
- `assets/js/ea-testi-mq.js` + `template-parts/chapters/parts/testimonials.php`-family
  markup: left/right controls are real `<button type="button">` with correct,
  distinguishing `aria-label`s — confirmed live: `aria-label="הזזה שמאלה"` and
  `aria-label="הזזה ימינה"`, decorative arrow glyphs `aria-hidden="true"`, and the
  exhausted-direction button correctly gets the native `disabled` attribute
  (confirmed live on page load: the right/"back" button starts `disabled=""`, matching
  `ea-testi-mq.js:119-124`'s `index<=0` logic). Real `<button>` elements mean Tab/Enter/
  Space work natively — nothing custom to break.
- Its idle ping-pong auto-animation (`ea-testi-mq.js:127-220`) correctly: does nothing
  under `prefers-reduced-motion: reduce` (line 127, 159); pauses on
  `mouseenter`/`focusin`/`pointerdown` and resumes on leave/blur (lines 196-205); stops
  **permanently** the instant a user clicks either manual button (lines 172-176,
  179-191); and pauses whenever scrolled out of view via `IntersectionObserver`
  (lines 207-217) rather than running forever off-screen.
- The two **not-currently-live** implementations (`ea-testimonials.js` dots-rotator;
  `block-testimonials-carousel.php` auto-scroll marquee) both show the same care in
  code review: dots are real `<button>`s with per-item `aria-label`s and correct
  `aria-current` toggling; the marquee's duplicate (visual-loop-only) card set is
  `aria-hidden="true"` with `tabindex="-1"` stripped from its links
  (`block-testimonials-carousel.php:89`, `:51/:68`), its live viewport carries
  `role="group" tabindex="0"` with an aria-label stating the pause-on-hover/focus
  behaviour up front (`block-testimonials-carousel.php:85`), and reduced-motion turns
  the whole thing into a static, non-scrolling row (`testimonials-carousel.css:54`).
- One consistent, minor, non-blocking observation across all three: the mechanism to
  pause automatic movement is hover/focus/click-driven rather than an always-visible
  "pause" button. This satisfies SC 2.2.2 (a mechanism does exist and is reliable for
  as long as focus/hover is held) — I am not scoring it as a failure — but a persistent
  visible pause affordance would be more robust and more discoverable; noting as a
  cross-cutting recommendation rather than three separate findings.

### Found correct: WhatsApp float button and wp-accessibility plugin
- `.ea-whatsapp-float` (`inc/wave2-stage-b.php:396-407`) is a real `<a href>`,
  `target="_blank" rel="noopener noreferrer"`, with an `aria-label` that both
  describes the action and discloses the new-window behaviour
  ("שלח הודעה בוואטסאפ (נפתח בחלון חדש)"); its SVG icon is `aria-hidden="true"` and a
  visible text label sits alongside it. Fully keyboard-native, nothing to break. Live
  on every page except `/contact/` (deliberately suppressed there — see
  `inc/wave2-stage-b.php:388-395` — to avoid the duplicate-WhatsApp-CTA bug fixed
  2026-09-17 per this branch's own recent commits).
- wp-accessibility (Joe Dolson) v2.3.5 confirmed live: `wp-content/plugins/wp-accessibility/css/wpa-style.css?ver=2.3.5`
  and the matching JS both load on every page I checked. It does **not** currently
  inject any visible on-page toolbar or control — I checked the raw home-page HTML for
  any toolbar markup and found only the plugin's stylesheet `<link>` and one inline
  `--admin-bar-top` custom-property rule; no `.wpa-toolbar` or equivalent interactive
  element exists in the rendered page. There is therefore nothing of the plugin's own
  to test for keyboard-reachability right now — reporting this as a measured absence,
  not an assumed pass, per the brief's positive-assertion rule.
- No chat widget, booking embed, or cookie-consent modal exists anywhere in the theme
  (grepped for all of them).

---

## 8. Summary findings table

| ID | Severity | WCAG 2.0 SC | Measured/Inferred | Evidence |
|----|----------|-------------|--------------------|----------|
| A11Y-INTERACT-01 | High | 2.4.3 Focus Order (A) | Measured, live | `section-nav.php:16-82`; live Tab test on `/` |
| A11Y-INTERACT-02 | High (supports -01) | not a clean 2.0 fit — reported as evidence | Measured, live | live screenshot + `elementFromPoint`, `/` mobile |
| A11Y-INTERACT-03 | Medium | 4.1.2 Name/Role/Value (A) | Measured, live+code | `section-nav.php:33,64`; `chapters.css:497`; grep of all JS |
| A11Y-INTERACT-04 | Medium | 3.1.2 Language of Parts (AA) | Measured, live | live empty-submit DOM on `/contact/` |
| A11Y-INTERACT-05 | Recommendation (not 2.0 AA) | — | Measured, live | `ea-w2-15-cf7-contact-form-once.php:61`; live `<select>` |
| A11Y-INTERACT-06 | Would be Critical; latent | 2.1.1 Keyboard (A) | Measured code; measured-unreachable live | `template-book-detail.php:62-97`; `books-v2.css:1261-1263`; live body-class check on all 3 book pages |
| A11Y-INTERACT-07 | Latent | 1.2.2 Captions (A) | Measured code; live population not found | `videoblk.php:24`; `ea-chapters.js:100-115` |
| A11Y-INTERACT-08 | Exposure (see §6 framing) | 1.2.2 Captions (A) | Measured code + live-partial | `ea-mokesh.js:73-87`; live mount+button on `/eyal-amit/mokesh-dahiman/` |
| A11Y-INTERACT-09 | Low / recommendation | not a clean 2.0 fit | Measured, live | 4 iframe titles on `/eyal-amit/mokesh-dahiman/` |
| A11Y-INTERACT-10 | Informational | — | Inferred (code), path not live | `contact.php:35-64` vs live CF7 required-set |
| A11Y-INTERACT-11 | Latent | 4.1.2 (A) | Measured code; not found live | `block-faq-mini.php:58` |

---

## 9. Could not measure

- **CF7 success-path announcement** — would require a real, valid submission, which
  sends a live email to Eyal's `admin_email`. Deliberately not attempted.
- **YouTube player internals** (Mokesh trailer, and the QR facade's embedded player
  once activated) — cross-origin iframe content is not introspectable from the parent
  page; assessed from the requested `playerVars`/URL only.
- **Actual page-template assignment** for the 3 book pages, the QR pages, and the blog
  pages — no wp-admin or WP-CLI access on this read-only, no-WP-CLI staging box (per
  this project's own prior findings). Body-class evidence is strong but is not the
  same as reading the `_wp_page_template` post meta directly.
- **wp-accessibility plugin's admin-configured feature set** — only observable from
  its front-end output, which currently shows no toolbar; I cannot see its settings
  screen (read-only mandate) to know whether the toolbar is off by configuration or by
  version.
- **Whether any page outside the stated page set still uses the Wave2 `.ea-topnav`
  system** — I did not crawl the whole site, only the page set plus the additional
  URLs needed to resolve slugs (books, QR children).
- **VoiceOver/NVDA actual announcement behaviour** for any of the above — all keyboard
  findings above were measured via real key events and DOM state (`document.activeElement`,
  attribute values), not via an actual screen reader. That is a separate check (the
  brief assigns full screen-reader passes to team_50's round-3 signoff).

---

## 10. Recommended fixes, ordered by user impact

1. **Fix the live mobile-menu focus order** (`section-nav.php`) — either reorder
   `.nav__r` before `.nav__l` in the DOM (with CSS `order`/flex keeping the burger
   visually first), or add the same focus-management `ea-mobile-nav.js` already has
   correctly built (move focus into the first menu link on open, trap Tab within the
   open menu, restore focus to the burger on close). This is the single highest-impact
   fix in this report — it affects the primary nav on every page, for every keyboard
   user. (A11Y-INTERACT-01, -02)
2. **Make `.nav__dd` submenu buttons update their own `aria-expanded`** — a
   ~4-line JS fix (`ea-chapters.js`), toggling the attribute on `focusin`/`focusout` or
   `click` to match the CSS reveal. (A11Y-INTERACT-03)
3. **Get a real Hebrew translation loaded for Contact Form 7's built-in validation
   strings**, or override the two `wpcf7_default_alert` / `wpcf7_ajax_json_echo`-level
   strings for this form specifically. (A11Y-INTERACT-04)
4. **Add a blank/prompt first option to the subject `<select>`**
   (`ea-w2-15-cf7-contact-form-once.php:61`, bump `EA_W2_15_CF7_REV`). (A11Y-INTERACT-05)
5. **Either fix or delete `page-templates/template-book-detail.php`'s lightbox** before
   it is ever assigned to a live page — real `<button>`s, JS open/close, focus moved
   into the dialog, Escape and a visible close control that is actually focusable.
   (A11Y-INTERACT-06)
6. **Add a `<track kind="captions">` requirement to the `videoblk` content pipeline**
   before any real video is supplied to it, and decide/record a captioning policy for
   the Mokesh trailer (a transcript is the cheapest fix given `controls:0` is load-
   bearing for the autoplay-hero look). (A11Y-INTERACT-07, -08 — owner decision on the
   legal angle per the brief's 35ד framing, not this line's call)
7. **Delete the stray `aria-expanded="false"` in `block-faq-mini.php:58`** — trivial,
   zero risk, fixes the same bug class as #2 wherever this block gets placed.
   (A11Y-INTERACT-11)
8. Lower priority / cleanup: reconcile or retire the dormant fallback contact form
   (A11Y-INTERACT-10), and decide whether the Wave2 nav/drawer/dropdown/testimonials
   code (§3) should be wired back up (it is better-built than what is live) or removed
   to stop it from silently bit-rotting or confusing the next engineer who edits it
   believing it is live.

---

## 11. Where I think other lines will get this wrong

- **Anyone testing keyboard/focus behaviour against `.ea-topnav`, `.ea-mnav-drawer`,
  `ea-mobile-nav.js`, or the Wave2 dropdown and reporting a PASS is testing dead code.**
  That system is well-built and would deserve a pass on its own — but it is not what a
  real visitor to any page I checked encounters. A line that audits only the source
  (without a live check) is very likely to credit the site with this drawer's careful
  focus-trap/Escape/restore behaviour, when the live experience is the Chapters `#nav`
  with A11Y-INTERACT-01/-02/-03 instead. The reverse mistake is just as likely: crawling
  the live DOM only and never reading `ea-mobile-nav.js` would miss that a
  *better* implementation already exists in the codebase and could be reused rather
  than rebuilt.
- **The same trap applies to testimonials**: `ea-testimonials.js` (dots) and the
  auto-scroll marquee are real, careful, and not live on the page I checked them on.
  Only `ea-testi-mq.js` is live on the home page today.
- **The book-cover lightbox will look like a slam-dunk critical finding from source
  alone** — and it would be, if it were reachable. Whoever checks it should check
  `document.body.className` on the live page first, the way I did, before scoring it;
  I nearly filed this as a plain "Critical, live" finding before that one check
  changed the picture.
- **A shared-browser-pane session collision will silently corrupt a live check** for
  any line that does not verify `document.title`/`location.href` immediately before
  trusting a DOM read. I hit this repeatedly this session (§1). It produces exactly
  the "confident wrong answer" pattern this project has been burned by before, just
  from a new cause (concurrent agents, not a harness bug) — worth adding to the
  project's permanent trap list, not just this round's.
- **Regulation 35ד**: I have deliberately not asserted or assumed any turnover-based
  exemption anywhere above, and I have kept the two Mokesh/videoblk media findings
  framed as WCAG 1.2.2 technical-conformance gaps *first*, with the legal question
  named separately as the owner's to resolve. A line that either asserts the exemption
  applies, or asserts the law definitely requires captions here, is going beyond what
  this audit — or team_100 — actually knows.

---

*Auditor: team_10 (A11Y-INTERACT line). Findings prefixed `A11Y-INTERACT`. This report
is read-only evidence for team_100/team_50 consolidation; no file under `site/` was
modified in the course of this audit.*
