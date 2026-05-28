# LOD400 Spec — WP-W2-07
# Press + Moksha Page + 49 QR Pages + FB Testimonials (live)

**WP ID:** WP-W2-07 | **Track:** A | **Milestone:** S002 | **Profile:** L0
**Owner/Builder:** team_10 | **L-GATE_BUILD:** team_50 (non-Claude) | **L-GATE_VALIDATE:** team_190 (Codex)
**Depends on:** WP-W2-02 (COMPLETE — about layout) | **Authored:** 2026-05-28 (team_100) | **lod_status:** LOD400

## Objective
Deliver the "heritage" content wrapping the core: press mentions, the Moksha Dahiman page, 49 QR pages (1:1 migration), and FB Top-5 testimonials. Measurable: 49 QR URLs + /press + /about/moksha live; testimonials render with text+image+link.

## Pages & sources
| Item | URL | Source |
|------|-----|--------|
| Press | `/press` (or section under `/about`) | extract press articles from legacy (`/qr-press` or equiv) — list: date+title+link |
| Moksha | `/about/moksha` | `מוקש דהימן/ומה היום.docx` + legacy images. **NOTE:** page already exists (created in W2-02 as ID 181) — W2-07 fills final content. |
| 49 QR pages | `/qr/qr1/`..`/qr/qr49/` | 1:1 migration (content+images+structure). QR slug nesting `qr/qrN` per QR-URL-INVENTORY.csv (do NOT change existing QR slugs — QR-URL-POLICY). |
| FB testimonials | embedded in Hero/sections | text from 25.5.26 + image-fetch from FB (profile photos) |

## Block / behavior contract
- Press: ≥5 articles, each date+title+external link (new tab).
- Moksha: content + image + link to /about.
- QR: each page renders migrated content + images; 49 URLs verified active.
- FB testimonials: Top-5 with text+image+link; **download FB images → rehost in `wp-content/uploads/`** (FB hot-link blocked) — relative links (consistent with W2-06 media-localization policy). Publication consent for 30+ collected by nimrod (round 1 = 5 already-public).

## Cross-cutting
Reuse W2-02 about/content layout + D-14. QR pages: no SEO index page needed (F2). Route via `template_include` / page templates as appropriate; set `ea_wave2_shell`.

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
