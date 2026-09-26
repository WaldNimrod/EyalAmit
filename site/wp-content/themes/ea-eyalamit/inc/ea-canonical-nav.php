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
 * "קורסים" (/learning/courses-external/, «יעלה בקרוב») is not a menu item.
 * Eyal 2026-09-24: the page stays published and stays out of the menu.
 * The «יעלה בקרוב» line on the page itself is unchanged.
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
		/*
		 * S007 M-14 (2026-09-24) — approved nav-tree rebuild, per
		 * _COMMUNICATION/team_90/AUDIT-2026-09-24/MANDATE-TEAM10-NAV-TREE-2026-09-24.md
		 * and its same-day amendment (adds testimonials/faq/galleries under
		 * "אייל עמית"). "home" is removed outright: the logo covers it and the
		 * breadcrumb always shows "בית" as its own first, hardcoded crumb
		 * (see ea_breadcrumb_trail()) — that does not read this array's items.
		 */
		array(
			'key'      => 'eyal-amit',
			'label'    => 'אייל עמית',
			'href'     => $h( '/eyal-amit/' ),
			'children' => array(
				array( 'key' => 'about', 'label' => 'אודות אייל', 'href' => $h( '/eyal-amit/' ) ),
				/* team_00 dictate, 2026-09-24 (post-M14 follow-up): label changed from
				   "מוקש דהימן — לזכרו" to "מוקש דהימן - המורה שלי", plain hyphen as
				   dictated (not the em dash the old label used). "המורה שלי" originally
				   shipped with a synthesized italic slant (Heebo has no italic axis);
				   team_00 round-C follow-up ruled that a mess and, after both weight
				   options were rendered and shown, chose a real thin face over it —
				   font-weight:var(--fw-thin) (100, a genuine cut in the loaded Heebo
				   family, not synthesized), no italic. Set on the <em> in every
				   renderer's own stylesheet (chapters.css / ea-nav-drawer.css /
				   ea-canonical-nav-gp-dropdown.css), never here — this array carries
				   data, not style. The page's own title/H1 is unchanged — menu label
				   only. 'label_emph' is a separate field, not HTML in 'label': every
				   renderer below runs esc_html() on both pieces independently and wraps
				   the emph piece in its own <em>. */
				array( 'key' => 'mokesh-dahiman', 'label' => 'מוקש דהימן -', 'label_emph' => 'המורה שלי', 'href' => $h( '/eyal-amit/mokesh-dahiman/' ) ),
				array( 'key' => 'testimonials', 'label' => 'המלצות', 'href' => $h( '/testimonials/' ) ),
				array( 'key' => 'faq', 'label' => 'שאלות ותשובות', 'href' => $h( '/faq/' ) ),
				array( 'key' => 'galleries', 'label' => 'גלריה', 'href' => $h( '/galleries/' ) ),
				/*
				 * Round C (2026-09-24), team_00 live-meeting dictate: "ספרים" moves out
				 * of level 1 and becomes a child here, after "גלריה" and before "צור
				 * קשר", keeping its own children — which therefore become level 3.
				 * This is the first item in the tree that nests three deep; every
				 * renderer below (desktop dropdown, mobile drawer accordion) walks
				 * 'children' recursively rather than assuming two levels, specifically
				 * so this did not need a hand-coded third markup block anywhere.
				 */
				array(
					'key'      => 'books',
					'label'    => 'ספרים',
					'href'     => $h( '/books/' ),
					'children' => array(
						/* Wave 1 A9 (2026-09-25): the drawer renders a parent as a
						   button with no href, so /books/ was reachable only via the
						   fragment on «מבצעים». This row is the same convention the
						   other four parents already use — the publisher name that
						   already titles this page, pointing at the page itself. */
						array( 'key' => 'books-muzza', 'label' => 'מוזה הוצאה לאור', 'href' => $h( '/books/' ) ),
						array( 'key' => 'books-bundle', 'label' => 'מבצעים', 'href' => $h( '/books/#books-bundle' ) ),
						array( 'key' => 'tsva-bekahol', 'label' => 'צבע בכחול וזרוק לים', 'href' => $h( '/books/tsva-bekahol/' ) ),
						array( 'key' => 'kushi-blantis', 'label' => 'כושי בלאנטיס', 'href' => $h( '/books/kushi-blantis/' ) ),
						array( 'key' => 'vekatavta', 'label' => 'וכתבת', 'href' => $h( '/books/vekatavta/' ) ),
					),
				),
				array( 'key' => 'contact', 'label' => 'צור קשר', 'href' => $h( '/contact/' ) ),
			),
		),
		array(
			'key'      => 'treatments',
			'label'    => 'טיפולים בדיג׳רידו',
			/* team_00 follow-up, 2026-09-24 (post-M14): every level-1 parent now
			   points at its own first child, same rule "אייל עמית" already followed
			   — was null (rendered as a non-navigating <button>), now the first
			   child's own href ('treatment' below), verified live returning 200. */
			'href'     => $h( '/treatment/' ),
			'children' => array(
				array( 'key' => 'treatment', 'label' => 'טיפול נשימה באמצעות דיג׳רידו', 'href' => $h( '/treatment/' ) ),
				array( 'key' => 'sound-healing', 'label' => 'סאונד הילינג', 'href' => $h( '/sound-healing/' ) ),
				array( 'key' => 'snoring-sleep-apnea', 'label' => 'טיפול בנחירות ודום נשימה בשינה', 'href' => $h( '/snoring-sleep-apnea/' ) ),
			),
		),
		array(
			'key'      => 'lessons-training',
			'label'    => 'שיעורים והכשרות',
			/* Same follow-up as 'treatments' above — first child's href, verified
			   live returning 200. */
			'href'     => $h( '/lessons/' ),
			'children' => array(
				array( 'key' => 'lessons', 'label' => 'שיעורי דיג׳רידו פרטיים', 'href' => $h( '/lessons/' ) ),
				array( 'key' => 'therapist-training', 'label' => 'הכשרות למטפלים', 'href' => $h( '/learning/therapist-training/' ) ),
				/* Content not ready — Eyal 2026-09-24: "להשאיר מחוץ לתפריט". Kept in the
				   tree (real page, real href) so it can be restored in one step; every
				   renderer below skips an item flagged 'hidden'. */
				array( 'key' => 'courses-external', 'label' => 'קורסים דיגיטליים', 'href' => $h( '/learning/courses-external/' ), 'hidden' => true ),
				array( 'key' => 'lectures', 'label' => 'הרצאות', 'href' => $h( '/learning/lectures/' ) ),
				array( 'key' => 'workshops', 'label' => 'סדנאות דיג׳רידו', 'href' => $h( '/learning/workshops/' ) ),
			),
		),
		array( 'key' => 'method', 'label' => 'השיטה', 'href' => $h( '/method/' ) ),
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
		array( 'key' => 'blog', 'label' => 'בלוג דיג׳רידו', 'href' => $h( '/blog/' ) ),
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

