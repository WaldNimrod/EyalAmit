# AOS HANDOFF — team_100 → fresh SEO/GEO continuation session · depth: FULL

**Mechanism:** `/AOS_handoff 100 full` → `/AOS_mail handoff` → hub API; hub DB is **offline** (db_connectivity offline; team_110 actor key blocked) → **file-transport fallback** (ADR043 §4/§5). This file IS the handoff artifact.
**Engine:** team_100 (Claude Code) · **Generated:** 2026-06-20 · **Profile:** L0 spoke
**Repo:** `/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`
**git:** `main @ 817e05b` (Wave-1 SEO/GEO + session work merged; theme `1.4.14`) · branch `wave1b-seo-geo @ 5b0493c` (deployed to staging, **pending Round-2 dual-PASS**). origin push NOT done (awaits explicit "פוש"). Staging: `http://eyalamit-co-il-2026.s887.upress.link`.

## Mission
Continue the SEO/GEO program: **(1) validate everything already built, (2) drive the open validation→merge to closure, (3) prepare/refine the completion plan + task definitions** for the remaining (mostly Eyal-gated) work. SEO/GEO is the client's #1 objective (organic discovery via Google + AI engines).

## §A — Reality you must internalize FIRST (corrects the original plan)
**Yoast SEO v27.8 is the LIVE schema engine.** The LOD400/exec-plan premise of "0% schema, hand-roll a JSON-LD @graph" was WRONG (the agents read theme source, not runtime). Yoast already emits WebPage/WebSite/BreadcrumbList + OG/Twitter + canonical + the sitemap `/sitemap_index.xml`. The corrected, IMPLEMENTED approach: **extend Yoast's single @graph** via `wpseo_schema_graph` (mu-plugin `ea-w2-seo-schema.php`) — never a second engine. Full correction: `WP-S004-P001-WP000-…md` Appendix B.

## §B — What's DONE + LIVE (validate it)
**Wave-1 (merged to `main`, dual-PASS Round-1 team_50+team_190):** W1-01 conversion repair (WhatsApp+form for all; GA4 `G-MRXESK7QJF` fires independent of Clarity; `generate_lead`; wa.me pre-fill via `ea_wave2_wa_url()`), W1-02/W1-08 Yoast @graph extension (Person+sameAs[he.wikipedia], ProfessionalService+NAP, Service/route, Product/Offer numeric-only), W1-06 `/Blog/→/blog/` 301.
**Wave-1b (on `wave1b-seo-geo`, deployed to staging, LOCAL QA green, NEEDS Round-2 dual-PASS):** `/shop/cart|checkout|my-account → /shop/` 301; per-route meta descriptions (9 bare routes, `ea_w2_09_route_description()`); contact-page visible NAP/hours (BLD-4); LCP `fetchpriority` on /eyal-amit.

**→ IMMEDIATE NEXT (validation to closure):** the Round-2 mandate is written: `MANDATE-VALIDATE-WAVE1B-2026-06-20.md` (gates + team_50 activation prompt). Get team_50→team_190 dual-PASS, then **merge `wave1b-seo-geo` → main on Nimrod's explicit go**. Re-run the gates yourself too (`scripts/qa/content-diff.mjs`, `http-qa-axe.cjs`, `_aos/…/qa_probe.mjs`, the redirect/analytics probes `scripts/qa/wave1-*`).

## §C — Completion plan + the canonical WP (refine the tasks here)
- **Canonical umbrella WP:** `WP-S004-P001-WP000-SEO-GEO-FINALIZATION-2026-06-20.md` (13 sub-WPs, LOD400, + critic appendix + Yoast Appendix B). File-canonical; DB registration blocked on team_110 key.
- **Execution plan:** `SEO-GEO-EXECUTION-PLAN-2026-06-20.md` (P1/P2/P3 + WP-12 cutover) + `SEO-GEO-VALIDATION-DEPLOYMENT-PLAN-2026-06-20.md`.
- **The roadmap SSoT:** `COMPLETION-ROUND-ROADMAP-2026-06-20.md` (status snapshot + the precise done / deferred / Eyal-gated lists). **Keep this current** — it is the single completion tracker.
- **Refine remaining tasks:** the highest-value remaining build (gated on Eyal content) is the **sleep-apnea/snoring pillar** (CP-01) + answer-first tightening — the #1 organic-traffic lever. When Eyal approves the content proposals (hub), build it (note SEO-B1: must be a TOP-LEVEL page — `wave2-w2-04.php` injects only `post_parent==0`).

