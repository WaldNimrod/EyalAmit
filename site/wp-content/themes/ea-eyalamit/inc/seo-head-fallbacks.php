<?php
/**
 * Site-wide SEO head fallbacks (relocated from inc/wave2-w2-09.php — WP-CANON T6).
 *
 *  1. meta description — Yoast-first; theme fallback for routes Yoast does not cover.
 *  2. favicon link — eliminates /favicon.ico 404 when no WP Site Icon is set.
 *  3. Blog author byline — display-only "אייל עמית" on single posts (from w2-06).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Trim a meta description to ~157 chars on a clean boundary.
 *
 * @param string $text
 * @return string
 */
function ea_w2_09_trim_description( $text ) {
	$text = trim( wp_strip_all_tags( (string) $text ) );
	if ( '' === $text ) {
		return '';
	}
	if ( function_exists( 'mb_strlen' ) && mb_strlen( $text ) > 160 ) {
		return rtrim( mb_substr( $text, 0, 157 ) ) . '…';
	}
	return $text;
}

/**
 * Per-route meta description for inner pages (W1-09: these routes shipped description-less).
 * Keyed on the queried page slug; '' when no specific copy (caller falls back to the tagline).
 *
 * @return string
 */
function ea_w2_09_route_description() {
	$map = array(
		'eyal-amit'      => 'אייל עמית — מאסטר דיג׳רידו ומטפל בנשימה, מייסד המרכז לטיפול בנשימה באמצעות דיג׳רידו בפרדס חנה. הסיפור, שיטת cbDIDG וליווי אישי.',
		'shop'           => 'חנות הדיג׳רידו של אייל עמית — כלים בעבודת יד, תיקים, סטנדים, אביזרים ותיקון דיג׳רידו, מהמרכז לטיפול בנשימה באמצעות דיג׳רידו בפרדס חנה.',
		'didgeridoos'    => 'דיג׳רידו למכירה — כלים בעבודת יד בבחירת אייל עמית, מאסטר דיג׳רידו. ייעוץ והתאמה אישית מהמרכז לטיפול בנשימה בפרדס חנה.',
		'bags'           => 'תיקים לדיג׳רידו בעבודת יד — הגנה ונשיאה נוחה לכלי שלכם, מחנות אייל עמית.',
		'stands-storage' => 'סטנדים לאחסון דיג׳רידו — בתלייה או בעמידה, בעבודת יד, מחנות אייל עמית.',
		'stand-floor'    => 'סטנד רצפתי לדיג׳רידו — לנגינה בישיבה בגובה נמוך, מחנות אייל עמית.',
		'repair'         => 'תיקון דיג׳רידו — שירות מקצועי לכלים מכל הסוגים, מהמרכז לטיפול בנשימה באמצעות דיג׳רידו של אייל עמית.',
		'books'          => 'הספרים של אייל עמית בהוצאת מוזה — סיפורים אוטוביוגרפיים. כל הכותרים והרכישה במקום אחד.',
		'muzza'          => 'מוזה הוצאה לאור — הספרים והסיפורים של אייל עמית. כל הכותרים והרכישה.',
		'blog'           => 'הבלוג של אייל עמית — דיג׳רידו, נשימה, סאונד הילינג וסיפורים מהמרכז לטיפול בנשימה בפרדס חנה.',
		'faq'            => 'שאלות נפוצות על טיפול בנשימה באמצעות דיג׳רידו, סאונד הילינג ושיעורי נגינה בדיג׳רידו — תשובות מאת אייל עמית.',
		'contact'        => 'צרו קשר עם אייל עמית — המרכז לטיפול בנשימה באמצעות דיג׳רידו, רח׳ עמל 8 ב׳ פרדס חנה. וואטסאפ, טלפון וטופס.',
	);

	if ( is_home() && ! is_front_page() ) {
		return $map['blog'];
	}

	if ( is_singular( 'post' ) ) {
		$excerpt = trim( wp_strip_all_tags( (string) get_the_excerpt() ) );
		if ( '' !== $excerpt ) {
			return ea_w2_09_trim_description( $excerpt );
		}
	}

	if ( function_exists( 'ea_chapters_is_view' ) && ea_chapters_is_view()
		&& function_exists( 'ea_chapters_defaults' ) ) {
		$d = ea_chapters_defaults();
		if ( ! empty( $d['phero']['sub'] ) ) {
			return ea_w2_09_trim_description( (string) $d['phero']['sub'] );
		}
	}

	if ( ! is_page() ) {
		return '';
	}
	$obj  = get_queried_object();
	$slug = ( $obj && isset( $obj->post_name ) ) ? (string) $obj->post_name : '';
	return isset( $map[ $slug ] ) ? $map[ $slug ] : '';
}

/**
 * Meta description fallback on wp_head (Yoast defers when post meta is set).
 */
function ea_w2_09_meta_description() {
	if ( function_exists( 'ea_w2_08_is_en_page' ) && ea_w2_08_is_en_page() ) {
		$description = 'Didgeridoo-based breath work, sound healing and lessons — Pardes Hanna, Israel.';
		printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $description ) );
		return;
	}

	$queried_id = (int) get_queried_object_id();
	if ( $queried_id > 0 ) {
		$yoast_desc = trim( (string) get_post_meta( $queried_id, '_yoast_wpseo_metadesc', true ) );
		if ( '' !== $yoast_desc ) {
			return;
		}
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	$is_front = ( $front_id > 0 && is_page( $front_id ) && is_front_page() ) || is_front_page();

	if ( $is_front ) {
		$description = 'המרכז לטיפול בנשימה באמצעות דיג׳רידו — שיטת cbDIDG של אייל עמית. להחזיר שליטה על הנשימה דרך עבודה עם דיג׳רידו, תרגול נשימה וליווי אישי.';
	} else {
		$description = ea_w2_09_route_description();
		if ( '' === $description ) {
			$tagline     = trim( (string) get_bloginfo( 'description' ) );
			$description = '' !== $tagline ? $tagline : '';
		}
	}

	$description = trim( wp_strip_all_tags( $description ) );
	if ( '' === $description ) {
		return;
	}

	printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $description ) );
}
add_action( 'wp_head', 'ea_w2_09_meta_description', 4 );

/**
 * Favicon fallback when no WP Site Icon is configured.
 */
function ea_w2_09_favicon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}

	$icon = get_stylesheet_directory_uri() . '/assets/images/ea-logo.jpg';
	printf( '<link rel="icon" href="%s" type="image/jpeg" />' . "\n", esc_url( $icon ) );
	printf( '<link rel="shortcut icon" href="%s" type="image/jpeg" />' . "\n", esc_url( $icon ) );
	printf( '<link rel="apple-touch-icon" href="%s" />' . "\n", esc_url( $icon ) );
}
add_action( 'wp_head', 'ea_w2_09_favicon', 4 );

/**
 * Display-only author byline on single blog posts (relocated from wave2-w2-06.php).
 *
 * @param string $display_name The author's display name.
 * @return string
 */
function ea_w2_11_blog_author_display( $display_name ) {
	if ( is_singular( 'post' ) ) {
		return 'אייל עמית';
	}
	return $display_name;
}
add_filter( 'the_author', 'ea_w2_11_blog_author_display' );
add_filter( 'get_the_author_display_name', 'ea_w2_11_blog_author_display' );
