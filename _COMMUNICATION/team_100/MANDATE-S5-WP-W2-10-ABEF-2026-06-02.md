# MANDATE — S5 routing — WP-W2-10 A/B/E/F — team_100 — v1.0

**Date:** 2026-06-02
**Author:** team_100 (orchestrator)
**To:** team_50 (L-GATE_BUILD) → then team_190 (L-GATE_VALIDATE, **run in Cursor** — cross-engine per IR#1/#5)
**WP:** WP-W2-10 clusters A (Service), B (Editorial), E (Commerce), F (EN landing). G (Hero video) remains BLOCKED (Eyal asset).
**Branch:** `feature/w2-10-track2` (NOT merged to main — awaiting team_00 go). **Staging:** http://eyalamit-co-il-2026.s887.upress.link (integrated theme deployed 2026-06-02).

## Gate order (STRICT)
For each cluster: **team_50 L-GATE_BUILD must PASS before team_190 L-GATE_VALIDATE.** team_190 runs in **Cursor** (Claude built it — validator engine must differ).

## Build-side status (all four)
S3 build COMPLETE · S4 token-compliance **PASS** (zero D-14 drift; `ea-tokens.css` untouched) · team_100 pre-flight **PASS** (axe 0 crit/0 serious all routes; LH perf 97–98 / a11y 100). Pre-flight is advisory — reproduce independently.

## Routes + sources per cluster
| Cluster | Routes | Spec | Mockup (composition SSoT) | S4 | Pre-flight |
|---|---|---|---|---|---|
| A | /treatment /method /sound-healing /lessons | `_aos/work_packages/S003/WP-W2-10-A/LOD400_IMPL_spec.md` | `_COMMUNICATION/team_35/WP-W2-10-A/elevation/mockup/service-treatment.html` | `team_80/TOKEN-COMPLIANCE-WP-W2-10-A-2026-06-02.md` | `team_100/PREFLIGHT-QA-WP-W2-10-A-2026-06-02.md` |
| B | /about /press /about/moksha | `…/WP-W2-10-B/LOD400_IMPL_spec.md` | `_COMMUNICATION/team_35/WP-W2-10-B/elevation/` | `…-B-…md` | `team_100/PREFLIGHT-QA-WP-W2-10-BEF-2026-06-02.md` |
| E | /books · /books/vekatavta /books/kushi-blantis /books/tsva-bekahol · /shop | `…/WP-W2-10-E/LOD400_IMPL_spec.md` | `_COMMUNICATION/team_35/WP-W2-10-E/elevation/` | `…-E-…md` | (BEF pre-flight) |
| F | /en | `…/WP-W2-10-F/LOD400_IMPL_spec.md` | `_COMMUNICATION/team_35/WP-W2-10-F/elevation/` | `…-F-…md` | (BEF pre-flight) |

## QA bar (reproduce — every cluster)
- `node scripts/qa/http-qa-axe.cjs <cluster routes>` → 0 critical / 0 serious.
- `bash scripts/qa/http-qa-lighthouse.sh <primary + 1 sibling>` → mobile perf median ≥85; a11y 100. (perf on https; SEO/BP staging-capped.)
- Composition matches the elevated mockup; single H1/route; zero new D-14 tokens/atoms; RTL logical props (F = LTR mirror, logical props only, `dir/lang=ltr/en` on html+main, language pill → Hebrew `/`); graceful Eyal-gap placeholders; real assets wired; no console errors; per-route HTTP 200.

## Carry-forward flags for validators (non-blocking, surface in verdict)
1. **E — tsva vendor URL:** builder used asset-manifest SSoT `https://www.mendele.co.il/product/tzvabekahol/` over legacy `…/tsvabacholvezorekleyam/`. Confirm with Eyal; not a gate fail.
2. **F — closing CTA href:** points to real `/contact?lang=en` (production behavior) rather than the mockup's `#contact` anchor (in-page `id="contact"` retained). Acceptable; flag if mockup-exact anchor preferred.
3. **B — editorial nav active-state:** `about/press/moksha` are intentionally NOT primary-nav items, so no active underline on those routes (global nav IA unchanged — out of scope for composition-only WP).
4. **A — `ea-atoms.css` composition block:** A's atom sub-element rules were appended to shared `ea-atoms.css` (existing tokens only); relocatable to a cluster sheet if preferred — see A S4 note.
5. **Out-of-band commit `e3a658e`** (governance snapshot propagation by team_00 identity) landed on this branch during the session — unrelated to WP-W2-10; flagged to team_00.

## On PASS (both gates, per cluster)
Return to team_100 for WP closure per ADR042: team_191 ARCHIVE_MANIFEST → roadmap DONE/LOD500_LOCKED (file SSoT, ADR034 R9) → merge `feature/w2-10-track2` → main on **team_00 go** (currently NOT merged).
