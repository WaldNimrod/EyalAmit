<?php
/**
 * Chapters /media/ (מדיה) — PLACEHOLDER defaults. No Eyal source (na in PAGE_MAP);
 * media items (video, press, recordings) pending Eyal (logged in the HUB). Shows
 * the Chapters layout for meeting consistency.
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
