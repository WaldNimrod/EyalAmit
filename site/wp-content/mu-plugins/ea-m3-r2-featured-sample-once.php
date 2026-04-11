<?php
/**
 * Plugin Name: EA M3 — R2 דגימת featured + alt לגלריות (פעם אחת)
 * Description: יוצר קובץ JPEG קטן (&lt;150KB), מצמיד ל־ea-m3-seed-gallery-1/2, מגדיר alt. איפוס: delete_option('ea_m3_r2_featured_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return string|false JPEG binary.
 */
function ea_m3_r2_build_sample_jpeg() {
	if ( ! function_exists( 'imagecreatetruecolor' ) || ! function_exists( 'imagejpeg' ) ) {
		return false;
	}
	$w = 360;
	$h = 220;
	$im = imagecreatetruecolor( $w, $h );
	if ( ! $im ) {
		return false;
	}
	$sand = imagecolorallocate( $im, 216, 199, 181 );
	imagefilledrectangle( $im, 0, 0, $w, $h, $sand );
	$accent = imagecolorallocate( $im, 164, 78, 43 );
	imagefilledellipse( $im, (int) ( $w / 2 ), (int) ( $h / 2 ), 120, 120, $accent );
	ob_start();
	imagejpeg( $im, null, 82 );
	$bin = ob_get_clean();
	imagedestroy( $im );
	return is_string( $bin ) ? $bin : false;
}

/**
 * @param string $filename basename.
 * @param string $binary   JPEG bytes.
 * @return int Attachment ID or 0.
 */
function ea_m3_r2_sideload_jpeg( $filename, $binary ) {
	if ( $binary === '' || ! function_exists( 'wp_upload_bits' ) ) {
		return 0;
	}
	$upload = wp_upload_bits( $filename, null, $binary );
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}
	$file = $upload['file'];
	$wp_filetype = wp_check_filetype( $filename, null );
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'] ? $wp_filetype['type'] : 'image/jpeg',
		'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	);
	$attach_id = wp_insert_attachment( $attachment, $file );
	if ( is_wp_error( $attach_id ) || $attach_id < 1 ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$meta = wp_generate_attachment_metadata( $attach_id, $file );
	wp_update_attachment_metadata( $attach_id, $meta );
	return (int) $attach_id;
}

function ea_m3_r2_featured_maybe_run() {
	if ( get_option( 'ea_m3_r2_featured_v1', '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( ! post_type_exists( 'ea_gallery' ) ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_m3_r2_featured_lock' ) ) {
		return;
	}
	set_transient( 'ea_m3_r2_featured_lock', 1, 120 );

	try {
		$jpeg = ea_m3_r2_build_sample_jpeg();
		if ( $jpeg === false || strlen( $jpeg ) > 150000 ) {
			return;
		}

		$pairs = array(
			'ea-m3-seed-gallery-1' => 'דוגמת גלריה M3 — כרטיס קטלוג (רקע חול מיתוג)',
			'ea-m3-seed-gallery-2'   => 'דוגמת גלריה שנייה — מחיצה לבדיקת משקל ו־alt',
		);

		$i = 0;
		foreach ( $pairs as $slug => $alt ) {
			++$i;
			$posts = get_posts(
				array(
					'post_type'      => 'ea_gallery',
					'name'           => $slug,
					'post_status'    => 'any',
					'posts_per_page' => 1,
					'fields'         => 'ids',
				)
			);
			if ( empty( $posts ) ) {
				continue;
			}
			$pid = (int) $posts[0];
			if ( get_post_thumbnail_id( $pid ) > 0 ) {
				continue;
			}
			$fname = 'ea-m3-r2-sample-' . $i . '.jpg';
			$aid   = ea_m3_r2_sideload_jpeg( $fname, $jpeg );
			if ( $aid < 1 ) {
				continue;
			}
			update_post_meta( $aid, '_wp_attachment_image_alt', $alt );
			set_post_thumbnail( $pid, $aid );
		}

		update_option( 'ea_m3_r2_featured_v1', 'done' );
	} finally {
		delete_transient( 'ea_m3_r2_featured_lock' );
	}
}

add_action( 'init', 'ea_m3_r2_featured_maybe_run', 30 );
