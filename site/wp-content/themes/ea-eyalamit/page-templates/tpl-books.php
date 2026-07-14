<?php
/**
 * Template Name: tpl-books (retired Wave2)
 *
 * WP-CANON T6 hygiene (F90-M02): Wave2 books archive renderer was deleted with
 * wave2-w2-05.php. Live /books/ is served by Chapters (muzza). If an editor still
 * assigns this legacy template, soft-redirect to the canonical hub.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

wp_safe_redirect( home_url( '/books/' ), 301 );
exit;
