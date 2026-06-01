<?php
/**
 * Template Name: tpl-contact (Wave2)
 * D-14 §5 — CF7 + WhatsApp A/B variants.
 *
 * WP-W2-11 S3 (Conversion cluster) — composition refined to the team_35 C mockup
 * (conversion-contact.html) using ONLY existing D-14 atoms from ea-atoms.css.
 * Two-column ea-contact-section: accessible form (intended CF7 field set) on one
 * side; WhatsApp A/B CTA (canonical ea-cta-ab / ea-ab-testing.js mechanism) +
 * trust reassurances on the other. ea_wave2_render_contact_form() is preserved so
 * a real CF7 form takes over once Eyal creates it (add_filter ea_wave2_cf7_form_id);
 * until then form_id=0 keeps emitting the graceful placeholder note (AC-05).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_wa_url = 'https://wa.me/' . ( defined( 'EA_WAVE2_WHATSAPP_E164' ) ? EA_WAVE2_WHATSAPP_E164 : '972524822842' );

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-contact">
	<section class="ea-contact-page-intro" aria-label="<?php esc_attr_e( 'כותרת צור קשר', 'ea-eyalamit' ); ?>">
		<div class="ea-contact-page-intro__inner ea-entrance">
			<?php the_title( '<h1 class="ea-page-title">', '</h1>' ); ?>
			<p class="ea-contact-page-intro__sub"><?php esc_html_e( 'ניתן ליצור קשר לתיאום שיחת היכרות, שאלות כלליות או כל פנייה אחרת.', 'ea-eyalamit' ); ?></p>
		</div>
	</section>

	<section class="ea-contact-section" data-block="contact" aria-label="<?php esc_attr_e( 'טופס צור קשר ודרכי התקשרות', 'ea-eyalamit' ); ?>">
		<div class="ea-contact-section__inner">

			<!-- Column: accessible contact form (intended CF7 field set; placeholder until form_id wired). -->
			<div class="ea-entrance">
				<h2 class="ea-contact-section__heading"><?php esc_html_e( 'השאירו פנייה', 'ea-eyalamit' ); ?></h2>

				<?php
				// When a real CF7 form_id is wired, ea_wave2_render_contact_form() renders it.
				// On staging (form_id=0) it emits the graceful placeholder <p> note (no fatal).
				ea_wave2_render_contact_form();
				?>

				<form class="ea-contact-form" action="#" method="post" novalidate aria-describedby="ea-cf-intro">
					<p class="ea-sr-only" id="ea-cf-intro"><?php esc_html_e( 'שדות המסומנים כשדה חובה נדרשים למילוי.', 'ea-eyalamit' ); ?></p>

					<div class="ea-contact-form__field">
						<label class="ea-contact-form__label" for="ea-cf-name">
							<?php esc_html_e( 'שם מלא', 'ea-eyalamit' ); ?>
							<span class="ea-sr-only"><?php esc_html_e( '(שדה חובה)', 'ea-eyalamit' ); ?></span>
						</label>
						<input class="ea-contact-form__input" id="ea-cf-name" name="name" type="text" autocomplete="name"
							required aria-required="true" aria-describedby="ea-cf-name-err">
						<span class="ea-contact-form__error" id="ea-cf-name-err" hidden><?php esc_html_e( 'נא להזין שם מלא.', 'ea-eyalamit' ); ?></span>
					</div>

					<div class="ea-contact-form__field">
						<label class="ea-contact-form__label" for="ea-cf-phone">
							<?php esc_html_e( 'טלפון', 'ea-eyalamit' ); ?>
							<span class="ea-sr-only"><?php esc_html_e( '(שדה חובה)', 'ea-eyalamit' ); ?></span>
						</label>
						<input class="ea-contact-form__input" id="ea-cf-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel"
							required aria-required="true" aria-describedby="ea-cf-phone-err">
						<span class="ea-contact-form__error" id="ea-cf-phone-err" hidden><?php esc_html_e( 'נא להזין מספר טלפון תקין.', 'ea-eyalamit' ); ?></span>
					</div>

					<div class="ea-contact-form__field">
						<label class="ea-contact-form__label" for="ea-cf-email"><?php esc_html_e( 'דוא״ל', 'ea-eyalamit' ); ?></label>
						<input class="ea-contact-form__input" id="ea-cf-email" name="email" type="email" autocomplete="email"
							aria-describedby="ea-cf-email-err">
						<span class="ea-contact-form__error" id="ea-cf-email-err" hidden><?php esc_html_e( 'כתובת הדוא״ל אינה תקינה.', 'ea-eyalamit' ); ?></span>
					</div>

					<div class="ea-contact-form__field">
						<label class="ea-contact-form__label" for="ea-cf-topic"><?php esc_html_e( 'נושא הפנייה', 'ea-eyalamit' ); ?></label>
						<select class="ea-contact-form__select" id="ea-cf-topic" name="topic">
							<option value="intro"><?php esc_html_e( 'תיאום שיחת היכרות', 'ea-eyalamit' ); ?></option>
							<option value="treatment"><?php esc_html_e( "טיפול בדיג'רידו", 'ea-eyalamit' ); ?></option>
							<option value="lessons"><?php esc_html_e( 'שיעורי נגינה', 'ea-eyalamit' ); ?></option>
							<option value="sound-healing"><?php esc_html_e( 'סאונד הילינג', 'ea-eyalamit' ); ?></option>
							<option value="didgeridoos"><?php esc_html_e( "רכישת דיג'רידו", 'ea-eyalamit' ); ?></option>
							<option value="general"><?php esc_html_e( 'שאלה כללית', 'ea-eyalamit' ); ?></option>
						</select>
					</div>

					<div class="ea-contact-form__field">
						<label class="ea-contact-form__label" for="ea-cf-message">
							<?php esc_html_e( 'הודעה', 'ea-eyalamit' ); ?>
							<span class="ea-sr-only"><?php esc_html_e( '(שדה חובה)', 'ea-eyalamit' ); ?></span>
						</label>
						<textarea class="ea-contact-form__textarea" id="ea-cf-message" name="message" rows="5"
							required aria-required="true" aria-describedby="ea-cf-message-err"></textarea>
						<span class="ea-contact-form__error" id="ea-cf-message-err" hidden><?php esc_html_e( 'נא להזין את תוכן הפנייה.', 'ea-eyalamit' ); ?></span>
					</div>

					<button class="ea-cta-pill ea-cta-pill--primary" type="submit"><?php esc_html_e( 'שליחת פנייה', 'ea-eyalamit' ); ?></button>

					<p class="ea-contact-form__note"><?php esc_html_e( 'פנייתך תיענה בדרך כלל תוך יום עסקים אחד.', 'ea-eyalamit' ); ?></p>
				</form>
			</div>

			<!-- Column: WhatsApp A/B CTA (canonical ea-cta-ab / ea-ab-testing.js) + trust reassurances. -->
			<aside class="ea-contact-section__cta-side ea-entrance" aria-label="<?php esc_attr_e( 'דרכי התקשרות מהירות', 'ea-eyalamit' ); ?>">
				<h2 class="ea-contact-section__heading"><?php esc_html_e( 'מעדיפים לכתוב ישירות?', 'ea-eyalamit' ); ?></h2>
				<p class="ea-contact-section__body"><?php esc_html_e( 'אפשר לפנות בוואטסאפ ולקבל מענה אישי — גם לתיאום שיחת היכרות וגם לשאלות.', 'ea-eyalamit' ); ?></p>

				<div class="ea-cta-ab" data-ea-ab data-ab-experiment="contact_whatsapp_cta" data-ea-page="contact">
					<a class="ea-cta-pill ea-cta-pill--primary ea-cta-ab__wa"
						href="<?php echo esc_url( $ea_wa_url ); ?>"
						target="_blank"
						rel="noopener noreferrer"
						data-ea-ab-wa
						data-ab-variant="A"
						aria-label="<?php esc_attr_e( 'דברו איתי בוואטסאפ (נפתח בחלון חדש)', 'ea-eyalamit' ); ?>">
						<?php esc_html_e( 'דברו איתי בוואטסאפ', 'ea-eyalamit' ); ?>
					</a>
					<a class="ea-cta-pill ea-cta-pill--primary ea-cta-ab__wa"
						href="<?php echo esc_url( $ea_wa_url ); ?>"
						target="_blank"
						rel="noopener noreferrer"
						data-ea-ab-wa
						data-ab-variant="B"
						aria-label="<?php esc_attr_e( 'לתיאום שיחת היכרות בוואטסאפ (נפתח בחלון חדש)', 'ea-eyalamit' ); ?>"
						hidden>
						<?php esc_html_e( 'לתיאום שיחת היכרות בוואטסאפ', 'ea-eyalamit' ); ?>
					</a>
				</div>

				<p class="ea-contact-section__body"><?php esc_html_e( 'שיחת היכרות ראשונית ללא התחייבות.', 'ea-eyalamit' ); ?></p>
				<p class="ea-contact-section__body"><?php esc_html_e( 'ליווי אישי, אחד על אחד.', 'ea-eyalamit' ); ?></p>
				<p class="ea-contact-section__body"><?php esc_html_e( 'מענה אישי תוך יום עסקים אחד.', 'ea-eyalamit' ); ?></p>
			</aside>

		</div>
	</section>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
