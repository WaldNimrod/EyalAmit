<?php
/**
 * WP-W2-07 — Heritage (Press · QR · FB Top-5 testimonials) routing + assets.
 *
 * Mirrors the W2-02 / W2-05 pattern (template_include @ priority 100,
 * ea_wave2_shell query var on template_redirect, body-class / sidebar / GP-title
 * filters, the_content injection for structured pages).
 *
 *   /press            -> structured 26-link render via the_content (slug `press`)
 *   /qr/qrN/          -> seeded pages on tpl-qr.php (router only marks the shell)
 *   FB Top-5          -> ea_w2_07_fb_testimonials() reused by W2-04 / surfaces
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * True when on the /press page.
 *
 * @return bool
 */
function ea_w2_07_is_press() {
	if ( ! is_page() ) {
		return false;
	}
	$post = get_queried_object();
	return ( $post instanceof WP_Post ) && 'press' === $post->post_name && 0 === (int) $post->post_parent;
}

/**
 * True when on a QR page (tpl-qr.php assigned, child of `qr`).
 *
 * @return bool
 */
function ea_w2_07_is_qr() {
	if ( ! is_page() ) {
		return false;
	}
	if ( is_page_template( 'page-templates/tpl-qr.php' ) ) {
		return true;
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) || ! $post->post_parent ) {
		return false;
	}
	return 'qr' === get_post_field( 'post_name', (int) $post->post_parent );
}

/**
 * True for any W2-07 active view.
 *
 * @return bool
 */
function ea_w2_07_is_wave2_page() {
	return ea_w2_07_is_press() || ea_w2_07_is_qr();
}

/**
 * Route /press to the content shell template (tpl-content.php), like W2-02.
 *
 * @param string $tpl
 * @return string
 */
function ea_w2_07_template_include( $tpl ) {
	if ( ea_w2_07_is_press() ) {
		$t = locate_template( 'page-templates/tpl-content.php' );
		if ( $t ) {
			return $t;
		}
	}
	return $tpl;
}
add_filter( 'template_include', 'ea_w2_07_template_include', 100 );

/**
 * Mark W2-07 views as a Wave2 active view (shell + Stage-B asset hygiene).
 */
add_action( 'template_redirect', function () {
	if ( ea_w2_07_is_wave2_page() ) {
		set_query_var( 'ea_wave2_shell', true );
	}
} );

/**
 * Body classes.
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_w2_07_body_class( $classes ) {
	if ( ! ea_w2_07_is_wave2_page() ) {
		return $classes;
	}
	if ( ! in_array( 'ea-wave2-shell', $classes, true ) ) {
		$classes[] = 'ea-wave2-shell';
	}
	$classes[] = ea_w2_07_is_press() ? 'ea-press' : 'ea-qr';
	return $classes;
}
add_filter( 'body_class', 'ea_w2_07_body_class', 102 );

/**
 * No sidebar on W2-07 pages.
 *
 * @param string $layout
 * @return string
 */
function ea_w2_07_sidebar_layout( $layout ) {
	return ea_w2_07_is_wave2_page() ? 'no-sidebar' : $layout;
}
add_filter( 'generate_sidebar_layout', 'ea_w2_07_sidebar_layout', 103 );

/**
 * Hide GeneratePress content title (H1 is inside the template/content).
 *
 * @param bool $show
 * @return bool
 */
function ea_w2_07_hide_gp_title( $show ) {
	return ea_w2_07_is_wave2_page() ? false : $show;
}
add_filter( 'generate_show_title', 'ea_w2_07_hide_gp_title', 103 );

/**
 * Enqueue the W2-07 CSS partial on W2-07 views.
 */
function ea_w2_07_assets() {
	if ( is_admin() || ! ea_w2_07_is_wave2_page() ) {
		return;
	}
	$uri = get_stylesheet_directory_uri();
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style(
		'ea-w2-07-heritage',
		$uri . '/assets/css/w2-07-heritage.css',
		array( 'ea-wave2-atoms' ),
		$ver
	);
}
add_action( 'wp_enqueue_scripts', 'ea_w2_07_assets', 28 );

/* ============================================================
   /press — structured render of the 26-article legacy list.
============================================================ */

/**
 * Load the press export (array of {date,title,url,source}).
 *
 * @return array<int,array<string,string>>
 */
function ea_w2_07_press_data() {
	$path = get_stylesheet_directory() . '/inc/data/w2-07-press.json';
	if ( ! is_readable( $path ) ) {
		return array();
	}
	$json = json_decode( (string) file_get_contents( $path ), true );
	return is_array( $json ) ? $json : array();
}

/**
 * Render the /press list. Newest first; each row = date · title · external link
 * (new tab). All 26 rendered.
 *
 * @return string
 */
function ea_w2_07_render_press() {
	$items = ea_w2_07_press_data();
	usort( $items, function ( $a, $b ) {
		return strcmp( (string) ( $b['date'] ?? '' ), (string) ( $a['date'] ?? '' ) );
	} );
	ob_start();
	?>
	<section class="ea-section ea-press" data-block="press" aria-label="אזכורים בתקשורת">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading ea-entrance--breath">אזכורים בתקשורת</h2>
			<p class="ea-press__intro">אזכורים, כתבות וראיונות לאורך השנים. הקישורים נפתחים בלשונית חדשה.</p>
			<ul class="ea-press__list">
				<?php foreach ( $items as $it ) :
					$title  = isset( $it['title'] ) ? trim( (string) $it['title'] ) : '';
					$url    = isset( $it['url'] ) ? trim( (string) $it['url'] ) : '';
					$source = isset( $it['source'] ) ? trim( (string) $it['source'] ) : '';
					$date   = isset( $it['date'] ) ? trim( (string) $it['date'] ) : '';
					if ( '' === $title || '' === $url ) {
						continue;
					}
					$year = ( '' !== $date ) ? substr( $date, 0, 4 ) : '';
					?>
					<li class="ea-press__item ea-entrance">
						<?php if ( '' !== $year ) : ?>
							<span class="ea-press__date"><?php echo esc_html( $year ); ?></span>
						<?php endif; ?>
						<a class="ea-press__link ea-text-link"
							href="<?php echo esc_url( $url ); ?>"
							target="_blank"
							rel="noopener noreferrer">
							<?php echo esc_html( $title ); ?>
							<span class="ea-press__hint" aria-hidden="true"> ↗</span>
						</a>
						<?php if ( '' !== $source ) : ?>
							<span class="ea-press__source"><?php echo esc_html( $source ); ?></span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php
	$press = ob_get_clean();
	// FB Top-5 testimonials rendered on the heritage surface (AC-04).
	return $press . ea_w2_07_render_fb_testimonials( 'ממליצים' );
}

/**
 * Inject /press content (the page post_content is an empty placeholder).
 *
 * @param string $content
 * @return string
 */
function ea_w2_07_inject_press( $content ) {
	if ( ! is_main_query() || ! in_the_loop() || ! ea_w2_07_is_press() ) {
		return $content;
	}
	return ea_w2_07_render_press();
}
add_filter( 'the_content', 'ea_w2_07_inject_press', 9 );

