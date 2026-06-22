<?php
/**
 * Chapters part — full-bleed photo band with pull-quote. $args: image, alt, quote, attrib
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a = isset( $args ) && is_array( $args ) ? $args : array();
?>
<section class="bleed" aria-label="<?php echo esc_attr( $a['alt'] ?? '' ); ?>">
	<?php if ( ! empty( $a['image'] ) ) : ?>
		<img class="r r--fade" src="<?php echo esc_url( $a['image'] ); ?>" alt="<?php echo esc_attr( $a['alt'] ?? '' ); ?>" loading="lazy">
	<?php endif; ?>
	<span class="bleed__sc" aria-hidden="true"></span>
	<div class="bleed__c"><div class="bleed__in">
		<p class="bleed__q r"><?php echo esc_html( $a['quote'] ?? '' ); ?></p>
		<?php if ( ! empty( $a['attrib'] ) ) : ?><p class="bleed__a r"><?php echo esc_html( $a['attrib'] ); ?></p><?php endif; ?>
	</div></div>
</section>
