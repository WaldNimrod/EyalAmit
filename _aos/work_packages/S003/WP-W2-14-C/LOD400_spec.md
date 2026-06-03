# LOD400 — WP-W2-14-C · Home elevation review-fixes

**WP:** WP-W2-14-C | **Milestone:** S003 | **Parent:** WP-W2-14 | **Priority:** MED-HIGH | **Profile:** L0
**Builder:** team_10 | **Tokens:** team_80 | **QA:** team_50 → team_190 (Cursor, incl. VISUAL+mobile)
**Authored:** 2026-06-03 (team_100) | **lod_status:** LOD400
**SSoT:** `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/mockups/Home - Dashboard (elevated).html` + `DELTA-AND-FIXES.md` §B (the 4 Home review fixes).

## 0. Objective
Apply team_00's Home review fixes (sparse text + add imagery + rotating testimonials) to the live Home (`/`), desktop + mobile. Inherits chrome/drawer from **WP-W2-14-A**.

## 1. Scope (the review fixes — DELTA §B)
- **"מה זה טיפול" section** → restructure to a **two-column media row** (text + figure); release the narrow lead width. Figure = labelled graceful placeholder (no real studio photo yet — do NOT mislabel the portrait-painting asset).
- **About block** → **portrait media row** using `eyal-portrait-hero.jpg`.
- **Testimonials** → **auto-advancing 1-up rotator** (5 named real quotes, dots, pause on hover/focus, RTL-correct transform, `prefers-reduced-motion` → static). Reuse `--ea-dur-*`/`--ea-ease-*` (no new keyframes).
- Files: `page-templates/tpl-home.php` + the home render fn/blocks (`inc/wave2-stage-b.php`) + home CSS (existing sheet); rotator JS reuses existing patterns (no new heavy assets).

## 2. Acceptance Criteria
- Home matches the elevated Home mockup desktop + mobile; media rows fill the former sparse text; rotator advances/pauses/respects reduced-motion; RTL correct.
- axe 0 crit/0 serious; LH mobile perf median ≥85 (rotator must not regress LCP), a11y 100; 0 horizontal overflow; single H1.
- D-14 zero-drift; `ea-tokens.css` unchanged.

## 3. Gate chain
S3 → S4 → deploy → team_100 pre-flight (incl. mobile + rotator behaviour) → S5 team_50 → team_190 (Cursor, visual+mobile).

## 4. Orchestration
**Blocked by WP-W2-14-A.** Parallel with B/D/E (worktree; owns tpl-home + home blocks/CSS + rotator JS only).
