<?php
/**
 * Template Name: tpl-faq (Wave2)
 * D-14 §5 tpl-faq — faq-filter + faq-item panels.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-faq">
	<h1 class="ea-page-title"><?php esc_html_e( 'שאלות נפוצות', 'ea-eyalamit' ); ?></h1>
	<?php get_template_part( 'template-parts/blocks/block', 'faq-mini' ); ?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
