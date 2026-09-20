<?php
/**
 * Wave A 2026-09-20 — first-visit cookie/measurement notice.
 *
 * Facts already published on /privacy/: GA4 G-MRXESK7QJF may use cookies or
 * identifiers; some pages load Google Fonts. Israeli Privacy Law + Amendment 13
 * require transparency, not a GDPR consent wall. This notice does not block
 * GA4 and does not offer categories/reject (that is Wave B).
 *
 * D-6 (2026-09-06) required a cookie banner; this is the informational first
 * slice. Copy is paraphrased from privacy-defaults.php, not invented law.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

function ea_cookie_notice_enqueue_assets() {
	if ( is_admin() ) {
		return;
	}
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style(
		'ea-cookie-notice',
		get_stylesheet_directory_uri() . '/assets/css/ea-cookie-notice.css',
		array( 'ea-wave2-tokens' ),
		$ver
	);
	wp_enqueue_script(
		'ea-cookie-notice',
		get_stylesheet_directory_uri() . '/assets/js/ea-cookie-notice.js',
		array(),
		$ver,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_cookie_notice_enqueue_assets', 3 );

function ea_cookie_notice_render() {
	if ( is_admin() ) {
		return;
	}
	$privacy = esc_url( home_url( '/privacy/' ) );
	?>
<dialog class="ea-cookie" id="ea-cookie-notice" aria-labelledby="ea-cookie-title">
	<div class="ea-cookie__panel">
		<p class="ea-cookie__title" id="ea-cookie-title"><?php esc_html_e( 'שימוש בעוגיות ובמדידה', 'ea-eyalamit' ); ?></p>
		<p class="ea-cookie__body"><?php esc_html_e( 'באתר פועל Google Analytics 4 לאיסוף נתוני שימוש סטטיסטיים, ועשוי להשתמש בעוגיות או במזהים. בחלק מהעמודים נטענים גם גופנים מ־Google.', 'ea-eyalamit' ); ?></p>
		<p class="ea-cookie__body"><a class="ea-cookie__link" href="<?php echo $privacy; ?>"><?php esc_html_e( 'מדיניות הפרטיות', 'ea-eyalamit' ); ?></a></p>
		<div class="ea-cookie__row">
			<button type="button" class="ea-cookie__ack" data-ea-cookie-ack><?php esc_html_e( 'הבנתי', 'ea-eyalamit' ); ?></button>
		</div>
	</div>
</dialog>
	<?php
}
add_action( 'wp_footer', 'ea_cookie_notice_render', 20 );
