<?php
/**
 * Plugin Name: EA M3 — תוכן זמני צוות 80 (פעם אחת)
 * Description: משלים תוכן placeholder מ־M3-TEXT-PLACEHOLDER-RETURN-TEAM80 (מטריצת קטלוגים, משפטי, EN, Yoast לשירותים, שיטה, בלוג). איפוס: delete_option('ea_m3_team80_placeholder_content_v1').
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'EA_M3_TEAM80_OPTION', 'ea_m3_team80_placeholder_content_v1' );

/**
 * @param string $path Page path e.g. 'faq' or 'learning/lectures'.
 * @return int Post ID or 0.
 */
function ea_m3_team80_page_id( $path ) {
	$p = get_page_by_path( $path, OBJECT, 'page' );
	return ( $p && $p->post_type === 'page' ) ? (int) $p->ID : 0;
}

/**
 * @param int    $post_id Post ID.
 * @param string $html    HTML fragment.
 */
function ea_m3_team80_set_content( $post_id, $html ) {
	if ( $post_id < 1 ) {
		return;
	}
	wp_update_post(
		array(
			'ID'           => $post_id,
			'post_content' => wp_kses_post( $html ),
		)
	);
}

/**
 * @param int    $post_id Post ID.
 * @param string $desc    Meta description.
 */
function ea_m3_team80_set_metadesc( $post_id, $desc ) {
	if ( $post_id < 1 || $desc === '' ) {
		return;
	}
	update_post_meta( $post_id, '_yoast_wpseo_metadesc', wp_strip_all_tags( $desc ) );
}

/**
 * Build FAQ catalog HTML (intro + static instances for staging).
 */
function ea_m3_team80_html_faq_catalog() {
	$intro1 = 'עמוד השאלות הנפוצות מרכז במקום אחד תשובות לשאלות שחוזרות שוב ושוב סביב טיפול בדיג\'רידו, שיעורים, סאונד הילינג, סדנאות והדרך שבה אייל עובד. הרעיון הוא לאפשר קריאה שקטה ומסודרת, וגם לעזור למי שעדיין לא בטוח מה מתאים לו להתחיל מהשאלה הנכונה. אפשר לקרוא לפי סדר, ואפשר פשוט לבחור את הנושא שהכי רלוונטי כרגע.';
	$intro2 = 'השאלות מקובצות לפי נושאים כדי להקל על ההתמצאות: טיפול, לימוד, סאונד, סדנאות וכלים. חלק מהשאלות מופיעות גם בעמודי השירות עצמם, וכאן הן מרוכזות בקטלוג אחד שמאפשר מבט רחב ונוח יותר.';
	$items  = array(
		array( 'טיפול', 'האם טיפול בדיג\'רידו מתאים גם למי שלא ניגן מעולם?', 'כן. אין צורך בניסיון קודם. המפגש הראשון נועד לבדוק יחד איך להיכנס לעבודה עם נשימה, צליל והקשבה בקצב שמתאים לאדם.' ),
		array( 'סאונד הילינג', 'מה קורה במפגש סאונד הילינג?', 'במפגש סאונד הילינג הדגש הוא על הקשבה לצליל ועל החוויה שהוא יוצר בגוף ובמרחב. זהו זמן של עצירה, שהייה והסכמה לתת לצליל לעבוד בלי מאמץ מיוחד.' ),
		array( 'לימוד', 'האם שיעורי דיג\'רידו מתאימים גם למתחילים?', 'בהחלט. אפשר להתחיל מאפס, וללמוד את הכלי יחד עם עבודה נכונה על נשימה, הפקת צליל והיכרות עם הגוף. השיעורים נבנים לפי הרמה והקצב של התלמיד.' ),
		array( 'סדנאות', 'האם הסדנאות מתאימות רק לנגנים?', 'לא בהכרח. יש סדנאות שמתאימות גם למי שמגיע בלי ניסיון, במיוחד כשהמטרה היא מפגש עם תהליך, בנייה, צליל או עבודה קבוצתית.' ),
		array( 'כלים', 'האם אפשר להתייעץ לפני תיקון או רכישת כלי?', 'כן. לפני תיקון, חידוש או בחירה של כלי, אפשר ליצור קשר, להסביר מה יש ברשותכם או מה אתם מחפשים, ולבדוק מה נכון לעשות.' ),
	);
	$html  = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — v1 — 2026-04-06 — צוות 80 — לא לאישור פרסום סופי</em></p>';
	$html .= '<p>' . esc_html( $intro1 ) . '</p><p>' . esc_html( $intro2 ) . '</p>';
	$html .= '<h2>שאלות נפוצות</h2>';
	foreach ( $items as $row ) {
		$html .= '<h3>' . esc_html( $row[1] ) . '</h3>';
		$html .= '<p><strong>' . esc_html( $row[0] ) . '</strong></p>';
		$html .= '<p>' . esc_html( $row[2] ) . '</p>';
	}
	return $html;
}

