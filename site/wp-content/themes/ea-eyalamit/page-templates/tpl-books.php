<?php
/**
 * Template Name: tpl-books (Wave2)
 * WP-W2-03 — Muzza Publishing catalog (/books).
 * 12 blocks per LOD400 spec: header, hero, intro, about-Eyal, why-here,
 * 3 book cards, inline bundle block, 3 worlds, purchase CTA, shipping, closing.
 * Content verbatim from:
 *   docs/.../תוכן לאתר 25.5.26/מוזה הוצאה לאור - ספרים/MUZZA.md
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();

// BLOCK 01 — Header / top nav.
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-books ea-books-page">

	<?php // BLOCK 02 — Hero (full-screen, single H1, CTA → bundle). ?>
	<section class="ea-book-hero" data-block="hero" aria-label="מוזה הוצאה לאור">
		<div class="ea-book-hero__overlay" aria-hidden="true"></div>
		<div class="ea-book-hero__content">
			<h1 class="ea-book-hero__title">מוזה הוצאה לאור</h1>
			<div class="ea-book-hero__cta-wrap">
				<a class="ea-cta-pill ea-cta-pill--ghost-white" href="#books-bundle">לרכישת חבילת הספרים</a>
			</div>
		</div>
	</section>

	<?php // BLOCK 03 — Intro. ?>
	<section class="ea-section ea-section--prose" data-block="intro" aria-label="פתיח">
		<div class="ea-section__inner ea-entrance--breath">
			<p>מוזה הוצאה לאור הנה הוצאת ספרים עצמית שהוקמה בשנת 2004 על ידי הסופר ומספר הסיפורים אייל עמית.</p>
			<p>בהוצאת מוזה רואים אור ספרי מסעות, פנטסיה וסיפורים אישיים מעוררי השראה - ספרים שנכתבו בתקופות שונות בחיים, וכל אחד מהם פותח דלת אחרת אל מסע, שינוי, חופש והתבוננות.</p>
			<p>מוזה הוצאה לאור היא הבית של ספריו של אייל עמית - הוצאה עצמאית שנולדה מתוך רצון לכתוב, להוציא לאור ולפגוש קוראים בדרך ישירה, אישית ולא מתווכת.</p>
			<p>הספרים שראו כאן אור שונים מאוד זה מזה, אבל מחוברים באותו חוט פנימי: קול חי, כתיבה שנובעת מתוך החיים עצמם, ומבט שלא ממהר להתיישר לפי תבניות מקובלות. יש בהם מסע, פנטסיה, אהבה, הומור, כאב, שינוי, חופש, השראה, תובנות עמוקות לחיים, והרבה מאוד אנושיות.</p>
		</div>
	</section>

	<?php // BLOCK 04 — About Eyal (short). ?>
	<section class="ea-section ea-section--prose ea-section--alt" data-block="about-eyal" aria-label="על אייל עמית">
		<div class="ea-section__inner">
			<p>אייל עמית הוא סופר ומוציא לאור, מהנדס אלקטרוניקה לשעבר ואיש במה לשעבר, שיצר במשך שנים את מופע הסיפורים "תופעת יחיד".</p>
			<p>במקביל לכתיבה, הוא עוסק למעלה משני עשורים בעבודה עם דיג'רידו - כמורה, בונה ומטפל בנשימה, ומנהל את המרכז לטיפול בדיג'רידו בפרדס חנה.</p>
			<p><a class="ea-text-link" href="https://he.wikipedia.org/wiki/%D7%90%D7%99%D7%99%D7%9C_%D7%A2%D7%9E%D7%99%D7%AA" target="_blank" rel="noopener noreferrer">לקריאה נוספת על אייל עמית בויקיפדיה</a></p>
		</div>
	</section>

	<?php // BLOCK 05 — Why the Muzza books are sold here. ?>
	<section class="ea-section ea-section--prose" data-block="why-here" aria-label="למה את הספרים של מוזה תמצאו כאן">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading">למה את הספרים של מוזה תמצאו כאן</h2>
			<p>הספרים של מוזה לא נמכרים כאן במקרה.</p>
			<p>ברכישת ספר דרך רשתות הספרים, רוב הכסף לא מגיע לסופר אלא נשאר בדרך - אצל הרשת ואצל המפיצים. ברכישה ישירה מהיוצר, ממש בדומה ל"חקלאות ישירה", התמיכה מגיעה כמעט נטו למי שכתב את הספר. לכן כאן הספרים נמכרים במחיר מוזל ומשתלם יותר - כזה שטוב גם לקוראים וגם ליוצר.</p>
		</div>
	</section>

	<?php // BLOCKS 06–08 — 3 book cards (each card links to its /books/<slug>). ?>
	<section class="ea-books-section" data-block="book-cards" aria-label="ספרי מוזה הוצאה לאור">
		<div class="ea-books-section__inner">
			<div class="ea-books-grid">

				<?php // Book 1 — צבע בכחול וזרוק לים. ?>
				<article class="ea-book-card ea-entrance">
					<a class="ea-book-card__link"
					   href="<?php echo esc_url( home_url( '/books/tsva-bekahol' ) ); ?>"
					   aria-label="לעמוד הספר צבע בכחול וזרוק לים">
						<div class="ea-book-card__cover-placeholder" aria-hidden="true">[כריכת צבע בכחול וזרוק לים]</div>
						<div class="ea-book-card__body">
							<h3 class="ea-book-card__title">צבע בכחול וזרוק לים</h3>
							<p class="ea-book-card__teaser">38 סיפורים קצרים ובועטים על הטיול הגדול לדרום אמריקה - על שחרור, בריחה, חופש, בלבול, וכל מה שקורה בדרך החוצה ובדרך חזרה. הספר יצא לראשונה בשנת 2001 וכיום נמצא במהדורה העשירית.</p>
						</div>
					</a>
				</article>

				<?php // Book 2 — כושי בלאנטיס. ?>
				<article class="ea-book-card ea-entrance" style="animation-delay:0.1s">
					<a class="ea-book-card__link"
					   href="<?php echo esc_url( home_url( '/books/kushi-blantis' ) ); ?>"
					   aria-label="לעמוד הספר כושי בלאנטיס">
						<div class="ea-book-card__cover-placeholder" aria-hidden="true">[כריכת כושי בלאנטיס]</div>
						<div class="ea-book-card__body">
							<h3 class="ea-book-card__title">כושי בלאנטיס</h3>
							<p class="ea-book-card__teaser">רומן פנטזיה על התעוררות, בחירה, אומץ, והיציאה מהחיים הנוחים מדי - מסע סמלי, צבעוני ומטלטל אל מחוץ לכלוב הזהב. הספר יצא לאור בשנת 2004 ונמצא במהדורה השישית.</p>
						</div>
					</a>
				</article>

				<?php // Book 3 — וכתבת. ?>
				<article class="ea-book-card ea-entrance" style="animation-delay:0.2s">
					<a class="ea-book-card__link"
					   href="<?php echo esc_url( home_url( '/books/vekatavta' ) ); ?>"
					   aria-label="לעמוד הספר וכתבת">
						<div class="ea-book-card__cover-placeholder" aria-hidden="true">[כריכת וכתבת]</div>
						<div class="ea-book-card__body">
							<h3 class="ea-book-card__title">וכתבת</h3>
							<p class="ea-book-card__teaser">46 סיפורים אמיתיים מחייו של אייל עמית - ספר אישי, חי ומעורר השראה, על אהבה, מסעות, אובדן, שינוי, צמיחה, והיכולת לקום גם מהמקומות הכי קשים. הספר ראה אור בשנת 2017, ובאתר מודגש גם אלמנט ה-QR שמרחיב את חוויית הקריאה מעבר לדף.</p>
						</div>
					</a>
				</article>

			</div>
		</div>
	</section>

	<?php // BLOCK 09 — Bundle (inline, anchor target for hero CTA). ?>
	<section id="books-bundle" class="ea-bundle" data-block="bundle" aria-label="חבילת 3 הספרים של אייל עמית">
		<div class="ea-bundle__inner ea-entrance--breath">
			<span class="ea-bundle__accent" aria-hidden="true"></span>
			<h2 class="ea-bundle__title">חבילת 3 הספרים של אייל עמית</h2>
			<p class="ea-bundle__price">שלושת הספרים יחד במחיר מיוחד<br>
				<strong>150 ש"ח</strong> במקום <del>207 ש"ח</del></p>
			<p class="ea-bundle__desc">זו הזדמנות להיכנס לעולם הכתיבה של אייל עמית דרך שלושה ספרים שונים מאוד באופי שלהם, אבל מחוברים באותו קול חי, אישי ולא שגרתי.</p>

			<?php // BLOCK 10 — Purchase CTA for the bundle (external Morning link supplied). ?>
			<div class="ea-bundle__cta">
				<?php ea_w2_03_render_purchase_button( 'bundle', 'לרכישת חבילת 3 הספרים', 'https://mrng.to/MTUiO3vkIg' ); ?>
			</div>

			<?php // BLOCK 11 — Shipping / purchase note. ?>
			<p class="ea-bundle__note">הרכישה מתבצעת דרך קישור חיצוני.<br>פרטי משלוח ותשלום מופיעים בעמוד הרכישה.</p>
		</div>
	</section>

	<?php // BLOCK (3 worlds) — supporting block for the bundle. ?>
	<section class="ea-section ea-section--prose ea-section--alt" data-block="three-worlds" aria-label="שלושה ספרים, שלושה עולמות">
		<div class="ea-section__inner">
			<h2 class="ea-section__heading">שלושה ספרים, שלושה עולמות</h2>
			<p>כל אחד מהספרים עומד בפני עצמו. יחד, הם מציעים מפגש עם שלושה שערים שונים אל תוך החיים והכתיבה:</p>
			<ul class="ea-section__list">
				<li>מסע והתבגרות</li>
				<li>פנטסיה והתעוררות</li>
				<li>סיפורים אמיתיים בגובה העיניים</li>
			</ul>
			<p>זו יכולה להיות דרך טובה להתחיל להכיר את הכתיבה של אייל עמית, וזו גם מתנה מקורית למי שאוהב ספרים עם קול אישי, תנועה ועומק.</p>
		</div>
	</section>

	<?php // BLOCK 12 — Closing. ?>
	<section class="ea-section ea-section--prose ea-section--closing" data-block="closing" aria-label="סגירת עמוד">
		<div class="ea-section__inner">
			<p>הספרים נכתבו בתקופות שונות בחיים, וכל אחד מהם מביא קול אחר, זווית אחרת והתבוננות שונה.</p>
			<p>אין סדר קריאה מחייב. כל ספר עומד בפני עצמו.</p>
		</div>
	</section>

</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
