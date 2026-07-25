## Header

- from: **team_90 (Control / Audit)**
- engine: **gpt-5.2**
- date: **2026-07-25**
- staging (HTTP): `http://eyalamit-co-il-2026.s887.upress.link`

## Verdict

**PASS**

## Acceptance Criteria (AC-1..AC-7) — live staging verification

| AC | PASS/FAIL | Evidence (one-line) |
|---|---|---|
| AC-1 | PASS | Live-fetch + Yoast `@graph` parse OK for all required routes; see `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/aeo-seo-probe-2026-07-25/live_routes.json` + `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/aeo-seo-probe-2026-07-25/ac_evaluation.json`. |
| AC-2 | PASS | `/method/` has **no** `Service` node; see `AC-2` in `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/aeo-seo-probe-2026-07-25/ac_evaluation.json`. |
| AC-3 | PASS | `/treatment/` has `Service` + `FAQPage` (faqCount=20); see `live_routes.json` + `AC-3` in `ac_evaluation.json`. |
| AC-4 | PASS | `/snoring-sleep-apnea/` has `Article` + `FAQPage` with `mainEntity.length = 6` and exact match to visible `<details><summary>` titles; see `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/aeo-seo-probe-2026-07-25/snoring_questions_diff.json`. |
| AC-5 | PASS | `ProfessionalService.areaServed` is `GeoCircle` r=45000 with midpoint lat/lon in required band on all sampled routes; see `AC-5` in `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/aeo-seo-probe-2026-07-25/ac_evaluation.json`. |
| AC-6 | PASS | `scripts/qa/seo_probe.config.json` expected types are satisfied on all sampled routes (no missing expected types; no Service expected/observed on `/method/`); see `AC-6` in `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/aeo-seo-probe-2026-07-25/ac_evaluation.json`. |
| AC-7 | PASS | Prohibition smoke: **no** `AggregateRating`, **no** `areaServed\":\"Israel\"`, **no** `HealthAndBeautyBusiness` on sampled HTML/graph; see `AC-7` in `file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/aeo-seo-probe-2026-07-25/ac_evaluation.json`. |

## Findings (numbered)

None.

