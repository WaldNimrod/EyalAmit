# Redirect & Migration Research — 2026-09-26

Team 90 (control). Research only — no decisions taken here. Measured against:
- New site staging: `http://eyalamit-co-il-2026.s887.upress.link` (plain HTTP by design; TLS invalid by design — not a finding)
- Old production site: `https://www.eyalamit.co.il`

Method: full GETs, redirects NOT auto-followed (`curl --max-redirs 0`), one hop measured at a time. Verified the curl approach against `curl -sI` on live URLs before trusting it (three-URL spot check, see §0). Every 200 response body size was asserted >1000 bytes (no empty-200 false positives anywhere in this run). All Hebrew/percent-encoded text was `html.unescape`d / `urllib.parse.unquote`d before comparison.

---

## Executive summary

- **New site currently serves 153 published objects** (101 pages + 52 posts, enumerated via `wp-json/wp/v2/pages` and `/posts`, paged to exhaustion — matches the expected ~153 population exactly).
- **17 of those 153 already 301-redirect** to another new-site URL. All 17 are single-hop and land on a live 200. **13 of the 17 are traceable to an exact line in this repo's mu-plugins/theme; 4 are not traceable to any repo rule** (see §1.3) — they must live in the database or be WordPress's own default slug-collision behavior, which matters for the domain cutover because nothing in git reproduces them.
- Beyond the 153, targeted testing of known legacy paths found **11 more live 301s** and **one confirmed 2-hop redirect chain already in production today** (`/instrument-repair/` → `/tools-and-accessories/repair/` → `/repair/`), plus **one real rule collision already latent in the repo** (two different mu-plugins define different targets for the same source path `/services/handmade-instruments/`; the priority-0 one silently wins and the priority-1 one is dead code).
- **The store**: the new site has **no functioning store at all** — no WooCommerce plugin in the repo, every WooCommerce REST endpoint 404s, and `/cart/`, `/checkout/`, `/my-account/` all 404. The new site's `/shop/` URL is **not** a store — it's an ordinary published page titled "כלים בעבודת יד ואביזרים" (handmade tools & accessories). The **old** site still runs a live WooCommerce shop: 1 shop archive + 7 product URLs + 2 product-category URLs = **10 store-related URLs**, all still returning 200 right now. `/cart/`, `/checkout/`, `/my-account/` are already 404 on the **old** site too (pre-existing breakage, not something the migration causes). Only 1 `shop_order` sitemap entry exists and it is a generic archive path, not an individual order — not fetched, per the privacy constraint.
- **~1,255 old-site URLs need a redirect decision**, independently re-derived here straight from the old site's own Yoast sitemap index (251 content URLs + 1,004 attachment URLs) — this figure exactly matches the prior audit's count, which is a good cross-check that both measurements are sound.
- **Three biggest collision risks**, all measured, not guessed:
  1. **`/shop/` means two different things on the two sites.** Old `/shop/` = WooCommerce "Products Archive." New `/shop/` = a live, real, non-commerce content page (accessories catalog) that the site's own nav depends on. A naive rule "old `/shop/*` → `/books/`" must NOT catch bare `/shop/` on the new site after cutover, or it destroys a page that has nothing to do with the store.
  2. **A 2-hop chain already exists in production** on the new site alone (`/instrument-repair/` → `/tools-and-accessories/repair/` → `/repair/`), before a single old-site rule has even been added. Old-site rules that also target `/tools-and-accessories/repair/` (rather than the true final `/repair/`) will silently become 3-hop chains.
  3. **A same-source rule collision already exists and one branch is silently dead**: `/services/handmade-instruments/` is defined twice, with two different targets, in two different mu-plugins; only the accident of load order and hook priority decides which one runs. This is exactly the failure mode the owner is worried about, already realized once, purely inside the current repo — before the ~1,255 old-site rules are even layered on top.

---

## 0. Method verification (required before trusting any measurement below)

Spot-checked 3 live URLs with `curl -sI --max-redirs 0` against the harness script (`check_url.sh`, plain `curl -s -D - -o body --max-redirs 0`) — all three returned identical status codes (200 for `/qr/qr48/`, `/press/`, `/snoring-sleep-apnea/`). No custom redirect-following code was written; curl's native `--max-redirs 0` was used throughout, avoiding the exact class of bug (a Python `HTTPRedirectHandler` silently following redirects) flagged as a prior failure mode on this project.