/* ============================================================
   FB Top-5 testimonials — canonical source for Wave2 surfaces.
   Text = the real FB Top-5 (sound-healing) with FB share links.
   Images rehosted under wp-content/uploads/ (relative); FB photos
   best-effort -> grey placeholder (spec F05/F04).
============================================================ */

/**
 * Canonical FB Top-5 testimonials.
 *
 * @return array<int,array<string,string>>
 */
function ea_w2_07_fb_testimonials() {
	return array(
		array(
			'name' => 'שרון לוסקי',
			'text' => "הגענו אחרי שבוע קשה… ונכנסנו לעולם אחר.\nשוכבים על רצפת עץ, עטופים בצלילים שמגיעים מכל כיוון – מעל, מתחת, מבפנים.\nפשוט להסכים להתמסר לזה.\nיצאתי בלי לדעת להסביר מה קרה… אבל עם תחושה עמוקה של וואו.",
			'href' => 'https://www.facebook.com/share/p/1DrzXzvXjA/',
			'image' => '',
		),
		array(
			'name' => 'לירן קלינה',
			'text' => "עליתי על החללית של אייל…\nחזרתי אחרי שעתיים, אבל לא באמת.\nעדיין מרחף בין גלקסיות.\nחוויה מטלטלת, נעימה, מעיפה ומקרקעת בו זמנית.\nSound healing ברמה הכי גבוהה שאפשר לדמיין.",
			'href' => 'https://www.facebook.com/share/p/1GoxG1xRKx/',
			'image' => '',
		),
		array(
			'name' => 'רוית יונה בניהו',
			'text' => "זו הייתה אחת החוויות המיוחדות שעברתי בחיים.\nתחושה של רטט עמוק שמסנכרן את הגוף מבפנים.\nנשארתי בלי מילים… וזה לא קורה לי הרבה.",
			'href' => 'https://www.facebook.com/share/p/1EYoGyKsiH/',
			'image' => '',
		),
		array(
			'name' => 'הילה יניב',
			'text' => "אמבטיית צלילים… עטופה בתדרים מכל כיוון.\nרטט עוצמתי שממיס את הגוף וזורק למחוזות אחרים.\nחוויה של ריפוי, חיבור וקסם.\nכל פרט במקום מדויק להפליא.",
			'href' => 'https://www.facebook.com/share/p/15mvQ8YZGNt/',
			'image' => '',
		),
		array(
			'name' => 'רתם פרץ',
			'text' => "חוויה אל־חושית.\nעפתי לחלל, טבעתי בתוך אמבטיית צלילים.\nהרגשתי עטופה, מוגנת ומוחזקת.\nלא דומה לשום דבר שעברתי קודם.",
			'href' => 'https://www.facebook.com/share/p/1CdeS2kWm7/',
			'image' => '',
		),
	);
}

/**
 * Render the FB Top-5 testimonials block (reusable). Mirrors the W2-05
 * testimonial accordion markup; image when present, else grey placeholder.
 *
 * @param string $heading
 * @return string
 */
function ea_w2_07_render_fb_testimonials( $heading = 'ממליצים' ) {
	$items = ea_w2_07_fb_testimonials();
	ob_start();
	?>
	<section class="ea-section ea-section--testimonials ea-fb-testimonials" data-block="testimonials-row" aria-label="<?php echo esc_attr( $heading ); ?>">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading ea-entrance--breath"><?php echo esc_html( $heading ); ?></h2>
			<div class="ea-testimonials-accordion">
				<?php foreach ( $items as $i => $item ) : ?>
					<details class="ea-testimonial-acc ea-entrance"<?php echo 0 === (int) $i ? ' open' : ''; ?>>
						<summary class="ea-testimonial-acc__summary">
							<span class="ea-testimonial-acc__figure" aria-hidden="true">
								<?php if ( ! empty( $item['image'] ) ) : ?>
									<img class="ea-testimonial-card__avatar" src="<?php echo esc_url( $item['image'] ); ?>" alt="" loading="lazy" />
								<?php else : ?>
									<span class="ea-testimonial-card__avatar-placeholder"></span>
								<?php endif; ?>
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
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/* ═══════════════════════════════════════════════════════════════════════════
 * WP-W2-10-B — elevated Editorial template (Track-2 cluster B).
 *
 * Mirrors the A render-pattern (ea_wave2_render_service_blocks, inc/wave2-w2-04.php):
 * a route-aware ea_wave2_render_editorial_blocks( $ctx ) called from
 * tpl-content.php inside <main class="ea-wave2-editorial">. Resolves the current
 * request into one of three editorial routes — /about (primary), /press,
 * /about/moksha — then composes the 13-block editorial layout by
 * set_query_var()-ing each generic block's context and get_template_part()-ing
 * the shared, data-driven partials. The bespoke editorial sections (Ink hero
 * with real portrait, meta strip, Mokesh memorial, studio gallery, book-cover
 * cross-link row) are composed inline from EXISTING .ea-* atoms — no shared
 * partial is edited and no new atom/token is defined.
 *
 * Route copy comes from ea_wave2_editorial_route_content(); /press reuses the
 * existing W2-07 press dataset + FB testimonials renderers (no content rewrite).
 *
 * Cluster CSS lives in assets/css/ea-blog.css (the editorial/content sheet),
 * enqueued on the three editorial routes by ea_wave2_editorial_assets().
 * ═══════════════════════════════════════════════════════════════════════════ */

/**
 * True when the current request is the /about/moksha child page.
 *
 * @return bool
 */
function ea_wave2_is_moksha() {
	if ( ! is_page() ) {
		return false;
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) || ! $post->post_parent ) {
		return false;
	}
	if ( 'moksha' !== $post->post_name ) {
		return false;
	}
	return 'about' === get_post_field( 'post_name', (int) $post->post_parent );
}

/**
 * Resolve the current request into an editorial route key, or '' when the
 * current view is not one of the three editorial routes.
 *
 * @return string  One of 'about' | 'press' | 'moksha', or ''.
 */
function ea_wave2_editorial_route() {
	if ( ea_wave2_is_moksha() ) {
		return 'moksha';
	}
	if ( ea_w2_07_is_press() ) {
		return 'press';
	}
	if ( is_page() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post && 'about' === $post->post_name && 0 === (int) $post->post_parent ) {
			return 'about';
		}
	}
	return '';
}

/**
 * Resolve the current request into an editorial route context, or null.
 *
 * Shape: array( 'route' => string, 'content' => array<string,mixed> ).
 *
 * @return array<string,mixed>|null
 */
function ea_wave2_editorial_ctx() {
	$route = ea_wave2_editorial_route();
	if ( '' === $route ) {
		return null;
	}
	$content = ea_wave2_editorial_route_content( $route );
	if ( ! is_array( $content ) ) {
		return null;
	}
	return array(
		'route'   => $route,
		'content' => $content,
	);
}

