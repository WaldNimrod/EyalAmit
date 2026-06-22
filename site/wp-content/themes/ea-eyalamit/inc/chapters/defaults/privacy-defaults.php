<?php
/**
 * Chapters /privacy/ (מדיניות פרטיות) — PLACEHOLDER defaults. Final legal text
 * pending Eyal / legal review (logged in the HUB). Renders the Chapters doc layout.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(
	'phero' => array(
		'chap'      => 'משפטי',
		'title'     => 'מדיניות <em>פרטיות</em>',
		'sub'       => 'כיצד אנו אוספים, משתמשים ושומרים על המידע שלך.',
		'media'     => 'assets/images/chapters/studio-interior.jpg',
		'cta_label' => '',
		'cta_url'   => '',
	),
	'sections' => array(
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'טיוטה',
				'title' => 'מדיניות הפרטיות בהשלמה',
				'body'  => '<p>⟨נוסח מדיניות הפרטיות המלא להשלמה ע״י אייל / ייעוץ משפטי⟩.</p><p>באופן כללי: המידע הנמסר בטופס יצירת הקשר משמש אך ורק למענה לפנייה ואינו מועבר לצד שלישי. לפרטים או בקשה למחיקת מידע ניתן <a class="tlink" href="/contact/">ליצור קשר</a>.</p>',
			),
		),
	),
);
