<?php
/**
 * Plugin Name: EA W2-17 — Sitemap hygiene (redirect-shells + test pages + child-sitemap noise)
 * Description: WP-W2-17 T4 (D-2, team_80 SEO-GEO-RESEARCH-SYNTHESIS-2026-07-02.md §5.2/§5.3 C-3).
 *   Excludes from Yoast's page/post sitemap the WP page shells that are live 301-redirect
 *   SOURCES (the shells are still published so Yoast lists them even though every request
 *   to their URL is 301'd elsewhere by ea-w209-legacy-301-redirects.php, wave2-w2-02.php,
 *   and ea-m2-site-tree-lock-sync-once.php), plus /sample-page/ and /wave2-test/. Also
 *   disables the noise child-sitemaps (taxonomy archives + author + third-party stats CPT)
 *   that carry no unique indexable content for this single-author niche site.
 *   IDs are resolved by path at runtime via get_page_by_path() — no hardcoded post IDs,
 *   so this survives a DB re-seed / staging-to-production content migration untouched.
 * Version: 1.0.0
 */
defined( 'ABSPATH' ) || exit;

/**
 * The 14 redirect-source URLs confirmed live 301 sources (team_80 synthesis §5.2 D-2 +
 * Appendix A sitemap sweep, cross-referenced against the actual redirect maps in:
 *   - site/wp-content/themes/ea-eyalamit/inc/wave2-w2-02.php:178-189 (/about/, /about/moksha/)
 *   - site/wp-content/mu-plugins/ea-m2-site-tree-lock-sync-once.php:400-423 (/services/*, /hashita/, /courses-soon/)
 *   - site/wp-content/themes/ea-eyalamit/functions.php:603-610 (/muzza/*, /muzeh/*)
 * plus the 2 unpublished-via-REST test shells (/sample-page/, /wave2-test/ — belt-and-braces:
 * excluded from the sitemap here too in case unpublish lags or is reverted).
 *
 * NOTE (open question — see COMPLETION_REPORT): the synthesis Appendix A shorthand lists
 * muzeh's variants as {,tsva…,kushi…,vekatavt} (4) but muzza's as {,vekatavt,tsva…} (3,
 * omitting kushi) to total 14. Source-code cross-check (functions.php:607,631) shows
 * /muzza/kushi-blantis/ IS a live redirect source (it is the actually-seeded+parented page,
 * site-tree-lock-sync-once.php:168) while /muzeh/kushi-blantis/ is only ever used as a
 * get_page_by_path() fallback lookup (:307), i.e. likely never a real published shell.
 * Both are listed below regardless: get_page_by_path() safely no-ops for whichever slug
 * does not resolve to a real page, so listing both cannot exclude a wrong/live URL — it
 * only guards against either naming being the one that is actually published.
 */
function ea_w217_redirect_source_paths() {
	return array(
		'/services/didgeridoo-lessons/',
		'/services/didgeridoo-treatment-breath/',
		'/services/handmade-instruments/',
		'/hashita/',
		'/courses-soon/',
		'/about/',
		'/about/moksha/',
		'/muzza/',
		'/muzza/vekatavt/',
		'/muzza/tsva-bechol-ve-zorek-layam/',
		'/muzza/kushi-blantis/',
		'/muzeh/',
		'/muzeh/vekatavt/',
		'/muzeh/tsva-bechol-ve-zorek-layam/',
		// Belt-and-braces: excluded from the sitemap regardless of REST unpublish timing.
		'/sample-page/',
		'/wave2-test/',
	);
}

/**
 * Resolve the path list above to post IDs at runtime (no hardcoded IDs — survives reseed).
 *
 * @return int[]
 */
function ea_w217_resolve_excluded_post_ids() {
	static $ids = null;
	if ( null !== $ids ) {
		return $ids;
	}
	$ids = array();
	foreach ( ea_w217_redirect_source_paths() as $path ) {
		$rel  = trim( (string) wp_parse_url( $path, PHP_URL_PATH ), '/' );
		if ( '' === $rel ) {
			continue;
		}
		// Nested slugs (e.g. muzza/kushi-blantis) resolve via get_page_by_path's slash-joined form.
		$post = get_page_by_path( $rel, OBJECT, array( 'page', 'post' ) );
		if ( $post instanceof WP_Post ) {
			$ids[] = (int) $post->ID;
		}
	}
	return array_values( array_unique( array_filter( $ids ) ) );
}

/**
 * Yoast filter: exclude specific post IDs from the post/page sitemap by exact ID
 * (resolved above from exact URL/slug — never a hardcoded literal ID).
 *
 * @param int[] $excluded_posts_ids Existing excluded IDs.
 * @return int[]
 */
