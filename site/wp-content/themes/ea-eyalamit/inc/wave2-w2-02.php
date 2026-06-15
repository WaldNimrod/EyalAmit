<?php
/**
 * WP-W2-02 — Core Content routing, redirects, assets.
 * Overrides legacy template_include filters (priority 92–98) with Wave2 templates.
 * Priority 100 ensures this runs after all legacy filters.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Wave2 core page slugs handled by this WP.
 *
 * @return string[]
 */
function ea_w2_02_wave2_slugs() {
	return array( 'method', 'treatment', 'faq', 'contact', 'about' );
}

/**
 * True when the current request is a Wave2 core page (or homepage).
 *
 * @return bool
 */
function ea_w2_02_is_wave2_page() {
	if ( is_front_page() && is_page() ) {
		return true;
	}
	if ( ! is_page() ) {
		return false;
	}
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	return in_array( $slug, ea_w2_02_wave2_slugs(), true );
}

/**
 * Route Wave2 core pages to their templates.
 * Runs at priority 100 — after legacy filters at 92–98.
 *
 * @param string $tpl Current template path.
 * @return string
 */
function ea_w2_02_template_include( $tpl ) {
	if ( is_front_page() && is_page() ) {
		$t = locate_template( 'page-templates/tpl-home.php' );
		if ( $t ) {
			return $t;
		}
	}
	if ( ! is_page() ) {
		return $tpl;
	}
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	$map  = array(
		'method'    => 'tpl-service',
		'treatment' => 'tpl-service',
		'faq'       => 'tpl-faq',
		'contact'   => 'tpl-contact',
		'about'     => 'tpl-content',
	);
	if ( isset( $map[ $slug ] ) ) {
		$t = locate_template( 'page-templates/' . $map[ $slug ] . '.php' );
		if ( $t ) {
			return $t;
		}
	}
	return $tpl;
}
add_filter( 'template_include', 'ea_w2_02_template_include', 100 );

/**
 * Mark W2-02 force-routed pages as a Wave2 active view so Stage-B asset
 * dequeue (ea_wave2_is_active_view) recognizes them. These pages are routed
 * via template_include without assigning template meta, so is_page_template()
 * cannot detect them. Runs before wp_enqueue_scripts.
 */
add_action( 'template_redirect', function () {
	if ( ea_w2_02_is_wave2_page() ) {
		set_query_var( 'ea_wave2_shell', true );
	}
} );

/**
 * Add ea-wave2-shell body class on all 6 core pages.
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_w2_02_body_class( $classes ) {
	if ( ! ea_w2_02_is_wave2_page() ) {
		return $classes;
	}
	if ( ! in_array( 'ea-wave2-shell', $classes, true ) ) {
		$classes[] = 'ea-wave2-shell';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_w2_02_body_class', 102 );

/**
 * No sidebar on Wave2 core pages.
 *
 * @param string $layout
 * @return string
 */
function ea_w2_02_sidebar_layout( $layout ) {
	if ( ea_w2_02_is_wave2_page() ) {
		return 'no-sidebar';
	}
	return $layout;
}
add_filter( 'generate_sidebar_layout', 'ea_w2_02_sidebar_layout', 103 );

/**
 * Hide GeneratePress content title on Wave2 pages (H1 is inside template/content).
 *
 * @param bool $show
 * @return bool
 */
function ea_w2_02_hide_gp_title( $show ) {
	if ( ea_w2_02_is_wave2_page() ) {
		return false;
	}
	return $show;
}
add_filter( 'generate_show_title', 'ea_w2_02_hide_gp_title', 103 );

/**
 * Enqueue the FAQ topic-navigation (TOC) assets on /faq only.
 *
 * WP-W2-16-C — replaces the old <select> topic filter (ea-faq-filter.js) with a
 * sticky topic menu: anchor jump-to-section + scroll-spy. faq-toc.css depends on
 * the atoms sheet (registered by ea_wave2_enqueue_assets at priority 28), so this
 * runs at priority 30 to guarantee the dependency is already registered.
 */
function ea_w2_02_faq_assets() {
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
add_action( 'wp_enqueue_scripts', 'ea_w2_02_faq_assets', 30 );

/**
 * 301 redirects: legacy about slug + eyal-amit → /about/.
 * Runs at priority 2 (before canonical redirect at priority 1 in site-tree mu-plugin).
 */
function ea_w2_02_legacy_redirects() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? rawurldecode( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
	$norm = trailingslashit( $path );

	$redirects = array(
		// Legacy Hebrew slug from old site → /about/.
		trailingslashit( (string) wp_parse_url( home_url( '/אייל-עמית-אודות/' ), PHP_URL_PATH ) ) => home_url( '/about/' ),
		// Site-tree eyal-amit page → canonical /about/.
		trailingslashit( (string) wp_parse_url( home_url( '/eyal-amit/' ), PHP_URL_PATH ) )         => home_url( '/about/' ),
		// Mokesh memorial — canonical is /about/moksha (where it renders + the content
		// gate measures). Both the nested site-tree slug AND the top-level slug 301 to
		// it in ONE hop (priority 2 beats WP's canonical redirect, which otherwise made
		// /mokesh-dahiman a 2-hop via /eyal-amit/mokesh-dahiman). WP-W2-15 F-W2-15-CA H5.
		trailingslashit( (string) wp_parse_url( home_url( '/eyal-amit/mokesh-dahiman/' ), PHP_URL_PATH ) ) => home_url( '/about/moksha/' ),
		trailingslashit( (string) wp_parse_url( home_url( '/mokesh-dahiman/' ), PHP_URL_PATH ) ) => home_url( '/about/moksha/' ),
	);

	foreach ( $redirects as $from => $to ) {
		if ( $norm === $from ) {
			wp_safe_redirect( $to, 301 );
			exit;
		}
	}
}
add_action( 'template_redirect', 'ea_w2_02_legacy_redirects', 2 );

/**
 * CF7 form ID for Wave2 contact page.
 * Set this to the actual post ID once the form is created in wp-admin → Contact → Contact Forms.
 * Example: add_filter( 'ea_wave2_cf7_form_id', fn() => 3 );
 */
// TODO: Set actual CF7 form ID after Eyal creates the form in wp-admin.
