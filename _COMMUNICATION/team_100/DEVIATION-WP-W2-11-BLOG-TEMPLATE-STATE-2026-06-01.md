---
id: DEVIATION-WP-W2-11-BLOG-TEMPLATE-STATE-2026-06-01
from_team: team_100 (Chief System Architect)
to_team: team_00 (record) / team_10 (Cluster 2 builder)
date: 2026-06-01
wp: WP-W2-11 (S003 Base Implementation)
cluster: Blog (D) — /blog, /blog/<slug>
type: INVESTIGATION / RECORD CORRECTION
status: CLEARED — no blocker
---

# Blog template state — investigation & clearance (Cluster 2)

## Why this note exists
During WP-W2-11 startup exploration, a sub-investigation reported that the Blog templates
(`tpl-blog-archive.php`, `tpl-blog-single.php`) were **STUBs with no `WP_Query` / `have_posts()`
loop**, contradicting the spec's claim that Blog was "built in W2-06 (REAL)". I surfaced that as a
suspected discrepancy to team_00 before issuing the Cluster 1 mandate. This note records the
direct-inspection result.

## Finding: the earlier audit was WRONG — templates ARE built
Direct read of both files (`site/wp-content/themes/ea-eyalamit/page-templates/`):

- **`tpl-blog-archive.php`** (86 lines) — REAL: `new WP_Query($query_args)` (L24),
  `if ($blog_query->have_posts())` (L51), `while (...) : $blog_query->the_post()` (L54),
  renders `block-blog-card` per post (L55), `block-footer-social` (L85).
- **`tpl-blog-single.php`** (77 lines) — REAL: standard WP loop `while (have_posts()) : the_post()`
  (L19), `the_post_thumbnail('large', ...)` (L23), `the_content()` (L56), `block-contact-cta` (L75),
  `block-footer-social` (L76).

This is **consistent with the spec and the team_00 decision** ("Blog … built in W2-06; implement the D
composition"). There is **no STUB issue and no reconciliation needed.**

## Disposition
- **Blog (Cluster 2) is clear to proceed** on the normal S3→S4→S5 path after Cluster 1 (Conversion)
  closes — composition-only refine on top of the W2-06 build, per the team_35 WP-W2-10-D package.
- The WP-W2-11 `roadmap.yaml` progress note has been **corrected** to drop the STUB claim.
- Carry-forwards still apply at Blog S3 (per spec §"Carry-forwards into S3"): featured-image
  placeholder strategy + empty categories + share/related (team_80 GCR), IDEA-006 excerpt
  `[vc_row]` strip (W2-06 P3). These are refinements, not blockers.

## Process note
The false STUB claim came from a broad fan-out search agent reading excerpts rather than the whole
files. Logged so the record is accurate; no action required beyond proceeding with Blog as planned.
