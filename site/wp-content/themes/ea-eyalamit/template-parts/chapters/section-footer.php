<?php
/**
 * Chapters — footer (multi-column links + brand + social + arcs motif).
 * Column links are template (fixed routes); brand tagline + copyright are editable.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
?>
<?php if ( function_exists( 'ea_chapters_type' ) && 'contact' === ea_chapters_type() ) : ?>
<div class="ea-contact-foot-gap" aria-hidden="true"></div>
<?php endif; ?>
<?php
/* S007 · MANDATE-FOOTER-UNIFY-2026-09-26.md — ONE footer, rendered once,
   from ea_canonical_nav_items() (inc/ea-canonical-nav.php). Replaces both
   the old hardcoded columns above (measured: they had drifted from the tree
   in five places) and this morning's separate sitemap row, which duplicated
   nine of their ten links. 'reveal' => true keeps this page's existing
   sticky-reveal footer behaviour (assets/css/chapters.css .foot.uncover,
   assets/js/ea-chapters.js) — the mandate did not ask to change that, only
   the content/columns/legal styling. */
if ( function_exists( 'ea_render_unified_footer' ) ) {
	ea_render_unified_footer( array( 'reveal' => true ) );
}
?>
