<?php
/**
 * Template Name: פרקים — EN landing (Chapters, LTR)
 *
 * English landing in the Chapters look — LTR, a self-contained English
 * header/footer (NOT the Hebrew section-nav), reusing Chapters atoms.
 * Body copy: Eyal C3 (2026-09-21). Draft banner WP-EI-06 removed.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
?><!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php wp_head(); ?>
<style>
/* Scoped to the EN landing — minimal LTR header/footer + overflow guard. */
/* The `html,body{overflow-x:hidden}` guard that used to be here is REMOVED (20.9.2026).
   It was added for the far-right skip-link that forced a ~10000px overflow — and the rule
   below actually fixes that, so the guard had been doing nothing for a while. Measured on
   live /en/ at 390 and 1440 with the guard forced off: scrollWidth === innerWidth, delta 0
   at both. What it WAS still doing is hiding any future overflow, which turns a real bug
   into a silent one: a page that cannot scroll sideways because it was told not to is not
   a page that passes. The decorative span.arcs still extends past the viewport and is
   clipped by its own container, which is the correct way to do that. */
/* The theme hides .screen-reader-text with right:-10000px (RTL); on this LTR page
   that lands far-right and forces a ~10000px horizontal overflow — neutralize it. */
.screen-reader-text{position:absolute!important;width:1px!important;height:1px!important;overflow:hidden!important;clip:rect(1px,1px,1px,1px)!important;left:auto!important;right:auto!important;inset-inline-start:0!important}
.screen-reader-text:focus{position:fixed!important;top:8px;inset-inline-start:8px;width:auto!important;height:auto!important;clip:auto!important;padding:10px 16px;background:#fff;z-index:200}
.ea-en-head{position:relative;z-index:50;display:flex;align-items:center;justify-content:space-between;gap:20px;
	max-width:1200px;margin-inline:auto;padding:20px 48px}
.ea-en-head__b{font-family:var(--bf,'Heebo',sans-serif);font-size:1.2rem;color:var(--ink,#2f2013);text-decoration:none}/* S007 M-07: was var(--serif,...) — nobody had decided this brand link should differ from .ea-en-head__lang beside it */
.ea-en-head__lang{font-family:var(--bf,'Heebo',sans-serif);font-size:.85rem;color:var(--terra-dk,#9A4F2B);text-decoration:none}
.ea-en-foot{background:var(--dark-grad,#0E0905);color:rgba(255,255,255,.82);padding:48px 48px;text-align:center;font-size:.85rem}
.ea-en-foot a{color:var(--terra-lt,#D08A5E);text-decoration:none}
@media(max-width:600px){.ea-en-head,.ea-en-foot{padding-inline:24px}}
@media(max-width:1023px){.ea-en-head{padding-inline-start:72px}}
/* S007 M-13 (2026-09-20): team_00 — «אנגלית - יש להוסיף לתפריט». /en/ was the
   only published URL rendering no navigation at all. Canonical items, canonical
   (Hebrew) labels — team_00 has not ruled on translating them, so this does not
   invent English ones; each label is its own RTL run inside this LTR page,
   which the browser's own bidi handling renders correctly without dir="rtl"
   reversing the (LTR) item order. Desktop only — mobile already gets the one
   shared drawer via the universal hooks in inc/ea-nav-drawer.php (unchanged,
   verified in M-12 Phase A). Hidden below 1024px, same breakpoint as every
   other desktop bar in this theme; the drawer is the mobile path here too. */
.ea-en-nav{display:flex;flex-wrap:wrap;gap:4px 18px;font-family:var(--bf,'Heebo',sans-serif);font-size:.85rem}
.ea-en-nav a{color:var(--ink,#2f2013);text-decoration:none}
.ea-en-nav a:hover,.ea-en-nav a:focus-visible{color:var(--terra-dk,#9A4F2B)}
@media(max-width:1023px){.ea-en-nav{display:none}}
</style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="ea-en-head">
	<a class="ea-en-head__b" href="/en/">Eyal Amit</a>
	<?php
	/*
	 * Flattened, not nested: this header has no dropdown affordance of its
	 * own to build one-off for a single draft page, and "identical item
	 * set... targets" has to mean every target is reachable, not only the
	 * top-level ones. A parent with no href of its own (learning, eyal-amit)
	 * renders no link for itself — it never had a destination — but its
	 * children still appear.
	 */
	?>
	<nav class="ea-en-nav" aria-label="Main">
		<?php foreach ( ea_canonical_nav_items() as $ea_en_item ) : ?>
			<?php if ( 'home' === $ea_en_item['key'] ) : ?>
				<?php continue; // the brand link above already carries this. ?>
			<?php endif; ?>
			<?php if ( $ea_en_item['href'] ) : ?>
		<a href="<?php echo esc_url( $ea_en_item['href'] ); ?>"><?php echo esc_html( $ea_en_item['label'] ); ?></a>
			<?php endif; ?>
			<?php foreach ( ( $ea_en_item['children'] ?? array() ) as $ea_en_child ) : ?>
				<?php if ( ! empty( $ea_en_child['hidden'] ) ) : ?>
					<?php continue; // same exclusion as the Hebrew nav — Eyal 2026-09-24, /learning/courses-external/ stays out. ?>
				<?php endif; ?>
				<?php if ( $ea_en_child['href'] === $ea_en_item['href'] ) : ?>
					<?php continue; // a self-referencing overview row (e.g. shop, treatment) — already linked above as the parent. ?>
				<?php endif; ?>
		<a href="<?php echo esc_url( $ea_en_child['href'] ); ?>"><?php echo esc_html( $ea_en_child['label'] ); ?></a>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</nav>
	<a class="ea-en-head__lang" href="/" lang="he">עברית →</a>
</header>

<main id="main" class="chapters-main" tabindex="-1" dir="ltr" style="direction:ltr;text-align:left">
	<?php
	$ea_phero = function_exists( 'ea_chapters_phero_overlay' ) ? ea_chapters_phero_overlay() : array();
	get_template_part( 'template-parts/chapters/parts/phero', null, $ea_phero );

	$ea_sections = function_exists( 'ea_chapters_page_sections' ) ? ea_chapters_page_sections() : array();
	foreach ( $ea_sections as $ea_s ) {
		if ( empty( $ea_s['part'] ) ) {
			continue;
		}
		$ea_args = isset( $ea_s['args'] ) && is_array( $ea_s['args'] ) ? $ea_s['args'] : array();
		get_template_part( 'template-parts/chapters/parts/' . $ea_s['part'], null, $ea_args );
	}
	?>
</main>

<footer class="ea-en-foot">
	<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Eyal Amit · The Didgeridoo Breath Center · Pardes Hanna, Israel · <a href="tel:<?php echo esc_attr( ea_nap( 'phone_href' ) ); ?>" dir="ltr"><?php echo esc_html( ea_nap( 'phone_schema' ) ); ?></a></p>
	<p><a href="/"><span lang="he">לאתר העברי</span> / Hebrew site</a></p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
