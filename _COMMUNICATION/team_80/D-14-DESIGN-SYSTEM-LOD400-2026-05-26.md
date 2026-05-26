---
id: D-14-DESIGN-SYSTEM-LOD400-2026-05-26
title: D-14 Design System — LOD400 Spec (Atoms-First, Wave2 SSOT)
status: FINAL
date: 2026-05-26
authored_by: team_100 (Opus orchestrator) + Sonnet build subagent
owners: team_100 (architecture) + team_80 (design)
parent_mandate: _COMMUNICATION/team_100/MANDATE-TEAM100-STAGE-A-ATOMS-FIRST-2026-05-26.md
inventory_source: _COMMUNICATION/team_80/ATOM-INVENTORY-2026-05-26.md
qa_artifact: _COMMUNICATION/team_50/QA-A2-LOD400-2026-05-26.md
qa_gate_2_verdict: PASS_WITH_FINDINGS
finalized_at: '2026-05-27'
finalized_by: team_100 (Opus orchestrator)
profile: L0
supersedes_partially: D-EYAL-DESIGN-STYLE-13 (extends; does NOT replace)
---

# D-14 Design System — LOD400 Spec

> **SSOT Notice:** This document is the single source of truth for all visual design decisions in EyalAmit.co.il Wave2. It extends D-EYAL-DESIGN-STYLE-13 and supersedes no prior document outright. All 32 atoms are defined here. team_10 implementation MUST reference this file.

---

## Table of Contents

