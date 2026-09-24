<?php
/**
 * Chapters /galleries/ — images from the old site's homepage Envira gallery
 * (envira-gallery-17793), the set at the bottom of https://www.eyalamit.co.il/.
 * Captions are the attachment titles on that gallery. No sample studio set.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_gallery_items = array();
$ea_gallery_file  = get_stylesheet_directory() . '/inc/data/old-home-gallery.json';
if ( is_readable( $ea_gallery_file ) ) {
	$ea_gallery_rows = json_decode( (string) file_get_contents( $ea_gallery_file ), true );
	if ( is_array( $ea_gallery_rows ) ) {
		foreach ( $ea_gallery_rows as $ea_row ) {
			$file = isset( $ea_row['file'] ) ? ltrim( (string) $ea_row['file'], '/' ) : '';
			if ( '' === $file ) {
				continue;
			}
			$cap = isset( $ea_row['cap'] ) ? (string) $ea_row['cap'] : '';
			$ea_gallery_items[] = array(
				'image' => 'assets/images/' . $file,
				'alt'   => $cap,
				'cap'   => $cap,
			);
		}
	}
}

return array(

	'phero' => array(
		'chap'      => '',
		'title'     => 'גלריות',
		'sub'       => '',
		'media'     => '',
		'media_alt' => '',
	),

	'sections' => array(
		array(
			'part' => 'gallery',
			'args' => array(
				'literal_alt' => true,
				'alt'         => false,
				'items'       => $ea_gallery_items,
			),
		),
	),
);
