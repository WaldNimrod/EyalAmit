---
id: SEO-GEO-RESEARCH-SYNTHESIS-2026-07-02
from_team: team_80 (Research — advisory, not part of the gate process)
to_team: team_100 (Chief Architect) — routing per mandate; completion notice to team_00
date: 2026-07-02
wp: none (S004-P001-WP000 is FILE-CANONICAL ONLY — not DB/roadmap-registered; `_aos/roadmap.yaml:9` active_milestone: S003)
mandate_ref: _COMMUNICATION/team_100/MANDATE-TEAM80-SEO-GEO-RESEARCH-2026-07-02_v1.0.0.md
engine_method: manual_hybrid + limited WebSearch — recommended by team_100, CONFIRMED by team_00 (Nimrod) in-session 2026-07-02 per ADR046 §2.6, before execution began. 2 of ≤5 permitted web queries used (D3 UA-token currency only; D12 resolved from in-repo evidence).
type: research-synthesis
verdict: ADVISORY — options + one recommendation per open item; no gate authority
sources_policy: every claim carries a repo-relative file:line citation or a URL + retrieval timestamp. Live checks: HTTP GET against staging 2026-07-02T20:40–20:55Z, raw responses archived in the session scratchpad evidence dir.
---

# SEO/GEO Research Synthesis — S004 program state, open decision gates, live verification

> **Identity (team_80 Iron Rule 6):** team_80 · group: research · profession: researcher · engine: claude-code (this session). Advisory only — findings route to team_100; nothing here is a gate verdict.

## §0 Executive summary

**The corpus tells one clear story, and the live site confirms it: the SEO/GEO *machine layer* is essentially shipped and verified; the remaining value is in the *content + media + off-site* layers, which are almost entirely gated on Eyal** (`_COMMUNICATION/team_100/COMPLETION-ROUND-ROADMAP-2026-06-20.md:100`). Wave-1, Wave-1b and Round-2 are all merged to `main` with cross-engine dual-PASS; the extended Yoast `@graph` (Person + ProfessionalService + Service-per-route), GA4 + `generate_lead`, og:image, per-post meta and the brand-string removal were all re-verified live today.

One-line recommendations for every open item (full analysis in §3–§4):

