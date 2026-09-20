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

$ea_editorial_ctx = function_exists( 'ea_wave2_editorial_ctx' ) ? ea_wave2_editorial_ctx() : null;

get_header();

/*
 * S007 M-13 (2026-09-20): this used to ALSO render block-topnav.php's own
 * .ea-topnav here, right after get_header() — meaning /about/ and /press/
 * showed two navigations at once: GeneratePress's own header nav (via
 * get_header(), which every template in this theme reaches) and this
 * template's separate, independently-maintained one. That is exactly the
 * defect _COMMUNICATION/team_00/DECIDE-S007-TWO-NAVIGATIONS-2026-09-20.md
 * found and M-13 exists to end — team_00: «כל העמודים ללא יוצא מהכלל חייבים
 * להציג אותו תפריט מדוייק ונכון». GeneratePress's header now renders the
 * canonical set too (inc/ea-canonical-nav.php's wp_nav_menu_items filter),
 * so this second render is removed rather than reconciled — the mobile
 * trigger these two pages relied on from .ea-mnav-burger is replaced by the
 * same standalone burger the GeneratePress-orphan pages already use (see
 * ea_nav_drawer_no_burger_pages() in inc/ea-nav-drawer.php).
 */
?>
<main id="main" class="ea-wave2-editorial">
	<?php
	if ( is_array( $ea_editorial_ctx ) ) {
		ea_wave2_render_editorial_blocks( $ea_editorial_ctx );
	} else {
		while ( have_posts() ) {
			the_post();
			/* S007/A11Y (2026-09-18): /about/ rendered TWO <h1 class="ea-page-title"> with
			   identical text — one from here, one already authored into the page content.
			   Caught by the cross-engine gate as a C5 failure (one h1 per page). Fixed in
			   the template rather than by editing Eyal's content: emit the title only when
			   the content does not already carry its own h1. */
			$ea_raw_content = (string) get_the_content();
			if ( ! preg_match( '/<h1[\s>]/i', $ea_raw_content ) ) {
				the_title( '<h1 class="ea-page-title">', '</h1>' );
			}
			the_content();
		}
	}
	?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
