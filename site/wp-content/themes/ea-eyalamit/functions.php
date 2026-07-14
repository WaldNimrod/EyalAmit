<?php
/**
 * Child theme for GeneratePress — ea-eyalamit
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * האם קובץ style.css של תבנית האב (GeneratePress) קיים בדיסק.
 *
 * @return bool
 */
function ea_eyalamit_generatepress_parent_style_readable() {
	$path = get_parent_theme_file_path( 'style.css' );
	return is_string( $path ) && is_readable( $path );
}

/**
 * כאשר GeneratePress לא מותקנת (למשל מאגר עם child בלבד), רישום handle ריק ל־`generate-style`
 * כדי שלא יישברו תלויות ב־wp_enqueue_style של child / Wave1 / דף בית.
 */
function ea_eyalamit_shim_generatepress_style_handle() {
	if ( wp_style_is( 'generate-style', 'registered' ) || wp_style_is( 'generate-style', 'enqueued' ) ) {
		return;
	}
	if ( ea_eyalamit_generatepress_parent_style_readable() ) {
		return;
	}
	wp_register_style( 'generate-style', false, array(), null );
	wp_enqueue_style( 'generate-style' );
}
add_action( 'wp_enqueue_scripts', 'ea_eyalamit_shim_generatepress_style_handle', 4 );

/**
 * מעטפת טיפוגרפיה ופריסה כשאין תבנית אב — בסיס לתדמית ולייבוא תוכן.
 */
