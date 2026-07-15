<?php
/**
 * Chapters — inner-page ACF field groups (WP-S4-05, free-ACF, data-driven).
 *
 * For every path-B (sections-array) page type, builds ONE free-ACF field group
 * from that type's OWN seeded defaults array (inc/chapters/defaults/{type}-defaults.php)
 * — scalars for every section arg ea_chapters_part_field_map() marks editable,
 * plus fixed-slot fields (no Pro Repeater needed) for every list, sized to
 * default-item-count + headroom. There is deliberately no hand-maintained field
 * list: the defaults file is the single source of truth, and both this registrar
 * and the render-side overlay (ea_chapters_page_sections() in chapters-render.php)
 * derive field names from the SAME shared ea_chapters_part_field_map() — so
 * registration and render can never drift apart (WP-S4-05-LOD400 §10 note).
 *
 * method (flat-key, accessor-driven — mirrors home's existing pattern) gets its
 * own small dedicated registrar, ea_chapters_register_method_fields(), reusing
 * ea_chapters_repeater_specs('method') for its 3 named repeaters so THAT shape
 * also has a single source (chapters-render.php / ea_chapters_assemble_rows()).
 *
 * Naming contract (WP-S4-05-LOD400 §2):
 *   scalar name : s{N}_{arg}            scalar key  : f_{type}_s{N}_{arg}
 *   list slot   : s{N}_i{K}_{sub}       list slot key : f_{type}_s{N}_i{K}_{sub}
 *   group key   : group_chapters_{type} location: page == <slug>
 *
 * Every page still renders identically when ACF is inactive or a field is empty —
 * this file only ADDS override capability. All read-side fallback already lives in
 * chapters-render.php's guarded accessors (ea_chapters_field_or() / rows / img),
 * so a missing acf_add_local_field_group() (ACF absent) or an unset field simply
 * means the seeded default shows, never a fatal or a blank page (AC-NOACF).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', 'ea_chapters_register_inner_fields' );
add_action( 'acf/init', 'ea_chapters_register_method_fields' );

/**
 * Page types excluded from the generic path-B registration loop: qr-hub/qr
 * (dynamic — read from a data file at render time, no sections[] authoring
 * surface), galleries/media (placeholder pages with no Eyal source yet — out of
 * WP-S4-05's approved scope), en (tpl-chapters-en.php inlines its own hardcoded
 * LTR content, not sections-driven), and method (flat-key mode-A — registered
 * separately by ea_chapters_register_method_fields(), not this generic loop).
 *
 * @return string[]
 */
function ea_chapters_inner_excluded_types() {
	return array( 'qr-hub', 'qr', 'galleries', 'media', 'en', 'method' );
}

/**
 * type => slug map (inverse of ea_chapters_route_map()) for field-group location
 * rules. First slug wins if a type were ever mapped from more than one slug.
 *
 * @return array<string,string>
 */
function ea_chapters_inner_type_slug_map() {
	$out = array();
	foreach ( ea_chapters_route_map() as $slug => $row ) {
		$type = isset( $row['type'] ) ? (string) $row['type'] : '';
		if ( '' !== $type && ! isset( $out[ $type ] ) ) {
			$out[ $type ] = $slug;
		}
	}
	return $out;
}

/**
 * Resolve a Chapters route slug (leaf post_name, e.g. 'treatment' or 'mokesh-dahiman')
 * to its numeric page ID for the ACF `page` location rule. ACF's `page` rule matches by
 * numeric page ID — NOT by slug string — so a slug value never matches and the field
 * group would never mount in wp-admin (fields invisible to the editor). Cached per request.
 *
 * @param string $slug
 * @return int Page ID, or 0 if not found (location simply never matches — harmless).
 */
function ea_chapters_inner_page_id( $slug ) {
	static $cache = array();
	if ( array_key_exists( $slug, $cache ) ) {
		return $cache[ $slug ];
	}
	$id   = 0;
	$page = get_page_by_path( $slug, OBJECT, 'page' ); // top-level pages (treatment, method, …)
	if ( $page instanceof WP_Post ) {
		$id = (int) $page->ID;
	} else {
		// Nested pages (e.g. mokesh-dahiman under eyal-amit, vekatavta under books): the
		// route slug is the leaf post_name — look it up directly by name.
		$found = get_posts( array(
			'name'        => $slug,
			'post_type'   => 'page',
			'post_status' => 'any',
			'numberposts' => 1,
			'fields'      => 'ids',
		) );
		$id = $found ? (int) $found[0] : 0;
	}
	$cache[ $slug ] = $id;
	return $id;
}

