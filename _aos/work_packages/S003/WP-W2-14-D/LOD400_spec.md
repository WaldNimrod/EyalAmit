# LOD400 — WP-W2-14-D · Method page — elevated build (new)

**WP:** WP-W2-14-D | **Milestone:** S003 | **Parent:** WP-W2-14 | **Priority:** MED | **Profile:** L0
**Builder:** team_10 | **Tokens:** team_80 | **QA:** team_50 → team_190 (Cursor, incl. VISUAL+mobile)
**Authored:** 2026-06-03 (team_100) | **lod_status:** LOD400
**SSoT:** `_COMMUNICATION/team_35/handoff-WP-W2-10-MOBILE/mockups/Method (elevated).html` + `BREAKPOINT-NOTES.md`.

## 0. Objective
Build the **elevated `/method` page** from the mockup (it was not in the Track-2 A/B/E/F set — now brought into the elevated + mobile chrome). Desktop + mobile. Inherits chrome/drawer from **WP-W2-14-A**.

## 1. Scope
- Build/elevate `/method` route template (likely `tpl-service.php` route ctx via the existing service render fn, OR a dedicated method composition — follow the mockup's block order). Reuse existing atoms/partials (hero, content sections, pillars, CTA band, footer).
- Notable mobile component: the **method 4-step grid → 2 → 1 col** (per BREAKPOINT-NOTES).
- Wire any real assets already in package (`hero-wide-studio.jpg` etc.); graceful gaps kept.
- Files: route handling in `inc/wave2-w2-04.php`/`wave2-w2-02.php` (method currently routes to tpl-service) + composition + method CSS (existing service sheet / cluster sheet).

## 2. Acceptance Criteria
- `/method` renders the elevated composition matching the mockup, desktop + mobile (390px); single H1; full block spine; no bare `the_content()` fallback.
- axe 0 crit/0 serious; LH mobile perf median ≥85, a11y 100; 0 horizontal overflow; RTL logical props.
- D-14 zero-drift; `ea-tokens.css` unchanged; visual screenshot vs mockup = gate.

## 3. Gate chain
S3 → S4 → deploy → team_100 pre-flight → S5 team_50 → team_190 (Cursor, visual+mobile).

## 4. Orchestration
**Blocked by WP-W2-14-A.** Parallel with B/C/E (worktree; owns the method composition + its CSS only).

## 5. Spec-validation remediations (2026-06-03)
- **P3 — Method routing PINNED (remove OR-ambiguity):** `/method` is routed to **`tpl-service.php` via the existing `wave2-w2-02.php` template_include** (already live). 14-D does **not** create a new dedicated template; it elevates the method composition within the service render path (route ctx `method`). Build the method block sequence per the mockup inside that path; do NOT fork a new template.
- **P3 — Harmonized QA AC:** `validate_aos .` 0 FAIL · `php -l` clean · HTTP 200 · axe 0 crit/0 serious (mobile+desktop) · LH mobile triple-run median ≥85 + a11y 100 · 0 overflow @360/390/414/768 · single H1 · RTL · D-14 zero-drift (team_80 S4) · visual screenshot (desktop+390px) = gate.
