# Archive Manifest: WP-W2-13

**archive_date:** 2026-06-02
**archived_by:** team_191 (Git, Archive & File Governance)
**mandate:** team_00 authorization (2026-06-02) per WP closure protocol; authority: ADR042 §step-1 + POST_GATE_ARCHIVE_PROCEDURE v1.1.0, Iron Rule #15
**wp_id:** WP-W2-13
**label:** S003 — Investigate & (conditionally) re-enable the D-14 entrance-animation layer
**milestone:** S003
**track:** A
**status:** DONE
**lod_status:** LOD400
**profile:** L0
**branch:** feature/s003-entrance-fix (PENDING ONLY: merge → `main` per team_00 go)
**created_at:** 2026-06-02
**completed_at:** 2026-06-02
**spec_ref:** `_aos/work_packages/S003/WP-W2-13/LOD400_spec.md`
**origin_ref:** discovery during WP-W2-12 L-GATE_VALIDATE (`_COMMUNICATION/team_100/DISPOSITION-WP-W2-12-AC01-2026-06-02.md`)
**decision_ref:** `_COMMUNICATION/team_00/DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md` (Option A — approve fix)

## Objective

Re-enable the D-14 entrance-animation layer (`ea-fadeUp` / `ea-breathReveal` / `ea-slideIn-rtl`, applied via
`.ea-entrance*`) which was **globally disabled site-wide** for every user — not just reduced-motion users — by an
accidental orphaned `@media (prefers-reduced-motion: reduce)` block at the top of `ea-atoms.css`. First
**investigate** whether the global motion-kill was intentional or accidental; if accidental, restore intended
behavior so entrances play for motion-OK users while the reduced-motion suppression is preserved. Re-enabling is a
**visual change requiring team_00 sign-off** (AC-04) and makes the WP-W2-12 stagger observable.

## Scope

IN: `site/wp-content/themes/ea-eyalamit/assets/css/ea-atoms.css` (the offending rule) + verification across
entrance-bearing routes (`/`, any `.ea-entrance` usage). OUT: new animations; composition / content / layout
changes; non-entrance motion; new tokens.

## Root cause (investigation, team_100)

**ACCIDENTAL** — an orphaned reduced-motion block. At the top of `ea-atoms.css` (which loads LAST):
`.ea-entrance, .ea-entrance--breath, .ea-entrance--slide { animation: none !important; opacity: 1 !important;
transform: none !important; }` (plus related selectors), terminated by a **stray `}` at line 40** with **no
`@media` opener** before it (`grep -c '@media.*prefers-reduced-motion' ea-atoms.css` = **0**). The shape is exactly
a `@media (prefers-reduced-motion: reduce) { … }` body whose **opening line was lost** during an edit, dumping the
reduced-motion overrides into **global scope**. A CSS parser ignores the stray top-level `}`, so `animation: none
!important` applied to **all users**. Confirmed at runtime (puppeteer): `matchMedia('(prefers-reduced-motion:
reduce)')` = **false** on `/`, yet computed `animation-name: none` on `.ea-entrance` — not a reduced-motion or
headless artifact. Introduced **2026-05-27 in commit `e165218`** ("WP-W2-01 Stage B"). A correct reduced-motion
block already exists in `ea-animations.css` (~lines 90–116) — the ea-atoms.css block is its mangled twin.

## The fix (S3 team_80)

**One line** (commit `e2fce1d`): re-added the missing `@media (prefers-reduced-motion: reduce) {` opener at the top
of `ea-atoms.css`, scoping the leaked `animation:none !important` block back to reduced-motion only. No rule
contents / selectors / values changed; no new tokens; `ea-animations.css` untouched. **Brace balance 291 / 291.**
Result: entrances PLAY for motion-OK users (content rises 20px / `ea-fadeUp` 0.6s, WP-W2-12 stagger
0.10/0.15/0.20/0.30s; headings use `ea-breathReveal`) and are fully suppressed under `prefers-reduced-motion:
reduce` (a11y preserved).

## team_00 DECISION

**Option A — APPROVE THE FIX (re-enable entrances).** team_00 approved (2026-06-02,
`DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md`). Scope: **site-wide** (everywhere `.ea-entrance*` is used).
Eyal review **not required** pre-merge — team_00 sign-off is sufficient. Rationale: confirmed accidental bug;
trivial, reversible, a11y-safe; restores designed D-14 motion and surfaces the WP-W2-12 stagger as a free win.

## Gate history

