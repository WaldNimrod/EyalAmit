<?php
/**
 * Chapters part — horizontal CTA band with logo motif (.cta-band--row).
 * $args: title, body, cta_label, cta_url, cta2_label, cta2_url (optional — renders a second button for a split CTA), cta_slug (optional — see phero.php's identical convention), id
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
			<div class="cta-band__act r r2<?php echo ! empty( $a['cta2_label'] ) ? ' cta-band__act-group' : ''; ?>">
				<a class="btn btn--terra"
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
