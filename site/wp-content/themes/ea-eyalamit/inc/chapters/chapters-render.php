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
		/* S006 · slug rename · אישור team_00 2026-08-17 */
		/* המפתח (slug) עבר media → testimonials. ה־'type' נשאר 'media' בכוונה: הוא לא
		 * ה־slug אלא שם קובץ ברירות המחדל (defaults/{type}-defaults.php) ומרחב שמות
		 * ה־ACF (f_{type}_…). יש לכך תקדים מפורש באותה טבלה — 'books' => type 'muzza',
		 * 'eyal-amit' => type 'about', 'qr' => type 'qr-hub'. שינוי ה־type היה גורר
		 * שינוי שם קובץ + מפתחות ACF ללא כל תועלת ל־URL. */
		'testimonials'  => array( 'template' => 'tpl-chapters-page',   'type' => 'media' ),
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
 * S006 T-01 · מקור: הערות 19.8.26/טיפול בדיג_רידו.xlsx · גיליון1!D5
 * «לך על הגרסה המוצעת» — /treatment/ נשאר; ?compare=eyal אינו מחליף ברירות מחדל.
 * treatment-eyal-defaults.php נשאר בדיסק ולא נטען.
 *
 * @return bool
 */
function ea_chapters_treatment_compare_eyal() {
	return false;
}

/**
 * Load the seeded defaults for the current Chapters page type (cached per type).
 *
 * @return array
 */
function ea_chapters_defaults() {
	static $cache = array();
	$type = ea_chapters_type();
	$eyal = ea_chapters_treatment_compare_eyal();
	$key  = $eyal ? 'treatment-eyal' : $type;
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}
	$slug           = $eyal ? 'treatment-eyal' : $type;
	$file           = get_stylesheet_directory() . '/inc/chapters/defaults/' . $slug . '-defaults.php';
	$cache[ $key ] = is_readable( $file ) ? (array) require $file : array();
	return $cache[ $key ];
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
		/* S006 · H-10 · 'session_cards' הוסר: פרק 07 הוא כעת prose ('session_body'),
		 * ואין יותר כרטיסים לרנדר. השארת המפרט הייתה רושמת 16 שדות ACF שאף תבנית
		 * לא קוראת. מקור: סקירה דף הבית.xlsx · C13. */
		/* S006 · H-12 · 'testi_items' עלה מ-4 ל-15 סלוטים ונוסף לו תת-שדה 'href',
		 * כדי שמשטח העריכה יתאים לחמש-עשרה העדויות המאושרות של אייל (כל שם מקושר
		 * לפוסט הפייסבוק שלו). מקור: סקירה דף הבית.xlsx · C16. */
		'testi_items'    => array( 'count' => 15, 'subs' => array( 'text', 'name', 'href', 'initial', 'avatar' ) ),
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
	/* S006 R1-02…R1-05 + wave1 R1-10/16/21/22 + wave2 tools + wave3 books/faq/snoring
	 * · seed from PHP defaults so ACF slots from the previous section order cannot overwrite. */
	if ( in_array( ea_chapters_type(), array( 'treatment', 'method', 'lessons', 'sound-healing', 'shop', 'muzza', 'about', 'mokesh', 'didgeridoos', 'bags', 'stands-storage', 'stand-floor', 'repair', 'kushi-blantis', 'tsva-bekahol', 'vekatavta', 'faq', 'snoring-sleep-apnea' ), true ) ) {
		if ( ! empty( $phero['media'] ) ) {
			$phero['media'] = ea_chapters_resolve_img( $phero['media'] );
		}
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
		/* S006 R1-02…R1-05 + wave1 R1-10/16/21/22 + wave2 tools + wave3 books/faq/snoring · seeded defaults only (see phero overlay). */
		if ( in_array( $type, array( 'treatment', 'method', 'lessons', 'sound-healing', 'shop', 'muzza', 'about', 'mokesh', 'didgeridoos', 'bags', 'stands-storage', 'stand-floor', 'repair', 'kushi-blantis', 'tsva-bekahol', 'vekatavta', 'faq', 'snoring-sleep-apnea' ), true ) ) {
			if ( isset( $map[ $part ]['scalars'] ) ) {
				foreach ( $map[ $part ]['scalars'] as $arg => $kind ) {
					if ( array_key_exists( $arg, $args ) && ( 'img' === $kind || 'file' === $kind ) ) {
						$args[ $arg ] = ea_chapters_resolve_img( $args[ $arg ] );
					}
				}
			}
			$out[] = array( 'part' => $part, 'args' => $args );
			continue;
		}
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
 * Curated testimonials for the marquee, optionally by category.
 * Retired brand is rewritten on display (ea_fb_testimonials_publish_text).
 * Returns [{text,name,href}].
 *
 * @param string $cat Optional FB-corpus category slug.
 * @return array<int,array{text:string,name:string,href:string}>
 */
function ea_chapters_testimonials( $cat = '' ) {
	$src = array();
	if ( '' !== $cat && function_exists( 'ea_fb_testimonials_by_cat' ) ) {
		$src = ea_fb_testimonials_by_cat( $cat );
	}
	if ( empty( $src ) && function_exists( 'ea_fb_testimonials_all' ) ) {
		$src = ea_fb_testimonials_all();
	}
	$out = array();
	foreach ( (array) $src as $t ) {
		$raw = trim( (string) ( $t['text'] ?? ( $t['snippet'] ?? '' ) ) );
		$txt = function_exists( 'ea_fb_testimonials_publish_text' )
			? ea_fb_testimonials_publish_text( $raw )
			: $raw;
		if ( '' === $txt ) {
			continue;
		}
		/* Nimrod, 2026-09-16: href was already in the corpus JSON (the original
		 * Facebook post) but dropped here, so testimonials.php's existing
		 * href-to-link logic never had anything to render for corpus-sourced
		 * pages (it already worked for home's own hand-curated items, which
		 * set href directly in home-defaults.php). No new field invented —
		 * $t['href'] is the same source link ea_fb_testimonials_by_cat/_all
		 * already carry from the corpus file. */
		$out[] = array(
			'text' => $txt,
			'name' => (string) ( $t['name'] ?? '' ),
			'href' => (string) ( $t['href'] ?? '' ),
		);
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
	$html = function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) $html ) : (string) $html;
	echo wp_kses(
		(string) $html,
		array(
			'em'     => array(),
			'br'     => array(),
			'strong' => array(),
			'span'   => array( 'class' => array() ),
			'a'      => array(
				'href'  => array(),
				'class' => array(),
			),
		)
	);
}