| Gate | Owner | Outcome |
|------|-------|---------|
| L-GATE_SPEC | team_100 | LOD400 spec authored 2026-06-02 (`LOD400_spec.md`); origin = WP-W2-12 validate discovery; `decision_ref` = DISPOSITION-WP-W2-12-AC01 |
| Investigation (pre-S3) | team_100 | Root cause = **ACCIDENTAL** orphaned reduced-motion block (lost `@media` opener, commit `e165218`); 1-line fix recommended; flagged as VISUAL CHANGE → team_00 sign-off needed. `FINDINGS-WP-W2-13-ENTRANCE-ANIM-2026-06-02.md` |
| team_00 DECISION | team_00 (Principal) | **Option A — approve the fix** (re-enable entrances site-wide; Eyal review not required). `DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md` |
| S3 build | team_80 (Builder/DS, Claude) | Added the `@media (prefers-reduced-motion: reduce) {` opener (commit `e2fce1d`, braces 291/291); deployed. Self-smoke (computed): no-preference → pillar2 `ea-fadeUp`/0.1s, pillar3 0.2s, pillar4 0.3s, breath heading `ea-breathReveal`; reduce → all `none`. Pre-flight: axe 0/0; LH mobile https `/` median 97 / a11y 100 (no regression) |
| S5 build-gate / disposition | team_100 | S5 pre-flight PASS; AC roll-up all ✓; BUILD-COMPLETE. `DISPOSITION-WP-W2-13-S5-CLOSE-2026-06-02.md` |
| S5 L-GATE_VALIDATE | team_190 (cross-engine, Cursor/Composer in lieu of Codex per team_00) | **PASS** (0 blocking; 0 non-blocking). Verdict `worktree_head e9ca9c3`, fix_commit `e2fce1d` → status **DONE** |

## Acceptance criteria (final — PASS)

All ACs **PASS**. AC-01 root-cause documented (accidental orphaned `@media` block; git blame `e165218`) ·
AC-02 entrances play under `no-preference` (computed `animation-name` = `ea-fadeUp`/`ea-breathReveal`, stagger
0.1/0.2/0.3s observable on pillars 2–4) AND fully suppressed under `reduce` (computed `animation: none`), proven via
computed-style trace in both contexts · AC-03 no D-14 drift — only `ea-atoms.css` +1 line, `ea-tokens.css`
unchanged, no new tokens, braces 291/291; axe 0 critical / 0 serious, LH a11y 100, mobile perf median **88** (≥85) ·
AC-04 team_00 sign-off recorded (DECISION ...v1, Option A) · AC-05 `validate_aos.sh` 30 PASS / 0 FAIL · AC-06 `/`
HTTP 200.

## AC-02 runtime proof (HTTPS `/`, puppeteer `emulateMediaFeatures` — team_190)

### `prefers-reduced-motion: no-preference`
- `matchMedia('(prefers-reduced-motion: reduce)')` → **false** ✓
- `.ea-pillars-grid .ea-pillar:nth-of-type(2)` → `ea-fadeUp`, delay **0.1s** ✓; nth(3) **0.2s** ✓; nth(4) **0.3s** ✓
- `.ea-content-section__heading.ea-entrance--breath` → `ea-breathReveal` ✓
- ⇒ WP-W2-12 stagger now **observable** (contrast with pre-W2-13 global kill).

### `prefers-reduced-motion: reduce`
- `matchMedia('(prefers-reduced-motion: reduce)')` → **true** ✓
- pillar2 / pillar3 / breath heading → `animation: none`, name `none`, delay `0s` ✓ (a11y preserved)

### Deployed CSS sanity
- Staging `ea-atoms.css` lines 1–2: comment + `@media (prefers-reduced-motion: reduce) {` (curl -k; matches repo).

## Key commits

- `e165218` (2026-05-27, WP-W2-01 Stage B) — **introduced** the bug (lost `@media` opener; orphaned reduced-motion block)
- `e2fce1d` (on `feature/s003-entrance-fix`) — **the fix**: re-added the `@media (prefers-reduced-motion: reduce) {` opener (1 line; braces 291/291)

## Cross-engine compliance (IR#1 + IR#5)

