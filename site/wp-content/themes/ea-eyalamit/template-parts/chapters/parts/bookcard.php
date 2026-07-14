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
				?>
				<a class="bookcard" href="<?php echo esc_url( $url ?: '#' ); ?>">
					<span class="bookcard__cover">
						<?php if ( $cover ) : ?>
							<img src="<?php echo esc_url( $cover ); ?>" alt="<?php echo esc_attr( $ttl ); ?>" loading="lazy">
						<?php else : ?>
							<span class="ph ph--d"><span><?php echo esc_html( $ttl ); ?></span></span>
						<?php endif; ?>
					</span>
					<span class="bookcard__b">
						<?php if ( ! empty( $it['meta'] ) ) : ?><span class="bookcard__meta"><?php echo esc_html( $it['meta'] ); ?></span><?php endif; ?>
						<span class="bookcard__t"><?php echo esc_html( $ttl ); ?></span>
						<?php if ( ! empty( $it['blurb'] ) ) : ?><span class="bookcard__blurb"><?php echo esc_html( $it['blurb'] ); ?></span><?php endif; ?>
						<span class="bookcard__cta" aria-hidden="true"><?php echo esc_html( $cta ); ?></span>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
