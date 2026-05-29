<?php
/**
 * WP-W2-04 — Sound Healing + Lessons service-page routing, content injection, assets.
 * Mirrors the W2-02/W2-03 pattern (template_include @ priority 100, ea_wave2_shell
 * query var on template_redirect, body-class / sidebar / GP-title filters).
 *
 * Unlike W2-03 (book pages under a /books parent), these two service pages are
 * TOP-LEVEL slugs (like W2-02): post_name `sound-healing` + `lessons` → tpl-service.
 *
 * tpl-service.php is a thin shell that renders the_content() only, and FTP deploy
 * cannot write post_content. Therefore the 10-block HTML is injected via a
 * the_content filter keyed on these two slugs (guarded by is_main_query()
 * + in_the_loop()). Block data comes from ea_w2_04_page_content().
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/wave2-w2-04-content.php';

/**
 * Top-level service slugs handled by this WP → template.
 *
 * @return array<string,string>
 */
function ea_w2_04_slugs() {
	return array(
		'sound-healing' => 'tpl-service',
		'lessons'       => 'tpl-service',
	);
}

/**
 * Resolve the current request to a W2-04 page slug, or '' if not a W2-04 view.
 *
 * @return string
 */
function ea_w2_04_current_slug() {
	if ( ! is_page() ) {
		return '';
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) ) {
		return '';
	}
	$slugs = ea_w2_04_slugs();
	// Top-level match only (post_parent === 0), like W2-02.
	if ( isset( $slugs[ $post->post_name ] ) && 0 === (int) $post->post_parent ) {
		return $post->post_name;
	}
	return '';
}

/**
 * True when the current request is a W2-04 service page.
 *
 * @return bool
 */
function ea_w2_04_is_wave2_page() {
	return '' !== ea_w2_04_current_slug();
}

/**
 * Route W2-04 pages to tpl-service. Priority 100 — after legacy filters.
 *
 * @param string $tpl Current template path.
 * @return string
 */
function ea_w2_04_template_include( $tpl ) {
	$slug = ea_w2_04_current_slug();
	if ( '' === $slug ) {
		return $tpl;
	}
	$slugs = ea_w2_04_slugs();
	$t     = locate_template( 'page-templates/' . $slugs[ $slug ] . '.php' );
	if ( $t ) {
		return $t;
	}
	return $tpl;
}
add_filter( 'template_include', 'ea_w2_04_template_include', 100 );

/**
 * Mark W2-04 force-routed pages as a Wave2 active view for Stage-B asset hygiene.
 */
add_action( 'template_redirect', function () {
	if ( ea_w2_04_is_wave2_page() ) {
		set_query_var( 'ea_wave2_shell', true );
	}
} );

/**
 * Body classes: ea-wave2-shell + ea-service-<slug>.
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_w2_04_body_class( $classes ) {
	$slug = ea_w2_04_current_slug();
	if ( '' === $slug ) {
		return $classes;
	}
	if ( ! in_array( 'ea-wave2-shell', $classes, true ) ) {
		$classes[] = 'ea-wave2-shell';
	}
	$classes[] = 'ea-service-' . $slug;
	return $classes;
}
add_filter( 'body_class', 'ea_w2_04_body_class', 102 );

/**
 * No sidebar on W2-04 pages.
 *
 * @param string $layout
 * @return string
 */
function ea_w2_04_sidebar_layout( $layout ) {
	if ( ea_w2_04_is_wave2_page() ) {
		return 'no-sidebar';
	}
	return $layout;
}
add_filter( 'generate_sidebar_layout', 'ea_w2_04_sidebar_layout', 103 );

/**
 * Hide GeneratePress content title on W2-04 pages (H1 is inside the hero block).
 *
 * @param bool $show
 * @return bool
 */
function ea_w2_04_hide_gp_title( $show ) {
	if ( ea_w2_04_is_wave2_page() ) {
		return false;
	}
	return $show;
}
add_filter( 'generate_show_title', 'ea_w2_04_hide_gp_title', 103 );

/**
 * Enqueue W2-04 assets: shared services.css, the W2-04 CSS partial, and the
 * canonical A/B CTA script (extended to toggle the in-page CTA block).
 */
