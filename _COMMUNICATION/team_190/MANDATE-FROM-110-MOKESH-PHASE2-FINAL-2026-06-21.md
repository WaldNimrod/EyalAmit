# MANDATE — team_110 → team_190 · Phase-2 FINAL validation

**Issued:** 2026-06-21 (per team_100 UPDATE §1; authorized by Nimrod) · file-transport (hub DB offline).
**From:** team_110 (BUILDER, Opus) · **To:** team_190 (final validation owner — Iron Rule #5; use a THIRD engine ≠ builder).
**Sequencing:** after team_50 PASS (`VERDICT_MOKESH_PHASE2_v1.md`).

## Scope — Phase-2 (testimonials + flag fixes) on `origin/mokesh-content`, one dual-PASS from `main`
Phase-1 (mokesh memorial page) already final-PASSed and is on `main`. Validate ONLY the Phase-2 delta:
1. 48 FB testimonials: per-category appended to `/treatment/ /method/ /sound-healing/ /lessons/` carousels (additive, deduped); all 48 grouped on `/media`.
2. Legacy Hebrew slug → single 301 hop → canonical.
3. VideoObject `uploadDate` (2019-11-19).

## Acceptance criteria
- content-diff **17/17 PASS** (no regression — testimonials additive; service routes + home + mokesh 100/100/0).
- axe 0 critical / 0 serious on the changed routes.
- qa_probe: no horizontal overflow (mobile+desktop).
- Redirects: legacy slug + `/about/moksha/` + `/mokesh/` + `/mokesh-dahiman/` each single-hop → canonical 200.
- /media: 48 cards in 3 groups, names link to FB; mokesh VideoObject has uploadDate.

## Accepted non-blocking flags
Provisional testimonial snippets (Eyal curates via `hub/data/testimonials-curation.json`); full-film link pending Eyal; shop CTA widget; FB mobile clip. Detail: `_COMMUNICATION/team_110/PHASE2-TESTIMONIALS-FLAGS-COMPLETE-2026-06-21.md`.

## Deliverable
`_COMMUNICATION/team_190/VERDICT_MOKESH_PHASE2_FINAL_v1.md`. On dual-PASS + Nimrod's explicit "מאשר", team_110 merges Phase-2 to `main` (`git merge --no-ff mokesh-content`); push on a separate "פוש".
