<?php
/**
 * Chapters — Blog single post (is_singular('post')). Self-contained doc: Chapters
 * nav + phero (post title H1 + featured image) + meta / content / tags / share
 * (WhatsApp + copy-link, WP-W2-11) + related posts, then the Chapters footer.
 * wp_head/wp_footer fire → per-post SEO meta + og:image + ea-blog/ea-atoms assets
 * + chapters.css are all preserved.
 *
 * New posts with inc/data/blog/{slug}.json render JSON rows (see inc/ea-blog-json.php).
 * Staging dummy: ?ea_blog_dummy={slug} when JSON has dummy:true.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$ea_json_data   = function_exists( 'ea_blog_json_active_data' ) ? ea_blog_json_active_data() : null;
$ea_json_dummy  = function_exists( 'ea_blog_json_is_dummy_preview' ) && ea_blog_json_is_dummy_preview();
$ea_share_url   = $ea_json_dummy ? home_url( '/' ) : ( is_singular( 'post' ) ? get_permalink() : home_url( '/' ) );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<main id="main" class="chapters-main" tabindex="-1">
	<?php
	if ( $ea_json_data ) {
		get_template_part( 'template-parts/chapters/parts/phero', null, ea_blog_json_phero_args( $ea_json_data ) );

		/* Round C (2026-09-24), team_00: breadcrumb in the classic position —
		   right-aligned, directly after the hero, before the main content. */
		if ( function_exists( 'ea_breadcrumbs_render' ) ) {
			ea_breadcrumbs_render();
		}

		ea_blog_json_render_rows( $ea_json_data );

		if ( ! $ea_json_dummy ) {
			while ( have_posts() ) :
				the_post();
				$tags = get_the_tags();
				if ( $tags ) :
					$tag_links = array_map(
						static function ( $t ) {
							return '<a href="' . esc_url( get_tag_link( $t->term_id ) ) . '">' . esc_html( $t->name ) . '</a>';
						},
						$tags
					);
					?>
		<section class="sec">
			<div class="wrap">
				<div class="ea-post-tags">
					<span class="ea-post-tags__label"><?php esc_html_e( 'תגיות:', 'ea-eyalamit' ); ?></span>
					<?php echo implode( ' ', $tag_links ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above ?>
				</div>
				<?php $ea_share_url = get_permalink(); ?>
				<div class="ea-post-share">
					<span class="ea-post-share__label"><?php esc_html_e( 'שיתוף:', 'ea-eyalamit' ); ?></span>
					<button type="button" class="ea-post-share__link" data-ea-copy-link="<?php echo esc_url( $ea_share_url ); ?>" aria-label="<?php esc_attr_e( 'העתקת קישור לפוסט', 'ea-eyalamit' ); ?>"><span aria-hidden="true">↗</span></button>
				</div>
			</div>
		</section>
					<?php
				else :
					$ea_share_url = get_permalink();
					?>
		<section class="sec">
			<div class="wrap">
				<div class="ea-post-share">
					<span class="ea-post-share__label"><?php esc_html_e( 'שיתוף:', 'ea-eyalamit' ); ?></span>
					<button type="button" class="ea-post-share__link" data-ea-copy-link="<?php echo esc_url( $ea_share_url ); ?>" aria-label="<?php esc_attr_e( 'העתקת קישור לפוסט', 'ea-eyalamit' ); ?>"><span aria-hidden="true">↗</span></button>
				</div>
			</div>
		</section>
					<?php
				endif;
			endwhile;
		}
	} else {
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/chapters/parts/phero', null, array(
				'chap'      => implode( ' · ', wp_list_pluck( (array) get_the_category(), 'name' ) ),
				'title'     => esc_html( get_the_title() ),
				'sub'       => sprintf( /* translators: 1: author, 2: date */ esc_html__( 'מאת %1$s · %2$s', 'ea-eyalamit' ), get_the_author(), get_the_date() ),
				'media'     => has_post_thumbnail() ? (string) get_the_post_thumbnail_url( get_the_ID(), 'large' ) : '',
				'media_alt' => esc_attr( get_the_title() ),
			) );

			/* Round C (2026-09-24), team_00: breadcrumb in the classic position —
			   right-aligned, directly after the hero, before the main content. */
			if ( function_exists( 'ea_breadcrumbs_render' ) ) {
				ea_breadcrumbs_render();
			}
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

				<?php $ea_share_url = get_permalink(); ?>
				<div class="ea-post-share">
					<span class="ea-post-share__label"><?php esc_html_e( 'שיתוף:', 'ea-eyalamit' ); ?></span>
					<button type="button" class="ea-post-share__link" data-ea-copy-link="<?php echo esc_url( $ea_share_url ); ?>" aria-label="<?php esc_attr_e( 'העתקת קישור לפוסט', 'ea-eyalamit' ); ?>"><span aria-hidden="true">↗</span></button>
				</div>
			</div>
		</section>

		<?php endwhile; ?>
	<?php } ?>

	<?php
	/* 4.10: the post before and the post after, by date — not two fixed cards. */
	$ea_prev = null;
	$ea_next = null;
	if ( ! $ea_json_dummy && is_singular( 'post' ) ) {
		$ea_prev = get_adjacent_post( false, '', true );
		$ea_next = get_adjacent_post( false, '', false );
	}
	if ( $ea_prev instanceof WP_Post || $ea_next instanceof WP_Post ) :
		?>
		<section class="sec sec--alt ea-related" aria-label="<?php esc_attr_e( 'פוסטים סמוכים', 'ea-eyalamit' ); ?>">
			<div class="wrap">
				<div class="ea-blog-grid ea-related__grid">
					<?php
					foreach ( array(
						array( $ea_prev, 'הפוסט שלפני' ),
						array( $ea_next, 'הפוסט שאחרי' ),
					) as $ea_adj ) :
						if ( ! ( $ea_adj[0] instanceof WP_Post ) ) {
							continue;
						}
						$GLOBALS['post'] = $ea_adj[0]; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						setup_postdata( $ea_adj[0] );
						?>
						<div class="ea-adj">
							<p class="ea-adj__label"><?php echo esc_html( $ea_adj[1] ); ?></p>
							<?php get_template_part( 'template-parts/blocks/block', 'blog-card' ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
		wp_reset_postdata();
	endif;

	$ea_blog_base = get_post_type_archive_link( 'post' );
	if ( ! $ea_blog_base ) {
		$ea_blog_base = home_url( '/blog/' );
	}
	$ea_blog_cats = get_categories( array( 'hide_empty' => true ) );
	if ( $ea_blog_cats ) :
		$ea_post_cat_id = 0;
		if ( ! $ea_json_dummy && is_singular( 'post' ) ) {
			$ea_post_cats = get_the_category();
			if ( $ea_post_cats ) {
				$ea_post_cat_id = (int) $ea_post_cats[0]->term_id;
			}
		}
		?>
		<nav class="sec" aria-label="<?php esc_attr_e( 'סינון לפי קטגוריה', 'ea-eyalamit' ); ?>">
			<div class="wrap">
				<div class="ea-blog-filter ea-blog-filter--post">
				<a href="<?php echo esc_url( $ea_blog_base ); ?>" class="ea-blog-filter__item<?php echo ! $ea_post_cat_id ? ' ea-blog-filter__item--active' : ''; ?>"><?php esc_html_e( 'הכל', 'ea-eyalamit' ); ?></a>
				<?php foreach ( $ea_blog_cats as $ea_blog_cat ) : ?>
				<a href="<?php echo esc_url( add_query_arg( 'cat', $ea_blog_cat->term_id, $ea_blog_base ) ); ?>" class="ea-blog-filter__item<?php echo $ea_post_cat_id === (int) $ea_blog_cat->term_id ? ' ea-blog-filter__item--active' : ''; ?>"><?php echo esc_html( $ea_blog_cat->name ); ?></a>
				<?php endforeach; ?>
				</div>
			</div>
		</nav>
		<?php
	endif;
	?>
</main>

<?php
wp_footer();
?>
</body>
</html>
