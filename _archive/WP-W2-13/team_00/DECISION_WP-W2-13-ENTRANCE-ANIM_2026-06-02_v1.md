---
id: DECISION_WP-W2-13-ENTRANCE-ANIM_2026-06-02_v1
type: aos_decide — DECISION RECORDED
date: 2026-06-02
decided_by: team_00 (Principal)
recorded_by: team_100 (Chief System Architect)
wp: WP-W2-13 (S003)
status: DECIDED
milestone: S003
---

# DECISION — WP-W2-13 entrance-animation layer

## Question
The D-14 entrance-animation layer is globally disabled site-wide by an **accidental orphaned**
`@media (prefers-reduced-motion: reduce)` block in `ea-atoms.css` (opening line lost in commit `e165218`,
2026-05-27; 0 `@media` opens + stray `}` at line 40 → `animation:none !important` leaked to global scope).
Re-enabling the entrances is a one-line fix but a visible motion change requiring sign-off.

## DECISION: Option A — APPROVE THE FIX (re-enable entrances)
team_00 approved (2026-06-02) implementing the fix.

- **Scope:** site-wide (the fix restores intended D-14 behavior wherever `.ea-entrance*` is used).
- **Eyal review:** not required pre-merge — team_00 sign-off is sufficient.

## What the fix does
Add the missing `@media (prefers-reduced-motion: reduce) {` opener so the override applies ONLY under
reduced-motion. Result: entrances play for motion-OK users (content rises 20px / `ea-fadeUp` 0.6s, with the
WP-W2-12 stagger 0.10/0.15/0.20/0.30s; headings use `ea-breathReveal`), and are fully suppressed under
`prefers-reduced-motion: reduce` (a11y preserved). No new tokens, no composition/layout change — only HOW the
existing homepage content (method pillars, treatment columns, testimonial cards, book cards, section headings,
contact form) arrives on load.

## Execution
team_80 S3 (add `@media` opener) → redeploy → S5: validate entrances play (no-preference) + suppressed (reduce)
+ axe 0/0 + LH a11y 100 / mobile perf ≥85 unchanged → team_190/Cursor L-GATE_VALIDATE → merge to main per team_00 go.

## Rationale
Confirmed accidental bug; trivial, reversible, a11y-safe fix; restores the designed D-14 motion and surfaces the
WP-W2-12 stagger. Aligned with AOS Iron Rules (defect fix, no tension).
