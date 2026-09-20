# Wave B as-made — 2026-09-21 · צוות 10

**Theme version:** 1.5.98  
**Mandate:** `_COMMUNICATION/team_10/S007-GROK/MANDATE-WAVE-B-APPROVED-2026-09-21.md`

## Files changed (theme)

| Area | Path |
|------|------|
| WB-02 crumbs | `site/wp-content/themes/ea-eyalamit/inc/ea-breadcrumbs.php` (new) |
| WB-02 CSS | `site/wp-content/themes/ea-eyalamit/assets/css/ea-breadcrumbs.css` (new) |
| WB-02 inject | `template-parts/chapters/parts/phero.php`, `mokesh-hero.php`, `section-hero.php`, `inc/wave2-w2-07.php` (editorial/press) |
| WB-03a contact gap | `template-parts/chapters/section-footer.php`, `assets/css/chapters.css` (`.ea-contact-foot-gap`) |
| WB-04a nowrap | `inc/chapters/defaults/{method,lessons,therapist-training,home}-defaults.php`, `inc/chapters/chapters-render.php` (`lang` on span), `style.css` (`.ea-nowrap`) |
| WB-17 nav 88→56 | `assets/css/chapters.css`, `assets/css/faq-toc.css` |
| WB-07 CMP | `inc/ea-cookie-notice.php`, `assets/js/ea-cookie-notice.js`, `assets/css/ea-cookie-notice.css`, `inc/wave2-stage-b.php`, `inc/chapters/chapters-enqueue.php`, `functions.php`, `inc/chapters/defaults/privacy-defaults.php` |
| WB-08 hrefs | `inc/data/ea-faq-seed.json`, `inc/chapters/defaults/lessons-defaults.php`, `mu-plugins/ea-wave-b-faq-href-once.php` (CPT sync) |
| Version + require | `style.css` (1.5.98), `functions.php` (`ea-breadcrumbs.php`) |

## Git commit

- `d3d82b9` — Wave B approved pack (theme + mandate + as-made)
- `5e0017b` — FAQ CPT href sync mu-plugin

## FTP

`Done: FTP deploy site/wp-content (child theme + mu-plugins).` (×2 — after each commit)

## DB post-body hrefs (WB-08 remainder)

FAQ CPT synced via `ea-wave-b-faq-href-once.php` (keys general-07/08/09, lessons-06). Still in WP post content only (not theme):

- mokesh post body → `/eyal-amit/mokesh-dahiman/`
- reversing post → `/treatment/`
- new book blog post
- studio post → `/books/vekatavta/`
- column 49 → `/contact/`
- column 40 muzza → `/books/`

## Smoke GET (no redirect follow)

| URL | Result |
|-----|--------|
| `/method/` HTTP 200 | `ea-crumb` present; `style.css?ver=1.5.98` |
| `/faq/` HTTP 200 | `ea-crumb` present; **0** `www.eyalamit.co.il` in FAQ answers after mu-plugin run |
