# RTL Audit — Angle 03: Interactive JavaScript

**Theme:** `ea-eyalamit`
**Scope:** every `*.js` file under `site/wp-content/themes/ea-eyalamit/assets/js/` (14 files)
**Date:** 2026-09-17
**Standard applied:** `_aos/lean-kit/modules/standards-conventions/rtl-bidi/RTL_BIDI_STANDARD_v1.0.0.md` (AOS Module 11), Section 7 (JavaScript and Dynamic Content) and Section 8.1 JS checklist in particular.
**Reference implementation:** `assets/js/ea-testi-mq.js`, per tonight's live fix (signed `-index*step()` transform, `LEFT` increments / `RIGHT` decrements because this RTL site reads "forward" toward the left, idle auto-advance reusing the same `apply()`/`step()` math as the click handlers).

## Intro

This audit covers all 14 JavaScript files shipped in the theme, checked against six risk categories: (1) `translateX`/`translate3d`/`left`/`right` positional math, (2) `scrollLeft` usage, (3) `ArrowLeft`/`ArrowRight` keyboard handling, (4) swipe/touch/pointer gesture direction, (5) hardcoded `'left'`/`'right'` strings or direct `style.left`/`style.marginLeft` assignment, and (6) whether the file is actually enqueued and reachable on a live page, given this theme's known dual-template ("Wave2" vs "Chapters") debt.

Method: every file was read in full. Risk-pattern claims were then cross-checked with targeted greps across all 14 files simultaneously (`scrollLeft`, `ArrowLeft`/`ArrowRight`/`keyCode 37/39`, `touchstart`/`touchmove`/`clientX`/`deltaX`, `translateX`/`translate3d`, `style.left`/`style.right`/`marginLeft`/`marginRight`, hardcoded `=== 'left'`/`'right'`, and direction-reading APIs) so no instance was missed by a manual read. Live/dead status was established by tracing `wp_enqueue_script` calls in `functions.php` and everything under `inc/` back through their gating conditions (`is_page_template()`, `is_page()`, the `ea_wave2_shell` query var, `ea_chapters_is_view()`), then cross-checked against which template file actually renders on a live request (`page-templates/tpl-chapters-*.php` for anything Chapters routes) and whether the DOM selectors each script queries actually exist in that live markup — not just whether the `<script>` tag is printed. This distinction matters: two files below (`ea-hero.js`, `ea-mobile-nav.js`) are enqueued sitewide today but query DOM elements that no longer exist in the live render tree — they ship bytes and execute, but are functionally inert. A third (`ea-testimonials.js`) is the predecessor the task asked about explicitly, and a fourth (`books-reveal.js`) turned out to be dead by the same pattern for unrelated (non-RTL) reasons.

**Headline result:** no live-breaking RTL bug of the kind fixed tonight in `ea-testi-mq.js` was found elsewhere in this file set. `scrollLeft`, `ArrowLeft`/`ArrowRight` keyboard bindings, and swipe/touch gesture code — the three riskiest categories per the brief — are **not used anywhere** in this theme's JS today (confirmed by grep across all 14 files, zero hits). The findings that do exist are: three low-severity/cosmetic hardcoded-physical-property or non-canonical-API issues, and a confirmation that four of the fourteen files are dead or functionally inert on the live site, one of which (`ea-testimonials.js`) is exactly the superseded predecessor of `ea-testi-mq.js` the task suspected.

---

## Per-file findings

### assets/js/books-reveal.js — no RTL-relevant code; dead on live pages

No `translateX`/`left`/`right` math, no `scrollLeft`, no arrow keys, no swipe, no hardcoded direction strings. Nothing to flag under criteria 1–5.

