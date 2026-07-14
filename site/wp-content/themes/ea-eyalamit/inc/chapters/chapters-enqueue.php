<?php
/**
 * Chapters (פרקים) — asset enqueue.
 *
 * Loads the single-source chapters.css, the 3-family Google Fonts, and the
 * runtime JS — only on Chapters views, at a late priority so chapters.css wins
 * the cascade over any base sheet still on the page. Version-pinned to the
 * theme Version header (cache-busts on the style.css bump), exactly like the
 * rest of the theme's enqueues.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue Chapters assets on Chapters views.
 */
function ea_chapters_enqueue_assets() {
	if ( is_admin() || ! ( ea_chapters_is_view() || ( function_exists( 'ea_chapters_is_blog_view' ) && ea_chapters_is_blog_view() ) ) ) {
		return;
	}
	$ver = wp_get_theme()->get( 'Version' );
	$uri = get_stylesheet_directory_uri();

	// 3-family Google Fonts: Heebo (body+headings) · Frank Ruhl Libre (hero/quotes) · Suez One (display).
	wp_enqueue_style(
		'ea-chapters-fonts',
		'https://fonts.googleapis.com/css2?family=Heebo:wght@200;300;400;500;600;700;800&family=Frank+Ruhl+Libre:wght@300;400;500;700&family=Suez+One&display=swap',
		array(),
		null
	);

	// Single-source design system CSS.
	wp_enqueue_style(
		'ea-chapters',
		$uri . '/assets/css/chapters.css',
		array( 'ea-chapters-fonts' ),
		$ver
	);

	// Runtime: reveal + nav scroll-state + mobile burger + sound toggle.
	wp_enqueue_script(
		'ea-chapters',
		$uri . '/assets/js/ea-chapters.js',
		array(),
		$ver,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_chapters_enqueue_assets', 100 );

/**
 * Body class marker for Chapters views (useful for any future scoping).
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_chapters_body_class( $classes ) {
	if ( ( ea_chapters_is_view() || ( function_exists( 'ea_chapters_is_blog_view' ) && ea_chapters_is_blog_view() ) ) && ! in_array( 'ea-chapters', $classes, true ) ) {
		$classes[] = 'ea-chapters';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_chapters_body_class', 105 );

/**
 * Enqueue the Mokesh memorial hero trailer script — scoped to /eyal-amit/mokesh-dahiman/
 * only. Ported from inc/wave2-w2-14e.php's ea_w2_14e_assets() (WP-CANON T1). The Wave2
 * enqueue call is intentionally left in place (harmless double-registration under the
 * same 'ea-mokesh' handle — WP dedupes by handle) until T6 removes that file; see
 * LOD400 T1 §6 for the sequencing note T6 must respect.
 */
function ea_chapters_mokesh_enqueue_assets() {
	if ( is_admin() || 'mokesh-dahiman' !== ea_chapters_current_slug() ) {
		return;
	}
	wp_enqueue_script(
		'ea-mokesh',
		get_stylesheet_directory_uri() . '/assets/js/ea-mokesh.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_chapters_mokesh_enqueue_assets', 101 );

/**
 * FAQ topic TOC (relocated from inc/wave2-w2-02.php after T6 deletion).
 */
function ea_chapters_faq_toc_assets() {
	if ( is_admin() || ! is_page( 'faq' ) ) {
		return;
	}
	$ver = wp_get_theme()->get( 'Version' );
	$uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'ea-faq-toc',
		$uri . '/assets/css/faq-toc.css',
		array( 'ea-wave2-atoms' ),
		$ver
	);
	wp_enqueue_script(
		'ea-faq-toc',
		$uri . '/assets/js/ea-faq-toc.js',
		array(),
		$ver,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_chapters_faq_toc_assets', 30 );

/**
 * Blog archive/single assets (relocated from inc/wave2-w2-06.php after T6 deletion).
 */
function ea_chapters_blog_assets() {
	if ( is_admin() || ! function_exists( 'ea_chapters_is_blog_view' ) || ! ea_chapters_is_blog_view() ) {
		return;
	}
	$ver = wp_get_theme()->get( 'Version' );
	$uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'ea-blog',
		$uri . '/assets/css/ea-blog.css',
		array( 'ea-wave2-tokens' ),
		$ver
	);

	if ( is_singular( 'post' ) ) {
		wp_enqueue_script(
			'ea-blog-share',
			$uri . '/assets/js/ea-blog-share.js',
			array(),
			$ver,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'ea_chapters_blog_assets', 29 );

/**
 * Blog view body classes (relocated from inc/wave2-w2-06.php).
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_chapters_blog_body_class( $classes ) {
	if ( ! function_exists( 'ea_chapters_is_blog_view' ) || ! ea_chapters_is_blog_view() ) {
		return $classes;
	}
	if ( is_home() && ! is_front_page() && ! in_array( 'ea-blog-archive-view', $classes, true ) ) {
		$classes[] = 'ea-blog-archive-view';
	}
	if ( is_singular( 'post' ) && ! in_array( 'ea-blog-single-view', $classes, true ) ) {
		$classes[] = 'ea-blog-single-view';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_chapters_blog_body_class', 106 );
