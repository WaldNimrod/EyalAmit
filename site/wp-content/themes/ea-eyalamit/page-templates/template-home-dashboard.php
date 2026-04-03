<?php
/**
 * Template Name: Home Dashboard (M2 mockup B)
 * Description: דף בית — מבנה לפי מוקאפ ב׳; טיפוגרפיה וצבעים לפי האתר הקיים (Bridge). היררכיה שיווקית לפי מפת v2.3 ופגישת 2026-03-31.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$img_base = get_stylesheet_directory_uri() . '/assets/home/';
$u        = static function ( $path ) {
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
					<?php esc_html_e( 'תצוגת דף בית — רקע בהיר, פונט Rubik (עברית ולטינית, ללא serif), דגש טורקיז; היררכיה שיווקית v2.3 — לאישור אייל.', 'ea-eyalamit' ); ?>
				</p>

				<section class="ea-home-hero" aria-label="<?php esc_attr_e( 'כותרת ראשית', 'ea-eyalamit' ); ?>">
					<?php
					/*
					 * `eyal-portrait-hero.jpg` — שם קובץ יציב לפריסה (דריסת FTP).
					 * מקור חי (2026): https://www.eyalamit.co.il/wp-content/uploads/2023/09/1.jpg — אותם בתים כמו באתר הראשי (כותרת Bridge).
					 */
					?>
					<img
						src="<?php echo esc_url( $img_base . 'eyal-portrait-hero.jpg' ); ?>"
						alt="<?php echo esc_attr__( 'אייל עמית - המרכז לטיפול בדיג׳רידו סטודיו נשימה מעגלית', 'ea-eyalamit' ); ?>"
						width="4000"
						height="1868"
						decoding="async"
						fetchpriority="high"
					/>
					<div class="ea-home-hero-overlay">
						<h1><?php esc_html_e( 'המרכז לטיפול בדיג׳רידו - אייל עמית', 'ea-eyalamit' ); ?></h1>
						<p class="ea-home-hero-sub"><?php esc_html_e( 'כלי נגינה, טיפול ונשימה, לימוד, הרצאות וסדנאות — ערוצי העבודה הפעילים של המרכז.', 'ea-eyalamit' ); ?></p>
						<p class="ea-home-hero-meta"><?php esc_html_e( 'המרכז לטיפול בנשימה באמצעות דיג׳ירידו - סטודיו נשימה מעגלית - אייל עמית', 'ea-eyalamit' ); ?></p>
						<div class="ea-home-cta-row">
							<a class="ea-home-btn" href="<?php echo $u( '/contact/' ); ?>"><?php esc_html_e( 'צור קשר', 'ea-eyalamit' ); ?></a>
							<a class="ea-home-btn ea-home-btn-ghost" href="<?php echo $u( '/hashita/' ); ?>"><?php esc_html_e( 'השיטה', 'ea-eyalamit' ); ?></a>
							<a class="ea-home-btn ea-home-btn-ghost" href="<?php echo $u( '/shop/' ); ?>"><?php esc_html_e( 'קטלוג כלים', 'ea-eyalamit' ); ?></a>
						</div>
					</div>
				</section>

				<section class="ea-home-priority" aria-label="<?php esc_attr_e( 'שירותים ומסלולים פעילים', 'ea-eyalamit' ); ?>">
					<h2><?php esc_html_e( 'מה המרכז מציע היום', 'ea-eyalamit' ); ?></h2>
					<p class="ea-home-priority-intro">
						<?php esc_html_e( 'לפי מפת האתר המאושרת: דגש על מסלולי ליבה (כלים, טיפול, לימוד, הרצאות וסדנאות). הופעות וכתבות היסטוריות אינן בראש סדר העדיפות השיווקי — הן מופיעות למטה כמורשת וארכיון.', 'ea-eyalamit' ); ?>
					</p>
					<ul class="ea-home-priority-grid">
						<li><a href="<?php echo $u( '/hashita/' ); ?>"><?php esc_html_e( 'השיטה — נשימה מעגלית והדיג׳רידו', 'ea-eyalamit' ); ?></a></li>
						<li><a href="<?php echo $u( '/handmade-instruments/' ); ?>"><?php esc_html_e( 'כלים בעבודת יד ואביזרים', 'ea-eyalamit' ); ?></a></li>
						<li><a href="<?php echo $u( '/instrument-repair/' ); ?>"><?php esc_html_e( 'תיקון וחידוש כלים', 'ea-eyalamit' ); ?></a></li>
						<li><a href="<?php echo $u( '/didgeridoo-treatment-breath/' ); ?>"><?php esc_html_e( 'טיפול בדיג׳רידו / נשימה', 'ea-eyalamit' ); ?></a></li>
						<li><a href="<?php echo $u( '/sound-healing/' ); ?>"><?php esc_html_e( 'סאונד הילינג / מדיטציה', 'ea-eyalamit' ); ?></a></li>
						<li><a href="<?php echo $u( '/didgeridoo-lessons/' ); ?>"><?php esc_html_e( 'שיעורי דיג׳רידו / נגינה', 'ea-eyalamit' ); ?></a></li>
						<li><a href="<?php echo $u( '/lectures/' ); ?>"><?php esc_html_e( 'הרצאות', 'ea-eyalamit' ); ?></a></li>
						<li><a href="<?php echo $u( '/workshops/' ); ?>"><?php esc_html_e( 'סדנאות', 'ea-eyalamit' ); ?></a></li>
						<li><a href="<?php echo $u( '/courses-soon/' ); ?>"><?php esc_html_e( 'קורסים', 'ea-eyalamit' ); ?></a></li>
						<li><a href="<?php echo $u( '/therapist-training/' ); ?>"><?php esc_html_e( 'הכשרות למטפלים', 'ea-eyalamit' ); ?></a></li>
					</ul>
				</section>

				<div class="ea-home-blocks">
					<div class="ea-home-card ea-home-block-large">
						<img
							src="<?php echo esc_url( $img_base . 'workshop-thumb.jpg' ); ?>"
							alt="<?php echo esc_attr__( 'סדנה או מפגש מקצועי במרכז — אייל עמית', 'ea-eyalamit' ); ?>"
							width="300"
							height="227"
							decoding="async"
							loading="lazy"
						/>
						<div class="inner">
							<h2><?php esc_html_e( 'סדנאות והרצאות', 'ea-eyalamit' ); ?></h2>
							<p><?php esc_html_e( 'מסלולים קבוצתיים ומפגשי העשרה — לפרטים ולרישום בעמודי הסדנאות וההרצאות.', 'ea-eyalamit' ); ?></p>
							<div class="ea-home-cta-row ea-home-cta-row--compact">
								<a class="ea-home-btn" href="<?php echo $u( '/workshops/' ); ?>"><?php esc_html_e( 'סדנאות', 'ea-eyalamit' ); ?></a>
								<a class="ea-home-btn ea-home-btn-ghost" href="<?php echo $u( '/lectures/' ); ?>"><?php esc_html_e( 'הרצאות', 'ea-eyalamit' ); ?></a>
							</div>
						</div>
					</div>

					<div class="ea-home-card">
						<h3><?php esc_html_e( 'אודות והמלצות', 'ea-eyalamit' ); ?></h3>
						<p><?php esc_html_e( 'רקע מקצועי, מסע ועדויות — מוזמנים להמשיך מאודות ומהמלצות.', 'ea-eyalamit' ); ?></p>
						<p class="ea-home-card__link-row">
							<a href="<?php echo $u( '/eyal-amit/' ); ?>"><?php esc_html_e( 'אייל עמית', 'ea-eyalamit' ); ?></a>
							<?php echo esc_html( ' · ' ); ?>
							<a href="<?php echo $u( '/testimonials-media/' ); ?>"><?php esc_html_e( 'המלצות ומדיה', 'ea-eyalamit' ); ?></a>
						</p>
					</div>

					<div class="ea-home-card ea-home-legacy">
						<h3><?php esc_html_e( 'מורשת, הופעות וארכיון', 'ea-eyalamit' ); ?></h3>
						<p><?php esc_html_e( 'תכנים מהעבר — לא בראש סדר העדיפות השיווקי; נשמרים לגישה ישירה ולמבקרים מחפשים ארכיון.', 'ea-eyalamit' ); ?></p>
						<ul class="ea-home-legacy-list">
							<li><a href="<?php echo $u( '/shows-heritage/' ); ?>"><?php esc_html_e( 'הופעות / מורשת מופע', 'ea-eyalamit' ); ?></a></li>
							<li><a href="<?php echo $u( '/historical-articles/' ); ?>"><?php esc_html_e( 'כתבות היסטוריות', 'ea-eyalamit' ); ?></a></li>
						</ul>
					</div>
				</div>

				<section class="ea-home-seo-block" aria-label="<?php esc_attr_e( 'מידע למבקרים ומנועי חיפוש', 'ea-eyalamit' ); ?>">
					<h2><?php esc_html_e( 'המרכז בקצרה', 'ea-eyalamit' ); ?></h2>
					<p>
						<?php esc_html_e( 'אייל עמית מפעיל במרכז לטיפול בדיג׳רידו בישראל מסלולי לימוד, טיפול וסדנאות בנשימה מעגלית, סאונד הילינג ודיג׳רידו. האתר משמש מקור מידע על שירותים, מחירונים ורכישת כלים — עם מבנה ברור לקוראים ולמנועי חיפוש.', 'ea-eyalamit' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'מילות מפתח: דיג׳רידו, נשימה מעגלית, טיפול בדיג׳רידו בישראל, סדנאות וקורסים, סאונד הילינג, אייל עמית.', 'ea-eyalamit' ); ?>
					</p>
				</section>
			</div>
		</div>
	</div>
	<?php
}
get_footer();
