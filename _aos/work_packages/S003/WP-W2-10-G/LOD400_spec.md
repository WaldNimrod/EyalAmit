# LOD400 Spec — WP-W2-10-G
# UI-Precision — Hero video finalization (BLOCKED on Eyal asset)

**WP ID:** WP-W2-10-G | **Milestone:** S003 | **Parent:** WP-W2-10 | **Priority:** HIGH | **Profile:** L0 | **status:** BLOCKED
**Executors:** team_35 + team_10 + team_80 | **QA:** team_50 (non-Claude) → **Validate:** team_190 (Codex)
**Authored:** 2026-05-29 (team_100) | **lod_status:** LOD400 | **Process SSoT:** UI-PRECISION-WORK-PACKAGES-LOD200 §WP-W2-10-G

## Objective
Replace the CSS-gradient hero placeholder in `block-hero.php` with the real Hero=C video treatment per the D-14 `atom-structure-hero-video`.

## Route & template
Route: **homepage `/`** (`page_on_front=16`), hero region rendered by `template-parts/blocks/block-hero.php` (within `tpl-home.php`). This WP touches only the hero block composition — not the rest of the homepage (which already has a reviewed composition).

## Scope
Video element + poster + reduced-motion fallback + overlay-text composition + mobile preload behavior. Mockup of the final hero with a real video frame.

## 5-stage flow
S1 mockup (final hero with real video frame) → S2 Eyal sign-off → S3 team_10 implement in `block-hero.php` → S4 team_80 tokens → S5 team_50 QA → team_190 validate. Starts when Eyal delivers the video.

## Acceptance Criteria
- AC-G0: mockup of the final hero (with real video frame) approved by Eyal (S2 sign-off gate — parity with sibling clusters).
- AC-G1: video plays + poster fallback present.
- AC-G2: `prefers-reduced-motion: reduce` serves the poster (no autoplay).
- AC-G3: overlay text legible over video (WCAG contrast).
- AC-G4: mobile data-friendly preload strategy (no full autoplay download on cellular).
- AC-G5: team_50 QA + team_190 L-GATE_VALIDATE PASS — Lighthouse mobile perf ≥ 85 / a11y 100 (triple-run median); axe 0 critical / 0 serious.

## Dependencies / blocker
🔒 **BLOCKED** on Eyal-provided hero video asset (external). No work starts until the video arrives. team_35 activated by team_00 thereafter.

## Gate sequence
L-GATE_SPEC (this doc) → [BLOCKED: await video] → S1–S5 → L-GATE_BUILD → L-GATE_VALIDATE → close. Est: mockup 1d + refine 1d + QA 0.5d (post-video).
