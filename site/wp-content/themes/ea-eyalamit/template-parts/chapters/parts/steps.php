<?php
/**
 * Chapters part — connected step timeline (.show / .shstep). $args: chap, title,
 * lead, dark(bool), items[{title,text}], id
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
$dark  = ! empty( $a['dark'] );
?>
<section class="sec<?php echo $dark ? ' sec--dark' : ''; ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap center">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap chap--c r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h2 class="h2 r"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
		<?php if ( ! empty( $a['lead'] ) ) : ?><p class="lead r" style="margin:14px auto 0"><?php echo esc_html( $a['lead'] ); ?></p><?php endif; ?>
		<div class="show<?php echo $dark ? ' show--ondark' : ''; ?> r">
			<div class="show__track">
				<?php foreach ( $items as $i => $it ) : ?>
					<div class="shstep">
						<span class="shstep__dot"><span><?php echo esc_html( (string) ( $i + 1 ) ); ?></span></span>
						<h3 class="shstep__t"><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
						<p class="shstep__p"><?php echo esc_html( $it['text'] ?? '' ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
