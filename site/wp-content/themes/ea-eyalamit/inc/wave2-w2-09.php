<?php
/**
 * WP-W2-09 — Cutover SEO/best-practices head hygiene.
 *
 * Two theme-level, content-neutral head additions surfaced by the AC-05
 * Lighthouse pass on HTTP staging:
 *
 *  1. meta description — the HE homepage had no <meta name="description">,
 *     failing the Lighthouse SEO `meta-description` audit. We emit one derived
 *     from the existing hero copy (no new page content/copy is introduced).
 *     A site-wide fallback uses the WordPress tagline so inner pages without a
 *     dedicated description still get a sensible value. If a host-side SEO
 *     plugin already prints a `name="description"` tag this is harmless (the
 *     first one wins for crawlers; we only add when the theme owns the head).
 *
 *  2. favicon link — the homepage logged a 404 for /favicon.ico, failing the
 *     Lighthouse best-practices `errors-in-console` audit. We point the icon at
 *     the existing brand logo asset shipped with the theme, eliminating the
 *     network 404 without adding a binary.
 *
 * NOTE (staging artifacts, intentionally NOT touched here):
 *   - is-crawlable (SEO) is failed by the intentional staging noindex
 *     (mu-plugin ea-staging-noindex.php). Removing it would game the score and
 *     is forbidden; it lifts at the M7 HTTPS/production cutover.
 *   - is-on-https / redirects-http (best-practices) are HTTP-only staging
 *     limits; HTTPS lands at M7 cutover.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Meta description for the HE homepage (and a tagline-based site-wide fallback).
 *
 * Derived verbatim from the existing hero title + subtitle already rendered on
 * the front page, so no new copy is authored.
 */
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
		// 'muzza' is a DEAD entry: /muzza/ is a 301 SOURCE that redirects to canonical
		// /books/ (redirects SSoT). It is never queried as a Page, so this copy never
		// renders. Retained as documentation; F-W1B-META-02 dispositioned — accept the
		// /books/ canonical, do not author a distinct /muzza/ landing.
		'muzza'          => 'מוזה הוצאה לאור — הספרים והסיפורים של אייל עמית. כל הכותרים והרכישה.',
		// 'blog' is served by the is_home() branch below (the posts archive is not a
		// Page); the entry lives here so the copy has a single source of truth.
		'blog'           => 'הבלוג של אייל עמית — דיג׳רידו, נשימה, סאונד הילינג וסיפורים מהמרכז לטיפול בנשימה בפרדס חנה.',
		'faq'            => 'שאלות נפוצות על טיפול בנשימה באמצעות דיג׳רידו, סאונד הילינג ושיעורי נגינה בדיג׳רידו — תשובות מאת אייל עמית.',
		'contact'        => 'צרו קשר עם אייל עמית — המרכז לטיפול בנשימה באמצעות דיג׳רידו, רח׳ עמל 8 ב׳ פרדס חנה. וואטסאפ, טלפון וטופס.',
	);

	// Blog posts archive: WordPress serves /blog/ via is_home() (the static front
	// page is a separate Page), so is_page() is false here and the slug map below is
	// never reached. Without this branch the archive shipped description-less
	// (B-W1B-META-01). Guard on ! is_front_page() so this only applies to the
	// dedicated posts page, not when the blog is configured as the site homepage
	// (that case is handled by the is_front_page() branch in the caller).
	if ( is_home() && ! is_front_page() ) {
		return $map['blog'];
	}

	if ( ! is_page() ) {
		return '';
	}
	$obj  = get_queried_object();
	$slug = ( $obj && isset( $obj->post_name ) ) ? (string) $obj->post_name : '';
	return isset( $map[ $slug ] ) ? $map[ $slug ] : '';
}

function ea_w2_09_meta_description() {
	// Skip the EN landing page; it carries its own context (W2-08) and we do not
	// want the HE description leaking onto it.
	if ( function_exists( 'ea_w2_08_is_en_page' ) && ea_w2_08_is_en_page() ) {
		return;
	}

	$front_id = (int) get_option( 'page_on_front', 0 );
	$is_front = ( $front_id > 0 && is_page( $front_id ) && is_front_page() ) || is_front_page();

	if ( $is_front ) {
		$description = 'המרכז לטיפול בנשימה באמצעות דיג׳רידו — שיטת cbDIDG של אייל עמית. להחזיר שליטה על הנשימה דרך עבודה עם דיג׳רידו, תרגול נשימה וליווי אישי.';
	} else {
		// W1-09: per-route description for inner pages (were description-less), then tagline fallback.
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
 * Emit a favicon link pointing at the shipped brand logo, eliminating the
 * /favicon.ico 404 that fails the best-practices errors-in-console audit.
 */
function ea_w2_09_favicon() {
	// Respect a real WP Site Icon if one is configured (it prints its own links).
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}

	$icon = get_stylesheet_directory_uri() . '/assets/images/ea-logo.jpg';
	printf( '<link rel="icon" href="%s" type="image/jpeg" />' . "\n", esc_url( $icon ) );
	printf( '<link rel="shortcut icon" href="%s" type="image/jpeg" />' . "\n", esc_url( $icon ) );
	printf( '<link rel="apple-touch-icon" href="%s" />' . "\n", esc_url( $icon ) );
}
add_action( 'wp_head', 'ea_w2_09_favicon', 4 );
