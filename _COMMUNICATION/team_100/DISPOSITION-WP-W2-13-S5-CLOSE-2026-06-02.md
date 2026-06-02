---
id: DISPOSITION-WP-W2-13-S5-CLOSE-2026-06-02
from_team: team_100
to_team: team_00 / team_190 / team_80
date: 2026-06-02
wp: WP-W2-13 (S003 — re-enable D-14 entrance animations)
stage: S5 close
branch: feature/s003-entrance-fix
verdict: BUILD-COMPLETE — S5 pre-flight PASS; external L-GATE_VALIDATE (team_190/Cursor) pending
decision_ref: _COMMUNICATION/team_00/DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md
---

# DISPOSITION — WP-W2-13 · entrance-animation fix · S5 close

## What changed (S3 team_80)
One-line fix (commit `e2fce1d`): re-added the missing `@media (prefers-reduced-motion: reduce) {` opener at the top
of `ea-atoms.css`, so the leaked `animation:none !important` block is scoped to reduced-motion again. Brace balance
verified (291/291). No rule contents/selectors/values changed; no new tokens; `ea-animations.css` untouched.

## Behaviour now (team_80 computed-style self-smoke, confirmed)
| Context | `.ea-pillar:nth-of-type(2)` | breath heading | meaning |
|---|---|---|---|
| no-preference | `ea-fadeUp`, delay 0.1s (nth3 0.2s, nth4 0.3s) | `ea-breathReveal` | entrances PLAY; WP-W2-12 stagger now live |
| reduce | `none` | `none` | fully suppressed — a11y preserved |

## S5 pre-flight (team_100)
- axe (http) `/` → **0 critical / 0 serious** PASS.
- Lighthouse mobile (https) `/` → perf **97 / 97 / 96** (median 97), a11y **100** — **no regression** with motion on.
- validate_aos 0 FAIL; `/` HTTP 200.

## AC roll-up
AC-01 root-cause documented (accidental orphaned @media) ✓ · AC-02 entrances play (no-preference) + suppressed
(reduce) ✓ · AC-03 no D-14 drift, no new tokens ✓ · AC-04 team_00 sign-off recorded (DECISION ...v1) ✓ ·
AC-05 validate_aos 0 FAIL ✓ · AC-06 `/` 200 ✓.

**WP-W2-13: BUILD-COMPLETE, S5 pre-flight PASS.** Remaining: external L-GATE_VALIDATE (team_190/Cursor —
prompt at `_COMMUNICATION/team_100/PROMPT-TEAM190-WP-W2-13-L-GATE-VALIDATE-CURSOR-2026-06-02.md`) + merge per team_00 go.

## Note
This re-enables entrance motion **site-wide** (everywhere `.ea-entrance*` is used), per team_00's approved scope.
Reduced-motion users are unaffected (no motion). If any specific page should stay static, that's a follow-up scoping tweak.
