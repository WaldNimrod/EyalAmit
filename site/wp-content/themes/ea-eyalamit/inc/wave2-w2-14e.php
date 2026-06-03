<?php
/**
 * WP-W2-14-E — Memorial + Galleries + Media: 3 new elevated pages.
 *
 * Force-routes the 3 top-level slugs (/mokesh-dahiman, /galleries, /media) to
 * page-templates/tpl-catalog-14e.php, marks them as Wave2 active views for the
 * Stage-B chrome/asset hygiene, enqueues the dedicated catalog sheet
 * (assets/css/w2-14e-catalog.css), and renders each page's composition from the
 * mockup (team_35 handoff-WP-W2-10-MOBILE).
 *
 * Pattern mirrors inc/wave2-w2-04.php (slug→tpl map, template_include @ 100,
 * ea_wave2_shell query var on template_redirect, body-class / sidebar / GP-title
 * filters, scoped enqueue). Compositions reuse the canonical topnav + footer
 * blocks via the template chrome; the per-page bodies are rendered here.
 *
 * D-14: zero new tokens/atoms/keyframes. All copy in the memorial page is
 * VERBATIM from the mockup `Memorial - Mokesh (elevated).html` (sensitive).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Top-level slugs handled by this WP → template.
 *
 * @return array<string,string>
 */
function ea_w2_14e_slugs() {
	return array(
		'mokesh-dahiman' => 'tpl-catalog-14e',
		'galleries'      => 'tpl-catalog-14e',
		'media'          => 'tpl-catalog-14e',
	);
}

/**
 * Resolve the current request to a 14-E page slug, or '' if not a 14-E view.
 * Top-level pages only (post_parent === 0).
 *
 * @return string
 */
function ea_w2_14e_current_slug() {
	if ( ! is_page() ) {
		return '';
	}
	$post = get_queried_object();
	if ( ! ( $post instanceof WP_Post ) ) {
		return '';
	}
	$slugs = ea_w2_14e_slugs();
	// Match by exact (unique) slug — NOT top-level-only: /mokesh-dahiman is a
	// child of /eyal-amit (post_parent != 0) yet must route to 14-E. The three
	// 14-E slugs are unique, so a parent check is unnecessary and was wrongly
	// excluding the memorial page.
	if ( isset( $slugs[ $post->post_name ] ) ) {
		return $post->post_name;
	}
	return '';
}

/**
 * True when the current request is a 14-E page.
 *
 * @return bool
 */
function ea_w2_14e_is_page() {
	return '' !== ea_w2_14e_current_slug();
}

/**
 * Resolve the current request into a 14-E route context, or null.
 *
 * Shape: array( 'slug' => string ).
 *
 * @return array<string,string>|null
 */
function ea_w2_14e_ctx() {
	$slug = ea_w2_14e_current_slug();
	if ( '' === $slug ) {
		return null;
	}
	return array( 'slug' => $slug );
}

/**
 * Force-route 14-E pages to tpl-catalog-14e. Priority 100 — after legacy filters.
 *
 * @param string $tpl Current template path.
 * @return string
 */
function ea_w2_14e_template_include( $tpl ) {
	$slug = ea_w2_14e_current_slug();
	if ( '' === $slug ) {
		return $tpl;
	}
	$slugs = ea_w2_14e_slugs();
	$t     = locate_template( 'page-templates/' . $slugs[ $slug ] . '.php' );
	if ( $t ) {
		return $t;
	}
	return $tpl;
}
// Priority 102 so WP-W2-14-E's elevated compositions win over the prior
// W2-07 editorial router (priority 101), which also claimed /mokesh-dahiman.
// The team_35 memorial mockup (dignified sand-ring + verbatim copy) supersedes
// the generic editorial elevation there; galleries/media are unaffected.
add_filter( 'template_include', 'ea_w2_14e_template_include', 102 );

/**
 * Mark 14-E force-routed pages as a Wave2 active view for Stage-B asset hygiene.
 */
add_action( 'template_redirect', function () {
	if ( ea_w2_14e_is_page() ) {
		set_query_var( 'ea_wave2_shell', true );
	}
} );

