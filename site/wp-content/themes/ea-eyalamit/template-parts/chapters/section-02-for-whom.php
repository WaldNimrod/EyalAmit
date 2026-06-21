<?php
/**
 * Chapters — 02 FOR WHOM (4 photo + text columns, staggered reveal).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$items = ea_chapters_rows( 'whom_items' );
$lead  = ea_chapters_field( 'whom_lead' );
?>
<section class="sec sec--alt" id="whom">
	<div class="wrap center">
		<span class="chap chap--c r"><?php echo esc_html( ea_chapters_field( 'whom_chap' ) ); ?></span>
		<h2 class="h2 r"><?php echo esc_html( ea_chapters_field( 'whom_title' ) ); ?></h2>
		<?php if ( $lead ) : ?>
			<p class="lead r" style="margin-top:14px"><?php echo esc_html( $lead ); ?></p>
		<?php endif; ?>
		<div class="whom">
			<?php
			foreach ( $items as $i => $row ) :
				$rcls = 'r' . ( $i ? ' r' . ( $i + 1 ) : '' );
				?>
				<div class="whom__i <?php echo esc_attr( $rcls ); ?>">
					<span class="whom__m">
						<?php $src = ea_chapters_resolve_img( isset( $row['image'] ) ? $row['image'] : '' ); ?>
						<?php if ( $src ) : ?>
							<img src="<?php echo esc_url( $src ); ?>" alt="" loading="lazy">
						<?php else : ?>
							<span class="ph"><span><?php esc_html_e( 'תמונה', 'ea-eyalamit' ); ?></span></span>
						<?php endif; ?>
					</span>
					<p class="whom__p"><?php echo esc_html( isset( $row['text'] ) ? $row['text'] : '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
