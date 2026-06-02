<?php
/**
 * Block: service-comparison — D-14 service-comparison atom.
 *
 * Generic N-column service comparison composed from EXISTING atoms
 * (ea-service-comparison*). New PARTIAL only — not a new atom/token.
 * The current route's column is marked active (background + eyebrow tag).
 *
 * Context via `ea_comparison_ctx` query var:
 *   array(
 *     'heading'    => string,
 *     'aria_label' => string,
 *     'cols'       => array of array(
 *        'title'    => string,   // H3 column title
 *        'body'     => string,   // column paragraph
 *        'active'   => bool,     // current route → active styling + tag
 *        'tag'      => string,   // eyebrow tag for the active col (e.g. "הדף הזה")
 *     ),
 *   )
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_cmp_ctx = get_query_var( 'ea_comparison_ctx' );
if ( ! is_array( $ea_cmp_ctx ) ) {
	$ea_cmp_ctx = array();
}

$ea_cmp_heading = isset( $ea_cmp_ctx['heading'] ) ? (string) $ea_cmp_ctx['heading'] : 'מה ההבדל בין השירותים';
$ea_cmp_aria    = isset( $ea_cmp_ctx['aria_label'] ) ? (string) $ea_cmp_ctx['aria_label'] : 'השוואת שירותים';
$ea_cmp_cols    = ( isset( $ea_cmp_ctx['cols'] ) && is_array( $ea_cmp_ctx['cols'] ) ) ? $ea_cmp_ctx['cols'] : array();

if ( empty( $ea_cmp_cols ) ) {
	return;
}
?>
<section class="ea-service-comparison" data-block="service-comparison" aria-label="<?php echo esc_attr( $ea_cmp_aria ); ?>">
      <div class="ea-service-comparison__inner">
        <h2 class="ea-service-comparison__heading ea-entrance--breath"><?php echo esc_html( $ea_cmp_heading ); ?></h2>
        <div class="ea-service-comparison__grid">
          <?php foreach ( $ea_cmp_cols as $ea_cmp_col ) :
            $ea_c_title  = isset( $ea_cmp_col['title'] ) ? (string) $ea_cmp_col['title'] : '';
            $ea_c_body   = isset( $ea_cmp_col['body'] ) ? (string) $ea_cmp_col['body'] : '';
            $ea_c_active = ! empty( $ea_cmp_col['active'] );
            $ea_c_tag    = isset( $ea_cmp_col['tag'] ) ? (string) $ea_cmp_col['tag'] : '';
            $ea_c_cls    = 'ea-service-comparison__col ea-entrance' . ( $ea_c_active ? ' ea-service-comparison__col--active' : '' );
          ?>
          <article class="<?php echo esc_attr( $ea_c_cls ); ?>">
            <?php if ( $ea_c_active && '' !== $ea_c_tag ) : ?>
            <span class="ea-service-comparison__tag"><?php echo esc_html( $ea_c_tag ); ?></span>
            <?php endif; ?>
            <h3 class="ea-service-comparison__col-title"><?php echo esc_html( $ea_c_title ); ?></h3>
            <?php if ( '' !== $ea_c_body ) : ?>
            <p><?php echo esc_html( $ea_c_body ); ?></p>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
