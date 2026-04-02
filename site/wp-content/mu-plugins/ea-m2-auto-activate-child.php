<?php
/**
 * Plugin Name: EA M2 — הפעלת child אוטומטית (פעם אחת)
 * Description: לאחר פריסת FTP, מחליף לתבנית ea-eyalamit בבקשה הראשונה ל-WordPress. אופציונלי להסיר אחרי ייצוב M2.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * מפעיל את child GeneratePress פעם אחת כשהקבצים כבר על השרת (בלי כניסה ל-wp-admin).
 */
add_action(
	'init',
	function () {
		if ( get_option( 'ea_m2_child_theme_activated', '' ) === 'done' ) {
			return;
		}
		$child = wp_get_theme( 'ea-eyalamit' );
		if ( ! $child->exists() ) {
			return;
		}
		if ( get_stylesheet() === 'ea-eyalamit' ) {
			update_option( 'ea_m2_child_theme_activated', 'done' );
			return;
		}
		switch_theme( 'ea-eyalamit' );
		update_option( 'ea_m2_child_theme_activated', 'done' );
	},
	1
);
