<?php
/**
 * Chapters — 07 HOW TO START (dark image band, 3 steps, closing CTA).
 * Step icons are part of the design (rendered by index); titles/text are editable.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$bg    = ea_chapters_img( 'start_bg' );
$steps = ea_chapters_rows( 'start_steps' );
$cta_l = ea_chapters_field( 'start_cta_label' );
$cta_u = ea_chapters_field( 'start_cta_url' );

// Fixed design icons, rendered by step index (phone, compass, calendar).
$icons = array(
	'<svg viewBox="0 0 24 24"><path d="M5 4 h3 l1.5 4 -2 1.5 a11 11 0 0 0 5 5 l1.5-2 4 1.5 v3 a2 2 0 0 1-2 2 A16 16 0 0 1 3 6 a2 2 0 0 1 2-2 z"/></svg>',
	'<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M15 9 l-2 5 -4 1 2-5 z"/></svg>',
	'<svg viewBox="0 0 24 24"><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M4 9 h16 M9 3 v4 M15 3 v4"/></svg>',
);
?>
<section class="start" id="start">
	<div class="start__bg" aria-hidden="true">
		<?php if ( $bg ) : ?>
			<img class="r r--fade" src="<?php echo esc_url( $bg ); ?>" alt="" loading="lazy">
		<?php endif; ?>
	</div>
	<span class="start__sc" aria-hidden="true"></span>
	<div class="start__in center">
		<span class="chap chap--c r"><?php echo esc_html( ea_chapters_field( 'start_chap' ) ); ?></span>
		<h2 class="h2 start__h r"><?php echo esc_html( ea_chapters_field( 'start_title' ) ); ?></h2>
		<div class="steps3 r">
			<?php foreach ( $steps as $i => $row ) : ?>
				<div class="st3">
					<span class="st3__ic"><?php echo $icons[ $i % count( $icons ) ]; // phpcs:ignore WordPress.Security.EscapeOutput — static trusted SVG ?></span>
					<div class="st3__t"><?php echo esc_html( isset( $row['title'] ) ? $row['title'] : '' ); ?></div>
					<p class="st3__p"><?php echo esc_html( isset( $row['text'] ) ? $row['text'] : '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if ( $cta_l ) : ?>
			<div class="center" style="margin-top:48px"><a class="btn btn--terra r" href="<?php echo esc_url( $cta_u ); ?>"><?php echo esc_html( $cta_l ); ?></a></div>
		<?php endif; ?>
	</div>
</section>
