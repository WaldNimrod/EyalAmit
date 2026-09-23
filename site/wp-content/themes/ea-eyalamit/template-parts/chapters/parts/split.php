<?php
/**
 * Chapters part — two-column text + figure (.split2 / .intro-body / .figr).
 * $args: chap, title, body (HTML), image (url), alt, figr ('l'|'p'|'w'), reversed(bool), id,
 * soft (bool — adds sec--alt; `alt` stays the image alt), cover (bool — split2--cover, no figr),
 * literal_alt (bool — keep an empty alt empty).
 *
 * The pairs_with_cards flag was removed on 2026-09-20 with the cards' side-column layout
 * (team_00 rejected it on screenshots). For a SMALL picture that should sit beside the text
 * without narrowing it, use prose.php's float_image instead of this part.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a   = isset( $args ) && is_array( $args ) ? $args : array();
$cls = 'sec';
if ( ! empty( $a['soft'] ) ) {
	$cls .= ' sec--alt';
}
$ea_split = 'split2' . ( ! empty( $a['reversed'] ) ? ' split2--rev' : '' ) . ( ! empty( $a['cover'] ) ? ' split2--cover' : '' );
?>
<section class="<?php echo esc_attr( $cls ); ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap">
		<div class="<?php echo esc_attr( $ea_split ); ?>">
			<div class="r">
				<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
				<h2 class="h2" style="margin-bottom:18px"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
				<div class="intro-body"><?php echo wp_kses_post( function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) ( $a['body'] ?? '' ) ) : ( $a['body'] ?? '' ) ); ?></div>
			</div>
			<?php
			$ea_img_src     = esc_url( $a['image'] ?? '' );
			$ea_img_alt_raw = (string) ( $a['alt'] ?? '' );
			if ( empty( $a['literal_alt'] ) && function_exists( 'ea_chapters_content_img_alt' ) ) {
				$ea_img_alt_raw = ea_chapters_content_img_alt( $a['image'] ?? '', $ea_img_alt_raw );
			}
			$ea_img_alt = esc_attr( $ea_img_alt_raw );
			$ea_fig_cls = ! empty( $a['cover'] )
				? 'split2__m'
				: 'figr figr--' . (string) ( $a['figr'] ?? 'l' ) . ' split2__m r r2';
			/* `zoom` is for document screenshots that have to sit beside their text and
			   still be readable — the image is small in a two-column split, so the button
			   opens it full size. Plain <img> when the flag is absent. */
			?>
			<figure class="<?php echo esc_attr( $ea_fig_cls ); ?>" style="margin:0">
				<?php if ( ! empty( $a['zoom'] ) ) : ?>
					<button type="button" class="zoom" data-zoom-src="<?php echo $ea_img_src; ?>" data-zoom-alt="<?php echo $ea_img_alt; ?>">
						<img src="<?php echo $ea_img_src; ?>" alt="<?php echo $ea_img_alt; ?>" loading="lazy">
						<span class="zoom__hint"><?php esc_html_e( 'להגדלה — לחצו על התמונה', 'ea-eyalamit' ); ?></span>
					</button>
				<?php else : ?>
					<img src="<?php echo $ea_img_src; ?>" alt="<?php echo $ea_img_alt; ?>" loading="lazy">
				<?php endif; ?>
			</figure>
		</div>
	</div>
</section>
