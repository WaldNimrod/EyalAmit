<?php
/**
 * Block: faq-list — WP-W2-02 full FAQ accordion with category filter.
 * Content source: docs/project/eyal-ceo-submissions-and-responses/from-eyal/תוכן לאתר 25.5.26/דף FAQ/FAQ FINAL.md
 *
 * Optional arg (WP-W2-04, passed via get_template_part $args):
 *   $args['ea_faq_only_category'] — when set to a category slug, the block
 *   renders VIEW-ONLY: only that category's questions, no filter chips/select,
 *   no category heading. Default /faq behavior (full filterable list) is
 *   unchanged when the arg is absent. The single FAQ dataset is NOT duplicated.
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

$ea_faq_only_category = ( isset( $args['ea_faq_only_category'] ) && '' !== $args['ea_faq_only_category'] )
	? (string) $args['ea_faq_only_category']
	: '';

$faq_categories = array(
	'treatment'    => "טיפול בדיג'רידו",
	'lessons'      => "שיעורי נגינה בדיג'רידו",
	'sound-healing' => "סאונד הילינג בדיג'רידו",
	'method'       => 'השיטה — cbDIDG',
	'general'      => 'שאלות כלליות',
);

$faq_data = array(

	/* ─── TREATMENT ─── */
	array(
		'category' => 'treatment',
		'q'        => "מה זה בעצם טיפול בדיג'רידו?",
		'a'        => "<p>טיפול בדיג'רידו הוא תהליך אישי שבו עובדים באופן אקטיבי עם הנשימה, באמצעות נגינה בדיג'רידו ככלי עבודה.</p><p>הדיג'רידו לא עומד במרכז כנגינה או כמטרה, אלא משמש ככלי שמאפשר להבין, להרגיש ולשנות את דפוסי הנשימה היומיומית.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => 'איך נראה מפגש טיפולי?',
		'a'        => "<p>המפגש הוא אישי, אחד על אחד.</p><p>במהלך המפגש לומדים בהדרגה איך לעבוד עם הנשימה דרך הכלי, תוך תשומת לב לפרטים קטנים — אופן הנשיפה, תנועת הגוף, מתח, הרגלים קיימים ועוד.</p><p>זה לא שיעור נגינה רגיל, אלא תהליך שמכוון להשפעה על הנשימה עצמה.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => 'האם צריך ניסיון קודם בנגינה?',
		'a'        => "<p>לא. אין צורך בניסיון קודם, לא בנגינה ולא בעבודה עם נשימה.</p><p>העבודה מתחילה מהבסיס, ומותאמת לכל אדם לפי הקצב והיכולת שלו.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => "למי טיפול בדיג'רידו יכול להתאים?",
		'a'        => "<p>אנשים מגיעים ממגוון סיבות, למשל:</p><ul><li>תחושה של עומס או סטרס מתמשך</li><li>קושי בנשימה או הרגלי נשימה לא מודעים</li><li>נחירות או הפרעות שינה</li><li>רצון לשפר את הקשר לגוף ולנשימה</li></ul><p>אבל לא חייבת להיות בעיה מוגדרת — יש גם מי שמגיעים מתוך סקרנות.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => "מה ההבדל בין טיפול בדיג'רידו לסאונד הילינג?",
		'a'        => "<p>בטיפול בדיג'רידו יש עבודה אקטיבית — המשתתף לומד לנגן ועובד בפועל עם הנשימה שלו.</p><p>לעומת זאת, בסאונד הילינג החוויה היא פאסיבית, ובשיעורי נגינה הדגש הוא על לימוד הכלי.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => 'כמה זמן לוקח לראות שינוי?',
		'a'        => "<p>זה לא תהליך של מפגש אחד. העבודה מבוססת על תרגול והתמדה, וההשפעה נבנית לאורך זמן.</p><p>רבים מדווחים על שינוי כבר בשלבים הראשונים, אבל המשמעות העמוקה מגיעה דרך תהליך.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => 'האם זה טיפול רפואי?',
		'a'        => "<p>לא. העבודה אינה תחליף לטיפול רפואי, ואינה מוצגת ככזו.</p><p>עם זאת, אנשים רבים מגיעים מתוך מצבים שונים שקשורים לנשימה או לסטרס, ועובדים עליהם דרך הנשימה.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => 'מה הקשר בין הנגינה לנשימה היומיומית?',
		'a'        => "<p>זו נקודה מרכזית. הנשימה בזמן נגינה בדיג'רידו היא כלי ללמידה, אבל המטרה היא להשפיע על הנשימה מחוץ לנגינה — ביומיום, בשגרה, ובמצבים שונים.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => 'כמה זמן נמשך התהליך?',
		'a'        => "<p>אין זמן קבוע. זה תהליך אישי שיכול להימשך תקופה קצרה או ארוכה יותר בהתאם לצורך.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => 'האם צריך לתרגל גם בין המפגשים?',
		'a'        => "<p>כן. התרגול בין המפגשים הוא חלק חשוב מהתהליך, ושם הרבה מהשינוי מתבסס.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => 'מה קורה במפגש הראשון?',
		'a'        => "<p>המפגש הראשון כולל היכרות ואבחון. ניתן להתחיל ב<a href=\"/contact\">שיחת היכרות</a>.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => 'האם זה מתאים גם למי שלא "מחובר לעולם הזה"?',
		'a'        => "<p>כן. אין צורך ברקע, אמונה או גישה מסוימת. העבודה היא פשוטה וישירה, ומתאימה למגוון רחב של אנשים.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => "במה זה שונה מטיפולי נשימה אחרים?",
		'a'        => "<p>הייחוד הוא בשילוב בין כלי פיזי, צליל ותהליך למידה הדרגתי, שבו האדם עצמו לומד לעבוד עם הנשימה שלו.</p>",
	),
	array(
		'category' => 'treatment',
		'q'        => "למי זה פחות מתאים?",
		'a'        => "<p>העבודה מתאימה לרוב האנשים, אך יש מצבים שבהם כדאי להתייעץ מראש:</p><ul><li>נשים בהריון</li><li>מצבים נפשיים מורכבים</li><li>מצבים רפואיים חריגים</li></ul><p>העבודה מתאימה בדרך כלל מגיל 17 ומעלה.</p>",
	),

	/* ─── LESSONS ─── */
	array(
		'category' => 'lessons',
		'q'        => 'האם אפשר ללמוד לבד מיוטיוב?',
		'a'        => "<p>אפשר, אך ללא משוב טעויות מתקבעות, התסכול גדל ורבים פורשים. ליווי אישי מאפשר תיקון בזמן אמת והתקדמות מדויקת.</p>",
	),
	array(
		'category' => 'lessons',
		'q'        => 'האם עדיף ללמוד בקבוצה או פרטי?',
		'a'        => "<p>לימוד בקבוצה מתקדם בקצב אחיד ולא מאפשר התאמה אישית. בשיעור פרטי ההתקדמות מהירה ומדויקת יותר בעשרות אחוזים.</p>",
	),
	array(
		'category' => 'lessons',
		'q'        => 'האם זה מתאים למי שניסה בעבר ולא הצליח?',
		'a'        => "<p>כן. למידה מסודרת עם ליווי אישי מאפשרת התקדמות אמיתית.</p>",
	),
	array(
		'category' => 'lessons',
		'q'        => 'האם אפשר ללמוד על כיסא?',
		'a'        => "<p>כן. ניתן ללמוד במגוון מנחים בהתאם לנוחות הגוף.</p>",
	),
	array(
		'category' => 'lessons',
		'q'        => 'האם יש מגבלת גיל?',
		'a'        => "<p>השיעורים מיועדים מגיל 17 ומעלה.</p>",
	),
	array(
		'category' => 'lessons',
		'q'        => 'האם אפשר בזמן הריון?',
		'a'        => "<p>לא מומלץ.</p>",
	),
	array(
		'category' => 'lessons',
		'q'        => 'יש לי בעיה בריאותית',
		'a'        => "<p>שיעורים אינם טיפוליים. פנו למסלול של <a href=\"/treatment\">טיפול בדיג'רידו</a>.</p>",
	),
	array(
		'category' => 'lessons',
		'q'        => 'האם יש שיעור ניסיון?',
		'a'        => "<p>כן. ניתן להגיע ללא התחייבות.</p>",
	),

	/* ─── SOUND HEALING ─── */
	array(
		'category' => 'sound-healing',
		'q'        => 'האם צריך ניסיון קודם או היכרות עם סאונד הילינג?',
		'a'        => "<p>לא. המפגש מתאים גם למי שמגיע בפעם הראשונה, מתוך סקרנות או רצון להיחשף לחוויה.</p>",
	),
	array(
		'category' => 'sound-healing',
		'q'        => "מה ההבדל בין סאונד הילינג לטיפול בדיג'רידו?",
		'a'        => "<p>בסאונד הילינג מדובר במפגש פאסיבי שבו מקשיבים לצליל ונמצאים בתוך המרחב שנוצר.</p><p>בטיפול בדיג'רידו העבודה היא אקטיבית ומבוססת על תהליך אישי עם הנשימה.</p>",
	),
	array(
		'category' => 'sound-healing',
		'q'        => 'האם יש מגע במהלך המפגש?',
		'a'        => "<p>ברוב המקרים העבודה נעשית ללא מגע, דרך צליל ותדר בלבד. במקרים מסוימים עשוי להיות מגע עדין ותומך.</p>",
	),
	array(
		'category' => 'sound-healing',
		'q'        => 'האם עולים רגשות או זיכרונות במהלך המפגש?',
		'a'        => "<p>לעיתים כן. זה חלק טבעי מהתהליך, והמפגש מתקיים בתוך מרחב מוחזק ובטוח שמאפשר לזה להתרחש בצורה מדויקת.</p>",
	),
	array(
		'category' => 'sound-healing',
		'q'        => 'מה אם קשה לי "להירגע" או לשחרר?',
		'a'        => "<p>אין ציפייה להגיע למצב מסוים. גם אם המחשבות פעילות או הגוף לא נרגע מיד — הצליל עדיין פועל, והתהליך מתרחש בקצב האישי שלך.</p>",
	),
	array(
		'category' => 'sound-healing',
		'q'        => 'האם זה מתאים גם כמתנה או כחוויה זוגית?',
		'a'        => "<p>כן. ניתן להגיע למפגש כיחיד או כזוג, והוא מתאים גם למי שמחפש דרך אחרת לציין רגע משמעותי.</p>",
	),
	array(
		'category' => 'sound-healing',
		'q'        => 'כמה זמן נמשך המפגש?',
		'a'        => "<p>המפגש נמשך בדרך כלל כשעתיים.</p>",
	),
	array(
		'category' => 'sound-healing',
		'q'        => 'האם זה מתאים לכל אחד?',
		'a'        => "<p>המפגש אינו מיועד למצבים נפשיים מורכבים או לא יציבים, ואינו מתאים לנשים בהריון. אם יש ספק, מומלץ להתייעץ מראש דרך <a href=\"/contact\">שיחת היכרות</a>.</p>",
	),

	/* ─── METHOD ─── */
	array(
		'category' => 'method',
		'q'        => "מה ההבדל בין שיטת cbDIDG לבין שיטות נשימה אחרות כמו ריברסינג או בוטייקו?",
		'a'        => "<p>בשיטת <a href=\"/method\">cbDIDG</a> העבודה מתבצעת דרך נגינה בדיג'רידו, כך שהנשימה הופכת לפעולה מוחשית עם משוב מיידי של צליל. הנגינה יוצרת עניין, מיקוד ורצף תרגול, ומאפשרת להתמיד לאורך זמן.</p>",
	),
	array(
		'category' => 'method',
		'q'        => "מה ההבדל בין נשימה מעגלית בדיג'רידו לבין נשימה מעגלית בריברסינג?",
		'a'        => "<p>למרות השם הדומה, מדובר בשתי גישות שונות לחלוטין.</p><p>נשימה מעגלית בדיג'רידו היא טכניקה פיזית שמאפשרת הפקת צליל רציף.</p><p>לעומת זאת, בריברסינג מדובר בתהליך נשימתי שמטרתו לעורר חוויה רגשית או תודעתית.</p>",
	),
	array(
		'category' => 'method',
		'q'        => "האם צריך לדעת לנגן בדיג'רידו כדי להתחיל?",
		'a'        => "<p>לא. הלימוד מתחיל מהבסיס.</p>",
	),
	array(
		'category' => 'method',
		'q'        => 'כמה זמן לוקח לראות שינוי?',
		'a'        => "<p>זה תהליך הדרגתי שמבוסס על תרגול והתמדה.</p>",
	),
	array(
		'category' => 'method',
		'q'        => "האם השיטה יכולה לעזור לנחירות או דום נשימה?",
		'a'        => "<p>יש מקרים שבהם כן, אך כל מקרה נבחן באופן אישי. <a href=\"https://www.bmj.com/content/332/7536/266\" target=\"_blank\" rel=\"noopener\">לקריאה על המחקר ב‑BMJ</a>.</p>",
	),
	array(
		'category' => 'method',
		'q'        => 'למי זה לא מתאים?',
		'a'        => "<p>לאנשים שמחפשים פתרון מהיר ללא תרגול, לנשים בהריון ולמצבים מורכבים מסוימים.</p>",
	),

	/* ─── GENERAL ─── */
	array(
		'category' => 'general',
		'q'        => 'איפה מתקיימים המפגשים?',
		'a'        => "<p>המפגשים מתקיימים בסטודיו בפרדס חנה, בסביבה שקטה ונעימה שמאפשרת עבודה ממוקדת עם נשימה וצליל.</p>",
	),
	array(
		'category' => 'general',
		'q'        => 'מה הכתובת של המרכז?',
		'a'        => "<p>המרכז ממוקם בפרדס חנה. כתובת מדויקת ניתנת לאחר יצירת קשר ותיאום מפגש. <a href=\"/contact\">לשיחת היכרות</a>.</p>",
	),
	array(
		'category' => 'general',
		'q'        => 'מה שעות הפעילות?',
		'a'        => "<p>הפעילות מתקיימת בתיאום מראש בלבד. <a href=\"/contact\">לתיאום שיחת היכרות</a>.</p>",
	),
	array(
		'category' => 'general',
		'q'        => 'איך קובעים מפגש?',
		'a'        => "<p>ניתן ליצור קשר דרך <a href=\"/contact\">שיחת היכרות</a> ולתאם זמן שמתאים.</p>",
	),
	array(
		'category' => 'general',
		'q'        => 'כמה זה עולה?',
		'a'        => "<p>המחירים משתנים בהתאם לסוג המפגש — <a href=\"/treatment\">טיפול בדיג'רידו</a>, <a href=\"/lessons\">שיעורי נגינה</a> או <a href=\"/sound-healing\">סאונד הילינג</a>. הדרך הפשוטה היא לפנות ולקבל הסבר מדויק.</p>",
	),
	array(
		'category' => 'general',
		'q'        => 'כמה זמן נמשך כל מפגש?',
		'a'        => "<ul><li>טיפול בדיג'רידו — לרוב כ‑60 דקות (מפגש ראשון ארוך יותר)</li><li>שיעורי נגינה בדיג'רידו — כ‑60 דקות</li><li>סאונד הילינג בדיג'רידו — כ‑שעתיים</li></ul>",
	),
	array(
		'category' => 'general',
		'q'        => "האם אפשר לרכוש דיג'רידו?",
		'a'        => "<p>כן. יש אפשרות לרכוש כלים שנבנים בעבודת יד על ידי אייל עמית, בהתאמה אישית. לפרטים — <a href=\"/contact\">צרו קשר</a>.</p>",
	),
	array(
		'category' => 'general',
		'q'        => "האם יש גם אביזרים נלווים?",
		'a'        => "<p>כן. ניתן למצוא גם אביזרים משלימים לנגינה ולתחזוקה. לפרטים — <a href=\"/contact\">צרו קשר</a>.</p>",
	),
	array(
		'category' => 'general',
		'q'        => "האם ניתן לתקן דיג'רידו?",
		'a'        => "<p>כן. יש אפשרות לתיקון ושיקום כלי דיג'רידו. לפרטים — <a href=\"/contact\">צרו קשר</a>.</p>",
	),
	array(
		'category' => 'general',
		'q'        => 'האם יש סדנאות קבוצתיות?',
		'a'        => "<p>לעיתים מתקיימות סדנאות חד פעמיות, אך עיקר העבודה נעשית באופן אישי.</p>",
	),
	array(
		'category' => 'general',
		'q'        => 'מי הוא מוקש ומה הקשר שלו לאייל עמית?',
		'a'        => "<p>מוקש היה מאסטר לדיג'רידו, יוגי מזרם הבהקטי שחי ברישיקש הודו, והקדיש את חייו להפצת הדיג'רידו ומלאכת בנייתו בעולם.</p><p>אייל עמית למד אצלו לאורך שנים והיה מתלמידיו הקרובים מאז שנת 2000. קשר זה מהווה חלק משמעותי מהבסיס שעליו נבנתה <a href=\"/method\">שיטת cbDIDG</a>.</p>",
	),
	array(
		'category' => 'general',
		'q'        => 'האם יש קורס להכשרת מטפלים?',
		'a'        => "<p>כן. קיים קורס הכשרה למטפלים בשיטת cbDIDG, המיועד למי שמעוניין להעמיק בעבודה עם נשימה ולהפוך אותה לכלי מקצועי. לפרטים — <a href=\"/contact\">צרו קשר</a>.</p>",
	),
	array(
		'category' => 'general',
		'q'        => 'האם יש תוכן נוסף שאפשר לקרוא?',
		'a'        => "<p>כן. ניתן למצוא מאמרים, הסברים ותכנים נוספים ב<a href=\"/blog\">בלוג</a>.</p>",
	),
	array(
		'category' => 'general',
		'q'        => 'האם אייל עמית כתב ספרים?',
		'a'        => "<p>כן. אייל עמית כתב והוציא לאור 3 ספרים. לפרטים — <a href=\"/muzza\">מוזה הוצאה לאור</a>.</p>",
	),
);
?>
<?php if ( '' !== $ea_faq_only_category ) :
	// WP-W2-04 — view-only single-category render (no chips/select/JS, no heading).
	$ea_only_items = array_filter(
		$faq_data,
		static function ( $item ) use ( $ea_faq_only_category ) {
			return $item['category'] === $ea_faq_only_category;
		}
	);
	?>
	<div class="ea-faq-list ea-faq-list--view-only" data-block="faq-list" data-faq-category="<?php echo esc_attr( $ea_faq_only_category ); ?>">
		<div class="ea-faq-category" data-category="<?php echo esc_attr( $ea_faq_only_category ); ?>">
			<?php foreach ( $ea_only_items as $item ) : ?>
				<details class="ea-faq-item ea-entrance" data-category="<?php echo esc_attr( $item['category'] ); ?>">
					<summary class="ea-faq-item__question"><?php echo esc_html( $item['q'] ); ?></summary>
					<div class="ea-faq-item__answer"><?php echo wp_kses_post( $item['a'] ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
	<?php return; endif; ?>
<section class="ea-faq-list" data-block="faq-list" aria-label="<?php esc_attr_e( 'שאלות נפוצות', 'ea-eyalamit' ); ?>">
	<div class="ea-faq-list__inner">

		<div class="ea-faq-list__filter" role="search" aria-label="<?php esc_attr_e( 'סינון שאלות', 'ea-eyalamit' ); ?>">
			<label for="ea-faq-cat" class="ea-faq-list__filter-label">
				<?php esc_html_e( 'נושא:', 'ea-eyalamit' ); ?>
			</label>
			<select id="ea-faq-cat" class="ea-faq-list__filter-select" aria-label="<?php esc_attr_e( 'בחר נושא', 'ea-eyalamit' ); ?>">
				<option value="all"><?php esc_html_e( 'הכל', 'ea-eyalamit' ); ?></option>
				<?php foreach ( $faq_categories as $slug => $label ) : ?>
					<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<?php foreach ( $faq_categories as $cat_slug => $cat_label ) :
			$cat_items = array_filter(
				$faq_data,
				static function ( $item ) use ( $cat_slug ) {
					return $item['category'] === $cat_slug;
				}
			);
			if ( empty( $cat_items ) ) {
				continue;
			}
			?>
			<div class="ea-faq-category" data-category="<?php echo esc_attr( $cat_slug ); ?>">
				<h2 class="ea-faq-category__heading"><?php echo esc_html( $cat_label ); ?></h2>
				<?php foreach ( $cat_items as $item ) : ?>
					<details
						class="ea-faq-item ea-entrance"
						data-category="<?php echo esc_attr( $item['category'] ); ?>"
					>
						<summary class="ea-faq-item__question">
							<?php echo esc_html( $item['q'] ); ?>
						</summary>
						<div class="ea-faq-item__answer">
							<?php echo wp_kses_post( $item['a'] ); ?>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>

	</div>
</section>
