<?php
/**
 * Chapters — QR embed facade (WP-S5-06).
 *
 * Replaces the rendered YouTube iframe on /qr/ pages with a click-to-load
 * facade. RENDER-FILTER ONLY: post_content is never modified, because
 * mu-plugins/ea-w2-seo-schema.php L266 regexes the RAW post_content to emit the
 * QR VideoObject nodes — a seed-change/reseed would silently delete every one of
 * them (WP-S5-06 LOD400 §2).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * True on the /qr/ hub or any /qr/{child}/ page.
 * Mirrors the schema gate at mu-plugins/ea-w2-seo-schema.php L238-246.
 *
 * @return bool
 */
function ea_chapters_qr_facade_is_view() {
	if ( ! is_page() ) {
		return false;
	}
	$obj = get_queried_object();
	if ( ! $obj instanceof WP_Post ) {
		return false;
	}
	if ( 'qr' === $obj->post_name && 0 === (int) $obj->post_parent ) {
		return true; // hub
	}
	return $obj->post_parent
		&& 'qr' === (string) get_post_field( 'post_name', (int) $obj->post_parent );
}

/**
 * Swap every YouTube iframe for a facade button. Non-YouTube iframes untouched.
 *
 * @param string $content
 * @return string
 */
function ea_chapters_qr_facade_content( $content ) {
	if ( is_admin() || ! is_main_query() || ! in_the_loop() || ! ea_chapters_qr_facade_is_view() ) {
		return $content;
	}
	if ( false === stripos( $content, '/embed/' ) ) {
		return $content;
	}

	$title = get_the_title( get_queried_object_id() );
	$total = preg_match_all(
		'#youtube(?:-nocookie)?\.com/embed/([A-Za-z0-9_-]{6,})#i',
		$content,
		$ignored
	);
	$index = 0;

	return preg_replace_callback(
		'#<iframe\b[^>]*\bsrc=(["\'])https?://(?:www\.)?youtube(?:-nocookie)?\.com/embed/([A-Za-z0-9_-]{6,})[^"\']*\1[^>]*>\s*</iframe>#i',
		static function ( $m ) use ( $title, $total, &$index ) {
			$index++;
			$vid = $m[2];

			// Accessible name. The INDEX RULE mirrors the VideoObject `name` at
			// ea-w2-seo-schema.php L275-278 (append " — N" only when >1) so the two
			// stay in lockstep. The "נגן וידאו:" prefix is DELIBERATE and has no
			// counterpart in VideoObject.name: this is a <button>, so its accessible
			// name must state the ACTION (WCAG 2.4.6 / 4.1.2), not just the title.
			// Do not "align" them by dropping the prefix.
			$label = $total > 1
				? sprintf( 'נגן וידאו: %s — %d', $title, $index )
				: sprintf( 'נגן וידאו: %s', $title );

			return sprintf(
				'<button type="button" class="ea-qr-facade" data-ea-qr-video="%1$s" aria-label="%2$s">' .
					'<img class="ea-qr-facade__thumb" src="https://i.ytimg.com/vi/%1$s/hqdefault.jpg" alt="" ' .
						'width="480" height="360" loading="lazy" decoding="async">' .
					'<span class="ea-qr-facade__play" aria-hidden="true"></span>' .
				'</button>',
				esc_attr( $vid ),
				esc_attr( $label )
			);
		},
		$content
	);
}
add_filter( 'the_content', 'ea_chapters_qr_facade_content', 20 );

/**
 * Facade runtime — QR views only. CSS ships inside chapters.css (already loaded
 * here, and it already owns .ea-qr-embed--video) so this adds no extra request.
 */
function ea_chapters_qr_facade_assets() {
	if ( is_admin() || ! ea_chapters_qr_facade_is_view() ) {
		return;
	}
	wp_enqueue_script(
		'ea-qr-facade',
		get_stylesheet_directory_uri() . '/assets/js/ea-qr-facade.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_chapters_qr_facade_assets', 30 );
