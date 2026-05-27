<?php
/**
 * Template Name: tpl-content (Wave2)
 * D-14 §5 — /about, /press, /about/moksha. Optional CF7 on contact variant.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-content">
	<!-- SLOT: page-title -->
	<!-- SLOT: section-intro -->
	<?php
	while ( have_posts() ) {
		the_post();
		the_title( '<h1 class="ea-page-title">', '</h1>' );
		the_content();
	}
	?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
