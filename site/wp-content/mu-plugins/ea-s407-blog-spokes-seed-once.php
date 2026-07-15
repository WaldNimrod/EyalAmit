<?php
/**
 * Plugin Name: EA S4-07 — Blog spokes seed (once, DRAFT only)
 * Description: WP-S4-07 §4 (BLOG-01..04). Idempotent seed of 4 hub-and-spoke blog
 *   posts (post_type 'post', matching the live blog route — is_singular('post') in
 *   inc/chapters/chapters-routing.php). Bodies are structured from the
 *   draft_or_outline OUTLINES in hub/data/content-proposals.json (BLOG-01..04) —
 *   these are section-label outlines, not full verbatim prose in the source, so
 *   the connective sentences inside each section are this seed's own drafting,
 *   written to carry every fact/claim the outline specifies. AC-7: every post is
 *   seeded as post_status => 'draft' — 0 published. Reset:
 *   delete_option('ea_s407_blog_spokes_seed_v1').
 *
 *   BLOG-03 note: an existing legacy post covering the same rebirthing-vs-
 *   circular-breathing topic was found in site/exports/blog-legacy.wxr
 *   (post_name "ריברסינג-נשימה-מעגלית-דיגרידו") — the spec (§4) frames BLOG-03 as
 *   an upgrade of that existing post, not a new one. This script creates a NEW
 *   draft instead (idempotent-seed mechanism only knows how to insert, not
 *   locate-and-merge into arbitrary legacy content) — team_100/team_10 needs to
 *   reconcile the two before publishing (merge, or retire one).
 *
 *   Model: idempotency-by-meta-key, same pattern as ea-faq-seed-once.php
 *   (_ea_faq_seed_key) — each spoke is looked up by a stable `_ea_s407_blog_seed_key`
 *   post meta value so re-running never creates duplicates and never touches a
 *   post that was hand-edited since.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Standard medical disclaimer paragraph (verbatim, matches
 * inc/chapters/defaults/treatment-defaults.php "דיסקליימר" section) — AC-11.
 *
 * @return string
 */
function ea_s407_blog_disclaimer() {
	return '<p>המידע באתר זה אינו מהווה ייעוץ רפואי, אבחון או טיפול רפואי, ואינו מחליף פנייה לאיש מקצוע מוסמך.</p><p>במקרים של מצב רפואי או נפשי, יש להתייעץ עם גורם רפואי מוסמך לפני תחילת התהליך.</p>';
}

/**
 * @param string $badge_title Title inside the glow note.
 * @param string $note        Note body text.
 * @return string
 */
function ea_s407_blog_pending( $badge_title, $note ) {
	return '<div class="ea-pending-approval" role="status"><span class="ea-pending-approval__badge">ממתין לאישור</span><p class="ea-pending-approval__title">' . esc_html( $badge_title ) . '</p><p class="ea-pending-approval__note">' . esc_html( $note ) . '</p></div>';
}

/**
 * @return array<int,array{seed_key:string,title:string,body:string}>
 */
