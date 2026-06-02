# FIX DISPOSITION — WP-W2-10-F /en template routing — team_100 — v1.0

**Date:** 2026-06-03 · **Trigger:** team_190 L-GATE_VALIDATE FAIL (P0) — `_COMMUNICATION/team_190/VERDICT-WP-W2-10-F-L-GATE-VALIDATE-2026-06-03.md`
**Fixed by:** team_10 (Claude) · **Commit:** `<this>` on `main` · **Redeployed:** 2026-06-03

## Defect (P0)
`/en/` rendered through the GeneratePress **default** template, not `page-templates/tpl-en-landing.php`. The `the_content` filter injected blocks 2–7 into the GP wrapper, but the template-owned chrome never rendered: missing EN topnav (block 1), EN footer (block 8), language pill → Hebrew `/`, and `<main dir="ltr" lang="en">` (GP `<main class="site-main">` instead; only `<html>` had dir/lang via the functions.php filter).

## Root cause
`inc/wave2-w2-08.php` had **no `template_include` filter** — only a `template_redirect` setting `ea_wave2_shell`. The other clusters route via `template_include` (e.g. `wave2-w2-02.php` priority 100). `tpl-en-landing.php` was complete and correct but never applied.

## Fix
Added `ea_w2_08_template_include()` (priority 101) returning `locate_template('page-templates/tpl-en-landing.php')` when `ea_w2_08_is_en_page()` — child-theme-aware (no parent/child URI repeat), single filter, guarded to `/en` only.

## Verification (staging, post-redeploy)
- `<main id="main" class="ea-wave2-en" lang="en" dir="ltr">` present; GP `site-main` wrapper gone (0).
- EN topnav (block 1) + EN footer (block 8) render; language pill → `home_url('/')`; single H1; `<html lang="en" dir="ltr">`.
- axe `/en/` → 0 crit / 0 serious; zero physical left/right in F CSS additions (LTR logical-props intact); `php -l` clean.

## Status & routing
A/B/E already PASS team_190 (constitutional). F re-enters: **team_50 L-GATE_BUILD re-pass → team_190 L-GATE_VALIDATE re-validate**. On F PASS → full WP-W2-10 closure (ADR042: per-cluster team_191 ARCHIVE_MANIFEST → roadmap DONE/LOD500_LOCKED) on team_00 go. main merged + pushed.
