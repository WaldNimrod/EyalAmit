<?php
/**
 * Plugin Name: EA M2 — זריעת מעטפת (פעם אחת)
 * Description: יוצר עמודי §7, הגדרות קריאה, תפריט primary, noindex ל-P15, shortcode Fluent ב-contact. רץ פעם אחת; לא למחוק לפני ייצוב — אפשר לאפס עם delete_option('ea_m2_shell_seed_v1').
 * Version: 1.0.4
 */

defined( 'ABSPATH' ) || exit;

/**
 * Runs once per staging site when option is not set.
 */
function ea_m2_seed_shell_maybe_run() {
	if ( get_option( 'ea_m2_shell_seed_v1', '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_m2_seed_shell_lock' ) ) {
		return;
	}
	set_transient( 'ea_m2_seed_shell_lock', 1, 120 );

	try {
		ea_m2_seed_shell_run();
		update_option( 'ea_m2_shell_seed_v1', 'done' );
	} finally {
		delete_transient( 'ea_m2_seed_shell_lock' );
	}
}

/**
 * @return int|\WP_Error
 */
function ea_m2_seed_get_or_create_page( $title, $slug, $parent_id = 0, $content = '' ) {
	$path = $slug;
	if ( $parent_id > 0 ) {
		$anc = get_post( $parent_id );
		if ( $anc && $anc->post_name ) {
			$path = $anc->post_name . '/' . $slug;
		}
	}
	$existing = get_page_by_path( $path, OBJECT, 'page' );
	if ( ! $existing && $parent_id > 0 ) {
		$existing = get_page_by_path( $slug, OBJECT, 'page' );
	}
	if ( $existing && $existing->post_status === 'publish' ) {
		return (int) $existing->ID;
	}
	$html = $content ? '<p>' . wp_kses_post( $content ) . '</p>' : '<p></p>';
	return wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_parent'  => (int) $parent_id,
			'post_content' => $html,
		),
		true
	);
}

/**
 * @param int   $menu_id Menu term ID.
 * @param array $args    wp_update_nav_menu_item args (title, object_id, parent_item_id).
 */
function ea_m2_add_menu_page_item( $menu_id, $args ) {
	$item = array(
		'menu-item-title'     => $args['title'],
		'menu-item-object-id' => (int) $args['object_id'],
		'menu-item-object'    => 'page',
		'menu-item-type'      => 'post_type',
		'menu-item-status'    => 'publish',
	);
	if ( ! empty( $args['parent_item_id'] ) ) {
		$item['menu-item-parent-id'] = (int) $args['parent_item_id'];
	}
	return wp_update_nav_menu_item( $menu_id, 0, $item );
}

