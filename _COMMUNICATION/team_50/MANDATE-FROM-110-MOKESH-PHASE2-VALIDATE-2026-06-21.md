# MANDATE — team_110 → team_50 · Phase-2 validation (testimonials + flag fixes)

**Issued:** 2026-06-21 (per team_100 UPDATE-100-TO-110-INTEGRATION-DONE §1; authorized by Nimrod) · file-transport (hub DB offline).
**From:** team_110 (BUILDER, Opus) · **To:** team_50 (cross-engine BUILD gate — **use a NON-Claude engine**, Iron Rule #1).

## Scope — Phase-2 only (`mokesh-content` @ HEAD, on `origin/mokesh-content`; staging theme 1.4.16)
Phase-1 (the mokesh memorial page) already dual-PASSed and is merged to `main`. Validate ONLY the Phase-2-changed surface:
1. **Service carousels** `/treatment/ /method/ /sound-healing/ /lessons/` — each now appends its CATEGORY of FB testimonials AFTER the service-specific (source) ones, deduped by name. **content-diff must stay green** (additive — builder saw all four at 100/100/0).
2. **/media** — all 48 testimonials in 3 category groups; each name links to its FB post.
3. **Legacy redirect single-hop** — the legacy Hebrew slug `/דיגרידו-…/מוקש-…/` now 301s directly to `/eyal-amit/mokesh-dahiman/` (was 2-hop via `/about/moksha/`).
4. **VideoObject uploadDate** — mokesh page VideoObject now has `uploadDate` 2019-11-19.

## Re-run independently (all must hold)
- `node scripts/qa/content-diff.mjs` → **17/17 PASS**, 0 under-90 (service routes + home + mokesh 100/100/0).
- `node scripts/qa/http-qa-axe.cjs /media/ /lessons/ /treatment/ /sound-healing/` → 0 critical / 0 serious.
- `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --base http://eyalamit-co-il-2026.s887.upress.link --paths /media/,/lessons/,/eyal-amit/mokesh-dahiman/` → no overflow (mobile+desktop).
- Legacy Hebrew slug → 1×301 → canonical 200 (single hop).
- /media renders 48 cards (3 groups); mokesh VideoObject has uploadDate.

## Accepted, non-blocking (see PHASE2 artifact §item3)
Testimonial snippets are PROVISIONAL (auto-generated, pending Eyal curation via `hub/data/testimonials-curation.json`); full-film placeholder pending Eyal's link; shop-page CTA "gaps" are an intentional richer purchase widget; FB-iframe minor mobile clip (no document overflow).

## Deliverable
`_COMMUNICATION/team_50/VERDICT_MOKESH_PHASE2_v1.md` (PASS/FAIL + evidence). On PASS → team_190 final. Full build detail: `_COMMUNICATION/team_110/PHASE2-TESTIMONIALS-FLAGS-COMPLETE-2026-06-21.md`.
