<?php
/**
 * Chapters part — full-bleed photo with a text block (.photo-band).
 * $args: title, body (HTML), image, alt, literal_alt, cta_label, cta_url, id.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a   = isset( $args ) && is_array( $args ) ? $args : array();
$src = function_exists( 'ea_chapters_resolve_img' ) ? ea_chapters_resolve_img( $a['image'] ?? '' ) : (string) ( $a['image'] ?? '' );
$alt = (string) ( $a['alt'] ?? '' );
if ( empty( $a['literal_alt'] ) && function_exists( 'ea_chapters_content_img_alt' ) ) {
	$alt = ea_chapters_content_img_alt( $src, $alt );
}
?>
<section class="photo-band"<?php echo ! empty( $a['id'] ) ? ' id="' . esc_attr( $a['id'] ) . '"' : ''; ?>>
	<?php if ( '' !== $src ) : ?>
		<img class="photo-band__media" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
	<?php endif; ?>
	<span class="photo-band__sc" aria-hidden="true"></span>
	<div class="photo-band__in">
		<?php if ( ! empty( $a['title'] ) ) : ?><h2 class="h2"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<?php if ( ! empty( $a['body'] ) ) : ?>
			<?php echo wp_kses_post( function_exists( 'ea_replace_retired_brand' ) ? ea_replace_retired_brand( (string) $a['body'] ) : (string) $a['body'] ); ?>
		<?php endif; ?>
		<?php if ( ! empty( $a['cta_label'] ) ) : ?>
			<a class="btn btn--sand" href="<?php echo esc_url( $a['cta_url'] ?? '#' ); ?>"><?php echo esc_html( $a['cta_label'] ); ?></a>
		<?php endif; ?>
	</div>
</section>
