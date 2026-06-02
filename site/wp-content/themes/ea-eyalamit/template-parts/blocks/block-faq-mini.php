<?php
/**
 * Block: faq-mini — D-14/POC Wave2.
 *
 * Generic / data-driven (WP-W2-10-A Phase 0b). Reads optional context from the
 * `ea_faq_mini_ctx` query var.
 *
 * Context shape (all keys optional):
 *   array(
 *     'heading'    => string,
 *     'aria_label' => string,
 *     'items'      => array of array( 'q' => string, 'a' => string ),
 *     'footer'     => array( 'label' => string, 'href' => string ),
 *   )
 *
 * Backward compatible: with no context, renders the original HOME 4 FAQ items
 * + "לכל השאלות הנפוצות" link to /faq.
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_faqm_ctx = get_query_var( 'ea_faq_mini_ctx' );
if ( ! is_array( $ea_faqm_ctx ) ) {
	$ea_faqm_ctx = array();
}

$ea_faqm_heading = isset( $ea_faqm_ctx['heading'] ) ? (string) $ea_faqm_ctx['heading'] : 'שאלות נפוצות';
$ea_faqm_aria    = isset( $ea_faqm_ctx['aria_label'] ) ? (string) $ea_faqm_ctx['aria_label'] : 'שאלות נפוצות';

$ea_faqm_items = ( isset( $ea_faqm_ctx['items'] ) && is_array( $ea_faqm_ctx['items'] ) ) ? $ea_faqm_ctx['items'] : array();
if ( empty( $ea_faqm_items ) ) {
	$ea_faqm_items = array(
		array( 'q' => 'האם טיפול בדיג׳רידו מתאים גם למי שאין לו ידע מוזיקלי?', 'a' => 'כן, בהחלט. הטיפול לא דורש ידע מוזיקלי מוקדם. הדיג׳רידו הוא כלי העבודה, לא המטרה. הלמידה מתחילה מאפס ומותאמת לכל אחד.' ),
		array( 'q' => 'כמה מפגשים נדרשים כדי לראות שינוי?', 'a' => 'כל אחד שונה, אך בדרך כלל ניתן לחוש שינוי ראשוני כבר לאחר מספר מפגשים. השינוי העמוק יותר מגיע עם תרגול עקבי לאורך זמן. הדגש הוא על תהליך הדרגתי, לא פתרון קסם מהיר.' ),
		array( 'q' => 'מה ההבדל בין טיפול בדיג׳רידו לסאונד הילינג?', 'a' => 'בטיפול בדיג׳רידו — המטופל פעיל, לומד לנגן ולשלוט בנשימה. האפקט הוא לטווח ארוך. בסאונד הילינג — החוויה פאסיבית, מיועדת להרפיה מיידית. שתי הגישות משלימות ושונות בתכלית.' ),
		array( 'q' => 'איפה מתקיימים המפגשים?', 'a' => 'המפגשים מתקיימים בסטודיו שבלב חצר מטופחת בפרדס חנה — מוקפת ירוק, עצי פרי בוגרים, שבילי עץ, שדרת במבוקים וגינת ירק מלבלבת. הסטודיו תוכנן מתוך הבנה עמוקה של סאונד ואקוסטיקה.' ),
	);
}

$ea_faqm_footer = ( isset( $ea_faqm_ctx['footer'] ) && is_array( $ea_faqm_ctx['footer'] ) )
	? $ea_faqm_ctx['footer']
	: array( 'label' => 'לכל השאלות הנפוצות', 'href' => home_url( '/faq' ) );
?>
<section class="ea-faq-mini-section" data-block="faq-mini" aria-label="<?php echo esc_attr( $ea_faqm_aria ); ?>">
      <div class="ea-faq-mini-section__inner">
        <h2 class="ea-faq-mini-section__heading ea-entrance--breath"><?php echo esc_html( $ea_faqm_heading ); ?></h2>
        <div class="ea-faq-list">
          <?php foreach ( $ea_faqm_items as $ea_faqm_item ) :
            $ea_faqm_q = isset( $ea_faqm_item['q'] ) ? (string) $ea_faqm_item['q'] : '';
            $ea_faqm_a = isset( $ea_faqm_item['a'] ) ? (string) $ea_faqm_item['a'] : '';
            if ( '' === $ea_faqm_q ) {
              continue;
            }
          ?>
          <div class="ea-faq-item">
            <details class="ea-faq-item__details">
              <summary class="ea-faq-item__summary" aria-expanded="false">
                <h3 class="ea-faq-item__question"><?php echo esc_html( $ea_faqm_q ); ?></h3>
                <span class="ea-faq-item__icon" aria-hidden="true">
                  <svg viewBox="0 0 16 16" width="16" height="16" focusable="false">
                    <path d="M2 5l6 6 6-6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                  </svg>
                </span>
              </summary>
              <div class="ea-faq-item__answer">
                <p><?php echo esc_html( $ea_faqm_a ); ?></p>
              </div>
            </details>
          </div>
          <?php endforeach; ?>
        </div>
        <?php if ( is_array( $ea_faqm_footer ) && ! empty( $ea_faqm_footer['label'] ) && ! empty( $ea_faqm_footer['href'] ) ) : ?>
        <div class="ea-faq-mini-section__footer">
          <a class="ea-link" href="<?php echo esc_url( (string) $ea_faqm_footer['href'] ); ?>"><?php echo esc_html( (string) $ea_faqm_footer['label'] ); ?></a>
        </div>
        <?php endif; ?>
      </div>
    </section>
