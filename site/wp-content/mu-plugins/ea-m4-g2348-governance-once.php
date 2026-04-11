<?php
/**
 * Plugin Name: EA M4 — G2/G3/G4/G8 מנדט נימרוד §8 (פעם אחת)
 * Description: איחוד repair, עמוד קורסים פנימי, שלד ספר צבע, איחוד מדיה (טיוטת testimonials-media + טקסונומיית המלצות). איפוס: delete_option('ea_m4_g2348_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'EA_M4_G2348_OPTION', 'ea_m4_g2348_v1' );

/**
 * @return int[]
 */
function ea_m4_g2348_page_ids_by_slug( $slug ) {
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
function ea_m4_g2348_draft_except( $keep_id, $others ) {
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
 * @param string $slug   post_name.
 * @param int    $parent Expected post_parent.
 * @return int 0 if none.
 */
function ea_m4_g2348_pick_under_parent( $slug, $parent ) {
	$ids = ea_m4_g2348_page_ids_by_slug( $slug );
	foreach ( $ids as $id ) {
		$p = get_post( $id );
		if ( $p && (int) $p->post_parent === (int) $parent ) {
			return (int) $id;
		}
	}
	return 0;
}

/**
 * @return void
 */
function ea_m4_g2348_ensure_testimonial_term() {
	if ( ! taxonomy_exists( 'ea_testimonial_cat' ) ) {
		return;
	}
	$t = term_exists( 'recommendations', 'ea_testimonial_cat' );
	if ( $t ) {
		return;
	}
	wp_insert_term(
		'המלצות',
		'ea_testimonial_cat',
		array(
			'slug' => 'recommendations',
		)
	);
}

/**
 * Assign «המלצות» to all published ea_testimonial (קטלוג מאוחד G8).
 *
 * @return void
 */
function ea_m4_g2348_assign_testimonial_terms() {
	ea_m4_g2348_ensure_testimonial_term();
	$term = get_term_by( 'slug', 'recommendations', 'ea_testimonial_cat' );
	if ( ! $term || is_wp_error( $term ) ) {
		return;
	}
	$tid = (int) $term->term_id;
	$posts = get_posts(
		array(
			'post_type'      => 'ea_testimonial',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);
	foreach ( $posts as $pid ) {
		wp_set_object_terms( (int) $pid, array( $tid ), 'ea_testimonial_cat', false );
	}
}

/**
 * @return string
 */
function ea_m4_g2348_html_courses_landing() {
	$purchase = apply_filters( 'ea_m4_courses_purchase_url', 'https://www.eyalamit.co.il/' );
	$learn    = apply_filters( 'ea_m4_courses_learn_url', 'https://www.eyalamit.co.il/' );
	$intro    = 'עמוד זה מרכז מידע על קורסים חיצוניים (סקולר / רב־מסר) מתוך האתר של אייל. כאן ניתן לקרוא הקשר קצר, ולצאת ליעדי הרכישה והלמידה בפלטפורמות החיצוניות המאושרות — כשה־URL הסופי ייקלט מ־אייל/נימרוד, יש לעדכן את הקישורים בלי לשנות את מבנה העץ.';
	$html     = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — G3 — v1 — 2026-04-01 — לא לאישור פרסום סופי</em></p>';
	$html    .= '<p>' . esc_html( $intro ) . '</p>';
	$html    .= '<p class="ea-courses-external-actions">';
	$html    .= '<a class="ea-button ea-courses-purchase" href="' . esc_url( $purchase ) . '" rel="noopener noreferrer">' . esc_html__( 'מעבר לרכישה / סקולר', 'ea-eyalamit' ) . '</a> ';
	$html    .= '<a class="ea-button ea-courses-learn" href="' . esc_url( $learn ) . '" rel="noopener noreferrer">' . esc_html__( 'מעבר לקורס / למידה עצמית', 'ea-eyalamit' ) . '</a>';
	$html    .= '</p>';
	return $html;
}

/**
 * @return string
 */
function ea_m4_g2348_html_book_tsva_shell() {
	$html  = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — G4 — שלד ספר — st-book-tsva — v1 — לא לאישור פרסום; אימות legacy — M5/cutover</em></p>';
	$html .= '<h2 class="ea-book-title">' . esc_html__( 'צבע בכחול וזרוק לים', 'ea-eyalamit' ) . '</h2>';
	$html .= '<p class="ea-book-lead">' . esc_html__( 'תקציר הספר — PLACEHOLDER עד שחזור מלא מ־legacy או אספקת מחקר.', 'ea-eyalamit' ) . '</p>';
	$html .= '<figure class="ea-book-cover-placeholder" aria-label="' . esc_attr__( 'מקום לתמונת כריכה', 'ea-eyalamit' ) . '"><p>' . esc_html__( '[תמונת כריכה — PLACEHOLDER]', 'ea-eyalamit' ) . '</p></figure>';
	$html .= '<section class="ea-book-section"><h3>' . esc_html__( 'על הספר', 'ea-eyalamit' ) . '</h3><p>' . esc_html__( 'טקסט מבוא — PLACEHOLDER (R# לפי M3-TEXT-PLACEHOLDER-REQUIREMENTS).', 'ea-eyalamit' ) . '</p></section>';
	$html .= '<section class="ea-book-section"><h3>' . esc_html__( 'קטע לדוגמה', 'ea-eyalamit' ) . '</h3><p>' . esc_html__( 'ציטוט או פסקה — PLACEHOLDER.', 'ea-eyalamit' ) . '</p></section>';
	$html .= '<section class="ea-book-section"><h3>' . esc_html__( 'רכישה', 'ea-eyalamit' ) . '</h3><p>' . esc_html__( 'קישורי רכישה (מודפס / דיגיטלי) — PLACEHOLDER עד אימות מול אתר חי.', 'ea-eyalamit' ) . '</p></section>';
	return $html;
}

/**
 * @return void
 */
function ea_m4_g2348_maybe_run() {
	if ( get_option( EA_M4_G2348_OPTION, '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_m4_g2348_lock' ) ) {
		return;
	}
	set_transient( 'ea_m4_g2348_lock', 1, 120 );

	try {
		$tools = get_page_by_path( 'tools-and-accessories', OBJECT, 'page' );
		$tid   = $tools ? (int) $tools->ID : 0;

		// G2 — קנוני repair תחת כלים; טיוטה לכפילים.
		if ( $tid > 0 ) {
			$r_ids = ea_m4_g2348_page_ids_by_slug( 'repair' );
			$r_keep = ea_m4_g2348_pick_under_parent( 'repair', $tid );
			if ( $r_keep < 1 && ! empty( $r_ids ) ) {
				$r_keep = (int) $r_ids[0];
				wp_update_post(
					array(
						'ID'          => $r_keep,
						'post_parent' => $tid,
					)
				);
			}
			if ( $r_keep > 0 ) {
				wp_update_post(
					array(
						'ID'         => $r_keep,
						'post_title' => 'תיקון וחידוש כלים',
					)
				);
				ea_m4_g2348_draft_except( $r_keep, $r_ids );
			}
		}
		$ir_ids = ea_m4_g2348_page_ids_by_slug( 'instrument-repair' );
		foreach ( $ir_ids as $iid ) {
			$p = get_post( $iid );
			if ( $p && $p->post_status === 'publish' ) {
				wp_update_post(
					array(
						'ID'          => $iid,
						'post_status' => 'draft',
					)
				);
			}
		}

		// G8 — עמוד כפול testimonials-media → טיוטה (301 כבר ב־MU M2).
		foreach ( ea_m4_g2348_page_ids_by_slug( 'testimonials-media' ) as $x ) {
			$px = get_post( $x );
			if ( $px && $px->post_status === 'publish' ) {
				wp_update_post(
					array(
						'ID'          => $x,
						'post_status' => 'draft',
					)
				);
			}
		}

		// G3 — תוכן עמוד קורסים פנימי.
		$courses = get_page_by_path( 'learning/courses-external', OBJECT, 'page' );
		if ( $courses ) {
			wp_update_post(
				array(
					'ID'           => (int) $courses->ID,
					'post_content' => wp_kses_post( ea_m4_g2348_html_courses_landing() ),
				)
			);
		}

		// G4 — שלד ספר צבע.
		$tsva = get_page_by_path( 'muzza/tsva-bechol-ve-zorek-layam', OBJECT, 'page' );
		if ( ! $tsva ) {
			$tsva = get_page_by_path( 'muzeh/tsva-bechol-ve-zorek-layam', OBJECT, 'page' );
		}
		if ( $tsva ) {
			wp_update_post(
				array(
					'ID'           => (int) $tsva->ID,
					'post_content' => wp_kses_post( ea_m4_g2348_html_book_tsva_shell() ),
				)
			);
		}

		if ( taxonomy_exists( 'ea_testimonial_cat' ) ) {
			ea_m4_g2348_assign_testimonial_terms();
		}

		update_option( EA_M4_G2348_OPTION, 'done' );
		flush_rewrite_rules( false );
	} finally {
		delete_transient( 'ea_m4_g2348_lock' );
	}
}

add_action( 'init', 'ea_m4_g2348_maybe_run', 32 );
