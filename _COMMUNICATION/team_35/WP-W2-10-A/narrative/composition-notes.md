# Composition Notes — WP-W2-10-A (Service cluster)

**Team:** team_35 (Design Studio, claude-design) · **Stage:** S1 (hi-fi mockup) · **Date:** 2026-05-31
**Primary mockup:** `../mockup/service-treatment.html` (route `/treatment`)
**Source of atoms/tokens:** D-14 — `ea-tokens.css` + `ea-atoms.css` (cited, never redefined).
**Composition-only** — every element below is an existing D-14 atom assembled per the `tpl-service.php` slot map. No new atoms, no new token values.

---

## 1. Slot map → atom binding (tpl-service.php)

`tpl-service.php` declares 3 explicit SLOT comments (`hero-content`, `intro-text`, `body-sections`) plus the implicit archetype slots from the LOD400 spec (`hero, intro, body-sections, faq-filter, testimonials, cta-pill, footer`). The mockup wires all 7:

| Slot | D-14 atom (class) | Section in mockup |
|------|-------------------|-------------------|
| hero-content | `atom-structure-hero-video` → `.ea-hero` + `.ea-hero__gradient-bg` (variant_placeholder) | `<section class="ea-hero">` |
| intro-text | `atom-structure-section-intro` → `.ea-section-intro` | "משהו בנשימה שלך מבקש תשומת לב" |
| body-sections | `atom-structure-content-section` → `.ea-content-section` | "מה זה טיפול בדיג׳רידו" |
| body-sections | pillars-grid → `.ea-pillars-grid` / `.ea-pillar` | "למי זה מתאים" |
| body-sections | `atom-content-bio-block` → `.ea-bio-block` | "איך נראה מפגש" (+ real portrait) |
| body-sections | service-comparison → `.ea-service-comparison` | "מה ההבדל בין טיפול…" |
| testimonials | `atom-content-testimonial-card` → `.ea-testimonials-section` / `.ea-testimonial-card` | "אנשים מספרים" |
| faq-filter | `atom-content-faq-item` → `.ea-faq-mini-section` / `.ea-faq-item` | "שאלות נפוצות" (mini) |
| cta-pill | `atom-feedback-cta-pill` → `.ea-section--cta` + `.ea-cta-pill--primary` | "לתיאום שיחת היכרות" |
| (chrome) | `atom-nav-topnav` `.ea-topnav` · `atom-interaction-sound-toggle` `.ea-sound-toggle` · `atom-interaction-whatsapp-cta` `.ea-whatsapp-float` · `atom-data-display-footer-social` `.ea-footer` | header/float/footer |
| (rhythm) | `atom-structure-breath-divider` `.ea-breath-divider` | between intro and body |

---

## 2. Screen-by-screen composition (/treatment)

### 2.1 Top nav — `atom-nav-topnav`
Fixed translucent dark bar (`rgba(46,43,40,0.72)` + `blur(8px)`), brand right, links inline, `aria-current="page"` on **טיפול**. Sound-toggle + burger in `.ea-topnav__controls`. Skip-link (`.ea-skiplink`) is the first focusable element — required by the atom contract for a11y.

### 2.2 Hero — `atom-structure-hero-video` (variant_placeholder)
Full-viewport (`86vh`, `min-height:640px`) on the **CSS-gradient placeholder** `.ea-hero__gradient-bg` — no per-route hero photo/video exists yet (see asset manifest). 3 decorative `breath-line`s. Real H1 "טיפול בדיג׳רידו" + real subtitle. `.ea-hero__trust` line is **composed** from on-page facts (studio location, 1-on-1, cbDIDG) — flagged Q1. Single primary `.ea-cta-pill--primary` → /contact.
*Spacing:* hero owns the fold; first content section opens at `--ea-section-padding` (120px) for a calm entry.

### 2.3 Intro — `atom-structure-section-intro`
Prose-width (960px), `--ea-type-body-lg` rhythm via `.ea-section-intro__body` (1.05rem / 1.9). 3 verbatim paragraphs. This is the emotional "hook" before explanation — block order intentionally: *feeling → definition → fit → logistics → disambiguation → proof → answers → ask.*

### 2.4 Breath divider — `atom-structure-breath-divider`
Single hairline (`--ea-line`) to breathe between the lyrical intro and the explanatory body. Decorative, `aria-hidden`.

