# LOD400 Spec — WP-W2-12
# S003 DS-Hygiene — tokenize POC stagger-delays + de-inline POC block styles

**WP ID:** WP-W2-12 | **Milestone:** S003 | **Track:** A (design-system hygiene) | **Profile:** L0
**Owner:** team_100 (orchestration) | **Builder/DS:** team_80 (design-system owner) | **Validate:** team_190 (cross-engine)
**Authored:** 2026-06-02 (team_100) | **lod_status:** LOD400 | **status:** PLANNED
**Origin:** carry-forward from WP-W2-11 (team_80 S4 Home finding 942a87c; WP-W2-11-COMPLETION carry-forward #3)

## Objective
Remove the pre-existing inline `style=""` from the POC home blocks by (1) introducing named D-14 **stagger-delay
tokens** for the entrance-animation delays currently hard-coded inline, and (2) moving the inline declarations
into CSS class / `nth-child` rules. **Rendering must be pixel-identical** — this is a hygiene refactor of the
already-signed-off POC composition, NOT a visual change.

## Why now
WP-W2-11 held a strict composition-only / no-new-token discipline, so these pre-existing inline styles were
ruled "acceptable, pre-existing, non-blocking" and deferred (team_80 verdict, Home S4). team_00 approved
opening this dedicated WP (2026-06-02) to clear the debt under proper design-system governance (new tokens are
gated and belong in their own WP, not a composition-only pass).

## Scope (IN)
The 6 POC blocks carrying inline `style=""` (animation-delay stagger + token-based spacing):
`template-parts/blocks/` → `block-method-pillars.php`, `block-treatment-overview.php`, `block-testimonials-row.php`,
`block-books-row.php`, `block-services-row.php`, `block-contact-cta.php`.
D-14 files: `assets/css/ea-tokens.css` (new stagger tokens), `assets/css/ea-atoms.css` (new rules), and
`ea-animations.css` if delay belongs with the keyframes layer.

## Out of scope
Any visual/composition change; any block not in the list above; Eyal-gap content; Track-2 clusters.

## Approach
1. **Inventory** every inline `style=""` in the 6 blocks; record each declaration + its computed value.
2. **Tokenize** the recurring stagger delays as `--ea-stagger-1..N` (or a single `--ea-stagger-step` + `calc()`),
   added to `ea-tokens.css`. No magic numbers left inline.
3. **Relocate** the declarations into class/`nth-child` rules in `ea-atoms.css` (or animations layer), referencing
   the new tokens + existing spacing tokens. Remove the inline `style=""` from the PHP.
4. **RTL** logical properties preserved. Respect `prefers-reduced-motion` (existing pattern).
5. Deploy to staging; verify **pixel-identical** rendering.

## Execution flow (S3 → S4 → S5)
| Stage | Owner | Output |
|-------|-------|--------|
| S3 | team_80 (DS owner) | add stagger tokens; move inline → CSS; remove inline `style=""`; deploy |
| S4 | team_80 self-audit + team_100 review | new tokens documented; zero raw hex; no inline `style=""` remaining in the 6 blocks |
| S5 | team_50 (build-gate) → team_190 (validate, cross-engine — run in Cursor per team_00) | axe + LH over http/https; **visual diff = pixel-identical** |

## Acceptance Criteria
- **AC-01** Rendering is **pixel-identical** to pre-WP (before/after screenshots of `/` at desktop + mobile match; no layout/animation timing change perceptible).
- **AC-02** Zero inline `style=""` remaining in the 6 target blocks (`grep` clean).
- **AC-03** New stagger tokens defined in `ea-tokens.css`; all former inline values now reference tokens or existing tokens; **no raw magic numbers** in the new rules; no raw hex.
- **AC-04** axe 0 critical / 0 serious and Lighthouse a11y 100 / mobile perf ≥85 on `/` — unchanged from WP-W2-11.
- **AC-05** `validate_aos.sh` 0 FAIL + `php -l` clean on touched PHP.
- **AC-06** Deployed to staging, `/` HTTP 200.

## Gate sequence
L-GATE_SPEC (this doc) → S3 (team_80) → S4 → S5 L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190/Cursor) → CLOSE.

## SSoT / branch
ADR034 offline-fallback: work on a named branch (`feature/s003-ds-hygiene`), file `roadmap.yaml` = SSoT, merge to main per team_00 go. New tokens are a gated D-14 change — authored under this WP with team_00 approval (recorded 2026-06-02).
