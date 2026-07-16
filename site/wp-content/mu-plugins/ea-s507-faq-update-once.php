<?php
/**
 * Plugin Name: EA — WP-S5-07 §4.G one-time FAQ row update (2-key allow-list)
 * Description: Pushes the corrected `method-02` (rebirthing glow) and `general-17`
 *   (canonical phone) answers from inc/data/ea-faq-seed.json into the two live ea_faq
 *   rows. Staging has NO WP-CLI, so a self-guarded FTP drop-in is the idiom.
 *
 *   🔴 WHY THIS EXISTS — ea-faq-seed-once.php is INSERT-ONLY:
 *       if ( ! empty( $existing ) ) { continue; }   // ea-faq-seed-once.php:91-103
 *   so clearing its `ea_faq_seed_v2` flag re-runs the loop but updates NOTHING — every
 *   already-seeded row hits the `continue`. Copying the QR reseed pattern here (which
 *   DOES update, ea-w2-07-qr-seed-once.php:57-59) silently no-ops. Two seeders, opposite
 *   semantics. That asymmetry is exactly why WP-S4-07's AC-6 "stayed open" even though
 *   the repo seed was already correct.
 *
 *   🔴 DO NOT widen this to update-all + bump to v3: that would overwrite post_content on
 *   ALL 108 rows and destroy any edits Eyal/team_00 made in wp-admin — restoring which was
 *   the entire point of WP-S4-05. The 2-key allow-list keeps the blast radius at zero.
 *
 *   Runs at init priority 41, AFTER ea_faq_seed_once_maybe_run() at init@40.
 *   Answers are read FROM THE JSON — never retyped here (one source).
 *
 *   Single-fire: after the first run it is a no-op. "Nothing happened on the second load"
 *   is CORRECT, not a failure. Safe to leave deployed; delete once confirmed.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		// v2 flag: the v1 run self-disarmed (see the "rows live under items[]" note below) —
		// it burnt ea_s507_faq_update_done while updating nothing. Same lesson as
		// ea-w2-07b-qr-reseed-once.php: a spent flag can never be reused.
		if ( 'done' === get_option( 'ea_s507_faq_update_v2_done', '' ) ) {
			return;
		}
		if ( wp_installing() ) {
			return;
		}

		$keys = array( 'method-02', 'general-17' );   // EXPLICIT allow-list — never widen
		$file = get_stylesheet_directory() . '/inc/data/ea-faq-seed.json';
		$raw  = json_decode( (string) file_get_contents( $file ), true );

		// 🔴 The rows live under items[], NOT at the top level. ea-faq-seed.json is
		// { "_note": str, "count": int, "items": [ … ] } — cf. ea-faq-seed-once.php:54,60,
		// which reads $raw['items']. Iterating $raw directly walks _note/count/items, none of
		// which has a 'seed_key', so the map comes out EMPTY, every key hits `continue`, and
		// the drop-in sets its flag having changed nothing — a silent self-disarm. This is
		// how the v1 run failed. Do not "simplify" back to foreach ( $raw as $row ).
		if ( empty( $raw['items'] ) || ! is_array( $raw['items'] ) ) {
			return;
		}

		$by = array();
		foreach ( $raw['items'] as $row ) {
			if ( isset( $row['seed_key'] ) ) {
				$by[ $row['seed_key'] ] = $row;
			}
		}

		foreach ( $keys as $k ) {
			if ( empty( $by[ $k ] ) ) {
				continue;
			}
			$ids = get_posts(
				array(
					'post_type'   => 'ea_faq',
					'post_status' => 'any',
					'numberposts' => 1,
					'fields'      => 'ids',
					'meta_key'    => '_ea_faq_seed_key',
					'meta_value'  => $k,
				)
			);
			if ( empty( $ids ) ) {
				continue;
			}
			wp_update_post(
				array(
					'ID'           => (int) $ids[0],
					'post_content' => $by[ $k ]['a'],
				)
			);
		}

		update_option( 'ea_s507_faq_update_v2_done', 'done' );
	},
	41
);
