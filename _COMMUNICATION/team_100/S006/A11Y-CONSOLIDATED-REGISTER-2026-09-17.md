# S006 · Consolidated accessibility register · IS 5568 AA (= WCAG 2.0 AA)

Issued by: team_100 · Date: 2026-09-17 · Not legal advice.
Auditors: five independent team_10 lines (Sonnet), each on a different facet, none seeing
the others' findings. Consolidation and claim verification: team_100 (Opus). Iron Rule #1
holds: the lines that measured are not the engine that validated.

Source reports: `_COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/`
team_100 verification log: `tmp/qa/a11y-verify/team100-verification-log.md`

- 01 STRUCTURE — 10 findings
- 02 VISUAL — 14 findings
- 03 INTERACTIVE — 11 findings
- 04 LIVE — 6 findings
- 05 LEGAL — 21 findings
- **Total: 62.**

team_100 re-measured 14 load-bearing claims independently. All 14 confirmed. Three
corrections were produced in the process, listed in §2.

---

## 1. The result that governs how every other result must be read

**axe-core returns a clean bill of health on pages carrying this audit's most serious
failure. Proven, not argued.**

The LIVE line ran axe-core 4.11.4 across 11 pages x 2 viewports and found **0 violations**
in all 22 runs. I read the 22 raw result files myself: the run is real and honest.

The page set I authored did not include `/books/vekatavta/`, `/books/kushi-blantis/`,
`/books/tsva-bekahol/` — where the STRUCTURE line found 162 content photographs rendered
with `alt=""`. I ran axe-core myself against those three pages:

    /books/vekatavta/      axe violations = 0    (97 images, 95 with alt="")
    /books/kushi-blantis/  axe violations = 0    (23 images, 22 with alt="")
    /books/tsva-bekahol/   axe violations = 0    (46 images, 45 with alt="")

`alt=""` is the correct, standard way to mark an image decorative. No automated tool can
know these 162 photographs are content. **The rule passes by design.**

Two independent scope errors compounded here — the tool cannot see the defect, and the page
set excluded the affected pages. Either alone produces a false clean.

**Operative consequences.**
1. "We ran an automated scan and it was clean" is not evidence of conformance on this site
   and must never support a claim in the published statement.
2. Any future conformance sign-off requires human review of images per page, not a scan.
3. This is the project's documented failure mode — harnesses that fail OPEN — recurring,
   this time inside the industry-standard tool rather than our own code.

---

## 2. team_100 corrections to the audit

**2.1 A cross-line contradiction, resolved.**
The LEGAL line marked the statement's alt-text claim TRUE; the STRUCTURE line found 162
photos with no alt. Both measurements are correct. The LEGAL line sampled `/`,
`/accessibility/`, `/contact/` — where coverage genuinely is good (I confirmed: 41 of 42
home images carry real alt). Its verdict is scoped too narrowly to support the sitewide,
unqualified claim the statement actually makes.
**Binding verdict: the statement's alt-text claim is FALSE as written.**

**2.2 A citation error (charter §3א-2).**
A11Y-LEGAL-14 cites `header.php:24` as the source of the live skip link. Measured: the live
link is emitted by `site/wp-content/themes/ea-eyalamit/inc/wave2-stage-b.php:422`;
`header.php:24` emits a different anchor that does not appear in the live HTML. The LIVE
line reached the same conclusion independently. A fix applied to `header.php` would change
nothing. Corrected.

**2.3 An undercount.**
A11Y-STRUCT-07 reports 2 unmarked Hebrew runs inside the `lang="en"` page. Measured: **4** —
the header language switch and the WhatsApp button label are also unmarked.

**2.4 team_100's own incomplete statement, corrected.**
I reported mid-audit that the skip link is "genuinely correct", on my own measurement across
8 templates (one link, target `#main`, resolving to a real `<main tabindex="-1">`). That
measurement stands. It was incomplete: the VISUAL line found, and I confirmed to the
decimal, that the link's contrast collapses to **2.48:1** at the moment it receives focus.
The link is functionally correct and visually deficient. The second fact changes the
conformance conclusion and is carried forward.

---

## 3. Confirmed defects, ordered by user impact

### P0 — blocks a core path for a real user

**P0-1 · Skip link is nearly invisible exactly when it is used.** `A11Y-VISUAL-01`.
Measured live (viewport asserted 1440x900): unfocused white on brand orange = 5.67:1;
**on focus the colour becomes rgb(46,43,40) on rgb(164,78,43) = 2.48:1**, against a 4.5:1
floor. Cause, verified in the live cascade: GeneratePress's generated inline rule
`a:hover,a:focus,a:active{color:var(--contrast)}` (specificity 0,1,1) beats the child
theme's single-class colour rule (0,1,0), which never re-asserts colour on focus. This is
not visible by reading our source files — only live cascade inspection finds it.
SC 1.4.3, 2.4.7.

