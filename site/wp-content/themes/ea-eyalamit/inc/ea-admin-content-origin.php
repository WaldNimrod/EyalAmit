<?php
/**
 * Tell the editor, on the edit screen itself, where this page's content actually comes from.
 *
 * Why this exists. Measured 2026-09-27 across the whole published population: the body editor
 * has no effect on any of the 52 core pages, because the Chapters templates never call
 * the_content(). Twelve of those pages additionally held leftover text in the editor that was
 * not on the site — someone could open /terms/, see 55 words, correct them, save, change
 * nothing, and reasonably believe they had fixed it. That text has since been cleared, which
 * stops the lie but leaves an empty box with no explanation.
 *
 * So the box explains itself. Admin only: this adds nothing to the front end and renders on no
 * public page.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Is this page rendered by Chapters, and does its body editor therefore do nothing?
 *
 * @param int $post_id Page id.
 * @return string Chapters type, or '' when the page renders normally.
 */
function ea_admin_content_origin_type( $post_id ) {
	if ( ! function_exists( 'ea_chapters_route_map' ) ) {
		return '';
	}
	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		return '';
	}
	$path = trim( (string) get_page_uri( $post ), '/' );
	$map  = ea_chapters_route_map();
	foreach ( array( $path, $post->post_name ) as $key ) {
		if ( isset( $map[ $key ] ) ) {
			$entry = $map[ $key ];
			return is_array( $entry ) ? (string) $entry['type'] : (string) $entry;
		}
	}
	return '';
}

/**
 * Print the notice on the page edit screen.
 *
 * @return void
 */
function ea_admin_content_origin_notice() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'page' !== $screen->id ) {
		return;
	}
	$post_id = isset( $_GET['post'] ) ? absint( wp_unslash( $_GET['post'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only notice.
	if ( ! $post_id ) {
		return;
	}

	$type = ea_admin_content_origin_type( $post_id );
	if ( '' === $type ) {
		echo '<div class="notice notice-success"><p><strong>'
			. esc_html__( 'העמוד הזה נערך כרגיל.', 'ea-eyalamit' ) . '</strong> '
			. esc_html__( 'מה שתכתוב כאן יופיע באתר, והעמוד יקבל את התפריט והפוטר של האתר.', 'ea-eyalamit' )
			. '</p></div>';
		return;
	}

	$frozen = function_exists( 'ea_chapters_seeded_only_types' )
		&& in_array( $type, ea_chapters_seeded_only_types(), true );

	echo '<div class="notice notice-warning"><p><strong>'
		. esc_html__( 'שימו לב — תיבת התוכן הזו אינה משפיעה על העמוד.', 'ea-eyalamit' )
		. '</strong> '
		. esc_html__( 'העמוד הזה מצויר בתבנית ייעודית שאינה קוראת את תיבת התוכן. מה שייכתב כאן יישמר ולא יופיע לגולשים.', 'ea-eyalamit' )
		. '</p><p>';

	if ( $frozen ) {
		echo esc_html__( 'התוכן שלו מגיע כרגע מקובץ בתוך התבנית, ולכן שינוי דורש פנייה לצוות.', 'ea-eyalamit' )
			. ' <em>' . esc_html( $type ) . '</em>';
	} else {
		echo esc_html__( 'את התוכן שלו עורכים בשדות המובנים שמופיעים מתחת לתיבה הזו, ולא בתיבה עצמה.', 'ea-eyalamit' );
	}

	echo '</p></div>';
}
add_action( 'admin_notices', 'ea_admin_content_origin_notice' );
