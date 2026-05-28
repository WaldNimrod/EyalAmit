<?php
/**
 * WP-W2-06 Blog Migration — blog-specific hooks and enqueue.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue blog CSS on archive and single post templates.
 */
add_action( 'wp_enqueue_scripts', 'ea_w2_06_enqueue_blog_assets' );
function ea_w2_06_enqueue_blog_assets() {
	$ver = wp_get_theme()->get( 'Version' );
	if ( ea_wave2_is_active_view( 'tpl-blog-archive' ) || is_singular( 'post' ) ) {
		wp_enqueue_style(
			'ea-blog',
			get_stylesheet_directory_uri() . '/assets/css/ea-blog.css',
			[ 'ea-tokens' ],
			$ver
		);
	}
}

/**
 * Add body classes for blog views.
 */
add_filter( 'body_class', 'ea_w2_06_body_classes' );
function ea_w2_06_body_classes( $classes ) {
	if ( ea_wave2_is_active_view( 'tpl-blog-archive' ) ) {
		$classes[] = 'ea-blog-archive-view';
	}
	if ( is_singular( 'post' ) ) {
		$classes[] = 'ea-blog-single-view';
	}
	return $classes;
}
