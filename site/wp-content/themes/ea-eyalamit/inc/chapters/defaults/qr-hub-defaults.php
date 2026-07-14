<?php
/**
 * Chapters /qr/ hub — link grid to all QR child pages.
 * Reads titles from the same data file that seeded the WP pages (read-only).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_qr_data_file = WPMU_PLUGIN_DIR . '/ea-w2-07-qr-content-data.php';
$ea_qr_items     = array();
if ( is_readable( $ea_qr_data_file ) ) {
	$ea_qr_pages = (array) include $ea_qr_data_file;
	uksort(
		$ea_qr_pages,
		static function ( $a, $b ) {
			return (int) substr( $a, 2 ) <=> (int) substr( $b, 2 );
		}
	);
	foreach ( $ea_qr_pages as $ea_slug => $ea_page ) {
		$ea_qr_items[] = array(
			'title' => isset( $ea_page['title'] ) ? (string) $ea_page['title'] : (string) $ea_slug,
			'url'   => home_url( '/qr/' . $ea_slug . '/' ),
		);
	}
}

return array(
	'phero'    => array(
		'chap'  => 'QR',
		'title' => 'דפי ה-QR',
		'sub'   => 'כל עמוד קשור לקוד QR מודפס באחד הספרים.',
	),
	'sections' => array(
		array(
			'part' => 'bookcard',
			'args' => array(
				'cta_label' => 'לעמוד ה-QR ←',
				'items'     => $ea_qr_items,
				'alt'       => false,
			),
		),
	),
);
