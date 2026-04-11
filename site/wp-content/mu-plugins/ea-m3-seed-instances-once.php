<?php
/**
 * Plugin Name: EA M3 — זריעת אינסטנסים לדוגמה (פעם אחת)
 * Description: יוצר פריטי דוגמה ל־ea_faq, ea_gallery, ea_testimonial אם חסרים — לבדיקות QA-2. איפוס: delete_option('ea_m3_instances_seed_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * @param string $post_type CPT slug.
 * @param string $slug      post_name ייחודי.
 * @return int Post ID או 0.
 */
function ea_m3_instances_find_by_slug( $post_type, $slug ) {
	$posts = get_posts(
		array(
			'post_type'      => $post_type,
			'name'           => $slug,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	return ! empty( $posts ) ? (int) $posts[0] : 0;
}

/**
 * @param string $post_type CPT.
 * @param string $slug      post_name.
 * @param string $title     כותרת.
 * @param string $content   תוכן HTML.
 * @param string $excerpt   תקציר (אופציונלי).
 * @return void
 */
function ea_m3_instances_ensure_post( $post_type, $slug, $title, $content, $excerpt = '' ) {
	if ( ea_m3_instances_find_by_slug( $post_type, $slug ) > 0 ) {
		return;
	}
	wp_insert_post(
		array(
			'post_type'    => $post_type,
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
			'post_excerpt' => $excerpt,
			'menu_order'   => 0,
		),
		true
	);
}

/**
 * זריעה חד־פעמית — אחרי רישום CPT ב־child theme (init 9).
 */
function ea_m3_instances_seed_maybe_run() {
	if ( get_option( 'ea_m3_instances_seed_v1', '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( ! post_type_exists( 'ea_faq' ) || ! post_type_exists( 'ea_gallery' ) || ! post_type_exists( 'ea_testimonial' ) ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_m3_instances_seed_lock' ) ) {
		return;
	}
	set_transient( 'ea_m3_instances_seed_lock', 1, 120 );

	try {
		ea_m3_instances_ensure_post(
			'ea_faq',
			'ea-m3-seed-faq-1',
			'שאלת דוגמה (M3) — PLACEHOLDER R1',
			'<p>תשובה זמנית לבדיקת QA — להחליף מתוכן legacy / צוות 80.</p>'
		);
		ea_m3_instances_ensure_post(
			'ea_faq',
			'ea-m3-seed-faq-2',
			'שאלת דוגמה שנייה — PLACEHOLDER R2',
			'<p>תשובה זמנית שנייה — taxonomy / מבנה Toolset היסטורי יוטמע במיגרציה.</p>'
		);
		ea_m3_instances_ensure_post(
			'ea_gallery',
			'ea-m3-seed-gallery-1',
			'גלריית דוגמה — PLACEHOLDER R3',
			'<p>גוף גלריה: בלוקי גלריה WP או תמונות ממוזערות — ללא Envira בלי אישור 100. תמונות לפי Drive + 150KB למחיצה.</p>',
			'תקציר קצר לכרטיס הקטלוג — להחליף לאחר מיגרציה מ־legacy.'
		);
		ea_m3_instances_ensure_post(
			'ea_gallery',
			'ea-m3-seed-gallery-2',
			'גלריית דוגמה שנייה — PLACEHOLDER R4',
			'<p>מחיצה שנייה לדוגמה — מיפוי מלא מול GALLERY-INVENTORY.</p>',
			'תקציר שני לכרטיס.'
		);
		ea_m3_instances_ensure_post(
			'ea_testimonial',
			'ea-m3-seed-testimonial-1',
			'המלצת דוגמה — PLACEHOLDER R5',
			'<p>ציטוט או סיכום עדות — לאחד תוכן מ־testimonials-media לפי החלטת 100.</p>',
			'מקור / שם — PLACEHOLDER.'
		);
		ea_m3_instances_ensure_post(
			'ea_testimonial',
			'ea-m3-seed-testimonial-2',
			'המלצה שנייה',
			'<p>פריט שני לבדיקת רשימה ו־RTL.</p>',
			'תקציר שני.'
		);

		flush_rewrite_rules( false );
		update_option( 'ea_m3_instances_seed_v1', 'done' );
	} finally {
		delete_transient( 'ea_m3_instances_seed_lock' );
	}
}

add_action( 'init', 'ea_m3_instances_seed_maybe_run', 27 );
