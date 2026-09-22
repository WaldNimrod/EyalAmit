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
	$ea_blog_dummy = function_exists( 'ea_blog_json_dummy_preview_active' ) && ea_blog_json_dummy_preview_active();
	if ( is_admin() || ! ( ea_chapters_is_view() || ( function_exists( 'ea_chapters_is_blog_view' ) && ea_chapters_is_blog_view() ) || $ea_blog_dummy ) ) {
		return;
	}
	$ver = wp_get_theme()->get( 'Version' );
	$uri = get_stylesheet_directory_uri();

	// 2-family Google Fonts: Heebo (body+headings) · Frank Ruhl Libre (the .bleed__q pull
	// quote — team_00's one named exception to the Heebo collapse; keep this family).
	// S007 M-10: Suez One removed from this request — zero elements computed it across
	// all 157 URLs (its --display consumers were repointed to var(--bf) in S007 M-07).
	if ( function_exists( 'ea_cookie_measurement_allowed' ) && ea_cookie_measurement_allowed() ) {
		wp_enqueue_style(
			'ea-chapters-fonts',
			'https://fonts.googleapis.com/css2?family=Heebo:wght@200;300;400;500;600;700;800&family=Frank+Ruhl+Libre:wght@300;400;500;700&display=swap',
			array(),
			null
		);
	}

	// Single-source design system CSS.
	$chapters_deps = array();
	if ( wp_style_is( 'ea-chapters-fonts', 'enqueued' ) || wp_style_is( 'ea-chapters-fonts', 'registered' ) ) {
		$chapters_deps[] = 'ea-chapters-fonts';
	}
	wp_enqueue_style(
		'ea-chapters',
		$uri . '/assets/css/chapters.css',
		$chapters_deps,
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

	wp_enqueue_script(
		'ea-testi-mq',
		$uri . '/assets/js/ea-testi-mq.js',
		array(),
		$ver,
		true
	);

	/* Image lightbox — loaded on every Chapters view because any page may carry a
	   document screenshot beside its text. It exits immediately when the page has no
	   [data-zoom-src] trigger, so the cost on pages without one is a parsed no-op. */
	wp_enqueue_script(
		'ea-lightbox',
		$uri . '/assets/js/ea-lightbox.js',
		array(),
		$ver,
		true
	);

	/* Page TOC (inline / rail / mobile sheet) — loaded on every Chapters view
	   because any inner page may carry the part. It exits immediately when the
	   page has no .ea-toc, so the cost on pages without one is a parsed no-op. */
	wp_enqueue_script(
		'ea-toc',
		$uri . '/assets/js/ea-toc.js',
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
	$ea_blog_dummy = function_exists( 'ea_blog_json_dummy_preview_active' ) && ea_blog_json_dummy_preview_active();
	if ( ( ea_chapters_is_view() || ( function_exists( 'ea_chapters_is_blog_view' ) && ea_chapters_is_blog_view() ) || $ea_blog_dummy ) && ! in_array( 'ea-chapters', $classes, true ) ) {
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
	$ea_blog_dummy = function_exists( 'ea_blog_json_dummy_preview_active' ) && ea_blog_json_dummy_preview_active();
	if ( is_admin() || ( ! function_exists( 'ea_chapters_is_blog_view' ) || ! ea_chapters_is_blog_view() ) && ! $ea_blog_dummy ) {
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
	$ea_blog_dummy = function_exists( 'ea_blog_json_dummy_preview_active' ) && ea_blog_json_dummy_preview_active();
	if ( ( ! function_exists( 'ea_chapters_is_blog_view' ) || ! ea_chapters_is_blog_view() ) && ! $ea_blog_dummy ) {
		return $classes;
	}
	if ( is_home() && ! is_front_page() && ! in_array( 'ea-blog-archive-view', $classes, true ) ) {
		$classes[] = 'ea-blog-archive-view';
	}
	if ( ( is_singular( 'post' ) || $ea_blog_dummy ) && ! in_array( 'ea-blog-single-view', $classes, true ) ) {
		$classes[] = 'ea-blog-single-view';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_chapters_blog_body_class', 106 );
