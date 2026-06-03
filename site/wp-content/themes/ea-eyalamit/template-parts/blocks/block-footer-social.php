<?php
/**
 * Block: footer-social — D-14/POC Wave2.
 *
 * Canonical site footer (WP-W2-14-A, team_35 package). Renders the single
 * .ea-cfoot grid — brand+location · ניווט · מידע ותקנון · עקבו · copyright —
 * uniformly on every template (resolves the review note "footer with all the
 * info"). 4-col >=768px → 2-col <=767 (brand spans) → 1-col <=479. The primary
 * "ניווט" column mirrors the locked primary menu; "מידע ותקנון" mirrors the
 * footer-only catalog/legal links; "עקבו" keeps the real social channels.
 *
 * Context (optional):
 *   ea_nav_dir : string — 'rtl' (default) | 'ltr'. LTR hint for a future EN
 *                caller; emits dir="ltr" on the <footer>. Backward compatible.
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_nav_dir = (string) get_query_var( 'ea_nav_dir' );
if ( 'ltr' !== $ea_nav_dir ) {
	$ea_nav_dir = 'rtl';
}

/*
 * "ניווט" — the approved primary menu (SSoT: hub/data/site-tree.json,
 * Eyal 2026-04-06). Mirrors block-topnav.php's top-level items so the footer
 * nav is identical to the primary nav.
 */
$ea_cfoot_nav = array(
	array( 'href' => home_url( '/treatment' ),             'label' => 'טיפול בדיג׳רידו' ),
	array( 'href' => home_url( '/method' ),                'label' => 'השיטה' ),
	array( 'href' => home_url( '/lessons' ),               'label' => 'שיעורי דיג׳רידו' ),
	array( 'href' => home_url( '/sound-healing' ),         'label' => 'סאונד הילינג' ),
	array( 'href' => home_url( '/learning' ),              'label' => 'לימוד והכשרה' ),
	array( 'href' => home_url( '/tools-and-accessories' ), 'label' => 'כלים ואביזרים' ),
	array( 'href' => home_url( '/muzza' ),                 'label' => 'מוזה הוצאה לאור' ),
	array( 'href' => home_url( '/blog' ),                  'label' => 'בלוג דיג׳רידו' ),
	array( 'href' => home_url( '/eyal-amit' ),             'label' => 'אייל עמית' ),
	array( 'href' => home_url( '/contact' ),               'label' => 'צור קשר' ),
);

/*
 * "מידע ותקנון" — approved footer-only catalog/legal links (NOT in the primary
 * nav). Mirrors block-topnav.php's drawer foot links.
 */
$ea_cfoot_info = array(
	array( 'href' => home_url( '/faq' ),           'label' => 'שאלות נפוצות' ),
	array( 'href' => home_url( '/galleries' ),     'label' => 'גלריות' ),
	array( 'href' => home_url( '/media' ),         'label' => 'המלצות' ),
	array( 'href' => home_url( '/privacy' ),       'label' => 'מדיניות פרטיות' ),
	array( 'href' => home_url( '/accessibility' ), 'label' => 'הצהרת נגישות' ),
	array( 'href' => home_url( '/terms' ),         'label' => 'תקנון' ),
);
?>
<section data-block="footer-social">
    <footer class="ea-footer" aria-label="פוטר האתר"<?php echo 'ltr' === $ea_nav_dir ? ' dir="ltr"' : ''; ?>>
      <div class="ea-footer__inner">
        <div class="ea-cfoot">

          <!-- brand + tagline + location -->
          <div class="ea-cfoot__brandcol">
            <p class="ea-cfoot__brand">אייל עמית</p>
            <p class="ea-cfoot__tag">המרכז לטיפול בנשימה באמצעות דיג׳רידו · סטודיו נשימה מעגלית</p>
            <p class="ea-cfoot__loc">פרדס חנה · ישראל</p>
          </div>

          <!-- ניווט — primary menu -->
          <nav class="ea-cfoot__col" aria-label="ניווט">
            <p class="ea-cfoot__head">ניווט</p>
            <ul class="ea-cfoot__list" role="list">
              <?php foreach ( $ea_cfoot_nav as $ea_fn ) : ?>
              <li><a href="<?php echo esc_url( $ea_fn['href'] ); ?>"><?php echo esc_html( $ea_fn['label'] ); ?></a></li>
              <?php endforeach; ?>
            </ul>
          </nav>

          <!-- מידע ותקנון — footer-only catalog/legal -->
          <nav class="ea-cfoot__col" aria-label="מידע ותקנון">
            <p class="ea-cfoot__head">מידע ותקנון</p>
            <ul class="ea-cfoot__list" role="list">
              <?php foreach ( $ea_cfoot_info as $ea_fi ) : ?>
              <li><a href="<?php echo esc_url( $ea_fi['href'] ); ?>"><?php echo esc_html( $ea_fi['label'] ); ?></a></li>
              <?php endforeach; ?>
            </ul>
          </nav>

          <!-- עקבו — real social channels (4: TikTok added 2026-05-27 per Eyal) -->
          <div class="ea-cfoot__col">
            <p class="ea-cfoot__head">עקבו</p>
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
              <!-- TikTok — added 2026-05-27 per Eyal -->
              <a class="ea-footer__social-link"
                 href="https://www.tiktok.com/@didgeridoo_therapy?_r=1&amp;_t=ZS-96hl39iCAIG"
                 target="_blank"
                 rel="noopener noreferrer"
                 aria-label="טיקטוק של אייל עמית (נפתח בחלון חדש)"
                 role="listitem">
                <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="18" height="18">
                  <path fill="currentColor" d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5.8 20.1a6.34 6.34 0 0 0 10.86-4.43V8.78a8.16 8.16 0 0 0 4.77 1.52V6.85a4.85 4.85 0 0 1-1.84-.16z"/>
                </svg>
              </a>
            </div>
          </div>

        </div><!-- /.ea-cfoot -->

        <hr class="ea-cfoot__divider" aria-hidden="true">
        <p class="ea-cfoot__copy">
          &copy; 2026 אייל עמית — המרכז לטיפול בנשימה באמצעות דיג׳רידו. כל הזכויות שמורות.
        </p>
      </div>
    </footer>
  </section><!-- /footer-social -->
