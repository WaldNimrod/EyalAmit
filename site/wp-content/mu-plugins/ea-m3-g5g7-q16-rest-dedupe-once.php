<?php
/**
 * Plugin Name: EA M3 — G5–G7 / Q1-6 כפילויות REST (פעם אחת)
 * Description: משאיר עמוד קנוני יחיד ל-slug lectures, workshops (תחת learning), sound-healing (שורש); טיוטה לכפילים. איפוס: delete_option('ea_m3_g5g7_q16_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return int[]
 */
function ea_m3_g5g7_get_page_ids_by_slug( $slug ) {
	global $wpdb;
	$ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'page' AND post_name = %s AND post_status IN ('publish','draft','pending','private')",
			$slug
		)
	);
	return array_map( 'intval', $ids );
}

/**
 * @param int   $keep_id ID to keep published.
 * @param int[] $others  Other IDs → draft.
 */
function ea_m3_g5g7_draft_except( $keep_id, $others ) {
	foreach ( $others as $oid ) {
		if ( (int) $oid === (int) $keep_id || $oid < 1 ) {
			continue;
		}
		$p = get_post( $oid );
		if ( ! $p || $p->post_type !== 'page' ) {
			continue;
		}
		if ( $p->post_status === 'publish' ) {
			wp_update_post(
				array(
					'ID'          => $oid,
					'post_status' => 'draft',
				)
			);
		}
	}
}

/**
 * Pick canonical page ID for slug under expected parent (0 = root).
 *
 * @param string $slug   post_name.
 * @param int    $parent Expected post_parent.
 * @return int 0 if none.
 */
function ea_m3_g5g7_pick_canonical( $slug, $parent ) {
	$ids = ea_m3_g5g7_get_page_ids_by_slug( $slug );
	if ( empty( $ids ) ) {
		return 0;
	}
	$match = 0;
	foreach ( $ids as $id ) {
		$p = get_post( $id );
		if ( ! $p ) {
			continue;
		}
		if ( (int) $p->post_parent === (int) $parent ) {
			$match = $id;
			break;
		}
	}
	if ( $match > 0 ) {
		return $match;
	}
	// Fallback: first published by menu_order then ID.
	usort(
		$ids,
		function ( $a, $b ) {
			$pa = get_post( $a );
			$pb = get_post( $b );
			if ( ! $pa || ! $pb ) {
				return 0;
			}
			if ( $pa->post_status === 'publish' && $pb->post_status !== 'publish' ) {
				return -1;
			}
			if ( $pb->post_status === 'publish' && $pa->post_status !== 'publish' ) {
				return 1;
			}
			return (int) $a - (int) $b;
		}
	);
	return (int) $ids[0];
}

function ea_m3_g5g7_q16_maybe_run() {
	if ( get_option( 'ea_m3_g5g7_q16_v1', '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_m3_g5g7_q16_lock' ) ) {
		return;
	}
	set_transient( 'ea_m3_g5g7_q16_lock', 1, 120 );

	try {
		$learning = get_page_by_path( 'learning', OBJECT, 'page' );
		if ( ! $learning ) {
			return;
		}
		$lid = (int) $learning->ID;

		// lectures: canonical under learning.
		$lec_ids = ea_m3_g5g7_get_page_ids_by_slug( 'lectures' );
		$lec_keep = ea_m3_g5g7_pick_canonical( 'lectures', $lid );
		if ( $lec_keep < 1 && ! empty( $lec_ids ) ) {
			$lec_keep = (int) $lec_ids[0];
			wp_update_post(
				array(
					'ID'          => $lec_keep,
					'post_parent' => $lid,
				)
			);
		}
		if ( $lec_keep > 0 ) {
			ea_m3_g5g7_draft_except( $lec_keep, $lec_ids );
		}

		// workshops: canonical under learning.
		$w_ids = ea_m3_g5g7_get_page_ids_by_slug( 'workshops' );
		$w_keep = ea_m3_g5g7_pick_canonical( 'workshops', $lid );
		if ( $w_keep < 1 && ! empty( $w_ids ) ) {
			$w_keep = (int) $w_ids[0];
			wp_update_post(
				array(
					'ID'          => $w_keep,
					'post_parent' => $lid,
				)
			);
		}
		if ( $w_keep > 0 ) {
			ea_m3_g5g7_draft_except( $w_keep, $w_ids );
		}

		// sound-healing: canonical at root.
		$s_ids = ea_m3_g5g7_get_page_ids_by_slug( 'sound-healing' );
		$s_keep = ea_m3_g5g7_pick_canonical( 'sound-healing', 0 );
		if ( $s_keep < 1 && ! empty( $s_ids ) ) {
			$s_keep = (int) $s_ids[0];
			wp_update_post(
				array(
					'ID'          => $s_keep,
					'post_parent' => 0,
				)
			);
		}
		if ( $s_keep > 0 ) {
			ea_m3_g5g7_draft_except( $s_keep, $s_ids );
		}

		update_option( 'ea_m3_g5g7_q16_v1', 'done' );
		flush_rewrite_rules( false );
	} finally {
		delete_transient( 'ea_m3_g5g7_q16_lock' );
	}
}

add_action( 'init', 'ea_m3_g5g7_q16_maybe_run', 29 );
