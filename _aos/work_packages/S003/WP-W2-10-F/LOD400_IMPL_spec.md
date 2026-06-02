# LOD400 — WP-W2-10-F · EN landing FULL IMPLEMENTATION (post-elevation)

**WP:** WP-W2-10-F | **Milestone:** S003 | **Parent:** WP-W2-10 (Track-2) | **Priority:** HIGH | **Profile:** L0
**Builder:** team_10 (S3) · **Tokens:** team_80 (S4) · **QA:** team_50 → **Validate:** team_190 (Cursor)
**Authored:** 2026-06-02 (team_100) | **lod_status:** LOD400 (implementation-grade)
**Source of truth:** `_COMMUNICATION/team_35/WP-W2-10-F/elevation/` (`mockup/en-landing.html` + elevation-notes + handoff; READY_FOR_S2, 0 new tokens/atoms, 0 GCR).
**Shared conventions:** inherit render-pattern / D-14 discipline / https-perf ACs / gate prompts from `WP-W2-10-A/LOD400_IMPL_spec.md`.

## 0. Objective
Implement the elevated **EN landing** (`/en`) on `tpl-en-landing.php` (currently a stub). LTR mirror of the RTL system.
Composition-only on D-14 (`ea-tokens`, `ea-atoms`, `w2-08-en-landing.css`). **Copy VERBATIM EN** from `inc/wave2-w2-08.php` (team_30).

## 1. Gate
READY_FOR_S2 → S2 Eyal sign-off (team_00 proxy) gates S3.

## 2. Architecture
`tpl-en-landing.php` body renders the EN block sequence (render fn or inline `get_template_part` chain) inside
`<main id="main" class="ea-wave2-en" dir="ltr" lang="en">`. Single H1. Reduced-motion respected.

## 3. Block order (8)
1. topnav (LTR, language pill → Hebrew `/`) · 2. **hero** (`ea-en-hero` kicker + layered gradient + 2 breath-lines + `cta-pill --ghost-white`) ·
3. About (`ea-en-section`, section label) · 4. Method (`ea-en-section--alt` + `ea-en-list` principles) ·
5. Services (3 paths: therapy / sound / lessons, `ea-en-section`) · 6. **Books** (real cover row `ea-en-books-row` + prose) ·
7. Testimonials ×4 (`ea-en-testimonial` grid; trimmed 8→4 for pacing) + closing CTA · 8. footer-social (LTR).

## 4. LTR mirror checklist (AC-F3 — verify at S3)
- [ ] `dir="ltr" lang="en"` on `<html>` + `<main>`
- [ ] **logical properties only** — `inset-inline-start` (skiplink/whatsapp), `padding-inline-start` (list bullets → left), `justify-content:flex-start` (footer nav/social)
- [ ] language pill links to Hebrew `/`
- [ ] EN copy verbatim from `wave2-w2-08.php`; if team_30 revises, re-sync
- [ ] type tokens use D-14 `--ea-type-*` shorthands verbatim

## 5. Real-asset wiring
3 book covers (`vekatavt`/`kushi-blantis`/`tsva-bechol`) → theme media for the `ea-en-books-row`. No other real assets required.

## 6. Acceptance (F-specific; else per A §7)
- AC-F2 `/en` renders the full elevated LTR composition (no stub fallback); matches `en-landing.html`.
- AC-F3 LTR mirror correct (checklist §4); no physical left/right that breaks the mirror; single H1.
- AC-F-copy EN copy verbatim from W2-08 source.
- (zero drift; axe 0/0; LH https a11y 100 / mobile perf ≥85 on /en; reduced-motion respected; validate 0 FAIL; /en 200.)

## 7. Build sequence / gates
Per A §8/§9 (single route). S4 team_80 (cover row / kicker / gradient hero are recompositions; confirm logical-prop mirroring, zero drift) → S5 team_50 (`/en/`) → team_190 (Cursor, verify LTR mirror + EN verbatim). HALT for S2 first.

## 8. Risk
Testimonials trimmed 8→4 — full set remains in W2-08 source if Eyal prefers all (team_00 call at S2). EN copy drift if team_30 revises W2-08 → re-sync before deploy.
