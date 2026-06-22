<?php
/**
 * Chapters part — drill-down comparison accordion (.dd). $args: chap, title, lead,
 * dark(bool), id, items[{tag,title,body(HTML),active(bool)}]
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
?>
<section class="sec<?php echo ! empty( $a['dark'] ) ? ' sec--dark' : ''; ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap center">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap chap--c r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h2 class="h2 r"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
		<?php if ( ! empty( $a['lead'] ) ) : ?><p class="lead r" style="margin:14px auto 0"><?php echo esc_html( $a['lead'] ); ?></p><?php endif; ?>
		<div class="dd r">
			<?php foreach ( $items as $it ) : $active = ! empty( $it['active'] ); ?>
				<details class="dd__item<?php echo $active ? ' dd__item--active' : ''; ?>"<?php echo $active ? ' open' : ''; ?>>
					<summary class="dd__sum">
						<span class="dd__sum-main">
							<?php if ( ! empty( $it['tag'] ) ) : ?><span class="dd__tag"><?php echo esc_html( $it['tag'] ); ?></span><?php endif; ?>
							<span class="dd__t"><?php echo esc_html( $it['title'] ?? '' ); ?></span>
						</span>
						<span class="dd__ic" aria-hidden="true"></span>
					</summary>
					<div class="dd__body"><?php echo wp_kses_post( $it['body'] ?? '' ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