### 2.5 "מה זה" — `atom-structure-content-section`
Default `--ea-bg`. Verbatim 3 paragraphs.

### 2.6 "למי זה מתאים" — pillars-grid (alt bg)
The 5 verbatim bullets are promoted from a flat `<ul>` into the `.ea-pillars-grid` / `.ea-pillar` atom (2-col → 1-col mobile) for scannability. Each `.ea-pillar__label` is a **2–3 word kicker** derived from its bullet (not new copy — a label of the existing line); full verbatim line sits in `.ea-pillar__text`. Flagged Q2. Background `--ea-content-section--alt` (`--ea-bg-alt`) to separate from §2.5.

### 2.7 "איך נראה מפגש" — `atom-content-bio-block`
2-col (content + 320px figure). Uses the **real** theme asset `assets/home/eyal-portrait-hero.jpg` in `.ea-bio-block__portrait`. On mobile the figure stacks first (atom's built-in order swap). Conveys the physical studio/space described in the copy.

### 2.8 "מה ההבדל" — service-comparison (treatment-overview)
The atom CSS ships a 2-col `.ea-service-comparison__grid`; the page content is a **3-way** comparison (treatment / sound-healing / lessons). I render 3 `.ea-service-comparison__col` cards in the same grid (the `1px gap on --ea-line` hairline pattern is identical; only the column count differs, set inline in the mockup `:root`-scoped style). **No new atom** — same class, same visual language. Flagged Q4 for team_10: confirm whether `.ea-service-comparison__grid` should gain a 3-col modifier at S3 (composition stays valid either way). Columns 2 & 3 link to /sound-healing and /lessons → internal cross-sell.

### 2.9 "אנשים מספרים" — `atom-content-testimonial-card`
3-card row (3→2→1 responsive). The 3 real /treatment testimonials, verbatim quote + name. `.ea-testimonial-card__avatar-placeholder` (sand circle) used — **no real testimonial photos exist** (asset manifest). Footer ghost-pill → /about#testimonials ("לעוד המלצות ועדויות", verbatim link label).

### 2.10 "שאלות נפוצות" — `atom-content-faq-item` (mini)
`/treatment` has **no inline FAQ block** on staging. I composed a 3-item mini-FAQ using verbatim sentences already on the page (experience needed / first-session length / treatment-vs-sound-healing). Native `<details>/<summary>` — keyboard-operable, no JS. Footer `.ea-link` → /faq. Flagged Q3: Eyal to confirm the 3 items or point to canonical FAQ entries.

### 2.11 Medical disclaimer
Verbatim disclaimer paragraph from staging, on `--ea-bg-alt`, `--ea-muted` small text. Reused the generic small-note styling; semantically a `<section aria-label>`. Kept distinct from FAQ for legal clarity.

### 2.12 Closing CTA — `atom-feedback-cta-pill`
`.ea-section--cta` centered band with verbatim closing copy ("לא כל אחד מגיע לכאן…") and the primary pill repeat. This is the conversion anchor; mirrors the hero CTA label for consistency.

### 2.13 WhatsApp float + footer
`atom-interaction-whatsapp-cta` floating pill (placeholder `wa.me` number → Q5) and `atom-data-display-footer-social` reproduced verbatim from `block-footer-social.php` (real social URLs, 4 channels incl. TikTok).

---

## 3. Accessibility / target rationale (design-toward)
- Single `<h1>` (hero); section headings are `<h2>`, card/pillar/FAQ titles `<h3>` — clean outline.
- `<main id="main">` + skip-link; every interactive atom has a visible `:focus-visible` ring (terracotta, offset) inherited from D-14.
- Contrast: body text uses `--ea-text-body (#5A3826)` / `--ea-earth` on cream — the AA-corrected D-14 values; hero text on dark gradient + overlay + text-shadow.
- Testimonials are `<figure>/<blockquote>/<figcaption>`; FAQ is native `<details>`; comparison columns are `<article>` — no ARIA where native semantics suffice.
- Decorative elements (`breath-line`, divider, icons, avatar placeholders) are `aria-hidden`. WhatsApp/social links announce "נפתח בחלון חדש".

---

## 4. Layout DNA reuse across the 3 sibling routes

All 4 routes share the **same vertical spine**: topnav → hero(gradient placeholder) → section-intro → [content-sections] → service-comparison/disambiguation → testimonials → faq-mini → cta band → whatsapp + footer. Per-route variation is **content density + which body atoms repeat**, never new atoms.

### /method — "שיטת cbDIDG" (content from W2-02)
- Hero H1 "שיטת cbDIDG של אייל עמית" + 2-line subtitle (verbatim).
- Body: "מהי שיטת cbDIDG" + "לא כל עבודה… אותו דבר" as `.ea-content-section` pair.
- **"עקרונות השיטה"** (3 principles: עבודה אקטיבית / הבחנה בין טכניקה לנשימה / תהליך) → maps cleanly onto `.ea-pillars-grid` as **3 pillars** with the bold lead-phrase as `.ea-pillar__title` and the rest as `.ea-pillar__text`.
- "מה מייחד" + "איך נולדה השיטה" (origin story incl. מוקש דהימן / 2000) → `.ea-bio-block` candidate (use portrait asset).
- "למי השיטה מתאימה" → pillars or `.ea-content-section__body ul`.
- No testimonials on the /method page → **omit** the testimonials slot or reuse the 3 treatment ones cross-route (Q6). FAQ-mini: compose from "למי מתאים" or link to /faq.

### /sound-healing — "סאונד הילינג פרטי" (content from W2-04) — RICHEST route
- Hero H1 (long) + subtitle; same gradient placeholder.
- Long intro (6 paragraphs) → `.ea-section-intro` + a following `.ea-content-section`.
- Body sections map 1:1 to the page H2s: "מה זה" / "מה מיוחד" / "איך זה עובד" (long, multi-paragraph) / "מה מאפשר" / "למי זה מתאים".
- **This route ships a REAL FAQ** (8 Q&A) → full `.ea-faq-list` of `.ea-faq-item` (not a composed mini). Footer "דף השאלות הנפוצות המלא" → /faq.
- **Real testimonials present** (שרון לוסקי, לירן קלינה, רוית יונה בניהו, הילה יניב, רתם פרץ) → `.ea-testimonials-grid` (3 shown + ghost-pill "לכל ההמלצות").
- Closing "רוצים להגיע למפגש?" → `.ea-section--cta` + WhatsApp.
- Variation: this is the only route where faq-mini becomes faq-full and testimonials are native to the page.

### /lessons — "שיעורי נגינה" (content from W2-04)
- Hero H1 "שיעורי נגינה בדיג'רידו לפי שיטת cbDIDG" + intro paragraphs.
- "מה זה ללמוד לנגן" / "למה ללמוד" / "איך נראים השיעורים" → `.ea-content-section` stack.
- **"מה לומדים בפועל"** is a **4-stage curriculum** (שלב 1–4 + המשך) → strong fit for `.ea-pillars-grid` (use `.ea-pillar__label` = "שלב 1" kicker, `.ea-pillar__title` = stage name, `.ea-pillar__text` = description). This is the signature per-route variation for /lessons.
- "למי זה מתאים" + "למה דווקא אצל אייל" (H3 bio) → `.ea-bio-block`.
- **Real FAQ** (8 Q&A) → full `.ea-faq-list`. **Real testimonials** (שירי אלקבץ, נוית צוף שטראוס, רותי שליט, ענת קרמנר ויינשטיין, אלכס פלופ) → testimonials grid.
- Closing "מוכנים להתחיל?" → cta band + WhatsApp.

### Cross-route summary
| Route | Hero | Pillars used for | FAQ | Testimonials | Comparison |
|-------|------|------------------|-----|--------------|-----------|
| /treatment | gradient | "למי זה מתאים" (5) | mini (composed) | 3 real | 3-way (native) |
| /method | gradient | "עקרונות השיטה" (3) | mini/link | none → reuse? (Q6) | "לא כל עבודה…" prose |
| /sound-healing | gradient | "למי זה מתאים" | **full (8 real)** | 5 real | prose |
| /lessons | gradient | "מה לומדים" 4-stage | **full (8 real)** | 5 real | n/a |

Same atoms, same spine, same tokens — only content quantity and the pillars/FAQ richness differ. This is what makes one approved /treatment mockup sufficient for Eyal to sign off the archetype (S2) before team_10 wires all 4 routes (S3).
