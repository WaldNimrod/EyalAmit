<?php
/**
 * Chapters home — seeded content defaults (single source of truth).
 *
 * Every value here renders when ACF is inactive or a field is left empty, so a
 * fresh/duplicated page is never blank. Image values are theme-relative paths
 * (resolved by ea_chapters_asset_url) or absolute URLs.
 *
 * BRAND NOTE: the original mockup used the retired brand «סטודיו נשימה מעגלית».
 * Per WP-06 (brand migration) that string is removed sitewide — the canonical
 * brand «המרכז לטיפול בדיג׳רידו» / NAP is used instead. Do not reintroduce it.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	/* ── HERO ── */
	'hero_title'    => 'טיפול בדיג׳רידו אינו מבוסס רק על האזנה.<br>הוא למידה, נשימה ו<em>נוכחות</em>.',
	'hero_subtitle' => 'שיטת cbDIDG היא גישת טיפול ייחודית המבוססת על נשימה, צליל ונוכחות, שפותחה ומיושמת על ידי אייל עמית — מהוותיקים בארץ בתחום, הפועל מאז 1999.',
	'hero_cta_label'=> 'לתיאום שיחת היכרות',
	'hero_cta_url'  => '#start',
	'hero_video'    => 'assets/video/ea-home-hero-720-muted.mp4',
	'hero_poster'   => 'assets/video/ea-home-hero-poster.jpg',

	/* ── 01 ABOUT ── */
	'about_chap'    => 'פרק 01',
	'about_title'   => 'אייל עמית',
	'about_body'    => "<p>מורה לדיג׳רידו, מטפל בנשימה וסופר, הפועל מאז 1999 ומייסד המרכז לטיפול בדיג׳רידו בפרדס חנה. דרכו צמחה משילוב של חקירה אישית, ניסיון מעשי וחניכה אצל המאסטר מוקש דהימן.</p>\n<p>לצד עבודתו בעולם הדיג׳רידו והנשימה, אייל ממשיך ללמד וללוות אנשים בתהליכים אישיים דרך עבודה עם הנשימה — בגישה ישירה, לא מתייפייפת, שמחברת בין גוף, צליל וחיים.</p>\n<p>הוא גם כתב שלושה ספרים, הקים את הוצאת הספרים ״מוזה״, ויצר מופע סיפורים שרץ במשך שנים על במות מרכזיות בארץ — ביניהן צוותא, הקאמרי ובית ציוני אמריקה.</p>",
	'about_img1'    => 'assets/images/chapters/eyal-portrait-garden.jpg',
	'about_img1_alt'=> 'אייל עמית בגינת הסטודיו עם הדיג׳רידו',
	'about_img2'    => 'assets/images/chapters/didg-spiral-detail.jpg',
	'about_img2_alt'=> 'ספירלת cbDIDG חרוטה בקצה הדיג׳רידו',
	'about_img3'    => 'assets/images/chapters/logo-didgs-door.jpg',
	'about_img3_alt'=> 'שלושה דיג׳רידו בצורת ספירלת הלוגו',
	'about_timeline'=> array(
		array( 'year' => '1999', 'text' => 'תחילת הדרך והעבודה עם הדיג׳רידו' ),
		array( 'year' => '2004', 'text' => 'הקמת הוצאת הספרים ״מוזה״' ),
		array( 'year' => '2017', 'text' => '״וכתבת״ — 46 סיפורים מהחיים' ),
		array( 'year' => 'היום', 'text' => 'המרכז לטיפול בדיג׳רידו, פרדס חנה' ),
	),

	/* ── 02 FOR WHOM ── */
	'whom_chap'  => 'פרק 02',
	'whom_title' => 'למי מתאים התהליך',
	'whom_lead'  => 'ההתאמה תמיד נבחנת דרך שיחה ומפגש, ולא לפי כותרת בלבד.',
	'whom_items' => array(
		array( 'image' => 'assets/images/chapters/eyal-bright.jpg',     'text' => 'למי שהנשימה שלו הפכה שטחית או לא יציבה תחת עומס יומיומי.' ),
		array( 'image' => 'assets/images/chapters/breath-practice.jpg', 'text' => 'למי שמבקש שקט, מיקוד או תהליך אישי שמחזיר אותו אל עצמו.' ),
		array( 'image' => 'assets/images/chapters/eyal-window.jpg',     'text' => 'למי שמתמודד עם מתח, חרדה וקושי בוויסות רגשי.' ),
		array( 'image' => 'assets/images/chapters/eyal-close.jpg',      'text' => 'למי שמתקשה בתרגול שקט ומחפש דרך אחרת להגיע אליו.' ),
	),

	/* ── 03 SESSION (dark hover-reveal cards) ── */
	'session_chap'  => 'פרק 03',
	'session_title' => 'מה קורה במפגש',
	'session_lead'  => 'מפגש אינו רק האזנה — אלא למידה והתנסות, צעד אחר צעד.',
	'session_cards' => array(
		array(
			'image'  => 'assets/images/chapters/eyal-studio-play.jpg',
			'title'  => 'עבודה עם הנשימה',
			'text'   => 'הקשבה לגוף ועבודה ישירה עם הנשימה והצליל.',
			'reveal' => 'מזהים יחד את דפוסי הנשימה הקיימים, ומתחילים לעבוד איתם במודעות.',
		),
		array(
			'image'  => 'assets/images/chapters/eyal-teaching.jpg',
			'title'  => 'תרגול מעשי',
			'text'   => 'הפקת צליל ונשימה מעגלית, בהדרגה וללא רקע קודם.',
			'reveal' => 'הגוף לומד דרך תרגול חי ומעשי — לא תיאוריה, אלא חוויה.',
		),
		array(
			'image'  => 'assets/images/chapters/eyal-receiving.jpg',
			'title'  => 'הקשבה והדרכה',
			'text'   => 'ליווי אישי ומדויק, מותאם לנקודת המוצא של כל אחד.',
			'reveal' => 'הקצב נקבע לפי האדם שמגיע — בהקשבה למה שנכון עבורו.',
		),
		array(
			'image'  => 'assets/images/chapters/stone-mandala.jpg',
			'title'  => 'עומק ויציבות',
			'text'   => 'רצף נשימתי יציב — ריכוז, שקט וזרימה דרך הנגינה.',
			'reveal' => 'עם הזמן העקרונות מלווים גם את החיים מחוץ לסטודיו.',
		),
	),

	/* ── PHOTO BAND (bleed) ── */
	'band_image'  => 'assets/images/chapters/group-session-garden.jpg',
	'band_alt'    => 'מפגש נשימה קבוצתי בגינת הסטודיו',
	'band_quote'  => 'הנשימה היא המקום שבו הגוף, הצליל והנוכחות נפגשים.',
	'band_attrib' => 'המרכז לטיפול בדיג׳רידו · פרדס חנה',

	/* ── 04 STUDIO (dark split) ── */
	'studio_chap'      => 'פרק 04',
	'studio_title'     => 'הסטודיו והמרחב',
	'studio_body'      => 'המפגשים מתקיימים בסטודיו שקט שמוקף ירוק, בפרדס חנה — מרחב שמזמין להאט, לנשום ולהקשיב. עוד לפני שמתחילים, הדרך פנימה היא חלק מהתהליך.',
	'studio_cta_label' => 'למרחבים נוספים על הסטודיו',
	'studio_cta_url'   => '#',
	'studio_image'     => 'assets/images/chapters/studio-interior.jpg',
	'studio_alt'       => 'פנים הסטודיו — קיר הפסיפס והדיג׳רידו, פרדס חנה',

	/* ── 05 TESTIMONIALS ── */
	'testi_chap'  => 'פרק 05',
	'testi_title' => 'עדויות והמלצות',
	'testi_items' => array(
		array( 'initial' => 'ש', 'text' => '״כמו רבים אחרים גם אני חשבתי שאני באה ללמוד דיג׳רידו, ולא היה לי מושג איזה מסע עוצמתי מחכה לי.״', 'name' => 'שירי אלקבץ' ),
		array( 'initial' => 'נ', 'text' => '״מה שאני לומדת מאייל זה לנשום מחדש — להיות בנוכחות בנשימה, זה להיות בנוכחות בחיים.״', 'name' => 'נוית צוף שטראוס' ),
		array( 'initial' => 'ע', 'text' => '״אייל פירק את אומנות הנשימה עם הדיג׳רידו למרכיבים הקטנים והברורים ביותר.״', 'name' => 'ענת קרמנר וינשטיין' ),
	),

	/* ── 06 COMPARE ── */
	'cmp_chap'    => 'פרק 06',
	'cmp_title'   => 'השוואה בין טיפול בדיג׳רידו לסאונד הילינג',
	'cmp_lead'    => 'שתי דרכים לעבוד עם צליל — ההבדל הוא במידת ההשתתפות.',
	'cmp_a_image' => 'assets/images/chapters/breath-practice.jpg',
	'cmp_a_title' => 'טיפול בדיג׳רידו',
	'cmp_a_text'  => 'השתתפות פעילה ועבודה אישית עם נשימה וכלי — תהליך מתמשך שבו לומדים לווסת ולחזק את הנשימה.',
	'cmp_a_cta'   => 'לפרטים על טיפול בדיג׳רידו',
	'cmp_a_url'   => '/treatment/',
	'cmp_b_image' => 'assets/images/chapters/didgs-window.jpg',
	'cmp_b_title' => 'סאונד הילינג',
	'cmp_b_text'  => 'הדגש על הקשבה, חוויה וקבלה של הצליל כפי שהוא פוגש את הגוף והמרחב — לרוב מפגש נקודתי.',
	'cmp_b_cta'   => 'לפרטים על סאונד הילינג',
	'cmp_b_url'   => '/sound-healing/',

	/* ── 07 HOW TO START (dark band) ── */
	'start_chap'      => 'פרק 07',
	'start_title'     => 'איך מתחילים',
	'start_bg'        => 'assets/images/chapters/studio-interior.jpg',
	'start_cta_label' => 'לתיאום שיחת היכרות',
	'start_cta_url'   => '/contact/',
	'start_steps'     => array(
		array( 'title' => 'שיחת היכרות ראשונית', 'text' => 'נבין יחד את הצורך והכוונה שלך.' ),
		array( 'title' => 'התאמת המסלול',        'text' => 'נבחר את הדרך המתאימה — טיפול, שיעור או מסגרת אחרת.' ),
		array( 'title' => 'מפגש ראשון',          'text' => 'עוצרים לרגע, נושמים ומתחילים.' ),
	),

	/* ── FOOTER ── */
	'foot_tagline'   => 'המרכז לטיפול בנשימה באמצעות דיג׳רידו · פרדס חנה, ישראל. שיטת cbDIDG, מאז 1999.',
	'foot_copyright' => '© 2026 אייל עמית · כל הזכויות שמורות',
);
