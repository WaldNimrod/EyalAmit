<?php
/**
 * Home — «עכשיו באתר» (T-IA-SPOTLIGHT). Cards only. Eyal swaps every slot.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$cards = ea_chapters_rows( 'now_cards' );
if ( empty( $cards ) ) {
	return;
}
?>
<section class="sec" id="ea-now">
	<div class="wrap">
		<div class="ea-now">
			<?php foreach ( $cards as $row ) : ?>
				<?php
				$href  = isset( $row['url'] ) ? (string) $row['url'] : '';
				$title = isset( $row['title'] ) ? (string) $row['title'] : '';
				$src   = function_exists( 'ea_chapters_resolve_img' ) ? ea_chapters_resolve_img( isset( $row['image'] ) ? $row['image'] : '' ) : '';
				if ( $href && ! preg_match( '#^(https?:)?//#', $href ) ) {
					$href = home_url( $href );
				}
				?>
			<a class="ea-now__card" href="<?php echo esc_url( $href ? $href : '#' ); ?>">
				<div class="ea-now__ph">
					<?php if ( $src ) : ?>
					<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
					<?php endif; ?>
				</div>
				<div class="ea-now__tx">
					<?php if ( $title ) : ?><h3 class="ea-now__t"><?php echo esc_html( $title ); ?></h3><?php endif; ?>
					<?php if ( ! empty( $row['line1'] ) ) : ?><p class="ea-now__run"><?php echo esc_html( $row['line1'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $row['line2'] ) ) : ?><p class="ea-now__run"><?php echo esc_html( $row['line2'] ); ?></p><?php endif; ?>
				</div>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
