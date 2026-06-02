<?php
/**
 * Block: topnav — D-14/POC Wave2.
 *
 * Generic / data-driven (WP-W2-10-A Phase 0b).
 *
 * Context (optional):
 *   ea_topnav_active : string  — route key of the active nav item; one of the
 *                                $ea_topnav_items keys ('home','method','treatment',
 *                                'sound-healing','lessons','books','faq','contact').
 *                                Default 'home' (original behavior).
 *   ea_nav_dir       : string  — 'rtl' (default) | 'ltr'. LTR hint for a future
 *                                EN caller; emits dir="ltr" on the <nav>.
 *
 * Backward compatible: with no context set, 'home' is active and dir is rtl,
 * matching the original hardcoded markup.
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_topnav_active = (string) get_query_var( 'ea_topnav_active' );
if ( '' === $ea_topnav_active ) {
	$ea_topnav_active = 'home';
}

$ea_nav_dir = (string) get_query_var( 'ea_nav_dir' );
if ( 'ltr' !== $ea_nav_dir ) {
	$ea_nav_dir = 'rtl';
}

$ea_topnav_items = array(
	'home'          => array( 'href' => home_url( '/' ),               'label' => 'בית' ),
	'method'        => array( 'href' => home_url( '/method' ),         'label' => 'השיטה' ),
	'treatment'     => array( 'href' => home_url( '/treatment' ),      'label' => 'טיפול' ),
	'sound-healing' => array( 'href' => home_url( '/sound-healing' ),  'label' => 'סאונד הילינג' ),
	'lessons'       => array( 'href' => home_url( '/lessons' ),        'label' => 'שיעורים' ),
	'books'         => array( 'href' => home_url( '/books' ),          'label' => 'ספרים' ),
	'faq'           => array( 'href' => home_url( '/faq' ),            'label' => 'שאלות נפוצות' ),
	'contact'       => array( 'href' => home_url( '/contact' ),        'label' => 'צור קשר' ),
);
?>
<header data-block="topnav">
    <nav class="ea-topnav" aria-label="ניווט ראשי"<?php echo 'ltr' === $ea_nav_dir ? ' dir="ltr"' : ''; ?>>
      <a class="ea-topnav__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="אייל עמית — דף הבית">
        אייל עמית
      </a>
      <ul class="ea-topnav__links" role="list">
        <?php foreach ( $ea_topnav_items as $ea_nav_key => $ea_nav_item ) : ?>
        <li><a class="ea-topnav__link" href="<?php echo esc_url( $ea_nav_item['href'] ); ?>"<?php echo ( $ea_nav_key === $ea_topnav_active ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $ea_nav_item['label'] ); ?></a></li>
        <?php endforeach; ?>
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