function ea_w2_04_assets() {
	if ( is_admin() || ! ea_w2_04_is_wave2_page() ) {
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
		'ea-w2-04-service',
		$uri . '/assets/css/w2-04-service.css',
		array( 'ea-eyalamit-services' ),
		$ver
	);
	// Canonical A/B mechanism (eyal_cta_variant). Toggles [data-ea-ab] CTA block.
	wp_enqueue_script(
		'ea-ab-testing',
		$uri . '/assets/js/ea-ab-testing.js',
		array(),
		$ver,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_w2_04_assets', 28 );

/**
 * Inject the 10-block service-page HTML into the_content for W2-04 pages.
 * tpl-service.php renders the_content() only; post_content is empty in the DB.
 *
 * @param string $content
 * @return string
 */
function ea_w2_04_inject_content( $content ) {
	if ( ! is_main_query() || ! in_the_loop() ) {
		return $content;
	}
	$slug = ea_w2_04_current_slug();
	if ( '' === $slug ) {
		return $content;
	}
	$blocks = ea_w2_04_page_content( $slug );
	if ( ! is_array( $blocks ) ) {
		return $content;
	}
	return ea_w2_04_render_blocks( $slug, $blocks );
}
add_filter( 'the_content', 'ea_w2_04_inject_content', 9 );

/**
 * Render the ordered block list to HTML.
 *
 * @param string                          $slug
 * @param array<int,array<string,mixed>>  $blocks
 * @return string
 */
function ea_w2_04_render_blocks( $slug, $blocks ) {
	ob_start();
	$alt = false;
	foreach ( $blocks as $block ) {
		$type = isset( $block['type'] ) ? $block['type'] : '';
		switch ( $type ) {
			case 'hero':
				ea_w2_04_render_hero( $block );
				break;
			case 'prose':
				ea_w2_04_render_prose( $block, $alt );
				$alt = ! $alt;
				break;
			case 'steps':
				ea_w2_04_render_steps( $block, $alt );
				$alt = ! $alt;
				break;
			case 'faq':
				ea_w2_04_render_faq( $block, $alt );
				$alt = ! $alt;
				break;
			case 'testimonials':
				ea_w2_04_render_testimonials( $block, $alt );
				$alt = ! $alt;
				break;
			case 'cta':
				ea_w2_04_render_cta( $slug, $block );
				break;
		}
	}
	return ob_get_clean();
}

/**
 * Hero block (single H1 + subtitle + primary CTA).
 *
 * @param array<string,mixed> $b
 */
function ea_w2_04_render_hero( $b ) {
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
function ea_w2_04_render_prose( $b, $alt ) {
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
function ea_w2_04_render_steps( $b, $alt ) {
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
function ea_w2_04_render_faq( $b, $alt ) {
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
 * Testimonials block — Top-5 + accordion; text + placeholder image + FB link.
 * Images are grey placeholders until WP-W2-07 (declared carry-forward).
 *
 * @param array<string,mixed> $b
 * @param bool                $alt
 */
function ea_w2_04_render_testimonials( $b, $alt ) {
	$classes = 'ea-section ea-section--testimonials';
	if ( $alt ) {
		$classes .= ' ea-section--alt';
	}
	?>
	<section class="<?php echo esc_attr( $classes ); ?>" data-block="testimonials-row" aria-label="<?php echo esc_attr( $b['heading'] ); ?>">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading ea-entrance--breath"><?php echo esc_html( $b['heading'] ); ?></h2>
			<div class="ea-testimonials-accordion">
				<?php foreach ( (array) $b['items'] as $i => $item ) : ?>
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
							</blockquote>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
			<?php if ( ! empty( $b['footer_href'] ) ) : ?>
				<div class="ea-testimonials-section__footer">
					<a class="ea-link" href="<?php echo esc_url( home_url( $b['footer_href'] ) ); ?>">
						<?php echo esc_html( $b['footer_label'] ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
}

/**
 * CTA block — A/B variant (form_only / dual / wa_only) via the canonical
 * eyal_cta_variant key in ea-ab-testing.js. All three variants are present in
 * the markup; ea-ab-testing.js toggles visibility per the per-session variant.
 *
 * form  → /contact?subject=<page-slug>
 * WhatsApp → https://wa.me/972524822842
 * GA4 cta_click { variant_label, page } fired by ea-ab-testing.js.
 *
 * @param string              $slug
 * @param array<string,mixed> $b
 */
function ea_w2_04_render_cta( $slug, $b ) {
	$contact = home_url( '/contact?subject=' . rawurlencode( $slug ) );
	$wa      = 'https://wa.me/972524822842';
	?>
	<section class="ea-section ea-section--cta ea-section--closing" data-block="cta" aria-label="<?php echo esc_attr( $b['heading'] ); ?>">
		<div class="ea-section__inner ea-section__inner--center">
			<h2 class="ea-section__heading"><?php echo esc_html( $b['heading'] ); ?></h2>
			<?php if ( ! empty( $b['html'] ) ) : ?>
				<div class="ea-service-prose ea-service-prose--center"><?php echo wp_kses_post( $b['html'] ); ?></div>
			<?php endif; ?>
			<div class="ea-cta-ab" data-ea-ab data-ea-page="<?php echo esc_attr( $slug ); ?>">
				<a class="ea-cta-pill ea-cta-pill--primary ea-cta-ab__form"
					href="<?php echo esc_url( $contact ); ?>"
					data-ea-ab-form>
					לתיאום שיחת היכרות
				</a>
				<a class="ea-cta-pill ea-cta-pill--whatsapp ea-cta-ab__wa"
					href="<?php echo esc_url( $wa ); ?>"
					target="_blank"
					rel="noopener noreferrer"
					data-ea-ab-wa>
					שליחת הודעה ב‑WhatsApp
				</a>
			</div>
		</div>
	</section>
	<?php
}
