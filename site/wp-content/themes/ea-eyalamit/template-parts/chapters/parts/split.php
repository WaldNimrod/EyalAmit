<?php
/**
 * Chapters part — two-column text + figure (.split2 / .intro-body / .figr).
 * $args: chap, title, body (HTML), image (url), alt, figr ('l'|'p'|'w'), reversed(bool), id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a = isset( $args ) && is_array( $args ) ? $args : array();
?>
<section class="sec"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap">
		<div class="split2<?php echo ! empty( $a['reversed'] ) ? ' split2--rev' : ''; ?>">
			<div class="r">
				<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
				<h2 class="h2" style="margin-bottom:18px"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
				<div class="intro-body"><?php echo wp_kses_post( $a['body'] ?? '' ); ?></div>
			</div>
			<figure class="figr figr--<?php echo esc_attr( $a['figr'] ?? 'l' ); ?> split2__m r r2" style="margin:0">
				<img src="<?php echo esc_url( $a['image'] ?? '' ); ?>" alt="<?php echo esc_attr( $a['alt'] ?? '' ); ?>" loading="lazy">
			</figure>
		</div>
	</div>
</section>
