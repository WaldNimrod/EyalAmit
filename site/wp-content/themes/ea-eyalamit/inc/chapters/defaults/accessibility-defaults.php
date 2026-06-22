<?php
/**
 * Chapters /accessibility/ (הצהרת נגישות) — PLACEHOLDER defaults. A formal
 * accessibility statement is legally required in Israel; the final wording is
 * pending Eyal / legal review (logged in the HUB). Basic skeleton below.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(
	'phero' => array(
		'chap'      => 'משפטי',
		'title'     => 'הצהרת <em>נגישות</em>',
		'sub'       => 'אנו פועלים להנגיש את האתר לכלל המשתמשים.',
		'media'     => 'assets/images/chapters/studio-interior.jpg',
		'cta_label' => '',
		'cta_url'   => '',
	),
	'sections' => array(
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'טיוטה',
				'title' => 'הצהרת הנגישות בהשלמה',
				'body'  => '<p>⟨נוסח הצהרת הנגישות הפורמלי (תקן ישראלי 5568 / WCAG 2.0 AA) להשלמה ע״י אייל / ייעוץ מקצועי⟩.</p><p>האתר נבנה מתוך מחויבות לנגישות: מבנה כותרות תקין, ניגודיות, ניווט מקלדת וטקסט חלופי לתמונות. נתקלתם בקושי נגישות? נשמח לדעת ולתקן — <a class="tlink" href="/contact/">צרו קשר</a>.</p>',
			),
		),
	),
);
