<?php
/**
 * EA — Facebook testimonials corpus (D-TESTIMONIALS, team_110 2026-06-21).
 *
 * 48 testimonials (17 treatment · 9 sound-healing · 22 lessons), each with the
 * commenter's name, the original FB post link, a PROVISIONAL carousel snippet
 * (pending Eyal review via the hub) and the full FB post. Data lives in
 * inc/data/ea-testimonials-fb.json (avoids PHP-escaping Hebrew quotes).
 *
 * Wiring: per-category snippets are appended (after service-specific, deduped) to
 * the service carousels (inc/wave2-w2-04.php); a broad set feeds the home rotator
 * (inc/wave2-stage-b.php); the FULL set renders on /media (inc/wave2-w2-14e.php).
 * Full 48 + the provisional selection are recorded as Eyal-review options in the
 * hub (hub/data/testimonials-curation.json + materials-needed.json I1).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * All 48 FB testimonials (static-cached). Each: cat, name, href, snippet, full.
 *
 * @return array<int,array<string,string>>
 */
function ea_fb_testimonials_all() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$cache = array();
	$path  = get_stylesheet_directory() . '/inc/data/ea-testimonials-fb.json';
	if ( is_readable( $path ) ) {
		$raw = json_decode( (string) file_get_contents( $path ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( is_array( $raw ) && ! empty( $raw['items'] ) && is_array( $raw['items'] ) ) {
			$cache = $raw['items'];
		}
	}
	return $cache;
}

/**
 * Map a service slug to a testimonials category.
 *
 * @param string $slug
 * @return string category key, or '' if none.
 */
function ea_fb_testimonials_cat_for_slug( $slug ) {
	switch ( $slug ) {
		case 'treatment':
		case 'method':
			return 'treatment';
		case 'sound-healing':
			return 'sound-healing';
		case 'lessons':
			return 'lessons';
		default:
			return '';
	}
}

/**
 * Per-category testimonials shaped for the carousel/row blocks (snippet as text).
 *
 * @param string $slug Service slug (treatment|method|sound-healing|lessons).
 * @return array<int,array{name:string,text:string,href:string}>
 */
function ea_fb_testimonials_by_cat( $slug ) {
	$cat = ea_fb_testimonials_cat_for_slug( $slug );
	if ( '' === $cat ) {
		return array();
	}
	$out = array();
	foreach ( ea_fb_testimonials_all() as $t ) {
		if ( ( $t['cat'] ?? '' ) !== $cat ) {
			continue;
		}
		$out[] = array(
			'name' => (string) ( $t['name'] ?? '' ),
			'text' => (string) ( $t['snippet'] ?? '' ),
			'href' => (string) ( $t['href'] ?? '' ),
		);
	}
	return $out;
}

/**
 * Broad cross-category set for the home rotator (snippet as text), up to
 * $per_cat per category, in document order. Provisional — Eyal curates in the hub.
 *
 * @param int $per_cat
 * @return array<int,array{name:string,text:string,href:string}>
 */
function ea_fb_testimonials_home( $per_cat = 4 ) {
	$counts = array();
	$out    = array();
	foreach ( ea_fb_testimonials_all() as $t ) {
		$cat = (string) ( $t['cat'] ?? '' );
		$n   = isset( $counts[ $cat ] ) ? $counts[ $cat ] : 0;
		if ( $n >= $per_cat ) {
			continue;
		}
		$counts[ $cat ] = $n + 1;
		$out[]          = array(
			'name' => (string) ( $t['name'] ?? '' ),
			'text' => (string) ( $t['snippet'] ?? '' ),
			'href' => (string) ( $t['href'] ?? '' ),
		);
	}
	return $out;
}
