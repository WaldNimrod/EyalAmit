<?php
/** Block: footer-social — D-14/POC Wave2 */
defined( 'ABSPATH' ) || exit;
?>
<section data-block="footer-social">
    <footer class="ea-footer" aria-label="פוטר האתר">
      <div class="ea-footer__inner">
        <p class="ea-footer__brand">אייל עמית</p>
        <p class="ea-footer__tagline">המרכז לטיפול בנשימה באמצעות דיג׳רידו</p>
        <p class="ea-footer__location">פרדס חנה &middot; ישראל</p>

        <!-- Social links — variant_without-tiktok (TikTok pending) -->
        <div class="ea-footer__social" role="list" aria-label="רשתות חברתיות">
          <!-- Facebook -->
          <a class="ea-footer__social-link"
             href="https://www.facebook.com/didgeridoo.studio.eyal.amit"
             target="_blank"
             rel="noopener noreferrer"
             aria-label="פייסבוק של אייל עמית (נפתח בחלון חדש)"
             role="listitem">
            <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="18" height="18">
              <path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
          </a>
          <!-- Instagram -->
          <a class="ea-footer__social-link"
             href="https://www.instagram.com/didgeridoo.therapy.center"
             target="_blank"
             rel="noopener noreferrer"
             aria-label="אינסטגרם של אייל עמית (נפתח בחלון חדש)"
             role="listitem">
            <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="18" height="18">
              <path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
          </a>
          <!-- YouTube -->
          <a class="ea-footer__social-link"
             href="https://www.youtube.com/@%D7%90%D7%99%D7%99%D7%9C%D7%A2%D7%9E%D7%99%D7%AA"
             target="_blank"
             rel="noopener noreferrer"
             aria-label="יוטיוב של אייל עמית (נפתח בחלון חדש)"
             role="listitem">
            <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="18" height="18">
              <path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
          </a>
          <!-- TikTok: hidden per variant_without-tiktok (pending URL from Eyal) -->
          <!-- <a class="ea-footer__social-link" hidden ...>TikTok</a> -->
        </div>

        <!-- Footer navigation -->
        <nav class="ea-footer__nav" aria-label="ניווט פוטר">
          <a class="ea-footer__nav-link" href="<?php echo esc_url( home_url( '/method' ) ); ?>">השיטה</a>
          <a class="ea-footer__nav-link" href="<?php echo esc_url( home_url( '/treatment' ) ); ?>">טיפול</a>
          <a class="ea-footer__nav-link" href="<?php echo esc_url( home_url( '/sound-healing' ) ); ?>">סאונד הילינג</a>
          <a class="ea-footer__nav-link" href="<?php echo esc_url( home_url( '/lessons' ) ); ?>">שיעורים</a>
          <a class="ea-footer__nav-link" href="<?php echo esc_url( home_url( '/books' ) ); ?>">ספרים</a>
          <a class="ea-footer__nav-link" href="<?php echo esc_url( home_url( '/faq' ) ); ?>">שאלות נפוצות</a>
          <a class="ea-footer__nav-link" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">צור קשר</a>
        </nav>

        <hr class="ea-footer__divider" aria-hidden="true">
        <p class="ea-footer__copy">
          &copy; 2026 אייל עמית — המרכז לטיפול בנשימה באמצעות דיג׳רידו. כל הזכויות שמורות.
        </p>
      </div>
    </footer>
  </section><!-- /footer-social -->
