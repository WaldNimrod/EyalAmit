<?php
/**
 * Chapters — top navigation.
 *
 * S007 M-13: items now come from ea_canonical_nav_items() (inc/ea-canonical-
 * nav.php) — the single source every renderer reads — instead of being
 * hand-coded here. "home" is skipped: the logo two lines below already
 * carries it (href, aria-label), so this renderer's affordance for it is
 * the logo, not a text item; that is markup, which the ruling leaves to
 * each renderer.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_nav_items = ea_canonical_nav_items();
?>
<nav class="nav" id="nav" aria-label="<?php esc_attr_e( 'תפריט ראשי', 'ea-eyalamit' ); ?>">
	<a class="nav__b" href="<?php echo $h( '/' ); ?>" aria-label="<?php esc_attr_e( 'אייל עמית — דף הבית', 'ea-eyalamit' ); ?>">
		<span class="nav__lg" aria-hidden="true"></span>
	</a>

	<?php /* WS-2.2 (A11Y-FIX-2026-09-18): burger moved before .nav__l so DOM/tab order
	matches the open-panel reality at mobile width — Tab from the burger must land inside
	the menu it just opened, not past it. Visual position at both breakpoints is restored
	via `order` in chapters.css (see .nav__burger, mobile media query) since CSS order
	does not affect tab order. See _COMMUNICATION/team_10/A11Y-FIX-2026-09-18/. */ ?>
	<?php /* S007 M-12 (2026-09-20): opens the one shared drawer dialog (ea-nav-drawer.js
	auto-wires any [data-ea-nav-trigger]), not the old .nav__l off-canvas panel. */ ?>
	<button class="nav__burger" type="button" data-ea-nav-trigger aria-label="<?php esc_attr_e( 'תפריט', 'ea-eyalamit' ); ?>" aria-expanded="false">
		<span></span><span></span><span></span>
	</button>

	<ul class="nav__l" role="list">
		<?php foreach ( $ea_nav_items as $ea_item ) : ?>
			<?php if ( 'home' === $ea_item['key'] ) : ?>
				<?php continue; // the logo above already carries this. ?>
			<?php endif; ?>
			<?php $ea_children = isset( $ea_item['children'] ) ? $ea_item['children'] : array(); ?>
			<?php if ( $ea_children ) : ?>
		<li>
			<?php if ( $ea_item['href'] ) : ?>
			<a class="nav__dd" href="<?php echo esc_url( $ea_item['href'] ); ?>"><?php echo esc_html( $ea_item['label'] ); ?><span class="nav__caret" aria-hidden="true">▾</span></a>
			<?php else : ?>
			<button class="nav__dd" type="button" aria-haspopup="true" aria-expanded="false"><?php echo esc_html( $ea_item['label'] ); ?><span class="nav__caret" aria-hidden="true">▾</span></button>
			<?php endif; ?>
			<ul class="nav__sub" role="list">
				<?php foreach ( $ea_children as $ea_child ) : ?>
				<li><a href="<?php echo esc_url( $ea_child['href'] ); ?>"><?php echo esc_html( $ea_child['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</li>
			<?php else : ?>
		<li><a href="<?php echo esc_url( $ea_item['href'] ); ?>"><?php echo esc_html( $ea_item['label'] ); ?></a></li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>

	<div class="nav__r">
		<button class="nav__tg" id="soundtg" type="button" aria-pressed="false" aria-label="<?php esc_attr_e( 'הפעלת קול בסרטון', 'ea-eyalamit' ); ?>">
			<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9 h4 l5-4 v14 l-5-4 H4 z"/><path d="M17 9 a4 4 0 0 1 0 6"/></svg>שמע
		</button>
		<a class="nav__en" href="<?php echo $h( '/en/' ); ?>" hreflang="en" lang="en">EN</a>
	</div>
</nav>
