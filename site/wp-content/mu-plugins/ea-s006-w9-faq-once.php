<?php
/**
 * Plugin Name: EA S006 — wave 9 FAQ seed push (once)
 * Description: Pushes selected seed_keys from inc/data/ea-faq-seed.json onto the
 *   live ea_faq CPT after 19.8 FAQ notes. Does not touch block-faq-list.php.
 *   Reads answers FROM THE JSON. New flag — prior one-shots already fired.
 *
 *   Reset: delete_option('ea_s006_w9_faq_v1_done').
 * Version: 1.0.0
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	static function () {
		if ( 'done' === get_option( 'ea_s006_w9_faq_v1_done', '' ) ) {
			return;
		}
		if ( wp_installing() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
			return;
		}
		if ( ! post_type_exists( 'ea_faq' ) ) {
			return;
		}

		$keys = array(
			'general-10',
			'general-14',
			'general-15',
			'general-18',
			'treatment-08',
			'treatment-16',
			'treatment-17',
			'treatment-18',
			'treatment-19',
			'treatment-20',
			'method-01',
			'method-02',
			'method-05',
			'lessons-06',
		);
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

		update_option( 'ea_s006_w9_faq_v1_done', 'done' );
	},
	44
);
