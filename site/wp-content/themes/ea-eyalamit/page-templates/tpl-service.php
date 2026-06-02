<?php
/**
 * Template Name: tpl-service (Wave2)
 *
 * Elevated service template (WP-W2-10-A). Renders the 14-block composition for
 * the 4 service routes (/treatment, /method, /sound-healing, /lessons) via the
 * route-aware render function — no bare the_content() fallback.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_service_ctx = function_exists( 'ea_wave2_service_ctx' ) ? ea_wave2_service_ctx() : null;
$ea_service_active = is_array( $ea_service_ctx ) && isset( $ea_service_ctx['slug'] ) ? (string) $ea_service_ctx['slug'] : '';

get_header();

set_query_var( 'ea_topnav_active', $ea_service_active );
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-service">
	<?php
	if ( is_array( $ea_service_ctx ) ) {
		ea_wave2_render_service_blocks( $ea_service_ctx );
	}
	?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
