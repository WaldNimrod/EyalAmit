<?php
/**
 * Template Name: tpl-shop-item (Wave2)
 * WP-W2-05 product page — /didgeridoos, /bags, /stands-storage, /stand-floor, /repair.
 * Thin shell: renders the_content() only; the 10-block HTML (hero · what-it-is ·
 * features · who-it's-for · faq · testimonials · price · purchase/contact CTA ·
 * gallery · closing) is injected by wave2-w2-05.php (the_content filter). The H1
 * lives inside the hero block, so the page title is NOT echoed here.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-shop-item">
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
