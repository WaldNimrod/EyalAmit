<?php
/**
 * Template Name: Book detail — דף ספר (tpl-book-detail)
 * Description: דף ספר בודד — hero banner (כריכה מטושטשת), כותרת, תקציר (lead), כריכה גדולה + lightbox, גוף.
 *              עיצוב: D-EYAL-DESIGN-STYLE-13 (V2.1, Heebo, no shadows, 1px lines, inner-page hero).
 *              Slugs: kushi-blantis · tsva-bechol-ve-zorek-layam · vekatavt.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
while ( have_posts() ) {
	the_post();

	// Hero background: featured image URL (for CSS custom property)
	$hero_img_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
	$hero_style   = $hero_img_url
		? ' style="--book-hero-bg: url(\'' . esc_url( $hero_img_url ) . '\')"'
		: '';

	// Parent page (מוזה hub) URL + title
	$parent_id    = (int) get_post()->post_parent;
	$parent_url   = $parent_id ? get_permalink( $parent_id ) : home_url( '/muzza/' );
	$parent_title = $parent_id ? get_the_title( $parent_id ) : 'מוזה הוצאה לאור';

	// Cover alt text
	$thumb_id  = get_post_thumbnail_id();
	$cover_alt = $thumb_id
		? (string) get_post_meta( $thumb_id, '_wp_attachment_image_alt', true )
		: esc_attr( get_the_title() );
	if ( ! $cover_alt ) {
		$cover_alt = esc_attr( get_the_title() );
	}
	?>

	<!-- §HERO — inner-page hero banner with blurred cover [V2.1 2026-04-11] -->
	<div class="ea-book-detail-hero"<?php echo $hero_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="ea-book-detail-hero__blur" aria-hidden="true"></div>
		<div class="ea-book-detail-hero__overlay" aria-hidden="true"></div>
		<div class="ea-book-detail-hero__content">
			<a href="<?php echo esc_url( $parent_url ); ?>" class="ea-book-detail-hero__back">
				← <?php echo esc_html( $parent_title ); ?>
			</a>
			<h1 class="ea-book-detail-hero__title reveal"><?php the_title(); ?></h1>
		</div>
	</div>

	<div class="inside-article">
		<div class="entry-content ea-book-detail">

			<?php if ( has_excerpt() ) : ?>
				<p class="ea-book-lead reveal"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
			<?php endif; ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<!-- Cover + lightbox [V2.1] -->
				<div class="ea-book-detail__cover-clearfix reveal">

					<div class="ea-book-cover-wrap">
						<input type="checkbox" id="ea-cover-lightbox" class="ea-cover-lightbox-toggle" aria-hidden="true">

						<figure class="ea-book-cover">
							<label for="ea-cover-lightbox" class="ea-cover-lightbox-trigger" aria-label="<?php esc_attr_e( 'הגדל כריכה', 'ea-eyalamit' ); ?>">
								<?php
								the_post_thumbnail(
									'large',
									array(
										'alt'   => esc_attr( $cover_alt ),
										'class' => 'ea-cover-img',
									)
								);
								?>
								<span class="ea-cover-zoom-hint" aria-hidden="true">&#x2295;</span>
							</label>
							<?php
							$cap = wp_get_attachment_caption( $thumb_id );
							if ( $cap ) {
								echo '<figcaption>' . esc_html( $cap ) . '</figcaption>';
							}
							?>
						</figure>

						<!-- Lightbox overlay — pure CSS (checkbox hack) -->
						<div class="ea-cover-lightbox-overlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'כריכת הספר מוגדלת', 'ea-eyalamit' ); ?>">
							<label for="ea-cover-lightbox" class="ea-cover-lightbox-close" aria-label="<?php esc_attr_e( 'סגור', 'ea-eyalamit' ); ?>">&#x2715;</label>
							<?php
							the_post_thumbnail(
								'full',
								array(
									'alt'   => '',
									'class' => 'ea-cover-lightbox-img',
								)
							);
							?>
						</div>
					</div>

					<div class="ea-book-body">
						<?php the_content(); ?>
					</div>

				</div>
			<?php else : ?>
				<div class="ea-book-body reveal">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
	<?php
}
get_footer();
