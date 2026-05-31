# Asset Manifest — WP-W2-10-D (Blog cluster) — S1

Featured-image strategy for archive cards + single post.

## Status on staging (`http://eyalamit-co-il-2026.s887.upress.link`)
- Archive `/blog/` (HTTP 200): 12 posts, all category **כללי**. Cards render via `block-blog-card`, which calls `the_post_thumbnail('medium_large')`.
- The post bodies are Visual-Composer (`[vc_single_image image="…"]`) layouts; many embed images **inside the content**, but it is **not confirmed** that each post has a WP **featured image** (`_thumbnail_id`) set. The card thumb + single hero both depend on the featured image, not on in-content `[vc_single_image]`.

## What exists vs. what Eyal must provide

| Slot | Source | Exists now? | Action |
|------|--------|-------------|--------|
| Archive card thumb (16:9) | `the_post_thumbnail('medium_large')` | **Unconfirmed per-post** | If a post has no featured image → graceful gradient placeholder (`.ea-blog-card__thumb-placeholder`, sand→bg-alt). Eyal/editor should set a featured image per post for visual parity. |
| Single featured hero | `the_post_thumbnail('large')` | The demo post (מוקש דהימן) has **none** as a featured image | Mockup uses earth→chocolate→ink gradient placeholder w/ `aria-label`. Eyal: confirm whether to (a) backfill featured images, or (b) auto-promote the first in-content image as the featured image (migration task, not S1). |
| In-content images | embedded `[vc_single_image]` in post body | Yes (live, hosted on staging) | Rendered as-is inside `.ea-post-content` once shortcodes resolve. No new assets needed. |

## Strategy recommendation (for S2 sign-off)
1. **Placeholder-first, no blocker:** the gradient placeholders are D-14-token-only and pass a11y/contrast, so the blog ships visually coherent even with zero featured images. (Composition does not gate on assets.)
2. **Preferred:** Eyal/editor sets one featured image per post (landscape, ≥1200px wide). Cards crop to 16:9 via `object-fit:cover`; single uses `large`.
3. **Migration option (S3+, not S1):** a one-time script promoting each post's first `[vc_single_image]` to `_thumbnail_id`. Out of team_35 scope — noted for team_10/team_60.

## Image specs (when supplied)
- Card source size: `medium_large` (768px) min; crop region 16:9, centred.
- Single hero: `large`; full-bleed of `--ea-prose-width` (960px), native aspect.
- Format: WebP preferred (perf ≥85 target, AC-U2/AC-D4); `loading="lazy"` on cards (eager on single hero, per template).
- Alt text: templates already pass `alt = get_the_title()`; Eyal may supply richer alt per image for a11y.
