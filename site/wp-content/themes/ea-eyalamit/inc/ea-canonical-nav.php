<?php
/**
 * S007 M-13 — the ONE navigation, every published URL, desktop and mobile.
 *
 * Per _COMMUNICATION/team_00/DECIDE-S007-TWO-NAVIGATIONS-2026-09-20.md and
 * _COMMUNICATION/team_10/MANDATE-S007-M13-ONE-NAVIGATION-2026-09-20.md:
 * there were three independently-maintained copies of the site tree
 * (section-nav.php, block-topnav.php, and M-12's own ea_nav_drawer_items())
 * and they had already drifted. This file is the single data source all of
 * them now read. A renderer may differ in markup and styling; it may not
 * differ in items, labels or targets — those are Eyal's words, not ours to
 * regularise (the earlier "{label} — עמוד ראשי" pattern in M-12's own drawer
 * was exactly that kind of silent regularisation, and is fixed here to
 * match section-nav.php byte-for-byte instead).
 *
 * "קורסים" now points at /learning/courses-external/ («יעלה בקרוב»).
 * Nimrod 2026-09-21: scoped exception to the main-nav hold — add this child
 * only; do not restructure L1. The old href="#" omission (P2-A1) is closed.
 *
 * "home" IS in this list (the mobile drawer renders it as an explicit row),
 * but a desktop-style renderer with its own logo/brand-as-home link (every
 * renderer in this theme has one) should skip rendering it a second time as
 * a text item — per team_100: the item is present via the logo, only the
 * affordance differs, and that is markup, which renderers are free to vary.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * The canonical nav tree. Labels are Hebrew — that is the canonical
 * language today; a future per-locale override (e.g. for /en/, still
 * pending team_00/Eyal) is a filter on this return value, not a second
 * copy of the tree.
 *
 * @return array[] List of array('key','label','href'(nullable),'children'=>array(array('key','label','href','external'=>bool))).
 */
