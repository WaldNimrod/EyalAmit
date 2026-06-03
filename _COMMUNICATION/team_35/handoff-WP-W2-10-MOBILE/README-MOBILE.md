# HANDOFF — WP-W2-10 **MOBILE** (single-nav drawer + responsive lock + Home elevation)

**From:** team_35 (Design Studio) → **team_10** (WP implementation) · cc **team_100** (architect), team_00 (co-design)
**Date:** 2026-06-03 · **System:** D-14 (`ea-tokens.css` + `ea-atoms.css`) **verbatim** · **Zero new tokens / zero new atoms.**
**Builds on:** `README-HANDOFF-INDEX.md` (Track-2 desktop elevation) + `COVERAGE-MATRIX.md`. This package is the **mobile + responsive tier** of that same set, plus the Home review fixes.

> **Read me first, then `NAV-DRAWER-SPEC.md`, `BREAKPOINT-NOTES.md`, `DELTA-AND-FIXES.md`.** Together they let you implement the mobile interface without having been in the design session.

---

## 1. Overview

The desktop elevation (Track-2 A/B/E/F + Home) is signed off. The **gap this package closes** is everything mobile/responsive:

1. **Mobile navigation** — the single dark `ea-topnav` had a burger but **no drawer design**. This package delivers a full **side-sheet drawer**: the complete approved 11-item menu, 3 inline-accordion submenus, sound + EN utilities, footer links, focus-trap / Esc / scrim, RTL **and** LTR (`/en`) mirror.
2. **Chrome uniformity** — every template was rendering a *different* ad-hoc subset of nav links and a stub footer. Both nav and footer are now generated from **one canonical source** keyed to `site-tree.json`, so all templates are identical and exact (this was the explicit review blocker — "התפריט הראשי לא אחיד בכל התבניות").
3. **Per-component mobile decisions** — the open questions in the brief §4 (3-col comparison, shop columns, testimonials, timeline) are **decided** and implemented, with alternates toggleable for review.
4. **Home review fixes** — imagery added to sparse text sections; testimonials → auto-advancing rotator; memorial subtitle nowrap-on-desktop. See `DELTA-AND-FIXES.md`.

### About these design files
The files in `mockups/` are **design references created in HTML** — they show the intended look and behaviour, they are **not** drop-in production code. The task in `ea-eyalamit` is to **recreate this behaviour in the WordPress theme** (PHP templates + the existing `ea-*` atom CSS + a small JS enqueue), reusing established patterns. The mobile chrome is delivered as **two additive files** (`assets/ea-mobile-nav.css`, `assets/ea-mobile-nav.js`) + one decisions file (`assets/ea-mobile-variants.css`) precisely so it can be lifted into the theme as new partials/enqueues **without touching desktop markup**.

### Fidelity
**High-fidelity.** Final D-14 colours, type, spacing, tap-targets, motion, and RTL/LTR behaviour. Implement pixel-faithfully against the existing atoms. The only deliberately-unfinished elements are the **graceful Eyal-gaps** (placeholder photos, sound asset, social URLs) — flagged throughout and in the original `asset-manifest.md` files.

---

## 2. What's in this package

```
handoff-WP-W2-10-MOBILE/
├── README-MOBILE.md          ← you are here (master)
├── NAV-DRAWER-SPEC.md        ← drawer interaction spec (open/close, accordion, focus, EN/LTR)
├── BREAKPOINT-NOTES.md       ← per-component behaviour at 1023 / 767 / 639 + target widths
├── DELTA-AND-FIXES.md        ← deltas vs desktop elevation + the 5 review fixes (with anchors)
└── mockups/                  ← fully self-contained — open any file directly
    ├── Mobile UI.html        ← 390px PHONE HARNESS — start here. Picks any template, toggles decisions.
    ├── Home - Dashboard (elevated).html
    ├── Method (elevated).html
    ├── Service - Treatment (elevated).html
    ├── Editorial - About (elevated).html
    ├── Memorial - Mokesh (elevated).html
    ├── Commerce - Books Archive (elevated).html
    ├── Commerce - Book Detail (elevated).html
    ├── Galleries Catalog (elevated).html
    ├── Media Catalog (elevated).html
    ├── EN - Landing (elevated).html
    └── assets/
        ├── ea-mobile-nav.css       ← drawer + canonical desktop dropdowns + canonical footer (mobile-scoped)
        ├── ea-mobile-nav.js        ← builds the menu/footer from the locked model; drives the drawer
        ├── ea-mobile-variants.css  ← §4 decisions (defaults) + alternates behind data-attrs
        ├── eyal-portrait-hero.jpg, hero-wide-studio.jpg, ea-logo.jpg
        ├── covers/  (kushi-blantis, tsva-bechol, vekatavt)
        └── gallery/ (kushi-01, kushi-02-eyal-italy, kushi-04-sinai)
```

