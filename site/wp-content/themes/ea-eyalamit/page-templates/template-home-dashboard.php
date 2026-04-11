<?php
/**
 * Template Name: Home Dashboard (M2 mockup B)
 * Description: דף בית — 12 בלוקים לפי מסמך אייל (GEO/AEO/SEO) §7.1–§8; וידאו אחרי בלוקי ההסבר; FAQ קצר; CTA תחתון. טיפוגרפיה לפי child.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$u = static function ( $path ) {
	return esc_url( home_url( $path ) );
};

get_header();
while ( have_posts() ) {
	the_post();
	?>
	<div class="inside-article">
		<div class="entry-content">
			<div class="ea-home-front">
				<p class="ea-home-banner" role="note">
					<?php esc_html_e( 'תצוגת דף בית — מבנה מאושר במסמך אייל (GEO/AEO/SEO) §7.1–§8; סטייג׳ינג. Hero וסדר בלוקים נעולים למסמך.', 'ea-eyalamit' ); ?>
				</p>

				<section class="ea-home-hero" aria-label="<?php esc_attr_e( 'Hero — בלוק 2', 'ea-eyalamit' ); ?>">
					<div class="ea-home-hero-backdrop" role="img" aria-label="<?php esc_attr_e( 'רקע Hero — מוקאפ ללא תמונת סטוק; יוחלף בתמונת מותג מאייל', 'ea-eyalamit' ); ?>"></div>
					<div class="ea-home-hero-overlay">
						<h1><?php esc_html_e( 'המרכז לטיפול בנשימה באמצעות דיג׳רידו - שיטת cbDIDG של אייל עמית', 'ea-eyalamit' ); ?></h1>
						<p class="ea-home-hero-sub"><?php esc_html_e( 'גישת טיפול ייחודית המבוססת על דיג׳רידו, נשימה וצליל, שפותחה ומיושמת על ידי אייל עמית - מהוותיקים בארץ בתחום.', 'ea-eyalamit' ); ?></p>
						<p class="ea-home-hero-meta"><?php esc_html_e( 'אייל עמית הוא מורה לדיג׳רידו ומטפל בנשימה באמצעות דיג׳רידו, הפועל מאז 1999 ומייסד המרכז לטיפול בדיג׳רידו בפרדס חנה.', 'ea-eyalamit' ); ?></p>
						<div class="ea-home-cta-row">
							<a class="ea-home-btn" href="<?php echo $u( '/contact/' ); ?>"><?php esc_html_e( 'לתיאום שיחה', 'ea-eyalamit' ); ?></a>
							<a class="ea-home-btn ea-home-btn-ghost" href="<?php echo $u( '/method/' ); ?>"><?php esc_html_e( 'השיטה', 'ea-eyalamit' ); ?></a>
						</div>
					</div>
				</section>

				<section class="ea-home-section" aria-labelledby="ea-home-what-treatment">
					<h2 id="ea-home-what-treatment"><?php esc_html_e( 'מה זה טיפול בדיג׳רידו', 'ea-eyalamit' ); ?></h2>
					<p class="ea-home-section-lead">
						<?php esc_html_e( 'טיפול בדיג׳רידו הוא תהליך עבודה עם נשימה, צליל והקשבה לגוף, שבו האדם משתתף באופן פעיל. המפגש לא מבוסס רק על האזנה, אלא על למידה והתנסות שמחברות בין נשימה, צליל ונוכחות.', 'ea-eyalamit' ); ?>
					</p>
				</section>

				<section class="ea-home-section" aria-labelledby="ea-home-vs-sound">
					<h2 id="ea-home-vs-sound"><?php esc_html_e( 'טיפול בדיג׳רידו מול סאונד הילינג', 'ea-eyalamit' ); ?></h2>
					<p class="ea-home-section-lead">
						<?php esc_html_e( 'בטיפול בדיג׳רידו יש השתתפות פעילה ועבודה אישית עם נשימה וכלי. בסאונד הילינג הדגש הוא יותר על הקשבה, חוויה וקבלה של הצליל כפי שהוא פוגש את הגוף והמרחב.', 'ea-eyalamit' ); ?>
						<?php echo esc_html( ' ' ); ?>
						<a href="<?php echo $u( '/treatment/' ); ?>"><?php esc_html_e( 'טיפול', 'ea-eyalamit' ); ?></a>
						<?php echo esc_html( ' · ' ); ?>
						<a href="<?php echo $u( '/sound-healing/' ); ?>"><?php esc_html_e( 'סאונד הילינג', 'ea-eyalamit' ); ?></a>
					</p>
				</section>

				<section class="ea-home-section ea-home-video-block" aria-labelledby="ea-home-video-h">
					<h2 id="ea-home-video-h"><?php esc_html_e( 'וידאו — הצצה למרחב ולדרך העבודה', 'ea-eyalamit' ); ?></h2>
					<p class="ea-home-section-lead">
						<?php esc_html_e( 'לפי המסמך: הוידאו אחרי בלוקי ההסבר; ללא autoplay; עם הקשר טקסטואלי מעל ומתחת.', 'ea-eyalamit' ); ?>
					</p>
					<div class="ea-home-video-placeholder" role="img" aria-label="<?php esc_attr_e( 'מקום לשבץ וידאו (iframe) — ללא הפעלה אוטומטית', 'ea-eyalamit' ); ?>">
						<span><?php esc_html_e( 'מקום לוידאו (placeholder)', 'ea-eyalamit' ); ?></span>
					</div>
					<p class="ea-home-video-caption">
						<?php esc_html_e( 'טקסט מתחת לוידאו — הסבר קצר למבקרים ולמנועי תשובה.', 'ea-eyalamit' ); ?>
					</p>
				</section>

				<section class="ea-home-section" aria-labelledby="ea-home-areas-h">
					<h2 id="ea-home-areas-h"><?php esc_html_e( 'תחומי הפעילות', 'ea-eyalamit' ); ?></h2>
					<p class="ea-home-section-lead ea-home-section-lead--compact"><?php esc_html_e( 'ארבעת הכרטיסים המאושרים במסמך — בלי מוצרים בבלוק זה.', 'ea-eyalamit' ); ?></p>
					<ul class="ea-home-areas-grid">
						<li class="ea-home-area-card"><a href="<?php echo $u( '/treatment/' ); ?>"><?php esc_html_e( 'טיפול בדיג׳רידו', 'ea-eyalamit' ); ?></a></li>
						<li class="ea-home-area-card"><a href="<?php echo $u( '/lessons/' ); ?>"><?php esc_html_e( 'שיעורי דיג׳רידו', 'ea-eyalamit' ); ?></a></li>
						<li class="ea-home-area-card"><a href="<?php echo $u( '/sound-healing/' ); ?>"><?php esc_html_e( 'סאונד הילינג', 'ea-eyalamit' ); ?></a></li>
						<li class="ea-home-area-card"><a href="<?php echo $u( '/method/' ); ?>"><?php esc_html_e( 'השיטה', 'ea-eyalamit' ); ?></a></li>
					</ul>
				</section>

				<section class="ea-home-section" aria-labelledby="ea-home-cbdidg-h">
					<h2 id="ea-home-cbdidg-h"><?php esc_html_e( 'שיטת cbDIDG', 'ea-eyalamit' ); ?></h2>
					<p class="ea-home-section-lead">
						<?php esc_html_e( 'בלוק סמכות — לא אזכור שולי. קישור לעמוד השיטה.', 'ea-eyalamit' ); ?>
						<a href="<?php echo $u( '/method/' ); ?>"><?php esc_html_e( 'לעמוד השיטה', 'ea-eyalamit' ); ?></a>
					</p>
				</section>

				<section class="ea-home-section" aria-labelledby="ea-home-audience-h">
					<h2 id="ea-home-audience-h"><?php esc_html_e( 'למי זה מתאים', 'ea-eyalamit' ); ?></h2>
					<p class="ea-home-section-lead">
						<?php esc_html_e( 'למי שמבקש לפגוש את הנשימה בצורה מעשית יותר, למי שמחפש שקט, מיקוד או תהליך אישי, וגם למי שנמשך לדיג׳רידו ככלי לימוד וחקירה. ההתאמה תמיד נבחנת דרך שיחה ומפגש, ולא לפי כותרת בלבד.', 'ea-eyalamit' ); ?>
					</p>
				</section>

				<section class="ea-home-section ea-home-faq-short" aria-labelledby="ea-home-faq-h">
					<h2 id="ea-home-faq-h"><?php esc_html_e( 'שאלות נפוצות — קצר', 'ea-eyalamit' ); ?></h2>
					<p class="ea-home-section-lead ea-home-section-lead--compact"><?php esc_html_e( 'תשובות זמניות — צוות 80; לעמוד FAQ מלא:', 'ea-eyalamit' ); ?>
						<a href="<?php echo $u( '/faq/' ); ?>"><?php esc_html_e( 'שאלות נפוצות', 'ea-eyalamit' ); ?></a>
					</p>
					<details class="ea-home-faq-item">
						<summary><?php esc_html_e( 'מה זה טיפול בדיג׳רידו?', 'ea-eyalamit' ); ?></summary>
						<p><?php esc_html_e( 'טיפול בדיג׳רידו הוא תהליך עבודה עם נשימה, צליל והקשבה לגוף, שבו האדם משתתף באופן פעיל. המפגש לא מבוסס רק על האזנה, אלא על למידה והתנסות שמחברות בין נשימה, צליל ונוכחות.', 'ea-eyalamit' ); ?></p>
					</details>
					<details class="ea-home-faq-item">
						<summary><?php esc_html_e( 'מה ההבדל בין טיפול בדיג׳רידו לסאונד הילינג?', 'ea-eyalamit' ); ?></summary>
						<p><?php esc_html_e( 'בטיפול בדיג׳רידו יש השתתפות פעילה ועבודה אישית עם נשימה וכלי. בסאונד הילינג הדגש הוא יותר על הקשבה, חוויה וקבלה של הצליל כפי שהוא פוגש את הגוף והמרחב.', 'ea-eyalamit' ); ?></p>
					</details>
					<details class="ea-home-faq-item">
						<summary><?php esc_html_e( 'האם צריך ניסיון קודם כדי להגיע?', 'ea-eyalamit' ); ?></summary>
						<p><?php esc_html_e( 'לא. אפשר להגיע בלי רקע מוקדם, ויחד לבדוק מה מתאים יותר כרגע: טיפול, שיעור, סאונד הילינג או מסגרת אחרת. נקודת המוצא היא התאמה לאדם, לא עמידה בדרישת סף.', 'ea-eyalamit' ); ?></p>
					</details>
					<details class="ea-home-faq-item">
						<summary><?php esc_html_e( 'למי זה יכול להתאים?', 'ea-eyalamit' ); ?></summary>
						<p><?php esc_html_e( 'למי שמבקש לפגוש את הנשימה בצורה מעשית יותר, למי שמחפש שקט, מיקוד או תהליך אישי, וגם למי שנמשך לדיג׳רידו ככלי לימוד וחקירה. ההתאמה תמיד נבחנת דרך שיחה ומפגש, ולא לפי כותרת בלבד.', 'ea-eyalamit' ); ?></p>
					</details>
					<details class="ea-home-faq-item">
						<summary><?php esc_html_e( 'איך מתחילים?', 'ea-eyalamit' ); ?></summary>
						<p><?php esc_html_e( 'מתחילים ביצירת קשר, שאלה קצרה או תיאום מפגש ראשון. משם אפשר להבין יחד מהו הערוץ הנכון ביותר להמשך, בהתאם לשלב שבו אתם נמצאים ולמה שאתם מחפשים.', 'ea-eyalamit' ); ?></p>
					</details>
					<p class="ea-home-faq-more">
						<a class="ea-home-btn ea-home-btn-ghost" href="<?php echo $u( '/faq/' ); ?>"><?php esc_html_e( 'לעמוד FAQ המלא', 'ea-eyalamit' ); ?></a>
					</p>
				</section>

				<section class="ea-home-section" aria-labelledby="ea-home-testimonials-h">
					<h2 id="ea-home-testimonials-h"><?php esc_html_e( 'המלצות', 'ea-eyalamit' ); ?></h2>
					<h3 class="ea-home-testimonials-sub"><?php esc_html_e( 'מילים שנשארו אחרי המפגש', 'ea-eyalamit' ); ?></h3>
					<p class="ea-home-section-lead ea-home-section-lead--compact">
						<a href="<?php echo $u( '/media/' ); ?>"><?php esc_html_e( 'המלצות — קטלוג מרכזי', 'ea-eyalamit' ); ?></a>
					</p>
					<blockquote class="ea-home-quote" cite="<?php echo esc_url( home_url( '/' ) ); ?>">
						<p><?php esc_html_e( 'הגעתי בלי לדעת למה לצפות, ומהר מאוד הרגשתי שיש כאן דרך אחרת להקשיב לעצמי דרך הנשימה והצליל.', 'ea-eyalamit' ); ?></p>
					</blockquote>
					<blockquote class="ea-home-quote" cite="<?php echo esc_url( home_url( '/' ) ); ?>">
						<p><?php esc_html_e( 'המפגש היה פשוט, נעים ומדויק, ויצאתי ממנו עם תחושת שקט וקרבה לגוף שלא חוויתי מזמן.', 'ea-eyalamit' ); ?></p>
					</blockquote>
					<p class="ea-home-placeholder-tag" role="note"><em><?php esc_html_e( 'PLACEHOLDER — צוות 80 — לא לאישור פרסום סופי', 'ea-eyalamit' ); ?></em></p>
				</section>

				<section class="ea-home-section" aria-labelledby="ea-home-updates-h">
					<h2 id="ea-home-updates-h"><?php esc_html_e( 'עדכונים', 'ea-eyalamit' ); ?></h2>
					<p class="ea-home-section-lead">
						<?php esc_html_e( 'באזור הזה יופיעו עדכונים שוטפים מתוך העשייה של אייל: סדנאות קרובות, אירועים, תכנים חדשים או הודעות חשובות. לא כל דבר חייב לעלות כאן, אלא רק מה שרלוונטי עכשיו ויכול לעזור להבין מה קורה בזמן אמת.', 'ea-eyalamit' ); ?>
					</p>
				</section>

				<section class="ea-home-section ea-home-about-short" aria-labelledby="ea-home-about-h">
					<h2 id="ea-home-about-h"><?php esc_html_e( 'אודות קצר', 'ea-eyalamit' ); ?></h2>
					<p class="ea-home-section-lead">
						<?php esc_html_e( 'חיזוק entity — לא ביוגרפיה ארוכה. ', 'ea-eyalamit' ); ?>
						<a href="<?php echo $u( '/eyal-amit/' ); ?>"><?php esc_html_e( 'אייל עמית', 'ea-eyalamit' ); ?></a>
					</p>
				</section>

				<section class="ea-home-cta-bottom" aria-label="<?php esc_attr_e( 'קריאה לפעולה תחתונה', 'ea-eyalamit' ); ?>">
					<h2 class="ea-home-cta-bottom__title"><?php esc_html_e( 'מוכנים לשיחת היכרות?', 'ea-eyalamit' ); ?></h2>
					<p class="ea-home-cta-bottom__text"><?php esc_html_e( 'אם משהו כאן מרגיש מדויק לכם, אפשר לעצור לרגע ולבדוק מה נכון להתחיל ממנו. מוזמנים ליצור קשר, לשאול, להתייעץ, ולתאם מפגש ראשוני או שיחה קצרה שתעזור לדייק את הצעד הבא.', 'ea-eyalamit' ); ?></p>
					<div class="ea-home-cta-row ea-home-cta-row--center">
						<a class="ea-home-btn" href="<?php echo $u( '/contact/' ); ?>"><?php esc_html_e( 'צור קשר / לתיאום שיחה', 'ea-eyalamit' ); ?></a>
					</div>
					<p class="ea-home-cta-bottom__hint"><?php esc_html_e( 'לתיאום מפגש או לשאלות, מוזמנים ליצור קשר.', 'ea-eyalamit' ); ?></p>
				</section>
			</div>
		</div>
	</div>
	<?php
}
get_footer();
