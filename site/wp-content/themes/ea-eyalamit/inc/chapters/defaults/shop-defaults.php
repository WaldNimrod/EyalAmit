<?php
/**
 * Chapters /shop/ — product catalog hub (ported from Wave2 ea_w2_05_render_archive).
 * Product cards are intentionally duplicated (not calling ea_w2_05_*) so T6 can
 * delete wave2-w2-05.php without breaking this page. Prices resolve at runtime
 * from ea_product_price postmeta on each product page.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_shop_defs = array(
	array( 'slug' => 'didgeridoos', 'title' => "כלי דיג'רידו למכירה", 'excerpt' => 'כלים בעבודת יד, מותאמים לצליל ולנשימה.' ),
	array( 'slug' => 'bags', 'title' => "תיקים לדיג'רידו", 'excerpt' => 'הגנה ונשיאה נוחה לכלי, בעבודת יד.' ),
	array( 'slug' => 'stands-storage', 'title' => "סטנדים לאחסון דיג'רידו", 'excerpt' => 'תלייה או עמידה — אחסון יציב ובטוח.' ),
	array( 'slug' => 'stand-floor', 'title' => "סטנד רצפתי לנגינה בישיבה נמוכה", 'excerpt' => 'יציבות ונוחות לנגינה בישיבה על הרצפה.' ),
	array( 'slug' => 'repair', 'title' => "תיקון וחידוש דיג'רידו", 'excerpt' => "שירות תיקון מקצועי לכלי דיג'רידו." ),
);

$ea_shop_items = array();
foreach ( $ea_shop_defs as $d ) {
	$price = '';
	$page  = get_page_by_path( $d['slug'] );
	if ( $page instanceof WP_Post ) {
		$meta  = get_post_meta( $page->ID, 'ea_product_price', true );
		$price = is_string( $meta ) ? trim( $meta ) : '';
	}
	$ea_shop_items[] = array(
		'title' => $d['title'],
		'blurb' => $d['excerpt'],
		'url'   => home_url( '/' . $d['slug'] . '/' ),
		'meta'  => '' !== $price ? $price . ' ₪' : 'מחיר לפי התאמה',
	);
}

return array(
	'phero'    => array(
		'chap'  => 'חנות',
		'title' => "כלים ואביזרים לדיג'רידו",
		'sub'   => 'כלים בעבודת יד, תיקים, סטנדים, וכן שירות תיקון וחידוש.',
	),
	'sections' => array(
		array(
			'part' => 'bookcard',
			'args' => array(
				'chap'       => 'המוצרים',
				'title'      => 'כל המוצרים',
				'cta_label'  => 'לעמוד המוצר ←',
				'items'      => $ea_shop_items,
				'alt'        => false,
			),
		),
	),
);
