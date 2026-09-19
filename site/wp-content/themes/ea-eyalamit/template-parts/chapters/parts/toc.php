<?php
/**
 * Chapters part — page table of contents. Three states of the same navigation:
 * inline list, floating rail, mobile sheet. Spec: SKETCH-TOC-ELEMENT-2026-09-18.html.
 *
 * $args: items[ { id (anchor without hash), label } ], heading (optional eyebrow).
 * Renders nothing when items is empty or missing.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a     = isset( $args ) && is_array( $args ) ? $args : array();
$items = ( isset( $a['items'] ) && is_array( $a['items'] ) ) ? $a['items'] : array();
$items = array_values(
	array_filter(
		$items,
		function ( $it ) {
			return is_array( $it ) && '' !== (string) ( $it['id'] ?? '' ) && '' !== (string) ( $it['label'] ?? '' );
		}
	)
);
if ( empty( $items ) ) {
	return;
}
$heading = isset( $a['heading'] ) && '' !== (string) $a['heading'] ? (string) $a['heading'] : 'בעמוד הזה';
?>
<div class="ea-toc">
	<section class="sec ea-toc__sec">
		<div class="wrap lede">
			<nav class="toc-inline" aria-label="<?php echo esc_attr( 'תוכן העניינים' ); ?>">
				<p class="toc-inline__h"><?php echo esc_html( $heading ); ?></p>
				<ol>
					<?php foreach ( $items as $it ) : ?>
						<li><a href="<?php echo esc_url( '#' . $it['id'] ); ?>"><?php echo esc_html( $it['label'] ); ?></a></li>
					<?php endforeach; ?>
				</ol>
			</nav>
		</div>
	</section>
	<nav class="rail" aria-label="<?php echo esc_attr( 'ניווט מהיר בעמוד' ); ?>">
		<?php foreach ( $items as $it ) : ?>
			<a href="<?php echo esc_url( '#' . $it['id'] ); ?>"><span><?php echo esc_html( $it['label'] ); ?></span><i aria-hidden="true"></i></a>
		<?php endforeach; ?>
	</nav>
	<button class="toc-fab" type="button" aria-haspopup="dialog">☰ <?php echo esc_html( $heading ); ?></button>
	<dialog class="sheet" aria-label="<?php echo esc_attr( 'תוכן העניינים' ); ?>">
		<div class="sheet__in">
			<div class="sheet__top">
				<span class="sheet__t"><?php echo esc_html( $heading ); ?></span>
				<button class="sheet__x" type="button" aria-label="<?php echo esc_attr( 'סגירה' ); ?>">&times;</button>
			</div>
			<ol>
				<?php foreach ( $items as $it ) : ?>
					<li><a href="<?php echo esc_url( '#' . $it['id'] ); ?>"><?php echo esc_html( $it['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ol>
		</div>
	</dialog>
</div>
