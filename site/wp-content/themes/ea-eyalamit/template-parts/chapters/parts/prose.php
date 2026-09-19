<?php
/**
 * Chapters part — prose section (.intro-body). $args: chap, title, body(HTML), center(bool), alt, dark, id,
 * pairs_with_toc(bool) — marks this .sec as the lead that sits beside a following .ea-toc
 * (class ea-toc-lede-lead; pairing CSS cannot nest :has()),
 * float_image + float_alt + float_zoom + float_side('s'|'e') — a SMALL figure floated inside
 * the prose so the text wraps around it, instead of a two-column split that narrows the
 * whole section's text for the height of one picture (team_00, 20.9.2026),
 * collapsible(bool) + toggle_label — when collapsible is true, body renders inside a closed-by-default
 * <details>/<summary> instead of a plain div (e.g. long reading excerpts).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a   = isset( $args ) && is_array( $args ) ? $args : array();
$cls = 'sec';
if ( ! empty( $a['dark'] ) ) {
	$cls .= ' sec--dark';
} elseif ( ! empty( $a['alt'] ) ) {
	$cls .= ' sec--alt';
}
if ( ! empty( $a['pairs_with_toc'] ) ) {
	$cls .= ' ea-toc-lede-lead';
}
$center      = ! empty( $a['center'] );
$collapsible = ! empty( $a['collapsible'] );
/* No scroll-reveal classes when collapsible: content nested inside a closed <details> never
   intersects the viewport, so the IntersectionObserver in ea-chapters.js never fires and the
   text would stay at opacity:0 forever, even after the user opens it. Matches the existing
   faq.php accordion, which deliberately keeps reveal classes off content nested in <details>. */
$body_cls    = $collapsible ? 'intro-body' : 'intro-body r r2';
$body_style  = $center ? ' style="margin-inline:auto"' : '';
?>
<section class="<?php echo esc_attr( $cls ); ?>"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<div class="wrap<?php echo $center ? ' center' : ''; ?>">
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap<?php echo $center ? ' chap--c' : ''; ?> r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2 r" style="margin-bottom:18px"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<?php if ( $collapsible ) : ?>
			<details class="prose-acc">
				<summary class="prose-acc__t"><?php echo esc_html( $a['toggle_label'] ?? 'לחצו לקריאה' ); ?></summary>
				<div class="<?php echo esc_attr( $body_cls ); ?>"<?php echo $body_style; ?>><?php echo wp_kses_post( function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) ( $a['body'] ?? '' ) ) : ( $a['body'] ?? '' ) ); ?></div>
			</details>
		<?php else : ?>
			<div class="<?php echo esc_attr( $body_cls ); ?>"<?php echo $body_style; ?>>
				<?php
				if ( ! empty( $a['float_image'] ) ) :
					$ea_fs  = esc_url( $a['float_image'] );
					$ea_fa  = esc_attr( function_exists( 'ea_chapters_content_img_alt' ) ? ea_chapters_content_img_alt( $a['float_image'], $a['float_alt'] ?? '' ) : ( $a['float_alt'] ?? '' ) );
					$ea_fsd = ( 'e' === ( $a['float_side'] ?? 's' ) ) ? 'e' : 's';
					?>
					<figure class="pfloat pfloat--<?php echo esc_attr( $ea_fsd ); ?>">
						<?php if ( ! empty( $a['float_zoom'] ) ) : ?>
							<button type="button" class="zoom" data-zoom-src="<?php echo $ea_fs; ?>" data-zoom-alt="<?php echo $ea_fa; ?>">
								<img src="<?php echo $ea_fs; ?>" alt="<?php echo $ea_fa; ?>" loading="lazy">
								<span class="zoom__hint"><?php esc_html_e( 'להגדלה — לחצו על התמונה', 'ea-eyalamit' ); ?></span>
							</button>
						<?php else : ?>
							<img src="<?php echo $ea_fs; ?>" alt="<?php echo $ea_fa; ?>" loading="lazy">
						<?php endif; ?>
					</figure>
				<?php endif; ?>
				<?php echo wp_kses_post( function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) ( $a['body'] ?? '' ) ) : ( $a['body'] ?? '' ) ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
