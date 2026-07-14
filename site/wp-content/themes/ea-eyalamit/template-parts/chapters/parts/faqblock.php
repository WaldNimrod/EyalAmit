<?php
/**
 * Chapters part — FAQ list. Delegates to the canonical FAQ block
 * (template-parts/blocks/block-faq-list.php). WP-CANON T2 many-to-many passthrough.
 *
 * $args: cat (legacy single), cats (array), chap, title, id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a = isset( $args ) && is_array( $args ) ? $args : array();

$ea_fb_args = array();
if ( ! empty( $a['cats'] ) && is_array( $a['cats'] ) ) {
	$ea_fb_args['ea_faq_only_categories'] = $a['cats'];
} elseif ( ! empty( $a['cat'] ) ) {
	$ea_fb_args['ea_faq_only_category'] = $a['cat'];
}
if ( ! empty( $a['chap'] ) ) {
	$ea_fb_args['ea_faq_view_chap'] = $a['chap'];
}
if ( ! empty( $a['title'] ) ) {
	$ea_fb_args['ea_faq_view_title'] = $a['title'];
}
if ( ! empty( $a['id'] ) ) {
	$ea_fb_args['ea_faq_view_id'] = $a['id'];
}

get_template_part( 'template-parts/blocks/block', 'faq-list', $ea_fb_args );
