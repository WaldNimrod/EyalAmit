<?php
/**
 * The ONE mobile navigation drawer — server-rendered <dialog>, S007 M-12.
 *
 * @param array $args {
 *     @type array  $items      Nav tree: array of array('key','label','href'|null,'children'=>array(array('label','href','external'=>bool))).
 *     @type array  $foot_links Secondary footer links: array(array('href','label')).
 * }
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$items      = isset( $args['items'] ) ? $args['items'] : array();
$foot_links = isset( $args['foot_links'] ) ? $args['foot_links'] : array();
$current    = isset( $args['active'] ) ? $args['active'] : '';
$ea_he      = function_exists( 'ea_open_round_he_attr' ) ? ea_open_round_he_attr() : '';
?>
<dialog class="ea-nd" id="ea-nav-drawer"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput — static lang/dir attr ?> aria-label="<?php esc_attr_e( 'תפריט ראשי', 'ea-eyalamit' ); ?>">
	<div class="ea-nd__head">
		<a class="ea-nd__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php esc_html_e( 'המרכז לטיפול בדיג׳רידו', 'ea-eyalamit' ); ?></a>
		<button class="ea-nd__close" type="button" aria-label="<?php esc_attr_e( 'סגירת תפריט', 'ea-eyalamit' ); ?>">&times;</button>
	</div>

	<ul class="ea-nd__list" role="list">
		<?php /* team_00 addendum, 2026-09-24: explicit monochrome home icon, first
		row (right-most in RTL) — reuses .ea-nd__link's own row styling, no new
		CSS. See inc/ea-canonical-nav.php ea_canonical_nav_home_link(). */ ?>
		<li class="ea-nd__item"><?php echo ea_canonical_nav_home_link( 'ea-nd__link', $ea_he ); // phpcs:ignore WordPress.Security.EscapeOutput — built with esc_url()/esc_attr() inside ea_canonical_nav_home_link() ?></li>
		<?php foreach ( $items as $item ) : ?>
			<?php ea_nav_drawer_render_item( $item, $current, $ea_he ); // recursive — see inc/ea-nav-drawer.php ?>
		<?php endforeach; ?>
	</ul>

	<div class="ea-nd__foot">
		<div class="ea-nd__foot-utils">
			<a class="ea-nd__pill" href="<?php echo esc_url( home_url( '/en/' ) ); ?>" lang="en" aria-label="English — switch to English">EN</a>
		</div>
		<div class="ea-nd__foot-links">
			<?php foreach ( $foot_links as $fl ) : ?>
			<a href="<?php echo esc_url( $fl['href'] ); ?>"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $fl['label'] ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</dialog>
