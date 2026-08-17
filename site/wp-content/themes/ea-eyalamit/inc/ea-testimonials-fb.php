<?php
/**
 * EA — Facebook testimonials corpus (D-TESTIMONIALS, team_110 2026-06-21).
 *
 * 48 testimonials (17 treatment · 9 sound-healing · 22 lessons), each with the
 * commenter's name, the original FB post link, a PROVISIONAL carousel snippet
 * (pending Eyal review via the hub) and the full FB post. Data lives in
 * inc/data/ea-testimonials-fb.json (avoids PHP-escaping Hebrew quotes).
 *
 * Wiring: per-category snippets are appended (after service-specific, deduped) to
 * the service carousels (inc/wave2-w2-04.php); a broad set feeds the home rotator
 * (inc/wave2-stage-b.php); the FULL set renders on /testimonials/ (was /media/ —
 * S006 · slug rename · אישור team_00 2026-08-17).
 * Full 48 + the provisional selection are recorded as Eyal-review options in the
 * hub (hub/data/testimonials-curation.json + materials-needed.json I1).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * All 48 FB testimonials (static-cached). Each: cat, name, href, snippet, full.
 *
 * @return array<int,array<string,string>>
 */
function ea_fb_testimonials_all() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$cache = array();
	$path  = get_stylesheet_directory() . '/inc/data/ea-testimonials-fb.json';
	if ( is_readable( $path ) ) {
		$raw = json_decode( (string) file_get_contents( $path ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( is_array( $raw ) && ! empty( $raw['items'] ) && is_array( $raw['items'] ) ) {
			$cache = $raw['items'];
		}
	}
	return $cache;
}

/**
 * Map a service slug to a testimonials category.
 *
 * @param string $slug
 * @return string category key, or '' if none.
 */
function ea_fb_testimonials_cat_for_slug( $slug ) {
	switch ( $slug ) {
		case 'treatment':
		case 'method':
			return 'treatment';
		case 'sound-healing':
			return 'sound-healing';
		case 'lessons':
			return 'lessons';
		default:
			return '';
	}
}

/**
 * Per-category testimonials shaped for the carousel/row blocks (snippet as text).
 *
 * @param string $slug Service slug (treatment|method|sound-healing|lessons).
 * @return array<int,array{name:string,text:string,href:string}>
 */
function ea_fb_testimonials_by_cat( $slug ) {
	$cat = ea_fb_testimonials_cat_for_slug( $slug );
	if ( '' === $cat ) {
		return array();
	}
	$out = array();
	foreach ( ea_fb_testimonials_all() as $t ) {
		if ( ( $t['cat'] ?? '' ) !== $cat ) {
			continue;
		}
		$out[] = array(
			'name' => (string) ( $t['name'] ?? '' ),
			'text' => (string) ( $t['snippet'] ?? '' ),
			'href' => (string) ( $t['href'] ?? '' ),
		);
	}
	return $out;
}

/**
 * S006 · H-15 · מקור: content 13.8.26/ריכוז כל ההמלצות - טיפול בדיג'רידו, שיעורי
 * נגינה, סאונדהילינג,/ממליצים מהפייסבוק.docx
 *
 * ניקוי כתובת פייסבוק מהקורפוס. בשתי שורות במסמך של אייל הקישור וגוף ההמלצה
 * יושבים באותה פסקה, ולכן בונה ה-JSON בלע את הטקסט אל תוך ה-href:
 *   idx 13 (דן ארליכמן)   — 'https://…/1DKp5Coss8/ ⁨U+2028⁩משתף אתכם בכתבה…'
 *   idx 23 (ענת קוצר גפני) — 'https://…/1XpADx79Kb/⁨U+2028⁩דמייני לעצמך…'
 * החיתוך ברווח/U+2028 הראשון מחזיר בדיוק את יעד ההיפר-קישור שרשום ב-docx
 * (word/_rels/document.xml.rels) — אומת בייט-לבייט מול שתי הרשומות. אין כאן
 * תוכן חדש: רק הסרה של טקסט שנדבק בטעות לכתובת.
 *
 * ⚠ ea-testimonials-fb.json עצמו לא נגע (מחוץ למנדט). התיקון במקור מדווח ל-team_100.
 *
 * @param string $href
 * @return string
 */
function ea_fb_testimonials_clean_href( $href ) {
	$href = (string) $href;
	$cut  = preg_split( '/[\s\x{2028}\x{2029}]/u', $href, 2 );
	return is_array( $cut ) ? trim( (string) $cut[0] ) : trim( $href );
}

/**
 * S006 · H-15 · מקור: content 13.8.26/…/ממליצים מהפייסבוק.docx
 *
 * הסט המלא של קטגוריה אחת עבור עמוד ריכוז ההמלצות (/testimonials/ — לשעבר /media/,
 * S006 · slug rename · אישור team_00 2026-08-17), לפי הקטגוריות של
 * אייל במסמך: «טיפול בדיג'רידו» (17) · «סאונד הילינג» (9) · «שיעורי נגינה
 * בדיג'רידו» (22) = 48. בניגוד ל-ea_chapters_testimonials(), כאן שום רשומה לא
 * נופלת: גם המלצה שאין לה snippet בקורפוס מוחזרת (שם + קישור בלבד), כי היא חלק
 * מהרשימה של אייל.
 *
 * מותג שיצא משימוש (WP-06): «סטודיו נשימה מעגלית» לא מתפרסם. הכלל מוחל כאן על
 * הטקסט המוצג בלבד (snippet) ולא על ה-full שאינו מרונדר — ולכן נופל הציטוט של
 * רשומה אחת (idx 27, דרור מצליח) במקום חמש. הציטוט לא נערך ולא נוסח מחדש, רק
 * לא מוצג; השם והקישור נשארים.
 *
 * @param string $cat Corpus category key (treatment|sound-healing|lessons).
 * @return array<int,array{name:string,text:string,href:string}>
 */
function ea_fb_testimonials_archive( $cat ) {
	$brand = 'סטודיו נשימה מעגלית';
	$cat   = (string) $cat;
	$out   = array();
	foreach ( ea_fb_testimonials_all() as $t ) {
		if ( ( $t['cat'] ?? '' ) !== $cat ) {
			continue;
		}
		$text = trim( (string) ( $t['snippet'] ?? '' ) );
		if ( '' !== $text && false !== mb_strpos( $text, $brand ) ) {
			$text = ''; // brand-compliance: hide, never edit a customer quote.
		}
		$out[] = array(
			'name' => (string) ( $t['name'] ?? '' ),
			'text' => $text,
			'href' => ea_fb_testimonials_clean_href( $t['href'] ?? '' ),
		);
	}
	return $out;
}

/**
 * Broad cross-category set for the home rotator (snippet as text), up to
 * $per_cat per category, in document order. Provisional — Eyal curates in the hub.
 *
 * @param int $per_cat
 * @return array<int,array{name:string,text:string,href:string}>
 */
function ea_fb_testimonials_home( $per_cat = 4 ) {
	$counts = array();
	$out    = array();
	foreach ( ea_fb_testimonials_all() as $t ) {
		$cat = (string) ( $t['cat'] ?? '' );
		$n   = isset( $counts[ $cat ] ) ? $counts[ $cat ] : 0;
		if ( $n >= $per_cat ) {
			continue;
		}
		$counts[ $cat ] = $n + 1;
		$out[]          = array(
			'name' => (string) ( $t['name'] ?? '' ),
			'text' => (string) ( $t['snippet'] ?? '' ),
			'href' => (string) ( $t['href'] ?? '' ),
		);
	}
	return $out;
}
