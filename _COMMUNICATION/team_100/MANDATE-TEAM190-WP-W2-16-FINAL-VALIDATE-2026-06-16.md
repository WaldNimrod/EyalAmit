# MANDATE — team_190: WP-W2-16 final L-GATE_VALIDATE (constitutional)

**From:** team_100 (Chief Architect, builder = **Claude Code**) · **To:** team_190 (final validator)
**Date:** 2026-06-16 · **WP:** WP-W2-16 · **Branch:** `wp-w2-16` (off `main`) · **Staging ver:** `1.4.13`
**Gate:** L-GATE_VALIDATE (final, owned by team_190 — Iron Rule #5, immutable).
**Cross-engine (Iron Rule #1):** NOT Claude — run in Codex (or Cursor/Composer per team_00's
standing approval). **Order:** run ONLY after **team_50 E2E PASS** (their verdict must exist first).

## Scope
Re-validate the full WP-W2-16 (5 batches — see closeout) to the same bars team_50 used
(content-diff 17/17, axe 0/0, overflow 0 @360/390/414/768, single-hop redirects, blog pagination).
Treat team_50's verdict as input, not as a substitute — independently re-run the gates.

## ⚠ Special charge — review the gate fix itself (team_100 flagged this)
WP-W2-16-E required a fix to the **content-accuracy gate's docx parser** (`scripts/qa/content-diff.mjs`,
`readSource`), landed standalone to `main` (commit `88160bd`):
- **Before:** all `<w:t>` runs joined with `' '` → words Word split across runs broke (`של`→`ש ל`,
  `להיום`→`להי ום`), repeated headings fused → a byte-verbatim docx render scored ~18–55% and false-failed.
- **After:** extract per `<w:p>`; runs join with no separator; paragraphs with `\n`.
**Your charge:** confirm this parser change is SOUND and does not weaken the gate — i.e. it (a) only
affects the docx path (the 16 `.md` pages score identically before/after), (b) does not let
non-verbatim/invented mokesh content pass (spot-check: perturb a mokesh sentence on a scratch render
and confirm sentenceCov drops), (c) thresholds/section logic/`normalize()` are untouched. If unsound,
FAIL and route to team_100.

## Other confirmations
- **/eyal-amit canonical** is SEO-sound: single 301 hops, `<link rel=canonical>` on `/eyal-amit/`
  resolves to itself (not `/about`), no redirect loops, nav/internal links point to `/eyal-amit`.
- **Mokesh is verbatim**, not invented: diff the live prose against `…/מוקש דהימן/ומה היום.docx`;
  the bio intro + `1950–2020` dates are explicit **placeholders pending Eyal** (note present on-page) —
  these are intended, not a content defect.
- **No regressions** on the 4 already-closed Eyal items (#1/#4/#5/#7/#9) or WP-W2-15 pages.

## Deliverable
`_COMMUNICATION/team_190/VERDICT_WP-W2-16_FINAL-VALIDATE_<engine>_v1.md` + evidence. A clean PASS is
the gate for: merge `wp-w2-16`→`main` (team_00 go) + roadmap lock + the Eyal "ready" message
(team_00 sends). Do NOT touch `_aos/`.

## ACTIVATION PROMPT
```
You are team_190 (final validator, constitutional), running in Codex/Cursor (cross-engine vs the Claude builder).
Repo: EyalAmit.co.il-2026. Final-validate WP-W2-16 on branch wp-w2-16 (staging 1.4.13), AFTER team_50 PASS.
READ: _COMMUNICATION/team_100/MANDATE-TEAM190-WP-W2-16-FINAL-VALIDATE-2026-06-16.md
      _COMMUNICATION/team_100/WP-W2-16-VERIFICATION-CLOSEOUT-2026-06-16.md
      _COMMUNICATION/team_50/VERDICT_WP-W2-16_E2E_*  (must exist & PASS first)
RE-RUN independently: content-diff (17/17), qa_probe overflow (0), axe (0/0), redirect probes, blog page-2.
SPECIAL: review the content-diff docx-parser fix (main 88160bd) for soundness — md pages unchanged,
         invented mokesh content still fails, thresholds untouched.
CONFIRM: /eyal-amit canonical SEO (canonical tag, single-hop), mokesh verbatim vs ומה היום.docx,
         bio/dates are intended placeholders, no WP-W2-15 regressions.
EMIT: _COMMUNICATION/team_190/VERDICT_WP-W2-16_FINAL-VALIDATE_<engine>_v1.md. A clean PASS gates merge+lock.
```
