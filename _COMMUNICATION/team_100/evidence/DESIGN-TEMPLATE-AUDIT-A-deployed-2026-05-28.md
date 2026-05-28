# Design Template Audit — Part A: Deployed Theme Inventory
**Date:** 2026-05-28
**Auditor:** team_100 sub-agent (Sonnet)
**Scope:** site/wp-content/themes/ea-eyalamit/ (read-only)

---

## A. Page Templates (`page-templates/tpl-*.php`)

13 files total. Classification: **REAL** = renders meaningful layout/content; **STUB** = slot comments only, no real block composition.

| File | Template Name | Route / Purpose | Lines | Classification | Markers / Notes |
|------|---------------|-----------------|-------|----------------|-----------------|
| `tpl-home.php` | tpl-home (Wave2) | `/` homepage | 13 | **REAL** — calls `ea_wave2_render_home_blocks(true)` which renders all 12 POC blocks | None |
| `tpl-stage-b-test.php` | tpl-stage-b-test (Wave2 QA smoke) | `/stage-b-test` QA page | 13 | **REAL** — identical to tpl-home; smoke-test double | None |
| `tpl-contact.php` | tpl-contact (Wave2) | `/contact` | 22 | **REAL** — renders `block-intro` + `ea_wave2_render_contact_form()` + footer | CF7 form ID = 0; fallback note printed: "יוגדר לאחר יצירת טופס CF7 ב-wp-admin" |
| `tpl-faq.php` | tpl-faq (Wave2) | `/faq` | 20 | **REAL** — renders `block-faq-mini` between nav/footer | None |
| `tpl-books.php` | tpl-books (Wave2) | `/books` | 19 | **REAL** — renders `block-books-row` between nav/footer | None |
| `tpl-content.php` | tpl-content (Wave2) | `/about`, `/press`, `/about/moksha` | 27 | **STUB** — renders `the_content()` only; slot comments present: `<!-- SLOT: page-title -->`, `<!-- SLOT: section-intro -->` | No block partials wired; relies on WP post content |
| `tpl-service.php` | tpl-service (Wave2) | `/treatment`, `/sound-healing`, `/lessons`, `/method` | 28 | **STUB** — renders `the_content()` only; 3 slot comments: `<!-- SLOT: hero-content -->`, `<!-- SLOT: intro-text -->`, `<!-- SLOT: body-sections -->` | No blocks wired despite D-14 §5 listing 7 slots (hero, intro, content-sections, faq-filter, testimonials, cta-pill, footer) |
| `tpl-book-detail.php` | tpl-book-detail (Wave2) | Individual book pages | 25 | **STUB** — `<!-- SLOT: book-detail -->` only | No content or block wiring |
| `tpl-blog-archive.php` | tpl-blog-archive (Wave2) | Blog listing | 20 | **STUB** — `<!-- SLOT: blog-card archive tiles -->` only | No WP_Query, no loop |
| `tpl-blog-single.php` | tpl-blog-single (Wave2) | Single blog post | 25 | **STUB** — `<!-- SLOT: blog-post -->` only | No `have_posts()` loop |
| `tpl-en-landing.php` | tpl-en-landing (Wave2) | English landing page | 25 | **STUB** — `<!-- SLOT: en-landing-content -->` only | No English content whatsoever |
| `tpl-shop-archive.php` | tpl-shop-archive (Wave2) | Shop/products listing | 20 | **STUB** — `<!-- SLOT: shop-product-grid -->` only | No WooCommerce wiring |
| `tpl-shop-item.php` | tpl-shop-item (Wave2) | Single product | 25 | **STUB** — `<!-- SLOT: shop-item -->` only | No WooCommerce wiring |

**Summary: 5 REAL, 8 STUB** (tpl-home, tpl-stage-b-test, tpl-contact, tpl-faq, tpl-books are real; all others are shells).

---

## B. Block Partials (`template-parts/blocks/block-*.php`)

