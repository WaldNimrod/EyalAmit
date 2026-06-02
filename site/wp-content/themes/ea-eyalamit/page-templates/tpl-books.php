<?php
/**
 * Template Name: tpl-books (Wave2)
 *
 * WP-W2-10-E (Commerce) — elevated /books archive (מוזה הוצאה לאור).
 * Composition source of truth:
 *   _COMMUNICATION/team_35/WP-W2-10-E/elevation/mockup/commerce-books-archive.html
 *
 * Block order (spec §2): topnav (current=ספרים) · book-hero (kicker) ·
 * why-here prose (--alt) · book-cards ×3 (real covers + genre + price +
 * "לעמוד הספר" footer) · stacked-cover bundle (--ea-chocolate, Morning CTA) ·
 * shop-grid ×5 (4:3 gaps, by-quote prices) · footer-social.
 *
 * Reuses the WP-W2-10-A render pattern: the shared topnav/footer partials are
 * driven via set_query_var(); the E-specific commerce blocks are rendered by
 * ea_w2_05_render_books_archive() in inc/wave2-w2-05.php. Book covers are real
 * theme media; book copy comes from ea_w2_03_book_content() (verbatim SSoT).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();

set_query_var( 'ea_topnav_active', 'books' );
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-books ea-books-page">
	<?php
	if ( function_exists( 'ea_w2_05_render_books_archive' ) ) {
		echo ea_w2_05_render_books_archive(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped at source.
	}
	?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