function ea_eyalamit_enqueue_theme_shell_fallback() {
	if ( is_admin() || ea_eyalamit_generatepress_parent_style_readable() ) {
		return;
	}
	wp_enqueue_style(
		'ea-eyalamit-theme-shell-fallback',
		get_stylesheet_directory_uri() . '/assets/css/theme-shell-fallback.css',
		array( 'ea-eyalamit-style', 'ea-eyalamit-fonts-rubik' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'ea_eyalamit_enqueue_theme_shell_fallback', 23 );

/**
 * Load textdomain for child theme strings.
 */
function ea_eyalamit_setup() {
	load_child_theme_textdomain( 'ea-eyalamit', get_stylesheet_directory() . '/languages' );
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'ea_eyalamit_setup' );

/**
 * מיקום תפריט פוטר — מולא ע״י MU סנכרון עץ (M2 Footer EA).
 */
function ea_eyalamit_register_nav_menus() {
	register_nav_menus(
		array(
			'primary'         => __( 'תפריט ראשי (M2 Primary EA — כמו GeneratePress)', 'ea-eyalamit' ),
			'ea_footer_legal' => __( 'EA Footer — קטלוגים ומשפטי', 'ea-eyalamit' ),
		)
	);
}
add_action( 'after_setup_theme', 'ea_eyalamit_register_nav_menus', 11 );

/**
 * פוטר: FAQ, גלריות, המלצות, פרטיות, נגישות, תקנון (site-tree).
 */
function ea_eyalamit_render_footer_legal_nav() {
	if ( ! has_nav_menu( 'ea_footer_legal' ) ) {
		return;
	}
	// The /en landing renders its own English footer nav inline (tpl-en-landing.php).
	// Suppress this Hebrew catalogs/legal menu there so the EN page footer stays
	// fully English (WP-W2-14-B EN chrome consistency; QA F-EN-footer).
	if ( is_page( 'en' ) ) {
		return;
	}
	echo '<nav class="ea-footer-legal-nav" aria-label="' . esc_attr__( 'קישורי פוטר — קטלוגים ומסמכים משפטיים', 'ea-eyalamit' ) . '">';
	wp_nav_menu(
		array(
			'theme_location' => 'ea_footer_legal',
			'container'      => false,
			'menu_class'     => 'ea-footer-legal-menu',
			'depth'          => 1,
			'fallback_cb'    => false,
		)
	);
	echo '</nav>';
}
add_action( 'generate_before_footer', 'ea_eyalamit_render_footer_legal_nav', 6 );

/**
 * EN בהדר בלבד — לא בתפריט הראשי (site-tree st-en).
 */
function ea_eyalamit_header_en_link() {
	if ( is_page( 'en' ) ) {
		return;
	}
	printf(
		'<span class="ea-header-en-wrap"><a class="ea-header-en-link" href="%1$s" hreflang="en" lang="en" aria-label="%2$s">EN</a></span>',
		esc_url( home_url( '/en/' ) ),
		esc_attr__( 'English — עמוד באנגלית', 'ea-eyalamit' )
	);
}
add_action( 'generate_inside_navigation', 'ea_eyalamit_header_en_link', 99 );

/**
 * Enqueue child stylesheet after GeneratePress parent.
 */
function ea_eyalamit_enqueue_styles() {
	wp_enqueue_style(
		'ea-eyalamit-style',
		get_stylesheet_uri(),
		array( 'generate-style' ),
		wp_get_theme()->get( 'Version' )
	);

	/* Rubik — דף בית + שאר העמודים (M3-M4 ליטוש מבני). */
	if ( ! is_admin() ) {
		wp_enqueue_style(
			'ea-eyalamit-fonts-rubik',
			'https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap',
			array(),
			null
		);
	}

}
add_action( 'wp_enqueue_scripts', 'ea_eyalamit_enqueue_styles', 20 );

/**
 * פלטה מאושרת ב־:root + דריסת משתני צבע GeneratePress (אחרי dynamic CSS של GP).
 * תיקון הערת QA-M4: מניעת דליפת --accent:#1e73be וכו׳.
 *
 * @return void
 */
function ea_eyalamit_enqueue_palette_root_overrides() {
	$css = ':root{'
		. '--eyal-sand:#d8c7b5;'
		. '--eyal-terracotta:#a44e2b;'
		. '--eyal-earth:#8a5a44;'
		. '--eyal-olive:#6e6f4a;'
		. '--eyal-ink:#2e2b28;'
		. '--eyal-chocolate:#5c3a2e;'
		. '--eyal-brick:#ab3a2b;'
		. '--eyal-accent-rgb:164,78,43;'
		. '--accent:var(--eyal-terracotta);'
		. '--accent-hover:var(--eyal-brick);'
		. '--contrast:var(--eyal-ink);'
		. '--contrast-2:var(--eyal-chocolate);'
		. '--contrast-3:var(--eyal-earth);'
		. '}';
	wp_add_inline_style( 'ea-eyalamit-style', $css );
}
add_action( 'wp_enqueue_scripts', 'ea_eyalamit_enqueue_palette_root_overrides', 100 );

/**
 * Preconnect to Google Fonts (Rubik) בחזית.
 */
function ea_eyalamit_font_preconnect( $urls, $relation_type ) {
	if ( 'preconnect' !== $relation_type || is_admin() ) {
		return $urls;
	}
	$urls[] = array(
		'href' => 'https://fonts.googleapis.com',
	);
	$urls[] = array(
		'href'          => 'https://fonts.gstatic.com',
		'crossorigin'   => 'anonymous',
	);
	return $urls;
}
add_filter( 'wp_resource_hints', 'ea_eyalamit_font_preconnect', 10, 2 );

/**
 * Body class for EN + M4 polish scope.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function ea_eyalamit_body_class( $classes ) {
	if ( is_page( 'en' ) || is_page( 'english' ) ) {
		$classes[] = 'ea-lang-en';
		/* תיקון הערת QA-M4: האתר RTL אבל עמוד EN — בלי מחלקת rtl על body. */
		$classes = array_values( array_diff( $classes, array( 'rtl' ) ) );
		$classes[] = 'ltr';
	}
	if ( ! is_admin() ) {
		$classes[] = 'ea-m4-polish';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_eyalamit_body_class', 99 );

/**
 * ברירת מחדל: עברית RTL (כשאין תבנית GP מלאה, לעיתים נשאר en-US).
 *
 * @param string $output Default attributes.
 * @return string
 */
function ea_eyalamit_hebrew_language_attributes( $output ) {
	if ( is_page( 'en' ) || is_page( 'english' ) ) {
		return $output;
	}
	$out = $output;
	if ( strpos( $out, 'lang="en-US"' ) !== false ) {
		$out = str_replace( 'lang="en-US"', 'lang="he-IL"', $out );
	}
	if ( strpos( $out, 'dir=' ) === false ) {
		$out = 'dir="rtl" ' . $out;
	}
	return $out;
}
add_filter( 'language_attributes', 'ea_eyalamit_hebrew_language_attributes', 5 );

/**
 * עמוד EN: lang/dir ברמת המסמך (תיקון F-04 דוח 50).
 *
 * @param string $output Default attributes.
 * @return string
 */
function ea_eyalamit_en_language_attributes( $output ) {
	if ( is_page( 'en' ) ) {
		return 'lang="en" dir="ltr"';
	}
	return $output;
}
add_filter( 'language_attributes', 'ea_eyalamit_en_language_attributes', 20 );

/**
 * M3 — רישום CPT לאינסטנסי FAQ, גלריות והמלצות (קטלוג מרכזי).
 */
function ea_eyalamit_register_m3_instance_cpts() {
	$base = array(
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'capability_type'     => 'post',
		'hierarchical'        => false,
		'menu_icon'           => 'dashicons-list-view',
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
	);

	register_post_type(
		'ea_faq',
		array_merge(
			$base,
			array(
				'labels'       => array(
					'name'          => __( 'שאלות נפוצות (אינסטנסים)', 'ea-eyalamit' ),
					'singular_name' => __( 'שאלה נפוצה', 'ea-eyalamit' ),
					'add_new_item'  => __( 'הוספת שאלה', 'ea-eyalamit' ),
					'edit_item'     => __( 'עריכת שאלה', 'ea-eyalamit' ),
				),
				'rewrite'      => array( 'slug' => 'faq-item', 'with_front' => false ),
				'menu_position' => 22,
			)
		)
	);

	register_post_type(
		'ea_gallery',
		array_merge(
			$base,
			array(
				'labels'       => array(
					'name'          => __( 'גלריות (אינסטנסים)', 'ea-eyalamit' ),
					'singular_name' => __( 'גלריה', 'ea-eyalamit' ),
					'add_new_item'  => __( 'הוספת גלריה', 'ea-eyalamit' ),
					'edit_item'     => __( 'עריכת גלריה', 'ea-eyalamit' ),
				),
				'rewrite'      => array( 'slug' => 'gallery-item', 'with_front' => false ),
				'menu_position' => 23,
			)
		)
	);

	register_post_type(
		'ea_testimonial',
		array_merge(
			$base,
			array(
				'labels'       => array(
					'name'          => __( 'המלצות / מדיה (אינסטנסים)', 'ea-eyalamit' ),
					'singular_name' => __( 'המלצה', 'ea-eyalamit' ),
					'add_new_item'  => __( 'הוספת המלצה', 'ea-eyalamit' ),
					'edit_item'     => __( 'עריכת המלצה', 'ea-eyalamit' ),
				),
				'rewrite'       => array( 'slug' => 'testimonial-item', 'with_front' => false ),
				'menu_position' => 24,
			)
		)
	);

	register_taxonomy(
		'ea_testimonial_cat',
		array( 'ea_testimonial' ),
		array(
			'labels'            => array(
				'name'          => __( 'קטגוריות המלצה / מדיה', 'ea-eyalamit' ),
				'singular_name' => __( 'קטגוריה', 'ea-eyalamit' ),
			),
			'public'            => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'testimonial-cat', 'with_front' => false ),
		)
	);

	register_taxonomy(
		'ea_faq_cat',
		array( 'ea_faq' ),
		array(
			'labels'             => array(
				'name'          => __( 'קטגוריות שאלות נפוצות', 'ea-eyalamit' ),
				'singular_name' => __( 'קטגוריה', 'ea-eyalamit' ),
			),
			'public'             => false, // WP-CANON T2 — no public term archives; hierarchical UI only.
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_rest'       => true,
			'show_admin_column'  => true,
			'hierarchical'       => true,
			'rewrite'            => false,
		)
	);
}
add_action( 'init', 'ea_eyalamit_register_m3_instance_cpts', 9 );

/**
 * רינדור רשימת אינסטנסים בעמוד קטלוג (M3).
 *
 * @param string $post_type סוג פוסט רשום.
 * @param array  $args      אפשרויות: show_thumb (bool).
 */
function ea_eyalamit_render_instance_catalog( $post_type, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'show_thumb' => true,
			'tax_query'  => null,
		)
	);

	$qargs = array(
		'post_type'      => $post_type,
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
		'no_found_rows'  => true,
	);
	if ( ! empty( $args['tax_query'] ) && is_array( $args['tax_query'] ) ) {
		$qargs['tax_query'] = $args['tax_query'];
	}

	$q = new WP_Query( $qargs );

	if ( ! $q->have_posts() ) {
		echo '<p class="ea-catalog-empty">' . esc_html__( 'אין פריטים מפורסמים בקטלוג עדיין.', 'ea-eyalamit' ) . '</p>';
		return;
	}

	echo '<ul class="ea-instance-catalog" role="list">';
	while ( $q->have_posts() ) {
		$q->the_post();
		$link = get_permalink();
		echo '<li class="ea-instance-catalog__item">';
		if ( $args['show_thumb'] && has_post_thumbnail() ) {
			$thumb_id = get_post_thumbnail_id();
			$alt        = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
			if ( $alt === '' || $alt === false ) {
				$alt = get_the_title();
			}
			echo '<a class="ea-instance-catalog__thumb" href="' . esc_url( $link ) . '">';
			echo get_the_post_thumbnail( get_the_ID(), 'medium', array( 'alt' => $alt ) );
			echo '</a>';
		}
		echo '<div class="ea-instance-catalog__body">';
		echo '<h2 class="ea-instance-catalog__title"><a href="' . esc_url( $link ) . '">' . esc_html( get_the_title() ) . '</a></h2>';
		if ( has_excerpt() ) {
			echo '<div class="ea-instance-catalog__excerpt">' . wp_kses_post( get_the_excerpt() ) . '</div>';
		}
		echo '</div></li>';
	}
	echo '</ul>';
	wp_reset_postdata();
}

