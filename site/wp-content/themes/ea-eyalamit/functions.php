<?php
/**
 * Child theme for GeneratePress — ea-eyalamit
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * True when rendering the M2 home dashboard layout (מבנה ב׳; ויזואל לפי אתר קיים).
 * Uses page_on_front (not slug) so staging matches Reading settings even if slug differs from `home`.
 */
function ea_eyalamit_is_home_dashboard_view() {
	if ( is_page_template( 'page-templates/template-home-dashboard.php' ) ) {
		return true;
	}
	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id > 0 && is_page( $front_id ) && is_front_page() ) {
		return true;
	}
	return false;
}

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

	if ( ea_eyalamit_is_home_dashboard_view() ) {
		/* טיפוגרפיה וטוקנים: style.css. כאן רק טעינת פונטים + פריסת דף הבית. */
		wp_enqueue_style(
			'ea-eyalamit-home-fonts',
			'https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap',
			array(),
			null
		);
		wp_enqueue_style(
			'ea-eyalamit-home-front',
			get_stylesheet_directory_uri() . '/assets/css/home-front.css',
			array( 'ea-eyalamit-style', 'ea-eyalamit-home-fonts' ),
			wp_get_theme()->get( 'Version' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'ea_eyalamit_enqueue_styles', 20 );

/**
 * Preconnect to Google Fonts for home dashboard.
 */
function ea_eyalamit_home_font_preconnect( $urls, $relation_type ) {
	if ( 'preconnect' !== $relation_type || ! ea_eyalamit_is_home_dashboard_view() ) {
		return $urls;
	}
	$urls[] = array(
		'href' => 'https://fonts.googleapis.com',
	);
	$urls[] = array(
		'href' => 'https://fonts.gstatic.com',
		'crossorigin' => 'anonymous',
	);
	return $urls;
}
add_filter( 'wp_resource_hints', 'ea_eyalamit_home_font_preconnect', 10, 2 );

/**
 * Force home dashboard template for static front page with slug `home` (M2 seed).
 *
 * @param string $template Path to template file.
 * @return string
 */
function ea_eyalamit_home_dashboard_template( $template ) {
	if ( ! is_front_page() || ! is_page() ) {
		return $template;
	}
	$front_id = (int) get_option( 'page_on_front', 0 );
	if ( $front_id < 1 || (int) get_queried_object_id() !== $front_id ) {
		return $template;
	}
	$t = get_stylesheet_directory() . '/page-templates/template-home-dashboard.php';
	return is_readable( $t ) ? $t : $template;
}
add_filter( 'template_include', 'ea_eyalamit_home_dashboard_template', 99 );

/**
 * Body class for home dashboard styling scope.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function ea_eyalamit_body_class( $classes ) {
	if ( is_page( 'en' ) || is_page( 'english' ) ) {
		$classes[] = 'ea-lang-en';
	}
	if ( ea_eyalamit_is_home_dashboard_view() ) {
		$classes[] = 'ea-home-dashboard';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_eyalamit_body_class' );

/**
 * GeneratePress: no sidebar on home dashboard.
 *
 * @param string $layout Layout slug.
 * @return string
 */
function ea_eyalamit_home_sidebar_layout( $layout ) {
	if ( ea_eyalamit_is_home_dashboard_view() ) {
		return 'no-sidebar';
	}
	return $layout;
}
add_filter( 'generate_sidebar_layout', 'ea_eyalamit_home_sidebar_layout', 20 );

/**
 * GeneratePress: hide content title — H1 is inside template hero.
 *
 * @param bool $show Whether to show title.
 * @return bool
 */
function ea_eyalamit_home_hide_title( $show ) {
	if ( ea_eyalamit_is_home_dashboard_view() ) {
		return false;
	}
	return $show;
}
add_filter( 'generate_show_title', 'ea_eyalamit_home_hide_title', 20 );
