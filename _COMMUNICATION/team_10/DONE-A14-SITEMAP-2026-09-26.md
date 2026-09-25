# DONE — A14 `/learning/therapist-training/` restored to the sitemap (2026-09-26)

## Root cause

Yoast SEO 28.5 omitted the page because post meta `_yoast_wpseo_meta-robots-noindex` was `1` on that page alone. Yoast copies that into the indexable (`is_robots_noindex`) and leaves noindex indexables out of `page-sitemap.xml`.

The value was written by `ea_m2_site_tree_lock_sync_run()` in [site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php) (`update_post_meta( $tid, '_yoast_wpseo_meta-robots-noindex', '1' )` on the `therapist-training` page). That sync is option-guarded and had already run, so the meta stayed in the database. The path is not in [site/wp-content/mu-plugins/ea-w2-17-sitemap-exclusions.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/mu-plugins/ea-w2-17-sitemap-exclusions.php). A search of `site/wp-content` for `wpseo_sitemap`, `wpseo_exclude`, and `_yoast_wpseo_meta-robots-noindex` found no other sitemap filter and no other writer of that meta key.

## Evidence (before the change)

Staging base `http://eyalamit-co-il-2026.s887.upress.link`. Redirects not followed.

| Measurement | Result |
|---|---|
| `GET /learning/therapist-training/` | **200**, 69863 bytes, `Location` absent |
| Canonical tags on that HTML | **1**: `http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/` |
| HTML `robots` meta | `noindex, nofollow` — same tag on sibling `/learning/lectures/` (staging host filter in `ea-staging-noindex.php`, every page) |
| REST `GET /wp-json/wp/v2/pages?slug=therapist-training` | id **21**, status **publish**, type **page**, parent **58**, link the URL above |
| `yoast_head_json.robots` on id 21 | `{"index":"noindex","follow":"follow"}` |
| `yoast_head_json.canonical` on id 21 | **absent** |
| Same fields on sibling `/learning/lectures/` (id 61, parent 58, publish) | `index`/`follow` plus a canonical |
| Published pages with `yoast_head_json.robots.index != "index"` | **1 of 101** — id 21 only |
| Published posts with `robots.index != "index"` | **0 of 52** |
| `sitemap_index.xml` | **200**, **2** locs: `post-sitemap.xml`, `page-sitemap.xml` |
| `page-sitemap.xml` / `post-sitemap.xml` | **82** + **53** = **135** unique locs |
| Target in either sitemap | **absent** |
| REST `context=edit` meta | 2 keys, neither Yoast. The raw meta key is not exposed. The once-plugin below refuses to finish unless `get_post_meta` returns `1`, and the Yoast head flipped only after that run. |

Plugin `wordpress-seo/wp-seo` version **28.5**, status active.

## Fix

Commit `3cea4c876e14` on `main`. Not pushed.

1. [site/wp-content/mu-plugins/ea-a14-therapist-training-sitemap-once.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/mu-plugins/ea-a14-therapist-training-sitemap-once.php) — resolves `learning/therapist-training` by path, deletes `_yoast_wpseo_meta-robots-noindex` only when the stored value is `1`, then returns. Yoast's `Indexable_Post_Meta_Watcher` (28.5) rebuilds the indexable on shutdown because the key uses the Yoast meta prefix. Flag `ea_a14_therapist_training_sitemap_v1`. Does not run on REST.
2. The site-tree sync no longer writes that meta, so a later reset of `ea_m2_site_tree_lock_sync_v3` cannot put the URL back out of the sitemap.
3. [site/wp-content/themes/ea-eyalamit/inc/seo-head-fallbacks.php](file:///Users/nimrod/Documents/AOS_V5/EyalAmit.co.il-2026/site/wp-content/themes/ea-eyalamit/inc/seo-head-fallbacks.php) — the extra canonical prints only while that meta is still `1`. After the delete, Yoast prints the one canonical. Theme version in `style.css` was not bumped.

Deploy: `python3 scripts/ftp_deploy_site_wp_content.py` on a clean `site/`. Log line: `Deploying tree of commit 3cea4c876e14`. Upload included `ea-a14-therapist-training-sitemap-once.php`, `ea-m2-site-tree-lock-sync-once.php`, and `inc/seo-head-fallbacks.php`. Ended `Done: FTP deploy site/wp-content (child theme + mu-plugins).`

Triggered by `GET /` (200). The once-plugin does not run on REST, and the indexable rebuild is on shutdown, so the sitemap was read on a later request.

## Acceptance (after)

| Check | Result |
|---|---|
| `page-sitemap.xml` + `post-sitemap.xml` | **83 + 53 = 136** unique `<loc>` |
| `/learning/therapist-training/` | **1** occurrence, in `page-sitemap.xml` only |
| Set difference, both directions | **added** exactly `http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/` · **removed** none |
| `sitemap_index.xml` | **200**, still **2** locs (post, page) |
| `GET /learning/therapist-training/` redirects not followed | **200**, 69864 bytes |
| Canonical tags on that HTML | **1**, href that same URL |
| `yoast_head_json.robots` | `index` / `follow` / `max-snippet:-1` / `max-image-preview:large` / `max-video-preview:-1` |
| `yoast_head_json.canonical` | `http://eyalamit-co-il-2026.s887.upress.link/learning/therapist-training/` |
| HTML `robots` meta | still `noindex, nofollow` — the staging-wide tag, same as every other staging URL |
| 136 sitemap URLs, redirects not followed | **136/136 HTTP 200**, final URL equal to the loc, **0** bodies containing `Fatal error`, `Parse error`, `Uncaught `, `There has been a critical error`, `<b>Warning</b>`, `<b>Notice</b>`, `<b>Deprecated</b>`, `<b>Fatal error</b>` |

## Next

Team 90 remeasures the two child sitemaps and the 136 URLs. This session does not push.