/**
 * Alt for content photos when ACF rows omit the new `alt` sub-field.
 *
 * S006 M-10, 2026-09-18: matched by sha256 content hash, not filename/basename.
 * The old 20-entry basename map missed every re-use of a photo under a second
 * filename — the worked example: chapters/eyal-teaching.jpg carries a good alt
 * and is byte-identical to chapters/tsva/tsva-32.jpg, which a basename lookup
 * could never resolve. Hash matching makes a photograph carry its description
 * under every filename it appears under. The 191-entry map below was generated
 * from every `'alt'`/`'media_alt'` value actually present in
 * inc/chapters/defaults/*.php as of M-10 (the original 20 plus the ~156 authored
 * for the three book galleries) — see build_media_data.py's site-image register
 * for the same join. Not auto-regenerated on file changes; a future image with
 * a new description needs its hash added here too, same maintenance shape as
 * the map it replaces.
 *
 * @param string $src      Image URL or theme-relative path.
 * @param string $explicit Explicit alt from the row/field.
 * @return string
 */
function ea_chapters_content_img_alt( $src, $explicit = '' ) {
	$explicit = trim( (string) $explicit );
	if ( '' !== $explicit ) {
		return $explicit;
	}
	static $hash_cache = array();
	$abs = ea_chapters_content_img_abs_path( (string) $src );
	if ( ! $abs ) {
		return '';
	}
	if ( ! array_key_exists( $abs, $hash_cache ) ) {
		$hash_cache[ $abs ] = @hash_file( 'sha256', $abs );
	}
	$hash = $hash_cache[ $abs ];
	if ( ! $hash ) {
		return '';
	}
	$map = ea_chapters_content_img_alt_map();
	return isset( $map[ $hash ] ) ? $map[ $hash ] : '';
}

/**
 * Resolve an image src (theme-relative path or full/staging URL) to an
 * absolute filesystem path inside this theme, or '' if it doesn't resolve to
 * a real file — guards the hash_file() call in ea_chapters_content_img_alt()
 * against remote/foreign URLs.
 *
 * @param string $src
 * @return string
 */
function ea_chapters_content_img_abs_path( $src ) {
	$path = (string) ( wp_parse_url( $src, PHP_URL_PATH ) ?: $src );
	/* get_stylesheet_directory(), NOT get_template_directory(). This is a child
	   theme: get_template_directory() returns the GeneratePress parent, so the
	   needle became '/wp-content/themes/generatepress/', matched nothing, and
	   every path resolved to a file that does not exist — realpath() returned
	   false and the whole 191-entry hash map was dead on the live site. Every
	   other path lookup in this file already uses get_stylesheet_directory()
	   (see :185, :206). It survived review because a standalone PHP harness has
	   no parent theme to be wrong about; only WordPress tells the two apart. */
	$theme_root = get_stylesheet_directory();
	$needle     = '/wp-content/themes/' . basename( $theme_root ) . '/';
	$pos        = strpos( $path, $needle );
	$rel        = false !== $pos ? substr( $path, $pos + strlen( $needle ) ) : ltrim( $path, '/' );
	$abs        = $theme_root . '/' . $rel;
	$real       = realpath( $abs );
	// Guard against path traversal / anything that resolves outside the theme.
	if ( ! $real || 0 !== strpos( $real, realpath( $theme_root ) ) ) {
		return '';
	}
	return $real;
}

/**
 * sha256 => Hebrew alt text, for every photo with a known description
 * anywhere in inc/chapters/defaults/*.php. Generated for M-10 (2026-09-18);
 * see the docblock on ea_chapters_content_img_alt().
 *
 * @return array<string,string>
 */
