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

	foreach ( $map as $slug => $type ) {
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

		$defaults = ea_acf_residue_flatten( ea_chapters_defaults( $type ) );

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
