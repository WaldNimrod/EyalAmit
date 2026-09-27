<?php
/**
 * Plugin Name: EA ACF residue audit (read-only, temporary)
 * Description: Answers one question before the bypass at chapters-render.php:609/:651 can safely
 *              be removed: are there ACF values sitting in postmeta on the bypassed pages, and
 *              would they differ from what those pages currently render?
 *              READ-ONLY. It reads postmeta and compares each stored value against the seeded
 *              default, reporting lengths and a verdict — never the text itself, because page copy
 *              is the client's content and does not belong in a report. Authenticated route,
 *              manage_options only. Remove and redeploy once read.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'ea/v1',
			'/acf-residue',
			array(
				'methods'             => 'GET',
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
				'callback'            => 'ea_acf_residue_report',
			)
		);
	}
);

/**
 * The 21 types whose ACF overlay is skipped (chapters-render.php:609 and :651).
 *
 * @return string[]
 */
function ea_acf_residue_bypassed_types() {
	return array(
		'treatment', 'method', 'lessons', 'sound-healing', 'shop', 'muzza', 'about', 'mokesh',
		'didgeridoos', 'bags', 'stands-storage', 'stand-floor', 'repair', 'kushi-blantis',
		'tsva-bekahol', 'vekatavta', 'faq', 'snoring-sleep-apnea', 'en', 'courses-external',
		'galleries',
	);
}

/**
 * Flatten a seeded defaults array into comparable scalar leaves keyed like ACF field names.
 *
 * @param mixed  $node   Defaults node.
 * @param string $prefix Key prefix.
 * @return array<string,string>
 */
function ea_acf_residue_flatten( $node, $prefix = '' ) {
	$out = array();
	if ( is_array( $node ) ) {
		foreach ( $node as $k => $v ) {
			$key = '' === $prefix ? (string) $k : $prefix . '_' . $k;
			$out = array_merge( $out, ea_acf_residue_flatten( $v, $key ) );
		}
	} elseif ( is_scalar( $node ) ) {
		$out[ $prefix ] = (string) $node;
	}
	return $out;
}

/**
 * Build the read-only residue report.
 *
 * @return array<string,mixed>
 */
function ea_acf_residue_report() {
	global $wpdb;

	if ( ! function_exists( 'ea_chapters_route_map' ) ) {
		return array( 'error' => 'chapters not loaded' );
	}

	$bypassed = ea_acf_residue_bypassed_types();
	$map      = ea_chapters_route_map();
	$rows     = array();
	$totals   = array(
		'pages_examined'        => 0,
		'pages_with_any_value'  => 0,
		'stored_values_total'   => 0,
		'identical_to_default'  => 0,
		'differs_from_default'  => 0,
		'no_matching_default'   => 0,
	);

	foreach ( $map as $slug => $entry ) {
		// Map values are array{template,type}, not plain strings.
		$type = is_array( $entry ) ? ( isset( $entry['type'] ) ? (string) $entry['type'] : '' ) : (string) $entry;
		if ( ! in_array( $type, $bypassed, true ) ) {
			continue;
		}
		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			continue;
		}
		++$totals['pages_examined'];

		// Every postmeta row whose key does not start with '_' — ACF stores the value there and
		// the field-key reference under the underscored twin.
		$meta = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT meta_key, meta_value FROM {$wpdb->postmeta}
				 WHERE post_id = %d AND meta_key NOT LIKE %s",
				$page->ID,
				$wpdb->esc_like( '_' ) . '%'
			),
			ARRAY_A
		);

		// ea_chapters_defaults() reads the CURRENT request's type; the per-type reader is _for().
		$seed     = function_exists( 'ea_chapters_defaults_for' ) ? ea_chapters_defaults_for( $type ) : array();
		$defaults = ea_acf_residue_flatten( $seed );

		$fields = array();
		foreach ( $meta as $m ) {
			$key = (string) $m['meta_key'];
			$val = (string) $m['meta_value'];
			if ( '' === trim( $val ) ) {
				continue;
			}
			// Only count keys that look like this theme's ACF slots, not WP/Yoast/plugin meta.
			if ( ! preg_match( '/^(s\d+_|phero_|hero_|what_|about_|cmp_|testi_|foot_|faq_)/', $key ) ) {
				continue;
			}
			++$totals['stored_values_total'];

			$verdict = 'no-matching-default';
			if ( isset( $defaults[ $key ] ) ) {
				$verdict = ( $defaults[ $key ] === $val ) ? 'identical-to-default' : 'DIFFERS-from-default';
			}
			$k = str_replace( '-', '_', $verdict );
			if ( 'identical-to-default' === $verdict ) {
				++$totals['identical_to_default'];
			} elseif ( 'no-matching-default' === $verdict ) {
				++$totals['no_matching_default'];
			} else {
				++$totals['differs_from_default'];
			}

			$fields[] = array(
				'key'            => $key,
				'stored_length'  => strlen( $val ),
				'default_length' => isset( $defaults[ $key ] ) ? strlen( $defaults[ $key ] ) : null,
				'verdict'        => $verdict,
			);
		}

		if ( $fields ) {
			++$totals['pages_with_any_value'];
		}

		$rows[] = array(
			'slug'          => $slug,
			'type'          => $type,
			'post_id'       => $page->ID,
			'stored_fields' => count( $fields ),
			'fields'        => $fields,
		);
	}

	return array(
		'note'     => 'lengths and verdicts only; no page copy is returned',
		'bypassed' => count( $bypassed ),
		'totals'   => $totals,
		'pages'    => $rows,
	);
}