/**
 * Common Hebrew editor-facing label for a recurring arg/sub name. Falls back to a
 * readable version of the raw key for anything not in this set — still fully
 * functional (the field still registers/overlays correctly), just less polished;
 * the tab label (section chap/title) already orients the editor either way.
 *
 * @param string $key
 * @return string
 */
function ea_chapters_inner_label( $key ) {
	$labels = array(
		'chap'          => 'תווית פרק',
		'title'         => 'כותרת',
		'sub'           => 'תת־כותרת',
		'body'          => 'טקסט',
		'lead'          => 'משפט פתיחה',
		'media'         => 'תמונה',
		'media_alt'     => 'תיאור תמונה (alt)',
		'image'         => 'תמונה',
		'alt'           => 'תיאור תמונה (alt)',
		'cap'           => 'כיתוב',
		'cap_b'         => 'כיתוב (מודגש)',
		'cap_sub'       => 'כיתוב (משנה)',
		'quote'         => 'ציטוט',
		'attrib'        => 'ייחוס',
		'cta_label'     => 'טקסט כפתור',
		'cta_url'       => 'קישור כפתור',
		'cta2_label'    => 'טקסט כפתור 2',
		'cta2_url'      => 'קישור כפתור 2',
		'poster'        => 'תמונת פוסטר',
		'video'         => 'וידאו (mp4)',
		'text'          => 'טקסט',
		'tag'           => 'תווית',
		'more'          => 'טקסט נוסף (בחשיפה)',
		'year'          => 'שנה',
		'name'          => 'שם',
		'cover'         => 'תמונת עטיפה',
		'meta'          => "פרטים (שנה / ז'אנר)",
		'blurb'         => 'תקציר',
		'url'           => 'קישור',
		'contact_label' => 'טקסט כפתור יצירת קשר',
		'price_note'    => 'הערת מחיר',
		'toggle_label'  => 'טקסט כפתור פתיחה',
	);
	return isset( $labels[ $key ] ) ? $labels[ $key ] : ucfirst( str_replace( '_', ' ', $key ) );
}

/**
 * Build one ACF field definition. $name is the BARE field name (no type prefix —
 * matches the naming contract so get_field($name) in the overlay resolves it); the
 * key is namespaced by $type to stay globally unique across every group. $label is
 * resolved by the caller (ea_chapters_inner_label($arg)) since the arg/sub key is
 * no longer recoverable once composed into 's{N}_...'/'s{N}_i{K}_...'/'phero_...'.
 *
 * @param string $type
 * @param string $name
 * @param string $label
 * @param string $kind 'img'|'file'|'txt'|'ta'|'wys'
 * @return array
 */
function ea_chapters_inner_field( $type, $name, $label, $kind ) {
	$key = 'f_' . $type . '_' . $name;
	switch ( $kind ) {
		case 'img':
			return array( 'key' => $key, 'name' => $name, 'label' => $label, 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all' );
		case 'file':
			return array( 'key' => $key, 'name' => $name, 'label' => $label, 'type' => 'file', 'return_format' => 'id', 'mime_types' => 'mp4' );
		case 'wys':
			return array( 'key' => $key, 'name' => $name, 'label' => $label, 'type' => 'wysiwyg', 'media_upload' => 0, 'tabs' => 'visual' );
		case 'ta':
			return array( 'key' => $key, 'name' => $name, 'label' => $label, 'type' => 'textarea', 'rows' => 3, 'new_lines' => '' );
		case 'txt':
		default:
			return array( 'key' => $key, 'name' => $name, 'label' => $label, 'type' => 'text' );
	}
}

/**
 * ACF tab field (wp-admin grouping only — not a data field).
 *
 * @param string $type
 * @param string $slug  Unique-within-group slug for the key.
 * @param string $label
 * @return array
 */
function ea_chapters_inner_tab( $type, $slug, $label ) {
	return array( 'key' => 'tab_' . $type . '_' . $slug, 'label' => $label, 'type' => 'tab', 'placement' => 'top' );
}

/**
 * ACF accordion field (collapsible slot grouping — mirrors acf-fields-home.php's
 * existing $acc() pattern).
 *
 * @param string $type
 * @param string $slug
 * @param string $label
 * @return array
 */
function ea_chapters_inner_accordion( $type, $slug, $label ) {
	return array( 'key' => 'acc_' . $type . '_' . $slug, 'label' => $label, 'type' => 'accordion', 'open' => 0, 'multi_expand' => 1, 'endpoint' => 0 );
}

/**
 * Register one free-ACF field group per path-B page type, built entirely from
 * that type's own seeded defaults (phero + sections[]) — see file docblock.
 */
function ea_chapters_register_inner_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	$excluded = ea_chapters_inner_excluded_types();
	$map      = ea_chapters_part_field_map();
	foreach ( ea_chapters_inner_type_slug_map() as $type => $slug ) {
		if ( in_array( $type, $excluded, true ) ) {
			continue;
		}
		$d = ea_chapters_defaults_for( $type );
		if ( empty( $d ) ) {
			continue;
		}
		$fields = ea_chapters_build_inner_fields( $type, $d, $map );
		if ( empty( $fields ) ) {
			continue; // Nothing editable for this type (e.g. contact — the form itself is CF7/hardcoded).
		}
		acf_add_local_field_group( array(
			'key'             => 'group_chapters_' . $type,
			'title'           => 'פרקים — ' . $slug,
			'fields'          => $fields,
			'location'        => array(
				array( array( 'param' => 'page', 'operator' => '==', 'value' => (string) ea_chapters_inner_page_id( $slug ) ) ),
			),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'description'     => 'תוכן עמוד «פרקים». עריכת טקסטים ותמונות בלבד — המבנה והעיצוב נעולים. תואם ACF החינמי.',
			'hide_on_screen'  => array( 'the_content' ),
		) );
	}
}

