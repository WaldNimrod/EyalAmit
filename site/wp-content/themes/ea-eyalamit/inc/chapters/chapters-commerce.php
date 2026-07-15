<?php
/**
 * Chapters-owned home for commerce accessors that must survive Wave2 deletion (T6).
 * Relocated verbatim — WP-CANON-TEMPLATE-UNIFICATION T6, closing team_90 F90-01/F90-02.
 * Consumers: product-cta.php (T3); phero/cta cta_slug (T3b) via ea-book-purchase.js.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

// --- from inc/wave2-w2-05.php (verbatim + function_exists guards for dual-load window) ---
if ( ! function_exists( 'ea_w2_05_gi_url_map' ) ) {
	/**
	 * @return array<string,string>
	 */
	function ea_w2_05_gi_url_map() {
		// Temporary shared GI example (kushi Morning) until per-SKU mrng.to URLs — team_00 2026-07-14.
		return array(
			'didgeridoos'    => 'https://mrng.to/MTUiO3vkIg',
			'bags'           => 'https://mrng.to/MTUiO3vkIg',
			'stands-storage' => 'https://mrng.to/MTUiO3vkIg',
			'stand-floor'    => 'https://mrng.to/MTUiO3vkIg',
			'repair'         => 'https://mrng.to/MTUiO3vkIg',
		);
	}
}
if ( ! function_exists( 'ea_w2_05_gi_url' ) ) {
	/**
	 * @param string $slug Product slug.
	 * @return string
	 */
	function ea_w2_05_gi_url( $slug ) {
		$map = ea_w2_05_gi_url_map();
		return isset( $map[ $slug ] ) ? trim( (string) $map[ $slug ] ) : '';
	}
}
if ( ! function_exists( 'ea_w2_05_price' ) ) {
	/**
	 * @param int $post_id Product page ID.
	 * @return string
	 */
	function ea_w2_05_price( $post_id ) {
		$price = get_post_meta( $post_id, 'ea_product_price', true );
		$price = is_string( $price ) ? trim( $price ) : '';
		return '' !== $price ? $price : 'מחיר לפי התאמה';
	}
}

// --- from inc/wave2-stage-b.php (verbatim — D90-01) ---
if ( ! defined( 'EA_WAVE2_WHATSAPP_E164' ) ) {
	define( 'EA_WAVE2_WHATSAPP_E164', '972524822842' );
}
if ( ! function_exists( 'ea_wave2_wa_url' ) ) {
	/**
	 * @param string $msg Optional WhatsApp prefill.
	 * @return string
	 */
	function ea_wave2_wa_url( $msg = '' ) {
		$msg = ( '' !== $msg ) ? $msg : 'היי אייל, הגעתי דרך האתר ואשמח לקבל פרטים';
		return 'https://wa.me/' . EA_WAVE2_WHATSAPP_E164 . '?text=' . rawurlencode( $msg );
	}
}

/**
 * Enqueue book purchase GA4 tracker on the three book pages (replaces ea_w2_03_purchase_assets).
 */
function ea_chapters_book_purchase_assets() {
	if ( is_admin() ) {
		return;
	}
	if ( ! is_page( array( 'vekatavta', 'kushi-blantis', 'tsva-bekahol' ) ) ) {
		return;
	}
	wp_enqueue_script(
		'ea-book-purchase',
		get_stylesheet_directory_uri() . '/assets/js/ea-book-purchase.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_chapters_book_purchase_assets', 20 );

/**
 * Enqueue product-page shop CSS (re-homes former wave2-w2-05.php enqueue).
 */
function ea_chapters_w2_05_shop_assets() {
	if ( is_admin() ) {
		return;
	}
	if ( ! is_page( array( 'didgeridoos', 'bags', 'stands-storage', 'stand-floor', 'repair' ) ) ) {
		return;
	}
	wp_enqueue_style(
		'ea-w2-05-shop',
		get_stylesheet_directory_uri() . '/assets/css/w2-05-shop.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'ea_chapters_w2_05_shop_assets', 20 );
