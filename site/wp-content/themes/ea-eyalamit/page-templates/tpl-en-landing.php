<?php
/**
 * Template Name: tpl-en-landing (Wave2)
 * D-14 §5 tpl-en-landing — /en LTR shell.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-en" lang="en" dir="ltr">
	<?php
	// W2-08: the injected hero block carries the single H1 — do NOT print the_title()
	// here (would duplicate the page H1). Content is injected via the_content (the
	// the_content filter in inc/wave2-w2-08.php, keyed on slug `en`).
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
