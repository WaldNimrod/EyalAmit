<?php
/**
 * Chapters /treatment/?compare=eyal — document-exact twin of treatment-defaults.php.
 *
 * S006 R1-02 · team_00: two live links for Eyal to choose.
 * Diff vs proposed (only these):
 *   1. no bleed photo-quote («הנשימה היא לכולם» stays in FAQ SECTION 10)
 *   2. FAQ = 15 questions from SECTION 10 only (no snoring/CPAP extras)
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$d     = require __DIR__ . '/treatment-defaults.php';
$items = isset( $d['faq_eyal_items'] ) && is_array( $d['faq_eyal_items'] ) ? $d['faq_eyal_items'] : array();
unset( $d['faq_eyal_items'] );

$out = array();
foreach ( $d['sections'] as $sec ) {
	$part = isset( $sec['part'] ) ? $sec['part'] : '';
	if ( 'bleed' === $part ) {
		continue;
	}
	if ( 'faqblock' === $part ) {
		$sec['part'] = 'faq-inline';
		$sec['args']['items'] = $items;
		unset( $sec['args']['cats'] );
	}
	$out[] = $sec;
}
$d['sections'] = $out;

return $d;