/**
 * Route /about/moksha (child of /about) to tpl-content. /about and /press are
 * already routed to tpl-content by W2-02 and W2-07 respectively. Priority 101 —
 * after the W2-02/W2-07 filters (100) so this only adds the missing child route.
 *
 * @param string $tpl
 * @return string
 */
function ea_wave2_editorial_template_include( $tpl ) {
	if ( ea_wave2_is_moksha() ) {
		$t = locate_template( 'page-templates/tpl-content.php' );
		if ( $t ) {
			return $t;
		}
	}
	return $tpl;
}
add_filter( 'template_include', 'ea_wave2_editorial_template_include', 101 );

/**
 * Shell hygiene for /about/moksha (W2-02 covers /about, W2-07 covers /press):
 * mark the Wave2 shell, drop the sidebar, hide the GP title, add body classes.
 */
add_action( 'template_redirect', function () {
	if ( ea_wave2_is_moksha() ) {
		set_query_var( 'ea_wave2_shell', true );
	}
} );

/**
 * Body classes for the editorial routes (ea-wave2-shell + ea-editorial + route).
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_wave2_editorial_body_class( $classes ) {
	$route = ea_wave2_editorial_route();
	if ( '' === $route ) {
		return $classes;
	}
	if ( ! in_array( 'ea-wave2-shell', $classes, true ) ) {
		$classes[] = 'ea-wave2-shell';
	}
	if ( ! in_array( 'ea-editorial', $classes, true ) ) {
		$classes[] = 'ea-editorial';
	}
	$classes[] = 'ea-editorial-' . $route;
	return $classes;
}
add_filter( 'body_class', 'ea_wave2_editorial_body_class', 104 );

/**
 * No sidebar / no GP title on /about/moksha (others already filtered upstream).
 *
 * @param string $layout
 * @return string
 */
function ea_wave2_editorial_sidebar_layout( $layout ) {
	return ea_wave2_is_moksha() ? 'no-sidebar' : $layout;
}
add_filter( 'generate_sidebar_layout', 'ea_wave2_editorial_sidebar_layout', 104 );

/**
 * Hide the GeneratePress content title on /about/moksha (H1 is in the hero).
 *
 * @param bool $show
 * @return bool
 */
function ea_wave2_editorial_hide_gp_title( $show ) {
	return ea_wave2_is_moksha() ? false : $show;
}
add_filter( 'generate_show_title', 'ea_wave2_editorial_hide_gp_title', 104 );

/**
 * Enqueue the editorial cluster sheet (ea-blog.css) on the three editorial
 * routes. Depends on the shared Wave2 atoms so atom rules cascade first.
 */
function ea_wave2_editorial_assets() {
	if ( is_admin() || '' === ea_wave2_editorial_route() ) {
		return;
	}
	$uri = get_stylesheet_directory_uri();
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style(
		'ea-editorial',
		$uri . '/assets/css/ea-blog.css',
		array( 'ea-wave2-atoms' ),
		$ver
	);
}
add_action( 'wp_enqueue_scripts', 'ea_wave2_editorial_assets', 29 );

/**
 * Suppress the legacy W2-07 /press the_content injection on the editorial
 * routes. tpl-content.php now renders the editorial composition directly via
 * ea_wave2_render_editorial_blocks() and no longer calls the_content(); this
 * guards against residual loop output if the_content() is ever reached.
 *
 * Runs at priority 8 — before ea_w2_07_inject_press() at 9.
 *
 * @param string $content
 * @return string
 */
function ea_wave2_suppress_legacy_editorial_content( $content ) {
	return null !== ea_wave2_editorial_ctx() ? '' : $content;
}
add_filter( 'the_content', 'ea_wave2_suppress_legacy_editorial_content', 8 );

/**
 * Render the 13-block elevated editorial composition for a resolved route.
 *
 * Block order (LOD400 §3): topnav (chrome, template) · 1 Ink editorial hero +
 * real portrait · 2 meta strip · 3 section-intro · 4 breath-divider ·
 * 5 content-section (the centre, .lead first para) · 6 journey timeline
 * (.ea-pillar ×6 via block-method-pillars) · 7 breath-divider · 8 Mokesh
 * memorial (dedicated section, verbatim copy) · 9 studio + gallery ·
 * 10 book-cover cross-link row · 11 contact CTA band (Ink) · footer-social
 * (chrome, template). /press and /about/moksha swap the body sections.
 *
 * @param array<string,mixed>|null $ctx From ea_wave2_editorial_ctx().
 */
