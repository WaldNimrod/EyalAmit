<?php
/**
 * Plugin Name: EA — align the accessibility statement's modified date (once)
 * Description: team_00 approved 2026-09-18 as the governing last-updated date for the
 *   accessibility statement (2026-09-19). The visible sentence lives in the theme
 *   (inc/chapters/defaults/accessibility-defaults.php) while WordPress stores an April
 *   placeholder body for the same page, so WordPress never learned the text had changed and
 *   kept publishing post_modified = 2026-04-07 — which Yoast then emits as JSON-LD
 *   dateModified. One URL, two contradictory last-updated dates, and the machine-readable
 *   one is the wrong one: that is what search engines read.
 *
 *   This sets post_modified / post_modified_gmt on that page to the approved date, and
 *   nothing else. It does NOT touch post_content: the body stored in WordPress is stale by
 *   design — the visitor-facing copy is rendered by the theme — and rewriting it here would
 *   put the statement's text in two places, which is the drift this whole fix exists to end.
 *
 *   wp_update_post() is deliberately NOT used: it stamps post_modified with the current
 *   time, which is the opposite of what is wanted. Direct $wpdb->update is the only way to
 *   set a specific modified date.
 *
 *   Idempotent and flag-guarded. If the statement's text changes again, bump the date below
 *   AND the option key, and re-deploy.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		$flag = 'ea_a11y_statement_modified_2026_09_18_v1';
		if ( 'done' === get_option( $flag ) ) {
			return;
		}

		/* Must match $ea_a11y_updated_iso in the theme's accessibility-defaults.php. */
		$iso_local = '2026-09-18 12:00:00';
		$iso_gmt   = get_gmt_from_date( $iso_local );

		$page = get_page_by_path( 'accessibility' );
		if ( ! $page ) {
			/* Do not guess an ID. Leave the flag unset so a later run can try again once
			   the slug exists, and leave a trace rather than failing silently. */
			update_option( 'ea_a11y_statement_modified_last_error', 'page not found by slug: accessibility' );
			return;
		}

		global $wpdb;
		$rows = $wpdb->update(
			$wpdb->posts,
			array(
				'post_modified'     => $iso_local,
				'post_modified_gmt' => $iso_gmt,
			),
			array( 'ID' => (int) $page->ID ),
			array( '%s', '%s' ),
			array( '%d' )
		);

		clean_post_cache( (int) $page->ID );

		update_option(
			'ea_a11y_statement_modified_result',
			array(
				'page_id'  => (int) $page->ID,
				'rows'     => $rows,
				'set_to'   => $iso_local,
				'ran_at'   => current_time( 'mysql' ),
			)
		);
		update_option( $flag, 'done' );
	},
	20
);
