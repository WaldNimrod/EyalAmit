<?php
/**
 * S007 M-12 — the ONE mobile navigation drawer, every page.
 *
 * Replaces three independent mobile menus (Chapters .nav__burger, Wave2
 * .ea-mnav-*, GeneratePress .menu-toggle on six parent-theme pages) with one
 * native <dialog>, per _COMMUNICATION/team_00/DECISION-S007-MOBILE-NAV-MECHANISM-2026-09-19.md
 * and _COMMUNICATION/team_10/MANDATE-S007-M12-ONE-MOBILE-DRAWER-2026-09-20.md.
 *
 * Content is the live Chapters nav (template-parts/chapters/section-nav.php),
 * not the June package's mockup list — team_100 diffed both against live REST
 * data and confirmed the Chapters list is the richer, current, reviewed one.
 * One item is deliberately dropped: "קורסים" (an external-course link still
 * pending a URL from Eyal) resolves to href="#" on the live desktop nav today
 * — already logged as P2-A1 in the accessibility open package. A drawer that
 * reaches every page must not carry a control that goes nowhere onto pages
 * that never had it before.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * The six pages that render on GeneratePress's own page.php today and gain
 * a working mobile menu — and, by using the Chapters list, also gain reach
 * to /shop/ and /snoring-sleep-apnea/ and the EN toggle, none of which their
 * current (WordPress-menu-driven) header nav can reach. That is a real,
 * visible change in what those pages offer, not only a styling one.
 */
function ea_nav_drawer_orphan_slugs() {
	return array( 'services', 'shows-heritage', 'historical-articles', 'thank-you', 'courses-soon', 'courses-external' );
}

/**
 * The shared nav tree. A third, independently-maintained copy of the site
 * tree — Chapters (section-nav.php) and Wave2 (block-topnav.php) already
 * each keep their own; unifying those is a separate, content-level decision
 * for team_00, not this mandate.
 *
 * @return array
 */
function ea_nav_drawer_items() {
	$h = static function ( $path ) {
		return esc_url( home_url( $path ) );
	};
	return array(
		array( 'key' => 'home', 'label' => 'בית', 'href' => $h( '/' ) ),
		array(
			'key'      => 'treatment',
			'label'    => 'טיפול בדיג׳רידו',
			'href'     => $h( '/treatment/' ),
			'children' => array(
				array( 'key' => 'snoring-sleep-apnea', 'label' => 'נחירות ודום נשימה בשינה', 'href' => $h( '/snoring-sleep-apnea/' ) ),
			),
		),
		array( 'key' => 'method', 'label' => 'השיטה', 'href' => $h( '/method/' ) ),
		array( 'key' => 'lessons', 'label' => 'שיעורי דיג׳רידו', 'href' => $h( '/lessons/' ) ),
		array( 'key' => 'sound-healing', 'label' => 'סאונד הילינג', 'href' => $h( '/sound-healing/' ) ),
		array(
			'key'      => 'learning',
			'label'    => 'לימוד והכשרה',
			'href'     => null,
			'children' => array(
				array( 'key' => 'therapist-training', 'label' => 'הכשרות למטפלים', 'href' => $h( '/learning/therapist-training/' ) ),
				/* "קורסים" (external course link) intentionally omitted — see file docblock. */
				array( 'key' => 'lectures', 'label' => 'הרצאות', 'href' => $h( '/learning/lectures/' ) ),
				array( 'key' => 'workshops', 'label' => 'סדנאות', 'href' => $h( '/learning/workshops/' ) ),
			),
		),
		array(
			'key'      => 'shop',
			'label'    => 'כלים ואביזרים',
			'href'     => $h( '/shop/' ),
			'children' => array(
				array( 'key' => 'repair', 'label' => 'תיקון וחידוש כלים', 'href' => $h( '/repair/' ) ),
				array( 'key' => 'didgeridoos', 'label' => 'כלי דיג׳רידו למכירה', 'href' => $h( '/didgeridoos/' ) ),
				array( 'key' => 'bags', 'label' => 'תיקים לדיג׳רידו', 'href' => $h( '/bags/' ) ),
				array( 'key' => 'stands-storage', 'label' => 'סטנדים לאחסון דיג׳רידו', 'href' => $h( '/stands-storage/' ) ),
				array( 'key' => 'stand-floor', 'label' => 'סטנד רצפתי לנגינה', 'href' => $h( '/stand-floor/' ) ),
			),
		),
		array(
			'key'      => 'books',
			'label'    => 'ספרים',
			'href'     => $h( '/books/' ),
			'children' => array(
				array( 'key' => 'books-bundle', 'label' => 'מבצעים', 'href' => $h( '/books/#books-bundle' ) ),
				array( 'key' => 'tsva-bekahol', 'label' => 'צבע בכחול וזרוק לים', 'href' => $h( '/books/tsva-bekahol/' ) ),
				array( 'key' => 'kushi-blantis', 'label' => 'כושי בלאנטיס', 'href' => $h( '/books/kushi-blantis/' ) ),
				array( 'key' => 'vekatavta', 'label' => 'וכתבת', 'href' => $h( '/books/vekatavta/' ) ),
			),
		),
		array( 'key' => 'blog', 'label' => 'בלוג דיג׳רידו', 'href' => $h( '/blog/' ) ),
		array(
			'key'      => 'eyal-amit',
			'label'    => 'אייל עמית',
			'href'     => null,
			'children' => array(
				array( 'key' => 'about', 'label' => 'אודות אייל', 'href' => $h( '/eyal-amit/' ) ),
				array( 'key' => 'mokesh-dahiman', 'label' => 'מוקש דהימן — לזכרו', 'href' => $h( '/eyal-amit/mokesh-dahiman/' ) ),
			),
		),
		array( 'key' => 'contact', 'label' => 'צור קשר', 'href' => $h( '/contact/' ) ),
	);
}

