<?php
/**
 * Chapters — HERO (video bg + single H1). The page's only <h1>.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$video  = ea_chapters_asset_url( ea_chapters_field( 'hero_video' ) );
$poster = ea_chapters_img( 'hero_poster' );
$trust  = ea_chapters_field( 'hero_trust' );
$cta_l  = ea_chapters_field( 'hero_cta_label' );
$cta_u  = ea_chapters_field( 'hero_cta_url' );
?>
<header class="hero">
	<?php if ( $video ) : ?>
		<?php /* No `autoplay`/eager preload in the static markup — ea-chapters.js starts playback
			after window `load`, respecting prefers-reduced-motion, so the video never competes with
			the poster (the hero's actual LCP element) for initial bandwidth. */ ?>
		<video class="hero__media" muted loop playsinline preload="none"<?php echo $poster ? ' poster="' . esc_url( $poster ) . '"' : ''; ?>>
			<source src="<?php echo esc_url( $video ); ?>" type="video/mp4">
		</video>
	<?php elseif ( $poster ) : ?>
		<img class="hero__media" src="<?php echo esc_url( $poster ); ?>" alt="" />
	<?php endif; ?>
	<div class="hero__scrim" aria-hidden="true"></div>
	<div class="hero__c">
		<?php if ( $trust ) : ?><span class="hero__trust"><?php echo esc_html( $trust ); ?></span><?php endif; ?>
		<h1 class="hero__h"><?php ea_chapters_kses_e( ea_chapters_field( 'hero_title' ) ); ?></h1>
		<p class="hero__s"><?php ea_chapters_kses_e( ea_chapters_field( 'hero_subtitle' ) ); ?></p>
		<?php if ( $cta_l ) : ?>
			<a class="btn btn--terra" href="<?php echo esc_url( $cta_u ); ?>"><?php echo esc_html( $cta_l ); ?></a>
		<?php endif; ?>
	</div>
	<div class="hero__cues" aria-hidden="true"><span></span><span></span></div>
</header>