function ea_m2_seed_shell_run() {
	$ids = array();

	$ids['services'] = ea_m2_seed_get_or_create_page( 'שירותים', 'services', 0, 'עמוד הורה לשירותים — placeholder.' );
	$svc_children    = array(
		array( "שיעורי דיג'רידו / נגינה", 'didgeridoo-lessons', 'שירות — placeholder.' ),
		array( 'טיפול בדיג\'רידו / נשימה', 'didgeridoo-treatment-breath', 'שירות — placeholder.' ),
		array( 'סאונד הילינג / מדיטציית דיג\'רידו', 'sound-healing', 'שירות — placeholder.' ),
		array( 'סדנאות', 'workshops', 'שירות — placeholder.' ),
		array( 'תיקון וחידוש כלים', 'instrument-repair', 'שירות — placeholder.' ),
		array( 'כלים בעבודת יד ואביזרים', 'handmade-instruments', 'מידע + קישור סליקה חיצונית — placeholder.' ),
		array( 'הרצאות', 'lectures', 'שירות — placeholder.' ),
	);
	foreach ( $svc_children as $row ) {
		ea_m2_seed_get_or_create_page( $row[0], $row[1], $ids['services'], $row[2] );
	}

	$ids['eyal'] = ea_m2_seed_get_or_create_page( 'אייל עמית', 'eyal-amit', 0, 'אודות — placeholder.' );
	ea_m2_seed_get_or_create_page( 'מוקש דהימן — לזכרו', 'moked-dehiman', $ids['eyal'], 'עמוד ייעודי — placeholder.' );

	$top = array(
		array( 'בית', 'home', 'עמוד בית — placeholder ל־M2.' ),
		array( 'השיטה', 'hashita', 'תוכן יגיע לפי אפיון — placeholder.' ),
		array( 'בלוג', 'blog', 'ארכיון בלוג — placeholder.' ),
		array( 'המלצות ומדיה', 'testimonials-media', 'placeholder.' ),
		array( 'ספרים', 'books', 'placeholder.' ),
		array( 'הכשרות למטפלים', 'therapist-training', 'יעלה בקרוב — placeholder.' ),
		array( 'צור קשר', 'contact', '' ),
		array( 'הופעות / מורשת מופע', 'shows-heritage', 'ניווט משני — placeholder.' ),
		array( 'כתבות היסטוריות', 'historical-articles', 'אופציונלי — placeholder.' ),
		array( 'English', 'en', 'EN landing — placeholder.' ),
		array( 'הצהרת נגישות', 'accessibility-statement', 'placeholder.' ),
		array( 'תקנון', 'terms', 'placeholder.' ),
		array( 'עמוד קטלוג ראשי', 'shop', 'קטלוג ראשי — שימור slug shop לפי §7 M2.' ),
		array( 'תודה', 'thank-you', 'דף תודה אחרי טפסים — אם בשימוש.' ),
		array( 'קורסים — בקרוב', 'courses-soon', 'פנימי ל־T3 עד קישור סקולר אמיתי (F11-b).' ),
	);
	foreach ( $top as $row ) {
		$ids[ $row[1] ] = ea_m2_seed_get_or_create_page( $row[0], $row[1], 0, $row[2] );
	}

	$contact_id = (int) $ids['contact'];
	if ( $contact_id > 0 ) {
		// Avoid straight double-quotes inside attributes — some save paths entity-encode and break do_shortcode.
		wp_update_post(
			array(
				'ID'           => $contact_id,
				'post_content' => '<p>טופס צור קשר — Fluent Forms.</p>' . "\n\n" . '[fluentform id=1]',
			)
		);
	}

	$tid = (int) $ids['therapist-training'];
	if ( $tid > 0 ) {
		update_post_meta( $tid, '_yoast_wpseo_meta-robots-noindex', '1' );
	}

	$home_id = (int) $ids['home'];
	$blog_id = (int) $ids['blog'];
	if ( $home_id && $blog_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
		update_option( 'page_for_posts', $blog_id );
	}

	$menu_name = 'M2 Primary EA';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = (int) $menu->term_id;
	}

	if ( ! is_wp_error( $menu_id ) && $menu_id > 0 ) {
		$items = wp_get_nav_menu_items( $menu_id );
		$locs = get_theme_mod( 'nav_menu_locations' );
		if ( ! is_array( $locs ) ) {
			$locs = array();
		}
		$locs['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locs );

		if ( empty( $items ) ) {
			$sid = ea_m2_add_menu_page_item(
				$menu_id,
				array(
					'title'     => 'בית',
					'object_id' => $ids['home'],
				)
			);
			ea_m2_add_menu_page_item(
				$menu_id,
				array(
					'title'     => 'השיטה',
					'object_id' => $ids['hashita'],
				)
			);
			$svc_item = ea_m2_add_menu_page_item(
				$menu_id,
				array(
					'title'     => 'שירותים',
					'object_id' => $ids['services'],
				)
			);
			foreach ( $svc_children as $row ) {
				$p = get_page_by_path( 'services/' . $row[1], OBJECT, 'page' );
				if ( ! $p ) {
					$p = get_page_by_path( $row[1], OBJECT, 'page' );
				}
				if ( $p ) {
					ea_m2_add_menu_page_item(
						$menu_id,
						array(
							'title'           => $row[0],
							'object_id'       => (int) $p->ID,
							'parent_item_id'  => (int) $svc_item,
						)
					);
				}
			}
			$eyal_item = ea_m2_add_menu_page_item(
				$menu_id,
				array(
					'title'     => 'אייל עמית',
					'object_id' => $ids['eyal'],
				)
			);
			$moked = get_page_by_path( 'eyal-amit/moked-dehiman', OBJECT, 'page' );
			if ( ! $moked ) {
				$moked = get_page_by_path( 'moked-dehiman', OBJECT, 'page' );
			}
			if ( $moked && $eyal_item ) {
				ea_m2_add_menu_page_item(
					$menu_id,
					array(
						'title'          => 'מוקש דהימן — לזכרו',
						'object_id'    => (int) $moked->ID,
						'parent_item_id' => (int) $eyal_item,
					)
				);
			}
			ea_m2_add_menu_page_item( $menu_id, array( 'title' => 'בלוג', 'object_id' => $ids['blog'] ) );
			ea_m2_add_menu_page_item( $menu_id, array( 'title' => 'המלצות ומדיה', 'object_id' => $ids['testimonials-media'] ) );
			ea_m2_add_menu_page_item( $menu_id, array( 'title' => 'ספרים', 'object_id' => $ids['books'] ) );
			ea_m2_add_menu_page_item( $menu_id, array( 'title' => 'צור קשר', 'object_id' => $ids['contact'] ) );
			ea_m2_add_menu_page_item( $menu_id, array( 'title' => 'קורסים', 'object_id' => $ids['courses-soon'] ) );
			ea_m2_add_menu_page_item( $menu_id, array( 'title' => 'הכשרות למטפלים', 'object_id' => $ids['therapist-training'] ) );
			ea_m2_add_menu_page_item( $menu_id, array( 'title' => 'הופעות / מורשת מופע', 'object_id' => $ids['shows-heritage'] ) );
			ea_m2_add_menu_page_item( $menu_id, array( 'title' => 'English', 'object_id' => $ids['en'] ) );
		}
	}

	flush_rewrite_rules( false );
}

