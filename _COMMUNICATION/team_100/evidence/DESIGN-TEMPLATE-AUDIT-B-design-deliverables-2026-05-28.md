# Design Template Audit — Part B: Design-Team Deliverables Assessment
**Date:** 2026-05-28
**Auditor:** team_100 sub-agent (Sonnet)
**Design team:** team_80 (user-referenced "team 35" — see §E)
**Scope:** _COMMUNICATION/team_80/ + design docs (read-only)

---

## §E. Does team_35 exist?

**Yes — but it is NOT team_80.**

`_aos/governance/team_35.md` exists and defines team_35 as **Design Studio** (סטודיו עיצוב), a separate AOS team invoked on-demand by team_00 for LOD200 wireframes and LOD300 mockups. It is a `PIPELINE_FEEDER` in the CONTENT track and has no LOD400/500 role. team_35 and team_80 are two distinct teams. The user-facing alias "team 35" does not correspond to the team that owns D-14; the design SSOT owner is **team_80**.

---

## A. What the design team delivered to COMPLETION (LOD400 / final)

### A.1 Core design tokens — LOCKED, unambiguous

All of the following have exact hex/px/rem/ms values with no TBD:

| Token category | Status | Key values |
|---|---|---|
| **Color palette** | LOCKED | 7 brand colors + 5 UI tokens, exact hex, contrast ratios verified. Source: `docs/project/EYAL-SITE-COLOR-PALETTE.md` + D-14 §1.1. `--ea-muted` updated 2026-05-27 to `#6F635A`; `--ea-text-body: #5A3826` added. |
| **Typography scale** | LOCKED | 9 tokens (h1-hero → caption), Heebo only, exact rem/weight/line-height/letter-spacing values. Responsive scaling at 640px specified. |
| **Spacing scale** | LOCKED | 14 named steps (0→288px), 8px base. Section padding rules by page type specified. |
| **Layout grid** | LOCKED | 4 named grids (ea-grid-4/3/2/prose), 3 breakpoints (640/1024/1440px), max widths. |
| **Z-index scale** | LOCKED | 7 levels (0→70), named. |
| **Motion system** | LOCKED (v1.1) | 4 breathing keyframes + 3 entrance keyframes. All transform-only (no opacity ramp). Durations, delays, reduced-motion block — all exact. |
| **Micro-interactions** | LOCKED | Link underline grow-from-center, CTA pill hover, scroll progress — exact CSS. |
| **WCAG contrast table** | LOCKED | 14 pairs checked with pass/fail. |
| **CSS variables block** | LOCKED | Full copy-paste-ready `:root` block for `ea-tokens.css`. |

### A.2 Atom inventory — 32 atoms, all specced

- **Total atoms:** 32 (structure: 7, content: 9, interaction: 6, feedback: 4, nav: 3, data-display: 3)
- **Spec depth per atom:** Every atom has: HTML anatomy (BEM), full CSS, ARIA notes, states, reduced-motion behavior, variants, responsive overrides, and "composes into" cross-reference.
- **No TBD inside any atom definition.** Content slots use `<!-- SLOT: name -->` placeholder comments — this is intentional implementer guidance, not design ambiguity.
- **Patch sync (v1.1):** 8 POC patches (P1–P8) backported 2026-05-27. Atom count unchanged. Patch note artifact exists: `D-14-PATCH-NOTE-2026-05-27.md`.

### A.3 Page templates (§5) — 11 slot maps delivered

D-14 §5 defines 11 named templates with ordered slot maps:

| Template | Slug(s) | Composition status |
|---|---|---|
| tpl-home | `/` | FULL slot map — 12 blocks locked in §4.1 |
| tpl-service | `/treatment`, `/sound-healing`, `/lessons`, `/method` | FULL slot map — one shared template, N content sections |
| tpl-book-detail | `/books/[slug]` | FULL slot map |
| tpl-books | `/books` (MUZZA catalog) | FULL slot map |
| tpl-shop-item | `/[product-slug]` | FULL slot map |
| tpl-shop-archive | `/shop` | FULL slot map |
| tpl-blog-archive | `/blog` | FULL slot map |
| tpl-blog-single | `/blog/[slug]` | FULL slot map |
| tpl-faq | `/faq` | FULL slot map |
| tpl-content | `/about`, `/press`, `/about/moksha` | FULL slot map |
| tpl-en-landing | `/en` | FULL slot map |

### A.4 WP integration spec — complete

CPTs (book, product, press, qr), taxonomies, 8 JSON data schemas, CF7 contact form fields, PHP file tree, GA4 analytics hooks — all fully specified in D-14 §8–§9.

---

## B. What is ASSUMPTION-BASED / needs design precision

### B.1 Explicit open items (confirmed from source documents)

