<?php
/**
 * Chapters — Blog single post (is_singular('post')). Self-contained doc: Chapters
 * nav + phero (post title H1 + featured image) + meta / content / tags / share
 * (WhatsApp + copy-link, WP-W2-11) + related posts, then the Chapters footer.
 * wp_head/wp_footer fire → per-post SEO meta + og:image + ea-blog/ea-atoms assets
 * + chapters.css are all preserved.
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

<main id="chapters-main" class="ea-wave2-blog-single">
	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/chapters/parts/phero', null, array(
			'chap'      => implode( ' · ', wp_list_pluck( (array) get_the_category(), 'name' ) ),
			'title'     => esc_html( get_the_title() ),
			'sub'       => sprintf( /* translators: 1: author, 2: date */ esc_html__( 'מאת %1$s · %2$s', 'ea-eyalamit' ), get_the_author(), get_the_date() ),
			'media'     => has_post_thumbnail() ? (string) get_the_post_thumbnail_url( get_the_ID(), 'large' ) : '',
			'media_alt' => esc_attr( get_the_title() ),
		) );
		?>

		<section class="sec">
			<div class="wrap">
				<div class="ea-post-content"><?php the_content(); ?></div>

				<?php
				$tags = get_the_tags();
				if ( $tags ) :
					$tag_links = array_map(
						static function ( $t ) {
							return '<a href="' . esc_url( get_tag_link( $t->term_id ) ) . '">' . esc_html( $t->name ) . '</a>';
						},
						$tags
					);
					?>
				<div class="ea-post-tags">
					<span class="ea-post-tags__label"><?php esc_html_e( 'תגיות:', 'ea-eyalamit' ); ?></span>
					<?php echo implode( ' ', $tag_links ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above ?>
				</div>
				<?php endif; ?>

				<?php
				$ea_share_url = get_permalink();
				$ea_wa_href   = 'https://wa.me/?text=' . rawurlencode( get_the_title() . ' ' . $ea_share_url );
				?>
				<div class="ea-post-share">
					<span class="ea-post-share__label"><?php esc_html_e( 'שיתוף:', 'ea-eyalamit' ); ?></span>
					<a class="ea-post-share__link" href="<?php echo esc_url( $ea_wa_href ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'שיתוף ב-WhatsApp', 'ea-eyalamit' ); ?>"><span aria-hidden="true">WA</span></a>
					<button type="button" class="ea-post-share__link" data-ea-copy-link="<?php echo esc_url( $ea_share_url ); ?>" aria-label="<?php esc_attr_e( 'העתקת קישור לפוסט', 'ea-eyalamit' ); ?>"><span aria-hidden="true">↗</span></button>
				</div>
			</div>
		</section>

	<?php endwhile; ?>

	<?php
	// Related posts — 2-up, same-category with recent fallback (WP-W2-11).
	$ea_post_id  = get_the_ID();
	$ea_post_cat = get_the_category();
	$ea_rel_args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 2,
		'post__not_in'        => array( $ea_post_id ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);
	if ( $ea_post_cat ) {
		$ea_rel_args['category__in'] = wp_list_pluck( $ea_post_cat, 'term_id' );
	}
	$ea_related = new WP_Query( $ea_rel_args );
	if ( ! $ea_related->have_posts() && $ea_post_cat ) {
		unset( $ea_rel_args['category__in'] );
		$ea_related = new WP_Query( $ea_rel_args );
	}
	if ( $ea_related->have_posts() ) :
		?>
		<section class="sec sec--alt ea-related" aria-labelledby="ea-related-heading">
			<div class="wrap center">
				<h2 class="h2 r" id="ea-related-heading"><?php esc_html_e( 'פוסטים נוספים', 'ea-eyalamit' ); ?></h2>
				<div class="ea-blog-grid ea-related__grid">
					<?php
					while ( $ea_related->have_posts() ) :
						$ea_related->the_post();
						get_template_part( 'template-parts/blocks/block', 'blog-card' );
					endwhile;
					?>
				</div>
			</div>
		</section>
		<?php
		wp_reset_postdata();
	endif;
	?>
</main>

<?php
get_template_part( 'template-parts/chapters/section', 'footer' );
wp_footer();
?>
</body>
</html>
