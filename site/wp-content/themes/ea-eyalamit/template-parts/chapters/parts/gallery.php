<?php
/**
 * Chapters part — image gallery grid (.gallery / .gfig). A responsive masonry-ish
 * grid of figures (image + optional caption). Also reusable for book galleries.
 * $args: chap, title, lead, alt (bg, default true), id, items[ { image, alt, cap, pending, pending_label } ]
 *
 * Items with pending=true (or empty image + pending) render a glowing
 * «ממתין לאישור» slot instead of skipping.
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
				$is_pending = ! empty( $it['pending'] );
				$src        = ea_chapters_resolve_img( $it['image'] ?? '' );
				if ( ! $src && ! $is_pending ) {
					continue;
				}
				if ( $is_pending && ! $src ) :
					$plabel = ! empty( $it['pending_label'] ) ? $it['pending_label'] : ( $it['cap'] ?? 'מדיה חסרה' );
					?>
				<figure class="gfig gfig--pending">
					<div class="ea-pending-approval" role="status">
						<span class="ea-pending-approval__badge">ממתין לאישור</span>
						<p class="ea-pending-approval__title"><?php echo esc_html( $plabel ); ?></p>
						<?php if ( ! empty( $it['alt'] ) ) : ?>
							<p class="ea-pending-approval__note"><?php echo esc_html( $it['alt'] ); ?></p>
						<?php endif; ?>
					</div>
				</figure>
					<?php
					continue;
				endif;
				?>
				<figure class="gfig<?php echo $is_pending ? ' gfig--pending-img' : ''; ?>">
					<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $it['alt'] ?? '' ); ?>" loading="lazy">
					<?php if ( $is_pending ) : ?>
						<span class="ea-pending-approval__badge" style="position:absolute;inset-block-start:10px;inset-inline-start:10px;z-index:2">ממתין לאישור</span>
					<?php endif; ?>
					<?php if ( ! empty( $it['cap'] ) ) : ?><figcaption class="gfig__cap"><?php echo esc_html( $it['cap'] ); ?></figcaption><?php endif; ?>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
