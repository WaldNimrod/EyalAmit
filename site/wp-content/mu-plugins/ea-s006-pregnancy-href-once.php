<?php
/**
 * Plugin Name: EA S006 — pregnancy FAQ href (once)
 * Description: S006 wave 1 Yoast. Pushes seed_key `lessons-06` from
 *   inc/data/ea-faq-seed.json onto the live ea_faq CPT so FAQPage JSON-LD on
 *   /lessons/ matches the visible pregnancy URL Eyal gave (19.8 D6). Allow-list
 *   of one key — do not widen. Reads the answer FROM THE JSON.
 *
 *   ea-faq-seed-once.php is INSERT-ONLY; ea-s006-faq-merge-once.php already
 *   fired (ea_s006_faq_merge_v1_done). This is a new flag.
 *
 *   Reset: delete_option('ea_s006_pregnancy_href_v1_done').
 * Version: 1.0.0
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	static function () {
		if ( 'done' === get_option( 'ea_s006_pregnancy_href_v1_done', '' ) ) {
			return;
		}
		if ( wp_installing() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
			return;
		}
		if ( ! post_type_exists( 'ea_faq' ) ) {
			return;
		}

		$keys = array( 'lessons-06', 'treatment-01', 'treatment-02', 'treatment-03', 'treatment-04', 'treatment-05', 'treatment-07' );
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
					'post_content' => $by[ $k ]['a'],
				)
			);
		}

		update_option( 'ea_s006_pregnancy_href_v1_done', 'done' );
	},
	43
);
