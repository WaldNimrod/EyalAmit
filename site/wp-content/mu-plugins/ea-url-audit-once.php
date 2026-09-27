<?php
/**
 * Plugin Name: EA URL audit (read-only, one-shot)
 * Description: Counts absolute staging-host references stored in wp_options and wp_postmeta,
 *              to size the domain cutover. READ-ONLY: SELECT queries only, never writes to the
 *              database. Returns option and meta NAMES with counts and NEVER their values,
 *              because the options table holds credentials. Exposed as an authenticated REST
 *              route restricted to manage_options — it carries no secret of its own.
 *              Temporary: fetch the report, then remove this file and redeploy.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'ea/v1',
			'/url-audit',
			array(
				'methods'             => 'GET',
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
				'callback'            => 'ea_url_audit_report',
			)
		);
	}
);

/**
 * Build the read-only audit report.
 *
 * @return array<string,mixed>
 */
function ea_url_audit_report() {
	global $wpdb;
	$host = 'eyalamit-co-il-2026.s887.upress.link';
	$like = '%' . $wpdb->esc_like( $host ) . '%';
	$len  = strlen( $host );

	$options = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT option_name,
			        ROUND( ( LENGTH(option_value) - LENGTH( REPLACE(option_value, %s, '') ) ) / %d ) AS hits
			 FROM {$wpdb->options}
			 WHERE option_value LIKE %s
			 ORDER BY hits DESC",
			$host,
			$len,
			$like
		),
		ARRAY_A
	);

	$meta = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT meta_key, COUNT(*) AS rows_n,
			        SUM( ROUND( ( LENGTH(meta_value) - LENGTH( REPLACE(meta_value, %s, '') ) ) / %d ) ) AS hits
			 FROM {$wpdb->postmeta}
			 WHERE meta_value LIKE %s
			 GROUP BY meta_key
			 ORDER BY hits DESC",
			$host,
			$len,
			$like
		),
		ARRAY_A
	);

	return array(
		'host'          => $host,
		'home_url'      => get_option( 'home' ),
		'site_url'      => get_option( 'siteurl' ),
		'blog_public'   => get_option( 'blog_public' ),
		'options'       => $options,
		'postmeta'      => $meta,
		'termmeta_rows' => (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->termmeta} WHERE meta_value LIKE %s", $like ) ),
		'comment_rows'  => (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_content LIKE %s", $like ) ),
		'note'          => 'names and counts only; no values are returned',
	);
}
