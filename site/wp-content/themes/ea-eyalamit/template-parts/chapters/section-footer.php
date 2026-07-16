<?php
/**
 * Chapters — footer (multi-column links + brand + social + arcs motif).
 * Column links are template (fixed routes); brand tagline + copyright are editable.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$h = static function ( $path ) {
	return esc_url( home_url( $path ) );
};
?>
<footer class="foot">
	<span class="arcs" aria-hidden="true"></span>
	<div class="foot__in">
		<div>
			<h4>מה מציעים</h4>
			<a href="<?php echo $h( '/treatment/' ); ?>">טיפול בדיג׳רידו</a>
			<a href="<?php echo $h( '/lessons/' ); ?>">שיעורי דיג׳רידו</a>
			<a href="<?php echo $h( '/sound-healing/' ); ?>">סאונד הילינג</a>
			<a href="<?php echo $h( '/method/' ); ?>">השיטה cbDIDG</a>
		</div>
		<div>
			<h4>עוד</h4>
			<a href="<?php echo $h( '/blog/' ); ?>">בלוג</a>
			<a href="<?php echo $h( '/books/' ); ?>">ספרים · מוזה</a>
			<a href="<?php echo $h( '/eyal-amit/' ); ?>">אודות אייל</a>
			<a href="<?php echo $h( '/contact/' ); ?>">צור קשר</a>
		</div>
		<div class="foot__brand">
			<b>אייל עמית</b>
			<p>המרכז לטיפול בנשימה באמצעות דיג׳רידו · פרדס חנה, ישראל. שיטת cbDIDG, מאז 1999.</p>
			<p class="foot__nap"><?php echo esc_html( ea_nap( 'address_display' ) ); ?></p>
			<p class="foot__tel">
				<a href="tel:<?php echo esc_attr( ea_nap( 'phone_href' ) ); ?>" dir="ltr"><?php echo esc_html( ea_nap( 'phone_display' ) ); ?></a>
			</p>
			<div class="foot__soc">
				<a href="<?php echo $h( '/contact/' ); ?>" aria-label="פייסבוק"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 4 h-2.5 a3 3 0 0 0-3 3 v3 H7 v3 h2.5 v7 h3 v-7 H15 l.5-3 h-3 V7 a1 1 0 0 1 1-1 H15 z"/></svg></a>
				<a href="<?php echo $h( '/contact/' ); ?>" aria-label="אינסטגרם"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="rgba(255,255,255,.7)" stroke="none"/></svg></a>
				<a href="<?php echo $h( '/contact/' ); ?>" aria-label="יוטיוב"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="6" width="18" height="12" rx="3"/><path d="M10.5 9 v6 l5-3 z" fill="rgba(255,255,255,.7)" stroke="none"/></svg></a>
				<a href="<?php echo $h( '/contact/' ); ?>" aria-label="טיקטוק"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 4 v9.5 a3.5 3.5 0 1 1-3-3.46 M14 7 a4 4 0 0 0 4 3.2"/></svg></a>
			</div>
		</div>
	</div>
	<div class="foot__legal">
		<p class="foot__disc">המידע באתר זה אינו מהווה ייעוץ רפואי, אבחון או טיפול רפואי, ואינו מחליף פנייה לאיש מקצוע מוסמך. במקרים של מצב רפואי או נפשי, יש להתייעץ עם גורם רפואי מוסמך לפני תחילת התהליך.</p>
		<p class="foot__base">&copy; 2026 אייל עמית · כל הזכויות שמורות · <a href="<?php echo $h( '/accessibility/' ); ?>">הצהרת נגישות</a> · <a href="<?php echo $h( '/privacy/' ); ?>">מדיניות פרטיות</a></p>
	</div>
</footer>
