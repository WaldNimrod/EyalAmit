<?php
/**
 * Plugin Name: EA W2-10 — repoint nav "תיקון וחידוש" to canonical /repair/ (once)
 * Description: F-W2-05-01: a primary-nav menu item linked the LEGACY page /tools-and-accessories/repair/ (page id 65, child of tools-and-accessories) instead of the canonical top-level /repair/ (page id 293). Repoints any nav_menu_item referencing the legacy page to the canonical page. Reset: delete_option('ea_w2_10_nav_repair_canonical_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', 'ea_w2_10_nav_repair_canonical' );
add_action( 'init', 'ea_w2_10_nav_repair_canonical' );

function ea_w2_10_nav_repair_canonical() {
	if ( get_option( 'ea_w2_10_nav_repair_canonical_v1' ) ) {
		return;
	}

	$canonical = get_page_by_path( 'repair' );                          // top-level /repair/ (canonical)
	$legacy    = get_page_by_path( 'tools-and-accessories/repair' );    // legacy nested page

	if ( $canonical && $legacy && $canonical->ID !== $legacy->ID ) {
		$items = get_posts( array(
			'post_type'   => 'nav_menu_item',
			'numberposts' => -1,
			'post_status' => 'any',
			'meta_key'    => '_menu_item_object_id',
			'meta_value'  => (string) $legacy->ID,
		) );
		foreach ( $items as $item ) {
			if ( 'page' === get_post_meta( $item->ID, '_menu_item_object', true ) ) {
				update_post_meta( $item->ID, '_menu_item_object_id', (string) $canonical->ID );
			}
		}
	}

	update_option( 'ea_w2_10_nav_repair_canonical_v1', gmdate( 'c' ), false );
}
