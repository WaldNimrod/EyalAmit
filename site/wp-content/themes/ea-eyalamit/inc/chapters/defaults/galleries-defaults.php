<?php
/**
 * Chapters /galleries/ (גלריות) — PLACEHOLDER defaults. No Eyal source (na in
 * content-diff PAGE_MAP); the imagery + curation are pending Eyal (logged in the
 * HUB). Shows the Chapters layout with sample studio imagery so the page is
 * visually consistent for the meeting.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	'phero' => array(
		'chap'      => 'גלריות',
		'title'     => 'גלריות <em>ותמונות</em>',
		'sub'       => 'רגעים מהסטודיו, מהמפגשים ומהדרך.',
		'media'     => 'assets/images/chapters/studio-mosaic.jpg',
		'media_alt' => 'הסטודיו בפרדס חנה',
	),

	'sections' => array(

		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'בקרוב',
				'title' => 'גלריית התמונות בהשלמה',
				'body'  => '<p>⟨תוכן הגלריה והתמונות להשלמה ע״י אייל⟩ — להלן תצוגה לדוגמה של מבנה הגלריה.</p>',
			),
		),

		array(
			'part' => 'gallery',
			'args' => array(
				'chap'  => 'הסטודיו והמרחב',
				'title' => 'הצצה אל המרחב',
				'items' => array(
					array( 'image' => 'assets/images/chapters/studio-interior.jpg', 'alt' => 'פנים הסטודיו', 'cap' => '⟨כיתוב להשלמה⟩' ),
					array( 'image' => 'assets/images/chapters/garden.jpg', 'alt' => 'הגינה', 'cap' => '⟨כיתוב להשלמה⟩' ),
					array( 'image' => 'assets/images/chapters/studio-didgs.jpg', 'alt' => "דיג'רידו בסטודיו", 'cap' => '⟨כיתוב להשלמה⟩' ),
					array( 'image' => 'assets/images/chapters/eyal-playing.jpg', 'alt' => 'אייל מנגן', 'cap' => '⟨כיתוב להשלמה⟩' ),
					array( 'image' => 'assets/images/chapters/group-session-garden.jpg', 'alt' => 'מפגש בגינה', 'cap' => '⟨כיתוב להשלמה⟩' ),
					array( 'image' => 'assets/images/chapters/eyal-workshop.jpg', 'alt' => 'בית המלאכה', 'cap' => '⟨כיתוב להשלמה⟩' ),
				),
			),
		),

		array(
			'part' => 'cta',
			'args' => array(
				'title'     => 'רוצים לבקר במרחב?',
				'body'      => 'אפשר לתאם שיחת היכרות וביקור בסטודיו בפרדס חנה.',
				'cta_label' => 'לתיאום שיחת היכרות',
				'cta_url'   => '/contact/',
			),
		),
	),
);
