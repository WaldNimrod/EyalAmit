# LOD400 Spec — WP-W2-13
# S003 — Investigate & (conditionally) re-enable the D-14 entrance-animation layer

**WP ID:** WP-W2-13 | **Milestone:** S003 | **Track:** A | **Profile:** L0
**Owner:** team_100 (orchestration) | **Builder/DS:** team_80 | **Validate:** team_190 (Cursor) | **Sign-off:** team_00 (visual change)
**Authored:** 2026-06-02 (team_100) | **lod_status:** LOD400 | **status:** PLANNED
**Origin:** discovery during WP-W2-12 L-GATE_VALIDATE (DISPOSITION-WP-W2-12-AC01-2026-06-02.md)

## Problem
The D-14 entrance-animation layer (`ea-fadeUp` / `ea-breathReveal` / `ea-slideIn-rtl`, applied via `.ea-entrance*`)
is **globally disabled site-wide** by a **pre-existing top-level** rule in `ea-atoms.css` (loads last):
`.ea-entrance, .ea-entrance--breath, .ea-entrance--slide { animation: none !important; }`.
Confirmed not reduced-motion (`matchMedia('(prefers-reduced-motion: reduce)')` = false on `/`, yet computed
`animation-name: none`). So the entrances never play, on any route, for any user. This also makes the WP-W2-12
stagger inert (tidy but non-functional).

## Objective
1. **Investigate** whether the global `animation: none !important` is intentional (deliberate motion-kill) or an
   accidental/leftover override. Check git history of `ea-atoms.css`, any related decision/notes, and whether it was
   meant to be scoped to `@media (prefers-reduced-motion: reduce)` (there IS a correct reduced-motion block already
   in `ea-animations.css` lines ~90-116 — the top-level one in ea-atoms.css may be a mis-scoped duplicate).
2. **If accidental:** remove/limit the override so entrances play for motion-OK users while the reduced-motion block
   still suppresses them for reduce users; verify the WP-W2-12 stagger then renders (0.10/0.15/0.20/0.30s).
3. **If intentional:** document the decision, keep entrances off, and record that WP-W2-12's stagger is intentionally inert.

## Scope (IN)
`assets/css/ea-atoms.css` (the offending rule) + verification across the entrance-bearing routes (`/`, and any
`.ea-entrance` usage). No composition/content change.

## Out of scope
New animations; composition changes; non-entrance motion.

## Decision gate (team_00)
Re-enabling entrances is a **visual change** → requires **team_00 sign-off** before merge (and ideally Eyal awareness,
since it changes perceived motion on the homepage). This WP STOPS at a recommendation if team_00 has not pre-approved
the visual change.

## Acceptance Criteria
- **AC-01** Root-cause documented: is the global `animation:none !important` intentional? (git blame + rationale.)
- **AC-02** If re-enabled: entrances play for `prefers-reduced-motion: no-preference` (computed `animation-name`
  = ea-fadeUp/etc., stagger delays 0.10/0.15/0.20/0.30s observable) AND are fully suppressed under
  `prefers-reduced-motion: reduce` (computed `animation: none`). Proven via computed-style trace both contexts.
- **AC-03** No D-14 drift; reduced-motion accessibility preserved; axe 0 crit/serious; LH a11y 100 / mobile perf ≥85 on `/`.
- **AC-04** team_00 sign-off recorded for the visual change (if re-enabled).
- **AC-05** validate_aos 0 FAIL; `/` HTTP 200.

## Gate sequence
L-GATE_SPEC → (investigate) → S3 team_80 → S4 → S5 team_50 → L-GATE_VALIDATE team_190 (Cursor) → team_00 sign-off → CLOSE.

## SSoT / branch
ADR034 offline-fallback: named branch, file roadmap.yaml = SSoT, merge per team_00 go.
