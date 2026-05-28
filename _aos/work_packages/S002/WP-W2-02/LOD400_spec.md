# LOD400 Spec — WP-W2-02
# Wave2 Core Content — 6 Public Pages (Home · Method · Treatment · About · FAQ · Contact)

**WP ID:** WP-W2-02 | **Track:** A | **Milestone:** S002 | **Profile:** L0
**Builder:** team_10 (claude-sonnet-4-6) | **L-GATE_BUILD:** team_50 (cursor-composer) | **L-GATE_VALIDATE:** team_190 (Codex/OpenAI)
**Branch:** feature/w2-06-blog | **Staging:** http://eyalamit-co-il-2026.s887.upress.link
**Authored:** 2026-05-28 (team_100, retro-LOD400 from delivery per team_00 disposition) | **lod_status:** LOD400

---

## Objective
Deliver the six core public pages of the Wave2 site with final Hebrew content (sourced from Eyal's 25.5.26 package), routed through Wave2 templates, with correct asset hygiene, legacy redirects, and mobile correctness. No new design system work (consumes Stage-B D-14 tokens + Wave2 shell).

## Architecture / cross-cutting requirements
| ID | Requirement | Implementation anchor |
|----|-------------|------------------------|
| X-01 | Wave2 templates routed at `template_include` **priority 100** (after legacy 92–98). | `inc/wave2-w2-02.php` `ea_w2_02_template_include()` |
| X-02 | Every Wave2 page carries body class `ea-wave2-shell`. | Wave2 shell / router |
| X-03 | Force-routed pages MUST register as a Wave2 active view (`set_query_var('ea_wave2_shell', true)`), so Stage-B asset dequeue (`ea_wave2_is_active_view()`) applies. | `inc/wave2-w2-02.php` `template_redirect` hook |
| X-04 | Non-Wave2 core CSS dequeued on Wave2 views: `wp-block-library`, `wp-block-library-theme`, `classic-theme-styles`, `global-styles`. | `inc/wave2-stage-b.php` `ea_wave2_dequeue_unused_styles()` @999 |
| X-05 | Contact Form 7 CSS/JS load **only** on `/contact/`. Detect via `is_page('contact')`; enforce with `wpcf7_load_css`/`wpcf7_load_js` filters (dequeue alone loses to global enqueue). | `inc/wave2-stage-b.php` |
| X-06 | `style.css` `Version: 1.4.1` (W2-02 slot; W2-06 owns 1.4.0). | theme `style.css` |
| X-07 | Permalink structure `/%postname%/` (M2 standard). Pages at `/<slug>/`. | WP setting (pre-existing) |
| X-08 | `validate_aos.sh` → 0 FAIL on branch. | CI gate |
| X-09 | Mobile (`max-width:639px`): paragraph `text-align: start` on Wave2 content/service paragraphs. | `assets/css/ea-atoms.css` |

## Per-page specification

### P1 — Home `/`
- **Template:** `page-templates/tpl-home.php` (front page; `page_on_front=16`).
- **H1:** `המרכז לטיפול בנשימה באמצעות דיג'רידו`
- **Content:** hero + homepage sections 01–03 per `from-eyal/.../תוכן לאתר 25.5.26` homepage source (`block-intro` includes the §02 paragraph). Video embed (Section 03) = Eyal-dependent placeholder (non-blocking).
- **AC:** 200; H1 matches source; `ea-wave2-shell` present; no placeholder copy.

### P2 — Method `/method/`
- **Template:** `page-templates/tpl-service.php` (routed by slug `method`).
- **H1:** `שיטת cbDIDG של אייל עמית`
- **Content source:** `from-eyal/.../תוכן לאתר 25.5.26/השיטה/method.md`.
- **AC:** 200; H1 matches; full body copy, no placeholders; mobile OK.

### P3 — Treatment `/treatment/`
- **Template:** `page-templates/tpl-service.php` (slug `treatment`).
- **H1:** `טיפול בדיג'רידו`
- **Content source:** `.../תוכן לאתר 25.5.26/treatment.md`.
- **AC:** 200; H1 matches; full body copy; mobile OK.

### P4 — About `/about/` (+ child `/about/moksha/`)
- **Template:** `page-templates/tpl-content.php` (slug `about`); `tpl-content.php` adds a sub-link to `/about/moksha/` when slug=`about`.
- **H1:** `אודות אייל עמית` ; child H1: Moksha Dahiman story.
- **Pages:** `/about/` (ID 180) and `/about/moksha/` (ID 181). Both created via WP REST API (seeder stalled on `wp_insert_post` — documented, acceptable).
- **AC:** `/about/` 200; `/about/moksha/` 200; biographical content present.

### P5 — FAQ `/faq/`
- **Template:** `page-templates/tpl-faq.php` using `template-parts/blocks/block-faq-list.php`.
- **H1:** `שאלות נפוצות (FAQ)`
- **Content source:** `.../תוכן לאתר 25.5.26/דף FAQ/FAQ FINAL.md`. **50 questions across 5 categories** (delivery count; supersedes earlier "42" estimate).
- **Behavior:** client-side category filter (`assets/js/ea-faq-filter.js`, vanilla JS) — selecting a category shows only its questions.
- **AC:** 200; H1 matches; 50 Qs / 5 categories rendered; filter hides/shows correctly.

### P6 — Contact `/contact/`
- **Template:** `page-templates/tpl-contact.php`.
- **H1:** `צור קשר`
- **Form:** CF7 via `ea_wave2_cf7_form_id` filter. **Form ID is Eyal-dependent** (set `add_filter('ea_wave2_cf7_form_id', fn() => <ID>)` once created) — non-blocking open item (IDEA-003/004).
- **AC:** 200; H1 matches; CF7 assets present here and ONLY here (per X-05).

## Legacy redirects (301)
| Legacy | New |
|--------|-----|
| `/אייל-עמית-אודות/` | `/about/` |
| `/eyal-amit/` | `/about/` |
| `/eyal-amit/mokesh-dahiman/` | `/about/moksha/` |
Implemented in `ea_w2_02_legacy_redirects()`.

## Acceptance Criteria (gate — matches team_50 L-GATE_BUILD)
AC-01 six URLs 200 · AC-02 H1s match 25.5.26 · AC-03 templates active (`ea-wave2-shell`) · AC-04 FAQ filter works · AC-05 CF7 CSS/JS only on `/contact/` · AC-06 `/about/moksha/` 200 · AC-07 legacy slug 301s · AC-08 `validate_aos.sh` 0 FAIL · AC-09 mobile `<p>` text-align · AC-10 `style.css` 1.4.1.

## Out of scope (Eyal-dependent / Phase 2)
CF7 form ID, GA4 + Clarity IDs, homepage video embed, SMTP delivery confirmation (IDEA-003/004). Visual design changes. Navigation changes.

## Files (delivery reference)
Created: `inc/wave2-w2-02.php`, `template-parts/blocks/block-faq-list.php`, `assets/js/ea-faq-filter.js`, `mu-plugins/ea-w2-02-core-pages-seed-once.php`.
Modified: `functions.php` (require), `style.css` (1.4.1), `page-templates/tpl-faq.php`, `tpl-contact.php`, `tpl-content.php`, `block-intro.php`, `assets/css/ea-atoms.css`, `inc/wave2-stage-b.php` (AC-05 fix, commit ebb6101).

## Gate sequence
L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50, PASS_WITH_FINDINGS) → L-GATE_VALIDATE (team_190).
