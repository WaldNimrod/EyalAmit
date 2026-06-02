<?php
/**
 * Template Name: tpl-content (Wave2)
 *
 * Elevated Editorial template (WP-W2-10-B). Renders the 13-block editorial
 * composition for the three editorial routes (/about, /press, /about/moksha)
 * via the route-aware render function ea_wave2_render_editorial_blocks() —
 * no bare the_content() fallback on those routes. Any other page assigned to
 * this template degrades to the legacy title + the_content() loop.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_editorial_ctx    = function_exists( 'ea_wave2_editorial_ctx' ) ? ea_wave2_editorial_ctx() : null;
$ea_editorial_active = is_array( $ea_editorial_ctx ) && isset( $ea_editorial_ctx['route'] ) ? (string) $ea_editorial_ctx['route'] : '';

get_header();

set_query_var( 'ea_topnav_active', $ea_editorial_active );
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-editorial">
	<?php
	if ( is_array( $ea_editorial_ctx ) ) {
		ea_wave2_render_editorial_blocks( $ea_editorial_ctx );
	} else {
		while ( have_posts() ) {
			the_post();
			the_title( '<h1 class="ea-page-title">', '</h1>' );
			the_content();
		}
	}
	?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
