<?php
/**
 * Plugin Name: EA — WP-S5-07 §4.F one-time QR reseed
 * Description: Clears the W2-07 QR seeder's guard flag ONCE so the seeder re-runs and
 *   pushes the corrected /qr/qr32/ phone number (was a 9-digit truncation, now the
 *   canonical 052-4822842) into post_content. The truncated literal is deliberately NOT
 *   repeated here — scripts/qa/nap_canon_check.mjs treats it as a violation anywhere in
 *   site/wp-content, comments included, and that strictness is the point.
 *   Staging has NO WP-CLI, so a self-guarded FTP drop-in is the idiom
 *   (cf. ea-w2-07b-qr-reseed-once.php, whose own flag is already burnt — hence a NEW
 *   flag here). Does NOT edit the seeder. Never hand-edit the DB.
 *
 *   Runs at init priority 27, one BEFORE the seeder's 28, so the reseed lands in the
 *   SAME request.
 *
 *   Why this is safe against WP-S5-06's facade: the facade is a `the_content` RENDER
 *   filter and never touches post_content. This reseed writes back the same seed HTML
 *   — all 60 embeds included — so ea-w2-seo-schema.php:266 still regexes the raw column
 *   and every VideoObject survives. Execution order between S5-06 and S5-07 is
 *   irrelevant (WP-S5-07 LOD400 §4.F).
 *
 *   Single-fire: after the first run it is a no-op. "Nothing happened on the second
 *   load" is CORRECT, not a failure. Safe to leave deployed; delete once confirmed.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		if ( 'done' === get_option( 'ea_s507_qr_reseed_done', '' ) ) {
			return;
		}
		if ( wp_installing() ) {
			return;
		}
		delete_option( 'ea_w2_07_qr_seeded_v3' );          // clears the W2-07 seeder guard
		update_option( 'ea_s507_qr_reseed_done', 'done' ); // single-fire
	},
	27
);
