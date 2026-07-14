<?php
/**
 * Template Name: tpl-home (Wave2)
 * D-14 §5 tpl-home — homepage slot map; 12 POC blocks via get_template_part.
 *
 * FROZEN EMERGENCY ROLLBACK (WP-CANON T6): kept when EA_CHAPTERS_FRONT=false.
 * Do not edit — Chapters tpl-chapters-home.php is the live template.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
ea_wave2_render_home_blocks( true );
get_footer();
