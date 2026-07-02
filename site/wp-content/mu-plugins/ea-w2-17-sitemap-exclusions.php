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
 * The 14 redirect-source URLs, ground-truth per team_80's live evidence log (Appendix A,
 * SEO-GEO-RESEARCH-SYNTHESIS-2026-07-02.md:296-301 — actual live 301 sweep, 88x200/14x301):
 *   /services/didgeridoo-lessons/ · /services/didgeridoo-treatment-breath/ ·
 *   /services/handmade-instruments/ · /hashita/ · /courses-soon/ ·
 *   /muzeh/{,tsva-bechol-ve-zorek-layam,kushi-blantis,vekatavt}/ (4) ·
 *   /muzza/{,vekatavt,tsva-bechol-ve-zorek-layam}/ (3, no kushi-blantis variant) ·
 *   /about/ · /about/moksha/  = 14.
 *
 * CORRECTION 2026-07-03 (live AC-004 verify, second pass): the first cut of this list
 * (source-code cross-reference against functions.php/site-tree-lock-sync-once.php, without
 * consulting Appendix A directly) incorrectly included /muzza/kushi-blantis/ (not a real
 * redirect source per Appendix A) and omitted /muzeh/kushi-blantis/ (which IS one, and was
 * confirmed still live in page-sitemap.xml after the first deploy). Fixed below against the
 * ground-truth evidence log; /muzza/kushi-blantis/ is left in defensively (harmless no-op if
 * it never resolves to a real sitemap entry).
 *
 * Also includes the 2 unpublished-via-REST test shells (/sample-page/, /wave2-test/ —
 * belt-and-braces: excluded from the sitemap here too in case the REST unpublish, run
 * separately via scripts/wp_rest_client.py, lags or is reverted).
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
		'/muzza/kushi-blantis/', // defensive; not in the ground-truth 14 but harmless if absent.
		'/muzeh/',
		'/muzeh/vekatavt/',
		'/muzeh/tsva-bechol-ve-zorek-layam/',
		'/muzeh/kushi-blantis/', // the actual ground-truth 14th entry (Appendix A) — was missing.
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
