<?php
/**
 * «חדש באתר» card row (T-IA-SPOTLIGHT). Image + title + up to two lines.
 *
 * Home page (T-IA-SPOTLIGHT's original spot, immediately after the hero):
 * called with no $args — reads the ACF-or-default 'now_cards' rows exactly
 * as before. Eyal swaps every slot there via ACF.
 *
 * Round C (2026-09-24): reused on the books page too (immediately after its
 * own hero) — the mandate's own instruction was explicit: "Reuse it — do
 * not copy the markup into a second file... If the component is hard-wired
 * to the home page, make it accept its cards as a parameter rather than
 * forking it." $args['cards'] overrides the ACF/default rows. The section
 * id stays the literal "ea-now" (and its ea-open-round.css styling) on
 * every page that uses this partial — ids only need to be unique within one
 * document, and this partial never renders twice on the same page, so
 * reusing it costs nothing and avoids a second, id-scoped copy of that CSS.
 * Row shape is identical either way: image, title, line1, line2, url — see
 * inc/chapters/acf-fields-home.php's 'now_cards' field group for the ACF
 * side of that shape.
 *
 * @param array{cards?:array[]} $args
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_spot_a = isset( $args ) && is_array( $args ) ? $args : array();
$cards     = isset( $ea_spot_a['cards'] ) ? $ea_spot_a['cards'] : ea_chapters_rows( 'now_cards' );
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
