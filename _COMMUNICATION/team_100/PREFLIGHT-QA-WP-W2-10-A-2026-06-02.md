# PRE-FLIGHT QA — WP-W2-10-A — team_100 — v1.0

**Date:** 2026-06-02
**Author:** team_100 (orchestrator pre-flight — advisory, NOT the S5 gate)
**WP:** WP-W2-10-A (Service)
**Type:** team_100 pre-flight (catches issues before external routing; per Track-1 practice)
**Staging:** http://eyalamit-co-il-2026.s887.upress.link (theme deployed 2026-06-02, branch `feature/w2-10-track2`)

## Results
| Route | HTTP | axe crit/serious | LH perf (https, mobile median) | LH a11y | single H1 |
|-------|------|------------------|--------------------------------|---------|-----------|
| /treatment/ | 200 | 0 / 0 | 97 | 100 | ✓ |
| /method/ | 200 | 0 / 0 | 97 | 100 | ✓ |
| /sound-healing/ | 200 | 0 / 0 | — (spot: /treatment+/method) | — | ✓ |
| /lessons/ | 200 | 0 / 0 | — | — | ✓ |

- axe: `node scripts/qa/http-qa-axe.cjs /treatment/ /method/ /sound-healing/ /lessons/` → **PASS, 0 crit/0 serious** all 4. Report: `scripts/qa/reports/axe-http-2026-06-02.json`.
- Lighthouse: `bash scripts/qa/http-qa-lighthouse.sh /treatment/ /method/` → perf 97 / a11y 100 both (≥85 perf, 100 a11y bar met). SEO/BP staging-capped (noindex+HTTP).
- Composition: all 14 blocks render (hero+CTA pair, intro, divider, content-section, cbDIDG 4-step grid, 5-tile grid, bio-block w/ **real portrait** `eyal-portrait-hero.jpg`, service-comparison active state, testimonials ×3 sand-circle avatars, faq-mini, disclaimer verbatim, CTA band). No bare `the_content()` / SLOT-stub fallback. Backward-compat verified: home renders identically, no service-context leak.

## Assessment
A is build-side complete and exceeds the S5 bar in pre-flight. Cleared to route to S5 (team_50 L-GATE_BUILD → team_190 L-GATE_VALIDATE in Cursor). This artifact is advisory; the authoritative verdicts are cross-engine per IR#1/#5.
