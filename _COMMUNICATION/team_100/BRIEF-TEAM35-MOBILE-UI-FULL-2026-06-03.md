# BRIEF → team_35 — Full mobile UI for EyalAmit.co.il (WP-W2-10)

**Date:** 2026-06-03 · **From:** team_100 · **To:** team_35 (design/elevation) · **Priority:** P1 · **Type:** mobile interface spec
**Goal:** deliver a **complete + accurate mobile mockup set** for every page type + the mobile navigation, so team_10 can implement a pixel-faithful, accessible RTL mobile interface (EN page = LTR).

---

## 0. Why this brief
The desktop elevation is live (chrome fixed: single nav, full-bleed, footer at bottom; nav now matches the approved site-tree). Mobile page **layouts** mostly work (hero stacks, card grids collapse to 1-column, footer at bottom). **The gap is mobile NAVIGATION** (the full 11-item menu + 3 dropdowns + EN + sound toggle has no proper drawer design) plus a set of per-component mobile decisions that the desktop mockups never specified. We need your mobile mockups to lock these.

## 1. Reference materials (SSoT)
- **Desktop mockups:** `_COMMUNICATION/team_35/WP-W2-10-{A,B,E,F}/elevation/mockup/*.html`
- **Approved IA / menu (must match):** `hub/data/site-tree.json` (Eyal-approved 2026-04-06) + `_COMMUNICATION/team_10/M2-MENU-PRIMARY-LOCKED-FROM-SITE-TREE-2026-03-29.md`
- **Live staging (view on a phone / 390px):** http://eyalamit-co-il-2026.s887.upress.link — `/treatment` `/about` `/books` `/books/vekatavta` `/shop` `/en`
- **Current mobile-state screenshots:** `scripts/qa/reports/mobile-audit/*.png` (390px full-page captures)
- **Design tokens (use ONLY these):** `site/wp-content/themes/ea-eyalamit/assets/css/ea-tokens.css` (D-14). Existing breakpoint tokens/queries in `ea-atoms.css`.

