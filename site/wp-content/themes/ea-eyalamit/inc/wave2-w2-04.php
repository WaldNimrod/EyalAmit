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

/* ═══════════════════════════════════════════════════════════════════════════
 * WP-W2-10-A — elevated service template (Track-2 pattern-setter).
 *
 * Mirrors ea_wave2_render_home_blocks() (inc/wave2-stage-b.php). Resolves the
 * current page slug into a route context (ea_wave2_service_ctx) and renders the
 * 14-block elevated composition (ea_wave2_render_service_blocks) by
 * set_query_var()-ing each generic block's context then get_template_part().
 *
 * Route context comes from ea_wave2_service_route_content() in the content file.
 * ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Service routes handled by the elevated tpl-service composition.
 *
 * @return string[]
 */
function ea_wave2_service_slugs() {
	return array( 'treatment', 'method', 'sound-healing', 'lessons' );
}

/**
 * Enqueue the WP-W2-10-A service composition sheet on all 4 service routes.
 *
 * Relocated 2026-06-03 from the shared ea-atoms.css into assets/css/w2-10-service.css
 * (loaded only here), matching the B/E/F cluster-sheet convention. team_00 DECISION
 * 2026-06-03 (DECISION 2). Dep on ea-wave2-atoms keeps the load order after the atoms.
 */
