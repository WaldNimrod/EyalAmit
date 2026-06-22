<?php
/**
 * Chapters part — horizontal CTA band with logo motif (.cta-band--row).
 * $args: title, body, cta_label, cta_url, id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a = isset( $args ) && is_array( $args ) ? $args : array();
?>
<section class="cta-band cta-band--row"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<span class="cta-band__logo cta-band__logo--side" aria-hidden="true"></span>
	<div class="cta-band__in">
		<div class="cta-band__txt r">
			<h2 class="cta-band__h"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
			<?php if ( ! empty( $a['body'] ) ) : ?><p class="cta-band__p"><?php echo esc_html( $a['body'] ); ?></p><?php endif; ?>
		</div>
		<?php if ( ! empty( $a['cta_label'] ) ) : ?>
			<div class="cta-band__act r r2"><a class="btn btn--terra" href="<?php echo esc_url( $a['cta_url'] ?? '#' ); ?>"><?php echo esc_html( $a['cta_label'] ); ?></a></div>
		<?php endif; ?>
	</div>
</section>
