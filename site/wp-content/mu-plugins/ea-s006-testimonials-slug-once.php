<?php
/**
 * Plugin Name: EA S006 — slug עמוד ההמלצות: media → testimonials (פעם אחת) + 301
 * Description: משנה פעם אחת את ה־slug של עמוד ריכוז ההמלצות מ־`media` ל־`testimonials`
 *   (העמוד הוא כיום קטלוג 48 ההמלצות בשלוש קטגוריות; `media` נקרא למשתמש ולמנוע חיפוש
 *   כ«עיתונות/גלריה/וידאו»). בנוסף מרשם 301 קבוע מ־/media/ ל־/testimonials/ כדי שה־URL
 *   הישן לא ייפול ל־404 — הוא מופיע במסמך של אייל («[לכל ההמלצות](/media)») ועשוי להיות
 *   מקושר מבחוץ. staging ללא WP-CLI (uPress), ולכן זהו drop-in חד־פעמי דרך FTP, בדיוק
 *   כמו ea-m2-ia-slug-fixups-once.php / ea-w2-07b-qr-reseed-once.php.
 *
 *   אישור: team_00 (נמרוד) 2026-08-17 — אישור מחדש לעץ הנעול hub/data/site-tree.json
 *   (צומת st-media). ⚠ המסמך של אייל עדיין כותב `/media` — אין להשתמש בו כדי «לתקן» חזרה.
 *
 *   מנגנון: init@29 (אחרי ea_m2_ia_slug_fixups_maybe_run@26 ו־
 *   ea_m2_site_tree_lock_sync_maybe_run@28, כך שאם אחד מהם ייזרע מחדש עמוד `media`
 *   באותה בקשה — הוא ישונה כאן). מוגן ב־update_option('ea_s006_testimonials_slug_v1').
 *   אידמפוטנטי: הרצה שנייה מוצאת את `testimonials` קיים, מסמנת done ויוצאת בלי לגעת ב־DB.
 *   בטוח להשאיר deployed (no-op אחרי ההרצה הראשונה) — אבל ה־301 חייב להישאר לתמיד.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/* S006 · slug rename · אישור team_00 2026-08-17 */
defined( 'EA_S006_TESTI_SLUG_OPTION' ) || define( 'EA_S006_TESTI_SLUG_OPTION', 'ea_s006_testimonials_slug_v1' );
defined( 'EA_S006_TESTI_SLUG_OLD' ) || define( 'EA_S006_TESTI_SLUG_OLD', 'media' );
defined( 'EA_S006_TESTI_SLUG_NEW' ) || define( 'EA_S006_TESTI_SLUG_NEW', 'testimonials' );

/**
 * שינוי ה־slug בפועל. פעם אחת, ואידמפוטנטי אם ירוץ שוב.
 *
 * @return void
 */
function ea_s006_testimonials_slug_maybe_run() {
	/* S006 · slug rename · אישור team_00 2026-08-17 */
	if ( 'done' === get_option( EA_S006_TESTI_SLUG_OPTION, '' ) ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_s006_testimonials_slug_lock' ) ) {
		return;
	}
	set_transient( 'ea_s006_testimonials_slug_lock', 1, 120 );

	try {
		// כבר בשם החדש (הרצה שנייה, או DB שכבר עודכן ידנית) — סמן done ואל תיגע.
		$new = get_page_by_path( EA_S006_TESTI_SLUG_NEW, OBJECT, 'page' );
		if ( $new instanceof WP_Post && 'page' === $new->post_type ) {
			update_option( EA_S006_TESTI_SLUG_OPTION, 'done' );
			return;
		}

		$old = get_page_by_path( EA_S006_TESTI_SLUG_OLD, OBJECT, 'page' );
		if ( ! $old instanceof WP_Post || 'page' !== $old->post_type || 0 !== (int) $old->post_parent ) {
			// אין מה לשנות בבקשה הזאת. לא מסמנים done — כדי שהבקשה הבאה תנסה שוב
			// (למשל אם עמוד ה־seed טרם נוצר). חסר סיכון: פעולה אחת ויחידה.
			return;
		}

		$res = wp_update_post(
			array(
				'ID'        => (int) $old->ID,
				'post_name' => EA_S006_TESTI_SLUG_NEW,
			),
			true
		);
		if ( is_wp_error( $res ) ) {
			return;
		}

		// אימות: WP מוסיף סיומת «-2» אם ה־slug תפוס. בלי האימות היינו מסמנים done
		// על עמוד שיושב ב־/testimonials-2/, וה־301 היה מפנה ל־404.
		if ( EA_S006_TESTI_SLUG_NEW !== (string) get_post_field( 'post_name', (int) $old->ID ) ) {
			return;
		}

		update_option( EA_S006_TESTI_SLUG_OPTION, 'done' );
		flush_rewrite_rules( false );
	} finally {
		delete_transient( 'ea_s006_testimonials_slug_lock' );
	}
}
add_action( 'init', 'ea_s006_testimonials_slug_maybe_run', 29 );

/**
 * 301 קבוע: /media/ → /testimonials/. מנגנון זהה ל־ea-w209-legacy-301-redirects.php
 * (‎.htaccess אינרטי בסטאק הזה — nginx; PHP הוא המנגנון החי). לא נוסף לקובץ w209 עצמו
 * כי הוא GENERATED ומסומן «DO NOT hand-edit».
 *
 * מוגן ביעד: אם עמוד `testimonials` לא קיים/לא publish (למשל השינוי טרם רץ) — לא מפנים,
 * ו־/media/ ממשיך לעבוד כרגיל. עדיף URL ישן חי מאשר 301 ל־404.
 *
 * @return void
 */
function ea_s006_testimonials_slug_redirect() {
	/* S006 · slug rename · אישור team_00 2026-08-17 */
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? rawurldecode( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	if ( '' === $uri ) {
		return;
	}
	$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
	if ( '' === $path ) {
		return;
	}
	$norm = trailingslashit( $path );
	$key  = trailingslashit( (string) wp_parse_url( home_url( '/' . EA_S006_TESTI_SLUG_OLD . '/' ), PHP_URL_PATH ) );
	if ( $norm !== $key ) {
		return;
	}

	$target = get_page_by_path( EA_S006_TESTI_SLUG_NEW, OBJECT, 'page' );
	if ( ! $target instanceof WP_Post || 'publish' !== $target->post_status ) {
		return;
	}

	header( 'X-EA-Redirect: s006-media-testimonials' );
	wp_safe_redirect( home_url( '/' . EA_S006_TESTI_SLUG_NEW . '/' ), 301 );
	exit;
}
// priority 0 — לפני redirect_canonical (@10) ולפני טבלת הנתיבים הקנוניים של M2 (@1).
add_action( 'template_redirect', 'ea_s006_testimonials_slug_redirect', 0 );
