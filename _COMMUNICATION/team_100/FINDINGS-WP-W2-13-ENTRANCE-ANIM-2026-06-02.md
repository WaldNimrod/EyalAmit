---
id: FINDINGS-WP-W2-13-ENTRANCE-ANIM-2026-06-02
from_team: team_100 (Chief System Architect)
to_team: team_00 (sign-off decision) / team_80
date: 2026-06-02
wp: WP-W2-13 (investigate & conditionally re-enable D-14 entrance-animation layer)
stage: investigation (pre-S3) — root cause + recommendation
verdict: ACCIDENTAL (orphaned reduced-motion block) — fix is 1 line, but it is a VISUAL CHANGE → needs team_00 sign-off
---

# WP-W2-13 — Investigation findings: why the entrance animations are globally off

## Root cause: ACCIDENTAL — an orphaned `@media (prefers-reduced-motion: reduce)` block
At the very top of `site/wp-content/themes/ea-eyalamit/assets/css/ea-atoms.css`:
```
1  /* EyalAmit Wave2 — atom layout/styles ... */
2  .ea-entrance, .ea-entrance--breath, .ea-entrance--slide {
5      animation: none !important; opacity: 1 !important; transform: none !important; }
   ...  (also: #ea-scroll-progress, .ea-cta-pill, .ea-whatsapp-float, .ea-link::after,
         .ea-testimonials-carousel[data-autoplay], .ea-bio-block__portrait, .ea-carousel__track)
40 }   <-- STRAY closing brace (no matching open)
```
Evidence it is accidental:
- The block contents are indented 6-8 spaces and **end with a stray `}` at line 40**, but there is **no `@media` opener** before line 2 — `grep -c '@media.*prefers-reduced-motion' ea-atoms.css` = **0**.
- The shape is exactly a `@media (prefers-reduced-motion: reduce) { ... }` body whose **opening line was lost** during an edit, dumping the reduced-motion overrides into **global scope**.
- A CSS parser ignores the stray top-level `}`, so the `animation: none !important` rules apply to **all users** (confirmed at runtime: `matchMedia('(prefers-reduced-motion: reduce)')` = false on `/`, yet computed `animation-name: none` on `.ea-entrance`).
- Introduced 2026-05-27 in commit `e165218` ("WP-W2-01 Stage B — implementation COMPLETE_PENDING_QA"). A correct reduced-motion block already exists in `ea-animations.css` (~lines 90-116) — this top-of-atoms block is its mangled twin.

## Effect
The entire D-14 entrance-animation layer (`ea-fadeUp` / `ea-breathReveal` / `ea-slideIn-rtl`) is suppressed
site-wide for every user — not just reduced-motion users. The WP-W2-12 stagger is therefore inert (tidy but unseen).

## Recommended fix (S3 — one line, low-risk)
Insert the missing opener so the block only applies under reduced-motion:
```
/* comment */                                   (line 1, unchanged)
@media (prefers-reduced-motion: reduce) {       <-- ADD this line
.ea-entrance, ... { animation: none !important; ... }
...
}                                               (existing line-40 brace now correctly closes the media query)
```
Result: entrances PLAY for motion-OK users (and the WP-W2-12 stagger becomes observable at 0.10/0.15/0.20/0.30s),
while reduced-motion users keep full suppression (accessibility preserved). No new tokens; no composition change.

## ⚠ This is a VISUAL CHANGE → team_00 sign-off required (AC-04)
Re-enabling entrances changes perceived motion on the homepage (and everywhere `.ea-entrance` is used). Per the
WP-W2-13 spec this needs team_00 sign-off before S3 implementation. Options for team_00:
- **A — Approve the fix:** team_80 adds the `@media` opener (S3), redeploy, then S5 validates entrances play
  (no-preference) AND are suppressed (reduce), axe/LH unchanged. Recommended — restores intended D-14 behavior + a free win (W2-12 stagger goes live).
- **B — Keep entrances off:** treat the motion-kill as desired; close WP-W2-13 as "intentional, documented." W2-12 stagger stays inert.

Awaiting team_00 decision (A or B) before any code change. Investigation only — no theme files edited.
