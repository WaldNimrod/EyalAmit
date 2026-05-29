<?php
/**
 * Template Name: tpl-qr (Wave2)
 * WP-W2-07 QR heritage page — /qr/qr1/ .. /qr/qr48/.
 * Thin shell: renders the migrated post_content (the_content) inside the Wave2
 * shell. The page H1 lives in the title bar of the article wrapper here (the GP
 * title is hidden by the W2-07 router), so we render the_title() once.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-qr">
	<?php
	while ( have_posts() ) {
		the_post();
		?>
		<article class="ea-qr-article">
			<div class="ea-qr-article__inner ea-entrance--breath">
				<header class="ea-qr-article__head">
					<h1 class="ea-qr-article__title"><?php the_title(); ?></h1>
				</header>
				<div class="ea-qr-article__body ea-service-prose">
					<?php the_content(); ?>
				</div>
				<footer class="ea-qr-article__foot">
					<a class="ea-text-link" href="<?php echo esc_url( home_url( '/qr/' ) ); ?>">← כל דפי ה־QR</a>
				</footer>
			</div>
		</article>
		<?php
	}
	?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
