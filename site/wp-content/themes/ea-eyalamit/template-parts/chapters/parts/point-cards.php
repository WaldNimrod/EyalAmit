<?php
/**
 * Chapters part — two-column point cards (.point-cards).
 * $args: chap, title, id, lead (HTML), after (HTML), items[{title,text}].
 * White cards sit on sec--alt. The last card stays in its own cell.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
?>
<section class="sec sec--alt"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r" style="margin-bottom:18px"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<div class="point-cards">
			<?php if ( ! empty( $a['lead'] ) ) : ?>
				<div class="point-cards__lead intro-body"><?php echo wp_kses_post( function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) $a['lead'] ) : (string) $a['lead'] ); ?></div>
			<?php endif; ?>
			<div class="point-cards__grid">
				<?php foreach ( $items as $it ) :
					$title = isset( $it['title'] ) ? (string) $it['title'] : '';
					$text  = isset( $it['text'] ) ? (string) $it['text'] : '';
					if ( '' === $title && '' === $text ) {
						continue;
					}
					?>
					<article class="point-cards__card">
						<?php if ( '' !== $title ) : ?><h3><?php echo esc_html( $title ); ?></h3><?php endif; ?>
						<?php if ( '' !== $text ) : ?><p><?php echo esc_html( $text ); ?></p><?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
			<?php if ( ! empty( $a['after'] ) ) : ?>
				<div class="point-cards__after intro-body"><?php echo wp_kses_post( function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) $a['after'] ) : (string) $a['after'] ); ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>
