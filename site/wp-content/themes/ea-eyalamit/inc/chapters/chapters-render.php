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
 * Slug → Chapters template + content-type map for inner pages. The front page is
 * handled separately. Filterable so the set can grow without touching the router.
 *
 * @return array<string,array{template:string,type:string}>
 */
function ea_chapters_route_map() {
	return (array) apply_filters( 'ea_chapters_route_map', array(
		'method'        => array( 'template' => 'tpl-chapters-method', 'type' => 'method' ),
		'treatment'     => array( 'template' => 'tpl-chapters-page',   'type' => 'treatment' ),
		'sound-healing' => array( 'template' => 'tpl-chapters-page',   'type' => 'sound-healing' ),
		'lessons'       => array( 'template' => 'tpl-chapters-page',   'type' => 'lessons' ),
		'eyal-amit'     => array( 'template' => 'tpl-chapters-page',   'type' => 'about' ),
		'faq'           => array( 'template' => 'tpl-chapters-page',   'type' => 'faq' ),
		'didgeridoos'   => array( 'template' => 'tpl-chapters-page',   'type' => 'didgeridoos' ),
		'bags'          => array( 'template' => 'tpl-chapters-page',   'type' => 'bags' ),
		'stands-storage' => array( 'template' => 'tpl-chapters-page',  'type' => 'stands-storage' ),
		'stand-floor'   => array( 'template' => 'tpl-chapters-page',   'type' => 'stand-floor' ),
		'repair'        => array( 'template' => 'tpl-chapters-page',   'type' => 'repair' ),
		'books'         => array( 'template' => 'tpl-chapters-page',   'type' => 'muzza' ),
		'vekatavta'     => array( 'template' => 'tpl-chapters-page',   'type' => 'vekatavta' ),
		'kushi-blantis' => array( 'template' => 'tpl-chapters-page',   'type' => 'kushi-blantis' ),
		'tsva-bekahol'  => array( 'template' => 'tpl-chapters-page',   'type' => 'tsva-bekahol' ),
		'mokesh-dahiman' => array( 'template' => 'tpl-chapters-page',  'type' => 'mokesh' ),
		'contact'       => array( 'template' => 'tpl-chapters-page',   'type' => 'contact' ),
	) );
}

/**
 * Is the Chapters redesign active? One flag for the whole system; filter/redefine
 * EA_CHAPTERS_FRONT false for an instant rollback to the legacy templates.
 *
 * @return bool
 */
function ea_chapters_enabled() {
	$default = defined( 'EA_CHAPTERS_FRONT' ) ? (bool) EA_CHAPTERS_FRONT : true;
	return (bool) apply_filters( 'ea_chapters_front_enabled', $default );
}

/** Back-compat alias. */
function ea_chapters_front_enabled() {
	return ea_chapters_enabled();
}

/**
 * Current page slug (empty when not a page).
 *
 * @return string
 */
function ea_chapters_current_slug() {
	if ( ! is_page() ) {
		return '';
	}
	return (string) get_post_field( 'post_name', get_queried_object_id() );
}

/**
 * True on any view the Chapters system renders (front page, or a mapped inner slug).
 *
 * @return bool
 */
function ea_chapters_is_view() {
	if ( ! ea_chapters_enabled() ) {
		return false;
	}
	if ( is_front_page() && is_page() ) {
		return true;
	}
	return isset( ea_chapters_route_map()[ ea_chapters_current_slug() ] );
}

/**
 * Content type for the current Chapters view ('home' | 'method' | 'treatment' |
 * 'sound-healing' | 'lessons' | 'about'). Drives which defaults file loads.
 * A template may override via $GLOBALS['ea_chapters_type'].
 *
 * @return string
 */
function ea_chapters_type() {
	if ( isset( $GLOBALS['ea_chapters_type'] ) && '' !== $GLOBALS['ea_chapters_type'] ) {
		return (string) $GLOBALS['ea_chapters_type'];
	}
	if ( is_front_page() && is_page() ) {
		return 'home';
	}
	$map = ea_chapters_route_map();
	$slug = ea_chapters_current_slug();
	return isset( $map[ $slug ] ) ? $map[ $slug ]['type'] : 'home';
}

/**
 * Load the seeded defaults for the current Chapters page type (cached per type).
 *
 * @return array
 */
