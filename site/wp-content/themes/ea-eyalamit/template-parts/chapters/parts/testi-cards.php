<?php
/**
 * Chapters part — a small set of quote cards beside a preceding section.
 * $args: quotes (array of HTML strings, relocated verbatim from source content —
 * this part adds no wording, label, attribution or heading of its own), id.
 *
 * S007 M-09: team_00, «עדויות - ליד הסיפור».
 * 20.9.2026 — the side-column pairing this first shipped with was wrong and he
 * said so: it narrowed the story's text to a third of the page for the height of
 * two small cards. «ליד הסיפור» means AT THE RIGHT POINT IN IT, not in a parallel
 * column. This now renders as a normal full-width band placed between the two
 * halves of the narrative, directly under the sentence that introduces the quotes.
 * $args also takes alt(bool) so the band can share its neighbours' background.
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
<section class="sec ea-testi-cards<?php echo ! empty( $a['alt'] ) ? ' sec--alt' : ''; ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap">
		<div class="ea-testi-cards__list">
			<?php foreach ( $quotes as $ea_q ) : ?>
				<blockquote class="ea-testi-cards__card"><?php echo wp_kses_post( $ea_q ); ?></blockquote>
			<?php endforeach; ?>
		</div>
	</div>
</section>
