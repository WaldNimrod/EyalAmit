<?php
/**
 * WP-W2-01 Stage B — D-14 tokens, blocks, templates, analytics, CF7.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/** CF7 form post ID (create in wp-admin or via filter). */
define( 'EA_WAVE2_CF7_FORM_ID', 0 );

/** WhatsApp E.164 without + — 052-4822842 */
define( 'EA_WAVE2_WHATSAPP_E164', '972524822842' );

/**
 * Ordered POC homepage blocks (12).
 *
 * @return string[]
 */
function ea_wave2_home_block_slugs() {
	return array(
		'topnav',
		'hero',
		'breath-divider-1',
		'intro',
		'method-pillars',
		'treatment-overview',
		'testimonials-row',
		'books-row',
		'services-row',
		'faq-mini',
		'contact-cta',
		'footer-social',
	);
}

/**
 * @return bool
 */
function ea_wave2_is_active_view() {
	if ( is_page_template( array(
		'page-templates/tpl-home.php',
		'page-templates/tpl-stage-b-test.php',
		'page-templates/tpl-service.php',
		'page-templates/tpl-content.php',
		'page-templates/tpl-contact.php',
		'page-templates/tpl-faq.php',
		'page-templates/tpl-books.php',
		'page-templates/tpl-book-detail.php',
		'page-templates/tpl-shop-archive.php',
		'page-templates/tpl-shop-item.php',
		'page-templates/tpl-blog-archive.php',
		'page-templates/tpl-blog-single.php',
		'page-templates/tpl-en-landing.php',
	) ) ) {
		return true;
	}
	return (bool) get_query_var( 'ea_wave2_shell', false );
}

/**
 * Enqueue D-14 CSS + Wave2 JS.
 */
