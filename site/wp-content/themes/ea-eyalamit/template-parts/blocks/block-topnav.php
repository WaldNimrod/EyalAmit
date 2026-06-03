<?php
/**
 * Block: topnav — D-14/POC Wave2.
 *
 * Generic / data-driven (WP-W2-10-A Phase 0b; menu rebuilt to approved
 * site-tree SSoT — team_10 post-closure remediation 2026-06-03).
 *
 * Context (optional):
 *   ea_topnav_active : string  — route key of the active nav item; one of the
 *                                $ea_topnav_items keys (top-level or submenu),
 *                                e.g. 'home','treatment','method','lessons',
 *                                'sound-healing','learning','therapist-training',
 *                                'courses-external','lectures','workshops',
 *                                'tools-and-accessories','instruments','repair',
 *                                'muzza','blog','eyal-amit','mokesh-dahiman',
 *                                'contact'. Default 'home' (original behavior).
 *                                When a submenu key is active, its parent group
 *                                is also flagged (aria-current on the child,
 *                                open/active state on the parent).
 *   ea_nav_dir       : string  — 'rtl' (default) | 'ltr'. LTR hint for a future
 *                                EN caller; emits dir="ltr" on the <nav>.
 *
 * Backward compatible: with no context set, 'home' is active and dir is rtl.
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

/*
 * Approved primary menu (SSoT: hub/data/site-tree.json, Eyal 2026-04-06;
 * locked in _COMMUNICATION/team_10/M2-MENU-PRIMARY-LOCKED-FROM-SITE-TREE-2026-03-29.md).
 * Each top-level item: 'href','label', optional 'children' (submenu) and
 * 'external' (true => link as-is, opens in new tab).
 * The logo/brand IS "home" (position 1, no text label) and is rendered
 * separately as .ea-topnav__brand — it is intentionally NOT in this list.
 */
$ea_topnav_items = array(
	'treatment'             => array(
		'href'  => home_url( '/treatment' ),
		'label' => 'טיפול בדיג׳רידו',
	),
	'method'                => array(
		'href'  => home_url( '/method' ),
		'label' => 'השיטה',
	),
	'lessons'               => array(
		'href'  => home_url( '/lessons' ),
		'label' => 'שיעורי דיג׳רידו',
	),
	'sound-healing'         => array(
		'href'  => home_url( '/sound-healing' ),
		'label' => 'סאונד הילינג',
	),
	'learning'              => array(
		'href'     => home_url( '/learning' ),
		'label'    => 'לימוד והכשרה',
		'children' => array(
			'therapist-training' => array(
				'href'  => home_url( '/therapist-training' ),
				'label' => 'הכשרות למטפלים',
			),
			'courses-external'   => array(
				/*
				 * External courses URL (Scholar/חיצוני) — PENDING canonical URL
				 * from team_00/Eyal. Placeholder '#' kept until supplied so the
				 * item is visible without emitting a silent 404 to a WP route.
				 * external courses URL — pending team_00/Eyal
				 */
				'href'     => '#',
				'label'    => 'קורסים (חיצוני)',
				'external' => true,
			),
			'lectures'           => array(
				'href'  => home_url( '/lectures' ),
				'label' => 'הרצאות',
			),
			'workshops'          => array(
				'href'  => home_url( '/workshops' ),
				'label' => 'סדנאות',
			),
		),
	),
	'tools-and-accessories' => array(
		'href'     => home_url( '/tools-and-accessories' ),
		'label'    => 'כלים ואביזרים',
		'children' => array(
			'instruments' => array(
				'href'  => home_url( '/instruments' ),
				'label' => 'כלים בעבודת יד ואביזרים',
			),
			'repair'      => array(
				'href'  => home_url( '/repair' ),
				'label' => 'תיקון וחידוש כלים',
			),
		),
	),
	'muzza'                 => array(
		'href'  => home_url( '/muzza' ),
		'label' => 'מוזה הוצאה לאור',
	),
	'blog'                  => array(
		'href'  => home_url( '/blog' ),
		'label' => 'בלוג דיג׳רידו',
	),
	'eyal-amit'             => array(
		'href'     => home_url( '/eyal-amit' ),
		'label'    => 'אייל עמית',
		'children' => array(
			'mokesh-dahiman' => array(
				'href'  => home_url( '/mokesh-dahiman' ),
				'label' => 'מוקש דהימן — לזכרו',
			),
		),
	),
	'contact'               => array(
		'href'  => home_url( '/contact' ),
		'label' => 'צור קשר',
	),
);

/**
 * True when $key (or any of its $children keys) is the active route.
 *
 * @param string $key   Top-level route key.
 * @param array  $item  Item definition (may contain 'children').
 * @param string $active Currently active route key.
 * @return bool
 */
$ea_nav_is_active = static function ( $key, $item, $active ) {
	if ( $key === $active ) {
		return true;
	}
	if ( ! empty( $item['children'] ) && isset( $item['children'][ $active ] ) ) {
		return true;
	}
	return false;
};
?>
<header data-block="topnav">
    <nav class="ea-topnav" aria-label="ניווט ראשי"<?php echo 'ltr' === $ea_nav_dir ? ' dir="ltr"' : ''; ?>>
      <a class="ea-topnav__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="אייל עמית — דף הבית">
        אייל עמית
      </a>
      <ul class="ea-topnav__links" role="list">
        <?php foreach ( $ea_topnav_items as $ea_nav_key => $ea_nav_item ) : ?>
          <?php
          $ea_active   = $ea_nav_is_active( $ea_nav_key, $ea_nav_item, $ea_topnav_active );
          $ea_children = isset( $ea_nav_item['children'] ) ? $ea_nav_item['children'] : array();
          ?>
          <?php if ( $ea_children ) : ?>
        <li class="ea-topnav__item ea-topnav__item--has-submenu<?php echo $ea_active ? ' is-active' : ''; ?>">
          <button class="ea-topnav__link ea-topnav__dropdown-toggle"
                  type="button"
                  aria-haspopup="true"
                  aria-expanded="false"<?php echo $ea_active ? ' aria-current="page"' : ''; ?>>
            <?php echo esc_html( $ea_nav_item['label'] ); ?>
            <span class="ea-topnav__caret" aria-hidden="true">▾</span>
          </button>
          <ul class="ea-topnav__submenu" role="list">
            <?php foreach ( $ea_children as $ea_sub_key => $ea_sub_item ) : ?>
              <?php $ea_sub_active = ( $ea_sub_key === $ea_topnav_active ); ?>
            <li class="ea-topnav__subitem">
              <a class="ea-topnav__sublink"
                 href="<?php echo esc_url( $ea_sub_item['href'] ); ?>"<?php
                  echo $ea_sub_active ? ' aria-current="page"' : '';
                  echo ! empty( $ea_sub_item['external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
                  ?>><?php echo esc_html( $ea_sub_item['label'] ); ?></a>
            </li>
            <?php endforeach; ?>
          </ul>
        </li>
          <?php else : ?>
        <li class="ea-topnav__item">
          <a class="ea-topnav__link"
             href="<?php echo esc_url( $ea_nav_item['href'] ); ?>"<?php echo $ea_active ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $ea_nav_item['label'] ); ?></a>
        </li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
      <div class="ea-topnav__controls">
        <!-- EN language pill — switches to the English landing (its own EN nav) -->
        <a class="ea-topnav__lang"
           href="<?php echo esc_url( home_url( '/en' ) ); ?>"
           lang="en"
           aria-label="English">EN</a>
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
