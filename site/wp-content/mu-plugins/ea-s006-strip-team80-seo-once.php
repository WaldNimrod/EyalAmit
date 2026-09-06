<?php
/**
 * Plugin Name: EA S006 — strip team-80 PLACEHOLDER from Yoast/excerpt (once)
 * Description: S006 final remediations. Team-80 seed wrote PLACEHOLDER chrome into
 *   `_yoast_wpseo_metadesc` / Open Graph extras / `post_excerpt`. That string is
 *   visible on Facebook/WhatsApp share cards (caught on /testimonials/). This
 *   one-shot DELETES those SEO fields when they contain PLACEHOLDER or «צוות 80».
 *   It does NOT edit post_content (frozen pages / H-06 Lorem stay as drafted).
 *   Theme filters in inc/seo-head-fallbacks.php are the live safety net so Yoast
 *   cannot re-emit chrome from leftover post_content.
 *
 *   Reset: delete_option('ea_s006_strip_team80_seo_v1_done').
 * Version: 1.0.0
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

define( 'EA_S006_STRIP_TEAM80_SEO_OPTION', 'ea_s006_strip_team80_seo_v1_done' );

/**
 * @param string $text Candidate SEO/excerpt string.
 * @return bool
 */
function ea_s006_strip_team80_seo_is_chrome( $text ) {
	$t = (string) $text;
	if ( '' === $t ) {
		return false;
	}
	return ( false !== strpos( $t, 'PLACEHOLDER' ) || false !== strpos( $t, 'צוות 80' ) );
}

/**
 * Clear team-80 chrome from Yoast meta + excerpt. One shot.
 *
 * @return void
 */
function ea_s006_strip_team80_seo_once_maybe_run() {
	if ( 'done' === get_option( EA_S006_STRIP_TEAM80_SEO_OPTION, '' ) ) {
		return;
	}
	if ( wp_installing() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_s006_strip_team80_seo_lock' ) ) {
		return;
	}
	set_transient( 'ea_s006_strip_team80_seo_lock', 1, 300 );

	try {
		$q = new WP_Query(
			array(
				'post_type'              => array( 'page', 'post' ),
				'post_status'            => 'any',
				'posts_per_page'         => -1,
				'fields'                 => 'ids',
				'no_found_rows'          => true,
				'update_post_meta_cache' => true,
				'update_post_term_cache' => false,
			)
		);

		$meta_keys = array(
			'_yoast_wpseo_metadesc',
			'_yoast_wpseo_opengraph-description',
			'_yoast_wpseo_twitter-description',
		);

		foreach ( (array) $q->posts as $post_id ) {
			$post_id = (int) $post_id;
			if ( $post_id < 1 ) {
				continue;
			}
			foreach ( $meta_keys as $key ) {
				$val = (string) get_post_meta( $post_id, $key, true );
				if ( ea_s006_strip_team80_seo_is_chrome( $val ) ) {
					delete_post_meta( $post_id, $key );
				}
			}
			$excerpt = (string) get_post_field( 'post_excerpt', $post_id );
			if ( ea_s006_strip_team80_seo_is_chrome( $excerpt ) ) {
				wp_update_post(
					array(
						'ID'           => $post_id,
						'post_excerpt' => '',
					)
				);
			}
		}

		update_option( EA_S006_STRIP_TEAM80_SEO_OPTION, 'done', false );
	} finally {
		delete_transient( 'ea_s006_strip_team80_seo_lock' );
	}
}
add_action( 'init', 'ea_s006_strip_team80_seo_once_maybe_run', 43 );
