<?php
/**
 * WP-W2-03 — Muzza Publishing catalog + book-detail routing, assets.
 * Mirrors the W2-02 pattern (template_include @ priority 100, ea_wave2_shell
 * query var on template_redirect, body-class / sidebar / GP-title filters).
 *
 * Unlike W2-02 (top-level post_name match), book pages live under a /books
 * parent: catalog = page slug `books`; the 3 book pages are CHILDREN of `books`.
 * Matching is done on the queried page's slug + its parent slug so that
 * /books/<slug> resolves correctly.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/wave2-w2-03-content.php';

/**
 * Catalog parent slug.
 *
 * @return string
 */
function ea_w2_03_catalog_slug() {
	return 'books';
}

/**
 * Book-detail child slugs (children of `books`) → book identity.
 *
 * @return array<string,string>
 */
function ea_w2_03_book_slugs() {
	return array(
		'vekatavta'    => 'vekatavta',
		'kushi-blantis' => 'kushi-blantis',
		'tsva-bekahol' => 'tsva-bekahol',
	);
}

/**
 * Resolve the current request to a W2-03 view.
 * Returns one of: 'catalog', a book slug, or '' (not a W2-03 view).
 *
 * @return string
 */
function ea_w2_03_current_view() {
	if ( ! is_page() ) {
		return '';
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) ) {
		return '';
	}

	// Catalog page: top-level slug `books`.
	if ( $post->post_name === ea_w2_03_catalog_slug() && 0 === (int) $post->post_parent ) {
		return 'catalog';
	}

	// Book-detail page: child of `books` whose slug is in the book map.
	$books = ea_w2_03_book_slugs();
	if ( isset( $books[ $post->post_name ] ) && (int) $post->post_parent > 0 ) {
		$parent = get_post( $post->post_parent );
		if ( $parent instanceof WP_Post && $parent->post_name === ea_w2_03_catalog_slug() ) {
			return $post->post_name;
		}
	}

	return '';
}

/**
 * True when the current request is any W2-03 view (catalog or a book page).
 *
 * @return bool
 */
function ea_w2_03_is_wave2_page() {
	return '' !== ea_w2_03_current_view();
}

/**
 * Route W2-03 pages to their templates.
 * Runs at priority 100 — after legacy filters at 92–98 and W2-02 at 100.
 *
 * @param string $tpl Current template path.
 * @return string
 */
function ea_w2_03_template_include( $tpl ) {
	$view = ea_w2_03_current_view();
	if ( '' === $view ) {
		return $tpl;
	}
	$template = ( 'catalog' === $view ) ? 'tpl-books' : 'tpl-book-detail';
	$t        = locate_template( 'page-templates/' . $template . '.php' );
	if ( $t ) {
		return $t;
	}
	return $tpl;
}
add_filter( 'template_include', 'ea_w2_03_template_include', 100 );

/**
 * Mark W2-03 force-routed pages as a Wave2 active view so Stage-B asset
 * dequeue (ea_wave2_is_active_view) recognizes them. Runs before
 * wp_enqueue_scripts.
 */
add_action( 'template_redirect', function () {
	if ( ea_w2_03_is_wave2_page() ) {
		set_query_var( 'ea_wave2_shell', true );
	}
} );

/**
 * Add ea-wave2-shell body class on W2-03 pages.
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_w2_03_body_class( $classes ) {
	if ( ! ea_w2_03_is_wave2_page() ) {
		return $classes;
	}
	if ( ! in_array( 'ea-wave2-shell', $classes, true ) ) {
		$classes[] = 'ea-wave2-shell';
	}
	$view = ea_w2_03_current_view();
	$classes[] = ( 'catalog' === $view ) ? 'ea-books-catalog' : 'ea-book-detail-' . $view;
	return $classes;
}
add_filter( 'body_class', 'ea_w2_03_body_class', 102 );

/**
 * No sidebar on W2-03 pages.
 *
 * @param string $layout
 * @return string
 */