/**
 * Build the flat ACF field array for one path-B type: phero_{arg} scalars, then
 * per-section s{N}_{arg} scalars + s{N}_i{K}_{sub} fixed list slots, grouped under
 * tabs (one per section) for a readable wp-admin edit screen.
 *
 * @param string $type
 * @param array  $d   This type's seeded defaults array (phero/sections).
 * @param array  $map ea_chapters_part_field_map().
 * @return array ACF field definitions.
 */
function ea_chapters_build_inner_fields( $type, $d, $map ) {
	$fields = array();

	// phero (top-level, flat naming — aligned with method's existing phero_* convention).
	$phero = ( isset( $d['phero'] ) && is_array( $d['phero'] ) ) ? $d['phero'] : array();
	if ( ! empty( $phero ) && isset( $map['phero']['scalars'] ) ) {
		$fields[] = ea_chapters_inner_tab( $type, 'phero', 'עמוד — כותרת (Hero)' );
		foreach ( $map['phero']['scalars'] as $arg => $kind ) {
			if ( ! array_key_exists( $arg, $phero ) ) {
				continue;
			}
			$fields[] = ea_chapters_inner_field( $type, 'phero_' . $arg, ea_chapters_inner_label( $arg ), $kind );
		}
	}

	$secs = ( isset( $d['sections'] ) && is_array( $d['sections'] ) ) ? $d['sections'] : array();
	foreach ( $secs as $n => $sec ) {
		$part = isset( $sec['part'] ) ? $sec['part'] : '';
		if ( ! isset( $map[ $part ] ) ) {
			continue;
		}
		$args        = ( isset( $sec['args'] ) && is_array( $sec['args'] ) ) ? $sec['args'] : array();
		$has_scalars = isset( $map[ $part ]['scalars'] ) && ! empty( $map[ $part ]['scalars'] );
		$has_list    = isset( $map[ $part ]['list'] );
		if ( ! $has_scalars && ! $has_list ) {
			continue;
		}
		$label     = ! empty( $args['title'] ) ? $args['title'] : ( ! empty( $args['chap'] ) ? $args['chap'] : $part );
		$tab_added = false;

		if ( $has_scalars ) {
			foreach ( $map[ $part ]['scalars'] as $arg => $kind ) {
				if ( ! array_key_exists( $arg, $args ) ) {
					continue; // Only register fields for args THIS section's defaults actually use.
				}
				if ( ! $tab_added ) {
					$fields[]  = ea_chapters_inner_tab( $type, 's' . $n, 'סקשן ' . ( $n + 1 ) . ' — ' . $label );
					$tab_added = true;
				}
				$fields[] = ea_chapters_inner_field( $type, 's' . $n . '_' . $arg, ea_chapters_inner_label( $arg ), $kind );
			}
		}

		if ( $has_list ) {
			$items = ( isset( $args['items'] ) && is_array( $args['items'] ) ) ? $args['items'] : array();
			$count = max( 1, count( $items ) + ea_chapters_list_headroom( $part ) );
			if ( ! $tab_added ) {
				$fields[] = ea_chapters_inner_tab( $type, 's' . $n . '_list', 'סקשן ' . ( $n + 1 ) . ' — ' . $label . ' (רשימה)' );
			}
			for ( $k = 1; $k <= $count; $k++ ) {
				$fields[] = ea_chapters_inner_accordion( $type, 's' . $n . '_i' . $k, 'פריט ' . $k );
				foreach ( $map[ $part ]['list'] as $sub => $kind ) {
					$fields[] = ea_chapters_inner_field( $type, 's' . $n . '_i' . $k . '_' . $sub, ea_chapters_inner_label( $sub ), $kind );
				}
			}
		}
	}

	return $fields;
}