## 2. Targets & breakpoints
- **Device widths to design for:** 360px (small Android), **390px (iPhone — primary)**, 414px, 768px (tablet portrait).
- **Existing CSS breakpoints in the theme:** `max-width: 1023px` (tablet), `max-width: 767px` (mobile), `max-width: 639px` (small). Design to these; flag if you need a new one (→ team_100 GCR, don't invent tokens).
- **No horizontal scroll at any width** (current `/treatment` shows a 1px overflow — root out any element wider than 100vw; use logical props, `max-width:100%`, `overflow-wrap`).

## 3. MOBILE NAVIGATION — the priority deliverable
The single nav (`ea-topnav`, dark elevated bar) must collapse into a mobile **drawer/disclosure**. Current state: a ☰ burger renders top-left next to שמע + EN + brand, but the drawer pattern + submenu behavior is unspecified and needs your design (and must be verified to actually open).
Design and specify:
1. **Closed state (top bar):** brand (right), and on the left: ☰ burger + שמע (sound) toggle + EN pill. Confirm order, sizes, tap targets (≥44×44px).
2. **Open drawer:** full-screen or side sheet? RTL slide direction? Overlay/scrim? Close affordance (X)? Focus trap + Esc + outside-tap close.
3. **The full approved menu inside the drawer** (every page reachable):
   - טיפול בדיג׳רידו · השיטה · שיעורי דיג׳רידו · סאונד הילינג
   - **לימוד והכשרה** (accordion) → הכשרות למטפלים · קורסים (חיצוני) · הרצאות · סדנאות
   - **כלים ואביזרים** (accordion) → כלים בעבודת יד ואביזרים · תיקון וחידוש כלים
   - מוזה הוצאה לאור · בלוג דיג׳רידו
   - **אייל עמית** (accordion) → מוקש דהימן — לזכרו
   - צור קשר
   - + EN link + sound toggle inside the drawer (or kept in the bar — your call)
4. **Submenu pattern in the drawer:** accordion (expand inline) vs nested push-panel? Specify open/close + caret state + active-item highlight.
5. **Footer links** (שאלות נפוצות · גלריות · המלצות · מדיניות פרטיות · הצהרת נגישות · תקנון) — mobile footer stacking.
6. **EN page (`/en`, LTR):** mirror the same drawer, **LTR**, with the English menu (Home · The Method · Services · Books · Testimonials) + עברית pill → `/`.

## 4. Per-page-type mobile component specs needed
For each, confirm stacking, spacing, font-size, image ratios at 390px:
| Component | Pages | Mobile question to resolve |
|---|---|---|
| Hero (gradient + kicker + H1 + sub + trust + CTA pair) | all | CTA pair stacks full-width (currently OK) — confirm order, spacing, hero min-height on mobile |
| cbDIDG **4-step** pillars grid | A | 4→1 col (confirm), step number treatment, vertical rhythm |
| "who it's for" **5-tile** grid | A | tiles → 1 col? spacing |
| **Service-comparison** (3-col table) | A | **how does a 3-column comparison render at 390px?** stack / horizontal-scroll / accordion — needs your decision |
| Bio block (portrait + prose) | A, B | portrait + text stack order, portrait ratio/size |
| Testimonials ×3/×4 (cards) | A, F | 1-col stack vs swipe carousel? |
| FAQ-mini / FAQ accordion | A, C | tap targets, expand behavior |
| Editorial hero + meta + journey timeline (6 cells) | B | timeline on mobile (vertical?); **memorial section** treatment (sensitive) |
| Studio + gallery grid | B | grid→1-2 col; lead image ratio |
| Books archive cards (cover+price+footer) | E | 1-col (currently OK) — confirm cover ratio, price/CTA placement |
| Stacked-cover **bundle** band | E | how 3 stacked covers + price render at 390px |
| Book **detail** (cover hero split + excerpt + FAQ + CTAs) | E | cover-hero stack order; long excerpt handling; external-purchase CTAs full-width |
| Shop grid (4-up) | E | 4→2 col or 1 col at 390px? |
| EN landing (LTR) | F | full LTR mobile pass; logical-prop mirror |
| Footer (brand + social + nav + links + copyright) | all | section stacking order on mobile |

## 5. Constraints (binding)
- **D-14:** existing `--ea-*` tokens only; no raw hex, no inline styles, no new `@keyframes`. New mobile rules = compositions of existing atoms/tokens. If a genuinely new token is required → flag for a team_80/team_100 GCR (do not invent).
- **RTL** via logical properties only (`padding-inline-*`, `inset-inline-*`); **EN `/en` = LTR** (logical props mirror automatically).
- **A11y:** tap targets ≥44px; drawer focus-trap + Esc; `aria-expanded` on accordions; visible focus rings; maintain axe 0 critical/0 serious; single H1/route.
- **Performance:** mobile LH perf median ≥85 (don't add heavy assets; reuse optimized covers ~130KB).
- **Graceful Eyal-gaps** kept (sand-circle avatars, gradient hero, product-photo placeholders).

## 6. Deliverables (from team_35)
1. **Mobile mockups** (390px, RTL) for each page type in §4 + the **nav drawer** (closed + open + each accordion open state). HTML mockups consistent with your desktop set (same `ea-*` class vocabulary, tokens), OR annotated designs.
2. **Nav drawer interaction spec** (open/close, submenu accordion, focus order, EN/LTR variant).
3. **Per-component breakpoint notes** (what changes at 1023/767/639 and your target widths).
4. Explicit decisions on the open questions in §4 (esp. **service-comparison 3-col**, **shop grid columns**, **testimonials carousel vs stack**, **timeline on mobile**).
5. Confirm: no new tokens needed (or list any → GCR).

## 7. Current-state notes (so you build on reality, not from scratch)
- Single nav + full-bleed + footer-at-bottom are LIVE and correct on desktop.
- Mobile **page bodies stack acceptably already** (hero, cards→1col, footer) — your job is to refine spacing/typography + lock the open questions, not rebuild.
- Mobile **nav drawer** is the main missing piece (burger present; drawer behavior to design + must open reliably).
- Minor: `/treatment` has ~1px horizontal overflow at 390px — find/remove the offending element.

Refs: `_COMMUNICATION/team_100/NAV-IA-GAP-ANALYSIS-2026-06-03.md` · `CHROME-NAV-REMEDIATION-DONE-2026-06-03.md` · `VISUAL-FIDELITY-AUDIT-WP-W2-10-2026-06-03.md` · `REQUEST-TEAM35-NAV-RECONCILIATION-2026-06-03.md`
