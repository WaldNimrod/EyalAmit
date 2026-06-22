<?php
/**
 * Chapters home — seeded content defaults (single source of truth).
 *
 * Every value here renders when ACF is inactive or a field is left empty, so a
 * fresh/duplicated page is never blank. Image values are theme-relative paths
 * (resolved by ea_chapters_asset_url) or absolute URLs.
 *
 * BRAND NOTE: the original mockup used the retired brand (retired studio brand).
 * Per WP-06 (brand migration) that string is removed sitewide — the canonical
 * brand «המרכז לטיפול בדיג׳רידו» / NAP is used instead. Do not reintroduce it.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	/* ── HERO ── */
	'hero_title'    => "המרכז לטיפול בנשימה באמצעות דיג'רידו - שיטת cbDIDG של אייל עמית",
	'hero_subtitle' => "להחזיר שליטה על הנשימה דרך עבודה עם דיג'רידו, תרגול נשימה וליווי אישי<br>בגישה טיפולית מבוססת דיג'רידו ובהשראת חניכה אישית אצל מוקש דהימן",
	'hero_cta_label'=> 'לתיאום שיחת היכרות',
	'hero_cta_url'  => '/contact/',
	'hero_video'    => 'assets/video/ea-home-hero-720-muted.mp4',
	'hero_poster'   => 'assets/video/ea-home-hero-poster.jpg',

	/* ── 01 ABOUT ── */
	'about_chap'    => 'פרק 01',
	'about_title'   => 'אייל עמית',
	'about_body'    => "<p>העבודה של אייל עמית עם נשימה ודיג'רידו התחילה מתוך משיכה לצליל המיוחד של הכלי.</p>\n<p>רק בהמשך הדרך, לאחר שנים של למידה אצל המאסטר ההודי מוקש דהימן, התבהר הקשר בין הנשימה למערכות הגוף.</p>\n<p>הרקע ההנדסי של אייל איפשר לו לפרק תהליכים מורכבים לשיטה ברורה וישימה.</p>\n<p>את המרכז לטיפול בדיג'רידו הקים מתוך רצון לקדם, להנגיש וללמד את העבודה עם הדיג'רידו ככלי להשפעה על הגוף, הנשימה והתודעה. <a class=\"tlink\" href=\"/eyal-amit/\">לעמוד אייל עמית</a></p>",
	'about_img1'    => 'assets/images/chapters/eyal-portrait-garden.jpg',
	'about_img1_alt'=> 'אייל עמית בגינת הסטודיו עם הדיג׳רידו',
	'about_img2'    => 'assets/images/chapters/didg-spiral-detail.jpg',
	'about_img2_alt'=> 'ספירלת cbDIDG חרוטה בקצה הדיג׳רידו',
	'about_img3'    => 'assets/images/chapters/logo-didgs-door.jpg',
	'about_img3_alt'=> 'שלושה דיג׳רידו בצורת ספירלת הלוגו',
	'about_timeline'=> array(
		array( 'year' => '1999', 'text' => '⟨טקסט להשלמה ע״י אייל⟩' ),
		array( 'year' => '2004', 'text' => '⟨טקסט להשלמה ע״י אייל⟩' ),
		array( 'year' => '2017', 'text' => '⟨טקסט להשלמה ע״י אייל⟩' ),
		array( 'year' => 'היום', 'text' => '⟨טקסט להשלמה ע״י אייל⟩' ),
	),

	/* ── 02 FOR WHOM ── */
	'whom_chap'  => 'פרק 02',
	'whom_title' => 'למי מתאים התהליך',
	'whom_lead'  => '⟨טקסט להשלמה ע״י אייל⟩',
	'whom_items' => array(
		array( 'image' => 'assets/images/chapters/eyal-bright.jpg',     'text' => 'מתאים למי שסובל מסימפטומים בריאותיים, גם אם לא תמיד ברור מה המקור.' ),
		array( 'image' => 'assets/images/chapters/breath-practice.jpg', 'text' => 'למי שמבין שמדובר בתהליך אישי עמוק, ולא מחפש פתרון קסם מהיר.' ),
		array( 'image' => 'assets/images/chapters/eyal-window.jpg',     'text' => 'למי שרוצה לעבוד עם הנשימה בצורה מעשית ומוכן להקדיש זמן לתרגול.' ),
		array( 'image' => 'assets/images/chapters/eyal-close.jpg',      'text' => 'למי שמעוניין לבדוק כיוון אחר, לא שגרתי, חווייתי ומהנה.' ),
	),

	/* ── 03 SESSION (dark hover-reveal cards) ── */
	'session_chap'  => 'פרק 03',
	'session_title' => "מה קורה במפגש טיפול בדיג'רידו",
	'session_lead'  => 'המפגש מתקיים בסביבה שקטה ונעימה, שמאפשרת לעצור ולהתמקד בנשימה.',
	'session_cards' => array(
		array(
			'image'  => 'assets/images/chapters/eyal-studio-play.jpg',
			'title'  => '⟨טקסט להשלמה ע״י אייל⟩',
			'text'   => 'העבודה משלבת תרגול, הקשבה והדרכה אישית, בקצב שמתאים לכל אחד.',
			'reveal' => '⟨טקסט להשלמה ע״י אייל⟩',
		),
		array(
			'image'  => 'assets/images/chapters/eyal-teaching.jpg',
			'title'  => '⟨טקסט להשלמה ע״י אייל⟩',
			'text'   => "הדגש הוא על תרגול מעשי, חיבור לגוף ולנשימה ופיתוח יכולת עבודה עצמאית עם הדיג'רידו.",
			'reveal' => '⟨טקסט להשלמה ע״י אייל⟩',
		),
		array(
			'image'  => 'assets/images/chapters/eyal-receiving.jpg',
			'title'  => '⟨טקסט להשלמה ע״י אייל⟩',
			'text'   => '⟨טקסט להשלמה ע״י אייל⟩',
			'reveal' => '⟨טקסט להשלמה ע״י אייל⟩',
		),
		array(
			'image'  => 'assets/images/chapters/stone-mandala.jpg',
			'title'  => '⟨טקסט להשלמה ע״י אייל⟩',
			'text'   => '⟨טקסט להשלמה ע״י אייל⟩',
			'reveal' => '⟨טקסט להשלמה ע״י אייל⟩',
		),
	),

	/* ── PHOTO BAND (bleed) ── */
	'band_image'  => 'assets/images/chapters/group-session-garden.jpg',
	'band_alt'    => 'מפגש נשימה קבוצתי בגינת הסטודיו',
	'band_quote'  => '⟨טקסט להשלמה ע״י אייל⟩',
	'band_attrib' => '⟨טקסט להשלמה ע״י אייל⟩',

	/* ── 04 STUDIO (dark split) ── */
	'studio_chap'      => 'פרק 04',
	'studio_title'     => 'הסטודיו והמרחב',
	'studio_body'      => 'הסטודיו שבו מתקיימת העבודה תוכנן מתוך הבנה עמוקה של סאונד ואקוסטיקה. החלל מאפשר עבודה מדויקת עם צליל ותדר, ותומך בתהליך גם בטיפול וגם בסאונד הילינג. הסטודיו ממוקם בלב חצר מטופחת, מוקפת ירוק, עצי פרי בוגרים, שבילי עץ, שדרת במבוקים וגינת ירק מלבלבת. תחושה של מרחב חי ונושם. רבים מדווחים כי כבר בכניסה למקום, משהו בקצב משתנה והלב נפתח, עוד לפני שהמפגש מתחיל.',
	'studio_cta_label' => 'למידע נוסף על סאונד הילינג',
	'studio_cta_url'   => '/sound-healing/',
	'studio_image'     => 'assets/images/chapters/studio-interior.jpg',
	'studio_alt'       => 'פנים הסטודיו — קיר הפסיפס והדיג׳רידו, פרדס חנה',

	/* ── 05 TESTIMONIALS ── */
	'testi_chap'  => 'פרק 05',
	'testi_title' => 'עדויות והמלצות',
	'testi_items' => array(
		array( 'initial' => 'ש', 'text' => 'גיליתי מסע עוצמתי של נשימה, שקט וחיבור לעצמי', 'name' => 'שירי אלקבץ' ),
		array( 'initial' => 'נ', 'text' => 'להיות בנוכחות בנשימה זה להיות בנוכחות בחיים', 'name' => 'נוית צוף שטראוס' ),
		array( 'initial' => 'ע', 'text' => 'זו כנראה המתנה הכי טובה שנתתי לעצמי', 'name' => 'ענת קרמנר ויינשטיין' ),
	),

	/* ── 06 COMPARE ── */
	'cmp_chap'    => 'פרק 06',
	'cmp_title'   => "טיפול בדיג'רידו או סאונד הילינג - מה ההבדל?",
	'cmp_lead'    => '⟨טקסט להשלמה ע״י אייל⟩',
	'cmp_a_image' => 'assets/images/chapters/breath-practice.jpg',
	'cmp_a_title' => "טיפול בדיג'רידו",
	'cmp_a_text'  => 'עבודה אקטיבית ותהליכית עם הנשימה, שבה המטופל לומד לחזק ולווסת את מערכת הנשימה שלו. האפקט הוא לאורך זמן ולטווח הארוך.',
	'cmp_a_cta'   => "למידע נוסף על טיפול בדיג'רידו",
	'cmp_a_url'   => '/treatment/',
	'cmp_b_image' => 'assets/images/chapters/didgs-window.jpg',
	'cmp_b_title' => 'סאונד הילינג',
	'cmp_b_text'  => 'חוויה פאסיבית, בדרך כלל חד פעמית, של הקשבה לצליל. המטרה היא הרפיה ואיזון באמצעות תדרים וכלי נגינה שונים. האפקט הוא מיידי וקצר מועד.',
	'cmp_b_cta'   => 'למידע נוסף על סאונד הילינג',
	'cmp_b_url'   => '/sound-healing/',

	/* ── 07 HOW TO START (dark band) ── */
	'start_chap'      => 'פרק 07',
	'start_title'     => 'איך מתחילים',
	'start_bg'        => 'assets/images/chapters/studio-interior.jpg',
	'start_cta_label' => 'לתיאום שיחת היכרות',
	'start_cta_url'   => '/contact/',
	'start_steps'     => array(
		array( 'title' => '⟨טקסט להשלמה ע״י אייל⟩', 'text' => 'אפשר להתחיל בשיחת היכרות קצרה, להבין את הצורך ולבדוק התאמה.' ),
		array( 'title' => '⟨טקסט להשלמה ע״י אייל⟩', 'text' => 'השיחה מאפשרת לשאול שאלות ולקבל כיוון ראשוני.' ),
		array( 'title' => '⟨טקסט להשלמה ע״י אייל⟩', 'text' => 'אין צורך להתחייב מראש לתהליך.' ),
	),

	/* ── FOOTER ── */
	'foot_tagline'   => '⟨טקסט להשלמה ע״י אייל⟩',
	'foot_copyright' => '⟨טקסט להשלמה ע״י אייל⟩',
);
