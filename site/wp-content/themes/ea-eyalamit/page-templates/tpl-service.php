<?php
/**
 * Template Name: tpl-service (Wave2)
 * D-14 §5 tpl-service — /treatment, /sound-healing, /lessons, /method.
 * Slots: hero, intro, content-sections, faq-filter, testimonials, cta-pill, footer.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-service">
	<!-- SLOT: hero-content -->
	<!-- SLOT: intro-text -->
	<!-- SLOT: body-sections -->
	<?php
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
