<?php
/**
 * Template Name: פרקים — עמוד (Chapters Page)
 *
 * Generic flexible inner-page template: renders a page hero + an ordered list of
 * Chapters section-parts defined per page-type in defaults/{type}-defaults.php
 * ('phero' => array, 'sections' => [ ['part'=>'split','args'=>[…]], … ]).
 * Used by treatment / sound-healing / lessons / about. Self-contained doc → keeps
 * wp_head/wp_footer (SEO, analytics, WhatsApp).
 *
 * The page hero (which carries the single H1 + intro subtitle) renders INSIDE
 * <main> so it sits within the main landmark (a11y) and is part of the page's
 * measured content.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
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

$ea_d     = ea_chapters_defaults();
$ea_phero = ( isset( $ea_d['phero'] ) && is_array( $ea_d['phero'] ) ) ? $ea_d['phero'] : array();
// Resolve phero media path → URL.
if ( ! empty( $ea_phero['media'] ) ) {
	$ea_phero['media'] = ea_chapters_asset_url( $ea_phero['media'] );
}
?>

<main id="chapters-main">
	<?php
	get_template_part( 'template-parts/chapters/parts/phero', null, $ea_phero );

	$ea_sections = ( isset( $ea_d['sections'] ) && is_array( $ea_d['sections'] ) ) ? $ea_d['sections'] : array();
	foreach ( $ea_sections as $ea_s ) {
		if ( empty( $ea_s['part'] ) ) {
			continue;
		}
		$ea_args = isset( $ea_s['args'] ) && is_array( $ea_s['args'] ) ? $ea_s['args'] : array();
		// Resolve any image-path args to URLs for image-bearing parts.
		foreach ( array( 'image', 'media', 'poster', 'video' ) as $ea_k ) {
			if ( ! empty( $ea_args[ $ea_k ] ) ) {
				$ea_args[ $ea_k ] = ea_chapters_asset_url( $ea_args[ $ea_k ] );
			}
		}
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
