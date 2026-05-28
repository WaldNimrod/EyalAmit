<?php
/**
 * Template Name: tpl-contact (Wave2)
 * D-14 §5 — CF7 + WhatsApp A/B variants.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-contact">
	<section class="ea-contact-page-intro" aria-label="<?php esc_attr_e( 'כותרת צור קשר', 'ea-eyalamit' ); ?>">
		<div class="ea-contact-page-intro__inner ea-entrance">
			<?php the_title( '<h1 class="ea-page-title">', '</h1>' ); ?>
			<p class="ea-contact-page-intro__sub"><?php esc_html_e( 'ניתן ליצור קשר לתיאום שיחת היכרות, שאלות כלליות או כל פנייה אחרת.', 'ea-eyalamit' ); ?></p>
		</div>
	</section>
	<section class="ea-contact-page-form" aria-label="<?php esc_attr_e( 'טופס צור קשר', 'ea-eyalamit' ); ?>">
		<?php ea_wave2_render_contact_form(); ?>
	</section>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
