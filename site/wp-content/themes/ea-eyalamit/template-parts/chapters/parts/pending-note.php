<?php
/**
 * Chapters part — pending-approval note (section-level glow marker).
 * Canonical replacement for hand-injected .ea-pending-approval HTML in prose bodies
 * (WP-S4-06). Use for prose/legal/EN/temp-CTA sections that have no media slot.
 * $args: chap, title (REQUIRED), note (REQUIRED), id, alt
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;
$a = isset( $args ) && is_array( $args ) ? $args : array();
if ( empty( $a['title'] ) ) { return; }
?>
<section class="sec<?php echo ! empty( $a['alt'] ) ? ' sec--alt' : ''; ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap center">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap chap--c r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<div class="ea-pending-approval r" role="status" aria-live="polite">
			<span class="ea-pending-approval__badge">ממתין לאישור</span>
			<p class="ea-pending-approval__title"><?php echo esc_html( $a['title'] ); ?></p>
			<?php if ( ! empty( $a['note'] ) ) : ?>
				<p class="ea-pending-approval__note"><?php echo wp_kses_post( $a['note'] ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
