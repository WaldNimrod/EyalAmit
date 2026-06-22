<?php
/**
 * Plugin Name: EA W2-06b — retired-brand scrub in BLOG POST TITLES (once)
 * Description: WP-06 follow-up (team_100 2026-06-23, Nimrod-approved scope: TITLES ONLY).
 *   The original ea-w2-06 migration deliberately skipped blog posts; team_50 (F-01) found
 *   the retired brand «סטודיו נשימה מעגלית» in blog post TITLES that surface on the /blog/
 *   archive. This scrubs the brand from blog post TITLES only — post_content is left intact
 *   (historical articles preserved). post_title change does NOT regenerate post_name, so
 *   permalinks/slugs are unaffected and no URLs break. Idempotent + flag-guarded.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		if ( 'done' === get_option( 'ea_w2_06b_blog_title_brand_v1' ) ) {
			return;
		}
		if ( ! function_exists( 'wp_update_post' ) ) {
			return;
		}
		global $wpdb;
		$brand = 'סטודיו נשימה מעגלית';

		$ids = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT ID FROM {$wpdb->posts}
				 WHERE post_type = 'post'
				 AND post_status IN ('publish','draft','private','pending')
				 AND post_title LIKE %s",
				'%' . $wpdb->esc_like( $brand ) . '%'
			)
		);

		$changed = array();
		foreach ( (array) $ids as $id ) {
			$post = get_post( $id );
			if ( ! $post ) {
				continue;
			}
			$orig = (string) $post->post_title;
			$t    = $orig;
			// 1) "ב<brand>" → "במרכז לטיפול בדיג'רידו" (brand used as a place: "…חדש בסטודיו…").
			$t = str_replace( 'ב' . $brand, "במרכז לטיפול בדיג'רידו", $t );
			// 2) "<sep> <brand>" → "" (brand after a dash; canonical name already in the title).
			$t = preg_replace( '/\s*[\x{2013}\x{2014}\-]\s*' . preg_quote( $brand, '/' ) . '/u', '', $t );
			// 3) any bare residual → canonical.
			$t = str_replace( $brand, "המרכז לטיפול בדיג'רידו", $t );
			// tidy doubled spaces from a removal.
			$t = trim( preg_replace( '/\s{2,}/u', ' ', $t ) );

			if ( '' !== $t && $t !== $orig ) {
				wp_update_post(
					array(
						'ID'         => $id,
						'post_title' => $t,
						// post_name intentionally omitted → existing slug preserved (no URL change).
					)
				);
				$changed[ $id ] = $t;
			}
		}

		update_option( 'ea_w2_06b_blog_title_brand_v1', 'done' );
		update_option(
			'ea_w2_06b_blog_title_brand_log',
			array(
				'changed' => $changed,
				'when'    => current_time( 'mysql' ),
			)
		);
	},
	21
);
