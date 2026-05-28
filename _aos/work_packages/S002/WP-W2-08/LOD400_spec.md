# LOD400 Spec — WP-W2-08
# English Landing Page (/en)

**WP ID:** WP-W2-08 | **Track:** A | **Milestone:** S002 | **Profile:** L0
**Owner/Builder:** team_10 (impl) + team_30 (EN content) | **L-GATE_BUILD:** team_50 (non-Claude) | **L-GATE_VALIDATE:** team_190 (Codex)
**Depends on:** WP-W2-02 (COMPLETE — final HE content to summarize) | **Authored:** 2026-05-28 (team_100) | **lod_status:** LOD400

## Objective
One English landing page summarizing the whole site, designed, with media and correct hreflang. Measurable: `/en` 200, 6 sections in English, hreflang EN↔HE reciprocal.

## Page
| URL | Template | Content |
|-----|----------|---------|
| `/en` (or `/en/landing`) | `tpl-en-landing.php` (already in `ea_wave2_is_active_view` list) | English summary authored from 25.5.26 essence (NOT literal translation) |

## Section contract (6)
1. Hero (image + EN tagline) · 2. About Eyal · 3. Method (cbDIDG) · 4. Services overview · 5. Books · 6. Testimonials (5-10 translated) + CTA.

## Cross-cutting / SEO
- `lang="en"`, `hreflang="en"` + reciprocal `hreflang="he"` from the Hebrew homepage.
- CTA → `/contact?lang=en` (subject auto-set).
- Relevant media (portrait, studio). D-14 tokens; `ea-wave2-shell`.
- 301 from any legacy EN page if applicable.

## Acceptance Criteria
- AC-01: `/en` → 200.
- AC-02: 6 sections present with English content.
- AC-03: hreflang EN↔HE linked correctly (reciprocal).
- AC-04: CTA → `/contact?lang=en`.
- AC-05: `validate_aos.sh` 0 FAIL; mobile responsive.

## Out of scope
Full HE-site translation; separate EN service pages; EN blog.

## Gate sequence
L-GATE_ELIGIBILITY → L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190).
