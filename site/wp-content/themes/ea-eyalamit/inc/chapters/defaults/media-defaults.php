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
			'part' => 'prose',
			'args' => array(
				'chap'  => 'בקרוב',
				'title' => 'אוסף המדיה בהשלמה',
				'body'  => '<p>⟨תוכן עמוד המדיה — סרטונים, הקלטות וכתבות — להשלמה ע״י אייל⟩. להלן תצוגה לדוגמה.</p>',
			),
		),

		array(
			'part' => 'gallery',
			'args' => array(
				'chap'  => 'רגעים',
				'title' => 'מתוך המפגשים והנגינה',
				'items' => array(
					array( 'image' => 'assets/images/chapters/eyal-playing.jpg', 'alt' => 'נגינה', 'cap' => '⟨כיתוב להשלמה⟩' ),
					array( 'image' => 'assets/images/chapters/eyal-teaching.jpg', 'alt' => 'הוראה', 'cap' => '⟨כיתוב להשלמה⟩' ),
					array( 'image' => 'assets/images/chapters/group-session-garden.jpg', 'alt' => 'מפגש קבוצתי', 'cap' => '⟨כיתוב להשלמה⟩' ),
					array( 'image' => 'assets/images/chapters/eyal-receiving.jpg', 'alt' => 'סאונד הילינג', 'cap' => '⟨כיתוב להשלמה⟩' ),
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
