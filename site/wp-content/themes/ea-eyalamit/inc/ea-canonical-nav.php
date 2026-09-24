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
				 * קשר", keeping its own four children — which therefore become level 3.
				 * This is the first item in the tree that nests three deep; every
				 * renderer below (desktop dropdown, mobile drawer accordion) walks
				 * 'children' recursively rather than assuming two levels, specifically
				 * so this did not need a hand-coded third markup block anywhere.
				 */
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
