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
		'testimonials-carousel',
		'books-row',
		'services-row',
		'faq-mini',
		'bio',
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
		'page-templates/tpl-qr.php',
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

	// WP-W2-16-B — testimonials carousel atom (D-EYAL-TESTIMONIALS-14 = א); Home + service routes.
	wp_enqueue_style( 'ea-testimonials-carousel', $uri . '/assets/css/testimonials-carousel.css', array( 'ea-wave2-atoms' ), $ver );

	/*
	 * Mobile chrome foundation (WP-W2-14-A). The drawer/canonical-footer sheet
	 * loads AFTER ea-atoms so the <=1023px bar-normalisation wins specificity
	 * ties; the §4 variants sheet loads after it. The drawer behaviour JS is
	 * deferred and self-degrades when the chrome is absent. THIS ENQUEUE BLOCK
	 * IS OWNED BY WP-W2-14-A — child WPs (B/C/D/E) must not edit these lines.
	 */
	wp_enqueue_style( 'ea-mobile-nav', $uri . '/assets/css/ea-mobile-nav.css', array( 'ea-wave2-atoms' ), $ver );
	wp_enqueue_style( 'ea-mobile-variants', $uri . '/assets/css/ea-mobile-variants.css', array( 'ea-mobile-nav' ), $ver );

	$js_deps = array();
	wp_enqueue_script( 'ea-wave2-entrance', $uri . '/assets/js/ea-entrance.js', $js_deps, $ver, true );
	wp_enqueue_script( 'ea-wave2-scroll', $uri . '/assets/js/ea-scroll.js', $js_deps, $ver, true );
	wp_enqueue_script( 'ea-wave2-ab-testing', $uri . '/assets/js/ea-ab-testing.js', $js_deps, $ver, true );
	wp_enqueue_script( 'ea-wave2-hero', $uri . '/assets/js/ea-hero.js', $js_deps, $ver, true );
	wp_enqueue_script( 'ea-mobile-nav', $uri . '/assets/js/ea-mobile-nav.js', $js_deps, $ver, true );

	wp_localize_script(
		'ea-wave2-ab-testing',
		'eaWave2Ab',
		array(
			'whatsappE164' => EA_WAVE2_WHATSAPP_E164,
			'cf7FormId'    => (int) apply_filters( 'ea_wave2_cf7_form_id', EA_WAVE2_CF7_FORM_ID ),
		)
	);

	/*
	 * WP-W2-14-C — Home elevation review-fixes. Home-scoped layout sheet
	 * (media rows + testimonials rotator) + the rotator behaviour JS. These
	 * load only on the Home template and are independent of the 14-A
	 * mobile-asset enqueues above. Do not move them into that block.
	 */
	if ( is_page_template( 'page-templates/tpl-home.php' ) ) {
		wp_enqueue_style( 'ea-wave2-home-front', $uri . '/assets/css/home-front.css', array( 'ea-wave2-atoms' ), $ver );
		wp_enqueue_script( 'ea-wave2-testimonials', $uri . '/assets/js/ea-testimonials.js', $js_deps, $ver, true );
	}
}
add_action( 'wp_enqueue_scripts', 'ea_wave2_enqueue_assets', 28 );

/**
 * Perf: dequeue WordPress / plugin styles that are never used on Wave2
 * templates. Cuts render-blocking inline + linked CSS on /wave2-test/
 * and future Wave2 content pages. Runs late so other plugins finish
 * registering first.
 *
 * Targets (none of these are referenced by Wave2 markup):
 *   - wp-block-library  / wp-block-library-theme  (Gutenberg block CSS)
 *   - classic-theme-styles (legacy classic-editor styles)
 *   - wp-emoji-styles-inline-css (inline; handle is 'wp-emoji-styles')
 *   - global-styles (FSE global styles when block theme unused)
 *   - contact-form-7  (only Wave2 contact CTA uses CF7 — keep on contact pages
 *     by checking the block-contact-cta marker via has_block / template name)
 */
