<?php
/**
 * Plugin Name: EA FAQ seed (once) — WP-CANON T2
 * Description: Idempotent seed of ea_faq posts + ea_faq_cat from theme inc/data/ea-faq-seed.json. Runs once on staging when WP-CLI is unavailable. Reset: delete_option('ea_faq_seed_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Category slug → Hebrew label (display order).
 *
 * @return array<string,string>
 */
function ea_faq_seed_once_category_labels() {
	return array(
		'treatment'      => "טיפול בדיג'רידו",
		'lessons'        => "שיעורי נגינה בדיג'רידו",
		'sound-healing'  => "סאונד הילינג בדיג'רידו",
		'method'         => 'השיטה — cbDIDG',
		'didgeridoos'    => "רכישת דיג'רידו",
		'bags'           => "תיקים לדיג'רידו",
		'stands-storage' => "סטנדים לאחסון דיג'רידו",
		'stand-floor'    => 'סטנד רצפתי לנגינה',
		'repair'         => "תיקון וחידוש דיג'רידו",
		'general'        => 'שאלות כלליות',
		'vekatavta'      => 'וכתבת',
		'kushi-blantis'  => 'כושי בלאנטיס',
		'tsva-bekahol'   => 'צבע בכחול',
	);
}

/**
 * Run once: migrate seed JSON into CPT + taxonomy.
 */
function ea_faq_seed_once_maybe_run() {
	if ( get_option( 'ea_faq_seed_v1', '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_faq_seed_lock' ) ) {
		return;
	}
	set_transient( 'ea_faq_seed_lock', 1, 300 );

	try {
		$path = get_stylesheet_directory() . '/inc/data/ea-faq-seed.json';
		if ( ! is_readable( $path ) ) {
			return;
		}
		$raw = json_decode( (string) file_get_contents( $path ), true );
		if ( empty( $raw['items'] ) || ! is_array( $raw['items'] ) ) {
			return;
		}

		$labels     = ea_faq_seed_once_category_labels();
		$seed_slugs = array();
		foreach ( $raw['items'] as $item ) {
			foreach ( (array) ( $item['categories'] ?? array() ) as $slug ) {
				$seed_slugs[ $slug ] = true;
			}
		}
		$ordered = array();
		foreach ( array_keys( $labels ) as $slug ) {
			if ( isset( $seed_slugs[ $slug ] ) ) {
				$ordered[] = $slug;
			}
		}
		foreach ( array_keys( $seed_slugs ) as $slug ) {
			if ( ! in_array( $slug, $ordered, true ) ) {
				$ordered[] = $slug;
			}
		}

		foreach ( $ordered as $slug ) {
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
				continue;
			}
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
			wp_set_object_terms( $post_id, (array) $item['categories'], 'ea_faq_cat', false );
		}

		update_option( 'ea_faq_seed_v1', 'done', false );
	} finally {
		delete_transient( 'ea_faq_seed_lock' );
	}
}
add_action( 'init', 'ea_faq_seed_once_maybe_run', 40 );
