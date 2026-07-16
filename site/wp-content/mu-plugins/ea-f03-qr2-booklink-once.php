<?php
/**
 * Plugin Name: EA — F-03 one-time QR reseed (qr2 broken book link)
 * Description: Clears the W2-07 QR seeder's guard flag ONCE so the seeder re-runs and pushes
 *   the corrected /qr/qr2/ book link into post_content.
 *
 *   WHAT IT FIXES — team_00 direct instruction 2026-07-16 (F-03 of WP-S5-03, which routed it as
 *   out-of-scope for S5-03/06/07). /qr/qr2/ carried TWO anchors to /books/צבע-בכחול-וזרוק-לים/,
 *   which returns 404. One was empty; the other was a VISIBLE «לדף הספר>>» link a reader clicks
 *   after scanning the QR printed in Eyal's book. Both now point at /books/tsva-bekahol/
 *   (verified HTTP 200), and the empty anchor carries the book's title.
 *
 *   Staging has NO WP-CLI, so a self-guarded FTP drop-in is the idiom. NEW flag: both
 *   ea_w2_07b_qr_reseed_done and ea_s507_qr_reseed_done are already burnt — a spent flag can
 *   never be reused.
 *
 *   Runs at init priority 27, one BEFORE the seeder's 28, so the reseed lands in the SAME request.
 *   The W2-07 seeder is update-capable on re-run (ea-w2-07-qr-seed-once.php:57-59), unlike the
 *   FAQ seeder, which is insert-only.
 *
 *   SAFE against the WP-S5-06 facade: the facade is a `the_content` RENDER filter and never
 *   touches post_content. This reseed writes back the same seed HTML — all 60 embeds included —
 *   so ea-w2-seo-schema.php:266 still regexes the raw column and every VideoObject survives.
 *   /qr/qr2/ must still report VideoObject = 1 afterwards.
 *
 *   Single-fire: after the first run it is a no-op. "Nothing happened on the second load" is
 *   CORRECT, not a failure. Safe to leave deployed; delete once confirmed.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		if ( 'done' === get_option( 'ea_f03_qr2_booklink_done', '' ) ) {
			return;
		}
		if ( wp_installing() ) {
			return;
		}
		delete_option( 'ea_w2_07_qr_seeded_v3' );            // clears the W2-07 seeder guard
		update_option( 'ea_f03_qr2_booklink_done', 'done' ); // single-fire
	},
	27
);
