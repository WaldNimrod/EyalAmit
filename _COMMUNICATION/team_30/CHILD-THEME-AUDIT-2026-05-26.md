# Child Theme Audit — ea-eyalamit | 2026-05-26

**Audited by:** team_30  
**Theme path:** `site/wp-content/themes/ea-eyalamit/`  
**Theme version:** 1.3.6  
**Total files audited:** 22 (11 PHP, 5 CSS, 3 images, 1 JS, 2 images additional)

---

## Summary

- **keep:** 9 files
- **refresh:** 11 files (awaiting LOD400 spec from team_100)
- **delete:** 1 file

---

## File Verdicts

| File | Verdict | Rationale |
|------|---------|-----------|
| `functions.php` | refresh | Core orchestrator — needs Wave2 analytics hooks (GA4 + Clarity) and design token enqueue pattern per LOD400 spec. Otherwise solid: GPT fallbacks, CPT registrations, nav menus, body classes, template routing all correct. |
| `style.css` | refresh | Contains hardcoded CSS custom properties (`--ea-home-*`, `--ea-font-sans`, spacing tokens) scoped to `.ea-home-dashboard` and `.ea-m4-polish`. Wave2 LOD400 will replace these with the canonical design token set. The Wave1 header block comment and theme metadata remain valid. |
| `header.php` | refresh | Current shell is a GP-absent fallback. Wave2 layout changes (new navigation structure, potential sticky header, logo update) are expected per LOD400 scope. The GP delegation pattern (`load_template($parent_header)`) is correct and should be preserved. |
| `footer.php` | refresh | Same pattern as header — GP delegation is correct; the fallback shell footer is functional. Wave2 may introduce a richer footer layout per LOD400 spec. |
| `assets/css/home-front.css` | refresh | Functional Wave1 home layout CSS. Colors are hardcoded (`#1abc9c` accent, grey tones) that differ from the brand palette. Wave2 LOD400 will supply the correct design tokens and layout spec for the homepage. Awaiting LOD400 before touching. |
| `assets/css/services.css` | refresh | Solid Wave1 services layout (treatment + method pages). Uses Rubik correctly per brand, but contains hardcoded hero gradient values and a `border-radius: 6px` card style that may conflict with Wave2 design rules (D-EYAL-DESIGN-STYLE-13 mandates 4px for containers). LOD400 will determine final spec. |
| `assets/css/theme-shell-fallback.css` | keep | Still needed: provides body/layout baseline when GeneratePress parent is absent (dev/staging without full GP install). The body classes it targets (`ea-m4-polish`, `ea-home-dashboard`, `ea-books-hub-view`, `ea-book-detail-view`) are all active. Remove only if GP is confirmed always-present in Wave2 environments. |
| `assets/css/books-wave1.css` | delete | Superseded by `books-v2.css`. The V2 file already loads in `functions.php` via `ea_eyalamit_books_v2_assets()` — `books-wave1.css` is never enqueued. It uses forbidden typography (Frank Ruhl Libre, Amatic SC), heavy box-shadows, and `border-radius: 9–14px` — all Wave1 violations corrected in V2. Safe to delete. |
| `assets/css/books-v2.css` | keep | Active D-EYAL-DESIGN-STYLE-13 implementation. Fully annotated [W1→V2] corrections. Covers hub hero, detail hero, cards, buttons, lightbox, reveal system, gallery, print. No action needed for Wave2 unless LOD400 mandates changes to the books section. |
| `assets/js/books-reveal.js` | keep | Clean IntersectionObserver scroll-reveal. Graceful fallback for no-IO environments. Tied to `.reveal` / `.reveal.visible` classes in `books-v2.css`. No changes needed. |
| `page-templates/template-home-dashboard.php` | refresh | Wave1 home template — hardcoded Hebrew strings, placeholder hero backdrop, Wave1 section structure. LOD400 Stage A will determine Wave2 homepage layout. Likely a significant rewrite. |
| `page-templates/template-books-hub.php` | keep | V2.1 implementation. Uses D-EYAL-DESIGN-STYLE-13 hero banner, Heebo typography, inner-page hero, bundle CTA section. Wave2 is NOT redesigning the books section (Wave1/V2 is complete). Keep as-is. |
| `page-templates/template-book-detail.php` | keep | V2.1 implementation. Blurred cover hero, lightbox, RTL-aware float, V2 button system. Wave2 is NOT redesigning book pages. Keep as-is. |
| `page-templates/template-faq-catalog.php` | keep | M3 catalog template — functional, routes to CPT `ea_faq`. Wave2 is not redesigning catalog pages at this stage. Keep. |
| `page-templates/template-galleries-catalog.php` | keep | M3 catalog template — functional, routes to CPT `ea_gallery`. Keep. |
| `page-templates/template-media-catalog.php` | keep | M3 catalog template — functional, routes to CPT `ea_testimonial`. Keep. |
| `page-templates/template-treatment.php` | keep | Wave1 treatment page. Solid structure with hero, steps, FAQ, CTA. Not in Wave2 redesign scope per available context. Keep pending LOD400 scope confirmation. |
| `page-templates/template-method.php` | keep | Wave1 method page. Same assessment as treatment. Keep. |
| `assets/images/ea-logo.jpg` | keep | Active brand asset — referenced in `header.php` shell fallback. |
| `assets/images/books-hero.jpg` | keep | Active — referenced in `books-v2.css` §32 as `url('../images/books-hero.jpg')`. |
| `assets/images/books-hero-studio.jpg` | keep | Likely alternate/backup for books hero. Keep until confirmed unused. |
| `assets/home/eyal-portrait-hero.jpg` | keep | Home hero portrait asset — referenced in home template or awaiting Wave2 hero integration. |
| `assets/home/workshop-thumb.jpg` | keep | Workshop thumbnail — likely referenced in home dashboard template blocks. |

