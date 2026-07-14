<?php
/**
 * Block: faq-list — WP-W2-02 full FAQ accordion with category filter.
 * Content source: ea_faq CPT + ea_faq_cat taxonomy (WP-CANON T2).
 *
 * Optional args (passed via get_template_part $args):
 *   ea_faq_only_category       — legacy single slug (Wave2 back-compat).
 *   ea_faq_only_categories     — array of category slugs (many-to-many OR filter).
 *   ea_faq_view_chap           — optional chap label in view-only mode.
 *   ea_faq_view_title          — optional H2 in view-only mode.
 *   ea_faq_view_id             — optional section id anchor in view-only mode.
 *
 * @package ea_eyalamit
 */
defined( 'ABSPATH' ) || exit;

// WP-CANON T2 — normalize legacy single arg + new array arg.
$ea_only_cats = array();
if ( isset( $args['ea_faq_only_categories'] ) && is_array( $args['ea_faq_only_categories'] ) ) {
	$ea_only_cats = array_values( array_filter( array_map( 'sanitize_title', $args['ea_faq_only_categories'] ) ) );
} elseif ( isset( $args['ea_faq_only_category'] ) && '' !== $args['ea_faq_only_category'] ) {
	$ea_only_cats = array( sanitize_title( (string) $args['ea_faq_only_category'] ) );
}
$ea_view_chap  = isset( $args['ea_faq_view_chap'] ) ? (string) $args['ea_faq_view_chap'] : '';
$ea_view_title = isset( $args['ea_faq_view_title'] ) ? (string) $args['ea_faq_view_title'] : '';
$ea_view_id    = isset( $args['ea_faq_view_id'] ) ? (string) $args['ea_faq_view_id'] : '';

$faq_categories = function_exists( 'ea_faq_get_categories' ) ? ea_faq_get_categories() : array();
$faq_data       = function_exists( 'ea_faq_query_items' ) ? ea_faq_query_items() : array();
?>
<?php if ( ! empty( $ea_only_cats ) ) :
	$ea_only_items = array_filter(
		$faq_data,
		static function ( $item ) use ( $ea_only_cats ) {
			return (bool) array_intersect( $ea_only_cats, $item['categories'] );
		}
	);
	?>
	<section class="ea-faq-list ea-faq-list--view-only" data-block="faq-list" data-faq-category="<?php echo esc_attr( implode( ' ', $ea_only_cats ) ); ?>"<?php echo '' !== $ea_view_id ? ' id="' . esc_attr( $ea_view_id ) . '"' : ''; ?>>
		<div class="ea-faq-list__inner">
			<?php if ( '' !== $ea_view_chap ) : ?><span class="chap chap--c r"><?php echo esc_html( $ea_view_chap ); ?></span><?php endif; ?>
			<?php if ( '' !== $ea_view_title ) : ?><h2 class="h2 r"><?php echo esc_html( $ea_view_title ); ?></h2><?php endif; ?>
			<div class="ea-faq-category">
				<?php foreach ( $ea_only_items as $item ) : ?>
					<details class="ea-faq-item ea-entrance" data-category="<?php echo esc_attr( implode( ' ', $item['categories'] ) ); ?>">
						<summary class="ea-faq-item__question"><?php echo esc_html( $item['q'] ); ?></summary>
						<div class="ea-faq-item__answer"><?php echo wp_kses_post( $item['a'] ); ?></div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php return; endif; ?>
<section class="ea-faq-list" data-block="faq-list" aria-label="<?php esc_attr_e( 'שאלות נפוצות', 'ea-eyalamit' ); ?>">
	<div class="ea-faq-list__inner">

		<?php
		// WP-W2-16-C — topic TOC source: only categories that actually have questions.
		$ea_faq_toc = array();
		foreach ( $faq_categories as $ea_toc_slug => $ea_toc_label ) {
			foreach ( $faq_data as $ea_toc_fd ) {
				if ( in_array( $ea_toc_slug, $ea_toc_fd['categories'], true ) ) {
					$ea_faq_toc[ $ea_toc_slug ] = $ea_toc_label;
					break;
				}
			}
		}
		?>
		<?php // WP-W2-16-C — sticky topic navigation (TOC): anchor jump-to-section + scroll-spy (Eyal #3). ?>
		<nav class="ea-faq-toc" aria-label="<?php esc_attr_e( 'ניווט נושאי שאלות נפוצות', 'ea-eyalamit' ); ?>" data-faq-toc>
			<span class="ea-faq-toc__label"><?php esc_html_e( 'נושאים:', 'ea-eyalamit' ); ?></span>
			<ul class="ea-faq-toc__list">
				<?php foreach ( $ea_faq_toc as $ea_toc_slug => $ea_toc_label ) : ?>
					<li class="ea-faq-toc__item">
						<a class="ea-faq-toc__link" href="#faq-topic-<?php echo esc_attr( $ea_toc_slug ); ?>" data-faq-toc-link="<?php echo esc_attr( $ea_toc_slug ); ?>"><?php echo esc_html( $ea_toc_label ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>

		<div id="faq-list">
		<?php foreach ( $faq_categories as $cat_slug => $cat_label ) :
			$cat_items = array_filter(
				$faq_data,
				static function ( $item ) use ( $cat_slug ) {
					return in_array( $cat_slug, $item['categories'], true );
				}
			);
			?>
			<div class="ea-faq-category" id="faq-topic-<?php echo esc_attr( $cat_slug ); ?>" data-category="<?php echo esc_attr( $cat_slug ); ?>"<?php echo empty( $cat_items ) ? ' hidden' : ''; ?>>
				<h2 class="ea-faq-category__heading"><?php echo esc_html( $cat_label ); ?></h2>
				<?php if ( empty( $cat_items ) ) : ?>
					<p class="ea-faq-item__answer"><?php esc_html_e( 'תוכן בהכנה — אין עדיין שאלות מפורסמות בקטגוריה זו.', 'ea-eyalamit' ); ?></p>
				<?php else : ?>
					<?php foreach ( $cat_items as $item ) : ?>
						<details
							class="ea-faq-item ea-entrance"
							data-category="<?php echo esc_attr( implode( ' ', $item['categories'] ) ); ?>"
						>
							<summary class="ea-faq-item__summary">
								<h3 class="ea-faq-item__question"><?php echo esc_html( $item['q'] ); ?></h3>
								<span class="ea-faq-item__icon" aria-hidden="true">&#9662;</span>
							</summary>
							<div class="ea-faq-item__answer">
								<?php echo wp_kses_post( $item['a'] ); ?>
							</div>
						</details>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		</div>

	</div>
</section>
