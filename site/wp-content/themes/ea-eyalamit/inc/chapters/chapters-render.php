<?php
/**
 * Chapters (פרקים) — render accessors.
 *
 * The contract: section partials NEVER call get_field() directly. They call
 * these accessors, which return the ACF value when present and a seeded default
 * otherwise. This means the page renders the full design even when ACF is
 * inactive (or a field is empty) — it can never white-screen or render blank.
 *
 * Mirrors the data-or-default pattern already used by template-parts/blocks/block-hero.php.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Template path that carries the Chapters home field group + render.
 *
 * @return string
 */
function ea_chapters_home_template() {
	return 'page-templates/tpl-chapters-home.php';
}

/**
 * Is the Chapters front page active? Filterable so it can be flipped off for an
 * instant rollback to the legacy tpl-home (define EA_CHAPTERS_FRONT false, or
 * add_filter 'ea_chapters_front_enabled' '__return_false').
 *
 * @return bool
 */
function ea_chapters_front_enabled() {
	$default = defined( 'EA_CHAPTERS_FRONT' ) ? (bool) EA_CHAPTERS_FRONT : true;
	return (bool) apply_filters( 'ea_chapters_front_enabled', $default );
}

/**
 * True on any view rendered by the Chapters system (front page when enabled, or
 * any page assigned the Chapters template).
 *
 * @return bool
 */
function ea_chapters_is_view() {
	if ( is_page_template( ea_chapters_home_template() ) ) {
		return true;
	}
	if ( is_front_page() && is_page() && ea_chapters_front_enabled() ) {
		return true;
	}
	return false;
}

/**
 * Load the seeded defaults for the current Chapters page type.
 * Cached per request. Home is the only type in this round.
 *
 * @return array
 */
function ea_chapters_defaults() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$file  = get_stylesheet_directory() . '/inc/chapters/defaults/home-defaults.php';
	$cache = is_readable( $file ) ? (array) require $file : array();
	return $cache;
}

/**
 * Scalar / array field accessor: ACF value when non-empty, else seeded default.
 *
 * @param string   $name    Field name.
 * @param int|null $post_id Optional post id.
 * @return mixed
 */
function ea_chapters_field( $name, $post_id = null ) {
	if ( function_exists( 'get_field' ) ) {
		$val = get_field( $name, $post_id );
		if ( null !== $val && '' !== $val && false !== $val && array() !== $val ) {
			return $val;
		}
	}
	$d = ea_chapters_defaults();
	return isset( $d[ $name ] ) ? $d[ $name ] : '';
}

/**
 * Repeater accessor: ACF rows when present, else seeded default array of rows.
 *
 * @param string   $name    Repeater field name.
 * @param int|null $post_id Optional post id.
 * @return array[]
 */
function ea_chapters_rows( $name, $post_id = null ) {
	if ( function_exists( 'get_field' ) ) {
		$rows = get_field( $name, $post_id );
		if ( is_array( $rows ) && ! empty( $rows ) ) {
			return $rows;
		}
	}
	$d = ea_chapters_defaults();
	return ( isset( $d[ $name ] ) && is_array( $d[ $name ] ) ) ? $d[ $name ] : array();
}

/**
 * Resolve an image field to a URL. Accepts an ACF attachment id / array / url,
 * else falls back to a seeded default (theme-relative path or absolute url).
 *
 * @param string $name    Field name.
 * @param string $size    Image size for attachment ids.
 * @return string URL ('' if none).
 */
function ea_chapters_img( $name, $size = 'large' ) {
	$val = function_exists( 'get_field' ) ? get_field( $name ) : null;
	if ( is_array( $val ) && ! empty( $val['url'] ) ) {
		return (string) $val['url'];
	}
	if ( is_numeric( $val ) && (int) $val > 0 ) {
		$url = wp_get_attachment_image_url( (int) $val, $size );
		if ( $url ) {
			return $url;
		}
	}
	if ( is_string( $val ) && '' !== $val ) {
		return $val;
	}
	$d   = ea_chapters_defaults();
	$def = isset( $d[ $name ] ) ? (string) $d[ $name ] : '';
	return ea_chapters_asset_url( $def );
}

/**
 * Turn a seeded default image value into a URL: absolute urls pass through;
 * theme-relative paths ('assets/...') resolve against the stylesheet dir.
 *
 * @param string $value
 * @return string
 */
function ea_chapters_asset_url( $value ) {
	$value = (string) $value;
	if ( '' === $value ) {
		return '';
	}
	if ( preg_match( '#^(https?:)?//#', $value ) || 0 === strpos( $value, 'data:' ) ) {
		return $value;
	}
	return get_stylesheet_directory_uri() . '/' . ltrim( $value, '/' );
}

/**
 * Resolve a raw image value (ACF attachment id / array / url, or a seeded
 * theme-relative path) from a repeater row to a URL.
 *
 * @param mixed  $value
 * @param string $size
 * @return string URL ('' if none).
 */
function ea_chapters_resolve_img( $value, $size = 'large' ) {
	if ( is_array( $value ) && ! empty( $value['url'] ) ) {
		return (string) $value['url'];
	}
	if ( is_numeric( $value ) && (int) $value > 0 ) {
		$url = wp_get_attachment_image_url( (int) $value, $size );
		if ( $url ) {
			return $url;
		}
	}
	if ( is_string( $value ) && '' !== $value ) {
		return ea_chapters_asset_url( $value );
	}
	return '';
}

/**
 * Limited-HTML echo helper for hero/quote strings that allow <em>/<br>/<strong>.
 *
 * @param string $html
 * @return void
 */
function ea_chapters_kses_e( $html ) {
	echo wp_kses(
		(string) $html,
		array(
			'em'     => array(),
			'br'     => array(),
			'strong' => array(),
			'span'   => array( 'class' => array() ),
		)
	);
}
