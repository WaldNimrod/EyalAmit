<?php
/**
 * S007 Wave B — breadcrumb trail from ea_canonical_nav_items().
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether breadcrumbs should render on this view.
 *
 * @return bool
 */
function ea_breadcrumbs_should_show() {
	if ( is_front_page() ) {
		return false;
	}
	if ( is_page( 'en' ) ) {
		return false;
	}
	return true;
}

/**
 * True on /qr/ hub or any /qr/* child.
 *
 * Round C (2026-09-24): this used to gate ea_breadcrumbs_should_show() —
 * the whole printed-code family shipped with NO breadcrumb at all, one of
 * the three measured gaps the mandate names explicitly. It is its own
 * template family (tpl-chapters-qr.php), not covered by any shared header,
 * so it needed checking, not assuming. Repurposed below to add the /qr/
 * hub as an intermediate crumb for a QR child instead of suppressing the
 * whole trail.
 *
 * @return bool
 */
function ea_breadcrumbs_is_qr_view() {
	if ( is_page( 'qr' ) ) {
		return true;
	}
	if ( ! is_page() ) {
		return false;
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) || ! $post->post_parent ) {
		return false;
	}
	return 'qr' === get_post_field( 'post_name', (int) $post->post_parent );
}

/**
 * The /qr/ hub post, when the current view is one of its children
 * (e.g. /qr/qr20/) — used to insert a real intermediate crumb rather than
 * jumping straight from "בית" to the printed-code page's own title.
 *
 * @return WP_Post|null
 */
function ea_breadcrumbs_qr_parent() {
	if ( ! is_page() ) {
		return null;
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) || ! $post->post_parent ) {
		return null;
	}
	if ( 'qr' !== get_post_field( 'post_name', (int) $post->post_parent ) ) {
		return null;
	}
	$parent = get_post( (int) $post->post_parent );
	return ( $parent instanceof WP_Post ) ? $parent : null;
}

/**
 * Current request path with trailing slash.
 *
 * @return string
 */
function ea_breadcrumbs_request_path() {
	$path = wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? (string) $_SERVER['REQUEST_URI'] : '', PHP_URL_PATH );
	if ( ! is_string( $path ) || '' === $path ) {
		$path = '/';
	}
	return trailingslashit( $path );
}

/**
 * Normalize a home-relative href to a trailing-slash path.
 *
 * @param string $href
 * @return string
 */
function ea_breadcrumbs_href_path( $href ) {
	if ( '' === $href ) {
		return '';
	}
	$path = wp_parse_url( $href, PHP_URL_PATH );
	if ( ! is_string( $path ) || '' === $path ) {
		$path = '/';
	}
	return trailingslashit( $path );
}

/**
 * A nav item/child's full text label. Nav entries may carry the visual
 * emphasis piece (e.g. "מוקש דהימן -" + label_emph "המורה שלי") in a
 * separate 'label_emph' field so the menu renderers can esc_html() and
 * italicise it on its own (2026-09-24 follow-up) — a breadcrumb crumb has
 * no italic treatment of its own, but it still needs the FULL sentence, not
 * the truncated 'label' half with a dangling hyphen.
 *
 * @param array $entry Nav item or child array.
 * @return string
 */
function ea_breadcrumbs_full_label( $entry ) {
	$label = isset( $entry['label'] ) ? (string) $entry['label'] : '';
	if ( ! empty( $entry['label_emph'] ) ) {
		$label .= ' ' . (string) $entry['label_emph'];
	}
	return $label;
}

/**
 * Find a nav chain for the current path inside ea_canonical_nav_items().
 *
 * @param string   $path Request path.
 * @param array[]  $items Nav items.
 * @return array<int,array{label:string,href:?string}>|null
 */
