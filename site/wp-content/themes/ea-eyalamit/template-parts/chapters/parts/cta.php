<?php
/**
 * Chapters part — horizontal CTA band with logo motif (.cta-band--row).
 * $args: title, body, cta_label, cta_url, cta2_label, cta2_url (optional — renders a second button for a split CTA), cta_slug (optional — see phero.php's identical convention), id,
 * stack (bool — column, no logo), choc (bool — chocolate fill), sand (bool — --ea-sand fill, /method/ colour test only), btn (optional class, default btn--terra).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a = isset( $args ) && is_array( $args ) ? $args : array();
$ea_band = 'cta-band' . ( ! empty( $a['stack'] ) ? ' cta-band--stack' : ' cta-band--row' );
if ( ! empty( $a['choc'] ) ) {
	$ea_band .= ' cta-band--choc';
}
if ( ! empty( $a['sand'] ) ) {
	$ea_band .= ' cta-band--sand';
}
$ea_btn = ! empty( $a['btn'] ) ? sanitize_html_class( (string) $a['btn'] ) : 'btn--terra';
?>
<section class="<?php echo esc_attr( $ea_band ); ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<?php if ( empty( $a['stack'] ) ) : ?>
		<span class="cta-band__logo cta-band__logo--side" aria-hidden="true"></span>
	<?php endif; ?>
	<div class="cta-band__in">
		<div class="cta-band__txt r">
			<?php /* S006 · H-08 · הכותרת אופציונלית: ה-CTA הסופי של דף הבית (SECTION 12)
				הוא פסקה + כפתור בלבד, ללא כותרת אצל אייל — עדיף לא לרנדר h2 ריק
				מאשר להמציא כותרת. עמודים שכן מעבירים 'title' לא מושפעים. */ ?>
			<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="cta-band__h"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
			<?php if ( ! empty( $a['body'] ) ) : ?><p class="cta-band__p"><?php echo esc_html( $a['body'] ); ?></p><?php endif; ?>
		</div>
		<?php if ( ! empty( $a['cta_label'] ) ) : ?>
			<div class="cta-band__act r r2<?php echo ! empty( $a['cta2_label'] ) ? ' cta-band__act-group' : ''; ?>">
				<a class="btn <?php echo esc_attr( $ea_btn ); ?>"
					href="<?php echo esc_url( $a['cta_url'] ?? '#' ); ?>"
					<?php if ( ! empty( $a['cta_slug'] ) ) : ?>target="_blank" rel="noopener noreferrer" data-ea-book-purchase data-ea-book-slug="<?php echo esc_attr( sanitize_title( $a['cta_slug'] ) ); ?>" aria-label="<?php echo esc_attr( $a['cta_label'] . ' (נפתח בלשונית חדשה)' ); ?>"<?php endif; ?>><?php echo esc_html( $a['cta_label'] ); ?></a>
				<?php if ( ! empty( $a['cta2_label'] ) ) : ?>
					<a class="btn btn--gw"
						href="<?php echo esc_url( $a['cta2_url'] ?? '#' ); ?>"
						<?php if ( ! empty( $a['cta_slug'] ) ) : ?>target="_blank" rel="noopener noreferrer" data-ea-book-purchase data-ea-book-slug="<?php echo esc_attr( sanitize_title( $a['cta_slug'] ) ); ?>" aria-label="<?php echo esc_attr( $a['cta2_label'] . ' (נפתח בלשונית חדשה)' ); ?>"<?php endif; ?>><?php echo esc_html( $a['cta2_label'] ); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $a['temp_note'] ) ) : ?>
			<p class="ea-pending-inline" role="status" style="margin-top:10px"><span><?php echo esc_html( $a['temp_note'] ); ?></span></p>
		<?php endif; ?>
	</div>
</section>
