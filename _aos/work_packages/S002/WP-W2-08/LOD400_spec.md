# LOD400 Spec — WP-W2-08
# English Landing Page (/en)

**WP ID:** WP-W2-08 | **Track:** A | **Milestone:** S002 | **Profile:** L0
**Owner/Builder:** team_10 (impl) + team_30 (EN content) | **L-GATE_BUILD:** team_50 (non-Claude) | **L-GATE_VALIDATE:** team_190 (Codex)
**Depends on:** WP-W2-02 (COMPLETE — final HE content to summarize) | **Authored:** 2026-05-28 (team_100) | **lod_status:** LOD400

## Objective
One English landing page summarizing the whole site, designed, with media and correct hreflang. Measurable: `/en` 200, 6 sections in English, hreflang EN↔HE reciprocal.

## Page
| URL (canonical) | Template | Content source |
|-----------------|----------|----------------|
| `/en` (single canonical URL — `/en/landing` NOT used; if any legacy `/en/landing` exists, 301 → `/en`) | `tpl-en-landing.php` (already in `ea_wave2_is_active_view` list) | **Input dependency** (B01): final EN copy at `_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md`, authored+approved by team_30 BEFORE build. The builder MUST NOT author/translate marketing copy during implementation. |

## Section contract (6) — each maps to an approved EN block in the team_30 artifact, summarizing these HE sources (F04)
1. Hero (image + EN tagline) ← `/` homepage hero · 2. About Eyal ← `/about` · 3. Method (cbDIDG) ← `/method` · 4. Services overview ← `/treatment` + `/sound-healing` + `/lessons` · 5. Books ← `/books` · 6. Testimonials (5-10, EN) + CTA ← `ea-legacy-curated-2026-04-11/catalog.json`.

## Cross-cutting / SEO
- `lang="en"`. **hreflang contract (B03):** on `/en` emit `<link rel="alternate" hreflang="en" href="…/en/">` and `<link rel="alternate" hreflang="he" href="…/">` (HE counterpart = homepage `/`, `page_on_front=16`); add the reciprocal `hreflang="en"` alternate on the HE homepage. `x-default` → `/`.
- CTA → `/contact?lang=en` (subject auto-set).
- Relevant media (portrait, studio) from new-site uploads (relative). D-14 tokens; `ea-wave2-shell`.

## Input dependency (HARD — blocks L-GATE_ELIGIBILITY)
`_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md` (6 approved EN sections). Build does not start until present.

## Acceptance Criteria
- AC-01: `/en` → 200.
- AC-02: 6 sections present, each matching the approved `_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md` content verbatim (no builder-authored copy).
- AC-03: hreflang per B03 — `/en` emits en + he(→`/`) + x-default alternates; HE homepage emits reciprocal `hreflang="en"` → `/en`.
- AC-04: CTA → `/contact?lang=en`.
- AC-05: `validate_aos.sh` 0 FAIL; mobile responsive.

## Out of scope
Full HE-site translation; separate EN service pages; EN blog.

## Gate sequence
L-GATE_ELIGIBILITY → L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190).
