<?php
/**
 * Template Name: מדיה / המלצות — קטלוג (M3)
 * Description: עמוד קטלוג המלצות ומדיה — מבוא + אינסטנסי CPT `ea_testimonial` לפי קטגוריה (G8); 301 מ־testimonials-media.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
while ( have_posts() ) {
	the_post();
	?>
	<div class="inside-article">
		<div class="entry-content ea-media-catalog">
			<p class="ea-media-catalog-note" role="note">
				<?php esc_html_e( 'קטלוג מדיה מאוחד — סעיף «המלצות» לפי קטגוריה ב־WP; עמוד legacy testimonials-media — טיוטה + 301 לכאן.', 'ea-eyalamit' ); ?>
			</p>
			<?php the_content(); ?>
			<section class="ea-instance-catalog-wrap" aria-label="<?php esc_attr_e( 'רשימת המלצות', 'ea-eyalamit' ); ?>">
				<?php
				$rec_term = taxonomy_exists( 'ea_testimonial_cat' ) ? get_term_by( 'slug', 'recommendations', 'ea_testimonial_cat' ) : false;
				if ( $rec_term && ! is_wp_error( $rec_term ) ) {
					echo '<h2 class="ea-media-section-title">' . esc_html( $rec_term->name ) . '</h2>';
					ea_eyalamit_render_instance_catalog(
						'ea_testimonial',
						array(
							'show_thumb' => true,
							'tax_query'  => array(
								array(
									'taxonomy' => 'ea_testimonial_cat',
									'field'    => 'term_id',
									'terms'    => array( (int) $rec_term->term_id ),
								),
							),
						)
					);
				} else {
					ea_eyalamit_render_instance_catalog( 'ea_testimonial', array( 'show_thumb' => true ) );
				}
				?>
			</section>
		</div>
	</div>
	<?php
}
get_footer();
