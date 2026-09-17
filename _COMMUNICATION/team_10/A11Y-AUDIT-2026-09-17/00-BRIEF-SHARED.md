# Shared brief — S006 accessibility audit (IS 5568 / WCAG 2.0 AA)

Issuer: team_100 (Opus) · Auditors: team_10 lines (Sonnet) · Date: 2026-09-17
Consolidation + claim verification: team_100. Fixes: team_100. **Auditors do not fix anything.**

## Why this audit exists

The site ships a published accessibility statement that asserts conformance, while no
conformance audit has ever been signed. Owner (team_00 / Nimrod) has now opened the
round-3 accessibility gate and asked for several independent lines to examine different
facets, prove what fails, and each return a detailed report.

The pre-existing plan for this gate is
`_COMMUNICATION/team_100/S006/PLAN-S006-A11Y-DEPTH-NOW-AND-R3-2026-08-26.md` — read it.
Its round-3 "Definition of Done" (9 items) is the acceptance frame for this audit.

## The standard that binds — do not substitute another

- Israeli law: Equal Rights for Persons with Disabilities Law, 5758-1998, and the
  Accessibility Adjustments to Service Regulations, 5773-2013 (internet service under
  amendment 5778-2017).
- Binding technical standard: **IS 5568 level AA**, which is **WCAG 2.0 level AA**.
- WCAG 2.1 / 2.2 success criteria are useful testing tools but are **not** the Israeli
  legal obligation. If you cite a 2.1/2.2-only criterion, label it explicitly as
  "beyond the binding standard — recommendation only". Do not inflate the failure list
  with criteria the regulations do not impose.
- Regulation 35ה governs the statement itself: prominent, lists the adjustments actually
  made, names a coordinator and contact channels.
- Regulation 35ו exemptions turn on business classification and turnover. **We do not have
  Eyal's turnover figure.** Never assert or assume an exemption.
- This audit is **not legal advice** and must say so.

## Verified environment facts (measured by team_100 on 2026-09-17, cite these as given)

- Staging (our new site): `http://eyalamit-co-il-2026.s887.upress.link` — HTTP 200.
  TLS on staging is invalid **by design**; a cert warning there is not a defect.
- Production `https://www.eyalamit.co.il/` — HTTP 200, but it is still the OLD site.
  `https://www.eyalamit.co.il/accessibility/` — HTTP **404**. The new site is not live.
  **Audit staging. Do not audit production and report its faults as ours.**
- Active theme: child theme `ea-eyalamit` on GeneratePress, Version **1.5.37**
  (`site/wp-content/themes/ea-eyalamit/style.css:11`).
- Plugin **wp-accessibility** (Joe Dolson) is active — its asset path appears in the live
  home page HTML. It is a helper, not a conformance layer.
- The statement page content lives at
  `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/accessibility-defaults.php`
  (70 lines) and carries a "draft, not yet approved" banner (WP-EI-05).
- The earlier A11Y-NOW fixes (single working skip link to `#main`, EN skip label, content
  `alt` on home) are merged and live in the current tree — verify, don't assume.

## Page set (use this set unless your scope says otherwise)

`/` · `/contact/` · `/treatment/` · `/accessibility/` · `/faq/` · `/shop/` ·
`/blog/` + one blog post · `/en/` · `/qr/` + one child QR page · one book/product page.

## Rules of evidence — these are not optional

1. **§3א-2 — every claim asserting a fact about code cites `file:line`.** A claim without
   a citation is deleted from your report before it reaches the owner.
2. **Positive assertion (charter §5.1).** A check that cannot run reports
   "COULD NOT MEASURE" with the reason. Never report PASS because something was absent,
   silent, or errored. Absence of an error is not evidence of correctness.
3. Separate **measured** from **inferred**. Label every finding one or the other.
4. Severity must be tied to a named WCAG 2.0 success criterion (number + name), or be
   labelled "not a 2.0 AA failure — recommendation".
5. If you disagree with a premise in this brief, say so in your report with evidence.
   Do not silently work around it.

## Known measurement traps on this project — read before you measure

These have each produced a confident wrong answer here before:

- `curl` sees HTML only, never the rendered box model or JS-built markup. Never judge
  layout, contrast, or focus from curl.
- A browser pane with a `0x0` viewport returns real-looking numbers that are wrong
  (one measurement returned 66.3px where the truth was 201.5px). Assert the viewport is
  non-zero before trusting any measurement.
- Lazy-loaded images report `naturalWidth = 0`; arithmetic on them yields `NaN`, and
  `Math.abs(NaN) > threshold` is `false` — the comparison silently passes. Refuse to judge
  an image that has not decoded.
- Single-line `grep` misses attributes on multi-line tags. Use multi-line aware search.
- Batch browser calls can 503 mid-run and return partial results that look complete.

`node` v24 and Google Chrome are installed. The repo's own probe is
`_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs`. You may write your own
harness under the scratch path your mandate names.

## Hard prohibitions

- **Read-only on the product.** Do not edit any file under `site/`. Do not deploy. Do not
  touch FTP. Do not enter wp-admin and change settings.
- Do not rewrite `accessibility-defaults.php`, privacy, or terms. Do not remove the
  WP-EI-05 draft banner.
- Do not install, enable, or recommend enabling any plugin as an action — a recommendation
  goes in the report, the decision is the owner's.
- Do not run `git add -A` or `git add .` (charter §5.4).
- Write only inside `_COMMUNICATION/team_10/A11Y-AUDIT-2026-09-17/`.

## Report format

One markdown file at the path your mandate names. **English.** Structure:

1. Scope and what you actually ran (commands, URLs, timestamps).
2. Findings table: ID · severity · WCAG 2.0 SC · measured/inferred · evidence
   (`file:line` or a reproducible browser measurement) · what a user experiences.
3. What you checked and found **correct** — equally important, with evidence.
4. COULD NOT MEASURE list, with the reason for each.
5. Your recommended fixes, ordered by user impact, each naming the file to change.
6. Anything you believe the other lines will get wrong.

Findings are numbered `A11Y-<YOURPREFIX>-NN`.