/**
 * Body classes: ea-wave2-shell + ea-14e-<slug>.
 *
 * @param string[] $classes
 * @return string[]
 */
function ea_w2_14e_body_class( $classes ) {
	$slug = ea_w2_14e_current_slug();
	if ( '' === $slug ) {
		return $classes;
	}
	if ( ! in_array( 'ea-wave2-shell', $classes, true ) ) {
		$classes[] = 'ea-wave2-shell';
	}
	$classes[] = 'ea-14e-' . $slug;
	return $classes;
}
add_filter( 'body_class', 'ea_w2_14e_body_class', 102 );

/**
 * No sidebar on 14-E pages.
 *
 * @param string $layout
 * @return string
 */
function ea_w2_14e_sidebar_layout( $layout ) {
	if ( ea_w2_14e_is_page() ) {
		return 'no-sidebar';
	}
	return $layout;
}
add_filter( 'generate_sidebar_layout', 'ea_w2_14e_sidebar_layout', 103 );

/**
 * Hide GeneratePress content title on 14-E pages (the H1 is inside the body).
 *
 * @param bool $show
 * @return bool
 */
function ea_w2_14e_hide_gp_title( $show ) {
	if ( ea_w2_14e_is_page() ) {
		return false;
	}
	return $show;
}
add_filter( 'generate_show_title', 'ea_w2_14e_hide_gp_title', 103 );

/**
 * Enqueue the 14-E catalog sheet (memorial + galleries + media). Dep on
 * ea-wave2-atoms keeps load order after the atoms (matches the cluster-sheet
 * convention). Scoped to the 3 routes only — NOT enqueued via the 14-A block.
 */
