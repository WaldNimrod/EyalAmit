---
id: W2-08-BUILD-REPORT-2026-05-29
from_team: team_10 (Builder, Claude)
to_team: team_100 (Chief System Architect)
wp: WP-W2-08 — English Landing Page (/en)
date: 2026-05-29
branch: feature/w2-08-en
worktree: /Users/nimrod/Documents/Eyal Amit/EyalAmit-w2-08
status: BUILD COMPLETE — deployed to staging, all 5 ACs verified
---

# WP-W2-08 Build Report — English Landing (/en)

## Summary
Extended existing infra (the /en WP page + `tpl-en-landing.php` already live). Added the
6-section EN content injection (verbatim from the team_30 artifact), reciprocal hreflang
(both directions), the `/contact?lang=en` CTA, an LTR D-14 stylesheet, and the single-H1
suppression. Deployed via FTP. All 5 acceptance criteria verified on staging.

## Files touched
- **NEW** `site/wp-content/themes/ea-eyalamit/inc/wave2-w2-08.php` — router/provider: `the_content`
  filter @ pri 9 (guards `is_main_query() && in_the_loop()`) keyed on slug `en`; `ea_wave2_shell`
  query var + body class `ea-en-landing` + no-sidebar + GP-title suppression; W2-08 CSS enqueue;
  hreflang emitter on `wp_head` @ pri 5; 6 sections rendered verbatim; CTA helper → `/contact?lang=en`.
- **NEW** `site/wp-content/themes/ea-eyalamit/assets/css/w2-08-en-landing.css` — LTR styles, D-14
  tokens only (no raw hex), scoped to `body.ea-en-landing`, responsive `@media (max-width:768px)`.
- **EDIT** `site/wp-content/themes/ea-eyalamit/functions.php` — `require_once inc/wave2-w2-08.php`.
- **EDIT** `site/wp-content/themes/ea-eyalamit/page-templates/tpl-en-landing.php` — removed `the_title()`
  H1 (hero block now carries the single H1); kept `lang="en" dir="ltr"`; renders `the_content()` only.
- **EDIT** `site/wp-content/themes/ea-eyalamit/style.css` — Version 1.4.5 → **1.4.6**.

## Acceptance Criteria — verified on staging (http://eyalamit-co-il-2026.s887.upress.link)

### AC-01 — /en → 200 ✅
`curl -o /dev/null -w "%{http_code}" /en/` → **200**. `<html lang="en" dir="ltr">` confirmed.

### AC-02 — 6 sections present + verbatim ✅
`data-block` markers in order: `hero`, `about`, `method`, `services`, `books`, `testimonials`.
Single `<h1>` (count = 1) = hero tagline "The Center for Breath Therapy through the Didgeridoo — the
cbDIDG Method by Eyal Amit". Verbatim spot-checks all FOUND: "Active since 1999", "founded the Center
for Breath Therapy", "cbDIDG is a structured method", "Three principles guide the method", "Mookesh
Dhiman", "three distinct paths", "Muzza Publishing is an independent press", the 3 book titles (Paint
It Blue…, Kushi Blantis, And You Shall Write), all **8 named testimonials** (Shiri Elkabetz … Alex
Flop, `ea-en-testimonial__name` count = 8), and the closing line "something in this path probably
speaks to you". No builder-authored/translated copy — content copied verbatim from the team_30 artifact.

### AC-03 — hreflang reciprocal both directions ✅
**/en `<head>`:**
```
<link rel="alternate" hreflang="en" href="…/en/" />
<link rel="alternate" hreflang="he" href="…/" />
<link rel="alternate" hreflang="x-default" href="…/" />
```
**HE homepage `/` `<head>` (page-id-16 = page_on_front):**
```
<link rel="alternate" hreflang="en" href="…/en/" />
<link rel="alternate" hreflang="he" href="…/" />
<link rel="alternate" hreflang="x-default" href="…/" />
```
Reciprocal en↔he confirmed; x-default → `/` on both. /en is page-id-25; homepage is page-id-16.

### AC-04 — CTA → /contact?lang=en ✅
3 in-page CTA buttons (hero, services, closing) all `href="…/contact?lang=en"`. Resolves: WordPress
301s `/contact?lang=en` → `/contact/?lang=en` (trailing-slash canonicalization), final **200** with
`lang=en` preserved. Never `#`.

### AC-05 — validate_aos.sh 0 FAIL + responsive ✅
`bash _aos/lean-kit/modules/validation-quality/scripts/validate_aos.sh .` → **30 PASS / 18 SKIP / 0
FAIL**. "L-GATE_BUILD EXIT CRITERION: SATISFIED." Mobile: CSS ships `@media (max-width:768px)` rules
(hero scales to `--ea-type-h2`, testimonials grid collapses 2→1 col); CSS served 200 at ver=1.4.6.

## Asset / deploy evidence
- W2-08 CSS enqueued on /en: `…/assets/css/w2-08-en-landing.css?ver=1.4.6` → 200.
- Body class on /en: `ea-wave2-shell … ea-lang-en ltr … ea-en-landing` (GP default title suppressed).
- Deployed via `scripts/ftp_deploy_site_wp_content.py` (full theme dir, FTPS) — all files OK.
- PHP lint clean on all PHP files (`php -l`).

## Image notes
Hero uses the authentic theme asset `assets/home/eyal-portrait-hero.jpg` (theme-relative,
served 200) — a genuine Eyal portrait, no stock. The new-site `wp-content/uploads` tree contains
only book covers + gallery samples (no portrait/studio shot), so the theme-bundled authentic
portrait was the correct authentic source. Section bodies are clean text on D-14 alt-tinted bands
(no decorative stock). Dark overlay on hero for legibility (`--ea-ink` + rgba scrim).

## Notes / minor observations (non-blocking)
- Body on page-id-25 also carries a stray `ea-blog-archive-view` class from another WP's body_class
  filter matching this page id. Cosmetic only — W2-08 CSS is scoped to `.ea-en-landing`, so no visual
  impact. Pre-existing; not introduced by W2-08.

## Blockers for the gates
None. Build complete, deployed, all 5 ACs PASS. Ready for L-GATE_BUILD (team_50, non-Claude) →
L-GATE_VALIDATE (team_190, Codex). Commits to be made surgically by file path (no `git add -A`);
not pushed.

*team_10 (Builder, Claude) — 2026-05-29.*
