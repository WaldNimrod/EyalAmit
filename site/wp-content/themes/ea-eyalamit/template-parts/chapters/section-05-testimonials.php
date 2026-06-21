<?php
/**
 * Chapters — 05 TESTIMONIALS (3 cards; avatar image or initial placeholder).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$items = ea_chapters_rows( 'testi_items' );
?>
<section class="sec sec--alt">
	<div class="wrap center">
		<span class="chap chap--c r"><?php echo esc_html( ea_chapters_field( 'testi_chap' ) ); ?></span>
		<h2 class="h2 r"><?php echo esc_html( ea_chapters_field( 'testi_title' ) ); ?></h2>
		<div class="testi r">
			<div class="testi__track">
				<?php
				foreach ( $items as $row ) :
					$avatar  = ea_chapters_resolve_img( isset( $row['avatar'] ) ? $row['avatar'] : '', 'thumbnail' );
					$initial = isset( $row['initial'] ) ? $row['initial'] : '';
					?>
					<figure class="tcard">
						<span class="tcard__av">
							<?php if ( $avatar ) : ?>
								<img src="<?php echo esc_url( $avatar ); ?>" alt="<?php echo esc_attr( isset( $row['name'] ) ? $row['name'] : '' ); ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover">
							<?php else : ?>
								<span class="ph"><span><?php echo esc_html( $initial ); ?></span></span>
							<?php endif; ?>
						</span>
						<p class="tcard__q"><?php echo esc_html( isset( $row['text'] ) ? $row['text'] : '' ); ?></p>
						<figcaption class="tcard__n"><?php echo esc_html( isset( $row['name'] ) ? $row['name'] : '' ); ?></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
