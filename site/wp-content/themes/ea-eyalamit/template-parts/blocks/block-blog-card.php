<?php
/**
 * Blog card partial — used inside tpl-blog-archive WP_Query loop.
 * Expects: have_posts() / the_post() already called by the caller.
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$cats = get_the_category();
$cat  = $cats ? $cats[0] : null;

// IDEA-006: strip Visual-Composer/legacy shortcodes + tags so cards never render raw [vc_row …].
// strip_shortcodes() only removes REGISTERED shortcodes; VC/Elementor are not registered on this
// site, so we also run a registration-independent pass (reusing the mu-plugin cleaner when present,
// else a self-contained regex) before trimming.
$ea_raw_excerpt   = has_excerpt() ? get_the_excerpt() : get_the_content();
$ea_clean_excerpt = strip_shortcodes( $ea_raw_excerpt );
if ( function_exists( 'ea_strip_legacy_blog_shortcodes' ) ) {
	$ea_clean_excerpt = ea_strip_legacy_blog_shortcodes( $ea_clean_excerpt );
} else {
	// Fallback: strip any remaining [shortcode …] / [/shortcode] tokens, keep inner text.
	$ea_clean_excerpt = preg_replace( '/\[([a-z_-]+)[^\]]*\](.*?)\[\/\1\]/s', '$2', $ea_clean_excerpt );
	$ea_clean_excerpt = preg_replace( '/\[[a-z_-]+[^\]]*\/?\]|\[\/[a-z_-]+\]/', '', $ea_clean_excerpt );
}
$ea_clean_excerpt = wp_strip_all_tags( $ea_clean_excerpt );
$ea_clean_excerpt = wp_trim_words( $ea_clean_excerpt, 20, '…' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ea-blog-card' ); ?>>
	<a href="<?php the_permalink(); ?>" class="ea-blog-card__link" aria-label="<?php the_title_attribute(); ?>" tabindex="-1">
		<div class="ea-blog-card__thumb">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large', [ 'loading' => 'lazy', 'alt' => esc_attr( get_the_title() ) ] ); ?>
			<?php else : ?>
				<div class="ea-blog-card__thumb-placeholder" role="img" aria-label="<?php esc_attr_e( 'תמונת רקע מעוצבת — אין תמונה ראשית לפוסט זה', 'ea-eyalamit' ); ?>"></div>
			<?php endif; ?>
		</div>
	</a>
	<div class="ea-blog-card__body">
		<?php if ( $cat ) : ?>
			<span class="ea-blog-card__cat">
				<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
			</span>
		<?php endif; ?>
		<h2 class="ea-blog-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>
		<p class="ea-blog-card__excerpt"><?php echo esc_html( $ea_clean_excerpt ); ?></p>
		<time class="ea-blog-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
			<?php echo esc_html( get_the_date() ); ?>
		</time>
	</div>
</article>