| Open item | Recommendation |
|---|---|
| **D2** geo radius | Adopt **bounded GeoCircle** now: midpoint = the already-public studio address (עמל 8 ב' פרדס חנה), radius **45 km** (Hadera–Haifa–Sharon catchment); ratify against the GBP service area when WP009 claims GBP. |
| **D3** GPTBot | **Explicit Allow + log the decision.** Allow all 8 named UAs incl. GPTBot; blocking training bots buys nothing for a discovery-first brand and user-fetchers bypass robots.txt anyway. |
| **D12** keyword volumes | **GSC-first.** Ship WP010 phase-1 scoped to the 3 strategy-justified spokes (no volume data needed); size phase-2 from real GSC queries 4–8 weeks post-cutover. No paid tool. |
| **D13** English site | **EN out-of-scope.** `/en/` verified technically correct today — keep it that way, invest nothing; revisit only if post-cutover AI-referral data shows EN demand. |
| **AC-12** lead receipt | Split it: **staging-provable half NOW** (owner: team_100 accountable, team_10+uPress ops executing, Eyal confirms inbox via team_00; target ≤2026-07-09), production re-run stays in the WP012 cutover checklist. |
| **Task-4 verdict** | Signals hold, with **2 real drift findings** (duplicate/zero meta descriptions on service routes; 14 redirected + 2 test URLs polluting the sitemap) and **1 cutover-critical flag** (a block-all robots.txt is live on staging — provenance must be identified before cutover). |

**Top-3 movable-now actions:** (1) team_00/100 ratify D2/D3/D12/D13 from this report — none needs Eyal; (2) fix the meta-description drift + sitemap hygiene (small WP-04/WP-12-scope code fixes, team_10); (3) name the AC-12 owner and run the staging lead-deliverability test this week. The single highest-leverage *Eyal* unblock remains approving the 15 content proposals, above all **CP-01** (`hub/data/eyal-needs.json:7,18`).

**Governance note:** the hub API/DB is **ONLINE today** (health probe 2026-07-02: `db.status: online`, PostgreSQL 16.13 — §5.4). The S004 program's file-canonical status was premised on the DB being offline/blocked (`WP-S004-P001-WP000-SEO-GEO-FINALIZATION-2026-06-20.md:15-16`). team_100 should verify whether the team_110 actor-key blocker has lifted and run the queued one-pass DB registration.

---

## §1 Method & evidence base

- **Method:** `manual_hybrid` + limited WebSearch, recommended by team_100 in the mandate (`MANDATE-TEAM80-SEO-GEO-RESEARCH-2026-07-02_v1.0.0.md` §Engine method) and **confirmed by team_00 in-session on 2026-07-02 before execution** (ADR046 §2.6 satisfied). Web budget used: 2 of ≤5 queries, both for D3 UA-token currency; D12 needed no web input.
- **Corpus read in full:** the umbrella WP, LOD400 strategy, execution plan, validation-deployment plan, Wave-1 scope, both validation mandates + Round-2 completion + continuation handoff + completion-round roadmap + chapters closeout, the 2026-03-31 audit, Eyal's dev brief + requirements baseline + the 2026-04-10 delta, and `hub/data/{content-proposals,decisions,tasks,eyal-needs,materials-needed,updates,meeting-brief}.json`.
- **Live checks:** HTTP GET (curl) against `http://eyalamit-co-il-2026.s887.upress.link` on 2026-07-02T20:40–20:55Z with cache-busting `?nc=` params; raw responses archived in the session scratchpad (`evidence/`). HTTP-only per CLAUDE.md staging-TLS discipline; curl is the correct tool here (schema/headers/robots — not layout).
- **Git verification:** all Wave-1/Wave-1b/Round-2 commits (`0ce1f41`, `5f4110f`, `5b0493c`, `c9827e3`, `32eefde`) confirmed **ancestors of `main`**; branches since deleted; all four SEO mu-plugins present in-repo (`site/wp-content/mu-plugins/`).
- **Citation-anchor corrections** (both verified this session; earlier maps pointed elsewhere): the D1–D13 decision ledger **with statuses** lives in the umbrella WP §8 (`WP-S004-P001-WP000-SEO-GEO-FINALIZATION-2026-06-20.md:166-184`), not in the LOD400 file; AC-12's verbatim text is umbrella `:131`, not the validation-deployment plan. Beware two unrelated "AC-12" strings in April Hub-V2 artifacts and the separate **AC-12b** (`:132`).

---

## §2 Current-state synthesis (Task 1)

### §2.1 The 13 S004 sub-WPs

Program: `WP-S004-P001-WP000-SEO-GEO-FINALIZATION-2026-06-20.md` (sub-WP table `:48-62`; **file-canonical only** `:15-16` — every status below is file-evidence-based, none is DB-registered). Execution evidence: Wave-1 dual-PASS (`HANDOFF_100_SEO-GEO-CONTINUATION_2026-06-20_v1.md:15`, `_COMMUNICATION/team_190/VERDICT_WP-S004-P001-WP000-WAVE1_FINAL_v1.md`), Wave-1b dual-PASS 2026-06-21 (`COMPLETION-ROUND-ROADMAP-2026-06-20.md:116-121`, `_COMMUNICATION/team_190/VERDICT_WP-S004-P001-WP000-WAVE1B_FINAL_v1.md`), Round-2 (`SEO-GEO-ROUND2-COMPLETION-2026-06-21.md`), chapters post-deploy PASS (`_COMMUNICATION/team_190/VERDICT_CHAPTERS-FULLSITE_POSTDEPLOY_2026-06-23.md`).

| Sub-WP | Title (short) | Status | Evidence |
|---|---|---|---|
| WP001 | Conversion repair + analytics un-gate | **in-progress** — built + staging-verified; only the AC-12 *receipt* half open | Built/merged: Wave-1 W1-01/13/01t (`MANDATE-VALIDATE-WAVE1-SEO-GEO-2026-06-20.md:9-11`); GA4 live today (evidence log §A); `generate_lead` fired + CF7 form present (`VERDICT_CHAPTERS-FULLSITE_POSTDEPLOY_2026-06-23.md:106-110`); `hub/data/tasks.json` → `M5-T-LEAD-TRACKING: in_progress`; receipt half = §4 |
| WP002 | Extend Yoast `@graph` | **in-progress** — Person/ProfessionalService/Service live-verified today; FAQPage, ImageObject, VideoObject hooks and the geo node NOT built | Live graph per page type (§5.1); code map `site/wp-content/mu-plugins/ea-w2-seo-schema.php:40-105`; FAQPage = zero occurrences in theme/mu-plugins (grep, 2026-07-02); geo node **blocked by D2** (umbrella `:171`) |
| WP003 | Sleep-apnea pillar + press kit | **blocked-on-Eyal** (CP-01 approval) + **open-decision** DEC-SEO-B1 (injector/URL) | `hub/data/content-proposals.json:5-15` (CP-01, incl. the injector question in `eyal_decision`); umbrella `:183` DEC-SEO-B1 "OPEN — RECORD AT BUILD"; `tasks.json` → `M5-T-SEO-PILLAR: not_started` |
| WP004 | Crawl-policy + meta head pack | **in-progress** — per-route meta (Wave-1b), og:image (Round-2), hreflang, per-post meta all live-verified; production robots.txt cutover-gated + **blocked by D3**; NEW drift found today (§5.2 D-1) | Wave-1b batch (`COMPLETION-ROUND-ROADMAP-2026-06-20.md:78,82`); og:image live + resolves 200 (§A); AC-19 holds live (blog post desc=1, §A); robots spec `SEO-GEO-EXECUTION-PLAN-2026-06-20.md:78` |
| WP005 | Image hygiene + WebP/LCP | **open (deliberately deferred, non-blocked)** | Deferred by decision: `SEO-GEO-ROUND2-COMPLETION-2026-06-21.md:13`; `COMPLETION-ROUND-ROADMAP-2026-06-20.md:84` (marginal CWV gain + layout risk) |
| WP006 | NAP lock + brand removal + geo layer | **done (on-site half)** — 1 open disposition with Eyal; geo layer waits on D2/WP009 | Brand string = 0 live occurrences incl. seeded QR32, DB migration ran (`SEO-GEO-ROUND2-COMPLETION-2026-06-21.md:20`); NAP verified on `/contact/` today (E.164 + עמל 8, §A); heading disposition (a)/(b) tracked to Eyal as `OPEN-BRAND-RETIRED` (`hub/data/eyal-needs.json:100-104`); `tasks.json` → `M5-T-CONTACT-NAP: completed` |
| WP007 | Video facade + transcripts + VideoObject | **in-progress** — 60 QR embeds → youtube-nocookie shipped; facade/thumbnail deferred; transcripts + VideoObject not built; memorial film **blocked-on-Eyal** (EYL-2) | `SEO-GEO-ROUND2-COMPLETION-2026-06-21.md:21` (nocookie), `:13` (facade deferred); EYL-2 `COMPLETION-ROUND-ROADMAP-2026-06-20.md:16` |
| WP008 | Honest commerce schema + buying guide | **in-progress** — is_numeric Product/Offer code shipped (Wave-1 W1-08) and behaving correctly live (no Product where no numeric price, §A); **prices blocked-on-Eyal**; buying-guide content not built | `MANDATE-VALIDATE-WAVE1-SEO-GEO-2026-06-20.md:13`; live check `/books/vekatavta/` + `/didgeridoos/` (§A); prices: `COMPLETION-ROUND-ROADMAP-2026-06-20.md:95` |
| WP009 | Off-site authority (GBP/Wikidata/dirs/YT) | **blocked-on-Eyal** (Google/Wikidata account access) | `COMPLETION-ROUND-ROADMAP-2026-06-20.md:97`; umbrella `:107` |
| WP010 | Blog hub-and-spoke cluster | **blocked-on-Eyal** (BLOG-01..04 approvals) + **open-decision** D12 (sizing) | `hub/data/content-proposals.json:127-169`; umbrella `:181` |
| WP011 | Digital-PR + reviews + mentions | **blocked** (depends on WP003 press kit + Eyal/owner actions) — not started | Dependency: umbrella `:154`; owner-dependence `SEO-GEO-EXECUTION-PLAN-2026-06-20.md:92` |
| WP012 | Cutover (Track B, gated) | **open — gated, not started** (M7); today's findings add 3 checklist items (§5.2–§5.3) | `hub/data/tasks.json` M7 tasks all `not_started`; gate spec `SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md:157-215` |
| WP013 | Measurement + KPI baseline + AI-citation audit | **in-progress** — `generate_lead` wired + verified; baseline is cutover-gated by design; quarterly audit not started | `VERDICT_CHAPTERS-FULLSITE_POSTDEPLOY_2026-06-23.md:110`; baseline-at-cutover rule `SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md:25,61` |

### §2.2 The 15 content proposals — all blocked-on-Eyal

`hub/data/content-proposals.json` (generated 2026-06-20) holds exactly 15: **CP-01** (sleep-apnea pillar), **AF-01..04** (answer-first blocks for /treatment, /method, /sound-healing, /lessons), **BN-01..03** (brand reframe: footer, bio, titles/meta), **FAQ-01..03** (sleep-apnea long-tail, cbDIDG/rebirthing disambiguation, geo/practical), **BLOG-01..04** (spokes). Zero are approved: `hub/data/tasks.json` → `M5-T-CONTENT-PROPOSALS: not_started`, "ממתין לאייל — במיוחד CP-01" (`tasks.json:395-400`); every P1 item `status: open` (`hub/data/eyal-needs.json:21-57`). CP-01 is flagged as the #1 organic-traffic + AI-citation lever in three independent places: `content-proposals.json:11`, `eyal-needs.json:7,18`, umbrella `:30`. Status: **15/15 blocked-on-Eyal** — the hub intake page (`content-proposals.html`) is live and was the #1 agenda item of the 2026-06-23 meeting (`hub/data/meeting-brief.json:13`).

Note for team_100: BN-01/BN-02's *site-side* implementation already shipped in Round-2 (brand string removed live, `SEO-GEO-ROUND2-COMPLETION-2026-06-21.md:20`) — what remains open with Eyal is the *approval/alternative-wording* layer (`eyal-needs.json:86-104` P3), and BN-03 (titles/descriptions wording) is genuinely unbuilt.

### §2.3 The 5 locked decisions — referenced, not reopened

All five are `status: approved` in `hub/data/decisions.json` and none is contradicted by the live site:

| Decision | Locked resolution (source) | Live cross-check today |
|---|---|---|
| D-EYAL-SITE-07 | Hub site tree = IA source of truth, locked 2026-04-06 (`decisions.json:10-18`) | — |
| D-EYAL-CONTENT-MODEL-09 | Two public slugs: `blog` + `media` (`decisions.json:43-50`) | `/blog/` 200 in sitemap; `/media/` 200 (§A sweep) |
| D-EYAL-MENU-BRAND-10 | Menu says «השיטה»; cbDIDG in hero/method page (`decisions.json:53-60`) | — |
| D-EYAL-ENTITY-CATALOG-12 | Unified model, 3 footer catalogs: faq/galleries/media (`decisions.json:106-114`) | `/faq/`, `/galleries/`, `/media/` all 200 (§A sweep) |
| D-EYAL-ABOUT-URL-15 | `/eyal-amit` canonical; `/about` reversed to 301 (`decisions.json:149-157`) | **Verified live:** `/eyal-amit/` 200 direct; `/about/` → 301 → `/eyal-amit/`; `/about/moksha/` → 301 → `/eyal-amit/mokesh-dahiman/` (§A) |

### §2.4 Reconciliation notes (where governance docs lag reality)

1. **D10 (Mukesh memorial) is content-only open, and even that has narrowed.** The LOD400's D10 (`LOD400-SEO-GEO-OPTIMIZATION-2026-06-19.md:183`) reads as fully open; the umbrella re-scoped it — slug CLOSED in code at `/eyal-amit/mokesh-dahiman/` (`WP-S004-…:179,253`); and hub decision **D-EYAL-MOKESH-16 is `approved`** (content source: build from the existing doc now, Eyal's final verbal approval after staging view — `decisions.json:160-168`). What genuinely remains of D10: EYL-2 (the full-film public link, `COMPLETION-ROUND-ROADMAP-2026-06-20.md:16`) + Eyal's final pass on the built page (`eyal-needs.json:139-144` `OPEN-MOKESH-FINAL`). Do not re-report D10 as an open decision gate.
2. **The "0% schema" premise is dead** and the execution plan itself says so: Yoast SEO v27.8 is the live schema engine; the mu-plugin **extends** its single `@graph` (`SEO-GEO-EXECUTION-PLAN-2026-06-20.md:11-12`; umbrella Appendix B `:271-285`). Verified live again today (§5.1). Any reader of the LOD400 must apply this correction.
3. **File-canonical vs DB:** `_aos/roadmap.yaml:9` still says `active_milestone: S003`, `_aos/work_packages/` holds S001–S003 only — consistent with the umbrella's file-canonical banner. **But the DB-offline premise has changed:** live health probe today returned `db.status: online` (§5.4). The one-pass S004 registration queued in umbrella `:16` should be re-attempted once team_110 confirms the actor key.
4. **AC-09's brand-absence gate was re-scoped** to the site's own voice: 6 verbatim customer testimonial quotes legitimately retain the old brand string (`SEO-GEO-ROUND2-COMPLETION-2026-06-21.md:35`) — a validator running `--absent 'סטודיו נשימה מעגלית'` naively will false-fail.

