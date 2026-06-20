<!-- team_100 SEO/GEO finalization — execution-prep workflow wf_2a85ad67-08d, 2026-06-20. Builds on LOD400 + exec plan + completion register. -->

# LOD400 — S004-P001-WP000: SEO / GEO / AEO Launch-Readiness Finalization (Umbrella Work Package)

**WP ID:** `S004-P001-WP000` (canonical umbrella)
**Label:** SEO/GEO/AEO finalization — entity grounding, conversion repair, earned corroboration, and gated production cutover for EyalAmit.co.il-2026
**Track:** A (standard) — with a single nested **Track B** cutover sub-WP (`S004-P001-WP012`)
**Milestone:** S004 — Launch-Readiness (forward milestone; opens after S003 UI-Precision)
**Profile:** L0 · **Domain:** `eyalamit`
**Owner / Author:** team_100 (Chief Architect, SEO/GEO delivery lead)
**Build engine:** team_10 (Claude Code) / cross-engine validators per Iron Rule #1
**L-GATE_BUILD:** team_50 (non-Claude engine) · **L-GATE_VALIDATE:** team_190 (constitutional, cross-engine)
**Date:** 2026-06-20 · **lod_status:** LOD400 · **current_lean_gate:** L-GATE_SPEC

> **CANONICAL STATUS — FILE-CANONICAL ONLY (DB registration BLOCKED).**
> This umbrella WP is authored **file-canonically**. DB registration of `S004-*` is **blocked on the team_110 hub API actor key** (completion register §7; request `_COMMUNICATION/team_100/REQUEST-TEAM110-HUB-API-KEY-AND-DB-MIGRATION-2026-06-16.md`). Hub canonical DB probe `db_connectivity_status.json` reads **`status: offline`** (port 5434 refused, stamped 2026-06-20T11:00Z) and the live roadmap API has never held the Wave2/SEO program — `_aos/roadmap.yaml` is the live SSoT. Per ADR034 R8 / the PRECONDITION#1 interim protocol: structured mutation is by file only, on a named branch (never `main`), and the API must be re-probed before any DB write. **On actor-key arrival**, team_100 migrates this umbrella + its 13 sub-WPs to canonical DB IDs in one reconciliation pass (alongside the WP-W2-* → canonical migration already queued in §7).

---

## 1. Problem statement

EyalAmit.co.il-2026 is a content-complete (S002 closed 9/9) Hebrew RTL WordPress site whose **single business objective is organic discovery** — via classic search (Google) **and** generative/answer engines (ChatGPT/SearchGPT, Perplexity, Google AI Overviews + AI Mode, Gemini, Claude, Copilot). Three structural problems block that objective today, all re-verified against the live repo on 2026-06-20:

1. **The conversion funnel actively leaks.** The site **suppresses ~⅓ of leads and measures zero conversions**: the A/B test sets `display:none` on `.ea-whatsapp-float` for the `form_only` variant; GA4 never fires (`__PENDING_EYAL__` gate couples it to the still-missing Clarity ID); every `wa.me` link is bare (no `?text=` pre-fill); and `EA_WAVE2_CF7_FORM_ID = 0` because CF7 is not active server-side. This is pure waste **regardless of traffic** — fixing it is the highest-ROI work in the program.
2. **The machine-grounding layer is 0% built.** Zero JSON-LD, zero OG/Twitter, no per-route `<title>`/canonical, no `robots.txt` in `site/` root (only a block-all `hub/dist/robots.txt` artifact), no Wikidata Q-ID, no claimed Google Business Profile, and the existing `he.wikipedia` article is not wired via `sameAs`. AI/answer engines cannot deterministically resolve **Eyal Amit → cbDIDG → טיפול בנשימה באמצעות דיג'רידו → פרדס חנה**.
3. **Go-live is an unmanaged, irreversible operation.** Two stale 301 exports disagree with the live mu-plugin SSoT; the staging-noindex gate must be verified to lift; the sitemap URL is self-contradictory across the plan (`wp-sitemap.xml` vs the legacy `/sitemap_index.xml` 301 target); and several real published routes (`/shows/ /repair/ /bags/ /stand-floor/ /stands-storage/ /books/* /about/moksha/ /press/` + 48 `/qr/qr*/`) would ship as thin, schema-less, tagline-fallback pages.

The strategy and the 13-WP backlog **already exist** (LOD400 2026-06-19; execution plan 2026-06-20) and are **not re-derived here**. This umbrella exists to make the program **canonically governable** — one tracked S004 launch mission with one set of cross-cutting acceptance criteria, dependency closure, decision-gate ledger, and KPI baseline — over the 13 sub-WPs that carry the detailed per-component specs.

**Deliberate niche framing (carried, not re-litigated):** this is a low-volume Hebrew RTL niche where head-term ranking will not move the business. The whole effort is a portfolio of cheap, high-leverage **entity-grounding + earned-corroboration + conversion-capture** moves, with the **sleep-apnea/snoring bridge (BMJ 2006 Puhan RCT)** as the single largest organic-and-AI-citation lever.

---

## 2. Solution concept

Ship the existing 13-WP backlog as **one governed launch mission** in three phases plus a gated Track-B cutover, sequenced by the ruthless ordering principle **"every visitor is precious — fix the leaking funnel before pouring more traffic in."** The umbrella is the **integration and verification contract**: it owns the cross-WP dependency graph, the shared decision-gate ledger, the consolidated route inventory, the end-to-end lead-receipt proof, and the launch KPI baseline. Each numbered component below is a self-contained sub-WP whose detailed spec lives in `SEO-GEO-EXECUTION-PLAN-2026-06-20.md` §4 (verbatim) and is incorporated here by reference; the umbrella does **not** duplicate those paragraphs.

