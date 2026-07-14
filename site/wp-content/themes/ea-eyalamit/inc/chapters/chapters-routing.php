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
		$map  = ea_chapters_route_map();
		$slug = ea_chapters_current_slug();
		if ( isset( $map[ $slug ] ) ) {
			$t = locate_template( 'page-templates/' . $map[ $slug ]['template'] . '.php' );
			if ( $t ) {
				return $t;
			}
		}
		// Pattern-route — parent + child (e.g. /qr/qrN/).
		$post = get_queried_object();
		if ( $post instanceof WP_Post && $post->post_parent ) {
			$parent_slug = get_post_field( 'post_name', (int) $post->post_parent );
			$patterns    = ea_chapters_pattern_routes();
			if ( isset( $patterns[ $parent_slug ] ) ) {
				$t = locate_template( 'page-templates/' . $patterns[ $parent_slug ]['template'] . '.php' );
				if ( $t ) {
					return $t;
				}
			}
		}
	}
	return $tpl;
}
// Priority 103 so a Chapters-mapped slug wins over the WP-W2-14e catalog router
// (template_include @ 102) — e.g. /eyal-amit/mokesh-dahiman/. Unmapped 14e slugs
// (/galleries, /media) are untouched: this filter returns $tpl unchanged for them.
add_filter( 'template_include', 'ea_chapters_template_include', 103 );

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

/* ── Blog (archive + single) → Chapters chrome ───────────────────────────────
 * The page router above only handles is_page(); the blog Posts page (is_home) and
 * single posts (is_singular('post')) are routed here. Priority 105 wins over the
 * WP-W2-06 router (template_include @ 100). chapters.css/js + the body class are
 * enqueued for these views via chapters-enqueue (ea_chapters_is_blog_view). */
function ea_chapters_is_blog_view() {
	return ( is_home() && ! is_front_page() ) || is_singular( 'post' );
}

function ea_chapters_blog_template_include( $tpl ) {
	if ( ! ea_chapters_enabled() ) {
		return $tpl;
	}
	if ( is_home() && ! is_front_page() ) {
		$t = locate_template( 'page-templates/tpl-chapters-blog-archive.php' );
		if ( $t ) {
			set_query_var( 'ea_wave2_shell', true );
			return $t;
		}
	}
	if ( is_singular( 'post' ) ) {
		$t = locate_template( 'page-templates/tpl-chapters-blog-single.php' );
		if ( $t ) {
			set_query_var( 'ea_wave2_shell', true );
			return $t;
		}
	}
	return $tpl;
}
add_filter( 'template_include', 'ea_chapters_blog_template_include', 105 );