---

## §3 The four open decision gates (Task 2)

Ledger source for all four: umbrella §8, `WP-S004-P001-WP000-SEO-GEO-FINALIZATION-2026-06-20.md:171,172,181,182`. All four are ratifiable by team_00/team_100 — **none needs Eyal**, except one optional sub-input on D2.

### §3.1 D2 — areaServed / geo for the business schema node (blocks the WP002 geo layer)

Ledger text: "Bounded GeoCircle around Pardes Hanna (north/center) = GBP service area; NOT `areaServed:Israel`; no precise geo until lat/long supplied" (`:171`). Prohibitions already locked by AC-04 (`:123`): no `areaServed:Israel`, schema areaServed must equal the GBP service area (AC-09, `:128`).

| Option | Pros | Cons |
|---|---|---|
| **A. Bounded GeoCircle** — `geoMidpoint` = studio coordinates, `geoRadius` ~45 km | Matches the ledger's own lean; one schema node; expresses "clients come to me from the north/center" truthfully; trivial to adjust radius later | Needs a lat/long + radius value; GBP models service areas as localities, so circle↔GBP parity is approximate |
| **B. Named-locality list** (`areaServed`: Pardes Hanna-Karkur, Hadera, Zichron, Caesarea, Netanya, Haifa…) | Mirrors GBP's locality model 1:1; no coordinates | List curation is a judgment call (invites re-litigating); verbose; higher maintenance |
| **C. Defer geo entirely** (PostalAddress only, already live) | Zero new decisions | Leaves WP002 permanently partial; forgoes the local-pack signal the strategy explicitly wants (LOD400 `:97`) |

