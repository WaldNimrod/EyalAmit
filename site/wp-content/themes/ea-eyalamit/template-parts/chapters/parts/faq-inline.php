<?php
/**
 * Chapters part — FAQ accordion from args items (not the shared CPT bank).
 *
 * S006 R1-02 · document-exact /treatment/?compare=eyal uses this so the five
 * snoring/CPAP questions (treatment-16..20) do not appear. Markup matches
 * block-faq-list view-only. Does not edit block-faq-list.php.
 *
 * $args: chap, title, id, items[{q,a}]
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
if ( empty( $items ) ) {
	return;
}
$ea_faq_cls = 'ea-faq-list ea-faq-list--view-only' . ( ! empty( $a['cards'] ) ? ' ea-faq-list--cards' : '' );
?>
<section class="<?php echo esc_attr( $ea_faq_cls ); ?>" data-block="faq-list"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="ea-faq-list__inner">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap chap--c r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<div class="ea-faq-category">
			<?php
			$ea_faq_i = 0;
			foreach ( $items as $item ) :
				$q = isset( $item['q'] ) ? (string) $item['q'] : '';
				$ans = isset( $item['a'] ) ? (string) $item['a'] : '';
				if ( '' === $q ) {
					continue;
				}
				$ea_open = ( ! empty( $a['open_first'] ) && 0 === $ea_faq_i ) ? ' open' : '';
				$ea_faq_i++;
				?>
				<details class="ea-faq-item ea-entrance"<?php echo $ea_open; ?>>
					<summary class="ea-faq-item__question"><?php echo esc_html( $q ); ?></summary>
					<div class="ea-faq-item__answer"><?php echo wp_kses_post( $ans ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
