<?php
/**
 * Chapters part — book cards grid (.bookcards / .bookcard). Each card is a single
 * clickable link to the book's detail page: cover + (meta) + title + blurb + CTA.
 * Whole card is the link. Cover falls back to a styled placeholder when absent.
 *
 * $args: chap, title, lead, alt (bg, default true), id,
 *        items[ { cover, title, blurb, url, meta } ]
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
$alt   = array_key_exists( 'alt', $a ) ? ! empty( $a['alt'] ) : true;
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
						<span class="bookcard__cta" aria-hidden="true">לעמוד הספר ←</span>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
