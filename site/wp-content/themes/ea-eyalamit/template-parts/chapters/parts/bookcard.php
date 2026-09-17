<?php
/**
 * Chapters part — cards grid (.bookcards / .bookcard). Each card is a single
 * clickable link: cover + (meta) + title + blurb + CTA. Whole card is the link.
 * Cover falls back to a styled placeholder when absent.
 *
 * Used for books (Muzza), shop products, and QR hub — CTA copy is contextual.
 *
 * $args: chap, title, lead, alt (bg, default true), id,
 *        cta_label (section default CTA; default «לעמוד הספר ←»),
 *        items[ { cover, title, blurb, url, meta, cta } ]
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a          = isset( $args ) && is_array( $args ) ? $args : array();
$items      = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
$alt        = array_key_exists( 'alt', $a ) ? ! empty( $a['alt'] ) : true;
$cta_default = ! empty( $a['cta_label'] ) ? (string) $a['cta_label'] : 'לעמוד הספר ←';

/* A11Y fix 2026-09-18 (A11Y-STRUCT-02, team_10/WS-3B, _COMMUNICATION/team_10/
 * A11Y-FIX-2026-09-18/04-DONE-HEADING-STRUCTURE.md): card titles rendered as
 * a <span> (was line 57) — invisible to heading-based navigation, SC 1.3.1.
 * Measured live: /shop/ and /qr/ have exactly 1 heading on the whole page
 * (the H1). Level is derived from this part's OWN context, not hardcoded —
 * this part renders its own <h2 class="h2 r"> above the grid a few lines up
 * only when $a['title'] is set. Today none of the 3 real callers (shop-
 * defaults.php, qr-hub-defaults.php, muzza-defaults.php's "books" section)
 * pass a title, so no local H2 exists and cards default to H2 themselves —
 * confirmed against the live H1-only pages, no skipped level. A future
 * caller that does pass 'title' gets its own H2 immediately above the grid,
 * so H3 is then correct for its cards. $a['card_heading_level'] (2-6) is a
 * new, optional explicit override for a caller whose surrounding heading
 * context this part cannot otherwise see. */
$ea_card_level = ! empty( $a['title'] ) ? 3 : 2;
if ( isset( $a['card_heading_level'] ) && is_numeric( $a['card_heading_level'] ) ) {
	$ea_card_level = max( 2, min( 6, (int) $a['card_heading_level'] ) );
}
$ea_card_tag = 'h' . $ea_card_level;
?>
<section class="sec<?php echo $alt ? ' sec--alt' : ''; ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap center">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap chap--c r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<?php if ( ! empty( $a['lead'] ) ) : ?><p class="lead r" style="margin-top:14px"><?php echo esc_html( $a['lead'] ); ?></p><?php endif; ?>
		<div class="bookcards r">
			<?php
			foreach ( $items as $it ) :
				$url   = $it['url'] ?? '';
				$cover = ea_chapters_resolve_img( $it['cover'] ?? '' );
				$ttl   = $it['title'] ?? '';
				$cta   = ! empty( $it['cta'] ) ? (string) $it['cta'] : $cta_default;
				/* S006 RTL audit 2026-09-17: shop/QR cta copy ends in a literal
				 * "←" (see shop-defaults.php / qr-hub-defaults.php) meant to read
				 * "go this way" in Hebrew — left bare inside RTL text it bidi-
				 * mirrors and points the wrong way, same bug class as tonight's
				 * testimonial-carousel arrows. Strip it and re-render in its own
				 * dir="ltr" span so every current and future cta/cta_label stays
				 * correct without each content string needing its own workaround. */
				$cta_arrow = false;
				if ( false !== mb_strpos( $cta, '←' ) ) {
					$cta       = trim( str_replace( '←', '', $cta ) );
					$cta_arrow = true;
				}
				?>
				<a class="bookcard" href="<?php echo esc_url( $url ?: '#' ); ?>">
					<span class="bookcard__cover">
						<?php if ( $cover ) : ?>
							<img src="<?php echo esc_url( $cover ); ?>" alt="<?php echo esc_attr( $ttl ); ?>" loading="lazy">
						<?php else : ?>
							<span class="ph ph--d"><span><?php echo esc_html( $ttl ); ?></span></span>
						<?php endif; ?>
					</span>
					<?php /* A11Y 2026-09-18: <div>, not <span>. The card title above became a real
					heading (A11Y-STRUCT-02), and a heading inside a <span> is invalid — <span> takes
					phrasing content only, which SC 4.1.1 Parsing asks us to respect. Chrome parses it
					as authored either way (measured: the h2 stays nested, nothing reparents), so this
					is correctness rather than a visible fix. Free of visual risk because
					.bookcard__b already declares display:flex (chapters.css:875), and <a> has a
					transparent content model, so flow content inside it is fine. */ ?>
					<div class="bookcard__b">
						<?php if ( ! empty( $it['meta'] ) ) : ?><span class="bookcard__meta"><?php echo esc_html( $it['meta'] ); ?></span><?php endif; ?>
						<?php printf( '<%1$s class="bookcard__t">%2$s</%1$s>', $ea_card_tag, esc_html( $ttl ) ); ?>
						<?php if ( ! empty( $it['blurb'] ) ) : ?><span class="bookcard__blurb"><?php echo esc_html( $it['blurb'] ); ?></span><?php endif; ?>
						<span class="bookcard__cta" aria-hidden="true"><?php echo esc_html( $cta ); ?><?php if ( $cta_arrow ) : ?><span class="bookcard__cta-ar" dir="ltr">←</span><?php endif; ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
