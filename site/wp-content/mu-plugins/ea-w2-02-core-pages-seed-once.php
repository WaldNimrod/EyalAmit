<?php
/**
 * Plugin Name: EA W2-02 — זריעת עמודי ליבה (פעם אחת)
 * Description: יוצר 6 עמודי ליבה של Wave2 + /about/moksha. מעדכן תבנית עמוד + תוכן מ-25.5.26. איפוס: delete_option('ea_w2_02_core_pages_seed_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'EA_W2_02_SEED_OPTION', 'ea_w2_02_core_pages_seed_v1' );
define( 'EA_W2_02_SEED_LOCK', 'ea_w2_02_seed_lock' );

/**
 * Guard: run only once, not during install/AJAX/REST.
 */
function ea_w2_02_seed_maybe_run() {
	if ( get_option( EA_W2_02_SEED_OPTION, '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( EA_W2_02_SEED_LOCK ) ) {
		return;
	}
	set_transient( EA_W2_02_SEED_LOCK, 1, 180 );

	try {
		ea_w2_02_seed_run();
		update_option( EA_W2_02_SEED_OPTION, 'done' );
	} finally {
		delete_transient( EA_W2_02_SEED_LOCK );
	}
}
add_action( 'init', 'ea_w2_02_seed_maybe_run', 35 );

/**
 * Ensure a page exists (by slug path), return its ID.
 * Updates post_status to publish and post_parent if needed.
 *
 * @param string $title
 * @param string $slug
 * @param int    $parent_id
 * @param string $content   HTML content.
 * @param string $template  Page template relative path.
 * @return int|WP_Error
 */
function ea_w2_02_ensure_page( $title, $slug, $parent_id, $content, $template ) {
	$path = $slug;
	if ( $parent_id > 0 ) {
		$parent = get_post( $parent_id );
		if ( $parent && $parent->post_name ) {
			$path = $parent->post_name . '/' . $slug;
		}
	}
	$existing = get_page_by_path( $path, OBJECT, 'page' );
	if ( ! $existing && $parent_id > 0 ) {
		$existing = get_page_by_path( $slug, OBJECT, 'page' );
	}

	if ( $existing && $existing->post_type === 'page' ) {
		$update = array( 'ID' => (int) $existing->ID );
		if ( $existing->post_status !== 'publish' ) {
			$update['post_status'] = 'publish';
		}
		if ( $content !== '' ) {
			$update['post_content'] = $content;
		}
		if ( (int) $existing->post_parent !== $parent_id ) {
			$update['post_parent'] = $parent_id;
		}
		if ( count( $update ) > 1 ) {
			wp_update_post( $update );
		}
		if ( $template ) {
			update_post_meta( (int) $existing->ID, '_wp_page_template', $template );
		}
		return (int) $existing->ID;
	}

	$new_id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_parent'  => (int) $parent_id,
			'post_content' => $content,
		),
		true
	);
	if ( ! is_wp_error( $new_id ) && $template ) {
		update_post_meta( $new_id, '_wp_page_template', $template );
	}
	return $new_id;
}

/**
 * HTML content for the Method page (from method.md — 25.5.26).
 */
