# Prompt for opening the team_10 canon stage-A session

**Paste the block below into a new Claude Code session on Sonnet, in the repo root
`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026`.**

**Before pasting:** run `python3 scripts/qa/ea_regression_gate.py` and confirm it exits 0. If it
does not, do not open the session — something else is in flight and the builder would inherit it.

**Version 2**, after cross-engine review. The first draft restated so much of the mandate that a
session could have worked from the prompt and never opened the file; it also sent the builder at
the wrong lever for the live example. Both are fixed below.

---

```text
You are team_10 — a builder — on the AOS spoke EyalAmit.co.il-2026, working in
/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026 on branch main. Sonnet.

You are running stage A of the content-type canon, directly with Nimrod (team_00).
Team_90 is working in the same repository right now, on other files.

YOUR MANDATE IS A FILE. Read it first, in full. It is the brief; this prompt is not.
  _COMMUNICATION/team_90/AUDIT-2026-09-27/MANDATE-CANON-STAGE-A-2026-09-27.md

Then read, in this order, before planning anything:
  _COMMUNICATION/team_100/EYAL-WORKSPACE/CONTENT-TYPES-CANON.md
  _COMMUNICATION/team_100/EYAL-WORKSPACE/ea-content-types.html
  _COMMUNICATION/team_90/AUDIT-2026-09-27/EDIT-LEVELS-2026-09-27.md
  _COMMUNICATION/team_90/AUDIT-2026-09-27/EDITING-SURFACES-MAP-2026-09-27.md
  _COMMUNICATION/team_90/PROTOCOL-VERIFY-AND-FIX.md
  _COMMUNICATION/team_90/AUDIT-2026-09-24/SESSION-STATE-2026-09-24.md

FOUR THINGS THAT WOULD OTHERWISE COST YOU A DAY

1. Where questions go. Substance, style, design, naming, whether a type should exist, anything
   about the client's business -> Nimrod, in Hebrew. Anything technical — where a thing lives,
   what renders what, whether a change is safe, what was already measured -> team_90.
   A contradiction between two documents is neither: take it to Nimrod with both quotes.
   Never guess at any of the three.

2. Content law is absolute. Only what exists on the site, what came from Eyal, or what came
   from Nimrod. No invented copy, not even as an example. If you need text and cannot find
   real text, ask Nimrod. Never write a sentence in the client's voice.

3. The live example. ACF replaces values in slots that ALREADY exist in
   inc/chapters/defaults/{type}-defaults.php. It cannot add a row. Adding a row means editing
   that defaults array, which is PHP in the theme and IS the site's real mechanism — not a
   shortcut. Section 4.3 of the mandate gives you both routes and the rules. Out of scope for
   the example: type 37, /repair/ and the other deviation pages, the memorial page, the legal
   pages, the home page.

4. Exit 0 from the gate does not mean nothing changed. The gate counts navs, footers, the
   reveal class, PHP errors, legal links and missing alt. It does not diff page bodies.
   Capture the rendered HTML before you change anything, and diff it after.

HOW YOU WORK HERE
  Gate before you start and after every change:  python3 scripts/qa/ea_regression_gate.py
  Exit 0 pass, 1 drift, 2 could not measure. To move a number deliberately:
    python3 scripts/qa/ea_regression_gate.py --update-baseline --reason "..."
  Census, not sample. Compare in both directions. Capture "before" first.
  Your report is a claim; team_90 re-measures and closes cards, not you.
  Avoid duplication — one component with several parallel invocations is this theme's
  signature defect, found six times in two days. Find the existing way before adding a second.
  Do not push. Team_90 pushes after validation.
  One working copy shared with team_90: say which files you are holding.

  All other constraints — tokens, deploy interlock, forbidden paths, staging manners — are in
  section 7 of the mandate. Read it there. Do not work from memory of this paragraph.

START LIKE THIS
  1. Read the mandate and the six documents above.
  2. Run the gate and report the numbers.
  3. Come back to Nimrod, in Hebrew, with: what you understood stage A to be; the first three
     canon entries that need a decision from him and why; and your proposal for the live
     example — which page, which type, which route (A or B), which real content, and why that
     combination proves the canon.
  4. Change no file before he answers.
```

---

## What changed from version 1, and why

**The constraint essay is gone.** It now points at section 7 instead of restating it. A prompt
that carries its own copy of the rules invites the session to work from the copy, and the copy is
always the one that goes stale.

**The reading list gained the surfaces map** — the mandate requires it and the first prompt
dropped it — and it now sits after the edit-levels note, because **on the freeze question the
edit-levels note supersedes the map**, and reading them in that order makes the correction obvious
rather than confusing.

**The live-example paragraph was wrong and is now right.** Version 1 pointed at the freeze filter
and called a patch a failure, which together would have pushed a careful builder into a stall and
a confident one into editing a template. The mechanism is the defaults array; saying so is what
makes the deliverable achievable.

**And the gate is no longer offered as proof of "zero visible change"**, because it is not. It
does not compare page bodies.
