<?php
/**
 * Block: bio — D-14 atom-content-bio-block.
 *
 * Composed from EXISTING atoms (ea-bio-block* + ea-sr-only). New PARTIAL only —
 * NOT a new atom or token. Renders a prose + portrait two-column bio block.
 *
 * Context via `ea_bio_ctx` query var (all keys optional):
 *   array(
 *     'heading'    => string,        // H2
 *     'body'       => string[],      // paragraph strings
 *     'image'      => string,        // portrait URL; absent → sand placeholder
 *     'image_alt'  => string,        // alt text for the portrait
 *     'image_cap'  => string,        // visually-hidden figcaption
 *     'aria_label' => string,        // section aria-label
 *   )
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_bio_ctx = get_query_var( 'ea_bio_ctx' );
if ( ! is_array( $ea_bio_ctx ) ) {
	$ea_bio_ctx = array();
}

$ea_bio_heading = isset( $ea_bio_ctx['heading'] ) ? (string) $ea_bio_ctx['heading'] : 'איך נראה מפגש';
$ea_bio_aria    = isset( $ea_bio_ctx['aria_label'] ) ? (string) $ea_bio_ctx['aria_label'] : $ea_bio_heading;
$ea_bio_body    = ( isset( $ea_bio_ctx['body'] ) && is_array( $ea_bio_ctx['body'] ) ) ? $ea_bio_ctx['body'] : array();
$ea_bio_img     = isset( $ea_bio_ctx['image'] ) ? (string) $ea_bio_ctx['image'] : '';
$ea_bio_img_alt = isset( $ea_bio_ctx['image_alt'] ) ? (string) $ea_bio_ctx['image_alt'] : '';
$ea_bio_img_cap = isset( $ea_bio_ctx['image_cap'] ) ? (string) $ea_bio_ctx['image_cap'] : '';
?>
<section class="ea-bio-block" data-block="bio" aria-label="<?php echo esc_attr( $ea_bio_aria ); ?>">
      <div class="ea-bio-block__inner">
        <div class="ea-bio-block__content ea-entrance--breath">
          <h2 class="ea-bio-block__heading"><?php echo esc_html( $ea_bio_heading ); ?></h2>
          <?php foreach ( $ea_bio_body as $ea_bio_p ) : ?>
          <p class="ea-bio-block__text"><?php echo esc_html( (string) $ea_bio_p ); ?></p>
          <?php endforeach; ?>
        </div>
        <figure class="ea-bio-block__figure ea-entrance">
          <?php if ( '' !== $ea_bio_img ) : ?>
          <img class="ea-bio-block__portrait" src="<?php echo esc_url( $ea_bio_img ); ?>" alt="<?php echo esc_attr( $ea_bio_img_alt ); ?>" width="320" height="400" loading="lazy">
          <?php else : ?>
          <span class="ea-bio-block__portrait-placeholder" aria-hidden="true"></span>
          <?php endif; ?>
          <?php if ( '' !== $ea_bio_img_cap ) : ?>
          <figcaption class="ea-sr-only"><?php echo esc_html( $ea_bio_img_cap ); ?></figcaption>
          <?php endif; ?>
        </figure>
      </div>
    </section>
