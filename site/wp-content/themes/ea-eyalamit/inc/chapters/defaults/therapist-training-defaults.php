<?php
/**
 * Chapters /learning/therapist-training/ (הכשרות למטפלים) — team draft.
 * Vision copy sourced verbatim-ish from about-defaults §10/§7 (real Eyal content).
 * Program structure / dates / pricing = ea-pending-approval (genuinely missing).
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;
return array(
	'phero' => array(
		'chap'      => 'הכשרה',
		'title'     => 'הכשרת <em>מטפלים ומנחים</em> בשיטת cbDIDG',
		'sub'       => 'להעביר את הידע הלאה — מסלול עומק למי שמבקש ללמוד, ללמד ולטפל בנשימה באמצעות דיג׳רידו.',
		'media'     => 'assets/images/chapters/studio-interior.jpg',
		'media_alt' => 'פנים הסטודיו בפרדס חנה',
		'cta_label' => 'להשארת פרטים ולתיאום שיחה',
		'cta_url'   => '/contact/',
	),
	'sections' => array(
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'החזון',
				'title' => 'הדור הבא של התחום',
				'body'  => '<p>בשנים האחרונות הולכת ומתבהרת עבורי משימה נוספת: העברת הידע הלאה. לצד העבודה עם תלמידים ומטופלים, אני פועל להקמת מסלול הכשרת מטפלים ומנחים בשיטת <a class="tlink" href="/method/">cbDIDG</a>.</p><p>מטרתי היא להכשיר דור חדש של אנשי מקצוע שיוכלו להמשיך לפתח, ללמד ולהנגיש את העבודה עם נשימה ודיג׳רידו. אני מאמין שתחום הטיפול בנשימה באמצעות דיג׳רידו נמצא רק בתחילת דרכו בישראל, ושבשנים הקרובות ימשיך להתפתח ולהתרחב.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'למי מיועד',
				'title' => 'למי מתאים המסלול',
				'body'  => '<p>המסלול מיועד למי שכבר פגש את הדיג׳רידו ואת עבודת הנשימה ומבקש להעמיק — מטפלים ומנחים מתחומים משיקים, נגני דיג׳רידו מנוסים, ואנשים שרוצים להפוך את העיסוק בנשימה ובצליל למקצוע. אין צורך בהכשרה רפואית קודמת; נקודת המוצא היא היכרות עם הדרך והתאמה אישית שנבחנת בשיחה.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'מבנה המסלול',
				'title' => 'תוכנית ההכשרה',
				'body'  => '<div class="ea-pending-approval" role="status"><span class="ea-pending-approval__badge">ממתין לאישור</span><p class="ea-pending-approval__title">מבנה המסלול, תנאי קבלה, מועדי פתיחה ועלות</p><p class="ea-pending-approval__note">הפרטים המדויקים של תוכנית ההכשרה — משך, שלבים, תנאי קבלה, מועדי פתיחה קרובים ומחיר — יתפרסמו כאן לאחר גיבוש סופי ואישור. מוזמנים כבר עכשיו להשאיר פרטים ולתאם שיחה, כדי להיות ראשונים לדעת כשהמסלול נפתח.</p></div>',
			),
		),
		array(
			'part' => 'cta',
			'args' => array(
				'title'     => 'רוצים להיות בין הראשונים?',
				'body'      => 'השאירו פרטים ותאמו שיחה — נעדכן אתכם כשמבנה המסלול והמועדים ייסגרו.',
				'cta_label' => 'להשארת פרטים',
				'cta_url'   => '/contact/',
			),
		),
	),
);
