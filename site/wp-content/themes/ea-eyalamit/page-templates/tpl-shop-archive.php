<?php
/**
 * Template Name: tpl-shop-archive (Wave2)
 * WP-W2-05 /shop catalog — responsive product grid (5 linked cards). Thin shell:
 * renders the_content() only; the catalog-grid HTML (including the page H1) is
 * injected by wave2-w2-05.php (the_content filter).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-shop-archive">
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
