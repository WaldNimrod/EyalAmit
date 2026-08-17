<?php
/**
 * Template Name: פרקים — השיטה (Chapters Method)
 *
 * S006 R1-03 · same loop as tpl-chapters-page.php so /method/ can render
 * phero + sections[] from method-defaults.php (one md section per block).
 * Page-specific file — not a shared inner-page template.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$GLOBALS['ea_chapters_type'] = 'method';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="ea-skip-link screen-reader-text" href="#chapters-main"><?php esc_html_e( 'דלג לתוכן העמוד', 'ea-eyalamit' ); ?></a>

<?php
get_template_part( 'template-parts/chapters/section', 'nav' );
$ea_phero = ea_chapters_phero_overlay();
?>

<main id="chapters-main">
	<?php
	get_template_part( 'template-parts/chapters/parts/phero', null, $ea_phero );

	$ea_sections = ea_chapters_page_sections();
	foreach ( $ea_sections as $ea_s ) {
		if ( empty( $ea_s['part'] ) ) {
			continue;
		}
		$ea_args = isset( $ea_s['args'] ) && is_array( $ea_s['args'] ) ? $ea_s['args'] : array();
		get_template_part( 'template-parts/chapters/parts/' . $ea_s['part'], null, $ea_args );
	}
	?>
</main>

<?php
get_template_part( 'template-parts/chapters/section', 'footer' );
wp_footer();
?>
</body>
</html>
