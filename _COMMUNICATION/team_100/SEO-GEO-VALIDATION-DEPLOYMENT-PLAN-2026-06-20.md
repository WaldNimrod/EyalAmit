<!-- team_100 SEO/GEO finalization — execution-prep workflow wf_2a85ad67-08d, 2026-06-20. Builds on LOD400 + exec plan + completion register. -->

# team_100 — DEEP VALIDATION + DEPLOYMENT PLAN (layered onto the 13 WPs)

**Project:** EyalAmit.co.il-2026 · **Owner:** team_100 (SEO/GEO delivery) · **Date:** 2026-06-20
**Scope:** the validation gate matrix + deployment choreography + cutover checklist that wrap the 13-WP backlog in `SEO-GEO-EXECUTION-PLAN-2026-06-20.md`. This **does not re-derive** the WPs — it tells you exactly *how each WP is proven before it ships* and *how the build reaches production safely*.

**Grounded in the real toolchain (verified 2026-06-20 against the repo):**
- Content-accuracy gate: `scripts/qa/content-diff.mjs` (gate = `sectionCov>=95 AND sentenceCov>=90 AND inventedSections=0`; exits via `summary.json`)
- a11y gate: `scripts/qa/http-qa-axe.cjs` (axe-core wcag2a/2aa; **exit 0 only if every route 0 critical + 0 serious**)
- responsive/overflow gate: `_aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs` (CDP scrollWidth vs clientWidth, `--absent` forbidden-term scan, `--shots`)
- full journey E2E: `scripts/qa/cr-final-e2e.cjs` (nav hrefs, verbatim phrase checks, redirect-chain follower, purchase links)
- perf: `scripts/qa/http-qa-lighthouse.sh` (measures over **HTTPS** to drop the http→https 301 artifact)
- deploy: `scripts/ftp_deploy_site_wp_content.py` (child theme + mu-plugins → staging), `scripts/ftp_deploy_w2_06_blog.py` (blog WP), `scripts/ftp_publish_eyal_client_hub.py` (hub, **prunes** by default)
- 301/cutover: `scripts/gen_htaccess_301_from_decisions.py` (from `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json`), `scripts/final_pre_cutover_check.sh`, `scripts/verify-301-blog.sh`
- cutover spec: `_COMMUNICATION/team_100/LOD200-PRODUCTION-CUTOVER-2026-06-16.md` (Track B)

**Staging base (canonical, hard-coded in every runner):** `http://eyalamit-co-il-2026.s887.upress.link` (HTTP-only, `noindex` by `ea-staging-noindex.php` — **by design**, per CLAUDE.md TLS discipline).

---

## 0. Three platform facts that shape every gate (do not violate)

