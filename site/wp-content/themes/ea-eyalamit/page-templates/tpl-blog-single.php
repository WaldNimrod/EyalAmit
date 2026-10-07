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

		<div class="ea-post-featured">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large', [ 'loading' => 'eager', 'alt' => esc_attr( get_the_title() ) ] ); ?>
			<?php else : ?>
				<div class="ea-post-featured__placeholder" role="img" aria-label="<?php esc_attr_e( 'תמונת רקע מעוצבת — אין תמונה ראשית לפוסט זה', 'ea-eyalamit' ); ?>"></div>
			<?php endif; ?>
		</div>

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

		<?php
		// WP-W2-11 S3 — Share row: WhatsApp + copy-link only (no Facebook).
		$ea_share_url  = get_permalink();
		$ea_share_text = get_the_title();
		$ea_wa_href    = 'https://wa.me/?text=' . rawurlencode( $ea_share_text . ' ' . $ea_share_url );
		?>
		<div class="ea-post-share">
			<span class="ea-post-share__label"><?php esc_html_e( 'שיתוף:', 'ea-eyalamit' ); ?></span>
			<a class="ea-post-share__link" href="<?php echo esc_url( $ea_wa_href ); ?>"
			   target="_blank" rel="noopener noreferrer"
			   aria-label="<?php esc_attr_e( 'שיתוף ב-WhatsApp', 'ea-eyalamit' ); ?>">
				<span aria-hidden="true">WA</span>
			</a>
			<button type="button" class="ea-post-share__link" data-ea-copy-link="<?php echo esc_url( $ea_share_url ); ?>"
			        aria-label="<?php esc_attr_e( 'העתקת קישור לפוסט', 'ea-eyalamit' ); ?>">
				<span aria-hidden="true">↗</span>
			</button>
		</div>

	<?php endwhile; ?>
</main>

<?php
/* 4.10: the post before and the post after, by date. */
$ea_prev = get_adjacent_post( false, '', true );
$ea_next = get_adjacent_post( false, '', false );
if ( $ea_prev instanceof WP_Post || $ea_next instanceof WP_Post ) :
?>
<section class="ea-related" aria-label="<?php esc_attr_e( 'פוסטים סמוכים', 'ea-eyalamit' ); ?>">
	<div class="ea-related__grid">
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
	$ea_post_cats   = get_the_category();
	$ea_post_cat_id = $ea_post_cats ? (int) $ea_post_cats[0]->term_id : 0;
	?>
<nav class="ea-blog-filter ea-blog-filter--post" aria-label="<?php esc_attr_e( 'סינון לפי קטגוריה', 'ea-eyalamit' ); ?>">
	<a href="<?php echo esc_url( $ea_blog_base ); ?>" class="ea-blog-filter__item<?php echo ! $ea_post_cat_id ? ' ea-blog-filter__item--active' : ''; ?>"><?php esc_html_e( 'הכל', 'ea-eyalamit' ); ?></a>
	<?php foreach ( $ea_blog_cats as $ea_blog_cat ) : ?>
	<a href="<?php echo esc_url( add_query_arg( 'cat', $ea_blog_cat->term_id, $ea_blog_base ) ); ?>" class="ea-blog-filter__item<?php echo $ea_post_cat_id === (int) $ea_blog_cat->term_id ? ' ea-blog-filter__item--active' : ''; ?>"><?php echo esc_html( $ea_blog_cat->name ); ?></a>
	<?php endforeach; ?>
</nav>
	<?php
endif;

get_template_part( 'template-parts/blocks/block', 'contact-cta' );
get_footer();