function ea_breadcrumbs_find_nav_chain( $path, $items ) {
	foreach ( $items as $item ) {
		if ( 'home' === ( $item['key'] ?? '' ) ) {
			continue;
		}
		$item_href = isset( $item['href'] ) ? (string) $item['href'] : '';
		if ( $item_href && ea_breadcrumbs_href_path( $item_href ) === $path ) {
			return array(
				array(
					'label' => ea_breadcrumbs_full_label( $item ),
					'href'  => $item_href,
				),
			);
		}
		$children = isset( $item['children'] ) ? (array) $item['children'] : array();
		foreach ( $children as $child ) {
			$child_href = isset( $child['href'] ) ? (string) $child['href'] : '';
			if ( ! $child_href || ea_breadcrumbs_href_path( $child_href ) !== $path ) {
				continue;
			}
			$chain = array();
			if ( ! empty( $item['label'] ) ) {
				$chain[] = array(
					'label' => ea_breadcrumbs_full_label( $item ),
					'href'  => ! empty( $item['href'] ) ? (string) $item['href'] : null,
				);
			}
			$chain[] = array(
				'label' => ea_breadcrumbs_full_label( $child ),
				'href'  => $child_href,
			);
			return $chain;
		}
	}
	return null;
}

/**
 * Strip HTML from a hero/title string for the current crumb label.
 *
 * @param string $html
 * @return string
 */
function ea_breadcrumbs_plain_title( $html ) {
	$text = wp_strip_all_tags( (string) $html );
	$text = preg_replace( '/\s+/u', ' ', $text );
	return trim( (string) $text );
}

/**
 * Build breadcrumb trail items after «בית».
 *
 * @return array<int,array{label:string,href:?string}>
 */
function ea_breadcrumb_trail() {
	$trail = array(
		array(
			'label' => 'בית',
			'href'  => home_url( '/' ),
		),
	);

	if ( is_singular( 'post' ) ) {
		foreach ( ea_canonical_nav_items() as $item ) {
			if ( 'blog' === ( $item['key'] ?? '' ) && ! empty( $item['href'] ) ) {
				$trail[] = array(
					'label' => (string) $item['label'],
					'href'  => (string) $item['href'],
				);
				break;
			}
		}
		$trail[] = array(
			'label' => ea_breadcrumbs_plain_title( get_the_title() ),
			'href'  => null,
		);
		return $trail;
	}

	$path  = ea_breadcrumbs_request_path();
	$chain = ea_breadcrumbs_find_nav_chain( $path, ea_canonical_nav_items() );
	if ( is_array( $chain ) && ! empty( $chain ) ) {
		foreach ( $chain as $crumb ) {
			$trail[] = $crumb;
		}
		$last = count( $trail ) - 1;
		$trail[ $last ]['href'] = null;
		return $trail;
	}

	/*
	 * Round C (2026-09-24) — /qr/qr20/ (the whole printed-code family) was one
	 * of the three measured gaps with no breadcrumb at all; the family is not
	 * in ea_canonical_nav_items() (it is an external/print-only link set, not
	 * a menu item), so ea_breadcrumbs_find_nav_chain() above never matches it
	 * and execution always reached the generic-title fallback below. Add a
	 * real intermediate "QR" crumb from the actual parent post (its own title
	 * and permalink — not invented copy) before falling through to that
	 * fallback, so a QR child reads בית ▸ QR ▸ <page title> instead of
	 * jumping straight from בית to the title.
	 */
	$qr_parent = ea_breadcrumbs_qr_parent();
	if ( $qr_parent instanceof WP_Post ) {
		$trail[] = array(
			'label' => ea_breadcrumbs_plain_title( get_the_title( $qr_parent ) ),
			'href'  => get_permalink( $qr_parent ),
		);
	}

	$title = '';
	if ( is_page() && function_exists( 'ea_chapters_phero_overlay' ) && ea_chapters_is_view() ) {
		$phero = ea_chapters_phero_overlay();
		if ( ! empty( $phero['title'] ) ) {
			$title = ea_breadcrumbs_plain_title( $phero['title'] );
		}
	}
	if ( '' === $title && is_page() ) {
		$title = ea_breadcrumbs_plain_title( get_the_title() );
	}
	if ( '' === $title ) {
		$title = ea_breadcrumbs_plain_title( wp_get_document_title() );
	}
	if ( '' !== $title ) {
		$trail[] = array(
			'label' => $title,
			'href'  => null,
		);
	}

	return $trail;
}

