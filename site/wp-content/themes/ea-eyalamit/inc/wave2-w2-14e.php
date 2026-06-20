<?php
/**
 * WP-W2-14-E — Memorial + Galleries + Media: 3 new elevated pages.
 *
 * Force-routes the 3 top-level slugs (/mokesh-dahiman, /galleries, /media) to
 * page-templates/tpl-catalog-14e.php, marks them as Wave2 active views for the
 * Stage-B chrome/asset hygiene, enqueues the dedicated catalog sheet
 * (assets/css/w2-14e-catalog.css), and renders each page's composition from the
 * mockup (team_35 handoff-WP-W2-10-MOBILE).
 *
 * Pattern mirrors inc/wave2-w2-04.php (slug→tpl map, template_include @ 100,
 * ea_wave2_shell query var on template_redirect, body-class / sidebar / GP-title
 * filters, scoped enqueue). Compositions reuse the canonical topnav + footer
 * blocks via the template chrome; the per-page bodies are rendered here.
 *
 * D-14: zero new tokens/atoms/keyframes. The memorial copy is VERBATIM from Eyal's
 * FULL memorial doc (team_110 2026-06-21, D-MOKESH — supersedes the «ומה היום»
 * fragment); the design keeps the team_35 elevated shell. Media per D-FILM / the
 * 2026-06-16 capture: hero trailer + 19 photos + full-film placeholder + 4 FB embeds.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Top-level slugs handled by this WP → template.
 *
 * @return array<string,string>
 */
function ea_w2_14e_slugs() {
	return array(
		// Memorial canonical slug (site-tree) + the legacy 'moksha' page
		// (/about/moksha, id 181) that all memorial URLs currently resolve to —
		// both render the elevated memorial so the dignified page is what users
		// reach regardless of which URL the nav/redirects land on.
		'mokesh-dahiman' => 'tpl-catalog-14e',
		'moksha'         => 'tpl-catalog-14e',
		'galleries'      => 'tpl-catalog-14e',
		'media'          => 'tpl-catalog-14e',
	);
}

/**
 * Resolve the current request to a 14-E page slug, or '' if not a 14-E view.
 * Top-level pages only (post_parent === 0).
 *
 * @return string
 */
function ea_w2_14e_current_slug() {
	if ( ! is_page() ) {
		return '';
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) ) {
		return '';
	}
	$slugs = ea_w2_14e_slugs();
	// Match by exact (unique) slug — NOT top-level-only: /mokesh-dahiman is a
	// child of /eyal-amit (post_parent != 0) yet must route to 14-E. The three
	// 14-E slugs are unique, so a parent check is unnecessary and was wrongly
	// excluding the memorial page.
	if ( isset( $slugs[ $post->post_name ] ) ) {
		return $post->post_name;
	}
	return '';
}

/**
 * True when the current request is a 14-E page.
 *
 * @return bool
 */
function ea_w2_14e_is_page() {
	return '' !== ea_w2_14e_current_slug();
}

/**
 * Resolve the current request into a 14-E route context, or null.
 *
 * Shape: array( 'slug' => string ).
 *
 * @return array<string,string>|null
 */
function ea_w2_14e_ctx() {
	$slug = ea_w2_14e_current_slug();
	if ( '' === $slug ) {
		return null;
	}
	return array( 'slug' => $slug );
}

/**
 * Force-route 14-E pages to tpl-catalog-14e. Priority 100 — after legacy filters.
 *
 * @param string $tpl Current template path.
 * @return string
 */
function ea_w2_14e_template_include( $tpl ) {
	$slug = ea_w2_14e_current_slug();
	if ( '' === $slug ) {
		return $tpl;
	}
	$slugs = ea_w2_14e_slugs();
	$t     = locate_template( 'page-templates/' . $slugs[ $slug ] . '.php' );
	if ( $t ) {
		return $t;
	}
	return $tpl;
}
// Priority 102 so WP-W2-14-E's elevated compositions win over the prior
// W2-07 editorial router (priority 101), which also claimed /mokesh-dahiman.
// The team_35 memorial mockup (dignified sand-ring + verbatim copy) supersedes
// the generic editorial elevation there; galleries/media are unaffected.
add_filter( 'template_include', 'ea_w2_14e_template_include', 102 );

/**
 * Mark 14-E force-routed pages as a Wave2 active view for Stage-B asset hygiene.
 */
add_action( 'template_redirect', function () {
	if ( ea_w2_14e_is_page() ) {
		set_query_var( 'ea_wave2_shell', true );
	}
} );

/**
 * Body classes: ea-wave2-shell + ea-14e-<slug>.
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_w2_14e_body_class( $classes ) {
	$slug = ea_w2_14e_current_slug();
	if ( '' === $slug ) {
		return $classes;
	}
	if ( ! in_array( 'ea-wave2-shell', $classes, true ) ) {
		$classes[] = 'ea-wave2-shell';
	}
	$classes[] = 'ea-14e-' . $slug;
	return $classes;
}
add_filter( 'body_class', 'ea_w2_14e_body_class', 102 );

/**
 * No sidebar on 14-E pages.
 *
 * @param string $layout
 * @return string
 */
function ea_w2_14e_sidebar_layout( $layout ) {
	if ( ea_w2_14e_is_page() ) {
		return 'no-sidebar';
	}
	return $layout;
}
add_filter( 'generate_sidebar_layout', 'ea_w2_14e_sidebar_layout', 103 );

/**
 * Hide GeneratePress content title on 14-E pages (the H1 is inside the body).
 *
 * @param bool $show
 * @return bool
 */
function ea_w2_14e_hide_gp_title( $show ) {
	if ( ea_w2_14e_is_page() ) {
		return false;
	}
	return $show;
}
add_filter( 'generate_show_title', 'ea_w2_14e_hide_gp_title', 103 );

/**
 * Enqueue the 14-E catalog sheet (memorial + galleries + media). Dep on
 * ea-wave2-atoms keeps load order after the atoms (matches the cluster-sheet
 * convention). Scoped to the 3 routes only — NOT enqueued via the 14-A block.
 */