function ea_w2_02_method_html() {
	return '
<section class="ea-service-hero">
<h1 class="ea-page-title">שיטת cbDIDG של אייל עמית</h1>
<p class="ea-page-subtitle">שיטה לעבודה עם הנשימה באמצעות דיג׳רידו, המבוססת על תרגול עצמי דרך הכלי בליווי אישי.</p>
<p>הדיג׳רידו אינו המטרה — הוא הכלי שדרכו לומדים לעבוד עם הנשימה היומיומית, לחזק, לווסת ולהחזיר עליה את השליטה.</p>
<p><a class="ea-cta-pill ea-cta-pill--primary" href="/contact">לתיאום שיחת היכרות</a></p>
</section>

<section class="ea-service-section">
<h2>מהי שיטת cbDIDG</h2>
<p>שיטת cbDIDG היא שיטה לעבודה עם הנשימה, המתבצעת דרך נגינה בדיג׳רידו וליווי אישי, כחלק מתהליך של <a href="/treatment">טיפול בדיג׳רידו</a> או במסגרת <a href="/lessons">שיעורי נגינה</a>.</p>
<p>העבודה אינה מתמקדת רק בלימוד נגינה או בטכניקה, אלא בשיפור דפוסי הנשימה היומיומיים.</p>
<p>הדיג׳רידו משמש ככלי עבודה — לא כמטרה בפני עצמה.</p>
</section>

<section class="ea-service-section">
<h2>לא כל עבודה עם דיג׳רידו היא אותו דבר</h2>
<p>ב<a href="/treatment">טיפול בדיג׳רידו</a> נכנסים לתהליך אישי ולומדים לעבוד באופן אקטיבי עם הנשימה היומיומית.</p>
<p>ב<a href="/sound-healing">סאונד הילינג</a> חווים מפגש נקודתי של הקשבה פאסיבית לצליל.</p>
<p>וב<a href="/lessons">שיעורי נגינה</a> מתמקדים בלימוד נגינה ובהתפתחות מוזיקלית.</p>
</section>

<section class="ea-service-section">
<h2>עקרונות השיטה</h2>
<p><strong>עבודה אקטיבית.</strong> המשתתף אינו רק מקבל חוויה פאסיבית, אלא לומד באופן אקטיבי לבנות שליטה בנשימה שלו.</p>
<p><strong>הבחנה בין טכניקה לנשימה יומיומית.</strong> הנגינה היא כלי תרגול, אך המטרה היא שינוי בדפוסי הנשימה שמלווים את האדם לאורך היום וגם בזמן השינה.</p>
<p><strong>תהליך.</strong> לא חוויה רגעית, אלא עבודה הדרגתית שמבוססת על תרגול, התמדה והעמקה.</p>
</section>

<section class="ea-service-section">
<h2>מה מייחד את שיטת cbDIDG</h2>
<p>שיטת cbDIDG אינה מתמקדת רק בנגינה או בטכניקות הנשימה המעגלית בזמן התרגול.</p>
<p>מדובר בשיטה סדורה ללימוד והטמעה של שליטה בנשימה, המבוססת על עבודה אישית, תרגול מותאם וליווי לאורך זמן.</p>
<p>הדיג׳רידו מאפשר לקבל משוב מיידי דרך הצליל, לזהות דפוסים ולדייק את העבודה, באופן שלא מתאפשר בתרגול נשימה בלבד.</p>
</section>

<section class="ea-service-section">
<h2>איך נולדה השיטה</h2>
<p>השיטה נולדה מתוך מסע אישי של חקירה, לימוד עמוק של הנשימה ורצון להתמודד עם אסטמה ואלרגיות קשות.</p>
<p>אחד המקורות המשמעותיים בדרך היה הקשר המתמשך עם המאסטר ההודי לדיג׳רידו מוקש דהימן, שהחל בשנת 2000. אייל הפך לאחד מתלמידיו הקרובים, ולמד ממנו את יסודות העבודה התרפויטית עם הדיג׳רידו.</p>
<p>לצד זה, הושפע גם מתחומים כמו טאי צ׳י, צ׳י קונג, יוגה ומיינדפולנס.</p>
</section>

<section class="ea-service-section">
<h2>למי השיטה מתאימה</h2>
<ul>
<li>לאנשים שחווים עומס רגשי, מתח בגוף או קושי לווסת את עצמם</li>
<li>לאנשים שמתמודדים עם נחירות, דום נשימה בשינה, עייפות כרונית</li>
<li>למי שמחפש תהליך אישי עמוק, ולא פתרון קסם מהיר</li>
</ul>
<p>השיטה מתאימה למי שמוכן לקחת חלק פעיל בעבודה עם הנשימה שלו, ולהתמסר לתרגול לאורך זמן.</p>
</section>

<section class="ea-service-section">
<h2>לתיאום שיחת היכרות</h2>
<p>אם הגעתם עד לכאן, כנראה שמשהו בדרך הזו נוגע בכם.</p>
<p>שיחת היכרות מאפשרת להבין יחד האם השיטה מתאימה לכם.</p>
<p><a class="ea-cta-pill ea-cta-pill--primary" href="/contact">לתיאום שיחת היכרות</a></p>
</section>
';
}

