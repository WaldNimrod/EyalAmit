<?php
/**
 * Template Name: פרקים — השיטה (Chapters Method)
 *
 * Content template-mother. Self-contained doc (keeps wp_head/wp_footer → SEO,
 * analytics, WhatsApp). Sections assembled from shared Chapters parts; content
 * from ea_chapters_field()/rows()/img() (ACF-or-seeded-defaults, type=method).
 *
 * The page hero (single H1 + intro subtitle) renders INSIDE <main> so it sits
 * within the main landmark (a11y) and is part of the page's measured content.
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

<?php get_template_part( 'template-parts/chapters/section', 'nav' ); ?>

<main id="chapters-main">
	<?php
	get_template_part( 'template-parts/chapters/parts/phero', null, array(
		'chap'      => ea_chapters_field( 'phero_chap' ),
		'title'     => ea_chapters_field( 'phero_title' ),
		'sub'       => ea_chapters_field( 'phero_sub' ),
		'media'     => ea_chapters_img( 'phero_media' ),
		'media_alt' => ea_chapters_field( 'phero_media_alt' ),
		'cta_label' => ea_chapters_field( 'phero_cta_label' ),
		'cta_url'   => ea_chapters_field( 'phero_cta_url' ),
	) );

	get_template_part( 'template-parts/chapters/parts/split', null, array(
		'chap'  => ea_chapters_field( 'split_chap' ),
		'title' => ea_chapters_field( 'split_title' ),
		'body'  => ea_chapters_field( 'split_body' ),
		'image' => ea_chapters_img( 'split_image' ),
		'alt'   => ea_chapters_field( 'split_alt' ),
		'figr'  => 'l',
	) );

	get_template_part( 'template-parts/chapters/parts/mag', null, array(
		'id'      => 'how',
		'chap'    => ea_chapters_field( 'mag_chap' ),
		'title'   => ea_chapters_field( 'mag_title' ),
		'image'   => ea_chapters_img( 'mag_image' ),
		'alt'     => ea_chapters_field( 'mag_alt' ),
		'cap_b'   => ea_chapters_field( 'mag_cap_b' ),
		'cap_sub' => ea_chapters_field( 'mag_cap_sub' ),
		'items'   => ea_chapters_rows( 'mag_items' ),
	) );

	get_template_part( 'template-parts/chapters/parts/lead', null, array(
		'chap'  => ea_chapters_field( 'uniq_chap' ),
		'title' => ea_chapters_field( 'uniq_title' ),
		'lead'  => ea_chapters_field( 'uniq_lead' ),
	) );

	get_template_part( 'template-parts/chapters/parts/bleed', null, array(
		'image'  => ea_chapters_img( 'bleed_image' ),
		'alt'    => ea_chapters_field( 'bleed_alt' ),
		'quote'  => ea_chapters_field( 'bleed_quote' ),
		'attrib' => ea_chapters_field( 'bleed_attrib' ),
	) );

	get_template_part( 'template-parts/chapters/parts/reveals', null, array(
		'chap'  => ea_chapters_field( 'whom_chap' ),
		'title' => ea_chapters_field( 'whom_title' ),
		'items' => ea_chapters_rows( 'whom_items' ),
	) );

	get_template_part( 'template-parts/chapters/parts/faqblock', null, array(
		'cats'  => array( 'method' ),
		'chap'  => 'שאלות נפוצות',
		'title' => 'שאלות נפוצות על השיטה',
	) );

	get_template_part( 'template-parts/chapters/parts/testimonials', null, array(
		'chap'  => ea_chapters_field( 'testi_chap' ),
		'title' => ea_chapters_field( 'testi_title' ),
		'items' => ea_chapters_rows( 'testi_items' ),
	) );

	get_template_part( 'template-parts/chapters/parts/cta', null, array(
		'title'     => ea_chapters_field( 'cta_title' ),
		'body'      => ea_chapters_field( 'cta_body' ),
		'cta_label' => ea_chapters_field( 'cta_label' ),
		'cta_url'   => ea_chapters_field( 'cta_url' ),
	) );
	?>
</main>

<?php
get_template_part( 'template-parts/chapters/section', 'footer' );
wp_footer();
?>
</body>
</html>
