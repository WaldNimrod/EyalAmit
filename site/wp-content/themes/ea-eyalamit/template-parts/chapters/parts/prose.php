<?php
/**
 * Chapters part — prose section (.intro-body). $args: chap, title, body(HTML), center(bool), alt, dark, id
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
$center = ! empty( $a['center'] );
?>
<section class="<?php echo esc_attr( $cls ); ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap<?php echo $center ? ' center' : ''; ?>">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap<?php echo $center ? ' chap--c' : ''; ?> r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r" style="margin-bottom:18px"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<div class="intro-body r r2"<?php echo $center ? ' style="margin-inline:auto"' : ''; ?>><?php echo wp_kses_post( $a['body'] ?? '' ); ?></div>
	</div>
</section>
