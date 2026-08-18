<?php
/**
 * Chapters /faq/ (שאלות נפוצות) — S006 R1-25.
 *
 * FAQ-02: SECTION 01–02 from FAQ FINAL.md. No em, no invented chap tags.
 * Intro href /didgeridoo-treatment kept as in md (not rewritten to /treatment/).
 * faqblock left in place (accordion still CPT). FAQ-01 media kept pending Eyal.
 * FAQ-03 corpus: inc/data/ea-faq-seed.json + mu-plugins/ea-s006-faq-merge-once.php.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

return array(

	/* S006 · מקור: content 13.8.26/דף FAQ/FAQ FINAL.md · SECTION 01 · שורות 18–22
	 * H1 «שאלות נפוצות» בלי em · בלי תג-פרק · תת = שורות 18–20 · CTA שורה 22 [שיחת היכרות](/contact)
	 * מדיה: existing studio-mosaic.jpg · FAQ-01 ממתין לאייל */
	'phero' => array(
		'chap'      => '',
		/* S006 · מקור: content 13.8.26/דף FAQ/FAQ FINAL.md · SECTION 01 · H1 בלי em (אין H1 נפרד במסמך) */
		'title'     => 'שאלות נפוצות',
		/* S006 · מקור: content 13.8.26/דף FAQ/FAQ FINAL.md · SECTION 01 · שורות 18–20 */
		'sub'       => "שאלות נפוצות על טיפול בדיג'רידו, שיעורי נגינה בדיג'רידו, סאונד הילינג ושיטת cbDIDG. לא כל עבודה עם דיג'רידו היא אותו דבר. כאן תמצאו תשובות לשאלות נפוצות והבנה ברורה של ההבדלים בין סוגי העבודה עם דיג'רידו.",
		'media'     => 'assets/images/chapters/studio-mosaic.jpg',
		'media_alt' => 'הסטודיו בפרדס חנה — שאלות נפוצות',
		/* S006 · מקור: content 13.8.26/דף FAQ/FAQ FINAL.md · SECTION 01 · שורה 22 */
		'cta_label' => 'שיחת היכרות',
		'cta_url'   => '/contact/',
	),

	'sections' => array(

		/* S006 · מקור: content 13.8.26/דף FAQ/FAQ FINAL.md · SECTION 02 · שורות 43–51
		 * בלי תג «לפני שמתחילים» · בלי H2 שהומצא · 👉 ככתבו
		 * href /didgeridoo-treatment ככתבו — לא המרה ל-/treatment/ */
		array(
			'part' => 'prose',
			'args' => array(
				'body' => "<p>👉 לפני שממשיכים, חשוב להבין:<br>לא כל עבודה עם דיג'רידו היא אותו דבר.</p><p>אם עדיין לא יצא לך, מומלץ לקרוא גם על:</p><ul><li><a class=\"tlink\" href=\"/didgeridoo-treatment\">טיפול בדיג'רידו</a></li><li><a class=\"tlink\" href=\"/sound-healing\">סאונד הילינג בדיג'רידו</a></li><li><a class=\"tlink\" href=\"/lessons\">שיעורי נגינה בדיג'רידו</a></li><li><a class=\"tlink\" href=\"/method\">השיטה - cbDIDG</a></li></ul>",
			),
		),

		/* S006 · FAQ-03 · accordion remains CPT faqblock (block-faq-list.php untouched) */
		array(
			'part' => 'faqblock',
			'args' => array(),
		),
	),
);
