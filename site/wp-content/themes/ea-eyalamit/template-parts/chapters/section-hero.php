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
		<?php /* S007-GROK 2026-09-20: sound toggle lives on the video, never in the nav.
		   Rendered only when a real <video> exists. Accessible name + aria-pressed kept. */ ?>
		<button class="hero__sound" id="soundtg" type="button" aria-pressed="false" aria-label="<?php esc_attr_e( 'שמע — הפעלת קול בסרטון', 'ea-eyalamit' ); ?>">
			<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9 h4 l5-4 v14 l-5-4 H4 z"/><path d="M17 9 a4 4 0 0 1 0 6"/></svg><?php esc_html_e( 'שמע', 'ea-eyalamit' ); ?>
		</button>
	<?php elseif ( $poster ) : ?>
		<img class="hero__media" src="<?php echo esc_url( $poster ); ?>" alt="" />
	<?php endif; ?>
	<div class="hero__scrim" aria-hidden="true"></div>
	<div class="hero__c">
		<?php /* S006 · H-02 · שורת האמון של אייל היא שתי שורות (SECTION 01 → «### Trust line:»),
			ולכן היא עוברת דרך ea_chapters_kses_e (מתיר <br>) ולא דרך esc_html שבלע את השבירה. */ ?>
		<?php /* Round C (2026-09-24), team_00: the breadcrumb moves OUT of the hero
			into the "classic position" — right-aligned, directly below the hero,
			before the main content — the same on every page. Only used by the home
			page, where breadcrumbs never render anyway (is_front_page()), so there
			is nothing to relocate a call site for here; kept as a comment so a
			future non-home caller of this partial does not silently reintroduce the
			in-hero placement. */ ?>
		<?php if ( $trust ) : ?><span class="hero__trust"><?php ea_chapters_kses_e( $trust ); ?></span><?php endif; ?>
		<h1 class="hero__h"><?php ea_chapters_kses_e( ea_chapters_field( 'hero_title' ) ); ?></h1>
		<p class="hero__s"><?php ea_chapters_kses_e( ea_chapters_field( 'hero_subtitle' ) ); ?></p>
		<?php if ( $cta_l ) : ?>
			<a class="btn btn--terra" href="<?php echo esc_url( $cta_u ); ?>"><?php echo esc_html( $cta_l ); ?></a>
		<?php endif; ?>
	</div>
	<div class="hero__cues" aria-hidden="true"><span></span><span></span></div>
</header>
