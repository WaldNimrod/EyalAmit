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
			/* S007 · MANDATE-FOOTER-UNIFY-2026-09-26.md — the ONE footer,
			   only reached here if the GeneratePress parent theme is ever
			   unreadable (this whole branch is otherwise dormant — see
			   ea_eyalamit_enqueue_theme_shell_fallback() in functions.php;
			   the live/staging case reaches the same function via the
			   wp_footer safety net at the end of inc/ea-canonical-nav.php
			   instead, since it's the parent's own footer.php that runs).
			   Kept in step with the other three render paths regardless. */
			if ( function_exists( 'ea_render_unified_footer' ) ) {
				ea_render_unified_footer();
			}
			?>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
