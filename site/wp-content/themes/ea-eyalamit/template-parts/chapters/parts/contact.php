<?php
/**
 * Chapters part — contact section. Three stacked rows (Eyal, 2026-09-17:
 * "the page needs to be built from visually separated parts, rows, like the
 * home page — each row with a touch of design that separates it"), replacing
 * the previous single flat block:
 *   1) form + a small photo of Eyal next to it
 *   2) a dark WhatsApp CTA band (matches the home page's .cta-band look),
 *      with the trust points styled as short headlines rather than body text
 *   3) the NAP details, its own row with plain, deliberate typography
 *
 * CF7 takes over row 1's form via ea_wave2_render_contact_form() once Eyal
 * wires the form id. WhatsApp CTA is the canonical ea-cta-ab / ea-ab-testing.js
 * → generate_lead. Reuses the ea-contact-* / ea-cta-* atoms (ea-atoms.css
 * loads on Chapters views via the Wave2 shell).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_wa_url = function_exists( 'ea_wave2_wa_url' )
	? ea_wave2_wa_url( 'היי אייל, הגעתי דרך עמוד צור הקשר ואשמח לתאם שיחת היכרות' )
	: 'https://wa.me/' . ( defined( 'EA_WAVE2_WHATSAPP_E164' ) ? EA_WAVE2_WHATSAPP_E164 : '972524822842' );
?>
<section class="sec ea-wave2-contact" data-block="contact">
	<div class="wrap">
		<div class="ea-contact-form-row">

			<!-- Form (CF7 placeholder until form_id wired). -->
			<div class="ea-entrance">
				<h2 class="ea-contact-section__heading r"><?php esc_html_e( 'השאירו פנייה', 'ea-eyalamit' ); ?></h2>
				<?php if ( ! ea_wave2_render_contact_form() ) : ?>

				<form class="ea-contact-form" action="#" method="post" novalidate aria-describedby="ea-cf-intro">
					<p class="ea-sr-only" id="ea-cf-intro"><?php esc_html_e( 'שדות המסומנים כשדה חובה נדרשים למילוי.', 'ea-eyalamit' ); ?></p>

					<div class="ea-contact-form__field">
						<label class="ea-contact-form__label" for="ea-cf-name"><?php esc_html_e( 'שם מלא', 'ea-eyalamit' ); ?><span class="ea-sr-only"><?php esc_html_e( '(שדה חובה)', 'ea-eyalamit' ); ?></span></label>
						<input class="ea-contact-form__input" id="ea-cf-name" name="name" type="text" autocomplete="name" required aria-required="true" aria-describedby="ea-cf-name-err">
						<span class="ea-contact-form__error" id="ea-cf-name-err" hidden><?php esc_html_e( 'נא להזין שם מלא.', 'ea-eyalamit' ); ?></span>
					</div>

					<div class="ea-contact-form__field">
						<label class="ea-contact-form__label" for="ea-cf-phone"><?php esc_html_e( 'טלפון', 'ea-eyalamit' ); ?><span class="ea-sr-only"><?php esc_html_e( '(שדה חובה)', 'ea-eyalamit' ); ?></span></label>
						<input class="ea-contact-form__input" id="ea-cf-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" required aria-required="true" aria-describedby="ea-cf-phone-err">
						<span class="ea-contact-form__error" id="ea-cf-phone-err" hidden><?php esc_html_e( 'נא להזין מספר טלפון תקין.', 'ea-eyalamit' ); ?></span>
					</div>

					<div class="ea-contact-form__field">
						<label class="ea-contact-form__label" for="ea-cf-email"><?php esc_html_e( 'דוא״ל', 'ea-eyalamit' ); ?></label>
						<input class="ea-contact-form__input" id="ea-cf-email" name="email" type="email" autocomplete="email" aria-describedby="ea-cf-email-err">
						<span class="ea-contact-form__error" id="ea-cf-email-err" hidden><?php esc_html_e( 'כתובת הדוא״ל אינה תקינה.', 'ea-eyalamit' ); ?></span>
					</div>

					<div class="ea-contact-form__field">
						<label class="ea-contact-form__label" for="ea-cf-message"><?php esc_html_e( 'הודעה', 'ea-eyalamit' ); ?><span class="ea-sr-only"><?php esc_html_e( '(שדה חובה)', 'ea-eyalamit' ); ?></span></label>
						<textarea class="ea-contact-form__textarea" id="ea-cf-message" name="message" rows="5" required aria-required="true" aria-describedby="ea-cf-message-err"></textarea>
						<span class="ea-contact-form__error" id="ea-cf-message-err" hidden><?php esc_html_e( 'נא להזין את תוכן הפנייה.', 'ea-eyalamit' ); ?></span>
					</div>

					<button class="ea-cta-pill ea-cta-pill--primary" type="submit"><?php esc_html_e( 'שליחת פנייה', 'ea-eyalamit' ); ?></button>
					<p class="ea-contact-form__note"><?php esc_html_e( 'פנייתך תיענה בדרך כלל תוך יום עסקים אחד.', 'ea-eyalamit' ); ?></p>
				</form>
				<?php endif; ?>
			</div>

			<!-- Small photo of Eyal, next to the form (same portrait used on /eyal-amit/). -->
			<span class="ea-contact-portrait ea-entrance" aria-hidden="true">
				<img src="<?php echo esc_url( ea_chapters_resolve_img( 'assets/images/chapters/eyal-portrait-garden.jpg' ) ); ?>" alt="" loading="lazy">
			</span>

		</div>
	</div>
</section>

<!-- Dark CTA row (same look as the home page's .cta-band), replacing the plain "prefer to write" text block. -->
<section class="sec sec--dark ea-wave2-contact__cta" data-block="contact-cta">
	<span class="cta-band__logo cta-band__logo--side" aria-hidden="true"></span>
	<div class="wrap">
		<div class="ea-entrance ea-contact-cta r" aria-label="<?php esc_attr_e( 'דרכי התקשרות מהירות', 'ea-eyalamit' ); ?>">
			<h2 class="ea-contact-section__heading"><?php esc_html_e( 'מעדיפים לכתוב ישירות?', 'ea-eyalamit' ); ?></h2>
			<p class="ea-contact-section__body"><?php esc_html_e( 'אפשר לפנות בוואטסאפ ולקבל מענה אישי — גם לתיאום שיחת היכרות וגם לשאלות.', 'ea-eyalamit' ); ?></p>

			<div class="ea-cta-ab" data-ea-ab data-ab-experiment="contact_whatsapp_cta" data-ea-page="contact">
				<a class="ea-cta-pill ea-cta-pill--primary ea-cta-ab__wa" href="<?php echo esc_url( $ea_wa_url ); ?>" target="_blank" rel="noopener noreferrer" data-ea-ab-wa data-ab-variant="A" aria-label="<?php esc_attr_e( 'דברו איתי בוואטסאפ (נפתח בחלון חדש)', 'ea-eyalamit' ); ?>"><?php esc_html_e( 'דברו איתי בוואטסאפ', 'ea-eyalamit' ); ?></a>
			</div>

			<ul class="ea-contact-points">
				<li><?php esc_html_e( 'שיחת היכרות ראשונית ללא התחייבות', 'ea-eyalamit' ); ?></li>
				<li><?php esc_html_e( 'ליווי אישי, אחד על אחד', 'ea-eyalamit' ); ?></li>
				<li><?php esc_html_e( 'מענה אישי תוך יום עסקים אחד', 'ea-eyalamit' ); ?></li>
			</ul>
		</div>
	</div>
</section>

<!-- NAP row, its own block so it reads as a distinct "details" section, not a footnote under the CTA. -->
<section class="sec sec--alt ea-wave2-contact__nap" data-block="contact-nap">
	<div class="wrap center">
		<div class="ea-entrance ea-contact-nap" aria-label="<?php esc_attr_e( 'פרטי המרכז וכתובת', 'ea-eyalamit' ); ?>">
			<h3 class="ea-contact-nap__h"><?php esc_html_e( "המרכז לטיפול בנשימה באמצעות דיג'רידו", 'ea-eyalamit' ); ?></h3>
			<p class="ea-contact-nap__row"><?php echo esc_html( ea_nap( 'address_display' ) ); ?></p>
			<p class="ea-contact-nap__row"><?php esc_html_e( 'טלפון / וואטסאפ:', 'ea-eyalamit' ); ?> <a href="tel:<?php echo esc_attr( ea_nap( 'phone_href' ) ); ?>" dir="ltr" style="white-space:nowrap"><?php echo esc_html( ea_nap( 'phone_display' ) ); ?></a></p>
			<p class="ea-contact-nap__row"><?php esc_html_e( "שעות פעילות: א'–ה' 9:00–19:00 · ו' 9:00–14:00 · שבת סגור · ביקור בתיאום מראש", 'ea-eyalamit' ); ?></p>
		</div>
	</div>
</section>
