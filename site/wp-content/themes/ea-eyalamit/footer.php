<?php
/**
 * פוטר: GeneratePress כשקיימת; אחרת shell מינימלי.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$parent_footer = get_parent_theme_file_path( 'footer.php' );
if ( is_string( $parent_footer ) && is_readable( $parent_footer ) ) {
	/*
	 * S007 · MANDATE-FOOTER-UNIFY-2026-09-26.md — GeneratePress's own
	 * "site-info" credits bar must not render next to this theme's unified
	 * footer (that exact pairing was one source of /press/ painting two
	 * footer landmarks in one request). functions.php filters
	 * generate_show_footer / generate_show_credits to false, but measured
	 * live 2026-09-26: this GeneratePress version still rendered the bar —
	 * neither filter gates it. The parent theme's own footer.php is not in
	 * this repo (installed on the server, not vendored), so there is no
	 * source to fix directly or a hook name to trust; buffering this
	 * theme's own delegation point and stripping that one element is the
	 * one place this can be done reliably without editing parent files.
	 * ea_render_unified_footer()'s own wp_footer hook (inc/ea-canonical-nav.php)
	 * still fires inside this buffer (wp_footer() is called from within the
	 * parent's own footer.php), so it is captured and re-emitted unchanged —
	 * only the site-info element is removed.
	 */
	ob_start();
	load_template( $parent_footer, true );
	$ea_gp_footer_html = (string) ob_get_clean();
	$ea_gp_footer_html = preg_replace(
		'#<footer\b[^>]*\bclass="[^"]*\bsite-info\b[^"]*"[^>]*>.*?</footer>#s',
		'',
		$ea_gp_footer_html,
		1
	);
	echo $ea_gp_footer_html; // phpcs:ignore WordPress.Security.EscapeOutput -- GeneratePress's own trusted template output, only regex-stripped above.
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
			/* S007 · MANDATE-FOOTER-UNIFY-2026-09-26.md — the ea_footer_legal
			   catalogs/legal nav is no longer called here either (see the
			   unhook + comment on its add_action in functions.php): it
			   duplicated links this branch's own ea_render_unified_footer()
			   call below now carries. */
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
