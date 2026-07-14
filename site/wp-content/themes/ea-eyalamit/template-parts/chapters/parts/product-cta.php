<?php
/**
 * Chapters part — product price + purchase/contact CTA (WP-CANON-TEMPLATE-UNIFICATION T3).
 * Commerce accessors live in inc/chapters/chapters-commerce.php (T6 re-home; Wave2 w2-05 deleted):
 *   ea_w2_05_price() / ea_w2_05_gi_url() / ea_wave2_wa_url()
 * Structural wrapper (.sec/.wrap/.chap/.h2) is Chapters-native; price + CTA buttons reuse
 * .ea-product-price / .ea-cta-pill / .ea-cta-ab (ea-atoms / remaining stage-b enqueue).
 * data-* attributes match the GA4 product_cta_click contract for assets/js/ea-ab-testing.js.
 *
 * $args:
 *   slug          (string, REQUIRED) — didgeridoos|bags|stands-storage|stand-floor|repair
 *   title         (string) — H2 heading
 *   body          (string, plain text) — supporting paragraph
 *   price_note    (string, optional) — small print under the price line
 *   gi_label      (string, optional) — Green-Invoice button label; default 'לרכישה מאובטחת'
 *   contact_label (string, optional) — contact/form button label; default 'לתיאום והתאמה'
 *   alt           (bool, optional) — sec--alt background; default false
 *   id            (string, optional) — section anchor id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a    = isset( $args ) && is_array( $args ) ? $args : array();
$slug = isset( $a['slug'] ) ? (string) $a['slug'] : '';
$alt  = ! empty( $a['alt'] );

// Reuse — NOT duplicate — the Wave2 accessors (single source of truth).
// get_queried_object_id() (not get_the_ID()): tpl-chapters-page.php has no have_posts()/
// the_post() Loop, so global $post is not guaranteed populated. get_queried_object_id()
// is the pattern already proven elsewhere in this exact codebase for the same situation
// (ea_chapters_current_slug(), inc/chapters/chapters-render.php:85; and the schema Product
// node, mu-plugins/ea-w2-seo-schema.php:121).
$post_id = get_queried_object_id();
$price   = function_exists( 'ea_w2_05_price' ) ? ea_w2_05_price( $post_id ) : '';
$gi      = ( '' !== $slug && function_exists( 'ea_w2_05_gi_url' ) ) ? ea_w2_05_gi_url( $slug ) : '';
$wa      = function_exists( 'ea_wave2_wa_url' )
	? ea_wave2_wa_url( 'היי אייל, מתעניין/ת במוצר מהאתר ואשמח לפרטים' )
	: 'https://wa.me/972524822842';
$contact = home_url( '/contact?subject=product-' . rawurlencode( $slug ) );
?>
<section class="sec<?php echo $alt ? ' sec--alt' : ''; ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap center">
		<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<?php if ( ! empty( $a['body'] ) ) : ?><p class="lead r" style="margin-top:14px"><?php echo esc_html( $a['body'] ); ?></p><?php endif; ?>

		<p class="ea-product-price r" data-product-price style="margin-top:32px"><?php echo esc_html( $price ); ?></p>
		<?php if ( ! empty( $a['price_note'] ) ) : ?>
			<p class="ea-product-price__note r"><?php echo esc_html( $a['price_note'] ); ?></p>
		<?php endif; ?>

		<?php if ( '' !== $gi ) : ?>
			<div class="ea-cta-ab r" data-ea-product-cta data-product-slug="<?php echo esc_attr( $slug ); ?>" data-cta-type="green_invoice">
				<a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( $gi ); ?>" target="_blank" rel="noopener" data-ea-product-cta-link>
					<?php echo esc_html( ! empty( $a['gi_label'] ) ? $a['gi_label'] : 'לרכישה מאובטחת' ); ?>
				</a>
			</div>
		<?php else : ?>
			<div class="ea-cta-ab r" data-ea-product-cta data-product-slug="<?php echo esc_attr( $slug ); ?>" data-cta-type="contact" data-ea-page="product-<?php echo esc_attr( $slug ); ?>">
				<a class="ea-cta-pill ea-cta-pill--primary ea-cta-ab__form" href="<?php echo esc_url( $contact ); ?>" data-ea-ab-form data-ea-product-cta-link>
					<?php echo esc_html( ! empty( $a['contact_label'] ) ? $a['contact_label'] : 'לתיאום והתאמה' ); ?>
				</a>
				<a class="ea-cta-pill ea-cta-pill--whatsapp ea-cta-ab__wa" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener noreferrer" data-ea-ab-wa data-ea-product-cta-link>
					שליחת הודעה ב‑WhatsApp
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
