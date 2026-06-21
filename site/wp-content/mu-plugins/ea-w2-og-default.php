<?php
/**
 * Plugin Name: EA W2 — default OG/Twitter image (extends Yoast)
 * Description: WP-04. Yoast SEO is the live engine but emits NO og:image on any route
 *   (no per-page featured image + no Yoast default configured), so social/AI cards have
 *   no image. This supplies a sitewide DEFAULT image via Yoast's own filters — only when
 *   Yoast/the page would otherwise have none — so there is never a duplicate tag. We
 *   EXTEND Yoast (per the schema lesson); we do NOT print a parallel <meta og:image>.
 *
 *   The default is a theme-shipped brand asset. A dedicated 1200×630 card image per
 *   route is a media-gated upgrade (EYL-3); swap via the `ea_w2_og_default_image_url`
 *   filter when it arrives.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sitewide default Open Graph / Twitter image URL (brand asset shipped with the theme).
 *
 * @return string
 */
function ea_w2_og_default_image_url() {
	$url = get_stylesheet_directory_uri() . '/assets/images/eyal-portrait-hero.jpg';
	return (string) apply_filters( 'ea_w2_og_default_image_url', $url );
}

/**
 * Fill in the OG image only when Yoast resolved none (empty), mirroring Yoast's own
 * "use the page image if it has one" behaviour — so pages WITH a featured image keep it
 * and we never emit two images.
 */
add_filter(
	'wpseo_opengraph_image',
	function ( $image ) {
		return ( empty( $image ) ) ? ea_w2_og_default_image_url() : $image;
	},
	20
);

add_filter(
	'wpseo_twitter_image',
	function ( $image ) {
		return ( empty( $image ) ) ? ea_w2_og_default_image_url() : $image;
	},
	20
);