12 blocks total. Classification: **REAL** = structured markup + ea-* tokens + dynamic/hardcoded content that is presentable; **SKELETON** = placeholder structure only.

| Block File | Block Name | Lines | Markup Quality | Content Source | ea-* Classes | Placeholder Markers |
|------------|------------|-------|----------------|----------------|--------------|---------------------|
| `block-topnav.php` | topnav | 53 | Full structured nav with burger, sound toggle, audio element | Hardcoded RTL links (8 nav items), dynamic `home_url()` | `ea-topnav`, `ea-topnav__brand`, `ea-topnav__links`, `ea-topnav__link`, `ea-topnav__controls`, `ea-topnav__burger`, `ea-sound-toggle` | Audio src resolves to theme; fallback graceful. None |
| `block-hero.php` | hero | 37 | Full — title, subtitle, trust line, CTA pill, 3 breath-lines | All hardcoded Hebrew text | `ea-hero`, `ea-hero__bg`, `ea-hero__gradient-bg`, `ea-hero__breath-line`, `ea-hero__content`, `ea-hero__title`, `ea-hero__subtitle`, `ea-hero__trust`, `ea-hero__cta-pill--ghost-white` | **`<!-- Background: CSS gradient placeholder (variant_placeholder — pre-video delivery) -->`** — explicit comment that video has NOT been delivered |
| `block-breath-divider-1.php` | breath-divider-1 | 9 | Minimal but complete decorative divider | Structural only | `ea-breath-divider`, `ea-breath-divider--delay-1`, `ea-breath-divider__line` | None |
| `block-intro.php` | intro | 18 | Section wrapper with heading + body div | WP `the_content()` pull — dynamic | `ea-section-intro`, `ea-section-intro__inner`, `ea-section-intro__heading`, `ea-section-intro__body` | None — but heading text is hardcoded "מה זה טיפול בנשימה באמצעות דיג׳רידו" |
| `block-method-pillars.php` | method-pillars | 39 | 4-pillar grid, fully marked up | All hardcoded Hebrew text (4 pillars with labels, titles, text) | `ea-content-section--alt`, `ea-pillars-grid`, `ea-pillar`, `ea-pillar__label`, `ea-pillar__title`, `ea-pillar__text` | None — content is real but hardcoded, not from WP fields |
| `block-treatment-overview.php` | treatment-overview | 46 | 2-column service comparison grid | All hardcoded Hebrew bullet lists (Digirido vs Sound Healing) | `ea-service-comparison`, `ea-service-comparison__grid`, `ea-service-comparison__col`, `ea-service-comparison__list`, `ea-service-comparison__cta` | Inline style found: `font-family: var(--ea-font); font-size: 0.78rem; font-weight: 200;` — should be a token class |
| `block-testimonials-row.php` | testimonials-row | 87 | 3-card grid, full markup | Hardcoded Hebrew testimonial text (3 items) | `ea-testimonials-section`, `ea-testimonials-grid`, `ea-testimonial-card`, `ea-testimonial-card__quote`, `ea-testimonial-card__footer` | **`ea-testimonial-card__avatar-placeholder`** — all 3 testimonial avatars use `<span class="ea-testimonial-card__avatar-placeholder">` (sand circle, no real photo) |
| `block-books-row.php` | books-row | 63 | 3-card grid, full markup | Hardcoded (3 book titles + teasers) | `ea-books-section`, `ea-books-grid`, `ea-book-card`, `ea-book-card__link`, `ea-book-card__body` | **`ea-book-card__cover-placeholder`** — all 3 book covers use placeholder div (no real images); `aria-hidden="true"` on placeholder |
| `block-services-row.php` | services-row | 30 | 2-tile grid | Hardcoded (Sound Healing + Lessons) | `ea-services-section`, `ea-services-grid`, `ea-service-tile`, `ea-service-tile__label`, `ea-service-tile__title`, `ea-service-tile__desc` | None — only 2 of 4+ services listed |
| `block-faq-mini.php` | faq-mini | 83 | 4 `<details>/<summary>` FAQ items | Hardcoded Hebrew Q&A (4 items, Digirido-focused) | `ea-faq-mini-section`, `ea-faq-list`, `ea-faq-item`, `ea-faq-item__details`, `ea-faq-item__summary`, `ea-faq-item__question`, `ea-faq-item__answer` | None |
| `block-contact-cta.php` | contact-cta | 31 | 2-column — CTA text side + form side | LHS hardcoded; RHS renders CF7 (dynamic) | `ea-contact-section`, `ea-contact-section__inner`, `ea-contact-section__cta-side`, `ea-contact-section__heading`, `ea-contact-section__body`, `ea-entrance` | Inline style on RHS (`animation-delay:0.15s`) is inline not class-based; CF7 form ID = 0 pending |
| `block-footer-social.php` | footer-social | 77 | Full footer — brand, tagline, location, 4 social icons, nav, copyright | Mix hardcoded + `home_url()` links | `ea-footer`, `ea-footer__inner`, `ea-footer__brand`, `ea-footer__tagline`, `ea-footer__location`, `ea-footer__social`, `ea-footer__social-link`, `ea-footer__nav`, `ea-footer__copy` | Social icon SVGs have `href="#"` for TikTok (placeholder URL) |

