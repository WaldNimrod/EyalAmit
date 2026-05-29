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
 * Enqueue W2-05 assets: shared services.css, the W2-05 CSS partial, and the
 * canonical A/B CTA script (extended to wire the product-CTA buttons).
 */
function ea_w2_05_assets() {
	if ( is_admin() || ! ea_w2_05_is_wave2_page() ) {
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
