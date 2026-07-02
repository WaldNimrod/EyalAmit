# LOD400 — WP-W2-17 · CR-FINAL remediation + SEO/GEO ratified execution

**WP:** WP-W2-17 | **Milestone:** S003 | **Parent:** — | **Priority:** HIGH | **Profile:** L0
**Builder:** team_110 (execution mandate per ADR045; sub-agents permitted) | **QA:** builder self-verify → **team_90 re-audit (Cursor engine — cross-engine IR#1)** | **Final validate:** team_190/team_50 June PASS stands unless scope reopened
**Authored:** 2026-07-03 (team_100, claude-code) | **lod_status:** LOD400
**SSoT inputs:** `_COMMUNICATION/team_90/CONTENT-ACCURACY-REPORT-CR-FINAL-2026-07-02.md` (+ its `evidence/`) · `_COMMUNICATION/team_80/SEO-GEO-RESEARCH-SYNTHESIS-2026-07-02.md` · `_COMMUNICATION/team_100/DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md`

> **SUPERSEDE NOTE:** `_COMMUNICATION/team_100/MANDATE-TEAM10-CRFINAL-FIXROUND-2026-07-03.md` is SUPERSEDED by this program. Its Task 1 ("restore `/eyal-amit/` §07 heading + studio sentence") is **wrong and must not be executed** — the missing text is the deliberate, now-**permanently ratified** brand-string retirement (see DECISION artifact, item "Brand — permanent"). Its Task 2 (image verify-first) is absorbed here as T2.

---

## 0. Objective

Close the team_90 CR-FINAL leg-1 FAIL and execute every non-Eyal-blocked item from the team_80 SEO/GEO synthesis, in one fast-track WP, so that a team_90 re-audit (Cursor) can return CR-FINAL leg 1 to PASS and the M5→M6→M7 cutover chain is unblocked on everything that does not require Eyal.

## 1. Scope — task cards

### T1 — Permanent brand normalization in the content gate (resolves P0-CRF-01)
- **Fact base:** live `/eyal-amit/` content is CORRECT. The §07 delta vs source is the deliberate Round-2 brand retirement («סטודיו נשימה מעגלית» removed site-wide, 2026-06-21, after the 06-05 audit). team_00 ratified this as **permanent** on 2026-07-03 — the source doc is what is stale.
- **Do:** in `scripts/qa/content-diff.mjs`, add a **source-side** normalization that strips the retired brand suffix (`– סטודיו נשימה מעגלית פרדס חנה` and the bare `סטודיו נשימה מעגלית` token where it appears as part of the center name) before matching — same pattern as the existing jungle-vibes normalization. Code comment must cite `DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md`.
- **Do NOT:** touch the 6 verbatim customer-testimonial quotes scope-out (AC-09 re-scope, Round-2 `:35`) — those legitimately retain the string and are already out of scope; the normalization applies to source-side matching only.
- **Verify residue:** confirm the full §07 delta (title + lede sentence) is attributable to the brand string alone (evidence: `_COMMUNICATION/team_90/evidence/content-accuracy-cr-final-2026-07-02/_eyal-amit.json:17,22-23`). Any non-brand residue = a real content fix, report it separately.

### T2 — Image audit: verify-first, then fix (resolves image-audit FAIL)
- **Fact base:** `evidence/image-audit-cr-final-2026-07-02/` — 19 DOM-broken + 9 missing slots over 16 pages. The audit tool scrolls to trigger lazy-load but **never clicks carousels** → off-viewport carousel images are likely false positives. team_100 spot-check: the two "broken" `/eyal-amit/` files exist in-repo at full size (`site/wp-content/themes/ea-eyalamit/assets/images/chapters/garden.jpg`, `studio-didgs.jpg`).
- **Do:** load each of the 8 failing pages in a real browser (trigger carousels/lazy-load manually); classify every finding as: (a) probe false-positive, (b) deploy gap (asset in repo, missing on server → redeploy), (c) mapping gap (`_COMMUNICATION/team_110/image-map.json` is mockup-derived and ahead of the built page — e.g. `/eyal-amit/` slots book-1/2/3 + gallery-4), (d) genuine content gap.
- **Known real candidate:** home hero video `ea-home-hero-720-muted.mp4` — referenced by `inc/chapters/defaults/home-defaults.php:25` but **absent from the repo** (poster exists at `assets/video/ea-home-hero-poster.jpg`). Source it from `local/video-work/` (WP-W2-16-A compressed 720p 6.1MB) or the media pipeline; if untraceable → (d) content-gap ask, do not fabricate.
- **Fix only (b) and (d)-fixable.** (c) mapping gaps are documented back to team_100 — never force an image onto a page to satisfy a stale map. Never disable lazy-load to appease the probe.
- **Deliverable:** per-finding classification table + fixes + a fresh `image-audit.cjs` run (copy at `_COMMUNICATION/team_90/evidence/image-audit-cr-final-2026-07-02/image-audit.cjs`) annotated with the carousel caveat.

### T3 — D-1: meta-description single source (fixes 2×/0× drift)
- **Fact base:** `/treatment/` `/sound-healing/` `/lessons/` emit **2** `<meta name="description">`; `/method/` emits **0**. Emitter A: `ea_w2_09_route_description()` — `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php` (route map :63-121, chapters `phero.sub` branch :105-113, emit ~:150). Emitter B: a second F110-01 chapters-era emitter — locate with `grep -rn 'name="description"' site/wp-content/themes/ea-eyalamit/ site/wp-content/mu-plugins/`.
- **Do:** one owner per route; every one of the 16 in-scope routes emits **exactly one** non-empty description (≠ bloginfo tagline); `/method/` gains its description (its `phero_sub` exists in `method-defaults.php`).
- **Risk:** ACF shadowing — chapters routes resolve content via `ea_chapters_field()` (`inc/chapters/chapters-render.php:145-154`, ACF DB value wins over PHP defaults). If a live check shows no change after deploy, fix the ACF value (`scripts/wp_rest_client.py`), don't loop redeploys.

### T4 — D-2: sitemap hygiene (14 redirect-shells + 2 test pages out)
- **Fact base:** Yoast page-sitemap (102 URLs) lists 14 URLs that are 301 sources (redirects served at request time by `site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php`; the WP page shells are still published so Yoast lists them) + `/sample-page/` + `/wave2-test/` as indexable 200s. Full list: team_80 report Appendix A sitemap sweep.
- **Do:** new mu-plugin `site/wp-content/mu-plugins/ea-w2-17-sitemap-exclusions.php` using `wpseo_exclude_from_sitemap_by_post_ids` (resolve IDs by path at runtime — no hardcoded IDs); unpublish `/sample-page/` + `/wave2-test/` via `scripts/wp_rest_client.py` (app-password creds in `local/.env.upress`).
- **CRITICAL:** append the new mu-plugin to the deploy list in `scripts/ftp_deploy_site_wp_content.py:108-123` — a mu-plugin not on that list silently never deploys.

### T5 — D2 (ratified): GeoCircle areaServed on the business node
- **Do:** in `site/wp-content/mu-plugins/ea-w2-seo-schema.php` (ProfessionalService node :54-84), add `areaServed` = GeoCircle: `geoMidpoint` = geocoded studio address (עמל 8 ב', פרדס חנה-כרכור), `geoRadius` 45000 (meters).
- **Coordinates:** verify with a real geocoder at build time. Expected band: lat ∈ [32.4, 32.5], lon ∈ [34.9, 35.0]. (An earlier draft's 32.1667/35.1833 is known-wrong — reject.)
- **Prohibition lint stays green:** no `areaServed: Israel`, no `AggregateRating`, no `HealthAndBeautyBusiness` (AC-04/validation-plan §3.4).

### T6 — D3 (ratified) production robots.txt + C-1 provenance
- **(a) Author** `docs/cutover/robots-production.txt`: explicit Allow stanzas for Googlebot, Bingbot, GPTBot, OAI-SearchBot, ChatGPT-User, ClaudeBot, Claude-SearchBot, Claude-User, PerplexityBot, Perplexity-User + `Sitemap: https://www.eyalamit.co.il/sitemap_index.xml`. Re-verify UA tokens at build (spec: `SEO-GEO-EXECUTION-PLAN-2026-06-20.md:78`). **Path must stay outside `site/wp-content/**` deploy trees — this file is deployed ONLY at cutover (WP012).**
- **(b) C-1 provenance:** staging serves block-all `robots.txt` at the site root; `hub/dist/robots.txt` is byte-identical BUT the hub deploys to `/ea-eyal-hub/` — root provenance unconfirmed. FTP-inspect the WP docroot; document what serves it (physical file / host default); add an explicit "replace with docs/cutover/robots-production.txt + AC-07 curl matrix" step to the WP012 cutover checklist.
- **Post-condition now:** `curl -s $BASE/robots.txt` still returns block-all after all of this WP's deploys.

### T7 — seo_probe.mjs: the missing SEO gate (closes the QA harness gap)
- **Fact base:** existing `qa_probe.mjs` checks zero SEO signals — D-1 shipped silently for 10 days. team_80 delivered the full 12-check spec: report **Appendix B**.
- **Do:** build `scripts/qa/seo_probe.mjs` — Node 18+, zero deps, pure HTTP (no browser), CLI `--config/--base/--out`, JSON summary + exit 0/1, conventions of `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` and `scripts/qa/content-diff.mjs`. Per-route expected schema-types from `scripts/qa/seo_probe.config.json` manifest. Checks 1–12 exactly per Appendix B, calibrated for staging (noindex EXPECTED on staging host; flips on production). Brand-absence check honors the T1 permanent ratification + the 6-quote AC-09 scope-out.
- **Proof:** self-run against staging exits 0 after T3–T5 are deployed (and would have caught pre-fix D-1 — demonstrate by noting the check that covers it).

### T8 — AC-12 (ratified): staging lead-receipt test
- **Owner registered:** team_100 accountable · team_10/uPress-ops executing · Eyal inbox-confirm via team_00 · target ≤2026-07-09 (hub `tasks.json` M5-T-LEAD-TRACKING updated by team_100 in this session).
- **Do (builder half):** real CF7 submission on `$BASE/contact/` (test-marked payload); capture success response; document SMTP/deliverability + honeypot/Turnstile posture on uPress (validation-plan §4 steps 1–5, staging-pointed). GA4 `generate_lead` firing was already proven 2026-06-23 (`VERDICT_CHAPTERS-FULLSITE_POSTDEPLOY_2026-06-23.md:106-110`) — do not re-prove, reference it.
- **Not in builder scope:** Eyal's inbox confirmation (2-minute WhatsApp ask, already queued in the hub) and the production re-run (WP012 checklist item 12).

### T9 — D13 (team_00 decision): EN single-page refresh — DRAFT ONLY
- **Do:** draft the refreshed `/en/` single-page copy (Mukesh lineage + cbDIDG intro) → `_COMMUNICATION/team_100/EN-REFRESH-DRAFT-WP-W2-17-2026-07-03.md`. English, client-voice, YMYL-safe claims only.
- **HARD GATE:** nothing is published to `/en/` until Eyal approves the copy (hub ask already filed). `/en/` must remain technically correct meanwhile (hreflang/lang/dir verified live 2026-07-02).

## 2. Acceptance Criteria

`BASE=http://eyalamit-co-il-2026.s887.upress.link` — cache-bust every live check with `?nc=$(date +%s)`.

- **AC-001 (T1):** `node scripts/qa/content-diff.mjs --base $BASE --out <evidence>` → `/eyal-amit/` section% = 100; full run 16/16 in-scope PASS; normalization code comment cites the DECISION artifact.
- **AC-002 (T2):** classification table covers all 19+9 findings; 0 genuine-broken images remain post-fix (`image-audit.cjs` re-run); mapping gaps documented to team_100; no lazy-load disabled.
- **AC-003 (T3):** for ALL 16 in-scope routes: `curl -s "$BASE<route>?nc=..." | grep -c 'name="description"'` == 1, value non-empty and ≠ tagline; `php -l` clean.
- **AC-004 (T4):** `curl -s "$BASE/page-sitemap.xml"` contains none of the 14 redirect-source URLs nor `/sample-page/` nor `/wave2-test/`; every remaining `<loc>` returns direct HTTP 200; `grep ea-w2-17 scripts/ftp_deploy_site_wp_content.py` hits.
- **AC-005 (T5):** live home JSON-LD: ProfessionalService.areaServed = GeoCircle, geoMidpoint lat∈[32.4,32.5] lon∈[34.9,35.0], geoRadius 45000; prohibition lint 0 hits.
- **AC-006 (T6):** `docs/cutover/robots-production.txt` exists with 10 UA stanzas + Sitemap line; NOT referenced by any deploy script; `curl -s $BASE/robots.txt` still block-all; C-1 provenance documented + WP012 checklist step added.
- **AC-007 (T7):** `node --check scripts/qa/seo_probe.mjs` clean; self-run vs staging exits 0; all 12 Appendix-B checks implemented; JSON report written to evidence.
- **AC-008 (T8):** CF7 staging submission success captured; SMTP/anti-spam posture documented; no owner-less state remains (tasks.json carries owner+date).
- **AC-009 (T9):** EN draft artifact complete; zero bytes deployed to `/en/`.
- **AC-010 (global):** `php -l` clean on every touched PHP file; `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` → 0 FAIL; surgical per-file commits (never `git add -A`); site deploys via `scripts/ftp_deploy_site_wp_content.py` (upload-only) with **one consolidated deploy** after the code wave; any hub deploy uses `ftp_publish_eyal_client_hub.py --no-prune`.
- **AC-011 (global):** no "ready" message to Eyal from the builder — that determination belongs to the triple-PASS chain (team_90 re-audit → team_190/50 → team_00), unchanged.

## 3. Gate chain

```
L-GATE_SPEC  : this LOD400 + external validation panel (team_100, 2026-07-03 — §5 below)
L-GATE_BUILD : team_110 executes T1–T9 → self-verify per AC matrix → COMPLETION_REPORT to team_100
L-GATE_VALIDATE (leg 1) : team_90 CR-FINAL re-run — Cursor engine (IR#1) — content-diff (T1 normalization
                          submitted for ratification) + image re-audit (T2 classifications provided;
                          carousel-click improvement recommended) + seo_probe.mjs (new standing gate)
Legs 2/3     : team_190 + team_50 June PASS stands; re-run only if team_90 finds new cross-cutting scope
READY        : only on triple-PASS → team_00 → Eyal
```

## 4. Orchestration

1. **Wave A (parallel, file-disjoint, no deploy):** T1 · T3 · T4-code · T5 · T6a · T7-build · T9. Local gates: `php -l` / `node --check` per agent.
2. **Single consolidated deploy** (`ftp_deploy_site_wp_content.py`, carries T3+T4+T5) → T4-REST unpublish step.
3. **Live verification loop:** AC-003/004/005/006 curls + AC-001 content-diff + AC-007 seo_probe self-run. Fail → fix → redeploy; **max 2 iterations per task**, then escalate in the completion report (watch ACF shadowing per T3 risk note).
4. **Wave B (parallel, network):** T2 (browser verify + targeted fixes + redeploy if assets added) · T6b (FTP provenance) · T8 (CF7 test).
5. **Close:** evidence bundle under `_COMMUNICATION/team_110/` (or `evidence/` subdir), COMPLETION_REPORT to team_100, request team_90 re-audit dispatch.

## 5. Spec-validation remediations

*(to be filled by the external validation panel — team_100, 2026-07-03)*
