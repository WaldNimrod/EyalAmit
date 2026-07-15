<?php
/**
 * Chapters /learning/ (לימוד והכשרה) — hub. Team-authored, real content.
 * Sourced from about-defaults §7/§10 + site-tree st-learning-hub children.
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;
return array(
	'phero' => array(
		'chap'      => 'לימוד והכשרה',
		'title'     => 'ללמוד, להעמיק, <em>להנחות</em>',
		'sub'       => 'כל דרכי הלימוד וההכשרה במרכז — משיעור ראשון ועד מסלול הכשרת מטפלים בשיטת cbDIDG.',
		'media'     => 'assets/images/chapters/studio-didgs.jpg',
		'media_alt' => 'סטודיו הלימוד בפרדס חנה',
		'cta_label' => 'לתיאום שיחת היכרות',
		'cta_url'   => '/contact/',
	),
	'sections' => array(
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'פתיח',
				'title' => 'הדרך עוברת דרך לימוד',
				'body'  => '<p>המרכז לטיפול בדיג׳רידו הוא גם בית לימוד. לצד <a class="tlink" href="/treatment/">הטיפול</a> וה<a class="tlink" href="/sound-healing/">סאונד הילינג</a>, מתקיימת כאן עשייה חינוכית רחבה — משיעורי דיג׳רידו אישיים, דרך הרצאות וסדנאות לארגונים ולקבוצות, ועד מסלול הכשרה למי שמבקש ללמד ולטפל בעצמו בשיטת <a class="tlink" href="/method/">cbDIDG</a>.</p><p>בעמוד זה מרוכזות כל דרכי הלימוד וההכשרה, כדי שתוכלו לבחור את נקודת הכניסה הנכונה עבורכם.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'   => 'שיעורים אישיים',
				'title'  => 'שיעורי דיג׳רידו ונשימה מעגלית',
				'body'   => '<p>לימוד אישי של נגינה בדיג׳רידו, נשימה מעגלית והפקת צליל — לכל רמה, מאפס ועד מתקדמים. השיעורים נבנים לפי הקצב והמטרה של כל תלמיד.</p><p><a class="btn btn--gd" href="/lessons/">לעמוד שיעורי דיג׳רידו</a></p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'לארגונים ולקבוצות',
				'title' => 'הרצאות וסדנאות',
				'body'  => '<p>מפגשי נשימה, צליל ודיג׳רידו לחברות, צוותים, כנסים ואירועים — כהרצאה חווייתית או כסדנה מעשית.</p><p><a class="btn btn--gd" href="/learning/lectures/">להרצאות לארגונים</a> &nbsp; <a class="btn btn--gd" href="/learning/workshops/">לסדנאות</a></p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'מסלול עומק',
				'title' => 'הכשרת מטפלים ומנחים בשיטת cbDIDG',
				'body'  => '<p>מסלול הכשרה למי שמבקש ללמוד את הדרך באופן מובנה ומקצועי — ולהמשיך ללמד ולטפל בעצמו. חלק מחזון «הדור הבא» של התחום.</p><p><a class="btn btn--gd" href="/learning/therapist-training/">למסלול הכשרת מטפלים</a></p>',
			),
		),
		array(
			'part' => 'cta',
			'args' => array(
				'title'     => 'לא בטוחים מאיפה להתחיל?',
				'body'      => 'שיחת היכרות קצרה תעזור להבין יחד מה מתאים — שיעור אישי, סדנה, או מסלול הכשרה.',
				'cta_label' => 'לתיאום שיחת היכרות',
				'cta_url'   => '/contact/',
			),
		),
	),
);