/**
 * כל מונחי ea_faq_cat כ-[slug => name], לפי סדר-יצירה (term_id ASC) — תואם
 * לסדר שבו סקריפט ה-migration יוצר את המונחים, כדי לשמר את סדר-התצוגה הקיים
 * היום ב-/faq בלי תלות בפלאגין מיון נוסף. WP-CANON T2.
 *
 * @return array<string,string> slug => name
 */
function ea_faq_get_categories() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$cache = array();
	$terms = get_terms(
		array(
			'taxonomy'   => 'ea_faq_cat',
			'hide_empty' => false,
			'orderby'    => 'term_id',
			'order'      => 'ASC',
		)
	);
	if ( ! is_wp_error( $terms ) ) {
		foreach ( $terms as $t ) {
			$cache[ $t->slug ] = $t->name;
		}
	}
	return $cache;
}

/**
 * פריטי ea_faq מפורסמים, מסוננים (OR — many-to-many) לפי $cat_slugs כשהוא לא ריק.
 * $cat_slugs ריק = כל הקטלוג (זהה להתנהגות /faq היום ללא סינון). WP-CANON T2.
 *
 * post_content נשמר עם תגי <p>/<ul> מוכנים מראש — מוחזר גולמי, בלי the_content.
 * הצריכה בצד הקורא חייבת להישאר wp_kses_post() בלבד.
 *
 * @param string[] $cat_slugs Category slugs.
 * @return array<int,array{id:int,q:string,a:string,categories:string[]}>
 */
