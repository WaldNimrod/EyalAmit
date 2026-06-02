<?php
/**
 * Block: hero — D-14/POC Wave2.
 *
 * Generic / data-driven (WP-W2-10-A Phase 0b). Reads optional context from the
 * `ea_hero_ctx` query var. When no context is set, falls back to the original
 * hardcoded HOME hero copy so existing pages render byte-identically.
 *
 * Context shape (all keys optional):
 *   array(
 *     'kicker'    => string,                       // eyebrow line (sand, above title)
 *     'title'     => string,                       // H1 (allows <br>) — wp_kses on br
 *     'subtitle'  => string,                       // sub copy (allows <br>)
 *     'trust'     => string,                       // trust line (allows <br>)
 *     'ctas'      => array(                         // 0..n CTA pills (primary + ghost-white)
 *        array( 'label' => string, 'href' => string, 'variant' => 'primary'|'ghost-white'|'ghost' )
 *     ),
 *   )
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_hero_ctx = get_query_var( 'ea_hero_ctx' );
if ( ! is_array( $ea_hero_ctx ) ) {
	$ea_hero_ctx = array();
}

$ea_hero_allowed_br = array( 'br' => array() );

// Defaults = original hardcoded HOME hero (byte-identical when no context set).
$ea_hero_kicker   = isset( $ea_hero_ctx['kicker'] ) ? (string) $ea_hero_ctx['kicker'] : '';
$ea_hero_title    = isset( $ea_hero_ctx['title'] )
	? (string) $ea_hero_ctx['title']
	: 'המרכז לטיפול בנשימה באמצעות דיג׳רידו<br>שיטת cbDIDG של אייל עמית';
$ea_hero_subtitle = isset( $ea_hero_ctx['subtitle'] )
	? (string) $ea_hero_ctx['subtitle']
	: 'להחזיר שליטה על הנשימה דרך עבודה עם דיג׳רידו, תרגול נשימה וליווי אישי<br>בגישה טיפולית מבוססת דיג׳רידו ובהשראת חניכה אישית אצל מוקש דהימן';
$ea_hero_trust    = isset( $ea_hero_ctx['trust'] )
	? (string) $ea_hero_ctx['trust']
	: 'אייל עמית &middot; פועל מאז 1999 &middot; מהוותיקים בארץ בתחום &middot; מטפל ומלמד בשיטה שפותחה לאורך השנים &middot; בונה כלים בעבודת יד';

if ( isset( $ea_hero_ctx['ctas'] ) && is_array( $ea_hero_ctx['ctas'] ) ) {
	$ea_hero_ctas = $ea_hero_ctx['ctas'];
} else {
	$ea_hero_ctas = array(
		array(
			'label'   => 'לתיאום שיחת היכרות',
			'href'    => home_url( '/contact' ),
			'variant' => 'ghost-white',
		),
	);
}
?>
<section class="ea-hero" data-block="hero" aria-label="גיבור ראשי">
      <!-- Background: CSS gradient placeholder (variant_placeholder — pre-video delivery; zero external requests). Structure kept ready for a future <video> swap (Eyal asset blocked). -->
      <div class="ea-hero__bg" aria-hidden="true">
        <div class="ea-hero__gradient-bg"></div>
        <!-- Breathing overlay lines — decorative -->
        <span class="ea-hero__breath-line ea-hero__breath-line--1" aria-hidden="true"></span>
        <span class="ea-hero__breath-line ea-hero__breath-line--2" aria-hidden="true"></span>
        <span class="ea-hero__breath-line ea-hero__breath-line--3" aria-hidden="true"></span>
      </div>

      <!-- Dark overlay for contrast -->
      <div class="ea-hero__overlay" aria-hidden="true"></div>

      <!-- Content -->
      <div class="ea-hero__content">
        <?php if ( '' !== $ea_hero_kicker ) : ?>
        <p class="ea-hero__kicker"><?php echo esc_html( $ea_hero_kicker ); ?></p>
        <?php endif; ?>
        <h1 class="ea-hero__title">
          <?php echo wp_kses( $ea_hero_title, $ea_hero_allowed_br ); ?>
        </h1>
        <p class="ea-hero__subtitle">
          <?php echo wp_kses( $ea_hero_subtitle, $ea_hero_allowed_br ); ?>
        </p>
        <p class="ea-hero__trust">
          <?php echo wp_kses( $ea_hero_trust, $ea_hero_allowed_br ); ?>
        </p>
        <?php if ( ! empty( $ea_hero_ctas ) ) : ?>
        <div class="ea-hero__cta-wrap">
          <?php
          foreach ( $ea_hero_ctas as $ea_hero_cta ) {
            $ea_cta_label   = isset( $ea_hero_cta['label'] ) ? (string) $ea_hero_cta['label'] : '';
            $ea_cta_href    = isset( $ea_hero_cta['href'] ) ? (string) $ea_hero_cta['href'] : '';
            $ea_cta_variant = isset( $ea_hero_cta['variant'] ) ? (string) $ea_hero_cta['variant'] : 'ghost-white';
            if ( ! in_array( $ea_cta_variant, array( 'primary', 'ghost', 'ghost-white' ), true ) ) {
              $ea_cta_variant = 'ghost-white';
            }
            if ( '' === $ea_cta_label || '' === $ea_cta_href ) {
              continue;
            }
            printf(
              '<a class="ea-cta-pill ea-cta-pill--%1$s" href="%2$s">%3$s</a>',
              esc_attr( $ea_cta_variant ),
              esc_url( $ea_cta_href ),
              esc_html( $ea_cta_label )
            );
          }
          ?>
        </div>
        <?php endif; ?>
      </div>

    </section>
