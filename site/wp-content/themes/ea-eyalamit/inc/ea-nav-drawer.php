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
	return array( 'shows-heritage', 'historical-articles', 'thank-you', 'courses-soon', 'press' );
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

if ( ! function_exists( 'ea_nav_drawer_item_is_active' ) ) :
	/**
	 * Whether $item or any of its descendants (any depth) is the active item.
	 *
	 * @param array  $item    Nav item.
	 * @param string $current Active item key.
	 * @return bool
	 */
	function ea_nav_drawer_item_is_active( $item, $current ) {
		if ( '' === $current ) {
			return false;
		}
		if ( isset( $item['key'] ) && $item['key'] === $current ) {
			return true;
		}
		foreach ( ( isset( $item['children'] ) ? $item['children'] : array() ) as $child ) {
			if ( ea_nav_drawer_item_is_active( $child, $current ) ) {
				return true;
			}
		}
		return false;
	}
endif;

if ( ! function_exists( 'ea_nav_drawer_render_item' ) ) :
	/**
	 * Render one drawer row — an accordion `<li>` when the item carries
	 * children, a plain link `<li>` otherwise — recursing into 'children'
	 * at any depth. Round C (2026-09-24): "ספרים" gained a third level
	 * under "אייל עמית" in the canonical tree (inc/ea-canonical-nav.php);
	 * this is what lets its own accordion open inside the level-2 panel
	 * instead of a hand-coded third markup block — "a drawer that shows
	 * only two levels while the desktop menu shows three is a worse
	 * outcome than not shipping this" (Round C mandate).
	 *
	 * Reuses the exact classes the two-level version already had —
	 * `.ea-nd__acc-btn` for the open/close mechanics (ea-nav-drawer.js
	 * wires every `.ea-nd__acc-btn` it finds, regardless of nesting depth)
	 * and `.ea-nd__sublink` for a nested opener's size/colour/padding —
	 * so a level-3 opener needed zero new CSS rules for its own look, only
	 * an extra indent for its own sublist (ea-nav-drawer.css
	 * `.ea-nd__sublist--l3`).
	 *
	 * @param array  $item    Nav item: key,label,href,children?,hidden?,label_emph?,external?.
	 * @param string $current Active item key (aria-current / auto-expand).
	 * @param string $ea_he   Pre-rendered lang/dir attribute string (or '').
	 * @param int    $depth   0 = top level, 1+ = inside an ancestor's panel.
	 * @return void
	 */
	function ea_nav_drawer_render_item( $item, $current, $ea_he, $depth = 0 ) {
		$children = isset( $item['children'] ) ? $item['children'] : array();
		if ( $children ) {
			$acc_id    = 'ea-nd-acc-' . sanitize_html_class( $item['key'] );
			$is_active = ea_nav_drawer_item_is_active( $item, $current );
			/* Depth 0 keeps its own top-row look (.ea-nd__item, with its divider
			   border). A nested opener (e.g. "ספרים") gets NO .ea-nd__item — its
			   plain-link siblings in the same sublist are bare <li>s with no
			   divider either, and a nested accordion should read like one more
			   row in that list, not like a second top-level section. Its button
			   additionally carries .ea-nd__sublink so it inherits that class's
			   smaller/lighter row style (later in the cascade, so it wins over
			   .ea-nd__acc-btn's own sizing for the properties both set) without a
			   single new font-size or color declaration anywhere. */
			$li_class  = 0 === $depth ? ' class="ea-nd__item"' : '';
			$btn_class = 0 === $depth ? 'ea-nd__acc-btn' : 'ea-nd__acc-btn ea-nd__sublink';
			?>
			<li<?php echo $li_class; // phpcs:ignore WordPress.Security.EscapeOutput — static class string ?>>
				<button class="<?php echo esc_attr( $btn_class ); ?>" type="button"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?> aria-haspopup="true" aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $acc_id ); ?>">
					<span><?php echo esc_html( $item['label'] ); ?></span>
					<span class="ea-nd__caret" aria-hidden="true">⌄</span>
				</button>
				<div class="ea-nd__acc-panel" id="<?php echo esc_attr( $acc_id ); ?>">
					<div class="ea-nd__acc-panel-in">
						<ul class="ea-nd__sublist<?php echo $depth > 0 ? ' ea-nd__sublist--l3' : ''; ?>" role="list">
							<?php
							/*
							 * Mandate S007 task 0 (2026-09-24): the auto-generated
							 * "{label} — עמוד ראשי" row removed outright — it duplicated
							 * the section header (an accordion toggle, not a link) and
							 * the properly-named child that already targets the same
							 * page (team_00 verbatim: "כבר יש לנו ברמה 2 כפתור לכל
							 * עמוד"). This is a renderer-level rule (every item at every
							 * depth), not five hand-removed rows — the five live
							 * instances (אייל עמית, ספרים, טיפולים בדיג׳רידו, שיעורים
							 * והכשרות, כלים ואביזרים) were all generated by this one
							 * block. Verified before removal: every affected parent's
							 * own page stays reachable from the drawer via a named
							 * child link (direct match for four; the fifth, "ספרים",
							 * via its "מבצעים" child's /books/#books-bundle, which loads
							 * the same /books/ document).
							 */
							?>
							<?php foreach ( $children as $child ) : ?>
								<?php if ( ! empty( $child['hidden'] ) ) : ?>
									<?php continue; // S007 M-14: real page, kept in the tree, not rendered (content not ready). ?>
								<?php endif; ?>
								<?php ea_nav_drawer_render_item( $child, $current, $ea_he, $depth + 1 ); ?>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</li>
			<?php
		} else {
			$link_class = 0 === $depth ? 'ea-nd__link' : 'ea-nd__sublink';
			?>
			<li<?php echo 0 === $depth ? ' class="ea-nd__item"' : ''; ?>>
				<a class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $item['href'] ); ?>"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo ( ! empty( $item['key'] ) && $item['key'] === $current ) ? ' aria-current="page"' : ''; ?><?php echo ! empty( $item['external'] ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
					<span><?php echo esc_html( $item['label'] ); ?><?php if ( ! empty( $item['label_emph'] ) ) : ?> <em><?php echo esc_html( $item['label_emph'] ); ?></em><?php endif; ?></span>
					<?php if ( ! empty( $item['external'] ) ) : ?>
					<span class="ea-nd__ext"><?php esc_html_e( 'חיצוני ↗', 'ea-eyalamit' ); ?></span>
					<?php endif; ?>
				</a>
			</li>
			<?php
		}
	}
