<?php
/**
 * WP-W2-05 — Shop (5 product pages + unified /shop catalog) routing, content
 * injection, assets. Mirrors the W2-04 pattern (template_include @ priority 100,
 * ea_wave2_shell query var on template_redirect, body-class / sidebar / GP-title
 * filters).
 *
 * Product pages are TOP-LEVEL slugs (like W2-02/W2-04):
 *   didgeridoos | bags | stands-storage | stand-floor | repair  → tpl-shop-item
 *   shop                                                         → tpl-shop-archive
 *
 * tpl-shop-item.php / tpl-shop-archive.php are thin shells that render
 * the_content() only, and FTP deploy cannot write post_content. Therefore the
 * 10-block HTML (product page) / catalog grid (/shop) is injected via a
 * the_content filter keyed on these slugs (guarded by is_main_query()
 * + in_the_loop()). Block data comes from ea_w2_05_page_content().
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/wave2-w2-05-content.php';

/**
 * Top-level shop slugs handled by this WP → template.
 *
 * @return array<string,string>
 */
function ea_w2_05_slugs() {
	return array(
		'didgeridoos'    => 'tpl-shop-item',
		'bags'           => 'tpl-shop-item',
		'stands-storage' => 'tpl-shop-item',
		'stand-floor'    => 'tpl-shop-item',
		'repair'         => 'tpl-shop-item',
		'shop'           => 'tpl-shop-archive',
	);
}

/**
 * Resolve the current request to a W2-05 page slug, or '' if not a W2-05 view.
 *
 * @return string
 */
function ea_w2_05_current_slug() {
	if ( ! is_page() ) {
		return '';
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) ) {
		return '';
	}
	$slugs = ea_w2_05_slugs();
	// Top-level match only (post_parent === 0), like W2-02/W2-04.
	if ( isset( $slugs[ $post->post_name ] ) && 0 === (int) $post->post_parent ) {
		return $post->post_name;
	}
	return '';
}

/**
 * True when the current request is a W2-05 shop page.
 *
 * @return bool
 */
function ea_w2_05_is_wave2_page() {
	return '' !== ea_w2_05_current_slug();
}

/**
 * Route W2-05 pages to their shop template. Priority 100 — after legacy filters.
 *
 * @param string $tpl Current template path.
 * @return string
 */
function ea_w2_05_template_include( $tpl ) {
	$slug = ea_w2_05_current_slug();
	if ( '' === $slug ) {
		return $tpl;
	}
	$slugs = ea_w2_05_slugs();
	$t     = locate_template( 'page-templates/' . $slugs[ $slug ] . '.php' );
	if ( $t ) {
		return $t;
	}
	return $tpl;
}
add_filter( 'template_include', 'ea_w2_05_template_include', 100 );

/**
 * Mark W2-05 force-routed pages as a Wave2 active view for Stage-B asset hygiene.
 */
add_action( 'template_redirect', function () {
	if ( ea_w2_05_is_wave2_page() ) {
		set_query_var( 'ea_wave2_shell', true );
	}
} );

/**
 * Body classes: ea-wave2-shell + ea-shop-<slug>.
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_w2_05_body_class( $classes ) {
	$slug = ea_w2_05_current_slug();
	if ( '' === $slug ) {
		return $classes;
	}
	if ( ! in_array( 'ea-wave2-shell', $classes, true ) ) {
		$classes[] = 'ea-wave2-shell';
	}
	$classes[] = 'ea-shop-' . $slug;
	return $classes;
}
add_filter( 'body_class', 'ea_w2_05_body_class', 102 );

/**
 * No sidebar on W2-05 pages.
 *
 * @param string $layout
 * @return string
 */
function ea_w2_05_sidebar_layout( $layout ) {
	if ( ea_w2_05_is_wave2_page() ) {
		return 'no-sidebar';
	}
	return $layout;
}
add_filter( 'generate_sidebar_layout', 'ea_w2_05_sidebar_layout', 103 );

/**
 * Hide GeneratePress content title on W2-05 pages (H1 is inside the hero block).
 *
 * @param bool $show
 * @return bool
 */
function ea_w2_05_hide_gp_title( $show ) {
	if ( ea_w2_05_is_wave2_page() ) {
		return false;
	}
	return $show;
}
add_filter( 'generate_show_title', 'ea_w2_05_hide_gp_title', 103 );

/**
 * True when the elevated cluster-E sheet (w2-05-shop.css) should load: on the
 * W2-05 shop routes (shop archive + 5 product pages) AND on the W2-10-E
 * commerce-elevated /books routes (archive + 3 book details, routed by W2-03).
 * The elevated /books + detail compositions share their atoms with this sheet.
 *
 * @return bool
 */
function ea_w2_05_is_commerce_view() {
	if ( ea_w2_05_is_wave2_page() ) {
		return true;
	}
	return function_exists( 'ea_w2_03_is_wave2_page' ) && ea_w2_03_is_wave2_page();
}

/**
 * Enqueue W2-05 assets: shared services.css, the W2-05 CSS partial, and the
 * canonical A/B CTA script (extended to wire the product-CTA buttons).
 * Loads across all cluster-E commerce routes (shop + elevated /books + details).
 */
