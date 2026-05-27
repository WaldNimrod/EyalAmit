<?php
/**
 * Template Name: tpl-books (Wave2)
 * D-14 §5 tpl-books — catalog / muzza hub slots.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-books">
	<?php get_template_part( 'template-parts/blocks/block', 'books-row' ); ?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
