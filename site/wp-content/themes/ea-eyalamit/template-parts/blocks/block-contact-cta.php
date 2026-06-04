<?php
/**
 * Block: contact-cta — D-14/POC Wave2.
 *
 * Generic / data-driven (WP-W2-10-A Phase 0b). Reads optional context from the
 * `ea_cta_ctx` query var.
 *
 * Two layout variants:
 *   - default ('split'): the original HOME contact section (CTA copy + CF7 form).
 *                        Renders byte-identically when no context is set.
 *   - 'band': a centered closing CTA band (atom `ea-section--cta`) — heading +
 *             body paragraphs + a single primary CTA pill. No form. Used by the
 *             service template (block #12).
 *
 * Context shape (all keys optional):
 *   array(
 *     'variant'    => 'split' | 'band',
 *     'heading'    => string,
 *     'body'       => string[],                    // paragraph strings
 *     'cta'        => array( 'label' => string, 'href' => string ),
 *     'aria_label' => string,
 *   )
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_cta_ctx = get_query_var( 'ea_cta_ctx' );
if ( ! is_array( $ea_cta_ctx ) ) {
	$ea_cta_ctx = array();
}

$ea_cta_variant = isset( $ea_cta_ctx['variant'] ) ? (string) $ea_cta_ctx['variant'] : 'split';

if ( 'band' === $ea_cta_variant ) :
	$ea_cta_heading = isset( $ea_cta_ctx['heading'] ) ? (string) $ea_cta_ctx['heading'] : 'לתיאום שיחת היכרות';
	$ea_cta_aria    = isset( $ea_cta_ctx['aria_label'] ) ? (string) $ea_cta_ctx['aria_label'] : $ea_cta_heading;
	// Optional sr-only structural section label (e.g. the source's "CTA סופי"
	// marker). Reuses the locked ea-sr-only atom — no new token. When set, the
	// visible heading uses the CTA button label so no structural jargon shows.
	$ea_cta_sr_label = isset( $ea_cta_ctx['sr_label'] ) ? (string) $ea_cta_ctx['sr_label'] : '';
	$ea_cta_body    = ( isset( $ea_cta_ctx['body'] ) && is_array( $ea_cta_ctx['body'] ) ) ? $ea_cta_ctx['body'] : array();
	$ea_cta_btn     = isset( $ea_cta_ctx['cta'] ) && is_array( $ea_cta_ctx['cta'] ) ? $ea_cta_ctx['cta'] : array();
	$ea_cta_label   = isset( $ea_cta_btn['label'] ) ? (string) $ea_cta_btn['label'] : 'לתיאום שיחת היכרות';
	$ea_cta_href    = isset( $ea_cta_btn['href'] ) ? (string) $ea_cta_btn['href'] : home_url( '/contact' );
	?>
<section class="ea-section ea-section--cta ea-section--cta--ink ea-section--closing" data-block="contact-cta" aria-label="<?php echo esc_attr( $ea_cta_aria ); ?>">
      <div class="ea-section__inner ea-section__inner--center ea-entrance--breath">
        <?php if ( '' !== $ea_cta_sr_label ) : ?>
        <span class="ea-sr-only"><?php echo esc_html( $ea_cta_sr_label ); ?></span>
        <?php endif; ?>
        <h2 class="ea-section__heading"><?php echo esc_html( $ea_cta_heading ); ?></h2>
        <?php foreach ( $ea_cta_body as $ea_cta_p ) : ?>
        <p class="ea-section__list"><?php echo esc_html( (string) $ea_cta_p ); ?></p>
        <?php endforeach; ?>
        <a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( $ea_cta_href ); ?>">
          <?php echo esc_html( $ea_cta_label ); ?>
        </a>
      </div>
    </section>
	<?php
	return;
endif;

// ── default 'split' variant — original HOME contact section ──────────────────
$ea_cta_heading = isset( $ea_cta_ctx['heading'] ) ? (string) $ea_cta_ctx['heading'] : 'מתחילים בצעד פשוט';
$ea_cta_btn     = isset( $ea_cta_ctx['cta'] ) && is_array( $ea_cta_ctx['cta'] ) ? $ea_cta_ctx['cta'] : array();
$ea_cta_label   = isset( $ea_cta_btn['label'] ) ? (string) $ea_cta_btn['label'] : 'לתיאום שיחת היכרות';
$ea_cta_href    = isset( $ea_cta_btn['href'] ) ? (string) $ea_cta_btn['href'] : home_url( '/contact' );

if ( isset( $ea_cta_ctx['body'] ) && is_array( $ea_cta_ctx['body'] ) && ! empty( $ea_cta_ctx['body'] ) ) {
	$ea_cta_body = $ea_cta_ctx['body'];
} else {
	$ea_cta_body = array(
		'אם אתם מרגישים שהגיע הזמן להתחבר לנשימה שלכם, לחזק אותה, לווסת אותה ולהיכנס לתהליך הדרגתי, חווייתי ומהנה — אפשר להתחיל בשיחת היכרות קצרה.',
		'השיחה מאפשרת לשאול שאלות ולקבל כיוון ראשוני. אין צורך להתחייב מראש לתהליך.',
	);
}
?>
<section class="ea-contact-section" data-block="contact-cta" aria-label="יצירת קשר">
      <div class="ea-contact-section__inner">

        <!-- CTA side -->
        <div class="ea-contact-section__cta-side ea-entrance--breath">
          <h2 class="ea-contact-section__heading"><?php echo esc_html( $ea_cta_heading ); ?></h2>
          <?php foreach ( $ea_cta_body as $ea_cta_p ) : ?>
          <p class="ea-contact-section__body">
            <?php echo esc_html( (string) $ea_cta_p ); ?>
          </p>
          <?php endforeach; ?>
          <a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( $ea_cta_href ); ?>">
            <?php echo esc_html( $ea_cta_label ); ?>
          </a>
          <p class="ea-contact-form__note ea-contact-form__note--cta">
            אפשר גם לשלוח הודעה ישירה בוואטסאפ ↙
          </p>
        </div>

        <!-- SLOT: cf7-form-id — atom-interaction-contact-form -->
        <div class="ea-contact-section__form ea-entrance">
          <?php ea_wave2_render_contact_form(); ?>
        </div>

      </div>
    </section>