function ea_canonical_nav_items() {
	$h = static function ( $path ) {
		return esc_url( home_url( $path ) );
	};
	$items = array(
		array( 'key' => 'home', 'label' => 'בית', 'href' => $h( '/' ) ),
		array(
			'key'      => 'treatment',
			'label'    => 'טיפול בדיג׳רידו',
			'href'     => $h( '/treatment/' ),
			'children' => array(
				array( 'key' => 'treatment', 'label' => 'טיפול בדיג׳רידו', 'href' => $h( '/treatment/' ) ),
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
				array( 'key' => 'courses-external', 'label' => 'קורסים', 'href' => $h( '/learning/courses-external/' ) ),
				array( 'key' => 'lectures', 'label' => 'הרצאות', 'href' => $h( '/learning/lectures/' ) ),
				array( 'key' => 'workshops', 'label' => 'סדנאות', 'href' => $h( '/learning/workshops/' ) ),
			),
		),
		array(
			'key'      => 'shop',
			'label'    => 'כלים ואביזרים',
			'href'     => $h( '/shop/' ),
			'children' => array(
				/* section-nav.php's own first sub-row here is NOT "כלים ואביזרים —
				   עמוד ראשי" — it is this distinct, more specific label. Byte-exact. */
				array( 'key' => 'shop', 'label' => 'כלים בעבודת יד ואביזרים', 'href' => $h( '/shop/' ) ),
				array( 'key' => 'repair', 'label' => 'תיקון וחידוש כלי דיג׳רידו', 'href' => $h( '/repair/' ) ),
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
			/* No overview row here — section-nav.php goes straight to "מבצעים".
			   Not every parent-with-href gets a self-referencing first child;
			   copying the shop/treatment pattern here would be an invention. */
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

	/**
	 * Filter the canonical nav tree — the extension point for a future
	 * per-locale label override (e.g. /en/), so that need never grows a
	 * second hand-maintained copy of this tree.
	 *
	 * @param array[] $items Canonical nav items, see ea_canonical_nav_items().
	 */
	return apply_filters( 'ea_canonical_nav_items', $items );
}

/**
 * GeneratePress's own header calls wp_nav_menu(theme_location=primary) —
 * that is the single mechanism behind every URL that was rendering a
 * different, drifted, WordPress-menu-editable item set (measured:
 * historical-articles, learning/courses-external, press, services,
 * shows-heritage, thank-you, about, plus the ea_faq/ea_gallery/
 * ea_testimonial singles). Chapters templates never call get_header() at
 * all (self-contained documents), so they never reach GeneratePress's menu
 * and are unaffected by this filter — that is also why this alone cannot
 * touch them; section-nav.php reads the same source separately.
 *
 * Replaces the menu's rendered <li> markup outright rather than trying to
 * reconcile it with whatever is actually assigned to the 'primary' location
 * in the database — the ruling is that every page shows the canonical set,
 * not that the editable menu becomes the source of truth.
 */
function ea_canonical_nav_gp_header_items( $items, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $items;
	}
	$html = '';
	foreach ( ea_canonical_nav_items() as $item ) {
		if ( 'home' === $item['key'] ) {
			continue; // GeneratePress's own header already shows the site logo/title as home.
		}
		$children = isset( $item['children'] ) ? $item['children'] : array();
		if ( $children ) {
			$html .= '<li class="menu-item menu-item-has-children">';
			if ( $item['href'] ) {
				$html .= sprintf( '<a href="%s">%s</a>', esc_url( $item['href'] ), esc_html( $item['label'] ) );
			} else {
				/*
				 * "לימוד והכשרה" / "אייל עמית": permanent category labels with no
				 * overview page of their own (section-nav.php renders these as a
				 * <button>, not a link, for the same reason) — not the same thing
				 * as a dead href="#". «קורסים» now has a real destination.
				 *
				 * First version of this used href="#" to match GP's dropdown-hover
				 * CSS, which only reacts to :hover — measured live afterward:
				 * focusing that link does not reveal its submenu at all, and a
				 * real Tab walk confirms the submenu's own items (e.g. "הכשרות
				 * למטפלים") are unreachable by keyboard entirely. A real Enter
				 * keypress on href="#" also moves focus away to the top of the
				 * page instead of opening anything — a focusable control that
				 * does nothing, on every page that reaches GP's header. Same
				 * class of defect as "קורסים", found instead of assumed safe.
				 *
				 * Fixed with a real <button> (native Enter/Space activation, no
				 * hand-rolled key handling needed) wired by
				 * assets/js/ea-canonical-nav-gp-dropdown.js, which toggles
				 * aria-expanded and sets the submenu's own inline display style
				 * directly — high enough specificity to win regardless of GP's
				 * own (unread, unvendored) hover CSS, and cleared back to '' on
				 * close so GP's own hover behaviour resumes control for mouse
				 * users. ea-canonical-nav-gp-dropdown.css gives the button the
				 * same inherited font/color a sibling <a> would have, since a
				 * bare <button> does not inherit GP's own link styling.
				 */
				$html .= sprintf( '<button type="button" class="ea-gp-dd-toggle" aria-haspopup="true" aria-expanded="false">%s</button>', esc_html( $item['label'] ) );
			}
			$html .= '<ul class="sub-menu">';
			foreach ( $children as $child ) {
				$html .= sprintf(
					'<li class="menu-item"><a href="%s"%s>%s</a></li>',
					esc_url( $child['href'] ),
					! empty( $child['external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '',
					esc_html( $child['label'] )
				);
			}
			$html .= '</ul></li>';
		} else {
			$html .= sprintf( '<li class="menu-item"><a href="%s">%s</a></li>', esc_url( $item['href'] ), esc_html( $item['label'] ) );
		}
	}
	return $html;
}
add_filter( 'wp_nav_menu_items', 'ea_canonical_nav_gp_header_items', 10, 2 );

/**
 * Keyboard access for the .ea-gp-dd-toggle buttons above. Same unconditional
 * hook/priority as ea_eyalamit_enqueue_type_tokens_everywhere() — harmless
 * (and inert; the JS no-ops if it finds no matching elements) on pages that
 * never reach GeneratePress's header at all.
 */
function ea_canonical_nav_gp_dropdown_assets() {
	if ( is_admin() ) {
		return;
	}
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'ea-canonical-nav-gp-dropdown', get_stylesheet_directory_uri() . '/assets/css/ea-canonical-nav-gp-dropdown.css', array(), $ver );
	wp_enqueue_script( 'ea-canonical-nav-gp-dropdown', get_stylesheet_directory_uri() . '/assets/js/ea-canonical-nav-gp-dropdown.js', array(), $ver, true );
}
add_action( 'wp_enqueue_scripts', 'ea_canonical_nav_gp_dropdown_assets', 3 );
