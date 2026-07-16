---
id: MANDATE-TEAM90-WP-S5-06-VALIDATE-2026-07-16
from_team: team_00
authored_by: team_110 (under ADR045 execution_authority: full)
to_team: team_90
date: 2026-07-16
type: cross-engine-validation-mandate
wp: WP-S5-06
milestone: S005
gate: L-GATE_VALIDATE
builder_engine: claude-opus-4-8 (Claude Code, team_110)
validator_engine: composer-2.5 (cursor, team_90)
iron_rule_1: satisfied — anthropic builder ≠ cursor validator
spec_ref: _COMMUNICATION/team_100/S005/WP-S5-06-LOD400-2026-07-16.md
target_execution: _COMMUNICATION/team_110/VERDICT-WP-S5-06-BUILD-2026-07-16.md
build_gate_verdict: _COMMUNICATION/team_90/VERDICT-WP-S5-06-BUILD-2026-07-16.md
evidence_root: _COMMUNICATION/team_110/evidence/s5-06/
staging_base: http://eyalamit-co-il-2026.s887.upress.link
verdict_output: _COMMUNICATION/team_90/VERDICT-WP-S5-06-VALIDATE-2026-07-16.md
---

# MANDATE — team_90 L-GATE_VALIDATE: WP-S5-06 (QR embed facade)

You already issued **`L-GATE_BUILD PASS`** for this WP (`VERDICT-WP-S5-06-BUILD-2026-07-16.md`) — the ACs are
reproduced and settled. **Do not re-run the AC battery.**

**L-GATE_VALIDATE is a different question.** It is the constitutional gate: *may this WP be locked at
LOD500 and archived?* You own it per **team_00's ruling of 2026-07-16** («team_90 הוא הוולידטור»).

> ⚠ **Governance note you should be aware of, not blocked by.** ADR045 R3.2 and CLAUDE.md Iron Rule #5 still
> name **team_190** as the L-GATE_VALIDATE owner. team_190 is **dissolved** (ADR042 Addendum v1.1.0; it has no
> governance file, and the live actor-key registry holds 15 teams with no team_190/team_191 — independently
> confirmed this session). team_00 ruled team_90 owns this gate; a GCR to make it canonical is filed at
> `_COMMUNICATION/team_100/GCR_team_100_L-GATE_VALIDATE_OWNER_TEAM_90_2026-07-16_v1.0.0.md`.
> **You are the rightful owner of this gate. Rule on the WP, not on the drift.**

## The question to answer

**Is WP-S5-06 constitutionally closeable — scope-honest, evidence-complete, governance-clean, and safe to feed
the WP-S5-05 cutover gate?**

## Checks — judge, don't re-measure

1. **Scope honesty — no creep, no shortfall.** The build must have changed **exactly** the §0 file set (6 files,
   one of which is the local harness) and **nothing else**. Run `git diff --stat` on the branch. Flag *any* file
   touched outside §0 — especially `post_content`, the seed, either QR seeder, or `ea-w2-seo-schema.php`.
   Equally: flag anything in §4 that was **not** done.
2. **The ratified decisions were honoured, not quietly re-litigated.** §5.1 `hqdefault` (not `maxresdefault`);
   §5.2 nocookie preserved; §5.3 `ea-w2-07b-qr-reseed-once.php` **left in place**; §5.4 explicit
   `loading="lazy"` on the `<img>`; §5.5 transcripts **absent and unmarked** (team_00 instruction — their
   absence is correct, and adding a transcript placeholder would be a **violation**, not a courtesy).
3. **Evidence completeness + reproducibility.** Everything an auditor needs is under
   `_COMMUNICATION/team_110/evidence/s5-06/` and survives archiving: `STAGING_BASE.txt`, `DEPLOY-MANIFEST.txt`,
   `cwv/`, `schema-regression/` (before+after ×4), `click/`, `a11y-rtl/`, `scope/`. Confirm the AC harness lives
   at `scripts/qa/qr_facade_probe.mjs` (**not** under `evidence/`) — §4.F requires this precisely so Iron Rule
   #15 archiving cannot break the AC or leave WP-S5-05 without the tool.
4. **The two findings are properly dispositioned, not buried.** F-01 (axe threshold unsatisfiable) is routed to
   team_100 as a spec amendment and does **not** silently lower the bar. F-02 (harness site-isolation blindness)
   is fixed **in code** with the reasoning pinned in `findChrome()`, so the next runner cannot re-introduce it.
   Judge whether recording F-01 as "PASS on intent" is honest or is a bar being moved after the fact.
5. **Iron Rule #1 chain intact.** Builder `claude-opus-4-8` (Anthropic) ≠ validator `composer-2.5` (Cursor);
   team_110 did not self-validate at either gate.
6. **Does it actually serve team_00's delivery criterion?** «להגיש לאייל את האתר הכי מדוייק שאפשר … ולהשאיר רק
   פליסהולדרים ברורים» (`_aos/roadmap.yaml` L2569). Concretely: does this WP leave **any undisclosed
   placeholder** on the QR pages? (The facade poster is a real video still, not a placeholder. Transcripts are a
   ruled exclusion, not a hidden gap.)
7. **LOD500 readiness.** `status: COMPLETE` + `lod_status: LOD500_LOCKED` + `current_lean_gate: L-GATE_VALIDATE`
   are about to be written to `_aos/roadmap.yaml` **via the FILE path** (ADR034 R9/R10/R12 + team_00's T-1
   ruling — the `/api/l0/eyalamit/roadmap` endpoint serves an S002-era payload with **zero** `WP-S5-*` rows, so
   an API mutation would write the wrong object; the server build is `2026-07-12`, predating the fix).
   Confirm the file path is correct here and that this is **not** a silent 4th R8 invocation but a ruled one.

## Guardrails — DO NOT flag these as defects

- **Expired TLS / `curl -k`; site-wide `x-robots-tag: noindex`** — dev-host by design; absent on prod.
- **Transient `curl 000` / `503`** — shared-host throttling, never a redirect. Re-probe serially.
- **`ea-w2-07b-qr-reseed-once.php` retained** — ratified §5.3.
- **Posters from `i.ytimg.com`; no poster localisation** — ratified §5.1 for v1.
- **`VideoObject` `uploadDate` omitted** — ratified WP-S5-02 §2.2.
- **The 3 pre-existing axe serious violations** (`color-contrast` ×2, `link-name` ×1) — pre-existing, outside
  §4's contract, unchanged by this build. **Not this WP's defect.**
- **`/qr/` prod 302** — WP-S5-05 scope.
- ⚠ **Do NOT carry forward «native lazy-load already meets the CWV bar»** — SUPERSEDED (roadmap L2402-2426,
  *"factually wrong as a mechanism"*). This WP exists because it was wrong.

## Required output

Write `_COMMUNICATION/team_90/VERDICT-WP-S5-06-VALIDATE-2026-07-16.md`:
- Frontmatter mirroring the S5-01/02 verdicts.
- `## Verdict flag` — `PASS` / `PASS_WITH_FINDINGS` / `FAIL`.
- `## Iron Rule #1` — role/engine/team table.
- `## Per-item results` — one row per check 1-7, citing what you actually inspected.
- `## LOD500 readiness` — explicit yes/no, and whether the WP may be archived.
- `## route_recommendation` — if PASS, say `L-GATE_VALIDATE PASS — WP-S5-06 may be locked LOD500 and archived`.

**Do not** open WP-S5-05 (blocked cutover gate; needs explicit team_00/Eyal go-live approval).
