<?php
/**
 * Chapters — top navigation (fixed required menu structure, scope-doc §05).
 * Menu structure is intentionally fixed (not editor-managed) — it is template,
 * not content. Links resolve to real WP routes via home_url().
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$h = static function ( $path ) {
	return esc_url( home_url( $path ) );
};
?>
<nav class="nav" id="nav" aria-label="<?php esc_attr_e( 'תפריט ראשי', 'ea-eyalamit' ); ?>">
	<a class="nav__b" href="<?php echo $h( '/' ); ?>" aria-label="<?php esc_attr_e( 'אייל עמית — דף הבית', 'ea-eyalamit' ); ?>">
		<span class="nav__lg" aria-hidden="true"></span><b>אייל עמית</b>
	</a>

	<ul class="nav__l" role="list">
		<li><a href="<?php echo $h( '/treatment/' ); ?>">טיפול בדיג׳רידו</a></li>
		<li><a href="<?php echo $h( '/method/' ); ?>">השיטה</a></li>
		<li><a href="<?php echo $h( '/lessons/' ); ?>">שיעורי דיג׳רידו</a></li>
		<li><a href="<?php echo $h( '/sound-healing/' ); ?>">סאונד הילינג</a></li>
		<li>
			<button class="nav__dd" type="button" aria-haspopup="true" aria-expanded="false">לימוד והכשרה<span class="nav__caret" aria-hidden="true">▾</span></button>
			<ul class="nav__sub" role="list">
				<li><a href="#">הכשרות למטפלים</a></li>
				<li><a href="#">קורסים</a></li>
				<li><a href="#">הרצאות</a></li>
				<li><a href="#">סדנאות</a></li>
			</ul>
		</li>
		<li>
			<button class="nav__dd" type="button" aria-haspopup="true" aria-expanded="false">כלים ואביזרים<span class="nav__caret" aria-hidden="true">▾</span></button>
			<ul class="nav__sub" role="list">
				<li><a href="<?php echo $h( '/shop/' ); ?>">כלים בעבודת יד ואביזרים</a></li>
				<li><a href="<?php echo $h( '/repair/' ); ?>">תיקון וחידוש כלים</a></li>
				<li><a href="<?php echo $h( '/didgeridoos/' ); ?>">כלי דיג׳רידו למכירה</a></li>
				<li><a href="<?php echo $h( '/bags/' ); ?>">תיקים לדיג׳רידו</a></li>
				<li><a href="<?php echo $h( '/stands-storage/' ); ?>">סטנדים לאחסון דיג׳רידו</a></li>
				<li><a href="<?php echo $h( '/stand-floor/' ); ?>">סטנד רצפתי לנגינה</a></li>
			</ul>
		</li>
		<li><a href="<?php echo $h( '/books/' ); ?>">מוזה הוצאה לאור</a></li>
		<li><a href="<?php echo $h( '/blog/' ); ?>">בלוג דיג׳רידו</a></li>
		<li>
			<button class="nav__dd" type="button" aria-haspopup="true" aria-expanded="false">אייל עמית<span class="nav__caret" aria-hidden="true">▾</span></button>
			<ul class="nav__sub" role="list">
				<li><a href="<?php echo $h( '/eyal-amit/' ); ?>">אודות אייל</a></li>
				<li><a href="<?php echo $h( '/eyal-amit/mokesh-dahiman/' ); ?>">מוקש דהימן — לזכרו</a></li>
			</ul>
		</li>
		<li><a href="<?php echo $h( '/contact/' ); ?>">צור קשר</a></li>
	</ul>

	<div class="nav__r">
		<button class="nav__tg" id="soundtg" type="button" aria-pressed="false" aria-label="<?php esc_attr_e( 'הפעלת קול בסרטון', 'ea-eyalamit' ); ?>">
			<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9 h4 l5-4 v14 l-5-4 H4 z"/><path d="M17 9 a4 4 0 0 1 0 6"/></svg>שמע
		</button>
		<a class="nav__en" href="<?php echo $h( '/en/' ); ?>" hreflang="en" lang="en">EN</a>
		<button class="nav__burger" type="button" aria-label="<?php esc_attr_e( 'תפריט', 'ea-eyalamit' ); ?>" aria-expanded="false" aria-controls="nav">
			<span></span><span></span><span></span>
		</button>
	</div>
</nav>
