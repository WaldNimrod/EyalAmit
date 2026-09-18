<?php
/**
 * Chapters /accessibility/ (הצהרת נגישות).
 *
 * Rewritten 2026-09-18 under team_00 decision D-B («מאשר עדכון ההצהרה»), after
 * the S006 accessibility audit found that the previous wording asserted
 * adjustments the site had not made — most seriously a flat, sitewide claim of
 * alt text on images while 162 content photographs across the three book
 * galleries rendered alt="". Regulation 35ה requires the statement to describe
 * the adjustments ACTUALLY made, so the previous text was the single largest
 * exposure in the audit, larger than any code defect.
 *
 * Every factual claim below was measured on live staging on 2026-09-18, across
 * 12 pages INCLUDING the three book galleries the earlier sample had missed,
 * with every image forced to decode first. Evidence:
 *   _COMMUNICATION/team_100/S006/A11Y-CONSOLIDATED-REGISTER-2026-09-17.md
 *   _COMMUNICATION/team_10/A11Y-FIX-2026-09-18/
 *   tmp/qa/a11y-verify/team100-verification-log.md
 *
 * Standing rules that shaped the wording:
 *  - D-B: «פועלים לפי», never «עומדים». No conformance is claimed as fact, and
 *    the absence of an independent external audit is disclosed.
 *  - D-A: no overlay/accessibility widget is installed, so none is cited.
 *  - D-F / charter §8א clause 5: a clean automated scan is not evidence. axe-core
 *    reported 0 violations on the three book pages both before and after 162
 *    photographs were fixed, so no automated result underwrites any claim here.
 *  - D-E: the WP-EI-05 draft banner stays until Eyal approves the final wording.
 *  - Limitations are named specifically rather than hedged, because reg. 35ה asks
 *    for נקודות חוסר and a vague limitation clause protects nobody.
 *
 * NOT legal advice. Open for Eyal: the coordinator's name (D-C) — he must approve
 * being named before it is published; the six photographs he still has to identify.
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
		/* D-E · team_00 2026-09-18 — the banner stays until Eyal approves the final wording. */
		array(
			'part' => 'pending-note',
			'args' => array(
				'title' => 'נוסח משפטי — טיוטת צוות, טרם אושרה סופית',
				'note'  => 'הנוסח שלהלן נכתב על ידי הצוות כטיוטה עניינית ושמישה. הוא ממתין לבדיקה ולאישור סופיים של אייל / ייעוץ משפטי לפני שייחשב מחייב (WP-EI-05).',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'מחויבות',
				/* Not «הצהרת נגישות» again: that is the page H1, and repeating it as the
				   first H2 gives a screen-reader user the same heading twice in a row. */
				'title' => 'המחויבות שלנו',
				'body'  => '<p>המרכז לטיפול בדיג׳רידו רואה חשיבות רבה במתן שירות שוויוני לכלל הלקוחות, ופועל להנגיש את האתר כך שיהיה זמין ונוח לשימוש גם עבור אנשים עם מוגבלות.</p><p>אנו <strong>פועלים לפי</strong> תקנות שוויון זכויות לאנשים עם מוגבלות (התאמות נגישות לשירות), התשע״ג-2013, ולפי התקן הישראלי ת״י 5568 המבוסס על הנחיות WCAG 2.0 ברמה AA. <strong>לא בוצעה ביקורת נגישות חיצונית ובלתי תלויה</strong>, ולכן איננו מצהירים על עמידה מלאה ומאושרת בתקן, אלא מתארים להלן את ההתאמות שביצענו בפועל ואת המגבלות הידועות לנו.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'מה הונגש',
				'title' => 'ההתאמות שבוצעו בפועל',
				'body'  => '<p>כל הפריטים הבאים נבדקו ונמדדו על האתר עצמו בספטמבר 2026, בשנים־עשר עמודים מרכזיים:</p><ul><li><strong>מבנה כותרות תקין.</strong> כותרת ראשית אחת בכל עמוד, ללא דילוג בין רמות הכותרות, כך שניתן לסרוק את העמוד לפי כותרות.</li><li><strong>טקסט חלופי לתמונות התוכן.</strong> כל תמונה נושאת תיאור, למעט תמונות קישוט המסומנות ככאלה ולמעט מספר תמונות שטרם זוהו — ראו «מגבלות ידועות» למטה.</li><li><strong>קישור «דלג לתוכן»</strong> בראש כל עמוד, המעביר את המיקוד לאזור התוכן הראשי.</li><li><strong>ניווט מלא במקלדת</strong>, לרבות התפריט במסכים צרים. כל פקד מקבל סימון מיקוד — ראו הסתייגות ב«מגבלות ידועות» לגבי בולטות הסימון בחלק מהפקדים.</li><li><strong>הגדלת טקסט</strong> עד פי שניים ללא חיתוך תוכן וללא גלילה אופקית.</li><li><strong>סימון אזורי תוכן</strong> — אזור תוכן ראשי יחיד, אזורי ניווט מסומנים בשם, ומזהים ייחודיים ללא כפילויות.</li><li><strong>ניגודיות צבעים</strong> מותאמת לטקסט, לרבות צבע הטקסט במצב מיקוד מקלדת.</li></ul>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'מגבלות',
				'title' => 'מגבלות ידועות',
				'body'  => '<p>אנו מעדיפים לפרט את המגבלות שאנו מכירים, ולא להסתפק בנוסח כללי:</p><ul><li><strong>לא בוצעה בדיקה בקורא מסך.</strong> האתר נבנה עם סימון מתאים לקוראי מסך ונבדק בכלים אוטומטיים וידניים, אך טרם נבדק בפועל מול תוכנת קורא מסך.</li><li><strong>מספר תמונות בגלריות הספרים ממתינות לזיהוי</strong> ולכן טרם ניתן להן תיאור. העדפנו להשאירן ללא תיאור על פני לנחש את תוכנן.</li><li><strong>רכיב ממשק אחד</strong> — תגית נושא במצב מסומן — עדיין אינו עומד ביחס הניגודיות הנדרש, ותיקונו מצריך שינוי בצבע מותג.</li><li><strong>סימון המיקוד במקלדת בולט פחות מדי בחלק מהפקדים.</strong> הטקסט עצמו קריא בכל מצב, אך מסגרת הסימון בכמה פקדים — ובהם קישור הדילוג וכפתורי הפעולה — אינה בולטת מספיק מול הרקע שמאחוריה. אנו פועלים לתקן זאת.</li><li><strong>תכני צד שלישי</strong>, ובהם הטמעות וידאו, אינם בשליטתנו המלאה.</li><li><strong>כלי בדיקה אוטומטיים אינם מעידים על עמידה בתקן.</strong> למדנו זאת באתר הזה: בספטמבר 2026 סורק תקני דיווח «אפס תקלות» על עמודים שבהם 162 תמונות תוכן היו אז חסרות תיאור לחלוטין. אותן תמונות תוארו מאז, ונותרו מעטות הממתינות לזיהוי כאמור למעלה. לכן כל הבדיקות שלעיל נעשו גם ידנית.</li></ul><p>אנו ממשיכים לפעול לשיפור הנגישות באופן שוטף.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'מדיה',
				'title' => 'וידאו ואודיו',
				'body'  => '<p>באתר מוטמעים סרטוני וידאו חיצוניים. בשלב זה איננו מבטיחים כתוביות לכל סרטון. אם נתקלתם בתוכן מדיה שאינכם יכולים לצרוך, פנו אלינו בדרכים המפורטות למטה ונספק חלופה — תמלול, סיכום כתוב או שיחה אישית — בהתאם לצורך ובתוך זמן סביר.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'רכז נגישות',
				'title' => 'פנייה בנושא נגישות',
				'body'  => '<p>נתקלתם בקושי בנגישות האתר, או שיש לכם הצעה לשיפור? נשמח לדעת ולתקן. ניתן לפנות לרכז הנגישות של המרכז לטיפול בדיג׳רידו: טלפון 052-4822842, או דרך <a class="tlink" href="/contact/">עמוד יצירת הקשר</a>. נעשה כמיטב יכולתנו לתת מענה בהקדם.</p>',
			),
		),
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'תאריך',
				'title' => 'עדכון ההצהרה',
				'body'  => '<p>הצהרת נגישות זו עודכנה לאחרונה בספטמבר 2026, לאחר סבב בדיקות ותיקונים באתר, ותיבחן מעת לעת בהתאם לשינויים באתר ובדרישות הדין.</p>',
			),
		),
	),
);
