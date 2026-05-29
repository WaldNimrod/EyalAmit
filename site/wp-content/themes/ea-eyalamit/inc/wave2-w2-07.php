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
	<section class="ea-section ea-press" data-block="press" aria-label="עיתונות">
		<div class="ea-section__inner">
			<h1 class="ea-section__heading ea-entrance--breath">עיתונות</h1>
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
