<?php
/**
 * Plugin Name: EA S007 — retire the instance-CPT single URLs, and trash the 4 seed items (once)
 * Description: team_00 ruled 2026-09-20 on two separate things, and this carries out both.
 *
 *   (1) «שאלות - אם זה כפילות תוכן מלאה - למחוק». Verified live the same day, against the
 *   REST list and the rendered page: all 133 ea_faq questions and all 133 answers already
 *   appear on /faq/. Full duplication. But the deletion is of the URLs, not the content —
 *   /faq/ is RENDERED FROM these posts by ea_faq_query_items(), so trashing them would empty
 *   the very page they duplicate. The URLs are removed by registering the three instance CPTs
 *   non-public in the child theme's functions.php; this file only flushes the rewrite rules so
 *   the already-generated /faq-item/…, /gallery-item/… and /testimonial-item/… routes stop
 *   resolving. Without the flush the old rules survive in the options table and keep serving.
 *
 *   (2) «ארבעת עמודי הזרע ... מאשר». The four ea_gallery / ea_testimonial seed items are
 *   published placeholders whose visible body is our own internal build notes
 *   («בלי אישור 100», «לפי החלטת 100»). Unlike the ea_faq items they feed nothing: /galleries/
 *   and /testimonials/ do not render them. They are trashed here, not force-deleted, so the
 *   decision stays reversible from the WordPress trash.
 *
 *   The two ea_faq seed items this plugin's ancestor created (ea-m3-seed-faq-1|2) are already
 *   gone — confirmed live, zero PLACEHOLDER items in ea_faq and zero on /faq/ — so they are
 *   deliberately not listed below. ea-m3-seed-instances-once.php stays on disk and stays
 *   flag-guarded; it cannot recreate these because its own option guard is already 'done'.
 *
 *   Idempotent and flag-guarded. Resolves by slug, never by a hardcoded post ID, so it
 *   survives a DB re-seed.
 *
 * Version: 1.0.0
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * The four seed items to retire, as post_type => list of post_name.
 *
 * @return array
 */
function ea_s007_retire_seed_map() {
	return array(
		'ea_gallery'     => array( 'ea-m3-seed-gallery-1', 'ea-m3-seed-gallery-2' ),
		'ea_testimonial' => array( 'ea-m3-seed-testimonial-1', 'ea-m3-seed-testimonial-2' ),
	);
}

add_action(
	'init',
	function () {
		$flag = 'ea_s007_cpt_singles_retired_v1';
		if ( 'done' === get_option( $flag ) ) {
			return;
		}
		if ( wp_installing() ) {
			return;
		}
		/* The CPTs must already be registered, or get_posts() below returns nothing and the
		   flag would record a no-op as success. */
		if ( ! post_type_exists( 'ea_gallery' ) || ! post_type_exists( 'ea_testimonial' ) ) {
			return;
		}

		$trashed = array();
		$missing = array();
		foreach ( ea_s007_retire_seed_map() as $post_type => $slugs ) {
			foreach ( $slugs as $slug ) {
				$found = get_posts(
					array(
						'post_type'        => $post_type,
						'name'             => $slug,
						'post_status'      => array( 'publish', 'draft', 'pending', 'private' ),
						'numberposts'      => 1,
						'suppress_filters' => false,
					)
				);
				if ( empty( $found ) ) {
					$missing[] = $post_type . '/' . $slug;
					continue;
				}
				if ( wp_trash_post( (int) $found[0]->ID ) ) {
					$trashed[] = $post_type . '/' . $slug;
				}
			}
		}

		/* Retire the single URLs themselves. functions.php now registers all three instance
		   CPTs non-public; the rules generated while they were public live on until flushed. */
		flush_rewrite_rules( false );

		update_option(
			'ea_s007_cpt_singles_retired_result',
			array(
				'trashed' => $trashed,
				'missing' => $missing,
				'ran_at'  => current_time( 'mysql' ),
			)
		);
		update_option( $flag, 'done' );
	},
	20
);