function ea_wave2_dequeue_unused_styles() {
	if ( is_admin() || ! ea_wave2_is_active_view() ) {
		return;
	}

	// Gutenberg block library is not used by Wave2 markup.
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'global-styles' );
	wp_deregister_style( 'global-styles' );

	// CF7 is only needed on the contact page. Detect by page slug because
	// W2-02 force-routes templates without assigning template meta.
	if ( ! is_page( 'contact' ) ) {
		wp_dequeue_style( 'contact-form-7' );
		wp_dequeue_script( 'contact-form-7' );
		wp_dequeue_script( 'google-recaptcha' );
	}
}
add_action( 'wp_enqueue_scripts', 'ea_wave2_dequeue_unused_styles', 999 );

/**
 * Stop Contact Form 7 from enqueuing its CSS/JS anywhere except the contact
 * page. wp_dequeue can lose to dependency chains / global enqueue, so use CF7's
 * own native load filters to block the assets at the source. Safe: no page
 * other than /contact/ renders a CF7 form (form ID is contact-only).
 */
add_filter( 'wpcf7_load_css', function ( $load ) { return is_page( 'contact' ) ? $load : false; } );
add_filter( 'wpcf7_load_js', function ( $load ) { return is_page( 'contact' ) ? $load : false; } );

/**
 * Perf: suppress wp-emoji detection script + inline styles on Wave2 templates.
 * Must run at init (before WP hooks print_emoji_detection_script onto wp_head).
 */
function ea_wave2_disable_emojis() {
	if ( is_admin() ) {
		return;
	}
	// Defer the check until 'wp' (when query is resolved) so ea_wave2_is_active_view works.
	add_action( 'wp', function () {
		if ( ! ea_wave2_is_active_view() ) {
			return;
		}
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	} );
}
add_action( 'init', 'ea_wave2_disable_emojis' );

/**
 * Set the per-block context that drives the Home review-fix elevations
 * (WP-W2-14-C). Each block already reads an optional `*_ctx` query var and
 * falls back to its hardcoded defaults when absent, so these additions are
 * backward-compatible — only the Home render opts in to the elevated shapes.
 *
 * Review fixes (DELTA §B):
 *   1. intro  → two-column media row (text + labelled placeholder figure).
 *   2. bio    → portrait media row using eyal-portrait-hero.jpg.
 *   3. testimonials → auto-advancing 1-up rotator (5 named real quotes).
 */
