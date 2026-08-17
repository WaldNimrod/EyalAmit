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
<a class="ea-skip-link screen-reader-text" href="#chapters-main"><?php esc_html_e( 'דלג לתוכן העמוד', 'ea-eyalamit' ); ?></a>

<?php get_template_part( 'template-parts/chapters/section', 'nav' ); ?>

<main id="chapters-main">
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

	// 03 — וידאו: לא נבנה. קישור הווידאו במסמך אייל הוא placeholder (XXXXXXXXXXX).

	get_template_part( 'template-parts/chapters/section', '06-compare' );      // 04 — טיפול בדיג'רידו או סאונד הילינג
	get_template_part( 'template-parts/chapters/section', '02-for-whom' );     // 05 — למי מתאים התהליך
	get_template_part( 'template-parts/chapters/section', '07-how-to-start' ); // 06 — איך מתחילים
	get_template_part( 'template-parts/chapters/section', '03-session' );      // 07 — מה קורה במפגש
	get_template_part( 'template-parts/chapters/section', 'photo-band' );      // מעבר צילומי (לא סקשן ממוספר אצל אייל)
	get_template_part( 'template-parts/chapters/section', '04-studio' );       // 08 — הסטודיו והמרחב

	// 09 — הצצה נוספת לחוויה. הגלריה/וידאו המשני טרם הוגדרו, אבל הטקסט המאושר
	// של אייל נשאר גלוי כאן ולא נמחק.
	if ( '' !== trim( (string) ea_chapters_field( 'closing_body' ) ) ) {
		get_template_part( 'template-parts/chapters/parts/prose', null, array(
			'id'    => 'peek',
			'chap'  => ea_chapters_field( 'closing_chap' ),
			'title' => ea_chapters_field( 'closing_title' ),
			'body'  => ea_chapters_field( 'closing_body' ),
		) );
	}

	get_template_part( 'template-parts/chapters/section', '05-testimonials' ); // 10 — עדויות והמלצות
	get_template_part( 'template-parts/chapters/section', '01-about' );        // 11 — אייל עמית

	// 12 — CTA סופי («CTA רגוע · ללא לחץ»). ללא כותרת: אייל לא נתן לסקשן כותרת גלויה.
	if ( '' !== trim( (string) ea_chapters_field( 'final_cta_label' ) ) ) {
		get_template_part( 'template-parts/chapters/parts/cta', null, array(
			'id'        => 'final-cta',
			'body'      => ea_chapters_field( 'final_body' ),
			'cta_label' => ea_chapters_field( 'final_cta_label' ),
			'cta_url'   => ea_chapters_field( 'final_cta_url' ),
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
