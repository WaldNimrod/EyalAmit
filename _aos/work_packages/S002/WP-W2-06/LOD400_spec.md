# LOD400 Spec — WP-W2-06
# Wave2 Blog Migration — 54 Posts + Categories/Tags + Archive + Single + 301s + Media Localization

**WP ID:** WP-W2-06 | **Track:** A | **Milestone:** S002 | **Profile:** L0
**Builder:** team_10 (claude-sonnet-4-6) | **L-GATE_BUILD:** team_50 (cursor-composer) | **L-GATE_VALIDATE:** team_190 (Codex/OpenAI)
**Branch:** feature/w2-06-blog | **Staging:** http://eyalamit-co-il-2026.s887.upress.link
**Authored:** 2026-05-28 (team_100, retro-LOD400 from delivery per team_00 disposition) | **lod_status:** LOD400

---

## Objective
Migrate the legacy blog (54 posts) into the Wave2 site as an SEO asset: posts at the canonical root permalink, full taxonomy, Wave2-styled archive + single templates, all legacy `/Blog/` URLs 301-redirected, and **all referenced media physically localized** to the new site with relative links (no hotlinks to the legacy domain or third-party CDNs).

## Architecture / cross-cutting
| ID | Requirement | Anchor |
|----|-------------|--------|
| X-01 | Permalink structure `/%postname%/` (M2 standard). Posts at root `/<slug>/`. | WP setting |
| X-02 | `/blog/` is the WP **Posts page** (`page_for_posts=18`, `is_home()`). WP ignores page templates on the posts page → archive routed via `template_include`. | `inc/wave2-w2-06.php` `ea_w2_06_template_include()` |
| X-03 | Archive → `page-templates/tpl-blog-archive.php` on `is_home() && !is_front_page()`; single post → `page-templates/tpl-blog-single.php` on `is_singular('post')`. Both set `ea_wave2_shell` query var (Wave2 active view → asset enqueue + Stage-B dequeue). | `inc/wave2-w2-06.php` |
| X-04 | Shortcode cleanup: strip legacy VC/Elementor shortcodes on render (no DB mutation). | `mu-plugins/ea-blog-shortcode-cleanup.php` |
| X-05 | `style.css` `Version: 1.4.0` (W2-06 slot; W2-02 owns 1.4.1). | theme `style.css` |
| X-06 | Blog CSS uses D-14 tokens only (no raw hex). | `assets/css/ea-blog.css` |
| X-07 | `validate_aos.sh` → 0 FAIL. | CI gate |

## Content migration (delivery facts)
- **54 posts**, all `publish`, author mapped to `eyaladmin` (id 1), original dates + slugs preserved. Imported via WP REST (Application Password) — `_COMMUNICATION/team_100/tools/import_blog_wxr.py`.
- **6 categories** with hierarchy: top-level `כללי`, `הוצאה לאור - ספרים`, `כתבה על תופעת יחיד...`, `תופעת יחיד - מופע הסיפורים...`; children of `הוצאה לאור - ספרים`: `סיפורים מהספר 'וכתבת'`, `ספרים בהוצאת מוזה`.
- **47 tags** (inline post_tag terms across 27 tagged posts). (Earlier "126/126 tags" estimate corrected to 47.)
- Source WXR: `site/exports/blog-legacy.wxr` (54 `<item>`, 0 attachment items).
- Default `hello-world` post demoted to draft.

## Media localization (team_00 directive — mandatory)
- ALL embedded media downloaded and rehosted under new-site `wp-content/uploads/` with **root-relative** links; tool: `_COMMUNICATION/team_100/tools/media_localize.py` (idempotent).
- Mapping: legacy `eyalamit.co.il/wp-content/uploads/...` → mirrored path; external CDNs → `wp-content/uploads/ea-legacy/<host>/<hash>-<name>`.
- **158/164 migrated.** 6 unrecoverable (dead at source, NON-BLOCKING): `blog.muzza.co.il` (DNS dead) ×2, `namaste.co.il` 404, `gallery.mailchimp.com` 403 ×2, 1 legacy 404. These were already broken pre-migration.

## 301 redirects
- Catch-all: legacy `/Blog/<slug>/` → 301 → root `/<slug>/` (slugs preserved): `RewriteRule ^Blog/(.+)$ /$1 [R=301,L,NC]`.
- Plus 26 page-level legacy redirects (kept from builder file).
- Deployed to live web-root `.htaccess` (backup taken) via `_COMMUNICATION/team_100/tools/deploy_htaccess_301.py`.

## Acceptance Criteria (gate — per GO-SIGNAL correction, root URLs)
| AC | Criterion |
|----|-----------|
| AC-01 | 54 posts → HTTP 200 at **root `/<slug>/`** (sample ≥10) |
| AC-02 | author/date/categories/tags preserved; Wave2 single template routed |
| AC-03 | post images load from new site (`/wp-content/uploads/...`, relative); 6 dead-source refs excluded |
| AC-04 | `/blog/` renders Wave2 archive (`ea-wave2-shell`, blog card grid, category filter, pagination); no raw `[vc_row]` |
| AC-05 | `/Blog/<slug>/` → 301 → root `/<slug>/` (sample ≥5) |
| AC-06 | `validate_aos.sh` 0 FAIL |
| AC-07 | no VC/Elementor shortcode artifacts in rendered posts or archive excerpts |
| AC-08 | `style.css` Version present |

## Out of scope / follow-ups
- Internal legacy cross-links (`<a href>` to `www.eyalamit.co.il/Blog/...` inside post bodies) — candidate follow-up (localize to relative), pending team_00 decision.
- Wave2 blog post design polish beyond template routing.

## Files (delivery reference)
`page-templates/tpl-blog-archive.php`, `tpl-blog-single.php`, `template-parts/blocks/block-blog-card.php`, `inc/wave2-w2-06.php` (incl. archive/single template routing), `assets/css/ea-blog.css`, `mu-plugins/ea-blog-shortcode-cleanup.php`, `functions.php` (require), `style.css` (1.4.0). 301 + import + media tooling under `_COMMUNICATION/team_100/tools/`.

## Gate sequence
L-GATE_SPEC (this doc) → L-GATE_BUILD (team_50) → L-GATE_VALIDATE (team_190).
