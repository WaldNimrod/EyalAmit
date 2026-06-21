<?php
/**
 * Chapters — full-bleed photo band with quote (rhythm separator).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$img = ea_chapters_img( 'band_image' );
$alt = ea_chapters_field( 'band_alt' );
?>
<section class="bleed" aria-label="<?php echo esc_attr( $alt ); ?>">
	<?php if ( $img ) : ?>
		<img class="r r--fade" src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
	<?php endif; ?>
	<span class="bleed__sc" aria-hidden="true"></span>
	<div class="bleed__c"><div class="bleed__in">
		<p class="bleed__q r"><?php echo esc_html( ea_chapters_field( 'band_quote' ) ); ?></p>
		<p class="bleed__a r"><?php echo esc_html( ea_chapters_field( 'band_attrib' ) ); ?></p>
	</div></div>
</section>
