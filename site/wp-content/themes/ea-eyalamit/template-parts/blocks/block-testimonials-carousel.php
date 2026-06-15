<?php
/**
 * Block: testimonials-carousel — WP-W2-16-B (D-EYAL-TESTIMONIALS-14 = א).
 *
 * Continuous RTL auto-scroll marquee of testimonial cards (Eyal #2). Reads the
 * same `ea_testimonials_ctx` query var as block-testimonials-row (heading,
 * aria_label, items[text|name|href|avatar], footer, ghost_cta), so callers swap
 * the block slug without reshaping data. Falls back to the canonical FB Top-5.
 *
 * Pure CSS motion (assets/css/testimonials-carousel.css): the card set is
 * rendered twice for a seamless loop; the second (dupe) set is aria-hidden and
 * its links are removed from the tab order. Pauses on hover/focus; reduced-motion
 * collapses to a static, horizontally-scrollable row.
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_tc_ctx = get_query_var( 'ea_testimonials_ctx' );
if ( ! is_array( $ea_tc_ctx ) ) {
	$ea_tc_ctx = array();
}

$ea_tc_heading = isset( $ea_tc_ctx['heading'] ) ? (string) $ea_tc_ctx['heading'] : 'עדויות והמלצות';
$ea_tc_aria    = isset( $ea_tc_ctx['aria_label'] ) ? (string) $ea_tc_ctx['aria_label'] : 'עדויות לקוחות';

$ea_tc_items = ( isset( $ea_tc_ctx['items'] ) && is_array( $ea_tc_ctx['items'] ) ) ? $ea_tc_ctx['items'] : array();
if ( empty( $ea_tc_items ) && function_exists( 'ea_w2_07_fb_testimonials' ) ) {
	$ea_tc_items = ea_w2_07_fb_testimonials();
}
if ( empty( $ea_tc_items ) ) {
	return;
}

$ea_tc_footer    = ( isset( $ea_tc_ctx['footer'] ) && is_array( $ea_tc_ctx['footer'] ) ) ? $ea_tc_ctx['footer'] : null;
$ea_tc_ghost_cta = ( isset( $ea_tc_ctx['ghost_cta'] ) && is_array( $ea_tc_ctx['ghost_cta'] ) ) ? $ea_tc_ctx['ghost_cta'] : null;

// Per-instance speed: ~6s per card so the perceived scroll rate is constant
// regardless of how many testimonials feed the carousel. Min 28s.
$ea_tc_duration = max( 28, count( $ea_tc_items ) * 6 );

/**
 * Render one testimonial card. $is_dupe → interactive name link is pulled from
 * the tab order (the duplicate set exists only for the seamless visual loop).
 */
$ea_tc_render_card = static function ( $item, $is_dupe ) {
	$text   = isset( $item['text'] ) ? (string) $item['text'] : '';
	$name   = isset( $item['name'] ) ? (string) $item['name'] : '';
	$href   = isset( $item['href'] ) ? (string) $item['href'] : '';
	$avatar = isset( $item['avatar'] ) ? (string) $item['avatar'] : '';
	$tab    = $is_dupe ? ' tabindex="-1"' : '';
	?>
	<article class="ea-testimonial-card ea-entrance">
		<div class="ea-testimonial-card__figure" aria-hidden="true">
			<?php if ( '' !== $avatar ) : ?>
			<img class="ea-testimonial-card__avatar" src="<?php echo esc_url( $avatar ); ?>" alt="" width="48" height="48" loading="lazy">
			<?php else : ?>
			<span class="ea-testimonial-card__avatar-placeholder"></span>
			<?php endif; ?>
		</div>
		<blockquote class="ea-testimonial-card__quote">
			<p class="ea-testimonial-card__text"><?php echo nl2br( esc_html( $text ) ); ?></p>
			<footer class="ea-testimonial-card__footer">
				<?php if ( '' !== $href ) : ?>
				<a class="ea-testimonial-card__name ea-link"
				   href="<?php echo esc_url( $href ); ?>"
				   target="_blank"
				   rel="noopener noreferrer"<?php echo $tab; // phpcs:ignore ?>
				   aria-label="<?php echo esc_attr( 'המלצת ' . $name . ' בפייסבוק (נפתח בחלון חדש)' ); ?>">
					<?php echo esc_html( $name ); ?>
				</a>
				<span class="ea-testimonial-card__hint" aria-hidden="true"> ↗</span>
				<?php else : ?>
				<span class="ea-testimonial-card__name"><?php echo esc_html( $name ); ?></span>
				<?php endif; ?>
			</footer>
		</blockquote>
	</article>
	<?php
};
?>
<section class="ea-testimonials-section ea-testi-carousel" data-block="testimonials-carousel" aria-label="<?php echo esc_attr( $ea_tc_aria ); ?>">
	<div class="ea-testimonials-section__inner">
		<h2 class="ea-testimonials-section__heading ea-entrance--breath"><?php echo esc_html( $ea_tc_heading ); ?></h2>
		<div class="ea-testi-carousel__viewport" role="group" tabindex="0" aria-label="<?php echo esc_attr( $ea_tc_aria . ' — קרוסלה נעה, עצירה במעבר עכבר או מיקוד' ); ?>">
			<div class="ea-testi-carousel__track" style="--ea-testi-duration: <?php echo esc_attr( $ea_tc_duration ); ?>s;">
				<?php for ( $ea_tc_dup = 0; $ea_tc_dup < 2; $ea_tc_dup++ ) : ?>
					<?php foreach ( $ea_tc_items as $ea_tc_item ) : ?>
					<div class="ea-testi-carousel__item"<?php echo $ea_tc_dup ? ' data-testi-dupe aria-hidden="true"' : ''; ?>>
						<?php $ea_tc_render_card( $ea_tc_item, (bool) $ea_tc_dup ); ?>
					</div>
					<?php endforeach; ?>
				<?php endfor; ?>
			</div>
		</div>
		<?php if ( is_array( $ea_tc_ghost_cta ) && ! empty( $ea_tc_ghost_cta['label'] ) && ! empty( $ea_tc_ghost_cta['href'] ) ) : ?>
		<div class="ea-testimonials-section__footer">
			<a class="ea-cta-pill ea-cta-pill--ghost" href="<?php echo esc_url( (string) $ea_tc_ghost_cta['href'] ); ?>"><?php echo esc_html( (string) $ea_tc_ghost_cta['label'] ); ?></a>
		</div>
		<?php elseif ( is_array( $ea_tc_footer ) && ! empty( $ea_tc_footer['label'] ) && ! empty( $ea_tc_footer['href'] ) ) : ?>
		<div class="ea-testimonials-section__footer">
			<a class="ea-link" href="<?php echo esc_url( (string) $ea_tc_footer['href'] ); ?>"><?php echo esc_html( (string) $ea_tc_footer['label'] ); ?></a>
		</div>
		<?php endif; ?>
	</div>
</section>
