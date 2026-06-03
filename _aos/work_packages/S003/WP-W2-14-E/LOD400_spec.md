# LOD400 — WP-W2-14-E · Remaining new elevated pages — Memorial + Galleries + Media

**WP:** WP-W2-14-E | **Milestone:** S003 | **Parent:** WP-W2-14 | **Priority:** MED | **Profile:** L0
**Builder:** team_10 | **Tokens:** team_80 | **QA:** team_50 → team_190 (Cursor, incl. VISUAL+mobile)
**Authored:** 2026-06-03 (team_100) | **lod_status:** LOD400
**SSoT:** `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/mockups/` — `Memorial - Mokesh (elevated).html`, `Galleries Catalog (elevated).html`, `Media Catalog (elevated).html` + `BREAKPOINT-NOTES.md`.

## 0. Objective
Build the **3 remaining new elevated pages** from the mockups, desktop + mobile. All inherit chrome/drawer from **WP-W2-14-A**.

## 1. Scope (3 pages)
- **Memorial — Mokesh (`/mokesh-dahiman`):** SENSITIVE content — copy **verbatim**, treated with care. Round **sand avatar** + quote, generous spacing; subtitle **`white-space:nowrap` ≥768px**, wraps on mobile (replaces brittle inline `width:600px` with a token-clean class — DELTA §B). Compose from existing atoms.
- **Galleries Catalog (`/galleries`):** gallery grid **3 → 2 → 1 col**; lead image ratio per mockup; uses gallery assets + graceful placeholders.
- **Media / testimonials Catalog (`/media`):** `.ea-tgrid` testimonial/media grid → **1-col stack** on mobile.
- Files: route templates / compositions for the 3 routes (all exist as pages, 200) + their CSS (cluster or shared catalog sheet); reuse existing atoms; no new tokens.

## 2. Acceptance Criteria
- Each of `/mokesh-dahiman`, `/galleries`, `/media` renders the elevated composition matching its mockup, desktop + mobile (390px); single H1; memorial copy verbatim + dignified.
- axe 0 crit/0 serious; LH mobile perf median ≥85, a11y 100; 0 horizontal overflow; RTL logical props.
- D-14 zero-drift; `ea-tokens.css` unchanged; visual screenshot vs mockup = gate.

## 3. Gate chain
S3 → S4 → deploy → team_100 pre-flight → S5 team_50 → team_190 (Cursor, visual+mobile).

## 4. Orchestration
**Blocked by WP-W2-14-A.** Parallel with B/C/D (worktree; owns the 3 page compositions + catalog CSS only). Build order within: Galleries + Media (shared catalog DNA) then Memorial (sensitive, own care).

## 5. Spec-validation remediations (2026-06-03)
- **P3 — Harmonized QA AC (uniform):** `validate_aos .` 0 FAIL · `php -l` clean · HTTP 200 (`/mokesh-dahiman`, `/galleries`, `/media`) · axe 0 crit/0 serious (mobile+desktop) · LH mobile triple-run median ≥85 + a11y 100 · 0 overflow @360/390/414/768 · single H1 · RTL logical props · D-14 zero new tokens/atoms (team_80 S4) · visual mockup-vs-live screenshot (desktop+390px) = gate. Memorial copy verbatim + dignified.