function ea_s407_blog_spokes_data() {
	$disclaimer = ea_s407_blog_disclaimer();

	// BLOG-01 — pillar = /treatment + CP-01 (snoring-sleep-apnea).
	$blog01_body = '<p>מחקר מבוקר שפורסם בכתב העת BMJ ב-2006 בדק אם תרגול קבוע בדיג\'רידו יכול להשפיע על נחירות ודום נשימה חסימתי בשינה. החוקרים, בראשות מילו פוהאן מאוניברסיטת ציריך, מצאו שיפור בקבוצת המתרגלים לעומת קבוצת הביקורת. הפוסט הזה מפרק את המחקר לגורמים: מי ביצע אותו, מה נמדד, מה נמצא — ומה המגבלות שחשוב להכיר.</p>'
		. '<h2>מי ערך את המחקר ומתי</h2>'
		. '<p>מחקר-הביקורת המבוקר (RCT) פורסם בכתב העת הרפואי BMJ בשנת 2006, בהובלת מילו פוהאן ועמיתיו מאוניברסיטת ציריך בשווייץ. המחקר בדק לראשונה, בצורה שיטתית, האם תרגול נגינה בדיג\'רידו יכול להשפיע על נחירות ועל דום נשימה חסימתי קל עד בינוני בשינה.</p>'
		. '<h2>מה בדיוק נמדד</h2>'
		. ea_s407_blog_pending( 'פרטי המחקר המדויקים', 'מספר המשתתפים, מדדי AHI/Epworth ומשך המעקב (~4 חודשים) ממתינים לאישור אייל אילו נתונים מדויקים לפרסם (WP-S4-07 §4, BLOG-01).' )
		. '<p>המשתתפים חולקו לקבוצת תרגול וקבוצת ביקורת, ועברו מעקב של כארבעה חודשים. נמדדו מדד חומרת דום הנשימה (AHI), מדד ישנוניות יום (Epworth Sleepiness Scale), ודיווח של בני/בנות הזוג על עוצמת הנחירות. מדובר במדגם קטן יחסית — נתון שחשוב לזכור בפרשנות התוצאות.</p>'
		. '<h2>מה היו התוצאות</h2>'
		. '<p>בקבוצה שתרגלה נגינה בדיג\'רידו נמצא שיפור מובהק במדדים, לעומת קבוצת הביקורת: ירידה בחומרת דום הנשימה, פחות ישנוניות בשעות היום, ופחות נחירות כפי שדווחו על ידי בני/בנות הזוג.</p>'
		. '<h2>מה המגבלות</h2>'
		. '<p>כמו בכל מחקר יחיד, יש לקרוא את התוצאות בזהירות: מדובר במדגם קטן יחסית, שהתמקד באנשים עם דום נשימה קל עד בינוני בלבד — לא חמור. אין במחקר כדי להוות תחליף לאבחון או טיפול רפואי, ונדרש מחקר נוסף ורחב יותר.</p>'
		. '<h2>מה זה אומר עבורך בפועל</h2>'
		. '<p>אם אתם מתמודדים עם נחירות או דום נשימה קל-בינוני, המחקר מציע כיוון מעניין: עבודה אקטיבית עם הנשימה, כפי שמתבצעת דרך <a class="tlink" href="/method/">שיטת cbDIDG</a>, עשויה לתמוך בשיפור. זהו כלי משלים — לא תחליף לבדיקת שינה או לייעוץ רפואי.</p>'
		. $disclaimer
		. '<p>לקריאה נוספת: <a class="tlink" href="/treatment/">טיפול בדיג\'רידו</a> · <a class="tlink" href="/blog/">מהי שיטת cbDIDG</a></p>'
		. '<p><a class="tlink" href="/contact/">לתיאום שיחת היכרות</a></p>';

	// BLOG-02 — pillar = /method.
	$blog02_body = '<p>שיטת cbDIDG היא שיטה לעבודה עם הנשימה דרך נגינה בדיג\'רידו וליווי אישי, שפיתח אייל עמית לאורך יותר משני עשורים. היא נולדה ממסע אישי של התמודדות עם אסטמה ואלרגיות, מחניכה אצל המאסטר ההודי מוקש דהימן, ומניסיון מעשי מתמשך עם מאות מתרגלים — ומתבדלת מתרגול נשימה "יבש" במשוב-הצליל המיידי שהדיג\'רידו מספק.</p>'
		. '<h2>איך נולדה השיטה</h2>'
		. ea_s407_blog_pending( 'הסיפור האישי — אסטמה/אלרגיות', 'חשיפת הנתון האישי (אסטמה ואלרגיות) ממתינה לאישור אייל שהוא בנוח לפרסם אותו (WP-S4-07 §4, BLOG-02).' )
		. '<p>שיטת cbDIDG נולדה מתוך מסע אישי של חקירה ולימוד עמוק של הנשימה, כחלק מהתמודדות עם אסטמה ואלרגיות קשות. המפגש עם הדיג\'רידו התחיל מתוך משיכה לצליל המיוחד שלו, אך התגלה בהמשך ככלי שמאפשר לעבוד באופן ישיר עם מערכת הנשימה.</p>'
		. '<h2>החיבור למוקש דהימן</h2>'
		. ea_s407_blog_pending( 'פרטי החניכה אצל מוקש', 'תאריך ההיכרות (2000) ותיאור "תלמיד קרוב" ממתינים לאישור אייל, כחלק מהחלטה D10 (WP-S4-07 §4, BLOG-02).' )
		. '<p>אחד המקורות המשמעותיים בדרך היה הקשר המתמשך עם המאסטר ההודי לדיג\'רידו <a class="tlink" href="/eyal-amit/mokesh-dahiman/">מוקש דהימן</a>, שהחל בשנת 2000. במהלך השנים הפך אייל לאחד מתלמידיו הקרובים, ולמד ממנו את יסודות העבודה התרפויטית עם הדיג\'רידו.</p>'
		. '<h2>שלושת עקרונות השיטה</h2>'
		. '<p>העיקרון הראשון: עבודה אקטיבית — המשתתף לומד לבנות שליטה בנשימה שלו, לא רק לקבל חוויה פאסיבית. העיקרון השני: הבחנה בין טכניקת הנשימה המעגלית המשמשת בזמן נגינה לבין הנשימה היומיומית — הנגינה היא כלי תרגול, לא המטרה עצמה. העיקרון השלישי: תהליך הדרגתי ולא חוויה חד-פעמית, המבוסס על תרגול, התמדה והעמקה.</p>'
		. '<h2>במה זה שונה מתרגול נשימה יבש</h2>'
		. '<p>הדיג\'רידו מאפשר לקבל משוב מיידי דרך הצליל, לזהות דפוסים ולדייק את העבודה — משוב שלא מתאפשר בתרגול נשימה "יבש" בלבד. השילוב בין הכלי, התרגול הפיזי, וההקשבה למה שקורה בגוף הוא הליבה הייחודית של שיטת cbDIDG.</p>'
		. $disclaimer
		. '<p>לקריאה נוספת: <a class="tlink" href="/method/">השיטה — cbDIDG</a> · <a class="tlink" href="/treatment/">טיפול בדיג\'רידו</a></p>'
		. '<p><a class="tlink" href="/contact/">לתיאום שיחת היכרות</a></p>';

	// BLOG-03 — pillar = /method. See file docblock re: existing legacy post.
	$blog03_body = '<p>למרות השם הדומה, נשימה מעגלית בדיג\'רידו וריברסינג (rebirthing) הם שני דברים שונים לחלוטין: הראשון הוא טכניקה פיזית להפקת צליל רציף; השני הוא תהליך נשימה רגשי-תודעתי. אייל עמית עוסק בטיפול בנשימה דרך הדיג\'רידו — לא ב-rebirthing.</p>'
		. '<h2>טבלת השוואה</h2>'
		. '<table><thead><tr><th></th><th>נשימה מעגלית בדיג\'רידו</th><th>ריברסינג (rebirthing)</th></tr></thead><tbody>'
		. '<tr><td>מטרה</td><td>הפקת צליל רציף דרך הכלי, ועבודה על דפוסי נשימה יומיומיים</td><td>עיבוד רגשי/תודעתי דרך דפוס נשימה מודע</td></tr>'
		. '<tr><td>איך מתבצע</td><td>נגינה בדיג\'רידו + תרגול נשימה מעגלית פיזית</td><td>נשימה רציפה ללא עצירות, לרוב בליווי מונחה</td></tr>'
		. '<tr><td>מה לומדים</td><td>שליטה בכלי ובנשימה, טכניקה פיזית מדויקת</td><td>עיבוד חוויתי-רגשי, לא נגינה בכלי</td></tr>'
		. '<tr><td>מה התוצאה</td><td>יכולת נגינה + שיפור בדפוסי נשימה יומיומיים</td><td>חוויה רגשית/תודעתית</td></tr>'
		. '</tbody></table>'
		. '<h2>למה הבלבול קיים</h2>'
		. '<p>שני השמות חולקים את המילה "מעגלית", ושניהם עוסקים בנשימה — ומכאן הבלבול. אבל מדובר בשתי גישות שונות שנולדו מהקשרים שונים לחלוטין: אחת מהעולם המוזיקלי-פיזי של כלי הדיג\'רידו, והשנייה מעולם הטיפול הרגשי.</p>'
		. '<h2>מה זה אומר אם אתה מחפש נשימה מעגלית או ריברסינג</h2>'
		. ea_s407_blog_pending( 'הצהרת-ישות — "לא עוסק ברברסינג"', 'ניסוח וטון ההצהרה "אייל לא עוסק ב-rebirthing" ממתינים לאישור אייל (WP-S4-07 §4, BLOG-03).' )
		. '<p>אם אתם מחפשים ריברסינג כתהליך רגשי-תודעתי, זה לא התחום של אייל עמית. אם אתם מחפשים עבודה עם הנשימה היומיומית דרך כלי מוזיקלי, נגינה וטכניקה — טיפול בדיג\'רידו בשיטת cbDIDG הוא הכתובת.</p>'
		. $disclaimer
		. '<p>לקריאה נוספת: <a class="tlink" href="/method/">השיטה — cbDIDG</a></p>'
		. '<p><a class="tlink" href="/contact/">לתיאום שיחת היכרות</a></p>';

	// BLOG-04 — pillar = /sound-healing + /treatment.
	$blog04_body = '<p>לא כל עבודה עם דיג\'רידו היא אותו דבר. אצל אייל עמית אפשר לפגוש את הכלי בשלוש דרכים שונות: טיפול בדיג\'רידו — תהליך אישי ואקטיבי עם הנשימה; סאונד הילינג — מפגש פאסיבי של הקשבה לצליל; ושיעורי נגינה — לימוד מוזיקלי של הכלי. הפוסט הזה עוזר להבין מה מתאים למי.</p>'
		. '<h2>טבלת השוואה</h2>'
		. ea_s407_blog_pending( 'עמודות ההשוואה + "למי מתאים"', 'ניסוח עמודות טבלת ההשוואה ו"למי מתאים" לכל מסלול ממתין לאישור אייל — לא-חוסם (WP-S4-07 §4, BLOG-04).' )
		. '<table><thead><tr><th></th><th>טיפול בדיג\'רידו</th><th>סאונד הילינג</th><th>שיעורי נגינה</th></tr></thead><tbody>'
		. '<tr><td>סוג עבודה</td><td>אקטיבית</td><td>פאסיבית (הקשבה)</td><td>לימודית-מוזיקלית</td></tr>'
		. '<tr><td>נקודתי או תהליך</td><td>תהליך מתמשך</td><td>לרוב מפגש נקודתי</td><td>תהליך לימודי מתמשך</td></tr>'
		. '<tr><td>מה לומדים</td><td>שליטה, ויסות והחזרת שליטה על הנשימה היומיומית</td><td>אין "לימוד" — חוויה של הרפיה עמוקה דרך צליל</td><td>נגינה, טכניקת הנשימה המעגלית, מקצבים ואפקטים</td></tr>'
		. '<tr><td>למי מתאים</td><td>למי שמוכן להיכנס לתהליך אישי הדרגתי ולעבוד באופן אקטיבי עם הנשימה</td><td>למי שמחפש הרפיה עמוקה, עצירה מהשגרה והתקרקעות</td><td>למי שרוצה ללמוד לנגן ולהתפתח מוזיקלית</td></tr>'
		. '</tbody></table>'
		. '<h2>לאן לפנות</h2>'
		. '<p>אם אתם מתלבטים לאן לפנות: <a class="tlink" href="/treatment/">טיפול בדיג\'רידו</a> מתאים למי שמחפש תהליך אישי מול נחירות, סטרס או עומס; <a class="tlink" href="/sound-healing/">סאונד הילינג</a> מתאים למי שמחפש חוויה של הרפיה ועצירה מהשגרה; ו<a class="tlink" href="/lessons/">שיעורי נגינה</a> מתאימים למי שפשוט רוצה ללמוד לנגן בכלי.</p>'
		. $disclaimer
		. '<p>לקריאה נוספת: <a class="tlink" href="/blog/">מהי שיטת cbDIDG</a></p>'
		. '<p><a class="tlink" href="/contact/">לתיאום שיחת היכרות</a></p>';

	return array(
		array(
			'seed_key' => 'blog-s407-01-bmj-snoring',
			'title'    => "דיג'רידו לדום נשימה ונחירות — מה באמת מצא מחקר ה-BMJ",
			'slug'     => 'bmj-didgeridoo-snoring-study',
			'body'     => $blog01_body,
		),
		array(
			'seed_key' => 'blog-s407-02-cbdidg-method',
			'title'    => 'מהי שיטת cbDIDG — ואיך היא שונה מתרגול נשימה רגיל',
			'slug'     => 'what-is-cbdidg-method',
			'body'     => $blog02_body,
		),
		array(
			'seed_key' => 'blog-s407-03-rebirthing-diff',
			'title'    => "ריברסינג, נשימה מעגלית ודיג'רידו — מה ההבדל",
			'slug'     => 'rebirthing-vs-circular-breathing-didgeridoo-s407',
			'body'     => $blog03_body,
		),
		array(
			'seed_key' => 'blog-s407-04-three-paths',
			'title'    => "ההבדל בין טיפול בדיג'רידו, סאונד הילינג ושיעורי נגינה",
			'slug'     => 'treatment-vs-sound-healing-vs-lessons',
			'body'     => $blog04_body,
		),
	);
}

