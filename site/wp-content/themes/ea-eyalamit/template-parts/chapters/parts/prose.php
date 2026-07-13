<?php
/**
 * Chapters part — prose section (.intro-body). $args: chap, title, body(HTML), center(bool), alt, dark, id,
 * collapsible(bool) + toggle_label — when collapsible is true, body renders inside a closed-by-default
 * <details>/<summary> instead of a plain div (e.g. long reading excerpts).
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
$center      = ! empty( $a['center'] );
$collapsible = ! empty( $a['collapsible'] );
/* No scroll-reveal classes when collapsible: content nested inside a closed <details> never
   intersects the viewport, so the IntersectionObserver in ea-chapters.js never fires and the
   text would stay at opacity:0 forever, even after the user opens it. Matches the existing
   faq.php accordion, which deliberately keeps reveal classes off content nested in <details>. */
$body_cls    = $collapsible ? 'intro-body' : 'intro-body r r2';
$body_style  = $center ? ' style="margin-inline:auto"' : '';
?>
<section class="<?php echo esc_attr( $cls ); ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap<?php echo $center ? ' center' : ''; ?>">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap<?php echo $center ? ' chap--c' : ''; ?> r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r" style="margin-bottom:18px"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<?php if ( $collapsible ) : ?>
			<details class="prose-acc">
				<summary class="prose-acc__t"><?php echo esc_html( $a['toggle_label'] ?? 'לחצו לקריאה' ); ?></summary>
				<div class="<?php echo esc_attr( $body_cls ); ?>"<?php echo $body_style; ?>><?php echo wp_kses_post( $a['body'] ?? '' ); ?></div>
			</details>
		<?php else : ?>
			<div class="<?php echo esc_attr( $body_cls ); ?>"<?php echo $body_style; ?>><?php echo wp_kses_post( $a['body'] ?? '' ); ?></div>
		<?php endif; ?>
	</div>
</section>
