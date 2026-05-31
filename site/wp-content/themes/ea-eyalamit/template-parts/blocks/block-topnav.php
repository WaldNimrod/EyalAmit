<?php
/** Block: topnav — D-14/POC Wave2 */
defined( 'ABSPATH' ) || exit;
?>
<header data-block="topnav">
    <nav class="ea-topnav" aria-label="ניווט ראשי">
      <a class="ea-topnav__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="אייל עמית — דף הבית">
        אייל עמית
      </a>
      <ul class="ea-topnav__links" role="list">
        <li><a class="ea-topnav__link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-current="page">בית</a></li>
        <li><a class="ea-topnav__link" href="<?php echo esc_url( home_url( '/method' ) ); ?>">השיטה</a></li>
        <li><a class="ea-topnav__link" href="<?php echo esc_url( home_url( '/treatment' ) ); ?>">טיפול</a></li>
        <li><a class="ea-topnav__link" href="<?php echo esc_url( home_url( '/sound-healing' ) ); ?>">סאונד הילינג</a></li>
        <li><a class="ea-topnav__link" href="<?php echo esc_url( home_url( '/lessons' ) ); ?>">שיעורים</a></li>
        <li><a class="ea-topnav__link" href="<?php echo esc_url( home_url( '/books' ) ); ?>">ספרים</a></li>
        <li><a class="ea-topnav__link" href="<?php echo esc_url( home_url( '/faq' ) ); ?>">שאלות נפוצות</a></li>
        <li><a class="ea-topnav__link" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">צור קשר</a></li>
      </ul>
      <div class="ea-topnav__controls">
        <!-- atom-interaction-sound-toggle -->
        <button class="ea-sound-toggle"
                type="button"
                aria-label="שמע — הפעל צליל דיג'רידו"
                aria-pressed="false"
                data-on="false">
          <span class="ea-sound-toggle__ico ea-sound-toggle__ico--off" aria-hidden="true">♪</span>
          <span class="ea-sound-toggle__label">שמע</span>
          <?php
          /**
           * Sound-toggle audio source — emitted only when the asset is
           * actually present in the theme media dir, and built from a
           * theme-relative URI (not site-absolute). Avoids a live 404
           * reference until Eyal supplies the canonical didgeridoo file.
           * ea-hero.js already no-ops gracefully when this <audio> is absent.
           */
          $ea_audio_rel  = '/assets/audio/didgeridoo-ambient.mp3';
          $ea_audio_path = get_stylesheet_directory() . $ea_audio_rel;
          if ( is_readable( $ea_audio_path ) ) :
          ?>
          <audio class="ea-sound-toggle__audio" preload="none"
                 src="<?php echo esc_url( get_stylesheet_directory_uri() . $ea_audio_rel ); ?>"></audio>
          <?php endif; ?>
        </button>
        <button class="ea-topnav__burger"
                type="button"
                aria-label="פתח תפריט"
                aria-expanded="false">
          ☰
        </button>
      </div>
    </nav>
  </header>
