# LOD400 — WP-W2-17 · CR-FINAL remediation + SEO/GEO ratified execution

**WP:** WP-W2-17 | **Milestone:** S003 | **Parent:** — | **Priority:** HIGH | **Profile:** L0
**Builder:** team_110 (execution mandate per ADR045; sub-agents permitted) | **QA:** builder self-verify → **team_90 re-audit (Cursor engine — cross-engine IR#1)** | **Final validate:** team_190/team_50 June PASS stands unless scope reopened
**Authored:** 2026-07-03 (team_100, claude-code) | **lod_status:** LOD400 (rev 2 — post-validation-panel, see §5)
**SSoT inputs:**
- `_COMMUNICATION/team_90/CONTENT-ACCURACY-REPORT-CR-FINAL-2026-07-02.md` (+ its `evidence/`)
- `_COMMUNICATION/team_80/SEO-GEO-RESEARCH-SYNTHESIS-2026-07-02.md` (Appendix B = seo_probe check-spec)
- `_COMMUNICATION/team_100/DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md`
- `_COMMUNICATION/team_100/WP-S004-P001-WP000-SEO-GEO-FINALIZATION-2026-06-20.md` — "the umbrella" (its ACs cited below as **umbrella AC-xx**)
- `_COMMUNICATION/team_100/SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md` — "the validation plan" (prohibition-lint §3.4, AC-12 protocol §4)
- `_COMMUNICATION/team_100/SEO-GEO-EXECUTION-PLAN-2026-06-20.md` (WP-04 robots spec :78)
- `_COMMUNICATION/team_100/SEO-GEO-ROUND2-COMPLETION-2026-06-21.md` (AC-09 6-quote re-scope :35)
- `_COMMUNICATION/team_190/VERDICT_CHAPTERS-FULLSITE_POSTDEPLOY_2026-06-23.md` (generate_lead evidence :106-110)

> **SUPERSEDE NOTE:** `_COMMUNICATION/team_100/MANDATE-TEAM10-CRFINAL-FIXROUND-2026-07-03.md` is SUPERSEDED by this program. Its Task 1 ("restore `/eyal-amit/` §07 heading + studio sentence") is **wrong and must not be executed** — the missing text is the deliberate, now-**permanently ratified** brand-string retirement (DECISION §4). Its Task 2 (image verify-first) is absorbed here as T2.

---

## 0. Objective

Close the team_90 CR-FINAL leg-1 FAIL and execute every non-Eyal-blocked item from the team_80 SEO/GEO synthesis, in one fast-track WP, so that a team_90 re-audit (Cursor) can return CR-FINAL leg 1 to PASS and the M5→M6→M7 cutover chain is unblocked on everything that does not require Eyal.

## 1. Scope — task cards

### T1 — Permanent brand normalization in the content gate (resolves P0-CRF-01)
- **Fact base:** live `/eyal-amit/` content is CORRECT. The §07 delta vs source is the deliberate Round-2 brand retirement («סטודיו נשימה מעגלית» removed site-wide, 2026-06-21, after the 06-05 audit). team_00 ratified this as **permanent** on 2026-07-03 — the source doc is what is stale.
- **Do:** in `scripts/qa/content-diff.mjs`, add a **source-side** normalization that strips the retired brand suffix (`– סטודיו נשימה מעגלית פרדס חנה` and the bare `סטודיו נשימה מעגלית` token where it appears as part of the center name) before matching — same pattern as the existing jungle-vibes normalization (`content-diff.mjs:128-133`). Code comment must cite `DECISION-WP-W2-17-RATIFICATIONS-2026-07-03.md`.
- **Do NOT:** touch the 6 verbatim customer-testimonial quotes scope-out (umbrella AC-09 re-scope, `SEO-GEO-ROUND2-COMPLETION-2026-06-21.md:35`) — those legitimately retain the string and are already out of scope; the normalization applies to source-side matching only.
- **Verify residue:** confirm the full §07 delta (title + lede sentence) is attributable to the brand string alone (evidence: `_COMMUNICATION/team_90/evidence/content-accuracy-cr-final-2026-07-02/_eyal-amit.json:17,22-23`). Any non-brand residue = a real content fix — report it in the COMPLETION_REPORT as a distinct section.

### T2 — Image audit: verify-first, then fix (resolves image-audit FAIL)
- **Fact base:** `evidence/image-audit-cr-final-2026-07-02/` — 19 DOM-broken + 9 missing slots over 16 pages (8 pages failing). The audit tool scrolls to trigger lazy-load but **never clicks carousels**, and inspects only `<img>` elements (never `<video>`) → off-viewport carousel images and video slots are likely false positives. team_100 spot-check: the two "broken" `/eyal-amit/` files exist in-repo at full size (`site/wp-content/themes/ea-eyalamit/assets/images/chapters/garden.jpg`, `studio-didgs.jpg`).
- **Do:** load each of the 8 failing pages in a real browser (trigger carousels/lazy-load manually); classify every finding as: (a) probe false-positive, (b) deploy gap (asset in repo, missing on server → redeploy), (c) mapping gap (`_COMMUNICATION/team_110/image-map.json` is mockup-derived and ahead of the built page — e.g. `/eyal-amit/` slots book-1/2/3 + gallery-4), (d) genuine content gap.
- **Home hero video/poster slots:** `ea-home-hero-720-muted.mp4` **is in the repo and git-tracked** (`site/wp-content/themes/ea-eyalamit/assets/video/`, 6.47MB, committed 2026-06-16) alongside `ea-home-hero-poster.jpg`. If missing/broken live this is category (b) deploy gap or (a) probe false-positive (the audit never checks `<video>`) — **never (d)** for this item. Verify live presence with `curl -I` on both asset URLs first.
- **Fix only (b) and (d)-fixable.** (c) mapping gaps are documented back to team_100 — never force an image onto a page to satisfy a stale map. Never disable lazy-load to appease the probe.
- **Deliverable:** per-finding classification table + fixes + a fresh `image-audit.cjs` run (copy at `_COMMUNICATION/team_90/evidence/image-audit-cr-final-2026-07-02/image-audit.cjs`) annotated with the carousel caveat — bundled in the COMPLETION_REPORT.

### T3 — D-1: meta-description single source (fixes 2×/0× drift)
- **Fact base:** `/treatment/` `/sound-healing/` `/lessons/` emit **2** `<meta name="description">`; `/method/` emits **0**. **Emitter A (in-repo):** `ea_w2_09_route_description()` — `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-09.php` (route-map literal :63-82 within the resolver :63-121, chapters `phero.sub` branch :105-113, emit :150). **Emitter B (server-side, NOT findable by repo grep):** Yoast SEO rendering DB post-meta `_yoast_wpseo_metadesc`, seeded for exactly these 3 routes by the M3-era seeder `site/wp-content/mu-plugins/ea-m3-team80-placeholder-content-once.php:176-178` (live `/treatment/` first description is byte-identical to the seeded string). `/method/` has neither a route-map entry nor a seeded metadesc → 0.
- **Do:** one owner per route. Either clear the stale `_yoast_wpseo_metadesc` values via `scripts/wp_rest_client.py` (app-password creds in `local/.env.upress`) and let Emitter A own all routes, or cede those routes to Yoast and remove them from Emitter A's path — builder's call, documented. `/method/` must gain exactly 1 (its `phero_sub` exists in `method-defaults.php:23`).
- **Risk:** ACF shadowing — chapters routes resolve content via `ea_chapters_field()` (`inc/chapters/chapters-render.php:145-154`, ACF DB value wins over PHP defaults). If a live check shows no change after deploy, fix the DB-side value, don't loop redeploys.

### T4 — D-2: sitemap hygiene (14 redirect-shells + 2 test pages + child-sitemap noise)
- **Fact base:** Yoast page-sitemap (102 URLs) lists 14 URLs that are 301 sources (redirects served at request time by `site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php`; the WP page shells are still published so Yoast lists them) + `/sample-page/` + `/wave2-test/` as indexable 200s. Full list: team_80 report Appendix A sitemap sweep.
- **Do:** new mu-plugin `site/wp-content/mu-plugins/ea-w2-17-sitemap-exclusions.php` using `wpseo_exclude_from_sitemap_by_post_ids` (resolve IDs by path at runtime — no hardcoded IDs); unpublish `/sample-page/` + `/wave2-test/` via `scripts/wp_rest_client.py`. **Same pass (team_80 flag C-3):** disable the noise child-sitemaps (`wpa-stats-type`, `author`, `post_tag`/`category`) via Yoast filters/settings in the same mu-plugin where filterable.
- **CRITICAL:** append the new mu-plugin to the deploy list in `scripts/ftp_deploy_site_wp_content.py` (mu-plugin `files.append` block spans **:108-136** — append at the end of the list) — a mu-plugin not on that list silently never deploys.

### T5 — D2 (ratified): GeoCircle areaServed on the business node
- **Do:** in `site/wp-content/mu-plugins/ea-w2-seo-schema.php` (ProfessionalService node :54-84), add `areaServed` = GeoCircle: `geoMidpoint` = geocoded studio address (עמל 8 ב', פרדס חנה-כרכור), `geoRadius` 45000 (meters).
- **Coordinates:** verify with a real geocoder at build time. Expected band: lat ∈ [32.4, 32.5], lon ∈ [34.9, 35.0]. (An earlier draft's 32.1667/35.1833 is known-wrong — reject.)
- **Prohibition lint stays green:** no `areaServed: Israel`, no `AggregateRating`, no `HealthAndBeautyBusiness` (umbrella AC-04; lint definition = validation plan §3.4).

### T6 — D3 (ratified) production robots.txt + C-1 provenance
- **(a) Author** `docs/cutover/robots-production.txt`: explicit Allow stanzas for the **10 ratified UAs** — Googlebot, Bingbot, GPTBot, OAI-SearchBot, ChatGPT-User, ClaudeBot, Claude-SearchBot, Claude-User, PerplexityBot, Perplexity-User — + `Sitemap: https://www.eyalamit.co.il/sitemap_index.xml`. Re-verify UA tokens at build (`SEO-GEO-EXECUTION-PLAN-2026-06-20.md:78`). **Path must stay outside `site/wp-content/**` deploy trees — this file is deployed ONLY at cutover (WP012).**
- **(b) C-1 provenance:** staging serves block-all `robots.txt` at the site root; `hub/dist/robots.txt` is byte-identical BUT the hub deploys to `/ea-eyal-hub/` — root provenance unconfirmed. FTP-inspect the WP docroot; document findings in the COMPLETION_REPORT.
- **(c) Cutover checklist:** create/extend `docs/cutover/WP012-CUTOVER-CHECKLIST.md` (create-if-missing; team_100 ratifies at completion) with: identify+replace root robots.txt with `docs/cutover/robots-production.txt` + run the umbrella AC-07 day-one curl matrix (validation plan :112-125).
- **Post-condition now:** `curl -s $BASE/robots.txt` still returns block-all after all of this WP's deploys.

### T7 — seo_probe.mjs: the missing SEO gate (closes the QA harness gap)
- **Fact base:** existing `qa_probe.mjs` checks zero SEO signals — D-1 shipped silently for 10 days. team_80 delivered the full 12-check spec: report **Appendix B**.
- **Routing deviation (recorded):** team_80 §5.5 recommended team_90/team_50 build this; per the team_00 fast-track directive it is built by team_110 here, and **team_90 ratifies the implementation against Appendix B at the re-audit** (gate chain below).
- **Do:** build `scripts/qa/seo_probe.mjs` — Node 18+, zero deps, pure HTTP (no browser), CLI `--config/--base/--out`, JSON summary + exit 0/1, conventions of `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` and `scripts/qa/content-diff.mjs`. **Author** the per-route expectations manifest `scripts/qa/seo_probe.config.json` (does not exist yet — builder creates it; per-route expected `@type` set, description/canonical/OG expectations). Checks 1–12 per Appendix B, calibrated for staging (noindex EXPECTED on staging host; flips on production), with two ratified supersessions: check 2's UA count is **10** (D3 ratification supersedes Appendix B's "8"); check 12's brand-absence honors the T1 permanent ratification + the 6-quote scope-out. On C-2 (`/method/` Service node): per DECISION §9, «השיטה» is **not** a Service — the manifest must NOT expect a Service node on `/method/`.
- **Proof:** self-run against staging exits 0 after T3–T5 are deployed, and the COMPLETION_REPORT names which check catches the pre-fix D-1 state (check 4).

### T8 — AC-12 (ratified): staging lead-receipt test — umbrella AC-12, validation plan §4
- **Owner registered:** team_100 accountable · team_10/uPress-ops executing · Eyal inbox-confirm via team_00 · target ≤2026-07-09 (hub `tasks.json` M5-T-LEAD-TRACKING updated by team_100, 2026-07-03).
- **Do (builder half — validation plan §4 steps 1–5, staging-pointed, per-path):**
  1. real CF7 submission on `$BASE/contact/` (test-marked payload) — capture success response;
  2. wa.me path: verify the prefilled `?text=` link resolves and the click fires `generate_lead` (network/GA4-debug capture on staging);
  3. tel: path: verify link presence + E.164 format + `generate_lead` wiring;
  4. per-path `generate_lead` evidence — the 2026-06-23 verdict (`VERDICT_CHAPTERS-FULLSITE_POSTDEPLOY_2026-06-23.md:106-110`) covers the WhatsApp-click path only; do not treat it as covering CF7/tel;
  5. document SMTP/deliverability + honeypot/Turnstile posture on uPress.
  Any step infeasible headless (e.g. real-device tap) → explicit scope-out in the COMPLETION_REPORT with the named follow-up owner (team_00/Eyal device check at inbox-confirm time).
- **Not in builder scope:** Eyal's inbox confirmation (2-minute WhatsApp ask, already queued in the hub) and the production re-run (WP012 checklist).

### T9 — D13 (team_00 decision): EN single-page refresh — DRAFT ONLY
- **Do:** draft the refreshed `/en/` single-page copy (Mukesh lineage + cbDIDG intro) → `_COMMUNICATION/team_110/EN-REFRESH-DRAFT-WP-W2-17-2026-07-03.md` (builder's own comms dir — Directory Authority). English, client-voice, YMYL-safe claims only.
- **HARD GATE:** nothing is published to `/en/` until Eyal approves the copy (hub ask already filed). `/en/` must remain technically correct meanwhile (hreflang/lang/dir verified live 2026-07-02).

## 2. Acceptance Criteria

`BASE=http://eyalamit-co-il-2026.s887.upress.link` — cache-bust every live check with `?nc=$(date +%s)`.
**Route set definition:** "the 16 in-scope routes" = team_90's CR1–4 rollup set (report §1 table); `/eyal-amit/mokesh-dahiman/` is measured separately (out of rollup per team_90 §6) — a full content-diff run post-T1 shows **17/17 measured gate-PASS**.

- **AC-001 (T1):** `node scripts/qa/content-diff.mjs --base $BASE --out <evidence>` → `/eyal-amit/` section% = 100; 16/16 rollup PASS and 17/17 measured gate-PASS; normalization code comment cites the DECISION artifact.
- **AC-002 (T2):** classification table covers all 19+9 findings; 0 genuine-broken images remain post-fix (`image-audit.cjs` re-run); mapping gaps documented to team_100; no lazy-load disabled.
- **AC-003 (T3):** for ALL 16 rollup routes + `/eyal-amit/mokesh-dahiman/`: `curl -s "$BASE<route>?nc=..." | grep -o 'name="description"' | wc -l` == 1, value non-empty and ≠ tagline; `php -l` clean.
- **AC-004 (T4):** `curl -s "$BASE/page-sitemap.xml"` contains none of the 14 redirect-source URLs nor `/sample-page/` nor `/wave2-test/`; every remaining `<loc>` returns direct HTTP 200; **`curl -s -o /dev/null -w '%{http_code}' "$BASE/sample-page/?nc=..."` ≠ 200 and same for `/wave2-test/`** (unpublish is independently observable); noise child-sitemaps absent from `sitemap_index.xml` where filterable; `grep ea-w2-17 scripts/ftp_deploy_site_wp_content.py` hits.
- **AC-005 (T5):** live home JSON-LD: ProfessionalService.areaServed = GeoCircle, geoMidpoint lat∈[32.4,32.5] lon∈[34.9,35.0], geoRadius 45000; prohibition lint (validation plan §3.4) 0 hits.
- **AC-006 (T6):** `docs/cutover/robots-production.txt` exists with 10 UA stanzas + Sitemap line; NOT referenced by any deploy script; `curl -s $BASE/robots.txt` still block-all; C-1 provenance documented in COMPLETION_REPORT; `docs/cutover/WP012-CUTOVER-CHECKLIST.md` exists with the replace+umbrella-AC-07 step.
- **AC-007 (T7):** `node --check scripts/qa/seo_probe.mjs` clean; `scripts/qa/seo_probe.config.json` exists and covers every rollup route with an expected-`@type` set (no Service on `/method/` per DECISION §9); self-run vs staging exits 0; all 12 Appendix-B checks implemented (10-UA supersession noted in code); COMPLETION_REPORT names the check that catches pre-fix D-1.
- **AC-008 (T8):** validation-plan §4 steps 1–5 evidence captured per-path (CF7 submit success; wa.me prefilled + generate_lead; tel: presence + wiring; SMTP/anti-spam posture); any headless-infeasible step explicitly scoped out with named follow-up owner; no owner-less state remains (tasks.json carries owner+date).
- **AC-009 (T9):** draft artifact at `_COMMUNICATION/team_110/EN-REFRESH-DRAFT-WP-W2-17-2026-07-03.md` covering Mukesh lineage + cbDIDG intro + contact CTA, YMYL-safe; zero bytes deployed to `/en/` — verified by before/after hash of live `/en/` HTML (`curl -s "$BASE/en/?nc=..." | shasum`).
- **AC-010 (global):** `php -l` clean on every touched PHP file; `bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` → 0 FAIL; surgical per-file commits (never `git add -A`); site deploys via `scripts/ftp_deploy_site_wp_content.py` (upload-only) — the initial code wave ships as **one consolidated deploy**; §4.3/§4.4 remediation redeploys are permitted; any hub deploy uses `ftp_publish_eyal_client_hub.py --no-prune`.
- **AC-011 (global):** no "ready" message to Eyal from the builder — that determination belongs to the triple-PASS chain (team_90 re-audit → team_190/50 → team_00), unchanged.

## 3. Gate chain

```
L-GATE_SPEC  : this LOD400 + external validation panel — PASS_WITH_FINDINGS, remediated (§5)
L-GATE_BUILD : team_110 executes T1–T9 → self-verify per AC matrix → COMPLETION_REPORT to team_100
               (COMPLETION_REPORT must include: T1 non-brand residue section · T2 classification
                table · T6b C-1 provenance · T7 D-1-catching-check note · T8 scope-outs if any)
L-GATE_VALIDATE (leg 1) : team_90 CR-FINAL re-run — Cursor engine (IR#1) — content-diff (T1
               normalization submitted for ratification) + image re-audit (T2 classifications
               provided; carousel-click improvement recommended) + seo_probe.mjs (team_90
               RATIFIES the implementation against Appendix B — routing-deviation closure)
               + image-picker thumb-load/localStorage spot-check (team_90 carried finding §5)
Legs 2/3     : team_190 + team_50 June PASS stands; re-run only if team_90 finds new cross-cutting scope
READY        : only on triple-PASS → team_00 → Eyal
```

## 4. Orchestration

1. **Wave A (parallel, file-disjoint, no deploy):** T1 · T3-code · T4-code · T5 · T6a/T6c · T7-build · T9. Local gates: `php -l` / `node --check` per agent.
2. **Single consolidated deploy** (`ftp_deploy_site_wp_content.py`, carries T3+T4+T5) → T3/T4 REST steps (metadesc clear if chosen; unpublish test pages).
3. **Live verification loop:** AC-003/004/005/006 curls + AC-001 content-diff + AC-007 seo_probe self-run. Fail → fix → redeploy; **max 2 iterations per task**, then escalate in the completion report (watch ACF/DB shadowing per T3 risk note).
4. **Wave B (parallel, network):** T2 (browser verify + targeted fixes + redeploy if assets added) · T6b (FTP provenance) · T8 (lead-path tests).
5. **Close:** evidence bundle under `_COMMUNICATION/team_110/` (or `evidence/` subdir), COMPLETION_REPORT to team_100, request team_90 re-audit dispatch.

## 5. Spec-validation remediations

**2026-07-03 — External validation panel (L-GATE_SPEC).** Composition: 3 independent adversarial validator agents in contexts separate from the spec author (lenses: LOD400-canon conformance · factual grounding vs repo · completeness/scope vs both source reports), engine claude-code; true cross-engine validation remains team_90 (Cursor) at leg-1 per IR#1. Panel verdict: **PASS_WITH_FINDINGS ×3, 0 BLOCKING** — all findings remediated in rev 2 as follows:

| # | Finding (severity) | Remediation applied |
|---|---|---|
| 1 | T3 "Emitter B" mischaracterized — real second emitter is Yoast DB `_yoast_wpseo_metadesc`, seeded by `ea-m3-team80-placeholder-content-once.php:176-178` (MAJOR, factual+canon) | T3 fact base rewritten; fix channel = REST metadesc clear or cede-to-Yoast |
| 2 | T2 hero-video premise false — mp4 IS in-repo, git-tracked since 2026-06-16 (MAJOR, factual) | T2 rewritten: category (b)/(a) only, never (d); `<video>` blind-spot of audit tool noted |
| 3 | External AC labels (AC-04/07/09/12) pathless + colliding with local AC numbering (MAJOR, canon) | SSoT inputs list expanded (5 docs with paths); external refs prefixed "umbrella AC-xx"/"validation plan §x" |
| 4 | T9 deliverable path violated Directory Authority (team_110 writing to team_100 dir) (MAJOR, canon) | Path → `_COMMUNICATION/team_110/` |
| 5 | WP012 cutover checklist artifact didn't exist as a writable target (MAJOR, canon) | T6c: `docs/cutover/WP012-CUTOVER-CHECKLIST.md` create-if-missing, team_100 ratifies |
| 6 | AC-004 didn't observe the unpublish independently (MAJOR, canon) | live ≠200 checks added for both test pages |
| 7 | L-GATE_SPEC self-validation ambiguity (MAJOR, canon) | This § records the independent panel composition; gate line updated |
| 8 | T7 routing deviation from team_80 §5.5 unrecorded; no team_90 ratification of the probe (MAJOR, completeness) | Deviation recorded in T7; gate chain adds team_90 ratification of seo_probe |
| 9 | AC-008 narrowed AC-12 to CF7 only, dropping wa.me/tel per-path steps (MAJOR, completeness) | T8/AC-008 extended to validation-plan §4 steps 1–5 per-path + explicit scope-out rule |
| 10 | Deploy-list line range stale (:108-123 → :108-136) (MINOR) | Corrected in T4 |
| 11 | "16 in-scope" vs 17-measured ambiguity; grep -c counts lines not tags (MINOR) | Route-set definition added in §2; AC-003 uses `grep -o \| wc -l` and includes mokesh |
| 12 | Appendix-B check-2 "8 UAs" vs ratified 10 (MINOR) | Supersession stated in T7 + AC-007 |
| 13 | seo_probe.config.json implied pre-existing; D-1-catch proof missing from AC (MINOR) | T7/AC-007: builder authors manifest; D-1 check named in COMPLETION_REPORT |
| 14 | AC-009 unverifiable (draft completeness, /en/ untouched) (MINOR) | Completeness criteria + live-HTML hash check added |
| 15 | AC-010 "one deploy" contradicted §4 remediation loops (MINOR) | Reworded: initial wave consolidated; remediation redeploys permitted |
| 16 | T1 residue + T6b provenance had no named artifact (MINOR) | Both routed into COMPLETION_REPORT (gate chain lists required sections) |
| 17 | C-2 `/method/` Service-node decision would be silently encoded by T7 manifest (MINOR, completeness) | Decided: DECISION §9 (not a Service); T7 manifest instruction added |
| 18 | C-3 child-sitemap noise dropped from the D-2 pass (MINOR, completeness) | Folded into T4 + AC-004 |
| 19 | S004 umbrella + 13 sub-WP DB registration disposition unstated (MINOR, completeness) | Carried: queued behind the same API field-mapping bug documented in the WP-W2-17 roadmap note; re-attempt when API fixed (team_100/team_110) |
| 20 | team_90 carried finding (image-picker thumb-load/localStorage) dropped (MINOR, completeness) | Added to the team_90 re-audit scope in the gate chain |
