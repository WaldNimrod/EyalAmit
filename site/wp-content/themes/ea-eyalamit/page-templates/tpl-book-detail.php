<?php
/**
 * Template Name: tpl-book-detail (Wave2)
 *
 * WP-W2-10-E (Commerce) — elevated single book page (/books/<slug>).
 * Composition source of truth:
 *   _COMMUNICATION/team_35/WP-W2-10-E/elevation/mockup/commerce-book-detail.html
 *   (mockup is /books/vekatavta; cloned for kushi-blantis + tsva-bekahol).
 *
 * Block order (spec §3): topnav · book-hero (real cover 1fr/220px split +
 * kicker + price-on-CTA) · meta strip · summary · excerpt (OPEN) · about ·
 * gallery (1 real + gaps) · who · mid-CTA (print --primary + e-book
 * --secondary) · FAQ ×4 (verbatim) · closing CTA · footer-social.
 *
 * One data-driven render path serves all 3 books: copy from
 * ea_w2_03_book_content( $slug ) (verbatim SSoT), cover/meta/vendor from the
 * E maps in inc/wave2-w2-05.php. Single H1 (the book title) per page.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_view = function_exists( 'ea_w2_03_current_view' ) ? ea_w2_03_current_view() : '';
$ea_slug = ( $ea_view && 'catalog' !== $ea_view ) ? $ea_view : '';
$ea_book = ( '' !== $ea_slug && function_exists( 'ea_w2_03_book_content' ) ) ? ea_w2_03_book_content( $ea_slug ) : null;

get_header();

set_query_var( 'ea_topnav_active', 'books' );
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-book-detail ea-book-page">
	<?php
	if ( is_array( $ea_book ) && function_exists( 'ea_w2_05_render_book_detail' ) ) {
		echo ea_w2_05_render_book_detail( $ea_slug, $ea_book ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped at source.
	} else {
		// Defensive fallback — render the raw WP content if the book is unknown.
		echo '<div class="ea-section"><div class="ea-section__inner">';
		while ( have_posts() ) {
			the_post();
			the_title( '<h1 class="ea-section__heading">', '</h1>' );
			the_content();
		}
		echo '</div></div>';
	}
	?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
