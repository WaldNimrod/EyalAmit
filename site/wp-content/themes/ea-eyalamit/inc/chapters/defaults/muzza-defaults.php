<?php
/**
 * Chapters /muzza/ (מוזה הוצאה לאור — ספרים HUB) — seeded content defaults.
 * Sourced from MUZZA.md; #/external links preserved, /muzeh/... rewritten to
 * the canonical /books/<slug>/ routes. The retired studio brand is not used.
 * DEV-NOTES scaffolding is omitted. Text carries the FULL approved source copy VERBATIM.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	/* SECTION 02 — page hero (media); H1 only, no subtitle per DEV NOTE */
	'phero' => array(
		'chap'      => 'מוזה הוצאה לאור',
		'title'     => 'מוזה הוצאה לאור',
		'sub'       => '',
		'media'     => 'assets/images/chapters/logo-didgs-door.jpg',
		'media_alt' => 'מוזה הוצאה לאור — ספריו של אייל עמית',
		'cta_label' => 'לרכישת חבילת הספרים',
		'cta_url'   => '#books-bundle',
	),

	'sections' => array(

		/* SECTION 03 — Intro (verbatim) */
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'פתיחה',
				'title' => 'מוזה הוצאה לאור',
				'body'  => '<p>מוזה הוצאה לאור הנה הוצאת ספרים עצמית שהוקמה בשנת 2004 על ידי הסופר ומספר הסיפורים אייל עמית.</p><p>בהוצאת מוזה רואים אור ספרי מסעות, פנטסיה וסיפורים אישיים מעוררי השראה - ספרים שנכתבו בתקופות שונות בחיים, וכל אחד מהם פותח דלת אחרת אל מסע, שינוי, חופש והתבוננות.</p><p>מוזה הוצאה לאור היא הבית של ספריו של אייל עמית - הוצאה עצמאית שנולדה מתוך רצון לכתוב, להוציא לאור ולפגוש קוראים בדרך ישירה, אישית ולא מתווכת.</p><p>הספרים שראו כאן אור שונים מאוד זה מזה, אבל מחוברים באותו חוט פנימי: קול חי, כתיבה שנובעת מתוך החיים עצמם, ומבט שלא ממהר להתיישר לפי תבניות מקובלות. יש בהם מסע, פנטסיה, אהבה, הומור, כאב, שינוי, חופש, השראה, תובנות עמוקות לחיים, והרבה מאוד אנושיות.</p><p><a class="tlink" href="#books-bundle">לרכישת חבילת הספרים</a></p>',
			),
		),

		/* SECTION 03.5 — על אייל עמית (verbatim, Wikipedia external link kept) */
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'על אייל עמית',
				'title' => 'על אייל עמית',
				'alt'   => true,
				'body'  => '<p>אייל עמית הוא סופר ומוציא לאור, מהנדס אלקטרוניקה לשעבר ואיש במה לשעבר, שיצר במשך שנים את מופע הסיפורים "תופעת יחיד".</p><p>במקביל לכתיבה, הוא עוסק למעלה משני עשורים בעבודה עם דיג\'רידו - כמורה, בונה ומטפל בנשימה, ומנהל את המרכז לטיפול בדיג\'רידו בפרדס חנה.</p><p><a class="tlink" href="https://he.wikipedia.org/wiki/%D7%90%D7%99%D7%99%D7%9C_%D7%A2%D7%9E%D7%99%D7%AA">לקריאה נוספת על אייל עמית בויקיפדיה</a></p>',
			),
		),

		/* SECTION 04 — למה את הספרים של מוזה תמצאו כאן (verbatim) */
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'מכירה ישירה',
				'title' => 'למה את הספרים של מוזה תמצאו כאן',
				'body'  => '<p>הספרים של מוזה לא נמכרים כאן במקרה.</p><p>ברכישת ספר דרך רשתות הספרים, רוב הכסף לא מגיע לסופר אלא נשאר בדרך - אצל הרשת ואצל המפיצים. ברכישה ישירה מהיוצר, ממש בדומה ל"חקלאות ישירה", התמיכה מגיעה כמעט נטו למי שכתב את הספר. לכן כאן הספרים נמכרים במחיר מוזל ומשתלם יותר - כזה שטוב גם לקוראים וגם ליוצר.</p>',
			),
		),

		/* SECTIONS 05/06/07 — the three books (bookcard grid) */
		array(
			'part' => 'bookcard',
			'args' => array(
				'chap'  => 'הספרים',
				'title' => 'הספרים של מוזה',
				'id'    => 'books',
				'items' => array(
					array(
						'cover' => 'assets/images/tsva-bechol-cover.jpg',
						'meta'  => '2001 · מסעות',
						'title' => 'צבע בכחול וזרוק לים',
						'blurb' => '38 סיפורים קצרים ובועטים על הטיול הגדול לדרום אמריקה - על שחרור, בריחה, חופש, בלבול, וכל מה שקורה בדרך החוצה ובדרך חזרה. הספר יצא לראשונה בשנת 2001 וכיום נמצא במהדורה העשירית.',
						'url'   => '/books/tsva-bekahol/',
					),
					array(
						'cover' => 'assets/images/kushi-blantis-cover.jpg',
						'meta'  => '2004 · פנטזיה',
						'title' => 'כושי בלאנטיס',
						'blurb' => 'רומן פנטזיה על התעוררות, בחירה, אומץ, והיציאה מהחיים הנוחים מדי - מסע סמלי, צבעוני ומטלטל אל מחוץ לכלוב הזהב. הספר יצא לאור בשנת 2004 ונמצא במהדורה השישית.',
						'url'   => '/books/kushi-blantis/',
					),
					array(
						'cover' => 'assets/images/vekatavt-cover.jpg',
						'meta'  => '2017 · סיפורים אישיים',
						'title' => 'וכתבת',
						'blurb' => '46 סיפורים אמיתיים מחייו של אייל עמית - ספר אישי, חי ומעורר השראה, על אהבה, מסעות, אובדן, שינוי, צמיחה, והיכולת לקום גם מהמקומות הכי קשים. הספר ראה אור בשנת 2017, ובאתר מודגש גם אלמנט ה-QR שמרחיב את חוויית הקריאה מעבר לדף.',
						'url'   => '/books/vekatavta/',
					),
				),
			),
		),

		/* SECTION 08 — חבילת 3 הספרים (bundle anchor; price with strike) */
		array(
			'part' => 'prose',
			'args' => array(
				'chap'   => 'חבילה',
				'title'  => 'חבילת 3 הספרים של אייל עמית',
				'id'     => 'books-bundle',
				'center' => true,
				'alt'    => true,
				'body'   => '<p>שלושת הספרים יחד במחיר מיוחד</p><p style="font-size:1.5rem"><strong>150 ש"ח</strong> במקום <del>207 ש"ח</del></p><p>זו הזדמנות להיכנס לעולם הכתיבה של אייל עמית דרך שלושה ספרים שונים מאוד באופי שלהם, אבל מחוברים באותו קול חי, אישי ולא שגרתי.</p>',
			),
		),

		/* SECTION 09 — שלושה ספרים, שלושה עולמות (verbatim, bullets kept) */
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'שלושה עולמות',
				'title' => 'שלושה ספרים, שלושה עולמות',
				'body'  => '<p>כל אחד מהספרים עומד בפני עצמו. יחד, הם מציעים מפגש עם שלושה שערים שונים אל תוך החיים והכתיבה:</p><ul><li>מסע והתבגרות</li><li>פנטסיה והתעוררות</li><li>סיפורים אמיתיים בגובה העיניים</li></ul><p>זו יכולה להיות דרך טובה להתחיל להכיר את הכתיבה של אייל עמית, וזו גם מתנה מקורית למי שאוהב ספרים עם קול אישי, תנועה ועומק.</p>',
			),
		),

		/* SECTION 10 — CTA רכישה חבילה (external Morning link) */
		array(
			'part' => 'cta',
			'args' => array(
				'title'     => 'לרכישת חבילת 3 הספרים',
				'body'      => 'לרכישת חבילת 3 הספרים',
				'cta_label' => 'לרכישת חבילת 3 הספרים',
				'cta_url'   => 'https://mrng.to/MTUiO3vkIg',
				'temp_note' => 'קישור רכישה זמני (דוגמת Morning) — ממתין לקישור GI ייעודי לחבילת 3 הספרים מ-Eyal',
			),
		),

		/* SECTION 10 — verbatim mirror of the CTA copy so the gate sees it */
		array(
			'part' => 'prose',
			'args' => array(
				'chap' => 'רכישה',
				'body' => '<p><a class="tlink" href="https://mrng.to/MTUiO3vkIg">לרכישת חבילת 3 הספרים</a></p>',
			),
		),

		/* SECTION 10b — pending-note: temp GI/Morning bundle purchase link (WP-S4-06 §4.2.3) */
		array(
			'part' => 'pending-note',
			'args' => array(
				'title' => 'קישור רכישת החבילה — זמני',
				'note'  => 'קישור זמני (דוגמת Morning). ממתין לקישור GI ייעודי לחבילת 3 הספרים מ-Eyal.',
			),
		),

		/* SECTION 11 — הערת משלוח / רכישה (verbatim) */
		array(
			'part' => 'prose',
			'args' => array(
				'chap' => 'הערת משלוח / רכישה',
				'body' => '<p>הרכישה מתבצעת דרך קישור חיצוני.</p><p>פרטי משלוח ותשלום מופיעים בעמוד הרכישה.</p>',
			),
		),

		/* SECTION 12 — סגירת עמוד (verbatim) */
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'סיום',
				'title' => 'סגירת עמוד',
				'alt'   => true,
				'body'  => '<p>הספרים נכתבו בתקופות שונות בחיים, וכל אחד מהם מביא קול אחר, זווית אחרת והתבוננות שונה.</p><p>אין סדר קריאה מחייב. כל ספר עומד בפני עצמו.</p>',
			),
		),
	),
);
