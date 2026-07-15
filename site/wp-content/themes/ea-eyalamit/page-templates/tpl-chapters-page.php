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

// WP-S4-05: phero + sections now flow through the ACF-or-default overlay
// (chapters-render.php) instead of reading $ea_d['phero']/['sections'] raw — this
// is what makes the page wp-admin-editable. Image resolution (incl. ACF
// attachment ids) happens inside the overlay via ea_chapters_resolve_img(), so no
// separate asset_url pass is needed here any more. When ACF is inactive or a field
// is empty, both overlay functions return the exact seeded defaults untouched
// (AC-NOACF/AC-FALLBACK) — same render as before this change.
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
