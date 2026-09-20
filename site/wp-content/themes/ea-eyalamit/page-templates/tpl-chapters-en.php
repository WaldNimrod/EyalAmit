<?php
/**
 * Template Name: פרקים — EN landing (Chapters, LTR)
 *
 * English landing in the Chapters look — LTR, a self-contained minimal English
 * header/footer (NOT the Hebrew section-nav), reusing only proven Chapters atoms
 * (.phero / .sec / .wrap / .btn). PLACEHOLDER English copy — the final terse
 * English summary is pending Eyal (D-EYAL-EN-BODY-02, logged in the HUB).
 * Self-contained doc → keeps wp_head/wp_footer (SEO, hreflang, analytics).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
$wa = function_exists( 'ea_wave2_wa_url' ) ? ea_wave2_wa_url( 'Hi Eyal, I found you through the English page' ) : 'https://wa.me/972524822842';
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
				<?php if ( $ea_en_child['href'] === $ea_en_item['href'] ) : ?>
					<?php continue; // a self-referencing overview row (e.g. shop, treatment) — already linked above as the parent. ?>
				<?php endif; ?>
		<a href="<?php echo esc_url( $ea_en_child['href'] ); ?>"><?php echo esc_html( $ea_en_child['label'] ); ?></a>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</nav>
	<a class="ea-en-head__lang" href="/">עברית →</a>
</header>

<main id="main" class="chapters-main" tabindex="-1" dir="ltr" style="direction:ltr;text-align:left">
	<div class="wrap"><p class="ea-pending-inline ea-pending-inline--wide" role="status">
		<span>Draft — English summary is a team draft awaiting Eyal's approval before launch (WP-EI-06) · טיוטה צוותית באנגלית הממתינה לאישור אייל</span>
	</p></div>
	<?php
	get_template_part( 'template-parts/chapters/parts/phero', null, array(
		'chap'      => 'Didgeridoo &amp; Breath',
		'title'     => 'Eyal <em>Amit</em>',
		'sub'       => 'Didgeridoo-based breath work, sound healing and lessons — Pardes Hanna, Israel.',
		'media'     => ea_chapters_asset_url( 'assets/images/chapters/eyal-window.jpg' ),
		'media_alt' => 'Eyal Amit playing the didgeridoo',
		'cta_label' => 'Talk on WhatsApp',
		'cta_url'   => $wa,
	) );
	?>

	<section class="sec" style="direction:ltr;text-align:left">
		<div class="wrap">
			<span class="chap r">About</span>
			<h2 class="h2 r">Working with breath through the didgeridoo</h2>
			<div class="intro-body r" style="text-align:left">
				<p>Eyal Amit has worked with the didgeridoo and breath since 1999. Over more than two decades of teaching, therapy, instrument-making and study — in Israel and abroad — he developed <strong>cbDIDG</strong>, a structured method that uses the didgeridoo as a practical tool for working with everyday breathing.</p>
				<p>The method took shape gradually, growing out of Eyal's own study of breath — motivated in part by his own asthma — his apprenticeship with Mukesh Dahiman, and later study of body-breath disciplines such as tai chi, qigong, yoga and mindfulness. It rests on three principles: active work, not a passive experience; playing the didgeridoo is the practice tool, not the goal itself; and a cumulative process, not a one-time session.</p>
				<p>The core idea is simple: the didgeridoo is not the goal — it is a working tool. Through it, and with personal guidance, one can develop deeper breath awareness, improve breathing patterns and ease symptoms linked to chronic stress. Sessions take place one-on-one at the studio in Pardes Hanna, Israel.</p>
				<p>The full site is in Hebrew — <a class="tlink" href="/">visit the Hebrew site →</a></p>
			</div>
		</div>
	</section>

	<section class="sec sec--alt" style="direction:ltr;text-align:left">
		<div class="wrap">
			<span class="chap r">The Lineage</span>
			<h2 class="h2 r">Mukesh Dahiman</h2>
			<div class="intro-body r" style="text-align:left">
				<p>Eyal met Mukesh Dahiman — a didgeridoo-maker and teacher from Rishikesh, India — in 2000, and became one of his close students. What he carries forward is a patient, hands-on way of working rooted in listening to the breath.</p>
				<p>Mukesh passed away in October 2020. His teaching lives on through his students, Eyal among them.</p>
			</div>
		</div>
	</section>

	<section class="sec sec--alt" style="direction:ltr;text-align:left">
		<div class="wrap">
			<span class="chap r">What I offer</span>
			<h2 class="h2 r">Ways to work together</h2>
			<div class="intro-body r" style="text-align:left">
				<p><strong>Didgeridoo breath therapy</strong> — active, personal work with everyday breathing, sound and body awareness.</p>
				<p><strong>Private sound healing</strong> — a quiet personal journey in sound and vibration; a time to stop, listen and let the sound work.</p>
				<p><strong>Didgeridoo lessons</strong> — learn to play from scratch, including circular breathing, at your own pace.</p>
				<p><strong>Talks &amp; workshops</strong> — group breath-and-sound sessions for teams, events and organizations.</p>
				<p>To ask a question or arrange an introductory call, reach out on WhatsApp below.</p>
			</div>
		</div>
	</section>

	<section class="sec" style="direction:ltr;text-align:left">
		<div class="wrap center">
			<h2 class="h2 r">Get in touch</h2>
			<p style="margin-top:14px">Or call/WhatsApp <a href="tel:<?php echo esc_attr( ea_nap( 'phone_href' ) ); ?>" dir="ltr"><?php echo esc_html( ea_nap( 'phone_schema' ) ); ?></a> directly.</p>
		</div>
	</section>
</main>

<footer class="ea-en-foot">
	<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Eyal Amit · The Didgeridoo Breath Center · Pardes Hanna, Israel · <a href="tel:<?php echo esc_attr( ea_nap( 'phone_href' ) ); ?>" dir="ltr"><?php echo esc_html( ea_nap( 'phone_schema' ) ); ?></a></p>
	<p><a href="/">לאתר העברי / Hebrew site</a></p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
