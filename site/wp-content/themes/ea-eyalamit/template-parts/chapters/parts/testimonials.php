<?php
/**
 * Chapters part — testimonials marquee (continuous side-scroll, pause on hover).
 *
 * Renders verbatim $args['items'] ({text, name}) when provided — the approved
 * source testimonials — otherwise falls back to the FB corpus (brand-excluded)
 * via ea_chapters_testimonials($cat).
 *
 * $args: chap, title, cat (optional category slug), items (optional [{text,name,href}])
 *
 * S006 · slug rename · אישור team_00 2026-08-17 — /media/ → /testimonials/
 * S006 · H-15 · שלוש תוספות בלבד עבור /testimonials/ (ריכוז כל ההמלצות). ברירת המחדל
 * לא זזה — /treatment, /sound-healing, /lessons ודף הבית מרונדרים בדיוק כמקודם:
 *   1) 'href' על פריט → השם הופך לקישור, באותה תבנית בדיוק שכבר קיימת ב-
 *      template-parts/chapters/section-05-testimonials.php (tmq__nl + target/rel).
 *      פריט בלי href מרונדר כמו קודם, בייט-לבייט.
 *   2) 'archive' => true → מושך את הקטגוריה המלאה מהקורפוס דרך
 *      ea_fb_testimonials_archive($cat), כולל רשומות שאין להן snippet.
 *   3) 'layout' => 'grid' → רשת סטטית במקום קרוסלה. בעמוד ריכוז אי-אפשר
 *      להשתמש בקרוסלה: היא מכפילה כל כרטיס (loop של 50%-) ו-clamp:8 חותך ציטוטים,
 *      ואייל ביקש קישור לעמוד «שמרכז את כל העדויות».
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$a       = isset( $args ) && is_array( $args ) ? $args : array();
$archive = ! empty( $a['archive'] );                                  // S006 · H-15
$grid    = 'grid' === ( $a['layout'] ?? '' );                         // S006 · H-15
$items   = array();
if ( ! empty( $a['items'] ) && is_array( $a['items'] ) ) {
	foreach ( $a['items'] as $it ) {
		$txt = isset( $it['text'] ) ? trim( (string) $it['text'] ) : '';
		if ( '' === $txt ) {
			continue;
		}
		$items[] = array(
			'text' => $txt,
			'name' => isset( $it['name'] ) ? (string) $it['name'] : '',
			'href' => isset( $it['href'] ) ? (string) $it['href'] : '', // S006 · H-15
		);
	}
}
/* S006 · H-15 · מסלול הארכיון: כל הקטגוריה, כולל המלצה בלי ציטוט (שם + קישור). */
if ( empty( $items ) && $archive ) {
	$items = ea_fb_testimonials_archive( $a['cat'] ?? '' );
}
if ( empty( $items ) ) {
	$items = ea_chapters_testimonials( $a['cat'] ?? '' );
}
if ( empty( $items ) ) {
	return;
}
$cards = static function () use ( $items, $grid ) {
	foreach ( $items as $it ) {
		echo '<figure class="tmq' . ( $grid ? ' tmq--full' : '' ) . '">';
		/* S006 · H-15 · בארכיון מוצגת גם המלצה שאין לה ציטוט בקורפוס — השם
		 * והקישור הם התוכן של אייל, ואין להמציא טקסט במקומם. */
		if ( '' !== $it['text'] ) {
			echo '<blockquote class="tmq__q">' . esc_html( $it['text'] ) . '</blockquote>';
		}
		if ( '' !== $it['name'] ) {
			/* S006 · H-15 · אותה תבנית קישור כמו section-05-testimonials.php. */
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
		<?php if ( ! empty( $a['chap'] ) ) : ?><span class="chap chap--c r"><?php echo esc_html( $a['chap'] ); ?></span><?php endif; ?>
		<h2 class="h2 r"><?php echo esc_html( $a['title'] ?? '' ); ?></h2>
	</div>
<?php if ( $grid ) : /* S006 · H-15 · רשת סטטית, בלי הכפלה ובלי חיתוך טקסט. */ ?>
	<div class="wrap">
		<div class="testi-grid r"><?php $cards(); ?></div>
	</div>
<?php else : ?>
	<div class="testi-mq r" role="region" aria-label="<?php echo esc_attr( $a['title'] ?? 'עדויות' ); ?>">
		<div class="testi-mq__track"><?php $cards(); $cards(); ?></div>
	</div>
<?php endif; ?>
</section>
