---
id: ATOM-INVENTORY-2026-05-26
title: Atom Inventory — Wave2 LOD400 design system source list
status: FINAL
document_version: v1.1.0
date: 2026-05-26
authored_by: team_100 (Opus orchestrator) + Sonnet build subagent
owners: team_100 (architecture) + team_80 (design)
parent_mandate: _COMMUNICATION/team_100/MANDATE-TEAM100-STAGE-A-ATOMS-FIRST-2026-05-26.md
qa_artifact: _COMMUNICATION/team_50/QA-A1-INVENTORY-2026-05-26.md
qa_gate_1_verdict: PASS_WITH_FINDINGS
finalized_at: '2026-05-27'
finalized_by: team_100 (Opus orchestrator)
profile: L0
---

# Atom Inventory — Wave2 LOD400 Source List

## 0. Summary

- **Total atoms:** 32
- **Categories:** structure (7), content (9), interaction (6), feedback (4), nav (3), data-display (3)
- **Patch sync:** 2026-05-27 P1–P8 backport aligned with D-14 v1.1.0 (no atom count change)
- **Sources scanned:** 15 content .md + 1 .docx (referenced by filename only — ומה היום.docx) + 9 Wave2 WPs + hero-c-fbw-sketch.html + QR-URL-INVENTORY.csv (49 rows) + social-channels.json + EYAL-SITE-COLOR-PALETTE.md + D-EYAL-DESIGN-DIRECTION-FBW-DEEP-2026-05-26.md + DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md

---

## 1. Atom Catalog

### structure

---

#### `atom-structure-hero-video`
- **HE name:** גיבור וידאו
- **EN name:** Hero Video Frame
- **Category:** structure
- **Usage count:** 6 (homepage, treatment, method, sound-healing, lessons, FAQ — each service page uses a fullscreen hero)
- **Source files:** `homepage1-3 v2.md §SECTION 01`, `treatment.md §SECTION 01`, `method.md §SECTION 01`, `sound_healing_final.md §SECTION 01`, `lesons.md §SECTION 01`, `FAQ FINAL.md §SECTION 01`, `hero-c-fbw-sketch.html §.hero`
- **Variants:** `variant_video` (video loop + breathing-lines overlay, desktop), `variant_still` (static image fallback, mobile), `variant_placeholder` (CSS gradient + breathing lines, pre-video delivery)
- **Accessibility flags:** autoplay must be muted (browser policy); pause button required per ת"י 5568; keep `.ea-hero__controls` wrapper without `aria-label` (labels belong on interactive buttons only); H1 overlay must pass WCAG AA contrast (≥4.5:1) against video; `prefers-reduced-motion` disables all animation overlays; `alt` on fallback image required
- **D-14 motion:** yes — breathing-lines overlay (`breathe-x` keyframe, ~7s loop, opacity 0.35↔0.55); video loop autoplay muted; `breathe-pulse` on CTA pill (scale 1.0↔1.005, 8s); entrance fade-up on H1/H2
- **Responsive notes:** desktop = full 100vh video; mobile = static image fallback (max 800 KB); RTL: H1 text-align right, CTA pill right-aligned; sound-toggle and pause button top-right corner in LTR terms = top-left in RTL layout
- **Composes into:** tpl-home, tpl-service, tpl-method

---

