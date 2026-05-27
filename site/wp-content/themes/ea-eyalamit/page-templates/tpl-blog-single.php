<?php
/**
 * Template Name: tpl-blog-single (Wave2)
 * D-14 §5 tpl-blog-single — post content + end CTA.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-blog-single">
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
