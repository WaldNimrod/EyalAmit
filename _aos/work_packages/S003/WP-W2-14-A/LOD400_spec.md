# LOD400 — WP-W2-14-A · Mobile Chrome Foundation (canonical nav + footer + drawer)

**WP:** WP-W2-14-A | **Milestone:** S003 | **Parent:** WP-W2-14 (Mobile tier) | **Priority:** HIGH | **Profile:** L0
**Builder:** team_10 (S3) | **Tokens:** team_80 (S4) | **QA:** team_50 (S5 build) → **Validate:** team_190 (Cursor, cross-engine, incl. VISUAL + mobile)
**Authored:** 2026-06-03 (team_100) | **lod_status:** LOD400
**Source package (SSoT):** `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/` — read `README-MOBILE.md` → `NAV-DRAWER-SPEC.md` → `BREAKPOINT-NOTES.md` → `DELTA-AND-FIXES.md`. Implementation files: `mockups/assets/ea-mobile-nav.css`, `ea-mobile-nav.js`, `ea-mobile-variants.css`. Approved IA: `hub/data/site-tree.json` (Eyal 2026-04-06).

## 0. Objective
Establish the **single canonical site chrome** (nav + footer) and the **mobile drawer** as a reusable foundation that every template inherits. This is the **pattern-setter** — it BLOCKS all other WP-W2-14 children. Replaces the interim per-template nav (WP-W2-10 chrome remediation) with team_35's canonical, server-rendered, IA-locked implementation.

## 1. Scope (files)
- `site/wp-content/themes/ea-eyalamit/template-parts/blocks/block-topnav.php` — **server-render** the canonical nav from the approved WP menu / `site-tree.json` (10 top-level + 3 dropdown groups [לימוד והכשרה, כלים ואביזרים, אייל עמית] + EN pill + sound). **Delete all per-template hard-coded link lists** (DELTA §C.1). Desktop ≥1024 = hover/focus dropdowns; ≤1023 = drawer bar (links hidden).
- `block-footer-social.php` — render the **canonical footer** (`.ea-cfoot`: brand+location · ניווט · מידע ותקנון · עקבו · copyright) from ONE partial on every template; 4→2→1 col. 19 links per NAV-DRAWER-SPEC §3 + DELTA §C.2.
- New theme assets ported from the package: `assets/css/ea-mobile-nav.css` (drawer + canonical dropdowns + footer, mobile-scoped `@media (max-width:1023px)`), `assets/js/ea-mobile-nav.js` (**drawer behaviour only** — open/close, accordion `0fr→1fr`, focus-trap, Esc, scrim, body-scroll-lock, `dir`-aware slide sign `--ea-mnav-tx`; **DO NOT ship** the client-side menu-builder nor the harness `postMessage` listener — DELTA §C.3, SPEC §7), `assets/css/ea-mobile-variants.css` (§4 defaults).
- `inc/wave2-stage-b.php` (or functions enqueue) — enqueue the 3 files on all wave2 pages.

## 2. Behaviour (per NAV-DRAWER-SPEC.md — implement verbatim)
Closed bar (64px dark fixed): `[☰][♪שמע][EN] … brand` (burger+sound+EN at inline-start LTR-fixed order; brand inline-end). Drawer: side sheet `min(86vw,360px)`, scrim `rgba(46,43,40,.55)`+blur, slide via `--ea-mnav-tx`, `role="dialog" aria-modal`, focus-trap + Esc + scrim-tap + link-tap + resize≥1024 close, focus restore. Submenus = inline accordions (`aria-expanded`/`aria-controls`, first sub-item = parent overview link, external קורסים = `חיצוני ↗`). EN `/en` = LTR mirror (English menu + עברית pill → `/`).

## 3. Acceptance Criteria
- **AC-A1** Nav + footer **identical on every template** (sourced from the locked IA; no per-page lists). 10 items · 3 dropdowns · 7 sub-links · footer 19 links.
- **AC-A2** Drawer fully functional + accessible: focus-trap, Esc, scrim, body-scroll-lock, `aria-*`, ≥44px targets, visible focus rings, `prefers-reduced-motion` disables motion. axe **0 critical / 0 serious** (mobile + desktop).
- **AC-A3** **Zero horizontal scroll** at 360 / 390 / 414 / 768 px (`scrollWidth === innerWidth`) — resolves the `/treatment` overflow.
- **AC-A4** RTL + **LTR (`/en`)** both correct (single code path; logical properties + computed slide sign).
- **AC-A5** D-14: zero new tokens/atoms/keyframes, no raw hex, no inline layout styles; `ea-tokens.css` unchanged (team_80 S4).
- **AC-A6** Desktop ≥1024 nav unchanged in content from the approved menu; LH mobile perf median ≥85, a11y 100; per-route HTTP 200; single H1.
- **AC-A7** **Visual fidelity** vs `Mobile UI.html` + the elevated mockups (mockup-vs-live screenshot compare is now a gate — see VISUAL-FIDELITY lesson).

## 4. Gate chain
S3 (team_10) → S4 (team_80 tokens) → deploy (FTP) → team_100 pre-flight (axe http + LH https + **mobile screenshot vs mockup** + 0-overflow probe) → S5 team_50 L-GATE_BUILD → team_190 L-GATE_VALIDATE (Cursor; **must include a visual + mobile-drawer + RTL/LTR check**).

## 5. Orchestration
**FIRST / SOLO pattern-setter. BLOCKS WP-W2-14-B/C/D/E.** They inherit this chrome by dropping the 3 enqueues; do not start their builds until 14-A's pattern is deployed + pre-flight-clean.

## 6. Spec-validation remediations (2026-06-03 — team_190 findings resolved)
- **P2 — Drawer breakpoint DECIDED = `≤1023px`** (package default; drawer through tablet, full 10-item desktop nav only ≥1024 where it fits). team_00-default-approved; a switch to `≤767` is a one-line change if team_00 directs before build. Pin this value in `ea-mobile-nav.css` media scope.
- **P3 — Enqueue ownership:** the 3 enqueues (`ea-mobile-nav.css`/`.js` + `ea-mobile-variants.css`) are added in `inc/wave2-stage-b.php` **by 14-A only**. Phase-2 children (esp. 14-C, which also touches `wave2-stage-b.php` for home blocks) **MUST NOT edit the enqueue lines** — merge rule: 14-A owns the enqueue block; children touch only their own functions/blocks.
- **P3 — Desktop "בית" vs drawer home (implementation guard):** desktop nav = **logo-only home** (no "בית" text item) per the locked menu; the **drawer** carries an explicit "בית" link as item #1 (NAV-DRAWER-SPEC §3). This asymmetry is intentional — render the desktop home as the brand/logo and the drawer home as a labelled link; do not add a "בית" text item to the desktop bar.