function ea_w2_14e_assets() {
	if ( is_admin() || ! ea_w2_14e_is_page() ) {
		return;
	}
	wp_enqueue_style(
		'ea-w2-14e-catalog',
		get_stylesheet_directory_uri() . '/assets/css/w2-14e-catalog.css',
		array( 'ea-wave2-atoms' ),
		wp_get_theme()->get( 'Version' )
	);

	// Memorial only: the YouTube-IFrame-API hero trailer (muted autoplay + unmute).
	// Galleries/media don't need it. Loaded in the footer; the API script is injected
	// by the module itself, gated on prefers-reduced-motion.
	$slug = ea_w2_14e_current_slug();
	if ( 'mokesh-dahiman' === $slug || 'moksha' === $slug ) {
		wp_enqueue_script(
			'ea-mokesh',
			get_stylesheet_directory_uri() . '/assets/js/ea-mokesh.js',
			array(),
			wp_get_theme()->get( 'Version' ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'ea_w2_14e_assets', 29 );

/* ═══════════════════════════════════════════════════════════════════════════
 * Render dispatch
 * ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Render the composition for a resolved 14-E route.
 *
 * @param array<string,string>|null $ctx From ea_w2_14e_ctx().
 */
function ea_w2_14e_render( $ctx ) {
	$slug = is_array( $ctx ) && isset( $ctx['slug'] ) ? (string) $ctx['slug'] : '';
	switch ( $slug ) {
		case 'mokesh-dahiman':
		case 'moksha':
			ea_w2_14e_render_memorial();
			break;
		case 'galleries':
			ea_w2_14e_render_galleries();
			break;
		case 'media':
			ea_w2_14e_render_media();
			break;
	}
}

/**
 * Theme image URL helper — returns the asset URL when the file exists in
 * assets/images/, else ''. Lets compositions degrade to placeholders.
 *
 * @param string $file Filename within assets/images/.
 * @return string
 */
function ea_w2_14e_img( $file ) {
	$path = get_stylesheet_directory() . '/assets/images/' . $file;
	if ( is_readable( $path ) ) {
		return get_stylesheet_directory_uri() . '/assets/images/' . $file;
	}
	return '';
}

/* ═══════════════════════════════════════════════════════════════════════════
 * MEMORIAL — /mokesh-dahiman (SENSITIVE — copy VERBATIM from the mockup)
 * ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Trailer (public) — verified title "MUKESH - The Art of Shanti Living | Official Trailer",
 * channel Kuthli Studio (= קוטלי). The full ~60-min film is NOT public yet (placeholder).
 *
 * @return string YouTube video id.
 */
function ea_w2_14e_mokesh_trailer_id() {
	return 'kf4NKSdYi9E';
}

/**
 * Ordered media-library attachment IDs for the 19 memorial photos. Seeded once by
 * mu-plugins/ea-w2-14e-mokesh-media-seed-once.php (option ea_mokesh_photo_ids).
 * Empty until the seeder runs (page degrades gracefully — no photo grid).
 *
 * @return int[]
 */
function ea_w2_14e_mokesh_photo_ids() {
	$ids = get_option( 'ea_mokesh_photo_ids', array() );
	if ( ! is_array( $ids ) ) {
		return array();
	}
	return array_values( array_filter( array_map( 'intval', $ids ) ) );
}

/**
 * Facebook post embeds at the very bottom (media capture 2026-06-16, 4 posts).
 *
 * @return string[]
 */
function ea_w2_14e_mokesh_fb_posts() {
	return array(
		'https://www.facebook.com/IsraelDidgCenter/posts/pfbid02G6viGTqgqTHFv36najD6n9T6yskVpC5UfWx1RzrbNTqNMfTYRKrJkzkqHH2taffXl',
		'https://www.facebook.com/eyal.amit.muzza/posts/pfbid033bDz4Wj8Pc6K3nF58VuXBUHkfoNKPZa4wTsxhPSUVHANHwZT3rAqj1oUAGXzwTm6l',
		'https://www.facebook.com/eyal.amit.muzza/posts/pfbid0zekNyNV6dztxGnwQKaLg9GhSAwSsjMWR2jaqQtAkZMLAHWNhKem12AknNrsCAJZRl',
		'https://www.facebook.com/gemma.calaf/posts/pfbid0gsUdiLtCCghgQp9RuyPncdb4NRojZ3k5LdxMqfeNPinvQd9x6Y7j6Jrp9VUThqiEl',
	);
}

/**
 * Memorial narrative sections — VERBATIM from Eyal's full memorial doc
 * (from-eyal/תוכן לאתר 25.5.26/מוקש דהימן/מוקש דהימן – מאסטר דיג'רידו – דף להנצחת זכרו ופועלו 1950-2020.docx).
 * Headings = the doc's section headings (so the content-diff gate's section/invented
 * checks pass). Brand rendered «Jungle Vibes» per D-SPELLING (source mixes jungle/jungel;
 * the gate normalizes both). Bodies are nowdoc blobs (paragraph per line, no escaping).
 *
 * @return array<int,array{id:string,eyebrow:string,heading:string,body:string}>
 */
function ea_w2_14e_mokesh_sections() {
	return array(
		array(
			'id'      => 'ea-mem-s1',
			'eyebrow' => 'לזכרו',
			'heading' => 'מי היה מוקש דהימן?',
			'body'    => <<<'HE'
מוקש דהימן היה אמן-נגר, בונה דיג'רידו ומורה מרישיקש שבהודו, שכבר בתחילת שנות השבעים הקדיש את חייו למלאכת בנייתו של הדיג'רידו ולהפצתו ככלי נשימה, ריפוי וחיבור ללב.
מתוך בית מלאכה צנוע סמוך לגדת נהר הגנגס, בנה מוקש במשך עשרות שנים כלי דיג'רידו בעבודת יד, ואירח ולימד אלפי מטיילים מכל העולם את מלאכת הבנייה, הנשימה וההקשבה דרך הכלי. בדרכו הפשוטה, הצנועה והעמוקה, הפך מוקש לאחת הדמויות המשפיעות בהפצת הדיג'רידו בעולם המערבי.
אייל עמית, מורה ומטפל בדיג'רידו בישראל, פגש את מוקש בשנת 2000, למד ממנו לאורך השנים, והפך לתלמידו הקרוב ולאחד ממשיכי דרכו. עמוד זה נכתב לזכרו, להנצחת פועלו ולשמירת מורשתו של האיש שידע, דיבר ולימד שפה אחת בלבד - שפת הלב.
ומכאן, במילותיי, הסיפור האישי שלי עם מוקש - האיש, המורה, החבר, והלב שממשיך להדהד דרך כל נשימה וכל צליל.
HE
		),
		array(
			'id'      => 'ea-mem-s2',
			'eyebrow' => 'ההתחלה',
			'heading' => "היכרותו הראשונה של מוקש עם הדיג'רידו",
			'body'    => <<<'HE'
סיפורו של מוקש מתחיל בסוף שנות השישים של המאה הקודמת. כמעט לפני 50 שנה. להקת הביטלס מגיעה לאשרם של מהרישי ברישיקש ויחד אתם נפתח לרווחה שער התיירות המערבית. מאות ואלפים החלו נוהרים לעיירה הקדושה, מחפשים מקום להניח בו את ראשם. בעלי מקצוע מכל רחבי הודו נקראו למשימה – לבנות מלונות ולהקים אשרמים. מוקש באותם ימים עדיין נער צעיר, מגיע מקסטה של אמנים-נגרים, נקרא למשימה ביחד עם אביו. כאמנים-נגרים הם היו אחראיים על החלונות, הדלתות, התגליפים ופיתוחי העץ במלון.
בין לבין ובסיום כל יום עבודה החל מוקש להתערבב קצת עם התיירים. אט אט למד כמה מילים בשפה האנגלית - מה שאפשר לו תקשורת ברמה בסיסית, אך בהחלט מספקת. זה מדהים לגלות איזה שיחות נפש אפשר לנהל בהודו עם אדם שבאוצר המילים שלו יש פחות ממאה מילים, אבל הלב שלו פתוח.
יום אחד, בתחילת שנות השבעים, הגיע למלון בו מוקש ואבא שלו עבדו, תייר אוסטרלי חביב עם תיק גב ובידו אחז גזע במבוק ארוך ועבה - לא בדיוק המראה הקלאסי של "מקל הליכה". כשמוקש שאל אותו באנגלית שבורה מה פשר הדבר, התייר הצמיד את גזע הבמבוק לשפתיו והשמיע צליל ארוך ומתמשך שהרעיד כל תא ותא בגופו של מוקש. דקות ארוכות הוא עמד שם המום, עם לסת שמוטה, לא מאמין מה הוא שומע, מה הוא רואה ומה הוא מרגיש. לא רק תאי גופו רעדו, כי אם גם נפשו תודעתו וכל הווייתו. היה זה הצליל שכל הודי מכיר כבר מיום היוולדו, צליל שטבוע לכולנו עמוק בDNA, צליל שבלתי אפשרי להישאר אליו אדיש, צליל הבריאה, צליל היקום כולו, צליל האחד המושלם, השלם והמופלא מכל – צליל ה-אום. ולא "סתם" אום, אום שלא נגמר! אום אינסופי שנמשך ונמשך דקות ארוכות ללא הפסקה. ובין לבין האוסטרלי נושם והאום לא עוצר ולא מפסיק. מוקש נגנב. עד העצמות הוא נגנב. ואם זה לא הספיק, הצליל הפילאי הזה עוד הופק מכלי העשוי מעץ! והוא אמן-נגר! סקרנותו לגבי "חליל האום" המכושף הזה הרקיעה לשחקים. הוא ביקש יפה והתייר האוסטרלי הסכים ללמד אותו. לא עברו כמה דקות ומוקש כבר הטמיע את טכניקת הנשימה המעגלית בצורה חלקה ונקייה כאילו נולד אתה והכיר אותה כל חייו. מי יודע, אולי מגלגול קודם.
אם מקודם זה היה מוקש שעמד המום, עכשיו היה זה תורו של האוסטרלי לשמוט את הלסת. טכניקת הנשימה המעגלית בדיג'רידו ידועה כמאתגרת מאוד ולמרבית האנשים כלל איננה אינטואיטיבית. לאדם הממוצע לוקח זמן רב עד שהטכניקה הזו נרכשת ומוטמעת, בטח ובטח לא עניין של דקות.
ואכן, אחרי הכירות אישית עמוקה שלי עם מוקש, כמעט שלושה עשורים אחרי אותו מפגש עם התייר האוסטרלי - אם היו מבקשים ממני לתאר את האיש הנדיר הזה בכמה מילים, ומבלי להשתמש במילה "מואר", אז מרבית המילים שהייתי משתמש בהן היו "מיוחד, בלתי רגיל בעליל, רחוק מאוד מהממוצע, צנוע ופשוט, חייכן ואופטימי, מסתפק במועט ומוכיר תודה על הקיים, מיטיב עם סביבתו ונוכח בצורה באבסולוטית". ואם היו נותנים לי להוסיף עוד כמה מילים, אז גם הייתי אומר עליו שהוא איש שחי, עשה, ידע, דיבר ולימד כל חייו רק שפה אחת - את שפת הלב.
מוקש מעולם לא פגש אבוריג'יני, מעולם לא ניגן בכלי נגינה כלשהו ומעולם גם לא יצא מגבולות הודו בגופו. למעשה, הפעמים בהן יצא מביתו היו בעיקר לצרכי יאטרה במקומות קדושים וביקור חבריו הסהדואים בפסגות ההימליה. מוקש עצמו היה איש משפחה עם בית אישה וילדים, אך אורח החיים הסהדואי תמיד משך ועניין אותו. הוא חי חיים צנועים ונטולי חומר עד כמה שניתן. ממילים ותארי כבוד למיניהם כגון "מורה, מאסטר, חכם, באבא ו-גורו" הוא לגמרי סלד. מוקש ג'י אולי היה הכינוי היחיד שעוד איכשהו הסכים לקבל. "אני איש חופשי" – תמיד היה נוהג לומר בצניעות. וכשהיה פונה לאחרים הוא תמיד היה משתמש ב-בראדר ו-סיסטר.
ברבות השנים זכה מוקש לביקורים רבים של סהדואים גדולים שחלקו לו כבוד רב ותמיד ראו בו כאחד משלהם – אח למנטרה. מיוחד, בלתי רגיל בעליל ורחוק מאוד מהממוצע, כבר אמרתי.
HE
		),
		array(
			'id'      => 'ea-mem-s3',
			'eyebrow' => 'רישיקש',
			'heading' => 'בית המלאכה ברישיקש',
			'body'    => <<<'HE'
מאז אותו מפגש מכונן עם "צינור האום" מוקש החליט להקדיש את חייו לדיג'רידו. הוא ראה בהפצתו שליחות של ממש. הוא הקים בית מלאכה קטן וצנוע בחצר ביתו השוכן מרחק הליכה מגדת הגנגס, קרוב לשוק הגדול של רישיקש. ושם, ללא שימוש בכלים חשמליים, על רצפת בוץ מסורתית, החל במלאכת בניית כלי הדיג'רידו. בהתחלה מעץ במבוק ובהמשך מגזעי עץ מקומיים קשים. גרזן, מיפסלת, פטיש, אבא-שיווה, אמא-גנגה והאל ווישהו-קארמה היו לו למדריכים והראו לו את הדרך. ללא שום פירסום, ורק משמועות פה לאוזן, החלו להופיע בחצרו תיירים מערביים סקרנים. בהתחלה הגיעו בטפטופים ובהמשך באו בשיירות. חבורות חבורות היו יושבים אצלו בחצר מבוקר עד ליל ועל בסיס יומי. במשך שבועות וחודשים ארוכים, ובהנחייתו המסורה, היו בונים לעצמם, בעבודת יד, דיג' יפייפה עם סאונד חלומי, ובמקביל כמובן גם למדו את טכניקות הנשימה דרכו. "העולם זקוק לדיג'רידו. אם העולם ינגן בדיג'רידו לא יהיו יותר מלחמות," הסביר לי פעם בשפתו המיוחדת והוסיף, "shanti play mantra inside – shanti coming home".
HE
		),
		array(
			'id'      => 'ea-mem-s4',
			'eyebrow' => 'תודעה',
			'heading' => 'מוקש במרחבי ה- Dream Time',
			'body'    => <<<'HE'
אם כבר הזכרתי את נגני הדיג' של היום, אז באופן כללי, בסצנת הדיג'רידו העולמית ובקורלציה מוחלטת לתדר העולמי המהיר והתזזיתי שאנו חיים בו כיום, לא מפתיע שהחשיפה שלנו לדיג'רידו בעת הנוכחית היא בעיקר דרך מוסיקת טראנס אלקטרונית ומגוון הרכבים ואמני דיג'רידו מפורסמים שנותנים בראש בפסטיבלים ובמסיבות עם טכניקות ביט בוקס מוטרפות ובמקצבים במהירות האור. באופן כללי, הגישה הרווחת היום בסצנת הדיג'רידו העולמית - לנגן כמה שיותר מהר – ככה יותר טוב. יוטיוב מלא היום בסרטונים בעיקר מהז'אנר הזה, ובהתאם גם נפוצים מורים לדיג'רידו המלמדים בעיקר את הפן המוסיקלי-פרפורמרי של הדיג' והרבה פחות את הפן המדיטטבי-תרפוייתי שלו.
אז כן, הדיג'רידו בהחלט יודע לעשות גם את זה – לתת בראש בהופעות. אבל, צריך לזכור שלאבוריג'ינים לא היו מחשבים וגם לא היו להם לופרים, וטכניקת הדיג'-בוקס הכה פופולרית היום היא בכלל המצאה מערבית של ה-10-15 שנים האחרונות. זה אחלה וזה לגמרי מגניב ולחלוטין יש לזה מקום, אבל במקור, הדיג'רידו מגיע מעולם אחר לגמרי. למעשה בדיוק מהצד השני של הסקלה.
הדיג'רידו מגיע מעולם קדום, שורשי, שמאני, מאגי. עולם של ציידים-לקטים שחיו בהרמוניה עם האדמה, עם המים, עם החי, הצומח והדומם. תרבות נוודית שהיתה לגמרי אחד עם הטבע סביבה והשתמשה בדיג'רידו ככלי ריפוי, ככלי תיקשור, ככלי טיקסי וככלי המתווך בין העולם הזה לעולמות שמעבר. המושג האבוריג'יני Dream-Time בהקשר של דיג'רידו, מתאר למעשה את אותו מרחב תודעה חלימתי-אחדותי-מדיטטבי אליו אנו שואפים כל חיינו בתרגולי היוגה שלנו. עבור האבוריג'ינים היתה זו דרך חיים.
מוקש, שבמשך כל חייו חקר את נושא הנשימה והתודעה דרך צינור האום, ולמעשה תירגל באופן יום יומי את כל אותן טכניקות פראניימה שהיו מוכרות לו מהעולם היוגי-סהדואי, אט אט נחשף למנטרות נשימה מסוימות שהחלו להתגלות בפניו. מנטרות שאפשרו לו להיכנס פנימה, עוד ועוד, ולהתחבר לאותו מרחב תודעתי-אחדותי-מדיטטבי - מהסוג שרק יוגים גבוהים במיוחד זכו בחייהם לפגוש.
HE
		),
		array(
			'id'      => 'ea-mem-s5',
			'eyebrow' => 'החלום',
			'heading' => 'קוטלי - הסטודיו החדש בהימליה',
			'body'    => <<<'HE'
הזמנים משתנים ... כוחות כלכליים חדשים בהודו מביאים את בית המלאכה ברישיקש לטבוע מתחת למגדלי בטון, פלסטיק, מסכי סמארטפונים, רעש צופרים וזיהום אוויר קשה. העיירה השקטה והשלווה על גדת הגנגס הפכה לעיר סואנת. חנק של ממש לאמנים כמו מוקש שאט אט נדחקו לצדדים ונעלמו.
מוקש, שכל חייו נמשך לאורח החיים הסהדואי, ושמושג ה"שאנטי" הפך אמונתו ודרך חייו, החליט לחפש אדמה חדשה, הרחק מהמולת העיר, קרוב יותר לטבע, בפשטות, כמו בימים ההם. להקים מקום חדש, מבודד בהרים, שישמש עבורו ועבור אמנים מכל רחבי העולם כמקלט ליצירתיות, לאמנות, למוזיקה, לתרגול וללמידה. מקום שיאפשר לו לפרוש לגמלאות ולהזדקן בשקט ובשלווה.
בשאנטי.
בעזרתם הפיננסית של שניים מתלמידיו המקורבים ובעזרת רשת קהילת המטיילים הגלובלית שכבר הכירה את פועלו ותרמה כספים, גוייס הסכום המבוקש. האדמה המתאימה נמצאה בקוטלי - כפר קטן ובתולי למרגלות ההימלאיה, 1000 מטר מעל רישיקש, כשעתיים נסיעה מביתו שבעיר. כפר פסטורלי העוסק רובו בחקלאות המשקיף על כל העמק ועל נהר הגנגס המתפתל עד קצה האופק.
בשנת 2013 העבודה החלה, אך במהרה גילה מוקש כי סכום הכסף שגוייס לא מספיק להשלמת הפרוייקט. הכסף הספיק רק להקמת בקתה קטנה וצנועה של חדר אחד ולהנחת היסודות הראשונים של הסטודיו. חלומו של מוקש נאלץ לחכות. הסטודיו נותר חשוף על יסודותיו, ללא גג וללא קירות וללא אפשרות אמיתית להגשים את חלום הפרישה שלו.
בשנת 2018, כמעט 6 שנים לאחר שהפרוייקט נעצר, ואחרי למעלה מעשור שלא נפגשנו, הגעתי עם אשתי ושני ילדיי לביקור אצל מוקש. הגענו אליו אחרי שנה של מסע עם הילדים במזרח. מיותר להדגיש את עוצמת השמחה וגובה ההתרגשות באוויר. יומיים לפני שמוקש לקח אותנו לראות את יסודות הפקוייקט העומד תקוע בקוטלי, הספקתי להעניק לו את שני ספריי האחרונים שבין דפיהם כתובים עליו סיפורים. פוג'ה חגיגית בגנגס וצילום מרגש של שנינו עם הספרים לגמרי התבקש.
הביקור בקוטלי היה עוצמתי ומפעים, בייחוד המפגש של הילדים שלי עמו. זו אמנם היתה הפעם הראשונה ולצערי גם האחרונה שהם נפגשו, אך המפגש היה מרגש ומבורך כל כך - ועל כך אהיה אסיר תודה תמיד. האיש המיוחד הזה, שתמונתו תלויה אצלנו בבית על הקיר, ואינספור הסיפורים ששמעו עליו ממני כל חייהם, סוף סוף זכו לפגוש אותו ולהכירו מקרוב.
אחרי סיור מקיף בין יסודות הסטודיו החדש וכמה שיחות של השלמות פערים, קלטתי שמוקש זקוק לעזרה. הוא כבר מזדקן וההמתנה האינסופית הזו לנס שיבוא ויאפשר לו להשלים את הפרוייקט – לא ממש תרמו למצבו הבריאותי. באותם רגעים קול חזק וברור הדהד עמוק בתוכי - זה עכשיו או לעולם לא. והנס הזה, שמוקש ממתין לו בסבלנות כה רבה ומעוררת פליאה כבר 6 שנים, הוא לא אחר מאשר אני. עבורי זו היתה ההזדמנות להוכיר לו תודה אמיתית ו"להשיב לו כגמולו" על כל אותן מתנות הקסם שהעניק לי בכל שנות היכרותנו. על הדיג'רידו, על הנשימה, על החיבור לעצמי, על הסטודיו המשגשג שלי, על האהבה ללא תנאי הזאת שהרעיף עלי תמיד. ידעתי שזו הולכת להיות משימה מורכבת ומאתגרת מאוד, אבל אהבתי ותודתי אליו חזרה היתה גדולה בהרבה.
HE
		),
		array(
			'id'      => 'ea-mem-s6',
			'eyebrow' => 'הגשמה',
			'heading' => 'הגשמת החלום',
			'body'    => <<<'HE'
חצי שנה אח"כ נפגשנו שוב. אח שלי גיא, שהספיק כבר להכיר את מוקש בעבר, הצטרף אלי למסע. נסענו יחד, לשבועיים וחצי, נטו לשהות במחיצתו של מוקש, וכמובן לקדם את עניין הסטודיו בקוטלי.
בשל היכרותנו העמוקה והאמון המחלט השורר בנינו, מוקש הסכים להעניק לנו אישור מיוחד לצלם אותו, מתי, איפה וכמה שאני רוצה. בכל מצב, בכל סיטואציה, בכל מקום ובכל זמן. בלי ליידע אותו ובלי לשאול אותו מראש. גיא ואני צילמנו אותו בכל מני סיטואציות ומצבים שעדשת מצלמה מעולם לא ראתה בעבר. רגעים עם המשפחה שלו, עם הילדים, עם אשתו, ואפילו עם הנכדה שלו. שום דבר איננו מבויים בסרט הזה. וכדי לשמור על הפשטות והטבעיות בסיטואציות, הכל צולם במצלמת הטלפון הנייד. אם הייתה לי שאלה והסיטואציה אפשרה זאת, פשוט שאלתי ומוקש ענה. רוב הזמן, לא היה צורך בדיבורים. מוקש הוא לא איש שמרבה להשתמש במילים. שאנטי זוכרים. כשהלב פתוח, באמת באמת פתוח, אין שום צורך במילים. השפה היחידה שמוקש דובר בה היא שפת הלב, ובשבילה - לא צריך הרבה מילים.
מהחומרים הסופר נדירים שצילמנו, זיקקנו ברגישות ובזהירות רבה את האיש הזה. ניסינו לענות על השאלה הפשוטה - מי זה מוקש, מה כל כך מיוחד באיש הזה, איך זה שאלפי אנשים מסביב לגלובוס ביקרו בסדנה שלו במהלך ארבעת העשורים האחרונות ועדיין ממשיכים להגיע מכל קצוות תבל. תיעוד נדיר ומרגש של שבועיים וחצי בחייו.
אחרי כמה חודשים ארוכים של עריכה, הסרט בן ה-60 דקות הושלם. כאן בתחתית העמוד תוכלו לצפות בקטע קצר ממנו המהווה פרומו בלבד לסרט המלא.
בעזרתו של גיא ועוד שני תלמידים ותיקים נוספים של מוקש שהתמזל מזלי להכיר, ג'מה הספרדייה ובאצ'ו הגיאורגי, הרמנו פרוייקט גיוס המונים עולמי וגם פתחנו דף פייסבוק לסרט MUKESH - The Art of Shanti Living
הקרנתו הראשונה והמרגשת של הסרט התקיימה במסגרת פסטיבל הדיג'רידו הישראלי. מאות אנשים שמרביתם כלל לא הכירו את מוקש, שמעו לראשונה על האיש ופועלו. בהמשך התקיימו הקרנות נוספות בארץ ובמקומות שונים בעולם. כולם בוצעו ע"י תלמידים ותיקים של מוקש ששמחו לתת יד ולתמוך בפרוייקט. ממכירת הכרטיסים בהקרנות ומתרומות נדיבות של אנשים מסביב לגלובוס, הצלחנו לגייס את סכום הכסף הנדרש.
בשנת 2019 חודשה הבנייה בקוטלי. מוקש לא ידע את נפשו מרוב התרגשות ושמחה. מאיש מזדקן ועייף הוא הפך בין רגע לפועל בניין חרוץ ומסור, שכל כוחותיו שבו אליו. מדי כמה ימים הייתי מקבל מבניו תמונות וסרטונים המתעדים את תהליך הבנייה. כבר יש גג, והקומה השנייה הושלמה, והמרפסות שמשקיפות לגנגס. הכל קורה! רגעים של אושר צרוף שבאמת קשה לתאר כאן במילים. איזו זכות!
בראש שלי כבר עשיתי תוכניות להמשך. תכננתי להגיע שוב לביקור, והפעם לצלם את ה-"אחרי". להראות בסוף הסרט שהחלום של מוקש הוגשם, ושהסטודיו הושלם, פעיל ושוקק חיים. האם יכול להיות סוף שמח וטוב יותר מזה?
מושלם!!!
HE
		),
		array(
			'id'      => 'ea-mem-s7',
			'eyebrow' => '2020',
			'heading' => 'תפנית חדה בעלילה',
			'body'    => <<<'HE'
אז כן, כעבור שנה של בנייה אינטנסיבית במו ידיו של מוקש, ארבעת בניו ועוד מספר פועלים, הסטודיו בקוטלי הושלם. מוקש זכה להגשים את חלומו הישן ולראות את המקום עומד ומוכן. חגיגות הפתיחה כבר היו מעבר לפינה, אך למציאות היו תוכניות מעט אחרות עבורו. עבורו ועבור העולם כולו. וירוס הקורונה של שנת 2020 טרף את כל הקלפים. השמיים נסגרו, התיירות חוסלה כליל, והאנושות כולה נכנסה לסגר מלא בבתים. גל ראשון, גל שני, ובינתיים בהודו המצב רק הולך ומחריף. עוצר מחלט שלא אפשר כמעט תנועה. מוקש, כמו יתר ההודים, ישב כמעט שנה שלמה בבית ללא יכולת תנועה. והאיש הזה, שהוא סמל החופש, סמל העצמאות והשאנטי, שחיכה בסבלנות כה רבה להשלמת הסטודיו שלו בהימליה, שכבר סיים את מלאכת הבנייה ורק חיכה שחיי הפרישה החדשים שלו יתחילו, צריך עכשיו לשבת בבית. לשבת ולא לזוז לאף מקום. ציפור דרור שנכלאה בכלוב. את הקושי ההולך ומתגבר אצלו יכולתי להרגיש בשיחות הטלפון שלנו. חוסר הפעילות המתמשכת בהחלט לא תרמה לבריאותו ורק זירזה את הזדקנותו.
HE
		),
		array(
			'id'      => 'ea-mem-s8',
			'eyebrow' => 'פרידה',
			'heading' => 'פרידה',
			'body'    => <<<'HE'
בבוקר ה- 11.10.2020 עזב מוקש את גופו. הוא הותיר אחריו אישה – אניטה, ארבעה בנים – גוראפ, דאמרו, טריסול ומונסון, בת נשואה – גיני, ונכדה – פריטי.
טקס שריפתו נערך על גדת הגנגס סמוך לביתו. במקביל נערכו טקסי פוג'ה פרטיים במקומות רבים מסביב לעולם. אנשים שהכירו והוקירו את מפעל חייו הדליקו ביום הזה נר לזכרו, הדליקו קטורת ונשמו בדיג'רידו לעילוי נשמתו.
שנה בדיוק חלפה מאז עזיבתו של מוקש, ולצערי הרב מגפת הקורונה עדיין כאן אתנו בעת כתיבת שורות אלה. השמיים להודו עדיין סגורים והסטודיו בקוטלי עדיין עומד שומם. הלוואי ולסיפור הזה היה סוף אחר, אבל אלה הם החיים. וואט טו דו.
הדבר היחיד שאנחנו יכולים לעשות הוא לזכור את האיש הצנוע והכה מיוחד הזה. לזכור את האיש שמעולם לא חיפש פרסום ומעולם לא דרש הכרה בפועלו. לזכור את האיש שהצליח לגעת בלב של אנשים רבים כל כך - באופן ישיר ובאופן עקיף – ובצורה כל כך פשוטה וכל כך טבעית.
מפעל חייו, הדיג'רידו, ימשיך להדהד, לצמוח ולהתעצם בעולם כולו עד שלא ישאר אדם אחד על הפלנטה שלא יכיר את כלי הנשימה המופלא הזה. תאמינו או לא, אבל כבר עכשיו, באתר הרשמי של קופ"ח מכבי מכירים היום ואף ממליצים באופן חד משמעי על הדיג'רידו ככלי ריפוי למערכת הנשימה. לא רחוק היום שיכירו בכלי הריפוי הזה גם בהקשר של כל יתר מערכות הגוף, ואני חותם לכם על זה!
HE
		),
		array(
			'id'      => 'ea-mem-s9',
			'eyebrow' => '2026',
			'heading' => 'ומה היום',
			'body'    => <<<'HE'
בשנת 2026, שש שנים לאחר פטירתו של מוקש, טסתי להודו לבקר את המשפחה ולסגור מעגל שנשאר אצלי בלב פתוח מאז פטירתו. השנים של הקורונה והמלחמה הבלתי נגמרת עם כל שכנינו במזרח התיכון מנעו ממני לטוס. עם יד על הלב, אני חושב שגם נמנעתי וחששתי מהנסיעה הזו. חששתי מאוד להגיע לרישיקש שאחרי מוקש..
אחרי טבילה במים של מוקש (המקום הספציפי גל גדת הגנגס בה מוקש נהג לטבול), עריכת טקסי פרידה פרטיים וביקור בכל המקדשים, מערות ומקומות הקדושים שמוקש אהב לבקר ולקחת אותי אליהם, המעגל הושלם. נוכחותו הפיזית של מוקש תמיד תחסר לי, אך לפחות ליבי עתה שקט. הפרידה הושלמה. המעגל נסגר.
פטירתו הפתאומית של מוקש גדעה לצערי את פעילותו ופועלו ברישיקש. שנים קשות ומורכבות מאוד עברו על אשתו וארבעת בניו בניסיון לשרוד במציאות קשה ומורכבת. בנוסף לכל הצרות בשנת 2004 נהר הגנגס עלה על גדותיו וליטרלי לקח להם את הבית. במשך שנתיים וחצי הצטופפו כולם בבית המלאכה – המבנה היחיד שנשאר עומד על תילו.
ההחלטה היתה קשה, אך בסופו של דבר הם החליטו למכור את בית המלאכה המיתולוגי ועם הכסף בנו לעצמם בית חדש.
כשהגעתי לביקור עמד שם בית חדש שאינני מכיר. בית ללא חצר, ללא שמיים פתוחים ועם שער ברזל כבד ומנעול. איפה שעמד פעם בית המלאכה הוקם מלון הודי פשוט. מחזה בלתי נתפס שממש שובר את הלב.
בהתאם למסורת ההודית בנו הבכור של מוקש ירש את העסק (Jungle Vibes) ונכון להיום הוא היחיד מבין כל האחים שמנסה עדיין לעסוק במלאכת בניית כלי נגינה בחנות קטנה, שוממת וכושלת.
שברון הלב הגדול ביותר שחוויתי בביקור הזה התרחש בעת הביקור שלי בקוטלי.
לראות את המקום ככה מוזנח.. מטונף.. הבקתה רקובה לגמרי. צואת עכברושים בין השמיכות המעופשות. פינת הבישול במצב קטטוני, סכנה תברואתית של ממש. הסטודיו החדש שבנינו עומד שומם וכולו אכול טרמיטים. זו רק שאלה של זמן עד שהוא ירקב כולו ויתמוטט.
מתוך כבוד והערכה למוקש, כרעתי על בירכיי ובמשך יום שלם מילאתי עם ידיים חשופות 8 שקים ענקיים של זבל מכל המתחם. אספתי בעיקר שברי זכוכיות של בקבוקי וויסקי.
ממקום מטופח ומלבלב של שיחי ורדים, אלוורה, כורכום, ג'ינג'ר ואפילו זן נדיר של במבוק יפני שמוקש שתל במו ידיו, המקום הפך למאורת שיכורים ונרקומנים הודים שמצאו לעצמם זולה נטושה ופשוט השמידו וחירבו את המקום. ממקום של אהבה, הגשמת חלום וקסם - אל אדמת קוצים חרבה ובוכייה.
קרו עוד הרבה דברים בביקור הזה. דברים קשים ומצערים כל כך שכבר הפסקתי לספור את הפעמים שנשבר לי הלב. מתוך כבוד למוקש אני מעדיף שלא להעלותם על הכתב, אבל גם בלעדיהם נראה לי שהתמונה כבר די ברורה..
השורה התחתונה היא שמוקש איננו. תם עידן מוקש ברישיקש. הוא איננו נוכח שם יותר, לא בגופו ולצערי גם לא ברוחו. האנרגיה במקום השתנתה קליל, השפה המדוברת כבר מזמן איננה שפת הלב. הקסם פג לגמרי.
אני מתפלל לאלוהים ומקווה שיעשה חסד עם משפחתו של מוקש ויעזור להם למצוא שוב את הדרך.
חזרתי מהודו שבור לב, אך במקביל גם בתחושת שליחות גדולה יותר מאי פעם. אני מרגיש זכות כל כך גדולה וענקית להמשיך את דרכו ופועלו של מוקש. כאן, בלב שלי, ובמרכז לטיפול בדיג'רידו שהקמתי בחצר ביתנו בפרדס חנה, הרוח של מוקש בהחלט חיה וקיימת. אמנם אין ביננו קשר דם, אך הקשר הנישמתי והרוחני חזק יותר מאי פעם.
בשנת 2018 בעודו בחיים, קיבלתי את ברכתו של מוקש שהכריז על המרכז שהקמתי כסניף הרשמי של Jungle Vibes בישראל.
כמוני בדיוק ישנם עוד מורים, בנאים ומטפלים אחרים בדיג'רידו ברחבי העולם, שיצאו מבית מלאכתו של מוקש. את חלקם אני מכיר באופן אישי, אך לצערי זיקתם למוקש והקשר אליו אבדו מזמן. מורשתו ומשנתו של מוקש כלל איננה באה לידי ביטוי בעשייתם, בהוויתם, או בהוראתם. מוקש נשכח מלבם. ואכן, בודדים ומעטים מאוד האנשים שזכו להכיר את מוקש מקרוב והצליחו לראות ולהכיר באמת גם את האיש שמעבר ל-"בונה הדיג'ים ההודי מרישיקש".
בתחומים אחרים, לא של דיג'רידו, אני מכיר באופן אישי גם לא מעט מטפלים הוליסטיים ובעלי מקצוע אחרים ההולכים בדרכו של מוקש, מדברים את שפת הלב ומיישמים את משנתו ותורתו בעשייתם.
HE
		),
	);
}

/**
 * Render one verbatim prose section: eyebrow + source heading + paragraphs.
 *
 * @param array  $sec  Section (id, eyebrow, heading, body).
 * @param bool   $alt  Alternate (darker) background.
 */
function ea_w2_14e_mem_render_section( $sec, $alt ) {
	$cls = 'ea-14e-section' . ( $alt ? ' ea-14e-section--alt' : '' );
	echo '<section class="' . esc_attr( $cls ) . '" aria-labelledby="' . esc_attr( $sec['id'] ) . '">';
	echo '<div class="ea-14e-inner">';
	if ( '' !== $sec['eyebrow'] ) {
		echo '<p class="ea-14e-label">' . esc_html( $sec['eyebrow'] ) . '</p>';
	}
	echo '<h2 id="' . esc_attr( $sec['id'] ) . '" class="ea-14e-heading">' . esc_html( $sec['heading'] ) . '</h2>';
	echo '<div class="ea-14e-prose">';
	foreach ( preg_split( '/\n+/', trim( $sec['body'] ) ) as $para ) {
		$para = trim( $para );
		if ( '' !== $para ) {
			echo '<p>' . esc_html( $para ) . '</p>';
		}
	}
	echo '</div></div></section>';
}

/**
 * Memorial page composition — full verbatim memorial (team_110, 2026-06-21; D-MOKESH).
 *
 * COPY is Eyal's FULL memorial doc, verbatim (11 sections); supersedes the «ומה היום»
 * fragment the page was first built from. DESIGN keeps the team_35 elevated shell.
 * Composition (D-FILM / media capture 2026-06-16): HERO trailer (muted autoplay + unmute,
 * YouTube IFrame API via assets/js/ea-mokesh.js) → memorial text → 19 photos (media
 * library, seeded once) → full-film placeholder → 4 Facebook post embeds.
 */
function ea_w2_14e_render_memorial() {
	$yt = ea_w2_14e_mokesh_trailer_id();

	// VideoObject schema for the public trailer (full film added when Eyal supplies it).
	$video_ld = array(
		'@context'     => 'https://schema.org',
		'@type'        => 'VideoObject',
		'name'         => 'MUKESH - The Art of Shanti Living | Official Trailer',
		'description'  => 'הטריילר הרשמי לסרט התיעודי על מוקש דהימן, מאסטר הדיג׳רידו מרישיקש, מאת אייל וגיא עמית.',
		'thumbnailUrl' => 'https://i.ytimg.com/vi/' . $yt . '/maxresdefault.jpg',
		'embedUrl'     => 'https://www.youtube-nocookie.com/embed/' . $yt,
		'contentUrl'   => 'https://youtu.be/' . $yt,
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $video_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . "</script>\n";
	?>
		<section class="ea-mem-hero ea-mem-hero--trailer">
			<div class="ea-mem-hero__media" aria-hidden="true">
				<div id="ea-mokesh-trailer" data-ytid="<?php echo esc_attr( $yt ); ?>"></div>
			</div>
			<div class="ea-mem-hero__scrim" aria-hidden="true"></div>
			<div class="ea-mem-hero__inner">
				<div class="ea-mem-hero__disc" aria-hidden="true"><span class="ea-mem-hero__yr">1950 — 2020</span></div>
				<p class="ea-mem-hero__kicker">לזכרו</p>
				<h1 class="ea-mem-hero__title">מוקש דהימן</h1>
				<p class="ea-mem-hero__sub ea-mem-hero__sub--desk-nowrap">מאסטר הדיג׳רידו, מורו של אייל עמית, והמקור שממנו צמחה הדרך התרפויטית.</p>
			</div>
			<button type="button" class="ea-mem-hero__unmute" data-ea-mokesh-unmute aria-pressed="false" hidden>
				<span class="ea-mem-hero__unmute-icon" aria-hidden="true"></span>
				<span class="ea-mem-hero__unmute-label">הפעלת קול</span>
			</button>
		</section>
	<?php
	// ---- Memorial narrative (verbatim, 9 prose sections, alternating bg) ----
	$sections = ea_w2_14e_mokesh_sections();
	foreach ( $sections as $i => $sec ) {
		ea_w2_14e_mem_render_section( $sec, 1 === ( $i % 2 ) );
	}
	?>
		<section class="ea-14e-section ea-14e-section--alt" aria-labelledby="ea-mem-eulogy-h">
			<div class="ea-14e-inner">
				<p class="ea-14e-label">דברי פרידה</p>
				<h2 id="ea-mem-eulogy-h" class="ea-14e-heading">דברי הספד</h2>
				<div class="ea-14e-prose">
					<p>נוח על משכבך בשלום מורי היקר והאהוב, מוקש דהימן. האיש שהפך לאגדה עוד בימי חייו. הנגר, האמן, החכם, השאמן, ההילר, הבאבא ואיש המשפחה, שהקדיש את כל חייו להפצת בשורת הדיג'רידו, ומבלי שתכנן או אפילו ידע הפך לשגריר הדיג'רידו הגדול ביותר בארצות המערב ובעולם כולו. המאסטר שהיה מחובר לליבו והיטיב לחבר גם אחרים לליבם. האדם שידע, שדיבר ושלימד רק שפה אחת - שפת הלב. תודה לך על כל שיעורי החיים. תודה על כל מתנות האור ותודה על כל רגעי הקסם משנת 2000 ועד עצם היום הזה. היית לי כחבר, היית לי כאח, היית לי כאב רוחני, כמקור להשראה אינסופית וכמורה אמת בנפתולי החיים. זכות ענקית נפלה בחלקי להכירך בחיים האלה, להיות לך לתלמיד, להנציח אותך בספריי, בסרט תיעודי מרגש ועכשיו גם כאן באתר שלי. רוחך המוארת, הווייתך הצנועה ומורשתך המופלאה תמשיך להדהד ולחיות בלבי ודרך עשייתי לנצח.</p>
				</div>
				<div class="ea-mem-sign">
					<p>יהי זכרך ברוך ומבורך</p>
					<p>אוהב אותך עד נשימתי האחרונה</p>
					<p class="ea-mem-sign__name">אייל עמית</p>
				</div>
			</div>
		</section>

		<section class="ea-mem-mantra" aria-label="Om Mukesh Ji">
			<p class="ea-mem-mantra__line">"Shanti Play Mantra Inside, Shanti Coming Home"</p>
			<p class="ea-mem-mantra__om">Om Mukesh Ji</p>
		</section>
	<?php
	// ---- 19 photos (media library, seeded once; original order) ----
	$photo_ids = ea_w2_14e_mokesh_photo_ids();
	if ( ! empty( $photo_ids ) ) {
		?>
		<section class="ea-14e-section" aria-labelledby="ea-mem-photos-h">
			<div class="ea-14e-inner">
				<p class="ea-14e-label">תיעוד</p>
				<h2 id="ea-mem-photos-h" class="ea-14e-heading ea-14e-heading--sm">מוקש, רישיקש והדרך</h2>
				<div class="ea-mem-photos">
					<?php
					foreach ( $photo_ids as $pid ) {
						echo '<figure class="ea-mem-photo">';
						echo wp_get_attachment_image(
							$pid,
							'large',
							false,
							array(
								'class'    => 'ea-mem-photo__img',
								'loading'  => 'lazy',
								'decoding' => 'async',
							)
						);
						echo '</figure>';
					}
					?>
				</div>
			</div>
		</section>
		<?php
	}
	?>
		<section class="ea-14e-section ea-14e-section--alt" aria-labelledby="ea-mem-film-h">
			<div class="ea-14e-inner">
				<p class="ea-14e-label">הסרט התיעודי</p>
				<h2 id="ea-mem-film-h" class="ea-14e-heading ea-14e-heading--sm">MUKESH — The Art of Shanti Living</h2>
				<div class="ea-mem-film" role="group" aria-label="הסרט המלא">
					<p class="ea-mem-film__ph">הסרט המלא (כ-60 דקות, מאת אייל וגיא עמית) יוטמע כאן בקרוב. בינתיים ניתן לצפות בטריילר בראש העמוד, ובדף הסרט בפייסבוק.</p>
					<a class="ea-mem-film__link" href="https://www.facebook.com/mukesh.the.art.of.shanti.living.the.movie/" target="_blank" rel="noopener noreferrer">דף הסרט בפייסבוק</a>
				</div>
			</div>
		</section>

		<section class="ea-14e-section" aria-labelledby="ea-mem-fb-h">
			<div class="ea-14e-inner">
				<p class="ea-14e-label">מהקהילה</p>
				<h2 id="ea-mem-fb-h" class="ea-14e-heading ea-14e-heading--sm">מתוך הפייסבוק</h2>
				<div class="ea-mem-fb">
					<?php foreach ( ea_w2_14e_mokesh_fb_posts() as $href ) : ?>
						<div class="ea-mem-fb__item">
							<iframe class="ea-mem-fb__frame" src="https://www.facebook.com/plugins/post.php?href=<?php echo rawurlencode( $href ); ?>&amp;show_text=true&amp;width=500&amp;locale=he_IL" width="500" height="640" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" loading="lazy" title="פוסט פייסבוק לזכר מוקש דהימן"></iframe>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
}

/* ═══════════════════════════════════════════════════════════════════════════
 * GALLERIES — /galleries (catalog grid 3→2→1)
 * ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Galleries catalog data. Real images degrade to a labelled placeholder when
 * the asset is missing (graceful). Copy verbatim from the mockup.
 *
 * @return array<int,array<string,string>>
 */
function ea_w2_14e_galleries_items() {
	return array(
		array(
			'img'   => 'hero-wide-studio.jpg',
			'alt'   => 'הסטודיו בפרדס חנה',
			'count' => '12 תמונות',
			'title' => 'הסטודיו בפרדס חנה',
			'desc'  => 'המרחב, החצר הירוקה ושבילי העץ.',
		),
		array(
			'img'   => 'kushi-04-sinai.jpg',
			'alt'   => 'מסעות',
			'count' => '18 תמונות',
			'title' => 'מסעות ודרכים',
			'desc'  => 'סיני, דרום אמריקה והמקומות שהיוו השראה.',
		),
		array(
			'img'         => '',
			'placeholder' => '[גלריית סדנאות — נדרש מאייל]',
			'count'       => '— תמונות',
			'title'       => 'סדנאות ומפגשים',
			'desc'        => 'קבוצות, סאונד הילינג ואירועים.',
		),
		array(
			'img'         => '',
			'placeholder' => '[גלריית כלים — נדרש מאייל]',
			'count'       => '— תמונות',
			'title'       => 'כלים בעבודת יד',
			'desc'        => 'דיג׳רידו, תיקים וסטנדים שנבנו ביד.',
		),
		array(
			'img'   => 'kushi-02-eyal-italy.jpg',
			'alt'   => 'הופעות',
			'count' => '9 תמונות',
			'title' => 'הופעות ומופעים',
			'desc'  => '״עכשיו!!!״ ומופעי סיפורים על במות.',
		),
		array(
			'img'         => '',
			'placeholder' => '[גלריית מוקש — נדרש מאישור]',
			'count'       => '— תמונות',
			'title'       => 'מוקש דהימן',
			'desc'        => 'מהלימוד והחניכה בהודו.',
		),
	);
}

/**
 * Galleries catalog composition.
 */
function ea_w2_14e_render_galleries() {
	?>
	<header class="ea-14e-pagehead">
		<div class="ea-14e-pagehead__inner">
			<p class="ea-14e-pagehead__label">גלריות</p>
			<h1 class="ea-14e-pagehead__title">רגעים מהמרחב ומהדרך</h1>
			<p class="ea-14e-pagehead__lead">צילומים מהסטודיו, ממפגשים, מסדנאות וממסעות — קטלוג גלריות שמתעדכן עם הזמן. לחיצה על גלריה פותחת את כל התמונות שבה.</p>
		</div>
	</header>
	<section class="ea-14e-section" aria-label="קטלוג גלריות">
		<div class="ea-14e-inner">
			<div class="ea-gal-grid">
				<?php foreach ( ea_w2_14e_galleries_items() as $g ) : ?>
					<?php
					$src = isset( $g['img'] ) && '' !== $g['img'] ? ea_w2_14e_img( $g['img'] ) : '';
					?>
					<a class="ea-gal" href="#">
						<div class="ea-gal__cover">
							<?php if ( '' !== $src ) : ?>
								<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( isset( $g['alt'] ) ? $g['alt'] : '' ); ?>" loading="lazy">
							<?php else : ?>
								<div class="ea-gal__ph"><?php echo esc_html( isset( $g['placeholder'] ) ? $g['placeholder'] : '' ); ?></div>
							<?php endif; ?>
							<span class="ea-gal__count"><?php echo esc_html( $g['count'] ); ?></span>
						</div>
						<p class="ea-gal__t"><?php echo esc_html( $g['title'] ); ?></p>
						<p class="ea-gal__d"><?php echo esc_html( $g['desc'] ); ?></p>
					</a>
				<?php endforeach; ?>
			</div>
			<p class="ea-14e-note">כל תוכן הגלריות מהאתר הקודם עובר לאתר החדש (תקרה ~150 תמונות למחיצה). הגלריות מתמלאות מתוך קטלוג המדיה ב-Hub עם מסירת הנכסים הסופית.</p>
		</div>
	</section>
	<?php
}

/* ═══════════════════════════════════════════════════════════════════════════
 * MEDIA / TESTIMONIALS — /media (.ea-tgrid → 1-col on mobile)
 * ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Testimonial cards (verbatim from the mockup).
 *
 * @return array<int,array<string,string>>
 */
function ea_w2_14e_media_testimonials() {
	return array(
		array( 'q' => 'כמו רבים אחרים גם אני חשבתי שאני באה ללמוד דיג׳רידו, ולא היה לי מושג איזה מסע עוצמתי מחכה לי.', 'n' => 'שירי אלקבץ' ),
		array( 'q' => 'מה שאני לומדת מאייל זה לנשום מחדש — להיות בנוכחות בנשימה, זה להיות בנוכחות בחיים.', 'n' => 'נוית צוף שטראוס' ),
		array( 'q' => 'פעם ראשונה בחיים שלמדתי לנשום נכון — תרגול הנשימה בדידג׳ פשוט מרגיע אותי.', 'n' => 'אלון גרזון רז' ),
		array( 'q' => 'אייל עמית הציל אותנו, ובזכותו כולנו חזרנו לנשום. הקשר המיוחד שנוצר עם הילד שלי קרה מהר והעמיק.', 'n' => 'חיה עזריה' ),
		array( 'q' => 'הלימוד אצלך, אייל, פתח עוד שכבה פנימית של נשימה וחיבר אותי עוד יותר לרפואה הפנימית שכולנו נושאים.', 'n' => 'קארין טננצפף' ),
		array( 'q' => 'אייל לא רק מלמד — הוא מלווה אותי במסע פנימי, ללמוד לנשום דרך הגוף, אל תוך הצליל ואל הנוכחות המלאה.', 'n' => 'אלכס פלופ' ),
	);
}

/**
 * Press / media items (verbatim from the mockup).
 *
 * @return array<int,array<string,string>>
 */
function ea_w2_14e_media_press() {
	return array(
		array( 'src' => 'כתבה', 'h' => 'שליחות חיי — כתבה אודות המרכז לטיפול בדיג׳רידו, סטודיו נשימה מעגלית פרדס חנה' ),
		array( 'src' => 'מאמר', 'h' => 'הכל על ריברסינג, נשימה מעגלית ודיג׳רידו — ההסבר המלא' ),
		array( 'src' => 'פודקאסט', 'h' => 'שיחה על נשימה, צליל וריפוי דרך הדיג׳רידו' ),
		array( 'src' => 'מופע', 'h' => '״עכשיו!!! — תופעת יחיד״: מופע הסיפורים של אייל עמית' ),
	);
}

/**
 * Media / testimonials catalog composition.
 */
function ea_w2_14e_render_media() {
	$contact = home_url( '/contact/' );
	?>
	<header class="ea-14e-pagehead">
		<div class="ea-14e-pagehead__inner">
			<p class="ea-14e-pagehead__label">המלצות ומדיה</p>
			<h1 class="ea-14e-pagehead__title">מילים שנשארו אחרי המפגש</h1>
			<p class="ea-14e-pagehead__lead">עדויות של משתתפים, אזכורים בעיתונות וכתבות נבחרות — קטלוג מרכזי שמתעדכן עם הזמן.</p>
		</div>
	</header>

	<section class="ea-14e-section" aria-labelledby="ea-media-t">
		<div class="ea-14e-inner">
			<h2 id="ea-media-t" class="ea-14e-heading ea-14e-heading--sm">עדויות משתתפים</h2>
			<div class="ea-filter" role="group" aria-label="סינון">
				<button type="button" aria-pressed="true">הכל</button>
				<button type="button" aria-pressed="false">טיפול</button>
				<button type="button" aria-pressed="false">שיעורים</button>
				<button type="button" aria-pressed="false">סאונד הילינג</button>
			</div>
			<div class="ea-tgrid">
				<?php foreach ( ea_w2_14e_media_testimonials() as $t ) : ?>
					<figure class="ea-tcard">
						<p class="ea-tcard__q"><?php echo esc_html( $t['q'] ); ?></p>
						<figcaption class="ea-tcard__n"><?php echo esc_html( $t['n'] ); ?></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="ea-14e-section ea-14e-section--alt" aria-labelledby="ea-media-p">
		<div class="ea-14e-inner">
			<h2 id="ea-media-p" class="ea-14e-heading ea-14e-heading--sm">מן התקשורת</h2>
			<div class="ea-press">
				<?php foreach ( ea_w2_14e_media_press() as $p ) : ?>
					<a href="#">
						<p class="ea-press__src"><?php echo esc_html( $p['src'] ); ?></p>
						<p class="ea-press__h"><?php echo esc_html( $p['h'] ); ?></p>
					</a>
				<?php endforeach; ?>
			</div>
			<p class="ea-14e-note">פריטי המדיה ייובאו מהקטלוג המרכזי (CMS) עם מסירת הנכסים והקישורים הסופיים.</p>
		</div>
	</section>

	<section class="ea-cta-band" aria-labelledby="ea-media-c">
		<div class="ea-14e-inner">
			<h2 id="ea-media-c" class="ea-cta-band__heading">רוצים לחוות בעצמכם?</h2>
			<a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( $contact ); ?>">לתיאום שיחת היכרות</a>
		</div>
	</section>
	<?php
}