/**
 * HTML content for the Treatment page (from treatment.md — 25.5.26).
 */
function ea_w2_02_treatment_html() {
	return '
<section class="ea-service-hero">
<h1 class="ea-page-title">טיפול בדיג׳רידו</h1>
<p class="ea-page-subtitle">להחזיר שליטה על הנשימה דרך עבודה אקטיבית עם דיג׳רידו, תרגול נשימה וליווי אישי</p>
<p><a class="ea-cta-pill ea-cta-pill--primary" href="/contact">לתיאום שיחת היכרות</a></p>
</section>

<section class="ea-service-section">
<h2>משהו בנשימה שלך מבקש תשומת לב</h2>
<p>הנשימה היא לא פעולה אוטומטית לחלוטין. רוב הזמן היא מתרחשת לבד, בלי שנשים לב.</p>
<p>אבל ברגע שמפנים אליה תשומת לב, יש לנו יכולת להשפיע עליה — לשנות עומק, קצב, איכות. לבחור איך לנשום.</p>
<p>העבודה במרכז מבוססת על <a href="/method">שיטת cbDIDG</a> שפותחה לאורך השנים מתוך ניסיון מעשי, ובהשראת חניכה אישית אצל המאסטר לדיג׳רידו מוקש דהימן.</p>
</section>

<section class="ea-service-section">
<h2>מה זה טיפול בדיג׳רידו</h2>
<p>טיפול בדיג׳רידו הוא תהליך אישי שבו עובדים באופן אקטיבי עם הנשימה היומיומית.</p>
<p>הדיג׳רידו משמש ככלי עבודה, לא כמטרה. העבודה אינה על הנגינה עצמה, אלא על הדרך שבה אנחנו נושמים.</p>
<p>במהלך המפגשים לומדים: איך מערכת הנשימה פועלת בפועל, לזהות דפוסים אוטומטיים, לפתח שליטה ויכולת ויסות.</p>
</section>

<section class="ea-service-section">
<h2>למי זה מתאים</h2>
<ul>
<li>מי שמתמודד עם סטרס כרוני</li>
<li>מי שחווה מתח, חרדה או עומס רגשי מתמשך</li>
<li>מי שסובל מנחירות או דום נשימה בשינה</li>
<li>מי שרוצה ללמוד לנשום בצורה מדויקת ומטיבה יותר</li>
<li>מי שרוצה להכניס יותר שקט, מודעות ומיקוד לחיים</li>
</ul>
</section>

<section class="ea-service-section">
<h2>איך נראה מפגש</h2>
<p>המפגשים מתקיימים אחד על אחד, בסטודיו בפרדס חנה. זהו מרחב שקט ונעים, הממוקם בלב חצר ירוקה עם עצי פרי ושבילי עץ.</p>
<p>במהלך המפגש עובדים בצורה הדרגתית, בקצב שמתאים לאדם שמגיע. המפגש הראשון כולל אבחון ולכן הוא לרוב מעט ארוך יותר.</p>
<p>אין צורך בניסיון קודם. העבודה מתחילה מהבסיס.</p>
</section>

<section class="ea-service-section">
<h2>מה ההבדל בין טיפול, סאונד הילינג ושיעורים</h2>
<p><strong>טיפול בדיג׳רידו:</strong> עבודה אקטיבית עם הנשימה היומיומית, דרך תרגול בדיג׳רידו, למידה וליווי אישי. תהליך מתמשך.</p>
<p><strong><a href="/sound-healing">סאונד הילינג בדיג׳רידו:</a></strong> עבודה פאסיבית של הקשבה לצליל דרך הגוף. לרוב מפגש נקודתי.</p>
<p><strong><a href="/lessons">שיעורי נגינה בדיג׳רידו:</a></strong> לימוד נגינה והתפתחות מוזיקלית.</p>
</section>

<section class="ea-service-section">
<h2>אנשים מספרים</h2>
<blockquote><p>"כמו רבים אחרים גם אני חשבתי שאני באה ללמוד דיג׳רידו, ולא היה לי מושג איזה מסע עוצמתי מחכה לי." — <a href="https://www.facebook.com/share/p/1E7ndvYyrp/" target="_blank" rel="noopener">שירי אלקבץ</a></p></blockquote>
<blockquote><p>"מה שאני לומדת מאייל זה לנשום מחדש... להיות בנוכחות בנשימה, זה להיות בנוכחות בחיים." — <a href="https://www.facebook.com/share/p/1AdaytsL6w/" target="_blank" rel="noopener">נוית צוף שטראוס</a></p></blockquote>
<blockquote><p>"פעם ראשונה בחיים שלמדתי לנשום נכון... תרגול הנשימה בדידג׳ פשוט מרגיע אותי." — <a href="https://www.facebook.com/share/v/1Cky28MdtH/" target="_blank" rel="noopener">אלון גרזון רז</a></p></blockquote>
<p><a href="/media">לעוד המלצות ועדויות</a></p>
</section>

<section class="ea-service-section">
<p class="ea-disclaimer">המידע באתר זה אינו מהווה ייעוץ רפואי, אבחון או טיפול רפואי, ואינו מחליף פנייה לאיש מקצוע מוסמך. במקרים של מצב רפואי או נפשי, יש להתייעץ עם גורם רפואי מוסמך לפני תחילת התהליך.</p>
</section>

<section class="ea-service-section">
<h2>לתיאום שיחת היכרות</h2>
<p>לא כל אחד מגיע לכאן מאותה סיבה — אבל אצל כולם עולה אותה תחושה: משהו בנשימה מבקש תשומת לב.</p>
<p>אם זה מדבר אליך, אפשר להתחיל.</p>
<p><a class="ea-cta-pill ea-cta-pill--primary" href="/contact">לתיאום שיחת היכרות</a></p>
</section>
';
}