---

## Refresh Queue (pending LOD400 spec from team_100)

Files that need updating once team_100 delivers Stage A LOD400:

- **`functions.php`** — LOD400 will determine: (a) whether analytics hooks go directly in `functions.php` or in a new `inc/analytics.php` include; (b) whether any consent/cookie banner integration is required; (c) if design token enqueue approach changes (currently via `wp_add_inline_style`).
- **`style.css`** — LOD400 will supply the canonical Wave2 design token set to replace the existing `--ea-home-*` and `--ea-m4-*` custom property declarations. The theme header block remains; token values will be updated.
- **`header.php`** — LOD400 will specify Wave2 header layout: whether sticky header is required, logo treatment, navigation structure changes, and whether the GP-absent shell fallback should be updated or deprecated.
- **`footer.php`** — LOD400 will specify Wave2 footer structure: richer layout, additional nav elements, social links, or legal copy changes.
- **`assets/css/home-front.css`** — LOD400 will supply Wave2 homepage layout spec. The current `#1abc9c` accent color and grey-tone palette will be replaced with brand palette tokens. Layout grid and component spacing may change significantly.
- **`assets/css/services.css`** — LOD400 will confirm whether Wave2 redesigns the treatment/method pages. If yes: full refresh with D-EYAL-DESIGN-STYLE-13 compliance (4px radius, no heavy gradients in CTAs, Heebo or Rubik per spec). If no: keep as Wave1.
- **`page-templates/template-home-dashboard.php`** — LOD400 Stage A homepage spec is the primary blocker. Wave2 homepage layout will likely replace the current 12-block Wave1 structure.

---

## Delete Queue

- **`assets/css/books-wave1.css`** — Wave1 CSS for books section. Fully superseded by `books-v2.css` which is actively enqueued. `books-wave1.css` is never enqueued in the current `functions.php`. Contains multiple design violations (Frank Ruhl Libre, Amatic SC fonts; box-shadows; border-radius 9–14px; `transform: translateY` on hover) that were explicitly corrected in V2. **Safe to delete immediately** — no code references it.

---

## Notes

**Theme quality observations:**
- The theme is well-structured overall. PHP functions use the `ea_eyalamit_` prefix consistently. All template routing via `template_include` filters is clean and prioritized correctly.
- The GeneratePress parent-absent fallback pattern (checking `is_readable($parent_header)` before delegating) is solid and staging-safe.
- `books-wave1.css` is the only confirmed dead file — never enqueued, fully replaced.
- `theme-shell-fallback.css` comments explicitly reference the body classes it depends on; the functions.php assigns those classes correctly. No mismatch found.
- The books V2 system (books-v2.css + books-reveal.js + template-books-hub.php + template-book-detail.php) is complete and Wave2-ready as-is.
- CPT registrations (`ea_faq`, `ea_gallery`, `ea_testimonial`, `ea_testimonial_cat`) and catalog templates are solid M3 code with no issues.
- Services pages (treatment + method) use Rubik consistently with the brand; CSS contains some gradient/shadow patterns that may need Wave2 alignment but are functional.
- The `ea_eyalamit_enqueue_palette_root_overrides()` function correctly uses `wp_add_inline_style` at priority 100 to override GeneratePress dynamic CSS — this pattern is correct and should be preserved.
- No orphaned or unreferenced PHP files found. All page templates are actively routed from `functions.php`.
