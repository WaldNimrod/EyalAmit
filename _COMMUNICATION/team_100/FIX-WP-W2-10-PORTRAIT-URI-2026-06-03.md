# FIX DISPOSITION — WP-W2-10 child-theme asset URLs — team_100 — v1.0

**Date:** 2026-06-03 · **Trigger:** team_190 L-GATE_VALIDATE cluster A FAIL (P0) — `_COMMUNICATION/team_190/VERDICT-WP-W2-10-A-L-GATE-VALIDATE-2026-06-03.md`
**Fixed by:** team_10 (Claude builder) · **Commit:** `407965a` on `main` · **Redeployed to staging:** 2026-06-03

## Defect (P0)
Bio portrait (and, latent, B/E covers + studio + gallery) referenced via `get_template_directory_uri()`, which resolves to the **parent** theme (GeneratePress) — assets live in the **child** theme `ea-eyalamit` → **404**, image not rendered. axe/LH/HTTP-200 did not catch it (a 404 `<img>` with alt is not an a11y violation and does not fail perf); team_100 pre-flight missed it by grepping filename presence rather than verifying URL HTTP status.

## Fix (systemic, fix-once)
Replaced all 6 asset-URL refs `get_template_directory_uri()` → `get_stylesheet_directory_uri()`:
- A — `inc/wave2-w2-04.php:513` (portrait)
- E — `inc/wave2-w2-05.php` (book covers, gallery)
- B — `inc/wave2-w2-07.php` (portrait, studio, image base)
- F — already correct (`get_stylesheet_directory_uri`); unchanged.

## Verification (staging)
- Direct asset URLs: child `/themes/ea-eyalamit/assets/images/*` → **200** (portrait, hero-wide-studio, 3 covers, gallery); old parent path → **404** (confirms root cause).
- Rendered pages (/treatment/, /about/, /books/, /books/vekatavta/, /en/): every `assets/images/*.jpg` src points to `ea-eyalamit` and resolves **200**.
- axe re-run (/treatment/, /about/, /books/, /books/vekatavta/) → **0 crit / 0 serious** (no regression from now-loading images).
- `php -l` clean (3 files); `validate_aos.sh .` → 0 FAIL.

## Process improvement (carried into team_50/team_190 mandates going forward)
QA must verify each `assets/images/*` URL returns HTTP 200 (not just presence in markup). Pre-flight check updated accordingly.

## Routing
Cluster A re-enters the gate chain: **team_50 L-GATE_BUILD re-pass → team_190 L-GATE_VALIDATE re-validate**. B/E now carry the fix (assets resolve) ahead of their own gates; F unaffected.
