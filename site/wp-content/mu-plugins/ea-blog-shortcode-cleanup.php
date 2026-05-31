<?php
/**
 * Strip legacy Visual Composer / Elementor shortcodes from blog post content AND excerpts on render.
 *
 * Runs on 'the_content' (singular posts) and 'get_the_excerpt' (archive cards / anywhere) so that
 * raw [vc_row …] / [et_pb_*] strings never reach the rendered page. The archive excerpt pipeline
 * (wp_trim_excerpt) does NOT strip unregistered shortcodes, so without the excerpt hook the blog
 * archive cards leak raw shortcodes (F-W2-06-03 / IDEA-006).
 *
 * Does NOT modify the DB — only affects rendered output. Fully reversible (deactivate mu-plugin).
 */

add_filter( 'the_content', 'ea_strip_legacy_blog_shortcodes_content', 1 );
add_filter( 'get_the_excerpt', 'ea_strip_legacy_blog_shortcodes_excerpt', 20 );

/**
 * Pure string cleaner — removes VC/Elementor/caption/unknown shortcodes, preserving inner text.
 */
function ea_strip_legacy_blog_shortcodes( $text ) {
	// Strip Visual Composer wrapper tags, preserve inner text
	$text = preg_replace( '/\[vc_[^\]]*\]|\[\/vc_[^\]]*\]/', '', $text );
	// Strip Elementor (et_pb_*) wrapper tags, preserve inner text
	$text = preg_replace( '/\[et_pb_[^\]]*\]|\[\/et_pb_[^\]]*\]/', '', $text );
	// Strip caption shortcode but keep the image inside
	$text = preg_replace( '/\[caption[^\]]*\](.*?)\[\/caption\]/s', '$1', $text );
	// Strip any remaining unrecognised paired shortcodes — keep inner content
	$text = preg_replace( '/\[([a-z_-]+)[^\]]*\](.*?)\[\/\1\]/s', '$2', $text );
	// Strip remaining self-closing unknown shortcodes
	$text = preg_replace( '/\[[a-z_-]+[^\]]*\/?\]/', '', $text );
	return $text;
}

/** the_content — singular posts only (preserves prior behaviour). */
function ea_strip_legacy_blog_shortcodes_content( $content ) {
	if ( ! is_singular( 'post' ) ) {
		return $content;
	}
	return ea_strip_legacy_blog_shortcodes( $content );
}

/** get_the_excerpt — posts only (fixes archive-card shortcode leakage). */
function ea_strip_legacy_blog_shortcodes_excerpt( $excerpt ) {
	if ( 'post' !== get_post_type() ) {
		return $excerpt;
	}
	$excerpt = ea_strip_legacy_blog_shortcodes( $excerpt );
	// Collapse whitespace left where a stripped shortcode sat.
	return trim( preg_replace( '/\s{2,}/', ' ', $excerpt ) );
}
