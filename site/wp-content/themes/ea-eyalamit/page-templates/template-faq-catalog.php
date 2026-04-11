<?php
/**
 * Template Name: FAQ — קטלוג (M2)
 * Description: עמוד שאלות נפוצות — מבוא + אזור לרשומות (CPT/אינסטנסים לפי D-EYAL-ENTITY-CATALOG). עד אז: placeholder מסודר ל־QA ולתוכן מאייל.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
while ( have_posts() ) {
	the_post();
	?>
	<div class="inside-article">
		<div class="entry-content ea-faq-catalog">
			<p class="ea-faq-catalog-note" role="note">
				<?php esc_html_e( 'תוכן מבוא ושאלות זמניות — צוות 80 (2026-04-06); מקור: _communication/team_80/M3-TEXT-PLACEHOLDER-RETURN-TEAM80-2026-04-06.md. נטען גם בגוף העמוד (MU או עורך).', 'ea-eyalamit' ); ?>
			</p>
			<?php the_content(); ?>
			<section class="ea-instance-catalog-wrap" aria-label="<?php esc_attr_e( 'רשימת שאלות נפוצות', 'ea-eyalamit' ); ?>">
				<?php ea_eyalamit_render_instance_catalog( 'ea_faq', array( 'show_thumb' => false ) ); ?>
			</section>
		</div>
	</div>
	<?php
}
get_footer();
