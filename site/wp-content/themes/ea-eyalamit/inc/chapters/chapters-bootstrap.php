<?php
/**
 * Chapters (פרקים) design system — bootstrap.
 *
 * Single require point for the Chapters layer (loaded once from functions.php).
 * The render accessors come first (templates depend on them); the rest register
 * their own hooks. Each file is self-guarding (ACF-absent safe).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_chapters_dir = get_stylesheet_directory() . '/inc/chapters/';

require_once $ea_chapters_dir . 'chapters-render.php';
require_once $ea_chapters_dir . 'chapters-routing.php';
require_once $ea_chapters_dir . 'chapters-enqueue.php';
require_once $ea_chapters_dir . 'chapters-duplicate.php';
require_once $ea_chapters_dir . 'acf-fields-home.php';
