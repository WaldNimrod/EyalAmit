<?php
/**
 * Chapters — 05 TESTIMONIALS. Continuous side-scrolling marquee of many real
 * testimonials from the curated FB corpus (inc/ea-testimonials-fb.php), pausing
 * on hover/focus. The 5 quotes that still contain the retired brand
 * «סטודיו נשימה מעגלית» are EXCLUDED here (not edited) per WP-06.
 * Falls back to the ACF/seeded testi_items if the corpus isn't available.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$brand = 'סטודיו נשימה מעגלית';
$items = array();

if ( function_exists( 'ea_fb_testimonials_all' ) ) {
	foreach ( ea_fb_testimonials_all() as $t ) {
		$blob = ( $t['name'] ?? '' ) . ' ' . ( $t['snippet'] ?? '' ) . ' ' . ( $t['full'] ?? '' );
		if ( false !== mb_strpos( $blob, $brand ) ) {
			continue; // brand-compliance: exclude, do not edit customer quotes
		}
		$txt = trim( (string) ( $t['snippet'] ?? '' ) );
		if ( '' === $txt ) {
			continue;
		}
		$items[] = array( 'text' => $txt, 'name' => (string) ( $t['name'] ?? '' ) );
	}
}
if ( empty( $items ) ) {
	foreach ( ea_chapters_rows( 'testi_items' ) as $r ) {
		$items[] = array( 'text' => $r['text'] ?? '', 'name' => $r['name'] ?? '' );
	}
}

if ( empty( $items ) ) {
	return;
}

$render_cards = static function () use ( $items ) {
	foreach ( $items as $it ) {
		echo '<figure class="tmq">';
		echo '<blockquote class="tmq__q">' . esc_html( $it['text'] ) . '</blockquote>';
		if ( '' !== $it['name'] ) {
			echo '<figcaption class="tmq__n">' . esc_html( $it['name'] ) . '</figcaption>';
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
</section>