Under criterion 6: this file is enqueued by `ea_eyalamit_books_v2_assets()` (`functions.php:705-713`, `wp_enqueue_scripts` priority 26), gated on `ea_eyalamit_is_books_hub_view() || ea_eyalamit_is_book_detail_view()` (`functions.php:678`). Both gate functions check **stale page slugs**: `ea_eyalamit_is_books_hub_view()` (`functions.php:538-546`) checks `post_name` against `array('muzza', 'muzeh')`, but the live books hub page is `/books/` (confirmed in `template-parts/chapters/section-nav.php:47`, and in the Chapters route map at `inc/chapters/chapters-render.php:47`, where `'books'` is the live slug and `'muzza'` is only an internal content-type key, not a URL slug). `ea_eyalamit_is_book_detail_view()` (`functions.php:554-562`) checks `ea_eyalamit_get_book_detail_slugs()` (`functions.php:522-529`), which returns `'kushi-blantis'`, `'tsva-bechol-ve-zorek-layam'`, `'vekatavt'` — the live slugs (per the same nav partial and route map) are `'kushi-blantis'` (coincidentally matches), `'tsva-bekahol'`, and `'vekatavta'` (both renamed, no longer match). Even on the one page where the gate does pass (`kushi-blantis`), the `.reveal` class this script queries (`document.querySelectorAll('.reveal')`, line 15) only exists in `page-templates/template-book-detail.php` and `template-books-hub.php` (confirmed by grep) — both superseded by Chapters' `tpl-chapters-page.php` for every one of these slugs, per `ea_chapters_route_map()`. Net effect: the script is inert everywhere on the live site (line 16-18 early-returns when `els.length` is 0). **Dead code**, unrelated to RTL, but matches the "known dead legacy JS" pattern the task asked to watch for.

### assets/js/ea-ab-testing.js — clean, live sitewide

No positional math, no `scrollLeft`, no arrow keys, no swipe, no hardcoded `left`/`right`. All DOM interaction is `display`/attribute toggles and click-tracking (WhatsApp float, CF7 form, in-page CTA blocks, footer social links, `tel:` links) — none of it direction-sensitive.

Live: enqueued inside `ea_wave2_enqueue_assets()` (`inc/wave2-stage-b.php:121`), gated by `ea_wave2_is_active_view()` (`inc/wave2-stage-b.php:61-80`), which returns true via `get_query_var('ea_wave2_shell')` — set unconditionally on `template_redirect` for every view `ea_chapters_is_view()` recognizes (`inc/chapters/chapters-routing.php:59-63`), i.e. the whole live site. Its target elements (`.ea-whatsapp-float[data-ea-ab]`, rendered sitewide via `ea_wave2_render_whatsapp_float()` on `wp_footer`, `inc/wave2-stage-b.php:~412`; `.ea-contact-form--cf7`/`.ea-contact-section`, present in the live `template-parts/chapters/parts/contact.php`) are confirmed present in the live DOM. No findings.

### assets/js/ea-blog-share.js — one low-severity hardcoded-physical-property finding; live

```
24		ta.style.position = 'absolute';
25		ta.style.left = '-9999px';
```

**Risk:** criterion 5 (`style.left =`) — this is a hidden-textarea `execCommand('copy')` fallback. **Actual impact: none.** `left: -9999px` moves the element 9999px from the containing block's physical left edge, which is off-screen in both `dir="ltr"` and `dir="rtl"` documents — CSS `left`/`right` are physical properties unaffected by `direction`, and the viewport's physical left edge doesn't move when the document is RTL. The textarea is invisible and its `.value` (not its rendered position) is what gets copied, so there is no user-visible failure. Flagging per the letter of the audit brief and the standard's JS checklist ("No hardcoded `'left'`/`'right'` strings in positioning logic," Section 8.1) — this is a style/future-proofing issue, not a live bug.

**Fix:** use a logical/direction-neutral equivalent, e.g. `ta.style.insetInlineStart = '-9999px';` (or fold the off-screen rule into a CSS class using `inset-inline-start`), so a future edit that adds a `top`/`right` to this block can't accidentally interact with a mirrored layout.

Live: enqueued by `ea_chapters_blog_assets()` (`inc/chapters/chapters-enqueue.php:125-149`) when `ea_chapters_is_blog_view() && is_singular('post')`. Its target, `[data-ea-copy-link]`, is confirmed present in the live `page-templates/tpl-chapters-blog-single.php:66`.

### assets/js/ea-book-purchase.js — clean, live

Pure GA4 event dispatch on click (`[data-ea-book-purchase]` → `book_purchase_click`). No positional/direction logic of any kind. No findings.

