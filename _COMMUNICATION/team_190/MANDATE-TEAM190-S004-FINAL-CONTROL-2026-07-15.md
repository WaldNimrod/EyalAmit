---
id: MANDATE-TEAM190-S004-FINAL-CONTROL-2026-07-15
from_team: team_100
to_team: team_190
date: 2026-07-15
type: constitutional-final-gate
milestone: S004
gate: L-GATE_VALIDATE
builder_engine: sonnet (anthropic)
build_validator_engine: composer-2.5 (cursor, team_90)
final_gate_engine: composer-2.5 (cursor) — cross-vendor ≠ Sonnet builder (IR#1/#5 hold). [gpt-5.2/Path-B attempted first for max independence but its runner returned empty output — known wrapper issue; fell back to the proven Path-A/composer-2.5.]
verdict_output: _COMMUNICATION/team_90/VERDICT-S004-FINAL-CONTROL-2026-07-15.md  (Path-A runner writes to the validator-team dir; team_100 copies to team_190/ as the constitutional record; team_190 is not in the hub roster.)
---

# MANDATE — team_190 CONSTITUTIONAL FINAL GATE: S004 (L-GATE_VALIDATE)

You are the **constitutional final validator** (gpt-5.2, team_190 — Iron Rule #5, immutable). You are a THIRD engine, independent from the Sonnet builders AND the composer-2.5 build-validator. **Independently assess** whether S004 is ready for delivery to Eyal. Do NOT rubber-stamp — verify against the evidence + live staging.

## Staging: http://eyalamit-co-il-2026.s887.upress.link  (TLS/noindex invalid BY DESIGN on staging — not a defect)

## What to validate (WP-S4-08 §2–§7, parts A–G)
- **A — re-check WP-S4-01..07:** each has a team_90 cross-engine verdict in `_COMMUNICATION/team_90/VERDICT-WP-S4-0*.md`. Confirm each is PASS or PASS_WITH_FINDINGS with findings appropriately deferred (not silently dropped). Spot-check 2–3 you consider highest-risk (e.g. WP-S4-01 anchor verbatim content-diff; WP-S4-05 editability no-regression).
- **B — pages:** every route 200 (evidence `_COMMUNICATION/team_190/evidence/s4-08-2026-07-15/partB-routes.txt` = 32/32; `partB-qr.txt` = 48/48 QR) + render 54/54 (`qa_probe/qa_probe_result.json`, 0 overflow/fatal). Spot-check a few routes live via curl.
- **C — editability mechanism:** WP-S4-05 verdict + harnesses (190/190) prove ACF field registration + overlay identity-when-no-override + 0 unguarded ACF calls + 40/40 live no-regression. The LIVE wp-admin edit cycle needs credentialed login (deferred to team_00/Eyal) — validate the MECHANISM, note the live test as team_00-pending (this is expected, not a FAIL).
- **D — glow inventory:** WP-S4-06 verdict + `_COMMUNICATION/team_90/evidence/wp-s4-06-2026-07-15/` — every Eyal-missing item glow-marked (5 products temp-GI, books, legal, /en, galleries, media, anchor slots), 0 raw `⟨⟩`, no false positives, anchor prose unchanged (fingerprint c31a513449cca270).
- **E — deploy:** site theme + mu-plugins on staging (all routes render current content); client hub published (1049/1049, --no-prune). Confirm staging serves the final state.
- **F — delivery package:** the package lives INSIDE the subdirectory `docs/project/eyal-ceo-submissions-and-responses/to-eyal/2026-07-15--final-review-package/` — use a RECURSIVE check (the files are one level down, not directly under `to-eyal/`). Exact files (verify they exist + open): `2026-07-15--EyalAmit-final-review-package.docx` (~39KB, 27 paras + a 7-row M-EYAL-INPUTS table) AND `2026-07-15--EyalAmit-final-review-package.pdf` (~88KB, `%PDF-1.7`). It presents what's ready + the 7 M-EYAL-INPUTS + how to supply. (A prior gate run FALSE-FAILED this via a too-shallow glob `to-eyal/2026-07-15*.docx`; the package does exist — confirm at the exact subdirectory path.)
- **G — lead capture:** `/contact/` has a live CF7 form; wa.me/tel fallback + GA4 (G-MRXESK7QJF) present (spot-check via curl).

## Required output
Write **`_COMMUNICATION/team_90/VERDICT-S004-FINAL-CONTROL-2026-07-15.md`** with: frontmatter (`final_gate_engine: composer-2.5`, `milestone: S004`, `iron_rule_1: satisfied`, `iron_rule_5: satisfied`); a single top-level **verdict flag** (`PASS` / `PASS_WITH_FINDINGS` / `CONCERNS` / `FAIL`); a per-part table (A–G) with PASS/FAIL + evidence; an explicit **go/no-go recommendation for delivery to Eyal**; and any residual that must be surfaced to team_00. Findings that are by-design (Eyal-sign-off deferrals, blog drafts, live-edit-cycle pending credentialed login) are NOT failures — classify them correctly. A genuine broken page / lost content / unmarked Eyal-missing item WOULD be a FAIL.