/**
 * @return string
 */
function ea_m3_team80_html_galleries_catalog() {
	$intro1 = 'עמוד הגלריות מרכז רגעים, תהליכים ועולמות תוכן שליוו את הדרך של אייל לאורך השנים. זה לא רק אוסף תמונות, אלא חלון למרחב העבודה, לספרים, לסדנאות ולחומר שנשאר חי גם מעבר למפגש עצמו. הגלריות כאן מסודרות כך שאפשר לשוטט ביניהן בשקט, ולהכיר עוד שכבות של העשייה דרך העין.';
	$intro2 = 'הגלריות מקובצות לפי מחיצות ברורות, כדי לשמור על סדר בין עולמות שונים של תוכן. כל מחיצה אוספת חומר מסוג אחר, כך שאפשר להיכנס ישירות למה שמעניין, בלי ללכת לאיבוד בתוך ספריית מדיה אחת ארוכה.';
	$secs   = array(
		array( 'מהמרחב ומהדרך', 'גלריה כללית מהסטודיו, מהמפגשים ומהמרחב שבו העבודה מתרחשת בפועל.' ),
		array( 'צבע בכחול וזרוק לים', 'חומרים ויזואליים הקשורים לספר ולעולם היצירה שנבנה סביבו.' ),
		array( 'כושי בלאנטיס', 'גלריה ייעודית לספר, לחומרי המדף ולנראות המלווה אותו.' ),
		array( 'וכתבת', 'גלריה המלווה את הספר ואת חומרי התוכן הקשורים אליו.' ),
	);
	$html   = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — v1 — 2026-04-06 — צוות 80 — לא לאישור פרסום סופי</em></p>';
	$html  .= '<p>' . esc_html( $intro1 ) . '</p><p>' . esc_html( $intro2 ) . '</p>';
	foreach ( $secs as $s ) {
		$html .= '<h3>' . esc_html( $s[0] ) . '</h3><p>' . esc_html( $s[1] ) . '</p>';
	}
	return $html;
}

/**
 * @return string
 */
function ea_m3_team80_html_media_catalog() {
	$intro = 'עמוד ההמלצות והמדיה אוסף קולות של תלמידים, מטופלים, משתתפי סדנאות וחומרי מדיה שקשורים לדרך של אייל. הוא נועד לתת הקשר אנושי לעבודה עצמה, לא כמסך שיווקי צעקני אלא כהזמנה להבין איך המפגש נחווה מבחוץ. לצד העמודים התוכןיים, זהו מקום שמחבר בין הניסיון האישי של אנשים לבין תחומי העבודה השונים.';
	$quotes = array(
		array( 'אנונימי', 'טיפול', 'הגעתי עם הרבה עומס, והמפגש יצר עבורי מרחב לא מוכר של נשימה, שקט ודיוק.' ),
		array( 'אנונימי', 'שיעורים', 'השיעורים חיברו בין נגינה לבין משהו הרבה יותר עמוק, והרגשתי שאני לומד גם את הכלי וגם את עצמי.' ),
		array( 'אנונימי', 'סאונד הילינג', 'מפגש הסאונד היה בשבילי זמן נדיר של עצירה, והצליל נשאר איתי גם הרבה אחרי שהוא נגמר.' ),
		array( 'אנונימי', 'סדנה', 'הייתה בסדנה תחושה של יצירה, משחק ורצינות ביחד, וזה מה שהפך אותה למשהו שנשאר.' ),
	);
	$html   = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — v1 — 2026-04-06 — צוות 80 — לא לאישור פרסום סופי</em></p>';
	$html  .= '<p>' . esc_html( $intro ) . '</p><h2>עדויות</h2>';
	foreach ( $quotes as $q ) {
		$html .= '<blockquote class="ea-testimonial-block"><p>' . esc_html( $q[2] ) . '</p><cite>' . esc_html( $q[0] ) . ' · ' . esc_html( $q[1] ) . '</cite></blockquote>';
	}
	return $html;
}