## §D — Remaining work
**🟡 Non-blocked, deferred (low ROI / cutover-time / risk):** full WebP `<picture>` pass (cwebp+Pillow ready; marginal CWV + layout risk); `final_pre_cutover_check.sh` QR assertion fix (48 `/qr/qr*/`+parent → 200, legacy `/qr/פרק-א/` → 410); hub `materials-needed.json` refresh.
**🔴 Eyal-gated (the open list):** Clarity id; mokesh full-film link; 38 media items; 48 testimonials curation; **15 content proposals** (esp. sleep-apnea pillar); product prices; courses URL; GBP/Wikidata (account access). All have live hub intake pages (media-intake, content-proposals).
**Track B cutover (gated):** `LOD200-PRODUCTION-CUTOVER` — DNS from legacy (mezoohost) to new; lift staging noindex; sitemap resubmit; GSC baseline; redirect/404 audit.

## §E — Toolchain
- **Deploy theme→staging:** `python3 scripts/ftp_deploy_site_wp_content.py` (theme + the mu-plugin ALLOWLIST — add new mu-plugins there or they won't ship). Bump `style.css Version:` to cache-bust assets.
- **Hub publish:** `python3 scripts/build_eyal_client_hub.py` → `python3 scripts/ftp_publish_eyal_client_hub.py --no-prune`.
- **301 SSoT:** `redirects-301-…json` → `gen_htaccess_301_from_decisions.py` → the PHP mu-plugin (`.htaccess` INERT on nginx). Never hand-edit the mu-plugin; regenerate. EMPTY_TARGET_MAP/EXTRA_301 carry the target overrides.
- **QA:** content-diff (≥95/≥90/0), axe, qa_probe (overflow), + curl checks for schema/GA4/redirects. Yoast → Rich Results Test (external).

## §F — Standing rules (HARD)
1. Builder ≠ validator (Iron #1); team_190 owns final validation (#5); comms via `_COMMUNICATION/` artifacts (#6).
2. **Commit/push/merge only on Nimrod's explicit ask.** Main-branch merge + origin push each need an explicit "מאשר/פוש".
3. **No "ready" to Eyal until dual-PASS;** Eyal messages are team_00's to send.
4. **Don't extract secrets from env/.env** (classifier-denied) — route the DB/actor-key need through the team_110 request.
5. **Present every decision/question to Nimrod;** but when he says "run", run to the next external-validation boundary without stopping — then present a mandate+prompt.
6. Verify against the LIVE runtime, not just theme source (the Yoast lesson). Adversarially verify findings.
7. File-links to Nimrod = clickable `file:///…%20…` markdown only.

## §G — Activation prompt
> You are **team_100 (Chief Architect)**, Claude Code, on EyalAmit.co.il-2026 (`/Users/nimrod/Documents/Eyal Amit/EyalAmit.co.il-2026`). Read this handoff + §A (Yoast reality). State: `main @ 817e05b` (Wave-1 live), `wave1b-seo-geo @ 5b0493c` (deployed, pending Round-2 dual-PASS). FIRST: drive the wave1b Round-2 validation to dual-PASS (`MANDATE-VALIDATE-WAVE1B-2026-06-20.md`) and merge on Nimrod's go. THEN: keep `COMPLETION-ROUND-ROADMAP-2026-06-20.md` current, refine the remaining task specs, and advance every non-blocked item to the next validation boundary. The #1 remaining lever is the sleep-apnea pillar — build it when Eyal approves the content proposals. Present every decision; when told "run", run to the validation boundary then issue a mandate+prompt.
