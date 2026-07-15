---
id: MANDATE-TEAM90-WP-S4-01-BUILD-2026-07-15
from_team: team_100
to_team: team_90
date: 2026-07-15
type: cross-engine-validation-mandate
wp: WP-S4-01
builder_engine: sonnet (anthropic, team_10)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator (distinct vendors)
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S4-01-BUILD-2026-07-15.md
---

# MANDATE — team_90 cross-engine validation: WP-S4-01 (anchor `/snoring-sleep-apnea/` verbatim)

You are the **cross-engine validator** (composer-2.5, team_90). A Sonnet builder (team_10) rewrote one file. **Independently reproduce** the acceptance criteria from the sources — do NOT trust the builder's report; re-derive everything yourself.

## Sources of truth (read all three)
- **Built file:** `site/wp-content/themes/ea-eyalamit/inc/chapters/defaults/snoring-sleep-apnea-defaults.php`
- **Verbatim source content:** `docs/project/eyal-ceo-submissions-and-responses/from-eyal/2026-07-12--snoring-sleep-apnea-didgeridoo-CHECKED.md`
- **Spec (ACs + mapping):** `_COMMUNICATION/team_100/S004/WP-S4-01-LOD400-2026-07-15.md` — §3 (section→part mapping), §4 (transform rules), §5 (disclaimer verbatim), §7 (the 12 ACs).

## Checks — reproduce each independently, cite evidence
- **AC-1** — 17 public sections S01–S17 present, in source order; S18 (dev notes) is NOT rendered (may appear only in the file's header docblock).
- **AC-2 (CORE)** — content-diff built file ↔ MD: every sentence of S01–S17 in the MD appears in the built body; no invented sentence, no omission; Hebrew punctuation, quotes, and numbers (250, 2006, 2014, 1999, 23:00, 7:00) verbatim. **List any missing / extra / altered sentence precisely (with MD line + built-file location).**
- **AC-3** — exactly 2 `.ea-pending-approval` glow slots (מכבי S05b, יוני S10b); no invented `<img>` for those two.
- **AC-4** — יוני story (S10) opens with a pending-approval note and the body text is verbatim (MD 384–437).
- **AC-5** — exactly one `<h1>` (from phero), text verbatim to MD line 11.
- **AC-6** — FAQ is a `dd` accordion with 6 items, first `active`, questions+answers verbatim.
- **AC-7** — internal links rewritten to real routes with trailing `/` (`/contact/ /treatment/ /method/ /eyal-amit/`); external links (BMJ, Maccabi) verbatim with `target="_blank" rel="noopener noreferrer"`.
- **AC-8** — TOC (S02) has 11 anchor links; each `href="#x"` has a matching `id="x"` on a section in the file.
- **AC-10** — disclaimer (S16) present in-page, verbatim to MD 647–653 (§5), 4 paragraphs.
- **AC-11** — `git diff --name-only` = ONLY `snoring-sleep-apnea-defaults.php`.
- **AC-12** — `php -l` clean; every single-quoted PHP string escapes the ASCII apostrophe as `\'`.
- **AC-9 (layout)** is validated separately by team_100 via `qa_probe.mjs` on staging; if evidence exists at `_COMMUNICATION/team_90/evidence/wp-s4-01-2026-07-15/`, reference it — otherwise note "deferred to team_100 staging QA".

## Required output
Write your verdict to **`_COMMUNICATION/team_90/VERDICT-WP-S4-01-BUILD-2026-07-15.md`** with:
- frontmatter incl. `validator_engine: composer-2.5`, `wp: WP-S4-01`, `iron_rule_1: satisfied`.
- a single top-level **verdict flag** — one of `PASS` / `PASS_WITH_FINDINGS` / `CONCERNS` / `FAIL`.
- a per-AC table (AC-1..AC-12) with PASS/FAIL + evidence (line refs).
- for AC-2, an explicit list of every content discrepancy found (or "none").
- `route_recommendation` if any FAIL (which package/step it returns to).