/**
 * @return string
 */
function ea_m3_team80_html_method() {
	$pillars = array(
		array( 'נשימה', 'הנשימה היא לא רק טכניקה, אלא שער לעבודה פנימית מדויקת, יציבה וקשובה יותר.' ),
		array( 'צליל', 'הצליל אינו קישוט או רקע, אלא כלי עבודה חי שפוגש את הגוף ואת מערכת הקשב באופן ישיר.' ),
		array( 'הקשבה', 'הדרך מתחילה ביכולת להקשיב למה שקורה באמת, בלי למהר לתקן ובלי להעמיס הבטחות.' ),
		array( 'תרגול', 'שינוי עמוק נבנה דרך חוויה מעשית, חזרתיות עדינה ועבודה שמבשילה לאורך זמן.' ),
		array( 'תהליך אישי', 'אין מסלול אחד שמתאים לכולם; לכל אדם יש קצב, כניסה ודרך משלו בתוך השיטה.' ),
	);
	$html    = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — v1 — 2026-04-06 — צוות 80 — לא לאישור פרסום סופי</em></p><ul class="ea-method-pillars">';
	foreach ( $pillars as $row ) {
		$html .= '<li><strong>' . esc_html( $row[0] ) . ':</strong> ' . esc_html( $row[1] ) . '</li>';
	}
	$html .= '</ul>';
	return $html;
}

/**
 * @return void
 */