function ea_w2_14e_assets() {
	if ( is_admin() || ! ea_w2_14e_is_page() ) {
		return;
	}
	wp_enqueue_style(
		'ea-w2-14e-catalog',
		get_stylesheet_directory_uri() . '/assets/css/w2-14e-catalog.css',
		array( 'ea-wave2-atoms' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'ea_w2_14e_assets', 29 );

/* ═══════════════════════════════════════════════════════════════════════════
 * Render dispatch
 * ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Render the composition for a resolved 14-E route.
 *
 * @param array<string,string>|null $ctx From ea_w2_14e_ctx().
 */
function ea_w2_14e_render( $ctx ) {
	$slug = is_array( $ctx ) && isset( $ctx['slug'] ) ? (string) $ctx['slug'] : '';
	switch ( $slug ) {
		case 'mokesh-dahiman':
			ea_w2_14e_render_memorial();
			break;
		case 'galleries':
			ea_w2_14e_render_galleries();
			break;
		case 'media':
			ea_w2_14e_render_media();
			break;
	}
}

/**
 * Theme image URL helper — returns the asset URL when the file exists in
 * assets/images/, else ''. Lets compositions degrade to placeholders.
 *
 * @param string $file Filename within assets/images/.
 * @return string
 */
function ea_w2_14e_img( $file ) {
	$path = get_stylesheet_directory() . '/assets/images/' . $file;
	if ( is_readable( $path ) ) {
		return get_stylesheet_directory_uri() . '/assets/images/' . $file;
	}
	return '';
}

/* ═══════════════════════════════════════════════════════════════════════════
 * MEMORIAL — /mokesh-dahiman (SENSITIVE — copy VERBATIM from the mockup)
 * ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Memorial page composition. All copy is verbatim from
 * `Memorial - Mokesh (elevated).html`. Subtitle nowrap ≥768px via a token-clean
 * class (.ea-mem-hero__sub--desk-nowrap) — no brittle inline width.
 */
function ea_w2_14e_render_memorial() {
	?>
	<section class="ea-mem-hero">
		<div class="ea-mem-hero__inner">
			<div class="ea-mem-hero__disc" aria-hidden="true"><span class="ea-mem-hero__yr">1950 — 2020</span></div>
			<p class="ea-mem-hero__kicker">לזכרו</p>
			<h1 class="ea-mem-hero__title">מוקש דהימן</h1>
			<p class="ea-mem-hero__sub ea-mem-hero__sub--desk-nowrap">מאסטר הדיג׳רידו, מורו של אייל עמית, והמקור שממנו צמחה הדרך התרפויטית.</p>
		</div>
	</section>

	<section class="ea-14e-section" aria-labelledby="ea-mem-a">
		<div class="ea-14e-inner">
			<p class="ea-14e-label">המורה</p>
			<h2 id="ea-mem-a" class="ea-14e-heading">המורה הגדול של חיי</h2>
			<div class="ea-14e-prose">
				<p>בשנת 2000 הגעתי להודו, ושם פגשתי את מוקש — מי שהפך ברבות השנים למורה הגדול של חיי. המפגש איתו והלימוד לצידו פתחו עבורי שער לעבודה עמוקה עם נשימה, גוף ותודעה.</p>
				<p>העבודה שלי עם הדיג׳רידו התפתחה מתוך הסתכלות שמגיעה מהעולם היוגי שממנו מוקש הגיע — גישה שמעמידה במרכז את הנשימה, המודעות ותשומת הלב הפנימית, ולא רק את הצד המוזיקלי של הכלי.</p>
			</div>
			<div class="ea-14e-pullquote">
				<blockquote>״הקשר עם מוקש דהימן הוא הציר שעליו נשענת כל הדרך התרפויטית שלי.״</blockquote>
			</div>
		</div>
	</section>

	<section class="ea-14e-section ea-14e-section--alt" aria-labelledby="ea-mem-l">
		<div class="ea-14e-inner">
			<p class="ea-14e-label">המורשת</p>
			<h2 id="ea-mem-l" class="ea-14e-heading">דרך שממשיכה</h2>
			<div class="ea-14e-prose">
				<p>שיטת cbDIDG שפיתחתי צמחה מתוך המסורת הזו, ומתוך כבוד עמוק לדרך שמוקש העביר לי. כל מפגש בסטודיו בפרדס חנה נושא בתוכו משהו מהחניכה הזו — מההקשבה, מהדיוק, ומההבנה שהנשימה היא הרבה מעבר לאוויר שנכנס ויוצא.</p>
				<p>הדף הזה הוא מחווה קטנה לאדם גדול, ולמורשת שממשיכה לנשום דרך כל מי שלומד כאן.</p>
			</div>
			<div class="ea-mem-gal" role="group" aria-label="גלריה לזכרו">
				<div class="ea-mem-gal__item">[תמונת מוקש — בכפוף לאישור]</div>
				<div class="ea-mem-gal__item">[מהלימוד בהודו — נדרש מאייל]</div>
				<div class="ea-mem-gal__item">[רישיקש — נדרש מאייל]</div>
			</div>
			<p class="ea-14e-note">תמונות לדף ההנצחה יוטמעו בכפוף לאישור אייל ולרגישות התוכן.</p>
		</div>
	</section>
	<?php
}

/* ═══════════════════════════════════════════════════════════════════════════
 * GALLERIES — /galleries (catalog grid 3→2→1)
 * ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Galleries catalog data. Real images degrade to a labelled placeholder when
 * the asset is missing (graceful). Copy verbatim from the mockup.
 *
 * @return array<int,array<string,string>>
 */
function ea_w2_14e_galleries_items() {
	return array(
		array(
			'img'   => 'hero-wide-studio.jpg',
			'alt'   => 'הסטודיו בפרדס חנה',
			'count' => '12 תמונות',
			'title' => 'הסטודיו בפרדס חנה',
			'desc'  => 'המרחב, החצר הירוקה ושבילי העץ.',
		),
		array(
			'img'   => 'kushi-04-sinai.jpg',
			'alt'   => 'מסעות',
			'count' => '18 תמונות',
			'title' => 'מסעות ודרכים',
			'desc'  => 'סיני, דרום אמריקה והמקומות שהיוו השראה.',
		),
		array(
			'img'         => '',
			'placeholder' => '[גלריית סדנאות — נדרש מאייל]',
			'count'       => '— תמונות',
			'title'       => 'סדנאות ומפגשים',
			'desc'        => 'קבוצות, סאונד הילינג ואירועים.',
		),
		array(
			'img'         => '',
			'placeholder' => '[גלריית כלים — נדרש מאייל]',
			'count'       => '— תמונות',
			'title'       => 'כלים בעבודת יד',
			'desc'        => 'דיג׳רידו, תיקים וסטנדים שנבנו ביד.',
		),
		array(
			'img'   => 'kushi-02-eyal-italy.jpg',
			'alt'   => 'הופעות',
			'count' => '9 תמונות',
			'title' => 'הופעות ומופעים',
			'desc'  => '״עכשיו!!!״ ומופעי סיפורים על במות.',
		),
		array(
			'img'         => '',
			'placeholder' => '[גלריית מוקש — נדרש מאישור]',
			'count'       => '— תמונות',
			'title'       => 'מוקש דהימן',
			'desc'        => 'מהלימוד והחניכה בהודו.',
		),
	);
}

/**
 * Galleries catalog composition.
 */
function ea_w2_14e_render_galleries() {
	?>
	<header class="ea-14e-pagehead">
		<div class="ea-14e-pagehead__inner">
			<p class="ea-14e-pagehead__label">גלריות</p>
			<h1 class="ea-14e-pagehead__title">רגעים מהמרחב ומהדרך</h1>
			<p class="ea-14e-pagehead__lead">צילומים מהסטודיו, ממפגשים, מסדנאות וממסעות — קטלוג גלריות שמתעדכן עם הזמן. לחיצה על גלריה פותחת את כל התמונות שבה.</p>
		</div>
	</header>
	<section class="ea-14e-section" aria-label="קטלוג גלריות">
		<div class="ea-14e-inner">
			<div class="ea-gal-grid">
				<?php foreach ( ea_w2_14e_galleries_items() as $g ) : ?>
					<?php
					$src = isset( $g['img'] ) && '' !== $g['img'] ? ea_w2_14e_img( $g['img'] ) : '';
					?>
					<a class="ea-gal" href="#">
						<div class="ea-gal__cover">
							<?php if ( '' !== $src ) : ?>
								<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( isset( $g['alt'] ) ? $g['alt'] : '' ); ?>" loading="lazy">
							<?php else : ?>
								<div class="ea-gal__ph"><?php echo esc_html( isset( $g['placeholder'] ) ? $g['placeholder'] : '' ); ?></div>
							<?php endif; ?>
							<span class="ea-gal__count"><?php echo esc_html( $g['count'] ); ?></span>
						</div>
						<p class="ea-gal__t"><?php echo esc_html( $g['title'] ); ?></p>
						<p class="ea-gal__d"><?php echo esc_html( $g['desc'] ); ?></p>
					</a>
				<?php endforeach; ?>
			</div>
			<p class="ea-14e-note">כל תוכן הגלריות מהאתר הקודם עובר לאתר החדש (תקרה ~150 תמונות למחיצה). הגלריות מתמלאות מתוך קטלוג המדיה ב-Hub עם מסירת הנכסים הסופית.</p>
		</div>
	</section>
	<?php
}

/* ═══════════════════════════════════════════════════════════════════════════
 * MEDIA / TESTIMONIALS — /media (.ea-tgrid → 1-col on mobile)
 * ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Testimonial cards (verbatim from the mockup).
 *
 * @return array<int,array<string,string>>
 */
function ea_w2_14e_media_testimonials() {
	return array(
		array( 'q' => 'כמו רבים אחרים גם אני חשבתי שאני באה ללמוד דיג׳רידו, ולא היה לי מושג איזה מסע עוצמתי מחכה לי.', 'n' => 'שירי אלקבץ' ),
		array( 'q' => 'מה שאני לומדת מאייל זה לנשום מחדש — להיות בנוכחות בנשימה, זה להיות בנוכחות בחיים.', 'n' => 'נוית צוף שטראוס' ),
		array( 'q' => 'פעם ראשונה בחיים שלמדתי לנשום נכון — תרגול הנשימה בדידג׳ פשוט מרגיע אותי.', 'n' => 'אלון גרזון רז' ),
		array( 'q' => 'אייל עמית הציל אותנו, ובזכותו כולנו חזרנו לנשום. הקשר המיוחד שנוצר עם הילד שלי קרה מהר והעמיק.', 'n' => 'חיה עזריה' ),
		array( 'q' => 'הלימוד אצלך, אייל, פתח עוד שכבה פנימית של נשימה וחיבר אותי עוד יותר לרפואה הפנימית שכולנו נושאים.', 'n' => 'קארין טננצפף' ),
		array( 'q' => 'אייל לא רק מלמד — הוא מלווה אותי במסע פנימי, ללמוד לנשום דרך הגוף, אל תוך הצליל ואל הנוכחות המלאה.', 'n' => 'אלכס פלופ' ),
	);
}

/**
 * Press / media items (verbatim from the mockup).
 *
 * @return array<int,array<string,string>>
 */
function ea_w2_14e_media_press() {
	return array(
		array( 'src' => 'כתבה', 'h' => 'שליחות חיי — כתבה אודות המרכז לטיפול בדיג׳רידו, סטודיו נשימה מעגלית פרדס חנה' ),
		array( 'src' => 'מאמר', 'h' => 'הכל על ריברסינג, נשימה מעגלית ודיג׳רידו — ההסבר המלא' ),
		array( 'src' => 'פודקאסט', 'h' => 'שיחה על נשימה, צליל וריפוי דרך הדיג׳רידו' ),
		array( 'src' => 'מופע', 'h' => '״עכשיו!!! — תופעת יחיד״: מופע הסיפורים של אייל עמית' ),
	);
}

/**
 * Media / testimonials catalog composition.
 */
function ea_w2_14e_render_media() {
	$contact = home_url( '/contact/' );
	?>
	<header class="ea-14e-pagehead">
		<div class="ea-14e-pagehead__inner">
			<p class="ea-14e-pagehead__label">המלצות ומדיה</p>
			<h1 class="ea-14e-pagehead__title">מילים שנשארו אחרי המפגש</h1>
			<p class="ea-14e-pagehead__lead">עדויות של משתתפים, אזכורים בעיתונות וכתבות נבחרות — קטלוג מרכזי שמתעדכן עם הזמן.</p>
		</div>
	</header>

	<section class="ea-14e-section" aria-labelledby="ea-media-t">
		<div class="ea-14e-inner">
			<h2 id="ea-media-t" class="ea-14e-heading ea-14e-heading--sm">עדויות משתתפים</h2>
			<div class="ea-filter" role="group" aria-label="סינון">
				<button type="button" aria-pressed="true">הכל</button>
				<button type="button" aria-pressed="false">טיפול</button>
				<button type="button" aria-pressed="false">שיעורים</button>
				<button type="button" aria-pressed="false">סאונד הילינג</button>
			</div>
			<div class="ea-tgrid">
				<?php foreach ( ea_w2_14e_media_testimonials() as $t ) : ?>
					<figure class="ea-tcard">
						<p class="ea-tcard__q"><?php echo esc_html( $t['q'] ); ?></p>
						<figcaption class="ea-tcard__n"><?php echo esc_html( $t['n'] ); ?></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="ea-14e-section ea-14e-section--alt" aria-labelledby="ea-media-p">
		<div class="ea-14e-inner">
			<h2 id="ea-media-p" class="ea-14e-heading ea-14e-heading--sm">מן התקשורת</h2>
			<div class="ea-press">
				<?php foreach ( ea_w2_14e_media_press() as $p ) : ?>
					<a href="#">
						<p class="ea-press__src"><?php echo esc_html( $p['src'] ); ?></p>
						<p class="ea-press__h"><?php echo esc_html( $p['h'] ); ?></p>
					</a>
				<?php endforeach; ?>
			</div>
			<p class="ea-14e-note">פריטי המדיה ייובאו מהקטלוג המרכזי (CMS) עם מסירת הנכסים והקישורים הסופיים.</p>
		</div>
	</section>

	<section class="ea-cta-band" aria-labelledby="ea-media-c">
		<div class="ea-14e-inner">
			<h2 id="ea-media-c" class="ea-cta-band__heading">רוצים לחוות בעצמכם?</h2>
			<a class="ea-cta-pill ea-cta-pill--primary" href="<?php echo esc_url( $contact ); ?>">לתיאום שיחת היכרות</a>
		</div>
	</section>
	<?php
}
