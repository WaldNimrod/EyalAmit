# LOD400 Spec — WP-W2-07
# Press + Moksha Page + 49 QR Pages + FB Testimonials (live)

**WP ID:** WP-W2-07 | **Track:** A | **Milestone:** S002 | **Profile:** L0
**Owner/Builder:** team_10 | **L-GATE_BUILD:** team_50 (non-Claude) | **L-GATE_VALIDATE:** team_190 (Codex)
**Depends on:** WP-W2-02 (COMPLETE — about layout) | **Authored:** 2026-05-28 (team_100) | **lod_status:** LOD400

## Objective
Deliver the "heritage" content wrapping the core: press mentions, the Moksha Dahiman page, 49 QR pages (1:1 migration), and FB Top-5 testimonials. Measurable: 49 QR URLs + /press + /about/moksha live; testimonials render with text+image+link.

## Pages, URLs, sources & routing (corrected per team_190 L-GATE_SPEC)
| Item | Canonical URL | Source artifact (exact) | Route / template plan |
|------|---------------|-------------------------|------------------------|
| Press | `/press` (canonical; NOT a section of /about) | **Input dependency** `_COMMUNICATION/team_40/W2-07-PRESS-EXPORT-2026-05-28.json` (team_40 produces from legacy crawl: array of {date,title,url,source}). | Seeded WP page slug `press` + `tpl-content.php`-style template; routed via the W2-02 `template_include` pattern (slug `press`), `set_query_var('ea_wave2_shell',true)`. |
| Moksha | `/about/moksha` | `…/25.5.26/מוקש דהימן/ומה היום.docx` (extract text) + legacy images via team_40. **Page exists** (W2-02 ID 181) — W2-07 fills final content. | Existing page; content update via REST; already routed by W2-02 (`tpl-content.php`). |
| 49 QR pages | `/qr/qr1/`..`/qr/qr49/` | **Input dependency** `_COMMUNICATION/team_40/W2-07-QR-CONTENT-EXPORT-2026-05-28.json` (team_40 produces: per-slug {qr_n, slug, title, body_html, image_urls[]}). URL inventory = `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv` (slugs/nesting — do NOT change, per QR-URL-POLICY). | **Seeded WP pages** under parent `qr` (one-time seeder mu-plugin `ea-w2-07-qr-seed-once.php`), each on a shared `tpl-qr.php` (add to `ea_wave2_is_active_view` list); legacy images downloaded → rehosted in `wp-content/uploads/ea-legacy/qr/` (relative). |
| FB testimonials | embedded in Hero/sections (home + service pages) | **`_COMMUNICATION/team_40/ea-legacy-curated-2026-04-11/catalog.json`** (`meta`+`entries`; images under `…/media/`). | Rendered via existing Wave2 testimonial block; images rehosted in `wp-content/uploads/` (relative). |

## Block / behavior contract
- Press: ≥5 articles from the press export, each date+title+external link (new tab).
- Moksha: content + image + link to `/about`.
- QR: each of 49 pages renders migrated body_html + images; all 49 URLs verified active (automated against the inventory CSV).
- FB testimonials: Top-5 from `catalog.json` entries with text+image+link; images rehosted under `wp-content/uploads/` (relative — consistent with W2-06 media policy).

## Input dependencies (HARD — block L-GATE_ELIGIBILITY until present)
1. `_COMMUNICATION/team_40/W2-07-PRESS-EXPORT-2026-05-28.json` (team_40).
2. `_COMMUNICATION/team_40/W2-07-QR-CONTENT-EXPORT-2026-05-28.json` (team_40).
3. Testimonial catalog already present (`ea-legacy-curated-2026-04-11/catalog.json`) ✓.
4. **External (F05):** FB profile-photo acquisition is best-effort; if Facebook fetch is blocked, fall back to the curated images in `…/ea-legacy-curated-2026-04-11/media/`; if none, grey avatar placeholder. Publication consent for 30+ collected by nimrod (round 1 = 5 already-public).

## Cross-cutting
Reuse W2-02 about/content layout + D-14; `set_query_var('ea_wave2_shell',true)`. QR pages need no SEO index page (F2).

## Acceptance Criteria
- AC-01: 49 QR URLs active under `/qr/qrN/` (automated check).
- AC-02: Moksha page shows content + image + link to about.
- AC-03: `/press` shows ≥5 legacy press articles.
- AC-04: FB Top-5 testimonials render text+image(rehosted)+link.
- AC-05: external links open in new tab; `validate_aos.sh` 0 FAIL.

## Out of scope
Rewriting QR/Moksha/press content (migration only). SEO on QR pages (F2).

## Gate sequence
L-GATE_ELIGIBILITY → L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190).
