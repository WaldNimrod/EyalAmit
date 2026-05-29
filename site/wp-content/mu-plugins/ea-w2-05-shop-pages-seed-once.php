<?php
/**
 * Plugin Name: EA W2-05 — seed shop pages (once)
 * Description: יוצר עמודי חנות חסרים ברמת השורש (post_parent=0) ליישור מול site-tree.json ולמסלול ה־router של WP-W2-05: didgeridoos, bags, stands-storage, stand-floor, repair (tpl-shop-item) + shop (tpl-shop-archive). תוכן הבלוקים מוזרק ע"י the_content filter בתבנית, כך שה־post_content נשאר ריק. לא מוחק עמודים קיימים. אפס: delete_option('ea_w2_05_shop_pages_v2').
 * Version: 1.0.0
 *
 * Mirrors the established once-only seeder pattern (ea-m2-ia-slug-fixups-once.php).
 * The shop slugs must exist as TOP-LEVEL pages for ea_w2_05_current_slug() to
 * route them (it matches post_parent === 0). FTP deploy cannot create pages, so
 * this runs once on the staging host.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Ensure a top-level published page exists for the given slug.
 *
 * If a page with this slug exists but is nested (post_parent !== 0), it is
 * re-parented to root so the W2-05 router can match it.
 *
 * @param string $title
 * @param string $slug
 * @return int|\WP_Error
 */
function ea_w2_05_seed_get_or_create_page( $title, $slug ) {
	$existing = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $existing instanceof WP_Post ) {
		$updates = array();
		if ( 'publish' !== $existing->post_status ) {
			$updates['post_status'] = 'publish';
		}
		if ( 0 !== (int) $existing->post_parent ) {
			$updates['post_parent'] = 0;
		}
		if ( ! empty( $updates ) ) {
			$updates['ID'] = (int) $existing->ID;
			wp_update_post( $updates );
		}
		return (int) $existing->ID;
	}
	return wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_parent'  => 0,
			'post_content' => '<p></p>',
		),
		true
	);
}

/**
 * Runs once. Separate option so already-seeded sites still get these pages.
 */
function ea_w2_05_shop_pages_maybe_run() {
	if ( get_option( 'ea_w2_05_shop_pages_v2', '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_w2_05_shop_pages_lock' ) ) {
		return;
	}
	set_transient( 'ea_w2_05_shop_pages_lock', 1, 120 );

	try {
		$pages = array(
			'didgeridoos'    => "כלי דיג'רידו למכירה",
			'bags'           => "תיקים לדיג'רידו",
			'stands-storage' => "סטנדים לאחסון דיג'רידו",
			'stand-floor'    => "סטנד רצפתי לנגינה בישיבה נמוכה",
			'repair'         => "תיקון וחידוש דיג'רידו",
			'shop'           => 'חנות',
		);
		foreach ( $pages as $slug => $title ) {
			ea_w2_05_seed_get_or_create_page( $title, $slug );
		}

		// Clear stale _wp_old_slug entries that collide with our shop slugs.
		// A legacy page (e.g. the tools-and-accessories hub) previously used one
		// of these slugs, leaving a _wp_old_slug meta that triggers WordPress'
		// old-slug 301 BEFORE our real page resolves (X-Redirect-By: WordPress).
		// Removing the colliding meta lets the canonical shop page render.
		global $wpdb;
		$slugs = array_keys( $pages );
		foreach ( $slugs as $slug ) {
			$meta_rows = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT post_id, meta_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_old_slug' AND meta_value = %s",
					$slug
				)
			);
			foreach ( (array) $meta_rows as $row ) {
				$owner = get_post( (int) $row->post_id );
				// Only delete when the owning post's CURRENT slug is NOT this slug
				// (i.e. the slug now belongs to a different, canonical page).
				if ( $owner instanceof WP_Post && $owner->post_name !== $slug ) {
					delete_metadata_by_mid( 'post', (int) $row->meta_id );
				}
			}
		}

		update_option( 'ea_w2_05_shop_pages_v2', 'done' );
		flush_rewrite_rules( false );
	} finally {
		delete_transient( 'ea_w2_05_shop_pages_lock' );
	}
}

add_action( 'init', 'ea_w2_05_shop_pages_maybe_run', 27 );
