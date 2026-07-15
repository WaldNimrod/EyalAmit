<?php
/**
 * Plugin Name: EA S4-07 — BN-03 per-route <title> + meta description (once)
 * Description: WP-S4-07 §5.1 (BN-03). Seeds Yoast's `_yoast_wpseo_title` (genuine
 *   gap — no title meta exists anywhere in this codebase yet, confirmed by a
 *   repo-wide grep for `_yoast_wpseo_title` before writing this file) and
 *   backfills `_yoast_wpseo_metadesc` ONLY where still empty, for the 6 WP-S4-07
 *   BN-03 routes: /treatment /method /sound-healing /lessons /eyal-amit + the
 *   CP-01 pillar /snoring-sleep-apnea/. Strings verbatim from
 *   hub/data/content-proposals.json (BN-03 draft_or_outline).
 *
 *   IMPORTANT — does NOT overwrite existing descriptions: /treatment, /method,
 *   /sound-healing, /lessons and /eyal-amit already carry Eyal-approved meta
 *   descriptions set by ea-content-eyal-seo-metadesc-2026-07-12-once.php
 *   (team_00 2026-07-12 directive), which differ in wording from the BN-03
 *   draft below. This script follows the same "never clobber a value an editor
 *   or another process may have set" policy as ea-w2-17-metadesc-backfill-once.php
 *   — so in practice only /snoring-sleep-apnea (no description set anywhere)
 *   picks up the BN-03 description here; the other 5 routes get ONLY the new
 *   <title> (a true gap) and keep their 2026-07-12 description untouched.
 *   team_100/Eyal must decide whether to replace the 07-12 descriptions with
 *   this cbDIDG-forward BN-03 wording — not decided by this script.
 *
 *   [EYAL-SIGN-OFF] open (WP-S4-07 §5.1): whether "מאז 1999" should additionally
 *   appear in the /eyal-amit <title> (competitor-overlap risk flagged in spec).
 *   NOT included in the title below (only in the description, per the verbatim
 *   draft). Meta tags are not visible DOM content, so no .ea-pending-approval
 *   UI marker applies here (per WP-S4-07 §5.1) — this is a process-level flag.
 *
 *   Reset: delete_option('ea_s407_bn03_meta_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'EA_S407_BN03_META_OPTION', 'ea_s407_bn03_meta_v1' );

/**
 * @param string $path Page path e.g. 'method' or 'snoring-sleep-apnea'.
 * @return int Post ID or 0.
 */
function ea_s407_bn03_page_id( $path ) {
	$p = get_page_by_path( $path, OBJECT, 'page' );
	return ( $p && $p->post_type === 'page' ) ? (int) $p->ID : 0;
}

/**
 * Backfill a Yoast meta key ONLY if it has no value yet (never clobber).
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key (_yoast_wpseo_title | _yoast_wpseo_metadesc).
 * @param string $value   Value to set.
 */
function ea_s407_bn03_set_if_empty( $post_id, $key, $value ) {
	if ( $post_id < 1 || '' === $value ) {
		return;
	}
	$existing = get_post_meta( $post_id, $key, true );
	if ( '' !== trim( (string) $existing ) ) {
		return;
	}
	update_post_meta( $post_id, $key, wp_strip_all_tags( $value ) );
}

/**
 * @return void
 */
function ea_s407_bn03_meta_run() {
	if ( get_option( EA_S407_BN03_META_OPTION, '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_s407_bn03_meta_lock' ) ) {
		return;
	}
	set_transient( 'ea_s407_bn03_meta_lock', 1, 120 );

	try {
		$routes = array(
			'treatment'           => array(
				'title' => "טיפול בדיג'רידו בפרדס חנה | אייל עמית – שיטת cbDIDG",
				'desc'  => "טיפול בדיג'רידו: עבודה אקטיבית עם הנשימה היומיומית דרך נגינה, תרגול וליווי אישי, בשיטת cbDIDG של אייל עמית. ליווי אחד-על-אחד בפרדס חנה, ללא ניסיון קודם.",
			),
			'method'              => array(
				'title' => "שיטת cbDIDG | אייל עמית – טיפול בנשימה באמצעות דיג'רידו",
				'desc'  => "מהי שיטת cbDIDG? שיטה לעבודה עם הנשימה דרך נגינה בדיג'רידו וליווי אישי, שפיתח אייל עמית. עבודה אקטיבית, הדרגתית, להחזרת שליטה על הנשימה היומיומית.",
			),
			'sound-healing'       => array(
				'title' => "סאונד הילינג פרטי בדיג'רידו | אייל עמית, פרדס חנה",
				'desc'  => "סאונד הילינג בדיג'רידו — מסע פרטי בצליל ותדר ליחיד או לזוג, ללא מגע, בסטודיו בפרדס חנה. הרפיה עמוקה דרך עבודה עם צליל ונשימה.",
			),
			'lessons'             => array(
				'title' => "שיעורי דיג'רידו פרטיים | נשימה מעגלית בשיטת cbDIDG",
				'desc'  => "שיעורי נגינה בדיג'רידו אחד-על-אחד בפרדס חנה, בשיטת cbDIDG. לימוד הנשימה המעגלית מהבסיס ועד נגינה רציפה, ללא ניסיון קודם.",
			),
			'eyal-amit'           => array(
				'title' => "אייל עמית | טיפול בנשימה באמצעות דיג'רידו, מפתח שיטת cbDIDG",
				'desc'  => "אייל עמית, מהוותיקים בתחום הדיג'רידו בישראל מאז 1999, מפתח שיטת cbDIDG ותלמידו של מוקש דהימן. המרכז לטיפול בנשימה בפרדס חנה.",
			),
			'snoring-sleep-apnea' => array(
				'title' => "דיג'רידו לנחירות ודום נשימה בשינה — מה אומר המחקר | אייל עמית",
				'desc'  => "האם דיג'רידו עוזר לנחירות ולדום נשימה בשינה? מה מצא מחקר ה-BMJ (Puhan 2006), איך זה עובד ולמי זה מתאים — מאת אייל עמית, פרדס חנה.",
			),
		);

		foreach ( $routes as $path => $pair ) {
			$post_id = ea_s407_bn03_page_id( $path );
			ea_s407_bn03_set_if_empty( $post_id, '_yoast_wpseo_title', $pair['title'] );
			ea_s407_bn03_set_if_empty( $post_id, '_yoast_wpseo_metadesc', $pair['desc'] );
		}

		update_option( EA_S407_BN03_META_OPTION, 'done' );
	} finally {
		delete_transient( 'ea_s407_bn03_meta_lock' );
	}
}

add_action( 'init', 'ea_s407_bn03_meta_run', 30 );