/**
 * Register method's flat-key field group (mode-A, mirrors home's existing
 * pattern) — field NAMES match exactly what tpl-chapters-method.php already
 * requests via ea_chapters_field()/ea_chapters_rows() (WP-S4-05-LOD400 §2.2/§3.3).
 * Repeater slot counts/subs come from ea_chapters_repeater_specs('method')
 * (chapters-render.php) — the SAME source ea_chapters_assemble_rows() reads — so
 * registration can never disagree with what the accessor actually assembles.
 */
function ea_chapters_register_method_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	$type = 'method';
	$map  = ea_chapters_part_field_map();

	$fields = array(
		ea_chapters_inner_tab( $type, 'phero', 'עמוד — כותרת (Hero)' ),
		ea_chapters_inner_field( $type, 'phero_chap', ea_chapters_inner_label( 'chap' ), 'txt' ),
		ea_chapters_inner_field( $type, 'phero_title', ea_chapters_inner_label( 'title' ), 'ta' ),
		ea_chapters_inner_field( $type, 'phero_sub', ea_chapters_inner_label( 'sub' ), 'ta' ),
		ea_chapters_inner_field( $type, 'phero_media', ea_chapters_inner_label( 'media' ), 'img' ),
		ea_chapters_inner_field( $type, 'phero_media_alt', ea_chapters_inner_label( 'media_alt' ), 'txt' ),
		ea_chapters_inner_field( $type, 'phero_cta_label', ea_chapters_inner_label( 'cta_label' ), 'txt' ),
		ea_chapters_inner_field( $type, 'phero_cta_url', ea_chapters_inner_label( 'cta_url' ), 'txt' ),

		ea_chapters_inner_tab( $type, 'split', 'מהי השיטה' ),
		ea_chapters_inner_field( $type, 'split_chap', ea_chapters_inner_label( 'chap' ), 'txt' ),
		ea_chapters_inner_field( $type, 'split_title', ea_chapters_inner_label( 'title' ), 'txt' ),
		ea_chapters_inner_field( $type, 'split_body', ea_chapters_inner_label( 'body' ), 'wys' ),
		ea_chapters_inner_field( $type, 'split_image', ea_chapters_inner_label( 'image' ), 'img' ),
		ea_chapters_inner_field( $type, 'split_alt', ea_chapters_inner_label( 'alt' ), 'txt' ),

		ea_chapters_inner_tab( $type, 'mag', 'איך בנויה השיטה' ),
		ea_chapters_inner_field( $type, 'mag_chap', ea_chapters_inner_label( 'chap' ), 'txt' ),
		ea_chapters_inner_field( $type, 'mag_title', ea_chapters_inner_label( 'title' ), 'txt' ),
		ea_chapters_inner_field( $type, 'mag_image', ea_chapters_inner_label( 'image' ), 'img' ),
		ea_chapters_inner_field( $type, 'mag_alt', ea_chapters_inner_label( 'alt' ), 'txt' ),
		ea_chapters_inner_field( $type, 'mag_cap_b', ea_chapters_inner_label( 'cap_b' ), 'txt' ),
		ea_chapters_inner_field( $type, 'mag_cap_sub', ea_chapters_inner_label( 'cap_sub' ), 'txt' ),
	);

	$fields = array_merge( $fields, ea_chapters_method_slots( $type, 'mag_items', 'פריט', $map['mag']['list'] ) );

	$fields = array_merge(
		$fields,
		array(
			ea_chapters_inner_tab( $type, 'uniq', 'ייחוד' ),
			ea_chapters_inner_field( $type, 'uniq_chap', ea_chapters_inner_label( 'chap' ), 'txt' ),
			ea_chapters_inner_field( $type, 'uniq_title', ea_chapters_inner_label( 'title' ), 'txt' ),
			ea_chapters_inner_field( $type, 'uniq_lead', ea_chapters_inner_label( 'lead' ), 'ta' ),

			ea_chapters_inner_tab( $type, 'bleed', 'ציטוט' ),
			ea_chapters_inner_field( $type, 'bleed_image', ea_chapters_inner_label( 'image' ), 'img' ),
			ea_chapters_inner_field( $type, 'bleed_alt', ea_chapters_inner_label( 'alt' ), 'txt' ),
			ea_chapters_inner_field( $type, 'bleed_quote', ea_chapters_inner_label( 'quote' ), 'ta' ),
			ea_chapters_inner_field( $type, 'bleed_attrib', ea_chapters_inner_label( 'attrib' ), 'txt' ),

			ea_chapters_inner_tab( $type, 'whom', 'למי מתאים' ),
			ea_chapters_inner_field( $type, 'whom_chap', ea_chapters_inner_label( 'chap' ), 'txt' ),
			ea_chapters_inner_field( $type, 'whom_title', ea_chapters_inner_label( 'title' ), 'txt' ),
		)
	);

	// whom_items feeds the 'reveals' part (tpl-chapters-method.php) — same sub-map.
	$fields = array_merge( $fields, ea_chapters_method_slots( $type, 'whom_items', 'פריט', $map['reveals']['list'] ) );

	$fields = array_merge(
		$fields,
		array(
			ea_chapters_inner_tab( $type, 'testi', 'עדויות' ),
			ea_chapters_inner_field( $type, 'testi_chap', ea_chapters_inner_label( 'chap' ), 'txt' ),
			ea_chapters_inner_field( $type, 'testi_title', ea_chapters_inner_label( 'title' ), 'txt' ),
		)
	);

	// testi_items feeds the 'testimonials' part — same sub-map.
	$fields = array_merge( $fields, ea_chapters_method_slots( $type, 'testi_items', 'המלצה', $map['testimonials']['list'] ) );

	$fields = array_merge(
		$fields,
		array(
			ea_chapters_inner_tab( $type, 'cta', 'סיום' ),
			ea_chapters_inner_field( $type, 'cta_title', ea_chapters_inner_label( 'title' ), 'ta' ),
			ea_chapters_inner_field( $type, 'cta_body', ea_chapters_inner_label( 'body' ), 'ta' ),
			ea_chapters_inner_field( $type, 'cta_label', ea_chapters_inner_label( 'cta_label' ), 'txt' ),
			ea_chapters_inner_field( $type, 'cta_url', ea_chapters_inner_label( 'cta_url' ), 'txt' ),
		)
	);

	acf_add_local_field_group( array(
		'key'             => 'group_chapters_method',
		'title'           => 'פרקים — השיטה (method)',
		'fields'          => $fields,
		'location'        => array(
			array( array( 'param' => 'page', 'operator' => '==', 'value' => (string) ea_chapters_inner_page_id( 'method' ) ) ),
		),
		'menu_order'      => 0,
		'position'        => 'normal',
		'style'           => 'default',
		'label_placement' => 'top',
		'active'          => true,
		'description'     => 'תוכן עמוד «השיטה». עריכת טקסטים ותמונות בלבד — המבנה והעיצוב נעולים. תואם ACF החינמי.',
		'hide_on_screen'  => array( 'the_content' ),
	) );
}

