<?php
/**
 * Chapters — 05 TESTIMONIALS. Continuous side-scrolling marquee, pausing on
 * hover/focus.
 *
 * S006 · H-12 · מקור: סקירה דף הבית.xlsx · C16 — «קרוסלת עדויות - יש 15 עדויות
 * במסמך המקורי. בסוף העדויות צריך לשים קישור לדף פנימי שמרכז את כל העדויות.»
 *
 * סדר העדיפויות הפוך מכפי שהיה: 'testi_items' (חמש-עשרה העדויות המאושרות של אייל
 * מ-SECTION 10, ב-home-defaults.php) קודם, והקורפוס של 48 העדויות
 * (inc/data/ea-testimonials-fb.json) נשאר רק כרשת ביטחון אם testi_items ריק.
 * קודם לכן הקורפוס ניצח תמיד, ולכן דף הבית הציג 48 במקום 15.
 * הקורפוס עצמו לא נגע — הוא ממשיך להזין את קרוסלות השירותים דרך
 * template-parts/chapters/parts/testimonials.php.
 *
 * בנתיב הקורפוס, 5 הציטוטים שעדיין נושאים את המותג שיצא משימוש
 * «סטודיו נשימה מעגלית» מסוננים (לא נערכים) לפי WP-06.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$brand = 'סטודיו נשימה מעגלית';
$items = array();

/* S006 · H-11 · מקור: content 13.8.26/דף הבית/homepage1-3 v2.md · SECTION 10 → «CTA: [לכל ההמלצות](/media)» */
$cta_l = ea_chapters_field( 'testi_cta_label' );
$cta_u = ea_chapters_field( 'testi_cta_url' );

foreach ( ea_chapters_rows( 'testi_items' ) as $r ) {
	$txt = trim( (string) ( $r['text'] ?? '' ) );
	if ( '' === $txt ) {
		continue;
	}
	$items[] = array( 'text' => $txt, 'name' => (string) ( $r['name'] ?? '' ), 'href' => (string) ( $r['href'] ?? '' ) );
}
if ( empty( $items ) && function_exists( 'ea_fb_testimonials_all' ) ) {
	foreach ( ea_fb_testimonials_all() as $t ) {
		$blob = ( $t['name'] ?? '' ) . ' ' . ( $t['snippet'] ?? '' ) . ' ' . ( $t['full'] ?? '' );
		if ( false !== mb_strpos( $blob, $brand ) ) {
			continue; // brand-compliance: exclude, do not edit customer quotes
		}
		$txt = trim( (string) ( $t['snippet'] ?? '' ) );
		if ( '' === $txt ) {
			continue;
		}
		$items[] = array( 'text' => $txt, 'name' => (string) ( $t['name'] ?? '' ), 'href' => (string) ( $t['href'] ?? '' ) );
	}
}

if ( empty( $items ) ) {
	return;
}

$render_cards = static function () use ( $items ) {
	foreach ( $items as $it ) {
		/* S006 · H-12 · DEV NOTES של אייל ב-SECTION 10: «2–4 שורות לכל ממליץ».
		 * הכרטיס מקודד HTML (esc_html), ולכן שבירת השורה נעשית כאן: כל שורה
		 * מקודדת בנפרד ומחוברת ב-<br> שאנחנו מייצרים. הטקסט עצמו לא משתנה. */
		$lines = preg_split( '/\R/u', (string) $it['text'] );
		$html  = implode( '<br>', array_map( 'esc_html', (array) $lines ) );
		echo '<figure class="tmq">';
		echo '<blockquote class="tmq__q">' . $html . '</blockquote>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- each line escaped above.
		if ( '' !== $it['name'] ) {
			if ( ! empty( $it['href'] ) ) {
				echo '<figcaption class="tmq__n"><a class="tmq__nl" href="' . esc_url( $it['href'] ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $it['name'] ) . '</a></figcaption>';
			} else {
				echo '<figcaption class="tmq__n">' . esc_html( $it['name'] ) . '</figcaption>';
			}
		}
		echo '</figure>';
	}
};
?>
<section class="sec sec--alt">
	<div class="wrap center">
		<span class="chap chap--c r"><?php echo esc_html( ea_chapters_field( 'testi_chap' ) ); ?></span>
		<h2 class="h2 r"><?php echo esc_html( ea_chapters_field( 'testi_title' ) ); ?></h2>
	</div>
	<div class="testi-mq r" role="region" aria-label="<?php esc_attr_e( 'עדויות והמלצות', 'ea-eyalamit' ); ?>">
		<div class="testi-mq__track">
			<?php
			// Rendered twice for a seamless -50% loop.
			$render_cards();
			$render_cards();
			?>
		</div>
	</div>
	<?php if ( $cta_l ) : ?>
		<div class="wrap center" style="margin-top:40px">
			<a class="btn btn--gd r" href="<?php echo esc_url( $cta_u ); ?>"><?php echo esc_html( $cta_l ); ?></a>
		</div>
	<?php endif; ?>
</section>