/**
 * Run once: insert the 4 blog spokes as drafts (idempotent by seed-key meta).
 */
function ea_s407_blog_spokes_seed_once_maybe_run() {
	if ( get_option( 'ea_s407_blog_spokes_seed_v1', '' ) === 'done' ) {
		return;
	}
	if ( wp_installing() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( get_transient( 'ea_s407_blog_spokes_seed_lock' ) ) {
		return;
	}
	set_transient( 'ea_s407_blog_spokes_seed_lock', 1, 300 );

	try {
		foreach ( ea_s407_blog_spokes_data() as $spoke ) {
			$existing = get_posts(
				array(
					'post_type'   => 'post',
					'post_status' => 'any',
					'meta_key'    => '_ea_s407_blog_seed_key',
					'meta_value'  => $spoke['seed_key'],
					'numberposts' => 1,
					'fields'      => 'ids',
				)
			);
			if ( ! empty( $existing ) ) {
				continue; // Already seeded (or hand-edited since) — never overwrite.
			}

			$post_id = wp_insert_post(
				array(
					'post_type'    => 'post',
					'post_status'  => 'draft', // AC-7: 0 published.
					'post_title'   => $spoke['title'],
					'post_name'    => $spoke['slug'],
					'post_content' => $spoke['body'],
				),
				true
			);
			if ( is_wp_error( $post_id ) ) {
				continue;
			}
			update_post_meta( $post_id, '_ea_s407_blog_seed_key', $spoke['seed_key'] );
		}

		update_option( 'ea_s407_blog_spokes_seed_v1', 'done', false );
	} finally {
		delete_transient( 'ea_s407_blog_spokes_seed_lock' );
	}
}
add_action( 'init', 'ea_s407_blog_spokes_seed_once_maybe_run', 40 );
