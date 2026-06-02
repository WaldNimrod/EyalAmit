# Archive Manifest: WP-W2-12

**archive_date:** 2026-06-02
**archived_by:** team_191 (Git, Archive & File Governance)
**mandate:** team_00 authorization (2026-06-02) per WP closure protocol; authority: ADR042 §step-1 + POST_GATE_ARCHIVE_PROCEDURE v1.1.0, Iron Rule #15
**wp_id:** WP-W2-12
**label:** S003 DS-Hygiene — tokenize POC stagger-delays + de-inline POC block styles
**milestone:** S003
**track:** A (design-system hygiene)
**status:** DONE
**lod_status:** LOD400
**profile:** L0
**branch:** feature/s003-ds-hygiene (PENDING ONLY: merge → `main` per team_00 go)
**created_at:** 2026-06-02
**completed_at:** 2026-06-02
**spec_ref:** `_aos/work_packages/S003/WP-W2-12/LOD400_spec.md`
**origin_ref:** carry-forward #3 from WP-W2-11 (team_80 S4 Home finding `942a87c`); `_COMMUNICATION/team_100/WP-W2-11-COMPLETION-2026-06-02.md`
**mandate_ref:** `_COMMUNICATION/team_100/MANDATE-TEAM80-WP-W2-12-S3-DS-HYGIENE-2026-06-02.md`

## Objective

Clear pre-existing inline-`style=""` debt on the signed-off POC home blocks under proper design-system
governance — a **hygiene refactor, NOT a visual change**. Two moves: (1) introduce a named D-14 stagger
token `--ea-stagger-step: 0.05s` (consumed via `calc(var(--ea-stagger-step) * n)`) so the entrance-animation
stagger delays are no longer hard-coded inline; (2) relocate the 6 POC blocks' inline declarations into
CSS class / `nth-of-type` rules. **Rendering must be pixel-identical** before/after. New stagger tokens are a
gated D-14 change, authored under this WP with team_00 approval (recorded 2026-06-02).

## Scope — 6 POC blocks (`template-parts/blocks/`)

`block-method-pillars.php` · `block-treatment-overview.php` · `block-testimonials-row.php` ·
`block-books-row.php` · `block-services-row.php` · `block-contact-cta.php`.
D-14 CSS: `assets/css/ea-tokens.css` (new `--ea-stagger-step`), `ea-animations.css` (tokenized `nth-of-type`
stagger rules), `ea-atoms.css` (de-inlined layout classes). Out of scope: any visual/composition change;
blocks outside the 6; Eyal-gap content; Track-2 clusters.

## Summary

team_80 (DS owner) added `--ea-stagger-step: 0.05s` and moved every inline `style=""` from the 6 POC blocks
into `ea-animations.css` `nth-of-type` rules (exact delay arithmetic ×2/×3/×4/×6 → 0.10/0.15/0.20/0.30s) and
`ea-atoms.css` classes (`.ea-block-cta-end`, `.ea-service-comparison__note`, `.ea-contact-form__note--cta`).
The `text-align:right` literal was retained for RTL. Deployed to staging. L-GATE_VALIDATE round-1 (team_190/
Cursor) returned **FAIL** on AC-01 because live computed stagger delays resolve to `animation: none` / `0s`.
team_100 root-caused this to a **pre-existing** top-level `.ea-entrance{animation:none!important}` in
`ea-atoms.css` (loads last) that globally suppresses all entrance motion site-wide — unrelated to and
predating WP-W2-12, which added **no** animation rules. AC-01 ("pixel-identical") is therefore satisfied by
**rendering / computed-style equivalence**, not by observing a globally-disabled animation. team_00 chose
RE-VALIDATE with a corrected proof bar; round-1 FAIL was **withdrawn** and team_190/Cursor issued **REV2 PASS**.
The global-entrance-kill discovery was spun out as follow-up **WP-W2-13**. All cluster code on
`feature/s003-ds-hygiene`; merge to `main` pending team_00 go.

## Gate history