Live: enqueued by `ea_chapters_book_purchase_assets()` (`inc/chapters/chapters-commerce.php:68-83`), gated `is_page(array('vekatavta','kushi-blantis','tsva-bekahol'))` — these are the live book-detail slugs (see `books-reveal.js` above for the slug-mismatch contrast). Target markup `data-ea-book-purchase` confirmed present in `template-parts/chapters/parts/phero.php:35` and `parts/cta.php:26,30`.

### assets/js/ea-chapters.js — clean, live sitewide

Covers nav scroll-state, `IntersectionObserver` scroll-reveal, mobile hamburger (`.nav__burger`), hero-video autoplay/sound toggle (`#soundtg`), and click-to-play video blocks. No `translateX`/`left`/`right` math, no `scrollLeft`, no arrow-key handling (only `Escape` to close the mobile menu, which is direction-neutral), no swipe/touch, no hardcoded direction strings. No findings.

Live: enqueued by `ea_chapters_enqueue_assets()` (`inc/chapters/chapters-enqueue.php:19-59`) whenever `ea_chapters_is_view() || ea_chapters_is_blog_view()` — i.e. sitewide. Confirmed by its own selectors (`#nav`, `.nav__burger`, `.r`, `#soundtg`, `.hero__media`) matching the live `template-parts/chapters/section-nav.php` and `section-hero.php` markup.

### assets/js/ea-entrance.js — clean, live sitewide

`IntersectionObserver`-driven entrance animation; toggles a class or resets `opacity`/`transform` to `'none'` on reduced-motion. No direction-sensitive code. No findings.