**To preview:** open `mockups/Mobile UI.html` — it loads each real template inside a 390px frame so the actual breakpoints fire, and lets you open the drawer + flip every §4 decision live. Each elevated page also opens standalone (resize the window past 1023px to see the desktop nav, below it to see the drawer bar).

---

## 3. The three additive files (this is the whole mobile layer)

Everything mobile is **three files, injected before `</head>`** on every template. Nothing else in the desktop markup changed.

```html
<link rel="stylesheet" href="assets/ea-mobile-nav.css">
<link rel="stylesheet" href="assets/ea-mobile-variants.css">
<script src="assets/ea-mobile-nav.js" defer></script>
```

| File | Responsibility | Scope guard |
|---|---|---|
| `ea-mobile-nav.css` | Closed-bar controls, side-sheet drawer, accordion, scrim; **canonical desktop dropdowns**; **canonical footer** | Drawer chrome under `@media (max-width:1023px)`; desktop dropdown/footer rules are plain (apply ≥1024 where links are visible) |
| `ea-mobile-nav.js` | Holds the **locked menu + footer model** (HE & EN); injects the closed-bar controls + drawer; **rebuilds `.ea-topnav__links` and `.ea-footer__inner`** so every page is identical; drives open/close, accordion, focus-trap, Esc, scrim, RTL/LTR slide axis; listens to the harness over `postMessage` | Reads `<html dir>`/`lang`; degrades to no-op if `.ea-topnav` absent |
| `ea-mobile-variants.css` | The §4 decisions as **defaults**, with alternates behind `html[data-…]` attributes (toggled by the harness for review) | All under `@media (max-width:767px)` |

**Implementation note for team_10:** in the theme this becomes (a) two enqueues (`ea-mobile-nav.css`+`.js`) in `functions.php`, (b) the menu model sourced from the WP nav menu / `site-tree.json` rather than the hard-coded JS array, and (c) the canonical footer rendered by the existing footer template part. The JS here rebuilds nav/footer client-side **only because these are static mockups** — in WP, render them server-side from the same locked IA and keep just the drawer behaviour JS.

---

## 4. §4 open questions — DECIDED

| Question (brief §4) | **Decision (default)** | Alternate (toggle) | Where |
|---|---|---|---|
| **Service-comparison 3-col @390** | **3 full-width stacked cards**, hairline frame, active card = terracotta border + `--ea-bg-alt` | horizontal swipe row (`data-compare="scroll"`) | `ea-mobile-variants.css` · Service-Treatment |
| **Shop grid (4-up) @390** | **2 columns** (keeps it shoppable/scannable) | 1 column (`data-shop="1col"`) | `ea-mobile-variants.css` · `.ea-shop-grid` |
| **Testimonials** | **1-column stack** (readability + a11y) on archive/Media; **Home uses the auto-rotator** (review request) | carousel (`data-testi="carousel"`) | `ea-mobile-variants.css` + Home rotator |
| **About journey timeline @mobile** | **Vertical**, one cell under the next | — | Editorial-About (page CSS, ≤639) |
| **Memorial section** | Round sand avatar + quote, generous spacing, subtitle **nowrap on desktop / wraps mobile** | — | Memorial-Mokesh |

The harness right-rail flips each toggle live so Eyal/team can confirm a decision before build.

---

## 5. Token & a11y compliance (binding constraints from the brief §5)

- **D-14:** zero new tokens, zero new atoms, zero new `@keyframes`, no raw hex in layout rules, no inline styles for layout. Every new rule is a composition of existing `--ea-*`. **No GCR required.** (The two Home photos use existing assets; the rotator/​drawer motion reuse `--ea-dur-*` / `--ea-ease-*`.)
- **RTL via logical properties only** (`inset-inline-*`, `padding-inline-*`, `margin-inline-*`). The **single** physical value is the drawer slide sign, computed at runtime from `(dir, side)` and stored in `--ea-mnav-tx`.
- **EN `/en` = LTR** — same component, mirrors automatically; English menu + "עברית" pill.
- **A11y:** all tap targets ≥44×44px; drawer is `role="dialog" aria-modal="true"` with focus-trap + Esc + outside-tap + focus restore; accordions use `aria-expanded` + `aria-controls`; `aria-current="page"` on the active link; visible focus rings (`--ea-sand`); `prefers-reduced-motion` disables drawer/rotator/caret transitions.
- **No horizontal scroll at any width** — verified `scrollWidth === innerWidth` at 360/390/414/768 on all 10 templates (this also resolves the `/treatment` ~1px overflow note).

