<?php
/**
 * Plugin Name: EA M2 — זריעת מעטפת (פעם אחת)
 * Description: סימון תאימות ישנה בלבד. IA, עמודים ותפריטים — ea-m2-site-tree-lock-sync-once.php (init 28). תיקון Fluent ב-contact: init 32. איפוס זריעה: delete_option('ea_m2_shell_seed_v1').
 * Version: 1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Runs once per site when option is not set — כבר לא יוצר עמודים/תפריט legacy (עץ נעול).
 */
function ea_m2_seed_shell_maybe_run() {
	if ( get_option( 'ea_m2_shell_seed_v1', '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_m2_seed_shell_lock' ) ) {
		return;
	}
	set_transient( 'ea_m2_seed_shell_lock', 1, 120 );

	try {
		ea_m2_seed_shell_run();
		update_option( 'ea_m2_shell_seed_v1', 'done' );
	} finally {
		delete_transient( 'ea_m2_seed_shell_lock' );
	}
}

/**
 * ריק מכוון — סנכרון העץ (MU) אחראי על מלאי M2.
 */
function ea_m2_seed_shell_run() {
}

add_action( 'init', 'ea_m2_seed_shell_maybe_run', 25 );

/**
 * Ensure Reading settings match M2 pages (fixes cache / partial runs / option mismatch).
 */
function ea_m2_ensure_reading_settings() {
	$home = get_page_by_path( 'home', OBJECT, 'page' );
	$blog = get_page_by_path( 'blog', OBJECT, 'page' );
	if ( ! $home || ! $blog ) {
		return;
	}
	$want_front = (int) $home->ID;
	$want_posts = (int) $blog->ID;
	$cur        = (int) get_option( 'page_on_front', 0 );
	if ( get_option( 'show_on_front', '' ) !== 'page' || $cur !== $want_front ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $want_front );
		update_option( 'page_for_posts', $want_posts );
	}
}
add_action( 'init', 'ea_m2_ensure_reading_settings', 30 );

/**
 * Repair contact page if Fluent shortcode was stored with HTML entities (shortcode then renders as plain text).
 */
function ea_m2_repair_contact_fluent_shortcode() {
	$page = get_page_by_path( 'contact', OBJECT, 'page' );
	if ( ! $page || $page->post_status !== 'publish' ) {
		return;
	}
	$c   = $page->post_content;
	$new = str_replace(
		array( '[fluentform id=&quot;1&quot;]', '[fluentform id=&#8221;1&#8221;]', '[fluentform id="1"]' ),
		'[fluentform id=1]',
		$c
	);
	if ( $new !== $c ) {
		wp_update_post(
			array(
				'ID'           => (int) $page->ID,
				'post_content' => $new,
			)
		);
	}
}
add_action( 'init', 'ea_m2_repair_contact_fluent_shortcode', 32 );

/**
 * Render Fluent on contact: core do_shortcode (11) skips tags with HTML entities / bad quotes — fix after 11.
 */
function ea_m2_contact_fluent_the_content_fix( $content ) {
	if ( ! is_singular( 'page' ) ) {
		return $content;
	}
	$post = get_queried_object();
	if ( ! $post instanceof WP_Post || $post->post_name !== 'contact' ) {
		return $content;
	}
	if ( ! preg_match( '/\[fluentform[^\]]+\]/i', $content ) ) {
		return $content;
	}
	// Single form on this page — normalize any broken tag to canonical shortcode output.
	return (string) preg_replace_callback(
		'/\[fluentform[^\]]+\]/i',
		static function () {
			return do_shortcode( '[fluentform id=1]' );
		},
		$content,
		1
	);
}
add_filter( 'the_content', 'ea_m2_contact_fluent_the_content_fix', 12 );
