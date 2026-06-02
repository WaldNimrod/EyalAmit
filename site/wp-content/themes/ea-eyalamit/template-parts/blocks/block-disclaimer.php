<?php
/**
 * Block: disclaimer — D-14 disclaimer atom.
 *
 * Legally-required note. New PARTIAL composed with EXISTING tokens
 * (.ea-disclaimer*). Not a new atom/token.
 *
 * Context via `ea_disclaimer_ctx` query var (optional):
 *   array(
 *     'text'       => string,        // verbatim disclaimer copy
 *     'aria_label' => string,
 *   )
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_disc_ctx = get_query_var( 'ea_disclaimer_ctx' );
if ( ! is_array( $ea_disc_ctx ) ) {
	$ea_disc_ctx = array();
}

$ea_disc_text = isset( $ea_disc_ctx['text'] )
	? (string) $ea_disc_ctx['text']
	: 'המידע באתר זה אינו מהווה ייעוץ רפואי, אבחון או טיפול רפואי, ואינו מחליף פנייה לאיש מקצוע מוסמך. במקרים של מצב רפואי או נפשי, יש להתייעץ עם גורם רפואי מוסמך לפני תחילת התהליך.';
$ea_disc_aria = isset( $ea_disc_ctx['aria_label'] ) ? (string) $ea_disc_ctx['aria_label'] : 'הבהרה';
?>
<section class="ea-disclaimer" data-block="disclaimer" aria-label="<?php echo esc_attr( $ea_disc_aria ); ?>">
      <div class="ea-disclaimer__inner">
        <p class="ea-disclaimer__text"><?php echo esc_html( $ea_disc_text ); ?></p>
      </div>
    </section>
