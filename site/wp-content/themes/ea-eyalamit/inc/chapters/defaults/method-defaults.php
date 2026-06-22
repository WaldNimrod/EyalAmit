<?php
/**
 * Chapters /method/ (השיטה) — seeded content defaults. Content template-mother.
 * Sourced from the השיטה-פרקים mockup; .html links rewritten to real routes;
 * brand «סטודיו נשימה מעגלית» not used (footer carries the canonical NAP brand).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	/* phero (media hero) */
	'phero_chap'      => 'שיטה ייחודית · מאז 1999',
	'phero_title'     => 'שיטת cbDIDG — עבודה עם <em>הנשימה</em> דרך הדיג׳רידו',
	'phero_sub'       => 'שיטה לעבודה עם הנשימה באמצעות תרגול אקטיבי בדיג׳רידו, שפותחה על ידי אייל עמית לאורך שנים של חקירה, תרגול וליווי אישי.',
	'phero_media'     => 'assets/images/chapters/eyal-window.jpg',
	'phero_media_alt' => 'אייל עמית מנגן בדיג׳רידו מול קיר הקשתות בסטודיו',
	'phero_cta_label' => 'איך בנויה השיטה ↓',
	'phero_cta_url'   => '#how',

	/* split — מהי השיטה */
	'split_chap'  => 'מהי השיטה',
	'split_title' => 'גישה סדורה לנשימה',
	'split_body'  => '<p>השיטה נבנתה מתוך ניסיון מעשי מצטבר, ובהשפעת הלימוד והחניכה שקיבל אייל כתלמיד קרוב של המאסטר לדיג׳רידו <a class="tlink" href="/eyal-amit/mokesh-dahiman/">מוקש דהימן</a>, החל משנת 1999.</p><p>היא משלבת תרגול אקטיבי, הקשבה ועבודה מדויקת עם הגוף — ומאפשרת להטמיע נשימה מעגלית בצורה הדרגתית, ברורה ונגישה.</p>',
	'split_image' => 'assets/images/chapters/eyal-studio-play.jpg',
	'split_alt'   => 'אייל עמית מתרגל נשימה דרך הדיג׳רידו',

	/* mag-spread — מבנה (איך בנויה השיטה) */
	'mag_chap'    => 'מבנה',
	'mag_title'   => 'איך בנויה השיטה — ארבעה שלבים',
	'mag_image'   => 'assets/images/chapters/eyal-studio-play.jpg',
	'mag_alt'     => 'אייל עמית מתרגל נשימה דרך הדיג׳רידו',
	'mag_cap_b'   => 'שיטת cbDIDG',
	'mag_cap_sub' => 'תרגול אקטיבי · פרדס חנה',
	'mag_items'   => array(
		array( 'title' => 'אבחון והיכרות', 'text' => 'היכרות ואבחון ראשוני של דפוסי הנשימה, להבנת נקודת המוצא.' ),
		array( 'title' => 'תרגול ולמידה', 'text' => 'עבודה מעשית עם הדיג׳רידו — הפקת צליל ועבודה ישירה עם הנשימה.' ),
		array( 'title' => 'התבססות והטמעה', 'text' => 'העבודה הופכת מדויקת ויציבה; עקרונות הנשימה מלווים גם מחוץ למפגש.' ),
		array( 'title' => 'עומק ומצב פנימי', 'text' => 'שהייה ברצף נשימתי יציב — ריכוז, שקט וזרימה דרך הנגינה עצמה.' ),
	),

	/* lead — ייחוד */
	'uniq_chap'  => 'ייחוד',
	'uniq_title' => 'מה מייחד את cbDIDG',
	'uniq_lead'  => 'השיטה מציבה את הנשימה במרכז, ומשתמשת בדיג׳רידו ככלי תרגול חי ומעשי. הנשימה משמשת לא רק כאמצעי תרגול, אלא כנקודת גישה להבנה עמוקה יותר של הגוף והתגובה הפנימית.',

	/* bleed pullquote */
	'bleed_image'  => 'assets/images/chapters/didg-spiral-detail.jpg',
	'bleed_alt'    => 'ספירלת cbDIDG חרוטה בקצה הדיג׳רידו',
	'bleed_quote'  => '״זה לא שיעור נגינה רגיל, ולא רק למידה תיאורטית — זה מפגש שבו לומדים לנשום, דרך חוויה ישירה של הגוף והצליל.״',
	'bleed_attrib' => 'אייל עמית · cbDIDG',

	/* reveals — למי מתאים */
	'whom_chap'  => 'למי מתאים',
	'whom_title' => 'למי השיטה מתאימה',
	'whom_items' => array(
		array( 'image' => 'assets/images/chapters/eyal-bright.jpg',     'title' => 'סטרס כרוני ועומס', 'more' => 'למי שהנשימה שלו הפכה שטחית או לא יציבה תחת עומס יומיומי.' ),
		array( 'image' => 'assets/images/chapters/breath-practice.jpg', 'title' => 'נחירות ודום נשימה בשינה', 'more' => 'עבודה על שליטה, ויסות ויציבות של מערכת הנשימה.' ),
		array( 'image' => 'assets/images/chapters/eyal-window.jpg',     'title' => 'מתח, חרדה וויסות רגשי', 'more' => 'חיזוק היכולת להירגע, להתאזן ולהגיב בצורה יציבה יותר.' ),
		array( 'image' => 'assets/images/chapters/eyal-close.jpg',      'title' => 'מי שמתקשה בתרגול שקט', 'more' => 'הדיג׳רידו מאפשר להישאר בתנועה ובפעולה, ובתוך כך להגיע לשקט.' ),
	),

	/* cta */
	'cta_title' => 'להתחיל לעבוד עם הנשימה שלך',
	'cta_body'  => 'אם משהו ממה שקראת כאן דיבר אליך, יכול להיות שזה הזמן להתחיל תהליך אישי — בליווי, בקצב מותאם, ומתוך הקשבה למה שנכון עבורך.',
	'cta_label' => 'לתיאום שיחת היכרות',
	'cta_url'   => '/contact/',
);