Builder/DS **team_80** (Claude, commit `e2fce1d`) ≠ build-gate **team_50** (non-Claude) ≠ final validate
**team_190**. team_190 L-GATE_VALIDATE run in **Cursor/Composer** (team_00-approved in lieu of Codex; Cursor ≠
Claude builder satisfies IR#1+IR#5) — independent puppeteer trace + QA reruns. Final validation owned by team_190
(constitutional, immutable — Iron Rule #5).

## Design-system (team_80)

**No D-14 drift.** No new tokens; no rule contents / selectors / values changed; `ea-tokens.css` and
`ea-animations.css` untouched. Single-line scoping fix in `ea-atoms.css` only; brace balance 291/291. Re-enables the
existing designed D-14 entrance layer and surfaces the WP-W2-12 `--ea-stagger-step` stagger (0.10/0.15/0.20/0.30s),
which had been inert site-wide due to this accidental override.

## Decision & verdict references

- `_COMMUNICATION/team_100/FINDINGS-WP-W2-13-ENTRANCE-ANIM-2026-06-02.md` (investigation — root cause ACCIDENTAL + recommendation)
- `_COMMUNICATION/team_00/DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md` (team_00 — Option A, approve fix)
- `_COMMUNICATION/team_100/DISPOSITION-WP-W2-13-S5-CLOSE-2026-06-02.md` (S5 close — BUILD-COMPLETE, pre-flight PASS)
- `_COMMUNICATION/team_100/PROMPT-TEAM190-WP-W2-13-L-GATE-VALIDATE-CURSOR-2026-06-02.md` (validate prompt)
- `_COMMUNICATION/team_190/VERDICT-WP-W2-13-L-GATE-VALIDATE-2026-06-02.md` (L-GATE_VALIDATE — PASS)

## Artifact inventory (archived 2026-07-08 — Phase B sweep, team_110)

Per-team files **relocated** from `_COMMUNICATION/team_*/` into this archive dir (superseding the
2026-06-02 "referenced in place" disposition). `_aos/` spec and validator evidence under `scripts/qa/`
are unchanged — not `_COMMUNICATION/` artifacts, out of this procedure's scope.

### team_00
- team_00/DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md (Option A — approve fix)

### team_100
- team_100/FINDINGS-WP-W2-13-ENTRANCE-ANIM-2026-06-02.md (investigation / root cause)
- team_100/DISPOSITION-WP-W2-13-S5-CLOSE-2026-06-02.md (S5 close)
- team_100/PROMPT-TEAM190-WP-W2-13-L-GATE-VALIDATE-CURSOR-2026-06-02.md (validate prompt)

### team_190 (L-GATE_VALIDATE verdict)
- team_190/VERDICT-WP-W2-13-L-GATE-VALIDATE-2026-06-02.md (PASS)

### Spec (unchanged — retained under `_aos/work_packages/`)
- _aos/work_packages/S003/WP-W2-13/LOD400_spec.md

### Validator evidence (unchanged — retained in repo, `scripts/qa/`)
- scripts/qa/wp-w2-13-entrance-proof.cjs · scripts/qa/reports/wp-w2-13-entrance-proof.json
- scripts/qa/reports/lh-mobile-t190-w2-13-run{1,2,3}.json (perf 88/87/89, a11y 100/100/100 → median perf 88)

### Cross-references (physically archived under a sibling WP — not duplicated here)
- `DISPOSITION-WP-W2-12-AC01-2026-06-02.md` (origin — discovery during WP-W2-12 validate; owned by WP-W2-12) → `_archive/WP-W2-12/team_100/DISPOSITION-WP-W2-12-AC01-2026-06-02.md`

## Path redirects

| Former path (before archive) | Archived path |
|-------------------------------|---------------|
| _COMMUNICATION/team_00/DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md | _archive/WP-W2-13/team_00/DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md |
| _COMMUNICATION/team_100/FINDINGS-WP-W2-13-ENTRANCE-ANIM-2026-06-02.md | _archive/WP-W2-13/team_100/FINDINGS-WP-W2-13-ENTRANCE-ANIM-2026-06-02.md |
| _COMMUNICATION/team_100/DISPOSITION-WP-W2-13-S5-CLOSE-2026-06-02.md | _archive/WP-W2-13/team_100/DISPOSITION-WP-W2-13-S5-CLOSE-2026-06-02.md |
| _COMMUNICATION/team_100/PROMPT-TEAM190-WP-W2-13-L-GATE-VALIDATE-CURSOR-2026-06-02.md | _archive/WP-W2-13/team_100/PROMPT-TEAM190-WP-W2-13-L-GATE-VALIDATE-CURSOR-2026-06-02.md |
| _COMMUNICATION/team_190/VERDICT-WP-W2-13-L-GATE-VALIDATE-2026-06-02.md | _archive/WP-W2-13/team_190/VERDICT-WP-W2-13-L-GATE-VALIDATE-2026-06-02.md |
| _COMMUNICATION/team_100/DISPOSITION-WP-W2-12-AC01-2026-06-02.md (shared) | _archive/WP-W2-12/team_100/DISPOSITION-WP-W2-12-AC01-2026-06-02.md |

## Relationship to WP-W2-12

This WP **surfaced and activated** the WP-W2-12 stagger. WP-W2-12 (DS-hygiene) tokenized the entrance stagger
(`--ea-stagger-step: 0.05s`, nth-of-type `calc()` rules 0.10/0.15/0.20/0.30s) but the stagger was **inert** because
this same orphaned `ea-atoms.css` override globally killed all entrance motion. The WP-W2-13 fix makes that stagger
observable for the first time on the live site.

## Carry-forwards (post-WP, tracked)

1. **Merge** `feature/s003-entrance-fix` → `main` per team_00 go (only pending item at close).
2. **Production-cutover re-measure** — mobile perf (https) + SEO/BP at production cutover (S003-wide).
3. **Per-page motion scoping** — if any specific page should stay static, a follow-up scoping tweak (entrances are now site-wide per team_00's approved scope).

---
*Generated by post-gate archive procedure (team_191) | 2026-06-02*
*Phase B relocation completed by team_110 | 2026-07-08 (Fleet Version-Hygiene Sweep)*