**P0-2 · The same mechanism hits the sitewide nav language toggle.** `A11Y-VISUAL-02`.
Measured ~1.1–1.4:1 on the dark nav — effectively invisible on keyboard focus. SC 1.4.3, 2.4.7.

**P0-3 · The mobile menu cannot be reached by keyboard after opening it.**
`A11Y-INTERACT-01/02`, `A11Y-LIVE-01/02`. Two lines found this independently, by two
different activation methods (mouse click and a real `Enter` key press). I confirmed the
cause in the DOM: inside `#nav`, the menu `<ul>` begins ~3.7KB **before** the burger button
(`section-nav.php:21` vs `:78`). Tabbing forward from the burger therefore walks past the
menu into background content. At mobile width the LIVE line measured 32 tab stops, 28 of
them geometrically off-screen. SC 2.1.1, 2.4.3.

**P0-4 · 162 content photographs are silent to assistive technology.** `A11Y-STRUCT-01`.
Measured by two parties: `/books/vekatavta/` 95 of 96, `/books/kushi-blantis/` 22 of 23,
`/books/tsva-bekahol/` 45 of 46 images carry `alt=""` with no caption and no `aria-hidden`.
Cause: `gallery.php:54` routes alt through `ea_chapters_content_img_alt()`
(`chapters-render.php:753-783`), whose hardcoded filename map has no entries for these
images and returns `''`. The three galleries supply no `alt` and no `cap` keys.
Whole gallery sections are empty for a screen-reader user. SC 1.1.1.

**P0-5 · The published statement asserts an adjustment we have not made.** `A11Y-LEGAL-01`,
with §2.1. This is the project's largest exposure and it is not a code defect. Regulation
35ה requires the statement to describe the adjustments **actually** made.

### P1 — real, narrower

**P1-1 · The D-8 subject dropdown silently pre-selects the first option.**
`A11Y-INTERACT-05`. Measured live: 7 options, none `selected`, none with an empty value, so
the browser selects option 0. Every visitor who does not touch the field sends an email
titled "טיפול בדיג'רידו — פניה מטופס צור קשר באתר" regardless of their actual subject.
Source: `site/wp-content/mu-plugins/ea-w2-15-cf7-contact-form-once.php:61`.
**This is team_100's own implementation of Nimrod's locked decision D-8.** It is a
content-correctness defect as much as an accessibility one: Eyal's mail is mislabelled.
The fix stays inside D-8 — field stays, dropdown stays, a blank prompt option is added.

**P1-2 · Two submenu toggles never report their state.** `A11Y-INTERACT-03`. Measured: zero
occurrences of `nav__dd` anywhere in the theme's JS. The buttons at `section-nav.php:33,64`
keep `aria-expanded="false"` permanently. The correct handler exists at `ea-hero.js:51-64`
but binds `.ea-topnav__dropdown-toggle`, a dead Wave2 selector. The live burger itself IS
handled correctly (`ea-chapters.js:42-55`). SC 4.1.2.

**P1-3 · An undefined colour token renders the exact colour it was created to replace.**
`A11Y-VISUAL-03`. `--eyal-muted` is used at `books-v2.css:462,839,879,887` and defined
nowhere; every use falls back to `#a8a19b`, computed 1.70–2.41:1. SC 1.4.3.

**P1-4 · `chapters.css`'s own `--muted` fails against both its standard backgrounds.**
`A11Y-VISUAL-04`. 4.26:1 and 3.56:1, used for captions, blog meta and a disclaimer. SC 1.4.3.

**P1-5 · Form validation errors appear in untranslated English inside a `lang="he-IL"` form.**
`A11Y-INTERACT-04`, confirmed live after a safe empty submit. SC 3.1.2, 3.3.1.

**P1-6 · At 200% zoom, real nav controls are clipped off the left edge.** `A11Y-LIVE-03`.
RTL-specific; the line found it only after fixing a right-edge-only bug in its own
instrument. SC 1.4.4.

**P1-7 · Hub pages are invisible to heading navigation.** `A11Y-STRUCT-02`. Measured:
`/shop/` and `/qr/` each contain exactly one heading on the whole page. Card titles render
as `<span class="bookcard__t">` (`bookcard.php:57`). SC 1.3.1.

**P1-8 · The same FAQ component emits headings on one page and not another.**
`A11Y-STRUCT-03`. Measured: `/faq/` 150 headings including H3 per question; `/treatment/`
12 headings, levels 1 and 2 only. Two branches of `block-faq-list.php` (`:100` vs `:45`).
SC 1.3.1.

