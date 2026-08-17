<?php
/**
 * Chapters /media/ (מדיה) — ריכוז כל ההמלצות + מדיה.
 *
 * S006 · H-15 · מקור: content 13.8.26/ריכוז כל ההמלצות - טיפול בדיג'רידו, שיעורי
 * נגינה, סאונדהילינג,/ממליצים מהפייסבוק.docx — 48 המלצות בשלוש הקטגוריות של אייל,
 * בסדר ובחלוקה שלו במסמך:
 *   «טיפול בדיג'רידו» 17 · «סאונד הילינג» 9 · «שיעורי נגינה בדיג'רידו» 22 = 48
 * (34 שמות ייחודיים; חלק מהממליצים כתבו יותר מפוסט אחד).
 * הכותרות כאן הן המחרוזות של אייל מהמסמך, מילה במילה, כולל הגרש U+0027.
 * הטקסט עצמו לא משוכפל לכאן — הוא נמשך מהקורפוס inc/data/ea-testimonials-fb.json
 * (שלא נגע) דרך ea_fb_testimonials_archive(), בדיוק כפי שאר העמודים ניזונים ממנו.
 *
 * ⚠ פריטי המדיה עצמם (סרטונים, הקלטות, כתבות) עדיין ממתינים לאייל — ולכן
 * ה-pending-note נשאר במקומו, מעל הגלריה שאליה הוא מתייחס («התמונות למטה»).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	'phero' => array(
		'chap'      => 'מדיה',
		'title'     => 'מדיה <em>ווידאו</em>',
		'sub'       => 'סרטונים, הקלטות, וכתבות על העבודה עם הנשימה והדיג׳רידו.',
		'media'     => 'assets/images/chapters/eyal-window.jpg',
		'media_alt' => "אייל עמית מנגן בדיג'רידו",
	),

	'sections' => array(

		/* S006 · H-15 · מקור: content 13.8.26/ריכוז כל ההמלצות…/ממליצים מהפייסבוק.docx
		 * שלוש הקטגוריות של אייל, כל אחת כמקטע נפרד עם הכותרת שלו מהמסמך. סדר
		 * הרשומות בכל קטגוריה הוא סדר המסמך (הקורפוס נשמר באותו סדר, אומת 48/48).
		 * 'archive' => true מושך את הקטגוריה במלואה, כולל המלצה שאין לה snippet
		 * בקורפוס — היא מרונדרת כשם + קישור, בלי שהומצא לה טקסט. */
		array(
			'part' => 'testimonials',
			'args' => array(
				'title'   => "טיפול בדיג'רידו",
				'cat'     => 'treatment',
				'archive' => true,
				'layout'  => 'grid',
			),
		),

		array(
			'part' => 'testimonials',
			'args' => array(
				'title'   => 'סאונד הילינג',
				'cat'     => 'sound-healing',
				'archive' => true,
				'layout'  => 'grid',
			),
		),

		array(
			'part' => 'testimonials',
			'args' => array(
				'title'   => "שיעורי נגינה בדיג'רידו",
				'cat'     => 'lessons',
				'archive' => true,
				'layout'  => 'grid',
			),
		),

		array(
			'part' => 'pending-note',
			'args' => array(
				'chap'  => 'בהשלמה',
				'title' => 'אוסף המדיה בהשלמה',
				'note'  => 'תוכן עמוד המדיה — סרטונים, הקלטות וכתבות — ממתין להשלמה ולאישור מאייל. התמונות למטה הן תצוגה לדוגמה.',
			),
		),

		array(
			'part' => 'gallery',
			'args' => array(
				'chap'  => 'רגעים',
				'title' => 'מתוך המפגשים והנגינה',
				'items' => array(
					array( 'image' => 'assets/images/chapters/eyal-playing.jpg', 'alt' => 'נגינה', 'cap' => '' ),
					array( 'image' => 'assets/images/chapters/eyal-teaching.jpg', 'alt' => 'הוראה', 'cap' => '' ),
					array( 'image' => 'assets/images/chapters/group-session-garden.jpg', 'alt' => 'מפגש קבוצתי', 'cap' => '' ),
					array( 'image' => 'assets/images/chapters/eyal-receiving.jpg', 'alt' => 'סאונד הילינג', 'cap' => '' ),
				),
			),
		),

		array(
			'part' => 'cta',
			'args' => array(
				'title'     => 'רוצים לשמוע עוד?',
				'body'      => 'מוזמנים לפנות לתיאום שיחת היכרות.',
				'cta_label' => 'ליצירת קשר',
				'cta_url'   => '/contact/',
			),
		),
	),
);
