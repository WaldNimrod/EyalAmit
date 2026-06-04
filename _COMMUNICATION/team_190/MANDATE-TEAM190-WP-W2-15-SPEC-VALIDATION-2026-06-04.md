---
id: MANDATE-TEAM190-WP-W2-15-SPEC-VALIDATION-2026-06-04
from_team: team_100 (Chief System Architect)
to_team: team_190 (Senior Constitutional Validator)
date: 2026-06-04
gate: L-GATE_SPEC (plan/spec validation — BEFORE implementation)
wp: WP-W2-15 — Content reconciliation + Eyal-feedback fixes
engine: cross-engine non-Claude (Cursor / Codex)
staging: http://eyalamit-co-il-2026.s887.upress.link
status: ISSUED
---

# Mandate — L-GATE_SPEC validation of the WP-W2-15 plan (incl. screenshot accuracy checks)

Validate the **WP-W2-15 program plan** before we build, AND independently verify its factual premises (the content-mismatch findings) using live evidence + **screenshots where they aid accuracy**. Adversarial + independent (do not rely on team_100's conclusions before your own).

## Inputs
- Plan: `_COMMUNICATION/team_100/WP-W2-15-CONTENT-RECONCILIATION-PROGRAM-PLAN-2026-06-04.md`
- Premise evidence (verify, don't trust): `_COMMUNICATION/team_100/CONTENT-INTEGRITY-AUDIT-2026-06-04.md` + `EYAL-FEEDBACK-TRIAGE-2026-06-04.md`
- Eyal content SSoT: `docs/.../from-eyal/תוכן לאתר 25.5.26/` + `INDEX-CONTENT-2026-05-25.md`
- Roadmap: WP-W2-15 + children A–F
- Live staging (above)

## A. Plan soundness (L-GATE_SPEC)
1. **Coverage** — do children A–F cover ALL 9 of Eyal's points (FAQ-3 #1, testimonials carousel #2, FAQ TOC #3, muzza #4, books #5, blog pagination #6, About #7, Mokesh #8, 5 unbuilt pages #9)? Flag any gap.
2. **Source mapping correct** — each page → its right `25.5.26` source file (e.g. `/method`→`method.md`, `/muzza`→`MUZZA.md`, books→`eyal_tsva_FINAL.md`/`kushi_full.md`/`vekatavta.md`, shop→`buy didgeridoo.md`/`bags for didg.md`/`stend for hanging.md`/`stend for playing.md`/`build didg.md`).
3. **Acceptance testable** — is the NEW **CONTENT-ACCURACY** gate (verbatim live-vs-source ≥95%) well-defined and measurable? Are per-child ACs unambiguous?
4. **Orchestration + IR-compliance** — phasing coherent (15-A first; B/C/D parallel; F blocked)? ADR034 named-branch, single-writer roadmap, cross-engine validate, D-14 zero-drift, surgical commits all present? No structural-rework risk (content-fill into locked structure)?
5. **Blocked items correctly isolated** — 15-F (About/Mokesh/galleries/testimonials real content) properly gated on Eyal; not blocking 15-A–E.

## B. Premise verification (independent — screenshots as needed)
Confirm or correct the plan's factual basis. Use MCP browser + the `qa_probe`/scripts; **screenshot live pages vs the Eyal source** where it sharpens the accuracy judgment:
1. **Content mismatch** — sample-verify the audit's per-page accuracy: `/method` (~0%), `/muzza` (~0%), `/treatment`·`/sound-healing`·`/lessons` (~25%), `/faq` (~41%), `/` (~66%). Compare live text to the `25.5.26` source; screenshot a couple to evidence "invented vs Eyal copy."
2. **Blog pagination #6** — confirm `/blog/page/2..5` render the SAME posts as page 1 (only ~12 of 54 posts ever surface).
3. **Unbuilt pages #9** — confirm tools-for-sale / bags / stands-storage / floor-stand / repair are absent or not wired (despite sources existing).
4. **About #7 / Mokesh #8 / FAQ-3 #1 / testimonials-3 #2** — confirm each (About renders placeholder blocks not Eyal copy; per-page FAQ shows only 3; testimonials only 3).
5. **Source currency** — confirm `25.5.26` is the latest Eyal submission (supersedes April) + the Drive "Shared-with-me / not syncing" operational flag.

## C. Output
`_COMMUNICATION/team_190/VERDICT-WP-W2-15-SPEC-VALIDATION-2026-06-04.md` — §0 verdict box · §1 engine declaration · §2 plan-soundness findings (P0/P1/P2) · §3 premise-verification results (with screenshot paths under `evidence/wp-w2-15-spec/`) · §4 routing.
Verdict: **PASS** (plan sound, build may proceed) / **PASS_WITH_FINDINGS** (proceed after listed plan edits) / **FAIL** (plan must be reworked). Commit: `validate(WP-W2-15/L-GATE_SPEC): {VERDICT} — Team 190`. Write only under `_COMMUNICATION/team_190/`.

*team_100 — 2026-06-04 — validate the plan before we build.*
