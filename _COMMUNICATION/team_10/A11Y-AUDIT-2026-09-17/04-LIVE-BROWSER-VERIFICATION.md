# A11Y-LIVE — Empirical Live-Browser Verification

Line: team_10 (A11Y-LIVE) · Date: 2026-09-17 · Repo: `EyalAmit.co.il-2026` ·
Branch `s006/tracker-integrity`
Standard: **IS 5568 level AA = WCAG 2.0 level AA** (binding). Any 2.1/2.2-only criterion
cited below is explicitly labelled "beyond the binding standard — recommendation only."
**This is not legal advice.**

Consolidation, claim verification and fixes: team_100. This line does not fix anything and
did not edit any file under `site/`.

Mandate: prove what a real rendering engine actually does — measurements, not readings of
source. Where this line's measurement contradicts a source-only line, this line's measurement
governs, but only where the measurement itself is sound; every place my own two measurement
paths initially disagreed with each other is called out and reconciled below (§6), not
silently dropped.

---

## 1. Scope and what I actually ran

**Target:** staging `http://eyalamit-co-il-2026.s887.upress.link` (HTTP, not HTTPS — no TLS
cert is even in play for this host; the brief's TLS-invalid-by-design note applies to the
`https://` scheme on this host, which I did not use). All navigations in this report hit this
host between **2026-09-17 20:17 and 20:32 UTC** (harness timestamps in the raw JSON).

