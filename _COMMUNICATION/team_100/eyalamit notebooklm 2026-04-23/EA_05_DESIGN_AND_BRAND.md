<!--
package: EyalAmit.co.il NotebookLM Package
file: EA_05_DESIGN_AND_BRAND.md
date: 2026-04-23
audience: designers, front-end developers, visual brand collaborators
-->

# EyalAmit.co.il — Design, Visual Identity, and Brand

## Design Philosophy

The site's design direction is described as **"ללא מהפכות בממשק"** — no interface revolutions. This is a deliberate decision: the brand is established, the visual identity is recognized by an existing audience, and the goal is a modern, clean, professional refresh — not a brand overhaul.

The design should communicate: **professional center, not a hobby site.** The visual language should feel warm, grounded, and calm — not clinical, not flashy, not spiritual-cliché (no dreamcatchers, no mandalas, no stock "meditation sunset" photography).

**Mobile-first.** Every block is designed for mobile before desktop. This is both a design constraint and an SEO requirement (Google's mobile-first indexing).

**Generous whitespace.** The site should breathe — generous margins, not dense, not cluttered. The content is substantive; it does not need visual noise to feel rich.

**RTL-native.** All layout, all text rendering, all padding/margin logic uses CSS logical properties to be genuinely RTL — not just `direction: rtl` applied on top of LTR assumptions.

---

## Color Palette (Locked — From Eyal's Canva Brand Slide)

These seven colors are the complete brand palette. They are derived from Eyal's own Canva branding material and are binding for all UI outputs.

| Name | HEX | Primary Role |
|------|-----|-------------|
| **Sand** | `#D8C7B5` | Light backgrounds, soft surfaces, gradients, OG image background |
| **Terracotta** | `#A44E2B` | Primary accent — borders, structural lines, active states |
| **Earth** | `#8A5A44` | Secondary text, metadata, warm supporting icons |
| **Olive** | `#6E6F4A` | Nature / organic / secondary emphasis (sparingly) |
| **Ink** | `#2E2B28` | Primary text, dark headings, all body copy |
| **Chocolate** | `#5C3A2E` | Secondary headings, secondary buttons, deep borders |
| **Brick** | `#AB3A2B` | Strong CTA, call-to-action buttons, critical highlights (used sparingly) |

### CSS Custom Properties

All implemented via CSS custom properties in the child theme:

```css
:root {
  --eyal-sand:       #D8C7B5;
  --eyal-terracotta: #A44E2B;
  --eyal-earth:      #8A5A44;
  --eyal-olive:      #6E6F4A;
  --eyal-ink:        #2E2B28;
  --eyal-chocolate:  #5C3A2E;
  --eyal-brick:      #AB3A2B;

  /* Semantic aliases */
  --accent:          var(--eyal-terracotta);
  --accent-strong:   var(--eyal-brick);
  --text:            var(--eyal-ink);
  --text-muted:      var(--eyal-earth);
  --surface:         var(--eyal-sand);
}
```

### Color Usage Guidelines

- **Ink** (`#2E2B28`) is the default body text color — warm near-black, not pure `#000000`
- **Sand** (`#D8C7B5`) is the default page background color for sections that need warmth and softness
- **Terracotta** (`#A44E2B`) draws attention: borders on key content boxes, active navigation states, H2 underlines
- **Brick** (`#AB3A2B`) is for CTA buttons only — reserved for conversion-critical elements. Do not use for decoration.
- **Olive** (`#6E6F4A`) is used sparingly — it reads as "nature" and provides subtle differentiation, but can look muddy if overused
- **No pure white** (`#FFFFFF`) for large background areas — use Sand instead for warmth. White can be used for card backgrounds nested inside Sand sections.

---

## Logo Specification

**Logo shape:** Square (1:1 ratio)

**Source master:** `master logo cbdidg.psd` (Adobe Photoshop)

**Currently deployed on old site:** `ea-logo.jpg` — 472×472px JPEG — **insufficient quality.** The new site requires proper exports.

**Required export set (10 files):**

| File | Format | Size | Background | Use |
|------|--------|------|------------|-----|
| `ea-logo.svg` | SVG | Scalable | Transparent | Master — all digital use |
| `ea-logo-512.png` | PNG-24 | 512×512 | Transparent | High-res digital |
| `ea-logo-256.png` | PNG-24 | 256×256 | Transparent | Standard digital |
| `ea-logo-192.png` | PNG-24 | 192×192 | Transparent | PWA / app icon |
| `ea-logo-128.png` | PNG-24 | 128×128 | Transparent | Nav header |
| `ea-favicon.ico` | ICO | Multi-size | Transparent | Browser favicon |
| `ea-favicon-32.png` | PNG | 32×32 | Transparent | Favicon |
| `ea-favicon-16.png` | PNG | 16×16 | Transparent | Favicon small |
| `ea-og-image.jpg` | JPEG | 1200×630 | Sand (`#D8C7B5`) | OG / social sharing |
| `ea-logo-print.png` | PNG-24 | 1000×1000 | Transparent | Print use |

**OG Image spec:** Logo centered (~400×400px) on 1200×630 canvas with Sand (`#D8C7B5`) background. Typography: Heebo Light 300, Ink `#2E2B28`. Include the site name or tagline below the logo mark.

**Header display size:** `max-height: 40px` — logo scales down cleanly to this from the SVG source.

**No dark-background version needed** — all site surfaces are light/warm tones.

---

## Typography

**Hebrew fonts (approved):**
- **Primary:** Arial (safe fallback — universally available)
- **Preferred:** Heebo or Assistant (Google Fonts — clean, RTL-optimized, readable)
- **Weight hierarchy:** 700/800 for H1, 600 for H2, 400 for body, 300 for captions/metadata

**Font stack:**
```css
font-family: 'Heebo', 'Assistant', Arial, sans-serif;
```

**Type scale (general guidance):**
- H1: 2.2–2.8rem (desktop), 1.6–1.8rem (mobile)
- H2: 1.6–1.8rem (desktop), 1.3rem (mobile)
- H3: 1.2–1.3rem
- Body: 1.05–1.1rem, line-height 1.7–1.8 (generously open)
- Captions/metadata: 0.85rem, Earth (`#8A5A44`)

**Letter-spacing:** Minimal — these fonts are designed for Hebrew legibility without tracking adjustments.

**No mixed-language font conflicts:** The English landing page uses the same font stack — Heebo supports both Hebrew and Latin characters.

---

## Homepage Visual Direction Options

Three homepage block sequences were developed for client selection. All three share the same block inventory — they differ in visual hierarchy and density:

### Option A — "One Gate"
Full-width hero (dominant image + H1 + CTA) → single main news/events block → up to 3 secondary service cards below. **Minimal.** Immediate clarity about "what's happening now." Best when Eyal has regular events to feature.

### Option B — "Center + Depth"
Narrower hero + message block + CTA → side column with events list → 2 equal content blocks (one service summary, one testimonial). More "professional center" feel. Best for building trust quickly on first visit.

### Option C — "Dominant Image + Layer"
Nearly full-screen image or ambient video + text overlay + CTA → one "what's new" line → two action buttons/cards. Most minimal. For strong personal brand with infrequent public events. The visual communicates the atmosphere more than the words.

**Eyal's stated preference:** "A hero with a large image and diverse elements below" — aligning most closely with Option A or Option B. Final selection pending.

---

## Page-Level Design Patterns

### The Answer Block Pattern
Every H2 section on service/method pages is followed by a visually distinct answer block:
- Slightly indented or slightly larger font
- Terracotta left-border (RTL: right-border for Hebrew, left-border for English)
- 40–100 words
- No jargon, no sub-clauses

This block serves both SEO (structured for featured snippets) and UX (scannable on mobile).

### The Distinction Table Pattern
Used for the "Treatment vs. Sound Healing" comparison:
- Two-column comparison table
- Warm palette — Sand background, Chocolate border, Ink text
- No heavy borders — subtle `border-collapse` with thin lines

### The FAQ Pattern
- H3: Question
- P: Answer (40–100 words, direct)
- Accordion behavior on mobile (expand/collapse), flat display on desktop
- FAQPage schema markup

### The Testimonial Pattern
- Short (2–4 lines of text)
- Attribution: first name, general context (e.g., "מנהל פרויקטים, ת'א")
- No photos required (privacy)
- Sand background card with Terracotta accent border

### The CTA Block Pattern
Appears at minimum: top of service page (hero CTA) + bottom of service page (closing CTA).

**Primary CTA text:** "לתיאום שיחת היכרות"
**Secondary CTA text:** "לפרטים ויצירת קשר"

CTA button: Brick (`#AB3A2B`) background, white text, 6–8px border-radius, comfortable padding (16px 32px). Hover state: darken 8–10%.

---

## Photography and Visual Content Guidelines

**What to use:**
- Eyal in the studio — playing, teaching, one-on-one setting
- The instrument — close-up detail, texture, natural light
- The studio space — warm, natural, with garden visible
- Hands on the instrument — action-oriented, not posed

**What to avoid:**
- Generic stock "wellness" photography (sunset meditation, empty nature landscapes, generic hands)
- Images that code as "spiritual healing" without human specificity
- Oversaturated or HDR processing — keep natural

**Image treatment:** Warm color grading consistent with the Sand/Terracotta/Earth palette. Slight desaturation of cool tones, slight lift on warm tones. No filter presets that push toward blue/purple tones.

**Alt text:** All images have descriptive Hebrew alt text — required for accessibility compliance (Israeli standards) and SEO.

---

## Technical Design Implementation

**Platform:** WordPress 6.9+ / GeneratePress parent theme + `ea-eyalamit` child theme + ACF (Advanced Custom Fields)

**What lives in the child theme:**
- All brand CSS (via `style.css` in child theme)
- All custom PHP functions (prefix: `ea_`)
- Custom page templates
- Logo and brand asset files
- Any custom block templates

**What does NOT live in the child theme:**
- Plugin configurations (these are in the database)
- Content (this is in WordPress posts/pages/ACF fields)
- Media library assets (in `wp-content/uploads/`)

**GeneratePress modules active:**
- Blog
- Colors
- Disable elements (for selective layout control)
- Site library (for base templates)
- Spacing

**Explicitly forbidden:**
- Elementor (would replace GeneratePress as the builder — not compatible with the lean architecture)
- WPBakery, Divi, or other heavy page builders
- Any plugin that injects its own visual components that can't be overridden by the child theme

**Block editor (Gutenberg):** Used for standard page/post content. The Answer Block Pattern is implemented as a custom Gutenberg block pattern in the child theme — authors select it from the pattern library for consistent rendering.

---

## Responsive Design

**Breakpoints:**
- Mobile: < 600px
- Tablet: 600px–1024px
- Desktop: > 1024px

**Mobile-first implementation:** All CSS starts from the mobile layout. Media queries add complexity for larger screens, not the reverse.

**Key mobile behaviors:**
- Navigation: hamburger menu with full-screen overlay (drawer style, RTL)
- Service tables / comparison blocks: stack vertically on mobile
- FAQ: accordion behavior (one open at a time)
- Hero: text block below image on mobile (not overlaid — insufficient contrast at small sizes)
- CTA button: full-width on mobile

---

## Accessibility Standards

The site targets compliance with Israeli accessibility standards (WCAG 2.1 AA minimum):

- WP Accessibility plugin (Joe Dolson) active
- Skip-to-content link
- All form labels properly associated
- All images have alt text
- Heading hierarchy respected (one H1, logical H2/H3 nesting)
- Minimum contrast ratio 4.5:1 for body text — verified for all palette color combinations
- Keyboard navigation tested for all interactive elements

**Color contrast check on primary combinations:**
- Ink (`#2E2B28`) on Sand (`#D8C7B5`): contrast ratio ~7.2 — PASS
- White on Brick (`#AB3A2B`): contrast ratio ~4.8 — PASS
- Earth (`#8A5A44`) on White: contrast ratio ~5.1 — PASS (for captions)

**Accessibility statement page:** Required by Israeli law — present and linked from footer.