| Gate | Owner | Outcome |
|------|-------|---------|
| L-GATE_SPEC | team_100 | LOD400 spec authored 2026-06-02 (`LOD400_spec.md`); origin = WP-W2-11 carry-forward #3; team_00 approved opening dedicated WP |
| S3 build | team_80 (DS owner, Claude) | Added `--ea-stagger-step` token; moved all inline `style=""` from 6 POC blocks → `ea-animations.css` nth-of-type + `ea-atoms.css` classes; deployed via `scripts/ftp_deploy_site_wp_content.py`. Pre-flight PASS (axe 0/0; 0 inline animation-delay in served HTML; LH mobile median 97/a11y 100) |
| S4 token-compliance | team_80 self-audit + team_100 review | New token documented; no raw hex / no magic numbers in new rules; zero inline `style=""` remaining in the 6 blocks |
| S5 L-GATE_BUILD | team_50 (non-Claude) | axe + LH over http/https; build-gate commands all exit 0 |
| S5 L-GATE_VALIDATE — round 1 | team_190 (cross-engine, Cursor/Composer in lieu of Codex per team_00) | **FAIL** (1 blocking, AC-01: computed stagger delays = `animation:none`). Verdict `worktree_head 1aceec1` |
| Disposition (AC-01) | team_100 → team_00 | Root-cause: pre-existing global `.ea-entrance{animation:none!important}` in `ea-atoms.css`; AC-01 satisfied by rendering-equivalence; FAIL = proof-method artifact. team_00 chose RE-VALIDATE with corrected proof |
| S5 L-GATE_VALIDATE — REV2 | team_190 (Cursor/Composer) | **PASS** (0 blocking; 1 informational NB out of scope). Round-1 FAIL **withdrawn**. AC-01 proven by computed-style equivalence. Verdict `worktree_head e765725` → status **DONE** |

## AC-01 root-cause & equivalence proof

- The required computed-delay proof (0.10/0.15/0.20/0.30s) is **unsatisfiable by construction**: a pre-existing,
  top-level (non-media) rule in `ea-atoms.css` (which loads LAST) —
  `.ea-entrance, .ea-entrance--breath, .ea-entrance--slide { animation: none !important; }` — globally suppresses
  every entrance animation site-wide, unconditionally, overriding `ea-animations.css`'s `ea-fadeUp` entrance.
- Confirmed **not** reduced-motion: `matchMedia('(prefers-reduced-motion: reduce)')` = `false` under no-preference
  emulation, yet computed `animation-name: none` on `.ea-entrance` elements. Not a headless quirk.
- WP-W2-12's `git diff main..HEAD` on `ea-atoms.css` adds **only** de-inlined layout classes
  (`.ea-block-cta-end`, `.ea-service-comparison__note`, `.ea-contact-form__note--cta`) — **no animation rules**.
  The `animation:none !important` predates this WP.
