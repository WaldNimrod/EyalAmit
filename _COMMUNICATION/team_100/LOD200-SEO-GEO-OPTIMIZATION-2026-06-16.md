# LOD200 — Geo/SEO Optimization Round

**WP (proposed):** `S004-P001-WP001` (milestone S004 *Launch Readiness* — see Open Decisions) · **Author:** team_100
**Date:** 2026-06-16 · **lod_status:** LOD200 · **Track:** A (Standard) · **Profile:** L0 · **Priority:** HIGH
**Supersedes/absorbs:** the `PLANNED` SEO WP `S002-P001-WP004` (meta titles/descriptions/OG).

## 1. Problem statement (LOD100 confirmed)
The rebuilt site ships with only baseline metadata. It is not yet optimized for (a) classic **SEO** (search engines) or
(b) **GEO** — Generative Engine Optimization, i.e. being correctly read, cited, and surfaced by AI answer engines
(Google AI Overviews, ChatGPT, Perplexity, etc.). Staging SEO/perf numbers are artifacts (noindex edge headers,
http→https redirect, uPress TTFB) and must be earned on the production domain. Without this pass, a content-accurate
site still under-performs on discovery — the primary growth channel for a single-practitioner business.

## 2. Solution concept
A single, comprehensive optimization pass across all live routes covering both SEO and GEO, theme-native (no plugins
beyond what exists), driven from `functions.php` / `wp_head` and the existing block render layer.

## 3. Major components & purpose
- **Per-page meta layer** — unique `<title>`, meta description, canonical, Open Graph + Twitter cards per route (home, services, /eyal-amit, books, shop products, faq, blog posts, mokesh, en).
- **JSON-LD structured data** — `Organization`/`LocalBusiness` (the studio, פרדס חנה, hours, geo), `Person` (Eyal), `Product` (shop), `FAQPage` (/faq), `Article` (blog), `BreadcrumbList`. Validated against Google Rich Results.
- **GEO content layer** — entity clarity, citeable factual statements, explicit Q&A phrasing, author/expertise signals (E-E-A-T) so answer engines can extract and attribute.
- **Crawl/index infra** — XML sitemap, `robots.txt`, canonical audit (single-hop, self-canonical — already true for /eyal-amit), `hreflang` he↔en.
- **Internal-link graph** — every page reachable, topical clusters (treatment↔method↔lessons↔faq), descriptive anchors.
- **Image + performance** — alt text/SEO, intrinsic dimensions, lazy/eager + `fetchpriority` (LCP), Core Web Vitals re-measure (on production).

## 4. Primary flow (happy path)
Audit current state per route → author meta + JSON-LD per template → add GEO content blocks/markup → generate sitemap + robots → fix internal links → validate (Rich Results, Lighthouse SEO, schema validator) on production → measure CWV on prod → iterate.

## 5. Actors / systems
team_100 (architect) · builder (team_10/team_35) · team_50 + team_190 (validate) · **Eyal** (factual confirmations, NAP, hours, analytics IDs — partly blocking, see Open Decisions) · Google/Bing/AI answer engines (consumers).

## 6. Open decisions (explicit)
- **D-OPT-1 — Milestone:** new **S004 (Launch Readiness)** vs continue S003. *(team_00)*
- **D-OPT-2 — GEO target scope:** which answer engines/markup depth to prioritize (Google AI Overviews + schema baseline, vs broader). *(team_00)*
- **D-OPT-3 — Analytics:** is GA4/Clarity wiring in-scope here or in the Eyal-dependent WP? (IDs are `__PENDING_EYAL__`). *(cross-ref `LOD200-EYAL-DEPENDENT-COMPLETIONS`)*
- **D-OPT-4 — Sequencing vs cutover:** measure SEO/perf pre- or post-production-cutover (real numbers need prod).

## 7. Dependencies & constraints
Depends on **production cutover** (`S004-P001-WP003`) for true measurement; on Eyal for NAP/hours/analytics; content frozen (WP-W2-16 done). Constraint: theme-native, ea-tokens/locked-atoms untouched; no new heavy plugins.

## 8. Initial success criteria (directional)
Every route has unique, intentional title+description+canonical+OG; valid JSON-LD per type (0 Rich-Results errors); sitemap + robots live; he/en hreflang correct; CWV "good" on production mobile; key pages carry GEO-extractable Q&A + entity markup.

## 9. Out of scope
Paid SEM/ads; off-site backlink building; the production deploy itself (separate WP); content rewriting (content is locked/verbatim).

## 10. Risk classification
**Medium** — SEO is iterative and partly external (engine behaviour); GEO is an emerging, less-deterministic surface; production-only measurement adds a sequencing dependency.

## 11. Track declaration
**Track A (Standard).** GEO carries a small research element (answer-engine behaviour) but the deliverables are concrete markup/meta/infra; no LOD300 system-behaviour spec required. LOD400 will enumerate per-route meta + schema + AC.
