<?php
/**
 * Home-only SECTION 03 — Eyal-approved YouTube embed (EI-B1).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$chap  = (string) ea_chapters_field( 'video_chap' );
$title = (string) ea_chapters_field( 'video_title' );
$embed = (string) ea_chapters_field( 'video_embed_url' );
if ( '' === $embed ) {
	$embed = 'https://www.youtube.com/embed/wDQoJauqsRM';
}
$iframe_title = $title ? $title : __( 'וידאו', 'ea-eyalamit' );
?>
<section class="sec sec--alt" id="video">
	<div class="wrap">
		<?php if ( $chap ) : ?><span class="chap r"><?php echo esc_html( $chap ); ?></span><?php endif; ?>
		<?php if ( $title ) : ?><h2 class="h2 r" style="margin-bottom:18px"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
		<div class="videoblk r r2" style="margin-top:48px">
			<iframe
				src="<?php echo esc_url( $embed ); ?>"
				title="<?php echo esc_attr( $iframe_title ); ?>"
				allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
				allowfullscreen
				loading="lazy"
				style="position:absolute;inset:0;width:100%;height:100%;border:0"
			></iframe>
		</div>
	</div>
</section>