function ea_wave2_enqueue_assets() {
	if ( is_admin() || ! ea_wave2_is_active_view() ) {
		return;
	}

	$ver = wp_get_theme()->get( 'Version' );
	$dir = get_stylesheet_directory();
	$uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'ea-eyalamit-fonts-heebo',
		'https://fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'ea-wave2-tokens', $uri . '/assets/css/ea-tokens.css', array(), $ver );
	wp_enqueue_style( 'ea-wave2-animations', $uri . '/assets/css/ea-animations.css', array( 'ea-wave2-tokens' ), $ver );
	wp_enqueue_style( 'ea-wave2-atoms', $uri . '/assets/css/ea-atoms.css', array( 'ea-wave2-tokens', 'ea-wave2-animations' ), $ver );

	$js_deps = array();
	wp_enqueue_script( 'ea-wave2-entrance', $uri . '/assets/js/ea-entrance.js', $js_deps, $ver, true );
	wp_enqueue_script( 'ea-wave2-scroll', $uri . '/assets/js/ea-scroll.js', $js_deps, $ver, true );
	wp_enqueue_script( 'ea-wave2-ab-testing', $uri . '/assets/js/ea-ab-testing.js', $js_deps, $ver, true );
	wp_enqueue_script( 'ea-wave2-hero', $uri . '/assets/js/ea-hero.js', $js_deps, $ver, true );

	wp_localize_script(
		'ea-wave2-ab-testing',
		'eaWave2Ab',
		array(
			'whatsappE164' => EA_WAVE2_WHATSAPP_E164,
			'cf7FormId'    => (int) apply_filters( 'ea_wave2_cf7_form_id', EA_WAVE2_CF7_FORM_ID ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'ea_wave2_enqueue_assets', 28 );

/**
 * Render all 12 homepage blocks in POC order.
 *
 * @param bool $include_chrome If true, renders topnav before and footer after inner blocks.
 */
function ea_wave2_render_home_blocks( $include_chrome = true ) {
	$slugs = ea_wave2_home_block_slugs();
	if ( $include_chrome ) {
		get_template_part( 'template-parts/blocks/block', 'topnav' );
		echo '<main id="main" class="ea-wave2-home__main">';
		$slugs = array_values( array_diff( $slugs, array( 'topnav', 'footer-social' ) ) );
	}
	foreach ( $slugs as $slug ) {
		get_template_part( 'template-parts/blocks/block', $slug );
	}
	if ( $include_chrome ) {
		echo '</main>';
		get_template_part( 'template-parts/blocks/block', 'footer-social' );
	}
}

/**
 * CF7 shortcode for contact surfaces.
 */
function ea_wave2_render_contact_form() {
	$form_id = (int) apply_filters( 'ea_wave2_cf7_form_id', EA_WAVE2_CF7_FORM_ID );
	if ( $form_id > 0 && function_exists( 'wpcf7_contact_form' ) ) {
		echo '<div class="ea-contact-form ea-contact-form--cf7">';
		echo do_shortcode( '[contact-form-7 id="' . absint( $form_id ) . '" html_class="ea-contact-form__form" title="צור קשר"]' );
		echo '</div>';
		return;
	}
	echo '<p class="ea-contact-form__note" role="status">' . esc_html__( 'טופס צור קשר — יוגדר לאחר יצירת טופס CF7 ב־wp-admin (ראה inc/cf7-wave2-form.txt).', 'ea-eyalamit' ) . '</p>';
}

/**
 * Floating WhatsApp CTA (variant controlled by ea-ab-testing.js).
 */
function ea_wave2_render_whatsapp_float() {
	$url = 'https://wa.me/' . EA_WAVE2_WHATSAPP_E164;
	?>
	<a class="ea-whatsapp-float"
	   href="<?php echo esc_url( $url ); ?>"
	   target="_blank"
	   rel="noopener noreferrer"
	   data-ea-ab="whatsapp"
	   aria-label="<?php esc_attr_e( 'שלח הודעה בוואטסאפ (נפתח בחלון חדש)', 'ea-eyalamit' ); ?>">
		<svg class="ea-whatsapp-float__icon" aria-hidden="true" viewBox="0 0 24 24" width="24" height="24">
			<path fill="currentColor" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
			<path fill="currentColor" d="M12 0C5.373 0 0 5.373 0 12c0 2.126.553 4.122 1.522 5.855L0 24l6.293-1.499A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.891 0-3.667-.499-5.2-1.373l-.373-.222-3.735.89.921-3.617-.243-.386A9.946 9.946 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
		</svg>
		<span class="ea-whatsapp-float__label"><?php esc_html_e( 'שלח הודעה', 'ea-eyalamit' ); ?></span>
	</a>
	<?php
}
add_action( 'wp_footer', 'ea_wave2_render_whatsapp_float', 15 );

/**
 * Skip link + scroll progress (Wave2 shell).
 */
function ea_wave2_body_open_extras() {
	if ( ! ea_wave2_is_active_view() ) {
		return;
	}
	echo '<a class="ea-skiplink" href="#main">' . esc_html__( 'דלג לתוכן', 'ea-eyalamit' ) . '</a>';
	echo '<div id="ea-scroll-progress" aria-hidden="true"></div>';
}
add_action( 'wp_body_open', 'ea_wave2_body_open_extras', 5 );

/**
 * Load analytics-config.json from hub mirror or theme fallback.
 *
 * @return array<string,mixed>
 */
function ea_wave2_get_analytics_config() {
	$candidates = array(
		get_stylesheet_directory() . '/inc/analytics-config.json',
		dirname( get_stylesheet_directory(), 4 ) . '/hub/data/analytics-config.json',
	);
	foreach ( $candidates as $path ) {
		if ( is_readable( $path ) ) {
			$json = json_decode( (string) file_get_contents( $path ), true );
			if ( is_array( $json ) ) {
				return $json;
			}
		}
	}
	return array();
}

/**
 * GA4 + Clarity in head (scaffold when PENDING_CREDENTIALS).
 */
function ea_wave2_print_analytics_head() {
	$cfg  = ea_wave2_get_analytics_config();
	$ga4  = isset( $cfg['ga4']['measurement_id'] ) ? (string) $cfg['ga4']['measurement_id'] : '';
	$clar = isset( $cfg['clarity']['project_id'] ) ? (string) $cfg['clarity']['project_id'] : '';

	$pending = ( $ga4 === '' || $ga4 === '__PENDING_EYAL__' || $clar === '' || $clar === '__PENDING_EYAL__' );
	if ( $pending ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( 'ea_wave2 analytics: credentials missing — analytics inactive (hub/data/analytics-config.json)' );
		}
		return;
	}

	$ga4  = preg_replace( '/[^A-Z0-9-]/i', '', $ga4 );
	$clar = preg_replace( '/[^a-z0-9]/i', '', $clar );
	if ( $ga4 === '' || $clar === '' ) {
		return;
	}
	?>
	<!-- EA Wave2 Analytics — GA4 -->
	<script async src="<?php echo esc_url( 'https://www.googletagmanager.com/gtag/js?id=' . $ga4 ); ?>"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', '<?php echo esc_js( $ga4 ); ?>');
	</script>
	<!-- EA Wave2 Analytics — Clarity -->
	<script>
	(function(c,l,a,r,i,t,y){
		c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
		t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
		y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
	})(window, document, "clarity", "script", "<?php echo esc_js( $clar ); ?>");
	</script>
	<?php
}
add_action( 'wp_head', 'ea_wave2_print_analytics_head', 20 );

/**
 * Register Wave2 page templates for template_include routing.
 *
 * @param string $template Template path.
 * @return string
 */
function ea_wave2_template_router( $template ) {
	$map = array(
		'stage-b-test' => 'tpl-stage-b-test.php',
	);
	if ( is_page() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			if ( isset( $map[ $post->post_name ] ) ) {
				$candidate = get_stylesheet_directory() . '/page-templates/' . $map[ $post->post_name ];
				if ( is_readable( $candidate ) ) {
					return $candidate;
				}
			}
		}
	}
	return $template;
}
add_filter( 'template_include', 'ea_wave2_template_router', 90 );

/**
 * @param string[] $classes Body classes.
 * @return string[]
 */
function ea_wave2_body_class( $classes ) {
	if ( ea_wave2_is_active_view() ) {
		$classes[] = 'ea-wave2-shell';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_wave2_body_class', 97 );