function ea_faq_query_items( array $cat_slugs = array() ) {
	$qargs = array(
		'post_type'      => 'ea_faq',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
		'no_found_rows'  => true,
	);
	if ( ! empty( $cat_slugs ) ) {
		$qargs['tax_query'] = array(
			array(
				'taxonomy' => 'ea_faq_cat',
				'field'    => 'slug',
				'terms'    => array_map( 'sanitize_title', $cat_slugs ),
				'operator' => 'IN',
			),
		);
	}
	$out = array();
	foreach ( get_posts( $qargs ) as $p ) {
		$terms = wp_get_post_terms( $p->ID, 'ea_faq_cat', array( 'fields' => 'slugs' ) );
		if ( is_wp_error( $terms ) ) {
			$terms = array();
		}
		$out[] = array(
			'id'         => $p->ID,
			'q'          => get_the_title( $p ),
			'a'          => (string) $p->post_content,
			'categories' => $terms,
		);
	}
	return $out;
}

/**
 * עמוד גלריות — תבנית קטלוג (st-galleries-catalog).
 *
 * @param string $template Path to template file.
 * @return string
 */
function ea_eyalamit_galleries_catalog_template( $template ) {
	if ( ! is_page( 'galleries' ) ) {
		return $template;
	}
	$t = get_stylesheet_directory() . '/page-templates/template-galleries-catalog.php';
	return is_readable( $t ) ? $t : $template;
}
add_filter( 'template_include', 'ea_eyalamit_galleries_catalog_template', 97 );

