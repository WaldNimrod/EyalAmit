<?php
/**
 * Chapters part — image gallery grid (.gallery / .gfig). A responsive masonry-ish
 * grid of figures (image + optional caption). Also reusable for book galleries.
 * $args: chap, title, lead, alt (bg, default true), id, items[ { image, alt, cap } ]
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
		<div class="gallery r">
			<?php
			foreach ( $items as $it ) :
				$src = ea_chapters_resolve_img( $it['image'] ?? '' );
				if ( ! $src ) {
					continue;
				}
				?>
				<figure class="gfig">
					<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $it['alt'] ?? '' ); ?>" loading="lazy">
					<?php if ( ! empty( $it['cap'] ) ) : ?><figcaption class="gfig__cap"><?php echo esc_html( $it['cap'] ); ?></figcaption><?php endif; ?>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
