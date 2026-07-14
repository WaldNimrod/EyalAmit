<?php
/**
 * Template Name: tpl-catalog-14e (retired Wave2)
 *
 * WP-CANON T6 hygiene (F90-M02): Wave2 14e renderer (ea_w2_14e_*) was deleted.
 * Mokesh / galleries / media now route via Chapters. Legacy template assignment
 * soft-redirects home to avoid a fatal on missing functions.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

wp_safe_redirect( home_url( '/' ), 301 );
exit;
