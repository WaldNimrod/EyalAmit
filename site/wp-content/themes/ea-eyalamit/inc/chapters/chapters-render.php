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
		'snoring-sleep-apnea' => array( 'template' => 'tpl-chapters-page', 'type' => 'snoring-sleep-apnea' ),
		'sound-healing' => array( 'template' => 'tpl-chapters-page',   'type' => 'sound-healing' ),
		'lessons'       => array( 'template' => 'tpl-chapters-page',   'type' => 'lessons' ),
		'eyal-amit'     => array( 'template' => 'tpl-chapters-page',   'type' => 'about' ),
		'faq'           => array( 'template' => 'tpl-chapters-page',   'type' => 'faq' ),
		'didgeridoos'   => array( 'template' => 'tpl-chapters-page',   'type' => 'didgeridoos' ),
		'bags'          => array( 'template' => 'tpl-chapters-page',   'type' => 'bags' ),
		'stands-storage' => array( 'template' => 'tpl-chapters-page',  'type' => 'stands-storage' ),
		'stand-floor'   => array( 'template' => 'tpl-chapters-page',   'type' => 'stand-floor' ),
		'repair'        => array( 'template' => 'tpl-chapters-page',   'type' => 'repair' ),
		'shop'          => array( 'template' => 'tpl-chapters-page',   'type' => 'shop' ),
		'books'         => array( 'template' => 'tpl-chapters-page',   'type' => 'muzza' ),
		'qr'            => array( 'template' => 'tpl-chapters-page',   'type' => 'qr-hub' ),
		'vekatavta'     => array( 'template' => 'tpl-chapters-page',   'type' => 'vekatavta' ),
		'kushi-blantis' => array( 'template' => 'tpl-chapters-page',   'type' => 'kushi-blantis' ),
		'tsva-bekahol'  => array( 'template' => 'tpl-chapters-page',   'type' => 'tsva-bekahol' ),
		'mokesh-dahiman' => array( 'template' => 'tpl-chapters-mokesh', 'type' => 'mokesh' ),
		'contact'       => array( 'template' => 'tpl-chapters-page',   'type' => 'contact' ),
		'galleries'     => array( 'template' => 'tpl-chapters-page',   'type' => 'galleries' ),
		'media'         => array( 'template' => 'tpl-chapters-page',   'type' => 'media' ),
		'privacy'       => array( 'template' => 'tpl-chapters-page',   'type' => 'privacy' ),
		'accessibility' => array( 'template' => 'tpl-chapters-page',   'type' => 'accessibility' ),
		'terms'         => array( 'template' => 'tpl-chapters-page',   'type' => 'terms' ),
		'en'            => array( 'template' => 'tpl-chapters-en',     'type' => 'en' ),
		'learning'          => array( 'template' => 'tpl-chapters-page', 'type' => 'learning' ),
		'therapist-training' => array( 'template' => 'tpl-chapters-page', 'type' => 'therapist-training' ),
		'lectures'          => array( 'template' => 'tpl-chapters-page', 'type' => 'lectures' ),
		'workshops'         => array( 'template' => 'tpl-chapters-page', 'type' => 'workshops' ),
	) );
}

/**
 * Parent-slug → template+type for hierarchical child pages (e.g. /qr/qrN/).
 * Each child carries real post_content; not sections-based defaults.
 *
 * @return array<string,array{template:string,type:string}>
 */
