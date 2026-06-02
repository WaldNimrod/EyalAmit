<?php
/**
 * Block: method-pillars — D-14/POC Wave2.
 *
 * Generic / data-driven (WP-W2-10-A Phase 0b). Reads optional context from the
 * `ea_pillars_ctx` query var (whole-block) and/or `ea_pillars_items` (items only).
 *
 * Supports the home 4-pillar grid, the cbDIDG 4-step grid (`--steps` modifier,
 * 4 columns), the 5-tile "who it's for" grid, and a 6-cell timeline — all as
 * grid-column-count variations driven by `grid_modifier`, using existing grid +
 * `--ea-space` tokens only. No new atom is introduced by this partial.
 *
 * Context shape (all keys optional):
 *   array(
 *     'heading'       => string,        // H2 (omitted if '')
 *     'label'         => string,        // eyebrow label above heading (content-section__label)
 *     'intro'         => string|string[], // intro paragraph(s) under heading
 *     'grid_modifier' => string,        // '' (base 2-col) | 'steps' (4-col) | ... (BEM modifier suffix)
 *     'alt'           => bool,          // true → ea-content-section--alt background
 *     'show_titles'   => bool,          // true (default) → render pillar title (H3)
 *     'cta'           => array( 'label' => string, 'href' => string ) | null,
 *     'aria_label'    => string,
 *     'items'         => array of array(
 *         'label' => string,  // pillar eyebrow / step number
 *         'title' => string,  // pillar title (H3) — optional
 *         'text'  => string,  // pillar body
 *     ),
 *   )
 *
 * Backward compatible: with no context, renders the original HOME cbDIDG block
 * (heading + intro + 4 pillars + ghost CTA to /method).
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_pillars_ctx = get_query_var( 'ea_pillars_ctx' );
if ( ! is_array( $ea_pillars_ctx ) ) {
	$ea_pillars_ctx = array();
}

// Items: prefer the dedicated query var, then the ctx key, then the default.
$ea_pillars_items = get_query_var( 'ea_pillars_items' );
if ( empty( $ea_pillars_items ) && isset( $ea_pillars_ctx['items'] ) ) {
	$ea_pillars_items = $ea_pillars_ctx['items'];
}

$ea_pillars_is_default = empty( $ea_pillars_items );

if ( $ea_pillars_is_default ) {
	$ea_pillars_items = array(
		array( 'label' => '01', 'title' => 'נשימה מעגלית', 'text' => 'לימוד טכניקת הנשימה המעגלית כבסיס לעבודה מתמשכת עם הנשימה היומיומית.' ),
		array( 'label' => '02', 'title' => 'ליווי אישי', 'text' => 'תהליך אישי מותאם, בקצב שמתאים לכל אחד, עם דגש על תרגול מעשי ועצמאי.' ),
		array( 'label' => '03', 'title' => 'חיבור לגוף', 'text' => 'פיתוח מודעות לנשימה ולגוף, הקשבה לסימנים והבנת הקשר בין נשימה לבריאות.' ),
		array( 'label' => '04', 'title' => 'שינוי לטווח ארוך', 'text' => 'המטרה היא שינוי שנמשך מחוץ למפגש ומשפיע על איכות החיים לאורך זמן.' ),
	);
}

$ea_pillars_heading = isset( $ea_pillars_ctx['heading'] )
	? (string) $ea_pillars_ctx['heading']
	: ( $ea_pillars_is_default ? 'שיטת cbDIDG — העקרונות' : '' );

$ea_pillars_label = isset( $ea_pillars_ctx['label'] ) ? (string) $ea_pillars_ctx['label'] : '';

$ea_pillars_aria = isset( $ea_pillars_ctx['aria_label'] )
	? (string) $ea_pillars_ctx['aria_label']
	: ( $ea_pillars_is_default ? 'עמודי שיטת cbDIDG' : ( '' !== $ea_pillars_heading ? $ea_pillars_heading : 'עקרונות' ) );

if ( isset( $ea_pillars_ctx['intro'] ) ) {
	$ea_pillars_intro = is_array( $ea_pillars_ctx['intro'] ) ? $ea_pillars_ctx['intro'] : array( (string) $ea_pillars_ctx['intro'] );
} elseif ( $ea_pillars_is_default ) {
	$ea_pillars_intro = array( 'שיטת cbDIDG (Circular Breathing Didgeridoo) היא גישה טיפולית שפותחה על ידי אייל עמית לאורך למעלה מעשרים שנה של עבודה, לימוד ותרגול. הרקע ההנדסי של אייל איפשר לו לפרק תהליכים מורכבים לשיטה ברורה וישימה.' );
} else {
	$ea_pillars_intro = array();
}

$ea_pillars_modifier = isset( $ea_pillars_ctx['grid_modifier'] ) ? sanitize_html_class( (string) $ea_pillars_ctx['grid_modifier'] ) : '';
$ea_pillars_grid_cls = 'ea-pillars-grid' . ( '' !== $ea_pillars_modifier ? ' ea-pillars-grid--' . $ea_pillars_modifier : '' );

$ea_pillars_alt = array_key_exists( 'alt', $ea_pillars_ctx ) ? (bool) $ea_pillars_ctx['alt'] : true;
$ea_pillars_sect_cls = 'ea-content-section' . ( $ea_pillars_alt ? ' ea-content-section--alt' : '' );

$ea_pillars_show_titles = array_key_exists( 'show_titles', $ea_pillars_ctx ) ? (bool) $ea_pillars_ctx['show_titles'] : true;

if ( array_key_exists( 'cta', $ea_pillars_ctx ) ) {
	$ea_pillars_cta = $ea_pillars_ctx['cta'];
} elseif ( $ea_pillars_is_default ) {
	$ea_pillars_cta = array( 'label' => 'למידע נוסף על השיטה', 'href' => home_url( '/method' ) );
} else {
	$ea_pillars_cta = null;
}
?>
<section class="<?php echo esc_attr( $ea_pillars_sect_cls ); ?>" data-block="method-pillars" aria-label="<?php echo esc_attr( $ea_pillars_aria ); ?>">
      <div class="ea-content-section__inner">
        <?php if ( '' !== $ea_pillars_label ) : ?>
        <p class="ea-content-section__label"><?php echo esc_html( $ea_pillars_label ); ?></p>
        <?php endif; ?>
        <?php if ( '' !== $ea_pillars_heading ) : ?>
        <h2 class="ea-content-section__heading ea-entrance--breath"><?php echo esc_html( $ea_pillars_heading ); ?></h2>
        <?php endif; ?>
        <?php if ( ! empty( $ea_pillars_intro ) ) : ?>
        <div class="ea-content-section__body">
          <?php foreach ( $ea_pillars_intro as $ea_pillars_p ) : ?>
          <p><?php echo esc_html( (string) $ea_pillars_p ); ?></p>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="<?php echo esc_attr( $ea_pillars_grid_cls ); ?>">
          <?php foreach ( $ea_pillars_items as $ea_pillar ) : ?>
          <div class="ea-pillar ea-entrance">
            <?php if ( ! empty( $ea_pillar['label'] ) ) : ?>
            <p class="ea-pillar__label"><?php echo esc_html( (string) $ea_pillar['label'] ); ?></p>
            <?php endif; ?>
            <?php if ( $ea_pillars_show_titles && ! empty( $ea_pillar['title'] ) ) : ?>
            <h3 class="ea-pillar__title"><?php echo esc_html( (string) $ea_pillar['title'] ); ?></h3>
            <?php endif; ?>
            <?php if ( ! empty( $ea_pillar['text'] ) ) : ?>
            <p class="ea-pillar__text"><?php echo esc_html( (string) $ea_pillar['text'] ); ?></p>
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
        <?php if ( is_array( $ea_pillars_cta ) && ! empty( $ea_pillars_cta['label'] ) && ! empty( $ea_pillars_cta['href'] ) ) : ?>
        <div class="ea-block-cta-end">
          <a class="ea-cta-pill ea-cta-pill--ghost" href="<?php echo esc_url( (string) $ea_pillars_cta['href'] ); ?>">
            <?php echo esc_html( (string) $ea_pillars_cta['label'] ); ?>
          </a>
        </div>
        <?php endif; ?>
      </div>
    </section>
