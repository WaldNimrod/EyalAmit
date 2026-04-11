<?php
/**
 * Plugin Name: EA M2 — תיקוני slug לפי עץ נעול (פעם אחת)
 * Description: יוצר עמודים חסרים: method (השיטה), faq, galleries, media — יישור ל־site-tree.json; לא מוחק עמודים ישנים (למשל hashita). אפס: delete_option('ea_m2_ia_slug_fixups_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return int|\WP_Error
 */
function ea_m2_ia_fixups_get_or_create_page( $title, $slug, $content = '' ) {
	$existing = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $existing && $existing->post_status === 'publish' ) {
		return (int) $existing->ID;
	}
	$html = $content ? '<p>' . wp_kses_post( $content ) . '</p>' : '<p></p>';
	return wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_parent'  => 0,
			'post_content' => $html,
		),
		true
	);
}

/**
 * Runs once after shell seed (option separate so sites already seeded still get fixups).
 */
function ea_m2_ia_slug_fixups_maybe_run() {
	if ( get_option( 'ea_m2_ia_slug_fixups_v1', '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_m2_ia_slug_fixups_lock' ) ) {
		return;
	}
	set_transient( 'ea_m2_ia_slug_fixups_lock', 1, 120 );

	try {
		ea_m2_ia_fixups_get_or_create_page(
			'השיטה',
			'method',
			'Placeholder — תוכן לפי SSOT; slug נעול מול site-tree (st-method).'
		);
		ea_m2_ia_fixups_get_or_create_page(
			'שאלות נפוצות (FAQ)',
			'faq',
			'מבוא זמני — רשומות FAQ יוזנו מאייל או כאינסטנסים ב־CMS.'
		);
		ea_m2_ia_fixups_get_or_create_page(
			'גלריות — קטלוג מרכזי',
			'galleries',
			'מבוא זמני — קטלוג גלריות לפי מודל האינסטנסים.'
		);
		ea_m2_ia_fixups_get_or_create_page(
			'המלצות — קטלוג מרכזי',
			'media',
			'מבוא זמני — המלצות ומדיה לפי מודל האינסטנסים.'
		);
		update_option( 'ea_m2_ia_slug_fixups_v1', 'done' );
		flush_rewrite_rules( false );
	} finally {
		delete_transient( 'ea_m2_ia_slug_fixups_lock' );
	}
}

add_action( 'init', 'ea_m2_ia_slug_fixups_maybe_run', 26 );
