<?php
/**
 * Template Name: Books hub — מוזה (tpl-books)
 * Description: שער הוצאה לאור — hero banner + פתיח + כרטיסי ספר (ילדי העמוד) + bundle CTA.
 *              מזהה עץ: st-books · slug `muzza`.
 *              עיצוב: D-EYAL-DESIGN-STYLE-13 (V2.1, Heebo, no shadows, 1px lines, inner-page hero).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
while ( have_posts() ) {
	the_post();
	$parent_id = (int) get_the_ID();
	$children    = get_pages(
		array(
			'parent'      => $parent_id,
			'sort_column' => 'menu_order',
			'sort_order'  => 'asc',
		)
	);
	?>

	<!-- §HERO — inner-page hero banner [V2.1 2026-04-11] -->
	<div class="ea-books-hub-hero" role="img" aria-label="<?php echo esc_attr( get_the_title() . ' — הוצאת הספרים של אייל עמית' ); ?>">
		<div class="ea-books-hub-hero__overlay" aria-hidden="true"></div>
		<div class="ea-books-hub-hero__content">
			<span class="ea-section-label"><?php esc_html_e( 'הוצאה לאור', 'ea-eyalamit' ); ?></span>
			<h1 class="ea-books-hub-hero__title"><?php the_title(); ?></h1>
		</div>
	</div>

	<div class="inside-article">
		<div class="entry-content ea-books-hub">

			<div class="ea-books-hub-intro reveal">
				<?php the_content(); ?>
			</div>

			<?php if ( ! empty( $children ) ) : ?>
				<ul id="books-grid" class="ea-books-hub-grid reveal" role="list">
					<?php
					foreach ( $children as $child ) {
						$child_id = (int) $child->ID;
						$link     = get_permalink( $child_id );
						$thumb    = get_the_post_thumbnail(
							$child_id,
							'medium_large',
							array(
								'class' => 'ea-books-hub-card__img',
								'alt'   => esc_attr( get_the_title( $child_id ) ),
							)
						);
						$raw_excerpt = (string) get_post_field( 'post_excerpt', $child_id );
						$excerpt     = $raw_excerpt !== '' ? wp_strip_all_tags( $raw_excerpt ) : '';
						?>
						<li class="ea-books-hub-card">
							<?php if ( $thumb ) : ?>
								<figure class="ea-books-hub-card__media">
									<a href="<?php echo esc_url( $link ); ?>"><?php echo $thumb; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
								</figure>
							<?php endif; ?>
							<div class="ea-books-hub-card__body">
								<h2 class="ea-books-hub-card__title">
									<a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( get_the_title( $child_id ) ); ?></a>
								</h2>
								<?php if ( $excerpt !== '' ) : ?>
									<p class="ea-books-hub-card__excerpt"><?php echo esc_html( $excerpt ); ?></p>
								<?php endif; ?>
								<p class="ea-books-hub-card__cta">
									<a href="<?php echo esc_url( $link ); ?>"><?php esc_html_e( 'לעמוד הספר', 'ea-eyalamit' ); ?></a>
								</p>
							</div>
						</li>
						<?php
					}
					?>
				</ul>

				<!-- Bundle CTA — V2, D-EYAL-DESIGN-STYLE-13 -->
				<div class="ea-books-bundle reveal">
					<div class="ea-books-bundle__accent" aria-hidden="true"></div>
					<span class="ea-section-label"><?php esc_html_e( 'הצעה מיוחדת', 'ea-eyalamit' ); ?></span>
					<h2 class="ea-books-bundle__title"><?php esc_html_e( 'חבילת 3 הספרים של אייל עמית', 'ea-eyalamit' ); ?></h2>
					<p class="ea-books-bundle__desc">
						<?php esc_html_e( 'שלושת הספרים יחד במחיר מיוחד —', 'ea-eyalamit' ); ?>
						<strong>150 &#8362; <?php esc_html_e( 'במקום 207 ₪', 'ea-eyalamit' ); ?></strong>
					</p>
					<div class="ea-books-bundle__cta">
						<a href="#TODO_BUNDLE_URL" class="ea-btn ea-btn--primary">
							<?php esc_html_e( 'לרכישת החבילה', 'ea-eyalamit' ); ?>
						</a>
						<a href="#books-grid" class="ea-btn ea-btn--ghost">
							<?php esc_html_e( 'לכל הספרים', 'ea-eyalamit' ); ?>
						</a>
					</div>
				</div>

			<?php else : ?>
				<p class="ea-books-hub-empty" role="status">
					<?php esc_html_e( 'אין עדיין עמודי ספר תחת מדור זה. הוסיפו עמודי משנה תחת «מוזה הוצאה לאור» בניהול.', 'ea-eyalamit' ); ?>
				</p>
			<?php endif; ?>

		</div>
	</div>
	<?php
}
get_footer();
