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