/** Secondary footer links — identical set to block-topnav.php's $ea_mnav_foot_links (team_00-approved 2026-08-17). */
function ea_nav_drawer_foot_links() {
	return array(
		array( 'href' => home_url( '/faq' ), 'label' => 'שאלות נפוצות' ),
		array( 'href' => home_url( '/galleries' ), 'label' => 'גלריות' ),
		array( 'href' => home_url( '/testimonials' ), 'label' => 'המלצות' ),
		array( 'href' => home_url( '/privacy' ), 'label' => 'מדיניות פרטיות' ),
		array( 'href' => home_url( '/accessibility' ), 'label' => 'הצהרת נגישות' ),
		array( 'href' => home_url( '/terms' ), 'label' => 'תקנון' ),
	);
}

/**
 * Render the shared <dialog> once per page, in the footer — reachable from
 * every template that calls wp_footer(), which every template in this theme
 * does (Chapters templates keep their own wp_head/wp_footer; Wave2 and the
 * six orphan pages get it from get_footer()).
 */
function ea_nav_drawer_render() {
	get_template_part(
		'template-parts/nav/nav-drawer',
		null,
		array(
			'items'      => ea_nav_drawer_items(),
			'foot_links' => ea_nav_drawer_foot_links(),
			'show_sound' => ! is_page( ea_nav_drawer_orphan_slugs() ),
		)
	);
}
add_action( 'wp_footer', 'ea_nav_drawer_render', 15 );

/**
 * A standalone burger for the six pages that have no burger of their own
 * today (GeneratePress's real .menu-toggle already exists in their own
 * masthead; this is Phase A's minimum viable trigger, not a redesign of
 * that masthead — that visual unification is Phase B).
 */
function ea_nav_drawer_render_standalone_burger() {
	if ( ! is_page( ea_nav_drawer_orphan_slugs() ) ) {
		return;
	}
	?>
	<button type="button" class="ea-nd-burger ea-nd-burger--standalone" data-ea-nav-trigger aria-label="<?php esc_attr_e( 'תפריט', 'ea-eyalamit' ); ?>">
		<span class="ea-nd-burger__bars" aria-hidden="true"><span></span><span></span><span></span></span>
	</button>
	<?php
}
add_action( 'wp_footer', 'ea_nav_drawer_render_standalone_burger', 14 );

/**
 * Enqueue on the SAME unconditional hook/priority already proven to reach
 * the six orphan pages (ea_eyalamit_enqueue_type_tokens_everywhere, this
 * file's sibling in functions.php) — they load neither ea-atoms.css nor
 * chapters.css, so anything styling this drawer for them has to be enqueued
 * here, not assumed to already be on the page.
 */
function ea_nav_drawer_enqueue_assets() {
	if ( is_admin() ) {
		return;
	}
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'ea-nav-drawer', get_stylesheet_directory_uri() . '/assets/css/ea-nav-drawer.css', array( 'ea-wave2-tokens' ), $ver );
	wp_enqueue_script( 'ea-nav-drawer', get_stylesheet_directory_uri() . '/assets/js/ea-nav-drawer.js', array(), $ver, true );
}
add_action( 'wp_enqueue_scripts', 'ea_nav_drawer_enqueue_assets', 3 );
