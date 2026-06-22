<?php
/**
 * Chapters (פרקים) — central routing. Overrides legacy templates (priority 101,
 * after wave2-w2-02 at 100) for the front page + mapped inner slugs when enabled.
 * Rollback-safe: define EA_CHAPTERS_FRONT false (or filter) to fall back instantly.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Route front page + mapped inner pages to their Chapters templates.
 *
 * @param string $tpl
 * @return string
 */
function ea_chapters_template_include( $tpl ) {
	if ( ! ea_chapters_enabled() ) {
		return $tpl;
	}
	if ( is_front_page() && is_page() ) {
		$t = locate_template( 'page-templates/tpl-chapters-home.php' );
		return $t ? $t : $tpl;
	}
	if ( is_page() ) {
		$map = ea_chapters_route_map();
		$slug = ea_chapters_current_slug();
		if ( isset( $map[ $slug ] ) ) {
			$t = locate_template( 'page-templates/' . $map[ $slug ]['template'] . '.php' );
			if ( $t ) {
				return $t;
			}
		}
	}
	return $tpl;
}
add_filter( 'template_include', 'ea_chapters_template_include', 101 );

/**
 * Mark Chapters views as a Wave2 active view (so Stage-B asset/dequeue logic and
 * the shell body class apply), since they are force-routed without template meta.
 */
add_action( 'template_redirect', function () {
	if ( ea_chapters_is_view() ) {
		set_query_var( 'ea_wave2_shell', true );
	}
} );

/** No GeneratePress sidebar on Chapters inner pages. */
add_filter( 'generate_sidebar_layout', function ( $layout ) {
	return ea_chapters_is_view() ? 'no-sidebar' : $layout;
}, 104 );

/** Hide the GeneratePress content title on Chapters inner pages (H1 is in the phero). */
add_filter( 'generate_show_title', function ( $show ) {
	return ea_chapters_is_view() ? false : $show;
}, 104 );
