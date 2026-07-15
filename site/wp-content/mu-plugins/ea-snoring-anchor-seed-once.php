<?php
/**
 * Plugin Name: EA — seed snoring/sleep-apnea pillar page (once)
 * Description: Creates top-level published page /snoring-sleep-apnea/ for Chapters route map. Content from theme defaults. Reset: delete_option('ea_snoring_anchor_seed_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * @param string $title
 * @param string $slug
 * @return int|\WP_Error
 */
function ea_snoring_anchor_seed_get_or_create_page( $title, $slug ) {
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
 * Runs once on admin/front after deploy.
 */
function ea_snoring_anchor_seed_maybe_run() {
	if ( get_option( 'ea_snoring_anchor_seed_v1', '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_snoring_anchor_seed_lock' ) ) {
		return;
	}
	set_transient( 'ea_snoring_anchor_seed_lock', 1, 120 );

	try {
		$result = ea_snoring_anchor_seed_get_or_create_page(
			'דיג׳רידו, נחירות ודום נשימה בשינה',
			'snoring-sleep-apnea'
		);
		if ( ! is_wp_error( $result ) ) {
			update_option( 'ea_snoring_anchor_seed_v1', 'done', false );
		}
	} finally {
		delete_transient( 'ea_snoring_anchor_seed_lock' );
	}
}

add_action( 'init', 'ea_snoring_anchor_seed_maybe_run', 30 );