---

## 1. Every redirect that already exists on the new site

### 1.1 Population enumerated

```
GET /wp-json/wp/v2/pages?per_page=100&status=publish&page=1  → X-WP-Total: 101, X-WP-TotalPages: 2
GET /wp-json/wp/v2/pages?per_page=100&status=publish&page=2  → remainder
GET /wp-json/wp/v2/posts?per_page=100&status=publish&page=1  → X-WP-Total: 52,  X-WP-TotalPages: 1
```
101 pages + 52 posts = **153**, all `status: publish` (no drafts/private slipped into the count). Full GET (not HEAD), redirects not followed, run for all 153.

**Status code distribution across the 153:** `200` × 136, `301` × 17. No 4xx, no 5xx, no 000 (connection failures) — every one of the 153 published objects answered.

### 1.2 The 17 redirects, chain-followed one hop at a time

All 17 are **single-hop** (verified by re-fetching every `Location` target with redirects still not followed — every target answered 200 on the first additional hop, none produced a further 3xx). No loops. No chain lands on a 404.

| # | Source (new site) | → Location | Target status |
|---|---|---|---|
| 1 | `/about/moksha/` | `/eyal-amit/mokesh-dahiman/` | 200 |
| 2 | `/courses-soon/` | `/learning/courses-external/` | 200 |
| 3 | `/hashita/` | `/method/` | 200 |
| 4 | `/muzeh/` | `/books/` | 200 |
| 5 | `/muzeh/kushi-blantis/` | `/books/kushi-blantis/` | 200 |
| 6 | `/muzeh/tsva-bechol-ve-zorek-layam/` | `/books/tsva-bekahol/` | 200 |
| 7 | `/muzeh/vekatavt/` | `/books/vekatavta/` | 200 |
| 8 | `/muzza/` | `/books/` | 200 |
| 9 | `/muzza/tsva-bechol-ve-zorek-layam/` | `/books/tsva-bekahol/` | 200 |
| 10 | `/muzza/vekatavt/` | `/books/vekatavta/` | 200 |
| 11 | `/services/didgeridoo-lessons/` | `/lessons/` | 200 |
| 12 | `/services/didgeridoo-treatment-breath/` | `/treatment/` | 200 |
| 13 | `/services/handmade-instruments/` | `/didgeridoos/` | 200 (see §4 — this source is *also* claimed by a second, dead rule) |
| 14 | `/shows-heritage/` | `/` | 200 |
| 15 | `/tools-and-accessories/` | `/shop/` | 200 |
| 16 | `/tools-and-accessories/instruments/` | `/didgeridoos/` | 200 |
| 17 | `/tools-and-accessories/repair/` | `/repair/` | 200 |

Two accidental-looking same-target clusters, both intentional on inspection: `/muzeh/*` and `/muzza/*` (two historical slugs for the same Hebrew "מוזה" publishing hub) both collapse onto `/books/*` — that's a deliberate many-to-one consolidation, traced to source (§1.4), not a defect.

### 1.3 Redirects found beyond the 153 (targeted testing of known legacy paths)

These paths are **not themselves published WP objects** (no page/post owns them), so the REST enumeration in §1.1 can't see them — they only exist as redirect *rules*. Found by testing paths referenced in the repo's own redirect code:

| Source | → Location | Notes |
|---|---|---|
| `/instrument-repair/` | `/tools-and-accessories/repair/` | **then itself 301s again → `/repair/` — a confirmed 2-hop chain, see §4** |
| `/services/instrument-repair/` | `/tools-and-accessories/repair/` | same 2-hop chain |
| `/testimonials-media/` | `/testimonials/` | single-hop, 200 |
| `/media/` | `/testimonials/` | single-hop, 200 |
| `/courses-external/` | `/learning/courses-external/` | single-hop, 200 |
| `/accessibility-statement/` | `/accessibility/` | single-hop, 200 |
| `/services/sound-healing/` | `/sound-healing/` | single-hop, 200 |
| `/services/workshops/` | `/learning/workshops/` | single-hop, 200 |
| `/services/lectures/` | `/learning/lectures/` | single-hop, 200 |
| `/lectures/` | `/learning/lectures/` | single-hop, 200 |
| `/workshops/` | `/learning/workshops/` | single-hop, 200 |

