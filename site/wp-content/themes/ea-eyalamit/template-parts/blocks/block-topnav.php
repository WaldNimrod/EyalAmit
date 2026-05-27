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
                aria-label="הפעל צליל דיג'רידו"
                aria-pressed="false"
                data-on="false">
          <span class="ea-sound-toggle__ico ea-sound-toggle__ico--off" aria-hidden="true">♪</span>
          <span class="ea-sound-toggle__label">שמע</span>
          <audio class="ea-sound-toggle__audio" preload="none"
                 src="/assets/audio/didgeridoo-ambient.mp3"></audio>
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
