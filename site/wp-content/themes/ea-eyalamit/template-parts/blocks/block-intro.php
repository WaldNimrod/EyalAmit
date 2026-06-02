<?php
/**
 * Block: intro — D-14/POC Wave2.
 *
 * Generic / data-driven (WP-W2-10-A Phase 0b). Reads optional context from the
 * `ea_intro_ctx` query var. When no context is set, falls back to the original
 * hardcoded HOME intro copy so existing pages render identically.
 *
 * Context shape (all keys optional):
 *   array(
 *     'heading'    => string,        // H2
 *     'body'       => string[],      // array of paragraph strings (each wrapped in <p>)
 *     'aria_label' => string,        // section aria-label
 *   )
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_intro_ctx = get_query_var( 'ea_intro_ctx' );
if ( ! is_array( $ea_intro_ctx ) ) {
	$ea_intro_ctx = array();
}

// Defaults = original hardcoded HOME intro.
$ea_intro_heading = isset( $ea_intro_ctx['heading'] )
	? (string) $ea_intro_ctx['heading']
	: 'מה זה טיפול בנשימה באמצעות דיג׳רידו';

$ea_intro_aria = isset( $ea_intro_ctx['aria_label'] )
	? (string) $ea_intro_ctx['aria_label']
	: 'מה זה טיפול בנשימה באמצעות דיג׳רידו';

if ( isset( $ea_intro_ctx['body'] ) && is_array( $ea_intro_ctx['body'] ) && ! empty( $ea_intro_ctx['body'] ) ) {
	$ea_intro_body = $ea_intro_ctx['body'];
} else {
	$ea_intro_body = array(
		'בטיפול בנשימה באמצעות דיג׳רידו, הדיג׳רידו הוא כלי עבודה על הנשימה — לא המטרה עצמה.',
		'יש הבדל בין טכניקת הנשימה המעגלית, המשמשת בזמן נגינה בדיג׳רידו, לבין הנשימה היומיומית הרגילה של האדם. העבודה עם הדיג׳רידו משפיעה על שתיהן, אך הכוונה היא להשפיע על הנשימה ביומיום — זו שמלווה את האדם לאורך כל היום וגם בזמן השינה.',
		'בטיפול נוצר קשר הדוק ומודע עם הנשימה היומיומית. אנו לומדים לשלוט בה, לחזק ולווסת אותה, והכל דרך תרגול מעשי של נגינה בדיג׳רידו.',
		'הנגינה בדיג׳רידו מתפתחת לאורך התהליך, ונשארת אמצעי — לא המטרה.',
		'המטרה היא לא רק להבין את הנשימה היומיומית, אלא ליצור בה שינוי שנמשך גם מחוץ למפגש. שינוי שמשפיע על איכות החיים לטווח הארוך, ועשוי להפחית סימפטומים ולשפר מדדים בריאותיים.',
		'יש דרכים שונות לעבוד עם הנשימה, והדיג׳רידו מציע דרך אחרת, חווייתית, חיה ומעניינת, שמשלבת תרגול עם צליל ונגינה והופכת את העבודה עם הנשימה למשהו שקל יותר להתמיד בו.',
	);
}
?>
<section class="ea-section-intro" data-block="intro" aria-label="<?php echo esc_attr( $ea_intro_aria ); ?>">
      <div class="ea-section-intro__inner ea-entrance--breath">
        <h2 class="ea-section-intro__heading">
          <?php echo esc_html( $ea_intro_heading ); ?>
        </h2>
        <div class="ea-section-intro__body">
          <?php foreach ( $ea_intro_body as $ea_intro_p ) : ?>
          <p><?php echo esc_html( (string) $ea_intro_p ); ?></p>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