function ea_wave2_set_home_block_context() {
	$uri = get_stylesheet_directory_uri();

	/*
	 * WP-W2-15-CR1 — home render carries Eyal's homepage source VERBATIM
	 * (docs/.../דף הבית/homepage1-3 v2.md), every SECTION 01–12 in order.
	 * Punctuation matches the source exactly (hyphen "-" not em-dash, geresh).
	 */

	set_query_var( 'ea_hero_ctx', array(
		'title'    => "המרכז לטיפול בנשימה באמצעות דיג׳רידו - שיטת cbDIDG של אייל עמית",
		'subtitle' => "להחזיר שליטה על הנשימה דרך עבודה עם דיג׳רידו, תרגול נשימה וליווי אישי<br>בגישה טיפולית מבוססת דיג׳רידו ובהשראת חניכה אישית אצל מוקש דהימן",
		'trust'    => "אייל עמית · פועל מאז 1999 · מהוותיקים בארץ בתחום<br>מטפל ומלמד בשיטה שפותחה לאורך השנים · בונה כלים בעבודת יד",
		'ctas'     => array(
			array( 'label' => 'לתיאום שיחת היכרות', 'href' => home_url( '/contact' ), 'variant' => 'ghost-white' ),
		),
		// WP-W2-16-A — muted full-length background loop + poster (D-EYAL-VIDEO-13 = ב).
		// 720p H.264 (6.1MB) covers the gradient on Home only; reduced-motion → poster.
		'video'    => array(
			'poster'  => $uri . '/assets/video/ea-home-hero-poster.jpg',
			'sources' => array(
				array( 'src' => $uri . '/assets/video/ea-home-hero-720-muted.mp4', 'type' => 'video/mp4' ),
			),
		),
	) );

	// SECTION 02 — מה זה טיפול בנשימה באמצעות דיג׳רידו (verbatim source body).
	set_query_var( 'ea_intro_ctx', array(
		'heading' => "מה זה טיפול בנשימה באמצעות דיג׳רידו",
		'body'    => array(
			"בטיפול בנשימה באמצעות דיג׳רידו, הדיג׳רידו הוא כלי עבודה על הנשימה - לא המטרה עצמה.",
			"יש הבדל בין טכניקת הנשימה המעגלית, המשמשת בזמן נגינה בדיג׳רידו, לבין הנשימה היומיומית הרגילה של האדם.",
			"העבודה עם הדיג׳רידו משפיעה על שתיהן, אך הכוונה היא להשפיע על הנשימה ביומיום - זו שמלווה את האדם לאורך כל היום וגם בזמן השינה.",
			"בטיפול נוצר קשר הדוק ומודע עם הנשימה היומיומית. אנו לומדים לשלוט בה, לחזק ולווסת אותה, והכל דרך תרגול מעשי של נגינה בדיג׳רידו.",
			"הנגינה בדיג׳רידו מתפתחת לאורך התהליך, ונשארת אמצעי - לא המטרה.",
			"המטרה היא לא רק להבין את הנשימה היומיומית, אלא ליצור בה שינוי שנמשך גם מחוץ למפגש. שינוי שמשפיע על איכות החיים לטווח הארוך, ועשוי להפחית סימפטומים ולשפר מדדים בריאותיים.",
			"מי שירצה בהמשך להעמיק גם בפן המוזיקלי, יוכל לעשות זאת ביתר קלות, על בסיס עבודה נשימתית יציבה ומדויקת.",
			"יש דרכים שונות לעבוד עם הנשימה, והדיג׳רידו מציע דרך אחרת, חווייתית, חיה ומעניינת, שמשלבת תרגול עם צליל ונגינה והופכת את העבודה עם הנשימה למשהו שקל יותר להתמיד בו.",
		),
	) );

	// SECTION 06 — איך מתחילים (soft intro CTA), carried by the pillars block.
	// The source lines are short; rendered as pillar bodies (no titles) so the
	// data-driven path is used (avoids the hardcoded default-pillars fallback).
	set_query_var( 'ea_pillars_ctx', array(
		'heading'     => 'איך מתחילים',
		'show_titles' => false,
		'items'       => array(
			array( 'text' => 'אפשר להתחיל בשיחת היכרות קצרה, להבין את הצורך ולבדוק התאמה.' ),
			array( 'text' => 'השיחה מאפשרת לשאול שאלות ולקבל כיוון ראשוני.' ),
			array( 'text' => 'אין צורך להתחייב מראש לתהליך.' ),
		),
		'cta'         => array( 'label' => 'לתיאום שיחת היכרות', 'href' => home_url( '/contact' ) ),
	) );

	// SECTION 11 — אייל עמית (verbatim bio body).
	set_query_var( 'ea_bio_ctx', array(
		'wrap_class' => 'ea-home-mediarow--portrait',
		'heading'    => 'אייל עמית',
		'body'       => array(
			"העבודה של אייל עמית עם נשימה ודיג׳רידו התחילה מתוך משיכה לצליל המיוחד של הכלי.",
			'רק בהמשך הדרך, לאחר שנים של למידה אצל המאסטר ההודי מוקש דהימן, התבהר הקשר בין הנשימה למערכות הגוף.',
			'מתוך התרגול והחקירה העצמית, התגלה גם הקשר הישיר לנשימה – וליכולת להשפיע על אסטמה, אלרגיות ומצבים נוספים.',
			'בהדרגה חל שינוי משמעותי במצב הבריאותי – מערכת הנשימה התחזקה והתסמינים פחתו עד שנעלמו.',
			'התהליך הזה חוזר על עצמו אצל רבים מהאנשים שמבקשים "רק ללמוד לנגן בדיג׳רידו". הם מגיעים מתוך סקרנות או משיכה לצליל, ורק בהמשך תוך כדי התהליך מתחילים להבין עד כמה הנשימה קשורה לסימפטומים מסוימים שמהם הם סובלים.',
			'הרקע ההנדסי של אייל איפשר לו לפרק תהליכים מורכבים לשיטה ברורה וישימה.',
			"את המרכז לטיפול בדיג׳רידו הקים מתוך רצון לקדם, להנגיש וללמד את העבודה עם הדיג׳רידו ככלי להשפעה על הגוף, הנשימה והתודעה.",
		),
		'image'      => $uri . '/assets/images/eyal-portrait-hero.jpg',
		'image_alt'  => 'אייל עמית',
		'image_cap'  => 'דיוקן אייל עמית',
	) );

	// SECTION 10 — עדויות והמלצות. All 15 testimonials VERBATIM, each name linked
	// to its original post (opens in new tab). Carousel via the rotator flag.
	set_query_var( 'ea_testimonials_ctx', array(
		'heading'    => 'עדויות והמלצות',
		'aria_label' => 'עדויות והמלצות',
		'rotator'    => true,
		'items'      => array(
			array( 'text' => "אייל עמית הציל אותנו ובזכותו חזרנו כולנו לנשום…\nנשימה היא הבסיס להכל\nאפשר ללמוד לנשום מחדש", 'name' => 'חיה עזריה', 'href' => 'https://www.facebook.com/share/v/18Ua5NoWv4/' ),
			array( 'text' => "גיליתי מסע עוצמתי של נשימה, שקט וחיבור לעצמי\nמעבר לסידור הנשימה שמסדר את הנשמה, קיבלתי גם השקטה של הראש\nזו מתנה לחיים", 'name' => 'שירי אלקבץ', 'href' => 'https://www.facebook.com/share/p/1E7ndvYyrp/' ),
			array( 'text' => "אני לומדת לנשום מחדש\nלהיות בנוכחות בנשימה זה להיות בנוכחות בחיים\nזה משהו שמחלחל לכל תחום ביום יום", 'name' => 'נוית צוף שטראוס', 'href' => 'https://www.facebook.com/share/p/1AdaytsL6w/' ),
			array( 'text' => "פעם ראשונה בחיים שלמדתי לנשום נכון\nאין לנו מושג בכלל כמה אנחנו לא נושמים נכון\nזה פתח לי עולם של שקט", 'name' => 'אלון גרזון רז', 'href' => 'https://www.facebook.com/share/v/1Cky28MdtH/' ),
			array( 'text' => "חיבור חדש למערכת הנשימה שלי\nהעבודה משפיעה על הגוף, הנשימה והתודעה\nכמעט לא משתמש במשאף מאז שהתחלתי", 'name' => "ירון סאנצ׳ו גושן", 'href' => 'https://www.facebook.com/share/v/1FosYpULUC/' ),
			array( 'text' => "זו כנראה המתנה הכי טובה שנתתי לעצמי\nהנשימה נפתחת עוד ועוד\nזו חוויה שהיא הרבה מעבר ללמידה", 'name' => 'ענת קרמנר ויינשטיין', 'href' => 'https://www.facebook.com/share/p/1DzVcWpAJH/' ),
			array( 'text' => "הלימוד פתח לי רובד נשימתי חדש\nחיבר אותי לרפואה הפנימית שיש בכולנו\nלהגיע לסטודיו זו מתנה אדירה", 'name' => 'קרין טננצאפ', 'href' => 'https://www.facebook.com/share/p/18Ks7D2HQD/' ),
			array( 'text' => "זו לא רק למידת כלי נגינה\nזו דרך עוצמתית לגלות את כוחה של הנשימה\nכל מפגש משאיר אותי ממוקדת ורגועה", 'name' => 'אלכס פלופ', 'href' => 'https://www.facebook.com/share/p/18Z6mqzCuj/' ),
			array( 'text' => "הנשימה משפיעה על איכות החיים\nהקשבה לנשימה משנה חיים ומורידה סטרס\nממליץ בחום על אייל", 'name' => 'אלכס פסטרנק', 'href' => 'https://www.facebook.com/share/p/1PDkhtFZ4t/' ),
			array( 'text' => "אחת החוויות המיוחדות שעברתי\nהגוף מסתנכרן עם הצלילים\nחוויה חלומית", 'name' => 'רוית יונה בניהו', 'href' => 'https://www.facebook.com/share/p/1EYoGyKsiH/' ),
			array( 'text' => "מטלטל, נעים ומעיף בו זמנית\nסאונד הילינג ברמה גבוהה מאוד\nחוויה חזקה מאוד", 'name' => 'לירן קלינה', 'href' => 'https://www.facebook.com/share/p/1GoxG1xRKx/' ),
			array( 'text' => "נכנסתי לעולם אחר לגמרי\nעטופה בצלילים ובשקט עמוק\nחוויה שנשארת גם אחרי", 'name' => 'שרון לוסקי', 'href' => 'https://www.facebook.com/share/p/1DrzXzvXjA/' ),
			array( 'text' => "למדתי שאני בכלל לא יודעת לנשום נכון\nזה היה שוק להבין כמה זה משפיע על הגוף\nאני בתוך התהליך ונהנית ממנו", 'name' => 'גלית מילר', 'href' => 'https://www.facebook.com/share/v/1H6Z937hZ1/' ),
			array( 'text' => "מסע זוגי מדיטטיבי ועוצמתי\nיצאנו בהיי\nחוויה אינטימית ומיוחדת", 'name' => 'ליה גלפנד', 'href' => 'https://www.facebook.com/share/p/18WepdnZu6/' ),
			array( 'text' => "עפתי לחלל וטבעתי באמבטיית צלילים\nהרגשתי עטופה ובטוחה\nחוויה מאוד עוצמתית", 'name' => 'רתם פרץ', 'href' => 'https://www.facebook.com/share/p/1CdeS2kWm7/' ),
		),
		'footer'     => array( 'label' => 'לכל ההמלצות', 'href' => home_url( '/media' ) ),
	) );

	// SECTION 12 — CTA סופי (closing band, verbatim). Structural label "CTA סופי"
	// rendered as an sr-only identifier so section coverage matches verbatim.
	set_query_var( 'ea_cta_ctx', array(
		'variant'    => 'band',
		'heading'    => 'מתחילים בצעד פשוט',
		'aria_label' => 'CTA סופי',
		'body'       => array(
			'אם אתם מרגישים שהגיע הזמן להתחבר לנשימה שלכם, לחזק אותה, לווסת אותה ולהיכנס לתהליך הדרגתי, חווייתי ומהנה – אפשר להתחיל בצעד פשוט.',
		),
		'cta'        => array( 'label' => 'לתיאום שיחת היכרות', 'href' => home_url( '/contact' ) ),
	) );
}

