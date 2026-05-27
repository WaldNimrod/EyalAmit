<?php
/** Block: treatment-overview — D-14/POC Wave2 */
defined( 'ABSPATH' ) || exit;
?>
<section class="ea-service-comparison" data-block="treatment-overview" aria-label="השוואת שירותים">
      <div class="ea-service-comparison__inner">
        <h2 class="ea-service-comparison__heading ea-entrance--breath">
          טיפול בדיג׳רידו או סאונד הילינג — מה ההבדל?
        </h2>
        <div class="ea-service-comparison__grid" role="list">
          <!-- Treatment column -->
          <div class="ea-service-comparison__col ea-entrance" role="listitem">
            <h3 class="ea-service-comparison__col-title">טיפול בדיג׳רידו</h3>
            <ul class="ea-service-comparison__list">
              <li>עבודה אקטיבית ותהליכית עם הנשימה</li>
              <li>המטופל לומד לחזק ולווסת את מערכת הנשימה</li>
              <li>האפקט הוא לאורך זמן ולטווח הארוך</li>
              <li>תוך כדי, לומדים לנגן בדיג׳רידו</li>
            </ul>
            <p style="font-family: var(--ea-font); font-size: 0.78rem; font-weight: 200; color: var(--ea-muted); margin: 0 0 var(--ea-space-4);">
              למי שסובל מסימפטומים בריאותיים, מוכן להקדיש זמן לתהליך עמוק ורוצה לעבוד עם הנשימה בצורה מעשית.
            </p>
            <div class="ea-service-comparison__cta">
              <a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( home_url( '/treatment' ) ); ?>">למידע נוסף על טיפול</a>
            </div>
          </div>

          <!-- Sound healing column -->
          <div class="ea-service-comparison__col ea-entrance" style="animation-delay:0.15s" role="listitem">
            <h3 class="ea-service-comparison__col-title">סאונד הילינג</h3>
            <ul class="ea-service-comparison__list">
              <li>חוויה פאסיבית של הקשבה לצליל</li>
              <li>מטרה: הרפיה ואיזון באמצעות תדרים</li>
              <li>האפקט הוא מיידי וקצר מועד</li>
              <li>חוויה אינטימית ומיוחדת, בדרך כלל חד-פעמית</li>
            </ul>
            <p style="font-family: var(--ea-font); font-size: 0.78rem; font-weight: 200; color: var(--ea-muted); margin: 0 0 var(--ea-space-4);">
              למי שמחפש חוויה עמוקה ומיידית של הרפיה ורוצה לשמוע ולחוש בגוף את הדיג׳רידו.
            </p>
            <div class="ea-service-comparison__cta">
              <a class="ea-cta-pill ea-cta-pill--ghost" href="<?php echo esc_url( home_url( '/sound-healing' ) ); ?>">למידע נוסף על סאונד הילינג</a>
            </div>
          </div>
        </div>
      </div>
    </section>
