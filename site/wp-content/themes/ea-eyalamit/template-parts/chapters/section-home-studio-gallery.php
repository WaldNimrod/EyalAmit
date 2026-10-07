<?php
/**
 * Home — the old studio gallery, closed until the visitor opens it.
 * Source: Gallery/גלריה-דיגרידו-סטודיו-נשימה-מעגלית (Envira 17793),
 * the same files already stored for the admin galleries page.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_file  = get_stylesheet_directory() . '/inc/data/old-home-gallery.json';
$ea_items = array();
if ( is_readable( $ea_file ) ) {
	$ea_rows = json_decode( (string) file_get_contents( $ea_file ), true );
	if ( is_array( $ea_rows ) ) {
		foreach ( $ea_rows as $ea_row ) {
			$file = isset( $ea_row['file'] ) ? ltrim( (string) $ea_row['file'], '/' ) : '';
			if ( '' === $file ) {
				continue;
			}
			$ea_items[] = array(
				'image' => 'assets/images/' . $file,
				'alt'   => isset( $ea_row['alt'] ) ? (string) $ea_row['alt'] : '',
			);
		}
	}
}
if ( ! $ea_items ) {
	return;
}

get_template_part(
	'template-parts/chapters/parts/gallery',
	null,
	array(
		'id'               => 'home-didg-gallery',
		'alt'              => false,
		'accordion'        => true,
		'accordion_label'  => 'לפתיחת הגלריה',
		'items'            => $ea_items,
	)
);
