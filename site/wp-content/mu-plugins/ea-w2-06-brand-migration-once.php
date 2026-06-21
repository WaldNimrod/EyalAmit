<?php
/**
 * Plugin Name: EA W2-06 — brand-string DB migration (once)
 * Description: WP-06. The seed plugins (ea-w2-02 about page, ea-w2-07 QR pages) already
 *   seeded «סטודיו נשימה מעגלית» into the DB; fixing the seed SOURCE does not re-run the
 *   guarded "*-once" seeders, so this one-time migration scrubs the brand from the
 *   already-seeded content. It targets NON-blog posts only (post_type != 'post'), so it
 *   never edits Eyal's blog posts; testimonials live in a theme JSON file, not the DB,
 *   so they are untouched. Idempotent + flag-guarded.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		if ( 'done' === get_option( 'ea_w2_06_brand_migration_v1' ) ) {
			return;
		}
		if ( ! function_exists( 'wp_update_post' ) ) {
			return;
		}
		global $wpdb;
		$brand = 'סטודיו נשימה מעגלית';

		// Clean, wording-preserving replacements (match the fixed seed sources).
		$pairs = array(
			'את המרכז לטיפול בדיג׳רידו — סטודיו נשימה מעגלית בפרדס חנה — הקים' => 'את המרכז לטיפול בנשימה באמצעות דיג׳רידו בפרדס חנה — הקים',
			'ברוכים הבאים לסטודיו נשימה מעגלית בפרדס חנה -'                   => 'ברוכים הבאים למרכז לטיפול בנשימה באמצעות דיג׳רידו בפרדס חנה -',
			' - סטודיו נשימה מעגלית פרדס חנה. היום.'                          => ' פרדס חנה. היום.',
			'המרכז לטיפול בדיג\'רידו סטודיו נשימה מעגלית פרדס חנה אייל עמית'  => 'המרכז לטיפול בנשימה באמצעות דיג\'רידו פרדס חנה אייל עמית',
			'לדף של \'סטודיו נשימה מעגלית\' בפייסבוק'                         => 'לדף הפייסבוק שלנו',
			'תמונות נוספות מהמרכז לטיפול בדיג\'רידו - סטודיו נשימה מעגלית פרדס חנה.' => 'תמונות נוספות מהמרכז לטיפול בנשימה באמצעות דיג\'רידו פרדס חנה.',
		);

		$ids = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT ID FROM {$wpdb->posts}
				 WHERE post_status IN ('publish','draft','private','pending')
				 AND post_type NOT IN ('post','attachment','revision','nav_menu_item')
				 AND post_content LIKE %s",
				'%' . $wpdb->esc_like( $brand ) . '%'
			)
		);

		$changed  = 0;
		$residual = array();
		foreach ( (array) $ids as $id ) {
			$post = get_post( $id );
			if ( ! $post ) {
				continue;
			}
			$content = $orig = (string) $post->post_content;
			foreach ( $pairs as $old => $new ) {
				$content = str_replace( $old, $new, $content );
			}
			// Safety net so AC-09 (--absent) passes even on an unforeseen pattern:
			// drop a leading connector + brand, fix the "ל<brand>" prefix, then any bare brand.
			$content = preg_replace( '/\s*[·\x{2013}\x{2014}\-]\s*' . preg_quote( $brand, '/' ) . '/u', '', $content );
			$content = str_replace( 'ל' . $brand, 'למרכז לטיפול בנשימה באמצעות דיג׳רידו', $content );
			$content = str_replace( $brand, '', $content );

			if ( $content !== $orig ) {
				wp_update_post(
					array(
						'ID'           => $id,
						'post_content' => $content,
					)
				);
				++$changed;
				if ( false !== strpos( $content, $brand ) ) {
					$residual[] = $id;
				}
			}
		}

		update_option( 'ea_w2_06_brand_migration_v1', 'done' );
		update_option(
			'ea_w2_06_brand_migration_log',
			array(
				'changed'  => $changed,
				'residual' => $residual,
				'when'     => current_time( 'mysql' ),
			)
		);
	},
	20
);
