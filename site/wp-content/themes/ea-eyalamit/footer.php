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
			/* S007 · MANDATE-FOOTER-SITEMAP-ROW-2026-09-26.md — second footer
			   row, only reached if the GeneratePress parent theme is ever
			   unreadable (this whole branch is otherwise dormant — see
			   ea_eyalamit_enqueue_theme_shell_fallback() in functions.php).
			   Kept in step with the other three render paths regardless. */
			if ( function_exists( 'ea_render_canonical_nav_footer_sitemap' ) ) {
				ea_render_canonical_nav_footer_sitemap();
			}
			?>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