function ea_chapters_content_img_alt_map() {
	static $map = null;
	if ( null !== $map ) {
		return $map;
	}
	$map = array(
		'006018b4d934b90386682c4cd79cff9046f179c19b59037a4b88a1567ae596d2' => 'אייל עמית עם דיג׳רידו',
		'017b3d09ded24199081a17efce151f5a23951007bbb36cc3920e29fb0d8665bf' => 'מוקש דהימן',
		'01f2bdb3599205528d90c55dee262ed36ae625da1312f4bfcf09feeb9ba6e521' => 'קערת דובדבנים טריים לצד עותק הספר וכתבת',
		'030d9b417b17194db01a415a31d23c84c06583b7e76bc13e7cd018c9a0042a1b' => 'מוקש דהימן',
		'03ac2423d8cec6d8300585565dc459d3d0aa35b97466648c0786c2a56e5517b4' => 'ארבעה אנשים צוחקים באוהל בערב, אחד מחזיק תמונת כריכת הספר וכתבת',
		'04db5076bc1b884ddb4f3de65136468219036c8362423aa7d0285d2198da3df1' => 'אייל עמית עם המאסטר מוקש דהימן ברישיקש, הודו',
		'057ac0fc5d7f6b5a23359eaef342c7afe56cd9ad4f1e39ab0d651854375768e0' => 'שתי נשים באזור ישיבה מוצל בחוף, אחת קוראת את הספר הכחול',
		'06923b20a1b96b430db446938034c2c2ae985928e1ecd3e0abd1235aa5b57c0f' => 'מוקש דהימן',
		'085e849a0d30598c979c81673b4e47453f8d9b7a932a07734758026168b908b7' => 'אישה יושבת מול כוננית ספרים עמוסה, מחזיקה את הספר',
		'0a5a358e8f5f48ad01b276e7be89d6410e32c115aa2d03388f72bec0b99ec347' => 'יד מחזיקה את כריכת הספר וכתבת מול רכב שטח כסוף בדרך כפרית',
		'0b29c14f633f352c7971134adf998142f109f93a29b4a732c05b777c69a0a1f8' => 'מוקש דהימן',
		'0b982c15afe83215cbd41583e4c32b2770764c689b2388c884ab3db41d7d025a' => 'אישה עם שיער מתולתל קוראת את הספר הפתוח',
		'0c8c0ad04f5d03777cc98e2454c747aaa1382423c611de8661874a23b75fab98' => 'גבר ואישה מחייכים מחזיקים לוח עץ עם מדבקת וחייכת',
		'0ec163f2f51ba19e5b0636eb98b5530ef35051918b830188bce9b0e484a0d0b3' => 'גבר עם שיער מקורזל יושב בחוץ עם מחשב נייד ועליו מדבקת וכתבת',
		'0f8390afbe6ad6340a9ce6c0b45a310e0f39d446c26367a42b208145e1b75282' => 'גבר יושב בגינה ומנגן בדידג\'רידו, עם מדבקה דבוקה על כלי הנגינה',
		'0f90fa074e128635fa1f5001955749ecd354134abda51a99ef46d54b381e45df' => 'מתוך אתר מכבי: דיג\'רידו תחת "טיפולים משלימים" לדום נשימה חסימתי בשינה',
		'0fe603b4373c7d31304eb0415fd9547fbec350e30f722716fa4cba7293755b8a' => 'גב הספר עם טקסט תקציר וברקוד',
		'12e45226b3f2355d3a8af1ee3e8f38f65566e3534497ba63555bdba12665331f' => 'גבר קירח מחייך מחזיק פתק מעל מצחו, פאב הומה ברקע',
		'131e0fb3b0f567e89e066fe40c7ef649d471bc9204efd8128a6ab308d31bd40e' => 'שתי נשים מחייכות יושבות על שטיח צבעוני, מסיבת חוץ בלילה',
		'16d05c48aea4c3b65337aa1a91b4da80022fdec529fc736e795f9f3d745fa589' => 'קופסת עור פתוחה עם סיגריה מגולגלת, נייר גלגול ומדבקת וגלגלת',
		'18cdd13c05203b2aefd416fdcc355260a7e6c8603f1217abbe2ee29d253cc851' => 'ברמן מחייך ומצביע על מדבקת וניגנת מאחורי דלפק הבר',
		'1924f0d2e3eeba924aa6149656787368debc509300528f5b9cde1a42f7f76d0d' => 'שולחן עם ערימות ספרים וחבילות פתקי מילים, שלט מחיר בכתב יד',
		'1a1e1893afde01075bc9f2e2d4f8f8735087a2b6aff8239a50d51c185ee9e845' => 'מוקש דהימן',
		'1a8cf9dd5c54a77b15535311831cf5e6af7fb53516f0b44bc5da44e51563e131' => 'כריכת הספר פרושה, צד קדמי ואחורי עם טקסט',
		'1c51b927f4a9f04d00cdc8cad3bbb036a0f81299a7a697e114ba0507cc400673' => 'גבר ושלוש נשים מחייכים במסיבת חוץ בערב, מחזיקים כוסות שתייה',
		'1f3d154d96e62d97e5be4378268d71f87f517eea7a1e0a887541974cc6152c08' => 'הסטודיו בפרדס חנה — שאלות נפוצות',
		'1f4f35513c19c67d2b1e1f45366219e9333f11fad9ae6a660f5b987432bbf98f' => 'ארבעה אנשים מחייכים בשוק, מחזיקים מדבקות עם כיתוב בעברית',
		'1f65dc871830ee2be160aeec65923a2cae84497bdf47b0db320bb87488e542e3' => 'כרטיסי מילים מהספר וכתבת סביב עותק הספר על שמיכה',
		'20ee22605e9c14f6a8a3b1c0b369c66aa24582b288635d5c600306fcfec434fb' => 'גבר מחייך עם אגודל למעלה מחזיק פתק, בחוץ בלילה',
		'20f04b4276cc7bbd386812e3f6243b6afead462a9c6233190c59074658b72be2' => 'כתבת עיתון עם תמונת השחקן שי אביבי בישיבה בחוץ',
		'21efc3f76105a27c601abc4c8ec2b5cca8bf48e0e151bdaefd12baa0ac6cf3ef' => 'מוקש דהימן',
		'230eba7f165faba28796624db7a926fa071510d27268cf2f6df88df23ad15e87' => 'מוזה הוצאה לאור — ספריו של אייל עמית',
		'24b744014baf645e81d8ca651031e65dcf37f96fab25221365fc54d87b4265ba' => 'גבר ושתי נשים מחייכים בסלפי מתחת למטריה אדומה בלילה',
		'2631304e83f1262c9ee7a33396b3b01dddf22ff5dea72d67a7ac75add793b7b3' => 'לוח מודעות עם כרזות אירועים ומודעת הספר וכתבת, ומתחתיו שולחן עם כלים חד-פעמיים',
		'2744420d86f3114760a1858ef592bd001e743277c0ae4e669e0de3a7205d8fb6' => 'שלוש נשים מחייכות בבר, מחזיקות מדבקות עם כיתוב בעברית',
		'27d32f533bcd44f29680a3428fa5745999dcfbd6e6c5dbdcb0fdd465ca5089f3' => 'שתי נשים שוכבות על כריות בחוף מדברי, קוראות ספרים',
		'296350e92674576328a9f831ce36e54529f27cf409bb661085c6ebf03a94652d' => 'קומקום אמייל כחול וכוס תה, לצד כיס טבק גלגול עם פתק',
		'2a91b435c4f68a9fb10acb5f5dd57d1a124a5ee70bdb67027cc4b1202b5e5f70' => 'שני גברים בסלפי צמוד, אחד מהם מחזיק את הספר וכתבת',
		'2bdeb4fd01ab9931672e1bdcb09cd8b5b1bda3884eb366f85e0859b49258a14d' => 'גבר צעיר ללא חולצה יושב על גזע עץ וקורא את הספר הכחול',
		'2ea59fe31dd5f2803e4c0eb62b95bd66a9d3131f3715b2310c78bc4777d65649' => 'הספר הכחול ניצב על שולחן בחנות בדים, גבר צעיר מחייך ברקע',
		'2f0961d898c6cc5bfd756946e0b4cdcc39d6fe069048b3242eb645f4c08001e2' => 'אייל עמית מחזיק פתק עם משפט מהספר וכתבת, בערב חברתי בחוץ',
		'316ae2ee2603e91611a1671a3dfffa3d97b5c824122ddcad0c1d882ff341758e' => 'גבר מנשק אישה על הלחי, היא מחזיקה מכשיר עם מדבקה בעברית',
		'366f14b3455df49d1b9abdaf94c116ab7d487e7a43f9f63ffe266f93a1e66eee' => 'אישה יושבת על קורת עץ וקוראת ספר, תיק גב לצידה',
		'3ab095656e95be02266539d103c5853f1c3e18a5211b2585c72b4a7006334d41' => 'נערה ושתי נשים מחייכות בערב חוץ, מחזיקות פתקי מילים מהספר וכתבת',
		'3ae3b98949e0bc4ef57dc2f8b433fed36dd4c6456bf9285b399185d8d34191a3' => 'גבר צעיר מחזיק ספר כחול לצד אישה מבוגרת, ציורי ילדים על הקיר',
		'3c0a1128a6bfe2e353ba7464adb3986a0d3a23ec676f063259bd29d6b474ab53' => 'שלושה גברים מחייכים יושבים בחוץ בלילה, מחזיקים פתקי מילים',
		'3cf0a938c8bc074c7d7d4d9e8c6592a642ff186a9113d7472e4e9fe44c21c59e' => 'הספר וכתבת מונח על שולחן עץ, לצד כלי אוכל ופסלון תרנגול',
		'3d3f4b1b0b1d35073d4c38f2ccdd8c96b0a3247945408f2d56a9603136a274c0' => 'גבר מחזיק כוס שתייה ופתק עם המילה ונשמת, בערב בחוץ',
		'3fa0abc46bfa48fedfdb33bca0f711f3be7f2cab13b3c364a4992b65ae7f16c0' => 'נשים מחזיקות פתקי מילים מהספר וכתבת סמוך לפניהן, בערב בין אנשים',
		'43b759238dabd5686d1b83288f2e71cdc6c562c293d95c7a597c97918105f16c' => 'גבר שוכב על חוף ים וקורא את הספר, גלגל מתנפח לצידו',
		'44e0c25ebe77c193c73f80d0d4859b75cd36fc230c95423e6e5449d56a5c0326' => 'אישה יושבת על מבנה אבן ליד בריכת מים ירוקה, קוראת את הספר',
		'452ca04727e71ac0e3348389377f9623a9ef39960207500f08c3343e033cb7c2' => 'אישה מצמידה מדבקת ונשמת לשפתיה מול קיר במבוק, לצידה אישה עם מדבקה על ראשה',
		'4541ba3c45bafec61c4082ad61f8982d7b97562f5dd4829937b99c096269413c' => 'מפגש סאונד הילינג בגינת הסטודיו',
		'482aab9bd5e702fbe1463d83b680317908b19d54041f711f08d4f727618b76a3' => 'גבר מחזיק את הספר על חוף חול לבן מול צוקים וסירה במים',
		'488dcc4ec0c9d0a5cfec84e84b4164e396bc15ab14914da2bcfa7ecbb6af7ac2' => 'תרגול נשימה עם דיג׳רידו',
		'48a6d6582209cad82c2fe302230e68e84d18f3e19774b7237f6b7c9e024ba8fe' => 'מוקש דהימן',
		'4ad6b2e8434b86568e53da49a4c10ef61bde9551b5bb6f994ea45ba6752e4b8d' => 'גבר עומד בין שני סוסים בכפר הררי, מחזיק את הספר מול המצלמה',
		'4c03fec702b9e2b6f115a35396169ea0a89694482f41c9354e0d69c9a076e691' => 'שישה אנשים מחייכים מחזיקים פתקי מילים, בפאב עם תמונות דיוקן על הקיר',
		'517f23de5b366b7745d279fec9e996c26ddc85c040dd9b69107f081996e1a887' => 'שלט עץ למתחם פאצ\'ה מאמה בין דקלים, לצידו שלט הספר',
		'520852b80d5db02089bffc319d7b94e5c530b169d880e5d2ae1658b0c27b87a2' => 'תקריב יד חותמת בעט על ספר, לצד ערימת ספרים',
		'53fcfb5f60fddd0933ad0bb055b4cd8001de841caa467a0498e7b3e535d8e138' => 'פרה מציצה מעל ספר פתוח, פרות נוספות ברקע',
		'54960f93f8400b020a4d4e7bd8c8962f42367987336eea2a05f0999b0411759e' => 'מוקש דהימן',
		'54d7adfd51b8ab952080a9ff0480f9e62203a74a6c8422db86909f04bff8f1cf' => 'אייל עמית — וכתבת',
		'55d55c4abef2488a3b15839139028840b75f994d180f4fcf95aa9145b1a1d01a' => 'פרות בסככה מעל ספר פתוח ברקע הקדמי',
		'5708cc2795ca6a7234861c4b1866e8ddd666c3d5bd632222d21d224fca6b4b24' => 'מוקש דהימן',
		'5724684b1d03e19faabd9c4b673c39eec1559525638dfc52bc276e4734721c01' => 'רחוב עם דוכני שוק, אופניים ומדבקה על עמוד חסימה',
		'578c8b8fb89a434430034780325e3ed9f2e36b891213f94f7c076f6d6da50ae3' => 'פסל ישו הגואל על רקע שמיים כחולים, אישה מחזיקה דף עם תמונת כריכת הספר',
		'57f998a2a54fd804c6f0a9a07beebaf00d7a463bbde15fcaa2086cd98c19a9c9' => 'גבר יושב על גזע דקל מעל חוף ים, קורא את הספר',
		'58691a9f21cb34849d2adc026d1815e37b309ab58361bc7bd547c8575eabfc9f' => 'גבר עם משקפיים מחזיק את הספר ותינוק בזרועותיו',
		'594962d6df572fb191ce5838952eebade68f20d7d2f74e085e0743f54bf39b1c' => 'כריכת הספר: רכב מכונף בתוך פרח לוטוס על רקע תכלת',
		'596e32489fd0910799854d0a7041b7c19d49cd97618b8e9bb9a0d25712011b71' => 'שני גברים מחייכים בשוק, מחזיקים מדבקות ונשמת וכתבת',
		'5b4e3981f480aa6b6be733dcd88c73093c40bd15118555a384dc79ea59ab88da' => 'אייל עמית מנגן בדיג׳רידו מול קיר הקשתות בסטודיו',
		'5b55e44b71743fd4bb644f733164f7fad3c825a5f5e85638d2784d6410bcdec1' => 'רכב עם מדבקת וסלחת ליד הפנס האחורי',
		'5da8084c8289017ed3a5f4d7475a050ebd202632ec5c3fa1df6251c8791ef0d2' => 'אישה צעירה עם אופניים מחזיקה את הספר הכחול, עצי פריחה ושלטים ביפנית ברקע',
		'5f5361c18d3a3ea1baf6ae3248294b9b045277201dead55795d6d4f90334c5b7' => 'מבט מלמעלה על ידיים ממיינות פתקי מילים על שולחן עגול',
		'6259065c3233086f928a6f7c32a85b3684dd763ceaa0c16519511e3beb95693c' => 'גבר עם משקפי שמש מחזיק את הספר מול מפרץ טורקיז וצוקים',
		'62d5eba910864060f221f7f654b6d4a20a93051b0c52e279fd5e1da5628857c6' => 'מוקש דהימן',
		'62e9fab270c3b5fbd49cc3a51cb8907e508c5525fae008a9273b84cc6257fe2a' => 'אייל עמית מחייך בכורסה מול כוננית ספרים, מחזיק ספר פתוח',
		'62fe1b04fbf78409d92041350887960606af6d82baaa35a87192625f97712bc5' => 'גבר ואישה מחזיקים יחד צרור פתקי מילים, בחוץ בלילה',
		'655e3d855c733e24bf6d3d263d3a975aabe439674d8434946a46b4dcc04738c9' => 'שתי צעירות ליד עמדת בלו באס בפרדס חנה, עם פתקי משפטים מהספר וכתבת',
		'65963eccf98e5d222bd6fa754d5d48a2e8812980cf626d5c0bb5fa3664fa3c91' => 'קובץ הדפסה של כריכת הספר וכתבת עם גב וכריכה אחורית',
		'66eb3212aeee7dfb652124567009aaa26347ec2925540d387c2bf278453a42ff' => 'גבר יושב ליד מדורה בצריף, קורא את הספר ומחייך',
		'6784366d836f4dce3837501f5c72e6205dfdd485bbc7377f6ede3cf65e86773f' => 'מדבקות בעברית וכרטיס עם תמונת הספר וכתבת על גזע עץ בין צמחים',
		'690b3f89b3a0de34dccf7db9254cbd79ad976918f6aef6d7bf0c08db054288c5' => 'גבר מחייך מחזיק פתק ליד ראשו, קהל רוקד תחת אוהל פתוח',
		'6a42c13c502f673c3f9caf93faee3aafaa86907f7ca42573c7491371c51cc94a' => 'גבר בגלימה מסורתית מחזיק את הספר הכחול ליד שלט הפארק הלאומי ג\'יגמה דורג\'י, פרה שחורה מאחור',
		'6ab22ac714599c3a168e315dd0da42ee10ca89b355468ab4c1ce8680a5f2708f' => 'גבר מצביע אגודל ומחזיק את הספר, מפל מים ברקע',
		'6af86fcaa688e314dc00b7eaf906f3fa54ca2ef07488eb36987c8b5c7125d7c4' => 'גבר צעיר עם כובע מניף אגודל ומחזיק את הספר הכחול, שלטי ניאון ביפנית ברקע',
		'6b1602ab3b10849659810e68db5a1b343d49a1d61eff797609cd157a026bf00b' => 'גבר עם משקפי שמש עומד ליד הגה עץ של ספינה, מצופי הצלה כתומים מעליו',
		'6b341619ac96f219dbaaa97c2af08ba1e22470649e804563a99ca2b639cee10d' => 'דלת זכוכית עם מדבקת פרפר ושלט וצחקת',
		'6c1a3011e105e72b3e85ac432c7585afa6a4b5327880a52f50789f4398424fbb' => 'מכונות ממתקים ופתק עם הכיתוב ואכלת, בכניסה לחנות',
		'6c28013640cda58db08af401fa4b9c100760bb0ae128851717922e9db49a0d5e' => 'מדבקת והודעת ומדבקת חיה מצוירת על שמשה אחורית של רכב',
		'6d7026a55ab0703679b5741affd2b6f560a552c4f597baa372ce1f883541fab4' => 'אייל עמית, מחבר הרומן כושי בלאנטיס',
		'6d8cbfe13c6aa22f4c61e7b690754b312d3ee39b936d7c7b210649612e212d56' => 'פריסת כריכת הספר וכתבת עם רשימת סיפורים בגב הספר',
		'6de30229b4608f9d3ca69f85da4125ae9de6d810f699faab38dadf7b771b2d2f' => 'כתבת עיתון על אייל עמית עם תמונתו בתנוחת הופעה',
		'7225804e4e90bb89a50a417bd70b52b99a1ec8cb88a0f4c8124a979c78b2b08d' => 'שתי נשים מחייכות מחזיקות פתקי מילים, ליד דלת עץ מעוטרת',
		'735966f8d3adf230653cff5fde78d1bcd2b72b103a9e66562a9c072a74502e46' => 'מוקש דהימן',
		'73e2f0d89330637fcd1b4aaa16c2b760f87b2564d457a9959ae79aba3878284b' => 'אייל עמית במהלך עבודה עם דיג׳רידו בסטודיו',
		'77471fe2ef94460ecd890a385c3601ee8d9400fc316636dd63ee62bd25770c3c' => 'חצר בלילה עם שולחן, כיסאות ושלט והקשבת',
		'785937a173e145aeff6f7056fee7dfb68db6a3b81468920064e84bdea9339ebc' => 'גבר מושך חבל ליד סירת עץ על החוף',
		'78bf29b9c29d4fec3812f92693fa361155126667f51afffa381e6dcdbe97c37d' => 'תמרור עצור עם סמל כף יד ומדבקת ונשמת',
		'7be40f1db707a0b1807a91c49333f420cb3bba6d76eff897955dbc7f57548a33' => 'אישה עומדת על דשא ליד אגם, מחזיקה את הספר פתוח',
		'7ceda27e6a1035ffd98d50b590dd9a304b8b1e61bfe93dfaf8ad6120b276e476' => 'כריכת הספר עם איור כלב מנוקד משתין',
		'7ed3d7c2d61048fd66992fdd032f606f48fe7cca55e191235ce810cea1f8cac8' => 'גבר מחייך בראי קטן ברכב, לצידו מדבקת וחייכת',
		'826b6a4d74604ec1c310caf8798fb5f6926f01b2de35f3b175da56073f5bd1f3' => 'תינוק זוחל על רצפת אריחים, עם פתק מחובר לגב',
		'82d81bf79a796613960dd5182228203588a8d6dbc7ae78f4912d05cb76fce1bc' => 'מטייל עם תיק גב מתבונן בסלע טבעי מוזר, מדבר והרים ברקע',
		'844d17cd34e09087c0a5b44d522b74c853e0cf67eb807c4b67a6c6433d4cf5ba' => 'עותק הספר וכתבת מונח על מעקה עץ מול נוף כפרי פתוח',
		'8692139c557c7c8643908789bd0c89f37f80a8dbb75f62ed2dc214ddf8463498' => 'מוקש דהימן',
		'87c64b78c2f6fae0dc25ba7cc1bf467d5cd879b777937d60cb35df0c21f0de66' => 'גבר יושב על סלע ליד נהר בין הרים בדמדומים, מחזיק את הספר ודף נוסף',
		'88d68ea3ceee8dc1b644f07a8f138cabba66e6fe02ea24fbde5ca9780139324d' => 'גבר עם מצלמה מחזיק את הספר הכחול ברחוב שוק, סטופה בודהיסטית מעוטרת בדגלי תפילה ברקע',
		'8dbe19f9e5ef94ca46347c07a7b7b8c8f9d359052eb38c44ddc2e988ffa0a71d' => 'גבר כורע בסככת פרות ומחזיק ספר פתוח',
		'905dbbed149d001ebaefbf487fe718da024e66be3915f5a1d574a06d6fa82a93' => 'אישה ונערה מצטלמות בסלפי ליד רכב עם מדבקת וצחקת',
		'910783cdf68917c5b55aae8ab641bfcb0d426679323f3cba7259eeac04a97cc0' => 'עלי גפן על קרש חיתוך ומדבקה עם הכיתוב וגלגלת',
		'91a467649819b6c80bd32699e435bda5bda60ae2caea24c87d6a0b924a8390df' => 'גבר מקבל תספורת במספרה וקורא את הספר וכתבת',
		'94dcec0ea6d767634574b8fd3359d107bf9c07f00033c93f09471b280f0ad302' => 'פינת נגינה ביתית עם דיג\'רידו ופסנתר חשמלי',
		'957858f5ae334ca9a5100013005bbf523263241dc148d8fcbeec4f1dccb66c4a' => 'תקריב מטושטש של דף זכויות היוצרים בספר וכתבת, ברקע דמויות במטבח',
		'96a1cf666ad7802f40989b3be0872a4b642faf7999717b36ab2041745497bcd6' => 'דלפק צ\'ק-אין בשדה תעופה עם דרכונים, כרטיסי טיסה והדמיית כריכת הספר וכתבת',
		'97ec2221cc18dd294eb39465030c3ebfa4b7641488f2809823effaa28cbbd37a' => 'אייל עמית קורא את הספר, ילד נשען עליו בספה',
		'99879f8b5214369c5b63a5038e4c6d6c10937672fe4254807e986802d8854034' => 'מוקש דהימן',
		'9ca68692b023fead9c074167500d68b24e29e7477aae0a43f6be150b7fb121b5' => 'שתי נשים ליד מבנה טיח לבן מעוטר בדגלי תפילה, אחת מחזיקה ספר כחול קטן',
		'9de5cb08628de40d6b8ce418be8ec532f431eb9812c2b847e81e36fadad57c77' => 'תלמידי בית ספר בבלייזר ועניבת פסים, אחד מהם מחזיק כרטיס עם הכיתוב וכתבת',
		'9f0598b3aee511d726282a1fe4bc0a1d3493cebd5223f9061fc657062747db7f' => 'הספר מונח על חוף אבנים, ים וצוקים לבנים ברקע',
		'9f25a490787305db529efa215679bf0b598803ff79f1e0003b91bf7ad02aeb3d' => 'גבר יחף יושב על הקרקע וקורא את הספר, אופניים ברקע',
		'a038bb5362d06674bd7f975e554f09b0a09487a21dadefdcaf3a266a9fedde7c' => 'אישה קוראת את הספר בתוך סירה ירוקה על החוף, אדם נוסף שוכב לצידה',
		'a339c85eabca081df495bec862e2487ecff6db3dae438aa01084672d624589aa' => 'תקריב על חלק אחורי של אופנוע, לוחית רישוי, פעמונים ומדבקת כלב מצויר',
		'a743a78a492ed704b337599b4828faf7c6c1fa7679434b1bb99543733fb3c708' => 'חלון חנות מכוסה מדבקות צבעוניות וכיתובים, שתיים מסומנות בעיגול כחול',
		'ac772f879f819112a65c3797483a55c342495f9338f97cf4b748072e06f64853' => 'תינוק שוכב עם מוצץ ובובת מיני מאוס, ספרים ובהם כושי בלאנטיס ברקע',
		'ae74c2a1cd7ea0d3c83e4dce11d49302ceb10ce525d45b2fe0cadc9e95abd1d0' => 'אייל מנגן',
		'ae969c02ce78aaf5295f2e7b51d3b3cff4c470e484aee5db8c3012dbf4866365' => 'הדמיית כריכת הספר וכתבת על רקע רכב',
		'b0ae3f13b00b2c3889e06244530d359e5cde0bdbf57b7a92885cae75f1a013fd' => 'שתי נשים מחזיקות פתקי מילים מהספר וכתבת, בערב באירוע עם תאורה צבעונית',
		'b0cd24c654b6e3fcecd25c31939a303ba8f0c1522cc7eb7db04c403b7896a6d1' => 'שלושה גברים מחייכים בערב חוץ, מחזיקים פתקים עם מילים מהספר וכתבת',
		'b1bd935fe3c99b1c0b6b081d10690d04ff18f6cca8f35bf25c0385573a80f057' => 'אייל עמית מנחה מפגש דיג׳רידו',
		'b230febb8efecec75de4d85cbffef18993d73f9adcd266662e5f6b018332da72' => 'פנים הסטודיו בפרדס חנה',
		'b286aafa41272b4086d13b998e8188d01a7003d242ba2edfa3a72cd1bfb8d2eb' => 'גבר מדביק מדבקה על רכב מאזדה בלילה',
		'b28acc60e9d4d79c8696e3a025512db1bc8d44540193f890a3947d9c98c28228' => 'ארבע נשים יושבות בערב חוץ, כל אחת מחזיקה פתק עם מילה מהספר וכתבת',
		'b29bd27460eed74bbed134b636f47f085c8b28901b44066a583ae1c893e4ce41' => 'גבר ואישה מחייכים בסלפי במסיבת חוץ, עמדת תקליטן ברקע',
		'b55544bc797f44843034ca8442c415907cf7128052c81574942c06b2ff43bbc2' => 'אייל עמית מחזיק ילד בחיקו במרפסת בערב, נשים יושבות סביב שולחן ברקע',
		'b5a929f05dac0dadd944211db4a28736401086dbd2a1021339511d565ac703fd' => 'מכסה מחשב נייד עם מדבקות ציוד תקליטנות ומדבקת מילה מהספר וכתבת',
		'bacf412aa9e089a6a706d496df66259c7124092c58d927f8832fd0982797b01f' => 'הגינה והסטודיו בפרדס חנה',
		'bc158fe5c3ff74824f20bdff1e6f02ccc7fad5b96e55103d48b8b194cabf312e' => 'שלט עם משפטים מהספר וכתבת תלוי על קיר בשירותים',
		'bd6992fc9d289098270739ee7c6ec6f08b6ce03cedd68fc65a1ad1b5c5a6dbb0' => 'יד מחזיקה פתק עם הכיתוב וכתבת, אירוע חוצות בלילה',
		'be3e2564767b655b905ba85d1201301665281505969f8daae41d3c6e942debc6' => 'אישה שרועה על מיטה עם הספר בחיקה, קעקוע חינה על השוק',
		'bf2c4552614e58c36543f5aef892e0482c1d3a31d44c475a6a2c434e2ad50f4a' => 'אישה צוחקת ומחזיקה פתק עם המילה וצחקת',
		'bfb5f39f2ead2ff87d5d683c4d6a95c89bb1f3f353fcac14d6f9900dbafaf0c0' => 'אייל עמית מלמד נגינה בדיג\'רידו',
		'c0590cb8b20e33bc5a7edb56fe3e39206bfe77237d0e2c438f2f526703861007' => 'אישה עם כובע מחזיקה ספר כחול פתוח ליד נחל, בדים צהובים תלויים מעליה',
		'c0a79f5e7603c72bee8dc7eae3f0ccd65cd6843af911b177e4c7c16e1f0f0068' => 'גבר מצייר קעקוע חינה על כף רגל',
		'c127ce17f79c29122e669674b04343c7b334d65708fc71a08167ebbf59ebf92b' => 'תקליטן עם כובע ואוזניות עומד ליד מחשב נייד עם מדבקת וניגנת',
		'c306091d4ef9d194688a8c266d1d9ccd4c4815a1aa2400551b0d8d0a480be77a' => 'שלושה אנשים מחייכים בסלפי מתחת לעץ, אישה מחזיקה מחברות והספר וכתבת',
		'c3645e6b6cc3e7f87e8cca4b28c9bb6658d28c702399b58763215f969f706201' => 'תקריב על הגה עץ של ספינה, מדבקות צבעוניות של הספר וחברת שיט לצדו',
		'c69cb7c86370b364e02592d3a239a01ffb6121b07ef4a23815390cbc68ab637d' => 'גביש קוורץ מונח על הספר בגינה',
		'c8f8542f52abe3f0289d610a65a5397b5516458dfd1bc63d7d7812c35cc1c0fd' => 'שני גברים ושתי נשים עומדים בערב חוץ, כל אחד מחזיק פתק עם מילה מהספר וכתבת',
		'cc0cbdad2666aacfd8192842e9e9e0ff58265cbbff4447e5e82ef3d3e8f5cee6' => 'אופנוע עמוס תיקי נסיעה בצד דרך מוצלת, טרקטור אדום ברקע, סימון בעט אדום על התמונה',
		'cd57578a0df9fa70d7580ba6b743682042c9083480f900679899b058e65e95da' => 'לוחית רישוי של רכב ניסאן עם מדבקת וחלמת',
		'cd78a8f8589b59c0afcd481c3e00ef003b532d5fbf9d32f10d06708431a8cdda' => 'גיטרה על מעמד בפינת חדר, פתק מונח לצדה',
		'ce5d97271db4ecebdade27476f62320a7f699b1e571ece51aad1fb1719427339' => 'מוקש דהימן',
		'cefc0e729d33257bcdfff0553f54d75a3113ce58059101446cf2c4fc5da8fdb0' => 'שלושה גברים מחייכים בערב חוץ, מחזיקים פתקים עם משפטים מהספר וכתבת',
		'd163db4daec8aba8d73cf093402aa291ef30b4a0193a9746e1ed091452df2822' => 'דיוקן של אייל עמית',
		'd206f8d432bcba430c920c114ab090c22ede82e8f31444cce322d9a3848e04c5' => 'מפגש סאונד הילינג — הקשבה לצליל',
		'd216c9932ab96db3ebb39d1ca370939c32a312a3b29e59f91a2ebe93357e953e' => 'חלקו האחורי של רכב מסחרי לבן מכוסה מדבקות עם משפטים מהספר וכתבת',
		'd817dfe71570916c0ec0d90b14042d35662e41b63b96f68de7f7f89c8faa40aa' => 'גבר רכון מעל ערימות ספרים על שולחן, בתוך אוהל בלילה',
		'd982625443625f3fd663df6c97efb1b53da78ece3e7a06f6c51e2793e5dd277a' => 'אישה מחזיקה את הספר ליד נהר, מגדל אבן וגשר עץ ברקע',
		'da23cfe36d1a7fb8f3cac1791bc2caf6a26be936d748b8106ee7bf60fca10284' => 'כרטיסי פרסומת לספר וכתבת ושלט מחירון על כיסא קש, לצד ספל אמייל',
		'db026f60430665c715254610a0b9cff973b0eaff080a0f935fca965a19ef9649' => 'כרטיסי מילים מהספר וכתבת ועלי כותרת סגולים מפוזרים על שולחן עץ',
		'dc8bf01e253006aad26c18dfbe450028362da1e4a12254fee1b3073cb8e75fd6' => 'פנים חנות בדים עמוסת אריגים מקופלים, שתי נשים יושבות וגבר הולך ברקע',
		'dca23f2fe984d83893a0519685d54c1068660f868f098baf47fee9ecc0c458e2' => 'מדבקת וכתבת על מעקה עץ מול חוף ים טרופי',
		'df055a0bb411ba776fdc9f544e627a0c4788aeeab6e886777cc4e80a5d84f5fe' => 'גבר מפעיל ציוד תקליטן בחוץ בלילה, ירח מלא בשמיים',
		'e009e007c7b400ca4598695ae746b3cd61330296279ec6af06b9d81caf3c7226' => 'גבר עם כאפייה קורא ספר פתוח ליד הים',
		'e0baa566287a978d44475952865fc94f0e217ebd0be150667e06c9a3246315e2' => 'כיתוב ביד באבק על השמשה האחורית של טנדר לבן, בשטח חקלאי',
		'e2cd38db3a41b83700ab3f09ab714c8d8c703b641b269f93649febc66f33983a' => 'כובע קש, תיק פרחוני והספר וכתבת על כיסאות אדומים באולם',
		'e50f4ee57f15615f9e2324a18ae397fccab72c5f4b425b13d6f9b539088e7de0' => 'מוקש דהימן',
		'e83e495a0c3f03e291054c6e55d3014efb5221612c7802bac3322857b20c1d2c' => 'גבר יושב מול מתלה דיג\'רידואים עם מחשב נייד ועליו מדבקת וכתבת',
		'e8b1c72ec5b5bde4f17e22214b84b9ea1b18024f3680e63718ac6298cd7f8458' => 'מוקש דהימן',
		'e8dee3ec0e8fd85e72f1c1ccc05d95b6fbf031c91606dc1f01935f77affde035' => 'גמל שוכב עם שמיכה צבעונית ואוכף מעוטר, הספר מונח עליו',
		'e9d80e87f6b2afd4c6fef4749b8f80eaf90c5c2daaa444159776a15f98fda2c9' => 'גבר עם משקפי שמש יושב על מדרגות אבן ומחזיק את הספר הכחול, מבנה עם עמודים אדומים מאחור',
		'ec8f0c7b00f858a3ae170633f3c4ff42d29cec0b0d4be61709f3517ee01993ca' => 'אישה קוראת את הספר בבית קפה, מבנים והרים ברקע',
		'ef29494e92fc738637953bd8037221b85a9eb5a65464694cfffc391008e3efab' => 'שלושה גברים מצלמים סלפי בחוץ ומחזיקים כרטיסי מילים מהספר וכתבת',
		'ef5a368039b78b2dfa1ad42f15e090e2323e3a165f51e6c7c417c454789d6e23' => 'גבר קורא את הספר על כיסא ברחוב אבן בכפר עתיק',
		'f0472760b24741cd280ab76e72d72feda9bba09b7a5a16b43c51520760803894' => 'גבר עם משקפי שמש קורא את הספר על מרפסת אבן, נוף הרים ברקע',
		'f1871a1c1bb06e3c25b55ab733bc6109cb032e332311067e0274739ce9aa4f6d' => 'אישה שוכבת על כיסא חוף וקוראת ספר כחול, ים ברקע',
		'f1efb1ab673856f9bc3462c8954ce0b9b3186754087380298e915b0292a1e12d' => 'שני צעירים וצעירה מחזיקים פתקי מילים סמוך לפניהם, בערב בבית קפה',
		'f3c6ffac4f27ea3ee74d986352e5da10d7b2ebbf0d49483759f9e8ad55681e32' => 'מוקש דהימן',
		'f494f3d792a9b5a5ab73c33dbc6bf289e5613d169256c0e1aa78e154db412221' => 'אייל עמית מדבר בטלפון ליד מסך מחשב, מדבקת והקשבת על ארגז עץ',
		'f549fa5ea823e0017504395ff6f5e57ddb5ce4d79a0ea71457dff25e8ed39259' => 'בית המלאכה',
		'f57b4e27c302d1767efc51893984a76d2f10b46215274f98ffc7037d3f2fe1de' => 'אייל עמית בגינת הסטודיו בפרדס חנה',
		'f83424c48571f82fd5119cbda2045d7633a332ad7be7867c8a28ec67c07fada8' => 'שמשה אחורית של רכב עם מדבקת וצחקת',
		'f864fc9272a1ade9cbfe16c33abeec93764d742ebdfc4eb0d11a4a278cf8fae7' => 'מוקש דהימן',
		'f8a5921e6d4f3fae50585172e798b1b0b976f469ffb10183b7ab377fb5792b87' => 'כלב פרוותי עם פתק על הגב עומד ליד ארגזי ירקות בשוק',
		'f91dfd01090f396b424e8dfff5586b727147ee0ddd3f215575a24dd200ae0be2' => 'התכתבות עם מטופל על תוצאות בדיקת שינה לאחר תהליך דיג\'רידו — פרט מזהה מטושטש',
		'f93757578f9988c53317bbad67a10bfa6d7e2237f7842925170292ab130e826e' => 'שתי נשים וגבר יושבים בחוץ בלילה מול גדר קנים, מחזיקים פתקים',
		'fb1a56d02d56eb9c3bb063320cd309bfaf0b98f3083f397b8a74baa8cf22bc22' => 'אייל עמית, מחבר הספר «צבע בכחול וזרוק לים»',
		'fbaef6f9cdb7c1ae8188f167d65187b34bd669cd98020319ff43fec75533bff2' => 'הספר מונח על לוח המחוונים, דרך מושלגת מבעד לשמשה',
		'fcc0b3e1c33ca34064f5d23102f7054b5947e86d4db06ea40a1c567d96820746' => 'אישה וגבר מחזיקים כל אחד פתק עם מילה מהספר וכתבת, בתוך בר',
	);
	return $map;
}