function ea_wave2_render_editorial_blocks( $ctx ) {
	if ( ! is_array( $ctx ) || empty( $ctx['content'] ) ) {
		return;
	}
	$route = isset( $ctx['route'] ) ? (string) $ctx['route'] : '';
	$c     = $ctx['content'];

	/* 1 — Ink editorial hero with the real portrait (single H1). */
	ea_wave2_editorial_render_hero( isset( $c['hero'] ) ? (array) $c['hero'] : array() );

	/* 2 — meta strip (composition-only, existing type tokens). */
	if ( ! empty( $c['meta'] ) ) {
		ea_wave2_editorial_render_metastrip( (array) $c['meta'] );
	}

	/* 3 — section-intro (long-form opening) via the shared partial. */
	if ( ! empty( $c['intro'] ) ) {
		set_query_var( 'ea_intro_ctx', (array) $c['intro'] );
		get_template_part( 'template-parts/blocks/block', 'intro' );
	}

	/* 4 — breath-divider. */
	get_template_part( 'template-parts/blocks/block', 'breath-divider-1' );

	/* 5 — primary content-section(s). 'lead' on first para handled by sheet. */
	if ( ! empty( $c['sections'] ) ) {
		foreach ( (array) $c['sections'] as $ea_ed_sec ) {
			ea_wave2_editorial_render_section( (array) $ea_ed_sec );
		}
	}

	/* 6 — journey timeline: .ea-pillar ×6 via the shared method-pillars partial. */
	if ( ! empty( $c['timeline'] ) ) {
		$tl = (array) $c['timeline'];
		set_query_var( 'ea_pillars_ctx', array(
			'label'         => isset( $tl['label'] ) ? $tl['label'] : '',
			'heading'       => isset( $tl['heading'] ) ? $tl['heading'] : '',
			'items'         => isset( $tl['items'] ) ? $tl['items'] : array(),
			'grid_modifier' => 'timeline',
			'alt'           => true,
			'show_titles'   => true,
			'cta'           => null,
		) );
		get_template_part( 'template-parts/blocks/block', 'method-pillars' );

		/* 7 — breath-divider after the timeline. */
		get_template_part( 'template-parts/blocks/block', 'breath-divider-1' );
	}

	/* 8 — Mokesh memorial: dedicated section, copy VERBATIM. */
	if ( ! empty( $c['memorial'] ) ) {
		ea_wave2_editorial_render_memorial( (array) $c['memorial'] );
	}

	/* 9 — studio + gallery (real studio photo + graceful gaps). */
	if ( ! empty( $c['studio'] ) ) {
		ea_wave2_editorial_render_studio( (array) $c['studio'] );
	}

	/* /press body — press clippings list + FB testimonials (reuse W2-07). */
	if ( 'press' === $route ) {
		echo ea_w2_07_render_press(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- builder-escaped markup.
	}

	/* 10 — book-cover cross-link row + service tiles. */
	if ( ! empty( $c['books'] ) ) {
		ea_wave2_editorial_render_books( (array) $c['books'] );
	}

	/* 11 — closing contact CTA band (Ink) via the shared partial. */
	$cta = isset( $c['cta'] ) ? (array) $c['cta'] : array();
	set_query_var( 'ea_cta_ctx', array(
		'variant' => 'band',
		'heading' => isset( $cta['heading'] ) ? $cta['heading'] : 'רוצים להכיר?',
		'body'    => isset( $cta['body'] ) ? $cta['body'] : array(),
		'cta'     => array(
			'label' => isset( $cta['label'] ) ? $cta['label'] : 'לתיאום שיחת היכרות',
			'href'  => home_url( '/contact' ),
		),
	) );
	get_template_part( 'template-parts/blocks/block', 'contact-cta' );
}

/**
 * Ink editorial hero — kicker + H1 + lead + real portrait in a 1fr/300px split.
 * Composed from cluster atoms (.ea-edhero*); portrait via get_stylesheet_directory_uri().
 *
 * @param array<string,mixed> $h
 */
function ea_wave2_editorial_render_hero( $h ) {
	$kicker  = isset( $h['kicker'] ) ? (string) $h['kicker'] : '';
	$title   = isset( $h['title'] ) ? (string) $h['title'] : '';
	$lead    = isset( $h['lead'] ) ? (string) $h['lead'] : '';
	$img     = isset( $h['image'] ) ? (string) $h['image'] : '';
	$img_alt = isset( $h['image_alt'] ) ? (string) $h['image_alt'] : '';
	?>
	<header class="ea-edhero" data-block="editorial-hero">
	      <div class="ea-edhero__inner">
	        <div class="ea-edhero__text ea-entrance--breath">
	          <?php if ( '' !== $kicker ) : ?>
	          <p class="ea-edhero__kicker"><?php echo esc_html( $kicker ); ?></p>
	          <?php endif; ?>
	          <h1 class="ea-edhero__title"><?php echo esc_html( $title ); ?></h1>
	          <?php if ( '' !== $lead ) : ?>
	          <p class="ea-edhero__lead"><?php echo esc_html( $lead ); ?></p>
	          <?php endif; ?>
	        </div>
	        <?php if ( '' !== $img ) : ?>
	        <img class="ea-edhero__portrait" src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" width="300" height="375" loading="eager" />
	        <?php endif; ?>
	      </div>
	    </header>
	<?php
}

/**
 * Meta strip — scannable key/value pairs (composition-only).
 *
 * @param array<int,array<string,string>> $items  Each {k, v}.
 */
function ea_wave2_editorial_render_metastrip( $items ) {
	?>
	<div class="ea-metastrip" data-block="metastrip">
	      <div class="ea-metastrip__inner">
	        <?php foreach ( $items as $it ) : ?>
	        <div class="ea-metastrip__cell">
	          <p class="ea-metastrip__k"><?php echo esc_html( (string) ( $it['k'] ?? '' ) ); ?></p>
	          <p class="ea-metastrip__v"><?php echo esc_html( (string) ( $it['v'] ?? '' ) ); ?></p>
	        </div>
	        <?php endforeach; ?>
	      </div>
	    </div>
	<?php
}

/**
 * Editorial content-section. Composed from the existing .ea-content-section
 * atoms; first paragraph optionally promoted to .lead (styled in the sheet).
 *
 * @param array<string,mixed> $s
 */
function ea_wave2_editorial_render_section( $s ) {
	$label   = isset( $s['label'] ) ? (string) $s['label'] : '';
	$heading = isset( $s['heading'] ) ? (string) $s['heading'] : '';
	$body    = ( isset( $s['body'] ) && is_array( $s['body'] ) ) ? $s['body'] : array();
	$alt     = ! empty( $s['alt'] );
	$lead    = ! empty( $s['lead'] );
	$id      = isset( $s['id'] ) ? sanitize_html_class( (string) $s['id'] ) : '';
	$cls     = 'ea-content-section' . ( $alt ? ' ea-content-section--alt' : '' );
	?>
	<section class="<?php echo esc_attr( $cls ); ?>"<?php echo '' !== $id ? ' id="' . esc_attr( $id ) . '"' : ''; ?> data-block="content-section" aria-label="<?php echo esc_attr( '' !== $heading ? $heading : 'תוכן' ); ?>">
	      <div class="ea-content-section__inner">
	        <?php if ( '' !== $label ) : ?>
	        <p class="ea-content-section__label"><?php echo esc_html( $label ); ?></p>
	        <?php endif; ?>
	        <?php if ( '' !== $heading ) : ?>
	        <h2 class="ea-content-section__heading ea-entrance--breath"><?php echo esc_html( $heading ); ?></h2>
	        <?php endif; ?>
	        <?php if ( ! empty( $body ) ) : ?>
	        <div class="ea-content-section__body">
	          <?php foreach ( $body as $i => $p ) : ?>
	          <p<?php echo ( $lead && 0 === (int) $i ) ? ' class="lead"' : ''; ?>><?php echo esc_html( (string) $p ); ?></p>
	          <?php endforeach; ?>
	        </div>
	        <?php endif; ?>
	      </div>
	    </section>
	<?php
}

/**
 * Mokesh memorial — dedicated section: copy + circular memorial disc + pullquote.
 * SENSITIVE: body + pullquote copy are rendered VERBATIM from the route dataset.
 *
 * @param array<string,mixed> $m
 */
function ea_wave2_editorial_render_memorial( $m ) {
	$label     = isset( $m['label'] ) ? (string) $m['label'] : '';
	$heading   = isset( $m['heading'] ) ? (string) $m['heading'] : '';
	$body      = ( isset( $m['body'] ) && is_array( $m['body'] ) ) ? $m['body'] : array();
	$disc_name = isset( $m['disc_name'] ) ? (string) $m['disc_name'] : '';
	$disc_year = isset( $m['disc_year'] ) ? (string) $m['disc_year'] : '';
	$pullquote = isset( $m['pullquote'] ) ? (string) $m['pullquote'] : '';
	?>
	<section class="ea-content-section" id="mokesh" data-block="memorial" aria-label="<?php echo esc_attr( '' !== $heading ? $heading : 'מוקש דהימן' ); ?>">
	      <div class="ea-mokesh-grid">
	        <div class="ea-mokesh-grid__text">
	          <?php if ( '' !== $label ) : ?>
	          <p class="ea-content-section__label"><?php echo esc_html( $label ); ?></p>
	          <?php endif; ?>
	          <?php if ( '' !== $heading ) : ?>
	          <h2 class="ea-content-section__heading ea-entrance--breath"><?php echo esc_html( $heading ); ?></h2>
	          <?php endif; ?>
	          <?php if ( ! empty( $body ) ) : ?>
	          <div class="ea-content-section__body">
	            <?php foreach ( $body as $p ) : ?>
	            <p><?php echo esc_html( (string) $p ); ?></p>
	            <?php endforeach; ?>
	          </div>
	          <?php endif; ?>
	        </div>
	        <div class="ea-mokesh-disc" role="img" aria-label="<?php echo esc_attr( trim( $disc_name . ' ' . $disc_year ) ); ?>">
	          <p class="ea-mokesh-disc__nm"><?php echo esc_html( $disc_name ); ?></p>
	          <?php if ( '' !== $disc_year ) : ?>
	          <p class="ea-mokesh-disc__yr"><?php echo esc_html( $disc_year ); ?></p>
	          <?php endif; ?>
	        </div>
	      </div>
	      <?php if ( '' !== $pullquote ) : ?>
	      <div class="ea-pullquote">
	        <blockquote><?php echo esc_html( $pullquote ); ?></blockquote>
	      </div>
	      <?php endif; ?>
	    </section>
	<?php
}

/**
 * Studio + gallery — content-section--alt + the book-gallery atom pattern.
 * First cell = real studio photo (16:7 lead); remaining cells = graceful gaps.
 *
 * @param array<string,mixed> $st
 */
function ea_wave2_editorial_render_studio( $st ) {
	$label    = isset( $st['label'] ) ? (string) $st['label'] : '';
	$heading  = isset( $st['heading'] ) ? (string) $st['heading'] : '';
	$body     = ( isset( $st['body'] ) && is_array( $st['body'] ) ) ? $st['body'] : array();
	$g_label  = isset( $st['gallery_label'] ) ? (string) $st['gallery_label'] : '';
	$g_note   = isset( $st['gallery_note'] ) ? (string) $st['gallery_note'] : '';
	$cells    = ( isset( $st['cells'] ) && is_array( $st['cells'] ) ) ? $st['cells'] : array();
	?>
	<section class="ea-content-section ea-content-section--alt" data-block="studio" aria-label="<?php echo esc_attr( '' !== $heading ? $heading : 'הסטודיו' ); ?>">
	      <div class="ea-content-section__inner">
	        <?php if ( '' !== $label ) : ?>
	        <p class="ea-content-section__label"><?php echo esc_html( $label ); ?></p>
	        <?php endif; ?>
	        <?php if ( '' !== $heading ) : ?>
	        <h2 class="ea-content-section__heading ea-entrance--breath"><?php echo esc_html( $heading ); ?></h2>
	        <?php endif; ?>
	        <?php if ( ! empty( $body ) ) : ?>
	        <div class="ea-content-section__body">
	          <?php foreach ( $body as $p ) : ?>
	          <p><?php echo esc_html( (string) $p ); ?></p>
	          <?php endforeach; ?>
	        </div>
	        <?php endif; ?>
	      </div>
	      <?php if ( ! empty( $cells ) ) : ?>
	      <div class="ea-book-gallery" role="group" aria-label="<?php echo esc_attr( '' !== $g_label ? $g_label : 'גלריית תמונות' ); ?>">
	        <?php if ( '' !== $g_label ) : ?>
	        <span class="ea-book-gallery__label"><?php echo esc_html( $g_label ); ?></span>
	        <?php endif; ?>
	        <div class="ea-book-gallery__grid">
	          <?php foreach ( $cells as $cell ) :
	            $cimg = isset( $cell['image'] ) ? (string) $cell['image'] : '';
	            $calt = isset( $cell['alt'] ) ? (string) $cell['alt'] : '';
	            $ctxt = isset( $cell['text'] ) ? (string) $cell['text'] : '';
	            ?>
	          <div class="ea-book-gallery__item">
	            <?php if ( '' !== $cimg ) : ?>
	            <img src="<?php echo esc_url( $cimg ); ?>" alt="<?php echo esc_attr( $calt ); ?>" loading="lazy" />
	            <?php else : ?>
	            <span class="ea-book-gallery__text"><?php echo esc_html( $ctxt ); ?></span>
	            <?php endif; ?>
	          </div>
	          <?php endforeach; ?>
	        </div>
	        <?php if ( '' !== $g_note ) : ?>
	        <p class="ea-book-gallery__note"><?php echo esc_html( $g_note ); ?></p>
	        <?php endif; ?>
	      </div>
	      <?php endif; ?>
	    </section>
	<?php
}

/**
 * Book-cover cross-link row — real cover images + service tiles.
 * Composed from .ea-services-section / .ea-service-tile atoms + a cover row
 * (.ea-books-row, styled in the cluster sheet). Covers via theme media URIs.
 *
 * @param array<string,mixed> $b
 */
function ea_wave2_editorial_render_books( $b ) {
	$label   = isset( $b['label'] ) ? (string) $b['label'] : '';
	$heading = isset( $b['heading'] ) ? (string) $b['heading'] : '';
	$covers  = ( isset( $b['covers'] ) && is_array( $b['covers'] ) ) ? $b['covers'] : array();
	$tiles   = ( isset( $b['tiles'] ) && is_array( $b['tiles'] ) ) ? $b['tiles'] : array();
	?>
	<section class="ea-services-section" data-block="books-crosslink" aria-label="<?php echo esc_attr( '' !== $heading ? $heading : 'ספרים' ); ?>">
	      <div class="ea-services-section__inner">
	        <?php if ( '' !== $label ) : ?>
	        <p class="ea-services-section__label"><?php echo esc_html( $label ); ?></p>
	        <?php endif; ?>
	        <?php if ( '' !== $heading ) : ?>
	        <h2 class="ea-services-section__heading ea-entrance--breath"><?php echo esc_html( $heading ); ?></h2>
	        <?php endif; ?>
	        <?php if ( ! empty( $covers ) ) : ?>
	        <div class="ea-books-row">
	          <?php foreach ( $covers as $cover ) : ?>
	          <img src="<?php echo esc_url( (string) ( $cover['image'] ?? '' ) ); ?>" alt="<?php echo esc_attr( (string) ( $cover['alt'] ?? '' ) ); ?>" loading="lazy" />
	          <?php endforeach; ?>
	        </div>
	        <?php endif; ?>
	        <?php if ( ! empty( $tiles ) ) : ?>
	        <div class="ea-services-grid">
	          <?php foreach ( $tiles as $tile ) : ?>
	          <a class="ea-service-tile" href="<?php echo esc_url( (string) ( $tile['href'] ?? '#' ) ); ?>">
	            <?php if ( ! empty( $tile['label'] ) ) : ?>
	            <p class="ea-service-tile__label"><?php echo esc_html( (string) $tile['label'] ); ?></p>
	            <?php endif; ?>
	            <h3 class="ea-service-tile__title"><?php echo esc_html( (string) ( $tile['title'] ?? '' ) ); ?></h3>
	            <?php if ( ! empty( $tile['desc'] ) ) : ?>
	            <p class="ea-service-tile__desc"><?php echo esc_html( (string) $tile['desc'] ); ?></p>
	            <?php endif; ?>
	          </a>
	          <?php endforeach; ?>
	        </div>
	        <?php endif; ?>
	      </div>
	    </section>
	<?php
}

/**
 * Real book covers + theme-media URIs, shared by the editorial routes.
 *
 * @return array<int,array<string,string>>
 */
function ea_wave2_editorial_covers() {
	$base = get_stylesheet_directory_uri() . '/assets/images/';
	return array(
		array( 'image' => $base . 'tsva-bechol-cover.jpg', 'alt' => 'צבע בכחול וזרוק לים' ),
		array( 'image' => $base . 'kushi-blantis-cover.jpg', 'alt' => 'כושי בלאנטיס' ),
		array( 'image' => $base . 'vekatavt-cover.jpg', 'alt' => 'וכתבת' ),
	);
}

/**
 * Mokesh memorial dataset. SENSITIVE — body + pullquote copy are VERBATIM from
 * the team_35 elevation mockup (editorial-about.html). Do NOT paraphrase.
 *
 * @return array<string,mixed>
 */
function ea_wave2_editorial_memorial() {
	return array(
		'label'     => 'המורה',
		'heading'   => 'מוקש דהימן',
		'body'      => array(
			'אחד המקורות המשמעותיים ביותר בדרך היה הקשר המתמשך עם המאסטר ההודי לדיג׳רידו מוקש דהימן, שהחל בשנת 2000. אייל הפך לאחד מתלמידיו הקרובים, ולמד ממנו את יסודות העבודה התרפויטית עם הדיג׳רידו — גישה שמעמידה במרכז את הנשימה והמודעות, ולא רק את הצד המוזיקלי של הכלי.',
		),
		'disc_name' => 'מוקש דהימן',
		'disc_year' => '1950 — 2020',
		'pullquote' => '״הקשר עם מוקש דהימן הוא הציר שעליו נשענת כל הדרך התרפויטית שלי.״',
	);
}

/**
 * Route copy for the editorial routes. All copy is verbatim from the team_35
 * elevation mockup; /press reuses the existing W2-07 press dataset for its body.
 *
 * @param string $route  'about' | 'press' | 'moksha'.
 * @return array<string,mixed>|null
 */
function ea_wave2_editorial_route_content( $route ) {
	$portrait = get_stylesheet_directory_uri() . '/assets/images/eyal-portrait-hero.jpg';
	$studio   = get_stylesheet_directory_uri() . '/assets/images/hero-wide-studio.jpg';

	$books = array(
		'label'   => 'גם סופר',
		'heading' => 'שלושה ספרים, אותה נשימה',
		'covers'  => ea_wave2_editorial_covers(),
		'tiles'   => array(
			array(
				'label' => 'סיפור',
				'title' => 'על מוקש דהימן',
				'desc'  => 'המאסטר ההודי לדיג׳רידו, מורו של אייל, והמורשת הממשיכה מרישיקש לפרדס חנה.',
				'href'  => home_url( '/about/moksha/' ),
			),
			array(
				'label' => 'מוזה הוצאה לאור',
				'title' => 'לעמוד הספרים',
				'desc'  => 'ספר מסע, רומן פנטזיה, וקובץ סיפורים אוטוביוגרפי — לרכישה ישירה מהיוצר.',
				'href'  => home_url( '/books/' ),
			),
		),
	);

	if ( 'about' === $route ) {
		// WP-W2-15-CR1: /about carries Eyal's About source VERBATIM. Every source
		// SECTION (01–13) maps to an editorial content-section in source order
		// (heading = source section title verbatim, body = its sentences verbatim).
		// SECTION 01 HERO is the editorial hero (H1 + H2 + sub-title sentences); the
		// non-source elevation blocks (intro/timeline/studio/books) are dropped so no
		// invented heading is emitted. The closing CTA band heading reuses the
		// SECTION 12 title verbatim so it is not counted as an invented section.
		return array(
			'hero'     => array(
				// SECTION 01 — HERO (structural label; rendered as the editorial hero).
				'kicker'    => 'אודות',
				'title'     => 'אייל עמית',
				'lead'      => 'מייסד שיטת cbDIDG, מורה לדיג׳רידו, מטפל בנשימה באמצעות דיג׳רידו ובונה כלי דיג׳רידו בעבודת יד.',
				'image'     => $portrait,
				'image_alt' => 'דיוקן של אייל עמית',
			),
			'meta'     => array(
				array( 'k' => 'פועל מאז', 'v' => '1999' ),
				array( 'k' => 'שיטה', 'v' => 'cbDIDG' ),
				array( 'k' => 'סטודיו', 'v' => 'פרדס חנה' ),
				array( 'k' => 'ספרים', 'v' => 'שלושה' ),
			),
			'sections' => array(
				// SECTION 01 — HERO body sentences (H2 + תת כותרת), verbatim.
				array(
					'lead'    => true,
					'body'    => array(
						'מייסד שיטת cbDIDG, מורה לדיג׳רידו, מטפל בנשימה באמצעות דיג׳רידו ובונה כלי דיג׳רידו בעבודת יד.',
						'מאז 1999 אני עוסק בדיג׳רידו, נשימה, הוראה, טיפול, בניית כלים ופיתוח שיטה סדורה לעבודה עם הנשימה באמצעות הדיג׳רידו.',
					),
				),
				// SECTION 02
				array(
					'heading' => 'המסע שלי התחיל הרבה לפני הדיג׳רידו',
					'body'    => array(
						'נולדתי וגדלתי בגבעתיים. בהכשרתי אני מהנדס אלקטרוניקה, אבל לצד העולם הטכנולוגי התקיים תמיד חיפוש אחר משמעות, חיבור והבנה של מה באמת משפיע על הגוף והנפש.',
						'בגיל 12 חוויתי אירוע טראומטי ששינה את חיי. הבניין שבו גרנו עלה באש, וחבר ילדות שלי נספה בשריפה.',
						'שנים אחר כך, במהלך השירות הצבאי, התפרצו אצלי אסתמה ואלרגיות קשות. הנשימה, פעולה שרוב האנשים כלל אינם חושבים עליה, הפכה עבורי לנושא מרכזי.',
						'במשך שנים חיפשתי לא רק הקלה זמנית, אלא דרך להבין את הנשימה ולהשפיע עליה באמת.',
					),
				),
				// SECTION 03
				array(
					'heading' => 'המפגש עם הדיג׳רידו',
					'body'    => array(
						'בשנת 1999 פגשתי לראשונה את הדיג׳רידו.',
						'הצליל העמוק והמהפנט של הכלי משך אותי מיד, אך רק בהמשך הבנתי שהמשיכה לא הייתה מקרית.',
						'דרך לימוד הנגינה גיליתי עולם שלם של נשימה, הקשבה ומודעות. ככל שהעמקתי, כך השתנתה גם מערכת היחסים שלי עם הגוף, עם הסטרס ועם איכות החיים שלי.',
						'הדיג׳רידו לא רק לימד אותי לנגן.',
						'הוא לימד אותי לנשום.',
					),
				),
				// SECTION 04
				array(
					'heading' => 'המורים שעיצבו את דרכי',
					'body'    => array(
						'במשך יותר מ־20 שנה זכיתי ללמוד, לעבוד ולצמוח לצד מורים יוצאי דופן.',
						'המורה המשמעותי ביותר בחיי היה מוקש דהימן מרישיקש שבהודו. כבר משנות השבעים של המאה הקודמת, ומבלי שתכנן או ידע, הוא הפך לשגריר הדיג׳רידו הגדול ביותר בעולם.',
						'במשך שנים רבות למדתי לצידו, עבדתי בבית המלאכה שלו והפכתי לאחד מתלמידיו הקרובים.',
						'לצד מוקש למדתי גם ממורים ישראליים המגיעים מתחומים שונים: יורם סיון, מחלוצי תחום הדיג׳רידו בישראל; תמיר אלוני, מאסטר לטאי צ׳י וצ׳י קונג; טל מידן, מורתי לראג׳ה יוגה במסורת הבריגהו יוגה; אלה טולנאי, מורתי למיינדפולנס; לילה וניגם חפר, מוריי ליסודות בפסיכותרפיה; ושיר סופר, בהכשרת מטפלים בקערות טיבטיות.',
						'החיבור בין כל העולמות הללו הוא חלק משמעותי מהבסיס שעליו נבנתה בהמשך שיטת cbDIDG.',
					),
				),
				// SECTION 05
				array(
					'heading' => 'הדיג׳ שנגנב והדרך החדשה שנפתחה',
					'body'    => array(
						'בשנת 2003 נסעתי שוב להודו.',
						'במשך חודש שלם ישבתי בחצר של מוקש ובניתי דיג׳רידו בעבודת יד מגזע עץ טיק.',
						'כשחזרתי לארץ הדיג׳ לא הגיע.',
						'הוא נגנב בדרך.',
						'בדיעבד, זה היה אחד האירועים המכוננים בחיי.',
						'זמן קצר לאחר מכן קיבלתי החלטה ששינתה את מסלול חיי: לעזוב את הדרך המקצועית שסללתי כמהנדס אלקטרוניקה ולהקדיש את עצמי לעולם הדיג׳רידו.',
						'הדיג׳ שנעלם הפך לדלת שנפתחה.',
					),
				),
				// SECTION 06
				array(
					'heading' => 'שיטת cbDIDG',
					'body'    => array(
						'לאורך יותר משני עשורים אני חוקר את הקשר בין נשימה, סטרס, גוף ותודעה.',
						'מתוך מאות תלמידים, מטופלים, סדנאות ותהליכי ליווי התגבשה בהדרגה שיטת cbDIDG.',
						'בלב השיטה עומדת הבחנה פשוטה אך חשובה:',
						'הדיג׳רידו אינו המטרה. הוא כלי עבודה.',
						'באמצעות הדיג׳רידו ובשילוב חניכה אישית מסודרת ומקצועית ניתן לפתח מודעות נשימתית עמוקה יותר, לשפר דפוסי נשימה ולסייע בהתמודדות עם סימפטומים הקשורים לסטרס כרוני.',
						'חשוב לי להדגיש שלא כל נגינה בדיג׳רידו תלמד לנשום נכון. יש ניואנסים רבים בנשימה שצריך להכיר, ולכן נדרשת למידה מדויקת והדרגתית.',
						'זו בדיוק הסיבה שבגללה פיתחתי דרך עבודה מסודרת במסגרת טיפול בדיג׳רידו ובמסגרת שיעורי דיג׳רידו, בהתאם לצורך ולמטרה של האדם שמגיע.',
					),
				),
				// SECTION 07
				array(
					'heading' => 'המרכז לטיפול בדיג׳רידו – סטודיו נשימה מעגלית פרדס חנה',
					'body'    => array(
						'אחרי שנים של הוראה, טיפול, בניית כלים ולימוד בארץ ובעולם, הבנתי שאני רוצה ליצור בית אחד שבו כל חלקי הדרך נפגשים - נשימה, דיג׳רידו, טיפול, לימוד, סאונד הילינג ובניית כלים.',
						'מתוך החזון הזה הקמתי את המרכז לטיפול בדיג׳רידו - סטודיו נשימה מעגלית פרדס חנה, במטרה לקדם, להפיץ וללמד את איכויותיו התרפויטיות של הדיג׳רידו בתחומי הגוף, הנפש והתודעה.',
						'המרכז כולל בית מלאכה לבניית דיג׳רידו בעבודת יד, סטודיו ללימוד, טיפול בדיג׳רידו וסאונד הילינג, וחצר מטופחת הכוללת שבילים, צמחייה ואוהל טיפי המשמשים כמרחב מפגש, התכווננות והעמקה.',
						'כיום פועל המרכז בארבעה צירים מרכזיים:',
						'טיפול בדיג׳רידו',
						'שיעורי דיג׳רידו ונשימה מעגלית',
						'סאונד הילינג',
						'הכשרת מטפלים ומנחים בשיטת cbDIDG',
						'אל המרכז מגיעים תלמידים ומטופלים מכל רחבי הארץ - צפון, דרום ומרכז, ללא הבדלי דת, מין, גזע, לאום ומגדר.',
						'הנשימה היא לכולם.',
					),
				),
				// SECTION 08
				array(
					'heading' => 'נשימה, מחקר והכרה מקצועית',
					'body'    => array(
						'במהלך השנים הלכה וגברה ההכרה המחקרית בדיג׳רידו ככלי בעל ערך מעבר לעולם המוזיקה.',
						'כיום קיימים מחקרים שהדגימו את תרומתו של תרגול דיג׳רידו במצבים הקשורים לנחירות ולדום נשימה חסימתי בשינה.',
						'אני מאמין שזהו רק קצה הקרחון.',
						'הנשימה שלנו משפיעה על כל מערכות הגוף, וככל שהמחקר מתקדם, כך מתרחבת גם ההבנה לגבי הקשר בין דפוסי נשימה, סטרס כרוני ואיכות החיים.',
						'בעבודה שלי, הדיג׳רידו משמש כדרך מעשית לפגוש את הנשימה, ללמוד אותה, לתרגל אותה ולהפוך אותה לכלי משמעותי יותר בחיי היומיום.',
						'למידע נוסף על טיפול בדיג׳רידו, נחירות ודום נשימה בשינה',
					),
				),
				// SECTION 09
				array(
					'heading' => 'ספרים, במה ותקשורת',
					'body'    => array(
						'לצד פעילותי בתחום הדיג׳רידו אני גם סופר, מוציא לאור ומספר סיפורים.',
						'כתבתי שלושה ספרים, הקמתי את הוצאת הספרים ״מוזה״, ויצרתי מופע סיפורים מצליח שרץ במשך שנים על במות מרכזיות ברחבי הארץ, ביניהן צוותא, הקאמרי ובית ציוני אמריקה.',
						'פעילותי כסופר, מוציא לאור, מספר סיפורים ואיש דיג׳רידו מתועדת גם בערך ותיק בוויקיפדיה, המהווה חלק ממסע חיים ארוך של יצירה, חקירה ועשייה.',
					),
				),
				// SECTION 10
				array(
					'heading' => 'הדור הבא של התחום',
					'body'    => array(
						'בשנים האחרונות הולכת ומתבהרת עבורי משימה נוספת: העברת הידע הלאה.',
						'לצד העבודה עם תלמידים ומטופלים, אני פועל להקמת מסלול הכשרת מטפלים ומנחים בשיטת cbDIDG.',
						'מטרתי היא להכשיר דור חדש של אנשי מקצוע שיוכלו להמשיך לפתח, ללמד ולהנגיש את העבודה עם נשימה ודיג׳רידו.',
						'אני מאמין שתחום הטיפול בנשימה באמצעות דיג׳רידו נמצא רק בתחילת דרכו בישראל, ושבשנים הקרובות ימשיך להתפתח ולהתרחב.',
					),
				),
				// SECTION 11
				array(
					'heading' => 'היום',
					'body'    => array(
						'אחרי יותר מ־25 שנים בתחום, אני עדיין תלמיד.',
						'אני עדיין חוקר, לומד, בונה, מלמד ומתרגש בכל פעם מחדש מהיכולת של נשימה להשפיע על חיי אדם.',
						'מה שהתחיל כחיפוש אישי אחר דרך לנשום טוב יותר, הפך לדרך חיים, לשיטה, למרכז מקצועי ולשליחות.',
						'אם הגעתם לכאן, ייתכן שגם אתם מחפשים דרך לחזור לנשום.',
						'ואם כך, אשמח לפגוש אתכם בדרך.',
					),
				),
				// SECTION 12 — לתיאום שיחת היכרות (content; the CTA band below reuses
				// this title so its heading is not flagged as an invented section).
				array(
					'heading' => 'לתיאום שיחת היכרות',
					'body'    => array(
						'אם הגעתם עד לכאן, כנראה שמשהו בדרך הזו נוגע בכם.',
						'ייתכן שאתם מחפשים שינוי בנשימה,',
						'ייתכן שאתם רוצים ללמוד לנגן בדיג׳רידו,',
						'ייתכן שאתם סקרנים לגבי שיטת cbDIDG,',
						'ואולי פשוט מרגישים שזה הזמן לעצור רגע ולהקשיב.',
						'שיחת היכרות מאפשרת להבין יחד מה נכון עבורכם:',
						'טיפול בדיג׳רידו,',
						'שיעורי דיג׳רידו,',
						'סאונד הילינג,',
						'או תהליך אישי במרכז בפרדס חנה.',
					),
				),
				// SECTION 13 — דיסקליימר.
				array(
					'heading' => 'דיסקליימר',
					'body'    => array(
						'המידע בעמוד זה אינו מהווה ייעוץ רפואי, אבחון או טיפול רפואי, ואינו מחליף פנייה לרופא או לאיש מקצוע מוסמך.',
						'במקרים של מצב רפואי, נשימתי או נפשי, יש להתייעץ עם גורם רפואי מוסמך לפני תחילת תהליך או תרגול.',
						'העבודה עם דיג׳רידו ונשימה יכולה לשמש כתהליך משלים, אישי וחווייתי, אך אינה מחליפה טיפול רפואי נדרש.',
					),
				),
			),
			'cta'      => array(
				// Heading reuses the SECTION 12 title verbatim (not an invented section);
				// the verbatim CTA link is the source CTA.
				'heading' => 'לתיאום שיחת היכרות',
				'body'    => array(),
				'label'   => 'לתיאום שיחת היכרות',
			),
		);
	}

	if ( 'moksha' === $route ) {
		// Memorial-led long-form. Lead with the dedicated memorial section
		// (sensitive copy verbatim), then biography sections + back-link tile.
		return array(
			'hero'     => array(
				'kicker'    => 'אודות · המורה',
				'title'     => 'מוקש דהימן',
				'lead'      => 'המאסטר ההודי לדיג׳רידו, מורו של אייל, והמורשת הממשיכה מרישיקש לפרדס חנה.',
				'image'     => $portrait,
				'image_alt' => 'דיוקן של אייל עמית',
			),
			'memorial' => ea_wave2_editorial_memorial(),
			'sections' => array(
				array(
					'label'   => 'הדרך',
					'heading' => 'מרישיקש לפרדס חנה',
					'lead'    => true,
					'body'    => array(
						'הקשר עם מוקש דהימן החל בשנת 2000 והפך לציר המרכזי של הדרך התרפויטית. אייל למד ממנו את העבודה עם הדיג׳רידו ככלי לנשימה ולמודעות — גישה שהוא ממשיך ומלמד עד היום בסטודיו בפרדס חנה.',
						'המורשת הזו ממשיכה בכל מפגש, בכל סדנה ובכל תרגול — נשימה אחת שמחברת בין רישיקש לפרדס חנה.',
					),
				),
			),
			'books'    => array(
				'label'   => 'המשך קריאה',
				'heading' => 'מהמרכז לדף אודות',
				'covers'  => array(),
				'tiles'   => array(
					array(
						'label' => 'אודות',
						'title' => 'חזרה לעמוד אודות אייל עמית',
						'desc'  => 'הסיפור המלא של אייל עמית, המרכז לטיפול בדיג׳רידו, וציר הזמן של הדרך.',
						'href'  => home_url( '/about/' ),
					),
					array(
						'label' => 'מוזה הוצאה לאור',
						'title' => 'לעמוד הספרים',
						'desc'  => 'ספר מסע, רומן פנטזיה, וקובץ סיפורים אוטוביוגרפי — לרכישה ישירה מהיוצר.',
						'href'  => home_url( '/books/' ),
					),
				),
			),
			'cta'      => array(
				'heading' => 'רוצים להכיר?',
				'body'    => array( 'לתיאום שיחת היכרות, ללא התחייבות.' ),
				'label'   => 'לתיאום שיחת היכרות',
			),
		);
	}

	if ( 'press' === $route ) {
		// /press: editorial shell (hero + meta) → press clippings list + FB
		// testimonials (rendered by ea_w2_07_render_press() in the render fn) →
		// books cross-link → CTA. Press body copy stays the W2-07 dataset.
		return array(
			'hero'  => array(
				'kicker'    => 'אודות · עיתונות',
				'title'     => 'עיתונות',
				'lead'      => 'אזכורים, כתבות וראיונות לאורך השנים. הקישורים נפתחים בלשונית חדשה.',
				'image'     => $portrait,
				'image_alt' => 'דיוקן של אייל עמית',
			),
			'meta'  => array(
				array( 'k' => 'פועל מאז', 'v' => '1999' ),
				array( 'k' => 'שיטה', 'v' => 'cbDIDG' ),
				array( 'k' => 'סטודיו', 'v' => 'פרדס חנה' ),
				array( 'k' => 'ספרים', 'v' => 'שלושה' ),
			),
			'books' => $books,
			'cta'   => array(
				'heading' => 'רוצים להכיר?',
				'body'    => array( 'לתיאום שיחת היכרות, ללא התחייבות.' ),
				'label'   => 'לתיאום שיחת היכרות',
			),
		);
	}

	return null;
}
