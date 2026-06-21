<?php
/**
 * Chapters — 03 SESSION. Reveal-over-image cards: the image stays a fixed size,
 * the title sits over it, and on hover/focus the detail text fades in OVER the
 * image (no card resize, no grid movement).
 *
 * @package ea_eyalamit
 */

defined( 'ABSPATH' ) || exit;

$cards = ea_chapters_rows( 'session_cards' );
$lead  = ea_chapters_field( 'session_lead' );
?>
<section class="sec sec--dark" id="session">
	<div class="wrap center">
		<span class="chap chap--c r"><?php echo esc_html( ea_chapters_field( 'session_chap' ) ); ?></span>
		<h2 class="h2 r"><?php echo esc_html( ea_chapters_field( 'session_title' ) ); ?></h2>
		<?php if ( $lead ) : ?>
			<p class="lead r" style="margin-top:14px;color:rgba(255,255,255,.82)"><?php echo esc_html( $lead ); ?></p>
		<?php endif; ?>
		<div class="reveals">
			<?php
			foreach ( $cards as $i => $row ) :
				$rcls   = 'r' . ( $i ? ' r' . ( $i + 1 ) : '' );
				$src    = ea_chapters_resolve_img( isset( $row['image'] ) ? $row['image'] : '' );
				$title  = isset( $row['title'] ) ? $row['title'] : '';
				$text   = isset( $row['text'] ) ? $row['text'] : '';
				$reveal = isset( $row['reveal'] ) ? $row['reveal'] : '';
				?>
				<div class="rcard <?php echo esc_attr( $rcls ); ?>" tabindex="0" aria-label="<?php echo esc_attr( $title ); ?>">
					<?php if ( $src ) : ?>
						<img src="<?php echo esc_url( $src ); ?>" alt="" loading="lazy">
					<?php else : ?>
						<span class="ph ph--d" style="position:absolute;inset:0"><span><?php esc_html_e( 'תמונה', 'ea-eyalamit' ); ?></span></span>
					<?php endif; ?>
					<span class="rcard__sc" aria-hidden="true"></span>
					<span class="rcard__hint" aria-hidden="true">+</span>
					<div class="rcard__b">
						<h3 class="rcard__t"><?php echo esc_html( $title ); ?></h3>
						<div class="rcard__more">
							<?php if ( $text ) : ?><p><?php echo esc_html( $text ); ?></p><?php endif; ?>
							<?php if ( $reveal ) : ?><p><?php echo esc_html( $reveal ); ?></p><?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
