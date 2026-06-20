<?php
/**
 * Plugin Name: EA W2-14-E — מוקש דהימן: זריעת 19 תמונות לספריית המדיה (פעם אחת)
 * Description: מייבא את 19 תמונות עמוד ההנצחה (מצורפות תחת התבנית assets/images/mokesh/) לספריית המדיה, בסדר המקורי, ושומר את מזהי הקבצים ב-option ea_mokesh_photo_ids שהרנדרר קורא. אידמפוטנטי ומרפא-עצמו. איפוס: delete_option('ea_mokesh_photo_ids'); delete_option('ea_mokesh_media_map').
 * Version: 1.0.0
 *
 * Photos chosen for the media-library route (Nimrod 2026-06-21) over hot-linking
 * or theme-asset hot-references: proper attachments give WP-generated srcset, alt
 * management and media-manager visibility for Eyal. Source files bundle under the
 * theme (deployed recursively); this seeder copies them into uploads as attachments.
 */

defined( 'ABSPATH' ) || exit;

const EA_MOKESH_PHOTO_COUNT = 19;

/**
 * Import one bundled JPEG into the media library.
 *
 * @param string $path     Absolute source path under the theme.
 * @param string $filename Target upload basename (ASCII).
 * @param string $alt      Alt text.
 * @param string $title    Attachment title.
 * @param int    $idx      1-based memorial order index (stored as meta).
 * @return int Attachment ID, or 0 on failure.
 */
function ea_w2_14e_mokesh_import( $path, $filename, $alt, $title, $idx ) {
	if ( ! is_readable( $path ) || ! function_exists( 'wp_upload_bits' ) ) {
		return 0;
	}
	$bin = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	if ( false === $bin || '' === $bin ) {
		return 0;
	}
	$upload = wp_upload_bits( $filename, null, $bin );
	if ( ! empty( $upload['error'] ) || empty( $upload['file'] ) ) {
		return 0;
	}
	$file        = $upload['file'];
	$wp_filetype = wp_check_filetype( $filename, null );
	$attachment  = array(
		'post_mime_type' => $wp_filetype['type'] ? $wp_filetype['type'] : 'image/jpeg',
		'post_title'     => $title,
		'post_content'   => '',
		'post_status'    => 'inherit',
	);
	$aid = wp_insert_attachment( $attachment, $file );
	if ( is_wp_error( $aid ) || $aid < 1 ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$meta = wp_generate_attachment_metadata( $aid, $file );
	wp_update_attachment_metadata( $aid, $meta );
	update_post_meta( $aid, '_wp_attachment_image_alt', $alt );
	update_post_meta( $aid, '_ea_mokesh_idx', (int) $idx );
	return (int) $aid;
}

/**
 * Seed (or repair) the 19 memorial photos. Runs until the ordered list is complete.
 */
function ea_w2_14e_mokesh_media_maybe_run() {
	if ( wp_installing() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	$existing = get_option( 'ea_mokesh_photo_ids', array() );
	if ( is_array( $existing ) && count( $existing ) >= EA_MOKESH_PHOTO_COUNT ) {
		return; // complete
	}
	if ( get_transient( 'ea_mokesh_media_lock' ) ) {
		return;
	}
	set_transient( 'ea_mokesh_media_lock', 1, 300 );

	try {
		$dir = trailingslashit( get_stylesheet_directory() ) . 'assets/images/mokesh/';
		if ( ! is_dir( $dir ) ) {
			return;
		}

		// index => attachment id (self-healing across runs).
		$map = get_option( 'ea_mokesh_media_map', array() );
		if ( ! is_array( $map ) ) {
			$map = array();
		}

		for ( $i = 1; $i <= EA_MOKESH_PHOTO_COUNT; $i++ ) {
			$have = isset( $map[ $i ] ) ? (int) $map[ $i ] : 0;
			if ( $have > 0 && 'attachment' === get_post_type( $have ) ) {
				continue; // already imported and present
			}
			$src = $dir . sprintf( 'mokesh-%02d.jpeg', $i );
			$alt = sprintf( 'מוקש דהימן — רישיקש, הודו · Jungle Vibes (תמונה %d)', $i );
			$aid = ea_w2_14e_mokesh_import(
				$src,
				sprintf( 'mukesh-dhiman-rishikesh-%02d.jpeg', $i ),
				$alt,
				sprintf( 'מוקש דהימן — רישיקש (%d)', $i ),
				$i
			);
			if ( $aid > 0 ) {
				$map[ $i ] = $aid;
			}
		}

		update_option( 'ea_mokesh_media_map', $map, false );

		// Ordered, gap-free flat list for the renderer.
		$ordered = array();
		for ( $i = 1; $i <= EA_MOKESH_PHOTO_COUNT; $i++ ) {
			if ( ! empty( $map[ $i ] ) ) {
				$ordered[] = (int) $map[ $i ];
			}
		}
		update_option( 'ea_mokesh_photo_ids', $ordered, false );
	} finally {
		delete_transient( 'ea_mokesh_media_lock' );
	}
}

add_action( 'init', 'ea_w2_14e_mokesh_media_maybe_run', 31 );