/**
 * HTML content for the About page (from method.md §08 + treatment.md §11 — biographical sections).
 */
function ea_w2_02_about_html() {
	return '
<section class="ea-content-section">
<h1 class="ea-page-title">אודות אייל עמית</h1>
<p>אייל עמית עוסק בעבודה עם דיג׳רידו מאז 1999, והוא מהוותיקים בארץ בתחום.</p>
<p>את המרכז לטיפול בדיג׳רידו — סטודיו נשימה מעגלית בפרדס חנה — הקים מתוך רצון להנגיש וללמד את העבודה עם הדיג׳רידו ככלי להשפעה תרפויטית על הגוף, הנשימה והתודעה.</p>
<p>לאורך השנים ליווה מאות אנשים בתהליכים אישיים, ופיתח את <a href="/method">שיטת cbDIDG</a> לטיפול באמצעות דיג׳רידו, מתוך שילוב של ניסיון מעשי וחקירה מתמשכת.</p>
</section>

<section class="ea-content-section">
<h2>הדרך</h2>
<p>הדרך שלו עם הדיג׳רידו החלה מתוך מסע אישי של חקירה ורצון להתמודד עם קשיים בריאותיים — אסטמה ואלרגיות קשות.</p>
<p>אחד המקורות המשמעותיים ביותר בדרך היה הקשר המתמשך עם המאסטר ההודי לדיג׳רידו מוקש דהימן, שהחל בשנת 2000. אייל הפך לאחד מתלמידיו הקרובים, ולמד ממנו את יסודות העבודה התרפויטית עם הדיג׳רידו.</p>
<p>לצד זה, הושפע מתחומים נוספים כמו טאי צ׳י, צ׳י קונג, יוגה ומיינדפולנס, שהעמיקו את ההבנה של הקשר בין נשימה, גוף ותודעה.</p>
</section>

<section class="ea-content-section">
<h2>הסטודיו</h2>
<p>הסטודיו ממוקם בפרדס חנה, בתוך מרחב ירוק ושקט עם חצר פתוחה, עצי פרי ושבילי עץ.</p>
<p>זהו מרחב שמאפשר לעצור, להקשיב ולהתמקד — עוד לפני שמתחילה העבודה עצמה.</p>
</section>

<section class="ea-content-section">
<h2>ספרים</h2>
<p>אייל עמית כתב והוציא לאור 3 ספרים במסגרת <a href="/muzza">מוזה הוצאה לאור</a>.</p>
</section>

<section class="ea-content-section">
<p><a class="ea-cta-pill ea-cta-pill--primary" href="/contact">לתיאום שיחת היכרות</a></p>
</section>
';
}

