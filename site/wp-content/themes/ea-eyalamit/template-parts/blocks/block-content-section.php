<?php
/**
 * Block: content-section — D-14 atom-structure-content-section.
 *
 * Generic prose content section composed from EXISTING atoms
 * (ea-content-section*). New PARTIAL only — not a new atom/token.
 *
 * Context via `ea_content_ctx` query var (all keys optional):
 *   array(
 *     'label'      => string,        // eyebrow label
 *     'heading'    => string,        // H2
 *     'body'       => string[],      // paragraph strings
 *     'alt'        => bool,          // true → --alt background
 *     'id'         => string,        // anchor id on the <section>
 *     'aria_label' => string,
 *   )
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_cs_ctx = get_query_var( 'ea_content_ctx' );
if ( ! is_array( $ea_cs_ctx ) ) {
	$ea_cs_ctx = array();
}

$ea_cs_label   = isset( $ea_cs_ctx['label'] ) ? (string) $ea_cs_ctx['label'] : '';
$ea_cs_heading = isset( $ea_cs_ctx['heading'] ) ? (string) $ea_cs_ctx['heading'] : '';
$ea_cs_body    = ( isset( $ea_cs_ctx['body'] ) && is_array( $ea_cs_ctx['body'] ) ) ? $ea_cs_ctx['body'] : array();
$ea_cs_alt     = ! empty( $ea_cs_ctx['alt'] );
$ea_cs_id      = isset( $ea_cs_ctx['id'] ) ? sanitize_html_class( (string) $ea_cs_ctx['id'] ) : '';
$ea_cs_aria    = isset( $ea_cs_ctx['aria_label'] ) ? (string) $ea_cs_ctx['aria_label'] : ( '' !== $ea_cs_heading ? $ea_cs_heading : 'תוכן' );

$ea_cs_cls = 'ea-content-section' . ( $ea_cs_alt ? ' ea-content-section--alt' : '' );
?>
<section class="<?php echo esc_attr( $ea_cs_cls ); ?>"<?php echo '' !== $ea_cs_id ? ' id="' . esc_attr( $ea_cs_id ) . '"' : ''; ?> data-block="content-section" aria-label="<?php echo esc_attr( $ea_cs_aria ); ?>">
      <div class="ea-content-section__inner">
        <?php if ( '' !== $ea_cs_label ) : ?>
        <p class="ea-content-section__label"><?php echo esc_html( $ea_cs_label ); ?></p>
        <?php endif; ?>
        <?php if ( '' !== $ea_cs_heading ) : ?>
        <h2 class="ea-content-section__heading ea-entrance--breath"><?php echo esc_html( $ea_cs_heading ); ?></h2>
        <?php endif; ?>
        <?php if ( ! empty( $ea_cs_body ) ) : ?>
        <div class="ea-content-section__body">
          <?php foreach ( $ea_cs_body as $ea_cs_p ) : ?>
          <p><?php echo esc_html( (string) $ea_cs_p ); ?></p>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </section>