function ea_w2_03_sidebar_layout( $layout ) {
	if ( ea_w2_03_is_wave2_page() ) {
		return 'no-sidebar';
	}
	return $layout;
}
add_filter( 'generate_sidebar_layout', 'ea_w2_03_sidebar_layout', 103 );

/**
 * Hide GeneratePress content title on W2-03 pages (H1 lives in the template).
 *
 * @param bool $show
 * @return bool
 */
function ea_w2_03_hide_gp_title( $show ) {
	if ( ea_w2_03_is_wave2_page() ) {
		return false;
	}
	return $show;
}
add_filter( 'generate_show_title', 'ea_w2_03_hide_gp_title', 103 );

/**
 * Enqueue the purchase-button GA4 tracking JS on W2-03 views only.
 * The script fires the GA4 `book_purchase_click` event with `book_slug`
 * whenever a `[data-ea-book-purchase]` element is activated (AC-03).
 */
function ea_w2_03_purchase_assets() {
	if ( is_admin() || ! ea_w2_03_is_wave2_page() ) {
		return;
	}
	wp_enqueue_script(
		'ea-w2-03-purchase',
		get_stylesheet_directory_uri() . '/assets/js/ea-book-purchase.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_w2_03_purchase_assets', 28 );

/**
 * Render an external/CTA purchase button.
 * AC-03: opens the purchase URL in a NEW tab + fires GA4 `book_purchase_click`
 * with `book_slug`. When no external link is provided (Green Invoice pending),
 * the fallback URL is /contact?subject=book-<slug>, opened in the SAME tab,
 * and the GA4 event still fires.
 *
 * @param string $book_slug Book identity slug.
 * @param string $label     Button label.
 * @param string $href      External purchase URL, or '' to use the contact fallback.
 * @param string $variant   '' (primary) or 'ghost' / 'secondary'.
 */
function ea_w2_03_render_purchase_button( $book_slug, $label, $href = '', $variant = '' ) {
	$book_slug = sanitize_title( $book_slug );
	$has_link  = ( '' !== trim( (string) $href ) );

	if ( $has_link ) {
		$url        = $href;
		$target     = ' target="_blank" rel="noopener noreferrer"';
		$aria_extra = ' (נפתח בלשונית חדשה)';
	} else {
		$url        = home_url( '/contact?subject=book-' . $book_slug );
		$target     = '';
		$aria_extra = '';
	}

	$class = 'ea-cta-pill';
	if ( 'ghost' === $variant ) {
		$class .= ' ea-cta-pill--ghost';
	} elseif ( 'secondary' === $variant ) {
		$class .= ' ea-cta-pill--secondary';
	} else {
		$class .= ' ea-cta-pill--primary';
	}

	printf(
		'<a class="%1$s" href="%2$s"%3$s data-ea-book-purchase data-ea-book-slug="%4$s" aria-label="%5$s">%6$s</a>',
		esc_attr( $class ),
		esc_url( $url ),
		$target, // phpcs:ignore — static safe markup.
		esc_attr( $book_slug ),
		esc_attr( $label . $aria_extra ),
		esc_html( $label )
	);
}

/**
 * Render a grey gallery placeholder (covers/press not yet supplied by Eyal).
 *
 * @param string $label    Section eyebrow label.
 * @param int    $count    Number of placeholder cells.
 */
function ea_w2_03_render_gallery_placeholder( $label = 'גלריה', $count = 5 ) {
	echo '<div class="ea-book-gallery" data-block="gallery" aria-label="' . esc_attr( $label ) . '">';
	echo '<span class="ea-book-gallery__label">' . esc_html( $label ) . '</span>';
	echo '<div class="ea-book-gallery__grid">';
	for ( $i = 0; $i < (int) $count; $i++ ) {
		echo '<div class="ea-book-gallery__item" aria-hidden="true"><span class="ea-book-gallery__text">תמונה</span></div>';
	}
	echo '</div>';
	echo '<p class="ea-book-gallery__note">תמונות יתווספו עם קבלת החומרים.</p>';
	echo '</div>';
}
