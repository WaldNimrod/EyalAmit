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
			[ 'ea-wave2-tokens' ],
			$ver
		);
	}
	// WP-W2-11 S3 — copy-link share button on single posts only.
	if ( is_singular( 'post' ) ) {
		wp_enqueue_script(
			'ea-blog-share',
			get_stylesheet_directory_uri() . '/assets/js/ea-blog-share.js',
			[],
			$ver,
			true
		);
	}
}

/**
 * Add body classes for blog views.
 */
add_filter( 'body_class', 'ea_w2_06_body_classes' );
function ea_w2_06_body_classes( $classes ) {
	// ea_wave2_is_active_view() takes NO argument — it returns true for ANY Wave2 template,
	// so the prior call leaked 'ea-blog-archive-view' onto /en and every Wave2 page (F-W2-08-01).
	// Scope strictly to the actual blog archive: the posts page (is_home) or tpl-blog-archive.
	if ( is_home() || is_page_template( 'page-templates/tpl-blog-archive.php' ) ) {
		$classes[] = 'ea-blog-archive-view';
	}
	if ( is_singular( 'post' ) ) {
		$classes[] = 'ea-blog-single-view';
	}
	return $classes;
}

/**
 * Route the blog Posts page (/blog/ = page_for_posts, is_home) and single posts
 * to their Wave2 templates. WP ignores page templates on the posts page, and
 * single posts have no page-template meta, so route via template_include.
 * set_query_var('ea_wave2_shell', true) makes ea_wave2_is_active_view() treat
 * these as Wave2 views (enables ea-blog asset enqueue + Stage-B dequeue). The
 * filter runs before wp_enqueue_scripts.
 */
add_filter( 'template_include', 'ea_w2_06_template_include', 100 );
function ea_w2_06_template_include( $tpl ) {
	if ( is_home() && ! is_front_page() ) {
		$t = locate_template( 'page-templates/tpl-blog-archive.php' );
		if ( $t ) {
			set_query_var( 'ea_wave2_shell', true );
			return $t;
		}
	}
	if ( is_singular( 'post' ) ) {
		$t = locate_template( 'page-templates/tpl-blog-single.php' );
		if ( $t ) {
			set_query_var( 'ea_wave2_shell', true );
			return $t;
		}
	}
	return $tpl;
}

/**
 * WP-W2-11 S3 (Blog D) — display-only author byline.
 * The WP user is 'eyaladmin'; the public byline must read 'אייל עמית'.
 * This filters the DISPLAYED name only on single-post views — it does NOT
 * touch the WP user, the Yoast nicename, or add an /author/ 301 (deferred to
 * the production-cutover SEO pass per the S3 mandate).
 *
 * @param string $display_name The author's display name.
 * @return string
 */
add_filter( 'the_author', 'ea_w2_11_blog_author_display' );
add_filter( 'get_the_author_display_name', 'ea_w2_11_blog_author_display' );
function ea_w2_11_blog_author_display( $display_name ) {
	if ( is_singular( 'post' ) ) {
		return 'אייל עמית';
	}
	return $display_name;
}

/**
 * AC-03 a11y fix — sanitize broken ARIA left over from pasted Facebook/Instagram
 * embed HTML inside legacy post bodies (imported via blog-legacy.wxr).
 *
 * Two single posts carry copy-pasted Facebook React markup
 * (`<div class="x1a2a7pz" role="article" aria-posinset="NaN"
 *   aria-describedby="_r_…_" aria-labelledby="_r_…_">`). Facebook computes
 * `aria-posinset` client-side from a virtualized feed index; pasted out of that
 * context it serializes to the literal string "NaN" and its `aria-describedby`/
 * `aria-labelledby` reference IDs that do not exist on our page. Both are invalid
 * per the ARIA spec (axe: `aria-valid-attr-value`), producing the 2 critical
 * violations on the SINGLE post. The /blog/ ARCHIVE is unaffected because cards
 * render a stripped/trimmed excerpt (wp_strip_all_tags + wp_trim_words in
 * block-blog-card.php), so the embed div never reaches the archive DOM.
 *
 * Render-time only: no DB mutation (the stored post_content is left intact, so
 * this is composition-safe and reversible, and needs no API write). Scoped to
 * single posts and to the exact orphaned set-semantics attributes — it does not
 * touch valid ARIA anywhere else and does not affect the archive grid.
 *
 * @param string $content Post content HTML.
 * @return string
 */
add_filter( 'the_content', 'ea_w2_11_strip_orphan_embed_aria', 20 );
function ea_w2_11_strip_orphan_embed_aria( $content ) {
	if ( ! is_singular( 'post' ) || strpos( $content, 'aria-posinset="NaN"' ) === false ) {
		return $content;
	}
	// Remove the invalid set-position attribute (the gate blocker) plus the
	// dangling aria-describedby/aria-labelledby that point at non-existent
	// Facebook-generated IDs (_r_…_), which are themselves invalid references.
	$content = preg_replace( '/\s+aria-posinset="NaN"/', '', $content );
	$content = preg_replace( '/\s+aria-(?:describedby|labelledby)="(?:_r_[^"]*)"/', '', $content );
	return $content;
}
