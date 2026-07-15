<?php
/**
 * Chapters — product price meta-box (WP-S4-05 §5).
 *
 * The 5 product pages (didgeridoos/bags/stands-storage/stand-floor/repair) and the
 * /shop/ catalog both read the price from postmeta key 'ea_product_price' (string;
 * plain shekel number, e.g. '1450') via ea_w2_05_price() (chapters-commerce.php) —
 * confirmed the ONLY storage path; there was previously no wp-admin UI to write it,
 * which is why the price could not be edited. This file is that UI: a plain
 * meta-box (no ACF dependency at all — postmeta, not a field group), nonce +
 * capability guarded. An empty value deletes the meta so the page falls back to
 * "מחיר לפי התאמה" (ea_w2_05_price()'s own existing fallback) — never a blank/broken
 * price line.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action( 'add_meta_boxes', 'ea_product_price_add_box' );
add_action( 'save_post_page', 'ea_product_price_save', 10, 2 );

/**
 * The 5 product-page slugs this meta-box applies to (WP-S4-05 confirmed scope).
 *
 * @param WP_Post $post
 * @return bool
 */
function ea_product_price_is_product( $post ) {
	$slug = get_post_field( 'post_name', $post );
	return in_array( $slug, array( 'didgeridoos', 'bags', 'stands-storage', 'stand-floor', 'repair' ), true );
}

/**
 * Register the meta-box on every 'page' (rendered content is conditional — see
 * ea_product_price_render()) so it is available regardless of admin screen order.
 */
function ea_product_price_add_box() {
	add_meta_box( 'ea_product_price', 'מחיר מוצר (₪)', 'ea_product_price_render', 'page', 'side', 'high' );
}

/**
 * Render the meta-box body. Non-product pages get a short explanatory note
 * instead of the input (no nonce field either, so save() has nothing to process).
 *
 * @param WP_Post $post
 */
function ea_product_price_render( $post ) {
	if ( ! ea_product_price_is_product( $post ) ) {
		echo '<p>שדה מחיר פעיל בעמודי מוצר בלבד.</p>';
		return;
	}
	wp_nonce_field( 'ea_product_price_save', 'ea_product_price_nonce' );
	$v = esc_attr( (string) get_post_meta( $post->ID, 'ea_product_price', true ) );
	echo '<label for="ea_product_price_f">מחיר בש"ח (ריק = "מחיר לפי התאמה")</label>';
	echo '<input type="text" inputmode="numeric" id="ea_product_price_f" name="ea_product_price_f" value="' . $v . '" style="width:100%" />';
}

/**
 * Save handler: nonce + autosave + edit_page capability guarded, product-slug
 * scoped. Strips everything but digits/dot; empty input deletes the meta key
 * entirely (so ea_w2_05_price()'s own '' check falls back to the "by arrangement"
 * copy — this file never writes an empty string).
 *
 * @param int     $post_id
 * @param WP_Post $post
 */
function ea_product_price_save( $post_id, $post ) {
	if ( ! isset( $_POST['ea_product_price_nonce'] ) || ! wp_verify_nonce( $_POST['ea_product_price_nonce'], 'ea_product_price_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	if ( ! ea_product_price_is_product( $post ) ) {
		return;
	}
	$raw = isset( $_POST['ea_product_price_f'] ) ? sanitize_text_field( wp_unslash( $_POST['ea_product_price_f'] ) ) : '';
	$raw = preg_replace( '/[^\d.]/', '', $raw ); // Digits + dot only.
	if ( '' === $raw ) {
		delete_post_meta( $post_id, 'ea_product_price' );
	} else {
		update_post_meta( $post_id, 'ea_product_price', $raw );
	}
}