- ⇒ The entrance stagger has been **inert on the live site all along**; W2-12 only relocated inert delays +
  token-based spacing (verbatim values). Computed-equivalence (REV2, no-preference): `.ea-block-cta-end` →
  margin-top 48px (`--ea-space-6`) / text-align right; `.ea-service-comparison__note` → 12.48px (0.78rem) /
  font-weight 200 / `rgb(111,99,90)` (#6F635A=`--ea-muted`) / margin-bottom 32px (`--ea-space-4`);
  `.ea-contact-form__note--cta` → margin-top 32px. ⇒ **pixel-identical → AC-01 met**.
- Parallels the WP-W2-11 Conversion AC-04 staging-cap precedent (validator measured a condition that doesn't
  reflect the real before/after comparison).

## Acceptance criteria (final — REV2 PASS)

All ACs **PASS**. AC-01 pixel-identical (rendering/computed equivalence; FAIL was a proof-method artifact) ·
AC-02 zero inline `style=""` in the 6 blocks (`grep` clean, source + served HTML) · AC-03 only new token
`--ea-stagger-step: 0.05s`, nth-of-type `calc()` rules arithmetically correct, no raw magic numbers / no raw
hex · AC-04 axe 0 critical / 0 serious, LH a11y 100, mobile perf median **88** (≥85) · AC-05 `validate_aos.sh`
30 PASS / 18 SKIP / 0 FAIL + `php -l` clean · AC-06 deployed to staging, `/` HTTP 200.

## Key commits (on `feature/s003-ds-hygiene`)

### team_80 S3 — 9 commits (`8f35906..192c922`)
- `8f35906` add `--ea-stagger-step` token (D-14) for POC entrance stagger
- `1dd5cac` tokenized nth-of-type stagger rules (de-inlined from POC blocks)
- `4faf26b` add de-inlined block classes (cta-end, comparison note, contact note--cta)
- `bd1e5ca` remove inline `style=` from block-method-pillars
- `cb1597a` remove inline `style=` from block-treatment-overview
- `539f985` remove inline `style=` from block-testimonials-row
- `7756dec` remove inline `style=` from block-books-row
- `90d3e6c` remove inline `style=` from block-services-row
- `192c922` remove inline `style=` from block-contact-cta

## Cross-engine compliance (IR#1 + IR#5)

Builder/DS **team_80** (Claude) ≠ build-gate **team_50** (non-Claude) ≠ final validate **team_190**.
team_190 L-GATE_VALIDATE (both round-1 and REV2) run in **Cursor/Composer** (team_00-approved in lieu of Codex;
Cursor ≠ Claude builder satisfies IR#1+IR#5). Final validation owned by team_190 (constitutional, immutable —
Iron Rule #5).

## Design-system (team_80)

One new gated D-14 token: `--ea-stagger-step: 0.05s` in `ea-tokens.css`. Stagger rules tokenized via
`calc(var(--ea-stagger-step) * n)` (×2/×3/×4/×6) in `ea-animations.css`. De-inlined classes reference new +
existing spacing/colour tokens; no raw hex, no magic numbers. `text-align:right` literal retained verbatim for
RTL (documented; cannot be tokenized exactly). Zero inline `style=""` remaining in the 6 POC blocks.

## Disposition & verdict references

- `_COMMUNICATION/team_100/DISPOSITION-WP-W2-12-AC01-2026-06-02.md` (AC-01 root-cause + equivalence recommendation)
- `_COMMUNICATION/team_100/PROMPT-TEAM190-WP-W2-12-REVALIDATE-CORRECTED-CURSOR-2026-06-02.md` (corrected re-validate prompt)
- `_COMMUNICATION/team_190/VERDICT-WP-W2-12-L-GATE-VALIDATE-2026-06-02.md` (round 1 — FAIL, withdrawn / superseded)
- `_COMMUNICATION/team_190/VERDICT-WP-W2-12-L-GATE-VALIDATE-REV2-2026-06-02.md` (REV2 — PASS, cluster close approved)

## Artifact inventory (referenced, retained in place)

These canonical artifacts document the WP lifecycle. They remain at their `_COMMUNICATION/team_*/` and
`_aos/` locations (referenced as the audit trail; not relocated by this manifest).

### team_100
- team_100/MANDATE-TEAM80-WP-W2-12-S3-DS-HYGIENE-2026-06-02.md
- team_100/DISPOSITION-WP-W2-12-AC01-2026-06-02.md
- team_100/PROMPT-TEAM190-WP-W2-12-REVALIDATE-CORRECTED-CURSOR-2026-06-02.md
- team_100/WP-W2-11-COMPLETION-2026-06-02.md (origin — carry-forward #3)

### team_190 (L-GATE_VALIDATE verdicts)
- team_190/VERDICT-WP-W2-12-L-GATE-VALIDATE-2026-06-02.md (round 1 FAIL — superseded)
- team_190/VERDICT-WP-W2-12-L-GATE-VALIDATE-REV2-2026-06-02.md (REV2 PASS)

### Spec
- _aos/work_packages/S003/WP-W2-12/LOD400_spec.md

### Validator evidence (retained in repo)
- scripts/qa/wp-w2-12-rev2-computed-proof.cjs · scripts/qa/reports/wp-w2-12-rev2-computed-proof.json
- scripts/qa/reports/wp-w2-12-rev2-home-desktop.png · wp-w2-12-rev2-home-mobile.png
- scripts/qa/reports/lh-mobile-t190-w2-12-rev2-run{1,2,3}.json

## Spun-out follow-up

**WP-W2-13** (PLANNED, team_80, MEDIUM) — Investigate & (conditionally) re-enable the D-14 entrance-animation
layer. Discovery during WP-W2-12 validate: the pre-existing top-level `.ea-entrance{animation:none!important}`
in `ea-atoms.css` globally disables the entire entrance layer (`ea-fadeUp`/breath/slide) site-wide. Re-enabling
is a **visual change requiring team_00 sign-off** and would make the WP-W2-12 stagger observable.
Ref: `_aos/work_packages/S003/WP-W2-13/LOD400_spec.md`; `decision_ref` = DISPOSITION-WP-W2-12-AC01.

## Carry-forwards (post-WP, tracked)

1. **Merge** `feature/s003-ds-hygiene` → `main` per team_00 go (only pending item at close).
2. **WP-W2-13** — investigate/re-enable entrance-animation layer (would make W2-12 stagger observable).
3. **Production-cutover re-measure** — mobile perf (https) + SEO/BP at production cutover (S003-wide).

---
*Generated by post-gate archive procedure (team_191) | 2026-06-02*
