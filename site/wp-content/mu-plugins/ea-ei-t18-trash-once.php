<?php
/**
 * Plugin Name: EA EI-T18 — Trash P016 + P045 (once)
 * Description: Moves mandated blog deletes to trash; 301 handled by ea-ei-t18-legacy-301.php.
 * Version: 1.0.0
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	static function () {
		if ( 'done' === get_option( 'ea_ei_t18_trash_v1_done', '' ) ) {
			return;
		}
		if ( wp_installing() ) {
			return;
		}

		$slugs = array(
			'סיפורים-מהנייר-עם-אייל-עמית',
			'41-הטור-של-אייל-עמית-חארטה-בארטה',
		);

		foreach ( $slugs as $slug ) {
			$posts = get_posts(
				array(
					'post_type'      => 'post',
					'name'           => $slug,
					'post_status'    => array( 'publish', 'draft', 'private', 'future' ),
					'posts_per_page' => 1,
					'fields'         => 'ids',
				)
			);
			if ( ! empty( $posts ) ) {
				wp_trash_post( (int) $posts[0] );
			}
		}

		update_option( 'ea_ei_t18_trash_v1_done', 'done', false );
	},
	20
);
