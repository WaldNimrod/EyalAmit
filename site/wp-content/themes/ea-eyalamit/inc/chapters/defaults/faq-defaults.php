<?php
/**
 * Chapters /faq/ (שאלות נפוצות) — seeded content defaults.
 *
 * Renders on the generic tpl-chapters-page: phero (SECTION 01 Hero) + an intro
 * prose (SECTION 02 Intro Links Block) + the canonical FAQ accordion via the
 * 'faqblock' part (block-faq-list.php — full Q&A corpus, AC-18 canonical links).
 * Text VERBATIM from the approved source (דף FAQ/FAQ FINAL.md).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	/* SECTION 01 — Hero */
	'phero' => array(
		'chap'      => 'שאלות נפוצות',
		'title'     => 'שאלות <em>נפוצות</em>',
		'sub'       => "שאלות נפוצות על טיפול בדיג'רידו, שיעורי נגינה בדיג'רידו, סאונד הילינג ושיטת cbDIDG. לא כל עבודה עם דיג'רידו היא אותו דבר. כאן תמצאו תשובות לשאלות נפוצות והבנה ברורה של ההבדלים בין סוגי העבודה עם דיג'רידו.",
		'media'     => 'assets/images/chapters/studio-mosaic.jpg',
		'media_alt' => 'הסטודיו בפרדס חנה — שאלות נפוצות',
		'cta_label' => 'שיחת היכרות',
		'cta_url'   => '/contact/',
	),

	'sections' => array(

		/* SECTION 02 — Intro Links Block */
		array(
			'part' => 'prose',
			'args' => array(
				'chap'  => 'לפני שמתחילים',
				'title' => 'לא כל עבודה עם דיג׳רידו היא אותו דבר',
				'body'  => "<p>לפני שממשיכים, חשוב להבין: לא כל עבודה עם דיג'רידו היא אותו דבר.</p><p>אם עדיין לא יצא לך, מומלץ לקרוא גם על: <a class=\"tlink\" href=\"/treatment/\">טיפול בדיג'רידו</a>, <a class=\"tlink\" href=\"/sound-healing/\">סאונד הילינג בדיג'רידו</a>, <a class=\"tlink\" href=\"/lessons/\">שיעורי נגינה בדיג'רידו</a>, <a class=\"tlink\" href=\"/method/\">השיטה - cbDIDG</a>.</p>",
			),
		),

		/* SECTION 03+ — full FAQ accordion (canonical block, AC-18 links) */
		array(
			'part' => 'faqblock',
			'args' => array(),
		),
	),
);
