<?php
/**
 * Plugin Name: EA — NAP SSoT accessor (WP-S5-07)
 * Description: The ONE canonical Name/Address/Phone source. Every display surface
 *   MUST read from ea_nap() instead of hard-coding a copy. Canon + rationale:
 *   _COMMUNICATION/team_110/DECISION-NAP-CANON-2026-07-16.md (RATIFIED — do not
 *   re-open, do not ask team_00/Eyal). Extracted out of ea-w2-seo-schema.php,
 *   whose NAP literal nothing could consume — the root cause of 6 phone variants
 *   and an unsatisfiable WP-S4-07 AC-10.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Canonical NAP.
 *
 * @param string $key '' for the whole map, or one of the keys below.
 * @return string|array
 */
function ea_nap( $key = '' ) {
	$nap = array(
		'name'            => 'המרכז לטיפול בנשימה באמצעות דיג\'רידו',
		'alternate_name'  => 'cbDIDG',
		'street'          => 'עמל 8 ב\'',                  // U+0027
		'locality'        => 'פרדס חנה-כרכור',             // U+002D
		'country'         => 'IL',
		'address_display' => 'רח\' עמל 8 ב\', פרדס חנה-כרכור', // U+0027 x2, U+002D
		'phone_display'   => '052-4822842',                 // U+002D, no country code
		'phone_href'      => '+972524822842',               // tel: href
		'phone_schema'    => '+972-52-482-2842',            // schema.org telephone
	);
	if ( '' === $key ) {
		return $nap;
	}
	return isset( $nap[ $key ] ) ? $nap[ $key ] : '';
}
