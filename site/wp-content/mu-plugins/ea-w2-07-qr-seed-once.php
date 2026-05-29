<?php
/**
 * Plugin Name: EA W2-07 — seed QR + press pages (once)
 * Description: יוצר עמוד הורה `qr` ואת 48 עמודי ה־QR (qr1..qr48) תחתיו, עם post_content מהמיגרציה (ea-w2-07-qr-content-data.php), ומשייך לכל אחד את התבנית tpl-qr.php. בנוסף יוצר את עמוד `press` (ברמת השורש). once-only עם דגל ea_w2_07_qr_seeded_v3 ומנעול transient. אינו מוחק עמודים קיימים; מעדכן post_content/template בהרצה חוזרת לאחר reset. אפס: delete_option('ea_w2_07_qr_seeded_v3').
 * Version: 1.0.0
 *
 * Mirrors ea-w2-05-shop-pages-seed-once.php guards (ABSPATH, init hook, option
 * flag, transient lock, idempotent get-or-create, NO wp-load re-require).
 *
 * QR bodies are large + unique, so (unlike W2-05's the_content injection) the
 * real post_content is seeded here from the migrated data file.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Ensure a published page exists with the given slug/parent/template/content.
 * Idempotent: existing pages are re-published + re-parented + content/template
 * refreshed (so a content regen + reset re-applies cleanly).
 *
 * @param string $title
 * @param string $slug
 * @param int    $parent_id
 * @param string $content
 * @param string $template Relative template file (e.g. page-templates/tpl-qr.php) or ''.
 * @return int|\WP_Error
 */
function ea_w2_07_seed_get_or_create_page( $title, $slug, $parent_id, $content, $template = '' ) {
	$existing = get_page_by_path(
		( $parent_id ? trailingslashit( get_post_field( 'post_name', $parent_id ) ) : '' ) . $slug,
		OBJECT,
		'page'
	);
	// Fallback: match by slug + parent directly (path lookup can miss nested).
	if ( ! ( $existing instanceof WP_Post ) ) {
		$q = get_posts( array(
			'post_type'        => 'page',
			'name'             => $slug,
			'post_parent'      => (int) $parent_id,
			'post_status'      => 'any',
			'numberposts'      => 1,
			'suppress_filters' => true,
		) );
		if ( ! empty( $q ) ) {
			$existing = $q[0];
		}
	}

	if ( $existing instanceof WP_Post ) {
		$updates = array( 'ID' => (int) $existing->ID );
		if ( 'publish' !== $existing->post_status ) {
			$updates['post_status'] = 'publish';
		}
		if ( (int) $existing->post_parent !== (int) $parent_id ) {
			$updates['post_parent'] = (int) $parent_id;
		}
		if ( '' !== $content && $existing->post_content !== $content ) {
			$updates['post_content'] = $content;
		}
		if ( count( $updates ) > 1 ) {
			wp_update_post( $updates );
		}
		$id = (int) $existing->ID;
	} else {
		$id = wp_insert_post(
			array(
				'post_title'   => $title,
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_parent'  => (int) $parent_id,
				'post_content' => '' !== $content ? $content : '<p></p>',
			),
			true
		);
		if ( is_wp_error( $id ) ) {
			return $id;
		}
		$id = (int) $id;
	}

	if ( '' !== $template ) {
		update_post_meta( $id, '_wp_page_template', $template );
	}
	return $id;
}

/**
 * Runs once. Seeds parent `qr`, 48 QR children, and root `press` page.
 */
function ea_w2_07_qr_seed_maybe_run() {
	if ( get_option( 'ea_w2_07_qr_seeded_v3', '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_w2_07_qr_seed_lock' ) ) {
		return;
	}
	set_transient( 'ea_w2_07_qr_seed_lock', 1, 300 );

	// Controlled migration of trusted legacy content: the bodies contain
	// YouTube <iframe> embeds that KSES would strip on insert (no logged-in
	// user with unfiltered_html in this init context). Remove KSES filters for
	// the duration of the seed, then restore them.
	$kses_was_active = false !== has_filter( 'content_save_pre', 'wp_filter_post_kses' );
	if ( $kses_was_active ) {
		kses_remove_filters();
	}

	try {
		$data_file = __DIR__ . '/ea-w2-07-qr-content-data.php';
		if ( ! is_readable( $data_file ) ) {
			return; // data not deployed yet; retry next request.
		}
		$pages = include $data_file;
		if ( ! is_array( $pages ) || empty( $pages ) ) {
			return;
		}

		// Parent /qr/ page (no template — its children carry tpl-qr).
		$parent_id = ea_w2_07_seed_get_or_create_page( 'QR', 'qr', 0, '<p></p>', '' );
		if ( is_wp_error( $parent_id ) || ! $parent_id ) {
			return;
		}

		// 48 QR children under /qr/.
		foreach ( $pages as $child_slug => $page ) {
			ea_w2_07_seed_get_or_create_page(
				(string) $page['title'],
				(string) $child_slug,
				(int) $parent_id,
				(string) $page['html'],
				'page-templates/tpl-qr.php'
			);
		}

		// Root /press/ page (content injected by the W2-07 router the_content filter).
		ea_w2_07_seed_get_or_create_page( 'עיתונות', 'press', 0, '<p></p>', '' );

		update_option( 'ea_w2_07_qr_seeded_v3', 'done' );
		flush_rewrite_rules( false );
	} finally {
		if ( $kses_was_active ) {
			kses_init_filters();
		}
		delete_transient( 'ea_w2_07_qr_seed_lock' );
	}
}

add_action( 'init', 'ea_w2_07_qr_seed_maybe_run', 28 );