**Summary: 12 blocks — 10 REAL (presentable), 2 have significant placeholder content** (hero: no video; books-row: no cover images).

---

## C. CSS / Design Tokens

### `assets/css/ea-tokens.css` — 84 lines

| Category | Variables |
|----------|-----------|
| Brand colors | `--ea-sand`, `--ea-terracotta`, `--ea-earth`, `--ea-olive`, `--ea-ink`, `--ea-chocolate`, `--ea-brick` (7) |
| Semantic aliases | `--ea-accent`, `--ea-accent-strong`, `--ea-text`, `--ea-text-body`, `--ea-text-muted` (5) |
| UI backgrounds | `--ea-bg`, `--ea-bg-alt`, `--ea-line`, `--ea-muted` (4) |
| Typography | `--ea-font`, `--ea-type-h1-hero`, `--ea-type-h1`, `--ea-type-h2`, `--ea-type-h3`, `--ea-type-h4`, `--ea-type-body-lg`, `--ea-type-body`, `--ea-type-body-sm`, `--ea-type-caption` (10) |
| Spacing | `--ea-space-0/1/2/3/4/5/6/8/10/12/15/18/24/36` (14) |
| Layout | `--ea-content-width`, `--ea-prose-width`, `--ea-gutter`, `--ea-section-padding`, `--ea-nav-height`, `--ea-nav-height-mob` (6) |
| Radii | `--ea-radius-pill`, `--ea-radius-img` (2) |
| Z-index | 7 z-index levels (base → tooltip) |
| Transitions | `--ea-ease-enter`, `--ea-ease-exit`, `--ea-dur-fast`, `--ea-dur-mid`, `--ea-dur-slow` (5) |

**Total: 60 CSS custom properties defined.**

Note: `--ea-type-*` shorthand tokens (font shorthand) are defined but blocks mostly set `font-family`, `font-weight`, `font-size` individually rather than applying shorthand — the typography shorthand tokens are not actually consumed by atom classes.

### `assets/css/ea-atoms.css` — 1303 lines

32 atom section comment blocks (`/* === ... ===`). Distinct atom style blocks by `/* ===` section:

