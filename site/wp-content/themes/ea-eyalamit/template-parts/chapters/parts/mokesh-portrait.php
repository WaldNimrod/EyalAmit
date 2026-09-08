<?php
/**
 * Chapters part — Mokesh portrait: split layout WITH a figure caption.
 * PAGE-SPECIFIC to /mokesh/, loaded only from mokesh-defaults.php. See M-04 action 2.
 *
 * $args: chap, title, body (HTML), image (url), alt, figr ('l'|'p'|'w'), reversed(bool),
 *        id, cap_lines (array of plain-text lines rendered as the figcaption).
 *
 * Why this exists instead of an argument on split.php: Eyal asked for a caption under
 * the portrait, and split.php emits a bare <figure> with no <figcaption> and no cap arg.
 * split.php is loaded by six other defaults files, so extending it would reach pages that
 * are already approved or awaiting Eyal (charter §4). Everything except the <figcaption>
 * is a faithful copy of split.php — same classes, same escaping, same brand rewrite —
 * so the rendered output is identical apart from the caption.
 *
 * cap_lines are Latin text inside an RTL document: dir="ltr" keeps the hyphen and the
 * word order from being reordered by the bidi algorithm. Styling is inline rather than a
 * new CSS rule — no generic figcaption rule exists in the theme, and inline style is the
 * established pattern in these parts.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a    = isset( $args ) && is_array( $args ) ? $args : array();
$caps = ( isset( $a['cap_lines'] ) && is_array( $a['cap_lines'] ) ) ? array_filter( $a['cap_lines'], 'strlen' ) : array();

/* The sections overlay resolves image paths only for parts listed in its $map
 * (chapters-render.php:423 does it for 'split'), and this page-specific part is not in
 * that map — an unresolved theme-relative path would ship as a broken <img>. Resolving
 * here keeps the fix inside this part instead of editing the shared map. Safe to call
 * twice: ea_chapters_asset_url() returns an already-absolute URL unchanged. */
$img = $a['image'] ?? '';
if ( function_exists( 'ea_chapters_resolve_img' ) ) {
	$img = ea_chapters_resolve_img( $img );
}
?>
<section class="sec"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap">
		<div class="split2<?php echo ! empty( $a['reversed'] ) ? ' split2--rev' : ''; ?>">
			<div class="r">
				<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
				<h2 class="h2" style="margin-bottom:18px"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
				<div class="intro-body"><?php echo wp_kses_post( function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) ( $a['body'] ?? '' ) ) : ( $a['body'] ?? '' ) ); ?></div>
			</div>
			<figure class="split2__m r r2" style="margin:0">
				<?php /* .figr keeps its own rounded, clipped box so `.figr img` still applies;
				         the caption sits outside it, under the image, and is not clipped. */ ?>
				<div class="figr figr--<?php echo esc_attr( $a['figr'] ?? 'l' ); ?>">
					<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( function_exists( 'ea_chapters_content_img_alt' ) ? ea_chapters_content_img_alt( $a['image'] ?? '', $a['alt'] ?? '' ) : ( $a['alt'] ?? '' ) ); ?>" loading="lazy">
				</div>
				<?php if ( $caps ) : ?>
					<figcaption dir="ltr" style="margin-top:10px;font-family:var(--bf);font-size:.78rem;line-height:1.65;letter-spacing:.3px;color:var(--muted);text-align:left">
						<?php foreach ( $caps as $line ) : ?>
							<span style="display:block"><?php echo esc_html( $line ); ?></span>
						<?php endforeach; ?>
					</figcaption>
				<?php endif; ?>
			</figure>
		</div>
	</div>
</section>
