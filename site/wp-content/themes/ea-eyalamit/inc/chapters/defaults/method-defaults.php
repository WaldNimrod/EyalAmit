<?php
/**
 * Chapters /method/ (השיטה) — seeded content defaults. Content template-mother.
 * Structure/media/layout sourced from the השיטה-פרקים mockup; .html links rewritten
 * to real routes. TEXT replaced verbatim from the approved source (method.md).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	/* phero (media hero) */
	'phero_chap'      => "⟨טקסט להשלמה ע״י אייל⟩",
	'phero_title'     => 'שיטת <em>cbDIDG</em> של אייל עמית',
	'phero_sub'       => "שיטה לעבודה עם הנשימה באמצעות דיג'רידו, המבוססת על תרגול עצמי דרך הכלי בליווי אישי. הדיג'רידו אינו המטרה - הוא הכלי שדרכו לומדים לעבוד עם הנשימה היומיומית, לחזק, לווסת ולהחזיר עליה את השליטה.",
	'phero_media'     => 'assets/images/chapters/eyal-window.jpg',
	'phero_media_alt' => 'אייל עמית מנגן בדיג׳רידו מול קיר הקשתות בסטודיו',
	'phero_cta_label' => "⟨טקסט להשלמה ע״י אייל⟩",
	'phero_cta_url'   => '#how',

	/* split — מהי השיטה */
	'split_chap'  => "⟨טקסט להשלמה ע״י אייל⟩",
	'split_title' => 'מהי שיטת cbDIDG',
	'split_body'  => '<p>שיטת cbDIDG היא שיטה לעבודה עם הנשימה, המתבצעת דרך נגינה בדיג\'רידו וליווי אישי, כחלק מתהליך של <a class="tlink" href="/treatment/">טיפול בדיג\'רידו</a> או במסגרת של <a class="tlink" href="/lessons/">שיעורי נגינה בדיג\'רידו</a>.</p><p>העבודה אינה מתמקדת רק בלימוד נגינה או בטכניקה, אלא בשיפור דפוסי הנשימה היומיומיים.</p><p>דרך הכלי, התרגול וההקשבה למה שקורה בגוף, נבנית בהדרגה שליטה, יציבות ויכולת ויסות של מערכת הנשימה.</p>',
	'split_image' => 'assets/images/chapters/eyal-studio-play.jpg',
	'split_alt'   => 'אייל עמית מתרגל נשימה דרך הדיג׳רידו',

	/* mag-spread — מבנה (איך בנויה השיטה) */
	'mag_chap'    => "⟨טקסט להשלמה ע״י אייל⟩",
	'mag_title'   => 'איך בנויה השיטה',
	'mag_image'   => 'assets/images/chapters/eyal-studio-play.jpg',
	'mag_alt'     => 'אייל עמית מתרגל נשימה דרך הדיג׳רידו',
	'mag_cap_b'   => 'שיטת cbDIDG',
	'mag_cap_sub' => "⟨טקסט להשלמה ע״י אייל⟩",
	'mag_items'   => array(
		array( 'title' => "⟨טקסט להשלמה ע״י אייל⟩", 'text' => "שיטת cbDIDG בנויה כתהליך הדרגתי, שבו העבודה עם הנשימה מתפתחת דרך שילוב בין תרגול, הקשבה וליווי אישי." ),
		array( 'title' => "⟨טקסט להשלמה ע״י אייל⟩", 'text' => "בתחילת הדרך מתמקדים בהיכרות עם הכלי ועם עקרונות העבודה עם הנשימה, דרך תרגול בסיסי והבנה של מה שקורה בגוף בזמן נשימה." ),
		array( 'title' => "⟨טקסט להשלמה ע״י אייל⟩", 'text' => "בהמשך, העבודה הופכת מדויקת יותר - דרך תרגול ממוקד, פיתוח שליטה וקואורדינציה בין שאיפה לנשיפה." ),
		array( 'title' => "⟨טקסט להשלמה ע״י אייל⟩", 'text' => "הקצב והעומק משתנים מאדם לאדם, בהתאם לנקודת הפתיחה ולמטרות התהליך." ),
	),

	/* lead — ייחוד */
	'uniq_chap'  => "⟨טקסט להשלמה ע״י אייל⟩",
	'uniq_title' => 'מה מייחד את שיטת cbDIDG',
	'uniq_lead'  => "שיטת cbDIDG אינה מתמקדת רק בנגינה או בטכניקות הנשימה המעגלית בזמן התרגול. מדובר בשיטה סדורה ללימוד והטמעה של שליטה בנשימה, המבוססת על עבודה אישית, תרגול מותאם וליווי לאורך זמן.",

	/* bleed pullquote */
	'bleed_image'  => 'assets/images/chapters/didg-spiral-detail.jpg',
	'bleed_alt'    => 'ספירלת cbDIDG חרוטה בקצה הדיג׳רידו',
	'bleed_quote'  => "״הדיג'רידו אינו המטרה - הוא הכלי שדרכו לומדים לעבוד עם הנשימה היומיומית, לחזק, לווסת ולהחזיר עליה את השליטה.״",
	'bleed_attrib' => 'אייל עמית · cbDIDG',

	/* reveals — למי מתאים */
	'whom_chap'  => "⟨טקסט להשלמה ע״י אייל⟩",
	'whom_title' => 'למי השיטה מתאימה',
	'whom_items' => array(
		array( 'image' => 'assets/images/chapters/eyal-bright.jpg',     'title' => "⟨טקסט להשלמה ע״י אייל⟩", 'more' => "השיטה מתאימה לאנשים שמרגישים שהנשימה שלהם אינה יציבה או אינה משרתת אותם כפי שהייתה יכולה." ),
		array( 'image' => 'assets/images/chapters/breath-practice.jpg', 'title' => "⟨טקסט להשלמה ע״י אייל⟩", 'more' => "לאנשים שחווים עומס רגשי או מחשבתי, מתח בגוף או קושי לווסת את עצמם לאורך היום." ),
		array( 'image' => 'assets/images/chapters/eyal-window.jpg',     'title' => "⟨טקסט להשלמה ע״י אייל⟩", 'more' => "לאנשים שמתמודדים עם סימפטומים הקשורים בנשימה, כמו נחירות, דום נשימה בשינה, עייפות כרונית או תחושת חוסר אוויר." ),
		array( 'image' => 'assets/images/chapters/eyal-close.jpg',      'title' => "⟨טקסט להשלמה ע״י אייל⟩", 'more' => "השיטה מתאימה למי שמוכן לקחת חלק פעיל בעבודה עם הנשימה שלו, ולהתמסר לתרגול לאורך זמן." ),
	),

	/* cta */
	'cta_title' => 'אם הגעתם עד לכאן, כנראה שמשהו בדרך הזו נוגע בכם.',
	'cta_body'  => 'שיחת היכרות מאפשרת להבין יחד האם השיטה מתאימה לכם, ולראות איך ניתן להתחיל תהליך אישי שמתאים בדיוק לכם.',
	'cta_label' => 'לתיאום שיחת היכרות',
	'cta_url'   => '/contact/',
);
