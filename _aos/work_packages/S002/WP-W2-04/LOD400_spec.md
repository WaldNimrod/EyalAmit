# LOD400 Spec — WP-W2-04
# Sound Healing + Lessons (2 service pages)

**WP ID:** WP-W2-04 | **Track:** A | **Milestone:** S002 | **Profile:** L0
**Owner/Builder:** team_10 | **L-GATE_BUILD:** team_50 (non-Claude) | **L-GATE_VALIDATE:** team_190 (Codex)
**Depends on:** WP-W2-02 (COMPLETE — `tpl-service.php`) | **Soft-dep:** WP-W2-07 (final testimonial template, non-blocking) | **Authored:** 2026-05-28 (team_100) | **lod_status:** LOD400

## Objective
Two service pages live on staging with 25.5.26 content, category-filtered FAQ embed, and testimonials block. Measurable: 2 URLs 200, H1+body match source 1:1, FAQ filter shows only the page's category.

## Pages & sources
| Page | URL | Template | Source (.md) | Blocks |
|------|-----|----------|--------------|--------|
| Sound Healing | `/sound-healing` | `tpl-service.php` | `סאונדהילינג/sound_healing_final.md` | 10 |
| Lessons | `/lessons` | `tpl-service.php` | `שיעורי נגינה/lesons.md` | 10 |

## Block contract (each page)
hero · what-it-is · how-it-works/benefits · who-it's-for · **FAQ (view-only, filtered to this page's category)** · **testimonials** (Top-5 + accordion; text+image+link, image=placeholder until W2-07) · CTA (form + WhatsApp per A/B variant).

## Cross-cutting (reuse W2-02 infra)
Route via slug in a `template_include` router (extend the W2-02 pattern or add `inc/wave2-w2-04.php`), set `ea_wave2_shell`; D-14 tokens; `ea-wave2-shell` body class; coordinate `style.css` version slot.

## A/B CTA contract (F01 — canonical, from WP-W2-01 ea-ab-testing)
Each page's CTA uses the W2-01 A/B mechanism (`assets/js/ea-ab-testing.js`, per-session random variant + GA4 event): **variant_A** = contact form only; **variant_B** = form + WhatsApp; **variant_C** = WhatsApp only. Targets: form → `/contact?subject=<page-slug>`; WhatsApp → `https://wa.me/972524822842` (default text per WP-W2-01). GA4 event: `cta_click` with `variant_label` (A/B/C) + `page`. Build-time expected: all three variants wired; random assignment live.

## Testimonial dependency (F02)
Testimonial **text** is in scope now; **images** depend on WP-W2-07. Placeholder images are acceptable for **L-GATE_BUILD**. For **L-GATE_VALIDATE**: placeholders acceptable ONLY if W2-07 is still open at that time (declared carry-forward); if W2-07 is closed, final images are required.

## Acceptance Criteria
- AC-01: `/sound-healing`, `/lessons` → 200.
- AC-02: H1 + body match 25.5.26 source 1:1.
- AC-03: FAQ filter on each page shows ONLY that category's questions.
- AC-04: testimonials render text+image+link (placeholder image OK until W2-07).
- AC-05: every CTA active (form + WhatsApp per A/B variant).
- AC-06: `validate_aos.sh` 0 FAIL; mobile responsive.

## Out of scope
Treatment/Method pages (W2-02). Final FB testimonial images (W2-07).

## Gate sequence
L-GATE_ELIGIBILITY → L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190).
