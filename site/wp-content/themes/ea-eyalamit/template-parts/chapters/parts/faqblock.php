<?php
/**
 * Chapters part — FAQ list. Delegates to the canonical WP-W2-02 FAQ block
 * (template-parts/blocks/block-faq-list.php), preserving the full filterable
 * accordion + the AC-18 canonical internal links + the sticky TOC/scroll-spy
 * assets (enqueued on is_page('faq')). Used inside the Chapters /faq/ page.
 *
 * $args (optional): ea_faq_only_category — render a single category view-only.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a = isset( $args ) && is_array( $args ) ? $args : array();
get_template_part(
	'template-parts/blocks/block',
	'faq-list',
	array( 'ea_faq_only_category' => $a['cat'] ?? '' )
);
