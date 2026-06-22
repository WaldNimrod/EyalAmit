<?php
/**
 * Chapters part — testimonials marquee (continuous side-scroll from the FB corpus,
 * brand-excluded, pause on hover). $args: chap, title, cat (optional category slug)
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ea_chapters_testimonials( $a['cat'] ?? '' );
if ( empty( $items ) ) {
	return;
}
$cards = static function () use ( $items ) {
	foreach ( $items as $it ) {
		echo '<figure class="tmq"><blockquote class="tmq__q">' . esc_html( $it['text'] ) . '</blockquote>';
		if ( '' !== $it['name'] ) {
			echo '<figcaption class="tmq__n">' . esc_html( $it['name'] ) . '</figcaption>';
		}
		echo '</figure>';
	}
};
?>
<section class="sec sec--alt">
	<div class="wrap center">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap chap--c r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h2 class="h2 r"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
	</div>
	<div class="testi-mq r" role="region" aria-label="<?php echo esc_attr( $a['title'] ?? 'עדויות' ); ?>">
		<div class="testi-mq__track"><?php $cards(); $cards(); ?></div>
	</div>
</section>
