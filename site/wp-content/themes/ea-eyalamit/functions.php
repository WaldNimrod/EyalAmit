<?php
/**
 * Child theme for GeneratePress — ea-eyalamit
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load textdomain for child theme strings.
 */
function ea_eyalamit_setup() {
	load_child_theme_textdomain( 'ea-eyalamit', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'ea_eyalamit_setup' );

/**
 * Enqueue child stylesheet after GeneratePress parent.
 */
function ea_eyalamit_enqueue_styles() {
	wp_enqueue_style(
		'ea-eyalamit-style',
		get_stylesheet_uri(),
		array( 'generate-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'ea_eyalamit_enqueue_styles', 20 );

/**
 * English landing (P19): LTR body + class for scoped CSS (WP-THEME-EVALUATION §5–7).
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function ea_eyalamit_body_class( $classes ) {
	if ( is_page( 'en' ) || is_page( 'english' ) ) {
		$classes[] = 'ea-lang-en';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_eyalamit_body_class' );
