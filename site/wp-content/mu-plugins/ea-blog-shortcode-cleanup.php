<?php
/**
 * Strip legacy Visual Composer / Elementor shortcodes from blog post content on render.
 *
 * Runs on 'the_content' filter at priority 1, before WP's own shortcode pass.
 * Does NOT modify the DB — only affects rendered output. Fully reversible (deactivate mu-plugin).
 * Handles ~80% of posts automatically; 5-10 complex posts require manual cleanup.
 */

add_filter( 'the_content', 'ea_strip_legacy_blog_shortcodes', 1 );

function ea_strip_legacy_blog_shortcodes( $content ) {
	if ( ! is_singular( 'post' ) ) {
		return $content;
	}

	// Strip Visual Composer wrapper tags, preserve inner text
	$content = preg_replace( '/\[vc_[^\]]*\]|\[\/vc_[^\]]*\]/', '', $content );

	// Strip Elementor (et_pb_*) wrapper tags, preserve inner text
	$content = preg_replace( '/\[et_pb_[^\]]*\]|\[\/et_pb_[^\]]*\]/', '', $content );

	// Strip caption shortcode but keep the image inside
	$content = preg_replace( '/\[caption[^\]]*\](.*?)\[\/caption\]/s', '$1', $content );

	// Strip any remaining unrecognised paired shortcodes — keep inner content
	$content = preg_replace( '/\[([a-z_-]+)[^\]]*\](.*?)\[\/\1\]/s', '$2', $content );

	// Strip remaining self-closing unknown shortcodes
	$content = preg_replace( '/\[[a-z_-]+[^\]]*\/?\]/', '', $content );

	return $content;
}
