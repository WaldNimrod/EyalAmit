<?php
/**
 * Block: footer-social — D-14/POC Wave2 call site.
 *
 * S007 · MANDATE-FOOTER-UNIFY-2026-09-26.md: this used to carry its own
 * bespoke .ea-cfoot markup (a fourth hand-maintained copy of the nav tree,
 * measured to have drifted from ea_canonical_nav_items()). It now just
 * calls the ONE unified footer — same function, same markup, same CSS as
 * every other render path in this theme. This file stays only because its
 * call sites (page-templates/tpl-content.php, tpl-blog-archive.php,
 * tpl-blog-single.php, tpl-qr.php) already call it by this name.
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

/* MANDATE-FOOTER-ONE-PATH-2026-09-27 / MANDATE-INVOCATION-DEDUP-2026-09-27 —
   footer markup is rendered once on wp_footer (ea_render_unified_footer_wp_hook).
   This partial has zero call sites; kept so existing template names stay stable. */
