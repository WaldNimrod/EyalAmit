<?php
/**
 * Plugin Name: EA M2 — הפעלת Fluent Forms בסטייג'ינג (uPress)
 * Description: אם Fluent Forms מותקן אך לא פעיל, מוסיף ל־active_plugins, טוען את הקובץ הראשי ומריץ הוק activate_* (כמו ליבה בלי silent) — כדי שטבלאות/shortcodes יאותחלו גם מבלי wp-admin. בפרודקשן (לא upress) לא רץ.
 * Version: 1.0.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * @return bool
 */
function ea_m2_ensure_fluent_is_upress_staging() {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	return is_string( $host ) && $host !== '' && str_contains( $host, 'upress.link' );
}

/**
 * @return string|null Plugin basename relative to wp-content/plugins, or null.
 */
function ea_m2_ensure_fluent_discover_basename() {
	$static_candidates = array(
		'fluentform/fluentform.php',
		'fluent-forms/fluent-forms.php',
	);
	foreach ( $static_candidates as $rel ) {
		$path = WP_PLUGIN_DIR . '/' . $rel;
		if ( is_readable( $path ) ) {
			return $rel;
		}
	}
	if ( ! is_dir( WP_PLUGIN_DIR ) ) {
		return null;
	}
	$dirs = scandir( WP_PLUGIN_DIR );
	if ( ! is_array( $dirs ) ) {
		return null;
	}
	foreach ( $dirs as $dir ) {
		if ( $dir === '.' || $dir === '..' ) {
			continue;
		}
		$low = strtolower( (string) $dir );
		if ( strpos( $low, 'fluent' ) === false ) {
			continue;
		}
		$base = WP_PLUGIN_DIR . '/' . $dir;
		if ( ! is_dir( $base ) ) {
			continue;
		}
		foreach ( array( 'fluentform.php', 'fluent-forms.php', 'FluentForm.php' ) as $file ) {
			$main = $base . '/' . $file;
			if ( is_readable( $main ) ) {
				return $dir . '/' . $file;
			}
		}
	}
	return null;
}

/**
 * Front-safe activation: core's activate_plugin(…, silent true) skips activate_{$plugin} hooks — Fluent may need them.
 *
 * @param string $basename Plugin path relative to plugins dir.
 * @param string $main     Full path to main plugin file.
 */
function ea_m2_ensure_fluent_activate_like_core( $basename, $main ) {
	$active = get_option( 'active_plugins', array() );
	if ( ! is_array( $active ) ) {
		$active = array();
	}
	if ( in_array( $basename, $active, true ) ) {
		return;
	}
	$active[] = $basename;
	sort( $active );
	update_option( 'active_plugins', $active );
	wp_cache_delete( 'active_plugins', 'options' );

	do_action( 'activate_plugin', $basename, false );
	if ( is_readable( $main ) ) {
		require_once $main;
	}
	do_action( 'activate_' . $basename, false );
}

/**
 * Activate Fluent if needed; load early on plugins_loaded so later priorities (Fluent's own) still run.
 */
function ea_m2_ensure_fluent_maybe_activate() {
	if ( ! ea_m2_ensure_fluent_is_upress_staging() ) {
		return;
	}
	if ( ! defined( 'WP_PLUGIN_DIR' ) ) {
		return;
	}
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	$basename = ea_m2_ensure_fluent_discover_basename();
	if ( $basename === null ) {
		return;
	}
	$main = WP_PLUGIN_DIR . '/' . $basename;
	if ( is_plugin_active( $basename ) ) {
		return;
	}
	ea_m2_ensure_fluent_activate_like_core( $basename, $main );
}
add_action( 'plugins_loaded', 'ea_m2_ensure_fluent_maybe_activate', 1 );
