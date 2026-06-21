<?php
/**
 * Chapters (פרקים) — theme-native "duplicate page" action (no plugin).
 *
 * Adds a "שכפל" row action on the Pages list that clones a page as a draft,
 * copying its template assignment (_wp_page_template) and all post meta —
 * including every ACF field + its _fieldkey companion — so the clone keeps the
 * same template and its content. This is how Eyal spins up new pages on an
 * existing template without touching code.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add the "שכפל" link to page row actions.
 *
 * @param array   $actions
 * @param WP_Post $post
 * @return array
 */
function ea_chapters_duplicate_row_action( $actions, $post ) {
	if ( 'page' === $post->post_type && current_user_can( 'edit_pages' ) ) {
		$url = wp_nonce_url(
			admin_url( 'admin-post.php?action=ea_chapters_duplicate&post=' . (int) $post->ID ),
			'ea_chapters_dup_' . (int) $post->ID
		);
		$actions['ea_chapters_duplicate'] = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'שכפל', 'ea-eyalamit' ) . '</a>';
	}
	return $actions;
}
add_filter( 'page_row_actions', 'ea_chapters_duplicate_row_action', 10, 2 );

/**
 * Handle the duplicate request: capability + nonce checked, clone as draft,
 * copy template + all meta, redirect to the editor.
 */
function ea_chapters_do_duplicate() {
	$src_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0;
	$nonce  = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';

	if ( ! $src_id || ! current_user_can( 'edit_pages' ) || ! wp_verify_nonce( $nonce, 'ea_chapters_dup_' . $src_id ) ) {
		wp_die( esc_html__( 'פעולה לא מורשית.', 'ea-eyalamit' ) );
	}

	$src = get_post( $src_id );
	if ( ! $src || 'page' !== $src->post_type ) {
		wp_die( esc_html__( 'העמוד לא נמצא.', 'ea-eyalamit' ) );
	}

	$new_id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'draft',
			'post_title'   => $src->post_title . ' ' . __( '(עותק)', 'ea-eyalamit' ),
			'post_content' => $src->post_content,
			'post_excerpt' => $src->post_excerpt,
			'post_parent'  => $src->post_parent,
			'menu_order'   => $src->menu_order,
			'post_author'  => get_current_user_id(),
		),
		true
	);

	if ( is_wp_error( $new_id ) || ! $new_id ) {
		wp_die( esc_html__( 'יצירת העותק נכשלה.', 'ea-eyalamit' ) );
	}

	// Copy all meta (template assignment + ACF values and their _fieldkey companions).
	$skip = array( '_edit_lock', '_edit_last', '_wp_old_slug' );
	foreach ( get_post_meta( $src_id ) as $key => $values ) {
		if ( in_array( $key, $skip, true ) ) {
			continue;
		}
		foreach ( $values as $value ) {
			add_post_meta( $new_id, $key, maybe_unserialize( $value ) );
		}
	}

	wp_safe_redirect( admin_url( 'post.php?action=edit&post=' . (int) $new_id ) );
	exit;
}
add_action( 'admin_post_ea_chapters_duplicate', 'ea_chapters_do_duplicate' );
