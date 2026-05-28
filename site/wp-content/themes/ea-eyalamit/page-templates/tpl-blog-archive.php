<?php
/**
 * Template Name: tpl-blog-archive (Wave2)
 * D-14 §5 tpl-blog-archive — blog card grid, category filter, pagination.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$active_cat = isset( $_GET['cat'] ) ? absint( $_GET['cat'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification
$paged      = isset( $_GET['paged'] ) ? max( 1, absint( $_GET['paged'] ) ) : 1;

$query_args = [
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 12,
	'paged'          => $paged,
];
if ( $active_cat ) {
	$query_args['cat'] = $active_cat;
}

$blog_query = new WP_Query( $query_args );

get_header();
get_template_part( 'template-parts/blocks/block', 'topnav' );
?>
<main id="main" class="ea-wave2-blog-archive">

	<h1 class="ea-page-title"><?php esc_html_e( 'בלוג', 'ea-eyalamit' ); ?></h1>

	<?php
	$categories = get_categories( [ 'hide_empty' => true ] );
	if ( $categories ) :
	?>
	<nav class="ea-blog-filter" aria-label="<?php esc_attr_e( 'סינון לפי קטגוריה', 'ea-eyalamit' ); ?>">
		<a href="<?php echo esc_url( get_permalink() ); ?>"
		   class="ea-blog-filter__item<?php echo ! $active_cat ? ' ea-blog-filter__item--active' : ''; ?>">
			<?php esc_html_e( 'הכל', 'ea-eyalamit' ); ?>
		</a>
		<?php foreach ( $categories as $cat ) : ?>
		<a href="<?php echo esc_url( add_query_arg( 'cat', $cat->term_id, get_permalink() ) ); ?>"
		   class="ea-blog-filter__item<?php echo $active_cat === $cat->term_id ? ' ea-blog-filter__item--active' : ''; ?>">
			<?php echo esc_html( $cat->name ); ?>
		</a>
		<?php endforeach; ?>
	</nav>
	<?php endif; ?>

	<?php if ( $blog_query->have_posts() ) : ?>

		<div class="ea-blog-grid">
			<?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
				<?php get_template_part( 'template-parts/blocks/block', 'blog-card' ); ?>
			<?php endwhile; ?>
		</div>

		<?php
		$pagination = paginate_links( [
			'base'      => add_query_arg( 'paged', '%#%', get_permalink() ),
			'format'    => '',
			'current'   => $paged,
			'total'     => $blog_query->max_num_pages,
			'type'      => 'array',
			'prev_text' => '&rarr;',
			'next_text' => '&larr;',
			'add_args'  => $active_cat ? [ 'cat' => $active_cat ] : false,
		] );
		if ( $pagination ) :
		?>
		<nav class="ea-blog-pagination" aria-label="<?php esc_attr_e( 'ניווט עמודים', 'ea-eyalamit' ); ?>">
			<?php echo implode( "\n", $pagination ); // phpcs:ignore WordPress.Security.EscapeOutput -- paginate_links returns safe HTML ?>
		</nav>
		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

	<?php else : ?>
		<p class="ea-blog-empty"><?php esc_html_e( 'אין פוסטים בקטגוריה זו.', 'ea-eyalamit' ); ?></p>
	<?php endif; ?>

</main>
<?php
get_template_part( 'template-parts/blocks/block', 'footer-social' );
get_footer();