/**
 * Echo breadcrumb nav markup.
 *
 * Round C (2026-09-24), team_00: the "classic position" — right-aligned,
 * directly after the hero, before the main content, the same on every page
 * — replaces the previous in-hero placement. Every remaining call site
 * (see inc/ea-canonical-nav.php's sibling files and every tpl-chapters-*.php
 * template) now sits OUTSIDE its page's hero/header on the page's own
 * (light) background, not on a dark phero/hero image, so this wraps itself
 * in `.ea-crumb-bar > .wrap` for the same horizontal rhythm every `.sec .wrap`
 * on the page already has — no page-specific wrapper markup needed at each
 * of the nine call sites. `dark` is kept as a supported option (unused by
 * any current call site after this round's move, but not removed — a
 * future in-hero caller should not have to reinvent it).
 *
 * @param array{dark?:bool} $args dark=true on dark phero/hero backgrounds.
 * @return void
 */
function ea_breadcrumbs_render( $args = array() ) {
	if ( ! ea_breadcrumbs_should_show() ) {
		return;
	}
	$trail = ea_breadcrumb_trail();
	if ( count( $trail ) < 2 ) {
		return;
	}

	$dark  = ! empty( $args['dark'] );
	$class = 'ea-crumb' . ( $dark ? ' ea-crumb--on-dark' : '' );
	?>
	<div class="ea-crumb-bar">
		<div class="wrap">
			<nav class="<?php echo esc_attr( $class ); ?>" aria-label="<?php esc_attr_e( 'פירורי לחם', 'ea-eyalamit' ); ?>">
				<ol class="ea-crumb__list">
					<?php
					$total = count( $trail );
					foreach ( $trail as $i => $crumb ) :
						$is_last = ( $i === $total - 1 );
						?>
					<li class="ea-crumb__item">
						<?php if ( ! $is_last && ! empty( $crumb['href'] ) ) : ?>
							<a class="ea-crumb__link" href="<?php echo esc_url( $crumb['href'] ); ?>"><?php echo esc_html( $crumb['label'] ); ?></a>
						<?php else : ?>
							<span class="ea-crumb__current" aria-current="page"><?php echo esc_html( $crumb['label'] ); ?></span>
						<?php endif; ?>
					</li>
						<?php
					endforeach;
					?>
				</ol>
			</nav>
		</div>
	</div>
	<?php
}

/**
 * Enqueue breadcrumb styles on views that may render them.
 *
 * @return void
 */
function ea_breadcrumbs_enqueue_assets() {
	if ( is_admin() || ! ea_breadcrumbs_should_show() ) {
		return;
	}
	wp_enqueue_style(
		'ea-breadcrumbs',
		get_stylesheet_directory_uri() . '/assets/css/ea-breadcrumbs.css',
		array( 'ea-wave2-tokens' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'ea_breadcrumbs_enqueue_assets', 4 );

/**
 * /shows-heritage/ and /historical-articles/ are two of the three measured
 * Round C gaps: page-template-default GeneratePress pages with no phero/
 * hero partial of their own (inc/wave2-w2-07.php's own content-filter
 * pattern is the only hook these two pages give anything, per
 * ea_w2_07_strip_optional_placeholder() and its neighbours in that same
 * file), so none of the four ea_breadcrumbs_render() call sites this round
 * touches ever reach them. Same mechanism these two pages already use for
 * their own content (a the_content filter), at priority 5 — before the
 * placeholder-strip/historical-articles-injection filters at 8/9, so the
 * breadcrumb is the literal first thing in .entry-content, right after GP's
 * own entry-header/H1 ("the hero" on a page with none of its own) and
 * before the real body copy those later filters touch. Purely additive
 * (prepends markup); the regex-based filters at 8/9 match specific
 * placeholder text and are unaffected by what now sits ahead of it.
 *
 * @param string $content Post content.
 * @return string
 */
function ea_breadcrumbs_prepend_on_orphan_pages( $content ) {
	if ( ! is_string( $content ) || ! is_main_query() || ! in_the_loop() ) {
		return $content;
	}
	if ( ! is_page( array( 'shows-heritage', 'historical-articles' ) ) ) {
		return $content;
	}
	if ( ! function_exists( 'ea_breadcrumbs_render' ) ) {
		return $content;
	}
	ob_start();
	ea_breadcrumbs_render();
	$crumb = ob_get_clean();
	return ( '' !== trim( (string) $crumb ) ) ? $crumb . $content : $content;
}
add_filter( 'the_content', 'ea_breadcrumbs_prepend_on_orphan_pages', 5 );
