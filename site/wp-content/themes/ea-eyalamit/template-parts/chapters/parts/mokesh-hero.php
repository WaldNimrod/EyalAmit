<?php
/**
 * Chapters part — Mokesh memorial hero (video variant of .phero--media). Page-specific,
 * NOT a generic reusable part — see LOD400 T1 §3 for the extend-vs-bespoke rationale.
 * $args: chap, title (limited HTML via ea_chapters_kses_e), sub, media (poster/fallback
 * image url — ALSO the no-JS/reduced-motion/API-blocked fallback), media_alt, yt_id.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$media = $a['media'] ?? '';
$yt_id = $a['yt_id'] ?? '';
?>
<header class="phero phero--media mokesh-hero">
	<?php if ( $media ) : ?>
		<img class="phero__media" src="<?php echo esc_url( $media ); ?>" alt="<?php echo esc_attr( $a['media_alt'] ?? '' ); ?>">
	<?php endif; ?>
	<?php if ( $yt_id ) : ?>
		<div class="mokesh-hero__yt" aria-hidden="true">
			<div id="ea-mokesh-trailer" data-ytid="<?php echo esc_attr( $yt_id ); ?>"></div>
		</div>
	<?php endif; ?>
	<span class="phero__sc" aria-hidden="true"></span>
	<span class="arcs" aria-hidden="true"></span>
	<div class="phero__in">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h1 class="phero__h"><?php ea_chapters_kses_e( $a['title'] ?? '' ); ?></h1>
		<?php if ( ! empty( $a['sub'] ) ) : ?><p class="phero__s"><?php echo esc_html( $a['sub'] ); ?></p><?php endif; ?>
	</div>
	<?php if ( $yt_id ) : ?>
		<button type="button" class="mokesh-hero__unmute" data-ea-mokesh-unmute aria-pressed="false" hidden>
			<span class="mokesh-hero__unmute-icon" aria-hidden="true"></span>
			<span class="mokesh-hero__unmute-label">הפעלת קול</span>
		</button>
	<?php endif; ?>
</header>