function ea_m3_team80_placeholder_run() {
	if ( get_option( EA_M3_TEAM80_OPTION, '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() ) {
		return;
	}
	if ( wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_m3_team80_lock' ) ) {
		return;
	}
	set_transient( 'ea_m3_team80_lock', 1, 120 );

	try {
		// קטלוגים.
		ea_m3_team80_set_content( ea_m3_team80_page_id( 'faq' ), ea_m3_team80_html_faq_catalog() );
		ea_m3_team80_set_content( ea_m3_team80_page_id( 'galleries' ), ea_m3_team80_html_galleries_catalog() );
		ea_m3_team80_set_content( ea_m3_team80_page_id( 'media' ), ea_m3_team80_html_media_catalog() );

		// משפטי + EN + הכשרות.
		$legal_priv = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — משפטי — לא לאישור פרסום סופי</em></p><p>המידע בעמוד זה נועד לתת הסבר ראשוני על אופן השימוש באתר, על יצירת קשר ועל אופן הטיפול בפרטים שנמסרים דרך טפסים או ערוצי פנייה. נוסח זה הוא placeholder בלבד, ויש להשלים אותו מול דרישות משפטיות, כלי המדידה בפועל ומנגנון ההסכמה לקוקיז לפני פרסום סופי.</p><p><strong>להשלים לפני פרסום:</strong></p><ul><li>אילו פרטים נאספים בפועל</li><li>אילו שירותי צד ג\' פועלים באתר</li><li>האם מופעלים כלי מדידה, דיוור או רימרקטינג</li><li>פרטי יצירת קשר רשמיים למדיניות</li></ul>';
		ea_m3_team80_set_content( ea_m3_team80_page_id( 'privacy' ), $legal_priv );

		$legal_acc = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — נגישות — לא לאישור פרסום סופי</em></p><p>האתר החדש נבנה מתוך כוונה לאפשר חוויית שימוש ברורה, נגישה ונוחה ככל האפשר, בעברית ובתצוגת מובייל ודסקטופ. נוסח זה הוא placeholder בלבד, ויש להשלים אותו לאחר בדיקה בפועל של הרכיבים, התוספים, הטפסים והמסכים המרכזיים באתר.</p><p><strong>להשלים לפני פרסום:</strong></p><ul><li>תאריך עדכון ההצהרה</li><li>הסדרי נגישות רלוונטיים אם קיימים</li><li>פרטי יצירת קשר לפניות בנושא נגישות</li><li>מגבלות ידועות אם יישארו</li></ul>';
		ea_m3_team80_set_content( ea_m3_team80_page_id( 'accessibility' ), $legal_acc );

		$legal_terms = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — תקנון — לא לאישור פרסום סופי</em></p><p>השימוש באתר, בתכנים ובקישורים החיצוניים כפוף לתנאים שיוגדרו בנוסח הסופי של התקנון. נוסח זה הוא placeholder בלבד, ומטרתו לסמן את הצורך בעמוד תקנון מלא לפני פרסום האתר לציבור.</p><p><strong>להשלים לפני פרסום:</strong></p><ul><li>תנאי שימוש כלליים</li><li>תנאים לקישורים חיצוניים ולרכישה מחוץ לאתר</li><li>זכויות יוצרים ושימוש בתוכן</li><li>תחולת דין ופרטי יצירת קשר</li></ul>';
		ea_m3_team80_set_content( ea_m3_team80_page_id( 'terms' ), $legal_terms );

		$en = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — EN — v1</em></p><h2>Didgeridoo Breath Work with Eyal Amit</h2><p>A quiet introduction page in English for visitors who want to learn about Eyal Amit\'s work with breath, sound and didgeridoo.</p>';
		ea_m3_team80_set_content( ea_m3_team80_page_id( 'en' ), $en );

		$train = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — v1 — צוות 80</em></p><p>עמוד הכשרות למטפלים יעלה בהמשך, וירכז מידע על מסלול עומק למי שמבקש ללמוד את הדרך באופן מובנה ורציני.</p>';
		ea_m3_team80_set_content( ea_m3_team80_page_id( 'learning/therapist-training' ), $train );

		// שיטה + בלוג.
		ea_m3_team80_set_content( ea_m3_team80_page_id( 'method' ), ea_m3_team80_html_method() );
		$blog_intro = '<p class="ea-team80-tag" role="note"><em>PLACEHOLDER — v1 — צוות 80</em></p><p>ארכיון הבלוג מרכז טקסטים, מחשבות, סיפורים וחומרי עומק שנכתבו לאורך השנים סביב דיג\'רידו, נשימה, מסע אישי ויצירה. זהו לא רק מדור כתבות, אלא מקום שמרחיב את ההיכרות עם הדרך של אייל מעבר לעמודי השירות עצמם. אפשר לקרוא כאן לפי עניין, לפי זמן או פשוט לעצור על טקסט שמבקש תשומת לב. עבור מי שמגיע דרך חיפוש, זהו גם שער טוב להבין את רוח האתר ואת השפה שמחברת בין גוף, צליל וחיים.</p>';
		ea_m3_team80_set_content( ea_m3_team80_page_id( 'blog' ), $blog_intro );

		// Yoast metadesc לשירותים.
		ea_m3_team80_set_metadesc( ea_m3_team80_page_id( 'treatment' ), 'טיפול בדיג\'רידו הוא תהליך אישי של עבודה עם נשימה, צליל והקשבה לגוף, בדרך מעשית, רגישה ולא פולשנית.' );
		ea_m3_team80_set_metadesc( ea_m3_team80_page_id( 'lessons' ), 'שיעורי דיג\'רידו עם אייל עמית מחברים בין לימוד נגינה, נשימה מעגלית והיכרות עמוקה עם הגוף והצליל.' );
		ea_m3_team80_set_metadesc( ea_m3_team80_page_id( 'sound-healing' ), 'סאונד הילינג בדיג\'רידו הוא מרחב של הקשבה, צליל ותדר, למי שמבקש לעצור, להתמסר ולהיפגש עם שקט אחר.' );
		ea_m3_team80_set_metadesc( ea_m3_team80_page_id( 'workshops' ), 'סדנאות דיג\'רידו מאפשרות מפגש קבוצתי עם נשימה, צליל, בנייה או תרגול, באווירה חווייתית ומעמיקה.' );
		ea_m3_team80_set_metadesc( ea_m3_team80_page_id( 'instruments' ), 'כלים בעבודת יד ואביזרים לדיג\'רידו, מתוך היכרות מעשית ארוכת שנים עם נגינה, בנייה ואיכות צליל.' );
		ea_m3_team80_set_metadesc( ea_m3_team80_page_id( 'repair' ), 'תיקון וחידוש דיג\'רידו וכלים נלווים, מתוך הבנה של חומר, תהודה ושמירה על אופי הכלי לאורך זמן.' );
		ea_m3_team80_set_metadesc( ea_m3_team80_page_id( 'learning/lectures' ), 'הרצאות של אייל עמית פותחות שער לעולם הדיג\'רידו, הנשימה, הצליל והסיפורים שמלווים את הדרך האישית והמקצועית.' );

		update_option( EA_M3_TEAM80_OPTION, 'done' );
	} finally {
		delete_transient( 'ea_m3_team80_lock' );
	}
}

add_action( 'init', 'ea_m3_team80_placeholder_run', 30 );
