<?php
/**
 * Chapters part — magazine spread (.mag-spread / .mag-list, dark section).
 * Numbered editorial list (numbers via CSS counter). $args: chap, title, image,
 * alt, cap_b, cap_sub, items[{title,text}], id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
?>
<section class="sec sec--dark"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<span class="arcs" aria-hidden="true" style="width:560px;height:560px;top:-180px;left:-180px;opacity:.1;filter:invert(1) sepia(.5) brightness(1.3)"></span>
	<div class="wrap" style="position:relative;z-index:2">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h2 class="h2 r" style="color:#fff;max-width:18ch"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
		<div class="mag-spread">
			<figure class="mag-spread__fig r">
				<img src="<?php echo esc_url( $a['image'] ?? '' ); ?>" alt="<?php echo esc_attr( $a['alt'] ?? '' ); ?>" loading="lazy">
				<figcaption><b><?php echo esc_html( $a['cap_b'] ?? '' ); ?></b><?php echo esc_html( $a['cap_sub'] ?? '' ); ?></figcaption>
			</figure>
			<ol class="mag-list r r2">
				<?php foreach ( $items as $it ) : ?>
					<li class="mag-list__i">
						<span class="mag-list__n" aria-hidden="true"></span>
						<div>
							<h3 class="mag-list__t"><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
							<p class="mag-list__p"><?php echo esc_html( $it['text'] ?? '' ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>
