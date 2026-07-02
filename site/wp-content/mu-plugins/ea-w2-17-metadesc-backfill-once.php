<?php
/**
 * Plugin Name: EA W2-17 — Meta-description backfill (Yoast single source, once)
 * Description: WP-W2-17 T3 (D-1, spec §5 finding #1). Seeds `_yoast_wpseo_metadesc`
 *   for the "16 rollup + mokesh" routes that currently have NO Yoast meta-description
 *   value, so Yoast becomes the single source of truth for every in-scope route
 *   (paired with the ea_w2_09_meta_description() Yoast-first guard in
 *   inc/wave2-w2-09.php). Follows the exact one-time-seed pattern of
 *   ea-m3-team80-placeholder-content-once.php (option-flag gate, same helper shapes).
 *   Reset: delete_option('ea_w217_metadesc_backfill_v1').
 *
 *   Routes already Yoast-seeded by ea-m3-team80-placeholder-content-once.php
 *   (treatment, lessons, sound-healing) are intentionally NOT touched here — this
 *   file only fills the GAP routes (see AC-003 route set: team_90 CR1-4 rollup +
 *   /eyal-amit/mokesh-dahiman/, WP-W2-17-CRFINAL-SEO-REMEDIATION-PROGRAM-2026-07-03.md §2).
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'EA_W217_METADESC_OPTION', 'ea_w217_metadesc_backfill_v1' );

/**
 * @param string $path Page path e.g. 'method' or 'books/vekatavta'.
 * @return int Post ID or 0.
 */
function ea_w217_metadesc_page_id( $path ) {
	$p = get_page_by_path( $path, OBJECT, 'page' );
	return ( $p && $p->post_type === 'page' ) ? (int) $p->ID : 0;
}

/**
 * Set the Yoast meta description for a post ID, but ONLY if it has no value yet
 * (never clobber a value an editor or another process may have set since).
 *
 * @param int    $post_id Post ID.
 * @param string $desc    Meta description.
 */
function ea_w217_metadesc_set_if_empty( $post_id, $desc ) {
	if ( $post_id < 1 || '' === $desc ) {
		return;
	}
	$existing = get_post_meta( $post_id, '_yoast_wpseo_metadesc', true );
	if ( '' !== trim( (string) $existing ) ) {
		return;
	}
	update_post_meta( $post_id, '_yoast_wpseo_metadesc', wp_strip_all_tags( $desc ) );
}

/**
 * @return void
 */
function ea_w217_metadesc_backfill_run() {
	if ( get_option( EA_W217_METADESC_OPTION, '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_w217_metadesc_lock' ) ) {
		return;
	}
	set_transient( 'ea_w217_metadesc_lock', 1, 120 );

	try {
		// Front page (static home, page_on_front) — resolved by option, not by path,
		// since the front page's own slug is not guaranteed to be queryable as a path.
		$front_id = (int) get_option( 'page_on_front', 0 );
		ea_w217_metadesc_set_if_empty(
			$front_id,
			'המרכז לטיפול בנשימה באמצעות דיג\'רידו בפרדס חנה — שיטת cbDIDG של אייל עמית. תרגול נשימה מעגלית, טיפול אישי, שיעורי נגינה וסאונד הילינג, להחזרת שליטה בנשימה.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'method' ),
			'שיטת cbDIDG של אייל עמית — עבודה עם הנשימה דרך נגינה בדיג\'רידו וליווי אישי. תהליך הדרגתי של תרגול, הקשבה וחיזוק השליטה בנשימה היומיומית, מפרדס חנה.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'faq' ),
			'שאלות נפוצות על טיפול בדיג\'רידו, שיעורי נגינה, סאונד הילינג ושיטת cbDIDG של אייל עמית — תשובות ברורות וההבדלים בין סוגי העבודה עם הדיג\'רידו.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'books' ),
			'הספרים של אייל עמית בהוצאת מוזה — וכתבת, כושי בלאנטיס וצבע בכחול וזרוק לים. סיפורים אוטוביוגרפיים על אהבה, מסעות, אובדן וצמיחה. כל הכותרים והרכישה במקום אחד.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'eyal-amit' ),
			'אייל עמית — מאסטר דיג\'רידו ומטפל בנשימה, מייסד המרכז לטיפול בנשימה באמצעות דיג\'רידו בפרדס חנה. הסיפור האישי, שיטת cbDIDG והדרך אל הליווי האישי.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'books/vekatavta' ),
			'וכתבת מאת אייל עמית — 46 סיפורים אמיתיים ומעוררי השראה מהחיים, על אהבה, מסעות, הורות, אובדן, שינוי וצמיחה. ספר אישי מאוד, כתוב בקול ישיר וחי.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'books/kushi-blantis' ),
			'כושי בלאנטיס — רומן פנטזיה מאת אייל עמית על התעוררות, בחירה, חופש וחיבור ללב, והאומץ לצאת מהחיים הנוחים מדי. מהספרים בהוצאת מוזה.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'books/tsva-bekahol' ),
			'צבע בכחול וזרוק לים — ספר הביכורים של אייל עמית, 38 סיפורים קצרים על הטיול הגדול לדרום אמריקה. הרפתקה, תחנות בדרך וגילוי עצמי.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'didgeridoos' ),
			'דיג\'רידו למכירה — כלים בעבודת יד בבחירתו האישית של אייל עמית, מאסטר דיג\'רידו. ייעוץ והתאמה אישית מהמרכז לטיפול בנשימה באמצעות דיג\'רידו בפרדס חנה.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'bags' ),
			'תיקים לדיג\'רידו בעבודת יד — הגנה ונשיאה נוחה לכלי שלכם בדרך ובבית, מחנות הדיג\'רידו של אייל עמית, מהמרכז לטיפול בנשימה בפרדס חנה.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'stands-storage' ),
			'סטנדים לאחסון דיג\'רידו — בתלייה או בעמידה, בעבודת יד ובאיכות גבוהה, לשמירה נוחה ובטוחה על הכלי בין נגינה לנגינה. מחנות אייל עמית.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'stand-floor' ),
			'סטנד רצפתי לדיג\'רידו — פתרון נוח לנגינה בישיבה בגובה נמוך, בעבודת יד ובאיכות גבוהה, מחנות הדיג\'רידו של אייל עמית בפרדס חנה.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'repair' ),
			'תיקון וחידוש דיג\'רידו וכלים נלווים מכל הסוגים, מתוך הבנה מעמיקה של חומר, תהודה ואיכות צליל — שירות מקצועי מהמרכז לטיפול בנשימה של אייל עמית.'
		);

		ea_w217_metadesc_set_if_empty(
			ea_w217_metadesc_page_id( 'eyal-amit/mokesh-dahiman' ),
			'לזכרו של מוקש דהימן (1950–2020) — אמן-נגר, בונה דיג\'רידו ומורה מרישיקש שבהודו, ומהדמויות המשמעותיות בדרכו האישית והמקצועית של אייל עמית.'
		);

		update_option( EA_W217_METADESC_OPTION, 'done' );
	} finally {
		delete_transient( 'ea_w217_metadesc_lock' );
	}
}

add_action( 'init', 'ea_w217_metadesc_backfill_run', 30 );