add_action( 'init', 'ea_m2_seed_shell_maybe_run', 25 );

/**
 * Ensure Reading settings match M2 pages (fixes cache / partial runs / option mismatch).
 */
function ea_m2_ensure_reading_settings() {
	$home = get_page_by_path( 'home', OBJECT, 'page' );
	$blog = get_page_by_path( 'blog', OBJECT, 'page' );
	if ( ! $home || ! $blog ) {
		return;
	}
	$want_front = (int) $home->ID;
	$want_posts = (int) $blog->ID;
	$cur        = (int) get_option( 'page_on_front', 0 );
	if ( get_option( 'show_on_front', '' ) !== 'page' || $cur !== $want_front ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $want_front );
		update_option( 'page_for_posts', $want_posts );
	}
}
add_action( 'init', 'ea_m2_ensure_reading_settings', 30 );

/**
 * Repair contact page if Fluent shortcode was stored with HTML entities (shortcode then renders as plain text).
 */
function ea_m2_repair_contact_fluent_shortcode() {
	$page = get_page_by_path( 'contact', OBJECT, 'page' );
	if ( ! $page || $page->post_status !== 'publish' ) {
		return;
	}
	$c   = $page->post_content;
	$new = str_replace(
		array( '[fluentform id=&quot;1&quot;]', '[fluentform id=&#8221;1&#8221;]', '[fluentform id="1"]' ),
		'[fluentform id=1]',
		$c
	);
	if ( $new !== $c ) {
		wp_update_post(
			array(
				'ID'           => (int) $page->ID,
				'post_content' => $new,
			)
		);
	}
}
add_action( 'init', 'ea_m2_repair_contact_fluent_shortcode', 32 );

/**
 * Render Fluent on contact: core do_shortcode (11) skips tags with HTML entities / bad quotes — fix after 11.
 */
function ea_m2_contact_fluent_the_content_fix( $content ) {
	if ( ! is_singular( 'page' ) ) {
		return $content;
	}
	$post = get_queried_object();
	if ( ! $post instanceof WP_Post || $post->post_name !== 'contact' ) {
		return $content;
	}
	if ( ! preg_match( '/\[fluentform[^\]]+\]/i', $content ) ) {
		return $content;
	}
	// Single form on this page — normalize any broken tag to canonical shortcode output.
	return (string) preg_replace_callback(
		'/\[fluentform[^\]]+\]/i',
		static function () {
			return do_shortcode( '[fluentform id=1]' );
		},
		$content,
		1
	);
}
add_filter( 'the_content', 'ea_m2_contact_fluent_the_content_fix', 12 );