1. `atom-nav-topnav` — `.ea-topnav` + sub-elements + responsive
2. `atom-interaction-sound-toggle` — `.ea-sound-toggle`
3. `atom-structure-hero-video` — `.ea-hero` + gradient bg + breath lines + content + responsive
4. `atom-feedback-cta-pill` — `.ea-cta-pill` (3 variants: primary, ghost, ghost-white)
5. `atom-structure-breath-divider` — `.ea-breath-divider`
6. `atom-structure-section-intro + atom-content-bio-block` — `.ea-section-intro`, `.ea-bio-block`
7. `atom-structure-content-section` — `.ea-content-section` + pillars grid + service comparison
8. `atom-content-testimonial-card` — `.ea-testimonials-section`, `.ea-testimonials-grid`, `.ea-testimonial-card`
9. `atom-content-book-card` — `.ea-books-section`, `.ea-books-grid`, `.ea-book-card`
10. Services row — `.ea-services-section`, `.ea-services-grid`, `.ea-service-tile`
11. `atom-content-faq-item` — `.ea-faq-mini-section`, `.ea-faq-list`, `.ea-faq-item`
12. `atom-interaction-whatsapp-cta + atom-interaction-contact-form` — `.ea-contact-section`, `.ea-whatsapp-float`, `.ea-contact-form`
13. `atom-content-bio-block` — `.ea-bio-block` (also covers portrait-placeholder)
14. `atom-data-display-footer-social` — `.ea-footer` + sub-elements
15. Layout helpers — `.ea-container`, `.ea-sr-only`
16. Responsive mobile `<640px` — overrides for all section paddings + headings
17. Skip link — `.ea-skiplink`
18. Scroll progress — `#ea-scroll-progress`
19. Base reset / body / img

**Distinct atoms with CSS: ~19 named atom groups covering all 12 blocks.**

### `assets/css/ea-animations.css` — 115 lines

| Animation | Purpose |
|-----------|---------|
| `breathe-slow` | Horizontal scaleX + opacity — divider lines |
| `breathe-medium` | Opacity pulse — logo brand, portrait images |
| `breathe-fast` | Scale pulse — CTA pills, WhatsApp float |
| `breathe-drift` | XY translateX/Y — accent circles in hero overlay |
| `ea-fadeUp` | translateY entrance — standard scroll entrance |
| `ea-breathReveal` | scale+translateY — section headings |
| `ea-slideIn-rtl` | translateX — panels/drawers from right |

**Utility classes:** `.ea-entrance` (ea-fadeUp), `.ea-entrance--breath` (ea-breathReveal), `.ea-entrance--slide` (ea-slideIn-rtl).

**Reduced-motion fallback:** PRESENT and thorough — `@media (prefers-reduced-motion: reduce)` at line 61. Covers: animation-duration → 0.01ms, iteration-count → 1, transition-duration → 0.01ms; explicit removal of `.ea-breath-line`, `.ea-breath-circle`, `.hero-video-bg::before/::after`; explicit `animation: none !important` for `.ea-entrance`, `.ea-cta-pill`, `.ea-whatsapp-float`, `.ea-testimonials-carousel[data-autoplay]`, `.ea-bio-block__portrait`. Scroll progress hidden. **Note:** `.ea-breath-line` class (in reduced-motion rule) does not match actual block class `.ea-hero__breath-line` — minor mismatch but decorative only.

### CSS Gaps Analysis

| Gap | Severity | Detail |
|-----|----------|--------|
| `--ea-type-*` shorthand tokens unused | Low | Blocks set font properties individually; tokens defined but never consumed by atom classes |
| `.ea-breath-line` vs `.ea-hero__breath-line` | Low | Reduced-motion rule targets `.ea-breath-line` (non-existent) not `.ea-hero__breath-line` (actual); breath lines not suppressed in reduced-motion |
| `.ea-bio-block__portrait` in reduced-motion rule | Info | Block referenced in animations but `block-intro.php` doesn't render `ea-bio-block__portrait` — it renders inline `the_content()`. The `ea-bio-block` atom CSS is defined but no block partial implements it |
| `.ea-testimonials-carousel[data-autoplay]` | Info | Carousel atom CSS rule in reduced-motion; no carousel markup exists in any block — testimonials are a static grid |
| `books-v2.css` and `home-front.css` and `services.css` | Info | 3 extra CSS files exist in `assets/css/` beyond the D-14 trilogy (tokens/atoms/animations). Not enqueued by wave2-stage-b.php — possibly Wave1 residue |
| Inline styles in blocks | Low | `block-treatment-overview.php` line 20 and 37, `block-contact-cta.php` line 25 use raw `style=""` attributes with font/spacing values that should use token classes |

