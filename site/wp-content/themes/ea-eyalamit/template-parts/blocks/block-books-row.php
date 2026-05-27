<?php
/** Block: books-row — D-14/POC Wave2 */
defined( 'ABSPATH' ) || exit;
?>
<section class="ea-books-section" data-block="books-row" aria-label="ספרי מוזה הוצאה לאור">
      <div class="ea-books-section__inner">
        <h2 class="ea-books-section__heading ea-entrance--breath">מוזה הוצאה לאור</h2>
        <p class="ea-books-section__intro">
          הוצאת ספרים עצמית שהוקמה בשנת 2004. ספרי מסעות, פנטסיה וסיפורים אישיים מעוררי השראה — כתובים מתוך החיים עצמם.
        </p>
        <div class="ea-books-grid">

          <!-- Book 1: וכתבת -->
          <article class="ea-book-card ea-entrance">
            <a class="ea-book-card__link"
               href="<?php echo esc_url( home_url( '/books/vekatavta' ) ); ?>"
               aria-label="פרטים על הספר: וכתבת">
              <div class="ea-book-card__cover-placeholder" aria-hidden="true">
                [כריכת וכתבת]
              </div>
              <div class="ea-book-card__body">
                <h3 class="ea-book-card__title">וכתבת</h3>
                <p class="ea-book-card__teaser">ספר עם 49 קודי QR — כל קוד פותח דלת לסיפור נסתר, וידאו או תמונה.</p>
              </div>
            </a>
          </article>

          <!-- Book 2: כושי בלאנטיס -->
          <article class="ea-book-card ea-entrance" style="animation-delay:0.1s">
            <a class="ea-book-card__link"
               href="<?php echo esc_url( home_url( '/books/kushi-atlantis' ) ); ?>"
               aria-label="פרטים על הספר: כושי בלאנטיס">
              <div class="ea-book-card__cover-placeholder" aria-hidden="true">
                [כריכת כושי בלאנטיס]
              </div>
              <div class="ea-book-card__body">
                <h3 class="ea-book-card__title">כושי בלאנטיס</h3>
                <p class="ea-book-card__teaser">ספר פנטסיה ומסע — עולם שלם של הרפתקאות, חופש והתבוננות.</p>
              </div>
            </a>
          </article>

          <!-- Book 3: צבע בכחול וזרוק לים -->
          <article class="ea-book-card ea-entrance" style="animation-delay:0.2s">
            <a class="ea-book-card__link"
               href="<?php echo esc_url( home_url( '/books/tsva-bekahol' ) ); ?>"
               aria-label="פרטים על הספר: צבע בכחול וזרוק לים">
              <div class="ea-book-card__cover-placeholder" aria-hidden="true">
                [כריכת צבע בכחול]
              </div>
              <div class="ea-book-card__body">
                <h3 class="ea-book-card__title">צבע בכחול וזרוק לים</h3>
                <p class="ea-book-card__teaser">ספר מסעות אישי — קול חי, כתיבה נובעת מתוך החיים, מבט שלא ממהר.</p>
              </div>
            </a>
          </article>

        </div>
        <div style="margin-top: var(--ea-space-6); text-align: right;">
          <a class="ea-cta-pill ea-cta-pill--ghost" href="<?php echo esc_url( home_url( '/books' ) ); ?>">לכל הספרים</a>
        </div>
      </div>
    </section>