function ea_w217_exclude_from_sitemap_by_post_ids( $excluded_posts_ids ) {
	if ( ! is_array( $excluded_posts_ids ) ) {
		$excluded_posts_ids = array();
	}
	return array_values( array_unique( array_merge( $excluded_posts_ids, ea_w217_resolve_excluded_post_ids() ) ) );
}
add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', 'ea_w217_exclude_from_sitemap_by_post_ids' );

/**
 * C-3 (team_80 synthesis §5.3): disable noise child-sitemaps. Live sitemap_index.xml sweep
 * (synthesis Appendix A) shows 10 children: post, page, ea_faq, ea_gallery, ea_testimonial,
 * category, post_tag, wpa-stats-type, ea_testimonial_cat, author.
 * Content-bearing (kept): post, page, ea_faq, ea_gallery, ea_testimonial.
 * Noise (disabled below): category, post_tag, author, wpa-stats-type (third-party stats CPT,
 * not registered anywhere in this repo), ea_testimonial_cat (single-term "recommendations"
 * taxonomy on ea_testimonial, functions.php:396-411 — archive adds no unique indexable value).
 */

// Taxonomy archives: built-in category/post_tag + our ea_testimonial_cat.
function ea_w217_sitemap_exclude_taxonomy( $excluded, $taxonomy ) {
	$noise_taxonomies = array( 'category', 'post_tag', 'ea_testimonial_cat' );
	if ( in_array( $taxonomy, $noise_taxonomies, true ) ) {
		return true;
	}
	return $excluded;
}
add_filter( 'wpseo_sitemap_exclude_taxonomy', 'ea_w217_sitemap_exclude_taxonomy', 10, 2 );

// Author sitemap: single-author niche site, no unique per-author archive value.
add_filter( 'wpseo_sitemap_exclude_author', '__return_true' );

// Third-party "wpa-stats-type" CPT sitemap (not our post type — likely a stats/analytics
// plugin's internal CPT that Yoast picked up because it is publicly queryable).
function ea_w217_sitemap_exclude_post_type( $excluded, $post_type ) {
	if ( 'wpa-stats-type' === $post_type ) {
		return true;
	}
	return $excluded;
}
add_filter( 'wpseo_sitemap_exclude_post_type', 'ea_w217_sitemap_exclude_post_type', 10, 2 );

/**
 * Belt-and-braces (live-verified 2026-07-03 need): 'wpa-stats-type' still appeared in
 * sitemap_index.xml after the post-type-exclude filter above (deploy confirmed live —
 * category/post_tag/author noise sitemaps DID disappear from the index — so this is a
 * genuine gap for this specific CPT sitemap, not a caching artifact). Strip it directly
 * from the index links regardless of how the underlying CPT sitemap is registered.
 */
function ea_w217_sitemap_index_strip_wpa_stats( $links ) {
	if ( ! is_array( $links ) ) {
		return $links;
	}
	return array_values(
		array_filter(
			$links,
			function ( $link ) {
				$loc = is_array( $link ) && isset( $link['loc'] ) ? (string) $link['loc'] : '';
				return false === strpos( $loc, 'wpa-stats-type' );
			}
		)
	);
}
add_filter( 'wpseo_sitemap_index_links', 'ea_w217_sitemap_index_strip_wpa_stats' );

/**
 * Belt-and-braces (live-verified 2026-07-03 need): the by-post-ID exclusion above resolved
 * 13/14 redirect-source paths + both test pages correctly, but /muzeh/kushi-blantis/ still
 * appeared in page-sitemap.xml live (get_page_by_path() path-resolution edge case — see the
 * "open question" note in ea_w217_redirect_source_paths() above). Add a direct URL-string
 * match on the rendered sitemap entry so exclusion never depends on path->ID resolution
 * succeeding — this is authoritative regardless of the by-ID filter's outcome.
 */
function ea_w217_sitemap_entry_strip_by_url( $url, $type, $post ) {
	if ( ! is_array( $url ) || empty( $url['loc'] ) ) {
		return $url;
	}
	static $excluded_paths = null;
	if ( null === $excluded_paths ) {
		$excluded_paths = array_map(
			function ( $p ) {
				return trim( $p, '/' );
			},
			ea_w217_redirect_source_paths()
		);
	}
	$path = trim( (string) wp_parse_url( $url['loc'], PHP_URL_PATH ), '/' );
	if ( in_array( $path, $excluded_paths, true ) ) {
		return false;
	}
	return $url;
}
add_filter( 'wpseo_sitemap_entry', 'ea_w217_sitemap_entry_strip_by_url', 10, 3 );