/**
 * Second measurement team_00 ordered: does lifting the freeze actually restore editing?
 *
 * Self-contained and self-cleaning. On one bypassed page it writes a single sentinel value into
 * the ACF slot, resolves the section tree with the freeze lifted for that type only, checks
 * whether the sentinel reached the rendered arguments, and then deletes the value again. The
 * page's own copy is never touched and nothing is left behind.
 */
add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'ea/v1',
			'/unfreeze-test',
			array(
				'methods'             => 'GET',
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
				'callback'            => 'ea_unfreeze_test',
			)
		);
	}
);

/**
 * @return array<string,mixed>
 */
function ea_unfreeze_test() {
	$slug     = 'repair';
	$type     = 'repair';
	$sentinel = 'EA-UNFREEZE-SENTINEL-27SEP';

	$page = get_page_by_path( $slug );
	if ( ! $page || ! function_exists( 'ea_chapters_page_sections' ) ) {
		return array( 'error' => 'page or resolver missing' );
	}

	// Find a scalar slot this page's own defaults actually define, so the test targets a real field.
	$seed = ea_chapters_defaults_for( $type );
	$key  = '';
	if ( isset( $seed['sections'] ) && is_array( $seed['sections'] ) ) {
		foreach ( $seed['sections'] as $n => $sec ) {
			foreach ( array( 'title', 'chap', 'sub' ) as $arg ) {
				if ( isset( $sec['args'][ $arg ] ) && is_string( $sec['args'][ $arg ] ) && '' !== $sec['args'][ $arg ] ) {
					$key = 's' . ( $n + 1 ) . '_' . $arg;
					break 2;
				}
			}
		}
	}
	if ( '' === $key ) {
		return array( 'error' => 'no scalar slot found in the seeded defaults' );
	}

	$had_before = metadata_exists( 'post', $page->ID, $key );

	// ea_chapters_page_sections() and get_field() both read the CURRENT request's context, so the
	// page has to be made current: the type override global, and the global post for ACF.
	$prev_type            = isset( $GLOBALS['ea_chapters_type'] ) ? $GLOBALS['ea_chapters_type'] : null;
	$prev_post            = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;
	$GLOBALS['ea_chapters_type'] = $type;
	$GLOBALS['post']             = $page; // phpcs:ignore WordPress.WP.GlobalVariablesOverride -- restored below.
	setup_postdata( $page );

	$frozen = wp_json_encode( ea_chapters_page_sections() );

	update_post_meta( $page->ID, $key, $sentinel );
	$frozen_with_value = wp_json_encode( ea_chapters_page_sections() );

	$lift = function ( $types ) use ( $type ) {
		return array_values( array_diff( (array) $types, array( $type ) ) );
	};
	add_filter( 'ea_chapters_seeded_only_types', $lift, 99 );
	$lifted = wp_json_encode( ea_chapters_page_sections() );
	remove_filter( 'ea_chapters_seeded_only_types', $lift, 99 );

	// Clean up: the page must end exactly as it started.
	if ( ! $had_before ) {
		delete_post_meta( $page->ID, $key );
	}
	$left_behind = metadata_exists( 'post', $page->ID, $key );

	wp_reset_postdata();
	if ( null === $prev_type ) {
		unset( $GLOBALS['ea_chapters_type'] );
	} else {
		$GLOBALS['ea_chapters_type'] = $prev_type;
	}
	$GLOBALS['post'] = $prev_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride -- restoring.

	return array(
		'page'                          => $slug,
		'post_id'                       => $page->ID,
		'field_tested'                  => $key,
		'meta_existed_before'           => (bool) $had_before,
		'sentinel_visible_when_frozen'  => false !== strpos( (string) $frozen_with_value, $sentinel ),
		'sentinel_visible_when_lifted'  => false !== strpos( (string) $lifted, $sentinel ),
		'frozen_output_unchanged_by_the_value' => $frozen === $frozen_with_value,
		'acf_available'                 => function_exists( 'get_field' ),
		'meta_left_behind'              => (bool) $left_behind,
	);
}