/**
 * עמוד מדיה / המלצות — תבנית קטלוג (st-media).
 *
 * @param string $template Path to template file.
 * @return string
 */
function ea_eyalamit_media_catalog_template( $template ) {
	if ( ! is_page( 'media' ) ) {
		return $template;
	}
	$t = get_stylesheet_directory() . '/page-templates/template-media-catalog.php';
	return is_readable( $t ) ? $t : $template;
}
add_filter( 'template_include', 'ea_eyalamit_media_catalog_template', 96 );

/**
 * Slugs של עמודי ספר שמשתמשים בתבנית tpl-book-detail (Wave1).
 *
 * @return string[]
 */
function ea_eyalamit_get_book_detail_slugs() {
	return apply_filters(
		'ea_eyalamit_book_detail_slugs',
		array(
			'kushi-blantis',
			'tsva-bechol-ve-zorek-layam',
			'vekatavt',
		)
	);
}

/**
 * Slug קנוני לשער מוזה (st-books). legacy: `muzeh` — תמיכה זמנית עד מיגרציה.
 *
 * @return bool
 */
function ea_eyalamit_is_books_hub_view() {
	if ( ! is_singular( 'page' ) ) {
		return false;
	}
	$post = get_queried_object();
	if ( ! $post instanceof WP_Post ) {
		return false;
	}
	return in_array( $post->post_name, array( 'muzza', 'muzeh' ), true );
}

/**
 * דף ספר בודד — tpl-book-detail.
 *
 * @return bool
 */
function ea_eyalamit_is_book_detail_view() {
	if ( ! is_singular( 'page' ) ) {
		return false;
	}
	$post = get_queried_object();
	if ( ! $post instanceof WP_Post ) {
		return false;
	}
	$slugs = ea_eyalamit_get_book_detail_slugs();
	return in_array( $post->post_name, $slugs, true );
}

/**
 * תבנית שער ספרים — muzza.
 *
 * @param string $template Path to template file.
 * @return string
 */
function ea_eyalamit_books_hub_template( $template ) {
	if ( ! ea_eyalamit_is_books_hub_view() ) {
		return $template;
	}
	$t = get_stylesheet_directory() . '/page-templates/template-books-hub.php';
	return is_readable( $t ) ? $t : $template;
}
add_filter( 'template_include', 'ea_eyalamit_books_hub_template', 95 );

/**
 * WP-W2-15-CR1: consolidate the two duplicate "מוזה הוצאה לאור" pages.
 *
 * Eyal's verbatim MUZZA.md content is carried by the Chapters /books archive
 * (muzza-defaults + tpl-chapters-page). The legacy Wave2 tpl-books.php is retired
 * (301 → /books/). /muzza (and the /muzeh alias) is a PERMANENT 301 to /books —
 * the 3 book pages nest under /books/<slug>, so the catalog belongs at /books for
 * URL hierarchy. The nav points directly at /books.
 */
