<?php
/**
 * פוטר: GeneratePress כשקיימת; אחרת shell מינימלי.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$parent_footer = get_parent_theme_file_path( 'footer.php' );
if ( is_string( $parent_footer ) && is_readable( $parent_footer ) ) {
	load_template( $parent_footer, true );
	return;
}
?>
	</main>
	<footer class="ea-shell-footer" role="contentinfo">
		<div class="ea-shell-footer__inner">
			<p class="ea-shell-footer__brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</p>
			<?php
			if ( has_nav_menu( 'ea_footer_legal' ) ) {
				ea_eyalamit_render_footer_legal_nav();
			}
			?>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
