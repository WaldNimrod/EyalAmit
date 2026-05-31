# Composition Notes — WP-W2-10-D (Blog cluster) — S1

Screen-by-screen composition rationale citing D-14 atom IDs. **Composition-only** — every value is a verbatim D-14 token; no new atoms, no new token values (AC-U1). Source CSS: `ea-tokens.css`, `ea-atoms.css`, plus the W2-06 build sheet `ea-blog.css` (already L-GATE_VALIDATE PASS).

---

## Screen 1 — Blog archive (`/blog`, `tpl-blog-archive.php`)

Block order top→bottom, matching the deployed template's `get_template_part` sequence:

1. **atom-nav-topnav** (`.ea-topnav`, ea-atoms.css) — fixed dark glass bar, `--ea-nav-height` 64px, `aria-current="page"` on בלוג. Brand right, links centre/left per RTL flex.
2. **Page title** `.ea-page-title` — `font:var(--ea-type-h1)` (200 / 2.8rem), centred, `margin-block-end:var(--ea-space-5)`. Single H1 per page.
3. **Category filter** `.ea-blog-filter` → `.ea-blog-filter__item` — pill-ish bordered chips, `--ea-type-body-sm`, `gap:var(--ea-space-2)`, centred, wraps. Active state `--ea-blog-filter__item--active` paints `--ea-accent` border + `--ea-bg-alt` fill. Real categories from staging: הכל / כללי / ספרים בהוצאת מוזה / סיפורים מהספר 'וכתבת' / הוצאה לאור - ספרים / תופעת יחיד - מופע הסיפורים / כתבה על תופעת יחיד. (All 12 live posts are currently in כללי — see open question Q3.)
4. **Card grid** `.ea-blog-grid` — 3-up desktop → 2-up ≤900px → 1-up ≤560px, `gap:var(--ea-space-5)`. Holds N × `block-blog-card`.
   - **block-blog-card** (`.ea-blog-card`): 16:9 thumb (`--ea-bg-alt` ground; gradient placeholder when no featured image), body padded `--ea-space-3`. Vertical rhythm via `gap:var(--ea-space-1)`.
     - cat eyebrow `.ea-blog-card__cat` — `--ea-type-caption`, `--ea-accent`, uppercase + `letter-spacing:0.08em`.
     - title `.ea-blog-card__title` — `--ea-type-h3` (400 / 0.92rem), `line-height:1.45`. Long real titles (e.g. the ריברסינג post) wrap to 3–4 lines — acceptable; titles are the primary scent.
     - excerpt `.ea-blog-card__excerpt` — `--ea-type-body-sm`, `--ea-text-body`, clamped to 3 lines (`-webkit-line-clamp:3`). **IDEA-006 demonstrated here:** excerpts shown are shortcode-stripped clean Hebrew, NOT the raw `[vc_row …]` strings currently served by staging (see HANDOFF Bonus).
     - date `.ea-blog-card__date` — `--ea-type-caption`, `--ea-muted`.
   - Card link a11y: outer wrapper `tabindex="-1"` + `:focus-within` ring on the card; the title `<a>` is the real tab stop — single focusable target per card, no duplicate-link SR noise.
5. **Pagination** `.ea-blog-pagination` — centred bordered chips, `.current` = `--ea-accent`. Staging reports 5 pages (12 posts/page). `aria-label="ניווט עמודים"`; current page marked `aria-current="page"`; ellipsis `aria-hidden`.
6. **atom-data-display-footer-social** (`.ea-footer`, ea-atoms.css) — dark `--ea-ink` footer.

## Screen 2 — Blog single (`/blog/<slug>`, `tpl-blog-single.php`)

1. **atom-nav-topnav** — identical.
2. **Featured image** `.ea-post-featured` — full-width, `margin-block-end:var(--ea-space-6)`. Real staging post has none → D-14 earth→chocolate→ink gradient placeholder carrying an `aria-label` (mirrors `.ea-book-hero` gradient language already in ea-atoms.css). See Q2.
3. **Title** `.ea-page-title` — `--ea-type-h1`. The real title is long; H1 wraps gracefully on the `--ea-prose-width` column.
4. **Meta row** `.ea-post-meta` — author / date / category, `--ea-type-body-sm`, `--ea-muted`, separated by `gap:var(--ea-space-3)`, underlined with `--ea-line`. NOTE author on staging is the WP login `eyaladmin`; shown here as the intended display name **אייל עמית** (see Q1).
5. **Reading column** `.ea-post-content` — **AC-D3 long-Hebrew typography:**
   - body `font:var(--ea-type-body-lg)` (300 / 1.05rem) with explicit `line-height:1.9` (generous leading for Hebrew, no descenders but tall stacked diacritics tolerate the openness).
   - **`max-width:66ch`** added at composition level to cap measure (the prose wrapper is already `--ea-prose-width` 960px, but 66ch keeps the line ~45–75 Hebrew chars for comfortable RTL saccades). This uses no new token — it is a `ch` constraint, flagged for team_10/team_80 review (Q4).
   - paragraph spacing `margin-block-end:var(--ea-space-3)`; `h2`=`--ea-type-h2`, `h3`=`--ea-type-h3`. Body colour `--ea-text-body` (#5A3826, AA on `--ea-bg`).
6. **Tags** `.ea-post-tags` — bordered chips, `--ea-type-body-sm`.
7. **Share row** `.ea-post-share` — *composition proposal* (spec single = "…+ share"); not in current W2-06 build. Round 40px bordered icon buttons reusing footer-social geometry; each has `aria-label`. Flagged with the olive "הצעת קומפוזיציה" badge in the mockup. See Q5.
8. **Related posts** `.ea-related` — *composition proposal* (spec single = "…+ related posts"); reuses `.ea-blog-card` at 2-up, titles only (`--ea-type-h3`). See Q5.
9. **contact-cta block** — centred `.ea-contact-section` (`--ea-bg-alt`) with `.ea-cta-pill--primary`; this is appended by `tpl-blog-single.php` (`block`,`contact-cta`).
10. **footer-social**.

## RTL / a11y posture
- `dir="rtl" lang="he"` on `<html>`; logical props (`margin-block`, `inset-inline`, `border-inline-start`) throughout — no hard left/right that would break a future `/en` mirror.
- One H1 per page; `h2`/`h3` hierarchy preserved; landmark `main#main` + skip link.
- All interactive elements carry `:focus-visible` rings (`2px solid var(--ea-terracotta)`).
- Contrast: `--ea-text-body` #5A3826 and `--ea-muted` #6F635A both meet AA on `--ea-bg`/`--ea-bg-alt` (per D-14 2026-05-27 audit notes in tokens).
- Card pattern avoids nested-interactive: only title `<a>` is tabbable; thumb wrapper is `tabindex="-1"`.

## Atoms intentionally NOT introduced
No new atoms invented. Share + related are compositions of existing patterns (footer-social geometry; blog-card). If Eyal approves them as permanent, team_80 must register them via GCR before S4 — flagged, not assumed.
