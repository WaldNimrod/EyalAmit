<?php
/**
 * Template Name: פרקים — דף הבית (Chapters Home)
 *
 * Self-contained Chapters (פרקים) home: emits its own document so the cinematic
 * Chapters nav/footer render without the GeneratePress header chrome (avoids the
 * doubled-nav issue). wp_head()/wp_footer() still fire, so the SEO machine layer
 * (Yoast @graph, per-route meta, og:image, analytics, WhatsApp float) is intact.
 *
 * Content comes from ea_chapters_field()/rows()/img(), which fall back to seeded
 * defaults — so the page renders fully even when ACF is inactive.
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
get_template_part( 'template-parts/chapters/section', 'hero' );
?>

<main id="chapters-main">
	<?php
	get_template_part( 'template-parts/chapters/section', '01-about' );
	get_template_part( 'template-parts/chapters/section', '02-for-whom' );
	get_template_part( 'template-parts/chapters/section', '03-session' );
	get_template_part( 'template-parts/chapters/section', 'photo-band' );
	get_template_part( 'template-parts/chapters/section', '04-studio' );
	get_template_part( 'template-parts/chapters/section', '05-testimonials' );
	get_template_part( 'template-parts/chapters/section', '06-compare' );
	get_template_part( 'template-parts/chapters/section', '07-how-to-start' );
	?>
</main>

<?php
get_template_part( 'template-parts/chapters/section', 'footer' );
wp_footer();
?>
</body>
</html>
