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
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ea-blog-card' ); ?>>
	<a href="<?php the_permalink(); ?>" class="ea-blog-card__link" aria-label="<?php the_title_attribute(); ?>" tabindex="-1">
		<div class="ea-blog-card__thumb">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large', [ 'loading' => 'lazy', 'alt' => esc_attr( get_the_title() ) ] ); ?>
			<?php else : ?>
				<div class="ea-blog-card__thumb-placeholder" aria-hidden="true"></div>
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
		<p class="ea-blog-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '…' ) ); ?></p>
		<time class="ea-blog-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
			<?php echo esc_html( get_the_date() ); ?>
		</time>
	</div>
</article>
