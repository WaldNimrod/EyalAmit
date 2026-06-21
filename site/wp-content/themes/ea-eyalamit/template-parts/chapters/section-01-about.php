<?php
/**
 * Chapters — 01 ABOUT (bio + 3-image collage + timeline).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$tl = ea_chapters_rows( 'about_timeline' );
?>
<section class="sec" id="about">
	<div class="wrap">
		<div class="about">
			<div class="r">
				<span class="chap"><?php echo esc_html( ea_chapters_field( 'about_chap' ) ); ?></span>
				<h2 class="h2" style="margin-bottom:22px"><?php echo esc_html( ea_chapters_field( 'about_title' ) ); ?></h2>
				<div class="about__body"><?php echo wp_kses_post( ea_chapters_field( 'about_body' ) ); ?></div>
			</div>
			<div class="about__col">
				<div class="collage">
					<span class="collage__big r"><img src="<?php echo esc_url( ea_chapters_img( 'about_img1' ) ); ?>" alt="<?php echo esc_attr( ea_chapters_field( 'about_img1_alt' ) ); ?>" loading="lazy"></span>
					<span class="collage__sm r r2"><img src="<?php echo esc_url( ea_chapters_img( 'about_img2' ) ); ?>" alt="<?php echo esc_attr( ea_chapters_field( 'about_img2_alt' ) ); ?>" loading="lazy"></span>
					<span class="collage__sm r r3"><img src="<?php echo esc_url( ea_chapters_img( 'about_img3' ) ); ?>" alt="<?php echo esc_attr( ea_chapters_field( 'about_img3_alt' ) ); ?>" loading="lazy"></span>
				</div>
			</div>
		</div>

		<?php if ( ! empty( $tl ) ) : ?>
			<ol class="tl r">
				<?php foreach ( $tl as $row ) : ?>
					<li class="tl__n">
						<span class="tl__y"><?php echo esc_html( isset( $row['year'] ) ? $row['year'] : '' ); ?></span>
						<p class="tl__l"><?php echo esc_html( isset( $row['text'] ) ? $row['text'] : '' ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		<?php endif; ?>
	</div>
</section>
