<?php
/**
 * Chapters part — FAQ (.faq, native details/summary). $args: chap, title, items[{q,a(HTML)}], id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
?>
<section class="sec"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap center">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap chap--c r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h2 class="h2 r"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
		<div class="faq r">
			<?php foreach ( $items as $it ) : ?>
				<details class="faq__i">
					<summary><?php echo esc_html( $it['q'] ?? '' ); ?></summary>
					<p><?php echo wp_kses_post( $it['a'] ?? '' ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
