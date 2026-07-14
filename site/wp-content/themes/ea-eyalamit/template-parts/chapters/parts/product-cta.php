<?php
/**
 * Chapters part — product price + purchase/contact CTA (WP-CANON-TEMPLATE-UNIFICATION T3).
 * Reuses (does NOT duplicate) the Wave2 accessors — single source of truth for price,
 * the Green-Invoice URL map, and the WhatsApp URL builder:
 *   ea_w2_05_price()   — inc/wave2-w2-05.php:261-265
 *   ea_w2_05_gi_url()  — inc/wave2-w2-05.php:250-253 (map: inc/wave2-w2-05.php:234-241)
 *   ea_wave2_wa_url()  — inc/wave2-stage-b.php:22-27
 * Structural wrapper (.sec/.wrap/.chap/.h2) is Chapters-native; the price line + CTA
 * buttons reuse Wave2's .ea-product-price / .ea-cta-pill / .ea-cta-ab classes verbatim —
 * same mixing pattern already shipped in template-parts/chapters/parts/contact.php:76-79.
 * Zero new CSS: w2-05-shop.css + ea-atoms.css (which define all classes used here) are
 * already enqueued on these 5 pages today via ea_w2_05_assets() (slug-gated, template-
 * independent) and ea_wave2_enqueue_assets() (ea_wave2_shell-gated, set unconditionally
 * for every Chapters view by inc/chapters/chapters-routing.php's template_redirect hook).
 * data-* attributes match ea_w2_05_render_cta()'s contract exactly, so the already-loaded
 * assets/js/ea-ab-testing.js wires the A/B display + GA4 product_cta_click automatically
 * — zero new JS. (Prerequisite: the double-enqueue fix in §2.4 must land first, or the
 * click event double-fires — see LOD400 §6.3.)
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
