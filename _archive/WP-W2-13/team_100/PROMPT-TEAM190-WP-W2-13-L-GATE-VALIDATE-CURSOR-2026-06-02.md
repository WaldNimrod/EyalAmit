---
id: PROMPT-TEAM190-WP-W2-13-L-GATE-VALIDATE-CURSOR-2026-06-02
from_team: team_100
to_team: team_190 — RUN IN CURSOR / Composer
date: 2026-06-02
wp: WP-W2-13 (S003 — re-enable D-14 entrance animations)
engine_note: team_00-approved — run via CURSOR (no Codex). Builder team_80 via Claude; Cursor != Claude → IR#1+IR#5.
decision_ref: _COMMUNICATION/team_00/DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md
---

# Paste-ready prompt for team_190 — WP-W2-13 L-GATE_VALIDATE (run in Cursor)

```
ROLE: team_190 — constitutional L-GATE_VALIDATE for WP-W2-13 (S003), in Cursor/Composer (cross-engine vs Claude
builder team_80; team_00-approved). Repo root: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026 .

WP-W2-13 fixed an ACCIDENTAL bug: a `@media (prefers-reduced-motion: reduce)` block at the top of ea-atoms.css had
lost its opening line, leaking `animation:none !important` to global scope and disabling the D-14 entrance-animation
layer site-wide. The fix (commit e2fce1d) re-adds the `@media (prefers-reduced-motion: reduce) {` opener (1 line).

Read first: _COMMUNICATION/team_00/DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1.md,
_COMMUNICATION/team_100/FINDINGS-WP-W2-13-ENTRANCE-ANIM-2026-06-02.md, _aos/work_packages/S003/WP-W2-13/LOD400_spec.md.

PASS bar (verify on / over https; use puppeteer-core with emulateMediaFeatures):
- AC-02 ENTRANCES PLAY for motion-OK: with prefers-reduced-motion:no-preference, computed on
  `.ea-pillars-grid .ea-pillar:nth-of-type(2)` → animation-name = ea-fadeUp, animation-delay = 0.1s; nth(3) → 0.2s;
  nth(4) → 0.3s; a `.ea-entrance--breath` heading → ea-breathReveal. (i.e., the WP-W2-12 stagger is now observable.)
- AC-02 SUPPRESSED under reduce: with prefers-reduced-motion:reduce, the same elements compute animation:none /
  animation-name:none (accessibility preserved). Confirm matchMedia('(prefers-reduced-motion: reduce)') flips correctly.
- AC-03 no D-14 drift (only the @media opener added; ea-tokens.css unchanged; no new tokens); brace balance intact.
- axe: node scripts/qa/http-qa-axe.cjs /  → 0 critical / 0 serious.
- Lighthouse: bash scripts/qa/http-qa-lighthouse.sh /  → a11y 100; mobile perf >=85 (triple-run median).
- AC-05 validate_aos 0 FAIL; AC-06 / HTTP 200.

Issue PASS/FAIL with rationale to:
  _COMMUNICATION/team_190/VERDICT-WP-W2-13-L-GATE-VALIDATE-2026-06-0X.md
Do NOT edit theme/_aos files — validate only.
```

## team_100 pre-flight reference (cross-check)
Computed (team_80 self-smoke): no-preference → pillar2 ea-fadeUp/0.1s, pillar3 0.2s, breath heading ea-breathReveal;
reduce → all none. axe/LH pre-flight results appended to the WP-W2-13 disposition.
