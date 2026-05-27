<?php
/**
 * Template Name: tpl-shop-archive (Wave2)
 * D-14 §5 tpl-shop-archive — /shop product grid.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-shop-archive">
	<h1 class="ea-page-title"><?php esc_html_e( 'חנות', 'ea-eyalamit' ); ?></h1>
	<!-- SLOT: product-card tiles (CPT ea_product — WP-W2-05) -->
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
