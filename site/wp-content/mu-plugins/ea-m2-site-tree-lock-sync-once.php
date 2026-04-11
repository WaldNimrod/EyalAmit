<?php
/**
 * Plugin Name: EA M2 — סנכרון עץ נעול (פעם אחת)
 * Description: עמודים + תפריט primary + תפריט פוטר לפי hub/data/site-tree.json. איפוס סנכרון: delete_option('ea_m2_site_tree_lock_sync_v3').
 * Version: 1.2.0
 */

defined( 'ABSPATH' ) || exit;

define( 'EA_M2_SITE_TREE_SYNC_OPTION', 'ea_m2_site_tree_lock_sync_v3' );

/**
 * URL חיצוני לפריט «קורסים» בתפריט — סנכרון סקולר/רב־מסר כשמאושר.
 *
 * @param string $default ברירת מחדל: דומיין חי (לא 404).
 */
function ea_m2_courses_external_url_default() {
	return 'https://www.eyalamit.co.il/';
}

/**
 * @return int|\WP_Error
 */
function ea_m2_st_ensure_page( $title, $slug, $parent_id = 0, $content = '' ) {
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
	$html = $content ? '<p>' . wp_kses_post( $content ) . '</p>' : '<p></p>';
	if ( $existing && $existing->post_type === 'page' ) {
		$updates = array( 'ID' => (int) $existing->ID );
		if ( (int) $existing->post_parent !== (int) $parent_id ) {
			$updates['post_parent'] = (int) $parent_id;
		}
		if ( $existing->post_status !== 'publish' ) {
			$updates['post_status'] = 'publish';
		}
		if ( count( $updates ) > 1 ) {
			wp_update_post( $updates );
		}
		return (int) $existing->ID;
	}
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
 * @param int    $menu_id Menu term ID.
 * @param int    $page_id Page ID.
 * @param string $title   Optional menu label.
 * @param int    $parent_nav_id Parent nav_menu_item ID.
 * @return int nav item DB id or 0.
 */
function ea_m2_st_add_menu_page( $menu_id, $page_id, $title = '', $parent_nav_id = 0 ) {
	$p = get_post( $page_id );
	if ( ! $p || $p->post_type !== 'page' ) {
		return 0;
	}
	$item = array(
		'menu-item-title'     => $title !== '' ? $title : $p->post_title,
		'menu-item-object-id' => (int) $page_id,
		'menu-item-object'    => 'page',
		'menu-item-type'      => 'post_type',
		'menu-item-status'    => 'publish',
	);
	if ( $parent_nav_id > 0 ) {
		$item['menu-item-parent-id'] = (int) $parent_nav_id;
	}
	$mid = wp_update_nav_menu_item( $menu_id, 0, $item );
	return is_wp_error( $mid ) ? 0 : (int) $mid;
}

/**
 * @param int    $menu_id Menu term ID.
 * @param string $url     Full URL.
 * @param string $title   Label.
 * @param int    $parent_nav_id Parent nav_menu_item ID.
 * @return int nav item DB id or 0.
 */
function ea_m2_st_add_menu_custom( $menu_id, $url, $title, $parent_nav_id = 0 ) {
	$item = array(
		'menu-item-title'  => $title,
		'menu-item-url'    => esc_url_raw( $url ),
		'menu-item-type'   => 'custom',
		'menu-item-status' => 'publish',
	);
	if ( $parent_nav_id > 0 ) {
		$item['menu-item-parent-id'] = (int) $parent_nav_id;
	}
	$mid = wp_update_nav_menu_item( $menu_id, 0, $item );
	return is_wp_error( $mid ) ? 0 : (int) $mid;
}

/**
 * @param int $menu_id Menu term ID.
 */
function ea_m2_st_clear_nav_menu_items( $menu_id ) {
	$items = wp_get_nav_menu_items( $menu_id, array( 'post_status' => 'any' ) );
	if ( ! is_array( $items ) ) {
		return;
	}
	foreach ( $items as $item ) {
		if ( isset( $item->ID ) ) {
			wp_delete_post( (int) $item->ID, true );
		}
	}
}

/**
 * Canonical IA + primary + footer menus לפי site-tree.json.
 */
function ea_m2_site_tree_lock_sync_run() {
	$ids = array();

	// --- Top-level & hubs (סדר treeOrder) ---
	$ids['home']      = ea_m2_st_ensure_page( 'דף הבית', 'home', 0, 'עמוד בית סטטי — M2.' );
	$ids['treatment'] = ea_m2_st_ensure_page( "טיפול בדיג'רידו", 'treatment', 0, 'שירות — placeholder לפי SSOT.' );
	$ids['method']    = ea_m2_st_ensure_page( 'השיטה', 'method', 0, 'תוכן לפי אפיון — placeholder.' );
	$ids['lessons']   = ea_m2_st_ensure_page( "שיעורי דיג'רידו", 'lessons', 0, 'שירות — placeholder.' );
	$ids['sound']     = ea_m2_st_ensure_page( 'סאונד הילינג', 'sound-healing', 0, 'שירות — placeholder.' );

	$ids['learning'] = ea_m2_st_ensure_page( 'לימוד והכשרה', 'learning', 0, 'שער לימוד והכשרה — placeholder.' );

	$ids['therapist-training'] = ea_m2_st_ensure_page(
		'הכשרות למטפלים',
		'therapist-training',
		$ids['learning'],
		'Placeholder — noindex לפי מנדט M2.'
	);

	ea_m2_st_ensure_page(
		'קורסים (סקולר / חיצוני)',
		'courses-external',
		$ids['learning'],
		'נקודת נחיתה פנימית עד קישור סקולר סופי — הקישור בתפריט הוא חיצוני לפי העץ.'
	);

	$ids['lectures']  = ea_m2_st_ensure_page( 'הרצאות', 'lectures', $ids['learning'], 'שירות — placeholder.' );
	$ids['workshops'] = ea_m2_st_ensure_page( 'סדנאות', 'workshops', $ids['learning'], 'שירות — placeholder.' );

	$ids['tools']       = ea_m2_st_ensure_page( 'כלים ואביזרים', 'tools-and-accessories', 0, 'שער כלים — placeholder.' );
	$ids['instruments'] = ea_m2_st_ensure_page(
		'כלים בעבודת יד ואביזרים',
		'instruments',
		$ids['tools'],
		'שירות — placeholder.'
	);
	$ids['repair'] = ea_m2_st_ensure_page( 'תיקון וחידוש כלים', 'repair', $ids['tools'], 'שירות — placeholder.' );

	$ids['muzza'] = ea_m2_st_ensure_page( 'מוזה הוצאה לאור', 'muzza', 0, 'שער הוצאה — placeholder.' );
	ea_m2_st_ensure_page( 'צבע בכחול וזרוק לים', 'tsva-bechol-ve-zorek-layam', $ids['muzza'], 'ספר — placeholder.' );
	ea_m2_st_ensure_page( 'כושי בלאנטיס', 'kushi-blantis', $ids['muzza'], 'ספר — placeholder.' );
	ea_m2_st_ensure_page( 'וכתבת', 'vekatavt', $ids['muzza'], 'ספר — placeholder.' );

	$ids['blog'] = ea_m2_st_ensure_page( "בלוג דיג'רידו", 'blog', 0, 'ארכיון בלוג — placeholder.' );
	$ids['eyal'] = ea_m2_st_ensure_page( 'אייל עמית', 'eyal-amit', 0, 'אודות — placeholder.' );

	// מוקש: slug נעול mokesh-dahiman (תיקון מ־moked-dehiman בזריעה ישנה).
	$moked = get_page_by_path( 'eyal-amit/moked-dehiman', OBJECT, 'page' );
	if ( ! $moked ) {
		$moked = get_page_by_path( 'moked-dehiman', OBJECT, 'page' );
	}
	if ( $moked && $moked->post_type === 'page' ) {
		wp_update_post(
			array(
				'ID'          => (int) $moked->ID,
				'post_name'   => 'mokesh-dahiman',
				'post_parent' => (int) $ids['eyal'],
			)
		);
		$ids['mokesh'] = (int) $moked->ID;
	} else {
		$ids['mokesh'] = ea_m2_st_ensure_page(
			'מוקש דהימן — לזכרו',
			'mokesh-dahiman',
			$ids['eyal'],
			'עמוד ייעודי — placeholder.'
		);
	}

	$ids['contact'] = ea_m2_st_ensure_page( 'צור קשר', 'contact', 0, '' );
	$ids['en']      = ea_m2_st_ensure_page( 'אנגלית (EN)', 'en', 0, 'EN landing — placeholder.' );

	// פוטר / מערכת (לא בתפריט ראשי).
	$ids['faq']       = ea_m2_st_ensure_page( 'שאלות נפוצות (FAQ)', 'faq', 0, 'קטלוג FAQ — placeholder.' );
	$ids['galleries'] = ea_m2_st_ensure_page( 'גלריות — קטלוג מרכזי', 'galleries', 0, 'קטלוג גלריות — placeholder.' );
	$ids['media']     = ea_m2_st_ensure_page( 'המלצות — קטלוג מרכזי (ומדיה)', 'media', 0, 'קטלוג המלצות — placeholder.' );
	$ids['privacy']   = ea_m2_st_ensure_page( 'מדיניות פרטיות', 'privacy', 0, 'מסמך משפטי — placeholder.' );
	$ids['terms']     = ea_m2_st_ensure_page( 'תקנון', 'terms', 0, 'מסמך משפטי — placeholder.' );

	// נגישות: slug נעול accessibility (לא accessibility-statement).
	$acc_old = get_page_by_path( 'accessibility-statement', OBJECT, 'page' );
	if ( $acc_old && $acc_old->post_type === 'page' ) {
		wp_update_post(
			array(
				'ID'        => (int) $acc_old->ID,
				'post_name' => 'accessibility',
			)
		);
		$ids['accessibility'] = (int) $acc_old->ID;
	} else {
		$ids['accessibility'] = ea_m2_st_ensure_page( 'הצהרת נגישות', 'accessibility', 0, 'מסמך נגישות — placeholder.' );
	}

	ea_m2_st_ensure_page( 'תודה אחרי טפסים', 'thank-you', 0, 'מערכת — placeholder.' );
	ea_m2_st_ensure_page( 'דף מאגר «שירותים» (legacy)', 'services', 0, 'Legacy — לא בתפריט החדש; למיגרציה.' );

	// צור קשר — Fluent.
	$cid = (int) $ids['contact'];
	if ( $cid > 0 ) {
		wp_update_post(
			array(
				'ID'           => $cid,
				'post_content' => '<p>טופס צור קשר — Fluent Forms.</p>' . "\n\n" . '[fluentform id=1]',
			)
		);
	}

	$tid = (int) $ids['therapist-training'];
	if ( $tid > 0 ) {
		update_post_meta( $tid, '_yoast_wpseo_meta-robots-noindex', '1' );
	}

	// קריאה.
	if ( ! empty( $ids['home'] ) && ! empty( $ids['blog'] ) && ! is_wp_error( $ids['home'] ) && ! is_wp_error( $ids['blog'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $ids['home'] );
		update_option( 'page_for_posts', (int) $ids['blog'] );
	}

	$locs = get_theme_mod( 'nav_menu_locations' );
	if ( ! is_array( $locs ) ) {
		$locs = array();
	}

	// תפריט ראשי — ניקוי מלא ובנייה מחדש (ללא פריט «בית» — לוגו בלבד לפי העץ).
	$menu_name = 'M2 Primary EA';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
	} else {
		$menu_id = (int) $menu->term_id;
	}

	if ( ! is_wp_error( $menu_id ) && $menu_id > 0 ) {
		ea_m2_st_clear_nav_menu_items( $menu_id );

		$locs['primary'] = $menu_id;

		$courses_url = apply_filters( 'ea_m2_courses_external_url', ea_m2_courses_external_url_default() );

		$nav              = array();
		$nav['treatment'] = ea_m2_st_add_menu_page( $menu_id, (int) $ids['treatment'] );
		$nav['method']    = ea_m2_st_add_menu_page( $menu_id, (int) $ids['method'] );
		$nav['lessons']   = ea_m2_st_add_menu_page( $menu_id, (int) $ids['lessons'] );
		$nav['sound']     = ea_m2_st_add_menu_page( $menu_id, (int) $ids['sound'] );

		$nav['learning'] = ea_m2_st_add_menu_page( $menu_id, (int) $ids['learning'], 'לימוד והכשרה' );
		ea_m2_st_add_menu_page( $menu_id, (int) $ids['therapist-training'], '', (int) $nav['learning'] );
		// G3 — T3 לנתיב קנוני פנימי (תוכן + קישורי חוץ בעמוד); לא custom URL.
		$courses_page = get_page_by_path( 'learning/courses-external', OBJECT, 'page' );
		if ( $courses_page && $courses_page->post_type === 'page' ) {
			ea_m2_st_add_menu_page(
				$menu_id,
				(int) $courses_page->ID,
				'קורסים (סקולר / חיצוני)',
				(int) $nav['learning']
			);
		} else {
			ea_m2_st_add_menu_custom(
				$menu_id,
				$courses_url,
				'קורסים (סקולר / חיצוני)',
				(int) $nav['learning']
			);
		}
		ea_m2_st_add_menu_page( $menu_id, (int) $ids['lectures'], '', (int) $nav['learning'] );
		ea_m2_st_add_menu_page( $menu_id, (int) $ids['workshops'], '', (int) $nav['learning'] );

		$nav['tools'] = ea_m2_st_add_menu_page( $menu_id, (int) $ids['tools'], 'כלים ואביזרים' );
		ea_m2_st_add_menu_page( $menu_id, (int) $ids['instruments'], '', (int) $nav['tools'] );
		ea_m2_st_add_menu_page( $menu_id, (int) $ids['repair'], '', (int) $nav['tools'] );

		$nav['muzza'] = ea_m2_st_add_menu_page( $menu_id, (int) $ids['muzza'], 'מוזה הוצאה לאור' );
		$p_tsva      = get_page_by_path( 'muzza/tsva-bechol-ve-zorek-layam', OBJECT, 'page' );
		if ( ! $p_tsva ) {
			$p_tsva = get_page_by_path( 'muzeh/tsva-bechol-ve-zorek-layam', OBJECT, 'page' );
		}
		$p_kushi = get_page_by_path( 'muzza/kushi-blantis', OBJECT, 'page' );
		if ( ! $p_kushi ) {
			$p_kushi = get_page_by_path( 'muzeh/kushi-blantis', OBJECT, 'page' );
		}
		$p_vek = get_page_by_path( 'muzza/vekatavt', OBJECT, 'page' );
		if ( ! $p_vek ) {
			$p_vek = get_page_by_path( 'muzeh/vekatavt', OBJECT, 'page' );
		}
		if ( $p_tsva ) {
			ea_m2_st_add_menu_page( $menu_id, (int) $p_tsva->ID, '', (int) $nav['muzza'] );
		}
		if ( $p_kushi ) {
			ea_m2_st_add_menu_page( $menu_id, (int) $p_kushi->ID, '', (int) $nav['muzza'] );
		}
		if ( $p_vek ) {
			ea_m2_st_add_menu_page( $menu_id, (int) $p_vek->ID, '', (int) $nav['muzza'] );
		}

		ea_m2_st_add_menu_page( $menu_id, (int) $ids['blog'] );

		$nav['eyal'] = ea_m2_st_add_menu_page( $menu_id, (int) $ids['eyal'], 'אייל עמית' );
		ea_m2_st_add_menu_page( $menu_id, (int) $ids['mokesh'], '', (int) $nav['eyal'] );

		ea_m2_st_add_menu_page( $menu_id, (int) $ids['contact'] );
	}

	// תפריט פוטר — קטלוגים + משפטי (site-tree: פוטר בלבד).
	$footer_name = 'M2 Footer EA';
	$footer_menu = wp_get_nav_menu_object( $footer_name );
	if ( ! $footer_menu ) {
		$footer_id = wp_create_nav_menu( $footer_name );
	} else {
		$footer_id = (int) $footer_menu->term_id;
	}

	if ( ! is_wp_error( $footer_id ) && $footer_id > 0 ) {
		ea_m2_st_clear_nav_menu_items( $footer_id );
		ea_m2_st_add_menu_page( $footer_id, (int) $ids['faq'] );
		ea_m2_st_add_menu_page( $footer_id, (int) $ids['galleries'] );
		ea_m2_st_add_menu_page( $footer_id, (int) $ids['media'] );
		ea_m2_st_add_menu_page( $footer_id, (int) $ids['privacy'] );
		ea_m2_st_add_menu_page( $footer_id, (int) $ids['accessibility'] );
		ea_m2_st_add_menu_page( $footer_id, (int) $ids['terms'] );
		$locs['ea_footer_legal'] = $footer_id;
	}

	set_theme_mod( 'nav_menu_locations', $locs );

	flush_rewrite_rules( false );
}

function ea_m2_site_tree_lock_sync_maybe_run() {
	if ( get_option( EA_M2_SITE_TREE_SYNC_OPTION, '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_m2_site_tree_lock_sync_lock' ) ) {
		return;
	}
	set_transient( 'ea_m2_site_tree_lock_sync_lock', 1, 180 );

	try {
		ea_m2_site_tree_lock_sync_run();
		update_option( EA_M2_SITE_TREE_SYNC_OPTION, 'done' );
	} finally {
		delete_transient( 'ea_m2_site_tree_lock_sync_lock' );
	}
}

add_action( 'init', 'ea_m2_site_tree_lock_sync_maybe_run', 28 );

/**
 * הפניות 301: נתיבים legacy → קנוניים לפי site-tree.json.
 */
function ea_m2_st_canonical_path_redirects() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? rawurldecode( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	if ( $uri === '' ) {
		return;
	}
	$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
	if ( $path === '' ) {
		return;
	}
	$norm = trailingslashit( $path );

	$courses_landing = home_url( '/learning/courses-external/' );

	$internal = array(
		'/courses-external/'                      => home_url( '/learning/courses-external/' ),
		'/accessibility-statement/'               => home_url( '/accessibility/' ),
		'/shop/'                                  => home_url( '/tools-and-accessories/' ),
		'/courses-soon/'                          => $courses_landing,
		'/books/'                                 => home_url( '/muzza/' ),
		'/muzeh/'                                 => home_url( '/muzza/' ),
		'/hashita/'                               => home_url( '/method/' ),
		'/testimonials-media/'                    => home_url( '/media/' ),
		'/didgeridoo-treatment-breath/'           => home_url( '/treatment/' ),
		'/services/didgeridoo-treatment-breath/'  => home_url( '/treatment/' ),
		'/services/didgeridoo-lessons/'            => home_url( '/lessons/' ),
		'/services/sound-healing/'                => home_url( '/sound-healing/' ),
		'/services/instrument-repair/'            => home_url( '/tools-and-accessories/repair/' ),
		'/instrument-repair/'                     => home_url( '/tools-and-accessories/repair/' ),
		'/services/handmade-instruments/'         => home_url( '/tools-and-accessories/instruments/' ),
		'/services/workshops/'                    => home_url( '/learning/workshops/' ),
		'/services/lectures/'                     => home_url( '/learning/lectures/' ),
		// G5–G7: שורש slug מול קנוני תחת learning (אם נשארו קישורים ישנים).
		'/lectures/'                              => home_url( '/learning/lectures/' ),
		'/workshops/'                             => home_url( '/learning/workshops/' ),
	);

	foreach ( $internal as $rel => $target ) {
		$key = trailingslashit( (string) wp_parse_url( home_url( $rel ), PHP_URL_PATH ) );
		if ( $norm === $key ) {
			wp_safe_redirect( $target, 301 );
			exit;
		}
	}
}
add_action( 'template_redirect', 'ea_m2_st_canonical_path_redirects', 1 );