---

## D. Coverage Gaps

### Templates registered in functions.php but file state

| Template | Registered in functions.php | File Exists | State |
|----------|---------------------------|-------------|-------|
| `template-home-dashboard.php` | Yes (ea_eyalamit_home_dashboard_template) | YES | Old Wave1 template — separate from tpl-home |
| `template-faq-catalog.php` | Yes | YES | Old Wave1 |
| `template-galleries-catalog.php` | Yes | YES | Old Wave1 |
| `template-media-catalog.php` | Yes | YES | Old Wave1 |
| `template-books-hub.php` | Yes | YES | Old Wave1 |
| `template-book-detail.php` | Yes | YES | Old Wave1 |
| `template-treatment.php` | Yes | YES | Old Wave1 |
| `template-method.php` | Yes | YES | Old Wave1 |

All 8 `template-*.php` (non-tpl) files are Wave1 legacy; they co-exist with the Wave2 `tpl-*.php` set. No missing files — but overlap could cause routing confusion.

### Blocks referenced in `ea_wave2_home_block_slugs()` vs partials present

All 12 slugs in the ordered list have matching `block-{slug}.php` files. No missing block partials for the homepage flow.

### Hero Video (Hero=C decision)

**block-hero.php line 6:** `<!-- Background: CSS gradient placeholder (variant_placeholder — pre-video delivery) -->`

The hero background is a CSS gradient (`linear-gradient` from `#1a1714` → `#2E2B28` → `#3d2e26`). There is **no `<video>` element, no `<source>`, no video asset** in the theme. The atoms CSS for this block is named `atom-structure-hero-video` but the current implementation is gradient-only. The design decision "Hero=C video" is not implemented — the code has an explicit pre-video placeholder marker.

### Service Pages (tpl-service.php)

`tpl-service.php` covers `/treatment`, `/sound-healing`, `/lessons`, `/method` (4 routes) but renders only `the_content()`. The D-14 §5 spec lists 7 slots for this template (hero, intro, content-sections, faq-filter, testimonials, cta-pill, footer) — none are wired. These 4 service pages currently show only raw WP post content with nav + footer chrome, no designed layout.

### Contact Form

`EA_WAVE2_CF7_FORM_ID = 0` — CF7 form not configured. `tpl-contact.php` and `block-contact-cta.php` both render a fallback notice instead of the actual form: "טופס צור קשר — יוגדר לאחר יצירת טופס CF7 ב-wp-admin."

### Analytics Credentials

`analytics-config.json` uses `__PENDING_EYAL__` sentinel values for GA4 measurement_id and Clarity project_id. Analytics are completely inactive until Eyal provides these.

### English Landing Page

`tpl-en-landing.php` — 25 lines, single `<!-- SLOT: en-landing-content -->` comment, no English content, no translation strings, no layout.

---

## Summary Scorecard

| Dimension | Count | Real/Complete | Stub/Placeholder |
|-----------|-------|---------------|-----------------|
| tpl-* page templates | 13 | 5 | 8 |
| block-* partials | 12 | 10 (presentable) | 2 (hero video, book covers) |
| CSS token variables | 60 | 60 defined | 10 typography shorthand tokens unused |
| Animation keyframes | 7 | 7 with reduced-motion fallback | 1 class name mismatch |
| Atom CSS groups | ~19 | ~17 match blocks | 2 (bio-block portrait, carousel) reference unimplemented markup |
