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

/* Two callers can print this partial in one request (wp_body_open plus the
   template). A second call returns no markup. Items and order stay as they are. */
if ( ! function_exists( 'ea_chapters_nav_mark_once' ) ) {
	/**
	 * True the first time the primary nav is printed in this request.
	 *
	 * @return bool
	 */
	function ea_chapters_nav_mark_once() {
		static $done = false;
		if ( $done ) {
			return false;
		}
		$done = true;
		return true;
	}
}
if ( ! ea_chapters_nav_mark_once() ) {
	return;
}

/* The M-13 rewrite removed this file's local `$h = fn($path) => esc_url(home_url($path))`
   helper along with the hand-coded item list, but two call sites survived it — the logo
   href and the EN link — and `$h('/')` on an undefined variable is a fatal, not a notice.
   It took down every Chapters page on 1.5.90. Both now call esc_url(home_url()) directly
   so there is no local helper left to lose. Third time a deletion in this theme has taken
   a neighbouring assignment with it; see the memory note on regex deletions. */

$ea_nav_items = ea_canonical_nav_items();
$ea_he        = function_exists( 'ea_open_round_he_attr' ) ? ea_open_round_he_attr() : '';
?>
<nav class="nav" id="nav"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput — static lang/dir attr ?> aria-label="<?php esc_attr_e( 'תפריט ראשי', 'ea-eyalamit' ); ?>">
	<a class="nav__b" href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?> aria-label="<?php esc_attr_e( 'המרכז לטיפול בדיג׳רידו — דף הבית', 'ea-eyalamit' ); ?>">
		<span class="nav__lg" aria-hidden="true"></span>
		<span class="nav__wm" aria-hidden="true"><?php esc_html_e( 'המרכז לטיפול בדיג׳רידו', 'ea-eyalamit' ); ?></span>
	</a>

	<?php /* WS-2.2 / DA-NAV-01 (2026-09-21): burger before .nav__l so DOM/tab order
	still reaches the drawer trigger before L1 (tab order unaffected by CSS order).
	At mobile width chapters.css places burger at inline-start and logo at inline-end
	via order — physical right in RTL, left in LTR. Desktop DOM unchanged: logo | L1 | EN. */ ?>
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
			<a class="nav__dd" href="<?php echo esc_url( $ea_item['href'] ); ?>" aria-haspopup="true" aria-expanded="false"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $ea_item['label'] ); ?><span class="nav__caret" aria-hidden="true">▾</span></a>
			<?php else : ?>
			<button class="nav__dd" type="button" aria-haspopup="true" aria-expanded="false"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $ea_item['label'] ); ?><span class="nav__caret" aria-hidden="true">▾</span></button>
			<?php endif; ?>
			<ul class="nav__sub" role="list">
				<?php foreach ( $ea_children as $ea_child ) : ?>
					<?php if ( ! empty( $ea_child['hidden'] ) ) : ?>
						<?php continue; // S007 M-14: real page, kept in the tree, not rendered (content not ready). ?>
					<?php endif; ?>
				<li><a href="<?php echo esc_url( $ea_child['href'] ); ?>"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $ea_child['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</li>
			<?php else : ?>
		<li><a href="<?php echo esc_url( $ea_item['href'] ); ?>"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $ea_item['label'] ); ?></a></li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>

	<div class="nav__r">
		<a class="nav__en" href="<?php echo esc_url( home_url( '/en/' ) ); ?>" hreflang="en" lang="en">EN</a>
	</div>
</nav>
