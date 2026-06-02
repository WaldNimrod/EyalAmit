<?php
/**
 * Block: testimonials-row — D-14/POC Wave2.
 *
 * Generic / data-driven (WP-W2-10-A Phase 0b). Reads optional context from the
 * `ea_testimonials_ctx` query var.
 *
 * Context shape (all keys optional):
 *   array(
 *     'heading'    => string,
 *     'aria_label' => string,
 *     'items'      => array of array(
 *        'text'   => string,   // quote (newlines → <br>)
 *        'name'   => string,
 *        'href'   => string,   // optional FB/source link; omitted → plain name
 *        'avatar' => string,   // optional avatar image URL; absent → sand-circle placeholder
 *     ),
 *     'footer' => array( 'label' => string, 'href' => string ),       // plain text link (default)
 *     'ghost_cta' => array( 'label' => string, 'href' => string ),    // ghost CTA pill (service variant)
 *   )
 *
 * Backward compatible: with no context, renders the original HOME 3 testimonials
 * + "לכל ההמלצות" text link.
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_test_ctx = get_query_var( 'ea_testimonials_ctx' );
if ( ! is_array( $ea_test_ctx ) ) {
	$ea_test_ctx = array();
}

$ea_test_heading = isset( $ea_test_ctx['heading'] ) ? (string) $ea_test_ctx['heading'] : 'מה אומרים המגיעים';
$ea_test_aria    = isset( $ea_test_ctx['aria_label'] ) ? (string) $ea_test_ctx['aria_label'] : 'עדויות לקוחות';

$ea_test_items = ( isset( $ea_test_ctx['items'] ) && is_array( $ea_test_ctx['items'] ) ) ? $ea_test_ctx['items'] : array();
if ( empty( $ea_test_items ) ) {
	$ea_test_items = array(
		array(
			'text' => "אייל עמית הציל אותנו ובזכותו חזרנו כולנו לנשום…\nנשימה היא הבסיס להכל\nאפשר ללמוד לנשום מחדש",
			'name' => 'חיה עזריה',
			'href' => 'https://www.facebook.com/share/v/18Ua5NoWv4/',
		),
		array(
			'text' => "גיליתי מסע עוצמתי של נשימה, שקט וחיבור לעצמי\nמעבר לסידור הנשימה שמסדר את הנשמה, קיבלתי גם השקטה של הראש\nזו מתנה לחיים",
			'name' => 'שירי אלקבץ',
			'href' => 'https://www.facebook.com/share/p/1E7ndvYyrp/',
		),
		array(
			'text' => "אני לומדת לנשום מחדש\nלהיות בנוכחות בנשימה זה להיות בנוכחות בחיים\nזה משהו שמחלחל לכל תחום ביום יום",
			'name' => 'נוית צוף שטראוס',
			'href' => 'https://www.facebook.com/share/p/1AdaytsL6w/',
		),
	);
	if ( ! isset( $ea_test_ctx['footer'] ) ) {
		$ea_test_ctx['footer'] = array( 'label' => 'לכל ההמלצות', 'href' => home_url( '/media' ) );
	}
}

$ea_test_footer    = ( isset( $ea_test_ctx['footer'] ) && is_array( $ea_test_ctx['footer'] ) ) ? $ea_test_ctx['footer'] : null;
$ea_test_ghost_cta = ( isset( $ea_test_ctx['ghost_cta'] ) && is_array( $ea_test_ctx['ghost_cta'] ) ) ? $ea_test_ctx['ghost_cta'] : null;
?>
<section class="ea-testimonials-section" data-block="testimonials-row" aria-label="<?php echo esc_attr( $ea_test_aria ); ?>">
      <div class="ea-testimonials-section__inner">
        <h2 class="ea-testimonials-section__heading ea-entrance--breath"><?php echo esc_html( $ea_test_heading ); ?></h2>
        <div class="ea-testimonials-grid">
          <?php foreach ( $ea_test_items as $ea_test_item ) :
            $ea_t_text   = isset( $ea_test_item['text'] ) ? (string) $ea_test_item['text'] : '';
            $ea_t_name   = isset( $ea_test_item['name'] ) ? (string) $ea_test_item['name'] : '';
            $ea_t_href   = isset( $ea_test_item['href'] ) ? (string) $ea_test_item['href'] : '';
            $ea_t_avatar = isset( $ea_test_item['avatar'] ) ? (string) $ea_test_item['avatar'] : '';
          ?>
          <article class="ea-testimonial-card ea-entrance">
            <div class="ea-testimonial-card__figure" aria-hidden="true">
              <?php if ( '' !== $ea_t_avatar ) : ?>
              <img class="ea-testimonial-card__avatar" src="<?php echo esc_url( $ea_t_avatar ); ?>" alt="" width="48" height="48" loading="lazy">
              <?php else : ?>
              <span class="ea-testimonial-card__avatar-placeholder"></span>
              <?php endif; ?>
            </div>
            <blockquote class="ea-testimonial-card__quote">
              <p class="ea-testimonial-card__text">
                <?php echo nl2br( esc_html( $ea_t_text ) ); ?>
              </p>
              <footer class="ea-testimonial-card__footer">
                <?php if ( '' !== $ea_t_href ) : ?>
                <a class="ea-testimonial-card__name ea-link"
                   href="<?php echo esc_url( $ea_t_href ); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="<?php echo esc_attr( 'המלצת ' . $ea_t_name . ' בפייסבוק (נפתח בחלון חדש)' ); ?>">
                  <?php echo esc_html( $ea_t_name ); ?>
                </a>
                <span class="ea-testimonial-card__hint" aria-hidden="true"> ↗</span>
                <?php else : ?>
                <span class="ea-testimonial-card__name"><?php echo esc_html( $ea_t_name ); ?></span>
                <?php endif; ?>
              </footer>
            </blockquote>
          </article>
          <?php endforeach; ?>
        </div>
        <?php if ( is_array( $ea_test_ghost_cta ) && ! empty( $ea_test_ghost_cta['label'] ) && ! empty( $ea_test_ghost_cta['href'] ) ) : ?>
        <div class="ea-testimonials-section__footer">
          <a class="ea-cta-pill ea-cta-pill--ghost" href="<?php echo esc_url( (string) $ea_test_ghost_cta['href'] ); ?>">
            <?php echo esc_html( (string) $ea_test_ghost_cta['label'] ); ?>
          </a>
        </div>
        <?php elseif ( is_array( $ea_test_footer ) && ! empty( $ea_test_footer['label'] ) && ! empty( $ea_test_footer['href'] ) ) : ?>
        <div class="ea-testimonials-section__footer">
          <a class="ea-link" href="<?php echo esc_url( (string) $ea_test_footer['href'] ); ?>"><?php echo esc_html( (string) $ea_test_footer['label'] ); ?></a>
        </div>
        <?php endif; ?>
      </div>
    </section>
