<?php
/**
 * Template Name: tpl-en-landing (Wave2)
 * D-14 §5 tpl-en-landing — /en LTR landing (WP-W2-10-F elevation).
 *
 * The 8-block LTR composition:
 *   1. topnav (EN, language pill → Hebrew /)        — inline here
 *   2–7. hero → testimonials + closing CTA          — ea_w2_08_render() via the_content
 *   8. footer (EN)                                   — inline here
 *
 * The shared block-topnav / block-footer-social partials are Hebrew-only and
 * may not be edited (D-14 HARD RULE), so the EN nav/footer are rendered here.
 * <html dir="ltr" lang="en"> is set by ea_eyalamit_en_language_attributes()
 * in functions.php; this template owns <main dir="ltr" lang="en">.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<header data-block="topnav">
	<nav class="ea-topnav" aria-label="Primary navigation" dir="ltr">
		<a class="ea-topnav__brand" href="<?php echo esc_url( home_url( '/en' ) ); ?>" aria-label="Eyal Amit — Home">Eyal Amit</a>
		<ul class="ea-topnav__links" role="list">
			<li><a class="ea-topnav__link" href="#hero" aria-current="page">Home</a></li>
			<li><a class="ea-topnav__link" href="#method">The Method</a></li>
			<li><a class="ea-topnav__link" href="#services">Services</a></li>
			<li><a class="ea-topnav__link" href="#books">Books</a></li>
			<li><a class="ea-topnav__link" href="#testimonials">Testimonials</a></li>
		</ul>
		<div class="ea-topnav__controls">
			<a class="ea-lang-pill" href="<?php echo esc_url( home_url( '/' ) ); ?>" hreflang="he" lang="he" aria-label="עברית — switch to Hebrew">עברית</a>
		</div>
	</nav>
</header>
<main id="main" class="ea-wave2-en" lang="en" dir="ltr">
	<?php
	// W2-08: the injected composition carries the single H1 — do NOT print the_title()
	// here (would duplicate the page H1). Content is injected via the the_content
	// filter in inc/wave2-w2-08.php (ea_w2_08_render), keyed on slug `en`.
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	?>
</main>
<footer class="ea-footer" aria-label="Site footer" dir="ltr">
	<div class="ea-footer__inner">
		<p class="ea-footer__brand">Eyal Amit</p>
		<p class="ea-footer__tagline">The Center for Breath Therapy through the Didgeridoo</p>
		<p class="ea-footer__location">Pardes Hanna &middot; Israel</p>
		<nav class="ea-footer__nav" aria-label="Footer navigation">
			<a class="ea-footer__nav-link" href="#method">The Method</a>
			<a class="ea-footer__nav-link" href="#services">Services</a>
			<a class="ea-footer__nav-link" href="#books">Books</a>
			<a class="ea-footer__nav-link" href="#testimonials">Testimonials</a>
			<a class="ea-footer__nav-link" href="#contact">Contact</a>
		</nav>
		<hr class="ea-footer__divider" aria-hidden="true">
		<p class="ea-footer__copy">&copy; 2026 Eyal Amit — The Center for Breath Therapy through the Didgeridoo. All rights reserved.</p>
	</div>
</footer>
<?php
get_footer();
