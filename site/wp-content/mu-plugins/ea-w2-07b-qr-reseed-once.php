<?php
/**
 * Plugin Name: EA W2-07b — QR reseed trigger (once, WP-S5-02 §3.1)
 * Description: Forces ONE re-run of ea-w2-07-qr-seed-once.php by clearing its
 *   `ea_w2_07_qr_seeded_v3` flag, so the live QR pages' post_content refreshes to
 *   the current source (youtube-nocookie embeds + loading="lazy"). The live DB
 *   predates the nocookie switch and was never re-seeded. Staging has NO WP-CLI,
 *   so this is the idiomatic one-time FTP drop-in (cf. ea-faq-seed-once.php).
 *   Self-guarded via `ea_w2_07b_qr_reseed_done`; runs at init priority 27 — BEFORE
 *   ea_w2_07_qr_seed_maybe_run() at priority 28 — so the seeder re-runs in the SAME
 *   request. Does NOT edit the seeder. Idempotent + safe to leave deployed
 *   (no-ops after the first run); delete once the reseed is confirmed.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		if ( 'done' === get_option( 'ea_w2_07b_qr_reseed_done', '' ) ) {
			return;
		}
		if ( wp_installing() ) {
			return;
		}
		// Clear the W2-07 seeder's guard so ea_w2_07_qr_seed_maybe_run() (init@28)
		// re-applies the current post_content this same request.
		delete_option( 'ea_w2_07_qr_seeded_v3' );
		update_option( 'ea_w2_07b_qr_reseed_done', 'done' );
	},
	27
);
