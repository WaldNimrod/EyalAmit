<?php
/**
 * Chapters /learning/lectures/ (הרצאות לארגונים) — team draft.
 * Content re-authored from mockup-lectures.html + about (real, publishable).
 * Purchase/pricing link = ea-pending-approval (depends on Eyal GI link, WP-EI-01).
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;
return array(
	'phero' => array(
		'chap'      => 'לארגונים',
		'title'     => 'הרצאות <em>ומפגשי נשימה</em> לארגונים',
		'sub'       => 'חוויית נשימה, מבוא לדיג׳רידו וסאונד הילינג — מותאם לזמן, לקהל ולמטרה של הארגון.',
		'media'     => 'assets/images/chapters/studio-didgs.jpg',
		'media_alt' => 'אייל עמית מנחה מפגש דיג׳רידו',
		'cta_label' => 'לבקשת הצעה',
		'cta_url'   => '/contact/',
	),
	'sections' => array(
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'מה זה',
				'title' => 'הפוגה שמחזירה נשימה',
				'body'  => '<p>מפגש נשימה ודיג׳רידו לחברות, צוותים, כנסים ואירועים — הזדמנות לעצור, לנשום ולהתחבר דרך חוויה בלתי-שגרתית. המפגש משלב הרצאה קצרה על נשימה וצליל, הדגמה חיה של הדיג׳רידו, וחלק חווייתי מעשי שמתאים גם למי שמעולם לא ניגן.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'פורמטים',
				'title' => 'פורמטים אפשריים',
				'body'  => '<ul><li><strong>מפגש 45–60 דקות</strong> — הרצאה + הדגמה חיה.</li><li><strong>סדנה 90–120 דקות</strong> — חוויה מעורבת של הקשבה ותרגול.</li><li><strong>יום עיון</strong> — לפי תיאום ומטרות הארגון.</li></ul><p>כל פורמט מותאם למספר המשתתפים, למקום ולזמן העומד לרשותכם.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'הערך',
				'title' => 'מה הארגון מקבל',
				'body'  => '<p>הפוגה מרעננת מהשגרה, כלים פשוטים לריכוז ולנשימה רגועה יותר, וחוויה משותפת שמחברת בין אנשים. מפגש שנשאר בזיכרון הרבה אחרי שהוא נגמר.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'איך מזמינים',
				'title' => 'תהליך ההזמנה',
				'body'  => '<p>יצירת קשר ← התאמת מסר, זמן וקהל ← הצעת מחיר ← אישור ← המפגש. אפשר לפנות דרך <a class="tlink" href="/contact/">עמוד יצירת הקשר</a> ולתאם שיחה קצרה שבה נבין יחד מה מתאים.</p><div class="ea-pending-approval" role="status"><span class="ea-pending-approval__badge">ממתין לאישור</span><p class="ea-pending-approval__title">מחירון וקישור תשלום / הצעת מחיר מקוונת</p><p class="ea-pending-approval__note">מחיר המפגשים וקישור התשלום דרך חשבונית ירוקה יתווספו כאן לאחר אישור אייל (מתואם עם חבילת קישורי הסליקה). עד אז ההזמנה מתבצעת דרך יצירת קשר.</p></div>',
			),
		),
	),
);
