<?php
/**
 * Chapters part — a small set of quote cards beside a preceding section.
 * $args: quotes (array of HTML strings, relocated verbatim from source content —
 * this part adds no wording, label, attribution or heading of its own), id.
 *
 * S007 M-09: team_00, «עדויות - ליד הסיפור» — pairs with the immediately
 * preceding .sec via the same display:contents + :has() technique as
 * .ea-toc-lede-lead (see chapters.css). The preceding section's own args must
 * set 'pairs_with_cards' => true (prose.php / split.php).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a      = isset( $args ) && is_array( $args ) ? $args : array();
$quotes = ( isset( $a['quotes'] ) && is_array( $a['quotes'] ) ) ? array_values( array_filter( $a['quotes'], 'strlen' ) ) : array();
if ( empty( $quotes ) ) {
	return;
}
?>
<section class="sec ea-testi-cards"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap">
		<div class="ea-testi-cards__list">
			<?php foreach ( $quotes as $ea_q ) : ?>
				<blockquote class="ea-testi-cards__card"><?php echo wp_kses_post( $ea_q ); ?></blockquote>
			<?php endforeach; ?>
		</div>
	</div>
</section>
