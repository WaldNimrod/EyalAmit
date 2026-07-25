# AEO checklist — deep audit baseline (2026-07-25)

Sources merged: SEO/AEO skill (AEO + structured data + EEAT + technical SEO);
`docs/project/AEO-GEO-READINESS-AUDIT-2026-03-31.md` §6 P0;
`docs/project/team-100-preplanning/04-IA-SEO-SOCIAL-REQUIREMENTS.md`;
team_80 synthesis + WP-W2-17 + S4-07.

| ID | Dimension | Pass criteria (staging unless noted) |
|----|-----------|--------------------------------------|
| C1 | Crawl / AI UAs | Staging: block-all or noindex OK. Prod (cutover): 10 UAs Allowed + Sitemap |
| C2 | Answer-first | Core service routes lead with direct answer paragraph (AF-01..04) |
| C3 | FAQ visible | FAQ accordion/block present where schema FAQPage claimed |
| C4 | FAQPage schema | `@type:FAQPage` in Yoast `@graph` iff visible FAQ items exist |
| C5 | Entity graph | Person + ProfessionalService global; Service on treatment/sound-healing/lessons only |
| C6 | GeoCircle | ProfessionalService.areaServed = GeoCircle (not `Israel`) |
| C7 | Meta uniqueness | Exactly 1 non-empty meta description ≠ tagline per route |
| C8 | Canonical + OG | Self-ref canonical; exactly 1 og:image HTTP 200 |
| C9 | Prohibitions | No AggregateRating; no HealthAndBeautyBusiness; no VideoObject-on-hero |
| C10 | EEAT Person | Person name/url/image/jobTitle/sameAs present; About page linkable |
| C11 | Pillar AEO | `/snoring-sleep-apnea/` answerable + FAQPage if FAQ present; Article only if article-shaped |
| C12 | NAP consistency | Footer NAP matches schema address/phone; FAQ geo answers align |
| C13 | Measurement | Cutover: UTM chatgpt + GSC (documented WP012) — not required live on staging |

Evidence dir: `_COMMUNICATION/team_100/evidence/aeo-deep-audit-2026-07-25/`
