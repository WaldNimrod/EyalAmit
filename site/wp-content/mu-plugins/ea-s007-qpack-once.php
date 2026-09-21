<?php
/**
 * Plugin Name: EA S007 Q-pack — unpublish services + about (once)
 * Description: Nimrod 2026-09-21: unpublish /services/ with no redirect; unpublish /about/
 *   (301 overlay lives in ea-s006-r2-w1-legacy-301.php). Does not touch /services/* children
 *   or /about/moksha/.
 * Version: 1.0.0
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	static function () {
		if ( 'done' === get_option( 'ea_s007_qpack_v1_done', '' ) ) {
			return;
		}
		if ( wp_installing() ) {
			return;
		}

		$parents = array( 'services', 'about' );
		foreach ( $parents as $slug ) {
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			if ( ! $page instanceof WP_Post ) {
				continue;
			}
			if ( (int) $page->post_parent !== 0 ) {
				continue;
			}
			if ( 'publish' === $page->post_status ) {
				wp_update_post(
					array(
						'ID'          => (int) $page->ID,
						'post_status' => 'draft',
					)
				);
			}
		}

		$courses = get_page_by_path( 'learning/courses-external', OBJECT, 'page' );
		if ( $courses instanceof WP_Post ) {
			wp_update_post(
				array(
					'ID'         => (int) $courses->ID,
					'post_title' => 'קורסים',
				)
			);
		}

		update_option( 'ea_s007_qpack_v1_done', 'done', false );
	},
	20
);