**Recommendation: Option A.** The "no precise geo until lat/long supplied" guard is effectively satisfied: D6 is CLOSED as SHOW-address (`:175`), the street address עמל 8 ב' פרדס חנה is already published on `/contact/` and inside the live `#business` schema node (verified today, §A) — coordinates of a published address add no privacy exposure. Concrete values to ratify: midpoint = the studio address geocoded, radius **45 km** (covers the Hadera–Haifa–Sharon catchment named in LOD400 `:97` without claiming all-Israel). Ratifier: team_100 structurally; give Eyal a one-line FYI (not a decision) unless he objects to map-pin precision. When WP009 claims GBP, set the GBP service area to the same catchment and adjust the circle if they diverge (AC-09 parity).

### §3.2 D3 — GPTBot allow/block in robots.txt (blocks the WP004 robots posture)

Ledger: "OPEN (recommend allow) — Log it; OAI-SearchBot/ChatGPT-User allowed regardless" (`:172`). Strategy context: LOD400 §5 crawler policy (`LOD400-SEO-GEO-OPTIMIZATION-2026-06-19.md:83`) — the must-allow set is the *citation/user* channel; Googlebot (not Google-Extended) feeds AI Overviews; the ~27% CDN/WAF accidental-block trap is the real operational risk (umbrella `:201`).

