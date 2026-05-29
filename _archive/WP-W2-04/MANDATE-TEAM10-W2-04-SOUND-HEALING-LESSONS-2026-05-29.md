---
id: MANDATE-TEAM10-W2-04-SOUND-HEALING-LESSONS-2026-05-29
from_team: team_100 (Chief System Architect)
to_team: team_10 (Builder)
wp: WP-W2-04 — Sound Healing + Lessons (2 service pages)
date: 2026-05-29
status: READY TO DISPATCH (awaiting team_00 go)
spec_ref: _aos/work_packages/S002/WP-W2-04/LOD400_spec.md
depends_on: WP-W2-02 (COMPLETE — tpl-service.php) | soft-dep WP-W2-07 (testimonial images, non-blocking)
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-04  (branch feature/w2-04-services)
---

# Dispatch Mandate — WP-W2-04 (Sound Healing + Lessons)

## 1. Scope
Build 2 service pages on `tpl-service.php`, 10 blocks each:
- `/sound-healing` — source `docs/.../תוכן לאתר 25.5.26/סאונדהילינג/sound_healing_final.md`
- `/lessons` — source `docs/.../תוכן לאתר 25.5.26/שיעורי נגינה/lesons.md`
Blocks (each): hero · what-it-is · how-it-works/benefits · who-it's-for · FAQ (view-only,
filtered to page category) · testimonials (Top-5 + accordion; text+image+link, image=placeholder
until W2-07) · CTA (A/B variant). Work entirely in the worktree above.

## 2. Architecture (derived by team_100 — follow exactly)

### 2a. Router — `inc/wave2-w2-04.php` (mirror `inc/wave2-w2-03.php`)
- `template_include` filter @ priority **100**, maps top-level slugs `sound-healing` + `lessons`
  → `tpl-service`. Use `post_name` match (top-level, like W2-02 — NOT child-of-parent like W2-03).
- On `template_redirect`: `set_query_var('ea_wave2_shell', true)` for these views (Stage-B asset
  hygiene). Body class: add `ea-wave2-shell` + `ea-service-<slug>`. no-sidebar; hide GP title.
- `require_once __DIR__ . '/wave2-w2-04.php';` appended in `functions.php` (surgical edit).

### 2b. Content injection — `the_content` filter + `inc/wave2-w2-04-content.php` (CRITICAL)
`tpl-service.php` is a thin shell that renders `the_content()` only — there is **no** W2-02
content provider and FTP deploy **cannot** write `post_content` (that is DB-side). Therefore:
- Create `inc/wave2-w2-04-content.php` (mirror `wave2-w2-03-content.php`): a provider returning
  the full 10-block HTML for each page slug, built from the 25.5.26 source `.md` files.
- Inject via an `add_filter('the_content', …)` keyed on the two slugs (guard `is_main_query()`
  + `in_the_loop()`), so the block markup replaces/wraps the empty page content. `require_once`
  the content file from the router.
- D-14 tokens ONLY (`--ea-*`, incl. the new `--ea-on-dark`); **no raw hex**. Reuse existing
  block markup/classes where they exist (see 2d/2e/2f).

### 2c. AC-05 content rule (team_00 aos_decide B, 2026-05-29)
"1:1 with source" = **normalize clear/obvious typos** while **preserving Eyal's voice &
deliberate spoken-style slang**. Genuine ambiguity (typo vs intentional voice) → **flag to
team_100 in the completion report, do NOT guess**. (Same rule applied to W2-03.)

### 2d. FAQ block (AC-03) — view-only, category-filtered
FAQ data lives in `template-parts/blocks/block-faq-list.php` as a hardcoded array; each item has
a `category` field. Categories `sound-healing` and `lessons` already exist there. Render the FAQ
block **view-only** (no filter chips/JS) showing **only** the current page's category items.
Refactor `block-faq-list.php` to accept an optional `$ea_faq_only_category` arg (passed via
`get_template_part` args or `set_query_var`) — do NOT duplicate the FAQ dataset. Default behavior
on `/faq` (full filterable list) must stay unchanged.

### 2e. Testimonials block (AC-04) — Top-5 + accordion
Reuse `template-parts/blocks/block-testimonials-row.php`. Render Top-5 with accordion; each item
= text + image + link. **Images = placeholder** until W2-07 (reuse the W2-03 grey-placeholder
pattern, `ea_w2_03_render_gallery_placeholder` style, or an equivalent testimonials placeholder).
Testimonial **text**: source from the page `.md` if present, else the existing testimonials block
data; if neither has page-specific text, use a clearly-marked placeholder and flag in the report.

### 2f. CTA A/B (AC-05) — reuse canonical mechanism, do NOT reinvent
`assets/js/ea-ab-testing.js` already assigns a per-session variant under the **canonical
sessionStorage key `eyal_cta_variant`** with variants `form_only` / `dual` / `wa_only`
(↔ A / B / C). Reuse this exact key. Wire an in-page CTA block on each service page:
- variant A `form_only` = contact form only; B `dual` = form + WhatsApp; C `wa_only` = WhatsApp only.
- form → `/contact?subject=<page-slug>` (`sound-healing` / `lessons`).
- WhatsApp → `https://wa.me/972524822842`.
- GA4 event `cta_click` with `{ variant_label: <A|B|C or form_only|dual|wa_only>, page: <slug> }`.
- Extend `ea-ab-testing.js` to toggle the in-page CTA block (`[data-ea-ab]` on the CTA element)
  using the SAME key — do not introduce a second variant key. All three variants wired; random
  assignment live.

### 2g. Versioning
Bump `style.css` `Version:` **1.4.2 → 1.4.3** (W2-03 left it at 1.4.2). Single bump for this WP.

## 3. Acceptance criteria (gate against — LOD400 spec AC-01..06)
- AC-01: `/sound-healing`, `/lessons` → HTTP 200.
- AC-02: H1 + body 1:1 with 25.5.26 source (under the §2c normalization rule).
- AC-03: FAQ shows ONLY the page's category, view-only.
- AC-04: testimonials render text + image(placeholder) + link.
- AC-05: every CTA active (form + WhatsApp per A/B variant), GA4 wired.
- AC-06: `validate_aos.sh` 0 FAIL; mobile responsive.

## 4. Deploy
`python3 scripts/ftp_deploy_site_wp_content.py` then verify live with cache-bust
`?cb=$(date +%s)$RANDOM`. Confirm both URLs 200 + all 10 blocks render on each.

## 5. Cross-engine chain (IR#1 — immutable)
Builder team_10 (claude). L-GATE_BUILD team_50 **MUST be non-Claude**. L-GATE_VALIDATE team_190
native Codex. Builder engine ≠ validator engine.

## 6. Git discipline
Surgical commits **by file name** — NEVER `git add -A`. Work on `feature/w2-04-services` in the
dedicated worktree. Do not touch `_aos/`. Do not commit `local/.env.upress`.

## 7. Deliverables
2 live staging URLs; `inc/wave2-w2-04.php`; `inc/wave2-w2-04-content.php`; FAQ/testimonials/CTA
wiring; `style.css` 1.4.3; completion report → `_COMMUNICATION/team_100/` (incl. any AC-05 flags
and testimonial-text/placeholder notes).

*team_100 — 2026-05-29 — READY TO DISPATCH on team_00 go.*
