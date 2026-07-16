---
id: RESEARCH-WP-S5-01-GROUND-TRUTH-2026-07-16
from_team: team_100
date: 2026-07-16
type: research-preserved-for-handoff
wp: WP-S5-01
status: COMPLETE — ready to fold directly into WP-S5-01-LOD400 authoring
---

# Preserved ground-truth research — WP-S5-01 (quick-verify residuals)

Produced by an Explore agent during this session, before the task was correctly redirected to a canonical
handoff (per team_00 instruction, 2026-07-16). Complete — use directly, no need to re-run.

## Item 1 — Blog pagination bug: **ABSENT (already fixed)**

Historical bug (`/blog/page/N/` always serving page-1 posts) is fixed in the LIVE template. Two templates exist with the fix; only one is wired to actually serve `/blog/`:
- `inc/chapters/chapters-routing.php:80-104` — `ea_chapters_blog_template_include()` on `template_include` priority 105 (beats legacy router @100 and Chapters-page router @103) → routes to `page-templates/tpl-chapters-blog-archive.php` — **this is the live one**.
- `page-templates/tpl-blog-archive.php` has the identical fix but is dead code under Chapters-enabled routing.

Fix (`tpl-chapters-blog-archive.php:14-20`): `$paged = max(1, (int) get_query_var('paged'), (int) get_query_var('page'), isset($_GET['paged']) ? absint($_GET['paged']) : 0);` — correctly reads `get_query_var('paged')` first (the historical bug read only `$_GET['paged']`).

Live curl (staging): `/blog/`, `/blog/page/2/`, `/blog/page/3/`, `/blog/page/5/` all 200, each with a distinct post-slug set and correct `page-numbers current` marker. **Confirmed fixed — no dev work needed.** If re-tested, assert against `tpl-chapters-blog-archive.php`, not the dead `tpl-blog-archive.php`.

## Item 2 — FAQ section-TOC: **PRESENT (built and live)**

Full sticky topic TOC is built: `template-parts/blocks/block-faq-list.php:58-79` builds `$ea_faq_toc` from categories with actual questions, renders `<nav class="ea-faq-toc" ...>` with anchor links to `#faq-topic-<slug>`; matching `id="faq-topic-<slug>"` divs at line 90. Sticky CSS (`assets/css/faq-toc.css:14-15`), scroll-spy JS with `IntersectionObserver` + smooth-scroll + reduced-motion respect (`assets/js/ea-faq-toc.js`).

Live curl on `/faq/`: 13 anchor chips (`#faq-topic-treatment`, `#faq-topic-lessons`, `#faq-topic-sound-healing`, `#faq-topic-method`, `#faq-topic-didgeridoos`, `#faq-topic-bags`, `#faq-topic-stands-storage`, `#faq-topic-stand-floor`, `#faq-topic-repair`, `#faq-topic-general`, `#faq-topic-vekatavta`, `#faq-topic-kushi-blantis`, `#faq-topic-tsva-bekahol`) — all 13 have matching target divs. **Built and shipped.** Spec should read "confirm-only" (regression: chip count == categories-with-questions count, each href target exists), not "build."

## Item 3 — Shop pages in nav: **PRESENT (in the actual nav menu)**

All 5 shop routes are explicit `<li><a>` entries in the hard-coded top nav's "כלים ואביזרים" dropdown — `template-parts/chapters/section-nav.php:36-46`: `/shop/`, `/repair/` (L40), `/didgeridoos/` (L41), `/bags/` (L42), `/stands-storage/` (L43), `/stand-floor/` (L44). Menu is intentionally template-fixed (not WP-editor-managed, per file's own header comment) — this counts as "the actual site navigation."

Live curl on `/` — isolated the `<nav class="nav" id="nav">` block: all 5 hrefs found inside it. **Present and correct — no gap, no dev work needed.**

## Item 4 — QR direct-200 assertion: **PASSES on staging; documented risk is production-only**

Master plan §8 item 3 (exact wording): parent `/qr/` + 48 `/qr/qrN/` = 49 rows, all must be DIRECT 200 (no redirect-follow) — because a **documented production-only** 302 exists (`docs/project/team-100-preplanning/QR-URL-INVENTORY.csv` row 1: "VERIFIED 2026-05-26: parent /qr/ exists on prod but currently 302-redirects to /shop/books/וכתבת/ — may need fix").

Mechanism: `/qr/` → `tpl-chapters-page` type `qr-hub` (`chapters-render.php:48`); `/qr/qrN/` children → `tpl-chapters-qr` via parent-slug pattern route (`chapters-render.php:73-77` + `chapters-routing.php:35-46`) — each QR child is a real WP page with real `post_content`, not sections-based.

