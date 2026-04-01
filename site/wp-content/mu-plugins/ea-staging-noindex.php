<?php
/**
 * Plugin Name: EA Staging noindex (uPress)
 * Description: Adds noindex,nofollow on staging hosts (*.upress.link). Inactive on production domains. See M2 runbook §8.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * True when site host is uPress staging (not production eyalamit.co.il).
 */
function ea_is_upress_staging_host() {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	if ( ! is_string( $host ) || $host === '' ) {
		return false;
	}
	return str_contains( $host, 'upress.link' );
}

/**
 * @param array<string, bool|string> $robots Robots directives.
 * @return array<string, bool|string>
 */
function ea_staging_wp_robots( $robots ) {
	if ( ! ea_is_upress_staging_host() ) {
		return $robots;
	}
	$robots['noindex']  = true;
	$robots['nofollow'] = true;
	return $robots;
}
add_filter( 'wp_robots', 'ea_staging_wp_robots', 20 );