**Page set** (11 pages, exactly my mandate's list): `/` (home), `/contact/`, `/treatment/`,
`/accessibility/`, `/faq/`, `/shop/`, `/blog/`, one blog post
(`/עוד-רגע-מחייו-של-מורה-לדיגרידו/`, percent-encoded in requests), `/en/`, `/qr/`, one child QR
page (`/qr/qr1/`). All 11 returned HTTP 200 on every navigation (confirmed both by a
preliminary `curl` orientation pass and, authoritatively, by the harness's own per-navigation
`response.status()` check — see "Rigor" below). Each page was measured at **desktop
(1440×900)** and **mobile (375×812, `isMobile:true`)** viewports.

**Tooling:** a hand-built Node v24 harness driving the actually-installed **Google Chrome
152.0.7977.83** (not a bundled "Chrome for Testing") over real CDP via `puppeteer-core`
23.11.1 and **axe-core 4.11.4** — both already vendored offline at
`scripts/qa/node_modules/` (no network dependency; loaded from my scripts under `tmp/qa/`
via Node's `createRequire` pointed at that package). I read the repo's own
`_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` first and followed its
house pattern (`--headless --disable-gpu --no-sandbox --ignore-certificate-errors
--hide-scrollbars`) rather than inventing a new one, but used `puppeteer-core` instead of raw
`WebSocket`+CDP-only for the parts that need a real accessible-name resolution
(`Accessibility.getPartialAXTree`/`getFullAXTree` via `page.createCDPSession()`), since that
requires more plumbing than the house probe's scrollWidth-only check needed.

**Scripts (all under `tmp/qa/a11y-2026-09-17/`, gitignored, read/write-only in that tree and
in `_COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/`):**
- `run.mjs` — the main sweep: axe-core, DOM contrast scan, keyboard traversal, AX-tree dump,
  200%-zoom/320px-reflow, image-load audit, wp-accessibility plugin-effect detection.
- `burger-toggle-check.mjs` — a targeted follow-up (see §2, A11Y-LIVE-01/02) built after the
  main sweep surfaced the mobile-nav problem, to directly activate the mobile-menu toggle with
  real keyboard events and measure before/after state.
- Raw JSON for every run is under `tmp/qa/a11y-2026-09-17/out/` (axe/, contrast/, keyboard/,
  ax-tree/, zoom-reflow/, images/, plugin-effect/, plus `manifest.json` and
  `burger-toggle-check*.json`), and 22 before/after screenshots under
  `tmp/qa/a11y-2026-09-17/out/screenshots/`. Every numeric claim below names the exact file.

**Discipline checks actually performed, per the brief's named traps:**
- **Viewport asserted non-zero and correct before trusting any measurement.** Every
  navigation reads back `window.innerWidth/innerHeight` and compares to the requested size
  (`gotoAndAssert()` in `run.mjs`); `manifest.json` records `measuredViewport` for all 22
  runs and all 22 show `viewportOk:true` (1440×900 / 375×812 exactly).
- **HTTP status asserted per navigation**, not inferred from absence of an error: all 22
  primary navigations plus every re-navigation (fresh reload before the keyboard walk, before
  the AX-tree dump, before the plugin-effect check) recorded `httpStatus:200`.
  `manifest.json`: zero entries carry `couldNotMeasure`, zero carry `fatalError`.
- **Tab-moves-focus-off-BODY sanity gate.** `walkKeyboard()` tracks whether every recorded
  stop stayed on `BODY`; `manifest.json`'s `keyboardSummary.brokenHarness` is `false` for all
  22 runs, and `en__desktop`/`en__mobile` additionally terminate cleanly by *returning* to
  `BODY` after 8 real content stops (`keyboard/en__desktop.json`) — i.e. Tab both leaves and
  correctly re-reaches `BODY` at natural document end, which is only possible if real key
  events are reaching the page throughout.
- **Images judged loaded only via `img.complete && naturalWidth>0 && naturalHeight>0`**, after
  scrolling the full page height first to trigger lazy-loaded images, never via a bare
  `naturalWidth` comparison. See §3 for the result.
- **No silent partial batches.** This harness drives one local Chrome sequentially (no remote
  browser-batch API in the loop), so the "503 mid-batch" failure mode named in the brief
  doesn't apply to how I drove Chrome; what *can* silently fail here is a real HTTP round-trip
  to the actual staging host, which is why every navigation's status is asserted (above) and
  `manifest.json`'s result count is verified as exactly 22 (11 pages × 2 viewports), matching
  the plan recorded in the same file's `pagesPlanned`/`viewportsPlanned`.
- **A genuine bug I found and fixed in my own instrument, disclosed rather than hidden:** my
  first contrast-ratio pass ignored the *foreground* text color's own alpha channel (Chrome
  reports `color: rgba(255,255,255,.88)` verbatim for CSS like that), which silently overstated
  contrast for any semi-transparent text color (measured 21:1 instead of the correct 15.97:1
  for one real case on the home page). Fixed by compositing the foreground color over the
  resolved background before computing luminance (`run.mjs`, `scanContrast`, the
  `fgRendered`/`colorAsRendered` computation) *before* running the full sweep — the numbers in
  §2/§3 are all post-fix. I also found and fixed a **direction-blind** overflow check (checked
  only the right edge; on this RTL site, real clipped content spills past the **left** edge —
  see A11Y-LIVE-03) before the full sweep, after a 200%-zoom screenshot visibly showed
  left-clipped nav text that my first pass had scored "0 offenders." Both fixes are in the
  `run.mjs` committed under `tmp/qa/`; the smoke-test numbers that exposed them are not what's
  reported below.

---

## 2. Findings

| ID | Severity | WCAG 2.0 SC | Measured/Inferred | Evidence | User impact |
|---|---|---|---|---|---|
| **A11Y-LIVE-01** | **High** | 2.4.7 Focus Visible (AA) | **Measured**, live, real keyboard events, 2 pages direct + sitewide by shared-partial inference | At the mobile viewport (375px, and by the CSS this applies to any width ≤1180px, i.e. most phones and many tablets), pressing Tab from page load walks through the **entire desktop primary nav** (10 top-level items + all dropdown submenus) before ever reaching the mobile-menu toggle button — and **28 of those 32 pre-toggle stops are geometrically off-screen** while genuinely holding keyboard focus. Measured twice, independently: home (`tmp/qa/a11y-2026-09-17/out/burger-toggle-check.json` — toggle first reached at **tab stop 33**, e.g. stop 3 focused at `rect.x=518` on a 375px-wide viewport) and `/contact/` (`out/burger-toggle-check___contact_.json` — toggle at **stop 32**, identically 28/32 off-screen). Root cause, read from source: `assets/css/chapters.css:104` and `:502` both set `.nav__l{display:none}` at ≤1080px/≤1180px, but a **later, same-file rule at `chapters.css:632-645`** re-declares `.nav__l{position:fixed;...;display:flex}` at the same ≤1180px breakpoint — later source order wins at equal specificity, so `.nav__l` is never actually `display:none`; it is hidden only by `transform:translateX(375px)` (confirmed live: `beforeActivation.navL.transform` = `"matrix(1,0,0,1,375,0)"`, exactly one viewport-width, in `out/burger-toggle-check.json`), which does **not** remove an element from the Tab order the way `display:none`/`visibility:hidden`/`inert` would. The toggle itself is `section-nav.php:78` (independently verified: `aria-label="תפריט" aria-expanded="false" aria-controls="nav"`); the panel is `section-nav.php:21` (`<ul class="nav__l" role="list">`). | A sighted keyboard-only user (motor-impaired, not using a screen reader) who tabs through a phone-width page sees **nothing happen** for the first ~30 presses — no visible focus indicator appears anywhere on screen, because focus is genuinely on links positioned a full screen-width away. They cannot tell whether the page is frozen, whether Tab is doing anything at all, or how many more presses stand between them and usable content, until — by persistence alone — they reach the toggle button. |
| **A11Y-LIVE-02** | **High** | 2.4.3 Focus Order (A) · 2.1.1 Keyboard (A) | **Measured**, live, real keyboard events (same 2 pages as LIVE-01) | Once the toggle **is** found and activated with a real `Enter` key press, the ARIA state and visuals update correctly (`aria-expanded` flips `false→true`; `.nav__l` becomes `transform:none`, on-screen, `inViewport:true` — see §3, this half is correct). But continuing to press **Tab forward** from the just-activated toggle does **not** enter the newly-revealed menu: on home, the next 6 Tab presses landed in `<main>` page content starting with the hero CTA button (`out/burger-toggle-check.json`, `postActivationTabStops[0]` = `main#main > header.hero > div.hero__c:nth-of-type(2) > a.btn.btn--terra`); identically on `/contact/` (`out/burger-toggle-check___contact_.json`). Cause: in the DOM, `button.nav__burger` (inside `div.nav__r`) comes **after** `ul.nav__l` (confirmed: `section-nav.php` renders `nav__l` at line 21, `nav__burger` at line 78 — the burger is structurally last in the nav). Forward Tab from the last element in a region moves to whatever follows the region in the DOM, which is `<main>`, not backward into `nav__l`. A user would have to know to press **Shift+Tab** to walk backward into the panel they just opened — a non-obvious, undiscoverable interaction. **Independently corroborated by a different line via a different activation method:** `03-INTERACTIVE-FORMS-MEDIA-AUDIT.md`'s A11Y-INTERACT-01 opened the same menu with a mouse **click** (not a keyboard `Enter`) and found the identical result — one Tab afterward lands on the same hero CTA link. Two independent lines, two different activation methods, the same outcome — this is not an artifact of how either of us triggered the toggle. That line's A11Y-INTERACT-02 additionally reports that the open panel does not visually cover the backdrop (a screenshot shows the hero photo still visible through roughly half the panel's width) — a distinct, complementary defect: my `afterActivation.navL.rect` confirms the panel's own layout *box* is genuinely full-width (`{x:0,w:375}`, `chapters.css:634`'s `inset:72px 0 0 0`), so the two findings agree rather than conflict — the box is correctly full-screen, but whatever should visually paint over the backdrop within it does not. | A keyboard user who *does* successfully find and open the hamburger menu (after the 30+ presses in LIVE-01) still cannot reach any of its links by continuing to do the one thing Tab is for — moving forward. The menu they just worked to open is, for practical purposes, still unusable. |
| **A11Y-LIVE-03** | Medium | 1.4.4 Resize Text (AA) | **Measured**, live, screenshot-confirmed | At 200% zoom (measured via Chromium's `documentElement.style.zoom`, applied at the 1440×900 baseline — see §6 methodology note), real navigation content is clipped off the page's **left** edge (this is an RTL page; overflow spills left, not right — my first pass checked only the right edge and reported zero offenders here until I looked at the screenshot and fixed the check, see §1). Concretely on home (`out/zoom-reflow/home.json`, `zoom200.offenders`): `nav#nav > div.nav__r` (165px past the left edge), `nav#nav > div.nav__r > a.nav__en` (the "EN" language link, 165px), `button#soundtg` (the sound-toggle button, 51px) — all confirmed visually in `out/screenshots/home_zoom200.png` (the leftmost nav controls are visibly cut off). Separately and distinctly, the testimonial carousel's own **clipping viewport** (not its intentionally-wide inner track — see §6) also overflows left by 756px on both home and `/treatment/` (`main#main > section... > div.testi-mq__viewport`, both `out/zoom-reflow/home.json` and `.../treatment.json`). Document-level `scrollWidth` never exceeds `clientWidth` in any of these cases (no scrollbar is created — the content is clipped, not scrollable), so this would not surface in a bare `scrollWidth>clientWidth` check either. | A low-vision user who zooms their browser to 200% (a standard assistive technique, and the literal test for this SC) permanently loses access to the language switch, the sound toggle, and (on home/treatment) sees a broken-looking, edge-clipped testimonials carousel — not merely "harder to read," but functionality and content actually removed from reach at the zoom level the SC exists to guarantee. |
| **A11Y-LIVE-04** | Low-Medium — **beyond the binding standard, recommendation only** (WCAG 2.1 AA, not IS 5568/WCAG 2.0) | 1.4.10 Reflow (2.1 AA) | Measured, live, screenshot-confirmed | At a 320px-wide viewport, the same `nav#nav > ul.nav__l` clipping is far larger in magnitude (up to 320px of a single element's own width pushed off-screen; 69-98 descendant offenders per page depending on page structure — `out/zoom-reflow/*.json`, `reflow320.offenders`), but visually harmless *for a sighted mouse/touch user* because the CSS correctly swaps in a hamburger icon at this width (confirmed in `out/screenshots/home_320.png` — the hamburger is visible and the desktop nav bar is not drawn on top of the layout). This is the same root cause as LIVE-01 (the collapsed panel keeps its natural, unclipped-by-`display:none` geometry) and is included here separately only because 1.4.10 Reflow is a WCAG 2.1, not 2.0, criterion — under the binding IS 5568/WCAG 2.0 AA standard this specific manifestation is not itself a compliance gap; LIVE-01 (2.4.7, WCAG 2.0 AA) already covers the keyboard-relevant consequence of the identical markup at the binding-standard level. | None beyond what LIVE-01 already describes for a keyboard user; a mouse/touch-only user at 320px sees a normal, correctly-collapsed mobile layout. Listed for completeness since the brief asked for this measurement explicitly. |
| **A11Y-LIVE-05** | Low-Medium | 4.1.2 Name, Role, Value (A) | **Measured** (axe-core, live) + **cited source** | axe-core (`runOnly: wcag2a+wcag2aa`) flags rule `aria-prohibited-attr` (axe impact: serious) as **incomplete** (needs human confirmation, not an auto-fail — axe cannot always prove AT non-support) on two elements on `/contact/`: `.ea-contact-cta` and `.ea-contact-nap`, both plain `<div>`s carrying `aria-label` with no ARIA `role` (`out/axe/contact__desktop.json` and `contact__mobile.json`, identical). Source, independently read: `template-parts/chapters/parts/contact.php:81` (`<div class="ea-entrance ea-contact-cta r" aria-label="דרכי התקשרות מהירות">`) and `:102` (`<div class="ea-entrance ea-contact-nap" aria-label="פרטי המרכז וכתובת">`). `aria-label` on a role-less `div` is not invalid per the ARIA spec's global-attribute rule, but has inconsistent support across AT/browser pairs — axe's own justification is exactly that. | Some screen-reader/browser combinations will not announce either group's label ("Quick contact methods" / "Center details and address"), degrading to an unlabelled block of contact links and address text — the content is still reachable and readable, just without the grouping cue sighted users get for free from the visual card layout. |
| **A11Y-LIVE-06** | Medium — **could not confirm compliance, not a confirmed failure** | 1.4.3 Contrast (Minimum) (AA) | **Measured** (DOM contrast scan + independent axe-core cross-check) | Across all 22 page/viewport runs, my own alpha-aware DOM contrast scan (`out/contrast/*.json`) found **zero** cases where a resolvable (solid-colour) background produced a ratio below threshold. However, on every single page, all or nearly all of the text visible in the initial viewport sits over a **background-image** (the sitewide nav bar's photographic/gradient header, and each page's own `phero`/hero banner) and is therefore reported `backgroundIndeterminate:true`, not a pass or fail — e.g. `/accessibility/` desktop: 21 of 21 checked text nodes indeterminate (`out/contrast/accessibility__desktop.json`); `/shop/` desktop: 32 of 32 (`out/contrast/shop__desktop.json`). axe-core independently flags the same class of case as `color-contrast` **incomplete** on every one of the 22 runs, and additionally flags `link-in-text-block` (1.4.1 Use of Color, A) as incomplete on `/en/` for the `tel:` link in the first paragraph, "contrast ratio could not be determined due to a background gradient" (`out/axe/en__desktop.json`). Visually (via the zoom/reflow screenshots) the white-on-dark-photo nav text reads as legible, but "looks fine to me" is not a measurement — I am reporting this honestly as unverifiable by either tool, not as a pass. | Cannot be stated with confidence either way from this line's measurements. If the underlying photo ever contains a light sky/region behind the white nav text (it did not in the specific frames I captured, but hero images can be swapped without a code change), contrast could fail silently with no build-time or lint-time signal, since neither axe nor a DOM-based checker can evaluate pixel colour under text without decoding the image itself (which I did not do — see §4). |

---

## 3. What I checked and found correct (with evidence)

- **The live skip link works, sitewide, at both viewports — verified by direct activation
  with real keyboard events, not by reading source.** On every one of the 11 pages, tab stop 1
  is an anchor with `href="#main"`; pressing a real `Enter` moves `document.activeElement` to
  the actual `<main>` element (`equalsQuerySelectorMain:true` in every
  `out/keyboard/*.json`'s `skipLinkTest.after`). This directly confirms the brief's "Verified
  environment facts" claim and independently corroborates A11Y-STRUCT's source-level finding
  (`01-STRUCTURE-SEMANTICS-AUDIT.md` §3) via a completely different method (mine: live
  activation; theirs: tracing `ea_wave2_is_active_view()`) — the two lines agree from
  independent evidence. **Important correction I found independently before reading their
  report:** the skip link visible in `header.php:24` (class `.ea-skip-link`, hyphenated) is
  **dead code** — the live element sitewide is `.ea-skiplink` (no hyphen), which I traced
  (independently of A11Y-STRUCT, then cross-checked against their citation) to
  `inc/wave2-stage-b.php:422`. I confirmed this live, not just in source: the *raw* (pre-JS)
  HTML fetched for `/` contains **zero** matches for `skip-link`/`skip_link`
  (`tmp/qa/a11y-2026-09-17/raw-html/home.raw.html`), yet the rendered DOM does contain
  `.ea-skiplink` — meaning a naive `curl`-only pass would have wrongly concluded the skip link
  was missing (exactly the "curl sees HTML only" trap the brief names; the skip link IS present
  server-side, my `curl` grep pattern simply didn't match the un-hyphenated class name — resolved
  by checking the live DOM, not by trusting either source read alone).
- **The mobile menu's own open mechanism is correctly implemented** (only the *reachability*
  of it, LIVE-01/02, is broken). Real `Enter` on `button.nav__burger` flips `aria-expanded`
  `false→true`, sets `#nav[data-menu="1"]`, and `.nav__l` genuinely becomes
  `transform:none`/on-screen (`out/burger-toggle-check.json`, `afterActivation`). `Escape`
  correctly closes it again (`data-menu` attribute removed, `out/burger-toggle-check.json`,
  `afterEscape`) without moving focus elsewhere or throwing it back to `BODY`.
- **Real Tab key events reliably reach the page, confirmed by a positive check, not by
  absence of error.** All 22 keyboard walks show `brokenHarness:false`
  (`out/manifest.json`); `/en/`'s walk (`out/keyboard/en__desktop.json`) both leaves `BODY` at
  stop 1 and **returns to `BODY`** at stop 9 after 8 genuine content stops — a clean, natural
  document end that is only observable if every intervening key event actually moved focus.
- **`/en/` correctly has no primary-nav landmark at all — measured live, matching
  A11Y-STRUCT's independent source-level finding exactly.** The entire keyboard walk is 9
  stops: skip link → 5 real content links → 2 footer links → a WhatsApp float button → `BODY`
  (`out/keyboard/en__desktop.json`) — no `nav__l`/`nav__burger` anywhere in the sequence,
  confirming `/en/` never includes `section-nav.php`. Independent cross-validation between a
  static-source line and a live-DOM line, in full agreement.
- **Heading tree, landmarks, and control-naming, via the real accessibility tree (CDP
  `Accessibility.getFullAXTree`) — not the DOM, the actual AX layer a screen reader consumes.**
  Home: 1×H1 → 11×H2 → 2×H3, no skipped levels (`out/ax-tree/home__desktop.json`); landmarks
  `navigation("תפריט ראשי")`, `main`, `contentinfo`, and 2 named `region`s, no duplicates,
  no unlabelled ambiguity. `/contact/`: 1×H1 → 2×H2 → 1×H3; landmarks include a `form`
  landmark correctly named "Contact form" (`out/ax-tree/contact__desktop.json`). **Zero**
  interactive-role AX nodes with an empty accessible name on either page
  (`noNameInteractive: []`), and **zero** DOM elements carrying `onclick`/a non-`-1` `tabindex`
  that resolve to a generic/`none` AX role (`genericExposedControls: []`, checked against
  `domCandidatesForGenericCheck` real DOM candidates, not assumed absent — see §4 for this
  check's disclosed limit).
- **Images: 100% loaded, 100% carry an `alt` attribute, across every page in the set.**
  After scrolling each full page to force lazy-loaded images to decode, every image on all 11
  pages had `naturalWidth>0 && naturalHeight>0 && complete:true` (home: 42/42; treatment:
  3/3; shop: 5/5; contact: 2/2; blog/blogpost/accessibility/faq/en: 1-2/1-2 each; `/qr/` and
  its child page have zero `<img>` elements at all, not a failure to load — confirmed by
  checking the count, not assuming). Full per-image data in `out/images/*.json`.
- **axe-core (wcag2a+wcag2aa only): zero rule violations on all 22 page/viewport
  combinations.** This is a real, positive result, but I want to be explicit about what it
  does and doesn't mean given everything else in §2: axe-core caught none of LIVE-01/02/03
  (focus order/visibility and zoom-driven layout clipping are outside what an automated DOM
  rule-checker can see), and its own `incomplete` list (LIVE-05/06) shows it was honestly
  uncertain about several things rather than confidently wrong. A clean axe run here is
  evidence of no *rule-detectable* defect, not evidence the page is fully accessible — treat
  the two results (0 violations, and the 6 live-measured findings above) as complementary,
  not contradictory.
- **The wp-accessibility plugin's live effect, measured, not assumed:** its own skip-link
  feature is explicitly **disabled** — the plugin's own runtime config, read verbatim from the
  live page (`out/plugin-effect/home__desktop.json`, `wpaConfigRaw`): `"skiplinks":
  {"enabled":false,"output":""}`. This means the working skip link described above is **100%
  theme code**, not a plugin contribution — confirmed two ways: the plugin's own settings say
  so, and the plugin's JS/CSS assets (`wpa-style.css?ver=2.3.5`,
  `wp-accessibility.min.js?ver=2.3.5` — both present and loading,
  `out/plugin-effect/home__desktop.json.wpaAssets`) inject **no** toolbar, no widget, and no
  DOM element with an id/class matching `wpa*`/`toolbar*` beyond its own `<link>`/`<style>`/
  `<script>` tags (`wpaDomSignals`, 4 entries, all just those asset tags themselves — no
  visible UI). Zero console warnings or errors were observed loading the home page with a
  listener attached from before navigation (`consoleMessages: []`, both viewports) — including
  none from the plugin's own missing-alt monitor, consistent with §3's image findings.
- **The "Video" section on the home page is not a defect — it is an explicitly-marked
  placeholder, and it is correctly exposed to assistive technology as one.** The section (H2
  "וידאו") wraps a `role="img"` element whose `aria-label` literally reads "כאן ייכנס וידאו
  16:9" ("a 16:9 video will go here"), containing a visible "ממתין לאישור" ("awaiting
  approval") badge and — separately — literal Lorem Ipsum body text above it (confirmed live,
  `tmp/home-full.html` fetch used for this specific check; this is a content-completeness
  matter for the content tracker referenced in project memory, not a WCAG failure: the
  placeholder has an accurate, non-misleading accessible name). This also **resolves** the
  axe-core `video-caption` "incomplete" flag on home (`out/axe/home__desktop.json`): the only
  actual `<video>` element on the page is a different, silent, decorative hero-background loop
  (`<video class="hero__media" muted loop playsinline preload="none" ...><source
  src=".../ea-home-hero-720-muted.mp4">` — confirmed in the raw HTML, filename literally says
  "muted"). WCAG 1.2.2 Captions applies to prerecorded video **with audio**; a silent
  decorative loop has none to caption. axe correctly could not rule this out from markup alone
  and flagged it `incomplete` rather than failing it outright — I am resolving that
  uncertainty here with the concrete evidence, rather than repeating it as an open finding.

---

## 4. COULD NOT MEASURE

- **Whether the two "indeterminate" contrast/gradient cases (A11Y-LIVE-06) actually pass or
  fail a real pixel reading.** Both my scanner and axe-core stop at "background is an image or
  gradient" by design (per the brief's own instruction for my scanner); neither decodes the
  actual image pixels behind the text. A real verdict would need either a manual colour-picker
  reading against the specific hero frames in production, or a canvas-based pixel sampler
  (out of scope for this pass — flagging as a concrete follow-up, not silently passing it).
- **Interactive elements wired only via `addEventListener` with no `tabindex`/`onclick`
  attribute and no ARIA role.** My "controls exposed as generic" check (§3) is DOM-attribute-first
  (`[onclick], [tabindex]`) specifically so it doesn't have to guess at AX roles for the entire
  page; it cannot see a click handler attached purely in JS with no attribute trace. Practically,
  such an element would likely also fail to be keyboard-focusable at all (a *worse*, more visible
  problem my keyboard walk would surface as a click-target with no tab stop) — but I cannot
  positively rule out the narrower "focusable-and-generic-but-not-attribute-visible" case with
  the check as built.
- **A full screen-reader session (VoiceOver/NVDA) end-to-end.** I measured the same
  Accessibility API layer a screen reader consumes (CDP `Accessibility.getFullAXTree`/
  `getPartialAXTree`), which is the correct empirical proxy for "what AT receives," but did not
  drive an actual screen reader's speech/braille output.
- **Contrast below the initial scroll position.** Per the brief's literal instruction ("every
  text node in the visible viewport"), my scan is intentionally scoped to what's on screen at
  load, without scrolling — which on this site's page structure means the sample is dominated
  by the sitewide nav + each page's own hero (both photo-backed), not by body copy further down
  (which is where the zero-numeric-failures body-text contrast would actually live). I did not
  extend the scan down the page; if team_100 wants full-page contrast coverage, that is a
  straightforward extension of the same instrument, not a new build.
- **wp-accessibility's other declared features' precise runtime effect** beyond what's visible
  in the DOM/config/console: the config blob (`out/plugin-effect/home__desktop.json`,
  `wpaConfigRaw`) also declares `"titles":"1"`, `"labels":"1"`, an `altSelector` scan target,
  and a "long description" (`ldType`/`ldText`) button feature. I confirmed none of these
  produced a visible DOM injection or console message on the home page at the moment I
  measured, but I did not reverse-engineer the plugin's minified JS to confirm what each flag
  does when its trigger condition is met elsewhere on the site.
- **Anything on the three book/product pages, or any page outside my mandate's exact 11-page
  list.** Out of scope for this line by design (see brief's page-set note "unless your scope
  says otherwise" — my mandate's scope is the narrower 11-page list); A11Y-STRUCT's report
  covers book pages from the source side.

---

## 5. Recommended fixes, ordered by user impact

1. **Remove the mobile nav's off-screen focusable content (A11Y-LIVE-01/02)** — highest
   impact, affects every phone/tablet visitor who uses a keyboard, on every page except `/en/`.
   In `assets/css/chapters.css`, inside the `@media(max-width:1180px)` block that starts at
   line 632, gate `.nav__l`'s focusability to its open state — e.g. toggle `inert` (or
   `visibility:hidden` plus `tabindex="-1"` on each link) on `.nav__l` whenever
   `#nav` lacks `[data-menu="1"]`, removing it exactly when the CSS already hides it visually.
   Separately, reorder the DOM (or add `tabindex` management) so the burger
   (`section-nav.php:78`) precedes `.nav__l` (`:21`) in tab order, or explicitly move focus
   into the panel's first link on open — either fixes LIVE-02 without touching LIVE-01's fix.
2. **Fix the 200%-zoom left-edge clipping (A11Y-LIVE-03)** — `nav#nav > div.nav__r` (the EN
   link and sound toggle) and the testimonial carousel's `.testi-mq__viewport` both need to
   remain within the viewport at 2x zoom; likely the same responsive breakpoints that
   already collapse the nav at narrow *viewport* widths need a `min-resolution`/zoom-aware
   equivalent, or the nav's fixed-width assumptions (`chapters.css` nav rules) need a fluid
   fallback. `.testi-mq__viewport` (`chapters.css:716`) needs its own overflow contained
   within `.testi-mq`'s parent at zoom, independent of the (correct, by-design) wide inner
   track.
3. **Give the two role-less `aria-label` divs a role (A11Y-LIVE-05)** — smallest, safest fix
   in this list: add `role="group"` to `template-parts/chapters/parts/contact.php:81` and
   `:102`.
4. **Get a definitive answer on the indeterminate contrast cases (A11Y-LIVE-06)** — not a
   code fix from this line's evidence, but worth resolving before the statement asserts
   conformance: either add a consistent scrim/overlay behind the nav and hero text strong
   enough to guarantee 4.5:1 against the darkest and lightest plausible frames of whatever
   photo/video is in play, or accept a manual/pixel-sampling verification pass.
5. **(Recommendation only, beyond binding standard) A11Y-LIVE-04** shares its fix with #1;
   no separate action needed once #1 lands.

---

## 6. Anything I believe the other lines will get wrong

- **My own two scripts initially "disagreed" with each other — the resolution matters for
  anyone reading both.** The main sweep's keyboard walk (`out/keyboard/*__mobile.json`) shows
  almost no off-screen stops and never reaches the burger, while `burger-toggle-check.mjs`
  shows 28 off-screen stops before the burger. Both are correct: the main walk auto-activates
  the skip link at stop 1 (by design, to verify it), which jumps focus straight into `<main>`
  — legitimately bypassing the broken nav entirely, exactly as a skip link should. The
  dedicated script deliberately does *not* touch the skip link, to measure the path a user
  takes if they don't (or don't know to) use it. **A line that reads only the main sweep's
  keyboard JSON would conclude the mobile nav has no keyboard problem — it would be looking at
  the post-skip-link path only.** Read `burger-toggle-check.json` for the pre-skip-link path.
- **A line trusting `header.php:24`/`:75` for the skip link or `<main>` markup is reading dead
  code**, confirmed independently by this line via live DOM inspection (not merely by tracing
  source, as A11Y-STRUCT also independently found) — see §3. The live class is `.ea-skiplink`
  (no hyphen); the live `<main>` carries `class="chapters-main"`, not `ea-shell-main`.
- **A line using a page-level-only RTL check on focus order will false-positive on the
  testimonial carousel.** My own visual-order heuristic (bounding-rect based, page `dir`
  only) initially flagged 12 "violations" on home and a similar count on `/treatment/` —
  every single one a consecutive pair of `.tmq` testimonial-card links. On inspection this is
  correct behaviour, not a bug: `chapters.css:716-717` deliberately sets
  `direction:ltr` on `.testi-mq__viewport`/`.testi-mq__track` (the CSS itself carries a
  comment: "RTL fix (Nimrod, live in an Eyal meeting, 2026-09-16)"), so left-to-right focus
  progression through that specific carousel is intentional and correct. I am disclosing this
  as a false-positive in my own heuristic rather than reporting it as a finding; a line without
  this context could easily report it as a real 2.4.3 issue.
- **A line reading the `role="img"` "Video" placeholder's raw HTML alone (without checking
  what it says) could plausibly mis-flag it as a missing-image/broken-content bug.** It's a
  correctly-labelled, intentional "coming soon" placeholder (see §3) — a content-tracker
  matter, not an accessibility defect.
- **Do not read "axe-core: 0 violations" (true, on all 22 runs) as "no problems."** Four of
  this report's six numbered findings (LIVE-01, 02, 03, 04) are entirely invisible to
  axe-core's rule set — they require real keyboard events and real zoom/viewport rendering,
  which is exactly why this line exists alongside the source-reading lines.

---

*Raw evidence for every claim above: `tmp/qa/a11y-2026-09-17/out/` (axe/, contrast/,
keyboard/, ax-tree/, zoom-reflow/, images/, plugin-effect/, screenshots/, manifest.json,
burger-toggle-check*.json). Harness source: `tmp/qa/a11y-2026-09-17/run.mjs` and
`burger-toggle-check.mjs`. Not legal advice.*
