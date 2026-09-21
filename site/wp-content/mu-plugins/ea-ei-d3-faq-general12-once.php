<?php
/**
 * Plugin Name: EA EI-D3 — FAQ general-12 href sync (once)
 * Description: Pushes general-12 therapist-training href from ea-faq-seed.json into live ea_faq.
 * Version: 1.0.0
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	static function () {
		if ( 'done' === get_option( 'ea_ei_d3_faq_general12_v1_done', '' ) ) {
			return;
		}
		if ( wp_installing() || ! post_type_exists( 'ea_faq' ) ) {
			return;
		}

		$file = get_stylesheet_directory() . '/inc/data/ea-faq-seed.json';
		if ( ! is_readable( $file ) ) {
			return;
		}
		$raw = json_decode( (string) file_get_contents( $file ), true );
		if ( empty( $raw['items'] ) || ! is_array( $raw['items'] ) ) {
			return;
		}

		$row = null;
		foreach ( $raw['items'] as $item ) {
			if ( isset( $item['seed_key'] ) && 'general-12' === $item['seed_key'] ) {
				$row = $item;
				break;
			}
		}
		if ( empty( $row['a'] ) ) {
			return;
		}

		$ids = get_posts(
			array(
				'post_type'   => 'ea_faq',
				'post_status' => 'any',
				'numberposts' => 1,
				'fields'      => 'ids',
				'meta_key'    => '_ea_faq_seed_key',
				'meta_value'  => 'general-12',
			)
		);
		if ( empty( $ids ) ) {
			return;
		}

		wp_update_post(
			array(
				'ID'           => (int) $ids[0],
				'post_content' => (string) $row['a'],
			)
		);
		update_option( 'ea_ei_d3_faq_general12_v1_done', 'done', false );
	},
	42
);
