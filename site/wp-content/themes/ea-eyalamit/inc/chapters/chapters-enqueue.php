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
	if ( is_admin() || ! ea_chapters_is_view() ) {
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
	if ( ea_chapters_is_view() && ! in_array( 'ea-chapters', $classes, true ) ) {
		$classes[] = 'ea-chapters';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_chapters_body_class', 105 );
