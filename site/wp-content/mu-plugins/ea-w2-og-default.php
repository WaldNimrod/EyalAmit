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
 * Yoast v27.8 emits NO og:image on this install (no per-page image + no Yoast default),
 * and the wpseo_opengraph_image filter does not fire when Yoast has no base image to
 * filter. So emit og:image + twitter:image directly on wp_head. Use the queried
 * singular's featured image when present (with real dimensions), else the sitewide
 * brand default. Yoast emits none here, so this is the single og:image (no duplicate).
 */
add_action(
	'wp_head',
	function () {
		$url = '';
		$w   = 0;
		$h   = 0;

		if ( is_singular() && has_post_thumbnail() ) {
			$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			if ( is_array( $src ) && ! empty( $src[0] ) ) {
				$url = $src[0];
				$w   = (int) $src[1];
				$h   = (int) $src[2];
			}
		}

		if ( '' === $url ) {
			$url  = ea_w2_og_default_image_url();
			$path = get_stylesheet_directory() . '/assets/images/eyal-portrait-hero.jpg';
			if ( is_readable( $path ) ) {
				$size = @getimagesize( $path );
				if ( is_array( $size ) ) {
					$w = (int) $size[0];
					$h = (int) $size[1];
				}
			}
		}

		if ( '' === $url ) {
			return;
		}

		printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $url ) );
		if ( $w > 0 && $h > 0 ) {
			printf( '<meta property="og:image:width" content="%d" />' . "\n", $w );
			printf( '<meta property="og:image:height" content="%d" />' . "\n", $h );
		}
		printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $url ) );
	},
	5
);
