---
id: QA-VERDICT-WP-W2-11-HOME-L-GATE-BUILD-2026-06-02
gate: L-GATE_BUILD
wp: WP-W2-11
cluster: Home refine — /
verdict: PASS
recorded_by: team_100 (BACKFILL from captured QA evidence — resolves team_190 audit note W05)
evidence_sources: team_100 S5 pre-flight + team_190/Cursor build-gate re-run (both reproduced the bar)
date: 2026-06-02
---

# L-GATE_BUILD — WP-W2-11 Home — PASS (backfilled)

**Audit-trail backfill.** The Home build-gate QA was executed twice (team_100 S5 pre-flight 2026-06-02, and
re-run by team_190/Cursor before its L-GATE_VALIDATE); no standalone team_50 verdict file was written at the
time (team_190 note W05). This file records the captured evidence. NOT a fresh gate run.

## Route
`/` (homepage).

## Results (PASS bar: axe 0 critical/0 serious; LH a11y 100; mobile perf ≥85 triple-run median)
| Source | axe (crit/serious) | LH mobile perf median | a11y | external hero req |
|--------|--------------------|-----------------------|------|-------------------|
| team_100 pre-flight | 0 / 0 | 98 | 100 | 0 (picsum removed) |
| team_190/Cursor re-run | 0 / 0 | 89 | 100 | 0 |

Both cleared the bar. Median delta = staging TTFB variance (non-blocking, team_190 W04/W06).
Live: POC composition intact, hero gradient-only (no external picsum request), `<br>` H1 kept,
0 console errors. `validate_aos.sh .` → 0 FAIL.

**Verdict: PASS** → cleared to L-GATE_VALIDATE (which subsequently PASSed, team_190/Cursor).
