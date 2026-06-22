<?php
/**
 * Chapters /eyal-amit/ (אודות) — seeded content defaults. Narrative page.
 * Sourced from the אודות-פרקים mockup; .html links rewritten to real routes;
 * retired brand (retired studio brand) dropped (footer carries the canonical NAP brand).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	'phero' => array(
		'chap'      => 'אודות · המרכז לטיפול בדיג׳רידו',
		'title'     => 'אייל <em>עמית</em>',
		'sub'       => 'עוסק בעבודה עם דיג׳רידו מאז 1999, ומהוותיקים בארץ בתחום. מורה, מטפל בנשימה, סופר — ומייסד המרכז לטיפול בדיג׳רידו בפרדס חנה.',
		'media'     => 'assets/images/chapters/eyal-portrait-garden.jpg',
		'media_alt' => 'אייל עמית בגינת הסטודיו בפרדס חנה',
		'cta_label' => '',
		'cta_url'   => '',
	),

	'sections' => array(

		/* INTRO — פתיח */
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'פתיח',
				'title' => 'משהו בנשימה התחיל את הכל',
				'body'  => '<p style="font-size:1.2rem;line-height:1.8;color:var(--ink)">הדרך של אייל עם הדיג׳רידו לא התחילה מתוך מוזיקה, אלא מתוך מסע אישי של חקירה ורצון להתמודד עם קשיים בריאותיים — אסטמה ואלרגיות קשות שליוו אותו שנים.</p><p>מה שהתחיל כסקרנות הפך לתהליך ריפוי עמוק, ובהמשך לשיטה שלמה שמלווה היום מאות אנשים.</p>',
			),
		),

		/* THE CENTER — המרכז (split reversed, figr l) */
		array(
			'part' => 'split',
			'args' => array(
				'chap'     => 'המרכז',
				'title'    => 'המרכז לטיפול בדיג׳רידו',
				'body'     => '<p style="font-size:1.15rem;color:var(--ink)">מקום שהוקם בפרדס חנה מתוך רצון להנגיש וללמד את העבודה עם הדיג׳רידו ככלי להשפעה תרפויטית על הגוף, הנשימה והתודעה.</p><p>לאורך השנים ליווה אייל מאות אנשים בתהליכים אישיים, ופיתח את שיטת cbDIDG לטיפול באמצעות דיג׳רידו — מתוך שילוב של ניסיון מעשי, חקירה מתמשכת, וחשיבה שיטתית שהביא איתו מהרקע שלו כמהנדס אלקטרוניקה.</p>',
				'image'    => 'assets/images/chapters/studio-interior.jpg',
				'alt'      => 'פנים הסטודיו בפרדס חנה',
				'figr'     => 'l',
				'reversed' => true,
			),
		),

		/* JOURNEY — ציר זמן (timeline, dark) */
		array(
			'part' => 'timeline',
			'args' => array(
				'chap'  => 'ציר זמן',
				'title' => 'כמה תחנות בדרך',
				'dark'  => true,
				'items' => array(
					array( 'year' => '1999', 'text' => 'המפגש עם הדיג׳רידו ועם מוקש — תחילת הקשר המתמשך עם המאסטר ההודי מוקש דהימן, שיהפוך לציר המרכזי של הדרך התרפויטית.' ),
					array( 'year' => '2001', 'text' => 'צבע בכחול וזרוק לים — הספר הראשון, 38 סיפורים מהטיול הגדול בדרום אמריקה. כיום במהדורה עשירית.' ),
					array( 'year' => '2004', 'text' => 'כושי בלאנטיס — רומן פנטזיה על התעוררות, בחירה ויציאה מהחיים הנוחים מדי.' ),
					array( 'year' => '2017', 'text' => 'וכתבת — קובץ של 46 סיפורים אמיתיים בסגנון ״ספוקן סטוריז״, עם קודי QR שמרחיבים כל סיפור.' ),
					array( 'year' => 'מאז', 'text' => 'שיטת cbDIDG — מתודולוגיה סדורה לעבודה עם הנשימה, שמלווה מאות מטופלים מכל הארץ.' ),
					array( 'year' => 'היום', 'text' => 'המרכז בפרדס חנה — סטודיו שתוכנן אקוסטית, טבול בירוק; מפגשים אישיים, סדנאות, וכתיבה חדשה.' ),
				),
			),
		),

		/* MOKESH — המורה (split, portrait) */
		array(
			'part' => 'split',
			'args' => array(
				'chap'     => 'המורה',
				'title'    => 'מוקש דהימן',
				'body'     => '<p>אחד המקורות המשמעותיים ביותר בדרך היה הקשר המתמשך עם המאסטר ההודי לדיג׳רידו מוקש דהימן, שהחל בשנת 2000. אייל הפך לאחד מתלמידיו הקרובים, ולמד ממנו את יסודות העבודה התרפויטית עם הדיג׳רידו — גישה שמעמידה במרכז את הנשימה והמודעות, ולא רק את הצד המוזיקלי של הכלי.</p><p>״הקשר עם מוקש דהימן הוא הציר שעליו נשענת כל הדרך התרפויטית שלי.״</p><p><a class="more" href="/eyal-amit/mokesh-dahiman/">לעמוד ההנצחה של מוקש דהימן</a></p>',
				'image'    => 'assets/images/chapters/mokesh-eyal.jpg',
				'alt'      => 'אייל עמית עם המאסטר מוקש דהימן ברישיקש, הודו',
				'figr'     => 'p',
				'reversed' => false,
			),
		),

		/* STUDIO gallery — המרחב (reveals) */
		array(
			'part' => 'reveals',
			'args' => array(
				'chap'  => 'המרחב',
				'title' => 'הסטודיו בפרדס חנה',
				'lead'  => 'הסטודיו ממוקם בפרדס חנה, בתוך מרחב ירוק ושקט עם חצר פתוחה, עצי פרי ושבילי עץ — מקום שנבנה ותוכנן מתוך הבנה אקוסטית של צליל ותדר.',
				'items' => array(
					array( 'image' => 'assets/images/chapters/studio-mosaic.jpg', 'title' => 'בניין הפסיפס', 'more' => 'מבנה הפסיפס בגינה — לב המרחב.' ),
					array( 'image' => 'assets/images/chapters/garden.jpg', 'title' => 'הגינה', 'more' => 'חצר פתוחה עם עצי פרי ושבילי עץ.' ),
					array( 'image' => 'assets/images/chapters/studio-didgs.jpg', 'title' => 'הדיג׳רידו בסטודיו', 'more' => 'אוסף הכלים הזמינים לתרגול ולנגינה.' ),
					array( 'image' => 'assets/images/chapters/studio-interior.jpg', 'title' => 'פנים הסטודיו', 'more' => 'מרחב שתוכנן אקוסטית לצליל ולתדר.' ),
				),
			),
		),

		/* BOOKS — גם סופר (prose, centered) */
		array(
			'part' => 'prose',
			'args' => array(
				'chap'   => 'גם סופר',
				'title'  => 'שלושה ספרים, אותה נשימה',
				'center' => true,
				'body'   => '<p><strong>צבע בכחול וזרוק לים</strong> · 2001 · מסע — 38 סיפורים מהטיול הגדול בדרום אמריקה. כיום במהדורה עשירית.</p><p><strong>כושי בלאנטיס</strong> · 2004 · רומן פנטזיה — על התעוררות, בחירה, אומץ והיציאה מהחיים הנוחים מדי.</p><p><strong>וכתבת</strong> · 2017 · סיפורים — 46 סיפורים אמיתיים בסגנון ספוקן-סטוריז, עם קודי QR שמרחיבים כל סיפור.</p><p><a class="btn btn--gd" href="/books/">לעמוד הספרים — מוזה הוצאה לאור</a></p>',
			),
		),

		/* CTA */
		array(
			'part' => 'cta',
			'args' => array(
				'title'     => 'רוצים להכיר?',
				'body'      => 'לתיאום שיחת היכרות, ללא התחייבות.',
				'cta_label' => 'לתיאום שיחת היכרות',
				'cta_url'   => '/contact/',
			),
		),

	),
);
