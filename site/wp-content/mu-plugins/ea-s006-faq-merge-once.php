<?php
/**
 * Plugin Name: EA — S006 R1-25 FAQ corpus merge (once)
 * Description: Updates existing ea_faq rows by `_ea_faq_seed_key` and inserts new
 *   seed_keys from inc/data/ea-faq-seed.json. Deletes M3 PLACEHOLDER FAQ cards
 *   (JSON-LD-only, no real content). Answers are read FROM THE JSON — never retyped here.
 *
 *   🔴 ea-faq-seed-once.php is INSERT-ONLY:
 *       if ( ! empty( $existing ) ) { continue; }   // ea-faq-seed-once.php:91-103
 *   Re-running that seeder cannot apply FAQ FINAL.md answers onto live rows.
 *
 *   🔴 ea-s507-faq-update-once.php is a 2-key allow-list (method-02, general-17)
 *   with flags ea_s507_faq_update_done / ea_s507_faq_update_v2_done.
 *   Do NOT reuse those flags. Do NOT copy its allow-list. This merge is a new
 *   one-shot: ea_s006_faq_merge_v1_done.
 *
 *   🔴 Rows live under items[], NOT at the top level (same trap as s507 v1).
 *
 *   Runs at init priority 42, AFTER ea_faq_seed_once_maybe_run() at init@40
 *   and the s507 updater at init@41.
 *
 *   Single-fire: after the first run it is a no-op. Safe to leave deployed;
 *   delete once confirmed. Reset: delete_option('ea_s006_faq_merge_v1_done').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * S006 R1-25: merge seed JSON into ea_faq CPT (update-or-insert) once.
 */
function ea_s006_faq_merge_once_maybe_run() {
	if ( 'done' === get_option( 'ea_s006_faq_merge_v1_done', '' ) ) {
		return;
	}
	if ( wp_installing() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( ! post_type_exists( 'ea_faq' ) ) {
		return;
	}
	if ( get_transient( 'ea_s006_faq_merge_lock' ) ) {
		return;
	}
	set_transient( 'ea_s006_faq_merge_lock', 1, 300 );

	try {
		$file = get_stylesheet_directory() . '/inc/data/ea-faq-seed.json';
		if ( ! is_readable( $file ) ) {
			return;
		}
		$raw = json_decode( (string) file_get_contents( $file ), true );
		if ( empty( $raw['items'] ) || ! is_array( $raw['items'] ) ) {
			return;
		}

		$labels = function_exists( 'ea_faq_seed_once_category_labels' )
			? ea_faq_seed_once_category_labels()
			: array();

		$seed_slugs = array();
		foreach ( $raw['items'] as $item ) {
			foreach ( (array) ( $item['categories'] ?? array() ) as $slug ) {
				$seed_slugs[ $slug ] = true;
			}
		}
		foreach ( array_keys( $seed_slugs ) as $slug ) {
			$name  = $labels[ $slug ] ?? $slug;
			$exist = term_exists( $slug, 'ea_faq_cat' );
			if ( $exist ) {
				wp_update_term( (int) ( is_array( $exist ) ? $exist['term_id'] : $exist ), 'ea_faq_cat', array( 'name' => $name ) );
			} else {
				wp_insert_term( $name, 'ea_faq_cat', array( 'slug' => $slug ) );
			}
		}

		foreach ( $raw['items'] as $item ) {
			if ( empty( $item['seed_key'] ) || empty( $item['q'] ) || empty( $item['a'] ) ) {
				continue;
			}
			$existing = get_posts(
				array(
					'post_type'   => 'ea_faq',
					'post_status' => 'any',
					'meta_key'    => '_ea_faq_seed_key',
					'meta_value'  => $item['seed_key'],
					'numberposts' => 1,
					'fields'      => 'ids',
				)
			);
			if ( ! empty( $existing ) ) {
				wp_update_post(
					array(
						'ID'           => (int) $existing[0],
						'post_title'   => $item['q'],
						'post_content' => $item['a'],
						'post_status'  => 'publish',
					)
				);
				$post_id = (int) $existing[0];
			} else {
				$post_id = wp_insert_post(
					array(
						'post_type'    => 'ea_faq',
						'post_status'  => 'publish',
						'post_title'   => $item['q'],
						'post_content' => $item['a'],
					),
					true
				);
				if ( is_wp_error( $post_id ) ) {
					continue;
				}
				update_post_meta( $post_id, '_ea_faq_seed_key', $item['seed_key'] );
			}
			wp_set_object_terms( $post_id, (array) $item['categories'], 'ea_faq_cat', false );
		}

		ea_s006_faq_merge_once_delete_placeholders();

		update_option( 'ea_s006_faq_merge_v1_done', 'done', false );
	} finally {
		delete_transient( 'ea_s006_faq_merge_lock' );
	}
}

/**
 * Drop M3 PLACEHOLDER FAQ cards (no real content = no component).
 */
function ea_s006_faq_merge_once_delete_placeholders() {
	$slugs = array( 'ea-m3-seed-faq-1', 'ea-m3-seed-faq-2' );
	foreach ( $slugs as $slug ) {
		$found = get_posts(
			array(
				'post_type'   => 'ea_faq',
				'post_status' => 'any',
				'name'        => $slug,
				'numberposts' => 1,
				'fields'      => 'ids',
			)
		);
		if ( ! empty( $found ) ) {
			wp_delete_post( (int) $found[0], true );
		}
	}

	$ids = get_posts(
		array(
			'post_type'   => 'ea_faq',
			'post_status' => 'any',
			'numberposts' => -1,
			'fields'      => 'ids',
		)
	);
	foreach ( $ids as $id ) {
		$title = get_the_title( (int) $id );
		if ( false !== strpos( $title, 'PLACEHOLDER' ) ) {
			wp_delete_post( (int) $id, true );
		}
	}
}

add_action( 'init', 'ea_s006_faq_merge_once_maybe_run', 42 );
