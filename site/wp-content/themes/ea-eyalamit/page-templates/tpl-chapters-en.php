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
html,body{overflow-x:hidden}
/* The theme hides .screen-reader-text with right:-10000px (RTL); on this LTR page
   that lands far-right and forces a ~10000px horizontal overflow — neutralize it. */
.screen-reader-text{position:absolute!important;width:1px!important;height:1px!important;overflow:hidden!important;clip:rect(1px,1px,1px,1px)!important;left:auto!important;right:auto!important;inset-inline-start:0!important}
.screen-reader-text:focus{position:fixed!important;top:8px;inset-inline-start:8px;width:auto!important;height:auto!important;clip:auto!important;padding:10px 16px;background:#fff;z-index:200}
.ea-en-head{position:relative;z-index:50;display:flex;align-items:center;justify-content:space-between;gap:20px;
	max-width:1200px;margin-inline:auto;padding:20px 48px}
.ea-en-head__b{font-family:var(--serif,'Frank Ruhl Libre',serif);font-size:1.2rem;color:var(--ink,#2f2013);text-decoration:none}
.ea-en-head__lang{font-family:var(--bf,'Heebo',sans-serif);font-size:.85rem;color:var(--terra-dk,#9A4F2B);text-decoration:none}
.ea-en-foot{background:var(--dark-grad,#0E0905);color:rgba(255,255,255,.82);padding:48px 48px;text-align:center;font-size:.85rem}
.ea-en-foot a{color:var(--terra-lt,#D08A5E);text-decoration:none}
@media(max-width:600px){.ea-en-head,.ea-en-foot{padding-inline:24px}}
</style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="ea-skip-link screen-reader-text" href="#chapters-main">Skip to content</a>

<header class="ea-en-head">
	<a class="ea-en-head__b" href="/en/">Eyal Amit</a>
	<a class="ea-en-head__lang" href="/">עברית →</a>
</header>

<main id="chapters-main" dir="ltr" style="direction:ltr;text-align:left">
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
			<p class="lead r" style="margin-top:14px">Reach out on WhatsApp to ask a question or arrange a short introductory call.</p>
			<p style="margin-top:28px"><a class="btn btn--terra" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener noreferrer">Talk on WhatsApp</a></p>
			<p style="margin-top:14px">Or call/WhatsApp <a href="tel:+972524822842" dir="ltr">+972-52-482-2842</a> directly.</p>
		</div>
	</section>
</main>

<footer class="ea-en-foot">
	<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Eyal Amit · The Didgeridoo Breath Center · Pardes Hanna, Israel · <a href="tel:+972524822842" dir="ltr">052-4822842</a></p>
	<p><a href="/">לאתר העברי / Hebrew site</a></p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