function ea_chapters_defaults() {
	static $cache = array();
	$type = ea_chapters_type();
	if ( isset( $cache[ $type ] ) ) {
		return $cache[ $type ];
	}
	$file           = get_stylesheet_directory() . '/inc/chapters/defaults/' . $type . '-defaults.php';
	$cache[ $type ] = is_readable( $file ) ? (array) require $file : array();
	return $cache[ $type ];
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
	// 1) ACF Pro repeater (if ever present) — use rows directly.
	if ( function_exists( 'have_rows' ) && have_rows( $name, $post_id ) ) {
		$rows = get_field( $name, $post_id );
		if ( is_array( $rows ) && ! empty( $rows ) ) {
			return $rows;
		}
	}
	// 2) Free-ACF fixed slots — assemble rows from {name}_{i}_{sub} fields.
	$assembled = ea_chapters_assemble_rows( $name, $post_id );
	if ( ! empty( $assembled ) ) {
		return $assembled;
	}
	// 3) Seeded defaults.
	$d = ea_chapters_defaults();
	return ( isset( $d[ $name ] ) && is_array( $d[ $name ] ) ) ? $d[ $name ] : array();
}

/**
 * Fixed-slot specs: repeater name → max slots + ordered sub-field names.
 * Single source for both the ACF field registration and the assembler, so the
 * design's fixed-count sections work on FREE ACF (no Pro Repeater needed).
 *
 * @return array<string,array{count:int,subs:string[]}>
 */
function ea_chapters_repeater_specs() {
	return array(
		'about_timeline' => array( 'count' => 4, 'subs' => array( 'year', 'text' ) ),
		'whom_items'     => array( 'count' => 4, 'subs' => array( 'image', 'text' ) ),
		'session_cards'  => array( 'count' => 4, 'subs' => array( 'image', 'title', 'text', 'reveal' ) ),
		'testi_items'    => array( 'count' => 4, 'subs' => array( 'text', 'name', 'initial', 'avatar' ) ),
		'start_steps'    => array( 'count' => 3, 'subs' => array( 'title', 'text' ) ),
	);
}

/**
 * Assemble repeater-shaped rows from flat fixed-slot ACF fields. A slot is
 * included only if at least one of its sub-fields has a value.
 *
 * @param string   $name
 * @param int|null $post_id
 * @return array[]
 */
function ea_chapters_assemble_rows( $name, $post_id = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return array();
	}
	$specs = ea_chapters_repeater_specs();
	if ( ! isset( $specs[ $name ] ) ) {
		return array();
	}
	$rows = array();
	for ( $i = 1; $i <= $specs[ $name ]['count']; $i++ ) {
		$row = array();
		$has = false;
		foreach ( $specs[ $name ]['subs'] as $sub ) {
			$val = get_field( $name . '_' . $i . '_' . $sub, $post_id );
			if ( null !== $val && '' !== $val && false !== $val ) {
				$row[ $sub ] = $val;
				$has         = true;
			} else {
				$row[ $sub ] = '';
			}
		}
		if ( $has ) {
			$rows[] = $row;
		}
	}
	return $rows;
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
 * Curated testimonials for the marquee, optionally by category, with the retired
 * brand «סטודיו נשימה מעגלית» excluded (not edited). Returns [{text,name}].
 *
 * @param string $cat Optional FB-corpus category slug.
 * @return array<int,array{text:string,name:string}>
 */
function ea_chapters_testimonials( $cat = '' ) {
	$brand = 'סטודיו נשימה מעגלית';
	$src   = array();
	if ( '' !== $cat && function_exists( 'ea_fb_testimonials_by_cat' ) ) {
		$src = ea_fb_testimonials_by_cat( $cat );
	}
	if ( empty( $src ) && function_exists( 'ea_fb_testimonials_all' ) ) {
		$src = ea_fb_testimonials_all();
	}
	$out = array();
	foreach ( (array) $src as $t ) {
		$blob = ( $t['name'] ?? '' ) . ' ' . ( $t['snippet'] ?? '' ) . ' ' . ( $t['full'] ?? '' ) . ' ' . ( $t['text'] ?? '' );
		if ( false !== mb_strpos( $blob, $brand ) ) {
			continue;
		}
		$txt = trim( (string) ( $t['snippet'] ?? ( $t['text'] ?? '' ) ) );
		if ( '' === $txt ) {
			continue;
		}
		$out[] = array( 'text' => $txt, 'name' => (string) ( $t['name'] ?? '' ) );
	}
	return $out;
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
