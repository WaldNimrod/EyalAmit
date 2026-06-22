<?php
/**
 * Chapters part — centered statement (chap + h2 + lead). $args: chap, title, lead, dark, alt(bg), id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a   = isset( $args ) && is_array( $args ) ? $args : array();
$cls = 'sec';
if ( ! empty( $a['dark'] ) ) {
	$cls .= ' sec--dark';
} elseif ( ! empty( $a['alt'] ) ) {
	$cls .= ' sec--alt';
}
?>
<section class="<?php echo esc_attr( $cls ); ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap center">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap chap--c r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h2 class="h2 r"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
		<?php if ( ! empty( $a['lead'] ) ) : ?><p class="lead r" style="margin:14px auto 0"><?php echo esc_html( $a['lead'] ); ?></p><?php endif; ?>
	</div>
</section>
