<?php
/**
 * Template Name: גלריות — קטלוג (M3)
 * Description: עמוד קטלוג גלריות — מבוא + אינסטנסי CPT `ea_gallery` (רשת/כרטיסים; תמונות לפי נוהל Drive + תקרת 150KB).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
while ( have_posts() ) {
	the_post();
	?>
	<div class="inside-article">
		<div class="entry-content ea-galleries-catalog">
			<p class="ea-galleries-catalog-note" role="note">
				<?php esc_html_e( 'גלריות — אכלוס מול מלאי legacy; ללא קבצי upload «מתים»; תקרת 150KB למחיצה. מפרט: _communication/team_10/M3-GALLERY-MIGRATION-SPEC-TEAM10-2026-04-01.md.', 'ea-eyalamit' ); ?>
			</p>
			<?php the_content(); ?>
			<section class="ea-instance-catalog-wrap" aria-label="<?php esc_attr_e( 'רשימת גלריות', 'ea-eyalamit' ); ?>">
				<?php ea_eyalamit_render_instance_catalog( 'ea_gallery', array( 'show_thumb' => true ) ); ?>
			</section>
		</div>
	</div>
	<?php
}
get_footer();
