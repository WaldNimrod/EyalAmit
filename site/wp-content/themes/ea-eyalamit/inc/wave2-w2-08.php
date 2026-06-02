<?php
/**
 * WP-W2-08 — English Landing Page (/en) content injection, hreflang, assets.
 *
 * Mirrors the W2-04/05 pattern: the /en page uses tpl-en-landing.php (a thin
 * shell that renders the_content() only) and FTP deploy cannot write
 * post_content. The 6-section EN landing HTML is therefore injected via a
 * the_content filter @ priority 9, keyed on the `en` page slug and guarded by
 * is_main_query() && in_the_loop().
 *
 * Content is used VERBATIM from the approved team_30 artifact
 * (_COMMUNICATION/team_30/W2-08-EN-CONTENT-2026-05-28.md). The builder MUST NOT
 * author, translate, or rewrite marketing copy here (AC-02). This is an English
 * summary of the Hebrew site, not a full translation.
 *
 * hreflang (B03): emitted on /en (en + he→/ + x-default→/) and reciprocally on
 * the HE homepage (page_on_front=16). See ea_w2_08_hreflang().
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * True when the current request is the /en landing page (slug `en`, top-level).
 *
 * @return bool
 */
function ea_w2_08_is_en_page() {
	if ( ! is_page() ) {
		return false;
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) ) {
		return false;
	}
	return 'en' === $post->post_name && 0 === (int) $post->post_parent;
}

/**
 * Mark /en as a Wave2 active view for Stage-B asset hygiene.
 */
add_action( 'template_redirect', function () {
	if ( ea_w2_08_is_en_page() ) {
		set_query_var( 'ea_wave2_shell', true );
	}
} );

/**
 * Body classes: ea-wave2-shell + ea-en-landing.
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_w2_08_body_class( $classes ) {
	if ( ! ea_w2_08_is_en_page() ) {
		return $classes;
	}
	if ( ! in_array( 'ea-wave2-shell', $classes, true ) ) {
		$classes[] = 'ea-wave2-shell';
	}
	$classes[] = 'ea-en-landing';
	return $classes;
}
add_filter( 'body_class', 'ea_w2_08_body_class', 102 );

/**
 * No sidebar on /en.
 *
 * @param string $layout
 * @return string
 */
function ea_w2_08_sidebar_layout( $layout ) {
	if ( ea_w2_08_is_en_page() ) {
		return 'no-sidebar';
	}
	return $layout;
}
add_filter( 'generate_sidebar_layout', 'ea_w2_08_sidebar_layout', 103 );

/**
 * Hide GeneratePress content title on /en — the hero block carries the single H1.
 *
 * @param bool $show
 * @return bool
 */
function ea_w2_08_hide_gp_title( $show ) {
	if ( ea_w2_08_is_en_page() ) {
		return false;
	}
	return $show;
}
add_filter( 'generate_show_title', 'ea_w2_08_hide_gp_title', 103 );

/**
 * Enqueue W2-08 CSS on /en.
 */
function ea_w2_08_assets() {
	if ( is_admin() || ! ea_w2_08_is_en_page() ) {
		return;
	}
	$uri = get_stylesheet_directory_uri();
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style(
		'ea-w2-08-en-landing',
		$uri . '/assets/css/w2-08-en-landing.css',
		array( 'ea-eyalamit-style' ),
		$ver
	);
}
add_action( 'wp_enqueue_scripts', 'ea_w2_08_assets', 28 );

/**
 * hreflang contract (B03). Emit reciprocal en↔he + x-default alternates on /en
 * and on the HE homepage (page_on_front).
 */