function ea_eyalamit_muzza_to_books_redirect() {
	if ( is_admin() ) {
		return;
	}
	// PATH-based map so EVERY legacy Muzza URL — the hub, the book children, AND the
	// old /muzza/<book> slugs WP would otherwise 2-hop via wp_old_slug_redirect —
	// lands on the canonical /books equivalent in a SINGLE 301. Runs at priority 0,
	// ahead of the mu-plugin /muzeh rule (F-CRF-02) and old-slug redirect (F-CRF-03).
	$req = isset( $_SERVER['REQUEST_URI'] )
		? (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH )
		: '';
	if ( '' === $req ) {
		return;
	}
	$req    = trailingslashit( $req );
	$legacy = array(
		'/muzza/' => '/books/',
		'/muzeh/' => '/books/',
		'/muzza/tsva-bechol-ve-zorek-layam/' => '/books/tsva-bekahol/',
		'/muzeh/tsva-bechol-ve-zorek-layam/' => '/books/tsva-bekahol/',
		'/muzza/kushi-blantis/'              => '/books/kushi-blantis/',
		'/muzeh/kushi-blantis/'              => '/books/kushi-blantis/',
		'/muzza/vekatavt/'                   => '/books/vekatavta/',
		'/muzeh/vekatavt/'                   => '/books/vekatavta/',
	);
	if ( isset( $legacy[ $req ] ) ) {
		wp_safe_redirect( home_url( $legacy[ $req ] ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'ea_eyalamit_muzza_to_books_redirect', 0 );

/**
 * Rewrite any WP nav-menu item that still points at a legacy Muzza URL to its
 * canonical /books equivalent — at output, so the rendered DOM carries no
 * /muzza|/muzeh hrefs even if the stored GeneratePress menu items (legacy
 * #primary-menu, menu-item-139…142) were never re-pointed in the DB.
 * (WP-W2-15-CR-FINAL F-CRF-01 P3 — FTP-deployable, no DB/API edit needed.)
 */
function ea_eyalamit_rewrite_legacy_muzza_menu_urls( $items ) {
	$map = array(
		'/muzza/tsva-bechol-ve-zorek-layam/' => '/books/tsva-bekahol/',
		'/muzeh/tsva-bechol-ve-zorek-layam/' => '/books/tsva-bekahol/',
		'/muzza/kushi-blantis/'              => '/books/kushi-blantis/',
		'/muzeh/kushi-blantis/'              => '/books/kushi-blantis/',
		'/muzza/vekatavt/'                   => '/books/vekatavta/',
		'/muzeh/vekatavt/'                   => '/books/vekatavta/',
		'/muzza/'                            => '/books/',
		'/muzeh/'                            => '/books/',
	);
	foreach ( $items as $item ) {
		if ( empty( $item->url ) ) {
			continue;
		}
		$path = trailingslashit( (string) wp_parse_url( $item->url, PHP_URL_PATH ) );
		if ( isset( $map[ $path ] ) ) {
			$item->url = home_url( $map[ $path ] );
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'ea_eyalamit_rewrite_legacy_muzza_menu_urls', 20 );

/**
 * תבנית דף ספר — Wave1.
 *
 * @param string $template Path to template file.
 * @return string
 */
function ea_eyalamit_book_detail_template( $template ) {
	if ( ! ea_eyalamit_is_book_detail_view() ) {
		return $template;
	}
	$t = get_stylesheet_directory() . '/page-templates/template-book-detail.php';
	return is_readable( $t ) ? $t : $template;
}
add_filter( 'template_include', 'ea_eyalamit_book_detail_template', 94 );

/**
 * עיצוב V2 — ספרים.
 * D-EYAL-DESIGN-STYLE-13: Heebo בלבד, ללא Frank Ruhl Libre / Amatic SC.
 *
 * @return void
 */
function ea_eyalamit_books_v2_assets() {
	if ( is_admin() ) {
		return;
	}
	if ( ! ea_eyalamit_is_books_hub_view() && ! ea_eyalamit_is_book_detail_view() ) {
		return;
	}

	// [V2] Heebo — לא נטען גלובלית בתבנית (הפונט הגלובלי הוא Rubik).
	// נטען כאן לעמודי הספרים בלבד. כשמערכת העיצוב תועבר גלובלית ל-Heebo —
	// להעביר את ה-enqueue ל-ea_eyalamit_enqueue_styles() ולהסיר מכאן.
	if ( ! wp_style_is( 'ea-eyalamit-fonts-heebo', 'enqueued' )
		&& ! wp_style_is( 'ea-eyalamit-fonts-heebo', 'registered' ) ) {
		wp_enqueue_style(
			'ea-eyalamit-fonts-heebo',
			'https://fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400;500;600&display=swap',
			array(),
			null
		);
	}

	// [V2] CSS: books-v2.css — מחליף את books-wave1.css.
	// [V2] הוסרה תלות ב-ea-eyalamit-fonts-rubik.
	wp_enqueue_style(
		'ea-eyalamit-books-v2',
		get_stylesheet_directory_uri() . '/assets/css/books-v2.css',
		array( 'ea-eyalamit-style' ),
		wp_get_theme()->get( 'Version' )
	);

	// [V2] Scroll-reveal JS — IntersectionObserver, threshold 0.15.
	wp_enqueue_script(
		'ea-eyalamit-books-reveal',
		get_stylesheet_directory_uri() . '/assets/js/books-reveal.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ea_eyalamit_books_v2_assets', 26 );

/**
 * מחלקות body לתבניות ספרים.
 * שמות המחלקות (ea-books-hub-view, ea-book-detail-view) לא משתנים —
 * theme-shell-fallback.css תלוי בהם.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function ea_eyalamit_books_v2_body_class( $classes ) {
	if ( ea_eyalamit_is_books_hub_view() ) {
		$classes[] = 'ea-books-hub-view';
	}
	if ( ea_eyalamit_is_book_detail_view() ) {
		$classes[] = 'ea-book-detail-view';
	}
	return $classes;
}
add_filter( 'body_class', 'ea_eyalamit_books_v2_body_class', 98 );

/**
 * ללא סרגל צד בתבניות ספרים.
 *
 * @param string $layout Layout slug.
 * @return string
 */
function ea_eyalamit_books_v2_sidebar_layout( $layout ) {
	if ( ea_eyalamit_is_books_hub_view() || ea_eyalamit_is_book_detail_view() ) {
		return 'no-sidebar';
	}
	return $layout;
}
add_filter( 'generate_sidebar_layout', 'ea_eyalamit_books_v2_sidebar_layout', 21 );

/**
 * כותרת GeneratePress מוסתרת — H1 בתבנית.
 *
 * @param bool $show Whether to show title.
 * @return bool
 */
function ea_eyalamit_books_v2_hide_title( $show ) {
	if ( ea_eyalamit_is_books_hub_view() || ea_eyalamit_is_book_detail_view() ) {
		return false;
	}
	return $show;
}
add_filter( 'generate_show_title', 'ea_eyalamit_books_v2_hide_title', 21 );

/**
 * WP-W2-01 Stage B — frozen rollback + residual Wave2 deps (WP-CANON T6 §3.2).
 * WhatsApp float, ea-tokens/atoms enqueue, CF7 — still required by Chapters shell.
 */
require_once get_stylesheet_directory() . '/inc/wave2-stage-b.php';

/**
 * WP-W2-07 Heritage — /press, QR DB-template pages, FB Top-5 testimonials.
 * /press out of Chapters scope — keep until dedicated migration.
 */
require_once get_stylesheet_directory() . '/inc/wave2-w2-07.php';

/**
 * WP-W2-08 — English Landing (/en) hreflang + assets (keep — hook still live on Chapters /en).
 */
require_once get_stylesheet_directory() . '/inc/wave2-w2-08.php';

/**
 * Site-wide SEO head fallbacks (relocated from wave2-w2-09.php — WP-CANON T6 §3.3).
 */
require_once get_stylesheet_directory() . '/inc/seo-head-fallbacks.php';

/**
 * Commerce accessors — must load before Wave2 w2-03/05 deletion (WP-CANON T6 §3.5.5).
 */
require_once get_stylesheet_directory() . '/inc/chapters/chapters-commerce.php';

/**
 * D-TESTIMONIALS (team_110) — 48 Facebook testimonials corpus + accessors
 * (per-category for service pages, broad set for home, full set for /media).
 */
require_once get_stylesheet_directory() . '/inc/ea-testimonials-fb.php';

/**
 * Chapters (פרקים) design system — single bootstrap (render accessors, enqueue,
 * duplicate-page action, ACF home field group). Self-guarding / ACF-absent safe.
 */
require_once get_stylesheet_directory() . '/inc/chapters/chapters-bootstrap.php';

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once get_stylesheet_directory() . '/inc/cli/class-ea-faq-migrate-command.php';
}
