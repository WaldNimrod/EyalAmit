<?php
/**
 * Chapters part — "for whom" reveal-over-image cards (.reveals / .rcard).
 * Title sits on the image; detail text reveals over it on hover (card stays fixed).
 * $args: chap, title, lead, alt(bg true=sec--alt default), items[{image,title,more}]
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
$alt   = array_key_exists( 'alt', $a ) ? ! empty( $a['alt'] ) : true;
?>
<section class="sec<?php echo $alt ? ' sec--alt' : ''; ?>">
	<div class="wrap center">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap chap--c r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h2 class="h2 r"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
		<?php if ( ! empty( $a['lead'] ) ) : ?><p class="lead r" style="margin-top:14px"><?php echo esc_html( $a['lead'] ); ?></p><?php endif; ?>
		<div class="reveals r">
			<?php
			foreach ( $items as $i => $it ) :
				$rcls = 'r' . ( $i ? ' r' . ( $i + 1 ) : '' );
				$src  = ea_chapters_resolve_img( $it['image'] ?? '' );
				$ttl  = $it['title'] ?? '';
				?>
				<div class="rcard <?php echo esc_attr( $rcls ); ?>" tabindex="0" aria-label="<?php echo esc_attr( $ttl ); ?>">
					<?php if ( $src ) : ?><img src="<?php echo esc_url( $src ); ?>" alt="" loading="lazy"><?php else : ?><span class="ph ph--d" style="position:absolute;inset:0"><span><?php esc_html_e( 'תמונה', 'ea-eyalamit' ); ?></span></span><?php endif; ?>
					<span class="rcard__sc" aria-hidden="true"></span>
					<span class="rcard__hint" aria-hidden="true">+</span>
					<div class="rcard__b">
						<h3 class="rcard__t"><?php echo esc_html( $ttl ); ?></h3>
						<?php if ( ! empty( $it['more'] ) ) : ?><div class="rcard__more"><p><?php echo esc_html( $it['more'] ); ?></p></div><?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