function ea_w2_08_hreflang() {
	$home    = trailingslashit( home_url( '/' ) );
	$en      = trailingslashit( home_url( '/en' ) );
	$front_id = (int) get_option( 'page_on_front', 0 );

	$emit = false;
	if ( ea_w2_08_is_en_page() ) {
		$emit = true;
	} elseif ( $front_id > 0 && is_page( $front_id ) && is_front_page() ) {
		$emit = true;
	}
	if ( ! $emit ) {
		return;
	}

	printf( '<link rel="alternate" hreflang="en" href="%s" />' . "\n", esc_url( $en ) );
	printf( '<link rel="alternate" hreflang="he" href="%s" />' . "\n", esc_url( $home ) );
	printf( '<link rel="alternate" hreflang="x-default" href="%s" />' . "\n", esc_url( $home ) );
}
add_action( 'wp_head', 'ea_w2_08_hreflang', 5 );

/**
 * Inject the 6-section EN landing HTML into the_content on /en.
 *
 * @param string $content
 * @return string
 */
function ea_w2_08_inject_content( $content ) {
	if ( ! is_main_query() || ! in_the_loop() ) {
		return $content;
	}
	if ( ! ea_w2_08_is_en_page() ) {
		return $content;
	}
	return ea_w2_08_render();
}
add_filter( 'the_content', 'ea_w2_08_inject_content', 9 );

/**
 * Primary CTA URL — /contact?lang=en (subject auto-set on the contact page).
 *
 * @return string
 */
function ea_w2_08_cta_url() {
	return home_url( '/contact?lang=en' );
}

/**
 * Render the full /en landing page composition.
 *
 * WP-W2-10-F (S1.5 elevation, 2026-06-02): the elevated 8-block LTR
 * composition. Blocks 2–7 (hero → testimonials + closing CTA) are emitted here
 * and injected via the_content; the EN topnav (block 1) and EN footer (block 8)
 * live in page-templates/tpl-en-landing.php because the shared topnav/footer
 * partials are Hebrew-only and may not be edited (D-14 HARD RULE).
 *
 * Copy is VERBATIM EN, trimmed to the elevated mockup
 * (_COMMUNICATION/team_35/WP-W2-10-F/elevation/mockup/en-landing.html),
 * sourced from the approved team_30 artifact W2-08-EN-CONTENT-2026-05-28.md.
 * Testimonials trimmed 8→4 for pacing (full set in $testimonials below,
 * commented for re-sync if Eyal prefers all — see LOD400 §8).
 *
 * @return string
 */