if ( ! function_exists( 'ea_canonical_nav_home_link' ) ) :
	/**
	 * The explicit visual "home" icon-link, prepended to level 1 in every
	 * desktop/drawer renderer (team_00 addendum to the S007 task-0 mandate,
	 * 2026-09-24). "home" was removed as a text item from this file's own
	 * tree earlier today on the reasoning that the logo click and the
	 * breadcrumb both already carry it; team_00 asked for this icon back as
	 * an explicit route, in addition to those, not a replacement for the
	 * canonical tree — so it is markup only, never added to
	 * ea_canonical_nav_items() itself.
	 *
	 * One shared function so the three renderers that need it (Chapters
	 * desktop nav, the GeneratePress header items filter, and the mobile
	 * drawer) stay byte-identical instead of drifting like the tree itself
	 * once did (see this file's own header comment on that history).
	 *
	 * Monochrome, `currentColor`-filled SVG — same pattern as the footer
	 * social icons (template-parts/blocks/block-footer-social.php): fixed
	 * viewBox/path, `aria-hidden="true" focusable="false"` on the <svg>, the
	 * accessible name lives on the wrapping <a> instead. No font-size or
	 * colour token touched; ea-tokens.css is unchanged.
	 *
	 * @param string $link_class CSS class for the <a> (matches the calling
	 *                           renderer's own link class so it inherits that
	 *                           renderer's existing color/hover/padding rules
	 *                           — no new CSS needed).
	 * @param string $ea_he      Pre-rendered lang/dir attribute string (or '').
	 * @return string HTML for the <a> element (not escaped further by callers —
	 *                fully built here with esc_url()/esc_attr()).
	 */
	function ea_canonical_nav_home_link( $link_class, $ea_he = '' ) {
		return sprintf(
			'<a class="%1$s" href="%2$s"%3$s aria-label="%4$s"><svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 3l8 7h-2v8h-5v-5h-2v5H6v-8H4l8-7z"/></svg></a>',
			esc_attr( $link_class ),
			esc_url( home_url( '/' ) ),
			$ea_he, // phpcs:ignore WordPress.Security.EscapeOutput — static lang/dir attr, same pattern as every other renderer in this file.
			esc_attr__( 'דף הבית', 'ea-eyalamit' )
		);
	}