Two hard reconciliations are carried as locked inputs (do not re-open): (1) **NAP/business name** = "המרכז לטיפול בנשימה באמצעות דיג'רידו" (cbDIDG), drop "סטודיו נשימה מעגלית", E.164 `+972-52-482-2842`, address עמל 8 ב' פרדס חנה, hours Sun–Thu 09–19 / Fri 09–14 / Sat closed / by-appointment, **SHOW address** (D1/D6 closed). (2) **Theme-native, no SEO plugin** (D4) — all schema/meta/sitemap is hand-rolled; never run two schema engines.

**Explicitly out of scope (do not spend budget):** `llms.txt`; self-serving Review/AggregateRating schema on the business entity; FAQPage *for Google rich results* (deprecated — keep for AI extraction only); YouTube Shorts; mass video production; Merchant Center / Shopping feed / UCP; fake/zero prices on "מחיר לפי התאמה" products; head-term chasing; bought guest posts / niche edits / PBNs (devalued by the March-2026 core update); EN content investment (D13 — keep `/en` correct, do not invest).

---

## 3. Major components (the 13 sub-WPs)

Detailed per-WP specs: `SEO-GEO-EXECUTION-PLAN-2026-06-20.md` §3 (tables) + §4 (one-paragraph specs). Proposed canonical sub-IDs map the legacy `WP-01..13` 1:1.

| Sub-WP ID | Legacy | Title | Phase | Track | Pri | Effort |
|---|---|---|---|---|---|---|
| `S004-P001-WP001` | WP-01 | Conversion-path repair + analytics un-gate (highest ROI) | P1 | A | P1 | M |
| `S004-P001-WP002` | WP-02 | Hand-rolled JSON-LD `@graph` (Person, ProfessionalService, Service×route, FAQPage, Breadcrumb, ImageObject, VideoObject hooks) — **dependency root** | P2 | A | P2 | M |
| `S004-P001-WP003` | WP-03 | Sleep-apnea/snoring pillar + press-kit data hook + answer-first tightening — **content/PR/video flywheel hub** | P2 | A | P2 | M |
| `S004-P001-WP004` | WP-04 | Crawl-policy + meta head pack (robots.txt, titles, meta, canonical, OG/Twitter, hreflang, breadcrumbs) | P1 | A | P1 | M |
| `S004-P001-WP005` | WP-05 | Image-discovery hygiene + WebP/LCP pass (+ image XML sitemap, intake checklist) | P1 | A | P1 | M |
| `S004-P001-WP006` | WP-06 | NAP lock + footer brand-string fix + explicit local/geo layer | P2 | A | P2 | M |
| `S004-P001-WP007` | WP-07 | Video channel: facade embeds + on-page transcripts + nested VideoObject | P2 | A | P2 | M |
| `S004-P001-WP008` | WP-08 | Honest commerce schema (Product/Offer, omit fake price) + content-led buying guide | P2 | A | P2 | M |
| `S004-P001-WP009` | WP-09 | Off-site authority kickoff (GBP, Wikidata, niche directories, YouTube metadata) — owner-dependent, start day one | P1 | A | P1 | M |
| `S004-P001-WP010` | WP-10 | Blog hub-and-spoke cluster + renewable freshness | P3 | A | P3 | H |
| `S004-P001-WP011` | WP-11 | Earned digital-PR + policy-safe reviews engine + unlinked-mention corroboration | P3 | A | P3 | M |
| **`S004-P001-WP012`** | **WP-12** | **Staging→production cutover: 301 SSoT freeze, redirect/404 audit, noindex-lift verify, sitemap resubmit** | **P3** | **B** | **P2** | **M** |
| `S004-P001-WP013` | WP-13 | Measurement, KPI baseline + quarterly AI-citation audit | P3 | A | P3 | L |

**Phase grouping:** P1 quick-wins {WP001, WP004, WP005, WP009} → P2 foundational {WP002, WP003, WP006, WP007, WP008} → P3 ongoing/off-site {WP010, WP011, WP013} + **WP012 (Track B, gated, runs at go-live).**

---

## 4. Primary flow

The end-to-end launch flow this umbrella governs, from build through measured go-live:

1. **Day-one parallel start (owner track + independent build).** Fire the four day-one owner asks (D1, D6, D11 — all closed; **D10 promoted to day-one**, see §6) and start the four independent P1 WPs in parallel: `WP001` (stop the leak + GA4), `WP004` (robots/meta/OG), `WP005` (WebP/LCP/alt), `WP009` (GBP/Wikidata/dirs/YouTube — compounds slowly).
2. **Lock the identity spine.** `WP009` (live profile URLs) → `WP006` (byte-identical NAP + footer fix + geo) → these feed the entity nodes.
3. **Build the machine layer.** `WP002` (`@graph`) consumes the locked NAP + the `sameAs` chain and becomes the **dependency root** for `WP003`, `WP007`, `WP008`, `WP010`.
4. **Build the content/PR/video flywheel.** `WP003` (sleep-apnea pillar + press kit) → `WP007` (video facades + transcripts + VideoObject), `WP008` (commerce schema + buying guide), `WP010` (blog cluster) — each emitting nodes defined in `WP002`.
5. **Earned corroboration runs continuously.** `WP011` points every digital-PR/review/mention back to the `WP003` press kit and the `WP006`/`WP009` NAP+GBP.
6. **Instrument and prove the funnel.** `WP013` extends the analytics into a single `generate_lead` event segmented by landing page + AI referrer; the **end-to-end lead-receipt test** (form + wa.me + tel:) is run and must pass (AC-12).
7. **Gated go-live (Track B).** `WP012` runs last: freeze the 301 SSoT, run the post-deploy redirect/404/chain audit, verify staging-noindex no-ops on production, curl each AI UA against live URLs for HTTP 200, publish production `robots.txt`, resubmit the (reconciled) sitemap in GSC, capture the GSC/GA4 baseline, monitor Coverage/Crawl-Stats/Page-Indexing for 2–4 weeks.