function ea_w2_08_render() {
	$cta      = ea_w2_08_cta_url();
	$covers   = get_stylesheet_directory_uri() . '/assets/images';
	ob_start();
	?>
	<div class="ea-en">

		<!-- ── Block 2 — Hero (elevation: kicker + layered gradient + breath lines) ── -->
		<section id="hero" class="ea-en-hero" data-block="hero" aria-label="The Center for Breath Therapy through the Didgeridoo">
			<span class="ea-en-hero__line ea-en-hero__line--1" aria-hidden="true"></span>
			<span class="ea-en-hero__line ea-en-hero__line--2" aria-hidden="true"></span>
			<div class="ea-en-hero__content">
				<p class="ea-en-hero__kicker">The Center for Breath Therapy · Pardes Hanna, Israel</p>
				<h1 class="ea-en-hero__title">Breath therapy through the didgeridoo — the cbDIDG method</h1>
				<p class="ea-en-hero__subhead">Regaining control of your breath through active work with the didgeridoo, breathing practice, and personal guidance — a method built over two decades and inspired by an apprenticeship with master Mookesh Dhiman.</p>
				<p class="ea-en-hero__trust">Eyal Amit · Active since 1999 · One of Israel's most experienced practitioners · Teaches, treats, and builds instruments by hand.</p>
				<div class="ea-en-hero__cta-wrap">
					<a class="ea-cta-pill ea-cta-pill--ghost-white" href="<?php echo esc_url( $cta ); ?>">Schedule an introductory call</a>
				</div>
			</div>
		</section>

		<!-- ── Block 3 — About ── -->
		<section class="ea-en-section" data-block="about" aria-labelledby="h-about">
			<div class="ea-en-section__inner">
				<p class="ea-en-section__label">About</p>
				<h2 id="h-about" class="ea-en-section__heading">About Eyal</h2>
				<div class="ea-en-prose">
					<p>Eyal Amit has worked with the didgeridoo since 1999 and is one of the most experienced practitioners of the instrument in Israel.</p>
					<p>He founded the Center for Breath Therapy — a circular-breathing studio in Pardes Hanna — to teach the didgeridoo as a tool with a real therapeutic effect on the body, the breath, and the mind. Over the years he has guided hundreds of people and developed the cbDIDG method, combining hands-on experience with ongoing inquiry.</p>
					<p>Eyal is also an author and independent publisher. A former electronics engineer and stage performer, he created the long-running storytelling show &ldquo;One-Man Phenomenon,&rdquo; and for more than two decades has worked with the didgeridoo as a teacher, instrument builder, and breath therapist.</p>
				</div>
			</div>
		</section>

		<!-- ── Block 4 — Method (cbDIDG) — alt + scannable principles list ── -->
		<section id="method" class="ea-en-section ea-en-section--alt" data-block="method" aria-labelledby="h-method">
			<div class="ea-en-section__inner">
				<p class="ea-en-section__label">cbDIDG</p>
				<h2 id="h-method" class="ea-en-section__heading">The Method</h2>
				<div class="ea-en-prose">
					<p><strong>cbDIDG</strong> is a structured method for working with the breath through playing the didgeridoo, guided one-on-one. The didgeridoo is not the goal — it is the tool through which you learn to work with your everyday breathing: to strengthen it, regulate it, and regain control over it.</p>
					<p><strong>Three principles guide the method:</strong></p>
					<ul class="ea-en-list">
						<li><strong>Active work.</strong> Unlike the passive experience of sound healing, you actively build control over your own breath through playing and consistent practice.</li>
						<li><strong>A clear distinction</strong> between the circular-breathing technique used while playing and everyday breathing. Playing is the practice tool; the aim is lasting change.</li>
						<li><strong>Process, not a moment.</strong> Gradual work built on practice, persistence, and depth — working toward the long term.</li>
					</ul>
					<p>The method grew from a personal journey — a deep study of the breath while coping with severe asthma — and from a long relationship with the Indian didgeridoo master <strong>Mookesh Dhiman</strong>, which began in 2000.</p>
				</div>
			</div>
		</section>

		<!-- ── Block 5 — Services (3 paths) ── -->
		<section id="services" class="ea-en-section" data-block="services" aria-labelledby="h-services">
			<div class="ea-en-section__inner">
				<p class="ea-en-section__label">Services</p>
				<h2 id="h-services" class="ea-en-section__heading">Three paths through one instrument</h2>
				<div class="ea-en-prose">
					<p><strong>Didgeridoo Therapy.</strong> Active, process-based work with the breath, in which you learn to strengthen and regulate your own breathing system — with a lasting effect. Sessions are private and one-on-one, in a quiet studio.</p>
					<p><strong>Sound Healing.</strong> A private journey in sound and frequency for individuals or couples, without touch. You rest comfortably while Eyal holds the space with the didgeridoo and additional frequency instruments — the vibration moving through the body like a gentle inner massage.</p>
					<p><strong>Didgeridoo Lessons.</strong> A focused learning path: developing playing skill, mastering the circular-breathing technique, and refining sound — fully private, structured for individual progress.</p>
				</div>
				<div class="ea-en-section__cta-wrap">
					<a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( $cta ); ?>">Schedule an introductory call</a>
				</div>
			</div>
		</section>

		<!-- ── Block 6 — Books (elevation: real cover row) ── -->
		<section id="books" class="ea-en-section ea-en-section--alt" data-block="books" aria-labelledby="h-books">
			<div class="ea-en-section__inner">
				<p class="ea-en-section__label">Muzza Publishing</p>
				<h2 id="h-books" class="ea-en-section__heading">Books</h2>
				<div class="ea-en-books-row">
					<img src="<?php echo esc_url( $covers . '/tsva-bechol-cover.jpg' ); ?>" alt="Paint It Blue and Throw It to the Sea — cover" width="128" height="171" loading="lazy">
					<img src="<?php echo esc_url( $covers . '/kushi-blantis-cover.jpg' ); ?>" alt="Kushi Blantis — cover" width="128" height="171" loading="lazy">
					<img src="<?php echo esc_url( $covers . '/vekatavt-cover.jpg' ); ?>" alt="And You Shall Write — cover" width="128" height="171" loading="lazy">
				</div>
				<div class="ea-en-prose">
					<p><strong>Muzza Publishing</strong> is an independent press founded in 2004 by author and storyteller Eyal Amit — home to his travel writing, fantasy, and inspiring personal stories. Buying directly from the creator means the support reaches the author almost in full, so the books are offered here at a lower, fairer price.</p>
					<ul class="ea-en-list">
						<li><strong>Paint It Blue and Throw It to the Sea</strong> — 38 short, kicking stories from a journey through South America. First published 2001, now in its tenth edition.</li>
						<li><strong>Kushi Blantis</strong> — a fantasy novel about awakening, choice, and stepping out of a life grown too comfortable. Published 2004, sixth edition.</li>
						<li><strong>And You Shall Write</strong> — 46 true stories about love, journeys, loss, change, and growth. Published 2017, with a QR element extending the reading beyond the page.</li>
					</ul>
					<p><strong>The three-book bundle</strong> brings all three together at a special price — a great way to get to know Eyal's writing, and an original gift.</p>
				</div>
			</div>
		</section>

		<!-- ── Block 7 — Testimonials (trimmed 8→4) + closing CTA ── -->
		<section id="testimonials" class="ea-en-section ea-en-section--testimonials" data-block="testimonials" aria-labelledby="h-testi">
			<div class="ea-en-section__inner">
				<p class="ea-en-section__label">Testimonials</p>
				<h2 id="h-testi" class="ea-en-section__heading">What people say about the work</h2>
				<p class="ea-en-testimonials__note">(translated from the original Hebrew testimonials)</p>
				<div class="ea-en-testimonials">
					<?php
					// Elevated set: 4 strongest, trimmed from 8 for pacing (LOD400 §8).
					// Full source set retained below for re-sync if Eyal prefers all.
					$testimonials = array(
						array(
							'text' => 'Like many others, I thought I was coming to learn the didgeridoo. I had no idea what a powerful journey I was about to go through — a quieting of an overloaded mind, and an embrace for the heart.',
							'name' => 'Shiri Elkabetz',
						),
						array(
							'text' => "What I've been learning from Eyal this past year is how to breathe anew — to be present in the breath is to be present in life.",
							'name' => 'Navit Tzuf Strauss',
						),
						array(
							'text' => 'Eyal broke down the art of breathing with the didgeridoo into the smallest, clearest components. It is so much more than learning a breathing instrument.',
							'name' => 'Anat Kremner Weinstein',
						),
						array(
							'text' => 'For the first time in my life I learned to breathe correctly — practicing breath through the didge simply calms me.',
							'name' => 'Alon Garzon Raz',
						),
						// Remaining source testimonials (W2-08 full set) — re-enable if Eyal prefers all 8:
						// 'Chaya Azaria', 'Karin Tenenzapf', 'Galit Miller', 'Alex Flop'.
					);
					foreach ( $testimonials as $t ) :
						?>
						<figure class="ea-en-testimonial">
							<blockquote class="ea-en-testimonial__quote">
								<p><?php echo esc_html( $t['text'] ); ?></p>
							</blockquote>
							<figcaption class="ea-en-testimonial__name"><?php echo esc_html( $t['name'] ); ?></figcaption>
						</figure>
					<?php endforeach; ?>
				</div>

				<div class="ea-en-closing" id="contact">
					<p class="ea-en-closing__text">If you've read this far, something in this path probably speaks to you. An introductory call lets us understand together whether the method is right for you, and how to begin a personal process that fits exactly who you are.</p>
					<div class="ea-en-section__cta-wrap">
						<a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( $cta ); ?>">Schedule an introductory call</a>
					</div>
				</div>
			</div>
		</section>

	</div>
	<?php
	return ob_get_clean();
}
