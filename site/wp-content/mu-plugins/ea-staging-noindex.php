<?php
/**
 * Plugin Name: EA Staging noindex (uPress)
 * Description: Adds noindex,nofollow on staging hosts (*.upress.link). Inactive on production domains. See M2 runbook §8.
 * Version: 1.0.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hint common full-page cache plugins (e.g. EzCache on uPress) not to cache HTML on staging — avoids stale `/` vs fresh `/?…`.
 */
function ea_staging_disable_page_cache_constant() {
	if ( ! ea_is_upress_staging_host() ) {
		return;
	}
	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}
}
add_action( 'init', 'ea_staging_disable_page_cache_constant', 0 );

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

/**
 * Discourage edge / full-page caching of stale HTML on uPress staging (e.g. old blog home before Reading settings).
 */
function ea_staging_nocache_front() {
	if ( ! ea_is_upress_staging_host() ) {
		return;
	}
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	nocache_headers();
}
add_action( 'template_redirect', 'ea_staging_nocache_front', 0 );
