<?php
/**
 * Chapters part — page hero (.phero / .phero--media). Renders the page's single H1.
 * $args: chap, title (limited HTML), sub, media (url), media_alt, cta_label, cta_url, dark(bool)
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$media = $a['media'] ?? '';
$dark  = ! empty( $a['dark'] ) || '' === $media;
?>
<header class="phero<?php echo $media ? ' phero--media' : ''; ?>">
	<?php if ( $media ) : ?>
		<img class="phero__media" src="<?php echo esc_url( $media ); ?>" alt="<?php echo esc_attr( $a['media_alt'] ?? '' ); ?>">
		<span class="phero__sc" aria-hidden="true"></span>
	<?php endif; ?>
	<span class="arcs" aria-hidden="true"></span>
	<div class="phero__in">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h1 class="phero__h"><?php ea_chapters_kses_e( $a['title'] ?? '' ); ?></h1>
		<?php if ( ! empty( $a['sub'] ) ) : ?><p class="phero__s"><?php echo esc_html( $a['sub'] ); ?></p><?php endif; ?>
		<?php if ( ! empty( $a['cta_label'] ) ) : ?>
			<p class="phero__cta"><a class="btn btn--gw" href="<?php echo esc_url( $a['cta_url'] ?? '#' ); ?>"><?php echo esc_html( $a['cta_label'] ); ?></a></p>
		<?php endif; ?>
	</div>
	<?php if ( $media ) : ?><span class="phero__media-cue" aria-hidden="true"></span><?php endif; ?>
</header>
