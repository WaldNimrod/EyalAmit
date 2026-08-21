<?php
/**
 * Chapters /shop/ — hub of five services (S006 wave 6, 19.8 column 5).
 *
 * Product copy for «כלי דיג'רידו למכירה» lives on /didgeridoos/.
 * This page is the cube menu Eyal asked for under «כלים בעבודת יד ואביזרים».
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	'phero' => array(
		'title' => "כלים בעבודת יד ואביזרים",
		'sub'   => "כל מה שצריך לדיג׳רידו, במקום אחד",
	),

	'sections' => array(

		array(
			'part' => 'prose',
			'args' => array(
				'title' => "כל מה שצריך לדיג׳רידו, במקום אחד",
				'body'  => '<p>מקום אחד שמרכז את כל מה שנגן דיג׳רידו צריך - משלב בחירת הכלי ועד לנגינה, נשיאה, אחסון ותחזוקה לאורך השנים.</p><p>כאן ניתן למצוא <strong>כלי דיג׳רידו בעבודת יד</strong>, שירותי <strong>תיקון וחידוש כלים</strong>, <strong>תיקים לדיג׳רידו</strong>, <strong>סטנדים לאחסון</strong> ו<strong>סטנד רצפתי לנגינה</strong>.</p><p>כל השירותים והמוצרים נשענים על יותר משני עשורים של ניסיון, היכרות עמוקה עם הדיג׳רידו והבנה מעשית של הצרכים של נגנים - מתחילים ומנוסים כאחד.</p>',
			),
		),

		array(
			'part' => 'bookcard',
			'args' => array(
				'cta_label' => 'לעמוד ←',
				'items'     => array(
					array(
						'cover' => 'assets/images/chapters/studio-didgs.jpg',
						'title' => "כלי דיג'רידו למכירה",
						'blurb' => "כלים בעבודת יד, מותאמים לנשימה ולנגינה.",
						'url'   => '/didgeridoos/',
						'cta'   => 'לעמוד הכלים ←',
					),
					array(
						'cover' => 'assets/images/chapters/eyal-workshop.jpg',
						'title' => 'תיקון וחידוש כלים',
						'blurb' => "טיפול בסדקים, שברים ושחיקה — חידוש הכלי.",
						'url'   => '/repair/',
						'cta'   => 'לעמוד התיקון ←',
					),
					array(
						'cover' => 'assets/images/chapters/didgs-window.jpg',
						'title' => "תיקים לדיג'רידו",
						'blurb' => 'הגנה על הכלי בדרך, באחסון ובשימוש היומיומי.',
						'url'   => '/bags/',
						'cta'   => 'לעמוד התיקים ←',
					),
					array(
						'cover' => 'assets/images/chapters/didg-bells.jpg',
						'title' => "סטנדים לאחסון דיג'רידו",
						'blurb' => 'לתלייה או בעמידה — שומרים על הכלי יציב ונגיש.',
						'url'   => '/stands-storage/',
						'cta'   => 'לעמוד הסטנדים ←',
					),
					array(
						'cover' => 'assets/images/chapters/eyal-playing.jpg',
						'title' => 'סטנד רצפתי לנגינה',
						'blurb' => 'תמיכה בנגינה בישיבה נמוכה.',
						'url'   => '/stand-floor/',
						'cta'   => 'לעמוד הסטנד ←',
					),
				),
			),
		),

	),
);