/**
 * Fixed-slot fields for one of method's named repeaters, sized/shaped from
 * ea_chapters_repeater_specs('method') (chapters-render.php) — single source
 * shared with ea_chapters_assemble_rows(), so registration can never drift from
 * what the accessor actually reads. $sub_map (sub => kind) is passed in from the
 * corresponding entry of ea_chapters_part_field_map() so no kind-guessing logic is
 * duplicated here either.
 *
 * @param string               $type
 * @param string               $base    Repeater name, e.g. 'mag_items'.
 * @param string               $label   Slot label prefix.
 * @param array<string,string> $sub_map sub => kind.
 * @return array
 */
function ea_chapters_method_slots( $type, $base, $label, $sub_map ) {
	$specs = ea_chapters_repeater_specs( $type );
	if ( ! isset( $specs[ $base ] ) ) {
		return array();
	}
	$out = array();
	for ( $i = 1; $i <= $specs[ $base ]['count']; $i++ ) {
		$out[] = ea_chapters_inner_accordion( $type, $base . '_' . $i, $label . ' ' . $i );
		foreach ( $specs[ $base ]['subs'] as $sub ) {
			$kind  = isset( $sub_map[ $sub ] ) ? $sub_map[ $sub ] : 'txt';
			$out[] = ea_chapters_inner_field( $type, $base . '_' . $i . '_' . $sub, ea_chapters_inner_label( $sub ), $kind );
		}
	}
	return $out;
}