endif;

if ( ! function_exists( 'ea_render_nav_item_desktop' ) ) :
	/**
	 * Render one Chapters desktop nav item — and, recursively, its own
	 * children — as a `<li>`. Round C (2026-09-24): "ספרים" gained a third
	 * level under "אייל עמית", and the renderer this feeds
	 * (template-parts/chapters/section-nav.php) used to be a single flat
	 * loop with no recursion and no grandchild support. Depth is
	 * data-driven here instead of a hand-written third markup block — this
	 * theme's own recurring defect, per Team 90's audit, is parallel
	 * implementations of one component, and a special case for "ספרים"
	 * alone would have been a fifth instance of it.
	 *
	 * The open/close mechanism is identical at every depth on purpose:
	 * every dropdown opener carries `aria-haspopup="true"` and a
	 * `aria-expanded` that assets/js/ea-chapters.js keeps in sync via
	 * `.nav__dd[aria-haspopup="true"]` — a selector, not a depth check — so
	 * a third level needs no second script. assets/css/chapters.css reveals
	 * `.nav__sub` on hover/focus-within the same way at any depth.
	 *
	 * @param array  $ea_item Nav item: key,label,href,children?,hidden?,label_emph?.
	 * @param string $ea_he   Pre-rendered lang/dir attribute string (or '').
	 * @return void
	 */
	function ea_render_nav_item_desktop( $ea_item, $ea_he ) {
		$ea_children = isset( $ea_item['children'] ) ? $ea_item['children'] : array();
		if ( $ea_children ) {
			echo '<li>';
			if ( $ea_item['href'] ) {
				printf(
					'<a class="nav__dd" href="%s" aria-haspopup="true" aria-expanded="false"%s>%s<span class="nav__caret" aria-hidden="true">▾</span></a>',
					esc_url( $ea_item['href'] ),
					$ea_he, // phpcs:ignore WordPress.Security.EscapeOutput — static lang/dir attr
					esc_html( $ea_item['label'] )
				);
			} else {
				printf(
					'<button class="nav__dd" type="button" aria-haspopup="true" aria-expanded="false"%s>%s<span class="nav__caret" aria-hidden="true">▾</span></button>',
					$ea_he, // phpcs:ignore WordPress.Security.EscapeOutput
					esc_html( $ea_item['label'] )
				);
			}
			echo '<ul class="nav__sub" role="list">';
			foreach ( $ea_children as $ea_child ) {
				if ( ! empty( $ea_child['hidden'] ) ) {
					continue; // S007 M-14: real page, kept in the tree, not rendered (content not ready).
				}
				ea_render_nav_item_desktop( $ea_child, $ea_he );
			}
			echo '</ul></li>';
		} else {
			printf(
				'<li><a href="%s"%s>%s%s</a></li>',
				esc_url( $ea_item['href'] ),
				$ea_he, // phpcs:ignore WordPress.Security.EscapeOutput
				esc_html( $ea_item['label'] ),
				/* 'label_emph': a separate field, run through its own esc_html(), never
				   HTML placed inside 'label' — that would be escaped as literal tag text
				   by the esc_html() call above. */
				! empty( $ea_item['label_emph'] ) ? ' <em>' . esc_html( $ea_item['label_emph'] ) . '</em>' : ''
			);
		}
	}
