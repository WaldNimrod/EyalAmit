<?php
/**
 * The ONE mobile navigation drawer — server-rendered <dialog>, S007 M-12.
 *
 * @param array $args {
 *     @type array  $items      Nav tree: array of array('key','label','href'|null,'children'=>array(array('label','href','external'=>bool))).
 *     @type array  $foot_links Secondary footer links: array(array('href','label')).
 * }
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$items      = isset( $args['items'] ) ? $args['items'] : array();
$foot_links = isset( $args['foot_links'] ) ? $args['foot_links'] : array();
$current    = isset( $args['active'] ) ? $args['active'] : '';
$ea_he      = function_exists( 'ea_open_round_he_attr' ) ? ea_open_round_he_attr() : '';
?>
<dialog class="ea-nd" id="ea-nav-drawer"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput — static lang/dir attr ?> aria-label="<?php esc_attr_e( 'תפריט ראשי', 'ea-eyalamit' ); ?>">
	<div class="ea-nd__head">
		<a class="ea-nd__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php esc_html_e( 'המרכז לטיפול בדיג׳רידו', 'ea-eyalamit' ); ?></a>
		<button class="ea-nd__close" type="button" aria-label="<?php esc_attr_e( 'סגירת תפריט', 'ea-eyalamit' ); ?>">&times;</button>
	</div>

	<ul class="ea-nd__list" role="list">
		<?php foreach ( $items as $item ) : ?>
			<?php $children = isset( $item['children'] ) ? $item['children'] : array(); ?>
			<?php if ( $children ) : ?>
				<?php
				$acc_id   = 'ea-nd-acc-' . sanitize_html_class( $item['key'] );
				$is_active = ( $item['key'] === $current );
				if ( ! $is_active ) {
					foreach ( $children as $child ) {
						if ( ! empty( $child['key'] ) && $child['key'] === $current ) {
							$is_active = true;
							break;
						}
					}
				}
				?>
	<li class="ea-nd__item">
		<button class="ea-nd__acc-btn" type="button"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?> aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $acc_id ); ?>">
			<span><?php echo esc_html( $item['label'] ); ?></span>
			<span class="ea-nd__caret" aria-hidden="true">⌄</span>
		</button>
		<div class="ea-nd__acc-panel" id="<?php echo esc_attr( $acc_id ); ?>">
			<div class="ea-nd__acc-panel-in">
				<ul class="ea-nd__sublist" role="list">
					<?php if ( ! empty( $item['href'] ) ) : ?>
					<li>
						<a class="ea-nd__sublink" href="<?php echo esc_url( $item['href'] ); ?>"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
							<?php
							echo esc_html(
								sprintf(
									/* translators: %s: parent menu label. */
									__( '%s — עמוד ראשי', 'ea-eyalamit' ),
									$item['label']
								)
							);
							?>
						</a>
					</li>
					<?php endif; ?>
					<?php foreach ( $children as $child ) : ?>
					<li>
						<a class="ea-nd__sublink" href="<?php echo esc_url( $child['href'] ); ?>"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo ! empty( $child['key'] ) && $child['key'] === $current ? ' aria-current="page"' : ''; ?><?php echo ! empty( $child['external'] ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
							<span><?php echo esc_html( $child['label'] ); ?></span>
							<?php if ( ! empty( $child['external'] ) ) : ?>
							<span class="ea-nd__ext"><?php esc_html_e( 'חיצוני ↗', 'ea-eyalamit' ); ?></span>
							<?php endif; ?>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</li>
			<?php else : ?>
	<li class="ea-nd__item">
		<a class="ea-nd__link" href="<?php echo esc_url( $item['href'] ); ?>"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?><?php echo $item['key'] === $current ? ' aria-current="page"' : ''; ?>>
			<span><?php echo esc_html( $item['label'] ); ?></span>
		</a>
	</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>

	<div class="ea-nd__foot">
		<div class="ea-nd__foot-utils">
			<a class="ea-nd__pill" href="<?php echo esc_url( home_url( '/en/' ) ); ?>" lang="en" aria-label="English — switch to English">EN</a>
		</div>
		<div class="ea-nd__foot-links">
			<?php foreach ( $foot_links as $fl ) : ?>
			<a href="<?php echo esc_url( $fl['href'] ); ?>"<?php echo $ea_he; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $fl['label'] ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</dialog>
