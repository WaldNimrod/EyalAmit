<?php
/** Block: hero — D-14/POC Wave2 */
defined( 'ABSPATH' ) || exit;
?>
<section class="ea-hero" data-block="hero" aria-label="גיבור ראשי">
      <!-- Background: CSS gradient placeholder (variant_placeholder — pre-video delivery) -->
      <div class="ea-hero__bg" aria-hidden="true">
        <div class="ea-hero__gradient-bg"></div>
        <!-- Breathing overlay lines — decorative -->
        <span class="ea-hero__breath-line ea-hero__breath-line--1" aria-hidden="true"></span>
        <span class="ea-hero__breath-line ea-hero__breath-line--2" aria-hidden="true"></span>
        <span class="ea-hero__breath-line ea-hero__breath-line--3" aria-hidden="true"></span>
        <?php /* TEMP placeholder image from the net (Lorem Picsum, grayscale+blur) — pre-video stand-in; swap for Eyal's real hero video/asset. Sits above the gradient, below the dark contrast overlay. */ ?>
        <img class="ea-hero__placeholder" src="https://picsum.photos/seed/eyalamit-hero/1920/1080?grayscale&amp;blur=2" alt="" aria-hidden="true" loading="eager" decoding="async" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:1;" />
      </div>

      <!-- Dark overlay for contrast -->
      <div class="ea-hero__overlay" aria-hidden="true"></div>

      <!-- Content -->
      <div class="ea-hero__content">
        <h1 class="ea-hero__title">
          המרכז לטיפול בנשימה באמצעות דיג׳רידו<br>שיטת cbDIDG של אייל עמית
        </h1>
        <p class="ea-hero__subtitle">
          להחזיר שליטה על הנשימה דרך עבודה עם דיג׳רידו, תרגול נשימה וליווי אישי<br>
          בגישה טיפולית מבוססת דיג׳רידו ובהשראת חניכה אישית אצל מוקש דהימן
        </p>
        <p class="ea-hero__trust">
          אייל עמית &middot; פועל מאז 1999 &middot; מהוותיקים בארץ בתחום &middot; מטפל ומלמד בשיטה שפותחה לאורך השנים &middot; בונה כלים בעבודת יד
        </p>
        <div class="ea-hero__cta-wrap">
          <a class="ea-cta-pill ea-cta-pill--ghost-white" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">
            לתיאום שיחת היכרות
          </a>
        </div>
      </div>

    </section>
