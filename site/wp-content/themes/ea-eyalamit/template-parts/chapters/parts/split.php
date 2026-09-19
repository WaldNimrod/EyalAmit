<?php
/**
 * Chapters part — two-column text + figure (.split2 / .intro-body / .figr).
 * $args: chap, title, body (HTML), image (url), alt, figr ('l'|'p'|'w'), reversed(bool), id,
 * pairs_with_cards(bool) — marks this .sec as the lead that sits beside a following
 * .ea-testi-cards part (class ea-cards-lede-lead; same display:contents + :has()
 * technique as prose.php's pairs_with_toc — see chapters.css).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a   = isset( $args ) && is_array( $args ) ? $args : array();
$cls = 'sec' . ( ! empty( $a['pairs_with_cards'] ) ? ' ea-cards-lede-lead' : '' );
?>
<section class="<?php echo esc_attr( $cls ); ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap">
		<div class="split2<?php echo ! empty( $a['reversed'] ) ? ' split2--rev' : ''; ?>">
			<div class="r">
				<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
				<h2 class="h2" style="margin-bottom:18px"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
				<div class="intro-body"><?php echo wp_kses_post( function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) ( $a['body'] ?? '' ) ) : ( $a['body'] ?? '' ) ); ?></div>
			</div>
			<?php
			$ea_img_src = esc_url( $a['image'] ?? '' );
			$ea_img_alt = esc_attr( function_exists( 'ea_chapters_content_img_alt' ) ? ea_chapters_content_img_alt( $a['image'] ?? '', $a['alt'] ?? '' ) : ( $a['alt'] ?? '' ) );
			/* `zoom` is for document screenshots that have to sit beside their text and
			   still be readable — the image is small in a two-column split, so the button
			   opens it full size. Plain <img> when the flag is absent. */
			?>
			<figure class="figr figr--<?php echo esc_attr( $a['figr'] ?? 'l' ); ?> split2__m r r2" style="margin:0">
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