**Critical path:** `WP009 → WP006 → WP002 → {WP003, WP007, WP008, WP010}`. **Last + gated:** `WP012` (needs `WP004` robots/meta, `WP013` analytics live, and D10).

---

## 5. Actors & systems

| Actor / System | Role in this WP |
|---|---|
| **team_100** (Chief Architect) | Umbrella owner; decision-gate ledger; route-inventory SSoT; KPI baseline; file-canonical authority on `_aos/roadmap.yaml` + `_aos/work_packages/` |
| **team_10** (builder, Claude Code) | Theme/mu-plugin implementation of WP001–WP008, WP010, WP012–WP013 |
| **team_50** (L-GATE_BUILD, non-Claude) | Cross-engine build verification (Iron Rule #1) |
| **team_190** (L-GATE_VALIDATE, Codex) | Constitutional, cross-engine final validation (Iron Rule #5) |
| **team_110** (hub DB/work-env authority) | **Blocker holder** — issues the actor key that unblocks DB registration (§7 register) |
| **team_00** (Principal) | Approves cutover go (`WP012`); approves branch merges under ADR034 offline-fallback |
| **Eyal (via team_00)** | Owner-dependent inputs: Clarity ID (EYL-1), Mokesh full-film link + facts (EYL-2/D10), media intake 38 items (EYL-3), testimonials (EYL-4), GBP claim, Wikidata, reviews ask |
| **uPress / ops** | Server-side CF7 activation + SMTP/deliverability + spam protection (honeypot/Turnstile); CDN/WAF must not 403 AI UAs |
| **WordPress / GeneratePress / ea-eyalamit child theme** | Host platform; `inc/wave2-*`, `mu-plugins/ea-w2*`, block templates |
| **Google** | Search (Googlebot → also feeds AI Overviews), GSC, GA4, Google Business Profile |
| **AI/answer engines** | OAI-SearchBot/ChatGPT-User, Claude-SearchBot/Claude-User, PerplexityBot/Perplexity-User, Gemini, Bingbot/Copilot |
| **Off-site authority nodes** | he.wikipedia, Wikidata, GBP, Facebook, YouTube, youdidgeridoo.com/iDIDJ/DidjNet, Hebrew practitioner/event indexes |

---

## 6. Acceptance criteria (testable, umbrella-level)

These are the **cross-cutting launch-gate criteria** the umbrella owns; per-WP ACs live in the sub-WPs. All are pass/fail.

- **AC-01 — Lead leak stopped.** `.ea-whatsapp-float` is visible to 100% of sessions (no variant sets `display:none` on the sole working lead path). *(WP001)*
- **AC-02 — GA4 fires independently.** With Clarity still `__PENDING_EYAL__`, GA4 `G-MRXESK7QJF` loads and records a pageview on every core route (network-tab confirmed). *(WP001/WP013/D11)*
- **AC-03 — Pre-filled contact paths.** Every `wa.me` link carries a page-aware Hebrew `?text=`; `tel:` + tappable NAP/hours present in footer + /contact. *(WP001)*
- **AC-04 — `@graph` validates and cross-references.** One connected `@graph` validates in the Schema.org validator with zero errors; `#person`/`#business`/`#service-*` `@id`s are mutually referenced; honors prohibitions (ProfessionalService not HealthAndBeautyBusiness; no `areaServed:Israel`; no precise geo until lat/long supplied; no self-serving AggregateRating; no VideoObject on the muted hero loop). *(WP002/D2/D5)*
- **AC-05 — FAQPage byte-identical.** FAQPage entities are generated from the **same arrays** the visible accordions render; question/answer text matches the rendered DOM byte-for-byte. *(WP002)*
- **AC-06 — Sleep-apnea pillar is buildable and live.** The pillar resolves at a URL that the chosen injector actually serves (SEO-B1 resolved: top-level `/sleep-apnea-snoring` **or** the `wave2-w2-04` injector extended to accept a parent slug — decision recorded in the gate ledger), returns 200, carries the 40–100w direct-answer lede + named **BMJ 2006 Puhan RCT** + JCSM meta-analysis with outbound links + Article/FAQPage/`citation` JSON-LD + the "לעיתונאים / מקורות" press-kit sub-block. *(WP003/SEO-B1)*
- **AC-07 — Crawl policy is correct and proven.** Production `site/` root `robots.txt` (not the block-all artifact) allows Googlebot/Bingbot + the AI citation UAs and declares the **single reconciled sitemap URL**; the legacy sitemap 301 target, the robots `Sitemap:` directive, and the GSC submission **all name the same URL** (SEO-B2 resolved). Post-cutover, `curl` of each named AI UA against ≥3 live URLs returns **HTTP 200** (not 403/blocked), run **the day robots goes live**, not deferred to the monitoring window. *(WP004/WP012/D3/SEO-B2)*
- **AC-08 — Image discovery hygiene.** Hero/portrait/logo/book/product/Mukesh assets served as WebP via `<picture>`/srcset with explicit width/height; LCP poster `eager`+`fetchpriority=high`, below-fold `lazy`; weak `alt` replaced (no `alt=get_the_title()`); visible Hebrew captions added; hand-rolled image XML sitemap referenced from robots; intake checklist shipped. *(WP005)*
- **AC-09 — NAP locked byte-identical.** One canonical NAP string appears identically across footer, /contact, schema `#business`, and GBP; "סטודיו נשימה מעגלית" removed from the footer brand string; schema `areaServed` equals the GBP service area. *(WP006/WP009/D1/D6)*
- **AC-10 — Honest commerce schema.** `Product` emits from `ea_product_price` meta with a defined `is_numeric` rule; the `Offer` node is **omitted entirely** where the value is the "מחיר לפי התאמה" fallback (no fake/zero price). *(WP008/SEO-B4-adjacent)*
- **AC-11 — Full route inventory has machine layer or is explicitly noindexed.** Every published 200 route — including `/shows/ /repair/ /bags/ /stand-floor/ /stands-storage/ /books/vekatavta/ /books/kushi-blantis/ /about/moksha/ /press/` and the **48 `/qr/qr*/`** pages — either receives title/meta/canonical/OG (+ schema where applicable) or is explicitly marked noindex/out-of-scope; none ship with silent tagline-fallback meta. The 48 `/qr/qr*/` raw-iframe embeds are assigned to one WP for facade/lazy/transcript remediation. *(SEO-B5, SEO-B3; WP002/WP004/WP005/WP007)*
- **AC-12 — End-to-end lead receipt proven (the single most consequential gate).** A real test lead submitted via **each** path (CF7 form, pre-filled `wa.me`, `tel:`) is confirmed **received by Eyal** (form lands in inbox, not spam) **and** the GA4 `generate_lead` event fires for each. CF7 confirmed active server-side; SMTP/deliverability + spam protection in place. *(WP001/WP013/SEO-B4/D7)*
- **AC-13 — 301 SSoT frozen and audited.** `ea-w209-legacy-301-redirects.php` is the sole live mechanism; the two stale exports are quarantined; the `/Blog/ → /blog/` prefix rule is emitted (301-1 closed) and the verification harness is repaired (301-2); post-deploy list-mode audit shows **every 301 = single hop to a 200, no chains**; the 48 `/qr/qr*/` + parent `/qr/` stay **200** and legacy `/qr/פרק-א/` stays **410** (SEO-B3 corrected). *(WP012)*
- **AC-14 — Staging noindex lifts on production.** The `ea-staging-noindex.php` mu-plugin no-ops on production (host check + `WP_HOME`/`WP_SITEURL` assertion); ≥8 live URLs fetched confirm **no `noindex`**. *(WP012)*
- **AC-15 — Baseline captured.** GSC property for `https://www.eyalamit.co.il` verified; GA4 + GSC baseline captured **at cutover** (staging numbers discarded as artifacts); sitemap resubmitted; Coverage/Crawl-Stats/Page-Indexing monitored 2–4 weeks. *(WP012/WP013)*
- **AC-16 — Governance.** `validate_aos.sh .` exits **0 FAIL** on this spoke; no edits to AOS-layer files; all inter-team coordination via canonical `_COMMUNICATION/` artifacts. *(umbrella)*

---

## 7. Dependencies

**Internal (sub-WP graph):**
```
WP001 (CRO + GA4) ─────────────► WP013 (funnel instrumentation + baseline)
WP009 (GBP/Wikidata/dirs/YT) ─► WP006 (NAP lock + geo) ─► WP002 (@graph) ─┬─► WP003 (pillar + press kit)
       │ (sameAs → WP002)                │                                ├─► WP007 (video facade + VideoObject)
       │                                 │                                ├─► WP008 (Product/Offer + buying guide)
       │                                 │                                └─► WP010 (blog cluster)
WP004 (robots/meta/OG/hreflang) ─────────┴────────────────► WP012 (Track B cutover, gated)
WP005 (WebP/LCP/alt + ImageObject half) ─► WP002 (ImageObject nodes) ──► WP012 (verify live)
WP003 (press kit) ─► WP011 (digital-PR + reviews + mentions) ─► WP009/WP006 (NAP/GBP round-trip)
WP013 (analytics live) ─► WP012 (inventory sources + baseline capture)
```
**Cross-milestone / external:**
- **S003 (UI-Precision) must close** before WP012 cutover (design-QA + full-responsive sweep precede go-live).
- **team_110 actor key** → unblocks DB registration of this umbrella + 13 sub-WPs (governance, not build-blocking — file roadmap remains SSoT meanwhile).
- **Ops / uPress:** CF7 activation + SMTP/deliverability + spam protection (named dependency, not theme code) — blocks AC-12.
- **Eyal-dependent inputs:** EYL-1 Clarity ID (does not block GA4 once gate split), EYL-2/D10 Mokesh full-film + facts, EYL-3 media (38 items), EYL-4 testimonials.
- **Pre-build blockers (resolve before/while building):** **SEO-B1** pillar URL buildability, **SEO-B2** sitemap URL contradiction, **SEO-B3** 48 QR raw-iframe ownership, **SEO-B4** CF7 server-gate + lead-receipt test, **SEO-B5** route enumeration gaps.

---

## 8. Open decision-gates

| ID | Status | Disposition |
|---|---|---|
| D1 NAP/business name | **CLOSED** | Lead with "המרכז לטיפול בנשימה באמצעות דיג'רידו / cbDIDG"; drop "סטודיו נשימה מעגלית"; E.164 +972-52-482-2842 |
| D2 areaServed/geo | **OPEN** | Bounded GeoCircle around Pardes Hanna (north/center) = GBP service area; NOT `areaServed:Israel`; no precise geo until lat/long supplied — blocks WP002 geo node |
| D3 GPTBot allow/block | **OPEN (recommend allow)** | Log it; OAI-SearchBot/ChatGPT-User allowed regardless — blocks WP004 robots posture |
| D4 SEO plugin vs theme-native | **CLOSED** | Theme-native; if a plugin is ever added, its schema module OFF |
| D5 business schema subtype | **CLOSED** | ProfessionalService + Person (not HealthAndBeautyBusiness) |
| D6 GBP address display | **CLOSED** | SHOW (home studio is client-visited); no set hours, by-appointment |
| D7 primary conversion goal | **CLOSED** | Therapy lead → intro call |
| D8 books/products role | **CLOSED** | Products = content-led secondary, inquiry-only; books = authority layer |
| D9 health-claim conservatism | **CLOSED** | No cure/efficacy; cite mechanism (BMJ); visible disclaimer + "התייעצו עם איש מקצוע רפואי" |
| **D10 Mukesh memorial facts/dates/images + full-film** | **OPEN — PROMOTE TO DAY-ONE** | Owner-dependent (Eyal, unknown latency); gates WP007 + WP012; freeze canonical live slug **`/about/moksha/`** so the 301 target + schema node agree |
| D11 GA4 ID source-of-truth | **CLOSED** | Reconcile `__PENDING_EYAL__` → `G-MRXESK7QJF`; split the gate so GA4 fires without Clarity |
| D12 verify Hebrew keyword volumes | **OPEN** | Verify in GSC/Keyword Planner **before** sizing WP010 word/article count; or scope WP010 phase-1 to the 3 strategy-justified spokes (sleep-apnea / cbDIDG / disambiguation) that need no volume data |
| D13 EN target audience | **OPEN (recommend EN out-of-scope)** | Keep `/en` correct (hreflang/lang/dir) but do not invest content; Qwoted English channel is bonus-only |
| **DEC-SEO-B1 pillar injector** | **OPEN — RECORD AT BUILD** | Either make the pillar top-level `/sleep-apnea-snoring` to fit the existing `wave2-w2-04` injector (matches `post_parent==0` only), or extend the injector to accept a parent slug — record the chosen path |
| **DEC-SEO-B2 sitemap URL** | **OPEN — RECORD AT BUILD** | Pick ONE sitemap URL (`wp-sitemap.xml` vs `sitemap_index.xml` alias) and make robots + GSC + the legacy 301 target all name it |

---

## 9. Track classification & rationale

**Track A (standard)** for the umbrella and 12 of 13 sub-WPs — additive content/schema/theme work, reversible, no irreversible production state change. **Track B (cutover discipline)** is nested for **`S004-P001-WP012` only** — the same-domain in-place re-platform is the one **irreversible, sensitive** operation (301 SSoT freeze, noindex lift, DNS-adjacent verification, sitemap resubmit). It is sequenced **last and gated** (team_00 go), runs at go-live, and depends on WP004 (robots/meta), WP013 (analytics for inventory + baseline), D10, and S003 closure.

---

## 10. Risk classification

| Risk | Severity | Mitigation |
|---|---|---|
| **Funnel keeps leaking / leads silently lost** | **HIGH** | WP001 + the AC-12 end-to-end lead-receipt test (form/wa.me/tel:) — the single most consequential unverified assumption; ops must confirm CF7 + SMTP + spam protection |
| **Entity collision** (Gonen Berlev shares "מאז 1999" + health framing) | HIGH | Differentiate on breath-THERAPY + cbDIDG + Mukesh lineage + named BMJ RCT; do **not** lean on "1999" |
| **Address-hiding ranking trap** | HIGH | D6 closed SHOW address; schema `areaServed` = GBP service area |
| **AI bots blocked at CDN/WAF (≈27% accidental-block trap)** | HIGH | AC-07 day-one `curl`-each-UA-for-200 test; do not defer to monitoring window |
| **Cutover regression** (301 chains, noindex stuck, sitemap 404, thin routes) | HIGH | WP012 list-mode audit + AC-13/AC-14; SEO-B2/B3/B5 resolved pre-cutover |
| **Schema collision** (two engines) | MEDIUM | D4 theme-native single source; plugin schema OFF if ever added |
| **YMYL over-claim** | MEDIUM | D9 responsible-claims pass + citations + visible disclaimer |
| **Review-policy penalty** (incentive/gating) | MEDIUM | WP011 no-incentive, no-gating engine; never חינם/הנחה/הגרלה |
| **D10/EYL latency stalls the gated go-live** | MEDIUM | Promote D10 to day-one owner ask; freeze `/about/moksha/` slug |
| **D12 keyword-volume uncertainty inflates WP010** | MEDIUM | Verify in GSC **before** sizing; or scope WP010-phase-1 to the 3 justified spokes |
| **Wasted effort on deprecated/decoration assets** | LOW | Explicit out-of-scope list (§2) |
| **Stale-date anti-pattern** | LOW | Auto-archive expired events; truthful sitemap lastmod |
| **Governance/DB drift (file vs DB)** | MEDIUM | File-canonical now; one reconciliation pass on actor-key arrival (§7) |

---

## 11. Success metrics / KPIs

Baseline is set **at the WP012 cutover** (staging is noindex — pre-cutover numbers are artifacts); deltas measured thereafter. The #1 goal (AI-driven organic) is unmeasurable until conversions fire, so **AC-02/AC-12 must pass first.**

- **Conversion (core path):** `generate_lead` events (intro-call CTA click / WhatsApp open / form submit) segmented by landing page + AI referrer; lead-receipt confirmed (AC-12); GBP actions (calls, directions); review velocity **~3–10/month** with owner reply **≤24h**.
- **Classic search (GSC):** organic clicks/impressions; position + impressions for question-form long-tail + geo terms; clicks to /treatment, /method, the sleep-apnea pillar; breadcrumb rich-result status; field CWV pass rate (LCP ≤2.5s target) post-cutover.
- **AI discovery (GA4 + manual):** referral sessions from `chatgpt.com` / `perplexity.ai` / `gemini.google.com` / `bing.com`; AI-assisted landing pages; **quarterly manual citation audit** — does ChatGPT/Perplexity/AI-Overviews name Eyal for "טיפול בדיג'רידו", "דיג'רידו לדום נשימה בשינה", "מהי שיטת cbDIDG".
- **Earned corroboration (WP011):** running mention-log with the NAP form of every earned mention/link; quarterly AI-name check.
- **Crawlability (launch gate):** every named AI UA returns HTTP 200 against live URLs (AC-07).
- **Schema health:** `@graph` validates zero-error; FAQPage byte-identical to DOM (AC-04/AC-05).

---

## 12. Gate sequence (lean-kit)

`L-GATE_ELIGIBILITY → L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50, non-Claude) → L-GATE_VALIDATE (team_190, Codex)`. Per-WP gates run inside each sub-WP; the umbrella's L-GATE_VALIDATE asserts the 16 cross-cutting ACs above and `validate_aos.sh` 0 FAIL. **Cutover (WP012) carries an additional team_00 go-gate** before the irreversible Track-B operation.

---

## 13. Provenance & references (do not duplicate — build on)

- Strategy (LOD400): `_COMMUNICATION/team_100/LOD400-SEO-GEO-OPTIMIZATION-2026-06-19.md` (T1–T21, D1–D12, GEO/local/content/technical plans).
- Execution plan (13 WPs verbatim, per-WP specs, dependency view, critic pre-build blockers): `_COMMUNICATION/team_100/SEO-GEO-EXECUTION-PLAN-2026-06-20.md`.
- Completion-round SSoT (all gaps → M5/M6/M7; §7 DB/actor-key blocker): `_COMMUNICATION/team_100/COMPLETION-ROUND-ROADMAP-2026-06-20.md`.
- NAP SSoT: `_COMMUNICATION/team_100/BUSINESS-NAP-AND-HOURS-2026-06-16.md`.
- DB/actor-key request: `_COMMUNICATION/team_100/REQUEST-TEAM110-HUB-API-KEY-AND-DB-MIGRATION-2026-06-16.md`.
- Hub DB status (offline, 2026-06-20): `/Users/nimrod/Documents/agents-os/_aos/db_connectivity_status.json`.
- Live roadmap SSoT: `_aos/roadmap.yaml` (`active_milestone: S003`; S004 slot free, verified).

*This umbrella is the central launch mission. It governs the 13 sub-WPs as one tracked S004 Launch-Readiness milestone; it does not re-derive their specs. File-canonical now; DB-registerable on the team_110 actor key.*

---

## Appendix — pre-build corrections (completeness critic, 2026-06-20)

Stress-tested against the live repo. **Apply before/during build** — several override stale statements above:

### 🔴 Must-fix / corrections
- FACTUAL DEFECT (HIGH) — the '/about/moksha/' slug-freeze instruction is BACKWARDS against live code. The canonical WP (D10, AC-flow §4, risk table), the Validation+Deployment plan (§8.6, §1 WP-07/WP-12), and the cutover spec ALL repeatedly say to 'freeze canonical live slug /about/moksha/' so the 301 target + schema node agree. But the live, already-approved site-tree (WP-W2-16-D / D-EYAL-ABOUT-URL-15) makes the Mukesh-memorial canonical = '/eyal-amit/mokesh-dahiman/', and '/about/moksha/' is explicitly a LEGACY SOURCE that 301s to it (site/wp-content/themes/ea-eyalamit/inc/wave2-w2-02.php:182; matcher ea_wave2_is_moksha() at inc/wave2-w2-07.php:355-368 keys on post_name 'mokesh-dahiman' under parent 'eyal-amit'). If WP-02 builds the VideoObject/memorial schema @id/url on '/about/moksha/' and WP-12 freezes that as the 301 TARGET, the schema node and the redirect will point at a URL that itself 301s away — a guaranteed self-contradiction and a 2-hop chain that violates AC-13. Correct everywhere: canonical = /eyal-amit/mokesh-dahiman/; /about/moksha/ stays a 301 SOURCE only.
- STALE DECISION-GATE (HIGH) — D10 is mis-stated as 'OPEN — slug freeze pending' but the SLUG decision is already CLOSED in live code. The Mukesh memorial route, parent, and 301 wiring are committed (WP-W2-16-D). What is genuinely still owner-blocked is only the memorial CONTENT (facts/dates/full-film, EYL-2). The WP conflates 'slug not frozen' (false — it's frozen, just at a different slug than the WP claims) with 'content not supplied' (true). This mislabels what actually gates WP-07 and inflates the day-one owner ask. Re-scope D10 to content-only.
- VALIDATION GATE NOT RECONCILED (HIGH) — the master cutover gate script scripts/final_pre_cutover_check.sh STILL hard-asserts 'all 49 QR URLs -> 200' (lines 9, 110-111), which is exactly the wrong count the Validation plan §1(c)/§8(3) says must be corrected to 48 /qr/qrN/ + /qr/ = 200 and /qr/פרק-א/ = 410. The plan DOCUMENTS the needed fix but the machine gate was never changed, so a literal cutover run would either pass on a wrong premise or try to keep a 410'd URL alive. Worse: QR-URL-INVENTORY.csv row 1 notes the parent /qr/ currently 302-redirects to /shop/books/וכתבת/ ('may need fix') — so '/qr/ stays 200' is not even true today and there is no WP task assigned to fix that 302. The QR-count reconciliation is a paper decision with no code/CSV change behind it.
- BRAND-STRING REMEDIATION SCOPE UNDER-ENUMERATED (HIGH) — the Content-Proposals 'ground-truth' claims the dropped brand 'סטודיו נשימה מעגלית' lives in only 2 places (block-footer-social.php:64 + wave2-w2-04-content.php:559/729). It actually appears in 6 files / 12 occurrences across the live site: ALSO wave2-w2-07.php:1017,1020 (about/eyal-amit editorial), wave2-w2-14e.php:420 (press strip), AND two SEED files — ea-w2-02-core-pages-seed-once.php:246 and ea-w2-07-qr-content-data.php:600,649,651,653,654. The seed-file occurrences are baked into DB-seeded page content + QR pages, so a theme-string edit alone will NOT remove them from rendered output (AC-09 / the OV --absent 'סטודיו נשימה מעגלית' gate will FAIL on about/press/QR routes). WP-06/CP-BN proposals must enumerate all 6 files and define how seeded content is corrected (re-seed vs. content migration), not just the footer.
- INTERNAL-LINK / FAQPAGE-SCHEMA CONFLICT UNADDRESSED (MEDIUM-HIGH) — block-faq-list.php answers contain hardcoded internal links to LEGACY URLs that the 301 layer redirects: percent-encoded '/Blog/...' targets (lines 40, 105, 206) and legacy Hebrew '/דיגרידו-המרכז.../' deep paths (lines 263, 268, 273). Because AC-05 requires FAQPage JSON-LD be byte-identical to the rendered DOM, the emitted schema will encode links that 301-bounce, and AC-13 demands 'every 301 = single hop, no chains' — visitor/crawler clicks on these become avoidable redirects, and bot-followed schema links hit non-canonical URLs. No WP or AC covers auditing/repointing in-content internal links to canonical targets. Add an internal-link-canonicalization task (likely under WP-02 or WP-10) with a gate: zero in-content links to known-301 sources.
- AC-08 ALT-TEXT GAP IS WIDER THAN STATED (MEDIUM) — the WP flags only 'alt=get_the_title()' (confirmed at functions.php:460) and lists portrait/logo/book/product assets generically. But content images also ship with EMPTY alt: book covers at wave2-w2-05.php:961 (alt='') and the blog-card/book-detail thumbnails reuse get_the_title() (block-blog-card.php:34, template-book-detail.php:34, tpl-blog-single.php:23,29). Empty alt on a book COVER is a content image, not decorative — AC-08 says 'no empty alt on content images' but the WP never enumerates the cover/thumbnail surfaces, so a literal build could leave them. WP-05 needs an explicit alt audit list covering covers + post-thumbnails, with the is-decorative-vs-content rule stated.
- CF7 / LEAD-RECEIPT HAS NO OWNED DEADLINE OR FALLBACK SPEC (MEDIUM-HIGH) — AC-12 / §4 correctly name lead-receipt as 'the single most consequential gate' and EA_WAVE2_CF7_FORM_ID=0 + the 'TODO: set CF7 form ID after Eyal creates the form' (wave2-w2-07.php) confirm CF7 is not active. But the program treats CF7 activation + SMTP/deliverability + spam protection as a vaguely-owned 'ops/uPress dependency' with NO named owner task, NO date, and it gates the entire go-live. The §4 'fallback — if CF7 silently fails, wa.me+tel must still work' is stated as a principle but there is NO acceptance criterion asserting the contact page degrades gracefully when form_id=0 (today wave2-stage-b.php:354 renders a 'TBD' note with no tel:/WhatsApp fallback per the Wave-1 doc). Specify: (a) a named ops ticket with owner+date for CF7/SMTP/spam, and (b) an AC that the contact page ALWAYS exposes wa.me + tel: even when CF7 is inactive, tested before launch.
- DEC-SEO-B2 SITEMAP RECONCILIATION IS STILL UNDECIDED AND BLOCKS WP-04 (MEDIUM) — confirmed live drift remains: the 301 mu-plugin maps '/מפת-אתר-site-map/' -> '/sitemap_index.xml' (ea-w209-legacy-301-redirects.php:40) but the site is theme-native WP-core which emits /wp-sitemap.xml; '/sitemap_index.xml' 404s (no plugin, no alias). The WP lists this as 'OPEN — RECORD AT BUILD' but it is a hard prerequisite for WP-04's robots Sitemap: directive AND for cutover checklist item 8 (robots + 301 + GSC must name ONE url). Leaving it 'record at build' risks shipping robots.txt and the 301 pointing at a 404 sitemap. Decide now (add sitemap_index.xml->wp-sitemap.xml alias OR repoint the 301) so WP-04 and WP-12 can't proceed on a contradiction.
- WAVE-1 OMITS THE SEED-CONTENT BRAND FIX AND THE 302 /qr/ PARENT — both are buildable now (no Eyal input) but neither is in the Wave-1 buildable list. The brand string in seed/QR-data files (above) is pure code/data and decided (D1 closed) yet Wave-1 only claims 'footer brand-string fix'. The /qr/ parent 302->/shop/books/וכתבת/ is a code redirect fixable now and is required for AC-13/cutover item 6, yet appears nowhere in Wave-1. Both are wrongly absent from the buildable-now set.
- NO ROLLBACK CRITERIA FOR THE NON-CUTOVER (Track A) WORK — the program has a strong cutover rollback (restore-to-legacy) but the additive Track-A schema/CRO/analytics changes deploy to a LIVE staging→prod theme with no per-WP rollback/revert trigger defined. If WP-02 @graph injects malformed JSON-LD or WP-01's analytics un-gate double-fires generate_lead, the only stated safety net is the cross-engine dual-PASS pre-merge. Add an explicit post-deploy revert trigger + version-pin (style.css ver bump is mentioned for cache-bust but not as a rollback handle) for Track-A WPs, especially WP-01 (touches the sole working lead path) and WP-02 (sitewide head injection).

### 🟡 Risks
- The brief/WP/validation-plan repeatedly assert claims were 're-verified against the live repo on 2026-06-20', and most low-level claims DID verify (A/B display:none at ea-ab-testing.js:29; joint GA4+Clarity gate at wave2-stage-b.php:420; CF7 form id=0; bare lead-path wa.me; zero JSON-LD; block-all hub/dist/robots.txt; SEO-B1 post_parent===0 at wave2-w2-04.php:48). The credibility problem is concentrated in the higher-level CUTOVER/IDENTITY claims (the /about/moksha slug, the QR count, the brand-string file set) where the docs diverge from code — these are precisely the irreversible-cutover and entity-grounding areas where being wrong is most expensive.
- Several 'OPEN' decision-gates (D10 slug, parts of SEO-B2/SEO-B3) are actually already resolved-in-code or already-reconciled in a newer artifact (301-MAP-RECONCILIATION-2026-06-20.md quarantined the stale exports and fixed the /מוזה->/books drift), but the canonical WP and validation plan were not updated to reflect that newer reconciliation pass — the governance docs lag the repo, so a reader following the WP could re-do or mis-do already-settled work.
- The whole program's #1 KPI (AI-driven organic leads) is unmeasurable until AC-02 + AC-12 pass, and AC-12 depends on an ops dependency (CF7/SMTP/spam) that has no owner, no date, and no graceful-degradation AC — so the single most consequential gate is also the least-owned, creating a real risk the launch is declared 'done' on schema/CRO work while the lead funnel is still silently void.


---

## Appendix B — Yoast reality correction (2026-06-20, from the Wave-1 build)

**The "0% schema / hand-roll a JSON-LD @graph" premise above is WRONG.** It came from reading the theme *source*
(which has no JSON-LD) and missing the live *runtime*. Verified on staging:
- **Yoast SEO v27.8 is the active SEO engine.** It already emits a JSON-LD @graph (WebPage/WebSite/BreadcrumbList/
  SearchAction), OG + Twitter cards, `rel=canonical`, and the XML sitemap at **`/sitemap_index.xml`** (`/wp-sitemap.xml` 301s away).
- Yoast's graph **lacks** Organization/Person/LocalBusiness/Service/FAQPage — exactly the entity nodes we want.
- **No meta duplication:** inner pages have 1 `meta description` (the theme's service-specific copy) + 1 Yoast canonical; Yoast owns title/OG/Twitter/breadcrumb/sitemap, the theme owns the service descriptions — complementary.

**Corrected approach (implemented in Wave-1):**
- **W1-02 (built):** a mu-plugin (`ea-w2-seo-schema.php`) hooks Yoast's `wpseo_schema_graph` to ADD Person (+sameAs incl. the live he.wikipedia article), ProfessionalService (NAP), and Service-per-route — **one schema engine, no hand-rolled second @graph**.
- **W1-04 (verified):** no meta surgery needed (no duplication); the production robots.txt allow-list defers to the cutover (staging is noindex-gated).
- **W1-07 (resolved):** canonical sitemap = `/sitemap_index.xml` (Yoast) — the legacy 301 already targets it.

Net: the SEO machine-grounding is **smaller + lower-risk** than the plan assumed — extend Yoast, don't rebuild it. The LOD400/exec-plan "0% schema, JSON-LD is the cheapest big win, build a hand-rolled @graph" framing should be read through this correction.
