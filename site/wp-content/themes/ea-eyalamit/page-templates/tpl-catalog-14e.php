<?php
/**
 * Template Name: tpl-catalog-14e (Wave2)
 *
 * Elevated composition template for the 3 remaining new pages (WP-W2-14-E):
 *   /mokesh-dahiman (memorial), /galleries (catalog), /media (catalog).
 *
 * Mirrors page-templates/tpl-service.php: get_header() → canonical topnav block
 * → <main> with the route-aware render function → canonical footer-social block
 * → get_footer(). No bare the_content() fallback. Routing + render functions
 * live in inc/wave2-w2-14e.php (force-routed via template_include @ 100).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_14e_ctx    = function_exists( 'ea_w2_14e_ctx' ) ? ea_w2_14e_ctx() : null;
$ea_14e_active = is_array( $ea_14e_ctx ) && isset( $ea_14e_ctx['slug'] ) ? (string) $ea_14e_ctx['slug'] : '';

get_header();

set_query_var( 'ea_topnav_active', $ea_14e_active );
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-14e">
	<?php
	if ( is_array( $ea_14e_ctx ) && function_exists( 'ea_w2_14e_render' ) ) {
		ea_w2_14e_render( $ea_14e_ctx );
	}
	?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