Web verification (2026-07-02): the UA token set in the WP-04 spec is still current. OpenAI operates exactly three tokens — GPTBot (training), OAI-SearchBot (search index/citations), ChatGPT-User (user-initiated fetch) — each needing its own robots.txt entry ([OpenAI crawler docs](https://developers.openai.com/api/docs/bots)). Anthropic mirrors this: ClaudeBot (training), Claude-SearchBot (search index), Claude-User (user fetch) ([Search Engine Land](https://searchengineland.com/anthropic-claude-bots-470171)). Perplexity: PerplexityBot + Perplexity-User, and **Perplexity-User generally does not honor robots.txt** ([xSeek reference](https://www.xseek.io/docs/claude-user-agents); [2026 UA landscape](https://nohacks.co/blog/ai-user-agents-landscape-2026)). Also relevant: 2.5M+ sites now default-block AI training via managed robots/CDN rules (Cloudflare, Aug 2025 — same landscape source) — which is precisely why an *explicit* allow posture, verified with the AC-07 day-one curl matrix, matters more in 2026 than it did when the plan was written.

| Option | Pros | Cons |
|---|---|---|
| **A. Explicit Allow-all 8 UAs incl. GPTBot, logged** | Discovery-first objective (the site's *only* objective, umbrella `:22`); training inclusion helps an unknown brand get *known* by models; explicit stanzas double as documentation and satisfy "Log it"; trivially reversible (one line) | Content becomes training data (no proprietary-content concern exists in this corpus) |
| **B. Block GPTBot/ClaudeBot (training), allow citation bots** | Principled "citations yes, training no" stance | Directly contradicts the discovery objective; zero documented business rationale; user-fetchers bypass robots.txt anyway, so the "protection" is thin |
| **C. Silent default-allow (no GPTBot stanza)** | Same effect as A, less UA maintenance | Fails the ledger's own "Log it" requirement; invisible posture = accidental-flip risk at CDN/WAF level goes unnoticed |

**Recommendation: Option A** — explicit Allow for Googlebot, Bingbot, GPTBot, OAI-SearchBot, ChatGPT-User, ClaudeBot*, Claude-SearchBot, Claude-User, PerplexityBot, Perplexity-User + `Sitemap: https://www.eyalamit.co.il/sitemap_index.xml`, recorded as DEC-D3 in the umbrella ledger. (*ClaudeBot = Anthropic's training bot, the D3 logic extends to it identically.) Re-verify exact tokens at WP-04 build (the spec already requires this, `SEO-GEO-EXECUTION-PLAN-2026-06-20.md:78`) and run the AC-07 day-one 200-curl matrix at cutover (`SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md:112-125`). Ratifier: team_00/team_100; no Eyal input needed.

### §3.3 D12 — Hebrew keyword-volume verification method (blocks WP010 sizing only)

Ledger: "Verify in GSC/Keyword Planner **before** sizing WP010 word/article count; or scope WP010 phase-1 to the 3 strategy-justified spokes… that need no volume data" (`:181`). Context: the niche-demand ordering is SERP-inferred, explicitly flagged uncertain (`LOD400-…:13`); WP010 is the single largest content effort (effort H, `SEO-GEO-EXECUTION-PLAN-2026-06-20.md:63`).

| Option | Pros | Cons |
|---|---|---|
| **A. GSC-first + 3-spoke phase-1** — ship the sleep-apnea, cbDIDG, and rebirthing-disambiguation spokes now (they're justified by strategy, not volume); collect 4–8 weeks of real production GSC query data post-cutover; size phase-2 from it | Zero cost; measures *real* demand rather than tool estimates; matches the ledger's own hedge; nothing blocks today | Full cluster sizing waits for cutover + dwell time |
| **B. Google Keyword Planner now** | Pre-cutover numbers; named in the ledger | Hebrew low-volume niches get bucketed/unreliable KP data; requires a Google Ads account (owner ask); numbers would be directional at best |
| **C. Paid third-party tool (Ahrefs/Semrush)** | Fast, richer UI | Worst Hebrew low-volume coverage of the three; cost conflicts with team_80's credit-conservation rule and the program's cheap-moves philosophy |

**Recommendation: Option A.** Note the elegant alignment: the 3 strategy-justified spokes are exactly BLOG-01/02/03 of the pending proposals — so phase-1 needs **Eyal's content approval, not volume data**, and D12 stops being a blocker at all until phase-2. If an Ads account already exists when WP009 touches Google properties, run KP as a free sanity check — do not create an account for it. Ratifier: team_100. No web research was needed for this gate; the in-repo evidence is decisive.

### §3.4 D13 — English-site SEO investment (posture; blocks nothing hard)

Ledger: "OPEN (recommend EN out-of-scope) — keep `/en` correct (hreflang/lang/dir), do not invest content; Qwoted EN channel bonus-only" (`:182`). Related locked context: D-EYAL-EN-BODY-02 already defers EN body copy to the final phase (`hub/data/decisions.json:63-71`); EN content investment is on the umbrella's explicit out-of-scope list (`:40`).

| Option | Pros | Cons |
|---|---|---|
| **A. EN out-of-scope, keep `/en` technically correct** | Aligned with the Hebrew-local lead objective, the locked deferral, and the out-of-scope list; verified cheap to maintain — today `/en/` already emits `lang="en" dir="ltr"`, reciprocal en/he/x-default hreflang, 1 meta description, full Yoast graph (§A) | Forgoes the international didgeridoo long-tail |
| **B. One-page EN refresh** (Mukesh lineage + cbDIDG intro) | Small fixed cost; captures EN brand searches | YMYL claim-review cost per language; needs Eyal-approved EN copy — a new content gate for marginal demand |
| **C. Full EN mirror** | — | Reject: large effort, no demand evidence, doubles the YMYL review surface |

**Recommendation: Option A**, with a data-triggered revisit: WP013 already tracks AI-referral sessions by landing page (`SEO-GEO-EXECUTION-PLAN-2026-06-20.md:96`) — if post-cutover data shows meaningful EN-language referrals landing on `/en/`, promote Option B then. Ratifier: team_00/team_100.

### §3.5 Fifth open gate found in the ledger (in-scope flag)

**DEC-SEO-B1 — pillar injector/URL** is also still "OPEN — RECORD AT BUILD" (`:183`): top-level `/sleep-apnea-snoring` (fits the existing `wave2-w2-04.php` `post_parent===0` injector) vs extending the injector for a child URL. It is deliberately a record-at-build decision and CP-01's `eyal_decision` block already surfaces it (`content-proposals.json:14`). team_80 advisory view: **top-level** is the lower-risk path (no injector surgery; the umbrella's own AC-06 accepts either, `:125`) — but this belongs to team_100 at WP003 build time, not to this report to close.

---

## §4 AC-12 ownership gap (Task 3)

**The criterion** (umbrella `:131`, verbatim core): a real test lead via **each** path — CF7 form, pre-filled `wa.me`, `tel:` — confirmed **received by Eyal** (inbox, not spam) **and** GA4 `generate_lead` fires for each; "**Named ops-task placeholder (owner/date TBD — team_00)… this is the only AC with no owned deadline and gates the entire go-live**." The umbrella's own critic ranks it the least-owned most-consequential gate (`:266`); the validation plan devotes §4 to it (`SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md:98-108`) and requires it **before WP001 closes AND again post-cutover**.

**What the evidence already shows (staging, verified):**
- CF7 form **present** on `/contact/`, WhatsApp link carries `?text=`, and `generate_lead` **fired** on click — team_190, 2026-06-23 (`VERDICT_CHAPTERS-FULLSITE_POSTDEPLOY_2026-06-23.md:106-110`, evidence `function/contact_whatsapp_probe.json`).
- GA4 `G-MRXESK7QJF` loads independently of the still-pending Clarity (live today, §A; D11 closed `:180`).
- Graceful degradation (AC-12b) formalized as already-true (`:132`).

**What has never been proven (the actual gap):** the *receipt* half — a submitted CF7 lead landing in **Eyal's real inbox, not spam** (SMTP/deliverability + honeypot/Turnstile posture on uPress), and real-device wa.me/tel taps. Nothing in `tasks.json`, the roadmap register, or any verdict names an owner or date for this (cross-checked: `M5-T-LEAD-TRACKING: in_progress` carries "אימות end-to-end ב-cutover" with no owner, `tasks.json:402-407`; `businessLeversHe` WP-01 same, `eyal-needs.json:8`). **Deliberate boundary:** Clarity (`M5-T-ANALYTICS`, EYL-1) is adjacent analytics, **not** part of AC-12 — GA4 already fires without it; do not couple them.

**Recommended ownership + next step (Option-set considered: team_100-owned / team_10-owned / defer-to-cutover; recommendation below is the first):**
- **Accountable owner: team_100** — it owns the cutover gate, the file-canonical ledger, and per its charter the "route-inventory + verification contract" of the umbrella (`:36`). AC-12 is a *verification* obligation, which is why leaving it to the build team left it orphaned.
- **Executing:** team_10 + uPress ops (CF7 activation state, SMTP/deliverability config, honeypot/Turnstile) — the validation plan already labels this "a named ops/hosting task, not assumed confirmed" (`:108`).
- **Human verifier:** Eyal confirms inbox receipt (a 2-minute WhatsApp ask), coordinated by team_00 — the only part of AC-12 that touches Eyal, and it is trivial.
- **Dates:** run the **staging-provable half now — target ≤2026-07-09** (validation-plan §4 protocol pointed at staging; nothing about it requires production), and keep the **production re-run** where it already lives: WP012 cutover checklist item 12 (`:212`).
- **Concrete next step for team_100:** register the named ops-task file-canonically (one line in the umbrella ledger + owner/date into `M5-T-LEAD-TRACKING.stateHe`), then execute validation-plan §4 steps 1–5 on staging with Eyal's real recipient address. If the DB registration unblocks (§5.4), register it as a canonical task in the same pass.

---

## §5 Live dev-site verification (Task 4)

Base: `http://eyalamit-co-il-2026.s887.upress.link`, HTTP GET, 2026-07-02T20:40–20:55Z, cache-busted. Full raw log: §Appendix A. Staging noindex and staging-capped Lighthouse SEO scores are **expected/correct** per `SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md:25` and `CLOSEOUT_CHAPTERS-FULLSITE_POSTFIX_DEPLOY_E2E_2026-06-23.md:54` — none of them is reported as a defect below.

### §5.1 Signals that HOLD (answer to the mandate's three questions: yes, yes, yes)

| Signal | Result | Matches |
|---|---|---|
| Yoast JSON-LD `@graph` present + extended | Every checked page emits one graph: `WebPage/BreadcrumbList/WebSite` (Yoast) + `Person` + `ProfessionalService` (mu-plugin, global) | `ea-w2-seo-schema.php:40-85`; Appendix B correction still accurate |
| Per-page typing | `Service` node on `/treatment/`, `/sound-healing/`, `/lessons/` (exactly the coded slug map — `/method/` intentionally not in it); `Article` (+author `Person`) on blog posts — Yoast-native; **FAQPage absent on `/faq/` = expected** (un-built WP002 remainder, zero occurrences in code); Product absent where no numeric price = **correct** honest-commerce behavior (prices are Eyal-gated) | `ea-w2-seo-schema.php:86-105,108-135`; `COMPLETION-ROUND-ROADMAP-2026-06-20.md:95` |
| Staging noindex mu-plugin | `<meta name='robots' content='noindex, nofollow…'>` present + `X-Robots-Tag: noindex, nofollow` response header + `Cache-Control: no-cache…` — **correct on staging** (belt-and-braces; the header layer comes from the host/edge on top of the mu-plugin's `wp_robots` meta) | `ea-staging-noindex.php:38-46,51-63` |
| robots.txt | present (see FLAG C-1 §5.3) | — |
| `/sitemap_index.xml` | 200, Yoast index, 10 child sitemaps; `/wp-sitemap.xml` → 301 → it — DEC-SEO-B2 holds | `SEO-GEO-EXECUTION-PLAN-2026-06-20.md:161` |
| `/llms.txt` | 404 — **correct** (explicit SKIP) | umbrella `:40`; LOD400 `:89` |
| og:image (Round-2 residual) | **Deployed and live**: exactly 1 `og:image` per checked page (default `eyal-portrait-hero.jpg`), resolves HTTP 200 (173 KB) — the FTP-outage gap from `SEO-GEO-ROUND2-COMPLETION-2026-06-21.md:26` is closed by the 06-23 full theme sync | `CLOSEOUT_…_2026-06-23.md:18`; commit `c9827e3` ancestor of main (git-verified) |
| AC-19 per-post meta | Blog post emits exactly 1 `<meta name="description">` | Round-2 `:19` |
| hreflang / `/en/` | `lang="en" dir="ltr"`; reciprocal en/he/x-default `<link>` pairs on home + `/en/` | LOD400 T19 (`:73`) |
| GA4 | `G-MRXESK7QJF` in home head | D11 closed (`:180`) |
| D-EYAL-ABOUT-URL-15 | `/eyal-amit/` 200 direct; `/about/` and `/about/moksha/` are single-hop 301 sources to their canonical targets | `decisions.json:149-157` |
| NAP (AC-09 posture) | `/contact/` carries `+972-52-482-2842` and עמל 8 in visible copy + schema | `BUSINESS-NAP-AND-HOURS-2026-06-16.md` (SSoT) |

### §5.2 DRIFT — two real regressions found (route to team_100 → team_10; small fixes)

- **D-1 · Meta-description drift on the service routes.** Today: `/treatment/`, `/sound-healing/`, `/lessons/` each emit **2** different `<meta name="description">` tags; `/method/` emits **0**. This contradicts the state team_50 verified on 2026-06-21 ("meta 13/13… no dup", `COMPLETION-ROUND-ROADMAP-2026-06-20.md:109`) and Appendix B's no-duplication claim (umbrella `:278`). Most plausible cause: the chapters full-site rebuild (deployed 2026-06-22/23) layered its `phero.sub`-derived description (the F110-01 mechanism, `CLOSEOUT_…_2026-06-23.md:19`) on top of the existing `ea_w2_09_route_description()` map on three routes, while `/method/` fell through both. Duplicate descriptions are ignored-at-best, conflicting-at-worst for snippet selection; a route with zero ships tagline-fallback risk at cutover. **Fix scope: WP-04 (one description per route, single source of truth) — pure code, no Eyal input.**
- **D-2 · Sitemap hygiene.** The page-sitemap (102 URLs) contains **14 URLs that are 301 sources** (all `/services/*`, `/muzza/*`, `/muzeh/*`, `/about/`, `/about/moksha/`, `/hashita/`, `/courses-soon/` — each verified single-hop to the correct canonical target) plus `/sample-page/` and `/wave2-test/` as indexable 200s. Yoast lists them because the WP pages exist as published; the redirect mu-plugin 301s them at request time, so Yoast can't know. A sitemap listing redirects/test pages is exactly the "crawl noise / tight topic graph" problem the original audit flagged (`docs/project/AEO-GEO-READINESS-AUDIT-2026-03-31.md:132-141`). **Fix scope: exclude-from-sitemap (Yoast meta) or unpublish the shells — must land before the WP012 GSC sitemap submission.** Full list in Appendix A.

### §5.3 FLAGS — expected-but-must-be-managed

- **C-1 · Block-all robots.txt is live on staging.** `GET /robots.txt` returns `User-agent: * / Disallow: /` — byte-identical to the `hub/dist/robots.txt` artifact the program repeatedly warns about (umbrella `:25`; validation plan `:155`). On *staging* a block-all robots.txt is protective and consistent with the noindex posture — **not a defect today**. But its provenance is unidentified (a physical docroot file would survive cutover; a uPress staging-domain default would not), and AC-07 requires the production allow-list file instead. **Add to the WP012 checklist: identify what serves this file, and assert post-cutover that robots.txt is the WP-04 allow-list, not this artifact.**
- **C-2 · `/method/` carries no `Service` schema node** — consistent with the code (slug map = treatment/sound-healing/lessons), so not drift; but WP002's spec says Service-per-route for the service pages. team_100 should decide deliberately whether «השיטה» is a Service (probably not — it is the methodology entity, better served by the planned `knowsAbout`/description wiring) and record it in the WP002 spec so the omission is documented rather than accidental.
- **C-3 · Sitemap child-sitemap noise:** `wpa-stats-type-sitemap.xml`, `author-sitemap.xml`, `post_tag`/`category` sitemaps are exposed for a single-author niche site. Low priority; fold into the same Yoast-settings pass as D-2.

### §5.4 Governance side-finding — the DB is back online

CTX-05 health probe today: `{"api":"online","db":{"status":"online","version":"PostgreSQL 16.13…"},"mode":"online","built_at":"2026-07-02T12:03:04Z"}` (live curl, §A). The S004 program's entire file-canonical posture rests on "DB registration BLOCKED… db_connectivity reads offline" (umbrella `:15-16`, stamped 2026-06-20). Whether the *actor-key* half of the blocker (`REQUEST-TEAM110-HUB-API-KEY-AND-DB-MIGRATION-2026-06-16.md`) is also resolved was not testable from this session (no actor key in env — expected for a spoke research session). **Action for team_100/team_110: probe with the actor key; if writes succeed, run the queued one-pass S004 + 13 sub-WP registration.**

### §5.5 The QA-harness coverage gap (mandate Task 4, explicit)

Verified: every `docs/qa/*/qa_probe_result.json` (11 probe runs, 2026-06-22) checks only `{url, http_rendered, scrollWidth/clientWidth → overflow, forbiddenFound, title, pass}` — **zero SEO signals**: no robots meta/header, no robots.txt, no sitemap, no JSON-LD typing, no meta-description count, no canonical, no OG, no hreflang (`docs/qa/probe-fullsite-2026-06-22/qa_probe_result.json`, result-object keys). Today's D-1 drift demonstrates the cost concretely: **a meta-regression shipped on 06-22/23 and no automated gate caught it** — it was found by this mandate's manual pass ten days later.

**Routing recommendation (per team_80's charter — advisory, no execution):** closing the gap is **technical execution** and belongs to **team_90 (QA automation) or team_50 (gate runner) under a team_100 mandate** — not to team_80. team_80's contribution is the ready-to-implement check-spec in **Appendix B** (12 checks, all curl/Node-implementable against staging, calibrated to expect the staging noindex rather than fail on it). Suggested shape: a `seo_probe.mjs` sibling to `qa_probe.mjs`, added to the §2 standing harness (`SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md:75-81`) so every deploy gets it, with per-route expected-schema-types read from a small JSON manifest.

---

## §6 Consolidated open-topics register (Task 5)

| # | Item | Type | Recommendation / ask | Ratifier / owner | Blocked on Eyal? |
|---|---|---|---|---|---|
| 1 | D2 geo radius | decision | GeoCircle, studio midpoint, 45 km (§3.1) | team_100 (+FYI Eyal) | No |
| 2 | D3 GPTBot | decision | Explicit allow-all 8 UAs, logged (§3.2) | team_00/100 | No |
| 3 | D12 keyword volumes | decision | GSC-first + 3-spoke phase-1 (§3.3) | team_100 | No |
| 4 | D13 EN investment | decision | Out-of-scope, keep `/en` correct (§3.4) | team_00/100 | No |
| 5 | DEC-SEO-B1 pillar URL | decision (at build) | Lean top-level; record at WP003 build (§3.5) | team_100 | No |
| 6 | AC-12 owner/date | ownership gap | team_100 accountable; staging half ≤07-09 (§4) | team_100 + ops; Eyal = 2-min inbox confirm | Minimal |
| 7 | D-1 meta-description drift | live drift | WP-04 fix: one description per route (§5.2) | team_10 | No |
| 8 | D-2 sitemap hygiene (14×301 + 2 test pages) | live drift | Yoast-exclude/unpublish before GSC submit (§5.2) | team_10 | No |
| 9 | C-1 block-all robots.txt provenance | cutover flag | Add identify+replace assertion to WP012 (§5.3) | team_100/ops | No |
| 10 | QA SEO-probe gap | harness gap | Mandate team_90/team_50; spec = Appendix B (§5.5) | team_100 → team_90/50 | No |
| 11 | S004 DB registration | governance | DB online — re-probe actor key, register (§5.4) | team_100/team_110 | No |
| 12 | 15 content proposals (CP/AF/BN/FAQ/BLOG) | content approvals | #1 lever = CP-01; hub intake live | **Eyal** (team_00 channel) | **Yes** |
| 13 | `/eyal-amit/` heading disposition (a)/(b) | content disposition | Already tracked as `OPEN-BRAND-RETIRED` (`eyal-needs.json:100-104`) | **Eyal** | **Yes** |
| 14 | EYL-1 Clarity project_id | analytics input | Guide PDF sent; GA4 unaffected | **Eyal** | **Yes** |
| 15 | EYL-2 Mokesh full-film link + final page approval | media/content | `OPEN-MOKESH-FINAL` (`eyal-needs.json:139-144`) | **Eyal** | **Yes** |
| 16 | EYL-3 media 38 items · EYL-4 testimonials 48 · product prices · courses URL · EYL-6 `/shop/תקנון/` target | materials | Intake pages live (`materials-needed.json`, media-intake) | **Eyal** | **Yes** |
| 17 | GBP claim + Wikidata (WP009) | off-site accounts | Day-one owner ask once Eyal grants access | **Eyal** + team_100 | **Yes** |

## §7 Prioritized next actions

**§7.1 Movable now (no Eyal input), in order:**
1. **Ratify D2/D3/D12/D13** from §3 (one team_00/100 sitting; unblocks the WP002 geo node and the WP004 robots posture spec, and formally de-blocks WP010 phase-1 sizing).
2. **Name the AC-12 owner + run the staging lead-deliverability test** (§4) — the program's own "most consequential gate", target ≤2026-07-09.
3. **Fix D-1 + D-2** (meta descriptions; sitemap exclusions) — small team_10 code/settings changes; re-verify with the §2 harness.
4. **Issue the QA seo-probe mandate** to team_90/team_50 with Appendix B (prevents the next silent drift).
5. **Re-probe the hub API with the actor key** and, if unblocked, run the one-pass S004 DB registration (§5.4).
6. At WP003 build time: record DEC-SEO-B1 (lean top-level).

**§7.2 Hard-blocked on Eyal — the exact asks (all already live in the hub):**
- Approve/edit the **15 content proposals** — especially CP-01's lede, expert quote, and the CPAP-claim wording (`content-proposals.json:14` lists his 4 decision points). This single approval unblocks WP003 → WP007-embed → WP010-phase-1 → WP011-press-kit — the whole content flywheel.
- Confirm the `/eyal-amit/` heading disposition (a: reconcile source doc / b: accept D1 deviation).
- Send the Clarity `project_id` (guide already delivered).
- Provide the Mokesh full-film link + final pass on the memorial page.
- Fill media intake (38 items; the 9 needs-new are design-blocking for M6), curate the 48 testimonials, set numeric product prices (activates the already-shipped Product/Offer schema), give the courses URL + `/shop/תקנון/` target confirm, and grant GBP/Wikidata access.

**§7.3 Sequencing:** items 1–5 of §7.1 are parallel and independent. The Eyal-approval batch (CP-01 first) is the critical path to M5 content-complete → M6 design-QA → M7 cutover (`hub/data/tasks.json` M5→M6→M7 chain; `COMPLETION-ROUND-ROADMAP-2026-06-20.md:69`). Nothing in this report changes the milestone order; it removes every excuse for the non-Eyal items to wait.

## §8 Out of scope / not reopened

The 5 locked decisions (§2.3) are cited as constraints, not revisited. `llms.txt` stays skipped (umbrella `:40`). D10 is reported in its reconciled content-only form (§2.4.1). No code, content, schema or QA-script was written or changed by this session (team_80 write scope: this file only). Health-claim wording, testimonial curation and all §7.2 items are Eyal's and are reported, not resolved.

---

## Appendix A — Evidence log (live checks, 2026-07-02T20:40–20:55Z, HTTP GET, cache-busted)

Raw responses archived in the session scratchpad `evidence/` dir (home.html, page_*.html, post_blog.html, robots.txt, sitemap_index.xml, page-sitemap.xml, sitemap_status.txt, home_headers.txt, ts.txt).

```
GET /robots.txt                    → 200  body: "User-agent: *\nDisallow: /"   (== hub/dist/robots.txt byte-identical)
GET /sitemap_index.xml             → 200  Yoast index, 10 children (post, page, ea_faq, ea_gallery, ea_testimonial,
                                          category, post_tag, wpa-stats-type, ea_testimonial_cat, author)
GET /wp-sitemap.xml                → 301  → /sitemap_index.xml
GET /llms.txt                      → 404  (expected — explicit SKIP)
GET /  (headers)                   → 200  Cache-Control: no-cache,…,private · X-Robots-Tag: noindex, nofollow
GET /  (body)                      → graph [WebPage,BreadcrumbList,WebSite,Person,ProfessionalService]
                                     meta robots 'noindex, nofollow…' · og:image ×1 (eyal-portrait-hero.jpg) · desc ×1
                                     hreflang link en/he/x-default · gtag G-MRXESK7QJF present
GET /eyal-amit/                    → 200  graph +Person ✓ · og:image ×1 · desc ×1
GET /treatment/                    → 200  graph +Service ✓ · desc ×2  ← DRIFT D-1
GET /method/                       → 200  no Service node (per code) · desc ×0  ← DRIFT D-1
GET /sound-healing/                → 200  graph +Service ✓ · desc ×2  ← DRIFT D-1
GET /lessons/                      → 200  graph +Service ✓ · desc ×2  ← DRIFT D-1
GET /faq/                          → 200  no FAQPage node (expected — WP002 remainder)
GET /contact/                      → 200  +972-52-482-2842 ✓ · עמל 8 ✓
GET /en/                           → 200  <html lang="en" dir="ltr"> · hreflang en/he/x-default · desc ×1
GET <first post-sitemap post>      → 200  graph [Article,WebPage,BreadcrumbList,WebSite,Person,Person,
                                          ProfessionalService] · og:image ×1 · desc ×1  (AC-19 holds)
GET /didgeridoos/ · /books/vekatavta/ → 200  no Product node, no numeric price present (correct is_numeric behavior)
GET og:image asset                 → 200  173,624 bytes
GET /about/                        → 301 → /eyal-amit/        GET /about/moksha/ → 301 → /eyal-amit/mokesh-dahiman/
Sitemap sweep (102 page-sitemap URLs) → 88× 200 · 14× 301 (all single-hop, correct targets):
  /services/didgeridoo-lessons/→/lessons/ · /services/didgeridoo-treatment-breath/→/treatment/
  /services/handmade-instruments/→/tools-and-accessories/instruments/ · /hashita/→/method/
  /courses-soon/→/learning/courses-external/ · /muzeh/{,tsva…,kushi…,vekatavt}/→/books/* ·
  /muzza/{,vekatavt,tsva…}/→/books/* · /about/→/eyal-amit/ · /about/moksha/→/eyal-amit/mokesh-dahiman/
  + /sample-page/ and /wave2-test/ = 200 in sitemap  ← DRIFT D-2
AOS health probe (CTX-05)          → {"api":"online","db":{"status":"online","version":"PostgreSQL 16.13…"},
                                      "mode":"online","built_at":"2026-07-02T12:03:04Z"}
validate_aos.sh .                  → 45 PASS / 30 SKIP / 0 FAIL
```

Web sources (D3 token verification, retrieved 2026-07-02): [OpenAI crawler documentation](https://developers.openai.com/api/docs/bots) · [Search Engine Land — Anthropic's three crawlers](https://searchengineland.com/anthropic-claude-bots-470171) · [The AI User-Agent Landscape in 2026](https://nohacks.co/blog/ai-user-agents-landscape-2026) · [xSeek — Claude user agents](https://www.xseek.io/docs/claude-user-agents).

## Appendix B — SEO-probe check-spec (for team_90/team_50 under a team_100 mandate)

Per-deploy, against staging (HTTP), reading per-route expectations from a JSON manifest. All checks are curl/Node-implementable; none needs a browser.

| # | Check | Pass rule (staging) | Catches |
|---|---|---|---|
| 1 | robots meta/header | `noindex, nofollow` PRESENT on staging host; test flips to ABSENT-required on production host (AC-14) | noindex stuck/lost |
| 2 | robots.txt | staging: any; production: NOT `Disallow: /`, contains `Sitemap: …/sitemap_index.xml` + the 8 allowed UAs (AC-07) | block-all artifact leak |
| 3 | sitemap_index | 200 + parses; every `<loc>` in child sitemaps returns **direct 200** (no 301/302/404) | D-2 class pollution |
| 4 | meta description | exactly **1** per route, non-empty, ≠ bloginfo tagline | D-1 class drift (dup/zero) |
| 5 | canonical | exactly 1, self-referencing | dup/missing canonical |
| 6 | og:image | exactly 1, resolves 200 | Round-2 class regression |
| 7 | JSON-LD graph | single `yoast-schema-graph` block, parses; per-route expected `@type` set from manifest (home: Person+ProfessionalService; service slugs: +Service; posts: Article; faq: +FAQPage once WP002 ships it) | schema drops/second engine |
| 8 | `@id` connectivity | `#person`/`#business`/`#service-*` referenced, no dangling `@id` (validation-plan §3.3) | broken graph |
| 9 | prohibition lint | zero `AggregateRating` / `areaServed":"Israel"` / `HealthAndBeautyBusiness` / VideoObject-on-hero (validation-plan §3.4) | D2/D5 violations |
| 10 | hreflang | reciprocal en/he/x-default pairs on `/` + `/en/`; `/en/` has `lang="en" dir="ltr"` | T19 regressions |
| 11 | GA4 | `gtag/js?id=G-MRXESK7QJF` in head; exactly one config | analytics un-gate regression |
| 12 | brand-string absence | `--absent 'סטודיו נשימה מעגלית'` on all routes **excluding** the 6 verbatim testimonial quotes (re-scoped AC-09, Round-2 `:35`) | brand re-leak |

---

**Routing:** → **team_100** for architecture-level action (per team_80 charter; not routed to Eyal directly — §7.2 asks go through team_00's channel). Completion notice to team_00: deliverable path = `_COMMUNICATION/team_80/SEO-GEO-RESEARCH-SYNTHESIS-2026-07-02.md`; one-line summary = *"SEO/GEO machine layer shipped & live-verified; 4 decision gates resolved with recommendations (GeoCircle-45km / allow-GPTBot / GSC-first / EN-out-of-scope); AC-12 owner proposed (team_100, staging test ≤07-09); 2 live drifts + 1 cutover flag + QA-gap spec delivered; 15 content proposals remain the #1 Eyal-blocked lever."*
