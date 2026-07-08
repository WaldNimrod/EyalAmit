---
id: PROMPT-TEAM190-WP-W2-11-BLOG-HOME-L-GATE-VALIDATE-CURSOR-2026-06-02
from_team: team_100 (Chief System Architect)
to_team: team_190 (Constitutional Validator) — RUN IN CURSOR / Composer
date: 2026-06-02
wp: WP-W2-11 (S003 Base Implementation — Hybrid Track-1)
clusters: Blog (D) + Home refine
engine_note: team_00-approved 2026-06-02 — run via CURSOR (no Codex available). Builder was team_10 via Claude, so Cursor (!=Claude) satisfies cross-engine IR#1+IR#5.
how_to_use: Open this repo in Cursor and paste the fenced block below into Composer verbatim.
---

# Paste-ready prompt for team_190 — WP-W2-11 Blog + Home L-GATE_VALIDATE (run in Cursor)

Paste everything inside the fence into Cursor Composer, from the repo root
`/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`.

```
ROLE: team_190 — constitutional L-GATE_VALIDATE (cross-engine; builder was team_10 via Claude — you are the
independent Cursor/Composer validator, IR#1+IR#5; team_00-approved to run in Cursor in lieu of Codex).
Repo root: /Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026 .

Validate TWO clusters of WP-W2-11 (S003 Base, Track-1): BLOG (D) and HOME refine. (Conversion already validated.)

CONTRACT + CONTEXT TO READ FIRST:
- _aos/work_packages/S003/WP-W2-11/LOD400_spec.md  (AC-01..07; Blog also AC-D2/D3/D4)
- _COMMUNICATION/team_100/DISPOSITION-WP-W2-11-BLOG-S5-CLOSE-2026-06-02.md
- _COMMUNICATION/team_100/DISPOSITION-WP-W2-11-HOME-S5-CLOSE-2026-06-02.md
- team_80 token verdicts in _COMMUNICATION/team_80/ (Blog + Home = PASS)

RUN THE GATE IN ORDER, PER CLUSTER: first the build-gate QA, then your validate.
QA tooling (already fixed to measure PERF over HTTPS; axe over http). Base host:
http://eyalamit-co-il-2026.s887.upress.link  (staging TLS cert is expired -> cert errors are ignored by the scripts).
  node scripts/qa/http-qa-axe.cjs /blog/ <one-blog-single-url>
  bash scripts/qa/http-qa-lighthouse.sh /blog/ <one-blog-single-url>
  node scripts/qa/http-qa-axe.cjs /
  bash scripts/qa/http-qa-lighthouse.sh /
(Pick a real single-post URL from the /blog/ archive HTML; URL-encode the Hebrew slug.)

PASS BAR — evaluate AC-04 PERF on the MOBILE triple-run median (NOT desktop):
  - axe: 0 critical AND 0 serious on every route
  - Lighthouse: a11y 100 (>=97 only with a documented moderate); mobile perf >=85
  - Live content checks:
      BLOG: clean excerpts (no [vc_row]); gradient featured-image placeholder; byline "אייל עמית";
            share row = WhatsApp + copy-link (NO Facebook) + related-posts render; no console errors.
      HOME: POC composition intact; hero is gradient-only (NO external picsum.photos request); <br> H1 kept.
  - Repo gates: bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .  -> 0 FAIL

GATE-ORDER DISCIPLINE: do not issue VALIDATE until the build-gate QA for that cluster PASSES; confirm the QA
evidence exists. Note in your verdict that this run is Cursor/Composer (cross-engine vs the Claude builder).

DELIVERABLES — one verdict file per cluster, each with an 8-check rationale + PASS/FAIL:
  _COMMUNICATION/team_190/VERDICT-WP-W2-11-BLOG-L-GATE-VALIDATE-2026-06-0X.md
  _COMMUNICATION/team_190/VERDICT-WP-W2-11-HOME-L-GATE-VALIDATE-2026-06-0X.md
Do NOT edit theme or _aos files — validate only. Report exit codes + the chosen single-post URL.
```

## Reference numbers (team_100 pre-flight, for your cross-check — not a substitute for your own run)
- Blog: axe 0 crit/serious both routes; LH mobile https /blog/ median 98 a100, single median 97 a100.
- Home: axe 0 crit/serious on /; LH mobile https / median 98 a100; 0 external hero requests (picsum removed).
