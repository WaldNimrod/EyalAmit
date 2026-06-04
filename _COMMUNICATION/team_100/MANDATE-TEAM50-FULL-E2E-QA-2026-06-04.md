---
id: MANDATE-TEAM50-FULL-E2E-QA-2026-06-04
from_team: team_100 (Chief System Architect)
to_team: team_50 (QA & Functional Acceptance)
date: 2026-06-04
type: QA_MANDATE
scope: FULL-SITE deep E2E + visual-precision + content-comparison (independent, external)
engine: Cursor Composer (cross-engine; builder = Claude Code → IR#1)
staging: http://eyalamit-co-il-2026.s887.upress.link
status: ISSUED
---

# Mandate — Full-site deep E2E QA (team_50, independent external pass)

## 0. Why this mandate
WP-W2-14 (mobile chrome + drawer, canonical nav/footer, Home review-fixes, /method elevated, and the new Memorial / Galleries / Media pages) is built, integrated and deployed to staging (branch `wp-w2-14-phase2`). Before routing the per-WP L-GATE_VALIDATE and while we await Eyal's content answers, team_00 has requested a **single, full, deep, independent E2E QA pass over the entire site** — every interface, every breakpoint — with **visual-precision** and **content-accuracy** as first-class gates, returning a **detailed feedback report**.

This is a **discovery/audit** pass (not a single-WP gate). Be exhaustive and adversarial. Assume nothing passes until proven.

## 1. Identity & rules
- You are **team_50** (QA & Functional Acceptance), **Cursor Composer** — cross-engine vs the Claude Code build (IR#1). Verify **independently**; do not rely on team_100 pre-flight or build reports.
- Read first: `_COMMUNICATION/team_50/onboard_team50.md`, `_aos/governance/team_50.md` (esp. GCR-002 mandatory UI sweep + scenario matrix).
- **No code edits, no merge, no deploy.** Recommend fixes only. Output **only** under `_COMMUNICATION/team_50/`.
- Dev/staging TLS may be invalid by design; HTTP is expected (CLAUDE.md). LH **perf** on staging is an artifact — measure perf on production if needed; a11y is authoritative via axe.

## 2. Surface in scope — EVERY interface
Test all live routes (chrome + page body), desktop **and** mobile:

**Primary nav (10) + dropdowns:** `/`, `/treatment`, `/method`, `/lessons`, `/sound-healing`, `/learning` (+ `/therapist-training`, `/courses-external`, `/lectures`, `/workshops`), `/tools-and-accessories` (+ `/instruments`, `/repair`), `/muzza` (books) + book details, `/blog` + a single post, `/eyal-amit` (about), `/contact`.
**Footer-only + new:** `/faq`, `/galleries`, `/media`, `/privacy`, `/accessibility`, `/terms`, `/mokesh-dahiman` **and** `/about/moksha` (memorial — both URLs), `/shop` + product pages, `/en` (EN/LTR).
**Chrome (every page):** top nav, desktop dropdowns, **mobile drawer**, canonical `.ea-cfoot` footer.

If a route 404s or is missing, that is a finding (record it) — do not skip silently.

## 3. Test dimensions (ALL mandatory)

### 3.1 Structural / E2E navigation
- Per route: HTTP 200, exactly **one H1**, **0 console errors**, no broken asset (every `<img>`/CSS/JS/font → 200; flag any 404, esp. cross-theme `generatepress` vs `ea-eyalamit`).
- **Click every link** (nav, all 3 dropdowns, drawer items + accordions + sub-links, footer columns, in-body CTAs, language pill, social icons): resolves to the intended target + 200; external links `target=_blank rel=noopener`. Build a link-coverage matrix.
- Forms/interactions end-to-end: contact form (submit + validation paths — note `form_id` state), sound toggle, **home testimonials rotator** (advance/pause/dots/reduced-motion), language switch HE↔EN, purchase/CTA buttons.

### 3.2 Mobile drawer (GCR-002 full UI sweep, @390 + @360)
Open (☰) · close (✕) · scrim-tap · Esc · tap a link closes+navigates · resize ≥1024 auto-close · focus → ✕ on open, restored to ☰ on close · **focus-trap** (Tab/Shift+Tab cycle) · body-scroll-lock · accordion `aria-expanded` 0fr→1fr · `aria-current` on active route · ≥44px targets · `prefers-reduced-motion` halts motion · `קורסים חיצוני ↗`. Confirm on RTL **and** the `/en` LTR page.

### 3.3 Responsive / zero-overflow
On **every** route, at **360 / 390 / 414 / 768 / 1280**: `scrollWidth === clientWidth` (no horizontal scroll). Use the box model (CDP/Lighthouse/Playwright), not curl. Report any overflowing element (selector + width).

### 3.4 Visual precision (mockup-vs-live) — a GATE
For every elevated page, screenshot **desktop + 390px** and compare to its team_35 mockup (`_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/mockups/` and the Track-2 elevation set). Flag layout/spacing/type/colour/component deviations (e.g. comparison cards, shop grid, rotator, bio media-rows, memorial sand-ring, galleries grid 3→2→1, media `.ea-tgrid` stack). Verify D-14 token fidelity visually (no off-palette colours, consistent spacing).

### 3.5 Content accuracy (live vs Eyal's source) — a GATE
Compare live page text against Eyal's source content and flag every discrepancy, omission, placeholder, or typo:
- Source: `docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/` (per-page `.md`/`.docx`) + `INDEX-CONTENT-2026-05-25.md` + `site-tree.json`.
- Cross-check against the open findings already logged: `_COMMUNICATION/team_100/CONTENT-AUDIT-WP-W2-14-VS-EYAL-2026-06-04.md` (F1–F9) and the client-hub group H. Confirm/expand them; find NEW content gaps we missed.
- Special attention: **Memorial** (is the page copy faithful to `ומה היום.docx`? the omitted line, headings, dates 1950–2020?), **Galleries/Media** (mockup-sample vs real), **/method** vs `method.md`, Home rotator quotes provenance.
- Verify nav/footer labels + the 19/20-link footer match the locked IA; confirm the canonical menu is identical on every template.

### 3.6 Accessibility
axe-core **0 critical / 0 serious** on every route (mobile **and** desktop). Keyboard-only nav of the whole site (skip-link, focus order, visible focus rings, drawer trap, accordions). Colour-contrast spot-checks. Report all critical/serious with selector + fix hint.

### 3.7 Performance (supplemental)
LH mobile per key route (note staging perf = artifact; a11y authoritative). Flag obvious regressions (LCP, CLS, render-blocking).

### 3.8 RTL / LTR
RTL correctness on HE pages (logical properties, no physical-direction bugs); `/en` full LTR pass (mirrored chrome, drawer slide axis, English menu + "עברית" pill).

### 3.9 Regression
Confirm WP-W2-14 did not regress previously-signed-off pages (service cluster, about, books, blog, contact, FAQ, EN).

## 4. Scenario matrix (per GCR-002 — apply to interactive surfaces)
1. Happy path · 2. Error/validation (form invalid, empty states) · 3. Edge (360px, long text, empty catalog) · 4. Conflict/duplicate (the two memorial URLs) · 5. Cancellation (abandon a multi-step flow). Mark N/A with justification where not applicable.

## 5. Tooling (independent runs; record commands + exit codes)
- `node scripts/qa/http-qa-axe.cjs --base <staging> <routes…>` (a11y)
- `node _aos/lean-kit/modules/validation-quality/scripts/qa/qa_probe.mjs --config <cfg> --shots` (overflow + screenshots, all viewports)
- `bash scripts/qa/http-qa-lighthouse.sh <routes>` (perf/a11y)
- MCP browser (Cursor) — real drawer/link/form interaction + mockup-vs-live screenshots
- `git`/file reads for content comparison; do NOT modify files.

## 6. Deliverable — detailed feedback report
`_COMMUNICATION/team_50/QA-REPORT-FULL-E2E-SITE-2026-06-04.md`, including:
- **§0 Verdict box** (overall PASS / PASS_WITH_FINDINGS / FAIL; blocking count; one-line next step).
- **§1 Engine declaration** (Cursor, IR#1, staging HEAD, "independent").
- **§2 Coverage matrix** — every route × every dimension (3.1–3.9), pass/fail per cell.
- **§3 Findings** — each with: ID, severity (**P0 blocking / P1 / P2 / P3 / nit**), dimension, route, evidence (command output / screenshot path), and a concrete fix recommendation + owner (team_10 build / team_80 tokens / team_00 content/IA).
- **§4 Link-coverage matrix** (every link → destination → status).
- **§5 Content-accuracy table** (live vs Eyal source; confirm/expand F1–F9 + new gaps).
- **§6 Visual-precision notes** (per page, desktop+390, deviations from mockup).
- **§7 Routing recommendation** (what blocks per-WP L-GATE_VALIDATE; what's content-pending on Eyal).
- Evidence (screenshots/JSON) under `_COMMUNICATION/team_50/evidence/full-e2e-2026-06-04/`.

## 7. Severity guidance
- **P0** = broken/incorrect behaviour, 404 asset/route, axe critical, horizontal overflow, content factually wrong, accessibility blocker.
- **P1** = visual deviation from mockup that changes meaning/layout, missing real content where required, axe serious.
- **P2/P3** = polish, minor spacing/type, optional content, nits.

Be exhaustive. A happy-path-only pass is **not** acceptable (GCR-002). Return everything you find.

*team_100 — 2026-06-04 — independent full-site E2E QA mandate for team_50.*