function ea_wave2_service_composition_assets() {
	if ( is_admin() || ! is_page( ea_wave2_service_slugs() ) ) {
		return;
	}
	wp_enqueue_style(
		'ea-w2-10-service',
		get_stylesheet_directory_uri() . '/assets/css/w2-10-service.css',
		array( 'ea-wave2-atoms' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'ea_wave2_service_composition_assets', 29 );

/**
 * Resolve the current request into a service route context array, or null when
 * the current page is not one of the 4 service routes.
 *
 * Shape: array( 'slug' => string, 'content' => array<string,mixed> ).
 *
 * @return array<string,mixed>|null
 */
function ea_wave2_service_ctx() {
	if ( ! is_page() ) {
		return null;
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) ) {
		return null;
	}
	$slug = $post->post_name;
	if ( ! in_array( $slug, ea_wave2_service_slugs(), true ) || 0 !== (int) $post->post_parent ) {
		return null;
	}
	$content = function_exists( 'ea_wave2_service_route_content' ) ? ea_wave2_service_route_content( $slug ) : null;
	if ( ! is_array( $content ) ) {
		return null;
	}
	return array(
		'slug'    => $slug,
		'content' => $content,
	);
}

/**
 * Render the 14-block elevated service composition for a resolved route.
 *
 * Order (spec §3): hero, section-intro, breath-divider, content-section,
 * cbDIDG 4-step pillars, "who" 5-tile pillars, bio (real portrait),
 * service-comparison (active route), testimonials, faq-mini (+ /faq link),
 * disclaimer, CTA band. footer-social is rendered by the template chrome.
 *
 * @param array<string,mixed>|null $route_ctx From ea_wave2_service_ctx().
 */
function ea_wave2_render_service_blocks( $route_ctx ) {
	if ( ! is_array( $route_ctx ) || empty( $route_ctx['content'] ) ) {
		return;
	}
	$slug = isset( $route_ctx['slug'] ) ? (string) $route_ctx['slug'] : '';
	$c    = $route_ctx['content'];

	$portrait_url = get_stylesheet_directory_uri() . '/assets/images/eyal-portrait-hero.jpg';

	/* 1 — HERO (gradient + kicker + CTA pair + 3 breath-lines). */
	$hero         = isset( $c['hero'] ) ? (array) $c['hero'] : array();
	$hero_title   = isset( $hero['title'] ) ? (string) $hero['title'] : '';
	$hero['ctas'] = array(
		array( 'label' => 'לתיאום שיחת היכרות', 'href' => home_url( '/contact' ), 'variant' => 'primary' ),
		array( 'label' => 'מה זה ' . $hero_title, 'href' => '#what', 'variant' => 'ghost-white' ),
	);
	set_query_var( 'ea_hero_ctx', $hero );
	get_template_part( 'template-parts/blocks/block', 'hero' );

	/* 2 — SECTION-INTRO. */
	set_query_var( 'ea_intro_ctx', isset( $c['intro'] ) ? (array) $c['intro'] : array() );
	get_template_part( 'template-parts/blocks/block', 'intro' );

	/* 3 — BREATH-DIVIDER. */
	get_template_part( 'template-parts/blocks/block', 'breath-divider-1' );

	/* 4 — CONTENT-SECTION ("מה זה …"), anchored #what for the hero ghost CTA. */
	$what       = isset( $c['what'] ) ? (array) $c['what'] : array();
	$what['id'] = 'what';
	set_query_var( 'ea_content_ctx', $what );
	get_template_part( 'template-parts/blocks/block', 'content-section' );

	/* 5 — cbDIDG 4-STEP method (.ea-pillar ×4 in --steps grid, --alt bg). */
	$steps = isset( $c['steps'] ) ? (array) $c['steps'] : array();
	set_query_var( 'ea_pillars_ctx', array(
		'label'         => isset( $steps['label'] ) ? $steps['label'] : '',
		'heading'       => isset( $steps['heading'] ) ? $steps['heading'] : '',
		'items'         => isset( $steps['items'] ) ? $steps['items'] : array(),
		'grid_modifier' => 'steps',
		'alt'           => true,
		'show_titles'   => true,
		'cta'           => null,
	) );
	get_template_part( 'template-parts/blocks/block', 'method-pillars' );

	/* 6 — "WHO IT'S FOR" 5-tile pillar grid (base grid, light bg, no titles). */
	$who = isset( $c['who'] ) ? (array) $c['who'] : array();
	set_query_var( 'ea_pillars_ctx', array(
		'label'         => isset( $who['label'] ) ? $who['label'] : '',
		'heading'       => isset( $who['heading'] ) ? $who['heading'] : '',
		'items'         => isset( $who['items'] ) ? $who['items'] : array(),
		'grid_modifier' => '',
		'alt'           => false,
		'show_titles'   => false,
		'cta'           => null,
	) );
	get_template_part( 'template-parts/blocks/block', 'method-pillars' );

	/* 7 — BIO-BLOCK with the real portrait. */
	$bio          = isset( $c['bio'] ) ? (array) $c['bio'] : array();
	$bio['image'] = $portrait_url;
	set_query_var( 'ea_bio_ctx', $bio );
	get_template_part( 'template-parts/blocks/block', 'bio' );

	/* 8 — SERVICE-COMPARISON (current route active). */
	set_query_var( 'ea_comparison_ctx', array(
		'heading' => 'מה ההבדל בין טיפול, סאונד הילינג ושיעורים',
		'cols'    => function_exists( 'ea_wave2_service_comparison_cols' ) ? ea_wave2_service_comparison_cols( $slug ) : array(),
	) );
	get_template_part( 'template-parts/blocks/block', 'service-comparison' );

	/* 9 — TESTIMONIALS ×3 (sand-circle avatars) + ghost CTA. */
	$testi = isset( $c['testimonials'] ) ? (array) $c['testimonials'] : array();
	set_query_var( 'ea_testimonials_ctx', array(
		'heading'   => isset( $testi['heading'] ) ? $testi['heading'] : 'אנשים מספרים',
		'items'     => function_exists( 'ea_wave2_service_testimonials' ) ? ea_wave2_service_testimonials( $slug ) : array(),
		'ghost_cta' => array( 'label' => 'לעוד המלצות ועדויות', 'href' => home_url( '/about#testimonials' ) ),
	) );
	get_template_part( 'template-parts/blocks/block', 'testimonials-row' );

	/* 10 — FAQ-MINI ×3 + link to /faq. */
	$faq = isset( $c['faq'] ) ? (array) $c['faq'] : array();
	set_query_var( 'ea_faq_mini_ctx', array(
		'heading' => isset( $faq['heading'] ) ? $faq['heading'] : 'שאלות נפוצות',
		'items'   => isset( $faq['items'] ) ? $faq['items'] : array(),
		'footer'  => array( 'label' => 'לדף השאלות הנפוצות המלא', 'href' => home_url( '/faq' ) ),
	) );
	get_template_part( 'template-parts/blocks/block', 'faq-mini' );

	/* 11 — DISCLAIMER (verbatim). */
	set_query_var( 'ea_disclaimer_ctx', array(
		'text' => function_exists( 'ea_wave2_service_disclaimer_text' ) ? ea_wave2_service_disclaimer_text() : '',
	) );
	get_template_part( 'template-parts/blocks/block', 'disclaimer' );

	/* 12 — CTA BAND (ink). */
	$cta = isset( $c['cta'] ) ? (array) $c['cta'] : array();
	set_query_var( 'ea_cta_ctx', array(
		'variant' => 'band',
		'heading' => isset( $cta['heading'] ) ? $cta['heading'] : 'לתיאום שיחת היכרות',
		'body'    => isset( $cta['body'] ) ? $cta['body'] : array(),
		'cta'     => array( 'label' => 'לתיאום שיחת היכרות', 'href' => home_url( '/contact' ) ),
	) );
	get_template_part( 'template-parts/blocks/block', 'contact-cta' );
}

/**
 * Disable the legacy W2-04 the_content block injection for service routes now
 * handled by the elevated tpl-service render function. tpl-service no longer
 * calls the_content(), but this guards against residual loop output.
 *
 * @param string $content
 * @return string
 */
function ea_wave2_suppress_legacy_service_content( $content ) {
	if ( null !== ea_wave2_service_ctx() ) {
		return '';
	}
	return $content;
}
add_filter( 'the_content', 'ea_wave2_suppress_legacy_service_content', 8 );
