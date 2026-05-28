<?php
/**
 * Template Name: tpl-blog-single (Wave2)
 * D-14 §5 tpl-blog-single — post content, meta, featured image, end CTA.
 *
 * Note: this template is assigned to individual posts via the template_include
 * hook in functions.php (or directly in WP admin for the post type). On single
 * posts the standard WP loop is used — no secondary WP_Query needed.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-blog-single">
	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( has_post_thumbnail() ) : ?>
		<div class="ea-post-featured">
			<?php the_post_thumbnail( 'large', [ 'loading' => 'eager', 'alt' => esc_attr( get_the_title() ) ] ); ?>
		</div>
		<?php endif; ?>

		<h1 class="ea-page-title"><?php the_title(); ?></h1>

		<div class="ea-post-meta">
			<span class="ea-post-meta__author">
				<?php
				printf(
					/* translators: %s: author display name */
					esc_html__( 'מאת: %s', 'ea-eyalamit' ),
					esc_html( get_the_author() )
				);
				?>
			</span>
			<time class="ea-post-meta__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date() ); ?>
			</time>
			<?php
			$cats = get_the_category();
			if ( $cats ) :
				$cat_links = array_map( function( $c ) {
					return '<a href="' . esc_url( get_category_link( $c->term_id ) ) . '">' . esc_html( $c->name ) . '</a>';
				}, $cats );
			?>
			<span class="ea-post-meta__cats">
				<?php echo implode( ', ', $cat_links ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above ?>
			</span>
			<?php endif; ?>
		</div>

		<div class="ea-post-content">
			<?php the_content(); ?>
		</div>

		<?php
		$tags = get_the_tags();
		if ( $tags ) :
			$tag_links = array_map( function( $t ) {
				return '<a href="' . esc_url( get_tag_link( $t->term_id ) ) . '">' . esc_html( $t->name ) . '</a>';
			}, $tags );
		?>
		<div class="ea-post-tags">
			<span class="ea-post-tags__label"><?php esc_html_e( 'תגיות:', 'ea-eyalamit' ); ?></span>
			<?php echo implode( ' ', $tag_links ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above ?>
		</div>
		<?php endif; ?>

	<?php endwhile; ?>
</main>
<?php
get_template_part( 'template-parts/blocks/block', 'contact-cta' );
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
