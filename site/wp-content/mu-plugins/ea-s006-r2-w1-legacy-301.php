<?php
/**
 * Plugin Name: EA S006 R2 W1 — Legacy 301 (five locked paths)
 * Description: 301 קבוע מחמש כתובות ישנות (סבב 2 גל 1) ליעדים נעולים ב-MAP-S006-R2-W1-301.
 *   לא נגע ב-ea-w209-legacy-301-redirects.php (GENERATED) ולא ב-ea-m2-site-tree-lock-sync-once.php.
 *   `/services/handmade-instruments/` רץ כאן בעדיפות 0 (קפיצה אחת אל /didgeridoos/)
 *   ומקדים את טבלת M2 (@1) שקודם הפנתה אל /tools-and-accessories/instruments/.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * 301: חמש כתובות סבב 2 גל 1 → יעדים נעולים.
 * דפוס: ea-s006-testimonials-slug-once.php (template_redirect @0, wp_safe_redirect 301).
 * לא מפנים אם עמוד היעד אינו publish — עדיף מקור 200 מאשר 301 ל-404.
 *
 * @return void
 */
function ea_s006_r2_w1_legacy_301() {
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

	/* S006 · מקור: INTAKE-NIMROD-R2-MAP-2026-08-24.md · נימרוד 24.8.2026 */
	$map = array(
		'/about/moksha/'                      => '/eyal-amit/mokesh-dahiman/',
		'/tools-and-accessories/'             => '/shop/',
		'/tools-and-accessories/instruments/' => '/didgeridoos/',
		'/tools-and-accessories/repair/'      => '/repair/',
		'/services/handmade-instruments/'     => '/didgeridoos/',
	);

	$dest = '';
	foreach ( $map as $from => $to ) {
		$key = trailingslashit( (string) wp_parse_url( home_url( $from ), PHP_URL_PATH ) );
		if ( $norm === $key ) {
			$dest = $to;
			break;
		}
	}
	if ( '' === $dest ) {
		return;
	}

	$target = get_page_by_path( trim( $dest, '/' ), OBJECT, 'page' );
	if ( ! $target instanceof WP_Post || 'publish' !== $target->post_status ) {
		return;
	}

	header( 'X-EA-Redirect: s006-r2-w1' );
	wp_safe_redirect( home_url( $dest ), 301 );
	exit;
}
// priority 0 — לפני redirect_canonical (@10) ולפני טבלת הנתיבים הקנוניים של M2 (@1).
add_action( 'template_redirect', 'ea_s006_r2_w1_legacy_301', 0 );