/**
 * Render all homepage blocks in POC order.
 *
 * @param bool $include_chrome If true, renders topnav before and footer after inner blocks.
 */
function ea_wave2_render_home_blocks( $include_chrome = true ) {
	ea_wave2_set_home_block_context();
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

	// W1-01: GA4 and Clarity fire INDEPENDENTLY. GA4 must not wait on the still-pending
	// Clarity id — decoupling the gate makes conversion measurement live now.
	$ga4_ok  = ( $ga4 !== '' && $ga4 !== '__PENDING_EYAL__' );
	$clar_ok = ( $clar !== '' && $clar !== '__PENDING_EYAL__' );
	if ( $ga4_ok ) {
		$ga4 = preg_replace( '/[^A-Z0-9-]/i', '', $ga4 );
	}
	if ( $clar_ok ) {
		$clar = preg_replace( '/[^a-z0-9]/i', '', $clar );
	}
	$ga4_ok  = $ga4_ok && $ga4 !== '';
	$clar_ok = $clar_ok && $clar !== '';

	if ( ! $ga4_ok && ! $clar_ok ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( 'ea_wave2 analytics: no valid GA4/Clarity id — analytics inactive (analytics-config.json)' );
		}
		return;
	}

	if ( $ga4_ok ) {
		?>
	<!-- EA Wave2 Analytics — GA4 -->
	<script async src="<?php echo esc_url( 'https://www.googletagmanager.com/gtag/js?id=' . $ga4 ); ?>"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', '<?php echo esc_js( $ga4 ); ?>');
	</script>
		<?php
	}
	if ( $clar_ok ) {
		?>
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
