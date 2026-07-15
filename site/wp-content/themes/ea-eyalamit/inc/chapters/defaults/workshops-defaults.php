<?php
/**
 * Chapters /learning/workshops/ (סדנאות) — team draft.
 * Content from M3-TEXT-RETURN R6 (st-svc-workshops) + FAQ-4 + about (real).
 * Upcoming-workshops schedule = ea-pending-approval (dynamic, Eyal-updated).
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;
return array(
	'phero' => array(
		'chap'      => 'סדנאות',
		'title'     => 'סדנאות <em>דיג׳רידו ונשימה</em>',
		'sub'       => 'מפגש קבוצתי עם נשימה, צליל, בנייה ותרגול — באווירה חווייתית ומעמיקה.',
		'media'     => 'assets/images/chapters/garden.jpg',
		'media_alt' => 'חצר הסטודיו בפרדס חנה',
		'cta_label' => 'לפרטים ולהרשמה',
		'cta_url'   => '/contact/',
	),
	'sections' => array(
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'מה זה',
				'title' => 'ללמוד ולהתנסות ביחד',
				'body'  => '<p>הסדנאות מאפשרות מפגש קבוצתי עם נשימה, צליל ודיג׳רידו — בין אם המטרה היא ללמוד להפיק צליל ראשון, לתרגל נשימה מעגלית, לבנות כלי, או פשוט לחוות תהליך קבוצתי סביב הקשבה ונוכחות.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'למי מתאים',
				'title' => 'לא רק לנגנים',
				'body'  => '<p>לא בהכרח צריך ניסיון. יש סדנאות שמתאימות גם למי שמגיע בלי רקע, במיוחד כשהמטרה היא מפגש עם תהליך, בנייה, צליל או עבודה קבוצתית. ההתאמה נבחנת לפי אופי הסדנה והקבוצה.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'סוגי סדנאות',
				'title' => 'מה אפשר לחוות',
				'body'  => '<ul><li><strong>סדנת נשימה וצליל</strong> — היכרות חווייתית עם הדיג׳רידו ככלי לעבודה עם הנשימה.</li><li><strong>סדנת נגינה</strong> — הפקת צליל, נשימה מעגלית וקצב, למתחילים ומתקדמים.</li><li><strong>סדנת בנייה</strong> — הצצה לעולם בניית הדיג׳רידו בעבודת יד.</li></ul>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'מתי',
				'title' => 'סדנאות קרובות',
				'body'  => '<div class="ea-pending-approval" role="status"><span class="ea-pending-approval__badge">ממתין לאישור</span><p class="ea-pending-approval__title">לוח הסדנאות הקרובות</p><p class="ea-pending-approval__note">מועדי הסדנאות הקרובות, המיקום והמחיר יתעדכנו כאן. סדנאות פרטיות וקבוצתיות ניתן לתאם בכל עת דרך יצירת קשר.</p></div>',
			),
		),
		array(
			'part' => 'cta',
			'args' => array(
				'title'     => 'רוצים לארגן סדנה?',
				'body'      => 'אפשר לתאם סדנה פרטית לקבוצה, לצוות או לאירוע — צרו קשר ונבנה יחד את המפגש.',
				'cta_label' => 'ליצירת קשר',
				'cta_url'   => '/contact/',
			),
		),
	),
);
