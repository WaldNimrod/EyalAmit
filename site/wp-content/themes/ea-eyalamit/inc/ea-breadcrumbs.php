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
	if ( ea_breadcrumbs_is_qr_view() ) {
		return false;
	}
	return true;
}

/**
 * True on /qr/ hub or any /qr/* child.
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
					'label' => (string) $item['label'],
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
					'label' => (string) $item['label'],
					'href'  => ! empty( $item['href'] ) ? (string) $item['href'] : null,
				);
			}
			$chain[] = array(
				'label' => (string) $child['label'],
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
 * @param array{dark?:bool} $args dark=true on dark phero backgrounds.
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
