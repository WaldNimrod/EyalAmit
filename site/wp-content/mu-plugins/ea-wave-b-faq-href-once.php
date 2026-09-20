<?php
/**
 * Plugin Name: EA Wave B — FAQ href sync (once)
 * Description: Pushes updated answers for general-07/08/09 + lessons-06 from
 *   inc/data/ea-faq-seed.json into live ea_faq rows (301 href pack). Allow-list only.
 * Version: 1.0.0
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	static function () {
		if ( 'done' === get_option( 'ea_wave_b_faq_href_v1_done', '' ) ) {
			return;
		}
		if ( wp_installing() || ! post_type_exists( 'ea_faq' ) ) {
			return;
		}

		$keys = array( 'general-07', 'general-08', 'general-09', 'lessons-06' );
		$file = get_stylesheet_directory() . '/inc/data/ea-faq-seed.json';
		if ( ! is_readable( $file ) ) {
			return;
		}
		$raw = json_decode( (string) file_get_contents( $file ), true );
		if ( empty( $raw['items'] ) || ! is_array( $raw['items'] ) ) {
			return;
		}

		$by = array();
		foreach ( $raw['items'] as $row ) {
			if ( isset( $row['seed_key'] ) ) {
				$by[ $row['seed_key'] ] = $row;
			}
		}

		$updated = 0;
		foreach ( $keys as $k ) {
			if ( empty( $by[ $k ]['a'] ) ) {
				continue;
			}
			$ids = get_posts(
				array(
					'post_type'   => 'ea_faq',
					'post_status' => 'any',
					'numberposts' => 1,
					'fields'      => 'ids',
					'meta_key'    => '_ea_faq_seed_key',
					'meta_value'  => $k,
				)
			);
			if ( empty( $ids ) ) {
				continue;
			}
			wp_update_post(
				array(
					'ID'           => (int) $ids[0],
					'post_content' => (string) $by[ $k ]['a'],
				)
			);
			++$updated;
		}

		if ( $updated > 0 ) {
			update_option( 'ea_wave_b_faq_href_v1_done', 'done', false );
		}
	},
	42
);
