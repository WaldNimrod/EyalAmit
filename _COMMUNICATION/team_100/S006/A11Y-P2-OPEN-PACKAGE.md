# S006 · Accessibility P2 — open work package

Status: **OPEN, not scheduled.** Owner decision D-I (team_00, 2026-09-18): P0 and P1 are
taken in this milestone; P2 is written up so it can be picked up cold later rather than
quietly dropped. Nothing here is started.

Written by team_100, 2026-09-18. Not legal advice.

## How to read this file

Every item carries the three things the owner asked for:

- **Source** — where the finding came from, so you can read the original evidence.
- **Standard** — the exact success criterion, by number and title, **and whether it is
  actually binding.** The binding standard here is **IS 5568 level AA = WCAG 2.0 level AA**
  (<https://www.w3.org/TR/WCAG20/>). Several items below are **not** WCAG 2.0 AA failures.
  They are recommendations. Do not spend P0 effort on them and do not report them as
  compliance gaps.
- **Already done** — what has been fixed nearby, so nobody re-audits covered ground.

**Line numbers drift.** `section-nav.php` moved by 9 lines when the burger was relocated on
2026-09-18. Re-verify every citation before acting on it.

**⚠ An automated scan cannot close any of these.** Charter §8א clause 5: a clean scan is not
a PASS. axe-core returns 0 violations on pages in this project that carry confirmed failures.

## Source reports (all under `_COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/`)

`01-STRUCTURE-SEMANTICS-AUDIT.md` · `02-VISUAL-CONTRAST-FOCUS-AUDIT.md` ·
`03-INTERACTIVE-FORMS-MEDIA-AUDIT.md` · `04-LIVE-BROWSER-VERIFICATION.md` ·
`05-LEGAL-STATEMENT-PLUGIN-DOCS-AUDIT.md`

Consolidated and verified: `_COMMUNICATION/team_100/S006/A11Y-CONSOLIDATED-REGISTER-2026-09-17.md`
team_100's own re-measurements: `tmp/qa/a11y-verify/team100-verification-log.md`

---

## Group A — real WCAG 2.0 AA failures, low user impact

### P2-A1 · A menu item that goes nowhere
`<a href="#">קורסים</a>` sits in the primary menu on every page that renders the nav.
Activating it does nothing. The code comment says it is a placeholder awaiting a course URL
from Eyal.
- **Where:** `template-parts/chapters/section-nav.php:46` (was `:37` before the nav fix).
- **Standard:** SC 2.4.4 Link Purpose (In Context), Level A. **Binding.**
- **Source:** A11Y-STRUCT-04.
- **Already done:** nothing. **Blocked on content, not code** — it needs either the real URL
  from Eyal or a decision to remove the item. Route it as a question, not a build task.

### P2-A2 · Hebrew text inside the English page, unmarked
`/en/` is `<html lang="en">`, and four Hebrew runs sit inside it with no element-level
`lang="he"`. A screen reader with an English voice will try to pronounce them as English.
- **Where:** `page-templates/tpl-chapters-en.php:43` (the «עברית →» language switch), `:48`
  (the WP-EI-06 draft banner), `:112` (the footer link), plus the WhatsApp button label.
- **Standard:** SC 3.1.2 Language of Parts, Level AA. **Binding.**
- **Source:** A11Y-STRUCT-07. **The auditor reported 2 runs; team_100 measured 4.** Use 4.
- **Already done:** the EN skip link was translated in the August A11Y-NOW wave
  (`DONE-S006-A11Y-NOW-TEAM10-2026-08-26.md`). The `lang`/`dir` attributes on the page
  itself are correct. Only the embedded runs are unmarked.

### P2-A3 · Decorative step icons announced as content
Three SVG step icons render with no `aria-hidden`, on `/`, `/treatment/`, `/method/` and
anywhere else section 07 appears. A screen reader announces an unlabelled graphic per step.
- **Where:** `template-parts/chapters/section-07-how-to-start.php:17` (the `$icons` array)
  and `:36` (the `.st3__ic` wrapper).
- **Standard:** SC 1.1.1 Non-text Content, Level A. **Binding.**
- **Source:** A11Y-STRUCT-05.
- **Already done:** this is the *only* inconsistency against an otherwise correct sitewide
  convention — the nav caret, burger, sound toggle, footer social glyphs, FAQ chevron and
  testimonial glyphs are all already `aria-hidden`. Copy that pattern; do not invent one.

### P2-A4 · A three-step sequence that is not a list
The "how to start" steps are three sibling `<div class="st3">`, so a screen reader is never
told "list of 3 items" or "item 2 of 3". The order and count exist only visually.
- **Where:** `template-parts/chapters/section-07-how-to-start.php:33` and the `.st3` divs.
- **Standard:** SC 1.3.1 Info and Relationships, Level A. **Binding.**
- **Source:** A11Y-STRUCT-06.
- **Already done:** `section-nav.php` deliberately re-asserts `role="list"` on every `<ul>`
  to survive the WebKit/VoiceOver `list-style:none` bug. The team already knows this
  pattern — that is what makes this instance an oversight rather than a choice.

### P2-A5 · Contrast near-misses
Four separate small failures, all computed to full precision, none catastrophic:
- `.foot__brand p` — **4.4960:1**. A genuine near-miss, not a rounding artefact.
- `.btile--clay` tile text — **4.26:1** at one end of its own gradient (passes at the other).
  Its `.btile__tag` at 9px computes 3.20:1 and 4.47:1 across the gradient — fails at both.
- `.ea-mnav-link__ext` — **4.11:1** (`assets/css/ea-mobile-nav.css:167`). **Check first
  whether this renders at all** — `ea-mobile-nav.css` belongs to the dead Wave2 system.
- **Standard:** SC 1.4.3 Contrast (Minimum), Level AA. **Binding.**
- **Source:** A11Y-VISUAL-05, -06, -07.
- **Already done:** the footer disclaimer token was fixed in the A11Y-CLOSE W1 wave and now
  computes **7.74:1**, live-confirmed. The two P1 token failures (`--eyal-muted` undefined,
  `--muted` at 4.26/3.56) are scheduled in WS-3B — **do that first**, since
  A11Y-VISUAL-13 identifies one shared root cause behind several of these: three unrelated
  "muted" colours and two "ink" values across duplicate token systems. Fixing the tokens may
  close some of P2-A5 for free. Re-measure before doing anything here.

### P2-A6 · Focus outlines that may be clipped
`.bookcard` relies on the browser's default focus ring on an element that sets
`overflow:hidden`; `.rcard` (`chapters.css:508`) draws an explicit outline with a positive
`outline-offset` (`chapters.css:520`) on a box that also clips its own overflow — documented
Chromium/Firefox behaviour clips it.
- **Standard:** SC 2.4.7 Focus Visible, Level AA. **Binding.**
- **Source:** A11Y-VISUAL-08, -09. **-09 is inferred, not measured** — no page in the
  auditor's sample rendered `.rcard`. **Verify it renders anywhere before fixing it.**
- **Already done:** the sitewide focus-contrast collision was fixed on 2026-09-18
  (`A11Y-FIX-2026-09-18/01-DONE-FOCUS-CONTRAST.md`) — that was about *colour*, not clipping.
  Different defect, same criterion.

---

## Group B — NOT WCAG 2.0 AA failures. Recommendations only.

Do not report these as compliance gaps and do not put them in the accessibility statement.

### P2-B1 · Inconsistent new-window warnings — **SC 3.2.5 is Level AAA**
Some `target="_blank"` links warn the user via `aria-label`; others open a second tab
silently. Security hygiene (`rel="noopener noreferrer"`) is correct throughout.
- **Standard:** SC 3.2.5 Change on Request, **Level AAA — beyond IS 5568 AA. Not binding.**
- **Source:** A11Y-STRUCT-08, which lists both the warning and non-warning sites.
- **Why it is still worth doing one day:** consistency. Half-warning is worse than either.

### P2-B2 · `/shop/` has an internal-sounding page title
Live title: «עמוד קטלוג ראשי - eyal amit» — an admin label rather than a visitor-facing one.
- **Standard:** SC 2.4.2 Page Titled, Level A. It technically *passes*: the title does
  identify the topic. **Not a failure; a quality issue.**
- **Source:** A11Y-STRUCT-09. **The value's source was not found in theme code** — it is
  probably a DB/Yoast value, so this may be a content-admin edit, not a code change.

### P2-B3 · `/en/` has no navigation
The English page offers only a link back to the Hebrew home page and a WhatsApp CTA.
- **Standard:** touches SC 2.4.5 Multiple Ways (AA), but that criterion concerns locating a
  page within a *set*, and `/en/` is deliberately one self-contained page. **Not a failure.**
- **Source:** A11Y-STRUCT-10. Very likely intentional — the file's own docblock calls it a
  self-contained placeholder landing page. **Wanted: an explicit sign-off that it is
  intended**, not a fix.

### P2-B4 · Two orphaned stylesheets
Dead CSS loading on every page request without styling anything.
- **Standard:** none. Hygiene.
- **Source:** A11Y-VISUAL-14.
- **Already done / related:** this is the same Wave2-vs-Chapters dual-template debt found
  independently by the RTL audit (`RTL-AUDIT-2026-09-17/`), the structure line and the
  interactive line. **There is an open owner decision on the dead-code pile as a whole**
  (RTL audit summary, decision 2: delete it, or keep it documented as a safety net).
  **Do not delete these two stylesheets in isolation — fold them into that decision.**

---

## Latent — confirmed in code, verified NOT reachable by a visitor today

These are real defects in code that no live page currently renders. They become P0 the day
the template is used. **Do not "fix" them blind; first re-verify whether they went live.**

- **The book-cover lightbox is completely keyboard-inoperable** — a `display:none` checkbox
  with bare `<label>` controls, in `page-templates/template-book-detail.php`. None of the
  three real book pages use that template today. Source: A11Y-INTERACT-06.
- A captionless self-hosted video block, and a stale hardcoded `aria-expanded` in a mini-FAQ
  block — neither found placed on any live page. Source: A11Y-INTERACT-07, -11.

---

## Explicitly NOT in this package

- **The 30 identical alt strings** on the home `#peek` gallery — assigned to M-10, step 5.
- **The 162 empty-alt book photographs** — M-10, the main task.
- Everything in WS-3B (the P1 clusters) — scheduled in this milestone.
- The accessibility statement rewrite — WS-4, and it depends on all of the above landing first.
