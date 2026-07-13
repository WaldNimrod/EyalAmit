<?php
/**
 * Plugin Name: EA — Eyal SEO doc meta-description update (2026-07-12, once)
 * Description: Applies the exact meta-description wording from Eyal's SEO spec doc
 *   (2026-07-12 WhatsApp intake) to the 8 routes where that doc gives a complete,
 *   well-formed sentence (not a 2-4 word fragment). Force-overwrites
 *   `_yoast_wpseo_metadesc` (content = Eyal's call, per team_00 2026-07-12 directive),
 *   unlike the backfill-if-empty scripts this supersedes for these routes.
 *   Intentionally SKIPS /bags, /stands-storage, /stand-floor, /books,
 *   /kushi-blantis, /vekatavta, /tsva-bekahol, /eyal-amit, /mokesh-dahiman — the SEO
 *   doc's text for those is a short keyword fragment (e.g. "ספר מאת אייל עמית"), not a
 *   real meta description, and would regress the fuller existing copy. Flagged back
 *   to team_00 rather than applied. Reset: delete_option('ea_eyal_seo_metadesc_20260712_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'EA_EYAL_SEO_METADESC_20260712_OPTION', 'ea_eyal_seo_metadesc_20260712_v1' );

/**
 * @param string $path Page path e.g. 'method' or 'books/vekatavta'.
 * @return int Post ID or 0.
 */
function ea_eyal_seo_metadesc_20260712_page_id( $path ) {
	$p = get_page_by_path( $path, OBJECT, 'page' );
	return ( $p && $p->post_type === 'page' ) ? (int) $p->ID : 0;
}

/**
 * Force-set the Yoast meta description for a post ID (overwrites any existing value).
 *
 * @param int    $post_id Post ID.
 * @param string $desc    Meta description.
 */
function ea_eyal_seo_metadesc_20260712_set( $post_id, $desc ) {
	if ( $post_id < 1 || '' === $desc ) {
		return;
	}
	update_post_meta( $post_id, '_yoast_wpseo_metadesc', wp_strip_all_tags( $desc ) );
}

/**
 * @return void
 */
function ea_eyal_seo_metadesc_20260712_run() {
	if ( get_option( EA_EYAL_SEO_METADESC_20260712_OPTION, '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_eyal_seo_metadesc_20260712_lock' ) ) {
		return;
	}
	set_transient( 'ea_eyal_seo_metadesc_20260712_lock', 1, 120 );

	try {
		// Front page (static home, page_on_front).
		$front_id = (int) get_option( 'page_on_front', 0 );
		ea_eyal_seo_metadesc_20260712_set(
			$front_id,
			"החזירו את השליטה על הנשימה בשיטת cbDIDG של אייל עמית. טיפול בנחירות, דום נשימה וסטרס באמצעות תרגול דיג'רידו אקטיבי. ליווי אישי בפרדס חנה."
		);

		ea_eyal_seo_metadesc_20260712_set(
			ea_eyal_seo_metadesc_20260712_page_id( 'treatment' ),
			"תהליך אישי לחיזוק מערכת הנשימה. למדו להחזיר שליטה וויסות למערכת הנשימה דרך הדיג'רידו. פתרון מבוסס תרגול לסטרס, נחירות ומתח כרוני."
		);

		ea_eyal_seo_metadesc_20260712_set(
			ea_eyal_seo_metadesc_20260712_page_id( 'method' ),
			"גלו את עקרונות cbDIDG: הבחנה בין דפוסי נשימה, עבודה אקטיבית ודיוק פיזיקלי. השיטה המקצועית של אייל עמית לחיזוק דרכי נשימה באמצעות דיג'רידו."
		);

		ea_eyal_seo_metadesc_20260712_set(
			ea_eyal_seo_metadesc_20260712_page_id( 'sound-healing' ),
			"חוויה פאסיבית של הרפיה עמוקה ואיזון תדרים. מפגש אישי בסטודיו אקוסטי בפרדס חנה. עצירה מהשגרה וחיבור פנימי דרך צליל הדיג'רידו."
		);

		ea_eyal_seo_metadesc_20260712_set(
			ea_eyal_seo_metadesc_20260712_page_id( 'lessons' ),
			"למדו לנגן בדיג'רידו אחד על אחד בפרדס חנה. שליטה בנשימה מעגלית, מקצבים ואפקטים. מתודולוגיה הדרגתית המותאמת לקצב האישי שלכם."
		);

		ea_eyal_seo_metadesc_20260712_set(
			ea_eyal_seo_metadesc_20260712_page_id( 'faq' ),
			"כל התשובות על טיפול בנשימה, רכישה, תיקון כלי דיג'רידו ולימוד נשימה מעגלית. מידע מקצועי מקיף מאת אייל עמית."
		);

		ea_eyal_seo_metadesc_20260712_set(
			ea_eyal_seo_metadesc_20260712_page_id( 'repair' ),
			"שירות תיקון דיג'רידו מקצועי: טיפול בסדקים, שברים ושדרוג פיות עץ. עבודה מבוססת הבנה גיאומטרית-פיזיקלית של מבנה הכלי והסאונד."
		);

		ea_eyal_seo_metadesc_20260712_set(
			ea_eyal_seo_metadesc_20260712_page_id( 'didgeridoos' ),
			"למכירה: כלי דיג'רידו שנבנו בעבודת יד ע\"י אייל עמית. כלים בעלי לחץ אחורי גבוה המותאמים במיוחד לעבודה נשימתית טיפולית."
		);

		update_option( EA_EYAL_SEO_METADESC_20260712_OPTION, 'done' );
	} finally {
		delete_transient( 'ea_eyal_seo_metadesc_20260712_lock' );
	}
}

add_action( 'init', 'ea_eyal_seo_metadesc_20260712_run', 30 );
