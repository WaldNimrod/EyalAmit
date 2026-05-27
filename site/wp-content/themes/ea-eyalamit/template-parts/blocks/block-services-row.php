<?php
/** Block: services-row — D-14/POC Wave2 */
defined( 'ABSPATH' ) || exit;
?>
<section class="ea-services-section" data-block="services-row" aria-label="שירותים נוספים">
      <div class="ea-services-section__inner">
        <h2 class="ea-services-section__heading ea-entrance--breath">שירותים נוספים</h2>
        <div class="ea-services-grid">
          <a class="ea-service-tile ea-entrance"
             href="<?php echo esc_url( home_url( '/sound-healing' ) ); ?>"
             aria-label="סאונד הילינג — למידע נוסף">
            <p class="ea-service-tile__label">חוויה</p>
            <h3 class="ea-service-tile__title">סאונד הילינג</h3>
            <p class="ea-service-tile__desc">
              חוויה פאסיבית ועמוקה של הקשבה לצליל הדיג׳רידו. הרפיה, איזון ותדרים בחלל מותאם אקוסטית. בדרך כלל מפגש אחד, אינטימי ומיוחד.
            </p>
          </a>
          <a class="ea-service-tile ea-entrance"
             href="<?php echo esc_url( home_url( '/lessons' ) ); ?>"
             style="animation-delay:0.1s"
             aria-label="שיעורי נגינה — למידע נוסף">
            <p class="ea-service-tile__label">לימוד</p>
            <h3 class="ea-service-tile__title">שיעורי נגינה בדיג׳רידו</h3>
            <p class="ea-service-tile__desc">
              לימוד נגינה בדיג׳רידו לכל הרמות. שיעורים פרטיים מותאמים אישית, מפתחים יכולת עצמאית ובונים בסיס נשימתי יציב.
            </p>
          </a>
        </div>
      </div>
    </section>