/**
 * HTML content for the About/Moksha sub-page (from method.md §07 — origin story).
 */
function ea_w2_02_moksha_html() {
	return '
<section class="ea-content-section">
<h1 class="ea-page-title">מוקש דהימן — לזכרו</h1>
<p>מוקש היה מאסטר לדיג׳רידו, יוגי מזרם הבהקטי שחי עם משפחתו ברישיקש, הודו. הוא התמחה בבניית כלי דיג׳רידו והקדיש את חייו להפצת הדיג׳רידו ומלאכת בנייתו בעולם.</p>
<p>פעילותו החלה באמצע שנות השבעים והסתיימה עם פטירתו בשנת 2020.</p>
</section>

<section class="ea-content-section">
<h2>הקשר עם אייל עמית</h2>
<p>אייל עמית למד אצל מוקש לאורך שנים והיה מתלמידיו הקרובים מאז שנת 2000. הקשר הזה מהווה חלק משמעותי מהבסיס שעליו נבנתה <a href="/method">שיטת cbDIDG</a>.</p>
<p>המפגש עם הדיג׳רידו דרך מוקש התחיל מתוך משיכה לצליל המיוחד שלו, אך בהמשך התגלה ככלי שמאפשר לעבוד באופן ישיר עם מערכת הנשימה.</p>
<p>לצד החיבור למוקש, אייל הושפע גם מתחומים נוספים כמו טאי צ׳י, צ׳י קונג, יוגה ומיינדפולנס — שילוב שהוביל להתגבשות של שיטה סדורה.</p>
</section>

<section class="ea-content-section">
<p><a href="/about">← חזרה לאודות אייל עמית</a></p>
</section>
';
}

/**
 * Main seeder: create/update the 6 core Wave2 pages.
 */
