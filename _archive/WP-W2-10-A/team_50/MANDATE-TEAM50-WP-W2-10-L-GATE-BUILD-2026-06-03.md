# MANDATE — L-GATE_BUILD — WP-W2-10 A/B/E/F — team_100 → team_50 — v1.0

**Date:** 2026-06-03
**From:** team_100 (orchestrator) · **To:** team_50 (QA / L-GATE_BUILD owner)
**Engine constraint (IR#1/#5):** team_50 ≠ Claude (Claude was the builder). Run in **Cursor**.
**WP:** WP-W2-10 clusters A (Service), B (Editorial), E (Commerce), F (EN landing). G BLOCKED (Eyal hero video).
**Source:** branch `feature/w2-10-track2` merged to `main` @ `d452beb` (local; not pushed). **Staging (validate against this):** http://eyalamit-co-il-2026.s887.upress.link

## Your gate
L-GATE_BUILD — independently reproduce the QA bar (do NOT trust team_100 pre-flight; it is advisory). You run **before** team_190. Issue a per-cluster verdict; on PASS the cluster proceeds to team_190 L-GATE_VALIDATE.

## Routes per cluster
| Cluster | Routes |
|---|---|
| A | /treatment/ /method/ /sound-healing/ /lessons/ |
| B | /about/ /press/ /about/moksha/ |
| E | /books/ · /books/vekatavta/ /books/kushi-blantis/ /books/tsva-bekahol/ · /shop/ |
| F | /en/ |

## QA bar (PASS = all of the below, per cluster)
1. `node scripts/qa/http-qa-axe.cjs <cluster routes>` → **0 critical / 0 serious** every route.
2. `bash scripts/qa/http-qa-lighthouse.sh <primary + 1 sibling>` → **mobile perf triple-run median ≥ 85**, **a11y = 100**. (perf measured on https; SEO/BP staging-capped — ignore.)
3. Per-route HTTP 200; single `<h1>` per route; no console errors.

## Output (per cluster)
Write `QA-VERDICT-WP-W2-10-{A|B|E|F}-L-GATE-BUILD-2026-06-03.md` → `_COMMUNICATION/team_50/` with: verdict (PASS / PASS_WITH_FINDINGS / FAIL), the axe + LH numbers per route, and any findings. On FAIL, route back to team_100 (do NOT advance to team_190).

## References
- Specs: `_aos/work_packages/S003/WP-W2-10-{A,B,E,F}/LOD400_IMPL_spec.md`
- Composition SSoT (mockups): `_COMMUNICATION/team_35/WP-W2-10-{A,B,E,F}/elevation/`
- S4 token-compliance (PASS): `_COMMUNICATION/team_80/TOKEN-COMPLIANCE-WP-W2-10-{A,B,E,F}-2026-06-02.md`
- team_100 pre-flight (advisory): `_COMMUNICATION/team_100/PREFLIGHT-QA-WP-W2-10-A-2026-06-02.md`, `…-BEF-2026-06-02.md`
- Umbrella routing + carry-forward flags: `_COMMUNICATION/team_100/MANDATE-S5-WP-W2-10-ABEF-2026-06-02.md`

## Carry-forward flags (note in verdict; non-blocking)
E — tsva vendor URL uses asset-manifest SSoT (tzvabekahol). F — closing CTA `/contact?lang=en` vs mockup `#contact`. B — editorial routes intentionally not in primary nav (no active-state).
