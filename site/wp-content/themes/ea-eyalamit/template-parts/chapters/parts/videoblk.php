<?php
/**
 * Chapters part — text + dedicated video block (.videoblk). $args: chap, title,
 * body(HTML), poster(url), video(url), cap, alt
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$video = $a['video'] ?? '';
$poster = $a['poster'] ?? '';
?>
<section class="sec sec--alt">
	<div class="wrap">
		<div style="max-width:760px">
			<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
			<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r" style="margin-bottom:18px"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
			<?php if ( ! empty( $a['body'] ) ) : ?><div class="intro-body r r2"><?php echo wp_kses_post( $a['body'] ); ?></div><?php endif; ?>
		</div>
		<div class="videoblk r r2" style="margin-top:48px">
			<?php if ( $poster ) : ?><img class="videoblk__poster" src="<?php echo esc_url( $poster ); ?>" alt="<?php echo esc_attr( $a['alt'] ?? '' ); ?>" loading="lazy"><?php endif; ?>
			<?php if ( $video ) : ?>
				<video class="videoblk__v" muted loop playsinline preload="none"<?php echo $poster ? ' poster="' . esc_url( $poster ) . '"' : ''; ?> style="display:none"><source src="<?php echo esc_url( $video ); ?>" type="video/mp4"></video>
				<span class="videoblk__sc" aria-hidden="true"></span>
				<button class="videoblk__play" type="button" aria-label="<?php esc_attr_e( 'נגן סרטון', 'ea-eyalamit' ); ?>"></button>
			<?php endif; ?>
			<?php if ( ! empty( $a['cap'] ) ) : ?><span class="videoblk__cap"><?php echo esc_html( $a['cap'] ); ?></span><?php endif; ?>
		</div>
	</div>
</section>