| Gap | Document | Status |
|---|---|---|
| **G1 — Hero video asset** | ATOM-INVENTORY §3.1 | No video file exists. `variant_placeholder` (CSS gradient) active. Eyal to supply. |
| **G2 — Sound toggle audio** | ATOM-INVENTORY §3.1 | No `/assets/audio/didgeridoo-ambient.mp3`. Eyal to provide recording. |
| **G3 — TikTok URL** | ATOM-INVENTORY §3.1 | `status: pending_url_from_eyal` in social-channels.json. Footer uses variant_without-tiktok until received. |
| **G4 — Green Invoice purchase URLs** | ATOM-INVENTORY §3.1 | 3 book purchase links not yet in repo. Required before WP-W2-03 goes live. |
| **G5 — Mokesh page content** | ATOM-INVENTORY §3.1 | `ומה היום.docx` is binary, unreadable. team_30 to convert. |
| **G6 — Product prices** | ATOM-INVENTORY §3.1 | Not set. `variant_inquiry` active as default. Eyal to enter via WP admin. |
| **G7 — Testimonial profile photos** | ATOM-INVENTORY §3.1 | 30+ FB CDN photos must be downloaded locally. WP-W2-07 scope. |

### B.2 Hero — video treatment partially designed, art direction deferred

- Decision: Hero=C (video) is LOCKED (2026-05-26, Eyal in meeting, documented in D-EYAL-DESIGN-DIRECTION-FBW-DEEP).
- The **atom spec** for `atom-structure-hero-video` is complete (HTML/CSS/JS/ARIA/responsive).
- The **video production brief** exists in D-EYAL-DESIGN-DIRECTION-FBW-DEEP §2.4 (close-up didgeridoo, 15–25s loop, H.264+WebM dual source, warm color grade, ≤3MB).
- **Not yet resolved:** Eyal has not supplied the video. Whether existing footage can be used or a new shoot is needed (₪3–8K) is TBD. The atom includes `variant_placeholder` specifically to unblock implementation.
- **Art direction:** The brief is directional ("קלוז-אפ דיג'רידו, איטית, מסתורית"), not a shot list or approved storyboard. The visual appearance of the Hero video itself is asset-dependent and has no approved comp.

### B.3 Per-PAGE layouts — atoms specced, NO visual mockups for most pages

This is the critical precision gap:

- D-14 delivers **design system + slot maps**, not **visual mockups or Figma comps**.
- The only page with a POC HTML mockup is the homepage (`hub/dist/decisions/atoms-poc-2026-05-26.html`), which was used for Stage A QA (team_50 + team_190).
- The HANDOFF artifact (2026-04-10) references `hub/dist/mockups/homepage-final-prototype.html` and three hero variants (A/B/C). These are HTML prototypes authored in April 2026, pre-D-14.
- For **all other pages** (method, treatment, sound-healing, lessons, books, shop, FAQ, contact, about, blog, EN, press, moksha, QR), composition is defined only by:
  - The atom spec (each atom's appearance is fully defined)
  - The template slot map in §5 (which atom goes where, in what order)
  - The composition rules in §4 (padding, color alternation, anti-patterns)
  - No visual mockup, no Figma, no reference screenshot per non-home page.

**This means:** team_10 must assemble pages by reading the slot map + atom specs. The assembled result will be correct per-spec, but there is no pre-approved visual to compare against. First render = first visual review.

### B.4 Wave2 pages with NO designed composition (atoms-by-slot-map only)

| Page / Template | Wave2 WP | Design comp? |
|---|---|---|
| `/method` | W2-02 | Slot map only |
| `/treatment` | W2-02 | Slot map only |
| `/sound-healing` | W2-04 | Slot map only |
| `/lessons` | W2-04 | Slot map only |
| `/faq` | W2-02 | Slot map only |
| `/contact` | W2-02 | Slot map only |
| `/about`, `/press`, `/about/moksha` | W2-07 | Slot map only |
| `/books` (MUZZA) | W2-03 | Slot map only |
| `/books/[slug]` × 3 | W2-03 | Slot map only |
| `/shop` | W2-05 | Slot map only |
| `/[product-slug]` × 5 | W2-05 | Slot map only |
| `/blog`, `/blog/[slug]` × 54 | W2-06 | Slot map only |
| `/en` | W2-08 | Slot map only |
| `/qr/qr[1–49]` | W2-07 | Slot map only |
| **Homepage** `/` | W2-02 | POC HTML mockup ✅ |

---

## C. The POC

### C.1 What the POC covered

- **File:** `hub/dist/decisions/atoms-poc-2026-05-26.html`
- **Scope:** Atoms-first proof of concept for Stage A. Proved all 32 atoms render with correct BEM classes, tokens, responsive behavior, ARIA, and motion.
- **Page coverage:** Primarily homepage composition (blocks 01–12 per §4.1). The POC is an atoms showcase / homepage draft, not a multi-page rendering.
- **QA on POC:** team_50 ran axe-core + Lighthouse + visual inspection. team_190 issued PASS_WITH_FINDINGS (v2). The 8 P1–P8 patches were backported from POC findings into D-14 v1.1.

### C.2 The gap: POC → every Wave2 page

The POC demonstrated that the atom system works. It did NOT:
- Render any service page (method, treatment, sound-healing, lessons)
- Render any book/shop/FAQ/blog/EN page
- Render any sub-page template (tpl-service, tpl-faq, tpl-book-detail, etc.)

The gap is not in the atom definitions (those are complete) — it is in the **per-page visual assembly**. When team_10 implements `/treatment`, they will produce the first-ever rendered version of that page. There is no approved visual to diff against.

**Risk quantification:** With 11 templates and 14+ distinct pages, the "first visual" for ~13 templates has never been reviewed by Eyal. Visual surprise is possible even with a complete spec.

---

## D. Design authority + process

### D.1 Who signed off design

- **Eyal (CEO/client):** Approved D-13 (LOD300 — style + palette + typography) on 2026-04-07. Approved Hero=C and FBW deeper direction on 2026-05-26. Has NOT approved any per-page visual beyond the homepage prototype.
- **team_80:** Owns D-14 LOD400 spec. Self-certified all atoms (AC-1–AC-6 in ATOM-INVENTORY §3.3). No separate visual-design review gate exists between team_80 and Eyal for LOD400 atoms.
- **team_100:** Architecture owner. Co-author of D-14.
- **team_190:** Validated Stage A (atoms + POC) at L-GATE_SPEC level — PASS_WITH_FINDINGS. Not a visual/aesthetic gate; validates spec completeness and accessibility.
- **No separate UI/visual-design review gate** in the pipeline between Stage A (atoms) and Stage B (implementation). Visual review is expected to happen during/after Stage B QA.

### D.2 Full visual mockup or spec-as-code?

**Spec-as-code + one POC HTML.**

- D-13 HANDOFF references `hub/dist/mockups/homepage-final-prototype.html` and hero variants — these are HTML prototypes from April 2026.
- D-14 is entirely markdown (spec + CSS code blocks + BEM HTML examples).
- No Figma file, no image comps, no design tool artifacts are referenced anywhere in any team_80 document.
- The POC HTML (`atoms-poc-2026-05-26.html`) is the closest thing to a visual mockup, and it covers the homepage only.

---

## Summary: Single Biggest Design-Precision Risk

**The visual assembly of non-home pages has never been previewed by Eyal.**

The design system (atoms, tokens, templates) is complete and well-specced at LOD400. But the slot-map composition model means the first time Eyal sees `/treatment`, `/method`, `/books`, `/shop`, or `/blog` in a browser will be after team_10 implements them in Stage B. If the assembled appearance doesn't match Eyal's expectation — even with a correct spec — a visual revision round is unavoidable. This is not a spec gap; it is a **sign-off gap** between spec-as-code (D-14) and client-approved visual (non-existent for ~13 of 14 templates).

**Mitigation recommendation (for team_100 decision):** Before team_10 implements each template cluster, generate a static HTML preview (similar to the Stage A POC) for Eyal's visual sign-off. Priority order: tpl-service (4 pages), tpl-book-detail (3 pages), tpl-shop-item (5 pages).

---

## Artifact reference index

| Artifact | Path | Status |
|---|---|---|
| D-14 design system | `_COMMUNICATION/team_80/D-14-DESIGN-SYSTEM-LOD400-2026-05-26.md` | FINAL v1.1.0 |
| D-14 patch note | `_COMMUNICATION/team_80/D-14-PATCH-NOTE-2026-05-27.md` | COMPLETE |
| Atom inventory | `_COMMUNICATION/team_80/ATOM-INVENTORY-2026-05-26.md` | FINAL v1.1.0 |
| D-13 decision (client-approved) | `_COMMUNICATION/team_80/D-EYAL-DESIGN-STYLE-13-DECISION-PACKAGE-2026-04-07.md` | LOCKED |
| Handoff (LOD300→LOD400) | `_COMMUNICATION/team_80/HANDOFF-DESIGN-SYSTEM-TO-TEAM100-2026-04-10.md` | ACTIVE |
| FBW deep direction | `_COMMUNICATION/team_100/D-EYAL-DESIGN-DIRECTION-FBW-DEEP-2026-05-26.md` | OPEN (informs D-14) |
| Color palette SSOT | `docs/project/EYAL-SITE-COLOR-PALETTE.md` | LOCKED |
| team_80 mandate (D-14 patch) | `_COMMUNICATION/team_80/MANDATE-TEAM80-D-14-PATCH-FROM-POC-2026-05-27.md` | COMPLETE |
| team_35 governance | `_aos/governance/team_35.md` | EXISTS — separate team from team_80 |
