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
 * Pages whose ENTIRE nav chrome is GeneratePress's own header — no separate
 * template-rendered bar of their own. Originally the six GeneratePress
 * orphans (gaining a working mobile menu, and via the canonical list, reach
 * to /shop/, /snoring-sleep-apnea/ and EN that their old WP-menu-driven
 * header never had). S007 M-13 (2026-09-20) adds 'about' and 'press':
 * tpl-content.php used to render its own separate .ea-mnav-burger there,
 * which is now removed (see page-templates/tpl-content.php) because it was
 * a second navigation next to GeneratePress's — so those two pages need
 * this same standalone trigger now, same as the six originals. Name kept
 * (not renamed to something like "gp-header-only") to limit this change's
 * surface area; the six-orphan framing it implies is narrower than what the
 * function now covers.
 */
function ea_nav_drawer_orphan_slugs() {
	return array( 'services', 'shows-heritage', 'historical-articles', 'thank-you', 'courses-soon', 'courses-external', 'about', 'press' );
}

/**
 * Every page with no burger of its own today: the six GeneratePress orphans,
 * plus /en/ — a self-contained LTR landing (tpl-chapters-en.php) that never
 * includes section-nav.php and has no mobile trigger either. The mandate
 * names /en/ explicitly for this reason ("today has no burger at all").
 */
function ea_nav_drawer_no_burger_pages() {
	return array_merge( ea_nav_drawer_orphan_slugs(), array( 'en' ) );
}

/**
 * Marks the six GeneratePress orphan pages so ea-nav-drawer.css can hide
 * their real .menu-toggle — found live, not assumed: a first version placed
 * the standalone burger next to GP's toggle instead of replacing it, which
 * leaves two triggers opening two different menus on the same page. «מגירה
 * אחת לכל האתר» means one way in, not a second button beside the old one.
 * No page-slug-* body class exists to hook without this (confirmed against
 * live markup — GeneratePress only emits page-id-N here), so this adds one.
 */
function ea_nav_drawer_orphan_body_class( $classes ) {
	if ( is_page( ea_nav_drawer_orphan_slugs() ) ) {
		$classes[] = 'ea-nd-orphan';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_nav_drawer_orphan_body_class' );

/**
 * S007 M-13: the nav tree itself moved to inc/ea-canonical-nav.php
 * (ea_canonical_nav_items()) — it is no longer this drawer's own copy, it is
 * THE single source every renderer reads (Chapters, Wave2, GeneratePress's
 * header, and this drawer). Kept as a thin alias so nothing else in this
 * file has to change.
 *
 * @return array
 */
function ea_nav_drawer_items() {
	return ea_canonical_nav_items();
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
			'show_sound' => ! is_page( ea_nav_drawer_no_burger_pages() ),
		)
	);
}
add_action( 'wp_footer', 'ea_nav_drawer_render', 15 );

/**
 * A standalone burger for every page that has no burger of its own today
 * (the six GeneratePress orphans — whose real .menu-toggle already exists in
 * their own masthead, so this is Phase A's minimum viable trigger, not a
 * redesign of that masthead, which is Phase B — plus /en/). Chapters and
 * Wave2 pages already have a real burger of their own; not touched here.
 */
function ea_nav_drawer_render_standalone_burger() {
	if ( ! is_page( ea_nav_drawer_no_burger_pages() ) ) {
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
