# Mandate — team_90 AEO seo_probe ratification (cross-engine)

| Field | Value |
|-------|--------|
| from | team_100 |
| to | team_90 (Control / Audit) |
| date | 2026-07-25 |
| engine | **GPT-5.2** (subagent) — Iron Rule #1: builder ≠ validator (schema/probe updated by team_100/Cursor) |
| staging | `http://eyalamit-co-il-2026.s887.upress.link` |
| parent | `_COMMUNICATION/team_100/AEO-DEEP-AUDIT-AND-OPTIMIZATION-2026-07-25.md` |
| exec | `_COMMUNICATION/team_100/AEO-EXEC-SUMMARY-2026-07-25.md` |

## Identity

You are **team_90**. Read in full:

`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/onboard_team90.md`

You **ratify or reject** the updated AEO SEO gate. You do **not** change architecture, edit production robots, or invent content. You **must** re-verify live staging yourself — do **not** trust team_100’s PASS as fact.

## What changed (context only — verify)

1. `scripts/qa/seo_probe.config.json` — expects `FAQPage` / `Book` / `Article` on emitting routes; added `/snoring-sleep-apnea/`.
2. `scripts/qa/seo_probe.mjs` — check **7b** requires `ProfessionalService.areaServed` = GeoCircle r=45000 in Pardes Hanna band when business node present.
3. `site/wp-content/mu-plugins/ea-w2-seo-schema.php` — pillar emits `Article` + `FAQPage` from visible Chapters `dd` accordion when no CPT FAQPage.

Builder evidence (may be stale — re-check):  
`/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/evidence/aeo-deep-audit-2026-07-25/post_redeploy/`

## Required reading (absolute paths)

- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/scripts/qa/seo_probe.config.json`
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/scripts/qa/seo_probe.mjs` (checks 7 + 7b)
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/mu-plugins/ea-w2-seo-schema.php`
- `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_100/AEO-DEEP-AUDIT-AND-OPTIMIZATION-2026-07-25.md` (findings AEO-01..03)

## Acceptance criteria (all must be checked live)

| AC | Check |
|----|--------|
| AC-1 | Fetch HTML for at least: `/`, `/treatment/`, `/method/`, `/faq/`, `/snoring-sleep-apnea/`, one book (`/books/vekatavta/`). Parse Yoast `@graph`. |
| AC-2 | `/method/` has **no** `Service` node (C-2). |
| AC-3 | `/treatment/` has `Service` + `FAQPage`. |
| AC-4 | `/snoring-sleep-apnea/` has `Article` + `FAQPage` with `mainEntity.length` ≥ 6; FAQ questions match visible `<details>`/`dd` titles on the page. |
| AC-5 | Where `ProfessionalService` exists: `areaServed.@type` = `GeoCircle`, `geoRadius` = 45000, lat∈[32.4,32.5], lon∈[34.9,35.0]. |
| AC-6 | Config `expectedTypes` for those routes are **necessary and sufficient** (no missing required types; no unjustified Service on method). |
| AC-7 | Prohibition smoke: no `AggregateRating`, no `areaServed":"Israel"`, no `HealthAndBeautyBusiness` on sampled HTML. |

Staging TLS may be invalid — use HTTP. Staging `robots.txt` Disallow:/ is **expected**.

## Deliverables

1. **Verdict file (required):**  
   `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/VERDICT-AEO-SEO-PROBE-RATIFICATION-2026-07-25.md`  
   - Verdict: `PASS` | `PASS_WITH_FINDINGS` | `FAIL`  
   - Numbered findings: severity + evidence (URL + observation) + recommended fix owner (100/110)  
   - Mark any claim not re-checked as **UNVERIFIED**

2. **Evidence dir (required):**  
   `/Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/_COMMUNICATION/team_90/evidence/aeo-seo-probe-2026-07-25/`  
   - JSON or text dumps of live `@type` sets / FAQ counts / GeoCircle fields per route

## Out of scope

- Editing `seo_probe` or schema (report only; team_100 remediates on FAIL)
- Full sitemap HEAD crawl (F-SEO-01 deferred)
- Production cutover / robots swap
- Content accuracy / Eyal pending copy

## Done when

Verdict file + evidence exist; every AC-1..7 has a PASS/FAIL line with live evidence path.
