# DONE — cbDIDG `lang="en"` on visible text (staging)

| Field | Value |
|-------|--------|
| **Date** | 2026-09-26 |
| **Owner** | team_10 (builder) |
| **Staging** | http://eyalamit-co-il-2026.s887.upress.link |
| **Theme** | `ea-eyalamit` **1.5.142** (`site/wp-content/themes/ea-eyalamit/style.css`) |
| **Deploy** | `python3 scripts/ftp_deploy_site_wp_content.py --allow-dirty` (2 runs; site/ uncommitted) |

## Summary

Render-time + template wiring marks visible Latin token `cbDIDG` with `<span lang="en">cbDIDG</span>` (or preserves existing `<span lang="en" class="ea-nowrap">cbDIDG</span>` in four H1 heroes). **No copy changes.** **No DB / mu-plugin migration** — FAQ and blog HTML pass through `ea_chapters_prepare_body_html()` / `the_content` filter.

Core module: `site/wp-content/themes/ea-eyalamit/inc/ea-cbdidg-lang.php`.

## Counts (measured on 136 sitemap URLs, HTTP 200)

| Metric | Before deploy | After deploy |
|--------|---------------|--------------|
| Pages crawled | 136 | 136 |
| `cbDIDG` in `<body>` (scripts stripped) | **202** | **202** |
| Marked `<span lang="en">cbDIDG</span>` (in body) | **4** | **200** |
| Unmarked `cbDIDG` in body | **198** | **2** |
| Unmarked in `alt` (body) | **2** | **2** |
| **Visible text still unmarked** | **198** | **0** (2 unmarked = `alt` only) |

**Note on brief figure “377”:** Re-measure on this host gives **202** body tokens (shared footer line + page copy), not 377. **534** raw substring hits appear if `<title>`, `<meta description>`, and JSON-LD are included — those were **not** wrapped (rule: no spans in title/meta/schema). If Team 90 uses a counter that includes head/schema or duplicate DOM (e.g. mobile + desktop chrome), align the counter to **body visible text** above.

## Deliberately unmarked (2)

| Location | Reason |
|----------|--------|
| `alt="לוגו cbDIDG, עיגול פסים…"` (home peek image) | HTML **attribute** — wrapping would break `alt` / put tags in attribute |
| `alt="ספירלת cbDIDG חרוטה…"` (home collage image) | Same |

## `ea-nowrap` decision

| Choice | Measurement |
|--------|-------------|
| **Keep existing** `lang="en" class="ea-nowrap"` on **four** H1 heroes only (`/`, `/method/`, `/lessons/`, `/learning/therapist-training/`) — already in defaults before this WP | Wave-B census: `cbDIDG` token already **one line** at 390px with nowrap unit; unchanged |
| **New marks** use **`lang="en"` only** (no `ea-nowrap`) | Avoid `white-space:nowrap` on body/footer/links/FAQ; footer tagline and paragraphs must wrap normally |
| **Not added** to new instances | Adding `ea-nowrap` to isolated tokens in running Hebrew prose would change break points (typography canon: no ad-hoc nowrap in copy) |

Post-deploy: `qa_probe.mjs` on `/`, `/method/`, `/lessons/` — **overflow: false** (mobile/tablet/desktop); no new horizontal overflow.

## Titles / share cards (10 URLs)

Compared before snapshot (`/tmp/ea-cbdidg-titles-before.json`) vs after on: `/`, `/method/`, `/lessons/`, `/treatment/`, `/eyal-amit/`, `/faq/`, `/blog/`, `/en/`, `/learning/therapist-training/`, `/sound-healing/`.

**`<title>`, `meta description`, `og:description` — byte-identical** (titles/meta still contain plain `cbDIDG` text, unwrapped).

## Safety checks

| Check | Result |
|-------|--------|
| Literal `&lt;span` / `lang=` as visible text | **0** pages (`qa_probe` absent scan + 136 crawl) |
| `<span` inside `<title>`, `meta content`, JSON-LD | **0** (grep `/method/` meta/title; schema keeps plain `alternateName":"cbDIDG"`) |
| PHP error strings | **0** / 136 |
| HTTP status | **136/136** 200 |
| Footer instances | **1** / page (`ea-ftr`) |
| Primary nav | Site uses chapters/Wave2 chrome (not `main-navigation` class); footer nav **1** / page |

## Database

**Not involved.** FAQ answers/questions and chapter copy render from theme/DB HTML through PHP helpers; no run-once content patch required.

## Files touched (high level)

- `inc/ea-cbdidg-lang.php` (new)
- `functions.php` (require)
- `inc/chapters/chapters-render.php` (`ea_chapters_kses_e`)
- Chapter partials + FAQ blocks (`ea_chapters_prepare_body_html`, `ea_esc_visible_text`)
- `inc/wave2-w2-07.php`, `inc/wave2-w2-08.php`, `inc/ea-canonical-nav.php`
- `template-parts/blocks/block-hero.php`, `block-method-pillars.php`, `block-faq-list.php`, `block-faq-mini.php`
- `style.css` version **1.5.141 → 1.5.142**

## Team 90

Re-run full 136 URL census: body visible `cbDIDG` = marked `lang="en"` except **two** `alt` strings on `/` (and any page that reuses those images).
