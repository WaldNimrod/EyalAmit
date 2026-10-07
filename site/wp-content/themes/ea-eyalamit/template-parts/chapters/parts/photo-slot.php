<?php
/**
 * Chapters part — empty photo slot. Label is a standing reservation, not copy.
 *
 * $args: label (visible + aria), id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$label = isset( $a['label'] ) && '' !== $a['label'] ? (string) $a['label'] : 'Photo — to be chosen';
$src   = isset( $a['image'] ) ? (string) $a['image'] : '';
if ( '' !== $src && function_exists( 'ea_chapters_asset_url' ) && ! preg_match( '#^https?://#', $src ) ) {
	$src = ea_chapters_asset_url( $src );
}
?>
<section class="sec"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap">
		<figure class="ea-photo-slot">
			<?php if ( '' !== $src ) : ?>
			<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( (string) ( $a['alt'] ?? '' ) ); ?>" loading="lazy">
			<?php else : ?>
			<div class="ph" role="img" aria-label="<?php echo esc_attr( $label ); ?>">
				<span><?php echo ea_esc_visible_text( $label ); ?></span>
			</div>
			<?php endif; ?>
		</figure>
	</div>
</section>
