# FIX DISPOSITION — WP-W2-10-E cover/LCP mobile perf — team_100 — v1.0

**Date:** 2026-06-03 · **Trigger:** team_50 L-GATE_BUILD FAIL — `_COMMUNICATION/team_50/QA-VERDICT-WP-W2-10-E-L-GATE-BUILD-2026-06-03.md` (`/books/vekatavta/` mobile perf median **73** < 85; all other E checks PASS).
**Fixed by:** team_10 (Claude) · **Commit:** `<this>` on `main` · **Redeployed:** 2026-06-03

## Root cause (and why pre-flight missed it)
The detail hero cover is the **mobile LCP** (single-column `1fr`, `width:100%`, eager). Covers were unoptimized: vekatavt 557 KB / tsva 612 KB / kushi 281 KB. **The earlier pre-flight reported `/books/vekatavta/` perf 97 — but that was before the portrait-URI fix, when the cover 404'd and never loaded** (falsely fast LCP). Once the URI fix made the cover actually load, the true mobile LCP cost surfaced → 73. (Lesson: a broken/404 image inflates Lighthouse perf; fixing it can reveal genuinely poor perf.)

## Fix (D-14-clean; no token change; no composition/a11y change)
- Resized the 3 covers to max 800 px @ q72: vekatavt 557→132 KB, tsva 612→140 KB, kushi 281→127 KB. Pristine originals retained in `_COMMUNICATION/team_35/handoff-WP-W2-10-Track2/shared-assets/covers/`.
- Added `fetchpriority="high"` + intrinsic `width="600" height="800"` (3:4) to the detail hero cover (`inc/wave2-w2-05.php`).

## Verification (staging, post-redeploy)
- `/books/vekatavta/` mobile perf median **73 → 97**, a11y 100. `/books/` 97 / a11y 100.
- Optimized cover served at 200 (~136 KB); hero img carries `fetchpriority="high"`.
- axe re-run `/books/vekatavta/ /books/ /books/kushi-blantis/ /books/tsva-bekahol/` → **0 crit / 0 serious**.
- `php -l` clean; covers also used by B/F (lighter = improvement only, no regression).

## Routing
E re-enters: **team_50 L-GATE_BUILD re-pass → team_190 L-GATE_VALIDATE**. A/B/F unaffected by composition; B/F covers are now lighter (team_190 validates current staging state regardless).
