---
id: PROMPT-TEAM190-WP-W2-12-DS-HYGIENE-L-GATE-VALIDATE-CURSOR-2026-06-02
from_team: team_100
to_team: team_190 (Constitutional Validator) — RUN IN CURSOR / Composer
date: 2026-06-02
wp: WP-W2-12 (S003 DS-Hygiene)
engine_note: team_00-approved — run via CURSOR (no Codex). Builder/DS was team_80 via Claude; Cursor != Claude satisfies IR#1+IR#5.
how_to_use: Open this repo in Cursor and paste the fenced block into Composer verbatim.
---

# Paste-ready prompt for team_190 — WP-W2-12 DS-Hygiene L-GATE_VALIDATE (run in Cursor)

```
ROLE: team_190 — constitutional L-GATE_VALIDATE (cross-engine; DS builder was team_80 via Claude — you are the
independent Cursor/Composer validator, IR#1+IR#5; team_00-approved in lieu of Codex).
Repo root: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026 .

Validate WP-W2-12 (S003 DS-Hygiene): tokenized POC entrance-animation stagger-delays + de-inlined 6 POC blocks
(method-pillars, treatment-overview, testimonials-row, books-row, services-row, contact-cta). This is a
HYGIENE refactor — the bar is PIXEL-IDENTICAL rendering, not a visual change.

CONTRACT: _aos/work_packages/S003/WP-W2-12/LOD400_spec.md (AC-01..06).
team_80 S3 report/mandate: _COMMUNICATION/team_100/MANDATE-TEAM80-WP-W2-12-S3-DS-HYGIENE-2026-06-02.md.

Run, then verify:
  node scripts/qa/http-qa-axe.cjs /
  bash scripts/qa/http-qa-lighthouse.sh /            (perf measured on https)
  bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .

PASS bar:
  - AC-01 PIXEL-IDENTICAL: homepage / renders identically vs before (layout + entrance stagger timing). Confirm the
    deployed CSS reproduces the old delays exactly: --ea-stagger-step:0.05s in ea-tokens.css; nth-of-type rules in
    ea-animations.css give x2=0.10s, x3=0.15s, x4=0.20s, x6=0.30s. Check a couple computed animation-delays in the
    rendered page match.
  - AC-02 zero inline style="" remaining in the 6 blocks: grep the served HTML for inline animation-delay -> 0.
  - AC-03 only new token is --ea-stagger-step; no raw magic numbers / no raw hex in the new rules; ea-tokens.css
    otherwise unchanged.
  - AC-04 axe 0 critical/0 serious on /; LH a11y 100; mobile perf >=85 (triple-run median) — unchanged from WP-W2-11 Home.
  - AC-05 validate_aos 0 FAIL.

Write the verdict (8-check rationale + PASS/FAIL) to:
  _COMMUNICATION/team_190/VERDICT-WP-W2-12-L-GATE-VALIDATE-2026-06-0X.md
Do NOT edit theme/_aos files — validate only.
```

## team_100 pre-flight reference (cross-check, not a substitute)
axe 0 crit/serious on /; 0 inline animation-delay in served HTML; LH mobile https / median 97 a100.