function ea_w2_05_assets() {
	if ( is_admin() || ! ea_w2_05_is_commerce_view() ) {
		return;
	}
	$uri = get_stylesheet_directory_uri();
	$ver = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'ea-eyalamit-services',
		$uri . '/assets/css/services.css',
		array( 'ea-eyalamit-style' ),
		$ver
	);
	wp_enqueue_style(
		'ea-w2-05-shop',
		$uri . '/assets/css/w2-05-shop.css',
		array( 'ea-eyalamit-services' ),
		$ver
	);
	// Canonical A/B mechanism (eyal_cta_variant). Wires [data-ea-product-cta].
	wp_enqueue_script(
		'ea-ab-testing',
		$uri . '/assets/js/ea-ab-testing.js',
		array(),
		$ver,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_w2_05_assets', 28 );

/**
 * Inject the shop HTML into the_content for W2-05 pages.
 * tpl-shop-item.php / tpl-shop-archive.php render the_content() only; the
 * post_content is empty in the DB.
 *
 * @param string $content
 * @return string
 */
function ea_w2_05_inject_content( $content ) {
	if ( ! is_main_query() || ! in_the_loop() ) {
		return $content;
	}
	$slug = ea_w2_05_current_slug();
	if ( '' === $slug ) {
		return $content;
	}
	if ( 'shop' === $slug ) {
		return ea_w2_05_render_archive();
	}
	$blocks = ea_w2_05_page_content( $slug );
	if ( ! is_array( $blocks ) ) {
		return $content;
	}
	return ea_w2_05_render_blocks( $slug, $blocks );
}
add_filter( 'the_content', 'ea_w2_05_inject_content', 9 );

/* ============================================================
   Green Invoice URL map (B02). All EMPTY now → contact fallback.
   Wiring a real URL later = one-line-per-product edit here.
============================================================ */

/**
 * Per-slug Green Invoice purchase URL map. Empty string → contact fallback.
 *
 * @return array<string,string>
 */
function ea_w2_05_gi_url_map() {
	return array(
		'didgeridoos'    => '',
		'bags'           => '',
		'stands-storage' => '',
		'stand-floor'    => '',
		'repair'         => '',
	);
}

/**
 * Resolve the GI URL for a product slug, or '' when none configured.
 *
 * @param string $slug
 * @return string
 */
function ea_w2_05_gi_url( $slug ) {
	$map = ea_w2_05_gi_url_map();
	return isset( $map[ $slug ] ) ? (string) $map[ $slug ] : '';
}

/**
 * Resolve the price for a product slug from post meta, with literal fallback.
 *
 * @param int $post_id
 * @return string The displayable price string ("מחיר לפי התאמה" when empty).
 */
function ea_w2_05_price( $post_id ) {
	$price = get_post_meta( $post_id, 'ea_product_price', true );
	$price = is_string( $price ) ? trim( $price ) : '';
	return '' !== $price ? $price : 'מחיר לפי התאמה';
}

/* ============================================================
   Block rendering — product page (10-block contract).
============================================================ */

/**
 * Render the ordered block list to HTML.
 *
 * @param string                          $slug
 * @param array<int,array<string,mixed>>  $blocks
 * @return string
 */
function ea_w2_05_render_blocks( $slug, $blocks ) {
	ob_start();
	$alt = false;
	foreach ( $blocks as $block ) {
		$type = isset( $block['type'] ) ? $block['type'] : '';
		switch ( $type ) {
			case 'hero':
				ea_w2_05_render_hero( $slug, $block );
				break;
			case 'prose':
				ea_w2_05_render_prose( $block, $alt );
				$alt = ! $alt;
				break;
			case 'steps':
				ea_w2_05_render_steps( $block, $alt );
				$alt = ! $alt;
				break;
			case 'faq':
				ea_w2_05_render_faq( $block, $alt );
				$alt = ! $alt;
				break;
			case 'testimonials':
				ea_w2_05_render_testimonials( $block, $alt );
				$alt = ! $alt;
				break;
			case 'price':
				ea_w2_05_render_price( $block, $alt );
				$alt = ! $alt;
				break;
			case 'cta':
				ea_w2_05_render_cta( $slug, $block );
				break;
			case 'gallery':
				ea_w2_05_render_gallery( $block, $alt );
				$alt = ! $alt;
				break;
		}
	}
	return ob_get_clean();
}

/**
 * Hero block (single H1 + subtitle + primary CTA).
 *
 * @param string              $slug
 * @param array<string,mixed> $b
 */
function ea_w2_05_render_hero( $slug, $b ) {
	?>
	<section class="ea-service-hero" data-block="hero" aria-label="<?php echo esc_attr( $b['title'] ); ?>">
		<div class="ea-service-hero__overlay" aria-hidden="true"></div>
		<div class="ea-service-hero__content ea-entrance--breath">
			<h1 class="ea-service-hero__title"><?php echo esc_html( $b['title'] ); ?></h1>
			<?php if ( ! empty( $b['subtitle'] ) ) : ?>
				<p class="ea-service-hero__subtitle"><?php echo esc_html( $b['subtitle'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $b['cta_label'] ) ) : ?>
				<div class="ea-service-hero__cta-wrap">
					<a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( home_url( $b['cta_href'] ) ); ?>">
						<?php echo esc_html( $b['cta_label'] ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
}

/**
 * Prose block (optional H2 + rich-text body).
 *
 * @param array<string,mixed> $b
 * @param bool                $alt
 */
function ea_w2_05_render_prose( $b, $alt ) {
	$classes = 'ea-section ea-section--prose';
	if ( $alt ) {
		$classes .= ' ea-section--alt';
	}
	$heading = isset( $b['heading'] ) ? $b['heading'] : '';
	?>
	<section class="<?php echo esc_attr( $classes ); ?>" data-block="prose" aria-label="<?php echo esc_attr( '' !== $heading ? $heading : 'תוכן' ); ?>">
		<div class="ea-section__inner ea-entrance--breath">
			<?php if ( '' !== $heading ) : ?>
				<h2 class="ea-section__heading"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<div class="ea-service-prose"><?php echo wp_kses_post( $b['html'] ); ?></div>
		</div>
	</section>
	<?php
}

/**
 * Steps block (intro + staged accordion).
 *
 * @param array<string,mixed> $b
 * @param bool                $alt
 */
function ea_w2_05_render_steps( $b, $alt ) {
	$classes = 'ea-section ea-section--prose';
	if ( $alt ) {
		$classes .= ' ea-section--alt';
	}
	?>
	<section class="<?php echo esc_attr( $classes ); ?>" data-block="steps" aria-label="<?php echo esc_attr( $b['heading'] ); ?>">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading"><?php echo esc_html( $b['heading'] ); ?></h2>
			<?php if ( ! empty( $b['intro'] ) ) : ?>
				<p class="ea-service-steps__intro"><?php echo esc_html( $b['intro'] ); ?></p>
			<?php endif; ?>
			<div class="ea-service-steps">
				<?php foreach ( (array) $b['items'] as $i => $item ) : ?>
					<details class="ea-faq-item ea-service-step ea-entrance"<?php echo 0 === (int) $i ? ' open' : ''; ?>>
						<summary class="ea-faq-item__question"><?php echo esc_html( $item['h'] ); ?></summary>
						<div class="ea-faq-item__answer"><?php echo wp_kses_post( $item['body'] ); ?></div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * FAQ block — view-only, category-filtered. Reuses block-faq-list.php dataset
 * via the $ea_faq_only_category arg (no chips/JS, single category).
 *
 * @param array<string,mixed> $b
 * @param bool                $alt
 */
function ea_w2_05_render_faq( $b, $alt ) {
	$classes = 'ea-section ea-section--prose ea-section--faq';
	if ( $alt ) {
		$classes .= ' ea-section--alt';
	}
	?>
	<section class="<?php echo esc_attr( $classes ); ?>" data-block="faq" aria-label="<?php echo esc_attr( $b['heading'] ); ?>">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading"><?php echo esc_html( $b['heading'] ); ?></h2>
			<?php
			get_template_part(
				'template-parts/blocks/block',
				'faq-list',
				array( 'ea_faq_only_category' => $b['category'] )
			);
			?>
			<p class="ea-service-faq__more">
				<a class="ea-text-link" href="<?php echo esc_url( home_url( '/faq' ) ); ?>">דף השאלות הנפוצות המלא</a>
			</p>
		</div>
	</section>
	<?php
}

/**
 * Testimonials block — placeholder accordion; grey avatar placeholders until
 * WP-W2-07 (declared carry-forward). Identical pattern to W2-04.
 *
 * @param array<string,mixed> $b
 * @param bool                $alt
 */
function ea_w2_05_render_testimonials( $b, $alt ) {
	$classes = 'ea-section ea-section--testimonials';
	if ( $alt ) {
		$classes .= ' ea-section--alt';
	}
	$items = isset( $b['items'] ) ? (array) $b['items'] : array();
	?>
	<section class="<?php echo esc_attr( $classes ); ?>" data-block="testimonials-row" aria-label="<?php echo esc_attr( $b['heading'] ); ?>">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading ea-entrance--breath"><?php echo esc_html( $b['heading'] ); ?></h2>
			<?php if ( ! empty( $b['intro'] ) ) : ?>
				<p class="ea-service-steps__intro"><?php echo esc_html( $b['intro'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $items ) ) : ?>
				<div class="ea-testimonials-accordion">
					<?php foreach ( $items as $i => $item ) : ?>
						<details class="ea-testimonial-acc ea-entrance"<?php echo 0 === (int) $i ? ' open' : ''; ?>>
							<summary class="ea-testimonial-acc__summary">
								<span class="ea-testimonial-acc__figure" aria-hidden="true">
									<span class="ea-testimonial-card__avatar-placeholder"></span>
								</span>
								<span class="ea-testimonial-acc__name"><?php echo esc_html( $item['name'] ); ?></span>
								<span class="ea-testimonial-acc__chevron" aria-hidden="true">⌄</span>
							</summary>
							<div class="ea-testimonial-acc__body">
								<blockquote class="ea-testimonial-card__quote">
									<p class="ea-testimonial-card__text"><?php echo nl2br( esc_html( $item['text'] ) ); ?></p>
									<?php if ( ! empty( $item['href'] ) ) : ?>
										<footer class="ea-testimonial-card__footer">
											<a class="ea-testimonial-card__name ea-link"
												href="<?php echo esc_url( $item['href'] ); ?>"
												target="_blank"
												rel="noopener noreferrer"
												aria-label="<?php echo esc_attr( 'המלצת ' . $item['name'] . ' בפייסבוק (נפתח בחלון חדש)' ); ?>">
												<?php echo esc_html( $item['name'] ); ?>
											</a>
											<span class="ea-testimonial-card__hint" aria-hidden="true"> ↗</span>
										</footer>
									<?php endif; ?>
								</blockquote>
							</div>
						</details>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<p class="ea-service-prose ea-service-prose--center"><?php echo esc_html( ! empty( $b['placeholder'] ) ? $b['placeholder'] : 'המלצות ייעודיות יתווספו בהמשך.' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
}

/**
 * Price block — renders ea_product_price post meta, literal fallback when empty.
 * No hardcoded price values; Eyal enters the price via WP admin (C3).
 *
 * @param array<string,mixed> $b
 * @param bool                $alt
 */
function ea_w2_05_render_price( $b, $alt ) {
	$classes = 'ea-section ea-section--prose ea-section--price';
	if ( $alt ) {
		$classes .= ' ea-section--alt';
	}
	$heading = isset( $b['heading'] ) ? $b['heading'] : 'מחיר';
	$price   = ea_w2_05_price( get_the_ID() );
	?>
	<section class="<?php echo esc_attr( $classes ); ?>" data-block="price" aria-label="<?php echo esc_attr( $heading ); ?>">
		<div class="ea-section__inner ea-section__inner--center">
			<h2 class="ea-section__heading"><?php echo esc_html( $heading ); ?></h2>
			<p class="ea-product-price" data-product-price><?php echo esc_html( $price ); ?></p>
			<?php if ( ! empty( $b['note'] ) ) : ?>
				<p class="ea-product-price__note"><?php echo esc_html( $b['note'] ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
}

/**
 * Purchase/contact CTA block (B02 matrix).
 *
 * GI URL present → button opens it new-tab (target=_blank rel=noopener),
 *   cta_type=green_invoice.
 * No GI URL (current state for ALL 5) → /contact?subject=product-<slug> same tab,
 *   cta_type=contact. Never "#".
 *
 * The A/B variant (eyal_cta_variant: form_only/dual/wa_only) selects form vs
 * WhatsApp for the contact path; WhatsApp → https://wa.me/972524822842.
 * ea-ab-testing.js wires [data-ea-product-cta] and fires GA4 product_cta_click
 * { product_slug, cta_type }.
 *
 * @param string              $slug
 * @param array<string,mixed> $b
 */
function ea_w2_05_render_cta( $slug, $b ) {
	$gi      = ea_w2_05_gi_url( $slug );
	$contact = home_url( '/contact?subject=product-' . rawurlencode( $slug ) );
	$wa      = 'https://wa.me/972524822842';
	$heading = isset( $b['heading'] ) ? $b['heading'] : 'לרכישה והתאמה';
	?>
	<section class="ea-section ea-section--cta ea-section--closing" data-block="cta" aria-label="<?php echo esc_attr( $heading ); ?>">
		<div class="ea-section__inner ea-section__inner--center">
			<h2 class="ea-section__heading"><?php echo esc_html( $heading ); ?></h2>
			<?php if ( ! empty( $b['html'] ) ) : ?>
				<div class="ea-service-prose ea-service-prose--center"><?php echo wp_kses_post( $b['html'] ); ?></div>
			<?php endif; ?>
			<?php if ( '' !== $gi ) : ?>
				<div class="ea-cta-ab ea-cta-ab--purchase"
					data-ea-product-cta
					data-product-slug="<?php echo esc_attr( $slug ); ?>"
					data-cta-type="green_invoice">
					<a class="ea-cta-pill ea-cta-pill--primary"
						href="<?php echo esc_url( $gi ); ?>"
						target="_blank"
						rel="noopener"
						data-ea-product-cta-link>
						<?php echo esc_html( ! empty( $b['gi_label'] ) ? $b['gi_label'] : 'לרכישה מאובטחת' ); ?>
					</a>
				</div>
			<?php else : ?>
				<div class="ea-cta-ab ea-cta-ab--purchase"
					data-ea-product-cta
					data-product-slug="<?php echo esc_attr( $slug ); ?>"
					data-cta-type="contact"
					data-ea-page="product-<?php echo esc_attr( $slug ); ?>">
					<a class="ea-cta-pill ea-cta-pill--primary ea-cta-ab__form"
						href="<?php echo esc_url( $contact ); ?>"
						data-ea-ab-form
						data-ea-product-cta-link>
						<?php echo esc_html( ! empty( $b['contact_label'] ) ? $b['contact_label'] : 'לתיאום והתאמה' ); ?>
					</a>
					<a class="ea-cta-pill ea-cta-pill--whatsapp ea-cta-ab__wa"
						href="<?php echo esc_url( $wa ); ?>"
						target="_blank"
						rel="noopener noreferrer"
						data-ea-ab-wa
						data-ea-product-cta-link>
						שליחת הודעה ב‑WhatsApp
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
}

/**
 * Gallery block — placeholder grey tiles (real images Eyal/W2-07-era; non-blocking).
 *
 * @param array<string,mixed> $b
 * @param bool                $alt
 */
function ea_w2_05_render_gallery( $b, $alt ) {
	$classes = 'ea-section ea-section--gallery';
	if ( $alt ) {
		$classes .= ' ea-section--alt';
	}
	$heading = isset( $b['heading'] ) ? $b['heading'] : 'תמונות';
	$count   = isset( $b['count'] ) ? max( 1, (int) $b['count'] ) : 6;
	?>
	<section class="<?php echo esc_attr( $classes ); ?>" data-block="gallery" aria-label="<?php echo esc_attr( $heading ); ?>">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading"><?php echo esc_html( $heading ); ?></h2>
			<?php if ( ! empty( $b['intro'] ) ) : ?>
				<p class="ea-service-steps__intro"><?php echo esc_html( $b['intro'] ); ?></p>
			<?php endif; ?>
			<div class="ea-gallery-grid" aria-hidden="true">
				<?php for ( $i = 0; $i < $count; $i++ ) : ?>
					<span class="ea-gallery-tile ea-gallery-tile--placeholder"></span>
				<?php endfor; ?>
			</div>
		</div>
	</section>
	<?php
}

/* ============================================================
   /shop catalog archive — responsive grid, 5 linked product cards.
============================================================ */

/**
 * Render the unified /shop catalog grid (5 product cards). Each card links to
 * its product page and shows price/fallback.
 *
 * @return string
 */
function ea_w2_05_render_archive() {
	$cards = ea_w2_05_catalog_cards();
	ob_start();
	?>
	<section class="ea-section ea-shop-archive" data-block="shop-archive" aria-label="חנות">
		<div class="ea-section__inner">
			<h1 class="ea-section__heading ea-entrance--breath">כלים ואביזרים לדיג'רידו</h1>
			<p class="ea-service-steps__intro">כלים בעבודת יד, תיקים, סטנדים, וכן שירות תיקון וחידוש — כל אחד מותאם לעבודה עם הכלי ועם הנשימה.</p>
			<div class="ea-shop-grid">
				<?php foreach ( $cards as $card ) :
					$price = '' !== $card['price'] ? $card['price'] : 'מחיר לפי התאמה';
					?>
					<a class="ea-shop-card ea-entrance" href="<?php echo esc_url( home_url( '/' . $card['slug'] ) ); ?>">
						<span class="ea-shop-card__media ea-shop-card__media--placeholder" aria-hidden="true"></span>
						<span class="ea-shop-card__body">
							<span class="ea-shop-card__title"><?php echo esc_html( $card['title'] ); ?></span>
							<span class="ea-shop-card__excerpt"><?php echo esc_html( $card['excerpt'] ); ?></span>
							<span class="ea-shop-card__price"><?php echo esc_html( $price ); ?></span>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Catalog card data for /shop. Price is resolved from each product page's
 * ea_product_price post meta when the page exists, else literal fallback.
 *
 * @return array<int,array<string,string>>
 */
function ea_w2_05_catalog_cards() {
	$defs = array(
		array(
			'slug'    => 'didgeridoos',
			'title'   => "כלי דיג'רידו למכירה",
			'excerpt' => 'כלים בעבודת יד, מותאמים לצליל ולנשימה.',
		),
		array(
			'slug'    => 'bags',
			'title'   => "תיקים לדיג'רידו",
			'excerpt' => 'הגנה ונשיאה נוחה לכלי, בעבודת יד.',
		),
		array(
			'slug'    => 'stands-storage',
			'title'   => "סטנדים לאחסון דיג'רידו",
			'excerpt' => 'תלייה או עמידה — אחסון יציב ובטוח.',
		),
		array(
			'slug'    => 'stand-floor',
			'title'   => "סטנד רצפתי לנגינה בישיבה נמוכה",
			'excerpt' => 'יציבות ונוחות לנגינה בישיבה על הרצפה.',
		),
		array(
			'slug'    => 'repair',
			'title'   => "תיקון וחידוש דיג'רידו",
			'excerpt' => 'שירות תיקון מקצועי לכלי דיג\'רידו.',
		),
	);
	$cards = array();
	foreach ( $defs as $def ) {
		$price = '';
		$page  = get_page_by_path( $def['slug'] );
		if ( $page instanceof WP_Post ) {
			$meta = get_post_meta( $page->ID, 'ea_product_price', true );
			$price = is_string( $meta ) ? trim( $meta ) : '';
		}
		$cards[] = array(
			'slug'    => $def['slug'],
			'title'   => $def['title'],
			'excerpt' => $def['excerpt'],
			'price'   => $price,
		);
	}
	return $cards;
}

/* ════════════════════════════════════════════════════════════════════════
   WP-W2-10-E — Commerce ELEVATED /books archive + 3 book details.
   Composition SSoT: _COMMUNICATION/team_35/WP-W2-10-E/elevation/mockup/
   (commerce-books-archive.html + commerce-book-detail.html).

   Books are routed by W2-03 (ea_w2_03_current_view → tpl-books / tpl-book-detail);
   copy comes verbatim from ea_w2_03_book_content( $slug ). This block adds the
   E-specific presentation maps (real covers, kicker, genre, price, meta strip,
   external vendor links per asset-manifest) + the two render functions. One
   data-driven path serves all 3 book details (clone = same code, per-slug data).

   ALL purchase CTAs are EXTERNAL links (no checkout). Vendor URLs are the
   asset-manifest SSoT (Morning / Mendele). Single H1 per page.
   ════════════════════════════════════════════════════════════════════════ */

/**
 * Per-book presentation map for the elevated /books composition.
 * Order follows the archive mockup (tsva-bekahol, kushi-blantis, vekatavta).
 *
 * Keys per book:
 *   cover    — real cover filename in assets/images/ (3:4 art).
 *   genre    — archive-card eyebrow + detail-hero kicker prefix.
 *   price    — display price string (numeric + ₪ handled in markup).
 *   teaser   — short archive-card teaser.
 *   kicker   — detail-hero eyebrow (genre · format · year).
 *   subtitle — detail-hero subtitle (short; full copy stays in summary).
 *   meta     — meta-strip rows [{k,v}] (מחבר / עמודים / סיפורים / שנה).
 *   buy      — external purchase links {print, ebook} (asset-manifest SSoT).
 *
 * @return array<string,array<string,mixed>>
 */
function ea_w2_05_book_map() {
	return array(
		'tsva-bekahol'  => array(
			'cover'    => 'tsva-bechol-cover.jpg',
			'genre'    => 'סיפורים קצרים · מסע',
			'price'    => '59',
			'teaser'   => '38 סיפורים קצרים ובועטים על הטיול הגדול לדרום אמריקה. יצא לראשונה ב-2001, כיום במהדורה העשירית.',
			'kicker'   => 'סיפורים קצרים · מסע · 2001',
			'subtitle' => '38 סיפורים קצרים על הטיול הגדול לדרום אמריקה אחרי השירות הצבאי — שחרור, בריחה, חופש, וכל מה שקורה בדרך החוצה ובדרך חזרה.',
			'meta'     => array(
				array( 'k' => 'מחבר', 'v' => 'אייל עמית' ),
				array( 'k' => 'עמודים', 'v' => '128' ),
				array( 'k' => 'סיפורים', 'v' => '38' ),
				array( 'k' => 'יצא לאור', 'v' => '2001' ),
			),
			'buy'      => array(
				'print' => 'https://www.mendele.co.il/product/tzvabekahol/',
				'ebook' => 'https://www.mendele.co.il/product/tzvabekahol/',
			),
			'faq_idx'  => array( 0, 1, 2, 4 ),
		),
		'kushi-blantis' => array(
			'cover'    => 'kushi-blantis-cover.jpg',
			'genre'    => 'רומן פנטזיה',
			'price'    => '69',
			'teaser'   => 'רומן פנטזיה על התעוררות, בחירה, אומץ, והיציאה מהחיים הנוחים מדי. יצא ב-2004, במהדורה השישית.',
			'kicker'   => 'רומן פנטזיה · 2004',
			'subtitle' => 'רומן פנטזיה על התעוררות, בחירה, חופש, חיבור ללב, והאומץ לצאת מהחיים הנוחים מדי.',
			'meta'     => array(
				array( 'k' => 'מחבר', 'v' => 'אייל עמית' ),
				array( 'k' => 'עמודים', 'v' => '236' ),
				array( 'k' => 'ז׳אנר', 'v' => 'פנטזיה' ),
				array( 'k' => 'יצא לאור', 'v' => '2004' ),
			),
			'buy'      => array(
				'print' => 'https://mrng.to/MTUiO3vkIg',
				'ebook' => 'https://www.mendele.co.il/product/kushibelantis/',
			),
			'faq_idx'  => array( 0, 1, 2, 3 ),
		),
		'vekatavta'     => array(
			'cover'    => 'vekatavt-cover.jpg',
			'genre'    => 'סיפורים אמיתיים · QR',
			'price'    => '79',
			'teaser'   => '46 סיפורים אמיתיים על אהבה, מסעות, אובדן, שינוי וצמיחה. ראה אור ב-2017, עם קודי QR שמרחיבים את הקריאה.',
			'kicker'   => 'סיפורים אמיתיים · ספוקן סטוריז · 2017',
			'subtitle' => '46 סיפורים אמיתיים מחייו של אייל עמית — אישי, מעורר השראה, שנע דרך אהבה, מסעות, הורות, אובדן, שינוי וצמיחה.',
			'meta'     => array(
				array( 'k' => 'מחבר', 'v' => 'אייל עמית' ),
				array( 'k' => 'עמודים', 'v' => '252' ),
				array( 'k' => 'סיפורים', 'v' => '46' ),
				array( 'k' => 'יצא לאור', 'v' => '2017' ),
			),
			'buy'      => array(
				'print' => 'https://www.mendele.co.il/product/vekatavta/',
				'ebook' => 'https://www.mendele.co.il/product/vekatavta/',
			),
			// Curated verbatim subset matching the detail mockup (dataset idx 0,2,5,6).
			'faq_idx'  => array( 0, 2, 5, 6 ),
		),
	);
}

/**
 * Three-book bundle definition (stacked-cover visual + external Morning CTA).
 *
 * @return array<string,mixed>
 */
function ea_w2_05_book_bundle() {
	return array(
		'covers' => array( 'tsva-bechol-cover.jpg', 'kushi-blantis-cover.jpg', 'vekatavt-cover.jpg' ),
		'price'  => '150',
		'strike' => '207',
		'url'    => 'https://mrng.to/MTUiO3vkIg',
	);
}

/**
 * Resolve a real cover image URL from a filename in the theme media dir.
 *
 * @param string $file
 * @return string
 */
function ea_w2_05_cover_url( $file ) {
	return get_stylesheet_directory_uri() . '/assets/images/' . $file;
}

/**
 * Render the elevated /books archive (hero + why-here + 3 book cards + bundle +
 * shop grid). Mirrors commerce-books-archive.html. Single H1 in the hero.
 *
 * @return string
 */
function ea_w2_05_render_books_archive() {
	$books  = ea_w2_05_book_map();
	$bundle = ea_w2_05_book_bundle();
	ob_start();
	?>
	<section class="ea-book-hero" data-block="hero" aria-label="מוזה הוצאה לאור">
		<div class="ea-book-hero__overlay" aria-hidden="true"></div>
		<div class="ea-book-hero__content">
			<p class="ea-book-hero__kicker">הוצאה לאור · עצמאית מאז 2004</p>
			<h1 class="ea-book-hero__title">מוזה הוצאה לאור</h1>
			<p class="ea-book-hero__subtitle">הוצאת ספרים עצמית של הסופר ומספר הסיפורים אייל עמית — ספרי מסעות, פנטסיה וסיפורים אישיים מעוררי השראה.</p>
			<div class="ea-book-hero__cta-wrap">
				<a class="ea-cta-pill ea-cta-pill--ghost-white" href="#books-bundle">לחבילת 3 הספרים</a>
			</div>
		</div>
	</section>

	<section class="ea-section ea-section--prose ea-section--alt" data-block="why-here" aria-label="למה כאן">
		<div class="ea-section__inner ea-entrance--breath">
			<p class="ea-section__label">רכישה ישירה</p>
			<h2 class="ea-section__heading">למה את הספרים של מוזה תמצאו כאן</h2>
			<p>ברכישת ספר דרך רשתות הספרים, רוב הכסף לא מגיע לסופר אלא נשאר בדרך — אצל הרשת ואצל המפיצים. ברכישה ישירה מהיוצר, ממש בדומה ל״חקלאות ישירה״, התמיכה מגיעה כמעט נטו למי שכתב את הספר. לכן כאן הספרים נמכרים במחיר מוזל ומשתלם יותר — כזה שטוב גם לקוראים וגם ליוצר.</p>
		</div>
	</section>

	<section class="ea-books-section" data-block="book-cards" aria-labelledby="books-grid-heading">
		<div class="ea-books-section__inner">
			<p class="ea-books-section__label">שלושה ספרים</p>
			<h2 id="books-grid-heading" class="ea-books-section__heading">ספרי מוזה</h2>
			<p class="ea-books-section__intro">שלושה ספרים, שלושה עולמות. כל ספר עומד בפני עצמו — בחרו את הדלת שמדברת אליכם.</p>
			<div class="ea-books-grid">
				<?php
				foreach ( $books as $slug => $b ) :
					$book  = function_exists( 'ea_w2_03_book_content' ) ? ea_w2_03_book_content( $slug ) : null;
					$title = is_array( $book ) && isset( $book['title'] ) ? (string) $book['title'] : '';
					?>
					<article class="ea-book-card ea-entrance">
						<a class="ea-book-card__link"
							href="<?php echo esc_url( home_url( '/books/' . $slug ) ); ?>"
							aria-label="<?php echo esc_attr( 'לעמוד הספר ' . $title ); ?>">
							<img class="ea-book-card__cover"
								src="<?php echo esc_url( ea_w2_05_cover_url( $b['cover'] ) ); ?>"
								alt="<?php echo esc_attr( 'כריכת ' . $title ); ?>"
								loading="lazy" decoding="async">
							<div class="ea-book-card__body">
								<p class="ea-book-card__genre"><?php echo esc_html( $b['genre'] ); ?></p>
								<h3 class="ea-book-card__title"><?php echo esc_html( $title ); ?></h3>
								<p class="ea-book-card__teaser"><?php echo esc_html( $b['teaser'] ); ?></p>
								<div class="ea-book-card__foot">
									<span class="ea-book-card__price"><?php echo esc_html( $b['price'] ); ?><small> ₪</small></span>
									<span class="ea-book-card__more">לעמוד הספר ←</span>
								</div>
							</div>
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section id="books-bundle" class="ea-bundle" data-block="bundle" aria-label="חבילת 3 הספרים">
		<div class="ea-bundle__inner ea-entrance--breath">
			<span class="ea-bundle__accent" aria-hidden="true"></span>
			<p class="ea-bundle__label">הצעה מיוחדת</p>
			<h2 class="ea-bundle__title">חבילת 3 הספרים של אייל עמית</h2>
			<div class="ea-bundle__covers" aria-hidden="true">
				<?php foreach ( $bundle['covers'] as $cover ) : ?>
					<img src="<?php echo esc_url( ea_w2_05_cover_url( $cover ) ); ?>" alt="" loading="lazy" decoding="async">
				<?php endforeach; ?>
			</div>
			<p class="ea-bundle__price">שלושת הספרים יחד — <strong><?php echo esc_html( $bundle['price'] ); ?> ש״ח</strong> במקום <del><?php echo esc_html( $bundle['strike'] ); ?> ש״ח</del></p>
			<p class="ea-bundle__desc">הזדמנות להיכנס לעולם הכתיבה של אייל עמית דרך שלושה ספרים שונים מאוד באופי שלהם, אבל מחוברים באותו קול חי, אישי ולא שגרתי.</p>
			<a class="ea-cta-pill ea-cta-pill--primary"
				href="<?php echo esc_url( $bundle['url'] ); ?>"
				target="_blank" rel="noopener noreferrer"
				data-ea-book-purchase data-ea-book-slug="bundle"
				aria-label="לרכישת חבילת 3 הספרים (נפתח בלשונית חדשה)">לרכישת חבילת 3 הספרים</a>
			<p class="ea-bundle__note">הרכישה מתבצעת דרך קישור חיצוני (Morning / חשבונית ירוקה).</p>
		</div>
	</section>

	<section class="ea-books-section ea-section--alt" data-block="shop-grid" aria-labelledby="shop-grid-heading">
		<div class="ea-books-section__inner">
			<p class="ea-books-section__label">החנות</p>
			<h2 id="shop-grid-heading" class="ea-books-section__heading">דיג׳רידו ואביזרים בעבודת יד</h2>
			<p class="ea-books-section__intro">כלים ואביזרים שנבנו בעבודת יד, מתוך הבנה עמוקה של הצליל, המבנה והקשר לנשימה.</p>
			<div class="ea-shop-grid">
				<?php foreach ( ea_w2_05_catalog_cards() as $card ) :
					$price = '' !== $card['price'] ? $card['price'] : 'מחיר לפי התאמה';
					?>
					<a class="ea-shop-card ea-entrance" href="<?php echo esc_url( home_url( '/' . $card['slug'] ) ); ?>">
						<span class="ea-shop-card__media ea-shop-card__media--placeholder" aria-hidden="true"></span>
						<span class="ea-shop-card__body">
							<span class="ea-shop-card__title"><?php echo esc_html( $card['title'] ); ?></span>
							<span class="ea-shop-card__excerpt"><?php echo esc_html( $card['excerpt'] ); ?></span>
							<span class="ea-shop-card__price"><?php echo esc_html( $price ); ?></span>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Render the elevated single book-detail composition for one of the 3 books.
 * Mirrors commerce-book-detail.html (vekatavta archetype, cloned per slug).
 * Copy is verbatim from $book (ea_w2_03_book_content); presentation/vendor from
 * the E book map. Single H1 = the book title in the hero.
 *
 * @param string              $slug  One of: vekatavta, kushi-blantis, tsva-bekahol.
 * @param array<string,mixed> $book  ea_w2_03_book_content( $slug ).
 * @return string
 */
function ea_w2_05_render_book_detail( $slug, $book ) {
	$map = ea_w2_05_book_map();
	$m   = isset( $map[ $slug ] ) ? $map[ $slug ] : null;
	if ( ! is_array( $m ) ) {
		return '';
	}
	$title     = isset( $book['title'] ) ? (string) $book['title'] : '';
	$subtitle  = '' !== (string) $m['subtitle'] ? (string) $m['subtitle'] : ( isset( $book['hero_sub'][0] ) ? (string) $book['hero_sub'][0] : '' );
	$price     = (string) $m['price'];
	$print_url = (string) $m['buy']['print'];
	$ebook_url = (string) $m['buy']['ebook'];

	// FAQ ×4 verbatim — explicit per-book index selection from the content SSoT
	// (vekatavta matches the detail mockup's curated 4; clones default first-4).
	$all_faq = isset( $book['faq'] ) ? array_values( (array) $book['faq'] ) : array();
	$faq_idx = isset( $m['faq_idx'] ) ? (array) $m['faq_idx'] : array( 0, 1, 2, 3 );
	$faq     = array();
	foreach ( $faq_idx as $i ) {
		if ( isset( $all_faq[ $i ] ) ) {
			$faq[] = $all_faq[ $i ];
		}
	}

	$gallery_lead = get_stylesheet_directory_uri() . '/assets/images/kushi-02-eyal-italy.jpg';

	ob_start();
	?>
	<section class="ea-book-hero" data-block="hero" aria-label="<?php echo esc_attr( $title ); ?>">
		<div class="ea-book-hero__overlay" aria-hidden="true"></div>
		<div class="ea-book-hero__content">
			<div>
				<a class="ea-book-hero__back" href="<?php echo esc_url( home_url( '/books' ) ); ?>">← מוזה הוצאה לאור</a>
				<p class="ea-book-hero__kicker"><?php echo esc_html( $m['kicker'] ); ?></p>
				<h1 class="ea-book-hero__title"><?php echo esc_html( $title ); ?></h1>
				<p class="ea-book-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
				<div class="ea-book-hero__cta-wrap">
					<a class="ea-cta-pill ea-cta-pill--primary"
						href="<?php echo esc_url( $print_url ); ?>"
						target="_blank" rel="noopener noreferrer"
						data-ea-book-purchase data-ea-book-slug="<?php echo esc_attr( $slug ); ?>"
						aria-label="<?php echo esc_attr( 'לרכישת הספר ' . $title . ' (נפתח בלשונית חדשה)' ); ?>">לרכישת הספר · <?php echo esc_html( $price ); ?> ₪</a>
				</div>
			</div>
			<img class="ea-book-hero__cover"
				src="<?php echo esc_url( ea_w2_05_cover_url( $m['cover'] ) ); ?>"
				alt="<?php echo esc_attr( 'כריכת הספר ' . $title ); ?>"
				width="600" height="800" fetchpriority="high" decoding="async">
		</div>
	</section>

	<div class="ea-metastrip" data-block="meta">
		<div class="ea-metastrip__inner">
			<?php foreach ( (array) $m['meta'] as $row ) : ?>
				<div>
					<p class="ea-metastrip__k"><?php echo esc_html( $row['k'] ); ?></p>
					<p class="ea-metastrip__v"><?php echo esc_html( $row['v'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<section class="ea-section" data-block="summary" aria-label="תקציר הספר">
		<div class="ea-section__inner ea-entrance--breath">
			<p class="ea-section__label">תקציר</p>
			<h2 class="ea-section__heading">על מה הספר</h2>
			<div class="ea-book-prose"><?php echo wp_kses_post( (string) $book['summary'] ); ?></div>
		</div>
	</section>

	<section class="ea-section ea-section--alt" data-block="excerpt" aria-label="קטע מתוך הספר">
		<div class="ea-section__inner">
			<details class="ea-book-excerpt" open>
				<summary class="ea-book-excerpt__toggle"><?php echo esc_html( isset( $book['excerpt_label'] ) ? $book['excerpt_label'] : 'קטע מתוך הספר — לקריאה' ); ?></summary>
				<div class="ea-book-excerpt__body ea-book-prose ea-book-prose--preserve">
					<?php echo wp_kses_post( (string) $book['excerpt_html'] ); ?>
				</div>
			</details>
		</div>
	</section>

	<section class="ea-section" data-block="about-book" aria-label="על הספר">
		<div class="ea-section__inner">
			<p class="ea-section__label">רקע</p>
			<h2 class="ea-section__heading">איך נולד הספר</h2>
			<div class="ea-book-prose"><?php echo wp_kses_post( (string) $book['about'] ); ?></div>
		</div>
	</section>

	<section class="ea-section ea-section--alt" data-block="gallery" aria-label="גלריה">
		<div class="ea-section__inner">
			<p class="ea-section__label">גלריה</p>
			<h2 class="ea-section__heading">מהעולם של הספר</h2>
			<div class="ea-book-gallery">
				<div class="ea-book-gallery__grid">
					<div class="ea-book-gallery__item">
						<img src="<?php echo esc_url( $gallery_lead ); ?>" alt="<?php echo esc_attr( 'מהעולם של הספר ' . $title ); ?>" loading="lazy" decoding="async">
					</div>
					<div class="ea-book-gallery__item"><span class="ea-book-gallery__text">[תמונה — נדרש מאייל]</span></div>
					<div class="ea-book-gallery__item"><span class="ea-book-gallery__text">[תמונה — נדרש מאייל]</span></div>
					<div class="ea-book-gallery__item"><span class="ea-book-gallery__text">[תמונה — נדרש מאייל]</span></div>
				</div>
				<p class="ea-book-gallery__note">תמונות פנים וכריכה אחורית יתווספו עם מסירת הנכסים מאייל. הפלייסהולדרים נשמרים ביחס תצוגה זהה ל-swap ישיר.</p>
			</div>
		</div>
	</section>

	<section class="ea-section" data-block="who-for" aria-label="למי הספר מתאים">
		<div class="ea-section__inner">
			<p class="ea-section__label">למי זה מתאים</p>
			<h2 class="ea-section__heading">למי הספר מדבר</h2>
			<div class="ea-book-prose"><?php echo wp_kses_post( (string) $book['who'] ); ?></div>
		</div>
	</section>

	<section class="ea-section ea-section--cta" data-block="mid-cta" aria-label="קריאה לפעולה">
		<div class="ea-section__inner ea-section__inner--center">
			<p class="ea-book-midcta__text">רוצה להתחיל לקרוא כבר עכשיו?</p>
			<div class="ea-book-purchase-cta">
				<a class="ea-cta-pill ea-cta-pill--primary"
					href="<?php echo esc_url( $print_url ); ?>"
					target="_blank" rel="noopener noreferrer"
					data-ea-book-purchase data-ea-book-slug="<?php echo esc_attr( $slug ); ?>"
					aria-label="<?php echo esc_attr( 'לרכישת הספר המודפס ' . $title . ' (נפתח בלשונית חדשה)' ); ?>">לרכישת הספר המודפס</a>
				<a class="ea-cta-pill ea-cta-pill--secondary"
					href="<?php echo esc_url( $ebook_url ); ?>"
					target="_blank" rel="noopener noreferrer"
					data-ea-book-purchase data-ea-book-slug="<?php echo esc_attr( $slug ); ?>"
					aria-label="<?php echo esc_attr( 'ספר אלקטרוני ' . $title . ' (נפתח בלשונית חדשה)' ); ?>">ספר אלקטרוני</a>
			</div>
		</div>
	</section>

	<section class="ea-section" data-block="faq" aria-label="שאלות ותשובות">
		<div class="ea-section__inner">
			<p class="ea-section__label">שאלות ותשובות</p>
			<h2 class="ea-section__heading">לפני שקונים</h2>
			<?php foreach ( $faq as $qa ) : ?>
				<details class="ea-faq-item">
					<summary class="ea-faq-item__question"><?php echo esc_html( $qa['q'] ); ?></summary>
					<div class="ea-faq-item__answer"><?php echo wp_kses_post( $qa['a'] ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="ea-section ea-section--alt" data-block="closing" aria-label="סגירה">
		<div class="ea-section__inner ea-section__inner--center">
			<div class="ea-book-prose"><?php echo wp_kses_post( (string) $book['closing'] ); ?></div>
			<div class="ea-book-purchase-cta">
				<a class="ea-cta-pill ea-cta-pill--primary"
					href="<?php echo esc_url( $print_url ); ?>"
					target="_blank" rel="noopener noreferrer"
					data-ea-book-purchase data-ea-book-slug="<?php echo esc_attr( $slug ); ?>"
					aria-label="<?php echo esc_attr( 'לרכישת הספר ' . $title . ' (נפתח בלשונית חדשה)' ); ?>">לרכישת הספר</a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