function ea_w2_02_seed_run() {
	// --- HOME PAGE ---
	// The home page (slug 'home') was created by ea-m2-site-tree-lock-sync-once.
	// Just update its template to tpl-home.php.
	$home = get_page_by_path( 'home', OBJECT, 'page' );
	if ( $home && $home->post_type === 'page' ) {
		update_post_meta( (int) $home->ID, '_wp_page_template', 'page-templates/tpl-home.php' );
	}

	// --- METHOD PAGE ---
	$method = get_page_by_path( 'method', OBJECT, 'page' );
	if ( $method && $method->post_type === 'page' ) {
		wp_update_post(
			array(
				'ID'           => (int) $method->ID,
				'post_title'   => "שיטת cbDIDG של אייל עמית",
				'post_content' => ea_w2_02_method_html(),
				'post_status'  => 'publish',
			)
		);
		update_post_meta( (int) $method->ID, '_wp_page_template', 'page-templates/tpl-service.php' );
	} else {
		$id = wp_insert_post(
			array(
				'post_title'   => "שיטת cbDIDG של אייל עמית",
				'post_name'    => 'method',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => ea_w2_02_method_html(),
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', 'page-templates/tpl-service.php' );
		}
	}

	// --- TREATMENT PAGE ---
	$treatment = get_page_by_path( 'treatment', OBJECT, 'page' );
	if ( $treatment && $treatment->post_type === 'page' ) {
		wp_update_post(
			array(
				'ID'           => (int) $treatment->ID,
				'post_title'   => "טיפול בדיג'רידו",
				'post_content' => ea_w2_02_treatment_html(),
				'post_status'  => 'publish',
			)
		);
		update_post_meta( (int) $treatment->ID, '_wp_page_template', 'page-templates/tpl-service.php' );
	} else {
		$id = wp_insert_post(
			array(
				'post_title'   => "טיפול בדיג'רידו",
				'post_name'    => 'treatment',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => ea_w2_02_treatment_html(),
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', 'page-templates/tpl-service.php' );
		}
	}

	// --- FAQ PAGE ---
	$faq = get_page_by_path( 'faq', OBJECT, 'page' );
	if ( $faq && $faq->post_type === 'page' ) {
		wp_update_post(
			array(
				'ID'          => (int) $faq->ID,
				'post_title'  => 'שאלות נפוצות',
				'post_status' => 'publish',
			)
		);
		update_post_meta( (int) $faq->ID, '_wp_page_template', 'page-templates/tpl-faq.php' );
	} else {
		$id = wp_insert_post(
			array(
				'post_title'   => 'שאלות נפוצות',
				'post_name'    => 'faq',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', 'page-templates/tpl-faq.php' );
		}
	}

	// --- CONTACT PAGE ---
	$contact = get_page_by_path( 'contact', OBJECT, 'page' );
	if ( $contact && $contact->post_type === 'page' ) {
		wp_update_post(
			array(
				'ID'          => (int) $contact->ID,
				'post_title'  => 'צור קשר',
				'post_status' => 'publish',
			)
		);
		update_post_meta( (int) $contact->ID, '_wp_page_template', 'page-templates/tpl-contact.php' );
	} else {
		$id = wp_insert_post(
			array(
				'post_title'   => 'צור קשר',
				'post_name'    => 'contact',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', 'page-templates/tpl-contact.php' );
		}
	}

	// --- ABOUT PAGE ---
	// Create /about as a separate canonical page.
	// The site-tree eyal-amit page redirects to /about via wave2-w2-02.php.
	$about = get_page_by_path( 'about', OBJECT, 'page' );
	if ( $about && $about->post_type === 'page' ) {
		wp_update_post(
			array(
				'ID'           => (int) $about->ID,
				'post_title'   => 'אודות אייל עמית',
				'post_content' => ea_w2_02_about_html(),
				'post_status'  => 'publish',
			)
		);
		update_post_meta( (int) $about->ID, '_wp_page_template', 'page-templates/tpl-content.php' );
		$about_id = (int) $about->ID;
	} else {
		$about_id = wp_insert_post(
			array(
				'post_title'   => 'אודות אייל עמית',
				'post_name'    => 'about',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => ea_w2_02_about_html(),
			)
		);
		if ( $about_id && ! is_wp_error( $about_id ) ) {
			update_post_meta( $about_id, '_wp_page_template', 'page-templates/tpl-content.php' );
		} else {
			$about_id = 0;
		}
	}

	// --- ABOUT/MOKSHA SUB-PAGE ---
	if ( $about_id > 0 ) {
		$moksha_path = 'about/moksha';
		$moksha      = get_page_by_path( $moksha_path, OBJECT, 'page' );
		if ( ! $moksha ) {
			$moksha = get_page_by_path( 'moksha', OBJECT, 'page' );
		}
		if ( $moksha && $moksha->post_type === 'page' ) {
			wp_update_post(
				array(
					'ID'           => (int) $moksha->ID,
					'post_title'   => 'מוקש דהימן — לזכרו',
					'post_content' => ea_w2_02_moksha_html(),
					'post_parent'  => $about_id,
					'post_status'  => 'publish',
				)
			);
			update_post_meta( (int) $moksha->ID, '_wp_page_template', 'page-templates/tpl-content.php' );
		} else {
			$moksha_id = wp_insert_post(
				array(
					'post_title'   => 'מוקש דהימן — לזכרו',
					'post_name'    => 'moksha',
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_parent'  => $about_id,
					'post_content' => ea_w2_02_moksha_html(),
				)
			);
			if ( $moksha_id && ! is_wp_error( $moksha_id ) ) {
				update_post_meta( $moksha_id, '_wp_page_template', 'page-templates/tpl-content.php' );
			}
		}
	}

	flush_rewrite_rules( false );
}
