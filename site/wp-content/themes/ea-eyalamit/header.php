<?php
/**
 * כותרת עליונה: GeneratePress כשקיימת; אחרת shell מינימלי לפיתוח בלי תבנית אב במאגר.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$parent_header = get_parent_theme_file_path( 'header.php' );
if ( is_string( $parent_header ) && is_readable( $parent_header ) ) {
	load_template( $parent_header, true );
	return;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="ea-skip-link screen-reader-text" href="#ea-main"><?php esc_html_e( 'דלג לתוכן העמוד', 'ea-eyalamit' ); ?></a>
<div id="page" class="ea-shell">
	<header class="ea-shell-header" role="banner">
		<div class="ea-shell-header__bar" aria-hidden="true"></div>
		<div class="ea-shell-header__inner">
			<div class="ea-shell-header__brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ea-shell-header__logo-link">
					<img
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ea-logo.jpg' ); ?>"
						alt="<?php bloginfo( 'name' ); ?>"
						class="ea-shell-logo"
						width="140"
						height="40"
						loading="eager"
					/>
				</a>
			</div>
			<?php
			$ea_shell_primary_args = array(
				'container'   => false,
				'menu_class'  => 'ea-shell-nav__list',
				'fallback_cb' => false,
				'depth'       => 4,
			);
			$ea_shell_show_primary = has_nav_menu( 'primary' );
			if ( ! $ea_shell_show_primary ) {
				$ea_m2_menu = wp_get_nav_menu_object( 'M2 Primary EA' );
				if ( $ea_m2_menu && ! is_wp_error( $ea_m2_menu ) ) {
					$ea_shell_primary_args['menu'] = (int) $ea_m2_menu->term_id;
					$ea_shell_show_primary         = true;
				}
			} else {
				$ea_shell_primary_args['theme_location'] = 'primary';
			}
			if ( $ea_shell_show_primary ) :
				?>
				<nav class="ea-shell-nav" role="navigation" aria-label="<?php esc_attr_e( 'תפריט ראשי', 'ea-eyalamit' ); ?>">
					<?php wp_nav_menu( $ea_shell_primary_args ); ?>
				</nav>
				<?php
			endif;
			?>
			<?php if ( ! is_page( 'en' ) && ! is_page( 'english' ) ) : ?>
				<div class="ea-shell-header__tools">
					<span class="ea-shell-header__en">
						<a href="<?php echo esc_url( home_url( '/en/' ) ); ?>" hreflang="en" lang="en"><?php esc_html_e( 'EN', 'ea-eyalamit' ); ?></a>
					</span>
				</div>
			<?php endif; ?>
		</div>
	</header>
	<main id="ea-main" class="ea-shell-main" role="main">
