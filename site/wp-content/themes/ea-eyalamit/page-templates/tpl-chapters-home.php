<?php
/**
 * Template Name: פרקים — דף הבית (Chapters Home)
 *
 * Self-contained Chapters (פרקים) home: emits its own document so the cinematic
 * Chapters nav/footer render without the GeneratePress header chrome (avoids the
 * doubled-nav issue). wp_head()/wp_footer() still fire, so the SEO machine layer
 * (Yoast @graph, per-route meta, og:image, analytics, WhatsApp float) is intact.
 *
 * Content comes from ea_chapters_field()/rows()/img(), which fall back to seeded
 * defaults — so the page renders fully even when ACF is inactive.
 *
 * The cinematic hero (single H1 + intro subtitle) renders INSIDE <main> so it sits
 * within the main landmark (a11y) and is part of the page's measured content.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/chapters/section', 'nav' ); ?>

<main id="main" class="chapters-main" tabindex="-1">
	<?php
	/* S006 · H-09 · סדר הסקשנים לפי מספור אייל 01..12
	 * (content 13.8.26/דף הבית/homepage1-3 v2.md). שמות קבצי ה-partials נשארו
	 * היסטוריים (section-01-about וכו') — המספר בשם הקובץ אינו מספר הפרק של אייל;
	 * תוויות «פרק NN» מגיעות מ-home-defaults.php ומעודכנות למספור החדש. */

	// 01 — HERO.
	get_template_part( 'template-parts/chapters/section', 'hero' );

	// 02 — מה זה טיפול בנשימה באמצעות דיג'רידו (prose).
	if ( '' !== trim( (string) ea_chapters_field( 'what_body' ) ) ) {
		get_template_part( 'template-parts/chapters/parts/prose', null, array(
			'id'    => 'what',
			'chap'  => ea_chapters_field( 'what_chap' ),
			'title' => ea_chapters_field( 'what_title' ),
			'body'  => ea_chapters_field( 'what_body' ),
			'alt'   => true,
		) );
	}

	// 03 — וידאו: שלד + פלייסהולדר 16:9. התוכן חסום (H-06).
	get_template_part( 'template-parts/chapters/section', 'home-03-video' );

	get_template_part( 'template-parts/chapters/section', 'home-spotlight' );

	get_template_part( 'template-parts/chapters/section', '06-compare' );      // 04 — טיפול בדיג'רידו או סאונד הילינג
	get_template_part( 'template-parts/chapters/section', '02-for-whom' );     // 05 — למי מתאים התהליך
	get_template_part( 'template-parts/chapters/section', '07-how-to-start' ); // 06 — איך מתחילים
	get_template_part( 'template-parts/chapters/section', '03-session' );      // 07 — מה קורה במפגש
	get_template_part( 'template-parts/chapters/section', 'photo-band' );      // מעבר צילומי (לא סקשן ממוספר אצל אייל)
	get_template_part( 'template-parts/chapters/section', '04-studio' );       // 08 — הסטודיו והמרחב

	// 09 — הצצה נוספת לחוויה: טקסט מאושר + פלייסהולדר מדיה + CTA מ-C15.
	get_template_part( 'template-parts/chapters/section', 'home-09-peek' );

	/*
	 * Wave 1 A2 — six corpus questions, read from the ea_faq CPT
	 * (ea_faq_query_items), between the peek and the testimonials.
	 * Do NOT emit FAQPage schema on this URL. Spec §15.3 restricts FAQPage
	 * to the dedicated /faq/ page. The home page emits zero FAQPage nodes;
	 * adding one here would duplicate the entity on the site's
	 * highest-authority URL.
	 */
	$ea_home_faq_keys = array( 'treatment-01', 'treatment-02', 'treatment-03', 'general-01', 'general-05', 'general-17' );
	$ea_home_faq_by   = array();
	if ( function_exists( 'ea_faq_query_items' ) ) {
		foreach ( ea_faq_query_items() as $ea_home_faq_row ) {
			$ea_home_faq_key = isset( $ea_home_faq_row['seed_key'] ) ? (string) $ea_home_faq_row['seed_key'] : '';
			if ( '' !== $ea_home_faq_key ) {
				$ea_home_faq_by[ $ea_home_faq_key ] = $ea_home_faq_row;
			}
		}
	}
	$ea_home_faq_items = array();
	foreach ( $ea_home_faq_keys as $ea_home_faq_key ) {
		if ( empty( $ea_home_faq_by[ $ea_home_faq_key ] ) ) {
			continue;
		}
		$ea_home_faq_items[] = array(
			'q' => $ea_home_faq_by[ $ea_home_faq_key ]['q'],
			'a' => $ea_home_faq_by[ $ea_home_faq_key ]['a'],
		);
	}
	set_query_var(
		'ea_faq_mini_ctx',
		array(
			'items'  => $ea_home_faq_items,
			'footer' => array(
				'label' => 'לכל השאלות הנפוצות',
				'href'  => home_url( '/faq/' ),
			),
		)
	);
	get_template_part( 'template-parts/blocks/block', 'faq-mini' );

	get_template_part( 'template-parts/chapters/section', '05-testimonials' ); // 10 — עדויות והמלצות
	get_template_part( 'template-parts/chapters/section', '01-about' );        // 11 — אייל עמית

	// 12 — CTA סופי («CTA רגוע · ללא לחץ»). ללא כותרת: אייל לא נתן לסקשן כותרת גלויה.
	if ( '' !== trim( (string) ea_chapters_field( 'final_cta_label' ) ) ) {
		get_template_part( 'template-parts/chapters/parts/cta', null, array(
			'id'        => 'final-cta',
			'body'      => ea_chapters_field( 'final_body' ),
			'cta_label' => ea_chapters_field( 'final_cta_label' ),
			'cta_url'   => ea_chapters_field( 'final_cta_url' ),
			/* Directly above the footer — sand type (owner 2026-09-26).
			   This band is not a defaults 'part', so the flag lives on the call. */
			'sand'      => true,
		) );
	}
	?>
</main>

<?php
get_template_part( 'template-parts/chapters/section', 'footer' );
wp_footer();
?>
</body>
</html>
