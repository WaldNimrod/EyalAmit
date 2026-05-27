<?php
/**
 * Template Name: tpl-stage-b-test (Wave2 QA smoke)
 * AC-06: all 12 blocks in POC order on one page.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
ea_wave2_render_home_blocks( true );
get_footer();
