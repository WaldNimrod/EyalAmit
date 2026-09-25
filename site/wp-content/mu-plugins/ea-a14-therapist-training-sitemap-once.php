<?php
/**
 * Plugin Name: EA A14 — restore therapist-training to the sitemap (once)
 * Description: team_00 ruled on 2026-09-26 that /learning/therapist-training/ belongs
 *   in the sitemap. The page is published and returns 200, and it is not in
 *   ea-w2-17-sitemap-exclusions.php. Yoast SEO 28.5 still omitted it because
 *   ea-m2-site-tree-lock-sync-once.php stored _yoast_wpseo_meta-robots-noindex = 1
 *   on this page only. Yoast copies that into the indexable (is_robots_noindex)
 *   and leaves noindex indexables out of page-sitemap.xml. Measured 2026-09-26:
 *   of 101 published pages and 52 published posts, this was the only object whose
 *   yoast_head_json.robots.index was "noindex", and it was the only 200 URL absent
 *   from the two child sitemaps (82 + 53 = 135).
 *
 *   Deletes that one meta key. Yoast's Indexable_Post_Meta_Watcher rebuilds the
 *   indexable on shutdown because the key uses the Yoast meta prefix. Does not
 *   change post content, status, parent, or any other URL.
 *
 *   Reset: delete_option('ea_a14_therapist_training_sitemap_v1').
 * Version: 1.0.0
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

define( 'EA_A14_THERAPIST_SITEMAP_OPTION', 'ea_a14_therapist_training_sitemap_v1' );

/**
 * Clear the Yoast noindex meta on /learning/therapist-training/. One shot.
 *
 * @return void
 */
function ea_a14_therapist_training_sitemap_once() {
	if ( 'done' === get_option( EA_A14_THERAPIST_SITEMAP_OPTION, '' ) ) {
		return;
	}
	if ( wp_installing() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_a14_therapist_training_sitemap_lock' ) ) {
		return;
	}
	set_transient( 'ea_a14_therapist_training_sitemap_lock', 1, 300 );

	try {
		$page = get_page_by_path( 'learning/therapist-training', OBJECT, 'page' );
		if ( ! ( $page instanceof WP_Post ) || 'page' !== $page->post_type ) {
			update_option( 'ea_a14_therapist_training_sitemap_last_error', 'page not found by path learning/therapist-training', false );
			return;
		}

		$key    = '_yoast_wpseo_meta-robots-noindex';
		$before = get_post_meta( $page->ID, $key, true );
		if ( '1' !== (string) $before ) {
			update_option(
				'ea_a14_therapist_training_sitemap_last_error',
				'refusing to mark done; meta was ' . var_export( $before, true ),
				false
			);
			return;
		}

		delete_post_meta( $page->ID, $key );
		$after = get_post_meta( $page->ID, $key, true );
		if ( '' !== (string) $after ) {
			update_option(
				'ea_a14_therapist_training_sitemap_last_error',
				'delete_post_meta left ' . var_export( $after, true ),
				false
			);
			return;
		}

		if ( class_exists( 'WPSEO_Sitemaps_Cache' ) ) {
			WPSEO_Sitemaps_Cache::invalidate( 'page' );
		}

		update_option(
			'ea_a14_therapist_training_sitemap_result',
			array(
				'page_id' => (int) $page->ID,
				'path'    => '/learning/therapist-training/',
				'before'  => (string) $before,
				'after'   => '',
				'ran_at'  => current_time( 'mysql' ),
			),
			false
		);
		delete_option( 'ea_a14_therapist_training_sitemap_last_error' );
		update_option( EA_A14_THERAPIST_SITEMAP_OPTION, 'done', false );
	} finally {
		delete_transient( 'ea_a14_therapist_training_sitemap_lock' );
	}
}
add_action( 'init', 'ea_a14_therapist_training_sitemap_once', 20 );
