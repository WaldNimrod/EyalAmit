<?php
/**
 * Plugin Name: EA EI-T18 — Deleted blog posts 301 → /blog/
 * Description: P016 + P045 paths redirect to /blog/ after trash (EI-T18).
 * Version: 1.0.0
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return void
 */
function ea_ei_t18_legacy_301() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? rawurldecode( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	if ( '' === $uri ) {
		return;
	}
	$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
	if ( '' === $path ) {
		return;
	}
	$norm = trailingslashit( $path );

	$map = array(
		'/סיפורים-מהנייר-עם-אייל-עמית/'     => '/blog/',
		'/41-הטור-של-אייל-עמית-חארטה-בארטה/' => '/blog/',
	);

	if ( ! isset( $map[ $norm ] ) ) {
		return;
	}

	header( 'X-EA-Redirect: ei-t18' );
	wp_safe_redirect( home_url( $map[ $norm ] ), 301 );
	exit;
}
add_action( 'template_redirect', 'ea_ei_t18_legacy_301', 0 );
