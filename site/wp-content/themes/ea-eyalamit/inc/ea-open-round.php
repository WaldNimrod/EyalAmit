<?php
/**
 * Open-round (2026-09-22) — home spotlight, DA chrome/a11y, contact thank-you enqueue.
 *
 * CSS lives in assets/css/ea-open-round.css so Team 10 can keep owning chapters.css.
 * Does not edit inc/ea-canonical-nav.php (L1 locked).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load open-round CSS after Chapters so float/nav overrides win.
 */
function ea_open_round_enqueue() {
	if ( is_admin() ) {
		return;
	}
	$ver = wp_get_theme()->get( 'Version' );
	$uri = get_stylesheet_directory_uri();
	$deps = array();
	if ( wp_style_is( 'ea-chapters', 'enqueued' ) || wp_style_is( 'ea-chapters', 'registered' ) ) {
		$deps[] = 'ea-chapters';
	}
	wp_enqueue_style( 'ea-open-round', $uri . '/assets/css/ea-open-round.css', $deps, $ver );

	/* GP / EN orphans need the Chapters nav sheet; skip JS (drawer owns the burger). */
	if ( is_page( ea_open_round_chrome_slugs() ) && ! wp_style_is( 'ea-chapters', 'enqueued' ) ) {
		wp_enqueue_style(
			'ea-chapters',
			$uri . '/assets/css/chapters.css',
			array(),
			$ver
		);
	}

	/* EI-A4: thank-you redirect JS is in ea-ab-testing.js but Wave2 whitelist
	   misses live Chapters /contact/. */
	if ( is_page( 'contact' ) && ! wp_script_is( 'ea-wave2-ab-testing', 'enqueued' ) ) {
		wp_enqueue_script(
			'ea-wave2-ab-testing',
			$uri . '/assets/js/ea-ab-testing.js',
			array(),
			$ver,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'ea_open_round_enqueue', 110 );

/**
 * Unified Chapters header on GP about/press (DA-NAV-02).
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_open_round_chrome_slugs() {
	$slugs = array( 'en' );
	if ( function_exists( 'ea_nav_drawer_orphan_slugs' ) ) {
		$slugs = array_merge( ea_nav_drawer_orphan_slugs(), $slugs );
	} else {
		$slugs = array( 'shows-heritage', 'historical-articles', 'thank-you', 'courses-soon', 'press', 'en' );
	}
	return $slugs;
}

/**
 * @param string[] $classes
 * @return string[]
 */
function ea_open_round_body_class( $classes ) {
	if ( is_page( ea_open_round_chrome_slugs() ) ) {
		$classes[] = 'ea-open-round-chrome';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_open_round_body_class', 106 );

/**
 * Inject Chapters nav on GP / EN pages (DA-NAV-02). GP header is then hidden in CSS.
 */
function ea_open_round_inject_chapters_nav() {
	if ( ! is_page( ea_open_round_chrome_slugs() ) ) {
		return;
	}
	get_template_part( 'template-parts/chapters/section', 'nav' );
}
add_action( 'wp_body_open', 'ea_open_round_inject_chapters_nav', 20 );

/**
 * Do not emit GeneratePress's navigation on the two pages that still load
 * the parent header.
 *
 * Measured 2026-09-26 on the 136 sitemap URLs (redirects not followed): only
 * /press/ and /historical-articles/ lack the ea-chapters body class, and only
 * those two contain id="site-navigation" (1) plus class main-navigation (2).
 * /press/ is force-routed to page-templates/tpl-content.php, which calls
 * get_header(). /historical-articles/ is not in ea_chapters_route_map(), so
 * it falls through to GeneratePress page.php, which also calls get_header().
 * Child header.php then loads the parent header. Body class nav-float-right
 * selects generate_add_navigation_float_right(), which calls
 * generate_navigation_position() and prints both
 * nav.main-navigation#mobile-menu-control-wrapper and
 * nav#site-navigation.main-navigation. The other 134 pages are Chapters
 * documents and never call get_header(), so those hooks never run.
 *
 * The canonical nav#nav is already injected above. These remove_action calls
 * are GeneratePress's own extension point for a child that supplies its own
 * navigation (see the parent comments on generate_add_navigation_*). The
 * site-header shell is left in place; only the navigation constructors are
 * removed, so the markup is not emitted.
 */
function ea_open_round_unhook_gp_navigation() {
	if ( ! is_page( array( 'press', 'historical-articles' ) ) ) {
		return;
	}
	remove_action( 'generate_after_header_content', 'generate_add_navigation_float_right', 5 );
	remove_action( 'generate_after_header', 'generate_add_navigation_after_header', 5 );
	remove_action( 'generate_before_header', 'generate_add_navigation_before_header', 5 );
	remove_action( 'generate_before_right_sidebar_content', 'generate_add_navigation_before_right_sidebar', 5 );
	remove_action( 'generate_before_left_sidebar_content', 'generate_add_navigation_before_left_sidebar', 5 );
}
add_action( 'wp', 'ea_open_round_unhook_gp_navigation', 20 );

/**
 * DA-P2-05 — visitor title matches the shop H1, not the WP admin name.
 *
 * @param string $title
 * @return string
 */
function ea_open_round_shop_document_title( $title ) {
	if ( is_admin() || ! is_page( 'shop' ) ) {
		return $title;
	}
	$h1   = 'כלים בעבודת יד ואביזרים';
	$site = wp_strip_all_tags( get_bloginfo( 'name', 'display' ) );
	return $site ? $h1 . ' - ' . $site : $h1;
}
add_filter( 'pre_get_document_title', 'ea_open_round_shop_document_title', 20 );

/**
 * lang="he" attribute when the page is English.
 *
 * @return string
 */
function ea_open_round_he_attr() {
	return is_page( 'en' ) ? ' lang="he" dir="rtl"' : '';
}