endif;

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
	/*
	 * team_00 addendum, 2026-09-24: explicit monochrome home icon, first
	 * item, before "אייל עמית" — see ea_canonical_nav_home_link() above. GP
	 * markup here is a raw <li><a> string (not wp_nav_menu <li> objects), so
	 * this prepends a plain <li> around the shared link markup.
	 */
	$html = '<li class="menu-item ea-gp-home">' . ea_canonical_nav_home_link( 'ea-gp-home__link' ) . '</li>';
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
				 * Kept for a future category with no page of its own (this is the
				 * shared reason section-nav.php also has a <button> branch) — not the
				 * same thing as a dead href="#". As of the 2026-09-24 follow-up every
				 * current parent-with-children has an href (the last two, "טיפולים
				 * בדיג׳רידו" and "שיעורים והכשרות", now point at their first child,
				 * same rule "אייל עמית" already followed), so this branch is
				 * presently unreached; left in place rather than deleted.
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
				if ( ! empty( $child['hidden'] ) ) {
					continue; // S007 M-14: real page, kept in the tree, not rendered (content not ready).
				}
				$html .= sprintf(
					'<li class="menu-item"><a href="%s"%s>%s%s</a></li>',
					esc_url( $child['href'] ),
					! empty( $child['external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '',
					esc_html( $child['label'] ),
					/* 'label_emph' (2026-09-24 follow-up): a separate field, run through
					   its own esc_html(), never HTML placed inside 'label' — that would
					   be escaped as literal tag text by this same esc_html() call above. */
					! empty( $child['label_emph'] ) ? ' <em>' . esc_html( $child['label_emph'] ) . '</em>' : ''
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

if ( ! function_exists( 'ea_footer_unified_columns' ) ) :
	/**
	 * Build the footer's column list from ea_canonical_nav_items() — ONE
	 * source, two footer-only presentation overrides on top of it. Neither
	 * override touches the tree array itself (that array also drives the
	 * main desktop menu and the mobile drawer, which team_00 did not ask to
	 * change); both are applied here, to a copy, at render time only.
	 *
	 * Override 1 — team_00 (Nimrod), live dictate 2026-09-26, MANDATE-
	 * FOOTER-UNIFY-2026-09-26.md: «ספרים כעמודה משלה». "ספרים" ("books") is
	 * lifted out of its parent's children (in the tree today that parent is
	 * "אייל עמית" — measured; the mandate text itself says "כלים ואביזרים",
	 * which this file's own tree contradicts, see the DONE report) and
	 * becomes its own top-level footer column, last in column order per
	 * team_00's own enumeration ("...כלים ואביזרים · ספרים").
	 *
	 * Override 2 — team_00, follow-up dictate 2026-09-26: «השיטה ובלוג -
	 * שבלוג יהיה בפוטר ילד של השיטה». "בלוג דיג׳רידו" ("blog") is a
	 * top-level tree item with no children of its own; in the FOOTER ONLY
	 * it is removed from the top-level column row and appended as a child
	 * link under the "השיטה" ("method") column, which otherwise would have
	 * been a single-link column. This is the reason the footer ends at six
	 * columns, not seven, and none of them is a bare single link.
	 *
	 * Every other item, label, href, 'hidden' flag and 'label_emph' passes
	 * through unchanged. No item is dropped; nothing here writes a label or
	 * a URL that is not already in the tree.
	 *
	 * @return array[] Column list — same per-item shape as ea_canonical_nav_items(),
	 *                  each with a flat (non-nested) 'children' array.
	 */
	function ea_footer_unified_columns() {
		$ea_columns   = array();
		$ea_books_col = null;
		$ea_blog_item = null;

		foreach ( ea_canonical_nav_items() as $ea_item ) {
			if ( ! empty( $ea_item['hidden'] ) || 'home' === $ea_item['key'] ) {
				continue;
			}
			if ( 'blog' === $ea_item['key'] ) {
				$ea_blog_item = $ea_item; // Override 2 — held back, appended under "method" below.
				continue;
			}
			$ea_children = isset( $ea_item['children'] ) ? $ea_item['children'] : array();
			if ( $ea_children ) {
				$ea_kept = array();
				foreach ( $ea_children as $ea_child ) {
					if ( 'books' === $ea_child['key'] ) {
						$ea_books_col = $ea_child; // Override 1 — held back, appended as its own column below.
						continue;
					}
					$ea_kept[] = $ea_child;
				}
				$ea_item['children'] = $ea_kept;
			}
			$ea_columns[] = $ea_item;
		}

		if ( $ea_blog_item ) {
			foreach ( $ea_columns as &$ea_col ) {
				if ( 'method' === $ea_col['key'] ) {
					$ea_col['children']   = isset( $ea_col['children'] ) ? $ea_col['children'] : array();
					$ea_col['children'][] = $ea_blog_item;
				}
			}
			unset( $ea_col );
		}

		if ( $ea_books_col ) {
			$ea_columns[] = $ea_books_col; // last column, per team_00's stated order.
		}

		return $ea_columns;
	}
endif;

if ( ! function_exists( 'ea_render_unified_footer_column' ) ) :
	/**
	 * Render one footer column: the heading AND a flat list of its children.
	 *
	 * team_00 (Nimrod), 2026-09-26 follow-up dictate: «הכותרות בפוטר כולן גם
	 * עם קישור עליהן» — every column heading is itself a link, to that
	 * item's own href straight from the tree (never hardcoded, never
	 * substituted). Every current top-level item has a real href (see this
	 * file's own header comment on the 2026-09-24 "every parent points at
	 * its own first child" follow-up), so no heading is ever left bare.
	 *
	 * No third level exists here (unlike the desktop dropdown/drawer):
	 * after ea_footer_unified_columns()'s two overrides, no column's
	 * children have children of their own, so this stays a flat two-level
	 * render — heading link, then a plain list of leaf links.
	 *
	 * @param array $ea_col One column — same shape as an ea_canonical_nav_items() item.
	 * @return void
	 */
	function ea_render_unified_footer_column( $ea_col ) {
		$ea_children = isset( $ea_col['children'] ) ? $ea_col['children'] : array();
		echo '<div class="ea-ftr__col">';
		printf(
			'<a class="ea-ftr__col-title" href="%s">%s%s</a>',
			esc_url( $ea_col['href'] ),
			esc_html( $ea_col['label'] ),
			/* 'label_emph': a separate field, run through its own esc_html(), never
			   HTML placed inside 'label' — same convention as every renderer above. */
			! empty( $ea_col['label_emph'] ) ? ' <em>' . esc_html( $ea_col['label_emph'] ) . '</em>' : ''
		);
		if ( $ea_children ) {
			echo '<ul class="ea-ftr__col-list" role="list">';
			foreach ( $ea_children as $ea_child ) {
				if ( ! empty( $ea_child['hidden'] ) ) {
					continue; // S007 M-14: courses-external — real page, kept in the tree, not rendered.
				}
				printf(
					'<li><a href="%s">%s%s</a></li>',
					esc_url( $ea_child['href'] ),
					esc_html( $ea_child['label'] ),
					! empty( $ea_child['label_emph'] ) ? ' <em>' . esc_html( $ea_child['label_emph'] ) . '</em>' : ''
				);
			}
			echo '</ul>';
		}
		echo '</div>';
	}
endif;

if ( ! function_exists( 'ea_render_unified_footer' ) ) :
	/**
	 * THE footer. One block, rendered once per page, reached from all four
	 * render paths this theme has (Chapters' section-footer.php, Wave2's
	 * block-footer-social.php, tpl-chapters-en.php, and the child
	 * footer.php gateway) — replaces both the old per-path hardcoded footer
	 * columns (which had drifted from the tree in five places — see the
	 * DONE report) AND this morning's separate sitemap row (MANDATE-
	 * FOOTER-SITEMAP-ROW-2026-09-26.md), which duplicated nine of the ten
	 * links in those old columns. Nimrod, 2026-09-26: «השורה השניה זה
	 * כפילות וזה לא טוב... צריך שיכנס רק פעם אחת אחיד בעיצוב יפה».
	 *
	 * Layout, in DOM order (matches his own enumeration order):
	 *   1. the menu, as columns — ea_footer_unified_columns() (the tree,
	 *      with the two footer-only overrides documented on that function).
	 *   2. contact details, in their own block — the existing brand/
	 *      address/phone/social copy, unchanged content, moved here so it
	 *      renders from ONE place instead of four.
	 *   3. the legal strip, LAST, CENTRED, and the only light-toned part of
	 *      the footer — everything above is on the dark ground. Content is
	 *      the existing medical disclaimer + copyright + accessibility/
	 *      privacy links (Chapters' own section-footer.php copy — chosen
	 *      over Wave2's shorter copyright-only line because it is the one
	 *      that already carries both legal links the mandate names).
	 *
	 * Guarded to render at most once per request — the same guard the
	 * sitemap row used, for the same reason: a single page can reach more
	 * than one of the four call sites (e.g. tpl-content.php calls
	 * block-footer-social.php and then get_footer()).
	 *
	 * Styling lives entirely in assets/css/ea-footer-unified.css, enqueued
	 * unconditionally (ea_eyalamit_enqueue_footer_unified_everywhere() in
	 * functions.php) so this ONE footer renders identically regardless of
	 * which of the four paths reaches it — including pages that load none
	 * of this theme's other stylesheets (measured 2026-09-26:
	 * /historical-articles/). Every size/weight/colour in that file is an
	 * existing --fs-*, --fw-*, --ea-ink, --ea-bg or --ea-text-body token
	 * (or an rgba() opacity layered on one of those, same convention the
	 * sitemap row's own CSS used); this adds no new token.
	 *
	 * @param array $ea_args {
	 *     @type bool $reveal Chapters-only sticky-reveal wrapper — adds the
	 *                        `foot uncover` classes and the `.arcs` motif
	 *                        span that assets/css/chapters.css and
	 *                        assets/js/ea-chapters.js (`footer.foot.uncover`)
	 *                        already key off. False on the other three
	 *                        paths, which never loaded that CSS/JS anyway.
	 * }
	 * @return void
	 */
	function ea_render_unified_footer( $ea_args = array() ) {
		static $ea_rendered = false;
		if ( $ea_rendered ) {
			return;
		}
		$ea_rendered = true;

		$ea_args = wp_parse_args( $ea_args, array( 'reveal' => false ) );

		$ea_footer_class = 'ea-ftr';
		if ( $ea_args['reveal'] ) {
			$ea_footer_class .= ' foot uncover';
		}

		/* lang/dir explicit here (not inherited) — the tree is Hebrew-only
		   (see this file's own header comment) but this same function is
		   also called from tpl-chapters-en.php, an English/LTR page, so the
		   Hebrew content needs its own bidi context wherever it lands. */
		echo '<footer class="' . esc_attr( $ea_footer_class ) . '" role="contentinfo" lang="he" dir="rtl">';
		if ( $ea_args['reveal'] ) {
			echo '<span class="arcs" aria-hidden="true"></span>';
		}
		echo '<div class="ea-ftr__in">';

		echo '<nav class="ea-ftr__nav" aria-label="' . esc_attr__( 'ניווט בפוטר', 'ea-eyalamit' ) . '">';
		foreach ( ea_footer_unified_columns() as $ea_col ) {
			ea_render_unified_footer_column( $ea_col );
		}
		echo '</nav>';

		// Contact block — existing copy (template-parts/chapters/section-footer.php), unchanged.
		echo '<div class="ea-ftr__contact">';
		echo '<b class="ea-ftr__contact-name">המרכז לטיפול בנשימה באמצעות דיג׳רידו</b>';
		echo '<p class="ea-ftr__contact-tag">פרדס חנה, ישראל. שיטת cbDIDG, מאז 1999.</p>';
		echo '<p class="ea-ftr__contact-nap">' . esc_html( ea_nap( 'address_display' ) ) . '</p>';
		printf(
			'<p class="ea-ftr__contact-tel"><a href="tel:%s" dir="ltr">%s</a></p>',
			esc_attr( ea_nap( 'phone_href' ) ),
			esc_html( ea_nap( 'phone_display' ) )
		);
		echo '<div class="ea-ftr__soc">';
		printf(
			'<a href="%s" target="_blank" rel="noopener" aria-label="%s"><svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>',
			esc_url( 'https://www.facebook.com/didgeridoo.studio.eyal.amit' ),
			esc_attr__( 'פייסבוק של אייל עמית (נפתח בחלון חדש)', 'ea-eyalamit' )
		);
		printf(
			'<a href="%s" target="_blank" rel="noopener" aria-label="%s"><svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>',
			esc_url( 'https://www.instagram.com/didgeridoo.therapy.center' ),
			esc_attr__( 'אינסטגרם של אייל עמית (נפתח בחלון חדש)', 'ea-eyalamit' )
		);
		printf(
			'<a href="%s" target="_blank" rel="noopener" aria-label="%s"><svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>',
			esc_url( 'https://www.youtube.com/@%D7%90%D7%99%D7%99%D7%9C%D7%A2%D7%9E%D7%99%D7%AA' ),
			esc_attr__( 'יוטיוב של אייל עמית (נפתח בחלון חדש)', 'ea-eyalamit' )
		);
		printf(
			'<a href="%s" target="_blank" rel="noopener" aria-label="%s"><svg aria-hidden="true" focusable="false" viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5.8 20.1a6.34 6.34 0 0 0 10.86-4.43V8.78a8.16 8.16 0 0 0 4.77 1.52V6.85a4.85 4.85 0 0 1-1.84-.16z"/></svg></a>',
			esc_url( 'https://www.tiktok.com/@didgeridoo_therapy' ),
			esc_attr__( 'טיקטוק של אייל עמית (נפתח בחלון חדש)', 'ea-eyalamit' )
		);
		echo '</div>'; // .ea-ftr__soc
		echo '</div>'; // .ea-ftr__contact

		echo '</div>'; // .ea-ftr__in

		// Legal strip — LAST, centred, the only light-toned region. Existing copy (section-footer.php).
		echo '<div class="ea-ftr__legal">';
		echo '<div class="ea-ftr__legal-in">';
		echo '<p class="ea-ftr__disc">המידע באתר זה אינו מהווה ייעוץ רפואי, אבחון או טיפול רפואי, ואינו מחליף פנייה לאיש מקצוע מוסמך. במקרים של מצב רפואי או נפשי, יש להתייעץ עם גורם רפואי מוסמך לפני תחילת התהליך.</p>';
		printf(
			'<p class="ea-ftr__base">&copy; 2026 אייל עמית · כל הזכויות שמורות · <a href="%s">הצהרת נגישות</a> · <a href="%s">מדיניות פרטיות</a> · <a href="%s">תקנון</a></p>',
			esc_url( home_url( '/accessibility/' ) ),
			esc_url( home_url( '/privacy/' ) ),
			esc_url( home_url( '/terms/' ) )
		);
		echo '</div>'; // .ea-ftr__legal-in
		echo '</div>'; // .ea-ftr__legal

		echo '</footer>';
	}
endif;

/*
 * Universal safety net — same mechanism the sitemap row it replaces used,
 * for the same reason: the child footer.php gateway (inc/ea-canonical-nav.php
 * caller: footer.php) calls ea_render_unified_footer() explicitly in its own
 * shell branch, but when the GeneratePress PARENT theme's footer.php is
 * readable (the live/staging case), THAT file is what actually runs, with
 * none of this theme's footer partials in the request at all. Measured
 * 2026-09-26: /historical-articles/ is the one live example among the 153
 * published pages/posts (it renders on page-template-default). The parent
 * theme's own footer.php is not in this repo (installed on the server, not
 * vendored), so there is no safe fixed point inside it to call from
 * directly. wp_footer() fires on every WordPress front-end page immediately
 * before </body>, including this theme's own, so hooking it here reaches
 * that page without depending on the parent theme's internal structure.
 * generate_show_footer is also filtered to false (functions.php) so
 * GeneratePress's own site-info <footer> never renders alongside this one —
 * that pairing is what produced the double footer on /press/ (Wave2's own
 * .ea-footer plus GP's .site-info; see the DONE report for the measurement).
 * The function's own render-once guard makes this hook inert everywhere the
 * footer already rendered via one of the three explicit calls above.
 */
add_action( 'wp_footer', 'ea_render_unified_footer' );