1. **nginx/uPress, `.htaccess` is INERT.** `gen_htaccess_301_from_decisions.py` itself documents that "Apache .htaccess RewriteRules are IGNORED" on this host. **The live redirect mechanism is the mu-plugin `ea-w209-legacy-301-redirects.php`.** The generated `.htaccess` block is a *portable artifact / human-readable SSoT*, not the runtime. Every redirect gate must test the **live HTTP response**, never assume the `.htaccess` file is doing anything.
2. **Staging is HTTP + noindex.** SEO and Best-Practices Lighthouse scores are **staging-capped artifacts** (accepted disposition AC-05). Only **Performance ≥90 and Accessibility ≥90 are gated on staging**; SEO/BP/CWV are *re-measured on the production HTTPS domain* at cutover. Never sign off CWV from staging.
3. **Cross-engine duality is constitutional (Iron Rules #1, #5).** The builder engine ≠ the validator engine. team_50 runs the build-side journey proof; **team_190 owns final validation and is immutable.** A WP is not "PASS" until it has a **dual-PASS** (build-engine green + validator-engine green on a different engine).

---

## 1. Per-WP validation gates

Legend for automated gates: **CD** = `content-diff.mjs` · **AX** = `http-qa-axe.cjs` · **OV** = `qa_probe.mjs` · **E2E** = `cr-final-e2e.cjs` · **LH** = `http-qa-lighthouse.sh` · **PRE** = `final_pre_cutover_check.sh`. External tools named inline.

> **Universal floor (every WP, before its own gate):** the touched routes must keep **CD pass** (no content regression — `inventedSections=0` is the hard one: a new JSON-LD/UI block that injects visible H2/H3 text not in Eyal's source will fail it), **AX 0 crit/0 serious**, and **OV no overflow at 360/390/414/768/1440**. These three are the regression net; the per-WP rows below are *additive*.

### P1 — Quick wins

| WP | Automated gate(s) | External / manual validation | Hard pass criteria |
|---|---|---|---|
| **WP-01 Conversion repair + GA4 un-gate** | E2E (CTA/nav hrefs, no console errors); OV with `--absent "form_only-hidden,display:none"` smoke on `.ea-whatsapp-float`; AX on `/contact/` (the form is a YMYL a11y surface) | **LEAD-DELIVERABILITY E2E (the single most consequential test — see §4):** submit one real lead via each path — (a) CF7 form, (b) `wa.me` prefilled link, (c) `tel:` — and confirm receipt in Eyal's inbox (not spam) + `generate_lead` GA4 event fires (GA4 DebugView / Realtime). GA4 G-MRXESK7QJF live-fire check via Realtime. wa.me URL contains `?text=` with page-aware Hebrew. | WhatsApp float visible to **100%** of sessions (A/B hide branch paused); GA4 hit recorded in Realtime; **a real test lead arrives in Eyal's inbox via all 3 paths**; `generate_lead` event recorded. CF7 must be **active on the server** (form_id ≠ 0) — this is an ops dependency, not theme code (appendix blocker). |
| **WP-04 Crawl-policy + meta head pack** | CD (titles/meta must not inject body text that trips inventedSections); OV (breadcrumb UI no overflow) | **Schema/meta:** Google Rich Results Test + Schema.org validator on BreadcrumbList. **`<title>`/meta/canonical/OG/hreflang:** curl each route, assert one self-referencing canonical, 150–160-char meta, og:image 1200×630 resolves 200, reciprocal hreflang pairs, `/en` gets `lang=en dir=ltr`. **Twitter/OG render:** card validators. **robots.txt:** the AI-bot 200 curl matrix (§5) — run the day robots.txt goes live, not bundled into monitoring. | One canonical/route; OG image 200; hreflang reciprocal; **AI UAs (OAI-SearchBot, ChatGPT-User, PerplexityBot, Claude-SearchBot, Claude-User, Google-Extended/GPTBot per D3) get HTTP 200, never 403** on 3 live URLs. **Reconcile the sitemap URL contradiction (appendix blocker): robots `Sitemap:` directive, the legacy 301 target, and the GSC submission must all name the SAME url.** Live 301 maps `/מפת-אתר-site-map/ → /sitemap_index.xml`; theme-native has no `/sitemap_index.xml`. Decision required: add a `sitemap_index.xml → wp-sitemap.xml` alias OR repoint the 301 — whichever, all three references must agree, verified by a single-hop redirect-chain check. |
| **WP-05 Image hygiene + WebP/LCP** | OV `--shots` (visible captions render, no layout shift from width/height attrs); CD (figcaption promotion from `ea-sr-only` to visible adds visible text — confirm it's source-faithful so inventedSections stays 0) | **LH** on `/`, `/treatment/`: **LCP ≤ 2.5s** with hero poster `fetchpriority=high`; below-fold `loading=lazy`. WebP served via `<picture>` (curl `Accept: image/webp`). Image XML sitemap (`wp_sitemaps_*` filter) validates + is referenced from robots.txt. Alt-text audit: no `alt=get_the_title()`, no empty `alt=''` on content images. | LCP ≤2.5s (re-confirm on prod HTTPS); CLS < 0.1 (explicit width/height present); image sitemap 200 + well-formed; every content image has keyword-natural Hebrew alt + visible caption where specified. |
| **WP-09 Off-site authority (GBP/Wikidata/dirs/YT)** | n/a (off-site) — but it **feeds** WP-02 | **Manual:** GBP NAP byte-identical to NAP SSoT (`BUSINESS-NAP-AND-HOURS-2026-06-16.md`); Wikidata item created + linked to he.wikipedia + `sameAs` chain captured. Each live profile URL must later appear in WP-02 `#person.sameAs` and round-trip-validate in the Schema validator. | NAP byte-identical across GBP + site + schema; every claimed `sameAs` URL resolves 200; logged in `_COMMUNICATION/team_100/`. |

### P2 — Foundational

| WP | Automated gate(s) | External / manual validation | Hard pass criteria |
|---|---|---|---|
| **WP-02 JSON-LD `@graph`** | CD (FAQPage must be generated **byte-identical** from the same arrays the visible accordions render — CD on `/faq/` proves the visible side; a node-vs-DOM diff proves the JSON side); AX | **Schema.org validator + Google Rich Results Test on EVERY route** (not just home): assert connected `@graph` (`#person worksFor #business`, Service-per-route, BreadcrumbList, ImageObject cross-refs as `primaryImageOfPage`). **Honors prohibitions:** no `areaServed:Israel` default, no precise geo until D2 lat/long, **no self-serving AggregateRating**, no VideoObject on the muted hero loop. **Route-completeness audit (appendix blocker):** enumerate `/shows/ /repair/ /bags/ /stand-floor/ /stands-storage/ /books/vekatavta/ /books/kushi-blantis/ /about/moksha/ /press/` + the 48 `/qr/qr*/` — each must get a schema node OR be explicitly noindex, never silently thin. | Rich Results Test = "valid, eligible" for Breadcrumb + FAQ (FAQ for AI-extraction only — no Google rich result expected, deprecated); zero errors in Schema validator on all enumerated routes; no two schema engines emit (D4). |
| **WP-03 Sleep-apnea pillar + press kit** | CD on the new pillar route (40–100w lede + RCT facts must be present, verbatim); E2E verbatim-phrase check extended to the BMJ/Puhan + JCSM citations | **URL/injector reconciliation (appendix blocker — currently not buildable):** `wave2-w2-04.php` injects **top-level pages only** (`post_parent === 0`). Decision: ship the pillar as **top-level `/sleep-apnea-snoring`** OR extend the injector to accept a parent slug. Validate the chosen route actually receives W2-04 content/blocks/JSON-LD injection (CD on it returns measured sections, not N/A). **Schema:** Article + FAQPage + `citation` nodes validate in Rich Results Test; outbound links to BMJ/JCSM resolve 200. **D9 health-claim conservatism:** visible disclaimer + "התייעצו עם איש מקצוע רפואי" present; no cure/efficacy claims. | Pillar route returns CD-measured content (proves injection works); citations resolve; disclaimer present; press-kit sub-block is a stable anchor target for WP-11. |
| **WP-06 NAP lock + footer + geo** | CD (footer brand string must drop "סטודיו נשימה מעגלית" — run OV `--absent "סטודיו נשימה מעגלית"` across all routes to prove it's gone everywhere) | NAP byte-identical: site footer == `/contact/` == WP-02 `#business` node == WP-09 GBP == NAP SSoT. `areaServed` (schema) == GBP service area (D2 bounded GeoCircle, NOT Israel). | `--absent "סטודיו נשימה מעגלית"` passes on every route; four-way NAP byte-match; areaServed matches GBP. |
| **WP-07 Video facade + transcripts + VideoObject** | OV/LH (the facade must NOT regress LCP/INP — real iframe loads on click only); CD (visible transcripts add extractable text — must be human-corrected, source-faithful) | **CWV impact (appendix blocker):** the **48 `/qr/qr*/` pages embed RAW YouTube iframes** — the largest existing video footprint, owned by neither WP-05 nor WP-07. Assign here: LH on 2–3 sample `/qr/qrN/` pages — facade-convert or at minimum lazy + transcript; assert INP ≤200ms, LCP ≤2.5s. **VideoObject** only on real watchable embeds, nested as `video` of the page's Article/BlogPosting node — validate in Rich Results Test; assert **no** VideoObject on the muted hero loop. D10 (Moksha facts) blocks the memorial embed — promote to day-one owner ask. | Facade defers iframe (network panel: no youtube request until click); INP ≤200ms + LCP ≤2.5s on QR + embed pages; VideoObject valid + correctly nested; canonical slug frozen `/about/moksha/`. |
| **WP-08 Honest commerce schema + buying guide** | CD on the 5 shop pages + `/didgeridoos/` buying guide; E2E purchase-link reachability (pattern already in `cr-final-e2e.cjs PURCHASE_LINKS`) | **Schema:** Rich Results Test "Merchant listings"/Product — assert Offer node emitted **only where `ea_product_price` is `is_numeric`**; **OMIT offers entirely for "מחיר לפי התאמה"** (appendix refinement — define the rule as `is_numeric()` so the build never emits a fake/zero Offer). No Merchant Center / Shopping feed. | Product nodes valid; zero zero-price/fake Offers; "מחיר לפי התאמה" pages emit name/image/description only; buying-guide content present (CD). |

### P3 — Ongoing / cutover

| WP | Automated gate(s) | External / manual validation | Hard pass criteria |
|---|---|---|---|
| **WP-10 Blog cluster + freshness** | CD per spoke; E2E (hub↔spoke + lateral internal links resolve, no console errors); OV | **BlogPosting** nodes validate (author=#person, accurate datePublished/dateModified, visible "עודכן לאחרונה"). **D12 sequencing (appendix refinement):** verify Hebrew keyword volumes in GSC/Keyword-Planner BEFORE sizing word-count; phase-1 = only the 3 strategy-justified spokes (sleep-apnea / cbDIDG / circular-vs-rebirthing disambiguation) which need no volume data. Auto-archive expired events so sitemap `lastmod` stays honest. | BlogPosting valid; dates real; internal links 200; phase-1 scoped to the 3 justified spokes until D12 closes. |
| **WP-11 Digital-PR + reviews + mentions** | n/a (off-site) | Reviews engine **policy-safe**: no incentive, no gating, owner reply ≤24h — manual audit of review text for חינם/הנחה/הגרלה (auto-fail if present). Mention-log in `_COMMUNICATION/team_100/` with NAP form of each mention. `/eyal-amit/` "בתקשורת" strip renders coverage. | Reviews policy-compliant; mention-log maintained; coverage strip live; press-kit (WP-03) is the link target. |
| **WP-13 Measurement + KPI baseline** | E2E (CTA clicks map to one `generate_lead` event) | **GA4 DebugView:** intro-call / WhatsApp-open / form-submit all fire **one** `generate_lead` event segmented by landing page + AI referrer (`chatgpt.com`, `perplexity.ai`, `gemini.google.com`, `bing.com`). GSC property verified for `https://www.eyalamit.co.il`. Baseline captured **at cutover** (staging numbers are artifacts). | All 3 paths → `generate_lead`; GSC property verified; baseline snapshot stored at cutover (not before). |
| **WP-12 Cutover (Track B)** | **PRE** (`final_pre_cutover_check.sh`) — the master gate (a→e below); `verify-301-blog.sh`; E2E redirect-chain follower | Full §6 cutover checklist. Gated by D10 (Moksha 301 target). | PRE exits 0; §6 checklist fully green; team_190 sign-off; Eyal go-live approval recorded. |

**`final_pre_cutover_check.sh` asserts (the WP-12 master gate), all cache-busted:**
- **(a)** every in-use media URL → 200 (from `MEDIA-IN-USE-INVENTORY-REGEN-2026-05-30.json`)
- **(b)** every generated **301** → single 301 hop whose Location resolves to a **200**; every **410** → 410 (parses `htaccess_301_block.txt`; literal page-level rules only)
- **(c)** all **49 QR URLs → 200** — **but correct the count per appendix blocker:** 48 `/qr/qrN/` + parent `/qr/` stay **200**; legacy `/qr/פרק-א/` stays **410** (the blanket "49 must stay 200" is wrong and would try to keep a 410'd URL alive). Reconcile `QR-URL-INVENTORY.csv` to this before running.
- **(d)** `validate_aos.sh` → 0 FAIL
- **(e)** Lighthouse home: **GATE Perf & A11y ≥90**; SEO/BP recorded as staging-capped (→100 at cutover)

---

## 2. The standing QA harness (run order on any staging deploy)

```
1. content-diff.mjs   --base <staging>   → summary.json: every measured page gatePass=true
2. http-qa-axe.cjs     [routes]          → exit 0 (0 critical/0 serious every route)
3. qa_probe.mjs        --config <cfg> --shots → verdict PASS (no overflow @ 360/390/414/768/1440; no forbidden term)
4. cr-final-e2e.cjs                       → all checks pass (nav, verbatim phrases, redirect chains, purchase links, 0 console errors)
5. http-qa-lighthouse.sh  / /treatment/   → Perf≥90 A11y≥90 (SEO/BP staging-capped)
```
All five write JSON evidence under `_COMMUNICATION/team_XX/evidence/`. A WP closes only when its build-engine run AND the validator-engine (team_190, different engine) run are both green.

---

## 3. Schema / Rich-Results validation protocol (WP-02/03/07/08/10)

Because the site is **theme-native, hand-rolled JSON-LD (D4)** there is no plugin to lean on — every node is validated externally per route:

1. **Schema.org validator** (validator.schema.org) — paste rendered HTML per route; **0 errors** required. Catches malformed `@graph`, broken cross-refs, wrong subtype.
2. **Google Rich Results Test** (search.google.com/test/rich-results) — per route; assert eligibility for BreadcrumbList (rich), Product (where numeric), VideoObject; FAQPage shows "detected" but **no Google rich result expected** (deprecated — kept for AI extraction only).
3. **Connected-graph assertion** — script-extract every `@id`/`@type`; assert `#person worksFor #business`, each Service references its route, ImageObject is `primaryImageOfPage`. A dangling `@id` = fail.
4. **Prohibition lint** — grep rendered JSON-LD for `AggregateRating`, `areaServed":"Israel"`, `HealthAndBeautyBusiness`, VideoObject on hero → any hit = fail (these are explicit D5/D2 violations).
5. **Run on production after cutover too** — staging noindex doesn't affect schema, but the canonical/`url` fields change host at cutover; re-validate.

---

## 4. LEAD-DELIVERABILITY test (the one gate the whole program lives or dies on)

The #1 business goal is therapy leads, and the appendix flags this as **"the single most consequential unverified assumption."** Instrument-firing (WP-13) proves a *click*; this proves *receipt*. Run before WP-01 closes AND again post-cutover:

1. **CF7 path** — confirm CF7 **active on server** (`ea_wave2_cf7_form_id` resolves ≠ 0; gated on `class_exists('WPCF7_ContactForm')` — an **ops dependency on uPress**, not a theme commit). Submit a real test lead → confirm it lands in **Eyal's inbox, not spam** (verify SMTP/deliverability + spam protection honeypot/Turnstile). A silent void = hard fail.
2. **wa.me path** — open the prefilled link → assert WhatsApp opens with the page-aware Hebrew `?text=`.
3. **tel: path** — assert dialer opens with E.164 `+972-52-482-2842`.
4. **Event fire** — each of the 3 records exactly one `generate_lead` in GA4 DebugView/Realtime.
5. **Fallback** — if CF7 email silently fails, the WhatsApp+tel path must still be reachable (no single point of failure on the lead funnel).

Owner of (1)'s server-side (CF7 activation, SMTP, spam protection): **named ops/hosting task on the WP-12/ops track** — not assumed "confirmed."

---

## 5. AI-bot crawlability check (the highest-leverage GEO lever — run the day robots.txt goes live)

Per appendix refinement, this must NOT be buried in the 2–4 week monitoring window. For each UA, curl 3 live URLs and assert **HTTP 200, never 403/blocked** (CDN/WAF must not eat the AI UAs):

```bash
for UA in "OAI-SearchBot/1.0" "ChatGPT-User/1.0" "PerplexityBot/1.0" \
          "Claude-SearchBot/1.0" "Claude-User/1.0" "GPTBot/1.1" "Google-Extended"; do
  for U in / /treatment/ /sleep-apnea-snoring/ ; do   # use the real pillar slug per WP-03 decision
    code=$(curl -s -A "$UA" -o /dev/null -w "%{http_code}" "https://www.eyalamit.co.il$U")
    echo "$UA $U -> $code"   # expect 200
  done
done
```
Re-verify exact UA tokens at build time (they drift). Confirm `robots.txt` **allows** these + Googlebot/Bingbot, declares the **single agreed sitemap URL**, and is **NOT** the block-all `hub/dist/robots.txt` artifact.

---

## 6. Deployment choreography

### 6.1 Staging deploy + validate (every WP, repeatable)

```
1. BUILD locally — edit child theme / mu-plugins under site/wp-content/
2. BUMP style.css Version (e.g. 1.4.0 → 1.4.1)  ← cache-bust; WP enqueues by ver
3. DEPLOY:  python3 scripts/ftp_deploy_site_wp_content.py --dry-run   (review file list)
            python3 scripts/ftp_deploy_site_wp_content.py
   (blog WP only:  python3 scripts/ftp_deploy_w2_06_blog.py)
4. ACTIVATE — hit staging homepage once (HTTP) so ea-m2-auto-activate-child.php switches theme;
   import WXR/menus/forms via wp-cli/admin if the WP seeds content
5. STAGING QA — run the §2 harness in order (CD → AX → OV → E2E → LH)
6. SCHEMA/RICH-RESULTS — §3 protocol on touched routes
7. CROSS-ENGINE DUAL-PASS — team_50 build-engine green AND team_190 validator (different engine) green  (Iron Rules #1/#5)
8. HUB PUBLISH (only for Eyal-facing surfaces) — see 6.2
```
`ftp_deploy_site_wp_content.py` ships the **whole child theme tree + the full mu-plugin set** including `ea-staging-noindex.php` and `ea-w209-legacy-301-redirects.php` (the live redirect engine) — so staging always mirrors what production will run, minus the noindex no-op.

### 6.2 Hub publish (Eyal-facing surfaces only)

```
python3 scripts/build_eyal_client_hub.py [--mirror-docs]
python3 scripts/ftp_publish_eyal_client_hub.py --dry-run     (review upload + PRUNE list)
python3 scripts/ftp_publish_eyal_client_hub.py               (PRUNES remote orphans by default)
```
**Caution:** the publisher **prunes remote files not present in local dist** by default — only run after `build_eyal_client_hub.py` so you don't delete live hub pages. The block-all `hub/dist/robots.txt` lives here and must **never** be the production site robots.txt (WP-04/WP-12 publish a real one).

### 6.3 Gated production cutover (Track B — the one irreversible op)

Per `LOD200-PRODUCTION-CUTOVER-2026-06-16.md`. Resolve the blocking decisions first (**D-CUT-1** uPress-promote vs mezoohost; **D-CUT-2** in-place vs blue/green; **D-CUT-5** credentials).

```
PRE-CUTOVER
  1. Full backup (DB + files) of current production legacy site  ← rollback insurance
  2. Final staging sign-off: §2 harness green + team_190 sign-off
  3. Regenerate 301 SSoT:  python3 scripts/gen_htaccess_301_from_decisions.py
     → quarantine the two STALE exports that disagree (they send /צור-קשר/→/ and studio
       sub-pages lazily→/ instead of the live mu-plugin's correct topical targets).
       ea-w209-legacy-301-redirects.php is the SOLE live mechanism.
  4. Build consolidated migration inventory (135-decision JSON + legacy mapping + GSC top
     pages + GA4 landing pages + wp-sitemap); classify each URL:
       keep-200 | 301 | 410 | QR-protected-200
     CORRECTED counts: 48 /qr/qrN/ + parent /qr/ = 200 ; /qr/פרק-א/ = 410.
  5. Maintenance/freeze window opens.

DEPLOY + CONFIG TO PRODUCTION
  6. Deploy theme + mu-plugins + seeded content to production WP; verify parity with staging.
  7. wp-config: remove noindex/staging guards; set real WP_HOME/WP_SITEURL (www canonical);
     valid production TLS; CF7 recipient; GA4 G-MRXESK7QJF + Clarity IDs.
  8. Publish the REAL production robots.txt (NOT hub/dist block-all); single agreed Sitemap: URL.

GO-LIVE
  9. Switch domain / in-place activation → new site serves at www.eyalamit.co.il.

POST-CUTOVER VERIFY (must pass before window closes)  → §7 checklist
  10. bash scripts/final_pre_cutover_check.sh           (a–e all green; run against PROD now)
  11. bash scripts/verify-301-blog.sh https://www.eyalamit.co.il   (/Blog/ catch-all 301→/blog/)
  12. Re-run §2 harness + §3 schema + §5 AI-bot matrix against PRODUCTION HTTPS
  13. Re-run §4 lead-deliverability on production
  14. Re-measure SEO + CWV on the real HTTPS domain (staging numbers were artifacts)

ROLLBACK — if ANY gate fails within the window → restore-to-legacy from step-1 backup.
```

---

## 7. Cutover validation checklist (post-go-live, production HTTPS)

| # | Check | Tool / method | Pass |
|---|---|---|---|
| 1 | **noindex lifted** | curl 8+ live URLs; assert no `noindex` in `<meta robots>` or `X-Robots-Tag`; `ea-staging-noindex.php` no-ops on prod host (host check + WP_HOME/WP_SITEURL assertion) | 0 pages with noindex |
| 2 | **TLS valid (production)** | `curl -Iv https://www.eyalamit.co.il` — valid cert, no `-k` | valid chain (prod cert error = real defect) |
| 3 | **www canonical** | non-www + http → single 301 → `https://www.` | single-hop to www HTTPS |
| 4 | **Redirect-chain audit** | `final_pre_cutover_check.sh` (b) + `cr-final-e2e.cjs` follower: every legacy 301 = **single hop to a 200**, no chains/loops; every 410 = 410 | 0 chains, 0 broken targets |
| 5 | **/Blog/ catch-all** | `verify-301-blog.sh https://www.eyalamit.co.il` — `^Blog/(.+)$ → /$1` 301→`/blog/` | 3/3 PASS |
| 6 | **QR surface** | 48 `/qr/qrN/` + `/qr/` = 200; `/qr/פרק-א/` = 410 | exact counts match |
| 7 | **404 audit** | crawl the full migration inventory; every legacy URL is keep-200 / 301 / 410 — **zero unexpected 404** | 0 stray 404 |
| 8 | **Sitemap submit + resubmit** | submit the **single agreed sitemap URL** in GSC; confirm the robots `Sitemap:` directive + legacy 301 target + GSC entry all name it; resubmit after deploy | sitemap accepted, no read errors, URLs all agree |
| 9 | **GSC baseline + URL Inspection** | URL-inspect 5–8 key routes (live test, "URL is on Google" path); set Coverage/Page-Indexing/Crawl-Stats baseline; **monitor 2–4 weeks** | indexable, no coverage errors at baseline |
| 10 | **robots AI-bot 200 check** | §5 matrix against production (CDN/WAF live now) | all UAs 200, never 403 |
| 11 | **Schema on prod** | §3 protocol — `url`/canonical now point at prod host | 0 errors, rich-result eligible |
| 12 | **Lead deliverability (prod)** | §4 — real lead via form/wa.me/tel reaches Eyal's inbox + fires `generate_lead` | all 3 paths receipt-confirmed |
| 13 | **CWV re-measure (prod)** | `http-qa-lighthouse.sh` over HTTPS + CrUX/PSI field data: **LCP ≤2.5s, INP ≤200ms, CLS <0.1** | all three pass on field data |
| 14 | **Analytics + baseline capture** | GA4 Realtime confirms hits; capture the WP-13 GSC+GA4 baseline snapshot **at cutover** | data flowing; baseline stored |
| 15 | **Final sign-off** | `final_pre_cutover_check.sh` exit 0; team_190 cross-engine sign-off; **Eyal/team_00 go-live approval recorded** | all recorded |

---

## 8. Open items this plan surfaces (decision-gated, must close before the WPs they block ship)

These are the **appendix pre-build blockers re-expressed as validation gates** — each is unverifiable/unbuildable until resolved:
1. **WP-03 injector/URL mismatch** — `wave2-w2-04.php` is top-level-only; pillar must be top-level OR the injector extended. *Validation: CD on the pillar route returns measured content, not N/A.*
2. **Sitemap URL contradiction** — `wp-sitemap.xml` (WP-core) vs live 301 target `/sitemap_index.xml` (no such file theme-native). *Validation: robots + 301 + GSC name one URL; single-hop chain check.*
3. **QR count** — 48 `/qr/qrN/` + `/qr/` = 200; `/qr/פרק-א/` = 410 (not "49 stay 200"). *Validation: `final_pre_cutover_check.sh` (c) reconciled to corrected `QR-URL-INVENTORY.csv`.*
4. **CF7 server activation** — ops dependency on uPress; form_id=0 until active. *Validation: §4 path (1) receipt.*
5. **Lead deliverability has no acceptance criterion in the WP plan** — added as §4 here (hard gate).
6. **D10 Moksha facts** — owner-dependent, blocks WP-07 + WP-12 memorial 301; canonical slug frozen `/about/moksha/`. *Promote to day-one owner ask alongside D1/D6/D11.*
7. **Route-completeness for the machine layer** — `/shows/ /repair/ /bags/ /stand-floor/ /stands-storage/ /books/* /about/moksha/ /press/` + 48 QR pages must get schema/meta/OG OR explicit noindex (WP-02/WP-04). *Validation: §3 enumerated-route audit.*
8. **48 QR raw iframes** — assigned to WP-07 for facade/lazy/transcript + CWV. *Validation: LH INP/LCP on sample QR pages.*
9. **WP-08 Offer rule** — `is_numeric()` decides Offer-vs-omit; never a fake/zero price. *Validation: schema lint for zero-price Offers.*
10. **AI-bot check sequencing** — run the day robots.txt goes live (§5), not in the monitoring window.

---

*This plan is the validation/deployment layer team_100 executes alongside the 13-WP backlog. Each WP closes only on its per-WP gate (§1) + the universal regression floor + a cross-engine dual-PASS (§2). The build reaches production only through the gated Track B choreography (§6.3) and the 15-point cutover checklist (§7), with `final_pre_cutover_check.sh` as the machine gate and team_190 + Eyal as the human gates.*