function ea_chapters_pattern_routes() {
	return (array) apply_filters( 'ea_chapters_pattern_routes', array(
		'qr' => array( 'template' => 'tpl-chapters-qr', 'type' => 'qr' ),
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
	if ( isset( ea_chapters_route_map()[ ea_chapters_current_slug() ] ) ) {
		return true;
	}
	// Pattern-route match (parent + child), e.g. /qr/qrN/.
	if ( is_page() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post && $post->post_parent ) {
			$parent_slug = get_post_field( 'post_name', (int) $post->post_parent );
			if ( isset( ea_chapters_pattern_routes()[ $parent_slug ] ) ) {
				return true;
			}
		}
	}
	return false;
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
 * Load seeded defaults for an EXPLICIT type, unlike ea_chapters_defaults() (which
 * reads the current page's type). Used by the section-list spec builder and the
 * WP-S4-05 field registrar (acf-fields-inner.php), both of which must loop over
 * every path-B page type during acf/init regardless of which page is rendering.
 * Deliberately kept separate from ea_chapters_defaults() (own static cache) rather
 * than refactoring it, so the existing, heavily-relied-on function is untouched.
 *
 * @param string $type
 * @return array
 */
function ea_chapters_defaults_for( $type ) {
	static $cache = array();
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
 * Type-aware (WP-S4-05): 'whom_items'/'testi_items' etc. have a DIFFERENT shape on
 * home vs. method (verified — home whom_items={image,text}×4, method
 * whom_items={image,title,more}×6; home testi_items={text,name,initial,avatar}×4,
 * method testi_items={name,text}×12), so a single global spec would corrupt one of
 * them. Called with no arg (existing call sites), it resolves the CURRENT page's
 * type, so home/method behavior is 100% unchanged. Path-B (sections-array) list
 * specs are merged in from ea_chapters_section_specs() (derived from the same
 * per-page defaults + the shared ea_chapters_part_field_map(), so there is no
 * separate schema to drift out of sync).
 *
 * @param string|null $type Optional explicit type; defaults to the current page's type.
 * @return array<string,array{count:int,subs:string[]}>
 */
function ea_chapters_repeater_specs( $type = null ) {
	$type = ( null !== $type ) ? $type : ea_chapters_type();
	$base = array( // home (back-compat — unchanged default).
		'about_timeline' => array( 'count' => 4, 'subs' => array( 'year', 'text' ) ),
		'whom_items'     => array( 'count' => 4, 'subs' => array( 'image', 'text' ) ),
		'session_cards'  => array( 'count' => 4, 'subs' => array( 'image', 'title', 'text', 'reveal' ) ),
		'testi_items'    => array( 'count' => 4, 'subs' => array( 'text', 'name', 'initial', 'avatar' ) ),
		'start_steps'    => array( 'count' => 3, 'subs' => array( 'title', 'text' ) ),
	);
	$by_type = array(
		'method' => array(
			'mag_items'   => array( 'count' => 6, 'subs' => array( 'title', 'text' ) ),
			'whom_items'  => array( 'count' => 6, 'subs' => array( 'image', 'title', 'more' ) ),
			'testi_items' => array( 'count' => 12, 'subs' => array( 'name', 'text' ) ),
		),
	);
	// Section repeaters for path-B types are merged in from ea_chapters_section_specs($type).
	$specs = ( 'home' === $type ) ? $base : ( isset( $by_type[ $type ] ) ? $by_type[ $type ] : array() );
	return array_merge( $specs, ea_chapters_section_specs( $type ) );
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
 * Editable-arg whitelist per section 'part' type (WP-S4-05 §3 SSOT). Anything NOT
 * listed here is structural/locked — it is never registered as an ACF field and
 * never touched by the overlay; it passes through from the seeded default args
 * untouched (e.g. part/figr/reversed/id/alt(bool)/center/dark/collapsible/active/
 * cats/slug/cta_slug/yt_id/pending/pending_label).
 *
 * Consumed by BOTH the field registrar (acf-fields-inner.php) and the overlay
 * (ea_chapters_page_sections() below) — a single exported function, never copied,
 * so registration and render can never drift apart.
 *
 * 'img' => image field (return_format=id); 'file' => file (mp4); 'wys' => wysiwyg;
 * 'txt'/'ta' => text/textarea. 'list' => the item sub-map for section['args']['items'].
 *
 * @return array<string,array{scalars?:array<string,string>,list?:array<string,string>}>
 */
function ea_chapters_part_field_map() {
	return array(
		'phero'        => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'ta', 'sub' => 'ta', 'media' => 'img', 'media_alt' => 'txt', 'cta_label' => 'txt', 'cta_url' => 'txt' ) ),
		'prose'        => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt', 'body' => 'wys', 'toggle_label' => 'txt' ) ),
		'split'        => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt', 'body' => 'wys', 'image' => 'img', 'alt' => 'txt' ) ),
		'lead'         => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt', 'lead' => 'ta' ) ),
		'bleed'        => array( 'scalars' => array( 'image' => 'img', 'alt' => 'txt', 'quote' => 'ta', 'attrib' => 'txt' ) ),
		'cta'          => array( 'scalars' => array( 'title' => 'ta', 'body' => 'ta', 'cta_label' => 'txt', 'cta_url' => 'txt', 'cta2_label' => 'txt', 'cta2_url' => 'txt' ) ),
		'videoblk'     => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt', 'body' => 'wys', 'poster' => 'img', 'video' => 'file', 'cap' => 'txt', 'alt' => 'txt' ) ),
		'mag'          => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt', 'image' => 'img', 'alt' => 'txt', 'cap_b' => 'txt', 'cap_sub' => 'txt' ), 'list' => array( 'title' => 'txt', 'text' => 'ta' ) ),
		'steps'        => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt', 'lead' => 'ta' ), 'list' => array( 'title' => 'txt', 'text' => 'ta' ) ),
		'reveals'      => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt', 'lead' => 'ta' ), 'list' => array( 'image' => 'img', 'title' => 'txt', 'more' => 'ta' ) ),
		'dd'           => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt', 'lead' => 'ta' ), 'list' => array( 'tag' => 'txt', 'title' => 'txt', 'body' => 'wys' ) ),
		'testimonials' => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt' ), 'list' => array( 'name' => 'txt', 'text' => 'ta' ) ),
		'timeline'     => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt' ), 'list' => array( 'year' => 'txt', 'text' => 'ta' ) ),
		'gallery'      => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt', 'lead' => 'ta' ), 'list' => array( 'image' => 'img', 'alt' => 'txt', 'cap' => 'txt' ) ),
		'bookcard'     => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt' ), 'list' => array( 'cover' => 'img', 'meta' => 'txt', 'title' => 'txt', 'blurb' => 'ta', 'url' => 'txt' ) ),
		'product-cta'  => array( 'scalars' => array( 'title' => 'txt', 'body' => 'ta', 'contact_label' => 'txt', 'price_note' => 'txt' ) ), // price via meta-box, not ACF.
		'faqblock'     => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt' ) ), // items = CPT ea_faq (locked).
		'fbembeds'     => array( 'scalars' => array( 'chap' => 'txt', 'title' => 'txt' ) ), // hrefs locked.
		'contact'      => array( 'scalars' => array() ),
	);
}

/**
 * List-slot headroom: registered/fetched slots = default item count + headroom
 * (so an editor can add new items beyond the seeded set, per AC-LIST).
 *
 * @param string $part
 * @return int
 */
function ea_chapters_list_headroom( $part ) {
	return ( 'testimonials' === $part ) ? 4 : 2;
}

/**
 * Path-B (sections-array) list-repeater specs for one page type, derived from that
 * type's OWN seeded defaults + ea_chapters_part_field_map() — never hand-maintained,
 * so it can never drift from what acf-fields-inner.php registers. Registry key
 * matches the naming contract's "list repeater name": {type}_s{N}.
 *
 * @param string $type
 * @return array<string,array{count:int,subs:array<string,string>}>
 */
function ea_chapters_section_specs( $type ) {
	static $cache = array();
	if ( isset( $cache[ $type ] ) ) {
		return $cache[ $type ];
	}
	$out  = array();
	$d    = ea_chapters_defaults_for( $type );
	$secs = ( isset( $d['sections'] ) && is_array( $d['sections'] ) ) ? $d['sections'] : array();
	$map  = ea_chapters_part_field_map();
	foreach ( $secs as $n => $sec ) {
		$part = isset( $sec['part'] ) ? $sec['part'] : '';
		if ( ! isset( $map[ $part ]['list'] ) ) {
			continue;
		}
		$items                    = ( isset( $sec['args']['items'] ) && is_array( $sec['args']['items'] ) ) ? $sec['args']['items'] : array();
		$count                    = count( $items ) + ea_chapters_list_headroom( $part );
		$out[ $type . '_s' . $n ] = array(
			'count' => max( 1, $count ),
			'subs'  => $map[ $part ]['list'],
		);
	}
	$cache[ $type ] = $out;
	return $out;
}

/**
 * Scalar accessor variant for path-B overlay use: returns the ACF value when
 * non-empty, else the EXPLICIT $default passed in (not a defaults()-array lookup —
 * section-scoped field names like 's3_body' are not top-level defaults() keys, so
 * the caller must supply the real seeded value itself).
 *
 * @param string   $name
 * @param mixed    $default
 * @param int|null $post_id
 * @return mixed
 */
function ea_chapters_field_or( $name, $default, $post_id = null ) {
	if ( function_exists( 'get_field' ) ) {
		$val = get_field( $name, $post_id );
		if ( null !== $val && '' !== $val && false !== $val && array() !== $val ) {
			return $val;
		}
	}
	return $default;
}

/**
 * Per-slot ACF fetch for one path-B section list, field names 's{N}_i{K}_{sub}'
 * (naming contract §2.1). Deliberately NOT ea_chapters_assemble_rows(): that
 * assembler (a) compacts/reindexes — it drops any untouched slot and shifts later
 * slots down, which would misalign a mid-list edit (e.g. editing only slot 2's
 * 'more' field) against the seeded defaults array in ea_chapters_merge_list_rows(),
 * silently corrupting a sibling slot — and (b) builds field names as
 * '{name}_{i}_{sub}' (no 'i' marker), which does not match the 's{N}_i{K}_{sub}'
 * contract that acf-fields-inner.php actually registers. This fetch instead always
 * returns exactly $count rows, one per slot in order (blank subs as ''), so the
 * merge can align by true slot number.
 *
 * @param int                  $n       Section index N.
 * @param int                  $count   Slot count (from ea_chapters_section_specs()).
 * @param array<string,string> $sub_map sub => kind.
 * @param int|null             $post_id
 * @return array[] One row per slot 1..count, in order; [] when ACF is unavailable.
 */
function ea_chapters_section_list_fetch( $n, $count, $sub_map, $post_id = null ) {
	if ( ! function_exists( 'get_field' ) || $count <= 0 ) {
		return array();
	}
	$rows = array();
	for ( $k = 1; $k <= $count; $k++ ) {
		$row = array();
		foreach ( $sub_map as $sub => $kind ) {
			$val         = get_field( 's' . $n . '_i' . $k . '_' . $sub, $post_id );
			$row[ $sub ] = ( null !== $val && false !== $val ) ? $val : '';
		}
		$rows[] = $row;
	}
	return $rows;
}

/**
 * Merge fetched ACF slot-rows onto the seeded default items array, per slot index.
 * A slot's sub-field falls back to that SAME slot's default value when empty, so a
 * partial edit never blanks an untouched sibling field or sibling slot; any extra
 * keys already on the default row (locked structural flags like pending/
 * pending_label/active) pass through untouched, since each output row starts as a
 * copy of the matching default row. Slots beyond the default count (headroom)
 * become new rows only once they actually have content (AC-LIST). If nothing
 * anywhere in the list was touched, the original $defaults array is returned
 * unchanged (AC-FALLBACK / AC-NOACF identity).
 *
 * @param array[]               $rows     Per-slot ACF rows (index 0 = slot 1), from ea_chapters_section_list_fetch().
 * @param array[]               $defaults Seeded default items.
 * @param array<string,string>  $sub_map  sub-field => kind ('img'|'file'|'txt'|'ta'|'wys').
 * @return array[]
 */
function ea_chapters_merge_list_rows( $rows, $defaults, $sub_map ) {
	if ( empty( $rows ) ) {
		return $defaults;
	}
	$out         = array();
	$count       = max( count( $rows ), count( $defaults ) );
	$any_touched = false;
	for ( $i = 0; $i < $count; $i++ ) {
		$def = ( isset( $defaults[ $i ] ) && is_array( $defaults[ $i ] ) ) ? $defaults[ $i ] : array();
		$acf = ( isset( $rows[ $i ] ) && is_array( $rows[ $i ] ) ) ? $rows[ $i ] : array();
		$row = $def; // Start from the default so locked/extra keys pass through untouched.
		foreach ( $sub_map as $sub => $kind ) {
			$val = isset( $acf[ $sub ] ) ? $acf[ $sub ] : '';
			if ( null === $val || '' === $val || false === $val ) {
				continue; // Empty → keep the default's value for this sub (already in $row).
			}
			$any_touched = true;
			$row[ $sub ] = ( 'img' === $kind || 'file' === $kind ) ? ea_chapters_resolve_img( $val ) : $val;
		}
		if ( ! empty( $row ) ) {
			$out[] = $row;
		}
	}
	return $any_touched ? $out : $defaults;
}

/**
 * Overlay ACF phero_{arg} scalar fields onto the seeded $d['phero'] array (flat
 * naming, aligned with method's existing phero_* convention — phero is a top-level
 * key, not part of the sections[] index space). Safe no-op (returns the seeded
 * phero array untouched) when ACF is absent or the page type has no 'phero'.
 *
 * @return array
 */
function ea_chapters_phero_overlay() {
	$d     = ea_chapters_defaults();
	$phero = ( isset( $d['phero'] ) && is_array( $d['phero'] ) ) ? $d['phero'] : array();
	$map   = ea_chapters_part_field_map();
	if ( empty( $phero ) || ! isset( $map['phero']['scalars'] ) ) {
		return $phero;
	}
	foreach ( $map['phero']['scalars'] as $arg => $kind ) {
		if ( ! array_key_exists( $arg, $phero ) ) {
			continue; // Only overlay args this page's phero actually defines.
		}
		$name = 'phero_' . $arg;
		if ( 'img' === $kind || 'file' === $kind ) {
			$phero[ $arg ] = ea_chapters_resolve_img( ea_chapters_field_or( $name, $phero[ $arg ] ) );
		} else {
			$phero[ $arg ] = ea_chapters_field_or( $name, $phero[ $arg ] );
		}
	}
	return $phero;
}

/**
 * The path-B (sections-array) overlay: ACF value OR seeded default, by section
 * index — the core of WP-S4-05. Scalars resolve via ea_chapters_field_or() (image/
 * file args additionally through ea_chapters_resolve_img()); list items merge via
 * ea_chapters_merge_list_rows(). Structural args (anything not in
 * ea_chapters_part_field_map()'s scalars for that part) pass through from the
 * default untouched. When ACF is inactive/absent, EVERY field call is a guarded
 * no-op and this returns the exact seeded $d['sections'] content (AC-NOACF).
 *
 * @return array[] sections ready for the foreach in tpl-chapters-page.php / tpl-chapters-mokesh.php.
 */
function ea_chapters_page_sections() {
	$d    = ea_chapters_defaults();
	$type = ea_chapters_type();
	$out  = array();
	$secs = ( isset( $d['sections'] ) && is_array( $d['sections'] ) ) ? $d['sections'] : array();
	$map  = ea_chapters_part_field_map();
	$spec = ea_chapters_section_specs( $type );
	foreach ( $secs as $n => $sec ) {
		$part = isset( $sec['part'] ) ? (string) $sec['part'] : '';
		$args = ( isset( $sec['args'] ) && is_array( $sec['args'] ) ) ? $sec['args'] : array();
		if ( isset( $map[ $part ]['scalars'] ) ) {
			foreach ( $map[ $part ]['scalars'] as $arg => $kind ) {
				if ( ! array_key_exists( $arg, $args ) ) {
					continue; // Only editable args present in this section's defaults.
				}
				$name = 's' . $n . '_' . $arg;
				if ( 'img' === $kind || 'file' === $kind ) {
					$args[ $arg ] = ea_chapters_resolve_img( ea_chapters_field_or( $name, $args[ $arg ] ) );
				} else {
					$args[ $arg ] = ea_chapters_field_or( $name, $args[ $arg ] );
				}
			}
		}
		if ( isset( $map[ $part ]['list'] ) ) {
			$key  = $type . '_s' . $n;
			$cnt  = isset( $spec[ $key ] ) ? (int) $spec[ $key ]['count'] : 0;
			$rows = ea_chapters_section_list_fetch( $n, $cnt, $map[ $part ]['list'] );
			if ( ! empty( $rows ) ) {
				$default_items = ( isset( $args['items'] ) && is_array( $args['items'] ) ) ? $args['items'] : array();
				$args['items'] = ea_chapters_merge_list_rows( $rows, $default_items, $map[ $part ]['list'] );
			}
		}
		$out[] = array( 'part' => $part, 'args' => $args );
	}
	return $out;
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
