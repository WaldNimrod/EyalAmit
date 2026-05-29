<?php
/**
 * Template Name: tpl-book-detail (Wave2)
 * WP-W2-03 — single book page (/books/<slug>).
 * 14-block contract: hero(H1) · summary(תקציר) · excerpt(קטע מתוך) ·
 * about-the-book(על הספר) · gallery · purchase · who-it's-for(למי מתאים) ·
 * intermediate CTA · filtered FAQ · press mentions · closing CTA + about-Eyal.
 * Content verbatim (AC-05) via ea_w2_03_book_content().
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_view = function_exists( 'ea_w2_03_current_view' ) ? ea_w2_03_current_view() : '';
$ea_book = ( $ea_view && 'catalog' !== $ea_view ) ? ea_w2_03_book_content( $ea_view ) : null;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );

if ( ! $ea_book ) {
	// Defensive fallback — render the raw WP content if the book is unknown.
	echo '<main id="main" class="ea-wave2-book-detail"><div class="ea-section__inner">';
	while ( have_posts() ) {
		the_post();
		the_title( '<h1>', '</h1>' );
		the_content();
	}
	echo '</div></main>';
	get_template_part( 'template-parts/blocks/block', 'footer-social' );
	get_footer();
	return;
}

$ea_slug = $ea_view;
?>
<main id="main" class="ea-wave2-book-detail ea-book-page">

	<?php // BLOCK 01 — Hero (single H1 + subtitle + purchase CTA). ?>
	<section class="ea-book-hero" data-block="hero" aria-label="<?php echo esc_attr( $ea_book['title'] ); ?>">
		<div class="ea-book-hero__overlay" aria-hidden="true"></div>
		<div class="ea-book-hero__content">
			<a class="ea-book-hero__back" href="<?php echo esc_url( home_url( '/books' ) ); ?>">← מוזה הוצאה לאור</a>
			<h1 class="ea-book-hero__title"><?php echo esc_html( $ea_book['title'] ); ?></h1>
			<?php foreach ( (array) $ea_book['hero_sub'] as $ea_line ) : ?>
				<p class="ea-book-hero__subtitle"><?php echo esc_html( $ea_line ); ?></p>
			<?php endforeach; ?>
			<div class="ea-book-hero__cta-wrap">
				<?php ea_w2_03_render_purchase_button( $ea_slug, $ea_book['purchase_label'], '', 'ghost' ); ?>
			</div>
		</div>
	</section>

	<?php // BLOCK 02 — Summary (תקציר). ?>
	<section class="ea-section ea-section--prose" data-block="summary" aria-label="תקציר הספר">
		<div class="ea-section__inner ea-entrance--breath">
			<h2 class="ea-section__heading">תקציר הספר</h2>
			<div class="ea-book-prose"><?php echo wp_kses_post( $ea_book['summary'] ); ?></div>
		</div>
	</section>

	<?php // BLOCK 03 — Excerpt (קטע מתוך הספר) — accordion, default closed. ?>
	<section class="ea-section ea-section--alt" data-block="excerpt" aria-label="קטע מתוך הספר">
		<div class="ea-section__inner">
			<details class="ea-book-excerpt">
				<summary class="ea-book-excerpt__toggle"><?php echo esc_html( $ea_book['excerpt_label'] ); ?></summary>
				<div class="ea-book-excerpt__body ea-book-prose ea-book-prose--preserve">
					<?php echo wp_kses_post( $ea_book['excerpt_html'] ); ?>
				</div>
			</details>
		</div>
	</section>

	<?php // BLOCK 04 — About the book (על הספר). ?>
	<section class="ea-section ea-section--prose" data-block="about-book" aria-label="על הספר">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading">על הספר</h2>
			<div class="ea-book-prose"><?php echo wp_kses_post( $ea_book['about'] ); ?></div>
		</div>
	</section>

	<?php // BLOCK 05 — Gallery (grey placeholder until images supplied). ?>
	<section class="ea-section ea-section--alt" data-block="gallery" aria-label="גלריה">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading">גלריה</h2>
			<?php ea_w2_03_render_gallery_placeholder( 'גלריה', 5 ); ?>
		</div>
	</section>

	<?php // BLOCK 06 — Purchase (Green Invoice button — fallback to /contact). ?>
	<section class="ea-section ea-section--prose" data-block="purchase" aria-label="רכישת הספר">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading">רכישת הספר</h2>
			<div class="ea-book-prose"><?php echo wp_kses_post( $ea_book['purchase_section'] ); ?></div>
			<div class="ea-book-purchase-cta">
				<?php ea_w2_03_render_purchase_button( $ea_slug, $ea_book['purchase_label'] ); ?>
			</div>
		</div>
	</section>

	<?php // BLOCK 07 — Who it's for (למי הספר מתאים). ?>
	<section class="ea-section ea-section--alt ea-section--prose" data-block="who-for" aria-label="למי הספר מתאים">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading">למי הספר מתאים</h2>
			<div class="ea-book-prose"><?php echo wp_kses_post( $ea_book['who'] ); ?></div>
		</div>
	</section>

	<?php // BLOCK 08 — Intermediate CTA. ?>
	<section class="ea-section ea-section--cta" data-block="mid-cta" aria-label="קריאה לפעולה">
		<div class="ea-section__inner ea-section__inner--center">
			<p class="ea-book-midcta__text">רוצה להתחיל לקרוא כבר עכשיו?</p>
			<?php ea_w2_03_render_purchase_button( $ea_slug, $ea_book['purchase_label'] ); ?>
		</div>
	</section>

	<?php // BLOCK 09 — Filtered FAQ (book-specific). ?>
	<section class="ea-section ea-section--prose" data-block="faq" aria-label="שאלות ותשובות">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading">שאלות ותשובות</h2>
			<?php foreach ( (array) $ea_book['faq'] as $ea_qa ) : ?>
				<details class="ea-faq-item ea-entrance">
					<summary class="ea-faq-item__question"><?php echo esc_html( $ea_qa['q'] ); ?></summary>
					<div class="ea-faq-item__answer"><?php echo wp_kses_post( $ea_qa['a'] ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</section>

	<?php // BLOCK 10 — Press mentions. ?>
	<section class="ea-section ea-section--alt ea-section--prose" data-block="press" aria-label="כתבות מהעיתונות">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading">כתבות מהעיתונות</h2>
			<div class="ea-book-prose"><?php echo wp_kses_post( $ea_book['press'] ); ?></div>
		</div>
	</section>

	<?php // BLOCK 11 — Closing CTA. ?>
	<section class="ea-section ea-section--prose ea-section--closing" data-block="closing" aria-label="סגירה">
		<div class="ea-section__inner ea-section__inner--center">
			<div class="ea-book-prose"><?php echo wp_kses_post( $ea_book['closing'] ); ?></div>
			<div class="ea-book-purchase-cta">
				<?php ea_w2_03_render_purchase_button( $ea_slug, $ea_book['purchase_label'] ); ?>
			</div>
		</div>
	</section>

</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