---

## 6. Coverage — all 10 designed templates carry the mobile layer

| # | Template | Mobile file | Drawer | Canonical nav (10 + 3 dropdowns) | Canonical footer | Notable mobile component |
|---|---|---|---|---|---|---|
| 1 | Home | `Home - Dashboard (elevated).html` | ✅ | ✅ | ✅ | media rows + testimonial rotator |
| 2 | Method | `Method (elevated).html` | ✅ | ✅ | ✅ | 4-step → 2 → 1 col |
| 3 | Service — Treatment (A) | `Service - Treatment (elevated).html` | ✅ | ✅ | ✅ | **3-col comparison → 3 cards**, 5-tile, bio |
| 4 | Editorial — About (B) | `Editorial - About (elevated).html` | ✅ | ✅ | ✅ | vertical timeline, studio grid |
| 5 | Memorial — Mokesh | `Memorial - Mokesh (elevated).html` | ✅ | ✅ | ✅ | sensitive section, nowrap subtitle |
| 6 | Commerce — Books archive (E) | `Commerce - Books Archive (elevated).html` | ✅ | ✅ | ✅ | 1-col cards, stacked-cover bundle, **shop grid 2-col** |
| 7 | Commerce — Book detail (E) | `Commerce - Book Detail (elevated).html` | ✅ | ✅ | ✅ | cover-hero stack, full-width purchase CTAs |
| 8 | Galleries catalog | `Galleries Catalog (elevated).html` | ✅ | ✅ | ✅ | 3→2→1 gallery grid |
| 9 | Media / testimonials | `Media Catalog (elevated).html` | ✅ | ✅ | ✅ | `.ea-tgrid` → 1-col stack |
| 10 | EN landing (F) | `EN - Landing (elevated).html` | ✅ (LTR) | ✅ (EN menu) | ✅ (EN) | full LTR mobile pass |

> Shop **archive** is the DNA demo inside the books-archive `§shop` (per `COVERAGE-MATRIX.md` #8); shop **item** reuses the book-detail archetype (#9). Contact / FAQ / Blog are Track-1 S1 pages — if/when elevated, drop the same three `<head>` includes in and they inherit the entire mobile layer for free.

---

## 7. Design tokens used (all pre-existing D-14)

Colours `--ea-ink #2E2B28` · `--ea-terracotta #A44E2B` · `--ea-sand #D8C7B5` · `--ea-earth #8A5A44` · `--ea-chocolate #5C3A2E` · `--ea-bg #FAF8F5` · `--ea-bg-alt #F3EEE8` · `--ea-line rgba(216,199,181,.35)` · `--ea-muted #6F635A` · `--ea-text-body #5A3826`.
Type `--ea-font 'Heebo'` (weights 100–500). Spacing `--ea-space-1..15` (8→120px). Radii `--ea-radius-img 4px` · `--ea-radius-pill 100px`. Motion `--ea-dur-fast 150ms` · `--ea-dur-mid 300ms` (+ `--ea-dur-slow` where present) · `--ea-ease-enter`. Z `--ea-z-sticky` · `--ea-z-modal*` / `--ea-z-dropdown` (fallbacks supplied where a token is absent). Layout `--ea-nav-height 64px` · `--ea-gutter 24px` · `--ea-prose-width 960px`.

## 8. Assets / Eyal-gaps
Real images reused (no new heavy assets): `eyal-portrait-hero.jpg`, `hero-wide-studio.jpg`, `ea-logo.jpg`, 3 book covers, 3 gallery shots — all in `mockups/assets/`. Graceful gaps still open: **studio/treatment photography** (Home "what is treatment" uses a labelled placeholder rather than mislabel the portrait-painting asset), **didgeridoo sound asset** (sound toggle is visual-only), **social channel URLs** (footer `#`), and the gallery/workshop placeholders already inventoried in the per-cluster `asset-manifest.md`.

## 9. Status
All 10 designed templates are **READY_FOR_S2** for mobile as they were for desktop. team_35 halts at S2 (no template edits, no deploy, no self-validation — S5 = team_50 + team_190). Hand this folder, the desktop `README-HANDOFF-INDEX.md`, and `COVERAGE-MATRIX.md` to team_10 together for the complete visual set.
