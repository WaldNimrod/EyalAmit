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
 * Render the full /en landing page (6 sections, content VERBATIM from the
 * approved team_30 artifact W2-08-EN-CONTENT-2026-05-28.md).
 *
 * @return string
 */
function ea_w2_08_render() {
	$cta = ea_w2_08_cta_url();
	$hero_img = get_stylesheet_directory_uri() . '/assets/home/eyal-portrait-hero.jpg';
	ob_start();
	?>
	<div class="ea-en">

		<!-- ── Section 1 — Hero ── -->
		<section class="ea-en-hero" data-block="hero" style="background-image:url('<?php echo esc_url( $hero_img ); ?>');" aria-label="The Center for Breath Therapy through the Didgeridoo">
			<div class="ea-en-hero__overlay" aria-hidden="true"></div>
			<div class="ea-en-hero__content">
				<h1 class="ea-en-hero__title">The Center for Breath Therapy through the Didgeridoo — the cbDIDG Method by Eyal Amit</h1>
				<p class="ea-en-hero__subhead">Regaining control of your breath through active work with the didgeridoo, breathing practice, and personal guidance — a therapeutic approach built on the didgeridoo and inspired by a personal apprenticeship with master Mookesh Dhiman.</p>
				<p class="ea-en-hero__trust">Eyal Amit · Active since 1999 · One of Israel's most experienced practitioners in the field · Teaches and treats in a method developed over the years · Builds instruments by hand.</p>
				<div class="ea-en-hero__cta-wrap">
					<a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( $cta ); ?>">Schedule an introductory call</a>
				</div>
			</div>
		</section>

		<!-- ── Section 2 — About Eyal ── -->
		<section class="ea-en-section" data-block="about" aria-label="About Eyal">
			<div class="ea-en-section__inner">
				<h2 class="ea-en-section__heading">About Eyal</h2>
				<div class="ea-en-prose">
					<p>Eyal Amit has worked with the didgeridoo since 1999 and is one of the most experienced practitioners of the instrument in Israel.</p>
					<p>He founded the Center for Breath Therapy — a circular-breathing studio in Pardes Hanna — out of a desire to make the didgeridoo accessible and to teach it as a tool with a real therapeutic effect on the body, the breath, and the mind. Over the years he has guided hundreds of people through personal processes and developed the cbDIDG method for didgeridoo-based therapy, combining hands-on experience with ongoing inquiry.</p>
					<p>Eyal is also an author and independent publisher. A former electronics engineer and stage performer, he created the long-running storytelling show &ldquo;One-Man Phenomenon,&rdquo; and for more than two decades has worked with the didgeridoo as a teacher, instrument builder, and breath therapist.</p>
				</div>
			</div>
		</section>

		<!-- ── Section 3 — The Method (cbDIDG) ── -->
		<section class="ea-en-section ea-en-section--alt" data-block="method" aria-label="The Method (cbDIDG)">
			<div class="ea-en-section__inner">
				<h2 class="ea-en-section__heading">The Method (cbDIDG)</h2>
				<div class="ea-en-prose">
					<p><strong>cbDIDG</strong> is a structured method for working with the breath through playing the didgeridoo, guided one-on-one. The didgeridoo is not the goal — it is the tool through which you learn to work with your everyday breathing: to strengthen it, regulate it, and regain control over it.</p>
					<p>The work is not only about learning to play or mastering a technique. It is about improving the everyday breathing patterns that accompany a person throughout the day — and even during sleep. Through the instrument, through practice, and through listening to what is happening in the body, control, stability, and the ability to regulate the breathing system are built up gradually.</p>
					<p><strong>Three principles guide the method:</strong></p>
					<ul class="ea-en-list">
						<li><strong>Active work.</strong> Unlike the passive experience of sound healing, the participant actively learns to build control over their own breath through playing and consistent practice.</li>
						<li><strong>A clear distinction</strong> between the circular-breathing technique used while playing and everyday breathing. Playing is the practice tool; the aim is lasting change in the breathing patterns that carry through daily life.</li>
						<li><strong>Process, not a moment.</strong> This is not a one-off experience with short-term effect, but gradual work built on practice, persistence, and depth — working toward the long term.</li>
					</ul>
					<p>Because the didgeridoo gives immediate feedback through sound, it lets you identify patterns and refine the work in a way that &ldquo;dry&rdquo; breathing practice alone cannot.</p>
					<p>The method grew out of a personal journey — a deep study of the breath and a wish to cope with severe asthma and allergies — and from a long relationship with the Indian didgeridoo master <strong>Mookesh Dhiman</strong>, which began in 2000. It was further shaped by tai chi, qigong, yoga, and mindfulness, all of which deepened Eyal's understanding of the connection between breath, body, and mind.</p>
				</div>
			</div>
		</section>

		<!-- ── Section 4 — Services Overview ── -->
		<section class="ea-en-section" data-block="services" aria-label="Services Overview">
			<div class="ea-en-section__inner">
				<h2 class="ea-en-section__heading">Services Overview</h2>
				<div class="ea-en-prose">
					<p>Not all work with the didgeridoo is the same. The Center offers three distinct paths through the same instrument:</p>
					<p><strong>Didgeridoo Therapy.</strong> Active, process-based work with the breath, in which you learn to strengthen and regulate your own breathing system — with a lasting, long-term effect. The didgeridoo here is a tool to work on the breath, not the goal itself; over time, you also learn to play. It suits people living with health symptoms (even when the source isn't clear), those who understand this is a deep personal process rather than a quick fix, and anyone curious about an alternative, experiential therapeutic direction. Sessions are private and one-on-one, in a quiet, comfortable studio.</p>
					<p><strong>Sound Healing.</strong> A private journey in sound and frequency for individuals or couples — without touch. Unlike most group sound-healing sessions, this is intimate and fully tailored: you rest comfortably (first on a mat, then in hammocks) while Eyal holds the space with the didgeridoo and additional frequency instruments. The vibration moves through the body like a gentle inner massage, slows things down, widens the breath, and creates a held space for deep listening. The effect is immediate and powerful — ideal for anyone who wants to pause, disconnect from the load, and reconnect inward.</p>
					<p><strong>Didgeridoo Lessons.</strong> A focused learning path for playing the instrument: developing playing skill, mastering the circular-breathing technique unique to the didgeridoo, working with rhythm, dynamics, and speed, and refining sound and vocal effects. Lessons follow the cbDIDG method, are fully private with Eyal's personal attention, and are structured for individual progress.</p>
				</div>
				<div class="ea-en-section__cta-wrap">
					<a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( $cta ); ?>">Schedule an introductory call</a>
				</div>
			</div>
		</section>

		<!-- ── Section 5 — Books — Muzza Publishing ── -->
		<section class="ea-en-section ea-en-section--alt" data-block="books" aria-label="Books — Muzza Publishing">
			<div class="ea-en-section__inner">
				<h2 class="ea-en-section__heading">Books — Muzza Publishing</h2>
				<div class="ea-en-prose">
					<p><strong>Muzza Publishing</strong> is an independent press founded in 2004 by author and storyteller Eyal Amit. It is home to his travel writing, fantasy, and inspiring personal stories — books written in different chapters of his life, each opening a different door onto journey, change, freedom, and reflection. They differ greatly from one another, yet share the same inner thread: a living voice, writing that flows from life itself, and a gaze that doesn't rush to fit familiar molds.</p>
					<p><strong>Why you'll find these books here.</strong> When a book is bought through the big retail chains, most of the money never reaches the author — it stays with the chain and the distributors. Buying directly from the creator, much like &ldquo;direct-from-farm,&rdquo; means the support reaches the person who wrote the book almost in full. That's why the books are offered here at a lower, fairer price — better for readers and for the author alike.</p>
					<p><strong>The three books:</strong></p>
					<ul class="ea-en-list">
						<li><strong>Paint It Blue and Throw It to the Sea</strong> — 38 short, kicking stories from the great journey through South America: about release, escape, freedom, confusion, and everything that happens on the way out and the way back. First published in 2001, now in its tenth edition.</li>
						<li><strong>Kushi Blantis</strong> — a fantasy novel about awakening, choice, courage, and stepping out of a life that has grown too comfortable: a symbolic, colorful, and stirring journey beyond the gilded cage. Published in 2004, now in its sixth edition.</li>
						<li><strong>And You Shall Write</strong> — 46 true stories from Eyal Amit's life: a personal, living, inspiring book about love, journeys, loss, change, growth, and the ability to rise even from the hardest places. Published in 2017, with a QR element that extends the reading experience beyond the page.</li>
					</ul>
					<p><strong>The three-book bundle.</strong> All three together at a special price — three very different books, connected by the same living, personal, unconventional voice: a journey and coming-of-age, fantasy and awakening, and true stories at eye level. A great way to get to know Eyal Amit's writing, and an original gift for anyone who loves books with a personal voice, movement, and depth.</p>
				</div>
			</div>
		</section>

		<!-- ── Section 6 — Testimonials & CTA ── -->
		<section class="ea-en-section ea-en-section--testimonials" data-block="testimonials" aria-label="Testimonials">
			<div class="ea-en-section__inner">
				<h2 class="ea-en-section__heading">What people say about the work</h2>
				<p class="ea-en-testimonials__note">(translated from the original Hebrew testimonials)</p>
				<div class="ea-en-testimonials">
					<?php
					$testimonials = array(
						array(
							'text' => "Like many others, I thought I was coming 'to learn the didgeridoo.' I had no idea what a powerful journey I was about to go through. Beyond settling the breath that settles the soul, I got a quieting of an overloaded mind, and a caress and embrace for the heart.",
							'name' => 'Shiri Elkabetz',
						),
						array(
							'text' => 'My story with breathing is very complex. What I\'ve been learning from Eyal this past year, alongside my own healing journey, is how to breathe anew — to be present in the breath is to be present in life.',
							'name' => 'Navit Tzuf Strauss',
						),
						array(
							'text' => 'After I quit smoking, I felt it was time to do something about the breath, and the soul. Eyal broke down the art of breathing with the didgeridoo into the smallest, clearest components. I warmly recommend the experience — it is so much more than learning a breathing instrument.',
							'name' => 'Anat Kremner Weinstein',
						),
						array(
							'text' => 'Eyal Amit saved us, and thanks to him we all returned to breathing. The special bond he formed with my child happened fast and only deepened, and of course the breathing improved significantly thanks to the weekly practice.',
							'name' => 'Chaya Azaria',
						),
						array(
							'text' => 'Learning with you, Eyal, opened another inner layer of breath and connected me even more to the inner medicine we all carry. From the bottom of my heart and lungs — coming to your studio is an enormous gift every person owes themselves.',
							'name' => 'Karin Tenenzapf',
						),
						array(
							'text' => "First, I learned that I don't really know how to breathe correctly — it turns out most of us don't. And second, I'm learning to play this incredible instrument. I'm on the way, inside the process, and I'm enjoying it.",
							'name' => 'Galit Miller',
						),
						array(
							'text' => 'I thought the didge could be just another cool instrument to play. Instead I discovered a whole world of quiet. For the first time in my life I learned to breathe correctly — practicing breath through the didge simply calms me.',
							'name' => 'Alon Garzon Raz',
						),
						array(
							'text' => 'This is not just learning a musical instrument. It is a powerful way to discover the strength of the breath. Eyal doesn\'t only teach — he guides me on an inner journey, learning how to breathe through the body, into the sound, and into full presence.',
							'name' => 'Alex Flop',
						),
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

				<div class="ea-en-closing">
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
