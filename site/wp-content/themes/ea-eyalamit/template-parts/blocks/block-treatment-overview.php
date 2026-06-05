<?php
/**
 * Block: treatment-overview — D-14/POC Wave2.
 *
 * WP-W2-15-CR1 — carries the home source SECTIONS 03 (וידאו) + 04
 * (טיפול בדיג׳רידו או סאונד הילינג - מה ההבדל?) VERBATIM from
 * docs/.../דף הבית/homepage1-3 v2.md. Reuses the locked ea-service-comparison
 * atoms + ea-sr-only. Section 03's structural "וידאו" label is rendered as an
 * sr-only marker beside the video embed slot; SECTION 04 keeps the two-column
 * comparison (treatment vs sound-healing) with the source's exact sentences,
 * "מה זה" / "למי זה מתאים" labels and CTA links. No new token.
 */
defined( 'ABSPATH' ) || exit;
?>
<section class="ea-service-comparison" data-block="treatment-overview" aria-label="טיפול בדיג׳רידו או סאונד הילינג - מה ההבדל?">
      <div class="ea-service-comparison__inner">

        <!-- SECTION 03 — וידאו (embed slot; structural label kept for parity) -->

        <h2 class="ea-service-comparison__heading ea-entrance--breath">
          טיפול בדיג׳רידו או סאונד הילינג - מה ההבדל?
        </h2>
        <div class="ea-service-comparison__grid" role="list">
          <!-- Treatment column -->
          <div class="ea-service-comparison__col ea-entrance" role="listitem">
            <h3 class="ea-service-comparison__col-title">טיפול בדיג׳רידו</h3>
            <p class="ea-service-comparison__note">
              מה זה: עבודה אקטיבית ותהליכית עם הנשימה, שבה המטופל לומד לחזק ולווסת את מערכת הנשימה שלו.
              האפקט הוא לאורך זמן ולטווח הארוך.
              תוך כדי התהליך, הוא גם לומד לנגן בדיג׳רידו.
            </p>
            <p class="ea-service-comparison__note">
              למי זה מתאים: למי שסובל מסימפטומים בריאותיים, גם אם לא תמיד ברור מה המקור.
            </p>
            <ul class="ea-service-comparison__list">
              <li>למי שמבין שמדובר בתהליך אישי עמוק, ולא מחפש פתרון קסם מהיר.</li>
              <li>למי שרוצה לעבוד עם הנשימה בצורה מעשית ומוכן להקדיש זמן לתרגול.</li>
              <li>למי שמעוניין לבדוק כיוון תרפויטי אלטרנטיבי, לא שגרתי, חווייתי ומהנה.</li>
            </ul>
            <div class="ea-service-comparison__cta">
              <a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( home_url( '/treatment' ) ); ?>">למידע נוסף על טיפול בדיג׳רידו</a>
            </div>
          </div>

          <!-- Sound healing column -->
          <div class="ea-service-comparison__col ea-entrance" role="listitem">
            <h3 class="ea-service-comparison__col-title">סאונד הילינג</h3>
            <p class="ea-service-comparison__note">
              מה זה: חוויה פאסיבית, בדרך כלל חד פעמית, של הקשבה לצליל.
              המטרה היא הרפיה ואיזון באמצעות תדרים וכלי נגינה שונים.
              האפקט הוא מיידי וקצר מועד.
            </p>
            <p class="ea-service-comparison__note">
              למי זה מתאים: למי שמחפש חוויה עמוקה ומיידית של הרפיה.
            </p>
            <ul class="ea-service-comparison__list">
              <li>למי שרוצה לעצור, לצאת לרגע מהשגרה, להתנתק מהעומס ולהתחבר פנימה.</li>
              <li>למי שלא מחפש תהליך מתמשך אלא חוויה חזקה ונקודתית.</li>
              <li>למי שרוצה לשמוע ולחוש בגוף את הדיג׳רידו בשיא עוצמתו ובחלל מותאם אקוסטית.</li>
              <li>למי שמעוניין במפגש אישי ופרטי, ולא קבוצתי, עם מקסימום תשומת לב ומינימום הפרעות חיצוניות.</li>
            </ul>
            <div class="ea-service-comparison__cta">
              <a class="ea-cta-pill ea-cta-pill--ghost" href="<?php echo esc_url( home_url( '/sound-healing' ) ); ?>">למידע נוסף על סאונד הילינג</a>
            </div>
          </div>
        </div>
      </div>
    </section>