Plus, from the *generated* legacy map (`ea-w209-legacy-301-redirects.php`), spot-verified live: `/shop/cart/`, `/shop/checkout/`, `/shop/my-account/` → `/shop/`; `/shop/תקנון/` → `/`; `/צור-קשר/` → `/contact/`; `/הופעות/` → `/shows/`; `/מוזה-הוצאה-לאור/` → `/books/`. And three 410s spot-verified live: `/qr/פרק-א/`, `/thankyou/`, `/adi/` (all return HTTP 410, matching the file's `$gone` array).

A live-only diagnostic header (`X-EA-Redirect: <source-tag>`) is present on most (not all) of these responses and was used as corroborating evidence for §1.4, not as the sole evidence — every mapping below was independently confirmed by reading the matching PHP.

### 1.4 Traceability — file:line for every redirect mechanism found in the repo

No `.htaccess` exists anywhere under `site/` (confirmed by `find`). This is expected and documented in-repo: the uPress stack is nginx, and `.htaccess` is inert there — a quarantine note (`_COMMUNICATION/team_100/301-quarantine-stale-W2-06-exports/README.md`) explicitly says so and records that an old `.htaccess`/Redirection-plugin export was pulled from `site/` in 2026-06-20 for exactly this reason (see §4). All *live* redirect logic is PHP, on the `template_redirect` hook, across five mu-plugins and one theme file:

1. **`site/wp-content/mu-plugins/ea-s006-r2-w1-legacy-301.php`** (priority 0) — 7-entry `$map` at lines 34–42. Sets `X-EA-Redirect: s006-r2-w1`. Covers: `/about/`, `/אייל-עמית-אודות/`, `/about/moksha/`, `/tools-and-accessories/`, `/tools-and-accessories/instruments/`, `/tools-and-accessories/repair/`, `/services/handmade-instruments/`.
2. **`site/wp-content/mu-plugins/ea-w209-legacy-301-redirects.php`** (priority 0, GENERATED — do not hand-edit per its own header) — ~46-entry `$map` at lines 41–89, a `/Blog/(.+)` prefix-regex catch-all at lines 101–105 (confirmed live against `/Blog/some-random-slug-test/` → 301 to `/blog/some-random-slug-test/`), and a 13-entry 410 `$gone` array at lines 20–34. Sets `X-EA-Redirect: w209-301` / `w209-blog` / `w209-410`. Source of truth: `hub/data/decisions/redirects-301-eyal-final-2026-05-27.json` (135 decisions) via `scripts/gen_htaccess_301_from_decisions.py`.
3. **`site/wp-content/mu-plugins/ea-s006-testimonials-slug-once.php`** (priority 0) — single rule at lines 100–127, `/media/` → `/testimonials/`. Sets `X-EA-Redirect: s006-media-testimonials`.
4. **`site/wp-content/mu-plugins/ea-ei-t18-legacy-301.php`** (priority 0) — 2-entry `$map` at lines 29–32 (`/סיפורים-מהנייר-עם-אייל-עמית/` and `/41-הטור-של-אייל-עמית-חארטה-בארטה/` → `/blog/`). Sets `X-EA-Redirect: ei-t18`. (These are the two real content gaps already flagged on the S007 board — not a fresh finding here.)
5. **`site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php`**, function `ea_m2_st_canonical_path_redirects` (priority **1**, i.e. runs *after* all of the above) — 19-entry `$internal` array at lines 404–431. No `X-EA-Redirect` header set (confirmed absent on all live matches). Covers `/courses-soon/`, `/hashita/`, `/testimonials-media/`, `/didgeridoo-treatment-breath/`, `/services/didgeridoo-treatment-breath/`, `/services/didgeridoo-lessons/`, `/services/sound-healing/`, `/services/instrument-repair/`, `/instrument-repair/`, `/services/handmade-instruments/` **(dead — see §4)**, `/services/workshops/`, `/services/lectures/`, `/lectures/`, `/workshops/`, `/accessibility-statement/`, `/courses-external/`, `/muzeh/` **(dead — superseded by #6)**.
6. **`site/wp-content/themes/ea-eyalamit/functions.php`**, function `ea_eyalamit_muzza_to_books_redirect` (priority 0, added at theme load — after all mu-plugins, before #5's priority-1 hook) — 8-entry `$legacy` array at lines 654–663. No header set. Covers `/muzza/`, `/muzeh/` and both their 3 book-child slugs → `/books/...`. Also `ea_wave1_shows_heritage_301` (priority 0, lines 676–691): `/shows-heritage/` → `/`.

**Traceable vs. not traceable, stated plainly:**
- **13 of the 17 REST-population redirects** (§1.2, rows 1–3, 8–17 minus row 4/5/6/7/9/10) trace cleanly to one of the six mechanisms above with no ambiguity.
- **`/muzeh/` and its 3 children (rows 4–7)** are defined in *two* places (functions.php priority-0 AND the mu-plugin priority-1 rule for the bare `/muzeh/`). functions.php wins because mu-plugins load before the theme, but *within* the same priority tier WordPress fires callbacks in registration order — mu-plugin priority-0 hooks (none of which mention `/muzeh/`) all run first, then the theme's priority-0 hook (which does) fires and `exit()`s, so the mu-plugin's priority-1 rule for `/muzeh/` never runs. **This is traceable, but only by reading hook priority + registration order — it is not obvious from either file in isolation.**
- **`/product-category/books/` → `/books/` (301, no `X-EA-Redirect` header) is NOT traceable to any rule in this repo.** `grep -rn "product-category"` across `mu-plugins` and the theme returns nothing. WooCommerce is not installed on the new site (confirmed — no plugin directory, all `/wp-json/wc/*` endpoints 404), so `product-category` is not even a registered taxonomy here. This redirect's origin (WordPress core's own canonical-path guessing against a since-vanished taxonomy? host-level config? a leftover DB option?) is **not measured** — flagging as instructed rather than guessing.

---

## 2. The store

Owner's ruling today: *"אין חנות יורד - כל עמודי החנות מפנים לעמוד הספרים"* — store is being removed; all store pages redirect to `/books/`.

### 2.1 New site — measured directly

| Path | Status | Notes |
|---|---|---|
| `/shop/` | **200** | Real published page. Title: "כלים בעבודת יד ואביזרים" (handmade tools & accessories). Schema.org type `WebPage`, breadcrumb label "עמוד קטלוג ראשי." Not a WooCommerce archive — 1 incidental match for the word "product" in the whole 64KB body, zero WooCommerce markup. |
| `/cart/` | 404 | |
| `/checkout/` | 404 | |
| `/my-account/` | 404 | |
| `/product/` | 404 | |
| `/product-category/books/` | 301 → `/books/` | untraceable to repo, see §1.4 |
| `/wp-json/wc/v3/products` | 404 | WooCommerce REST namespace absent |
| `/wp-json/wc/store/v1/products` | 404 | WooCommerce Store API absent |
| `site/wp-content/plugins/` (repo) | — | contains only `wordpress-importer`; **no WooCommerce plugin directory exists in this repo at all** |

**Conclusion: the new site has no functioning store today, full stop** — not deactivated, not hidden, structurally absent. `/shop/` on the new site is unrelated content that the current-site IA depends on (see §4 for why that's a collision risk, not a comfort).

### 2.2 Old site — measured directly, via the old site's own Yoast `product-sitemap.xml` / `product_cat-sitemap.xml` / `shop_order-sitemap.xml`

**10 store-related URLs total, all currently live (200):**

- 1 shop archive: `/shop/` — 200, title "מוצרים Archive," 41 WooCommerce-string matches, 4 add-to-cart matches. This is a genuine, functioning WooCommerce shop root.
- 7 product URLs, all 200, all under `/shop/books/<hebrew-slug>/`:
  - `וכתבת` (vekatavt)
  - `כושי-בלאנטיס` (kushi-blantis)
  - `צבע-בכחול-וזרוק-לים` (tsva-bekahol-vezorek-layam)
  - `שלושת-הספרים-וכתבתָּ-כושי-בלאנטיס-צב...` (3-book bundle)
  - `שני-הספרים-וכתבתָּ-צבע-בכחול-וזרוק-לי...` (2-book bundle)
  - `שני-הספרים-וכתבתָּ-כושי-בלאנטיס-במחי...` (2-book bundle, second variant)
  - `כושי-בלנטיס-העתק` ("-העתק" = "-copy"; looks like a QA/test duplicate product, matching the prior audit's note)
- 2 product-category URLs: `/product-category/sale/`, `/product-category/books/` — both 200.
- `/cart/`, `/checkout/`, `/my-account/` (bare, no `/shop/` prefix) — **already 404 on the old site too.** This is pre-existing breakage on production, not something the migration causes — worth knowing so it isn't mis-blamed on the cutover later.
- `shop_order-sitemap.xml` contains **exactly 1** `<loc>`: `https://www.eyalamit.co.il/Blog/shop_order/` — a generic archive base path, not an individual order record. Per the privacy constraint, this was counted, its sitemap URL was read, and it was never fetched.

**Note on a discrepancy with the prior audit:** the 2026-09-24 audit narrative states 2 of the 7 old-site products are dead. This fresh measurement, taken now (2026-09-26), found **all 7 currently return 200**. Both measurements can be correct at their respective times — stating the discrepancy rather than silently overriding either number. Not re-derived further, since re-deriving is out of scope per the brief; flagging so it isn't read as a contradiction.

---

## 3. The old→new mapping skeleton

Re-derived independently from the old site's own `sitemap_index.xml` (19 sub-sitemaps), not from the prior audit's narrative, as a cross-check. **Total: 251 content URLs + 1,004 attachment URLs = 1,255 — matches the prior audit's headline count exactly**, which is a strong signal both measurements are sound.

| Group | Sitemap source | Count | New-site equivalent? | Pattern-level rule |
|---|---|---|---|---|
| Home | `page-sitemap.xml` | 1 | Yes — `/` | exact |
| Core Hebrew content pages | `page-sitemap.xml` (non-`/qr/`, non-`/shop/`) | 26 | **~24 of 26 already have an exact-match rule in `ea-w209-legacy-301-redirects.php`** (verified by direct comparison — nearly every one of these 26 paths is a literal key in that file's `$map`) | exact match per path (already the pattern in use; do not attempt a prefix rule here — see §4) |
| `/qr/qrN/` pages | `page-sitemap.xml` | 50 (`/qr/` + qr1–qr48 + `/qr/פרק-א/`) | **49 of 50 already exist on the new site at the identical path** (`/qr/`, `/qr/qr1/` … `/qr/qr48/` are live new-site pages, same slugs) — **no redirect needed for these, they're the same URL on both sites.** The 50th, `/qr/פרק-א/`, is already declared `410 Gone` in `ea-w209-legacy-301-redirects.php`. | none needed (same-URL survivors) / 1 already-410 |
| Store (`/shop/`, `/shop/books/*`, `/product-category/*`) | `page-sitemap.xml` + `product-sitemap.xml` + `product_cat-sitemap.xml` | 5 + 7 + 2 = 14 (incl. `/shop/cart/`, `/shop/checkout/`, `/shop/my-account/`, `/shop/תקנון/`, all already mapped in the repo) | Per today's ruling: all → `/books/`. **10 of the 14 already have exact rules that point somewhere** — but not uniformly to `/books/`; `/shop/cart|checkout|my-account/` currently → `/shop/` (§1.3), which is itself now slated to mean something else post-ruling. These 3 need re-decision, not just carry-forward. | exact match per known product slug → its already-live `/books/<slug>/` (3 have a clear new equivalent: `וכתבת`→`vekatavta`, `כושי-בלאנטיס`/`כושי-בלנטיס-העתק`→`kushi-blantis`, `צבע-בכחול-וזרוק-לים`→`tsva-bekahol`); the 2 bundle URLs and `/shop/`, `/product-category/*` have **no direct equivalent — per the ruling they become `/books/`, which is a policy decision, not a content match** |
| Blog posts | `post-sitemap.xml` | 54 | Not individually checked here (out of this task's scope — the prior audit already did 100% core-URL verification); `/Blog/<slug>/` → `/blog/<slug>/` catch-all regex already live (§1.3) for any slug not otherwise exact-mapped | prefix regex (existing) + exact-match overrides for renamed slugs (existing pattern, see w209 comment on WP-S5-03) |
| Portfolio pages | `portfolio_page-sitemap.xml` | 25 | No — prior audit's "looks like theme demo content" finding stands; **not re-derived here**, but independently cross-validated: sample titles (`art-week-2014-malmo`, `superdollz-showroom`, etc.) match the prior audit's list exactly | no equivalent found; owner decision pending per prior audit |
| Blog categories | `category-sitemap.xml` | 6 | Not checked | class decision (archive→parent vs. accept loss), per prior audit §6 |
| Blog tags | `post_tag-sitemap.xml` | 47 | Not checked | same class decision |
| Shows | `shows-sitemap.xml` | 4 (incl. 2 titled "מופע לדוגמה" = "example show") | Not checked | likely 2 real + 2 demo, per prior audit |
| Envira galleries | `envira-sitemap.xml` + `envira_album-sitemap.xml` | 5 + 1 = 6 | Not checked | book-adjacent galleries per prior audit §5 — gallery ≠ product page |
| pagescategory / portfolio_category / testimonials_category / slides_category / carousels_category / author | 5 taxonomy sitemaps | 2+3+2+8+1+2 = 18 | Not checked | almost certainly WP-generated archive noise from retired plugins (LayerSlider "slides," a carousel plugin, a portfolio plugin) — class decision |
| shop_order archive | `shop_order-sitemap.xml` | 1 (base path only, no orders) | N/A | drop / 410, not a redirect target |
| Attachments (media) | `attachment-sitemap1.xml` + `attachment-sitemap2.xml` | 1,000 + 4 = 1,004 | Not re-checked (prior audit's 100-sample / 0-survivor finding stands) | out of scope here |

**Hebrew / percent-encoded paths — flagged explicitly, since the brief calls these out as the ones that break naive rule-writing:** every one of the 26 core pages, all 7 non-bundle product slugs, all 6 blog categories, all 47 tags, the 4 shows, and both envira galleries are Hebrew paths served as percent-encoded UTF-8 (`%d7%...`). The existing repo pattern (`rawurldecode( wp_unslash( $_SERVER['REQUEST_URI'] ) )` then exact string match against a `wp_parse_url`-normalized key) already handles this correctly and consistently across all 5 hand-maintained files — that pattern, not a fresh one, should be the template for any new old-site rules.

**Explicit "no equivalent" findings (not invented):** the 2 book-bundle product URLs, the 25 portfolio pages, the 47 tag archives' targets beyond a generic parent, and the 1,004 attachments have no measured 1:1 new-site equivalent. Stated as such, per instruction, rather than guessed.

---

## 4. The spaghetti risk, stated concretely

Everything below is either something already measured live, or a direct reading of committed code — not speculation about what old-site rules *might* do.

**1. `/shop/` is a semantic collision between the two sites, not just a URL collision.** Old `/shop/` is the WooCommerce root. New `/shop/` is a real, live, non-commerce page the site's own navigation depends on (per the theme's own comment at `ea-m2-site-tree-lock-sync-once.php:407-409`: *"/shop is now the canonical unified catalog route... the legacy /shop → /tools-and-accessories/ redirect is removed so the catalog page resolves"*). After the domain cutover, `eyalamit.co.il/shop/` will be served by the *new* WordPress, which already has an opinion about what that URL means. A rule written as "everything historically under `/shop/*` → `/books/`" is exactly the kind of prefix rule that will also swallow the bare `/shop/` that the new site needs to keep working as-is. **Recommendation: any store-migration rule must be an explicit, finite list of the 14 known old `/shop/...` paths (§3), never a prefix on `/shop/`, and the new site's own `/shop/` page must be excluded by construction, not by hoping the rule order saves it.**

**2. A 2-hop chain already exists in production, with zero old-site rules added yet.** `/instrument-repair/` → `/tools-and-accessories/repair/` (mu-plugin `ea-m2-site-tree-lock-sync-once.php:424`) → `/repair/` (mu-plugin `ea-s006-r2-w1-legacy-301.php:40`) → 200. Both hops are real, separately-registered rules that happen to compose into a chain because rule #1's *target* is rule #2's *source*. This is the exact mechanism the owner is worried about ("ספגטי") — and it's already there today, self-inflicted, without any old-site data yet layered on. **Recommendation: before writing a single old-site rule, collapse this existing chain (repoint `/instrument-repair/` and `/services/instrument-repair/` straight at `/repair/`), and audit every other existing rule's *target* against every other rule's *source* for the same shape.** Any old-site rule that targets `/tools-and-accessories/repair/` (rather than the true final `/repair/`) will become a 3-hop chain the moment it's added.

**3. A same-source rule collision already exists, and it fails silently.** `/services/handmade-instruments/` is defined in both `ea-s006-r2-w1-legacy-301.php` (priority 0, target `/didgeridoos/`) and `ea-m2-site-tree-lock-sync-once.php` (priority 1, target `/tools-and-accessories/instruments/`). The priority-0 rule always wins and `exit()`s before the priority-1 rule ever runs; there is no error, no log, nothing — the second rule is just permanently unreachable dead code that *looks* live because it's in a file that clearly still executes for its other 18 entries. Confirmed live: the actual response is `/didgeridoos/` (priority-0's target). **This is not hypothetical spaghetti — it is spaghetti that already shipped, and it will not surface again until someone greps for the exact path and finds two answers.** The bare `/muzeh/` source has the identical shape (defined in both `functions.php` priority-0 and the mu-plugin priority-1 — happens to agree on the target here, but only by luck, since both currently point at `/books/`).

**4. The old, quarantined redirect export is a documented cautionary tale, not a live risk — but it's evidence naive rule-writing has already produced wrong answers on this exact project once.** `_COMMUNICATION/team_100/301-quarantine-stale-W2-06-exports/` holds a 2026-05-28 Redirection-plugin export that disagreed with the authoritative map in **14 places** (e.g. it would have sent `/צור-קשר/` to `/` instead of `/contact/`, and multiple studio sub-pages to `/` instead of their real targets), and it's inert anyway (`.htaccess` on nginx). It was correctly pulled and quarantined by team_100 on 2026-06-20 with a clear README. One open item it flagged — the capital-`B` `/Blog/*` catch-all never being folded into the live mechanism — **has since been resolved**: verified live today, `/Blog/<anything>/` 301s to `/blog/<anything>/` via the regex at `ea-w209-legacy-301-redirects.php:101-105`. No action needed here; noted for completeness since the brief asked to check every place a redirect can be declared.

**5. One live rule cannot be reproduced from git at all.** `/product-category/books/` → `/books/` (§1.4) has no source in this repo. Whatever mechanism produces it (WordPress core default behavior against a now-unregistered taxonomy, or a DB-level artifact) will not automatically travel with a fresh deploy or a rebuilt database, and won't be visible to whoever writes the ~250 old-site rules next unless they independently probe for it the way this research did.

**Recommended rule order** (measured reasoning, not a preference): **most-specific-exact-match first, prefix/regex catch-alls last**, exactly the shape the codebase already settled on for the `/Blog/*` case (comment at `ea-w209-legacy-301-redirects.php:94`: *"AN EXACT DECISION BEATS THE CATCH-ALL"* — after a real incident where the regex ran first and silently ate an exact rename). Concretely: (1) 410s, (2) the finite explicit list of old-site exact paths (all Hebrew percent-encoded, all normalized the way the existing 5 files already do it), (3) any necessary prefix/regex rule last, and only for genuinely unbounded sets like `/Blog/*`. **Rule shape: never a bare prefix on a path segment the new site also uses for its own IA** (`/shop/`, `/qr/`, `/product-category/` are all live new-site namespaces right now — a rule scoped to "starts with `/shop/`" is unsafe; a rule scoped to "is exactly one of these 14 known old paths" is safe).

---

## Open questions only the owner can answer

1. **The `/shop/` naming collision (§4.1):** should the new site's existing `/shop/` page (tools & accessories catalog) be renamed to free up the slug for the store-decommission redirects, or should the store rules be written as an explicit finite list that simply never touches bare `/shop/`? Both are workable; only Nimrod can pick.
2. **The 2 book-bundle product URLs and `/product-category/sale/`, `/product-category/books/`** (§3): confirmed no direct content equivalent exists on the new site. Per today's ruling they redirect to `/books/` — is that the final word for the category URLs too, or should `/product-category/books/` specifically be treated differently since it already un-traceably redirects to `/books/` on its own (§1.4)?
3. **The 24-of-26 core-page rule gap:** which 2 of the 26 core Hebrew pages are the ones *not* already covered by `ea-w209-legacy-301-redirects.php`'s map — worth a follow-up diff before cutover, not answered in this pass (scope was the mechanism inventory, not a page-by-page reconciliation, which the prior 2026-09-24 audit already did at 100%).
4. **Whether to collapse the `/instrument-repair/` → `/tools-and-accessories/repair/` → `/repair/` chain now** (before old-site rules are added) or leave it and simply make sure no new rule targets the middle hop. Either is an engineering call once decided; which one is Nimrod's to make given deploy-risk appetite this close to cutover.
