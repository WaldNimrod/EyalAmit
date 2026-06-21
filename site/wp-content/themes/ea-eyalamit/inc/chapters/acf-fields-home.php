<?php
/**
 * Chapters (פרקים) home — ACF field group (code-registered, version-controlled).
 *
 * FREE-ACF compatible: the fixed-count sections (timeline / for-whom / session /
 * testimonials / steps) are registered as flat fixed-slot fields named
 * {base}_{i}_{sub} (no Pro Repeater needed). ea_chapters_assemble_rows() turns
 * them back into repeater-shaped rows, so the section partials are unchanged.
 * Slot counts + sub-fields come from ea_chapters_repeater_specs() (single source).
 *
 * Field names match defaults/home-defaults.php + the accessors, so an ACF value
 * transparently overrides the seeded default. Image fields return the attachment
 * id (resolved by ea_chapters_img()/ea_chapters_resolve_img()).
 *
 * Location: the static front page OR any page on the Chapters template. If ACF is
 * inactive this file no-ops and the page renders from seeded defaults.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', 'ea_chapters_register_home_fields' );

function ea_chapters_register_home_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$img = function ( $key, $name, $label ) {
		return array( 'key' => $key, 'name' => $name, 'label' => $label, 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all' );
	};
	$txt = function ( $key, $name, $label, $type = 'text', $rows = 2 ) {
		$f = array( 'key' => $key, 'name' => $name, 'label' => $label, 'type' => $type );
		if ( 'textarea' === $type ) {
			$f['rows']      = $rows;
			$f['new_lines'] = '';
		}
		if ( 'wysiwyg' === $type ) {
			$f['media_upload'] = 0;
			$f['tabs']         = 'visual';
		}
		return $f;
	};
	$tab = function ( $key, $label ) {
		return array( 'key' => $key, 'label' => $label, 'type' => 'tab', 'placement' => 'top' );
	};
	$acc = function ( $key, $label ) {
		return array( 'key' => $key, 'label' => $label, 'type' => 'accordion', 'open' => 0, 'multi_expand' => 1, 'endpoint' => 0 );
	};
	// Build the flat fixed-slot fields for one repeater base.
	$slots = function ( $base, $count, $subdefs, $slot_label ) use ( $img, $txt, $acc ) {
		$out = array();
		for ( $i = 1; $i <= $count; $i++ ) {
			$out[] = $acc( "f_{$base}_{$i}_acc", "{$slot_label} {$i}" );
			foreach ( $subdefs as $sd ) {
				$k = "f_{$base}_{$i}_{$sd['name']}";
				$n = "{$base}_{$i}_{$sd['name']}";
				if ( 'image' === $sd['type'] ) {
					$out[] = $img( $k, $n, $sd['label'] );
				} else {
					$out[] = $txt( $k, $n, $sd['label'], $sd['type'], isset( $sd['rows'] ) ? $sd['rows'] : 2 );
				}
			}
		}
		return $out;
	};

	$fields = array_merge(
		array(
			$tab( 'tab_hero', 'Hero' ),
			$txt( 'f_hero_title', 'hero_title', 'כותרת ראשית (H1) — מותר <em> ו־<br>', 'textarea', 2 ),
			$txt( 'f_hero_sub', 'hero_subtitle', 'תת־כותרת', 'textarea', 3 ),
			$txt( 'f_hero_cta_l', 'hero_cta_label', 'טקסט כפתור' ),
			$txt( 'f_hero_cta_u', 'hero_cta_url', 'קישור כפתור' ),
			array( 'key' => 'f_hero_video', 'name' => 'hero_video', 'label' => 'וידאו רקע (mp4)', 'type' => 'file', 'return_format' => 'url', 'mime_types' => 'mp4' ),
			$img( 'f_hero_poster', 'hero_poster', 'תמונת פוסטר לווידאו' ),

			$tab( 'tab_about', '01 אודות' ),
			$txt( 'f_about_chap', 'about_chap', 'תווית פרק' ),
			$txt( 'f_about_title', 'about_title', 'כותרת' ),
			$txt( 'f_about_body', 'about_body', 'פסקאות', 'wysiwyg' ),
			$img( 'f_about_img1', 'about_img1', 'תמונה 1 (גדולה)' ),
			$txt( 'f_about_img1a', 'about_img1_alt', 'תיאור תמונה 1 (alt)' ),
			$img( 'f_about_img2', 'about_img2', 'תמונה 2' ),
			$txt( 'f_about_img2a', 'about_img2_alt', 'תיאור תמונה 2 (alt)' ),
			$img( 'f_about_img3', 'about_img3', 'תמונה 3' ),
			$txt( 'f_about_img3a', 'about_img3_alt', 'תיאור תמונה 3 (alt)' ),
		),
		$slots( 'about_timeline', 4, array(
			array( 'type' => 'text', 'name' => 'year', 'label' => 'שנה' ),
			array( 'type' => 'text', 'name' => 'text', 'label' => 'תיאור' ),
		), 'שלב' ),

		array(
			$tab( 'tab_whom', '02 למי מתאים' ),
			$txt( 'f_whom_chap', 'whom_chap', 'תווית פרק' ),
			$txt( 'f_whom_title', 'whom_title', 'כותרת' ),
			$txt( 'f_whom_lead', 'whom_lead', 'משפט פתיחה', 'textarea', 2 ),
		),
		$slots( 'whom_items', 4, array(
			array( 'type' => 'image', 'name' => 'image', 'label' => 'תמונה' ),
			array( 'type' => 'textarea', 'name' => 'text', 'label' => 'טקסט', 'rows' => 3 ),
		), 'פריט' ),

		array(
			$tab( 'tab_session', '03 מהלך המפגש' ),
			$txt( 'f_sess_chap', 'session_chap', 'תווית פרק' ),
			$txt( 'f_sess_title', 'session_title', 'כותרת' ),
			$txt( 'f_sess_lead', 'session_lead', 'משפט פתיחה', 'textarea', 2 ),
		),
		$slots( 'session_cards', 4, array(
			array( 'type' => 'image', 'name' => 'image', 'label' => 'תמונה' ),
			array( 'type' => 'text', 'name' => 'title', 'label' => 'כותרת' ),
			array( 'type' => 'textarea', 'name' => 'text', 'label' => 'טקסט קצר', 'rows' => 2 ),
			array( 'type' => 'textarea', 'name' => 'reveal', 'label' => 'טקסט שנחשף במעבר עכבר', 'rows' => 2 ),
		), 'כרטיס' ),

		array(
			$tab( 'tab_band', 'תמונה + ציטוט' ),
			$img( 'f_band_img', 'band_image', 'תמונה (רוחב מלא)' ),
			$txt( 'f_band_alt', 'band_alt', 'תיאור תמונה (alt)' ),
			$txt( 'f_band_q', 'band_quote', 'ציטוט', 'textarea', 2 ),
			$txt( 'f_band_at', 'band_attrib', 'ייחוס' ),

			$tab( 'tab_studio', '04 הסטודיו' ),
			$txt( 'f_studio_chap', 'studio_chap', 'תווית פרק' ),
			$txt( 'f_studio_title', 'studio_title', 'כותרת' ),
			$txt( 'f_studio_body', 'studio_body', 'טקסט', 'textarea', 4 ),
			$txt( 'f_studio_cta_l', 'studio_cta_label', 'טקסט כפתור' ),
			$txt( 'f_studio_cta_u', 'studio_cta_url', 'קישור כפתור' ),
			$img( 'f_studio_img', 'studio_image', 'תמונה' ),
			$txt( 'f_studio_alt', 'studio_alt', 'תיאור תמונה (alt)' ),

			$tab( 'tab_testi', '05 המלצות' ),
			$txt( 'f_testi_chap', 'testi_chap', 'תווית פרק' ),
			$txt( 'f_testi_title', 'testi_title', 'כותרת' ),
		),
		$slots( 'testi_items', 4, array(
			array( 'type' => 'textarea', 'name' => 'text', 'label' => 'טקסט', 'rows' => 3 ),
			array( 'type' => 'text', 'name' => 'name', 'label' => 'שם' ),
			array( 'type' => 'text', 'name' => 'initial', 'label' => 'אות (אם אין תמונה)' ),
			array( 'type' => 'image', 'name' => 'avatar', 'label' => 'תמונת פרופיל (אופציונלי)' ),
		), 'המלצה' ),

		array(
			$tab( 'tab_cmp', '06 השוואה' ),
			$txt( 'f_cmp_chap', 'cmp_chap', 'תווית פרק' ),
			$txt( 'f_cmp_title', 'cmp_title', 'כותרת' ),
			$txt( 'f_cmp_lead', 'cmp_lead', 'משפט פתיחה', 'textarea', 2 ),
			$img( 'f_cmp_a_img', 'cmp_a_image', 'כרטיס א׳ — תמונה' ),
			$txt( 'f_cmp_a_t', 'cmp_a_title', 'כרטיס א׳ — כותרת' ),
			$txt( 'f_cmp_a_x', 'cmp_a_text', 'כרטיס א׳ — טקסט', 'textarea', 3 ),
			$txt( 'f_cmp_a_c', 'cmp_a_cta', 'כרטיס א׳ — טקסט כפתור' ),
			$txt( 'f_cmp_a_u', 'cmp_a_url', 'כרטיס א׳ — קישור' ),
			$img( 'f_cmp_b_img', 'cmp_b_image', 'כרטיס ב׳ — תמונה' ),
			$txt( 'f_cmp_b_t', 'cmp_b_title', 'כרטיס ב׳ — כותרת' ),
			$txt( 'f_cmp_b_x', 'cmp_b_text', 'כרטיס ב׳ — טקסט', 'textarea', 3 ),
			$txt( 'f_cmp_b_c', 'cmp_b_cta', 'כרטיס ב׳ — טקסט כפתור' ),
			$txt( 'f_cmp_b_u', 'cmp_b_url', 'כרטיס ב׳ — קישור' ),

			$tab( 'tab_start', '07 איך מתחילים' ),
			$txt( 'f_start_chap', 'start_chap', 'תווית פרק' ),
			$txt( 'f_start_title', 'start_title', 'כותרת' ),
			$img( 'f_start_bg', 'start_bg', 'תמונת רקע' ),
			$txt( 'f_start_cta_l', 'start_cta_label', 'טקסט כפתור' ),
			$txt( 'f_start_cta_u', 'start_cta_url', 'קישור כפתור' ),
		),
		$slots( 'start_steps', 3, array(
			array( 'type' => 'text', 'name' => 'title', 'label' => 'כותרת שלב' ),
			array( 'type' => 'textarea', 'name' => 'text', 'label' => 'תיאור', 'rows' => 2 ),
		), 'שלב' ),

		array(
			$tab( 'tab_foot', 'פוטר' ),
			$txt( 'f_foot_tag', 'foot_tagline', 'תיאור מותג', 'textarea', 2 ),
			$txt( 'f_foot_cr', 'foot_copyright', 'זכויות יוצרים' ),
		)
	);

	acf_add_local_field_group( array(
		'key'            => 'group_chapters_home',
		'title'          => 'פרקים — דף הבית',
		'fields'         => $fields,
		'location'       => array(
			array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-templates/tpl-chapters-home.php' ) ),
			array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) ),
		),
		'menu_order'     => 0,
		'position'       => 'normal',
		'style'          => 'default',
		'label_placement'=> 'top',
		'active'         => true,
		'description'    => 'תוכן דף הבית בעיצוב "פרקים". עריכת טקסטים ותמונות בלבד — המבנה והעיצוב נעולים. תואם ACF החינמי.',
		'hide_on_screen' => array( 'the_content' ),
	) );
}