Live curl (direct, no `-L`, vs `-L` follow) on `/qr/`, `/qr/qr1/`, `/qr/qr2/`, `/qr/qr24/`, `/qr/qr48/`: **all 5 direct HTTP 200, zero redirects, on staging.** CSV confirms exactly 49 rows (qr + qr1..qr48) — "49, not 48" framing is correct.

**Spec note (important):** staging-pass does NOT prove the prod-only 302 is resolved — the redirect engine is prod-conditional and staging cannot substitute for prod testing here. `final_pre_cutover_check.sh` must re-run this exact check (all 49 CSV rows, no `-L`, assert 200 + no Location header) **after production cutover** specifically. Do not mark this item fully "closed" from staging evidence alone.

## Item 5 — Route-completeness schema/meta spot-check: **MIXED — 2 real gaps found (of 6 sampled)**

Two independent mechanisms, neither WP-editor-managed:
1. **Meta description** — `inc/seo-head-fallbacks.php`, `ea_w2_09_route_description()` (L37-78): hard-coded slug→description map (L38-51) covering `eyal-amit, shop, didgeridoos, bags, stands-storage, stand-floor, repair, books, muzza, blog, faq, contact`. For slugs NOT in the map, falls back to Chapters `phero.sub` ONLY if that slug is a Chapters route. **`press` is in neither** → no fallback path exists.
2. **JSON-LD schema** — mu-plugin `ea-w2-seo-schema.php` (`add_filter('wpseo_schema_graph', ..., 20, 2)` L237), augments Yoast's base graph with page-specific nodes gated on hard-coded slug arrays: `Service` (`$services` L99-103: treatment/sound-healing/lessons), `Product` (dynamic, gated on `ea_product_price` postmeta), `FAQPage` (`$ea_faq_pages` L150-166, 13 slugs), `Book` (`$ea_book_slugs` L180, 3 slugs), `Person+VideoObject` (hard-coded to `mokesh-dahiman` only, L196-233). **`press` and `qr`/`qrN` appear in NONE of these arrays.**
3. **noindex** — only two mechanisms exist site-wide: `ea-staging-noindex.php:38-46` (global, host-conditional on `upress.link`, staging-only safety net — NOT a route-specific editorial decision) and a one-time noindex postmeta setter scoped only to `therapist-training`. **No route-specific noindex exists for `/press/` or any QR page.**

**Per-route live findings (staging):**

| Route | Meta description | Schema page-specific node | Verdict |
|---|---|---|---|
| `/repair/` | Present (map L45) | `FAQPage` 6 Q&A | Complete |
| `/bags/` | Present (map L42) | `FAQPage` 7 Q&A | Complete |
| `/books/vekatavta/` | Present (Chapters `phero.sub` fallback) | `Book` node | Complete |
| `/eyal-amit/mokesh-dahiman/` | Present (Chapters `phero.sub` fallback) | `Person`+`VideoObject` | Complete |
| `/press/` | **MISSING** — no `<meta name="description">` at all | **MISSING** — only Yoast generic base graph | **GAP** |
| `/qr/qr1/` (sample of 48) | **MISSING** — only auto-OG from post excerpt | **MISSING** — only base graph | **GAP** |

(The `x-robots-tag: noindex` header seen on ALL 6 sampled routes is the staging-wide safety-net plugin — present identically on the complete AND gapped routes; it does not count as "explicit noindex" for this item's purpose, and will not exist on production.)

**Build-spec acceptance criteria (concrete, closes this item):**
1. Add a `press` entry to `inc/seo-head-fallbacks.php`'s `$map` (L38-51), or make `press` a Chapters-view route so the `phero.sub` fallback applies.
2. The 48 `/qr/qrN/` pages have real unique `post_content` per page but no generic description/schema mechanism — fix via either (a) generate meta description from each page's own excerpt/content (mirror the existing `is_singular('post')` excerpt fallback at `seo-head-fallbacks.php:57-62`), or (b) add an explicit, deliberate noindex for QR pages via a real mu-plugin rule keyed on the `qr` parent-slug pattern (not the staging-only plugin) if they're meant to stay unindexed.
3. `ea-w2-seo-schema.php` needs either a `press`-specific schema node (e.g. `Article`/`CollectionPage`) or an explicit documented decision that `/press/` is schema-exempt.
4. Re-run the master plan's §3 enumerated-route audit (Schema.org validator + Google Rich Results Test) on `/press/` and a `/qr/qrN/` sample after the fix — these are the only 2 of 9 enumerated route classes without coverage.

## Cross-note vs WP-S5-02

Item 5 here overlaps directly with WP-S5-02's "route-completeness schema/meta" item (same master-plan §8 item 7) — the LOD400 authoring session should treat this as ONE finding shared across both WPs' specs, not duplicate work, and decide which WP owns the actual fix (recommend: WP-S5-02, since it's explicitly the SEO/GEO-completion package; WP-S5-01 should just carry the verification/confirm-only framing).
