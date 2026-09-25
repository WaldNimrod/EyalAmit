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
 * True when a Yoast/excerpt string is leftover team-80 staging chrome
 * (PLACEHOLDER banner). Those strings must never ship in share cards.
 *
 * @param string $text Raw description.
 * @return bool
 */
function ea_w2_09_is_team80_chrome( $text ) {
	$t = (string) $text;
	if ( '' === $t ) {
		return false;
	}
	if ( false !== strpos( $t, 'PLACEHOLDER' ) || false !== strpos( $t, 'צוות 80' ) ) {
		return true;
	}
	// /shows-heritage/ stores «ניווט משני — placeholder.» as the share description.
	if ( false !== stripos( $t, 'placeholder' ) ) {
		return true;
	}
	// Body leftover on /historical-articles/: «אופציונלי — placeholder.»
	// Case of the English word varies; the Hebrew word is the anchor.
	if ( false !== stripos( $t, 'placeholder' ) && false !== strpos( $t, 'אופציונלי' ) ) {
		return true;
	}
	// Staging note on /thank-you/ that was shipping as the share description.
	return false !== strpos( $t, 'אם בשימוש' );
}

/**
 * Replace team-80 chrome with the theme route fallback (phero.sub / $map).
 * Used by Yoast filters so og:description cannot leak the banner.
 *
 * @param string $desc Candidate description from Yoast or content.
 * @return string
 */
function ea_w2_09_filter_yoast_chrome_desc( $desc ) {
	// /shop/ and /contact/ store an internal marker (a spec-reference note on
	// /shop/, a plugin name on /contact/) as the Yoast share-card description,
	// while the real meta description (Yoast's own metadesc post meta, already
	// correct and already live in <meta name="description">) is untouched.
	// Same shape as the /shows-heritage/ leak above — replace only the leak
	// with the description the page already serves, never new copy.
	if ( is_page( array( 'shop', 'contact' ) ) ) {
		$known_leaks = array(
			'shop'    => 'קטלוג ראשי — שימור slug shop לפי §7 M2.',
			'contact' => 'טופס צור קשר — Fluent Forms.',
		);
		$obj  = get_queried_object();
		$slug = ( $obj instanceof WP_Post ) ? (string) $obj->post_name : '';
		$plain = trim( wp_strip_all_tags( html_entity_decode( (string) $desc, ENT_QUOTES, 'UTF-8' ) ) );
		if ( isset( $known_leaks[ $slug ] ) && $plain === $known_leaks[ $slug ] ) {
			$queried_id = (int) get_queried_object_id();
			$real_meta  = $queried_id > 0 ? trim( (string) get_post_meta( $queried_id, '_yoast_wpseo_metadesc', true ) ) : '';
			if ( '' !== $real_meta ) {
				return ea_w2_09_trim_description( $real_meta );
			}
		}
	}
	if ( ! ea_w2_09_is_team80_chrome( $desc ) ) {
		return $desc;
	}
	$fallback = ea_w2_09_route_description();
	if ( '' === $fallback ) {
		$fallback = trim( (string) get_bloginfo( 'description' ) );
	}
	return ea_w2_09_trim_description( $fallback );
}

/**
 * Per-route meta description for inner pages (W1-09: these routes shipped description-less).
 * Keyed on the queried page slug; '' when no specific copy (caller falls back to the tagline).
 *
 * @return string
 */
