<?php
/**
 * Plugin Name: EA W2-10 — set author display name (once)
 * Description: Blog bylines showed the login "eyaladmin" instead of "אייל עמית" (WP-W2-10-D Q1). Sets the display_name + nickname of the eyaladmin user once. Reset: delete_option('ea_w2_10_author_displayname_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', 'ea_w2_10_fix_author_displayname' );
add_action( 'init', 'ea_w2_10_fix_author_displayname' );

function ea_w2_10_fix_author_displayname() {
	if ( get_option( 'ea_w2_10_author_displayname_v1' ) ) {
		return;
	}

	$target = 'אייל עמית';
	$user   = get_user_by( 'login', 'eyaladmin' );

	// Fallback: any user whose display_name is still a login-like "eyaladmin".
	if ( ! $user ) {
		$found = get_users( array( 'search' => 'eyaladmin', 'search_columns' => array( 'user_login', 'display_name' ), 'number' => 1 ) );
		$user  = $found ? $found[0] : null;
	}

	if ( $user && 'WP_User' === get_class( $user ) ) {
		wp_update_user( array(
			'ID'           => $user->ID,
			'display_name' => $target,
			'nickname'     => $target,
		) );
	}

	// Mark done even if the user was absent, so this never re-runs on every load.
	update_option( 'ea_w2_10_author_displayname_v1', gmdate( 'c' ), false );
}
