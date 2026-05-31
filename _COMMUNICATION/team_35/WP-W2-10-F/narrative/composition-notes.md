# Composition Notes — WP-W2-10-F (/en EN landing)

**Team:** team_35 (Design Studio, claude-design) · **Date:** 2026-05-31 · **Stage:** S1 (composition-only)
**Route:** `/en` · **Template:** `tpl-en-landing.php` · **Content:** W2-08 (verbatim, `inc/wave2-w2-08.php`)
**Mockup:** `../mockup/en-landing.html`

> Composition-only per AC-U1: every visual is an existing D-14 atom or the already-deployed
> W2-08 `.ea-en-*` presentation. No new atoms, no token/CSS values invented.

---

## Screen order & rationale (6 sections + chrome)

| # | Block (`data-block`) | D-14 atom(s) | Why here |
|---|----------------------|--------------|----------|
| — | topnav | `atom-nav-topnav` (ea-atoms.css §atom-nav-topnav) | Fixed dark bar; single H1 lives in hero, not nav. |
| 1 | `hero` | `.ea-en-hero` (W2-08) + `atom-feedback-cta-pill` (`.ea-cta-pill--primary`) | Full-viewport hero carries the only H1 + primary CTA. Portrait bg + ink overlay for AA text contrast. |
| 2 | `about` | `.ea-en-section` (W2-08, prose) | Establishes practitioner credibility before method/services. |
| 3 | `method` | `.ea-en-section--alt` + `.ea-en-list` | Alt bg alternation = rhythm; 3 principles as a bulleted list. |
| 4 | `services` | `.ea-en-section` + repeated `.ea-cta-pill--primary` | Three paths as prose; mid-page CTA repeat (conversion). |
| 5 | `books` | `.ea-en-section--alt` + `.ea-en-list` | Muzza catalog; alt bg keeps the alternation cadence. |
| 6 | `testimonials` | `.ea-en-testimonials` 2-col grid + `.ea-en-closing` + `.ea-cta-pill--primary` | Social proof → closing CTA. |
| — | footer-social | `atom-data-display-footer-social` | Social row + footer nav + copyright. |
| — | whatsapp | `atom-interaction-whatsapp-cta` (`.ea-whatsapp-float`) | Persistent contact affordance. |

Spacing: every section uses `--ea-space-12` vertical padding (W2-08 deployed value; mobile `--ea-space-10`); `--ea-prose-width` (960px) caps line length for EN readability. Background alternation `--ea-bg` ↔ `--ea-bg-alt`.

---

## RTL → LTR MIRROR CHECKLIST (the core risk for this cluster)

| # | Surface | RTL system (rest of site) | LTR (/en) mirror in mockup | Mechanism |
|---|---------|---------------------------|----------------------------|-----------|
| M1 | `body` flow | `direction:rtl; text-align:right` | `direction:ltr; text-align:left` | Explicit on `<html dir="ltr">`, `<main dir="ltr">`, `.ea-en`. |
| M2 | List bullets / `padding-inline-start` | bullets + indent on the RIGHT | bullets + indent on the LEFT | `padding-inline-start` (logical) flips automatically with dir. `.ea-en-list` already uses it — **PASS, no override needed**. |
| M3 | WhatsApp float `inset-inline-start` | bottom-RIGHT | bottom-LEFT | `inset-inline-start` (logical) flips automatically — **PASS**. |
| M4 | Footer social row | `flex-direction:row-reverse; justify-content:flex-end` (FB,IG,YT from right) | natural `row` + `flex-start` (FB,IG,YT,TT from left) | **PHYSICAL prop override required** — `row-reverse`/`flex-end` are NOT direction-aware. Mockup sets `flex-direction:row; justify-content:flex-start`. **ACTION for S3/team_10.** |
| M5 | Footer nav `justify-content:flex-end` | right-aligned | left-aligned | `flex-end` is physical → mockup overrides to `flex-start`. **ACTION for S3.** |
| M6 | Skip-link `right:0` | top-right | top-left | RTL atom uses physical `right:0`. Mockup uses `inset-inline-start:0`. **ACTION for S3.** |
| M7 | Hero text-align | `text-align:right` in `.ea-hero__*` atoms | centered (W2-08 hero is `text-align:center`) | W2-08 hero already neutral-centered → no mirror needed. **PASS.** |
| M8 | `margin-inline:auto` centering | symmetric | symmetric | Logical, direction-agnostic — **PASS**. |
| M9 | Iconography / arrows | n/a (no directional arrows in this composition) | n/a | No chevrons/back-arrows on /en. FAQ chevron atom (rotate-only) not used here. **PASS.** |
| M10 | Language switch | RTL nav has sound-toggle in controls slot | /en swaps it for an `עברית` `hreflang="he"` pill (BiDi-safe, `lang="he"` set) | Composition decision — confirms en↔he reciprocity (matches B03 hreflang in `wave2-w2-08.php`). |

**Net finding:** the deployed W2-08 CSS is genuinely LTR-clean (uses logical props for indents/insets). The only RTL bleed risks are in the **shared footer atom** (M4, M5) and **skip-link** (M6), which rely on PHYSICAL `row-reverse`/`flex-end`/`right`. These do not auto-flip; the mockup demonstrates the correct LTR override but the real fix belongs in S3 (team_10) / S4 (team_80) — flagged, not silently patched.

---

## Accessibility composition (design-toward AC-U2/AC-U3)

- One `<h1>` (hero); all other section titles `<h2>` with `aria-labelledby` wiring section→heading.
- Skip-link first focusable; visible focus rings (`outline:2px solid var(--ea-terracotta)`) on every interactive atom — inherited from D-14, not re-authored.
- `lang="en"` on root + `lang="he"` on the Hebrew language pill so AT switches voice for the one Hebrew token.
- Hero text on `rgba(46,43,40,0.55→0.72)` gradient over portrait → white (`--ea-on-dark`) clears AA.
- Testimonials as `<figure>`/`<blockquote>`/`<figcaption>`; social/external links carry "(opens in a new window)".
- `prefers-reduced-motion` honored; mockup ships motion neutralized (matches ea-atoms.css reduced-motion block).

## Out of scope (do NOT do at S1)
Template edits, token changes, self-validation (Lighthouse/axe = S5/team_50+190, cross-engine). Footer/skip-link physical-prop fixes = S3/team_10.