function ea_w2_09_route_description() {
	$map = array(
		'eyal-amit'      => 'הכירו את אייל עמית, מורה ומטפל בנשימה באמצעות דיג׳רידו מאז 1999, מייסד שיטת cbDIDG ובונה כלי דיג׳רידו בעבודת יד בפרדס חנה.',
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
		'lectures'       => 'הרצאות של אייל עמית המשלבות סיפור אישי, נשימה, דיג׳רידו, מחקר והדגמות חיות. לחברות, ארגונים, כנסים, קהילות וקבוצות פרטיות.',
		'workshops'      => 'סדנת נשימה אקטיבית באמצעות דיג׳רידו לקבוצות, חברות וארגונים. לומדים על הנשימה, סטרס, הפקת צליל ועקרונות הנשימה המעגלית בדיג׳רידו, ללא צורך בניסיון קודם.',
		'contact'        => 'צרו קשר עם אייל עמית — המרכז לטיפול בנשימה באמצעות דיג׳רידו, רח\' עמל 8 ב\' פרדס חנה. וואטסאפ, טלפון וטופס.',
		'testimonials'   => 'סרטונים, הקלטות, וכתבות על העבודה עם הנשימה והדיג׳רידו.',
		'press'          => 'אייל עמית בתקשורת — כתבות, ראיונות ואזכורים על המרכז לטיפול בנשימה באמצעות דיג׳רידו, שיטת cbDIDG והספרים.',
		'qr'             => 'עמודי ה-QR של אייל עמית — סרטוני הדרכה ותוכן נלווה לספרים ולכלים, מהמרכז לטיפול בנשימה באמצעות דיג׳רידו.',
		// First sentence of the live archive (inc/data/w2-07-show-archive.json), not new copy.
		'historical-articles' => 'מופע הסיפורים של אייל עמית. מופע מפתיע וראשון מסוגו בישראל בז\'אנר ה-"ספוקן סטוריז" שהושק לראשונה בשנת 2012.',
	);

	if ( is_home() && ! is_front_page() ) {
		return $map['blog'];
	}

	if ( is_singular( 'post' ) ) {
		$post = get_queried_object();
		$excerpt = trim( wp_strip_all_tags( (string) get_the_excerpt( $post ) ) );
		if ( '' !== $excerpt && ! ea_w2_09_is_team80_chrome( $excerpt ) ) {
			return ea_w2_09_trim_description( $excerpt );
		}
		if ( $post instanceof WP_Post ) {
			$from_body = ea_w2_09_trim_description( wp_trim_words( wp_strip_all_tags( (string) $post->post_content ), 30, '…' ) );
			if ( '' !== $from_body && ! ea_w2_09_is_team80_chrome( $from_body ) ) {
				return $from_body;
			}
		}
	}

	// QR pages (WP-S5-02 §2.4) — resolved BEFORE the Chapters is_view branch below.
	// The /qr/ hub is a Chapters view whose generic phero.sub would otherwise be
	// returned there and mask the dedicated copy; the children carry real bodies.
	// Hub /qr/ -> dedicated $map['qr'] copy; child /qr/qrN/ -> trimmed post_content.
	if ( is_page() ) {
		$qr_obj = get_queried_object();
		if ( $qr_obj instanceof WP_Post ) {
			$qr_parent_slug = $qr_obj->post_parent
				? (string) get_post_field( 'post_name', $qr_obj->post_parent )
				: '';
			if ( 'qr' === $qr_parent_slug ) {
				$from_body = ea_w2_09_trim_description( wp_trim_words( wp_strip_all_tags( (string) $qr_obj->post_content ), 30, '…' ) );
				if ( '' !== $from_body && ! ea_w2_09_is_team80_chrome( $from_body ) ) {
					return $from_body;
				}
				$title = html_entity_decode( wp_strip_all_tags( get_the_title( $qr_obj ) ), ENT_QUOTES, 'UTF-8' );
				// wptexturize stores the dash as the entity &#8211;, which decode turns back into a dash.
				$title = (string) preg_replace( '/^\s*qr\s*\d+\s*[-–—]\s*/iu', '', $title );
				return ea_w2_09_trim_description( $title );
			}
			if ( 'qr' === $qr_obj->post_name && 0 === (int) $qr_obj->post_parent ) {
				return isset( $map['qr'] ) ? $map['qr'] : '';
			}
		}
	}

	if ( function_exists( 'ea_chapters_is_view' ) && ea_chapters_is_view()
		&& function_exists( 'ea_chapters_defaults' ) ) {
		$d = ea_chapters_defaults();
		if ( ! empty( $d['phero']['sub'] ) && ! ea_w2_09_is_team80_chrome( (string) $d['phero']['sub'] ) ) {
			return ea_w2_09_trim_description( (string) $d['phero']['sub'] );
		}
		foreach ( (array) ( $d['sections'] ?? array() ) as $sec ) {
			if ( ! is_array( $sec ) || ( $sec['part'] ?? '' ) !== 'prose' ) {
				continue;
			}
			$body = (string) ( $sec['args']['body'] ?? '' );
			$body = str_replace( array( '</p>', '<br>', '<br/>', '<br />' ), ' ', $body );
			$body = ea_w2_09_trim_description( wp_strip_all_tags( $body ) );
			if ( '' !== $body && ! ea_w2_09_is_team80_chrome( $body ) ) {
				return $body;
			}
		}
	}

	if ( ! is_page() ) {
		return '';
	}
	$obj  = get_queried_object();
	$slug = ( $obj && isset( $obj->post_name ) ) ? (string) $obj->post_name : '';
	if ( isset( $map[ $slug ] ) && '' !== $map[ $slug ] ) {
		return $map[ $slug ];
	}
	// Last resort: the page's own words, never the site tagline and never chrome.
	if ( $obj instanceof WP_Post ) {
		$from_body = ea_w2_09_trim_description( wp_trim_words( wp_strip_all_tags( (string) $obj->post_content ), 30, '…' ) );
		if ( '' !== $from_body && ! ea_w2_09_is_team80_chrome( $from_body ) ) {
			return $from_body;
		}
	}
	return '';
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
		if ( '' !== $yoast_desc && ! ea_w2_09_is_team80_chrome( $yoast_desc ) ) {
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
add_filter( 'wpseo_metadesc', 'ea_w2_09_filter_yoast_chrome_desc', 20 );
add_filter( 'wpseo_opengraph_desc', 'ea_w2_09_filter_yoast_chrome_desc', 20 );
add_filter( 'wpseo_twitter_description', 'ea_w2_09_filter_yoast_chrome_desc', 20 );

/**
 * The six routes measured with a meta description and no og:description.
 * Copy is whatever ea_w2_09_route_description() already returns for that page.
 */
function ea_w2_09_needs_og_description_fallback() {
	if ( ! is_page() ) {
		return false;
	}
	$obj = get_queried_object();
	if ( ! ( $obj instanceof WP_Post ) ) {
		return false;
	}
	$slug   = (string) $obj->post_name;
	$parent = $obj->post_parent ? (string) get_post_field( 'post_name', $obj->post_parent ) : '';
	if ( in_array( $slug, array( 'press', 'historical-articles' ), true ) ) {
		return true;
	}
	if ( 'qr' === $slug && 0 === (int) $obj->post_parent ) {
		return true;
	}
	return 'qr' === $parent && in_array( $slug, array( 'qr20', 'qr29', 'qr39' ), true );
}

/**
 * Print og:description equal to the existing meta description on the six routes
 * where Yoast emits none. Other pages already have the tag from Yoast.
 */
function ea_w2_09_opengraph_desc_tag() {
	if ( ! ea_w2_09_needs_og_description_fallback() ) {
		return;
	}
	$description = trim( wp_strip_all_tags( (string) ea_w2_09_route_description() ) );
	if ( '' === $description ) {
		return;
	}
	printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $description ) );
}
add_action( 'wp_head', 'ea_w2_09_opengraph_desc_tag', 5 );

/**
 * Yoast omits the canonical while /learning/therapist-training/ is meta-robots noindex.
 * A14 (2026-09-26) clears that meta, after which Yoast emits the one canonical itself.
 * This remains only for the noindex state, so a cleared page does not get a second tag.
 */
function ea_w2_09_therapist_training_canonical() {
	if ( ! is_page( 'therapist-training' ) ) {
		return;
	}
	$obj = get_queried_object();
	if ( $obj instanceof WP_Post ) {
		$noindex = get_post_meta( $obj->ID, '_yoast_wpseo_meta-robots-noindex', true );
		if ( '1' !== (string) $noindex ) {
			return;
		}
	}
	$url = get_permalink();
	if ( ! is_string( $url ) || '' === $url ) {
		return;
	}
	printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $url ) );
}
add_action( 'wp_head', 'ea_w2_09_therapist_training_canonical', 1 );

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