endif;

/**
 * Secondary footer links — identical set to block-topnav.php's
 * $ea_mnav_foot_links (team_00-approved 2026-08-17).
 *
 * Mandate S007 task 0 (2026-09-24): all six measured live as 301s (missing
 * trailing slash, redirecting to the canonical slashed path). "A menu link
 * that redirects is a failure by this project's own criterion." Slashes
 * added; re-measured after the fix, all six return 200 directly.
 */
function ea_nav_drawer_foot_links() {
	return array(
		array( 'href' => home_url( '/faq/' ), 'label' => 'שאלות נפוצות' ),
		array( 'href' => home_url( '/galleries/' ), 'label' => 'גלריות' ),
		array( 'href' => home_url( '/testimonials/' ), 'label' => 'המלצות' ),
		array( 'href' => home_url( '/privacy/' ), 'label' => 'מדיניות פרטיות' ),
		array( 'href' => home_url( '/accessibility/' ), 'label' => 'הצהרת נגישות' ),
		array( 'href' => home_url( '/terms/' ), 'label' => 'תקנון' ),
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

/**
 * WAF-V01 (2026-09-20): GP /about/ and /press/ carry site-branding but no Chapters
 * .nav__wm. Append the same centre-name string beside the GP title — no second nav.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function ea_gp_wordmark_body_class( $classes ) {
	if ( is_page( array( 'about', 'press' ) ) ) {
		$classes[] = 'ea-gp-wordmark';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_gp_wordmark_body_class', 100 );

/**
 * Append the Chapters wordmark beside GP site title (WAF-V01).
 *
 * generate_after_logo does not run when the header uses a text site title
 * instead of a custom logo — filter the title output instead.
 *
 * @param string $output Site title markup.
 * @return string
 */
function ea_gp_append_wordmark_to_site_title( $output ) {
	if ( ! is_page( array( 'about', 'press' ) ) ) {
		return $output;
	}
	$output .= '<span class="nav__wm">' . esc_html__( 'המרכז לטיפול בדיג׳רידו', 'ea-eyalamit' ) . '</span>';
	return $output;
}
add_filter( 'generate_site_title_output', 'ea_gp_append_wordmark_to_site_title', 20 );
