<?php
/**
 * Template Name: tpl-blog-archive (Wave2)
 * D-14 §5 tpl-blog-archive — blog card grid + pagination.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-blog-archive">
	<h1 class="ea-page-title"><?php esc_html_e( 'בלוג', 'ea-eyalamit' ); ?></h1>
	<!-- SLOT: blog-card archive tiles -->
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
