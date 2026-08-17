<?php
/**
 * Home-only SECTION 09 — approved prose + media placeholder + CTA from Excel.
 *
 * S006 · טקסט: content 13.8.26/דף הבית/homepage1-3 v2.md · SECTION 09
 *        (שדות closing_* קיימים — שמות השדה לא שונו, חוב טכני מחוץ לסקואופ).
 * S006 · מדיה: סקירה דף הבית.xlsx · גיליון1!C15 — «גלריה / וידאו משני»
 *        «תמונות אותנטיות בלבד (לא stock)». הפלייסהולדר בנוי; H-07 נשאר ממתין לאייל.
 * S006 · CTA: אותו תא C15 — «[לתיאום שיחת היכרות](/contact)» מילה-במילה.
 *
 * Home-only file — does not edit shared parts/*.php.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$body = (string) ea_chapters_field( 'closing_body' );
if ( '' === trim( $body ) ) {
	return;
}

$chap     = (string) ea_chapters_field( 'closing_chap' );
$title    = (string) ea_chapters_field( 'closing_title' );
$plabel   = (string) ea_chapters_field( 'peek_media_placeholder' );
$cta_l    = (string) ea_chapters_field( 'peek_cta_label' );
$cta_u    = (string) ea_chapters_field( 'peek_cta_url' );
?>
<section class="sec" id="peek">
	<div class="wrap">
		<?php if ( $chap ) : ?><span class="chap r"><?php echo esc_html( $chap ); ?></span><?php endif; ?>
		<?php if ( $title ) : ?><h2 class="h2 r" style="margin-bottom:18px"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
		<div class="intro-body r r2"><?php echo wp_kses_post( $body ); ?></div>
		<?php if ( $plabel ) : ?>
		<div class="gallery r" style="margin-top:32px">
			<figure class="gfig gfig--pending">
				<div class="ea-pending-approval" role="status">
					<span class="ea-pending-approval__badge">ממתין לאישור</span>
					<p class="ea-pending-approval__title"><?php echo esc_html( $plabel ); ?></p>
				</div>
			</figure>
		</div>
		<?php endif; ?>
		<?php if ( $cta_l ) : ?>
		<p class="r" style="margin-top:24px"><a class="tlink" href="<?php echo esc_url( $cta_u ); ?>"><?php echo esc_html( $cta_l ); ?></a></p>
		<?php endif; ?>
	</div>
</section>
