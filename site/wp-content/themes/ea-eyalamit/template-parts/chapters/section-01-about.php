<?php
/**
 * Chapters — 01 ABOUT (bio + 3-image collage).
 *
 * S006 · H-01 · מקור: הערות 19.8.26/דף הבית.xlsx · גיליון1!D5 «למחוק מהדף»
 * ציר הזמן אינו מרונדר. about_body + תמונות לא נפתחו בסקואופ הזה.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="sec" id="about">
	<div class="wrap">
		<div class="about">
			<div class="r">
				<?php if ( ea_chapters_field( 'about_chap' ) ) : ?><span class="chap"><?php echo esc_html( ea_chapters_field( 'about_chap' ) ); ?></span><?php endif; ?>
				<h2 class="h2" style="margin-bottom:22px"><?php echo esc_html( ea_chapters_field( 'about_title' ) ); ?></h2>
				<div class="about__body"><?php echo wp_kses_post( function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) ea_chapters_field( 'about_body' ) ) : ea_chapters_field( 'about_body' ) ); ?></div>
			</div>
			<div class="about__col">
				<div class="collage">
					<span class="collage__big r"><img src="<?php echo esc_url( ea_chapters_img( 'about_img1' ) ); ?>" alt="<?php echo esc_attr( ea_chapters_field( 'about_img1_alt' ) ); ?>" loading="lazy"></span>
					<span class="collage__sm r r2"><img src="<?php echo esc_url( ea_chapters_img( 'about_img2' ) ); ?>" alt="<?php echo esc_attr( ea_chapters_field( 'about_img2_alt' ) ); ?>" loading="lazy"></span>
					<span class="collage__sm r r3"><img src="<?php echo esc_url( ea_chapters_img( 'about_img3' ) ); ?>" alt="<?php echo esc_attr( ea_chapters_field( 'about_img3_alt' ) ); ?>" loading="lazy"></span>
				</div>
			</div>
		</div>
	</div>
</section>
