<?php
/**
 * Wave B 2026-09-21 — first-visit measurement choice (accept / reject).
 *
 * Replaces Wave A acknowledgement-only notice. Key: ea_cookie_cmp = accept|reject.
 * Ignores legacy ea_cookie_notice_ack. PHP gates GA4 + Google Fonts via cookie;
 * JS mirrors choice to localStorage + first-party cookie (path=/, SameSite=Lax).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether GA4 / Clarity / Google Fonts may load for this request.
 *
 * @return bool
 */
function ea_cookie_measurement_allowed() {
	return isset( $_COOKIE['ea_cookie_cmp'] ) && 'accept' === $_COOKIE['ea_cookie_cmp'];
}

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
		<p class="ea-cookie__title" id="ea-cookie-title"><?php esc_html_e( 'שימוש בעוגיות', 'ea-eyalamit' ); ?></p>
		<p class="ea-cookie__body"><?php
			echo wp_kses(
				sprintf(
					/* translators: %s: privacy policy URL */
					__( 'כדי לשפר את חוויית הגלישה, לתפעל את האתר ולנתח את השימוש בו, אנו משתמשים בקובצי Cookies ובטכנולוגיות דומות. מידע נוסף על השימוש במידע מופיע ב<a class="ea-cookie__link" href="%s">מדיניות הפרטיות</a>.', 'ea-eyalamit' ),
					$privacy
				),
				array(
					'a' => array(
						'class' => array(),
						'href'  => array(),
					),
				)
			);
		?></p>
		<div class="ea-cookie__row">
			<button type="button" class="ea-cookie__ack" data-ea-cookie-choice="accept"><?php esc_html_e( 'אישור', 'ea-eyalamit' ); ?></button>
			<button type="button" class="ea-cookie__reject" data-ea-cookie-choice="reject"><?php esc_html_e( 'דחייה', 'ea-eyalamit' ); ?></button>
		</div>
	</div>
</dialog>
	<?php
}
add_action( 'wp_footer', 'ea_cookie_notice_render', 5 );
