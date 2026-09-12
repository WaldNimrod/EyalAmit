<?php
/**
 * Plugin Name: EA W2-15 — Contact Form 7 seeder (once) + form_id wiring
 * Description: Creates the site contact form programmatically (Contact Form 7 is
 *   active on the server) and wires it to the Wave2 contact template via the
 *   `ea_wave2_cf7_form_id` filter. This is a build/admin task (team_100), NOT
 *   content from Eyal — submissions go to the site admin email (Eyal's on prod).
 *   Closes WP-W2-15 materials item C1 (was: "form_id=0, placeholder shown").
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

// Bump to re-apply the form definition to the already-seeded form. 2 = D-8 dropdown.
if ( ! defined( 'EA_W2_15_CF7_REV' ) ) {
	define( 'EA_W2_15_CF7_REV', 2 );
}

/**
 * Ensure the contact form exists; return its post ID (0 if CF7 not available yet).
 */
function ea_w2_15_cf7_ensure_form() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return 0;
	}

	/*
	 * S006 D-8 · team_00 2026-09-12 — «נושא» becomes a dropdown and the mail subject
	 * is built from the selection plus a fixed phrase.
	 *
	 * The original guard returned an existing form untouched, so editing the template
	 * here could never reach a site that had already been seeded — which is why the
	 * free-text subject field stayed live long after we thought we had removed it.
	 * The definition is versioned now: the same form id is kept, and its properties
	 * are re-applied whenever EA_W2_15_CF7_REV moves. Bump the constant to ship a
	 * change; leave it alone and this stays a no-op on every request.
	 */
	$existing = (int) get_option( 'ea_w2_15_cf7_form_id', 0 );
	$rev_seen = (int) get_option( 'ea_w2_15_cf7_rev', 0 );
	if ( $existing > 0 ) {
		$p = get_post( $existing );
		if ( $p && 'wpcf7_contact_form' === $p->post_type && 'trash' !== $p->post_status ) {
			if ( $rev_seen >= EA_W2_15_CF7_REV ) {
				return $existing;
			}
		} else {
			$existing = 0;
		}
	}

	$host        = (string) wp_parse_url( home_url(), PHP_URL_HOST );
	$admin_email = get_option( 'admin_email' );
	$blogname    = wp_specialchars_decode( (string) get_option( 'blogname' ), ENT_QUOTES );

	$form_markup =
		'<div class="ea-cf7">' . "\n" .
		'<p class="ea-cf7-row"><label>שם מלא<br />[text* your-name autocomplete:name placeholder "שם מלא"]</label></p>' . "\n" .
		'<p class="ea-cf7-row"><label>טלפון<br />[tel your-phone autocomplete:tel placeholder "טלפון"]</label></p>' . "\n" .
		'<p class="ea-cf7-row"><label>אימייל<br />[email* your-email autocomplete:email placeholder "אימייל"]</label></p>' . "\n" .
		'<p class="ea-cf7-row"><label>נושא<br />[select* your-subject "טיפול בדיג\'רידו" "שיעורי נגינה" "סאונד הילינג" "רכישת כלי" "רכישת ספר" "תיקון כלי" "אחר"]</label></p>' . "\n" .
		'<p class="ea-cf7-row"><label>הודעה<br />[textarea your-message placeholder "ספרו לנו במה נוכל לעזור"]</label></p>' . "\n" .
		'<p class="ea-cf7-submit">[submit "שליחה"]</p>' . "\n" .
		'</div>';

	$mail = array(
		'active'             => true,
		'subject'            => '[your-subject] — פניה מטופס צור קשר באתר',
		'sender'             => sprintf( '%s <wordpress@%s>', $blogname, $host ),
		'recipient'          => $admin_email,
		'body'               => "פנייה חדשה מאתר אייל עמית:\n\n"
			. "שם: [your-name]\n"
			. "טלפון: [your-phone]\n"
			. "אימייל: [your-email]\n"
			. "נושא: [your-subject]\n\n"
			. "הודעה:\n[your-message]\n\n"
			. "-- \nנשלח מ-[_site_title] ([_site_url])",
		'additional_headers' => 'Reply-To: [your-email]',
		'attachments'        => '',
		'use_html'           => false,
		'exclude_blank'      => false,
	);

	$form = $existing > 0
		? WPCF7_ContactForm::get_instance( $existing )
		: WPCF7_ContactForm::get_template( array( 'title' => 'צור קשר — אייל עמית' ) );
	if ( ! $form ) {
		return 0;
	}
	$props = $form->get_properties();
	$props['form'] = $form_markup;
	$props['mail'] = $mail;
	$form->set_properties( $props );
	$form->set_title( 'צור קשר — אייל עמית' );

	$id = $form->save();
	if ( $id ) {
		update_option( 'ea_w2_15_cf7_form_id', (int) $id );
		update_option( 'ea_w2_15_cf7_rev', EA_W2_15_CF7_REV );
		return (int) $id;
	}
	return 0;
}
add_action( 'wp_loaded', 'ea_w2_15_cf7_ensure_form', 99 );

/**
 * Wire the seeded form into the Wave2 contact template.
 */
add_filter(
	'ea_wave2_cf7_form_id',
	function ( $id ) {
		$opt = (int) get_option( 'ea_w2_15_cf7_form_id', 0 );
		return $opt > 0 ? $opt : $id;
	}
);
