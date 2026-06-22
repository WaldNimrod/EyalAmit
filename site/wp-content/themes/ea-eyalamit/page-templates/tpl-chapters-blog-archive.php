<?php
/**
 * Chapters — Blog archive (/blog/, the posts page / is_home). Self-contained doc:
 * Chapters nav + phero + the WP-W2-06 card grid / category filter / pagination
 * (logic preserved verbatim, incl. the paged-query-var fix), inside <main>, then
 * the Chapters footer. wp_head/wp_footer fire → SEO + ea-blog/ea-atoms assets +
 * chapters.css (enqueued for blog views by chapters-routing).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$active_cat = isset( $_GET['cat'] ) ? absint( $_GET['cat'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification
$paged      = max(
	1,
	(int) get_query_var( 'paged' ),
	(int) get_query_var( 'page' ),
	isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 0
);

$query_args = array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 12,
	'paged'          => $paged,
);
if ( $active_cat ) {
	$query_args['cat'] = $active_cat;
}
$blog_query = new WP_Query( $query_args );
$blog_base  = get_post_type_archive_link( 'post' );
if ( ! $blog_base ) {
	$blog_base = home_url( '/blog/' );
}
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

<main id="chapters-main" class="ea-wave2-blog-archive">
	<?php
	get_template_part( 'template-parts/chapters/parts/phero', null, array(
		'chap'      => 'הבלוג',
		'title'     => 'בלוג',
		'sub'       => 'מאמרים, תובנות וסיפורים על נשימה, דיג׳רידו והדרך.',
		'media'     => ea_chapters_asset_url( 'assets/images/chapters/studio-mosaic.jpg' ),
		'media_alt' => 'הסטודיו בפרדס חנה',
	) );
	?>

	<section class="sec">
		<div class="wrap">
			<?php
			$categories = get_categories( array( 'hide_empty' => true ) );
			if ( $categories ) :
			?>
			<nav class="ea-blog-filter" aria-label="<?php esc_attr_e( 'סינון לפי קטגוריה', 'ea-eyalamit' ); ?>">
				<a href="<?php echo esc_url( $blog_base ); ?>" class="ea-blog-filter__item<?php echo ! $active_cat ? ' ea-blog-filter__item--active' : ''; ?>"><?php esc_html_e( 'הכל', 'ea-eyalamit' ); ?></a>
				<?php foreach ( $categories as $cat ) : ?>
				<a href="<?php echo esc_url( add_query_arg( 'cat', $cat->term_id, $blog_base ) ); ?>" class="ea-blog-filter__item<?php echo $active_cat === $cat->term_id ? ' ea-blog-filter__item--active' : ''; ?>"><?php echo esc_html( $cat->name ); ?></a>
				<?php endforeach; ?>
			</nav>
			<?php endif; ?>

			<?php if ( $blog_query->have_posts() ) : ?>
				<div class="ea-blog-grid">
					<?php
					while ( $blog_query->have_posts() ) :
						$blog_query->the_post();
						get_template_part( 'template-parts/blocks/block', 'blog-card' );
					endwhile;
					?>
				</div>

				<?php
				$pagination = paginate_links( array(
					'base'      => trailingslashit( $blog_base ) . 'page/%#%/',
					'format'    => '',
					'current'   => $paged,
					'total'     => $blog_query->max_num_pages,
					'type'      => 'array',
					'prev_text' => '&rarr;',
					'next_text' => '&larr;',
					'add_args'  => $active_cat ? array( 'cat' => $active_cat ) : false,
				) );
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
		</div>
	</section>
</main>

<?php
get_template_part( 'template-parts/chapters/section', 'footer' );
wp_footer();
?>
</body>
</html>
