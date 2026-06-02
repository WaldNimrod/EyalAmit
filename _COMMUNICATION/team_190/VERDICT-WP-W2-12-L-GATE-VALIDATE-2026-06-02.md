---
id: VERDICT-WP-W2-12-L-GATE-VALIDATE-2026-06-02
from: team_190 (L-GATE_VALIDATE)
to: team_100, team_00, team_80, team_50
type: QA_VERDICT
gate: L-GATE_VALIDATE
date: 2026-06-02
round: 1
engine: cursor-composer (cross-engine vs team_80/Claude builder; team_00-approved in lieu of Codex)
verdict: FAIL
blocking_findings: 1
wp: WP-W2-12 (S003 DS-Hygiene)
cluster: Home DS-hygiene (/)
branch: feature/s003-ds-hygiene
worktree_head: 1aceec1
spec_ref: _aos/work_packages/S003/WP-W2-12/LOD400_spec.md
mandate_ref: _COMMUNICATION/team_100/MANDATE-TEAM80-WP-W2-12-S3-DS-HYGIENE-2026-06-02.md
staging: http://eyalamit-co-il-2026.s887.upress.link
---

# VERDICT — WP-W2-12 DS-Hygiene | L-GATE_VALIDATE

## Verdict Box

| Field | Value |
|-------|-------|
| Gate | L-GATE_VALIDATE (team_190) |
| Verdict | **FAIL** |
| Blocking findings | **1** (AC-01) |
| Non-blocking findings | 0 |
| Route | `/` |
| Build/quality gate commands | All exited 0 (details below) |
| Cluster close | **NOT APPROVED** until AC-01 is remediated and revalidated |

---

## 8-check rationale (WP-W2-12 AC contract)

| # | Check | Verdict | Evidence |
|---|-------|---------|----------|
| 1 | Cross-engine IR#1/IR#5 independence | PASS | Builder/DS path is team_80 (Claude); this validation executed in Cursor/Composer, independent runtime and rerun evidence. |
| 2 | AC-01 pixel-identical with preserved stagger timing semantics | **FAIL (BLOCKING)** | Contract requires confirming tokenized stagger reproduces old delays and checking computed delays. `ea-tokens.css` defines `--ea-stagger-step: 0.05s`, and `ea-animations.css` defines correct nth-of-type mappings. However computed style on live `/` for representative targets (`.ea-pillar:nth-of-type(2)`, `.ea-service-comparison__col:nth-of-type(2)`, `.ea-testimonial-card:nth-of-type(3)`, `.ea-service-tile:nth-of-type(2)`, `.ea-contact-section__form.ea-entrance`) returns `animation-delay: 0s` (and `animation: none`). This does not satisfy the mandate's required computed-delay confirmation for 0.10/0.15/0.20/0.30s mappings. |
| 3 | AC-02 zero inline `style=""` in the six target blocks | PASS | Source check (`template-parts/blocks/block-{method-pillars,treatment-overview,testimonials-row,books-row,services-row,contact-cta}.php`) found no `style=`. Served home HTML check: inline `style=` count 0 and inline `animation-delay:` count 0. |
| 4 | AC-03 token correctness and hygiene constraints | PASS | Token commit `8f35906` adds only `--ea-stagger-step` in `ea-tokens.css` (+6 lines). Stagger rules commit `1dd5cac` adds tokenized `calc(var(--ea-stagger-step) * n)` rules in `ea-animations.css`; no raw hex in new rules. |
| 5 | Required command: axe on `/` | PASS | `node scripts/qa/http-qa-axe.cjs /` -> exit 0; 0 critical / 0 serious; HTTP 200. |
| 6 | Required command: lighthouse script on `/` | PASS | `bash scripts/qa/http-qa-lighthouse.sh /` -> perf 98 / a11y 100 / bp 100 / seo 69, exit 0 (script uses https for perf measurement). |
| 7 | AC-04 mobile perf/a11y (triple-run median) | PASS | Independent https mobile LH x3 on `/`: perf 89/89/89 -> median 89 (>=85), a11y 100 on all runs. Reports: `scripts/qa/reports/lh-mobile-t190-w2-12-home-run{1,2,3}.json`. |
| 8 | AC-05 repo quality gate (`validate_aos.sh`) | PASS | `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` -> 30 PASS / 18 SKIP / 0 FAIL, exit 0. |

---

## Blocking finding

### F-W2-12-01 — AC-01 evidence mismatch on live computed stagger timing

- Severity: **P1 / BLOCKING**
- Observed state: token/rule authoring is present in CSS, but computed animation timing for target entrance elements on live `/` is `0s` and animation resolves to `none`.
- Contract impact: AC-01 explicitly requires preserving and confirming stagger timing equivalence; this evidence bar is not met.
- Note: this validate gate does not edit theme files; remediation belongs to builder/DS path (team_80), then re-run S5 build + validate.

---

## Command log (validator run)

```bash
cd "/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026"
node scripts/qa/http-qa-axe.cjs /
bash scripts/qa/http-qa-lighthouse.sh /
bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .
```

| Command | Exit code |
|---------|-----------|
| `node scripts/qa/http-qa-axe.cjs /` | 0 |
| `bash scripts/qa/http-qa-lighthouse.sh /` | 0 |
| `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` | 0 |

---

## Handoff

- **team_80 / team_100:** remediate AC-01 evidence gap (live computed stagger delays must validate to intended mapped values), redeploy, and request re-validation.
- **team_190 status:** gate remains **FAIL** until AC-01 is closed with runtime proof.