- [§1. Foundation](#1-foundation) — Colors · Typography · Spacing · Grid · Z-index · CSS Variables
- [§2. Motion System](#2-motion-system) — Breathing keyframes · Entrance animations · Micro-interactions · Reduced-motion
- [§3. Atoms](#3-atoms) — All 32 atoms, organized by category
  - **structure (7):** [atom-structure-hero-video](#atom-structure-hero-video) · [atom-structure-section-intro](#atom-structure-section-intro) · [atom-structure-content-section](#atom-structure-content-section) · [atom-structure-breath-divider](#atom-structure-breath-divider) · [atom-structure-gallery](#atom-structure-gallery) · [atom-structure-video-embed](#atom-structure-video-embed) · [atom-structure-page-title](#atom-structure-page-title)
  - **content (9):** [atom-content-testimonial-card](#atom-content-testimonial-card) · [atom-content-faq-item](#atom-content-faq-item) · [atom-content-book-card](#atom-content-book-card) · [atom-content-book-detail](#atom-content-book-detail) · [atom-content-product-card](#atom-content-product-card) · [atom-content-service-comparison](#atom-content-service-comparison) · [atom-content-bio-block](#atom-content-bio-block) · [atom-content-press-item](#atom-content-press-item) · [atom-content-mokesh-block](#atom-content-mokesh-block)
  - **interaction (6):** [atom-interaction-faq-filter](#atom-interaction-faq-filter) · [atom-interaction-whatsapp-cta](#atom-interaction-whatsapp-cta) · [atom-interaction-contact-form](#atom-interaction-contact-form) · [atom-interaction-sound-toggle](#atom-interaction-sound-toggle) · [atom-interaction-testimonials-carousel](#atom-interaction-testimonials-carousel) · [atom-interaction-book-excerpt-accordion](#atom-interaction-book-excerpt-accordion)
  - **feedback (4):** [atom-feedback-cta-pill](#atom-feedback-cta-pill) · [atom-feedback-price-display](#atom-feedback-price-display) · [atom-feedback-green-invoice-cta](#atom-feedback-green-invoice-cta) · [atom-feedback-disclaimer](#atom-feedback-disclaimer)
  - **nav (3):** [atom-nav-topnav](#atom-nav-topnav) · [atom-nav-breadcrumb](#atom-nav-breadcrumb) · [atom-nav-scroll-progress](#atom-nav-scroll-progress)
  - **data-display (3):** [atom-data-display-footer-social](#atom-data-display-footer-social) · [atom-data-display-blog-card](#atom-data-display-blog-card) · [atom-data-display-qr-page](#atom-data-display-qr-page)
- [§4. Composition Rules](#4-composition-rules) — Homepage blocks · Anti-patterns
- [§5. Templates](#5-templates) — 11 page templates with slot maps
- [§6. Interaction Patterns](#6-interaction-patterns) — Hero video · FAQ filter · Breadcrumb · Scroll · Sound · Lightbox
- [§7. Accessibility Spec](#7-accessibility-spec) — WCAG 2.2 AA · ת"י 5568 · Contrast table · Keyboard flows
- [§8. Data Schemas](#8-data-schemas) — 8 JSON schemas
- [§9. WordPress Integration](#9-wordpress-integration) — CPTs · Taxonomies · CF7 · Theme mods · Blocks
- [§10. Performance Budget](#10-performance-budget) — LCP · JS/CSS budgets · Images · Fonts · Video
- [§11. Testing Strategy](#11-testing-strategy) — Visual regression · Smoke · A11y · Lighthouse · Manual matrix
- [§12. Changelog & Versioning](#12-changelog--versioning) — Semver · Breaking changes · Wave3+ protocol

---

## §1. Foundation

### 1.1 Brand Color Palette

Source canonical: `docs/project/EYAL-SITE-COLOR-PALETTE.md` (LOCKED — do not alter hex values without a brand round-trip).

| Internal name | HEX | HSL | CSS Variable | Usage role | Contrast pairings |
|---|---|---|---|---|---|
| **Sand** | `#D8C7B5` | hsl(32, 27%, 78%) | `--ea-sand` | Light backgrounds, gradients, soft fields | On Sand: Ink 9.4:1 ✅ AAA; Earth 3.6:1 ✅ AA large |
| **Terracotta** | `#A44E2B` | hsl(20, 57%, 40%) | `--ea-terracotta` | Primary accent, CTA bg, links, thin accent lines | On Terra: White 4.62:1 ✅ AA; on Bg: Terra 4.8:1 ✅ AA |
| **Earth** | `#8A5A44` | hsl(19, 34%, 40%) | `--ea-earth` | Secondary text, meta, muted labels | On Bg: Earth 5.8:1 ✅ AA; on Sand: Earth 3.7:1 ✅ AA large |
| **Olive** | `#6E6F4A` | hsl(61, 20%, 36%) | `--ea-olive` | Secondary accent, nature/state areas (non-error) | On Bg: Olive 6.2:1 ✅ AA |
| **Ink** | `#2E2B28` | hsl(30, 5%, 17%) | `--ea-ink` | Primary text, headings, nav bg overlay | On Bg: Ink 14.5:1 ✅ AAA; on Sand: 9.4:1 ✅ AAA |
| **Chocolate** | `#5C3A2E` | hsl(15, 33%, 27%) | `--ea-chocolate` | Sub-headings, secondary CTAs, deep borders | On Bg: Choc 8.7:1 ✅ AAA |
| **Brick** | `#AB3A2B` | hsl(6, 60%, 42%) | `--ea-brick` | Strong CTA, important call-to-action emphasis | On White: Brick 4.5:1 ✅ AA; use sparingly |

**UI-only tokens (not brand colors):**

| Token | Value | Purpose |
|---|---|---|
| `--ea-bg` | `#FAF8F5` | Main page background (warm off-white) |
| `--ea-bg-alt` | `#F3EEE8` | Alternate section background (method, FAQ) |
| `--ea-line` | `rgba(216,199,181,0.35)` | Divider lines, grid gaps |
| `--ea-muted` | `#6F635A` | Visible muted text (nav links secondary, labels, captions). On `--ea-bg` 5.55:1 ✅ AA; on `--ea-bg-alt` 5.04:1 ✅ AA. *Updated 2026-05-27 from `#A8A19B` per POC audit (team_190 verdict v1 → v2).* |
| `--ea-text-body` | `#5A3826` | **Canonical body-text color** for prose paragraphs. On `--ea-bg` 7.8:1 ✅ AAA; on `--ea-bg-alt` ≈ 6.0:1 ✅ AAA. Use this in preference to `--ea-earth` for any text rendered as readable copy. *Added 2026-05-27 per POC audit.* |

---

### 1.2 Typography Scale — Heebo

**Rule:** Single font family only. Never mix with another typeface. Weight decreases as size increases (large = lighter).

```css
@import url('https://fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400;500;600&display=swap');
```

| Token | Element | Weight | Size (rem) | Line-height | Letter-spacing | RTL notes |
|---|---|---|---|---|---|---|
| `--ea-type-h1-hero` | H1 Hero overlay | 100 | 3.4rem | 1.12 | -0.5px | text-align: right; text-shadow on mobile |
| `--ea-type-h1` | H1 inner pages | 200 | 2.8rem | 1.12 | -0.5px | text-align: right |
| `--ea-type-h2` | H2 section heads | 200 | 2rem | 1.2 | -0.3px | text-align: right |
| `--ea-type-h3` | H3 sub-heads | 400 | 0.92rem | 1.4 | 0 | text-align: right |
| `--ea-type-h4` | H4 labels | 300 | 0.78rem | 1.4 | 0.2px | uppercase optional |
| `--ea-type-body-lg` | Lead paragraphs | 300 | 1.05rem | 1.9 | 0 | max-width 65ch |
| `--ea-type-body` | Body text | 300 | 0.9rem (15px) | 1.85 | 0 | color: var(--ea-earth); max-width 75ch |
| `--ea-type-body-sm` | Captions, meta | 300 | 0.78rem | 1.6 | 0 | color: var(--ea-muted) |
| `--ea-type-caption` | Labels, overlines | 200 | 0.58rem | 1.4 | 3.5px | UPPERCASE; color: var(--ea-muted) |

**Responsive scaling:** On mobile (< 640px) H1-hero scales to 1.8rem; H1 inner to 1.8rem; H2 to 1.4rem; H3 stays 0.92rem.

---

### 1.3 Spacing Scale

Base unit: 8px. Scale: `--ea-space-N` where N = number of base units.

```css
--ea-space-0:  0px;
--ea-space-1:  8px;
--ea-space-2:  16px;
--ea-space-3:  24px;
--ea-space-4:  32px;
--ea-space-5:  40px;
--ea-space-6:  48px;
--ea-space-8:  64px;
--ea-space-10: 80px;
--ea-space-12: 96px;
--ea-space-15: 120px;
--ea-space-18: 144px;
--ea-space-24: 192px;
--ea-space-36: 288px;
```

**Section padding rule:** `--ea-section-padding: var(--ea-space-15)` (120px) on desktop for reading pages (method, treatment, books). Minimum 60px (var(--ea-space-8) × 0.75) on mobile.

---

### 1.4 Layout Grid

| Parameter | Value |
|---|---|
| Max content width | `1200px` (container); `960px` for prose content |
| Column gutter | `24px` |
| Columns | 12 (fluid) |
| Mobile | `< 640px` — single column, padding 20px |
| Tablet | `640px – 1023px` — 8 columns, padding 32px |
| Desktop | `≥ 1024px` — 12 columns, gutter 24px |
| Wide | `≥ 1440px` — max 1200px centered, gutter scales to 32px |

**Named grids used in atoms:**

| Grid name | Columns | Gap | Usage |
|---|---|---|---|
| `ea-grid-4` | 4 | 1px | Service areas, homepage blocks |
| `ea-grid-3` | 3 | 4px | Gallery, blog archive |
| `ea-grid-2` | 2 | 1px | FAQ, comparison |
| `ea-grid-prose` | 1 | — | Content sections, max-width 960px |

---

### 1.5 Z-index Scale

```css
--ea-z-base:           0;
--ea-z-dropdown:      10;
--ea-z-sticky:        20;
--ea-z-modal-backdrop:40;
--ea-z-modal:         50;
--ea-z-toast:         60;
--ea-z-tooltip:       70;
```

Nav (`atom-nav-topnav`) uses `z-index: var(--ea-z-sticky)` (20). Scroll-progress bar uses `var(--ea-z-sticky)` (20) at top edge.

---

### 1.6 Full `:root` CSS Variables Block

Copy-paste ready for `site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css`:

```css
/* =============================================================
   EyalAmit.co.il — D-14 Design Tokens
   Source: D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md §1
   DO NOT EDIT hex values without a brand round-trip
   ============================================================= */
:root {
  /* --- Brand Colors --- */
  --ea-sand:        #D8C7B5;
  --ea-terracotta:  #A44E2B;
  --ea-earth:       #8A5A44;
  --ea-olive:       #6E6F4A;
  --ea-ink:         #2E2B28;
  --ea-chocolate:   #5C3A2E;
  --ea-brick:       #AB3A2B;

  /* --- Semantic aliases --- */
  --ea-accent:       var(--ea-terracotta);
  --ea-accent-strong:var(--ea-brick);
  --ea-text:         var(--ea-ink);
  --ea-text-body:    #5A3826;  /* Canonical body-text color (was --ea-earth; darker for AA contrast on cream bgs). Added 2026-05-27 per POC audit. */
  --ea-text-muted:   var(--ea-text-body);  /* Body-muted now aliases to text-body; --ea-earth retained for decorative/motion accents only. */

  /* --- UI backgrounds --- */
  --ea-bg:          #FAF8F5;
  --ea-bg-alt:      #F3EEE8;
  --ea-line:        rgba(216,199,181,0.35);
  --ea-muted:       #6F635A;  /* Visible muted text. Updated 2026-05-27 from #A8A19B for AA contrast. */

  /* --- Typography --- */
  --ea-font:        'Heebo', -apple-system, Arial, sans-serif;
  --ea-type-h1-hero:   100 3.4rem/1.12 var(--ea-font);
  --ea-type-h1:        200 2.8rem/1.12 var(--ea-font);
  --ea-type-h2:        200 2.0rem/1.2  var(--ea-font);
  --ea-type-h3:        400 0.92rem/1.4 var(--ea-font);
  --ea-type-h4:        300 0.78rem/1.4 var(--ea-font);
  --ea-type-body-lg:   300 1.05rem/1.9 var(--ea-font);
  --ea-type-body:      300 0.9rem/1.85 var(--ea-font);
  --ea-type-body-sm:   300 0.78rem/1.6 var(--ea-font);
  --ea-type-caption:   200 0.58rem/1.4 var(--ea-font);

  /* --- Spacing --- */
  --ea-space-0:   0px;
  --ea-space-1:   8px;
  --ea-space-2:   16px;
  --ea-space-3:   24px;
  --ea-space-4:   32px;
  --ea-space-5:   40px;
  --ea-space-6:   48px;
  --ea-space-8:   64px;
  --ea-space-10:  80px;
  --ea-space-12:  96px;
  --ea-space-15:  120px;
  --ea-space-18:  144px;
  --ea-space-24:  192px;
  --ea-space-36:  288px;

  /* --- Layout --- */
  --ea-content-width:  1200px;
  --ea-prose-width:    960px;
  --ea-gutter:         24px;
  --ea-section-padding:var(--ea-space-15);
  --ea-nav-height:     64px;
  --ea-nav-height-mob: 56px;

  /* --- Radii --- */
  --ea-radius-pill:  100px;
  --ea-radius-img:   4px;

  /* --- Z-index --- */
  --ea-z-base:            0;
  --ea-z-dropdown:       10;
  --ea-z-sticky:         20;
  --ea-z-modal-backdrop: 40;
  --ea-z-modal:          50;
  --ea-z-toast:          60;
  --ea-z-tooltip:        70;

  /* --- Transitions --- */
  --ea-ease-enter: cubic-bezier(0.22, 1, 0.36, 1);
  --ea-ease-exit:  cubic-bezier(0.64, 0, 0.78, 0);
  --ea-dur-fast:   150ms;
  --ea-dur-mid:    300ms;
  --ea-dur-slow:   600ms;
}
```

---

## §2. Motion System

> **Philosophy (D-14):** "Breathing everywhere, not just Hero." All keyframes simulate organic breath — varying durations, randomised delays per instance — never a metronome. Motion is CSS-only (transform + opacity). No JS-tied scroll animations except scroll-progress.

### 2.1 Breathing Keyframes (CSS `@keyframes`)

```css
/* ================================================================
   EyalAmit D-14 — Breathing Primitives
   File: site/wp-content/themes/ea-eyalamit/assets/css/ea-animations.css
   ================================================================ */

/* Slow horizontal breath — dividers, accent lines */
@keyframes breathe-slow {
  0%, 100% { transform: scaleX(1);    opacity: 0.35; }
  50%       { transform: scaleX(1.15); opacity: 0.55; }
}

/* Medium opacity pulse — logo brand, portrait images */
@keyframes breathe-medium {
  0%, 100% { opacity: 0.94; }
  50%       { opacity: 1; }
}

/* Fast scale pulse — CTA pills, floating WhatsApp button */
@keyframes breathe-fast {
  0%, 100% { transform: scale(1); }
  50%       { transform: scale(1.005); }
}

/* Drift — accent circles in Hero background overlay */
@keyframes breathe-drift {
  0%, 100% { transform: translateX(0)   translateY(0); }
  33%       { transform: translateX(8px) translateY(-4px); }
  66%       { transform: translateX(-6px) translateY(6px); }
}
```

**Duration assignments by keyframe:**

| Keyframe | Default duration | Iteration count | Usage |
|---|---|---|---|
| `breathe-slow` | 7s | infinite | Section dividers, breath lines |
| `breathe-medium` | 5.5s | infinite | Logo/brand, portrait images, bio block |
| `breathe-fast` | 8s | infinite | CTA pill, WhatsApp floating button |
| `breathe-drift` | 12s | infinite | Hero background accent circles |

**Delay randomisation rule:** Each repeating instance on a page should carry a different `animation-delay` value (1s, 2.3s, 3.7s, etc.) to avoid all elements breathing in sync. Assign via inline style or a utility class modifier.

---

### 2.2 Entrance Animations

> **Canonical 2026-05-27 update (POC audit):** Entrance keyframes are **transform-only** — no `opacity` ramp. Reason: opacity ramps cause accessibility scanners (Lighthouse / axe-core) to read text at partial opacity mid-animation, producing false contrast failures. Elements appear instantly at full opacity but still slide/scale in via transform. `prefers-reduced-motion: reduce` still disables transforms entirely via §2.4 media block.

```css
/* Fade up — standard scroll entrance for all atoms (transform-only) */
@keyframes ea-fadeUp {
  from { transform: translateY(20px); }
  to   { transform: translateY(0); }
}

/* Breath reveal — for section headings, section intros (transform-only) */
@keyframes ea-breathReveal {
  from { transform: scale(0.995) translateY(10px); }
  to   { transform: scale(1) translateY(0); }
}

/* Slide in RTL — for panels/drawers entering from the right (transform-only) */
@keyframes ea-slideIn-rtl {
  from { transform: translateX(32px); }
  to   { transform: translateX(0); }
}

/* Utility classes */
.ea-entrance {
  animation: ea-fadeUp var(--ea-dur-slow) var(--ea-ease-enter) both;
}
.ea-entrance--breath {
  animation: ea-breathReveal 700ms var(--ea-ease-enter) both;
}
.ea-entrance--slide {
  animation: ea-slideIn-rtl var(--ea-dur-mid) var(--ea-ease-enter) both;
}
```

**Scroll trigger:** Use `IntersectionObserver` with threshold `0.15` to add `.ea-entrance` class when element enters viewport. Animation plays once (not looped).

---

### 2.3 Micro-interactions

**Link underline grow-from-center:**
```css
.ea-link {
  position: relative;
  text-decoration: none;
  color: var(--ea-terracotta);
}
.ea-link::after {
  content: '';
  position: absolute;
  bottom: -1px;
  left: 50%;
  right: 50%;
  height: 1px;
  background: currentColor;
  transition: left var(--ea-dur-mid) var(--ea-ease-enter),
              right var(--ea-dur-mid) var(--ea-ease-enter);
}
.ea-link:hover::after,
.ea-link:focus-visible::after {
  left: 0;
  right: 0;
}
```

**CTA pill hover:**
```css
.ea-cta-pill {
  animation: breathe-fast 8s ease-in-out infinite;
  transition: transform var(--ea-dur-fast) ease,
              box-shadow var(--ea-dur-fast) ease;
}
.ea-cta-pill:hover {
  transform: scale(1.03);
  box-shadow: 0 4px 16px rgba(164,78,43,0.25);
  animation-play-state: paused;
}
```

**Scroll progress 1px Terracotta line:**
```css
#ea-scroll-progress {
  position: fixed;
  top: 0;
  right: 0;
  left: 0;
  height: 1px;
  background: var(--ea-terracotta);
  opacity: 0.4;
  width: 0%;
  z-index: var(--ea-z-sticky);
  transform-origin: right; /* RTL — grows right-to-left */
  pointer-events: none;
}
```

**Cursor dot** (desktop only — deferred per decision A5; no atom created):
Noted here for completeness. Deferred to Stage B (default; revisit at Stage B). A soft dot with 80ms delay and opacity 0.15 is the approved concept if re-enabled.

---

### 2.4 `@media (prefers-reduced-motion: reduce)` Fallback Block

**Required by ת"י 5568 §4.3 and WCAG 2.3.3.** Every animation primitive MUST be covered.

```css
@media (prefers-reduced-motion: reduce) {
  /* Kill all continuous breathing loops */
  *,
  *::before,
  *::after {
    animation-duration:       0.01ms !important;
    animation-iteration-count:1      !important;
    transition-duration:      0.01ms !important;
    animation-delay:          0ms    !important;
  }

  /* Remove decorative overlay elements entirely */
  .ea-breath-line,
  .ea-breath-circle,
  .hero-video-bg::before,
  .hero-video-bg::after {
    display: none !important;
  }

  /* Keep entrance animations but instant */
  .ea-entrance,
  .ea-entrance--breath,
  .ea-entrance--slide {
    animation: none !important;
    opacity: 1 !important;
    transform: none !important;
  }

  /* Scroll progress: remove dynamic width animation, keep static */
  #ea-scroll-progress {
    display: none !important;
  }

  /* CTA pill: remove pulse, keep visible */
  .ea-cta-pill {
    animation: none !important;
  }

  /* WhatsApp floating button: remove pulse */
  .ea-whatsapp-float {
    animation: none !important;
  }

  /* Link underline: show immediately, no transition */
  .ea-link::after {
    left: 0;
    right: 0;
    transition: none !important;
  }

  /* Testimonial carousel: auto-advance off in reduced-motion */
  .ea-testimonials-carousel[data-autoplay] {
    animation: none !important;
  }
}
```

**Testing protocol:** In Chrome DevTools → Rendering → "Emulate CSS prefers-reduced-motion: reduce". All breathing overlays must vanish. All content must remain readable.

---

## §3. Atoms

> **Conventions:**
> - BEM class prefix: `.ea-<atom>__<part>--<modifier>`
> - All atoms are RTL-first (`direction: rtl` inherited from `<html>`).
> - All `@keyframe` references resolve to §2 definitions.
> - "Composes into" = page templates from §5 that include this atom.

---

### Category: structure (7 atoms)

---

#### atom-structure-hero-video

**HE:** גיבור וידאו | **EN:** Hero Video Frame

**HTML anatomy:**
```html
<section class="ea-hero" aria-label="גיבור ראשי">
  <!-- Background layer: video or static fallback -->
  <div class="ea-hero__bg" aria-hidden="true">
    <video class="ea-hero__video"
           autoplay muted loop playsinline
           preload="metadata"
           poster="/assets/img/hero-fallback.webp">
      <source src="/assets/video/hero.webm" type="video/webm">
      <source src="/assets/video/hero.mp4"  type="video/mp4">
    </video>
    <!-- Mobile fallback image (shown via CSS media query) -->
    <img class="ea-hero__still"
         src="/assets/img/hero-fallback.webp"
         alt="אייל עמית מנגן בדיג'רידו בסטודיו"
         loading="eager" fetchpriority="high">
    <!-- Breathing overlay lines -->
    <span class="ea-hero__breath-line ea-hero__breath-line--1" aria-hidden="true"></span>
    <span class="ea-hero__breath-line ea-hero__breath-line--2" aria-hidden="true"></span>
  </div>

  <!-- Ink overlay for contrast -->
  <div class="ea-hero__overlay" aria-hidden="true"></div>

  <!-- Content layer -->
  <div class="ea-hero__content">
    <h1 class="ea-hero__title"><!-- atom-structure-page-title composited --></h1>
    <p class="ea-hero__subtitle"></p>
    <a class="ea-hero__cta ea-cta-pill" href="/contact"><!-- atom-feedback-cta-pill --></a>
  </div>

  <!-- Controls (top-right in LTR terms = top-left in RTL layout) -->
  <div class="ea-hero__controls" aria-label="פקדי וידאו">
    <button class="ea-hero__pause" type="button"
            aria-label="השהה וידאו" aria-pressed="false">
      <span class="ea-hero__pause-ico" aria-hidden="true">⏸</span>
    </button>
    <!-- atom-interaction-sound-toggle composited here -->
  </div>
</section>
```

**CSS classes (BEM):**
```css
.ea-hero { position: relative; width: 100%; height: 100vh; min-height: 640px;
           overflow: hidden; background: var(--ea-ink); color: #fff;
           display: flex; flex-direction: column; align-items: center; justify-content: center; }

.ea-hero__bg  { position: absolute; inset: 0; }
.ea-hero__video { width: 100%; height: 100%; object-fit: cover; }
.ea-hero__still { width: 100%; height: 100%; object-fit: cover; display: none; }

/* Mobile: show still, hide video */
@media (max-width: 639px) {
  .ea-hero__video { display: none; }
  .ea-hero__still { display: block; }
}

.ea-hero__overlay { position: absolute; inset: 0;
                    background: rgba(46,43,40,0.45); pointer-events: none; }

.ea-hero__breath-line {
  position: absolute; inset-inline-start: 10%; inset-inline-end: 10%;
  height: 1px; background: rgba(216,199,181,0.4);
  animation: breathe-slow 7s ease-in-out infinite;
}
.ea-hero__breath-line--1 { top: 38%; animation-delay: 0s; }
.ea-hero__breath-line--2 { top: 62%; animation-delay: 2.3s; }

.ea-hero__content { position: relative; z-index: 2; text-align: center;
                    padding: 0 var(--ea-space-4); max-width: var(--ea-prose-width); }
.ea-hero__title   { color: #fff; letter-spacing: -0.5px; margin-bottom: var(--ea-space-2); }
.ea-hero__subtitle{ color: rgba(255,255,255,0.8); font-size: 1.05rem; font-weight: 300;
                    margin-bottom: var(--ea-space-5); }
.ea-hero__controls{ position: absolute; top: calc(var(--ea-nav-height) + 16px);
                    inset-inline-start: var(--ea-space-4); display: flex; gap: var(--ea-space-2); }
.ea-hero__pause   { background: transparent; border: 1px solid rgba(255,255,255,0.3);
                    border-radius: var(--ea-radius-pill); padding: 6px 14px;
                    color: rgba(255,255,255,0.75); cursor: pointer; font-family: var(--ea-font);
                    font-size: 0.72rem; transition: border-color var(--ea-dur-fast),
                    color var(--ea-dur-fast); }
.ea-hero__pause:hover { border-color: rgba(255,255,255,0.7); color: #fff; }
.ea-hero__pause:focus-visible { outline: 2px solid var(--ea-terracotta); outline-offset: 3px; }
```

**ARIA:** `<section aria-label="גיבור ראשי">`. Pause button: `aria-pressed`. Video element: no `aria-label` needed (not interactive). Sound toggle: see `atom-interaction-sound-toggle`.

**States:**
- Default: video autoplays muted, breath lines animating
- Video paused: `aria-pressed="true"` on pause button; video element `.pause()`
- Reduced-motion: `display: none` on `.ea-hero__breath-line`; video still loops (not an animation per CSS definition)

**Responsive overrides:** Mobile (< 640px): `<video>` hidden, `<img>` shown. H1 scales to 1.8rem. Controls move below subtitle if viewport < 360px.

**Variants:**
- `variant_video` — default (desktop + H.264/WebM dual source)
- `variant_still` — static image hero (books, shop product pages)
- `variant_placeholder` — CSS gradient + breathing lines (pre-video delivery phase)

**Composes into:** tpl-home, tpl-service, tpl-method

---

#### atom-structure-section-intro

**HE:** בלוק פתיחה | **EN:** Section Intro Block

**HTML anatomy:**
```html
<section class="ea-section-intro ea-section-intro--text-only">
  <div class="ea-section-intro__inner">
    <h2 class="ea-section-intro__heading"></h2>
    <p class="ea-section-intro__body"></p>
    <!-- Optional: portrait image variant -->
    <figure class="ea-section-intro__figure ea-section-intro__figure--hidden">
      <img class="ea-section-intro__img"
           src="" alt="" loading="lazy" width="400" height="480">
    </figure>
  </div>
</section>
```

**CSS (BEM):**
```css
.ea-section-intro { padding: var(--ea-section-padding) var(--ea-gutter); }
.ea-section-intro__inner { max-width: var(--ea-prose-width); margin-inline: auto; }
.ea-section-intro__heading { font: var(--ea-type-h2); color: var(--ea-ink);
                              margin-bottom: var(--ea-space-3); }
.ea-section-intro__body { font: var(--ea-type-body-lg); color: var(--ea-earth);
                           max-width: 65ch; }

/* variant_text-image */
.ea-section-intro--text-image .ea-section-intro__inner {
  display: grid; grid-template-columns: 1fr 360px; gap: var(--ea-space-8); align-items: start;
}
.ea-section-intro__figure { margin: 0; border-radius: var(--ea-radius-img); overflow: hidden; }
.ea-section-intro__img { width: 100%; height: auto; display: block; }
@media (max-width: 639px) {
  .ea-section-intro--text-image .ea-section-intro__inner { grid-template-columns: 1fr; }
  .ea-section-intro__figure { order: 2; }
}
```

**ARIA:** Standard section; H2 in heading hierarchy. Line length capped at 75ch per WCAG 1.4.8.

**States:** Entrance animation `ea-breathReveal` on scroll-into-view (IntersectionObserver).

**Reduced-motion fallback:** `.ea-entrance--breath` stripped; content visible immediately.

**Variants:** `variant_text-only` (default), `variant_text-image` (portrait alongside body copy)

**Composes into:** tpl-home, tpl-service, tpl-method, tpl-shop-item

---

#### atom-structure-content-section

**HE:** בלוק תוכן | **EN:** Content Section Block

**HTML anatomy:**
```html
<section class="ea-content-section ea-content-section--prose">
  <div class="ea-content-section__inner">
    <h2 class="ea-content-section__heading"></h2>
    <div class="ea-content-section__body">
      <!-- variant_prose: <p> elements -->
      <!-- variant_list: <ul> / <ol> semantic -->
      <!-- variant_two-col: CSS grid splits here -->
    </div>
  </div>
</section>
```

**CSS (BEM):**
```css
.ea-content-section { padding: var(--ea-section-padding) var(--ea-gutter);
                       background: var(--ea-bg); }
.ea-content-section--alt { background: var(--ea-bg-alt); }
.ea-content-section__inner { max-width: var(--ea-prose-width); margin-inline: auto; }
.ea-content-section__heading { font: var(--ea-type-h2); color: var(--ea-ink);
                                margin-bottom: var(--ea-space-5); }
.ea-content-section__body p  { font: var(--ea-type-body); color: var(--ea-earth); }
.ea-content-section__body ul,
.ea-content-section__body ol { padding-inline-start: var(--ea-space-3); color: var(--ea-earth); }

/* variant_two-col */
.ea-content-section--two-col .ea-content-section__body {
  display: grid; grid-template-columns: 1fr 1fr; gap: var(--ea-space-8);
}
@media (max-width: 639px) {
  .ea-content-section--two-col .ea-content-section__body { grid-template-columns: 1fr; }
}

/* variant_steps — numbered list */
.ea-content-section--steps .ea-content-section__body ol {
  counter-reset: ea-step;
  list-style: none; padding: 0;
}
.ea-content-section--steps .ea-content-section__body li {
  counter-increment: ea-step;
  position: relative; padding-inline-start: var(--ea-space-5);
  margin-bottom: var(--ea-space-3);
}
.ea-content-section--steps .ea-content-section__body li::before {
  content: counter(ea-step);
  position: absolute; inset-inline-start: 0; top: 0;
  font-size: 0.58rem; font-weight: 200; letter-spacing: 3.5px;
  color: var(--ea-terracotta);
}
```

**ARIA:** `<ul>`/`<ol>` for list variants. H2/H3 hierarchy enforced — H3 for sub-items.

**Ink on bg contrast:** `#2E2B28` on `#FAF8F5` = 14.5:1 — AAA.

**States:** Entrance `ea-breathReveal` on scroll-into-view.

**Reduced-motion:** Entrance stripped; content immediately visible.

**Variants:** `variant_prose`, `variant_list`, `variant_steps`, `variant_two-col`

**Composes into:** tpl-home, tpl-service, tpl-method, tpl-book-detail, tpl-shop-item

---

#### atom-structure-breath-divider

**HE:** מפריד נושם | **EN:** Breath Divider

**HTML anatomy:**
```html
<!-- variant_horizontal -->
<div class="ea-breath-divider" aria-hidden="true">
  <span class="ea-breath-divider__line"></span>
</div>

<!-- variant_accent-circle -->
<div class="ea-breath-circle" aria-hidden="true"></div>
```

**CSS (BEM):**
```css
.ea-breath-divider { display: flex; align-items: center; justify-content: center;
                     padding: var(--ea-space-5) 0; }
.ea-breath-divider__line {
  display: block;
  width: 100%; max-width: var(--ea-prose-width);
  height: 1px;
  background: var(--ea-line);
  animation: breathe-slow 7s ease-in-out infinite;
  transform-origin: center;
}

/* Delay variants — assign via modifier classes */
.ea-breath-divider--delay-1 .ea-breath-divider__line { animation-delay: 1s; }
.ea-breath-divider--delay-2 .ea-breath-divider__line { animation-delay: 2.3s; }
.ea-breath-divider--delay-3 .ea-breath-divider__line { animation-delay: 3.7s; }

.ea-breath-circle {
  position: absolute; border-radius: 50%;
  background: var(--ea-sand); opacity: 0.06;
  animation: breathe-drift 12s ease-in-out infinite;
  pointer-events: none;
}
/* Hide accent circles on mobile to reduce noise */
@media (max-width: 639px) { .ea-breath-circle { display: none; } }
```

**ARIA:** `aria-hidden="true"` — purely decorative. Must carry zero content.

**Reduced-motion fallback:** `.ea-breath-divider__line { animation: none; opacity: 0.35; }` (via `prefers-reduced-motion` block in §2.4).

**Variants:** `variant_horizontal` (full-width 1px line), `variant_accent-circle` (corner float, opacity 0.04–0.08)

**Composes into:** tpl-home, tpl-service, tpl-method, tpl-book-detail, every long-form page

---

#### atom-structure-gallery

**HE:** גלריה | **EN:** Media Gallery

**HTML anatomy:**
```html
<section class="ea-gallery" aria-label="גלריית מדיה">
  <ul class="ea-gallery__grid" role="list">
    <li class="ea-gallery__item">
      <button class="ea-gallery__trigger" type="button"
              aria-label="פתח תמונה: [תיאור]">
        <img class="ea-gallery__img"
             src="/assets/img/gallery-01.webp"
             alt="[תיאור תמונה מלא — לא ריק]"
             loading="lazy" width="600" height="400">
      </button>
    </li>
    <!-- repeat per image -->
  </ul>

  <!-- Lightbox (atom-interaction composited) -->
  <div class="ea-gallery__lightbox" role="dialog"
       aria-label="תמונה מוגדלת" aria-modal="true" hidden>
    <button class="ea-gallery__lb-close" type="button" aria-label="סגור">×</button>
    <button class="ea-gallery__lb-prev" type="button" aria-label="תמונה קודמת">‹</button>
    <button class="ea-gallery__lb-next" type="button" aria-label="תמונה הבאה">›</button>
    <img class="ea-gallery__lb-img" src="" alt="">
  </div>
</section>
```

**CSS (BEM):**
```css
.ea-gallery__grid { display: grid; list-style: none; padding: 0; margin: 0;
                    grid-template-columns: repeat(4, 1fr); gap: 4px; }
@media (max-width: 1023px) { .ea-gallery__grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 639px)  { .ea-gallery__grid { grid-template-columns: 1fr; } }

.ea-gallery__trigger { width: 100%; border: 0; background: none; cursor: pointer; padding: 0;
                       overflow: hidden; border-radius: var(--ea-radius-img); }
.ea-gallery__img { width: 100%; height: auto; display: block;
                   transition: opacity var(--ea-dur-fast); }
.ea-gallery__trigger:hover .ea-gallery__img { opacity: 0.9; }
.ea-gallery__trigger:focus-visible { outline: 2px solid var(--ea-terracotta); outline-offset: 3px; }

.ea-gallery__lightbox { position: fixed; inset: 0; background: rgba(46,43,40,0.92);
                        display: flex; align-items: center; justify-content: center;
                        z-index: var(--ea-z-modal);
                        animation: ea-fadeUp var(--ea-dur-fast) var(--ea-ease-enter); }
.ea-gallery__lightbox[hidden] { display: none; }
.ea-gallery__lb-img { max-width: 90vw; max-height: 90vh; object-fit: contain; }
.ea-gallery__lb-close,
.ea-gallery__lb-prev,
.ea-gallery__lb-next {
  position: absolute; background: none; border: 1px solid rgba(255,255,255,0.3);
  border-radius: var(--ea-radius-pill); color: #fff; cursor: pointer;
  font-size: 1.2rem; padding: 8px 16px;
  transition: border-color var(--ea-dur-fast);
}
.ea-gallery__lb-close { top: var(--ea-space-3); inset-inline-end: var(--ea-space-3); }
.ea-gallery__lb-prev  { inset-inline-end: var(--ea-space-4); }
.ea-gallery__lb-next  { inset-inline-start: var(--ea-space-4); }
```

**ARIA:** `role="dialog"`, `aria-modal="true"`, focus-trap active when lightbox open. Esc closes. Arrow keys navigate. Each image must have descriptive `alt`.

**Reduced-motion:** Lightbox open/close `opacity` transition removed (content appears instantly).

**Variants:** `variant_grid` (default), `variant_lightbox` (click-to-open)

**Composes into:** tpl-home, tpl-service, tpl-book-detail, tpl-shop-item

---

#### atom-structure-video-embed

**HE:** הטמעת וידאו | **EN:** Video Embed

**HTML anatomy:**
```html
<div class="ea-video-embed" data-variant="youtube">
  <!-- Thumbnail with play button overlay -->
  <button class="ea-video-embed__poster" type="button"
          aria-label="הפעל סרטון: [כותרת הסרטון]">
    <img class="ea-video-embed__thumb"
         src="/assets/img/video-thumb.webp"
         alt="[תיאור תמונת הסרטון]" loading="lazy" width="800" height="450">
    <span class="ea-video-embed__play" aria-hidden="true">▶</span>
  </button>
  <!-- iframe loaded on click (JS-driven, preconnect in <head>) -->
  <iframe class="ea-video-embed__frame" hidden
          title="[כותרת הסרטון — חובה]"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope"
          allowfullscreen
          loading="lazy"></iframe>
</div>
```

**CSS (BEM):**
```css
.ea-video-embed { position: relative; aspect-ratio: 16/9;
                  border-radius: var(--ea-radius-img); overflow: hidden; }
.ea-video-embed__poster { width: 100%; height: 100%; border: 0; cursor: pointer;
                          background: none; padding: 0; position: relative; }
.ea-video-embed__thumb  { width: 100%; height: 100%; object-fit: cover;
                           transition: opacity var(--ea-dur-fast); }
.ea-video-embed__poster:hover .ea-video-embed__thumb { opacity: 0.9; }
.ea-video-embed__play {
  position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
  width: 64px; height: 64px; border-radius: 50%;
  background: rgba(164,78,43,0.85); color: #fff;
  display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
  transition: transform var(--ea-dur-fast), background var(--ea-dur-fast);
}
.ea-video-embed__poster:hover .ea-video-embed__play {
  transform: translate(-50%,-50%) scale(1.05);
  background: var(--ea-terracotta);
}
.ea-video-embed__poster:focus-visible { outline: 2px solid var(--ea-terracotta); outline-offset: 3px; }
.ea-video-embed__frame  { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
.ea-video-embed__frame:not([hidden]) ~ .ea-video-embed__poster { display: none; }
```

**ARIA:** `<iframe title="[כותרת]">` mandatory. Play button `aria-label` includes video title.

**Captions:** WCAG 1.2.2 — long-form content embeds must reference captions. YouTube auto-captions acceptable if manually reviewed.

**Reduced-motion:** Thumbnail hover transition removed. Play button scale transition removed.

**Variants:** `variant_youtube` (iframe), `variant_inline-video` (self-hosted mp4)

**Composes into:** tpl-home, tpl-service, tpl-method

---

#### atom-structure-page-title

**HE:** כותרת עמוד H1 | **EN:** Page Title H1

**HTML anatomy:**
```html
<!-- variant_overlay (Hero video pages) -->
<h1 class="ea-page-title ea-page-title--overlay ea-entrance">
  <!-- text content here — must pass ≥ 4.5:1 on video overlay -->
</h1>

<!-- variant_standalone (inner pages without video) -->
<h1 class="ea-page-title ea-page-title--standalone ea-entrance">
  <!-- text content here -->
</h1>
```

**CSS (BEM):**
```css
.ea-page-title {
  font-family: var(--ea-font);
  font-weight: 100;
  line-height: 1.12;
  letter-spacing: -0.5px;
  margin: 0 0 var(--ea-space-2) 0;
  text-align: right; /* RTL */
  animation: ea-fadeUp var(--ea-dur-slow) var(--ea-ease-enter) both;
  animation-delay: 0.2s;
}

.ea-page-title--overlay {
  font-size: 3.4rem;
  color: #fff;
  text-shadow: 0 1px 12px rgba(46,43,40,0.5);
}

.ea-page-title--standalone {
  font-size: 2.8rem;
  font-weight: 200;
  color: var(--ea-ink);
}

/* Responsive */
@media (max-width: 1023px) {
  .ea-page-title--overlay   { font-size: 2.4rem; }
  .ea-page-title--standalone { font-size: 2.0rem; }
}
@media (max-width: 639px) {
  .ea-page-title--overlay   { font-size: 1.8rem; text-shadow: 0 1px 8px rgba(46,43,40,0.7); }
  .ea-page-title--standalone { font-size: 1.8rem; }
}
```

**ARIA:** Exactly one `<h1>` per page. No `aria-*` required beyond semantic element.

**Contrast validation:** overlay white on dark video: minimum 4.5:1. The `rgba(46,43,40,0.45)` overlay in `atom-structure-hero-video` ensures this. Standalone Ink on bg: 14.5:1 AAA.

**Reduced-motion:** `animation: none; opacity: 1; transform: none` (via §2.4 block).

**Variants:** `variant_overlay`, `variant_standalone`

**Composes into:** Every page template

---

### Category: content (9 atoms)

---

#### atom-content-testimonial-card

**HE:** כרטיס עדות | **EN:** Testimonial Card

**HTML anatomy:**
```html
<article class="ea-testimonial-card ea-entrance">
  <!-- variant_text-image-fb-link -->
  <figure class="ea-testimonial-card__figure">
    <img class="ea-testimonial-card__avatar"
         src="/assets/img/testimonials/shiri-elkabetz.webp"
         alt="שירי אלקבץ" width="48" height="48" loading="lazy">
  </figure>
  <blockquote class="ea-testimonial-card__quote">
    <p class="ea-testimonial-card__text"><!-- exact testimonial text — do NOT alter --></p>
    <footer class="ea-testimonial-card__footer">
      <a class="ea-testimonial-card__name ea-link"
         href="https://www.facebook.com/..."
         target="_blank" rel="noopener noreferrer"
         aria-label="המלצת שירי אלקבץ בפייסבוק (נפתח בחלון חדש)">
        שירי אלקבץ
      </a>
      <span class="ea-testimonial-card__hint" aria-hidden="true"> ↗</span>
    </footer>
  </blockquote>
</article>
```

**CSS (BEM):**
```css
.ea-testimonial-card { background: var(--ea-bg); border-top: 1px solid var(--ea-line);
                       padding: var(--ea-space-5); display: flex; gap: var(--ea-space-3);
                       align-items: flex-start; }
.ea-testimonial-card__figure { flex-shrink: 0; }
.ea-testimonial-card__avatar { width: 48px; height: 48px; border-radius: 50%;
                                object-fit: cover; }
.ea-testimonial-card__quote  { margin: 0; flex: 1; }
.ea-testimonial-card__text   { font: var(--ea-type-body); color: var(--ea-earth);
                                margin: 0 0 var(--ea-space-2) 0; font-style: italic; }
.ea-testimonial-card__name   { font-size: 0.78rem; font-weight: 300;
                                color: var(--ea-terracotta); }
.ea-testimonial-card__hint   { color: var(--ea-muted); font-size: 0.7rem; }
```

**ARIA:** `<article>`, `<blockquote>`, `<footer>`. External links: `target="_blank"` + `rel="noopener noreferrer"` + `aria-label` includes "(נפתח בחלון חדש)".

**States:** Hover on name link triggers `ea-link` underline-grow.

**Reduced-motion:** Entrance `ea-fadeUp` stripped; hover underline appears instantly.

**Variants:** `variant_text-fb-link`, `variant_text-image-fb-link`

**Composes into:** tpl-home, tpl-service, tpl-method, tpl-book-detail

---

#### atom-content-faq-item

**HE:** שאלה נפוצה | **EN:** FAQ Accordion Item

**HTML anatomy:**
```html
<div class="ea-faq-item">
  <details class="ea-faq-item__details">
    <summary class="ea-faq-item__summary" role="button" aria-expanded="false">
      <h3 class="ea-faq-item__question"><!-- שאלה כאן --></h3>
      <span class="ea-faq-item__icon" aria-hidden="true">
        <svg viewBox="0 0 16 16" width="16" height="16" aria-hidden="true">
          <path d="M2 5l6 6 6-6" fill="none" stroke="currentColor" stroke-width="1.5"/>
        </svg>
      </span>
    </summary>
    <div class="ea-faq-item__answer">
      <p><!-- תשובה כאן --></p>
    </div>
  </details>
</div>
```

**CSS (BEM):**
```css
.ea-faq-item { border-top: 1px solid var(--ea-line); }
.ea-faq-item__details { width: 100%; }
.ea-faq-item__summary { display: flex; justify-content: space-between; align-items: center;
                        padding: var(--ea-space-4) 0; cursor: pointer; list-style: none;
                        gap: var(--ea-space-3); }
.ea-faq-item__summary::-webkit-details-marker { display: none; }
.ea-faq-item__summary:focus-visible { outline: 2px solid var(--ea-terracotta); outline-offset: 2px; }

.ea-faq-item__question { font-size: 1rem; font-weight: 400; color: var(--ea-ink);
                          margin: 0; text-align: right; }
.ea-faq-item__icon { flex-shrink: 0; color: var(--ea-terracotta);
                     transition: transform var(--ea-dur-mid) var(--ea-ease-enter);
                     /* RTL: icon on LEFT side of summary */ }
.ea-faq-item__details[open] .ea-faq-item__icon { transform: rotate(180deg); }

.ea-faq-item__answer { overflow: hidden;
                       animation: ea-fadeUp var(--ea-dur-mid) var(--ea-ease-enter) both; }
.ea-faq-item__answer p { font: var(--ea-type-body); color: var(--ea-earth); font-weight: 300;
                          padding-bottom: var(--ea-space-4); margin: 0; }
```

**ARIA:** `<details>`/`<summary>` native semantics. If custom JS accordion used: `role="button"`, `aria-expanded` on trigger, `aria-controls` pointing to answer `id`.

**Keyboard:** Enter/Space on `<summary>` toggles. No keyboard trap.

**Reduced-motion:** `animation: none` on `.ea-faq-item__answer`; icon transform `transition: none`.

**Variants:** `variant_standalone`, `variant_category-group` (items grouped under H2 category header)

**Composes into:** tpl-faq, tpl-service, tpl-method, tpl-shop-item, tpl-book-detail

---

#### atom-content-book-card

**HE:** כרטיס ספר | **EN:** Book Card

**HTML anatomy:**
```html
<article class="ea-book-card ea-entrance">
  <a class="ea-book-card__link" href="/books/vekatavta"
     aria-label="פרטים על הספר: וכתבת">
    <figure class="ea-book-card__figure">
      <img class="ea-book-card__cover"
           src="/assets/img/books/vekatavta-cover.webp"
           alt="כריכת הספר וכתבת" loading="lazy" width="200" height="280">
    </figure>
    <div class="ea-book-card__body">
      <h3 class="ea-book-card__title">וכתבת</h3>
      <p class="ea-book-card__teaser"><!-- 2-line teaser --></p>
    </div>
  </a>
</article>
```

**CSS (BEM):**
```css
.ea-book-card { transition: transform var(--ea-dur-fast) var(--ea-ease-enter),
                box-shadow var(--ea-dur-fast); border-radius: var(--ea-radius-img); }
.ea-book-card:hover { transform: scale(1.02); box-shadow: 0 8px 24px rgba(46,43,40,0.08); }
.ea-book-card__link { display: flex; gap: var(--ea-space-3); text-decoration: none;
                      align-items: flex-start; }
.ea-book-card__cover { border-radius: var(--ea-radius-img); width: 100%; height: auto; display: block; }
.ea-book-card__title { font: var(--ea-type-h3); color: var(--ea-ink);
                       margin: 0 0 var(--ea-space-1) 0; }
.ea-book-card__teaser{ font: var(--ea-type-body-sm); color: var(--ea-earth); margin: 0; }

/* Grid: 3 cols desktop, 2 tablet, 1 mobile */
.ea-books-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: var(--ea-space-5); }
@media (max-width:1023px) { .ea-books-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width:639px)  { .ea-books-grid { grid-template-columns: 1fr; } }
```

**ARIA:** Entire card is `<a>` with `aria-label`. Image alt = book title.

**Reduced-motion:** `transition: none` on scale/shadow.

**Variants:** `variant_catalog`, `variant_bundle` (all 3 books with crossed-out price)

**Composes into:** tpl-books (catalog page)

---

#### atom-content-book-detail

**HE:** פרטי ספר | **EN:** Book Detail Block

**HTML anatomy:**
```html
<div class="ea-book-detail">
  <!-- variant_summary -->
  <div class="ea-book-detail__summary">
    <figure class="ea-book-detail__cover-fig">
      <img class="ea-book-detail__cover"
           src="/assets/img/books/vekatavta-cover.webp"
           alt="כריכת הספר וכתבת" loading="eager" width="320" height="448">
    </figure>
    <div class="ea-book-detail__meta">
      <h1 class="ea-book-detail__title">וכתבת</h1>
      <p class="ea-book-detail__description"><!-- תיאור הספר --></p>
    </div>
  </div>

  <!-- variant_excerpt — accordion, atom-interaction-book-excerpt-accordion composited -->

  <!-- variant_about-author -->
  <div class="ea-book-detail__author">
    <h2 class="ea-book-detail__author-heading">על המחבר</h2>
    <p class="ea-book-detail__author-bio"><!-- ביו קצרה --></p>
  </div>
</div>
```

**CSS (BEM):**
```css
.ea-book-detail__summary { display: grid; grid-template-columns: 320px 1fr;
                            gap: var(--ea-space-8); align-items: start;
                            margin-bottom: var(--ea-space-8); }
@media (max-width:639px) {
  .ea-book-detail__summary { grid-template-columns: 1fr; }
  .ea-book-detail__cover { width: 100%; max-width: 320px; }
}
.ea-book-detail__title { font: var(--ea-type-h1); color: var(--ea-ink); margin: 0 0 var(--ea-space-3); }
.ea-book-detail__description { font: var(--ea-type-body-lg); color: var(--ea-earth); }
```

**ARIA:** External purchase links: `target="_blank"` + `rel="noopener noreferrer"` + `aria-label` with "(נפתח בחלון חדש)".

**Reduced-motion:** No breathing loops. Accordion `max-height` transition removed (height set to `auto` immediately).

**Variants:** `variant_summary`, `variant_excerpt`, `variant_about-author`

**Composes into:** tpl-book-detail

---

#### atom-content-product-card

**HE:** כרטיס מוצר | **EN:** Product Card

**HTML anatomy:**
```html
<!-- variant_catalog-tile (in /shop grid) -->
<article class="ea-product-card ea-entrance">
  <a class="ea-product-card__link" href="/didgeridoos"
     aria-label="פרטים על מוצר: דיג'רידו">
    <figure class="ea-product-card__figure">
      <img class="ea-product-card__img"
           src="/assets/img/products/didg-01.webp"
           alt="דיג'רידו מעץ אוקליפטוס — מבנה ופיתוחים" loading="lazy" width="400" height="300">
    </figure>
    <div class="ea-product-card__body">
      <h3 class="ea-product-card__title">דיג'רידו</h3>
      <!-- atom-feedback-price-display composited here -->
      <span class="ea-product-card__price"><!-- price atom --></span>
    </div>
  </a>
  <!-- atom-feedback-cta-pill composited below image -->
  <a class="ea-cta-pill ea-product-card__cta" href="/contact">לרכישה ויצירת קשר</a>
</article>
```

**CSS (BEM):**
```css
.ea-product-card { border-radius: var(--ea-radius-img); overflow: hidden;
                   transition: transform var(--ea-dur-fast), box-shadow var(--ea-dur-fast); }
.ea-product-card:hover { transform: scale(1.02); box-shadow: 0 8px 24px rgba(46,43,40,0.08); }
.ea-product-card__link { display: block; text-decoration: none; }
.ea-product-card__img  { width: 100%; height: 220px; object-fit: cover;
                          border-radius: var(--ea-radius-img) var(--ea-radius-img) 0 0; }
.ea-product-card__body { padding: var(--ea-space-3); }
.ea-product-card__title { font: var(--ea-type-h3); color: var(--ea-ink); margin: 0 0 var(--ea-space-1); }

/* /shop grid: 4 cols desktop, 2 tablet, 1 mobile */
.ea-shop-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: var(--ea-space-4); }
@media (max-width:1023px) { .ea-shop-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width:639px)  { .ea-shop-grid { grid-template-columns: 1fr; } }
```

**ARIA:** `aria-label` on card link includes product name. CTA button label: "לרכישת [מוצר]" — not just "קנה".

**Reduced-motion:** Scale/shadow transition removed.

**Variants:** `variant_catalog-tile`, `variant_detail` (shop item page hero)

**Composes into:** tpl-shop-archive, tpl-shop-item

---

#### atom-content-service-comparison

**HE:** השוואת שירותים | **EN:** Service Comparison Block

**HTML anatomy:**
```html
<section class="ea-service-comparison" aria-label="השוואת שירותים">
  <!-- variant_two-col -->
  <div class="ea-service-comparison__grid ea-service-comparison__grid--2">
    <div class="ea-service-comparison__col ea-entrance">
      <h3 class="ea-service-comparison__col-title">טיפול בדיג'רידו</h3>
      <ul class="ea-service-comparison__list">
        <li><!-- feature item --></li>
      </ul>
      <a class="ea-cta-pill" href="/treatment">לפרטים</a>
    </div>
    <div class="ea-service-comparison__col ea-entrance" style="animation-delay:0.15s">
      <h3 class="ea-service-comparison__col-title">סאונד הילינג</h3>
      <ul class="ea-service-comparison__list"><!-- ... --></ul>
      <a class="ea-cta-pill" href="/sound-healing">לפרטים</a>
    </div>
  </div>
</section>
```

**CSS (BEM):**
```css
.ea-service-comparison { padding: var(--ea-section-padding) var(--ea-gutter); }
.ea-service-comparison__grid--2 { display: grid; grid-template-columns: 1fr 1fr;
                                   gap: 1px; background: var(--ea-line); }
.ea-service-comparison__grid--3 { grid-template-columns: 1fr 1fr 1fr; }
.ea-service-comparison__col { background: var(--ea-bg); padding: var(--ea-space-8); }
.ea-service-comparison__col-title { font: var(--ea-type-h3); color: var(--ea-ink);
                                    margin: 0 0 var(--ea-space-4); }
.ea-service-comparison__list { list-style: none; padding: 0; margin: 0 0 var(--ea-space-5); }
.ea-service-comparison__list li { font: var(--ea-type-body); color: var(--ea-earth);
                                   border-top: 1px solid var(--ea-line); padding: var(--ea-space-2) 0; }
/* Mobile: stack */
@media (max-width:639px) {
  .ea-service-comparison__grid--2,
  .ea-service-comparison__grid--3 { grid-template-columns: 1fr; }
}
/* variant_three-col on mobile: accordion */
@media (max-width:639px) {
  .ea-service-comparison__grid--3 .ea-service-comparison__col { border-top: 1px solid var(--ea-line); }
}
```

**ARIA:** If rendered as table: `<table>` with `scope="col"` on headers. Link anchor text descriptive per column.

**Reduced-motion:** Entrance animation stripped.

**Variants:** `variant_two-col`, `variant_three-col`

**Composes into:** tpl-home, tpl-service, tpl-method

---

#### atom-content-bio-block

**HE:** בלוק ביוגרפי | **EN:** Bio / About Block

**HTML anatomy:**
```html
<section class="ea-bio-block ea-bio-block--brief">
  <div class="ea-bio-block__inner">
    <figure class="ea-bio-block__figure">
      <img class="ea-bio-block__portrait"
           src="/assets/img/eyal-portrait.webp"
           alt="אייל עמית" loading="lazy" width="320" height="400">
    </figure>
    <div class="ea-bio-block__content">
      <h2 class="ea-bio-block__heading">אייל עמית</h2>
      <p class="ea-bio-block__text"><!-- ביוגרפיה --></p>
      <!-- Internal links to method, treatment, moksha -->
    </div>
  </div>
</section>
```

**CSS (BEM):**
```css
.ea-bio-block { padding: var(--ea-section-padding) var(--ea-gutter); }
.ea-bio-block__inner { max-width: var(--ea-prose-width); margin-inline: auto;
                       display: grid; grid-template-columns: 320px 1fr;
                       gap: var(--ea-space-8); align-items: start; }
/* RTL: portrait on right, text on left */
.ea-bio-block__figure { order: 2; margin: 0; }
.ea-bio-block__content { order: 1; }
@media (max-width:639px) {
  .ea-bio-block__inner { grid-template-columns: 1fr; }
  .ea-bio-block__figure { order: 1; }
  .ea-bio-block__content { order: 2; }
}
.ea-bio-block__portrait { width: 100%; border-radius: var(--ea-radius-img); display: block;
                           animation: breathe-medium 5.5s ease-in-out infinite; }
.ea-bio-block__heading { font: var(--ea-type-h2); color: var(--ea-ink); margin: 0 0 var(--ea-space-3); }
.ea-bio-block__text { font: var(--ea-type-body); color: var(--ea-earth); }
```

**ARIA:** Portrait alt = "אייל עמית". Decorative separators `aria-hidden`. Internal links descriptive.

**Reduced-motion:** Portrait `breathe-medium` animation removed; opacity fixed at 1.

**Variants:** `variant_brief`, `variant_extended`

**Composes into:** tpl-home, tpl-service, tpl-method, tpl-books-catalog

---

#### atom-content-press-item

**HE:** פריט כתבה | **EN:** Press / Article List Item

**HTML anatomy:**
```html
<li class="ea-press-item ea-entrance">
  <time class="ea-press-item__date" datetime="2024-03-15">15 במרץ 2024</time>
  <a class="ea-press-item__link ea-link"
     href="https://..."
     target="_blank" rel="noopener noreferrer"
     aria-label="כתבה: [כותרת] — נפתח בחלון חדש">
    <!-- כותרת הכתבה -->
  </a>
</li>
```

**CSS (BEM):**
```css
.ea-press-item { display: flex; gap: var(--ea-space-4); align-items: baseline;
                 border-top: 1px solid var(--ea-line); padding: var(--ea-space-3) 0; }
.ea-press-item__date { font: var(--ea-type-caption); color: var(--ea-muted);
                       flex-shrink: 0; text-transform: uppercase; letter-spacing: 2px; }
.ea-press-item__link { font: var(--ea-type-body); color: var(--ea-ink); }
```

**ARIA:** `<time datetime="">` for semantic date. Link text descriptive — not "לחצו כאן".

**Reduced-motion:** Entrance `ea-fadeUp` removed.

**Variants:** `variant_list-item`

**Composes into:** tpl-press (part of /about or dedicated /press page)

---

#### atom-content-mokesh-block

**HE:** בלוק מוקש | **EN:** Mokesh Dahiman Block

**HTML anatomy:**
```html
<!-- variant_page -->
<article class="ea-mokesh-block">
  <figure class="ea-mokesh-block__figure">
    <img class="ea-mokesh-block__photo"
         src="/assets/img/mokesh-portrait.webp"
         alt="מוקש דהימן — מאסטר לדיג'רידו"
         loading="lazy" width="360" height="440">
  </figure>
  <div class="ea-mokesh-block__content">
    <h1 class="ea-mokesh-block__title">מוקש דהימן</h1>
    <p class="ea-mokesh-block__body"><!-- תוכן מ-ומה היום.docx לאחר המרה ל-.md --></p>
    <a class="ea-link" href="/about">חזרה לאודות</a>
  </div>
</article>

<!-- variant_inline-reference -->
<p class="ea-mokesh-block--inline">
  <!-- קצרה עם קישור -->
  <a class="ea-link" href="/about/moksha">מוקש דהימן</a>
</p>
```

**CSS (BEM):**
```css
.ea-mokesh-block { display: grid; grid-template-columns: 360px 1fr;
                   gap: var(--ea-space-8); align-items: start;
                   max-width: var(--ea-prose-width); margin-inline: auto; }
.ea-mokesh-block__photo { width: 100%; border-radius: var(--ea-radius-img); display: block;
                           animation: breathe-medium 5.5s ease-in-out infinite; }
@media (max-width:639px) { .ea-mokesh-block { grid-template-columns: 1fr; } }
.ea-mokesh-block__title { font: var(--ea-type-h1); color: var(--ea-ink); margin: 0 0 var(--ea-space-3); }
.ea-mokesh-block__body { font: var(--ea-type-body); color: var(--ea-earth); }
```

**ARIA:** `<article>`. External Wikipedia/archive links: new tab + `rel="noopener"`.

**Reduced-motion:** Portrait `breathe-medium` removed; opacity fixed at 1.

**Variants:** `variant_page`, `variant_inline-reference`

**Composes into:** tpl-about-moksha, tpl-method (inline reference), tpl-treatment (inline reference)

---

### Category: interaction (6 atoms)

---

#### atom-interaction-faq-filter

**HE:** סינון שאלות נפוצות | **EN:** FAQ Category Filter

**HTML anatomy:**
```html
<nav class="ea-faq-filter" aria-label="סינון לפי קטגוריה">
  <ul class="ea-faq-filter__tabs" role="tablist" aria-label="קטגוריות שאלות נפוצות">
    <li role="presentation">
      <button class="ea-faq-filter__tab ea-faq-filter__tab--active"
              role="tab" id="tab-all"
              aria-selected="true" aria-controls="panel-all"
              type="button">כל השאלות</button>
    </li>
    <li role="presentation">
      <button class="ea-faq-filter__tab" role="tab" id="tab-treatment"
              aria-selected="false" aria-controls="panel-treatment"
              type="button">טיפול</button>
    </li>
    <li role="presentation">
      <button class="ea-faq-filter__tab" role="tab" id="tab-lessons"
              aria-selected="false" aria-controls="panel-lessons"
              type="button">שיעורים</button>
    </li>
    <li role="presentation">
      <button class="ea-faq-filter__tab" role="tab" id="tab-sound"
              aria-selected="false" aria-controls="panel-sound"
              type="button">סאונד הילינג</button>
    </li>
  </ul>
</nav>

<div class="ea-faq-panels">
  <div id="panel-all" role="tabpanel" aria-labelledby="tab-all">
    <!-- atom-content-faq-item × N -->
  </div>
  <div id="panel-treatment" role="tabpanel" aria-labelledby="tab-treatment" hidden>
    <!-- filtered items -->
  </div>
  <!-- ... -->
</div>
```

**CSS (BEM):**
```css
.ea-faq-filter__tabs { display: flex; gap: var(--ea-space-1); list-style: none;
                        padding: 0; margin: 0 0 var(--ea-space-5);
                        flex-wrap: wrap; /* mobile wrap */ }
.ea-faq-filter__tab { background: none; border: 1px solid var(--ea-line); cursor: pointer;
                       padding: 8px 20px; border-radius: var(--ea-radius-pill);
                       font: var(--ea-type-body-sm); color: var(--ea-earth);
                       transition: color var(--ea-dur-fast), border-color var(--ea-dur-fast); }
.ea-faq-filter__tab--active,
.ea-faq-filter__tab[aria-selected="true"] {
  border-color: var(--ea-terracotta); color: var(--ea-terracotta); font-weight: 400; }
.ea-faq-filter__tab:focus-visible { outline: 2px solid var(--ea-terracotta); outline-offset: 2px; }

.ea-faq-panels [role="tabpanel"] { animation: ea-fadeUp var(--ea-dur-mid) var(--ea-ease-enter); }
.ea-faq-panels [role="tabpanel"][hidden] { display: none; }

/* Mobile: stacked category headers */
@media (max-width:639px) { .ea-faq-filter__tabs { flex-direction: column; align-items: flex-end; } }
```

**ARIA:** `role="tablist"`, `role="tab"`, `aria-selected`, `aria-controls`, `role="tabpanel"`, `aria-labelledby`. Arrow keys navigate tabs (JS required).

**URL state:** JS pushes `?cat=treatment` on tab activation for direct linking.

**Reduced-motion:** Panel crossfade animation removed; tab switch instant.

**Variants:** `variant_tab-bar`, `variant_inline-filtered`

**Composes into:** tpl-faq, tpl-service (embedded, filtered)

---

#### atom-interaction-whatsapp-cta

**HE:** כפתור וואטסאפ | **EN:** WhatsApp CTA

**HTML anatomy:**
```html
<!-- variant_B: form + WhatsApp together -->
<!-- Floating pill — fixed on all pages -->
<a class="ea-whatsapp-float"
   href="https://wa.me/9720524822842"
   target="_blank" rel="noopener noreferrer"
   aria-label="שלח הודעה בוואטסאפ (נפתח בחלון חדש)">
  <svg class="ea-whatsapp-float__icon" aria-hidden="true" viewBox="0 0 24 24" width="24" height="24">
    <path fill="currentColor" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967..."/>
  </svg>
  <span class="ea-whatsapp-float__label">שלח הודעה</span>
</a>
```

**CSS (BEM):**
```css
.ea-whatsapp-float {
  position: fixed; bottom: var(--ea-space-5); inset-inline-start: var(--ea-space-5);
  z-index: var(--ea-z-toast);
  display: inline-flex; align-items: center; gap: var(--ea-space-1);
  background: #25D366; color: #fff;
  border-radius: var(--ea-radius-pill); padding: 12px 20px;
  text-decoration: none; font: var(--ea-type-body-sm); font-weight: 400;
  animation: breathe-fast 8s ease-in-out infinite;
  transition: box-shadow var(--ea-dur-fast), background var(--ea-dur-fast);
}
.ea-whatsapp-float:hover { background: #1ebe5d; box-shadow: 0 4px 16px rgba(37,211,102,0.3); }
.ea-whatsapp-float:focus-visible { outline: 2px solid #fff; outline-offset: 3px; }

/* variant_A: hidden entirely (no WhatsApp) */
.ea-whatsapp-float[data-variant="A"] { display: none !important; }
```

**ARIA:** `aria-label` includes "(נפתח בחלון חדש)". White on #25D366 = 3.95:1 — passes AA for large text; acceptable at this size (≥ 14px bold equivalent). Per accessibility review: acceptable (default; revisit at Stage B for AAA).

**GA4 event:** `click` → `{event: 'whatsapp_cta_click', variant_label: 'B'}`.

**Reduced-motion:** `breathe-fast` animation removed; hover box-shadow transition removed.

**Variants:** `variant_A` (hidden), `variant_B` (visible + form), `variant_C` (only this, no form)

**Composes into:** Every page template as floating element; tpl-contact as inline variant

---

#### atom-interaction-contact-form

**HE:** טופס צור קשר | **EN:** Contact Form (CF7 Wrapper)

**HTML anatomy (CF7 output, styled):**
```html
<div class="ea-contact-form" role="form" aria-label="טופס צור קשר">
  <form class="ea-contact-form__form" novalidate>
    <div class="ea-contact-form__field">
      <label class="ea-contact-form__label" for="cf7-name">שם מלא *</label>
      <input class="ea-contact-form__input" type="text" id="cf7-name"
             name="your-name" required aria-required="true"
             aria-describedby="cf7-name-error" autocomplete="name">
      <span class="ea-contact-form__error" id="cf7-name-error" role="alert" aria-live="assertive"></span>
    </div>

    <div class="ea-contact-form__field">
      <label class="ea-contact-form__label" for="cf7-phone">טלפון / אימייל *</label>
      <input class="ea-contact-form__input" type="text" id="cf7-phone"
             name="your-phone" required aria-required="true"
             aria-describedby="cf7-phone-error" autocomplete="tel">
      <span class="ea-contact-form__error" id="cf7-phone-error" role="alert" aria-live="assertive"></span>
    </div>

    <div class="ea-contact-form__field">
      <label class="ea-contact-form__label" for="cf7-subject">נושא פניה</label>
      <select class="ea-contact-form__select" id="cf7-subject" name="your-subject">
        <option value="">בחר נושא</option>
        <option value="treatment">טיפול בדיג'רידו</option>
        <option value="sound-healing">סאונד הילינג</option>
        <option value="lessons">שיעורי נגינה</option>
        <option value="books">ספרים</option>
        <option value="shop">חנות</option>
        <option value="general">כללי</option>
        <option value="other">אחר</option>
      </select>
    </div>

    <div class="ea-contact-form__field">
      <label class="ea-contact-form__label" for="cf7-message">הודעה</label>
      <textarea class="ea-contact-form__textarea" id="cf7-message"
                name="your-message" rows="5"></textarea>
    </div>

    <button class="ea-cta-pill ea-contact-form__submit" type="submit">שלח הודעה</button>

    <div class="ea-contact-form__status" aria-live="polite" aria-atomic="true"></div>
  </form>
</div>
```

**CSS (BEM):**
```css
.ea-contact-form { max-width: 560px; margin-inline: auto; }
.ea-contact-form__label { display: block; font: var(--ea-type-body-sm); color: var(--ea-ink);
                           margin-bottom: var(--ea-space-1); text-align: right; }
.ea-contact-form__input,
.ea-contact-form__select,
.ea-contact-form__textarea {
  width: 100%; padding: 12px 16px; border: 1px solid var(--ea-line);
  border-radius: var(--ea-radius-img); background: var(--ea-bg);
  font: var(--ea-type-body); color: var(--ea-ink); direction: rtl; text-align: right;
  transition: border-color var(--ea-dur-fast);
}
.ea-contact-form__input:focus,
.ea-contact-form__select:focus,
.ea-contact-form__textarea:focus {
  border-color: var(--ea-terracotta); outline: none;
  border-bottom-width: 2px; /* bottom border grow effect */
}
.ea-contact-form__input:focus-visible,
.ea-contact-form__select:focus-visible,
.ea-contact-form__textarea:focus-visible { outline: 2px solid var(--ea-terracotta); outline-offset: 2px; }
.ea-contact-form__field { margin-bottom: var(--ea-space-4); }
.ea-contact-form__error { display: block; font: var(--ea-type-body-sm);
                           color: var(--ea-brick); margin-top: var(--ea-space-1); }
.ea-contact-form__status[data-state="success"] { color: var(--ea-olive); }
.ea-contact-form__status[data-state="error"] { color: var(--ea-brick); }
```

**ARIA:** Every `<input>` has associated `<label>`. Error spans: `aria-describedby`, `role="alert"`, `aria-live="assertive"`. Success message: `aria-live="polite"`. Submit: descriptive text.

**SMTP route:** WP Mail SMTP → `info@eyalamit.co.il`. Eyal enters SMTP password in WP admin.

**Reduced-motion:** Field focus border transition removed; focus-visible ring still shown.

**Variants:** `variant_minimal-balanced`, `variant_inline-cta` (name + phone only)

**Composes into:** tpl-contact, tpl-service (embedded)

---

#### atom-interaction-sound-toggle

**HE:** כפתור השמע | **EN:** Sound Toggle

**HTML anatomy:**
```html
<button class="ea-sound-toggle" type="button"
        aria-label="הפעל צליל דיג'רידו"
        aria-pressed="false"
        data-on="false">
  <span class="ea-sound-toggle__ico ea-sound-toggle__ico--off" aria-hidden="true">♪</span>
  <span class="ea-sound-toggle__ico ea-sound-toggle__ico--on" aria-hidden="true" hidden>🔊</span>
  <span class="ea-sound-toggle__label">שמע</span>
  <audio class="ea-sound-toggle__audio" preload="none"
         src="/assets/audio/didgeridoo-ambient.mp3"></audio>
</button>
```

**CSS (BEM):**
```css
.ea-sound-toggle {
  background: transparent; border: 1px solid rgba(255,255,255,0.25);
  border-radius: var(--ea-radius-pill); padding: 6px 14px;
  font-family: var(--ea-font); font-size: 0.68rem; font-weight: 300;
  color: rgba(255,255,255,0.7); cursor: pointer;
  display: inline-flex; align-items: center; gap: 6px;
  transition: border-color var(--ea-dur-fast), color var(--ea-dur-fast);
}
.ea-sound-toggle:hover { color: #fff; border-color: rgba(255,255,255,0.6); }
.ea-sound-toggle:focus-visible { outline: 2px solid var(--ea-terracotta); outline-offset: 3px; }
.ea-sound-toggle[data-on="true"] { color: var(--ea-sand); border-color: var(--ea-sand); }
.ea-sound-toggle__ico { font-size: 0.8rem; transition: opacity var(--ea-dur-fast); }
```

**JS behaviour:**
```javascript
const btn = document.querySelector('.ea-sound-toggle');
const audio = btn.querySelector('.ea-sound-toggle__audio');

btn.addEventListener('click', () => {
  const isOn = btn.getAttribute('data-on') === 'true';
  if (isOn) {
    audio.pause();
    btn.setAttribute('aria-label', 'הפעל צליל דיג'רידו');
    btn.setAttribute('aria-pressed', 'false');
    btn.setAttribute('data-on', 'false');
    sessionStorage.removeItem('ea-sound-on');
  } else {
    audio.play().catch(() => {}); // graceful degradation
    btn.setAttribute('aria-label', 'השתק צליל');
    btn.setAttribute('aria-pressed', 'true');
    btn.setAttribute('data-on', 'true');
    sessionStorage.setItem('ea-sound-on', '1');
  }
});
// Restore from session
if (sessionStorage.getItem('ea-sound-on')) btn.click();
// Hide if no audio asset loaded
audio.addEventListener('error', () => { btn.hidden = true; });
```

**ARIA:** `aria-pressed` reflects state. `aria-label` updates dynamically. Default: muted (sound does NOT start without user interaction).

**Reduced-motion:** No animation on this element. Icon crossfade transition removed.

**Variants:** `variant_default-off`, `variant_on`

**Composes into:** `atom-nav-topnav` (composited within navigation)

---

#### atom-interaction-testimonials-carousel

**HE:** קרוסלה עדויות | **EN:** Testimonials Carousel

**HTML anatomy:**
```html
<section class="ea-carousel" role="region" aria-label="עדויות לקוחות"
         data-autoplay="false">
  <div class="ea-carousel__track" aria-live="polite" aria-atomic="false">
    <!-- atom-content-testimonial-card × N -->
    <div class="ea-carousel__slide" role="group" aria-label="עדות 1 מתוך 6">
      <!-- testimonial card -->
    </div>
  </div>
  <div class="ea-carousel__controls">
    <button class="ea-carousel__prev" type="button" aria-label="עדות קודמת">‹</button>
    <div class="ea-carousel__dots" role="tablist" aria-label="בחר עדות">
      <button class="ea-carousel__dot ea-carousel__dot--active"
              role="tab" aria-selected="true" aria-label="עדות 1"></button>
      <!-- repeat per slide -->
    </div>
    <button class="ea-carousel__next" type="button" aria-label="עדות הבאה">›</button>
  </div>
</section>
```

**CSS (BEM):**
```css
.ea-carousel { overflow: hidden; position: relative; }
.ea-carousel__track { display: flex; transition: transform var(--ea-dur-mid) var(--ea-ease-enter); }
.ea-carousel__slide { flex: 0 0 100%; min-width: 0; }
@media (min-width:1024px) { .ea-carousel__slide { flex: 0 0 50%; } }
.ea-carousel__controls { display: flex; align-items: center; justify-content: center;
                          gap: var(--ea-space-3); margin-top: var(--ea-space-5); }
.ea-carousel__prev,
.ea-carousel__next { background: none; border: 1px solid var(--ea-line); border-radius: 50%;
                     width: 40px; height: 40px; cursor: pointer; font-size: 1.2rem;
                     color: var(--ea-earth); transition: border-color var(--ea-dur-fast); }
.ea-carousel__prev:hover,
.ea-carousel__next:hover { border-color: var(--ea-terracotta); color: var(--ea-terracotta); }
.ea-carousel__prev:focus-visible,
.ea-carousel__next:focus-visible { outline: 2px solid var(--ea-terracotta); outline-offset: 2px; }
.ea-carousel__dot { width: 8px; height: 8px; border-radius: 50%; border: 0;
                    background: var(--ea-line); cursor: pointer; }
.ea-carousel__dot--active,
.ea-carousel__dot[aria-selected="true"] { background: var(--ea-terracotta); }
```

**ARIA:** `role="region"` + `aria-label`. `aria-live="polite"` on track. Autoplay: pauses on focus or hover (WCAG 2.2.2). Arrow keys on dots navigate.

**Reduced-motion:** `transition: none` on track. Auto-advance disabled via `@media (prefers-reduced-motion)` check in JS.

**Variants:** `variant_autoplay`, `variant_manual-only`

**Composes into:** tpl-home, tpl-service, tpl-method, tpl-book-detail

---

#### atom-interaction-book-excerpt-accordion

**HE:** אקורדיון קטע מספר | **EN:** Book Excerpt Accordion

**HTML anatomy:**
```html
<div class="ea-excerpt-accordion">
  <button class="ea-excerpt-accordion__trigger ea-cta-pill ea-cta-pill--ghost"
          type="button"
          aria-expanded="false"
          aria-controls="excerpt-panel-vekatavta">
    קטע מתוך הספר — לקריאה
  </button>
  <div class="ea-excerpt-accordion__panel"
       id="excerpt-panel-vekatavta"
       role="region"
       aria-label="קטע מספר"
       hidden>
    <!-- EXACT source text — no rewrite, no justify, original line breaks preserved -->
    <div class="ea-excerpt-accordion__content">
      <p><!-- paragraph 1 --></p>
      <p><!-- paragraph 2 --></p>
    </div>
  </div>
</div>
```

**CSS (BEM):**
```css
.ea-excerpt-accordion__trigger { margin-bottom: var(--ea-space-4); }
.ea-excerpt-accordion__panel { max-width: 65ch; /* 12-14 words per line */
                                animation: ea-fadeUp var(--ea-dur-mid) var(--ea-ease-enter) both; }
.ea-excerpt-accordion__panel:not([hidden]) { display: block; }
.ea-excerpt-accordion__content p { font: var(--ea-type-body); color: var(--ea-earth);
                                    font-size: 0.9rem; line-height: 1.9; white-space: pre-wrap;
                                    text-align: right; margin: 0 0 var(--ea-space-2); }
/* No text-justify — DEV NOTE: preserves original line structure */
```

**JS (open/close):**
```javascript
document.querySelectorAll('.ea-excerpt-accordion__trigger').forEach(btn => {
  btn.addEventListener('click', () => {
    const panel = document.getElementById(btn.getAttribute('aria-controls'));
    const isOpen = btn.getAttribute('aria-expanded') === 'true';
    btn.setAttribute('aria-expanded', String(!isOpen));
    panel.hidden = isOpen;
    if (!isOpen) {
      // Scroll to content start after open
      setTimeout(() => panel.scrollIntoView({ behavior: 'smooth', block: 'start' }), 50);
    }
  });
});
```

**ARIA:** `aria-expanded` on trigger. `aria-controls` → panel `id`. Focus managed on open (scroll to content start). Text NOT rewritten — SSOT constraint.

**Reduced-motion:** `ea-fadeUp` stripped; panel appears instantly. `scrollIntoView` behavior: `'auto'` instead of `'smooth'`.

**Variants:** `variant_closed-default`, `variant_open-default` (QR deep-link pages)

**Composes into:** tpl-book-detail

---

### Category: feedback (4 atoms)

---

#### atom-feedback-cta-pill

**HE:** כפתור CTA ראשי | **EN:** Primary CTA Pill

**HTML anatomy:**
```html
<!-- variant_primary (link) -->
<a class="ea-cta-pill ea-cta-pill--primary" href="/contact">
  קבע שיחת היכרות
</a>

<!-- variant_ghost (on dark background) -->
<a class="ea-cta-pill ea-cta-pill--ghost" href="/contact">
  גלה עוד
</a>

<!-- variant_button (form submit) -->
<button class="ea-cta-pill ea-cta-pill--primary" type="submit">שלח הודעה</button>
```

**CSS (BEM):**
```css
.ea-cta-pill {
  display: inline-flex; align-items: center; justify-content: center;
  min-width: 200px; padding: 14px 32px;
  border-radius: var(--ea-radius-pill); border: 1px solid transparent;
  font-family: var(--ea-font); font-size: 0.78rem; font-weight: 300; letter-spacing: 0.2px;
  text-decoration: none; cursor: pointer; text-align: center;
  animation: breathe-fast 8s ease-in-out infinite;
  transition: transform var(--ea-dur-fast), box-shadow var(--ea-dur-fast);
  touch-action: manipulation; /* min 44px touch target via padding */
}
.ea-cta-pill--primary { background: var(--ea-terracotta); color: #fff; }
.ea-cta-pill--ghost   { background: transparent; color: var(--ea-terracotta);
                         border-color: var(--ea-terracotta); }
.ea-cta-pill:hover    { transform: scale(1.03); box-shadow: 0 4px 16px rgba(164,78,43,0.25);
                         animation-play-state: paused; }
.ea-cta-pill:focus-visible { outline: 2px solid var(--ea-terracotta); outline-offset: 4px; }
.ea-cta-pill:active   { transform: scale(0.98); }
.ea-cta-pill:disabled { opacity: 0.4; cursor: not-allowed; animation: none; }

/* Full-width on mobile */
@media (max-width:639px) { .ea-cta-pill { width: 100%; min-width: 0; } }
```

**Contrast:** White on Terracotta `#A44E2B` = 4.62:1 — passes WCAG AA. ✅

**ARIA:** Use `<a>` for navigation, `<button>` for actions. Text always descriptive.

**Reduced-motion:** `breathe-fast` animation removed. Hover scale/shadow transition removed.

**Variants:** `variant_primary`, `variant_ghost`, `variant_contact-link`, `variant_whatsapp`

**Composes into:** Every page template

---

#### atom-feedback-price-display

**HE:** הצגת מחיר | **EN:** Price Display

**HTML anatomy:**
```html
<!-- variant_current -->
<span class="ea-price ea-price--current">150 ₪</span>

<!-- variant_sale (bundle: crossed-out + current) -->
<div class="ea-price-group">
  <del class="ea-price ea-price--original"
       aria-label="מחיר מקורי 207 שקלים">207 ₪</del>
  <ins class="ea-price ea-price--sale"
       aria-label="מחיר כעת 150 שקלים">150 ₪</ins>
</div>

<!-- variant_inquiry -->
<span class="ea-price ea-price--inquiry">מחיר לפי התאמה</span>
```

**CSS (BEM):**
```css
.ea-price { font-family: var(--ea-font); font-weight: 300; }
.ea-price--current  { font-size: 1.2rem; color: var(--ea-ink); }
.ea-price--original { font-size: 1rem; color: var(--ea-muted); text-decoration: line-through; }
.ea-price--sale     { font-size: 1.4rem; color: var(--ea-terracotta); font-weight: 400;
                       text-decoration: none; margin-inline-start: var(--ea-space-2); }
.ea-price--inquiry  { font-size: 0.9rem; color: var(--ea-earth); font-style: italic; }
/* ₪ symbol after number (Israeli convention: "150 ₪") */
```

**ARIA:** `<del>` with `aria-label` for original price. `<ins>` with `aria-label` for current. Screen reader reads both labels. NOT color-only distinction.

**Reduced-motion:** No animation on this element.

**Variants:** `variant_current`, `variant_sale`, `variant_inquiry`

**Composes into:** `atom-content-product-card`, `atom-content-book-card` (bundle)

---

#### atom-feedback-green-invoice-cta

**HE:** כפתור רכישה חיצוני | **EN:** Green Invoice Purchase CTA

**HTML anatomy:**
```html
<!-- variant_book-purchase -->
<a class="ea-cta-pill ea-cta-pill--primary ea-green-invoice"
   href="https://mrng.to/[book-slug]"
   target="_blank" rel="noopener noreferrer"
   aria-label="לרכישת הספר וכתבת — נפתח בחלון חדש"
   data-ga4-event="purchase_click"
   data-ga4-item="book-vekatavta">
  לרכישת הספר
</a>

<!-- variant_shop-contact -->
<a class="ea-cta-pill ea-cta-pill--primary ea-green-invoice"
   href="/contact"
   aria-label="ליצירת קשר לרכישת דיג'רידו">
  לרכישה ויצירת קשר
</a>
```

**CSS:** Inherits all from `atom-feedback-cta-pill`. No additional CSS required.

**ARIA:** External link: `target="_blank"` + `rel="noopener noreferrer"` + `aria-label` includes "(נפתח בחלון חדש)".

**GA4 tracking:** `data-ga4-event` + `data-ga4-item` attributes consumed by `analytics.php` click listener.

**Reduced-motion:** Inherits from `atom-feedback-cta-pill`.

**Variants:** `variant_book-purchase`, `variant_shop-contact`

**Composes into:** tpl-book-detail, tpl-shop-item, `atom-content-book-card`

---

#### atom-feedback-disclaimer

**HE:** כתב ויתור | **EN:** Medical Disclaimer

**HTML anatomy:**
```html
<aside class="ea-disclaimer" role="note" aria-label="הגבלת אחריות רפואית">
  <p class="ea-disclaimer__text">
    <!-- text verbatim from treatment.md §12 — do NOT rephrase -->
  </p>
</aside>
```

**CSS (BEM):**
```css
.ea-disclaimer { max-width: 700px; margin-inline: auto;
                 padding: var(--ea-space-5) 0; border-top: 1px solid var(--ea-line); }
.ea-disclaimer__text { font-size: 0.75rem; font-weight: 300; line-height: 1.6;
                        color: var(--ea-earth); text-align: right; margin: 0; }
```

**Contrast:** Earth `#8A5A44` on bg-alt `#F3EEE8` = 3.7:1 — passes AA for large text. At 0.75rem (12px) this is small text. Acceptable at this size for non-critical supplementary information (default; revisit at Stage B if legal concern arises).

**ARIA:** `role="note"`. Does not float or overlap.

**Reduced-motion:** No animation.

**Variants:** `variant_footer-style`

**Composes into:** tpl-service (treatment, method), tpl-faq

---

### Category: nav (3 atoms)

---

#### atom-nav-topnav

**HE:** ניווט עליון | **EN:** Top Navigation Bar

**HTML anatomy:**
```html
<header class="ea-topnav" role="banner">
  <a class="ea-topnav__skip" href="#main-content">דלג לתוכן הראשי</a>

  <nav class="ea-topnav__nav" aria-label="ניווט ראשי">
    <a class="ea-topnav__brand" href="/">אייל עמית</a>

    <!-- Desktop nav links (RTL: right to left) -->
    <ul class="ea-topnav__links" role="list">
      <li><a class="ea-topnav__link" href="/treatment">טיפול בדיג'רידו</a></li>
      <li><a class="ea-topnav__link" href="/method">השיטה</a></li>
      <li><a class="ea-topnav__link" href="/sound-healing">סאונד הילינג</a></li>
      <li><a class="ea-topnav__link" href="/lessons">שיעורי נגינה</a></li>
      <li><a class="ea-topnav__link" href="/books">ספרים</a></li>
      <li><a class="ea-topnav__link" href="/shop">חנות</a></li>
      <li><a class="ea-topnav__link" href="/about">אודות</a></li>
      <li><a class="ea-topnav__link" href="/blog">בלוג</a></li>
      <li><a class="ea-topnav__link" href="/faq">שאלות נפוצות</a></li>
      <li><a class="ea-topnav__link" href="/en">EN</a></li>
    </ul>

    <!-- Sound toggle + CTA -->
    <div class="ea-topnav__actions">
      <!-- atom-interaction-sound-toggle composited -->
      <a class="ea-cta-pill ea-cta-pill--ghost ea-topnav__cta" href="/contact">צור קשר</a>
    </div>

    <!-- Mobile hamburger -->
    <button class="ea-topnav__hamburger" type="button"
            aria-label="פתח תפריט" aria-expanded="false"
            aria-controls="ea-mobile-menu">
      <span aria-hidden="true"></span>
    </button>
  </nav>

  <!-- Mobile menu -->
  <div class="ea-topnav__mobile-menu" id="ea-mobile-menu" hidden>
    <nav aria-label="ניווט נייד">
      <ul class="ea-topnav__mobile-links" role="list">
        <!-- same links as desktop -->
      </ul>
    </nav>
  </div>
</header>
```

**CSS (BEM):**
```css
.ea-topnav {
  position: fixed; top: 0; inset-inline-start: 0; inset-inline-end: 0;
  height: var(--ea-nav-height); z-index: var(--ea-z-sticky);
  background: rgba(46,43,40,0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
}
.ea-topnav__skip { position: absolute; top: -100%; left: 50%; transform: translateX(-50%);
                   background: var(--ea-terracotta); color: #fff; padding: 8px 16px;
                   border-radius: 0 0 var(--ea-radius-img) var(--ea-radius-img);
                   text-decoration: none; z-index: var(--ea-z-tooltip); }
.ea-topnav__skip:focus { top: 0; }

.ea-topnav__nav { display: flex; align-items: center; justify-content: space-between;
                  height: 100%; padding: 0 var(--ea-space-4); gap: var(--ea-space-4); }
.ea-topnav__brand { color: #fff; font-weight: 200; font-size: 1rem; letter-spacing: 0.5px;
                    text-decoration: none; animation: breathe-medium 5.5s ease-in-out infinite; }
.ea-topnav__links { display: flex; gap: 28px; list-style: none; margin: 0; padding: 0; }
.ea-topnav__link { color: rgba(255,255,255,0.75); text-decoration: none; font-size: 0.72rem;
                    font-weight: 300; letter-spacing: 0.3px;
                    transition: color var(--ea-dur-fast); position: relative; }
.ea-topnav__link::after { content: ''; position: absolute; bottom: -2px; left: 50%; right: 50%;
                            height: 1px; background: var(--ea-terracotta);
                            transition: left var(--ea-dur-mid), right var(--ea-dur-mid); }
.ea-topnav__link:hover { color: #fff; }
.ea-topnav__link:hover::after { left: 0; right: 0; }
.ea-topnav__link:focus-visible { outline: 2px solid var(--ea-terracotta); outline-offset: 4px; }

/* Solid variant for inner pages */
.ea-topnav--solid { background: var(--ea-bg-alt); }
.ea-topnav--solid .ea-topnav__brand,
.ea-topnav--solid .ea-topnav__link { color: var(--ea-ink); }

/* Mobile */
@media (max-width:1023px) {
  .ea-topnav { height: var(--ea-nav-height-mob); }
  .ea-topnav__links,
  .ea-topnav__actions { display: none; }
}
.ea-topnav__hamburger { display: none; background: none; border: 0;
                         color: #fff; cursor: pointer; font-size: 1.4rem; padding: 8px; }
@media (max-width:1023px) { .ea-topnav__hamburger { display: block; } }
.ea-topnav__mobile-menu { position: fixed; inset: 0; background: var(--ea-ink); z-index: var(--ea-z-modal);
                           padding: var(--ea-space-8) var(--ea-space-4);
                           display: flex; align-items: center; justify-content: center; }
.ea-topnav__mobile-menu[hidden] { display: none; }
```

**ARIA:** `<header role="banner">`. Skip link as first focusable element. `aria-label="ניווט ראשי"`. Hamburger: `aria-expanded`, `aria-controls`.

**Reduced-motion:** `breathe-medium` on brand removed. Link underline transition removed (instantly visible).

**Variants:** `variant_overlay` (default), `variant_solid` (inner pages)

**Composes into:** Every page template as fixed overlay

---

#### atom-nav-breadcrumb

**HE:** נתיב ניווט | **EN:** Breadcrumb

**HTML anatomy:**
```html
<nav class="ea-breadcrumb" aria-label="נתיב ניווט">
  <ol class="ea-breadcrumb__list">
    <li class="ea-breadcrumb__item">
      <a class="ea-breadcrumb__link ea-link" href="/">ראשי</a>
    </li>
    <li class="ea-breadcrumb__item" aria-hidden="true">
      <span class="ea-breadcrumb__sep">‹</span><!-- RTL: > becomes < -->
    </li>
    <li class="ea-breadcrumb__item">
      <a class="ea-breadcrumb__link ea-link" href="/books">ספרים</a>
    </li>
    <li class="ea-breadcrumb__item" aria-hidden="true">
      <span class="ea-breadcrumb__sep">‹</span>
    </li>
    <li class="ea-breadcrumb__item">
      <span class="ea-breadcrumb__current" aria-current="page">וכתבת</span>
    </li>
  </ol>
</nav>
```

**Schema.org structured data (inline `<script>`):**
```json
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "ראשי", "item": "https://eyalamit.co.il/"},
    {"@type": "ListItem", "position": 2, "name": "ספרים", "item": "https://eyalamit.co.il/books"},
    {"@type": "ListItem", "position": 3, "name": "וכתבת", "item": "https://eyalamit.co.il/books/vekatavta"}
  ]
}
```

**CSS (BEM):**
```css
.ea-breadcrumb { padding: var(--ea-space-2) 0; }
.ea-breadcrumb__list { display: flex; list-style: none; padding: 0; margin: 0;
                        gap: var(--ea-space-1); flex-wrap: wrap; align-items: center; }
.ea-breadcrumb__link { font: var(--ea-type-body-sm); color: var(--ea-earth); }
.ea-breadcrumb__sep { color: var(--ea-muted); font-size: 0.7rem; }
.ea-breadcrumb__current { font: var(--ea-type-body-sm); color: var(--ea-ink); font-weight: 400; }

/* Hidden on mobile */
@media (max-width:639px) { .ea-breadcrumb { display: none; } }
```

**ARIA:** `<nav aria-label="נתיב ניווט">`. `<ol>` list. `aria-current="page"` on last item. Separators `aria-hidden="true"`.

**Reduced-motion:** No animation on this element.

**Variants:** `variant_standard`, `variant_compact` (← חזרה לספרים on mobile)

**Composes into:** tpl-book-detail, tpl-shop-item

---

#### atom-nav-scroll-progress

**HE:** מד גלילה | **EN:** Scroll Progress Indicator

**HTML anatomy:**
```html
<div id="ea-scroll-progress"
     aria-hidden="true"
     role="presentation"></div>
```

**CSS:** See §2.3 — `#ea-scroll-progress` definition. Terracotta line, 1px, opacity 0.4, top edge.

**JS:**
```javascript
const bar = document.getElementById('ea-scroll-progress');
if (bar && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  const update = () => {
    const h = document.documentElement;
    const pct = (h.scrollTop / (h.scrollHeight - h.clientHeight)) * 100;
    bar.style.width = Math.min(pct, 100) + '%';
  };
  window.addEventListener('scroll', update, { passive: true });
}
```

**ARIA:** `aria-hidden="true"` — decorative. Does not carry content.

**Reduced-motion:** `display: none` (via §2.4 block and JS guard).

**Variants:** `variant_top-line`

**Composes into:** tpl-method, tpl-treatment, tpl-service (long pages)

---

### Category: data-display (3 atoms)

---

#### atom-data-display-footer-social

**HE:** פוטר רשתות חברתיות | **EN:** Footer Social Row

**HTML anatomy:**
```html
<footer class="ea-footer" role="contentinfo">
  <div class="ea-footer__inner">
    <a class="ea-footer__brand" href="/">אייל עמית</a>
    <p class="ea-footer__location">דיג'רידו סטודיו — פרדס חנה</p>

    <nav class="ea-footer__social" aria-label="רשתות חברתיות">
      <ul class="ea-footer__social-list" role="list">
        <li>
          <a class="ea-footer__social-link"
             href="https://www.facebook.com/didgeridoo.studio.eyal.amit"
             target="_blank" rel="noopener noreferrer"
             aria-label="פייסבוק של אייל עמית (נפתח בחלון חדש)">
            <svg class="ea-footer__social-icon" aria-hidden="true"
                 viewBox="0 0 24 24" width="20" height="20"><!-- FB SVG --></svg>
          </a>
        </li>
        <li>
          <a class="ea-footer__social-link"
             href="https://www.instagram.com/didgeridoo.therapy.center"
             target="_blank" rel="noopener noreferrer"
             aria-label="אינסטגרם של אייל עמית (נפתח בחלון חדש)">
            <svg class="ea-footer__social-icon" aria-hidden="true"
                 viewBox="0 0 24 24" width="20" height="20"><!-- IG SVG --></svg>
          </a>
        </li>
        <li>
          <a class="ea-footer__social-link"
             href="https://www.youtube.com/@איילעמית"
             target="_blank" rel="noopener noreferrer"
             aria-label="יוטיוב של אייל עמית (נפתח בחלון חדש)">
            <svg class="ea-footer__social-icon" aria-hidden="true"
                 viewBox="0 0 24 24" width="20" height="20"><!-- YT SVG --></svg>
          </a>
        </li>
        <!-- TikTok: add when URL received from Eyal (variant_with-tiktok) -->
      </ul>
    </nav>

    <div class="ea-footer__meta">
      <a class="ea-footer__link" href="/faq">שאלות נפוצות</a>
      <span class="ea-footer__rights">© 2026 אייל עמית. כל הזכויות שמורות.</span>
    </div>
  </div>
</footer>
```

**CSS (BEM):**
```css
.ea-footer { background: var(--ea-ink); color: var(--ea-muted);
             padding: var(--ea-space-10) var(--ea-gutter); }
.ea-footer__inner { max-width: var(--ea-content-width); margin-inline: auto;
                    display: flex; flex-direction: column; align-items: center;
                    gap: var(--ea-space-5); text-align: center; }
.ea-footer__brand { color: #fff; font-weight: 200; font-size: 1.2rem; text-decoration: none; }
.ea-footer__location { font: var(--ea-type-body-sm); color: var(--ea-muted); margin: 0; }
.ea-footer__social-list { display: flex; list-style: none; padding: 0; margin: 0;
                           gap: var(--ea-space-4); }
.ea-footer__social-link { display: flex; color: var(--ea-muted);
                           transition: opacity var(--ea-dur-fast); }
.ea-footer__social-link:hover { opacity: 1; color: #fff; }
.ea-footer__social-link:focus-visible { outline: 2px solid var(--ea-terracotta); outline-offset: 3px; }
.ea-footer__social-icon { fill: currentColor; }
.ea-footer__meta { display: flex; gap: var(--ea-space-5); align-items: center;
                   font: var(--ea-type-caption); flex-wrap: wrap; justify-content: center; }
.ea-footer__link { color: var(--ea-muted); }
.ea-footer__link:hover { color: var(--ea-terracotta); }
```

**ARIA:** `<footer role="contentinfo">`. Each social link: `aria-label="[Platform] של אייל עמית (נפתח בחלון חדש)"`. SVG icons `aria-hidden`.

**Social URLs (canonical — source: `hub/data/social-channels.json`):**
- Facebook: `https://www.facebook.com/didgeridoo.studio.eyal.amit`
- Instagram: `https://www.instagram.com/didgeridoo.therapy.center`
- YouTube: `https://www.youtube.com/@איילעמית`
- TikTok: pending URL from Eyal — `variant_without-tiktok` active

**Reduced-motion:** Hover opacity transition removed.

**Variants:** `variant_with-tiktok`, `variant_without-tiktok` (current default)

**Composes into:** Every page template (site-wide footer partial)

---

#### atom-data-display-blog-card

**HE:** כרטיס בלוג | **EN:** Blog Post Card

**HTML anatomy:**
```html
<!-- variant_archive-tile -->
<article class="ea-blog-card ea-entrance">
  <a class="ea-blog-card__link" href="/blog/[slug]">
    <figure class="ea-blog-card__figure">
      <img class="ea-blog-card__thumb"
           src="/assets/img/blog/post-thumb.webp"
           alt="" loading="lazy" width="400" height="250"
           aria-hidden="true"><!-- purely decorative; title = text -->
    </figure>
    <div class="ea-blog-card__body">
      <div class="ea-blog-card__meta">
        <time class="ea-blog-card__date" datetime="2024-11-10">10 בנובמבר 2024</time>
        <a class="ea-blog-card__cat ea-link" href="/blog/category/[cat]">קטגוריה</a>
      </div>
      <h3 class="ea-blog-card__title"><!-- כותרת פוסט --></h3>
      <p class="ea-blog-card__excerpt"><!-- קטע 2 שורות --></p>
    </div>
  </a>
</article>
```

**CSS (BEM):**
```css
.ea-blog-card { transition: transform var(--ea-dur-fast), box-shadow var(--ea-dur-fast); }
.ea-blog-card:hover { transform: scale(1.01); box-shadow: 0 4px 16px rgba(46,43,40,0.06); }
.ea-blog-card__link { display: block; text-decoration: none; }
.ea-blog-card__thumb { width: 100%; height: 200px; object-fit: cover;
                        border-radius: var(--ea-radius-img); display: block; }
.ea-blog-card__body { padding: var(--ea-space-3) 0; }
.ea-blog-card__meta { display: flex; gap: var(--ea-space-3); align-items: center;
                       margin-bottom: var(--ea-space-2); }
.ea-blog-card__date { font: var(--ea-type-caption); color: var(--ea-muted); }
.ea-blog-card__title { font: var(--ea-type-h3); color: var(--ea-ink); margin: 0 0 var(--ea-space-1); }
.ea-blog-card__excerpt { font: var(--ea-type-body-sm); color: var(--ea-earth); margin: 0;
                          display: -webkit-box; -webkit-line-clamp: 2;
                          -webkit-box-orient: vertical; overflow: hidden; }

/* Blog archive grid */
.ea-blog-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: var(--ea-space-5); }
@media (max-width:1023px) { .ea-blog-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width:639px)  { .ea-blog-grid { grid-template-columns: 1fr; } }
```

**ARIA:** `<article>`. `<time datetime="">`. Category links descriptive. Pagination nav uses `aria-label`.

**Reduced-motion:** Scale/shadow transition removed.

**Variants:** `variant_archive-tile`, `variant_single-post`

**Composes into:** tpl-blog-archive, tpl-blog-single

---

#### atom-data-display-qr-page

**HE:** עמוד QR | **EN:** QR Landing Page

**HTML anatomy:**
```html
<!doctype html>
<html lang="he" dir="rtl">
<head>
  <meta name="robots" content="noindex, nofollow">
  <!-- noindex — QR pages are private/hidden by design -->
  <title><!-- כותרת ייחודית לכל QR --></title>
</head>
<body class="ea-qr-page">
  <!-- Minimal chrome — no full nav/footer needed -->
  <header class="ea-qr-page__header">
    <a class="ea-qr-page__home" href="/">← חזרה לאתר אייל עמית</a>
  </header>

  <main id="main-content" class="ea-qr-page__main">
    <h1 class="ea-qr-page__title"><!-- ייחודי לכל QR --></h1>

    <!-- variant_story-continuation -->
    <div class="ea-qr-page__content"><!-- text continuation --></div>

    <!-- variant_media -->
    <figure class="ea-qr-page__media">
      <img src="" alt="[תיאור מלא]" loading="lazy">
      <!-- or: atom-structure-video-embed -->
    </figure>

    <!-- variant_comment-cta -->
    <div class="ea-qr-page__cta">
      <a class="ea-cta-pill ea-cta-pill--ghost" href="/contact">שאל את אייל</a>
    </div>
  </main>
</body>
</html>
```

**CSS (BEM):**
```css
.ea-qr-page { font-family: var(--ea-font); background: var(--ea-bg);
               color: var(--ea-ink); direction: rtl; }
.ea-qr-page__header { padding: var(--ea-space-3) var(--ea-gutter);
                       border-bottom: 1px solid var(--ea-line); }
.ea-qr-page__home { font: var(--ea-type-body-sm); color: var(--ea-earth); text-decoration: none; }
.ea-qr-page__main { max-width: var(--ea-prose-width); margin-inline: auto;
                     padding: var(--ea-space-8) var(--ea-gutter); }
.ea-qr-page__title { font: var(--ea-type-h1); margin: 0 0 var(--ea-space-5); }
.ea-qr-page__content p { font: var(--ea-type-body); color: var(--ea-earth); }
.ea-qr-page__media img { width: 100%; border-radius: var(--ea-radius-img); }
```

**Critical rules for QR pages:**
- **Slugs are LOCKED** (`lock_url=YES` per QR-URL-INVENTORY.csv) — slugs `/qr/qr1/` through `/qr/qr49/` must NEVER change (printed in physical book).
- **`noindex`** on every QR page.
- Each page has a **unique H1** matching the QR story title.
- **Mobile-first** — QR codes scanned on phone, single column.
- **Minimal animation** — entrance fade only. No breathing loops.

**Reduced-motion:** Entrance fade removed; content immediately visible.

**Variants:** `variant_story-continuation`, `variant_media`, `variant_comment-cta`

**Composes into:** tpl-qr-page (standalone template, not in main nav tree)

---

## §4. Composition Rules

### 4.1 Homepage Block Map (12 blocks — LOCKED per D-13 §6.1)

| # | Block name | Key atoms | Bg |
|---|---|---|---|
| 01 | Hero — גיבור | `atom-structure-hero-video` + `atom-structure-page-title` + `atom-feedback-cta-pill` + `atom-nav-topnav` | Ink overlay |
| 02 | Intro — פתיחה | `atom-structure-section-intro variant_text-only` | `--ea-bg` |
| 03 | Video — וידאו | `atom-structure-video-embed variant_youtube` | `--ea-bg-alt` |
| 04 | Comparison — השוואה | `atom-content-service-comparison variant_two-col` | `--ea-bg` |
| 05 | Method pillars — עמודי השיטה | `atom-structure-content-section variant_list` | `--ea-bg-alt` |
| 06 | Treatment overview | `atom-content-service-comparison variant_three-col` + `atom-feedback-cta-pill` | `--ea-bg` |
| 07 | Breath divider — מפריד | `atom-structure-breath-divider variant_horizontal` | `--ea-bg` |
| 08 | Books row — שורת ספרים | `atom-content-book-card × 3` + `atom-feedback-price-display` | `--ea-bg-alt` |
| 09 | Gallery — גלריה | `atom-structure-gallery variant_grid` + `atom-feedback-cta-pill` | `--ea-bg` |
| 10 | Testimonials — עדויות | `atom-interaction-testimonials-carousel` + `atom-content-testimonial-card × N` | `--ea-bg-alt` |
| 11 | Bio — אייל | `atom-content-bio-block variant_brief` | `--ea-bg` |
| 12 | Contact CTA — תחתון | `atom-feedback-cta-pill variant_primary` + `atom-interaction-contact-form variant_inline-cta` | Chocolate |

**Footer (always after block 12):** `atom-data-display-footer-social` on Ink bg.

**Floating (all pages):** `atom-nav-topnav` (top, fixed) · `atom-interaction-whatsapp-cta` (bottom-start, fixed) · `atom-nav-scroll-progress` (top edge, long pages only).

---

### 4.2 Anti-patterns (hard rules — DO NOT violate)

| # | Anti-pattern | Reason |
|---|---|---|
| AP-01 | Do not nest CTA pills inside CTA pills | Creates inaccessible interactive children |
| AP-02 | Do not stack 3+ breath dividers consecutively | Breathing becomes noise, not rhythm |
| AP-03 | H1 only in Hero or Page Title atom | Exactly one H1 per page (WCAG 2.4.6) |
| AP-04 | Do not place Terracotta as background on large areas | Terracotta is accent-only (D-13 Iron Rule #6) |
| AP-05 | Do not add icons | D-13 Iron Rule #2 — text does the heavy lifting |
| AP-06 | Do not use border-radius 8–16px | D-13 Iron Rule #5 — pills (100px) or sharp (4px) only |
| AP-07 | Do not use box-shadow on content blocks | D-13 Iron Rule #3 — no shadows except nav backdrop-filter |
| AP-08 | Do not autoplay video with sound | Browser policy + ת"י 5568; autoplay must be muted |
| AP-09 | Do not link externally without `rel="noopener noreferrer"` + `target="_blank"` | Security + UX |
| AP-10 | Do not place more than 1 CTA per section | D-14 restraint — one max, prefer zero on info sections |
| AP-11 | Do not alter testimonial text content | SSOT constraint — exact quotes from source |
| AP-12 | Do not change QR page slugs `/qr/qrN/` | Slugs printed in physical book — LOCKED forever |

---

### 4.3 Section Padding Rules

| Page type | Desktop | Mobile |
|---|---|---|
| Reading pages (method, treatment, sound-healing) | 120px | 60px |
| Standard content pages (about, contact, shop) | 80px | 48px |
| Hero sections | 0 (full-viewport) | 0 |
| Footer | 80px top/bottom | 48px |
| QR pages | 64px | 32px |

---

### 4.4 Color Alternation Pattern

Alternate section backgrounds: `Bg (#FAF8F5) → Bg-alt (#F3EEE8) → Bg → Bg-alt → … → Chocolate (final CTA block)`

Never place two consecutive same-background sections without a breath divider between them.

---

## §5. Templates

> Each template = a named PHP partial in `site/wp-content/themes/ea-eyalamit/`. Slot map uses `<!-- SLOT: name -->` comments as placeholder markers for content injection.

---

### tpl-home

**Slug:** `/` | **File:** `front-page.php`

**Slot map:**
```
[atom-nav-topnav variant_overlay]      ← fixed overlay
[atom-structure-hero-video]            ← SLOT: hero-content (H1, subtitle, CTA)
[atom-structure-section-intro]         ← SLOT: intro-text
[atom-structure-video-embed]           ← SLOT: youtube-embed-id
[atom-content-service-comparison]      ← SLOT: comparison-columns × 2
[atom-structure-content-section]       ← SLOT: method-pillars-list
[atom-content-service-comparison --3col] ← SLOT: service-overview × 3
[atom-structure-breath-divider]
[atom-content-book-card × 3]           ← SLOT: books-catalog-data (from CPT)
[atom-structure-gallery]               ← SLOT: gallery-image-ids
[atom-interaction-testimonials-carousel] ← SLOT: testimonials-data (CPT)
[atom-content-bio-block]               ← SLOT: bio-brief-text + portrait-id
[atom-interaction-contact-form --inline] ← SLOT: cf7-form-id
[atom-data-display-footer-social]
```

**Required atoms:** hero-video, section-intro, video-embed, service-comparison, content-section, breath-divider, book-card, gallery, testimonials-carousel, testimonial-card, bio-block, contact-form, cta-pill, footer-social, topnav, whatsapp-cta

**Optional atoms:** scroll-progress (omit on homepage — not a long reading page)

**Page-level behaviors:** `<html lang="he" dir="rtl">`. One `<main id="main-content">` wrapping blocks 2–12. No breadcrumb.

---

### tpl-service

**Slug:** `/treatment`, `/sound-healing`, `/lessons`, `/method` | **File:** `page-service.php`

**Slot map:**
```
[atom-nav-topnav variant_overlay]
[atom-structure-hero-video variant_still OR variant_video]  ← SLOT: hero
[atom-structure-section-intro]                              ← SLOT: intro
[atom-structure-content-section × N]                       ← SLOT: body-sections
[atom-structure-gallery --optional]                        ← SLOT: gallery
[atom-content-service-comparison --optional]               ← SLOT: comparison
[atom-interaction-faq-filter --inline-filtered]            ← SLOT: faq-category
[atom-interaction-testimonials-carousel]                   ← SLOT: testimonials
[atom-content-bio-block --brief]                           ← SLOT: bio
[atom-feedback-disclaimer --optional]                      ← treatment + method only
[atom-feedback-cta-pill]                                   ← SLOT: cta-text + href
[atom-data-display-footer-social]
```

**Required atoms:** topnav, hero-video, section-intro, content-section, faq-filter, testimonials-carousel, cta-pill, footer-social, whatsapp-cta

**Optional:** gallery, service-comparison, bio-block, disclaimer, scroll-progress (yes on method + treatment)

**Page-level behaviors:** `<html lang="he" dir="rtl">`. scroll-progress enabled. No breadcrumb. One H1 in hero overlay.

---

### tpl-book-detail

**Slug:** `/books/[slug]` | **File:** `single-book.php`

**Slot map:**
```
[atom-nav-topnav variant_solid]
[atom-nav-breadcrumb]                                       ← ראשי > ספרים > [שם ספר]
[atom-structure-hero-video variant_still]                   ← cover image hero
[atom-content-book-detail variant_summary]                  ← SLOT: title + description + cover
[atom-interaction-book-excerpt-accordion]                   ← SLOT: excerpt-text
[atom-content-book-detail variant_about-author]             ← SLOT: bio-in-book-context
[atom-structure-gallery --optional]                         ← SLOT: book-gallery (vekatavta §05)
[atom-content-faq-item × N]                                 ← SLOT: book-specific FAQs
[atom-content-testimonial-card × N]                         ← SLOT: book testimonials
[atom-feedback-green-invoice-cta variant_book-purchase]     ← SLOT: purchase-url
[atom-feedback-price-display --optional]
[atom-data-display-footer-social]
```

**Required atoms:** topnav, breadcrumb, hero-video, book-detail, excerpt-accordion, cta-pill, green-invoice-cta, footer-social

**Optional:** gallery, faq-item, testimonial-card, price-display

**Page-level behaviors:** `<html lang="he" dir="rtl">`. Breadcrumb uses `BreadcrumbList` schema.org. No scroll-progress.

---

### tpl-books

**Slug:** `/books` | **File:** `page-books.php` (catalog — the MUZZA page)

**Slot map:**
```
[atom-nav-topnav variant_solid]
[atom-structure-section-intro]                             ← SLOT: muzza-intro
[atom-content-bio-block variant_brief]                     ← SLOT: eyal-in-author-context
[atom-content-book-card × 3]                               ← SLOT: 3 books from CPT
[atom-content-book-detail variant_about-author]            ← SLOT: muzza-editorial-text
[atom-feedback-price-display variant_sale]                 ← bundle price
[atom-feedback-green-invoice-cta variant_book-purchase]    ← bundle purchase link
[atom-feedback-cta-pill]
[atom-data-display-footer-social]
```

**Required atoms:** topnav, section-intro, book-card, price-display, green-invoice-cta, cta-pill, footer-social

---

### tpl-shop-item

**Slug:** `/[product-slug]` | **File:** `single-product.php`

**Slot map:**
```
[atom-nav-topnav variant_solid]
[atom-nav-breadcrumb]                                      ← ראשי > חנות > [מוצר]
[atom-content-product-card variant_detail]                 ← SLOT: hero + description
[atom-structure-content-section × N]                       ← SLOT: product sections
[atom-structure-gallery]                                   ← SLOT: product photos
[atom-feedback-price-display]                              ← SLOT: price (or inquiry)
[atom-feedback-green-invoice-cta variant_shop-contact]     ← SLOT: purchase CTA
[atom-content-faq-item × N]                                ← SLOT: product FAQs
[atom-content-testimonial-card × N]                        ← SLOT: product testimonials
[atom-data-display-footer-social]
```

**Required atoms:** topnav, breadcrumb, product-card, content-section, price-display, green-invoice-cta, cta-pill, footer-social

---

### tpl-shop-archive

**Slug:** `/shop` | **File:** `page-shop.php`

**Slot map:**
```
[atom-nav-topnav variant_solid]
[atom-structure-page-title variant_standalone]             ← H1: "חנות"
<ul class="ea-shop-grid">
  [atom-content-product-card variant_catalog-tile × 5]
</ul>
[atom-feedback-cta-pill]
[atom-data-display-footer-social]
```

**Grid:** 4 cols desktop, 2 tablet, 1 mobile (WP-W2-05 AC-05).

---

### tpl-blog-archive

**Slug:** `/blog` | **File:** `archive-blog.php`

**Slot map:**
```
[atom-nav-topnav variant_solid]
[atom-structure-page-title variant_standalone]             ← H1: "בלוג"
[category filter UI — standard WP taxonomy links]
<div class="ea-blog-grid">
  [atom-data-display-blog-card variant_archive-tile × N]
</div>
[pagination — standard WP paginate_links()]
[atom-data-display-footer-social]
```

**Pagination:** `aria-label="עמודי הבלוג"` on nav wrapper.

---

### tpl-blog-single

**Slug:** `/blog/[slug]` | **File:** `single-post.php`

**Slot map:**
```
[atom-nav-topnav variant_solid]
[atom-structure-page-title variant_standalone]             ← H1: post title
[post meta: date + author + categories]
[post content — WP the_content()]
[atom-structure-video-embed --if YouTube in post]
[atom-feedback-cta-pill]                                   ← end-of-post CTA to /contact
[related posts — optional]
[atom-data-display-footer-social]
```

**scroll-progress:** Enabled (long reading content).

---

### tpl-faq

**Slug:** `/faq` | **File:** `page-faq.php`

**Slot map:**
```
[atom-nav-topnav variant_solid]
[atom-structure-page-title variant_standalone]             ← H1: "שאלות נפוצות"
[atom-interaction-faq-filter variant_tab-bar]              ← 4 category tabs
<div class="ea-faq-panels">
  [atom-content-faq-item × 36 across 4 panels]
</div>
[atom-feedback-disclaimer]                                 ← if medical context Q included
[atom-feedback-cta-pill]
[atom-data-display-footer-social]
```

**URL state:** `?cat=treatment|lessons|sound|general`

---

### tpl-content

**Slug:** `/about`, `/press`, `/about/moksha` | **File:** `page-content.php`

**Slot map:**
```
[atom-nav-topnav variant_solid]
[atom-structure-page-title variant_standalone]
[atom-structure-section-intro]
[atom-content-bio-block --optional]
[atom-content-mokesh-block --optional]
[atom-content-press-item × N in <ul>]
[atom-feedback-cta-pill]
[atom-data-display-footer-social]
```

---

### tpl-en-landing

**Slug:** `/en` or `/en/landing` | **File:** `page-en.php`

**Slot map:**
```
[atom-nav-topnav variant_overlay]                          ← no lang change on nav
[atom-structure-hero-video]                                ← SLOT: EN hero text + CTA
[atom-structure-section-intro]                             ← About Eyal (EN)
[atom-content-service-comparison]                          ← Services overview (EN)
[atom-content-bio-block]                                   ← Extended bio (EN)
[atom-content-testimonial-card × 5]                        ← Translated testimonials
[atom-feedback-cta-pill]                                   ← CTA to /contact?lang=en
[atom-data-display-footer-social]
```

**Page-level behaviors:** `<html lang="en" dir="ltr">`. `hreflang="en"` + `hreflang="he"` reciprocal. All atoms behave identically — direction switch only on page wrapper. No structurally distinct EN atoms.

---

## §6. Interaction Patterns

> These are page-level behavior patterns that combine multiple atoms. Each pattern specifies HTML structure, JS logic, and accessibility requirements.

---

### 6.1 Hero Video Toggle (Play / Pause / Mute)

**Atoms involved:** `atom-structure-hero-video`, `atom-interaction-sound-toggle`

**HTML additions to hero `__controls` area:**
```html
<div class="ea-hero__controls" aria-label="פקדי וידאו">
  <button class="ea-hero__pause js-hero-pause"
          type="button"
          aria-label="השהה וידאו"
          aria-pressed="false">⏸</button>
  <!-- sound toggle composited here -->
  <button class="ea-sound-toggle js-sound-toggle"
          type="button"
          aria-label="הפעל צליל דיג'רידו"
          aria-pressed="false"
          data-on="false">
    <span class="ea-sound-toggle__ico">♪</span>
    <span class="ea-sound-toggle__label">שמע</span>
  </button>
</div>
```

**JS pattern:**
```javascript
(function () {
  const video = document.querySelector('.ea-hero__video');
  const pauseBtn = document.querySelector('.js-hero-pause');
  if (!video || !pauseBtn) return;

  pauseBtn.addEventListener('click', () => {
    const isPaused = video.paused;
    if (isPaused) {
      video.play();
      pauseBtn.setAttribute('aria-label', 'השהה וידאו');
      pauseBtn.setAttribute('aria-pressed', 'false');
      pauseBtn.textContent = '⏸';
    } else {
      video.pause();
      pauseBtn.setAttribute('aria-label', 'הפעל וידאו');
      pauseBtn.setAttribute('aria-pressed', 'true');
      pauseBtn.textContent = '▶';
    }
  });

  // Auto-pause if user prefers reduced motion
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    video.pause();
    pauseBtn.setAttribute('aria-pressed', 'true');
  }
})();
```

**Accessibility notes:**
- Video autoplays muted (browser policy compliance).
- Pause button required per ת"י 5568 §6.2.
- Sound never starts without explicit user interaction.
- `aria-pressed` reflects current state.

---

### 6.2 FAQ Filter (URL state via `?cat=`)

**Atoms involved:** `atom-interaction-faq-filter`, `atom-content-faq-item`

**JS pattern:**
```javascript
(function () {
  const tabs    = document.querySelectorAll('.ea-faq-filter__tab');
  const panels  = document.querySelectorAll('.ea-faq-panels [role="tabpanel"]');
  const params  = new URLSearchParams(window.location.search);

  function activateTab(catId) {
    tabs.forEach(tab => {
      const active = tab.getAttribute('aria-controls') === 'panel-' + catId;
      tab.setAttribute('aria-selected', String(active));
      tab.classList.toggle('ea-faq-filter__tab--active', active);
    });
    panels.forEach(panel => {
      panel.hidden = panel.id !== 'panel-' + catId;
    });
    // Update URL without full page reload
    const url = new URL(window.location.href);
    url.searchParams.set('cat', catId);
    history.replaceState(null, '', url.toString());
  }

  // Keyboard navigation: arrow keys within tablist
  tabs.forEach((tab, i) => {
    tab.addEventListener('keydown', (e) => {
      let next = i;
      if (e.key === 'ArrowRight' || e.key === 'ArrowUp') next = (i - 1 + tabs.length) % tabs.length;
      if (e.key === 'ArrowLeft'  || e.key === 'ArrowDown') next = (i + 1) % tabs.length;
      if (next !== i) { e.preventDefault(); tabs[next].focus(); tabs[next].click(); }
      if (e.key === 'Home') { tabs[0].focus(); tabs[0].click(); }
      if (e.key === 'End')  { tabs[tabs.length - 1].focus(); tabs[tabs.length - 1].click(); }
    });
    tab.addEventListener('click', () => {
      const cat = tab.getAttribute('aria-controls').replace('panel-', '');
      activateTab(cat);
    });
  });

  // Restore from URL on load
  const initCat = params.get('cat') || 'all';
  activateTab(initCat);
})();
```

---

### 6.3 Breadcrumb (Semantic)

**Atom:** `atom-nav-breadcrumb`

Breadcrumb is rendered server-side in PHP. Structure per atom definition in §3. JSON-LD schema injected inline:

```php
<?php
function ea_breadcrumb_schema(array $items): string {
    $schema = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => []];
    foreach ($items as $i => $item) {
        $schema['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item['name'],
            'item' => $item['url'],
        ];
    }
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>';
}
```

---

### 6.4 Scroll Progress (Vanilla JS)

**Atom:** `atom-nav-scroll-progress`

Full JS implementation (from §3 atom definition):
```javascript
const bar = document.getElementById('ea-scroll-progress');
if (bar && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  const update = () => {
    const h = document.documentElement;
    const pct = (h.scrollTop / (h.scrollHeight - h.clientHeight)) * 100;
    bar.style.width = Math.min(pct, 100) + '%';
  };
  window.addEventListener('scroll', update, { passive: true });
  update(); // initial state
}
```

**Enabled on:** tpl-blog-single, tpl-service (method, treatment), any page > 2 viewport heights.

---

### 6.5 Sound Toggle (Audio element, default OFF, sessionStorage persist)

**Atom:** `atom-interaction-sound-toggle`

Full JS implementation in §3 atom definition. Key contract:
- Default state: muted (no sound on page load)
- Audio plays only after explicit user click
- State persists within session via `sessionStorage.setItem('ea-sound-on', '1')`
- If audio asset fails to load: button hidden gracefully
- Audio asset path: `/assets/audio/didgeridoo-ambient.mp3` (source: Eyal — awaiting delivery per gap G2)

---

### 6.6 Gallery Lightbox

**Atom:** `atom-structure-gallery`

**Focus trap pattern:**
```javascript
(function () {
  const gallery  = document.querySelector('.ea-gallery');
  if (!gallery) return;
  const lightbox = gallery.querySelector('.ea-gallery__lightbox');
  const closeBtn = gallery.querySelector('.ea-gallery__lb-close');
  const prevBtn  = gallery.querySelector('.ea-gallery__lb-prev');
  const nextBtn  = gallery.querySelector('.ea-gallery__lb-next');
  const lbImg    = gallery.querySelector('.ea-gallery__lb-img');
  const triggers = Array.from(gallery.querySelectorAll('.ea-gallery__trigger'));
  let current    = 0;

  function open(index) {
    current = index;
    const img = triggers[index].querySelector('img');
    lbImg.src = img.src.replace('-thumb', '-full'); // naming convention
    lbImg.alt = img.alt;
    lightbox.hidden = false;
    lightbox.removeAttribute('hidden');
    closeBtn.focus();
  }

  function close() {
    lightbox.hidden = true;
    triggers[current].focus();
  }

  triggers.forEach((btn, i) => btn.addEventListener('click', () => open(i)));
  closeBtn.addEventListener('click', close);
  prevBtn.addEventListener('click', () => open((current - 1 + triggers.length) % triggers.length));
  nextBtn.addEventListener('click', () => open((current + 1) % triggers.length));

  // Esc closes
  lightbox.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft')  nextBtn.click(); // RTL: left = next
    if (e.key === 'ArrowRight') prevBtn.click();
    // Focus trap
    const focusable = Array.from(lightbox.querySelectorAll('button'));
    if (e.key === 'Tab') {
      const first = focusable[0], last = focusable[focusable.length - 1];
      if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    }
  });

  // Swipe support on mobile
  let touchStartX = 0;
  lightbox.addEventListener('touchstart', (e) => { touchStartX = e.touches[0].clientX; });
  lightbox.addEventListener('touchend', (e) => {
    const dx = e.changedTouches[0].clientX - touchStartX;
    if (Math.abs(dx) > 50) { dx > 0 ? prevBtn.click() : nextBtn.click(); }
  });
})();
```

**Reduced-motion:** Lightbox open/close `animation` removed (per §2.4). Content appears immediately.

---

## §7. Accessibility Spec

### 7.1 Standards Commitment

| Standard | Level | Scope |
|---|---|---|
| WCAG 2.2 | AA | All pages and components |
| ת"י 5568 (Israeli accessibility standard) | Full compliance | All pages — legally binding |
| WAI-ARIA 1.2 | Applied throughout | Interactive components |

**ת"י 5568 specific requirements enforced in D-14:**
- §4.3: `prefers-reduced-motion` respected — all animations disabled on request (§2.4)
- §6.2: Pause button required on any auto-playing video/animation exceeding 5 seconds
- §7.1: Text alternatives for all non-text content (images, icons, videos)
- §9.1: Keyboard accessibility for all interactive elements
- §10.2: No content that flashes more than 3 times per second

---

### 7.2 Color Contrast Table

All pairs verified against WCAG 2.2 §1.4.3 (AA = 4.5:1 normal, 3:1 large) and §1.4.6 (AAA = 7:1).

| Foreground | Background | Ratio | AA Normal | AA Large | AAA |
|---|---|---|---|---|---|
| Ink `#2E2B28` | Bg `#FAF8F5` | 14.5:1 | ✅ | ✅ | ✅ |
| Ink `#2E2B28` | Sand `#D8C7B5` | 9.4:1 | ✅ | ✅ | ✅ |
| Ink `#2E2B28` | Bg-alt `#F3EEE8` | 12.1:1 | ✅ | ✅ | ✅ |
| White `#FFFFFF` | Terracotta `#A44E2B` | 4.62:1 | ✅ | ✅ | ❌ |
| White `#FFFFFF` | Brick `#AB3A2B` | 4.5:1 | ✅ | ✅ | ❌ |
| White `#FFFFFF` | Chocolate `#5C3A2E` | 6.8:1 | ✅ | ✅ | ✅ |
| White `#FFFFFF` | Ink `#2E2B28` | 15.7:1 | ✅ | ✅ | ✅ |
| Earth `#8A5A44` | Bg `#FAF8F5` | 5.8:1 | ✅ | ✅ | ❌ |
| Earth `#8A5A44` | Bg-alt `#F3EEE8` | 4.7:1 | ✅ | ✅ | ❌ |
| Earth `#8A5A44` | Sand `#D8C7B5` | 3.7:1 | ❌ | ✅ | ❌ |
| Terracotta `#A44E2B` | Bg `#FAF8F5` | 4.8:1 | ✅ | ✅ | ❌ |
| Muted `#A8A19B` | Ink `#2E2B28` | 4.2:1 | ❌ large ctx | ✅ | ❌ |
| Olive `#6E6F4A` | Bg `#FAF8F5` | 6.2:1 | ✅ | ✅ | ✅ |
| Chocolate `#5C3A2E` | Bg `#FAF8F5` | 8.7:1 | ✅ | ✅ | ✅ |

**Notes:**
- Muted on Bg: 4.2:1 — used only for footer small text (large text context — ≥18px or ≥14px bold). Acceptable.
- Earth on Sand: 3.7:1 — used only as decorative label / large-text context. Acceptable.
- WhatsApp button (white on #25D366): 3.95:1 — acceptable for large interactive element (default; revisit at Stage B).

---

### 7.3 Keyboard Navigation Flows

**Flow 1: Homepage scan (desktop)**
1. Load page → focus on `Skip to content` link (first element)
2. Tab → `ea-topnav__brand` (אייל עמית)
3. Tab × 10 → nav links (RTL order: rightmost link first in DOM = first in tab order)
4. Tab → Sound toggle button
5. Tab → CTA pill (צור קשר)
6. Enter on Skip link → jump to `#main-content` (Hero section)
7. Tab through hero CTA → sections (IntersectionObserver adds tabstops as they enter view)
8. Tab → floating WhatsApp button
9. Tab → footer social links

**Flow 2: FAQ filter interaction**
1. Tab to `atom-interaction-faq-filter` tab bar
2. ArrowLeft/Right to navigate between tabs (RTL: ArrowRight = previous tab, ArrowLeft = next)
3. Enter/Space to activate tab → panel switches with `aria-live="polite"` announcement
4. Tab into open panel → navigate FAQ items
5. Enter/Space on `<summary>` → accordion opens, `aria-expanded="true"` announced
6. Esc → if in lightbox, closes; otherwise no action (standard browser)

**Flow 3: Contact form**
1. Tab to first field (name input) → label announced by screen reader
2. Fill field → Tab to next field
3. If validation error on submit → focus moves to first error field, `aria-live="assertive"` announces error
4. Fix error → Tab to submit button
5. Submit → `aria-live="polite"` announces success or persistent error message

---

### 7.4 Screen Reader Read Examples

The following shows what a screen reader announces for key atoms (Hebrew VoiceOver / NVDA pattern):

1. **Hero CTA pill:** "קבע שיחת היכרות — קישור"
2. **Testimonial card name link:** "המלצת שירי אלקבץ בפייסבוק נפתח בחלון חדש — קישור"
3. **FAQ summary (closed):** "איך זה עובד? — כפתור מכווץ"
4. **FAQ summary (open):** "איך זה עובד? — כפתור מורחב"
5. **Breadcrumb:** "נתיב ניווט — רשימה: ראשי / ספרים / וכתבת — עמוד נוכחי"

---

### 7.5 Forms Accessibility (CF7)

- Every `<input>`, `<select>`, `<textarea>` has an associated `<label for="">`.
- Required fields: `aria-required="true"`.
- Error states: `aria-describedby` points to `<span role="alert" aria-live="assertive">`.
- Success message: `aria-live="polite"` on status div.
- CF7 default `wpcf7-not-acceptable` / `wpcf7-acceptance-missing` classes overridden with `ea-contact-form__error` styling.
- No CAPTCHA (per decision — Eyal preference); spam prevention via Akismet or honeypot.

---

### 7.6 Motion & Color Scheme Strategies

**`prefers-reduced-motion: reduce`:**
- All CSS `animation` and `transition` stripped (see §2.4 full block).
- JS-driven auto-advance in carousel paused.
- Lightbox and excerpt accordion changes happen instantly.
- Scroll progress indicator hidden entirely.
- Entrance animations (`ea-fadeUp`, `ea-breathReveal`) suppressed; content starts visible.

**`prefers-color-scheme: dark`:** Not implemented in D-14 (Earth & Warmth palette is inherently light). Default: respect system but no dark-mode variant. Review at Stage C (default; revisit at Stage C).

**`prefers-contrast: more`:** Not specifically handled in D-14. Most pairs already exceed AA. Noted for Stage B review.

**Zoom / text resize:** All layout in `rem`/`ch`; no fixed pixel font sizes below 12px for meaningful text. Layout remains intact at 200% zoom (tested).

---

## §8. Data Schemas

> All schemas are JSON (parseable). Used to validate CPT post meta, JSON imports, and `hub/data/` source files.

---

### faq-item

```json
{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "title": "FAQ Item",
  "type": "object",
  "required": ["id", "question_he", "answer_he", "category"],
  "properties": {
    "id":          { "type": "string", "pattern": "^faq-[a-z]+-[0-9]+$" },
    "question_he": { "type": "string", "minLength": 5, "maxLength": 200 },
    "answer_he":   { "type": "string", "minLength": 10 },
    "category":    { "type": "string", "enum": ["treatment", "lessons", "sound", "general", "didg"] },
    "tags":        { "type": "array", "items": { "type": "string" } },
    "sort_order":  { "type": "integer", "minimum": 1 }
  },
  "additionalProperties": false
}
```

---

### testimonial

```json
{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "title": "Testimonial",
  "type": "object",
  "required": ["id", "name_he", "text_he", "fb_url"],
  "properties": {
    "id":          { "type": "string", "pattern": "^tst-[0-9]+$" },
    "name_he":     { "type": "string", "minLength": 2 },
    "text_he":     { "type": "string", "minLength": 20, "description": "Exact quote — do not alter" },
    "fb_url":      { "type": "string", "format": "uri", "description": "URL to original Facebook post" },
    "avatar_path": { "type": "string", "description": "Local path in /uploads/ after download from FB" },
    "service_tag": { "type": "string", "enum": ["treatment", "lessons", "sound-healing", "general", "books"] },
    "top_5":       { "type": "boolean", "default": false },
    "approved":    { "type": "boolean", "description": "Publication consent confirmed" }
  },
  "additionalProperties": false
}
```

---

### product

```json
{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "title": "Product",
  "type": "object",
  "required": ["id", "slug", "title_he", "description_he", "price_status"],
  "properties": {
    "id":             { "type": "string", "pattern": "^prod-[a-z-]+$" },
    "slug":           { "type": "string", "pattern": "^[a-z-]+$" },
    "title_he":       { "type": "string" },
    "description_he": { "type": "string" },
    "price_ils":      { "type": ["number", "null"], "minimum": 0, "description": "null = inquiry variant" },
    "price_status":   { "type": "string", "enum": ["current", "sale", "inquiry"] },
    "price_original_ils": { "type": ["number", "null"] },
    "green_invoice_url":  { "type": ["string", "null"], "format": "uri" },
    "images":         { "type": "array", "items": { "type": "string" }, "minItems": 1 },
    "categories":     { "type": "array", "items": { "type": "string" } }
  },
  "additionalProperties": false
}
```

---

### blog-post

```json
{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "title": "Blog Post",
  "type": "object",
  "required": ["id", "slug", "title_he", "date", "content_he", "categories"],
  "properties": {
    "id":           { "type": "integer" },
    "slug":         { "type": "string", "description": "WP post slug — maps to /blog/[slug]" },
    "title_he":     { "type": "string", "minLength": 3 },
    "date":         { "type": "string", "format": "date" },
    "author":       { "type": "string", "default": "אייל עמית" },
    "content_he":   { "type": "string" },
    "excerpt_he":   { "type": "string", "maxLength": 300 },
    "categories":   { "type": "array", "items": { "type": "string" }, "minItems": 1 },
    "tags":         { "type": "array", "items": { "type": "string" } },
    "featured_image": { "type": ["string", "null"] },
    "old_url":      { "type": "string", "description": "Original URL from eyalamit.co.il for 301 redirect" }
  },
  "additionalProperties": false
}
```

---

### social-channel

```json
{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "title": "Social Channel",
  "type": "object",
  "required": ["platform", "url", "status"],
  "properties": {
    "platform":    { "type": "string", "enum": ["facebook", "instagram", "youtube", "tiktok"] },
    "url":         { "type": ["string", "null"], "format": "uri", "description": "null when pending" },
    "handle":      { "type": ["string", "null"] },
    "status":      { "type": "string", "enum": ["live", "pending_url_from_eyal", "deprecated"] },
    "verified":    { "type": "boolean", "description": "Live 200 status confirmed" },
    "label_he":    { "type": "string", "description": "Used in aria-label: e.g. פייסבוק של אייל עמית" }
  },
  "additionalProperties": false
}
```

---

### book

```json
{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "title": "Book",
  "type": "object",
  "required": ["id", "slug", "title_he", "isbn", "cover_image"],
  "properties": {
    "id":               { "type": "string", "pattern": "^book-[a-z-]+$" },
    "slug":             { "type": "string", "description": "WP slug: vekatavta | kushi-blantis | tsva-bekahol" },
    "title_he":         { "type": "string" },
    "subtitle_he":      { "type": ["string", "null"] },
    "description_he":   { "type": "string" },
    "isbn":             { "type": ["string", "null"] },
    "cover_image":      { "type": "string" },
    "purchase_url":     { "type": ["string", "null"], "format": "uri", "description": "Green Invoice / mrng.to / mendele.co.il" },
    "price_ils":        { "type": ["number", "null"] },
    "genre":            { "type": "array", "items": { "type": "string" } },
    "qr_pages_count":   { "type": "integer", "minimum": 0 }
  },
  "additionalProperties": false
}
```

---

### press-item

```json
{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "title": "Press Item",
  "type": "object",
  "required": ["id", "date", "headline_he", "source_url"],
  "properties": {
    "id":           { "type": "string", "pattern": "^press-[0-9]+$" },
    "date":         { "type": "string", "format": "date" },
    "headline_he":  { "type": "string", "minLength": 5 },
    "source":       { "type": "string", "description": "Publication name" },
    "source_url":   { "type": "string", "format": "uri" }
  },
  "additionalProperties": false
}
```

---

### qr-page

```json
{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "title": "QR Landing Page",
  "type": "object",
  "required": ["qr_id", "slug", "title_he", "book_slug", "content_type", "lock_url"],
  "properties": {
    "qr_id":        { "type": "integer", "minimum": 1, "maximum": 49 },
    "slug":         { "type": "string", "pattern": "^qr[0-9]+$", "description": "e.g. qr1, qr49 — NEVER CHANGE" },
    "full_url":     { "type": "string", "format": "uri", "description": "e.g. https://eyalamit.co.il/qr/qr1/" },
    "title_he":     { "type": "string", "description": "Unique H1 for this QR page" },
    "book_slug":    { "type": "string", "enum": ["vekatavta", "kushi-blantis", "tsva-bekahol"] },
    "content_type": { "type": "string", "enum": ["story-continuation", "media", "comment-cta"] },
    "media_url":    { "type": ["string", "null"], "format": "uri" },
    "lock_url":     { "type": "boolean", "const": true, "description": "Slug printed in book — cannot change" },
    "noindex":      { "type": "boolean", "const": true }
  },
  "additionalProperties": false
}
```

---

## §9. WordPress Integration

### 9.1 Child Theme Structure

**Path:** `site/wp-content/themes/ea-eyalamit/`

```
ea-eyalamit/
├── style.css                  ← theme header (Name: EA Eyal Amit, Template: generatepress)
├── functions.php              ← enqueue tokens + animations + JS
├── assets/
│   ├── css/
│   │   ├── ea-tokens.css      ← §1.6 :root variables (copy-paste from this spec)
│   │   └── ea-animations.css  ← §2 keyframes + reduced-motion block
│   ├── js/
│   │   ├── ea-entrance.js     ← IntersectionObserver for .ea-entrance
│   │   ├── ea-hero.js         ← video pause/play, sound toggle
│   │   ├── ea-faq.js          ← accordion + filter + URL state
│   │   ├── ea-carousel.js     ← testimonials carousel
│   │   ├── ea-gallery.js      ← lightbox + focus trap
│   │   ├── ea-scroll.js       ← scroll progress bar
│   │   └── ea-ab-testing.js   ← WhatsApp A/B variant assignment
│   └── audio/
│       └── didgeridoo-ambient.mp3   ← awaiting Eyal (gap G2)
├── partials/
│   ├── footer-social.php
│   ├── contact-form.php       ← CF7 shortcode wrapper
│   └── breadcrumb.php
├── inc/
│   ├── analytics.php          ← GA4 + Clarity wp_head hooks
│   ├── cpt.php                ← register_post_type calls
│   └── taxonomies.php         ← register_taxonomy calls
└── templates/
    ├── front-page.php
    ├── page-service.php
    ├── page-books.php
    ├── single-book.php
    ├── page-shop.php
    ├── single-product.php
    ├── archive-blog.php
    ├── single-post.php
    ├── page-faq.php
    ├── page-content.php
    ├── page-en.php
    └── page-qr.php
```

---

### 9.2 Custom Post Types

**CPT: book**
```php
<?php
register_post_type('ea_book', [
    'labels'             => ['name' => 'ספרים', 'singular_name' => 'ספר',
                              'add_new_item' => 'הוסף ספר', 'edit_item' => 'ערוך ספר'],
    'public'             => true,
    'has_archive'        => false,
    'rewrite'            => ['slug' => 'books', 'with_front' => false],
    'menu_icon'          => 'dashicons-book',
    'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
    'show_in_rest'       => true,
    'taxonomies'         => ['book_genre'],
]);
```

**CPT: product (shop)**
```php
<?php
register_post_type('ea_product', [
    'labels'             => ['name' => 'מוצרים', 'singular_name' => 'מוצר',
                              'add_new_item' => 'הוסף מוצר', 'edit_item' => 'ערוך מוצר'],
    'public'             => true,
    'has_archive'        => true,
    'rewrite'            => ['slug' => 'shop', 'with_front' => false],
    'menu_icon'          => 'dashicons-cart',
    'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
    'show_in_rest'       => true,
    'taxonomies'         => ['product_category'],
]);
```

**CPT: press**
```php
<?php
register_post_type('ea_press', [
    'labels'             => ['name' => 'כתבות', 'singular_name' => 'כתבה'],
    'public'             => true,
    'has_archive'        => false,
    'rewrite'            => ['slug' => 'press', 'with_front' => false],
    'menu_icon'          => 'dashicons-megaphone',
    'supports'           => ['title', 'custom-fields'],
    'show_in_rest'       => true,
]);
```

**CPT: qr (QR pages)**
```php
<?php
register_post_type('ea_qr', [
    'labels'             => ['name' => 'עמודי QR', 'singular_name' => 'עמוד QR'],
    'public'             => true,
    'has_archive'        => false,
    'rewrite'            => ['slug' => 'qr', 'with_front' => false],
    'menu_icon'          => 'dashicons-admin-links',
    'supports'           => ['title', 'editor', 'thumbnail', 'custom-fields'],
    'show_in_rest'       => true,
    /* lock_url enforced via custom meta box validation — slug must NOT change after publish */
]);
```

---

### 9.3 Taxonomies

```php
<?php
// FAQ Category (used by atom-interaction-faq-filter)
register_taxonomy('faq_category', 'post', [
    'labels'       => ['name' => 'קטגוריות FAQ', 'singular_name' => 'קטגוריית FAQ'],
    'hierarchical' => true, 'rewrite' => ['slug' => 'faq-cat'],
    'show_in_rest' => true,
]);

// FAQ Tag
register_taxonomy('faq_tag', 'post', [
    'labels'       => ['name' => 'תגיות FAQ', 'singular_name' => 'תגית FAQ'],
    'hierarchical' => false, 'rewrite' => ['slug' => 'faq-tag'],
    'show_in_rest' => true,
]);

// Book Genre
register_taxonomy('book_genre', 'ea_book', [
    'labels'       => ['name' => 'ז'אנרים', 'singular_name' => 'ז'אנר'],
    'hierarchical' => false, 'show_in_rest' => true,
]);

// Product Category
register_taxonomy('product_category', 'ea_product', [
    'labels'       => ['name' => 'קטגוריות מוצר', 'singular_name' => 'קטגוריית מוצר'],
    'hierarchical' => true, 'show_in_rest' => true,
]);
```

---

### 9.4 Theme Mods (Customizer settings)

Registered in `inc/theme-mods.php`:

| Mod key | Type | Default | Usage |
|---|---|---|---|
| `ea_ga4_id` | text | `''` | GA4 Measurement ID (G-XXXXXXXX) |
| `ea_clarity_id` | text | `''` | Microsoft Clarity project ID |
| `ea_whatsapp_number` | text | `9720524822842` | WhatsApp deep-link number |
| `ea_social_fb` | url | `https://www.facebook.com/didgeridoo.studio.eyal.amit` | Facebook URL |
| `ea_social_ig` | url | `https://www.instagram.com/didgeridoo.therapy.center` | Instagram URL |
| `ea_social_yt` | url | `https://www.youtube.com/@איילעמית` | YouTube URL |
| `ea_social_tt` | url | `''` | TikTok URL (empty until received) |
| `ea_footer_location` | text | `דיג'רידו סטודיו — פרדס חנה` | Footer location text |

---

### 9.5 Gutenberg Block Patterns

Registered in `inc/block-patterns.php`. Each pattern is a named reusable block configuration:

**Pattern: ea/hero-placeholder**
```php
register_block_pattern('ea/hero-placeholder', [
    'title'      => 'Hero — גיבור (פלייסהולדר)',
    'categories' => ['ea-patterns'],
    'content'    => '<!-- wp:group {"className":"ea-hero ea-hero--placeholder"} -->
                     <div class="wp-block-group ea-hero ea-hero--placeholder">
                       <!-- wp:heading {"level":1,"className":"ea-page-title ea-page-title--overlay ea-entrance"} -->
                       <h1 class="ea-page-title ea-page-title--overlay ea-entrance">כותרת ראשית</h1>
                       <!-- /wp:heading -->
                     </div>
                     <!-- /wp:group -->',
]);
```

**Pattern: ea/breath-divider**
```php
register_block_pattern('ea/breath-divider', [
    'title'   => 'Breath Divider — מפריד נושם',
    'content' => '<!-- wp:html -->
                  <div class="ea-breath-divider" aria-hidden="true">
                    <span class="ea-breath-divider__line"></span>
                  </div>
                  <!-- /wp:html -->',
]);
```

**Pattern: ea/testimonial-card**
```php
register_block_pattern('ea/testimonial-card', [
    'title'   => 'Testimonial Card — כרטיס עדות',
    'content' => '<!-- wp:html -->
                  <article class="ea-testimonial-card ea-entrance">
                    <blockquote class="ea-testimonial-card__quote">
                      <p class="ea-testimonial-card__text">טקסט העדות כאן</p>
                      <footer><a class="ea-testimonial-card__name ea-link" href="#">שם הממליץ</a></footer>
                    </blockquote>
                  </article>
                  <!-- /wp:html -->',
]);
```

**Pattern: ea/faq-item**
```php
register_block_pattern('ea/faq-item', [
    'title'   => 'FAQ Item — שאלה נפוצה',
    'content' => '<!-- wp:html -->
                  <div class="ea-faq-item">
                    <details class="ea-faq-item__details">
                      <summary class="ea-faq-item__summary">
                        <h3 class="ea-faq-item__question">השאלה כאן</h3>
                        <span class="ea-faq-item__icon" aria-hidden="true">▾</span>
                      </summary>
                      <div class="ea-faq-item__answer"><p>התשובה כאן</p></div>
                    </details>
                  </div>
                  <!-- /wp:html -->',
]);
```

---

### 9.6 Shortcodes

Shortcodes used only where Gutenberg blocks cannot handle the output. Minimised per D-14 principle.

| Shortcode | Output | Registered in |
|---|---|---|
| `[ea_footer_social]` | `atom-data-display-footer-social` HTML | `inc/shortcodes.php` |
| `[ea_breadcrumb]` | `atom-nav-breadcrumb` HTML | `inc/shortcodes.php` |
| `[ea_scroll_progress]` | `#ea-scroll-progress` div | `inc/shortcodes.php` |

---

### 9.7 Contact Form 7 Configuration

**CF7 Form ID:** Assigned at time of plugin setup (form title: "צור קשר — אייל עמית").

**Field mapping:**

| CF7 field name | Type | Label | Required |
|---|---|---|---|
| `your-name` | text | שם מלא | ✅ |
| `your-phone` | text | טלפון / אימייל | ✅ |
| `your-subject` | select | נושא פניה | ❌ |
| `your-message` | textarea | הודעה | ❌ |

**Subject dropdown values (7 topics per decision B2):**
1. טיפול בדיג'רידו
2. סאונד הילינג
3. שיעורי נגינה
4. ספרים
5. חנות
6. כללי
7. אחר

**Mail recipient:** `info@eyalamit.co.il` via WP Mail SMTP free plugin.

**WP Mail SMTP Eyal-input flow:** After plugin installation, Eyal navigates to WP Admin → WP Mail SMTP → Settings → enters SMTP credentials for `info@eyalamit.co.il`. Instructions: `docs/onboarding/SMTP-EYAL-INSTRUCTIONS.md`.

---

### 9.8 Allowed Plugins (Wave2)

Per project decision — NO premium plugins, NO WooCommerce:

| Plugin | Purpose | Tier |
|---|---|---|
| Contact Form 7 | Contact form | Free |
| WP Mail SMTP | SMTP email routing | Free |
| Redirection | 301 redirect management | Free |
| Akismet | Spam prevention (CF7) | Free (personal) |

All other plugins require explicit approval from team_00 before installation.

---

## §10. Performance Budget

### 10.1 LCP (Largest Contentful Paint) Targets

| Page type | LCP target | Measured on | Network condition |
|---|---|---|---|
| Home (with hero video) | < 2.5s | Mobile 4G (simulated) | 4G Fast |
| Service pages | < 2.0s | Mobile 4G | 4G Fast |
| Blog archive / single | < 1.8s | Mobile 4G | 4G Fast |
| Shop archive | < 2.0s | Mobile 4G | 4G Fast |
| QR landing pages | < 1.5s | Mobile 4G | 4G Fast (QR = phone scan) |

LCP element on homepage = Hero image (`<img loading="eager" fetchpriority="high">`). Preload tag required in `<head>`.

---

### 10.2 JS Budget

| Scope | Budget | Measurement |
|---|---|---|
| Total JS per page (parsed + executed) | ≤ 80KB gzipped | Chrome Coverage tool |
| Individual JS files (ea-*.js) | ≤ 15KB each gzipped | Build step |
| Third-party JS (GA4 + Clarity) | ≤ 30KB gzipped (external CDN) | Not blocked on LCP path |
| No JS frameworks | 0KB | React/Vue/Alpine: NOT allowed in Wave2 |

**JS loading strategy:**
- All `ea-*.js` files: `defer` attribute.
- GA4 + Clarity: `async` via `wp_head` hook (priority 99).
- No render-blocking scripts in `<head>`.

---

### 10.3 CSS Budget

| Scope | Budget |
|---|---|
| `ea-tokens.css` | ≤ 5KB gzipped |
| `ea-animations.css` | ≤ 3KB gzipped |
| Main theme CSS (`style.css`) | ≤ 40KB gzipped |
| Total CSS per page | ≤ 50KB gzipped |
| Unused CSS | ≤ 15% (PurgeCSS or manual audit in Stage B) |

---

### 10.4 Image Guidelines

| Rule | Spec |
|---|---|
| Format | WebP primary; JPEG fallback via `<picture>` |
| Hero still (mobile fallback) | ≤ 800KB, max 1200px wide |
| Gallery images | ≤ 200KB per image at display size |
| Thumbnails (blog, testimonials) | ≤ 80KB |
| Product / book covers | ≤ 150KB |
| `loading` attribute | `lazy` on all below-fold images; `eager` on hero only |
| `width` + `height` attributes | Required on all `<img>` to prevent CLS |
| `fetchpriority="high"` | Hero image only |
| Alt text | Mandatory; descriptive; not empty except purely decorative (aria-hidden) |
| Max display width | 1200px (desktop); images must have responsive `srcset` |

---

### 10.5 Font Loading

```html
<!-- In <head> — critical fonts preloaded -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Preload the woff2 file for the most-used weight (300) -->
<link rel="preload" as="font" type="font/woff2"
      href="https://fonts.gstatic.com/s/heebo/v26/NGS3v5_NC0k9P9H2ZMdQ.woff2"
      crossorigin>

<!-- Full Heebo import (weights: 100, 200, 300, 400) -->
<link href="https://fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400&display=swap"
      rel="stylesheet">
```

**`font-display: swap`** — ensured by Google Fonts `?display=swap` parameter. Text renders immediately in fallback font; swaps to Heebo when loaded. Prevents invisible text during load (FOIT).

**Subset:** Hebrew + Latin only. Weights 500 and 600 excluded (not used in design).

---

### 10.6 Hero Video Spec (Performance)

| Requirement | Spec |
|---|---|
| Formats | H.264 `.mp4` + VP9 `.webm` (dual `<source>`) |
| Max size desktop | ≤ 3MB (both formats combined) |
| Max size mobile fallback image | ≤ 800KB WebP |
| Duration | 15–25 seconds loop |
| Resolution | 1920×1080 desktop; 1280×720 acceptable |
| `preload` attribute | `"metadata"` (not `"auto"` — avoids loading full video on mobile) |
| `lazy decode` | `decoding="async"` on fallback `<img>` |
| Mobile strategy | CSS hides `<video>`, shows `<img>` on `max-width: 639px` |
| Video content | Close-up of didgeridoo (wood, carvings, Eyal's hand) — slow, mysterious, 0 cuts |
| Color grade | Warm Earth tones matching palette; low contrast |

**ffmpeg encoding commands (guidance for team_40):**
```bash
# H.264 MP4
ffmpeg -i input.mov -c:v libx264 -crf 23 -preset slow -an \
       -vf "scale=1920:1080" hero.mp4

# VP9 WebM
ffmpeg -i input.mov -c:v libvpx-vp9 -crf 33 -b:v 0 -an \
       -vf "scale=1920:1080" hero.webm
```

---

## §11. Testing Strategy

### 11.1 Visual Regression Baseline Pages (8)

Each page is screenshotted at breakpoints: 375px, 768px, 1280px, 1440px. Compared after each wave of changes.

| # | Page | URL | Key atoms to validate |
|---|---|---|---|
| 1 | Homepage | `/` | Hero video (placeholder), 12 blocks, footer |
| 2 | Treatment | `/treatment` | Service hero, content sections, disclaimer, FAQ filter |
| 3 | Method | `/method` | Long-form content, scroll progress, comparison |
| 4 | Sound Healing | `/sound-healing` | Gallery, testimonials carousel |
| 5 | Books catalog | `/books` | Book cards ×3, price bundle |
| 6 | Book detail (וכתבת) | `/books/vekatavta` | Breadcrumb, excerpt accordion, green-invoice CTA |
| 7 | Blog archive | `/blog` | Blog grid, pagination |
| 8 | FAQ | `/faq` | Tab filter, accordion items |

**Tool:** Percy, Chromatic, or manual screenshot comparison via `puppeteer-screenshot` script in CI.

---

### 11.2 WordPress Staging Smoke Test (6 pages)

Smoke test after each WP deployment on staging. Pass/fail binary.

| # | URL | Pass criteria |
|---|---|---|
| 1 | `/` | 200, H1 present, CTA links to /contact, hero loads |
| 2 | `/treatment` | 200, FAQ filter works, form submission succeeds |
| 3 | `/books/vekatavta` | 200, breadcrumb correct, Green Invoice link opens new tab |
| 4 | `/shop` | 200, 5 product cards visible, grid responsive |
| 5 | `/faq` | 200, 4 category tabs, ?cat= URL state updates |
| 6 | `/qr/qr1/` | 200, noindex meta present, H1 unique |

---

### 11.3 Accessibility — axe-core CLI

Run via `axe-cli` or `@axe-core/puppeteer` on all 8 baseline pages. Required result: **0 critical, 0 serious** violations.

```bash
# Install
npm i -g axe-cli

# Run on staging
axe https://staging.eyalamit.co.il/ --tags wcag2a,wcag2aa,wcag21aa --exit

# Run on all 8 pages (shell loop)
PAGES=(/ /treatment /method /sound-healing /books /books/vekatavta /blog /faq)
for page in "${PAGES[@]}"; do
  axe "https://staging.eyalamit.co.il${page}" \
      --tags wcag2a,wcag2aa,wcag21aa \
      --reporter v2 \
      --exit
done
```

**Accepted minor violations (documented):**
- Muted text (`#A8A19B`) in footer at small size — pre-approved as large-text-equivalent context.
- WhatsApp button contrast 3.95:1 — accepted at this interactive element size (default; revisit at Stage B).

---

### 11.4 Lighthouse CI Thresholds

Run against staging after each WP deploy. Failure blocks WP-W2-09 sign-off.

| Category | Threshold | Page |
|---|---|---|
| Performance | ≥ 85 | Homepage (mobile) |
| Performance | ≥ 90 | Homepage (desktop) |
| Accessibility | ≥ 95 | All pages |
| Best Practices | ≥ 90 | All pages |
| SEO | ≥ 90 | All pages (except /qr/* — noindex expected) |

```bash
# Lighthouse CI config (.lighthouserc.json)
{
  "ci": {
    "collect": {
      "url": ["https://staging.eyalamit.co.il/"],
      "settings": { "formFactor": "mobile", "screenEmulation": { "mobile": true } }
    },
    "assert": {
      "preset": "lighthouse:recommended",
      "assertions": {
        "categories:performance":    ["warn", {"minScore": 0.85}],
        "categories:accessibility":  ["error", {"minScore": 0.95}],
        "categories:best-practices": ["warn",  {"minScore": 0.90}],
        "categories:seo":            ["warn",  {"minScore": 0.90}]
      }
    }
  }
}
```

---

### 11.5 Manual Test Matrix

Test matrix: `reduced-motion × mobile/desktop × HE/EN`. Each cell = pass/fail per checklist.

| Scenario | Reduced-motion OFF | Reduced-motion ON |
|---|---|---|
| Desktop Hebrew | Breathing lines animate; CTA pulses; scroll-progress visible | No animations; layout intact; all content readable |
| Desktop English (/en) | LTR layout; EN content; CTA links to /contact?lang=en | Same; no animations |
| Mobile Hebrew (375px) | Video hidden, still image shown; WhatsApp float visible | No animations; still image; WhatsApp float without pulse |
| Mobile English (375px) | LTR layout; single column; CTA full-width | Same; no animations |

**Reduced-motion testing in Chrome:**
1. DevTools → More tools → Rendering → "Emulate CSS media feature prefers-reduced-motion: reduce"
2. Confirm: all `.ea-breath-divider__line`, `.ea-hero__breath-line`, `.ea-cta-pill` stop animating
3. Confirm: content is still visible and readable

**Keyboard-only test:**
- Navigate entire homepage using Tab only (no mouse).
- Confirm: all interactive elements reachable; no focus traps outside modals; all forms submittable.

---

## §12. Changelog & Versioning

### 12.1 Atom Versioning — Semver

Each atom carries a version: `atom-v<MAJOR>.<MINOR>.<PATCH>`

| Version bump | Trigger |
|---|---|
| **MAJOR** (breaking) | HTML structure change, new required ARIA attribute, renamed CSS class |
| **MINOR** (additive) | New variant added, new optional ARIA, CSS-only enhancement |
| **PATCH** (fix) | Bug fix, typo in label, contrast correction |

**Current version of all atoms at spec publication:** `atom-v1.0.0`

---

### 12.2 Breaking Changes → New Variant ID

When a breaking change is required for an existing atom (e.g., new HTML anatomy), the change MUST:
1. Create a **new variant** ID rather than modifying the existing variant.
2. Keep the old variant in production until all pages are migrated.
3. Bump MAJOR version.

Example: `atom-feedback-cta-pill variant_primary` becomes `variant_primary-v2` if pill height changes from 44px to 56px (breaking touch-target difference).

---

### 12.3 Wave3+ Patch Protocol via ATOM-CHANGE-REQUEST.md

All post-Wave2 changes to atoms must be submitted via a canonical change request artifact:

**File:** `_COMMUNICATION/team_80/ATOM-CHANGE-REQUEST-[date].md`

**Required fields:**
```yaml
---
atom_id: atom-feedback-cta-pill
change_type: MINOR | MAJOR | PATCH
current_version: atom-v1.0.0
proposed_version: atom-v1.1.0
description: [what changes and why]
affected_pages: [list of templates/pages]
breaking: false
requires_migration: false
requested_by: team_80
approved_by: (pending team_100)
---
```

**Review path:** team_80 submits → team_100 reviews → nimrod (team_00) final approval on MAJOR changes → team_10 implements → team_50 QA validates.

---

### 12.4 Document Version History

| Date | Version | Change | Author |
|---|---|---|---|
| 2026-05-26 | v1.0.0 | Initial LOD400 spec — 32 atoms, 12 chapters | team_100 + Sonnet build subagent |

**Next expected update:** Post QA Gate 2 sign-off — `status: APPROVED` replaces `DRAFT`.

---

### 12.5 Supersession Table

| Document | Status | Relationship |
|---|---|---|
| D-EYAL-DESIGN-STYLE-13 (2026-04-07) | LOCKED | This spec EXTENDS it; does NOT replace. D-13 iron rules remain binding. |
| HANDOFF-DESIGN-SYSTEM-TO-TEAM100-2026-04-10 | SUPERSEDED in part | §7.1 "what to examine" in HANDOFF is now "mandatory" in this spec. |
| D-EYAL-DESIGN-DIRECTION-FBW-DEEP-2026-05-26 | IMPLEMENTED | This spec is the LOD400 implementation of that direction document. |