### P2 — correct, low impact

`A11Y-STRUCT-04` dead `<a href="#">קורסים</a>` in the sitewide menu (`section-nav.php:37`).
`A11Y-STRUCT-07` 4 unmarked Hebrew runs in the `lang="en"` page (corrected count).
`A11Y-STRUCT-05` decorative step icons not hidden. `A11Y-STRUCT-06` a 3-step sequence not a
list. `A11Y-LEGAL-10` caveat: 30 of 41 home-page images share one identical alt string —
technically compliant, functionally weak. `A11Y-VISUAL-05..11` further contrast and
focus-clipping items. `A11Y-VISUAL-13` three unrelated "muted" colours across duplicate
token systems — the systemic root cause beneath several contrast findings.

---

## 4. Verified as genuinely correct — do not spend attention here

Recorded because a conformance claim needs evidence of what passes, not only what fails.

- Skip link mechanics: exactly one per page on 8 templates measured, target `#main`,
  resolving to a real `<main id="main" tabindex="-1">`. The August fix holds. (Its focus
  contrast is P0-1; the mechanism itself is sound.)
- Heading trees: one H1 per page, no skipped levels, on all 13 pages fetched.
- Zero duplicate IDs, zero layout tables, correctly labelled duplicate landmarks.
- Footer contrast after the W1 token fix: `.foot__disc` 7.74:1, `.foot__col-title` ~7.06:1.
- CF7 live-region architecture: `role="status" aria-live="polite"`, correctly clipped
  rather than `display:none`. Exactly one form on `/contact/` — the historical duplicate is
  genuinely gone.
- FAQ accordion uses native `<details>`, 133 live instances.
- The testimonial carousel's pause and `prefers-reduced-motion` handling.
- The statement correctly contains **no** exemption or turnover claim.
- The statement is linked from the footer on every page sampled.

---

## 5. Decisions that belong to team_00, with the evidence to make them

**D-A · The overlay plugin question.** `A11Y-LEGAL-16`.
Facts established: wp-accessibility (Joe Dolson) is active, but its own skip-link feature is
**off** (`window.wpa.skiplinks.enabled:false`) — the working skip link is 100% our code. In
practice the plugin currently ships one stylesheet and one script and injects no visible UI.
Separately, an overlay-category widget is **already running on Eyal's current production
site**. Evidence against adopting an overlay as a conformance measure: the Overlay Fact
Sheet (1,000+ signatories, including W3C ARIA working-group members), W3C WAI discussion,
and the FTC's 2025 USD 1M settlement against Israeli overlay vendor accessiBe.
**team_100 recommendation: do not install an overlay as a compliance measure.** It does not
produce conformance and carries its own risk. Fix the delivered page instead.

**D-B · The statement's wording.** Current text asserts conformance as flat fact. Options:
(a) fix the underlying defects first, then keep a factual description of what was done;
(b) change "עומדים" to "פועלים לפי" and disclose that no independent audit was performed.
**Recommendation: both — (a) for P0, (b) as the standing honest frame.**

**D-C · Coordinator.** `A11Y-LEGAL-02`. Currently a phone number under a generic title, no
named person. Regulation 35ה wants a contact. Needs Eyal's approval of his own name.

**D-D · Captions policy.** `A11Y-LEGAL-07`. No media-alternative sentence anywhere. Whether
35ד's captioning duty reaches this business turns on classification and turnover we do not
have. A policy sentence is needed regardless of whether the duty binds.

**D-E · The draft banner.** `A11Y-LEGAL-03` calls WP-EI-05 a blocker on the statement's
validity. It is also honest. Decision is whether it survives launch.

---

## 6. One risk found that has nothing to do with accessibility

`A11Y-LEGAL-18`, confirmed by team_100. **`main` is 57 commits behind, carrying theme
version 1.5.15 against 1.5.37 in the working branch**; `origin/main` is 58 behind, last
commit 2026-08-23. Nearly a month of delivered work — including every August accessibility
fix — exists only on `s006/tracker-integrity`. Any deploy from `main` silently reverts the
site. This is a live, present-tense deployment hazard and is independent of this audit.

---

## 7. Round-3 Definition of Done — what still has no evidence

From `PLAN-S006-A11Y-DEPTH-NOW-AND-R3-2026-08-26.md` §"שער סבב 3". Confirmed absent from
the repo (`A11Y-LEGAL-21`): the WCAG 2.0 AA matrix over the named page set; a screen-reader
session log (VoiceOver or NVDA); mobile contrast evidence; and team_50's signed report.
This audit supplies raw material for the first and third. It does not replace items 3 or 8 —
**team_100 does not sign AA, and this register is not that signature.**
