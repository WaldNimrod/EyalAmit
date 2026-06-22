<?php
/**
 * Chapters part — horizontal timeline (.tl). $args: chap, title, lead, dark(bool), items[{year,text}], id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
?>
<section class="sec<?php echo ! empty( $a['dark'] ) ? ' sec--dark' : ''; ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap<?php echo ! empty( $a['center'] ) ? ' center' : ''; ?>">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<?php if ( ! empty( $a['lead'] ) ) : ?><p class="lead r" style="margin:14px 0 0"><?php echo esc_html( $a['lead'] ); ?></p><?php endif; ?>
		<ol class="tl r">
			<?php foreach ( $items as $it ) : ?>
				<li class="tl__n"><span class="tl__y"><?php echo esc_html( $it['year'] ?? '' ); ?></span><p class="tl__l"><?php echo esc_html( $it['text'] ?? '' ); ?></p></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