#### `atom-structure-section-intro`
- **HE name:** בלוק פתיחה
- **EN name:** Section Intro Block
- **Category:** structure
- **Usage count:** 8 (homepage §02, §05, method §02, treatment §02, sound-healing §02, lessons §02, buy-didgeridoo §02, bags §02)
- **Source files:** `homepage1-3 v2.md §SECTION 02`, `method.md §SECTION 02`, `treatment.md §SECTION 02`, `sound_healing_final.md §SECTION 02`, `lesons.md §SECTION 02`, `buy didgeridoo.md §SECTION 02`
- **Variants:** `variant_text-only`, `variant_text-image` (portrait alongside body copy)
- **Accessibility flags:** heading hierarchy: H2 under H1 hero; line length ≤ 75 chars per WCAG 1.4.8; font-weight 300 (Heebo) — confirm contrast on bg-alt (#F3EEE8)
- **D-14 motion:** yes — entrance: `fade-up` + breathing decompression (scale 0.995→1, 600ms ease-out) on scroll-into-view; no continuous loop
- **Responsive notes:** 960px content-width on desktop; full-bleed padding on mobile; RTL line-length still applies; text-align right; portrait image below text on mobile
- **Composes into:** tpl-home, tpl-service, tpl-method, tpl-shop-item

---

#### `atom-structure-content-section`
- **HE name:** בלוק תוכן
- **EN name:** Content Section Block
- **Category:** structure
- **Usage count:** 12 (appears in nearly every page — method §04–§10, treatment §05–§07, sound-healing §03–§06, lessons §05, MUZZA §03–§09, and book detail pages)
- **Source files:** `method.md §SECTION 04`, `treatment.md §SECTION 05`, `sound_healing_final.md §SECTION 03`, `lesons.md §SECTION 05`, `MUZZA.md §SECTION 03`
- **Variants:** `variant_prose` (pure text), `variant_list` (bulleted principles), `variant_steps` (numbered accordion, e.g. lessons stages), `variant_two-col` (text + image)
- **Accessibility flags:** list variants use `<ul>`/`<ol>` semantic markup; H2/H3 hierarchy enforced; color contrast Ink (#2E2B28) on bg (#FAF8F5) = 14.5:1 — passes AAA
- **D-14 motion:** yes — section entrance breathe-decompression (scale 0.995→1 + opacity 0→1, 700ms); section dividers use `atom-structure-breath-divider`
- **Responsive notes:** `--section-padding: 120px` desktop, 60px mobile; two-col collapses to single-col on mobile; RTL direction preserved throughout
- **Composes into:** tpl-home, tpl-service, tpl-method, tpl-book-detail, tpl-shop-item

---

#### `atom-structure-breath-divider`
- **HE name:** מפריד נושם
- **EN name:** Breath Divider
- **Category:** structure
- **Usage count:** 10 (between every major section on homepage; used on method, treatment, sound-healing, lessons pages as inter-section separator)
- **Source files:** `hero-c-fbw-sketch.html §.breath-line`, `D-EYAL-DESIGN-DIRECTION-FBW-DEEP-2026-05-26.md §2.1`, `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-01 Scope IN`
- **Variants:** `variant_horizontal` (full-width thin line, opacity ~0.35), `variant_accent-circle` (corner accent, opacity 0.04–0.08)
- **Accessibility flags:** decorative — `aria-hidden="true"` required; `prefers-reduced-motion` removes animation entirely; must not carry content
- **D-14 motion:** yes — continuous `breathe-x` loop (~6–8s, scaleX 1.0↔1.15); delay randomised per instance (1–3s) to simulate organic breath
- **Responsive notes:** horizontal divider spans full container-width on all breakpoints; accent-circles hidden on mobile to reduce visual noise
- **Composes into:** tpl-home, tpl-service, tpl-method, tpl-book-detail, every long-form page

---

#### `atom-structure-gallery`
- **HE name:** גלריה
- **EN name:** Media Gallery
- **Category:** structure
- **Usage count:** 5 (homepage §09, sound-healing §05 studio/tipi photos, lessons, vekatavta §05, bags §09)
- **Source files:** `homepage1-3 v2.md §SECTION 09 DEV NOTES`, `sound_healing_final.md §SECTION 05`, `vekatavta.md §SECTION 05`, `bags for didg.md §SECTION 09`
- **Variants:** `variant_grid` (masonry/grid, 3–4 cols desktop), `variant_lightbox` (click-to-open full image)
- **Accessibility flags:** every image needs descriptive `alt` text; lightbox must be keyboard-navigable (Esc closes, arrow keys navigate); focus-trap in lightbox; lazy-load with `loading="lazy"`
- **D-14 motion:** no continuous animation; fade-in entrance on scroll; lightbox open/close has gentle opacity transition (200ms)
- **Responsive notes:** 4 cols desktop → 2 cols tablet → 1 col mobile; images are authentic (not stock) per content SSOT; swipe gesture on mobile for lightbox navigation
- **Composes into:** tpl-home, tpl-service, tpl-book-detail, tpl-shop-item

---

#### `atom-structure-video-embed`
- **HE name:** הטמעת וידאו
- **EN name:** Video Embed
- **Category:** structure
- **Usage count:** 3 (homepage §03 YouTube embed, method §12 testimonials carousel with video links, lessons §04)
- **Source files:** `homepage1-3 v2.md §SECTION 03`, `method.md §SECTION 12 DEV NOTES`, `lesons.md §SECTION 04`
- **Variants:** `variant_youtube` (16:9 iframe with thumbnail + play button), `variant_inline-video` (self-hosted mp4 for Hero fallback)
- **Accessibility flags:** `<iframe>` must have `title` attribute; play button keyboard-accessible; captions required for long-form content (WCAG 1.2.2); `loading="lazy"` on iframe
- **D-14 motion:** thumbnail has subtle breathe-fade on hover (opacity 0.9↔1); no continuous loop
- **Responsive notes:** aspect-ratio: 16/9 maintained via CSS; full-width on mobile; RTL layout: play button centered
- **Composes into:** tpl-home, tpl-service, tpl-method

---

#### `atom-structure-page-title`
- **HE name:** כותרת עמוד H1
- **EN name:** Page Title H1
- **Category:** structure
- **Usage count:** 15 (every page has one H1)
- **Source files:** `homepage1-3 v2.md §SECTION 01 H1`, `method.md §SECTION 01 H1`, `treatment.md §SECTION 01 H1`, `sound_healing_final.md §SECTION 01 H1`, `lesons.md §SECTION 01 H1`, `FAQ FINAL.md §SECTION 01`, `MUZZA.md §SECTION 02 H1`, `buy didgeridoo.md §SECTION 01 H1`, all book pages
- **Variants:** `variant_overlay` (white text over hero image/video), `variant_standalone` (ink-colored, on plain background, e.g. inner pages)
- **Accessibility flags:** exactly one H1 per page (WCAG 2.4.6); font-weight 200–300 (Heebo); contrast white-on-overlay >= 4.5:1 checked against dark video overlay; `lang="he"` on root element
- **D-14 motion:** `fade-up` entrance (from opacity 0, translateY 20px, 600ms, animation-delay 0.2s); no continuous loop
- **Responsive notes:** font-size scales: desktop 3.2rem–3.8rem, tablet 2.4rem, mobile 1.8rem; text-align right (RTL); overlay variant needs text-shadow on mobile for legibility
- **Composes into:** every page template

---

### content

---

#### `atom-content-testimonial-card`
- **HE name:** כרטיס עדות
- **EN name:** Testimonial Card
- **Category:** content
- **Usage count:** 5 (homepage §10, method §12, treatment §08, sound-healing §09, lessons §08)
- **Source files:** `homepage1-3 v2.md §SECTION 10`, `method.md §SECTION 12`, `treatment.md §SECTION 08`, `sound_healing_final.md §SECTION 09`, `lesons.md §SECTION 08`
- **Variants:** `variant_text-fb-link` (name as anchor to original FB post, quote text 2–4 lines), `variant_text-image-fb-link` (adds profile photo per decision D1)
- **Accessibility flags:** name link must be descriptive (`aria-label="המלצת שירי אלקבץ בפייסבוק"`); external links open in new tab + `rel="noopener noreferrer"` + icon/text hint ("נפתח בחלון חדש"); image `alt` = full name; do not alter testimonial text (content SSOT)
- **D-14 motion:** carousel/slider: swipe on mobile; auto-advance optional (3s pause); entrance fade-up per card; no breathing loop on individual cards
- **Responsive notes:** desktop: 2–3 cards per row in grid; mobile: 1 card full-width, swipe; name link Terracotta (#A44E2B) with underline-grow hover
- **Composes into:** tpl-home, tpl-service, tpl-method, tpl-book-detail

---

#### `atom-content-faq-item`
- **HE name:** שאלה נפוצה
- **EN name:** FAQ Accordion Item
- **Category:** content
- **Usage count:** 6 (FAQ page §03–§09 with ~36 questions across 4 categories; method §11; treatment §10; sound-healing §08; lessons §09; buy-didgeridoo §08)
- **Source files:** `FAQ FINAL.md §SECTION 03–09`, `method.md §SECTION 11`, `treatment.md §SECTION 10`, `sound_healing_final.md §SECTION 08`, `lesons.md §SECTION 09`, `buy didgeridoo.md §SECTION 08`
- **Variants:** `variant_standalone` (single Q&A accordion), `variant_category-group` (multiple items under H2 category header)
- **Accessibility flags:** `<details>`/`<summary>` or ARIA `role="button"` `aria-expanded`; keyboard-operable (Enter/Space); focus visible on summary; H3 for each question; avoid keyboard trap
- **D-14 motion:** open/close: max-height transition (200ms ease-out); no breathing; content reveals with opacity 0→1
- **Responsive notes:** full-width on all breakpoints; one item open at a time per category; H3 font-size 1rem; answer text font-weight 300; RTL: chevron icon on left side
- **Composes into:** tpl-faq, tpl-service, tpl-method, tpl-shop-item, tpl-book-detail

---

#### `atom-content-book-card`
- **HE name:** כרטיס ספר
- **EN name:** Book Card
- **Category:** content
- **Usage count:** 3 (MUZZA.md §05–§07 — one per book: צבע בכחול, כושי בלאנטיס, וכתבת)
- **Source files:** `MUZZA.md §SECTION 05`, `MUZZA.md §SECTION 06`, `MUZZA.md §SECTION 07`
- **Variants:** `variant_catalog` (cover image + title + 2-line teaser + link to book page), `variant_bundle` (all 3 books grouped with crossed-out price)
- **Accessibility flags:** entire card is a single clickable link — use `<a>` wrapping or `aria-label` on card; cover image `alt` = book title; hover state communicates clickability (cursor: pointer, subtle shadow)
- **D-14 motion:** hover: gentle scale 1.0→1.02 + shadow deepen (200ms); entrance fade-up on scroll into view
- **Responsive notes:** desktop: 3 cols; tablet: 2 cols; mobile: 1 col full-width; RTL: text-align right; cover image left of text on desktop (flipped from LTR convention)
- **Composes into:** tpl-books-catalog (/books page)

---

#### `atom-content-book-detail`
- **HE name:** פרטי ספר
- **EN name:** Book Detail Block
- **Category:** content
- **Usage count:** 3 (vekatavta, kushi_full, eyal_tsva_FINAL — one per book detail page)
- **Source files:** `vekatavta.md §SECTION 02–04`, `kushi_full.md §SECTION 02–03`, `eyal_tsva_FINAL.md §SECTION 02–03`
- **Variants:** `variant_summary` (title + description + cover image), `variant_excerpt` (accordion-revealed story excerpt), `variant_about-author` (short bio in book context)
- **Accessibility flags:** accordion excerpt: same ARIA rules as `atom-content-faq-item`; external purchase links (Mendele, mrng.to) open in new tab with hint; keep original line breaks in excerpt (WCAG 1.4.8)
- **D-14 motion:** excerpt accordion open/close; no breathing loops on book detail
- **Responsive notes:** two-col (cover + text) on desktop collapses to single-col on mobile; cover image full-width on mobile; RTL layout
- **Composes into:** tpl-book-detail

---

#### `atom-content-product-card`
- **HE name:** כרטיס מוצר
- **EN name:** Product Card
- **Category:** content
- **Usage count:** 5 (shop catalog — one per product: didgeridoos, bags, stands-storage, stand-floor, repair)
- **Source files:** `buy didgeridoo.md §SECTION 01`, `bags for didg.md §SECTION 01`, `stend for hanging.md §SECTION 01`, `stend for playing.md §SECTION 01`, `build didg.md §SECTION 01`, `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-05`
- **Variants:** `variant_catalog-tile` (in /shop grid: image + title + price + CTA button), `variant_detail` (hero + full description, used as shop item page hero)
- **Accessibility flags:** price displayed semantically; CTA button has descriptive label (not just "קנה"); keyboard-focusable entire card; image `alt` = product name + brief description
- **D-14 motion:** hover: scale 1.0→1.02 (200ms); entrance fade-up; no breathing loop
- **Responsive notes:** /shop grid: 4 cols desktop, 2 cols tablet, 1 col mobile (per WP-W2-05 AC-05); RTL text alignment
- **Composes into:** tpl-shop-archive (/shop), tpl-shop-item

---

#### `atom-content-service-comparison`
- **HE name:** השוואת שירותים
- **EN name:** Service Comparison Block
- **Category:** content
- **Usage count:** 3 (homepage §04 treatment vs sound-healing, treatment §07, method §03)
- **Source files:** `homepage1-3 v2.md §SECTION 04`, `treatment.md §SECTION 07`, `method.md §SECTION 03`
- **Variants:** `variant_two-col` (side-by-side: treatment vs sound-healing), `variant_three-col` (treatment vs sound-healing vs lessons on method page)
- **Accessibility flags:** comparison tables use `<table>` or `role="table"` with `scope="col/row"`; accessible column headers; each column link has descriptive anchor text
- **D-14 motion:** fade-up entrance per column on scroll; no continuous loop
- **Responsive notes:** two-col collapses to stacked single-col on mobile; three-col collapses to accordion on mobile; RTL: columns order unchanged (content logic-based, not position-based)
- **Composes into:** tpl-home, tpl-service, tpl-method

---

#### `atom-content-bio-block`
- **HE name:** בלוק ביוגרפי
- **EN name:** Bio / About Block
- **Category:** content
- **Usage count:** 5 (homepage §11, method §08, treatment §11, lessons §07, MUZZA §03.5)
- **Source files:** `homepage1-3 v2.md §SECTION 11`, `method.md §SECTION 08`, `treatment.md §SECTION 11`, `lesons.md §SECTION 07`, `MUZZA.md §SECTION 03.5`
- **Variants:** `variant_brief` (2–4 lines + portrait image), `variant_extended` (full biography with internal links to moksha, method, treatment)
- **Accessibility flags:** portrait image `alt` = "אייל עמית"; if a placeholder is used instead of image, require `<span class="ea-bio-block__portrait-placeholder" role="img" aria-label="תמונת אייל עמית">`; decorative separators `aria-hidden`; internal links have descriptive anchor text
- **D-14 motion:** portrait image breathe-fade (opacity 0.94↔1, 5.5s loop — same as nav brand); section entrance fade-up
- **Responsive notes:** image + text side-by-side on desktop; stacked on mobile; RTL: image on right, text on left on desktop
- **Composes into:** tpl-home, tpl-service, tpl-method, tpl-books-catalog

---

#### `atom-content-press-item`
- **HE name:** פריט כתבה
- **EN name:** Press / Article List Item
- **Category:** content
- **Usage count:** 1 (/press or /about section — WP-W2-07)
- **Source files:** `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-07 Scope IN`; source press content: migrated from existing site
- **Variants:** `variant_list-item` (date + headline + external link)
- **Accessibility flags:** external links open new tab + `rel="noopener"`; date uses `<time datetime="">` element; link text descriptive (not "לחצ כאן")
- **D-14 motion:** entrance fade-up only; no continuous animation
- **Responsive notes:** list stacks vertically on all breakpoints; date right-aligned on desktop (RTL natural), left (RTL) on mobile
- **Composes into:** tpl-press (part of /about or /press page)

---

#### `atom-content-mokesh-block`
- **HE name:** בלוק מוקש
- **EN name:** Mokesh Dahiman Block
- **Category:** content
- **Usage count:** 2 (/about/moksha page per WP-W2-07; referenced in method §07, treatment §02 as link)
- **Source files:** `method.md §SECTION 07` (reference), `treatment.md §SECTION 02` (reference), `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-07 Scope IN`; docx: `ומה היום.docx` (referenced, not readable)
- **Variants:** `variant_page` (full /about/moksha page with text + photo), `variant_inline-reference` (short inline mention with link, used in method/treatment)
- **Accessibility flags:** photo `alt` = "מוקש דהימן — מאסטר לדיג'רידו"; external Wikipedia/archive links open new tab; page title H1 = "מוקש דהימן"
- **D-14 motion:** entrance fade-up; bio portrait breathe-fade (same as bio-block)
- **Responsive notes:** full-width on mobile; text after image on all breakpoints; RTL layout
- **Composes into:** tpl-about-moksha, tpl-method (inline reference), tpl-treatment (inline reference)

---

### interaction

---

#### `atom-interaction-faq-filter`
- **HE name:** סינון שאלות נפוצות
- **EN name:** FAQ Category Filter
- **Category:** interaction
- **Usage count:** 2 (/faq full page with 4 categories; per-service-page embedded FAQ filtered view)
- **Source files:** `FAQ FINAL.md §SECTION 03–09` (4 categories: טיפול, שיעורים, סאונד הילינג, cbDIDG + כלליות), `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-02 AC-03`
- **Variants:** `variant_tab-bar` (category tabs, URL-state `?cat=treatment`), `variant_inline-filtered` (service-page embed showing only matching category)
- **Accessibility flags:** tabs use `role="tablist"` / `role="tab"` / `aria-selected`; keyboard: arrow keys navigate tabs, Enter/Space activates; URL state update for direct linking; `aria-controls` connects tab to panel
- **D-14 motion:** tab switch: crossfade (opacity 0→1, 200ms); no breathing; active tab indicator has Terracotta underline
- **Responsive notes:** desktop: horizontal tab bar; mobile: dropdown or vertically stacked category headers; RTL: tabs read right-to-left
- **Composes into:** tpl-faq, tpl-service (embedded, filtered)

---

#### `atom-interaction-whatsapp-cta`
- **HE name:** כפתור וואטסאפ
- **EN name:** WhatsApp CTA
- **Category:** interaction
- **Usage count:** varies (A/B test across all pages — per-session random assignment; floats on every page)
- **Source files:** `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-01 B Scope §4`, `DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md §B3–B4`
- **Variants:** `variant_A` (contact form only — no WhatsApp), `variant_B` (form + WhatsApp button together), `variant_C` (WhatsApp only — no form)
- **Accessibility flags:** WhatsApp link must include `aria-label="שלח הודעה בוואטסאפ"` + external link hint; button contrast baseline uses white text on `#0F7A3F` (hover `#0C6A37`); keyboard-focusable; GA4 event on click with `variant_label`
- **D-14 motion:** floating pill has `breathe-pulse` (scale 1.0↔1.005, 8s loop — same as CTA pill); hover: slight shadow deepen + color lighten
- **Responsive notes:** floating variant: fixed bottom-left (RTL natural) on mobile; inline variant: full-width button on mobile; WhatsApp number: 052-4822842
- **Composes into:** every page template as floating element; tpl-contact as inline variant

---

#### `atom-interaction-contact-form`
- **HE name:** טופס צור קשר
- **EN name:** Contact Form (CF7 Wrapper)
- **Category:** interaction
- **Usage count:** 1 (/contact page) + embedded on service CTAs
- **Source files:** `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-01 B Scope §3`, `DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md §B1–B2`
- **Variants:** `variant_minimal-balanced` (name + phone/email + subject dropdown [optional] + message), `variant_inline-cta` (name + phone only, embedded in section bottom)
- **Accessibility flags:** all fields have associated `<label>`; error states use `aria-describedby`; required fields marked with `aria-required="true"`; success/error messages announced via `aria-live="polite"`; SMTP via WP Mail SMTP free plugin; sends to info@eyalamit.co.il
- **D-14 motion:** field focus: subtle Terracotta bottom-border grow (200ms); submit button has `breathe-pulse` identical to CTA pill; success state: fade-in confirmation
- **Responsive notes:** single-column on mobile; submit button full-width on mobile; RTL: labels right-aligned; dropdown subject values: 7 topics per decision B2
- **Composes into:** tpl-contact, tpl-service (embedded)

---

#### `atom-interaction-sound-toggle`
- **HE name:** כפתור השמע
- **EN name:** Sound Toggle
- **Category:** interaction
- **Usage count:** 1 (Hero section, top-nav area — all pages that have the Hero)
- **Source files:** `hero-c-fbw-sketch.html §.sound-toggle`, `D-EYAL-DESIGN-DIRECTION-FBW-DEEP-2026-05-26.md §2.5`, `DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md §A4`
- **Variants:** `variant_default-off` (shows "שמע" icon/label; default state is muted), `variant_on` (shows speaker icon active, sand-colored border per sketch)
- **Accessibility flags:** `<button>` with dynamic `aria-label` ("הפעל צליל" / "השתק צליל"); state reflected in `aria-pressed`; keyboard: Space/Enter toggles; audio must not start without user interaction (browser policy); recording of didgeridoo sound from Eyal (per A4)
- **D-14 motion:** icon transition on toggle: opacity crossfade (150ms); button border-color transition to var(--sand) when active (per sketch)
- **Responsive notes:** positioned in top-nav on desktop; on mobile: smaller pill, same top-nav position; hidden if no audio loaded (degrade gracefully)
- **Composes into:** `atom-nav-topnav` (composited within navigation atom)

---

#### `atom-interaction-testimonials-carousel`
- **HE name:** קרוסלה עדויות
- **EN name:** Testimonials Carousel
- **Category:** interaction
- **Usage count:** 5 (homepage §10, method §12, treatment §08, sound-healing §09, lessons §08)
- **Source files:** `homepage1-3 v2.md §SECTION 10 DEV NOTES`, `sound_healing_final.md §SECTION 09 DEV NOTES`, `lesons.md §SECTION 08 DEV NOTES`, `treatment.md §SECTION 08 DEV NOTES`
- **Variants:** `variant_autoplay` (slow auto-advance + manual control), `variant_manual-only` (swipe/click only, no autoplay)
- **Accessibility flags:** carousel wrapper `role="region"` `aria-label="עדויות"`; prev/next buttons with `aria-label`; `aria-live="polite"` on active card; autoplay pauses on focus or hover (WCAG 2.2.2); keyboard: arrow keys navigate cards
- **D-14 motion:** slide transition: horizontal slide with opacity crossfade; no breathing on individual cards; scroll indicator dots use Terracotta for active
- **Responsive notes:** desktop: 2–3 cards visible; mobile: 1 card full-width + swipe gesture; pagination dots below; "קרא עוד" truncation on long testimonials
- **Composes into:** tpl-home, tpl-service, tpl-method, tpl-book-detail

---

#### `atom-interaction-book-excerpt-accordion`
- **HE name:** אקורדיון קטע מספר
- **EN name:** Book Excerpt Accordion
- **Category:** interaction
- **Usage count:** 3 (one per book detail page: vekatavta, kushi, tsva)
- **Source files:** `vekatavta.md §SECTION 03 DEV NOTES`, `kushi_full.md §SECTION 03 DEV NOTES`, `eyal_tsva_FINAL.md §SECTION 03 DEV NOTES`
- **Variants:** `variant_closed-default` (button "קטע מתוך הספר — לקריאה", opens on click), `variant_open-default` (for QR landing pages that deep-link to excerpt)
- **Accessibility flags:** `<details>`/`<summary>` or `role="button"` `aria-expanded`; preserve exact original line breaks (DEV NOTE: no justify auto); no rewrite of source text; keyboard-operable; focus management on open (scroll to content start)
- **D-14 motion:** max-height ease-out 300ms; opacity 0→1 on open; no breathing
- **Responsive notes:** 12–14 words per line (CSS max-width control); full-width mobile; text-align right (RTL); font-size 0.9rem for excerpt readability
- **Composes into:** tpl-book-detail

---

### feedback

---

#### `atom-feedback-cta-pill`
- **HE name:** כפתור CTA ראשי
- **EN name:** Primary CTA Pill
- **Category:** feedback
- **Usage count:** 12 (every page — hero CTA, section CTAs, closing CTA; appears on homepage §01, §06, §09, §12; treatment §13; method §14; sound-healing §10; lessons §10; all book pages; shop pages)
- **Source files:** `homepage1-3 v2.md §SECTION 01 CTA`, `treatment.md §SECTION 13`, `method.md §SECTION 14`, `sound_healing_final.md §SECTION 10`, `hero-c-fbw-sketch.html §.hero-cta`, `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-01`
- **Variants:** `variant_primary` (Terracotta bg, white text, border-radius 100px), `variant_ghost` (transparent + Terracotta border, used on dark backgrounds), `variant_contact-link` (links to /contact), `variant_whatsapp` (WhatsApp deep-link)
- **Accessibility flags:** `<a>` or `<button>` (not div/span); minimum 44x44px touch target; descriptive text (not "לחץ כאן"); contrast: white on Terracotta (#A44E2B) = 4.62:1 — passes AA; focus-visible ring
- **D-14 motion:** continuous `breathe-pulse` (scale 1.0↔1.005, 8s, ease-in-out — per hero-c-fbw-sketch.html); hover: scale 1.0→1.03 + shadow (200ms); `prefers-reduced-motion` removes pulse, keeps hover
- **Responsive notes:** full-width on mobile; min-width 200px on desktop; padding: 14px 32px; font-weight 300 (Heebo); RTL: text reads right-to-left naturally
- **Composes into:** every page template

---

#### `atom-feedback-price-display`
- **HE name:** הצגת מחיר
- **EN name:** Price Display
- **Category:** feedback
- **Usage count:** 4 (/shop catalog cards + MUZZA.md §08 bundle price with strikethrough)
- **Source files:** `MUZZA.md §SECTION 08` (bundle: 150 ₪ במקום ~~207 ₪~~), `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-05 AC-03`, `DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md §C3`
- **Variants:** `variant_current` (plain price in ₪), `variant_sale` (struck-through original + highlighted current price), `variant_inquiry` (text "מחיר לפי התאמה" when price not yet set)
- **Accessibility flags:** struck-through price must have `aria-label` explaining it's the original price (screen readers say "207 שקלים מחיר מקורי, כעת 150 שקלים"); `<s>` or `<del>` element for strikethrough; no color-only distinction for sale price
- **D-14 motion:** no animation on price; subtle fade-in on page load as part of product card entrance
- **Responsive notes:** price inline with product title on catalog; larger and prominent on product detail page; RTL: ₪ symbol position per Israeli convention (after number: 150 ₪)
- **Composes into:** `atom-content-product-card`, `atom-content-book-card` (bundle)

---

#### `atom-feedback-green-invoice-cta`
- **HE name:** כפתור רכישה חיצוני
- **EN name:** Green Invoice Purchase CTA
- **Category:** feedback
- **Usage count:** 4 (3 book detail pages + MUZZA bundle; 5 shop product pages)
- **Source files:** `MUZZA.md §SECTION 10`, `vekatavta.md §SECTION 06`, `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-03 AC-03`, `DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md §C1`
- **Variants:** `variant_book-purchase` (links to mrng.to or mendele.co.il, opens new tab), `variant_shop-contact` (links to /contact for shop items — no direct cart)
- **Accessibility flags:** external link: new tab + `rel="noopener noreferrer"` + "(נפתח בחלון חדש)" text or `aria-label`; GA4 event on click per WP-W2-03 AC-03; button text descriptive ("לרכישת הספר / לרכישה")
- **D-14 motion:** same as `atom-feedback-cta-pill` `variant_primary` — `breathe-pulse` active; hover scale
- **Responsive notes:** full-width button on mobile; centered on desktop; opens external URL in new tab
- **Composes into:** tpl-book-detail, tpl-shop-item, `atom-content-book-card`

---

#### `atom-feedback-disclaimer`
- **HE name:** כתב ויתור
- **EN name:** Medical Disclaimer
- **Category:** feedback
- **Usage count:** 2 (treatment.md §12; FAQ FINAL.md §SECTION 07 mentions medical advice context)
- **Source files:** `treatment.md §SECTION 12`
- **Variants:** `variant_footer-style` (small gray text block, non-intrusive, bottom of treatment/method pages)
- **Accessibility flags:** font-size minimum 0.75rem; Earth (#8A5A44) on bg-alt (#F3EEE8) — verify 3:1 ratio (large text AA); `role="note"` or `aria-label="הגבלת אחריות רפואית"`
- **D-14 motion:** no animation; static block
- **Responsive notes:** full-width on all breakpoints; text-align right (RTL); max-width 700px centered; does not float or overlap other content
- **Composes into:** tpl-service (treatment, method), tpl-faq

---

### nav

---

#### `atom-nav-topnav`
- **HE name:** ניווט עליון
- **EN name:** Top Navigation Bar
- **Category:** nav
- **Usage count:** 15 (every page)
- **Source files:** `hero-c-fbw-sketch.html §nav.topnav`, `D-EYAL-DESIGN-DIRECTION-FBW-DEEP-2026-05-26.md §2.4 Hero Video spec`, `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-01`
- **Variants:** `variant_overlay` (fixed, semi-transparent dark bg with backdrop-filter blur, over Hero video), `variant_solid` (bg-alt, for inner pages without Hero video)
- **Accessibility flags:** `<nav>` with `aria-label="ניווט ראשי"`; skip-to-content link as first focusable element (WCAG 2.4.1); keyboard navigation through all links; hamburger menu for mobile with `aria-expanded`; focus-visible ring on all nav links; contains `atom-interaction-sound-toggle`
- **D-14 motion:** brand text has `breathe-fade` (opacity 0.94↔1, 5.5s per sketch); nav links: underline grows from center on hover (300ms); nav background transitions on scroll (transparent → blur bg)
- **Responsive notes:** desktop: horizontal links right-to-left (RTL); height 64px; mobile: hamburger menu, full-screen overlay or dropdown; height 56px mobile; logo left (RTL: logo right)
- **Composes into:** every page template as fixed overlay

---

#### `atom-nav-breadcrumb`
- **HE name:** נתיב ניווט
- **EN name:** Breadcrumb
- **Category:** nav
- **Usage count:** 4 (book detail pages /books/*, shop item pages /shop/* — nested pages needing location context)
- **Source files:** `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-03`, `DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md §F3`, `MUZZA.md §SECTION 01 DEV NOTES`
- **Variants:** `variant_standard` (Home > Books > שם ספר, RTL right-to-left reading), `variant_compact` (parent only: ← חזרה לספרים)
- **Accessibility flags:** `<nav aria-label="נתיב ניווט">` with `<ol>` list; `aria-current="page"` on last item; separators `aria-hidden="true"`; Structured Data (`BreadcrumbList` schema.org)
- **D-14 motion:** no animation; static; hover link color shift (Terracotta)
- **Responsive notes:** hidden on mobile (too cramped) — use compact variant; shown on tablet+; RTL: text direction right-to-left, separators match (> becomes <)
- **Composes into:** tpl-book-detail, tpl-shop-item

---

#### `atom-nav-scroll-progress`
- **HE name:** מד גלילה
- **EN name:** Scroll Progress Indicator
- **Category:** nav
- **Usage count:** 1 (long-form pages: method, treatment — per D-14 §2.6)
- **Source files:** `D-EYAL-DESIGN-DIRECTION-FBW-DEEP-2026-05-26.md §2.6`, `hero-c-fbw-sketch.html`
- **Variants:** `variant_top-line` (1px line at top edge, Terracotta, opacity 0.4, grows with scroll width)
- **Accessibility flags:** decorative — `aria-hidden="true"`; must not interfere with top-nav; `prefers-reduced-motion` removes the indicator entirely (replaces with nothing)
- **D-14 motion:** width transitions smoothly with `scroll-driven-animations` or JS `scrollY`; color Terracotta (#A44E2B); opacity 0.4 static (per D-14 spec)
- **Responsive notes:** shown on desktop and tablet; hidden on mobile (viewport too narrow for meaningful display); 1px height — does not affect layout
- **Composes into:** tpl-method, tpl-treatment, tpl-service (long pages)

---

### data-display

---

#### `atom-data-display-footer-social`
- **HE name:** פוטר רשתות חברתיות
- **EN name:** Footer Social Row
- **Category:** data-display
- **Usage count:** 15 (site-wide footer on every page)
- **Source files:** `hub/data/social-channels.json` (FB: didgeridoo.studio.eyal.amit; IG: didgeridoo.therapy.center; YT: @איילעמית; TT: pending), `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-01 B §5`, `DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md §D4`
- **Variants:** `variant_with-tiktok` (4 icons — when TikTok URL received from Eyal), `variant_without-tiktok` (3 icons — current state per canonical data)
- **Accessibility flags:** each social link: `<a>` with `aria-label="[Platform] של אייל עמית"` (e.g., "פייסבוק של אייל עמית"); SVG icons `aria-hidden="true"`; external links new tab + `rel="noopener noreferrer"`; footer location text uses `rgba(255,255,255,0.85)` and rights copy uses `rgba(255,255,255,0.78)` for readable contrast on Ink background
- **D-14 motion:** icon hover: subtle opacity 0.7→1 (150ms); no breathing loop
- **Responsive notes:** horizontal row on desktop; same row (smaller gap) on mobile; RTL: icons read right-to-left (FB, IG, YT, TT order from right); footer also includes: logo, studio location (פרדס חנה), rights, /faq link per WP-W2-01
- **Composes into:** `atom-structure-footer` (site footer partial)

---

#### `atom-data-display-blog-card`
- **HE name:** כרטיס בלוג
- **EN name:** Blog Post Card
- **Category:** data-display
- **Usage count:** 2 (/blog archive, category pages — 54 posts per WP-W2-06)
- **Source files:** `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-06`, `DECISION_EYAL_MEETING_CLOSURE_2026-05-26_v1.md §D3`
- **Variants:** `variant_archive-tile` (thumbnail + date + category + title + excerpt 2 lines), `variant_single-post` (full post layout with author, date, tags, categories — tpl-blog-single)
- **Accessibility flags:** `<article>` element; `<time datetime="">` for post date; category links descriptive; post thumbnail `alt` = post title (or empty if purely decorative); pagination uses `aria-label` on nav
- **D-14 motion:** entrance fade-up per card on scroll; hover: gentle shadow + scale 1.0→1.01 (150ms); no breathing loop
- **Responsive notes:** archive grid: 3 cols desktop, 2 tablet, 1 mobile; pagination below grid; RTL: read right-to-left; `/blog/` archive AC-04: pagination + category filter
- **Composes into:** tpl-blog-archive (/blog), tpl-blog-single

---

#### `atom-data-display-qr-page`
- **HE name:** עמוד QR
- **EN name:** QR Landing Page
- **Category:** data-display
- **Usage count:** 49 (/qr/qr1/ through /qr/qr49/ — all book "וכתבת" QR pages; source: QR-URL-INVENTORY.csv)
- **Source files:** `docs/project/team-100-preplanning/QR-URL-INVENTORY.csv` (49 rows, verified live), `vekatavta.md §SECTION 02` (QR described: "בסיום כל סיפור יש קוד QR ייחודי שמוביל לעמוד נסתר עם המשך לסיפור, וידאו או תמונה"), `WAVE2-WORK-PACKAGES-LOD200-2026-05-26.md §WP-W2-07 Scope IN`
- **Variants:** `variant_story-continuation` (text continuation of book story), `variant_media` (video or image gallery related to story), `variant_comment-cta` (option to respond/ask Eyal a question)
- **Accessibility flags:** page is `noindex` (per QR-URL-INVENTORY notes); each page has unique H1 matching QR story title; images alt text; external video embeds with title; lock_url=YES (must not change slug — printed in physical book)
- **D-14 motion:** minimal — entrance fade only; no breathing (these pages are text/media focused, not brand experience pages)
- **Responsive notes:** mobile-first (QR codes scanned on phone); single column; clean minimal layout; no top navigation or footer needed (can include minimal footer with link back to site)
- **Composes into:** tpl-qr-page (standalone, not part of main nav tree)

---

## 2. Cross-reference: Wave2 WP → atoms

### W2-01 — תשתית עיצוב D-14 + טופס + פוטר + Analytics

- `atom-structure-hero-video` (breathing lines overlay, sound toggle, pause button)
- `atom-structure-breath-divider` (CSS keyframes defined here as shared primitives)
- `atom-feedback-cta-pill` (breathing scale CSS defined here)
- `atom-interaction-sound-toggle` (component + audio asset)
- `atom-interaction-whatsapp-cta` (A/B variants A/B/C + GA4 event)
- `atom-interaction-contact-form` (CF7 + SMTP)
- `atom-data-display-footer-social` (footer partial with FB/IG/YT; TT pending)
- `atom-structure-page-title` (D-14 tokens: typography, fade-up animation)
- `atom-nav-topnav` (nav with sound-toggle composited)
- `atom-nav-scroll-progress` (D-14 §2.6)

---

### W2-02 — ליבת תוכן: בית + שיטה + טיפול + אודות + FAQ + צור קשר

- `atom-structure-hero-video` (homepage, method, treatment)
- `atom-structure-section-intro` (all 3 service pages)
- `atom-structure-content-section` (method §04–§10, treatment §05–§07)
- `atom-structure-breath-divider` (between sections on all 3 pages)
- `atom-content-service-comparison` (homepage §04, treatment §07, method §03)
- `atom-content-testimonial-card` (homepage §10, method §12, treatment §08)
- `atom-interaction-testimonials-carousel` (homepage §10, method §12, treatment §08)
- `atom-content-faq-item` (FAQ page — 4 categories, ~36 items)
- `atom-interaction-faq-filter` (FAQ page + embedded on service pages)
- `atom-content-bio-block` (homepage §11, method §08, treatment §11)
- `atom-feedback-cta-pill` (homepage §01 §06 §09 §12, method §14, treatment §13)
- `atom-interaction-contact-form` (/contact page)
- `atom-feedback-disclaimer` (treatment §12)
- `atom-structure-page-title` (all 6 pages)
- `atom-nav-topnav` (all 6 pages)
- `atom-nav-breadcrumb` (not needed on core pages — flat hierarchy)

---

### W2-03 — מוזה הוצאה לאור + 3 עמודי ספרים

- `atom-structure-hero-video` (`variant_still` — book cover image hero)
- `atom-structure-section-intro` (MUZZA §03 intro, per-book intro)
- `atom-content-book-card` (MUZZA §05–§07 — 3 book cards in catalog)
- `atom-content-book-detail` (each book detail page)
- `atom-interaction-book-excerpt-accordion` (each book detail page §03)
- `atom-feedback-cta-pill` (catalog CTA to bundle)
- `atom-feedback-green-invoice-cta` (per-book purchase button)
- `atom-feedback-price-display` (bundle: 150 ₪ / 207 ₪ crossed out)
- `atom-content-bio-block` (MUZZA §03.5)
- `atom-content-faq-item` (book detail Q&A sections)
- `atom-content-testimonial-card` (book pages — if applicable)
- `atom-nav-breadcrumb` (/books/* pages)
- `atom-structure-gallery` (vekatavta §05 gallery)
- `atom-structure-page-title` (all 4 pages)
- `atom-structure-breath-divider` (between sections)

---

### W2-04 — סאונד הילינג + שיעורי נגינה

- `atom-structure-hero-video` (sound-healing §01, lessons §01)
- `atom-structure-section-intro` (sound-healing §02, lessons §02)
- `atom-structure-content-section` (sound-healing §03–§07, lessons §05)
- `atom-structure-gallery` (sound-healing tipi/studio photos §05)
- `atom-content-service-comparison` (referenced in both pages)
- `atom-content-testimonial-card` (sound-healing §09, lessons §08)
- `atom-interaction-testimonials-carousel` (sound-healing §09, lessons §08)
- `atom-content-faq-item` (sound-healing §08, lessons §09)
- `atom-interaction-faq-filter` (embedded filtered FAQ per service)
- `atom-content-bio-block` (lessons §07)
- `atom-feedback-cta-pill` (sound-healing §10, lessons §10)
- `atom-interaction-whatsapp-cta` (A/B per service page)
- `atom-structure-breath-divider` (between sections)
- `atom-structure-page-title` (2 pages)

---

### W2-05 — שופ: 4 מוצרים + תיקון + עמוד `/shop` אחוד

- `atom-content-product-card` (all 5 product pages + /shop grid)
- `atom-structure-hero-video` (`variant_still` — product photo hero)
- `atom-structure-section-intro` (all 5 product pages)
- `atom-structure-content-section` (product detail sections)
- `atom-structure-gallery` (bags §09 photo grid)
- `atom-feedback-price-display` (shop catalog cards + product pages)
- `atom-feedback-green-invoice-cta` (purchase button per product)
- `atom-content-faq-item` (buy-didgeridoo §08, bags §08)
- `atom-content-testimonial-card` (buy-didgeridoo §09)
- `atom-interaction-whatsapp-cta` (A/B per shop page)
- `atom-feedback-cta-pill` (/shop page + product CTAs)
- `atom-nav-breadcrumb` (/shop/* pages)
- `atom-structure-page-title` (6 pages)
- `atom-structure-breath-divider` (between sections)

---

### W2-06 — מיגרציית בלוג: 54 פוסטים + 6 קטגוריות + 126 תגיות

- `atom-data-display-blog-card` (`variant_archive-tile` for /blog archive, `variant_single-post` for individual posts)
- `atom-structure-page-title` (archive page + each post)
- `atom-nav-topnav` (all blog pages)
- `atom-structure-breath-divider` (between sections on long posts)
- `atom-structure-video-embed` (posts that include YouTube embeds)
- `atom-feedback-cta-pill` (end-of-post CTA to /contact)

---

### W2-07 — כתבות עיתונות + עמוד מוקש + 49 QR + עדויות FB live

- `atom-content-press-item` (/press section — date + headline + link)
- `atom-content-mokesh-block` (/about/moksha page)
- `atom-data-display-qr-page` (49 QR landing pages)
- `atom-content-testimonial-card` (`variant_text-image-fb-link` — 30+ testimonials with FB profile photo per D1)
- `atom-structure-page-title` (moksha page, press page)
- `atom-structure-section-intro` (moksha page intro)
- `atom-feedback-cta-pill` (moksha page CTA to /contact)

---

### W2-08 — עמוד EN — תמצית האתר באנגלית

- `atom-structure-hero-video` (EN landing hero — same structure, EN content)
- `atom-structure-section-intro` (EN variant — same atom, `lang="en"` context)
- `atom-content-bio-block` ("About Eyal" section in EN)
- `atom-content-service-comparison` (services overview in EN)
- `atom-content-testimonial-card` (translated testimonials)
- `atom-feedback-cta-pill` (CTA → /contact?lang=en)
- `atom-structure-page-title` (EN H1)
- `atom-structure-breath-divider` (between EN sections)
- **Note:** EN atoms are structurally identical to HE atoms with `dir="ltr"` and `lang="en"` on the page wrapper — no structurally distinct EN-specific atoms needed

---

### W2-09 — סינון מדיה + יישום 301 + cutover preparation

- No new atoms produced; this WP validates that all atoms render correctly after media transfer and 301 redirects
- `atom-data-display-qr-page` (49 QR URLs verified live — no slug change)
- `atom-data-display-footer-social` (verify social URLs resolve post-cutover)
- `atom-feedback-cta-pill` (verify all CTAs link correctly post-301)

---

## 3. Gaps / open questions

### 3.1 Confirmed gaps (not yet resolvable from sources)

| # | Gap | Reason | Resolution path |
|---|-----|---------|-----------------|
| G1 | **Hero video asset** — no actual video file exists yet | Eyal to supply per decision A3; placeholder CSS animation in place | WP-W2-01 placeholder until video received |
| G2 | **Sound toggle audio file** — no recording asset in repo | Eyal must provide didgeridoo recording per A4 | team_40 to collect from Eyal |
| G3 | **TikTok URL** — not yet provided by Eyal | status: `pending_url_from_eyal` in social-channels.json | `atom-data-display-footer-social` `variant_without-tiktok` active until received |
| G4 | **Green Invoice URLs** per book (3 specific purchase links) | Eyal confirmed existence of links; not yet in repo | Required before WP-W2-03 goes live |
| G5 | **Mokesh page content** (`ומה היום.docx`) — .docx not readable in this scan | Cannot extract Hebrew content from binary; filename referenced only | team_30 to extract and convert to .md |
| G6 | **Product prices** — not set in source files | Eyal to enter via WP admin per C3 | `atom-feedback-price-display` `variant_inquiry` as default |
| G7 | **30+ testimonial profile photos** — FB image hosting | FB CDN hot-link blocked; images must be downloaded | WP-W2-07: team_40 to download and store in /uploads/ |

### 3.2 Structural ambiguities resolved

- **EN landing page atoms:** No separate EN atoms required — same atom set with `dir="ltr"` page context. Confirmed by W2-08 scope ("תמצית האתר בעמוד אחד").
- **QR page vs content atoms:** QR pages reuse standard content structure but with minimal chrome (no full nav/footer required) — `atom-data-display-qr-page` captures this distinct behavior adequately.
- **Blog single vs archive:** Both captured in `atom-data-display-blog-card` with two variants — structural difference is template context, not atom definition.
- **Cursor dot (D-14 §2.6):** Deferred (per A5 — "נדחה"). No atom created for cursor.

### 3.3 Self-verification against acceptance criteria

- [x] **AC-1:** Total = 32 atoms — within 20–40 range.
- [x] **AC-2:** All IDs unique, kebab-case, `atom-<category>-<name>` format.
- [x] **AC-3:** All 32 atoms have all 9 required fields filled (no TBD, no blank).
- [x] **AC-4:** Every atom traces to at least one source file by filename.
- [x] **AC-5:** All 9 Wave2 WPs covered in §2 cross-reference.
- [x] **AC-6:** Hebrew labels are real Hebrew (not transliteration) on all 32 atoms.
