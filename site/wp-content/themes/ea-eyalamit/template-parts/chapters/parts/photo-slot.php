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
?>
<section class="sec"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap">
		<figure class="ea-photo-slot">
			<div class="ph" role="img" aria-label="<?php echo esc_attr( $label ); ?>">
				<span><?php echo esc_html( $label ); ?></span>
			</div>
		</figure>
	</div>
</section>
