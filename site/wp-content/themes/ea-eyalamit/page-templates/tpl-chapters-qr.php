<?php
/**
 * Template: QR child under /qr/{slug}/. Chapters chrome (nav/phero/footer),
 * body renders real post_content via the_content() — fidelity to migrated HTML.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$GLOBALS['ea_chapters_type'] = 'qr';
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
	get_template_part(
		'template-parts/chapters/parts/phero',
		null,
		array(
			'chap'  => 'QR',
			'title' => get_the_title(),
		)
	);
	while ( have_posts() ) :
		the_post();
		?>
		<section class="sec">
			<div class="wrap">
				<div class="intro-body r r2"><?php the_content(); ?></div>
				<p class="r" style="margin-top:var(--ea-space-8, 32px)">
					<a class="tlink" href="<?php echo esc_url( home_url( '/qr/' ) ); ?>">← כל דפי ה-QR</a>
				</p>
			</div>
		</section>
	<?php endwhile; ?>
</main>
<?php
get_template_part( 'template-parts/chapters/section', 'footer' );
wp_footer();
?>
</body>
</html>
