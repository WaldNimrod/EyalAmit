<?php
/**
 * Chapters /contact/ (צור קשר) — seeded content defaults.
 * Renders on the generic tpl-chapters-page: phero + the 'contact' part (CF7 form
 * + WhatsApp A/B + NAP). No Eyal .md source — copy is template strings; there is
 * no content-diff entry for /contact/.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	'phero' => array(
		'chap'      => 'צור קשר',
		'title'     => 'צור <em>קשר</em>',
		'sub'       => 'ניתן ליצור קשר לתיאום שיחת היכרות, שאלות כלליות או כל פנייה אחרת.',
		'media'     => 'assets/images/chapters/garden.jpg',
		'media_alt' => 'הגינה והסטודיו בפרדס חנה',
		'cta_label' => 'דברו איתי בוואטסאפ',
		'cta_url'   => '#contact',
	),

	'sections' => array(
		array( 'part' => 'contact', 'args' => array() ),
	),
);
