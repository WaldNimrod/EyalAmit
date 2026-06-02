# PRE-FLIGHT QA — WP-W2-10-B/E/F — team_100 — v1.0

**Date:** 2026-06-02 · **Author:** team_100 (orchestrator pre-flight — advisory, NOT the S5 gate)
**Staging:** http://eyalamit-co-il-2026.s887.upress.link (integrated theme deployed from `feature/w2-10-track2`)

## Results (post fix-once)
| Cluster | Route | HTTP | axe crit/serious | LH perf (https) | LH a11y | single H1 |
|---|---|---|---|---|---|---|
| B | /about/ | 200 | 0/0 | 98 | 100 | ✓ |
| B | /press/ | 200 | 0/0 | — | — | ✓ |
| B | /about/moksha/ | 200 | 0/0 | — | — | ✓ |
| E | /books/ | 200 | 0/0 | 97 | 100 | ✓ |
| E | /books/vekatavta/ | 200 | 0/0 | 97 | 100 | ✓ |
| E | /books/kushi-blantis/ | 200 | 0/0 | — | — | ✓ |
| E | /books/tsva-bekahol/ | 200 | 0/0 | — | — | ✓ |
| E | /shop/ | 200 | 0/0 | — | — | ✓ |
| F | /en/ | 200 | 0/0 | 98 | 100 | ✓ |

- axe: `node scripts/qa/http-qa-axe.cjs <9 routes>` → **PASS, 0 crit/0 serious all 9**. Report: `scripts/qa/reports/axe-http-2026-06-02.json`.
- Lighthouse: `bash scripts/qa/http-qa-lighthouse.sh /about/ /books/ /books/vekatavta/ /en/` → perf 97–98 / a11y 100 (≥85 perf, 100 a11y met). SEO/BP staging-capped.

## Fix-once applied during pre-flight
- **/books/ color-contrast (serious → fixed):** `.ea-bundle__price del` faded `--ea-sand` on `--ea-chocolate` measured 3.86:1; removed `opacity:0.7` → ~6:1. Redeployed, re-ran axe → clean. No new token (D-14).

## Cluster-specific confirmations
- **B:** memorial section rendered verbatim (md5-matched), dedicated section not a link; AA holds on `--ea-bg` and `--ea-ink`; 6-cell journey timeline via shared method-pillars; real portrait wired.
- **E:** 3 book details data-driven (real covers); ALL purchase CTAs external (Morning/Mendele), no checkout; excerpt open; FAQ ×4 verbatim. **Carry-forward flag:** tsva vendor URL — builder used asset-manifest SSoT (`…/product/tzvabekahol/`) vs legacy (`…/product/tsvabacholvezorekleyam/`); confirm with Eyal at review.
- **F:** `dir/lang=ltr/en` on html+main; logical properties only (0 physical left/right); language pill → Hebrew `/`; EN copy verbatim; 3 real covers in books row. EN nav/footer inline (shared partials Hebrew-only).

## Assessment
B/E/F build-side complete; exceed S5 bars in pre-flight. Cleared to route to S5 (team_50 L-GATE_BUILD → team_190 L-GATE_VALIDATE, Cursor). Advisory only; authoritative verdicts are cross-engine (IR#1/#5).
