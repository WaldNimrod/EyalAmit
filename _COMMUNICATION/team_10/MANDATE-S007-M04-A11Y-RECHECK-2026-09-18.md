---
id: MANDATE_S007_M04_A11Y_RECHECK_2026-09-18
schema_version: aos_v1_team_messaging
type: MANDATE (team_100 → team_10)
from: team_100
to: team_10
cc: [team_00, team_50]
date: 2026-09-18
law: _COMMUNICATION/team_100/S006/S006-MILESTONE-CHARTER.md
state: _COMMUNICATION/team_100/S006/HANDOFF-CURRENT-S006.md
status: DISPATCHED
theme_under_test: 1.5.48
---

> ⚠ **HISTORICAL — not the current state.** Typography and CSS sizing are governed by
> `_COMMUNICATION/team_100/S007-TYPOGRAPHY-CANON.md`, locked at theme 1.5.56. Numbers in
> this file were true when it was written. **Do not act on a font-size figure from here**
> without checking the canon first — §7 there lists the specific figures that are dead.
> Kept because the measurements and the method are still useful; the conclusions are not.

# M-04 · Accessibility re-check against the locked type scale

## Why this exists now and not before

team_00's plan puts typography **before** the accessibility re-check, for a reason that has
just become concrete: **WCAG's contrast threshold is a function of text size.** Large text
(≥24px, or ≥18.66px at weight ≥700) needs **3:1**. Everything else needs **4.5:1**.

The scale locked today moved sizes. Anything that used to clear the bar at 3:1 **because it
was large**, and is now below 24px, is held to 4.5:1 instead — and may now fail a criterion
it passed yesterday without a single colour changing.

From the mapping, exactly two selectors crossed that boundary:

- `.cmpc__t` — was 26px, now 21.25px at weight 500. Was large. Is not.
- `.bookcard__t` — was 24px, now 21.25px at weight 300. Was large (exactly at the line). Is not.

And one is now fragile rather than crossed:

- `.h2` — was 41.6px, now **24.65px**. Still large, by 0.65px. Any future downward nudge to
  `--fs-h2` silently changes its requirement from 3:1 to 4.5:1 across every section title on
  the site. Say so in the report; it is a standing hazard, not a finding.

Verify those three claims yourself before building on them.

## The measurement problem — read this before writing any harness

I ran a quick pass myself and it produced **twelve failures, most of which are certainly
false**. It reported `ratio 1.003` — white on white — for the nav, the inner-page H1, the
hero sub, and the buttons. Those elements are white text over a **video**, over a
**linear-gradient scrim**, and over **background images**.

The cause: the harness walked up the DOM looking for a non-transparent
`backgroundColor`. That property is `transparent` for a gradient, for a background image,
and for a video element. So the walker sailed past the actual backdrop and landed on the
page's near-white body.

**Do not resolve the backdrop from the DOM.** Determine it from the rendered pixels:
screenshot the viewport and sample the actual pixels immediately behind each text run,
taking the darkest and lightest sampled values so text over a gradient is judged against the
worst case it actually sits on. Text over video must be sampled with the poster or a
decoded frame in place, not on a blank element.

State in the report which method you used and show one worked example end to end — the
element, the sampled backdrop pixels, the computed ratio, the threshold it was held to, and
why that threshold.

**This project's standing rule applies with full force here: a harness that cannot see the
backdrop reports success. Charter §8א clause 5.**

## Scope

1. **Contrast, size-aware.** Every rendered text element on the twelve pages listed below.
   For each: rendered px, computed weight, whether it qualifies as large text, the threshold
   that therefore applies, the measured ratio, and pass/fail against *that* threshold. Report
   anything that fails, and separately anything that passes 4.5:1 by less than 0.3 — those
   are one design tweak away from failing.

2. **Text resize to 200%.** Double the root font size — this is text resize, **not** `zoom:2`,
   which scales layout as well and answers a different question. For each page: does any
   content get clipped, and does the document scroll horizontally. Two cautions:
   - `scrollHeight > clientHeight` on an element is **not** clipping when that element's
     overflow is visible; a tight line-height produces it routinely. Real clipping requires
     an **ancestor that actually clips**. I hit this exact false positive on nine `.h2`
     elements today.
   - The home hero was a genuine failure of this kind and was fixed in 1.5.47. Confirm it
     stays fixed, and check whether any other section carries a fixed height with
     `overflow:hidden`.

3. **Heading structure, re-confirmed.** One `h1` per page, no skipped levels. An `h3` tier
   now exists in CSS; confirm nothing renders a heading that skips from `h1` to `h3`.

4. **Every factual claim in the published statement** at `/accessibility/`, re-measured
   against 1.5.48. This statement has already had to be corrected three times — twice for
   claiming adjustments that had not been made, once for naming a limitation that no longer
   existed. Treat each sentence as a claim to be falsified, not read.

## Pages

```
/                          /treatment/                /method/
/lessons/                  /sound-healing/            /faq/
/books/                    /books/vekatavta/          /eyal-amit/
/eyal-amit/mokesh-dahiman/ /contact/                  /accessibility/
```

## Hard limits

- **Measure and report. Change nothing.** No CSS, no PHP, no deploy, no theme commit. The
  only files you create are the report and its CSV.
- Do not propose colour changes. Brand colour is team_00's, and the last contrast fix was
  solved by reusing an existing token rather than inventing a shade — that option is usually
  there and it is not yours to pick.
- Do not touch `_aos/`. No `git add -A` / `git add .` (charter §5.4).

## Output

```
_COMMUNICATION/team_10/S007-M04/A11Y-RECHECK-2026-09-18.md
_COMMUNICATION/team_10/S007-M04/contrast-measurements.csv
```

CSV columns:

```
page,selector,sample_text,px,weight,is_large_text,threshold,fg,bg_sampled,ratio,verdict,method
```

## Positive assertion

Every number carries the page URL and selector it came from. A zero is only reportable with
the command or code that produced it. **Nothing from this mandate goes in the report as a
measurement — including the two crossed selectors and the three previous statement
corrections. Re-derive them or contradict them.**

## Reporting

Message team_100 (`eyalamit-co-il-2026-76`) with the artifact path, the count of genuine
failures, and the count of false positives your first harness produced before you fixed it.
That second number is worth as much as the first here.
