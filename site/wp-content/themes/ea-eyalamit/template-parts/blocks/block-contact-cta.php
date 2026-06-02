<?php
/** Block: contact-cta — D-14/POC Wave2 */
defined( 'ABSPATH' ) || exit;
?>
<section class="ea-contact-section" data-block="contact-cta" aria-label="יצירת קשר">
      <div class="ea-contact-section__inner">

        <!-- CTA side -->
        <div class="ea-contact-section__cta-side ea-entrance--breath">
          <h2 class="ea-contact-section__heading">מתחילים בצעד פשוט</h2>
          <p class="ea-contact-section__body">
            אם אתם מרגישים שהגיע הזמן להתחבר לנשימה שלכם, לחזק אותה, לווסת אותה ולהיכנס לתהליך הדרגתי, חווייתי ומהנה — אפשר להתחיל בשיחת היכרות קצרה.
          </p>
          <p class="ea-contact-section__body">
            השיחה מאפשרת לשאול שאלות ולקבל כיוון ראשוני. אין צורך להתחייב מראש לתהליך.
          </p>
          <a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">
            לתיאום שיחת היכרות
          </a>
          <p class="ea-contact-form__note ea-contact-form__note--cta">
            אפשר גם לשלוח הודעה ישירה בוואטסאפ ↙
          </p>
        </div>

        <!-- SLOT: cf7-form-id — atom-interaction-contact-form -->
        <div class="ea-contact-section__form ea-entrance">
          <?php ea_wave2_render_contact_form(); ?>
        </div>

      </div>
    </section>
