<?php
/**
 * Chapters (פרקים) home — ACF field group (code-registered, version-controlled).
 *
 * Field NAMES match the keys in defaults/home-defaults.php and the accessors in
 * chapters-render.php, so an ACF value transparently overrides the seeded default.
 * Image fields return the attachment id (resolved by ea_chapters_img()).
 *
 * Location: the static front page OR any page assigned the Chapters template —
 * so the front page (force-routed, no template meta) is still editable, and
 * duplicated pages on the template get the same fields.
 *
 * If ACF is inactive this file no-ops; the page renders from seeded defaults.
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
			$f['rows'] = $rows;
			$f['new_lines'] = '';
		}
		if ( 'wysiwyg' === $type ) {
			$f['media_upload'] = 0;
			$f['tabs'] = 'visual';
		}
		return $f;
	};
	$tab = function ( $key, $label ) {
		return array( 'key' => $key, 'label' => $label, 'type' => 'tab', 'placement' => 'top' );
	};

	acf_add_local_field_group( array(
		'key'    => 'group_chapters_home',
		'title'  => 'פרקים — דף הבית',
		'fields' => array(

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
			array( 'key' => 'f_about_tl', 'name' => 'about_timeline', 'label' => 'ציר זמן', 'type' => 'repeater', 'min' => 0, 'max' => 6, 'layout' => 'table', 'button_label' => 'הוסף שלב', 'sub_fields' => array(
				$txt( 'f_tl_year', 'year', 'שנה' ),
				$txt( 'f_tl_text', 'text', 'תיאור' ),
			) ),

			$tab( 'tab_whom', '02 למי מתאים' ),
			$txt( 'f_whom_chap', 'whom_chap', 'תווית פרק' ),
			$txt( 'f_whom_title', 'whom_title', 'כותרת' ),
			$txt( 'f_whom_lead', 'whom_lead', 'משפט פתיחה', 'textarea', 2 ),
			array( 'key' => 'f_whom_items', 'name' => 'whom_items', 'label' => 'פריטים', 'type' => 'repeater', 'min' => 0, 'max' => 4, 'layout' => 'block', 'button_label' => 'הוסף פריט', 'sub_fields' => array(
				$img( 'f_whom_img', 'image', 'תמונה' ),
				$txt( 'f_whom_txt', 'text', 'טקסט', 'textarea', 3 ),
			) ),

			$tab( 'tab_session', '03 מהלך המפגש' ),
			$txt( 'f_sess_chap', 'session_chap', 'תווית פרק' ),
			$txt( 'f_sess_title', 'session_title', 'כותרת' ),
			$txt( 'f_sess_lead', 'session_lead', 'משפט פתיחה', 'textarea', 2 ),
			array( 'key' => 'f_sess_cards', 'name' => 'session_cards', 'label' => 'כרטיסים', 'type' => 'repeater', 'min' => 0, 'max' => 4, 'layout' => 'block', 'button_label' => 'הוסף כרטיס', 'sub_fields' => array(
				$img( 'f_sc_img', 'image', 'תמונה' ),
				$txt( 'f_sc_title', 'title', 'כותרת' ),
				$txt( 'f_sc_text', 'text', 'טקסט קצר', 'textarea', 2 ),
				$txt( 'f_sc_reveal', 'reveal', 'טקסט שנחשף במעבר עכבר', 'textarea', 2 ),
			) ),

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
			array( 'key' => 'f_testi_items', 'name' => 'testi_items', 'label' => 'המלצות', 'type' => 'repeater', 'min' => 0, 'max' => 6, 'layout' => 'block', 'button_label' => 'הוסף המלצה', 'sub_fields' => array(
				$txt( 'f_t_text', 'text', 'טקסט', 'textarea', 3 ),
				$txt( 'f_t_name', 'name', 'שם' ),
				$txt( 'f_t_initial', 'initial', 'אות (אם אין תמונה)' ),
				$img( 'f_t_av', 'avatar', 'תמונת פרופיל (אופציונלי)' ),
			) ),

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
			array( 'key' => 'f_start_steps', 'name' => 'start_steps', 'label' => 'שלבים', 'type' => 'repeater', 'min' => 0, 'max' => 4, 'layout' => 'block', 'button_label' => 'הוסף שלב', 'sub_fields' => array(
				$txt( 'f_st_title', 'title', 'כותרת שלב' ),
				$txt( 'f_st_text', 'text', 'תיאור', 'textarea', 2 ),
			) ),

			$tab( 'tab_foot', 'פוטר' ),
			$txt( 'f_foot_tag', 'foot_tagline', 'תיאור מותג', 'textarea', 2 ),
			$txt( 'f_foot_cr', 'foot_copyright', 'זכויות יוצרים' ),
		),
		'location' => array(
			array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-templates/tpl-chapters-home.php' ) ),
			array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) ),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'active'                => true,
		'description'           => 'תוכן דף הבית בעיצוב "פרקים". עריכת טקסטים ותמונות בלבד — המבנה והעיצוב נעולים.',
		'hide_on_screen'        => array( 'the_content' ),
	) );
}
