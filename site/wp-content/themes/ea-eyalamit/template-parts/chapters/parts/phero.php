<?php
/**
 * Chapters part — page hero (.phero / .phero--media). Renders the page's single H1.
 * $args: chap, title (limited HTML), sub, lede (optional — multi-paragraph HTML body rendered
 * under the sub; see the escaping note below), media (url), media_alt, cta_label, cta_url, cta_slug (optional — marks the CTA as an external, GA4-tracked purchase link: adds target=_blank/rel=noopener + data-ea-book-purchase/data-ea-book-slug + aria-label suffix. Do not pass for internal/same-site links.), dark(bool)
 *
 * `lede` renders through wp_kses_post(), not ea_chapters_kses_e() like the other fields. That
 * helper's allowlist is em/br/strong/span/a and has no <p>, so a multi-paragraph body handed to
 * it loses every paragraph break and arrives as one run-on block. wp_kses_post is what the eight
 * other parts that carry body HTML already use (prose, split, dd, faq-inline, videoblk…), and
 * ea_replace_retired_brand is called explicitly here because it lives *inside* ea_chapters_kses_e
 * — dropping that helper without re-adding the call would silently stop rewriting the retired
 * studio brand in this text.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$media = $a['media'] ?? '';
$dark  = ! empty( $a['dark'] ) || '' === $media;
?>
<header class="phero<?php echo $media ? ' phero--media' : ''; ?>">
	<?php if ( $media ) : ?>
		<img class="phero__media" src="<?php echo esc_url( $media ); ?>" alt="<?php echo esc_attr( $a['media_alt'] ?? '' ); ?>">
		<span class="phero__sc" aria-hidden="true"></span>
	<?php endif; ?>
	<span class="arcs" aria-hidden="true"></span>
	<div class="phero__in">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h1 class="phero__h"><?php ea_chapters_kses_e( $a['title'] ?? '' ); ?></h1>
		<?php if ( ! empty( $a['sub'] ) ) : ?><p class="phero__s"><?php ea_chapters_kses_e( $a['sub'] ); ?></p><?php endif; ?>
		<?php if ( ! empty( $a['lede'] ) ) : ?><div class="phero__lede"><?php echo wp_kses_post( function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) $a['lede'] ) : (string) $a['lede'] ); ?></div><?php endif; ?>
		<?php if ( ! empty( $a['cta_label'] ) ) : ?>
			<p class="phero__cta"><a class="btn btn--gw" href="<?php echo esc_url( $a['cta_url'] ?? '#' ); ?>"<?php if ( ! empty( $a['cta_slug'] ) ) : ?> target="_blank" rel="noopener noreferrer" data-ea-book-purchase data-ea-book-slug="<?php echo esc_attr( sanitize_title( $a['cta_slug'] ) ); ?>" aria-label="<?php echo esc_attr( $a['cta_label'] . ' (נפתח בלשונית חדשה)' ); ?>"<?php endif; ?>><?php echo esc_html( $a['cta_label'] ); ?></a></p>
		<?php endif; ?>
	</div>
	<?php if ( $media ) : ?><span class="phero__media-cue" aria-hidden="true"></span><?php endif; ?>
</header>
