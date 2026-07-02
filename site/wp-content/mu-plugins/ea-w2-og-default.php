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
 * WP-W2-17 T7 live-verify correction (2026-07-03): the original premise here — "Yoast
 * emits NO og:image on any route" — was only true for routes WITHOUT a featured image.
 * seo_probe.mjs's og:image check caught a real duplicate on /books/kushi-blantis/ (which
 * DOES have an uploaded featured image, kushi-blantis-cover.jpg): Yoast auto-detects and
 * emits its own og:image (with width/height/type) whenever has_post_thumbnail() is true,
 * and this mu-plugin ALSO printed the same URL again as a second tag.
 *
 * Fix: only emit here when there is NO featured image (the sitewide-default-image case,
 * which is confirmed to be the one case Yoast has nothing to emit for). When a singular
 * post has its own featured image, defer to Yoast entirely and print nothing.
 */
add_action(
	'wp_head',
	function () {
		if ( is_singular() && has_post_thumbnail() ) {
			// Yoast already emits og:image from the post's own featured image in this
			// case (confirmed live) — printing here too would duplicate the tag.
			return;
		}

		$url  = ea_w2_og_default_image_url();
		$w    = 0;
		$h    = 0;
		$path = get_stylesheet_directory() . '/assets/images/eyal-portrait-hero.jpg';
		if ( is_readable( $path ) ) {
			$size = @getimagesize( $path );
			if ( is_array( $size ) ) {
				$w = (int) $size[0];
				$h = (int) $size[1];
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