Live: enqueued inside `ea_wave2_enqueue_assets()` (`inc/wave2-stage-b.php:119`), same sitewide `ea_wave2_shell` gate as `ea-ab-testing.js`. Its targets `.ea-entrance`/`.ea-entrance--breath`/`.ea-entrance--slide` are used extensively and directly inside the live Chapters templates (e.g. `template-parts/chapters/parts/contact.php:23,61`, `parts/faq-inline.php:33`, and every `template-parts/blocks/*.php` partial that Chapters' own inner pages still borrow) — confirmed live and functional, not just enqueued.

### assets/js/ea-faq-toc.js — clean, live

Scroll-spy + smooth-scroll TOC using `scrollIntoView()` and `IntersectionObserver`; measures nav/TOC height for a scroll-margin offset. No `left`/`right` math, no `scrollLeft`, no arrow keys, no swipe. `scrollIntoView({block: 'start'})` is direction-agnostic (it operates on the block axis, not inline axis). No findings.

Live: enqueued by `ea_chapters_faq_toc_assets()` (`inc/chapters/chapters-enqueue.php:99-120`), gated `is_page('faq')`. Target `[data-faq-toc]` confirmed in `template-parts/blocks/block-faq-list.php:70`, used by the FAQ route (`inc/chapters/chapters-render.php:40`, `type => faq`).

### assets/js/ea-hero.js — hardcoded left+right (benign); file is enqueued sitewide but functionally dead

```
34		    links.style.top = 'var(--ea-nav-height)';
35		    links.style.right = '0';
36		    links.style.left = '0';
```

**Risk:** criterion 5. Both `right` and `left` are pinned to `0` (full-bleed dropdown), so the two physical edges are symmetric and the result is identical under `dir="ltr"` or `dir="rtl"` — **not a live directional bug**, but it is exactly the hardcoded-physical-property pattern the standard's Section 8.1 JS checklist bans ("No hardcoded `'left'`/`'right'` strings in positioning logic — use logical or conditional"), and it sets a bad precedent to copy from.

**Fix:** `links.style.insetInlineStart = '0'; links.style.insetInlineEnd = '0';` (or move this whole block into a CSS class toggle rather than four inline-style assignments).

**Live/dead status — this is the more important finding for this file.** `ea-hero.js` is enqueued inside `ea_wave2_enqueue_assets()` (`inc/wave2-stage-b.php:122`) under the same sitewide `ea_wave2_shell` gate as `ea-ab-testing.js`/`ea-entrance.js` — so its `<script>` tag ships and executes on every live page. But every selector it queries — `.ea-sound-toggle` (line 6), `.ea-topnav__burger`/`.ea-topnav__links`/`.ea-topnav__dropdown-toggle` (lines 24, 47), `.ea-hero__video` (line 81) — belongs to `template-parts/blocks/block-topnav.php` and `block-hero.php` (the Wave2 nav/hero blocks). Those two files are called only from `ea_wave2_render_home_blocks()` (`inc/wave2-stage-b.php:349`, reachable only via the frozen `page-templates/tpl-home.php`/`tpl-stage-b-test.php`) and directly from `page-templates/tpl-qr.php`, `tpl-content.php`, `tpl-blog-archive.php`, `tpl-blog-single.php` — **all of which are superseded** by `tpl-chapters-*.php` equivalents under the live Chapters router (`ea_chapters_template_include()` at priority 103 and `ea_chapters_blog_template_include()` at priority 105, both overriding these older `template_include` registrations). A grep of `template-parts/chapters/` for `ea-topnav`, `ea-mnav`, `ea-sound-toggle`, `ea-hero__video` returns zero matches — none of this script's selectors exist anywhere in the live render tree. Every guard in the file (`if (btn) {...}`, `if (burger && links) {...}`) means it fails silently rather than throwing, so there's no visible symptom — it's just dead weight shipping on every pageview today.

### assets/js/ea-mobile-nav.js — reference-quality RTL handling, but currently dormant (dead)

This file is, alongside `ea-testi-mq.js` and `ea-testimonials.js`, one of the three best-written files in the set for direction-awareness:

```
20	  var html = doc.documentElement;
21	  var dir = (html.getAttribute("dir") || "rtl").toLowerCase();
...
35	  function applySide(side) {
36	    drawer.setAttribute("data-side", side);
37	    var physicalLeft = (side === "start" && dir === "ltr") || (side === "end" && dir === "rtl");
38	    html.style.setProperty("--ea-mnav-tx", physicalLeft ? "-100%" : "100%");
39	  }
```

This is exactly the pattern the standard prescribes for drawers (Section 5.4): it derives the *physical* slide sign from *both* the logical `side` ("start"/"end") and the actual document `dir`, instead of assuming one direction. No `scrollLeft`, no arrow keys, no swipe/touch gesture code.

**One cosmetic finding:** line 21 reads direction via `html.getAttribute("dir")` (i.e. `document.documentElement`'s attribute) rather than the canonical `document.dir` the standard mandates (Section 7.1: "MUST use `document.dir`... not `document.documentElement.dir`"; Section 8.1 checklist, same wording). The two return identical values in every browser (there is no functional difference here — `documentElement` IS `<html>`, and reading the attribute vs. the IDL property both surface the same `dir="rtl"`), so this is a naming/consistency nitpick only, not a bug.

**Fix (cosmetic only):** `var dir = (document.dir || "rtl").toLowerCase();`

**Live/dead status.** Like `ea-hero.js`, this file is enqueued sitewide inside `ea_wave2_enqueue_assets()` (`inc/wave2-stage-b.php:123`), but every element it queries — `.ea-topnav` (line 23), `#ea-mnav-drawer` (line 24), `.ea-mnav-scrim` (line 25), `.ea-mnav-burger`/`.ea-mnav-close`/`.ea-mnav-sound`/`.ea-mnav-acc__btn` — lives only in `template-parts/blocks/block-topnav.php`, which (see `ea-hero.js` above) is only reachable via templates the live Chapters router now overrides. Line 26 (`if (!topnav || !drawer || !scrim) return;`) means it silently no-ops on every live page today. Worth calling out precisely because it is the file with the *most correct* RTL logic in the whole theme, and it is currently not running anywhere live — if the Wave2 emergency rollback (`EA_CHAPTERS_FRONT=false`) is ever flipped, this is the one piece of dormant code that would come back and already be correct; `ea-hero.js` would come back and still carry its (admittedly benign) style-guide violation.

### assets/js/ea-mokesh.js — clean, live (scoped)

YouTube IFrame Player API wrapper for one memorial hero trailer. No positional math, no `scrollLeft`, no arrow keys, no swipe, no direction strings — only mute/unmute state and Hebrew label text swaps. No findings.

Live: enqueued by `ea_chapters_mokesh_enqueue_assets()` (`inc/chapters/chapters-enqueue.php:82-94`), gated `'mokesh-dahiman' === ea_chapters_current_slug()`. Target `#ea-mokesh-trailer` confirmed in `template-parts/chapters/parts/mokesh-hero.php:22`, which is only reachable via the route map's `'mokesh-dahiman' => tpl-chapters-mokesh` entry (`inc/chapters/chapters-render.php:52`) — live on that one route.

### assets/js/ea-qr-facade.js — clean, live (scoped)

Swaps a poster image for a live YouTube iframe on click. No positional/direction logic at all. No findings.

Live: enqueued by `ea_chapters_qr_facade_assets()` (`inc/chapters/chapters-qr-facade.php:94-106`), gated `ea_chapters_qr_facade_is_view()`. Its target buttons (`.ea-qr-facade`) are injected via an `the_content` filter (`ea_chapters_qr_facade_content()`, same file, lines ~60-88) on QR routes (route map `'qr' => tpl-chapters-page` plus the `/qr/qrN/` pattern route to `tpl-chapters-qr`, `inc/chapters/chapters-render.php:48,81`). Live.

### assets/js/ea-scroll.js — clean, live sitewide; one cross-cutting note (not a JS bug)

```
14	    var pct = height > 0 ? (scrollTop / height) * 100 : 0;
15	    bar.style.width = pct + '%';
```

No findings under criteria 1–5: this script only ever writes `.style.width`, never `left`/`right`/`transform`, so the JS itself carries no directional assumption — it is inherently direction-agnostic. Whether the bar visually fills from the reading-start side or not is entirely a function of the *paired CSS* for `#ea-scroll-progress` (its `inset-inline-*`/`left`/`right` anchoring), which is out of scope for a JS audit — flagging here only so the CSS-angle audit knows to check it, since a reading-progress bar conventionally should fill from the inline-start edge (right, in this RTL site) and a physical `left: 0` anchor on the bar's container would make growing `width` look like it fills from the wrong side.

Live: enqueued inside `ea_wave2_enqueue_assets()` (`inc/wave2-stage-b.php:120`), same sitewide gate. Its target `#ea-scroll-progress` is rendered by `ea_wave2_body_open_extras()` on `wp_body_open` (`inc/wave2-stage-b.php:~412-423`), itself gated by the same `ea_wave2_is_active_view()` — so, unlike `ea-hero.js`/`ea-mobile-nav.js`, both the script and its DOM target share the live sitewide gate. Confirmed live and functional.

### assets/js/ea-testi-mq.js — reference implementation; live (this is tonight's fix)

Already reviewed in full as the audit's reference. Signed pixel offset (`-index*step()`, clamped by `extraWidth()`), direction handled by the fixed (and correct, for this always-RTL site) convention that LEFT advances and RIGHT retreats, idle auto-advance reusing the exact same `apply()`/`step()`/`maxIndex()` math as the manual buttons so there is no second implementation to drift. No `scrollLeft`, no arrow-key binding, no swipe/touch. No findings — included in this table for completeness since the brief asks for every file.

Live: enqueued by `ea_chapters_enqueue_assets()` (`inc/chapters/chapters-enqueue.php:51-57`), same sitewide gate as `ea-chapters.js`. Its target `[data-testi-mq]` is used by `template-parts/chapters/section-05-testimonials.php` and `parts/testimonials.php`, which the live homepage renders directly (`page-templates/tpl-chapters-home.php:66`). Confirmed live.

### assets/js/ea-testimonials.js — correct RTL math, but this is the dead predecessor

```
45		// RTL-correct sign: in RTL the track must move toward the inline-start
46		// (positive translateX); in LTR toward negative translateX.
47		function rtlSign() {
48			return getComputedStyle( track ).direction === 'rtl' ? 1 : -1;
49		}
...
74			track.style.transform = 'translateX(' + ( rtlSign() * index * vw ) + 'px)';
```

No bug here either — if anything this is *more* standards-compliant than `ea-testi-mq.js` on one specific point: it reads direction via `getComputedStyle(track).direction`, which is precisely the pattern the standard recommends for a scoped component (Section 7.1: "Read direction of any element (computed, includes inheritance)"), and it derives the transform sign from that read rather than hardcoding an assumption. No `scrollLeft`, no arrow keys, no swipe.

**This is the file the task asked to confirm explicitly: it is dead on the live site**, superseded by `ea-testi-mq.js`. Evidence chain:
1. Its `wp_enqueue_script` call (`inc/wave2-stage-b.php:142`) sits inside `if ( is_page_template( 'page-templates/tpl-home.php' ) )` (line 140) — nested *inside* the already-sitewide `ea_wave2_enqueue_assets()`, i.e. it needs this extra, narrower condition on top of the shell gate.
2. `page-templates/tpl-home.php` is explicitly self-documented as dead: `"FROZEN EMERGENCY ROLLBACK (WP-CANON T6): kept when EA_CHAPTERS_FRONT=false. Do not edit — Chapters tpl-chapters-home.php is the live template."` (`tpl-home.php:6-7`).
3. `EA_CHAPTERS_FRONT` is never defined `false` anywhere in this codebase (confirmed by grep across all PHP) — it defaults to `true` (`inc/chapters/chapters-render.php:92`), so Chapters is live and the front page is force-routed to `tpl-chapters-home.php` by `ea_chapters_template_include()` (`inc/chapters/chapters-routing.php:22-24`) regardless of the page's stored template meta.
4. The live homepage template renders `get_template_part('template-parts/chapters/section', '05-testimonials')` (`tpl-chapters-home.php:66`) — i.e. the `[data-testi-mq]` markup `ea-testi-mq.js` drives — not the `[data-testi-rotator]` markup this script needs.
5. `[data-testi-rotator]` (this script's mount point) exists in exactly one place in the codebase: `template-parts/blocks/block-testimonials-row.php:73`. That partial is in turn only reachable from `inc/wave2-w2-07.php:286`, a Wave2-era file with no live call path once the front page and every mapped inner slug route through Chapters. So even in the hypothetical edge case where stale page-template postmeta made the enqueue condition evaluate true, the DOM node this script needs to find would still not exist on the live page, and `initRotator()`'s own guard (`if (!track || !dotsWrap) return;`, line 26-28) means it no-ops safely.

**Conclusion for the live/dead question asked explicitly:** `ea-testimonials.js` is the superseded predecessor of `ea-testi-mq.js`, exactly as suspected. It should not be used as a model for anything going forward (even though its code happens to be correct) since it is not reachable from any live URL.

---

## Patterns section

**1. The three highest-risk categories in the brief are entirely absent from this codebase.** `scrollLeft` (0 uses), `ArrowLeft`/`ArrowRight`/keyCode 37/39 keyboard bindings (0 uses), and touch/swipe/pointer-drag gesture code (0 uses) do not appear anywhere in the 14 files — confirmed by grep across the whole set, not just by manual reading. There is currently no carousel, drawer, or scrollable region in this theme's JS that responds to keyboard arrows or touch gestures at all; every "next/prev" interaction is button-click only. This is worth recording so a future scroll-container or swipeable carousel gets these three categories designed in correctly from day one, rather than retrofitted.

**2. Two genuinely different, both-correct conventions for deriving transform direction coexist, and that's fine.** `ea-testi-mq.js` hardcodes "LEFT = forward, RIGHT = back" because this site is permanently RTL with no LTR variant — a defensible simplification the code's own comments justify. `ea-testimonials.js` and `ea-mobile-nav.js` instead read direction at runtime (`getComputedStyle(...).direction` / the `dir` attribute) and derive the sign algebraically. Both approaches satisfy the standard; a project this permanently-RTL doesn't need every file to runtime-detect direction, but any component that could plausibly be reused in an LTR context (the `en` route exists — `tpl-chapters-en.php`, route map `'en'`) is safer using the runtime-detection style. Worth a style-guide note so contributors don't "fix" `ea-testi-mq.js`'s hardcoding by mistake, and don't skip runtime detection on a component destined for the `/en/` pages.

**3. `document.dir` vs `documentElement.getAttribute('dir')`.** Only `ea-mobile-nav.js` reads direction at all among the "hardcode" group, and it uses the non-canonical form. Purely cosmetic (identical output in every browser), but worth a lint rule since the standard calls this out explicitly (Section 7.1, Section 8.1 checklist) and it's a one-line fix.

**4. The dual-template ("Wave2" vs "Chapters") debt produces a distinct, RTL-adjacent risk class of its own: correct-looking code that cannot be trusted to be live.** Two files (`ea-hero.js`, `ea-mobile-nav.js`) are enqueued unconditionally sitewide today (their gate, `ea_wave2_shell`, is set true on every Chapters view) yet query DOM nodes that exist only in Wave2 block partials no live route renders anymore. Two more files (`books-reveal.js`, `ea-testimonials.js`) have narrower gates that are themselves keyed to dead conditions (stale slugs, or a frozen rollback template). All four fail *silently* — no console errors, no visual symptom — which is exactly how "fix a bug in dead code, ship nothing, move on confused" incidents happen. None of the four dead/inert files contains a live-breaking RTL bug, but two of them (`ea-hero.js`, `ea-mobile-nav.js`) do contain the kind of code a future contributor might reasonably go looking for and "fix" without realizing it never runs.

**5. Hardcoded physical `left`/`right` in JS, where it does occur, happens to be low-consequence today** (`ea-blog-share.js`'s off-screen textarea trick works identically in both directions by construction; `ea-hero.js`'s `left:0`/`right:0` pair is symmetric). Neither is a live bug. Both are still worth cleaning up per the standard's explicit JS checklist ban on hardcoded `left`/`right` strings, mostly so a future edit to either block (e.g. adding a `top`/asymmetric offset) doesn't quietly introduce a real one.

---

## Prioritized recommendations

1. **Confirm and then act on the dead-code findings (highest value, not urgent).** Bring `books-reveal.js`, `ea-testimonials.js`, and the functionally-inert parts of `ea-hero.js`/`ea-mobile-nav.js` to the team that owns the Wave2→Chapters migration (per project memory, this is tracked debt). Either (a) delete the dead files/enqueue calls once the emergency-rollback path is retired for good, or (b) if the rollback must stay warm, add a code comment at the top of each cross-referencing its live replacement, so nobody spends time RTL-auditing or bug-fixing code that cannot run. This directly prevents a repeat of tonight's root cause in a different shape: not a backwards button, but wasted effort on a component nobody can see.
2. **Stop shipping `ea-hero.js` and `ea-mobile-nav.js` bytes on every live pageview if they are confirmed permanently superseded.** They currently load (not just sit in the repo) on every request via the sitewide `ea_wave2_shell` gate, for zero live behavior. This is a performance/hygiene fix more than an RTL one, but it falls out of this audit directly.
3. **Low-severity cleanup, batchable with any other pass over these two files:** replace `ea-blog-share.js:25`'s `style.left` with `insetInlineStart`, and `ea-hero.js:35-36`'s `style.right`/`style.left` pair with `insetInlineStart`/`insetInlineEnd`. Neither fixes a live bug; both bring the files into line with the standard's explicit JS checklist and remove a bad copy-paste source.
4. **Cosmetic, no urgency:** `ea-mobile-nav.js:21`, swap `html.getAttribute("dir")` for `document.dir` to match the canonical API the standard names explicitly. Zero behavior change.
5. **Not a JS fix, but flag to the CSS-angle audit:** `ea-scroll.js` only ever writes `.style.width`; whether the reading-progress bar fills from the correct (inline-start) edge in this RTL site depends entirely on `#ea-scroll-progress`'s CSS anchoring, which this audit did not cover.
6. **No action needed, but worth stating plainly for the record:** none of the six risk categories in the brief turned up a live bug anywhere outside of tonight's already-fixed `ea-testi-mq.js` history. The two best-written files for RTL correctness in the theme (`ea-mobile-nav.js`, `ea-testimonials.js`) are both currently dead weight — worth keeping in mind if either is ever revived, since reviving them would cost nothing on the RTL front.

---

## Enqueue status — every JS file in the theme

| File | Enqueued by (function / file) | Gate condition | Loaded on a live page? |
|---|---|---|---|
| `books-reveal.js` | `ea_eyalamit_books_v2_assets()` — `functions.php:674-713` | `ea_eyalamit_is_books_hub_view()` \|\| `is_book_detail_view()` — both check **stale slugs** (`muzza`/`muzeh`; `tsva-bechol-ve-zorek-layam`/`vekatavt`) that don't match the live slugs (`books`; `tsva-bekahol`/`vekatavta`) | **Dead.** Gate passes only on `/books/kushi-blantis/` (coincidental slug match), and even there its `.reveal` target only exists in the superseded `template-book-detail.php`. |
| `ea-ab-testing.js` | `ea_wave2_enqueue_assets()` — `inc/wave2-stage-b.php:121` | `ea_wave2_is_active_view()` → true via `ea_wave2_shell` (set on every Chapters view, `chapters-routing.php:59-63`) | **Live**, sitewide. |
| `ea-blog-share.js` | `ea_chapters_blog_assets()` — `inc/chapters/chapters-enqueue.php:125-149` | `ea_chapters_is_blog_view() && is_singular('post')` | **Live**, on blog single posts (`tpl-chapters-blog-single.php`). |
| `ea-book-purchase.js` | `ea_chapters_book_purchase_assets()` — `inc/chapters/chapters-commerce.php:68-83` | `is_page(array('vekatavta','kushi-blantis','tsva-bekahol'))` | **Live**, on the 3 book-detail pages. |
| `ea-chapters.js` | `ea_chapters_enqueue_assets()` — `inc/chapters/chapters-enqueue.php:19-59` | `ea_chapters_is_view() \|\| ea_chapters_is_blog_view()` | **Live**, sitewide. |
| `ea-entrance.js` | `ea_wave2_enqueue_assets()` — `inc/wave2-stage-b.php:119` | same `ea_wave2_shell` gate as `ea-ab-testing.js` | **Live**, sitewide (`.ea-entrance` used throughout live Chapters partials). |
| `ea-faq-toc.js` | `ea_chapters_faq_toc_assets()` — `inc/chapters/chapters-enqueue.php:99-120` | `is_page('faq')` | **Live**, on the FAQ page. |
| `ea-hero.js` | `ea_wave2_enqueue_assets()` — `inc/wave2-stage-b.php:122` | same `ea_wave2_shell` gate | **Enqueued sitewide, but functionally dead** — its selectors (`.ea-topnav__burger`, `.ea-sound-toggle`, `.ea-hero__video`) only exist in the superseded `block-topnav.php`/`block-hero.php`. |
| `ea-mobile-nav.js` | `ea_wave2_enqueue_assets()` — `inc/wave2-stage-b.php:123` | same `ea_wave2_shell` gate | **Enqueued sitewide, but functionally dead** — same reason (`.ea-topnav`, `#ea-mnav-drawer`, `.ea-mnav-scrim` only in the superseded `block-topnav.php`). |
| `ea-mokesh.js` | `ea_chapters_mokesh_enqueue_assets()` — `inc/chapters/chapters-enqueue.php:82-94` | `ea_chapters_current_slug() === 'mokesh-dahiman'` | **Live**, on `/eyal-amit/mokesh-dahiman/` only. |
| `ea-qr-facade.js` | `ea_chapters_qr_facade_assets()` — `inc/chapters/chapters-qr-facade.php:94-106` | `ea_chapters_qr_facade_is_view()` | **Live**, on QR hub/child routes. |
| `ea-scroll.js` | `ea_wave2_enqueue_assets()` — `inc/wave2-stage-b.php:120` | same `ea_wave2_shell` gate | **Live**, sitewide (`#ea-scroll-progress` rendered by the same-gated `ea_wave2_body_open_extras()`). |
| `ea-testi-mq.js` | `ea_chapters_enqueue_assets()` — `inc/chapters/chapters-enqueue.php:51-57` | same gate as `ea-chapters.js` | **Live**, sitewide — this is the current, correct testimonials carousel (drives `[data-testi-mq]`, rendered on the homepage and elsewhere via `section-05-testimonials.php`). |
| `ea-testimonials.js` | `ea_wave2_enqueue_assets()` — `inc/wave2-stage-b.php:142`, nested inside `is_page_template('page-templates/tpl-home.php')` | `tpl-home.php` is the explicitly-frozen emergency-rollback template (`EA_CHAPTERS_FRONT` never set `false` anywhere) | **Dead.** Superseded by `ea-testi-mq.js`. Its target markup (`[data-testi-rotator]`, only in `block-testimonials-row.php` via dead `inc/wave2-w2-07.php`) does not exist in the live `tpl-chapters-home.php` render tree. |

---

*Angle: Interactive JS. Part of the multi-angle RTL audit requested 2026-09-17 following the live `ea-testi-mq.js` nav-button/positioning fix.*
