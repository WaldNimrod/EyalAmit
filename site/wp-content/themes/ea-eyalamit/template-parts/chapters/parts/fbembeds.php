<?php
/**
 * Chapters part — Facebook post embeds grid (.fbgrid). $args: chap, title, lead,
 * alt (bg tint, default true — matches gallery.php's own default), id, items[ { href, title } ].
 * Built generically (mirrors gallery.php's contract) though today's only consumer is
 * mokesh-defaults.php (4 posts, WP-CANON T1).
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
		<div class="fbgrid r">
			<?php
			foreach ( $items as $it ) :
				$href = $it['href'] ?? '';
				if ( ! $href ) {
					continue;
				}
				?>
				<div class="fbgrid__item">
					<iframe class="fbgrid__frame" src="https://www.facebook.com/plugins/post.php?href=<?php echo rawurlencode( $href ); ?>&amp;show_text=true&amp;width=500&amp;locale=he_IL" width="500" height="640" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" loading="lazy" title="<?php echo esc_attr( $it['title'] ?? 'פוסט פייסבוק' ); ?>"></iframe>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
