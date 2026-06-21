<?php
/**
 * Chapters — 04 STUDIO (dark split: text + image, arcs motif).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$img   = ea_chapters_img( 'studio_image' );
$alt   = ea_chapters_field( 'studio_alt' );
$cta_l = ea_chapters_field( 'studio_cta_label' );
$cta_u = ea_chapters_field( 'studio_cta_url' );
?>
<section class="sec" id="studio" style="padding:0">
	<div class="studio">
		<div class="studio__t r">
			<span class="arcs" aria-hidden="true"></span>
			<span class="chap"><?php echo esc_html( ea_chapters_field( 'studio_chap' ) ); ?></span>
			<h2 class="studio__h"><?php echo esc_html( ea_chapters_field( 'studio_title' ) ); ?></h2>
			<p class="studio__p"><?php echo esc_html( ea_chapters_field( 'studio_body' ) ); ?></p>
			<?php if ( $cta_l ) : ?>
				<a class="btn btn--gw" href="<?php echo esc_url( $cta_u ); ?>" style="align-self:flex-start"><?php echo esc_html( $cta_l ); ?></a>
			<?php endif; ?>
		</div>
		<div class="studio__m r r2">
			<?php if ( $img ) : ?>
				<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
			<?php endif; ?>
		</div>
	</div>
</section>
